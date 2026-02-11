<?php
/**
 * Integración de Cursos con Redes Sociales
 * Hook que dispara publicación automática cuando se crea un curso
 * 
 * @package Mongruas
 */

// Cargar el sistema de automatización
require_once get_template_directory() . '/inc/social-media-automation.php';

/**
 * Hook: Cuando se crea un curso nuevo
 */
add_action('mongruas_course_created', 'mongruas_auto_publish_course', 10, 1);

function mongruas_auto_publish_course($course_id) {
    global $social_media_automation;
    
    // Verificar si la publicación automática está activada
    $config = get_option('mongruas_instagram_config', array());
    
    if (empty($config['auto_publish'])) {
        return; // No publicar automáticamente
    }
    
    // Crear job para Instagram
    $job_id = $social_media_automation->create_job($course_id, 'instagram');
    
    if ($job_id) {
        // Log de éxito
        error_log("✅ Job de Instagram creado para curso #{$course_id} - Job ID: {$job_id}");
    } else {
        // Log de error
        error_log("❌ Error al crear job de Instagram para curso #{$course_id}");
    }
}

/**
 * Modificar la función de creación de cursos para disparar el hook
 */
add_action('wp_ajax_create_course', 'mongruas_create_course_with_social', 1);
add_action('wp_ajax_nopriv_create_course', 'mongruas_create_course_with_social', 1);

function mongruas_create_course_with_social() {
    // Esta función intercepta la creación de cursos
    // y dispara el hook después de guardar en DB
    
    // Verificar nonce y permisos
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'mongruas-panel-nonce')) {
        return;
    }
    
    if (!current_user_can('administrator')) {
        return;
    }
    
    global $wpdb;
    
    // Obtener datos del curso
    $name = sanitize_text_field($_POST['name']);
    $description = sanitize_textarea_field($_POST['description']);
    $start_date = sanitize_text_field($_POST['start_date']);
    $end_date = sanitize_text_field($_POST['end_date']);
    $price = floatval($_POST['price']);
    $max_students = intval($_POST['max_students']);
    $image_url = esc_url_raw($_POST['image_url']);
    
    // Insertar curso en la base de datos
    $result = $wpdb->insert(
        $wpdb->prefix . 'courses',
        array(
            'name' => $name,
            'description' => $description,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'price' => $price,
            'max_students' => $max_students,
            'image_url' => $image_url,
            'status' => 'active',
            'created_at' => current_time('mysql')
        ),
        array('%s', '%s', '%s', '%s', '%f', '%d', '%s', '%s', '%s')
    );
    
    if ($result) {
        $course_id = $wpdb->insert_id;
        
        // 🔥 DISPARAR HOOK PARA PUBLICACIÓN EN REDES SOCIALES
        do_action('mongruas_course_created', $course_id);
        
        wp_send_json_success(array(
            'message' => 'Curso creado correctamente',
            'course_id' => $course_id,
            'social_media_queued' => true
        ));
    } else {
        wp_send_json_error(array(
            'message' => 'Error al crear el curso'
        ));
    }
}

/**
 * Función manual para publicar un curso existente
 */
add_action('wp_ajax_publish_course_to_social', 'mongruas_publish_course_to_social');

function mongruas_publish_course_to_social() {
    // Verificar permisos
    if (!current_user_can('administrator')) {
        wp_send_json_error(array('message' => 'Sin permisos'));
    }
    
    $course_id = intval($_POST['course_id']);
    $platform = sanitize_text_field($_POST['platform']);
    
    global $social_media_automation;
    
    $job_id = $social_media_automation->create_job($course_id, $platform);
    
    if ($job_id) {
        wp_send_json_success(array(
            'message' => 'Publicación programada correctamente',
            'job_id' => $job_id
        ));
    } else {
        wp_send_json_error(array(
            'message' => 'Error al programar la publicación'
        ));
    }
}

/**
 * Endpoint para procesar jobs manualmente
 */
add_action('wp_ajax_process_social_jobs_now', 'mongruas_process_social_jobs_now');

function mongruas_process_social_jobs_now() {
    // Verificar permisos
    if (!current_user_can('administrator')) {
        wp_send_json_error(array('message' => 'Sin permisos'));
    }
    
    global $social_media_automation;
    
    $processed = $social_media_automation->process_jobs();
    
    wp_send_json_success(array(
        'message' => "Se procesaron {$processed} jobs",
        'processed' => $processed
    ));
}

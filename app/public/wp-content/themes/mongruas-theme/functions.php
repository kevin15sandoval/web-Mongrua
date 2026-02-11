<?php
/**
 * Formación y Enseñanza Mogruas Theme Functions
 *
 * @package Mongruas
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define theme constants
define('MONGRUAS_VERSION', '1.0.0');
define('MONGRUAS_THEME_DIR', get_template_directory());
define('MONGRUAS_THEME_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function mongruas_theme_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'mongruas'),
        'footer'  => __('Footer Menu', 'mongruas'),
    ));
    
    // Add image sizes
    add_image_size('mongruas-hero', 1920, 1080, true);
    add_image_size('mongruas-course', 600, 400, true);
    add_image_size('mongruas-testimonial', 150, 150, true);
    add_image_size('mongruas-logo', 200, 100, false);
}
add_action('after_setup_theme', 'mongruas_theme_setup');

/**
 * Enqueue Scripts and Styles
 */
function mongruas_enqueue_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style(
        'mongruas-main-style',
        MONGRUAS_THEME_URI . '/assets/css/main.css',
        array(),
        MONGRUAS_VERSION
    );
    
    // Enqueue responsive stylesheet
    wp_enqueue_style(
        'mongruas-responsive-style',
        MONGRUAS_THEME_URI . '/assets/css/responsive.css',
        array('mongruas-main-style'),
        MONGRUAS_VERSION
    );
    
    // Enqueue compact stylesheet (reduce espacios y tamaños)
    wp_enqueue_style(
        'mongruas-compact-style',
        MONGRUAS_THEME_URI . '/assets/css/compact.css',
        array('mongruas-main-style', 'mongruas-responsive-style'),
        MONGRUAS_VERSION
    );
    
    // Enqueue contact page stylesheet (solo en página de contacto)
    if (is_page_template('page-templates/page-contacto.php')) {
        wp_enqueue_style(
            'mongruas-contact-page-style',
            MONGRUAS_THEME_URI . '/assets/css/contact-page.css',
            array('mongruas-main-style'),
            MONGRUAS_VERSION
        );
    }
    
    // Enqueue upcoming courses stylesheet (solo en página de cursos)
    if (is_page_template('page-templates/page-cursos.php') || is_page('anuncios')) {
        wp_enqueue_style(
            'mongruas-upcoming-courses-style',
            MONGRUAS_THEME_URI . '/assets/css/upcoming-courses.css',
            array('mongruas-main-style'),
            MONGRUAS_VERSION
        );
        
        // Enqueue upcoming courses JavaScript
        wp_enqueue_script(
            'mongruas-upcoming-courses-script',
            MONGRUAS_THEME_URI . '/assets/js/upcoming-courses.js',
            array('jquery'),
            MONGRUAS_VERSION,
            true
        );
    }
    
    // Enqueue main JavaScript
    wp_enqueue_script(
        'mongruas-main-script',
        MONGRUAS_THEME_URI . '/assets/js/main.js',
        array('jquery'),
        MONGRUAS_VERSION,
        true
    );
    
    // Carrusel Fix - Forzar 3 columnas
    wp_enqueue_script(
        'mongruas-carrusel-fix',
        MONGRUAS_THEME_URI . '/assets/js/carrusel-fix.js',
        array('jquery'),
        MONGRUAS_VERSION,
        true
    );
    
    // Enqueue form validation JavaScript
    wp_enqueue_script(
        'mongruas-form-validation',
        MONGRUAS_THEME_URI . '/assets/js/form-validation.js',
        array('jquery', 'mongruas-main-script'),
        MONGRUAS_VERSION,
        true
    );
    
    // Enqueue contact form handler JavaScript
    wp_enqueue_script(
        'mongruas-contact-form-handler',
        MONGRUAS_THEME_URI . '/assets/js/contact-form-handler.js',
        array('jquery'),
        MONGRUAS_VERSION,
        true
    );
    
    // Localize script for AJAX
    wp_localize_script('mongruas-main-script', 'mongruasAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('mongruas-nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'mongruas_enqueue_scripts');

/**
 * Include required files
 */
require_once MONGRUAS_THEME_DIR . '/inc/custom-post-types.php';
require_once MONGRUAS_THEME_DIR . '/inc/acf-fields.php';
require_once MONGRUAS_THEME_DIR . '/inc/analytics.php';
require_once MONGRUAS_THEME_DIR . '/inc/security-config.php';
require_once MONGRUAS_THEME_DIR . '/inc/course-management-panel.php';
require_once MONGRUAS_THEME_DIR . '/inc/course-social-integration.php'; // Sistema de publicación automática en Instagram

// Include tests in development
if (defined('WP_DEBUG') && WP_DEBUG) {
    require_once MONGRUAS_THEME_DIR . '/tests/test-course-panel.php';
}

/**
 * ACF Options Page
 */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => __('Mogruas Settings', 'mongruas'),
        'menu_title' => __('Theme Settings', 'mongruas'),
        'menu_slug'  => 'mongruas-settings',
        'capability' => 'edit_posts',
        'icon_url'   => 'dashicons-admin-generic',
        'redirect'   => false
    ));
}

/**
 * Disable WordPress admin bar for non-admins
 */
if (!current_user_can('administrator') && !is_admin()) {
    show_admin_bar(false);
}


/**
 * Handle Contact Form Submission
 */
function mongruas_handle_contact_form() {
    // Verify nonce
    if (!isset($_POST['contact_form_nonce']) || !wp_verify_nonce($_POST['contact_form_nonce'], 'mongruas_contact_form')) {
        wp_send_json_error(array('message' => 'Security check failed'));
        return;
    }

    // Sanitize and validate inputs
    $name = sanitize_text_field($_POST['contact_name']);
    $email = sanitize_email($_POST['contact_email']);
    $phone = sanitize_text_field($_POST['contact_phone']);
    $consultation_type = sanitize_text_field($_POST['consultation_type']);
    $company = isset($_POST['contact_company']) ? sanitize_text_field($_POST['contact_company']) : '';
    $message = sanitize_textarea_field($_POST['contact_message']);

    // Validate required fields
    if (empty($name) || empty($email) || empty($phone) || empty($consultation_type)) {
        wp_send_json_error(array('message' => 'Please fill all required fields'));
        return;
    }

    // Validate email
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Invalid email address'));
        return;
    }

    // Prepare email - PRUEBAS: Enviar a Kevin (luego cambiar a irenesanchez@mogruasformacion.com)
    $to = 'kevin15sandoval@gmail.com';
    $subject = 'Nueva solicitud de información - ' . get_bloginfo('name');
    
    $email_message = "Nueva solicitud de información:\n\n";
    $email_message .= "Nombre: $name\n";
    $email_message .= "Email: $email\n";
    $email_message .= "Teléfono: $phone\n";
    $email_message .= "Tipo de consulta: $consultation_type\n";
    if (!empty($company)) {
        $email_message .= "Empresa: $company\n";
    }
    if (!empty($message)) {
        $email_message .= "\nMensaje:\n$message\n";
    }

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <noreply@mogruasformacion.com>',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );

    // Send email
    $sent = wp_mail($to, $subject, $email_message, $headers);
    
    // Add to MailPoet if enabled
    $mailpoet_result = false;
    if (get_option('mongruas_mailpoet_activo') && class_exists('\MailPoet\API\API')) {
        $lista_id = get_option('mongruas_mailpoet_lista');
        if ($lista_id) {
            try {
                $mailpoet_api = \MailPoet\API\API::MP('v1');
                $subscriber = $mailpoet_api->addSubscriber([
                    'email' => $email,
                    'first_name' => $name,
                ], [$lista_id]);
                $mailpoet_result = true;
            } catch (Exception $e) {
                error_log('MailPoet error: ' . $e->getMessage());
            }
        }
    }

    // Guardar en CRM si marcó "Recibir notificaciones"
    $crm_result = false;
    if (isset($_POST['receive_notifications']) && $_POST['receive_notifications'] == '1') {
        global $wpdb;
        $table_clientes = $wpdb->prefix . 'mongruas_clientes';
        
        // Verificar si el email ya existe
        $existe = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM $table_clientes WHERE email = %s",
            $email
        ));
        
        if (!$existe) {
            // Insertar nuevo contacto en el CRM
            $resultado_crm = $wpdb->insert(
                $table_clientes,
                array(
                    'nombre' => $name,
                    'email' => $email,
                    'telefono' => $phone,
                    'empresa' => $company,
                    'sector' => $consultation_type,
                    'lista' => 'Leads Web',
                    'origen' => 'Formulario Web',
                    'estado' => 'activo',
                    'notas' => $message,
                    'interes' => $consultation_type,
                    'ultima_actividad' => current_time('mysql')
                )
            );
            
            if ($resultado_crm) {
                $crm_result = true;
                error_log('Contacto guardado en CRM: ' . $email);
            }
        } else {
            // Actualizar contacto existente
            $wpdb->update(
                $table_clientes,
                array(
                    'ultima_actividad' => current_time('mysql'),
                    'notas' => $message
                ),
                array('email' => $email)
            );
            $crm_result = true;
        }
    }

    if ($sent) {
        $response_message = 'Form submitted successfully';
        if ($mailpoet_result) {
            $response_message .= ' and added to newsletter list';
        }
        if ($crm_result) {
            $response_message .= ' and saved to CRM';
        }
        wp_send_json_success(array('message' => $response_message));
    } else {
        wp_send_json_error(array('message' => 'Failed to send email'));
    }
}
add_action('wp_ajax_mongruas_submit_form', 'mongruas_handle_contact_form');
add_action('wp_ajax_nopriv_mongruas_submit_form', 'mongruas_handle_contact_form');

// SISTEMA DE CARRUSELES DINÁMICOS
require_once get_template_directory() . '/inc/carruseles-dinamicos.php';

// CARGAR ESTILOS Y SCRIPTS DE CARRUSELES DINÁMICOS
function mongruas_enqueue_carousel_assets() {
    wp_enqueue_style('mongruas-carruseles-dinamicos', get_template_directory_uri() . '/assets/css/carruseles-dinamicos.css', array(), '1.0.0');
    
    // Cargar en páginas específicas
    if (is_front_page() || is_page_template('page-templates/page-cursos.php') || is_page('anuncios')) {
        wp_enqueue_script('mongruas-carruseles-dinamicos', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
    }
}
add_action('wp_enqueue_scripts', 'mongruas_enqueue_carousel_assets');

// AGREGAR PÁGINA DE OPCIONES PARA CARRUSELES
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Configuración de Carruseles',
        'menu_title' => 'Carruseles',
        'menu_slug' => 'carruseles-config',
        'capability' => 'edit_posts',
        'icon_url' => 'dashicons-images-alt2',
        'position' => 30,
    ));
}

// FUNCIÓN HELPER PARA MOSTRAR CARRUSELES EN TEMPLATES
function mongruas_show_photo_carousel($page_id = null) {
    echo mongruas_display_photo_carousel($page_id);
}

function mongruas_show_courses_carousel($page_id = null) {
    echo mongruas_display_courses_carousel($page_id);
}

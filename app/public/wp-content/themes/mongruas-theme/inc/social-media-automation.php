<?php
/**
 * Sistema de Automatización de Redes Sociales
 * Publica automáticamente en Instagram cuando se crea un curso
 * 
 * @package Mongruas
 */

class SocialMediaAutomation {
    
    private $db;
    private $table_jobs;
    private $table_logs;
    
    public function __construct() {
        global $wpdb;
        $this->db = $wpdb;
        $this->table_jobs = $wpdb->prefix . 'social_jobs';
        $this->table_logs = $wpdb->prefix . 'social_logs';
        
        // Crear tablas si no existen
        $this->create_tables();
        
        // Hook para procesar jobs en background
        add_action('wp_ajax_process_social_jobs', array($this, 'process_jobs'));
        add_action('wp_ajax_nopriv_process_social_jobs', array($this, 'process_jobs'));
        
        // Cron job para procesar automáticamente cada 5 minutos
        if (!wp_next_scheduled('mongruas_process_social_jobs')) {
            wp_schedule_event(time(), 'five_minutes', 'mongruas_process_social_jobs');
        }
        add_action('mongruas_process_social_jobs', array($this, 'process_jobs'));
    }
    
    /**
     * Crear tablas de base de datos
     */
    private function create_tables() {
        $charset_collate = $this->db->get_charset_collate();
        
        // Tabla de jobs
        $sql_jobs = "CREATE TABLE IF NOT EXISTS {$this->table_jobs} (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            course_id bigint(20) NOT NULL,
            platform varchar(50) NOT NULL,
            status varchar(20) DEFAULT 'pending',
            attempts int(11) DEFAULT 0,
            max_attempts int(11) DEFAULT 3,
            payload longtext,
            error_message text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            scheduled_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY course_id (course_id),
            KEY status (status),
            KEY scheduled_at (scheduled_at)
        ) $charset_collate;";
        
        // Tabla de logs
        $sql_logs = "CREATE TABLE IF NOT EXISTS {$this->table_logs} (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            job_id bigint(20),
            course_id bigint(20),
            platform varchar(50),
            action varchar(100),
            status varchar(20),
            message text,
            response longtext,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY job_id (job_id),
            KEY course_id (course_id),
            KEY created_at (created_at)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_jobs);
        dbDelta($sql_logs);
    }
    
    /**
     * Crear job para publicar en redes sociales
     */
    public function create_job($course_id, $platform = 'instagram', $scheduled_at = null) {
        // Obtener datos del curso
        $course = $this->get_course_data($course_id);
        
        if (!$course) {
            $this->log(null, $course_id, $platform, 'create_job', 'error', 'Curso no encontrado');
            return false;
        }
        
        // Preparar payload
        $payload = json_encode(array(
            'course_name' => $course['name'],
            'course_description' => $course['description'],
            'course_date' => $course['date'],
            'course_image' => $course['image'],
            'course_url' => $course['url']
        ));
        
        // Insertar job
        $result = $this->db->insert(
            $this->table_jobs,
            array(
                'course_id' => $course_id,
                'platform' => $platform,
                'status' => 'pending',
                'payload' => $payload,
                'scheduled_at' => $scheduled_at ? $scheduled_at : current_time('mysql')
            ),
            array('%d', '%s', '%s', '%s', '%s')
        );
        
        if ($result) {
            $job_id = $this->db->insert_id;
            $this->log($job_id, $course_id, $platform, 'create_job', 'success', 'Job creado correctamente');
            return $job_id;
        }
        
        return false;
    }
    
    /**
     * Procesar jobs pendientes
     */
    public function process_jobs() {
        // Obtener jobs pendientes
        $jobs = $this->db->get_results("
            SELECT * FROM {$this->table_jobs}
            WHERE status = 'pending'
            AND attempts < max_attempts
            AND scheduled_at <= NOW()
            ORDER BY created_at ASC
            LIMIT 10
        ");
        
        foreach ($jobs as $job) {
            $this->process_single_job($job);
        }
        
        return count($jobs);
    }
    
    /**
     * Procesar un job individual
     */
    private function process_single_job($job) {
        // Actualizar intentos
        $this->db->update(
            $this->table_jobs,
            array('attempts' => $job->attempts + 1),
            array('id' => $job->id),
            array('%d'),
            array('%d')
        );
        
        $payload = json_decode($job->payload, true);
        
        try {
            // Publicar según la plataforma
            switch ($job->platform) {
                case 'instagram':
                    $result = $this->publish_to_instagram($payload);
                    break;
                case 'facebook':
                    $result = $this->publish_to_facebook($payload);
                    break;
                default:
                    throw new Exception("Plataforma no soportada: {$job->platform}");
            }
            
            if ($result['success']) {
                // Marcar como completado
                $this->db->update(
                    $this->table_jobs,
                    array('status' => 'completed'),
                    array('id' => $job->id),
                    array('%s'),
                    array('%d')
                );
                
                $this->log($job->id, $job->course_id, $job->platform, 'publish', 'success', 
                    'Publicado correctamente', json_encode($result));
            } else {
                throw new Exception($result['message']);
            }
            
        } catch (Exception $e) {
            // Registrar error
            $error_message = $e->getMessage();
            
            $this->db->update(
                $this->table_jobs,
                array('error_message' => $error_message),
                array('id' => $job->id),
                array('%s'),
                array('%d')
            );
            
            // Si alcanzó el máximo de intentos, marcar como fallido
            if ($job->attempts + 1 >= $job->max_attempts) {
                $this->db->update(
                    $this->table_jobs,
                    array('status' => 'failed'),
                    array('id' => $job->id),
                    array('%s'),
                    array('%d')
                );
            }
            
            $this->log($job->id, $job->course_id, $job->platform, 'publish', 'error', 
                $error_message);
        }
    }
    
    /**
     * Publicar en Instagram
     */
    private function publish_to_instagram($payload) {
        // Configuración de Instagram Graph API
        $instagram_config = get_option('mongruas_instagram_config', array());
        
        if (empty($instagram_config['access_token']) || empty($instagram_config['account_id'])) {
            return array(
                'success' => false,
                'message' => 'Instagram no configurado. Configura el Access Token y Account ID.'
            );
        }
        
        $access_token = $instagram_config['access_token'];
        $account_id = $instagram_config['account_id'];
        
        // Crear el mensaje
        $message = $this->generate_instagram_message($payload);
        
        // Si hay imagen, publicar con imagen
        if (!empty($payload['course_image'])) {
            return $this->publish_instagram_with_image($account_id, $access_token, $message, $payload['course_image']);
        } else {
            // Publicar solo texto (como carousel o story)
            return $this->publish_instagram_text($account_id, $access_token, $message);
        }
    }
    
    /**
     * Publicar en Instagram con imagen
     */
    private function publish_instagram_with_image($account_id, $access_token, $caption, $image_url) {
        // Paso 1: Crear contenedor de medios
        $create_url = "https://graph.facebook.com/v18.0/{$account_id}/media";
        
        $create_data = array(
            'image_url' => $image_url,
            'caption' => $caption,
            'access_token' => $access_token
        );
        
        $create_response = wp_remote_post($create_url, array(
            'body' => $create_data,
            'timeout' => 30
        ));
        
        if (is_wp_error($create_response)) {
            return array(
                'success' => false,
                'message' => 'Error al crear contenedor: ' . $create_response->get_error_message()
            );
        }
        
        $create_body = json_decode(wp_remote_retrieve_body($create_response), true);
        
        if (empty($create_body['id'])) {
            return array(
                'success' => false,
                'message' => 'Error al crear contenedor: ' . json_encode($create_body)
            );
        }
        
        $creation_id = $create_body['id'];
        
        // Paso 2: Publicar el contenedor
        $publish_url = "https://graph.facebook.com/v18.0/{$account_id}/media_publish";
        
        $publish_data = array(
            'creation_id' => $creation_id,
            'access_token' => $access_token
        );
        
        $publish_response = wp_remote_post($publish_url, array(
            'body' => $publish_data,
            'timeout' => 30
        ));
        
        if (is_wp_error($publish_response)) {
            return array(
                'success' => false,
                'message' => 'Error al publicar: ' . $publish_response->get_error_message()
            );
        }
        
        $publish_body = json_decode(wp_remote_retrieve_body($publish_response), true);
        
        if (empty($publish_body['id'])) {
            return array(
                'success' => false,
                'message' => 'Error al publicar: ' . json_encode($publish_body)
            );
        }
        
        return array(
            'success' => true,
            'message' => 'Publicado correctamente en Instagram',
            'post_id' => $publish_body['id']
        );
    }
    
    /**
     * Publicar texto en Instagram (como story)
     */
    private function publish_instagram_text($account_id, $access_token, $message) {
        // Instagram requiere imagen, así que generamos una imagen con el texto
        // O publicamos como story
        return array(
            'success' => false,
            'message' => 'Instagram requiere imagen. Por favor, añade una imagen al curso.'
        );
    }
    
    /**
     * Generar mensaje para Instagram
     */
    private function generate_instagram_message($payload) {
        $message = "🎓 ¡NUEVO GRUPO DISPONIBLE! 🎓\n\n";
        $message .= "📚 " . $payload['course_name'] . "\n\n";
        
        if (!empty($payload['course_description'])) {
            $message .= $payload['course_description'] . "\n\n";
        }
        
        if (!empty($payload['course_date'])) {
            $message .= "📅 Fecha: " . $payload['course_date'] . "\n\n";
        }
        
        $message .= "✅ ¡Plazas limitadas!\n";
        $message .= "📞 Contacta con nosotros para más información\n\n";
        $message .= "#Formación #Cursos #Mongruas #FormacionProfesional";
        
        return $message;
    }
    
    /**
     * Obtener datos del curso
     */
    private function get_course_data($course_id) {
        global $wpdb;
        
        $course = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}courses WHERE id = %d",
            $course_id
        ), ARRAY_A);
        
        if (!$course) {
            return null;
        }
        
        return array(
            'name' => $course['name'],
            'description' => $course['description'],
            'date' => $course['start_date'],
            'image' => $course['image_url'],
            'url' => home_url('/curso-detalle.php?id=' . $course_id)
        );
    }
    
    /**
     * Registrar log
     */
    private function log($job_id, $course_id, $platform, $action, $status, $message, $response = null) {
        $this->db->insert(
            $this->table_logs,
            array(
                'job_id' => $job_id,
                'course_id' => $course_id,
                'platform' => $platform,
                'action' => $action,
                'status' => $status,
                'message' => $message,
                'response' => $response
            ),
            array('%d', '%d', '%s', '%s', '%s', '%s', '%s')
        );
    }
    
    /**
     * Obtener estadísticas
     */
    public function get_stats() {
        $stats = array();
        
        $stats['pending'] = $this->db->get_var("SELECT COUNT(*) FROM {$this->table_jobs} WHERE status = 'pending'");
        $stats['completed'] = $this->db->get_var("SELECT COUNT(*) FROM {$this->table_jobs} WHERE status = 'completed'");
        $stats['failed'] = $this->db->get_var("SELECT COUNT(*) FROM {$this->table_jobs} WHERE status = 'failed'");
        $stats['total'] = $this->db->get_var("SELECT COUNT(*) FROM {$this->table_jobs}");
        
        return $stats;
    }
}

// Inicializar
global $social_media_automation;
$social_media_automation = new SocialMediaAutomation();

// Añadir intervalo personalizado de 5 minutos
add_filter('cron_schedules', function($schedules) {
    $schedules['five_minutes'] = array(
        'interval' => 300,
        'display' => __('Cada 5 minutos')
    );
    return $schedules;
});

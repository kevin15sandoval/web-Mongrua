<?php
/**
 * Security Configuration for Course Management Panel
 * 
 * Additional security measures and configurations
 * 
 * @package Mongruas
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Security Configuration Class
 */
class Mongruas_Security_Config {
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action('init', array($this, 'init_security_measures'));
        add_action('wp_login_failed', array($this, 'log_failed_login'));
        add_filter('wp_authenticate_user', array($this, 'check_user_status'), 10, 2);
    }
    
    /**
     * Initialize security measures
     */
    public function init_security_measures() {
        // Remove WordPress version from head
        remove_action('wp_head', 'wp_generator');
        
        // Remove version from RSS feeds
        add_filter('the_generator', '__return_empty_string');
        
        // Hide login errors
        add_filter('login_errors', array($this, 'hide_login_errors'));
        
        // Add security headers
        add_action('send_headers', array($this, 'add_security_headers'));
        
        // Disable file editing in admin
        if (!defined('DISALLOW_FILE_EDIT')) {
            define('DISALLOW_FILE_EDIT', true);
        }
    }
    
    /**
     * Hide login error details
     */
    public function hide_login_errors($error) {
        return 'Invalid login credentials.';
    }
    
    /**
     * Add security headers
     */
    public function add_security_headers() {
        // Only add headers for admin pages and our panel
        if (is_admin() || (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'mongruas/v1') !== false)) {
            header('X-Content-Type-Options: nosniff');
            header('X-Frame-Options: SAMEORIGIN');
            header('X-XSS-Protection: 1; mode=block');
            header('Referrer-Policy: strict-origin-when-cross-origin');
        }
    }
    
    /**
     * Log failed login attempts
     */
    public function log_failed_login($username) {
        $ip = $this->get_client_ip();
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Unknown';
        
        error_log(sprintf(
            'Failed login attempt for user "%s" from IP %s (User Agent: %s)',
            $username,
            $ip,
            $user_agent
        ));
    }
    
    /**
     * Check user status during authentication
     */
    public function check_user_status($user, $password) {
        if (is_wp_error($user)) {
            return $user;
        }
        
        // Additional checks can be added here
        // For example: check if user is active, not suspended, etc.
        
        return $user;
    }
    
    /**
     * Get client IP address
     */
    private function get_client_ip() {
        $ip_keys = array(
            'HTTP_CF_CONNECTING_IP',     // Cloudflare
            'HTTP_CLIENT_IP',            // Proxy
            'HTTP_X_FORWARDED_FOR',      // Load balancer/proxy
            'HTTP_X_FORWARDED',          // Proxy
            'HTTP_X_CLUSTER_CLIENT_IP',  // Cluster
            'HTTP_FORWARDED_FOR',        // Proxy
            'HTTP_FORWARDED',            // Proxy
            'REMOTE_ADDR'                // Standard
        );
        
        foreach ($ip_keys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                $ip = $_SERVER[$key];
                if (strpos($ip, ',') !== false) {
                    $ip = explode(',', $ip)[0];
                }
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }
        
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'Unknown';
    }
    
    /**
     * Validate nonce with additional checks
     */
    public static function validate_nonce($nonce, $action = 'mongruas-panel-nonce') {
        if (!wp_verify_nonce($nonce, $action)) {
            return false;
        }
        
        // Additional validation can be added here
        // For example: check nonce age, user session, etc.
        
        return true;
    }
    
    /**
     * Sanitize and validate course data
     */
    public static function validate_course_data($data) {
        $validated = array();
        $errors = array();
        
        // Validate name
        if (!isset($data['name'])) {
            $errors[] = 'Course name is required';
        } else {
            $validated['name'] = sanitize_text_field(trim($data['name']));
            
            // Business logic validation for name
            if (empty($validated['name'])) {
                // Empty name is allowed (course will be inactive)
                $validated['name'] = '';
            } elseif (strlen($validated['name']) < 3) {
                $errors[] = 'Course name must be at least 3 characters long';
            } elseif (strlen($validated['name']) > 200) {
                $errors[] = 'Course name too long (max 200 characters)';
            } elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ0-9\s\-\.\,\:\(\)]+$/u', $validated['name'])) {
                $errors[] = 'Course name contains invalid characters';
            }
        }
        
        // Validate description
        if (!isset($data['description'])) {
            $validated['description'] = '';
        } else {
            $validated['description'] = sanitize_textarea_field(trim($data['description']));
            
            // Business logic validation for description
            if (strlen($validated['description']) > 1000) {
                $errors[] = 'Course description too long (max 1000 characters)';
            }
            
            // Remove potentially harmful content
            $validated['description'] = wp_kses($validated['description'], array(
                'br' => array(),
                'p' => array(),
                'strong' => array(),
                'em' => array(),
                'ul' => array(),
                'ol' => array(),
                'li' => array(),
            ));
        }
        
        // Validate date
        if (!isset($data['date'])) {
            $validated['date'] = '';
        } else {
            $validated['date'] = sanitize_text_field(trim($data['date']));
            
            // Business logic validation for date
            if (!empty($validated['date'])) {
                if (strlen($validated['date']) > 100) {
                    $errors[] = 'Course date too long (max 100 characters)';
                }
                
                // Validate date format if it looks like a date
                if (preg_match('/^\d{4}-\d{2}-\d{2}/', $validated['date'])) {
                    $date_parts = explode('-', substr($validated['date'], 0, 10));
                    if (count($date_parts) === 3) {
                        if (!checkdate($date_parts[1], $date_parts[2], $date_parts[0])) {
                            $errors[] = 'Invalid date format';
                        }
                    }
                }
            }
        }
        
        // Validate duration
        if (!isset($data['duration'])) {
            $validated['duration'] = '';
        } else {
            $validated['duration'] = sanitize_text_field(trim($data['duration']));
            
            // Business logic validation for duration
            if (!empty($validated['duration'])) {
                if (strlen($validated['duration']) > 50) {
                    $errors[] = 'Course duration too long (max 50 characters)';
                }
                
                // Validate duration format (should contain numbers)
                if (!preg_match('/\d/', $validated['duration'])) {
                    $errors[] = 'Duration should contain numeric information';
                }
            }
        }
        
        // Validate modality
        $allowed_modalities = array('Online', 'Presencial', 'Semipresencial');
        if (!isset($data['modality']) || !in_array($data['modality'], $allowed_modalities)) {
            $validated['modality'] = 'Online'; // Default value
        } else {
            $validated['modality'] = $data['modality'];
        }
        
        // Validate category
        $allowed_categories = array(
            'Prevención de Riesgos Laborales',
            'Formación Profesional',
            'Idiomas',
            'Informática',
            'Gestión Empresarial',
            'Marketing',
            'Otros'
        );
        if (!isset($data['category']) || !in_array($data['category'], $allowed_categories)) {
            $validated['category'] = 'Prevención de Riesgos Laborales'; // Default value
        } else {
            $validated['category'] = $data['category'];
        }
        
        // Business logic validation: If name is provided, other required fields should be provided
        if (!empty($validated['name'])) {
            if (empty($validated['description'])) {
                $errors[] = 'Course description is required when name is provided';
            }
            if (empty($validated['date'])) {
                $errors[] = 'Course date is required when name is provided';
            }
            if (empty($validated['duration'])) {
                $errors[] = 'Course duration is required when name is provided';
            }
        }
        
        // Return errors if any
        if (!empty($errors)) {
            return new WP_Error('validation_failed', 'Validation failed', array(
                'status' => 400,
                'errors' => $errors
            ));
        }
        
        return $validated;
    }
    
    /**
     * Validate image data
     */
    public static function validate_image_data($image_data) {
        if (!is_array($image_data)) {
            return new WP_Error('invalid_image_data', 'Image data must be an array');
        }
        
        // Validate required fields
        if (!isset($image_data['id']) || !is_numeric($image_data['id'])) {
            return new WP_Error('invalid_image_id', 'Valid image ID is required');
        }
        
        // Verify the attachment exists and is an image
        $attachment = get_post($image_data['id']);
        if (!$attachment || $attachment->post_type !== 'attachment') {
            return new WP_Error('image_not_found', 'Image not found');
        }
        
        // Verify it's actually an image
        if (!wp_attachment_is_image($image_data['id'])) {
            return new WP_Error('not_an_image', 'Attachment is not an image');
        }
        
        return array(
            'id' => intval($image_data['id']),
            'url' => wp_get_attachment_url($image_data['id']),
            'alt' => isset($image_data['alt']) ? sanitize_text_field($image_data['alt']) : '',
        );
    }
    
    /**
     * Sanitize request data recursively
     */
    public static function sanitize_request_data($data) {
        if (is_array($data)) {
            return array_map(array(self::class, 'sanitize_request_data'), $data);
        }
        
        if (is_string($data)) {
            return sanitize_text_field($data);
        }
        
        return $data;
    }
    
    /**
     * Validate course ID
     */
    public static function validate_course_id($course_id) {
        $course_id = intval($course_id);
        
        if (!in_array($course_id, [1, 2, 3])) {
            return new WP_Error('invalid_course_id', 'Course ID must be 1, 2, or 3');
        }
        
        return $course_id;
    }
    
    /**
     * Check if user has required capabilities
     */
    public static function check_user_capabilities($required_capability = 'administrator') {
        if (!is_user_logged_in()) {
            return new WP_Error('not_logged_in', 'User not logged in', array('status' => 401));
        }
        
        if (!current_user_can($required_capability)) {
            return new WP_Error('insufficient_permissions', 'Insufficient permissions', array('status' => 403));
        }
        
        return true;
    }
}

// Initialize security configuration
new Mongruas_Security_Config();
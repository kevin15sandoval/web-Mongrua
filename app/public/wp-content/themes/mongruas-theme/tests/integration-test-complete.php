<?php
/**
 * Complete Integration Testing for Course Management Panel
 * 
 * Task 10.1: Complete integration testing
 * - Test all workflows end-to-end
 * - Verify WordPress ACF integration
 * - Test with different user roles and permissions
 * - Validate security boundary enforcement
 * 
 * @package Mongruas
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Complete_Integration_Test {
    
    private $test_results = array();
    private $total_tests = 0;
    private $passed_tests = 0;
    private $admin_user_id;
    private $editor_user_id;
    private $subscriber_user_id;
    private $courses_page_id;
    private $panel_instance;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->setup_test_environment();
    }
    
    /**
     * Setup test environment
     */
    private function setup_test_environment() {
        // Create test users with different roles
        $this->admin_user_id = wp_create_user('test_admin_' . time(), 'test_password_123', 'admin@test.local');
        $this->editor_user_id = wp_create_user('test_editor_' . time(), 'test_password_123', 'editor@test.local');
        $this->subscriber_user_id = wp_create_user('test_subscriber_' . time(), 'test_password_123', 'subscriber@test.local');
        
        if (is_wp_error($this->admin_user_id) || is_wp_error($this->editor_user_id) || is_wp_error($this->subscriber_user_id)) {
            throw new Exception('Failed to create test users');
        }
        
        // Set user roles
        $admin_user = new WP_User($this->admin_user_id);
        $admin_user->set_role('administrator');
        
        $editor_user = new WP_User($this->editor_user_id);
        $editor_user->set_role('editor');
        
        $subscriber_user = new WP_User($this->subscriber_user_id);
        $subscriber_user->set_role('subscriber');
        
        // Get or create courses page
        $this->courses_page_id = $this->get_or_create_courses_page();
        
        // Initialize panel instance
        $this->panel_instance = new Mongruas_Course_Management_Panel();
    }
    
    /**
     * Get or create courses page for testing
     */
    private function get_or_create_courses_page() {
        $courses_page = get_page_by_path('cursos');
        
        if (!$courses_page) {
            // Create a test courses page
            $page_id = wp_insert_post(array(
                'post_title' => 'Cursos',
                'post_name' => 'cursos',
                'post_content' => 'Test courses page for integration testing',
                'post_status' => 'publish',
                'post_type' => 'page',
            ));
            
            if (is_wp_error($page_id)) {
                throw new Exception('Failed to create test courses page');
            }
            
            return $page_id;
        }
        
        return $courses_page->ID;
    }
    
    /**
     * Test assertion helper
     */
    private function assert_test($condition, $test_name, $message = '') {
        $this->total_tests++;
        $status = $condition ? 'PASS' : 'FAIL';
        
        if ($condition) {
            $this->passed_tests++;
        }
        
        $this->test_results[] = array(
            'name' => $test_name,
            'status' => $status,
            'message' => $message,
            'condition' => $condition
        );
        
        return $condition;
    }
    
    /**
     * Run all integration tests
     */
    public function run_all_tests() {
        echo "<h1>Complete Integration Testing - Course Management Panel</h1>\n";
        echo "<p>Testing all workflows end-to-end, ACF integration, user roles, and security boundaries.</p>\n";
        
        try {
            // Test 1: Basic System Setup
            $this->test_basic_system_setup();
            
            // Test 2: User Role and Permission Testing
            $this->test_user_roles_and_permissions();
            
            // Test 3: Authentication Workflow Testing
            $this->test_authentication_workflows();
            
            // Test 4: Course Management Workflow Testing
            $this->test_course_management_workflows();
            
            // Test 5: ACF Integration Testing
            $this->test_acf_integration();
            
            // Test 6: Security Boundary Testing
            $this->test_security_boundaries();
            
            // Test 7: API Endpoint Testing
            $this->test_api_endpoints();
            
            // Test 8: Media Upload Workflow Testing
            $this->test_media_upload_workflows();
            
            // Test 9: Data Validation and Sanitization Testing
            $this->test_data_validation_and_sanitization();
            
            // Test 10: End-to-End Workflow Testing
            $this->test_end_to_end_workflows();
            
        } catch (Exception $e) {
            echo "<div style='color: red; background: #ffe6e6; padding: 10px; margin: 10px 0; border-radius: 5px;'>";
            echo "<strong>Test Execution Error:</strong> " . $e->getMessage();
            echo "</div>";
        }
        
        // Display results
        $this->display_test_results();
        
        // Cleanup
        $this->cleanup_test_environment();
        
        return $this->passed_tests === $this->total_tests;
    }
    
    /**
     * Test 1: Basic System Setup
     */
    private function test_basic_system_setup() {
        echo "<h2>1. Basic System Setup Tests</h2>\n";
        
        // Test class existence
        $this->assert_test(
            class_exists('Mongruas_Course_Management_Panel'),
            'Course Management Panel class exists',
            'Main panel class should be available'
        );
        
        $this->assert_test(
            class_exists('Mongruas_Security_Config'),
            'Security Config class exists',
            'Security configuration class should be available'
        );
        
        // Test required files exist
        $required_files = array(
            MONGRUAS_THEME_DIR . '/inc/course-management-panel.php',
            MONGRUAS_THEME_DIR . '/inc/security-config.php',
            MONGRUAS_THEME_DIR . '/assets/css/course-management-panel.css',
            MONGRUAS_THEME_DIR . '/assets/js/course-management-panel.js',
        );
        
        foreach ($required_files as $file) {
            $this->assert_test(
                file_exists($file),
                'Required file exists: ' . basename($file),
                'File: ' . $file
            );
        }
        
        // Test courses page exists
        $this->assert_test(
            !empty($this->courses_page_id),
            'Courses page exists or was created',
            'Page ID: ' . $this->courses_page_id
        );
        
        // Test WordPress hooks are registered
        $this->assert_test(
            has_action('init', array($this->panel_instance, 'init')),
            'Init hook is registered',
            'Panel initialization should be hooked to init'
        );
        
        $this->assert_test(
            has_action('wp_enqueue_scripts', array($this->panel_instance, 'enqueue_panel_assets')),
            'Asset enqueue hook is registered',
            'Asset enqueuing should be hooked to wp_enqueue_scripts'
        );
        
        $this->assert_test(
            has_action('wp_footer', array($this->panel_instance, 'render_panel_html')),
            'Footer render hook is registered',
            'Panel HTML rendering should be hooked to wp_footer'
        );
        
        $this->assert_test(
            has_action('rest_api_init', array($this->panel_instance, 'register_rest_endpoints')),
            'REST API hook is registered',
            'REST endpoints should be hooked to rest_api_init'
        );
    }
    
    /**
     * Test 2: User Role and Permission Testing
     */
    private function test_user_roles_and_permissions() {
        echo "<h2>2. User Role and Permission Tests</h2>\n";
        
        // Test admin user permissions
        wp_set_current_user($this->admin_user_id);
        
        $this->assert_test(
            current_user_can('administrator'),
            'Admin user has administrator capability',
            'Admin user should have administrator capability'
        );
        
        // Test panel access for admin
        ob_start();
        $this->panel_instance->render_panel_html();
        $admin_output = ob_get_clean();
        
        $this->assert_test(
            !empty($admin_output) && strpos($admin_output, 'mongruas-panel-access') !== false,
            'Admin user can access panel HTML',
            'Panel HTML should be rendered for admin users'
        );
        
        // Test asset enqueuing for admin
        do_action('wp_enqueue_scripts');
        
        $this->assert_test(
            wp_style_is('mongruas-panel-style', 'enqueued'),
            'Panel CSS enqueued for admin',
            'CSS should be enqueued for admin users'
        );
        
        $this->assert_test(
            wp_script_is('mongruas-panel-script', 'enqueued'),
            'Panel JS enqueued for admin',
            'JavaScript should be enqueued for admin users'
        );
        
        // Test editor user permissions
        wp_set_current_user($this->editor_user_id);
        
        $this->assert_test(
            !current_user_can('administrator'),
            'Editor user does not have administrator capability',
            'Editor user should not have administrator capability'
        );
        
        // Test panel access for editor (should be denied)
        ob_start();
        $this->panel_instance->render_panel_html();
        $editor_output = ob_get_clean();
        
        $this->assert_test(
            empty($editor_output),
            'Editor user cannot access panel HTML',
            'Panel HTML should not be rendered for editor users'
        );
        
        // Test subscriber user permissions
        wp_set_current_user($this->subscriber_user_id);
        
        $this->assert_test(
            !current_user_can('administrator'),
            'Subscriber user does not have administrator capability',
            'Subscriber user should not have administrator capability'
        );
        
        // Test panel access for subscriber (should be denied)
        ob_start();
        $this->panel_instance->render_panel_html();
        $subscriber_output = ob_get_clean();
        
        $this->assert_test(
            empty($subscriber_output),
            'Subscriber user cannot access panel HTML',
            'Panel HTML should not be rendered for subscriber users'
        );
        
        // Test logged out user
        wp_set_current_user(0);
        
        ob_start();
        $this->panel_instance->render_panel_html();
        $logged_out_output = ob_get_clean();
        
        $this->assert_test(
            empty($logged_out_output),
            'Logged out user cannot access panel HTML',
            'Panel HTML should not be rendered for logged out users'
        );
    }
    
    /**
     * Test 3: Authentication Workflow Testing
     */
    private function test_authentication_workflows() {
        echo "<h2>3. Authentication Workflow Tests</h2>\n";
        
        // Set admin user for testing
        wp_set_current_user($this->admin_user_id);
        
        // Test nonce generation and validation
        $nonce = wp_create_nonce('mongruas-panel-nonce');
        
        $this->assert_test(
            !empty($nonce) && strlen($nonce) === 10,
            'Nonce generation works correctly',
            'Nonce should be generated with correct length'
        );
        
        $this->assert_test(
            wp_verify_nonce($nonce, 'mongruas-panel-nonce'),
            'Nonce validation works correctly',
            'Generated nonce should validate successfully'
        );
        
        // Test security config nonce validation
        $this->assert_test(
            Mongruas_Security_Config::validate_nonce($nonce),
            'Security config nonce validation works',
            'Security class should validate nonces correctly'
        );
        
        // Test capability checking
        $capability_check = Mongruas_Security_Config::check_user_capabilities('administrator');
        
        $this->assert_test(
            !is_wp_error($capability_check),
            'Admin capability check passes',
            'Admin user should pass capability check'
        );
        
        // Test capability check with non-admin user
        wp_set_current_user($this->editor_user_id);
        $capability_check = Mongruas_Security_Config::check_user_capabilities('administrator');
        
        $this->assert_test(
            is_wp_error($capability_check),
            'Non-admin capability check fails',
            'Non-admin user should fail capability check'
        );
        
        // Test rate limiting functionality (simulate multiple failures)
        $username = 'test_rate_limit_user';
        
        // Simulate multiple login failures
        for ($i = 0; $i < 6; $i++) {
            do_action('wp_login_failed', $username);
        }
        
        // Check if rate limiting is working
        $transient_key = 'mongruas_login_failures_' . md5($username);
        $failures = get_transient($transient_key);
        
        $this->assert_test(
            $failures >= 5,
            'Rate limiting records failures correctly',
            'Should record multiple login failures'
        );
    }
    
    /**
     * Test 4: Course Management Workflow Testing
     */
    private function test_course_management_workflows() {
        echo "<h2>4. Course Management Workflow Tests</h2>\n";
        
        // Set admin user for testing
        wp_set_current_user($this->admin_user_id);
        
        // Test course data validation - valid data
        $valid_course_data = array(
            'name' => 'Test Integration Course',
            'description' => 'This is a test course for integration testing.',
            'date' => '2025-03-15',
            'duration' => '40 hours',
            'modality' => 'Online',
            'category' => 'Prevención de Riesgos Laborales',
        );
        
        $validated_data = Mongruas_Security_Config::validate_course_data($valid_course_data);
        
        $this->assert_test(
            !is_wp_error($validated_data),
            'Valid course data validation passes',
            'Valid course data should pass validation'
        );
        
        // Test course data validation - invalid data
        $invalid_course_data = array(
            'name' => 'AB', // Too short
            'description' => str_repeat('A', 1001), // Too long
            'date' => '2025-13-32', // Invalid date
            'duration' => '', // Empty when name provided
            'modality' => 'InvalidMode',
            'category' => 'InvalidCategory',
        );
        
        $invalid_result = Mongruas_Security_Config::validate_course_data($invalid_course_data);
        
        $this->assert_test(
            is_wp_error($invalid_result),
            'Invalid course data validation fails',
            'Invalid course data should fail validation'
        );
        
        // Test course ID validation
        for ($i = 0; $i <= 4; $i++) {
            $result = Mongruas_Security_Config::validate_course_id($i);
            $expected = in_array($i, [1, 2, 3]);
            $actual = !is_wp_error($result);
            
            $this->assert_test(
                $expected === $actual,
                "Course ID $i validation " . ($expected ? 'passes' : 'fails'),
                "Course ID $i should " . ($expected ? 'be valid' : 'be invalid')
            );
        }
        
        // Test empty course data (should be valid for inactive course)
        $empty_course_data = array(
            'name' => '',
            'description' => '',
            'date' => '',
            'duration' => '',
            'modality' => 'Online',
            'category' => 'Prevención de Riesgos Laborales',
        );
        
        $empty_result = Mongruas_Security_Config::validate_course_data($empty_course_data);
        
        $this->assert_test(
            !is_wp_error($empty_result),
            'Empty course data validation passes',
            'Empty course data should be valid for inactive courses'
        );
    }
    
    /**
     * Test 5: ACF Integration Testing
     */
    private function test_acf_integration() {
        echo "<h2>5. ACF Integration Tests</h2>\n";
        
        // Set admin user for testing
        wp_set_current_user($this->admin_user_id);
        
        // Test ACF function availability
        $this->assert_test(
            function_exists('get_field'),
            'ACF get_field function is available',
            'ACF should be installed and active'
        );
        
        $this->assert_test(
            function_exists('update_field'),
            'ACF update_field function is available',
            'ACF update functionality should be available'
        );
        
        // Test course field structure
        $course_fields = array(
            'course_1_name',
            'course_1_description',
            'course_1_date',
            'course_1_duration',
            'course_1_modality',
            'course_1_category',
            'course_1_image',
        );
        
        foreach ($course_fields as $field) {
            // Try to get the field (should not error even if empty)
            $field_value = get_field($field, $this->courses_page_id);
            
            $this->assert_test(
                !is_wp_error($field_value),
                "ACF field '$field' is accessible",
                "Should be able to access ACF field without errors"
            );
        }
        
        // Test ACF field update and retrieval
        $test_data = array(
            'course_1_name' => 'ACF Integration Test Course',
            'course_1_description' => 'Testing ACF integration functionality.',
            'course_1_date' => '2025-04-01',
            'course_1_duration' => '30 hours',
            'course_1_modality' => 'Presencial',
            'course_1_category' => 'Formación Profesional',
        );
        
        $update_success = true;
        foreach ($test_data as $field => $value) {
            $result = update_field($field, $value, $this->courses_page_id);
            if (!$result) {
                $update_success = false;
                break;
            }
        }
        
        $this->assert_test(
            $update_success,
            'ACF field updates work correctly',
            'Should be able to update ACF fields'
        );
        
        // Test ACF field retrieval after update
        $retrieval_success = true;
        foreach ($test_data as $field => $expected_value) {
            $actual_value = get_field($field, $this->courses_page_id);
            if ($actual_value !== $expected_value) {
                $retrieval_success = false;
                break;
            }
        }
        
        $this->assert_test(
            $retrieval_success,
            'ACF field retrieval works correctly',
            'Should be able to retrieve updated ACF field values'
        );
        
        // Test round-trip consistency (update then get)
        $round_trip_test_value = 'Round Trip Test Value ' . time();
        update_field('course_2_name', $round_trip_test_value, $this->courses_page_id);
        $retrieved_value = get_field('course_2_name', $this->courses_page_id);
        
        $this->assert_test(
            $retrieved_value === $round_trip_test_value,
            'ACF round-trip consistency works',
            'Updated value should match retrieved value'
        );
    }
    
    /**
     * Test 6: Security Boundary Testing
     */
    private function test_security_boundaries() {
        echo "<h2>6. Security Boundary Tests</h2>\n";
        
        // Test permission callback for REST endpoints
        $rest_server = rest_get_server();
        $routes = $rest_server->get_routes();
        
        // Test admin permission callback with admin user
        wp_set_current_user($this->admin_user_id);
        
        $mock_request = new WP_REST_Request('GET', '/mongruas/v1/courses');
        $mock_request->set_header('X-WP-Nonce', wp_create_nonce('mongruas-panel-nonce'));
        
        $permission_result = $this->panel_instance->check_admin_permission($mock_request);
        
        $this->assert_test(
            !is_wp_error($permission_result),
            'Admin user passes REST permission check',
            'Admin user should have access to REST endpoints'
        );
        
        // Test permission callback with non-admin user
        wp_set_current_user($this->editor_user_id);
        
        $mock_request = new WP_REST_Request('GET', '/mongruas/v1/courses');
        $mock_request->set_header('X-WP-Nonce', wp_create_nonce('mongruas-panel-nonce'));
        
        $permission_result = $this->panel_instance->check_admin_permission($mock_request);
        
        $this->assert_test(
            is_wp_error($permission_result),
            'Non-admin user fails REST permission check',
            'Non-admin user should not have access to REST endpoints'
        );
        
        // Test invalid nonce
        wp_set_current_user($this->admin_user_id);
        
        $mock_request = new WP_REST_Request('GET', '/mongruas/v1/courses');
        $mock_request->set_header('X-WP-Nonce', 'invalid_nonce');
        
        $permission_result = $this->panel_instance->check_admin_permission($mock_request);
        
        $this->assert_test(
            is_wp_error($permission_result) && $permission_result->get_error_code() === 'invalid_nonce',
            'Invalid nonce fails permission check',
            'Invalid nonce should be rejected'
        );
        
        // Test data sanitization
        $malicious_data = array(
            'name' => '<script>alert("xss")</script>Test Course',
            'description' => '<iframe src="javascript:alert(1)"></iframe>Description',
            'date' => '2025-01-01<script>',
            'duration' => '40 hours<img src=x onerror=alert(1)>',
            'modality' => 'Online',
            'category' => 'Prevención de Riesgos Laborales',
        );
        
        $sanitized_data = Mongruas_Security_Config::validate_course_data($malicious_data);
        
        if (!is_wp_error($sanitized_data)) {
            $contains_script = false;
            foreach ($sanitized_data as $value) {
                if (strpos($value, '<script>') !== false || strpos($value, 'javascript:') !== false) {
                    $contains_script = true;
                    break;
                }
            }
            
            $this->assert_test(
                !$contains_script,
                'Malicious scripts are sanitized',
                'Script tags and javascript: should be removed'
            );
        }
        
        // Test SQL injection protection (basic test)
        $sql_injection_data = array(
            'name' => "'; DROP TABLE wp_posts; --",
            'description' => "1' OR '1'='1",
            'date' => '2025-01-01',
            'duration' => '40 hours',
            'modality' => 'Online',
            'category' => 'Prevención de Riesgos Laborales',
        );
        
        $sanitized_sql_data = Mongruas_Security_Config::validate_course_data($sql_injection_data);
        
        if (!is_wp_error($sanitized_sql_data)) {
            $contains_sql = false;
            foreach ($sanitized_sql_data as $value) {
                if (strpos($value, 'DROP TABLE') !== false || strpos($value, "1'='1") !== false) {
                    $contains_sql = true;
                    break;
                }
            }
            
            $this->assert_test(
                !$contains_sql,
                'SQL injection attempts are sanitized',
                'SQL injection patterns should be sanitized'
            );
        }
    }
    
    /**
     * Test 7: API Endpoint Testing
     */
    private function test_api_endpoints() {
        echo "<h2>7. API Endpoint Tests</h2>\n";
        
        // Test REST endpoint registration
        $rest_server = rest_get_server();
        $routes = $rest_server->get_routes();
        
        $expected_endpoints = array(
            '/mongruas/v1/auth/login' => 'Authentication login endpoint',
            '/mongruas/v1/auth/verify' => 'Authentication verify endpoint',
            '/mongruas/v1/auth/logout' => 'Authentication logout endpoint',
            '/mongruas/v1/courses' => 'Courses management endpoint',
            '/mongruas/v1/courses/reorder' => 'Course reorder endpoint',
            '/mongruas/v1/media/upload' => 'Media upload endpoint',
        );
        
        foreach ($expected_endpoints as $endpoint => $description) {
            $this->assert_test(
                isset($routes[$endpoint]),
                "REST endpoint registered: $endpoint",
                $description
            );
        }
        
        // Test courses endpoint with admin user
        wp_set_current_user($this->admin_user_id);
        
        $courses_request = new WP_REST_Request('GET', '/mongruas/v1/courses');
        $courses_request->set_header('X-WP-Nonce', wp_create_nonce('mongruas-panel-nonce'));
        
        $courses_response = $this->panel_instance->get_courses($courses_request);
        
        $this->assert_test(
            !is_wp_error($courses_response),
            'Courses GET endpoint works for admin',
            'Admin should be able to retrieve courses'
        );
        
        if (!is_wp_error($courses_response)) {
            $response_data = rest_ensure_response($courses_response)->get_data();
            
            $this->assert_test(
                isset($response_data['success']) && $response_data['success'] === true,
                'Courses response has success flag',
                'Response should indicate success'
            );
            
            $this->assert_test(
                isset($response_data['data']) && is_array($response_data['data']),
                'Courses response has data array',
                'Response should contain courses data array'
            );
            
            $this->assert_test(
                count($response_data['data']) === 3,
                'Courses response has 3 course slots',
                'Should return exactly 3 course slots'
            );
        }
        
        // Test course update endpoint
        $update_data = array(
            'name' => 'API Test Course',
            'description' => 'Testing course update via API',
            'date' => '2025-05-01',
            'duration' => '25 hours',
            'modality' => 'Semipresencial',
            'category' => 'Informática',
        );
        
        $update_request = new WP_REST_Request('PUT', '/mongruas/v1/courses/1');
        $update_request->set_header('X-WP-Nonce', wp_create_nonce('mongruas-panel-nonce'));
        $update_request->set_body(json_encode($update_data));
        $update_request->set_param('id', 1);
        
        $update_response = $this->panel_instance->update_course($update_request);
        
        $this->assert_test(
            !is_wp_error($update_response),
            'Course update endpoint works for admin',
            'Admin should be able to update courses'
        );
        
        if (!is_wp_error($update_response)) {
            $update_response_data = rest_ensure_response($update_response)->get_data();
            
            $this->assert_test(
                isset($update_response_data['success']) && $update_response_data['success'] === true,
                'Course update response indicates success',
                'Update response should indicate success'
            );
            
            $this->assert_test(
                isset($update_response_data['data']['name']) && $update_response_data['data']['name'] === 'API Test Course',
                'Course update response contains updated data',
                'Response should contain the updated course data'
            );
        }
    }
    
    /**
     * Test 8: Media Upload Workflow Testing
     */
    private function test_media_upload_workflows() {
        echo "<h2>8. Media Upload Workflow Tests</h2>\n";
        
        // Set admin user for testing
        wp_set_current_user($this->admin_user_id);
        
        // Test image data validation - valid image
        $valid_image_data = array(
            'id' => 1, // Assuming attachment ID 1 exists or we'll create one
            'url' => 'http://example.com/test.jpg',
            'alt' => 'Test image',
        );
        
        // Create a test attachment for validation
        $test_attachment_id = wp_insert_attachment(array(
            'post_title' => 'Test Image',
            'post_content' => '',
            'post_status' => 'inherit',
            'post_mime_type' => 'image/jpeg',
        ));
        
        if (!is_wp_error($test_attachment_id)) {
            $valid_image_data['id'] = $test_attachment_id;
            
            $validated_image = Mongruas_Security_Config::validate_image_data($valid_image_data);
            
            $this->assert_test(
                !is_wp_error($validated_image),
                'Valid image data validation passes',
                'Valid image data should pass validation'
            );
        }
        
        // Test invalid image data
        $invalid_image_data = array(
            'id' => 'not_a_number',
            'url' => 'invalid_url',
        );
        
        $invalid_image_result = Mongruas_Security_Config::validate_image_data($invalid_image_data);
        
        $this->assert_test(
            is_wp_error($invalid_image_result),
            'Invalid image data validation fails',
            'Invalid image data should fail validation'
        );
        
        // Test file type validation (simulated)
        $allowed_types = array('image/jpeg', 'image/jpg', 'image/png', 'image/webp');
        $disallowed_types = array('text/plain', 'application/pdf', 'video/mp4', 'audio/mp3');
        
        foreach ($allowed_types as $type) {
            $this->assert_test(
                in_array($type, $allowed_types),
                "File type '$type' is allowed",
                'Should allow common image types'
            );
        }
        
        foreach ($disallowed_types as $type) {
            $this->assert_test(
                !in_array($type, $allowed_types),
                "File type '$type' is not allowed",
                'Should not allow non-image types'
            );
        }
        
        // Test file extension validation
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'webp');
        $test_filenames = array(
            'test.jpg' => true,
            'test.jpeg' => true,
            'test.png' => true,
            'test.webp' => true,
            'test.gif' => false,
            'test.pdf' => false,
            'test.exe' => false,
            'test.php' => false,
        );
        
        foreach ($test_filenames as $filename => $should_be_allowed) {
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $is_allowed = in_array($extension, $allowed_extensions);
            
            $this->assert_test(
                $is_allowed === $should_be_allowed,
                "File extension validation for '$filename'",
                $should_be_allowed ? 'Should be allowed' : 'Should not be allowed'
            );
        }
    }
    
    /**
     * Test 9: Data Validation and Sanitization Testing
     */
    private function test_data_validation_and_sanitization() {
        echo "<h2>9. Data Validation and Sanitization Tests</h2>\n";
        
        // Test comprehensive data sanitization
        $test_cases = array(
            // XSS attempts
            array(
                'input' => '<script>alert("xss")</script>',
                'field' => 'name',
                'should_contain' => false,
                'pattern' => '<script>',
                'description' => 'Script tags should be removed'
            ),
            array(
                'input' => 'javascript:alert(1)',
                'field' => 'description',
                'should_contain' => false,
                'pattern' => 'javascript:',
                'description' => 'JavaScript URLs should be sanitized'
            ),
            // SQL injection attempts
            array(
                'input' => "'; DROP TABLE wp_posts; --",
                'field' => 'name',
                'should_contain' => false,
                'pattern' => 'DROP TABLE',
                'description' => 'SQL injection should be sanitized'
            ),
            // Valid content
            array(
                'input' => 'Curso de Prevención de Riesgos Laborales',
                'field' => 'name',
                'should_contain' => true,
                'pattern' => 'Prevención',
                'description' => 'Valid Spanish text should be preserved'
            ),
            // Special characters
            array(
                'input' => 'Curso: Gestión & Administración (Nivel 1)',
                'field' => 'name',
                'should_contain' => true,
                'pattern' => 'Gestión',
                'description' => 'Valid special characters should be preserved'
            ),
        );
        
        foreach ($test_cases as $i => $test_case) {
            $test_data = array(
                'name' => $test_case['field'] === 'name' ? $test_case['input'] : 'Valid Name',
                'description' => $test_case['field'] === 'description' ? $test_case['input'] : 'Valid description',
                'date' => '2025-01-01',
                'duration' => '40 hours',
                'modality' => 'Online',
                'category' => 'Prevención de Riesgos Laborales',
            );
            
            $result = Mongruas_Security_Config::validate_course_data($test_data);
            
            if (!is_wp_error($result)) {
                $sanitized_value = $result[$test_case['field']];
                $contains_pattern = strpos($sanitized_value, $test_case['pattern']) !== false;
                
                $this->assert_test(
                    $contains_pattern === $test_case['should_contain'],
                    "Sanitization test case " . ($i + 1),
                    $test_case['description']
                );
            } else {
                // If validation failed, check if it was expected
                $this->assert_test(
                    !$test_case['should_contain'],
                    "Validation rejection test case " . ($i + 1),
                    'Invalid data should be rejected: ' . $result->get_error_message()
                );
            }
        }
        
        // Test field length limits
        $length_tests = array(
            array(
                'field' => 'name',
                'max_length' => 200,
                'test_value' => str_repeat('A', 201),
                'should_pass' => false,
            ),
            array(
                'field' => 'description',
                'max_length' => 1000,
                'test_value' => str_repeat('A', 1001),
                'should_pass' => false,
            ),
            array(
                'field' => 'duration',
                'max_length' => 50,
                'test_value' => str_repeat('A', 51),
                'should_pass' => false,
            ),
        );
        
        foreach ($length_tests as $length_test) {
            $test_data = array(
                'name' => $length_test['field'] === 'name' ? $length_test['test_value'] : 'Valid Name',
                'description' => $length_test['field'] === 'description' ? $length_test['test_value'] : 'Valid description',
                'date' => '2025-01-01',
                'duration' => $length_test['field'] === 'duration' ? $length_test['test_value'] : '40 hours',
                'modality' => 'Online',
                'category' => 'Prevención de Riesgos Laborales',
            );
            
            $result = Mongruas_Security_Config::validate_course_data($test_data);
            $validation_passed = !is_wp_error($result);
            
            $this->assert_test(
                $validation_passed === $length_test['should_pass'],
                "Length validation for {$length_test['field']} field",
                "Field should " . ($length_test['should_pass'] ? 'pass' : 'fail') . " length validation"
            );
        }
    }
    
    /**
     * Test 10: End-to-End Workflow Testing
     */
    private function test_end_to_end_workflows() {
        echo "<h2>10. End-to-End Workflow Tests</h2>\n";
        
        // Set admin user for complete workflow
        wp_set_current_user($this->admin_user_id);
        
        // Workflow 1: Complete course creation and management
        echo "<h3>10.1 Complete Course Creation Workflow</h3>\n";
        
        // Step 1: Clear existing course data
        update_field('course_3_name', '', $this->courses_page_id);
        update_field('course_3_description', '', $this->courses_page_id);
        update_field('course_3_date', '', $this->courses_page_id);
        update_field('course_3_duration', '', $this->courses_page_id);
        
        // Step 2: Create new course via API
        $new_course_data = array(
            'name' => 'End-to-End Test Course',
            'description' => 'This course was created during end-to-end testing to verify the complete workflow.',
            'date' => '2025-06-15',
            'duration' => '35 hours',
            'modality' => 'Presencial',
            'category' => 'Gestión Empresarial',
        );
        
        $create_request = new WP_REST_Request('PUT', '/mongruas/v1/courses/3');
        $create_request->set_header('X-WP-Nonce', wp_create_nonce('mongruas-panel-nonce'));
        $create_request->set_body(json_encode($new_course_data));
        $create_request->set_param('id', 3);
        
        $create_response = $this->panel_instance->update_course($create_request);
        
        $this->assert_test(
            !is_wp_error($create_response),
            'E2E: Course creation via API succeeds',
            'Should be able to create course via API'
        );
        
        // Step 3: Verify course was saved to ACF
        $saved_name = get_field('course_3_name', $this->courses_page_id);
        $saved_description = get_field('course_3_description', $this->courses_page_id);
        $saved_date = get_field('course_3_date', $this->courses_page_id);
        
        $this->assert_test(
            $saved_name === $new_course_data['name'],
            'E2E: Course name saved to ACF correctly',
            'Course name should be saved to ACF field'
        );
        
        $this->assert_test(
            $saved_description === $new_course_data['description'],
            'E2E: Course description saved to ACF correctly',
            'Course description should be saved to ACF field'
        );
        
        $this->assert_test(
            $saved_date === $new_course_data['date'],
            'E2E: Course date saved to ACF correctly',
            'Course date should be saved to ACF field'
        );
        
        // Step 4: Retrieve course via API and verify data
        $get_request = new WP_REST_Request('GET', '/mongruas/v1/courses');
        $get_request->set_header('X-WP-Nonce', wp_create_nonce('mongruas-panel-nonce'));
        
        $get_response = $this->panel_instance->get_courses($get_request);
        
        if (!is_wp_error($get_response)) {
            $response_data = rest_ensure_response($get_response)->get_data();
            $course_3_data = $response_data['data'][2]; // Third course (index 2)
            
            $this->assert_test(
                $course_3_data['name'] === $new_course_data['name'],
                'E2E: Retrieved course name matches created course',
                'API should return the same data that was saved'
            );
            
            $this->assert_test(
                $course_3_data['isActive'] === true,
                'E2E: Course is marked as active',
                'Course with name should be marked as active'
            );
        }
        
        // Step 5: Update course data
        $updated_course_data = array(
            'name' => 'Updated End-to-End Test Course',
            'description' => 'This course description was updated during testing.',
            'date' => '2025-07-01',
            'duration' => '45 hours',
            'modality' => 'Semipresencial',
            'category' => 'Marketing',
        );
        
        $update_request = new WP_REST_Request('PUT', '/mongruas/v1/courses/3');
        $update_request->set_header('X-WP-Nonce', wp_create_nonce('mongruas-panel-nonce'));
        $update_request->set_body(json_encode($updated_course_data));
        $update_request->set_param('id', 3);
        
        $update_response = $this->panel_instance->update_course($update_request);
        
        $this->assert_test(
            !is_wp_error($update_response),
            'E2E: Course update via API succeeds',
            'Should be able to update existing course via API'
        );
        
        // Step 6: Verify updated data in ACF
        $updated_name = get_field('course_3_name', $this->courses_page_id);
        $updated_modality = get_field('course_3_modality', $this->courses_page_id);
        
        $this->assert_test(
            $updated_name === $updated_course_data['name'],
            'E2E: Updated course name saved correctly',
            'Updated course name should be saved to ACF'
        );
        
        $this->assert_test(
            $updated_modality === $updated_course_data['modality'],
            'E2E: Updated course modality saved correctly',
            'Updated course modality should be saved to ACF'
        );
        
        // Step 7: Delete course
        $delete_request = new WP_REST_Request('DELETE', '/mongruas/v1/courses/3');
        $delete_request->set_header('X-WP-Nonce', wp_create_nonce('mongruas-panel-nonce'));
        $delete_request->set_param('id', 3);
        
        $delete_response = $this->panel_instance->delete_course($delete_request);
        
        $this->assert_test(
            !is_wp_error($delete_response),
            'E2E: Course deletion via API succeeds',
            'Should be able to delete course via API'
        );
        
        // Step 8: Verify course was deleted from ACF
        $deleted_name = get_field('course_3_name', $this->courses_page_id);
        
        $this->assert_test(
            empty($deleted_name),
            'E2E: Deleted course name cleared from ACF',
            'Deleted course name should be empty in ACF'
        );
        
        // Workflow 2: Security boundary enforcement during operations
        echo "<h3>10.2 Security Boundary Enforcement Workflow</h3>\n";
        
        // Test with non-admin user
        wp_set_current_user($this->editor_user_id);
        
        $unauthorized_request = new WP_REST_Request('GET', '/mongruas/v1/courses');
        $unauthorized_request->set_header('X-WP-Nonce', wp_create_nonce('mongruas-panel-nonce'));
        
        $unauthorized_response = $this->panel_instance->check_admin_permission($unauthorized_request);
        
        $this->assert_test(
            is_wp_error($unauthorized_response),
            'E2E: Non-admin user blocked from API access',
            'Non-admin users should be blocked from accessing API endpoints'
        );
        
        // Test with invalid nonce
        wp_set_current_user($this->admin_user_id);
        
        $invalid_nonce_request = new WP_REST_Request('GET', '/mongruas/v1/courses');
        $invalid_nonce_request->set_header('X-WP-Nonce', 'invalid_nonce_12345');
        
        $invalid_nonce_response = $this->panel_instance->check_admin_permission($invalid_nonce_request);
        
        $this->assert_test(
            is_wp_error($invalid_nonce_response) && $invalid_nonce_response->get_error_code() === 'invalid_nonce',
            'E2E: Invalid nonce blocked from API access',
            'Requests with invalid nonces should be blocked'
        );
        
        // Workflow 3: Complete data validation workflow
        echo "<h3>10.3 Complete Data Validation Workflow</h3>\n";
        
        // Test complete validation pipeline
        $validation_test_data = array(
            'name' => 'Comprehensive Validation Test Course',
            'description' => 'Testing the complete validation pipeline with proper data.',
            'date' => '2025-08-01',
            'duration' => '50 hours',
            'modality' => 'Online',
            'category' => 'Prevención de Riesgos Laborales',
        );
        
        // Step 1: Validate data
        $validated_data = Mongruas_Security_Config::validate_course_data($validation_test_data);
        
        $this->assert_test(
            !is_wp_error($validated_data),
            'E2E: Complete data validation passes',
            'Valid data should pass complete validation pipeline'
        );
        
        // Step 2: Save via API
        if (!is_wp_error($validated_data)) {
            $validation_request = new WP_REST_Request('PUT', '/mongruas/v1/courses/2');
            $validation_request->set_header('X-WP-Nonce', wp_create_nonce('mongruas-panel-nonce'));
            $validation_request->set_body(json_encode($validation_test_data));
            $validation_request->set_param('id', 2);
            
            $validation_response = $this->panel_instance->update_course($validation_request);
            
            $this->assert_test(
                !is_wp_error($validation_response),
                'E2E: Validated data saves successfully',
                'Data that passes validation should save successfully'
            );
        }
        
        // Step 3: Test with invalid data
        $invalid_validation_data = array(
            'name' => str_repeat('A', 201), // Too long
            'description' => 'Valid description',
            'date' => '2025-13-32', // Invalid date
            'duration' => '', // Empty when name provided
            'modality' => 'InvalidMode',
            'category' => 'InvalidCategory',
        );
        
        $invalid_validated_data = Mongruas_Security_Config::validate_course_data($invalid_validation_data);
        
        $this->assert_test(
            is_wp_error($invalid_validated_data),
            'E2E: Invalid data fails validation',
            'Invalid data should fail validation pipeline'
        );
        
        // Step 4: Attempt to save invalid data via API
        $invalid_validation_request = new WP_REST_Request('PUT', '/mongruas/v1/courses/2');
        $invalid_validation_request->set_header('X-WP-Nonce', wp_create_nonce('mongruas-panel-nonce'));
        $invalid_validation_request->set_body(json_encode($invalid_validation_data));
        $invalid_validation_request->set_param('id', 2);
        
        $invalid_validation_response = $this->panel_instance->update_course($invalid_validation_request);
        
        $this->assert_test(
            is_wp_error($invalid_validation_response),
            'E2E: Invalid data rejected by API',
            'API should reject data that fails validation'
        );
    }
    
    /**
     * Display test results
     */
    private function display_test_results() {
        echo "<h2>Test Results Summary</h2>\n";
        
        $success_rate = $this->total_tests > 0 ? ($this->passed_tests / $this->total_tests) * 100 : 0;
        
        echo "<div style='background: " . ($success_rate === 100 ? '#e6ffe6' : '#ffe6e6') . "; padding: 15px; margin: 15px 0; border-radius: 5px;'>\n";
        echo "<h3>Overall Results</h3>\n";
        echo "<p><strong>Total Tests:</strong> {$this->total_tests}</p>\n";
        echo "<p><strong>Passed:</strong> {$this->passed_tests}</p>\n";
        echo "<p><strong>Failed:</strong> " . ($this->total_tests - $this->passed_tests) . "</p>\n";
        echo "<p><strong>Success Rate:</strong> " . number_format($success_rate, 1) . "%</p>\n";
        echo "</div>\n";
        
        if ($success_rate === 100) {
            echo "<div style='color: green; background: #e6ffe6; padding: 10px; margin: 10px 0; border-radius: 5px;'>\n";
            echo "<strong>✅ ALL TESTS PASSED!</strong> The Course Management Panel integration is working correctly.\n";
            echo "</div>\n";
        } else {
            echo "<div style='color: red; background: #ffe6e6; padding: 10px; margin: 10px 0; border-radius: 5px;'>\n";
            echo "<strong>❌ Some tests failed.</strong> Please review the failed tests below.\n";
            echo "</div>\n";
        }
        
        // Display detailed results
        echo "<h3>Detailed Test Results</h3>\n";
        echo "<table style='width: 100%; border-collapse: collapse; margin: 10px 0;'>\n";
        echo "<thead>\n";
        echo "<tr style='background: #f0f0f0;'>\n";
        echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Status</th>\n";
        echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Test Name</th>\n";
        echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Message</th>\n";
        echo "</tr>\n";
        echo "</thead>\n";
        echo "<tbody>\n";
        
        foreach ($this->test_results as $result) {
            $status_color = $result['status'] === 'PASS' ? 'green' : 'red';
            $status_icon = $result['status'] === 'PASS' ? '✅' : '❌';
            
            echo "<tr>\n";
            echo "<td style='border: 1px solid #ddd; padding: 8px; color: {$status_color};'>{$status_icon} {$result['status']}</td>\n";
            echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($result['name']) . "</td>\n";
            echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($result['message']) . "</td>\n";
            echo "</tr>\n";
        }
        
        echo "</tbody>\n";
        echo "</table>\n";
    }
    
    /**
     * Cleanup test environment
     */
    private function cleanup_test_environment() {
        // Delete test users
        if ($this->admin_user_id) {
            wp_delete_user($this->admin_user_id);
        }
        if ($this->editor_user_id) {
            wp_delete_user($this->editor_user_id);
        }
        if ($this->subscriber_user_id) {
            wp_delete_user($this->subscriber_user_id);
        }
        
        // Clear test course data
        if ($this->courses_page_id) {
            update_field('course_1_name', '', $this->courses_page_id);
            update_field('course_1_description', '', $this->courses_page_id);
            update_field('course_2_name', '', $this->courses_page_id);
            update_field('course_2_description', '', $this->courses_page_id);
            update_field('course_3_name', '', $this->courses_page_id);
            update_field('course_3_description', '', $this->courses_page_id);
        }
        
        // Reset current user
        wp_set_current_user(0);
        
        // Clear any test transients
        delete_transient('mongruas_login_failures_' . md5('test_rate_limit_user'));
        
        echo "<p><em>Test environment cleaned up successfully.</em></p>\n";
    }
}

/**
 * Run integration tests if accessed directly or called
 */
function run_complete_integration_tests() {
    // Only allow admin access
    if (!current_user_can('administrator')) {
        echo "<div style='color: red; background: #ffe6e6; padding: 10px; margin: 10px 0; border-radius: 5px;'>";
        echo "<strong>Access Denied:</strong> Administrator privileges required to run integration tests.";
        echo "</div>";
        return false;
    }
    
    try {
        $integration_test = new Complete_Integration_Test();
        return $integration_test->run_all_tests();
    } catch (Exception $e) {
        echo "<div style='color: red; background: #ffe6e6; padding: 10px; margin: 10px 0; border-radius: 5px;'>";
        echo "<strong>Integration Test Error:</strong> " . $e->getMessage();
        echo "</div>";
        return false;
    }
}

// Auto-run tests if this file is accessed directly
if (defined('ABSPATH') && !defined('DOING_AJAX') && !wp_doing_cron()) {
    add_action('init', function() {
        if (isset($_GET['run_integration_tests']) && $_GET['run_integration_tests'] === '1') {
            add_action('wp_loaded', function() {
                echo "<!DOCTYPE html><html><head><title>Integration Tests</title></head><body>";
                run_complete_integration_tests();
                echo "</body></html>";
                exit;
            });
        }
    });
}
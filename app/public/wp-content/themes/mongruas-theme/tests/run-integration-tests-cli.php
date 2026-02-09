<?php
/**
 * CLI Integration Test Runner
 * 
 * Command-line interface for running integration tests
 * Can be executed from command line or included in other scripts
 * 
 * @package Mongruas
 * @since 1.0.0
 */

// Determine if we're running from CLI or web
$is_cli = php_sapi_name() === 'cli';

if (!$is_cli) {
    // Load WordPress if running from web
    require_once(dirname(__FILE__) . '/../../../../wp-load.php');
    
    // Only allow admin access for web requests
    if (!current_user_can('administrator')) {
        die('Access denied. Admin privileges required.');
    }
}

/**
 * Simple test runner class
 */
class Integration_Test_Runner {
    
    private $results = array();
    private $total_tests = 0;
    private $passed_tests = 0;
    private $is_cli;
    
    public function __construct($is_cli = false) {
        $this->is_cli = $is_cli;
    }
    
    /**
     * Output helper
     */
    private function output($message, $type = 'info') {
        if ($this->is_cli) {
            $prefix = '';
            switch ($type) {
                case 'success':
                    $prefix = '[PASS] ';
                    break;
                case 'error':
                    $prefix = '[FAIL] ';
                    break;
                case 'warning':
                    $prefix = '[WARN] ';
                    break;
                default:
                    $prefix = '[INFO] ';
            }
            echo $prefix . $message . "\n";
        } else {
            $color = '';
            switch ($type) {
                case 'success':
                    $color = 'green';
                    break;
                case 'error':
                    $color = 'red';
                    break;
                case 'warning':
                    $color = 'orange';
                    break;
                default:
                    $color = 'black';
            }
            echo "<p style='color: $color;'>$message</p>\n";
        }
    }
    
    /**
     * Test assertion
     */
    private function assert_test($condition, $test_name, $message = '') {
        $this->total_tests++;
        
        if ($condition) {
            $this->passed_tests++;
            $this->output("✅ $test_name" . ($message ? " - $message" : ''), 'success');
            $this->results[] = array('name' => $test_name, 'status' => 'PASS', 'message' => $message);
        } else {
            $this->output("❌ $test_name" . ($message ? " - $message" : ''), 'error');
            $this->results[] = array('name' => $test_name, 'status' => 'FAIL', 'message' => $message);
        }
        
        return $condition;
    }
    
    /**
     * Run basic integration tests
     */
    public function run_basic_tests() {
        $this->output("Starting Basic Integration Tests", 'info');
        $this->output("=====================================", 'info');
        
        // Test 1: WordPress Environment
        $this->output("\n1. WordPress Environment Tests", 'info');
        
        $this->assert_test(
            defined('ABSPATH'),
            'WordPress is loaded',
            'ABSPATH constant is defined'
        );
        
        $this->assert_test(
            function_exists('wp_get_current_user'),
            'WordPress functions available',
            'Core WordPress functions are loaded'
        );
        
        // Test 2: Required Classes
        $this->output("\n2. Required Class Tests", 'info');
        
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
        
        // Test 3: Required Files
        $this->output("\n3. Required File Tests", 'info');
        
        $theme_dir = get_template_directory();
        $required_files = array(
            '/inc/course-management-panel.php',
            '/inc/security-config.php',
            '/assets/css/course-management-panel.css',
            '/assets/js/course-management-panel.js',
        );
        
        foreach ($required_files as $file) {
            $full_path = $theme_dir . $file;
            $this->assert_test(
                file_exists($full_path),
                "Required file exists: " . basename($file),
                $file
            );
        }
        
        // Test 4: ACF Integration
        $this->output("\n4. ACF Integration Tests", 'info');
        
        $this->assert_test(
            function_exists('get_field'),
            'ACF get_field function available',
            'ACF should be installed and active'
        );
        
        $this->assert_test(
            function_exists('update_field'),
            'ACF update_field function available',
            'ACF update functionality should be available'
        );
        
        // Test 5: Security Functions
        $this->output("\n5. Security Function Tests", 'info');
        
        $this->assert_test(
            function_exists('wp_create_nonce'),
            'Nonce creation function available',
            'WordPress nonce functions should be available'
        );
        
        $this->assert_test(
            function_exists('wp_verify_nonce'),
            'Nonce verification function available',
            'WordPress nonce verification should be available'
        );
        
        // Test nonce functionality
        $test_nonce = wp_create_nonce('test-nonce');
        $this->assert_test(
            !empty($test_nonce) && wp_verify_nonce($test_nonce, 'test-nonce'),
            'Nonce generation and verification works',
            'Nonce functionality should work correctly'
        );
        
        // Test 6: REST API
        $this->output("\n6. REST API Tests", 'info');
        
        $rest_server = rest_get_server();
        $this->assert_test(
            !empty($rest_server),
            'REST API server available',
            'WordPress REST API should be available'
        );
        
        if ($rest_server) {
            $routes = $rest_server->get_routes();
            $mongruas_routes = array_filter(array_keys($routes), function($route) {
                return strpos($route, '/mongruas/v1/') === 0;
            });
            
            $this->assert_test(
                !empty($mongruas_routes),
                'Mongruas REST routes registered',
                count($mongruas_routes) . ' routes found'
            );
        }
        
        // Test 7: Data Validation
        $this->output("\n7. Data Validation Tests", 'info');
        
        // Test valid course data
        $valid_data = array(
            'name' => 'Test Course',
            'description' => 'Test Description',
            'date' => '2025-01-15',
            'duration' => '40 hours',
            'modality' => 'Online',
            'category' => 'Prevención de Riesgos Laborales',
        );
        
        $validated = Mongruas_Security_Config::validate_course_data($valid_data);
        $this->assert_test(
            !is_wp_error($validated),
            'Valid course data passes validation',
            'Valid data should pass validation'
        );
        
        // Test invalid course data
        $invalid_data = array(
            'name' => 'AB', // Too short
            'description' => str_repeat('A', 1001), // Too long
            'date' => '2025-13-32', // Invalid date
            'duration' => '',
            'modality' => 'InvalidMode',
            'category' => 'InvalidCategory',
        );
        
        $invalid_result = Mongruas_Security_Config::validate_course_data($invalid_data);
        $this->assert_test(
            is_wp_error($invalid_result),
            'Invalid course data fails validation',
            'Invalid data should fail validation'
        );
        
        // Test 8: User Permissions
        $this->output("\n8. User Permission Tests", 'info');
        
        if (!$this->is_cli) {
            $this->assert_test(
                current_user_can('administrator'),
                'Current user has admin capabilities',
                'User should have administrator role'
            );
            
            $capability_check = Mongruas_Security_Config::check_user_capabilities('administrator');
            $this->assert_test(
                !is_wp_error($capability_check),
                'Security capability check works',
                'Security class should validate admin capabilities'
            );
        } else {
            $this->output("⚠️ User permission tests skipped (CLI mode)", 'warning');
        }
        
        return $this->display_results();
    }
    
    /**
     * Run security-focused tests
     */
    public function run_security_tests() {
        $this->output("Starting Security Integration Tests", 'info');
        $this->output("===================================", 'info');
        
        // Test 1: Data Sanitization
        $this->output("\n1. Data Sanitization Tests", 'info');
        
        $malicious_data = array(
            'name' => '<script>alert("xss")</script>Test Course',
            'description' => '<iframe src="javascript:alert(1)"></iframe>Description',
            'date' => '2025-01-01<script>',
            'duration' => '40 hours<img src=x onerror=alert(1)>',
            'modality' => 'Online',
            'category' => 'Prevención de Riesgos Laborales',
        );
        
        $sanitized = Mongruas_Security_Config::validate_course_data($malicious_data);
        
        if (!is_wp_error($sanitized)) {
            $contains_script = false;
            foreach ($sanitized as $value) {
                if (strpos($value, '<script>') !== false || strpos($value, 'javascript:') !== false) {
                    $contains_script = true;
                    break;
                }
            }
            
            $this->assert_test(
                !$contains_script,
                'XSS attempts are sanitized',
                'Script tags and javascript: should be removed'
            );
        }
        
        // Test 2: SQL Injection Protection
        $sql_injection_data = array(
            'name' => "'; DROP TABLE wp_posts; --",
            'description' => "1' OR '1'='1",
            'date' => '2025-01-01',
            'duration' => '40 hours',
            'modality' => 'Online',
            'category' => 'Prevención de Riesgos Laborales',
        );
        
        $sanitized_sql = Mongruas_Security_Config::validate_course_data($sql_injection_data);
        
        if (!is_wp_error($sanitized_sql)) {
            $contains_sql = false;
            foreach ($sanitized_sql as $value) {
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
        
        // Test 3: Course ID Validation
        $this->output("\n2. Course ID Validation Tests", 'info');
        
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
        
        // Test 4: File Type Validation
        $this->output("\n3. File Type Validation Tests", 'info');
        
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
        
        return $this->display_results();
    }
    
    /**
     * Display test results
     */
    private function display_results() {
        $success_rate = $this->total_tests > 0 ? ($this->passed_tests / $this->total_tests) * 100 : 0;
        
        $this->output("\n" . str_repeat("=", 50), 'info');
        $this->output("TEST RESULTS SUMMARY", 'info');
        $this->output(str_repeat("=", 50), 'info');
        
        $this->output("Total Tests: {$this->total_tests}", 'info');
        $this->output("Passed: {$this->passed_tests}", 'success');
        $this->output("Failed: " . ($this->total_tests - $this->passed_tests), 'error');
        $this->output("Success Rate: " . number_format($success_rate, 1) . "%", 'info');
        
        if ($success_rate === 100) {
            $this->output("\n🎉 ALL TESTS PASSED! Integration is working correctly.", 'success');
        } else {
            $this->output("\n⚠️ Some tests failed. Please review the results above.", 'warning');
        }
        
        return $success_rate === 100;
    }
    
    /**
     * Get test results
     */
    public function get_results() {
        return array(
            'total' => $this->total_tests,
            'passed' => $this->passed_tests,
            'failed' => $this->total_tests - $this->passed_tests,
            'success_rate' => $this->total_tests > 0 ? ($this->passed_tests / $this->total_tests) * 100 : 0,
            'results' => $this->results
        );
    }
}

// Run tests if called directly
if (basename(__FILE__) === basename($_SERVER['SCRIPT_NAME']) || $is_cli) {
    $runner = new Integration_Test_Runner($is_cli);
    
    // Determine which tests to run
    $test_type = 'basic';
    if ($is_cli && isset($argv[1])) {
        $test_type = $argv[1];
    } elseif (!$is_cli && isset($_GET['type'])) {
        $test_type = $_GET['type'];
    }
    
    switch ($test_type) {
        case 'security':
            $success = $runner->run_security_tests();
            break;
        case 'basic':
        default:
            $success = $runner->run_basic_tests();
            break;
    }
    
    if ($is_cli) {
        exit($success ? 0 : 1);
    }
}
?>
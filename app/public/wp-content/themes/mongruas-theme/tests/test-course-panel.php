<?php
/**
 * Basic tests for Course Management Panel
 * 
 * @package Mongruas
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Test Course Management Panel Basic Functionality
 */
function test_course_panel_basic() {
    $results = array();
    
    // Test 1: Check if class exists
    $results['class_exists'] = class_exists('Mongruas_Course_Management_Panel');
    
    // Test 2: Check if security class exists
    $results['security_class_exists'] = class_exists('Mongruas_Security_Config');
    
    // Test 3: Check if required files exist
    $required_files = array(
        MONGRUAS_THEME_DIR . '/inc/course-management-panel.php',
        MONGRUAS_THEME_DIR . '/inc/security-config.php',
        MONGRUAS_THEME_DIR . '/assets/css/course-management-panel.css',
        MONGRUAS_THEME_DIR . '/assets/js/course-management-panel.js',
    );
    
    $results['files_exist'] = true;
    foreach ($required_files as $file) {
        if (!file_exists($file)) {
            $results['files_exist'] = false;
            $results['missing_file'] = $file;
            break;
        }
    }
    
    // Test 4: Check if REST endpoints are registered
    $rest_server = rest_get_server();
    $routes = $rest_server->get_routes();
    $results['rest_endpoints'] = array(
        'auth_login' => isset($routes['/mongruas/v1/auth/login']),
        'courses' => isset($routes['/mongruas/v1/courses']),
        'media_upload' => isset($routes['/mongruas/v1/media/upload']),
    );
    
    // Test 5: Test data validation - Valid data
    $test_data = array(
        'name' => 'Test Course',
        'description' => 'Test Description',
        'date' => '2025-01-15',
        'duration' => '40 hours',
        'modality' => 'Online',
        'category' => 'Prevención de Riesgos Laborales',
    );
    
    $validated = Mongruas_Security_Config::validate_course_data($test_data);
    $results['data_validation_valid'] = !is_wp_error($validated) && is_array($validated);
    
    // Test 6: Test data validation - Invalid data
    $invalid_data = array(
        'name' => 'AB', // Too short
        'description' => str_repeat('A', 1001), // Too long
        'date' => '2025-13-32', // Invalid date
        'duration' => '', // Empty when name provided
        'modality' => 'InvalidMode',
        'category' => 'InvalidCategory',
    );
    
    $invalid_result = Mongruas_Security_Config::validate_course_data($invalid_data);
    $results['data_validation_invalid'] = is_wp_error($invalid_result);
    
    // Test 7: Test course ID validation
    $results['course_id_validation'] = array(
        'valid_id_1' => !is_wp_error(Mongruas_Security_Config::validate_course_id(1)),
        'valid_id_2' => !is_wp_error(Mongruas_Security_Config::validate_course_id(2)),
        'valid_id_3' => !is_wp_error(Mongruas_Security_Config::validate_course_id(3)),
        'invalid_id_0' => is_wp_error(Mongruas_Security_Config::validate_course_id(0)),
        'invalid_id_4' => is_wp_error(Mongruas_Security_Config::validate_course_id(4)),
    );
    
    // Test 8: Test empty course data (should be valid for inactive course)
    $empty_data = array(
        'name' => '',
        'description' => '',
        'date' => '',
        'duration' => '',
        'modality' => 'Online',
        'category' => 'Prevención de Riesgos Laborales',
    );
    
    $empty_result = Mongruas_Security_Config::validate_course_data($empty_data);
    $results['empty_course_validation'] = !is_wp_error($empty_result);
    
    return $results;
}

/**
 * Display test results (for debugging)
 */
function display_course_panel_test_results() {
    if (!current_user_can('administrator')) {
        return;
    }
    
    $results = test_course_panel_basic();
    
    echo '<div style="background: #f1f1f1; padding: 20px; margin: 20px; border-radius: 5px;">';
    echo '<h3>Course Management Panel - Test Results</h3>';
    
    foreach ($results as $test => $result) {
        $status = is_bool($result) ? ($result ? '✅ PASS' : '❌ FAIL') : '📋 INFO';
        echo '<p><strong>' . ucfirst(str_replace('_', ' ', $test)) . ':</strong> ' . $status;
        
        if (!is_bool($result)) {
            echo '<br><pre>' . print_r($result, true) . '</pre>';
        }
        
        echo '</p>';
    }
    
    echo '</div>';
}

// Add test results to admin footer for debugging
if (is_admin() && current_user_can('administrator')) {
    add_action('admin_footer', 'display_course_panel_test_results');
}
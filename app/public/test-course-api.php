<?php
/**
 * Simple test script for Course Management API
 * 
 * This script tests the basic functionality of the course management API
 * Run this from the browser while logged in as an administrator
 */

// Load WordPress
require_once('wp-load.php');

// Only allow admin access
if (!current_user_can('administrator')) {
    die('Access denied. Admin privileges required.');
}

echo '<h1>Course Management API Test</h1>';

// Test 1: Check if classes exist
echo '<h2>1. Class Existence Test</h2>';
echo 'Mongruas_Course_Management_Panel: ' . (class_exists('Mongruas_Course_Management_Panel') ? '✅ EXISTS' : '❌ MISSING') . '<br>';
echo 'Mongruas_Security_Config: ' . (class_exists('Mongruas_Security_Config') ? '✅ EXISTS' : '❌ MISSING') . '<br>';

// Test 2: Data validation tests
echo '<h2>2. Data Validation Tests</h2>';

// Valid course data
$valid_data = array(
    'name' => 'Test Course Name',
    'description' => 'This is a test course description.',
    'date' => '2025-02-15',
    'duration' => '40 hours',
    'modality' => 'Online',
    'category' => 'Prevención de Riesgos Laborales',
);

$result = Mongruas_Security_Config::validate_course_data($valid_data);
echo 'Valid data validation: ' . (!is_wp_error($result) ? '✅ PASS' : '❌ FAIL - ' . $result->get_error_message()) . '<br>';

// Invalid course data (name too short)
$invalid_data = array(
    'name' => 'AB',
    'description' => 'Test description',
    'date' => '2025-02-15',
    'duration' => '40 hours',
    'modality' => 'Online',
    'category' => 'Prevención de Riesgos Laborales',
);

$result = Mongruas_Security_Config::validate_course_data($invalid_data);
echo 'Invalid data validation (short name): ' . (is_wp_error($result) ? '✅ PASS' : '❌ FAIL') . '<br>';

// Empty course data (should be valid for inactive course)
$empty_data = array(
    'name' => '',
    'description' => '',
    'date' => '',
    'duration' => '',
    'modality' => 'Online',
    'category' => 'Prevención de Riesgos Laborales',
);

$result = Mongruas_Security_Config::validate_course_data($empty_data);
echo 'Empty data validation: ' . (!is_wp_error($result) ? '✅ PASS' : '❌ FAIL - ' . $result->get_error_message()) . '<br>';

// Test 3: Course ID validation
echo '<h2>3. Course ID Validation Tests</h2>';

for ($i = 0; $i <= 4; $i++) {
    $result = Mongruas_Security_Config::validate_course_id($i);
    $expected = in_array($i, [1, 2, 3]);
    $actual = !is_wp_error($result);
    $status = ($expected === $actual) ? '✅ PASS' : '❌ FAIL';
    echo "Course ID $i: $status<br>";
}

// Test 4: REST API endpoints registration
echo '<h2>4. REST API Endpoints Test</h2>';

$rest_server = rest_get_server();
$routes = $rest_server->get_routes();

$expected_routes = array(
    '/mongruas/v1/auth/login',
    '/mongruas/v1/auth/verify',
    '/mongruas/v1/auth/logout',
    '/mongruas/v1/courses',
    '/mongruas/v1/courses/reorder',
    '/mongruas/v1/media/upload',
);

foreach ($expected_routes as $route) {
    $exists = isset($routes[$route]);
    echo "$route: " . ($exists ? '✅ REGISTERED' : '❌ MISSING') . '<br>';
}

// Test 5: Security measures
echo '<h2>5. Security Measures Test</h2>';

// Test nonce validation
$test_nonce = wp_create_nonce('mongruas-panel-nonce');
$nonce_valid = Mongruas_Security_Config::validate_nonce($test_nonce);
echo 'Nonce validation: ' . ($nonce_valid ? '✅ PASS' : '❌ FAIL') . '<br>';

// Test capability check
$capability_check = Mongruas_Security_Config::check_user_capabilities('administrator');
echo 'Admin capability check: ' . (!is_wp_error($capability_check) ? '✅ PASS' : '❌ FAIL') . '<br>';

echo '<h2>Test Complete</h2>';
echo '<p>All tests completed. Check results above for any failures.</p>';
?>
<?php
/**
 * Access Button Functionality Verification Script
 * 
 * Simple verification script for task 7.1: Verify access button functionality
 * This script can be run directly to test the access button functionality
 * 
 * @package Mongruas
 * @since 1.0.0
 */

// Include WordPress
require_once dirname(__FILE__) . '/../../../../wp-config.php';

// Test results storage
$test_results = array();
$total_tests = 0;
$passed_tests = 0;

/**
 * Simple test assertion function
 */
function test_assert($condition, $test_name, $message = '') {
    global $test_results, $total_tests, $passed_tests;
    
    $total_tests++;
    $status = $condition ? 'PASS' : 'FAIL';
    
    if ($condition) {
        $passed_tests++;
    }
    
    $test_results[] = array(
        'name' => $test_name,
        'status' => $status,
        'message' => $message
    );
    
    echo sprintf("[%s] %s%s\n", $status, $test_name, $message ? " - $message" : '');
    
    return $condition;
}

/**
 * Test helper to capture output
 */
function capture_output($callback) {
    ob_start();
    call_user_func($callback);
    return ob_get_clean();
}

echo "=== Access Button Functionality Verification ===\n\n";

// Create test users
$admin_user_id = wp_create_user('test_admin_' . time(), 'test_password', 'admin@test.com');
$regular_user_id = wp_create_user('test_user_' . time(), 'test_password', 'user@test.com');

if (is_wp_error($admin_user_id) || is_wp_error($regular_user_id)) {
    echo "ERROR: Could not create test users\n";
    exit(1);
}

// Set admin role
$admin_user = new WP_User($admin_user_id);
$admin_user->set_role('administrator');

// Initialize the course management panel
$panel_instance = new Mongruas_Course_Management_Panel();

echo "Test 1: Button visibility for admin users only\n";

// Test with admin user
wp_set_current_user($admin_user_id);
$admin_output = capture_output(function() use ($panel_instance) {
    $panel_instance->render_panel_html();
});

test_assert(
    strpos($admin_output, 'mongruas-panel-access') !== false,
    'Admin user sees access button',
    'Access button container should be present for admin users'
);

test_assert(
    strpos($admin_output, 'mongruas-panel-trigger') !== false,
    'Admin user sees trigger button',
    'Trigger button should be present for admin users'
);

test_assert(
    strpos($admin_output, 'Gestionar Cursos') !== false,
    'Admin user sees button title',
    'Button should have proper title attribute'
);

// Test with regular user
wp_set_current_user($regular_user_id);
$regular_output = capture_output(function() use ($panel_instance) {
    $panel_instance->render_panel_html();
});

test_assert(
    strpos($regular_output, 'mongruas-panel-access') === false,
    'Regular user does not see access button',
    'Access button should not be present for regular users'
);

test_assert(
    empty(trim($regular_output)),
    'Regular user gets empty output',
    'No panel HTML should be rendered for regular users'
);

// Test with no user (logged out)
wp_set_current_user(0);
$logged_out_output = capture_output(function() use ($panel_instance) {
    $panel_instance->render_panel_html();
});

test_assert(
    empty(trim($logged_out_output)),
    'Logged out user gets empty output',
    'No panel HTML should be rendered when logged out'
);

echo "\nTest 2: Modal structure and elements\n";

wp_set_current_user($admin_user_id);
$modal_output = capture_output(function() use ($panel_instance) {
    $panel_instance->render_panel_html();
});

// Test modal structure
test_assert(
    strpos($modal_output, 'mongruas-panel-modal') !== false,
    'Modal container is present',
    'Main modal container should be rendered'
);

test_assert(
    strpos($modal_output, 'mongruas-panel-overlay') !== false,
    'Modal overlay is present',
    'Modal overlay should be rendered'
);

test_assert(
    strpos($modal_output, 'Panel de Gestión de Cursos') !== false,
    'Modal title is present',
    'Modal should have proper title'
);

test_assert(
    strpos($modal_output, 'mongruas-panel-close') !== false,
    'Close button is present',
    'Modal should have close button'
);

// Test login form elements
test_assert(
    strpos($modal_output, 'mongruas-login-form') !== false,
    'Login form is present',
    'Login form should be rendered'
);

test_assert(
    strpos($modal_output, 'panel-username') !== false,
    'Username field is present',
    'Username input field should be rendered'
);

test_assert(
    strpos($modal_output, 'panel-password') !== false,
    'Password field is present',
    'Password input field should be rendered'
);

// Test main panel elements
test_assert(
    strpos($modal_output, 'mongruas-main-panel') !== false,
    'Main panel is present',
    'Main panel container should be rendered'
);

test_assert(
    strpos($modal_output, 'courses-list') !== false,
    'Courses list is present',
    'Courses list container should be rendered'
);

test_assert(
    strpos($modal_output, 'course-editor') !== false,
    'Course editor is present',
    'Course editor container should be rendered'
);

test_assert(
    strpos($modal_output, 'course-preview') !== false,
    'Course preview is present',
    'Course preview container should be rendered'
);

echo "\nTest 3: Assets enqueuing for admin users\n";

// Reset and test asset enqueuing
wp_dequeue_style('mongruas-panel-style');
wp_dequeue_script('mongruas-panel-script');

wp_set_current_user($admin_user_id);
do_action('wp_enqueue_scripts');

test_assert(
    wp_style_is('mongruas-panel-style', 'enqueued'),
    'CSS is enqueued for admin',
    'Panel CSS should be enqueued for admin users'
);

test_assert(
    wp_script_is('mongruas-panel-script', 'enqueued'),
    'JavaScript is enqueued for admin',
    'Panel JavaScript should be enqueued for admin users'
);

echo "\nTest 4: Assets NOT enqueued for regular users\n";

// Reset and test with regular user
wp_dequeue_style('mongruas-panel-style');
wp_dequeue_script('mongruas-panel-script');

wp_set_current_user($regular_user_id);
do_action('wp_enqueue_scripts');

test_assert(
    !wp_style_is('mongruas-panel-style', 'enqueued'),
    'CSS is NOT enqueued for regular user',
    'Panel CSS should not be enqueued for regular users'
);

test_assert(
    !wp_script_is('mongruas-panel-script', 'enqueued'),
    'JavaScript is NOT enqueued for regular user',
    'Panel JavaScript should not be enqueued for regular users'
);

echo "\nTest 5: Accessibility attributes\n";

wp_set_current_user($admin_user_id);
$accessibility_output = capture_output(function() use ($panel_instance) {
    $panel_instance->render_panel_html();
});

test_assert(
    strpos($accessibility_output, 'title="Gestionar Cursos"') !== false,
    'Button has title attribute',
    'Button should have title attribute for screen readers'
);

test_assert(
    strpos($accessibility_output, '<label for="panel-username">Usuario:</label>') !== false,
    'Username field has label',
    'Username field should have proper label'
);

test_assert(
    strpos($accessibility_output, '<label for="panel-password">Contraseña:</label>') !== false,
    'Password field has label',
    'Password field should have proper label'
);

test_assert(
    strpos($accessibility_output, 'id="panel-username" name="username" required') !== false,
    'Username field has proper attributes',
    'Username field should have ID, name, and required attributes'
);

test_assert(
    strpos($accessibility_output, 'id="panel-password" name="password" required') !== false,
    'Password field has proper attributes',
    'Password field should have ID, name, and required attributes'
);

echo "\nTest 6: Modal initial state (hidden)\n";

test_assert(
    strpos($accessibility_output, 'style="display: none;"') !== false,
    'Modal is hidden by default',
    'Modal should be hidden by default'
);

test_assert(
    strpos($accessibility_output, 'id="mongruas-main-panel" class="mongruas-main-panel" style="display: none;"') !== false,
    'Main panel is hidden initially',
    'Main panel should be hidden initially'
);

echo "\nTest 7: SVG icons are present\n";

test_assert(
    strpos($accessibility_output, '<svg width="20" height="20"') !== false,
    'Trigger button SVG is present',
    'Trigger button should have SVG icon'
);

test_assert(
    substr_count($accessibility_output, '<svg') >= 2,
    'Multiple SVG icons present',
    'Should have SVG icons for trigger and close buttons'
);

test_assert(
    strpos($accessibility_output, 'viewBox="0 0 24 24"') !== false,
    'SVG has proper viewBox',
    'SVG should have proper viewBox attribute'
);

echo "\nTest 8: JavaScript localization data\n";

wp_set_current_user($admin_user_id);
do_action('wp_enqueue_scripts');

global $wp_scripts;
$script_data = $wp_scripts->get_data('mongruas-panel-script', 'data');

test_assert(
    strpos($script_data, 'mongruasPanelAjax') !== false,
    'Localization object is present',
    'JavaScript should have localization object'
);

test_assert(
    strpos($script_data, '"ajaxurl":') !== false,
    'AJAX URL is present',
    'Localization should include AJAX URL'
);

test_assert(
    strpos($script_data, '"resturl":') !== false,
    'REST URL is present',
    'Localization should include REST URL'
);

test_assert(
    strpos($script_data, '"nonce":') !== false,
    'Nonce is present',
    'Localization should include security nonce'
);

test_assert(
    strpos($script_data, '"is_admin":true') !== false,
    'Admin flag is correct',
    'Localization should correctly identify admin user'
);

echo "\nTest 9: Responsive design elements\n";

test_assert(
    strpos($accessibility_output, 'panel-sidebar') !== false,
    'Sidebar element is present',
    'Panel should have sidebar for responsive design'
);

test_assert(
    strpos($accessibility_output, 'panel-main') !== false,
    'Main area element is present',
    'Panel should have main area for responsive design'
);

test_assert(
    strpos($accessibility_output, 'form-group') !== false,
    'Form groups are present',
    'Forms should use proper grouping for responsive design'
);

echo "\nTest 10: Security and validation\n";

test_assert(
    strpos($accessibility_output, 'type="submit" class="btn-primary"') !== false,
    'Submit button is present',
    'Form should have proper submit button'
);

test_assert(
    strpos($accessibility_output, 'id="login-error" class="error-message" style="display: none;"') !== false,
    'Error message container is present',
    'Form should have error message container'
);

// Clean up test users
wp_delete_user($admin_user_id);
wp_delete_user($regular_user_id);

// Reset current user
wp_set_current_user(0);

echo "\n=== Test Results Summary ===\n";
echo sprintf("Total Tests: %d\n", $total_tests);
echo sprintf("Passed: %d\n", $passed_tests);
echo sprintf("Failed: %d\n", $total_tests - $passed_tests);
echo sprintf("Success Rate: %.1f%%\n", ($passed_tests / $total_tests) * 100);

if ($passed_tests === $total_tests) {
    echo "\n✅ ALL TESTS PASSED! Access button functionality is working correctly.\n";
    exit(0);
} else {
    echo "\n❌ Some tests failed. Please review the implementation.\n";
    exit(1);
}
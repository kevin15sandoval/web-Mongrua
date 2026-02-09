<?php
/**
 * Simple verification script for integration tests
 * 
 * This script verifies that the integration test files are properly structured
 * and can be loaded without syntax errors.
 */

// Load WordPress
require_once('wp-load.php');

// Only allow admin access
if (!current_user_can('administrator')) {
    die('Access denied. Admin privileges required.');
}

echo "<h1>Integration Test Verification</h1>\n";

// Test 1: Check if integration test file exists and can be included
echo "<h2>1. File Existence and Syntax Check</h2>\n";

$integration_test_file = get_template_directory() . '/tests/integration-test-complete.php';

if (file_exists($integration_test_file)) {
    echo "✅ Integration test file exists: $integration_test_file<br>\n";
    
    // Try to include the file
    try {
        require_once($integration_test_file);
        echo "✅ Integration test file loaded successfully<br>\n";
        
        // Check if the class exists
        if (class_exists('Complete_Integration_Test')) {
            echo "✅ Complete_Integration_Test class is available<br>\n";
            
            // Try to instantiate the class (this will test constructor)
            try {
                // We need to be careful here as the constructor creates test users
                echo "⚠️ Class instantiation test skipped (would create test users)<br>\n";
            } catch (Exception $e) {
                echo "❌ Class instantiation failed: " . $e->getMessage() . "<br>\n";
            }
        } else {
            echo "❌ Complete_Integration_Test class not found<br>\n";
        }
        
    } catch (ParseError $e) {
        echo "❌ Syntax error in integration test file: " . $e->getMessage() . "<br>\n";
    } catch (Exception $e) {
        echo "❌ Error loading integration test file: " . $e->getMessage() . "<br>\n";
    }
} else {
    echo "❌ Integration test file not found: $integration_test_file<br>\n";
}

// Test 2: Check if test runner file exists
echo "<h2>2. Test Runner Verification</h2>\n";

$test_runner_file = __DIR__ . '/run-integration-tests.php';

if (file_exists($test_runner_file)) {
    echo "✅ Test runner file exists: $test_runner_file<br>\n";
} else {
    echo "❌ Test runner file not found: $test_runner_file<br>\n";
}

// Test 3: Check required classes and functions
echo "<h2>3. Required Dependencies Check</h2>\n";

$required_classes = array(
    'Mongruas_Course_Management_Panel',
    'Mongruas_Security_Config',
);

foreach ($required_classes as $class) {
    if (class_exists($class)) {
        echo "✅ Required class exists: $class<br>\n";
    } else {
        echo "❌ Required class missing: $class<br>\n";
    }
}

$required_functions = array(
    'get_field',
    'update_field',
    'wp_create_nonce',
    'wp_verify_nonce',
    'current_user_can',
);

foreach ($required_functions as $function) {
    if (function_exists($function)) {
        echo "✅ Required function exists: $function<br>\n";
    } else {
        echo "❌ Required function missing: $function<br>\n";
    }
}

// Test 4: Check WordPress environment
echo "<h2>4. WordPress Environment Check</h2>\n";

echo "✅ WordPress loaded successfully<br>\n";
echo "✅ WordPress version: " . get_bloginfo('version') . "<br>\n";
echo "✅ Current theme: " . get_template() . "<br>\n";
echo "✅ Current user: " . wp_get_current_user()->user_login . "<br>\n";
echo "✅ User capabilities: " . (current_user_can('administrator') ? 'Administrator' : 'Not Administrator') . "<br>\n";

// Test 5: Check ACF availability
echo "<h2>5. ACF Integration Check</h2>\n";

if (function_exists('get_field')) {
    echo "✅ ACF is available<br>\n";
    
    // Check if courses page exists
    $courses_page = get_page_by_path('cursos');
    if ($courses_page) {
        echo "✅ Courses page exists (ID: {$courses_page->ID})<br>\n";
        
        // Try to get a field value
        $test_field = get_field('course_1_name', $courses_page->ID);
        echo "✅ ACF field access works (course_1_name: " . ($test_field ? $test_field : 'empty') . ")<br>\n";
    } else {
        echo "⚠️ Courses page not found (will be created during tests)<br>\n";
    }
} else {
    echo "❌ ACF is not available<br>\n";
}

// Test 6: Check REST API
echo "<h2>6. REST API Check</h2>\n";

$rest_server = rest_get_server();
if ($rest_server) {
    echo "✅ REST API server is available<br>\n";
    
    $routes = $rest_server->get_routes();
    $mongruas_routes = array_filter(array_keys($routes), function($route) {
        return strpos($route, '/mongruas/v1/') === 0;
    });
    
    if (!empty($mongruas_routes)) {
        echo "✅ Mongruas REST routes registered: " . count($mongruas_routes) . " routes<br>\n";
        foreach ($mongruas_routes as $route) {
            echo "&nbsp;&nbsp;&nbsp;&nbsp;- $route<br>\n";
        }
    } else {
        echo "⚠️ No Mongruas REST routes found (may not be registered yet)<br>\n";
    }
} else {
    echo "❌ REST API server not available<br>\n";
}

echo "<h2>Verification Complete</h2>\n";
echo "<p>If all checks passed, the integration tests should run successfully.</p>\n";
echo "<p><a href='run-integration-tests.php'>Run Integration Tests</a></p>\n";
?>
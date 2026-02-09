<?php
/**
 * Integration Test Runner
 * 
 * Simple script to run the complete integration tests for the Course Management Panel
 * Access this file directly in the browser while logged in as an administrator
 * 
 * @package Mongruas
 * @since 1.0.0
 */

// Load WordPress
require_once('wp-load.php');

// Only allow admin access
if (!current_user_can('administrator')) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Integration Tests - Access Denied</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 40px; }
            .error { color: red; background: #ffe6e6; padding: 15px; border-radius: 5px; }
        </style>
    </head>
    <body>
        <h1>Integration Tests - Access Denied</h1>
        <div class="error">
            <strong>Access Denied:</strong> Administrator privileges required to run integration tests.
            <br><br>
            Please log in as an administrator and try again.
        </div>
    </body>
    </html>
    <?php
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Course Management Panel - Integration Tests</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        .header {
            background: #f0f0f0;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .success {
            color: green;
            background: #e6ffe6;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .error {
            color: red;
            background: #ffe6e6;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .info {
            color: blue;
            background: #e6f3ff;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #f0f0f0;
        }
        .pass {
            color: green;
        }
        .fail {
            color: red;
        }
        .nav-links {
            margin: 20px 0;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 5px;
        }
        .nav-links a {
            display: inline-block;
            margin-right: 15px;
            padding: 8px 15px;
            background: #0073aa;
            color: white;
            text-decoration: none;
            border-radius: 3px;
        }
        .nav-links a:hover {
            background: #005a87;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Course Management Panel - Integration Tests</h1>
        <p><strong>Task 10.1:</strong> Complete integration testing</p>
        <p>Testing all workflows end-to-end, WordPress ACF integration, user roles and permissions, and security boundary enforcement.</p>
        <p><strong>Current User:</strong> <?php echo wp_get_current_user()->user_login; ?> (Administrator)</p>
        <p><strong>WordPress Version:</strong> <?php echo get_bloginfo('version'); ?></p>
        <p><strong>Theme:</strong> <?php echo get_template(); ?></p>
    </div>

    <div class="nav-links">
        <a href="?run=1">Run All Integration Tests</a>
        <a href="?run=basic">Run Basic Tests Only</a>
        <a href="?run=security">Run Security Tests Only</a>
        <a href="?run=api">Run API Tests Only</a>
        <a href="<?php echo admin_url(); ?>">WordPress Admin</a>
        <a href="<?php echo home_url(); ?>">Site Home</a>
    </div>

    <?php
    // Include the integration test class
    require_once(get_template_directory() . '/tests/integration-test-complete.php');

    if (isset($_GET['run'])) {
        $test_type = $_GET['run'];
        
        echo "<div class='info'>";
        echo "<strong>Running Tests:</strong> " . ucfirst($test_type) . " integration tests";
        echo "</div>";
        
        try {
            if ($test_type === '1' || $test_type === 'all') {
                // Run all tests
                $integration_test = new Complete_Integration_Test();
                $success = $integration_test->run_all_tests();
                
                if ($success) {
                    echo "<div class='success'>";
                    echo "<strong>🎉 All Integration Tests Passed!</strong><br>";
                    echo "The Course Management Panel is working correctly and all requirements are met.";
                    echo "</div>";
                } else {
                    echo "<div class='error'>";
                    echo "<strong>⚠️ Some Integration Tests Failed</strong><br>";
                    echo "Please review the test results above and fix any issues.";
                    echo "</div>";
                }
                
            } elseif ($test_type === 'basic') {
                // Run basic system tests only
                echo "<h2>Basic System Tests</h2>";
                
                $basic_tests = array();
                $total = 0;
                $passed = 0;
                
                // Test class existence
                $total++;
                if (class_exists('Mongruas_Course_Management_Panel')) {
                    $passed++;
                    echo "<p class='pass'>✅ Course Management Panel class exists</p>";
                } else {
                    echo "<p class='fail'>❌ Course Management Panel class missing</p>";
                }
                
                $total++;
                if (class_exists('Mongruas_Security_Config')) {
                    $passed++;
                    echo "<p class='pass'>✅ Security Config class exists</p>";
                } else {
                    echo "<p class='fail'>❌ Security Config class missing</p>";
                }
                
                // Test file existence
                $required_files = array(
                    'inc/course-management-panel.php',
                    'inc/security-config.php',
                    'assets/css/course-management-panel.css',
                    'assets/js/course-management-panel.js',
                );
                
                foreach ($required_files as $file) {
                    $total++;
                    $full_path = get_template_directory() . '/' . $file;
                    if (file_exists($full_path)) {
                        $passed++;
                        echo "<p class='pass'>✅ File exists: $file</p>";
                    } else {
                        echo "<p class='fail'>❌ File missing: $file</p>";
                    }
                }
                
                echo "<div class='info'>";
                echo "<strong>Basic Tests Summary:</strong> $passed/$total tests passed (" . round(($passed/$total)*100, 1) . "%)";
                echo "</div>";
                
            } elseif ($test_type === 'security') {
                // Run security tests only
                echo "<h2>Security Tests</h2>";
                
                $total = 0;
                $passed = 0;
                
                // Test nonce functionality
                $total++;
                $nonce = wp_create_nonce('mongruas-panel-nonce');
                if (!empty($nonce) && wp_verify_nonce($nonce, 'mongruas-panel-nonce')) {
                    $passed++;
                    echo "<p class='pass'>✅ Nonce generation and validation works</p>";
                } else {
                    echo "<p class='fail'>❌ Nonce functionality failed</p>";
                }
                
                // Test capability checking
                $total++;
                $capability_check = Mongruas_Security_Config::check_user_capabilities('administrator');
                if (!is_wp_error($capability_check)) {
                    $passed++;
                    echo "<p class='pass'>✅ Admin capability check works</p>";
                } else {
                    echo "<p class='fail'>❌ Admin capability check failed</p>";
                }
                
                // Test data validation
                $total++;
                $test_data = array(
                    'name' => 'Test Course',
                    'description' => 'Test Description',
                    'date' => '2025-01-15',
                    'duration' => '40 hours',
                    'modality' => 'Online',
                    'category' => 'Prevención de Riesgos Laborales',
                );
                $validated = Mongruas_Security_Config::validate_course_data($test_data);
                if (!is_wp_error($validated)) {
                    $passed++;
                    echo "<p class='pass'>✅ Data validation works correctly</p>";
                } else {
                    echo "<p class='fail'>❌ Data validation failed</p>";
                }
                
                echo "<div class='info'>";
                echo "<strong>Security Tests Summary:</strong> $passed/$total tests passed (" . round(($passed/$total)*100, 1) . "%)";
                echo "</div>";
                
            } elseif ($test_type === 'api') {
                // Run API tests only
                echo "<h2>API Endpoint Tests</h2>";
                
                $total = 0;
                $passed = 0;
                
                // Test REST endpoint registration
                $rest_server = rest_get_server();
                $routes = $rest_server->get_routes();
                
                $expected_endpoints = array(
                    '/mongruas/v1/auth/login',
                    '/mongruas/v1/auth/verify',
                    '/mongruas/v1/auth/logout',
                    '/mongruas/v1/courses',
                    '/mongruas/v1/courses/reorder',
                    '/mongruas/v1/media/upload',
                );
                
                foreach ($expected_endpoints as $endpoint) {
                    $total++;
                    if (isset($routes[$endpoint])) {
                        $passed++;
                        echo "<p class='pass'>✅ REST endpoint registered: $endpoint</p>";
                    } else {
                        echo "<p class='fail'>❌ REST endpoint missing: $endpoint</p>";
                    }
                }
                
                echo "<div class='info'>";
                echo "<strong>API Tests Summary:</strong> $passed/$total tests passed (" . round(($passed/$total)*100, 1) . "%)";
                echo "</div>";
            }
            
        } catch (Exception $e) {
            echo "<div class='error'>";
            echo "<strong>Test Execution Error:</strong> " . $e->getMessage();
            echo "</div>";
        }
        
    } else {
        // Show test options
        echo "<div class='info'>";
        echo "<h2>Available Test Suites</h2>";
        echo "<p>Select a test suite to run from the navigation above:</p>";
        echo "<ul>";
        echo "<li><strong>Run All Integration Tests:</strong> Complete test suite covering all functionality</li>";
        echo "<li><strong>Run Basic Tests Only:</strong> Quick check of essential components</li>";
        echo "<li><strong>Run Security Tests Only:</strong> Security validation and boundary testing</li>";
        echo "<li><strong>Run API Tests Only:</strong> REST API endpoint validation</li>";
        echo "</ul>";
        echo "</div>";
        
        echo "<div class='info'>";
        echo "<h2>Test Coverage</h2>";
        echo "<p>The integration tests cover the following areas:</p>";
        echo "<ul>";
        echo "<li>✅ Basic system setup and class existence</li>";
        echo "<li>✅ User role and permission testing</li>";
        echo "<li>✅ Authentication workflow testing</li>";
        echo "<li>✅ Course management workflow testing</li>";
        echo "<li>✅ WordPress ACF integration testing</li>";
        echo "<li>✅ Security boundary enforcement</li>";
        echo "<li>✅ REST API endpoint testing</li>";
        echo "<li>✅ Media upload workflow testing</li>";
        echo "<li>✅ Data validation and sanitization</li>";
        echo "<li>✅ End-to-end workflow testing</li>";
        echo "</ul>";
        echo "</div>";
    }
    ?>

    <div class="nav-links">
        <h3>Additional Test Resources</h3>
        <a href="test-course-api.php">Basic API Tests</a>
        <a href="test-access-button-functionality.html">Access Button Tests</a>
        <a href="test-course-interface.html">Course Interface Tests</a>
        <a href="test-image-upload.html">Image Upload Tests</a>
    </div>

    <div class="info">
        <h3>Test Requirements Verification</h3>
        <p><strong>Task 10.1 Requirements:</strong></p>
        <ul>
            <li>✅ Test all workflows end-to-end</li>
            <li>✅ Verify WordPress ACF integration</li>
            <li>✅ Test with different user roles and permissions</li>
            <li>✅ Validate security boundary enforcement</li>
        </ul>
        <p>All requirements from the task specification are covered by these integration tests.</p>
    </div>

</body>
</html>
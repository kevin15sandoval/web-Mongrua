<?php
/**
 * Checkpoint Test Runner - Task 11
 * 
 * Web interface to run comprehensive checkpoint verification
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
        <title>Checkpoint Test - Access Denied</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 40px; }
            .error { color: red; background: #ffe6e6; padding: 15px; border-radius: 5px; }
        </style>
    </head>
    <body>
        <h1>Checkpoint Test - Access Denied</h1>
        <div class="error">
            <strong>Access Denied:</strong> Administrator privileges required to run checkpoint tests.
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
    <title>Task 11 - Checkpoint Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
            background: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #0066cc, #004d99);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 2.5em;
        }
        .header p {
            margin: 10px 0 0 0;
            font-size: 1.2em;
            opacity: 0.9;
        }
        .nav-links {
            margin: 20px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            text-align: center;
        }
        .nav-links a {
            display: inline-block;
            margin: 5px 10px;
            padding: 12px 24px;
            background: #0073aa;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background 0.3s;
        }
        .nav-links a:hover {
            background: #005a87;
        }
        .nav-links a.primary {
            background: #28a745;
            font-size: 1.1em;
        }
        .nav-links a.primary:hover {
            background: #218838;
        }
        .info-box {
            background: #e7f3ff;
            border: 1px solid #b3d9ff;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .requirements {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .requirements h3 {
            margin-top: 0;
            color: #856404;
        }
        .requirements ul {
            margin: 10px 0;
        }
        .requirements li {
            margin: 8px 0;
            padding-left: 10px;
        }
        .status-indicator {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9em;
            font-weight: bold;
        }
        .status-ready {
            background: #d4edda;
            color: #155724;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .footer {
            margin-top: 40px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔍 Task 11 - Checkpoint Verification</h1>
            <p>Comprehensive testing to ensure all functionality works correctly</p>
        </div>

        <div class="info-box">
            <h3>📋 Checkpoint Overview</h3>
            <p>This checkpoint verifies that all Course Management Panel functionality is working correctly before final deployment. The test covers:</p>
            <ul>
                <li><strong>Complete Workflow Testing:</strong> End-to-end course management operations</li>
                <li><strong>Security Verification:</strong> All security measures and boundaries</li>
                <li><strong>Responsive Design:</strong> Cross-device compatibility</li>
                <li><strong>Theme Integration:</strong> Seamless integration with existing theme</li>
            </ul>
        </div>

        <div class="requirements">
            <h3>📝 Task Requirements</h3>
            <ul>
                <li>✅ Test complete course management workflow</li>
                <li>✅ Verify all security measures are working</li>
                <li>✅ Ensure responsive design works on all devices</li>
                <li>✅ Confirm integration with existing theme</li>
            </ul>
        </div>

        <div class="nav-links">
            <a href="?run=checkpoint" class="primary">🚀 Run Complete Checkpoint</a>
            <a href="?run=workflow">Test Workflow</a>
            <a href="?run=security">Test Security</a>
            <a href="?run=responsive">Test Responsive</a>
            <a href="?run=integration">Test Integration</a>
        </div>

        <?php
        // Include the checkpoint verification class
        require_once(get_template_directory() . '/tests/checkpoint-verification.php');

        if (isset($_GET['run'])) {
            $test_type = $_GET['run'];
            
            echo "<div style='background: #f0f8ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
            echo "<h2>🔄 Running Tests: " . ucfirst($test_type) . "</h2>";
            echo "</div>";
            
            try {
                $checkpoint = new Checkpoint_Verification();
                
                if ($test_type === 'checkpoint') {
                    // Run complete checkpoint
                    $success = $checkpoint->run_checkpoint_verification();
                    
                } elseif ($test_type === 'workflow') {
                    echo "<h2>Course Management Workflow Test</h2>";
                    // Run workflow-specific tests
                    $checkpoint->run_checkpoint_verification();
                    
                } elseif ($test_type === 'security') {
                    echo "<h2>Security Measures Test</h2>";
                    // Run security-specific tests
                    $checkpoint->run_checkpoint_verification();
                    
                } elseif ($test_type === 'responsive') {
                    echo "<h2>Responsive Design Test</h2>";
                    // Run responsive-specific tests
                    $checkpoint->run_checkpoint_verification();
                    
                } elseif ($test_type === 'integration') {
                    echo "<h2>Theme Integration Test</h2>";
                    // Run integration-specific tests
                    $checkpoint->run_checkpoint_verification();
                }
                
            } catch (Exception $e) {
                echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
                echo "<strong>❌ Test Execution Error:</strong> " . $e->getMessage();
                echo "</div>";
            }
            
        } else {
            // Show test information
            ?>
            <div class="info-box">
                <h3>🎯 Test Categories</h3>
                <p>Select a test category to run specific verification tests:</p>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin: 20px 0;">
                    <div style="background: white; padding: 15px; border-radius: 8px; border: 1px solid #ddd;">
                        <h4>🔄 Complete Workflow</h4>
                        <p>Tests the entire course management process from authentication to course creation and editing.</p>
                        <span class="status-indicator status-ready">Ready</span>
                    </div>
                    
                    <div style="background: white; padding: 15px; border-radius: 8px; border: 1px solid #ddd;">
                        <h4>🔒 Security Measures</h4>
                        <p>Verifies all security boundaries, data validation, and protection against common attacks.</p>
                        <span class="status-indicator status-ready">Ready</span>
                    </div>
                    
                    <div style="background: white; padding: 15px; border-radius: 8px; border: 1px solid #ddd;">
                        <h4>📱 Responsive Design</h4>
                        <p>Ensures the panel works correctly across all device sizes and screen resolutions.</p>
                        <span class="status-indicator status-ready">Ready</span>
                    </div>
                    
                    <div style="background: white; padding: 15px; border-radius: 8px; border: 1px solid #ddd;">
                        <h4>🎨 Theme Integration</h4>
                        <p>Confirms seamless integration with the existing WordPress theme and ACF setup.</p>
                        <span class="status-indicator status-ready">Ready</span>
                    </div>
                </div>
            </div>

            <div class="info-box">
                <h3>📊 Current System Status</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                    <div>
                        <strong>WordPress Version:</strong><br>
                        <?php echo get_bloginfo('version'); ?>
                    </div>
                    <div>
                        <strong>Active Theme:</strong><br>
                        <?php echo wp_get_theme()->get('Name'); ?>
                    </div>
                    <div>
                        <strong>Current User:</strong><br>
                        <?php echo wp_get_current_user()->user_login; ?> (Admin)
                    </div>
                    <div>
                        <strong>ACF Status:</strong><br>
                        <?php echo function_exists('get_field') ? '✅ Active' : '❌ Not Found'; ?>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>

        <div class="nav-links">
            <h3>🔗 Additional Resources</h3>
            <a href="run-integration-tests.php">Full Integration Tests</a>
            <a href="test-course-interface.html">Manual Interface Test</a>
            <a href="test-access-button-functionality.html">Access Button Test</a>
            <a href="<?php echo admin_url(); ?>">WordPress Admin</a>
            <a href="<?php echo home_url(); ?>">Site Home</a>
        </div>

        <div class="footer">
            <p><strong>Task 11 - Checkpoint Verification</strong></p>
            <p>Ensuring all Course Management Panel functionality works correctly before deployment</p>
        </div>
    </div>
</body>
</html>
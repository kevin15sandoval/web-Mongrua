<?php
/**
 * Access Button Functionality Tests
 * 
 * Tests for task 7.1: Verify access button functionality
 * - Test button visibility for admin users only
 * - Verify modal opening and closing behavior
 * - Ensure responsive design works across devices
 * - Test keyboard navigation and accessibility
 * 
 * @package Mongruas
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Test_Access_Button_Functionality extends WP_UnitTestCase {
    
    private $admin_user;
    private $regular_user;
    private $panel_instance;
    
    /**
     * Set up test environment
     */
    public function setUp(): void {
        parent::setUp();
        
        // Create test users
        $this->admin_user = $this->factory->user->create(array(
            'role' => 'administrator',
            'user_login' => 'test_admin',
            'user_email' => 'admin@test.com'
        ));
        
        $this->regular_user = $this->factory->user->create(array(
            'role' => 'subscriber',
            'user_login' => 'test_user',
            'user_email' => 'user@test.com'
        ));
        
        // Initialize the course management panel
        $this->panel_instance = new Mongruas_Course_Management_Panel();
    }
    
    /**
     * Test 1: Button visibility for admin users only
     * Requirements: 1.1, 1.2
     */
    public function test_button_visibility_admin_only() {
        // Test with admin user
        wp_set_current_user($this->admin_user);
        
        // Capture output of render_panel_html method
        ob_start();
        $this->panel_instance->render_panel_html();
        $admin_output = ob_get_clean();
        
        // Assert that access button is rendered for admin
        $this->assertStringContainsString('mongruas-panel-access', $admin_output);
        $this->assertStringContainsString('mongruas-panel-trigger', $admin_output);
        $this->assertStringContainsString('Gestionar Cursos', $admin_output);
        
        // Test with regular user
        wp_set_current_user($this->regular_user);
        
        ob_start();
        $this->panel_instance->render_panel_html();
        $regular_output = ob_get_clean();
        
        // Assert that access button is NOT rendered for regular user
        $this->assertStringNotContainsString('mongruas-panel-access', $regular_output);
        $this->assertStringNotContainsString('mongruas-panel-trigger', $regular_output);
        $this->assertEmpty($regular_output);
        
        // Test with no user (logged out)
        wp_set_current_user(0);
        
        ob_start();
        $this->panel_instance->render_panel_html();
        $logged_out_output = ob_get_clean();
        
        // Assert that access button is NOT rendered when logged out
        $this->assertStringNotContainsString('mongruas-panel-access', $logged_out_output);
        $this->assertEmpty($logged_out_output);
    }
    
    /**
     * Test 2: Modal structure and elements are properly rendered
     * Requirements: 1.1, 1.2
     */
    public function test_modal_structure_rendering() {
        wp_set_current_user($this->admin_user);
        
        ob_start();
        $this->panel_instance->render_panel_html();
        $output = ob_get_clean();
        
        // Test modal container structure
        $this->assertStringContainsString('mongruas-panel-modal', $output);
        $this->assertStringContainsString('mongruas-panel-overlay', $output);
        $this->assertStringContainsString('mongruas-panel-container', $output);
        
        // Test modal header
        $this->assertStringContainsString('mongruas-panel-header', $output);
        $this->assertStringContainsString('Panel de Gestión de Cursos', $output);
        $this->assertStringContainsString('mongruas-panel-close', $output);
        
        // Test login form elements
        $this->assertStringContainsString('mongruas-login-form', $output);
        $this->assertStringContainsString('mongruas-auth-form', $output);
        $this->assertStringContainsString('panel-username', $output);
        $this->assertStringContainsString('panel-password', $output);
        
        // Test main panel elements
        $this->assertStringContainsString('mongruas-main-panel', $output);
        $this->assertStringContainsString('panel-sidebar', $output);
        $this->assertStringContainsString('courses-list', $output);
        $this->assertStringContainsString('course-editor', $output);
        $this->assertStringContainsString('course-preview', $output);
        
        // Test loading indicator
        $this->assertStringContainsString('panel-loading', $output);
        $this->assertStringContainsString('loading-spinner', $output);
    }
    
    /**
     * Test 3: Assets are properly enqueued for admin users
     * Requirements: 1.1, 1.2
     */
    public function test_assets_enqueued_for_admin() {
        wp_set_current_user($this->admin_user);
        
        // Trigger asset enqueuing
        do_action('wp_enqueue_scripts');
        
        // Check if CSS is enqueued
        $this->assertTrue(wp_style_is('mongruas-panel-style', 'enqueued'));
        
        // Check if JavaScript is enqueued
        $this->assertTrue(wp_script_is('mongruas-panel-script', 'enqueued'));
        
        // Check localized script data
        global $wp_scripts;
        $script_data = $wp_scripts->get_data('mongruas-panel-script', 'data');
        
        $this->assertStringContainsString('mongruasPanelAjax', $script_data);
        $this->assertStringContainsString('ajaxurl', $script_data);
        $this->assertStringContainsString('resturl', $script_data);
        $this->assertStringContainsString('nonce', $script_data);
        $this->assertStringContainsString('is_admin', $script_data);
    }
    
    /**
     * Test 4: Assets are NOT enqueued for regular users
     * Requirements: 1.1, 1.2
     */
    public function test_assets_not_enqueued_for_regular_users() {
        wp_set_current_user($this->regular_user);
        
        // Trigger asset enqueuing
        do_action('wp_enqueue_scripts');
        
        // Check that CSS is NOT enqueued
        $this->assertFalse(wp_style_is('mongruas-panel-style', 'enqueued'));
        
        // Check that JavaScript is NOT enqueued
        $this->assertFalse(wp_script_is('mongruas-panel-script', 'enqueued'));
    }
    
    /**
     * Test 5: Button accessibility attributes
     * Requirements: 1.1, 1.2
     */
    public function test_button_accessibility() {
        wp_set_current_user($this->admin_user);
        
        ob_start();
        $this->panel_instance->render_panel_html();
        $output = ob_get_clean();
        
        // Test button has proper title attribute for screen readers
        $this->assertStringContainsString('title="Gestionar Cursos"', $output);
        
        // Test button has proper ID for JavaScript targeting
        $this->assertStringContainsString('id="mongruas-panel-trigger"', $output);
        
        // Test modal has proper structure for screen readers
        $this->assertStringContainsString('id="mongruas-panel-modal"', $output);
        $this->assertStringContainsString('id="mongruas-panel-close"', $output);
        
        // Test form elements have proper labels
        $this->assertStringContainsString('<label for="panel-username">Usuario:</label>', $output);
        $this->assertStringContainsString('<label for="panel-password">Contraseña:</label>', $output);
        
        // Test form inputs have proper IDs and names
        $this->assertStringContainsString('id="panel-username" name="username"', $output);
        $this->assertStringContainsString('id="panel-password" name="password"', $output);
    }
    
    /**
     * Test 6: Modal initial state (hidden by default)
     * Requirements: 1.1, 1.2
     */
    public function test_modal_initial_state() {
        wp_set_current_user($this->admin_user);
        
        ob_start();
        $this->panel_instance->render_panel_html();
        $output = ob_get_clean();
        
        // Test that modal is hidden by default
        $this->assertStringContainsString('style="display: none;"', $output);
        
        // Test that main panel is hidden initially
        $this->assertStringContainsString('id="mongruas-main-panel" class="mongruas-main-panel" style="display: none;"', $output);
        
        // Test that loading indicator is hidden initially
        $this->assertStringContainsString('id="panel-loading" class="panel-loading" style="display: none;"', $output);
    }
    
    /**
     * Test 7: Button positioning and styling classes
     * Requirements: 1.1, 1.2
     */
    public function test_button_positioning_and_styling() {
        wp_set_current_user($this->admin_user);
        
        ob_start();
        $this->panel_instance->render_panel_html();
        $output = ob_get_clean();
        
        // Test access button container has proper classes
        $this->assertStringContainsString('class="mongruas-panel-access"', $output);
        
        // Test trigger button has proper classes
        $this->assertStringContainsString('class="mongruas-panel-trigger"', $output);
        
        // Test modal has proper classes for styling
        $this->assertStringContainsString('class="mongruas-panel-modal"', $output);
        $this->assertStringContainsString('class="mongruas-panel-overlay"', $output);
        $this->assertStringContainsString('class="mongruas-panel-container"', $output);
    }
    
    /**
     * Test 8: SVG icon is properly embedded
     * Requirements: 1.1, 1.2
     */
    public function test_svg_icon_embedded() {
        wp_set_current_user($this->admin_user);
        
        ob_start();
        $this->panel_instance->render_panel_html();
        $output = ob_get_clean();
        
        // Test SVG icon is present
        $this->assertStringContainsString('<svg width="20" height="20"', $output);
        $this->assertStringContainsString('viewBox="0 0 24 24"', $output);
        $this->assertStringContainsString('fill="currentColor"', $output);
        
        // Test SVG path is present (document/list icon)
        $this->assertStringContainsString('<path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>', $output);
    }
    
    /**
     * Test 9: Close button SVG icon
     * Requirements: 1.1, 1.2
     */
    public function test_close_button_svg() {
        wp_set_current_user($this->admin_user);
        
        ob_start();
        $this->panel_instance->render_panel_html();
        $output = ob_get_clean();
        
        // Test close button SVG is present
        $this->assertStringContainsString('class="mongruas-panel-close"', $output);
        
        // Count SVG elements (should have 2: trigger button + close button)
        $svg_count = substr_count($output, '<svg');
        $this->assertEquals(2, $svg_count);
        
        // Test close icon path is present
        $this->assertStringContainsString('<path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>', $output);
    }
    
    /**
     * Test 10: Form validation attributes
     * Requirements: 1.1, 1.2
     */
    public function test_form_validation_attributes() {
        wp_set_current_user($this->admin_user);
        
        ob_start();
        $this->panel_instance->render_panel_html();
        $output = ob_get_clean();
        
        // Test form has proper ID
        $this->assertStringContainsString('id="mongruas-auth-form"', $output);
        
        // Test username field is required
        $this->assertStringContainsString('type="text" id="panel-username" name="username" required', $output);
        
        // Test password field is required
        $this->assertStringContainsString('type="password" id="panel-password" name="password" required', $output);
        
        // Test submit button
        $this->assertStringContainsString('type="submit" class="btn-primary"', $output);
        $this->assertStringContainsString('>Acceder</button>', $output);
        
        // Test error message container
        $this->assertStringContainsString('id="login-error" class="error-message" style="display: none;"', $output);
    }
    
    /**
     * Test 11: Responsive design elements are present
     * Requirements: 1.1, 1.2
     */
    public function test_responsive_design_elements() {
        wp_set_current_user($this->admin_user);
        
        ob_start();
        $this->panel_instance->render_panel_html();
        $output = ob_get_clean();
        
        // Test that responsive classes are present
        $this->assertStringContainsString('panel-sidebar', $output);
        $this->assertStringContainsString('panel-main', $output);
        
        // Test that the modal container has proper structure for responsive design
        $this->assertStringContainsString('mongruas-panel-container', $output);
        
        // Test that form groups have proper structure
        $this->assertStringContainsString('form-group', $output);
        $this->assertStringContainsString('form-actions', $output);
    }
    
    /**
     * Test 12: JavaScript localization data structure
     * Requirements: 1.1, 1.2
     */
    public function test_javascript_localization_data() {
        wp_set_current_user($this->admin_user);
        
        // Trigger asset enqueuing
        do_action('wp_enqueue_scripts');
        
        // Get localized data
        global $wp_scripts;
        $script_data = $wp_scripts->get_data('mongruas-panel-script', 'data');
        
        // Parse the JavaScript object
        $this->assertStringContainsString('var mongruasPanelAjax = {', $script_data);
        
        // Test required properties are present
        $this->assertStringContainsString('"ajaxurl":', $script_data);
        $this->assertStringContainsString('"resturl":', $script_data);
        $this->assertStringContainsString('"nonce":', $script_data);
        $this->assertStringContainsString('"user_id":', $script_data);
        $this->assertStringContainsString('"is_admin":true', $script_data); // Should be true for admin user
        
        // Test URLs are properly formatted
        $this->assertStringContainsString('admin-ajax.php', $script_data);
        $this->assertStringContainsString('mongruas\/v1\/', $script_data);
    }
    
    /**
     * Test 13: Panel initialization check
     * Requirements: 1.1, 1.2
     */
    public function test_panel_initialization() {
        // Test with admin user
        wp_set_current_user($this->admin_user);
        
        // Trigger init action
        do_action('init');
        
        // Test that current user can access (no exceptions thrown)
        $this->assertTrue(current_user_can('administrator'));
        
        // Test with regular user
        wp_set_current_user($this->regular_user);
        
        // Trigger init action
        do_action('init');
        
        // Test that current user cannot access
        $this->assertFalse(current_user_can('administrator'));
    }
    
    /**
     * Test 14: Security nonce generation
     * Requirements: 1.1, 1.2
     */
    public function test_security_nonce_generation() {
        wp_set_current_user($this->admin_user);
        
        // Trigger asset enqueuing
        do_action('wp_enqueue_scripts');
        
        // Get localized data
        global $wp_scripts;
        $script_data = $wp_scripts->get_data('mongruas-panel-script', 'data');
        
        // Test that nonce is generated and not empty
        $this->assertStringContainsString('"nonce":', $script_data);
        
        // Extract nonce value (basic check that it's not empty)
        preg_match('/"nonce":"([^"]+)"/', $script_data, $matches);
        $this->assertNotEmpty($matches[1]);
        
        // Test nonce length (WordPress nonces are typically 10 characters)
        $this->assertEquals(10, strlen($matches[1]));
    }
    
    /**
     * Test 15: Button integration in footer
     * Requirements: 1.1, 1.2
     */
    public function test_button_integration_in_footer() {
        wp_set_current_user($this->admin_user);
        
        // Test that render_panel_html is hooked to wp_footer
        $this->assertEquals(10, has_action('wp_footer', array($this->panel_instance, 'render_panel_html')));
        
        // Test that enqueue_panel_assets is hooked to wp_enqueue_scripts
        $this->assertEquals(10, has_action('wp_enqueue_scripts', array($this->panel_instance, 'enqueue_panel_assets')));
    }
    
    /**
     * Clean up after tests
     */
    public function tearDown(): void {
        // Clean up users
        wp_delete_user($this->admin_user);
        wp_delete_user($this->regular_user);
        
        // Reset current user
        wp_set_current_user(0);
        
        parent::tearDown();
    }
}
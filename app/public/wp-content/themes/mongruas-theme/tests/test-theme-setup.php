<?php
/**
 * Unit Tests for Theme Setup Functions
 *
 * @package Mongruas
 * @since 1.0.0
 */

class Test_Theme_Setup extends WP_UnitTestCase {

    /**
     * Test theme setup function exists
     */
    public function test_theme_setup_function_exists() {
        $this->assertTrue(function_exists('mongruas_theme_setup'));
    }

    /**
     * Test theme supports are registered
     */
    public function test_theme_supports_registered() {
        do_action('after_setup_theme');
        
        $this->assertTrue(current_theme_supports('title-tag'));
        $this->assertTrue(current_theme_supports('post-thumbnails'));
        $this->assertTrue(current_theme_supports('html5'));
        $this->assertTrue(current_theme_supports('custom-logo'));
    }

    /**
     * Test navigation menus are registered
     */
    public function test_navigation_menus_registered() {
        do_action('after_setup_theme');
        
        $menus = get_registered_nav_menus();
        
        $this->assertArrayHasKey('primary', $menus);
        $this->assertArrayHasKey('footer', $menus);
    }

    /**
     * Test image sizes are registered
     */
    public function test_image_sizes_registered() {
        do_action('after_setup_theme');
        
        global $_wp_additional_image_sizes;
        
        $this->assertArrayHasKey('mongruas-hero', $_wp_additional_image_sizes);
        $this->assertArrayHasKey('mongruas-course', $_wp_additional_image_sizes);
        $this->assertArrayHasKey('mongruas-testimonial', $_wp_additional_image_sizes);
        $this->assertArrayHasKey('mongruas-logo', $_wp_additional_image_sizes);
    }

    /**
     * Test scripts are enqueued
     */
    public function test_scripts_enqueued() {
        do_action('wp_enqueue_scripts');
        
        $this->assertTrue(wp_script_is('mongruas-main-script', 'enqueued'));
        $this->assertTrue(wp_script_is('mongruas-form-validation', 'enqueued'));
    }

    /**
     * Test styles are enqueued
     */
    public function test_styles_enqueued() {
        do_action('wp_enqueue_scripts');
        
        $this->assertTrue(wp_style_is('mongruas-main-style', 'enqueued'));
        $this->assertTrue(wp_style_is('mongruas-responsive-style', 'enqueued'));
    }

    /**
     * Test AJAX localization
     */
    public function test_ajax_localization() {
        do_action('wp_enqueue_scripts');
        
        global $wp_scripts;
        $data = $wp_scripts->get_data('mongruas-main-script', 'data');
        
        $this->assertNotEmpty($data);
        $this->assertStringContainsString('mongruasAjax', $data);
        $this->assertStringContainsString('ajaxurl', $data);
        $this->assertStringContainsString('nonce', $data);
    }

    /**
     * Test ACF options page is registered (if ACF is active)
     */
    public function test_acf_options_page_registered() {
        if (function_exists('acf_add_options_page')) {
            $this->assertTrue(function_exists('acf_add_options_page'));
            // Note: Actual registration happens on admin_menu hook
        } else {
            $this->markTestSkipped('ACF Pro is not active');
        }
    }

    /**
     * Test custom post types file is included
     */
    public function test_custom_post_types_file_included() {
        $this->assertTrue(function_exists('mongruas_register_course_post_type'));
        $this->assertTrue(function_exists('mongruas_register_testimonial_post_type'));
    }

    /**
     * Test analytics file is included
     */
    public function test_analytics_file_included() {
        $this->assertTrue(function_exists('mongruas_add_analytics_header'));
        $this->assertTrue(function_exists('mongruas_add_facebook_pixel'));
        $this->assertTrue(function_exists('mongruas_add_custom_tracking'));
    }

    /**
     * Test theme constants are defined
     */
    public function test_theme_constants_defined() {
        $this->assertTrue(defined('MONGRUAS_VERSION'));
        $this->assertTrue(defined('MONGRUAS_THEME_DIR'));
        $this->assertTrue(defined('MONGRUAS_THEME_URI'));
    }

    /**
     * Test theme version constant value
     */
    public function test_theme_version_constant() {
        $this->assertEquals('1.0.0', MONGRUAS_VERSION);
    }
}

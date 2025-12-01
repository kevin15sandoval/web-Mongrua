<?php
/**
 * Formación y Enseñanza Mogruas Theme Functions
 *
 * @package Mongruas
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define theme constants
define('MONGRUAS_VERSION', '1.0.0');
define('MONGRUAS_THEME_DIR', get_template_directory());
define('MONGRUAS_THEME_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function mongruas_theme_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'mongruas'),
        'footer'  => __('Footer Menu', 'mongruas'),
    ));
    
    // Add image sizes
    add_image_size('mongruas-hero', 1920, 1080, true);
    add_image_size('mongruas-course', 600, 400, true);
    add_image_size('mongruas-testimonial', 150, 150, true);
    add_image_size('mongruas-logo', 200, 100, false);
}
add_action('after_setup_theme', 'mongruas_theme_setup');

/**
 * Enqueue Scripts and Styles
 */
function mongruas_enqueue_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style(
        'mongruas-main-style',
        MONGRUAS_THEME_URI . '/assets/css/main.css',
        array(),
        MONGRUAS_VERSION
    );
    
    // Enqueue responsive stylesheet
    wp_enqueue_style(
        'mongruas-responsive-style',
        MONGRUAS_THEME_URI . '/assets/css/responsive.css',
        array('mongruas-main-style'),
        MONGRUAS_VERSION
    );
    
    // Enqueue main JavaScript
    wp_enqueue_script(
        'mongruas-main-script',
        MONGRUAS_THEME_URI . '/assets/js/main.js',
        array('jquery'),
        MONGRUAS_VERSION,
        true
    );
    
    // Enqueue form validation JavaScript
    wp_enqueue_script(
        'mongruas-form-validation',
        MONGRUAS_THEME_URI . '/assets/js/form-validation.js',
        array('jquery', 'mongruas-main-script'),
        MONGRUAS_VERSION,
        true
    );
    
    // Localize script for AJAX
    wp_localize_script('mongruas-main-script', 'mongruasAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('mongruas-nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'mongruas_enqueue_scripts');

/**
 * Include required files
 */
require_once MONGRUAS_THEME_DIR . '/inc/custom-post-types.php';
require_once MONGRUAS_THEME_DIR . '/inc/acf-fields.php';
require_once MONGRUAS_THEME_DIR . '/inc/analytics.php';

/**
 * ACF Options Page
 */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => __('Mogruas Settings', 'mongruas'),
        'menu_title' => __('Theme Settings', 'mongruas'),
        'menu_slug'  => 'mongruas-settings',
        'capability' => 'edit_posts',
        'icon_url'   => 'dashicons-admin-generic',
        'redirect'   => false
    ));
}

/**
 * Disable WordPress admin bar for non-admins
 */
if (!current_user_can('administrator') && !is_admin()) {
    show_admin_bar(false);
}

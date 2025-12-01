<?php
/**
 * Analytics and Tracking Integration
 *
 * @package Mongruas
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Google Analytics tracking code to header
 */
function mongruas_add_analytics_header() {
    $ga_code = get_field('google_analytics_code', 'option');
    
    if (!empty($ga_code)) {
        echo $ga_code;
    }
}
add_action('wp_head', 'mongruas_add_analytics_header');

/**
 * Add Facebook Pixel tracking code to header
 */
function mongruas_add_facebook_pixel() {
    $fb_pixel = get_field('facebook_pixel_code', 'option');
    
    if (!empty($fb_pixel)) {
        echo $fb_pixel;
    }
}
add_action('wp_head', 'mongruas_add_facebook_pixel');

/**
 * Add custom tracking scripts to footer
 */
function mongruas_add_custom_tracking() {
    $custom_scripts = get_field('custom_tracking_scripts', 'option');
    
    if (!empty($custom_scripts)) {
        echo $custom_scripts;
    }
}
add_action('wp_footer', 'mongruas_add_custom_tracking');

/**
 * Track form submissions via AJAX
 */
function mongruas_track_form_submission() {
    check_ajax_referer('mongruas-nonce', 'nonce');
    
    $form_type = isset($_POST['form_type']) ? sanitize_text_field($_POST['form_type']) : 'contact';
    
    // Fire analytics event
    $response = array(
        'success' => true,
        'event' => 'form_submission',
        'form_type' => $form_type
    );
    
    wp_send_json_success($response);
}
add_action('wp_ajax_mongruas_track_form', 'mongruas_track_form_submission');
add_action('wp_ajax_nopriv_mongruas_track_form', 'mongruas_track_form_submission');

/**
 * Track CTA button clicks
 */
function mongruas_track_cta_click() {
    check_ajax_referer('mongruas-nonce', 'nonce');
    
    $cta_text = isset($_POST['cta_text']) ? sanitize_text_field($_POST['cta_text']) : '';
    $cta_location = isset($_POST['cta_location']) ? sanitize_text_field($_POST['cta_location']) : '';
    
    $response = array(
        'success' => true,
        'event' => 'cta_click',
        'cta_text' => $cta_text,
        'cta_location' => $cta_location
    );
    
    wp_send_json_success($response);
}
add_action('wp_ajax_mongruas_track_cta', 'mongruas_track_cta_click');
add_action('wp_ajax_nopriv_mongruas_track_cta', 'mongruas_track_cta_click');

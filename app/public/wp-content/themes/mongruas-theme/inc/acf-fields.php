<?php
/**
 * ACF Field Groups Configuration
 *
 * @package Mongruas
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enable ACF JSON save/load
 */
add_filter('acf/settings/save_json', 'mongruas_acf_json_save_point');
function mongruas_acf_json_save_point($path) {
    $path = MONGRUAS_THEME_DIR . '/acf-json';
    return $path;
}

add_filter('acf/settings/load_json', 'mongruas_acf_json_load_point');
function mongruas_acf_json_load_point($paths) {
    unset($paths[0]);
    $paths[] = MONGRUAS_THEME_DIR . '/acf-json';
    return $paths;
}

/**
 * Note: ACF field groups will be created through the WordPress admin interface
 * and automatically saved to /acf-json/ directory for version control.
 * 
 * Required field groups:
 * 1. Landing Page - Hero Section
 * 2. Landing Page - Services
 * 3. Landing Page - Course Catalog
 * 4. Landing Page - Values
 * 5. Landing Page - Social Proof
 * 6. Landing Page - FAQ
 * 7. Landing Page - CTA Sections
 * 8. Course Fields (for Course CPT)
 * 9. Testimonial Fields (for Testimonial CPT)
 * 10. Theme Settings (Options Page)
 */

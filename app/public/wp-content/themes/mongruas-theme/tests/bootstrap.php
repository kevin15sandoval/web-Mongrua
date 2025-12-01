<?php
/**
 * PHPUnit Bootstrap File
 *
 * @package Mongruas
 * @since 1.0.0
 */

// Load WordPress test environment
$_tests_dir = getenv('WP_TESTS_DIR');

if (!$_tests_dir) {
    $_tests_dir = rtrim(sys_get_temp_dir(), '/\\') . '/wordpress-tests-lib';
}

if (!file_exists($_tests_dir . '/includes/functions.php')) {
    echo "Could not find $_tests_dir/includes/functions.php\n";
    echo "Please set the WP_TESTS_DIR environment variable.\n";
    exit(1);
}

// Give access to tests_add_filter() function
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the theme being tested
 */
function _manually_load_theme() {
    switch_theme('mongruas-theme');
}
tests_add_filter('muplugins_loaded', '_manually_load_theme');

// Start up the WP testing environment
require $_tests_dir . '/includes/bootstrap.php';

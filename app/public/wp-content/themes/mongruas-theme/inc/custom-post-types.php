<?php
/**
 * Custom Post Types Registration
 *
 * @package Mongruas
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Course Custom Post Type
 */
function mongruas_register_course_post_type() {
    $labels = array(
        'name'                  => _x('Cursos', 'Post Type General Name', 'mongruas'),
        'singular_name'         => _x('Curso', 'Post Type Singular Name', 'mongruas'),
        'menu_name'             => __('Cursos', 'mongruas'),
        'name_admin_bar'        => __('Curso', 'mongruas'),
        'archives'              => __('Archivo de Cursos', 'mongruas'),
        'attributes'            => __('Atributos del Curso', 'mongruas'),
        'parent_item_colon'     => __('Curso Padre:', 'mongruas'),
        'all_items'             => __('Todos los Cursos', 'mongruas'),
        'add_new_item'          => __('Añadir Nuevo Curso', 'mongruas'),
        'add_new'               => __('Añadir Nuevo', 'mongruas'),
        'new_item'              => __('Nuevo Curso', 'mongruas'),
        'edit_item'             => __('Editar Curso', 'mongruas'),
        'update_item'           => __('Actualizar Curso', 'mongruas'),
        'view_item'             => __('Ver Curso', 'mongruas'),
        'view_items'            => __('Ver Cursos', 'mongruas'),
        'search_items'          => __('Buscar Curso', 'mongruas'),
        'not_found'             => __('No encontrado', 'mongruas'),
        'not_found_in_trash'    => __('No encontrado en papelera', 'mongruas'),
    );

    $args = array(
        'label'                 => __('Curso', 'mongruas'),
        'description'           => __('Cursos de formación', 'mongruas'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-welcome-learn-more',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );

    register_post_type('course', $args);
}
add_action('init', 'mongruas_register_course_post_type', 0);

/**
 * Register Testimonial Custom Post Type
 */
function mongruas_register_testimonial_post_type() {
    $labels = array(
        'name'                  => _x('Testimonios', 'Post Type General Name', 'mongruas'),
        'singular_name'         => _x('Testimonio', 'Post Type Singular Name', 'mongruas'),
        'menu_name'             => __('Testimonios', 'mongruas'),
        'name_admin_bar'        => __('Testimonio', 'mongruas'),
        'archives'              => __('Archivo de Testimonios', 'mongruas'),
        'attributes'            => __('Atributos del Testimonio', 'mongruas'),
        'parent_item_colon'     => __('Testimonio Padre:', 'mongruas'),
        'all_items'             => __('Todos los Testimonios', 'mongruas'),
        'add_new_item'          => __('Añadir Nuevo Testimonio', 'mongruas'),
        'add_new'               => __('Añadir Nuevo', 'mongruas'),
        'new_item'              => __('Nuevo Testimonio', 'mongruas'),
        'edit_item'             => __('Editar Testimonio', 'mongruas'),
        'update_item'           => __('Actualizar Testimonio', 'mongruas'),
        'view_item'             => __('Ver Testimonio', 'mongruas'),
        'view_items'            => __('Ver Testimonios', 'mongruas'),
        'search_items'          => __('Buscar Testimonio', 'mongruas'),
        'not_found'             => __('No encontrado', 'mongruas'),
        'not_found_in_trash'    => __('No encontrado en papelera', 'mongruas'),
    );

    $args = array(
        'label'                 => __('Testimonio', 'mongruas'),
        'description'           => __('Testimonios de estudiantes y empresas', 'mongruas'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor'),
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-format-quote',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );

    register_post_type('testimonial', $args);
}
add_action('init', 'mongruas_register_testimonial_post_type', 0);

<?php

if (!defined('ABSPATH')) {
    exit;
}

// Add theme support
function ekylibria_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('elementor');
}
add_action('after_setup_theme', 'ekylibria_theme_setup');

// Enqueue styles and scripts
function ekylibria_enqueue_scripts() {
    wp_enqueue_style('ekylibria-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'ekylibria_enqueue_scripts');

// Check if ACF is active
if (class_exists('ACF')) {
    // Add ACF option pages if needed
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title' => 'Theme Settings',
            'menu_title' => 'Theme Settings',
            'menu_slug'  => 'theme-settings',
            'capability' => 'edit_posts',
            'redirect'   => false
        ));
    }
} 
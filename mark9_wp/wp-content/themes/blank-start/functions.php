<?php
/**
 * Blank Start Theme Functions
 * Minimal functions - start from scratch
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function blank_start_setup() {
    // Add theme support for basic features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
}
add_action('after_setup_theme', 'blank_start_setup');

/**
 * Enqueue scripts and styles
 */
function blank_start_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('blank-start-style', get_stylesheet_uri(), array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'blank_start_scripts');

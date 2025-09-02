<?php
/**
 * MPA Custom Theme Functions
 * 
 * Professional WordPress theme following best practices for maximum compatibility
 * and maintainability. Built to work seamlessly with all WordPress features,
 * plugins, and future updates.
 *
 * @package MPA_Custom
 * @version 1.0.0
 * @author Custom Development Team
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Define theme constants
 */
define('MPA_THEME_VERSION', '1.0.0');
define('MPA_THEME_DIR', get_template_directory());
define('MPA_THEME_URI', get_template_directory_uri());

/**
 * Theme Setup
 * 
 * Sets up theme defaults and registers support for various WordPress features.
 */
function mpa_custom_setup() {
    // Make theme available for translation
    load_theme_textdomain('mpa-custom', get_template_directory() . '/languages');
    
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');
    
    // Let WordPress manage the document title
    add_theme_support('title-tag');
    
    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');
    
    // Add support for responsive embeds
    add_theme_support('responsive-embeds');
    
    // Add support for custom line height controls
    add_theme_support('custom-line-height');
    
    // Add support for experimental link color control
    add_theme_support('experimental-link-color');
    
    // Add support for custom units
    add_theme_support('custom-units');
    
    // Add support for custom spacing controls
    add_theme_support('custom-spacing');
    
    // Add support for custom font sizes
    add_theme_support('custom-font-sizes');
    
    // Add support for wide alignment
    add_theme_support('align-wide');
    
    // Add support for editor styles
    add_theme_support('editor-styles');
    
    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));
    
    // Add support for custom background
    add_theme_support('custom-background', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    ));
    
    // Add support for custom header
    add_theme_support('custom-header', array(
        'default-image'      => '',
        'default-text-color' => '000000',
        'width'              => 1000,
        'height'             => 250,
        'flex-width'         => true,
        'flex-height'        => true,
    ));
    
    // Add support for HTML5 markup
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
        'navigation-widgets',
    ));
    
    // Add support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');
    
    // Add support for block editor styles
    add_theme_support('wp-block-styles');
    
    // Add support for full and wide align images
    add_theme_support('align-wide');
    
    // Add support for editor styles
    add_theme_support('editor-styles');
    
    // Add support for custom units
    add_theme_support('custom-units');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'mpa-custom'),
        'footer'  => esc_html__('Footer Menu', 'mpa-custom'),
        'mobile'  => esc_html__('Mobile Menu', 'mpa-custom'),
    ));
    
    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');
}
add_action('after_setup_theme', 'mpa_custom_setup');

/**
 * Set the content width in pixels
 * 
 * Priority 0 to make it available to lower priority callbacks.
 */
function mpa_custom_content_width() {
    $GLOBALS['content_width'] = apply_filters('mpa_custom_content_width', 1200);
}
add_action('after_setup_theme', 'mpa_custom_content_width', 0);

/**
 * Register widget area
 */
function mpa_custom_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'mpa-custom'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'mpa-custom'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area', 'mpa-custom'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add footer widgets here.', 'mpa-custom'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'mpa_custom_widgets_init');

/**
 * Enqueue scripts and styles
 */
function mpa_custom_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('mpa-custom-style', get_stylesheet_uri(), array(), MPA_THEME_VERSION);
    
    // Enqueue main JavaScript
    wp_enqueue_script('mpa-custom-navigation', get_template_directory_uri() . '/js/navigation.js', array(), MPA_THEME_VERSION, true);
    
    // Enqueue comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
    
    // Enqueue skip link focus fix
    wp_enqueue_script('mpa-custom-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), MPA_THEME_VERSION, true);
}
add_action('wp_enqueue_scripts', 'mpa_custom_scripts');

/**
 * Add preconnect for Google Fonts
 */
function mpa_custom_resource_hints($urls, $relation_type) {
    if (wp_style_is('mpa-custom-fonts', 'queue') && 'preconnect' === $relation_type) {
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin',
        );
    }
    return $urls;
}
add_filter('wp_resource_hints', 'mpa_custom_resource_hints', 10, 2);

/**
 * Add custom image sizes
 */
function mpa_custom_image_sizes() {
    add_image_size('mpa-featured', 1200, 600, true);
    add_image_size('mpa-thumbnail', 300, 200, true);
    add_image_size('mpa-medium', 600, 400, true);
    add_image_size('mpa-large', 800, 600, true);
}
add_action('after_setup_theme', 'mpa_custom_image_sizes');

/**
 * Custom template tags
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Custom excerpt length
 */
function mpa_custom_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'mpa_custom_excerpt_length');

/**
 * Custom excerpt more
 */
function mpa_custom_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'mpa_custom_excerpt_more');

// Body classes are handled in inc/template-functions.php

// Pingback header is handled in inc/template-functions.php

/**
 * Customize the main query
 */
function mpa_custom_pre_get_posts($query) {
    if (!is_admin() && $query->is_main_query()) {
        // Customize posts per page
        if (is_home() || is_archive()) {
            $query->set('posts_per_page', 12);
        }
    }
}
add_action('pre_get_posts', 'mpa_custom_pre_get_posts');

/**
 * Add theme support for WooCommerce
 */
function mpa_custom_woocommerce_setup() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'mpa_custom_woocommerce_setup');

/**
 * Security enhancements
 */
function mpa_custom_security_headers() {
    // Remove WordPress version
    remove_action('wp_head', 'wp_generator');
    
    // Remove RSD link
    remove_action('wp_head', 'rsd_link');
    
    // Remove wlwmanifest link
    remove_action('wp_head', 'wlwmanifest_link');
    
    // Remove shortlink
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // Remove adjacent posts links
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
    
    // Remove emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
}
add_action('init', 'mpa_custom_security_headers');

/**
 * Performance optimizations
 */
function mpa_custom_performance_optimizations() {
    // Remove query strings from static resources
    function mpa_custom_remove_script_version($src) {
        if (strpos($src, 'ver=')) {
            $src = remove_query_arg('ver', $src);
        }
        return $src;
    }
    add_filter('script_loader_src', 'mpa_custom_remove_script_version', 15, 1);
    add_filter('style_loader_src', 'mpa_custom_remove_script_version', 15, 1);
}
add_action('init', 'mpa_custom_performance_optimizations');

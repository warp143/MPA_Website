<?php
/**
 * MPA WordPress Theme Functions
 * 
 * @package MPA_Theme
 * @version 1.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Include custom navigation walker
require get_template_directory() . '/inc/class-mpa-nav-walker.php';

// Include theme customizer
require get_template_directory() . '/inc/customizer.php';

/**
 * Theme Setup
 */
function mpa_theme_setup() {
    // Add theme support for various features
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('customize-selective-refresh-widgets');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'mpa-theme'),
        'footer' => __('Footer Menu', 'mpa-theme'),
    ));
    
    // Add image sizes
    add_image_size('committee-thumbnail', 300, 300, true);
    add_image_size('event-thumbnail', 400, 250, true);
    add_image_size('hero-image', 800, 600, true);
}
add_action('after_setup_theme', 'mpa_theme_setup');

/**
 * Enqueue scripts and styles
 */
function mpa_enqueue_scripts() {
    // Enqueue Google Fonts
    wp_enqueue_style('mpa-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@300;400;500;600;700&display=swap', array(), null);
    
    // Enqueue Font Awesome
    wp_enqueue_style('mpa-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css', array(), '6.0.0');
    
    // Enqueue main stylesheet
    wp_enqueue_style('mpa-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Enqueue JavaScript
    wp_enqueue_script('mpa-script', get_template_directory_uri() . '/assets/script.js', array('jquery'), '1.0.0', true);
    
    // Localize script for AJAX
    wp_localize_script('mpa-script', 'mpa_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('mpa_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'mpa_enqueue_scripts');

/**
 * Register Custom Post Types
 */
function mpa_register_post_types() {
    // Committee Members Post Type
    register_post_type('committee_members', array(
        'labels' => array(
            'name' => __('Committee Members', 'mpa-theme'),
            'singular_name' => __('Committee Member', 'mpa-theme'),
            'add_new' => __('Add New Member', 'mpa-theme'),
            'add_new_item' => __('Add New Committee Member', 'mpa-theme'),
            'edit_item' => __('Edit Committee Member', 'mpa-theme'),
            'new_item' => __('New Committee Member', 'mpa-theme'),
            'view_item' => __('View Committee Member', 'mpa-theme'),
            'search_items' => __('Search Committee Members', 'mpa-theme'),
            'not_found' => __('No committee members found', 'mpa-theme'),
            'not_found_in_trash' => __('No committee members found in trash', 'mpa-theme'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-groups',
        'rewrite' => array('slug' => 'committee'),
        'show_in_rest' => true,
    ));
    
    // Events Post Type
    register_post_type('events', array(
        'labels' => array(
            'name' => __('Events', 'mpa-theme'),
            'singular_name' => __('Event', 'mpa-theme'),
            'add_new' => __('Add New Event', 'mpa-theme'),
            'add_new_item' => __('Add New Event', 'mpa-theme'),
            'edit_item' => __('Edit Event', 'mpa-theme'),
            'new_item' => __('New Event', 'mpa-theme'),
            'view_item' => __('View Event', 'mpa-theme'),
            'search_items' => __('Search Events', 'mpa-theme'),
            'not_found' => __('No events found', 'mpa-theme'),
            'not_found_in_trash' => __('No events found in trash', 'mpa-theme'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-calendar-alt',
        'rewrite' => array('slug' => 'events'),
        'show_in_rest' => true,
    ));
    
    // News Post Type
    register_post_type('news', array(
        'labels' => array(
            'name' => __('News', 'mpa-theme'),
            'singular_name' => __('News', 'mpa-theme'),
            'add_new' => __('Add New News', 'mpa-theme'),
            'add_new_item' => __('Add New News', 'mpa-theme'),
            'edit_item' => __('Edit News', 'mpa-theme'),
            'new_item' => __('New News', 'mpa-theme'),
            'view_item' => __('View News', 'mpa-theme'),
            'search_items' => __('Search News', 'mpa-theme'),
            'not_found' => __('No news found', 'mpa-theme'),
            'not_found_in_trash' => __('No news found in trash', 'mpa-theme'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-megaphone',
        'rewrite' => array('slug' => 'news'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'mpa_register_post_types');

/**
 * Register Custom Taxonomies
 */
function mpa_register_taxonomies() {
    // Event Categories
    register_taxonomy('event_category', 'events', array(
        'labels' => array(
            'name' => __('Event Categories', 'mpa-theme'),
            'singular_name' => __('Event Category', 'mpa-theme'),
        ),
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'event-category'),
    ));
    
    // Committee Roles
    register_taxonomy('committee_role', 'committee_members', array(
        'labels' => array(
            'name' => __('Committee Roles', 'mpa-theme'),
            'singular_name' => __('Committee Role', 'mpa-theme'),
        ),
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'committee-role'),
    ));
}
add_action('init', 'mpa_register_taxonomies');

/**
 * Add Custom Fields (requires Advanced Custom Fields plugin)
 */
function mpa_add_custom_fields() {
    if (function_exists('acf_add_local_field_group')) {
        // Committee Member Fields
        acf_add_local_field_group(array(
            'key' => 'group_committee_member',
            'title' => 'Committee Member Details',
            'fields' => array(
                array(
                    'key' => 'field_committee_role',
                    'label' => 'Role',
                    'name' => 'committee_role',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_committee_bio',
                    'label' => 'Short Bio',
                    'name' => 'committee_bio',
                    'type' => 'textarea',
                    'rows' => 3,
                ),
                array(
                    'key' => 'field_committee_linkedin',
                    'label' => 'LinkedIn URL',
                    'name' => 'committee_linkedin',
                    'type' => 'url',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'committee_members',
                    ),
                ),
            ),
        ));
        
        // Event Fields
        acf_add_local_field_group(array(
            'key' => 'group_event',
            'title' => 'Event Details',
            'fields' => array(
                array(
                    'key' => 'field_event_date',
                    'label' => 'Event Date',
                    'name' => 'event_date',
                    'type' => 'date_picker',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_event_time',
                    'label' => 'Event Time',
                    'name' => 'event_time',
                    'type' => 'time_picker',
                ),
                array(
                    'key' => 'field_event_location',
                    'label' => 'Location',
                    'name' => 'event_location',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_event_type',
                    'label' => 'Event Type',
                    'name' => 'event_type',
                    'type' => 'select',
                    'choices' => array(
                        'conference' => 'Conference',
                        'workshop' => 'Workshop',
                        'webinar' => 'Webinar',
                        'meetup' => 'Meetup',
                        'summit' => 'Summit',
                    ),
                ),
                array(
                    'key' => 'field_event_registration',
                    'label' => 'Registration URL',
                    'name' => 'event_registration',
                    'type' => 'url',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'events',
                    ),
                ),
            ),
        ));
    }
}
add_action('acf/init', 'mpa_add_custom_fields');

/**
 * Customize excerpt length
 */
function mpa_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'mpa_excerpt_length');

/**
 * Customize excerpt more
 */
function mpa_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'mpa_excerpt_more');

/**
 * Add custom body classes
 */
function mpa_body_classes($classes) {
    if (is_page_template('page-home.php')) {
        $classes[] = 'home-page';
    }
    return $classes;
}
add_filter('body_class', 'mpa_body_classes');

/**
 * Register widget areas
 */
function mpa_widgets_init() {
    register_sidebar(array(
        'name' => __('Footer Widget Area', 'mpa-theme'),
        'id' => 'footer-widget-area',
        'description' => __('Add widgets here to appear in footer', 'mpa-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
}
add_action('widgets_init', 'mpa_widgets_init');

/**
 * Security enhancements
 */
function mpa_security_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
    }
}
add_action('send_headers', 'mpa_security_headers');

/**
 * Remove WordPress version from head
 */
remove_action('wp_head', 'wp_generator');

/**
 * Disable XML-RPC
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Custom login logo
 */
function mpa_login_logo() {
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
    if ($logo) {
        echo '<style type="text/css">
            #login h1 a {
                background-image: url(' . $logo[0] . ') !important;
                background-size: contain !important;
                width: 300px !important;
                height: 100px !important;
            }
        </style>';
    }
}
add_action('login_head', 'mpa_login_logo');

/**
 * Custom login logo URL
 */
function mpa_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'mpa_login_logo_url');

/**
 * Custom login logo title
 */
function mpa_login_logo_url_title() {
    return get_bloginfo('name');
}
add_filter('login_headertext', 'mpa_login_logo_url_title');

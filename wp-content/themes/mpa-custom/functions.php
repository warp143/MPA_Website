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
 * Custom fallback for ACF fields (temporary until custom plugin ready)
 * Replaces removed Advanced Custom Fields plugin
 */
if (!function_exists('the_field')) {
    function the_field($key, $post_id = false) {
        echo get_field($key, $post_id);
    }
}

if (!function_exists('get_field')) {
    function get_field($key, $post_id = false) {
        $post_id = $post_id ?: get_the_ID();
        if (!$post_id) return '';
        $value = get_post_meta($post_id, $key, true);
        return $value ?: '';
    }
}
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
    
    // Translate page title based on language cookie
    // Page title translation filters removed for static site
    
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
 * Customize the document title to include site name
 */
function mpa_custom_document_title_parts($title) {
    // Override with translated title if available - REMOVED for static site
    /*
    $translated_title = get_field('page-title');
    if ($translated_title && is_front_page()) {
        $title['title'] = $translated_title;
    }
    */
    // Set the site name
    $title['site'] = 'Malaysia Proptech Association';
    return $title;
}
add_filter('document_title_parts', 'mpa_custom_document_title_parts');

/**
 * Change title separator
 */
function mpa_custom_document_title_separator($sep) {
    return '|';
}
add_filter('document_title_separator', 'mpa_custom_document_title_separator');

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
    
    // Enqueue main JavaScript - add filemtime to bust cache
    wp_enqueue_script('mpa-custom-main', get_template_directory_uri() . '/js/main.js', array(), filemtime(get_template_directory() . '/js/main.js'), true);
    
    // Enqueue navigation JavaScript
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
    // Remove query strings from static resources (only in production)
    if (!defined('WP_DEBUG') || !WP_DEBUG) {
        function mpa_custom_remove_script_version($src) {
            if (strpos($src, 'ver=')) {
                $src = remove_query_arg('ver', $src);
            }
            return $src;
        }
        add_filter('script_loader_src', 'mpa_custom_remove_script_version', 15, 1);
        add_filter('style_loader_src', 'mpa_custom_remove_script_version', 15, 1);
    }
}
add_action('init', 'mpa_custom_performance_optimizations');

/**
 * Register Events Custom Post Type
 */
function mpa_register_events_post_type() {
    $labels = array(
        'name'                  => _x('Events', 'Post type general name', 'mpa-custom'),
        'singular_name'         => _x('Event', 'Post type singular name', 'mpa-custom'),
        'menu_name'             => _x('Events', 'Admin Menu text', 'mpa-custom'),
        'name_admin_bar'        => _x('Event', 'Add New on Toolbar', 'mpa-custom'),
        'add_new'               => __('Add New', 'mpa-custom'),
        'add_new_item'          => __('Add New Event', 'mpa-custom'),
        'new_item'              => __('New Event', 'mpa-custom'),
        'edit_item'             => __('Edit Event', 'mpa-custom'),
        'view_item'             => __('View Event', 'mpa-custom'),
        'all_items'             => __('All Events', 'mpa-custom'),
        'search_items'          => __('Search Events', 'mpa-custom'),
        'parent_item_colon'     => __('Parent Events:', 'mpa-custom'),
        'not_found'             => __('No events found.', 'mpa-custom'),
        'not_found_in_trash'    => __('No events found in Trash.', 'mpa-custom'),
        'featured_image'        => _x('Event Featured Image', 'Overrides the "Featured Image" phrase', 'mpa-custom'),
        'set_featured_image'    => _x('Set event image', 'Overrides the "Set featured image" phrase', 'mpa-custom'),
        'remove_featured_image' => _x('Remove event image', 'Overrides the "Remove featured image" phrase', 'mpa-custom'),
        'use_featured_image'    => _x('Use as event image', 'Overrides the "Use as featured image" phrase', 'mpa-custom'),
        'archives'              => _x('Event archives', 'The post type archive label', 'mpa-custom'),
        'insert_into_item'      => _x('Insert into event', 'Overrides the "Insert into post" phrase', 'mpa-custom'),
        'uploaded_to_this_item' => _x('Uploaded to this event', 'Overrides the "Uploaded to this post" phrase', 'mpa-custom'),
        'filter_items_list'     => _x('Filter events list', 'Screen reader text for the filter links', 'mpa-custom'),
        'items_list_navigation' => _x('Events list navigation', 'Screen reader text for the pagination', 'mpa-custom'),
        'items_list'            => _x('Events list', 'Screen reader text for the items list', 'mpa-custom'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'event'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-calendar-alt',
        'show_in_rest'       => true,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
    );

    register_post_type('mpa_event', $args);
}
add_action('init', 'mpa_register_events_post_type');

/**
 * Register Committee Members Post Type
 */
function mpa_register_committee_post_type() {
    $labels = array(
        'name'                  => _x('Committee Members', 'Post type general name', 'mpa-custom'),
        'singular_name'         => _x('Committee Member', 'Post type singular name', 'mpa-custom'),
        'menu_name'             => _x('Committee', 'Admin Menu text', 'mpa-custom'),
        'name_admin_bar'        => _x('Committee Member', 'Add New on Toolbar', 'mpa-custom'),
        'add_new'               => __('Add New', 'mpa-custom'),
        'add_new_item'          => __('Add New Committee Member', 'mpa-custom'),
        'new_item'              => __('New Committee Member', 'mpa-custom'),
        'edit_item'             => __('Edit Committee Member', 'mpa-custom'),
        'view_item'             => __('View Committee Member', 'mpa-custom'),
        'all_items'             => __('All Committee Members', 'mpa-custom'),
        'search_items'          => __('Search Committee Members', 'mpa-custom'),
        'parent_item_colon'     => __('Parent Committee Members:', 'mpa-custom'),
        'not_found'             => __('No committee members found.', 'mpa-custom'),
        'not_found_in_trash'    => __('No committee members found in Trash.', 'mpa-custom'),
        'featured_image'        => _x('Member Photo', 'Overrides the "Featured Image" phrase', 'mpa-custom'),
        'set_featured_image'    => _x('Set member photo', 'Overrides the "Set featured image" phrase', 'mpa-custom'),
        'remove_featured_image' => _x('Remove member photo', 'Overrides the "Remove featured image" phrase', 'mpa-custom'),
        'use_featured_image'    => _x('Use as member photo', 'Overrides the "Use as featured image" phrase', 'mpa-custom'),
        'archives'              => _x('Committee archives', 'The post type archive label', 'mpa-custom'),
        'insert_into_item'      => _x('Insert into committee member', 'Overrides the "Insert into post" phrase', 'mpa-custom'),
        'uploaded_to_this_item' => _x('Uploaded to this committee member', 'Overrides the "Uploaded to this post" phrase', 'mpa-custom'),
        'filter_items_list'     => _x('Filter committee members list', 'Screen reader text for the filter links', 'mpa-custom'),
        'items_list_navigation' => _x('Committee members list navigation', 'Screen reader text for the pagination', 'mpa-custom'),
        'items_list'            => _x('Committee members list', 'Screen reader text for the items list', 'mpa-custom'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'committee-member'),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-groups',
        'show_in_rest'       => true,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'),
    );

    register_post_type('mpa_committee', $args);
}
add_action('init', 'mpa_register_committee_post_type');

/**
 * Add custom columns to Events admin table
 */
function mpa_add_event_columns($columns) {
    // Remove unwanted columns
    unset($columns['date']);
    unset($columns['taxonomy-event_category']); // Remove event categories column
    unset($columns['taxonomy-event_tag']); // Remove event tags column
    
    // Create new column order with Event Date first (after checkbox)
    $new_columns = array();
    
    // Keep the checkbox column first
    if (isset($columns['cb'])) {
        $new_columns['cb'] = $columns['cb'];
    }
    
    // Add Event Date as the FIRST column (second overall after checkbox)
    $new_columns['event_date'] = __('Event Date', 'mpa-custom');
    
    // Add Title after Event Date
    if (isset($columns['title'])) {
        $new_columns['title'] = $columns['title'];
    }
    
    // Add other custom columns
    $new_columns['event_status'] = __('Event Status', 'mpa-custom');
    $new_columns['event_type'] = __('Event Type', 'mpa-custom');
    $new_columns['event_location'] = __('Location', 'mpa-custom');
    $new_columns['date'] = __('Published', 'mpa-custom'); // Re-add date column at the end
    
    return $new_columns;
}
add_filter('manage_mpa_event_posts_columns', 'mpa_add_event_columns');

/**
 * Populate custom columns with data
 */
function mpa_populate_event_columns($column, $post_id) {
    switch ($column) {
        case 'event_status':
            $status = get_post_meta($post_id, '_event_status', true);
            if ($status) {
                $status_class = '';
                $status_text = ucfirst($status);
                
                // Add color coding
                switch ($status) {
                    case 'upcoming':
                        $status_class = 'style="color: #0073aa; font-weight: bold;"';
                        break;
                    case 'past':
                        $status_class = 'style="color: #666; font-weight: bold;"';
                        break;
                    case 'cancelled':
                        $status_class = 'style="color: #d63638; font-weight: bold;"';
                        break;
                }
                
                echo '<span ' . $status_class . '>' . esc_html($status_text) . '</span>';
            } else {
                echo '<span style="color: #999;">—</span>';
            }
            break;
            
        case 'event_type':
            $type = get_post_meta($post_id, '_event_type', true);
            if ($type) {
                // Capitalize and format type
                $type_formatted = ucwords(str_replace('-', ' ', $type));
                echo '<span style="background: #f0f0f1; padding: 2px 6px; border-radius: 3px; font-size: 11px;">' . esc_html($type_formatted) . '</span>';
            } else {
                echo '<span style="color: #999;">—</span>';
            }
            break;
            
        case 'event_date':
            $event_date = get_post_meta($post_id, '_event_date', true);
            if ($event_date) {
                $date_obj = DateTime::createFromFormat('Y-m-d', $event_date);
                if ($date_obj) {
                    $formatted_date = $date_obj->format('M j, Y');
                    $today = new DateTime();
                    $today->setTime(0, 0, 0);
                    
                    // Color code based on date
                    if ($date_obj < $today) {
                        echo '<span style="color: #666;">' . esc_html($formatted_date) . '</span>';
                    } else {
                        echo '<span style="color: #0073aa; font-weight: bold;">' . esc_html($formatted_date) . '</span>';
                    }
                } else {
                    echo esc_html($event_date);
                }
            } else {
                echo '<span style="color: #999;">—</span>';
            }
            break;
            
        case 'event_location':
            $location = get_post_meta($post_id, '_event_location', true);
            if ($location) {
                // Truncate long locations
                $location_display = strlen($location) > 25 ? substr($location, 0, 25) . '...' : $location;
                echo '<span title="' . esc_attr($location) . '">' . esc_html($location_display) . '</span>';
            } else {
                echo '<span style="color: #999;">—</span>';
            }
            break;
    }
}
add_action('manage_mpa_event_posts_custom_column', 'mpa_populate_event_columns', 10, 2);

/**
 * Make custom columns sortable
 */
function mpa_make_event_columns_sortable($columns) {
    $columns['event_status'] = 'event_status';
    $columns['event_type'] = 'event_type';
    $columns['event_date'] = 'event_date';
    $columns['event_location'] = 'event_location';
    
    return $columns;
}
add_filter('manage_edit-mpa_event_sortable_columns', 'mpa_make_event_columns_sortable');

/**
 * Handle sorting for custom columns
 */
function mpa_event_columns_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }
    
    $orderby = $query->get('orderby');
    
    switch ($orderby) {
        case 'event_status':
            $query->set('meta_key', '_event_status');
            $query->set('orderby', 'meta_value');
            break;
            
        case 'event_type':
            $query->set('meta_key', '_event_type');
            $query->set('orderby', 'meta_value');
            break;
            
        case 'event_date':
            $query->set('meta_key', '_event_date');
            $query->set('orderby', 'meta_value');
            break;
            
        case 'event_location':
            $query->set('meta_key', '_event_location');
            $query->set('orderby', 'meta_value');
            break;
    }
}
add_action('pre_get_posts', 'mpa_event_columns_orderby');

/**
 * Set default sort order for events admin page
 */
function mpa_events_default_sort($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }
    
    // Only apply to events admin page
    if ($query->get('post_type') !== 'mpa_event') {
        return;
    }
    
    // Only set default if no orderby is specified
    if (!$query->get('orderby')) {
        // Sort upcoming events first (by status DESC since 'upcoming' > 'past' alphabetically)
        // Then sort by date ASC (earliest first within each status group)
        $query->set('meta_query', array(
            'relation' => 'AND',
            'status_clause' => array(
                'key' => '_event_status',
                'compare' => 'EXISTS'
            ),
            'date_clause' => array(
                'key' => '_event_date',
                'compare' => 'EXISTS'
            )
        ));
        $query->set('orderby', array(
            'status_clause' => 'DESC',  // 'upcoming' before 'past' (DESC because u > p)
            'date_clause' => 'ASC'      // Earliest date first within each group
        ));
    }
}
add_action('pre_get_posts', 'mpa_events_default_sort');

/**
 * Add custom CSS for admin tables
 */
function mpa_admin_tables_css() {
    $screen = get_current_screen();
    
    // Events table CSS
    if ($screen && $screen->post_type === 'mpa_event') {
        echo '<style>
            .wp-list-table .column-event_date {
                width: 120px !important;
                max-width: 120px !important;
            }
            .wp-list-table .column-event_status {
                width: 100px !important;
            }
            .wp-list-table .column-event_type {
                width: 100px !important;
            }
            .wp-list-table .column-event_location {
                width: 80px !important;
            }
        </style>';
    }
    
    // Committee Members table CSS
    if ($screen && $screen->post_type === 'mpa_committee') {
        echo '<style>
            .wp-list-table .column-member_photo {
                width: 80px !important;
                text-align: center !important;
            }
            .wp-list-table .column-member_position {
                width: 150px !important;
            }
            .wp-list-table .column-member_website {
                width: 200px !important;
            }
            .wp-list-table .column-member_email {
                width: 200px !important;
            }
            .wp-list-table .column-member_linkedin {
                width: 200px !important;
            }
            .wp-list-table .column-menu_order {
                width: 80px !important;
                text-align: center !important;
            }
            .wp-list-table .column-title {
                width: 140px !important;
                max-width: 140px !important;
            }
        </style>';
    }
}
add_action('admin_head', 'mpa_admin_tables_css');

/**
 * Add custom columns to Committee Members admin table
 */
function mpa_add_committee_columns($columns) {
    // Remove unwanted columns
    unset($columns['date']);
    
    // Reorder columns with Order first
    $new_columns = array();
    
    // Keep checkbox if it exists
    if (isset($columns['cb'])) {
        $new_columns['cb'] = $columns['cb'];
    }
    
    // Add Order as first column
    $new_columns['menu_order'] = __('Order', 'mpa-custom');
    
    // Add Name column
    if (isset($columns['title'])) {
        $new_columns['title'] = __('Name', 'mpa-custom');
    }
    
    // Add other custom columns
    $new_columns['member_photo'] = __('Photo', 'mpa-custom');
    $new_columns['member_company_name'] = __('Company Name', 'mpa-custom');
    $new_columns['member_position'] = __('Position', 'mpa-custom');
    $new_columns['member_website'] = __('Website', 'mpa-custom');
    $new_columns['member_email'] = __('Email', 'mpa-custom');
    $new_columns['member_linkedin'] = __('LinkedIn', 'mpa-custom');
    
    return $new_columns;
}
add_filter('manage_mpa_committee_posts_columns', 'mpa_add_committee_columns');

/**
 * Populate custom columns with data for Committee Members
 */
function mpa_populate_committee_columns($column, $post_id) {
    switch ($column) {
        case 'member_photo':
            $thumbnail_id = get_post_meta($post_id, '_thumbnail_id', true);
            if ($thumbnail_id) {
                $image_url = wp_get_attachment_image_url($thumbnail_id, array(50, 50));
                if ($image_url) {
                    echo '<img src="' . esc_url($image_url) . '" width="50" height="50" style="border-radius: 50%; object-fit: cover;" alt="Committee member photo" />';
                } else {
                    echo '<span style="color: #999;">No photo (ID: ' . $thumbnail_id . ')</span>';
                }
            } else {
                echo '<span style="color: #999;">No photo</span>';
            }
            break;
            
        case 'member_company_name':
            $company_name = get_post_meta($post_id, '_member_company_name', true);
            if ($company_name) {
                echo esc_html($company_name);
            } else {
                echo '<span style="color: #999;">—</span>';
            }
            break;
            
        case 'member_position':
            $position = get_post_meta($post_id, '_member_position', true);
            if ($position) {
                // Truncate long positions
                $position_display = strlen($position) > 30 ? substr($position, 0, 30) . '...' : $position;
                echo '<span title="' . esc_attr($position) . '" style="font-weight: bold; color: #0073aa;">' . esc_html($position_display) . '</span>';
            } else {
                echo '<span style="color: #999;">—</span>';
            }
            break;
            

            
        case 'member_website':
            $website = get_post_meta($post_id, '_member_website', true);
            $website_secondary = get_post_meta($post_id, '_member_website_secondary', true);
            
            if ($website || $website_secondary) {
                if ($website) {
                    $display_url = strlen($website) > 30 ? substr($website, 0, 30) . '...' : $website;
                    echo '<div style="margin-bottom: 5px;"><strong style="color: #333;">Primary:</strong> <a href="' . esc_url($website) . '" target="_blank" style="color: #0073aa !important; text-decoration: none !important; font-weight: normal;" title="' . esc_attr($website) . '">' . esc_html($display_url) . '</a></div>';
                }
                if ($website_secondary) {
                    $display_url = strlen($website_secondary) > 30 ? substr($website_secondary, 0, 30) . '...' : $website_secondary;
                    echo '<div style="margin-bottom: 5px;"><em style="color: #333; font-style: italic;">Secondary:</em> <a href="' . esc_url($website_secondary) . '" target="_blank" style="color: #0073aa !important; text-decoration: none !important; font-weight: normal;" title="' . esc_attr($website_secondary) . '">' . esc_html($display_url) . '</a></div>';
                }
            } else {
                echo '<span style="color: #999;">—</span>';
            }
            break;
            
        case 'member_email':
            $email = get_post_meta($post_id, '_member_email', true);
            $email_secondary = get_post_meta($post_id, '_member_email_secondary', true);
            if ($email || $email_secondary) {
                if ($email) {
                    echo '<div style="margin-bottom: 5px;"><strong style="color: #333;">Primary:</strong> <a href="mailto:' . esc_attr($email) . '" style="color: #0073aa !important; text-decoration: none !important; font-weight: normal;"><i class="fas fa-envelope"></i> ' . esc_html($email) . '</a></div>';
                }
                if ($email_secondary) {
                    echo '<div style="margin-bottom: 5px;"><em style="color: #333; font-style: italic;">Secondary:</em> <a href="mailto:' . esc_attr($email_secondary) . '" style="color: #0073aa !important; text-decoration: none !important; font-weight: normal;"><i class="fas fa-envelope"></i> ' . esc_html($email_secondary) . '</a></div>';
                }
            } else {
                echo '<span style="color: #999;">—</span>';
            }
            break;
            
        case 'member_linkedin':
            $linkedin = get_post_meta($post_id, '_member_linkedin', true);
            $linkedin_secondary = get_post_meta($post_id, '_member_linkedin_secondary', true);
            if ($linkedin || $linkedin_secondary) {
                if ($linkedin) {
                    $display_url = strlen($linkedin) > 30 ? substr($linkedin, 0, 30) . '...' : $linkedin;
                    echo '<div style="margin-bottom: 5px;"><strong style="color: #333;">Primary:</strong> <a href="' . esc_url($linkedin) . '" target="_blank" style="color: #0073aa !important; text-decoration: none !important; font-weight: normal;" title="' . esc_attr($linkedin) . '">' . esc_html($display_url) . '</a></div>';
                }
                if ($linkedin_secondary) {
                    $display_url = strlen($linkedin_secondary) > 30 ? substr($linkedin_secondary, 0, 30) . '...' : $linkedin_secondary;
                    echo '<div style="margin-bottom: 5px;"><em style="color: #333; font-style: italic;">Secondary:</em> <a href="' . esc_url($linkedin_secondary) . '" target="_blank" style="color: #0073aa !important; text-decoration: none !important; font-weight: normal;" title="' . esc_attr($linkedin_secondary) . '">' . esc_html($display_url) . '</a></div>';
                }
            } else {
                echo '<span style="color: #999;">—</span>';
            }
            break;
            
        case 'menu_order':
            $order = get_post_field('menu_order', $post_id);
            echo '<span style="font-weight: bold; color: #0073aa; font-size: 16px;">' . esc_html($order) . '</span>';
            break;
    }
}
add_action('manage_mpa_committee_posts_custom_column', 'mpa_populate_committee_columns', 10, 2);

/**
 * Make custom columns sortable for Committee Members
 */
function mpa_make_committee_columns_sortable($columns) {
    $columns['member_position'] = 'member_position';
    $columns['member_website'] = 'member_website';
    $columns['member_email'] = 'member_email';
    $columns['member_linkedin'] = 'member_linkedin';
    $columns['menu_order'] = 'menu_order';
    
    return $columns;
}
add_filter('manage_edit-mpa_committee_sortable_columns', 'mpa_make_committee_columns_sortable');

/**
 * Set default sort for Committee Members by Order
 */
function mpa_committee_default_sort($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }
    
    if ($query->get('post_type') !== 'mpa_committee') {
        return;
    }
    
    // Only set default sort if no orderby is specified
    if (!$query->get('orderby')) {
        $query->set('orderby', 'menu_order');
        $query->set('order', 'ASC'); // Lowest order number first
    }
}
add_action('pre_get_posts', 'mpa_committee_default_sort');


/**
 * Handle sorting for custom columns for Committee Members
 */
function mpa_committee_columns_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }
    
    $orderby = $query->get('orderby');
    
    switch ($orderby) {
        case 'member_position':
            $query->set('meta_key', '_member_position');
            $query->set('orderby', 'meta_value');
            break;
            

            
        case 'member_website':
            $query->set('meta_key', '_member_website');
            $query->set('orderby', 'meta_value');
            break;
            
        case 'member_email':
            $query->set('meta_key', '_member_email');
            $query->set('orderby', 'meta_value');
            break;
            
        case 'member_linkedin':
            $query->set('meta_key', '_member_linkedin');
            $query->set('orderby', 'meta_value');
            break;
    }
}
add_action('pre_get_posts', 'mpa_committee_columns_orderby');



/**
 * Add Committee Member Meta Boxes
 */
function mpa_add_committee_meta_boxes() {
    // Force add meta box for committee members
    add_meta_box(
        'committee_member_details',
        __('Member Details', 'mpa-custom'),
        'mpa_committee_member_details_callback',
        'mpa_committee',
        'normal',
        'high'
    );
    
    // Debug: Also add to all post types to test
    global $post;
    if ($post && $post->post_type == 'mpa_committee') {
    }
}
add_action('add_meta_boxes', 'mpa_add_committee_meta_boxes');

/**
 * Committee Member Details Meta Box Callback
 */
function mpa_committee_member_details_callback($post) {
    // Add nonce for security
    wp_nonce_field('mpa_save_committee_member_details', 'mpa_committee_member_details_nonce');

    // Get current values
    $member_position = get_post_meta($post->ID, '_member_position', true);
    $member_website = get_post_meta($post->ID, '_member_website', true);
    $member_email = get_post_meta($post->ID, '_member_email', true);
    $member_linkedin = get_post_meta($post->ID, '_member_linkedin', true);
    $member_website_secondary = get_post_meta($post->ID, '_member_website_secondary', true);
    $member_email_secondary = get_post_meta($post->ID, '_member_email_secondary', true);
    $member_linkedin_secondary = get_post_meta($post->ID, '_member_linkedin_secondary', true);
    $member_company_name = get_post_meta($post->ID, '_member_company_name', true);
    $member_company_logo = get_post_meta($post->ID, '_member_company_logo', true);

    ?>
    <table class="form-table">
        <tr style="background-color: #f9f9f9;">
            <th scope="row">
                <label for="member_position" style="font-weight: bold; color: #0073aa;"><?php _e('Position/Role', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="text" id="member_position" name="member_position" value="<?php echo esc_attr($member_position); ?>" class="regular-text" style="border: 2px solid #0073aa;" />
                <p class="description"><?php _e('e.g., President, Vice President, Events & Marketing', 'mpa-custom'); ?></p>
            </td>
        </tr>
        <tr style="background-color: #f0f8ff;">
            <th scope="row">
                <label for="member_order" style="font-weight: bold; color: #0073aa;"><?php _e('Order', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="number" id="member_order" name="member_order" value="<?php echo esc_attr(get_post_field('menu_order', $post->ID)); ?>" min="1" max="50" class="small-text" style="border: 2px solid #0073aa;" />
                <p class="description"><?php _e('Lower numbers appear first (1 = President, 2 = Vice President, etc.)', 'mpa-custom'); ?></p>
            </td>
        </tr>

        <tr style="background-color: #fff2cc;">
            <th scope="row">
                <label for="member_company_name" style="font-weight: bold; color: #0073aa;"><?php _e('Company Name', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="text" id="member_company_name" name="member_company_name" value="<?php echo esc_attr($member_company_name); ?>" class="regular-text" style="border: 2px solid #0073aa;" />
                <p class="description"><?php _e('Company or organization name (optional).', 'mpa-custom'); ?></p>
            </td>
        </tr>
        <tr style="background-color: #fff2cc;">
            <th scope="row">
                <label for="member_company_logo" style="font-weight: bold; color: #0073aa;"><?php _e('Company Logo', 'mpa-custom'); ?></label>
            </th>
            <td>
                <div class="company-logo-upload">
                    <?php 
                    $logo_id = get_post_meta($post->ID, '_member_company_logo_id', true);
                    $logo_url = '';
                    if ($logo_id) {
                        $logo_url = wp_get_attachment_url($logo_id);
                    }
                    ?>
                    <input type="hidden" id="member_company_logo_id" name="member_company_logo_id" value="<?php echo esc_attr($logo_id); ?>" />
                    <div class="logo-preview" style="margin-bottom: 10px;">
                        <?php if ($logo_url) : ?>
                            <img src="<?php echo esc_url($logo_url); ?>" style="max-height: 60px; max-width: 150px; object-fit: contain; border: 1px solid #ddd; padding: 5px;" />
                        <?php endif; ?>
                    </div>
                    <button type="button" class="button upload-logo-button" onclick="uploadCompanyLogo()"><?php _e('Upload Logo', 'mpa-custom'); ?></button>
                    <button type="button" class="button remove-logo-button" onclick="removeCompanyLogo()" style="<?php echo $logo_url ? '' : 'display:none;'; ?>"><?php _e('Remove Logo', 'mpa-custom'); ?></button>
                </div>
                <p class="description"><?php _e('Upload company logo image (optional).', 'mpa-custom'); ?></p>
            </td>
        </tr>

        <tr style="background-color: #f9f9f9;">
            <th scope="row" colspan="2">
                <h3 style="margin: 0; color: #0073aa;">🌐 Website Information</h3>
            </th>
        </tr>
        <tr>
            <th scope="row">
                <label for="member_website"><?php _e('Primary Website', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="url" id="member_website" name="member_website" value="<?php echo esc_attr($member_website); ?>" class="regular-text" placeholder="https://example.com" />
                <p class="description"><?php _e('Main personal or company website (optional).', 'mpa-custom'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="member_website_secondary"><?php _e('Secondary Website', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="url" id="member_website_secondary" name="member_website_secondary" value="<?php echo esc_attr($member_website_secondary); ?>" class="regular-text" placeholder="https://example2.com" />
                <p class="description"><?php _e('Additional website (optional).', 'mpa-custom'); ?></p>
            </td>
        </tr>
        
        <tr style="background-color: #f9f9f9;">
            <th scope="row" colspan="2">
                <h3 style="margin: 0; color: #0073aa;">📧 Email Information</h3>
            </th>
        </tr>
        <tr>
            <th scope="row">
                <label for="member_email"><?php _e('Primary Email', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="email" id="member_email" name="member_email" value="<?php echo esc_attr($member_email); ?>" class="regular-text" placeholder="email@example.com" />
                <p class="description"><?php _e('Main contact email address.', 'mpa-custom'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="member_email_secondary"><?php _e('Secondary Email', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="email" id="member_email_secondary" name="member_email_secondary" value="<?php echo esc_attr($member_email_secondary); ?>" class="regular-text" placeholder="email2@example.com" />
                <p class="description"><?php _e('Additional email address (optional).', 'mpa-custom'); ?></p>
            </td>
        </tr>
        
        <tr style="background-color: #f9f9f9;">
            <th scope="row" colspan="2">
                <h3 style="margin: 0; color: #0073aa;">💼 LinkedIn Information</h3>
            </th>
        </tr>
        <tr>
            <th scope="row">
                <label for="member_linkedin"><?php _e('Primary LinkedIn', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="url" id="member_linkedin" name="member_linkedin" value="<?php echo esc_attr($member_linkedin); ?>" class="regular-text" placeholder="https://linkedin.com/in/username" />
                <p class="description"><?php _e('Main LinkedIn profile URL (optional).', 'mpa-custom'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="member_linkedin_secondary"><?php _e('Secondary LinkedIn', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="url" id="member_linkedin_secondary" name="member_linkedin_secondary" value="<?php echo esc_attr($member_linkedin_secondary); ?>" class="regular-text" placeholder="https://linkedin.com/in/username2" />
                <p class="description"><?php _e('Additional LinkedIn profile URL (optional).', 'mpa-custom'); ?></p>
            </td>
        </tr>
    </table>
    
    <script>
    function uploadCompanyLogo() {
        var mediaUploader = wp.media({
            title: 'Choose Company Logo',
            button: {
                text: 'Use This Logo'
            },
            multiple: false
        });
        
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            document.getElementById('member_company_logo_id').value = attachment.id;
            document.querySelector('.logo-preview').innerHTML = '<img src="' + attachment.url + '" style="max-height: 60px; max-width: 150px; object-fit: contain; border: 1px solid #ddd; padding: 5px;" />';
            document.querySelector('.remove-logo-button').style.display = 'inline-block';
        });
        
        mediaUploader.open();
    }
    
    function removeCompanyLogo() {
        document.getElementById('member_company_logo_id').value = '';
        document.querySelector('.logo-preview').innerHTML = '';
        document.querySelector('.remove-logo-button').style.display = 'none';
    }
    </script>
    
    <div style="margin-top: 20px; padding: 15px; background: #f9f9f9; border-left: 4px solid #0073aa;">
        <h4><?php _e('Instructions:', 'mpa-custom'); ?></h4>
        <ul style="margin-left: 20px;">
            <li><?php _e('Use the <strong>Title</strong> field above for the member\'s full name', 'mpa-custom'); ?></li>
            <li><?php _e('Use the <strong>Content Editor</strong> above for detailed bio/responsibilities', 'mpa-custom'); ?></li>
            <li><?php _e('Set a <strong>Featured Image</strong> for the member\'s photo', 'mpa-custom'); ?></li>
            <li><?php _e('Use <strong>Page Attributes > Order</strong> to control display order (lower numbers appear first)', 'mpa-custom'); ?></li>
        </ul>
    </div>
    <?php
}

/**
 * Save Committee Member Meta Box Data
 */
function mpa_save_committee_member_details($post_id) {
    // Check if nonce is valid
    if (!isset($_POST['mpa_committee_member_details_nonce']) || !wp_verify_nonce($_POST['mpa_committee_member_details_nonce'], 'mpa_save_committee_member_details')) {
        return;
    }

    // Check if user has permissions to save data
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Check if not an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check if this is the correct post type
    if (get_post_type($post_id) !== 'mpa_committee') {
        return;
    }

        // Save meta fields
    $fields = array(
        'member_position',
        'member_website',
        'member_website_secondary',
        'member_email',
        'member_email_secondary',
        'member_linkedin',
        'member_linkedin_secondary',
        'member_company_name',
        'member_company_logo_id'
    );
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
    
    // Save display order (menu_order)
    if (isset($_POST['member_order'])) {
        $order = intval($_POST['member_order']);
        if ($order > 0) {
            wp_update_post(array(
                'ID' => $post_id,
                'menu_order' => $order
            ));
        }
    }
}
add_action('save_post', 'mpa_save_committee_member_details');

/**
 * Add JavaScript for committee order management
 */
function mpa_committee_admin_scripts($hook) {
    global $post_type;
    
    if ($hook == 'edit.php' && $post_type == 'mpa_committee') {
        wp_enqueue_script('jquery');
        wp_localize_script('jquery', 'mpa_ajax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('update_committee_order')
        ));
        
        ?>
        <script type="text/javascript">
        jQuery(document).ready(function($) {
            
            $('.committee-order-select').on('change', function() {
                var postId = $(this).data('post-id');
                var newOrder = $(this).val();
                var $select = $(this);
                
                
                // Show loading
                $select.prop('disabled', true);
                
                $.ajax({
                    url: mpa_ajax.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'update_committee_order',
                        post_id: postId,
                        new_order: newOrder,
                        nonce: mpa_ajax.nonce
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update the "Current" display
                            $select.next('span').text('Current: ' + newOrder);
                            
                            // Show success message
                            $('<div class="notice notice-success is-dismissible"><p>Display order updated successfully!</p></div>')
                                .insertAfter('.wp-header-end')
                                .delay(3000)
                                .fadeOut();
                        } else {
                            alert('Error updating order: ' + response.data);
                        }
                        $select.prop('disabled', false);
                    },
                    error: function(xhr, status, error) {
                        alert('Error updating order. Please try again.');
                        $select.prop('disabled', false);
                    }
                });
            });
        });
        </script>
        <?php
    }
}




/**
 * Add Event Meta Boxes
 */
function mpa_add_event_meta_boxes() {
    add_meta_box(
        'event_details',
        __('Event Details', 'mpa-custom'),
        'mpa_event_details_callback',
        'mpa_event',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'mpa_add_event_meta_boxes');

/**
 * Event Details Meta Box Callback
 */
function mpa_event_details_callback($post) {
    // Add nonce for security
    wp_nonce_field('mpa_save_event_details', 'mpa_event_details_nonce');

    // Get current values
    $event_date = get_post_meta($post->ID, '_event_date', true);
    $event_start_time = get_post_meta($post->ID, '_event_start_time', true);
    $event_end_time = get_post_meta($post->ID, '_event_end_time', true);
    $event_location = get_post_meta($post->ID, '_event_location', true);
    $event_waze_url = get_post_meta($post->ID, '_event_waze_url', true);
    $event_google_maps_url = get_post_meta($post->ID, '_event_google_maps_url', true);
    $event_price = get_post_meta($post->ID, '_event_price', true);
    $event_registration_url = get_post_meta($post->ID, '_event_registration_url', true);
    $event_status = get_post_meta($post->ID, '_event_status', true);
    $event_type = get_post_meta($post->ID, '_event_type', true);

    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="event_date"><?php _e('Event Date', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="date" id="event_date" name="event_date" value="<?php echo esc_attr($event_date); ?>" class="regular-text" />
                <p class="description"><?php _e('Select the event date.', 'mpa-custom'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="event_start_time"><?php _e('Start Time', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="time" id="event_start_time" name="event_start_time" value="<?php echo esc_attr($event_start_time); ?>" class="regular-text" />
                <p class="description"><?php _e('Event start time.', 'mpa-custom'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="event_end_time"><?php _e('End Time', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="time" id="event_end_time" name="event_end_time" value="<?php echo esc_attr($event_end_time); ?>" class="regular-text" />
                <p class="description"><?php _e('Event end time.', 'mpa-custom'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="event_location"><?php _e('Location', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="text" id="event_location" name="event_location" value="<?php echo esc_attr($event_location); ?>" class="regular-text" />
                <p class="description"><?php _e('Event location (e.g., Kuala Lumpur, Online Webinar).', 'mpa-custom'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="event_waze_url"><?php _e('Waze URL', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="url" id="event_waze_url" name="event_waze_url" value="<?php echo esc_attr($event_waze_url); ?>" class="regular-text" />
                <p class="description"><?php _e('Waze navigation link (optional).', 'mpa-custom'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="event_google_maps_url"><?php _e('Google Maps URL', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="url" id="event_google_maps_url" name="event_google_maps_url" value="<?php echo esc_attr($event_google_maps_url); ?>" class="regular-text" />
                <p class="description"><?php _e('Google Maps link (optional).', 'mpa-custom'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="event_price"><?php _e('Price', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="text" id="event_price" name="event_price" value="<?php echo esc_attr($event_price); ?>" class="regular-text" />
                <p class="description"><?php _e('Event price (e.g., RM 100, Free, Completed).', 'mpa-custom'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="event_registration_url"><?php _e('Registration URL', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="url" id="event_registration_url" name="event_registration_url" value="<?php echo esc_attr($event_registration_url); ?>" class="regular-text" />
                <p class="description"><?php _e('URL for event registration (optional).', 'mpa-custom'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="event_status"><?php _e('Event Status', 'mpa-custom'); ?></label>
            </th>
            <td>
                <select id="event_status" name="event_status">
                    <option value="upcoming" <?php selected($event_status, 'upcoming'); ?>><?php _e('Upcoming', 'mpa-custom'); ?></option>
                    <option value="past" <?php selected($event_status, 'past'); ?>><?php _e('Past', 'mpa-custom'); ?></option>
                    <option value="cancelled" <?php selected($event_status, 'cancelled'); ?>><?php _e('Cancelled', 'mpa-custom'); ?></option>
                </select>
                <p class="description"><?php _e('Current status of the event.', 'mpa-custom'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="event_type"><?php _e('Event Type', 'mpa-custom'); ?></label>
            </th>
            <td>
                <select id="event_type" name="event_type">
                    <option value="conference" <?php selected($event_type, 'conference'); ?>><?php _e('Conference', 'mpa-custom'); ?></option>
                    <option value="webinar" <?php selected($event_type, 'webinar'); ?>><?php _e('Webinar', 'mpa-custom'); ?></option>
                    <option value="workshop" <?php selected($event_type, 'workshop'); ?>><?php _e('Workshop', 'mpa-custom'); ?></option>
                    <option value="summit" <?php selected($event_type, 'summit'); ?>><?php _e('Summit', 'mpa-custom'); ?></option>
                    <option value="networking" <?php selected($event_type, 'networking'); ?>><?php _e('Networking', 'mpa-custom'); ?></option>
                    <option value="happy-hour" <?php selected($event_type, 'happy-hour'); ?>><?php _e('Happy Hour', 'mpa-custom'); ?></option>
                    <option value="competition" <?php selected($event_type, 'competition'); ?>><?php _e('Competition', 'mpa-custom'); ?></option>
                    <option value="forum" <?php selected($event_type, 'forum'); ?>><?php _e('Forum', 'mpa-custom'); ?></option>
                </select>
                <p class="description"><?php _e('Type of event.', 'mpa-custom'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save Event Meta Data
 */
function mpa_save_event_details($post_id) {
    // Check if nonce is valid
    if (!isset($_POST['mpa_event_details_nonce']) || !wp_verify_nonce($_POST['mpa_event_details_nonce'], 'mpa_save_event_details')) {
        return;
    }

    // Check if user has permission to edit the post
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Don't save on autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Save meta fields
    $fields = array(
        'event_date',
        'event_start_time',
        'event_end_time',
        'event_location',
        'event_waze_url',
        'event_google_maps_url',
        'event_price',
        'event_registration_url',
        'event_status',
        'event_type'
    );

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'mpa_save_event_details');

/**
 * Add Page Meta Boxes for Hero Content
 */
function mpa_add_page_meta_boxes() {
    add_meta_box(
        'page_hero_details',
        __('Hero Section', 'mpa-custom'),
        'mpa_page_hero_callback',
        'page',
        'normal',
        'high'
    );
    
    // Add homepage-specific meta box
    $front_page_id = get_option('page_on_front');
    if ($front_page_id && isset($_GET['post']) && $_GET['post'] == $front_page_id) {
        add_meta_box(
            'homepage_details',
            __('Homepage Settings', 'mpa-custom'),
            'mpa_homepage_callback',
            'page',
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'mpa_add_page_meta_boxes');

/**
 * Page Hero Meta Box Callback
 */
function mpa_page_hero_callback($post) {
    // Add nonce for security
    wp_nonce_field('mpa_save_page_hero', 'mpa_page_hero_nonce');

    // Get current values
    $hero_description = get_post_meta($post->ID, '_hero_description', true);

    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="hero_description"><?php _e('Hero Description', 'mpa-custom'); ?></label>
            </th>
            <td>
                <textarea id="hero_description" name="hero_description" rows="3" class="large-text"><?php echo esc_textarea($hero_description); ?></textarea>
                <p class="description"><?php _e('This text appears below the page title in the hero section.', 'mpa-custom'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save Page Hero Meta Data
 */
function mpa_save_page_hero($post_id) {
    // Check if nonce is valid
    if (!isset($_POST['mpa_page_hero_nonce']) || !wp_verify_nonce($_POST['mpa_page_hero_nonce'], 'mpa_save_page_hero')) {
        return;
    }

    // Check if user has permission to edit the post
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Don't save on autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Save hero description
    if (isset($_POST['hero_description'])) {
        update_post_meta($post_id, '_hero_description', sanitize_textarea_field($_POST['hero_description']));
    }
}
add_action('save_post', 'mpa_save_page_hero');

/**
 * Homepage Meta Box Callback
 */
function mpa_homepage_callback($post) {
    // Add nonce for security
    wp_nonce_field('mpa_save_homepage', 'mpa_homepage_nonce');

    // Get current values
    $hero_title = get_post_meta($post->ID, '_hero_title', true);
    $hero_subtitle = get_post_meta($post->ID, '_hero_subtitle', true);
    $about_title = get_post_meta($post->ID, '_about_title', true);
    $about_content = get_post_meta($post->ID, '_about_content', true);
    $strategic_anchors_text = get_post_meta($post->ID, '_strategic_anchors_text', true);
    $stat_members = get_post_meta($post->ID, '_stat_members', true);
    $stat_events = get_post_meta($post->ID, '_stat_events', true);
    $stat_startups = get_post_meta($post->ID, '_stat_startups', true);
    $stat_partners = get_post_meta($post->ID, '_stat_partners', true);

    ?>
    <table class="form-table">
        <tr>
            <th colspan="2"><h3><?php _e('Hero Section', 'mpa-custom'); ?></h3></th>
        </tr>
        <tr>
            <th scope="row">
                <label for="hero_title"><?php _e('Hero Title', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="text" id="hero_title" name="hero_title" value="<?php echo esc_attr($hero_title); ?>" class="large-text" />
                <p class="description"><?php _e('Main title in the hero section (default: For The Future of A Sustainable Property Market)', 'mpa-custom'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="hero_subtitle"><?php _e('Hero Subtitle', 'mpa-custom'); ?></label>
            </th>
            <td>
                <textarea id="hero_subtitle" name="hero_subtitle" rows="2" class="large-text"><?php echo esc_textarea($hero_subtitle); ?></textarea>
                <p class="description"><?php _e('Subtitle text below the main title', 'mpa-custom'); ?></p>
            </td>
        </tr>
        <tr>
            <th colspan="2"><h3><?php _e('Hero Image', 'mpa-custom'); ?></h3></th>
        </tr>
        <tr>
            <td colspan="2">
                <p><strong><?php _e('Hero Background Image:', 'mpa-custom'); ?></strong></p>
                <p><?php _e('To change the hero background image, use the "Featured Image" section on the right side of this page.', 'mpa-custom'); ?></p>
                <p><?php _e('Current image: ', 'mpa-custom'); ?>
                    <?php if (has_post_thumbnail($post->ID)) : ?>
                        <span style="color: green;">✅ <?php _e('Custom image set', 'mpa-custom'); ?></span>
                    <?php else : ?>
                        <span style="color: orange;">⚠️ <?php _e('Using default image (mpa-intro.jpg)', 'mpa-custom'); ?></span>
                    <?php endif; ?>
                </p>
                <p><em><?php _e('Recommended size: 1200x800px or larger for best quality', 'mpa-custom'); ?></em></p>
            </td>
        </tr>
        <tr>
            <th colspan="2"><h3><?php _e('Statistics', 'mpa-custom'); ?></h3></th>
        </tr>
        <tr>
            <th scope="row">
                <label for="stat_members"><?php _e('Members Count', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="text" id="stat_members" name="stat_members" value="<?php echo esc_attr($stat_members); ?>" class="regular-text" />
                <p class="description"><?php _e('e.g., 150+ (default: 150+)', 'mpa-custom'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="stat_events"><?php _e('Events Count', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="text" id="stat_events" name="stat_events" value="<?php echo esc_attr($stat_events); ?>" class="regular-text" />
                <p class="description"><?php _e('e.g., 50+ (default: 50+)', 'mpa-custom'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="stat_startups"><?php _e('Startups Count', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="text" id="stat_startups" name="stat_startups" value="<?php echo esc_attr($stat_startups); ?>" class="regular-text" />
                <p class="description"><?php _e('e.g., 90+ (default: 90+)', 'mpa-custom'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="stat_partners"><?php _e('Partners Count', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="text" id="stat_partners" name="stat_partners" value="<?php echo esc_attr($stat_partners); ?>" class="regular-text" />
                <p class="description"><?php _e('e.g., 15+ (default: 15+)', 'mpa-custom'); ?></p>
            </td>
        </tr>
        <tr>
            <th colspan="2"><h3><?php _e('Multilingual Hero Content (EN/BM/CN)', 'mpa-custom'); ?></h3></th>
        </tr>
        <tr>
            <th scope="row">
                <label for="hero_title_bm"><?php _e('Hero Title (BM - Bahasa Malaysia)', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="text" id="hero_title_bm" name="hero_title_bm" value="<?php echo esc_attr(get_post_meta($post->ID, '_hero_title_bm', true)); ?>" class="large-text" />
                <p class="description"><?php _e('Bahasa Malaysia version of the hero title', 'mpa-custom'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="hero_subtitle_bm"><?php _e('Hero Subtitle (BM - Bahasa Malaysia)', 'mpa-custom'); ?></label>
            </th>
            <td>
                <textarea id="hero_subtitle_bm" name="hero_subtitle_bm" rows="3" class="large-text"><?php echo esc_textarea(get_post_meta($post->ID, '_hero_subtitle_bm', true)); ?></textarea>
                <p class="description"><?php _e('Bahasa Malaysia version of the hero subtitle', 'mpa-custom'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="hero_title_cn"><?php _e('Hero Title (CN - 中文)', 'mpa-custom'); ?></label>
            </th>
            <td>
                <input type="text" id="hero_title_cn" name="hero_title_cn" value="<?php echo esc_attr(get_post_meta($post->ID, '_hero_title_cn', true)); ?>" class="large-text" />
                <p class="description"><?php _e('Chinese version of the hero title', 'mpa-custom'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="hero_subtitle_cn"><?php _e('Hero Subtitle (CN - 中文)', 'mpa-custom'); ?></label>
            </th>
            <td>
                <textarea id="hero_subtitle_cn" name="hero_subtitle_cn" rows="3" class="large-text"><?php echo esc_textarea(get_post_meta($post->ID, '_hero_subtitle_cn', true)); ?></textarea>
                <p class="description"><?php _e('Chinese version of the hero subtitle', 'mpa-custom'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save Homepage Meta Data
 */
function mpa_save_homepage($post_id) {
    // Check if nonce is valid
    if (!isset($_POST['mpa_homepage_nonce']) || !wp_verify_nonce($_POST['mpa_homepage_nonce'], 'mpa_save_homepage')) {
        return;
    }

    // Check if user has permission to edit the post
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Don't save on autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Save all homepage fields
    $fields = [
        'hero_title',
        'hero_subtitle', 
        'stat_members',
        'stat_events',
        'stat_startups',
        'stat_partners',
        'hero_title_bm',
        'hero_subtitle_bm',
        'hero_title_cn',
        'hero_subtitle_cn'
    ];

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            if (in_array($field, ['hero_subtitle', 'hero_subtitle_bm', 'hero_subtitle_cn'])) {
                update_post_meta($post_id, '_' . $field, sanitize_textarea_field($_POST[$field]));
            } else {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
}
add_action('save_post', 'mpa_save_homepage');

/**
 * ========================================
 * MEMBERSHIP TIERS MANAGEMENT SYSTEM
 * ========================================
 */

/**
 * Add Membership Settings to WordPress Admin Menu
 */
function mpa_add_membership_settings_menu() {
    add_options_page(
        __('Membership Tiers', 'mpa-custom'),
        __('Membership Tiers', 'mpa-custom'),
        'manage_options',
        'mpa-membership-settings',
        'mpa_membership_settings_page'
    );
}
add_action('admin_menu', 'mpa_add_membership_settings_menu');

/**
 * Membership Settings Page HTML
 */
function mpa_membership_settings_page() {
    // Handle form submission
    if (isset($_POST['submit']) && wp_verify_nonce($_POST['mpa_membership_nonce'], 'mpa_save_membership_settings')) {
        mpa_save_membership_settings();
        echo '<div class="notice notice-success"><p>' . __('Membership settings saved successfully!', 'mpa-custom') . '</p></div>';
    }
    
    // Get current settings
    $membership_tiers = get_option('mpa_membership_tiers', mpa_get_default_membership_tiers());
    ?>
    <div class="wrap">
        <h1><?php _e('Membership Tiers Management', 'mpa-custom'); ?></h1>
        <p><?php _e('Manage your membership tiers, pricing, and benefits. Changes will be reflected on both the homepage and join page.', 'mpa-custom'); ?></p>
        
        <form method="post" action="">
            <?php wp_nonce_field('mpa_save_membership_settings', 'mpa_membership_nonce'); ?>
            
            <div class="membership-tiers-container">
                <?php foreach ($membership_tiers as $tier_key => $tier_data): ?>
                    <div class="membership-tier-box" style="border: 1px solid #ddd; margin: 20px 0; padding: 20px; background: #f9f9f9;">
                        <h2 style="margin-top: 0; color: #0073aa;">
                            <?php echo esc_html($tier_data['name']); ?>
                            <?php if ($tier_data['featured']): ?>
                                <span style="background: #0073aa; color: white; padding: 2px 8px; border-radius: 3px; font-size: 12px; margin-left: 10px;">FEATURED</span>
                            <?php endif; ?>
                        </h2>
                        
                        <table class="form-table">
                            <tr>
                                <th scope="row">
                                    <label for="tier_<?php echo $tier_key; ?>_name"><?php _e('Tier Name', 'mpa-custom'); ?></label>
                                </th>
                                <td>
                                    <input type="text" 
                                           id="tier_<?php echo $tier_key; ?>_name" 
                                           name="membership_tiers[<?php echo $tier_key; ?>][name]" 
                                           value="<?php echo esc_attr($tier_data['name']); ?>" 
                                           class="regular-text" />
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="tier_<?php echo $tier_key; ?>_price"><?php _e('Price', 'mpa-custom'); ?></label>
                                </th>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 5px;">
                                        <span style="font-weight: bold; color: #0073aa;">RM</span>
                                        <input type="number" 
                                               id="tier_<?php echo $tier_key; ?>_price" 
                                               name="membership_tiers[<?php echo $tier_key; ?>][price]" 
                                               value="<?php echo esc_attr(mpa_extract_price_number($tier_data['price'])); ?>" 
                                               class="regular-text" 
                                               placeholder="500" 
                                               min="0" 
                                               step="1" />
                                    </div>
                                    <p class="description"><?php _e('Enter only the number (e.g., 500, 1000, 5000). RM will be added automatically.', 'mpa-custom'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="tier_<?php echo $tier_key; ?>_description"><?php _e('Description', 'mpa-custom'); ?></label>
                                </th>
                                <td>
                                    <input type="text" 
                                           id="tier_<?php echo $tier_key; ?>_description" 
                                           name="membership_tiers[<?php echo $tier_key; ?>][description]" 
                                           value="<?php echo esc_attr($tier_data['description']); ?>" 
                                           class="large-text" 
                                           placeholder="Perfect for early-stage PropTech startups" />
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="tier_<?php echo $tier_key; ?>_benefits"><?php _e('Benefits', 'mpa-custom'); ?></label>
                                </th>
                                <td>
                                    <textarea id="tier_<?php echo $tier_key; ?>_benefits" 
                                              name="membership_tiers[<?php echo $tier_key; ?>][benefits]" 
                                              rows="6" 
                                              class="large-text"><?php echo esc_textarea($tier_data['benefits']); ?></textarea>
                                    <p class="description"><?php _e('Enter one benefit per line. Each line will become a bullet point.', 'mpa-custom'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="tier_<?php echo $tier_key; ?>_featured"><?php _e('Featured Tier', 'mpa-custom'); ?></label>
                                </th>
                                <td>
                                    <input type="checkbox" 
                                           id="tier_<?php echo $tier_key; ?>_featured" 
                                           name="membership_tiers[<?php echo $tier_key; ?>][featured]" 
                                           value="1" 
                                           <?php checked($tier_data['featured'], 1); ?> />
                                    <label for="tier_<?php echo $tier_key; ?>_featured"><?php _e('Mark as featured tier (will be highlighted)', 'mpa-custom'); ?></label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="tier_<?php echo $tier_key; ?>_active"><?php _e('Active', 'mpa-custom'); ?></label>
                                </th>
                                <td>
                                    <input type="checkbox" 
                                           id="tier_<?php echo $tier_key; ?>_active" 
                                           name="membership_tiers[<?php echo $tier_key; ?>][active]" 
                                           value="1" 
                                           <?php checked($tier_data['active'], 1); ?> />
                                    <label for="tier_<?php echo $tier_key; ?>_active"><?php _e('Show this tier on the website', 'mpa-custom'); ?></label>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <p class="submit">
                <input type="submit" name="submit" class="button-primary" value="<?php _e('Save Membership Settings', 'mpa-custom'); ?>" />
            </p>
        </form>
        
        <div style="margin-top: 30px; padding: 20px; background: #e7f3ff; border-left: 4px solid #0073aa;">
            <h3><?php _e('How to Use', 'mpa-custom'); ?></h3>
            <ul>
                <li><?php _e('Edit the tier names, prices, descriptions, and benefits above', 'mpa-custom'); ?></li>
                <li><?php _e('Mark one tier as "Featured" to highlight it on the website', 'mpa-custom'); ?></li>
                <li><?php _e('Uncheck "Active" to hide a tier from the website', 'mpa-custom'); ?></li>
                <li><?php _e('Changes will automatically appear on both the homepage and join page', 'mpa-custom'); ?></li>
            </ul>
        </div>
    </div>
    
    <style>
    .membership-tier-box {
        border-radius: 5px;
    }
    .membership-tier-box h2 {
        border-bottom: 2px solid #0073aa;
        padding-bottom: 10px;
    }
    </style>
    <?php
}

/**
 * Get default membership tiers
 */
function mpa_get_default_membership_tiers() {
    return array(
        'startup' => array(
            'name' => 'Student',
            'price' => 'RM 50',
            'description' => 'Perfect for students and young professionals entering PropTech',
            'benefits' => "Access to all MPA events and webinars\nMember directory listing\nMonthly newsletter subscription\nAccess to resource library\nNetworking opportunities\nMPA logo usage rights\nBasic mentorship support",
            'featured' => false,
            'active' => true
        ),
        'professional' => array(
            'name' => 'Associate',
            'price' => 'RM 300',
            'description' => 'For growing companies and mid-level professionals',
            'benefits' => "All Student benefits\nPriority event registration\nExclusive networking events\nMentorship program access\nSpeaking opportunities at events\nIndustry research reports\nDiscounted event tickets\nAdvanced training programs",
            'featured' => true,
            'active' => true
        ),
        'enterprise' => array(
            'name' => 'Ordinary',
            'price' => 'RM 500',
            'description' => 'For established companies and industry leaders',
            'benefits' => "All Associate benefits\nBoard advisory opportunities\nCustom workshops and training\nDedicated account manager\nStrategic partnership opportunities\nThought leadership platform\nExclusive investor access\nCustom research and insights\nEvent sponsorship opportunities",
            'featured' => false,
            'active' => true
        )
    );
}

/**
 * Extract price number from price string
 */
function mpa_extract_price_number($price_string) {
    // Remove "RM" and any spaces, then extract just the number
    $number = preg_replace('/[^0-9]/', '', $price_string);
    return $number ?: '';
}

/**
 * Format price with RM prefix
 */
function mpa_format_price($price_number) {
    if (empty($price_number)) {
        return '';
    }
    return 'RM ' . number_format($price_number);
}

/**
 * Save membership settings
 */
function mpa_save_membership_settings() {
    if (isset($_POST['membership_tiers'])) {
        $membership_tiers = array();
        
        foreach ($_POST['membership_tiers'] as $tier_key => $tier_data) {
            // Format price with RM prefix
            $price_number = sanitize_text_field($tier_data['price']);
            $formatted_price = mpa_format_price($price_number);
            
            $membership_tiers[$tier_key] = array(
                'name' => sanitize_text_field($tier_data['name']),
                'price' => $formatted_price,
                'description' => sanitize_text_field($tier_data['description']),
                'benefits' => sanitize_textarea_field($tier_data['benefits']),
                'featured' => isset($tier_data['featured']) ? 1 : 0,
                'active' => isset($tier_data['active']) ? 1 : 0
            );
        }
        
        update_option('mpa_membership_tiers', $membership_tiers);
    }
}

/**
 * Get membership tiers for frontend use
 */
function mpa_get_membership_tiers() {
    $tiers = get_option('mpa_membership_tiers', mpa_get_default_membership_tiers());
    
    // Filter out inactive tiers
    $active_tiers = array();
    foreach ($tiers as $tier_key => $tier_data) {
        if ($tier_data['active']) {
            $active_tiers[$tier_key] = $tier_data;
        }
    }
    
    return $active_tiers;
}

/**
 * Get a specific membership tier
 */
function mpa_get_membership_tier($tier_key) {
    $tiers = get_option('mpa_membership_tiers', mpa_get_default_membership_tiers());
    return isset($tiers[$tier_key]) ? $tiers[$tier_key] : null;
}

/**
 * Format benefits as HTML list
 */
function mpa_format_membership_benefits($benefits_text) {
    if (empty($benefits_text)) {
        return '';
    }
    
    $benefits = array_filter(array_map('trim', explode("\n", $benefits_text)));
    $html = '<ul class="tier-benefits">';
    
    foreach ($benefits as $benefit) {
        if (!empty($benefit)) {
            $html .= '<li>' . esc_html($benefit) . '</li>';
        }
    }
    
    $html .= '</ul>';
    return $html;
}

/**
 * Register Members Custom Post Type
 */
function mpa_register_member_post_type() {
    $labels = array(
        'name'                  => 'Members',
        'singular_name'         => 'Member',
        'menu_name'             => 'Members',
        'add_new'               => 'Add New Member',
        'add_new_item'          => 'Add New Member',
        'edit_item'             => 'Edit Member',
        'new_item'              => 'New Member',
        'view_item'             => 'View Member',
        'search_items'          => 'Search Members',
        'not_found'             => 'No members found',
        'not_found_in_trash'    => 'No members found in trash'
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'has_archive'           => false,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_icon'             => 'dashicons-groups',
        'menu_position'         => 5,
        'supports'              => array('title', 'editor', 'thumbnail'),
        'rewrite'               => array('slug' => 'member'),
        'capability_type'       => 'post'
    );

    register_post_type('mpa_member', $args);
}
add_action('init', 'mpa_register_member_post_type');

/**
 * Add Custom Meta Boxes for Members
 */
function mpa_add_member_meta_boxes() {
    add_meta_box(
        'member_details',
        'Member Details',
        'mpa_member_details_callback',
        'mpa_member',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'mpa_add_member_meta_boxes');

/**
 * Meta Box Callback
 */
function mpa_member_details_callback($post) {
    wp_nonce_field('mpa_save_member_meta', 'mpa_member_nonce');
    
    $website = get_post_meta($post->ID, '_member_website', true);
    $vertical = get_post_meta($post->ID, '_member_vertical', true);
    $categories = get_post_meta($post->ID, '_member_categories', true);
    $contact_name = get_post_meta($post->ID, '_contact_name', true);
    $contact_email = get_post_meta($post->ID, '_contact_email', true);
    $contact_phone = get_post_meta($post->ID, '_contact_phone', true);
    ?>
    <p>
        <label for="member_website"><strong>Website URL:</strong></label><br>
        <input type="url" id="member_website" name="member_website" value="<?php echo esc_attr($website); ?>" style="width: 100%;" placeholder="https://example.com">
    </p>
    
    <p>
        <label for="member_vertical"><strong>Vertical / Focus Area:</strong></label><br>
        <select id="member_vertical" name="member_vertical" style="width: 100%;">
            <option value="">Select Vertical</option>
            <option value="PLAN & CONSTRUCT" <?php selected($vertical, 'PLAN & CONSTRUCT'); ?>>PLAN & CONSTRUCT</option>
            <option value="MARKET & TRANSACT" <?php selected($vertical, 'MARKET & TRANSACT'); ?>>MARKET & TRANSACT</option>
            <option value="OPERATE & MANAGE" <?php selected($vertical, 'OPERATE & MANAGE'); ?>>OPERATE & MANAGE</option>
            <option value="REINVEST, REPORT & REGENERATE" <?php selected($vertical, 'REINVEST, REPORT & REGENERATE'); ?>>REINVEST, REPORT & REGENERATE</option>
        </select>
    </p>
    
    <p>
        <label for="member_categories"><strong>Categories / Tags:</strong></label><br>
        <small>Select categories (will appear based on selected vertical)</small><br>
        <div id="admin_categories_container" style="display:grid;grid-template-columns:repeat(2,1fr);gap:8px;margin-top:10px;">
            <?php if ($vertical): 
                $existing_cats = $categories ? explode(', ', $categories) : array();
                // Get categories from centralized database settings
                $all_verticals = mpa_get_vertical_categories();
                $cats = isset($all_verticals[$vertical]['categories']) ? $all_verticals[$vertical]['categories'] : array();
                foreach ($cats as $cat):
                    $checked = in_array($cat, $existing_cats) ? 'checked' : '';
            ?>
                <label style="display:flex;align-items:center;gap:6px;padding:6px;border:1px solid #ddd;border-radius:3px;background:#f9f9f9;cursor:pointer;">
                    <input type="checkbox" name="admin_categories[]" value="<?php echo esc_attr($cat); ?>" <?php echo $checked; ?>> <?php echo esc_html($cat); ?>
                </label>
            <?php endforeach; else: ?>
                <p style="grid-column:1/-1;color:#666;font-style:italic;">Select a Vertical above to see available categories</p>
            <?php endif; ?>
        </div>
        <input type="hidden" id="member_categories" name="member_categories" value="<?php echo esc_attr($categories); ?>">
    </p>
    
    <script>
    jQuery(document).ready(function($) {
        // Category options based on vertical (loaded from database)
        const verticalCategories = <?php echo json_encode(array_map(function($v) { return $v['categories']; }, mpa_get_vertical_categories())); ?>;
        
        // Update categories when vertical changes
        $('#member_vertical').on('change', function() {
            const vertical = $(this).val();
            const container = $('#admin_categories_container');
            
            if (!vertical) {
                container.html('<p style="grid-column:1/-1;color:#666;font-style:italic;">Select a Vertical above to see available categories</p>');
                return;
            }
            
            const categories = verticalCategories[vertical] || [];
            const currentCats = $('#member_categories').val().split(', ').filter(c => c);
            
            container.html(categories.map(cat => {
                const checked = currentCats.includes(cat) ? 'checked' : '';
                return `<label style="display:flex;align-items:center;gap:6px;padding:6px;border:1px solid #ddd;border-radius:3px;background:#f9f9f9;cursor:pointer;">
                    <input type="checkbox" name="admin_categories[]" value="${cat}" ${checked}> ${cat}
                </label>`;
            }).join(''));
            
            updateCategoriesField();
        });
        
        // Update hidden field when checkboxes change
        $(document).on('change', 'input[name="admin_categories[]"]', function() {
            updateCategoriesField();
        });
        
        function updateCategoriesField() {
            const selected = [];
            $('input[name="admin_categories[]"]:checked').each(function() {
                selected.push($(this).val());
            });
            $('#member_categories').val(selected.join(', '));
        }
    });
    </script>
    
    <hr style="margin: 20px 0;">
    <h3>Contact Information</h3>
    
    <p>
        <label for="contact_name"><strong>Contact Person:</strong></label><br>
        <input type="text" id="contact_name" name="contact_name" value="<?php echo esc_attr($contact_name); ?>" style="width: 100%;" placeholder="John Doe">
    </p>
    
    <p>
        <label for="contact_email"><strong>Contact Email:</strong></label><br>
        <input type="email" id="contact_email" name="contact_email" value="<?php echo esc_attr($contact_email); ?>" style="width: 100%;" placeholder="contact@example.com">
    </p>
    
    <p>
        <label for="contact_phone"><strong>Contact Phone:</strong></label><br>
        <input type="tel" id="contact_phone" name="contact_phone" value="<?php echo esc_attr($contact_phone); ?>" style="width: 100%;" placeholder="+60123456789">
    </p>
    
    <hr style="margin: 20px 0;">
    
    <p>
        <label><strong>Logo Image:</strong></label><br>
        <small>Use the "Featured Image" section on the right sidebar to upload the member's logo</small>
    </p>
    
    <p>
        <label><strong>Description:</strong></label><br>
        <small>Use the main editor above to enter the member's description</small>
    </p>
    <?php
}

/**
 * Save Member Meta Data
 */
function mpa_save_member_meta($post_id) {
    // Check nonce
    if (!isset($_POST['mpa_member_nonce']) || !wp_verify_nonce($_POST['mpa_member_nonce'], 'mpa_save_member_meta')) {
        return;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save website URL
    if (isset($_POST['member_website'])) {
        update_post_meta($post_id, '_member_website', esc_url_raw($_POST['member_website']));
    }

    // Save vertical
    if (isset($_POST['member_vertical'])) {
        update_post_meta($post_id, '_member_vertical', sanitize_text_field($_POST['member_vertical']));
    }

    // Save categories
    if (isset($_POST['member_categories'])) {
        update_post_meta($post_id, '_member_categories', sanitize_text_field($_POST['member_categories']));
    }

    // Save contact information
    if (isset($_POST['contact_name'])) {
        update_post_meta($post_id, '_contact_name', sanitize_text_field($_POST['contact_name']));
    }

    if (isset($_POST['contact_email'])) {
        update_post_meta($post_id, '_contact_email', sanitize_email($_POST['contact_email']));
    }

    if (isset($_POST['contact_phone'])) {
        update_post_meta($post_id, '_contact_phone', sanitize_text_field($_POST['contact_phone']));
    }
}
add_action('save_post_mpa_member', 'mpa_save_member_meta');

/**
 * Add custom columns to Members admin list
 */
function mpa_member_custom_columns($columns) {
    $new_columns = array();
    $new_columns["cb"] = $columns["cb"];
    $new_columns["title"] = "Member";
    $new_columns["logo"] = "Logo";
    $new_columns["description"] = "Description";
    $new_columns["website"] = "Website";
    $new_columns["categories"] = "Categories";
    return $new_columns;
}
add_filter('manage_mpa_member_posts_columns', 'mpa_member_custom_columns');

/**
 * Populate custom columns with member data
 */
function mpa_member_custom_column_content($column, $post_id) {
    switch ($column) {
        case 'logo':
            $logo_id = get_post_thumbnail_id($post_id);
            if ($logo_id) {
                $logo_url = wp_get_attachment_image_url($logo_id, 'thumbnail');
                echo '<img src="' . esc_url($logo_url) . '" style="max-width: 60px; height: auto; border-radius: 4px;" alt="Logo">';
            } else {
                echo '<span style="color: #999;">No logo</span>';
            }
            break;
            
        case 'description':
            $post = get_post($post_id);
            $description = wp_trim_words($post->post_content, 15);
            echo $description ? esc_html($description) : '<span style="color: #999;">No description</span>';
            break;
            
        case 'website':
            $website = get_post_meta($post_id, '_member_website', true);
            if ($website) {
                echo '<a href="' . esc_url($website) . '" target="_blank" rel="noopener">' . esc_html(parse_url($website, PHP_URL_HOST)) . ' <span class="dashicons dashicons-external" style="font-size: 14px;"></span></a>';
            } else {
                echo '<span style="color: #999;">No website</span>';
            }
            break;
            
        case 'categories':
            $cats = get_post_meta($post_id, '_member_categories', true);
            if ($cats) {
                $cats_array = array_map('trim', explode(',', $cats));
                $limited = array_slice($cats_array, 0, 3);
                echo '<span style="font-size: 11px;">' . esc_html(implode(', ', $limited));
                if (count($cats_array) > 3) {
                    echo ' <strong>+' . (count($cats_array) - 3) . '</strong>';
                }
                echo '</span>';
            } else {
                echo '<span style="color: #999;">-</span>';
            }
            break;
        
        case 'vertical':
            $vertical = get_post_meta($post_id, '_member_vertical', true);
            if ($vertical) {
                $color_map = array(
                    'PLAN & CONSTRUCT' => '#3b82f6',
                    'MARKET & TRANSACT' => '#10b981',
                    'OPERATE & MANAGE' => '#f59e0b',
                    'REINVEST, REPORT & REGENERATE' => '#8b5cf6'
                );
                $color = isset($color_map[$vertical]) ? $color_map[$vertical] : '#6b7280';
                echo '<span style="background: ' . $color . '; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; white-space: nowrap;">' . esc_html($vertical) . '</span>';
            } else {
                echo '<span style="color: #999;">-</span>';
            }
            break;
            
        case 'subcategory':
            $categories = get_post_meta($post_id, '_member_categories', true);
            if ($categories) {
                $cats = array_map('trim', explode(',', $categories));
                echo '<div style="font-size: 11px; line-height: 1.4;">';
                foreach ($cats as $cat) {
                    echo '<span style="display: inline-block; margin-right: 5px; margin-bottom: 3px;">';
                    echo esc_html($cat);
                    if ($cat !== end($cats)) echo ',';
                    echo '</span>';
                }
                echo '</div>';
            } else {
                echo '<span style="color: #999;">-</span>';
            }
            break;
}
    }
add_action('manage_mpa_member_posts_custom_column', 'mpa_member_custom_column_content', 10, 2);

/**
 * Make columns sortable
 */
function mpa_member_sortable_columns($columns) {
    $columns['website'] = 'website';
    $columns['categories'] = 'categories';
    return $columns;
}
add_filter('manage_edit-mpa_member_sortable_columns', 'mpa_member_sortable_columns');

/**
 * Update member columns to include Featured column
 */
function mpa_update_member_columns_with_featured($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['featured'] = '⭐';
    $new_columns['title'] = 'Member';
    $new_columns['logo'] = 'Logo';
    $new_columns['vertical'] = 'Vertical';
    $new_columns['subcategory'] = 'Subcategory';
    $new_columns['description'] = 'Description';
    $new_columns['website'] = 'Website';
    return $new_columns;
}
add_filter('manage_mpa_member_posts_columns', 'mpa_update_member_columns_with_featured', 15);

/**
 * Display Featured column content
 */
function mpa_display_featured_column($column, $post_id) {
    if ($column === 'featured') {
        $is_featured = get_post_meta($post_id, '_member_featured', true);
        if ($is_featured == '1') {
            echo '<span style="font-size: 20px; color: #fbbf24;" title="Featured">⭐</span>';
        } else {
            echo '<span style="color: #ddd;" title="Not featured">☆</span>';
        }
    }
}
add_action('manage_mpa_member_posts_custom_column', 'mpa_display_featured_column', 15, 2);

/**
 * Add Featured checkbox to Member Details meta box
 */
function mpa_add_featured_checkbox() {
    global $post;
    if ($post && $post->post_type === 'mpa_member') {
        $is_featured = get_post_meta($post->ID, '_member_featured', true);
        ?>
        <script>
        jQuery(document).ready(function($) {
            var featuredHTML = '<p style="border-top: 1px solid #ddd; padding-top: 10px; margin-top: 10px;"><label><input type="checkbox" name="member_featured" value="1" <?php echo ($is_featured == "1" ? "checked" : ""); ?>><strong style="font-size: 14px;"> ⭐ Feature this member</strong></label><br><small>Check this to display this member in the "Featured Members" section on the members page</small></p>';
            $('#member_details .inside').append(featuredHTML);
        });
        </script>
        <?php
    }
}
add_action('admin_head', 'mpa_add_featured_checkbox');

/**
 * Save Featured status
 */
function mpa_save_featured_checkbox($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (!isset($_POST['post_type']) || $_POST['post_type'] !== 'mpa_member') return;
    
    if (isset($_POST['member_featured'])) {
        update_post_meta($post_id, '_member_featured', '1');
    } else {
        update_post_meta($post_id, '_member_featured', '0');
    }
}
add_action('save_post', 'mpa_save_featured_checkbox');

/**
 * Adjust member column widths
 */
function mpa_member_column_widths() {
    global $post_type;
    if ($post_type == 'mpa_member') {
        ?>
        <style>
            .wp-list-table .column-cb { width: 2.5% !important; }
            .wp-list-table .column-featured { width: 3% !important; text-align: center; }
            .wp-list-table .column-title { width: 10% !important; }
            .wp-list-table .column-logo { width: 7% !important; }
            .wp-list-table .column-vertical { width: 15% !important; }
            .wp-list-table .column-subcategory { width: 20% !important; }
            .wp-list-table .column-description { width: 28% !important; }
            .wp-list-table .column-website { width: 12% !important; }
            .wp-list-table .column-vertical span { display: inline-block; word-break: break-word; }
        </style>
        <?php
    }
}
add_action('admin_head', 'mpa_member_column_widths');

// ============================================================================
// MEMBER SUBMISSION SYSTEM - Functions Only
// ============================================================================

// Handle form submission via AJAX
add_action('wp_ajax_submit_member_application', 'handle_member_submission');
add_action('wp_ajax_nopriv_submit_member_application', 'handle_member_submission');

function handle_member_submission() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'member_submission_nonce')) {
        wp_send_json_error(['message' => 'Security verification failed']);
        return;
    }
    
    // Validate required fields
    $required_fields = ['company_name', 'company_description', 'company_website', 'contact_name', 'contact_email', 'vertical'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            wp_send_json_error(['message' => 'Please fill in all required fields']);
            return;
        }
    }
    
    // Validate categories (array)
    if (empty($_POST['categories']) || !is_array($_POST['categories'])) {
        wp_send_json_error(['message' => 'Please select at least one category']);
        return;
    }
    
    // Validate logo upload
    if (empty($_FILES['company_logo']['name'])) {
        wp_send_json_error(['message' => 'Company logo is required. Please upload a logo image.']);
        return;
    }
    
    // Sanitize inputs
    $company_name = sanitize_text_field($_POST['company_name']);
    $company_description = sanitize_textarea_field($_POST['company_description']);
    $company_website = esc_url_raw($_POST['company_website']);
    $vertical = sanitize_text_field($_POST['vertical']);
    // Convert categories array to comma-separated string
    $categories = is_array($_POST['categories']) 
        ? implode(', ', array_map('sanitize_text_field', $_POST['categories']))
        : sanitize_text_field($_POST['categories']);
    $subcategory = sanitize_text_field($_POST['subcategory'] ?? '');
    $contact_name = sanitize_text_field($_POST['contact_name']);
    $contact_email = sanitize_email($_POST['contact_email']);
    $contact_phone = sanitize_text_field($_POST['contact_phone'] ?? '');
    $linkedin = esc_url_raw($_POST['linkedin'] ?? '');
    $additional_info = sanitize_textarea_field($_POST['additional_info'] ?? '');
    
    // Create pending member post
    $post_data = array(
        'post_title' => $company_name,
        'post_content' => $company_description,
        'post_type' => 'mpa_member',
        'post_status' => 'pending',
        'meta_input' => array(
            '_member_website' => $company_website,
            '_member_vertical' => $vertical,
            '_member_categories' => $categories,
            '_member_subcategory' => $subcategory,
            '_contact_name' => $contact_name,
            '_contact_email' => $contact_email,
            '_contact_phone' => $contact_phone,
            '_member_linkedin' => $linkedin,
            '_additional_info' => $additional_info,
            '_submission_date' => current_time('mysql'),
            '_member_featured' => '0'
        )
    );
    
    $post_id = wp_insert_post($post_data);
    
    if (is_wp_error($post_id)) {
        wp_send_json_error(['message' => 'Failed to submit application']);
        return;
    }
    
    // Handle logo upload
    if (!empty($_FILES['company_logo']['name'])) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        
        $upload = wp_handle_upload($_FILES['company_logo'], array('test_form' => false));
        
        if (!isset($upload['error'])) {
            $attachment = array(
                'post_mime_type' => $upload['type'],
                'post_title' => $company_name . ' Logo',
                'post_content' => '',
                'post_status' => 'inherit'
            );
            
            $attach_id = wp_insert_attachment($attachment, $upload['file'], $post_id);
            $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
            wp_update_attachment_metadata($attach_id, $attach_data);
            set_post_thumbnail($post_id, $attach_id);
        }
    }
    
    // Send email to admin
    $admin_email = get_option('admin_email');
    wp_mail($admin_email, 'New Member Application: ' . $company_name, 
        "Review at: " . admin_url('edit.php?post_status=pending&post_type=mpa_member'));
    
    wp_send_json_success([
        'message' => 'Thank you! Your application has been submitted and is pending approval.'
    ]);
}

// Add admin menu for approvals
add_action('admin_menu', 'add_member_approval_menu');

function add_member_approval_menu() {
    add_submenu_page(
        'edit.php?post_type=mpa_member',
        'Pending Approvals',
        'Pending Approvals',
        'edit_posts',
        'member-approvals',
        'render_member_approval_page'
    );
}

function render_member_approval_page() {
    // Handle approve action
    if (isset($_POST['approve_member']) && isset($_POST['post_id'])) {
        $post_id = intval($_POST['post_id']);
        
        // Update post status to publish
        wp_update_post(array('ID' => $post_id, 'post_status' => 'publish'));
        
        // Ensure all metadata is properly saved (sometimes gets lost during approval)
        $website = get_post_meta($post_id, '_member_website', true);
        $vertical = get_post_meta($post_id, '_member_vertical', true);
        $categories = get_post_meta($post_id, '_member_categories', true);
        $contact_name = get_post_meta($post_id, '_contact_name', true);
        $contact_email = get_post_meta($post_id, '_contact_email', true);
        $contact_phone = get_post_meta($post_id, '_contact_phone', true);
        
        // Re-save all metadata to ensure it's preserved
        if ($website) update_post_meta($post_id, '_member_website', $website);
        if ($vertical) update_post_meta($post_id, '_member_vertical', $vertical);
        if ($categories) update_post_meta($post_id, '_member_categories', $categories);
        if ($contact_name) update_post_meta($post_id, '_contact_name', $contact_name);
        if ($contact_email) update_post_meta($post_id, '_contact_email', $contact_email);
        if ($contact_phone) update_post_meta($post_id, '_contact_phone', $contact_phone);
        
        // Send approval email
        if ($contact_email) {
            wp_mail($contact_email, 'MPA Membership Approved', 
                'Your membership application has been approved and is now live on our website!');
        }
        echo '<div class="notice notice-success"><p>Member approved and published with all details preserved!</p></div>';
    }
    
    // Handle reject action
    if (isset($_POST['reject_member']) && isset($_POST['post_id'])) {
        wp_delete_post(intval($_POST['post_id']), true);
        echo '<div class="notice notice-success"><p>Application rejected and deleted.</p></div>';
    }
    
    $pending = get_posts(array(
        'post_type' => 'mpa_member',
        'post_status' => 'pending',
        'numberposts' => -1
    ));
    
    echo '<div class="wrap"><h1>Pending Member Approvals</h1>';
    
    if (empty($pending)) {
        echo '<p>No pending applications.</p>';
    } else {
        foreach ($pending as $member) {
            $id = $member->ID;
            
            // Get all metadata
            $website = get_post_meta($id, '_member_website', true);
            $vertical = get_post_meta($id, '_member_vertical', true);
            $categories = get_post_meta($id, '_member_categories', true);
            $contact_name = get_post_meta($id, '_contact_name', true);
            $contact_email = get_post_meta($id, '_contact_email', true);
            $contact_phone = get_post_meta($id, '_contact_phone', true);
            $submission_date = get_post_meta($id, '_submission_date', true);
            $logo_id = get_post_thumbnail_id($id);
            $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'medium') : '';
            
            echo '<div style="background:#fff;padding:25px;margin:15px 0;border:1px solid #ccc;border-radius:5px;box-shadow:0 2px 4px rgba(0,0,0,0.1);">';
            
            // Header with company name and logo
            echo '<div style="display:flex;align-items:center;gap:20px;margin-bottom:20px;">';
            if ($logo_url) {
                echo '<img src="' . esc_url($logo_url) . '" alt="Logo" style="width:80px;height:80px;object-fit:contain;border:1px solid #ddd;border-radius:5px;padding:5px;background:#f9f9f9;">';
            }
            echo '<div>';
            echo '<h2 style="margin:0 0 5px 0;">' . esc_html($member->post_title) . '</h2>';
            if ($submission_date) {
                echo '<small style="color:#666;">Submitted: ' . esc_html($submission_date) . '</small>';
            }
            echo '</div>';
            echo '</div>';
            
            // SUMMARY BOX - Everything they entered
            echo '<div style="background:#f0f8ff;border-left:4px solid #0073aa;padding:15px;margin-bottom:20px;border-radius:4px;">';
            echo '<h3 style="margin:0 0 15px 0;font-size:16px;color:#0073aa;">📋 Application Summary - Everything They Entered</h3>';
            echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;font-size:14px;">';
            
            echo '<div><strong>Company Name:</strong><br>' . esc_html($member->post_title) . '</div>';
            echo '<div><strong>Website:</strong><br><a href="' . esc_url($website) . '" target="_blank">' . esc_html($website) . '</a></div>';
            
            if ($vertical) {
                $color_map = array(
                    'PLAN & CONSTRUCT' => '#3b82f6',
                    'MARKET & TRANSACT' => '#10b981',
                    'OPERATE & MANAGE' => '#f59e0b',
                    'REINVEST, REPORT & REGENERATE' => '#8b5cf6'
                );
                $color = isset($color_map[$vertical]) ? $color_map[$vertical] : '#6b7280';
                echo '<div><strong>Vertical:</strong><br><span style="background: ' . $color . '; color: white; padding: 3px 8px; border-radius: 3px; font-size: 12px; font-weight: 600;">' . esc_html($vertical) . '</span></div>';
            } else {
                echo '<div><strong>Vertical:</strong><br><span style="color:#d63638;">⚠️ NOT PROVIDED</span></div>';
            }
            
            echo '<div><strong>Categories/Tags:</strong><br>' . esc_html($categories) . '</div>';
            echo '<div><strong>Contact Person:</strong><br>' . esc_html($contact_name) . '</div>';
            echo '<div><strong>Contact Email:</strong><br><a href="mailto:' . esc_attr($contact_email) . '">' . esc_html($contact_email) . '</a></div>';
            
            if ($contact_phone) {
                echo '<div><strong>Contact Phone:</strong><br>' . esc_html($contact_phone) . '</div>';
            } else {
                echo '<div><strong>Contact Phone:</strong><br><span style="color:#999;">Not provided</span></div>';
            }
            
            if ($logo_url) {
                echo '<div><strong>Logo:</strong><br>✅ Uploaded (<a href="' . esc_url($logo_url) . '" target="_blank">view</a>)</div>';
            } else {
                echo '<div><strong>Logo:</strong><br><span style="color:#d63638;">❌ Not uploaded</span></div>';
            }
            
            echo '</div>';
            
            echo '<div style="margin-top:15px;padding-top:15px;border-top:1px solid #ddd;">';
            echo '<strong>Description:</strong><br>';
            echo '<div style="margin-top:8px;color:#555;line-height:1.6;">' . nl2br(esc_html($member->post_content)) . '</div>';
            echo '</div>';
            
            echo '</div>';
            
            // Action buttons
            echo '<div style="display:flex;gap:10px;">';
            
            // Edit button (opens in WordPress editor)
            echo '<a href="' . admin_url('post.php?post=' . $id . '&action=edit') . '" class="button" style="background:#f0f0f0;">✏️ Edit Before Approval</a>';
            
            // Approve button
            echo '<form method="post" style="display:inline;">';
            echo '<input type="hidden" name="post_id" value="' . $id . '">';
            echo '<button type="submit" name="approve_member" class="button button-primary" onclick="return confirm(\'Approve this member?\');">✅ Approve & Publish</button>';
            echo '</form>';
            
            // Reject button
            echo '<form method="post" style="display:inline;">';
            echo '<input type="hidden" name="post_id" value="' . $id . '">';
            echo '<button type="submit" name="reject_member" class="button" style="background:#dc3232;color:#fff;border-color:#dc3232;" onclick="return confirm(\'Delete this application permanently?\');">❌ Reject & Delete</button>';
            echo '</form>';
            
            echo '</div>';
            echo '</div>';
        }
    }
    
    echo '</div>';
}



// ========================================
// EVENT REGISTRATION SYSTEM
// ========================================

// Register custom post type for event registrations
function register_event_registration_post_type() {
    $args = array(
        'labels' => array(
            'name' => 'Event Registrations',
            'singular_name' => 'Event Registration',
            'add_new' => 'Add New Registration',
            'add_new_item' => 'Add New Registration',
            'edit_item' => 'View Registration',
            'view_item' => 'View Registration',
            'all_items' => 'All Registrations',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => 'edit.php?post_type=mpa_event',
        'capability_type' => 'post',
        'supports' => array('title'),
        'menu_icon' => 'dashicons-clipboard',
    );
    register_post_type('event_registration', $args);
}
add_action('init', 'register_event_registration_post_type');

// Add meta box for registration details
function add_registration_meta_box() {
    add_meta_box(
        'registration_details',
        'Registration Details',
        'registration_details_callback',
        'event_registration',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_registration_meta_box');

function registration_details_callback($post) {
    $event_id = get_post_meta($post->ID, '_event_id', true);
    $full_name = get_post_meta($post->ID, '_full_name', true);
    $email = get_post_meta($post->ID, '_email', true);
    $phone = get_post_meta($post->ID, '_phone', true);
    $company = get_post_meta($post->ID, '_company', true);
    $job_title = get_post_meta($post->ID, '_job_title', true);
    $dietary = get_post_meta($post->ID, '_dietary', true);
    $notes = get_post_meta($post->ID, '_notes', true);
    $registered_date = get_post_meta($post->ID, '_registered_date', true);
    
    $event = get_post($event_id);
    $event_title = $event ? $event->post_title : 'Unknown Event';
    
    ?>
    <div style="background:#f0f8ff;padding:20px;border-radius:8px;margin-bottom:20px;">
        <h3 style="margin:0 0 15px 0;color:#0073aa;">📋 Attendee Information</h3>
        
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;margin-bottom:20px;">
            <div>
                <strong>Event:</strong><br>
                <?php if ($event_id): ?>
                    <a href="<?php echo get_permalink($event_id); ?>" target="_blank">
                        <?php echo esc_html($event_title); ?>
                    </a>
                    <br>
                    <small><a href="<?php echo admin_url('post.php?post=' . $event_id . '&action=edit'); ?>">Edit Event</a></small>
                <?php else: ?>
                    <span style="color:#999;">Not specified</span>
                <?php endif; ?>
            </div>
            
            <div>
                <strong>Registration Date:</strong><br>
                <?php echo $registered_date ? date('F j, Y g:i A', strtotime($registered_date)) : get_the_date('F j, Y g:i A', $post->ID); ?>
            </div>
        </div>
        
        <hr style="margin:20px 0;border:none;border-top:1px solid #ddd;">
        
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;">
            <div>
                <strong>Full Name:</strong><br>
                <?php echo esc_html($full_name); ?>
            </div>
            
            <div>
                <strong>Email:</strong><br>
                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
            </div>
            
            <div>
                <strong>Phone:</strong><br>
                <a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_html($phone); ?></a>
            </div>
            
            <div>
                <strong>Company:</strong><br>
                <?php echo $company ? esc_html($company) : '<span style="color:#999;">Not provided</span>'; ?>
            </div>
            
            <div>
                <strong>Job Title:</strong><br>
                <?php echo $job_title ? esc_html($job_title) : '<span style="color:#999;">Not provided</span>'; ?>
            </div>
            
            <div>
                <strong>Dietary Requirements:</strong><br>
                <?php echo $dietary ? esc_html(ucfirst($dietary)) : '<span style="color:#999;">None</span>'; ?>
            </div>
        </div>
        
        <?php if ($notes): ?>
        <div style="margin-top:20px;padding-top:20px;border-top:1px solid #ddd;">
            <strong>Special Requests / Notes:</strong><br>
            <div style="margin-top:8px;padding:10px;background:#fff;border-radius:4px;color:#555;">
                <?php echo nl2br(esc_html($notes)); ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <div style="background:#fff3cd;border-left:4px solid #ffc107;padding:15px;border-radius:4px;">
        <strong>💡 Note:</strong> This registration is view-only. To export registrations, use the "Export" button in the Registrations list.
    </div>
    <?php
}

// Handle AJAX registration submission
function handle_event_registration() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'event_registration_nonce')) {
        wp_send_json_error(array('message' => 'Security verification failed'));
        return;
    }
    
    // Validate required fields
    $required_fields = array('event_id', 'full_name', 'email', 'phone', 'membership_status');
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            wp_send_json_error(array('message' => 'Please fill in all required fields'));
            return;
        }
    }
    
    // Sanitize inputs
    $event_id = intval($_POST['event_id']);
    $full_name = sanitize_text_field($_POST['full_name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $company = sanitize_text_field($_POST['company']);
    $job_title = sanitize_text_field($_POST['job_title']);
    $membership_status = sanitize_text_field($_POST['membership_status']);
    $dietary = sanitize_text_field($_POST['dietary']);
    $notes = sanitize_textarea_field($_POST['notes']);
    
    // Validate email
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Invalid email address'));
        return;
    }
    
    // Check if event exists
    $event = get_post($event_id);
    if (!$event || $event->post_type !== 'mpa_event') {
        wp_send_json_error(array('message' => 'Invalid event'));
        return;
    }
    
    // Create registration
    $post_data = array(
        'post_title' => $full_name . ' - ' . $event->post_title,
        'post_type' => 'event_registration',
        'post_status' => 'publish',
        'meta_input' => array(
            '_event_id' => $event_id,
            '_full_name' => $full_name,
            '_email' => $email,
            '_phone' => $phone,
            '_company' => $company,
            '_job_title' => $job_title,
            '_membership_status' => $membership_status,
            '_dietary' => $dietary,
            '_notes' => $notes,
            '_registered_date' => current_time('mysql'),
        )
    );
    
    $registration_id = wp_insert_post($post_data);
    
    if (is_wp_error($registration_id)) {
        wp_send_json_error(array('message' => 'Failed to create registration'));
        return;
    }
    
    // Send confirmation email to attendee (HTML)
    $attendee_data = array(
        'full_name' => $full_name,
        'email' => $email,
        'phone' => $phone,
        'company' => $company,
        'job_title' => $job_title,
        'membership_status' => $membership_status,
        'dietary' => $dietary
    );
    
    $to = $email;
    $subject = '✅ Registration Confirmed - ' . $event->post_title;
    $message = get_event_registration_email_html($event, $attendee_data);
    
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Proptech Notification <notification@proptech.org.my>'
    );
    wp_mail($to, $subject, $message, $headers);
    
    // Send notification to admin
    $admin_email = get_option('admin_email');
    $admin_subject = 'New Event Registration: ' . $event->post_title;
    $admin_message = "New event registration received:\n\n";
    $admin_message .= "Event: " . $event->post_title . "\n";
    $admin_message .= "Name: " . $full_name . "\n";
    $admin_message .= "Email: " . $email . "\n";
    $admin_message .= "Phone: " . $phone . "\n";
    if ($company) $admin_message .= "Company: " . $company . "\n";
    if ($job_title) $admin_message .= "Job Title: " . $job_title . "\n";
    $membership_label = ($membership_status === 'mpa_member') ? 'MPA Member' : 'Non-MPA Member';
    $admin_message .= "Membership Status: " . $membership_label . "\n";
    if ($dietary) $admin_message .= "Dietary: " . $dietary . "\n";
    if ($notes) $admin_message .= "Notes: " . $notes . "\n";
    $admin_message .= "\nView Registration: " . admin_url('post.php?post=' . $registration_id . '&action=edit');
    
    wp_mail($admin_email, $admin_subject, $admin_message, $headers);
    
    wp_send_json_success(array('message' => 'Registration successful'));
}
add_action('wp_ajax_submit_event_registration', 'handle_event_registration');
add_action('wp_ajax_nopriv_submit_event_registration', 'handle_event_registration');

// Add registration count to event admin columns
function add_registration_count_column($columns) {
    $columns['registrations'] = 'Registrations';
    return $columns;
}
add_filter('manage_mpa_event_posts_columns', 'add_registration_count_column');

function show_registration_count_column($column, $post_id) {
    if ($column === 'registrations') {
        $args = array(
            'post_type' => 'event_registration',
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => '_event_id',
                    'value' => $post_id,
                )
            ),
            'posts_per_page' => -1,
        );
        $registrations = new WP_Query($args);
        $count = $registrations->found_posts;
        
        if ($count > 0) {
            echo '<strong style="color:#0073aa;">' . $count . ' attendees</strong>';
            echo '<br><a href="' . admin_url('edit.php?post_type=event_registration&event_filter=' . $post_id) . '">View List</a>';
        } else {
            echo '<span style="color:#999;">0 registrations</span>';
        }
    }
}
add_action('manage_mpa_event_posts_custom_column', 'show_registration_count_column', 10, 2);

// Add dropdown filter for registrations by event
function add_event_filter_dropdown() {
    global $typenow;
    
    if ($typenow == 'event_registration') {
        // Get all events
        $events = get_posts(array(
            'post_type' => 'mpa_event',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'meta_value',
            'meta_key' => '_event_date',
            'order' => 'DESC'
        ));
        
        $current_filter = isset($_GET['event_filter']) ? $_GET['event_filter'] : '';
        
        echo '<select name="event_filter" id="event_filter">';
        echo '<option value="">All Events</option>';
        
        foreach ($events as $event) {
            $event_date = get_post_meta($event->ID, '_event_date', true);
            $formatted_date = $event_date ? date('M j, Y', strtotime($event_date)) : '';
            $display_name = $event->post_title . ($formatted_date ? ' (' . $formatted_date . ')' : '');
            
            printf(
                '<option value="%s"%s>%s</option>',
                $event->ID,
                selected($current_filter, $event->ID, false),
                esc_html($display_name)
            );
        }
        
        echo '</select>';
    }
}
add_action('restrict_manage_posts', 'add_event_filter_dropdown');

// Filter registrations by selected event
function filter_registrations_by_event($query) {
    global $pagenow, $typenow;
    
    if ($pagenow == 'edit.php' && $typenow == 'event_registration' && isset($_GET['event_filter']) && $_GET['event_filter'] != '') {
        $query->set('meta_query', array(
            array(
                'key' => '_event_id',
                'value' => $_GET['event_filter'],
                'compare' => '='
            )
        ));
    }
}
add_filter('pre_get_posts', 'filter_registrations_by_event');

// Add export button for registrations
function add_export_registrations_button() {
    $screen = get_current_screen();
    if ($screen->id === 'edit-event_registration') {
        ?>
        <script>
        jQuery(document).ready(function($) {
            $('.wrap h1').after('<a href="<?php echo admin_url('admin.php?action=export_event_registrations'); ?>" class="page-title-action">📥 Export to CSV</a>');
        });
        </script>
        <?php
    }
}
add_action('admin_footer', 'add_export_registrations_button');

// Handle CSV export
function export_event_registrations() {
    if (!current_user_can('manage_options') && !current_user_can('edit_posts')) {
        wp_die('Unauthorized');
    }
    
    $args = array(
        'post_type' => 'event_registration',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
    );
    
    $registrations = new WP_Query($args);
    
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="event-registrations-' . date('Y-m-d') . '.csv"');
    
    $output = fopen('php://output', 'w');
    
    // CSV headers
    fputcsv($output, array('Registration Date', 'Event', 'Full Name', 'Email', 'Phone', 'Company', 'Job Title', 'Dietary', 'Notes'));
    
    if ($registrations->have_posts()) {
        while ($registrations->have_posts()) {
            $registrations->the_post();
            $id = get_the_ID();
            
            $event_id = get_post_meta($id, '_event_id', true);
            $event = get_post($event_id);
            $event_title = $event ? $event->post_title : 'Unknown';
            
            fputcsv($output, array(
                get_post_meta($id, '_registered_date', true),
                $event_title,
                get_post_meta($id, '_full_name', true),
                get_post_meta($id, '_email', true),
                get_post_meta($id, '_phone', true),
                get_post_meta($id, '_company', true),
                get_post_meta($id, '_job_title', true),
                get_post_meta($id, '_dietary', true),
                get_post_meta($id, '_notes', true),
            ));
        }
    }
    
    fclose($output);
    exit;
}
add_action('admin_action_export_event_registrations', 'export_event_registrations');


// Add custom columns to Event Registrations list
function add_registration_list_columns($columns) {
    // Remove title and date columns
    unset($columns['title']);
    unset($columns['date']);
    
    // Add new columns
    $new_columns = array(
        'cb' => $columns['cb'],
        'attendee_name' => 'Attendee Name',
        'event_name' => 'Event',
        'email' => 'Email',
        'phone' => 'Phone',
        'company' => 'Company',
        'job_title' => 'Job Title',
        'membership_status' => 'Membership',
        'dietary' => 'Dietary',
        'registered_date' => 'Registered'
    );
    
    return $new_columns;
}
add_filter('manage_event_registration_posts_columns', 'add_registration_list_columns');

// Populate custom columns with data
function show_registration_list_columns($column, $post_id) {
    switch ($column) {
        case 'attendee_name':
            $full_name = get_post_meta($post_id, '_full_name', true);
            echo esc_html($full_name);
            break;
            
        case 'event_name':
            $event_id = get_post_meta($post_id, '_event_id', true);
            if ($event_id) {
                $event = get_post($event_id);
                if ($event) {
                    $event_date = get_post_meta($event_id, '_event_date', true);
                    $date_display = $event_date ? date('M j, Y', strtotime($event_date)) : '';
                    echo '<a href="' . get_permalink($event_id) . '" target="_blank">' . esc_html($event->post_title) . '</a>';
                    if ($date_display) {
                        echo '<br><small style="color:#666;">' . esc_html($date_display) . '</small>';
                    }
                } else {
                    echo '<span style="color:#999;">Event not found</span>';
                }
            }
            break;
            
        case 'email':
            $email = get_post_meta($post_id, '_email', true);
            if ($email) {
                echo '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
            }
            break;
            
        case 'phone':
            $phone = get_post_meta($post_id, '_phone', true);
            if ($phone) {
                echo '<a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a>';
            } else {
                echo '<span style="color:#999;">—</span>';
            }
            break;
            
        case 'company':
            $company = get_post_meta($post_id, '_company', true);
            if ($company) {
                echo esc_html($company);
            } else {
                echo '<span style="color:#999;">—</span>';
            }
            break;
            
        case 'job_title':
            $job_title = get_post_meta($post_id, '_job_title', true);
            if ($job_title) {
                echo esc_html($job_title);
            } else {
                echo '<span style="color:#999;">—</span>';
            }
            break;
            
        case 'dietary':
            $dietary = get_post_meta($post_id, '_dietary', true);
            if ($dietary) {
                // Format dietary requirement with icon
                $icon = '';
                switch(strtolower($dietary)) {
                    case 'vegetarian':
                        $icon = '🥗';
                        break;

            case 'membership_status':
                $membership_status = get_post_meta($post_id, '_membership_status', true);
                if ($membership_status) {
                    $status_label = ($membership_status === 'mpa_member') ? 'MPA Member' : 'Non-MPA Member';
                    $badge_color = ($membership_status === 'mpa_member') ? '#007AFF' : '#999';
                    echo '<span style="display:inline-block;padding:4px 8px;background:' . $badge_color . ';color:white;border-radius:4px;font-size:11px;font-weight:600;">' . esc_html($status_label) . '</span>';
                } else {
                    echo '<span style="color:#999;">—</span>';
                }
                break;
                    case 'vegan':
                        $icon = '🌱';
                        break;
                    case 'halal':
                        $icon = '☪️';
                        break;
                    case 'gluten-free':
                        $icon = '🌾';
                        break;
                    default:
                        $icon = '🍽️';
                }
                echo $icon . ' ' . esc_html(ucfirst($dietary));
            } else {
                echo '<span style="color:#999;">None</span>';
            }
            break;
            
        case 'registered_date':
            $registered_date = get_post_meta($post_id, '_registered_date', true);
            if ($registered_date) {
                echo date('M j, Y g:i A', strtotime($registered_date));
            } else {
                echo get_the_date('M j, Y g:i A', $post_id);
            }
            break;
    }
}
add_action('manage_event_registration_posts_custom_column', 'show_registration_list_columns', 10, 2);

// Make columns sortable
function make_registration_columns_sortable($columns) {
    $columns['attendee_name'] = 'attendee_name';
    $columns['event_name'] = 'event_name';
    $columns['registered_date'] = 'registered_date';
    return $columns;
}
add_filter('manage_edit-event_registration_sortable_columns', 'make_registration_columns_sortable');

// Handle sorting
function registration_column_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }
    
    $orderby = $query->get('orderby');
    
    if ('attendee_name' === $orderby) {
        $query->set('meta_key', '_full_name');
        $query->set('orderby', 'meta_value');
    } elseif ('event_name' === $orderby) {
        $query->set('meta_key', '_event_id');
        $query->set('orderby', 'meta_value_num');
    } elseif ('registered_date' === $orderby) {
        $query->set('meta_key', '_registered_date');
        $query->set('orderby', 'meta_value');
    }
}
add_action('pre_get_posts', 'registration_column_orderby');



// HTML Email Template for Event Registration Confirmation
function get_event_registration_email_html($event, $attendee_data) {
    $event_id = $event->ID;
    $event_title = $event->post_title;
    $event_date = get_post_meta($event_id, '_event_date', true);
    $event_start_time = get_post_meta($event_id, '_event_start_time', true);
    $event_end_time = get_post_meta($event_id, '_event_end_time', true);
    $event_location = get_post_meta($event_id, '_event_location', true);
    $event_image = get_the_post_thumbnail_url($event_id, 'large');
    $event_url = get_permalink($event_id);
    
    $full_name = $attendee_data['full_name'];
    $email = $attendee_data['email'];
    $phone = $attendee_data['phone'];
    $company = $attendee_data['company'];
    $membership_status = isset($attendee_data['membership_status']) ? $attendee_data['membership_status'] : '';
    $dietary = $attendee_data['dietary'];
    
    // Format date
    $formatted_date = $event_date ? date('l, F j, Y', strtotime($event_date)) : 'TBD';
    $formatted_time = '';
    if ($event_start_time && $event_end_time) {
        $formatted_time = $event_start_time . ' - ' . $event_end_time;
    } elseif ($event_start_time) {
        $formatted_time = $event_start_time;
    }
    
    ob_start();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Event Registration Confirmation</title>
    </head>
    <body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f4f4f4;">
        <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px 0;">
            <tr>
                <td align="center">
                    <!-- Main Container -->
                    <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        
                        <!-- Header -->
                        <tr>
                            <td style="background: linear-gradient(135deg, #402267 0%, #5a3a7a 100%); padding: 40px 30px; text-align: center;">
                                <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700;">✅ Registration Confirmed!</h1>
                                <p style="margin: 10px 0 0 0; color: rgba(255,255,255,0.9); font-size: 16px;">Thank you for registering</p>
                            </td>
                        </tr>
                        
                        <!-- Greeting -->
                        <tr>
                            <td style="padding: 30px 30px 20px 30px;">
                                <p style="margin: 0; font-size: 16px; color: #333333; line-height: 1.6;">
                                    Dear <strong><?php echo esc_html($full_name); ?></strong>,
                                </p>
                                <p style="margin: 15px 0 0 0; font-size: 16px; color: #333333; line-height: 1.6;">
                                    Your registration for the following event has been confirmed. We look forward to seeing you!
                                </p>
                            </td>
                        </tr>
                        
                        <!-- Event Image -->
                        <?php if ($event_image) : ?>
                        <tr>
                            <td style="padding: 0 30px;">
                                <img src="<?php echo esc_url($event_image); ?>" alt="<?php echo esc_attr($event_title); ?>" style="width: 100%; height: auto; border-radius: 8px; display: block;">
                            </td>
                        </tr>
                        <?php endif; ?>
                        
                        <!-- Event Details -->
                        <tr>
                            <td style="padding: 30px;">
                                <table width="100%" cellpadding="0" cellspacing="0" style="background: #f8f9fa; border-radius: 8px; padding: 20px;">
                                    <tr>
                                        <td>
                                            <h2 style="margin: 0 0 20px 0; font-size: 22px; color: #402267;"><?php echo esc_html($event_title); ?></h2>
                                            
                                            <!-- Date -->
                                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 12px;">
                                                <tr>
                                                    <td width="30" valign="top">
                                                        <span style="font-size: 20px;">📅</span>
                                                    </td>
                                                    <td>
                                                        <p style="margin: 0; font-size: 14px; color: #666; font-weight: 600;">Date</p>
                                                        <p style="margin: 2px 0 0 0; font-size: 16px; color: #333;"><?php echo esc_html($formatted_date); ?></p>
                                                    </td>
                                                </tr>
                                            </table>
                                            
                                            <!-- Time -->
                                            <?php if ($formatted_time) : ?>
                                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 12px;">
                                                <tr>
                                                    <td width="30" valign="top">
                                                        <span style="font-size: 20px;">🕐</span>
                                                    </td>
                                                    <td>
                                                        <p style="margin: 0; font-size: 14px; color: #666; font-weight: 600;">Time</p>
                                                        <p style="margin: 2px 0 0 0; font-size: 16px; color: #333;"><?php echo esc_html($formatted_time); ?></p>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php endif; ?>
                                            
                                            <!-- Location -->
                                            <?php if ($event_location) : ?>
                                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 12px;">
                                                <tr>
                                                    <td width="30" valign="top">
                                                        <span style="font-size: 20px;">📍</span>
                                                    </td>
                                                    <td>
                                                        <p style="margin: 0; font-size: 14px; color: #666; font-weight: 600;">Location</p>
                                                        <p style="margin: 2px 0 0 0; font-size: 16px; color: #333;"><?php echo esc_html($event_location); ?></p>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        
                        <!-- Your Registration Details -->
                        <tr>
                            <td style="padding: 0 30px 30px 30px;">
                                <h3 style="margin: 0 0 15px 0; font-size: 18px; color: #402267;">Your Registration Details</h3>
                                <table width="100%" cellpadding="8" cellspacing="0" style="border: 1px solid #e0e0e0; border-radius: 6px;">
                                    <tr style="background: #f8f9fa;">
                                        <td style="padding: 10px; font-size: 14px; color: #666; border-bottom: 1px solid #e0e0e0;"><strong>Name:</strong></td>
                                        <td style="padding: 10px; font-size: 14px; color: #333; border-bottom: 1px solid #e0e0e0;"><?php echo esc_html($full_name); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px; font-size: 14px; color: #666; border-bottom: 1px solid #e0e0e0;"><strong>Email:</strong></td>
                                        <td style="padding: 10px; font-size: 14px; color: #333; border-bottom: 1px solid #e0e0e0;"><?php echo esc_html($email); ?></td>
                                    </tr>
                                    <tr style="background: #f8f9fa;">
                                        <td style="padding: 10px; font-size: 14px; color: #666; border-bottom: 1px solid #e0e0e0;"><strong>Phone:</strong></td>
                                        <td style="padding: 10px; font-size: 14px; color: #333; border-bottom: 1px solid #e0e0e0;"><?php echo esc_html($phone); ?></td>
                                    </tr>
                                    <?php if ($company) : ?>
                                    <tr>
                                        <td style="padding: 10px; font-size: 14px; color: #666; border-bottom: 1px solid #e0e0e0;"><strong>Company:</strong></td>
                                        <td style="padding: 10px; font-size: 14px; color: #333; border-bottom: 1px solid #e0e0e0;"><?php echo esc_html($company); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if ($membership_status) : ?>
                                    <tr style="background: #f8f9fa;">
                                        <td style="padding: 10px; font-size: 14px; color: #666; border-bottom: 1px solid #e0e0e0;"><strong>Membership:</strong></td>
                                        <td style="padding: 10px; font-size: 14px; color: #333; border-bottom: 1px solid #e0e0e0;">
                                            <?php echo esc_html($membership_status === 'mpa_member' ? 'MPA Member' : 'Non-MPA Member'); ?>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if ($dietary) : ?>
                                    <tr>
                                        <td style="padding: 10px; font-size: 14px; color: #666;"><strong>Dietary:</strong></td>
                                        <td style="padding: 10px; font-size: 14px; color: #333;"><?php echo esc_html(ucfirst($dietary)); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                            </td>
                        </tr>
                        
                        <!-- CTA Button -->
                        <tr>
                            <td style="padding: 0 30px 30px 30px; text-align: center;">
                                <a href="<?php echo esc_url($event_url); ?>" style="display: inline-block; padding: 15px 40px; background-color: #007AFF; color: #ffffff; text-decoration: none; border-radius: 6px; font-size: 16px; font-weight: 600;">View Event Details</a>
                            </td>
                        </tr>
                        
                        <!-- Footer -->
                        <tr>
                            <td style="padding: 30px; background-color: #f8f9fa; text-align: center; border-top: 1px solid #e0e0e0;">
                                <p style="margin: 0 0 10px 0; font-size: 16px; color: #333; font-weight: 600;">Malaysia PropTech Association</p>
                                <p style="margin: 0 0 15px 0; font-size: 14px; color: #666;">
                                    <a href="https://proptech.org.my" style="color: #007AFF; text-decoration: none;">proptech.org.my</a>
                                </p>
                                <p style="margin: 0; font-size: 12px; color: #999;">
                                    This is an automated confirmation email. Please do not reply to this message.
                                </p>
                            </td>
                        </tr>
                        
                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>
    <?php
    return ob_get_clean();
}



// Add AJAX endpoint to send test confirmation email
function send_test_confirmation_email_ajax() {
    // Get registration ID from request
    $registration_id = isset($_POST['registration_id']) ? intval($_POST['registration_id']) : 430;
    
    // Get registration meta
    $event_id = get_post_meta($registration_id, '_event_id', true);
    $full_name = get_post_meta($registration_id, '_full_name', true);
    $email = get_post_meta($registration_id, '_email', true);
    $phone = get_post_meta($registration_id, '_phone', true);
    $company = get_post_meta($registration_id, '_company', true);
    $job_title = get_post_meta($registration_id, '_job_title', true);
    $dietary = get_post_meta($registration_id, '_dietary', true);
    
    // Get event
    $event = get_post($event_id);
    
    if (!$event) {
        wp_send_json_error(array('message' => 'Event not found'));
        return;
    }
    
    // Prepare attendee data
    $attendee_data = array(
        'full_name' => $full_name,
        'email' => $email,
        'phone' => $phone,
        'company' => $company,
        'job_title' => $job_title,
        'dietary' => $dietary
    );
    
    // Generate HTML email
    $message = get_event_registration_email_html($event, $attendee_data);
    
    // Prepare email
    $to = $email;
    $subject = '✅ Registration Confirmed - ' . $event->post_title;
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Proptech Notification <notification@proptech.org.my>'
    );
    
    // Send email
    $sent = wp_mail($to, $subject, $message, $headers);
    
    if ($sent) {
        wp_send_json_success(array(
            'message' => 'Email sent successfully!',
            'to' => $email,
            'subject' => $subject,
            'event' => $event->post_title
        ));
    } else {
        wp_send_json_error(array('message' => 'Failed to send email. Check WP Mail SMTP configuration.'));
    }
}
add_action('wp_ajax_send_test_confirmation', 'send_test_confirmation_email_ajax');
add_action('wp_ajax_nopriv_send_test_confirmation', 'send_test_confirmation_email_ajax');




// Add admin menu
add_action('admin_menu', 'mpa_add_vertical_settings_page');
function mpa_add_vertical_settings_page() {
    add_options_page(
        'Vertical & Category Settings',
        'Vertical Settings',
        'manage_options',
        'mpa-vertical-settings',
        'mpa_render_vertical_settings_page'
    );
}

// Initialize default categories if not set
add_action('admin_init', 'mpa_initialize_vertical_categories');
function mpa_initialize_vertical_categories() {
    if (!get_option('mpa_vertical_categories')) {
        $default_categories = array(
            'PLAN & CONSTRUCT' => array(
                'name' => 'PLAN & CONSTRUCT',
                'categories' => array('Feasibility', 'Land Use', 'Design', 'BIM/Digital Twins', 'Modular', 'Carbon/Supply Chain', 'Resilience', 'Permitting', 'Procurement', 'Bill of Quantities', 'Cost Data Management', 'Project Management', 'e-Tender', 'Vendor Management')
            ),
            'MARKET & TRANSACT' => array(
                'name' => 'MARKET & TRANSACT',
                'categories' => array('Sales', 'Leasing', 'Finance', 'Marketplaces', 'CRM', 'Digital Contracts', 'Title/Registry', 'Crowdfunding/Tokenized REITs')
            ),
            'OPERATE & MANAGE' => array(
                'name' => 'OPERATE & MANAGE',
                'categories' => array('Property/Facility Mgmt', 'IoT', 'Utilities', 'Tenant/Citizen Experience', 'Mobility Integration', 'Health/Wellness', 'Cybersecurity')
            ),
            'REINVEST, REPORT & REGENERATE' => array(
                'name' => 'REINVEST, REPORT & REGENERATE',
                'categories' => array('ESG & Financial Reporting', 'Portfolio Analytics', 'Regeneration', 'Recycling', 'Circular Economy', 'Deconstruction')
            )
        );
        update_option('mpa_vertical_categories', $default_categories);
    }
}

// Get vertical categories from database
function mpa_get_vertical_categories() {
    return get_option('mpa_vertical_categories', array());
}

// Render settings page
function mpa_render_vertical_settings_page() {
    // Handle form submission
    if (isset($_POST['mpa_save_verticals']) && check_admin_referer('mpa_vertical_settings')) {
        $verticals = array();
        
        if (isset($_POST['verticals']) && is_array($_POST['verticals'])) {
            foreach ($_POST['verticals'] as $key => $vertical_data) {
                $vertical_name = sanitize_text_field($vertical_data['name']);
                $categories = array();
                
                if (isset($vertical_data['categories']) && is_array($vertical_data['categories'])) {
                    foreach ($vertical_data['categories'] as $category) {
                        $cat = sanitize_text_field($category);
                        if (!empty($cat)) {
                            $categories[] = $cat;
                        }
                    }
                }
                
                if (!empty($vertical_name)) {
                    $verticals[$key] = array(
                        'name' => $vertical_name,
                        'categories' => $categories
                    );
                }
            }
        }
        
        update_option('mpa_vertical_categories', $verticals);
        echo '<div class="notice notice-success"><p>Vertical settings saved successfully!</p></div>';
    }
    
    $verticals = mpa_get_vertical_categories();
    ?>
    <div class="wrap">
        <h1>🏗️ Vertical & Category Settings</h1>
        <p>Manage your verticals and their subcategories. Changes will be reflected across all forms and displays.</p>
        
        <form method="post" action="">
            <?php wp_nonce_field('mpa_vertical_settings'); ?>
            
            <div id="vertical-settings-container">
                <?php foreach ($verticals as $key => $vertical): ?>
                    <div class="vertical-section" style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccc; border-radius: 8px;">
                        <h2 style="margin-top: 0;">
                            <span style="color: #6B46C1;">📊 Vertical <?php echo esc_html(array_search($key, array_keys($verticals)) + 1); ?></span>
                        </h2>
                        
                        <table class="form-table">
                            <tr>
                                <th><label>Vertical Name:</label></th>
                                <td>
                                    <input type="text" 
                                           name="verticals[<?php echo esc_attr($key); ?>][name]" 
                                           value="<?php echo esc_attr($vertical['name']); ?>" 
                                           class="regular-text"
                                           style="font-size: 16px; font-weight: bold;">
                                    <p class="description">You can rename this vertical, but be careful - this affects all existing members.</p>
                                </td>
                            </tr>
                            <tr>
                                <th><label>Subcategories:</label></th>
                                <td>
                                    <div class="categories-list" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 15px;">
                                        <?php foreach ($vertical['categories'] as $index => $category): ?>
                                            <div style="display: flex; align-items: center; gap: 8px; background: #f9f9f9; padding: 8px; border-radius: 4px;">
                                                <input type="text" 
                                                       name="verticals[<?php echo esc_attr($key); ?>][categories][]" 
                                                       value="<?php echo esc_attr($category); ?>" 
                                                       class="regular-text"
                                                       style="flex: 1;">
                                                <button type="button" class="button button-small remove-category" style="color: #dc2626;">✕</button>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <button type="button" class="button add-category" data-vertical="<?php echo esc_attr($key); ?>">
                                        ➕ Add Subcategory
                                    </button>
                                    <p class="description">Add, edit, or remove subcategories for this vertical.</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <p class="submit">
                <button type="submit" name="mpa_save_verticals" class="button button-primary button-large">
                    💾 Save All Changes
                </button>
            </p>
        </form>
        
        <div style="background: #fff3cd; border: 1px solid #ffc107; padding: 15px; border-radius: 8px; margin-top: 30px;">
            <h3 style="margin-top: 0;">⚠️ Important Notes:</h3>
            <ul>
                <li><strong>Renaming a vertical:</strong> This will affect the display name but won't automatically update existing member data.</li>
                <li><strong>Removing categories:</strong> Members with removed categories will keep their old values until manually updated.</li>
                <li><strong>Adding categories:</strong> New categories will be immediately available in all forms.</li>
                <li><strong>Backup:</strong> Always backup your data before making major changes.</li>
            </ul>
        </div>
    </div>
    
    <style>
        .vertical-section {
            transition: all 0.3s ease;
        }
        .vertical-section:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .remove-category:hover {
            background-color: #fee2e2 !important;
            border-color: #dc2626 !important;
        }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        // Add new category field
        $('.add-category').on('click', function() {
            var vertical = $(this).data('vertical');
            var container = $(this).prev('.categories-list');
            var newField = `
                <div style="display: flex; align-items: center; gap: 8px; background: #f9f9f9; padding: 8px; border-radius: 4px;">
                    <input type="text" 
                           name="verticals[${vertical}][categories][]" 
                           value="" 
                           class="regular-text" 
                           placeholder="Enter new category"
                           style="flex: 1;">
                    <button type="button" class="button button-small remove-category" style="color: #dc2626;">✕</button>
                </div>
            `;
            container.append(newField);
        });
        
        // Remove category field
        $(document).on('click', '.remove-category', function() {
            if (confirm('Are you sure you want to remove this category?')) {
                $(this).closest('div').remove();
            }
        });
    });
    </script>
    <?php
}




// Clear member count cache when member is saved or deleted
function mpa_clear_member_count_cache($post_id) {
    if (get_post_type($post_id) === "mpa_member") {
        // Get all verticals and clear their caches
        $verticals = mpa_get_vertical_categories();
        foreach ($verticals as $key => $vertical) {
            $cache_key = "mpa_member_count_" . sanitize_key($key);
            delete_transient($cache_key);
        }
    }
}
add_action("save_post", "mpa_clear_member_count_cache");
add_action("delete_post", "mpa_clear_member_count_cache");

// Clear events JSON cache when event is saved or deleted
function mpa_clear_events_json_cache($post_id) {
    if (get_post_type($post_id) === "mpa_event") {
        delete_transient("mpa_events_json_data");
    }
}
add_action("save_post", "mpa_clear_events_json_cache");
add_action("delete_post", "mpa_clear_events_json_cache");



/**
 * AJAX search handler for site-wide search
 */
function mpa_site_search_handler() {
    $query = isset($_POST['query']) ? sanitize_text_field($_POST['query']) : '';
    
    if (empty($query) || strlen($query) < 2) {
        wp_send_json_error(array('message' => 'Query too short'));
    }
    
    $results = array();
    
    // Search Events
    $events = new WP_Query(array(
        'post_type' => 'mpa_event',
        'posts_per_page' => 5,
        's' => $query,
        'post_status' => 'publish'
    ));
    
    if ($events->have_posts()) {
        while ($events->have_posts()) {
            $events->the_post();
            $event_date = get_post_meta(get_the_ID(), '_event_date', true);
            $event_status = get_post_meta(get_the_ID(), '_event_status', true);
            
            $results[] = array(
                'title' => get_the_title(),
                'url' => get_permalink(),
                'type' => 'Event' . ($event_status ? ' (' . ucfirst($event_status) . ')' : ''),
                'excerpt' => $event_date ? date('F j, Y', strtotime($event_date)) : ''
            );
        }
        wp_reset_postdata();
    }
    
    // Search Members
    $members = new WP_Query(array(
        'post_type' => 'mpa_member',
        'posts_per_page' => 5,
        's' => $query,
        'post_status' => 'publish'
    ));
    
    if ($members->have_posts()) {
        while ($members->have_posts()) {
            $members->the_post();
            $company = get_post_meta(get_the_ID(), '_company_name', true);
            
            $results[] = array(
                'title' => get_the_title(),
                'url' => get_permalink(),
                'type' => 'Member',
                'excerpt' => $company ? $company : ''
            );
        }
        wp_reset_postdata();
    }
    
    // Search Pages
    $pages = new WP_Query(array(
        'post_type' => 'page',
        'posts_per_page' => 3,
        's' => $query,
        'post_status' => 'publish'
    ));
    
    if ($pages->have_posts()) {
        while ($pages->have_posts()) {
            $pages->the_post();
            
            $results[] = array(
                'title' => get_the_title(),
                'url' => get_permalink(),
                'type' => 'Page',
                'excerpt' => wp_trim_words(get_the_excerpt(), 15)
            );
        }
        wp_reset_postdata();
    }
    
    // Search Posts/News
    $posts = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => 3,
        's' => $query,
        'post_status' => 'publish'
    ));
    
    if ($posts->have_posts()) {
        while ($posts->have_posts()) {
            $posts->the_post();
            
            $results[] = array(
                'title' => get_the_title(),
                'url' => get_permalink(),
                'type' => 'News/Article',
                'excerpt' => wp_trim_words(get_the_excerpt(), 15)
            );
        }
        wp_reset_postdata();
    }
    
    if (empty($results)) {
        wp_send_json_error(array('message' => 'No results found'));
    }
    
    wp_send_json_success(array(
        'results' => $results,
        'total' => count($results)
    ));
}

// Register AJAX handlers (for both logged-in and non-logged-in users)
add_action('wp_ajax_mpa_site_search', 'mpa_site_search_handler');
add_action('wp_ajax_nopriv_mpa_site_search', 'mpa_site_search_handler');

/**
 * Add native lazy loading to images
 * Improves initial page load by deferring off-screen images
 */
function mpa_add_lazy_loading($attr, $attachment = null) {
    // Add loading='lazy' to all images except those in header/hero
    if (!isset($attr['loading'])) {
        $attr['loading'] = 'lazy';
    }
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'mpa_add_lazy_loading', 10, 2);

/**
 * Add lazy loading to content images
 */
function mpa_add_lazy_loading_to_content($content) {
    // Add loading='lazy' to img tags that don't already have it
    $content = preg_replace('/<img(?![^>]*\sloading=)([^>]*)>/i', '<img loading="lazy"$1>', $content);
    return $content;
}
add_filter('the_content', 'mpa_add_lazy_loading_to_content');
add_filter('post_thumbnail_html', 'mpa_add_lazy_loading_to_content');
// Inject Polylang language URLs into JavaScript
function mpa_inject_polylang_urls() {
    if (!function_exists('pll_the_languages')) {
        return;
    }
    
    $languages = pll_the_languages(array('raw' => 1));
    $lang_urls = array();
    
    foreach ($languages as $lang) {
        $lang_urls[$lang['slug']] = $lang['url'];
    }
    
    ?>
    <script>
        window.polylangUrls = <?php echo json_encode($lang_urls); ?>;
        window.currentPolylangLang = '<?php echo pll_current_language(); ?>';
    </script>
    <?php
}
add_action('wp_head', 'mpa_inject_polylang_urls', 1);



// AGGRESSIVE FIX: Remove admin bar to prevent hoverintent errors
remove_action('init', '_wp_admin_bar_init');
add_filter('show_admin_bar', '__return_false');

// Ensure hoverintent loads if admin bar shows
function mpa_force_hoverintent_load() {
    wp_enqueue_script('hoverintent');
}
add_action('wp_enqueue_scripts', 'mpa_force_hoverintent_load', 1);
add_action('admin_enqueue_scripts', 'mpa_force_hoverintent_load', 1);




// Auto-translate hero section based on current Polylang language
function mpa_auto_translate_hero() {
    if (!function_exists('pll_current_language')) {
        return;
    }
    
    $current_lang = pll_current_language();
    if (!$current_lang || $current_lang === 'en') {
        return; // No translation needed for English
    }
    
    ?>
    <script>
    // Auto-translate hero section on page load based on Polylang language
    (function() {
        const lang = '<?php echo $current_lang; ?>';
        if (!lang || lang === 'en') return;
        
        // Translate hero title
        const heroTitle = document.querySelector('.hero-title');
        if (heroTitle && heroTitle.hasAttribute('data-' + lang)) {
            heroTitle.textContent = heroTitle.getAttribute('data-' + lang);
        }
        
        // Translate hero subtitle  
        const heroSubtitle = document.querySelector('.hero-subtitle');
        if (heroSubtitle && heroSubtitle.hasAttribute('data-' + lang)) {
            heroSubtitle.textContent = heroSubtitle.getAttribute('data-' + lang);
        }
        
        // Translate search placeholder
        const searchInput = document.querySelector('.search-input input');
        if (searchInput && lang === 'bm') {
            searchInput.placeholder = 'Cari acara, ahli, atau sumber...';
        } else if (searchInput && lang === 'cn') {
            searchInput.placeholder = '查找活动、会员或资源...';
        }
        
        // Translate search button
        const searchBtn = document.querySelector('.search-btn');
        if (searchBtn && lang === 'bm') {
            searchBtn.textContent = 'Cari';
        } else if (searchBtn && lang === 'cn') {
            searchBtn.textContent = '搜索';
        }
        
        // Translate stat labels
        const statLabels = document.querySelectorAll('.stat-label');
        if (statLabels.length >= 4) {
            if (lang === 'bm') {
                statLabels[0].textContent = 'Ahli';
                statLabels[1].textContent = 'Acara';
                statLabels[2].textContent = 'Startups';
                statLabels[3].textContent = 'Rakan Kongsi';
            } else if (lang === 'cn') {
                statLabels[0].textContent = '会员';
                statLabels[1].textContent = '活动';
                statLabels[2].textContent = '初创企业';
                statLabels[3].textContent = '合作伙伴';
            }
        }
    })();
    </script>
    <?php
}
add_action('wp_footer', 'mpa_auto_translate_hero', 999);

// Load MPA Translation frontend loader


// ============================================
// FOOTER SETTINGS - Editable in WordPress Admin
// ============================================

// Add admin menu for footer settings
add_action('admin_menu', 'mpa_footer_settings_menu');
function mpa_footer_settings_menu() {
    add_menu_page(
        'Footer Settings',
        'Footer Settings',
        'manage_options',
        'mpa-footer-settings',
        'mpa_footer_settings_page',
        'dashicons-admin-generic',
        30
    );
}

// Admin page HTML
function mpa_footer_settings_page() {
    // Save settings
    if (isset($_POST['mpa_footer_save'])) {
        check_admin_referer('mpa_footer_settings');
        
        update_option('mpa_linkedin_url', sanitize_text_field($_POST['mpa_linkedin_url']));
        update_option('mpa_twitter_url', sanitize_text_field($_POST['mpa_twitter_url']));
        update_option('mpa_facebook_url', sanitize_text_field($_POST['mpa_facebook_url']));
        update_option('mpa_instagram_url', sanitize_text_field($_POST['mpa_instagram_url']));
        update_option('mpa_youtube_url', sanitize_text_field($_POST['mpa_youtube_url']));
        update_option('mpa_contact_email', sanitize_email($_POST['mpa_contact_email']));
        update_option('mpa_contact_phone', sanitize_text_field($_POST['mpa_contact_phone']));
        update_option('mpa_contact_address', sanitize_textarea_field($_POST['mpa_contact_address']));
        
        echo '<div class="notice notice-success"><p>Settings saved!</p></div>';
    }
    
    // Get current values
    $linkedin = get_option('mpa_linkedin_url', 'https://linkedin.com/company/malaysia-proptech-association');
    $twitter = get_option('mpa_twitter_url', 'https://twitter.com/MalaysiaPropTech');
    $facebook = get_option('mpa_facebook_url', 'https://facebook.com/MalaysiaPropTechAssociation');
    $instagram = get_option('mpa_instagram_url', 'https://instagram.com/malaysiaproptech');
    $youtube = get_option('mpa_youtube_url', 'https://youtube.com/@MalaysiaPropTech');
    $email = get_option('mpa_contact_email', 'info@proptech.org.my');
    $phone = get_option('mpa_contact_phone', '+60 11 322 44 56');
    $address = get_option('mpa_contact_address', '53A, Jalan Kenari 21, Bandar Puchong Jaya, 47100 Puchong, Selangor');
    
    ?>
    <div class="wrap">
        <h1>Footer Settings</h1>
        <form method="post" action="">
            <?php wp_nonce_field('mpa_footer_settings'); ?>
            
            <h2>Social Media Links</h2>
            <table class="form-table">
                <tr>
                    <th><label for="mpa_linkedin_url">LinkedIn URL</label></th>
                    <td><input type="url" id="mpa_linkedin_url" name="mpa_linkedin_url" value="<?php echo esc_attr($linkedin); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="mpa_facebook_url">Facebook URL</label></th>
                    <td><input type="url" id="mpa_facebook_url" name="mpa_facebook_url" value="<?php echo esc_attr($facebook); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="mpa_youtube_url">YouTube URL</label></th>
                    <td><input type="url" id="mpa_youtube_url" name="mpa_youtube_url" value="<?php echo esc_attr($youtube); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="mpa_instagram_url">Instagram URL</label></th>
                    <td><input type="url" id="mpa_instagram_url" name="mpa_instagram_url" value="<?php echo esc_attr($instagram); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="mpa_twitter_url">Twitter URL</label></th>
                    <td><input type="url" id="mpa_twitter_url" name="mpa_twitter_url" value="<?php echo esc_attr($twitter); ?>" class="regular-text"></td>
                </tr>
                    <th><label for="mpa_contact_email">Email</label></th>
                    <td><input type="email" id="mpa_contact_email" name="mpa_contact_email" value="<?php echo esc_attr($email); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="mpa_contact_phone">Phone</label></th>
                    <td><input type="text" id="mpa_contact_phone" name="mpa_contact_phone" value="<?php echo esc_attr($phone); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="mpa_contact_address">Address</label></th>
                    <td><textarea id="mpa_contact_address" name="mpa_contact_address" rows="3" class="large-text"><?php echo esc_textarea($address); ?></textarea></td>
                </tr>
            </table>
            
            <p class="submit">
                <input type="submit" name="mpa_footer_save" class="button button-primary" value="Save Settings">
            </p>
        </form>
    </div>
    <?php
}

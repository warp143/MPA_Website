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
    wp_enqueue_script('mpa-custom-main', get_template_directory_uri() . '/js/main.js', array(), MPA_THEME_VERSION, true);
    
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
        $query->set('meta_key', '_event_date');
        $query->set('orderby', 'meta_value');
        $query->set('order', 'ASC'); // Earliest date first
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
        error_log('Adding meta box for committee member: ' . $post->ID);
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
        'member_linkedin_secondary'
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
            console.log('Committee order script loaded');
            console.log('Found ' + $('.committee-order-select').length + ' dropdowns');
            
            $('.committee-order-select').on('change', function() {
                console.log('Dropdown changed!');
                var postId = $(this).data('post-id');
                var newOrder = $(this).val();
                var $select = $(this);
                
                console.log('Post ID: ' + postId + ', New Order: ' + newOrder);
                
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
                        console.log('AJAX success:', response);
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
                        console.log('AJAX error:', status, error);
                        console.log('Response:', xhr.responseText);
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


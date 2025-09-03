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
 * Add custom columns to Events admin table
 */
function mpa_add_event_columns($columns) {
    // Remove unwanted columns
    unset($columns['date']);
    unset($columns['taxonomy-event_category']); // Remove event categories column
    unset($columns['taxonomy-event_tag']); // Remove event tags column
    
    // Add custom columns
    $columns['event_status'] = __('Event Status', 'mpa-custom');
    $columns['event_type'] = __('Event Type', 'mpa-custom');
    $columns['event_date'] = __('Event Date', 'mpa-custom');
    $columns['event_location'] = __('Location', 'mpa-custom');
    $columns['date'] = __('Published', 'mpa-custom'); // Re-add date column at the end
    
    return $columns;
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

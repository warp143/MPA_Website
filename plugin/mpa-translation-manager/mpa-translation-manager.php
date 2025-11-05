<?php
/**
 * Plugin Name: MPA Translation Manager
 * Plugin URI: https://proptech.org.my
 * Description: Centralized translation management system for Malaysia Proptech Association website. Replaces hardcoded JavaScript translations with database-driven system.
 * Version: 1.0.0
 * Author: Andrew Michael Kho
 * Author URI: https://www.linkedin.com/in/andrewmichaelkho/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: mpa-translation-manager
 * Requires at least: 5.0
 * Requires PHP: 7.4
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Plugin constants
define('MPA_TRANS_VERSION', '1.0.0');
define('MPA_TRANS_PATH', plugin_dir_path(__FILE__));
define('MPA_TRANS_URL', plugin_dir_url(__FILE__));
define('MPA_TRANS_BASENAME', plugin_basename(__FILE__));

// Autoload classes
require_once MPA_TRANS_PATH . 'includes/class-database.php';
require_once MPA_TRANS_PATH . 'includes/class-api.php';
require_once MPA_TRANS_PATH . 'includes/class-admin.php';
require_once MPA_TRANS_PATH . 'includes/class-migration.php';

/**
 * Activation hook - create database tables
 */
register_activation_hook(__FILE__, 'mpa_trans_activate');
function mpa_trans_activate() {
    MPA_Translation_Database::create_table();
    
    // Set default options
    add_option('mpa_trans_version', MPA_TRANS_VERSION);
    add_option('mpa_trans_activated', current_time('mysql'));
    
    flush_rewrite_rules();
}

/**
 * Deactivation hook
 */
register_deactivation_hook(__FILE__, 'mpa_trans_deactivate');
function mpa_trans_deactivate() {
    flush_rewrite_rules();
}

/**
 * Uninstall hook - clean up database (optional)
 * Uncomment if you want to remove all data on plugin deletion
 */
// register_uninstall_hook(__FILE__, 'mpa_trans_uninstall');
// function mpa_trans_uninstall() {
//     global $wpdb;
//     $table_name = $wpdb->prefix . 'mpa_translations';
//     $wpdb->query("DROP TABLE IF EXISTS $table_name");
//     delete_option('mpa_trans_version');
//     delete_option('mpa_trans_activated');
// }

/**
 * Initialize plugin
 */
add_action('plugins_loaded', 'mpa_trans_init');
function mpa_trans_init() {
    // Initialize API
    new MPA_Translation_API();
    
    // Initialize admin interface (only in admin)
    if (is_admin()) {
        new MPA_Translation_Admin();
    }
}

/**
 * Enqueue frontend scripts
 */
add_action('wp_enqueue_scripts', 'mpa_trans_enqueue_frontend');
function mpa_trans_enqueue_frontend() {
    wp_enqueue_script(
        'mpa-trans-loader',
        MPA_TRANS_URL . 'assets/js/frontend-loader.js',
        [],
        MPA_TRANS_VERSION,
        true
    );
    
    // Pass API URL to frontend
    wp_localize_script('mpa-trans-loader', 'mpaTransConfig', [
        'apiUrl' => rest_url('mpa/v1/translations'),
        'cacheExpiry' => apply_filters('mpa_trans_cache_expiry', 3600000) // 1 hour default
    ]);
}

/**
 * Add settings link on plugins page
 */
add_filter('plugin_action_links_' . MPA_TRANS_BASENAME, 'mpa_trans_settings_link');
function mpa_trans_settings_link($links) {
    $settings_link = '<a href="' . admin_url('tools.php?page=mpa-translation-manager') . '">Manage Translations</a>';
    array_unshift($links, $settings_link);
    return $links;
}

/**
 * AJAX handler for JSON export
 */
add_action('wp_ajax_mpa_export_json', 'mpa_trans_ajax_export_json');
function mpa_trans_ajax_export_json() {
    check_ajax_referer('wp_rest', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized');
    }
    
    MPA_Translation_Migration::export_json(true);
}

/**
 * AJAX handler for CSV export
 */
add_action('wp_ajax_mpa_export_csv', 'mpa_trans_ajax_export_csv');
function mpa_trans_ajax_export_csv() {
    check_ajax_referer('wp_rest', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized');
    }
    
    MPA_Translation_Migration::export_csv(true);
}

/**
 * AJAX handler for JSON import
 */
add_action('wp_ajax_mpa_import_json', 'mpa_trans_ajax_import_json');
function mpa_trans_ajax_import_json() {
    check_ajax_referer('wp_rest', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'Unauthorized']);
        return;
    }
    
    if (empty($_POST['json'])) {
        wp_send_json_error(['message' => 'No JSON data provided']);
        return;
    }
    
    $json = wp_unslash($_POST['json']);
    $overwrite = isset($_POST['overwrite']) && $_POST['overwrite'] === '1';
    
    $result = MPA_Translation_Migration::import_json($json, $overwrite);
    
    wp_send_json_success($result);
}


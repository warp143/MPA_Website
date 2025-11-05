<?php
/**
 * Plugin Name: MPA Translation Manager
 * Plugin URI: https://proptech.org.my
 * Description: Custom translation management system for Malaysia Proptech Association website - 100% custom built, no dependencies
 * Version: 1.0.0
 * Author: Andrew Michael Kho
 * Author URI: https://www.linkedin.com/in/andrewmichaelkho/
 * License: GPL v2 or later
 * Text Domain: mpa-translation-manager
 */

// Prevent direct access
if (!defined('ABSPATH')) exit;

// Plugin constants
define('MPA_TRANS_VERSION', '1.0.0');
define('MPA_TRANS_PATH', plugin_dir_path(__FILE__));
define('MPA_TRANS_URL', plugin_dir_url(__FILE__));

// Autoload classes
require_once MPA_TRANS_PATH . 'includes/class-database.php';
require_once MPA_TRANS_PATH . 'includes/class-api.php';
require_once MPA_TRANS_PATH . 'includes/class-admin.php';

// Activation hook - create database tables
register_activation_hook(__FILE__, 'mpa_trans_activate');
function mpa_trans_activate() {
    MPA_Translation_Database::create_table();
    MPA_Translation_Database::import_initial_data();
    flush_rewrite_rules();
}

// Deactivation hook
register_deactivation_hook(__FILE__, 'mpa_trans_deactivate');
function mpa_trans_deactivate() {
    flush_rewrite_rules();
}

// Set language cookie early (before headers sent)
add_action('init', 'mpa_trans_set_language_cookie', 1);
function mpa_trans_set_language_cookie() {
    if (!isset($_COOKIE['mpa_language'])) {
        setcookie('mpa_language', 'en', time() + (86400 * 30), '/');
        $_COOKIE['mpa_language'] = 'en'; // Set for current request
    }
}

// Initialize plugin
add_action('plugins_loaded', 'mpa_trans_init');
function mpa_trans_init() {
    new MPA_Translation_API();
    
    if (is_admin()) {
        new MPA_Translation_Admin();
    }
}

// Helper function - replacement for ACF's the_field()
if (!function_exists('the_field')) {
    function the_field($key) {
        echo get_field($key);
    }
}

if (!function_exists('get_field')) {
    function get_field($key) {
        // Get language from cookie, default to 'en'
        $lang = isset($_COOKIE['mpa_language']) ? sanitize_text_field($_COOKIE['mpa_language']) : 'en';
        
        // Validate language (only en, bm, cn allowed)
        if (!in_array($lang, ['en', 'bm', 'cn'])) {
            $lang = 'en';
        }
        
        return MPA_Translation_Database::get_translation($key, $lang);
    }
}

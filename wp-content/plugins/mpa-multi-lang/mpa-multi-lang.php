<?php
/**
 * Plugin Name: MPA Multi-Lang (Core)
 * Description: A lightweight, native translation architecture for proptech.org.my.
 * Version: 2.0.0
 * Author: MPA Tech Team
 * Text Domain: mpa-multi-lang
 */

if (!defined('ABSPATH')) {
    exit;
}

define('MPA_LANG_PATH', plugin_dir_path(__FILE__));
define('MPA_LANG_URL', plugin_dir_url(__FILE__));

// Register Taxonomy on Init
add_action('init', 'mpa_register_language_taxonomy');

function mpa_register_language_taxonomy() {
    $labels = [
        'name'              => 'Languages',
        'singular_name'     => 'Language',
        'menu_name'         => 'Languages',
    ];

    $args = [
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'lang'],
        'show_in_rest'      => true, // Essential for Gutenberg
        'public'            => false, // Don't expose archive pages
        'publicly_queryable'=> false,
    ];

    register_taxonomy('mpa_language', ['post', 'page', 'mpa_event'], $args);
}

// Activation Hook: Create Default Terms
register_activation_hook(__FILE__, 'mpa_install_languages');

function mpa_install_languages() {
    // Ensure taxonomy is registered before inserting terms
    mpa_register_language_taxonomy();

    $languages = ['en', 'ms', 'zh'];
    
    foreach ($languages as $lang) {
        if (!term_exists($lang, 'mpa_language')) {
            wp_insert_term($lang, 'mpa_language', [
                'slug' => $lang
            ]);
        }
    }
    
    // Flush rewrite rules
    flush_rewrite_rules();
}

// Load Sub-modules
require_once MPA_LANG_PATH . 'inc/admin-interface.php';
require_once MPA_LANG_PATH . 'inc/frontend-routing.php';
require_once MPA_LANG_PATH . 'inc/frontend-features.php';
require_once MPA_LANG_PATH . 'inc/sync-engine.php';

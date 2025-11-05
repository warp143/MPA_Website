<?php
/**
 * Admin UI for MPA Translation Manager
 */

class MPA_Translation_Admin {
    
    public function __construct() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }
    
    public function add_admin_menu() {
        add_management_page(
            'Translation Manager',
            'Translation Manager',
            'manage_options',
            'mpa-translation-manager',
            [$this, 'render_admin_page']
        );
    }
    
    public function enqueue_admin_assets($hook) {
        if ($hook !== 'tools_page_mpa-translation-manager') {
            return;
        }
        
        wp_enqueue_style(
            'mpa-trans-admin',
            MPA_TRANS_URL . 'admin/css/admin-styles.css',
            [],
            MPA_TRANS_VERSION
        );
        
        wp_enqueue_script(
            'mpa-trans-admin',
            MPA_TRANS_URL . 'admin/js/admin-scripts.js',
            ['jquery'],
            MPA_TRANS_VERSION,
            true
        );
        
        wp_localize_script('mpa-trans-admin', 'mpaTransAdmin', [
            'apiUrl' => rest_url('mpa/v1/translations'),
            'nonce' => wp_create_nonce('wp_rest')
        ]);
    }
    
    public function render_admin_page() {
        // Get all translations grouped by key
        global $wpdb;
        $table_name = $wpdb->prefix . 'mpa_translations';
        
        $results = $wpdb->get_results("
            SELECT translation_key, lang, value, context
            FROM $table_name
            ORDER BY context, translation_key, lang
        ");
        
        // Group by key
        $translations = [];
        foreach ($results as $row) {
            if (!isset($translations[$row->translation_key])) {
                $translations[$row->translation_key] = [
                    'en' => '',
                    'bm' => '',
                    'cn' => '',
                    'context' => $row->context
                ];
            }
            $translations[$row->translation_key][$row->lang] = $row->value;
        }
        
        include MPA_TRANS_PATH . 'admin/views/translation-manager.php';
    }
}

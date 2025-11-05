<?php
/**
 * MPA Translation Admin UI Class
 * Handles WordPress admin interface
 */

if (!defined('ABSPATH')) {
    exit;
}

class MPA_Translation_Admin {
    
    public function __construct() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_action('admin_notices', [$this, 'admin_notices']);
    }
    
    /**
     * Add admin menu page
     */
    public function add_admin_menu() {
        add_management_page(
            'Translation Manager',           // Page title
            'Translation Manager',           // Menu title
            'manage_options',                // Capability
            'mpa-translation-manager',       // Menu slug
            [$this, 'render_admin_page'],   // Callback
            99                               // Position
        );
    }
    
    /**
     * Enqueue admin assets (CSS and JS)
     */
    public function enqueue_admin_assets($hook) {
        // Only load on our admin page
        if ($hook !== 'tools_page_mpa-translation-manager') {
            return;
        }
        
        // Admin CSS
        wp_enqueue_style(
            'mpa-trans-admin',
            MPA_TRANS_URL . 'admin/css/admin-styles.css',
            [],
            MPA_TRANS_VERSION
        );
        
        // Admin JS
        wp_enqueue_script(
            'mpa-trans-admin',
            MPA_TRANS_URL . 'admin/js/admin-scripts.js',
            ['jquery'],
            MPA_TRANS_VERSION,
            true
        );
        
        // Pass data to JavaScript
        wp_localize_script('mpa-trans-admin', 'mpaTransAdmin', [
            'apiUrl' => rest_url('mpa/v1/translations'),
            'nonce' => wp_create_nonce('wp_rest'),
            'languages' => [
                'en' => 'English',
                'bm' => 'Bahasa Malaysia',
                'cn' => 'Chinese (中文)'
            ],
            'confirmDelete' => __('Are you sure you want to delete this translation? This action cannot be undone.', 'mpa-translation-manager')
        ]);
    }
    
    /**
     * Display admin notices
     */
    public function admin_notices() {
        // Check if we're on the right page
        if (!isset($_GET['page']) || $_GET['page'] !== 'mpa-translation-manager') {
            return;
        }
        
        // Success message
        if (isset($_GET['saved']) && $_GET['saved'] === '1') {
            echo '<div class="notice notice-success is-dismissible"><p><strong>Translations saved successfully!</strong></p></div>';
        }
        
        // Error message
        if (isset($_GET['error'])) {
            $error = sanitize_text_field($_GET['error']);
            echo '<div class="notice notice-error is-dismissible"><p><strong>Error:</strong> ' . esc_html($error) . '</p></div>';
        }
    }
    
    /**
     * Render admin page
     */
    public function render_admin_page() {
        // Get all translations grouped by key
        $translations = MPA_Translation_Database::get_all_grouped();
        $stats = MPA_Translation_Database::get_stats();
        
        // Get all unique keys (including those without translations)
        $all_keys = MPA_Translation_Database::get_all_keys();
        
        // Include the admin page template
        include MPA_TRANS_PATH . 'admin/views/translation-manager.php';
    }
    
    /**
     * Get context/category for a translation key
     * 
     * @param string $key Translation key
     * @return string Context category
     */
    public static function get_context($key) {
        // Categorize based on key prefix
        if (strpos($key, 'nav-') === 0) {
            return 'Navigation';
        } elseif (strpos($key, 'hero-') === 0) {
            return 'Hero Section';
        } elseif (strpos($key, 'btn-') === 0) {
            return 'Buttons';
        } elseif (strpos($key, 'event-') === 0) {
            return 'Events';
        } elseif (strpos($key, 'membership-') === 0 || strpos($key, 'benefit-') === 0) {
            return 'Membership';
        } elseif (strpos($key, 'footer-') === 0) {
            return 'Footer';
        } elseif (strpos($key, 'privacy-') === 0) {
            return 'Privacy Policy';
        } elseif (strpos($key, 'cookie-') === 0) {
            return 'Cookie Banner';
        } elseif (strpos($key, 'about-') === 0 || strpos($key, 'feature-') === 0) {
            return 'About Section';
        } elseif (strpos($key, 'newsletter-') === 0) {
            return 'Newsletter';
        } elseif (strpos($key, 'download-') === 0) {
            return 'Downloads';
        } elseif (strpos($key, 'stat-') === 0 || strpos($key, 'search-') === 0) {
            return 'Homepage';
        } else {
            return 'General';
        }
    }
}


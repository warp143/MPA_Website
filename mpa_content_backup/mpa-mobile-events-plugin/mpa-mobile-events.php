<?php
/**
 * Plugin Name: MPA Events Manager
 * Plugin URI: https://mpa-proptech.com
 * Description: Complete management system for MPA Events page with easy styling controls
 * Version: 2.0.0
 * Author: MPA PropTech
 * License: GPL2
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class MPA_Events_Manager {
    
    const VERSION = '2.0.0';
    
    public function __construct() {
        add_action('init', array($this, 'init'));
    }
    
    public function init() {
        // Frontend hooks
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
        add_action('wp_head', array($this, 'add_custom_styles'));
        
        // Admin hooks
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'admin_init'));
        add_action('admin_post_mpa_update_content', array($this, 'handle_content_update'));
    }
    
    private function is_events_page() {
        return is_page('mpa-events') || is_page(30841);
    }
    
    public function enqueue_styles() {
        if ($this->is_events_page()) {
            wp_enqueue_style(
                'mpa-font-awesome',
                'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css',
                array(),
                '6.0.0'
            );
        }
    }
    
    public function add_custom_styles() {
        if ($this->is_events_page()) {
            $header_height = get_option('mpa_header_height', '40');
            $header_color = get_option('mpa_header_text_color', '#ffffff');
            $mobile_enabled = get_option('mpa_mobile_enabled', '1');
            
            echo '<style id="mpa-custom-styles">' . "\n";
            
            // Header styles
            echo '.fancy-header {
                background-image: url("https://proptech.org.my/wp-content/uploads/2021/08/MPA-Header-Events-01.png") !important;
                background-repeat: no-repeat !important;
                background-position: center center !important;
                background-size: cover !important;
                background-color: #222222 !important;
            }
            
            .fancy-header-overlay {
                background: rgba(0,0,0,0.3) !important;
            }
            
            .fancy-header .fancy-title,
            .fancy-header h1,
            .dt-fancy-title h1,
            body .fancy-header h1 {
                color: ' . $header_color . ' !important;
                text-shadow: 3px 3px 6px rgba(0,0,0,0.9) !important;
                font-weight: bold !important;
                -webkit-text-fill-color: ' . $header_color . ' !important;
            }' . "\n";
            
            // Mobile styles
            if ($mobile_enabled) {
                echo '@media (max-width: 768px) {
                    .page-title-bg-wrap,
                    .page-title-inner,
                    .fancy-header-image,
                    .page-header,
                    .dt-fancy-title {
                        height: ' . $header_height . 'px !important;
                        min-height: ' . $header_height . 'px !important;
                        max-height: ' . $header_height . 'px !important;
                        padding-top: 10px !important;
                        padding-bottom: 10px !important;
                        overflow: hidden !important;
                    }
                    
                    .events-container {
                        flex-direction: column !important;
                        gap: 1.5rem !important;
                        padding: 1rem !important;
                    }
                    
                    .events-main {
                        flex: none !important;
                    }
                    
                    .events-sidebar {
                        width: 100% !important;
                        order: -1;
                    }
                    
                    .event-card {
                        display: block !important;
                        grid-template-columns: none !important;
                    }
                    
                    .event-icon {
                        height: 60px !important;
                        width: 100% !important;
                        border-radius: 16px 16px 0 0 !important;
                        font-size: 1.5rem !important;
                    }
                    
                    .past-events-grid {
                        grid-template-columns: 1fr !important;
                        gap: 1.5rem !important;
                    }
                    
                    .calendar-container {
                        padding: 1.5rem !important;
                    }
                    
                    .calendar-iframe {
                        height: 400px !important;
                    }
                }' . "\n";
            }
            
            echo '</style>' . "\n";
        }
    }
    
    public function add_admin_menu() {
        add_options_page(
            'MPA Events Manager',
            'MPA Events',
            'manage_options',
            'mpa-events-manager',
            array($this, 'admin_page')
        );
    }
    
    public function admin_init() {
        register_setting('mpa_events_settings', 'mpa_mobile_enabled');
        register_setting('mpa_events_settings', 'mpa_header_height');
        register_setting('mpa_events_settings', 'mpa_header_text_color');
        register_setting('mpa_events_settings', 'mpa_custom_css');
    }
    
    public function admin_page() {
        if (isset($_GET['updated'])) {
            echo '<div class="notice notice-success"><p>Settings saved successfully!</p></div>';
        }
        
        $current_content = '';
        $post = get_post(30841);
        if ($post) {
            $current_content = $post->post_content;
        }
        ?>
        <div class="wrap">
            <h1>🎯 MPA Events Manager</h1>
            
            <div class="notice notice-info">
                <p><strong>📱 Current Device:</strong> 
                    <?php if (wp_is_mobile()): ?>
                        <span style="color: green;">✓ Mobile - You'll see mobile styles</span>
                    <?php else: ?>
                        <span style="color: blue;">🖥️ Desktop - Switch to mobile view to see mobile styles</span>
                    <?php endif; ?>
                </p>
                <p><strong>🔗 Events Page:</strong> <a href="<?php echo get_permalink(30841); ?>" target="_blank">View Live Page</a></p>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                
                <!-- Settings Panel -->
                <div class="card">
                    <h2>⚙️ Styling Settings</h2>
                    <form method="post" action="options.php">
                        <?php settings_fields('mpa_events_settings'); ?>
                        
                        <table class="form-table">
                            <tr>
                                <th scope="row">📱 Mobile Optimization</th>
                                <td>
                                    <input type="checkbox" name="mpa_mobile_enabled" value="1" <?php checked(1, get_option('mpa_mobile_enabled', 1)); ?> />
                                    <label>Enable mobile responsive styling</label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">📏 Header Height (Mobile)</th>
                                <td>
                                    <input type="number" name="mpa_header_height" value="<?php echo get_option('mpa_header_height', '40'); ?>" min="20" max="200" />
                                    <label>pixels (current: <?php echo get_option('mpa_header_height', '40'); ?>px)</label>
                                    <p class="description">Height of the Events header on mobile devices</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">🎨 Header Text Color</th>
                                <td>
                                    <input type="color" name="mpa_header_text_color" value="<?php echo get_option('mpa_header_text_color', '#ffffff'); ?>" />
                                    <label>Color of "Events" title text</label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">🎨 Custom CSS</th>
                                <td>
                                    <textarea name="mpa_custom_css" rows="6" cols="50" placeholder="Add your custom CSS here..."><?php echo esc_textarea(get_option('mpa_custom_css', '')); ?></textarea>
                                    <p class="description">Advanced: Add custom CSS for additional styling</p>
                                </td>
                            </tr>
                        </table>
                        
                        <?php submit_button('💾 Save Settings'); ?>
                    </form>
                </div>
                
                <!-- Quick Actions Panel -->
                <div class="card">
                    <h2>🚀 Quick Actions</h2>
                    
                    <div style="margin-bottom: 1rem;">
                        <h3>📄 Page Management</h3>
                        <p><a href="<?php echo admin_url('post.php?post=30841&action=edit'); ?>" class="button button-primary">✏️ Edit Events Page</a></p>
                        <p><a href="<?php echo get_permalink(30841); ?>" target="_blank" class="button">👁️ View Live Page</a></p>
                        <p><a href="<?php echo get_permalink(30841); ?>?preview=true" target="_blank" class="button">🔍 Preview Changes</a></p>
                    </div>
                    
                    <div style="margin-bottom: 1rem;">
                        <h3>🔧 Troubleshooting</h3>
                        <p><a href="<?php echo admin_url('options-general.php?page=mpa-events-manager&action=clear_cache'); ?>" class="button">🗑️ Clear Cache</a></p>
                        <p><a href="<?php echo admin_url('options-general.php?page=mpa-events-manager&action=reset_settings'); ?>" class="button button-secondary">🔄 Reset Settings</a></p>
                    </div>
                    
                    <div>
                        <h3>📊 Current Status</h3>
                        <ul>
                            <li><strong>Plugin Version:</strong> <?php echo self::VERSION; ?></li>
                            <li><strong>Events Page ID:</strong> 30841</li>
                            <li><strong>Template:</strong> <?php echo get_page_template_slug(30841) ?: 'Default'; ?></li>
                            <li><strong>Mobile Styles:</strong> <?php echo get_option('mpa_mobile_enabled', 1) ? '✅ Enabled' : '❌ Disabled'; ?></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Instructions -->
            <div class="card" style="margin-top: 2rem;">
                <h2>📖 How to Use</h2>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                    <div>
                        <h3>🎨 Styling</h3>
                        <ol>
                            <li>Adjust header height using the slider above</li>
                            <li>Change header text color with the color picker</li>
                            <li>Toggle mobile optimization on/off</li>
                            <li>Add custom CSS for advanced styling</li>
                            <li>Click "Save Settings" to apply changes</li>
                        </ol>
                    </div>
                    <div>
                        <h3>📱 Testing</h3>
                        <ol>
                            <li>Save your settings first</li>
                            <li>Click "View Live Page" to see changes</li>
                            <li>Use browser dev tools to test mobile view</li>
                            <li>Or view on actual mobile device</li>
                            <li>Clear cache if changes don't appear</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        
        <style>
        .card { padding: 1.5rem; background: white; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04); }
        .card h2 { margin-top: 0; color: #23282d; }
        .card h3 { color: #0073aa; }
        .form-table th { width: 200px; }
        .button { margin-right: 0.5rem; margin-bottom: 0.5rem; }
        </style>
        <?php
    }
    
    public function handle_content_update() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        check_admin_referer('mpa_update_content');
        
        $new_content = wp_kses_post($_POST['page_content']);
        
        wp_update_post(array(
            'ID' => 30841,
            'post_content' => $new_content
        ));
        
        wp_redirect(admin_url('options-general.php?page=mpa-events-manager&updated=1'));
        exit;
    }
    
    public static function activate() {
        add_option('mpa_mobile_enabled', 1);
        add_option('mpa_header_height', '40');
        add_option('mpa_header_text_color', '#ffffff');
        add_option('mpa_custom_css', '');
    }
    
    public static function deactivate() {
        // Keep settings for reactivation
    }
    
    public static function uninstall() {
        delete_option('mpa_mobile_enabled');
        delete_option('mpa_header_height');
        delete_option('mpa_header_text_color');
        delete_option('mpa_custom_css');
    }
}

// Initialize plugin
new MPA_Events_Manager();

// Hooks
register_activation_hook(__FILE__, array('MPA_Events_Manager', 'activate'));
register_deactivation_hook(__FILE__, array('MPA_Events_Manager', 'deactivate'));
register_uninstall_hook(__FILE__, array('MPA_Events_Manager', 'uninstall'));
?>

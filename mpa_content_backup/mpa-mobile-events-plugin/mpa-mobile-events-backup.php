<?php
/**
 * Plugin Name: MPA Mobile Events Styling
 * Plugin URI: https://mpa-proptech.com
 * Description: Provides mobile-optimized styling for the Events page with clean, responsive design
 * Version: 1.0.0
 * Author: MPA PropTech
 * License: GPL2
 * 
 * This plugin applies mobile-specific styling to the Events page only,
 * leaving desktop experience unchanged.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class MPA_Mobile_Events {
    
    /**
     * Plugin version
     */
    const VERSION = '1.0.0';
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action('init', array($this, 'init'));
    }
    
    /**
     * Initialize plugin
     */
    public function init() {
        // Hook into WordPress
        add_action('wp_enqueue_scripts', array($this, 'enqueue_mobile_styles'));
        add_action('wp_head', array($this, 'add_mobile_meta_tags'));
        
        // Admin hooks
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'admin_init'));
    }
    
    /**
     * Check if current page is the events page
     */
    private function is_events_page() {
        return is_page('mpa-events') || is_page(30841);
    }
    
    /**
     * Detect if user is on mobile device
     */
    private function is_mobile_device() {
        return wp_is_mobile();
    }
    
    /**
     * Enqueue mobile styles only for events page on mobile
     */
    public function enqueue_mobile_styles() {
        // Only load on events page for mobile devices
        if ($this->is_events_page()) {
            
            // Enqueue Font Awesome for icons
            wp_enqueue_style(
                'mpa-font-awesome',
                'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css',
                array(),
                '6.0.0'
            );
            
            // Enqueue our mobile CSS
            wp_enqueue_style(
                'mpa-mobile-events',
                plugin_dir_url(__FILE__) . 'css/mobile-events.css',
                array(),
                self::VERSION
            );
            
            // Add inline CSS for immediate override
            wp_add_inline_style('mpa-mobile-events', $this->get_critical_mobile_css());
        }
    }
    
    /**
     * Add mobile meta tags for proper viewport handling
     */
    public function add_mobile_meta_tags() {
        if ($this->is_events_page()) {
            echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">' . "\n";
        }
    }
    
    /**
     * Get critical mobile CSS for immediate application
     */
    private function get_critical_mobile_css() {
        return '
        /* Critical mobile styles - applied immediately */
        body.page-id-30841 {
            background-color: #f8fafc !important;
        }
        
        .page-id-30841 .events-container {
            max-width: 100% !important;
            margin: 0 !important;
            padding: 1rem !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 1.5rem !important;
        }
        
        .page-id-30841 .event-card {
            display: block !important;
            grid-template-columns: none !important;
            margin-bottom: 1.5rem !important;
        }
        
        .page-id-30841 .event-icon {
            height: 60px !important;
            width: 100% !important;
            border-radius: 16px 16px 0 0 !important;
            font-size: 1.5rem !important;
        }
        
        .page-id-30841 .events-sidebar {
            width: 100% !important;
            order: -1 !important;
        }
        ';
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_options_page(
            'MPA Mobile Events Settings',
            'MPA Mobile Events',
            'manage_options',
            'mpa-mobile-events',
            array($this, 'admin_page')
        );
    }
    
    /**
     * Admin init
     */
    public function admin_init() {
        register_setting('mpa_mobile_events_settings', 'mpa_mobile_events_enabled');
        register_setting('mpa_mobile_events_settings', 'mpa_mobile_events_debug');
    }
    
    /**
     * Admin page
     */
    public function admin_page() {
        ?>
        <div class="wrap">
            <h1>MPA Mobile Events Settings</h1>
            
            <div class="notice notice-info">
                <p><strong>Plugin Status:</strong> 
                    <?php if ($this->is_mobile_device()): ?>
                        <span style="color: green;">✓ Mobile device detected - Mobile styles will be applied</span>
                    <?php else: ?>
                        <span style="color: orange;">⚠ Desktop device detected - Mobile styles will NOT be applied</span>
                    <?php endif; ?>
                </p>
            </div>
            
            <form method="post" action="options.php">
                <?php settings_fields('mpa_mobile_events_settings'); ?>
                <?php do_settings_sections('mpa_mobile_events_settings'); ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">Enable Mobile Styling</th>
                        <td>
                            <input type="checkbox" name="mpa_mobile_events_enabled" value="1" <?php checked(1, get_option('mpa_mobile_events_enabled', 1)); ?> />
                            <label>Apply mobile styling to Events page</label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Debug Mode</th>
                        <td>
                            <input type="checkbox" name="mpa_mobile_events_debug" value="1" <?php checked(1, get_option('mpa_mobile_events_debug', 0)); ?> />
                            <label>Show debug information in browser console</label>
                        </td>
                    </tr>
                </table>
                
                <?php submit_button(); ?>
            </form>
            
            <div class="card">
                <h2>Plugin Information</h2>
                <p><strong>Version:</strong> <?php echo self::VERSION; ?></p>
                <p><strong>Target Page:</strong> Events (ID: 30841)</p>
                <p><strong>Mobile Detection:</strong> WordPress wp_is_mobile() function</p>
                <p><strong>CSS File:</strong> /css/mobile-events.css</p>
            </div>
            
            <div class="card">
                <h2>How It Works</h2>
                <ol>
                    <li>Plugin detects if user is on mobile device using <code>wp_is_mobile()</code></li>
                    <li>Checks if current page is the Events page (ID: 30841)</li>
                    <li>If both conditions are true, loads mobile-specific CSS</li>
                    <li>Desktop users see normal theme styling</li>
                    <li>Mobile users get optimized event card layout</li>
                </ol>
            </div>
        </div>
        <?php
    }
    
    /**
     * Plugin activation
     */
    public static function activate() {
        // Set default options
        add_option('mpa_mobile_events_enabled', 1);
        add_option('mpa_mobile_events_debug', 0);
    }
    
    /**
     * Plugin deactivation
     */
    public static function deactivate() {
        // Clean up if needed
    }
    
    /**
     * Plugin uninstall
     */
    public static function uninstall() {
        // Remove options
        delete_option('mpa_mobile_events_enabled');
        delete_option('mpa_mobile_events_debug');
    }
}

// Initialize plugin
new MPA_Mobile_Events();

// Activation/Deactivation hooks
register_activation_hook(__FILE__, array('MPA_Mobile_Events', 'activate'));
register_deactivation_hook(__FILE__, array('MPA_Mobile_Events', 'deactivate'));
register_uninstall_hook(__FILE__, array('MPA_Mobile_Events', 'uninstall'));
?>

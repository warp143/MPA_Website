<?php
/**
 * Plugin Name: MPA Event Status Updater
 * Plugin URI: https://www.homesifu.io
 * Description: Automatically updates MPA event status from 'upcoming' to 'past' based on event dates. Includes logging, admin settings, and manual controls.
 * Version: 1.0.0
 * Author: MPA Committee Member 2025-2026 @ Andrew Michael Kho
 * Author URI: https://www.linkedin.com/in/andrewmichaelkho/
 * License: GPL v2 or later
 * Text Domain: mpa-event-status-updater
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('MPA_ESU_VERSION', '1.0.0');
define('MPA_ESU_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MPA_ESU_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Main MPA Event Status Updater Class
 */
class MPAEventStatusUpdater {
    
    private $option_name = 'mpa_esu_settings';
    private $log_option = 'mpa_esu_logs';
    
    public function __construct() {
        // Hook into WordPress
        add_action('init', array($this, 'init'));
        add_action('wp', array($this, 'schedule_event_status_update'));
        add_action('mpa_update_event_status', array($this, 'update_past_events'));
        
        // Admin hooks
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'admin_init'));
        add_action('wp_dashboard_setup', array($this, 'add_dashboard_widget'));
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
        
        // AJAX hooks for manual updates
        add_action('wp_ajax_mpa_manual_update', array($this, 'manual_update_ajax'));
        add_action('wp_ajax_mpa_clear_logs', array($this, 'clear_logs_ajax'));
        
        // Activation and deactivation hooks
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }
    
    /**
     * Initialize plugin
     */
    public function init() {
        // Load text domain for translations
        load_plugin_textdomain('mpa-event-status-updater', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }
    
    /**
     * Plugin activation
     */
    public function activate() {
        // Set default options
        $default_options = array(
            'enabled' => true,
            'schedule' => 'daily',
            'log_enabled' => true,
            'max_logs' => 100,
            'email_notifications' => false,
            'admin_email' => get_option('admin_email')
        );
        
        add_option($this->option_name, $default_options);
        
        // Schedule the cron event
        if (!wp_next_scheduled('mpa_update_event_status')) {
            wp_schedule_event(time(), 'daily', 'mpa_update_event_status');
        }
        
        // Log activation
        $this->log_message('Plugin activated successfully');
    }
    
    /**
     * Plugin deactivation
     */
    public function deactivate() {
        // Clear scheduled events
        wp_clear_scheduled_hook('mpa_update_event_status');
        
        // Log deactivation
        $this->log_message('Plugin deactivated');
    }
    
    /**
     * Schedule event status updates
     */
    public function schedule_event_status_update() {
        $options = get_option($this->option_name);
        
        if (!$options['enabled']) {
            return;
        }
        
        $schedule = isset($options['schedule']) ? $options['schedule'] : 'daily';
        
        if (!wp_next_scheduled('mpa_update_event_status')) {
            wp_schedule_event(time(), $schedule, 'mpa_update_event_status');
        }
    }
    
    /**
     * Update past events status
     */
    public function update_past_events() {
        global $wpdb;
        
        $options = get_option($this->option_name);
        
        if (!$options['enabled']) {
            $this->log_message('Update skipped - plugin disabled');
            return;
        }
        
        $start_time = microtime(true);
        
        // Get events that need status update (upcoming events that are now past)
        $events_to_update = $wpdb->get_results("
            SELECT pm1.post_id, p.post_title, pm2.meta_value as event_date
            FROM {$wpdb->postmeta} pm1
            JOIN {$wpdb->posts} p ON pm1.post_id = p.ID
            JOIN {$wpdb->postmeta} pm2 ON pm1.post_id = pm2.post_id
            WHERE pm1.meta_key = '_event_status' 
            AND pm1.meta_value = 'upcoming'
            AND pm2.meta_key = '_event_date' 
            AND pm2.meta_value < CURDATE()
            AND p.post_type = 'mpa_event'
            AND p.post_status = 'publish'
        ");
        
        $updated_count = 0;
        
        if (!empty($events_to_update)) {
            // Update the events
            $post_ids = array_map(function($event) { return $event->post_id; }, $events_to_update);
            $post_ids_string = implode(',', array_map('intval', $post_ids));
            
            $result = $wpdb->query("
                UPDATE {$wpdb->postmeta} 
                SET meta_value = 'past' 
                WHERE meta_key = '_event_status' 
                AND post_id IN ({$post_ids_string})
            ");
            
            $updated_count = $result;
            
            // Log each updated event
            foreach ($events_to_update as $event) {
                $this->log_message("Updated event: '{$event->post_title}' (ID: {$event->post_id}) from upcoming to past (Date: {$event->event_date})");
            }
        }
        
        $execution_time = round((microtime(true) - $start_time) * 1000, 2);
        
        // Log summary
        $message = "Status update completed: {$updated_count} events updated in {$execution_time}ms";
        $this->log_message($message);
        
        // Send email notification if enabled
        if ($options['email_notifications'] && $updated_count > 0) {
            $this->send_notification_email($updated_count, $events_to_update);
        }
        
        return $updated_count;
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_options_page(
            'MPA Event Status Updater',
            'Event Status Updater',
            'manage_options',
            'mpa-event-status-updater',
            array($this, 'admin_page')
        );
    }
    
    /**
     * Enqueue admin scripts
     */
    public function admin_enqueue_scripts($hook) {
        // Only load on plugins page
        if ($hook === 'plugins.php') {
            wp_enqueue_script('jquery');
            wp_add_inline_script('jquery', '
                jQuery(document).ready(function($) {
                    // Change "Visit plugin site" to "View details" for MPA plugins
                    $("a[href*=\'homesifu.io\']").each(function() {
                        if ($(this).text() === "Visit plugin site") {
                            $(this).text("View details");
                        }
                    });
                });
            ');
        }
    }
    
    /**
     * Initialize admin settings
     */
    public function admin_init() {
        register_setting('mpa_esu_settings_group', $this->option_name);
        
        // Add settings sections
        add_settings_section(
            'mpa_esu_main_section',
            'Main Settings',
            array($this, 'main_section_callback'),
            'mpa-event-status-updater'
        );
        
        add_settings_section(
            'mpa_esu_logging_section',
            'Logging Settings',
            array($this, 'logging_section_callback'),
            'mpa-event-status-updater'
        );
        
        // Add settings fields
        add_settings_field(
            'enabled',
            'Enable Automatic Updates',
            array($this, 'enabled_callback'),
            'mpa-event-status-updater',
            'mpa_esu_main_section'
        );
        
        add_settings_field(
            'schedule',
            'Update Schedule',
            array($this, 'schedule_callback'),
            'mpa-event-status-updater',
            'mpa_esu_main_section'
        );
        
        add_settings_field(
            'log_enabled',
            'Enable Logging',
            array($this, 'log_enabled_callback'),
            'mpa-event-status-updater',
            'mpa_esu_logging_section'
        );
        
        add_settings_field(
            'max_logs',
            'Maximum Log Entries',
            array($this, 'max_logs_callback'),
            'mpa-event-status-updater',
            'mpa_esu_logging_section'
        );
        
        add_settings_field(
            'email_notifications',
            'Email Notifications',
            array($this, 'email_notifications_callback'),
            'mpa-event-status-updater',
            'mpa_esu_main_section'
        );
    }
    
    /**
     * Admin page content
     */
    public function admin_page() {
        $options = get_option($this->option_name);
        $logs = get_option($this->log_option, array());
        
        ?>
        <div class="wrap">
            <h1>MPA Event Status Updater</h1>
            
            <div class="notice notice-info">
                <p><strong>Plugin Status:</strong> 
                    <?php echo $options['enabled'] ? '<span style="color: green;">Active</span>' : '<span style="color: red;">Disabled</span>'; ?>
                </p>
                <p><strong>Next Scheduled Update:</strong> 
                    <?php 
                    $next_run = wp_next_scheduled('mpa_update_event_status');
                    echo $next_run ? date('Y-m-d H:i:s', $next_run) : 'Not scheduled';
                    ?>
                </p>
            </div>
            
            <div class="postbox" style="margin-top: 20px;">
                <h3 class="hndle">Manual Controls</h3>
                <div class="inside">
                    <p>
                        <button type="button" id="manual-update-btn" class="button button-primary">
                            Run Manual Update Now
                        </button>
                        <span id="manual-update-result"></span>
                    </p>
                    <p class="description">
                        This will immediately check and update any events that should be marked as 'past'.
                    </p>
                </div>
            </div>
            
            <form method="post" action="options.php">
                <?php
                settings_fields('mpa_esu_settings_group');
                do_settings_sections('mpa-event-status-updater');
                submit_button();
                ?>
            </form>
            
            <div class="postbox" style="margin-top: 20px;">
                <h3 class="hndle">Activity Log 
                    <button type="button" id="clear-logs-btn" class="button button-small" style="float: right; margin-top: -3px;">
                        Clear Logs
                    </button>
                </h3>
                <div class="inside">
                    <div id="log-container" style="max-height: 400px; overflow-y: auto; background: #f9f9f9; padding: 10px; border: 1px solid #ddd;">
                        <?php if (empty($logs)): ?>
                            <p>No log entries yet.</p>
                        <?php else: ?>
                            <?php foreach (array_reverse($logs) as $log): ?>
                                <div style="margin-bottom: 5px; font-family: monospace; font-size: 12px;">
                                    <strong><?php echo esc_html($log['timestamp']); ?></strong> - 
                                    <?php echo esc_html($log['message']); ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            $('#manual-update-btn').click(function() {
                var button = $(this);
                var result = $('#manual-update-result');
                
                button.prop('disabled', true).text('Running...');
                result.html('<span style="color: #666;">Processing...</span>');
                
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'mpa_manual_update',
                        nonce: '<?php echo wp_create_nonce('mpa_manual_update'); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            result.html('<span style="color: green;">✓ ' + response.data.message + '</span>');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            result.html('<span style="color: red;">✗ ' + response.data.message + '</span>');
                        }
                    },
                    error: function() {
                        result.html('<span style="color: red;">✗ Error occurred</span>');
                    },
                    complete: function() {
                        button.prop('disabled', false).text('Run Manual Update Now');
                    }
                });
            });
            
            $('#clear-logs-btn').click(function() {
                if (confirm('Are you sure you want to clear all logs?')) {
                    $.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'mpa_clear_logs',
                            nonce: '<?php echo wp_create_nonce('mpa_clear_logs'); ?>'
                        },
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                            }
                        }
                    });
                }
            });
        });
        </script>
        <?php
    }
    
    /**
     * Settings callbacks
     */
    public function main_section_callback() {
        echo '<p>Configure how the automatic event status updates work.</p>';
    }
    
    public function logging_section_callback() {
        echo '<p>Control logging and monitoring features.</p>';
    }
    
    public function enabled_callback() {
        $options = get_option($this->option_name);
        $checked = isset($options['enabled']) && $options['enabled'] ? 'checked' : '';
        echo "<input type='checkbox' name='{$this->option_name}[enabled]' value='1' {$checked}> Enable automatic status updates";
    }
    
    public function schedule_callback() {
        $options = get_option($this->option_name);
        $schedule = isset($options['schedule']) ? $options['schedule'] : 'daily';
        $schedules = wp_get_schedules();
        
        echo "<select name='{$this->option_name}[schedule]'>";
        foreach ($schedules as $key => $schedule_info) {
            $selected = $schedule === $key ? 'selected' : '';
            echo "<option value='{$key}' {$selected}>{$schedule_info['display']}</option>";
        }
        echo "</select>";
    }
    
    public function log_enabled_callback() {
        $options = get_option($this->option_name);
        $checked = isset($options['log_enabled']) && $options['log_enabled'] ? 'checked' : '';
        echo "<input type='checkbox' name='{$this->option_name}[log_enabled]' value='1' {$checked}> Enable activity logging";
    }
    
    public function max_logs_callback() {
        $options = get_option($this->option_name);
        $max_logs = isset($options['max_logs']) ? $options['max_logs'] : 100;
        echo "<input type='number' name='{$this->option_name}[max_logs]' value='{$max_logs}' min='10' max='1000'>";
        echo "<p class='description'>Maximum number of log entries to keep (10-1000)</p>";
    }
    
    public function email_notifications_callback() {
        $options = get_option($this->option_name);
        $checked = isset($options['email_notifications']) && $options['email_notifications'] ? 'checked' : '';
        $email = isset($options['admin_email']) ? $options['admin_email'] : get_option('admin_email');
        
        echo "<input type='checkbox' name='{$this->option_name}[email_notifications]' value='1' {$checked}> Send email notifications";
        echo "<br><input type='email' name='{$this->option_name}[admin_email]' value='{$email}' placeholder='admin@example.com' style='margin-top: 5px;'>";
        echo "<p class='description'>Get notified when events are updated</p>";
    }
    
    /**
     * Add dashboard widget
     */
    public function add_dashboard_widget() {
        wp_add_dashboard_widget(
            'mpa_event_status_widget',
            'MPA Event Status Updates',
            array($this, 'dashboard_widget_content')
        );
    }
    
    /**
     * Dashboard widget content
     */
    public function dashboard_widget_content() {
        global $wpdb;
        
        // Get upcoming events count
        $upcoming_count = $wpdb->get_var("
            SELECT COUNT(*)
            FROM {$wpdb->postmeta} pm
            JOIN {$wpdb->posts} p ON pm.post_id = p.ID
            WHERE pm.meta_key = '_event_status' 
            AND pm.meta_value = 'upcoming'
            AND p.post_type = 'mpa_event'
            AND p.post_status = 'publish'
        ");
        
        // Get events that should be past (upcoming events with past dates)
        $should_be_past = $wpdb->get_var("
            SELECT COUNT(*)
            FROM {$wpdb->postmeta} pm1
            JOIN {$wpdb->posts} p ON pm1.post_id = p.ID
            JOIN {$wpdb->postmeta} pm2 ON pm1.post_id = pm2.post_id
            WHERE pm1.meta_key = '_event_status' 
            AND pm1.meta_value = 'upcoming'
            AND pm2.meta_key = '_event_date' 
            AND pm2.meta_value < CURDATE()
            AND p.post_type = 'mpa_event'
            AND p.post_status = 'publish'
        ");
        
        $next_run = wp_next_scheduled('mpa_update_event_status');
        
        echo '<p><strong>Upcoming Events:</strong> ' . $upcoming_count . '</p>';
        echo '<p><strong>Need Status Update:</strong> ' . ($should_be_past > 0 ? "<span style='color: orange;'>{$should_be_past}</span>" : $should_be_past) . '</p>';
        echo '<p><strong>Next Auto Update:</strong> ' . ($next_run ? date('M j, Y g:i A', $next_run) : 'Not scheduled') . '</p>';
        
        if ($should_be_past > 0) {
            echo '<p><a href="' . admin_url('options-general.php?page=mpa-event-status-updater') . '" class="button button-small">Update Now</a></p>';
        }
    }
    
    /**
     * AJAX handler for manual updates
     */
    public function manual_update_ajax() {
        if (!wp_verify_nonce($_POST['nonce'], 'mpa_manual_update') || !current_user_can('manage_options')) {
            wp_die('Security check failed');
        }
        
        $updated_count = $this->update_past_events();
        
        wp_send_json_success(array(
            'message' => "Updated {$updated_count} events successfully"
        ));
    }
    
    /**
     * AJAX handler for clearing logs
     */
    public function clear_logs_ajax() {
        if (!wp_verify_nonce($_POST['nonce'], 'mpa_clear_logs') || !current_user_can('manage_options')) {
            wp_die('Security check failed');
        }
        
        delete_option($this->log_option);
        $this->log_message('Logs cleared by admin');
        
        wp_send_json_success();
    }
    
    /**
     * Log a message
     */
    private function log_message($message) {
        $options = get_option($this->option_name);
        
        if (!isset($options['log_enabled']) || !$options['log_enabled']) {
            return;
        }
        
        $logs = get_option($this->log_option, array());
        $max_logs = isset($options['max_logs']) ? $options['max_logs'] : 100;
        
        // Add new log entry
        $logs[] = array(
            'timestamp' => current_time('Y-m-d H:i:s'),
            'message' => $message
        );
        
        // Keep only the most recent entries
        if (count($logs) > $max_logs) {
            $logs = array_slice($logs, -$max_logs);
        }
        
        update_option($this->log_option, $logs);
    }
    
    /**
     * Send notification email
     */
    private function send_notification_email($count, $events) {
        $options = get_option($this->option_name);
        $to = $options['admin_email'];
        $subject = 'MPA Event Status Update Notification';
        
        $message = "Hello,\n\n";
        $message .= "The MPA Event Status Updater has automatically updated {$count} events from 'upcoming' to 'past' status.\n\n";
        $message .= "Updated Events:\n";
        
        foreach ($events as $event) {
            $message .= "- {$event->post_title} (Date: {$event->event_date})\n";
        }
        
        $message .= "\nThis is an automated notification from your WordPress site.\n";
        $message .= "Site: " . get_site_url() . "\n";
        $message .= "Time: " . current_time('Y-m-d H:i:s');
        
        wp_mail($to, $subject, $message);
    }
}

// Initialize the plugin
new MPAEventStatusUpdater();

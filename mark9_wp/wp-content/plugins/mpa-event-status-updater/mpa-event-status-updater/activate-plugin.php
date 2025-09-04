<?php
/**
 * Plugin Activation Hook
 * Sets up the plugin when activated
 */

register_activation_hook(__FILE__, 'mpa_event_status_updater_activate');

function mpa_event_status_updater_activate() {
    // Set default options
    $default_options = array(
        'enabled' => true,
        'schedule' => 'daily',
        'log_enabled' => true,
        'max_logs' => 100,
        'email_notifications' => false,
        'admin_email' => get_option('admin_email')
    );
    
    add_option('mpa_esu_settings', $default_options);
    
    // Schedule the cron event
    if (!wp_next_scheduled('mpa_update_event_status')) {
        wp_schedule_event(time(), 'daily', 'mpa_update_event_status');
    }
    
    // Add activation notice
    add_option('mpa_event_status_updater_activation_notice', true);
}

// Display activation notice
add_action('admin_notices', 'mpa_event_status_updater_activation_notice');

function mpa_event_status_updater_activation_notice() {
    if (get_option('mpa_event_status_updater_activation_notice')) {
        ?>
        <div class="notice notice-success is-dismissible">
            <h3>🎉 MPA Event Status Updater Activated!</h3>
            <p><strong>What it does:</strong> Automatically updates MPA event status from 'upcoming' to 'past' based on event dates.</p>
            <p><strong>Features:</strong> Includes logging, admin settings, manual controls, and dashboard widgets.</p>
            <p><a href="<?php echo admin_url('admin.php?page=mpa-event-status-updater'); ?>" class="button button-primary">Configure Settings</a></p>
        </div>
        <?php
        delete_option('mpa_event_status_updater_activation_notice');
    }
}

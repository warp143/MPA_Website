# MPA Event Status Updater - WordPress Plugin

## Overview
Automatically updates MPA event status from 'upcoming' to 'past' based on event dates. This plugin is essential for keeping your MPA website event listings current and accurate.

## Features
- **🔄 Automatic Updates**: Daily cron job updates event statuses automatically
- **📊 Admin Dashboard**: Complete admin interface with settings and controls
- **📝 Activity Logging**: Detailed logs of all status updates
- **🎛️ Manual Controls**: Manual update buttons for immediate status changes
- **📱 Dashboard Widget**: Quick overview in WordPress dashboard
- **📧 Email Notifications**: Optional email alerts for status changes
- **⚙️ Customizable Settings**: Flexible configuration options

## Installation

### Prerequisites
- WordPress 5.0+
- PHP 7.4 or higher
- MySQL/MariaDB database

### Quick Setup
1. Upload the plugin to `wp-content/plugins/`
2. Activate the plugin in WordPress admin
3. Go to "MPA Event Status Updater" in admin menu
4. Configure your settings
5. The plugin will start working automatically

## Configuration

### Basic Settings
- **Enable/Disable**: Turn the plugin on or off
- **Update Schedule**: Choose how often to check events (daily, hourly, etc.)
- **Logging**: Enable/disable activity logging
- **Email Notifications**: Set up email alerts

### Advanced Settings
- **Maximum Logs**: Control how many log entries to keep
- **Admin Email**: Set custom email for notifications
- **Custom Post Types**: Configure which post types to monitor

## Usage

### Automatic Updates
The plugin runs automatically in the background:
- Checks event dates daily (or as configured)
- Updates 'upcoming' events to 'past' when date passes
- Logs all changes for audit trail

### Manual Updates
Use the admin interface for immediate updates:
- Manual status update button
- Bulk update options
- Clear logs when needed

### Dashboard Widget
Quick overview in WordPress dashboard:
- Recent status changes
- Total events processed
- Quick action buttons

## Event Post Type Support

This plugin works with any custom post type that has:
- A date field (publish date, custom field, or meta)
- Status taxonomy or meta field
- 'upcoming' and 'past' status values

## Logging System

### What Gets Logged
- Event status changes
- Manual updates
- Plugin activation/deactivation
- Error messages
- Configuration changes

### Log Management
- Automatic log rotation
- Configurable log retention
- Export logs for analysis
- Clear logs when needed

## Troubleshooting

### Common Issues
1. **Events not updating**: Check if cron is working
2. **Logs not showing**: Verify logging is enabled
3. **Email not sending**: Check email configuration

### Debug Mode
Enable WordPress debug mode to see detailed error messages:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

## Support
For support, contact the MPA Committee Member @ Andrew Michael Kho

## Changelog

### Version 1.0.0
- Initial release
- Automatic event status updates
- Admin interface and settings
- Activity logging system
- Dashboard widget
- Email notifications
- Manual update controls

## License
GPL v2 or later

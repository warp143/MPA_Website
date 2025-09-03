# MPA Event Status Updater

A WordPress plugin that automatically updates MPA event statuses from "upcoming" to "past" based on event dates.

## Features

- **Automatic Updates**: Runs daily to update event statuses
- **Manual Control**: Run updates manually from admin panel
- **Comprehensive Logging**: Track all status changes with timestamps
- **Email Notifications**: Get notified when events are updated
- **Dashboard Widget**: Monitor event status from WordPress dashboard
- **Flexible Scheduling**: Choose update frequency (daily, hourly, etc.)
- **Safe Operations**: Uses WordPress cron and proper database queries

## Installation

1. **Upload Plugin Files**:
   - Copy the entire `mpa-event-status-updater` folder to `/wp-content/plugins/`
   - Or upload via WordPress admin: Plugins → Add New → Upload Plugin

2. **Activate Plugin**:
   - Go to WordPress Admin → Plugins
   - Find "MPA Event Status Updater" and click "Activate"

3. **Configure Settings**:
   - Go to Settings → Event Status Updater
   - Configure your preferences

## Configuration

### Settings Page Location
WordPress Admin → Settings → Event Status Updater

### Available Settings

#### Main Settings
- **Enable Automatic Updates**: Turn automatic updates on/off
- **Update Schedule**: Choose how often to check (daily, hourly, etc.)
- **Email Notifications**: Get notified when events are updated
- **Admin Email**: Email address for notifications

#### Logging Settings
- **Enable Logging**: Turn activity logging on/off
- **Maximum Log Entries**: How many log entries to keep (10-1000)

### Manual Controls
- **Run Manual Update Now**: Immediately check and update event statuses
- **Clear Logs**: Remove all log entries

## How It Works

### Automatic Process
1. Plugin runs on WordPress cron schedule (default: daily)
2. Searches for events with status "upcoming" and date before today
3. Updates matching events to status "past"
4. Logs all changes with timestamps
5. Sends email notification if enabled

### Database Query
The plugin uses this SQL logic:
```sql
UPDATE wp_postmeta 
SET meta_value = 'past' 
WHERE meta_key = '_event_status' 
AND post_id IN (
    SELECT post_id 
    FROM wp_postmeta 
    WHERE meta_key = '_event_date' 
    AND meta_value < CURDATE()
)
```

### Event Requirements
Events must have:
- Post type: `mpa_event`
- Status: `publish`
- Meta field `_event_status` = "upcoming"
- Meta field `_event_date` with past date

## Dashboard Widget

The plugin adds a dashboard widget showing:
- Total upcoming events
- Events needing status update
- Next scheduled update time
- Quick link to manual update

## Logging System

### What Gets Logged
- Plugin activation/deactivation
- Automatic update runs
- Manual update runs
- Individual event status changes
- Execution times and performance metrics

### Log Format
```
2025-01-15 14:30:25 - Updated event: 'MPA Happy Hour - December 2024' (ID: 123) from upcoming to past (Date: 2024-12-26)
2025-01-15 14:30:25 - Status update completed: 3 events updated in 45.67ms
```

## Email Notifications

When enabled, you'll receive emails containing:
- Number of events updated
- List of updated event names and dates
- Timestamp of update
- Site information

## Troubleshooting

### Plugin Not Running
1. Check if plugin is activated
2. Verify "Enable Automatic Updates" is checked
3. Check WordPress cron is working: `wp cron event list`

### Events Not Updating
1. Verify events have correct post type (`mpa_event`)
2. Check events are published (not draft)
3. Confirm meta fields exist: `_event_status` and `_event_date`
4. Run manual update to test

### No Logs Appearing
1. Enable logging in settings
2. Check if events actually need updating
3. Verify database permissions

### Email Notifications Not Working
1. Check WordPress can send emails
2. Verify admin email address is correct
3. Check spam folder
4. Test with WordPress email testing plugin

## Database Backup

**Always backup your database before installing:**
```bash
mysqldump -u root mark9_wp > backup_$(date +%Y%m%d_%H%M%S).sql
```

## Uninstallation

1. **Deactivate Plugin**: WordPress Admin → Plugins → Deactivate
2. **Delete Plugin**: Plugins → Delete (removes all files)
3. **Clean Database** (optional):
   ```sql
   DELETE FROM wp_options WHERE option_name LIKE 'mpa_esu_%';
   ```

## Technical Details

### WordPress Hooks Used
- `init`: Plugin initialization
- `wp`: Schedule cron events
- `mpa_update_event_status`: Custom cron action
- `admin_menu`: Add settings page
- `wp_dashboard_setup`: Add dashboard widget

### Database Tables Used
- `wp_posts`: Event posts
- `wp_postmeta`: Event metadata
- `wp_options`: Plugin settings and logs

### Security Features
- Nonce verification for AJAX requests
- Capability checks (`manage_options`)
- SQL injection protection
- Direct access prevention

## Support

For issues or questions:
1. Check the activity log for error messages
2. Enable logging and run manual update
3. Verify database structure matches requirements
4. Contact MPA development team

## Version History

### 1.0.0
- Initial release
- Automatic status updates
- Admin settings page
- Logging system
- Email notifications
- Dashboard widget
- Manual update controls

---

*Plugin developed for Malaysia PropTech Association (MPA)*
*Compatible with WordPress 5.0+ and PHP 7.4+*

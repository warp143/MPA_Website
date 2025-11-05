# PropTech.org.my - Server & Workflow Guide

**Complete guide for managing and editing the live PropTech website**

---

## 📋 Table of Contents

1. [Server Information](#server-information)
2. [Quick Start - Editing Files](#quick-start---editing-files)
3. [SSH Access Methods](#ssh-access-methods)
4. [Direct Editing Workflow](#direct-editing-workflow)
5. [Common Editing Tasks](#common-editing-tasks)
6. [WordPress Management](#wordpress-management)
7. [Server Directory Structure](#server-directory-structure)
8. [Backup & Security](#backup--security)
9. [Troubleshooting](#troubleshooting)
10. [Alternative Access](#alternative-access)

---

## Server Information

- **Server**: smaug.cygnusdns.com
- **IP Address**: 103.152.12.27
- **OS**: Ubuntu 20.04.6 LTS
- **Username**: proptech
- **Password**: 3MDm*9otf-X~
- **Disk Usage**: 75% (352GB/494GB used)

### Important URLs
- **Live Site**: https://proptech.org.my
- **Admin Panel**: https://proptech.org.my/wp-admin/
- **Test Site**: https://proptech.org.my/test/
- **cPanel**: https://smaug.cygnusdns.com:2083

### Configuration File
Server credentials and paths are stored in:
```bash
ssh/proptech.json
```

This file contains:
- Server hostname and username
- SSH key path
- WordPress database credentials (db_name, db_user, db_password)
- Site URLs

---

## Quick Start - Editing Files

**🚀 Recommended Method: Interactive Editor Tool**

```bash
python3 tools/edit_live_theme.py
```

**What it does:**
- ✅ Shows menu of common theme files
- ✅ Downloads file from live server
- ✅ Opens in your editor (nano/vim)
- ✅ Creates automatic backup with timestamp
- ✅ Uploads changes back to server
- ✅ Changes are live immediately

**Example Session:**
```bash
$ python3 tools/edit_live_theme.py

📁 Available theme files to edit:

  1. front-page.php      - Homepage template
  2. header.php          - Site header
  3. footer.php          - Site footer
  4. style.css           - Theme styles
  5. functions.php       - Theme functions
  6. page-events.php     - Events page
  7. page-members.php    - Members page
  8. page-partners.php   - Partners page

  0. Custom path
  q. Quit

Select file to edit: 1

📥 Downloading front-page.php...
✅ Download successful
📝 Opening in nano...

[Make your edits, save and exit]

💾 File was modified. Upload to live server? (y/N): y
💾 Creating backup...
📤 Uploading...
✅ Upload successful
🎉 Changes are now live at https://proptech.org.my
```

---

## SSH Access Methods

### Method 1: SSH with Password
```bash
ssh proptech@smaug.cygnusdns.com
```
When prompted, enter password: `3MDm*9otf-X~`

### Method 2: SSH with Key (Recommended)
```bash
# Connect using SSH key (generated Oct 28, 2025)
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com
```

**SSH Key:**
- `ssh/proptech_mpa_new` - ED25519 key (Oct 2025) ✅ Active

**First time setup (if needed):**
```bash
# Copy public key to server
ssh-copy-id -i ssh/proptech_mpa_new.pub proptech@smaug.cygnusdns.com
```

**Fix key permissions if needed:**
```bash
chmod 600 ssh/proptech_mpa_new
```

---

## Direct Editing Workflow

### Interactive Editor (Primary Method)

Use this for all theme file edits:
```bash
python3 tools/edit_live_theme.py
```

**Available files:**
- `front-page.php` - Homepage template
- `header.php` - Site header
- `footer.php` - Site footer  
- `style.css` - Theme styles
- `functions.php` - Theme functions
- `page-events.php` - Events page template
- `page-members.php` - Members page template
- `page-partners.php` - Partners page template

**Custom files:**
- Select option `0` and enter any server path

### View File Contents (Without Editing)

```bash
# View entire file
python3 tools/view_live_file.py ~/public_html/proptech.org.my/wp-content/themes/mpa-custom/front-page.php

# View first 50 lines
python3 tools/view_live_file.py ~/public_html/proptech.org.my/wp-content/themes/mpa-custom/front-page.php 50

# View last 20 lines  
python3 tools/view_live_file.py ~/public_html/proptech.org.my/wp-content/themes/mpa-custom/front-page.php -20
```

### Direct SSH Editing

For quick edits or when the tool isn't available:

```bash
# 1. Connect to server
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com

# 2. Navigate to theme directory
cd ~/public_html/proptech.org.my/wp-content/themes/mpa-custom/

# 3. Create manual backup (recommended)
cp front-page.php front-page.php.backup.$(date +%Y%m%d_%H%M%S)

# 4. Edit file
nano front-page.php

# 5. Save (Ctrl+O, Enter, Ctrl+X) and exit
exit
```

### Best Practices

⚠️ **Important Guidelines:**

1. **Always create backups** - The interactive tool does this automatically
2. **Test changes immediately** - Visit the live site after uploading
3. **Work during low-traffic hours** - For major changes (evenings/weekends)
4. **Keep editor sessions short** - Download → Edit → Upload quickly
5. **Double-check before uploading** - Review changes in the editor

### Automatic Backups

Every edit creates a backup with timestamp:
```
filename.backup.YYYYMMDD_HHMMSS
```

**Example:**
```
front-page.php.backup.20251020_140530
```

**To restore from backup:**
```bash
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com
cd ~/public_html/proptech.org.my/wp-content/themes/mpa-custom/
cp front-page.php.backup.20251020_140530 front-page.php
```

---

## Common Editing Tasks

### Edit Homepage
```bash
python3 tools/edit_live_theme.py
# Select: 1. front-page.php
```

### Edit Styles
```bash
python3 tools/edit_live_theme.py
# Select: 4. style.css
```

### Edit Events Page
```bash
python3 tools/edit_live_theme.py
# Select: 6. page-events.php
```

### Edit Header/Footer
```bash
python3 tools/edit_live_theme.py
# Select: 2. header.php or 3. footer.php
```

### Edit Custom File
```bash
python3 tools/edit_live_theme.py
# Select: 0. Custom path
# Enter: ~/public_html/proptech.org.my/wp-content/themes/mpa-custom/your-file.php
```

---

## WordPress Management

### WP-CLI Commands

The server has WP-CLI installed for command-line WordPress management:

```bash
# SSH to server
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com

# Navigate to WordPress directory
cd ~/public_html/proptech.org.my/

# Check WordPress version
wp core version

# List all plugins
wp plugin list

# Activate/deactivate plugin
wp plugin activate plugin-name
wp plugin deactivate plugin-name

# List all themes
wp theme list

# Update WordPress core
wp core update

# Clear cache
wp cache flush

# Database operations
wp db check
wp db optimize
```

### Database Access

WordPress database credentials are in:
```bash
~/public_html/proptech.org.my/wp-config.php
```

**From proptech.json:**
- Database: `proptech_wp_vpwr5`
- User: `proptech_wp_zns32`
- Password: `$LGMY#0DhF4QeH03`
- Host: `localhost:3306`

---

## Server Directory Structure

### Main Directories

```
/home/proptech/
├── public_html/
│   └── proptech.org.my/              # Main WordPress installation
│       ├── wp-admin/                 # WordPress admin
│       ├── wp-content/
│       │   ├── themes/
│       │   │   └── mpa-custom/       # Custom theme (edit here)
│       │   ├── plugins/              # WordPress plugins
│       │   └── uploads/              # Media files
│       ├── wp-config.php             # WordPress configuration
│       └── test/                     # Test/staging environment
├── backup-*.tar.gz                   # Server backups
├── .ssh/                             # SSH keys
└── logs/                             # Server logs
```

### Important Paths

**Theme Directory:**
```
~/public_html/proptech.org.my/wp-content/themes/mpa-custom/
```

**WordPress Root:**
```
~/public_html/proptech.org.my/
```

**Uploads Directory:**
```
~/public_html/proptech.org.my/wp-content/uploads/
```

**Config File:**
```
~/public_html/proptech.org.my/wp-config.php
```

### Test Environment

**Web Access:**
- Test Site: https://proptech.org.my/test/
- Test Admin: https://proptech.org.my/test/wp-admin/

**File System:**
```bash
~/public_html/proptech.org.my/test/
```

---

## Backup & Security

### Available Backups

Located in `/home/proptech/`:
- `backup-8.10.2025_16-49-14_proptech.tar.gz` (4.9GB)
- `backup-9.14.2024_05-58-54_proptech.tar.gz` (3.7GB)

### Creating New Backups

```bash
# SSH to server
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com

# Create full backup
tar -czf backup-$(date +%m.%d.%Y_%H-%M-%S)_proptech.tar.gz public_html/

# Backup only WordPress files (faster)
cd ~/public_html
tar -czf ~/backup-wp-$(date +%m.%d.%Y_%H-%M-%S).tar.gz proptech.org.my/

# Backup only theme
cd ~/public_html/proptech.org.my/wp-content/themes
tar -czf ~/backup-theme-$(date +%m.%d.%Y_%H-%M-%S).tar.gz mpa-custom/
```

### Security Features

- ✅ Wordfence security plugin installed
- ✅ SSH key authentication enabled
- ✅ Imunify security patches applied
- ✅ SSL certificates managed through cPanel
- ✅ Automatic backups before file edits
- ✅ `.htaccess` protection on sensitive files

---

## Troubleshooting

### Connection Issues

**SSH Connection Timeout:**
```bash
# The server may be experiencing issues
# Try again in a few minutes or use cPanel file manager
# Check if SSH service is running (requires server access)
```

**Permission Denied:**
```bash
# Fix SSH key permissions
chmod 600 ssh/proptech_mpa_new

# Verify key exists
ls -la ssh/proptech_mpa_new
```

**Host Key Verification Failed:**
```bash
# Remove old host key
ssh-keygen -R smaug.cygnusdns.com

# Or connect with StrictHostKeyChecking=no
ssh -i ssh/proptech_mpa_new -o StrictHostKeyChecking=no proptech@smaug.cygnusdns.com
```

### File Issues

**Permission Denied on File Edit:**
```bash
# Check file permissions
ls -la ~/public_html/proptech.org.my/wp-content/themes/mpa-custom/

# Fix permissions if needed (on server)
chmod 644 filename.php
```

**File Not Found:**
```bash
# Verify the remote path exists
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com "ls -la ~/public_html/proptech.org.my/wp-content/themes/mpa-custom/"
```

### WordPress Issues

**Check Error Logs:**
```bash
# SSH to server
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com

# View recent errors
tail -f ~/logs/error_log

# View PHP errors
tail -f ~/public_html/proptech.org.my/wp-content/debug.log
```

**Database Connection Errors:**
```bash
# Verify wp-config.php settings
cat ~/public_html/proptech.org.my/wp-config.php | grep DB_

# Test database connection
wp db check
```

### Useful Server Commands

```bash
# Check disk usage
df -h

# Check memory usage
free -h

# Check running PHP processes
ps aux | grep php

# Check Apache status (may require sudo)
systemctl status apache2

# View recent Apache logs
tail -f ~/logs/error_log

# Check file permissions
ls -la
```

---

## Alternative Access

### cPanel File Manager

If SSH is not available or you prefer a GUI:

1. **Login to cPanel**
   - URL: https://smaug.cygnusdns.com:2083
   - Username: `proptech`
   - Password: `3MDm*9otf-X~`

2. **Open File Manager**
   - Click "File Manager" icon
   - Navigate to `public_html/proptech.org.my/wp-content/themes/mpa-custom/`

3. **Edit Files**
   - Right-click file → "Edit"
   - Make changes and click "Save Changes"
   - Changes are live immediately

4. **Create Backups**
   - Right-click file → "Copy"
   - Rename with `.backup.YYYYMMDD` suffix

### WordPress Admin Dashboard

For content editing (not theme files):

1. Go to https://proptech.org.my/wp-admin/
2. Login with WordPress credentials:
   - **Username**: `admin_amk`
   - **Password**: `d4Hw0pMJm23zXLD2i51R3Prb`
3. Use Appearance → Theme File Editor (if enabled)
4. Edit content through Pages/Posts

⚠️ **Note**: Theme File Editor is disabled for security. Use the interactive tool instead.

---

## Emergency Procedures

### If Something Breaks

1. **Restore from automatic backup:**
   ```bash
   ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com
   cd ~/public_html/proptech.org.my/wp-content/themes/mpa-custom/
   ls -lt *.backup.* | head -5  # Find recent backups
   cp front-page.php.backup.20251020_140530 front-page.php
   ```

2. **Check error logs:**
   ```bash
   tail -f ~/logs/error_log
   ```

3. **Contact hosting support:**
   - cPanel support available through hosting provider
   - Provide error messages and timestamps

### Legacy Deployment (Fallback)

If the interactive tool fails, use the old deployment method:

```bash
python3 tools/deploy_to_proptech.py
```

⚠️ **Note**: This requires maintaining local copies in `mark9_wp/` directory.

---

## Hide/Show Sign In Button

### Current Status: HIDDEN (as of Nov 5, 2025)

The Sign In button is currently hidden on the website but not deleted. The code is still in place and can be easily re-enabled.

### To HIDE the Sign In button:

1. **Edit header.php**:
   - Line 69 (desktop): Add class `sign-in-hidden`
   - Line 117 (mobile): Add class `sign-in-hidden`

```php
<!-- Desktop (Line 69) -->
<a href="<?php echo esc_url(home_url('/signin/')); ?>" class="btn-secondary desktop-only sign-in-hidden" ...>

<!-- Mobile (Line 117) -->
<a href="<?php echo esc_url(home_url('/signin/')); ?>" class="btn-secondary mobile-only sign-in-hidden" ...>
```

2. **Ensure style.css has the CSS rule** (already added):
```css
/* HIDE SIGN IN BUTTON - To re-enable, remove "sign-in-hidden" class from header.php */
.sign-in-hidden {
    display: none !important;
}
```

3. **Deploy to live server**:
```bash
cd mark9_wp/wp-content/themes/mpa-custom
scp -i ~/Documents/GitHub/MPA_Website/ssh/proptech_mpa_new header.php proptech@smaug.cygnusdns.com:~/public_html/proptech.org.my/wp-content/themes/mpa-custom/
scp -i ~/Documents/GitHub/MPA_Website/ssh/proptech_mpa_new style.css proptech@smaug.cygnusdns.com:~/public_html/proptech.org.my/wp-content/themes/mpa-custom/
```

### To SHOW the Sign In button (re-enable):

1. **Edit header.php**:
   - Line 69 (desktop): Remove `sign-in-hidden` class
   - Line 117 (mobile): Remove `sign-in-hidden` class

```php
<!-- Desktop (Line 69) - REMOVE sign-in-hidden -->
<a href="<?php echo esc_url(home_url('/signin/')); ?>" class="btn-secondary desktop-only" ...>

<!-- Mobile (Line 117) - REMOVE sign-in-hidden -->
<a href="<?php echo esc_url(home_url('/signin/')); ?>" class="btn-secondary mobile-only" ...>
```

2. **Deploy to live server**:
```bash
cd mark9_wp/wp-content/themes/mpa-custom
scp -i ~/Documents/GitHub/MPA_Website/ssh/proptech_mpa_new header.php proptech@smaug.cygnusdns.com:~/public_html/proptech.org.my/wp-content/themes/mpa-custom/
```

**Note**: The CSS rule can stay in style.css - it only affects elements with the `sign-in-hidden` class.

---

## Quick Reference

### Most Common Commands

```bash
# Edit homepage
python3 tools/edit_live_theme.py  # Select 1

# View file contents
python3 tools/view_live_file.py ~/public_html/proptech.org.my/wp-content/themes/mpa-custom/front-page.php

# SSH to server
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com

# Check WordPress version
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com "cd ~/public_html/proptech.org.my && wp core version"
```

### File Paths Cheatsheet

```bash
# Theme files
~/public_html/proptech.org.my/wp-content/themes/mpa-custom/

# Uploads
~/public_html/proptech.org.my/wp-content/uploads/

# Plugins  
~/public_html/proptech.org.my/wp-content/plugins/

# Config
~/public_html/proptech.org.my/wp-config.php

# Logs
~/logs/error_log
```

---

**Last Updated**: November 5, 2025  
**Document Version**: 2.4 (Added Sign In button hide/show instructions)  
**Server Status**: Active (Ubuntu 20.04.6 LTS)
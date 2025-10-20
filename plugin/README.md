# MPA Custom WordPress Plugins

This directory contains backups of custom WordPress plugins developed for the Malaysia Proptech Association website.

## Plugins Included

### 1. MPA Event Status Updater
**Location:** `mpa-event-status-updater/`

**Purpose:** Automatically updates event status from "upcoming" to "past" based on event dates

**Features:**
- Automatic status updates via WordPress cron
- Admin settings page for configuration
- Comprehensive logging system
- Manual control options
- Real-time event count display

**Author:** Andrew Michael Kho (MPA Committee Member 2025-2026)

**Files:**
- `mpa-event-status-updater.php` - Main plugin file
- `README.md` - Detailed documentation
- `create-wp-plugin.sh` - Setup script
- `mpa-event-status-updater-wordpress.zip` - Installable package

---

### 2. MPA Image Processor
**Location:** `mpa-image-processor/`

**Purpose:** Upload, crop, and remove backgrounds from committee member images using AI

**Features:**
- AI-powered background removal using `rembg`
- Interactive image cropping with Cropper.js
- Automatic image optimization (target 2MB)
- Smart cleanup system (prevents disk space issues)
- Support for large image uploads (up to 50MB)

**Technical Stack:**
- **PHP:** WordPress plugin architecture with `proc_open()` for shell execution
- **Python 3.8:** AI image processing (rembg, Pillow, OpenCV, NumPy)
- **JavaScript:** Cropper.js for interactive cropping interface

**Author:** Andrew Michael Kho (MPA Committee Member 2025-2026)

**Files:**
- `mpa-image-processor-plugin.php` - Main plugin file (29KB)
- `process_image.py` - Python AI background removal script
- `js/processor.js` - Frontend JavaScript
- `requirements.txt` - Python dependencies (Pillow, opencv-python, numpy, rembg)
- `setup-python-env.sh` - Python virtual environment setup script
- `README.md` - Detailed documentation

**Note:** The `plugin_env/` directory (Python virtual environment) is NOT backed up here as it's large (100MB+) and can be recreated using `setup-python-env.sh`.

---

## Installation on New Server

### For MPA Event Status Updater:
1. Upload the entire `mpa-event-status-updater/` folder to `wp-content/plugins/`
2. Activate the plugin in WordPress admin
3. Configure settings under **Settings → Event Status Updater**

### For MPA Image Processor:
1. Upload the entire `mpa-image-processor/` folder to `wp-content/plugins/`
2. SSH into server and run:
   ```bash
   cd wp-content/plugins/mpa-image-processor/
   bash setup-python-env.sh
   ```
3. Ensure Python 3.8+ is available on the server
4. Activate the plugin in WordPress admin
5. Access via **Admin Menu → Image Processor**

---

## Backup Information

**Last Updated:** October 20, 2025  
**Backed Up From:** proptech.org.my production server  
**Total Size:** ~160KB (excluding Python virtual environment)

---

## Recent Fixes (October 20, 2025)

### MPA Image Processor:
- ✅ Fixed hosting restrictions (shell_exec disabled → proc_open)
- ✅ Enhanced cleanup to remove ALL temp files
- ✅ Added smart background cleanup (hourly, deletes files older than 5 minutes)
- ✅ Verified Python 3.8 compatibility
- ✅ Pre-downloaded AI model (u2net.onnx) to prevent first-run timeout

---

## Support

For questions or issues, contact:  
**Andrew Michael Kho**  
LinkedIn: https://www.linkedin.com/in/andrewmichaelkho/  
Website: https://www.homesifu.io


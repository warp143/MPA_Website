# Wordfence Local Development Configuration

## Current Status
Wordfence is **DISABLED** for local development because it causes WordPress to hang during initialization.

## Why Wordfence is Disabled
- Wordfence WAF (Web Application Firewall) processes large config files (1.6MB+) on every request
- Network requests to Wordfence servers can timeout in local development
- Causes WordPress initialization to hang/timeout

## Configuration Made
1. ✅ WAF disabled in `wp-content/wflogs/config.php` (wafStatus: disabled)
2. ✅ Wordfence constants added to `wp-config.php`:
   - `WORDFENCE_DISABLE_LIVE_TRAFFIC = true`
   - `WORDFENCE_DISABLE_ADMINBAR = true`
3. ✅ Wordfence deactivated in WordPress database

## To Re-enable Wordfence (for Production)
1. Go to WordPress Admin → Plugins
2. Activate "Wordfence Security"
3. Go to Wordfence → Firewall → Enable WAF
4. Configure firewall rules as needed

## Alternative: Use Wordfence Only in Production
- Keep Wordfence disabled in local development
- Enable it only on production server
- This is the recommended approach for development environments

## Wordfence Folder Location
- Plugin folder: `wp-content/plugins/wordfence/`
- Config files: `wp-content/wflogs/`

---
Last updated: 2025-11-05

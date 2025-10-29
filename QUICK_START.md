# 🚀 QUICK START: Security Implementation

## Goal: Upgrade from 88/100 → 100/100 (5-6 hours)

---

## Option 1: Automated Script (Recommended)

```bash
# 1. SSH to server
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com

# 2. Download and run the script
cd ~
curl -O https://raw.githubusercontent.com/warp143/MPA_Website/main/implement_security_phases.sh
chmod +x implement_security_phases.sh
./implement_security_phases.sh
```

The script will:
- ✅ Create automatic backups
- ✅ Guide you through each phase
- ✅ Auto-update .htaccess
- ✅ Create .env file
- ✅ Verify changes
- ⚠️ Flag files that need manual editing

---

## Option 2: Manual Implementation

Follow the detailed guide:
```bash
# Download the guide
cd ~/public_html/proptech.org.my
curl -O https://raw.githubusercontent.com/warp143/MPA_Website/main/SECURITY_IMPLEMENTATION_GUIDE.md

# Read and follow step-by-step
less SECURITY_IMPLEMENTATION_GUIDE.md
```

---

## Quick Checklist

### Phase 1: Quick Wins (2 hours) → 91/100
- [ ] Edit `mpa-image-processor-plugin.php` - Add file validation
- [ ] Edit `mpa-event-status-updater.php` - Use $wpdb->prepare()

### Phase 2: Rate Limiting (2 hours) → 95/100
- [ ] Edit `functions.php` - Add rate limiting functions
- [ ] Edit `functions.php` - Add session timeout

### Phase 3: Secrets & Headers (2 hours) → 100/100
- [ ] Create `.env` file with credentials
- [ ] Edit `wp-config.php` - Read from .env
- [ ] Edit `.htaccess` - Protect .env file
- [ ] Edit `functions.php` - Add CSP headers
- [ ] Generate new WordPress security keys

---

## Files to Edit

```
1. wp-content/plugins/mpa-image-processor/mpa-image-processor-plugin.php
2. wp-content/plugins/mpa-event-status-updater/mpa-event-status-updater.php
3. wp-content/themes/mpa-custom/functions.php (3 additions)
4. wp-config.php
5. .htaccess
6. .env (create new)
```

---

## Verification Commands

```bash
# Test website
curl -I https://proptech.org.my

# Test .env protected
curl -I https://proptech.org.my/.env  # Should be 403

# Test security headers
curl -I https://proptech.org.my | grep X-Frame-Options

# Check for errors
tail -50 ~/public_html/proptech.org.my/wp-content/debug.log
```

---

## Backup Location

All backups stored in:
```
~/backups/security_upgrade_YYYYMMDD_HHMMSS/
```

---

## Need Help?

**Full documentation:** `SECURITY_IMPLEMENTATION_GUIDE.md`  
**Assessment report:** `SECURITY_ASSESSMENT_REPORT.md`

---

## 🎯 Result

**Before:** 88/100 (Excellent)  
**After:** 100/100 (Perfect)

**Time Investment:** 5-6 hours  
**Security Improvement:** +12 points  
**ROI:** World-class security posture


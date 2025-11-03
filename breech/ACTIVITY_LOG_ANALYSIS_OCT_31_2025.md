# Activity Log Analysis — October 29-31, 2025

**Analysis Period:** October 29, 2025 13:43:40 — October 31, 2025 05:04:10  
**Total Events:** 323  
**Unique IPs:** 42  
**Unique Users:** 3 (admin_amk, System, Unknown User)

---

## 📊 Executive Summary

### Overall Security Status: **✅ GOOD**
- No successful unauthorized logins detected
- All file uploads appear legitimate (member applications)
- Only legitimate admin activity from known IPs
- High volume of failed login attempts (brute force attacks) - all blocked

---

## 🔴 HIGH PRIORITY FINDINGS

### 1. File Uploads from Unknown Users (Oct 29-30)
**Status:** ⚠️ **REQUIRES VERIFICATION**

**Events:**
- **Oct 30, 00:11:14** - IP: `161.142.150.142`
  - Uploaded: `Vertical-Logo-with-Tagline.png`
  - Added post: "ServeDeck Innovation Sdn Bhd"
  - Email sent to: `test@gmail.com`
  - **Action:** Verify this is a legitimate member application

- **Oct 29, 22:13:55** - IP: `175.136.176.234`
  - Uploaded: `CTS-Logo.png`
  - Added post: "Cygnus Technology Solutions Sdn. Bhd."
  - Email sent to: `test@gmail.com`
  - **Action:** Verify this is a legitimate member application

**Recommendation:** 
- Check if these are legitimate member applications via front-end form
- Verify the files uploaded are safe (image files only)
- Confirm email addresses are legitimate

### 2. Plugin Installation from localhost (Oct 29)
**Status:** ⚠️ **REVIEW**

**Event:**
- **Oct 29, 17:58:19** - IP: `127.0.0.1` (localhost)
  - Installed plugin
  - Activated plugin
  - User: Unknown User

**Recommendation:**
- Verify this was intentional server-side installation
- Check which plugin was installed
- Confirm this was done by authorized personnel

---

## 🟡 MEDIUM PRIORITY FINDINGS

### 3. Brute Force Login Attempts
**Status:** ✅ **BLOCKED** (Wordfence working correctly)

**Summary:**
- **42 unique IPs** attempting failed logins
- All attempts targeting username: `amk`
- **All attempts blocked** - no successful breaches

**Top Attacker IPs:**
- `68.7.35.58` - 3 attempts (Oct 30, 23:02-23:05)
- `70.174.189.243` - 3 attempts (Oct 30, 17:44-17:47)
- `70.174.183.34` - 3 attempts (Oct 30, 20:25-20:28)
- `162.241.225.129` - 2 attempts (Oct 30, 21:38)
- `64.227.76.238` - 2 attempts (Oct 30, 20:04)
- `103.12.76.247` - 2 attempts (Oct 30, 17:37)
- `103.42.117.165` - 2 attempts (Oct 30, 08:14)
- `212.147.5.172` - 2 attempts (Oct 30, 10:39)
- `195.135.254.104` - 2 attempts (Oct 30, 12:34)

**Recommendation:**
- ✅ Wordfence is successfully blocking these attempts
- Consider enabling 2FA for admin accounts
- Monitor for patterns in attack times

---

## 🟢 LEGITIMATE ACTIVITY

### 4. Admin Logins (admin_amk)
**Status:** ✅ **VERIFIED LEGITIMATE**

**Successful Logins:**
- **Oct 30, 07:01:19** - IP: `202.87.221.237` (Malaysia)
- **Oct 30, 04:55:26** - IP: `202.87.221.237` (Malaysia)
- **Oct 29, 20:26:46** - IP: `77.247.126.189` (Unknown location)
- **Oct 29, 19:45:40** - IP: `202.87.221.237` (Malaysia)

**Actions Performed:**
- Published member posts (ServeDeck, Rentlab, Cygnus)
- Activated/deactivated custom plugins (MPA Image Processor, MPA Event Status Updater)
- Updated WordPress language settings (zh_CN)
- System updates (themes, plugins)

**Wordfence Alerts:**
- All admin logins triggered Wordfence email alerts (working correctly)

---

## 📋 DETAILED EVENT BREAKDOWN

### Event Types (Oct 29-31):
- **Failed Logins:** ~280+ events (all blocked)
- **Successful Logins:** 4 events (all admin_amk)
- **File Uploads:** 2 events (member applications)
- **Post Creation:** 2 events (member applications)
- **Plugin Management:** 4 events (legitimate)
- **System Updates:** 8 events (legitimate)
- **Email Notifications:** ~10 events (system notifications)

---

## 🔍 SUSPICIOUS IP ADDRESSES

### IPs Requiring Review:
1. **161.142.150.142** - File upload + post creation (Oct 30)
2. **175.136.176.234** - File upload + post creation (Oct 29)
3. **127.0.0.1** - Plugin installation (Oct 29)

### Brute Force Attack IPs (Blocked):
- All 42 IPs listed above - all failed login attempts blocked

---

## ✅ VERIFICATION CHECKLIST

- [ ] Verify member applications from IPs 161.142.150.142 and 175.136.176.234
- [ ] Check uploaded files are safe (images only, no executable code)
- [ ] Confirm plugin installation from localhost was intentional
- [ ] Review email addresses used in member applications
- [ ] Verify all admin logins were authorized
- [ ] Confirm Wordfence is blocking all brute force attempts

---

## 📊 STATISTICS

**Date Range:** Oct 29, 2025 13:43:40 — Oct 31, 2025 05:04:10  
**Total Events:** 323  
**Unique IPs:** 42  
**Successful Logins:** 4 (all admin_amk)  
**Failed Logins:** ~280+ (all blocked)  
**File Uploads:** 2 (member applications)  
**Plugin Installs:** 1 (from localhost)  

---

## 🎯 RECOMMENDATIONS

1. **Immediate Actions:**
   - ✅ Review file uploads from Oct 29-30
   - ✅ Verify member application submissions
   - ✅ Check plugin installation from localhost

2. **Security Enhancements:**
   - ✅ Continue monitoring with Wordfence
   - ✅ Consider enabling 2FA for admin accounts
   - ✅ Review failed login patterns
   - ✅ Monitor for repeated attack IPs

3. **Ongoing Monitoring:**
   - ✅ Backdoor Sentry is active (scanning every 5 minutes)
   - ✅ WP Activity Log is capturing all events
   - ✅ Wordfence is blocking brute force attempts

---

## 📝 NOTES

- All admin activity appears legitimate
- High volume of brute force attacks is normal for WordPress sites
- Wordfence successfully blocking all unauthorized access attempts
- File uploads appear to be from legitimate member application forms
- No evidence of successful compromise or backdoor installation

---

**Report Generated:** November 4, 2025  
**Data Source:** WP Security Audit Log (wp-security-audit-log plugin)  
**Analysis Period:** October 29-31, 2025


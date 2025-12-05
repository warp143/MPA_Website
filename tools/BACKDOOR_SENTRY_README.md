# Backdoor Sentry — Automated Hidden-Admin Backdoor Watch

This tool scans your WordPress install for a specific, high‑risk backdoor family
that creates a hidden `root` admin and hides it via `_pre_user_id` and
`protect_user_*` helpers. When detected, it quarantines the file and generates a
report. Optionally, it neutralizes (comments) the suspicious code in place.

## Files & Locations

**On Server (smaug.cygnusdns.com):**
- **Script:** `~/public_html/proptech.org.my/tools/backdoor_sentry.py`
- **Scan log:** `~/backdoor_sentry.log` (logs every scan run automatically)
- **Reports:** `~/public_html/proptech.org.my/breech/backdoor_sentry_reports/` (created when findings detected)
- **Quarantine:** `~/public_html/proptech.org.my/breech/quarantine/<timestamp>/<infected_file>`
- **Malware samples:** `~/public_html/proptech.org.my/breech/malware_samples/`

**Local Development:**
- `tools/backdoor_sentry.py` — main scanner script (upload to server when updated)

## Current Setup (Production)

**Cron Job Configuration:**
The scanner runs automatically every 5 minutes via cron:
```bash
*/5 * * * * /usr/bin/python3 ~/public_html/proptech.org.my/tools/backdoor_sentry.py --wp-root ~/public_html/proptech.org.my --neutralize --log-file ~/backdoor_sentry.log >> /dev/null 2>&1
```

**To view/edit cron:**
```bash
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com "crontab -l"
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com "crontab -e"
```

**Manual Run:**
```bash
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com
cd ~/public_html/proptech.org.my
python3 tools/backdoor_sentry.py --wp-root ~/public_html/proptech.org.my --neutralize --log-file ~/backdoor_sentry.log --verbose
```

Exit codes:
- `0` — No findings
- `1` — Findings quarantined
- `2` — Error

## Patterns Detected

### PHP Backdoors
- `wp_insert_user(... 'role' => 'administrator' ...)` — Hidden admin creation
- `username_exists('root')` — Root user checks
- `admin@wordpress.com` — Suspicious email patterns
- `_pre_user_id` — User ID manipulation
- `wp_admin_users_protect_user_query` — Admin user hiding
- `protect_user_from_deleting` / `protect_user_count` — User protection hooks

### JavaScript Malware
- SocGholish patterns
- Malicious script injection patterns
- Suspicious analytics/tracking domains
- Obfuscated code patterns (`eval`, `base64_decode`, `gzinflate`)

### File Types Scanned
PHP, JavaScript, HTML, CSS, TXT, JSON, XML, SQL, INI, CONF, HTACCESS, and files with no extension

## Logging

**Log File:** `~/backdoor_sentry.log` on server

**Log Format:**
Every scan run is automatically logged with timestamps and log levels:
```
[2025-12-05 21:35:47] [INFO] Scan started - WordPress root: /home/proptech/public_html/proptech.org.my
[2025-12-05 21:35:59] [INFO] Scan completed - No suspicious files found
[2025-12-05 21:40:22] [ALERT] Scan found 2 suspicious file(s)
[2025-12-05 21:40:23] [ALERT] Quarantined: wp-content/themes/test/backdoor.php
[2025-12-05 21:40:24] [ALERT] Neutralized 5 line(s) in wp-content/themes/test/backdoor.php
[2025-12-05 21:40:25] [INFO] Report written: breech/backdoor_sentry_reports/20251205_214025_backdoor_sentry.md
[2025-12-05 21:40:25] [ALERT] Scan completed - 2 file(s) quarantined, 2 file(s) neutralized
```

**Log Levels:**
- `[INFO]` — Normal operations (scan started/completed with no findings)
- `[ALERT]` — Security events (findings detected, files quarantined, code neutralized)
- `[ERROR]` — Errors during scanning or quarantine operations

**Verify Scanner is Running:**
```bash
# View recent log entries
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com "tail -20 ~/backdoor_sentry.log"

# Watch logs in real-time
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com "tail -f ~/backdoor_sentry.log"

# Count scans in last 24 hours
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com "grep 'Scan started' ~/backdoor_sentry.log | wc -l"

# Check for any alerts
ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com "grep 'ALERT' ~/backdoor_sentry.log"
```

## Forensic Workflow after Detection

When a backdoor or pattern match is discovered:

1. **Automatic Actions:**
   - File is **quarantined** under `breech/quarantine/<timestamp>/<relative_path>`
   - **Scan report** written to `breech/backdoor_sentry_reports/<timestamp>.md`
   - Log entry with `[ALERT]` level in `~/backdoor_sentry.log`

2. **Investigation Steps:**
   - Review the log file entry (timestamp, file path, patterns matched)
   - Examine the quarantined file (preserves original with full path)
   - Read the detailed report in `backdoor_sentry_reports/`
   - **Correlate file modification time** (`ls -l --full-time`, `stat`) with scan time
   - Check external logs (web server, FTP, cPanel, admin audit) within ±5 minutes

3. **Timeline Analysis:**
   - Log timestamps are in UTC by default (add +8 hours for MYT)
   - Quarantine directory names include timestamp (`YYYYMMDD_HHMMSS`)
   - Reports include full timestamp in filename and content
   - Match these with external log timestamps to determine infection vector

## Incident Response

If an infection is detected:

1. **Immediate Actions:**
   - Review the log file entry (timestamp, file path, patterns matched)
   - Examine the quarantined file in `breech/quarantine/`
   - Read the detailed report in `breech/backdoor_sentry_reports/`
   - Check if neutralization was successful (if `--neutralize` was used)

2. **Investigation:**
   - Check external logs (FTP, cPanel, admin, auth) within ±5 minutes of detection time
   - Preserve all relevant logs immediately (some hosters rotate/erase daily)
   - Review file modification times on quarantined files
   - Identify infection vector (vulnerable plugin, compromised credentials, etc.)

3. **Reporting:**
   - Report indicators/IPs to hosting support if suspicious access seen
   - Document timeline of events for security audit
   - **Do NOT delete** infected/quarantined files until forensics is complete

4. **Remediation:**
   - Remove or restore neutralized files if needed
   - Patch vulnerabilities that allowed the infection
   - Change all passwords and API keys
   - Review and harden security measures

## Updating the Script

When you make changes to `tools/backdoor_sentry.py` locally, upload it to the server:

```bash
scp -i ssh/proptech_mpa_new tools/backdoor_sentry.py proptech@smaug.cygnusdns.com:~/public_html/proptech.org.my/tools/backdoor_sentry.py
```

The cron job will automatically use the updated script on the next run (within 5 minutes).

## Technical Notes

- **Scan Scope:** Focuses on `wp-content` (themes, plugins) and `wp-includes`, `wp-admin` directories
- **Quarantine:** Preserves original files with full relative paths and timestamps for forensics
- **Neutralization:** Comments out suspicious code lines (reversible) — enabled via `--neutralize` flag
- **Logging:** Automatic — every scan run is logged, making it easy to verify regular operation
- **Performance:** Scans are efficient and designed to run every 5 minutes without impact
- **Pattern Matching:** Uses regex patterns to detect obfuscated and encoded malicious code
- **Server Time:** UTC by default (add +8 hours for MYT when reading logs)

## Additional Monitoring

For comprehensive security monitoring, consider:
- Complementary file integrity scanning tools
- WordPress security audit logging plugins (e.g., WP Security Audit Log)
- Server-level intrusion detection systems
- Regular security audits and penetration testing



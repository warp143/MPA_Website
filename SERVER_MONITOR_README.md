# Server Security Monitor - Usage Guide

## Overview

`server_monitor.py` is a comprehensive Python-based security monitoring script for proptech.org.my that runs every 30 minutes to check for:

- **System Health:** CPU load, memory usage, disk space
- **Malware Detection:** ELF executables, Perl scripts, known malware signatures
- **Process Monitoring:** Cryptocurrency miners, suspicious processes
- **WordPress Security:** Login attempts, new users, suspicious accounts
- **SSH Access:** Failed login attempts, active sessions
- **File Changes:** Recently modified files, file count anomalies
- **Core Integrity:** WordPress core file verification

## Quick Start

### Run the Monitor

```bash
cd /Users/amk/Documents/GitHub/MPA_Website
python3 server_monitor.py
```

The script will:
1. Perform an immediate security scan
2. Display results in real-time with color-coded output
3. Log everything to `server_monitor_log.txt`
4. Wait 30 minutes and repeat automatically

### Run in Background

```bash
# Start in background
nohup python3 server_monitor.py > /dev/null 2>&1 &

# Get process ID
echo $!

# To stop later, use the process ID:
kill [PID]
```

### View Live Logs

```bash
# Follow the log file in real-time
tail -f server_monitor_log.txt

# View last scan results
tail -100 server_monitor_log.txt
```

## What It Checks

### 1. System Resources
- **Server Load:** Alerts if > 10.0 (critical) or > 5.0 (warning)
- **Memory Usage:** Monitors total vs. available
- **Disk Usage:** Checks space on proptech partition

**Normal Values:**
- Load: 0.3 - 2.0
- Memory: < 50% used
- Disk: < 80% used

### 2. Malware Files
- **ELF Executables:** Linux malware (should be 0)
- **Perl Scripts:** Malware downloaders (should be 0)
- **8-Character Random Filenames:** Malware pattern from Oct attack
- **Known Malware Files:** cloud.php, main_center.php, avmphku plugin
- **PHP in Uploads:** PHP files in wp-content/uploads (should be 0)

### 3. Suspicious Processes
- **Cryptocurrency Miners:** minerd, xmr-stak, cryptonight, stratum
- **High CPU Processes:** Top 5 CPU consumers
- **Random Process Names:** Checks for 8-character random names

### 4. WordPress Access
- **Recent Users:** Lists last 10 user accounts
- **Suspicious Usernames:** Checks for 'root', 'admin', 'test', 'hacker'
- **Admin Count:** Total administrator accounts

**Known Good Users:**
- admin_amk (ID: 10) - Main admin
- amk (ID: 1) - Legacy admin
- eugene.teow (ID: 2)
- charlotte (ID: 3)
- user.1-4 (ID: 4-7)

### 5. SSH Access Monitoring
- **Failed Login Attempts:** Recent failed SSH password attempts
- **Currently Logged In:** Active SSH sessions
- **Last Logins:** History of last 10 connections

### 6. Cron Jobs
- **User Crontab:** Checks for malicious scheduled tasks
- **Suspicious Patterns:** Jobs pointing to wp-content or running every 15min

**Expected:** "No user crontab" (Good!)

### 7. File Changes
- **Recently Modified:** Files changed in last 30 minutes
- **File Count:** Total files vs. baseline (3,219 files)
- **Alerts if:** File count increases by > 50 files

### 8. WordPress Core Integrity
- **Core Files Check:** Verifies these files start with `<?php`:
  - class-wp-rest-post-statuses-controller.php
  - class-wp-rest-users-controller.php

## Output Examples

### Clean System
```
✅ Load normal: [1.06, 1.18, 0.90]
✅ ELF/Perl malware: 0 files
✅ Random filenames: 0 files
✅ PHP in uploads: 0 files
✅ No unexpected file modifications
✅ File count stable
✅ VERDICT: ALL CHECKS PASSED - SYSTEM CLEAN
```

### Malware Detected
```
⚠️ CRITICAL: 5 ELF/Perl malware files detected!
Malware files:
wp-content/plugins/some-plugin/y9s4pux5: Perl script
wp-content/themes/theme/2vxnbio0: ELF 64-bit executable
...

⚠️ 5 ALERTS DETECTED:
  ⚠️ MALWARE DETECTED: 5 ELF/Perl files!
  ⚠️ SUSPICIOUS FILES: 3 random filenames!
  ⚠️ FILE COUNT INCREASE: +8 files!

🔴 VERDICT: THREATS OR ANOMALIES DETECTED - INVESTIGATE IMMEDIATELY!
```

## Color Coding

- **🟢 GREEN:** All clear, normal operation
- **🟡 YELLOW:** Warning, elevated but not critical
- **🔵 BLUE:** Informational messages
- **🔴 RED:** Critical alerts, immediate action needed

## Log File Format

Logs are saved to `server_monitor_log.txt` with timestamps:

```
[2025-10-28 14:30:15] --- SCAN #1 ---
[2025-10-28 14:30:15] ══════════════════════════════════════════════════════════
[2025-10-28 14:30:15] SERVER SECURITY SCAN STARTED
[2025-10-28 14:30:15] Server: proptech.org.my
[2025-10-28 14:30:15] Time: Monday, October 28, 2025 at 02:30:15 PM
...
```

## Configuration

Edit these variables in `server_monitor.py`:

```python
SSH_KEY = "ssh/proptech_mpa_new"           # SSH key path
SSH_HOST = "proptech@smaug.cygnusdns.com"  # SSH connection
WP_PATH = "~/public_html/proptech.org.my"  # WordPress path
LOG_FILE = "server_monitor_log.txt"        # Log file name
BASELINE_FILE_COUNT = 3219                 # Expected file count
SCAN_INTERVAL = 1800                       # 30 minutes (seconds)
```

## Troubleshooting

### "Permission denied" SSH Error
```bash
# Fix SSH key permissions
chmod 600 ssh/proptech_mpa_new
```

### Script Won't Start
```bash
# Check Python version (needs 3.6+)
python3 --version

# Make sure script is executable
chmod +x server_monitor.py
```

### Can't Read Auth Logs
Some SSH checks require elevated privileges. This is normal - the script will note "Cannot access auth logs (permission restricted)" but continue with other checks.

### High False Positive Rate
If you get too many warnings:
1. Adjust thresholds in the script (e.g., load average limits)
2. Update `BASELINE_FILE_COUNT` after legitimate updates
3. Add exceptions for known good processes

## What to Do If Malware Is Detected

1. **DO NOT DELETE FILES YET** - Document first
2. **Stop the monitor** (Ctrl+C)
3. **Check the log file** for details
4. **Follow emergency procedures** in `SECURITY_MONITORING_GUIDE.md`
5. **Document evidence:**
   ```bash
   ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com \
     "cd ~/public_html/proptech.org.my && \
      find wp-content -type f -exec file {} \; | grep -E 'ELF|Perl script' \
      > ~/malware_evidence_$(date +%Y%m%d_%H%M%S).txt"
   ```

## Integration with Other Tools

### Email Alerts (Optional)

Add email notifications when threats are detected. Install `sendmail` or use an SMTP library:

```python
import smtplib
from email.message import EmailMessage

# In generate_summary():
if self.alerts:
    msg = EmailMessage()
    msg.set_content('\n'.join(self.alerts))
    msg['Subject'] = 'SECURITY ALERT - proptech.org.my'
    msg['From'] = 'monitor@proptech.org.my'
    msg['To'] = 'admin@youremail.com'
    
    s = smtplib.SMTP('localhost')
    s.send_message(msg)
    s.quit()
```

### Slack/Discord Webhooks

Post alerts to team chat:

```python
import requests

if self.alerts:
    webhook_url = "YOUR_WEBHOOK_URL"
    requests.post(webhook_url, json={
        "text": f"⚠️ Security Alert: {len(self.alerts)} threats detected!"
    })
```

## Schedule as System Service (Advanced)

### macOS (LaunchAgent)

Create `~/Library/LaunchAgents/com.proptech.monitor.plist`:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
<dict>
    <key>Label</key>
    <string>com.proptech.monitor</string>
    <key>ProgramArguments</key>
    <array>
        <string>/usr/bin/python3</string>
        <string>/Users/amk/Documents/GitHub/MPA_Website/server_monitor.py</string>
    </array>
    <key>RunAtLoad</key>
    <true/>
    <key>KeepAlive</key>
    <true/>
    <key>StandardOutPath</key>
    <string>/Users/amk/Documents/GitHub/MPA_Website/monitor_stdout.log</string>
    <key>StandardErrorPath</key>
    <string>/Users/amk/Documents/GitHub/MPA_Website/monitor_stderr.log</string>
</dict>
</plist>
```

Load it:
```bash
launchctl load ~/Library/LaunchAgents/com.proptech.monitor.plist
```

### Linux (systemd)

Create `/etc/systemd/system/proptech-monitor.service`:

```ini
[Unit]
Description=Proptech Security Monitor
After=network.target

[Service]
Type=simple
User=youruser
WorkingDirectory=/path/to/MPA_Website
ExecStart=/usr/bin/python3 /path/to/server_monitor.py
Restart=always

[Install]
WantedBy=multi-user.target
```

Enable and start:
```bash
sudo systemctl enable proptech-monitor
sudo systemctl start proptech-monitor
sudo systemctl status proptech-monitor
```

## Related Documents

- **SECURITY_INCIDENT_REPORT.md** - Details of October 24 attack
- **MALWARE_CLEANUP_REPORT_2025-10-27.md** - Cleanup procedures
- **SECURITY_MONITORING_GUIDE.md** - Manual security checks
- **SERVER_ACCESS_GUIDE.md** - Server access credentials

## Version History

| Version | Date | Changes |
|---------|------|---------|
| 1.0 | Oct 28, 2025 | Initial release - Python monitoring script |

---

**For Support:** Contact amk (test@gmail.com)  
**Last Updated:** October 28, 2025


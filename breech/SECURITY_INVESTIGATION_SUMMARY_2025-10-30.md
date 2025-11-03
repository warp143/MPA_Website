# 🚨 SECURITY INVESTIGATION SUMMARY — 30 October 2025

**Website:** proptech.org.my  
**Scope:** Deep forensic investigation post-backdoor/compromise incidents (Oct 24–30)  
**Prepared:** AI Assistant (for admin review)

---

### 1. Key Findings
- **No persistent or dormant backdoor code** found in any current files or historical UpdraftPlus backups (manual and automated scans complete).
- **All major backups (themes.zip)** from UpdraftPlus, both earliest and most recent, are clean with no presence of the `functions.php` user-creation backdoor or similar persistence logic.
- **No evidence of new suspicious code uploads, injections, or plugin exploits** detected in any webserver, plugin, or WordPress logs since the last clean backup.

### 2. Confirmed Attack Vector
- **The original backdoor was inserted into `functions.php` after the last backup and before incident detection.**
- The most probable scenarios for code insertion are:
  - **A. Compromised FTP credentials:** FTP service (ProFTPD) is running and may be accessible if not firewalled or geo-restricted, even if you never manually set up FTP users (hosting defaults often enable it).
  - **B. Compromised WordPress admin account:** If the admin login was brute-forced or leaked, the attacker could use the WP Theme Editor to insert code without creating files or logs visible to you.
- **Geo-restrictions block cPanel/SSH access from outside Malaysia,** making them less likely as the breach vector. FTP is likely not similarly restricted. 
- **No shell/login user accounts with active shells were found** (except root, which is standard and not configured for FTP by default).

### 3. What Was NOT Found
- No evidence the attacker re-gained access after removal/hardening (no new code, users, or web-based upload activity).
- No hidden/dormant malware in current or backup files.
- No plugin vulnerabilities or unknown web admin entries between backup and incident.
- No suspicious cron jobs or automated jobs overwriting your files.
- No cPanel or SSH logins from foreign IPs recorded.

### 4. Remaining Unknowns / Next Steps
- **FTP logs missing:** No server-side FTP/DFTP logs available to confirm or deny logins from foreign IPs. Direct hoster inquiry recommended.
- **Some attack traces may not be visible in web logs:** Attackers may have covered their tracks, or exploited weak FTP/admin panel credentials.
- **Verify FTP access controls:** Strongly recommended to disable or geo-restrict FTP, change all main passwords, and review hosting-level access logs with provider.
- **Ongoing monitoring:** Continue with Wordfence, sentry scripts, manual daily/weekly scans, and keep an eye on all admin logs.

---

**Summary:**
- No missed malware or persistent backdoors found in current files or backups.
- Post-backup code injection most likely via FTP or admin panel access, not plugin exploit or cPanel.
- All signs indicate system is clean since hardening, but please consider resolving all remaining unknowns with host.

---

**Last Updated:** 30 October 2025











# Backdoor Sentry — Automated Hidden-Admin Backdoor Watch

This tool scans your WordPress install for a specific, high‑risk backdoor family
that creates a hidden `root` admin and hides it via `_pre_user_id` and
`protect_user_*` helpers. When detected, it quarantines the file and generates a
report. Optionally, it neutralizes (comments) the suspicious code in place.

## Files
- `tools/backdoor_sentry.py` — main scanner script
- **Scan log:** `/home/proptech/backdoor_sentry.log` (one entry every 5 minutes)
- **Reports:** `breech/backdoor_sentry_reports/` (full incident records)
- **Quarantine:** `breech/quarantine/<timestamp>/<infected_file>` (full captured files for forensics)
- **Malware samples:** `breech/malware_samples/` (archived/categorized threats found by manual/other tools)

## Run (server/cron)
```bash
python3 tools/backdoor_sentry.py \
  --wp-root ~/public_html/proptech.org.my \
  --neutralize --verbose
```
- Default: every 5 minutes (configured by cron)
- Adjust with `crontab -e` as needed (update interval)

Exit codes:
- `0` — No findings
- `1` — Findings quarantined
- `2` — Error

## Patterns Detected
- `wp_insert_user(... 'role' => 'administrator' ...)`
- `username_exists('root')`
- `admin@wordpress.com`
- `_pre_user_id`
- `wp_admin_users_protect_user_query`
- `protect_user_from_deleting` / `protect_user_count`

## Forensic Workflow after Detection
- When a backdoor or pattern match is discovered:
  - The file is **quarantined** under `breech/quarantine/` with timestamp and original path
  - A **scan report** is written to `breech/backdoor_sentry_reports/` (log event with context)
  - Log entry in `/home/proptech/backdoor_sentry.log` shows scan/detection minute (UTC unless configured otherwise)
- **Correlate file modification time (`ls -l --full-time`, `stat` on the quarantined file) with scan time and external logs** (web, FTP, admin audit) to determine infection vector

### Note on Timestamps
- **Scan/server log time is UTC** by default unless hosting support updates the OS timezone (use +8 hours for MYT)
- Logs and reports WILL match quarantine/discovery minutes; use this for timeline analysis

## If an Infection is Detected
1. Review the log, report, and quarantined file immediately
2. Check external logs (FTP, cPanel, admin, auth) within ±5 minutes of the mtime/scan
3. Preserve all relevant logs (rotate/log immediately—some hosters erase/rotate daily)
4. Report indicators/IPs to hosting support if suspicious access seen
5. Leave the infected/quarantined files for evidence—do NOT delete unless forensics is complete

## Notes
- The scanner is conservative and focuses on theme/plugin PHP under `wp-content`.
- Quarantine keeps original copies with full relative paths and timestamps.
- Start with `--neutralize` to comment only the matched lines (reversible).
- For additional monitoring, consider running complementary integrity scans and enabling WordPress audit logging plugins.



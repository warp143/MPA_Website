# Backdoor Sentry — Automated Hidden-Admin Backdoor Watch

This tool scans your WordPress install for a specific, high‑risk backdoor family
that creates a hidden `root` admin and hides it via `_pre_user_id` and
`protect_user_*` helpers. When detected, it quarantines the file and generates a
report. Optionally, it neutralizes (comments) the suspicious code in place.

## Files
- `tools/backdoor_sentry.py` — main scanner
- Reports → `breech/backdoor_sentry_reports/`
- Quarantine → `breech/quarantine/<timestamp>/`

## Run (server)
```bash
python3 tools/backdoor_sentry.py \
  --wp-root ~/public_html/proptech.org.my \
  --neutralize --verbose
```

Exit codes:
- `0` — No findings
- `1` — Findings quarantined
- `2` — Error

## Schedule every 10 minutes (cron)
```bash
crontab -e
# Add:
*/10 * * * * cd ~/public_html/proptech.org.my && \
/usr/bin/python3 tools/backdoor_sentry.py --wp-root ~/public_html/proptech.org.my --neutralize >> ~/backdoor_sentry.log 2>&1
```

## Patterns detected
- `wp_insert_user(... 'role' => 'administrator' ...)`
- `username_exists('root')`
- `admin@wordpress.com`
- `_pre_user_id`
- `wp_admin_users_protect_user_query`
- `protect_user_from_deleting` / `protect_user_count`

## Notes
- The scanner is conservative and focuses on theme/plugin PHP under `wp-content`.
- Quarantine keeps original copies with full relative paths and timestamps.
- Start with `--neutralize` to comment only the matched lines (reversible).



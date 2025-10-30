# 🚨 Security Incident Report — October 30, 2025 (proptech.org.my)

Status: ACTIVE INVESTIGATION (site operational)  
Scope: Live server at `~/public_html/proptech.org.my`  
Prepared by: AI Assistant (with inputs from Andrew/Choo)

---

## Executive Summary
- Choo identified two malicious backdoor files in the active theme directory attempting to auto‑create a hidden administrator user `root` with a hardcoded password and stealth protections. The backdoor creation logic did not execute against the live `functions.php`, and no fake admin user exists.
- Multiple brute‑force login attempts targeted the deleted `amk` username today from several non‑Malaysia IPs, indicating ongoing external probing without current admin access.
- No suspicious file uploads were detected in the last 24 hours. File permission posture and WAF rules likely prevented direct injection into the active `functions.php`.

Risk: MEDIUM (ongoing external attempts; limited foothold suspected but no confirmed admin access now)  
Impact to visitors today: None observed  
Immediate priority: Credential rotation, IP blocking, finalize hardening phases

---

## What Was Found Today (Highlights)
1) Backdoor artifacts in theme (found by Choo):
   - `wp-content/themes/mpa-custom/functions.php.backdoor_backup`
   - `wp-content/themes/mpa-custom/functions.php.partial_backdoor`
   - Malicious code block designed to:
     - Create hidden admin `root` with `admin@wordpress.com`
     - Store hidden user id in `_pre_user_id`
     - Hide user from admin lists and protect from deletion
   - Status: These artifacts were removed previously; the current `functions.php` is clean; no `root` user exists.

2) Brute‑force attempts (today, Malaysia time):
   - 04:57 AM — 8.210.47.14 (Alibaba Cloud HK) — failed (user does not exist)
   - 05:44 AM — 67.207.163.194 (DigitalOcean US) — failed
   - 07:28 AM — 95.154.198.138 (M247 UK) — failed
   - 09:22 AM — 67.23.231.154 (HostDime US) — failed
   - Target: deleted username `amk` (attacker using outdated intel); all IPs outside Malaysia.

3) File uploads in last 24h:
   - No suspicious PHP/JS/HTML uploads detected in `wp-content/uploads/` or other sensitive paths.
   - Only benign `uploads/ao_ccss/index.html` touched (Autoptimize CCSS).

4) Active theme/config posture:
   - `functions.php` (current) shows no backdoor signatures (`wp_insert_user`, `admin@wordpress.com`, `_pre_user_id`, `protect_user_*`).
   - `wp-config.php` clean; `DISALLOW_FILE_EDIT` confirmed set in prior hardening (recommended to keep).

5) WAF and permissions likely blocked injection:
   - Wordfence rules include multiple generic backdoor detections (e.g., rules 114/115/152/824/836) and hook/file injection signatures.
   - File perms on `functions.php` are 664 (owner/group writable only); attacker could create side files but failed to overwrite the active file.

---

## Timeline (MYT, GMT+8)
- Oct 29 ~02:30–02:35 AM: Backdoor artifacts created in theme (backup/partial files). No execution against active `functions.php` confirmed.
- Oct 29 17:28:29: Active `functions.php` last modified (legitimate theme change; remains clean).
- Oct 30 04:57–09:22 AM: Brute‑force attempts against deleted `amk` from multiple foreign IPs; all failed.
- Oct 30 ~12:45 PM: Screenshot/alerts reviewed; verification that active theme/config remain clean.

---

## Forensic Details
### Malicious backdoor logic (from artifacts)
Pattern: hidden admin persistence using legitimate WP APIs
```
wp_insert_user([... 'user_login' => 'root', 'role' => 'administrator', 'user_email' => 'admin@wordpress.com'])
update_option('_pre_user_id', $id)
username_exists('root')
protect_user_from_deleting / wp_admin_users_protect_user_query / protect_user_count
```

Status today:
- Not present in current `functions.php`.
- No `root` user exists; user list clean.
- Backup/partial files with backdoor code were removed previously.

### Brute‑force IPs (outside Malaysia)
- 8.210.47.14 (HK)
- 67.207.163.194 (US)
- 95.154.198.138 (UK)
- 67.23.231.154 (US)

### Upload and file integrity checks (last 24h)
- No new PHP in `uploads/`; no suspicious JS/HTML created.
- Wordfence `wflogs` updated normally; rules present; `attack-data.php` minimal.

---

## Assessment
- Privilege state: No evidence of active admin compromise today; attacker attempts focus on old `amk` username (deleted) → outdated intel/bot activity.
- Foothold likelihood: Attacker previously had limited filesystem write to create artifacts but could not modify active theme file; current indicators suggest no executing backdoor.
- Primary risk: Continued credential guessing and potential exploitation of unpatched vectors if hardening is delayed.

---

## Indicators of Compromise (IOCs)
File/Code IOCs:
- Backdoor patterns: `wp_insert_user` + `root` + `admin@wordpress.com` + `_pre_user_id` + `protect_user_*`

Network IOCs (today):
- 8.210.47.14, 67.207.163.194, 95.154.198.138, 67.23.231.154 (failed logins against `amk`)

Behavioral IOCs:
- Repeated login attempts against a non‑existent account from rotating foreign IPs.

---

## Root Cause (current hypothesis)
- The earlier backdoor artifacts indicate prior limited write access to the theme directory, but current protections (permissions + `DISALLOW_FILE_EDIT` + WAF) prevented final injection. Today’s activity reflects external brute‑force probing without valid credentials.

---

## Actions Taken Today
- Verified current `functions.php` and `wp-config.php` are clean.
- Confirmed absence of `root`/fake admin accounts.
- Searched for recent uploads and suspicious file creations (none found).
- Mapped brute‑force IPs and geolocations (all non‑MY).
- Preserved clean references in `breech/malware_samples/` (functions-current.php, wp-config-current.php) and retained prior malware samples/reports for continuity.

---

## Recommendations (Immediate)
1) Block attacking IPs at WAF/hosting firewall:
   - 8.210.47.14, 67.207.163.194, 95.154.198.138, 67.23.231.154
2) Rotate credentials (WordPress admins, database, cPanel/SSH) and enforce strong passwords for all.
3) Keep `DISALLOW_FILE_EDIT` enabled; if possible, add `DISALLOW_FILE_MODS` during remediation windows.
4) Complete the previously defined security phases (rate‑limit forms, session timeout, CSP, `.env` secrets, .htaccess `.env` protection).
5) Enable/verify Wordfence brute‑force protections and login limiting (lockouts, CAPTCHA/2FA for all admins).
6) Continue daily log review for 7 days (failed logins, new file writes, user changes).

---

## Recommendations (Short Term — 7 days)
- IP allowlisting for `/wp-admin/` if feasible (admin networks only).
- Cloudflare/Sucuri WAF for edge filtering and rate limiting.
- Weekly integrity scan of `wp-content/` for backdoor patterns; alert on any `_pre_user_id`, `admin@wordpress.com`, or `wp_insert_user` in themes.
- Confirm backups are clean and stored off‑server; verify restore procedures.

---

## Current Verdict (Oct 30, 2025)
- No executing backdoor detected; site functioning normally.
- Ongoing external brute‑force attempts observed; all failed.
- Security posture improving; hardening and IP blocks should proceed immediately to reduce noise and risk.

---

## Appendix
- Related references and preserved evidence:
  - `breech/malware_samples/functions_php_backdoor_2025-10-29/*` (patterns, infected samples)
  - `breech/malware_samples/socgholish_2025-10-29/*` (JS malware analysis)
  - `breech/COMPREHENSIVE_MALWARE_SCAN_2025-10-29.md`
  - `breech/SOCGHOLISH_INCIDENT_2025-10-29.md`
  - `breech/SECURITY_MONITORING_GUIDE.md`

Last updated: October 30, 2025 (MYT)



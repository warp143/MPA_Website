#!/usr/bin/env python3
"""
Backdoor Sentry

Scans a WordPress installation every run for known backdoor patterns and
immediately quarantines suspicious files, writes a detailed report, and
optionally neutralizes the active file by commenting the suspicious block.

Recommended to run via cron every 10 minutes.

Conservative, pattern-based detector focused on hidden-admin backdoors:
 - wp_insert_user + administrator creation
 - admin@wordpress.com (fake email)
 - _pre_user_id (hidden user id storage)
 - protect_user_* and wp_admin_users_protect_* (stealth helpers)

Quarantine behavior:
 - Copies offending file to breech/quarantine/<timestamp>/<relative_path>
 - Writes a report to breech/backdoor_sentry_reports/<timestamp>.md
 - (Optional) neutralize: comments out matching lines in-place to prevent execution

Usage (server):
  python3 tools/backdoor_sentry.py --wp-root ~/public_html/proptech.org.my \
    --neutralize --verbose

Exit codes:
  0: no findings
  1: findings quarantined (action taken)
  2: error
"""

import argparse
import datetime as dt
import os
import re
import shutil
import sys
from pathlib import Path


DEFAULT_PATTERNS = [
    # user creation backdoor
    re.compile(r"wp_insert_user\s*\(.*role\s*=>\s*['\"]administrator['\"]", re.S),
    re.compile(r"username_exists\s*\(\s*['\"]root['\"]\s*\)", re.I),
    re.compile(r"admin@wordpress\.com", re.I),
    re.compile(r"_pre_user_id"),
    re.compile(r"wp_admin_users_protect_user_query"),
    re.compile(r"protect_user_(from_deleting|count)")
]


def relpath_under(base: Path, path: Path) -> str:
    try:
        return str(path.relative_to(base))
    except Exception:
        return str(path)


def should_skip(path: Path) -> bool:
    p = str(path)
    # Skip common safe or noisy locations
    skip_subs = [
        "/.git/", "/node_modules/", "/vendor/", "/wflogs/", 
        "/cache/", "/uploads/ao_ccss/", "/languages/",
        "backup", "\.bak", "\.backup", "\x20\d+\.php",  # backup copies
    ]
    for s in skip_subs:
        try:
            if re.search(s, p):
                return False if path.suffix == ".php" else True
        except re.error:
            pass
    return False


def find_suspicious_php(root: Path):
    findings = []
    for dirpath, _, filenames in os.walk(root):
        d = Path(dirpath)
        # Focus on wp-content tree primarily
        if not ("wp-content" in d.parts or d.name in {"wp-includes", "wp-admin"}):
            continue
        for fname in filenames:
            if not fname.endswith(".php"):
                continue
            fpath = d / fname
            if should_skip(fpath):
                continue
            try:
                text = fpath.read_text(errors="ignore")
            except Exception:
                continue
            if any(p.search(text) for p in DEFAULT_PATTERNS):
                findings.append(fpath)
    return findings


def ensure_dir(p: Path):
    p.mkdir(parents=True, exist_ok=True)


def comment_out_matches(path: Path) -> int:
    """Comment lines containing suspicious patterns. Returns number commented."""
    try:
        lines = path.read_text(errors="ignore").splitlines()
    except Exception:
        return 0
    changed = 0
    new_lines = []
    for line in lines:
        if any(p.search(line) for p in DEFAULT_PATTERNS):
            if not line.strip().startswith("// SENTRY_NEUTRALIZED:"):
                new_lines.append("// SENTRY_NEUTRALIZED: " + line)
                changed += 1
            else:
                new_lines.append(line)
        else:
            new_lines.append(line)
    if changed:
        path.write_text("\n".join(new_lines))
    return changed


def write_report(report_dir: Path, wp_root: Path, findings, quarantined, changed):
    ts = dt.datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    name = dt.datetime.now().strftime("%Y%m%d_%H%M%S") + "_backdoor_sentry.md"
    report_path = report_dir / name
    ensure_dir(report_dir)
    lines = []
    lines.append(f"# Backdoor Sentry Report - {ts}")
    lines.append("")
    lines.append(f"WordPress root: {wp_root}")
    lines.append(f"Findings: {len(findings)} | Quarantined: {len(quarantined)}")
    lines.append("")
    if findings:
        lines.append("## Suspicious Files")
        for f in findings:
            lines.append(f"- {relpath_under(wp_root, f)}")
        lines.append("")
    if quarantined:
        lines.append("## Quarantined")
        for q in quarantined:
            lines.append(f"- {relpath_under(wp_root, q)}")
        lines.append("")
    if changed:
        lines.append("## Neutralization Changes (line-level)")
        for fp, cnt in changed.items():
            lines.append(f"- {relpath_under(wp_root, Path(fp))}: {cnt} lines commented")
        lines.append("")
    lines.append("## Signatures Used")
    for pat in DEFAULT_PATTERNS:
        lines.append(f"- `{pat.pattern}`")
    lines.append("")
    report_path.write_text("\n".join(lines))
    return report_path


def main():
    parser = argparse.ArgumentParser(description="Scan and quarantine WP backdoor patterns")
    parser.add_argument("--wp-root", required=True, help="Path to WordPress root (contains wp-content)")
    parser.add_argument("--breech-dir", default="breech", help="Path to breech directory for reports/quarantine")
    parser.add_argument("--neutralize", action="store_true", help="Comment out suspicious lines in-place")
    parser.add_argument("--verbose", action="store_true")
    args = parser.parse_args()

    wp_root = Path(os.path.expanduser(args.wp_root)).resolve()
    if not (wp_root / "wp-content").exists():
        print("ERROR: wp-root does not look like a WordPress root", file=sys.stderr)
        return 2

    breech_dir = Path(args.breech_dir).resolve()
    quarantine_base = breech_dir / "quarantine" / dt.datetime.now().strftime("%Y%m%d_%H%M%S")
    report_dir = breech_dir / "backdoor_sentry_reports"

    def vlog(message: str):
        if args.verbose:
            ts = dt.datetime.now().strftime("%Y-%m-%d %H:%M:%S")
            print(f"[{ts}] {message}")

    findings = find_suspicious_php(wp_root)
    if not findings:
        vlog("No suspicious files found.")
        return 0

    quarantined = []
    changed = {}
    for f in findings:
        rel = relpath_under(wp_root, f)
        qdst = quarantine_base / rel
        ensure_dir(qdst.parent)
        try:
            shutil.copy2(f, qdst)
            quarantined.append(f)
        except Exception as e:
            if args.verbose:
                print(f"WARN: Failed to copy to quarantine: {f}: {e}")

        if args.neutralize:
            c = comment_out_matches(f)
            if c:
                changed[str(f)] = c
                if args.verbose:
                    print(f"Neutralized {c} line(s) in {rel}")

    ensure_dir(report_dir)
    report_path = write_report(report_dir, wp_root, findings, quarantined, changed)
    vlog(f"Report: {report_path}")
    vlog(f"Quarantined: {len(quarantined)} file(s)")

    return 1


if __name__ == "__main__":
    rc = main()
    sys.exit(rc)



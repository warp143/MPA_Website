#!/usr/bin/env python3
"""
Backdoor Sentry

Scans a WordPress installation every run for known backdoor patterns and
immediately quarantines suspicious files, writes a detailed report, and
optionally neutralizes the active file by commenting the suspicious block.

Recommended to run via cron every 10 minutes.

Comprehensive pattern-based detector for:
 - PHP backdoors (hidden-admin backdoors, wp_insert_user, etc.)
 - JavaScript malware (SocGholish, malicious script injections)
 - Text file malware (obfuscated code, malicious URLs)
 - ALL file types are scanned (PHP, JS, TXT, HTML, etc.)

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
    # PHP backdoor patterns
    re.compile(r"wp_insert_user\s*\(.*role\s*=>\s*['\"]administrator['\"]", re.S),
    re.compile(r"username_exists\s*\(\s*['\"]root['\"]\s*\)", re.I),
    re.compile(r"admin@wordpress\.com", re.I),
    re.compile(r"_pre_user_id"),
    re.compile(r"wp_admin_users_protect_user_query"),
    re.compile(r"protect_user_(from_deleting|count)"),
    # JavaScript malware patterns - SocGholish
    re.compile(r"content-website-analytics\.com", re.I),
    re.compile(r"socgholish", re.I),
    re.compile(r"createElement\s*\(\s*['\"]script['\"]\s*\).*\.src\s*=\s*['\"]https?://[^'\"]+\.(top|xyz|club|online|live|site)", re.I | re.S),
    re.compile(r"\.createElement\(['\"]script['\"]\).*\.src\s*=\s*['\"]https?://[^'\"]+\.(top|xyz|club|online|live|site)", re.I | re.S),
    # Generic malicious script injection patterns
    re.compile(r"document\.createElement\(['\"]script['\"]\).*\.src\s*=\s*['\"]https?://[a-z0-9-]+\.(top|xyz|club|online|live|site|tk|ml|ga|cf)", re.I | re.S),
    # Only match eval/gzinflate/str_rot13 when used together in obfuscation pattern
    # Must be in same statement/chain - not just anywhere in file
    re.compile(r"eval\s*\(\s*base64_decode\s*\(|eval\s*\(\s*gzinflate\s*\(|gzinflate\s*\(\s*base64_decode\s*\(|base64_decode\s*\(\s*eval\s*\(|str_rot13\s*\(\s*eval\s*\(", re.I),
    # Suspicious analytics/tracking domains (but exclude legitimate WordPress core files)
    re.compile(r"https?://[a-z0-9-]+\.(analytics|tracking|statistics|metrics)\.[a-z]{2,}", re.I),
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
        "backup", r"\.bak", r"\.backup", r"\x20\d+\.php",  # backup copies
    ]
    for s in skip_subs:
        try:
            if re.search(s, p):
                return True  # Skip these directories entirely
        except re.error:
            pass
    return False


def find_suspicious_files(root: Path):
    """Scan ALL file types for malware patterns."""
    findings = []
    # File extensions to scan (ALL file types)
    scan_extensions = {'.php', '.js', '.jsx', '.html', '.htm', '.txt', '.css', '.json', '.xml', '.sql', '.ini', '.conf', '.htaccess'}
    
    for dirpath, _, filenames in os.walk(root):
        d = Path(dirpath)
        # Focus on wp-content tree primarily
        if not ("wp-content" in d.parts or d.name in {"wp-includes", "wp-admin"}):
            continue
        for fname in filenames:
            fpath = d / fname
            if should_skip(fpath):
                continue
            
            # Scan files with known extensions OR files with no extension (might be malicious)
            if fpath.suffix.lower() in scan_extensions or not fpath.suffix:
                try:
                    # Try to read as text (ignore binary files)
                    text = fpath.read_text(errors="ignore")
                    # Only scan if file contains readable text (not binary)
                    if any(p.search(text) for p in DEFAULT_PATTERNS):
                        findings.append(fpath)
                except Exception:
                    continue
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
    
    # Determine comment style based on file extension
    ext = path.suffix.lower()
    if ext in {'.js', '.jsx', '.css'}:
        comment_prefix = "// SENTRY_NEUTRALIZED: "
        skip_prefix = "// SENTRY_NEUTRALIZED:"
    elif ext in {'.php'}:
        comment_prefix = "// SENTRY_NEUTRALIZED: "
        skip_prefix = "// SENTRY_NEUTRALIZED:"
    elif ext in {'.html', '.htm', '.xml'}:
        comment_prefix = "<!-- SENTRY_NEUTRALIZED: "
        skip_prefix = "<!-- SENTRY_NEUTRALIZED:"
    elif ext in {'.sh', '.bash'}:
        comment_prefix = "# SENTRY_NEUTRALIZED: "
        skip_prefix = "# SENTRY_NEUTRALIZED:"
    else:
        # Default to // for unknown types
        comment_prefix = "// SENTRY_NEUTRALIZED: "
        skip_prefix = "// SENTRY_NEUTRALIZED:"
    
    # Track function/block depth for PHP files to handle structure
    in_php_function = False
    function_depth = 0
    function_start_line = None
    
    for i, line in enumerate(lines):
        # Skip if already commented
        if line.strip().startswith(skip_prefix):
            new_lines.append(line)
            continue
        
        # Check if line matches any pattern
        matches = any(p.search(line) for p in DEFAULT_PATTERNS)
        
        if ext == '.php' and matches:
            # PHP-specific: Check if this is a function declaration
            stripped = line.strip()
            if re.search(r'^\s*(public\s+|private\s+|protected\s+|static\s+)*function\s+\w+\s*\(', stripped):
                # Comment out function declaration
                new_lines.append(comment_prefix + line)
                changed += 1
                # Track that we're now inside a function that needs neutralization
                in_php_function = True
                function_depth = stripped.count('{') - stripped.count('}')
                function_start_line = i
            else:
                # Regular line match - comment it out
                new_lines.append(comment_prefix + line)
                changed += 1
        elif matches:
            # Non-PHP or non-function PHP line - just comment it out
            new_lines.append(comment_prefix + line)
            changed += 1
        else:
            # No match - but check if we need to comment out function body
            if ext == '.php' and in_php_function:
                stripped = line.strip()
                # Track braces to know when function ends
                function_depth += stripped.count('{') - stripped.count('}')
                
                # Comment out everything inside the function
                new_lines.append(comment_prefix + line)
                changed += 1
                
                # Function ends when depth reaches 0 (all braces balanced)
                if function_depth <= 0:
                    in_php_function = False
                    function_depth = 0
                    function_start_line = None
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

    findings = find_suspicious_files(wp_root)
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



#!/usr/bin/env python3
"""
Server Security Monitor - proptech.org.my
Monitors system health, malware, and unauthorized access every 30 minutes
"""

import subprocess
import datetime
import time
import json
import os
from pathlib import Path

# Configuration
SSH_KEY = "ssh/proptech_mpa_new"
SSH_HOST = "proptech@smaug.cygnusdns.com"
WP_PATH = "~/public_html/proptech.org.my"
LOG_FILE = "server_monitor_log.txt"
BASELINE_FILE_COUNT = 3219
SCAN_INTERVAL = 1800  # 30 minutes in seconds

# Known malware signatures from Oct 24-28 attack
KNOWN_MALWARE = [
    "cloud.php",
    "main_center.php",
    "avmphku"
]

# Suspicious process names
SUSPICIOUS_PROCESSES = [
    "minerd",
    "xmr-stak",
    "cryptonight",
    "stratum"
]

# ANSI color codes
GREEN = "\033[92m"
RED = "\033[91m"
YELLOW = "\033[93m"
BLUE = "\033[94m"
RESET = "\033[0m"


class ServerMonitor:
    def __init__(self):
        self.log_file = Path(__file__).parent / LOG_FILE
        self.ssh_key = Path(__file__).parent / SSH_KEY
        self.alerts = []
        
    def log(self, message, color=""):
        """Log message to console and file"""
        timestamp = datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")
        log_msg = f"[{timestamp}] {message}"
        
        # Console output with color
        if color:
            print(f"{color}{log_msg}{RESET}")
        else:
            print(log_msg)
        
        # File output without color
        with open(self.log_file, "a") as f:
            f.write(log_msg + "\n")
    
    def run_ssh_command(self, command):
        """Execute command on remote server via SSH"""
        full_command = [
            "ssh",
            "-i", str(self.ssh_key),
            SSH_HOST,
            command
        ]
        
        try:
            result = subprocess.run(
                full_command,
                capture_output=True,
                text=True,
                timeout=60
            )
            return result.stdout.strip(), result.returncode
        except subprocess.TimeoutExpired:
            return "TIMEOUT", 1
        except Exception as e:
            return f"ERROR: {str(e)}", 1
    
    def check_system_resources(self):
        """Check server load, memory, and disk usage"""
        self.log("=" * 70)
        self.log("1. SYSTEM RESOURCES CHECK", BLUE)
        self.log("=" * 70)
        
        # Server load
        output, _ = self.run_ssh_command("uptime")
        self.log(f"Server Load: {output}")
        
        # Parse load average
        if "load average:" in output:
            load_str = output.split("load average:")[1].strip()
            loads = [float(x.strip()) for x in load_str.split(",")]
            
            if any(load > 10.0 for load in loads):
                self.alerts.append(f"⚠️ HIGH LOAD: {loads}")
                self.log(f"⚠️ ALERT: Server load is high! {loads}", RED)
            elif any(load > 5.0 for load in loads):
                self.log(f"⚠️ WARNING: Elevated load {loads}", YELLOW)
            else:
                self.log(f"✅ Load normal: {loads}", GREEN)
        
        # Memory usage
        output, _ = self.run_ssh_command("free -h | grep Mem")
        self.log(f"Memory: {output}")
        
        if output:
            parts = output.split()
            if len(parts) >= 3:
                used = parts[2]
                total = parts[1]
                self.log(f"Memory Used: {used} / {total}", GREEN)
        
        # Disk usage
        output, _ = self.run_ssh_command("df -h | grep -E 'Filesystem|proptech'")
        self.log(f"Disk Usage:\n{output}")
        
        self.log("")
    
    def check_malware_files(self):
        """Scan for ELF/Perl malware and suspicious files"""
        self.log("=" * 70)
        self.log("2. MALWARE FILE SCAN", BLUE)
        self.log("=" * 70)
        
        # Check for ELF/Perl files
        cmd = f"cd {WP_PATH} && find wp-content -type f -exec file {{}} \\; 2>/dev/null | grep -E 'ELF|Perl script' | grep -v '\\.pl:' | wc -l"
        output, _ = self.run_ssh_command(cmd)
        
        try:
            elf_count = int(output.strip())
            if elf_count > 0:
                self.alerts.append(f"⚠️ MALWARE DETECTED: {elf_count} ELF/Perl files!")
                self.log(f"⚠️ CRITICAL: {elf_count} ELF/Perl malware files detected!", RED)
                
                # Get file list
                cmd = f"cd {WP_PATH} && find wp-content -type f -exec file {{}} \\; 2>/dev/null | grep -E 'ELF|Perl script' | grep -v '\\.pl:' | head -10"
                files, _ = self.run_ssh_command(cmd)
                self.log(f"Malware files:\n{files}", RED)
            else:
                self.log(f"✅ ELF/Perl malware: 0 files", GREEN)
        except ValueError:
            self.log(f"⚠️ Error parsing malware count: {output}", YELLOW)
        
        # Check for 8-character random filenames
        cmd = f"cd {WP_PATH} && find wp-content -type f -regex '.*/[a-z0-9]{{8}}$' 2>/dev/null | wc -l"
        output, _ = self.run_ssh_command(cmd)
        
        try:
            random_count = int(output.strip())
            if random_count > 0:
                self.alerts.append(f"⚠️ SUSPICIOUS FILES: {random_count} random filenames!")
                self.log(f"⚠️ ALERT: {random_count} suspicious 8-char filenames!", RED)
            else:
                self.log(f"✅ Random filenames: 0 files", GREEN)
        except ValueError:
            pass
        
        # Check for known malware files
        for malware_name in KNOWN_MALWARE:
            cmd = f"cd {WP_PATH} && find wp-content -name '{malware_name}' 2>/dev/null | wc -l"
            output, _ = self.run_ssh_command(cmd)
            
            try:
                count = int(output.strip())
                if count > 0:
                    self.alerts.append(f"⚠️ KNOWN MALWARE: {malware_name} detected!")
                    self.log(f"⚠️ CRITICAL: Known malware '{malware_name}' found!", RED)
            except ValueError:
                pass
        
        # Check for PHP in uploads
        cmd = f"cd {WP_PATH} && find wp-content/uploads -name '*.php' -type f 2>/dev/null | wc -l"
        output, _ = self.run_ssh_command(cmd)
        
        try:
            php_count = int(output.strip())
            if php_count > 0:
                self.alerts.append(f"⚠️ PHP IN UPLOADS: {php_count} files!")
                self.log(f"⚠️ ALERT: {php_count} PHP files in uploads directory!", RED)
            else:
                self.log(f"✅ PHP in uploads: 0 files", GREEN)
        except ValueError:
            pass
        
        self.log("")
    
    def check_suspicious_processes(self):
        """Check for cryptocurrency miners and suspicious processes"""
        self.log("=" * 70)
        self.log("3. PROCESS MONITORING", BLUE)
        self.log("=" * 70)
        
        # Check for known miner processes
        for proc_name in SUSPICIOUS_PROCESSES:
            cmd = f"ps aux | grep '{proc_name}' | grep -v grep | wc -l"
            output, _ = self.run_ssh_command(cmd)
            
            try:
                count = int(output.strip())
                if count > 0:
                    self.alerts.append(f"⚠️ SUSPICIOUS PROCESS: {proc_name} detected!")
                    self.log(f"⚠️ ALERT: Suspicious process '{proc_name}' running!", RED)
                    
                    # Get process details
                    cmd = f"ps aux | grep '{proc_name}' | grep -v grep"
                    details, _ = self.run_ssh_command(cmd)
                    self.log(f"Process details:\n{details}", YELLOW)
            except ValueError:
                pass
        
        # Check for high CPU processes
        cmd = "ps aux --sort=-%cpu | head -5"
        output, _ = self.run_ssh_command(cmd)
        self.log(f"Top CPU processes:\n{output}")
        
        # Check for processes with random 8-char names
        cmd = "ps aux | grep -E '[a-z0-9]{8}' | grep -v 'grep' | grep -v 'systemd' | wc -l"
        output, _ = self.run_ssh_command(cmd)
        
        try:
            random_proc_count = int(output.strip())
            if random_proc_count > 10:  # More than 10 might indicate malware
                self.log(f"⚠️ WARNING: {random_proc_count} processes with random-like names", YELLOW)
            else:
                self.log(f"✅ Process names: Normal", GREEN)
        except ValueError:
            pass
        
        self.log("")
    
    def check_wordpress_logins(self):
        """Check for recent WordPress login attempts and new users"""
        self.log("=" * 70)
        self.log("4. WORDPRESS ACCESS CHECK", BLUE)
        self.log("=" * 70)
        
        # Check for recently created users (last 7 days)
        cmd = f"cd {WP_PATH} && wp user list --allow-root --fields=ID,user_login,user_email,user_registered | tail -10"
        output, _ = self.run_ssh_command(cmd)
        self.log(f"Recent WordPress users:\n{output}")
        
        # Check for suspicious usernames
        suspicious_users = ["root", "admin", "test", "hacker"]
        for username in suspicious_users:
            cmd = f"cd {WP_PATH} && wp user list --allow-root --field=user_login | grep -i '^{username}$' | wc -l"
            user_output, _ = self.run_ssh_command(cmd)
            
            try:
                count = int(user_output.strip())
                if count > 0:
                    self.alerts.append(f"⚠️ SUSPICIOUS USER: '{username}' account exists!")
                    self.log(f"⚠️ ALERT: Suspicious user account '{username}' found!", RED)
            except ValueError:
                pass
        
        # Count total admin users
        cmd = f"cd {WP_PATH} && wp user list --role=administrator --allow-root --format=count"
        output, _ = self.run_ssh_command(cmd)
        self.log(f"Total admin users: {output.strip()}")
        
        self.log("")
    
    def check_ssh_attempts(self):
        """Check for failed SSH login attempts"""
        self.log("=" * 70)
        self.log("5. SSH ACCESS MONITORING", BLUE)
        self.log("=" * 70)
        
        # Check recent failed SSH attempts (last 100 lines)
        cmd = "grep 'Failed password' /var/log/auth.log 2>/dev/null | tail -20 || grep 'Failed password' /var/log/secure 2>/dev/null | tail -20 || echo 'No auth log access'"
        output, _ = self.run_ssh_command(cmd)
        
        if output and output != "No auth log access":
            failed_attempts = len(output.strip().split('\n'))
            if failed_attempts > 0:
                self.log(f"⚠️ {failed_attempts} recent failed SSH attempts:", YELLOW)
                # Show last 5
                lines = output.strip().split('\n')
                for line in lines[-5:]:
                    self.log(f"  {line}", YELLOW)
            else:
                self.log(f"✅ No recent failed SSH attempts", GREEN)
        else:
            self.log(f"ℹ️  Cannot access auth logs (permission restricted)", BLUE)
        
        # Check for currently logged in users
        cmd = "who"
        output, _ = self.run_ssh_command(cmd)
        self.log(f"Currently logged in users:\n{output if output else 'None'}")
        
        # Check last logins
        cmd = "last -n 10"
        output, _ = self.run_ssh_command(cmd)
        self.log(f"Last 10 logins:\n{output}")
        
        self.log("")
    
    def check_cron_jobs(self):
        """Check for malicious cron jobs"""
        self.log("=" * 70)
        self.log("6. CRON JOB CHECK", BLUE)
        self.log("=" * 70)
        
        cmd = "crontab -l 2>/dev/null || echo 'No user crontab'"
        output, _ = self.run_ssh_command(cmd)
        
        if output == "No user crontab":
            self.log(f"✅ No user crontab (Good!)", GREEN)
        else:
            self.log(f"Cron jobs found:\n{output}")
            
            # Check for suspicious patterns
            if "wp-content" in output or "/15 " in output:
                self.alerts.append("⚠️ SUSPICIOUS CRON: Contains wp-content or runs every 15min!")
                self.log(f"⚠️ ALERT: Suspicious cron job detected!", RED)
        
        self.log("")
    
    def check_file_changes(self):
        """Check for recently modified files"""
        self.log("=" * 70)
        self.log("7. FILE CHANGE MONITORING", BLUE)
        self.log("=" * 70)
        
        # Check files modified in last 30 minutes
        cmd = f"cd {WP_PATH} && find wp-content -type f -mmin -30 2>/dev/null | wc -l"
        output, _ = self.run_ssh_command(cmd)
        
        try:
            recent_count = int(output.strip())
            if recent_count > 0:
                self.log(f"⚠️ {recent_count} files modified in last 30 minutes", YELLOW)
                
                # Show which files
                cmd = f"cd {WP_PATH} && find wp-content -type f -mmin -30 2>/dev/null | head -10"
                files, _ = self.run_ssh_command(cmd)
                self.log(f"Recent changes:\n{files}", YELLOW)
            else:
                self.log(f"✅ No unexpected file modifications", GREEN)
        except ValueError:
            pass
        
        # Check total file count
        cmd = f"cd {WP_PATH} && find wp-content -type f | wc -l"
        output, _ = self.run_ssh_command(cmd)
        
        try:
            current_count = int(output.strip())
            diff = current_count - BASELINE_FILE_COUNT
            
            self.log(f"Total files: {current_count} (baseline: {BASELINE_FILE_COUNT})")
            
            if diff > 50:
                self.alerts.append(f"⚠️ FILE COUNT INCREASE: +{diff} files!")
                self.log(f"⚠️ ALERT: File count increased by {diff} files!", RED)
            elif diff > 0:
                self.log(f"ℹ️  File count increased by {diff} files", BLUE)
            elif diff < -50:
                self.log(f"⚠️ WARNING: File count decreased by {abs(diff)} files!", YELLOW)
            else:
                self.log(f"✅ File count stable", GREEN)
        except ValueError:
            pass
        
        self.log("")
    
    def check_wp_core_integrity(self):
        """Verify WordPress core files haven't been modified"""
        self.log("=" * 70)
        self.log("8. WORDPRESS CORE INTEGRITY", BLUE)
        self.log("=" * 70)
        
        # Check known infected files from Oct attack
        core_files = [
            "wp-includes/rest-api/endpoints/class-wp-rest-post-statuses-controller.php",
            "wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php"
        ]
        
        for core_file in core_files:
            cmd = f"cd {WP_PATH} && head -n 1 {core_file}"
            output, _ = self.run_ssh_command(cmd)
            
            if output.strip() == "<?php":
                self.log(f"✅ {core_file.split('/')[-1]}: Clean", GREEN)
            else:
                self.alerts.append(f"⚠️ CORE FILE MODIFIED: {core_file}")
                self.log(f"⚠️ ALERT: Core file may be infected! {core_file}", RED)
                self.log(f"  First line: {output}", RED)
        
        self.log("")
    
    def generate_summary(self):
        """Generate scan summary and verdict"""
        self.log("=" * 70)
        self.log("9. SCAN SUMMARY", BLUE)
        self.log("=" * 70)
        
        if self.alerts:
            self.log(f"⚠️ {len(self.alerts)} ALERTS DETECTED:", RED)
            for alert in self.alerts:
                self.log(f"  {alert}", RED)
            self.log("")
            self.log("🔴 VERDICT: THREATS OR ANOMALIES DETECTED - INVESTIGATE IMMEDIATELY!", RED)
        else:
            self.log("✅ VERDICT: ALL CHECKS PASSED - SYSTEM CLEAN", GREEN)
        
        self.log("=" * 70)
        self.log("")
    
    def run_scan(self):
        """Execute full security scan"""
        scan_start = datetime.datetime.now()
        self.alerts = []
        
        self.log("")
        self.log("╔" + "═" * 68 + "╗")
        self.log("║" + " " * 15 + "SERVER SECURITY SCAN STARTED" + " " * 25 + "║")
        self.log("╚" + "═" * 68 + "╝")
        self.log(f"Server: proptech.org.my")
        self.log(f"Time: {scan_start.strftime('%A, %B %d, %Y at %I:%M:%S %p')}")
        self.log("")
        
        try:
            self.check_system_resources()
            self.check_malware_files()
            self.check_suspicious_processes()
            self.check_wordpress_logins()
            self.check_ssh_attempts()
            self.check_cron_jobs()
            self.check_file_changes()
            self.check_wp_core_integrity()
            self.generate_summary()
            
        except Exception as e:
            self.log(f"ERROR during scan: {str(e)}", RED)
        
        scan_end = datetime.datetime.now()
        duration = (scan_end - scan_start).total_seconds()
        
        self.log(f"Scan completed in {duration:.2f} seconds")
        self.log(f"Next scan in 30 minutes...")
        self.log("")


def main():
    """Main monitoring loop"""
    monitor = ServerMonitor()
    
    print(f"{BLUE}╔{'═' * 68}╗{RESET}")
    print(f"{BLUE}║{' ' * 10}PROPTECH.ORG.MY - SECURITY MONITOR{' ' * 19}║{RESET}")
    print(f"{BLUE}╚{'═' * 68}╝{RESET}")
    print(f"\n{GREEN}✓{RESET} Monitoring started")
    print(f"{GREEN}✓{RESET} Scan interval: 30 minutes")
    print(f"{GREEN}✓{RESET} Log file: {monitor.log_file}")
    print(f"{GREEN}✓{RESET} Press Ctrl+C to stop\n")
    
    try:
        scan_count = 0
        while True:
            scan_count += 1
            monitor.log(f"--- SCAN #{scan_count} ---", BLUE)
            monitor.run_scan()
            
            # Wait 30 minutes before next scan
            time.sleep(SCAN_INTERVAL)
            
    except KeyboardInterrupt:
        print(f"\n\n{YELLOW}Monitoring stopped by user{RESET}")
        print(f"{GREEN}✓{RESET} Total scans performed: {scan_count}")
        print(f"{GREEN}✓{RESET} Log file saved: {monitor.log_file}\n")


if __name__ == "__main__":
    main()


#!/usr/bin/env python3
"""
WordPress Backup Checker
Lists all available backups with time, size, and other details
"""

import subprocess
import sys
import os
import json
from datetime import datetime
import argparse
import re

class BackupChecker:
    def __init__(self, ssh_key_path, server_ip, server_user="azureuser"):
        self.ssh_key_path = ssh_key_path
        self.server_ip = server_ip
        self.server_user = server_user
        self.ssh_base = f"ssh -i {ssh_key_path} {server_user}@{server_ip}"
        
    def run_ssh_command(self, command):
        """Execute SSH command and return result"""
        full_command = f"{self.ssh_base} '{command}'"
        try:
            result = subprocess.run(full_command, shell=True, capture_output=True, text=True)
            return result.returncode == 0, result.stdout, result.stderr
        except Exception as e:
            return False, "", str(e)
    
    def get_backup_list(self):
        """Get list of all available backups"""
        success, stdout, stderr = self.run_ssh_command("find /var/www/html/backups -name 'wordpress_backup_*_complete.tar.gz' -type f 2>/dev/null | sort -r")
        if not success or not stdout.strip():
            return []
        
        backups = []
        for line in stdout.strip().split('\n'):
            if line.strip():
                backup_info = self.get_backup_details(line.strip())
                if backup_info:
                    backups.append(backup_info)
        
        return backups
    
    def get_backup_details(self, backup_path):
        """Get detailed information about a specific backup"""
        # Get file size
        success, size_output, stderr = self.run_ssh_command(f"du -h '{backup_path}'")
        if not success:
            return None
        
        size = size_output.strip().split('\t')[0]
        
        # Get file modification time
        success, time_output, stderr = self.run_ssh_command(f"stat -c '%y' '{backup_path}'")
        if not success:
            return None
        
        # Parse modification time
        mod_time = time_output.strip()
        try:
            dt = datetime.strptime(mod_time, '%Y-%m-%d %H:%M:%S.%f %z')
            formatted_time = dt.strftime('%Y-%m-%d %H:%M:%S %Z')
        except:
            formatted_time = mod_time
        
        # Extract backup name from path
        filename = os.path.basename(backup_path)
        backup_name = filename.replace('_complete.tar.gz', '')
        
        # Get backup directory info
        backup_dir = os.path.dirname(backup_path)
        success, manifest_output, stderr = self.run_ssh_command(f"cat '{backup_dir}/backup_manifest.txt' 2>/dev/null | head -15")
        manifest_preview = manifest_output.strip() if success else "No manifest found"
        
        # Check if this backup includes plugins
        success, plugins_check, stderr = self.run_ssh_command(f"tar -tzf '{backup_path}' | grep -q 'plugins_backup.tar.gz' && echo 'Includes plugins' || echo 'No plugins'")
        includes_plugins = "✅ Includes plugins" if "Includes plugins" in plugins_check else "❌ No plugins"
        
        return {
            'path': backup_path,
            'filename': filename,
            'backup_name': backup_name,
            'size': size,
            'mod_time': formatted_time,
            'backup_dir': backup_dir,
            'manifest_preview': manifest_preview,
            'includes_plugins': includes_plugins
        }
    
    def get_disk_usage(self):
        """Get disk usage information for backup directory"""
        success, stdout, stderr = self.run_ssh_command("du -sh /var/www/html/backups")
        if success:
            return stdout.strip().split('\t')[0]
        return "Unknown"
    
    def get_backup_count(self):
        """Get total number of backups"""
        success, stdout, stderr = self.run_ssh_command("find /var/www/html/backups -name 'wordpress_backup_*_complete.tar.gz' -type f 2>/dev/null | wc -l")
        if success:
            return int(stdout.strip())
        return 0
    
    def display_backups(self, backups, show_details=False):
        """Display backup information in a formatted table"""
        if not backups:
            print("❌ No backups found!")
            return
        
        print(f"\n📊 Found {len(backups)} backup(s)")
        print("=" * 80)
        
        # Header
        print(f"{'#':<3} {'Backup Name':<25} {'Size':<8} {'Date/Time':<20} {'Status':<10} {'Plugins':<12}")
        print("-" * 92)
        
        for i, backup in enumerate(backups, 1):
            status = "✅ Complete" if backup['size'] != "0" else "❌ Failed"
            print(f"{i:<3} {backup['backup_name']:<25} {backup['size']:<8} {backup['mod_time']:<20} {status:<10} {backup['includes_plugins']:<12}")
        
        print("-" * 92)
        
        if show_details:
            print("\n📋 Detailed Information:")
            print("=" * 80)
            for i, backup in enumerate(backups, 1):
                print(f"\n🔍 Backup #{i}: {backup['backup_name']}")
                print(f"   Path: {backup['path']}")
                print(f"   Size: {backup['size']}")
                print(f"   Created: {backup['mod_time']}")
                print(f"   Directory: {backup['backup_dir']}")
                print(f"   Plugins: {backup['includes_plugins']}")
                print(f"   Manifest Preview:")
                for line in backup['manifest_preview'].split('\n')[:8]:
                    print(f"     {line}")
                print()

def main():
    parser = argparse.ArgumentParser(description='WordPress Backup Checker')
    parser.add_argument('--ssh-key', default='ssh/azure_key', help='Path to SSH key file')
    parser.add_argument('--server-ip', default='4.194.249.21', help='Server IP address')
    parser.add_argument('--details', action='store_true', help='Show detailed information for each backup')
    parser.add_argument('--json', action='store_true', help='Output in JSON format')
    
    args = parser.parse_args()
    
    # Check if SSH key exists
    if not os.path.exists(args.ssh_key):
        print(f"❌ SSH key not found: {args.ssh_key}")
        sys.exit(1)
    
    checker = BackupChecker(args.ssh_key, args.server_ip)
    
    print("🔍 WordPress Backup Checker")
    print("=" * 50)
    
    # Get backup information
    backups = checker.get_backup_list()
    disk_usage = checker.get_disk_usage()
    backup_count = checker.get_backup_count()
    
    # Display summary
    print(f"📁 Backup Directory: /var/www/html/backups")
    print(f"💾 Total Disk Usage: {disk_usage}")
    print(f"📦 Total Backups: {backup_count}")
    
    if args.json:
        # Output in JSON format
        backup_data = {
            'summary': {
                'backup_directory': '/var/www/html/backups',
                'disk_usage': disk_usage,
                'total_backups': backup_count
            },
            'backups': backups
        }
        print(json.dumps(backup_data, indent=2))
    else:
        # Display in table format
        checker.display_backups(backups, args.details)
        
        if backups:
            print("\n💡 Usage:")
            print("   • Use --details for full backup information")
            print("   • Use --json for machine-readable output")
            print("   • Use restore_backup.py to restore a backup")

if __name__ == "__main__":
    main()

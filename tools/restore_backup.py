#!/usr/bin/env python3
"""
WordPress Backup Restorer
Allows selection and restoration of WordPress backups
"""

import subprocess
import sys
import os
import json
from datetime import datetime
import argparse
import re

class BackupRestorer:
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
        
        # Check if this backup includes plugins
        success, plugins_check, stderr = self.run_ssh_command(f"tar -tzf '{backup_path}' | grep -q 'plugins_backup.tar.gz' && echo 'Includes plugins' || echo 'No plugins'")
        includes_plugins = "✅ Includes plugins" if "Includes plugins" in plugins_check else "❌ No plugins"
        
        return {
            'path': backup_path,
            'filename': filename,
            'backup_name': backup_name,
            'size': size,
            'mod_time': formatted_time,
            'backup_dir': os.path.dirname(backup_path),
            'includes_plugins': includes_plugins
        }
    
    def display_backups(self, backups):
        """Display backup information in a formatted table"""
        if not backups:
            print("❌ No backups found!")
            return False
        
        print(f"\n📊 Available Backups ({len(backups)} found):")
        print("=" * 80)
        
        # Header
        print(f"{'#':<3} {'Backup Name':<25} {'Size':<8} {'Date/Time':<20} {'Status':<10} {'Plugins':<12}")
        print("-" * 92)
        
        for i, backup in enumerate(backups, 1):
            status = "✅ Complete" if backup['size'] != "0" else "❌ Failed"
            print(f"{i:<3} {backup['backup_name']:<25} {backup['size']:<8} {backup['mod_time']:<20} {status:<10} {backup['includes_plugins']:<12}")
        
        print("-" * 92)
        return True
    
    def extract_backup(self, backup_path, temp_dir="/tmp/restore_temp"):
        """Extract backup to temporary directory"""
        print(f"🔄 Extracting backup to {temp_dir}...")
        
        # Create temp directory
        success, stdout, stderr = self.run_ssh_command(f"mkdir -p {temp_dir}")
        if not success:
            print(f"❌ Failed to create temp directory: {stderr}")
            return False
        
        # Extract backup
        success, stdout, stderr = self.run_ssh_command(f"cd {temp_dir} && tar -xzf '{backup_path}'")
        if not success:
            print(f"❌ Failed to extract backup: {stderr}")
            return False
        
        print("✅ Backup extracted successfully")
        return True
    
    def restore_database(self, temp_dir):
        """Restore database from backup"""
        print("🔄 Restoring database...")
        
        database_file = f"{temp_dir}/database_backup.sql"
        success, stdout, stderr = self.run_ssh_command(f"cd /var/www/html && wp db import {database_file} --allow-root")
        if not success:
            print(f"❌ Failed to restore database: {stderr}")
            return False
        
        print("✅ Database restored successfully")
        return True
    
    def restore_theme_options(self, temp_dir):
        """Restore theme options from backup"""
        print("🔄 Restoring theme options...")
        
        # Restore the7 theme options
        the7_file = f"{temp_dir}/theme_options_the7.json"
        success, stdout, stderr = self.run_ssh_command(f"cd /var/www/html && wp option update the7 < {the7_file} --allow-root")
        if not success:
            print(f"⚠️  Failed to restore the7 options: {stderr}")
        else:
            print("✅ The7 theme options restored")
        
        # Restore theme mods
        mods_file = f"{temp_dir}/theme_mods_dt-the7.json"
        success, stdout, stderr = self.run_ssh_command(f"cd /var/www/html && wp option update theme_mods_dt-the7 < {mods_file} --allow-root")
        if not success:
            print(f"⚠️  Failed to restore theme mods: {stderr}")
        else:
            print("✅ Theme modifications restored")
        
        return True
    
    def restore_theme_files(self, temp_dir):
        """Restore theme files from backup"""
        print("🔄 Restoring theme files...")
        
        theme_files = f"{temp_dir}/theme_files_backup.tar.gz"
        success, stdout, stderr = self.run_ssh_command(f"cd /var/www/html && tar -xzf {theme_files}")
        if not success:
            print(f"❌ Failed to restore theme files: {stderr}")
            return False
        
        print("✅ Theme files restored successfully")
        return True
    
    def restore_plugins(self, temp_dir):
        """Restore plugins from backup"""
        print("🔄 Restoring plugins...")
        
        plugins_file = f"{temp_dir}/plugins_backup.tar.gz"
        success, stdout, stderr = self.run_ssh_command(f"cd /var/www/html && tar -xzf {plugins_file}")
        if not success:
            print(f"❌ Failed to restore plugins: {stderr}")
            return False
        
        print("✅ Plugins restored successfully")
        return True
    
    def clear_cache(self):
        """Clear WordPress cache"""
        print("🔄 Clearing cache...")
        
        success, stdout, stderr = self.run_ssh_command("cd /var/www/html && wp cache flush --allow-root")
        if not success:
            print(f"⚠️  Failed to clear cache: {stderr}")
        else:
            print("✅ Cache cleared successfully")
        
        return True
    
    def cleanup_temp(self, temp_dir="/tmp/restore_temp"):
        """Clean up temporary files"""
        print("🧹 Cleaning up temporary files...")
        
        success, stdout, stderr = self.run_ssh_command(f"rm -rf {temp_dir}")
        if not success:
            print(f"⚠️  Failed to clean up temp files: {stderr}")
        else:
            print("✅ Temporary files cleaned up")
        
        return True
    
    def restore_backup(self, backup_path):
        """Complete backup restoration process"""
        temp_dir = "/tmp/restore_temp"
        
        print(f"🚀 Starting restoration of: {os.path.basename(backup_path)}")
        print("=" * 60)
        
        # Step 1: Extract backup
        if not self.extract_backup(backup_path, temp_dir):
            return False
        
        # Step 2: Restore database
        if not self.restore_database(temp_dir):
            self.cleanup_temp(temp_dir)
            return False
        
        # Step 3: Restore theme options
        if not self.restore_theme_options(temp_dir):
            print("⚠️  Theme options restoration had issues, but continuing...")
        
        # Step 4: Restore theme files
        if not self.restore_theme_files(temp_dir):
            print("⚠️  Theme files restoration had issues, but continuing...")
        
        # Step 5: Restore plugins
        if not self.restore_plugins(temp_dir):
            print("⚠️  Plugins restoration had issues, but continuing...")
        
        # Step 6: Clear cache
        self.clear_cache()
        
        # Step 6: Cleanup
        self.cleanup_temp(temp_dir)
        
        print("\n✅ Backup restoration completed!")
        print("💡 Please check your website to ensure everything is working correctly.")
        
        return True

def main():
    parser = argparse.ArgumentParser(description='WordPress Backup Restorer')
    parser.add_argument('--ssh-key', default='ssh/azure_key', help='Path to SSH key file')
    parser.add_argument('--server-ip', default='4.194.249.21', help='Server IP address')
    parser.add_argument('--backup-number', type=int, help='Backup number to restore (from check_backup.py list)')
    parser.add_argument('--backup-path', help='Direct path to backup file')
    parser.add_argument('--list-only', action='store_true', help='Only list available backups')
    parser.add_argument('--force', action='store_true', help='Skip confirmation prompts')
    
    args = parser.parse_args()
    
    # Check if SSH key exists
    if not os.path.exists(args.ssh_key):
        print(f"❌ SSH key not found: {args.ssh_key}")
        sys.exit(1)
    
    restorer = BackupRestorer(args.ssh_key, args.server_ip)
    
    print("🔄 WordPress Backup Restorer")
    print("=" * 50)
    
    # Get available backups
    backups = restorer.get_backup_list()
    
    if args.list_only:
        restorer.display_backups(backups)
        return
    
    if not backups:
        print("❌ No backups found!")
        sys.exit(1)
    
    # Display available backups
    if not restorer.display_backups(backups):
        sys.exit(1)
    
    # Determine which backup to restore
    backup_to_restore = None
    
    if args.backup_path:
        # Use direct path
        backup_to_restore = args.backup_path
        print(f"🎯 Using specified backup: {backup_to_restore}")
    elif args.backup_number:
        # Use backup number
        if 1 <= args.backup_number <= len(backups):
            backup_to_restore = backups[args.backup_number - 1]['path']
            print(f"🎯 Using backup #{args.backup_number}: {backup_to_restore}")
        else:
            print(f"❌ Invalid backup number: {args.backup_number}")
            sys.exit(1)
    else:
        # Interactive selection
        print(f"\n🔢 Enter backup number to restore (1-{len(backups)}): ", end="")
        try:
            choice = int(input().strip())
            if 1 <= choice <= len(backups):
                backup_to_restore = backups[choice - 1]['path']
                print(f"🎯 Selected backup: {backup_to_restore}")
            else:
                print("❌ Invalid choice!")
                sys.exit(1)
        except (ValueError, KeyboardInterrupt):
            print("\n❌ Invalid input or cancelled!")
            sys.exit(1)
    
    # Confirmation
    if not args.force:
        print(f"\n⚠️  WARNING: This will overwrite your current WordPress installation!")
        print(f"📦 Backup to restore: {os.path.basename(backup_to_restore)}")
        print(f"📅 Created: {next((b['mod_time'] for b in backups if b['path'] == backup_to_restore), 'Unknown')}")
        
        confirm = input("🤔 Are you sure you want to continue? (yes/no): ").strip().lower()
        if confirm not in ['yes', 'y']:
            print("❌ Restoration cancelled!")
            sys.exit(0)
    
    # Perform restoration
    success = restorer.restore_backup(backup_to_restore)
    
    if success:
        print("\n🎉 Restoration completed successfully!")
        print("🌐 Please check your website at: http://4.194.249.21")
    else:
        print("\n❌ Restoration failed!")
        sys.exit(1)

if __name__ == "__main__":
    main()

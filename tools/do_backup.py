#!/usr/bin/env python3
"""
WordPress Backup Tool - Git Commit and Backup Creator
Creates a git commit and then creates a comprehensive WordPress backup
"""

import subprocess
import sys
import os
import json
from datetime import datetime
import argparse

class WordPressBackup:
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
    
    def git_commit(self, commit_message=None):
        """Perform git commit with optional message"""
        if not commit_message:
            commit_message = f"Auto backup commit - {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}"
        
        print(f"🔄 Creating git commit: {commit_message}")
        
        # Add all changes
        success, stdout, stderr = self.run_ssh_command("cd /var/www/html && git add .")
        if not success:
            print(f"❌ Failed to add files to git: {stderr}")
            return False
        
        # Commit changes - use a different approach to avoid shell interpretation issues
        commit_cmd = f"cd /var/www/html && echo '{commit_message}' | git commit -F -"
        success, stdout, stderr = self.run_ssh_command(commit_cmd)
        if not success:
            print(f"❌ Failed to commit: {stderr}")
            return False
        
        print("✅ Git commit successful")
        return True
    
    def git_push(self):
        """Push changes to remote repository"""
        print("🔄 Pushing to remote repository...")
        
        success, stdout, stderr = self.run_ssh_command("cd /var/www/html && git push origin main")
        if not success:
            print(f"❌ Failed to push: {stderr}")
            return False
        
        print("✅ Git push successful")
        return True
    
    def create_backup(self):
        """Create comprehensive WordPress backup"""
        print("🔄 Creating WordPress backup...")
        
        success, stdout, stderr = self.run_ssh_command("cd /var/www/html && sudo bash backup_scripts/create_backup.sh")
        if not success:
            print(f"❌ Failed to create backup: {stderr}")
            return False
        
        # Extract backup filename from output
        for line in stdout.split('\n'):
            if 'Backup location:' in line:
                backup_path = line.split(': ')[1].strip()
                print(f"✅ Backup created: {backup_path}")
                return backup_path
        
        print("✅ Backup created successfully")
        return True
    
    def get_backup_info(self):
        """Get information about the latest backup"""
        success, stdout, stderr = self.run_ssh_command("ls -t /var/www/html/backups/*/wordpress_backup_*_complete.tar.gz 2>/dev/null | head -1")
        if not success or not stdout.strip():
            return None
        
        latest_backup = stdout.strip()
        success, size_output, stderr = self.run_ssh_command(f"du -h {latest_backup}")
        if success:
            size = size_output.strip().split('\t')[0]
            
            # Check if backup includes plugins
            success, plugins_check, stderr = self.run_ssh_command(f"tar -tzf '{latest_backup}' | grep -q 'plugins_backup.tar.gz' && echo 'Includes plugins' || echo 'No plugins'")
            includes_plugins = "✅ Includes plugins" if "Includes plugins" in plugins_check else "❌ No plugins"
            
            return {
                'path': latest_backup,
                'size': size,
                'filename': os.path.basename(latest_backup),
                'includes_plugins': includes_plugins
            }
        return None

def main():
    parser = argparse.ArgumentParser(description='WordPress Git Commit and Backup Tool')
    parser.add_argument('--ssh-key', default='ssh/azure_key', help='Path to SSH key file')
    parser.add_argument('--server-ip', default='4.194.249.21', help='Server IP address')
    parser.add_argument('--commit-message', help='Custom commit message')
    parser.add_argument('--skip-git', action='store_true', help='Skip git operations, only create backup')
    parser.add_argument('--skip-push', action='store_true', help='Skip git push after commit')
    
    args = parser.parse_args()
    
    # Check if SSH key exists
    if not os.path.exists(args.ssh_key):
        print(f"❌ SSH key not found: {args.ssh_key}")
        sys.exit(1)
    
    backup_tool = WordPressBackup(args.ssh_key, args.server_ip)
    
    print("🚀 Starting WordPress Git Commit and Backup Process")
    print("=" * 50)
    
    # Step 1: Git commit (if not skipped)
    if not args.skip_git:
        if not backup_tool.git_commit(args.commit_message):
            print("❌ Git commit failed. Stopping process.")
            sys.exit(1)
        
        # Step 2: Git push (if not skipped)
        if not args.skip_push:
            if not backup_tool.git_push():
                print("⚠️  Git push failed, but continuing with backup...")
    
    # Step 3: Create backup
    backup_path = backup_tool.create_backup()
    if not backup_path:
        print("❌ Backup creation failed.")
        sys.exit(1)
    
    # Step 4: Get backup info
    backup_info = backup_tool.get_backup_info()
    if backup_info:
        print("\n📊 Backup Summary:")
        print(f"   File: {backup_info['filename']}")
        print(f"   Size: {backup_info['size']}")
        print(f"   Plugins: {backup_info['includes_plugins']}")
        print(f"   Path: {backup_info['path']}")
    
    print("\n✅ Process completed successfully!")
    print("💡 Next steps:")
    print("   1. Download the backup file to your local machine")
    print("   2. Store it in a secure location")
    print("   3. Test restoration on a staging environment")

if __name__ == "__main__":
    main()

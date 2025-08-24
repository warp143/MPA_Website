#!/usr/bin/env python3
"""
Deploy mark10 files to Azure server
Copies the local mark10 directory to the Azure server
"""

import os
import sys
import subprocess
import json
import argparse
from pathlib import Path

def load_azure_config(config_file="ssh/azure2.json"):
    """Load Azure server configuration"""
    try:
        with open(config_file, 'r') as f:
            return json.load(f)
    except FileNotFoundError:
        print(f"❌ Config file {config_file} not found")
        sys.exit(1)
    except json.JSONDecodeError:
        print(f"❌ Invalid JSON in {config_file}")
        sys.exit(1)

def run_command(command, description):
    """Run a shell command and handle errors"""
    print(f"🔄 {description}...")
    try:
        result = subprocess.run(command, shell=True, check=True, capture_output=True, text=True)
        print(f"✅ {description} successful")
        return result.stdout
    except subprocess.CalledProcessError as e:
        print(f"❌ {description} failed:")
        print(f"   Command: {command}")
        print(f"   Error: {e.stderr}")
        return None

def deploy_mark10(server_ip, username, key_path, target_path="/var/www/html/mark10"):
    """Deploy mark10 files to Azure server"""
    
    # Verify local mark10 directory exists
    local_path = "mark10"
    if not os.path.exists(local_path):
        print(f"❌ Local directory {local_path} not found")
        return False
    
    # Verify SSH key exists
    if not os.path.exists(key_path):
        print(f"❌ SSH key {key_path} not found")
        return False
    
    # Set SSH key permissions
    run_command(f"chmod 600 {key_path}", "Setting SSH key permissions")
    
    print(f"🚀 Starting deployment of mark10 to Azure server")
    print(f"📍 Server: {server_ip}")
    print(f"👤 User: {username}")
    print(f"📁 Target: {target_path}")
    print("=" * 50)
    
    # Create target directory on server
    ssh_cmd = f"ssh -i {key_path} -o StrictHostKeyChecking=no {username}@{server_ip}"
    create_dir_cmd = f"{ssh_cmd} 'mkdir -p {target_path}'"
    
    if not run_command(create_dir_cmd, "Creating target directory on server"):
        return False
    
    # Copy files using rsync
    rsync_cmd = f"rsync -avz --delete -e 'ssh -i {key_path} -o StrictHostKeyChecking=no' {local_path}/ {username}@{server_ip}:{target_path}/"
    
    if not run_command(rsync_cmd, "Copying files to server"):
        return False
    
    # Set proper permissions on server
    chmod_cmd = f"{ssh_cmd} 'chmod -R 644 {target_path}/* && chmod 755 {target_path}'"
    run_command(chmod_cmd, "Setting file permissions")
    
    # Verify deployment
    verify_cmd = f"{ssh_cmd} 'ls -la {target_path}/'"
    output = run_command(verify_cmd, "Verifying deployment")
    
    if output:
        print("\n📊 Deployment Summary:")
        print(f"   ✅ Files deployed to: {target_path}")
        print(f"   ✅ Server: {server_ip}")
        print(f"   ✅ Fixed hamburger menu included")
        print("\n📁 Deployed files:")
        for line in output.strip().split('\n'):
            if not line.startswith('total'):
                print(f"   {line}")
    
    return True

def main():
    parser = argparse.ArgumentParser(description="Deploy mark10 files to Azure server")
    parser.add_argument("--config", default="ssh/azure2.json", help="Azure config file")
    parser.add_argument("--target", default="/var/www/html/mark10", help="Target directory on server")
    parser.add_argument("--dry-run", action="store_true", help="Show what would be deployed without actually deploying")
    
    args = parser.parse_args()
    
    # Load configuration
    config = load_azure_config(args.config)
    server_config = config.get("server", {})
    
    server_ip = server_config.get("ip")
    username = server_config.get("username")
    key_path = server_config.get("key_path")
    
    if not all([server_ip, username, key_path]):
        print("❌ Missing required server configuration (ip, username, key_path)")
        sys.exit(1)
    
    if args.dry_run:
        print("🔍 DRY RUN - Would deploy:")
        print(f"   Local: mark10/")
        print(f"   Remote: {username}@{server_ip}:{args.target}")
        print(f"   SSH Key: {key_path}")
        return
    
    # Deploy files
    success = deploy_mark10(server_ip, username, key_path, args.target)
    
    if success:
        print("\n🎉 Deployment completed successfully!")
        print(f"🌐 Your fixed hamburger menu is now live at: http://{server_ip}/mark10/")
    else:
        print("\n❌ Deployment failed!")
        sys.exit(1)

if __name__ == "__main__":
    main()



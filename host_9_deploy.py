#!/usr/bin/env python3
"""
Simple rsync deployment for mark9 to Azure
"""

import os
import sys
import subprocess
import json

def load_azure_config(config_file="ssh/azure2.json"):
    """Load Azure server configuration"""
    try:
        with open(config_file, 'r') as f:
            return json.load(f)
    except FileNotFoundError:
        print(f"❌ Config file {config_file} not found")
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

def deploy_mark9():
    """Deploy mark9 using rsync"""
    
    # Load config
    config = load_azure_config()
    server_ip = config["server"]["ip"]
    username = config["server"]["username"]
    key_path = config["server"]["key_path"]
    
    print(f"🚀 Deploying mark9 to Azure server")
    print(f"📍 Server: {server_ip}")
    print(f"👤 User: {username}")
    print(f"📁 Source: mark9/")
    print(f"📁 Target: /var/www/html/mark9/")
    print("=" * 50)
    
    # Verify local mark9 directory exists
    if not os.path.exists("mark9"):
        print("❌ Local mark9 directory not found")
        return False
    
    # Set SSH key permissions
    run_command(f"chmod 600 {key_path}", "Setting SSH key permissions")
    
    # Remove existing directory and create fresh
    ssh_cmd = f"ssh -i {key_path} -o StrictHostKeyChecking=no {username}@{server_ip}"
    remove_cmd = f"{ssh_cmd} 'sudo rm -rf /var/www/html/mark9'"
    run_command(remove_cmd, "Removing old directory")
    
    mkdir_cmd = f"{ssh_cmd} 'sudo mkdir -p /var/www/html/mark9 && sudo chown azureuser:azureuser /var/www/html/mark9'"
    run_command(mkdir_cmd, "Creating target directory")
    
    # Copy files using rsync
    rsync_cmd = f"rsync -avz --delete -e 'ssh -i {key_path} -o StrictHostKeyChecking=no' mark9/ {username}@{server_ip}:/var/www/html/mark9/"
    if not run_command(rsync_cmd, "Copying files to server"):
        return False
    
    # Set proper permissions
    chmod_cmd = f"{ssh_cmd} 'sudo chown -R www-data:www-data /var/www/html/mark9/ && sudo chmod -R 644 /var/www/html/mark9/* && sudo chmod 755 /var/www/html/mark9/ && sudo chmod 755 /var/www/html/mark9/assets/'"
    run_command(chmod_cmd, "Setting file permissions")
    
    # Verify deployment
    verify_cmd = f"{ssh_cmd} 'ls -la /var/www/html/mark9/'"
    output = run_command(verify_cmd, "Verifying deployment")
    
    if output:
        print("\n📊 Deployment Summary:")
        print(f"   ✅ Files deployed to: /var/www/html/mark9/")
        print(f"   ✅ Server: {server_ip}")
        print(f"   ✅ All files copied with rsync")
        print(f"\n🌐 Your mark9 website is now live at: http://{server_ip}/mark9/")
        print(f"📧 Contact page: http://{server_ip}/mark9/contact.html")
        return True
    
    return False

def main():
    print("🚀 Mark9 Azure Deployment Script (rsync)")
    print("=" * 40)
    
    # Check if mark9 directory exists
    if not os.path.exists("mark9"):
        print("❌ Error: mark9/ directory not found in current location")
        print("   Please run this script from the Website directory")
        sys.exit(1)
    
    # Show deployment info
    print(f"📁 Source directory: {os.path.abspath('mark9')}")
    print("🚀 Starting deployment...")
    
    # Deploy files
    success = deploy_mark9()
    
    if success:
        print("\n🎉 Deployment completed successfully!")
        print("🔄 Apache will serve the updated files immediately")
    else:
        print("\n❌ Deployment failed!")
        sys.exit(1)

if __name__ == "__main__":
    main()

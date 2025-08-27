#!/usr/bin/env python3
"""
Deploy main portfolio index.html to Azure
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

def deploy_portfolio():
    """Deploy main portfolio index.html to Azure"""
    
    # Load config
    config = load_azure_config()
    server_ip = config["server"]["ip"]
    username = config["server"]["username"]
    key_path = config["server"]["key_path"]
    
    print(f"🚀 Deploying Portfolio to Azure server")
    print(f"📍 Server: {server_ip}")
    print(f"👤 User: {username}")
    print(f"📁 Source: index.html + mark directories")
    print(f"📁 Target: /var/www/html/")
    print("=" * 50)
    
    # Verify local index.html exists
    if not os.path.exists("index.html"):
        print("❌ Local index.html not found")
        return False
    
    # Set SSH key permissions
    run_command(f"chmod 600 {key_path}", "Setting SSH key permissions")
    
    # Create backup of current deployment
    ssh_cmd = f"ssh -i {key_path} -o StrictHostKeyChecking=no {username}@{server_ip}"
    backup_cmd = f"{ssh_cmd} 'sudo cp -r /var/www/html /var/www/html_backup_$(date +%Y%m%d_%H%M%S)'"
    run_command(backup_cmd, "Creating backup of current deployment")
    
    # Copy main index.html
    scp_index_cmd = f"scp -i {key_path} -o StrictHostKeyChecking=no index.html {username}@{server_ip}:/tmp/"
    if not run_command(scp_index_cmd, "Copying index.html to server"):
        return False
    
    # Move index.html to web root
    move_cmd = f"{ssh_cmd} 'sudo mv /tmp/index.html /var/www/html/ && sudo chown www-data:www-data /var/www/html/index.html && sudo chmod 644 /var/www/html/index.html'"
    run_command(move_cmd, "Moving index.html to web root")
    
    # Copy mark directories
    mark_dirs = ["mark1-mpa", "mark2-liquid", "mark7", "mark9"]
    for mark_dir in mark_dirs:
        if os.path.exists(mark_dir):
            print(f"📁 Copying {mark_dir}...")
            
            # Remove existing directory
            remove_cmd = f"{ssh_cmd} 'sudo rm -rf /var/www/html/{mark_dir}'"
            run_command(remove_cmd, f"Removing old {mark_dir}")
            
            # Create directory
            mkdir_cmd = f"{ssh_cmd} 'sudo mkdir -p /var/www/html/{mark_dir} && sudo chown azureuser:azureuser /var/www/html/{mark_dir}'"
            run_command(mkdir_cmd, f"Creating {mark_dir} directory")
            
            # Copy files using rsync
            rsync_cmd = f"rsync -avz --delete -e 'ssh -i {key_path} -o StrictHostKeyChecking=no' {mark_dir}/ {username}@{server_ip}:/var/www/html/{mark_dir}/"
            run_command(rsync_cmd, f"Copying {mark_dir} files")
            
            # Set permissions
            chmod_cmd = f"{ssh_cmd} 'sudo chown -R www-data:www-data /var/www/html/{mark_dir}/ && sudo chmod -R 644 /var/www/html/{mark_dir}/* && sudo chmod 755 /var/www/html/{mark_dir}/ && sudo find /var/www/html/{mark_dir}/ -type d -exec chmod 755 {{}} \\;'"
            run_command(chmod_cmd, f"Setting {mark_dir} permissions")
    
    # Verify deployment
    verify_cmd = f"{ssh_cmd} 'ls -la /var/www/html/'"
    output = run_command(verify_cmd, "Verifying deployment")
    
    if output:
        print("\n📊 Deployment Summary:")
        print(f"   ✅ Portfolio deployed to: /var/www/html/")
        print(f"   ✅ Server: {server_ip}")
        print(f"   ✅ All mark directories copied")
        print(f"\n🌐 Your portfolio is now live at: http://{server_ip}/")
        print(f"📁 Mark directories available at:")
        for mark_dir in mark_dirs:
            print(f"   - http://{server_ip}/{mark_dir}/")
        return True
    
    return False

def main():
    print("🚀 Portfolio Azure Deployment Script")
    print("=" * 40)
    
    # Check if index.html exists
    if not os.path.exists("index.html"):
        print("❌ Error: index.html not found in current location")
        print("   Please run this script from the Website directory")
        sys.exit(1)
    
    # Show deployment info
    print(f"📄 Main file: {os.path.abspath('index.html')}")
    
    # Deploy
    if deploy_portfolio():
        print("\n🎉 Deployment completed successfully!")
    else:
        print("\n❌ Deployment failed!")
        sys.exit(1)

if __name__ == "__main__":
    main()



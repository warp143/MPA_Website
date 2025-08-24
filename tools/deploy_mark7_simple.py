#!/usr/bin/env python3
"""
Simple deployment script for mark7 to Azure using scp
"""

import os
import sys
import subprocess
import json
import tarfile
import tempfile

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

def deploy_mark7():
    """Deploy mark7 to Azure using scp"""
    
    # Load config
    with open("ssh/azure2.json", 'r') as f:
        config = json.load(f)
    
    server_ip = config["server"]["ip"]
    username = config["server"]["username"]
    key_path = config["server"]["key_path"]
    
    print(f"🚀 Deploying mark7 to Azure server")
    print(f"📍 Server: {server_ip}")
    print(f"👤 User: {username}")
    print("=" * 50)
    
    # Set SSH key permissions
    run_command(f"chmod 600 {key_path}", "Setting SSH key permissions")
    
    # Create a temporary tar file
    print("🔄 Creating archive...")
    tar_filename = "mark7_deploy.tar.gz"
    
    # Create tar file
    with tarfile.open(tar_filename, "w:gz") as tar:
        tar.add("mark7", arcname="mark7")
    
    print(f"✅ Archive created: {tar_filename}")
    
    # Upload to server
    scp_cmd = f"scp -i {key_path} -o StrictHostKeyChecking=no {tar_filename} {username}@{server_ip}:/tmp/"
    if not run_command(scp_cmd, "Uploading archive to server"):
        return False
    
    # Extract on server
    ssh_cmd = f"ssh -i {key_path} -o StrictHostKeyChecking=no {username}@{server_ip}"
    extract_cmd = f"{ssh_cmd} 'cd /tmp && tar -xzf {tar_filename} -C /var/www/html/ && rm {tar_filename}'"
    if not run_command(extract_cmd, "Extracting files on server"):
        return False
    
    # Set permissions
    chmod_cmd = f"{ssh_cmd} 'chmod -R 644 /var/www/html/mark7/* && chmod 755 /var/www/html/mark7'"
    run_command(chmod_cmd, "Setting file permissions")
    
    # Verify deployment
    verify_cmd = f"{ssh_cmd} 'ls -la /var/www/html/mark7/'"
    output = run_command(verify_cmd, "Verifying deployment")
    
    # Clean up local tar file
    os.remove(tar_filename)
    print(f"✅ Cleaned up local archive")
    
    if output:
        print("\n📊 Deployment Summary:")
        print(f"   ✅ Files deployed to: /var/www/html/mark7/")
        print(f"   ✅ Server: {server_ip}")
        print(f"   ✅ Contact page with fixed layout included")
        print(f"\n🌐 Your mark7 website is now live at: http://{server_ip}/mark7/")
        print(f"📧 Contact page: http://{server_ip}/mark7/contact.html")
        return True
    
    return False

if __name__ == "__main__":
    success = deploy_mark7()
    if not success:
        print("\n❌ Deployment failed!")
        sys.exit(1)
    else:
        print("\n🎉 Deployment completed successfully!")

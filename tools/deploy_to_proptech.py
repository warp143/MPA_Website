#!/usr/bin/env python3
"""
Deploy WordPress files to proptech.org.my server
"""

import os
import sys
import subprocess
import json
from pathlib import Path

def load_config():
    """Load proptech server configuration"""
    config_file = Path(__file__).parent.parent / "ssh/proptech.json"
    try:
        with open(config_file, 'r') as f:
            return json.load(f)
    except FileNotFoundError:
        print(f"❌ Config file not found: {config_file}")
        sys.exit(1)

def run_command(command, description):
    """Run a shell command and handle errors"""
    print(f"🔄 {description}...")
    try:
        result = subprocess.run(
            command, 
            shell=True, 
            check=True, 
            capture_output=True, 
            text=True,
            timeout=60
        )
        print(f"✅ {description} successful")
        return True
    except subprocess.TimeoutExpired:
        print(f"⏱️  {description} timed out")
        return False
    except subprocess.CalledProcessError as e:
        print(f"❌ {description} failed:")
        print(f"   Error: {e.stderr}")
        return False
    except Exception as e:
        print(f"❌ {description} failed: {str(e)}")
        return False

def deploy_theme_file(config, local_file, remote_path):
    """Deploy a specific theme file to the server"""
    hostname = config["server"]["hostname"]
    username = config["server"]["username"]
    key_path = Path(__file__).parent.parent / config["server"]["key_path"]
    
    # Ensure key has correct permissions
    os.chmod(key_path, 0o600)
    
    # Create backup of the file on server
    ssh_cmd = f"ssh -i {key_path} -o StrictHostKeyChecking=no -o ConnectTimeout=10 {username}@{hostname}"
    backup_cmd = f"{ssh_cmd} 'cp {remote_path} {remote_path}.backup.$(date +%Y%m%d_%H%M%S) 2>/dev/null || true'"
    
    if not run_command(backup_cmd, "Creating backup of remote file"):
        print("⚠️  Backup failed, but continuing...")
    
    # Upload the file using scp
    scp_cmd = f"scp -i {key_path} -o StrictHostKeyChecking=no -o ConnectTimeout=10 {local_file} {username}@{hostname}:{remote_path}"
    
    return run_command(scp_cmd, f"Uploading {Path(local_file).name}")

def main():
    print("🚀 PropTech.org.my Deployment Script")
    print("=" * 50)
    
    # Load configuration
    config = load_config()
    
    # Define the file to deploy
    project_root = Path(__file__).parent.parent
    local_file = project_root / "mark9_wp/wp-content/themes/mpa-custom/front-page.php"
    remote_path = "~/public_html/proptech.org.my/wp-content/themes/mpa-custom/front-page.php"
    
    if not local_file.exists():
        print(f"❌ Local file not found: {local_file}")
        sys.exit(1)
    
    print(f"📁 Local file: {local_file}")
    print(f"📍 Server: {config['server']['hostname']}")
    print(f"🎯 Remote path: {remote_path}")
    print("=" * 50)
    
    # Deploy the file
    if deploy_theme_file(config, local_file, remote_path):
        print("\n🎉 Deployment successful!")
        print(f"🌐 Check your website at: {config['wordpress']['site_url']}")
        print("🔄 The fix should be live immediately")
        return 0
    else:
        print("\n❌ Deployment failed!")
        return 1

if __name__ == "__main__":
    sys.exit(main())


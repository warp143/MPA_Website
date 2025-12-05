#!/usr/bin/env python3
"""
Setup Backdoor Sentry cron job on the server
"""

import os
import sys
import json
import subprocess
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

def run_ssh_command(config, command, description):
    """Run a command on the remote server via SSH"""
    hostname = config["server"]["hostname"]
    username = config["server"]["username"]
    key_path = Path(__file__).parent.parent / config["server"]["key_path"]
    
    # Ensure key has correct permissions
    os.chmod(key_path, 0o600)
    
    ssh_cmd = f"ssh -i {key_path} -o StrictHostKeyChecking=no -o ConnectTimeout=10 {username}@{hostname} '{command}'"
    
    try:
        result = subprocess.run(
            ssh_cmd,
            shell=True,
            check=True,
            capture_output=True,
            text=True,
            timeout=30
        )
        if description:
            print(f"✅ {description}")
        return result.stdout.strip()
    except subprocess.TimeoutExpired:
        print(f"⏱️  {description} timed out")
        return None
    except subprocess.CalledProcessError as e:
        if description:
            print(f"❌ {description} failed: {e.stderr}")
        return None
    except Exception as e:
        if description:
            print(f"❌ {description} failed: {str(e)}")
        return None

def check_cron_exists(config):
    """Check if backdoor sentry cron job already exists"""
    cron_check = "crontab -l 2>/dev/null | grep -q 'backdoor_sentry' && echo 'EXISTS' || echo 'NOT_FOUND'"
    result = run_ssh_command(config, cron_check, None)
    return result == "EXISTS"

def get_cron_entry(config):
    """Generate the cron entry for backdoor sentry"""
    # Get the path to backdoor_sentry.py on the server
    # Assuming it's in ~/tools/backdoor_sentry.py or similar
    wp_root = "~/public_html/proptech.org.my"
    script_path = "~/tools/backdoor_sentry.py"
    log_file = "~/backdoor_sentry.log"
    
    # Cron: every 5 minutes
    cron_entry = f"*/5 * * * * /usr/bin/python3 {script_path} --wp-root {wp_root} --neutralize --log-file {log_file} >> /dev/null 2>&1"
    return cron_entry

def setup_cron(config):
    """Set up the cron job on the server"""
    print("🔍 Checking if cron job already exists...")
    
    if check_cron_exists(config):
        print("⚠️  Cron job already exists!")
        print("\nCurrent cron entries:")
        run_ssh_command(config, "crontab -l | grep backdoor_sentry", "Listing existing cron")
        
        response = input("\n❓ Do you want to replace it? (y/N): ").strip().lower()
        if response != 'y':
            print("❌ Aborted. Keeping existing cron job.")
            return False
        
        # Remove existing entry
        print("🗑️  Removing existing cron entry...")
        run_ssh_command(config, "crontab -l | grep -v 'backdoor_sentry' | crontab -", "Removing old entry")
    
    # Get current crontab
    print("📥 Getting current crontab...")
    current_cron = run_ssh_command(config, "crontab -l 2>/dev/null || echo ''", None)
    
    # Add new entry
    cron_entry = get_cron_entry(config)
    new_cron = current_cron + "\n" + cron_entry + "\n" if current_cron else cron_entry + "\n"
    
    # Write new crontab
    print("📤 Setting up new cron job...")
    temp_file = "/tmp/crontab_backdoor_sentry"
    
    # Write to temp file locally, then upload
    import tempfile
    with tempfile.NamedTemporaryFile(mode='w', delete=False) as f:
        f.write(new_cron)
        temp_local = f.name
    
    # Upload to server
    key_path = Path(__file__).parent.parent / config["server"]["key_path"]
    hostname = config["server"]["hostname"]
    username = config["server"]["username"]
    
    scp_cmd = f"scp -i {key_path} -o StrictHostKeyChecking=no {temp_local} {username}@{hostname}:{temp_file}"
    subprocess.run(scp_cmd, shell=True, check=True, capture_output=True)
    
    # Install crontab from file
    result = run_ssh_command(config, f"crontab {temp_file} && rm {temp_file}", "Installing cron job")
    
    # Clean up local temp file
    os.unlink(temp_local)
    
    if result is not None:
        print("✅ Cron job installed successfully!")
        print(f"\n📋 Cron entry:")
        print(f"   {cron_entry}")
        return True
    else:
        print("❌ Failed to install cron job")
        return False

def verify_setup(config):
    """Verify the cron job is set up correctly"""
    print("\n🔍 Verifying setup...")
    
    # Check cron exists
    if not check_cron_exists(config):
        print("❌ Cron job not found!")
        return False
    
    # Show cron entry
    print("✅ Cron job found!")
    print("\n📋 Current cron entry:")
    run_ssh_command(config, "crontab -l | grep backdoor_sentry", None)
    
    # Check if script exists on server
    script_path = "~/tools/backdoor_sentry.py"
    print(f"\n🔍 Checking if script exists: {script_path}")
    script_check = run_ssh_command(config, f"test -f {script_path} && echo 'EXISTS' || echo 'NOT_FOUND'", None)
    
    if script_check == "EXISTS":
        print("✅ Script file exists")
    else:
        print("⚠️  Script file not found! You may need to upload it first.")
        print(f"   Upload command: scp -i ssh/proptech_mpa_new tools/backdoor_sentry.py {config['server']['username']}@{config['server']['hostname']}:{script_path}")
    
    # Check log file
    log_file = "~/backdoor_sentry.log"
    print(f"\n🔍 Checking log file: {log_file}")
    log_check = run_ssh_command(config, f"test -f {log_file} && tail -3 {log_file} || echo 'No log file yet'", None)
    if log_check and "No log file yet" not in log_check:
        print("✅ Log file exists with recent entries")
    else:
        print("ℹ️  Log file will be created on first run")
    
    return True

def main():
    print("🛡️  Backdoor Sentry Cron Setup")
    print("=" * 50)
    
    config = load_config()
    print(f"📍 Server: {config['server']['hostname']}")
    print(f"👤 User: {config['server']['username']}")
    print("=" * 50)
    
    if setup_cron(config):
        verify_setup(config)
        print("\n🎉 Setup complete!")
        print("\n📝 The scanner will run every 5 minutes.")
        print("   Check logs with: ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com 'tail -f ~/backdoor_sentry.log'")
        return 0
    else:
        print("\n❌ Setup failed!")
        return 1

if __name__ == "__main__":
    sys.exit(main())


#!/usr/bin/env python3
"""
Find Logo Files on Server
This script will search for all logo files on the server to locate where they actually are.
"""

import subprocess
import sys
import os

def run_ssh_command(command, description):
    """Run an SSH command and handle errors"""
    print(f"🔄 {description}...")
    
    # SSH connection details
    server = "proptech@smaug.cygnusdns.com"
    password = "D!~EzNB$KHbE"
    
    # Use sshpass for password authentication
    ssh_cmd = f"sshpass -p '{password}' ssh -o StrictHostKeyChecking=no {server} '{command}'"
    
    try:
        result = subprocess.run(ssh_cmd, shell=True, check=True, capture_output=True, text=True)
        print(f"✅ {description} successful")
        if result.stdout.strip():
            print(f"   Output: {result.stdout.strip()}")
        return result.stdout
    except subprocess.CalledProcessError as e:
        print(f"❌ {description} failed:")
        print(f"   Command: {command}")
        print(f"   Error: {e.stderr}")
        return None
    except Exception as e:
        print(f"❌ {description} failed with unexpected error:")
        print(f"   Error: {str(e)}")
        return None

def main():
    print("🔍 Find Logo Files on Server")
    print("=" * 35)
    
    print("🎯 Searching for logo files on the server...")
    print()
    
    # Search for mpa-logo.png
    search_mpa_logo = "find /home/proptech -name 'mpa-logo.png' -type f 2>/dev/null"
    run_ssh_command(search_mpa_logo, "Searching for mpa-logo.png")
    
    # Search for MPA-logo-white-transparent-res.png
    search_white_logo = "find /home/proptech -name 'MPA-logo-white-transparent-res.png' -type f 2>/dev/null"
    run_ssh_command(search_white_logo, "Searching for MPA-logo-white-transparent-res.png")
    
    # Search for any logo files
    search_all_logos = "find /home/proptech -name '*logo*.png' -type f 2>/dev/null | head -20"
    run_ssh_command(search_all_logos, "Searching for all logo files")
    
    # Check WordPress uploads directory
    check_uploads = "ls -la /home/proptech/public_html/proptech.org.my/wp-content/uploads/ 2>/dev/null | grep -i logo || echo 'No logos in uploads'"
    run_ssh_command(check_uploads, "Checking WordPress uploads directory")
    
    # Check if there are any assets directories
    search_assets = "find /home/proptech -name 'assets' -type d 2>/dev/null"
    run_ssh_command(search_assets, "Searching for all assets directories")
    
    print()
    print("🔍 Search completed! Check the output above to see where the logo files are located.")

if __name__ == "__main__":
    try:
        main()
    except KeyboardInterrupt:
        print("\n\n⏹️  Script interrupted by user")
        sys.exit(1)
    except Exception as e:
        print(f"\n❌ Unexpected error: {e}")
        sys.exit(1)

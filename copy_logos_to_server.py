#!/usr/bin/env python3
"""
Copy Logo Files to Server
This script will copy the logo files from local backup to the server using scp.
"""

import subprocess
import sys
import os

def run_scp_command(local_file, remote_path, description):
    """Copy file to server using scp"""
    print(f"🔄 {description}...")
    
    # SCP command with password
    scp_cmd = f"sshpass -p 'D!~EzNB$KHbE' scp -o StrictHostKeyChecking=no {local_file} proptech@smaug.cygnusdns.com:{remote_path}"
    
    try:
        result = subprocess.run(scp_cmd, shell=True, check=True, capture_output=True, text=True)
        print(f"✅ {description} successful")
        return True
    except subprocess.CalledProcessError as e:
        print(f"❌ {description} failed:")
        print(f"   Command: {scp_cmd}")
        print(f"   Error: {e.stderr}")
        return False
    except Exception as e:
        print(f"❌ {description} failed with unexpected error:")
        print(f"   Error: {str(e)}")
        return False

def main():
    print("🔧 Copy Logo Files to Server")
    print("=" * 35)
    
    # Check if logo files exist locally
    logo_files = [
        "template_backup/mark9/assets/mpa-logo.png",
        "template_backup/mark9/assets/MPA-logo-white-transparent-res.png"
    ]
    
    for logo_file in logo_files:
        if not os.path.exists(logo_file):
            print(f"❌ Local file not found: {logo_file}")
            sys.exit(1)
        print(f"✅ Found local file: {logo_file}")
    
    print()
    print("🎯 Copying logo files to main site...")
    
    # Copy to main site theme assets
    main_site_path = "/home/proptech/public_html/proptech.org.my/wp-content/themes/mpa-custom/assets/"
    
    success_count = 0
    for logo_file in logo_files:
        filename = os.path.basename(logo_file)
        if run_scp_command(logo_file, main_site_path + filename, f"Copying {filename} to main site"):
            success_count += 1
    
    print()
    if success_count == len(logo_files):
        print("🎉 All logo files copied successfully!")
        print("📋 Summary:")
        print("   ✅ Copied mpa-logo.png to main site")
        print("   ✅ Copied MPA-logo-white-transparent-res.png to main site")
        print()
        print("🌐 Test your main site now:")
        print("   https://proptech.org.my/")
        print()
        print("💡 The logo should now appear on both main and test sites!")
    else:
        print(f"❌ Only {success_count}/{len(logo_files)} files copied successfully")
        sys.exit(1)

if __name__ == "__main__":
    try:
        main()
    except KeyboardInterrupt:
        print("\n\n⏹️  Script interrupted by user")
        sys.exit(1)
    except Exception as e:
        print(f"\n❌ Unexpected error: {e}")
        sys.exit(1)

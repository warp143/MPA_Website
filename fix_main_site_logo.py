#!/usr/bin/env python3
"""
Fix Main Site Logo
Copy the missing mpa-logo.png from test site to main site theme assets.
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
    print("🔧 Fix Main Site Logo")
    print("=" * 25)
    
    print("🎯 Copying missing logo from test site to main site...")
    print()
    
    # Step 1: Check if main site theme assets directory exists
    check_main_assets = "ls -la /home/proptech/public_html/proptech.org.my/wp-content/themes/mpa-custom/assets/ 2>/dev/null || echo 'Main site assets directory not found'"
    run_ssh_command(check_main_assets, "Checking main site theme assets directory")
    
    # Step 2: Create main site theme assets directory if it doesn't exist
    create_main_assets = "mkdir -p /home/proptech/public_html/proptech.org.my/wp-content/themes/mpa-custom/assets/"
    run_ssh_command(create_main_assets, "Creating main site theme assets directory")
    
    # Step 3: Copy the main logo from test site to main site
    copy_main_logo = "cp /home/proptech/public_html/proptech.org.my/test/wp-content/themes/mpa-custom/assets/mpa-logo.png /home/proptech/public_html/proptech.org.my/wp-content/themes/mpa-custom/assets/"
    if not run_ssh_command(copy_main_logo, "Copying mpa-logo.png to main site"):
        print("❌ Failed to copy main logo")
        sys.exit(1)
    
    # Step 4: Copy the white logo from uploads to main site theme assets
    copy_white_logo = "cp /home/proptech/public_html/proptech.org.my/wp-content/uploads/2024/07/MPA-logo-white-transparent-res.png /home/proptech/public_html/proptech.org.my/wp-content/themes/mpa-custom/assets/"
    if not run_ssh_command(copy_white_logo, "Copying white logo to main site theme assets"):
        print("❌ Failed to copy white logo")
        sys.exit(1)
    
    # Step 5: Set proper permissions
    set_permissions = "chmod 644 /home/proptech/public_html/proptech.org.my/wp-content/themes/mpa-custom/assets/mpa-logo.png /home/proptech/public_html/proptech.org.my/wp-content/themes/mpa-custom/assets/MPA-logo-white-transparent-res.png"
    run_ssh_command(set_permissions, "Setting proper permissions for logo files")
    
    # Step 6: Verify the files are now in place
    verify_logos = "ls -la /home/proptech/public_html/proptech.org.my/wp-content/themes/mpa-custom/assets/mpa-logo.png /home/proptech/public_html/proptech.org.my/wp-content/themes/mpa-custom/assets/MPA-logo-white-transparent-res.png"
    if not run_ssh_command(verify_logos, "Verifying logo files are in place"):
        print("❌ Logo files verification failed")
        sys.exit(1)
    
    print()
    print("🎉 Main site logo fix completed successfully!")
    print("📋 Summary:")
    print("   ✅ Created main site theme assets directory")
    print("   ✅ Copied mpa-logo.png from test site")
    print("   ✅ Copied MPA-logo-white-transparent-res.png from uploads")
    print("   ✅ Set proper file permissions")
    print()
    print("🌐 Test your main site now:")
    print("   https://proptech.org.my/")
    print()
    print("💡 The logo should now appear on the main site!")

if __name__ == "__main__":
    try:
        main()
    except KeyboardInterrupt:
        print("\n\n⏹️  Script interrupted by user")
        sys.exit(1)
    except Exception as e:
        print(f"\n❌ Unexpected error: {e}")
        sys.exit(1)

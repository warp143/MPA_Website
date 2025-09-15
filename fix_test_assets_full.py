#!/usr/bin/env python3
"""
Fix Test Site Assets - Copy all assets from WordPress theme to test directory
This script will copy all assets after the logo test is successful.
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

def check_sshpass():
    """Check if sshpass is installed"""
    try:
        subprocess.run(['sshpass', '-V'], capture_output=True, check=True)
        return True
    except (subprocess.CalledProcessError, FileNotFoundError):
        return False

def main():
    print("🔧 Test Site Assets Fix Script (Full)")
    print("=" * 45)
    
    # Check if sshpass is available
    if not check_sshpass():
        print("❌ sshpass is not installed. Installing...")
        try:
            subprocess.run(['brew', 'install', 'hudochenkov/sshpass/sshpass'], check=True)
            print("✅ sshpass installed successfully")
        except subprocess.CalledProcessError:
            print("❌ Failed to install sshpass. Please install manually:")
            print("   brew install hudochenkov/sshpass/sshpass")
            sys.exit(1)
    
    print("🎯 Copying ALL assets from WordPress theme to test directory...")
    print()
    
    # Step 1: Check if test directory exists
    check_test_dir = "ls -la /home/proptech/public_html/proptech.org.my/test/"
    if not run_ssh_command(check_test_dir, "Checking test directory"):
        print("❌ Test directory not found or accessible")
        sys.exit(1)
    
    # Step 2: Check if assets directory exists in test
    check_assets_dir = "ls -la /home/proptech/public_html/proptech.org.my/test/assets/ 2>/dev/null || echo 'assets directory not found'"
    run_ssh_command(check_assets_dir, "Checking if assets directory exists in test")
    
    # Step 3: Create assets directory in test if it doesn't exist
    create_assets_dir = "mkdir -p /home/proptech/public_html/proptech.org.my/test/assets/"
    if not run_ssh_command(create_assets_dir, "Creating assets directory in test"):
        print("❌ Failed to create assets directory")
        sys.exit(1)
    
    # Step 4: Check if source assets exist in WordPress theme
    check_source_assets = "ls -la /home/proptech/public_html/proptech.org.my/wp-content/themes/mpa-custom/assets/ | head -10"
    if not run_ssh_command(check_source_assets, "Checking source assets in WordPress theme"):
        print("❌ Source assets not found in WordPress theme")
        sys.exit(1)
    
    # Step 5: Copy ALL assets from WordPress theme to test
    copy_all_assets = "cp -r /home/proptech/public_html/proptech.org.my/wp-content/themes/mpa-custom/assets/* /home/proptech/public_html/proptech.org.my/test/assets/"
    if not run_ssh_command(copy_all_assets, "Copying all assets to test directory"):
        print("❌ Failed to copy assets")
        sys.exit(1)
    
    # Step 6: Set proper permissions for all files
    set_permissions = "find /home/proptech/public_html/proptech.org.my/test/assets/ -type f -exec chmod 644 {} \\;"
    run_ssh_command(set_permissions, "Setting proper permissions for all asset files")
    
    # Step 7: Set proper permissions for directories
    set_dir_permissions = "find /home/proptech/public_html/proptech.org.my/test/assets/ -type d -exec chmod 755 {} \\;"
    run_ssh_command(set_dir_permissions, "Setting proper permissions for asset directories")
    
    # Step 8: Verify key files were copied
    verify_logos = "ls -la /home/proptech/public_html/proptech.org.my/test/assets/mpa-logo.png /home/proptech/public_html/proptech.org.my/test/assets/MPA-logo-white-transparent-res.png"
    if not run_ssh_command(verify_logos, "Verifying logo files were copied"):
        print("❌ Logo files verification failed")
        sys.exit(1)
    
    # Step 9: Count total files copied
    count_files = "find /home/proptech/public_html/proptech.org.my/test/assets/ -type f | wc -l"
    file_count = run_ssh_command(count_files, "Counting total asset files")
    
    print()
    print("🎉 Full assets copy completed successfully!")
    print("📋 Summary:")
    print("   ✅ Created assets directory in test site")
    print("   ✅ Copied ALL assets from WordPress theme to test/assets/")
    print("   ✅ Set proper file and directory permissions")
    if file_count:
        print(f"   ✅ Total files copied: {file_count.strip()}")
    print()
    print("🌐 Test your site now:")
    print("   https://proptech.org.my/test/")
    print()
    print("💡 The logo and all other assets should now be working correctly!")

if __name__ == "__main__":
    try:
        main()
    except KeyboardInterrupt:
        print("\n\n⏹️  Script interrupted by user")
        sys.exit(1)
    except Exception as e:
        print(f"\n❌ Unexpected error: {e}")
        sys.exit(1)

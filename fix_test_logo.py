#!/usr/bin/env python3
"""
Fix Test Site Logo - Move logo files from WordPress theme to test directory
This script will SSH into the server and move the logo files to fix the missing logo issue.
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
    print("🔧 Test Site Logo Fix Script")
    print("=" * 40)
    
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
    
    print("🎯 Testing with just the main logo file first...")
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
    
    # Step 4: Check if logo files exist in WordPress theme
    check_logo_source = "ls -la /home/proptech/public_html/proptech.org.my/wp-content/themes/mpa-custom/assets/mpa-logo.png"
    if not run_ssh_command(check_logo_source, "Checking if logo exists in WordPress theme"):
        print("❌ Logo file not found in WordPress theme")
        sys.exit(1)
    
    # Step 5: Copy the main logo file (TEST - just one file)
    copy_logo = "cp /home/proptech/public_html/proptech.org.my/wp-content/themes/mpa-custom/assets/mpa-logo.png /home/proptech/public_html/proptech.org.my/test/assets/"
    if not run_ssh_command(copy_logo, "Copying main logo file to test assets"):
        print("❌ Failed to copy logo file")
        sys.exit(1)
    
    # Step 6: Verify the copy worked
    verify_logo = "ls -la /home/proptech/public_html/proptech.org.my/test/assets/mpa-logo.png"
    if not run_ssh_command(verify_logo, "Verifying logo file was copied"):
        print("❌ Logo file verification failed")
        sys.exit(1)
    
    # Step 7: Set proper permissions
    set_permissions = "chmod 644 /home/proptech/public_html/proptech.org.my/test/assets/mpa-logo.png"
    run_ssh_command(set_permissions, "Setting proper permissions for logo file")
    
    print()
    print("🎉 Logo fix test completed successfully!")
    print("📋 Summary:")
    print("   ✅ Created assets directory in test site")
    print("   ✅ Copied mpa-logo.png to test/assets/")
    print("   ✅ Set proper file permissions")
    print()
    print("🌐 Test your site now:")
    print("   https://proptech.org.my/test/")
    print()
    print("💡 If the logo appears correctly, run the full script to copy all assets.")
    print("   If not, check the browser console for any remaining errors.")

if __name__ == "__main__":
    try:
        main()
    except KeyboardInterrupt:
        print("\n\n⏹️  Script interrupted by user")
        sys.exit(1)
    except Exception as e:
        print(f"\n❌ Unexpected error: {e}")
        sys.exit(1)

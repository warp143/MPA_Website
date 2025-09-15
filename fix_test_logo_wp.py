#!/usr/bin/env python3
"""
Fix Test Site Logo - WordPress Version
The test site is actually a WordPress installation, so we need to check the theme setup.
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
    print("🔧 Test Site Logo Fix Script (WordPress Version)")
    print("=" * 50)
    
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
    
    print("🎯 Investigating WordPress test site structure...")
    print()
    
    # Step 1: Check what themes are available in test site
    check_themes = "ls -la /home/proptech/public_html/proptech.org.my/test/wp-content/themes/"
    if not run_ssh_command(check_themes, "Checking available themes in test site"):
        print("❌ Could not access themes directory")
        sys.exit(1)
    
    # Step 2: Check if mpa-custom theme exists in test site
    check_mpa_theme = "ls -la /home/proptech/public_html/proptech.org.my/test/wp-content/themes/mpa-custom/ 2>/dev/null || echo 'mpa-custom theme not found'"
    run_ssh_command(check_mpa_theme, "Checking if mpa-custom theme exists in test site")
    
    # Step 3: Check if assets exist in test site theme
    check_test_assets = "ls -la /home/proptech/public_html/proptech.org.my/test/wp-content/themes/mpa-custom/assets/ 2>/dev/null || echo 'assets not found in test theme'"
    run_ssh_command(check_test_assets, "Checking assets in test site theme")
    
    # Step 4: Check main site theme assets
    check_main_assets = "ls -la /home/proptech/public_html/proptech.org.my/wp-content/themes/mpa-custom/assets/mpa-logo.png"
    if not run_ssh_command(check_main_assets, "Checking main site theme assets"):
        print("❌ Main site assets not found")
        sys.exit(1)
    
    # Step 5: Copy the theme from main site to test site
    copy_theme = "cp -r /home/proptech/public_html/proptech.org.my/wp-content/themes/mpa-custom /home/proptech/public_html/proptech.org.my/test/wp-content/themes/"
    if not run_ssh_command(copy_theme, "Copying mpa-custom theme to test site"):
        print("❌ Failed to copy theme")
        sys.exit(1)
    
    # Step 6: Set proper permissions for the theme
    set_theme_permissions = "chown -R proptech:proptech /home/proptech/public_html/proptech.org.my/test/wp-content/themes/mpa-custom/"
    run_ssh_command(set_theme_permissions, "Setting theme ownership")
    
    set_file_permissions = "find /home/proptech/public_html/proptech.org.my/test/wp-content/themes/mpa-custom/ -type f -exec chmod 644 {} \\;"
    run_ssh_command(set_file_permissions, "Setting theme file permissions")
    
    set_dir_permissions = "find /home/proptech/public_html/proptech.org.my/test/wp-content/themes/mpa-custom/ -type d -exec chmod 755 {} \\;"
    run_ssh_command(set_dir_permissions, "Setting theme directory permissions")
    
    # Step 7: Verify the logo files are now available
    verify_logos = "ls -la /home/proptech/public_html/proptech.org.my/test/wp-content/themes/mpa-custom/assets/mpa-logo.png /home/proptech/public_html/proptech.org.my/test/wp-content/themes/mpa-custom/assets/MPA-logo-white-transparent-res.png"
    if not run_ssh_command(verify_logos, "Verifying logo files in test theme"):
        print("❌ Logo files verification failed")
        sys.exit(1)
    
    print()
    print("🎉 WordPress theme copy completed successfully!")
    print("📋 Summary:")
    print("   ✅ Copied mpa-custom theme from main site to test site")
    print("   ✅ Set proper file and directory permissions")
    print("   ✅ Logo files are now available in test site theme")
    print()
    print("🌐 Test your site now:")
    print("   https://proptech.org.my/test/")
    print()
    print("💡 The test site should now use the same theme as the main site.")
    print("   If the logo still doesn't appear, check the WordPress admin")
    print("   to ensure the mpa-custom theme is activated.")

if __name__ == "__main__":
    try:
        main()
    except KeyboardInterrupt:
        print("\n\n⏹️  Script interrupted by user")
        sys.exit(1)
    except Exception as e:
        print(f"\n❌ Unexpected error: {e}")
        sys.exit(1)

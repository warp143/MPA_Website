#!/usr/bin/env python3
"""
Restore Test Site Logos
Copy the logo files back to the test site from the main site.
"""

import subprocess
import sys

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
        return result.stdout
    except subprocess.CalledProcessError as e:
        print(f"❌ {description} failed: {e.stderr}")
        return None

def main():
    print("🔧 Restore Test Site Logos")
    print("=" * 30)
    
    # Copy logos back to test site
    restore_command = """
    cp /home/proptech/public_html/proptech.org.my/wp-content/themes/mpa-custom/assets/mpa-logo.png /home/proptech/public_html/proptech.org.my/test/wp-content/themes/mpa-custom/assets/ && \
    cp /home/proptech/public_html/proptech.org.my/wp-content/themes/mpa-custom/assets/MPA-logo-white-transparent-res.png /home/proptech/public_html/proptech.org.my/test/wp-content/themes/mpa-custom/assets/ && \
    chmod 644 /home/proptech/public_html/proptech.org.my/test/wp-content/themes/mpa-custom/assets/*.png && \
    ls -la /home/proptech/public_html/proptech.org.my/test/wp-content/themes/mpa-custom/assets/mpa-logo.png /home/proptech/public_html/proptech.org.my/test/wp-content/themes/mpa-custom/assets/MPA-logo-white-transparent-res.png
    """
    
    if run_ssh_command(restore_command, "Restoring logo files to test site"):
        print()
        print("🎉 Test site logos restored!")
        print("🌐 Test your site: https://proptech.org.my/test/")
    else:
        print("❌ Logo restore failed")

if __name__ == "__main__":
    main()

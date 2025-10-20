#!/usr/bin/env python3
"""
Direct editing of live server theme files
Downloads file, opens in editor, then uploads back to server
"""

import os
import sys
import subprocess
import json
import tempfile
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

def download_file(config, remote_path, local_path):
    """Download a file from the server"""
    hostname = config["server"]["hostname"]
    username = config["server"]["username"]
    key_path = Path(__file__).parent.parent / config["server"]["key_path"]
    
    os.chmod(key_path, 0o600)
    
    scp_cmd = f"scp -i {key_path} -o StrictHostKeyChecking=no {username}@{hostname}:{remote_path} {local_path}"
    
    print(f"📥 Downloading {remote_path}...")
    result = subprocess.run(scp_cmd, shell=True, capture_output=True, text=True)
    
    if result.returncode == 0:
        print("✅ Download successful")
        return True
    else:
        print(f"❌ Download failed: {result.stderr}")
        return False

def upload_file(config, local_path, remote_path):
    """Upload a file to the server"""
    hostname = config["server"]["hostname"]
    username = config["server"]["username"]
    key_path = Path(__file__).parent.parent / config["server"]["key_path"]
    
    # Create backup first
    ssh_cmd = f"ssh -i {key_path} -o StrictHostKeyChecking=no {username}@{hostname}"
    backup_cmd = f"{ssh_cmd} 'cp {remote_path} {remote_path}.backup.$(date +%Y%m%d_%H%M%S)'"
    
    print("💾 Creating backup...")
    subprocess.run(backup_cmd, shell=True, capture_output=True)
    
    # Upload file
    scp_cmd = f"scp -i {key_path} -o StrictHostKeyChecking=no {local_path} {username}@{hostname}:{remote_path}"
    
    print(f"📤 Uploading to {remote_path}...")
    result = subprocess.run(scp_cmd, shell=True, capture_output=True, text=True)
    
    if result.returncode == 0:
        print("✅ Upload successful")
        return True
    else:
        print(f"❌ Upload failed: {result.stderr}")
        return False

def list_theme_files(config):
    """List editable theme files"""
    print("\n📁 Available theme files to edit:\n")
    files = {
        "1": ("front-page.php", "~/public_html/proptech.org.my/wp-content/themes/mpa-custom/front-page.php"),
        "2": ("header.php", "~/public_html/proptech.org.my/wp-content/themes/mpa-custom/header.php"),
        "3": ("footer.php", "~/public_html/proptech.org.my/wp-content/themes/mpa-custom/footer.php"),
        "4": ("style.css", "~/public_html/proptech.org.my/wp-content/themes/mpa-custom/style.css"),
        "5": ("functions.php", "~/public_html/proptech.org.my/wp-content/themes/mpa-custom/functions.php"),
        "6": ("page-events.php", "~/public_html/proptech.org.my/wp-content/themes/mpa-custom/page-events.php"),
        "7": ("page-members.php", "~/public_html/proptech.org.my/wp-content/themes/mpa-custom/page-members.php"),
        "8": ("page-partners.php", "~/public_html/proptech.org.my/wp-content/themes/mpa-custom/page-partners.php"),
    }
    
    for key, (filename, path) in files.items():
        print(f"  {key}. {filename}")
    
    print("\n  0. Custom path")
    print("  q. Quit\n")
    
    return files

def main():
    print("🔧 Live Server Theme Editor")
    print("=" * 50)
    
    config = load_config()
    files = list_theme_files(config)
    
    choice = input("Select file to edit: ").strip()
    
    if choice.lower() == 'q':
        print("👋 Goodbye!")
        return 0
    
    if choice == '0':
        remote_path = input("Enter remote file path: ").strip()
        filename = Path(remote_path).name
    elif choice in files:
        filename, remote_path = files[choice]
    else:
        print("❌ Invalid choice")
        return 1
    
    # Create temp file
    with tempfile.NamedTemporaryFile(mode='w', suffix=f'_{filename}', delete=False) as tmp:
        temp_path = tmp.name
    
    try:
        # Download file
        if not download_file(config, remote_path, temp_path):
            return 1
        
        # Get original file hash
        original_hash = subprocess.run(
            ['md5', '-q', temp_path], 
            capture_output=True, 
            text=True
        ).stdout.strip()
        
        # Open in editor
        editor = os.environ.get('EDITOR', 'nano')
        print(f"\n📝 Opening in {editor}...")
        print("💡 Save and close the editor when done\n")
        
        subprocess.run([editor, temp_path])
        
        # Check if file was modified
        new_hash = subprocess.run(
            ['md5', '-q', temp_path], 
            capture_output=True, 
            text=True
        ).stdout.strip()
        
        if original_hash == new_hash:
            print("\n📌 No changes detected")
            return 0
        
        # Confirm upload
        response = input("\n💾 File was modified. Upload to live server? (y/N): ").strip().lower()
        
        if response == 'y':
            if upload_file(config, temp_path, remote_path):
                print(f"\n🎉 Changes are now live at {config['wordpress']['site_url']}")
                return 0
            else:
                return 1
        else:
            print("\n❌ Upload cancelled")
            return 0
            
    finally:
        # Cleanup
        if os.path.exists(temp_path):
            os.unlink(temp_path)

if __name__ == "__main__":
    sys.exit(main())


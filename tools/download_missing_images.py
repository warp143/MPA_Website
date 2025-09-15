#!/usr/bin/env python3
"""
Download any remaining images that were missed in the initial scrape
"""

import requests
import re
import os
from pathlib import Path
from urllib.parse import urlparse
import time

def get_safe_filename(url):
    """Convert URL to safe filename"""
    parsed = urlparse(url)
    path = parsed.path.strip('/')
    
    if not path or path == '':
        return 'index.html'
    
    # Remove query parameters and fragments
    path = path.split('?')[0].split('#')[0]
    
    # Replace unsafe characters
    safe_path = re.sub(r'[<>:"/\\|?*]', '_', path)
    return safe_path

def download_file(url, local_path, session):
    """Download a file from URL to local path"""
    try:
        print(f"Downloading: {url}")
        response = session.get(url, timeout=60, allow_redirects=True)
        response.raise_for_status()
        
        # Create directory if it doesn't exist
        local_path.parent.mkdir(parents=True, exist_ok=True)
        
        # Write file
        with open(local_path, 'wb') as f:
            f.write(response.content)
            
        print(f"Saved: {local_path}")
        return True
        
    except Exception as e:
        print(f"Failed to download {url}: {str(e)}")
        return False

def main():
    output_dir = Path("mpa_original")
    base_url = "https://proptech.org.my/"
    
    # Setup session
    session = requests.Session()
    session.headers.update({
        'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
    })
    
    # Find all HTML files
    html_files = list(output_dir.glob("*.html"))
    
    # Pattern to find image URLs
    image_pattern = r'https://proptech\.org\.my/[^"\s\)]+\.(png|jpg|jpeg|gif|svg|webp)'
    
    found_urls = set()
    
    # Search through all HTML files
    for html_file in html_files:
        print(f"Checking {html_file}...")
        with open(html_file, 'r', encoding='utf-8') as f:
            content = f.read()
            
        # Find all image URLs
        matches = re.findall(image_pattern, content, re.IGNORECASE)
        for match in re.finditer(image_pattern, content, re.IGNORECASE):
            url = match.group(0)
            found_urls.add(url)
    
    print(f"\nFound {len(found_urls)} unique image URLs")
    
    # Check which ones are missing
    missing_urls = []
    for url in found_urls:
        local_filename = get_safe_filename(url)
        local_path = output_dir / local_filename
        
        if not local_path.exists():
            missing_urls.append(url)
    
    print(f"Missing {len(missing_urls)} images")
    
    # Download missing images
    for url in missing_urls:
        local_filename = get_safe_filename(url)
        local_path = output_dir / local_filename
        
        if download_file(url, local_path, session):
            time.sleep(0.5)  # Be respectful
    
    print(f"\nCompleted! Downloaded {len(missing_urls)} additional images")

if __name__ == "__main__":
    main()

#!/usr/bin/env python3
"""
Web scraper for Malaysia PropTech Association website
Scrapes https://proptech.org.my/ and saves content to mpa_original folder
"""

import requests
from bs4 import BeautifulSoup
import os
import urllib.parse
from pathlib import Path
import time
import re
from urllib.parse import urljoin, urlparse
import mimetypes

class MPAWebsiteScraper:
    def __init__(self, base_url="https://proptech.org.my/", output_dir="mpa_original"):
        self.base_url = base_url
        self.output_dir = Path(output_dir)
        self.session = requests.Session()
        self.session.headers.update({
            'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Language': 'en-US,en;q=0.5',
            'Accept-Encoding': 'gzip, deflate',
            'Connection': 'keep-alive',
            'Upgrade-Insecure-Requests': '1'
        })
        # Set longer timeout and retry settings
        self.session.mount('http://', requests.adapters.HTTPAdapter(max_retries=3))
        self.session.mount('https://', requests.adapters.HTTPAdapter(max_retries=3))
        self.downloaded_urls = set()
        self.failed_downloads = []
        
        # Create output directory
        self.output_dir.mkdir(exist_ok=True)
        
    def get_safe_filename(self, url):
        """Convert URL to safe filename"""
        parsed = urlparse(url)
        path = parsed.path.strip('/')
        
        if not path or path == '':
            return 'index.html'
        
        # Remove query parameters and fragments
        path = path.split('?')[0].split('#')[0]
        
        # If path doesn't have extension, assume it's HTML
        if not Path(path).suffix:
            path += '.html'
            
        # Replace unsafe characters
        safe_path = re.sub(r'[<>:"/\\|?*]', '_', path)
        return safe_path
    
    def download_file(self, url, local_path):
        """Download a file from URL to local path"""
        try:
            print(f"Downloading: {url}")
            response = self.session.get(url, timeout=60, allow_redirects=True)
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
            self.failed_downloads.append((url, str(e)))
            return False
    
    def process_html_content(self, html_content, base_url):
        """Process HTML content and update links to local files"""
        soup = BeautifulSoup(html_content, 'html.parser')
        
        # Process different types of links
        link_attrs = [
            ('link', 'href'),
            ('script', 'src'),
            ('img', 'src'),
            ('a', 'href'),
            ('source', 'src'),
            ('video', 'src'),
            ('audio', 'src')
        ]
        
        for tag_name, attr_name in link_attrs:
            for tag in soup.find_all(tag_name):
                if tag.get(attr_name):
                    original_url = tag[attr_name]
                    absolute_url = urljoin(base_url, original_url)
                    
                    # Skip external links (keep them as is)
                    if not absolute_url.startswith(self.base_url):
                        continue
                    
                    # Convert to local path
                    local_filename = self.get_safe_filename(absolute_url)
                    tag[attr_name] = local_filename
                    
                    # Download the resource if we haven't already
                    if absolute_url not in self.downloaded_urls:
                        local_path = self.output_dir / local_filename
                        if self.download_file(absolute_url, local_path):
                            self.downloaded_urls.add(absolute_url)
        
        # Also process data-src attributes (lazy loading images)
        for img in soup.find_all('img'):
            if img.get('data-src'):
                original_url = img['data-src']
                absolute_url = urljoin(base_url, original_url)
                
                if absolute_url.startswith(self.base_url):
                    local_filename = self.get_safe_filename(absolute_url)
                    img['data-src'] = local_filename
                    
                    if absolute_url not in self.downloaded_urls:
                        local_path = self.output_dir / local_filename
                        if self.download_file(absolute_url, local_path):
                            self.downloaded_urls.add(absolute_url)
        
        # Process srcset attributes
        for img in soup.find_all('img'):
            if img.get('srcset'):
                srcset_parts = []
                for srcset_item in img['srcset'].split(','):
                    srcset_item = srcset_item.strip()
                    if ' ' in srcset_item:
                        url_part, size_part = srcset_item.rsplit(' ', 1)
                        absolute_url = urljoin(base_url, url_part)
                        
                        if absolute_url.startswith(self.base_url):
                            local_filename = self.get_safe_filename(absolute_url)
                            srcset_parts.append(f"{local_filename} {size_part}")
                            
                            if absolute_url not in self.downloaded_urls:
                                local_path = self.output_dir / local_filename
                                if self.download_file(absolute_url, local_path):
                                    self.downloaded_urls.add(absolute_url)
                        else:
                            srcset_parts.append(srcset_item)
                    else:
                        srcset_parts.append(srcset_item)
                
                img['srcset'] = ', '.join(srcset_parts)
        
        # Process data-srcset attributes
        for img in soup.find_all('img'):
            if img.get('data-srcset'):
                srcset_parts = []
                for srcset_item in img['data-srcset'].split(','):
                    srcset_item = srcset_item.strip()
                    if ' ' in srcset_item:
                        url_part, size_part = srcset_item.rsplit(' ', 1)
                        absolute_url = urljoin(base_url, url_part)
                        
                        if absolute_url.startswith(self.base_url):
                            local_filename = self.get_safe_filename(absolute_url)
                            srcset_parts.append(f"{local_filename} {size_part}")
                            
                            if absolute_url not in self.downloaded_urls:
                                local_path = self.output_dir / local_filename
                                if self.download_file(absolute_url, local_path):
                                    self.downloaded_urls.add(absolute_url)
                        else:
                            srcset_parts.append(srcset_item)
                    else:
                        srcset_parts.append(srcset_item)
                
                img['data-srcset'] = ', '.join(srcset_parts)
        
        # Process inline CSS and JavaScript that might contain URLs
        html_str = str(soup)
        
        # Find URLs in CSS and JS content
        import re
        url_pattern = r'https://proptech\.org\.my/[^"\s\)]+\.(png|jpg|jpeg|gif|svg|webp|css|js|woff|woff2|ttf|eot)'
        
        def replace_url(match):
            original_url = match.group(0)
            if original_url not in self.downloaded_urls:
                local_filename = self.get_safe_filename(original_url)
                local_path = self.output_dir / local_filename
                if self.download_file(original_url, local_path):
                    self.downloaded_urls.add(original_url)
                return local_filename
            else:
                return self.get_safe_filename(original_url)
        
        html_str = re.sub(url_pattern, replace_url, html_str)
        
        return html_str
    
    def scrape_page(self, url, filename=None):
        """Scrape a single page"""
        if url in self.downloaded_urls:
            return
            
        try:
            print(f"Scraping page: {url}")
            response = self.session.get(url, timeout=60, allow_redirects=True)
            response.raise_for_status()
            
            if filename is None:
                filename = self.get_safe_filename(url)
            
            local_path = self.output_dir / filename
            
            # Check if it's HTML content
            content_type = response.headers.get('content-type', '').lower()
            if 'text/html' in content_type:
                # Process HTML and update links
                processed_html = self.process_html_content(response.text, url)
                
                # Save processed HTML
                local_path.parent.mkdir(parents=True, exist_ok=True)
                with open(local_path, 'w', encoding='utf-8') as f:
                    f.write(processed_html)
            else:
                # Save binary content as-is
                local_path.parent.mkdir(parents=True, exist_ok=True)
                with open(local_path, 'wb') as f:
                    f.write(response.content)
            
            self.downloaded_urls.add(url)
            print(f"Saved: {local_path}")
            
            # Small delay to be respectful
            time.sleep(0.5)
            
        except Exception as e:
            print(f"Failed to scrape {url}: {str(e)}")
            self.failed_downloads.append((url, str(e)))
    
    def discover_pages(self, start_url):
        """Discover pages by parsing the main page for internal links"""
        try:
            response = self.session.get(start_url, timeout=60, allow_redirects=True)
            response.raise_for_status()
            
            soup = BeautifulSoup(response.text, 'html.parser')
            pages = set()
            
            # Find all links
            for link in soup.find_all('a', href=True):
                href = link['href']
                absolute_url = urljoin(start_url, href)
                
                # Only include internal links
                if absolute_url.startswith(self.base_url):
                    # Remove fragments
                    clean_url = absolute_url.split('#')[0]
                    pages.add(clean_url)
            
            return pages
            
        except Exception as e:
            print(f"Failed to discover pages from {start_url}: {str(e)}")
            return set()
    
    def scrape_website(self):
        """Main method to scrape the entire website"""
        print(f"Starting to scrape {self.base_url}")
        print(f"Output directory: {self.output_dir.absolute()}")
        
        # First, scrape the main page
        self.scrape_page(self.base_url, 'index.html')
        
        # Discover other pages
        print("Discovering internal pages...")
        pages = self.discover_pages(self.base_url)
        
        print(f"Found {len(pages)} pages to scrape")
        
        # Scrape each discovered page
        for page_url in pages:
            if page_url not in self.downloaded_urls:
                self.scrape_page(page_url)
        
        # Create a summary
        self.create_summary()
        
    def create_summary(self):
        """Create a summary of the scraping process"""
        summary_path = self.output_dir / 'scraping_summary.txt'
        
        with open(summary_path, 'w', encoding='utf-8') as f:
            f.write("Malaysia PropTech Association Website Scraping Summary\n")
            f.write("=" * 60 + "\n\n")
            f.write(f"Base URL: {self.base_url}\n")
            f.write(f"Output Directory: {self.output_dir.absolute()}\n")
            f.write(f"Total URLs Downloaded: {len(self.downloaded_urls)}\n")
            f.write(f"Failed Downloads: {len(self.failed_downloads)}\n\n")
            
            if self.downloaded_urls:
                f.write("Successfully Downloaded URLs:\n")
                f.write("-" * 30 + "\n")
                for url in sorted(self.downloaded_urls):
                    f.write(f"  {url}\n")
                f.write("\n")
            
            if self.failed_downloads:
                f.write("Failed Downloads:\n")
                f.write("-" * 20 + "\n")
                for url, error in self.failed_downloads:
                    f.write(f"  {url}: {error}\n")
        
        print(f"Summary saved to: {summary_path}")

def main():
    scraper = MPAWebsiteScraper()
    scraper.scrape_website()
    
    print("\nScraping completed!")
    print(f"Files saved to: {scraper.output_dir.absolute()}")
    
    if scraper.failed_downloads:
        print(f"Warning: {len(scraper.failed_downloads)} downloads failed")
        print("Check scraping_summary.txt for details")

if __name__ == "__main__":
    main()

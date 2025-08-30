#!/usr/bin/env python3
"""
Selenium script to check the members page logos
"""

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

def check_members_logos():
    # Use Chrome in headless mode
    options = webdriver.ChromeOptions()
    options.add_argument('--headless')
    options.add_argument('--no-sandbox')
    options.add_argument('--disable-dev-shm-usage')
    
    driver = webdriver.Chrome(options=options)
    
    try:
        print("🌐 Opening localhost:1739/members.html...")
        driver.get("http://localhost:1739/members.html")
        
        # Wait for page to load
        time.sleep(3)
        
        print("\n📋 Checking Featured Members Section:")
        # Check featured members logos
        try:
            featured_members = driver.find_elements(By.CSS_SELECTOR, '.featured-members .member-card')
            print(f"✅ Found {len(featured_members)} featured member cards")
            
            for i, member in enumerate(featured_members, 1):
                try:
                    logo = member.find_element(By.CSS_SELECTOR, '.member-logo img')
                    src = logo.get_attribute('src')
                    alt = logo.get_attribute('alt')
                    print(f"   Member {i}: {alt}")
                    print(f"      Logo src: {src}")
                    print(f"      Visible: {logo.is_displayed()}")
                    print(f"      Size: {logo.size}")
                except Exception as e:
                    print(f"   Member {i}: ❌ No logo found - {e}")
        except Exception as e:
            print(f"❌ Error checking featured members: {e}")
        
        print("\n📋 Checking Member Directory Section:")
        # Check directory member logos
        try:
            directory_items = driver.find_elements(By.CSS_SELECTOR, '.directory-item')
            print(f"✅ Found {len(directory_items)} directory items")
            
            for i, item in enumerate(directory_items[:10], 1):  # Check first 10
                try:
                    logo = item.find_element(By.CSS_SELECTOR, '.member-logo img')
                    src = logo.get_attribute('src')
                    alt = logo.get_attribute('alt')
                    member_name = item.find_element(By.CSS_SELECTOR, 'h3').text
                    print(f"   Directory {i}: {member_name}")
                    print(f"      Logo src: {src}")
                    print(f"      Visible: {logo.is_displayed()}")
                    print(f"      Size: {logo.size}")
                except Exception as e:
                    member_name = item.find_element(By.CSS_SELECTOR, 'h3').text if item.find_elements(By.CSS_SELECTOR, 'h3') else f"Item {i}"
                    print(f"   Directory {i}: {member_name} ❌ No logo found - {e}")
        except Exception as e:
            print(f"❌ Error checking directory items: {e}")
        
        # Check for broken images
        print("\n🔍 Checking for broken images:")
        try:
            images = driver.find_elements(By.TAG_NAME, 'img')
            broken_count = 0
            for img in images:
                src = img.get_attribute('src')
                if src and 'mpa_content_backup' in src:
                    # Check if image loads
                    natural_width = driver.execute_script("return arguments[0].naturalWidth", img)
                    if natural_width == 0:
                        print(f"   ❌ Broken image: {src}")
                        broken_count += 1
                    else:
                        print(f"   ✅ Working image: {src}")
            
            print(f"   Total backup images checked: {len([img for img in images if 'mpa_content_backup' in img.get_attribute('src') or ''])}")
            print(f"   Broken images: {broken_count}")
        except Exception as e:
            print(f"❌ Error checking broken images: {e}")
        
        # Take a screenshot
        print("\n📸 Taking screenshot...")
        driver.save_screenshot("members_check.png")
        print("✅ Screenshot saved as 'members_check.png'")
        
        # Get page source to check HTML
        page_source = driver.page_source
        backup_image_count = page_source.count('mpa_content_backup')
        print(f"\n📊 Page source analysis:")
        print(f"   References to mpa_content_backup: {backup_image_count}")
        
        if 'Sample2-20210505-PLA-FB-Funding-PitchIN' in page_source:
            print("   ✅ pitchIN logo reference found")
        else:
            print("   ❌ pitchIN logo reference not found")
            
        if 'atHome_Logo' in page_source:
            print("   ✅ HOMII logo reference found")
        else:
            print("   ❌ HOMII logo reference not found")
        
    except Exception as e:
        print(f"❌ Error: {e}")
    finally:
        driver.quit()

if __name__ == "__main__":
    check_members_logos()

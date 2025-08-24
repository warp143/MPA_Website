#!/usr/bin/env python3
"""
Selenium script to check the pillars section visually
"""

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

def check_pillars_selenium():
    # Use Chrome in headless mode
    options = webdriver.ChromeOptions()
    options.add_argument('--headless')
    options.add_argument('--no-sandbox')
    options.add_argument('--disable-dev-shm-usage')
    
    driver = webdriver.Chrome(options=options)
    
    try:
        print("🌐 Opening localhost:1734...")
        driver.get("http://localhost:1734")
        
        # Wait for page to load
        time.sleep(2)
        
        # Check if pillars image is visible
        try:
            pillars_img = driver.find_element(By.CSS_SELECTOR, 'img[src="assets/mpa-pillars-original.jpg"]')
            print("✅ Found pillars image element")
            
            # Check if it's visible
            if pillars_img.is_displayed():
                print("✅ Pillars image is visible")
                print(f"   Size: {pillars_img.size}")
                print(f"   Location: {pillars_img.location}")
            else:
                print("❌ Pillars image is not visible (hidden by CSS)")
                
        except Exception as e:
            print(f"❌ Could not find pillars image: {e}")
        
        # Check pillars container
        try:
            pillars_container = driver.find_element(By.CLASS_NAME, 'pillars-container')
            print("✅ Found pillars-container")
            print(f"   Size: {pillars_container.size}")
            print(f"   Location: {pillars_container.location}")
        except Exception as e:
            print(f"❌ Could not find pillars-container: {e}")
        
        # Check pillars visual
        try:
            pillars_visual = driver.find_element(By.CLASS_NAME, 'pillars-visual')
            print("✅ Found pillars-visual")
            print(f"   Size: {pillars_visual.size}")
            print(f"   Location: {pillars_visual.location}")
        except Exception as e:
            print(f"❌ Could not find pillars-visual: {e}")
        
        # Take a screenshot
        print("📸 Taking screenshot...")
        driver.save_screenshot("pillars_check.png")
        print("✅ Screenshot saved as 'pillars_check.png'")
        
        # Get page source to check HTML
        page_source = driver.page_source
        if 'mpa-pillars-original.jpg' in page_source:
            print("✅ Image reference found in page source")
        else:
            print("❌ Image reference not found in page source")
        
    except Exception as e:
        print(f"❌ Error: {e}")
    finally:
        driver.quit()

if __name__ == "__main__":
    check_pillars_selenium()

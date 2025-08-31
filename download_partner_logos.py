#!/usr/bin/env python3
import requests
import os

# Partner logos to download
partner_logos = [
    {
        "name": "light-house-club",
        "url": "https://proptech.org.my/wp-content/uploads/2021/11/LHC-01-768x461.png"
    },
    {
        "name": "indonesia-proptech-association",
        "url": "https://proptech.org.my/wp-content/uploads/2021/10/indonesia-proptech-association-portfolio-768x461.png"
    },
    {
        "name": "proptech-japan",
        "url": "https://proptech.org.my/wp-content/uploads/2021/10/Proptech-Japan-portfolio-01-768x461.png"
    },
    {
        "name": "asia-proptech",
        "url": "https://proptech.org.my/wp-content/uploads/2021/10/Asia-Proptech-portfolio-01-768x461.png"
    },
    {
        "name": "proptech-for-good",
        "url": "https://proptech.org.my/wp-content/uploads/2021/08/Proptech-For-Good-portfolio-01-768x461.png"
    },
    {
        "name": "unissu",
        "url": "https://proptech.org.my/wp-content/uploads/2021/08/Unissu_Logo-768x461.png"
    },
    {
        "name": "magic",
        "url": "https://proptech.org.my/wp-content/uploads/2021/08/MaGIC_Logo-768x461.png"
    },
    {
        "name": "proptech-bne",
        "url": "https://proptech.org.my/wp-content/uploads/2021/08/PropTech-BNE_Logo-768x461.png"
    }
]

# Create assets directory if it doesn't exist
if not os.path.exists('mark9/assets'):
    os.makedirs('mark9/assets')

# Download each logo
for partner in partner_logos:
    try:
        print(f"Downloading {partner['name']} logo...")
        response = requests.get(partner['url'], timeout=10)
        response.raise_for_status()
        
        # Save the logo
        filename = f"mark9/assets/{partner['name']}-logo.png"
        with open(filename, 'wb') as f:
            f.write(response.content)
        print(f"✓ Downloaded {filename}")
        
    except Exception as e:
        print(f"✗ Error downloading {partner['name']}: {e}")

print("Partner logo download complete!")

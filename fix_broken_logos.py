#!/usr/bin/env python3
import os
import requests
from urllib.parse import urlparse

def download_correct_logos():
    # Correct URLs for the broken logos
    logos = [
        ("softwareone-experts", "https://proptech.org.my/wp-content/uploads/2022/04/SoftwareONE-01.png"),
        ("mandarin-fox", "https://proptech.org.my/wp-content/uploads/2022/04/Mandarin-Fox-01-01.png"),
        ("novo-reperio", "https://proptech.org.my/wp-content/uploads/2021/08/NovoReperio_Logo.png"),
        ("nextsix-property", "https://proptech.org.my/wp-content/uploads/2021/08/NextSix_Logo.png"),
        ("isolutions", "https://proptech.org.my/wp-content/uploads/2021/08/iSolutions_Logo.png"),
        ("squarefeet-pro", "https://proptech.org.my/wp-content/uploads/2021/08/SquareFeetPro_Logo.png"),
        ("smplrspace", "https://proptech.org.my/wp-content/uploads/2021/08/SmplrSpace_Logo.png"),
        ("widebed", "https://proptech.org.my/wp-content/uploads/2021/08/WideBed_Logo.png"),
        ("salescandy", "https://proptech.org.my/wp-content/uploads/2021/08/SalesCandy_Logo.png"),
        ("tplus", "https://proptech.org.my/wp-content/uploads/2021/08/TPlus_Logo.png"),
        ("servedeck", "https://proptech.org.my/wp-content/uploads/2021/08/ServeDeck_Logo.png"),
        ("rentlab", "https://proptech.org.my/wp-content/uploads/2021/08/RentLab_Logo.png"),
        ("rekatone", "https://proptech.org.my/wp-content/uploads/2021/08/Rekatone_Logo.png"),
        ("prosales", "https://proptech.org.my/wp-content/uploads/2021/08/ProSales_Logo.png"),
        ("property-hunter", "https://proptech.org.my/wp-content/uploads/2021/08/PropertyHunter_Logo.png"),
        ("properly", "https://proptech.org.my/wp-content/uploads/2021/08/Properly_Logo.png"),
        ("propenomy", "https://proptech.org.my/wp-content/uploads/2021/08/Propenomy_Logo.png"),
        ("myliving-mylife", "https://proptech.org.my/wp-content/uploads/2021/08/MyLiving_Logo.png"),
        ("mhub", "https://proptech.org.my/wp-content/uploads/2021/08/MHub_Logo.png"),
        ("linkzzapp-pro", "https://proptech.org.my/wp-content/uploads/2021/08/LinkzzApp_Logo.png"),
    ]
    
    # Create assets directory if it doesn't exist
    os.makedirs("mark9/assets", exist_ok=True)
    
    downloaded_count = 0
    failed_count = 0
    
    for company, logo_url in logos:
        try:
            # Download logo
            response = requests.get(logo_url, timeout=10)
            if response.status_code == 200:
                # Get file extension
                parsed_url = urlparse(logo_url)
                filename = os.path.basename(parsed_url.path)
                extension = os.path.splitext(filename)[1]
                
                # Save logo
                output_path = f"mark9/assets/{company}-logo{extension}"
                with open(output_path, 'wb') as f:
                    f.write(response.content)
                print(f"Downloaded: {company} -> {output_path}")
                downloaded_count += 1
            else:
                print(f"Failed to download {company}: {response.status_code}")
                failed_count += 1
        except Exception as e:
            print(f"Error downloading {company}: {e}")
            failed_count += 1
    
    print(f"\nSummary: Downloaded {downloaded_count} logos, Failed {failed_count} logos")

if __name__ == "__main__":
    download_correct_logos()

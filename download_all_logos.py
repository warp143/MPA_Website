#!/usr/bin/env python3
import os
import requests
from urllib.parse import urlparse

def download_all_logos():
    # Complete list of ALL company logos from MPA website
    logos = [
        # Already downloaded (for reference)
        ("pitchin", "https://proptech.org.my/wp-content/uploads/2022/12/40.-pitchIN-768x461.png"),
        ("homii", "https://proptech.org.my/wp-content/uploads/2022/12/41.-HOMII-768x461.png"),
        ("speedbrick", "https://proptech.org.my/wp-content/uploads/2022/12/37.-speedbrick-768x461.png"),
        ("axai", "https://proptech.org.my/wp-content/uploads/2022/12/36.-Axaipay-2-768x461.png"),
        ("icares", "https://proptech.org.my/wp-content/uploads/2022/12/35.-iCares-768x461.png"),
        ("nuveq", "https://proptech.org.my/wp-content/uploads/2022/09/34.-Nuveq-768x461.png"),
        
        # Additional logos to download
        ("softwareone-experts", "https://proptech.org.my/wp-content/uploads/2021/08/SoftwareOne_Logo.png"),
        ("mandarin-fox", "https://proptech.org.my/wp-content/uploads/2021/08/MandarinFox_Logo.png"),
        ("novo-reperio", "https://proptech.org.my/wp-content/uploads/2021/08/NovoReperio_Logo.png"),
        ("nextsix-property", "https://proptech.org.my/wp-content/uploads/2021/08/NextSix_Logo.png"),
        ("isolutions", "https://proptech.org.my/wp-content/uploads/2021/08/iSolutions_Logo.png"),
        ("squarefeet-pro", "https://proptech.org.my/wp-content/uploads/2021/08/SquareFeet_Logo.png"),
        ("heyprop", "https://proptech.org.my/wp-content/uploads/2021/08/HeyProp_Logo.png"),
        ("ineighbour", "https://proptech.org.my/wp-content/uploads/2021/08/iNeighbour_Logo.png"),
        ("vendfun", "https://proptech.org.my/wp-content/uploads/2021/08/VendFun_Logo.png"),
        ("cozyhomes", "https://proptech.org.my/wp-content/uploads/2021/08/CozyHomes_Logo.png"),
        ("smplrspace", "https://proptech.org.my/wp-content/uploads/2021/08/SmplrSpace_Logo.png"),
        ("widebed", "https://proptech.org.my/wp-content/uploads/2021/08/WideBed_Logo.png"),
        ("salescandy", "https://proptech.org.my/wp-content/uploads/2021/08/SalesCandy_Logo.png"),
        ("hostplatform", "https://proptech.org.my/wp-content/uploads/2021/08/HostPlatform_Logo.png"),
        ("1balcony", "https://proptech.org.my/wp-content/uploads/2021/08/1Balcony_Logo.png"),
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
        ("estate-123", "https://proptech.org.my/wp-content/uploads/2021/08/Estate123_Logo.png"),
        ("dax", "https://proptech.org.my/wp-content/uploads/2021/08/DASB_Logo.png"),
        ("bwave", "https://proptech.org.my/wp-content/uploads/2021/08/bwave_Logo.png"),
        ("briq-bloq", "https://proptech.org.my/wp-content/uploads/2021/08/Briq_Bloq_Logo.png"),
        ("alphacore-technology", "https://proptech.org.my/wp-content/uploads/2022/04/AlphaCoreTech-01.png"),
        ("fusionqb", "https://proptech.org.my/wp-content/uploads/2021/08/FusionQB_Logo-01.png"),
        ("hck-properties", "https://proptech.org.my/wp-content/uploads/2022/09/33.HCK-Properties.png"),
    ]
    
    # Create assets directory if it doesn't exist
    os.makedirs("mark9/assets", exist_ok=True)
    
    downloaded_count = 0
    failed_count = 0
    
    for company, logo_url in logos:
        try:
            # Check if file already exists
            parsed_url = urlparse(logo_url)
            filename = os.path.basename(parsed_url.path)
            extension = os.path.splitext(filename)[1]
            output_path = f"mark9/assets/{company}-logo{extension}"
            
            if os.path.exists(output_path):
                print(f"Already exists: {company} -> {output_path}")
                continue
            
            # Download logo
            response = requests.get(logo_url, timeout=10)
            if response.status_code == 200:
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
    download_all_logos()

#!/usr/bin/env python3
import os
import re
import requests
from urllib.parse import urljoin, urlparse

def download_logos():
    # Company logos to download
    logos = [
        ("1balcony", "https://proptech.org.my/wp-content/uploads/2021/08/1Balcony_Logo.png"),
        ("alphacore-technology", "https://proptech.org.my/wp-content/uploads/2022/04/AlphaCoreTech-01.png"),
        ("briq-bloq", "https://proptech.org.my/wp-content/uploads/2021/08/Briq_Bloq_Logo.png"),
        ("bwave", "https://proptech.org.my/wp-content/uploads/2021/08/bwave_Logo.png"),
        ("cozyhomes", "https://proptech.org.my/wp-content/uploads/2021/08/CozyHomes_Logo.png"),
        ("dax", "https://proptech.org.my/wp-content/uploads/2021/08/DASB_Logo.png"),
        ("estate-123", "https://proptech.org.my/wp-content/uploads/2021/08/Estate123_Logo.png"),
        ("fusionqb", "https://proptech.org.my/wp-content/uploads/2021/08/FusionQB_Logo-01.png"),
        ("hck-properties", "https://proptech.org.my/wp-content/uploads/2022/09/33.HCK-Properties.png"),
        ("heyprop", "https://proptech.org.my/wp-content/uploads/2021/08/HeyProp_Logo.png"),
        ("hostplatform", "https://proptech.org.my/wp-content/uploads/2021/08/HostPlatform_Logo.png"),
        ("ineighbour", "https://proptech.org.my/wp-content/uploads/2021/08/iNeighbour_Logo.png"),
        ("isolutions", "https://proptech.org.my/wp-content/uploads/2021/08/iSolutions_Logo.png"),
        ("linkzzapp-pro", "https://proptech.org.my/wp-content/uploads/2021/08/LinkzzApp_Logo.png"),
        ("mandarin-fox", "https://proptech.org.my/wp-content/uploads/2021/08/MandarinFox_Logo.png"),
        ("mhub", "https://proptech.org.my/wp-content/uploads/2021/08/MHub_Logo.png"),
        ("myliving-mylife", "https://proptech.org.my/wp-content/uploads/2021/08/MyLiving_Logo.png"),
        ("nextsix-property", "https://proptech.org.my/wp-content/uploads/2021/08/NextSix_Logo.png"),
        ("novo-reperio", "https://proptech.org.my/wp-content/uploads/2021/08/NovoReperio_Logo.png"),
        ("propenomy", "https://proptech.org.my/wp-content/uploads/2021/08/Propenomy_Logo.png"),
        ("properly", "https://proptech.org.my/wp-content/uploads/2021/08/Properly_Logo.png"),
        ("property-hunter", "https://proptech.org.my/wp-content/uploads/2021/08/PropertyHunter_Logo.png"),
        ("prosales", "https://proptech.org.my/wp-content/uploads/2021/08/ProSales_Logo.png"),
        ("rekatone-com", "https://proptech.org.my/wp-content/uploads/2021/08/Rekatone_Logo.png"),
        ("rentlab", "https://proptech.org.my/wp-content/uploads/2021/08/RentLab_Logo.png"),
        ("salescandy", "https://proptech.org.my/wp-content/uploads/2021/08/SalesCandy_Logo.png"),
        ("servedeck", "https://proptech.org.my/wp-content/uploads/2021/08/ServeDeck_Logo.png"),
        ("smplrspace", "https://proptech.org.my/wp-content/uploads/2021/08/SmplrSpace_Logo.png"),
        ("softwareone-experts", "https://proptech.org.my/wp-content/uploads/2021/08/SoftwareOne_Logo.png"),
        ("squarefeet-pro", "https://proptech.org.my/wp-content/uploads/2021/08/SquareFeet_Logo.png"),
        ("tplus", "https://proptech.org.my/wp-content/uploads/2021/08/TPlus_Logo.png"),
        ("vendfun-sdn-bhd", "https://proptech.org.my/wp-content/uploads/2021/08/VendFun_Logo.png"),
        ("widebed", "https://proptech.org.my/wp-content/uploads/2021/08/WideBed_Logo.png"),
    ]
    
    # Create assets directory if it doesn't exist
    os.makedirs("mark9/assets", exist_ok=True)
    
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
            else:
                print(f"Failed to download {company}: {response.status_code}")
        except Exception as e:
            print(f"Error downloading {company}: {e}")

if __name__ == "__main__":
    download_logos()

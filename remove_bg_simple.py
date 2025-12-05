#!/usr/bin/env python3
"""
Simple script to remove checkerboard/transparent background from an image
Uses PIL to detect and remove the checkerboard pattern
"""

from PIL import Image
import sys
import os

def remove_checkerboard_background(input_path, output_path):
    """Remove checkerboard background and make it transparent"""
    print("🔄 Removing checkerboard background...")
    
    # Open image
    img = Image.open(input_path)
    
    # Convert to RGBA if not already
    if img.mode != 'RGBA':
        img = img.convert('RGBA')
    
    # Get image data
    data = img.getdata()
    
    # Create new image data
    new_data = []
    
    # Checkerboard colors are typically:
    # Light gray: around (200, 200, 200) or (128, 128, 128)
    # White: (255, 255, 255)
    # Dark gray: around (100, 100, 100) or (64, 64, 64)
    
    for item in data:
        r, g, b, a = item
        
        # Check if pixel is part of checkerboard (gray/white pattern)
        # Checkerboard pixels are typically very similar R, G, B values
        gray_threshold = 20  # Allow some variation
        is_gray = abs(r - g) < gray_threshold and abs(g - b) < gray_threshold
        
        # Check if it's a light or medium gray (typical checkerboard colors)
        if is_gray and (r > 80 and r < 220):
            # Make transparent
            new_data.append((r, g, b, 0))
        elif r > 240 and g > 240 and b > 240:  # Very light/white
            # Make transparent
            new_data.append((r, g, b, 0))
        else:
            # Keep the pixel
            new_data.append(item)
    
    # Create new image with transparent background
    img.putdata(new_data)
    
    # Save with transparency
    img.save(output_path, "PNG")
    print(f"✅ Background removed and saved to: {output_path}")
    
    return output_path

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("Usage: python remove_bg_simple.py <input_image> [output_image]")
        sys.exit(1)
    
    input_path = os.path.abspath(sys.argv[1])
    
    if len(sys.argv) >= 3:
        output_path = os.path.abspath(sys.argv[2])
    else:
        # Default output: same name with _transparent suffix
        base_name = os.path.splitext(input_path)[0]
        output_path = f"{base_name}_transparent.png"
    
    if not os.path.exists(input_path):
        print(f"❌ Error: Input file '{input_path}' not found!")
        sys.exit(1)
    
    try:
        remove_checkerboard_background(input_path, output_path)
        print(f"🎉 Done! Transparent image saved to: {output_path}")
    except Exception as e:
        print(f"❌ Error: {str(e)}")
        import traceback
        traceback.print_exc()
        sys.exit(1)


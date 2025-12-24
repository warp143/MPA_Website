#!/usr/bin/env python3
"""
Auto-crop image to remove transparent/empty borders
"""

from PIL import Image
import numpy as np
import sys
import os

def auto_crop(input_path, output_path, padding=0):
    """Crop image to remove transparent/empty borders"""
    print("🔄 Auto-cropping image...")
    
    # Open image
    img = Image.open(input_path)
    
    # Convert to RGBA if not already
    if img.mode != 'RGBA':
        img = img.convert('RGBA')
    
    # Convert to numpy array
    img_array = np.array(img)
    height, width = img_array.shape[:2]
    
    # Find bounding box of non-transparent pixels
    # Get alpha channel
    alpha = img_array[:, :, 3]
    
    # Find rows and columns that have at least one non-transparent pixel
    rows = np.any(alpha > 0, axis=1)
    cols = np.any(alpha > 0, axis=0)
    
    if not np.any(rows) or not np.any(cols):
        print("⚠️  Warning: Image appears to be fully transparent!")
        return input_path
    
    # Find bounding box
    top = np.argmax(rows)
    bottom = len(rows) - np.argmax(rows[::-1])
    left = np.argmax(cols)
    right = len(cols) - np.argmax(cols[::-1])
    
    # Add padding if requested
    if padding > 0:
        top = max(0, top - padding)
        bottom = min(height, bottom + padding)
        left = max(0, left - padding)
        right = min(width, right + padding)
    
    # Crop the image
    cropped = img.crop((left, top, right, bottom))
    
    # Save cropped image
    cropped.save(output_path, "PNG", optimize=True)
    
    original_size = f"{width}x{height}"
    new_size = f"{right-left}x{bottom-top}"
    print(f"✅ Image cropped: {original_size} → {new_size}")
    print(f"   Removed: {width - (right-left)}px width, {height - (bottom-top)}px height")
    print(f"✅ Saved to: {output_path}")
    
    return output_path

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("Usage: python crop_image.py <input_image> [output_image] [padding]")
        print("  padding: Extra pixels to keep around edges (default: 0)")
        sys.exit(1)
    
    input_path = os.path.abspath(sys.argv[1])
    
    if len(sys.argv) >= 3:
        output_path = os.path.abspath(sys.argv[2])
    else:
        base_name = os.path.splitext(input_path)[0]
        ext = os.path.splitext(input_path)[1]
        output_path = f"{base_name}_cropped{ext}"
    
    padding = 0
    if len(sys.argv) >= 4:
        try:
            padding = int(sys.argv[3])
        except ValueError:
            print("Warning: Invalid padding value, using default 0")
    
    if not os.path.exists(input_path):
        print(f"❌ Error: Input file '{input_path}' not found!")
        sys.exit(1)
    
    try:
        auto_crop(input_path, output_path, padding)
        print(f"🎉 Done! Cropped image saved to: {output_path}")
    except Exception as e:
        print(f"❌ Error: {str(e)}")
        import traceback
        traceback.print_exc()
        sys.exit(1)









#!/usr/bin/env python3
"""
Advanced background removal script using edge detection and color analysis
"""

from PIL import Image
import numpy as np
import sys
import os

def remove_background_advanced(input_path, output_path):
    """Remove background using advanced edge detection and color analysis"""
    print("🔄 Removing background with advanced method...")
    
    # Open image
    img = Image.open(input_path)
    
    # Convert to RGBA if not already
    if img.mode != 'RGBA':
        img = img.convert('RGBA')
    
    # Convert to numpy array
    img_array = np.array(img)
    
    # Get dimensions
    height, width = img_array.shape[:2]
    
    # Create alpha channel
    alpha = img_array[:, :, 3].copy()
    
    # Method 1: Remove checkerboard pattern (gray squares)
    # Checkerboard typically has similar R, G, B values (gray)
    gray_mask = np.abs(img_array[:, :, 0] - img_array[:, :, 1]) < 15
    gray_mask = gray_mask & (np.abs(img_array[:, :, 1] - img_array[:, :, 2]) < 15)
    
    # Check if gray values are in checkerboard range (typically 100-220)
    gray_values = img_array[:, :, 0]  # Use red channel as proxy
    checkerboard_mask = gray_mask & (gray_values > 80) & (gray_values < 230)
    
    # Method 2: Remove very light/white areas (checkerboard white squares)
    white_mask = (img_array[:, :, 0] > 240) & (img_array[:, :, 1] > 240) & (img_array[:, :, 2] > 240)
    
    # Method 3: Edge detection - keep pixels that are significantly different from neighbors
    # This helps preserve the battery icon edges
    edge_mask = np.zeros((height, width), dtype=bool)
    
    # Check each pixel against its neighbors
    for y in range(1, height - 1):
        for x in range(1, width - 1):
            center = img_array[y, x, :3]
            neighbors = [
                img_array[y-1, x, :3],
                img_array[y+1, x, :3],
                img_array[y, x-1, :3],
                img_array[y, x+1, :3]
            ]
            
            # Calculate color difference
            max_diff = max([np.linalg.norm(center - n) for n in neighbors])
            
            # If there's significant color difference, it's likely part of the object
            if max_diff > 30:
                edge_mask[y, x] = True
    
    # Combine masks: remove background but keep edges
    # Remove checkerboard and white, but preserve edge areas
    background_mask = (checkerboard_mask | white_mask) & ~edge_mask
    
    # Also check corners and edges of image (likely background)
    border_size = min(10, width // 20, height // 20)
    border_mask = np.zeros((height, width), dtype=bool)
    border_mask[:border_size, :] = True  # Top
    border_mask[-border_size:, :] = True  # Bottom
    border_mask[:, :border_size] = True  # Left
    border_mask[:, -border_size:] = True  # Right
    
    # Combine all background masks
    final_background = background_mask | (border_mask & (checkerboard_mask | white_mask))
    
    # Apply transparency
    alpha[final_background] = 0
    
    # Update alpha channel
    img_array[:, :, 3] = alpha
    
    # Convert back to PIL Image
    result_img = Image.fromarray(img_array, 'RGBA')
    
    # Save with transparency
    result_img.save(output_path, "PNG", optimize=True)
    print(f"✅ Background removed and saved to: {output_path}")
    
    return output_path

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("Usage: python remove_bg_advanced.py <input_image> [output_image]")
        sys.exit(1)
    
    input_path = os.path.abspath(sys.argv[1])
    
    if len(sys.argv) >= 3:
        output_path = os.path.abspath(sys.argv[2])
    else:
        base_name = os.path.splitext(input_path)[0]
        output_path = f"{base_name}_transparent.png"
    
    if not os.path.exists(input_path):
        print(f"❌ Error: Input file '{input_path}' not found!")
        sys.exit(1)
    
    try:
        remove_background_advanced(input_path, output_path)
        print(f"🎉 Done! Transparent image saved to: {output_path}")
    except Exception as e:
        print(f"❌ Error: {str(e)}")
        import traceback
        traceback.print_exc()
        sys.exit(1)









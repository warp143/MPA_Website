#!/usr/bin/env python3
"""
Background removal using flood fill from edges - best for checkerboard backgrounds
"""

from PIL import Image
import numpy as np
from scipy import ndimage
import sys
import os

def remove_background_floodfill(input_path, output_path):
    """Remove background using flood fill from image edges"""
    print("🔄 Removing background with flood fill method...")
    
    # Open image
    img = Image.open(input_path)
    original_mode = img.mode
    
    # Convert to RGBA
    if img.mode != 'RGBA':
        img = img.convert('RGBA')
    
    # Convert to numpy array
    img_array = np.array(img)
    height, width = img_array.shape[:2]
    
    # Create a mask for background removal
    # Start with all pixels as background (True = background, False = foreground)
    background_mask = np.ones((height, width), dtype=bool)
    
    # Convert to grayscale for analysis
    gray = np.dot(img_array[...,:3], [0.299, 0.587, 0.114])
    
    # Method: Flood fill from edges
    # Checkerboard squares are typically gray/white, so we'll remove those
    
    # Create edge seeds (pixels at the border)
    edge_seeds = np.zeros((height, width), dtype=bool)
    border_size = 2
    edge_seeds[:border_size, :] = True
    edge_seeds[-border_size:, :] = True
    edge_seeds[:, :border_size] = True
    edge_seeds[:, -border_size:] = True
    
    # For each edge pixel, flood fill similar colored pixels
    # Checkerboard typically has gray values between 100-220
    visited = np.zeros((height, width), dtype=bool)
    
    def flood_fill(start_y, start_x, threshold=25):
        """Flood fill from a starting point with color similarity threshold"""
        stack = [(start_y, start_x)]
        start_color = gray[start_y, start_x]
        filled = np.zeros((height, width), dtype=bool)
        
        while stack:
            y, x = stack.pop()
            
            if y < 0 or y >= height or x < 0 or x >= width:
                continue
            if visited[y, x] or filled[y, x]:
                continue
            
            # Check if color is similar (checkerboard pattern)
            color_diff = abs(gray[y, x] - start_color)
            is_gray = abs(img_array[y, x, 0] - img_array[y, x, 1]) < 20 and \
                     abs(img_array[y, x, 1] - img_array[y, x, 2]) < 20
            
            # If it's a gray/checkerboard pixel, mark as background
            if color_diff < threshold or (is_gray and 80 < gray[y, x] < 230):
                filled[y, x] = True
                visited[y, x] = True
                background_mask[y, x] = True
                
                # Add neighbors
                stack.append((y-1, x))
                stack.append((y+1, x))
                stack.append((y, x-1))
                stack.append((y, x+1))
    
    # Flood fill from edge pixels
    print("   Flood filling from edges...")
    for y in range(height):
        for x in range(width):
            if edge_seeds[y, x] and not visited[y, x]:
                flood_fill(y, x)
    
    # Also remove very light/white areas that are likely background
    white_areas = (img_array[:, :, 0] > 245) & (img_array[:, :, 1] > 245) & (img_array[:, :, 2] > 245)
    background_mask = background_mask | white_areas
    
    # Apply morphological operations to clean up the mask
    # Remove small holes in foreground
    from scipy.ndimage import binary_fill_holes, binary_erosion, binary_dilation
    
    # Invert mask (True = foreground, False = background)
    foreground_mask = ~background_mask
    
    # Fill small holes
    foreground_mask = binary_fill_holes(foreground_mask)
    
    # Slight erosion to remove edge artifacts, then dilation to restore
    foreground_mask = binary_erosion(foreground_mask, iterations=1)
    foreground_mask = binary_dilation(foreground_mask, iterations=2)
    
    # Convert back to background mask
    background_mask = ~foreground_mask
    
    # Apply transparency
    alpha = img_array[:, :, 3].copy()
    alpha[background_mask] = 0
    
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
        print("Usage: python remove_bg_floodfill.py <input_image> [output_image]")
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
        remove_background_floodfill(input_path, output_path)
        print(f"🎉 Done! Transparent image saved to: {output_path}")
    except ImportError as e:
        if 'scipy' in str(e):
            print("❌ Error: scipy is required. Install it with: pip3 install scipy")
        else:
            print(f"❌ Error: {str(e)}")
        sys.exit(1)
    except Exception as e:
        print(f"❌ Error: {str(e)}")
        import traceback
        traceback.print_exc()
        sys.exit(1)








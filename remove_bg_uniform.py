#!/usr/bin/env python3
"""
Background removal for images with uniform/solid color backgrounds
"""

from PIL import Image
import numpy as np
import sys
import os

def remove_uniform_background(input_path, output_path, tolerance=30):
    """Remove uniform background color using color similarity"""
    print("🔄 Removing uniform background...")
    
    # Open image
    img = Image.open(input_path)
    
    # Convert to RGBA
    if img.mode != 'RGBA':
        img = img.convert('RGBA')
    
    # Convert to numpy array
    img_array = np.array(img)
    height, width = img_array.shape[:2]
    
    # Sample background color from corners (most reliable for uniform backgrounds)
    corner_size = min(20, width // 10, height // 10)
    corners = [
        img_array[:corner_size, :corner_size],  # Top-left
        img_array[:corner_size, -corner_size:],  # Top-right
        img_array[-corner_size:, :corner_size],  # Bottom-left
        img_array[-corner_size:, -corner_size:]  # Bottom-right
    ]
    
    # Calculate average background color from corners
    bg_colors = []
    for corner in corners:
        # Get average RGB (ignore alpha)
        avg_r = np.mean(corner[:, :, 0])
        avg_g = np.mean(corner[:, :, 1])
        avg_b = np.mean(corner[:, :, 2])
        bg_colors.append([avg_r, avg_g, avg_b])
    
    # Use median to avoid outliers
    bg_color = np.median(bg_colors, axis=0)
    print(f"   Detected background color: RGB({int(bg_color[0])}, {int(bg_color[1])}, {int(bg_color[2])})")
    
    # Create mask for background pixels
    # Calculate color distance for each pixel
    r_diff = np.abs(img_array[:, :, 0].astype(float) - bg_color[0])
    g_diff = np.abs(img_array[:, :, 1].astype(float) - bg_color[1])
    b_diff = np.abs(img_array[:, :, 2].astype(float) - bg_color[2])
    
    # Euclidean distance
    color_distance = np.sqrt(r_diff**2 + g_diff**2 + b_diff**2)
    
    # Mark pixels as background if they're similar to background color
    background_mask = color_distance < tolerance
    
    # Also check edges - if edges are mostly background, remove them
    edge_pixels = np.concatenate([
        img_array[0, :, :3].reshape(-1, 3),  # Top edge
        img_array[-1, :, :3].reshape(-1, 3),  # Bottom edge
        img_array[:, 0, :3].reshape(-1, 3),  # Left edge
        img_array[:, -1, :3].reshape(-1, 3)  # Right edge
    ])
    
    # Check if edges are mostly background
    edge_distances = np.array([
        np.sqrt(np.sum((pixel - bg_color)**2)) for pixel in edge_pixels
    ])
    edge_bg_ratio = np.sum(edge_distances < tolerance) / len(edge_distances)
    
    if edge_bg_ratio > 0.7:  # If 70%+ of edges are background
        # Remove border areas that match background
        border_size = min(5, width // 20, height // 20)
        border_mask = np.zeros((height, width), dtype=bool)
        border_mask[:border_size, :] = True
        border_mask[-border_size:, :] = True
        border_mask[:, :border_size] = True
        border_mask[:, -border_size:] = True
        
        # Combine with background mask
        background_mask = background_mask | (border_mask & (color_distance < tolerance * 1.5))
    
    # Apply feathering to edges for smoother transitions
    # Create alpha channel
    alpha = img_array[:, :, 3].copy().astype(float)
    
    # Set background to transparent
    alpha[background_mask] = 0
    
    # Feather edges (smooth transition at boundaries) - simple version without scipy
    # Apply gradual transparency near edges
    for y in range(height):
        for x in range(width):
            if not background_mask[y, x]:  # If not fully background
                # Calculate distance from background color
                dist = color_distance[y, x]
                if dist < tolerance * 1.5:  # In transition zone
                    # Gradual fade
                    fade = min(1.0, (dist - tolerance) / (tolerance * 0.5))
                    fade = max(0.0, fade)  # Ensure non-negative
                    alpha[y, x] = int(255 * fade)
                else:
                    # Fully opaque
                    alpha[y, x] = 255
    
    # Ensure alpha is in valid range
    alpha = np.clip(alpha, 0, 255).astype(np.uint8)
    
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
        print("Usage: python remove_bg_uniform.py <input_image> [output_image] [tolerance]")
        print("  tolerance: Color similarity threshold (default: 30, higher = more aggressive)")
        sys.exit(1)
    
    input_path = os.path.abspath(sys.argv[1])
    
    if len(sys.argv) >= 3:
        output_path = os.path.abspath(sys.argv[2])
    else:
        base_name = os.path.splitext(input_path)[0]
        output_path = f"{base_name}_transparent.png"
    
    tolerance = 30
    if len(sys.argv) >= 4:
        try:
            tolerance = int(sys.argv[3])
        except ValueError:
            print("Warning: Invalid tolerance value, using default 30")
    
    if not os.path.exists(input_path):
        print(f"❌ Error: Input file '{input_path}' not found!")
        sys.exit(1)
    
    try:
        remove_uniform_background(input_path, output_path, tolerance)
        print(f"🎉 Done! Transparent image saved to: {output_path}")
    except Exception as e:
        print(f"❌ Error: {str(e)}")
        import traceback
        traceback.print_exc()
        sys.exit(1)


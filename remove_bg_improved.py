#!/usr/bin/env python3
"""
Improved background removal that handles vignettes and preserves glass/transparent objects
"""

from PIL import Image
import numpy as np
import sys
import os

def remove_background_improved(input_path, output_path, tolerance=25):
    """Remove background while preserving glass/transparent objects"""
    print("🔄 Removing background (improved method)...")
    
    # Open image
    img = Image.open(input_path)
    
    # Convert to RGBA
    if img.mode != 'RGBA':
        img = img.convert('RGBA')
    
    # Convert to numpy array
    img_array = np.array(img)
    height, width = img_array.shape[:2]
    
    # Sample background from corners AND edges (avoiding the center object)
    # The object is in the center, so sample from perimeter
    corner_size = min(30, width // 8, height // 8)
    edge_width = min(20, width // 10, height // 10)
    
    # Sample from all four corners
    corners = [
        img_array[:corner_size, :corner_size],  # Top-left
        img_array[:corner_size, -corner_size:],  # Top-right
        img_array[-corner_size:, :corner_size],  # Bottom-left
        img_array[-corner_size:, -corner_size:]  # Bottom-right
    ]
    
    # Also sample from edges (but not too close to center)
    edge_samples = []
    # Top edge (middle portion)
    if width > 100:
        edge_samples.append(img_array[:edge_width, width//4:3*width//4])
    # Bottom edge
    if width > 100:
        edge_samples.append(img_array[-edge_width:, width//4:3*width//4])
    # Left edge
    if height > 100:
        edge_samples.append(img_array[height//4:3*height//4, :edge_width])
    # Right edge
    if height > 100:
        edge_samples.append(img_array[height//4:3*height//4, -edge_width:])
    
    # Combine all samples
    all_samples = []
    for corner in corners:
        all_samples.append(corner[:, :, :3].reshape(-1, 3))
    for edge in edge_samples:
        all_samples.append(edge[:, :, :3].reshape(-1, 3))
    
    all_pixels = np.concatenate(all_samples, axis=0)
    
    # Filter out non-gray pixels (the object might have some color in corners)
    # Background should be gray (similar R, G, B values)
    gray_mask = np.abs(all_pixels[:, 0] - all_pixels[:, 1]) < 20
    gray_mask = gray_mask & (np.abs(all_pixels[:, 1] - all_pixels[:, 2]) < 20)
    gray_pixels = all_pixels[gray_mask]
    
    if len(gray_pixels) > 0:
        # Use median to avoid outliers
        bg_color = np.median(gray_pixels, axis=0)
    else:
        # Fallback: use mean of all samples
        bg_color = np.median(all_pixels, axis=0)
    print(f"   Detected background color: RGB({int(bg_color[0])}, {int(bg_color[1])}, {int(bg_color[2])})")
    
    # Calculate color distance for each pixel
    r_diff = np.abs(img_array[:, :, 0].astype(float) - bg_color[0])
    g_diff = np.abs(img_array[:, :, 1].astype(float) - bg_color[1])
    b_diff = np.abs(img_array[:, :, 2].astype(float) - bg_color[2])
    color_distance = np.sqrt(r_diff**2 + g_diff**2 + b_diff**2)
    
    # Create initial background mask
    background_mask = color_distance < tolerance
    
    # IMPORTANT: Preserve edges and high-contrast areas (the glass container)
    # Calculate edge strength using Sobel-like operator
    gray = np.dot(img_array[...,:3], [0.299, 0.587, 0.114])
    
    # Simple edge detection
    edge_strength = np.zeros((height, width))
    for y in range(1, height - 1):
        for x in range(1, width - 1):
            # Calculate gradient
            gx = abs(float(gray[y, x+1]) - float(gray[y, x-1]))
            gy = abs(float(gray[y+1, x]) - float(gray[y-1, x]))
            edge_strength[y, x] = np.sqrt(gx**2 + gy**2)
    
    # Normalize edge strength
    if edge_strength.max() > 0:
        edge_strength = edge_strength / edge_strength.max()
    
    # Preserve areas with strong edges (likely part of the object)
    edge_threshold = 0.15  # Adjust this to be more/less aggressive
    strong_edges = edge_strength > edge_threshold
    
    # Also preserve areas with high color saturation (the green liquid)
    saturation = np.zeros((height, width))
    for y in range(height):
        for x in range(width):
            r, g, b = img_array[y, x, :3]
            max_val = max(r, g, b)
            min_val = min(r, g, b)
            if max_val > 0:
                saturation[y, x] = (max_val - min_val) / max_val
    
    # Preserve highly saturated colors (like the green liquid)
    high_saturation = saturation > 0.3
    
    # Preserve bright/reflective areas (glass highlights)
    brightness = np.mean(img_array[:, :, :3], axis=2)
    bright_areas = brightness > 200
    
    # Combine preservation masks
    preserve_mask = strong_edges | high_saturation | bright_areas
    
    # Remove background BUT preserve important areas
    background_mask = background_mask & ~preserve_mask
    
    # Handle vignette: remove dark edges that are still background-like
    # But be careful not to remove the shadow under the object
    edge_pixels = np.concatenate([
        img_array[0, :, :3].reshape(-1, 3),  # Top edge
        img_array[-1, :, :3].reshape(-1, 3),  # Bottom edge
        img_array[:, 0, :3].reshape(-1, 3),  # Left edge
        img_array[:, -1, :3].reshape(-1, 3)  # Right edge
    ])
    
    edge_distances = np.array([
        np.sqrt(np.sum((pixel - bg_color)**2)) for pixel in edge_pixels
    ])
    
    # Remove border if it's mostly background (but not if it has strong edges)
    border_size = min(10, width // 15, height // 15)
    border_mask = np.zeros((height, width), dtype=bool)
    border_mask[:border_size, :] = True
    border_mask[-border_size:, :] = True
    border_mask[:, :border_size] = True
    border_mask[:, -border_size:] = True
    
    # Only remove border if it's background AND not near edges
    border_background = border_mask & (color_distance < tolerance * 1.2) & ~preserve_mask
    background_mask = background_mask | border_background
    
    # Create alpha channel
    alpha = img_array[:, :, 3].copy().astype(float)
    
    # Set background to transparent
    alpha[background_mask] = 0
    
    # Smooth transition at edges (anti-aliasing)
    # For pixels near the edge of the mask, create gradual transparency
    transition_zone = color_distance < tolerance * 1.8
    transition_zone = transition_zone & ~background_mask  # Only for non-background pixels
    
    for y in range(height):
        for x in range(width):
            if transition_zone[y, x]:
                dist = color_distance[y, x]
                # Create smooth fade
                fade_start = tolerance
                fade_end = tolerance * 1.8
                if fade_end > fade_start:
                    fade = (dist - fade_start) / (fade_end - fade_start)
                    fade = np.clip(fade, 0, 1)
                    alpha[y, x] = int(255 * fade)
            elif not background_mask[y, x]:
                alpha[y, x] = 255  # Fully opaque
    
    # Ensure alpha is valid
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
        print("Usage: python remove_bg_improved.py <input_image> [output_image] [tolerance]")
        print("  tolerance: Color similarity threshold (default: 25, lower = more precise)")
        sys.exit(1)
    
    input_path = os.path.abspath(sys.argv[1])
    
    if len(sys.argv) >= 3:
        output_path = os.path.abspath(sys.argv[2])
    else:
        base_name = os.path.splitext(input_path)[0]
        output_path = f"{base_name}_transparent.png"
    
    tolerance = 25
    if len(sys.argv) >= 4:
        try:
            tolerance = int(sys.argv[3])
        except ValueError:
            print("Warning: Invalid tolerance value, using default 25")
    
    if not os.path.exists(input_path):
        print(f"❌ Error: Input file '{input_path}' not found!")
        sys.exit(1)
    
    try:
        remove_background_improved(input_path, output_path, tolerance)
        print(f"🎉 Done! Transparent image saved to: {output_path}")
    except Exception as e:
        print(f"❌ Error: {str(e)}")
        import traceback
        traceback.print_exc()
        sys.exit(1)


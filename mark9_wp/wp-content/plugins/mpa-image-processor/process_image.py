#!/usr/bin/env python3
"""
Image Processing Script for Committee Member Photos
- Removes background and makes it transparent
- Respects user's crop selection (no additional cropping)
- Reduces file size to under 2MB
"""

import cv2
import numpy as np
from PIL import Image, ImageEnhance
import os
from rembg import remove
import argparse

def remove_background(input_path, output_path):
    """Remove background using rembg library"""
    print("🔄 Removing background...")
    
    # Read image
    input_image = Image.open(input_path)
    
    # Remove background
    output_image = remove(input_image)
    
    # Save with transparency
    output_image.save(output_path, "PNG")
    print(f"✅ Background removed and saved to: {output_path}")
    
    return output_path

def crop_upper_half(image_path, output_path):
    """Crop image to show only upper half of body with better face focus"""
    print("✂️ Cropping to upper half...")
    
    # Open image
    img = Image.open(image_path)
    
    # Get dimensions
    width, height = img.size
    
    # For better face focus, start from the very top and go to 80% down
    # This keeps the full head and shows more of upper body
    start_y = 0                    # Start from the very top (0%)
    end_y = int(height * 0.80)    # End 80% from top
    
    cropped_img = img.crop((0, start_y, width, end_y))
    
    # Save cropped image
    cropped_img.save(output_path, "PNG")
    print(f"✅ Cropped image saved to: {output_path}")
    
    return output_path

def reduce_file_size(image_path, output_path, target_size_mb=2.0):
    """Reduce file size while maintaining quality"""
    print("📦 Reducing file size...")
    
    # Open image
    img = Image.open(image_path)
    
    # Convert to RGBA if not already
    if img.mode != 'RGBA':
        img = img.convert('RGBA')
    
    # Start with original size
    quality = 95
    scale_factor = 1.0
    
    while True:
        # Create a copy to work with
        working_img = img.copy()
        
        # Scale down if needed
        if scale_factor < 1.0:
            new_width = int(img.width * scale_factor)
            new_height = int(img.height * scale_factor)
            working_img = working_img.resize((new_width, new_height), Image.Resampling.LANCZOS)
        
        # Save with current quality
        temp_path = "temp_quality_test.png"
        working_img.save(temp_path, "PNG", optimize=True)
        
        # Check file size
        file_size_mb = os.path.getsize(temp_path) / (1024 * 1024)
        
        print(f"   Testing: Quality={quality}, Scale={scale_factor:.2f}, Size={file_size_mb:.2f}MB")
        
        if file_size_mb <= target_size_mb:
            # We're under target size, save the final version
            working_img.save(output_path, "PNG", optimize=True)
            os.remove(temp_path)
            print(f"✅ Final image saved: {file_size_mb:.2f}MB")
            break
        
        # Reduce quality or scale
        if quality > 20:
            quality -= 5
        elif scale_factor > 0.3:
            scale_factor -= 0.1
        else:
            # We can't reduce further, save what we have
            working_img.save(output_path, "PNG", optimize=True)
            os.remove(temp_path)
            print(f"⚠️ Could not reach target size. Final size: {file_size_mb:.2f}MB")
            break
    
    return output_path

def enhance_image(image_path, output_path):
    """Enhance image quality after processing"""
    print("✨ Enhancing image quality...")
    
    # Open image
    img = Image.open(image_path)
    
    # Enhance contrast slightly
    enhancer = ImageEnhance.Contrast(img)
    img = enhancer.enhance(1.1)
    
    # Enhance sharpness
    enhancer = ImageEnhance.Sharpness(img)
    img = enhancer.enhance(1.2)
    
    # Save enhanced image
    img.save(output_path, "PNG", optimize=True)
    print(f"✅ Enhanced image saved to: {output_path}")
    
    return output_path

def main():
    parser = argparse.ArgumentParser(description="Process committee member image")
    parser.add_argument("input_image", help="Path to input image file")
    parser.add_argument("--output-dir", default="processed", help="Output directory (default: processed)")
    parser.add_argument("--target-size", type=float, default=2.0, help="Target file size in MB (default: 2.0)")
    
    args = parser.parse_args()
    
    # Check if input file exists
    if not os.path.exists(args.input_image):
        print(f"❌ Error: Input file '{args.input_image}' not found!")
        return
    
    # Create output directory
    os.makedirs(args.output_dir, exist_ok=True)
    
    # Generate output filenames
    base_name = os.path.splitext(os.path.basename(args.input_image))[0]
    no_bg_path = os.path.join(args.output_dir, f"{base_name}_no_bg.png")
    cropped_temp_path = os.path.join(args.output_dir, f"{base_name}_temp_cropped.png")
    final_path = os.path.join(args.output_dir, f"{base_name}_final.png")
    
    try:
        print("🚀 Starting image processing...")
        print(f"📁 Input: {args.input_image}")
        print(f"📁 Output directory: {args.output_dir}")
        print(f"🎯 Target size: {args.target_size}MB")
        print("-" * 50)
        
        # Step 1: Remove background
        remove_background(args.input_image, no_bg_path)
        
        # Step 2: Skip additional cropping - image is already cropped by user in browser
        print("⏭️  Skipping automatic cropping - using user's crop selection")
        # Just copy the background-removed image to the next step
        import shutil
        shutil.copy2(no_bg_path, cropped_temp_path)
        
        # Step 3: Reduce file size
        reduce_file_size(cropped_temp_path, final_path, args.target_size)
        
        # Step 4: Final enhancement - save as _cropped (not _enhanced)
        final_output_path = os.path.join(args.output_dir, f"{base_name}_cropped.png")
        enhance_image(final_path, final_output_path)
        
        # Clean up intermediate files (but keep the final output)
        os.remove(no_bg_path)
        if cropped_temp_path != final_output_path:
            os.remove(cropped_temp_path)
        os.remove(final_path)
        
        print("-" * 50)
        print("🎉 Image processing completed successfully!")
        print(f"📁 Final image: {final_output_path}")
        
        # Show final file size
        final_size_mb = os.path.getsize(final_output_path) / (1024 * 1024)
        print(f"📊 Final file size: {final_size_mb:.2f}MB")
        
    except Exception as e:
        print(f"❌ Error during processing: {str(e)}")
        return

if __name__ == "__main__":
    main()

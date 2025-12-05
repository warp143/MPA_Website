#!/usr/bin/env python3
"""
Simple script to remove background from an image and make it transparent
Uses the rembg CLI from the WordPress plugin's virtual environment
"""

import sys
import os
import subprocess

def remove_background(input_path, output_path):
    """Remove background using rembg CLI"""
    print("🔄 Removing background...")
    
    # Path to the plugin's virtual environment
    plugin_dir = "/Users/amk/Documents/GitHub/MPA_Website/mark9_wp/wp-content/plugins/mpa-image-processor"
    venv_site_packages = os.path.join(plugin_dir, "plugin_env/lib/python3.8/site-packages")
    
    if not os.path.exists(venv_site_packages):
        raise Exception("Virtual environment not found")
    
    # Use rembg CLI via rembg.cli
    for py_cmd in ['python3.9', 'python3']:
        try:
            env = os.environ.copy()
            env['PYTHONPATH'] = venv_site_packages + ':' + env.get('PYTHONPATH', '')
            
            # Use rembg.cli.main directly
            cmd = [
                py_cmd, '-c',
                f"import sys; sys.path.insert(0, '{venv_site_packages}'); "
                f"from rembg.cli import main; "
                f"sys.argv = ['rembg', 'i', '{os.path.abspath(input_path)}', '{os.path.abspath(output_path)}']; "
                f"main()"
            ]
            
            result = subprocess.run(
                cmd,
                env=env,
                capture_output=True,
                text=True,
                timeout=120
            )
            
            if result.returncode == 0:
                print(f"✅ Background removed and saved to: {output_path}")
                return output_path
            else:
                error_msg = result.stderr or result.stdout
                if "python3.9" in py_cmd:
                    # Try next Python version
                    continue
                else:
                    # Last attempt failed
                    raise Exception(f"rembg CLI failed: {error_msg}")
        except subprocess.TimeoutExpired:
            raise Exception("Process timed out after 2 minutes")
        except FileNotFoundError:
            if "python3.9" in py_cmd:
                continue
            raise Exception(f"Python command '{py_cmd}' not found")
        except Exception as e:
            if "python3.9" in py_cmd:
                continue
            raise e
    
    raise Exception("Failed to remove background with any Python version")

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("Usage: python remove_bg.py <input_image> [output_image]")
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
        remove_background(input_path, output_path)
        print(f"🎉 Done! Transparent image saved to: {output_path}")
    except Exception as e:
        print(f"❌ Error: {str(e)}")
        import traceback
        traceback.print_exc()
        sys.exit(1)

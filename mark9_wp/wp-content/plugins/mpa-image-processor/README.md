# MPA Image Processor

**AI-Powered Image Processing Plugin for WordPress**

A professional WordPress plugin designed specifically for the Malaysia PropTech Association (MPA) to process committee member photos with AI-powered background removal, intelligent cropping, and automatic optimization.

## 🎯 **Purpose**

This plugin streamlines the process of preparing committee member photos for the MPA website by:
- Automatically removing backgrounds using AI
- Providing intelligent cropping tools
- Optimizing images for web use
- Maintaining consistent image quality across the committee

## ✨ **Features**

### **Core Functionality**
- **AI Background Removal**: Uses advanced AI models to automatically remove backgrounds
- **Smart Cropping**: Interactive cropping with preset options (Head & Shoulders, Upper Body, Full Body)
- **Image Optimization**: Automatic compression and resizing for optimal web performance
- **Batch Processing**: Process multiple images efficiently
- **Media Library Integration**: Save processed images directly to WordPress media library

### **Technical Features**
- **Python Backend**: Powered by Python with AI libraries (rembg, OpenCV, Pillow)
- **Virtual Environment**: Isolated Python environment to prevent conflicts
- **AJAX Processing**: Asynchronous image processing for better user experience
- **Error Handling**: Comprehensive error handling and user feedback
- **Security**: WordPress nonce verification and user capability checks

## 🚀 **Installation**

### **Prerequisites**
- WordPress 5.0 or higher
- PHP 7.4 or higher
- Python 3.8 or higher
- Server with shell access (for Python environment setup)

### **Step 1: Plugin Installation**
1. Upload the `mpa-image-processor` folder to `/wp-content/plugins/`
2. Activate the plugin in WordPress admin
3. Navigate to **Image Processor** in the admin menu

### **Step 2: Python Environment Setup**
The plugin includes an automated setup script:

```bash
cd wp-content/plugins/mpa-image-processor
chmod +x setup-python-env.sh
./setup-python-env.sh
```

**What the setup script does:**
- Creates Python virtual environment (`plugin_env/`)
- Installs required Python packages:
  - `rembg` - AI background removal
  - `opencv-python` - Image processing
  - `Pillow` - Image manipulation
  - `numpy` - Numerical operations
  - `onnxruntime` - AI model runtime
- Creates output directory (`processed/`)
- Tests the installation

### **Step 3: Verification**
After setup, verify the installation:
1. Check that the **Image Processor** menu appears in WordPress admin
2. Upload a test image to ensure processing works
3. Verify Python environment is active (check for `(plugin_env)` in terminal)

## 📖 **Usage Guide**

### **Basic Workflow**

#### **1. Upload Image**
- Navigate to **Image Processor** in WordPress admin
- Click **Choose Image File** or drag & drop an image
- Supported formats: JPG, PNG
- Maximum size: 10MB (auto-compressed if larger)

#### **2. Crop Image**
- Use the interactive cropping tool to frame the image
- **Quick Presets:**
  - **Head & Shoulders**: Perfect for profile photos
  - **Upper Body**: Good for professional headshots
  - **Full Body**: Complete person view
- Manual adjustment available for precise control
- Click **Apply Crop** when satisfied

#### **3. Process Image**
- Click **Apply Crop** to start background removal
- AI processing begins automatically
- Progress bar shows processing status
- Background removal typically takes 10-30 seconds

#### **4. Save Results**
- **Save Processed Image Only**: Saves the background-removed image
- **Save Both Images**: Saves original and processed versions
- **Process Another Image**: Continue with next image

### **Advanced Features**

#### **Smart Upload & Compression**
- Large images automatically compressed to 1200px width
- Maintains aspect ratio and quality
- Reduces file size for faster processing

#### **Cropping Presets**
- **Head & Shoulders**: 70% width, 40% height, centered
- **Upper Body**: 80% width, 65% height, centered
- **Full Body**: 90% width, 96% height, minimal margins

#### **Quality Settings**
- Output format: PNG (transparent background)
- Target size: 2.0 (maintains aspect ratio)
- AI model: U2NET (state-of-the-art background removal)

## 🔧 **Configuration**

### **PHP Settings**
The plugin automatically increases PHP limits when active:
- `upload_max_filesize`: 50MB
- `post_max_size`: 50MB
- `max_execution_time`: 300 seconds
- `memory_limit`: 512MB

### **File Paths**
- **Upload Directory**: `/wp-content/uploads/mpa-processor/`
- **Processed Images**: `/wp-content/uploads/mpa-processor/processed/`
- **Python Environment**: `/wp-content/plugins/mpa-image-processor/plugin_env/`
- **Output Directory**: `/wp-content/plugins/mpa-image-processor/processed/`

### **Security Settings**
- **User Capability**: `manage_options` (administrators only)
- **Nonce Verification**: All AJAX requests verified
- **File Type Validation**: Only image files accepted
- **Path Sanitization**: All file paths sanitized

## 🐛 **Troubleshooting**

### **Common Issues**

#### **Python Environment Not Working**
```bash
# Check if virtual environment is active
source plugin_env/bin/activate

# Test Python packages
python -c "from rembg import remove; print('✅ Working')"

# Reinstall if needed
pip install -r requirements.txt
```

#### **Upload Failures**
- Check file size (max 10MB recommended)
- Verify file format (JPG, PNG only)
- Check server upload limits
- Ensure directory permissions (755 for folders, 644 for files)

#### **Background Removal Fails**
- Verify Python environment is active
- Check `processed/` directory exists
- Ensure sufficient server memory (512MB+)
- Check error logs in WordPress debug mode

#### **Cropping Tool Not Working**
- Verify Cropper.js is loaded (check browser console)
- Ensure jQuery is available
- Check for JavaScript conflicts with other plugins

### **Debug Mode**
Enable WordPress debug mode to see detailed error messages:
```php
// In wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

### **Log Files**
- **WordPress**: `/wp-content/debug.log`
- **PHP**: Check server error logs
- **Python**: Output displayed in WordPress admin

## 📁 **File Structure**

```
mpa-image-processor/
├── README.md                           # This documentation
├── mpa-image-processor-plugin.php      # Main WordPress plugin file
├── process_image.py                    # Python processing script
├── requirements.txt                    # Python dependencies
├── setup-python-env.sh                # Environment setup script
├── js/
│   └── processor.js                   # Frontend JavaScript
├── plugin_env/                         # Python virtual environment
│   ├── bin/                           # Python executables
│   ├── lib/                           # Python packages
│   └── pyvenv.cfg                     # Environment configuration
└── processed/                          # Output directory
    ├── Darren_Lim_cropped.png         # Example processed images
    ├── Dato_Joseph_cropped.png
    └── ...
```

## 🔒 **Security Considerations**

### **User Access Control**
- Only users with `manage_options` capability can access
- All AJAX requests require valid nonce tokens
- File uploads validated and sanitized

### **File System Security**
- Uploads restricted to designated directories
- File types validated before processing
- Path traversal attacks prevented

### **Python Environment**
- Virtual environment isolates dependencies
- No system-wide Python package installation
- Secure execution of external scripts

## 🚀 **Performance Optimization**

### **Image Processing**
- Automatic compression for large images
- Progressive JPEG loading
- Optimized AI model loading

### **Server Resources**
- Configurable memory limits
- Adjustable execution timeouts
- Efficient file handling

### **Caching**
- Processed images cached in uploads directory
- Avoids reprocessing identical images
- Optimized storage structure

## 🔄 **Maintenance**

### **Regular Tasks**
- Monitor `processed/` directory size
- Clean up old temporary files
- Update Python packages if needed
- Check WordPress and plugin updates

### **Python Package Updates**
```bash
cd wp-content/plugins/mpa-image-processor
source plugin_env/bin/activate
pip install --upgrade -r requirements.txt
```

### **Backup Considerations**
- Backup `processed/` directory regularly
- Include Python environment in backups
- Document any custom configurations

## 📞 **Support**

### **For MPA Committee Members**
- Contact: [Andrew Michael Kho](https://www.linkedin.com/in/andrewmichaelkho/)
- Organization: Malaysia PropTech Association
- Role: Committee Member 2025-2026

### **Technical Support**
- Check this README for common solutions
- Review WordPress debug logs
- Verify Python environment setup
- Test with sample images

### **Feature Requests**
- Submit through MPA committee channels
- Include use case and requirements
- Provide sample images if relevant

## 📝 **Changelog**

### **Version 1.0.0**
- Initial release
- AI background removal with rembg
- Interactive cropping with Cropper.js
- WordPress media library integration
- Python virtual environment setup
- Comprehensive error handling

## 📄 **License**

This plugin is licensed under GPL v2 or later, in accordance with WordPress plugin guidelines.

## 🙏 **Acknowledgments**

- **MPA Committee**: For requirements and testing
- **rembg**: AI background removal library
- **Cropper.js**: Image cropping functionality
- **WordPress Community**: Plugin development standards

---

**MPA Image Processor** - Making committee member photo management simple and professional.

*Developed for the Malaysia PropTech Association*

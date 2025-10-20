#!/bin/bash

# MPA Image Processor - Python Environment Setup Script
# This script sets up the Python environment for the WordPress plugin

echo "🔧 Setting up Python environment for MPA Image Processor..."

# Check if we're in the plugin directory
if [ ! -f "mpa-image-processor-plugin.php" ]; then
    echo "❌ Error: Please run this script from the mpa-image-processor plugin directory"
    echo "   Expected location: wp-content/plugins/mpa-image-processor/"
    exit 1
fi

# Create virtual environment
echo "📦 Creating Python virtual environment..."
python3 -m venv plugin_env

# Activate virtual environment
echo "🔌 Activating virtual environment..."
source plugin_env/bin/activate

# Install dependencies
echo "⬇️  Installing Python dependencies..."
pip install -r requirements.txt

# Install additional required packages
echo "🧠 Installing AI background removal engine..."
pip install onnxruntime

# Create processed directory
echo "📁 Creating output directory..."
mkdir -p processed

# Test installation
echo "🧪 Testing Python environment..."
python -c "from rembg import remove; from PIL import Image; print('✅ Python environment setup complete!')"

echo ""
echo "🎉 Setup completed successfully!"
echo ""
echo "📋 What was installed:"
echo "   • Python virtual environment (plugin_env/)"
echo "   • AI background removal (rembg + onnxruntime)"
echo "   • Image processing libraries (Pillow, OpenCV, NumPy)"
echo "   • Output directory (processed/)"
echo ""
echo "🚀 Your WordPress plugin is now ready to use!"

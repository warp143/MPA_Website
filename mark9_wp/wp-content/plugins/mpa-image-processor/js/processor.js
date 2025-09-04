jQuery(document).ready(function($) {
    console.log('MPA Image Processor: Script loaded');
    
    let cropper = null;
    let currentImagePath = null;
    let processedImagePath = null;
    let originalFileName = null;
    
    // Prevent multiple initialization
    if (window.mpaProcessorInitialized) {
        console.log('MPA Image Processor: Already initialized, skipping');
        return;
    }
    window.mpaProcessorInitialized = true;
    
    console.log('MPA Image Processor: Initializing interface');
    initInterface();
    
    function initInterface() {
        console.log('MPA Image Processor: Setting up event handlers');
        
        // Clean up any existing handlers first
        $('#imageInput').off();
        $('#uploadArea').off();
        $('.modern-upload-btn, #uploadBtn').off();
        $('.button').off('click');
        
        // File input change handler
        $('#imageInput').on('change', handleImageUpload);
        
        // Upload button handlers
        $('.modern-upload-btn, #uploadBtn').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('MPA Image Processor: Upload button clicked');
            document.getElementById('imageInput').click();
        });
        
        // Upload area click handler
        $('#uploadArea').on('click', function(e) {
            if (!$(e.target).is('input') && !$(e.target).hasClass('modern-upload-btn')) {
                e.preventDefault();
                e.stopPropagation();
                console.log('MPA Image Processor: Upload area clicked');
                document.getElementById('imageInput').click();
            }
        });
        
        // Button handlers for cropping and processing
        $('#applyCropBtn').on('click', applyCrop);
        $('#resetCropBtn').on('click', resetCrop);
        $('#cropHeadShouldersBtn').on('click', function() { setCropPreset('head-shoulders'); });
        $('#cropUpperBodyBtn').on('click', function() { setCropPreset('upper-body'); });
        $('#cropFullBodyBtn').on('click', function() { setCropPreset('full-body'); });
        $('#saveProcessedOnlyBtn').on('click', function() { 
            if (processedImagePath) {
                saveToMediaLibrary(processedImagePath, 'Committee Member Photo (No Background)');
            } else {
                alert('No processed image available. Please process an image first.');
            }
        });
        $('#processAnotherBtn').on('click', resetInterface);
    }
    
    function handleImageUpload(e) {
        console.log('MPA Image Processor: File input changed, files count:', e.target.files.length);
        
        const file = e.target.files[0];
        if (file) {
            console.log('MPA Image Processor: Processing selected file:', file.name);
            originalFileName = file.name;
            
            if (typeof mpa_ajax === 'undefined') {
                console.error('MPA Image Processor: mpa_ajax is not defined!');
                alert('Error: Plugin not properly loaded. Please refresh the page.');
                return;
            }
            
            // Compress and upload
            compressImage(file, function(compressedFile) {
                console.log('MPA Image Processor: Compressed from', (file.size / 1024 / 1024).toFixed(2) + 'MB to', (compressedFile.size / 1024 / 1024).toFixed(2) + 'MB');
                uploadFile(compressedFile);
            });
        }
    }
    
    function compressImage(file, callback) {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        const img = new Image();
        
        img.onload = function() {
            let { width, height } = img;
            const maxWidth = 1200;
            
            if (width > maxWidth) {
                height = (height * maxWidth) / width;
                width = maxWidth;
            }
            
            canvas.width = width;
            canvas.height = height;
            ctx.drawImage(img, 0, 0, width, height);
            
            canvas.toBlob(function(blob) {
                if (blob) {
                    const compressedFile = new File([blob], file.name, {
                        type: 'image/jpeg',
                        lastModified: Date.now()
                    });
                    callback(compressedFile);
                } else {
                    callback(file);
                }
            }, 'image/jpeg', 0.8);
        };
        
        img.onerror = function() {
            callback(file);
        };
        
        img.src = URL.createObjectURL(file);
    }
    
    function uploadFile(file) {
        console.log('MPA Image Processor: uploadFile() called');
        
        $('.upload-area').html('<p>⏳ Uploading compressed file...</p>');
        
        const formData = new FormData();
        formData.append('action', 'process_image');
        formData.append('nonce', mpa_ajax.nonce);
        formData.append('image', file);
        
        $.ajax({
            url: mpa_ajax.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('MPA Image Processor: AJAX success response:', response);
                if (response.success) {
                    currentImagePath = response.data.image_path;
                    console.log('MPA Image Processor: Upload successful! Now showing crop section...');
                    showCropSection(response.data.image_url);
                } else {
                    alert('Upload failed: ' + response.data);
                    resetInterface();
                }
            },
            error: function(xhr, status, error) {
                console.error('MPA Image Processor: AJAX error:', xhr, status, error);
                alert('Upload failed. Error: ' + error);
                resetInterface();
            }
        });
    }
    
    function showCropSection(imageUrl) {
        console.log('MPA Image Processor: showCropSection() called with URL:', imageUrl);
        $('#uploadSection').hide();
        $('#cropSection').show();
        
        const cropImage = $('#cropImage');
        cropImage.attr('src', imageUrl);
        
        setTimeout(function() {
            initCropper();
        }, 100);
    }
    
    function initCropper() {
        const image = document.getElementById('cropImage');
        if (cropper) {
            cropper.destroy();
        }
        
        image.onload = function() {
            cropper = new Cropper(image, {
                aspectRatio: NaN,
                viewMode: 1,
                dragMode: 'crop',
                autoCropArea: 0.8,
                restore: false,
                guides: true,
                center: true,
                highlight: false,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
                responsive: true,
                checkOrientation: false,
                zoomable: false,
                scalable: false,
                rotatable: false,
                movable: false,
                ready: function() {
                    console.log('Cropper initialized successfully');
                    const canvasData = this.cropper.getCanvasData();
                    const initialCropBoxData = {
                        left: canvasData.left + (canvasData.width * 0.1),
                        top: canvasData.top + (canvasData.height * 0.05),
                        width: canvasData.width * 0.8,
                        height: canvasData.height * 0.7
                    };
                    this.cropper.setCropBoxData(initialCropBoxData);
                }
            });
        };
        
        if (image.complete) {
            image.onload();
        }
    }
    
    function setCropPreset(preset) {
        if (!cropper) {
            alert('Please wait for the cropper to initialize.');
            return;
        }
        
        const canvasData = cropper.getCanvasData();
        let cropBoxData;
        
        switch(preset) {
            case 'head-shoulders':
                cropBoxData = {
                    left: canvasData.left + (canvasData.width * 0.15),
                    top: canvasData.top + (canvasData.height * 0.05),
                    width: canvasData.width * 0.7,
                    height: canvasData.height * 0.4
                };
                break;
            case 'upper-body':
                cropBoxData = {
                    left: canvasData.left + (canvasData.width * 0.1),
                    top: canvasData.top + (canvasData.height * 0.05),
                    width: canvasData.width * 0.8,
                    height: canvasData.height * 0.65
                };
                break;
            case 'full-body':
                cropBoxData = {
                    left: canvasData.left + (canvasData.width * 0.05),
                    top: canvasData.top + (canvasData.height * 0.02),
                    width: canvasData.width * 0.9,
                    height: canvasData.height * 0.96
                };
                break;
        }
        
        if (cropBoxData) {
            cropper.setCropBoxData(cropBoxData);
        }
    }
    
    function applyCrop() {
        if (!cropper) {
            alert('Please wait for the cropper to initialize.');
            return;
        }
        
        const canvas = cropper.getCroppedCanvas();
        if (canvas) {
            canvas.toBlob(function(blob) {
                processCroppedImage(blob);
            }, 'image/png');
        }
    }
    
    function resetCrop() {
        if (cropper) {
            cropper.reset();
        }
    }
    
    function processCroppedImage(blob) {
        $('#cropSection').hide();
        $('#processingSection').show();
        
        uploadCroppedImage(blob);
    }
    
    function uploadCroppedImage(blob) {
        const croppedFile = new File([blob], originalFileName || 'image', {
            type: 'image/png',
            lastModified: Date.now()
        });
        
        const formData = new FormData();
        formData.append('action', 'process_image');
        formData.append('nonce', mpa_ajax.nonce);
        formData.append('image', croppedFile);
        
        $.ajax({
            url: mpa_ajax.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    currentImagePath = response.data.image_path;
                    startProgressAndRemoveBackground();
                } else {
                    alert('Failed to upload cropped image: ' + response.data);
                    $('#processingSection').hide();
                    $('#cropSection').show();
                }
            },
            error: function() {
                alert('Failed to upload cropped image. Please try again.');
                $('#processingSection').hide();
                $('#cropSection').show();
            }
        });
    }
    
    function startProgressAndRemoveBackground() {
        let progress = 0;
        const progressInterval = setInterval(function() {
            progress += 10;
            $('.progress-fill').css('width', progress + '%');
            if (progress >= 100) {
                clearInterval(progressInterval);
                removeBackground();
            }
        }, 200);
    }
    
    function removeBackground() {
        if (!currentImagePath) {
            alert('No image to process.');
            return;
        }
        
        $.ajax({
            url: mpa_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'remove_background',
                nonce: mpa_ajax.nonce,
                image_path: currentImagePath,
                crop_data: {}
            },
            success: function(response) {
                if (response.success) {
                    showResults(response.data);
                } else {
                    alert('Background removal failed: ' + response.data);
                    $('#processingSection').hide();
                    $('#cropSection').show();
                }
            },
            error: function() {
                alert('Background removal failed. Please try again.');
                $('#processingSection').hide();
                $('#cropSection').show();
            }
        });
    }
    
    function showResults(data) {
        $('#processingSection').hide();
        $('#resultsSection').show();
        
        processedImagePath = data.processed_path;
        $('#processedResult').attr('src', data.processed_url);
        $('#originalResult').attr('src', $('#cropImage').attr('src'));
    }
    
    function saveToMediaLibrary(imagePath, imageTitle) {
        $.ajax({
            url: mpa_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'save_processed_image',
                nonce: mpa_ajax.nonce,
                image_path: imagePath,
                image_title: imageTitle
            },
            success: function(response) {
                if (response.success) {
                    alert('Image saved to media library successfully!');
                } else {
                    alert('Failed to save image: ' + response.data);
                }
            },
            error: function() {
                alert('Failed to save image. Please try again.');
            }
        });
    }
    
    function resetInterface() {
        $('#uploadSection').show();
        $('#cropSection').hide();
        $('#processingSection').hide();
        $('#resultsSection').hide();
        
        $('.upload-area').html(`
            <div class="upload-content">
                <div class="upload-icon">📸</div>
                <h3>Upload Committee Member Photo</h3>
                <p>Select a high-quality image for processing</p>
                <div class="modern-upload-btn" id="uploadBtn">
                    <span class="upload-btn-text">📁 Choose Image File</span>
                    <span class="upload-btn-subtext">JPG, PNG • Any size (auto-compressed)</span>
                </div>
                <input type="file" id="imageInput" accept="image/*" style="position: absolute; left: -9999px; opacity: 0;">
            </div>
        `);
        
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        
        $('.progress-fill').css('width', '0%');
        currentImagePath = null;
        processedImagePath = null;
        originalFileName = null;
        
        initInterface();
    }
});

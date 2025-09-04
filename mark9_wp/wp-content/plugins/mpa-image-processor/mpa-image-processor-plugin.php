<?php
/**
 * Plugin Name: MPA Image Processor
 * Plugin URI: https://www.homesifu.io
 * Description: Upload, crop, and remove backgrounds from images with AI-powered processing
 * Version: 1.0.0
 * Author: MPA Committee Member 2025-2026 @ Andrew Michael Kho
 * Author URI: https://www.linkedin.com/in/andrewmichaelkho/
 * License: GPL v2 or later
 * Text Domain: mpa-image-processor
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class MPAImageProcessor {
    
    public function __construct() {
        // HTTPS forcing disabled - using HTTP for IP address
        // add_filter('upload_dir', array($this, 'force_https_upload_dir'), 10, 1);
        // add_filter('wp_get_upload_dir', array($this, 'force_https_upload_dir'), 10, 1);
        // add_filter('home_url', array($this, 'force_https_home_url'), 10, 1);
        // add_filter('site_url', array($this, 'force_https_site_url'), 10, 1);
        // add_filter('wp_ajax_mpa_upload_image', array($this, 'force_https_ajax_response'), 10, 1);
        // add_filter('wp_ajax_nopriv_mpa_upload_image', array($this, 'force_https_ajax_response'), 10, 1);
        // add_filter('wp_ajax_mpa_remove_background', array($this, 'force_https_ajax_response'), 10, 1);
        // add_filter('wp_ajax_nopriv_mpa_remove_background', array($this, 'force_https_ajax_response'), 10, 1);
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'custom_admin_scripts'));
        add_action('wp_ajax_process_image', array($this, 'process_image_ajax'));
        add_action('wp_ajax_remove_background', array($this, 'remove_background_ajax'));
        add_action('wp_ajax_save_processed_image', array($this, 'save_processed_image_ajax'));
        
        // Increase PHP limits for this plugin
        add_action('init', array($this, 'increase_php_limits'));
        
        // WordPress upload filters
        add_filter('upload_size_limit', array($this, 'increase_upload_size_limit'));
        add_filter('wp_max_upload_size', array($this, 'increase_upload_size_limit'));
    }
    
    public function increase_upload_size_limit($size) {
        // Set to 50MB
        return 50 * 1024 * 1024;
    }
    
    public function increase_php_limits() {
        // Only increase limits when using our plugin
        if (isset($_GET['page']) && $_GET['page'] === 'mpa-image-processor') {
            @ini_set('upload_max_filesize', '50M');
            @ini_set('post_max_size', '50M');
            @ini_set('max_execution_time', '300');
            @ini_set('memory_limit', '512M');
        }
    }
    
    /**
     * Force HTTPS for all upload URLs
     */
    public function force_https_upload_dir($uploads) {
        if (isset($uploads['baseurl']) && strpos($uploads['baseurl'], 'http://') === 0) {
            $uploads['baseurl'] = str_replace('http://', 'https://', $uploads['baseurl']);
        }
        if (isset($uploads['url']) && strpos($uploads['url'], 'http://') === 0) {
            $uploads['url'] = str_replace('http://', 'https://', $uploads['url']);
        }
        return $uploads;
    }
    
    /**
     * Force HTTPS for home URL
     */
    public function force_https_home_url($url) {
        if (strpos($url, 'http://172.188.12.16') === 0) {
            return str_replace('http://', 'https://', $url);
        }
        return $url;
    }
    
    /**
     * Force HTTPS for site URL
     */
    public function force_https_site_url($url) {
        if (strpos($url, 'http://172.188.12.16') === 0) {
            return str_replace('http://', 'https://', $url);
        }
        return $url;
    }
    
    /**
     * Force HTTPS for AJAX responses
     */
    public function force_https_ajax_response($response) {
        if (is_array($response) && isset($response['data']['image_url'])) {
            $response['data']['image_url'] = str_replace('http://', 'https://', $response['data']['image_url']);
        }
        return $response;
    }
    
    public function add_admin_menu() {
        add_menu_page(
            'MPA Image Processor',
            'Image Processor',
            'manage_options',
            'mpa-image-processor',
            array($this, 'admin_page'),
            'dashicons-format-image',
            30
        );
    }
    
    public function enqueue_admin_scripts($hook) {
        if ($hook !== 'toplevel_page_mpa-image-processor') {
            return;
        }
        
        wp_enqueue_script('jquery');
        wp_enqueue_style('wp-admin');
        
        // Add Cropper.js for image cropping
        wp_enqueue_script('cropper-js', 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js', array(), '1.5.12', true);
        wp_enqueue_style('cropper-css', 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css', array(), '1.5.12');
        
        // Add our custom JavaScript
        wp_enqueue_script('mpa-processor', plugin_dir_url(__FILE__) . 'js/processor.js', array('jquery', 'cropper-js'), '1.0.0', true);
        
        // Localize script for AJAX
        wp_localize_script('mpa-processor', 'mpa_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('mpa_image_processor_nonce')
        ));
    }
    
    /**
     * Custom admin scripts for plugins page
     */
    public function custom_admin_scripts($hook) {
        // Only load on plugins page
        if ($hook === 'plugins.php') {
            wp_enqueue_script('jquery');
            wp_add_inline_script('jquery', '
                jQuery(document).ready(function($) {
                    // Change "Visit plugin site" to "View details" for MPA plugins
                    $("a[href*=\'homesifu.io\']").each(function() {
                        if ($(this).text() === "Visit plugin site") {
                            $(this).text("View details");
                        }
                    });
                });
            ');
        }
    }
    
    public function admin_page() {
        ?>
        <div class="wrap">
            <h1>MPA Image Processor</h1>
            
            <div class="notice notice-info">
                <p><strong>🎯 Ready to process committee member images!</strong> Upload, crop, and remove backgrounds automatically.</p>
                <p><strong>📏 Smart Upload:</strong> Large images (over 2MB) will be automatically compressed. Maximum recommended size: 10MB.</p>
                <p><strong>✨ Auto-Compression:</strong> Images will be resized to 1920px width and compressed to fit within upload limits.</p>
            </div>
            
            <!-- Upload Section -->
            <div id="uploadSection" class="card">
                <h2>📤 Step 1: Upload Image</h2>
                <div class="upload-area" id="uploadArea">
                    <div class="upload-content">
                        <div class="upload-icon">📸</div>
                        <h3>Upload Committee Member Photo</h3>
                        <p>Select a high-quality image for processing</p>
                        <label for="imageInput" class="modern-upload-btn">
                            <span class="upload-btn-text">📁 Choose Image File</span>
                            <span class="upload-btn-subtext">JPG, PNG • Max 10MB</span>
                        </label>
                        <input type="file" id="imageInput" accept="image/*" style="display: none;">
                    </div>
                </div>
            </div>
            
            <!-- Crop Section -->
            <div id="cropSection" class="card" style="display: none; max-width: none; width: 100%;">
                <h2 style="text-align: center;">✂️ Step 2: Crop Image</h2>
                <div class="crop-container">
                    <img id="cropImage" src="" alt="Crop this image">
                </div>
                <div class="crop-controls">
                    <div class="crop-presets" style="margin-bottom: 15px;">
                        <strong>Quick Crop Presets:</strong>
                        <button type="button" class="button button-small" id="cropHeadShouldersBtn">Head & Shoulders</button>
                        <button type="button" class="button button-small" id="cropUpperBodyBtn">Upper Body</button>
                        <button type="button" class="button button-small" id="cropFullBodyBtn">Full Body</button>
                    </div>
                    <button type="button" class="button button-primary" id="applyCropBtn">Apply Crop</button>
                    <button type="button" class="button button-secondary" id="resetCropBtn">Reset Crop</button>
                </div>
            </div>
            
            <!-- Processing Section -->
            <div id="processingSection" class="card" style="display: none;">
                <h2>🔄 Step 3: Remove Background</h2>
                <div class="processing-status">
                    <p>Processing your image...</p>
                    <div class="progress-bar">
                        <div class="progress-fill"></div>
                    </div>
                </div>
            </div>
            
            <!-- Results Section -->
            <div id="resultsSection" class="card" style="display: none;">
                <h2>✅ Step 4: Results</h2>
                <div class="results-container">
                    <div class="result-item">
                        <h3>Original Image</h3>
                        <img id="originalResult" src="" alt="Original">
                        <button type="button" class="button button-primary" id="saveOriginalBtn">Save to Media Library</button>
                    </div>
                    <div class="result-item">
                        <h3>Processed Image (No Background)</h3>
                        <img id="processedResult" src="" alt="Processed">
                        <button type="button" class="button button-primary" id="saveProcessedBtn">Save to Media Library</button>
                    </div>
                </div>
                <div class="bulk-actions">
                    <button type="button" class="button button-primary" id="saveProcessedOnlyBtn">💾 Save Processed Image Only</button>
                    <button type="button" class="button button-secondary" id="saveBothBtn">Save Both Images</button>
                    <button type="button" class="button button-secondary" id="processAnotherBtn">Process Another Image</button>
                </div>
            </div>
            
            <!-- Instructions -->
            <div class="card">
                <h2>📖 How to Use</h2>
                <ol>
                    <li><strong>Upload:</strong> Drag & drop or click to upload a committee member photo</li>
                    <li><strong>Crop:</strong> Use the interactive crop tool to frame the image perfectly</li>
                    <li><strong>Process:</strong> Click to remove the background automatically using AI</li>
                    <li><strong>Save:</strong> Save both original and processed images to your media library</li>
                </ol>
            </div>
        </div>
        
        <style>
        /* Make the admin area use full width */
        .wrap {
            max-width: none !important;
            margin-right: 20px !important;
        }
        .card {
            max-width: none !important;
        }
        .upload-area {
            border: 2px dashed #ddd;
            border-radius: 16px;
            padding: 50px 40px;
            text-align: center;
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .upload-area:hover {
            border-color: #0073aa;
            background: linear-gradient(135deg, #f0f8ff 0%, #e6f3ff 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 115, 170, 0.15);
        }
        .upload-area.dragover {
            border-color: #0073aa;
            background: linear-gradient(135deg, #e6f3ff 0%, #ddeeff 100%);
        }
        .upload-icon {
            font-size: 48px;
            margin-bottom: 20px;
            opacity: 0.8;
        }
        .upload-content h3 {
            margin: 0 0 10px 0;
            color: #2c3e50;
            font-size: 22px;
            font-weight: 600;
        }
        .upload-content p {
            margin: 0 0 30px 0;
            color: #6c757d;
            font-size: 16px;
        }
        .modern-upload-btn {
            display: inline-block;
            background: linear-gradient(135deg, #0073aa 0%, #005177 100%);
            color: white;
            padding: 16px 32px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(0, 115, 170, 0.3);
            position: relative;
            overflow: hidden;
        }
        .modern-upload-btn:hover {
            background: linear-gradient(135deg, #005177 0%, #003d5c 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 115, 170, 0.4);
            color: white;
            text-decoration: none;
        }
        .modern-upload-btn:active {
            transform: translateY(0);
        }
        .upload-btn-text {
            display: block;
            font-size: 16px;
            margin-bottom: 4px;
        }
        .upload-btn-subtext {
            display: block;
            font-size: 12px;
            opacity: 0.8;
            font-weight: 400;
        }
        .crop-container {
            width: 100%;
            max-width: 1200px;
            height: 700px;
            margin: 20px auto;
            border: 1px solid #ddd;
            background: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .crop-container img {
            max-width: 100%;
            height: auto;
            display: block;
        }
        /* Cropper.js specific styles */
        .cropper-container {
            width: 100% !important;
            max-width: 1200px !important;
            height: 700px !important;
            margin: 0 auto !important;
        }
        .cropper-canvas {
            max-width: 100% !important;
            max-height: 700px !important;
        }
        .cropper-drag-box {
            background: rgba(0, 0, 0, 0.1);
        }
        .cropper-view-box {
            outline: 2px solid #0073aa;
        }
        /* Disable zoom interactions */
        .cropper-canvas {
            pointer-events: none !important;
        }
        .cropper-crop-box {
            pointer-events: auto !important;
        }
        .cropper-drag-box {
            pointer-events: none !important;
        }
        .crop-controls {
            margin: 20px 0;
            text-align: center;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }
        .crop-presets {
            margin-bottom: 15px;
        }
        .crop-presets button {
            margin: 0 5px;
        }
        .progress-bar {
            width: 100%;
            height: 20px;
            background: #f0f0f0;
            border-radius: 10px;
            overflow: hidden;
            margin: 10px 0;
        }
        .progress-fill {
            height: 100%;
            background: #0073aa;
            width: 0%;
            transition: width 0.3s ease;
        }
        .results-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 20px 0;
            min-height: 400px;
        }
        
        .result-item {
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            background: #f9f9f9;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .result-item h3 {
            margin: 0 0 15px 0;
            font-size: 18px;
            color: #2c3e50;
            font-weight: 600;
        }
        .result-item img {
            max-width: 100%;
            max-height: 300px;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 0 auto;
            object-fit: contain;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            flex-grow: 1;
        }
        
        /* Remove individual save buttons from result items */
        .result-item .button {
            display: none;
        }
        
        .bulk-actions {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background: #f0f8ff;
            border-radius: 8px;
            border: 1px solid #e1f0ff;
        }
        .bulk-actions .button {
            margin: 0 10px;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 600;
        }
        </style>
        <?php
    }
    
    public function process_image_ajax() {
        // Increase PHP limits for upload
        @ini_set('upload_max_filesize', '50M');
        @ini_set('post_max_size', '50M');
        @ini_set('max_execution_time', '300');
        @ini_set('memory_limit', '512M');
        
        // Add debugging
        error_log('MPA Image Processor: AJAX request received');
        error_log('MPA Image Processor: Current upload_max_filesize: ' . ini_get('upload_max_filesize'));
        
        check_ajax_referer('mpa_image_processor_nonce', 'nonce');
        if (!current_user_can('manage_options')) {
            error_log('MPA Image Processor: User not authorized');
            wp_die('Unauthorized');
        }
        
        if (!isset($_FILES['image'])) {
            error_log('MPA Image Processor: No image file in request');
            wp_send_json_error('No image uploaded');
        }
        
        error_log('MPA Image Processor: Image file found: ' . $_FILES['image']['name']);
        
        $upload_dir = wp_upload_dir();
        $target_dir = $upload_dir['basedir'] . '/mpa-processor/';
        error_log('MPA Image Processor: Target directory: ' . $target_dir);
        
        if (!file_exists($target_dir)) {
            error_log('MPA Image Processor: Creating target directory');
            wp_mkdir_p($target_dir);
        }
        
        $file = $_FILES['image'];
        $file_name = sanitize_file_name($file['name']);
        $target_path = $target_dir . $file_name;
        error_log('MPA Image Processor: Target path: ' . $target_path);
        
        // Check for upload errors first
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $error_messages = array(
                UPLOAD_ERR_INI_SIZE => 'File is too large (exceeds upload_max_filesize)',
                UPLOAD_ERR_FORM_SIZE => 'File is too large (exceeds MAX_FILE_SIZE)',
                UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
                UPLOAD_ERR_NO_FILE => 'No file was uploaded',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
                UPLOAD_ERR_EXTENSION => 'File upload stopped by extension'
            );
            
            $error_message = isset($error_messages[$file['error']]) 
                ? $error_messages[$file['error']] 
                : 'Unknown upload error: ' . $file['error'];
                
            error_log('MPA Image Processor: Upload error: ' . $error_message);
            wp_send_json_error($error_message);
        }
        
        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            $image_url = 'http://172.188.12.16/wp-content/uploads/mpa-processor/' . $file_name . '?v=' . time();
            error_log('MPA Image Processor: File uploaded successfully');
            error_log('MPA Image Processor: Generated URL: ' . $image_url);
            
            // Force immediate response without WordPress processing
            header('Content-Type: application/json');
            echo json_encode(array(
                'success' => true,
                'data' => array(
                    'image_path' => $target_path,
                    'image_url' => $image_url
                )
            ));
            exit;
        } else {
            error_log('MPA Image Processor: Failed to move uploaded file');
            wp_send_json_error('Failed to move uploaded file to destination');
        }
    }
    
    public function remove_background_ajax() {
        check_ajax_referer('mpa_image_processor_nonce', 'nonce');
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $image_path = sanitize_text_field($_POST['image_path']);
        $crop_data = isset($_POST['crop_data']) ? $_POST['crop_data'] : array();
        
        error_log('MPA Image Processor: Processing image: ' . $image_path);
        
        // Use absolute path for Python script
        error_log('MPA Image Processor: Using absolute path: ' . $image_path);
        
        // Call Python script for background removal
        $command = sprintf(
            'cd %s && source plugin_env/bin/activate && python process_image.py %s --output-dir processed --target-size 2.0 2>&1',
            escapeshellarg(plugin_dir_path(__FILE__)),
            escapeshellarg($image_path)
        );
        
        error_log('MPA Image Processor: Command: ' . $command);
        
        $output = shell_exec($command);
        
        error_log('MPA Image Processor: Python output: ' . $output);
        
        if (strpos($output, '✅') !== false) {
            // The processed image is in the plugin directory
            $plugin_dir = plugin_dir_path(__FILE__);
            $processed_dir = $plugin_dir . 'processed/';
            $file_name = basename($image_path);
            
            // Always add _cropped, even if filename already has it
            $file_info = pathinfo($file_name);
            $processed_name = $file_info['filename'] . '_cropped.png';
            $processed_path = $processed_dir . $processed_name;
            
            error_log('MPA Image Processor: Looking for processed image at: ' . $processed_path);
            error_log('MPA Image Processor: File exists check: ' . (file_exists($processed_path) ? 'YES' : 'NO'));
            
            if (file_exists($processed_path)) {
                error_log('MPA Image Processor: File found! Starting copy process...');
                // Copy the processed image to uploads directory for web access
                $upload_dir = wp_upload_dir();
                $web_processed_dir = $upload_dir['basedir'] . '/mpa-processor/processed/';
                if (!file_exists($web_processed_dir)) {
                    wp_mkdir_p($web_processed_dir);
                }
                
                $web_processed_path = $web_processed_dir . $processed_name;
                error_log('MPA Image Processor: Copying to: ' . $web_processed_path);
                
                if (copy($processed_path, $web_processed_path)) {
                    $processed_url = 'http://172.188.12.16/wp-content/uploads/mpa-processor/processed/' . $processed_name . '?v=' . time();
                    error_log('MPA Image Processor: Copy successful!');
                    error_log('MPA Image Processor: Generated processed URL: ' . $processed_url);
                    
                    // Force immediate response without WordPress processing
                    header('Content-Type: application/json');
                    echo json_encode(array(
                        'success' => true,
                        'data' => array(
                            'processed_path' => $web_processed_path,
                            'processed_url' => $processed_url
                        )
                    ));
                    exit;
                } else {
                    error_log('MPA Image Processor: Copy failed!');
                    wp_send_json_error('Failed to copy processed image to web directory');
                }
            } else {
                wp_send_json_error('Processed image not found at: ' . $processed_path);
            }
        } else {
            wp_send_json_error('Background removal failed: ' . $output);
        }
    }
    
    public function save_processed_image_ajax() {
        check_ajax_referer('mpa_image_processor_nonce', 'nonce');
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $image_path = sanitize_text_field($_POST['image_path']);
        $image_title = sanitize_text_field($_POST['image_title']);
        
        if (!file_exists($image_path)) {
            wp_send_json_error('Image file not found');
        }
        
        $upload_dir = wp_upload_dir();
        $file_name = basename($image_path);
        $target_path = $upload_dir['path'] . '/' . $file_name;
        
        if (copy($image_path, $target_path)) {
            $file_type = wp_check_filetype($file_name, null);
            $attachment = array(
                'post_mime_type' => $file_type['type'],
                'post_title' => $image_title,
                'post_content' => '',
                'post_status' => 'inherit'
            );
            
            $attach_id = wp_insert_attachment($attachment, $target_path);
            if (!is_wp_error($attach_id)) {
                wp_update_attachment_metadata($attach_id, wp_generate_attachment_metadata($attach_id, $target_path));
                wp_send_json_success(array(
                    'attachment_id' => $attach_id,
                    'url' => wp_get_attachment_url($attach_id)
                ));
            } else {
                wp_send_json_error('Failed to create attachment');
            }
        } else {
            wp_send_json_error('Failed to copy image');
        }
    }
}

// Initialize the plugin
new MPAImageProcessor();

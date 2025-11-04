<?php
/**
 * Template Name: Member Submission Form
 */
get_header();
?>

<style>
.submission-form-container {
    max-width: 800px;
    margin: 140px auto 60px auto;
    padding: 40px;
    background: var(--bg-secondary);
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
}
.submission-form-container h1 {
    text-align: center;
    margin-bottom: 10px;
    color: var(--text-primary);
}
.submission-form-container .intro-text {
    text-align: center;
    color: var(--text-secondary);
    margin-bottom: 40px;
}
.form-group {
    margin-bottom: 25px;
}
.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    color: var(--text-primary);
}
.form-group .required {
    color: var(--accent-red, #e74c3c);
}
.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="url"],
.form-group input[type="tel"],
.form-group input[type="file"],
.form-group textarea,
.form-group select {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid var(--glass-border);
    border-radius: 6px;
    font-size: 15px;
    background: var(--bg-tertiary);
    color: var(--text-primary);
    transition: var(--transition-fast, 0.15s ease);
}
.form-group input::placeholder,
.form-group textarea::placeholder {
    color: var(--text-muted);
}
.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
    outline: none;
    border-color: var(--accent-blue, #3498db);
}
.form-group textarea {
    min-height: 120px;
}
.form-group small {
    display: block;
    margin-top: 5px;
    color: var(--text-muted);
    font-size: 13px;
}
.submit-btn {
    width: 100%;
    padding: 15px;
    background: var(--accent-blue, #3498db);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition-fast, 0.15s ease);
}
.submit-btn:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}
.alert {
    padding: 15px 20px;
    border-radius: 6px;
    margin-bottom: 25px;
}
.alert-success {
    background: rgba(52, 199, 89, 0.2);
    color: var(--accent-green, #34C759);
    border: 1px solid var(--accent-green, #34C759);
}
.alert-error {
    background: rgba(255, 59, 48, 0.2);
    color: var(--accent-red, #FF3B30);
    border: 1px solid var(--accent-red, #FF3B30);
}

@media (max-width: 768px) {
    .submission-form-container {
        margin: 100px auto 40px auto;
        padding: 30px 20px;
    }
}
</style>

<div class="submission-form-container">
    <h1>🚀 Update Member Information</h1>
    <p class="intro-text">Update your company information</p>

    <div id="formMessage"></div>

    <form id="memberSubmissionForm" enctype="multipart/form-data">
        <div class="form-group">
            <label>Company/Startup/Brand/Product Name <span class="required">*</span></label>
            <input type="text" name="company_name" required>
            <small style="display: block; margin-top: 5px; color: #999; font-size: 12px;">(Don't try to overcomplicate yourself, just choose 1 direction you like to go with and stick with it 😊)</small>
        </div>

        <div class="form-group">
            <label>Company's Elevator Pitch <span class="required">*</span></label>
            <div style="margin-bottom: 10px;">
                <p style="margin: 0; padding: 8px 12px; background: #f0f0f0; border-radius: 4px; font-size: 13px; color: #666; font-style: italic;">
                    💡 <strong>Suggested Elevator Pitch Template</strong> (optional guide - feel free to write your own)
                </p>
            </div>
            <textarea id="company_description" name="company_description" required style="height: 280px; resize: none; color: #999; font-size: 14px; line-height: 1.6;" placeholder="[Company Name] is [positioning] and [unique claim], designed to [core value proposition]. Our [key differentiator/technology] handles [key features]—so [benefit/outcome].

The [market/industry] is worth [market size], and we're focused on [target audience]—whether [range].

Our users/clients [benefit/metric 1] and achieve [metric 2].

As a [positioning], [Company] is currently [current status] and [expansion plans], with [future goals].

[Company]'s [key differentiator] transform [outcome]. Ready to [call to action]? Let's talk.">[Company Name] is [positioning] and [unique claim], designed to [core value proposition]. Our [key differentiator/technology] handles [key features]—so [benefit/outcome].

The [market/industry] is worth [market size], and we're focused on [target audience]—whether [range].

Our users/clients [benefit/metric 1] and achieve [metric 2].

As a [positioning], [Company] is currently [current status] and [expansion plans], with [future goals].

[Company]'s [key differentiator] transform [outcome]. Ready to [call to action]? Let's talk.</textarea>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px;">
                <small style="color: #666;">The template above is just a suggestion. Feel free to replace it completely with your own elevator pitch.</small>
                <small id="wordCount" style="color: #666; font-weight: 500; margin-left: 10px;">0 / 200 words</small>
            </div>
        </div>

        <div class="form-group">
            <label>Company Website <span class="required">*</span></label>
            <input type="text" id="company_website" name="company_website" placeholder="www.example.com or https://example.com" required>
            <small>Enter your website (https:// will be added automatically)</small>
        </div>

        <div class="form-group">
            <label>Company/Startup/Brand/Product Logo <span class="required">*</span></label>
            <input type="file" name="company_logo" accept="image/*" required>
            <small>PNG or JPG, max 2MB. Square logo preferred - REQUIRED</small>
        </div>

        <div class="form-group">
            <label>Vertical / Focus Area <span class="required">*</span></label>
            <select name="vertical" required>
                <option value="">Select Vertical</option>
                <option value="PLAN & CONSTRUCT">PLAN & CONSTRUCT</option>
                <option value="MARKET & TRANSACT">MARKET & TRANSACT</option>
                <option value="OPERATE & MANAGE">OPERATE & MANAGE</option>
                <option value="REINVEST, REPORT & REGENERATE">REINVEST, REPORT & REGENERATE</option>
            </select>
            <small>Select the main category that best describes your business</small>
        </div>

        <div class="form-group">
            <label>Categories / Tags <span class="required">*</span></label>
            <small style="display:block;margin-bottom:10px;">Select all that apply (categories will appear based on your selected vertical)</small>
            <div id="categoriesContainer" style="display:grid;grid-template-columns:repeat(2,1fr);gap:8px;">
                <p style="grid-column:1/-1;color:var(--text-muted);font-style:italic;">Please select a Vertical above first</p>
            </div>
        </div>

        <div class="form-group">
            <label>Contact Person <span class="required">*</span></label>
            <input type="text" name="contact_name" required>
        </div>

        <div class="form-group">
            <label>Contact Email <span class="required">*</span></label>
            <input type="email" name="contact_email" required>
        </div>

        <div class="form-group">
            <label>Contact Phone</label>
            <input type="tel" name="contact_phone" placeholder="+60123456789">
            <small>Optional</small>
        </div>

        <div class="form-group">
            <label style="font-weight: 600; margin-bottom: 15px; color: var(--text-primary);">Social Media Links (Optional)</label>
            
            <div style="margin-bottom: 15px;">
                <label style="font-weight: 500; margin-bottom: 5px; display: block;">🔗 LinkedIn</label>
                <input type="url" name="linkedin_url" placeholder="https://www.linkedin.com/company/yourcompany">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="font-weight: 500; margin-bottom: 5px; display: block;">📘 Facebook</label>
                <input type="url" name="facebook_url" placeholder="https://www.facebook.com/yourpage">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="font-weight: 500; margin-bottom: 5px; display: block;">📸 Instagram</label>
                <input type="url" name="instagram_url" placeholder="https://www.instagram.com/yourhandle">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="font-weight: 500; margin-bottom: 5px; display: block;">▶️ YouTube</label>
                <input type="url" name="youtube_url" placeholder="https://www.youtube.com/@yourchannel">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="font-weight: 500; margin-bottom: 5px; display: block;">🎶 TikTok</label>
                <input type="url" name="tiktok_url" placeholder="https://www.tiktok.com/@yourhandle">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="font-weight: 500; margin-bottom: 5px; display: block;">🐦 Twitter/X</label>
                <input type="url" name="twitter_url" placeholder="https://twitter.com/yourhandle">
            </div>
            
            <small style="display: block; margin-top: 10px;">All social media links are optional</small>
        </div>

        <button type="submit" class="submit-btn">Submit Update</button>
    </form>
</div>

<script>
// Category options based on vertical (loaded from centralized database settings)
const verticalCategories = <?php echo json_encode(array_map(function($v) { return $v['categories']; }, mpa_get_vertical_categories())); ?>;

// Update categories when vertical changes
document.querySelector('select[name="vertical"]').addEventListener('change', function() {
    const vertical = this.value;
    const container = document.getElementById('categoriesContainer');
    
    if (!vertical) {
        container.innerHTML = '<p style="grid-column:1/-1;color:var(--text-muted);font-style:italic;">Please select a Vertical above first</p>';
        return;
    }
    
    const categories = verticalCategories[vertical] || [];
    container.innerHTML = categories.map(cat => `
        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;padding:8px;border:1px solid var(--glass-border);border-radius:4px;background:var(--bg-tertiary);transition:all 0.2s;">
            <input type="checkbox" name="categories[]" value="${cat}" style="cursor:pointer;"> ${cat}
        </label>
    `).join('');
});

// Auto-add https:// to website field
document.getElementById('company_website').addEventListener('blur', function() {
    let url = this.value.trim();
    if (url && !url.match(/^https?:\/\//i)) {
        this.value = 'https://' + url.replace(/^\/+/, '');
    }
});

// Word counter function
function countWords(text) {
    if (!text || text.trim() === '') return 0;
    return text.trim().split(/\s+/).filter(word => word.length > 0).length;
}

// Handle textarea focus and word counting
const descriptionTextarea = document.getElementById('company_description');
const wordCountDisplay = document.getElementById('wordCount');
const maxWords = 200;

function updateWordCount() {
    const text = descriptionTextarea.value;
    const wordCount = countWords(text);
    
    // Change color when user starts typing
    if (text && !text.includes('[Company Name]') && !text.includes('[positioning]')) {
        descriptionTextarea.style.color = '#333';
    }
    
    // Update word count display
    if (wordCount > maxWords) {
        wordCountDisplay.textContent = wordCount + ' / 200 words';
        wordCountDisplay.style.color = '#e74c3c';
        wordCountDisplay.style.fontWeight = 'bold';
    } else {
        wordCountDisplay.textContent = wordCount + ' / 200 words';
        wordCountDisplay.style.color = '#666';
        wordCountDisplay.style.fontWeight = '500';
    }
}

descriptionTextarea.addEventListener('focus', function() {
    if (this.value.includes('[Company Name]') || this.value.includes('[positioning]')) {
        this.style.color = '#333';
    }
    updateWordCount();
});

descriptionTextarea.addEventListener('input', function() {
    updateWordCount();
    
    // Prevent typing beyond 300 words
    const text = this.value;
    const wordCount = countWords(text);
    
    if (wordCount > maxWords) {
        // Get the last valid position
        const words = text.trim().split(/\s+/);
        const validWords = words.slice(0, maxWords);
        const lastValidText = validWords.join(' ');
        const cursorPos = this.selectionStart;
        
        // If cursor is at the end, truncate
        if (cursorPos >= lastValidText.length) {
            this.value = lastValidText;
            this.setSelectionRange(lastValidText.length, lastValidText.length);
        }
        
        // Show warning
        if (!document.getElementById('wordLimitWarning')) {
            const warning = document.createElement('div');
            warning.id = 'wordLimitWarning';
            warning.style.cssText = 'margin-top: 5px; padding: 8px; background: #ffe6e6; border: 1px solid #e74c3c; border-radius: 4px; color: #c0392b; font-size: 13px;';
            warning.textContent = '⚠️ Maximum word limit reached (200 words). Please shorten your pitch.';
            this.parentElement.appendChild(warning);
        }
    } else {
        // Remove warning if it exists
        const warning = document.getElementById('wordLimitWarning');
        if (warning) {
            warning.remove();
        }
    }
});

// Initialize word count on page load
updateWordCount();

// Form submission
document.getElementById('memberSubmissionForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('.submit-btn');
    const messageDiv = document.getElementById('formMessage');
    
    // Validate word count
    const descriptionText = descriptionTextarea.value.trim();
    const wordCount = countWords(descriptionText);
    if (wordCount > maxWords) {
        messageDiv.innerHTML = '<div class="alert alert-error">❌ Please keep your elevator pitch under 200 words. Currently: ' + wordCount + ' words.</div>';
        window.scrollTo({ top: 0, behavior: 'smooth' });
        descriptionTextarea.focus();
        return;
    }
    
    if (wordCount === 0 || descriptionText === '') {
        messageDiv.innerHTML = '<div class="alert alert-error">❌ Please enter your company elevator pitch</div>';
        window.scrollTo({ top: 0, behavior: 'smooth' });
        descriptionTextarea.focus();
        return;
    }
    
    // Validate at least one category is selected
    const checkedCategories = document.querySelectorAll('input[name="categories[]"]:checked');
    if (checkedCategories.length === 0) {
        messageDiv.innerHTML = '<div class="alert alert-error">❌ Please select at least one category/tag</div>';
        window.scrollTo({ top: 0, behavior: 'smooth' });
        return;
    }
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Submitting...';
    messageDiv.innerHTML = '';
    
    const formData = new FormData(this);
    formData.append('action', 'submit_member_application');
    formData.append('nonce', '<?php echo wp_create_nonce('member_submission_nonce'); ?>');
    
    try {
        const response = await fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            messageDiv.innerHTML = '<div class="alert alert-success">✅ ' + result.data.message + '</div>';
            this.reset();
        } else {
            messageDiv.innerHTML = '<div class="alert alert-error">❌ ' + result.data.message + '</div>';
        }
    } catch (error) {
        messageDiv.innerHTML = '<div class="alert alert-error">❌ An error occurred. Please try again.</div>';
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Submit Update';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});
</script>

<?php get_footer(); ?>


<?php
/**
 * Template Name: Member Submission Form
 */
get_header();
?>

<style>
.submission-form-container {
    max-width: 800px;
    margin: 60px auto;
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
</style>

<div class="submission-form-container">
    <h1>🚀 Update Member Information</h1>
    <p class="intro-text">Update your company information</p>

    <div id="formMessage"></div>

    <form id="memberSubmissionForm" enctype="multipart/form-data">
        <div class="form-group">
            <label>Company Name <span class="required">*</span></label>
            <input type="text" name="company_name" required>
        </div>

        <div class="form-group">
            <label>Company Description <span class="required">*</span></label>
            <textarea name="company_description" required></textarea>
            <small>Brief description of your company (100-200 words)</small>
        </div>

        <div class="form-group">
            <label>Company Website <span class="required">*</span></label>
            <input type="text" id="company_website" name="company_website" placeholder="www.example.com or https://example.com" required>
            <small>Enter your website (https:// will be added automatically)</small>
        </div>

        <div class="form-group">
            <label>Company Logo <span class="required">*</span></label>
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

// Form submission
document.getElementById('memberSubmissionForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('.submit-btn');
    const messageDiv = document.getElementById('formMessage');
    
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


<?php
/**
 * Template Name: Event Registration
 * Description: Event registration form template with attendee information capture
 */

get_header();

// Get event ID from URL parameter
$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
$event = null;
$event_title = '';
$event_date = '';
$event_time = '';
$event_location = '';
$event_description = '';
$event_image = '';

if ($event_id > 0) {
    $event = get_post($event_id);
    if ($event && $event->post_type === 'mpa_event') {
        $event_title = $event->post_title;
        $event_date = get_post_meta($event_id, '_event_date', true);
        $event_time = get_post_meta($event_id, '_event_time', true);
        $event_location = get_post_meta($event_id, '_event_location', true);
        $event_description = wp_trim_words($event->post_content, 30, '...');
        $event_image = get_the_post_thumbnail_url($event_id, 'large');
    }
}

// Check if event is online (no dietary requirements needed)
$is_online_event = (stripos($event_location, 'online') !== false || stripos($event_location, 'virtual') !== false || stripos($event_location, 'zoom') !== false);
?>

<style>
/* Event Registration Page Styles */
.registration-page {
    min-height: 100vh;
    padding: var(--spacing-xxl) 0;
    background: var(--bg-primary);
}

body:not(.light-mode) .registration-page {
    background: var(--bg-primary-dark);
}

.registration-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 var(--spacing-lg);
}

.registration-header {
    text-align: center;
    margin-bottom: var(--spacing-xxl);
}

.registration-header h1 {
    font-size: 2.5rem;
    margin-bottom: var(--spacing-md);
    color: var(--text-primary);
}

body:not(.light-mode) .registration-header h1 {
    color: var(--text-primary-dark);
}

.registration-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--spacing-xxl);
    align-items: start;
}

@media (max-width: 768px) {
    .registration-content {
        grid-template-columns: 1fr;
    }
}

/* Event Info Card */
.event-info-section {
    background: var(--bg-secondary);
    border-radius: var(--border-radius-lg);
    padding: var(--spacing-xl);
    border: 1px solid var(--glass-border);
    position: sticky;
    top: 100px;
}

body:not(.light-mode) .event-info-section {
    background: var(--bg-secondary-dark);
    border-color: rgba(255, 255, 255, 0.1);
}

.event-info-section h2 {
    font-size: 1.8rem;
    margin-bottom: var(--spacing-md);
    color: var(--text-primary);
}

body:not(.light-mode) .event-info-section h2 {
    color: var(--text-primary-dark);
}

.event-featured-image {
    width: 100%;
    border-radius: var(--border-radius-md);
    margin-bottom: var(--spacing-lg);
    overflow: hidden;
}

.event-featured-image img {
    width: 100%;
    height: auto;
    display: block;
}

.event-detail {
    display: flex;
    align-items: start;
    gap: var(--spacing-md);
    margin-bottom: var(--spacing-md);
    padding: var(--spacing-md);
    background: var(--glass-bg);
    border-radius: var(--border-radius-md);
}

body:not(.light-mode) .event-detail {
    background: rgba(255, 255, 255, 0.05);
}

.event-detail i {
    color: var(--accent-blue);
    font-size: 1.2rem;
    margin-top: 3px;
}

.event-detail-content strong {
    display: block;
    margin-bottom: 4px;
    color: var(--text-primary);
}

body:not(.light-mode) .event-detail-content strong {
    color: var(--text-primary-dark);
}

.event-detail-content span {
    color: var(--text-secondary);
}

body:not(.light-mode) .event-detail-content span {
    color: var(--text-secondary-dark);
}

.event-description {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-top: var(--spacing-lg);
    padding-top: var(--spacing-lg);
    border-top: 1px solid var(--glass-border);
}

body:not(.light-mode) .event-description {
    color: var(--text-secondary-dark);
    border-color: rgba(255, 255, 255, 0.1);
}

/* Registration Form */
.registration-form-section {
    background: var(--bg-secondary);
    border-radius: var(--border-radius-lg);
    padding: var(--spacing-xl);
    border: 1px solid var(--glass-border);
}

body:not(.light-mode) .registration-form-section {
    background: var(--bg-secondary-dark);
    border-color: rgba(255, 255, 255, 0.1);
}

.registration-form-section h2 {
    font-size: 1.8rem;
    margin-bottom: var(--spacing-sm);
    color: var(--text-primary);
}

body:not(.light-mode) .registration-form-section h2 {
    color: var(--text-primary-dark);
}

.form-intro {
    color: var(--text-secondary);
    margin-bottom: var(--spacing-xl);
}

body:not(.light-mode) .form-intro {
    color: var(--text-secondary-dark);
}

.form-group {
    margin-bottom: var(--spacing-lg);
}

.form-group label {
    display: block;
    margin-bottom: var(--spacing-xs);
    font-weight: 600;
    color: var(--text-primary);
}

body:not(.light-mode) .form-group label {
    color: var(--text-primary-dark);
}

.form-group .required {
    color: #d63638;
}

.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="tel"],
.form-group textarea,
.form-group select {
    width: 100%;
    padding: var(--spacing-md);
    border: 1px solid var(--glass-border);
    border-radius: var(--border-radius-md);
    background: var(--bg-primary);
    color: var(--text-primary);
    font-size: 1rem;
    transition: var(--transition-normal);
}

body:not(.light-mode) .form-group input[type="text"],
body:not(.light-mode) .form-group input[type="email"],
body:not(.light-mode) .form-group input[type="tel"],
body:not(.light-mode) .form-group textarea,
body:not(.light-mode) .form-group select {
    background: var(--bg-primary-dark);
    border-color: rgba(255, 255, 255, 0.1);
    color: var(--text-primary-dark);
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
    outline: none;
    border-color: var(--accent-blue);
    box-shadow: 0 0 0 3px rgba(0, 122, 255, 0.1);
}

.form-group textarea {
    min-height: 100px;
    resize: vertical;
}

.form-group small {
    display: block;
    margin-top: var(--spacing-xs);
    color: var(--text-secondary);
    font-size: 0.875rem;
}

body:not(.light-mode) .form-group small {
    color: var(--text-secondary-dark);
}

.submit-btn {
    width: 100%;
    padding: var(--spacing-md) var(--spacing-xl);
    background: var(--accent-blue);
    color: white;
    border: none;
    border-radius: var(--border-radius-md);
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition-normal);
}

.submit-btn:hover {
    background: #0056b3;
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.submit-btn:disabled {
    background: #6c757d;
    cursor: not-allowed;
    transform: none;
}

.success-message,
.error-message {
    padding: var(--spacing-lg);
    border-radius: var(--border-radius-md);
    margin-bottom: var(--spacing-lg);
    display: none;
}

.success-message {
    background: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.error-message {
    background: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.success-message.show,
.error-message.show {
    display: block;
}
</style>

<div class="registration-page">
    <div class="registration-container">
        
        <div class="registration-header">
            <h1>📝 Event Registration</h1>
        </div>

        <?php if ($event): ?>
        
        <div class="registration-content">
            
            <!-- Event Information -->
            <div class="event-info-section">
                <h2><?php echo esc_html($event_title); ?></h2>
                
                <?php if ($event_image): ?>
                <div class="event-featured-image">
                    <img src="<?php echo esc_url($event_image); ?>" alt="<?php echo esc_attr($event_title); ?>">
                </div>
                <?php endif; ?>
                
                <?php if ($event_date): ?>
                <div class="event-detail">
                    <i class="fas fa-calendar"></i>
                    <div class="event-detail-content">
                        <strong>Date</strong>
                        <span><?php echo esc_html(date('l, F j, Y', strtotime($event_date))); ?></span>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if ($event_time): ?>
                <div class="event-detail">
                    <i class="fas fa-clock"></i>
                    <div class="event-detail-content">
                        <strong>Time</strong>
                        <span><?php echo esc_html($event_time); ?></span>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if ($event_location): ?>
                <div class="event-detail">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="event-detail-content">
                        <strong>Location</strong>
                        <span><?php echo esc_html($event_location); ?></span>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if ($event_description): ?>
                <div class="event-description">
                    <strong>About This Event</strong>
                    <p><?php echo esc_html($event_description); ?></p>
                    <a href="<?php echo get_permalink($event_id); ?>" class="btn-link">View full details →</a>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Registration Form -->
            <div class="registration-form-section">
                <h2>Register Now</h2>
                <p class="form-intro">Please fill in your details below to register for this event.</p>
                
                <div class="success-message" id="successMessage">
                    <strong>✅ Registration Successful!</strong><br>
                    Thank you for registering. A confirmation email has been sent to your email address.
                </div>
                
                <div class="error-message" id="errorMessage"></div>
                
                <form id="eventRegistrationForm">
                    <input type="hidden" name="event_id" value="<?php echo esc_attr($event_id); ?>">
                    <input type="hidden" name="action" value="submit_event_registration">
                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('event_registration_nonce'); ?>">
                    
                    <div class="form-group">
                        <label for="full_name">Full Name <span class="required">*</span></label>
                        <input type="text" id="full_name" name="full_name" required placeholder="John Doe">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address <span class="required">*</span></label>
                        <input type="email" id="email" name="email" required placeholder="john@example.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone Number <span class="required">*</span></label>
                        <input type="tel" id="phone" name="phone" required placeholder="+60123456789">
                    </div>
                    
                    <div class="form-group">
                        <label for="company">Company / Organization</label>
                        <input type="text" id="company" name="company" placeholder="Your Company Name">
                        <small>Optional</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="job_title">Job Title / Position</label>
                        <input type="text" id="job_title" name="job_title" placeholder="e.g., CEO, Developer, Manager">
                        <small>Optional</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="membership_status">Membership Status <span class="required">*</span></label>
                        <select id="membership_status" name="membership_status" required>
                            <option value="">-- Select --</option>
                            <option value="mpa_member">MPA Member</option>
                            <option value="non_member">Non-MPA Member</option>
                        </select>
                    </div>
                    
                    <?php if (!$is_online_event) : ?>
                    <div class="form-group">
                        <label for="dietary">Dietary Requirements</label>
                        <select id="dietary" name="dietary">
                            <option value="">None</option>
                            <option value="vegetarian">Vegetarian</option>
                            <option value="vegan">Vegan</option>
                            <option value="halal">Halal</option>
                            <option value="gluten-free">Gluten-Free</option>
                            <option value="other">Other (specify in notes)</option>
                        </select>
                        <small>Optional - For catering purposes</small>
                    </div>
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <label for="notes">Special Requests / Notes</label>
                        <textarea id="notes" name="notes" placeholder="Any special requests or additional information..."></textarea>
                        <small>Optional</small>
                    </div>
                    
                    <button type="submit" class="submit-btn" id="submitBtn">
                        Submit Registration
                    </button>
                </form>
            </div>
            
        </div>
        
        <?php else: ?>
        
        <div class="registration-form-section" style="text-align: center; padding: var(--spacing-xxl);">
            <h2>❌ Event Not Found</h2>
            <p style="margin: var(--spacing-lg) 0;">The event you're trying to register for could not be found.</p>
            <a href="/events/" class="btn-primary">← Back to Events</a>
        </div>
        
        <?php endif; ?>
        
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('eventRegistrationForm');
    const submitBtn = document.getElementById('submitBtn');
    const successMessage = document.getElementById('successMessage');
    const errorMessage = document.getElementById('errorMessage');
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.textContent = 'Submitting...';
        
        // Hide previous messages
        successMessage.classList.remove('show');
        errorMessage.classList.remove('show');
        
        // Prepare form data
        const formData = new FormData(form);
        
        try {
            const response = await fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                successMessage.classList.add('show');
                form.reset();
                
                // Scroll to success message
                successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                errorMessage.textContent = '❌ ' + (result.data.message || 'Registration failed. Please try again.');
                errorMessage.classList.add('show');
                
                // Scroll to error message
                errorMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        } catch (error) {
            errorMessage.textContent = '❌ Network error. Please check your connection and try again.';
            errorMessage.classList.add('show');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Submit Registration';
        }
    });
});
</script>

<?php get_footer(); ?>


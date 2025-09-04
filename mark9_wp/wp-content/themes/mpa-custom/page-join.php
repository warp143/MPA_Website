<?php get_header(); ?>

<!-- Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="hero-content">
            <h1><?php the_title(); ?></h1>
            <p><?php 
                $hero_description = get_post_meta(get_the_ID(), '_hero_description', true);
                echo $hero_description ?: 'Complete your membership application to become part of Malaysia\'s leading PropTech community';
            ?></p>
        </div>
        <div class="hero-image">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large', array('alt' => get_the_title() . ' Hero')); ?>
            <?php else : ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/join-hero.jpg" alt="<?php echo esc_attr(get_the_title()); ?>">
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Application Form -->
<section class="join-form-section">
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h2>Membership Application</h2>
                <p>Please fill out the form below to apply for MPA membership. Our team will review your application within 5-7 business days.</p>
            </div>

            <form class="join-form" id="joinForm">
                <!-- Company Information -->
                <div class="form-section">
                    <h3><i class="fas fa-building"></i> Company Information</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="companyName">Company Name *</label>
                            <input type="text" id="companyName" name="companyName" required>
                        </div>
                        <div class="form-group">
                            <label for="companyType">Company Type *</label>
                            <select id="companyType" name="companyType" required>
                                <option value="">Select company type</option>
                                <option value="startup">Startup</option>
                                <option value="scaleup">Scale-up</option>
                                <option value="enterprise">Enterprise</option>
                                <option value="agency">Agency</option>
                                <option value="consultancy">Consultancy</option>
                                <option value="academic">Academic Institution</option>
                                <option value="government">Government</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="industry">Primary Industry *</label>
                            <select id="industry" name="industry" required>
                                <option value="">Select primary industry</option>
                                <option value="plan">PLAN - Planning & Development</option>
                                <option value="construct">CONSTRUCT - Construction & Building</option>
                                <option value="transact">TRANSACT - Transactions & Marketplace</option>
                                <option value="manage">MANAGE - Property Management</option>
                                <option value="fintech">FinTech</option>
                                <option value="proptech">PropTech</option>
                                <option value="contech">ConTech</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="website">Website</label>
                            <input type="url" id="website" name="website" placeholder="https://example.com">
                        </div>
                        <div class="form-group full-width">
                            <label for="description">Company Description *</label>
                            <textarea id="description" name="description" rows="4" required placeholder="Describe your company's focus, products/services, and PropTech involvement"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="form-section">
                    <h3><i class="fas fa-user"></i> Primary Contact</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="firstName">First Name *</label>
                            <input type="text" id="firstName" name="firstName" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name *</label>
                            <input type="text" id="lastName" name="lastName" required>
                        </div>
                        <div class="form-group">
                            <label for="position">Position/Title *</label>
                            <input type="text" id="position" name="position" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="linkedin">LinkedIn Profile</label>
                            <input type="url" id="linkedin" name="linkedin" placeholder="https://linkedin.com/in/username">
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="form-section">
                    <h3><i class="fas fa-map-marker-alt"></i> Address Information</h3>
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="address">Street Address *</label>
                            <input type="text" id="address" name="address" required>
                        </div>
                        <div class="form-group">
                            <label for="city">City *</label>
                            <input type="text" id="city" name="city" required>
                        </div>
                        <div class="form-group">
                            <label for="state">State *</label>
                            <input type="text" id="state" name="state" required>
                        </div>
                        <div class="form-group">
                            <label for="postcode">Postal Code *</label>
                            <input type="text" id="postcode" name="postcode" required>
                        </div>
                        <div class="form-group">
                            <label for="country">Country *</label>
                            <select id="country" name="country" required>
                                <option value="">Select country</option>
                                <option value="MY" selected>Malaysia</option>
                                <option value="SG">Singapore</option>
                                <option value="ID">Indonesia</option>
                                <option value="TH">Thailand</option>
                                <option value="PH">Philippines</option>
                                <option value="VN">Vietnam</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Membership Selection -->
                <div class="form-section">
                    <h3><i class="fas fa-crown"></i> Membership Tier</h3>
                    <div class="membership-options">
                        <div class="membership-option">
                            <input type="radio" id="startup" name="membershipTier" value="startup" required>
                            <label for="startup" class="membership-label">
                                <div class="tier-info">
                                    <h4>Startup</h4>
                                    <div class="price">RM 500<span>/year</span></div>
                                    <p>Perfect for early-stage PropTech startups</p>
                                </div>
                                <div class="tier-benefits">
                                    <ul>
                                        <li>Access to all MPA events and webinars</li>
                                        <li>Member directory listing</li>
                                        <li>Monthly newsletter subscription</li>
                                        <li>Access to resource library</li>
                                    </ul>
                                </div>
                            </label>
                        </div>

                        <div class="membership-option">
                            <input type="radio" id="professional" name="membershipTier" value="professional" required>
                            <label for="professional" class="membership-label featured">
                                <div class="tier-info">
                                    <h4>Professional</h4>
                                    <div class="price">RM 1,000<span>/year</span></div>
                                    <p>For established companies and professionals</p>
                                </div>
                                <div class="tier-benefits">
                                    <ul>
                                        <li>All Startup benefits</li>
                                        <li>Priority event registration</li>
                                        <li>Exclusive networking events</li>
                                        <li>Mentorship program access</li>
                                    </ul>
                                </div>
                            </label>
                        </div>

                        <div class="membership-option">
                            <input type="radio" id="enterprise" name="membershipTier" value="enterprise" required>
                            <label for="enterprise" class="membership-label">
                                <div class="tier-info">
                                    <h4>Enterprise</h4>
                                    <div class="price">RM 5,000<span>/year</span></div>
                                    <p>For large organizations and industry leaders</p>
                                </div>
                                <div class="tier-benefits">
                                    <ul>
                                        <li>All Professional benefits</li>
                                        <li>Board advisory opportunities</li>
                                        <li>Custom workshops and training</li>
                                        <li>Dedicated account manager</li>
                                    </ul>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="form-section">
                    <h3><i class="fas fa-info-circle"></i> Additional Information</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="teamSize">Team Size</label>
                            <select id="teamSize" name="teamSize">
                                <option value="">Select team size</option>
                                <option value="1-5">1-5 employees</option>
                                <option value="6-20">6-20 employees</option>
                                <option value="21-50">21-50 employees</option>
                                <option value="51-100">51-100 employees</option>
                                <option value="100+">100+ employees</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="foundedYear">Founded Year</label>
                            <input type="number" id="foundedYear" name="foundedYear" min="1900" max="2025" placeholder="e.g., 2020">
                        </div>
                        <div class="form-group full-width">
                            <label for="interests">Areas of Interest</label>
                            <textarea id="interests" name="interests" rows="3" placeholder="What specific areas of PropTech are you most interested in? (e.g., AI, Blockchain, IoT, etc.)"></textarea>
                        </div>
                        <div class="form-group full-width">
                            <label for="expectations">What do you hope to achieve through MPA membership?</label>
                            <textarea id="expectations" name="expectations" rows="3" placeholder="Describe your goals and expectations from joining MPA"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="form-section">
                    <div class="form-group checkbox-group">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">
                            I agree to the <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>" target="_blank">Terms and Conditions</a> and <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>" target="_blank">Privacy Policy</a> *
                        </label>
                    </div>
                    <div class="form-group checkbox-group">
                        <input type="checkbox" id="newsletter" name="newsletter">
                        <label for="newsletter">
                            I would like to receive MPA newsletters and updates
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-paper-plane"></i>
                        Submit Application
                    </button>
                    <p class="form-note">* Required fields. Applications are reviewed within 5-7 business days.</p>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const joinForm = document.getElementById('joinForm');
    
    if (joinForm) {
        joinForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const companyName = formData.get('companyName');
            const email = formData.get('email');
            const membershipTier = formData.get('membershipTier');
            const termsAccepted = formData.get('terms');
            
            // Basic validation
            if (!companyName || !email || !membershipTier || !termsAccepted) {
                showNotification('Please fill in all required fields and accept the terms and conditions.', 'error');
                return;
            }
            
            // Demo functionality - show success message
            showNotification(`Thank you ${companyName}! Your ${membershipTier} membership application has been submitted successfully. We'll review it within 5-7 business days and contact you at ${email}.`, 'success');
            
            // Reset form
            this.reset();
        });
    }
    
    // Membership tier selection highlighting
    const membershipOptions = document.querySelectorAll('input[name="membershipTier"]');
    membershipOptions.forEach(option => {
        option.addEventListener('change', function() {
            // Remove selected class from all options
            document.querySelectorAll('.membership-label').forEach(label => {
                label.classList.remove('selected');
            });
            
            // Add selected class to chosen option
            if (this.checked) {
                this.nextElementSibling.classList.add('selected');
            }
        });
    });
    
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? 'var(--accent-green)' : type === 'error' ? 'var(--accent-red)' : type === 'warning' ? 'var(--accent-orange)' : 'var(--accent-blue)'};
            color: white;
            padding: var(--spacing-md);
            border-radius: var(--border-radius-md);
            box-shadow: var(--shadow-md);
            z-index: 1000;
            font-weight: 500;
            animation: slideIn 0.3s ease;
            max-width: 400px;
            line-height: 1.4;
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 6000);
    }
});
</script>

<?php get_footer(); ?>

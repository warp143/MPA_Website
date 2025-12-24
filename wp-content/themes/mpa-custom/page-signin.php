<?php get_header(); ?>

<!-- Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="hero-content">
            <h1><?php the_title(); ?></h1>
            <p><?php 
                $hero_description = get_post_meta(get_the_ID(), '_hero_description', true);
                echo $hero_description ?: 'Access your MPA member portal and connect with Malaysia\'s PropTech community';
            ?></p>
        </div>
        <div class="hero-image">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large', array('alt' => get_the_title() . ' Hero')); ?>
            <?php else : ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/signin-hero.jpg" alt="<?php echo esc_attr(get_the_title()); ?>">
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
.signin-page {
    min-height: 100vh;
    background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: var(--spacing-lg);
}

.signin-container {
    background: var(--bg-secondary);
    border: 1px solid var(--glass-border);
    border-radius: 16px;
    box-shadow: var(--shadow-lg);
    padding: 48px;
    width: 100%;
    max-width: 450px;
    position: relative;
}

/* Desktop Layout */
@media (min-width: 1024px) {
    .signin-page {
        padding: 0;
        background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
        min-height: calc(100vh - 80px);
        margin-top: 80px;
    }

    .signin-container {
        max-width: 1200px;
        width: 95%;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
        padding: 0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        min-height: 600px;
    }

    .signin-left {
        background: var(--bg-secondary);
        padding: 80px 60px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        border-right: 1px solid var(--glass-border);
    }

    .signin-right {
        background: var(--bg-secondary);
        padding: 80px 60px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: var(--text-primary);
    }

    .signin-header {
        text-align: left;
        margin-bottom: 50px;
        width: 100%;
    }

    .signin-title {
        font-size: 2.5rem;
        margin-bottom: 16px;
        font-weight: 700;
    }

    .signin-subtitle {
        font-size: 1.2rem;
        line-height: 1.6;
        color: #666666;
    }

    .signin-form {
        margin-bottom: 50px;
        width: 100%;
    }

    .form-group {
        margin-bottom: 32px;
    }

    .form-input {
        padding: 18px;
        font-size: 1rem;
    }

    .signin-btn {
        padding: 18px;
        font-size: 1rem;
    }

    .signin-links {
        margin-bottom: 50px;
        width: 100%;
    }

    .signup-section {
        width: 100%;
        margin: 0;
        max-width: 450px;
        margin-left: auto;
        margin-right: auto;
    }

    .feature-list li {
        padding: 16px 0;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 20px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        color: var(--text-primary-light);
    }

    .feature-list li:last-child {
        border-bottom: none;
    }

    .feature-list li i {
        font-size: 1.4rem;
        color: var(--accent-blue);
        width: 24px;
        text-align: center;
    }

    .desktop-cta {
        margin-top: auto;
        width: 100%;
        padding-top: 40px;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .desktop-cta h4 {
        font-size: 1.8rem;
        margin-bottom: 20px;
        font-weight: 600;
        line-height: 1.3;
        color: var(--text-primary-light);
    }

    .desktop-cta p {
        font-size: 1.1rem;
        margin-bottom: 30px;
        opacity: 0.95;
        line-height: 1.6;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
        color: var(--text-secondary-light);
    }

    .desktop-cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 20px 40px;
        background: var(--accent-blue);
        color: #ffffff !important;
        text-decoration: none;
        border: 2px solid var(--accent-blue);
        border-radius: 12px;
        font-weight: 600;
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }

    .desktop-cta-btn:hover {
        background: var(--accent-purple);
        border-color: var(--accent-purple);
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0, 122, 255, 0.3);
    }
}

.signin-header {
    text-align: center;
    margin-bottom: 32px;
}

.signin-logo {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--accent-blue);
    margin-bottom: 16px;
}

.signin-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 8px;
}

.signin-subtitle {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.signin-form {
    margin-bottom: 32px;
}

.form-group {
    margin-bottom: 24px;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: var(--text-primary);
    font-size: 0.9rem;
}

.form-input {
    width: 100%;
    padding: 14px;
    border: 2px solid var(--glass-border);
    border-radius: 8px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: var(--bg-tertiary);
    color: var(--text-primary);
}

.form-input:focus {
    outline: none;
    border-color: var(--accent-blue);
    box-shadow: 0 0 0 3px rgba(0, 122, 255, 0.2);
}

.form-checkbox {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 24px;
}

.form-checkbox input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: var(--accent-blue);
}

.form-checkbox label {
    color: #666666;
    font-size: 0.9rem;
}

.signin-btn {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
    color: #ffffff !important;
    border: none;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.signin-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 122, 255, 0.3);
}

.signin-links {
    text-align: center;
    padding-top: 24px;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    margin-bottom: 32px;
}

.signin-links p {
    color: var(--text-secondary);
    margin-bottom: 16px;
    font-size: 0.8rem;
}

.signin-links a {
    color: var(--accent-blue);
    text-decoration: none;
    font-weight: 500;
    margin: 0 16px;
    transition: all 0.3s ease;
}

.signin-links a:hover {
    text-decoration: underline;
}

.signup-section {
    text-align: center;
    padding: 32px;
    background: var(--bg-tertiary);
    border: 1px solid var(--glass-border);
    border-radius: 12px;
}

.signup-section h3 {
    margin-bottom: 16px;
    color: var(--text-primary);
}

.signup-section p {
    color: var(--text-secondary);
    margin-bottom: 24px;
    font-size: 0.9rem;
}

.signup-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 16px 32px;
    background: transparent;
    color: var(--accent-blue);
    text-decoration: none;
    border: 2px solid var(--accent-blue);
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.signup-btn:hover {
    background: var(--accent-blue);
    color: #ffffff !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 122, 255, 0.3);
}

@media (max-width: 768px) {
    .signin-container {
        padding: 32px;
        margin: 16px;
    }
}
</style>

<!-- Sign In Section -->
<section class="signin-page">
    <div class="signin-container">
        <!-- Left Side - Sign In Form (Desktop) / Full Form (Mobile) -->
        <div class="signin-left">
            <div class="signin-header">
                <div class="signin-logo">MPA</div>
                <h1 class="signin-title">Welcome Back</h1>
                <p class="signin-subtitle">Sign in to access your member dashboard</p>
            </div>
            
            <form class="signin-form" id="signinForm">
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>
                
                <div class="form-checkbox">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Keep me signed in</label>
                </div>
                
                <button type="submit" class="signin-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    Sign In
                </button>
            </form>
            
            <div class="signin-links">
                <p>Need help?</p>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact Support</a>
                <a href="<?php echo esc_url(home_url('/forgot-password/')); ?>">Forgot Password?</a>
            </div>

            <div class="signup-section">
                <h3>Not a Member Yet?</h3>
                <p>Join the Malaysia PropTech Association to access exclusive resources, networking opportunities, and industry insights.</p>
                <a href="<?php echo esc_url(home_url('/membership/')); ?>" class="signup-btn">
                    <i class="fas fa-user-plus"></i>
                    Join MPA Today
                </a>
            </div>

        </div>

        <!-- Right Side - Desktop Only Features -->
        <div class="signin-right">
            <div class="desktop-features">
                <h3>Why Join MPA?</h3>
                <p>Connect with Malaysia's leading PropTech community and accelerate your growth in the digital real estate ecosystem.</p>
                
                <ul class="feature-list">
                    <li>
                        <i class="fas fa-users"></i>
                        <span>150+ Active Members</span>
                    </li>
                    <li>
                        <i class="fas fa-calendar-alt"></i>
                        <span>50+ Events Annually</span>
                    </li>
                    <li>
                        <i class="fas fa-handshake"></i>
                        <span>25+ Strategic Partners</span>
                    </li>
                    <li>
                        <i class="fas fa-lightbulb"></i>
                        <span>Innovation Showcase</span>
                    </li>
                    <li>
                        <i class="fas fa-graduation-cap"></i>
                        <span>Educational Resources</span>
                    </li>
                    <li>
                        <i class="fas fa-globe"></i>
                        <span>Global Network Access</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('signinForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        
        if (email && password) {
            // Demo functionality - show success message
            showNotification('Demo: Sign in successful! Welcome to MPA.', 'success');
            // In a real app, this would redirect to dashboard
            // window.location.href = 'dashboard.html';
        } else {
            showNotification('Please enter both email and password.', 'warning');
        }
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
            max-width: 300px;
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 4000);
    }
});
</script>

<?php get_footer(); ?>

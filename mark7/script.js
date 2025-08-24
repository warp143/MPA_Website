// Creative Interactive JavaScript

// Mobile Navigation Toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.querySelector('.mobile-toggle');
    const navLinks = document.querySelector('.nav-links');
    
    if (mobileToggle && navLinks) {
        mobileToggle.addEventListener('click', function() {
            navLinks.classList.toggle('active');
            mobileToggle.classList.toggle('active');
        });
        
        // Close mobile menu when clicking on a link
        const navItems = document.querySelectorAll('.nav-item');
        navItems.forEach(item => {
            item.addEventListener('click', function() {
                navLinks.classList.remove('active');
                mobileToggle.classList.remove('active');
            });
        });
    }
});

// Smooth scrolling for navigation links
document.addEventListener('DOMContentLoaded', function() {
    const navItems = document.querySelectorAll('.nav-item');
    
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // If the link contains 'index.html', let it navigate normally
            if (href.includes('index.html')) {
                return; // Don't prevent default, let the link work
            }
            
            // Only prevent default for same-page anchor links
            if (href.startsWith('#')) {
                e.preventDefault();
                const targetElement = document.querySelector(href);
                
                if (targetElement) {
                    const offsetTop = targetElement.offsetTop - 100;
                    window.scrollTo({ top: offsetTop, behavior: 'smooth' });
                }
            }
        });
    });
});

// Navbar background change on scroll
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('.navbar');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.style.background = 'rgba(240, 244, 248, 0.98)';
            navbar.style.backdropFilter = 'blur(25px)';
        } else {
            navbar.style.background = 'rgba(240, 244, 248, 0.95)';
            navbar.style.backdropFilter = 'blur(20px)';
        }
    });
});

// Active navigation highlighting
document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('section[id]');
    const navItems = document.querySelectorAll('.nav-item');
    
    window.addEventListener('scroll', function() {
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 150;
            const sectionHeight = section.clientHeight;
            if (window.scrollY >= sectionTop && window.scrollY < sectionTop + sectionHeight) {
                current = section.getAttribute('id');
            }
        });
        
        navItems.forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('href') === `#${current}`) {
                item.classList.add('active');
            }
        });
    });
});

// Enhanced Intersection Observer for animations
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                entry.target.classList.add('animated');
            }
        });
    }, observerOptions);
    
    // Elements to animate
    const animateElements = document.querySelectorAll(
        '.ecosystem-card, .feature, .showcase-card, .timeline-item, .cta-btn'
    );
    
    animateElements.forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(30px)';
        element.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        observer.observe(element);
    });
});

// Interactive cube rotation
document.addEventListener('DOMContentLoaded', function() {
    const cube = document.querySelector('.interactive-cube');
    
    if (cube) {
        let isHovered = false;
        
        cube.addEventListener('mouseenter', function() {
            isHovered = true;
            this.style.animationPlayState = 'paused';
        });
        
        cube.addEventListener('mouseleave', function() {
            isHovered = false;
            this.style.animationPlayState = 'running';
        });
        
        cube.addEventListener('mousemove', function(e) {
            if (isHovered) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                const rotateX = (y - centerY) / 10;
                const rotateY = (x - centerX) / 10;
                
                this.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
            }
        });
    }
});

// Tech sphere interaction
document.addEventListener('DOMContentLoaded', function() {
    const sphere = document.querySelector('.tech-sphere');
    
    if (sphere) {
        sphere.addEventListener('mouseenter', function() {
            const rings = this.querySelectorAll('.sphere-ring');
            rings.forEach((ring, index) => {
                ring.style.animationDuration = `${5 + index * 2}s`;
            });
        });
        
        sphere.addEventListener('mouseleave', function() {
            const rings = this.querySelectorAll('.sphere-ring');
            rings.forEach((ring, index) => {
                ring.style.animationDuration = `${10 + index * 5}s`;
            });
        });
    }
});

// Button click effects with enhanced ripple
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.action-btn, .cta-btn');
    
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Create enhanced ripple effect
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            // Add click animation
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
});

// Timeline progress animation
document.addEventListener('DOMContentLoaded', function() {
    const timelineItems = document.querySelectorAll('.timeline-item');
    
    const timelineObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const progressBar = entry.target.querySelector('.progress-bar');
                if (progressBar) {
                    const width = progressBar.style.width;
                    progressBar.style.width = '0%';
                    setTimeout(() => {
                        progressBar.style.width = width;
                    }, 500);
                }
            }
        });
    }, { threshold: 0.5 });
    
    timelineItems.forEach(item => {
        timelineObserver.observe(item);
    });
});

// Particle field interaction
document.addEventListener('DOMContentLoaded', function() {
    const particleField = document.querySelector('.particle-field');
    
    if (particleField) {
        particleField.addEventListener('mousemove', function(e) {
            const particles = this.querySelectorAll('.particle');
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            particles.forEach((particle, index) => {
                const speed = (index + 1) * 0.5;
                const moveX = (x - rect.width / 2) * speed / 100;
                const moveY = (y - rect.height / 2) * speed / 100;
                
                particle.style.transform = `translate(${moveX}px, ${moveY}px)`;
            });
        });
        
        particleField.addEventListener('mouseleave', function() {
            const particles = this.querySelectorAll('.particle');
            particles.forEach(particle => {
                particle.style.transform = '';
            });
        });
    }
});

// Ecosystem cards hover effects
document.addEventListener('DOMContentLoaded', function() {
    const ecosystemCards = document.querySelectorAll('.ecosystem-card');
    
    ecosystemCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            const icon = this.querySelector('.card-icon');
            if (icon) {
                icon.style.transform = 'scale(1.1) rotate(5deg)';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            const icon = this.querySelector('.card-icon');
            if (icon) {
                icon.style.transform = 'scale(1) rotate(0deg)';
            }
        });
    });
});

// Showcase cards interaction
document.addEventListener('DOMContentLoaded', function() {
    const showcaseCards = document.querySelectorAll('.showcase-card');
    
    showcaseCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            const avatarRing = this.querySelector('.avatar-ring');
            if (avatarRing) {
                avatarRing.style.animationDuration = '2s';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            const avatarRing = this.querySelector('.avatar-ring');
            if (avatarRing) {
                avatarRing.style.animationDuration = '10s';
            }
        });
    });
});

// Floating shapes parallax effect
document.addEventListener('DOMContentLoaded', function() {
    const shapes = document.querySelectorAll('.shape');
    
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.5;
        
        shapes.forEach((shape, index) => {
            const speed = 0.5 + (index * 0.1);
            shape.style.transform = `translateY(${rate * speed}px) rotate(${rate * 0.1}deg)`;
        });
    });
});

// Enhanced notification system
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    // Add styles
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.padding = '1rem 1.5rem';
    notification.style.borderRadius = '15px';
    notification.style.color = 'white';
    notification.style.fontWeight = '600';
    notification.style.zIndex = '10000';
    notification.style.transform = 'translateX(100%)';
    notification.style.transition = 'transform 0.3s ease';
    notification.style.maxWidth = '300px';
    notification.style.boxShadow = '0 10px 30px rgba(0,0,0,0.2)';
    
    // Set background color based on type
    switch(type) {
        case 'success':
            notification.style.background = 'var(--success)';
            break;
        case 'error':
            notification.style.background = 'var(--error)';
            break;
        default:
            notification.style.background = 'var(--accent-primary)';
    }
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Remove after 4 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 4000);
}

// Form handling with enhanced validation
document.addEventListener('DOMContentLoaded', function() {
    const ctaButtons = document.querySelectorAll('.cta-btn');
    
    ctaButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (this.classList.contains('primary')) {
                showNotification('Launching your idea! We\'ll be in touch soon.', 'success');
            } else {
                showNotification('Opening chat... Let\'s start a conversation!', 'info');
            }
        });
    });
});

// Performance optimization: Lazy loading for images
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
});

// Add enhanced styles for interactions
const enhancedStyles = document.createElement('style');
enhancedStyles.textContent = `
    .action-btn, .cta-btn {
        position: relative;
        overflow: hidden;
    }
    
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.4);
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    .nav-item.active {
        background: var(--shadow-light);
        box-shadow: 
            4px 4px 8px var(--shadow-dark),
            -4px -4px 8px var(--shadow-light);
    }
    
    .nav-links.active {
        display: flex;
        flex-direction: column;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: var(--bg-primary);
        padding: 1rem;
        box-shadow: 
            var(--shadow-offset) var(--shadow-offset) var(--shadow-blur) var(--shadow-dark),
            calc(-1 * var(--shadow-offset)) calc(-1 * var(--shadow-offset)) var(--shadow-blur) var(--shadow-light);
    }
    
    .mobile-toggle.active span:nth-child(1) {
        transform: rotate(-45deg) translate(-5px, 6px);
    }
    
    .mobile-toggle.active span:nth-child(2) {
        opacity: 0;
    }
    
    .mobile-toggle.active span:nth-child(3) {
        transform: rotate(45deg) translate(-5px, -6px);
    }
    
    .notification-content {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .ecosystem-card:hover .card-icon {
        transform: scale(1.1) rotate(5deg);
        transition: transform 0.3s ease;
    }
    
    .showcase-card:hover .avatar-ring {
        animation-duration: 2s !important;
    }
    
    .interactive-cube {
        transition: transform 0.1s ease;
    }
    
    .tech-sphere:hover .sphere-ring {
        animation-duration: 5s !important;
    }
    
    .particle {
        transition: transform 0.3s ease;
    }
    
    @media (max-width: 768px) {
        .nav-links.active {
            display: flex;
        }
    }
`;

document.head.appendChild(enhancedStyles);

// Events Filter Functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterTabs = document.querySelectorAll('.filter-tab');
    const eventCards = document.querySelectorAll('.showcase-card[data-category]');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            filterTabs.forEach(t => t.classList.remove('active'));
            // Add active class to clicked tab
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            
            // Filter event cards
            eventCards.forEach(card => {
                const category = card.getAttribute('data-category');
                
                if (filter === 'all' || category === filter) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeInUp 0.5s ease forwards';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});

// Newsletter Form Handling
document.addEventListener('DOMContentLoaded', function() {
    const newsletterForm = document.querySelector('.newsletter-form');
    
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = this.querySelector('input[type="email"]').value;
            
            // Show success message
            const successMessage = document.createElement('div');
            successMessage.className = 'newsletter-success';
            successMessage.innerHTML = `
                <i class="fas fa-check-circle"></i>
                <span>Thank you! You've been subscribed to our newsletter.</span>
            `;
            successMessage.style.cssText = `
                background: #38a169;
                color: white;
                padding: 1rem;
                border-radius: 10px;
                margin-top: 1rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                animation: fadeIn 0.5s ease;
            `;
            
            this.appendChild(successMessage);
            this.querySelector('input[type="email"]').value = '';
            
            // Remove success message after 3 seconds
            setTimeout(() => {
                successMessage.remove();
            }, 3000);
        });
    }
});

// Add fadeInUp animation
const fadeInUpStyles = document.createElement('style');
fadeInUpStyles.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    .newsletter-success {
        background: #38a169;
        color: white;
        padding: 1rem;
        border-radius: 10px;
        margin-top: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        animation: fadeIn 0.5s ease;
    }
`;

document.head.appendChild(fadeInUpStyles);

// Retro/Vintage MPA Website JavaScript

document.addEventListener('DOMContentLoaded', function() {
    initRetroEffects();
    initNavigation();
    initEventFilters();
    initFormHandling();
});

// Retro Visual Effects
function initRetroEffects() {
    // Add glitch effect to titles
    const titles = document.querySelectorAll('.pixel-title, .hero-title, .section-title');
    titles.forEach(title => {
        title.addEventListener('mouseenter', function() {
            this.style.textShadow = '0 0 20px currentColor, 2px 2px 0px rgba(255,255,255,0.5)';
        });
        
        title.addEventListener('mouseleave', function() {
            this.style.textShadow = '';
        });
    });

    // Add scanline effect to buttons
    const buttons = document.querySelectorAll('.retro-btn');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.boxShadow = '0 0 30px currentColor, inset 0 0 10px rgba(255,255,255,0.1)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.boxShadow = '';
        });
    });
}

// Navigation Functionality
function initNavigation() {
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                targetSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Event Filter Functionality
function initEventFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const eventCards = document.querySelectorAll('.event-card');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            const filter = this.textContent.toLowerCase();
            
            eventCards.forEach(card => {
                const eventTitle = card.querySelector('.event-title').textContent.toLowerCase();
                const eventLocation = card.querySelector('.event-location').textContent.toLowerCase();
                
                let show = false;
                
                switch(filter) {
                    case 'all events':
                        show = true;
                        break;
                    case 'this month':
                        show = eventTitle.includes('summit') || eventTitle.includes('workshop');
                        break;
                    case 'upcoming':
                        show = !eventTitle.includes('past');
                        break;
                    case 'webinars':
                        show = eventLocation.includes('virtual');
                        break;
                    default:
                        show = true;
                }
                
                if (show) {
                    card.style.display = 'flex';
                    card.style.animation = 'fadeIn 0.5s ease-in';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
}

// Form Handling
function initFormHandling() {
    const newsletterForm = document.querySelector('.newsletter-form');
    const contactForm = document.querySelector('.contact-form');

    // Newsletter subscription
    if (newsletterForm) {
        const subscribeBtn = newsletterForm.querySelector('.retro-btn');
        const emailInput = newsletterForm.querySelector('.retro-input');

        subscribeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const email = emailInput.value.trim();
            
            if (validateEmail(email)) {
                showRetroNotification('SUBSCRIPTION SUCCESSFUL!', 'success');
                emailInput.value = '';
            } else {
                showRetroNotification('INVALID EMAIL FORMAT!', 'error');
            }
        });
    }

    // Contact form
    if (contactForm) {
        const sendBtn = contactForm.querySelector('.retro-btn');
        
        sendBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const name = contactForm.querySelector('input[type="text"]').value.trim();
            const email = contactForm.querySelector('input[type="email"]').value.trim();
            const message = contactForm.querySelector('.retro-textarea').value.trim();
            
            if (name && email && message && validateEmail(email)) {
                showRetroNotification('MESSAGE SENT SUCCESSFULLY!', 'success');
                contactForm.reset();
            } else {
                showRetroNotification('PLEASE FILL ALL FIELDS CORRECTLY!', 'error');
            }
        });
    }
}

// Utility Functions
function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function showRetroNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `retro-notification ${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span class="notification-icon">${type === 'success' ? '✓' : '✗'}</span>
            <span class="notification-text">${message}</span>
        </div>
    `;

    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--retro-black);
        border: 2px solid ${type === 'success' ? 'var(--neon-green)' : 'var(--neon-red)'};
        color: ${type === 'success' ? 'var(--neon-green)' : 'var(--neon-red)'};
        padding: 1rem 1.5rem;
        font-family: 'VT323', monospace;
        font-size: 1.1rem;
        z-index: 10000;
        box-shadow: 0 0 20px ${type === 'success' ? 'rgba(0, 255, 0, 0.5)' : 'rgba(255, 0, 0, 0.5)'};
        animation: slideInRight 0.5s ease-out;
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.5s ease-in';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 500);
    }, 3000);
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(100%); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    @keyframes slideOutRight {
        from { opacity: 1; transform: translateX(0); }
        to { opacity: 0; transform: translateX(100%); }
    }
    
    .retro-notification .notification-content {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .retro-notification .notification-icon {
        font-size: 1.2rem;
        font-weight: bold;
    }
`;
document.head.appendChild(style);

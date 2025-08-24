// BRUTALIST MPA WEBSITE - JAVASCRIPT

// DOM Content Loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('BRUTALIST MPA WEBSITE LOADED');
    
    // Initialize all functionality
    initNavigation();
    initEventFilters();
    initSmoothScrolling();
    initFormHandlers();
    initBrutalistEffects();
});

// NAVIGATION FUNCTIONALITY
function initNavigation() {
    const navLinks = document.querySelectorAll('.nav-link');
    const header = document.querySelector('.brutalist-header');
    
    // Smooth scrolling for navigation links
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                const headerHeight = header.offsetHeight;
                const targetPosition = targetSection.offsetTop - headerHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Header scroll effect
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            header.style.background = '#000000';
            header.style.borderBottomColor = '#FF0000';
        } else {
            header.style.background = '#FF0000';
            header.style.borderBottomColor = '#FFFFFF';
        }
    });
}

// EVENT FILTERS
function initEventFilters() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const eventCards = document.querySelectorAll('.event-card');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            const filterType = this.textContent.trim();
            
            // Filter events based on type
            eventCards.forEach(card => {
                const eventTitle = card.querySelector('.event-title').textContent;
                const eventDate = card.querySelector('.event-date').textContent;
                
                let shouldShow = true;
                
                switch(filterType) {
                    case 'THIS MONTH':
                        shouldShow = eventDate.includes('MAR 2024') || eventDate.includes('APR 2024');
                        break;
                    case 'UPCOMING':
                        shouldShow = !eventDate.includes('FEB 2024');
                        break;
                    case 'WEBINARS':
                        shouldShow = eventTitle.includes('WEBINAR') || eventTitle.includes('ONLINE');
                        break;
                    default: // ALL EVENTS
                        shouldShow = true;
                }
                
                if (shouldShow) {
                    card.style.display = 'block';
                    card.style.animation = 'brutalist-pulse 0.5s ease';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
}

// SMOOTH SCROLLING
function initSmoothScrolling() {
    // Add smooth scrolling behavior
    document.documentElement.style.scrollBehavior = 'smooth';
    
    // Custom scroll indicator
    const scrollIndicator = document.createElement('div');
    scrollIndicator.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 4px;
        background: #FF0000;
        z-index: 1001;
        transition: width 0.3s ease;
    `;
    document.body.appendChild(scrollIndicator);
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const scrollPercent = (scrollTop / docHeight) * 100;
        scrollIndicator.style.width = scrollPercent + '%';
    });
}

// FORM HANDLERS
function initFormHandlers() {
    // Newsletter form
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('.newsletter-input').value;
            
            if (email) {
                showBrutalistMessage('NEWSLETTER SUBSCRIPTION SUCCESSFUL!', 'success');
                this.reset();
            }
        });
    }
    
    // Contact form
    const contactForm = document.querySelector('.contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const name = this.querySelector('input[type="text"]').value;
            const email = this.querySelector('input[type="email"]').value;
            const message = this.querySelector('textarea').value;
            
            if (name && email && message) {
                showBrutalistMessage('MESSAGE SENT SUCCESSFULLY!', 'success');
                this.reset();
            }
        });
    }
    
    // Event registration buttons
    const eventRegisterBtns = document.querySelectorAll('.event-register');
    eventRegisterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const eventTitle = this.closest('.event-card').querySelector('.event-title').textContent;
            showBrutalistMessage(`REGISTRATION FOR: ${eventTitle}`, 'info');
        });
    });
    
    // Insight read buttons
    const insightReadBtns = document.querySelectorAll('.insight-read');
    insightReadBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const insightTitle = this.closest('.insight-card').querySelector('.insight-title').textContent;
            showBrutalistMessage(`READING: ${insightTitle}`, 'info');
        });
    });
    
    // CTA buttons
    const ctaBtns = document.querySelectorAll('.brutalist-cta');
    ctaBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const btnText = this.textContent;
            showBrutalistMessage(`${btnText} - ACTION TRIGGERED!`, 'success');
        });
    });
}

// BRUTALIST EFFECTS
function initBrutalistEffects() {
    // Glitch effect on hover for titles
    const titles = document.querySelectorAll('h1, h2, h3');
    titles.forEach(title => {
        title.addEventListener('mouseenter', function() {
            this.style.textShadow = '8px 8px 0px #FF0000, -8px -8px 0px #FFFFFF';
            this.style.transform = 'skew(-2deg)';
        });
        
        title.addEventListener('mouseleave', function() {
            this.style.textShadow = '';
            this.style.transform = '';
        });
    });
    
    // Random color flashes
    setInterval(() => {
        const randomElement = document.querySelectorAll('*')[Math.floor(Math.random() * document.querySelectorAll('*').length)];
        if (randomElement && randomElement.style) {
            const originalColor = randomElement.style.color;
            randomElement.style.color = '#FF0000';
            setTimeout(() => {
                randomElement.style.color = originalColor;
            }, 100);
        }
    }, 5000);
    
    // Typing effect for hero title
    const heroTitle = document.querySelector('.hero-title');
    if (heroTitle) {
        const originalText = heroTitle.textContent;
        heroTitle.textContent = '';
        let i = 0;
        
        function typeWriter() {
            if (i < originalText.length) {
                heroTitle.textContent += originalText.charAt(i);
                i++;
                setTimeout(typeWriter, 100);
            }
        }
        
        // Start typing effect after 1 second
        setTimeout(typeWriter, 1000);
    }
    
    // Parallax effect for stats
    const statNumbers = document.querySelectorAll('.stat-number');
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        statNumbers.forEach((stat, index) => {
            const speed = 0.5 + (index * 0.1);
            stat.style.transform = `translateY(${scrolled * speed}px)`;
        });
    });
}

// BRUTALIST MESSAGE SYSTEM
function showBrutalistMessage(message, type = 'info') {
    // Remove existing messages
    const existingMessages = document.querySelectorAll('.brutalist-message');
    existingMessages.forEach(msg => msg.remove());
    
    // Create new message
    const messageDiv = document.createElement('div');
    messageDiv.className = 'brutalist-message';
    messageDiv.textContent = message;
    
    // Style based on type
    const colors = {
        success: { bg: '#00FF00', text: '#000000' },
        error: { bg: '#FF0000', text: '#FFFFFF' },
        info: { bg: '#0000FF', text: '#FFFFFF' }
    };
    
    const colorScheme = colors[type] || colors.info;
    
    messageDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${colorScheme.bg};
        color: ${colorScheme.text};
        padding: 20px 40px;
        font-size: 1.2rem;
        font-weight: 700;
        text-transform: uppercase;
        border: 6px solid #000000;
        z-index: 10000;
        animation: brutalist-slide-in 0.5s ease;
        font-family: 'Space Mono', monospace;
        max-width: 400px;
        word-wrap: break-word;
    `;
    
    document.body.appendChild(messageDiv);
    
    // Remove message after 5 seconds
    setTimeout(() => {
        messageDiv.style.animation = 'brutalist-slide-out 0.5s ease';
        setTimeout(() => {
            messageDiv.remove();
        }, 500);
    }, 5000);
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes brutalist-slide-in {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes brutalist-slide-out {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    @keyframes brutalist-pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    @keyframes brutalist-glitch {
        0% { transform: translate(0); }
        20% { transform: translate(-2px, 2px); }
        40% { transform: translate(-2px, -2px); }
        60% { transform: translate(2px, 2px); }
        80% { transform: translate(2px, -2px); }
        100% { transform: translate(0); }
    }
`;
document.head.appendChild(style);

// CONSOLE LOGS FOR BRUTALIST EFFECT
console.log('%cBRUTALIST MPA WEBSITE', 'color: #FF0000; font-size: 2rem; font-weight: bold; text-shadow: 4px 4px 0px #000000;');
console.log('%cMALAYSIA PROPTECH ASSOCIATION', 'color: #FFFFFF; font-size: 1rem; font-weight: bold;');
console.log('%cBUILT WITH BRUTALIST DESIGN PRINCIPLES', 'color: #FF0000; font-size: 0.8rem;');

// ERROR HANDLING
window.addEventListener('error', function(e) {
    console.error('BRUTALIST ERROR:', e.error);
    showBrutalistMessage('SYSTEM ERROR DETECTED!', 'error');
});

// PERFORMANCE MONITORING
window.addEventListener('load', function() {
    const loadTime = performance.now();
    console.log(`%cPAGE LOADED IN ${loadTime.toFixed(2)}ms`, 'color: #00FF00; font-weight: bold;');
    
    if (loadTime > 3000) {
        showBrutalistMessage('SLOW LOAD TIME DETECTED!', 'error');
    }
});

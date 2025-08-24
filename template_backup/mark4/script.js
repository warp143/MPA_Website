// Joyn's Aggressive JavaScript - Making Steve Jobs Proud! 🚀

document.addEventListener('DOMContentLoaded', function() {
    console.log('🔥 Joyn\'s Aggressive Design System Loaded! 🔥');
    
    // Mobile Navigation Toggle with AGGRESSIVE animations
    const navToggle = document.getElementById('nav-toggle');
    const navMenu = document.getElementById('nav-menu');
    
    if (navToggle && navMenu) {
        navToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            const spans = navToggle.querySelectorAll('span');
            spans.forEach((span, index) => {
                span.classList.toggle('active');
                // Add some aggressive rotation
                if (span.classList.contains('active')) {
                    span.style.transform = `rotate(${45 * (index + 1)}deg)`;
                } else {
                    span.style.transform = 'rotate(0deg)';
                }
            });
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!navToggle.contains(e.target) && !navMenu.contains(e.target)) {
                navMenu.classList.remove('active');
                const spans = navToggle.querySelectorAll('span');
                spans.forEach(span => {
                    span.classList.remove('active');
                    span.style.transform = 'rotate(0deg)';
                });
            }
        });
    }
    
    // AGGRESSIVE Scroll Effects
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                entry.target.style.filter = 'blur(0px)';
            }
        });
    }, observerOptions);
    
    // Observe all cards and sections for AGGRESSIVE animations
    const animatedElements = document.querySelectorAll('.stat-item, .pillar, .event-card, .insight-card');
    animatedElements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(50px)';
        el.style.filter = 'blur(10px)';
        el.style.transition = `all 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94) ${index * 0.1}s`;
        observer.observe(el);
    });
    
    // AGGRESSIVE Parallax Effect
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.hero, .stats, .mission, .featured-events, .latest-insights, .cta');
        
        parallaxElements.forEach((element, index) => {
            const speed = 0.5 + (index * 0.1);
            const yPos = -(scrolled * speed);
            element.style.transform = `translateY(${yPos}px)`;
        });
    });
    
    // AGGRESSIVE Button Hover Effects
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.05)';
            this.style.boxShadow = '0 20px 40px rgba(0, 212, 255, 0.4)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '';
        });
    });
    
    // AGGRESSIVE Card Hover Effects
    const cards = document.querySelectorAll('.stat-item, .pillar, .event-card, .insight-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-15px) scale(1.03)';
            this.style.boxShadow = '0 25px 50px rgba(0, 212, 255, 0.3)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '';
        });
    });
    
    // AGGRESSIVE Text Animation on Load
    const heroTitle = document.querySelector('.hero-title');
    if (heroTitle) {
        const text = heroTitle.textContent;
        heroTitle.innerHTML = '';
        
        text.split('').forEach((char, index) => {
            const span = document.createElement('span');
            span.textContent = char;
            span.style.opacity = '0';
            span.style.transform = 'translateY(50px)';
            span.style.transition = `all 0.3s ease ${index * 0.05}s`;
            heroTitle.appendChild(span);
            
            setTimeout(() => {
                span.style.opacity = '1';
                span.style.transform = 'translateY(0)';
            }, 100 + (index * 50));
        });
    }
    
    // AGGRESSIVE Form Interactions
    const formInputs = document.querySelectorAll('input, textarea, select');
    formInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
            this.parentElement.style.boxShadow = '0 10px 30px rgba(0, 212, 255, 0.3)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
            this.parentElement.style.boxShadow = '';
        });
    });
    
    // AGGRESSIVE Navigation Highlight
    const navLinks = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('section[id]');
    
    window.addEventListener('scroll', function() {
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            if (window.pageYOffset >= sectionTop - 200) {
                current = section.getAttribute('id');
            }
        });
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    });
    
    // AGGRESSIVE Smooth Scrolling
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href.startsWith('#')) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
    
    // AGGRESSIVE Loading Animation
    window.addEventListener('load', function() {
        document.body.style.opacity = '0';
        document.body.style.transform = 'scale(0.95)';
        
        setTimeout(() => {
            document.body.style.transition = 'all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
            document.body.style.opacity = '1';
            document.body.style.transform = 'scale(1)';
        }, 100);
    });
    
    // AGGRESSIVE Cursor Effects (if not on mobile)
    if (!('ontouchstart' in window)) {
        const cursor = document.createElement('div');
        cursor.style.cssText = `
            position: fixed;
            width: 20px;
            height: 20px;
            background: var(--neon-blue);
            border-radius: 50%;
            pointer-events: none;
            z-index: 9999;
            mix-blend-mode: difference;
            transition: all 0.1s ease;
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.8);
        `;
        document.body.appendChild(cursor);
        
        document.addEventListener('mousemove', function(e) {
            cursor.style.left = e.clientX - 10 + 'px';
            cursor.style.top = e.clientY - 10 + 'px';
        });
        
        // AGGRESSIVE cursor effects on hover
        const hoverElements = document.querySelectorAll('a, button, .btn, .card, .stat-item, .pillar');
        hoverElements.forEach(element => {
            element.addEventListener('mouseenter', function() {
                cursor.style.transform = 'scale(2)';
                cursor.style.background = 'var(--neon-pink)';
                cursor.style.boxShadow = '0 0 30px rgba(255, 0, 128, 0.8)';
            });
            
            element.addEventListener('mouseleave', function() {
                cursor.style.transform = 'scale(1)';
                cursor.style.background = 'var(--neon-blue)';
                cursor.style.boxShadow = '0 0 20px rgba(0, 212, 255, 0.8)';
            });
        });
    }
    
    // AGGRESSIVE Form Validation with Style
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // AGGRESSIVE success animation
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'SENT! 🚀';
                submitBtn.style.background = 'var(--neon-green)';
                submitBtn.style.boxShadow = '0 0 30px rgba(0, 255, 136, 0.8)';
                
                setTimeout(() => {
                    submitBtn.textContent = originalText;
                    submitBtn.style.background = '';
                    submitBtn.style.boxShadow = '';
                }, 2000);
            }
        });
    });
    
    // AGGRESSIVE Performance Monitoring
    let frameCount = 0;
    let lastTime = performance.now();
    
    function checkPerformance() {
        frameCount++;
        const currentTime = performance.now();
        
        if (currentTime - lastTime >= 1000) {
            const fps = Math.round((frameCount * 1000) / (currentTime - lastTime));
            console.log(`🔥 Joyn's Design Running at ${fps} FPS! 🔥`);
            frameCount = 0;
            lastTime = currentTime;
        }
        
        requestAnimationFrame(checkPerformance);
    }
    
    checkPerformance();
    
    // AGGRESSIVE Easter Egg
    let konamiCode = [];
    const konamiSequence = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65]; // ↑↑↓↓←→←→BA
    
    document.addEventListener('keydown', function(e) {
        konamiCode.push(e.keyCode);
        if (konamiCode.length > konamiSequence.length) {
            konamiCode.shift();
        }
        
        if (konamiCode.join(',') === konamiSequence.join(',')) {
            console.log('🎉 KONAMI CODE ACTIVATED! 🎉');
            document.body.style.animation = 'rainbow 2s infinite';
            
            // Add rainbow animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes rainbow {
                    0% { filter: hue-rotate(0deg); }
                    100% { filter: hue-rotate(360deg); }
                }
            `;
            document.head.appendChild(style);
            
            setTimeout(() => {
                document.body.style.animation = '';
            }, 5000);
        }
    });
    
    console.log('🚀 Joyn\'s Aggressive JavaScript System Ready to Impress Steve Jobs! 🚀');
});

// AGGRESSIVE Utility Functions
function createParticleEffect(x, y, color = 'var(--neon-blue)') {
    for (let i = 0; i < 10; i++) {
        const particle = document.createElement('div');
        particle.style.cssText = `
            position: fixed;
            left: ${x}px;
            top: ${y}px;
            width: 4px;
            height: 4px;
            background: ${color};
            border-radius: 50%;
            pointer-events: none;
            z-index: 9998;
            animation: particle 1s ease-out forwards;
        `;
        
        const angle = (Math.PI * 2 * i) / 10;
        const velocity = 50 + Math.random() * 50;
        const vx = Math.cos(angle) * velocity;
        const vy = Math.sin(angle) * velocity;
        
        particle.style.setProperty('--vx', vx + 'px');
        particle.style.setProperty('--vy', vy + 'px');
        
        document.body.appendChild(particle);
        
        setTimeout(() => {
            particle.remove();
        }, 1000);
    }
}

// Add particle animation
const particleStyle = document.createElement('style');
particleStyle.textContent = `
    @keyframes particle {
        0% {
            transform: translate(0, 0);
            opacity: 1;
        }
        100% {
            transform: translate(var(--vx), var(--vy));
            opacity: 0;
        }
    }
`;
document.head.appendChild(particleStyle);

// AGGRESSIVE Click Effects
document.addEventListener('click', function(e) {
    createParticleEffect(e.clientX, e.clientY, 'var(--neon-pink)');
});

console.log('🎨 Joyn\'s Aggressive Design System - Making the Web Great Again! 🎨');

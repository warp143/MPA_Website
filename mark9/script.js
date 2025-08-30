// Modern Liquid MPA Website JavaScript

console.log('Script.js loaded!');

// Theme Management
let currentTheme = localStorage.getItem('theme') || 'auto';
let isAutoMode = currentTheme === 'auto';

function getAutoTheme() {
    const now = new Date();
    const hour = now.getHours();
    // Auto switch: dark mode from 7 PM to 7 AM, light mode from 7 AM to 7 PM
    return (hour >= 19 || hour < 7) ? 'dark' : 'light';
}

function applyTheme(theme) {
    console.log('applyTheme called with theme:', theme);
    const body = document.body;
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = themeToggle?.querySelector('.theme-icon');
    const autoIndicator = document.getElementById('autoIndicator');
    
    if (theme === 'light') {
        body.classList.add('light-mode');
        if (themeIcon) themeIcon.textContent = '☀️';
        console.log('Applied light theme');
    } else {
        body.classList.remove('light-mode');
        if (themeIcon) themeIcon.textContent = '🌙';
        console.log('Applied dark theme');
    }
    
    // Show/hide auto indicator
    if (autoIndicator) {
        if (isAutoMode) {
            autoIndicator.classList.remove('hidden');
        } else {
            autoIndicator.classList.add('hidden');
        }
    }
    
    // Update logo based on theme
    updateLogoForTheme(theme);
}

function updateLogoForTheme(theme) {
    const logoImg = document.querySelector('.logo-img');
    if (logoImg) {
        if (theme === 'light') {
            logoImg.src = 'assets/mpa-logo.png';
        } else {
            logoImg.src = 'assets/MPA-logo-white-transparent-res.png';
        }
    }
}

function checkAndUpdateTheme() {
    if (isAutoMode) {
        const autoTheme = getAutoTheme();
        applyTheme(autoTheme);
    } else {
        applyTheme(currentTheme);
    }
}

function setTheme(theme) {
    currentTheme = theme;
    isAutoMode = theme === 'auto';
    localStorage.setItem('theme', theme);
    checkAndUpdateTheme();
    updateAutoIndicator(theme);
}

function cycleTheme() {
    console.log('cycleTheme called, current theme:', currentTheme);
    const themes = ['auto', 'light', 'dark'];
    const currentIndex = themes.indexOf(currentTheme);
    const nextIndex = (currentIndex + 1) % themes.length;
    const newTheme = themes[nextIndex];
    console.log('Switching to theme:', newTheme);
    setTheme(newTheme);
}

function updateThemeIcon(theme) {
    const themeIcon = document.querySelector('.theme-icon');
    if (themeIcon) {
        if (theme === 'light') {
            themeIcon.textContent = '☀️';
        } else {
            themeIcon.textContent = '🌙';
        }
    }
}

function updateAutoIndicator(savedTheme) {
    const autoIndicator = document.getElementById('autoIndicator');
    const themeToggle = document.getElementById('themeToggle');
    if (autoIndicator && themeToggle) {
        if (savedTheme === 'auto') {
            autoIndicator.classList.remove('hidden');
            themeToggle.classList.remove('auto-hidden');
        } else {
            autoIndicator.classList.add('hidden');
            themeToggle.classList.add('auto-hidden');
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded!');
    console.log('Current page:', window.location.pathname);
    
    // Debug: Check if all required elements exist
    const requiredElements = [
        'themeToggle',
        'autoIndicator',
        'hamburger',
        'nav-menu'
    ];
    
    requiredElements.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            console.log(`✓ Element found: ${id}`);
        } else {
            console.warn(`⚠ Element missing: ${id}`);
        }
    });
    
    // Initialize theme
    checkAndUpdateTheme();
    
    // Set initial auto-hidden class if needed
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle && currentTheme !== 'auto') {
        themeToggle.classList.add('auto-hidden');
    }
    
    // Theme toggle functionality
    if (themeToggle) {
        console.log('Theme toggle found, adding click listener');
        themeToggle.addEventListener('click', function(e) {
            console.log('Theme toggle clicked!');
            e.preventDefault();
            e.stopPropagation();
            cycleTheme();
        });
        
        // Also add mousedown for testing
        themeToggle.addEventListener('mousedown', function(e) {
            console.log('Theme toggle mousedown!');
        });
    } else {
        console.error('Theme toggle not found!');
    }
    
    // Check for system theme changes
    if (window.matchMedia) {
        const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        mediaQuery.addListener(function(e) {
            if (isAutoMode) {
                checkAndUpdateTheme();
            }
        });
    }
    // Mobile Menu Management
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mobileDropdownMenu = document.getElementById('mobileDropdownMenu');

    function toggleMobileMenu() {
        const isActive = mobileDropdownMenu.classList.contains('active');
        
        if (isActive) {
            closeMobileMenu();
        } else {
            openMobileMenu();
        }
    }

    function openMobileMenu() {
        mobileDropdownMenu.classList.add('active');
        mobileMenuToggle.classList.add('active');
        
        // Add entrance animation to menu items
        const menuItems = mobileDropdownMenu.querySelectorAll('.mobile-dropdown-link');
        menuItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateX(-10px)';
            setTimeout(() => {
                item.style.transition = 'all 0.2s ease';
                item.style.opacity = '1';
                item.style.transform = 'translateX(0)';
            }, 50 + (index * 30));
        });
    }

    function closeMobileMenu() {
        mobileDropdownMenu.classList.remove('active');
        mobileMenuToggle.classList.remove('active');
        
        // Reset menu items
        const menuItems = mobileDropdownMenu.querySelectorAll('.mobile-dropdown-link');
        menuItems.forEach(item => {
            item.style.opacity = '';
            item.style.transform = '';
            item.style.transition = '';
        });
    }

    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', toggleMobileMenu);
    }

    // Language Dropdown Management
    const languageToggle = document.getElementById('languageToggle');
    const languageMenu = document.getElementById('languageMenu');
    const languageDropdown = document.querySelector('.language-dropdown');
    const currentLanguage = document.querySelector('.current-language');

    function toggleLanguageMenu() {
        languageDropdown.classList.toggle('active');
    }

    function selectLanguage(lang) {
        // Update current language display
        currentLanguage.textContent = lang.toUpperCase();
        
        // Update active states
        document.querySelectorAll('.language-option').forEach(option => {
            option.classList.remove('active');
        });
        document.querySelector(`[data-lang="${lang}"]`).classList.add('active');
        
        // Update mobile language options
        document.querySelectorAll('.mobile-language-option').forEach(option => {
            option.classList.remove('active');
        });
        document.querySelector(`.mobile-language-option[data-lang="${lang}"]`).classList.add('active');
        
        // Close dropdown
        languageDropdown.classList.remove('active');
        
        // Store language preference
        localStorage.setItem('selectedLanguage', lang);
        
        // Here you would typically trigger language change
        console.log(`Language changed to: ${lang}`);
    }

    if (languageToggle) {
        languageToggle.addEventListener('click', toggleLanguageMenu);
    }

    // Language option click handlers
    document.querySelectorAll('.language-option').forEach(option => {
        option.addEventListener('click', function() {
            const lang = this.getAttribute('data-lang');
            selectLanguage(lang);
        });
    });

    // Mobile language option click handlers
    document.querySelectorAll('.mobile-language-option').forEach(option => {
        option.addEventListener('click', function() {
            const lang = this.getAttribute('data-lang');
            selectLanguage(lang);
        });
    });

    // Smooth Scrolling for Navigation Links (only for same-page links)
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            
            // Check if it's a same-page link (starts with #)
            if (targetId.startsWith('#')) {
                e.preventDefault();
                const targetSection = document.querySelector(targetId);
                
                if (targetSection) {
                    const offsetTop = targetSection.offsetTop - 80; // Account for fixed navbar
                    
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    if (mobileDropdownMenu && mobileDropdownMenu.classList.contains('active')) {
                        closeMobileMenu();
                    }
                }
            }
            // For external page links (like about.html, events.html), let them work normally
        });
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (mobileDropdownMenu.classList.contains('active') && 
            !mobileDropdownMenu.contains(e.target) && 
            !mobileMenuToggle.contains(e.target)) {
            closeMobileMenu();
        }
        
        if (languageDropdown && !languageDropdown.contains(e.target)) {
            languageDropdown.classList.remove('active');
        }
    });

    // Close menu on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileDropdownMenu.classList.contains('active')) {
            closeMobileMenu();
        }
    });

    // Navbar Background on Scroll
    const navbar = document.querySelector('.navbar');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Search Functionality
    const searchInput = document.querySelector('.search-input input');
    const searchBtn = document.querySelector('.search-btn');
    
    if (searchInput && searchBtn) {
        searchBtn.addEventListener('click', function() {
            const query = searchInput.value.trim();
            if (query) {
                // Implement search functionality here
                console.log('Searching for:', query);
                alert(`Searching for: ${query}`);
            }
        });
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchBtn.click();
            }
        });
    }

    // Newsletter Subscription
    const newsletterForm = document.querySelector('.newsletter-form');
    const newsletterInput = document.querySelector('.newsletter-form input');
    const newsletterBtn = document.querySelector('.newsletter-form .btn-primary');
    
    if (newsletterForm && newsletterInput && newsletterBtn) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = newsletterInput.value.trim();
            if (email && isValidEmail(email)) {
                // Implement newsletter subscription here
                console.log('Newsletter subscription:', email);
                alert('Thank you for subscribing to our newsletter!');
                newsletterInput.value = '';
            } else {
                alert('Please enter a valid email address.');
            }
        });
    }

    // Event Registration Buttons
    const eventButtons = document.querySelectorAll('.event-card .btn-outline');
    
    eventButtons.forEach(button => {
        button.addEventListener('click', function() {
            const eventTitle = this.closest('.event-card').querySelector('.event-title').textContent;
            // Implement event registration here
            console.log('Registering for event:', eventTitle);
            alert(`Registration for "${eventTitle}" will be implemented here.`);
        });
    });

    // Membership Join Buttons
    const membershipButtons = document.querySelectorAll('.membership-card .btn-primary');
    
    membershipButtons.forEach(button => {
        button.addEventListener('click', function() {
            const membershipType = this.closest('.membership-card').querySelector('h3').textContent;
            // Implement membership registration here
            console.log('Joining membership:', membershipType);
            alert(`Membership registration for "${membershipType}" will be implemented here.`);
        });
    });

    // Navigation Join MPA Buttons
    const navJoinButtons = document.querySelectorAll('.nav-actions .btn-primary');

    navJoinButtons.forEach(button => {
        button.addEventListener('click', function() {
            window.location.href = 'membership.html';
        });
    });

    // Click Ripple Effect for all buttons
    const allButtons = document.querySelectorAll('.btn-primary, .btn-secondary, .btn-outline, .signin-btn, .signup-btn, .search-btn');
    console.log('Found buttons for ripple effect:', allButtons.length);

    allButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            console.log('Full-page flower ripple effect triggered on button:', this.className);

            // Create multiple concentric ripples for flower-like effect
            const rippleCount = 3;
            const viewportWidth = window.innerWidth;
            const viewportHeight = window.innerHeight;
            const maxSize = Math.max(viewportWidth, viewportHeight) * 2;

            // Get click position relative to viewport
            const centerX = e.clientX;
            const centerY = e.clientY;

            for (let i = 0; i < rippleCount; i++) {
                setTimeout(() => {
                    createFlowerRipple(centerX, centerY, maxSize, this, i);
                }, i * 380); // More pronounced stagger for enhanced visibility
            }
        });
    });

    function createFlowerRipple(centerX, centerY, maxSize, button, index) {
        const ripple = document.createElement('div');

        // Vary the size slightly for each ripple
        const sizeVariation = 0.8 + (index * 0.2);
        const rippleSize = maxSize * sizeVariation;

        const x = centerX - rippleSize / 2;
        const y = centerY - rippleSize / 2;

        ripple.style.width = ripple.style.height = rippleSize + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('full-page-ripple');

        // Create subtle colors for each ripple (background-appropriate)
        let colors;
        if (document.body.classList.contains('light-mode')) {
            // Light mode - subtle dark ripples
            colors = [
                ['rgba(0, 0, 0, 0.06)', 'rgba(0, 0, 0, 0.04)'],
                ['rgba(0, 0, 0, 0.04)', 'rgba(0, 0, 0, 0.03)'],
                ['rgba(0, 0, 0, 0.03)', 'rgba(0, 0, 0, 0.02)']
            ];
        } else {
            // Dark mode - subtle light ripples
            colors = [
                ['rgba(255, 255, 255, 0.12)', 'rgba(255, 255, 255, 0.08)'],
                ['rgba(255, 255, 255, 0.08)', 'rgba(255, 255, 255, 0.06)'],
                ['rgba(255, 255, 255, 0.06)', 'rgba(255, 255, 255, 0.04)']
            ];
        }

        ripple.style.background = colors[index][0];
        ripple.style.boxShadow = `0 0 0 0 ${colors[index][1]}`;

        // Add to body for full-page effect
        document.body.appendChild(ripple);
        console.log(`Flower ripple ${index + 1} created and appended`);

        setTimeout(() => {
            ripple.remove();
            console.log(`Flower ripple ${index + 1} effect completed`);
        }, 2800 + (index * 200)); // Staggered cleanup for slower animation
    }

    // Intersection Observer for Animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);

    // Observe elements for animation
    const animateElements = document.querySelectorAll('.event-card, .membership-card, .feature');
    animateElements.forEach(el => observer.observe(el));

    // Utility Functions
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Add loading animation
    window.addEventListener('load', function() {
        document.body.classList.add('loaded');
    });

    // Parallax effect for hero section - REMOVED to prevent expanding behavior

    // Add hover effects for cards
    const cards = document.querySelectorAll('.event-card, .membership-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Form validation for contact forms
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Basic form validation
            const inputs = this.querySelectorAll('input[required], textarea[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('error');
                } else {
                    input.classList.remove('error');
                }
            });
            
            if (isValid) {
                // Form is valid, implement submission here
                alert('Form submitted successfully!');
                this.reset();
            } else {
                alert('Please fill in all required fields.');
            }
        });
    });

    // Add smooth reveal animations
    const revealElements = document.querySelectorAll('.section-header, .about-text, .newsletter-content');
    revealElements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        
        setTimeout(() => {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, index * 200);
    });

    // Event Filtering
    const filterTabs = document.querySelectorAll('.filter-tab');
    const eventCards = document.querySelectorAll('.event-card');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Update active tab
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Filter events
            eventCards.forEach(card => {
                const categories = card.getAttribute('data-category').split(' ');
                if (filter === 'all' || categories.includes(filter)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // FAQ Accordion
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const icon = this.querySelector('i');
            
            // Toggle answer visibility
            if (answer.style.maxHeight) {
                answer.style.maxHeight = null;
                icon.style.transform = 'rotate(0deg)';
            } else {
                answer.style.maxHeight = answer.scrollHeight + 'px';
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });

    // Contact Form Validation
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Basic validation
            const firstName = document.getElementById('firstName').value.trim();
            const lastName = document.getElementById('lastName').value.trim();
            const email = document.getElementById('email').value.trim();
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value.trim();
            
            if (!firstName || !lastName || !email || !subject || !message) {
                alert('Please fill in all required fields.');
                return;
            }
            
            if (!isValidEmail(email)) {
                alert('Please enter a valid email address.');
                return;
            }
            
            // Simulate form submission
            alert('Thank you for your message! We will get back to you soon.');
            contactForm.reset();
        });
    }

    // Calendar Navigation and Grid
    const prevMonthBtn = document.getElementById('prevMonth');
    const nextMonthBtn = document.getElementById('nextMonth');
    const currentMonthEl = document.getElementById('currentMonth');
    const calendarGrid = document.getElementById('calendarGrid');
    
    console.log('Calendar elements found:', {
        prevMonthBtn: !!prevMonthBtn,
        nextMonthBtn: !!nextMonthBtn,
        currentMonthEl: !!currentMonthEl,
        calendarGrid: !!calendarGrid
    });
    
            if (prevMonthBtn && nextMonthBtn && currentMonthEl && calendarGrid) {
            // Set to current date in 2025
            const today = new Date(2025, 8, 25); // September 25, 2025
            let currentDate = new Date(2025, 8, 1); // September 1, 2025
            
            // Debug: Log the current date to console
            console.log('Calendar initialized with:', currentDate.toDateString());
            console.log('Today is:', today.toDateString());
        
        // Sample events data
        const events = [
            { date: '2025-08-15', title: 'PropTech Summit 2025', type: 'summit' },
            { date: '2025-08-20', title: 'AI in Real Estate Webinar', type: 'webinar' },
            { date: '2025-08-25', title: 'Startup Pitch Competition', type: 'competition' },
            { date: '2025-09-10', title: 'Blockchain Workshop', type: 'workshop' },
            { date: '2025-09-25', title: 'PropTech Investment Forum', type: 'forum' },
            { date: '2025-10-15', title: 'Smart Cities Conference', type: 'conference' },
            { date: '2025-11-05', title: 'Sustainability in PropTech', type: 'seminar' },
            { date: '2025-12-12', title: 'Digital Transformation Summit', type: 'summit' }
        ];
        
        function renderCalendar() {
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                               'July', 'August', 'September', 'October', 'November', 'December'];
            
            currentMonthEl.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;
            
            // Debug: Log what month/year is being rendered
            console.log('Rendering calendar for:', currentMonthEl.textContent);
            
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            
            // Get first day of month and number of days
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const daysInMonth = lastDay.getDate();
            const startingDay = firstDay.getDay();
            
            // Debug: Log the first day calculation
            console.log(`First day of ${monthNames[month]} ${year}:`, firstDay.toDateString());
            console.log(`Starting day index:`, startingDay, `(0=Sunday, 1=Monday, etc.)`);
            console.log(`Days in month:`, daysInMonth);
            
            // Adjust starting day for Monday-first week
            // JavaScript getDay(): 0=Sunday, 1=Monday, 2=Tuesday, 3=Wednesday, 4=Thursday, 5=Friday, 6=Saturday
            // Our Monday-first order: 0=Monday, 1=Tuesday, 2=Wednesday, 3=Thursday, 4=Friday, 5=Saturday, 6=Sunday
            let adjustedStartingDay;
            if (startingDay === 0) { // Sunday
                adjustedStartingDay = 6; // Sunday becomes last column
            } else {
                adjustedStartingDay = startingDay - 1; // Monday=1 becomes 0, Tuesday=2 becomes 1, etc.
            }
            
            console.log(`Adjusted starting day:`, adjustedStartingDay, `(0=Monday, 1=Tuesday, etc.)`);
            
            // Create calendar grid with weekday headers as the first row
            let calendarHTML = `
                <div class="calendar-days">
                    <div class="calendar-day weekday-header">Mon</div>
                    <div class="calendar-day weekday-header">Tue</div>
                    <div class="calendar-day weekday-header">Wed</div>
                    <div class="calendar-day weekday-header">Thu</div>
                    <div class="calendar-day weekday-header">Fri</div>
                    <div class="calendar-day weekday-header">Sat</div>
                    <div class="calendar-day weekday-header">Sun</div>
            `;
            

            
            // Add empty cells for days before the first day of the month
            for (let i = 0; i < adjustedStartingDay; i++) {
                calendarHTML += '<div class="calendar-day empty"></div>';
            }
            
            // Add days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const dayEvents = events.filter(event => event.date === dateString);
                const isToday = today.toDateString() === new Date(year, month, day).toDateString();
                const isPast = new Date(year, month, day) < new Date().setHours(0, 0, 0, 0);
                
                let dayClass = 'calendar-day';
                if (isToday) dayClass += ' today';
                if (isPast) dayClass += ' past';
                if (dayEvents.length > 0) dayClass += ' has-event';
                
                calendarHTML += `
                    <div class="${dayClass}" data-date="${dateString}">
                        <span class="day-number">${day}</span>
                        ${dayEvents.length > 0 ? `<div class="event-indicator" title="${dayEvents.map(e => e.title).join(', ')}"></div>` : ''}
                    </div>
                `;
            }
            
            calendarHTML += '</div>';
            calendarGrid.innerHTML = calendarHTML;
            
            // Add click handlers for days with events
            const eventDays = calendarGrid.querySelectorAll('.calendar-day.has-event');
            eventDays.forEach(day => {
                day.addEventListener('click', function() {
                    const date = this.dataset.date;
                    const dayEvents = events.filter(event => event.date === date);
                    showEventDetails(dayEvents, date);
                });
            });
        }
        
        function showEventDetails(dayEvents, date) {
            const eventList = dayEvents.map(event => `
                <div class="calendar-event-item">
                    <div class="event-type ${event.type}"></div>
                    <div class="event-info">
                        <h4>${event.title}</h4>
                        <p>${new Date(date).toLocaleDateString('en-US', { 
                            weekday: 'long', 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        })}</p>
                    </div>
                </div>
            `).join('');
            
            const modal = document.createElement('div');
            modal.className = 'calendar-modal';
            modal.innerHTML = `
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Events on ${new Date(date).toLocaleDateString('en-US', { 
                            weekday: 'long', 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        })}</h3>
                        <button class="modal-close">&times;</button>
                    </div>
                    <div class="modal-body">
                        ${eventList}
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
            
            // Close modal functionality
            modal.querySelector('.modal-close').addEventListener('click', () => {
                modal.remove();
            });
            
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.remove();
                }
            });
        }
        
        prevMonthBtn.addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });
        
        nextMonthBtn.addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });
        
        // Force initial render with a small delay to ensure DOM is ready
        setTimeout(() => {
            renderCalendar();
            // Debug: Force show current date info
            console.log('Current date:', new Date().toDateString());
            console.log('Calendar date:', currentDate.toDateString());
            console.log('Today is:', new Date().getDay()); // 0 = Sunday, 1 = Monday, etc.
        }, 100);
    } else {
        console.error('Calendar elements not found! Check if events.html has the correct IDs.');
    }

    // Enhanced image error handling with placeholders
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        // Handle image load error
        img.addEventListener('error', function() {
            console.log('Image failed to load:', this.src);
            
            // Determine the type of image based on context and use appropriate placeholder
            const parent = this.closest('.event-image, .news-image, .featured-image');
            const memberCard = this.closest('.member-card, .committee-member');
            
            if (parent) {
                // Event or news image
                if (this.closest('.event-image')) {
                    this.src = 'assets/images/placeholder-event.svg';
                } else if (this.closest('.news-image, .featured-image')) {
                    this.src = 'assets/images/placeholder-news.svg';
                }
            } else if (memberCard) {
                // Member or committee member image
                this.src = 'assets/images/placeholder-member.svg';
            } else if (this.closest('.mission-image, .president-image')) {
                // Mission or president image
                this.src = 'assets/images/placeholder-mission.svg';
            } else {
                // Generic fallback
                this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjRkZGRkZGIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OTk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkltYWdlIG5vdCBhdmFpbGFibGU8L3RleHQ+PC9zdmc+';
            }
        });
        
        // Add loading state
        img.addEventListener('load', function() {
            this.classList.add('loaded');
        });
    });
    
    // Page load completion indicator
    window.addEventListener('load', function() {
        console.log('Page fully loaded');
        document.body.classList.add('page-loaded');
    });
});

// Add CSS for animations
const style = document.createElement('style');
style.textContent = `
    .navbar.scrolled {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid var(--glass-border);
        box-shadow: var(--shadow-md);
    }
    
    body.light-mode .navbar.scrolled {
        background: var(--glass-bg-light);
        border-bottom: 1px solid var(--glass-border-light);
    }
    
    .nav-menu.active {
        display: flex;
        flex-direction: column;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background-color: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        padding: 1rem;
    }
    
    .hamburger.active span:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }
    
    .hamburger.active span:nth-child(2) {
        opacity: 0;
    }
    
    .hamburger.active span:nth-child(3) {
        transform: rotate(-45deg) translate(7px, -6px);
    }
    
    .animate-in {
        animation: fadeInUp 0.6s ease forwards;
    }
    
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
    
    .loaded {
        opacity: 1;
    }
    
    body {
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .error {
        border-color: #FF385C !important;
        box-shadow: 0 0 0 2px rgba(255, 56, 92, 0.2) !important;
    }
`;
document.head.appendChild(style);

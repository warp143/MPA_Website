// MPA Liquid Design JavaScript
document.addEventListener('DOMContentLoaded', function() {
    console.log('MPA Liquid Design loaded successfully!');
    


    // Theme Toggle Functionality with Auto-Switching
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = themeToggle?.querySelector('.theme-icon');
    const body = document.body;
    
    if (themeToggle && themeIcon) {
        // Auto theme switching function
        function getAutoTheme() {
            const now = new Date();
            const hour = now.getHours();
            // Light mode: 7am to 7pm (7-19)
            // Dark mode: 7pm to 7am (19-7)
            return (hour >= 7 && hour < 19) ? 'light' : 'dark';
        }
        
        // Check for saved theme preference or use auto theme
        const savedTheme = localStorage.getItem('mpa-theme');
        const autoTheme = getAutoTheme();
        
        // If no saved preference, use auto theme
        // If saved preference exists, use it (user can still override)
        const currentTheme = savedTheme || autoTheme;
        
        body.classList.toggle('light-mode', currentTheme === 'light');
        updateThemeIcon(currentTheme);
        updateAutoIndicator(savedTheme);
        
        // Auto-switch theme based on time
        function checkAndUpdateTheme() {
            const newAutoTheme = getAutoTheme();
            const savedTheme = localStorage.getItem('mpa-theme');
            
            // Only auto-switch if user hasn't set a manual preference
            if (!savedTheme) {
                const isCurrentlyLight = body.classList.contains('light-mode');
                const shouldBeLight = newAutoTheme === 'light';
                
                if (isCurrentlyLight !== shouldBeLight) {
                    body.classList.toggle('light-mode', shouldBeLight);
                    updateThemeIcon(newAutoTheme);
                    showNotification(`Auto-switched to ${newAutoTheme} mode`);
                }
            }
        }
        
        // Check theme every minute
        setInterval(checkAndUpdateTheme, 60000);
        
        // Also check when page becomes visible (user returns to tab)
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                checkAndUpdateTheme();
            }
        });
        
        themeToggle.addEventListener('click', function() {
            const isLightMode = body.classList.toggle('light-mode');
            const theme = isLightMode ? 'light' : 'dark';
            
            // Save theme preference (this will override auto-switching)
            localStorage.setItem('mpa-theme', theme);
            
            // Update icon and auto indicator
            updateThemeIcon(theme);
            updateAutoIndicator(theme);
            
            // Add transition effect
            body.style.transition = 'all 0.3s ease';
            
            // Show notification
            showNotification(`Switched to ${theme} mode`);
        });
        
        function updateThemeIcon(theme) {
            themeIcon.textContent = theme === 'light' ? '🌙' : '☀️';
        }
        
        function updateAutoIndicator(savedTheme) {
            const autoIndicator = document.getElementById('autoIndicator');
            if (autoIndicator) {
                // Show auto indicator only when no manual preference is saved
                autoIndicator.classList.toggle('hidden', !!savedTheme);
            }
        }
    }

    // Mobile Menu Toggle
    const mobileMenuToggle = document.querySelector('.mobile-menu-btn');
    const navMenu = document.querySelector('.nav-menu');
    const navContainer = document.querySelector('.nav-container');
    
    if (mobileMenuToggle && navMenu) {
        mobileMenuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            navMenu.classList.toggle('mobile-active');
            mobileMenuToggle.classList.toggle('active');
            navContainer.classList.toggle('menu-open');
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!navMenu.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                navMenu.classList.remove('mobile-active');
                mobileMenuToggle.classList.remove('active');
                navContainer.classList.remove('menu-open');
            }
        });
        
        // Close mobile menu when clicking on a nav link
        const navLinks = navMenu.querySelectorAll('.nav-link, .mobile-action-btn');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                // Add slight delay to show the click effect before closing
                setTimeout(() => {
                    navMenu.classList.remove('mobile-active');
                    mobileMenuToggle.classList.remove('active');
                    navContainer.classList.remove('menu-open');
                }, 150);
            });
        });
    }

    // Smooth scrolling for navigation links
    const navLinks = document.querySelectorAll('.nav-link[href^="#"]');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Active navigation link highlighting
    const sections = document.querySelectorAll('section[id]');
    const navItems = document.querySelectorAll('.nav-link');
    
    window.addEventListener('scroll', function() {
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            if (pageYOffset >= sectionTop - 200) {
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

    // Button interactions with ripple effect
    const buttons = document.querySelectorAll('.btn-primary-liquid, .btn-glass');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Create ripple effect
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
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
            
            // Show notification for demo purposes
            if (this.textContent.includes('Join') || this.textContent.includes('Register')) {
                showNotification('Action completed successfully!');
            }
        });
    });

    // Floating cards parallax effect
    const floatingCards = document.querySelectorAll('.card-glass');
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        floatingCards.forEach((card, index) => {
            const speed = 0.5 + (index * 0.1);
            card.style.transform = `translateY(${scrolled * speed}px)`;
        });
    });

    // Mouse parallax effect for liquid blobs
    const blobs = document.querySelectorAll('.liquid-blob');
    document.addEventListener('mousemove', function(e) {
        const mouseX = e.clientX / window.innerWidth;
        const mouseY = e.clientY / window.innerHeight;
        
        blobs.forEach((blob, index) => {
            const speed = 0.1 + (index * 0.05);
            const x = (mouseX - 0.5) * speed * 100;
            const y = (mouseY - 0.5) * speed * 100;
            blob.style.transform = `translate(${x}px, ${y}px)`;
        });
    });

    // Intersection Observer for scroll-triggered animations
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
    const animateElements = document.querySelectorAll('.feature-card-glass, .card-glass, .hero-content, .section-header');
    animateElements.forEach(el => {
        observer.observe(el);
    });

    // Notification system
    function showNotification(message) {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => notification.remove());
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.innerHTML = `
            <div class="notification-content">
                <span>${message}</span>
                <button class="notification-close">&times;</button>
            </div>
        `;
        
        // Add styles
        const style = document.createElement('style');
        style.textContent = `
            .notification {
                position: fixed;
                top: 100px;
                right: 20px;
                background: var(--glass-bg);
                backdrop-filter: blur(20px);
                border: 1px solid var(--glass-border);
                border-radius: 12px;
                padding: 1rem;
                color: var(--text-primary);
                z-index: 10000;
                transform: translateX(400px);
                transition: transform 0.3s ease;
                max-width: 300px;
            }
            
            .notification.show {
                transform: translateX(0);
            }
            
            .notification-content {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 1rem;
            }
            
            .notification-close {
                background: none;
                border: none;
                color: var(--text-primary);
                font-size: 1.5rem;
                cursor: pointer;
                padding: 0;
                width: 24px;
                height: 24px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                transition: background 0.3s ease;
            }
            
            .notification-close:hover {
                background: var(--glass-border);
            }
            
            .ripple {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.3);
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
            

            
            @media (max-width: 768px) {
                .notification {
                    right: 10px;
                    left: 10px;
                    max-width: none;
                }
            }
        `;
        
        if (!document.querySelector('#notification-styles')) {
            style.id = 'notification-styles';
            document.head.appendChild(style);
        }
        
        document.body.appendChild(notification);
        
        // Show notification
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);
        
        // Auto hide after 3 seconds
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
        
        // Close button functionality
        const closeBtn = notification.querySelector('.notification-close');
        closeBtn.addEventListener('click', function() {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        });
    }

    // Performance optimization: Throttle scroll events
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        }
    }
    
    // Apply throttling to scroll events
    const throttledScroll = throttle(function() {
        // Scroll-based animations
        const scrolled = window.pageYOffset;
        floatingCards.forEach((card, index) => {
            const speed = 0.5 + (index * 0.1);
            card.style.transform = `translateY(${scrolled * speed}px)`;
        });
    }, 16); // ~60fps
    
    window.addEventListener('scroll', throttledScroll);

    // Form handling
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Simple validation
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = 'var(--accent-red)';
                } else {
                    field.style.borderColor = '';
                }
            });
            
            if (!isValid) {
                showNotification('Please fill in all required fields');
                return;
            }
            
            // Simulate form submission
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Submitting...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
                showNotification('Form submitted successfully!');
                this.reset();
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }, 2000);
        });
    });

    // Search and filter functionality
    const searchInputs = document.querySelectorAll('input[type="search"], input[placeholder*="search"]');
    searchInputs.forEach(input => {
        input.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const items = document.querySelectorAll('[data-search]');
            
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // Filter functionality
    const filterSelects = document.querySelectorAll('select[data-filter]');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            const filterValue = this.value;
            const items = document.querySelectorAll(`[data-${this.dataset.filter}]`);
            
            items.forEach(item => {
                if (!filterValue || item.dataset[this.dataset.filter] === filterValue) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // Initialize any page-specific functionality
    initializePageSpecific();
});

// Page-specific functionality
function initializePageSpecific() {
    const currentPage = window.location.pathname.split('/').pop() || 'index.html';
    
    switch(currentPage) {
        case 'index.html':
        case '':
            // Homepage specific functionality
            break;
            
        case 'about.html':
            // About page specific functionality
            break;
            
        case 'events.html':
            // Events page specific functionality
            initializeCalendar();
            initializeEventFilters();
            break;
            
        case 'membership.html':
            // Membership page specific functionality
            break;
            
        case 'proptech-guide.html':
            // PropTech Guide page specific functionality
            break;
            
        case 'insights.html':
            // Insights page specific functionality
            break;
            
        case 'youth-hub.html':
            // Youth Hub page specific functionality
            break;
    }
}

// Calendar functionality for events page
function initializeCalendar() {
    const calendarDays = document.getElementById('calendarDays');
    const monthYearDisplay = document.getElementById('monthYear');
    const prevMonthBtn = document.getElementById('prevMonth');
    const nextMonthBtn = document.getElementById('nextMonth');
    
    if (!calendarDays) {
        console.log('Calendar container not found');
        return;
    }
    
    console.log('Initializing calendar...');
    
    // Mock event data
    const events = {
        '2025-08-25': [
            { title: 'PropTech Summit 2025', time: '9:00 AM - 6:00 PM', location: 'Kuala Lumpur Convention Centre' },
            { title: 'Digital Transformation Webinar', time: '2:00 PM - 4:00 PM', location: 'Virtual' }
        ],
        '2025-08-15': [
            { title: 'Youth Innovation Workshop', time: '10:00 AM - 2:00 PM', location: 'MPA Training Center' }
        ],
        '2025-09-10': [
            { title: 'PropTech Networking Night', time: '6:00 PM - 9:00 PM', location: 'KLCC' }
        ],
        '2025-09-22': [
            { title: 'Smart Building Workshop', time: '2:00 PM - 5:00 PM', location: 'Cyberjaya' }
        ]
    };
    
    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();
    
    const months = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];
    
    function generateCalendar(month, year) {
        console.log(`Generating calendar for ${months[month]} ${year}`);
        
        // Update month/year display
        if (monthYearDisplay) {
            monthYearDisplay.textContent = `${months[month]} ${year}`;
        }
        
        // Clear existing calendar
        calendarDays.innerHTML = '';
        
        // Get first day of month and how many days in month
        const firstDay = new Date(year, month, 1);
        const lastDate = new Date(year, month + 1, 0).getDate();
        const firstDayOfWeek = firstDay.getDay(); // 0 = Sunday
        
        // Get today's date for highlighting
        const today = new Date();
        const isCurrentMonth = today.getFullYear() === year && today.getMonth() === month;
        const todayDate = today.getDate();
        
        // Add empty cells for days before the first day of the month
        for (let i = 0; i < firstDayOfWeek; i++) {
            const emptyDay = document.createElement('div');
            emptyDay.className = 'calendar-day other-month';
            emptyDay.textContent = '';
            calendarDays.appendChild(emptyDay);
        }
        
        // Add all days of the current month
        for (let date = 1; date <= lastDate; date++) {
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day';
            dayElement.textContent = date;
            
            // Highlight today
            if (isCurrentMonth && date === todayDate) {
                dayElement.classList.add('today');
            }
            
            // Check for events (using YYYY-MM-DD format)
            const monthStr = (month + 1).toString().padStart(2, '0');
            const dateStr = date.toString().padStart(2, '0');
            const dateKey = `${year}-${monthStr}-${dateStr}`;
            
            if (events[dateKey]) {
                dayElement.classList.add('has-events');
                dayElement.title = `${events[dateKey].length} event(s) - Click to view details`;
                
                // Add click handler to show events
                dayElement.addEventListener('click', function() {
                    showEventDetails(dateKey, events[dateKey]);
                });
            }
            
            calendarDays.appendChild(dayElement);
        }
        
        // Fill remaining cells to complete the grid (optional)
        const totalCells = calendarDays.children.length;
        const remainingCells = 42 - totalCells; // 6 rows × 7 days
        for (let i = 1; i <= remainingCells && i <= 14; i++) {
            const nextMonthDay = document.createElement('div');
            nextMonthDay.className = 'calendar-day other-month';
            nextMonthDay.textContent = i;
            calendarDays.appendChild(nextMonthDay);
        }
        
        console.log(`Generated ${calendarDays.children.length} calendar days for ${months[month]} ${year}`);
    }
    
    function showEventDetails(date, dayEvents) {
        const eventDate = new Date(date);
        const formattedDate = eventDate.toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        let eventList = dayEvents.map(event => 
            `<div style="margin-bottom: 1rem; padding: 1rem; background: rgba(255,255,255,0.05); border-radius: 8px;">
                <strong>${event.title}</strong><br>
                <span style="color: var(--text-secondary);">📅 ${event.time}</span><br>
                <span style="color: var(--text-secondary);">📍 ${event.location}</span>
            </div>`
        ).join('');
        
        // Simple alert for now - could be replaced with a modal
        const eventDetails = `Events for ${formattedDate}:\n\n${dayEvents.map(event => 
            `${event.title}\n${event.time} - ${event.location}`
        ).join('\n\n')}`;
        
        alert(eventDetails);
    }
    
    // Navigation handlers
    if (prevMonthBtn) {
        prevMonthBtn.addEventListener('click', function() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            generateCalendar(currentMonth, currentYear);
        });
    }
    
    if (nextMonthBtn) {
        nextMonthBtn.addEventListener('click', function() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            generateCalendar(currentMonth, currentYear);
        });
    }
    
    // Initialize calendar
    generateCalendar(currentMonth, currentYear);
}

// Event Filters functionality
function initializeEventFilters() {
    const filterToggle = document.getElementById('filterToggle');
    const filtersContent = document.getElementById('filtersContent');
    const clearFilters = document.getElementById('clearFilters');
    const filterSelects = document.querySelectorAll('.filter-select');
    
    if (!filterToggle || !filtersContent) return;
    
    // Toggle filters visibility
    filterToggle.addEventListener('click', function() {
        const isActive = filtersContent.classList.contains('active');
        
        if (isActive) {
            filtersContent.classList.remove('active');
            filterToggle.classList.remove('active');
        } else {
            filtersContent.classList.add('active');
            filterToggle.classList.add('active');
        }
    });
    
    // Clear all filters
    if (clearFilters) {
        clearFilters.addEventListener('click', function() {
            filterSelects.forEach(select => {
                select.value = '';
            });
            
            // Trigger change event to update filtered results
            filterSelects.forEach(select => {
                select.dispatchEvent(new Event('change'));
            });
            
            showNotification('All filters cleared');
        });
    }
    
    // Add change listeners to filter selects
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            applyFilters();
        });
    });
}

function applyFilters() {
    const filterSelects = document.querySelectorAll('.filter-select');
    const activeFilters = {};
    
    filterSelects.forEach(select => {
        if (select.value) {
            const filterType = select.getAttribute('data-filter');
            activeFilters[filterType] = select.value;
        }
    });
    
    // Get all filterable items (event cards)
    const eventItems = document.querySelectorAll('[data-type], [data-date], [data-location], [data-category]');
    
    eventItems.forEach(item => {
        let shouldShow = true;
        
        // Check each active filter
        Object.keys(activeFilters).forEach(filterType => {
            const itemValue = item.getAttribute(`data-${filterType}`);
            const filterValue = activeFilters[filterType];
            
            if (itemValue && itemValue !== filterValue) {
                shouldShow = false;
            }
        });
        
        // Show or hide the item
        if (shouldShow) {
            item.style.display = 'block';
            item.style.opacity = '1';
        } else {
            item.style.display = 'none';
            item.style.opacity = '0';
        }
    });
    
    // Show notification about active filters
    const filterCount = Object.keys(activeFilters).length;
    if (filterCount > 0) {
        showNotification(`${filterCount} filter${filterCount > 1 ? 's' : ''} applied`);
    }
}



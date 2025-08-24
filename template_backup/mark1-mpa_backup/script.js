/**
 * MPA Website Mockup JavaScript
 * Handles interactivity for all pages
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Mobile Menu Toggle
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const nav = document.querySelector('.nav');
    
    if (mobileMenuToggle && nav) {
        mobileMenuToggle.addEventListener('click', function() {
            nav.classList.toggle('active');
            mobileMenuToggle.classList.toggle('active');
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!nav.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                nav.classList.remove('active');
                mobileMenuToggle.classList.remove('active');
            }
        });
    }
    
    // Smooth scrolling for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
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
    
    // Search and Filter Functionality (PropTech Guide page)
    const startupSearch = document.getElementById('startup-search');
    const categoryFilter = document.getElementById('category-filter');
    const regionFilter = document.getElementById('region-filter');
    const sdgFilter = document.getElementById('sdg-filter');
    const fundingFilter = document.getElementById('funding-filter');
    const techFilter = document.getElementById('tech-filter');
    const startupCards = document.querySelectorAll('.startup-card');
    const startupCount = document.getElementById('startup-count');
    
    function filterStartups() {
        const searchTerm = startupSearch ? startupSearch.value.toLowerCase() : '';
        const category = categoryFilter ? categoryFilter.value : '';
        const region = regionFilter ? regionFilter.value : '';
        const sdg = sdgFilter ? sdgFilter.value : '';
        const funding = fundingFilter ? fundingFilter.value : '';
        const tech = techFilter ? techFilter.value : '';
        
        let visibleCount = 0;
        
        startupCards.forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            const description = card.querySelector('p').textContent.toLowerCase();
            const cardCategory = card.dataset.category;
            const cardRegion = card.dataset.region;
            const cardSdg = card.dataset.sdg;
            const cardFunding = card.dataset.funding;
            const cardTech = card.dataset.tech;
            
            // Check search term
            const matchesSearch = !searchTerm || 
                title.includes(searchTerm) || 
                description.includes(searchTerm);
            
            // Check filters
            const matchesCategory = !category || cardCategory === category;
            const matchesRegion = !region || cardRegion === region;
            const matchesSdg = !sdg || cardSdg === sdg;
            const matchesFunding = !funding || cardFunding === funding;
            const matchesTech = !tech || cardTech === tech;
            
            // Show/hide card
            if (matchesSearch && matchesCategory && matchesRegion && 
                matchesSdg && matchesFunding && matchesTech) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Update count
        if (startupCount) {
            startupCount.textContent = `${visibleCount} startups found`;
        }
    }
    
    // Add event listeners for search and filters
    if (startupSearch) startupSearch.addEventListener('input', filterStartups);
    if (categoryFilter) categoryFilter.addEventListener('change', filterStartups);
    if (regionFilter) regionFilter.addEventListener('change', filterStartups);
    if (sdgFilter) sdgFilter.addEventListener('change', filterStartups);
    if (fundingFilter) fundingFilter.addEventListener('change', filterStartups);
    if (techFilter) techFilter.addEventListener('change', filterStartups);
    
    // View Toggle (Grid/List)
    const viewButtons = document.querySelectorAll('.view-btn');
    const startupsContainer = document.getElementById('startups-container');
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const view = this.dataset.view;
            
            // Update active button
            viewButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Update container class
            if (startupsContainer) {
                startupsContainer.className = `startups-${view}`;
            }
        });
    });
    
    // Startup Form Submission
    const startupForm = document.getElementById('startup-form');
    if (startupForm) {
        startupForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Simple validation
            if (!data['startup-name'] || !data['startup-description'] || 
                !data['startup-category'] || !data['startup-region'] || 
                !data['startup-email']) {
                alert('Please fill in all required fields.');
                return;
            }
            
            // Simulate form submission
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Submitting...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
                alert('Thank you! Your startup has been submitted successfully. We will review and add it to our directory soon.');
                this.reset();
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }, 2000);
        });
    }
    
    // Newsletter Form (if exists on page)
    const newsletterForm = document.getElementById('newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = this.querySelector('input[type="email"]').value;
            const name = this.querySelector('input[name="name"]')?.value || '';
            
            if (!email) {
                alert('Please enter your email address.');
                return;
            }
            
            // Simulate newsletter signup
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Subscribing...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
                alert('Thank you for subscribing to our newsletter!');
                this.reset();
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }, 1500);
        });
    }
    
    // Contact Form (if exists on page)
    const contactForm = document.querySelector('.contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = this.querySelector('input[name="name"]')?.value;
            const email = this.querySelector('input[name="email"]')?.value;
            const message = this.querySelector('textarea[name="message"]')?.value;
            
            if (!name || !email || !message) {
                alert('Please fill in all required fields.');
                return;
            }
            
            // Simulate form submission
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Sending...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
                alert('Thank you for your message! We will get back to you soon.');
                this.reset();
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }, 2000);
        });
    }
    
    // Load More Button
    const loadMoreBtn = document.querySelector('.load-more .btn');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            // Simulate loading more startups
            this.textContent = 'Loading...';
            this.disabled = true;
            
            setTimeout(() => {
                this.textContent = 'Load More Startups';
                this.disabled = false;
                alert('More startups loaded! (This is a demo - in a real implementation, more startup cards would be added here)');
            }, 1500);
        });
    }
    
    // Contact Buttons on Startup Cards
    const contactBtns = document.querySelectorAll('.contact-btn');
    contactBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const startupName = this.closest('.startup-card').querySelector('h3').textContent;
            alert(`Contact form for ${startupName} would open here. In a real implementation, this would open a contact modal or redirect to the startup's contact page.`);
        });
    });
    
    // Animate elements on scroll
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
    const animateElements = document.querySelectorAll('.startup-card, .highlight-card, .team-member, .sdg-card');
    animateElements.forEach(el => {
        observer.observe(el);
    });
    
    // Back to Top Button
    const backToTopBtn = document.createElement('button');
    backToTopBtn.className = 'back-to-top';
    backToTopBtn.innerHTML = '↑';
    backToTopBtn.title = 'Back to top';
    document.body.appendChild(backToTopBtn);
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopBtn.classList.add('visible');
        } else {
            backToTopBtn.classList.remove('visible');
        }
    });
    
    backToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // Form validation helpers
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    
    function validateURL(url) {
        if (!url) return true; // Optional field
        const re = /^https?:\/\/.+/;
        return re.test(url);
    }
    
    // Add CSS for animations
    const style = document.createElement('style');
    style.textContent = `
        .startup-card, .highlight-card, .team-member, .sdg-card {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        
        .startup-card.animate-in, .highlight-card.animate-in, 
        .team-member.animate-in, .sdg-card.animate-in {
            opacity: 1;
            transform: translateY(0);
        }
        
        .back-to-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: #0978bd;
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            font-size: 1.2rem;
        }
        
        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
        }
        
        .back-to-top:hover {
            background: #065a8a;
            transform: translateY(-2px);
        }
        
        .nav.active {
            display: block;
        }
        
        @media (max-width: 768px) {
            .nav {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: white;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                padding: 1rem;
            }
            
            .nav.active {
                display: block;
            }
            
            .nav-list {
                flex-direction: column;
                gap: 1rem;
            }
        }
    `;
    document.head.appendChild(style);
    
    // Event Filters (Events page)
    const eventTypeFilter = document.getElementById('event-type-filter');
    const dateFilter = document.getElementById('date-filter');
    const locationFilter = document.getElementById('location-filter');
    const eventCategoryFilter = document.getElementById('category-filter');
    const eventsContainer = document.getElementById('events-container');

    if (eventTypeFilter && eventsContainer) {
        [eventTypeFilter, dateFilter, locationFilter, eventCategoryFilter].forEach(filter => {
            if (filter) {
                filter.addEventListener('change', filterEvents);
            }
        });
    }

    function filterEvents() {
        const typeValue = eventTypeFilter ? eventTypeFilter.value : '';
        const dateValue = dateFilter ? dateFilter.value : '';
        const locationValue = locationFilter ? locationFilter.value : '';
        const categoryValue = eventCategoryFilter ? eventCategoryFilter.value : '';

        const eventItems = eventsContainer.querySelectorAll('.event-item');
        
        eventItems.forEach(item => {
            let show = true;
            
            if (typeValue && item.dataset.type !== typeValue) show = false;
            if (locationValue && item.dataset.location !== locationValue) show = false;
            if (categoryValue && item.dataset.category !== categoryValue) show = false;
            
            item.style.display = show ? 'flex' : 'none';
        });
    }

    // Event Registration Buttons
    const registerButtons = document.querySelectorAll('.btn-primary');
    registerButtons.forEach(button => {
        if (button.textContent.includes('Register')) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                alert('Registration functionality will be implemented in the full version. Thank you for your interest!');
            });
        }
    });

    // Membership Form (Membership page)
    const membershipForm = document.getElementById('membership-form');
    if (membershipForm) {
        membershipForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Thank you for your membership application! We will review it and get back to you within 3 business days.');
            membershipForm.reset();
        });
    }

    // Partner Form (Events page)
    const partnerForm = document.getElementById('partner-form');
    if (partnerForm) {
        partnerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Thank you for your partnership request! We will review it and contact you soon.');
            partnerForm.reset();
        });
    }

    // Tier Selection (Membership page)
    const tierButtons = document.querySelectorAll('.tier-card .btn-primary');
    tierButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const tierName = this.closest('.tier-card').querySelector('h3').textContent;
            alert(`Thank you for choosing the ${tierName} membership! You will be redirected to the application form.`);
            document.getElementById('membership-form').scrollIntoView({ behavior: 'smooth' });
        });
    });

    // Article Filter Tabs (Insights page)
    const filterTabs = document.querySelectorAll('.filter-tab');
    const articlesContainer = document.getElementById('articles-container');
    
    if (filterTabs.length > 0 && articlesContainer) {
        filterTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs
                filterTabs.forEach(t => t.classList.remove('active'));
                // Add active class to clicked tab
                this.classList.add('active');
                
                const category = this.dataset.category;
                const articles = articlesContainer.querySelectorAll('.article-card');
                
                articles.forEach(article => {
                    if (category === 'all' || article.dataset.category === category) {
                        article.style.display = 'block';
                    } else {
                        article.style.display = 'none';
                    }
                });
            });
        });
    }

    // Download Buttons (Insights page)
    const downloadButtons = document.querySelectorAll('.resource-card .btn-primary');
    downloadButtons.forEach(button => {
        if (button.textContent.includes('Download')) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const resourceName = this.closest('.resource-card').querySelector('h3').textContent;
                alert(`Download started for: ${resourceName}. In the full version, this would trigger an actual download.`);
            });
        }
    });

    // Newsletter Form (Insights page)
    const insightsNewsletterForm = document.getElementById('newsletter-form');
    if (insightsNewsletterForm) {
        insightsNewsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Thank you for subscribing to our newsletter! You will receive updates on the latest PropTech insights.');
            insightsNewsletterForm.reset();
        });
    }

    // Youth Hub Form
    const youthHubForm = document.getElementById('youth-hub-form');
    if (youthHubForm) {
        youthHubForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Thank you for your interest in joining the Youth Hub! We will review your application and contact you within 3 business days.');
            youthHubForm.reset();
        });
    }

    // Program Application Buttons (Youth Hub page)
    const programButtons = document.querySelectorAll('.program-card .btn-primary');
    programButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const programName = this.closest('.program-card').querySelector('h3').textContent;
            alert(`Thank you for your interest in the ${programName}! We will contact you with application details.`);
        });
    });

    // Resource Access Buttons (Youth Hub page)
    const resourceButtons = document.querySelectorAll('.student-resources .btn-primary');
    resourceButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const resourceName = this.closest('.resource-card').querySelector('h3').textContent;
            alert(`Access granted to: ${resourceName}. In the full version, this would provide access to the resource.`);
        });
    });

    // Success Story Buttons
    const storyButtons = document.querySelectorAll('.story-card .btn-outline');
    storyButtons.forEach(button => {
        if (button.textContent.includes('Read Full Story')) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const storyTitle = this.closest('.story-card').querySelector('h3').textContent;
                alert(`Opening full story: ${storyTitle}. In the full version, this would navigate to the complete article.`);
            });
        }
    });

    // Calendar Functionality
    class EventCalendar {
        constructor() {
            this.currentDate = new Date();
            this.selectedDate = new Date();
            this.events = this.getMockEvents();
            this.init();
        }

        init() {
            this.renderCalendar();
            this.bindEvents();
            this.selectDate(new Date(2025, 7, 25)); // Select August 25, 2025
        }

        getMockEvents() {
            return {
                '2025-08-25': [
                    {
                        title: 'PropTech Summit 2025',
                        time: '9:00 AM - 6:00 PM',
                        location: 'Kuala Lumpur Convention Centre',
                        type: 'Summit'
                    },
                    {
                        title: 'Digital Transformation Webinar',
                        time: '2:00 PM - 4:00 PM',
                        location: 'Virtual',
                        type: 'Webinar'
                    }
                ],
                '2025-08-05': [
                    {
                        title: 'PropTech Networking Breakfast',
                        time: '8:00 AM - 10:00 AM',
                        location: 'KLCC Convention Centre',
                        type: 'Networking'
                    }
                ],
                '2025-08-12': [
                    {
                        title: 'Smart Buildings Workshop',
                        time: '2:00 PM - 5:00 PM',
                        location: 'Cyberjaya Innovation Hub',
                        type: 'Workshop'
                    }
                ],
                '2025-08-15': [
                    {
                        title: 'Youth Innovation Workshop',
                        time: '10:00 AM - 2:00 PM',
                        location: 'MPA Training Center',
                        type: 'Workshop'
                    }
                ],
                '2025-08-18': [
                    {
                        title: 'Sustainable PropTech Webinar',
                        time: '11:00 AM - 12:30 PM',
                        location: 'Virtual',
                        type: 'Webinar'
                    }
                ],
                '2025-08-22': [
                    {
                        title: 'Investment Pitch Night',
                        time: '6:00 PM - 9:00 PM',
                        location: 'Menara MPA, KL',
                        type: 'Pitch Night'
                    }
                ],
                '2025-08-28': [
                    {
                        title: 'PropTech Startup Showcase',
                        time: '3:00 PM - 6:00 PM',
                        location: 'Bangsar South Tech Hub',
                        type: 'Showcase'
                    }
                ],
                '2025-08-30': [
                    {
                        title: 'AI in PropTech Panel Discussion',
                        time: '3:00 PM - 5:00 PM',
                        location: 'Virtual',
                        type: 'Panel'
                    }
                ],
                '2025-09-15': [
                    {
                        title: 'Sustainable PropTech Workshop',
                        time: '9:00 AM - 5:00 PM',
                        location: 'MPA Training Center',
                        type: 'Workshop'
                    }
                ],
                '2025-09-20': [
                    {
                        title: 'Startup Pitch Night',
                        time: '7:00 PM - 9:00 PM',
                        location: 'Kuala Lumpur',
                        type: 'Pitch Night'
                    }
                ]
            };
        }

        renderCalendar() {
            const year = this.currentDate.getFullYear();
            const month = this.currentDate.getMonth();
            
            // Update header
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                              'July', 'August', 'September', 'October', 'November', 'December'];
            document.getElementById('currentMonth').textContent = `${monthNames[month]} ${year}`;
            
            // Get first day of month and number of days
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startDate = new Date(firstDay);
            startDate.setDate(startDate.getDate() - firstDay.getDay());
            
            const calendarDays = document.getElementById('calendarDays');
            calendarDays.innerHTML = '';
            
            // Generate calendar days
            for (let i = 0; i < 42; i++) {
                const currentDate = new Date(startDate);
                currentDate.setDate(startDate.getDate() + i);
                
                const dayElement = document.createElement('div');
                dayElement.className = 'calendar-day';
                
                const dayNumber = document.createElement('div');
                dayNumber.className = 'calendar-day-number';
                dayNumber.textContent = currentDate.getDate();
                
                const dayEvents = document.createElement('div');
                dayEvents.className = 'calendar-day-events';
                
                // Check if this day has events
                const dateKey = this.formatDate(currentDate);
                if (this.events[dateKey]) {
                    dayElement.classList.add('has-events');
                    dayEvents.textContent = `${this.events[dateKey].length} event${this.events[dateKey].length > 1 ? 's' : ''}`;
                }
                
                // Add classes for styling
                if (currentDate.getMonth() !== month) {
                    dayElement.classList.add('other-month');
                }
                
                if (this.isToday(currentDate)) {
                    dayElement.classList.add('today');
                }
                
                if (this.isSameDate(currentDate, this.selectedDate)) {
                    dayElement.classList.add('selected');
                }
                
                dayElement.appendChild(dayNumber);
                dayElement.appendChild(dayEvents);
                
                // Add click event
                dayElement.addEventListener('click', () => {
                    this.selectDate(currentDate);
                });
                
                calendarDays.appendChild(dayElement);
            }
        }

        selectDate(date) {
            this.selectedDate = date;
            this.renderCalendar();
            this.showEventsForDate(date);
        }

        showEventsForDate(date) {
            const dateKey = this.formatDate(date);
            const dayEvents = document.getElementById('dayEvents');
            const selectedDateSpan = document.getElementById('selectedDate');
            
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                              'July', 'August', 'September', 'October', 'November', 'December'];
            selectedDateSpan.textContent = `${monthNames[date.getMonth()]} ${date.getDate()}, ${date.getFullYear()}`;
            
            if (this.events[dateKey]) {
                dayEvents.innerHTML = '';
                this.events[dateKey].forEach(event => {
                    const eventElement = document.createElement('div');
                    eventElement.className = 'day-event-item';
                    eventElement.innerHTML = `
                        <h5>${event.title}</h5>
                        <p class="event-time">🕒 ${event.time}</p>
                        <p>📍 ${event.location}</p>
                        <p><strong>Type:</strong> ${event.type}</p>
                    `;
                    dayEvents.appendChild(eventElement);
                });
            } else {
                dayEvents.innerHTML = '<div class="no-events">No events scheduled for this date</div>';
            }
        }

        formatDate(date) {
            return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
        }

        isToday(date) {
            const today = new Date();
            return date.getDate() === today.getDate() &&
                   date.getMonth() === today.getMonth() &&
                   date.getFullYear() === today.getFullYear();
        }

        isSameDate(date1, date2) {
            return date1.getDate() === date2.getDate() &&
                   date1.getMonth() === date2.getMonth() &&
                   date1.getFullYear() === date2.getFullYear();
        }

        bindEvents() {
            document.getElementById('prevMonth').addEventListener('click', () => {
                this.currentDate.setMonth(this.currentDate.getMonth() - 1);
                this.renderCalendar();
            });
            
            document.getElementById('nextMonth').addEventListener('click', () => {
                this.currentDate.setMonth(this.currentDate.getMonth() + 1);
                this.renderCalendar();
            });
        }
    }

    // Initialize calendar if on events page
    if (document.getElementById('calendarDays')) {
        new EventCalendar();
    }
    
    console.log('MPA Website Mockup JavaScript loaded successfully!');
});

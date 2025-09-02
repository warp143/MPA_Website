<?php get_header(); ?>

<!-- Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="hero-content">
            <h1>MPA Events</h1>
            <p>Join our local and internationally promoted events</p>
        </div>
        <div class="hero-image">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/events-hero.jpg" alt="MPA Events">
        </div>
    </div>
</section>


<!-- Top Section: Calendar + Featured Events -->
<section class="events-top-section">
    <div class="container">
        <div class="top-events-layout">
            <!-- Calendar on the left -->
            <div class="calendar-section">
                <div class="section-header">
                    <h2>Event Calendar</h2>
                    <p>Stay updated with our upcoming events and activities</p>
                </div>
                <div class="calendar-widget">
                    <div class="calendar-header">
                        <button class="calendar-nav" id="prevMonth"><i class="fas fa-chevron-left"></i></button>
                        <h3 id="currentMonth"></h3>
                        <button class="calendar-nav" id="nextMonth"><i class="fas fa-chevron-right"></i></button>
                    </div>
                    <div class="calendar-grid" id="calendarGrid">
                        <!-- Calendar will be populated by JavaScript -->
                    </div>
                    <div class="calendar-subscription">
                        <button class="btn-subscribe-calendar" id="subscribeCalendarBtn">
                            <i class="fas fa-calendar-alt"></i>
                            Subscribe to Our Calendar
                        </button>
                        <p class="subscription-info">Get all MPA events automatically in your calendar</p>
                    </div>
                </div>
            </div>
            <!-- Featured Events on the right -->
            <div class="featured-events-section">
                <div class="section-header">
                    <h2>Upcoming Events</h2>
                    <p>Don't miss our most important upcoming events</p>
                    <a href="#all-events" class="view-all-events" id="viewAllEventsLink">View all events</a>
                </div>
                <div class="featured-events-grid" id="upcomingEventsGrid">
                    <!-- Upcoming events will be populated dynamically from All Events section -->
                </div>
            </div>
        </div>
    </div>
</section>

<!-- All Events Section -->
<section class="events-page" id="all-events">
    <div class="container">
        <div class="section-header">
            <h2>All Events</h2>
            <p>Browse through all our events and activities</p>
        </div>
        <div class="filter-tabs">
            <button class="filter-tab active" data-filter="all">All Events</button>
            <button class="filter-tab" data-filter="upcoming">Upcoming</button>
            <button class="filter-tab" data-filter="past">Past Events</button>
            <button class="filter-tab" data-filter="webinar">Webinars</button>
            <button class="filter-tab" data-filter="summit">Summits</button>
        </div>
        <div class="events-grid">

            <div class="event-card upcoming" data-category="upcoming">
                <div class="event-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/startup-pitch-competition.jpeg" alt="Startup Pitch Competition">
                    <div class="event-date-badge">
                        <span class="day">10</span>
                        <span class="month">JAN</span>
                    </div>
                </div>
                <div class="event-content">
                    <div class="event-meta">
                        <span class="event-location"><i class="fas fa-map-marker-alt"></i> Penang Tech Hub</span>
                        <span class="event-time"><i class="fas fa-clock"></i> 10:00 AM - 5:00 PM</span>
                    </div>
                    <h3 class="event-title">Startup Pitch Competition</h3>
                    <p class="event-description">Showcase your PropTech innovation to investors and mentors. Win funding and mentorship opportunities. This competition is open to early-stage PropTech startups from across Malaysia.</p>
                    <div class="event-tags">
                        <span class="tag">Competition</span>
                        <span class="tag">Startup</span>
                        <span class="tag">Funding</span>
                    </div>
                    <div class="event-footer">
                        <span class="event-price">RM 100</span>
                        <div class="event-actions">
                            <button class="btn-outline">Register</button>
                            <button class="btn-calendar" data-event="startup-pitch-competition" data-date="2025-01-10" data-time="10:00-17:00" data-title="Startup Pitch Competition" data-location="Penang Tech Hub">
                                <i class="fas fa-calendar-plus"></i> Add to Calendar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Past Events -->
            <div class="event-card past" data-category="past summit">
                <div class="event-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/placeholder-event.svg" alt="RE:Connect September 2021">
                    <div class="event-date-badge past">
                        <span class="day">15</span>
                        <span class="month">SEP</span>
                    </div>
                </div>
                <div class="event-content">
                    <div class="event-meta">
                        <span class="event-location"><i class="fas fa-map-marker-alt"></i> Kuala Lumpur</span>
                        <span class="event-time"><i class="fas fa-clock"></i> Past Event</span>
                    </div>
                    <h3 class="event-title">RE:Connect September 2021</h3>
                    <p class="event-description">Malaysia PropTech Association Members at RE:Connect September 2021 - A successful networking event that brought together PropTech professionals, investors, and industry leaders from across the region.</p>
                    <div class="event-tags">
                        <span class="tag">Past</span>
                        <span class="tag">Networking</span>
                    </div>
                    <div class="event-footer">
                        <span class="event-price">Completed</span>
                        <a href="#" class="btn-secondary">View Photos</a>
                    </div>
                </div>
            </div>
            
            <div class="event-card past" data-category="past">
                <div class="event-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/placeholder-event.svg" alt="PropTech Asia Summit">
                    <div class="event-date-badge past">
                        <span class="day">20</span>
                        <span class="month">JUN</span>
                    </div>
                </div>
                <div class="event-content">
                    <div class="event-meta">
                        <span class="event-location"><i class="fas fa-map-marker-alt"></i> Singapore</span>
                        <span class="event-time"><i class="fas fa-clock"></i> Past Event</span>
                    </div>
                    <h3 class="event-title">PropTech Asia Summit 2023</h3>
                    <p class="event-description">MPA members participated in the regional PropTech summit, showcasing Malaysian innovations. The event featured panel discussions on AI in real estate, sustainable development, and regional collaboration opportunities.</p>
                    <div class="event-tags">
                        <span class="tag">Past</span>
                        <span class="tag">Regional</span>
                    </div>
                    <div class="event-footer">
                        <span class="event-price">Completed</span>
                        <a href="#" class="btn-secondary">View Report</a>
                    </div>
                </div>
            </div>
            
            <div class="event-card upcoming" data-category="upcoming webinar">
                <div class="event-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/placeholder-event.svg" alt="Sustainability in PropTech">
                    <div class="event-date-badge">
                        <span class="day">25</span>
                        <span class="month">JAN</span>
                    </div>
                </div>
                <div class="event-content">
                    <div class="event-meta">
                        <span class="event-location"><i class="fas fa-globe"></i> Online Webinar</span>
                        <span class="event-time"><i class="fas fa-clock"></i> 3:00 PM - 5:00 PM</span>
                    </div>
                    <h3 class="event-title">Sustainability in PropTech</h3>
                    <p class="event-description">How PropTech is driving sustainability in Malaysia's construction and real estate industry. Learn about green building technologies, ESG compliance, and sustainable development practices.</p>
                    <div class="event-tags">
                        <span class="tag">Webinar</span>
                        <span class="tag">Sustainability</span>
                        <span class="tag">Green Tech</span>
                    </div>
                    <div class="event-footer">
                        <span class="event-price">Free</span>
                        <div class="event-actions">
                            <button class="btn-outline">Register</button>
                            <button class="btn-calendar" data-event="sustainability-proptech" data-date="2025-01-25" data-time="15:00-17:00" data-title="Sustainability in PropTech" data-location="Online Webinar">
                                <i class="fas fa-calendar-plus"></i> Add to Calendar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="event-card upcoming" data-category="upcoming">
                <div class="event-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/blockchain-real-estate.jpeg" alt="Blockchain in Real Estate">
                    <div class="event-date-badge">
                        <span class="day">15</span>
                        <span class="month">FEB</span>
                    </div>
                </div>
                <div class="event-content">
                    <div class="event-meta">
                        <span class="event-location"><i class="fas fa-map-marker-alt"></i> Cyberjaya</span>
                        <span class="event-time"><i class="fas fa-clock"></i> 9:00 AM - 4:00 PM</span>
                    </div>
                    <h3 class="event-title">Blockchain in Real Estate Workshop</h3>
                    <p class="event-description">Hands-on workshop exploring blockchain applications in real estate, including property tokenization, smart contracts, and transparent transaction systems.</p>
                    <div class="event-tags">
                        <span class="tag">Workshop</span>
                        <span class="tag">Blockchain</span>
                        <span class="tag">Technology</span>
                    </div>
                    <div class="event-footer">
                        <span class="event-price">RM 200</span>
                        <div class="event-actions">
                            <button class="btn-outline">Register</button>
                            <button class="btn-calendar" data-event="blockchain-real-estate" data-date="2025-02-15" data-time="09:00-16:00" data-title="Blockchain in Real Estate Workshop" data-location="Cyberjaya">
                                <i class="fas fa-calendar-plus"></i> Add to Calendar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="event-card upcoming" data-category="upcoming">
                <div class="event-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/proptech-investment-forum.jpeg" alt="PropTech Investment Forum">
                    <div class="event-date-badge">
                        <span class="day">28</span>
                        <span class="month">FEB</span>
                    </div>
                </div>
                <div class="event-content">
                    <div class="event-meta">
                        <span class="event-location"><i class="fas fa-map-marker-alt"></i> Kuala Lumpur</span>
                        <span class="event-time"><i class="fas fa-clock"></i> 2:00 PM - 6:00 PM</span>
                    </div>
                    <h3 class="event-title">PropTech Investment Forum</h3>
                    <p class="event-description">Connect with investors, venture capitalists, and funding institutions. Learn about investment trends in PropTech and pitch your innovative solutions.</p>
                    <div class="event-tags">
                        <span class="tag">Forum</span>
                        <span class="tag">Investment</span>
                        <span class="tag">Networking</span>
                    </div>
                    <div class="event-footer">
                        <span class="event-price">RM 150</span>
                        <div class="event-actions">
                            <button class="btn-outline">Register</button>
                            <button class="btn-calendar" data-event="proptech-investment-forum" data-date="2025-02-28" data-time="14:00-18:00" data-title="PropTech Investment Forum" data-location="Kuala Lumpur">
                                <i class="fas fa-calendar-plus"></i> Add to Calendar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Populate upcoming events from All Events section
    document.addEventListener('DOMContentLoaded', function() {
        const upcomingEventsGrid = document.getElementById('upcomingEventsGrid');
        if (upcomingEventsGrid) {
            populateUpcomingEvents();
        }
        
        // Initialize calendar functionality
        initCalendarButtons();
        initCalendarSubscription();
        initViewAllEventsLink();
        
        function populateUpcomingEvents() {
            // Get all upcoming event cards from the All Events section
            const allUpcomingEvents = document.querySelectorAll('.event-card.upcoming');
            
            // Take the first 2 upcoming events
            const firstTwoUpcoming = Array.from(allUpcomingEvents).slice(0, 2);
            
            firstTwoUpcoming.forEach(eventCard => {
                // Clone the event card
                const clonedEvent = eventCard.cloneNode(true);
                
                // Add the "featured" class for styling
                clonedEvent.classList.add('featured');
                
                // Add "UPCOMING" badge if it doesn't exist
                const eventImage = clonedEvent.querySelector('.event-image');
                if (eventImage && !eventImage.querySelector('.event-badge')) {
                    const upcomingBadge = document.createElement('div');
                    upcomingBadge.className = 'event-badge upcoming';
                    upcomingBadge.textContent = 'UPCOMING';
                    eventImage.appendChild(upcomingBadge);
                }
                
                // Add to upcoming events grid
                upcomingEventsGrid.appendChild(clonedEvent);
            });
            
            // Re-initialize calendar buttons for cloned events
            initCalendarButtons();
        }
        
        function initCalendarButtons() {
            const calendarButtons = document.querySelectorAll('.btn-calendar');
            
            calendarButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const eventId = this.getAttribute('data-event');
                    const eventDate = this.getAttribute('data-date');
                    const eventTime = this.getAttribute('data-time');
                    const eventTitle = this.getAttribute('data-title');
                    const eventLocation = this.getAttribute('data-location');
                    
                    // Parse time range
                    const [startTime, endTime] = eventTime.split('-');
                    const [startHour, startMinute] = startTime.split(':').map(Number);
                    const [endHour, endMinute] = endTime.split(':').map(Number);
                    
                    // Create event start and end dates
                    const eventStart = new Date(eventDate + 'T' + startTime + ':00');
                    const eventEnd = new Date(eventDate + 'T' + endTime + ':00');
                    
                    // Generate calendar data
                    const calendarData = generateCalendarData(eventTitle, eventStart, eventEnd, eventLocation);
                    
                    // Create and download .ics file
                    downloadCalendarFile(calendarData, eventTitle);
                });
            });
        }
        
        function generateCalendarData(title, start, end, location) {
            const formatDate = (date) => {
                return date.toISOString().replace(/[-:]/g, '').split('.')[0] + 'Z';
            };
            
            const description = `Join us for ${title} at ${location}. Organized by Malaysia PropTech Association.`;
            
            return [
                'BEGIN:VCALENDAR',
                'VERSION:2.0',
                'PRODID:-//Malaysia PropTech Association//Event Calendar//EN',
                'CALSCALE:GREGORIAN',
                'METHOD:PUBLISH',
                'BEGIN:VEVENT',
                `UID:${Date.now()}@proptech.org.my`,
                `DTSTAMP:${formatDate(new Date())}`,
                `DTSTART:${formatDate(start)}`,
                `DTEND:${formatDate(end)}`,
                `SUMMARY:${title}`,
                `DESCRIPTION:${description}`,
                `LOCATION:${location}`,
                'ORGANIZER;CN=Malaysia PropTech Association:mailto:info@proptech.org.my',
                'STATUS:CONFIRMED',
                'SEQUENCE:0',
                'END:VEVENT',
                'END:VCALENDAR'
            ].join('\r\n');
        }
        
        function downloadCalendarFile(calendarData, eventTitle) {
            const blob = new Blob([calendarData], { type: 'text/calendar;charset=utf-8' });
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = `${eventTitle.replace(/[^a-zA-Z0-9]/g, '_')}.ics`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            window.URL.revokeObjectURL(url);
            
            // Show success message
            showNotification('Event added to calendar!', 'success');
        }
        
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? 'var(--accent-green)' : 'var(--accent-blue)'};
                color: white;
                padding: var(--spacing-md);
                border-radius: var(--border-radius-md);
                box-shadow: var(--shadow-md);
                z-index: 1000;
                font-weight: 500;
                animation: slideIn 0.3s ease;
            `;
            
            document.body.appendChild(notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }
        
        function initCalendarSubscription() {
            const subscribeBtn = document.getElementById('subscribeCalendarBtn');
            if (subscribeBtn) {
                subscribeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Create a comprehensive calendar feed with all MPA events
                    const allEvents = [
                        {
                            title: 'Startup Pitch Competition',
                            date: '2025-01-10',
                            time: '10:00-17:00',
                            location: 'Penang Tech Hub',
                            description: 'Showcase your PropTech innovation to investors and mentors. Win funding and mentorship opportunities.'
                        },
                        {
                            title: 'Sustainability in PropTech',
                            date: '2025-01-25',
                            time: '15:00-17:00',
                            location: 'Online Webinar',
                            description: 'How PropTech is driving sustainability in Malaysia\'s construction and real estate industry.'
                        },
                        {
                            title: 'Blockchain in Real Estate Workshop',
                            date: '2025-02-15',
                            time: '09:00-16:00',
                            location: 'Cyberjaya',
                            description: 'Hands-on workshop exploring blockchain applications in real estate.'
                        },
                        {
                            title: 'PropTech Investment Forum',
                            date: '2025-02-28',
                            time: '14:00-18:00',
                            location: 'Kuala Lumpur',
                            description: 'Connect with investors, venture capitalists, and funding institutions.'
                        }
                    ];
                    
                    // Generate comprehensive calendar data
                    const calendarData = generateSubscriptionCalendarData(allEvents);
                    
                    // Create and download .ics file
                    downloadCalendarFile(calendarData, 'MPA_Events_Calendar');
                    
                    // Show success message
                    showNotification('MPA Events Calendar downloaded! Import this file to subscribe to all our events.', 'success');
                });
            }
        }
        
        function generateSubscriptionCalendarData(events) {
            const formatDate = (date) => {
                return date.toISOString().replace(/[-:]/g, '').split('.')[0] + 'Z';
            };
            
            let calendarContent = [
                'BEGIN:VCALENDAR',
                'VERSION:2.0',
                'PRODID:-//Malaysia PropTech Association//Event Calendar//EN',
                'CALSCALE:GREGORIAN',
                'METHOD:PUBLISH',
                'X-WR-CALNAME:MPA Events Calendar',
                'X-WR-CALDESC:Malaysia PropTech Association Events and Activities',
                'X-WR-TIMEZONE:Asia/Kuala_Lumpur'
            ];
            
            events.forEach((event, index) => {
                const [startTime, endTime] = event.time.split('-');
                const eventStart = new Date(event.date + 'T' + startTime + ':00');
                const eventEnd = new Date(event.date + 'T' + endTime + ':00');
                
                calendarContent = calendarContent.concat([
                    'BEGIN:VEVENT',
                    `UID:mpa-event-${index + 1}@proptech.org.my`,
                    `DTSTAMP:${formatDate(new Date())}`,
                    `DTSTART:${formatDate(eventStart)}`,
                    `DTEND:${formatDate(eventEnd)}`,
                    `SUMMARY:${event.title}`,
                    `DESCRIPTION:${event.description} - Organized by Malaysia PropTech Association`,
                    `LOCATION:${event.location}`,
                    'ORGANIZER;CN=Malaysia PropTech Association:mailto:info@proptech.org.my',
                    'STATUS:CONFIRMED',
                    'SEQUENCE:0',
                    'END:VEVENT'
                ]);
            });
            
            calendarContent.push('END:VCALENDAR');
            return calendarContent.join('\r\n');
        }
        
        function initViewAllEventsLink() {
            const viewAllLink = document.getElementById('viewAllEventsLink');
            if (viewAllLink) {
                viewAllLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const allEventsSection = document.getElementById('all-events');
                    if (allEventsSection) {
                        allEventsSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            }
        }
    });
</script>

<?php get_footer(); ?>

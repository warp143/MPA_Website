<?php get_header(); ?>

<main id="main" class="site-main">
    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <div class="hero-left">
                <div class="hero-text-group">
                    <h1 class="hero-title">Malaysia Proptech Association</h1>
                    <p class="hero-subtitle">Leading The Digital Transformation of the Property Industry in Malaysia</p>
                </div>
                <div class="hero-search">
                    <div class="search-container">
                        <div class="search-input">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchInput" placeholder="Find events, members, or resources...">
                        </div>
                        <button class="search-btn" id="searchBtn">Search</button>
                    </div>
                </div>
                <div class="hero-stats">
                    <div class="stat">
                        <span class="stat-number">150+</span>
                        <span class="stat-label">Members</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">50+</span>
                        <span class="stat-label">Events</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">90+</span>
                        <span class="stat-label">Startups</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">15+</span>
                        <span class="stat-label">Partners</span>
                    </div>
                </div>
            </div>
        <div class="hero-image">
            <div class="image-container">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/mpa-intro.jpg" alt="Malaysia Proptech Association - Kuala Lumpur Skyline">
            </div>
        </div>
    </section>

    <!-- About MPA Section -->
    <section id="about" class="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>For The Future of A Sustainable Property Market</h2>
                    <p class="tie-paragraph">Malaysia Proptech Association Leads The Digital Transformation of the Built Environment in Malaysia and beyond, through innovation, collaboration, and sustainable growth. Building a strong community with integrity, inclusivity, and equality.</p>
                    <p>The Malaysia PropTech Association (MPA) is the driving force behind Malaysia's digital transformation in the built environment. We unite startups, scale-ups, corporates, investors, and government stakeholders to shape a smarter, more inclusive property ecosystem.</p>
                    
                    <p>Our mission is to accelerate innovation, foster collaboration, and empower a new generation of tech-driven leaders in the built environment!</p>
                    
                    <p>We believe that transformation must be rooted in integrity, inclusivity, and shared progress.</p>
                    
                    <p class="highlight-text">Together, we're building the built environment of the future!</p>
                </div>
                
                <div class="about-right">
                    <p class="strategic-anchors">MPA's work is guided by five Strategic Anchors, the pillars that define our purpose and drive our outcomes!</p>
                    
                    <div class="about-features">
                        <div class="feature">
                            <i class="fas fa-users"></i>
                            <div class="feature-content">
                                <h4>Community</h4>
                                <p>Connect with 150+ PropTech professionals</p>
                            </div>
                        </div>
                        <div class="feature">
                            <i class="fas fa-lightbulb"></i>
                            <div class="feature-content">
                                <h4>Innovation</h4>
                                <p>Drive cutting-edge PropTech solutions</p>
                            </div>
                        </div>
                        <div class="feature">
                            <i class="fas fa-globe"></i>
                            <div class="feature-content">
                                <h4>Global Network</h4>
                                <p>Access international PropTech ecosystem</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Events Section -->
    <section class="featured-events">
        <div class="container">
            <div class="section-header">
                <h2>Upcoming Events</h2>
                <a href="<?php echo esc_url(home_url('/events/')); ?>" class="view-all">View all events</a>
            </div>
            <div class="events-grid" id="homepageEventsGrid">
                <!-- Events will be populated dynamically from events page data -->
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section id="partners" class="partners">
        <div class="container">
            <div class="section-header">
                <h2>Our Partners</h2>
                <p>Strategic collaborations driving PropTech innovation in Malaysia</p>
            </div>
            <div class="partners-grid" id="homepagePartnersGrid">
                <!-- Partners will be populated dynamically from partners page data -->
            </div>
            <div class="partners-cta">
                <a href="<?php echo esc_url(home_url('/partners/')); ?>" class="btn-outline">View All Partners</a>
            </div>
        </div>
    </section>

    <!-- Membership Section -->
    <section id="membership" class="membership">
        <div class="container">
            <div class="section-header">
                <h2>Join Our Community</h2>
                <p>Choose the membership that fits your needs</p>
            </div>
            <div class="membership-cards">
                <div class="membership-card">
                    <div class="card-header">
                        <h3>Startup</h3>
                        <div class="price">RM 500<span>/year</span></div>
                    </div>
                    <ul class="benefits">
                        <li><i class="fas fa-check"></i> Access to all events</li>
                        <li><i class="fas fa-check"></i> Member directory</li>
                        <li><i class="fas fa-check"></i> Newsletter subscription</li>
                        <li><i class="fas fa-check"></i> Resource library</li>
                    </ul>
                    <a href="<?php echo esc_url(home_url('/join/')); ?>" class="btn-primary">Join Now</a>
                </div>
                <div class="membership-card featured">
                    <div class="card-header">
                        <h3>Professional</h3>
                        <div class="price">RM 1,000<span>/year</span></div>
                    </div>
                    <ul class="benefits">
                        <li><i class="fas fa-check"></i> All Startup benefits</li>
                        <li><i class="fas fa-check"></i> Priority event registration</li>
                        <li><i class="fas fa-check"></i> Networking opportunities</li>
                        <li><i class="fas fa-check"></i> Mentorship program</li>
                    </ul>
                    <a href="<?php echo esc_url(home_url('/join/')); ?>" class="btn-primary">Join Now</a>
                </div>
                <div class="membership-card">
                    <div class="card-header">
                        <h3>Enterprise</h3>
                        <div class="price">RM 5,000<span>/year</span></div>
                    </div>
                    <ul class="benefits">
                        <li><i class="fas fa-check"></i> All Professional benefits</li>
                        <li><i class="fas fa-check"></i> Speaking opportunities</li>
                        <li><i class="fas fa-check"></i> Custom workshops</li>
                        <li><i class="fas fa-check"></i> Board advisory</li>
                    </ul>
                    <a href="<?php echo esc_url(home_url('/join/')); ?>" class="btn-primary">Join Now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter">
        <div class="container">
            <div class="newsletter-content">
                <h2>Stay Updated</h2>
                <p>Get the latest PropTech news, events, and insights delivered to your inbox</p>
                <div class="newsletter-form">
                    <input type="email" placeholder="Enter your email address">
                    <button class="btn-primary">Subscribe</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Cookie Consent Banner -->
    <div class="cookie-banner" id="cookieBanner">
        <div class="container">
            <div class="cookie-content">
                <div class="cookie-text">
                    <h4>Cookie & Privacy Notice</h4>
                    <p>We use cookies and similar technologies to enhance your browsing experience, analyze site traffic, and personalize content. By continuing to use our website, you consent to our use of cookies in accordance with our Privacy Policy.</p>
                </div>
                <div class="cookie-actions">
                    <button class="btn-primary" id="acceptCookies">Accept All</button>
                    <button class="btn-outline" id="rejectCookies">Reject</button>
                    <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>" class="btn-outline">Learn More</a>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Populate homepage events from events page data
    document.addEventListener('DOMContentLoaded', function() {
        try {
            populateHomepageEvents();
            populateHomepagePartners();
            initSearchFunctionality();
            initCookieBanner();
        } catch (error) {
            console.error('Error initializing page:', error);
        }
        
        function initCookieBanner() {
            const cookieBanner = document.getElementById('cookieBanner');
            const acceptCookies = document.getElementById('acceptCookies');
            const rejectCookies = document.getElementById('rejectCookies');

            // Check if user has already made a choice
            const cookieChoice = localStorage.getItem('cookieChoice');
            if (cookieChoice) {
                cookieBanner.style.display = 'none';
            }

            acceptCookies.addEventListener('click', function() {
                localStorage.setItem('cookieChoice', 'accepted');
                cookieBanner.style.display = 'none';
                showNotification('Cookie preferences saved. Thank you!', 'success');
            });

            rejectCookies.addEventListener('click', function() {
                localStorage.setItem('cookieChoice', 'rejected');
                cookieBanner.style.display = 'none';
                showNotification('Cookie preferences saved. Some features may be limited.', 'info');
            });
        }
        
        function populateHomepageEvents() {
            // Define the same events data as used in events.html
            const upcomingEvents = [
                {
                    title: 'Startup Pitch Competition',
                    date: 'Jan 10, 2025',
                    location: 'Penang Tech Hub',
                    description: 'Showcase your PropTech innovation to investors and mentors. Win funding and mentorship opportunities.',
                    price: 'RM 100',
                    image: '<?php echo get_template_directory_uri(); ?>/assets/images/event-startup.svg',
                    badge: 'UPCOMING'
                },
                {
                    title: 'Sustainability in PropTech',
                    date: 'Jan 25, 2025',
                    location: 'Online Webinar',
                    description: 'How PropTech is driving sustainability in Malaysia\'s construction and real estate industry.',
                    price: 'Free',
                    image: '<?php echo get_template_directory_uri(); ?>/assets/un-sdg-goals.jpg',
                    badge: 'UPCOMING'
                },
                {
                    title: 'Blockchain in Real Estate Workshop',
                    date: 'Feb 15, 2025',
                    location: 'Cyberjaya',
                    description: 'Hands-on workshop exploring blockchain applications in real estate.',
                    price: 'RM 200',
                    image: '<?php echo get_template_directory_uri(); ?>/assets/images/event-ai.svg',
                    badge: 'UPCOMING'
                }
            ];
            
            const eventsGrid = document.getElementById('homepageEventsGrid');
            if (eventsGrid) {
                upcomingEvents.forEach(event => {
                    const eventCard = createEventCard(event);
                    eventsGrid.appendChild(eventCard);
                });
            }
        }
        
        function createEventCard(event) {
            const card = document.createElement('div');
            card.className = 'event-card';
            
            card.innerHTML = `
                <div class="event-image">
                    <img src="${event.image}" alt="${event.title}">
                    <div class="event-badge upcoming">${event.badge}</div>
                </div>
                <div class="event-content">
                    <div class="event-meta">
                        <span class="event-date">${event.date}</span>
                        <span class="event-location">${event.location}</span>
                    </div>
                    <h3 class="event-title">${event.title}</h3>
                    <p class="event-description">${event.description}</p>
                    <div class="event-footer">
                        <span class="event-price">${event.price}</span>
                        <button class="btn-outline">Register</button>
                    </div>
                </div>
            `;
            
            return card;
        }
        
        function initSearchFunctionality() {
            const searchInput = document.getElementById('searchInput');
            const searchBtn = document.getElementById('searchBtn');
            
            console.log('Initializing search functionality', { searchInput, searchBtn });
            
            if (searchInput && searchBtn) {
                // Handle search button click
                searchBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Search button clicked');
                    performSearch();
                });
                
                // Handle Enter key press
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        console.log('Enter key pressed in search');
                        performSearch();
                    }
                });
                
                // Prevent form submission if wrapped in form
                const form = searchInput.closest('form');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        performSearch();
                    });
                }
            } else {
                console.log('Search elements not found');
            }
            
            function performSearch() {
                const query = searchInput.value.trim().toLowerCase();
                
                if (query === '') {
                    showSearchNotification('Please enter a search term', 'warning');
                    return;
                }
                
                console.log('Performing search for:', query);
                
                // Define searchable content
                const searchableContent = {
                    events: [
                        'startup pitch competition',
                        'sustainability in proptech',
                        'blockchain in real estate',
                        'proptech investment forum',
                        'summit',
                        'webinar',
                        'workshop'
                    ],
                    members: [
                        'pitchin',
                        'omeshwer',
                        'proptech',
                        'startup',
                        'technology',
                        'real estate'
                    ],
                    resources: [
                        'news',
                        'articles',
                        'reports',
                        'guides',
                        'research',
                        'insights'
                    ]
                };
                
                // Search through content
                let results = [];
                
                // Search events
                if (searchableContent.events.some(event => event.includes(query))) {
                    results.push('events');
                }
                
                // Search members
                if (searchableContent.members.some(member => member.includes(query))) {
                    results.push('members');
                }
                
                // Search resources
                if (searchableContent.resources.some(resource => resource.includes(query))) {
                    results.push('resources');
                }
                
                // Handle search results
                if (results.length > 0) {
                    showSearchNotification(`Found ${results.length} result(s) for "${query}". Click to navigate.`, 'success');
                    
                    // Don't auto-redirect, let user click to navigate
                    console.log('Search results:', results);
                } else {
                    showSearchNotification(`No results found for "${query}"`, 'error');
                }
            }
            
            function showSearchNotification(message, type = 'info') {
                // Create notification element
                const notification = document.createElement('div');
                notification.className = `search-notification ${type}`;
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
        }
        
        function populateHomepagePartners() {
            // Define featured partners data (first 4 from partners page)
            const featuredPartners = [
                {
                    name: 'Light House Club',
                    category: 'International Organization',
                    description: 'Lighthouse Club International is a non-political organisation supporting the construction industry worldwide through the promotion of good fellowship among its members and the provision of charitable assistance to distressed persons within the industry.',
                    logo: '<?php echo get_template_directory_uri(); ?>/assets/light-house-club-logo.png',
                    tags: ['Construction', 'International']
                },
                {
                    name: 'Indonesia PropTech Association',
                    category: 'International Organization',
                    description: 'Building a Collaborative Proptech Community & Ecosystem. The Indonesia PropTech Association (IPTA) is an independent, official membership and non-profit organization established in Indonesia.',
                    logo: '<?php echo get_template_directory_uri(); ?>/assets/indonesia-proptech-association-logo.png',
                    tags: ['Regional', 'Ecosystem']
                },
                {
                    name: 'PropTech JAPAN',
                    category: 'International Organization',
                    description: 'PropTech JAPAN is Japan\'s largest real estate/construction startup community, which started its activities in 2017.',
                    logo: '<?php echo get_template_directory_uri(); ?>/assets/proptech-japan-logo.png',
                    tags: ['Startups', 'Real Estate']
                },
                {
                    name: 'Asia PropTech',
                    category: 'International Organization',
                    description: 'The PropTech for Good alliance is the place where CEOs, entrepreneurs, investors, innovators, and sustainability leaders from all around the world come together.',
                    logo: '<?php echo get_template_directory_uri(); ?>/assets/asia-proptech-logo.png',
                    tags: ['Alliance', 'Sustainability']
                }
            ];
            
            const partnersGrid = document.getElementById('homepagePartnersGrid');
            if (partnersGrid) {
                featuredPartners.forEach(partner => {
                    const partnerCard = createPartnerCard(partner);
                    partnersGrid.appendChild(partnerCard);
                });
            }
        }
        
        function createPartnerCard(partner) {
            const card = document.createElement('div');
            card.className = 'partner-card';
            
            card.innerHTML = `
                <div class="partner-logo">
                    <img src="${partner.logo}" alt="${partner.name}" onerror="this.style.display='none'">
                </div>
                <h3>${partner.name}</h3>
                <p class="partner-category">${partner.category}</p>
                <p class="partner-description">${partner.description}</p>
                <div class="partner-tags">
                    ${partner.tags.map(tag => `<span class="tag">${tag}</span>`).join('')}
                </div>
            `;
            
            return card;
        }
    });
</script>

<?php get_footer(); ?>

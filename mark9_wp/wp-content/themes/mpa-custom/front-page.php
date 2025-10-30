<?php get_header(); ?>

<!-- Set custom page title -->
<script>
</script>

<main id="main" class="site-main">
    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <div class="hero-left">
                <div class="hero-text-group">
                    <h1 class="hero-title" 
                        data-en="<?php echo esc_attr(get_post_meta(get_the_ID(), '_hero_title', true) ?: 'For The Future of A Sustainable Property Market'); ?>"
                        data-bm="<?php echo esc_attr(get_post_meta(get_the_ID(), '_hero_title_bm', true) ?: 'Untuk Masa Depan Pasaran Hartanah yang Mampan'); ?>"
                        data-cn="<?php echo esc_attr(get_post_meta(get_the_ID(), '_hero_title_cn', true) ?: '为可持续房地产市场的未来'); ?>">
                        <?php 
                        $hero_title = get_post_meta(get_the_ID(), '_hero_title', true);
                        echo $hero_title ?: 'For The Future of A Sustainable Property Market';
                        ?>
                    </h1>
                    <p class="hero-subtitle"
                        data-en="<?php echo esc_attr(get_post_meta(get_the_ID(), '_hero_subtitle', true) ?: 'Leading The Digital Transformation of the Property Industry in Malaysia through innovation, collaboration, and sustainable growth. Building a strong community with integrity, inclusivity, and equality.'); ?>"
                        data-bm="<?php echo esc_attr(get_post_meta(get_the_ID(), '_hero_subtitle_bm', true) ?: 'Memimpin Transformasi Digital Industri Hartanah di Malaysia melalui inovasi, kerjasama, dan pertumbuhan mampan. Membina komuniti yang kuat dengan integriti, inklusiviti, dan kesaksamaan.'); ?>"
                        data-cn="<?php echo esc_attr(get_post_meta(get_the_ID(), '_hero_subtitle_cn', true) ?: '通过创新、协作和可持续增长，引领马来西亚房地产行业的数字化转型。以诚信、包容性和平等性建立强大社区。'); ?>">
                        <?php 
                        $hero_subtitle = get_post_meta(get_the_ID(), '_hero_subtitle', true);
                        echo $hero_subtitle ?: 'Leading The Digital Transformation of the Property Industry in Malaysia through innovation, collaboration, and sustainable growth. Building a strong community with integrity, inclusivity, and equality.';
                        ?>
                    </p>
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
                        <span class="stat-number"><?php 
                            $members_count = get_post_meta(get_the_ID(), '_stat_members', true);
                            echo $members_count ?: '150+';
                        ?></span>
                        <span class="stat-label">Members</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number"><?php 
                            $events_count = get_post_meta(get_the_ID(), '_stat_events', true);
                            echo $events_count ?: '50+';
                        ?></span>
                        <span class="stat-label">Events</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number"><?php 
                            $startups_count = get_post_meta(get_the_ID(), '_stat_startups', true);
                            echo $startups_count ?: '90+';
                        ?></span>
                        <span class="stat-label">Startups</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number"><?php 
                            $partners_count = get_post_meta(get_the_ID(), '_stat_partners', true);
                            echo $partners_count ?: '15+';
                        ?></span>
                        <span class="stat-label">Partners</span>
                    </div>
                </div>
            </div>
        <div class="hero-image">
            <div class="image-container">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('large', array('alt' => 'Malaysia Proptech Association - Kuala Lumpur Skyline')); ?>
                <?php else : ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/mpa-intro.jpg" alt="Malaysia Proptech Association - Kuala Lumpur Skyline">
                <?php endif; ?>
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
                    <p class="highlight-text">Together, we're shaping the built environment of the future!</p>
                </div>
                
                <div class="about-right">
                    <p class="strategic-anchors">MPA's work is guided by five Strategic Anchors, the pillars that define our purpose and drive our outcomes!</p>
                    
                    <div class="about-features">
                        <div class="feature">
                            <i class="fas fa-gavel"></i>
                            <div class="feature-content">
                                <h4>Advocacy</h4>
                                <p>Championing digitalization and policy reform across the industry</p>
                            </div>
                        </div>
                        <div class="feature">
                            <i class="fas fa-handshake"></i>
                            <div class="feature-content">
                                <h4>Business Opportunities</h4>
                                <p>Connecting members to funding, partnerships, and market access</p>
                            </div>
                        </div>
                        <div class="feature">
                            <i class="fas fa-users"></i>
                            <div class="feature-content">
                                <h4>Community</h4>
                                <p>Building a vibrant, collaborative ecosystem of innovators and changemakers</p>
                            </div>
                        </div>
                        <div class="feature">
                            <i class="fas fa-rocket"></i>
                            <div class="feature-content">
                                <h4>Development</h4>
                                <p>Supporting startup growth, talent acceleration, and ecosystem maturity</p>
                            </div>
                        </div>
                        <div class="feature">
                            <i class="fas fa-graduation-cap"></i>
                            <div class="feature-content">
                                <h4>Education</h4>
                                <p>Equipping the industry with knowledge, tools, and future-ready skills</p>
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
                <?php 
                $membership_tiers = mpa_get_membership_tiers();
                foreach ($membership_tiers as $tier_key => $tier_data): 
                    $featured_class = $tier_data['featured'] ? 'featured' : '';
                ?>
                <div class="membership-card <?php echo esc_attr($featured_class); ?>">
                    <div class="card-header">
                        <h3><?php echo esc_html($tier_data['name']); ?></h3>
                        <div class="price"><?php echo esc_html($tier_data['price']); ?><span>/year</span></div>
                    </div>
                    <?php echo mpa_format_membership_benefits($tier_data['benefits']); ?>
                    <a href="<?php echo esc_url(home_url('/join/')); ?>" class="btn-primary">Join Now</a>
                </div>
                <?php endforeach; ?>
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
        
        async function populateHomepageEvents() {
            // Get real events from WordPress database
            try {
                const response = await fetch('/wp-content/themes/mpa-custom/get-events-json.php');
                const allEvents = await response.json();
                
                // Filter and sort upcoming events
                const today = new Date();
                const todayStart = new Date(today.getFullYear(), today.getMonth(), today.getDate());
                
                const upcomingEvents = allEvents
                    .filter(event => {
                        const eventDate = new Date(event.date);
                        return eventDate >= todayStart;
                    })
                    .sort((a, b) => new Date(a.date) - new Date(b.date))
                    .slice(0, 3); // Take first 3 upcoming events
                
                const eventsGrid = document.getElementById('homepageEventsGrid');
                if (eventsGrid) {
                    // Clear existing content
                    eventsGrid.innerHTML = '';
                    
                    if (upcomingEvents.length > 0) {
                        upcomingEvents.forEach(event => {
                            const eventCard = createEventCard(event);
                            eventsGrid.appendChild(eventCard);
                        });
                    } else {
                        // Show placeholder if no upcoming events
                        eventsGrid.innerHTML = '<p class="no-events">No upcoming events at this time.</p>';
                    }
                }
            } catch (error) {
                // Show fallback message
                const eventsGrid = document.getElementById('homepageEventsGrid');
                if (eventsGrid) {
                    eventsGrid.innerHTML = '<p class="no-events">Unable to load events. Please try again later.</p>';
                }
            }
        }
        
        function createEventCard(event) {
            const card = document.createElement('div');
            card.className = 'event-card';
            
            // Format date for display
            const eventDate = new Date(event.date);
            const formattedDate = eventDate.toLocaleDateString('en-US', { 
                month: 'short', 
                day: 'numeric',
                year: 'numeric'
            });
            
            // Get event type for styling
            const eventType = event.type || 'event';
            
            card.innerHTML = `
                <div class="event-image">
                    <img src="${event.featured_image || '/wp-content/themes/mpa-custom/assets/placeholder-event.svg'}" alt="${event.title}" loading="lazy">
                    <div class="event-badge upcoming">UPCOMING</div>
                    <div class="event-date-badge">
                        <span class="day">${eventDate.getDate()}</span>
                        <span class="month">${eventDate.toLocaleDateString('en-US', { month: 'short' })}</span>
                    </div>
                </div>
                <div class="event-content">
                    <div class="event-meta">
                        <span class="event-location">
                            <i class="fas fa-${event.location && event.location.toLowerCase().includes('online') ? 'globe' : 'map-marker-alt'}"></i> 
                            ${event.location || 'TBD'}
                        </span>
                        <span class="event-time">
                            <i class="fas fa-clock"></i> ${formattedDate}
                        </span>
                    </div>
                    <h3 class="event-title">${event.title}</h3>
                    <p class="event-description">${event.excerpt || event.description}</p>
                    <div class="event-footer">
                        <span class="event-price">${event.price || 'Free'}</span>
                        <div class="event-actions">
                            <a href="/events/" class="btn-secondary">View Details</a>
                        </div>
                    </div>
                </div>
            `;
            
            return card;
        }
        
        function initSearchFunctionality() {
            const searchInput = document.getElementById('searchInput');
            const searchBtn = document.getElementById('searchBtn');
            
            
            if (searchInput && searchBtn) {
                // Handle search button click
                searchBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    performSearch();
                });
                
                // Handle Enter key press
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
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
            }
            
            function performSearch() {
                const query = searchInput.value.trim().toLowerCase();
                
                if (query === '') {
                    showSearchNotification('Please enter a search term', 'warning');
                    return;
                }
                
                
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
                    <img src="${partner.logo}" alt="${partner.name}" onerror="this.style.display='none'" loading="lazy">
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

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
                    <h1 class="hero-title" data-translate="hero-title">
                        <?php the_field('hero-title'); ?>
                    </h1>
                    <p class="hero-subtitle" data-translate="hero-subtitle">
                        <?php the_field('hero-subtitle'); ?>
                    </p>
                </div>
                <div class="hero-search">
                    <div class="search-container">
                        <div class="search-input">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchInput" placeholder="<?php echo esc_attr(get_field('search-placeholder')); ?>" data-translate="search-placeholder">
                        </div>
                        <button class="search-btn" id="searchBtn" data-translate="search-btn"><?php the_field('search-btn'); ?></button>
                    </div>
                </div>
                <div class="hero-stats">
                    <div class="stat">
                        <span class="stat-number">150+</span>
                        <span class="stat-label" data-translate="stat-members"><?php the_field('stat-members'); ?></span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">50+</span>
                        <span class="stat-label" data-translate="stat-events"><?php the_field('stat-events'); ?></span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">90+</span>
                        <span class="stat-label" data-translate="stat-startups"><?php the_field('stat-startups'); ?></span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">15+</span>
                        <span class="stat-label" data-translate="stat-partners"><?php the_field('stat-partners'); ?></span>
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
        </div>
    </section>

    <!-- About MPA Section -->
    <section id="about" class="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2 data-translate="about-heading"><?php the_field('about-heading'); ?></h2>
                    <p class="tie-paragraph" data-translate="about-intro"><?php the_field('about-intro'); ?></p>
                    <p data-translate="about-mpa-desc"><?php the_field('about-mpa-desc'); ?></p>
                    <p data-translate="about-mission"><?php the_field('about-mission'); ?></p>
                    <p data-translate="about-belief"><?php the_field('about-belief'); ?></p>
                    <p class="highlight-text" data-translate="about-cta"><?php the_field('about-cta'); ?></p>
                </div>
                
                <div class="about-right">
                    <p class="strategic-anchors" data-translate="strategic-anchors-heading"><?php the_field('strategic-anchors-heading'); ?></p>
                    
                    <div class="about-features">
                        <div class="feature">
                            <i class="fas fa-gavel"></i>
                            <div class="feature-content">
                                <h4><?php the_field('pillar_1_title'); ?></h4>
                                <p><?php the_field('pillar_1_desc'); ?></p>
                            </div>
                        </div>
                        <div class="feature">
                            <i class="fas fa-handshake"></i>
                            <div class="feature-content">
                                <h4><?php the_field('pillar_2_title'); ?></h4>
                                <p><?php the_field('pillar_2_desc'); ?></p>
                            </div>
                        </div>
                        <div class="feature">
                            <i class="fas fa-users"></i>
                            <div class="feature-content">
                                <h4><?php the_field('pillar_3_title'); ?></h4>
                                <p><?php the_field('pillar_3_desc'); ?></p>
                            </div>
                        </div>
                        <div class="feature">
                            <i class="fas fa-rocket"></i>
                            <div class="feature-content">
                                <h4><?php the_field('pillar_4_title'); ?></h4>
                                <p><?php the_field('pillar_4_desc'); ?></p>
                            </div>
                        </div>
                        <div class="feature">
                            <i class="fas fa-graduation-cap"></i>
                            <div class="feature-content">
                                <h4><?php the_field('pillar_5_title'); ?></h4>
                                <p><?php the_field('pillar_5_desc'); ?></p>
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
                <h2 data-translate="events-title"><?php the_field('events-title'); ?></h2>
                <a href="<?php echo esc_url(home_url('/events/')); ?>" class="view-all" data-translate="view-all-events"><?php the_field('view-all-events'); ?></a>
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
                <h2 data-translate="partners-title"><?php the_field('partners-title'); ?></h2>
                <p data-translate="partners-subtitle"><?php the_field('partners-subtitle'); ?></p>
            </div>
            <div class="partners-grid" id="homepagePartnersGrid">
                <!-- Partners will be populated dynamically from partners page data -->
            </div>
            <div class="partners-cta">
                <a href="<?php echo esc_url(home_url('/partners/')); ?>" class="btn-outline" data-translate="view-all-partners"><?php the_field('view-all-partners'); ?></a>
            </div>
        </div>
    </section>

    <!-- Membership Section -->
    <section id="membership" class="membership">
        <div class="container">
            <div class="section-header">
                <h2 data-translate="community-title"><?php the_field('community-title'); ?></h2>
                <p data-translate="community-subtitle"><?php the_field('community-subtitle'); ?></p>
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
                <h2><?php
    if (function_exists('pll_current_language')) {
        $lang = pll_current_language();
        if ($lang === 'bm') echo 'Kekal Dikemas Kini';
        elseif ($lang === 'cn') echo '保持更新';
        else echo 'Stay Updated';
    } else {
        echo 'Stay Updated';
    }
    ?></h2>
                <p><?php
    if (function_exists('pll_current_language')) {
        $lang = pll_current_language();
        if ($lang === 'bm') echo 'Dapatkan berita, acara, dan pandangan PropTech terkini dihantar ke peti masuk anda';
        elseif ($lang === 'cn') echo '获取最新的房地产科技新闻、活动和见解，直接发送到您的收件箱';
        else echo 'Get the latest PropTech news, events, and insights delivered to your inbox';
    } else {
        echo 'Get the latest PropTech news, events, and insights delivered to your inbox';
    }
    ?></p>
                <div class="newsletter-form">
                    <input type="email" placeholder="<?php
    if (function_exists('pll_current_language')) {
        $lang = pll_current_language();
        if ($lang === 'bm') echo 'Masukkan alamat e-mel anda';
        elseif ($lang === 'cn') echo '输入您的电子邮件地址';
        else echo 'Enter your email address';
    } else {
        echo 'Enter your email address';
    }
    ?>">
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
            
            function performSearch() {const query = searchInput.value.trim();if (query === '') {
                    showSearchNotification('Please enter a search term', 'warning');
                    return;
                }
                
                if (query.length < 2) {
                    showSearchNotification('Please enter at least 2 characters', 'warning');
                    return;
                }
                
                // Show loading state
                searchBtn.disabled = true;
                searchBtn.textContent = 'Searching...';
                
                // Perform AJAX search
                fetch(window.location.origin + '/wp-admin/admin-ajax.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=mpa_site_search&query=${encodeURIComponent(query)}`
                })
                .then(response => {return response.json();
                })
                .then(data => {if (data.data && data.data.results) {}
                    
                    searchBtn.disabled = false;
                    searchBtn.textContent = 'Search';
                    
                    if (data.success && data.data && data.data.results && data.data.results.length > 0) {showSearchResults(data.data.results, query);
                    } else {showSearchNotification(`No results found for "${query}"`, 'error');
                    }
                })
                .catch(error => {
                    console.error('Search error details:', error);
                    searchBtn.disabled = false;
                    searchBtn.textContent = 'Search';
                    showSearchNotification('Search failed. Please try again.', 'error');
                });
            }
            
            function showSearchResults(results, query) {
                // Remove any existing results container
                const existingResults = document.querySelector('.search-results-dropdown');
                if (existingResults) {
                    existingResults.remove();
                }
                
                // Create results dropdown
                const resultsContainer = document.createElement('div');
                resultsContainer.className = 'search-results-dropdown';
                resultsContainer.style.display = 'block';
                resultsContainer.innerHTML = `
                    <div class="search-results-header">
                        <strong>Found ${results.length} result(s) for "${query}"</strong>
                        <button class="close-results" onclick="this.closest('.search-results-dropdown').remove()">×</button>
                    </div>
                    <div class="search-results-list">
                        ${results.map(result => `
                            <a href="${result.url}" class="search-result-item">
                                <div class="result-type">${result.type}</div>
                                <div class="result-title">${result.title}</div>
                                ${result.excerpt ? `<div class="result-excerpt">${result.excerpt}</div>` : ''}
                            </a>
                        `).join('')}
                    </div>
                    <div class="search-results-footer">
                        <a href="/?s=${encodeURIComponent(query)}" class="view-all-results">
                            View all results →
                        </a>
                    </div>
                `;
                
                // Insert directly into hero section, not relative to search container
                const heroSection = document.querySelector('.hero-search');
                if (heroSection) {
                    // Append directly to hero-search
                    heroSection.appendChild(resultsContainer);
                } else {
                    // Fallback: insert after search button
                    const searchBtn = document.getElementById('searchBtn');
                    if (searchBtn) {
                        searchBtn.parentNode.appendChild(resultsContainer);
                    }
                }
                
                // Add CSS for results dropdown
                if (!document.querySelector('#search-results-styles')) {
                    const style = document.createElement('style');
                    style.id = 'search-results-styles';
                    style.textContent = `
                        .search-results-dropdown {
                            position: relative;
                            width: 100%;
                            max-width: 800px;
                            margin: 20px auto 0;
                            background: white;
                            border-radius: 12px;
                            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
                            max-height: 500px;
                            overflow: hidden;
                            z-index: 10000;
                            display: block !important;
                        }
                        .search-results-header {
                            padding: 15px 20px;
                            background: #f8f9fa;
                            border-bottom: 1px solid #e9ecef;
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                        }
                        .close-results {
                            background: none;
                            border: none;
                            font-size: 24px;
                            cursor: pointer;
                            color: #6c757d;
                            padding: 0;
                            width: 30px;
                            height: 30px;
                            line-height: 1;
                        }
                        .close-results:hover {
                            color: #000;
                        }
                        .search-results-list {
                            max-height: 400px;
                            overflow-y: auto;
                        }
                        .search-result-item {
                            display: block;
                            padding: 15px 20px;
                            border-bottom: 1px solid #e9ecef;
                            text-decoration: none;
                            color: inherit;
                            transition: background 0.2s;
                        }
                        .search-result-item:hover {
                            background: #f8f9fa;
                        }
                        .result-type {
                            font-size: 12px;
                            text-transform: uppercase;
                            color: #6c757d;
                            margin-bottom: 5px;
                            font-weight: 600;
                        }
                        .result-title {
                            font-size: 16px;
                            font-weight: 600;
                            color: #212529;
                            margin-bottom: 5px;
                        }
                        .result-excerpt {
                            font-size: 14px;
                            color: #6c757d;
                            line-height: 1.4;
                        }
                        .search-results-footer {
                            padding: 15px 20px;
                            background: #f8f9fa;
                            border-top: 1px solid #e9ecef;
                            text-align: center;
                        }
                        .view-all-results {
                            color: #007bff;
                            text-decoration: none;
                            font-weight: 600;
                        }
                        .view-all-results:hover {
                            text-decoration: underline;
                        }
                        .hero-search {
                            position: relative;
                            width: 100%;
                        }
                    `;
                    document.head.appendChild(style);
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

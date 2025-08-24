<?php
/*
Plugin Name: MPA Mobile Events Fixed
Description: Mobile-responsive events page with single header - no duplicates
Version: 1.1
Author: MPA Development Team
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class MPA_Mobile_Events_Fixed {
    
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_mobile_styles'));
        add_action('wp_head', array($this, 'add_mobile_meta'));
        add_filter('the_content', array($this, 'replace_mobile_content'));
    }
    
    public function enqueue_mobile_styles() {
        // Only load on events page
        if (!is_page('mpa-events')) {
            return;
        }
        
        // Add mobile-specific CSS
        wp_add_inline_style('wp-block-library', $this->get_mobile_css());
    }
    
    public function add_mobile_meta() {
        // Only on events page
        if (!is_page('mpa-events')) {
            return;
        }
        
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">' . "\n";
    }
    
    public function replace_mobile_content($content) {
        // Only on events page and mobile devices
        if (!is_page('mpa-events')) {
            return $content;
        }
        
        // Check if mobile (simple detection)
        $is_mobile = wp_is_mobile() || (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/Mobile|Android|iPhone|iPad/', $_SERVER['HTTP_USER_AGENT']));
        
        if ($is_mobile) {
            return $this->get_mobile_events_content();
        }
        
        return $content; // Keep original content for desktop
    }
    
    private function get_mobile_events_content() {
        ob_start();
        
        // Get events from categories 303 and 344
        $events_query = new WP_Query(array(
            'post_type' => 'post',
            'category__in' => array(303, 344),
            'posts_per_page' => 10,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC'
        ));
        
        ?>
        <div class="mpa-mobile-events-wrapper">
            
            <!-- Filter Tabs -->
            <div class="mpa-filter-tabs">
                <button class="mpa-filter-tab active">All Events</button>
                <button class="mpa-filter-tab">This Month</button>
                <button class="mpa-filter-tab">Upcoming</button>
                <button class="mpa-filter-tab">Webinars</button>
            </div>
            
            <!-- Search Bar -->
            <div class="mpa-search-container">
                <div class="mpa-search-input">
                    <span class="mpa-search-icon">🔍</span>
                    <input type="text" placeholder="Search events..." id="mpa-search">
                </div>
            </div>
            
            <!-- Events List -->
            <div class="mpa-events-list">
                <?php if ($events_query->have_posts()) : ?>
                    <?php $event_count = 0; ?>
                    <?php while ($events_query->have_posts()) : $events_query->the_post(); ?>
                        <?php $event_count++; ?>
                        
                        <div class="mpa-event-card <?php echo ($event_count == 1) ? 'featured' : ''; ?>">
                            
                            <?php if ($event_count == 1) : ?>
                                <div class="mpa-featured-badge">Featured Event</div>
                            <?php endif; ?>
                            
                            <div class="mpa-event-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium', array('class' => 'mpa-event-thumb')); ?>
                                <?php else : ?>
                                    <div class="mpa-event-icon">
                                        <span>📅</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mpa-event-content">
                                <div class="mpa-event-date">
                                    <div class="mpa-date-day"><?php echo get_the_date('d'); ?></div>
                                    <div class="mpa-date-month"><?php echo get_the_date('M'); ?></div>
                                </div>
                                
                                <div class="mpa-event-info">
                                    <h3 class="mpa-event-title"><?php the_title(); ?></h3>
                                    
                                    <div class="mpa-event-excerpt">
                                        <?php 
                                        $excerpt = get_the_excerpt();
                                        echo wp_trim_words($excerpt, 20, '...');
                                        ?>
                                    </div>
                                    
                                    <div class="mpa-event-meta">
                                        <span class="mpa-meta-item">
                                            <span class="mpa-meta-icon">🕒</span>
                                            <?php echo get_the_date('F j, Y'); ?>
                                        </span>
                                        
                                        <?php 
                                        $categories = get_the_category();
                                        if ($categories) :
                                        ?>
                                            <span class="mpa-meta-item">
                                                <span class="mpa-meta-icon">📂</span>
                                                <?php echo esc_html($categories[0]->name); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="mpa-event-actions">
                                        <a href="<?php the_permalink(); ?>" class="mpa-btn-primary">
                                            Learn More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    <?php endwhile; ?>
                    
                <?php else : ?>
                    
                    <!-- No events found - show sample events -->
                    <div class="mpa-event-card featured">
                        <div class="mpa-featured-badge">Featured Event</div>
                        <div class="mpa-event-image">
                            <div class="mpa-event-icon">
                                <span>🏢</span>
                            </div>
                        </div>
                        <div class="mpa-event-content">
                            <div class="mpa-event-date">
                                <div class="mpa-date-day">20</div>
                                <div class="mpa-date-month">Sep</div>
                            </div>
                            <div class="mpa-event-info">
                                <h3 class="mpa-event-title">Asia Pacific PropTech Summit 2025</h3>
                                <div class="mpa-event-excerpt">
                                    Premier PropTech conference in the Asia Pacific region featuring industry leaders and innovation showcases.
                                </div>
                                <div class="mpa-event-meta">
                                    <span class="mpa-meta-item">
                                        <span class="mpa-meta-icon">🕒</span>
                                        September 20-22, 2025
                                    </span>
                                    <span class="mpa-meta-item">
                                        <span class="mpa-meta-icon">📍</span>
                                        Singapore
                                    </span>
                                </div>
                                <div class="mpa-event-actions">
                                    <a href="#" class="mpa-btn-primary">Learn More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mpa-event-card">
                        <div class="mpa-event-image">
                            <div class="mpa-event-icon">
                                <span>💻</span>
                            </div>
                        </div>
                        <div class="mpa-event-content">
                            <div class="mpa-event-date">
                                <div class="mpa-date-day">25</div>
                                <div class="mpa-date-month">Aug</div>
                            </div>
                            <div class="mpa-event-info">
                                <h3 class="mpa-event-title">Digital Transformation in PropTech</h3>
                                <div class="mpa-event-excerpt">
                                    Explore the latest digital technologies transforming property operations and management.
                                </div>
                                <div class="mpa-event-meta">
                                    <span class="mpa-meta-item">
                                        <span class="mpa-meta-icon">🕒</span>
                                        August 25, 2025
                                    </span>
                                    <span class="mpa-meta-item">
                                        <span class="mpa-meta-icon">💻</span>
                                        Virtual Event
                                    </span>
                                </div>
                                <div class="mpa-event-actions">
                                    <a href="#" class="mpa-btn-primary">Learn More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                <?php endif; ?>
                
                <?php wp_reset_postdata(); ?>
            </div>
            
            <!-- Newsletter Section -->
            <div class="mpa-newsletter">
                <h3>Stay Updated</h3>
                <p>Get notified about upcoming PropTech events and exclusive member benefits.</p>
                <form class="mpa-newsletter-form">
                    <input type="email" placeholder="Enter your email" required>
                    <button type="submit" class="mpa-btn-primary">Subscribe</button>
                </form>
            </div>
            
            <!-- Floating Action Button -->
            <div class="mpa-fab" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
                ↑
            </div>
            
        </div>
        
        <script>
        // Mobile search functionality
        document.getElementById('mpa-search').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const eventCards = document.querySelectorAll('.mpa-event-card');
            
            eventCards.forEach(card => {
                const title = card.querySelector('.mpa-event-title').textContent.toLowerCase();
                const excerpt = card.querySelector('.mpa-event-excerpt').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || excerpt.includes(searchTerm) || searchTerm === '') {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
        
        // Filter tab functionality
        document.querySelectorAll('.mpa-filter-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.mpa-filter-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });
        </script>
        
        <?php
        
        return ob_get_clean();
    }
    
    private function get_mobile_css() {
        return '
        /* MPA MOBILE EVENTS - NO DUPLICATE HEADERS */
        @media screen and (max-width: 768px) {
            
            /* Hide desktop elements AND original page header */
            .page-header,
            .entry-header,
            .breadcrumbs,
            .site-header .header-elements,
            body.page-id-30841 .entry-header,
            body.page-id-30841 .page-header {
                display: none !important;
            }
            
            /* Full width container */
            .container,
            .content-area,
            .site-main,
            .entry-content {
                max-width: 100% !important;
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            
            /* Mobile Events Wrapper */
            .mpa-mobile-events-wrapper {
                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
                min-height: 100vh !important;
                padding-top: 0 !important;
            }
            
            /* Filter Tabs - moved to top */
            .mpa-filter-tabs {
                display: flex !important;
                padding: 1rem !important;
                gap: 0.5rem !important;
                background: white !important;
                border-bottom: 1px solid #e2e8f0 !important;
                overflow-x: auto !important;
                scrollbar-width: none !important;
                margin-top: 0 !important;
            }
            
            .mpa-filter-tabs::-webkit-scrollbar {
                display: none !important;
            }
            
            .mpa-filter-tab {
                background: #f1f5f9 !important;
                border: none !important;
                padding: 0.5rem 1rem !important;
                border-radius: 20px !important;
                font-size: 0.85rem !important;
                font-weight: 600 !important;
                color: #64748b !important;
                white-space: nowrap !important;
                cursor: pointer !important;
                transition: all 0.3s ease !important;
            }
            
            .mpa-filter-tab.active {
                background: #0978bd !important;
                color: white !important;
                box-shadow: 0 4px 12px rgba(9, 120, 189, 0.3) !important;
            }
            
            /* Search Container */
            .mpa-search-container {
                padding: 1rem !important;
                background: white !important;
            }
            
            .mpa-search-input {
                display: flex !important;
                align-items: center !important;
                background: #f8fafc !important;
                border-radius: 12px !important;
                padding: 0.75rem 1rem !important;
                border: 2px solid transparent !important;
                transition: all 0.3s ease !important;
            }
            
            .mpa-search-input:focus-within {
                border-color: #0978bd !important;
                background: white !important;
                box-shadow: 0 0 0 4px rgba(9, 120, 189, 0.1) !important;
            }
            
            .mpa-search-icon {
                margin-right: 0.75rem !important;
                color: #94a3b8 !important;
            }
            
            .mpa-search-input input {
                border: none !important;
                background: transparent !important;
                outline: none !important;
                flex: 1 !important;
                font-size: 0.9rem !important;
                color: #1e293b !important;
            }
            
            /* Events List */
            .mpa-events-list {
                padding: 0 1rem !important;
            }
            
            .mpa-event-card {
                background: white !important;
                border-radius: 16px !important;
                overflow: hidden !important;
                box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
                margin-bottom: 1rem !important;
                transition: all 0.3s ease !important;
            }
            
            .mpa-event-card:hover {
                transform: translateY(-2px) !important;
                box-shadow: 0 8px 32px rgba(0,0,0,0.12) !important;
            }
            
            .mpa-event-card.featured {
                position: relative !important;
                box-shadow: 0 8px 32px rgba(0,0,0,0.15) !important;
            }
            
            .mpa-featured-badge {
                position: absolute !important;
                top: 1rem !important;
                left: 1rem !important;
                background: linear-gradient(135deg, #f59e0b, #f97316) !important;
                color: white !important;
                padding: 0.25rem 0.75rem !important;
                border-radius: 12px !important;
                font-size: 0.7rem !important;
                font-weight: 700 !important;
                z-index: 3 !important;
                text-transform: uppercase !important;
            }
            
            .mpa-event-image {
                position: relative !important;
                height: 100px !important;
                background: linear-gradient(135deg, #0978bd 0%, #0693e3 100%) !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }
            
            .mpa-event-card.featured .mpa-event-image {
                height: 120px !important;
            }
            
            .mpa-event-thumb {
                width: 100% !important;
                height: 100% !important;
                object-fit: cover !important;
            }
            
            .mpa-event-icon {
                font-size: 2rem !important;
                color: white !important;
                opacity: 0.9 !important;
            }
            
            .mpa-event-card.featured .mpa-event-icon {
                font-size: 3rem !important;
            }
            
            .mpa-event-content {
                display: flex !important;
                padding: 1rem !important;
                gap: 1rem !important;
            }
            
            .mpa-event-date {
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                background: #f8fafc !important;
                border-radius: 10px !important;
                padding: 0.5rem !important;
                min-width: 50px !important;
            }
            
            .mpa-date-day {
                font-size: 1.2rem !important;
                font-weight: 800 !important;
                color: #1e293b !important;
                line-height: 1 !important;
            }
            
            .mpa-date-month {
                font-size: 0.7rem !important;
                font-weight: 600 !important;
                color: #64748b !important;
                text-transform: uppercase !important;
            }
            
            .mpa-event-info {
                flex: 1 !important;
            }
            
            .mpa-event-title {
                font-size: 1.1rem !important;
                font-weight: 600 !important;
                color: #1e293b !important;
                margin: 0 0 0.5rem 0 !important;
                line-height: 1.3 !important;
            }
            
            .mpa-event-card.featured .mpa-event-title {
                font-size: 1.3rem !important;
                font-weight: 700 !important;
            }
            
            .mpa-event-excerpt {
                font-size: 0.85rem !important;
                color: #64748b !important;
                margin: 0 0 0.75rem 0 !important;
                line-height: 1.4 !important;
            }
            
            .mpa-event-meta {
                display: flex !important;
                gap: 1rem !important;
                flex-wrap: wrap !important;
                margin-bottom: 1rem !important;
            }
            
            .mpa-meta-item {
                display: flex !important;
                align-items: center !important;
                gap: 0.25rem !important;
                font-size: 0.75rem !important;
                color: #64748b !important;
            }
            
            .mpa-meta-icon {
                font-size: 0.8rem !important;
            }
            
            .mpa-btn-primary {
                background: linear-gradient(135deg, #0978bd, #0693e3) !important;
                color: white !important;
                border: none !important;
                padding: 0.625rem 1.25rem !important;
                border-radius: 10px !important;
                font-size: 0.85rem !important;
                font-weight: 600 !important;
                cursor: pointer !important;
                text-decoration: none !important;
                display: inline-block !important;
                transition: all 0.3s ease !important;
                box-shadow: 0 2px 8px rgba(9, 120, 189, 0.3) !important;
            }
            
            .mpa-btn-primary:hover {
                transform: translateY(-1px) !important;
                box-shadow: 0 4px 12px rgba(9, 120, 189, 0.4) !important;
                color: white !important;
                text-decoration: none !important;
            }
            
            /* Newsletter */
            .mpa-newsletter {
                background: white !important;
                border-radius: 20px !important;
                padding: 2rem 1rem !important;
                margin: 2rem 1rem !important;
                text-align: center !important;
                box-shadow: 0 8px 32px rgba(0,0,0,0.1) !important;
            }
            
            .mpa-newsletter h3 {
                font-size: 1.3rem !important;
                font-weight: 700 !important;
                color: #1e293b !important;
                margin-bottom: 0.5rem !important;
            }
            
            .mpa-newsletter p {
                color: #64748b !important;
                margin-bottom: 1.5rem !important;
                font-size: 0.9rem !important;
            }
            
            .mpa-newsletter-form {
                display: flex !important;
                flex-direction: column !important;
                gap: 0.75rem !important;
            }
            
            .mpa-newsletter-form input {
                padding: 0.875rem 1rem !important;
                border: 2px solid #e2e8f0 !important;
                border-radius: 12px !important;
                font-size: 0.9rem !important;
                outline: none !important;
            }
            
            .mpa-newsletter-form input:focus {
                border-color: #0978bd !important;
                box-shadow: 0 0 0 4px rgba(9, 120, 189, 0.1) !important;
            }
            
            /* Floating Action Button */
            .mpa-fab {
                position: fixed !important;
                bottom: 20px !important;
                right: 20px !important;
                width: 50px !important;
                height: 50px !important;
                background: linear-gradient(135deg, #0978bd, #0693e3) !important;
                color: white !important;
                border-radius: 50% !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                font-size: 18px !important;
                font-weight: bold !important;
                cursor: pointer !important;
                z-index: 1000 !important;
                box-shadow: 0 4px 12px rgba(9, 120, 189, 0.3) !important;
                transition: all 0.3s ease !important;
            }
            
            .mpa-fab:hover {
                transform: scale(1.1) !important;
                box-shadow: 0 6px 20px rgba(9, 120, 189, 0.4) !important;
            }
        }';
    }
}

// Initialize the plugin
new MPA_Mobile_Events_Fixed();

?>

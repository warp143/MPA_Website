<?php
/**
 * Template Name: Home Page
 *
 * @package MPA_Theme
 */

get_header();
?>

<!-- Hero Section - Creative Layout -->
<section id="home" class="hero">
    <div class="hero-background">
        <div class="floating-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
        </div>
    </div>
    
    <div class="hero-content">
        <div class="hero-text">
            <h1 class="hero-title">
                <span class="title-line"><?php echo get_theme_mod('hero_title_line1', 'Malaysia PropTech'); ?></span>
                <span class="title-line highlight"><?php echo get_theme_mod('hero_title_line2', 'Association'); ?></span>
                <span class="title-line"><?php echo get_theme_mod('hero_title_line3', 'For The Future of A Sustainable Property Market'); ?></span>
            </h1>
            <p class="hero-subtitle">
                <?php echo get_theme_mod('hero_subtitle', 'Leading the digital transformation of the property industry in Malaysia through innovation, collaboration, and sustainable growth. Building a strong community with integrity, inclusivity, and equality.'); ?>
            </p>
            <div class="hero-stats">
                <div class="stat">
                    <span class="stat-number"><?php echo get_theme_mod('hero_stat_members', '50+'); ?></span>
                    <span class="stat-label"><?php esc_html_e('Members', 'mpa-theme'); ?></span>
                </div>
                <div class="stat">
                    <span class="stat-number"><?php echo get_theme_mod('hero_stat_committee', '15+'); ?></span>
                    <span class="stat-label"><?php esc_html_e('Committee', 'mpa-theme'); ?></span>
                </div>
                <div class="stat">
                    <span class="stat-number"><?php echo get_theme_mod('hero_stat_events', '25+'); ?></span>
                    <span class="stat-label"><?php esc_html_e('Events', 'mpa-theme'); ?></span>
                </div>
            </div>
        </div>
        
        <div class="hero-visual">
            <div class="hero-image">
                <?php
                $hero_image = get_theme_mod('hero_image');
                if ($hero_image) {
                    echo wp_get_attachment_image($hero_image, 'hero-image', false, array('class' => 'hero-img', 'alt' => get_bloginfo('name')));
                } else {
                    echo '<img src="' . get_template_directory_uri() . '/assets/mpa-intro.jpg" alt="MPA Introduction" class="hero-img">';
                }
                ?>
            </div>
        </div>
    </div>
</section>

<!-- MPA Pillars Section -->
<section id="ecosystem" class="ecosystem">
    <div class="section-header">
        <h2 class="section-title"><?php echo get_theme_mod('ecosystem_title', 'MPA\'s Pillars'); ?></h2>
        <p class="section-subtitle"><?php echo get_theme_mod('ecosystem_subtitle', 'Building a strong community with integrity, inclusivity, and equality of all PropTech Members'); ?></p>
    </div>
    
    <div class="ecosystem-grid">
        <?php
        $pillars = array(
            array(
                'icon' => 'fas fa-bullhorn',
                'title' => 'Promote',
                'description' => 'MPA will promote all members, stakeholders, and strategic partners',
                'tags' => array('Global Reach', 'Strategic Partners')
            ),
            array(
                'icon' => 'fas fa-lightbulb',
                'title' => 'Inspire',
                'description' => 'MPA is here to inspire its members, students, fresh grads, and the property industry at large',
                'tags' => array('Students', 'Fresh Grads')
            ),
            array(
                'icon' => 'fas fa-calendar-check',
                'title' => 'Events',
                'description' => 'MPA members organize and participate in global events',
                'tags' => array('Local Events', 'Global Events')
            ),
            array(
                'icon' => 'fas fa-handshake',
                'title' => 'Partnerships',
                'description' => 'MPA actively seeks for partnerships in Malaysia & abroad',
                'tags' => array('Local Partners', 'International')
            ),
            array(
                'icon' => 'fas fa-briefcase',
                'title' => 'Employment',
                'description' => 'MPA believes in education and deployment within the PropTech industry',
                'tags' => array('Education', 'Deployment')
            ),
            array(
                'icon' => 'fas fa-rocket',
                'title' => 'Innovation',
                'description' => 'MPA helps to drive the PropTech Industry towards higher levels of innovation and technology',
                'tags' => array('Technology', 'Innovation')
            )
        );
        
        foreach ($pillars as $pillar) : ?>
            <div class="ecosystem-card">
                <div class="card-icon">
                    <i class="<?php echo esc_attr($pillar['icon']); ?>"></i>
                </div>
                <h3><?php echo esc_html($pillar['title']); ?></h3>
                <p><?php echo esc_html($pillar['description']); ?></p>
                <div class="card-stats">
                    <?php foreach ($pillar['tags'] as $tag) : ?>
                        <span><?php echo esc_html($tag); ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Committee Section -->
<section id="committee" class="innovation">
    <div class="innovation-container">
        <div class="innovation-content">
            <h2 class="innovation-title"><?php esc_html_e('Our Committee', 'mpa-theme'); ?></h2>
            <p class="innovation-text">
                <?php echo get_theme_mod('committee_description', 'Meet the dedicated team leading Malaysia\'s PropTech transformation. Our committee members bring diverse expertise and vision to drive innovation in the property technology sector.'); ?>
            </p>
            
            <div class="innovation-features">
                <?php
                $committee_members = get_posts(array(
                    'post_type' => 'committee_members',
                    'posts_per_page' => 6,
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ));
                
                if ($committee_members) :
                    foreach ($committee_members as $member) :
                        $role = get_field('committee_role', $member->ID);
                        $bio = get_field('committee_bio', $member->ID);
                        $linkedin = get_field('committee_linkedin', $member->ID);
                        ?>
                        <div class="feature">
                            <div class="feature-avatar">
                                <?php if (has_post_thumbnail($member->ID)) : ?>
                                    <?php echo get_the_post_thumbnail($member->ID, 'committee-thumbnail', array('class' => 'committee-img')); ?>
                                <?php else : ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/placeholder-member.jpg" alt="<?php echo esc_attr($member->post_title); ?>" class="committee-img">
                                <?php endif; ?>
                            </div>
                            <div class="feature-content">
                                <h4><?php echo esc_html($member->post_title); ?></h4>
                                <?php if ($role) : ?>
                                    <p class="committee-role"><?php echo esc_html($role); ?></p>
                                <?php endif; ?>
                                <p><?php echo esc_html($bio ? $bio : $member->post_excerpt); ?></p>
                                <?php if ($linkedin) : ?>
                                    <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer" class="linkedin-link">
                                        <i class="fab fa-linkedin"></i> <?php esc_html_e('LinkedIn', 'mpa-theme'); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                    endforeach;
                else :
                    // Fallback committee members
                    $fallback_members = array(
                        array('name' => 'Dr. Daniele Gambero', 'role' => 'President', 'bio' => 'Leading the digital transformation with 15+ years of experience', 'image' => 'daniele-gambero.webp'),
                        array('name' => 'Jason Ding', 'role' => 'Deputy President', 'bio' => 'Driving innovation and strategic partnerships', 'image' => 'jason-ding.webp'),
                        array('name' => 'Wong Keh Wei', 'role' => 'Secretary', 'bio' => 'Managing operations and member communications', 'image' => 'wong-keh-wei.png'),
                        array('name' => 'Liz Ang Gaik See', 'role' => 'Treasurer', 'bio' => 'Financial oversight and resource management', 'image' => 'liz-ang.webp'),
                        array('name' => 'Angela Kew Chui Teen', 'role' => 'VP Membership', 'bio' => 'Growing and nurturing our community', 'image' => 'angela-kew.png'),
                        array('name' => 'Naga R Krishnan', 'role' => 'VP Events', 'bio' => 'Organizing impactful industry events', 'image' => 'naga-krishnan.webp')
                    );
                    
                    foreach ($fallback_members as $member) : ?>
                        <div class="feature">
                            <div class="feature-avatar">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/<?php echo esc_attr($member['image']); ?>" alt="<?php echo esc_attr($member['name']); ?>" class="committee-img">
                            </div>
                            <div class="feature-content">
                                <h4><?php echo esc_html($member['name']); ?></h4>
                                <p class="committee-role"><?php echo esc_html($member['role']); ?></p>
                                <p><?php echo esc_html($member['bio']); ?></p>
                            </div>
                        </div>
                    <?php endforeach;
                endif; ?>
            </div>
        </div>
        
        <div class="innovation-visual">
            <div class="tech-sphere">
                <div class="sphere-ring ring-1"></div>
                <div class="sphere-ring ring-2"></div>
                <div class="sphere-ring ring-3"></div>
                <div class="sphere-core">
                    <i class="fas fa-users-cog"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Events Section -->
<section id="events" class="community">
    <div class="section-header">
        <h2 class="section-title"><?php esc_html_e('Latest Events', 'mpa-theme'); ?></h2>
        <p class="section-subtitle"><?php esc_html_e('Join us for inspiring events that shape the future of PropTech', 'mpa-theme'); ?></p>
    </div>
    
    <div class="community-showcase">
        <?php
        $events = get_posts(array(
            'post_type' => 'events',
            'posts_per_page' => 3,
            'meta_query' => array(
                array(
                    'key' => 'event_date',
                    'value' => date('Y-m-d'),
                    'compare' => '>=',
                    'type' => 'DATE'
                )
            ),
            'orderby' => 'meta_value',
            'meta_key' => 'event_date',
            'order' => 'ASC'
        ));
        
        if ($events) :
            foreach ($events as $index => $event) :
                $event_date = get_field('event_date', $event->ID);
                $event_location = get_field('event_location', $event->ID);
                $event_type = get_field('event_type', $event->ID);
                $featured_class = ($index === 0) ? ' featured' : '';
                ?>
                <div class="showcase-card<?php echo $featured_class; ?>">
                    <?php if (has_post_thumbnail($event->ID)) : ?>
                        <div class="event-image">
                            <?php echo get_the_post_thumbnail($event->ID, 'event-thumbnail', array('class' => 'event-img')); ?>
                        </div>
                    <?php endif; ?>
                    <h3><?php echo esc_html($event->post_title); ?></h3>
                    <?php if ($event_date) : ?>
                        <p class="member-role"><?php echo date('F j, Y', strtotime($event_date)); ?></p>
                    <?php endif; ?>
                    <p class="member-bio"><?php echo esc_html($event->post_excerpt); ?></p>
                    <div class="member-projects">
                        <?php if ($event_type) : ?>
                            <span class="project-tag"><?php echo esc_html(ucfirst($event_type)); ?></span>
                        <?php endif; ?>
                        <?php if ($event_location) : ?>
                            <span class="project-tag"><?php echo esc_html($event_location); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
            endforeach;
        else :
            // Fallback events
            $fallback_events = array(
                array('title' => 'MPA\'s Pillars', 'type' => 'Building Strong Community', 'description' => 'MPA\'s six pillars form the foundation of our mission: Promote, Inspire, Events, Partnerships, Employment, and Innovation.', 'tags' => array('Community', 'Innovation')),
                array('title' => 'PropTech Asia Summit', 'type' => 'Regional Conference', 'description' => 'Leading PropTech conference in Asia, bringing together industry leaders, investors, and innovators from across the region.', 'tags' => array('Asia Pacific', 'Investment')),
                array('title' => 'Student PropTech Workshop', 'type' => 'Educational Event', 'description' => 'Hands-on workshop for students and fresh graduates interested in PropTech careers and entrepreneurship.', 'tags' => array('Education', 'Students'))
            );
            
            foreach ($fallback_events as $index => $event) :
                $featured_class = ($index === 0) ? ' featured' : '';
                ?>
                <div class="showcase-card<?php echo $featured_class; ?>">
                    <div class="member-avatar">
                        <div class="avatar-ring"></div>
                        <i class="fas fa-<?php echo ($index === 0) ? 'users' : (($index === 1) ? 'globe' : 'graduation-cap'); ?>"></i>
                    </div>
                    <h3><?php echo esc_html($event['title']); ?></h3>
                    <p class="member-role"><?php echo esc_html($event['type']); ?></p>
                    <p class="member-bio"><?php echo esc_html($event['description']); ?></p>
                    <div class="member-projects">
                        <?php foreach ($event['tags'] as $tag) : ?>
                            <span class="project-tag"><?php echo esc_html($tag); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach;
        endif; ?>
    </div>
</section>

<!-- News Section -->
<section id="news" class="future">
    <div class="future-container">
        <div class="future-header">
            <h2 class="future-title"><?php esc_html_e('Latest News', 'mpa-theme'); ?></h2>
            <p class="future-subtitle"><?php esc_html_e('Stay updated with the latest PropTech developments and MPA activities', 'mpa-theme'); ?></p>
        </div>
        
        <div class="timeline">
            <?php
            $news_posts = get_posts(array(
                'post_type' => 'news',
                'posts_per_page' => 4,
                'orderby' => 'date',
                'order' => 'DESC'
            ));
            
            if ($news_posts) :
                foreach ($news_posts as $index => $post) :
                    $icon_class = 'fas fa-newspaper';
                    if ($index === 1) $icon_class = 'fas fa-building';
                    elseif ($index === 2) $icon_class = 'fas fa-users';
                    elseif ($index === 3) $icon_class = 'fas fa-chart-line';
                    ?>
                    <div class="timeline-item">
                        <div class="timeline-marker">
                            <i class="<?php echo $icon_class; ?>"></i>
                        </div>
                        <div class="timeline-content">
                            <h3><?php echo esc_html($post->post_title); ?></h3>
                            <p><?php echo esc_html($post->post_excerpt); ?></p>
                            <div class="timeline-progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                    <?php
                endforeach;
            else :
                // Fallback news
                $fallback_news = array(
                    array('title' => '35 Years of PropTech: Fostering A Bright Start To PropTech 4.0', 'content' => 'Exploring the evolution of PropTech and its impact on the USD 9.6 trillion real estate market, focusing on professionally managed properties.', 'icon' => 'fas fa-newspaper'),
                    array('title' => 'ProperLy Asia Sdn Bhd - Equity Crowd Funding', 'content' => 'MPA member company making waves in equity crowd funding for property technology solutions.', 'icon' => 'fas fa-building'),
                    array('title' => 'MPA New Committee Members 2021-2023', 'content' => 'Announcing new committee members who will drive MPA\'s mission forward with fresh perspectives and expertise.', 'icon' => 'fas fa-users'),
                    array('title' => 'PropTech is Shaping the Real Estate Industry in Asia', 'content' => 'How PropTech innovations are transforming the real estate landscape across Asia and creating new opportunities.', 'icon' => 'fas fa-chart-line')
                );
                
                foreach ($fallback_news as $news) : ?>
                    <div class="timeline-item">
                        <div class="timeline-marker">
                            <i class="<?php echo esc_attr($news['icon']); ?>"></i>
                        </div>
                        <div class="timeline-content">
                            <h3><?php echo esc_html($news['title']); ?></h3>
                            <p><?php echo esc_html($news['content']); ?></p>
                            <div class="timeline-progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</section>

<!-- Creative CTA Section -->
<section class="cta-creative">
    <div class="cta-container">
        <div class="cta-content">
            <h2 class="cta-title"><?php esc_html_e('Join MPA Today!', 'mpa-theme'); ?></h2>
            <p class="cta-text">
                <?php echo get_theme_mod('cta_text', 'Let\'s work together for a better future of the PropTech industry in Malaysia. Become part of our growing community of innovators, entrepreneurs, and industry leaders.'); ?>
            </p>
            <div class="cta-actions">
                <a href="<?php echo get_permalink(get_page_by_path('membership')); ?>" class="cta-btn primary">
                    <i class="fas fa-rocket"></i>
                    <span><?php esc_html_e('Join MPA', 'mpa-theme'); ?></span>
                </a>
                <a href="<?php echo get_permalink(get_page_by_path('contact')); ?>" class="cta-btn secondary">
                    <i class="fas fa-comments"></i>
                    <span><?php esc_html_e('Contact Us', 'mpa-theme'); ?></span>
                </a>
            </div>
        </div>
        
        <div class="cta-visual">
            <div class="particle-field">
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="ecosystem">
    <div class="section-header">
        <h2 class="section-title"><?php esc_html_e('Contact Information', 'mpa-theme'); ?></h2>
        <p class="section-subtitle"><?php esc_html_e('Get in touch with the Malaysia PropTech Association', 'mpa-theme'); ?></p>
    </div>
    
    <div class="ecosystem-grid">
        <div class="ecosystem-card">
            <div class="card-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <h3><?php esc_html_e('Email', 'mpa-theme'); ?></h3>
            <p><?php echo get_theme_mod('contact_email_general', 'General Inquiries: info@proptech.org.my'); ?></p>
            <div class="card-stats">
                <span><?php echo get_theme_mod('contact_email_secretariat', 'secretariat@proptech.org.my'); ?></span>
                <span><?php echo get_theme_mod('contact_email_membership', 'membership@proptech.org.my'); ?></span>
            </div>
        </div>
        
        <div class="ecosystem-card">
            <div class="card-icon">
                <i class="fas fa-phone"></i>
            </div>
            <h3><?php esc_html_e('Phone', 'mpa-theme'); ?></h3>
            <p><?php esc_html_e('Contact us for membership and partnership inquiries', 'mpa-theme'); ?></p>
            <div class="card-stats">
                <span><?php echo get_theme_mod('contact_phone', '011 322 44 56'); ?></span>
                <span><?php esc_html_e('Available Mon-Fri', 'mpa-theme'); ?></span>
            </div>
        </div>
        
        <div class="ecosystem-card">
            <div class="card-icon">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <h3><?php esc_html_e('Address', 'mpa-theme'); ?></h3>
            <p><?php echo get_theme_mod('contact_company_name', 'PERSATUAN TEKNOLOGI HARTANAH MALAYSIA (MALAYSIA PROPTECH ASSOCIATION)'); ?></p>
            <div class="card-stats">
                <span><?php echo get_theme_mod('contact_address_line1', '53A, Jalan Kenari 21'); ?></span>
                <span><?php echo get_theme_mod('contact_address_line2', 'Bandar Puchong Jaya, 47100 Puchong'); ?></span>
            </div>
        </div>
        
        <div class="ecosystem-card">
            <div class="card-icon">
                <i class="fas fa-globe"></i>
            </div>
            <h3><?php esc_html_e('Social Media', 'mpa-theme'); ?></h3>
            <p><?php esc_html_e('Follow us for the latest updates and industry insights', 'mpa-theme'); ?></p>
            <div class="card-stats">
                <span><?php esc_html_e('Facebook', 'mpa-theme'); ?></span>
                <span><?php esc_html_e('LinkedIn', 'mpa-theme'); ?></span>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
?>

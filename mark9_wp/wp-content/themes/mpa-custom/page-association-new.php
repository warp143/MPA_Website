<?php get_header(); ?>

<!-- Set custom page title -->
<script>
document.title = 'Association |';
</script>

<!-- Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="hero-content">
            <h1>About MPA</h1>
            <p>Driving Malaysia's PropTech transformation through innovation, collaboration, and strategic leadership</p>
        </div>
        <div class="hero-image">
                            <img src="<?php echo get_template_directory_uri(); ?>assets/association-hero.jpg" alt="MPA Association">
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section">
    <div class="container">
        <div class="about-content">
            <div class="about-left">
                <div class="about-text">
                    <h2>Who We Are</h2>
                    <p>The Malaysia PropTech Association (MPA) is the nation's leading organization dedicated to advancing property technology innovation. We bring together industry leaders, startups, investors, and technology providers to shape the future of Malaysia's real estate landscape.</p>
                    
                    <h3>Our Mission</h3>
                    <p>To accelerate the adoption of PropTech solutions across Malaysia's property ecosystem, fostering innovation, collaboration, and sustainable growth that benefits all stakeholders.</p>
                    
                    <h3>Our Vision</h3>
                    <p>To position Malaysia as the leading PropTech hub in Southeast Asia, where technology transforms how we buy, sell, rent, manage, and invest in property.</p>
                </div>
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

<!-- MPA Pillars -->
<section class="mpa-pillars">
    <div class="container" id="mpa-pillars-component">
        <!-- Component will be loaded here -->
    </div>
</section>

<!-- Committee -->
<section class="committee">
    <div class="container">
        <div class="section-header">
            <h2>Our Committee</h2>
            <p>Meet the leadership team driving Malaysia's PropTech transformation (2025-2026 Term)</p>
        </div>
        <div class="committee-grid">
            <?php
            // Query for active committee members
            $committee_query = new WP_Query(array(
                'post_type' => 'mpa_committee',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'meta_query' => array(
                    array(
                        'key' => '_member_status',
                        'value' => 'active',
                        'compare' => '='
                    ),
                    array(
                        'key' => '_member_term',
                        'value' => '2025-2026',
                        'compare' => '='
                    )
                ),
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ));

            if ($committee_query->have_posts()) :
                while ($committee_query->have_posts()) : $committee_query->the_post();
                    // Get member meta data
                    $member_position = get_post_meta(get_the_ID(), '_member_position', true);
                    $member_website = get_post_meta(get_the_ID(), '_member_website', true);
                    $member_website_secondary = get_post_meta(get_the_ID(), '_member_website_secondary', true);
                    $member_email = get_post_meta(get_the_ID(), '_member_email', true);
                    $member_email_secondary = get_post_meta(get_the_ID(), '_member_email_secondary', true);
                    $member_linkedin = get_post_meta(get_the_ID(), '_member_linkedin', true);
                    $member_linkedin_secondary = get_post_meta(get_the_ID(), '_member_linkedin_secondary', true);
                    
                    // Get member photo
                    $member_photo = '';
                    if (has_post_thumbnail()) {
                        $member_photo = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                    }
                    
                    // Get member bio/responsibilities from content
                    $member_bio = get_the_content();
                    
                    // Convert bio content to bullet points if it contains line breaks
                    $bio_lines = array_filter(explode("\n", strip_tags($member_bio)));
                    ?>
                    
                    <div class="committee-member">
                        <?php if ($member_photo) : ?>
                            <img src="<?php echo esc_url($member_photo); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                        <?php endif; ?>
                        
                        <h3><?php the_title(); ?></h3>
                        
                        <?php if ($member_position) : ?>
                            <p class="position"><?php echo esc_html($member_position); ?></p>
                        <?php endif; ?>
                        
                        <?php if (!empty($bio_lines)) : ?>
                            <div class="position-description">
                                <?php foreach ($bio_lines as $line) : ?>
                                    <p><?php echo esc_html(trim($line)); ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="member-contact">
                            <?php if ($member_website) : ?>
                                <a href="<?php echo esc_url($member_website); ?>" class="contact-link" title="Website" target="_blank"><i class="fas fa-globe"></i></a>
                            <?php endif; ?>
                            
                            <?php if ($member_website_secondary) : ?>
                                <a href="<?php echo esc_url($member_website_secondary); ?>" class="contact-link" title="Website" target="_blank"><i class="fas fa-globe"></i></a>
                            <?php endif; ?>
                            
                            <?php if ($member_email) : ?>
                                <a href="mailto:<?php echo esc_attr($member_email); ?>" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <?php endif; ?>
                            
                            <?php if ($member_email_secondary) : ?>
                                <a href="mailto:<?php echo esc_attr($member_email_secondary); ?>" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <?php endif; ?>
                            
                            <?php if ($member_linkedin) : ?>
                                <a href="<?php echo esc_url($member_linkedin); ?>" class="contact-link" title="LinkedIn" target="_blank"><i class="fas fa-linkedin"></i></a>
                            <?php endif; ?>
                            
                            <?php if ($member_linkedin_secondary) : ?>
                                <a href="<?php echo esc_url($member_linkedin_secondary); ?>" class="contact-link" title="LinkedIn" target="_blank"><i class="fas fa-linkedin"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                <?php endwhile;
                wp_reset_postdata();
            else : ?>
                <div class="committee-member">
                    <p><?php _e('No committee members found. Please add some in the WordPress admin.', 'mpa-custom'); ?></p>
                </div>
            <?php endif; ?>
        </div>
        <div class="text-center" style="margin-top: var(--spacing-xxl);">
            <a href="<?php echo esc_url(home_url('/old-members/')); ?>" class="btn-primary">View Previous Committee Members (2021-2023)</a>
        </div>
    </div>
</section>

<!-- Cookie Consent Banner -->
<div class="cookie-banner" id="cookieBanner">
    <div class="cookie-content">
        <div class="cookie-text">
            <h4>We use cookies</h4>
            <p>We use cookies to enhance your browsing experience and analyze our traffic. By clicking "Accept All", you consent to our use of cookies.</p>
        </div>
        <div class="cookie-actions">
            <button class="cookie-btn cookie-accept" onclick="acceptCookies()">Accept All</button>
            <button class="cookie-btn cookie-decline" onclick="declineCookies()">Decline</button>
        </div>
    </div>
</div>

<script src="scripts/header-loader.js"></script>
<script src="js/components.js"></script>
<script src="scripts/footer-loader.js"></script>

<?php get_footer(); ?>

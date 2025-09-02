<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <link rel="icon" type="image/svg+xml" href="<?php echo get_template_directory_uri(); ?>/favicon.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <!-- Header -->
    <header class="site-header">
        <div class="container">
            <div class="header-content">
                <div class="site-logo">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-title">
                        <?php bloginfo('name'); ?>
                    </a>
                </div>
                
                <nav class="main-navigation">
                    <a href="<?php echo esc_url(home_url('/proptech/')); ?>" class="nav-link">Proptech</a>
                    <a href="<?php echo esc_url(home_url('/association/')); ?>" class="nav-link">Association</a>
                    <a href="<?php echo esc_url(home_url('/members/')); ?>" class="nav-link">Members</a>
                    <a href="<?php echo esc_url(home_url('/events/')); ?>" class="nav-link">Events</a>
                    <a href="<?php echo esc_url(home_url('/news-resources/')); ?>" class="nav-link">News & Resources</a>
                    <a href="<?php echo esc_url(home_url('/partners/')); ?>" class="nav-link">Partners</a>
                </nav>
                
                <div class="header-actions">
                    <a href="<?php echo esc_url(home_url('/signin/')); ?>" class="btn btn-secondary">Sign In</a>
                    <a href="<?php echo esc_url(home_url('/membership/')); ?>" class="btn btn-primary">Join MPA</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main id="main" class="site-main">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                
                <!-- Hero Section -->
                <section class="hero-section">
                    <div class="container">
                        <div class="hero-content">
                            <h1 class="hero-title">Malaysia Proptech Association</h1>
                            <p class="hero-subtitle">Leading The Digital Transformation of the Property Industry in Malaysia</p>
                            
                            <!-- Search Box -->
                            <div class="search-container">
                                <div class="search-box">
                                    <input type="text" class="search-input" placeholder="Find events, members, or resources...">
                                    <button class="search-button">Search</button>
                                </div>
                            </div>
                            
                            <!-- Stats -->
                            <div class="stats-section">
                                <div class="stat-item">
                                    <span class="stat-number">150+</span>
                                    <span class="stat-label">Members</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number">50+</span>
                                    <span class="stat-label">Events</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number">90+</span>
                                    <span class="stat-label">Startups</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number">15+</span>
                                    <span class="stat-label">Partners</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- About Section -->
                <section class="about-section">
                    <div class="container">
                        <div class="about-content">
                            <div class="about-text">
                                <h2>For The Future of A Sustainable Property Market</h2>
                                <p class="highlight-text">Malaysia Proptech Association Leads The Digital Transformation of the Built Environment in Malaysia and beyond, through innovation, collaboration, and sustainable growth. Building a strong community with integrity, inclusivity, and equality.</p>
                                
                                <p>The Malaysia PropTech Association (MPA) is the driving force behind Malaysia's digital transformation in the built environment. We unite startups, scale-ups, corporates, investors, and government stakeholders to shape a smarter, more inclusive property ecosystem.</p>
                                
                                <p>Our mission is to accelerate innovation, foster collaboration, and empower a new generation of tech-driven leaders in the built environment!</p>
                                
                                <p>We believe that transformation must be rooted in integrity, inclusivity, and shared progress.</p>
                                
                                <p class="highlight-text">Together, we're building the built environment of the future!</p>
                            </div>
                            
                            <div class="about-features">
                                <p class="strategic-anchors">MPA's work is guided by five Strategic Anchors, the pillars that define our purpose and drive our outcomes!</p>
                                
                                <div class="features-grid">
                                    <div class="feature-item">
                                        <i class="fas fa-users feature-icon"></i>
                                        <div class="feature-content">
                                            <h4>Community</h4>
                                            <p>Connect with 150+ PropTech professionals</p>
                                        </div>
                                    </div>
                                    
                                    <div class="feature-item">
                                        <i class="fas fa-lightbulb feature-icon"></i>
                                        <div class="feature-content">
                                            <h4>Innovation</h4>
                                            <p>Drive cutting-edge PropTech solutions</p>
                                        </div>
                                    </div>
                                    
                                    <div class="feature-item">
                                        <i class="fas fa-globe feature-icon"></i>
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

                <!-- Page Content -->
                <section class="page-content">
                    <div class="container">
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <header class="entry-header">
                                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                            </header>

                            <div class="entry-content">
                                <?php the_content(); ?>
                            </div>
                        </article>
                    </div>
                </section>

            <?php endwhile; ?>
        <?php else : ?>
            <section class="no-content">
                <div class="container">
                    <h1>No content found</h1>
                    <p>Sorry, no content was found.</p>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Malaysia Proptech Association</h3>
                    <p>Leading the digital transformation of the property industry in Malaysia through innovation, collaboration, and sustainable growth.</p>
                </div>
                
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <p><a href="<?php echo esc_url(home_url('/proptech/')); ?>">Proptech</a></p>
                    <p><a href="<?php echo esc_url(home_url('/members/')); ?>">Members</a></p>
                    <p><a href="<?php echo esc_url(home_url('/events/')); ?>">Events</a></p>
                    <p><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a></p>
                </div>
                
                <div class="footer-section">
                    <h3>Connect</h3>
                    <p><a href="mailto:info@mpa.org.my">info@mpa.org.my</a></p>
                    <p>Follow us on social media</p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Malaysia Proptech Association. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>

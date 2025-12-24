<?php get_header(); ?>

<main id="main" class="site-main">
    <?php while (have_posts()) : the_post(); ?>
        
        <!-- Page Hero Section -->
        <section class="page-hero">
            <div class="container">
                <div class="hero-content">
                    <h1><?php the_title(); ?></h1>
                    <!-- Subtitle removed as part of static migration -->
                </div>
                <?php if (has_post_thumbnail()): ?>
                    <div class="hero-image">
                        <?php the_post_thumbnail('large', ['alt' => get_the_title()]); ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Page Content -->
        <section class="page-content">
            <div class="container">
                <div class="content-wrapper">
                    <?php the_content(); ?>
                </div>
            </div>
        </section>

        <!-- Optional Call to Action -->
        <!-- Optional Call to Action -->
        <section class="page-cta">
            <div class="container">
                <div class="cta-content">
                    <h2>Join Our Community</h2>
                    <p>Be part of Malaysia's growing PropTech ecosystem.</p>
                    <div class="cta-buttons">
                        <a href="<?php echo esc_url(home_url('/join/')); ?>" class="btn-primary">
                            Become a Member
                        </a>
                        <a href="<?php echo esc_url(home_url('/events/')); ?>" class="btn-outline">
                            Attend Events
                        </a>
                    </div>
                </div>
            </div>
        </section>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>

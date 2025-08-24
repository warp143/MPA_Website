<?php
/**
 * The template for displaying events archive
 *
 * @package MPA_Theme
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <header class="page-header">
            <h1 class="page-title"><?php esc_html_e('Events', 'mpa-theme'); ?></h1>
            <div class="archive-description">
                <p><?php esc_html_e('Join us for inspiring events that shape the future of PropTech', 'mpa-theme'); ?></p>
            </div>
        </header>

        <?php if (have_posts()) : ?>
            <div class="events-grid">
                <?php
                while (have_posts()) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('event-card'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="event-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('event-thumbnail'); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="event-content">
                            <header class="event-header">
                                <h2 class="event-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                
                                <?php
                                $event_date = get_field('event_date');
                                $event_time = get_field('event_time');
                                $event_location = get_field('event_location');
                                $event_type = get_field('event_type');
                                ?>
                                
                                <div class="event-meta">
                                    <?php if ($event_date) : ?>
                                        <span class="event-date">
                                            <i class="fas fa-calendar"></i>
                                            <?php echo date('F j, Y', strtotime($event_date)); ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <?php if ($event_time) : ?>
                                        <span class="event-time">
                                            <i class="fas fa-clock"></i>
                                            <?php echo esc_html($event_time); ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <?php if ($event_location) : ?>
                                        <span class="event-location">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <?php echo esc_html($event_location); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </header>

                            <div class="event-excerpt">
                                <?php the_excerpt(); ?>
                            </div>

                            <div class="event-footer">
                                <?php if ($event_type) : ?>
                                    <span class="event-type"><?php echo esc_html(ucfirst($event_type)); ?></span>
                                <?php endif; ?>
                                
                                <a href="<?php the_permalink(); ?>" class="event-link">
                                    <?php esc_html_e('Learn More', 'mpa-theme'); ?>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                    <?php
                endwhile;
                ?>
            </div>

            <?php
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => '<i class="fas fa-chevron-left"></i> ' . __('Previous', 'mpa-theme'),
                'next_text' => __('Next', 'mpa-theme') . ' <i class="fas fa-chevron-right"></i>',
            ));
            ?>

        <?php else : ?>
            <div class="no-events">
                <h2><?php esc_html_e('No Events Found', 'mpa-theme'); ?></h2>
                <p><?php esc_html_e('There are currently no upcoming events. Please check back later.', 'mpa-theme'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</main>

<style>
.container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem;
}

.page-header {
    text-align: center;
    margin-bottom: 3rem;
}

.page-title {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1rem;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.archive-description {
    font-size: 1.2rem;
    color: var(--text-secondary);
}

.events-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.event-card {
    background: var(--bg-primary);
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: 
        var(--shadow-offset) var(--shadow-offset) var(--shadow-blur) var(--shadow-dark),
        calc(-1 * var(--shadow-offset)) calc(-1 * var(--shadow-offset)) var(--shadow-blur) var(--shadow-light);
    transition: transform 0.3s ease;
}

.event-card:hover {
    transform: translateY(-5px);
}

.event-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.event-content {
    padding: 1.5rem;
}

.event-title {
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.event-title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: color 0.3s ease;
}

.event-title a:hover {
    color: var(--accent-primary);
}

.event-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1rem;
    font-size: 0.9rem;
    color: var(--text-secondary);
}

.event-meta span {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.event-excerpt {
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.event-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.event-type {
    padding: 0.3rem 0.8rem;
    background: var(--accent-primary);
    color: white;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 500;
}

.event-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--accent-primary);
    text-decoration: none;
    font-weight: 600;
    transition: gap 0.3s ease;
}

.event-link:hover {
    gap: 0.8rem;
}

.no-events {
    text-align: center;
    padding: 3rem;
}

.no-events h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.no-events p {
    color: var(--text-secondary);
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .events-grid {
        grid-template-columns: 1fr;
    }
    
    .event-meta {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .event-footer {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
}
</style>

<?php
get_footer();
?>

<?php get_header(); ?>

<style>
.member-single {
    padding: 120px 0 60px 0;
    min-height: 70vh;
}

.member-single .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.member-header {
    display: flex;
    gap: 40px;
    margin-bottom: 50px;
    align-items: flex-start;
}

.member-logo-container {
    flex-shrink: 0;
}

.member-logo-container img {
    width: 200px;
    height: 200px;
    object-fit: contain;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 20px;
    background: white;
}

.member-details {
    flex: 1;
}

.member-details h1 {
    margin: 0 0 20px 0;
    font-size: 2.5rem;
    color: #1a73e8;
}

.featured-badge {
    display: inline-block;
    background: #e53935;
    color: white;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 15px;
}

.member-meta {
    margin: 15px 0;
    font-size: 1.1rem;
}

.member-meta strong {
    color: #333;
}

.specialty-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin: 15px 0;
}

.specialty-tag {
    background: #1a73e8;
    color: white;
    padding: 6px 14px;
    border-radius: 16px;
    font-size: 0.9rem;
}

.website-btn {
    display: inline-block;
    background: #1a73e8;
    color: white;
    padding: 12px 24px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    margin-top: 20px;
    transition: background 0.3s;
}

.website-btn:hover {
    background: #1557b0;
}

.member-section {
    margin: 50px 0;
    padding-top: 40px;
    border-top: 2px solid #e0e0e0;
}

.member-section h2 {
    font-size: 2rem;
    color: #1a73e8;
    margin-bottom: 20px;
}

.member-description {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
}

.contact-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.contact-card {
    background: #f8f9fa;
    padding: 24px;
    border-radius: 8px;
    border-left: 4px solid #1a73e8;
}

.contact-card-title {
    display: block;
    color: #1a73e8;
    font-weight: 700;
    font-size: 1rem;
    margin-bottom: 8px;
}

.contact-card-value {
    font-size: 1.05rem;
    color: #333;
    word-wrap: break-word;
}

.contact-card-value a {
    color: #333;
    text-decoration: none;
}

.contact-card-value a:hover {
    color: #1a73e8;
}

.back-button {
    display: inline-block;
    margin-top: 40px;
    padding: 12px 24px;
    border: 2px solid #1a73e8;
    border-radius: 6px;
    color: #1a73e8;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.back-button:hover {
    background: #1a73e8;
    color: white;
}

@media (max-width: 768px) {
    .member-header {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .member-logo-container img {
        width: 150px;
        height: 150px;
    }
    
    .member-details h1 {
        font-size: 2rem;
    }
}
</style>

<section class="member-single">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <?php
            $website = get_post_meta(get_the_ID(), '_member_website', true);
            $vertical = get_post_meta(get_the_ID(), '_member_vertical', true);
            $categories = get_post_meta(get_the_ID(), '_member_categories', true);
            $contact_name = get_post_meta(get_the_ID(), '_contact_name', true);
            $contact_email = get_post_meta(get_the_ID(), '_contact_email', true);
            $contact_phone = get_post_meta(get_the_ID(), '_contact_phone', true);
            $is_featured = get_post_meta(get_the_ID(), '_member_featured', true);
            ?>
            
            <div class="member-header">
                <div class="member-logo-container">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('medium'); ?>
                    <?php else : ?>
                        <div style="width: 200px; height: 200px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                            <span style="font-size: 60px; color: #ccc;">👤</span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="member-details">
                    <h1><?php the_title(); ?></h1>
                    
                    <?php if ($is_featured == '1') : ?>
                        <div class="featured-badge">⭐ Featured Member</div>
                    <?php endif; ?>
                    
                    <?php if ($vertical) : ?>
                        <div class="member-meta">
                            <strong>Focus Area:</strong> <?php echo esc_html($vertical); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($categories) : ?>
                        <div class="member-meta"><strong>Specialties:</strong></div>
                        <div class="specialty-tags">
                            <?php
                            $cats = explode(',', $categories);
                            foreach ($cats as $cat) {
                                echo '<span class="specialty-tag">' . esc_html(trim($cat)) . '</span>';
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($website) : ?>
                        <a href="<?php echo esc_url($website); ?>" target="_blank" class="website-btn">🌐 Visit Website</a>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if (get_the_content()) : ?>
                <div class="member-section">
                    <h2>About <?php the_title(); ?></h2>
                    <div class="member-description">
                        <?php the_content(); ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($contact_name || $contact_email || $contact_phone) : ?>
                <div class="member-section">
                    <h2>Contact Details</h2>
                    <div class="contact-cards">
                        <?php if ($contact_name) : ?>
                            <div class="contact-card">
                                <span class="contact-card-title">👤 Contact Person</span>
                                <div class="contact-card-value"><?php echo esc_html($contact_name); ?></div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($contact_email) : ?>
                            <div class="contact-card">
                                <span class="contact-card-title">📧 Email</span>
                                <div class="contact-card-value">
                                    <a href="mailto:<?php echo esc_attr($contact_email); ?>"><?php echo esc_html($contact_email); ?></a>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($contact_phone) : ?>
                            <div class="contact-card">
                                <span class="contact-card-title">📱 Phone</span>
                                <div class="contact-card-value">
                                    <a href="tel:<?php echo esc_attr($contact_phone); ?>"><?php echo esc_html($contact_phone); ?></a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <div style="text-align: center;">
                <a href="<?php echo esc_url(home_url('/members/')); ?>" class="back-button">← Back to Members</a>
            </div>
            
        <?php endwhile; ?>
    </div>
</section>

<?php get_footer(); ?>


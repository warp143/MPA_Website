    </div><!-- #content -->

    <!-- Creative Footer -->
    <footer class="footer-creative">
        <div class="footer-container">
            <div class="footer-brand">
                <div class="footer-logo">
                    <?php
                    $custom_logo_id = get_theme_mod('custom_logo');
                    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                    if ($logo) {
                        echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" class="footer-logo-img">';
                    } else {
                        echo '<img src="' . get_template_directory_uri() . '/assets/mpa-logo.png" alt="' . get_bloginfo('name') . '" class="footer-logo-img">';
                    }
                    ?>
                    <span><?php bloginfo('name'); ?></span>
                </div>
                <p><?php bloginfo('description'); ?></p>
            </div>
            
            <div class="footer-links">
                <div class="link-group">
                    <h4><?php esc_html_e('Quick Links', 'mpa-theme'); ?></h4>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_class' => 'footer-menu',
                        'container' => false,
                        'fallback_cb' => false,
                    ));
                    ?>
                </div>
                
                <div class="link-group">
                    <h4><?php esc_html_e('Connect', 'mpa-theme'); ?></h4>
                    <?php
                    $social_links = array(
                        'facebook' => get_theme_mod('social_facebook'),
                        'linkedin' => get_theme_mod('social_linkedin'),
                        'instagram' => get_theme_mod('social_instagram'),
                        'youtube' => get_theme_mod('social_youtube'),
                    );
                    
                    foreach ($social_links as $platform => $url) {
                        if ($url) {
                            $icon_class = 'fab fa-' . $platform;
                            $platform_name = ucfirst($platform);
                            echo '<a href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer"><i class="' . $icon_class . '"></i> ' . $platform_name . '</a>';
                        }
                    }
                    ?>
                </div>
                
                <div class="link-group">
                    <h4><?php esc_html_e('Resources', 'mpa-theme'); ?></h4>
                    <a href="<?php echo get_post_type_archive_link('committee_members'); ?>"><?php esc_html_e('Members Directory', 'mpa-theme'); ?></a>
                    <a href="<?php echo get_permalink(get_page_by_path('partners')); ?>"><?php esc_html_e('Partners', 'mpa-theme'); ?></a>
                    <a href="<?php echo get_permalink(get_page_by_path('investors')); ?>"><?php esc_html_e('Investors', 'mpa-theme'); ?></a>
                    <a href="<?php echo get_permalink(get_page_by_path('about')); ?>"><?php esc_html_e('Mission & Vision', 'mpa-theme'); ?></a>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('All rights reserved.', 'mpa-theme'); ?></p>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

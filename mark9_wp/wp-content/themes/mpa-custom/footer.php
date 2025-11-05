    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>MPA</h3>
                    <p>Malaysia's leading PropTech community driving innovation in real estate technology.</p>
                    <div class="social-links">
                        <?php if (get_option('mpa_linkedin_url')): ?>
                            <a href="<?php echo esc_url(get_option('mpa_linkedin_url')); ?>" target="_blank"><i class="fab fa-linkedin"></i></a>
                        <?php endif; ?>
                        <?php if (get_option('mpa_facebook_url')): ?>
                            <a href="<?php echo esc_url(get_option('mpa_facebook_url')); ?>" target="_blank"><i class="fab fa-facebook"></i></a>
                        <?php endif; ?>
                        <?php if (get_option('mpa_youtube_url')): ?>
                            <a href="<?php echo esc_url(get_option('mpa_youtube_url')); ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                        <?php endif; ?>
                        <?php if (get_option('mpa_instagram_url')): ?>
                            <a href="<?php echo esc_url(get_option('mpa_instagram_url')); ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                        <?php endif; ?>
                        <?php if (get_option('mpa_twitter_url')): ?>
                            <a href="<?php echo esc_url(get_option('mpa_twitter_url')); ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/association/')); ?>">Association</a></li>
                        <li><a href="<?php echo esc_url(home_url('/membership/')); ?>">Membership</a></li>
                        <li><a href="<?php echo esc_url(home_url('/events/')); ?>">Events</a></li>
                        <li><a href="<?php echo esc_url(home_url('/news/')); ?>">News</a></li>
                        <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contact</h4>
                    <ul>
                        <?php if (get_option('mpa_contact_email')): ?>
                            <li><i class="fas fa-envelope"></i> <a href="mailto:<?php echo esc_attr(get_option('mpa_contact_email')); ?>"><?php echo esc_html(get_option('mpa_contact_email')); ?></a></li>
                        <?php endif; ?>
                        <?php if (get_option('mpa_contact_phone')): ?>
                            <li><i class="fas fa-phone"></i> <a href="tel:<?php echo esc_attr(str_replace(' ', '', get_option('mpa_contact_phone'))); ?>"><?php echo esc_html(get_option('mpa_contact_phone')); ?></a></li>
                        <?php endif; ?>
                        <?php if (get_option('mpa_contact_address')): ?>
                            <li><i class="fas fa-map-marker-alt"></i> <?php echo esc_html(get_option('mpa_contact_address')); ?></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Malaysia PropTech Association. All rights reserved.</p>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

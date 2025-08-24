<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'mpa-theme'); ?></a>

    <!-- Creative Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <div class="brand-logo">
                    <?php
                    $custom_logo_id = get_theme_mod('custom_logo');
                    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                    if ($logo) {
                        echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" class="nav-logo-img">';
                    } else {
                        echo '<img src="' . get_template_directory_uri() . '/assets/mpa-logo.png" alt="' . get_bloginfo('name') . '" class="nav-logo-img">';
                    }
                    ?>
                    <span class="brand-text"><?php bloginfo('name'); ?></span>
                </div>
            </div>
            
            <div class="nav-links">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class' => 'nav-menu',
                    'container' => false,
                    'fallback_cb' => 'mpa_fallback_menu',
                    'items_wrap' => '%3$s',
                    'walker' => new MPA_Nav_Walker(),
                ));
                ?>
            </div>
            
            <div class="nav-actions">
                <?php if (!is_user_logged_in()) : ?>
                    <a href="<?php echo wp_login_url(); ?>" class="action-btn secondary">
                        <i class="fas fa-sign-in-alt"></i>
                        <span><?php esc_html_e('Sign In', 'mpa-theme'); ?></span>
                    </a>
                <?php else : ?>
                    <a href="<?php echo admin_url(); ?>" class="action-btn secondary">
                        <i class="fas fa-user"></i>
                        <span><?php esc_html_e('Dashboard', 'mpa-theme'); ?></span>
                    </a>
                <?php endif; ?>
                
                <a href="<?php echo get_permalink(get_page_by_path('membership')); ?>" class="action-btn primary">
                    <i class="fas fa-plus"></i>
                    <span><?php esc_html_e('Join MPA', 'mpa-theme'); ?></span>
                </a>
            </div>
            
            <button class="mobile-toggle" aria-label="<?php esc_attr_e('Toggle navigation menu', 'mpa-theme'); ?>">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <div id="content" class="site-content">

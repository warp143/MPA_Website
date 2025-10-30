<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="<?php echo get_template_directory_uri(); ?>/favicon.svg">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css?v=1759336596">
    <!-- Load fonts asynchronously to prevent blocking -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    
    <!-- Load Font Awesome asynchronously -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" media="print" onload="this.media='all'">
    
    <!-- Fallback for browsers without JavaScript -->
    <noscript>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </noscript>
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/mpa-logo.png" alt="Malaysia PropTech Association" class="logo-img">
                </a>
            </div>
            <div class="nav-menu" id="nav-menu">
                <a href="<?php echo esc_url(home_url('/proptech/')); ?>" class="nav-link">PropTech</a>
                <a href="<?php echo esc_url(home_url('/association/')); ?>" class="nav-link">Association</a>
                <a href="<?php echo esc_url(home_url('/members/')); ?>" class="nav-link">Members</a>
                <a href="<?php echo esc_url(home_url('/events/')); ?>" class="nav-link">Events</a>
                <a href="<?php echo esc_url(home_url('/news/')); ?>" class="nav-link">News & Resource</a>
                <a href="<?php echo esc_url(home_url('/partners/')); ?>" class="nav-link">Partners</a>
            </div>
            <div class="nav-actions">
                <button class="theme-toggle" id="themeToggle">
                    <span class="theme-icon">🌙</span>
                    <span class="auto-indicator" id="autoIndicator" title="Auto mode active">🔄</span>
                </button>
                <div class="language-dropdown">
                    <button class="language-toggle" id="languageToggle">
                        <span class="current-language">EN</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="language-menu" id="languageMenu">
                        <button class="language-option" data-lang="en">
                            <span class="flag">🇺🇸</span>
                            <span>English</span>
                        </button>
                        <button class="language-option" data-lang="bm">
                            <span class="flag">🇲🇾</span>
                            <span>Bahasa Malaysia</span>
                        </button>
                        <button class="language-option" data-lang="cn">
                            <span class="flag">🇨🇳</span>
                            <span>中文</span>
                        </button>
                    </div>
                </div>
                <a href="<?php echo esc_url(home_url('/signin/')); ?>" class="btn-secondary desktop-only" data-translate="btn-signin">Sign In</a>
                <a href="http://118.107.202.35/Register/RegisterPage" class="btn-primary desktop-only" data-translate="btn-join">Join MPA</a>
                <button class="mobile-menu-toggle hamburger" id="mobileMenuToggle" aria-label="Toggle mobile menu">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Dropdown Menu -->
    <div class="mobile-dropdown-menu" id="mobileDropdownMenu">
        <nav class="mobile-dropdown-nav">
            <a href="<?php echo esc_url(home_url('/proptech/')); ?>" class="mobile-dropdown-link">
                <i class="fas fa-microchip"></i>
                <span>PropTech</span>
            </a>
            <a href="<?php echo esc_url(home_url('/association/')); ?>" class="mobile-dropdown-link">
                <i class="fas fa-info-circle"></i>
                <span>Association</span>
            </a>
            <a href="<?php echo esc_url(home_url('/members/')); ?>" class="mobile-dropdown-link">
                <i class="fas fa-users"></i>
                <span>Members</span>
            </a>
            <a href="<?php echo esc_url(home_url('/events/')); ?>" class="mobile-dropdown-link">
                <i class="fas fa-calendar-alt"></i>
                <span>Events</span>
            </a>
            <a href="<?php echo esc_url(home_url('/news/')); ?>" class="mobile-dropdown-link">
                <i class="fas fa-newspaper"></i>
                <span>News & Resource</span>
            </a>
            <a href="<?php echo esc_url(home_url('/partners/')); ?>" class="mobile-dropdown-link">
                <i class="fas fa-handshake"></i>
                <span>Partners</span>
            </a>
            
            <div class="mobile-language-selector">
                <span class="mobile-language-label">Language:</span>
                <div class="mobile-language-options">
                    <button class="mobile-language-option active" data-lang="en">EN</button>
                    <button class="mobile-language-option" data-lang="bm">BM</button>
                    <button class="mobile-language-option" data-lang="cn">CN</button>
                </div>
            </div>
            
            <a href="<?php echo esc_url(home_url('/signin/')); ?>" class="btn-secondary mobile-only" data-translate="btn-signin">Sign In</a>
            <a href="http://118.107.202.35/Register/RegisterPage" class="btn-primary mobile-only" data-translate="btn-join">Join MPA</a>
        </nav>
    </div>

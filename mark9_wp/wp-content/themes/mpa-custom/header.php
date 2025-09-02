<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <link rel="icon" type="image/svg+xml" href="<?php echo get_template_directory_uri(); ?>/favicon.svg">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">
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
    
    <!-- Debug loading issues -->
    <script>
        // Debug what's actually loading
        let loadingResources = [];
        let originalFetch = window.fetch;
        let originalXHR = window.XMLHttpRequest;
        
        // Track fetch requests
        window.fetch = function(...args) {
            console.log('FETCH REQUEST:', args[0]);
            loadingResources.push('FETCH: ' + args[0]);
            return originalFetch.apply(this, args);
        };
        
        // Track XHR requests
        window.XMLHttpRequest = function() {
            let xhr = new originalXHR();
            let originalOpen = xhr.open;
            xhr.open = function(method, url) {
                console.log('XHR REQUEST:', method, url);
                loadingResources.push('XHR: ' + method + ' ' + url);
                return originalOpen.apply(this, arguments);
            };
            return xhr;
        };
        
        // Track document ready state changes
        document.addEventListener('readystatechange', function() {
            console.log('Document ready state changed to:', document.readyState);
        });
        
        // Track window load event
        window.addEventListener('load', function() {
            console.log('Window load event fired');
        });
        
        // Check what's still loading every 2 seconds
        let checkInterval = setInterval(function() {
            console.log('=== LOADING CHECK ===');
            console.log('Document ready state:', document.readyState);
            console.log('Pending resources tracked:', loadingResources.length);
            
            // Check for pending network requests
            if (window.performance && window.performance.getEntriesByType) {
                let resources = window.performance.getEntriesByType('resource');
                let pendingResources = resources.filter(r => r.responseEnd === 0);
                console.log('Pending network resources:', pendingResources.length);
                pendingResources.forEach(r => console.log('  - PENDING:', r.name));
            }
            
            // Check for images still loading
            let images = document.querySelectorAll('img');
            let loadingImages = Array.from(images).filter(img => !img.complete);
            console.log('Images still loading:', loadingImages.length);
            loadingImages.forEach(img => console.log('  - LOADING IMG:', img.src));
            
            // Check for stylesheets still loading
            let stylesheets = document.querySelectorAll('link[rel="stylesheet"]');
            let loadingCSS = Array.from(stylesheets).filter(link => {
                try {
                    return !link.sheet || link.sheet.cssRules.length === 0;
                } catch(e) {
                    return true; // Cross-origin or still loading
                }
            });
            console.log('Stylesheets still loading:', loadingCSS.length);
            loadingCSS.forEach(css => console.log('  - LOADING CSS:', css.href));
            
            console.log('===================');
        }, 2000);
        
        // Set a timeout to see what's happening
        setTimeout(function() {
            console.log('=== 10 SECOND TIMEOUT ANALYSIS ===');
            console.log('Document ready state:', document.readyState);
            console.log('All tracked requests:', loadingResources);
            
            if (document.readyState !== 'complete') {
                console.log('🔥 PAGE STILL NOT COMPLETE AFTER 10 SECONDS');
                console.log('This indicates something is stuck loading...');
                
                // Don't stop the page, just log what's happening
                // window.stop();
            } else {
                console.log('✅ Page completed normally');
            }
            
            clearInterval(checkInterval);
        }, 10000);
    </script>
    
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
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/mpa-logo.png" alt="Malaysia Proptech Association" class="logo-img">
                </a>
            </div>
            <div class="nav-menu" id="nav-menu">
                <a href="<?php echo esc_url(home_url('/proptech/')); ?>" class="nav-link">Proptech</a>
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
                <a href="<?php echo esc_url(home_url('/join/')); ?>" class="btn-primary desktop-only" data-translate="btn-join">Join MPA</a>
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
                <span>Proptech</span>
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
            <a href="<?php echo esc_url(home_url('/join/')); ?>" class="btn-primary mobile-only" data-translate="btn-join">Join MPA</a>
        </nav>
    </div>

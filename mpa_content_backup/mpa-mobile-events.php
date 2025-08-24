<?php
/*
Plugin Name: MPA Mobile Events
Description: Mobile-only responsive design for MPA Events page - does NOT affect desktop or main theme
Version: 1.0
Author: MPA Development Team
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class MPA_Mobile_Events {
    
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_mobile_styles'));
        add_action('wp_head', array($this, 'add_mobile_meta'));
    }
    
    public function enqueue_mobile_styles() {
        // Only load on events page
        if (!is_page('mpa-events')) {
            return;
        }
        
        // Add mobile-specific CSS
        wp_add_inline_style('wp-block-library', $this->get_mobile_css());
        
        // Add mobile JavaScript
        wp_add_inline_script('jquery', $this->get_mobile_js());
    }
    
    public function add_mobile_meta() {
        // Only on events page
        if (!is_page('mpa-events')) {
            return;
        }
        
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">' . "\n";
    }
    
    private function get_mobile_css() {
        return '
        /* MPA MOBILE EVENTS - MOBILE ONLY */
        @media screen and (max-width: 768px) {
            
            /* Hide desktop elements on mobile only */
            .page-header,
            .entry-header,
            .breadcrumbs,
            .site-header .header-elements {
                display: none !important;
            }
            
            /* Force full width on mobile only */
            .container,
            .content-area,
            .site-main,
            .entry-content {
                max-width: 100% !important;
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            
            /* Mobile Events Header */
            body.page-id-30841 .entry-content {
                position: relative;
                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
                min-height: 100vh !important;
            }
            
            body.page-id-30841 .entry-content::before {
                content: "";
                display: block;
                height: 120px;
                background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
                background-image: url("http://4.194.249.21/wp-content/uploads/2021/08/MPA-Header-Events-01.png");
                background-size: cover;
                background-position: center;
                background-blend-mode: overlay;
                position: relative;
                margin: 0 0 2rem 0;
            }
            
            body.page-id-30841 .entry-content::after {
                content: "Events";
                display: block;
                position: absolute;
                top: 35px;
                left: 0;
                right: 0;
                text-align: center;
                color: white;
                font-size: 1.75rem;
                font-weight: 800;
                text-shadow: 0 4px 12px rgba(0,0,0,0.5);
                z-index: 2;
            }
            
            /* Mobile filter tabs */
            body.page-id-30841 .entry-content > *:first-child::before {
                content: "All Events • This Month • Upcoming • Webinars";
                display: block;
                padding: 1rem;
                background: white;
                border-bottom: 1px solid #e2e8f0;
                font-size: 0.85rem;
                font-weight: 600;
                color: #64748b;
                text-align: center;
                white-space: nowrap;
                overflow-x: auto;
            }
            
            /* Mobile search bar */
            body.page-id-30841 .entry-content > *:first-child::after {
                content: "🔍 Search events...";
                display: block;
                padding: 0.75rem 1rem;
                background: #f8fafc;
                border-radius: 12px;
                margin: 1rem;
                border: 2px solid transparent;
                font-size: 0.9rem;
                color: #94a3b8;
            }
            
            /* Style existing content for mobile */
            body.page-id-30841 .entry-content > * {
                padding: 0 1rem !important;
                margin-bottom: 1.5rem !important;
                background: white !important;
                border-radius: 16px !important;
                box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
            }
            
            /* Newsletter form mobile styling */
            body.page-id-30841 .entry-content form {
                background: white !important;
                border-radius: 20px !important;
                padding: 2rem 1rem !important;
                margin: 2rem 1rem !important;
                box-shadow: 0 8px 32px rgba(0,0,0,0.1) !important;
                text-align: center !important;
            }
            
            body.page-id-30841 .entry-content input[type="email"] {
                width: 100% !important;
                padding: 0.875rem 1rem !important;
                border: 2px solid #e2e8f0 !important;
                border-radius: 12px !important;
                font-size: 0.9rem !important;
                margin-bottom: 0.75rem !important;
                box-sizing: border-box !important;
            }
            
            body.page-id-30841 .entry-content input[type="submit"] {
                background: linear-gradient(135deg, #0978bd, #0693e3) !important;
                color: white !important;
                border: none !important;
                padding: 0.875rem 2rem !important;
                border-radius: 12px !important;
                font-size: 0.9rem !important;
                font-weight: 600 !important;
                cursor: pointer !important;
                width: 100% !important;
                box-shadow: 0 4px 12px rgba(9, 120, 189, 0.3) !important;
                transition: all 0.3s ease !important;
            }
            
            body.page-id-30841 .entry-content input[type="submit"]:hover {
                transform: translateY(-2px) !important;
                box-shadow: 0 6px 20px rgba(9, 120, 189, 0.4) !important;
            }
            
            /* Mobile-friendly text */
            body.page-id-30841 .entry-content p {
                font-size: 0.9rem !important;
                line-height: 1.6 !important;
                color: #64748b !important;
                padding: 1rem !important;
            }
            
            body.page-id-30841 .entry-content h1,
            body.page-id-30841 .entry-content h2,
            body.page-id-30841 .entry-content h3 {
                color: #1e293b !important;
                font-weight: 700 !important;
                margin-bottom: 0.5rem !important;
                padding: 1rem 1rem 0 1rem !important;
            }
            
            /* Mobile contact info styling */
            body.page-id-30841 .entry-content strong {
                display: block !important;
                background: #f8fafc !important;
                padding: 1rem !important;
                border-radius: 12px !important;
                margin: 0.5rem 0 !important;
                font-size: 0.9rem !important;
                color: #1e293b !important;
            }
            
            /* Mobile link styling */
            body.page-id-30841 .entry-content a {
                color: #0978bd !important;
                text-decoration: none !important;
                font-weight: 600 !important;
            }
            
            body.page-id-30841 .entry-content a:hover {
                color: #0863a0 !important;
            }
            
            /* Add mobile floating action button */
            body.page-id-30841::after {
                content: "↑";
                position: fixed;
                bottom: 20px;
                right: 20px;
                width: 50px;
                height: 50px;
                background: linear-gradient(135deg, #0978bd, #0693e3);
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 18px;
                font-weight: bold;
                box-shadow: 0 4px 12px rgba(9, 120, 189, 0.3);
                cursor: pointer;
                z-index: 1000;
                transition: all 0.3s ease;
            }
            
            /* Touch-friendly elements */
            body.page-id-30841 *:focus {
                outline: 2px solid #0978bd !important;
                outline-offset: 2px !important;
            }
        }
        
        /* Desktop - keep original styles */
        @media screen and (min-width: 769px) {
            /* Do nothing - preserve desktop experience */
        }';
    }
    
    private function get_mobile_js() {
        return '
        (function($) {
            $(document).ready(function() {
                // Only run on mobile and events page
                if (window.innerWidth > 768 || !window.location.href.includes("mpa-events")) {
                    return;
                }
                
                // Add floating action button functionality
                $("body").on("click", "body.page-id-30841::after", function() {
                    $("html, body").animate({scrollTop: 0}, 600);
                });
                
                // Add mobile search functionality
                $(".entry-content > *:first-child::after").on("click", function() {
                    var searchTerm = prompt("Search events:");
                    if (searchTerm) {
                        var content = $(".entry-content").text().toLowerCase();
                        if (content.includes(searchTerm.toLowerCase())) {
                            alert("Found: " + searchTerm);
                        } else {
                            alert("No results found for: " + searchTerm);
                        }
                    }
                });
                
                // Mobile touch improvements
                $("body.page-id-30841 a, body.page-id-30841 button, body.page-id-30841 input").each(function() {
                    $(this).css({
                        "min-height": "44px",
                        "min-width": "44px"
                    });
                });
                
                console.log("🎉 MPA Mobile Events loaded successfully!");
            });
        })(jQuery);';
    }
}

// Initialize the plugin
new MPA_Mobile_Events();

?>

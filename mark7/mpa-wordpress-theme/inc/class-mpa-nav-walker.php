<?php
/**
 * Custom Navigation Walker for MPA Theme
 *
 * @package MPA_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class MPA_Nav_Walker extends Walker_Nav_Menu {
    
    /**
     * Start the element output.
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'nav-item';
        
        // Add active class
        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'active';
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<a' . $id . $class_names . ' href="' . esc_url($item->url) . '">';
        
        // Add icon based on menu item title or custom field
        $icon = get_post_meta($item->ID, '_menu_item_icon', true);
        if (!$icon) {
            $icon = $this->get_icon_for_menu_item($item->title);
        }
        
        $output .= '<i class="' . esc_attr($icon) . '"></i>';
        $output .= '<span>' . esc_html($item->title) . '</span>';
    }
    
    /**
     * End the element output.
     */
    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</a>\n";
    }
    
    /**
     * Get icon class based on menu item title
     */
    private function get_icon_for_menu_item($title) {
        $title_lower = strtolower($title);
        
        $icon_map = array(
            'home' => 'fas fa-home',
            'about' => 'fas fa-info-circle',
            'committee' => 'fas fa-users',
            'events' => 'fas fa-calendar-alt',
            'news' => 'fas fa-newspaper',
            'contact' => 'fas fa-envelope',
            'membership' => 'fas fa-user-plus',
            'ecosystem' => 'fas fa-network-wired',
            'partners' => 'fas fa-handshake',
            'investors' => 'fas fa-chart-line',
            'resources' => 'fas fa-book',
            'blog' => 'fas fa-blog',
        );
        
        foreach ($icon_map as $keyword => $icon) {
            if (strpos($title_lower, $keyword) !== false) {
                return $icon;
            }
        }
        
        // Default icon
        return 'fas fa-link';
    }
}

/**
 * Fallback menu function
 */
function mpa_fallback_menu() {
    $menu_items = array(
        array('title' => 'Home', 'url' => home_url(), 'icon' => 'fas fa-home'),
        array('title' => 'Ecosystem', 'url' => '#ecosystem', 'icon' => 'fas fa-network-wired'),
        array('title' => 'Committee', 'url' => '#committee', 'icon' => 'fas fa-users'),
        array('title' => 'Events', 'url' => get_post_type_archive_link('events'), 'icon' => 'fas fa-calendar-alt'),
        array('title' => 'News', 'url' => get_post_type_archive_link('news'), 'icon' => 'fas fa-newspaper'),
        array('title' => 'Contact', 'url' => '#contact', 'icon' => 'fas fa-envelope'),
    );
    
    foreach ($menu_items as $item) {
        $current_class = (is_home() && $item['title'] === 'Home') ? ' active' : '';
        echo '<a href="' . esc_url($item['url']) . '" class="nav-item' . $current_class . '">';
        echo '<i class="' . esc_attr($item['icon']) . '"></i>';
        echo '<span>' . esc_html($item['title']) . '</span>';
        echo '</a>';
    }
}

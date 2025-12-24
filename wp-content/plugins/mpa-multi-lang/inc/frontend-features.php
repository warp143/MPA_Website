<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Frontend Features: SEO Headers, Shortcodes, and Template Tags
 */

/**
 * 1. Helper Function to get translated URL
 * 
 * @param int $post_id The post ID to look from
 * @param string $target_lang The target language slug ('en', 'ms', 'zh')
 * @return string|false The URL of the translation, or false if none.
 */
function mpa_get_trans_url($post_id, $target_lang) {
    if (!$post_id) return false;

    // Get Group ID
    $group_id = get_post_meta($post_id, '_mpa_translation_group_id', true);
    if (!$group_id) return false;

    // Query for the linked post in target lang
    $args = [
        'post_type' => 'any',
        'meta_key' => '_mpa_translation_group_id',
        'meta_value' => $group_id,
        'tax_query' => [
            [
                'taxonomy' => 'mpa_language',
                'field' => 'slug',
                'terms' => $target_lang
            ]
        ],
        'posts_per_page' => 1,
        'fields' => 'ids',
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    ];

    $query = new WP_Query($args);
    if ($query->posts) {
        $trans_id = $query->posts[0];
        $url = get_permalink($trans_id);
        
        // Ensure URL has prefix if needed (for MS/ZH)
        // Note: get_permalink() generates the NATIVE slug URL.
        // Our rewrite rules map ^ms/slug -> slug&lang=ms.
        // So we might need to FORCE the prefix into the URL string if get_permalink doesn't do it.
        // AND we want clean URLs: proptech.org.my/ms/slug
        
        // If native permalink is /slug/, and we want /ms/slug/
        if ($target_lang !== 'en') {
            $home = home_url('/');
            $slug = str_replace($home, '', $url); // get relative path
            $url = home_url('/' . $target_lang . '/' . $slug);
        }
        
        return $url;
    }

    return false;
}

/**
 * 2. Hreflang Injection
 */
add_action('wp_head', 'mpa_add_hreflang_tags');
function mpa_add_hreflang_tags() {
    if (!is_singular()) return;

    global $post;
    $langs = ['en', 'ms', 'zh'];

    foreach ($langs as $lang) {
        $url = mpa_get_trans_url($post->ID, $lang);
        if ($url) {
            echo '<link rel="alternate" hreflang="' . $lang . '" href="' . esc_url($url) . '" />' . "\n";
        }
    }
}

/**
 * 3. Language Switcher Shortcode
 * Usage: [mpa_lang_switcher]
 */
add_shortcode('mpa_lang_switcher', 'mpa_lang_switcher_render');
function mpa_lang_switcher_render() {
    if (!is_singular()) return ''; // Only work on posts/pages for now
    
    global $post;
    $current_lang = get_query_var('mpa_lang', 'en'); 
    // Fallback if query var not set (e.g. main english page)
    if (!$current_lang) {
        $terms = get_the_terms($post->ID, 'mpa_language');
        $current_lang = ($terms && !is_wp_error($terms)) ? $terms[0]->slug : 'en';
    }

    $langs = [
        'en' => 'English',
        'ms' => 'Bahasa Melayu',
        'zh' => '中文'
    ];

    $output = '<div class="mpa-lang-switcher">';
    $output .= '<span class="current-lang">' . $langs[$current_lang] . '</span>';
    $output .= '<ul class="lang-dropdown">';

    foreach ($langs as $slug => $label) {
        if ($slug === $current_lang) continue;

        $url = mpa_get_trans_url($post->ID, $slug);
        
        // If translation exists, link to it. 
        // If not, link to home of that language? Or disable?
        // Decision: Link to Home + Lang prefix if missing.
        if (!$url) {
            $url = home_url('/?lang=' . $slug); // Fallback for now due to complex rewrite logic
            if ($slug !== 'en') {
                 $url = home_url('/' . $slug . '/');
            } else {
                 $url = home_url('/');
            }
        }

        $output .= '<li><a href="' . esc_url($url) . '">' . $label . '</a></li>';
    }

    $output .= '</ul></div>';
    return $output;
}

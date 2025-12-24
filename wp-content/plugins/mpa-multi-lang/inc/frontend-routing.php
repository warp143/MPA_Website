<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle URL Rewrites and Frontend Routing
 */
class MPA_Frontend_Routing {

    public function __construct() {
        add_action('init', [$this, 'add_rewrite_rules']);
        add_filter('query_vars', [$this, 'add_query_vars']);
        add_action('template_redirect', [$this, 'force_locale']);
    }

    /**
     * register the query var so WordPress understands 'mpa_lang'
     */
    public function add_query_vars($vars) {
        $vars[] = 'mpa_lang';
        return $vars;
    }

    /**
     * Add Rewrite Rules for virtual language folders
     * ^ms/(.*) -> matches "ms/my-page-slug"
     */
    public function add_rewrite_rules() {
        add_rewrite_tag('%mpa_lang%', '([^&]+)');

        // 1. Root Language URLs (Homepage)
        // /ms/ -> loads page with slug 'ms-home'
        add_rewrite_rule(
            '^ms/?$',
            'index.php?pagename=ms-home&mpa_lang=ms',
            'top'
        );
        add_rewrite_rule(
            '^zh/?$',
            'index.php?pagename=zh-home&mpa_lang=zh',
            'top'
        );

        // 2. Generic Sub-pages
        // /ms/some-page -> index.php?pagename=some-page&mpa_lang=ms
        add_rewrite_rule(
            '^ms/([^/]+)/?$',
            'index.php?pagename=$matches[1]&mpa_lang=ms',
            'top'
        );
        add_rewrite_rule(
            '^zh/([^/]+)/?$',
            'index.php?pagename=$matches[1]&mpa_lang=zh',
            'top'
        );
    }

    /**
     * Force the locale when the mpa_lang query var is present
     */
    public function force_locale() {
        $lang = get_query_var('mpa_lang');
        if ($lang) {
            // Logic to switch locale for date formatting, etc
            switch ($lang) {
                case 'ms':
                    switch_to_locale('ms_MY');
                    break;
                case 'zh':
                    switch_to_locale('zh_CN'); // or zh_TW
                    break;
            }
        }
    }
}

new MPA_Frontend_Routing();

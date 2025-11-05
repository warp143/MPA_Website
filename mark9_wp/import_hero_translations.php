<?php
/**
 * Import hero section translations to database from WordPress post meta
 */

define('WP_USE_THEMES', false);
require('./wp-load.php');

global $wpdb;
$table = $wpdb->prefix . 'mpa_translations';
$home_id = get_option('page_on_front');

// Get existing post meta
$hero_translations = [
    ['hero-title', 'en', get_post_meta($home_id, '_hero_title', true)],
    ['hero-title', 'bm', get_post_meta($home_id, '_hero_title_bm', true)],
    ['hero-title', 'cn', get_post_meta($home_id, '_hero_title_cn', true)],
    ['hero-subtitle', 'en', get_post_meta($home_id, '_hero_subtitle', true)],
    ['hero-subtitle', 'bm', get_post_meta($home_id, '_hero_subtitle_bm', true)],
    ['hero-subtitle', 'cn', get_post_meta($home_id, '_hero_subtitle_cn', true)],
];

$imported = 0;
foreach ($hero_translations as $item) {
    if (!empty($item[2])) {
        $result = $wpdb->replace($table, [
            'translation_key' => $item[0],
            'lang' => $item[1],
            'value' => $item[2],
            'context' => 'Hero Section',
            'modified_by' => 1,
            'last_modified' => current_time('mysql')
        ]);
        if ($result) $imported++;
    }
}

echo "✅ Imported $imported hero translations from post meta to database\n";

// Verify
$count = $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE context = 'Hero Section'");
echo "Hero translations in database: $count\n";


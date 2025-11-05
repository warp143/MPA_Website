<?php
/**
 * Import missing navigation and other translations
 */

define('WP_USE_THEMES', false);
require('./wp-load.php');

global $wpdb;
$table = $wpdb->prefix . 'mpa_translations';

// Missing BM navigation translations
$missing_translations = [
    ['nav-proptech', 'bm', 'PropTech', 'Navigation'],
    ['nav-about', 'bm', 'Persatuan', 'Navigation'],
    ['nav-members', 'bm', 'Ahli', 'Navigation'],
    ['nav-events', 'bm', 'Acara', 'Navigation'],
    ['nav-news', 'bm', 'Berita & Sumber', 'Navigation'],
    ['nav-partners', 'bm', 'Rakan Kongsi', 'Navigation'],
    
    // Button translations
    ['btn-signin', 'bm', 'Daftar Masuk', 'Buttons'],
    ['btn-signin', 'cn', '登录', 'Buttons'],
    ['btn-join', 'bm', 'Sertai MPA', 'Buttons'],
    ['btn-join', 'cn', '加入 MPA', 'Buttons'],
    
    // Page title
    ['page-title', 'en', 'Malaysia PropTech Association', 'Page Title'],
    ['page-title', 'bm', 'Persatuan PropTech Malaysia', 'Page Title'],
    ['page-title', 'cn', '马来西亚房地产科技协会', 'Page Title'],
];

$imported = 0;
foreach ($missing_translations as $item) {
    $result = $wpdb->replace($table, [
        'translation_key' => $item[0],
        'lang' => $item[1],
        'value' => $item[2],
        'context' => $item[3],
        'modified_by' => 1,
        'last_modified' => current_time('mysql')
    ]);
    if ($result) $imported++;
}

echo "✅ Imported $imported missing translations\n";

// Verify
$count = $wpdb->get_var("SELECT COUNT(*) FROM $table");
echo "Total translations in database: $count\n";


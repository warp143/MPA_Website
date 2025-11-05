<?php
/**
 * Import remaining hardcoded translations
 */

define('WP_USE_THEMES', false);
require('./wp-load.php');

global $wpdb;
$table = $wpdb->prefix . 'mpa_translations';

// Remaining translations from front-page.php
$remaining_translations = [
    // Events section
    ['events-title', 'en', 'Upcoming Events', 'Events Section'],
    ['events-title', 'bm', 'Acara Akan Datang', 'Events Section'],
    ['events-title', 'cn', '即将举行的活动', 'Events Section'],
    
    ['view-all-events', 'en', 'View all events', 'Events Section'],
    ['view-all-events', 'bm', 'Lihat semua acara', 'Events Section'],
    ['view-all-events', 'cn', '查看所有活动', 'Events Section'],
    
    // Partners section
    ['partners-title', 'en', 'Our Partners', 'Partners Section'],
    ['partners-title', 'bm', 'Rakan Kongsi Kami', 'Partners Section'],
    ['partners-title', 'cn', '我们的合作伙伴', 'Partners Section'],
    
    ['partners-subtitle', 'en', 'Strategic collaborations driving PropTech innovation in Malaysia', 'Partners Section'],
    ['partners-subtitle', 'bm', 'Kerjasama strategik memacu inovasi PropTech di Malaysia', 'Partners Section'],
    ['partners-subtitle', 'cn', '推动马来西亚房地产科技创新的战略合作', 'Partners Section'],
    
    ['view-all-partners', 'en', 'View All Partners', 'Partners Section'],
    ['view-all-partners', 'bm', 'Lihat Semua Rakan Kongsi', 'Partners Section'],
    ['view-all-partners', 'cn', '查看所有合作伙伴', 'Partners Section'],
    
    // Community section
    ['community-title', 'en', 'Join Our Community', 'Community Section'],
    ['community-title', 'bm', 'Sertai Komuniti Kami', 'Community Section'],
    ['community-title', 'cn', '加入我们的社区', 'Community Section'],
    
    ['community-subtitle', 'en', 'Choose the membership that fits your needs', 'Community Section'],
    ['community-subtitle', 'bm', 'Pilih keahlian yang sesuai dengan keperluan anda', 'Community Section'],
    ['community-subtitle', 'cn', '选择适合您需求的会员资格', 'Community Section'],
];

$imported = 0;
foreach ($remaining_translations as $item) {
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

echo "✅ Imported $imported remaining translations\n";

// Verify
$count = $wpdb->get_var("SELECT COUNT(*) FROM $table");
echo "Total translations in database: $count\n";


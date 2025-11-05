<?php
/**
 * Import all hardcoded JavaScript translations to MPA Translation Manager database
 */

define('WP_USE_THEMES', false);
require('./wp-load.php');

global $wpdb;
$table = $wpdb->prefix . 'mpa_translations';

// All translations from main.js
$translations = [
    // Hero section
    ['hero-title', 'en', 'For The Future of A Sustainable Property Market'],
    ['hero-title', 'bm', 'Untuk Masa Depan Pasaran Hartanah yang Mampan'],
    ['hero-title', 'cn', '为可持续房地产市场的未来'],
    
    ['hero-subtitle', 'en', 'Leading The Digital Transformation of the Property Industry in Malaysia through innovation, collaboration, and sustainable growth. Building a strong community with integrity, inclusivity, and equality.'],
    ['hero-subtitle', 'bm', 'Memimpin Transformasi Digital Industri Hartanah di Malaysia melalui inovasi, kerjasama, dan pertumbuhan mampan. Membina komuniti yang kuat dengan integriti, inklusiviti, dan kesaksamaan.'],
    ['hero-subtitle', 'cn', '通过创新、协作和可持续增长，引领马来西亚房地产行业的数字化转型。以诚信、包容性和平等性建立强大社区。'],
    
    // Search
    ['search-placeholder', 'en', 'Find events, members, or resources...'],
    ['search-placeholder', 'bm', 'Cari acara, ahli, atau sumber...'],
    ['search-placeholder', 'cn', '查找活动、会员或资源...'],
    
    ['search-btn', 'en', 'Search'],
    ['search-btn', 'bm', 'Cari'],
    ['search-btn', 'cn', '搜索'],
    
    // Stats
    ['stat-members', 'en', 'Members'],
    ['stat-members', 'bm', 'Ahli'],
    ['stat-members', 'cn', '会员'],
    
    ['stat-events', 'en', 'Events'],
    ['stat-events', 'bm', 'Acara'],
    ['stat-events', 'cn', '活动'],
    
    ['stat-startups', 'en', 'Startups'],
    ['stat-startups', 'bm', 'Startups'],
    ['stat-startups', 'cn', '初创企业'],
    
    ['stat-partners', 'en', 'Partners'],
    ['stat-partners', 'bm', 'Rakan Kongsi'],
    ['stat-partners', 'cn', '合作伙伴'],
];

$imported = 0;
foreach ($translations as $item) {
    $result = $wpdb->replace($table, [
        'translation_key' => $item[0],
        'lang' => $item[1],
        'value' => $item[2],
        'context' => 'Frontend',
        'modified_by' => 1,
        'last_modified' => current_time('mysql')
    ]);
    if ($result) $imported++;
}

echo "✅ Imported $imported translations to database\n";

// Verify
$count = $wpdb->get_var("SELECT COUNT(*) FROM $table");
echo "Total translations in database: $count\n";


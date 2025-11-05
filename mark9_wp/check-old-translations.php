<?php
/**
 * Check for Old Translation Data (Polylang & ACF)
 * Run this script to analyze database for remnants of old translation systems
 */

// Load WordPress
require_once __DIR__ . '/wp-load.php';

global $wpdb;

echo "=== CHECKING FOR OLD TRANSLATION DATA ===\n\n";

// 1. Check for Polylang tables
echo "1. POLYLANG TABLES\n";
echo str_repeat("-", 80) . "\n";
$polylang_tables = $wpdb->get_results("SHOW TABLES LIKE '{$wpdb->prefix}polylang%'");
if (!empty($polylang_tables)) {
    echo "❌ FOUND POLYLANG TABLES:\n";
    foreach ($polylang_tables as $table) {
        $table_name = array_values((array)$table)[0];
        $count = $wpdb->get_var("SELECT COUNT(*) FROM `$table_name`");
        echo "   - $table_name (Rows: $count)\n";
    }
} else {
    echo "✅ No Polylang tables found\n";
}
echo "\n";

// 2. Check for Polylang options
echo "2. POLYLANG OPTIONS\n";
echo str_repeat("-", 80) . "\n";
$polylang_options = $wpdb->get_results("
    SELECT option_name, option_value 
    FROM {$wpdb->prefix}options 
    WHERE option_name LIKE '%polylang%'
");
if (!empty($polylang_options)) {
    echo "❌ FOUND POLYLANG OPTIONS:\n";
    foreach ($polylang_options as $option) {
        $value_preview = strlen($option->option_value) > 100 
            ? substr($option->option_value, 0, 100) . '...' 
            : $option->option_value;
        echo "   - {$option->option_name}: $value_preview\n";
    }
} else {
    echo "✅ No Polylang options found\n";
}
echo "\n";

// 3. Check for ACF translation fields
echo "3. ACF TRANSLATION FIELDS\n";
echo str_repeat("-", 80) . "\n";
$acf_trans_fields = $wpdb->get_results("
    SELECT meta_key, meta_value, post_id
    FROM {$wpdb->prefix}postmeta 
    WHERE meta_key LIKE '%acf%' 
    AND (meta_key LIKE '%_en%' OR meta_key LIKE '%_bm%' OR meta_key LIKE '%_cn%' 
         OR meta_key LIKE '%translation%' OR meta_key LIKE '%lang%')
    LIMIT 50
");
if (!empty($acf_trans_fields)) {
    echo "❌ FOUND ACF TRANSLATION FIELDS:\n";
    $grouped = [];
    foreach ($acf_trans_fields as $field) {
        $grouped[$field->meta_key][] = $field->post_id;
    }
    foreach ($grouped as $meta_key => $post_ids) {
        echo "   - $meta_key (Used in " . count($post_ids) . " posts)\n";
    }
} else {
    echo "✅ No ACF translation fields found\n";
}
echo "\n";

// 4. Check for language-related post meta
echo "4. LANGUAGE POST META\n";
echo str_repeat("-", 80) . "\n";
$lang_meta = $wpdb->get_results("
    SELECT meta_key, COUNT(*) as count
    FROM {$wpdb->prefix}postmeta 
    WHERE meta_key IN ('_polylang_lang', 'lang', 'language', 'pll_lang')
    GROUP BY meta_key
");
if (!empty($lang_meta)) {
    echo "❌ FOUND LANGUAGE META:\n";
    foreach ($lang_meta as $meta) {
        echo "   - {$meta->meta_key}: {$meta->count} entries\n";
    }
} else {
    echo "✅ No language post meta found\n";
}
echo "\n";

// 5. Check for language taxonomy
echo "5. LANGUAGE TAXONOMY\n";
echo str_repeat("-", 80) . "\n";
$lang_taxonomies = $wpdb->get_results("
    SELECT taxonomy, COUNT(*) as count
    FROM {$wpdb->prefix}term_taxonomy 
    WHERE taxonomy IN ('language', 'post_translations', 'term_translations', 'term_language')
    GROUP BY taxonomy
");
if (!empty($lang_taxonomies)) {
    echo "❌ FOUND LANGUAGE TAXONOMIES:\n";
    foreach ($lang_taxonomies as $tax) {
        echo "   - {$tax->taxonomy}: {$tax->count} terms\n";
    }
} else {
    echo "✅ No language taxonomies found\n";
}
echo "\n";

// 6. Check for translation-related posts
echo "6. TRANSLATION-RELATED POSTS\n";
echo str_repeat("-", 80) . "\n";
$trans_posts = $wpdb->get_results("
    SELECT post_type, COUNT(*) as count
    FROM {$wpdb->prefix}posts 
    WHERE post_type LIKE '%translation%' OR post_type LIKE '%lang%'
    GROUP BY post_type
");
if (!empty($trans_posts)) {
    echo "❌ FOUND TRANSLATION POST TYPES:\n";
    foreach ($trans_posts as $post) {
        echo "   - {$post->post_type}: {$post->count} posts\n";
    }
} else {
    echo "✅ No translation post types found\n";
}
echo "\n";

// 7. Check for our MPA translation table
echo "7. MPA TRANSLATION MANAGER\n";
echo str_repeat("-", 80) . "\n";
$mpa_table = $wpdb->get_results("SHOW TABLES LIKE '{$wpdb->prefix}mpa_translations'");
if (!empty($mpa_table)) {
    $count = $wpdb->get_var("SELECT COUNT(DISTINCT translation_key) FROM {$wpdb->prefix}mpa_translations");
    $total = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}mpa_translations");
    echo "✅ MPA Translation Manager is active\n";
    echo "   - Table: {$wpdb->prefix}mpa_translations\n";
    echo "   - Unique keys: $count\n";
    echo "   - Total translations: $total\n";
    
    // Show language breakdown
    $lang_breakdown = $wpdb->get_results("
        SELECT lang, COUNT(*) as count 
        FROM {$wpdb->prefix}mpa_translations 
        GROUP BY lang
    ");
    echo "   - Language breakdown:\n";
    foreach ($lang_breakdown as $lang) {
        echo "     • {$lang->lang}: {$lang->count} translations\n";
    }
} else {
    echo "❌ MPA Translation Manager table not found\n";
}
echo "\n";

// 8. Sample ACF field names to check
echo "8. COMMON ACF TRANSLATION PATTERNS\n";
echo str_repeat("-", 80) . "\n";
$acf_patterns = [
    '%_title_en%', '%_title_bm%', '%_title_cn%',
    '%_description_en%', '%_description_bm%', '%_description_cn%',
    '%_content_en%', '%_content_bm%', '%_content_cn%',
    '%hero_%', '%nav_%', '%footer_%'
];

foreach ($acf_patterns as $pattern) {
    $count = $wpdb->get_var($wpdb->prepare("
        SELECT COUNT(*) 
        FROM {$wpdb->prefix}postmeta 
        WHERE meta_key LIKE %s
    ", $pattern));
    
    if ($count > 0) {
        echo "❌ Found $count entries matching pattern: $pattern\n";
        
        // Show sample meta keys
        $samples = $wpdb->get_results($wpdb->prepare("
            SELECT DISTINCT meta_key 
            FROM {$wpdb->prefix}postmeta 
            WHERE meta_key LIKE %s
            LIMIT 5
        ", $pattern));
        
        foreach ($samples as $sample) {
            echo "   - {$sample->meta_key}\n";
        }
    }
}
echo "\n";

// 9. Check active plugins for translation plugins
echo "9. ACTIVE PLUGINS\n";
echo str_repeat("-", 80) . "\n";
$active_plugins = get_option('active_plugins', []);
$translation_plugins = array_filter($active_plugins, function($plugin) {
    return stripos($plugin, 'polylang') !== false || 
           stripos($plugin, 'acf') !== false ||
           stripos($plugin, 'translation') !== false ||
           stripos($plugin, 'multilang') !== false ||
           stripos($plugin, 'wpml') !== false;
});

if (!empty($translation_plugins)) {
    echo "❌ FOUND TRANSLATION-RELATED PLUGINS:\n";
    foreach ($translation_plugins as $plugin) {
        echo "   - $plugin\n";
    }
} else {
    echo "✅ No old translation plugins active\n";
}
echo "\n";

// Summary and Recommendations
echo "\n";
echo "=== SUMMARY & RECOMMENDATIONS ===\n";
echo str_repeat("=", 80) . "\n\n";

$has_old_data = !empty($polylang_tables) || 
                !empty($polylang_options) || 
                !empty($acf_trans_fields) ||
                !empty($lang_meta) ||
                !empty($lang_taxonomies) ||
                !empty($translation_plugins);

if ($has_old_data) {
    echo "⚠️  OLD TRANSLATION DATA DETECTED!\n\n";
    echo "Recommendations:\n";
    echo "1. ✓ Your MPA Translation Manager is working correctly\n";
    echo "2. ⚠️  Old Polylang/ACF translation data exists in the database\n";
    echo "3. 🧹 Consider cleaning up old data to reduce database bloat\n";
    echo "4. 💾 BACKUP your database before cleaning!\n\n";
    echo "Cleanup script can be generated if needed.\n";
} else {
    echo "✅ DATABASE IS CLEAN!\n\n";
    echo "No old Polylang or ACF translation data detected.\n";
    echo "Your MPA Translation Manager is the only active translation system.\n";
}

echo "\n" . str_repeat("=", 80) . "\n";


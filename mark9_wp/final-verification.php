<?php
/**
 * Final Verification - Comprehensive Check
 * VERIFICATION ONLY - NO CHANGES WILL BE MADE
 */

require_once __DIR__ . '/wp-load.php';
global $wpdb;

echo "=== COMPREHENSIVE DATABASE VERIFICATION ===\n";
echo "Checking for ANY remaining old translation data...\n\n";

$issues_found = [];

// 1. Check for Polylang tables
echo "1. POLYLANG TABLES\n" . str_repeat("-", 80) . "\n";
$polylang_tables = $wpdb->get_results("SHOW TABLES LIKE '{$wpdb->prefix}polylang%'");
if (!empty($polylang_tables)) {
    echo "❌ FOUND Polylang tables:\n";
    foreach ($polylang_tables as $table) {
        $table_name = array_values((array)$table)[0];
        echo "   - $table_name\n";
        $issues_found[] = "Polylang table: $table_name";
    }
} else {
    echo "✅ No Polylang tables\n";
}

// 2. Check for Polylang options
echo "\n2. POLYLANG OPTIONS\n" . str_repeat("-", 80) . "\n";
$polylang_options = $wpdb->get_results("
    SELECT option_name 
    FROM {$wpdb->prefix}options 
    WHERE option_name LIKE '%polylang%'
");
if (!empty($polylang_options)) {
    echo "❌ FOUND Polylang options:\n";
    foreach ($polylang_options as $option) {
        echo "   - {$option->option_name}\n";
        $issues_found[] = "Polylang option: {$option->option_name}";
    }
} else {
    echo "✅ No Polylang options\n";
}

// 3. Check for language taxonomies
echo "\n3. LANGUAGE TAXONOMIES\n" . str_repeat("-", 80) . "\n";
$lang_taxonomies = $wpdb->get_results("
    SELECT taxonomy, COUNT(*) as count
    FROM {$wpdb->prefix}term_taxonomy 
    WHERE taxonomy IN ('language', 'post_translations', 'term_language', 'term_translations')
    GROUP BY taxonomy
");
if (!empty($lang_taxonomies)) {
    echo "❌ FOUND language taxonomies:\n";
    foreach ($lang_taxonomies as $tax) {
        echo "   - {$tax->taxonomy}: {$tax->count} terms\n";
        $issues_found[] = "Language taxonomy: {$tax->taxonomy} ({$tax->count} terms)";
    }
} else {
    echo "✅ No language taxonomies\n";
}

// 4. Check for translation post meta with language codes
echo "\n4. TRANSLATION POST META (with language suffixes)\n" . str_repeat("-", 80) . "\n";
$trans_meta = $wpdb->get_results("
    SELECT DISTINCT meta_key, COUNT(*) as count
    FROM {$wpdb->prefix}postmeta
    WHERE (meta_key LIKE '%_bm' OR meta_key LIKE '%_cn' OR meta_key LIKE '%_ms' OR meta_key LIKE '%_zh' OR meta_key LIKE '%_en')
    OR (meta_key LIKE '%\\_bm' OR meta_key LIKE '%\\_cn' OR meta_key LIKE '%\\_ms' OR meta_key LIKE '%\\_zh' OR meta_key LIKE '%\\_en')
    GROUP BY meta_key
    HAVING meta_key NOT LIKE '%submission%' 
    AND meta_key NOT LIKE '%wpcf7%'
    AND meta_key NOT LIKE '%form%'
    ORDER BY meta_key
");

if (!empty($trans_meta)) {
    echo "⚠️  FOUND post meta with language suffixes:\n";
    foreach ($trans_meta as $meta) {
        // Check if it's actually a translation field
        $is_translation = (
            stripos($meta->meta_key, 'title') !== false ||
            stripos($meta->meta_key, 'subtitle') !== false ||
            stripos($meta->meta_key, 'description') !== false ||
            stripos($meta->meta_key, 'content') !== false ||
            stripos($meta->meta_key, 'hero') !== false
        );
        
        if ($is_translation) {
            echo "   ❌ {$meta->meta_key} ({$meta->count} entries) - TRANSLATION FIELD\n";
            $issues_found[] = "Translation meta: {$meta->meta_key} ({$meta->count} entries)";
        } else {
            echo "   ⚠️  {$meta->meta_key} ({$meta->count} entries) - may not be translation-related\n";
        }
    }
} else {
    echo "✅ No translation post meta found\n";
}

// 5. Check for WPML (another translation plugin)
echo "\n5. WPML PLUGIN DATA\n" . str_repeat("-", 80) . "\n";
$wpml_tables = $wpdb->get_results("SHOW TABLES LIKE '{$wpdb->prefix}icl%'");
if (!empty($wpml_tables)) {
    echo "❌ FOUND WPML tables:\n";
    foreach ($wpml_tables as $table) {
        $table_name = array_values((array)$table)[0];
        echo "   - $table_name\n";
        $issues_found[] = "WPML table: $table_name";
    }
} else {
    echo "✅ No WPML tables\n";
}

// 6. Verify MPA Translation Manager is working
echo "\n6. MPA TRANSLATION MANAGER STATUS\n" . str_repeat("-", 80) . "\n";
$mpa_table_exists = $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}mpa_translations'");
if ($mpa_table_exists) {
    $stats = $wpdb->get_results("
        SELECT lang, COUNT(*) as count 
        FROM {$wpdb->prefix}mpa_translations 
        GROUP BY lang
    ");
    echo "✅ MPA Translation Manager is active:\n";
    foreach ($stats as $stat) {
        echo "   - {$stat->lang}: {$stat->count} translations\n";
    }
    $total_keys = $wpdb->get_var("SELECT COUNT(DISTINCT translation_key) FROM {$wpdb->prefix}mpa_translations");
    echo "   - Total unique keys: $total_keys\n";
} else {
    echo "❌ MPA Translation Manager table NOT found!\n";
    $issues_found[] = "MPA Translation Manager table missing!";
}

// 7. Check active plugins
echo "\n7. ACTIVE TRANSLATION PLUGINS\n" . str_repeat("-", 80) . "\n";
$active_plugins = get_option('active_plugins', []);
$translation_plugins = array_filter($active_plugins, function($plugin) {
    return (
        stripos($plugin, 'polylang') !== false || 
        stripos($plugin, 'wpml') !== false ||
        stripos($plugin, 'multilang') !== false ||
        stripos($plugin, 'qtranslate') !== false
    );
});

if (!empty($translation_plugins)) {
    echo "⚠️  Found old translation plugins (may need deactivation):\n";
    foreach ($translation_plugins as $plugin) {
        echo "   - $plugin\n";
        $issues_found[] = "Old plugin active: $plugin";
    }
} else {
    echo "✅ No old translation plugins active\n";
}

$mpa_plugin_active = in_array('mpa-translation-manager/mpa-translation-manager.php', $active_plugins);
if ($mpa_plugin_active) {
    echo "✅ MPA Translation Manager plugin is active\n";
} else {
    echo "❌ MPA Translation Manager plugin is NOT active!\n";
    $issues_found[] = "MPA Translation Manager plugin not active";
}

// 8. Sample ACF field check (specific patterns)
echo "\n8. SPECIFIC ACF TRANSLATION PATTERNS\n" . str_repeat("-", 80) . "\n";
$specific_patterns = [
    '_hero_title_bm', '_hero_title_cn', '_hero_title_ms', '_hero_title_zh',
    '_hero_subtitle_bm', '_hero_subtitle_cn', '_hero_subtitle_ms', '_hero_subtitle_zh',
    '_about_title_bm', '_about_title_cn', '_about_content_bm', '_about_content_cn'
];

$found_specific = false;
foreach ($specific_patterns as $pattern) {
    $count = $wpdb->get_var($wpdb->prepare("
        SELECT COUNT(*) 
        FROM {$wpdb->prefix}postmeta 
        WHERE meta_key = %s
    ", $pattern));
    
    if ($count > 0) {
        echo "❌ Found: $pattern ($count entries)\n";
        $issues_found[] = "ACF field: $pattern ($count entries)";
        $found_specific = true;
    }
}

if (!$found_specific) {
    echo "✅ No specific ACF translation patterns found\n";
}

// FINAL SUMMARY
echo "\n\n" . str_repeat("=", 80) . "\n";
echo "FINAL VERIFICATION SUMMARY\n";
echo str_repeat("=", 80) . "\n\n";

if (empty($issues_found)) {
    echo "🎉 DATABASE IS COMPLETELY CLEAN! 🎉\n\n";
    echo "✅ No Polylang data\n";
    echo "✅ No ACF translation fields\n";
    echo "✅ No language taxonomies\n";
    echo "✅ No old translation plugins\n";
    echo "✅ MPA Translation Manager is working correctly\n";
    echo "\nYour database has been successfully cleaned!\n";
} else {
    echo "⚠️  ISSUES FOUND: " . count($issues_found) . "\n\n";
    foreach ($issues_found as $issue) {
        echo "   • $issue\n";
    }
    echo "\nThese issues should be addressed.\n";
}

echo str_repeat("=", 80) . "\n";


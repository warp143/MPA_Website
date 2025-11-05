<?php
/**
 * Cleanup ACF Hero Translation Fields
 * Removes old ACF hero translation meta fields from posts
 */

require_once __DIR__ . '/wp-load.php';
global $wpdb;

echo "=== ACF HERO TRANSLATION FIELDS CLEANUP ===\n\n";
echo "⚠️  This will remove old ACF hero translation fields:\n";
echo "    - _hero_title_bm, _hero_title_cn, _hero_title_ms\n";
echo "    - _hero_subtitle_bm, _hero_subtitle_cn, _hero_subtitle_ms\n\n";
echo "💾 Make sure you have a backup before proceeding!\n\n";

// 1. Preview what will be deleted
echo "1. Scanning for ACF hero translation fields...\n\n";
$acf_hero_keys = [
    '_hero_title_bm',
    '_hero_title_cn', 
    '_hero_title_ms',
    '_hero_subtitle_bm',
    '_hero_subtitle_cn',
    '_hero_subtitle_ms'
];

$preview_data = [];
foreach ($acf_hero_keys as $meta_key) {
    $results = $wpdb->get_results($wpdb->prepare("
        SELECT p.ID, p.post_title, pm.meta_key, pm.meta_value
        FROM {$wpdb->prefix}postmeta pm
        JOIN {$wpdb->prefix}posts p ON pm.post_id = p.ID
        WHERE pm.meta_key = %s
    ", $meta_key));
    
    if (!empty($results)) {
        foreach ($results as $row) {
            if (!isset($preview_data[$row->ID])) {
                $preview_data[$row->ID] = [
                    'post_title' => $row->post_title,
                    'fields' => []
                ];
            }
            $preview_data[$row->ID]['fields'][$row->meta_key] = $row->meta_value;
        }
    }
}

if (empty($preview_data)) {
    echo "✅ No ACF hero translation fields found. Nothing to clean up!\n";
    exit(0);
}

echo "Found ACF hero fields in " . count($preview_data) . " post(s):\n\n";
foreach ($preview_data as $post_id => $data) {
    echo "📄 Post #{$post_id}: {$data['post_title']}\n";
    foreach ($data['fields'] as $key => $value) {
        $preview = strlen($value) > 60 ? substr($value, 0, 60) . '...' : $value;
        echo "   - $key: $preview\n";
    }
    echo "\n";
}

echo str_repeat("-", 80) . "\n";
echo "Total fields to delete: " . array_sum(array_map(function($d) { return count($d['fields']); }, $preview_data)) . "\n";
echo str_repeat("-", 80) . "\n\n";

echo "Press ENTER to continue with deletion or Ctrl+C to cancel...";
if (php_sapi_name() === 'cli') {
    fgets(STDIN);
}

// 2. Perform deletion
echo "\n2. Deleting ACF hero translation fields...\n\n";
$total_deleted = 0;

foreach ($acf_hero_keys as $meta_key) {
    $deleted = $wpdb->delete(
        $wpdb->prefix . 'postmeta',
        ['meta_key' => $meta_key],
        ['%s']
    );
    
    if ($deleted > 0) {
        echo "   ✓ Deleted $deleted entries for: $meta_key\n";
        $total_deleted += $deleted;
    }
}

// 3. Verify cleanup
echo "\n3. Verifying cleanup...\n";
$remaining = 0;
foreach ($acf_hero_keys as $meta_key) {
    $count = $wpdb->get_var($wpdb->prepare("
        SELECT COUNT(*) 
        FROM {$wpdb->prefix}postmeta 
        WHERE meta_key = %s
    ", $meta_key));
    $remaining += $count;
}

if ($remaining == 0) {
    echo "   ✅ All ACF hero translation fields removed successfully!\n";
} else {
    echo "   ⚠️  Warning: $remaining fields still remain\n";
}

// Summary
echo "\n" . str_repeat("=", 80) . "\n";
echo "CLEANUP SUMMARY\n";
echo str_repeat("=", 80) . "\n";
echo "Total fields deleted: $total_deleted\n";
echo "Posts affected: " . count($preview_data) . "\n";
echo "\n✅ ACF hero translation fields have been removed!\n";
echo "✅ Posts themselves remain intact.\n";
echo "✅ Your MPA Translation Manager handles all translations now.\n";
echo str_repeat("=", 80) . "\n";


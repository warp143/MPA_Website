<?php
require_once __DIR__ . '/wp-load.php';
global $wpdb;

echo "=== CHECKING REMAINING HERO FIELDS ===\n\n";

$hero_fields = $wpdb->get_results("
    SELECT DISTINCT meta_key, COUNT(*) as count
    FROM {$wpdb->prefix}postmeta
    WHERE meta_key LIKE '%hero%'
    GROUP BY meta_key
    ORDER BY meta_key
");

echo "Found " . count($hero_fields) . " hero-related meta keys:\n\n";

foreach ($hero_fields as $field) {
    $is_translation = (stripos($field->meta_key, '_bm') !== false || 
                       stripos($field->meta_key, '_cn') !== false || 
                       stripos($field->meta_key, '_ms') !== false ||
                       stripos($field->meta_key, '_zh') !== false ||
                       stripos($field->meta_key, '_en') !== false);
    
    $status = $is_translation ? '⚠️  OLD TRANSLATION' : '✅ OK (current field)';
    
    echo "$status - {$field->meta_key} (used {$field->count} times)\n";
    
    // Show sample values for translation fields
    if ($is_translation) {
        $samples = $wpdb->get_results($wpdb->prepare("
            SELECT p.post_title, pm.meta_value
            FROM {$wpdb->prefix}postmeta pm
            JOIN {$wpdb->prefix}posts p ON pm.post_id = p.ID
            WHERE pm.meta_key = %s
            LIMIT 2
        ", $field->meta_key));
        
        foreach ($samples as $sample) {
            $value = strlen($sample->meta_value) > 50 ? substr($sample->meta_value, 0, 50) . '...' : $sample->meta_value;
            echo "      Post: {$sample->post_title}\n";
            echo "      Value: $value\n";
        }
    }
}

echo "\n" . str_repeat("=", 80) . "\n";


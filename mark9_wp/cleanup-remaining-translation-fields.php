<?php
require_once __DIR__ . '/wp-load.php';
global $wpdb;

echo "=== REMOVING REMAINING TRANSLATION FIELDS ===\n\n";

$translation_patterns = ['%_zh%', '%_en%', '%_bm%', '%_cn%', '%_ms%'];
$total_deleted = 0;

foreach ($translation_patterns as $pattern) {
    // Find fields matching this pattern
    $fields = $wpdb->get_results($wpdb->prepare("
        SELECT DISTINCT meta_key, COUNT(*) as count
        FROM {$wpdb->prefix}postmeta
        WHERE meta_key LIKE %s
        AND (meta_key LIKE '%%title%%' OR meta_key LIKE '%%subtitle%%' OR meta_key LIKE '%%description%%' OR meta_key LIKE '%%hero%%')
        GROUP BY meta_key
    ", $pattern));
    
    foreach ($fields as $field) {
        echo "Removing {$field->meta_key} ({$field->count} entries)...\n";
        
        $deleted = $wpdb->delete(
            $wpdb->prefix . 'postmeta',
            ['meta_key' => $field->meta_key],
            ['%s']
        );
        
        if ($deleted) {
            echo "   ✓ Deleted $deleted entries\n";
            $total_deleted += $deleted;
        }
    }
}

echo "\n" . str_repeat("=", 80) . "\n";
echo "CLEANUP COMPLETE\n";
echo "Total fields deleted: $total_deleted\n";
echo str_repeat("=", 80) . "\n";


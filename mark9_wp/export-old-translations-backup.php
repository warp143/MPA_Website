<?php
/**
 * Export Old Translation Data for Backup
 * Run this BEFORE cleanup to preserve data
 */

require_once __DIR__ . '/wp-load.php';
global $wpdb;

$backup_data = [
    'export_date' => current_time('mysql'),
    'database' => DB_NAME,
    'note' => 'Backup of Polylang and ACF translation data before cleanup',
];

echo "=== EXPORTING OLD TRANSLATION DATA ===\n\n";

// 1. Export Polylang Options
echo "1. Exporting Polylang options...\n";
$backup_data['polylang_options'] = [
    'polylang' => get_option('polylang'),
    'polylang_wpml_strings' => get_option('polylang_wpml_strings'),
    'widget_polylang' => get_option('widget_polylang'),
];
echo "   ✓ Exported Polylang options\n";

// 2. Export Language Terms
echo "\n2. Exporting language taxonomy terms...\n";
$backup_data['language_taxonomies'] = [];

$taxonomies = ['language', 'post_translations', 'term_language', 'term_translations'];
foreach ($taxonomies as $taxonomy) {
    $terms = $wpdb->get_results($wpdb->prepare("
        SELECT t.term_id, t.name, t.slug, tt.description, tt.parent, tt.count
        FROM {$wpdb->prefix}terms t
        JOIN {$wpdb->prefix}term_taxonomy tt ON t.term_id = tt.term_id
        WHERE tt.taxonomy = %s
    ", $taxonomy));
    
    $backup_data['language_taxonomies'][$taxonomy] = $terms;
    echo "   ✓ Exported {$taxonomy}: " . count($terms) . " terms\n";
}

// 3. Export Post-Language Relationships
echo "\n3. Exporting post-language relationships...\n";
$post_lang_relationships = $wpdb->get_results("
    SELECT 
        p.ID,
        p.post_title,
        p.post_type,
        p.post_status,
        t.name as language,
        t.slug as lang_code
    FROM {$wpdb->prefix}term_relationships tr
    JOIN {$wpdb->prefix}term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
    JOIN {$wpdb->prefix}terms t ON tt.term_id = t.term_id
    JOIN {$wpdb->prefix}posts p ON tr.object_id = p.ID
    WHERE tt.taxonomy = 'language'
    ORDER BY p.ID
");
$backup_data['post_language_assignments'] = $post_lang_relationships;
echo "   ✓ Exported " . count($post_lang_relationships) . " post-language relationships\n";

// 4. Export ACF Hero Translation Fields
echo "\n4. Exporting ACF hero translation fields...\n";
$acf_hero_fields = $wpdb->get_results("
    SELECT 
        p.ID,
        p.post_title,
        p.post_type,
        pm.meta_key,
        pm.meta_value
    FROM {$wpdb->prefix}postmeta pm
    JOIN {$wpdb->prefix}posts p ON pm.post_id = p.ID
    WHERE pm.meta_key IN (
        '_hero_title_bm', '_hero_title_cn', '_hero_title_ms',
        '_hero_subtitle_bm', '_hero_subtitle_cn', '_hero_subtitle_ms'
    )
    ORDER BY p.ID, pm.meta_key
");

$backup_data['acf_hero_fields'] = [];
foreach ($acf_hero_fields as $field) {
    if (!isset($backup_data['acf_hero_fields'][$field->ID])) {
        $backup_data['acf_hero_fields'][$field->ID] = [
            'post_title' => $field->post_title,
            'post_type' => $field->post_type,
            'fields' => [],
        ];
    }
    $backup_data['acf_hero_fields'][$field->ID]['fields'][$field->meta_key] = $field->meta_value;
}
echo "   ✓ Exported ACF fields from " . count($backup_data['acf_hero_fields']) . " posts\n";

// 5. Export Translation Groups
echo "\n5. Exporting translation groups...\n";
$translation_groups = [];
foreach ($backup_data['post_language_assignments'] as $post) {
    // Get translation group for this post
    $group = $wpdb->get_var($wpdb->prepare("
        SELECT t.slug
        FROM {$wpdb->prefix}term_relationships tr
        JOIN {$wpdb->prefix}term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
        JOIN {$wpdb->prefix}terms t ON tt.term_id = t.term_id
        WHERE tt.taxonomy = 'post_translations'
        AND tr.object_id = %d
    ", $post->ID));
    
    if ($group) {
        if (!isset($translation_groups[$group])) {
            $translation_groups[$group] = [];
        }
        $translation_groups[$group][] = [
            'id' => $post->ID,
            'title' => $post->post_title,
            'type' => $post->post_type,
            'language' => $post->lang_code,
        ];
    }
}
$backup_data['translation_groups'] = $translation_groups;
echo "   ✓ Exported " . count($translation_groups) . " translation groups\n";

// 6. Save to JSON file
$filename = 'old_translations_backup_' . date('Ymd_His') . '.json';
$filepath = __DIR__ . '/' . $filename;

echo "\n6. Saving backup...\n";
file_put_contents($filepath, json_encode($backup_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "   ✓ Backup saved to: $filename\n";

// 7. Generate summary
echo "\n" . str_repeat("=", 80) . "\n";
echo "BACKUP SUMMARY\n";
echo str_repeat("=", 80) . "\n";
echo "File: $filename\n";
echo "Size: " . number_format(filesize($filepath)) . " bytes\n";
echo "\nContents:\n";
echo "  - Polylang options: " . count($backup_data['polylang_options']) . " items\n";
echo "  - Language taxonomies: " . array_sum(array_map('count', $backup_data['language_taxonomies'])) . " terms\n";
echo "  - Post assignments: " . count($backup_data['post_language_assignments']) . " posts\n";
echo "  - ACF hero fields: " . count($backup_data['acf_hero_fields']) . " posts\n";
echo "  - Translation groups: " . count($backup_data['translation_groups']) . " groups\n";
echo "\n✅ Backup complete! You can now safely run cleanup scripts.\n";
echo str_repeat("=", 80) . "\n";


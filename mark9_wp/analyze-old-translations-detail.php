<?php
/**
 * Detailed Analysis of Old Translation Data
 */

require_once __DIR__ . '/wp-load.php';
global $wpdb;

echo "=== DETAILED ANALYSIS OF OLD TRANSLATION DATA ===\n\n";

// 1. Polylang Options Details
echo "1. POLYLANG OPTIONS (Detailed)\n";
echo str_repeat("-", 80) . "\n";
$polylang_option = get_option('polylang');
if ($polylang_option) {
    echo "Polylang Configuration:\n";
    print_r($polylang_option);
    echo "\n";
}

// 2. Language Taxonomy Terms
echo "\n2. LANGUAGE TAXONOMY TERMS\n";
echo str_repeat("-", 80) . "\n";

echo "\nLanguage Terms:\n";
$lang_terms = $wpdb->get_results("
    SELECT t.term_id, t.name, t.slug, tt.taxonomy, tt.count
    FROM {$wpdb->prefix}terms t
    JOIN {$wpdb->prefix}term_taxonomy tt ON t.term_id = tt.term_id
    WHERE tt.taxonomy = 'language'
");
foreach ($lang_terms as $term) {
    echo "  - {$term->name} ({$term->slug}) - {$term->count} posts\n";
}

echo "\nPost Translations:\n";
$post_trans = $wpdb->get_results("
    SELECT t.term_id, t.name, t.slug, tt.count
    FROM {$wpdb->prefix}terms t
    JOIN {$wpdb->prefix}term_taxonomy tt ON t.term_id = tt.term_id
    WHERE tt.taxonomy = 'post_translations'
");
foreach ($post_trans as $term) {
    echo "  - Translation Group: {$term->name} ({$term->count} posts)\n";
}

echo "\nTerm Language:\n";
$term_lang = $wpdb->get_results("
    SELECT t.term_id, t.name, t.slug, tt.count
    FROM {$wpdb->prefix}terms t
    JOIN {$wpdb->prefix}term_taxonomy tt ON t.term_id = tt.term_id
    WHERE tt.taxonomy = 'term_language'
");
foreach ($term_lang as $term) {
    echo "  - {$term->name} ({$term->slug})\n";
}

echo "\nTerm Translations:\n";
$term_trans = $wpdb->get_results("
    SELECT t.term_id, t.name, t.slug, tt.count
    FROM {$wpdb->prefix}terms t
    JOIN {$wpdb->prefix}term_taxonomy tt ON t.term_id = tt.term_id
    WHERE tt.taxonomy = 'term_translations'
");
foreach ($term_trans as $term) {
    echo "  - Translation Group: {$term->name}\n";
}

// 3. Posts with language assignments
echo "\n\n3. POSTS WITH LANGUAGE ASSIGNMENTS\n";
echo str_repeat("-", 80) . "\n";
$posts_by_lang = $wpdb->get_results("
    SELECT 
        t.slug as language,
        p.post_type,
        COUNT(*) as count
    FROM {$wpdb->prefix}term_relationships tr
    JOIN {$wpdb->prefix}term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
    JOIN {$wpdb->prefix}terms t ON tt.term_id = t.term_id
    JOIN {$wpdb->prefix}posts p ON tr.object_id = p.ID
    WHERE tt.taxonomy = 'language'
    GROUP BY t.slug, p.post_type
    ORDER BY t.slug, p.post_type
");

foreach ($posts_by_lang as $row) {
    echo "  - {$row->language}: {$row->post_type} ({$row->count} posts)\n";
}

// 4. ACF Hero Fields Details
echo "\n\n4. ACF HERO TRANSLATION FIELDS (Sample Data)\n";
echo str_repeat("-", 80) . "\n";
$hero_fields = $wpdb->get_results("
    SELECT p.ID, p.post_title, pm.meta_key, pm.meta_value
    FROM {$wpdb->prefix}postmeta pm
    JOIN {$wpdb->prefix}posts p ON pm.post_id = p.ID
    WHERE pm.meta_key LIKE '%hero%'
    AND (pm.meta_key LIKE '%_bm%' OR pm.meta_key LIKE '%_cn%' OR pm.meta_key LIKE '%_ms%')
    ORDER BY p.ID, pm.meta_key
    LIMIT 20
");

if (!empty($hero_fields)) {
    $current_post = null;
    foreach ($hero_fields as $field) {
        if ($current_post !== $field->ID) {
            echo "\n📄 Post #{$field->ID}: {$field->post_title}\n";
            $current_post = $field->ID;
        }
        $value = strlen($field->meta_value) > 60 
            ? substr($field->meta_value, 0, 60) . '...' 
            : $field->meta_value;
        echo "   {$field->meta_key}: $value\n";
    }
} else {
    echo "No hero translation fields found.\n";
}

// 5. All ACF-like translation meta keys
echo "\n\n5. ALL ACF TRANSLATION META KEYS\n";
echo str_repeat("-", 80) . "\n";
$all_trans_keys = $wpdb->get_results("
    SELECT DISTINCT meta_key, COUNT(*) as usage_count
    FROM {$wpdb->prefix}postmeta
    WHERE meta_key LIKE '%_bm%' 
       OR meta_key LIKE '%_cn%' 
       OR meta_key LIKE '%_ms%'
       OR meta_key LIKE '%_en%'
    GROUP BY meta_key
    ORDER BY usage_count DESC
");

if (!empty($all_trans_keys)) {
    echo "Found " . count($all_trans_keys) . " translation meta keys:\n\n";
    foreach ($all_trans_keys as $key) {
        echo "  - {$key->meta_key} (used {$key->usage_count} times)\n";
    }
} else {
    echo "No translation meta keys found.\n";
}

// 6. Check which posts have both old and new translation systems
echo "\n\n6. POSTS USING BOTH SYSTEMS\n";
echo str_repeat("-", 80) . "\n";
$dual_system = $wpdb->get_results("
    SELECT DISTINCT p.ID, p.post_title, p.post_type
    FROM {$wpdb->prefix}posts p
    JOIN {$wpdb->prefix}term_relationships tr ON p.ID = tr.object_id
    JOIN {$wpdb->prefix}term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
    JOIN {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id
    WHERE tt.taxonomy = 'language'
    AND (pm.meta_key LIKE '%_bm%' OR pm.meta_key LIKE '%_cn%')
    LIMIT 10
");

if (!empty($dual_system)) {
    echo "Posts using both Polylang AND ACF translations:\n";
    foreach ($dual_system as $post) {
        echo "  - #{$post->ID}: {$post->post_title} ({$post->post_type})\n";
    }
} else {
    echo "No posts using both systems.\n";
}

echo "\n\n" . str_repeat("=", 80) . "\n";
echo "Analysis complete!\n";


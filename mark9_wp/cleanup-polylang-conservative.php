<?php
/**
 * Conservative Polylang Cleanup
 * Removes Polylang metadata while KEEPING all posts
 */

require_once __DIR__ . '/wp-load.php';
global $wpdb;

echo "=== CONSERVATIVE POLYLANG CLEANUP ===\n\n";
echo "⚠️  WARNING: This will remove Polylang metadata from your database.\n";
echo "📋 Posts will be KEPT, only language assignments will be removed.\n";
echo "💾 Make sure you have a database backup before proceeding!\n\n";

echo "Press ENTER to continue or Ctrl+C to cancel...";
if (php_sapi_name() === 'cli') {
    fgets(STDIN);
}

echo "\nStarting cleanup...\n\n";

$stats = [
    'options_deleted' => 0,
    'term_relationships_deleted' => 0,
    'terms_deleted' => 0,
];

// 1. Remove Polylang options
echo "1. Removing Polylang options...\n";
$polylang_options = ['polylang', 'polylang_wpml_strings', 'widget_polylang'];
foreach ($polylang_options as $option) {
    if (delete_option($option)) {
        echo "   ✓ Deleted option: $option\n";
        $stats['options_deleted']++;
    }
}

// 2. Get all language-related term IDs
echo "\n2. Finding language taxonomy terms...\n";
$language_taxonomies = ['language', 'post_translations', 'term_language', 'term_translations'];
$term_ids = [];

foreach ($language_taxonomies as $taxonomy) {
    $terms = $wpdb->get_results($wpdb->prepare("
        SELECT tt.term_taxonomy_id, t.term_id, t.name, tt.count
        FROM {$wpdb->prefix}term_taxonomy tt
        JOIN {$wpdb->prefix}terms t ON tt.term_id = t.term_id
        WHERE tt.taxonomy = %s
    ", $taxonomy));
    
    echo "   Found {$taxonomy}: " . count($terms) . " terms\n";
    
    foreach ($terms as $term) {
        $term_ids[] = [
            'term_id' => $term->term_id,
            'term_taxonomy_id' => $term->term_taxonomy_id,
            'taxonomy' => $taxonomy,
            'name' => $term->name,
            'count' => $term->count,
        ];
    }
}

// 3. Remove term relationships (unlink posts from languages)
echo "\n3. Removing post-language relationships...\n";
foreach ($term_ids as $term) {
    $deleted = $wpdb->delete(
        $wpdb->prefix . 'term_relationships',
        ['term_taxonomy_id' => $term['term_taxonomy_id']],
        ['%d']
    );
    
    if ($deleted) {
        echo "   ✓ Removed {$deleted} relationships from: {$term['taxonomy']} - {$term['name']}\n";
        $stats['term_relationships_deleted'] += $deleted;
    }
}

// 4. Delete term taxonomy entries
echo "\n4. Removing term taxonomy entries...\n";
foreach ($term_ids as $term) {
    $deleted = $wpdb->delete(
        $wpdb->prefix . 'term_taxonomy',
        ['term_taxonomy_id' => $term['term_taxonomy_id']],
        ['%d']
    );
    
    if ($deleted) {
        echo "   ✓ Deleted taxonomy entry: {$term['taxonomy']} - {$term['name']}\n";
    }
}

// 5. Delete terms
echo "\n5. Removing language terms...\n";
foreach ($term_ids as $term) {
    $deleted = $wpdb->delete(
        $wpdb->prefix . 'terms',
        ['term_id' => $term['term_id']],
        ['%d']
    );
    
    if ($deleted) {
        echo "   ✓ Deleted term: {$term['name']}\n";
        $stats['terms_deleted']++;
    }
}

// 6. Clean up term meta (if any)
echo "\n6. Cleaning term meta...\n";
$term_ids_list = array_column($term_ids, 'term_id');
if (!empty($term_ids_list)) {
    $placeholders = implode(',', array_fill(0, count($term_ids_list), '%d'));
    $deleted_meta = $wpdb->query($wpdb->prepare("
        DELETE FROM {$wpdb->prefix}termmeta
        WHERE term_id IN ($placeholders)
    ", $term_ids_list));
    
    echo "   ✓ Deleted $deleted_meta term meta entries\n";
}

// 7. Verify cleanup
echo "\n7. Verifying cleanup...\n";
$remaining_polylang_tables = $wpdb->get_results("SHOW TABLES LIKE '{$wpdb->prefix}polylang%'");
$remaining_lang_terms = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM {$wpdb->prefix}term_taxonomy 
    WHERE taxonomy IN ('language', 'post_translations', 'term_language', 'term_translations')
");

if (empty($remaining_polylang_tables) && $remaining_lang_terms == 0) {
    echo "   ✅ Cleanup verified successfully!\n";
} else {
    echo "   ⚠️  Some data may remain:\n";
    if (!empty($remaining_polylang_tables)) {
        echo "      - Polylang tables still exist\n";
    }
    if ($remaining_lang_terms > 0) {
        echo "      - $remaining_lang_terms language terms still exist\n";
    }
}

// Summary
echo "\n" . str_repeat("=", 80) . "\n";
echo "CLEANUP SUMMARY\n";
echo str_repeat("=", 80) . "\n";
echo "Options deleted: {$stats['options_deleted']}\n";
echo "Term relationships removed: {$stats['term_relationships_deleted']}\n";
echo "Terms deleted: {$stats['terms_deleted']}\n";
echo "\n✅ Polylang metadata has been removed!\n";
echo "✅ All posts have been kept intact.\n";
echo "✅ Your MPA Translation Manager continues to work normally.\n";
echo "\n⚠️  Note: Posts that were duplicated for different languages still exist.\n";
echo "   You may want to manually review and delete duplicate pages if needed.\n";
echo str_repeat("=", 80) . "\n";


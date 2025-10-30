<?php
/**
 * Fix Committee Members Meta Fields Script
 * 
 * This script adds the missing _member_status and _member_term meta fields
 * to all committee members so they show up on the frontend.
 * 
 * Usage: Access this file via browser: /wp-content/themes/mpa-custom/fix-committee-meta.php
 */

// Load WordPress
require_once('../../../wp-config.php');
require_once('../../../wp-load.php');

// Check if user is admin
if (!current_user_can('manage_options')) {
    die('Access denied. Admin privileges required.');
}

echo "<h1>Fix Committee Members Meta Fields</h1>";

// Query all committee members
$all_committee = new WP_Query(array(
    'post_type' => 'mpa_committee',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'menu_order',
    'order' => 'ASC'
));

echo "<h2>Fixing " . $all_committee->found_posts . " committee members...</h2>";

$fixed_count = 0;

if ($all_committee->have_posts()) {
    while ($all_committee->have_posts()) {
        $all_committee->the_post();
        $post_id = get_the_ID();
        $name = get_the_title();
        
        echo "<h3>Processing: " . esc_html($name) . " (ID: " . $post_id . ")</h3>";
        
        // Check current meta values
        $current_status = get_post_meta($post_id, '_member_status', true);
        $current_term = get_post_meta($post_id, '_member_term', true);
        
        echo "<p>Current Status: " . ($current_status ? $current_status : 'Not set') . "</p>";
        echo "<p>Current Term: " . ($current_term ? $current_term : 'Not set') . "</p>";
        
        // Add missing meta fields
        if (!$current_status) {
            update_post_meta($post_id, '_member_status', 'active');
            echo "<p style='color: green;'>✓ Added _member_status: active</p>";
        }
        
        if (!$current_term) {
            update_post_meta($post_id, '_member_term', '2025-2026');
            echo "<p style='color: green;'>✓ Added _member_term: 2025-2026</p>";
        }
        
        if (!$current_status || !$current_term) {
            $fixed_count++;
        }
        
        echo "<hr>";
    }
} else {
    echo "<p>No committee members found.</p>";
}

wp_reset_postdata();

echo "<h2>Summary</h2>";
echo "<p style='color: blue; font-weight: bold;'>Fixed " . $fixed_count . " committee members.</p>";

echo "<h2>Now test the frontend</h2>";
echo "<p>Visit: <a href='/association/' target='_blank'>http://localhost:8000/association/</a></p>";
echo "<p>All committee members should now appear on the page, including Lim Lee Min in position 6.</p>";
?>

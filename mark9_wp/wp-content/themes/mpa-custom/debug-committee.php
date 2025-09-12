<?php
/**
 * Debug Committee Members Script
 * 
 * This script shows all committee members in the database to help debug issues.
 * 
 * Usage: Access this file via browser: /wp-content/themes/mpa-custom/debug-committee.php
 */

// Load WordPress
require_once('../../../wp-config.php');
require_once('../../../wp-load.php');

// Check if user is admin
if (!current_user_can('manage_options')) {
    die('Access denied. Admin privileges required.');
}

echo "<h1>Committee Members Debug</h1>";

// Query all committee members
$all_committee = new WP_Query(array(
    'post_type' => 'mpa_committee',
    'posts_per_page' => -1,
    'post_status' => 'any',
    'orderby' => 'menu_order',
    'order' => 'ASC'
));

echo "<h2>All Committee Members in Database:</h2>";
echo "<table border='1' cellpadding='10' cellspacing='0'>";
echo "<tr><th>ID</th><th>Name</th><th>Status</th><th>Order</th><th>Term</th><th>Position</th><th>Email</th></tr>";

if ($all_committee->have_posts()) {
    while ($all_committee->have_posts()) {
        $all_committee->the_post();
        $post_id = get_the_ID();
        
        $status = get_post_meta($post_id, '_member_status', true);
        $term = get_post_meta($post_id, '_member_term', true);
        $position = get_post_meta($post_id, '_member_position', true);
        $email = get_post_meta($post_id, '_member_email', true);
        $order = get_post_field('menu_order', $post_id);
        $post_status = get_post_status($post_id);
        
        echo "<tr>";
        echo "<td>" . $post_id . "</td>";
        echo "<td>" . get_the_title() . "</td>";
        echo "<td>" . ($post_status === 'publish' ? 'Published' : $post_status) . "</td>";
        echo "<td>" . $order . "</td>";
        echo "<td>" . ($term ? $term : 'Not set') . "</td>";
        echo "<td>" . ($position ? $position : 'Not set') . "</td>";
        echo "<td>" . ($email ? $email : 'Not set') . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No committee members found</td></tr>";
}

echo "</table>";

// Now check what the frontend query would return
echo "<h2>Frontend Query Results (what shows on the page):</h2>";

$frontend_query = new WP_Query(array(
    'post_type' => 'mpa_committee',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'meta_query' => array(
        array(
            'key' => '_member_status',
            'value' => 'active',
            'compare' => '='
        ),
        array(
            'key' => '_member_term',
            'value' => '2025-2026',
            'compare' => '='
        )
    ),
    'orderby' => 'menu_order',
    'order' => 'ASC'
));

echo "<table border='1' cellpadding='10' cellspacing='0'>";
echo "<tr><th>ID</th><th>Name</th><th>Order</th><th>Position</th><th>Email</th></tr>";

if ($frontend_query->have_posts()) {
    while ($frontend_query->have_posts()) {
        $frontend_query->the_post();
        $post_id = get_the_ID();
        
        $position = get_post_meta($post_id, '_member_position', true);
        $email = get_post_meta($post_id, '_member_email', true);
        $order = get_post_field('menu_order', $post_id);
        
        echo "<tr>";
        echo "<td>" . $post_id . "</td>";
        echo "<td>" . get_the_title() . "</td>";
        echo "<td>" . $order . "</td>";
        echo "<td>" . ($position ? $position : 'Not set') . "</td>";
        echo "<td>" . ($email ? $email : 'Not set') . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No committee members match the frontend criteria</td></tr>";
}

echo "</table>";

wp_reset_postdata();

echo "<h2>Instructions:</h2>";
echo "<p>For a committee member to show on the frontend, they need:</p>";
echo "<ul>";
echo "<li>Post Status: <strong>Published</strong></li>";
echo "<li>Member Status: <strong>active</strong></li>";
echo "<li>Member Term: <strong>2025-2026</strong></li>";
echo "<li>Menu Order: Set to desired position number</li>";
echo "</ul>";

echo "<p>If Lim Lee Min is missing, check these fields in the WordPress admin under Committee Members.</p>";
?>

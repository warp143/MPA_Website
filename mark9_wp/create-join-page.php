<?php
require_once('wp-config.php');
require_once('wp-load.php');

// Create the Join page
$join_page_data = array(
    'post_title'    => 'Join MPA',
    'post_name'     => 'join',
    'post_content'  => 'This page content is managed by the template.',
    'post_status'   => 'publish',
    'post_type'     => 'page'
);

$join_page_id = wp_insert_post($join_page_data);

if ($join_page_id) {
    echo "Join page created successfully with ID: $join_page_id\n";
} else {
    echo "Failed to create Join page\n";
}
?>

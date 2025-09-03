<?php
require_once('wp-config.php');
require_once('wp-load.php');

// Create the Old Members page
$page_data = array(
    'post_title'    => 'Previous Committee Members',
    'post_name'     => 'old-members',
    'post_content'  => 'This page content is managed by the template.',
    'post_status'   => 'publish',
    'post_type'     => 'page'
);

$page_id = wp_insert_post($page_data);

if ($page_id) {
    echo "Old Members page created successfully with ID: $page_id\n";
} else {
    echo "Failed to create Old Members page\n";
}
?>

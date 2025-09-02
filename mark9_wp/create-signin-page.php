<?php
require_once('wp-config.php');
require_once('wp-load.php');

// Create the Sign In page
$signin_page_data = array(
    'post_title'    => 'Sign In',
    'post_name'     => 'signin',
    'post_content'  => 'This page content is managed by the template.',
    'post_status'   => 'publish',
    'post_type'     => 'page'
);

$signin_page_id = wp_insert_post($signin_page_data);

if ($signin_page_id) {
    echo "Sign In page created successfully with ID: $signin_page_id\n";
} else {
    echo "Failed to create Sign In page\n";
}
?>

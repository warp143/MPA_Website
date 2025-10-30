<?php
require_once('wp-config.php');
require_once('wp-load.php');

// Create the Events page
$events_page_data = array(
    'post_title'    => 'Events',
    'post_name'     => 'events',
    'post_content'  => 'This page content is managed by the template.',
    'post_status'   => 'publish',
    'post_type'     => 'page'
);

$events_page_id = wp_insert_post($events_page_data);

// Create the News page
$news_page_data = array(
    'post_title'    => 'News',
    'post_name'     => 'news',
    'post_content'  => 'This page content is managed by the template.',
    'post_status'   => 'publish',
    'post_type'     => 'page'
);

$news_page_id = wp_insert_post($news_page_data);

if ($events_page_id) {
    echo "Events page created successfully with ID: $events_page_id\n";
} else {
    echo "Failed to create Events page\n";
}

if ($news_page_id) {
    echo "News page created successfully with ID: $news_page_id\n";
} else {
    echo "Failed to create News page\n";
}
?>

<?php
/**
 * Search Handler for Homepage
 * Searches events, members, and posts
 */

// Prevent any output before JSON
ob_start();

// Load WordPress
define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');

// Clear any buffered output
ob_end_clean();

// Set JSON header
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$query = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';

if (empty($query)) {
    echo json_encode(['error' => 'No search query provided', 'events' => [], 'members' => [], 'posts' => [], 'total' => 0]);
    exit;
}

$results = array(
    'events' => array(),
    'members' => array(),
    'posts' => array(),
    'total' => 0
);

// Search Events
$events_query = new WP_Query(array(
    'post_type' => 'mpa_event',
    's' => $query,
    'posts_per_page' => 5,
    'post_status' => 'publish'
));

if ($events_query->have_posts()) {
    while ($events_query->have_posts()) {
        $events_query->the_post();
        $event_id = get_the_ID();
        $event_date = get_post_meta($event_id, '_event_date', true);
        
        $results['events'][] = array(
            'id' => $event_id,
            'title' => get_the_title(),
            'excerpt' => wp_trim_words(get_the_excerpt(), 20),
            'url' => get_permalink(),
            'date' => $event_date
        );
    }
    wp_reset_postdata();
}

// Search Members
$members_query = new WP_Query(array(
    'post_type' => 'mpa_member',
    's' => $query,
    'posts_per_page' => 5,
    'post_status' => 'publish'
));

if ($members_query->have_posts()) {
    while ($members_query->have_posts()) {
        $members_query->the_post();
        $member_id = get_the_ID();
        $website = get_post_meta($member_id, '_member_website', true);
        $vertical = get_post_meta($member_id, '_member_vertical', true);
        $logo_id = get_post_thumbnail_id($member_id);
        $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'thumbnail') : '';
        
        $results['members'][] = array(
            'id' => $member_id,
            'title' => get_the_title(),
            'excerpt' => wp_trim_words(get_the_content(), 15),
            'url' => home_url('/members/'),
            'website' => $website,
            'vertical' => $vertical,
            'logo' => $logo_url
        );
    }
    wp_reset_postdata();
}

// Search Posts/News
$posts_query = new WP_Query(array(
    'post_type' => 'post',
    's' => $query,
    'posts_per_page' => 5,
    'post_status' => 'publish'
));

if ($posts_query->have_posts()) {
    while ($posts_query->have_posts()) {
        $posts_query->the_post();
        
        $results['posts'][] = array(
            'id' => get_the_ID(),
            'title' => get_the_title(),
            'excerpt' => wp_trim_words(get_the_excerpt(), 20),
            'url' => get_permalink(),
            'date' => get_the_date()
        );
    }
    wp_reset_postdata();
}

$results['total'] = count($results['events']) + count($results['members']) + count($results['posts']);

echo json_encode($results, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
exit;

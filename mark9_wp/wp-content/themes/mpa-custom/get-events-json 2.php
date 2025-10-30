<?php
// get-events-json.php - Provide events as JSON for calendar
require_once('../../../wp-config.php');
require_once('../../../wp-load.php');

header('Content-Type: application/json');

// Get all events
$events = get_posts(array(
    'post_type' => 'mpa_event',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'meta_key' => '_event_date',
    'orderby' => 'meta_value',
    'order' => 'ASC'
));

$events_data = array();

foreach ($events as $event) {
    $event_date = get_post_meta($event->ID, '_event_date', true);
    $event_type = get_post_meta($event->ID, '_event_type', true);
    $event_location = get_post_meta($event->ID, '_event_location', true);
    $event_price = get_post_meta($event->ID, '_event_price', true);
    $event_status = get_post_meta($event->ID, '_event_status', true);
    $event_start_time = get_post_meta($event->ID, '_event_start_time', true);
    $event_end_time = get_post_meta($event->ID, '_event_end_time', true);
    
    // Get featured image URL
    $featured_image = '';
    if (has_post_thumbnail($event->ID)) {
        $featured_image = get_the_post_thumbnail_url($event->ID, 'medium');
    } else {
        // Use placeholder if no featured image
        $featured_image = get_template_directory_uri() . '/assets/placeholder-event.svg';
    }
    
    if ($event_date) {
        $events_data[] = array(
            'id' => $event->ID,
            'date' => $event_date,
            'title' => $event->post_title,
            'type' => $event_type ?: 'event',
            'description' => wp_trim_words($event->post_content, 20),
            'location' => $event_location ?: 'TBD',
            'price' => $event_price ?: 'Free',
            'status' => ($event_status === 'featured') ? 'upcoming' : ($event_status ?: 'upcoming'),
            'original_status' => $event_status, // Debug: keep original status for troubleshooting
            'start_time' => $event_start_time ?: '',
            'end_time' => $event_end_time ?: '',
            'featured_image' => $featured_image,
            'excerpt' => get_the_excerpt($event->ID) ?: wp_trim_words($event->post_content, 25)
        );
    }
}

echo json_encode($events_data);
?>

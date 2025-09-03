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
    
    if ($event_date) {
        $events_data[] = array(
            'date' => $event_date,
            'title' => $event->post_title,
            'type' => $event_type ?: 'event',
            'description' => wp_trim_words($event->post_content, 20)
        );
    }
}

echo json_encode($events_data);
?>

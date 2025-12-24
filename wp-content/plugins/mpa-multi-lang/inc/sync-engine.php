<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Sync Engine: Propagates non-translatable metadata between linked posts
 */
class MPA_Sync_Engine {

    // List of keys to sync (non-translatable)
    private $keys_to_sync = [
        '_thumbnail_id',       // Featured Image
        '_wp_page_template',    // Page Template
        // Add other ACF or global keys here
    ];

    public function __construct() {
        add_action('save_post', [$this, 'sync_linked_meta'], 20, 2);
    }

    /**
     * When a post is saved, sync its specific meta keys to all other posts in the group
     */
    public function sync_linked_meta($post_id, $post) {
        // Prevent infinite loops
        static $is_syncing = false;
        if ($is_syncing) return;

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if ($post->post_status === 'auto-draft') return;

        // Get Group ID
        $group_id = get_post_meta($post_id, '_mpa_translation_group_id', true);
        if (!$group_id) return;

        $is_syncing = true;

        // Find sibling posts
        $siblings = get_posts([
            'post_type' => $post->post_type,
            'meta_key' => '_mpa_translation_group_id',
            'meta_value' => $group_id,
            'post__not_in' => [$post_id],
            'fields' => 'ids',
            'posts_per_page' => -1,
            'post_status' => 'any',
        ]);

        if ($siblings) {
            foreach ($this->keys_to_sync as $key) {
                $value = get_post_meta($post_id, $key, true);
                
                foreach ($siblings as $sibling_id) {
                    if ($value !== '') {
                        update_post_meta($sibling_id, $key, $value);
                    } else {
                        delete_post_meta($sibling_id, $key);
                    }
                }
            }
        }

        $is_syncing = false;
    }
}

new MPA_Sync_Engine();

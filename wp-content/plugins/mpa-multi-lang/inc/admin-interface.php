<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle Admin Metaboxes for Translation Linking
 */
class MPA_Admin_Interface {

    public function __construct() {
        add_action('add_meta_boxes', [$this, 'add_translation_metabox']);
        add_action('save_post', [$this, 'save_translation_data']);
    }

    public function add_translation_metabox() {
        add_meta_box(
            'mpa_translation_box',
            'MPA Translations',
            [$this, 'render_metabox'],
            ['page', 'post', 'mpa_event'],
            'side',
            'high'
        );
    }

    public function render_metabox($post) {
        wp_nonce_field('mpa_translation_save', 'mpa_translation_nonce');

        // 1. Current Language
        $terms = get_the_terms($post->ID, 'mpa_language');
        $current_lang = ($terms && !is_wp_error($terms)) ? $terms[0]->slug : 'en';
        
        // 2. Group ID
        $group_id = get_post_meta($post->ID, '_mpa_translation_group_id', true);
        if (!$group_id) {
            $group_id = uniqid('mpa_'); 
            // We don't save iterating uniqid immediately to avoid ghost groups, 
            // but we display it if needed or generate one on save if linking.
            // For display, let's treat "Make new group" as default logic.
        }

        // 3. Find Linked Posts in this Group
        $linked_posts = [];
        if (get_post_meta($post->ID, '_mpa_translation_group_id', true)) {
            $args = [
                'post_type' => ['page', 'post', 'mpa_event'],
                'meta_key' => '_mpa_translation_group_id',
                'meta_value' => $group_id,
                'post__not_in' => [$post->ID],
                'ignore_sticky_posts' => true,
                'no_found_rows' => true
            ];
            $query = new WP_Query($args);
            $linked_posts = $query->posts;
        }

        ?>
        <div class="mpa-trans-box">
            <p><strong>Current/Language:</strong></p>
            <select name="mpa_post_language" style="width:100%">
                <option value="en" <?php selected($current_lang, 'en'); ?>>🇬🇧 English (EN)</option>
                <option value="ms" <?php selected($current_lang, 'ms'); ?>>🇲🇾 Malay (MS)</option>
                <option value="zh" <?php selected($current_lang, 'zh'); ?>>🇨🇳 Chinese (ZH)</option>
            </select>

            <hr>
            
            <p><strong>Linked Translations:</strong></p>
            <?php if ($linked_posts): ?>
                <ul>
                <?php foreach ($linked_posts as $lp): 
                    $l_terms = get_the_terms($lp->ID, 'mpa_language');
                    $l_lang = ($l_terms) ? $l_terms[0]->slug : '?';
                    echo '<li>[' . strtoupper($l_lang) . '] <a href="'.get_edit_post_link($lp->ID).'">'.get_the_title($lp->ID).'</a></li>';
                endforeach; ?>
                </ul>
            <?php else: ?>
                <p><em>No linked translations found.</em></p>
            <?php endif; ?>

            <hr>

            <p><strong>Link to Post ID:</strong></p>
            <input type="number" name="mpa_link_post_id" placeholder="Enter Post ID to link" style="width:100%">
            <p class="description">Enter the ID of an existing post to link it to this one. They will share a Translation Group.</p>
        </div>
        <?php
    }

    public function save_translation_data($post_id) {
        if (!isset($_POST['mpa_translation_nonce']) || 
            !wp_verify_nonce($_POST['mpa_translation_nonce'], 'mpa_translation_save')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

        // 1. Save Language
        if (isset($_POST['mpa_post_language'])) {
            wp_set_object_terms($post_id, $_POST['mpa_post_language'], 'mpa_language');
        }

        // 2. Handle Linking
        if (!empty($_POST['mpa_link_post_id'])) {
            $target_id = intval($_POST['mpa_link_post_id']);
            $target_post = get_post($target_id);

            if ($target_post) {
                // Logic: Merging Groups
                // Check if current post has group
                $my_group = get_post_meta($post_id, '_mpa_translation_group_id', true);
                // Check if target has group
                $target_group = get_post_meta($target_id, '_mpa_translation_group_id', true);

                if ($my_group && !$target_group) {
                    // Add target to my group
                    update_post_meta($target_id, '_mpa_translation_group_id', $my_group);
                } elseif (!$my_group && $target_group) {
                    // Join target's group
                    update_post_meta($post_id, '_mpa_translation_group_id', $target_group);
                } elseif ($my_group && $target_group && $my_group !== $target_group) {
                    // Conflict! For now, adopt target's group? Or merge?
                    // Simple logic: Adopt target's group.
                    update_post_meta($post_id, '_mpa_translation_group_id', $target_group);
                    // Also update all my old group members to new group?
                    // Left as TODO for robustness.
                } elseif (!$my_group && !$target_group) {
                    // Create new group for both
                    $new_group = uniqid('mpa_');
                    update_post_meta($post_id, '_mpa_translation_group_id', $new_group);
                    update_post_meta($target_id, '_mpa_translation_group_id', $new_group);
                }
            }
        } else {
            // Ensure I have a group ID if I am setting a language? 
            // Ideally specific language posts should have a group ID even if alone, 
            // so they are ready to be linked.
            $my_group = get_post_meta($post_id, '_mpa_translation_group_id', true);
            if (!$my_group) {
                update_post_meta($post_id, '_mpa_translation_group_id', uniqid('mpa_'));
            }
        }
    }
}

new MPA_Admin_Interface();

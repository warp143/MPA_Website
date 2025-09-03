<?php
/**
 * Committee Members Migration Script
 * 
 * This script migrates hardcoded committee members to the database.
 * Run this once after setting up the committee post type.
 * 
 * Usage: Access this file via browser: /wp-content/themes/mpa-custom/migrate-committee-members.php
 */

// Load WordPress
require_once('../../../wp-config.php');
require_once('../../../wp-load.php');

// Check if user is admin
if (!current_user_can('manage_options')) {
    die('Access denied. Admin privileges required.');
}

// Committee members data (extracted from the original hardcoded template)
$committee_members = array(
    array(
        'name' => 'Dr. Daniele Gambero',
        'position' => 'President',
        'bio' => "• Provide strategic leadership to achieve association goals and OKRs\n• Represent the association in national and international forums\n• Drive policy advocacy and industry influence\n• Ensure alignment of all committees towards mission and revenue targets",
        'website' => 'https://propenomy.com/',
        'email' => 'presidency@proptech.org.my',
        'linkedin' => 'https://www.linkedin.com/in/propenomist/',
        'image' => 'wp-content_uploads_2024_07_Daniele-Gambero.webp',
        'order' => 1
    ),
    array(
        'name' => 'Jason Ding',
        'position' => 'Deputy President',
        'bio' => "• Support President in strategic planning and execution\n• Oversee cross-committee collaboration and ensure timely deliverables\n• Lead special projects (e.g., high-level partnerships, cross-border initiatives)",
        'website' => 'https://mhub.my/',
        'email' => 'info@proptech.org.my',
        'linkedin' => 'https://www.linkedin.com/in/jasondjs/',
        'image' => 'wp-content_uploads_2021_01_jason-ding.webp',
        'order' => 2
    ),
    array(
        'name' => 'Dr. Darren Yaw',
        'position' => 'Vice President',
        'bio' => "• Support the President in strategic initiatives and decision-making\n• Lead specific committees and working groups\n• Act as President in their absence\n• Drive member engagement and retention strategies",
        'website' => 'https://www.speedhome.com',
        'email' => 'darren@speedhome.com',
        'linkedin' => 'https://www.linkedin.com/in/darrenyaw/',
        'image' => 'wp-content_uploads_2024_07_Darren-Yaw.webp',
        'order' => 3
    ),
    array(
        'name' => 'Wong Keh Wei',
        'position' => 'Secretary General',
        'bio' => "• Oversee governance, compliance, and documentation\n• Ensure smooth communication between committees and members\n• Maintain updated association policies and procedures",
        'website' => 'https://www.rentlab.com.my',
        'email' => 'secretariat@proptech.org.my',
        'linkedin' => 'https://www.linkedin.com/in/wongkw33',
        'image' => 'wp-content_uploads_2021_08_KW_Wong.png',
        'order' => 4
    ),
    array(
        'name' => 'Liz Ang Gaik See',
        'position' => 'Treasurer',
        'bio' => "• Manage financial planning, budgeting, and reporting\n• Ensure proper allocation of event and operational funds\n• Drive financial sustainability and transparency",
        'website' => 'https://www.imortgage2u.com/promo/',
        'email' => 'liz.ang@techapp.com.my',
        'linkedin' => 'https://www.linkedin.com/in/liz-ang-140506117/',
        'image' => 'wp-content_uploads_2021_01_Liz-Ang.webp',
        'order' => 5
    ),
    array(
        'name' => 'Angela Kew Chui Teen',
        'position' => 'Membership',
        'bio' => "• Develop and implement member acquisition strategies\n• Manage member onboarding, engagement, and retention programs\n• Coordinate member benefits and value-added services",
        'website' => 'https://www.speedhome.com',
        'email' => 'angela@speedhome.com',
        'linkedin' => 'https://www.linkedin.com/in/angelakew/',
        'image' => 'wp-content_uploads_2021_08_Angela_Kew.png',
        'order' => 6
    ),
    array(
        'name' => 'Andrew Michael Kho',
        'position' => 'Events, Marketing & Communication, Tech & Innovation',
        'bio' => "• Plan and execute small to large-scale events (Tech Talk, PropTech Connect, Annual Dinner)\n• Manage brand, PR, and digital communication strategy\n• Oversee PropTech-related initiatives, innovation showcases, and knowledge sharing\n• Drive adoption of new tech tools for members and the association",
        'website' => 'https://www.homesifu.io',
        'email' => 'amk@homesifu.io',
        'linkedin' => 'https://www.linkedin.com/in/andrewmichaelkho/',
        'image' => 'Andrew.png',
        'order' => 7
    ),
    array(
        'name' => 'Azlan Bin Zainuddin',
        'position' => 'Tech & Innovation',
        'bio' => "• Oversee PropTech-related initiatives, innovation showcases, and knowledge sharing\n• Drive adoption of new tech tools for members and the association",
        'website' => 'https://www.aivot.my',
        'email' => 'azlan@aivot.my',
        'linkedin' => 'https://www.linkedin.com/in/azlan-zainuddin',
        'image' => 'wp-content_uploads_2021_01_azlan-zainuddin.webp',
        'order' => 8
    ),
    array(
        'name' => 'Lim Sook Khim',
        'position' => 'Sponsorship',
        'bio' => "• Identify and secure sponsorship for events and initiatives\n• Build long-term relationships with corporate sponsors",
        'website' => '',
        'email' => 'info@proptech.org.my',
        'linkedin' => '',
        'image' => 'lim-sook-khim.jpeg',
        'order' => 9
    ),
    array(
        'name' => 'Dato\' Joseph Hii W S',
        'position' => 'Sponsorship, Partnership',
        'bio' => "• Identify and secure sponsorship for events and initiatives\n• Build long-term relationships with corporate sponsors\n• Develop collaborations with industry associations, academia, government agencies, and international PropTech bodies\n• Create cross-promotional and co-hosted event opportunities",
        'website' => '',
        'email' => 'joehws1308@gmail.com',
        'linkedin' => '',
        'image' => '',
        'order' => 10
    )
);

echo "<h1>Committee Members Migration</h1>";
echo "<p>Migrating " . count($committee_members) . " committee members...</p>";

$success_count = 0;
$error_count = 0;

foreach ($committee_members as $member) {
    echo "<h3>Processing: " . esc_html($member['name']) . "</h3>";
    
    try {
        // Create the post
        $post_data = array(
            'post_title'    => $member['name'],
            'post_content'  => $member['bio'],
            'post_status'   => 'publish',
            'post_type'     => 'mpa_committee',
            'menu_order'    => $member['order']
        );
        
        $post_id = wp_insert_post($post_data);
        
        if (is_wp_error($post_id)) {
            throw new Exception($post_id->get_error_message());
        }
        
        // Add meta fields
        update_post_meta($post_id, '_member_position', $member['position']);
        update_post_meta($post_id, '_member_term', '2025-2026');
        update_post_meta($post_id, '_member_status', 'active');
        update_post_meta($post_id, '_member_website', $member['website']);
        update_post_meta($post_id, '_member_email', $member['email']);
        update_post_meta($post_id, '_member_linkedin', $member['linkedin']);
        
        // Handle image if exists
        if (!empty($member['image'])) {
            $image_path = get_template_directory() . '/assets/' . $member['image'];
            if (file_exists($image_path)) {
                // Create attachment
                $attachment_id = create_attachment_from_file($image_path, $post_id, $member['name']);
                if ($attachment_id) {
                    set_post_thumbnail($post_id, $attachment_id);
                    echo "<p style='color: green;'>✓ Created with image: " . $member['image'] . "</p>";
                } else {
                    echo "<p style='color: orange;'>⚠ Created without image (upload failed): " . $member['image'] . "</p>";
                }
            } else {
                echo "<p style='color: orange;'>⚠ Created without image (file not found): " . $member['image'] . "</p>";
            }
        } else {
            echo "<p style='color: green;'>✓ Created without image</p>";
        }
        
        $success_count++;
        echo "<p style='color: green;'>✓ Successfully created member ID: " . $post_id . "</p>";
        
    } catch (Exception $e) {
        $error_count++;
        echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
    }
    
    echo "<hr>";
}

echo "<h2>Migration Complete!</h2>";
echo "<p><strong>Success:</strong> " . $success_count . " members created</p>";
echo "<p><strong>Errors:</strong> " . $error_count . " members failed</p>";

if ($success_count > 0) {
    echo "<p style='color: green; font-weight: bold;'>✓ You can now manage committee members in WordPress Admin → Committee</p>";
    echo "<p><a href='/wp-admin/edit.php?post_type=mpa_committee' target='_blank'>View Committee Members in Admin</a></p>";
}

/**
 * Helper function to create attachment from file
 */
function create_attachment_from_file($file_path, $parent_post_id, $title) {
    if (!file_exists($file_path)) {
        return false;
    }
    
    $upload_dir = wp_upload_dir();
    $filename = basename($file_path);
    $new_file_path = $upload_dir['path'] . '/' . $filename;
    
    // Copy file to uploads directory
    if (!copy($file_path, $new_file_path)) {
        return false;
    }
    
    // Create attachment
    $attachment = array(
        'guid'           => $upload_dir['url'] . '/' . $filename,
        'post_mime_type' => wp_check_filetype($filename, null)['type'],
        'post_title'     => $title,
        'post_content'   => '',
        'post_status'    => 'inherit'
    );
    
    $attachment_id = wp_insert_attachment($attachment, $new_file_path, $parent_post_id);
    
    if (!is_wp_error($attachment_id)) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attachment_data = wp_generate_attachment_metadata($attachment_id, $new_file_path);
        wp_update_attachment_metadata($attachment_id, $attachment_data);
        return $attachment_id;
    }
    
    return false;
}

echo "<p><strong>Note:</strong> You can delete this migration script after running it successfully.</p>";
?>

<?php
/**
 * Fix Profile Builder Plugin PHP 8.3 Compatibility
 * This script patches the problematic file to fix the "Cannot access offset of type string on string" error
 */

$plugin_file = '/var/www/html/wp-content/plugins/profile-builder/front-end/default-fields/default-fields.php';

echo "🔧 Fixing Profile Builder Plugin PHP 8.3 Compatibility...\n";

// Read the current file
$content = file_get_contents($plugin_file);
if ($content === false) {
    echo "❌ Could not read plugin file\n";
    exit(1);
}

// Fix the problematic line - add proper type checking
$old_line = '$wppb_generalSettings = get_option(\'wppb_general_settings\', \'not_found\' );';
$new_line = '$wppb_generalSettings = get_option(\'wppb_general_settings\', \'not_found\' );
    if ( !is_array( $wppb_generalSettings ) ) {
        $wppb_generalSettings = array();
    }';

$content = str_replace($old_line, $new_line, $content);

// Also fix the array access issue
$old_condition = 'if ( ( $wppb_generalSettings != \'not_found\' ) && ( $wppb_generalSettings[\'loginWith\'] != \'email\' ) )';
$new_condition = 'if ( ( $wppb_generalSettings != \'not_found\' ) && is_array($wppb_generalSettings) && isset($wppb_generalSettings[\'loginWith\']) && ( $wppb_generalSettings[\'loginWith\'] != \'email\' ) )';

$content = str_replace($old_condition, $new_condition, $content);

// Write the fixed file
if (file_put_contents($plugin_file, $content) === false) {
    echo "❌ Could not write fixed file\n";
    exit(1);
}

echo "✅ Profile Builder Plugin fixed for PHP 8.3 compatibility!\n";
echo "🔄 WordPress admin should now be accessible\n";
?>

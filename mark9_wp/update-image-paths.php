<?php
$file_path = 'wp-content/themes/mpa-custom/page-old-members.php';
$content = file_get_contents($file_path);

// Replace all remaining external image URLs with local paths
$replacements = [
    'https://proptech.org.my/wp-content/uploads/2021/01/jacky-chuah.webp' => '<?php echo get_template_directory_uri(); ?>/assets/old-members/jacky-chuah.webp',
    'https://proptech.org.my/wp-content/uploads/2021/01/Liz-Ang.webp' => '<?php echo get_template_directory_uri(); ?>/assets/old-members/liz-ang.webp',
    'https://proptech.org.my/wp-content/uploads/2021/08/Angela_Kew.png' => '<?php echo get_template_directory_uri(); ?>/assets/old-members/angela-kew.png',
    'https://proptech.org.my/wp-content/uploads/2021/01/Michele-Tan.webp' => '<?php echo get_template_directory_uri(); ?>/assets/old-members/michele-tan.webp',
    'https://proptech.org.my/wp-content/uploads/2024/07/Naga-R-Krishnan-.webp' => '<?php echo get_template_directory_uri(); ?>/assets/old-members/naga-krishnan.webp',
    'https://proptech.org.my/wp-content/uploads/2021/01/aiden-teh.webp' => '<?php echo get_template_directory_uri(); ?>/assets/old-members/aiden-teh.webp',
    'https://proptech.org.my/wp-content/uploads/2021/01/benny-wee.webp' => '<?php echo get_template_directory_uri(); ?>/assets/old-members/benny-wee.webp',
    'https://proptech.org.my/wp-content/uploads/2021/01/azlan-zainuddin.webp' => '<?php echo get_template_directory_uri(); ?>/assets/old-members/azlan-zainuddin.webp',
    'https://proptech.org.my/wp-content/uploads/2021/01/christina-leong.webp' => '<?php echo get_template_directory_uri(); ?>/assets/old-members/christina-leong.webp',
    'https://proptech.org.my/wp-content/uploads/2021/08/Tharma.png' => '<?php echo get_template_directory_uri(); ?>/assets/old-members/tharma-gannasin.png'
];

foreach ($replacements as $search => $replace) {
    $content = str_replace($search, $replace, $content);
}

file_put_contents($file_path, $content);
echo "Image paths updated successfully!\n";
?>

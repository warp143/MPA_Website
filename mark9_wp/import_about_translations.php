<?php
/**
 * Import About section translations
 */

define('WP_USE_THEMES', false);
require('./wp-load.php');

global $wpdb;
$table = $wpdb->prefix . 'mpa_translations';

// About section translations
$about_translations = [
    // About heading
    ['about-heading', 'en', 'For The Future of A Sustainable Property Market', 'About Section'],
    ['about-heading', 'bm', 'Untuk Masa Depan Pasaran Hartanah yang Mampan', 'About Section'],
    ['about-heading', 'cn', '为可持续房地产市场的未来', 'About Section'],
    
    // About intro paragraph
    ['about-intro', 'en', 'Malaysia Proptech Association Leads The Digital Transformation of the Built Environment in Malaysia and beyond, through innovation, collaboration, and sustainable growth. Building a strong community with integrity, inclusivity, and equality.', 'About Section'],
    ['about-intro', 'bm', 'Persatuan PropTech Malaysia Memimpin Transformasi Digital Alam Bina di Malaysia dan seterusnya, melalui inovasi, kerjasama, dan pertumbuhan mampan. Membina komuniti yang kuat dengan integriti, inklusiviti, dan kesaksamaan.', 'About Section'],
    ['about-intro', 'cn', '马来西亚房地产科技协会通过创新、协作和可持续增长，引领马来西亚及更广泛的建筑环境的数字化转型。以诚信、包容性和平等性建立强大社区。', 'About Section'],
    
    // About MPA description
    ['about-mpa-desc', 'en', 'The Malaysia PropTech Association (MPA) is the driving force behind Malaysia\'s digital transformation in the built environment. We unite startups, scale-ups, corporates, investors, and government stakeholders to shape a smarter, more inclusive property ecosystem.', 'About Section'],
    ['about-mpa-desc', 'bm', 'Persatuan PropTech Malaysia (MPA) adalah pemacu utama transformasi digital Malaysia dalam alam bina. Kami menyatukan syarikat permulaan, syarikat berkembang, korporat, pelabur, dan pemegang taruh kerajaan untuk membentuk ekosistem hartanah yang lebih pintar dan inklusif.', 'About Section'],
    ['about-mpa-desc', 'cn', '马来西亚房地产科技协会（MPA）是推动马来西亚建筑环境数字化转型的主要力量。我们联合初创企业、成长型企业、企业、投资者和政府利益相关者，塑造更智能、更具包容性的房地产生态系统。', 'About Section'],
    
    // Mission statement
    ['about-mission', 'en', 'Our mission is to accelerate innovation, foster collaboration, and empower a new generation of tech-driven leaders in the built environment!', 'About Section'],
    ['about-mission', 'bm', 'Misi kami adalah untuk mempercepat inovasi, memupuk kerjasama, dan memperkasakan generasi baru pemimpin berasaskan teknologi dalam alam bina!', 'About Section'],
    ['about-mission', 'cn', '我们的使命是加速创新，促进协作，并在建筑环境中培养新一代技术驱动型领导者！', 'About Section'],
    
    // Belief statement
    ['about-belief', 'en', 'We believe that transformation must be rooted in integrity, inclusivity, and shared progress.', 'About Section'],
    ['about-belief', 'bm', 'Kami percaya bahawa transformasi mesti berakar umbi dalam integriti, inklusiviti, dan kemajuan bersama.', 'About Section'],
    ['about-belief', 'cn', '我们相信转型必须植根于诚信、包容性和共同进步。', 'About Section'],
    
    // Call to action
    ['about-cta', 'en', 'Together, we\'re shaping the built environment of the future!', 'About Section'],
    ['about-cta', 'bm', 'Bersama-sama, kami membentuk alam bina masa depan!', 'About Section'],
    ['about-cta', 'cn', '我们共同塑造未来的建筑环境！', 'About Section'],
    
    // Strategic Anchors heading
    ['strategic-anchors-heading', 'en', 'MPA\'s work is guided by five Strategic Anchors, the pillars that define our purpose and drive our outcomes!', 'About Section'],
    ['strategic-anchors-heading', 'bm', 'Kerja MPA dipandu oleh lima Penjuru Strategik, tiang yang menentukan tujuan kami dan memacu hasil kami!', 'About Section'],
    ['strategic-anchors-heading', 'cn', 'MPA的工作由五个战略支柱指导，这些支柱定义了我们的目标并推动我们的成果！', 'About Section'],
    
    // Fix pillar 5 description (it was hardcoded)
    ['pillar_5_desc', 'en', 'Equipping the industry with knowledge, tools, and future-ready skills', 'Strategic Pillars'],
    ['pillar_5_desc', 'bm', 'Melengkapkan industri dengan pengetahuan, alat, dan kemahiran masa depan', 'Strategic Pillars'],
    ['pillar_5_desc', 'cn', '为行业提供知识、工具和面向未来的技能', 'Strategic Pillars'],
];

$imported = 0;
foreach ($about_translations as $item) {
    $result = $wpdb->replace($table, [
        'translation_key' => $item[0],
        'lang' => $item[1],
        'value' => $item[2],
        'context' => $item[3],
        'modified_by' => 1,
        'last_modified' => current_time('mysql')
    ]);
    if ($result) $imported++;
}

echo "✅ Imported $imported about section translations\n";

// Verify
$count = $wpdb->get_var("SELECT COUNT(*) FROM $table");
echo "Total translations in database: $count\n";


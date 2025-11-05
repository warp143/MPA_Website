<?php
/**
 * Database operations for MPA Translation Manager
 */

class MPA_Translation_Database {
    
    public static function create_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'mpa_translations';
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id INT AUTO_INCREMENT PRIMARY KEY,
            translation_key VARCHAR(100) NOT NULL,
            lang VARCHAR(5) NOT NULL,
            value TEXT NOT NULL,
            context VARCHAR(255) DEFAULT NULL,
            last_modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            modified_by INT DEFAULT NULL,
            UNIQUE KEY unique_key_lang (translation_key, lang),
            INDEX idx_lang (lang),
            INDEX idx_key (translation_key)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
    public static function import_initial_data() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'mpa_translations';
        
        // Initial data for the 5 Strategic Pillars (from front-page.php)
        $initial_data = [
            // Pillar 1
            ['key' => 'pillar_1_title', 'lang' => 'en', 'value' => 'Advocacy', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_1_title', 'lang' => 'bm', 'value' => 'Advokasi', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_1_title', 'lang' => 'cn', 'value' => '倡导', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_1_desc', 'lang' => 'en', 'value' => 'Championing digitalization and policy reform across the industry', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_1_desc', 'lang' => 'bm', 'value' => 'Memperjuangkan digitalisasi dan pembaharuan dasar merentasi industri', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_1_desc', 'lang' => 'cn', 'value' => '倡导行业数字化和政策改革', 'context' => 'Strategic Pillars'],
            
            // Pillar 2
            ['key' => 'pillar_2_title', 'lang' => 'en', 'value' => 'Business Opportunities', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_2_title', 'lang' => 'bm', 'value' => 'Peluang Perniagaan', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_2_title', 'lang' => 'cn', 'value' => '商业机会', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_2_desc', 'lang' => 'en', 'value' => 'Connecting members to funding, partnerships, and market access', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_2_desc', 'lang' => 'bm', 'value' => 'Menghubungkan ahli kepada pembiayaan, perkongsian, dan akses pasaran', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_2_desc', 'lang' => 'cn', 'value' => '连接成员获取资金、合作伙伴和市场准入', 'context' => 'Strategic Pillars'],
            
            // Pillar 3
            ['key' => 'pillar_3_title', 'lang' => 'en', 'value' => 'Community', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_3_title', 'lang' => 'bm', 'value' => 'Komuniti', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_3_title', 'lang' => 'cn', 'value' => '社区', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_3_desc', 'lang' => 'en', 'value' => 'Building a vibrant collaborative ecosystem with innovators and changemakers', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_3_desc', 'lang' => 'bm', 'value' => 'Membina ekosistem kolaboratif yang bersemangat dengan inovator dan pengubah', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_3_desc', 'lang' => 'cn', 'value' => '与创新者和变革者建立充满活力的协作生态系统', 'context' => 'Strategic Pillars'],
            
            // Pillar 4
            ['key' => 'pillar_4_title', 'lang' => 'en', 'value' => 'Knowledge', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_4_title', 'lang' => 'bm', 'value' => 'Pengetahuan', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_4_title', 'lang' => 'cn', 'value' => '知识', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_4_desc', 'lang' => 'en', 'value' => 'Hosting training programs, workshops, and expert knowledge sharing', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_4_desc', 'lang' => 'bm', 'value' => 'Mengadakan program latihan, bengkel, dan perkongsian kepakaran', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_4_desc', 'lang' => 'cn', 'value' => '举办培训计划、研讨会和专家知识分享', 'context' => 'Strategic Pillars'],
            
            // Pillar 5
            ['key' => 'pillar_5_title', 'lang' => 'en', 'value' => 'Policy Advocacy', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_5_title', 'lang' => 'bm', 'value' => 'Advokasi Dasar', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_5_title', 'lang' => 'cn', 'value' => '政策倡导', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_5_desc', 'lang' => 'en', 'value' => 'Shaping regulatory frameworks for PropTech in Malaysia', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_5_desc', 'lang' => 'bm', 'value' => 'Membentuk rangka kerja peraturan untuk PropTech di Malaysia', 'context' => 'Strategic Pillars'],
            ['key' => 'pillar_5_desc', 'lang' => 'cn', 'value' => '塑造马来西亚房地产科技监管框架', 'context' => 'Strategic Pillars'],
        ];
        
        foreach ($initial_data as $item) {
            $wpdb->replace($table_name, [
                'translation_key' => $item['key'],
                'lang' => $item['lang'],
                'value' => $item['value'],
                'context' => $item['context'],
                'modified_by' => 1,
                'last_modified' => current_time('mysql')
            ]);
        }
    }
    
    public static function get_all_translations($lang) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'mpa_translations';
        
        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT translation_key, value FROM $table_name WHERE lang = %s",
            $lang
        ));
        
        $translations = [];
        foreach ($results as $row) {
            $translations[$row->translation_key] = $row->value;
        }
        
        return $translations;
    }
    
    public static function update_translation($key, $lang, $value, $user_id = null) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'mpa_translations';
        
        return $wpdb->replace($table_name, [
            'translation_key' => $key,
            'lang' => $lang,
            'value' => $value,
            'modified_by' => $user_id ?: get_current_user_id(),
            'last_modified' => current_time('mysql')
        ]);
    }
    
    public static function get_translation($key, $lang) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'mpa_translations';
        
        $value = $wpdb->get_var($wpdb->prepare(
            "SELECT value FROM $table_name WHERE translation_key = %s AND lang = %s",
            $key, $lang
        ));
        
        return $value ?: '';
    }
    
    public static function delete_translation($key, $lang) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'mpa_translations';
        
        return $wpdb->delete($table_name, [
            'translation_key' => $key,
            'lang' => $lang
        ]);
    }
    
    public static function get_all_keys() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'mpa_translations';
        
        $results = $wpdb->get_results("
            SELECT DISTINCT translation_key, context
            FROM $table_name
            ORDER BY context, translation_key
        ");
        
        return $results;
    }
}

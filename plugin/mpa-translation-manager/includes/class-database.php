<?php
/**
 * MPA Translation Database Class
 * Handles all database operations for translations
 */

if (!defined('ABSPATH')) {
    exit;
}

class MPA_Translation_Database {
    
    /**
     * Get table name
     */
    public static function get_table_name() {
        global $wpdb;
        return $wpdb->prefix . 'mpa_translations';
    }
    
    /**
     * Create translations table
     */
    public static function create_table() {
        global $wpdb;
        $table_name = self::get_table_name();
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
        
        // Verify table was created
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            error_log('MPA Translation Manager: Failed to create table ' . $table_name);
            return false;
        }
        
        return true;
    }
    
    /**
     * Get all translations for a specific language
     * 
     * @param string $lang Language code (en, bm, cn)
     * @return array Associative array of translation_key => value
     */
    public static function get_all_translations($lang) {
        global $wpdb;
        $table_name = self::get_table_name();
        
        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT translation_key, value FROM $table_name WHERE lang = %s ORDER BY translation_key ASC",
            $lang
        ));
        
        $translations = [];
        foreach ($results as $row) {
            $translations[$row->translation_key] = $row->value;
        }
        
        return $translations;
    }
    
    /**
     * Get a single translation
     * 
     * @param string $key Translation key
     * @param string $lang Language code
     * @return string|null Translation value or null if not found
     */
    public static function get_translation($key, $lang) {
        global $wpdb;
        $table_name = self::get_table_name();
        
        return $wpdb->get_var($wpdb->prepare(
            "SELECT value FROM $table_name WHERE translation_key = %s AND lang = %s",
            $key, $lang
        ));
    }
    
    /**
     * Get translation with full details (including metadata)
     * 
     * @param string $key Translation key
     * @param string $lang Language code
     * @return object|null Translation object or null if not found
     */
    public static function get_translation_full($key, $lang) {
        global $wpdb;
        $table_name = self::get_table_name();
        
        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_name WHERE translation_key = %s AND lang = %s",
            $key, $lang
        ));
    }
    
    /**
     * Update or insert a translation
     * 
     * @param string $key Translation key
     * @param string $lang Language code
     * @param string $value Translation value
     * @param int|null $user_id User ID who made the change
     * @param string|null $context Context/category for the translation
     * @return int|false Number of rows affected or false on error
     */
    public static function update_translation($key, $lang, $value, $user_id = null, $context = null) {
        global $wpdb;
        $table_name = self::get_table_name();
        
        // Check if translation exists
        $existing = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM $table_name WHERE translation_key = %s AND lang = %s",
            $key, $lang
        ));
        
        $data = [
            'translation_key' => $key,
            'lang' => $lang,
            'value' => $value,
            'modified_by' => $user_id ?: get_current_user_id(),
            'last_modified' => current_time('mysql')
        ];
        
        if ($context !== null) {
            $data['context'] = $context;
        }
        
        if ($existing) {
            // Update existing
            return $wpdb->update(
                $table_name,
                $data,
                ['id' => $existing],
                ['%s', '%s', '%s', '%d', '%s', '%s'],
                ['%d']
            );
        } else {
            // Insert new
            return $wpdb->insert(
                $table_name,
                $data,
                ['%s', '%s', '%s', '%d', '%s', '%s']
            );
        }
    }
    
    /**
     * Delete a translation
     * 
     * @param string $key Translation key
     * @param string $lang Language code (optional, if not provided deletes all languages)
     * @return int|false Number of rows deleted or false on error
     */
    public static function delete_translation($key, $lang = null) {
        global $wpdb;
        $table_name = self::get_table_name();
        
        if ($lang) {
            return $wpdb->delete($table_name, [
                'translation_key' => $key,
                'lang' => $lang
            ], ['%s', '%s']);
        } else {
            // Delete all languages for this key
            return $wpdb->delete($table_name, [
                'translation_key' => $key
            ], ['%s']);
        }
    }
    
    /**
     * Get all unique translation keys
     * 
     * @return array Array of translation keys
     */
    public static function get_all_keys() {
        global $wpdb;
        $table_name = self::get_table_name();
        
        $results = $wpdb->get_col(
            "SELECT DISTINCT translation_key FROM $table_name ORDER BY translation_key ASC"
        );
        
        return $results ?: [];
    }
    
    /**
     * Get translations grouped by key (all languages for each key)
     * 
     * @return array Associative array: key => ['en' => value, 'bm' => value, 'cn' => value]
     */
    public static function get_all_grouped() {
        global $wpdb;
        $table_name = self::get_table_name();
        
        $results = $wpdb->get_results(
            "SELECT translation_key, lang, value, context, last_modified, modified_by 
             FROM $table_name 
             ORDER BY translation_key ASC, lang ASC"
        );
        
        $grouped = [];
        foreach ($results as $row) {
            if (!isset($grouped[$row->translation_key])) {
                $grouped[$row->translation_key] = [
                    'en' => '',
                    'bm' => '',
                    'cn' => '',
                    'context' => $row->context,
                    'last_modified' => $row->last_modified,
                    'modified_by' => $row->modified_by
                ];
            }
            $grouped[$row->translation_key][$row->lang] = $row->value;
        }
        
        return $grouped;
    }
    
    /**
     * Get translation statistics
     * 
     * @return array Statistics about translations
     */
    public static function get_stats() {
        global $wpdb;
        $table_name = self::get_table_name();
        
        $stats = [
            'total' => 0,
            'by_language' => [],
            'unique_keys' => 0,
            'last_updated' => null
        ];
        
        // Total translations
        $stats['total'] = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
        
        // By language
        $lang_counts = $wpdb->get_results(
            "SELECT lang, COUNT(*) as count FROM $table_name GROUP BY lang"
        );
        foreach ($lang_counts as $row) {
            $stats['by_language'][$row->lang] = (int) $row->count;
        }
        
        // Unique keys
        $stats['unique_keys'] = $wpdb->get_var(
            "SELECT COUNT(DISTINCT translation_key) FROM $table_name"
        );
        
        // Last updated
        $stats['last_updated'] = $wpdb->get_var(
            "SELECT MAX(last_modified) FROM $table_name"
        );
        
        return $stats;
    }
    
    /**
     * Bulk insert translations
     * 
     * @param array $translations Array of translations [['key' => '', 'lang' => '', 'value' => '', 'context' => ''], ...]
     * @return array ['success' => int, 'failed' => int, 'errors' => array]
     */
    public static function bulk_insert($translations) {
        $success = 0;
        $failed = 0;
        $errors = [];
        
        foreach ($translations as $index => $trans) {
            if (empty($trans['key']) || empty($trans['lang']) || !isset($trans['value'])) {
                $failed++;
                $errors[] = "Row $index: Missing required fields";
                continue;
            }
            
            $result = self::update_translation(
                $trans['key'],
                $trans['lang'],
                $trans['value'],
                $trans['user_id'] ?? null,
                $trans['context'] ?? null
            );
            
            if ($result !== false) {
                $success++;
            } else {
                $failed++;
                $errors[] = "Row $index: Database error";
            }
        }
        
        return [
            'success' => $success,
            'failed' => $failed,
            'errors' => $errors
        ];
    }
}


<?php
/**
 * MPA Translation Migration Class
 * Handles import/export of translations
 */

if (!defined('ABSPATH')) {
    exit;
}

class MPA_Translation_Migration {
    
    /**
     * Export all translations to JSON
     * 
     * @param bool $download Whether to force download or return JSON string
     * @return string|void JSON string if $download is false
     */
    public static function export_json($download = true) {
        global $wpdb;
        $table_name = MPA_Translation_Database::get_table_name();
        
        $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY translation_key, lang");
        
        $export = [
            'version' => MPA_TRANS_VERSION,
            'exported_at' => current_time('mysql'),
            'site_url' => get_site_url(),
            'translations' => [
                'en' => [],
                'bm' => [],
                'cn' => []
            ]
        ];
        
        foreach ($results as $row) {
            $export['translations'][$row->lang][$row->translation_key] = $row->value;
        }
        
        $json = json_encode($export, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
        if ($download) {
            header('Content-Type: application/json');
            header('Content-Disposition: attachment; filename="mpa-translations-' . date('Y-m-d-His') . '.json"');
            header('Content-Length: ' . strlen($json));
            echo $json;
            exit;
        } else {
            return $json;
        }
    }
    
    /**
     * Import translations from JSON
     * 
     * @param string $json_string JSON string or file path
     * @param bool $overwrite Whether to overwrite existing translations
     * @return array ['success' => int, 'failed' => int, 'errors' => array, 'skipped' => int]
     */
    public static function import_json($json_string, $overwrite = false) {
        $success = 0;
        $failed = 0;
        $skipped = 0;
        $errors = [];
        
        // If it's a file path, read the file
        if (file_exists($json_string)) {
            $json_string = file_get_contents($json_string);
        }
        
        $data = json_decode($json_string, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'success' => 0,
                'failed' => 0,
                'skipped' => 0,
                'errors' => ['Invalid JSON: ' . json_last_error_msg()]
            ];
        }
        
        if (!isset($data['translations'])) {
            return [
                'success' => 0,
                'failed' => 0,
                'skipped' => 0,
                'errors' => ['Invalid format: missing "translations" key']
            ];
        }
        
        $translations = $data['translations'];
        
        foreach (['en', 'bm', 'cn'] as $lang) {
            if (!isset($translations[$lang])) {
                continue;
            }
            
            foreach ($translations[$lang] as $key => $value) {
                // Check if translation exists
                $existing = MPA_Translation_Database::get_translation($key, $lang);
                
                if ($existing && !$overwrite) {
                    $skipped++;
                    continue;
                }
                
                $result = MPA_Translation_Database::update_translation($key, $lang, $value);
                
                if ($result !== false) {
                    $success++;
                } else {
                    $failed++;
                    $errors[] = "Failed to import: $lang/$key";
                }
            }
        }
        
        return [
            'success' => $success,
            'failed' => $failed,
            'skipped' => $skipped,
            'errors' => $errors
        ];
    }
    
    /**
     * Import translations from the old JavaScript format
     * Specifically designed to import from main.js translations object
     * 
     * @param array $translations Translations array ['en' => [...], 'bm' => [...], 'cn' => [...]]
     * @return array Import results
     */
    public static function import_from_javascript($translations) {
        if (!is_array($translations)) {
            return [
                'success' => 0,
                'failed' => 0,
                'skipped' => 0,
                'errors' => ['Invalid input: expected array']
            ];
        }
        
        $import_data = [
            'version' => MPA_TRANS_VERSION,
            'exported_at' => current_time('mysql'),
            'site_url' => get_site_url(),
            'translations' => $translations
        ];
        
        return self::import_json(json_encode($import_data), true);
    }
    
    /**
     * Export translations to CSV
     * 
     * @param bool $download Whether to force download or return CSV string
     * @return string|void CSV string if $download is false
     */
    public static function export_csv($download = true) {
        $translations = MPA_Translation_Database::get_all_grouped();
        
        $csv = "Translation Key,English,Bahasa Malaysia,Chinese,Context\n";
        
        foreach ($translations as $key => $langs) {
            $context = MPA_Translation_Admin::get_context($key);
            $csv .= '"' . str_replace('"', '""', $key) . '",'
                 . '"' . str_replace('"', '""', $langs['en']) . '",'
                 . '"' . str_replace('"', '""', $langs['bm']) . '",'
                 . '"' . str_replace('"', '""', $langs['cn']) . '",'
                 . '"' . str_replace('"', '""', $context) . '"'
                 . "\n";
        }
        
        if ($download) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="mpa-translations-' . date('Y-m-d-His') . '.csv"');
            header('Content-Length: ' . strlen($csv));
            echo $csv;
            exit;
        } else {
            return $csv;
        }
    }
    
    /**
     * Generate migration script from live server main.js
     * This will output a PHP script that can be run to import translations
     * 
     * @return string PHP migration script
     */
    public static function generate_migration_script() {
        $script = '<?php
/**
 * MPA Translation Migration Script
 * Generated: ' . current_time('mysql') . '
 * 
 * Instructions:
 * 1. Copy the translations object from main.js
 * 2. Paste it into the $javascript_translations variable below
 * 3. Run this script via WP-CLI or browser (with admin access)
 */

// Load WordPress
require_once(__DIR__ . \'/../../wp-load.php\');

// Check admin access
if (!current_user_can(\'manage_options\')) {
    die(\'Error: You must be logged in as an administrator to run this script.\');
}

// Your translations from main.js
// Paste the entire translations object here
$javascript_translations = [
    \'en\' => [
        // Paste English translations here
    ],
    \'bm\' => [
        // Paste Bahasa Malaysia translations here
    ],
    \'cn\' => [
        // Paste Chinese translations here
    ]
];

// Import translations
$result = MPA_Translation_Migration::import_from_javascript($javascript_translations);

// Display results
echo "Migration Results:\\n";
echo "Success: " . $result[\'success\'] . "\\n";
echo "Failed: " . $result[\'failed\'] . "\\n";
echo "Skipped: " . $result[\'skipped\'] . "\\n";

if (!empty($result[\'errors\'])) {
    echo "\\nErrors:\\n";
    foreach ($result[\'errors\'] as $error) {
        echo "  - " . $error . "\\n";
    }
}

echo "\\nMigration complete!\\n";
?>';
        
        return $script;
    }
}


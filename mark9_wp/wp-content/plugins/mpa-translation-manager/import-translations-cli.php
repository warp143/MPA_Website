<?php
/**
 * WP-CLI Script to Import Translations
 * Run: wp eval-file import-translations-cli.php
 */

// Load the JSON file
$json_file = __DIR__ . '/translations-import.json';

if (!file_exists($json_file)) {
    WP_CLI::error("Translations file not found: $json_file");
    return;
}

$json_content = file_get_contents($json_file);
$data = json_decode($json_content, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    WP_CLI::error("Invalid JSON: " . json_last_error_msg());
    return;
}

if (!isset($data['translations'])) {
    WP_CLI::error("Invalid format: missing 'translations' key");
    return;
}

WP_CLI::log("Starting translation import...");

$success = 0;
$failed = 0;
$translations = $data['translations'];

foreach (['en', 'bm', 'cn'] as $lang) {
    if (!isset($translations[$lang])) {
        WP_CLI::warning("Language $lang not found in JSON");
        continue;
    }
    
    WP_CLI::log("Importing $lang translations...");
    
    foreach ($translations[$lang] as $key => $value) {
        $result = MPA_Translation_Database::update_translation($key, $lang, $value, 1);
        
        if ($result !== false) {
            $success++;
        } else {
            $failed++;
            WP_CLI::warning("Failed to import: $lang/$key");
        }
    }
}

WP_CLI::success("Import complete!");
WP_CLI::log("✓ Imported: $success translations");
WP_CLI::log("✗ Failed: $failed translations");

// Show stats
$stats = MPA_Translation_Database::get_stats();
WP_CLI::log("\n=== Database Statistics ===");
WP_CLI::log("Total translations: " . $stats['total']);
WP_CLI::log("English: " . ($stats['by_language']['en'] ?? 0));
WP_CLI::log("Bahasa Malaysia: " . ($stats['by_language']['bm'] ?? 0));
WP_CLI::log("Chinese: " . ($stats['by_language']['cn'] ?? 0));
WP_CLI::log("Unique keys: " . $stats['unique_keys']);


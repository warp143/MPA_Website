<?php
/**
 * Admin Page Template - Translation Manager
 * Variables available: $translations, $stats, $all_keys
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap mpa-translation-manager">
    <h1>
        <span class="dashicons dashicons-translation" style="font-size: 32px; vertical-align: middle;"></span>
        MPA Translation Manager
    </h1>
    
    <p class="description">
        Manage all website translations from one place. Changes are applied immediately without requiring code deployment.
    </p>
    
    <!-- Statistics Cards -->
    <div class="mpa-trans-stats-cards">
        <div class="mpa-stat-card">
            <div class="mpa-stat-value"><?php echo count($translations); ?></div>
            <div class="mpa-stat-label">Translation Keys</div>
        </div>
        <div class="mpa-stat-card">
            <div class="mpa-stat-value"><?php echo $stats['by_language']['en'] ?? 0; ?></div>
            <div class="mpa-stat-label">English</div>
        </div>
        <div class="mpa-stat-card">
            <div class="mpa-stat-value"><?php echo $stats['by_language']['bm'] ?? 0; ?></div>
            <div class="mpa-stat-label">Bahasa Malaysia</div>
        </div>
        <div class="mpa-stat-card">
            <div class="mpa-stat-value"><?php echo $stats['by_language']['cn'] ?? 0; ?></div>
            <div class="mpa-stat-label">Chinese (中文)</div>
        </div>
    </div>
    
    <!-- Toolbar -->
    <div class="mpa-trans-toolbar">
        <div class="mpa-trans-search">
            <input type="text" id="trans-search" placeholder="Search translations..." />
            <select id="trans-filter-context">
                <option value="">All Categories</option>
                <option value="Navigation">Navigation</option>
                <option value="Hero Section">Hero Section</option>
                <option value="Buttons">Buttons</option>
                <option value="Events">Events</option>
                <option value="Membership">Membership</option>
                <option value="Footer">Footer</option>
                <option value="Privacy Policy">Privacy Policy</option>
                <option value="Cookie Banner">Cookie Banner</option>
                <option value="About Section">About Section</option>
                <option value="Newsletter">Newsletter</option>
                <option value="General">General</option>
            </select>
            <label>
                <input type="checkbox" id="filter-missing" />
                Show only missing translations
            </label>
        </div>
        <div class="mpa-trans-actions">
            <button id="add-translation" class="button">
                <span class="dashicons dashicons-plus-alt"></span> Add New
            </button>
            <button id="export-json" class="button">
                <span class="dashicons dashicons-download"></span> Export JSON
            </button>
            <button id="export-csv" class="button">
                <span class="dashicons dashicons-media-spreadsheet"></span> Export CSV
            </button>
            <button id="import-json" class="button">
                <span class="dashicons dashicons-upload"></span> Import JSON
            </button>
            <button id="save-all" class="button button-primary">
                <span class="dashicons dashicons-yes"></span> Save All Changes
            </button>
        </div>
    </div>
    
    <div id="unsaved-notice" class="notice notice-warning inline" style="display: none;">
        <p><strong>⚠️ You have unsaved changes!</strong> <span id="unsaved-count">0</span> translation(s) modified.</p>
    </div>
    
    <!-- Translations Table -->
    <table class="wp-list-table widefat fixed striped table-view-list" id="translations-table">
        <thead>
            <tr>
                <th style="width: 20%;">Translation Key</th>
                <th style="width: 22%;">English</th>
                <th style="width: 22%;">Bahasa Malaysia</th>
                <th style="width: 22%;">Chinese (中文)</th>
                <th style="width: 10%;">Context</th>
                <th style="width: 4%;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($translations)): ?>
                <tr>
                    <td colspan="6" class="no-translations">
                        <p><strong>No translations found.</strong></p>
                        <p>Click "Add New" to create your first translation or "Import JSON" to import existing translations.</p>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($translations as $key => $langs): ?>
                    <?php 
                        $context = MPA_Translation_Admin::get_context($key);
                        $has_missing = empty($langs['en']) || empty($langs['bm']) || empty($langs['cn']);
                    ?>
                    <tr data-key="<?php echo esc_attr($key); ?>" 
                        data-context="<?php echo esc_attr($context); ?>"
                        class="<?php echo $has_missing ? 'has-missing' : ''; ?>">
                        <td class="translation-key">
                            <code><?php echo esc_html($key); ?></code>
                        </td>
                        <td>
                            <textarea 
                                class="trans-input" 
                                data-lang="en" 
                                data-key="<?php echo esc_attr($key); ?>"
                                placeholder="English translation"
                                rows="2"><?php echo esc_textarea($langs['en']); ?></textarea>
                            <?php if (empty($langs['en'])): ?>
                                <span class="missing-indicator">Missing</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <textarea 
                                class="trans-input" 
                                data-lang="bm" 
                                data-key="<?php echo esc_attr($key); ?>"
                                placeholder="Terjemahan Bahasa Malaysia"
                                rows="2"><?php echo esc_textarea($langs['bm']); ?></textarea>
                            <?php if (empty($langs['bm'])): ?>
                                <span class="missing-indicator">Missing</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <textarea 
                                class="trans-input" 
                                data-lang="cn" 
                                data-key="<?php echo esc_attr($key); ?>"
                                placeholder="中文翻译"
                                rows="2"><?php echo esc_textarea($langs['cn']); ?></textarea>
                            <?php if (empty($langs['cn'])): ?>
                                <span class="missing-indicator">Missing</span>
                            <?php endif; ?>
                        </td>
                        <td class="context-col">
                            <span class="context-badge context-<?php echo sanitize_html_class(strtolower(str_replace(' ', '-', $context))); ?>">
                                <?php echo esc_html($context); ?>
                            </span>
                        </td>
                        <td>
                            <button class="button button-small delete-trans" title="Delete this translation key">
                                <span class="dashicons dashicons-trash"></span>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    
    <!-- Loading Overlay -->
    <div id="loading-overlay" style="display: none;">
        <div class="loading-spinner">
            <span class="spinner is-active"></span>
            <p id="loading-message">Processing...</p>
        </div>
    </div>
</div>

<!-- Add Translation Modal -->
<div id="add-translation-modal" class="mpa-modal" style="display: none;">
    <div class="mpa-modal-overlay"></div>
    <div class="mpa-modal-content">
        <div class="mpa-modal-header">
            <h2>Add New Translation</h2>
            <button class="mpa-modal-close">&times;</button>
        </div>
        <form id="add-translation-form">
            <table class="form-table">
                <tr>
                    <th><label for="new-key">Translation Key *</label></th>
                    <td>
                        <input type="text" id="new-key" class="regular-text" 
                               placeholder="nav-new-page" required 
                               pattern="[a-z0-9-]+" 
                               title="Only lowercase letters, numbers, and hyphens" />
                        <p class="description">Use lowercase letters, numbers, and hyphens only (e.g., nav-about, btn-signin)</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="new-en">English *</label></th>
                    <td>
                        <textarea id="new-en" class="large-text" rows="2" required placeholder="English translation"></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="new-bm">Bahasa Malaysia</label></th>
                    <td>
                        <textarea id="new-bm" class="large-text" rows="2" placeholder="Terjemahan Bahasa Malaysia"></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="new-cn">Chinese (中文)</label></th>
                    <td>
                        <textarea id="new-cn" class="large-text" rows="2" placeholder="中文翻译"></textarea>
                    </td>
                </tr>
            </table>
            <p class="submit">
                <button type="submit" class="button button-primary">Add Translation</button>
                <button type="button" class="button cancel-add">Cancel</button>
            </p>
        </form>
    </div>
</div>

<!-- Import JSON Modal -->
<div id="import-json-modal" class="mpa-modal" style="display: none;">
    <div class="mpa-modal-overlay"></div>
    <div class="mpa-modal-content">
        <div class="mpa-modal-header">
            <h2>Import Translations from JSON</h2>
            <button class="mpa-modal-close">&times;</button>
        </div>
        <form id="import-json-form">
            <table class="form-table">
                <tr>
                    <th><label for="json-file">Select JSON File</label></th>
                    <td>
                        <input type="file" id="json-file" accept=".json" />
                        <p class="description">Upload a previously exported JSON file</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="json-paste">Or Paste JSON</label></th>
                    <td>
                        <textarea id="json-paste" class="large-text code" rows="10" 
                                  placeholder='{"translations": {"en": {...}, "bm": {...}, "cn": {...}}}'></textarea>
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <label>
                            <input type="checkbox" id="import-overwrite" />
                            Overwrite existing translations
                        </label>
                        <p class="description">If checked, existing translations will be replaced. If unchecked, only new translations will be added.</p>
                    </td>
                </tr>
            </table>
            <p class="submit">
                <button type="submit" class="button button-primary">Import Translations</button>
                <button type="button" class="button cancel-import">Cancel</button>
            </p>
        </form>
    </div>
</div>

<style>
/* Inline styles for now - will move to CSS file */
.mpa-translation-manager { max-width: 100%; padding: 20px 20px 40px; }
.mpa-trans-stats-cards { display: flex; gap: 20px; margin: 20px 0; }
.mpa-stat-card { background: #fff; border: 1px solid #c3c4c7; border-radius: 4px; padding: 20px; flex: 1; text-align: center; }
.mpa-stat-value { font-size: 32px; font-weight: bold; color: #2271b1; }
.mpa-stat-label { font-size: 14px; color: #646970; margin-top: 5px; }
.mpa-trans-toolbar { display: flex; justify-content: space-between; align-items: center; margin: 20px 0; flex-wrap: wrap; gap: 10px; }
.mpa-trans-search { display: flex; gap: 10px; flex: 1; }
.mpa-trans-search input[type="text"] { flex: 1; max-width: 300px; }
.mpa-trans-search select { max-width: 200px; }
.mpa-trans-actions { display: flex; gap: 5px; }
.trans-input { width: 100%; padding: 5px; font-size: 13px; border: 1px solid #ddd; border-radius: 3px; resize: vertical; }
.trans-input:focus { border-color: #2271b1; outline: none; box-shadow: 0 0 0 1px #2271b1; }
.translation-key code { background: #f0f0f1; padding: 3px 6px; border-radius: 3px; font-size: 12px; }
.context-badge { display: inline-block; padding: 3px 8px; border-radius: 3px; font-size: 11px; font-weight: 600; }
.context-navigation { background: #d5e5ff; color: #1d4ed8; }
.context-hero-section { background: #fce7f3; color: #be185d; }
.context-buttons { background: #dbeafe; color: #1e40af; }
.context-events { background: #dcfce7; color: #166534; }
.context-membership { background: #fef3c7; color: #92400e; }
.context-footer { background: #e0e7ff; color: #3730a3; }
.context-privacy-policy { background: #fed7aa; color: #9a3412; }
.context-cookie-banner { background: #fecaca; color: #991b1b; }
.context-about-section { background: #e9d5ff; color: #6b21a8; }
.context-newsletter { background: #ccfbf1; color: #115e59; }
.context-general { background: #f3f4f6; color: #374151; }
.missing-indicator { color: #d63638; font-size: 11px; font-weight: 600; display: block; margin-top: 3px; }
.has-missing { background: #fff8e1; }
.delete-trans { color: #d63638; }
.delete-trans:hover { color: #d63638; border-color: #d63638; }
.no-translations { text-align: center; padding: 40px 20px; }
.mpa-modal { position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 100000; }
.mpa-modal-overlay { position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); }
.mpa-modal-content { position: relative; background: #fff; max-width: 800px; margin: 50px auto; padding: 0; border-radius: 4px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); max-height: 90vh; overflow-y: auto; }
.mpa-modal-header { display: flex; justify-content: space-between; align-items: center; padding: 20px; border-bottom: 1px solid #ddd; }
.mpa-modal-header h2 { margin: 0; }
.mpa-modal-close { background: none; border: none; font-size: 32px; cursor: pointer; color: #666; line-height: 1; }
.mpa-modal-close:hover { color: #000; }
.mpa-modal form { padding: 20px; }
#loading-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.9); z-index: 99999; display: flex; align-items: center; justify-content: center; }
.loading-spinner { text-align: center; }
#unsaved-notice { margin: 20px 0; }
</style>


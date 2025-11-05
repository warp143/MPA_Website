<div class="wrap mpa-translation-manager">
    <h1>MPA Translation Manager</h1>
    <p class="description">Manage all translations for the Malaysia Proptech Association website. 100% custom built.</p>
    
    <div class="mpa-trans-stats" style="background: #fff; padding: 15px; margin: 20px 0; border-left: 4px solid #0073aa;">
        <strong>Total Keys:</strong> <?php echo count($translations); ?> &nbsp;|&nbsp;
        <strong>Languages:</strong> 3 (EN, BM, CN) &nbsp;|&nbsp;
        <strong>Status:</strong> <span style="color: #46b450;">●</span> Active
    </div>
    
    <form method="post" action="" id="translations-form">
        <?php wp_nonce_field('mpa_save_translations', 'mpa_trans_nonce'); ?>
        
        <table class="wp-list-table widefat fixed striped" style="margin-top: 20px;">
            <thead>
                <tr>
                    <th style="width: 20%;">Translation Key</th>
                    <th style="width: 10%;">Context</th>
                    <th style="width: 23%;">English (EN)</th>
                    <th style="width: 23%;">Bahasa Malaysia (BM)</th>
                    <th style="width: 23%;">Chinese (CN)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($translations as $key => $langs): ?>
                <tr>
                    <td><code><?php echo esc_html($key); ?></code></td>
                    <td><span class="context-tag" style="background: #f0f0f1; padding: 3px 8px; border-radius: 3px; font-size: 11px;"><?php echo esc_html($langs['context']); ?></span></td>
                    <td>
                        <input type="text" 
                               name="trans[<?php echo esc_attr($key); ?>][en]"
                               value="<?php echo esc_attr($langs['en']); ?>" 
                               class="regular-text"
                               style="width: 100%;" />
                    </td>
                    <td>
                        <input type="text" 
                               name="trans[<?php echo esc_attr($key); ?>][bm]"
                               value="<?php echo esc_attr($langs['bm']); ?>" 
                               class="regular-text"
                               style="width: 100%;" />
                    </td>
                    <td>
                        <input type="text" 
                               name="trans[<?php echo esc_attr($key); ?>][cn]"
                               value="<?php echo esc_attr($langs['cn']); ?>" 
                               class="regular-text"
                               style="width: 100%;" />
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <p class="submit">
            <input type="submit" name="save_translations" class="button button-primary button-large" value="Save All Translations" />
        </p>
    </form>
</div>

<?php
// Handle form submission
if (isset($_POST['save_translations']) && check_admin_referer('mpa_save_translations', 'mpa_trans_nonce')) {
    $translations_data = $_POST['trans'];
    $updated = 0;
    
    foreach ($translations_data as $key => $langs) {
        foreach ($langs as $lang => $value) {
            MPA_Translation_Database::update_translation($key, $lang, sanitize_textarea_field($value));
            $updated++;
        }
    }
    
    echo '<div class="notice notice-success is-dismissible"><p><strong>Success!</strong> Updated ' . $updated . ' translations.</p></div>';
}
?>

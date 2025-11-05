/**
 * MPA Translation Manager - Admin JavaScript
 */

(function($) {
    'use strict';
    
    let unsavedChanges = new Set();
    let allTranslations = {};
    
    $(document).ready(function() {
        init();
    });
    
    function init() {
        // Track changes
        $('.trans-input').on('input', handleInputChange);
        
        // Search functionality
        $('#trans-search').on('input', filterTranslations);
        $('#trans-filter-context').on('change', filterTranslations);
        $('#filter-missing').on('change', filterTranslations);
        
        // Buttons
        $('#add-translation').on('click', openAddModal);
        $('#save-all').on('click', saveAllChanges);
        $('#export-json').on('click', exportJSON);
        $('#export-csv').on('click', exportCSV);
        $('#import-json').on('click', openImportModal);
        
        // Delete buttons
        $('.delete-trans').on('click', deleteTranslation);
        
        // Modals
        $('.mpa-modal-close, .cancel-add, .cancel-import').on('click', closeModals);
        $('.mpa-modal-overlay').on('click', closeModals);
        
        // Forms
        $('#add-translation-form').on('submit', addTranslation);
        $('#import-json-form').on('submit', importJSON);
        $('#json-file').on('change', handleFileUpload);
        
        // Warn about unsaved changes
        $(window).on('beforeunload', function() {
            if (unsavedChanges.size > 0) {
                return 'You have unsaved changes. Are you sure you want to leave?';
            }
        });
        
        // Auto-resize textareas
        autoResizeTextareas();
    }
    
    function handleInputChange(e) {
        const $input = $(e.target);
        const key = $input.data('key');
        const lang = $input.data('lang');
        const changeKey = `${key}__${lang}`;
        
        // Track this change
        unsavedChanges.add(changeKey);
        
        // Mark row as modified
        $input.closest('tr').addClass('modified');
        
        // Update unsaved notice
        updateUnsavedNotice();
    }
    
    function updateUnsavedNotice() {
        const count = unsavedChanges.size;
        if (count > 0) {
            $('#unsaved-notice').show();
            $('#unsaved-count').text(count);
        } else {
            $('#unsaved-notice').hide();
        }
    }
    
    function filterTranslations() {
        const search = $('#trans-search').val().toLowerCase();
        const context = $('#trans-filter-context').val();
        const showMissingOnly = $('#filter-missing').is(':checked');
        
        $('#translations-table tbody tr').each(function() {
            const $row = $(this);
            const key = $row.data('key');
            const rowContext = $row.data('context');
            const hasMissing = $row.hasClass('has-missing');
            
            if (!key) return; // Skip no-translations row
            
            let show = true;
            
            // Search filter
            if (search && key.indexOf(search) === -1) {
                show = false;
            }
            
            // Context filter
            if (context && rowContext !== context) {
                show = false;
            }
            
            // Missing filter
            if (showMissingOnly && !hasMissing) {
                show = false;
            }
            
            $row.toggle(show);
        });
    }
    
    function saveAllChanges() {
        if (unsavedChanges.size === 0) {
            alert('No changes to save.');
            return;
        }
        
        showLoading('Saving translations...');
        
        const translations = [];
        
        // Collect all changed translations
        $('.trans-input').each(function() {
            const $input = $(this);
            const key = $input.data('key');
            const lang = $input.data('lang');
            const value = $input.val();
            const changeKey = `${key}__${lang}`;
            
            if (unsavedChanges.has(changeKey)) {
                translations.push({
                    key: key,
                    lang: lang,
                    value: value
                });
            }
        });
        
        // Send to API
        $.ajax({
            url: mpaTransAdmin.apiUrl + '/bulk',
            method: 'POST',
            headers: {
                'X-WP-Nonce': mpaTransAdmin.nonce
            },
            contentType: 'application/json',
            data: JSON.stringify({
                translations: translations
            }),
            success: function(response) {
                hideLoading();
                
                if (response.success) {
                    // Clear unsaved changes
                    unsavedChanges.clear();
                    $('.trans-input').closest('tr').removeClass('modified');
                    updateUnsavedNotice();
                    
                    alert(`✓ Successfully saved ${response.updated} translations!`);
                    
                    if (response.failed > 0) {
                        console.error('Some translations failed:', response.errors);
                    }
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr) {
                hideLoading();
                alert('Error saving translations: ' + (xhr.responseJSON?.message || 'Unknown error'));
            }
        });
    }
    
    function openAddModal() {
        $('#add-translation-modal').fadeIn();
        $('#new-key').focus();
    }
    
    function addTranslation(e) {
        e.preventDefault();
        
        const key = $('#new-key').val().trim();
        const en = $('#new-en').val().trim();
        const bm = $('#new-bm').val().trim();
        const cn = $('#new-cn').val().trim();
        
        if (!key || !en) {
            alert('Translation key and English translation are required.');
            return;
        }
        
        showLoading('Adding translation...');
        
        const translations = [
            { key, lang: 'en', value: en },
            { key, lang: 'bm', value: bm },
            { key, lang: 'cn', value: cn }
        ];
        
        $.ajax({
            url: mpaTransAdmin.apiUrl + '/bulk',
            method: 'POST',
            headers: {
                'X-WP-Nonce': mpaTransAdmin.nonce
            },
            contentType: 'application/json',
            data: JSON.stringify({ translations }),
            success: function(response) {
                hideLoading();
                closeModals();
                
                if (response.success) {
                    alert('✓ Translation added successfully!');
                    location.reload(); // Reload to show new translation
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr) {
                hideLoading();
                alert('Error: ' + (xhr.responseJSON?.message || 'Unknown error'));
            }
        });
    }
    
    function deleteTranslation(e) {
        e.preventDefault();
        
        if (!confirm(mpaTransAdmin.confirmDelete)) {
            return;
        }
        
        const $row = $(this).closest('tr');
        const key = $row.data('key');
        
        showLoading('Deleting translation...');
        
        $.ajax({
            url: mpaTransAdmin.apiUrl + '/' + encodeURIComponent(key),
            method: 'DELETE',
            headers: {
                'X-WP-Nonce': mpaTransAdmin.nonce
            },
            success: function(response) {
                hideLoading();
                
                if (response.success) {
                    $row.fadeOut(function() {
                        $(this).remove();
                    });
                    alert('✓ Translation deleted successfully!');
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr) {
                hideLoading();
                alert('Error: ' + (xhr.responseJSON?.message || 'Unknown error'));
            }
        });
    }
    
    function exportJSON() {
        window.location.href = ajaxurl + '?action=mpa_export_json&nonce=' + mpaTransAdmin.nonce;
    }
    
    function exportCSV() {
        window.location.href = ajaxurl + '?action=mpa_export_csv&nonce=' + mpaTransAdmin.nonce;
    }
    
    function openImportModal() {
        $('#import-json-modal').fadeIn();
    }
    
    function handleFileUpload(e) {
        const file = e.target.files[0];
        if (!file) return;
        
        const reader = new FileReader();
        reader.onload = function(event) {
            $('#json-paste').val(event.target.result);
        };
        reader.readAsText(file);
    }
    
    function importJSON(e) {
        e.preventDefault();
        
        const jsonText = $('#json-paste').val().trim();
        const overwrite = $('#import-overwrite').is(':checked');
        
        if (!jsonText) {
            alert('Please select a file or paste JSON data.');
            return;
        }
        
        // Validate JSON
        try {
            JSON.parse(jsonText);
        } catch (err) {
            alert('Invalid JSON: ' + err.message);
            return;
        }
        
        if (!confirm('Are you sure you want to import translations?' + (overwrite ? ' Existing translations will be overwritten.' : ''))) {
            return;
        }
        
        showLoading('Importing translations...');
        
        $.ajax({
            url: ajaxurl,
            method: 'POST',
            data: {
                action: 'mpa_import_json',
                nonce: mpaTransAdmin.nonce,
                json: jsonText,
                overwrite: overwrite ? '1' : '0'
            },
            success: function(response) {
                hideLoading();
                
                if (response.success) {
                    const data = response.data;
                    alert(`✓ Import complete!\n\nSuccess: ${data.success}\nFailed: ${data.failed}\nSkipped: ${data.skipped}`);
                    
                    if (data.success > 0) {
                        location.reload();
                    }
                } else {
                    alert('Error: ' + response.data.message);
                }
            },
            error: function(xhr) {
                hideLoading();
                alert('Error: ' + (xhr.responseJSON?.data?.message || 'Unknown error'));
            }
        });
    }
    
    function closeModals() {
        $('.mpa-modal').fadeOut();
        
        // Reset forms
        $('#add-translation-form')[0].reset();
        $('#import-json-form')[0].reset();
        $('#json-paste').val('');
    }
    
    function showLoading(message) {
        $('#loading-message').text(message || 'Processing...');
        $('#loading-overlay').fadeIn();
    }
    
    function hideLoading() {
        $('#loading-overlay').fadeOut();
    }
    
    function autoResizeTextareas() {
        $('.trans-input').each(function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        $('.trans-input').on('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }
    
})(jQuery);

// Add AJAX handlers for export/import
jQuery(document).ready(function($) {
    // Export JSON handler
    if (typeof ajaxurl !== 'undefined') {
        $(document).on('click', '#export-json', function(e) {
            e.preventDefault();
            window.open(ajaxurl + '?action=mpa_export_json', '_blank');
        });
        
        $(document).on('click', '#export-csv', function(e) {
            e.preventDefault();
            window.open(ajaxurl + '?action=mpa_export_csv', '_blank');
        });
    }
});


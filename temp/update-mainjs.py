#!/usr/bin/env python3
"""
Update main.js to use MPA Translation API instead of hardcoded translations
"""

import sys

def update_main_js(input_file, output_file):
    with open(input_file, 'r', encoding='utf-8') as f:
        lines = f.readlines()
    
    new_lines = []
    
    # Part 1: Lines before translations (1-213)
    new_lines.extend(lines[:213])
    
    # Part 2: Add new API loading code instead of hardcoded translations
    new_lines.append('\n')
    new_lines.append('    // ==========================================\n')
    new_lines.append('    // TRANSLATIONS NOW LOADED FROM API\n')
    new_lines.append('    // Removed 351 lines of hardcoded translations\n')
    new_lines.append('    // Using MPA Translation Manager Plugin\n')
    new_lines.append('    // API: /wp-json/mpa/v1/translations/{lang}\n')
    new_lines.append('    // ==========================================\n')
    new_lines.append('\n')
    new_lines.append('    // Load translations from REST API with caching\n')
    new_lines.append('    async function loadTranslations(lang) {\n')
    new_lines.append('        if (!window.MPA_TRANS) {\n')
    new_lines.append('            console.error("MPA_TRANS plugin not loaded!");\n')
    new_lines.append('            return {};\n')
    new_lines.append('        }\n')
    new_lines.append('        return await window.MPA_TRANS.load(lang);\n')
    new_lines.append('    }\n')
    new_lines.append('\n')
    
    # Part 3: Skip hardcoded translations (lines 214-565 in original, 0-indexed 213-564)
    # and continue from line 566 (0-indexed 565)
    # But we need to update selectLanguage to be async and load translations
    
    # Find selectLanguage function (should be around line 567 original, now 565 in array)
    select_lang_idx = None
    for i in range(565, min(600, len(lines))):
        if 'function selectLanguage(lang)' in lines[i]:
            select_lang_idx = i
            break
    
    if select_lang_idx:
        # Add everything before selectLanguage
        new_lines.extend(lines[565:select_lang_idx])
        
        # Add updated async selectLanguage
        new_lines.append('    async function selectLanguage(lang) {\n')
        new_lines.append('        // Load translations from API\n')
        new_lines.append('        const translations = await loadTranslations(lang);\n')
        new_lines.append('        \n')
        
        # Find the end of function header and add rest of selectLanguage
        func_start = select_lang_idx + 1
        # Find where applyTranslationsWithRetry is called
        apply_idx = None
        for i in range(select_lang_idx, min(select_lang_idx + 50, len(lines))):
            if 'applyTranslationsWithRetry(lang)' in lines[i]:
                apply_idx = i
                break
        
        if apply_idx:
            # Add lines between function start and applyTranslationsWithRetry call
            new_lines.extend(lines[func_start:apply_idx])
            # Update the call to pass translations
            new_lines.append('        // Apply translations with retry mechanism\n')
            new_lines.append('        await applyTranslationsWithRetry(lang, translations);\n')
            # Add rest after the call
            new_lines.extend(lines[apply_idx + 1:])
        else:
            print("Warning: Could not find applyTranslationsWithRetry call")
            new_lines.extend(lines[func_start:])
    else:
        print("Warning: Could not find selectLanguage function")
        new_lines.extend(lines[565:])
    
    # Write output
    with open(output_file, 'w', encoding='utf-8') as f:
        f.writelines(new_lines)
    
    original_lines = len(lines)
    new_lines_count = len(new_lines)
    print(f"✓ Original: {original_lines} lines")
    print(f"✓ New: {new_lines_count} lines")
    print(f"✓ Removed: {original_lines - new_lines_count} lines")

if __name__ == '__main__':
    # Get original from server backup
    update_main_js('main-original.js', 'main-updated.js')


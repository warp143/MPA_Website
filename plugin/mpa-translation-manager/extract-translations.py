#!/usr/bin/env python3
"""
Extract Translations from main.js
Converts JavaScript translations object to JSON format for import
"""

import json
import re
import sys

def extract_translations_from_js(js_content):
    """Extract translations from JavaScript file"""
    
    # Find the translations object
    pattern = r'const translations = \{([^\}]+(?:\{[^\}]*\}[^\}]*)*)\};'
    match = re.search(pattern, js_content, re.DOTALL)
    
    if not match:
        print("Error: Could not find translations object")
        return None
    
    translations_text = match.group(1)
    
    # Parse each language section
    translations = {
        'en': {},
        'bm': {},
        'cn': {}
    }
    
    # Split by language sections
    for lang in ['en', 'bm', 'cn']:
        # Find the language section
        lang_pattern = rf'{lang}:\s*\{{([^\}}]+(?:\{{[^\}}]*\}}[^\}}]*)*)\}}'
        lang_match = re.search(lang_pattern, translations_text, re.DOTALL)
        
        if not lang_match:
            print(f"Warning: Could not find {lang} section")
            continue
        
        lang_content = lang_match.group(1)
        
        # Extract key-value pairs
        # Pattern: 'key': 'value' or 'key': "value"
        pair_pattern = r"'([^']+)':\s*['\"]([^'\"]*(?:\\'|\\\")*[^'\"]*)['\"]"
        
        for pair_match in re.finditer(pair_pattern, lang_content):
            key = pair_match.group(1)
            value = pair_match.group(2)
            
            # Unescape quotes
            value = value.replace("\\'", "'").replace('\\"', '"')
            
            translations[lang][key] = value
    
    return translations

def main():
    # Read from stdin or file
    if len(sys.argv) > 1:
        with open(sys.argv[1], 'r', encoding='utf-8') as f:
            js_content = f.read()
    else:
        js_content = sys.stdin.read()
    
    translations = extract_translations_from_js(js_content)
    
    if translations:
        # Create import format
        import_data = {
            "version": "1.0.0",
            "exported_at": "2025-11-04",
            "site_url": "https://proptech.org.my",
            "translations": translations
        }
        
        # Print JSON
        print(json.dumps(import_data, ensure_ascii=False, indent=2))
        
        # Print statistics
        print("\n# Translation Statistics:", file=sys.stderr)
        for lang, trans in translations.items():
            print(f"# {lang.upper()}: {len(trans)} translations", file=sys.stderr)
        
        total = sum(len(trans) for trans in translations.values())
        print(f"# TOTAL: {total} translations", file=sys.stderr)

if __name__ == '__main__':
    main()


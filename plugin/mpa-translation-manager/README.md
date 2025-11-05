# MPA Translation Manager

**Version:** 1.0.0  
**Author:** Andrew Michael Kho  
**Requires:** WordPress 5.0+, PHP 7.4+

Centralized translation management system for Malaysia Proptech Association website. Replaces hardcoded JavaScript translations with a database-driven system accessible via WordPress admin panel.

---

## 🎯 Features

- **Database-driven translations** - Store all translations in WordPress database
- **Easy-to-use admin interface** - Manage translations from Tools → Translation Manager
- **REST API** - Frontend fetches translations via REST API with localStorage caching
- **Multi-language support** - English, Bahasa Malaysia, Chinese (中文)
- **Import/Export** - JSON and CSV export/import functionality
- **Real-time editing** - Changes apply immediately without code deployment
- **Translation validation** - Visual indicators for missing translations
- **Search & Filter** - Find translations by key, context, or missing status
- **Audit trail** - Track who modified translations and when

---

## 📦 Installation

### Method 1: Upload via WordPress Admin

1. Download/zip the plugin folder
2. Go to WordPress Admin → Plugins → Add New → Upload Plugin
3. Upload the ZIP file
4. Click "Activate Plugin"

### Method 2: Manual Installation

1. Upload the `mpa-translation-manager` folder to `/wp-content/plugins/`
2. Go to WordPress Admin → Plugins
3. Find "MPA Translation Manager" and click "Activate"

### Method 3: WP-CLI

```bash
# Upload plugin to server
scp -r mpa-translation-manager/ user@server:/path/to/wp-content/plugins/

# Activate via WP-CLI
wp plugin activate mpa-translation-manager
```

---

## 🚀 Quick Start

### 1. Access the Admin Interface

After activation, go to:
**WordPress Admin → Tools → Translation Manager**

### 2. Import Existing Translations

#### Option A: Import from JSON
1. Click "Import JSON"
2. Upload your exported translations file or paste JSON
3. Check "Overwrite existing translations" if needed
4. Click "Import Translations"

#### Option B: Add Manually
1. Click "+ Add New"
2. Enter translation key (e.g., `nav-about`)
3. Enter translations for all 3 languages
4. Click "Add Translation"

### 3. Edit Translations

1. Browse the translation table
2. Click on any text field to edit
3. Click "Save All Changes" when done
4. Changes apply immediately on the frontend!

---

## 📊 Admin Interface Guide

### Statistics Cards
- **Translation Keys** - Total number of unique keys
- **English, Bahasa Malaysia, Chinese** - Count per language

### Toolbar
- **Search** - Find translations by key name
- **Filter by Context** - Show only Navigation, Events, Privacy Policy, etc.
- **Show only missing** - Highlight incomplete translations
- **Add New** - Create new translation
- **Export JSON/CSV** - Download all translations
- **Import JSON** - Upload translations
- **Save All Changes** - Save edits

### Translation Table
- **Translation Key** - Unique identifier (e.g., `nav-about`)
- **English / Bahasa Malaysia / Chinese** - Translation values
- **Context** - Category (auto-detected from key prefix)
- **Actions** - Delete translation

### Missing Translations
- Highlighted in **yellow background**
- Shows "Missing" label in empty fields
- Use "Show only missing" filter to find them quickly

---

## 🔧 REST API Endpoints

### Public Endpoints

**GET** `/wp-json/mpa/v1/translations/{lang}`
- Returns all translations for a language
- **Parameters:** `lang` = `en`, `bm`, or `cn`
- **Response:**
```json
{
    "success": true,
    "language": "en",
    "translations": {
        "nav-about": "Association",
        "btn-signin": "Sign In",
        ...
    },
    "count": 105
}
```

### Admin Endpoints (require `manage_options` capability)

**GET** `/wp-json/mpa/v1/translations/all`
- Returns all translations grouped by key

**POST** `/wp-json/mpa/v1/translations`
- Update/create a single translation
- **Body:**
```json
{
    "key": "nav-about",
    "lang": "en",
    "value": "Association"
}
```

**POST** `/wp-json/mpa/v1/translations/bulk`
- Bulk update translations
- **Body:**
```json
{
    "translations": [
        {"key": "nav-about", "lang": "en", "value": "Association"},
        {"key": "nav-about", "lang": "bm", "value": "Persatuan"}
    ]
}
```

**DELETE** `/wp-json/mpa/v1/translations/{key}?lang={lang}`
- Delete a translation

**GET** `/wp-json/mpa/v1/translations/stats`
- Get translation statistics

---

## 🎨 Frontend Integration

The plugin automatically loads the frontend JavaScript that fetches translations from the API.

### Using Translations in Your Theme

```javascript
// Load translations for current language
const lang = localStorage.getItem('selectedLanguage') || 'en';
const translations = await MPA_TRANS.load(lang);

// Apply translations to elements
document.querySelectorAll('[data-translate]').forEach(el => {
    const key = el.getAttribute('data-translate');
    if (translations[key]) {
        el.textContent = translations[key];
    }
});
```

### Caching

Translations are automatically cached in localStorage for 1 hour. To clear cache:

```javascript
MPA_TRANS.clearCache();
```

To check cache status:

```javascript
const stats = MPA_TRANS.getCacheStats();
console.log(stats);
```

---

## 📥 Migration from Hardcoded Translations

### Step 1: Export Current Translations

Extract the translations object from your `main.js`:

```javascript
const translations = {
    en: { ... },
    bm: { ... },
    cn: { ... }
};
```

### Step 2: Convert to JSON

Create a JSON file:

```json
{
    "version": "1.0.0",
    "translations": {
        "en": { ... },
        "bm": { ... },
        "cn": { ... }
    }
}
```

### Step 3: Import

1. Go to Tools → Translation Manager
2. Click "Import JSON"
3. Paste the JSON or upload the file
4. Check "Overwrite existing translations"
5. Click "Import Translations"

### Step 4: Update Frontend Code

Replace the hardcoded translations in `main.js`:

```javascript
// OLD (remove this):
const translations = {
    en: { /* 105 keys */ },
    bm: { /* 105 keys */ },
    cn: { /* 105 keys */ }
};

// NEW (use this):
async function selectLanguage(lang) {
    const translations = await MPA_TRANS.load(lang);
    applyTranslations(translations, lang);
    // ... rest of function
}
```

---

## 🗄️ Database Structure

The plugin creates one table: `wp_mpa_translations`

```sql
CREATE TABLE wp_mpa_translations (
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
);
```

---

## 🔒 Security

- Admin UI requires `manage_options` capability
- REST API POST/DELETE endpoints require admin authentication
- GET endpoints are public (cached for performance)
- All inputs are sanitized and validated
- Uses WordPress nonce verification for AJAX requests
- SQL injection prevention via prepared statements

---

## 🐛 Troubleshooting

### Translations Not Loading

1. Check browser console for errors
2. Verify REST API is accessible: `/wp-json/mpa/v1/translations/en`
3. Clear localStorage cache: `MPA_TRANS.clearCache()`
4. Check WordPress permalink settings

### Import Fails

1. Verify JSON format is correct
2. Check file upload size limits in PHP settings
3. Ensure user has `manage_options` capability

### Database Issues

1. Check if table was created: `SHOW TABLES LIKE 'wp_mpa_translations'`
2. Reactivate plugin to recreate table
3. Check database user permissions

---

## 📝 Changelog

### 1.0.0 (2025-11-04)
- Initial release
- Database-driven translation system
- Admin UI with search/filter
- REST API endpoints
- Import/Export JSON/CSV
- Frontend loader with caching
- Migration from hardcoded JavaScript translations

---

## 👨‍💻 Developer

**Andrew Michael Kho**  
MPA Committee Member 2025-2026  
LinkedIn: https://www.linkedin.com/in/andrewmichaelkho/  
Website: https://www.homesifu.io

---

## 📄 License

GPL v2 or later

---

## 🙏 Support

For issues, questions, or feature requests, contact the MPA technical team.


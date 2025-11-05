# MPA Translation Manager

**100% Custom WordPress Translation Plugin**  
Built for Malaysia Proptech Association  
No third-party dependencies

## Features

- ✅ Custom database table for translations
- ✅ REST API endpoints for frontend
- ✅ WordPress admin UI for easy editing
- ✅ Support for 3 languages (EN, BM, CN)
- ✅ LocalStorage caching for performance
- ✅ Drop-in replacement for ACF fields
- ✅ 100% custom code, no dependencies

## Installation

1. Upload to `wp-content/plugins/mpa-translation-manager/`
2. Activate via WordPress Admin → Plugins
3. Manage translations at Tools → Translation Manager

## API Endpoints

- `GET /wp-json/mpa/v1/translations/{lang}` - Get all translations for a language
- `POST /wp-json/mpa/v1/translations` - Update single translation (admin only)
- `POST /wp-json/mpa/v1/translations/bulk` - Bulk update (admin only)

## Usage in Theme

```php
// In your theme templates:
the_field('pillar_1_title');  // Outputs translation based on current language
echo get_field('pillar_2_desc');  // Returns translation value
```

## Version

1.0.0 - Initial release

## Author

Andrew Michael Kho  
https://www.linkedin.com/in/andrewmichaelkho/

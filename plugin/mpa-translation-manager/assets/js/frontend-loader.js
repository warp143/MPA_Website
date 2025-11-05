/**
 * MPA Translation Loader - Frontend
 * Loads translations from REST API with localStorage caching
 */

(function() {
    'use strict';
    
    const MPA_TRANS = {
        cache: {},
        cacheExpiry: (typeof mpaTransConfig !== 'undefined' && mpaTransConfig.cacheExpiry) ? mpaTransConfig.cacheExpiry : 3600000, // 1 hour
        apiUrl: (typeof mpaTransConfig !== 'undefined' && mpaTransConfig.apiUrl) ? mpaTransConfig.apiUrl : '/wp-json/mpa/v1/translations',
        
        /**
         * Load translations for a specific language
         * @param {string} lang Language code (en, bm, cn)
         * @returns {Promise<Object>} Translations object
         */
        async load(lang) {
            // Validate language
            if (!['en', 'bm', 'cn'].includes(lang)) {
                console.error('MPA Trans: Invalid language code:', lang);
                return {};
            }
            
            // Check cache first
            const cached = this.getFromCache(lang);
            if (cached) {
                console.log('MPA Trans: Loaded', lang, 'from cache');
                return cached;
            }
            
            // Fetch from API
            try {
                console.log('MPA Trans: Fetching', lang, 'from API...');
                const response = await fetch(`${this.apiUrl}/${lang}`);
                
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                
                const data = await response.json();
                
                if (data.success && data.translations) {
                    console.log('MPA Trans: Loaded', data.count, 'translations for', lang);
                    this.saveToCache(lang, data.translations);
                    return data.translations;
                } else {
                    console.error('MPA Trans: API returned unsuccessful response:', data);
                    return {};
                }
            } catch (error) {
                console.error('MPA Trans: Failed to load translations:', error);
                
                // Try to use cached version even if expired
                const fallback = this.getFromCache(lang, true);
                if (fallback) {
                    console.warn('MPA Trans: Using expired cache as fallback');
                    return fallback;
                }
                
                return {};
            }
        },
        
        /**
         * Get translations from localStorage cache
         * @param {string} lang Language code
         * @param {boolean} ignoreExpiry Whether to ignore cache expiry
         * @returns {Object|null} Cached translations or null
         */
        getFromCache(lang, ignoreExpiry = false) {
            const cacheKey = `mpa_translations_${lang}`;
            const timestampKey = `${cacheKey}_timestamp`;
            
            try {
                const cached = localStorage.getItem(cacheKey);
                const timestamp = localStorage.getItem(timestampKey);
                
                if (!cached || !timestamp) {
                    return null;
                }
                
                // Check expiry
                if (!ignoreExpiry) {
                    const age = Date.now() - parseInt(timestamp, 10);
                    if (age > this.cacheExpiry) {
                        console.log('MPA Trans: Cache expired for', lang);
                        return null;
                    }
                }
                
                return JSON.parse(cached);
            } catch (error) {
                console.error('MPA Trans: Error reading cache:', error);
                return null;
            }
        },
        
        /**
         * Save translations to localStorage cache
         * @param {string} lang Language code
         * @param {Object} translations Translations object
         */
        saveToCache(lang, translations) {
            const cacheKey = `mpa_translations_${lang}`;
            const timestampKey = `${cacheKey}_timestamp`;
            
            try {
                localStorage.setItem(cacheKey, JSON.stringify(translations));
                localStorage.setItem(timestampKey, Date.now().toString());
            } catch (error) {
                console.error('MPA Trans: Error saving cache:', error);
            }
        },
        
        /**
         * Clear all cached translations
         */
        clearCache() {
            ['en', 'bm', 'cn'].forEach(lang => {
                try {
                    localStorage.removeItem(`mpa_translations_${lang}`);
                    localStorage.removeItem(`mpa_translations_${lang}_timestamp`);
                } catch (error) {
                    console.error('MPA Trans: Error clearing cache:', error);
                }
            });
            console.log('MPA Trans: Cache cleared');
        },
        
        /**
         * Preload translations for all languages
         * Useful for warming up the cache
         */
        async preloadAll() {
            console.log('MPA Trans: Preloading all languages...');
            const promises = ['en', 'bm', 'cn'].map(lang => this.load(lang));
            await Promise.all(promises);
            console.log('MPA Trans: Preload complete');
        },
        
        /**
         * Get cache statistics
         * @returns {Object} Cache stats
         */
        getCacheStats() {
            const stats = {};
            ['en', 'bm', 'cn'].forEach(lang => {
                const cacheKey = `mpa_translations_${lang}`;
                const timestampKey = `${cacheKey}_timestamp`;
                const cached = localStorage.getItem(cacheKey);
                const timestamp = localStorage.getItem(timestampKey);
                
                stats[lang] = {
                    cached: !!cached,
                    count: cached ? Object.keys(JSON.parse(cached)).length : 0,
                    age: timestamp ? Date.now() - parseInt(timestamp, 10) : null,
                    expired: timestamp ? (Date.now() - parseInt(timestamp, 10)) > this.cacheExpiry : null
                };
            });
            return stats;
        }
    };
    
    // Expose globally
    window.MPA_TRANS = MPA_TRANS;
    
    // Auto-preload on page load (optional)
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            // Get current language from page or default to English
            const currentLang = localStorage.getItem('selectedLanguage') || 'en';
            MPA_TRANS.load(currentLang);
        });
    } else {
        const currentLang = localStorage.getItem('selectedLanguage') || 'en';
        MPA_TRANS.load(currentLang);
    }
    
    console.log('MPA Translation Loader initialized');
    
})();


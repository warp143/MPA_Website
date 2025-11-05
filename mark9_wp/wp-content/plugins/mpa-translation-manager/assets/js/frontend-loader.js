// MPA Translation Loader - 100% Custom Built
(function() {
    'use strict';
    
    const MPA_TRANS = {
        cache: {},
        cacheExpiry: 3600000, // 1 hour in milliseconds
        
        async load(lang) {
            // Check cache first
            const cached = this.getFromCache(lang);
            if (cached) {
                return cached;
            }
            
            // Fetch from API
            try {
                const response = await fetch(`/wp-json/mpa/v1/translations/${lang}`);
                const data = await response.json();
                
                if (data.success) {
                    this.saveToCache(lang, data.translations);
                    return data.translations;
                }
            } catch (error) {
                console.error('MPA Translation Manager: Failed to load translations', error);
            }
            
            return {};
        },
        
        getFromCache(lang) {
            const cacheKey = `mpa_translations_${lang}`;
            const timestampKey = `${cacheKey}_timestamp`;
            
            const cached = localStorage.getItem(cacheKey);
            const timestamp = localStorage.getItem(timestampKey);
            
            if (cached && timestamp) {
                const age = Date.now() - parseInt(timestamp);
                if (age < this.cacheExpiry) {
                    return JSON.parse(cached);
                }
            }
            
            return null;
        },
        
        saveToCache(lang, translations) {
            const cacheKey = `mpa_translations_${lang}`;
            const timestampKey = `${cacheKey}_timestamp`;
            
            localStorage.setItem(cacheKey, JSON.stringify(translations));
            localStorage.setItem(timestampKey, Date.now().toString());
        },
        
        clearCache() {
            ['en', 'bm', 'cn'].forEach(lang => {
                localStorage.removeItem(`mpa_translations_${lang}`);
                localStorage.removeItem(`mpa_translations_${lang}_timestamp`);
            });
        }
    };
    
    // Expose globally
    window.MPA_TRANS = MPA_TRANS;
})();

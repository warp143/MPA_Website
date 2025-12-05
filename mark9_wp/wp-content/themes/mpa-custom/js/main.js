// Modern Liquid MPA Website JavaScript
alert('MAIN.JS LOADED - If you see this, script is working');
console.log('[DEBUG] ========================================');
console.log('[DEBUG] main.js FILE LOADED - Mobile theme buttons version');
console.log('[DEBUG] Timestamp:', new Date().toISOString());
console.log('[DEBUG] ========================================');

// Theme Management
let currentTheme = localStorage.getItem('theme') || 'auto';
let isAutoMode = currentTheme === 'auto';

// Immediate test - check if buttons exist right now
setTimeout(function() {
    console.log('[DEBUG] Immediate check - looking for buttons...');
    // Mobile theme toggle button is now handled in main DOMContentLoaded section
}, 100);

function getAutoTheme() {
    const now = new Date();
    const hour = now.getHours();
    // Auto switch: dark mode from 7 PM to 7 AM, light mode from 7 AM to 7 PM
    return (hour >= 19 || hour < 7) ? 'dark' : 'light';
}

function applyTheme(theme) {
    const body = document.body;
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = themeToggle?.querySelector('.theme-icon');
    const autoIndicator = document.getElementById('autoIndicator');
    
    if (theme === 'light') {
        body.classList.add('light-mode');
        if (themeIcon) themeIcon.textContent = '☀️';
    } else {
        body.classList.remove('light-mode');
        if (themeIcon) themeIcon.textContent = '🌙';
    }
    
    // Show/hide auto indicator
    if (autoIndicator) {
        if (isAutoMode) {
            autoIndicator.classList.remove('hidden');
        } else {
            autoIndicator.classList.add('hidden');
        }
    }
    
    // Update mobile theme buttons
    if (window.updateMobileThemeButton) {
        window.updateMobileThemeButton();
    }
    
    // Update logo based on theme
    updateLogoForTheme(theme);
}

function updateLogoForTheme(theme) {
    const logoImg = document.querySelector('.logo-img');
    if (logoImg) {
        if (theme === 'light') {
            logoImg.src = window.location.origin + '/wp-content/themes/mpa-custom/assets/mpa-logo.png';
        } else {
            logoImg.src = window.location.origin + '/wp-content/themes/mpa-custom/assets/MPA-logo-white-transparent-res.png';
        }
    }
}

function checkAndUpdateTheme() {
    if (isAutoMode) {
        const autoTheme = getAutoTheme();
        applyTheme(autoTheme);
    } else {
        applyTheme(currentTheme);
    }
}

// Expose checkAndUpdateTheme globally for header component integration
window.checkAndUpdateTheme = checkAndUpdateTheme;

function setTheme(theme) {
    // Ensure we're setting a valid theme
    if (theme !== 'light' && theme !== 'dark' && theme !== 'auto') {
        return;
    }
    
    currentTheme = theme;
    isAutoMode = theme === 'auto';
    localStorage.setItem('theme', theme);
    
    // Force immediate theme application
    if (theme === 'light') {
        document.body.classList.add('light-mode');
    } else if (theme === 'dark') {
        document.body.classList.remove('light-mode');
    } else {
        // Auto mode - use checkAndUpdateTheme
    checkAndUpdateTheme();
    updateAutoIndicator(theme);
        return;
    }
    
    // Update theme icon and indicators
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = themeToggle?.querySelector('.theme-icon');
    if (themeIcon) {
        themeIcon.textContent = theme === 'light' ? '☀️' : '🌙';
    }
    
    // Update mobile theme button icon
    const mobileBtn = document.getElementById('mobileThemeToggle');
    const mobileIcon = mobileBtn?.querySelector('.theme-icon');
    if (mobileIcon) {
        if (theme === 'auto') {
            // In auto mode, show the current effective theme
            const effectiveTheme = isAutoMode ? getAutoTheme() : (document.body.classList.contains('light-mode') ? 'light' : 'dark');
            mobileIcon.textContent = effectiveTheme === 'light' ? '☀️' : '🌙';
        } else {
            mobileIcon.textContent = theme === 'light' ? '☀️' : '🌙';
        }
    }
    const mobileIndicator = document.getElementById('mobileAutoIndicator');
    if (mobileIndicator) {
        mobileIndicator.style.display = (theme === 'auto') ? 'inline' : 'none';
    }
    
    // Update mobile theme buttons
    if (window.updateMobileThemeButton) {
        window.updateMobileThemeButton();
    }
    
    // Update logo
    updateLogoForTheme(theme);
    
    // Update auto indicator
    updateAutoIndicator(theme);
}

// Expose setTheme globally
window.setTheme = setTheme;

function cycleTheme() {
    const themes = ['auto', 'light', 'dark'];
    const currentIndex = themes.indexOf(currentTheme);
    const nextIndex = (currentIndex + 1) % themes.length;
    const newTheme = themes[nextIndex];
    setTheme(newTheme);
}

// Expose cycleTheme globally for header component integration
window.cycleTheme = cycleTheme;

function updateThemeIcon(theme) {
    const themeIcons = document.querySelectorAll('.theme-icon');
    themeIcons.forEach(themeIcon => {
        if (theme === 'light') {
            themeIcon.textContent = '☀️';
        } else {
            themeIcon.textContent = '🌙';
        }
    });
}

function updateAutoIndicator(savedTheme) {
    const autoIndicator = document.getElementById('autoIndicator');
    const themeToggle = document.getElementById('themeToggle');
    
    if (autoIndicator && themeToggle) {
        if (savedTheme === 'auto') {
            autoIndicator.classList.remove('hidden');
            themeToggle.classList.remove('auto-hidden');
        } else {
            autoIndicator.classList.add('hidden');
            themeToggle.classList.add('auto-hidden');
        }
    }
}


document.addEventListener('DOMContentLoaded', function() {
    // Check if all required elements exist
    const requiredElements = [
        'themeToggle',
        'autoIndicator',
        'hamburger',
        'nav-menu'
    ];
    
    requiredElements.forEach(id => {
        const element = document.getElementById(id);
        if (!element) {
        }
    });
    
    // Initialize theme
    checkAndUpdateTheme();
    
    // Set initial auto-hidden class if needed
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle && currentTheme !== 'auto') {
        themeToggle.classList.add('auto-hidden');
    }
    
    // Theme toggle functionality (desktop)
    if (themeToggle) {
        themeToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            cycleTheme();
        });
    }
    
    // Mobile theme toggle - SIMPLEST POSSIBLE
    setInterval(function() {
        const btn = document.getElementById('mobileThemeToggle');
        if (btn && !btn.dataset.handlerAttached) {
            btn.dataset.handlerAttached = 'true';
            btn.onclick = function() {
                window.cycleTheme();
                return false;
            };
        }
    }, 200);
    
    // Mobile menu container
    const mobileDropdownMenu = document.getElementById('mobileDropdownMenu');
    
    // Initial update - multiple attempts to ensure it runs
    updateMobileThemeButton();
    setTimeout(updateMobileThemeButton, 100);
    setTimeout(updateMobileThemeButton, 300);
    setTimeout(updateMobileThemeButton, 500);
    
    // Check for system theme changes
    if (window.matchMedia) {
        const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        mediaQuery.addListener(function(e) {
            if (isAutoMode) {
                checkAndUpdateTheme();
            }
        });
    }
    // Mobile Menu Management
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    // mobileDropdownMenu already defined above for theme toggle handler

    function toggleMobileMenu() {
        if (!mobileDropdownMenu) return;
        const isActive = mobileDropdownMenu.classList.contains('active');
        
        if (isActive) {
            closeMobileMenu();
        } else {
            openMobileMenu();
        }
    }

    function openMobileMenu() {
        if (!mobileDropdownMenu || !mobileMenuToggle) return;
        mobileDropdownMenu.classList.add('active');
        mobileMenuToggle.classList.add('active');
        
        // Add entrance animation to menu items
        const menuItems = mobileDropdownMenu.querySelectorAll('.mobile-dropdown-link');
        menuItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateX(-10px)';
            setTimeout(async () => {
                item.style.transition = 'all 0.2s ease';
                item.style.opacity = '1';
                item.style.transform = 'translateX(0)';
            }, 50 + (index * 30));
        });
    }

    function closeMobileMenu() {
        if (!mobileDropdownMenu || !mobileMenuToggle) return;
        mobileDropdownMenu.classList.remove('active');
        mobileMenuToggle.classList.remove('active');
        
        // Reset menu items
        const menuItems = mobileDropdownMenu.querySelectorAll('.mobile-dropdown-link');
        menuItems.forEach(item => {
            item.style.opacity = '';
            item.style.transform = '';
            item.style.transition = '';
        });
    }

    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', toggleMobileMenu);
    }

    // Language Dropdown Management
    const languageToggle = document.getElementById('languageToggle');
    const languageMenu = document.getElementById('languageMenu');
    const languageDropdown = document.querySelector('.language-dropdown');
    const currentLanguage = document.querySelector('.current-language');

    function toggleLanguageMenu() {
        if (!languageDropdown) {
            return;
        }
        languageDropdown.classList.toggle('active');
    }

    // Translation data


    // ==========================================
    // TRANSLATIONS NOW LOADED FROM REST API
    // Using MPA Translation Manager Plugin
    // API Endpoint: /wp-json/mpa/v1/translations/{lang}
    // Cached in localStorage for performance
    // ==========================================
    
    // Global translations cache
    let translationsCache = {};
    
    // Load translations from REST API
    async function loadTranslations(lang) {
        // Check cache first
        if (translationsCache[lang]) {
            return translationsCache[lang];
        }
        
        // Use MPA_TRANS plugin loader
        if (window.MPA_TRANS) {
            const translations = await window.MPA_TRANS.load(lang);
            translationsCache[lang] = translations;
            return translations;
        }
        
        return {};
    }

    async function selectLanguage(lang, forceReload = false) {
        // Check if language is changing (not initial load)
        const currentLang = localStorage.getItem('selectedLanguage');
        const isChanging = currentLang && currentLang !== lang;
        
        
        // Store language preference
        localStorage.setItem('selectedLanguage', lang);
        
        // Set cookie for PHP to read (so server-side rendering matches)
        document.cookie = `mpa_language=${lang}; path=/; max-age=${86400 * 30}; SameSite=Lax`;
        
        // If language is changing OR forceReload, reload page so PHP serves correct content
        if (isChanging || forceReload) {
            window.location.reload();
            return;
        }
        
        
        // Initial load - just update UI without reload
        const translations = await loadTranslations(lang);
        
        // Update current language display
        const currentLanguage = document.querySelector('.current-language');
        if (currentLanguage) {
            currentLanguage.textContent = lang.toUpperCase();
        }
        
        // Update active states
        document.querySelectorAll('.language-option').forEach(option => {
            option.classList.remove('active');
        });
        const activeOption = document.querySelector(`[data-lang="${lang}"]`);
        if (activeOption) {
            activeOption.classList.add('active');
        }
        
        // Update mobile language options
        document.querySelectorAll('.mobile-language-option').forEach(option => {
            option.classList.remove('active');
        });
        const activeMobileOption = document.querySelector(`.mobile-language-option[data-lang="${lang}"]`);
        if (activeMobileOption) {
            activeMobileOption.classList.add('active');
        }
        
        // Close dropdown
        const languageDropdown = document.querySelector('.language-dropdown');
        if (languageDropdown) {
            languageDropdown.classList.remove('active');
        }
        
        // Apply translations with retry mechanism
        applyTranslationsWithRetry(lang, translations);
        
        // Update PDF on privacy policy page
        if ((window.location.pathname.includes('privacy-policy') || window.location.href.includes('privacy-policy')) && typeof updatePrivacyPolicyPDF === 'function') {
            updatePrivacyPolicyPDF(lang);
        } else {
        }
    }
    
    // Expose selectLanguage globally for header component integration
    window.selectLanguage = selectLanguage;

    function applyTranslationsWithRetry(lang, translations, retryCount = 0) {
        const maxRetries = 3;
        
        try {
            applyTranslations(lang, translations);
        } catch (error) {
    
            if (retryCount < maxRetries) {
                setTimeout(async () => {
                    applyTranslationsWithRetry(lang, retryCount + 1);
                }, 200);
            } else {
            }
        }
    }

    function applyTranslations(lang, translations) {
        const t = translations;
        if (!t) return;

        // Navigation translations - use data-translate attribute
        // All nav links now have data-translate attribute, handled by the generic translator below

        // Navigation buttons translations - use data attributes for reliable translation
        const signInBtns = document.querySelectorAll('[data-translate="btn-signin"]');
        const joinBtns = document.querySelectorAll('[data-translate="btn-join"]');
        
        // Update all Sign In buttons (only if translation exists)
        if (t['btn-signin']) {
            signInBtns.forEach(btn => {
                btn.textContent = t['btn-signin'];
            });
        }
        
        // Update all Join MPA buttons (only if translation exists)
        if (t['btn-join']) {
            joinBtns.forEach(btn => {
                btn.textContent = t['btn-join'];
            });
        }

        // Translate all elements with data-translate attribute
        document.querySelectorAll('[data-translate]').forEach(element => {
            const key = element.getAttribute('data-translate');
            if (t[key]) {
                if (element.tagName === 'INPUT') {
                    element.placeholder = t[key];
                } else {
                    element.textContent = t[key];
                }
            }
        });

        // Events section translations
        const eventsTitle = document.querySelector('.featured-events h2');
        const viewAllEvents = document.querySelector('.view-all');
        if (eventsTitle) eventsTitle.textContent = t['events-title'];
        if (viewAllEvents) viewAllEvents.textContent = t['view-all-events'];

        // Event cards translations - removed hardcoded event overrides
        const registerButtons = document.querySelectorAll('.event-footer .btn-outline');
        
        registerButtons.forEach(btn => {
            if (btn.textContent === 'Register') {
                btn.textContent = t['btn-register'];
            }
        });

        // About section translations
        const aboutTitle = document.querySelector('#about h2');
        const aboutTexts = document.querySelectorAll('#about p');
        if (aboutTitle) aboutTitle.textContent = t['about-title'];
        if (aboutTexts.length >= 2) {
            aboutTexts[0].textContent = t['about-text-1'];
            aboutTexts[1].textContent = t['about-text-2'];
        }

        // Features translations
        const features = document.querySelectorAll('#about .feature h4');
        const featureDescs = document.querySelectorAll('#about .feature p');
        if (features.length >= 3) {
            features[0].textContent = t['feature-community'];
            features[1].textContent = t['feature-innovation'];
            features[2].textContent = t['feature-global'];
        }
        if (featureDescs.length >= 3) {
            featureDescs[0].textContent = t['feature-community-desc'];
            featureDescs[1].textContent = t['feature-innovation-desc'];
            featureDescs[2].textContent = t['feature-global-desc'];
        }

        // Membership section translations
        const membershipTitle = document.querySelector('#membership h2');
        const membershipSubtitle = document.querySelector('#membership .section-header p');
        if (membershipTitle) membershipTitle.textContent = t['membership-title'];
        if (membershipSubtitle) membershipSubtitle.textContent = t['membership-subtitle'];

        // Membership benefits translations
        const benefitItems = document.querySelectorAll('.benefits li');
        benefitItems.forEach(item => {
            const text = item.textContent.trim();
            if (text.includes('Access to all events')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-events']}`;
            } else if (text.includes('Member directory')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-directory']}`;
            } else if (text.includes('Newsletter subscription')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-newsletter']}`;
            } else if (text.includes('Resource library')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-resources']}`;
            } else if (text.includes('All Startup benefits')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-all-startup']}`;
            } else if (text.includes('Priority event registration')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-priority']}`;
            } else if (text.includes('Networking opportunities')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-networking']}`;
            } else if (text.includes('Mentorship program')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-mentorship']}`;
            } else if (text.includes('All Professional benefits')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-all-professional']}`;
            } else if (text.includes('Speaking opportunities')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-speaking']}`;
            } else if (text.includes('Custom workshops')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-workshops']}`;
            } else if (text.includes('Board advisory')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-advisory']}`;
            }
        });

        // Join Now buttons
        const joinNowButtons = document.querySelectorAll('.membership-card .btn-primary');
        joinNowButtons.forEach(btn => {
            if (btn.textContent === 'Join Now') {
                btn.textContent = t['btn-join-now'];
            }
        });

        // Newsletter section translations
        const newsletterTitle = document.querySelector('.newsletter h2');
        const newsletterSubtitle = document.querySelector('.newsletter p');
        const newsletterPlaceholder = document.querySelector('.newsletter-form input');
        const subscribeBtn = document.querySelector('.newsletter-form .btn-primary');
        if (newsletterTitle) newsletterTitle.textContent = t['newsletter-title'];
        if (newsletterSubtitle) newsletterSubtitle.textContent = t['newsletter-subtitle'];
        if (newsletterPlaceholder) newsletterPlaceholder.placeholder = t['newsletter-placeholder'];
        if (subscribeBtn) subscribeBtn.textContent = t['btn-subscribe'];

        // Footer translations
        const footerDesc = document.querySelector('.footer-section p');
        const footerLinks = document.querySelectorAll('.footer-section h4');
        const footerCopyright = document.querySelector('.footer-bottom p');
        // if (footerDesc) footerDesc.textContent = t['footer-mpa-desc']; // Removed - using HTML content
        if (footerCopyright) footerCopyright.textContent = t['footer-copyright'];

        // Privacy Policy translations
        const privacyTitle = document.querySelector('[data-translate="privacy-title"]');
        const privacySubtitle = document.querySelector('[data-translate="privacy-subtitle"]');
        const downloadPolicy = document.querySelector('[data-translate="download-policy"]');
        const downloadDescription = document.querySelector('[data-translate="download-description"]');
        const downloadEnglish = document.querySelector('[data-translate="download-english"]');
        const downloadBahasa = document.querySelector('[data-translate="download-bahasa"]');
        
        if (privacyTitle) privacyTitle.textContent = t['privacy-title'];
        if (privacySubtitle) privacySubtitle.textContent = t['privacy-subtitle'];
        if (downloadPolicy) downloadPolicy.textContent = t['download-policy'];
        if (downloadDescription) downloadDescription.textContent = t['download-description'];
        if (downloadEnglish) downloadEnglish.textContent = t['download-english'];
        if (downloadBahasa) downloadBahasa.textContent = t['download-bahasa'];

        // Privacy Policy content translations
        const privacyIntroTitle = document.querySelector('[data-translate="privacy-intro-title"]');
        const privacyIntroText = document.querySelector('[data-translate="privacy-intro-text"]');
        const privacyDataTitle = document.querySelector('[data-translate="privacy-data-title"]');
        const privacyDataIntro = document.querySelector('[data-translate="privacy-data-intro"]');
        
        if (privacyIntroTitle) privacyIntroTitle.textContent = t['privacy-intro-title'];
        if (privacyIntroText) privacyIntroText.textContent = t['privacy-intro-text'];
        if (privacyDataTitle) privacyDataTitle.textContent = t['privacy-data-title'];
        if (privacyDataIntro) privacyDataIntro.textContent = t['privacy-data-intro'];

        // Privacy Policy data types
        const privacyIdentity = document.querySelector('[data-translate="privacy-identity"]');
        const privacyIdentityDetails = document.querySelector('[data-translate="privacy-identity-details"]');
        const privacyContact = document.querySelector('[data-translate="privacy-contact"]');
        const privacyContactDetails = document.querySelector('[data-translate="privacy-contact-details"]');
        const privacyProfessional = document.querySelector('[data-translate="privacy-professional"]');
        const privacyProfessionalDetails = document.querySelector('[data-translate="privacy-professional-details"]');
        const privacyMembership = document.querySelector('[data-translate="privacy-membership"]');
        const privacyMembershipDetails = document.querySelector('[data-translate="privacy-membership-details"]');
        const privacyTechnical = document.querySelector('[data-translate="privacy-technical"]');
        const privacyTechnicalDetails = document.querySelector('[data-translate="privacy-technical-details"]');
        
        if (privacyIdentity) privacyIdentity.textContent = t['privacy-identity'];
        if (privacyIdentityDetails) privacyIdentityDetails.textContent = t['privacy-identity-details'];
        if (privacyContact) privacyContact.textContent = t['privacy-contact'];
        if (privacyContactDetails) privacyContactDetails.textContent = t['privacy-contact-details'];
        if (privacyProfessional) privacyProfessional.textContent = t['privacy-professional'];
        if (privacyProfessionalDetails) privacyProfessionalDetails.textContent = t['privacy-professional-details'];
        if (privacyMembership) privacyMembership.textContent = t['privacy-membership'];
        if (privacyMembershipDetails) privacyMembershipDetails.textContent = t['privacy-membership-details'];
        if (privacyTechnical) privacyTechnical.textContent = t['privacy-technical'];
        if (privacyTechnicalDetails) privacyTechnicalDetails.textContent = t['privacy-technical-details'];

        // Privacy Policy purpose section
        const privacyPurposeTitle = document.querySelector('[data-translate="privacy-purpose-title"]');
        const privacyPurposeIntro = document.querySelector('[data-translate="privacy-purpose-intro"]');
        const privacyPurpose1 = document.querySelector('[data-translate="privacy-purpose-1"]');
        const privacyPurpose2 = document.querySelector('[data-translate="privacy-purpose-2"]');
        const privacyPurpose3 = document.querySelector('[data-translate="privacy-purpose-3"]');
        const privacyPurpose4 = document.querySelector('[data-translate="privacy-purpose-4"]');
        const privacyPurpose5 = document.querySelector('[data-translate="privacy-purpose-5"]');
        
        if (privacyPurposeTitle) privacyPurposeTitle.textContent = t['privacy-purpose-title'];
        if (privacyPurposeIntro) privacyPurposeIntro.textContent = t['privacy-purpose-intro'];
        if (privacyPurpose1) privacyPurpose1.textContent = t['privacy-purpose-1'];
        if (privacyPurpose2) privacyPurpose2.textContent = t['privacy-purpose-2'];
        if (privacyPurpose3) privacyPurpose3.textContent = t['privacy-purpose-3'];
        if (privacyPurpose4) privacyPurpose4.textContent = t['privacy-purpose-4'];
        if (privacyPurpose5) privacyPurpose5.textContent = t['privacy-purpose-5'];

        // Privacy Policy consent section
        const privacyConsentTitle = document.querySelector('[data-translate="privacy-consent-title"]');
        const privacyConsentText = document.querySelector('[data-translate="privacy-consent-text"]');
        const privacyDpoName = document.querySelector('[data-translate="privacy-dpo-name"]');
        const privacyDpoEmail = document.querySelector('[data-translate="privacy-dpo-email"]');
        const privacyDpoContact = document.querySelector('[data-translate="privacy-dpo-contact"]');
        
        if (privacyConsentTitle) privacyConsentTitle.textContent = t['privacy-consent-title'];
        if (privacyConsentText) privacyConsentText.textContent = t['privacy-consent-text'];
        if (privacyDpoName) privacyDpoName.textContent = t['privacy-dpo-name'];
        if (privacyDpoEmail) privacyDpoEmail.textContent = t['privacy-dpo-email'];
        if (privacyDpoContact) privacyDpoContact.textContent = t['privacy-dpo-contact'];

        // Privacy Policy rights section
        const privacyRightsTitle = document.querySelector('[data-translate="privacy-rights-title"]');
        const privacyRightsIntro = document.querySelector('[data-translate="privacy-rights-intro"]');
        const privacyRights1 = document.querySelector('[data-translate="privacy-rights-1"]');
        const privacyRights2 = document.querySelector('[data-translate="privacy-rights-2"]');
        const privacyRights3 = document.querySelector('[data-translate="privacy-rights-3"]');
        
        if (privacyRightsTitle) privacyRightsTitle.textContent = t['privacy-rights-title'];
        if (privacyRightsIntro) privacyRightsIntro.textContent = t['privacy-rights-intro'];
        if (privacyRights1) privacyRights1.textContent = t['privacy-rights-1'];
        if (privacyRights2) privacyRights2.textContent = t['privacy-rights-2'];
        if (privacyRights3) privacyRights3.textContent = t['privacy-rights-3'];

        // Privacy Policy updates section
        const privacyUpdatesTitle = document.querySelector('[data-translate="privacy-updates-title"]');
        const privacyUpdatesText = document.querySelector('[data-translate="privacy-updates-text"]');
        
        if (privacyUpdatesTitle) privacyUpdatesTitle.textContent = t['privacy-updates-title'];
        if (privacyUpdatesText) privacyUpdatesText.textContent = t['privacy-updates-text'];

        // Cookie Banner translations
        const cookieTitle = document.querySelector('[data-translate="cookie-title"]');
        const cookieText = document.querySelector('[data-translate="cookie-text"]');
        const acceptCookies = document.querySelector('[data-translate="accept-cookies"]');
        const rejectCookies = document.querySelector('[data-translate="reject-cookies"]');
        const learnMore = document.querySelector('[data-translate="learn-more"]');
        
        if (cookieTitle) cookieTitle.textContent = t['cookie-title'];
        if (cookieText) cookieText.textContent = t['cookie-text'];
        if (acceptCookies) acceptCookies.textContent = t['accept-cookies'];
        if (rejectCookies) rejectCookies.textContent = t['reject-cookies'];
        if (learnMore) learnMore.textContent = t['learn-more'];
    }

    if (languageToggle) {
        languageToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleLanguageMenu();
        });
    } else {
    }

    // Language option click handlers
    document.querySelectorAll('.language-option').forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const lang = this.getAttribute('data-lang');
            
            // Set cookie and localStorage immediately
            localStorage.setItem('selectedLanguage', lang);
            document.cookie = `mpa_language=${lang}; path=/; max-age=${86400 * 30}; SameSite=Lax`;
            
            
            // Small delay to ensure cookie is written
            setTimeout(() => {
                window.location.reload();
            }, 50);
        });
    });

    // Mobile language option click handlers
    document.querySelectorAll('.mobile-language-option').forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const lang = this.getAttribute('data-lang');
            
            // Set cookie and localStorage immediately
            localStorage.setItem('selectedLanguage', lang);
            document.cookie = `mpa_language=${lang}; path=/; max-age=${86400 * 30}; SameSite=Lax`;
            
            // Small delay to ensure cookie is written
            setTimeout(() => {
                window.location.reload();
            }, 50);
        });
    });

    // Mobile theme option click handlers - EXACTLY LIKE LANGUAGE BUTTONS
    // Mobile theme toggle is now handled with single button (mobileThemeToggle) above

    // Smooth Scrolling for Navigation Links (only for same-page links)
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            
            // Check if it's a same-page link (starts with #)
            if (targetId.startsWith('#')) {
                e.preventDefault();
                const targetSection = document.querySelector(targetId);
                
                if (targetSection) {
                    const offsetTop = targetSection.offsetTop - 80; // Account for fixed navbar
                    
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    if (mobileDropdownMenu && mobileDropdownMenu.classList.contains('active')) {
                        closeMobileMenu();
                    }
                }
            }
            // For external page links (like about.html, events.html), let them work normally
        });
    });

    // Close menu when clicking outside - runs AFTER theme button handler
    document.addEventListener('click', function(e) {
        // Don't close menu if clicking on theme buttons or language options inside menu
        const isThemeOption = e.target.closest('#mobileThemeToggle') ||
                              e.target.closest('.mobile-theme-toggle-wrapper');
        const isLanguageOption = e.target.closest('.mobile-language-option');
        const isMobileControl = e.target.closest('.mobile-menu-controls');
        
        // If clicking on mobile theme options, don't close menu
        if (isThemeOption) {
            return;
        }
        
        if (mobileDropdownMenu && mobileDropdownMenu.classList.contains('active') && 
            !mobileDropdownMenu.contains(e.target) && 
            mobileMenuToggle && !mobileMenuToggle.contains(e.target) &&
            !isLanguageOption && !isMobileControl) {
            closeMobileMenu();
        }
        
        if (languageDropdown && !languageDropdown.contains(e.target)) {
            languageDropdown.classList.remove('active');
        }
    }, false); // BUBBLE PHASE - runs after capture phase handlers

    // Close menu on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileDropdownMenu && mobileDropdownMenu.classList.contains('active')) {
            closeMobileMenu();
        }
    });

    // Navbar Background on Scroll
    const navbar = document.querySelector('.navbar');
    
    window.addEventListener('scroll', function() {
        if (navbar) {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }
    }, { passive: true });

    // Search Functionality - Now handled by individual page scripts
    // Removed to prevent conflicts with new search implementation

    // Newsletter Subscription
    const newsletterForm = document.querySelector('.newsletter-form');
    const newsletterInput = document.querySelector('.newsletter-form input');
    const newsletterBtn = document.querySelector('.newsletter-form .btn-primary');
    
    if (newsletterForm && newsletterInput && newsletterBtn) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = newsletterInput.value.trim();
            if (email && isValidEmail(email)) {
                // Implement newsletter subscription here
        
                showNotification('Thank you for subscribing to our newsletter!', 'success');
                newsletterInput.value = '';
            } else {
                showNotification('Please enter a valid email address.', 'warning');
            }
        });
    }

    // Event Registration Buttons
    const eventButtons = document.querySelectorAll('.event-card .btn-outline');
    
    eventButtons.forEach(button => {
        button.addEventListener('click', function() {
            const eventTitle = this.closest('.event-card').querySelector('.event-title').textContent;
            // Implement event registration here
    
            showNotification(`Registration for "${eventTitle}" will be implemented here.`, 'info');
        });
    });

    // Membership Join Buttons - Now handled by links to join.html
    // Removed pop-up functionality since buttons are now proper links

    // Navigation Join MPA Buttons
    const navJoinButtons = document.querySelectorAll('.nav-actions .btn-primary');

    navJoinButtons.forEach(button => {
        button.addEventListener('click', function() {
            window.location.href = 'membership.html';
        });
    });

    // Click Ripple Effect for all buttons
    const allButtons = document.querySelectorAll('.btn-primary, .btn-secondary, .btn-outline, .signin-btn, .signup-btn, .search-btn');
    

    allButtons.forEach(button => {
        button.addEventListener('click', function(e) {
    

            // Create multiple concentric ripples for flower-like effect
            const rippleCount = 3;
            const viewportWidth = window.innerWidth;
            const viewportHeight = window.innerHeight;
            const maxSize = Math.max(viewportWidth, viewportHeight) * 2;

            // Get click position relative to viewport
            const centerX = e.clientX;
            const centerY = e.clientY;

            for (let i = 0; i < rippleCount; i++) {
                setTimeout(async () => {
                    createFlowerRipple(centerX, centerY, maxSize, this, i);
                }, i * 380); // More pronounced stagger for enhanced visibility
            }
        });
    });

    function createFlowerRipple(centerX, centerY, maxSize, button, index) {
        const ripple = document.createElement('div');

        // Vary the size slightly for each ripple
        const sizeVariation = 0.8 + (index * 0.2);
        const rippleSize = maxSize * sizeVariation;

        const x = centerX - rippleSize / 2;
        const y = centerY - rippleSize / 2;

        ripple.style.width = ripple.style.height = rippleSize + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('full-page-ripple');

        // Create subtle colors for each ripple (background-appropriate)
        let colors;
        if (document.body.classList.contains('light-mode')) {
            // Light mode - subtle dark ripples
            colors = [
                ['rgba(0, 0, 0, 0.06)', 'rgba(0, 0, 0, 0.04)'],
                ['rgba(0, 0, 0, 0.04)', 'rgba(0, 0, 0, 0.03)'],
                ['rgba(0, 0, 0, 0.03)', 'rgba(0, 0, 0, 0.02)']
            ];
        } else {
            // Dark mode - subtle light ripples
            colors = [
                ['rgba(255, 255, 255, 0.12)', 'rgba(255, 255, 255, 0.08)'],
                ['rgba(255, 255, 255, 0.08)', 'rgba(255, 255, 255, 0.06)'],
                ['rgba(255, 255, 255, 0.06)', 'rgba(255, 255, 255, 0.04)']
            ];
        }

        ripple.style.background = colors[index][0];
        ripple.style.boxShadow = `0 0 0 0 ${colors[index][1]}`;

        // Add to body for full-page effect
        document.body.appendChild(ripple);


        setTimeout(async () => {
            ripple.remove();
    
        }, 2800 + (index * 200)); // Staggered cleanup for slower animation
    }

    // Intersection Observer for Animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);

    // Observe elements for animation
    const animateElements = document.querySelectorAll('.event-card, .membership-card, .feature');
    animateElements.forEach(el => observer.observe(el));

    // Utility Functions
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Add loading animation
    window.addEventListener('load', function() {
        document.body.classList.add('loaded');
    });

    // Parallax effect for hero section - REMOVED to prevent expanding behavior

    // Add hover effects for cards
    const cards = document.querySelectorAll('.event-card, .membership-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Form validation for contact forms
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Basic form validation
            const inputs = this.querySelectorAll('input[required], textarea[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('error');
                } else {
                    input.classList.remove('error');
                }
            });
            
            if (isValid) {
                // Form is valid, implement submission here
                showNotification('Form submitted successfully!', 'success');
                this.reset();
            } else {
                showNotification('Please fill in all required fields.', 'warning');
            }
        });
    });

    // Add smooth reveal animations
    const revealElements = document.querySelectorAll('.section-header, .about-text, .newsletter-content');
    revealElements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        
        setTimeout(async () => {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, index * 200);
    });

    // Event Filtering
    const filterTabs = document.querySelectorAll('.filter-tab');
    const eventCards = document.querySelectorAll('.event-card');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Update active tab
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Filter events
            eventCards.forEach(card => {
                const categories = card.getAttribute('data-category').split(' ');
                if (filter === 'all' || categories.includes(filter)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // FAQ Accordion
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const icon = this.querySelector('i');
            
            // Toggle answer visibility
            if (answer.style.maxHeight) {
                answer.style.maxHeight = null;
                icon.style.transform = 'rotate(0deg)';
            } else {
                answer.style.maxHeight = answer.scrollHeight + 'px';
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });

    // Contact Form Validation
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Basic validation
            const firstName = document.getElementById('firstName').value.trim();
            const lastName = document.getElementById('lastName').value.trim();
            const email = document.getElementById('email').value.trim();
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value.trim();
            
            if (!firstName || !lastName || !email || !subject || !message) {
                showNotification('Please fill in all required fields.', 'warning');
                return;
            }
            
            if (!isValidEmail(email)) {
                showNotification('Please enter a valid email address.', 'warning');
                return;
            }
            
            // Simulate form submission
            showNotification('Thank you for your message! We will get back to you soon.', 'success');
            contactForm.reset();
        });
    }

    // Calendar Navigation and Grid
    const prevMonthBtn = document.getElementById('prevMonth');
    const nextMonthBtn = document.getElementById('nextMonth');
    const currentMonthEl = document.getElementById('currentMonth');
    const calendarGrid = document.getElementById('calendarGrid');
    
    if (prevMonthBtn && nextMonthBtn && currentMonthEl && calendarGrid) {
    } else {
        return; // Exit early if calendar elements don't exist
    }
    
    if (prevMonthBtn && nextMonthBtn && currentMonthEl && calendarGrid) {
            // Use actual current date
            const today = new Date();
            let currentDate = new Date(today.getFullYear(), today.getMonth(), 1); // First day of current month
            
            // Debug: Log the current date to console
            
        
        // Events data will be loaded from WordPress database
        let events = [];
        
        // Load events from WordPress
        async function loadEvents() {
            try {
                const response = await fetch('/wp-content/themes/mpa-custom/get-events-json.php');
                events = await response.json();
                // Refresh calendar after loading events
                renderCalendar();
            } catch (error) {
                // Still render calendar even if events fail to load
                renderCalendar();
            }
        }
        
        // Load events when page loads
        loadEvents();
        
        // Initial calendar render will happen after events are loaded
        // No need for setTimeout here since loadEvents() will trigger renderCalendar()
        
        function getISOWeekNumber(date) {
            const d = new Date(date);
            d.setHours(0, 0, 0, 0);
            // Thursday in current week decides the year
            d.setDate(d.getDate() + 3 - (d.getDay() + 6) % 7);
            // January 4 is always in week 1
            const week1 = new Date(d.getFullYear(), 0, 4);
            // Adjust to Thursday in week 1 and count number of weeks from date to week1
            return 1 + Math.round(((d.getTime() - week1.getTime()) / 86400000 - 3 + (week1.getDay() + 6) % 7) / 7);
        }
        
        async function getPublicHolidays(year, month) {
            try {
                const response = await fetch(`https://date.nager.at/api/v3/PublicHolidays/${year}/MY`);
                const allHolidays = await response.json();
                
                // Filter holidays for current month
                const monthHolidays = allHolidays.filter(holiday => {
                    const holidayDate = new Date(holiday.date);
                    return holidayDate.getMonth() === month;
                });
                
                return monthHolidays.map(holiday => {
                    const date = new Date(holiday.date);
                    const dateString = date.toLocaleDateString('en-US', { 
                        month: 'short', 
                        day: 'numeric' 
                    });
                    return {
                        date: dateString,
                        name: holiday.localName || holiday.name
                    };
                });
            } catch (error) {
                // Fallback to static data if API fails
                return getStaticHolidays(year, month);
            }
        }
        
        function getStaticHolidays(year, month) {
            const holidays = [];
            
            // Malaysia Public Holidays 2025 (fallback data)
            const allHolidays = [
                { month: 0, day: 1, name: "New Year's Day" },
                { month: 1, day: 1, name: "Chinese New Year" },
                { month: 1, day: 2, name: "Chinese New Year Holiday" },
                { month: 4, day: 1, name: "Labour Day" },
                { month: 4, day: 22, name: "Hari Raya Aidilfitri" },
                { month: 4, day: 23, name: "Hari Raya Aidilfitri Holiday" },
                { month: 5, day: 7, name: "Wesak Day" },
                { month: 6, day: 28, name: "Hari Raya Haji" },
                { month: 7, day: 31, name: "National Day" },
                { month: 8, day: 16, name: "Malaysia Day" },
                { month: 9, day: 6, name: "Prophet Muhammad's Birthday" },
                { month: 10, day: 5, name: "Deepavali" },
                { month: 11, day: 25, name: "Christmas Day" }
            ];
            
            // Filter holidays for current month
            const monthHolidays = allHolidays.filter(holiday => holiday.month === month);
            
            monthHolidays.forEach(holiday => {
                const date = new Date(year, month, holiday.day);
                const dateString = date.toLocaleDateString('en-US', { 
                    month: 'short', 
                    day: 'numeric' 
                });
                holidays.push({
                    date: dateString,
                    name: holiday.name
                });
            });
            
            return holidays;
        }
        
        async function loadPublicHolidays(year, month) {
            const holidaysContainer = document.getElementById('publicHolidays');
            if (!holidaysContainer) return;
            
            try {
                const holidays = await getPublicHolidays(year, month);
                
                if (holidays.length > 0) {
                    holidaysContainer.innerHTML = holidays.map(holiday => `
                        <div class="public-holiday">
                            <span class="date">${holiday.date}</span>
                            <span class="holiday-name">${holiday.name}</span>
                        </div>
                    `).join('');
                    
                    // Mark holidays on calendar with red dots
                    holidays.forEach(holiday => {
                        const dateParts = holiday.date.split(' ');
                        const monthName = dateParts[0];
                        const day = parseInt(dateParts[1]);
                        
                        // Convert month name to number
                        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                        const monthIndex = monthNames.indexOf(monthName);
                        
                        if (monthIndex === month) {
                            const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                            const holidayIndicator = document.getElementById(`holiday-${dateString}`);
                            if (holidayIndicator) {
                                holidayIndicator.style.display = 'block';
                                holidayIndicator.title = holiday.name;
                            }
                        }
                    });
                } else {
                    holidaysContainer.innerHTML = '<div class="no-holidays">No public holidays this month</div>';
                }
            } catch (error) {
                holidaysContainer.innerHTML = '<div class="error">Unable to load holidays</div>';
            }
        }
        
        function renderCalendar() {
            
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                               'July', 'August', 'September', 'October', 'November', 'December'];
            
            currentMonthEl.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;
            
            // Debug: Log what month/year is being rendered
    
            
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            
            // Get first day of month and number of days
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const daysInMonth = lastDay.getDate();
            const startingDay = firstDay.getDay();
            
            // Debug: Log the first day calculation
            
            
            // Adjust starting day for Monday-first week
            // JavaScript getDay(): 0=Sunday, 1=Monday, 2=Tuesday, 3=Wednesday, 4=Thursday, 5=Friday, 6=Saturday
            // Our Monday-first order: 0=Monday, 1=Tuesday, 2=Wednesday, 3=Thursday, 4=Friday, 5=Saturday, 6=Sunday
            let adjustedStartingDay;
            if (startingDay === 0) { // Sunday
                adjustedStartingDay = 6; // Sunday becomes last column
            } else {
                adjustedStartingDay = startingDay - 1; // Monday=1 becomes 0, Tuesday=2 becomes 1, etc.
            }
            
    
            
            // Create calendar grid with weekday headers as the first row
            let calendarHTML = `
                <div class="calendar-days">
                    <div class="calendar-day weekday-header">W</div>
                    <div class="calendar-day weekday-header">Mon</div>
                    <div class="calendar-day weekday-header">Tue</div>
                    <div class="calendar-day weekday-header">Wed</div>
                    <div class="calendar-day weekday-header">Thu</div>
                    <div class="calendar-day weekday-header">Fri</div>
                    <div class="calendar-day weekday-header">Sat</div>
                    <div class="calendar-day weekday-header">Sun</div>
            `;
            
            // Add week number for first week
            let weekNumber = getISOWeekNumber(new Date(year, month, 1));
            calendarHTML += `<div class="calendar-day week-number">W${String(weekNumber).padStart(2, '0')}</div>`;
            
            // Add empty cells for days before the first day of the month
            for (let i = 0; i < adjustedStartingDay; i++) {
                calendarHTML += '<div class="calendar-day empty"></div>';
            }
            
            // Add days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const dayEvents = events.filter(event => event.date === dateString);
                
                // Debug: Log events for this day
                if (dayEvents.length > 0) {
                }
                
                const isToday = today.toDateString() === new Date(year, month, day).toDateString();
                const isPast = new Date(year, month, day) < new Date().setHours(0, 0, 0, 0);
                
                let dayClass = 'calendar-day';
                if (isToday) dayClass += ' today';
                if (isPast) dayClass += ' past';
                if (dayEvents.length > 0) dayClass += ' has-event';
                
                calendarHTML += `
                    <div class="${dayClass}" data-date="${dateString}">
                        <span class="day-number">${day}</span>
                        ${dayEvents.length > 0 ? `<div class="event-indicator" title="${dayEvents.map(e => e.title).join(', ')}"></div>` : ''}
                        <div class="holiday-indicator" id="holiday-${dateString}"></div>
                    </div>
                `;
                
                // Add week number for new weeks (after Sunday)
                const currentDate = new Date(year, month, day);
                if (currentDate.getDay() === 0 && day < daysInMonth) {
                    const nextWeekNumber = getISOWeekNumber(new Date(year, month, day + 1));
                    calendarHTML += `<div class="calendar-day week-number">W${String(nextWeekNumber).padStart(2, '0')}</div>`;
                }
            }
            
            calendarHTML += '</div>';
            
            // Add public holidays section
            calendarHTML += `
                <div class="calendar-footer" id="calendarFooter">
                    <h4>🇲🇾 Public Holidays</h4>
                    <div class="public-holidays" id="publicHolidays">
                        <div class="loading">Loading holidays...</div>
                    </div>
                </div>
            `;
            
            calendarGrid.innerHTML = calendarHTML;
            
            // Load public holidays asynchronously
            loadPublicHolidays(year, month);
            
            // Add click handlers for days with events
            const eventDays = calendarGrid.querySelectorAll('.calendar-day.has-event');
            eventDays.forEach(day => {
                day.addEventListener('click', function() {
                    const date = this.dataset.date;
                    const dayEvents = events.filter(event => event.date === date);
                    showEventDetails(dayEvents, date);
                });
            });
        }
        
        function showEventDetails(dayEvents, date) {
            const eventList = dayEvents.map(event => `
                <div class="calendar-event-item">
                    <div class="event-type ${event.type}"></div>
                    <div class="event-info">
                        <h4>${event.title}</h4>
                        <p>${new Date(date).toLocaleDateString('en-US', { 
                            weekday: 'long', 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        })}</p>
                    </div>
                </div>
            `).join('');
            
            const modal = document.createElement('div');
            modal.className = 'calendar-modal';
            modal.innerHTML = `
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Events on ${new Date(date).toLocaleDateString('en-US', { 
                            weekday: 'long', 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        })}</h3>
                        <button class="modal-close">&times;</button>
                    </div>
                    <div class="modal-body">
                        ${eventList}
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
            
            // Close modal functionality
            modal.querySelector('.modal-close').addEventListener('click', () => {
                modal.remove();
            });
            
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.remove();
                }
            });
        }
        
        prevMonthBtn.addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });
        
        nextMonthBtn.addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });
        
        // Initial calendar render happens after events are loaded via loadEvents()
        // No need for setTimeout since events loading will trigger calendar render
    } else {
    }

    // Enhanced image error handling with placeholders
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        // Handle image load error
        img.addEventListener('error', function() {
            
            // Determine the type of image based on context and use appropriate placeholder
            const parent = this.closest('.event-image, .news-image, .featured-image');
            const memberCard = this.closest('.member-card, .committee-member');
            
            if (parent) {
                // Event or news image
                if (this.closest('.event-image')) {
                    this.src = 'assets/images/placeholder-event.svg';
                } else if (this.closest('.news-image, .featured-image')) {
                    this.src = 'assets/images/placeholder-news.svg';
                }
            } else if (memberCard) {
                // Member or committee member image
                this.src = 'assets/images/placeholder-member.svg';
            } else if (this.closest('.mission-image, .president-image')) {
                // Mission or president image
                this.src = 'assets/images/placeholder-mission.svg';
            } else {
                // Generic fallback - don't replace logo images
                if (!this.classList.contains('logo-img')) {
                    this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjRkZGRkZGIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OTk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkltYWdlIG5vdCBhdmFpbGFibGU8L3RleHQ+PC9zdmc+';
                }
            }
        });
        
        // Add loading state
        img.addEventListener('load', function() {
            this.classList.add('loaded');
        });
    });
    
    // Page load completion indicator
    window.addEventListener('load', function() {
        document.body.classList.add('page-loaded');
    });
});

// Add CSS for animations
const style = document.createElement('style');
style.textContent = `
    .navbar.scrolled {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid var(--glass-border);
        box-shadow: var(--shadow-md);
    }
    
    body.light-mode .navbar.scrolled {
        background: var(--glass-bg-light);
        border-bottom: 1px solid var(--glass-border-light);
    }
    
    .nav-menu.active {
        display: flex;
        flex-direction: column;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background-color: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        padding: 1rem;
    }
    
    .hamburger.active span:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }
    
    .hamburger.active span:nth-child(2) {
        opacity: 0;
    }
    
    .hamburger.active span:nth-child(3) {
        transform: rotate(-45deg) translate(7px, -6px);
    }
    
    .animate-in {
        animation: fadeInUp 0.6s ease forwards;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .loaded {
        opacity: 1;
    }
    
    body {
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .error {
        border-color: #FF385C !important;
        box-shadow: 0 0 0 2px rgba(255, 56, 92, 0.2) !important;
    }
`;
document.head.appendChild(style);

// Year tab functionality for old members page
function initYearTabs() {
    const yearTabs = document.querySelectorAll('.year-tab');
    const committeeYears = document.querySelectorAll('.committee-year');
    
    yearTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const targetYear = tab.getAttribute('data-year');
            
            // Remove active class from all tabs and years
            yearTabs.forEach(t => t.classList.remove('active'));
            committeeYears.forEach(year => year.classList.remove('active'));
            
            // Add active class to clicked tab and corresponding year
            tab.classList.add('active');
            const targetYearElement = document.getElementById(targetYear);
            if (targetYearElement) {
                targetYearElement.classList.add('active');
            }
        });
    });
}

// Initialize year tabs if on old-members page
if (document.querySelector('.year-tabs')) {
    initYearTabs();
}

// Initialize language on page load with delay to ensure DOM is ready
document.addEventListener('DOMContentLoaded', async function() {
    let savedLanguage = localStorage.getItem('selectedLanguage') || 'en';
    
    // Check if language is set via cookie (from PHP/get_field function)
    // Priority: cookie > localStorage > default to 'en'
    const cookieLang = document.cookie.match(/mpa_language=([^;]+)/);
    if (cookieLang) {
        savedLanguage = cookieLang[1];
        localStorage.setItem('selectedLanguage', savedLanguage);
    } else {
        // If no cookie, set it from localStorage so PHP can read it
        const storedLang = localStorage.getItem('selectedLanguage');
        if (storedLang) {
            document.cookie = `mpa_language=${storedLang}; path=/; max-age=${86400 * 30}; SameSite=Lax`;
            savedLanguage = storedLang;
        }
    }
    
    // Validate that the saved language is supported
    const supportedLanguages = ['en', 'bm', 'cn'];
    if (!supportedLanguages.includes(savedLanguage)) {
        savedLanguage = 'en';
        localStorage.setItem('selectedLanguage', 'en');
        document.cookie = `mpa_language=en; path=/; max-age=${86400 * 30}; SameSite=Lax`;
    }
    
    // Update dropdown label immediately (before async selectLanguage)
    const currentLanguage = document.querySelector('.current-language');
    if (currentLanguage) {
        currentLanguage.textContent = savedLanguage.toUpperCase();
    }
    
    // Ensure cookie matches savedLanguage (sync fix)
    document.cookie = `mpa_language=${savedLanguage}; path=/; max-age=${86400 * 30}; SameSite=Lax`;
    
    // Add manual language reset option (for debugging)
    if (window.location.search.includes('reset-lang=en')) {
        savedLanguage = 'en';
        localStorage.setItem('selectedLanguage', 'en');
        if (currentLanguage) {
            currentLanguage.textContent = 'EN';
        }
    }
    
    // Add a small delay to ensure all DOM elements are fully loaded
    setTimeout(async () => {
        await selectLanguage(savedLanguage);
    }, 100);
});

// Global notification function
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? 'var(--accent-green)' : type === 'error' ? 'var(--accent-red)' : type === 'warning' ? 'var(--accent-orange)' : 'var(--accent-blue)'};
        color: white;
        padding: var(--spacing-md);
        border-radius: var(--border-radius-md);
        box-shadow: var(--shadow-md);
        z-index: 1000;
        font-weight: 500;
        animation: slideIn 0.3s ease;
        max-width: 300px;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(async () => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(async () => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}
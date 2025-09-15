// Header Loader Script
document.addEventListener('DOMContentLoaded', function() {
    // Wait a bit for other scripts to load first
    setTimeout(() => {
        loadHeader();
    }, 100);
});

function loadHeader() {
    // All pages are in the same directory as components, so use relative path
    fetch('components/header.html')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(html => {
            // Find the header placeholder or create one
            let headerPlaceholder = document.querySelector('.header-placeholder');
            if (!headerPlaceholder) {
                // If no placeholder, prepend to body
                document.body.insertAdjacentHTML('afterbegin', html);
            } else {
                headerPlaceholder.innerHTML = html;
            }
            
            // Re-initialize header functionality after loading
            initializeHeaderFunctionality();
            
            // Re-apply current theme and language
            reapplyCurrentSettings();
        })
        .catch(error => {
            console.error('Error loading header:', error);
            console.log('Current URL:', window.location.href);
            console.log('Current pathname:', window.location.pathname);
        });
}

function initializeHeaderFunctionality() {
    // Re-initialize theme toggle functionality
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle && typeof cycleTheme === 'function') {
        // Remove any existing event listeners to prevent duplicates
        themeToggle.replaceWith(themeToggle.cloneNode(true));
        const newThemeToggle = document.getElementById('themeToggle');
        newThemeToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            cycleTheme();
        });
    }
    
    // Re-initialize language dropdown functionality
    const languageToggle = document.getElementById('languageToggle');
    const languageDropdown = document.querySelector('.language-dropdown');
    
    if (languageToggle && languageDropdown) {
        // Remove any existing event listeners to prevent duplicates
        languageToggle.replaceWith(languageToggle.cloneNode(true));
        const newLanguageToggle = document.getElementById('languageToggle');
        newLanguageToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            languageDropdown.classList.toggle('active');
        });
    }
    
    // Re-initialize language option click handlers
    document.querySelectorAll('.language-option').forEach(option => {
        option.addEventListener('click', function() {
            const lang = this.getAttribute('data-lang');
            if (typeof selectLanguage === 'function') {
                selectLanguage(lang);
            }
        });
    });
    
    // Re-initialize mobile language option click handlers
    document.querySelectorAll('.mobile-language-option').forEach(option => {
        option.addEventListener('click', function() {
            const lang = this.getAttribute('data-lang');
            if (typeof selectLanguage === 'function') {
                selectLanguage(lang);
            }
        });
    });
    
    // Re-initialize mobile menu functionality
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mobileDropdownMenu = document.getElementById('mobileDropdownMenu');
    
    if (mobileMenuToggle && mobileDropdownMenu) {
        mobileMenuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleMobileMenu();
        });
    }
    
    // Re-initialize Join MPA button functionality
    const joinButtons = document.querySelectorAll('.btn-primary[data-translate="btn-join"]');
    joinButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = 'join.html';
        });
    });
    
    // Re-initialize navbar scroll functionality
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (languageDropdown && !languageDropdown.contains(e.target)) {
            languageDropdown.classList.remove('active');
        }
        
        if (mobileDropdownMenu && mobileDropdownMenu.classList.contains('active') && 
            !mobileDropdownMenu.contains(e.target) && 
            !mobileMenuToggle.contains(e.target)) {
            closeMobileMenu();
        }
    });
    
    // Close menu on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (languageDropdown && languageDropdown.classList.contains('active')) {
                languageDropdown.classList.remove('active');
            }
            if (mobileDropdownMenu && mobileDropdownMenu.classList.contains('active')) {
                closeMobileMenu();
            }
        }
    });
}

function toggleMobileMenu() {
    const mobileDropdownMenu = document.getElementById('mobileDropdownMenu');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    
    if (!mobileDropdownMenu || !mobileMenuToggle) return;
    
    const isActive = mobileDropdownMenu.classList.contains('active');
    
    if (isActive) {
        closeMobileMenu();
    } else {
        openMobileMenu();
    }
}

function openMobileMenu() {
    const mobileDropdownMenu = document.getElementById('mobileDropdownMenu');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    
    if (!mobileDropdownMenu || !mobileMenuToggle) return;
    
    mobileDropdownMenu.classList.add('active');
    mobileMenuToggle.classList.add('active');
    
    // Add entrance animation to menu items
    const menuItems = mobileDropdownMenu.querySelectorAll('.mobile-dropdown-link');
    menuItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateX(-10px)';
        setTimeout(() => {
            item.style.transition = 'all 0.2s ease';
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        }, 50 + (index * 30));
    });
}

function closeMobileMenu() {
    const mobileDropdownMenu = document.getElementById('mobileDropdownMenu');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    
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

function reapplyCurrentSettings() {
    // Re-apply current theme
    if (typeof checkAndUpdateTheme === 'function') {
        checkAndUpdateTheme();
    }
    
    // Re-apply current language
    const savedLanguage = localStorage.getItem('selectedLanguage') || 'en';
    if (typeof selectLanguage === 'function') {
        // Small delay to ensure DOM is ready
        setTimeout(() => {
            selectLanguage(savedLanguage);
        }, 50);
    }
}

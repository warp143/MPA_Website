// Emergency fix for dropdowns if admin bar breaks things
document.addEventListener('DOMContentLoaded', function() {
    // Give admin bar time to fail, then reinit our dropdowns
    setTimeout(function() {
        const themeToggle = document.getElementById('themeToggle');
        const languageToggle = document.getElementById('languageToggle');
        const languageMenu = document.getElementById('languageMenu');
        
        if (themeToggle && !themeToggle.hasAttribute('data-listener-added')) {
            themeToggle.addEventListener('click', function() {
                const html = document.documentElement;
                const currentTheme = html.getAttribute('data-theme') || 'dark';
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                html.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
            });
            themeToggle.setAttribute('data-listener-added', 'true');
            console.log('✅ Theme toggle reinitialized');
        }
        
        if (languageToggle && languageMenu && !languageToggle.hasAttribute('data-listener-added')) {
            languageToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                languageMenu.classList.toggle('active');
            });
            languageToggle.setAttribute('data-listener-added', 'true');
            console.log('✅ Language toggle reinitialized');
            
            // Close on outside click
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.language-dropdown')) {
                    languageMenu.classList.remove('active');
                }
            });
        }
    }, 100);
});
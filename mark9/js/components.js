// Component Loader
async function loadComponent(elementId, componentPath) {
    try {
        const response = await fetch(componentPath);
        const html = await response.text();
        document.getElementById(elementId).innerHTML = html;
    } catch (error) {
        console.error('Error loading component:', error);
    }
}

// Load components when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Load pillars component if element exists
    const pillarsElement = document.getElementById('mpa-pillars-component');
    if (pillarsElement) {
        loadComponent('mpa-pillars-component', 'components/pillars.html');
    }
});

// Expose selectLanguage function globally for header component integration
window.selectLanguage = window.selectLanguage || function(lang) {
    console.warn('selectLanguage function not available - language switching may not work properly');
};

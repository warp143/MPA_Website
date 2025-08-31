// Footer Loader Script
document.addEventListener('DOMContentLoaded', function() {
    loadFooter();
});

function loadFooter() {
    fetch('components/footer.html')
        .then(response => response.text())
        .then(html => {
            // Find the footer placeholder or create one
            let footerPlaceholder = document.querySelector('.footer-placeholder');
            if (!footerPlaceholder) {
                // If no placeholder, append to body
                document.body.insertAdjacentHTML('beforeend', html);
            } else {
                footerPlaceholder.innerHTML = html;
            }
        })
        .catch(error => {
            console.error('Error loading footer:', error);
        });
}

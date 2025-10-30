<?php get_header(); ?>

<!-- Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="hero-content">
            <h1><?php the_title(); ?></h1>
            <p><?php 
                $hero_description = get_post_meta(get_the_ID(), '_hero_description', true);
                echo $hero_description ?: 'Protecting your personal data and ensuring transparency in how we handle your information';
            ?></p>
        </div>
        <div class="hero-image">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large', array('alt' => get_the_title() . ' Hero')); ?>
            <?php else : ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/privacy-hero.jpg" alt="<?php echo esc_attr(get_the_title()); ?>">
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Privacy Policy Content -->
<section class="privacy-content">
    <!-- Privacy Policy Content Display -->
    <div class="container">
        <div class="privacy-content-display" id="privacyContent">
            <!-- Content will be loaded here dynamically -->
        </div>
    </div>

    <!-- Download Section -->
    <div class="container">
        <div class="download-section">
            <h3 data-translate="download-policy">Download Privacy Policy</h3>
            <p data-translate="download-description">Download the privacy policy in your preferred language</p>
            <div class="download-buttons">
                <a href="<?php echo get_template_directory_uri(); ?>/assets/MPA - Privacy Policy - English.pdf" class="btn-outline" download>
                    <i class="fas fa-download"></i>
                    <span data-translate="download-english">English PDF</span>
                </a>
                <a href="<?php echo get_template_directory_uri(); ?>/assets/MPA - Privacy Policy - Bahasa.pdf" class="btn-outline" download>
                    <i class="fas fa-download"></i>
                    <span data-translate="download-bahasa">Bahasa Malaysia PDF</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Cookie Consent Banner -->
<div class="cookie-banner" id="cookieBanner">
    <div class="container">
        <div class="cookie-content">
            <div class="cookie-text">
                <h4 data-translate="cookie-title">Cookie & Privacy Notice</h4>
                <p data-translate="cookie-text">We use cookies and similar technologies to enhance your browsing experience, analyze site traffic, and personalize content. By continuing to use our website, you consent to our use of cookies in accordance with our Privacy Policy.</p>
            </div>
            <div class="cookie-actions">
                <button class="btn-primary" id="acceptCookies" data-translate="accept-cookies">Accept All</button>
                <button class="btn-outline" id="rejectCookies" data-translate="reject-cookies">Reject</button>
                <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>" class="btn-outline" data-translate="learn-more">Learn More</a>
            </div>
        </div>
    </div>
</div>

<script>
    // Privacy Policy specific functionality
    document.addEventListener('DOMContentLoaded', function() {
        const privacyContent = document.getElementById('privacyContent');

        // Function to update privacy policy content based on language
        window.updatePrivacyPolicyContent = function(lang) {
            console.log('updatePrivacyPolicyContent called with lang:', lang, 'on page:', window.location.pathname); // Debug
            
            let markdownFile;
            
            if (lang === 'bm') {
                markdownFile = '<?php echo get_template_directory_uri(); ?>/assets/MPA_Privacy_Policy_Bahasa.md';
            } else if (lang === 'cn') {
                markdownFile = '<?php echo get_template_directory_uri(); ?>/assets/MPA_Privacy_Policy_Chinese.md';
            } else {
                // Default to English for 'en'
                markdownFile = '<?php echo get_template_directory_uri(); ?>/assets/MPA_Privacy_Policy_English.md';
            }
            
            // Load markdown content
            console.log('Attempting to fetch:', markdownFile); // Debug
            fetch(markdownFile)
                .then(response => {
                    console.log('Fetch response status:', response.status); // Debug
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.text();
                })
                .then(content => {
                    console.log('Content loaded successfully, length:', content.length); // Debug
                    // Convert markdown to HTML (basic conversion)
                    const htmlContent = convertMarkdownToHtml(content);
                    privacyContent.innerHTML = htmlContent;
                })
                .catch(error => {
                    console.error('Error loading privacy policy content:', error);
                    privacyContent.innerHTML = '<p>Error loading privacy policy content. Please try again.</p>';
                });
            
            console.log('Loading markdown file:', markdownFile); // Debug
        };

        // Basic markdown to HTML converter
        function convertMarkdownToHtml(markdown) {
            let html = markdown;
            
            // Convert headers
            html = html.replace(/^### (.*$)/gim, '<h3>$1</h3>');
            html = html.replace(/^## (.*$)/gim, '<h2>$1</h2>');
            html = html.replace(/^# (.*$)/gim, '<h1>$1</h1>');
            
            // Convert bold text
            html = html.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            
            // Convert italic text
            html = html.replace(/\*(.*?)\*/g, '<em>$1</em>');
            
            // Convert lists
            html = html.replace(/^- (.*$)/gim, '<li>$1</li>');
            html = html.replace(/(<li>.*<\/li>)/s, '<ul>$1</ul>');
            
            // Convert line breaks
            html = html.replace(/\n\n/g, '</p><p>');
            html = html.replace(/\n/g, '<br>');
            
            // Wrap in paragraphs
            html = '<p>' + html + '</p>';
            
            // Clean up empty paragraphs
            html = html.replace(/<p><\/p>/g, '');
            html = html.replace(/<p><br><\/p>/g, '');
            
            return html;
        }

        // Make the function globally available
        window.updatePrivacyPolicyContent = updatePrivacyPolicyContent;

        // Initialize with current language
        const currentLang = localStorage.getItem('selectedLanguage') || 'en';
        
        // Override the default language selection for privacy policy page
        const originalSelectLanguage = window.selectLanguage;
        window.selectLanguage = function(lang) {
            // Call original function for navigation and other translations
            if (originalSelectLanguage) {
                originalSelectLanguage(lang);
            }
            
            // Update privacy policy content
            updatePrivacyPolicyContent(lang);
        };
        
        // Load content immediately
        updatePrivacyPolicyContent(currentLang);
        
        // Fallback: try loading again after a short delay
        setTimeout(() => {
            if (!privacyContent.innerHTML || privacyContent.innerHTML.includes('Content will be loaded')) {
                console.log('Fallback: Loading privacy policy content...');
                updatePrivacyPolicyContent(currentLang);
            }
        }, 1000);

        // Cookie Banner
        const cookieBanner = document.getElementById('cookieBanner');
        const acceptCookies = document.getElementById('acceptCookies');
        const rejectCookies = document.getElementById('rejectCookies');

        // Check if user has already made a choice
        const cookieChoice = localStorage.getItem('cookieChoice');
        if (cookieChoice) {
            cookieBanner.style.display = 'none';
        }

        acceptCookies.addEventListener('click', function() {
            localStorage.setItem('cookieChoice', 'accepted');
            cookieBanner.style.display = 'none';
            showNotification('Cookie preferences saved. Thank you!', 'success');
        });

        rejectCookies.addEventListener('click', function() {
            localStorage.setItem('cookieChoice', 'rejected');
            cookieBanner.style.display = 'none';
            showNotification('Cookie preferences saved. Some features may be limited.', 'info');
        });
    });
</script>

<?php get_footer(); ?>

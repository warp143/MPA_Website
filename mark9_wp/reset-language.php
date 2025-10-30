<!DOCTYPE html>
<html>
<head>
    <title>Reset Language to English</title>
</head>
<body>
    <h1>Language Reset Tool</h1>
    <p>Click the button below to reset the language to English:</p>
    <button onclick="resetLanguage()">Reset to English</button>
    <p id="status"></p>
    
    <script>
    function resetLanguage() {
        // Clear the saved language preference
        localStorage.removeItem('selectedLanguage');
        
        // Set it explicitly to English
        localStorage.setItem('selectedLanguage', 'en');
        
        document.getElementById('status').innerHTML = '✅ Language reset to English! You can now go back to your homepage.';
        
        // Optional: redirect back to homepage after 2 seconds
        setTimeout(() => {
            window.location.href = '/';
        }, 2000);
    }
    
    // Show current language
    const currentLang = localStorage.getItem('selectedLanguage') || 'not set';
    document.getElementById('status').innerHTML = 'Current language: ' + currentLang;
    </script>
</body>
</html>

# Complete Guide: Rebuilding Static HTML Pages to WordPress Templates

## Overview
This guide explains how to convert static HTML pages from the `mark9/` folder into dynamic WordPress templates in the `mark9_wp/` WordPress installation. This process ensures 100% identical replication while making the content manageable through WordPress.

## Project Structure
```
MPA_Website/
├── mark9/                          # Static HTML source files
│   ├── index.html                  # Homepage
│   ├── proptech.html              # PropTech page
│   ├── association.html           # Association page
│   ├── members.html               # Members directory
│   ├── events.html                # Events page
│   ├── news.html                  # News page
│   ├── partners.html              # Partners page
│   ├── styles.css                 # Main stylesheet
│   ├── script.js                  # Main JavaScript
│   └── assets/                    # Images and icons
└── mark9_wp/                      # WordPress installation
    └── wp-content/themes/mpa-custom/  # Custom theme
        ├── index.php              # Homepage template
        ├── page-{slug}.php        # Specific page templates
        ├── header.php             # Header component
        ├── footer.php             # Footer component
        ├── style.css              # Theme stylesheet
        └── assets/                # Local images and resources
```

## Step-by-Step Rebuilding Process

### Step 1: Analyze the Source HTML File

1. **Read the original HTML file completely**
   ```bash
   # Example: Read the source file
   cat mark9/proptech.html
   ```

2. **Identify key components:**
   - Page title and meta information
   - Hero section content
   - Main content sections
   - Images and their sources
   - JavaScript functionality
   - External resources (fonts, CDNs, etc.)

3. **Note external dependencies:**
   - External images (Pexels, proptech.org.my, etc.)
   - CDN resources (Font Awesome, Google Fonts)
   - JavaScript libraries

### Step 2: Create WordPress Page in Database

WordPress needs a page entry in the database to route URLs correctly.

1. **Create a temporary PHP script:**
   ```php
   <?php
   // create-{page-name}-page.php
   require_once('wp-config.php');
   require_once('wp-load.php');

   // Create the page
   $page_data = array(
       'post_title'    => 'Page Title',
       'post_name'     => 'page-slug',
       'post_content'  => 'This page content is managed by the template.',
       'post_status'   => 'publish',
       'post_type'     => 'page'
   );

   $page_id = wp_insert_post($page_data);
   
   if ($page_id) {
       echo "Page created successfully with ID: $page_id\n";
   } else {
       echo "Failed to create page\n";
   }
   ?>
   ```

2. **Run the script:**
   ```bash
   cd mark9_wp
   php create-{page-name}-page.php
   rm create-{page-name}-page.php  # Clean up
   ```

### Step 3: Download and Organize Assets

1. **Identify external images in the HTML:**
   ```bash
   # Find all image sources
   grep -o 'src="[^"]*"' mark9/proptech.html
   ```

2. **Download external images:**
   ```bash
   # Create assets directory if it doesn't exist
   mkdir -p mark9_wp/wp-content/themes/mpa-custom/assets

   # Download Pexels images
   curl -o mark9_wp/wp-content/themes/mpa-custom/assets/hero-image.jpg \
        "https://images.pexels.com/photos/3183150/pexels-photo-3183150.jpeg?w=600&h=400&fit=crop&crop=center"

   # Download proptech.org.my images
   curl -o mark9_wp/wp-content/themes/mpa-custom/assets/member-photo.webp \
        "https://proptech.org.my/wp-content/uploads/2024/07/Daniele-Gambero.webp"
   ```

3. **Copy existing local assets:**
   ```bash
   # Copy from mark9 assets to WordPress theme assets
   cp mark9/assets/Andrew.png mark9_wp/wp-content/themes/mpa-custom/assets/
   cp mark9/assets/*.svg mark9_wp/wp-content/themes/mpa-custom/assets/
   ```

### Step 4: Create WordPress Template File

1. **Create the template file:**
   ```bash
   # Template naming convention: page-{slug}.php
   touch mark9_wp/wp-content/themes/mpa-custom/page-proptech.php
   ```

2. **Template structure:**
   ```php
   <?php get_header(); ?>

   <!-- Copy HTML content from mark9/{page}.html -->
   <!-- Replace static paths with WordPress functions -->

   <?php get_footer(); ?>
   ```

### Step 5: Convert Static HTML to WordPress Template

#### A. Replace Static Asset Paths
```html
<!-- BEFORE (Static HTML) -->
<img src="assets/hero-image.jpg" alt="Hero">
<link rel="stylesheet" href="styles.css">

<!-- AFTER (WordPress Template) -->
<img src="<?php echo get_template_directory_uri(); ?>/assets/hero-image.jpg" alt="Hero">
<!-- CSS is loaded via functions.php -->
```

#### B. Replace Navigation Links
```html
<!-- BEFORE (Static HTML) -->
<a href="proptech.html">PropTech</a>
<a href="association.html">Association</a>

<!-- AFTER (WordPress Template) -->
<a href="<?php echo esc_url(home_url('/proptech/')); ?>">PropTech</a>
<a href="<?php echo esc_url(home_url('/association/')); ?>">Association</a>
```

#### C. Handle External Resources
```html
<!-- BEFORE (External CDN) -->
<img src="https://images.pexels.com/photos/3183150/..." alt="Hero">

<!-- AFTER (Local Asset) -->
<img src="<?php echo get_template_directory_uri(); ?>/assets/hero-image.jpg" alt="Hero">
```

### Step 6: Complete Template Example

Here's a complete example of converting `proptech.html`:

```php
<?php get_header(); ?>

<!-- Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="hero-content">
            <h1>PropTech Innovation</h1>
            <p>Transforming Malaysia's Property Landscape Through Technology</p>
        </div>
        <div class="hero-image">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/proptech-hero.jpg" alt="PropTech Hero">
        </div>
    </div>
</section>

<!-- PropTech Introduction -->
<section class="proptech-intro">
    <div class="container">
        <div class="intro-content">
            <div class="intro-text">
                <h2>What is PropTech?</h2>
                <p>Property Technology (PropTech) represents the digital transformation...</p>
                <!-- Copy exact content from mark9/proptech.html -->
            </div>
            <div class="intro-image">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/proptech-innovation.jpg" alt="PropTech Innovation">
            </div>
        </div>
    </div>
</section>

<!-- Continue with all sections from original HTML -->

<?php get_footer(); ?>
```

### Step 7: Test and Verify

1. **Test the page:**
   ```bash
   # Check if page loads
   curl -s http://localhost:8000/proptech/ | grep -c "PropTech Innovation"
   
   # Check for broken images
   curl -s http://localhost:8000/proptech/ | grep -o 'src="[^"]*"' | grep -v "<?php"
   ```

2. **Verify all sections:**
   - Hero section displays correctly
   - All images load properly
   - Navigation links work
   - JavaScript functionality works
   - Mobile responsiveness maintained

### Step 8: Handle Special Cases

#### Committee Member Photos (External URLs)
```php
<!-- Use placeholder for missing external images -->
<img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder-member.svg" 
     alt="<?php echo $member_name; ?>">

<!-- Or download and use local images -->
<img src="<?php echo get_template_directory_uri(); ?>/assets/daniele-gambero.webp" 
     alt="Dr. Daniele Gambero">
```

#### JavaScript Functionality
```html
<!-- Copy JavaScript from mark9/script.js or inline scripts -->
<script>
// SDG Tabs functionality (from association.html)
function initSDGTabs() {
    const sdgTabs = document.querySelectorAll('.sdg-tab');
    // ... rest of JavaScript
}
</script>
```

#### Dynamic Content
```php
<!-- For future dynamic content -->
<?php while (have_posts()) : the_post(); ?>
    <h1><?php the_title(); ?></h1>
    <div><?php the_content(); ?></div>
<?php endwhile; ?>
```

## Quality Checklist

### Before Deployment:
- [ ] All images load correctly (no 404s)
- [ ] All navigation links work
- [ ] JavaScript functionality works
- [ ] Mobile responsive design maintained
- [ ] Page loads without errors
- [ ] Content is 100% identical to original
- [ ] External dependencies are localized
- [ ] WordPress page exists in database
- [ ] Template file follows naming convention

### Testing Commands:
```bash
# Test page accessibility
curl -I http://localhost:8000/proptech/

# Count specific elements
curl -s http://localhost:8000/proptech/ | grep -c "section class"

# Check for broken images
curl -s http://localhost:8000/proptech/ | grep "404"

# Verify JavaScript loads
curl -s http://localhost:8000/proptech/ | grep -c "script"
```

## File Organization Best Practices

### Assets Management:
```
mark9_wp/wp-content/themes/mpa-custom/assets/
├── images/
│   ├── placeholder-member.svg      # Fallback images
│   └── committee/                  # Committee photos
├── proptech-hero.jpg              # Page-specific images
├── proptech-innovation.jpg
├── association-hero.jpg
├── Andrew.png                      # Local member photos
└── *.svg                          # Icon files
```

### Template Naming:
- `page-proptech.php` → `/proptech/` URL
- `page-association.php` → `/association/` URL  
- `page-members.php` → `/members/` URL
- `page-events.php` → `/events/` URL

## Common Issues and Solutions

### Issue 1: Page Shows Homepage Content
**Cause:** WordPress page doesn't exist in database
**Solution:** Create page using `wp_insert_post()` script

### Issue 2: Images Don't Load
**Cause:** Incorrect path or missing files
**Solution:** Use `get_template_directory_uri()` and verify file exists

### Issue 3: JavaScript Errors
**Cause:** Missing DOM elements or function conflicts
**Solution:** Add conditional checks and ensure proper loading order

### Issue 4: Styling Issues
**Cause:** CSS conflicts or missing classes
**Solution:** Verify all CSS classes exist in `style.css`

## Automation Script Example

```bash
#!/bin/bash
# rebuild-page.sh - Automate page rebuilding process

PAGE_NAME=$1
if [ -z "$PAGE_NAME" ]; then
    echo "Usage: ./rebuild-page.sh <page-name>"
    exit 1
fi

echo "Rebuilding $PAGE_NAME page..."

# Step 1: Read original HTML
echo "Reading mark9/$PAGE_NAME.html..."

# Step 2: Create WordPress page
echo "Creating WordPress page..."
cat > create-$PAGE_NAME-page.php << EOF
<?php
require_once('wp-config.php');
require_once('wp-load.php');
\$page_data = array(
    'post_title' => ucfirst($PAGE_NAME),
    'post_name' => $PAGE_NAME,
    'post_content' => 'Content managed by template.',
    'post_status' => 'publish',
    'post_type' => 'page'
);
\$page_id = wp_insert_post(\$page_data);
echo "Page created: \$page_id\n";
EOF

cd mark9_wp
php create-$PAGE_NAME-page.php
rm create-$PAGE_NAME-page.php

# Step 3: Create template file
echo "Creating template file..."
touch wp-content/themes/mpa-custom/page-$PAGE_NAME.php

echo "Template created: page-$PAGE_NAME.php"
echo "Next: Copy HTML content and replace static paths with WordPress functions"
```

## Summary

This process ensures:
1. **100% Content Fidelity** - Exact replication of original HTML
2. **WordPress Integration** - Proper routing and template system
3. **Asset Management** - Local hosting of all resources
4. **Maintainability** - Clean, organized code structure
5. **Performance** - Optimized loading and caching

Follow this guide for each page conversion to maintain consistency and quality across the entire WordPress site.

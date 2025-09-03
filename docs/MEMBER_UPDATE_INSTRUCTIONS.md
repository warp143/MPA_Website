# Committee Member Update Instructions

## Overview
This guide explains how to update committee member information including images, names, positions, and contact details in the WordPress MPA website.

## Method 1: File-Based Updates (Recommended for Images)

### 1.1 Adding New Member Images

#### Step 1: Copy Image to Theme Assets
```bash
# Copy the new image to the theme assets folder
cp "path/to/new-image.jpg" "mark9_wp/wp-content/themes/mpa-custom/assets/member-name.jpg"

# Example for Dato Joseph
cp "WhatsApp Image 2025-09-03 at 17.34.57.jpeg" "mark9_wp/wp-content/themes/mpa-custom/assets/dato-joseph-hii.jpeg"
```

#### Step 2: Update the PHP File
Edit `mark9_wp/wp-content/themes/mpa-custom/page-association.php`:

```php
<!-- Before (placeholder) -->
<img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder-member.svg" alt="Member Name">

<!-- After (actual image) -->
<img src="<?php echo get_template_directory_uri(); ?>/assets/member-name.jpg" alt="Member Name">
```

#### Step 3: Update Member Information
```php
<div class="committee-member">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/member-name.jpg" alt="Member Full Name">
    <h3>Member Full Name</h3>
    <p class="position">Position 1, Position 2</p>
    <div class="position-description">
        <p>• Task description 1</p>
        <p>• Task description 2</p>
        <p>• Task description 3</p>
    </div>
    <div class="member-contact">
        <a href="https://website.com" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
        <a href="mailto:email@domain.com" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
        <a href="https://linkedin.com/in/profile" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
    </div>
</div>
```

### 1.2 Image File Naming Convention
- Use lowercase letters
- Replace spaces with hyphens
- Use descriptive names
- Include member's name or identifier

**Examples:**
- `dato-joseph-hii.jpeg`
- `michele-tan.webp`
- `andrew-michael-kho.png`

## Method 2: Database Updates (For Complex Changes)

### 2.1 Connect to Database
```bash
mysql -u root mark9_wp
```

### 2.2 Add Image to Media Library
```sql
INSERT INTO wp_posts (
    post_author, post_date, post_date_gmt, post_content, post_title, 
    post_excerpt, post_status, comment_status, ping_status, post_password, 
    post_name, to_ping, pinged, post_modified, post_modified_gmt, 
    post_content_filtered, post_parent, guid, menu_order, post_type, 
    post_mime_type, comment_count
) VALUES (
    1, NOW(), UTC_TIMESTAMP(), '', 'member-image-name', '', 'inherit', 
    'open', 'closed', '', 'member-image-name', '', '', NOW(), 
    UTC_TIMESTAMP(), '', 0, 'http://localhost:8000/wp-content/uploads/2025/09/member-image-name.jpg', 
    0, 'attachment', 'image/jpeg', 0
);
```

## Common Update Scenarios

### 3.1 Adding Member Photo
1. Copy image to theme assets folder
2. Update PHP file with new image path
3. Test image display

### 3.2 Changing Member Name
1. Update `<h3>` tag content
2. Update `alt` attribute in image tag
3. Update any references in content

### 3.3 Updating Positions
1. Modify position text in `<p class="position">`
2. Update or add relevant task descriptions
3. Ensure tasks match the new positions

### 3.4 Updating Contact Information
1. Update website URL in href attribute
2. Update email address in mailto link
3. Update LinkedIn profile URL
4. Verify all links work correctly

## Troubleshooting

### 4.1 Image Not Displaying
**Problem**: Image shows as broken or placeholder
**Solutions**:
- Check file path is correct
- Verify image file exists in assets folder
- Check file permissions
- Clear browser cache

### 4.2 Wrong Image Path
**Problem**: Image loads from wrong location
**Solutions**:
- Use `get_template_directory_uri()` for theme assets
- Use `wp_upload_dir()` for uploads folder
- Verify relative path structure

## Best Practices

### 5.1 Image Management
- Use appropriate image formats (JPEG for photos, PNG for logos)
- Optimize images for web (compress, resize if needed)
- Use descriptive filenames
- Keep images in organized folder structure

### 5.2 Code Organization
- Follow existing HTML structure
- Use consistent naming conventions
- Comment complex changes
- Test changes before committing

## File Locations Reference

### 6.1 Theme Files
- **Main association page**: `mark9_wp/wp-content/themes/mpa-custom/page-association.php`
- **Theme assets**: `mark9_wp/wp-content/themes/mpa-custom/assets/`
- **CSS styles**: `mark9_wp/wp-content/themes/mpa-custom/style.css`

### 6.2 WordPress Uploads
- **Upload directory**: `mark9_wp/wp-content/uploads/`
- **Media library**: Database table `wp_posts` with `post_type = 'attachment'`

## Quick Reference Commands

### 7.1 File Operations
```bash
# Copy new image
cp "source-image.jpg" "mark9_wp/wp-content/themes/mpa-custom/assets/member-name.jpg"

# Check file exists
ls -la "mark9_wp/wp-content/themes/mpa-custom/assets/"

# View file permissions
stat "mark9_wp/wp-content/themes/mpa-custom/assets/member-name.jpg"
```

### 7.2 Git Operations
```bash
# Check changes
git status

# Add changes
git add .

# Commit changes
git commit -m "Update committee member: [Member Name] - [Change Description]"

# Push changes
git push origin main
```

---

## Example: Complete Member Update

### Before (Placeholder)
```php
<div class="committee-member">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder-member.svg" alt="Member Name">
    <h3>Member Name</h3>
    <p class="position">Old Position</p>
    <div class="position-description">
        <p>• Old task description</p>
    </div>
    <div class="member-contact">
        <a href="#" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
        <a href="mailto:old@email.com" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
        <a href="#" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
    </div>
</div>
```

### After (Updated)
```php
<div class="committee-member">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/new-member-photo.jpg" alt="New Full Name">
    <h3>New Full Name</h3>
    <p class="position">New Position 1, New Position 2</p>
    <div class="position-description">
        <p>• New task description 1</p>
        <p>• New task description 2</p>
        <p>• New task description 3</p>
    </div>
    <div class="member-contact">
        <a href="https://new-website.com" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
        <a href="mailto:new@email.com" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
        <a href="https://linkedin.com/in/new-profile" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
    </div>
</div>
```

---

*Last updated: September 2025*
*For WordPress MPA Committee Members Management*

# MPA - Malaysia PropTech Association WordPress Theme

A modern, creative WordPress theme for the Malaysia PropTech Association featuring neumorphic design and interactive elements.

## Features

### Design & User Experience
- **Neumorphic Design**: Soft shadows, rounded corners, and subtle depth effects
- **Responsive Layout**: Mobile-first approach with adaptive navigation
- **Interactive Elements**: Hover effects, smooth animations, and particle systems
- **Modern Typography**: Google Fonts (Inter, Space Grotesk) integration
- **Icon Integration**: Font Awesome icons throughout the theme

### WordPress Integration
- **Custom Post Types**: Committee Members, Events, News
- **Custom Taxonomies**: Event Categories, Committee Roles
- **Custom Fields**: Advanced Custom Fields integration for detailed content management
- **Theme Customizer**: Easy customization of colors, content, and settings
- **Widget Areas**: Footer widget support
- **SEO Optimized**: Clean code structure and semantic HTML

### Content Management
- **Dynamic Committee Section**: Manage committee members via WordPress admin
- **Event Management**: Add, edit, and organize events with dates and locations
- **News Timeline**: Publish and manage news articles
- **Contact Information**: Customizable contact details
- **Social Media Integration**: Easy social media link management

## Installation

### Prerequisites
- WordPress 5.0 or higher
- PHP 7.4 or higher
- MySQL 5.6 or higher

### Step 1: Upload Theme
1. Download the theme files
2. Upload the `mpa-wordpress-theme` folder to `/wp-content/themes/`
3. Activate the theme in WordPress Admin → Appearance → Themes

### Step 2: Install Required Plugins
The theme works best with these plugins:

#### Required Plugins
- **Advanced Custom Fields PRO** (for custom fields)
  - Download from: https://www.advancedcustomfields.com/
  - Install and activate

#### Recommended Plugins
- **Yoast SEO** (for SEO optimization)
- **WP Rocket** (for performance optimization)
- **Wordfence Security** (for security)

### Step 3: Configure Theme
1. Go to **Appearance → Customize**
2. Configure the following sections:
   - **Site Identity**: Upload logo and set site title
   - **Hero Section**: Customize hero content and statistics
   - **Contact Information**: Set contact details
   - **Social Media**: Add social media links

### Step 4: Create Content
1. **Committee Members**:
   - Go to **Committee Members → Add New**
   - Add member details, role, bio, and LinkedIn URL
   - Upload profile image

2. **Events**:
   - Go to **Events → Add New**
   - Set event date, location, type, and registration URL
   - Add event description and featured image

3. **News**:
   - Go to **News → Add New**
   - Write news articles with excerpts

### Step 5: Set Up Navigation
1. Go to **Appearance → Menus**
2. Create a new menu for "Primary Menu"
3. Add pages and custom post type archives
4. Assign to "Primary Menu" location

## Customization

### Theme Customizer Options
- **Hero Section**: Title lines, subtitle, statistics, hero image
- **Ecosystem**: Section title and subtitle
- **Committee**: Description text
- **Contact Information**: Email addresses, phone, address
- **CTA Section**: Call-to-action text and buttons

### Custom CSS
Add custom CSS in **Appearance → Customize → Additional CSS**

### Child Theme
For custom modifications, create a child theme:
1. Create a new folder: `mpa-wordpress-theme-child`
2. Add `style.css` with theme header
3. Add `functions.php` to enqueue parent styles

## File Structure

```
mpa-wordpress-theme/
├── style.css                 # Main stylesheet with theme header
├── functions.php             # Theme functions and setup
├── index.php                 # Main template file
├── header.php                # Header template
├── footer.php                # Footer template
├── page-home.php             # Home page template
├── assets/                   # Theme assets
│   ├── script.js             # JavaScript functionality
│   ├── mpa-logo.png          # Default logo
│   └── [other images]        # Theme images
├── inc/                      # Include files
│   └── class-mpa-nav-walker.php  # Custom navigation walker
├── template-parts/           # Template parts (future use)
└── page-templates/           # Page templates (future use)
```

## Custom Post Types

### Committee Members
- **Fields**: Role, Bio, LinkedIn URL
- **Features**: Profile images, ordering
- **Display**: Home page committee section

### Events
- **Fields**: Date, Time, Location, Type, Registration URL
- **Features**: Date-based filtering, event types
- **Display**: Home page events section, events archive

### News
- **Fields**: Standard WordPress fields
- **Features**: Excerpts, featured images
- **Display**: Home page timeline, news archive

## Browser Support
- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+

## Performance
- Optimized CSS and JavaScript
- Lazy loading for images
- Minified assets
- Efficient database queries

## Security
- Sanitized outputs
- Prepared statements
- Security headers
- WordPress best practices

## Support

### Common Issues
1. **Custom fields not showing**: Ensure Advanced Custom Fields is installed and activated
2. **Images not displaying**: Check file permissions and upload directory
3. **Menu not working**: Verify menu is assigned to correct location

### Getting Help
- Check the WordPress Codex for general WordPress issues
- Review theme documentation
- Contact theme developer for specific issues

## Changelog

### Version 1.0
- Initial release
- Neumorphic design system
- Custom post types
- Responsive layout
- Interactive elements

## License
This theme is developed for the Malaysia PropTech Association. All rights reserved.

## Credits
- Design: MPA Development Team
- Icons: Font Awesome
- Fonts: Google Fonts
- Framework: WordPress

=== MPA Mobile Events Styling ===
Contributors: mpa-proptech
Tags: mobile, events, responsive, styling
Requires at least: 5.0
Tested up to: 6.3
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Mobile-optimized styling for the MPA Events page with clean, responsive design.

== Description ==

The MPA Mobile Events Styling plugin provides mobile-specific styling for the Events page, ensuring a clean and responsive design on mobile devices while leaving the desktop experience unchanged.

**Key Features:**

* **Mobile-Only Application**: Styles are applied only when `wp_is_mobile()` returns true
* **Events Page Specific**: Only affects the Events page (ID: 30841)
* **Clean Event Cards**: Transforms event cards into mobile-friendly layout with thin header bars
* **Responsive Design**: Optimized for various mobile screen sizes
* **Theme Independent**: Works with any WordPress theme
* **Safe & Reversible**: Can be easily activated/deactivated without affecting other pages

**How It Works:**

1. Detects if user is on a mobile device using WordPress's `wp_is_mobile()` function
2. Checks if the current page is the Events page
3. If both conditions are met, loads mobile-specific CSS
4. Desktop users continue to see the normal theme styling
5. Mobile users get optimized event card layout with improved readability

**Mobile Optimizations:**

* Event cards display as single-column layout
* Event icons become thin header bars (60px height)
* Sidebar moves to top of page
* Improved typography and spacing for mobile
* Responsive calendar integration
* Touch-friendly buttons and links

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/mpa-mobile-events` directory
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Go to Settings > MPA Mobile Events to configure options
4. View the Events page on a mobile device to see the optimized layout

== Frequently Asked Questions ==

= Does this affect desktop users? =

No, the plugin only applies styling to mobile devices. Desktop users will see the normal theme styling.

= Which page does this affect? =

The plugin specifically targets the Events page (page ID: 30841). Other pages remain unchanged.

= Can I disable the mobile styling temporarily? =

Yes, you can disable the mobile styling from Settings > MPA Mobile Events without deactivating the plugin.

= Will this conflict with my theme? =

The plugin is designed to be theme-independent and uses specific CSS selectors to avoid conflicts.

== Screenshots ==

1. Mobile Events page with optimized layout
2. Plugin settings page
3. Comparison between desktop and mobile layouts

== Changelog ==

= 1.0.0 =
* Initial release
* Mobile-specific event card styling
* Responsive layout for Events page
* Admin settings panel
* Mobile device detection

== Upgrade Notice ==

= 1.0.0 =
Initial release of the MPA Mobile Events Styling plugin.

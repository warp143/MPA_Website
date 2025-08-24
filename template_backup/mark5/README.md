# MPA Website - Brutalist Design Version (Mark5)

## Overview

This is a **brutalist web design** version of the Malaysia PropTech Association website. Brutalist design emphasizes raw, bold, and intentionally "unfinished" aesthetics that challenge conventional web design norms.

## Design Philosophy

### Brutalist Principles Applied:
- **Sharp, high-contrast colors** (Black, White, Red)
- **Oversized text** with bold typography
- **Raw HTML feel** with minimal decoration
- **Functional simplicity** over polish
- **Intentional imperfection** and bold statements

### Key Features:
- Monospace fonts (Space Mono, VT323) for that raw, technical feel
- High contrast color scheme (#000000, #FFFFFF, #FF0000)
- Oversized headings with dramatic text shadows
- Thick borders and bold geometric shapes
- Minimal animations with maximum impact
- Raw, unfiltered user interactions

## File Structure

```
mark5/
├── index.html          # Main HTML structure
├── styles.css          # Brutalist CSS styles
├── script.js           # Interactive functionality
└── README.md           # This documentation
```

## Design Elements

### Typography
- **Primary Font**: Space Mono (monospace)
- **Display Font**: VT323 (monospace)
- **All text**: UPPERCASE for maximum impact
- **Letter spacing**: Increased for dramatic effect

### Color Scheme
- **Primary Black**: #000000
- **Primary White**: #FFFFFF  
- **Accent Red**: #FF0000
- **Success Green**: #00FF00
- **Info Blue**: #0000FF

### Layout Features
- **Fixed header** with bold red background
- **Full-height hero section** with oversized text
- **Grid-based layouts** with thick borders
- **Card-based content** with high contrast
- **Responsive design** that maintains brutality on all devices

## Interactive Features

### Navigation
- Smooth scrolling between sections
- Header color changes on scroll
- Bold hover effects with color inversions

### Event Filtering
- Filter buttons for different event types
- Dynamic content showing/hiding
- Brutalist animations on filter changes

### Form Interactions
- Newsletter subscription with brutalist messaging
- Contact form with validation
- Event registration buttons
- Success/error messages with bold styling

### Special Effects
- **Typing effect** on hero title
- **Parallax scrolling** for statistics
- **Random color flashes** every 5 seconds
- **Glitch effects** on title hover
- **Scroll progress indicator** at top of page

## Technical Implementation

### CSS Features
- CSS Grid and Flexbox for layouts
- Custom animations and transitions
- Responsive breakpoints
- High contrast color variables
- Brutalist-specific styling patterns

### JavaScript Features
- Event filtering system
- Form handling and validation
- Smooth scrolling implementation
- Brutalist message system
- Performance monitoring
- Error handling with brutalist feedback

### Performance Optimizations
- Minimal external dependencies
- Efficient DOM manipulation
- Optimized animations
- Mobile-responsive interactions

## Browser Compatibility

- **Chrome**: Full support
- **Firefox**: Full support
- **Safari**: Full support
- **Edge**: Full support
- **Mobile browsers**: Responsive design

## Usage

1. Open `index.html` in a web browser
2. Navigate through sections using the header menu
3. Interact with event filters and forms
4. Experience the brutalist design philosophy

## Customization

### Colors
Modify the color scheme in `styles.css`:
```css
/* Primary colors */
--brutalist-black: #000000;
--brutalist-white: #FFFFFF;
--brutalist-red: #FF0000;
```

### Typography
Change fonts in the HTML head:
```html
<link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=VT323&display=swap" rel="stylesheet">
```

### Animations
Adjust animation timing in `script.js`:
```javascript
// Random color flash interval (milliseconds)
setInterval(() => {
    // Color flash effect
}, 5000);
```

## Brutalist Design Philosophy

This design intentionally breaks conventional web design rules:

1. **Oversized Elements**: Everything is bigger, bolder, more in-your-face
2. **High Contrast**: Black, white, and red create maximum visual impact
3. **Raw Typography**: Monospace fonts and uppercase text feel technical and unrefined
4. **Bold Borders**: Thick, geometric borders create strong visual separation
5. **Minimal Decoration**: No subtle gradients or shadows - just pure, raw design
6. **Intentional Imperfection**: The design feels "unfinished" but purposeful

## Accessibility

Despite the bold design, accessibility is maintained:
- High contrast ratios meet WCAG guidelines
- Keyboard navigation support
- Screen reader compatibility
- Responsive design for all devices

## Future Enhancements

Potential additions while maintaining brutalist principles:
- Audio feedback on interactions
- More aggressive animations
- Additional glitch effects
- Experimental typography
- Interactive data visualizations

## Credits

- **Design Philosophy**: Brutalist Web Design movement
- **Fonts**: Google Fonts (Space Mono, VT323)
- **Icons**: Unicode emoji for maximum compatibility
- **Inspiration**: Early web design, terminal interfaces, punk aesthetics

---

*This is not your typical corporate website. It's bold, it's raw, it's brutalist.*

# MPA Website - Dark Mode Color Template

## Primary Theme Colors
```css
/* Main Theme Colors - Blue/Purple Gradient */
--accent-blue: #007AFF;      /* Apple System Blue */
--accent-purple: #5856D6;    /* Medium Purple with Blue Undertones */
```

## Dark Mode Color Palette
```css
/* Dark Mode Background Colors */
--bg-primary-dark: #000000;           /* Pure Black Background */
--bg-secondary-dark: #1a1a1a;         /* Dark Gray Secondary Background */

/* Dark Mode Text Colors */
--text-primary-dark: #ffffff;         /* White Primary Text */
--text-secondary-dark: rgba(255, 255, 255, 0.8);    /* 80% White Secondary Text */
--text-muted-dark: rgba(255, 255, 255, 0.6);        /* 60% White Muted Text */

/* Dark Mode Glass Effects */
--glass-bg-dark: rgba(255, 255, 255, 0.1);          /* 10% White Glass Background */
--glass-border-dark: rgba(255, 255, 255, 0.2);      /* 20% White Glass Border */
```

## Gradient Combinations
```css
/* Primary Gradient - Blue to Purple */
background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));

/* Text Gradient - White to Blue */
background: linear-gradient(135deg, var(--text-primary) 0%, var(--accent-blue) 100%);

/* Hero Title Gradient */
background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
```

## Component-Specific Colors

### Navigation
```css
/* Navbar Background */
background: var(--bg-primary-dark);

/* Nav Links */
color: var(--text-primary-dark);

/* Active/Hover States */
color: var(--accent-blue);
border-color: var(--accent-blue);
```

### Buttons
```css
/* Primary Button */
background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
color: var(--text-primary-dark);

/* Secondary Button */
background: transparent;
color: var(--text-primary-dark);
border: 1px solid var(--accent-blue);
```

### Cards & Containers
```css
/* Card Background */
background: var(--bg-secondary-dark);

/* Card Border */
border: 1px solid var(--glass-border-dark);

/* Glass Effect */
background: var(--glass-bg-dark);
backdrop-filter: blur(10px);
```

### Interactive Elements
```css
/* Links */
color: var(--accent-blue);

/* Hover States */
color: var(--accent-purple);

/* Focus States */
border-color: var(--accent-blue);
box-shadow: 0 0 0 2px rgba(0, 122, 255, 0.2);
```

## Color Usage Guidelines

### Text Hierarchy
1. **Primary Text**: `#ffffff` - Main headings, important content
2. **Secondary Text**: `rgba(255, 255, 255, 0.8)` - Subheadings, descriptions
3. **Muted Text**: `rgba(255, 255, 255, 0.6)` - Captions, metadata

### Interactive Elements
- **Primary Actions**: Blue/Purple gradient
- **Secondary Actions**: Transparent with blue border
- **Links**: Blue (`#007AFF`)
- **Hover States**: Purple (`#5856D6`)

### Background Layers
1. **Primary Background**: Pure black (`#000000`)
2. **Secondary Background**: Dark gray (`#1a1a1a`)
3. **Glass Effects**: Semi-transparent white overlays

## Accessibility Considerations
- **Contrast Ratio**: All text meets WCAG AA standards
- **Focus Indicators**: Blue outline for keyboard navigation
- **Color Independence**: Information not conveyed by color alone

## Implementation Notes
- Use CSS custom properties for consistent theming
- Apply gradients for visual hierarchy
- Maintain high contrast for readability
- Use glass effects sparingly for depth

---
*Last Updated: August 30, 2024*
*Theme: Malaysia Proptech Association Dark Mode*

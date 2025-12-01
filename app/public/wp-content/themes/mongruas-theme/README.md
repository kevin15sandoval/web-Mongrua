# Formación y Enseñanza Mogruas - WordPress Theme

Custom WordPress theme for the Mogruas landing page.

## Features

- Custom landing page template
- Advanced Custom Fields (ACF) integration
- Responsive design (mobile-first)
- Performance optimized
- Analytics integration (Google Analytics, Facebook Pixel)
- Form validation and submission
- Custom post types (Courses, Testimonials)
- SEO optimized

## Requirements

- WordPress 6.0 or higher
- PHP 8.0 or higher
- Advanced Custom Fields (ACF) Pro plugin

## Installation

1. Upload the theme folder to `/wp-content/themes/`
2. Activate the theme in WordPress admin
3. Install and activate ACF Pro plugin
4. Configure theme settings in "Theme Settings" menu

## Theme Structure

```
mongruas-theme/
├── assets/
│   ├── css/
│   │   ├── main.css
│   │   └── responsive.css
│   ├── js/
│   │   ├── main.js
│   │   └── form-validation.js
│   └── images/
├── inc/
│   ├── custom-post-types.php
│   ├── acf-fields.php
│   └── analytics.php
├── page-templates/
│   └── landing-page.php
├── template-parts/
│   ├── hero-section.php
│   ├── courses-section.php
│   ├── testimonials-section.php
│   ├── cta-section.php
│   └── faq-section.php
├── acf-json/
├── functions.php
├── header.php
├── footer.php
├── index.php
└── style.css
```

## Configuration

### Theme Settings (ACF Options Page)

- Contact Information (phone, email, address)
- Analytics Codes (Google Analytics, Facebook Pixel)
- Custom Tracking Scripts
- Certifications and Logos

### Custom Post Types

1. **Courses** (`course`)
   - Title, Description, Featured Image
   - Duration, Price, Benefits
   - Featured flag

2. **Testimonials** (`testimonial`)
   - Author Name, Role/Company
   - Author Photo
   - Rating (1-5)
   - Testimonial Text

## Development

### CSS Variables

The theme uses CSS custom properties for easy customization. Main variables are defined in `assets/css/main.css`:

- Colors (primary, secondary, neutral)
- Typography (fonts, sizes)
- Spacing
- Border radius
- Shadows
- Transitions

### JavaScript

- Mobile menu toggle
- Smooth scrolling
- CTA tracking
- Lazy loading images
- Counter animations
- FAQ accordion
- Form validation

## Support

For support, contact: [email]

## License

GNU General Public License v2 or later

## Credits

Developed for Formación y Enseñanza Mogruas

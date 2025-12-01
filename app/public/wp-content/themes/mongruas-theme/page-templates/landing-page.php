<?php
/**
 * Template Name: Mogruas Landing Page
 * Template Post Type: page
 *
 * @package Mongruas
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main landing-page">
    
    <?php
    // Hero Section
    get_template_part('template-parts/hero', 'section');
    
    // About Mogruas Section
    get_template_part('template-parts/about', 'section');
    
    // Services Section
    get_template_part('template-parts/services', 'section');
    
    // Course Catalog Section
    get_template_part('template-parts/course-catalog', 'section');
    
    // Social Proof Section (Testimonials + Stats)
    get_template_part('template-parts/social-proof', 'section');
    
    // Values Section
    get_template_part('template-parts/values', 'section');
    
    // Process/How It Works Section
    get_template_part('template-parts/process', 'section');
    
    // CTA Section (Contact Form)
    get_template_part('template-parts/cta', 'section');
    
    // FAQ Section
    get_template_part('template-parts/faq', 'section');
    ?>

</main>

<?php
get_footer();

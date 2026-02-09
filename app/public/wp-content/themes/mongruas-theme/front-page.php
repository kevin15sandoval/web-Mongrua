<?php
/**
 * The front page template file
 * 
 * Página de inicio principal con todas las secciones
 *
 * @package Mongruas
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main front-page">
    
    <?php
    // Hero Section
    get_template_part('template-parts/hero-section');
    
    // Social Proof Section - Estadísticas justo después del hero
    get_template_part('template-parts/social-proof-section');
    
    // About Section (ahora incluye el carrusel de fotos al lado)
    get_template_part('template-parts/about-section');
    
    // Services Section
    get_template_part('template-parts/services-section');
    
    // Upcoming Courses Section - DESACTIVADA (solo en /anuncios/)
    // get_template_part('template-parts/upcoming-courses-section');
    
    // Course Catalog Section
    get_template_part('template-parts/course-catalog-section');
    
    // Global Preventium Section
    get_template_part('template-parts/global-preventium-section');
    
    // CTA/Contact Section
    get_template_part('template-parts/cta-section');
    ?>

</main>

<?php
get_footer();

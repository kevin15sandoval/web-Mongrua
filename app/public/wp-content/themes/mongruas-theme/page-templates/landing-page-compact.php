<?php
/**
 * Template Name: Mogruas Landing Page Compacta
 * Template Post Type: page
 *
 * Landing page optimizada con solo 5 secciones esenciales
 * 
 * @package Mongruas
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main landing-page-compact">
    
    <?php
    // 1. Hero Section - Impacto inicial
    get_template_part('template-parts/hero', 'section');
    
    // 2. Services Section - Grid compacto de servicios
    get_template_part('template-parts/services', 'compact');
    
    // 3. Social Proof - Testimonios + Estadísticas combinados
    get_template_part('template-parts/social-proof', 'section');
    
    // 4. CTA Section - Formulario de contacto
    get_template_part('template-parts/cta', 'section');
    ?>

</main>

<?php
get_footer();

<?php
/**
 * Template part for displaying the course catalog section
 *
 * @package Mongruas
 * @since 1.0.0
 */

$catalog_heading = get_field('catalog_heading') ?: 'Catálogo de Cursos';
$catalog_description = get_field('catalog_description') ?: 'Más de 2000 cursos online disponibles en nuestra plataforma de teleformación';
$total_courses_count = get_field('total_courses_count') ?: '2000+';
$campus_virtual_url = get_field('campus_virtual_url') ?: 'https://www.plataformateleformacion.com';
?>

<section id="course-catalog" class="course-catalog-section section">
    <div class="container">
        <div class="section-heading">
            <h2><?php echo esc_html($catalog_heading); ?></h2>
            <p><?php echo esc_html($catalog_description); ?></p>
        </div>

        <div class="catalog-highlight">
            <div class="catalog-count">
                <span class="count-number"><?php echo esc_html($total_courses_count); ?></span>
                <span class="count-label"><?php esc_html_e('Cursos Disponibles', 'mongruas'); ?></span>
            </div>

            <div class="catalog-categories">
                <div class="category-item">
                    <h4><?php esc_html_e('Construcción', 'mongruas'); ?></h4>
                    <p><?php esc_html_e('Fundación Laboral de la Construcción', 'mongruas'); ?></p>
                </div>
                <div class="category-item">
                    <h4><?php esc_html_e('Metal', 'mongruas'); ?></h4>
                    <p><?php esc_html_e('Fundación del Metal', 'mongruas'); ?></p>
                </div>
                <div class="category-item">
                    <h4><?php esc_html_e('Competencias Profesionales', 'mongruas'); ?></h4>
                    <p><?php esc_html_e('Certificados de Profesionalidad', 'mongruas'); ?></p>
                </div>
                <div class="category-item">
                    <h4><?php esc_html_e('E-learning', 'mongruas'); ?></h4>
                    <p><?php esc_html_e('Cursos generales online', 'mongruas'); ?></p>
                </div>
            </div>

            <div class="catalog-cta">
                <a href="<?php echo esc_url($campus_virtual_url); ?>" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="btn btn-primary btn-lg cta-button"
                   data-cta-location="catalog">
                    <?php esc_html_e('Acceder al Campus Virtual', 'mongruas'); ?>
                </a>
                <a href="#contact" 
                   class="btn btn-outline btn-lg cta-button"
                   data-cta-location="catalog">
                    <?php esc_html_e('Solicitar Información', 'mongruas'); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php
/**
 * Template part for displaying the about section
 *
 * @package Mongruas
 * @since 1.0.0
 */

$about_heading = get_field('about_heading');
$about_description = get_field('about_description');
$about_image = get_field('about_image');
$about_highlights = get_field('about_highlights');

// Default values
$about_heading = $about_heading ?: 'Formación y Enseñanza Mogruas';
$about_description = $about_description ?: 'Somos un Centro Profesional para el Empleo, una empresa joven orientada a conseguir éxitos profesionales de nuestros alumnos. Desde 2005 ponemos al alcance de desempleados y trabajadores los medios más avanzados y funcionales, así como un equipo cualificado de grandes profesionales.';
?>

<section id="about" class="about-section section">
    <div class="container">
        <div class="about-content">
            <div class="about-text">
                <h2 class="section-title"><?php echo esc_html($about_heading); ?></h2>
                <div class="about-description">
                    <?php echo wpautop(wp_kses_post($about_description)); ?>
                </div>

                <?php if ($about_highlights) : ?>
                    <div class="about-highlights">
                        <?php foreach ($about_highlights as $highlight) : ?>
                            <div class="highlight-item">
                                <?php if (!empty($highlight['icon'])) : ?>
                                    <img src="<?php echo esc_url($highlight['icon']['url']); ?>" 
                                         alt="<?php echo esc_attr($highlight['title']); ?>"
                                         class="highlight-icon">
                                <?php endif; ?>
                                <div class="highlight-content">
                                    <h3 class="highlight-title"><?php echo esc_html($highlight['title']); ?></h3>
                                    <p class="highlight-text"><?php echo esc_html($highlight['text']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <!-- Default highlights -->
                    <div class="about-highlights">
                        <div class="highlight-item">
                            <div class="highlight-content">
                                <h3 class="highlight-title">20 Años de Experiencia</h3>
                                <p class="highlight-text">Desde 2005 formando profesionales</p>
                            </div>
                        </div>
                        <div class="highlight-item">
                            <div class="highlight-content">
                                <h3 class="highlight-title">Innovación</h3>
                                <p class="highlight-text">Contamos con 3 impresoras 3D para fomentar la creatividad</p>
                            </div>
                        </div>
                        <div class="highlight-item">
                            <div class="highlight-content">
                                <h3 class="highlight-title">Delegación Global Preventium</h3>
                                <p class="highlight-text">Desde 2018 gestionando PRL en más de 200 empresas</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($about_image) : ?>
                <div class="about-image">
                    <img src="<?php echo esc_url($about_image['url']); ?>" 
                         alt="<?php echo esc_attr($about_image['alt']); ?>"
                         loading="lazy">
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

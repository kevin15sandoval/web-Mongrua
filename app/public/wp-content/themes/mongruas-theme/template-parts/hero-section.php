<?php
/**
 * Template part for displaying the hero section
 *
 * @package Mongruas
 * @since 1.0.0
 */

$hero_headline = get_field('hero_headline');
$hero_subheadline = get_field('hero_subheadline');
$hero_background_image = get_field('hero_background_image');
$hero_background_video = get_field('hero_background_video');
$hero_primary_cta_text = get_field('hero_primary_cta_text');
$hero_primary_cta_link = get_field('hero_primary_cta_link');
$hero_secondary_cta_text = get_field('hero_secondary_cta_text');
$hero_secondary_cta_link = get_field('hero_secondary_cta_link');
$hero_trust_badges = get_field('hero_trust_badges');

// Default values
$hero_headline = $hero_headline ?: 'LA FORMACIÓN AL ALCANCE DE TODOS';
$hero_subheadline = $hero_subheadline ?: 'Centro Profesional para el Empleo desde 2005 en Talavera de la Reina';
$hero_primary_cta_text = $hero_primary_cta_text ?: 'Solicita Información';
$hero_secondary_cta_text = $hero_secondary_cta_text ?: 'Acceder al Campus Virtual';
$hero_secondary_cta_link = $hero_secondary_cta_link ?: 'https://www.plataformateleformacion.com';
?>

<section id="hero" class="hero-section">
    <div class="hero-background">
        <?php if ($hero_background_video) : ?>
            <video class="hero-video" autoplay muted loop playsinline>
                <source src="<?php echo esc_url($hero_background_video); ?>" type="video/mp4">
            </video>
        <?php elseif ($hero_background_image) : ?>
            <img src="<?php echo esc_url($hero_background_image['url']); ?>" 
                 alt="<?php echo esc_attr($hero_background_image['alt']); ?>"
                 class="hero-image">
        <?php endif; ?>
        <div class="hero-overlay"></div>
    </div>

    <div class="hero-content">
        <div class="container">
            <div class="hero-text">
                <h1 class="hero-headline"><?php echo esc_html($hero_headline); ?></h1>
                
                <?php if ($hero_subheadline) : ?>
                    <p class="hero-subheadline"><?php echo esc_html($hero_subheadline); ?></p>
                <?php endif; ?>

                <div class="hero-cta-buttons">
                    <?php if ($hero_primary_cta_text) : ?>
                        <a href="<?php echo esc_url($hero_primary_cta_link ?: '#contact'); ?>" 
                           class="btn btn-primary btn-lg cta-button"
                           data-cta-location="hero">
                            <?php echo esc_html($hero_primary_cta_text); ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($hero_secondary_cta_text) : ?>
                        <a href="<?php echo esc_url($hero_secondary_cta_link); ?>" 
                           class="btn btn-outline btn-lg cta-button"
                           target="_blank"
                           rel="noopener noreferrer"
                           data-cta-location="hero">
                            <?php echo esc_html($hero_secondary_cta_text); ?>
                        </a>
                    <?php endif; ?>
                </div>

                <?php if ($hero_trust_badges) : ?>
                    <div class="hero-trust-badges">
                        <?php foreach ($hero_trust_badges as $badge) : ?>
                            <div class="trust-badge">
                                <?php if (!empty($badge['image'])) : ?>
                                    <img src="<?php echo esc_url($badge['image']['url']); ?>" 
                                         alt="<?php echo esc_attr($badge['text']); ?>"
                                         class="trust-badge-icon">
                                <?php endif; ?>
                                <span class="trust-badge-text"><?php echo esc_html($badge['text']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="hero-scroll-indicator">
        <a href="#about" class="scroll-down" aria-label="<?php esc_attr_e('Scroll down', 'mongruas'); ?>">
            <span class="scroll-arrow"></span>
        </a>
    </div>
</section>

<?php
/**
 * Template Name: Página de Servicios
 * Template Post Type: page
 *
 * Página dedicada con información detallada de todos los servicios
 * 
 * @package Mongruas
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main page-servicios">
    
    <!-- Hero interno mejorado -->
    <section class="page-hero services-hero">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <span class="hero-badge">4 Servicios Principales</span>
                <h1 class="page-title">Nuestros Servicios</h1>
                <p class="page-subtitle">Soluciones integrales de formación y prevención para empresas y profesionales</p>
                <div class="hero-features">
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span>Acreditados por SEPE</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span>Formación Bonificada</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span>Delegación Global Preventium</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Servicios detallados -->
    <section class="services-detailed">
        <div class="container">
            <?php
            $services = get_field('services');
            
            if ($services):
                foreach ($services as $index => $service):
                    $title = $service['service_title'];
                    $description = $service['service_description'];
                    $icon = $service['service_icon'];
                    $badge = $service['service_badge_text'];
                    $features = $service['service_features'];
                    $cta_link = $service['service_cta_link'];
                    
                    // Alternar diseño izquierda/derecha
                    $layout_class = ($index % 2 == 0) ? 'layout-left' : 'layout-right';
            ?>
                    <div id="<?php echo sanitize_title($title); ?>" class="service-detail <?php echo $layout_class; ?>">
                        <div class="service-detail-content">
                            <?php if ($badge): ?>
                                <span class="service-badge-large"><?php echo esc_html($badge); ?></span>
                            <?php endif; ?>
                            
                            <h2 class="service-detail-title"><?php echo esc_html($title); ?></h2>
                            <p class="service-detail-description"><?php echo esc_html($description); ?></p>
                            
                            <?php if ($features): ?>
                                <div class="service-features-detailed">
                                    <h3>¿Qué incluye?</h3>
                                    <ul>
                                        <?php foreach ($features as $feature): ?>
                                            <li><?php echo esc_html($feature['feature_text']); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($cta_link): ?>
                                <a href="<?php echo esc_url($cta_link); ?>" class="btn btn-primary">Más Información</a>
                            <?php else: ?>
                                <a href="#contact" class="btn btn-primary">Solicitar Información</a>
                            <?php endif; ?>
                        </div>
                        
                        <div class="service-detail-image">
                            <?php if ($icon): ?>
                                <img src="<?php echo esc_url($icon); ?>" alt="<?php echo esc_attr($title); ?>">
                            <?php else: ?>
                                <div class="service-placeholder-icon">
                                    <svg width="200" height="200" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <circle cx="12" cy="12" r="10"/>
                                        <path d="M12 6v6l4 2"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
            <?php
                endforeach;
            else:
                // Servicios por defecto
                include(locate_template('template-parts/services-default-detailed.php'));
            endif;
            ?>
        </div>
    </section>

    <!-- CTA final -->
    <section class="services-final-cta">
        <div class="container text-center">
            <h2>¿Necesitas más información?</h2>
            <p>Contacta con nosotros y te asesoraremos sin compromiso</p>
            <a href="/contacto" class="btn btn-primary btn-lg">Contactar Ahora</a>
        </div>
    </section>

</main>

<?php
get_footer();
?>

<style>
/* Estilos mejorados para página de servicios */
.services-hero {
    position: relative;
    background: linear-gradient(135deg, #0066cc 0%, #0052a3 50%, #003d7a 100%);
    color: white;
    padding: 100px 0 80px;
    text-align: center;
    overflow: hidden;
}

.services-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
    opacity: 0.3;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%);
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-badge {
    display: inline-block;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    color: white;
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 20px;
    border: 1px solid rgba(255,255,255,0.3);
}

.services-hero .page-title,
.about-hero .page-title {
    font-size: 56px;
    font-weight: 800;
    margin-bottom: 20px;
    text-shadow: 0 2px 10px rgba(0,0,0,0.2);
}

.services-hero .page-subtitle,
.about-hero .page-subtitle {
    font-size: 22px;
    opacity: 0.95;
    margin-bottom: 40px;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
}

.hero-features {
    display: flex;
    justify-content: center;
    gap: 40px;
    flex-wrap: wrap;
}

.hero-features .feature-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 16px;
    font-weight: 600;
}

.hero-features .feature-icon {
    width: 24px;
    height: 24px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
}

.page-hero {
    background: linear-gradient(135deg, var(--color-primary) 0%, #0052a3 100%);
    color: white;
    padding: 80px 0 60px;
    text-align: center;
}

.page-hero .page-title {
    font-size: 48px;
    font-weight: 700;
    margin-bottom: 15px;
}

.page-hero .page-subtitle {
    font-size: 20px;
    opacity: 0.9;
    max-width: 700px;
    margin: 0 auto;
}

.services-detailed {
    padding: 80px 0;
}

.service-detail {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
    margin-bottom: 80px;
    padding-bottom: 80px;
    border-bottom: 1px solid #e0e0e0;
}

.service-detail:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.service-detail.layout-right {
    direction: rtl;
}

.service-detail.layout-right > * {
    direction: ltr;
}

.service-detail-content {
    padding: 20px 0;
}

.service-badge-large {
    display: inline-block;
    background: var(--color-secondary);
    color: white;
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    margin-bottom: 20px;
}

.service-detail-title {
    font-size: 36px;
    font-weight: 700;
    color: var(--color-text-dark);
    margin-bottom: 20px;
    line-height: 1.2;
}

.service-detail-description {
    font-size: 18px;
    color: var(--color-text);
    line-height: 1.6;
    margin-bottom: 30px;
}

.service-features-detailed h3 {
    font-size: 20px;
    font-weight: 600;
    color: var(--color-text-dark);
    margin-bottom: 15px;
}

.service-features-detailed ul {
    list-style: none;
    padding: 0;
    margin-bottom: 30px;
}

.service-features-detailed li {
    font-size: 16px;
    color: var(--color-text);
    padding: 10px 0;
    padding-left: 30px;
    position: relative;
}

.service-features-detailed li:before {
    content: "✓";
    position: absolute;
    left: 0;
    color: var(--color-primary);
    font-weight: bold;
    font-size: 20px;
}

.service-detail-image {
    display: flex;
    align-items: center;
    justify-content: center;
}

.service-detail-image img {
    max-width: 100%;
    height: auto;
    border-radius: 12px;
}

.service-placeholder-icon {
    width: 200px;
    height: 200px;
    color: var(--color-primary);
    opacity: 0.3;
}

.services-final-cta {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 80px 0;
}

.services-final-cta h2 {
    font-size: 36px;
    font-weight: 700;
    margin-bottom: 15px;
}

.services-final-cta p {
    font-size: 18px;
    color: var(--color-text);
    margin-bottom: 30px;
}

/* Responsive */
@media (max-width: 968px) {
    .page-hero {
        padding: 60px 0 40px;
    }
    
    .page-hero .page-title {
        font-size: 36px;
    }
    
    .page-hero .page-subtitle {
        font-size: 16px;
    }
    
    .services-detailed {
        padding: 60px 0;
    }
    
    .service-detail {
        grid-template-columns: 1fr;
        gap: 30px;
        margin-bottom: 60px;
        padding-bottom: 60px;
    }
    
    .service-detail.layout-right {
        direction: ltr;
    }
    
    .service-detail-title {
        font-size: 28px;
    }
    
    .service-detail-description {
        font-size: 16px;
    }
    
    .services-final-cta {
        padding: 60px 0;
    }
    
    .services-final-cta h2 {
        font-size: 28px;
    }
}
</style>

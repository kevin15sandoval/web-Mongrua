<?php
/**
 * Template part for displaying the services section
 *
 * @package Mongruas
 * @since 1.0.0
 */

$services_heading = get_field('services_section_heading');
$services_description = get_field('services_section_description');
$services = get_field('services');

// Default values
$services_heading = $services_heading ?: 'Nuestros Servicios';
$services_description = $services_description ?: 'Ofrecemos una amplia gama de servicios de formación y consultoría para particulares y empresas';
?>

<section id="services" class="services-section section">
    <div class="container">
        <div class="section-heading">
            <h2><?php echo esc_html($services_heading); ?></h2>
            <?php if ($services_description) : ?>
                <p><?php echo esc_html($services_description); ?></p>
            <?php endif; ?>
        </div>

        <div class="services-grid">
            <?php if ($services) : ?>
                <?php foreach ($services as $service) : ?>
                    <div class="service-card">
                        <?php if (!empty($service['service_icon'])) : ?>
                            <div class="service-icon">
                                <img src="<?php echo esc_url($service['service_icon']['url']); ?>" 
                                     alt="<?php echo esc_attr($service['service_title']); ?>">
                            </div>
                        <?php endif; ?>

                        <h3 class="service-title"><?php echo esc_html($service['service_title']); ?></h3>
                        
                        <p class="service-description"><?php echo esc_html($service['service_description']); ?></p>

                        <?php if (!empty($service['service_features'])) : ?>
                            <ul class="service-features">
                                <?php foreach ($service['service_features'] as $feature) : ?>
                                    <li><?php echo esc_html($feature['feature_text']); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <?php if (!empty($service['service_badge_text'])) : ?>
                            <span class="service-badge"><?php echo esc_html($service['service_badge_text']); ?></span>
                        <?php endif; ?>

                        <?php if (!empty($service['service_cta_link'])) : ?>
                            <a href="<?php echo esc_url($service['service_cta_link']); ?>" 
                               class="btn btn-outline cta-button"
                               data-cta-location="services">
                                <?php esc_html_e('Más Información', 'mongruas'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <!-- Default services -->
                <div class="service-card">
                    <h3 class="service-title">Certificados de Profesionalidad</h3>
                    <p class="service-description">Formación oficial acreditada por SEPE en electricidad, domótica y control de plagas</p>
                    <ul class="service-features">
                        <li>ELEE0109: Instalaciones Eléctricas de Baja Tensión</li>
                        <li>ELEM0111: Sistemas Domóticos e Inmóticos</li>
                        <li>SEAG0110: Control de Plagas</li>
                    </ul>
                    <span class="service-badge">Acreditados por SEPE</span>
                    <a href="#contact" class="btn btn-outline cta-button" data-cta-location="services">Más Información</a>
                </div>

                <div class="service-card">
                    <h3 class="service-title">Formación Bonificada</h3>
                    <p class="service-description">Programas de formación para empresas utilizando créditos de la Seguridad Social</p>
                    <ul class="service-features">
                        <li>Formación 100% bonificable</li>
                        <li>Planes personalizados</li>
                        <li>Gestión completa de bonificaciones</li>
                    </ul>
                    <span class="service-badge">Formación 100% Bonificable</span>
                    <a href="#contact" class="btn btn-outline cta-button" data-cta-location="services">Más Información</a>
                </div>

                <div class="service-card">
                    <h3 class="service-title">Prevención de Riesgos Laborales</h3>
                    <p class="service-description">Delegación Global Preventium - Gestión integral de PRL para empresas</p>
                    <ul class="service-features">
                        <li>Más de 200 empresas gestionadas</li>
                        <li>Actividades técnicas</li>
                        <li>Vigilancia de la salud</li>
                        <li>Formación en PRL</li>
                    </ul>
                    <span class="service-badge">Delegación Global Preventium</span>
                    <a href="#contact" class="btn btn-outline cta-button" data-cta-location="services">Más Información</a>
                </div>

                <div class="service-card">
                    <h3 class="service-title">Protección de Datos (LOPD/RGPD)</h3>
                    <p class="service-description">Adaptación de empresas al Reglamento General de Protección de Datos</p>
                    <ul class="service-features">
                        <li>Plataforma virtual de gestión</li>
                        <li>Departamento especializado</li>
                        <li>Cumplimiento normativo</li>
                    </ul>
                    <span class="service-badge">Cumplimiento RGPD</span>
                    <a href="#contact" class="btn btn-outline cta-button" data-cta-location="services">Más Información</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
/**
 * Services Section - Compact Version
 * Versión compacta con grid de 2x2 y menos contenido
 * 
 * @package Mongruas
 * @since 1.0.0
 */

$services_heading = get_field('services_section_heading') ?: 'Nuestros Servicios';
$services_description = get_field('services_section_description');
$services = get_field('services');
?>

<section id="services" class="services-section services-compact">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title"><?php echo esc_html($services_heading); ?></h2>
            <?php if ($services_description): ?>
                <p class="section-description"><?php echo esc_html($services_description); ?></p>
            <?php endif; ?>
        </div>

        <?php if ($services): ?>
            <div class="services-grid-compact">
                <?php 
                // Limitar a 4 servicios principales
                $services_limited = array_slice($services, 0, 4);
                foreach ($services_limited as $service): 
                    $title = $service['service_title'];
                    $description = $service['service_description'];
                    $icon = $service['service_icon'];
                    $badge = $service['service_badge_text'];
                    $features = $service['service_features'];
                ?>
                    <div class="service-card-compact">
                        <?php if ($badge): ?>
                            <span class="service-badge"><?php echo esc_html($badge); ?></span>
                        <?php endif; ?>
                        
                        <?php if ($icon): ?>
                            <div class="service-icon">
                                <img src="<?php echo esc_url($icon); ?>" alt="<?php echo esc_attr($title); ?>">
                            </div>
                        <?php endif; ?>
                        
                        <h3 class="service-title"><?php echo esc_html($title); ?></h3>
                        
                        <p class="service-description"><?php echo esc_html($description); ?></p>
                        
                        <?php if ($features && count($features) > 0): ?>
                            <ul class="service-features-compact">
                                <?php 
                                // Mostrar solo las primeras 3 características
                                $features_limited = array_slice($features, 0, 3);
                                foreach ($features_limited as $feature): 
                                ?>
                                    <li><?php echo esc_html($feature['feature_text']); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        
                        <a href="/servicios#<?php echo sanitize_title($title); ?>" class="service-link">
                            Ver más <span class="arrow">→</span>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="services-cta text-center">
                <a href="/servicios" class="btn btn-primary">Ver Todos los Servicios</a>
            </div>
        <?php else: ?>
            <!-- Servicios por defecto si no hay contenido ACF -->
            <div class="services-grid-compact">
                <div class="service-card-compact">
                    <span class="service-badge">Acreditados por SEPE</span>
                    <div class="service-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                            <path d="M2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <h3 class="service-title">Certificados de Profesionalidad</h3>
                    <p class="service-description">Formación oficial acreditada por SEPE</p>
                    <ul class="service-features-compact">
                        <li>Instalaciones Eléctricas</li>
                        <li>Sistemas Domóticos</li>
                        <li>Control de Plagas</li>
                    </ul>
                    <a href="/servicios#certificados" class="service-link">Ver más <span class="arrow">→</span></a>
                </div>
                
                <div class="service-card-compact">
                    <span class="service-badge">100% Bonificable</span>
                    <div class="service-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                        </svg>
                    </div>
                    <h3 class="service-title">Formación Bonificada</h3>
                    <p class="service-description">Programas para empresas con créditos de la Seguridad Social</p>
                    <ul class="service-features-compact">
                        <li>Formación 100% bonificable</li>
                        <li>Planes personalizados</li>
                        <li>Gestión completa</li>
                    </ul>
                    <a href="/servicios#bonificada" class="service-link">Ver más <span class="arrow">→</span></a>
                </div>
                
                <div class="service-card-compact">
                    <span class="service-badge">Global Preventium</span>
                    <div class="service-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <h3 class="service-title">Prevención de Riesgos</h3>
                    <p class="service-description">Gestión integral de PRL para empresas</p>
                    <ul class="service-features-compact">
                        <li>200+ empresas gestionadas</li>
                        <li>Vigilancia de la salud</li>
                        <li>Formación en PRL</li>
                    </ul>
                    <a href="/servicios#prl" class="service-link">Ver más <span class="arrow">→</span></a>
                </div>
                
                <div class="service-card-compact">
                    <span class="service-badge">Cumplimiento RGPD</span>
                    <div class="service-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </div>
                    <h3 class="service-title">Protección de Datos</h3>
                    <p class="service-description">Adaptación al RGPD para empresas</p>
                    <ul class="service-features-compact">
                        <li>Plataforma virtual</li>
                        <li>Departamento especializado</li>
                        <li>Cumplimiento normativo</li>
                    </ul>
                    <a href="/servicios#lopd" class="service-link">Ver más <span class="arrow">→</span></a>
                </div>
            </div>
            
            <div class="services-cta text-center">
                <a href="/servicios" class="btn btn-primary">Ver Todos los Servicios</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
/* Estilos mejorados para la versión compacta */
.services-compact {
    padding: 80px 0;
    background: #ffffff;
}

.services-compact .section-header {
    margin-bottom: 50px;
}

.services-compact .section-title {
    font-size: 42px;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 15px;
}

.services-compact .section-description {
    font-size: 18px;
    color: #495057;
    max-width: 700px;
    margin: 0 auto;
}

.services-grid-compact {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 35px;
    margin: 50px 0;
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
}

.service-card-compact {
    background: white;
    border-radius: 20px;
    padding: 40px 35px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    border: 2px solid transparent;
}

.service-card-compact::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #0066cc, #ff9900);
    transform: scaleX(0);
    transition: transform 0.4s ease;
}

.service-card-compact:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    border-color: #0066cc;
}

.service-card-compact:hover::before {
    transform: scaleX(1);
}

.service-card-compact .service-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    background: linear-gradient(135deg, #0066cc, #004d99);
    color: white;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3);
}

.service-card-compact .service-icon {
    width: 70px;
    height: 70px;
    margin-bottom: 25px;
    color: #0066cc;
    background: linear-gradient(135deg, rgba(0, 102, 204, 0.1), rgba(0, 102, 204, 0.05));
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.service-card-compact:hover .service-icon {
    background: linear-gradient(135deg, #0066cc, #004d99);
    color: white;
    transform: scale(1.1) rotate(5deg);
}

.service-card-compact .service-icon img {
    width: 45px;
    height: 45px;
    object-fit: contain;
}

.service-card-compact .service-icon svg {
    width: 45px;
    height: 45px;
    stroke-width: 2;
}

.service-card-compact .service-title {
    font-size: 24px;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 15px;
    line-height: 1.3;
}

.service-card-compact .service-description {
    font-size: 16px;
    color: #495057;
    margin-bottom: 20px;
    line-height: 1.6;
}

.service-features-compact {
    list-style: none;
    padding: 0;
    margin: 20px 0;
    border-top: 2px solid #f0f0f0;
    padding-top: 20px;
}

.service-features-compact li {
    font-size: 15px;
    color: #495057;
    padding: 10px 0;
    padding-left: 30px;
    position: relative;
    line-height: 1.5;
}

.service-features-compact li:before {
    content: "✓";
    position: absolute;
    left: 0;
    color: #28a745;
    font-weight: bold;
    font-size: 18px;
    width: 24px;
    height: 24px;
    background: rgba(40, 167, 69, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.service-card-compact .service-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #0066cc;
    font-weight: 700;
    font-size: 16px;
    text-decoration: none;
    margin-top: 20px;
    padding: 12px 24px;
    background: rgba(0, 102, 204, 0.05);
    border-radius: 30px;
    transition: all 0.3s ease;
}

.service-card-compact .service-link:hover {
    gap: 12px;
    background: #0066cc;
    color: white;
    box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3);
}

.service-card-compact .service-link .arrow {
    transition: transform 0.3s ease;
    font-size: 20px;
}

.service-card-compact:hover .service-link .arrow {
    transform: translateX(5px);
}

.services-cta {
    margin-top: 60px;
}

.services-cta .btn-primary {
    padding: 18px 45px;
    font-size: 18px;
    font-weight: 700;
    border-radius: 50px;
    background: linear-gradient(135deg, #ff9900, #cc7a00);
    border: none;
    box-shadow: 0 6px 20px rgba(255, 153, 0, 0.4);
    transition: all 0.3s ease;
}

.services-cta .btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(255, 153, 0, 0.5);
}

/* Responsive */
@media (max-width: 968px) {
    .services-compact {
        padding: 60px 0;
    }
    
    .services-compact .section-title {
        font-size: 32px;
    }
    
    .services-grid-compact {
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }
}

@media (max-width: 768px) {
    .services-compact {
        padding: 50px 0;
    }
    
    .services-compact .section-title {
        font-size: 28px;
    }
    
    .services-compact .section-description {
        font-size: 16px;
    }
    
    .services-grid-compact {
        grid-template-columns: 1fr;
        gap: 25px;
        margin: 40px 0;
    }
    
    .service-card-compact {
        padding: 30px 25px;
    }
    
    .service-card-compact .service-title {
        font-size: 20px;
    }
    
    .service-card-compact .service-description {
        font-size: 14px;
    }
    
    .service-features-compact li {
        font-size: 14px;
    }
}
</style>

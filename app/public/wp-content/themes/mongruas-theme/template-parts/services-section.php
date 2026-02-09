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

        <div class="services-carousel-container">
            <button class="services-carousel-control prev" id="servicesPrevBtn" aria-label="Anterior">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>

            <div class="services-carousel-wrapper">
                <div class="services-carousel-track" id="servicesCarouselTrack">
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
                            <div class="service-sepe-badge">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
                                    <path d="M9,22A1,1 0 0,1 8,21V18H4A2,2 0 0,1 2,16V4C2,2.89 2.9,2 4,2H20A2,2 0 0,1 22,4V16A2,2 0 0,1 20,18H13.9L10.2,21.71C10,21.9 9.75,22 9.5,22H9M10,16V19.08L13.08,16H20V4H4V16H10M16.5,6A1.5,1.5 0 0,1 18,7.5A1.5,1.5 0 0,1 16.5,9A1.5,1.5 0 0,1 15,7.5A1.5,1.5 0 0,1 16.5,6M7.5,6A1.5,1.5 0 0,1 9,7.5A1.5,1.5 0 0,1 7.5,9A1.5,1.5 0 0,1 6,7.5A1.5,1.5 0 0,1 7.5,6M12,6A1.5,1.5 0 0,1 13.5,7.5A1.5,1.5 0 0,1 12,9A1.5,1.5 0 0,1 10.5,7.5A1.5,1.5 0 0,1 12,6Z"/>
                                </svg>
                                <strong><?php echo esc_html($service['service_badge_text']); ?></strong>
                            </div>
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
                    <div class="service-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor" style="color: var(--color-primary);">
                            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                        </svg>
                    </div>
                    <h3 class="service-title">Certificados de Profesionalidad</h3>
                    <p class="service-description">Formación oficial acreditada por SEPE en electricidad, domótica y control de plagas</p>
                    
                    <!-- Certificados disponibles con el mismo estilo del footer -->
                    <div class="service-certificates">
                        <h4>Certificados Disponibles:</h4>
                        <ul class="service-cert-list">
                            <li><span class="service-cert-code">ELEE0109</span> Instalaciones Eléctricas de Baja Tensión</li>
                            <li><span class="service-cert-code">ELEM0111</span> Sistemas Domóticos e Inmóticos</li>
                            <li><span class="service-cert-code">SEAG0110</span> Control de Plagas</li>
                        </ul>
                    </div>
                    
                    <div class="service-sepe-badge">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
                            <path d="M9,22A1,1 0 0,1 8,21V18H4A2,2 0 0,1 2,16V4C2,2.89 2.9,2 4,2H20A2,2 0 0,1 22,4V16A2,2 0 0,1 20,18H13.9L10.2,21.71C10,21.9 9.75,22 9.5,22H9M10,16V19.08L13.08,16H20V4H4V16H10M16.5,6A1.5,1.5 0 0,1 18,7.5A1.5,1.5 0 0,1 16.5,9A1.5,1.5 0 0,1 15,7.5A1.5,1.5 0 0,1 16.5,6M7.5,6A1.5,1.5 0 0,1 9,7.5A1.5,1.5 0 0,1 7.5,9A1.5,1.5 0 0,1 6,7.5A1.5,1.5 0 0,1 7.5,6M12,6A1.5,1.5 0 0,1 13.5,7.5A1.5,1.5 0 0,1 12,9A1.5,1.5 0 0,1 10.5,7.5A1.5,1.5 0 0,1 12,6Z"/>
                        </svg>
                        <strong>Acreditados por SEPE</strong>
                    </div>
                    <a href="#contact" class="btn btn-outline cta-button" data-cta-location="services">Más Información</a>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor" style="color: var(--color-primary);">
                            <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4M12,6A6,6 0 0,0 6,12A6,6 0 0,0 12,18A6,6 0 0,0 18,12A6,6 0 0,0 12,6M12,8A4,4 0 0,1 16,12A4,4 0 0,1 12,16A4,4 0 0,1 8,12A4,4 0 0,1 12,8Z"/>
                        </svg>
                    </div>
                    <h3 class="service-title">Formación Bonificada</h3>
                    <p class="service-description">Programas de formación para empresas utilizando créditos de la Seguridad Social</p>
                    <ul class="service-features">
                        <li>Formación 100% bonificable</li>
                        <li>Planes personalizados</li>
                        <li>Gestión completa de bonificaciones</li>
                    </ul>
                    <div class="service-sepe-badge">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
                            <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M12,7C13.4,7 14.8,8.6 14.8,10V11.5C15.4,11.9 16,12.4 16,13V16C16,17.1 15.1,18 14,18H10C8.9,18 8,17.1 8,16V13C8,12.4 8.6,11.9 9.2,11.5V10C9.2,8.6 10.6,7 12,7M12,8.2C11.2,8.2 10.5,8.7 10.5,10V11.5H13.5V10C13.5,8.7 12.8,8.2 12,8.2Z"/>
                        </svg>
                        <strong>Formación 100% Bonificable</strong>
                    </div>
                    <a href="#contact" class="btn btn-outline cta-button" data-cta-location="services">Más Información</a>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor" style="color: var(--color-primary);">
                            <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M12,7C13.4,7 14.8,8.6 14.8,10V11.5C15.4,11.9 16,12.4 16,13V16C16,17.1 15.1,18 14,18H10C8.9,18 8,17.1 8,16V13C8,12.4 8.6,11.9 9.2,11.5V10C9.2,8.6 10.6,7 12,7M12,8.2C11.2,8.2 10.5,8.7 10.5,10V11.5H13.5V10C13.5,8.7 12.8,8.2 12,8.2Z"/>
                        </svg>
                    </div>
                    <h3 class="service-title">Prevención de Riesgos Laborales</h3>
                    <p class="service-description">Delegación Global Preventium - Gestión integral de PRL para empresas</p>
                    <ul class="service-features">
                        <li>Más de 200 empresas gestionadas</li>
                        <li>Actividades técnicas</li>
                        <li>Vigilancia de la salud</li>
                        <li>Formación en PRL</li>
                    </ul>
                    <div class="service-sepe-badge">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
                            <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M12,7C13.4,7 14.8,8.6 14.8,10V11.5C15.4,11.9 16,12.4 16,13V16C16,17.1 15.1,18 14,18H10C8.9,18 8,17.1 8,16V13C8,12.4 8.6,11.9 9.2,11.5V10C9.2,8.6 10.6,7 12,7M12,8.2C11.2,8.2 10.5,8.7 10.5,10V11.5H13.5V10C13.5,8.7 12.8,8.2 12,8.2Z"/>
                        </svg>
                        <strong>Delegación Global Preventium</strong>
                    </div>
                    <a href="#contact" class="btn btn-outline cta-button" data-cta-location="services">Más Información</a>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor" style="color: var(--color-primary);">
                            <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9L10,17Z"/>
                        </svg>
                    </div>
                    <h3 class="service-title">Protección de Datos (LOPD/RGPD)</h3>
                    <p class="service-description">Adaptación de empresas al Reglamento General de Protección de Datos</p>
                    <ul class="service-features">
                        <li>Plataforma virtual de gestión</li>
                        <li>Departamento especializado</li>
                        <li>Cumplimiento normativo</li>
                    </ul>
                    <div class="service-sepe-badge">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
                            <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9L10,17Z"/>
                        </svg>
                        <strong>Cumplimiento RGPD</strong>
                    </div>
                    <a href="#contact" class="btn btn-outline cta-button" data-cta-location="services">Más Información</a>
                </div>
            <?php endif; ?>
                </div>
            </div>

            <button class="services-carousel-control next" id="servicesNextBtn" aria-label="Siguiente">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>
        </div>

        <div class="services-carousel-dots" id="servicesCarouselDots"></div>
    </div>
</section>

<style>
/* Estilo especial para el badge de SEPE y otros badges - COMPACTO */
.service-sepe-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0066cc 0%, #004999 100%);
    color: white;
    padding: 10px 20px;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 700;
    margin: 5px auto;
    box-shadow: 0 2px 8px rgba(0, 102, 204, 0.3);
    border: 2px solid #0052a3;
    text-transform: none;
    letter-spacing: 0.3px;
    transition: all 0.3s ease;
    width: auto;
    max-width: fit-content;
}

.service-sepe-badge:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 102, 204, 0.5);
    background: linear-gradient(135deg, #0052a3 0%, #003d7a 100%);
}

.service-sepe-badge strong {
    font-weight: 700;
}

.service-sepe-badge svg {
    flex-shrink: 0;
    width: 16px;
    height: 16px;
    margin-right: 6px;
}

/* Estilos para certificados en servicios */
.service-certificates {
    margin: 15px 0;
    text-align: left;
    background: #f8f9fa;
    padding: 12px;
    border-radius: 8px;
    border-left: 4px solid #0066cc;
}

.service-certificates h4 {
    font-size: 13px;
    margin-bottom: 10px;
    color: #0066cc;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.service-cert-list {
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: 12px;
}

.service-cert-list li {
    margin: 8px 0;
    color: #495057;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    line-height: 1.4;
}

.service-cert-code {
    background: #0066cc;
    color: white;
    padding: 6px 10px;
    border-radius: 6px;
    font-weight: 800;
    font-size: 11px;
    margin-right: 10px;
    min-width: 80px;
    text-align: center;
    flex-shrink: 0;
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 2px 6px rgba(0, 102, 204, 0.3);
    letter-spacing: 0.5px;
}

.service-cert-code:hover {
    background: #0052a3;
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 102, 204, 0.5);
}

.service-icon {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 60px;
    height: 60px;
    background: rgba(0, 102, 204, 0.1);
    border-radius: 50%;
    margin: 0 auto 15px;
}

/* ESTILOS PARA LOS BOTONES DENTRO DE LAS TARJETAS */
.service-card .btn,
.service-card .cta-button {
    display: inline-block;
    width: auto !important;
    max-width: 100%;
    padding: 10px 20px !important;
    font-size: 0.85rem !important;
    margin: 5px auto !important;
    text-align: center;
    white-space: nowrap;
}

/* Botones azules (Acreditados, Formación 100%) */
.service-card .btn:not(.btn-outline) {
    background: #0066cc !important;
    color: white !important;
    border: none !important;
}

/* Botones naranjas (Más Información) */
.service-card .btn-outline,
.service-card .cta-button {
    background: #ff6b35 !important;
    color: white !important;
    border: 2px solid #ff6b35 !important;
}

.service-card .btn:hover,
.service-card .cta-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.services-carousel-container {
    position: relative;
    padding: 0 70px;
    margin-top: 40px;
    max-width: 1400px;
    margin-left: auto;
    margin-right: auto;
}

.services-carousel-wrapper {
    overflow: hidden;
    width: 100%;
}

.services-carousel-track {
    display: flex !important;
    flex-direction: row !important;
    transition: transform 0.5s ease-in-out;
    gap: 30px;
    width: 100%;
    flex-wrap: nowrap !important;
}

.services-carousel-track .service-card {
    flex: 0 0 calc(33.333% - 20px) !important;
    min-width: calc(33.333% - 20px) !important;
    max-width: calc(33.333% - 20px) !important;
    box-sizing: border-box;
    display: flex !important;
    flex-direction: column !important;
}

.services-carousel-control {
    position: absolute !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    background: white;
    border: 2px solid var(--color-primary);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 10 !important;
    color: var(--color-primary);
}

.services-carousel-control:hover {
    background: var(--color-primary);
    color: white;
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 6px 20px rgba(0, 102, 204, 0.4);
}

.services-carousel-control.prev {
    left: 0 !important;
}

.services-carousel-control.next {
    right: 0 !important;
}

.services-carousel-control:disabled {
    opacity: 0.3;
    cursor: not-allowed;
}

.services-carousel-control:disabled:hover {
    background: white;
    color: var(--color-primary);
    transform: translateY(-50%);
    box-shadow: none;
}

.services-carousel-dots {
    display: flex !important;
    flex-direction: row !important;
    justify-content: center !important;
    align-items: center !important;
    gap: 10px !important;
    margin-top: 40px;
    width: 100%;
}

.services-carousel-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #dee2e6;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0;
}

.services-carousel-dot:hover {
    background: #adb5bd;
    transform: scale(1.2);
}

.services-carousel-dot.active {
    background: var(--color-primary);
    width: 30px;
    border-radius: 6px;
}

/* Responsive */
@media (max-width: 1024px) {
    .services-carousel-track .service-card {
        flex: 0 0 calc(50% - 15px) !important;
        min-width: calc(50% - 15px) !important;
        max-width: calc(50% - 15px) !important;
    }
}

@media (max-width: 768px) {
    .services-carousel-container {
        padding: 0 50px;
    }
    
    .services-carousel-track {
        gap: 20px;
    }
    
    .services-carousel-track .service-card {
        flex: 0 0 100% !important;
        min-width: 100% !important;
        max-width: 100% !important;
    }
    
    .services-carousel-control {
        width: 40px;
        height: 40px;
    }
}

@media (max-width: 480px) {
    .services-carousel-container {
        padding: 0 40px;
    }
    
    .services-carousel-control {
        width: 35px;
        height: 35px;
    }
}
</style>

<script>
(function() {
    'use strict';
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initServicesCarousel);
    } else {
        initServicesCarousel();
    }
    
    function initServicesCarousel() {
        const track = document.getElementById('servicesCarouselTrack');
        const prevBtn = document.getElementById('servicesPrevBtn');
        const nextBtn = document.getElementById('servicesNextBtn');
        const dotsContainer = document.getElementById('servicesCarouselDots');
        
        if (!track || !prevBtn || !nextBtn || !dotsContainer) return;
        
        const cards = track.querySelectorAll('.service-card');
        if (cards.length === 0) return;
        
        let currentIndex = 0;
        let cardsPerView = 3;
        
        function getCardsPerView() {
            const width = window.innerWidth;
            return width <= 768 ? 1 : width <= 1024 ? 2 : 3;
        }
        
        function updateCardsPerView() {
            cardsPerView = getCardsPerView();
        }
        
        updateCardsPerView();
        let maxIndex = Math.max(0, cards.length - cardsPerView);
        
        function createDots() {
            dotsContainer.innerHTML = '';
            maxIndex = Math.max(0, cards.length - cardsPerView);
            
            for (let i = 0; i <= maxIndex; i++) {
                const dot = document.createElement('button');
                dot.className = 'services-carousel-dot';
                dot.setAttribute('aria-label', 'Ir a diapositiva ' + (i + 1));
                dot.onclick = function() { goToSlide(i); };
                if (i === currentIndex) dot.classList.add('active');
                dotsContainer.appendChild(dot);
            }
        }
        
        function updateCarousel() {
            const cardWidth = cards[0].offsetWidth;
            const gap = 30;
            const offset = -(currentIndex * (cardWidth + gap));
            track.style.transform = 'translateX(' + offset + 'px)';
            
            const dots = dotsContainer.querySelectorAll('.services-carousel-dot');
            dots.forEach(function(dot, index) {
                if (index === currentIndex) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
            
            prevBtn.disabled = currentIndex === 0;
            nextBtn.disabled = currentIndex >= maxIndex;
            prevBtn.style.opacity = currentIndex === 0 ? '0.3' : '1';
            nextBtn.style.opacity = currentIndex >= maxIndex ? '0.3' : '1';
        }
        
        function nextSlide() {
            if (currentIndex < maxIndex) {
                currentIndex++;
                updateCarousel();
            }
        }
        
        function prevSlide() {
            if (currentIndex > 0) {
                currentIndex--;
                updateCarousel();
            }
        }
        
        function goToSlide(index) {
            if (index >= 0 && index <= maxIndex) {
                currentIndex = index;
                updateCarousel();
            }
        }
        
        prevBtn.onclick = prevSlide;
        nextBtn.onclick = nextSlide;
        
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                const oldCardsPerView = cardsPerView;
                updateCardsPerView();
                
                if (oldCardsPerView !== cardsPerView) {
                    currentIndex = Math.min(currentIndex, Math.max(0, cards.length - cardsPerView));
                    createDots();
                }
                updateCarousel();
            }, 250);
        });
        
        let touchStartX = 0;
        let touchEndX = 0;
        
        track.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });
        
        track.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            const diff = touchStartX - touchEndX;
            
            if (Math.abs(diff) > 50) {
                if (diff > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
            }
        });
        
        createDots();
        updateCarousel();
    }
})();
</script>

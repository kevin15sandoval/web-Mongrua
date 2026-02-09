<?php
/**
 * Template part for displaying the about section with dynamic carousel
 *
 * @package Mongruas
 * @since 1.0.0
 */

$about_heading = get_field("about_heading");
$about_description = get_field("about_description");
$about_highlights = get_field("about_highlights");

// Default values
$about_heading = $about_heading ?: "Formación y Enseñanza Mogruas";
$about_description = $about_description ?: "Somos un Centro Profesional para el Empleo, una empresa joven orientada a conseguir éxitos profesionales de nuestros alumnos. Con más de 20 años de experiencia desde 2005, ponemos al alcance de desempleados y trabajadores los medios más avanzados y funcionales, así como un equipo cualificado de grandes profesionales.";
?>

<section id="about" class="about-section section">
    <div class="container">
        <div class="about-content-grid">
            <!-- COLUMNA IZQUIERDA: TEXTO -->
            <div class="about-text-column">
                <h2 class="section-title"><?php echo esc_html($about_heading); ?></h2>
                <div class="about-description">
                    <?php echo wpautop(wp_kses_post($about_description)); ?>
                </div>

                <?php if ($about_highlights) : ?>
                    <div class="about-highlights">
                        <?php foreach ($about_highlights as $highlight) : ?>
                            <div class="highlight-item">
                                <?php if (!empty($highlight["icon"])) : ?>
                                    <img src="<?php echo esc_url($highlight["icon"]["url"]); ?>" 
                                         alt="<?php echo esc_attr($highlight["title"]); ?>"
                                         class="highlight-icon">
                                <?php endif; ?>
                                <div class="highlight-content">
                                    <h3 class="highlight-title"><?php echo esc_html($highlight["title"]); ?></h3>
                                    <p class="highlight-text"><?php echo esc_html($highlight["text"]); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <!-- Default highlights -->
                    <div class="about-highlights">
                        <div class="highlight-item">
                            <div class="highlight-icon-box">
                                <span class="highlight-emoji">💡</span>
                            </div>
                            <div class="highlight-content">
                                <h3 class="highlight-title">Innovación</h3>
                                <p class="highlight-text">Contamos con 3 impresoras 3D para fomentar la creatividad y el aprendizaje práctico</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- COLUMNA DERECHA: CARRUSEL -->
            <div class="about-carousel-column">
                <h2 class="carousel-title">📸 Nuestras Instalaciones</h2>
                <p class="carousel-subtitle">Conoce nuestro centro de formación profesional</p>
                <div class="about-carousel-wrapper">
                    <!-- CARRUSEL CON FOTOS REALES - CÓDIGO FUNCIONAL -->
                    <div class="gallery-carousel-container">
                        <div class="gallery-carousel-slides" id="galleryCarouselSlides">
                            <div class="gallery-carousel-slide active">
                                <img src="<?php echo content_url('/uploads/galeria/portada.jpg'); ?>" alt="Portada Mogruas">
                                <div class="gallery-carousel-caption">Centro de Formación Mogruas</div>
                            </div>
                            <div class="gallery-carousel-slide">
                                <img src="<?php echo content_url('/uploads/galeria/entrada.jpg'); ?>" alt="Entrada">
                                <div class="gallery-carousel-caption">Entrada Principal</div>
                            </div>
                            <div class="gallery-carousel-slide">
                                <img src="<?php echo content_url('/uploads/galeria/isntalacion1.jpg'); ?>" alt="Instalación 1">
                                <div class="gallery-carousel-caption">Nuestras Instalaciones</div>
                            </div>
                            <div class="gallery-carousel-slide">
                                <img src="<?php echo content_url('/uploads/galeria/instalacion2.jpg'); ?>" alt="Instalación 2">
                                <div class="gallery-carousel-caption">Espacios de Formación</div>
                            </div>
                            <div class="gallery-carousel-slide">
                                <img src="<?php echo content_url('/uploads/galeria/instalion3.jpg'); ?>" alt="Instalación 3">
                                <div class="gallery-carousel-caption">Áreas de Trabajo</div>
                            </div>
                            <div class="gallery-carousel-slide">
                                <img src="<?php echo content_url('/uploads/galeria/instalcion4.jpg'); ?>" alt="Instalación 4">
                                <div class="gallery-carousel-caption">Equipamiento Moderno</div>
                            </div>
                            <div class="gallery-carousel-slide">
                                <img src="<?php echo content_url('/uploads/galeria/clases1.jpg'); ?>" alt="Clases 1">
                                <div class="gallery-carousel-caption">Aulas de Formación</div>
                            </div>
                            <div class="gallery-carousel-slide">
                                <img src="<?php echo content_url('/uploads/galeria/clases2.jpg'); ?>" alt="Clases 2">
                                <div class="gallery-carousel-caption">Clases Prácticas</div>
                            </div>
                            <div class="gallery-carousel-slide">
                                <img src="<?php echo content_url('/uploads/galeria/clases3.jpg'); ?>" alt="Clases 3">
                                <div class="gallery-carousel-caption">Formación Profesional</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- CONTROLES CON FLECHAS A LOS LADOS -->
                    <button class="gallery-nav-arrow gallery-nav-prev" id="galleryPrev" aria-label="Anterior">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </button>
                    <button class="gallery-nav-arrow gallery-nav-next" id="galleryNext" aria-label="Siguiente">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>
                    
                    <script>
                    (function() {
                        // Prevenir múltiples inicializaciones
                        if (window.galleryCarouselInitialized) {
                            return;
                        }
                        window.galleryCarouselInitialized = true;
                        
                        let indiceActual = 0;
                        let intervaloAuto;
                        
                        function iniciarCarruselGaleria() {
                            const slides = document.querySelectorAll('.gallery-carousel-slide');
                            const prevBtn = document.getElementById('galleryPrev');
                            const nextBtn = document.getElementById('galleryNext');
                            const container = document.querySelector('.gallery-carousel-container');
                            
                            if (!slides.length || !container) {
                                return;
                            }
                            
                            function mostrarSlide(n) {
                                if (n >= slides.length) indiceActual = 0;
                                if (n < 0) indiceActual = slides.length - 1;
                                
                                slides.forEach(slide => slide.classList.remove('active'));
                                slides[indiceActual].classList.add('active');
                            }
                            
                            function cambiarSlide(direccion) {
                                indiceActual += direccion;
                                mostrarSlide(indiceActual);
                                reiniciarAuto();
                            }
                            
                            function siguienteAuto() {
                                indiceActual++;
                                mostrarSlide(indiceActual);
                            }
                            
                            function reiniciarAuto() {
                                clearInterval(intervaloAuto);
                                intervaloAuto = setInterval(siguienteAuto, 7000);
                            }
                            
                            // Event listeners
                            if (prevBtn) prevBtn.addEventListener('click', function() { cambiarSlide(-1); });
                            if (nextBtn) nextBtn.addEventListener('click', function() { cambiarSlide(1); });
                            
                            // Autoplay
                            intervaloAuto = setInterval(siguienteAuto, 7000);
                            
                            // Pausar en hover
                            container.addEventListener('mouseenter', function() { clearInterval(intervaloAuto); });
                            container.addEventListener('mouseleave', function() {
                                intervaloAuto = setInterval(siguienteAuto, 7000);
                            });
                        }
                        
                        if (document.readyState === 'loading') {
                            document.addEventListener('DOMContentLoaded', iniciarCarruselGaleria);
                        } else {
                            iniciarCarruselGaleria();
                        }
                    })();
                    </script>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* LAYOUT DE 2 COLUMNAS */
.about-content-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    max-width: 1400px;
    margin: 0 auto;
    align-items: start;
}

/* COLUMNA DE TEXTO */
.about-text-column {
    text-align: left;
}

.about-text-column .section-title {
    font-size: 2.5rem;
    color: #2c3e50;
    margin-bottom: 20px;
    font-weight: 800;
}

.about-text-column .about-description {
    font-size: 1.1rem;
    color: #495057;
    line-height: 1.8;
    margin-bottom: 30px;
}

.about-highlights {
    margin-top: 30px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.about-highlights .highlight-item {
    display: flex;
    gap: 20px;
    align-items: flex-start;
    background: linear-gradient(135deg, rgba(0, 102, 204, 0.05) 0%, rgba(0, 82, 163, 0.08) 100%);
    padding: 25px;
    border-radius: 15px;
    border-left: 4px solid var(--color-primary);
    text-align: left;
}

.highlight-icon-box {
    flex-shrink: 0;
    width: 60px;
    height: 60px;
    background: white;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.highlight-emoji {
    font-size: 32px;
}

.highlight-content {
    flex: 1;
}

.highlight-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--color-primary);
    margin-bottom: 8px;
}

.highlight-text {
    font-size: 15px;
    color: #495057;
    line-height: 1.6;
    margin: 0;
}

/* COLUMNA DE CARRUSEL */
.about-carousel-column {
    text-align: center;
}

.carousel-title {
    font-size: 2rem;
    color: #2c3e50;
    margin-bottom: 15px;
    font-weight: 800;
}

.carousel-subtitle {
    font-size: 1.1rem;
    color: #6c757d;
    margin-bottom: 35px;
}

.about-carousel-wrapper {
    position: relative;
    border-radius: 20px;
    overflow: visible;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
}

/* CARRUSEL DE GALERÍA - CÓDIGO FUNCIONAL */
.gallery-carousel-container {
    position: relative;
    width: 100%;
    height: 400px;
    overflow: hidden;
    border-radius: 20px;
    background: #000;
}

/* FLECHAS DE NAVEGACIÓN A LOS LADOS */
.gallery-nav-arrow {
    position: absolute !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: white;
    border: 2px solid #0066cc;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 10 !important;
    color: #0066cc;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.gallery-nav-arrow:hover {
    background: #0066cc;
    color: white;
    transform: translateY(-50%) scale(1.1) !important;
    box-shadow: 0 6px 20px rgba(0, 102, 204, 0.4);
}

.gallery-nav-arrow:active {
    transform: translateY(-50%) scale(0.95) !important;
}

.gallery-nav-prev {
    left: 15px !important;
}

.gallery-nav-next {
    right: 15px !important;
}

.gallery-carousel-slides {
    position: relative;
    width: 100%;
    height: 100%;
}

.gallery-carousel-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
}

.gallery-carousel-slide.active {
    opacity: 1;
    z-index: 1;
}

.gallery-carousel-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.gallery-carousel-caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
    color: white;
    padding: 30px 20px 20px;
    font-size: 18px;
    font-weight: 600;
    text-align: center;
}

/* RESPONSIVE */
@media (max-width: 1024px) {
    .about-content-grid {
        grid-template-columns: 1fr;
        gap: 50px;
    }
    
    .about-text-column {
        text-align: center;
    }
    
    .about-highlights .highlight-item {
        text-align: left;
    }
}

@media (max-width: 768px) {
    .about-text-column .section-title {
        font-size: 2rem;
    }
    
    .carousel-title {
        font-size: 1.8rem;
    }
}
</style>
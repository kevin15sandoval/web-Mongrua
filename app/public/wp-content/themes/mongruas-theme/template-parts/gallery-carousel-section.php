<?php
/**
 * Template part for displaying photo gallery carousel
 * Carrusel de fotos reales
 */
?>

<section id="gallery-carousel" class="gallery-carousel-section section" style="padding: 80px 0; background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div class="section-heading" style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 3rem; color: #2c3e50; margin-bottom: 20px; font-weight: 800;">📸 Nuestras Instalaciones</h2>
            <p style="font-size: 1.2rem; color: #6c757d;">Conoce nuestro centro de formación profesional</p>
        </div>

        <div class="carousel-container" style="position: relative; max-width: 1000px; margin: 0 auto; padding: 0 60px;">
            <div class="carousel-wrapper" style="position: relative; overflow: hidden; border-radius: 20px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2); background: white;">
                <div class="carousel-track" id="carouselTrack">
                    <?php
                    // Buscar imágenes en la carpeta uploads
                    $uploads_dir = WP_CONTENT_DIR . '/uploads/2025/10';
                    $uploads_url = content_url('/uploads/2025/10');
                    
                    $imagenes = [];
                    if (is_dir($uploads_dir)) {
                        $archivos = scandir($uploads_dir);
                        foreach ($archivos as $archivo) {
                            if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $archivo)) {
                                $imagenes[] = $archivo;
                            }
                        }
                    }
                    
                    // Si hay imágenes, mostrarlas
                    if (count($imagenes) > 0):
                        foreach (array_slice($imagenes, 0, 8) as $index => $imagen):
                    ?>
                        <div class="carousel-slide <?php echo $index === 0 ? 'active' : ''; ?>" style="display: <?php echo $index === 0 ? 'block' : 'none'; ?>;">
                            <img src="<?php echo esc_url($uploads_url . '/' . $imagen); ?>" 
                                 alt="Instalaciones Mogruas" 
                                 style="width: 100%; height: 500px; object-fit: cover; display: block;">
                            <div class="carousel-caption" style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent); color: white; padding: 30px; font-size: 18px; font-weight: 600;">
                                Centro de Formación Mogruas
                            </div>
                        </div>
                    <?php
                        endforeach;
                    else:
                        // Imágenes placeholder si no hay fotos
                        $placeholders = [
                            ['titulo' => 'Aulas Modernas', 'desc' => 'Espacios equipados con tecnología'],
                            ['titulo' => 'Laboratorio', 'desc' => 'Instalaciones para prácticas'],
                            ['titulo' => 'Zona de Estudio', 'desc' => 'Áreas cómodas de aprendizaje'],
                            ['titulo' => 'Certificaciones', 'desc' => 'Entrega de certificados oficiales']
                        ];
                        
                        foreach ($placeholders as $index => $item):
                    ?>
                        <div class="carousel-slide <?php echo $index === 0 ? 'active' : ''; ?>" style="display: <?php echo $index === 0 ? 'block' : 'none'; ?>;">
                            <div style="height: 500px; display: flex; flex-direction: column; align-items: center; justify-content: center; background: linear-gradient(135deg, #e9ecef 0%, #f8f9fa 100%); padding: 40px; text-align: center;">
                                <div style="font-size: 80px; margin-bottom: 20px; opacity: 0.5;">📸</div>
                                <h3 style="font-size: 28px; font-weight: 700; color: #495057; margin-bottom: 10px;"><?php echo esc_html($item['titulo']); ?></h3>
                                <p style="font-size: 16px; color: #6c757d; margin: 0;"><?php echo esc_html($item['desc']); ?></p>
                            </div>
                        </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
                
                <!-- Controles -->
                <button onclick="cambiarSlide(-1)" class="carousel-control prev" style="position: absolute; top: 50%; transform: translateY(-50%); left: 15px; background: rgba(255, 255, 255, 0.95); border: none; width: 50px; height: 50px; border-radius: 50%; cursor: pointer; font-size: 24px; font-weight: bold; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); z-index: 10; color: #0066cc;">‹</button>
                <button onclick="cambiarSlide(1)" class="carousel-control next" style="position: absolute; top: 50%; transform: translateY(-50%); right: 15px; background: rgba(255, 255, 255, 0.95); border: none; width: 50px; height: 50px; border-radius: 50%; cursor: pointer; font-size: 24px; font-weight: bold; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); z-index: 10; color: #0066cc;">›</button>
            </div>
            
            <!-- Indicadores -->
            <div class="carousel-indicators" id="carouselIndicators" style="display: flex; justify-content: center; gap: 12px; margin-top: 30px;">
                <!-- Se generan con JavaScript -->
            </div>
        </div>
    </div>
</section>

<style>
.carousel-control:hover {
    background: #0066cc !important;
    color: white !important;
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 6px 20px rgba(0, 102, 204, 0.4);
}

.carousel-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #dee2e6;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0;
}

.carousel-indicator:hover {
    background: #adb5bd;
    transform: scale(1.2);
}

.carousel-indicator.active {
    background: #0066cc;
    width: 30px;
    border-radius: 6px;
}

@media (max-width: 768px) {
    .carousel-container {
        padding: 0 40px !important;
    }
    
    .carousel-slide img,
    .carousel-slide > div {
        height: 350px !important;
    }
    
    .carousel-control {
        width: 40px !important;
        height: 40px !important;
        font-size: 20px !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.carousel-slide');
    const indicatorsContainer = document.getElementById('carouselIndicators');
    
    let slideActual = 0;
    const totalSlides = slides.length;
    
    // Crear indicadores
    for (let i = 0; i < totalSlides; i++) {
        const indicator = document.createElement('button');
        indicator.classList.add('carousel-indicator');
        if (i === 0) indicator.classList.add('active');
        indicator.setAttribute('aria-label', `Ir a imagen ${i + 1}`);
        indicator.onclick = () => irASlide(i);
        indicatorsContainer.appendChild(indicator);
    }
    
    const indicators = document.querySelectorAll('.carousel-indicator');
    
    function mostrarSlide(n) {
        // Ocultar todos
        slides.forEach(slide => slide.style.display = 'none');
        indicators.forEach(ind => {
            ind.classList.remove('active');
            ind.style.background = '#dee2e6';
            ind.style.width = '12px';
        });
        
        // Mostrar actual
        slides[n].style.display = 'block';
        indicators[n].classList.add('active');
        indicators[n].style.background = '#0066cc';
        indicators[n].style.width = '30px';
    }
    
    window.cambiarSlide = function(direccion) {
        slideActual += direccion;
        
        if (slideActual >= totalSlides) {
            slideActual = 0;
        } else if (slideActual < 0) {
            slideActual = totalSlides - 1;
        }
        
        mostrarSlide(slideActual);
    };
    
    window.irASlide = function(n) {
        slideActual = n;
        mostrarSlide(slideActual);
    };
    
    // Autoplay cada 5 segundos
    setInterval(() => {
        cambiarSlide(1);
    }, 5000);
    
    // Soporte para teclado
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') cambiarSlide(-1);
        if (e.key === 'ArrowRight') cambiarSlide(1);
    });
    
    console.log('🎠 Carrusel de fotos cargado:', totalSlides, 'imágenes');
});
</script>
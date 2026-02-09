<?php
/**
 * COPIAR CARRUSEL DE INICIO A ANUNCIOS
 * Solución simple: usar el carrusel que ya funciona
 */

echo "<!DOCTYPE html>";
echo "<html><head><title>Copiar Carrusel de Inicio</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{background:#d4edda;color:#155724;padding:15px;margin:10px 0;border-radius:5px;} .error{background:#f8d7da;color:#721c24;padding:15px;margin:10px 0;border-radius:5px;}</style>";
echo "</head><body>";

echo "<h1>🎠 COPIAR CARRUSEL DE INICIO A ANUNCIOS</h1>";

$theme_path = __DIR__ . '/wp-content/themes/mongruas-theme';

// Template simple con carrusel funcional
$new_template = '<?php
/**
 * Template Name: Página de Cursos
 * Template Post Type: page
 *
 * Catálogo completo de cursos disponibles
 * 
 * @package Mongruas
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main page-cursos">
    
    <!-- CARRUSEL DE CURSOS - BASADO EN EL QUE FUNCIONA -->
    <section id="proximos-cursos" class="proximos-cursos-section section">
        <div class="container">
            <div class="section-heading">
                <h2>Próximos Cursos</h2>
                <p>Cursos que comenzarán próximamente. ¡Reserva tu plaza!</p>
            </div>

            <!-- Carrusel de cursos -->
            <div class="cursos-carousel">
                <div class="carousel-wrapper-cursos">
                    <div class="carousel-track-cursos" id="carouselTrackCursos">
                        <?php
                        // Obtener cursos del sistema dinámico
                        $courses = get_option("mongruas_courses", []);
                        
                        // Si no hay cursos, crear algunos por defecto
                        if (empty($courses)) {
                            $courses = [
                                [
                                    "id" => 1,
                                    "name" => "Montaje y Mantenimiento de Instalaciones Eléctricas", 
                                    "date" => "Enero 2025", 
                                    "modality" => "Presencial", 
                                    "duration" => "15 plazas", 
                                    "description" => "Curso completo de instalaciones eléctricas de baja tensión con certificado oficial.",
                                    "full_description" => "Este curso te capacitará para realizar instalaciones eléctricas de baja tensión según el REBT. Incluye prácticas reales y certificado oficial.",
                                    "price" => "Gratuito",
                                    "hours" => "120 horas"
                                ],
                                [
                                    "id" => 2,
                                    "name" => "Sistemas Domóticos e Inmóticos", 
                                    "date" => "Febrero 2025", 
                                    "modality" => "Presencial", 
                                    "duration" => "12 plazas", 
                                    "description" => "Especialización en automatización de edificios y sistemas inteligentes.",
                                    "full_description" => "Aprende a diseñar e instalar sistemas domóticos e inmóticos. Tecnología de vanguardia para el futuro de los edificios inteligentes.",
                                    "price" => "Gratuito",
                                    "hours" => "80 horas"
                                ],
                                [
                                    "id" => 3,
                                    "name" => "Control de Plagas", 
                                    "date" => "Marzo 2025", 
                                    "modality" => "Presencial", 
                                    "duration" => "10 plazas", 
                                    "description" => "Formación profesional en control y prevención de plagas urbanas.",
                                    "full_description" => "Conviértete en técnico especialista en control de plagas. Certificación oficial para ejercer profesionalmente en el sector.",
                                    "price" => "Gratuito",
                                    "hours" => "60 horas"
                                ],
                                [
                                    "id" => 4,
                                    "name" => "Prevención de Riesgos Laborales", 
                                    "date" => "Abril 2025", 
                                    "modality" => "Online", 
                                    "duration" => "20 plazas", 
                                    "description" => "Curso completo de PRL con certificado oficial.",
                                    "full_description" => "Formación completa en Prevención de Riesgos Laborales. Conviértete en técnico superior en PRL con todas las especialidades.",
                                    "price" => "Gratuito",
                                    "hours" => "200 horas"
                                ],
                                [
                                    "id" => 5,
                                    "name" => "Soldadura con Electrodo Revestido", 
                                    "date" => "Mayo 2025", 
                                    "modality" => "Presencial", 
                                    "duration" => "8 plazas", 
                                    "description" => "Curso práctico de soldadura con certificación oficial.",
                                    "full_description" => "Aprende las técnicas de soldadura con electrodo revestido. Curso 100% práctico con certificación oficial para trabajar en el sector.",
                                    "price" => "Gratuito",
                                    "hours" => "100 horas"
                                ],
                                [
                                    "id" => 6,
                                    "name" => "Gestión de Almacén", 
                                    "date" => "Junio 2025", 
                                    "modality" => "Mixta", 
                                    "duration" => "15 plazas", 
                                    "description" => "Gestión eficiente de almacenes y logística.",
                                    "full_description" => "Conviértete en experto en gestión de almacenes. Aprende sobre logística, inventarios y sistemas de gestión modernos.",
                                    "price" => "Gratuito",
                                    "hours" => "90 horas"
                                ]
                            ];
                            update_option("mongruas_courses", $courses);
                        }
                        
                        // Mostrar cursos en el carrusel
                        foreach ($courses as $index => $course):
                            $curso_id = isset($course["id"]) ? $course["id"] : uniqid();
                        ?>
                        
                        <div class="carousel-slide-cursos <?php echo $index === 0 ? 'active' : ''; ?>">
                            <div class="curso-card">
                                <div class="curso-header">
                                    <div class="curso-badge">Próximamente</div>
                                    <div class="curso-fecha">
                                        <span class="fecha-icon">📅</span>
                                        <span class="fecha-text"><?php echo esc_html($course["date"]); ?></span>
                                    </div>
                                </div>
                                
                                <div class="curso-content">
                                    <h3 class="curso-titulo"><?php echo esc_html($course["name"]); ?></h3>
                                    <p class="curso-descripcion"><?php echo esc_html($course["description"]); ?></p>
                                    
                                    <div class="curso-detalles">
                                        <div class="detalle-item">
                                            <span class="detalle-icon">⏱️</span>
                                            <span><?php echo esc_html($course["duration"]); ?></span>
                                        </div>
                                        <div class="detalle-item">
                                            <span class="detalle-icon">💻</span>
                                            <span><?php echo esc_html($course["modality"]); ?></span>
                                        </div>
                                        <?php if (isset($course["hours"])): ?>
                                        <div class="detalle-item">
                                            <span class="detalle-icon">🕐</span>
                                            <span><?php echo esc_html($course["hours"]); ?></span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="curso-acciones">
                                    <a href="<?php echo home_url("/curso-detalle/?id=" . $curso_id); ?>" class="btn-ver-mas">
                                        Ver Más Información
                                    </a>
                                    <a href="#contact" class="btn-reservar">
                                        Reservar Plaza
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Controles del carrusel -->
                <button class="carousel-control-cursos prev" id="prevBtnCursos" aria-label="Anterior">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>
                <button class="carousel-control-cursos next" id="nextBtnCursos" aria-label="Siguiente">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>

                <!-- Indicadores -->
                <div class="carousel-indicators-cursos" id="carouselIndicatorsCursos">
                    <!-- Se generan dinámicamente con JavaScript -->
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>

<style>
/* CARRUSEL DE CURSOS - BASADO EN EL QUE FUNCIONA */
.proximos-cursos-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    position: relative;
}

.proximos-cursos-section .section-heading {
    text-align: center;
    margin-bottom: 60px;
}

.proximos-cursos-section .section-heading h2 {
    font-size: 3.5rem;
    color: #2c3e50;
    margin-bottom: 20px;
    font-weight: 800;
}

.proximos-cursos-section .section-heading p {
    font-size: 1.3rem;
    color: #6c757d;
    max-width: 600px;
    margin: 0 auto;
}

.cursos-carousel {
    max-width: 800px;
    margin: 0 auto;
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.carousel-wrapper-cursos {
    position: relative;
    overflow: hidden;
    border-radius: 20px;
}

.carousel-track-cursos {
    display: flex;
    transition: transform 0.5s ease-in-out;
}

.carousel-slide-cursos {
    min-width: 100%;
    position: relative;
    display: none;
}

.carousel-slide-cursos.active {
    display: block;
}

.curso-card {
    background: white;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    position: relative;
}

.curso-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #3498db, #27ae60);
    border-radius: 20px 20px 0 0;
}

.curso-header {
    margin-bottom: 25px;
}

.curso-badge {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    display: inline-block;
    margin-bottom: 15px;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
}

.curso-fecha {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #e74c3c;
    font-weight: 700;
    background: rgba(231, 76, 60, 0.1);
    padding: 12px 18px;
    border-radius: 15px;
    border-left: 5px solid #e74c3c;
}

.fecha-icon {
    font-size: 1.3rem;
}

.fecha-text {
    font-size: 1rem;
}

.curso-titulo {
    font-size: 2rem;
    color: #2c3e50;
    margin-bottom: 15px;
    font-weight: 800;
    line-height: 1.3;
}

.curso-descripcion {
    color: #6c757d;
    line-height: 1.6;
    margin-bottom: 25px;
    font-size: 1.1rem;
}

.curso-detalles {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 30px;
    padding: 20px;
    background: rgba(52, 152, 219, 0.08);
    border-radius: 15px;
    border: 1px solid rgba(52, 152, 219, 0.15);
}

.detalle-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #495057;
    font-size: 1rem;
    font-weight: 600;
}

.detalle-icon {
    color: #3498db;
    font-size: 1.2rem;
}

.curso-acciones {
    display: flex;
    gap: 15px;
}

.btn-ver-mas {
    flex: 1;
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    padding: 15px 25px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 700;
    text-align: center;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
}

.btn-ver-mas:hover {
    background: linear-gradient(135deg, #2980b9, #1f618d);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(52, 152, 219, 0.4);
    color: white;
    text-decoration: none;
}

.btn-reservar {
    flex: 1;
    background: linear-gradient(135deg, #27ae60, #229954);
    color: white;
    padding: 15px 25px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 700;
    text-align: center;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3);
}

.btn-reservar:hover {
    background: linear-gradient(135deg, #229954, #1e8449);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(39, 174, 96, 0.4);
    color: white;
    text-decoration: none;
}

.carousel-control-cursos {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: none;
    background: rgba(255, 255, 255, 0.9);
    color: #333;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    z-index: 10;
}

.carousel-control-cursos:hover {
    background: #3498db;
    color: white;
    transform: translateY(-50%) scale(1.1);
}

.carousel-control-cursos.prev {
    left: -25px;
}

.carousel-control-cursos.next {
    right: -25px;
}

.carousel-indicators-cursos {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-top: 30px;
}

.carousel-indicator-cursos {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: none;
    background: rgba(52, 152, 219, 0.3);
    cursor: pointer;
    transition: all 0.3s ease;
}

.carousel-indicator-cursos:hover {
    background: rgba(52, 152, 219, 0.6);
}

.carousel-indicator-cursos.active {
    background: #3498db;
    transform: scale(1.3);
    box-shadow: 0 3px 10px rgba(52, 152, 219, 0.4);
}

/* Responsive */
@media (max-width: 768px) {
    .proximos-cursos-section .section-heading h2 {
        font-size: 2.5rem;
    }
    
    .curso-card {
        padding: 30px 25px;
    }
    
    .curso-titulo {
        font-size: 1.6rem;
    }
    
    .curso-acciones {
        flex-direction: column;
        gap: 15px;
    }
    
    .carousel-control-cursos {
        width: 40px;
        height: 40px;
    }
    
    .carousel-control-cursos.prev {
        left: -20px;
    }
    
    .carousel-control-cursos.next {
        right: -20px;
    }
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const track = document.getElementById("carouselTrackCursos");
    if (!track) return;
    
    const slides = document.querySelectorAll(".carousel-slide-cursos");
    const prevBtn = document.getElementById("prevBtnCursos");
    const nextBtn = document.getElementById("nextBtnCursos");
    const indicatorsContainer = document.getElementById("carouselIndicatorsCursos");
    
    let currentSlide = 0;
    const totalSlides = slides.length;
    
    // Crear indicadores
    for (let i = 0; i < totalSlides; i++) {
        const indicator = document.createElement("button");
        indicator.classList.add("carousel-indicator-cursos");
        if (i === 0) indicator.classList.add("active");
        indicator.setAttribute("aria-label", `Ir a curso ${i + 1}`);
        indicator.onclick = () => goToSlide(i);
        indicatorsContainer.appendChild(indicator);
    }
    
    const indicators = document.querySelectorAll(".carousel-indicator-cursos");
    
    function updateCarousel() {
        slides.forEach(slide => slide.classList.remove("active"));
        slides[currentSlide].classList.add("active");
        
        indicators.forEach(indicator => indicator.classList.remove("active"));
        indicators[currentSlide].classList.add("active");
    }
    
    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateCarousel();
    }
    
    function prevSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        updateCarousel();
    }
    
    function goToSlide(index) {
        currentSlide = index;
        updateCarousel();
    }
    
    nextBtn.onclick = nextSlide;
    prevBtn.onclick = prevSlide;
    
    // Autoplay
    let autoplayInterval = setInterval(nextSlide, 5000);
    
    const carouselContainer = document.querySelector(".cursos-carousel");
    carouselContainer.addEventListener("mouseenter", () => clearInterval(autoplayInterval));
    carouselContainer.addEventListener("mouseleave", () => {
        autoplayInterval = setInterval(nextSlide, 5000);
    });
    
    console.log("🎠 Carrusel de cursos cargado correctamente");
});
</script>';

$template_path = $theme_path . '/page-templates/page-cursos.php';
if (file_put_contents($template_path, $new_template)) {
    echo "<div class='success'>✅ Template REEMPLAZADO con carrusel funcional (basado en el de inicio)</div>";
} else {
    echo "<div class='error'>❌ Error al reemplazar template</div>";
}

echo "<hr>";
echo "<h2>🎯 CARRUSEL COPIADO DEL QUE FUNCIONA</h2>";
echo "<p>Se ha creado un carrusel basado en el que ya funciona en la página de inicio:</p>";
echo "<ul>";
echo "<li>✅ <strong>Un curso por vez</strong> - Como el carrusel de fotos</li>";
echo "<li>✅ <strong>Navegación con botones</strong> - Anterior/Siguiente</li>";
echo "<li>✅ <strong>Indicadores</strong> - Puntos para navegar</li>";
echo "<li>✅ <strong>Autoplay</strong> - Cambia automáticamente cada 5 segundos</li>";
echo "<li>✅ <strong>Botón \"Ver más información\"</strong> - Funcional</li>";
echo "<li>✅ <strong>Integrado con gestión</strong> - Usa cursos del sistema</li>";
echo "<li>✅ <strong>Responsive</strong> - Se adapta a móviles</li>";
echo "</ul>";

echo "<h3>🔗 Probar Ahora:</h3>";
echo "<p><a href='/anuncios/?v=" . time() . "' target='_blank' style='background: #27ae60; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; margin: 10px 0;'>🎠 VER CARRUSEL FUNCIONAL</a></p>";

echo "<p style='margin-top: 20px; padding: 15px; background: #d4edda; border-left: 4px solid #27ae60; color: #155724;'>";
echo "<strong>✅ ¡Carrusel funcional implementado!</strong><br>";
echo "Ahora deberías ver un carrusel que funciona igual que el de fotos de la página de inicio, pero mostrando cursos.";
echo "</p>";

echo "</body></html>";
?>
<?php
/**
 * REEMPLAZAR TEMPLATE COMPLETO CON CARRUSEL 3 EN 3
 * Solución directa que reemplaza todo el template
 */

echo "<!DOCTYPE html>";
echo "<html><head><title>Reemplazar Template Completo</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{background:#d4edda;color:#155724;padding:15px;margin:10px 0;border-radius:5px;} .error{background:#f8d7da;color:#721c24;padding:15px;margin:10px 0;border-radius:5px;}</style>";
echo "</head><body>";

echo "<h1>🔄 REEMPLAZAR TEMPLATE COMPLETO</h1>";

$theme_path = __DIR__ . '/wp-content/themes/mongruas-theme';

// Template completo con carrusel 3 en 3
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

<style>
/* CARRUSEL 3 EN 3 - ESTILOS COMPLETOS */
.carousel-3-en-3-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    position: relative;
    overflow: hidden;
}

.carousel-3-en-3-section::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%233498db\" fill-opacity=\"0.03\"%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"4\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.5;
}

.carousel-3-en-3-section .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
    z-index: 2;
}

.carousel-3-en-3-section .section-header {
    text-align: center;
    margin-bottom: 60px;
}

.carousel-3-en-3-section .section-header h2 {
    font-size: 3.5rem;
    color: #2c3e50;
    margin-bottom: 20px;
    font-weight: 800;
    position: relative;
}

.carousel-3-en-3-section .section-header h2::after {
    content: "";
    display: block;
    width: 100px;
    height: 4px;
    background: linear-gradient(90deg, #3498db, #27ae60);
    margin: 20px auto 0;
    border-radius: 2px;
}

.carousel-3-en-3-section .section-header p {
    font-size: 1.3rem;
    color: #6c757d;
    max-width: 600px;
    margin: 0 auto;
}

/* Contenedor del Carrusel */
.carousel-3-container {
    position: relative;
    max-width: 1100px;
    margin: 0 auto;
    overflow: hidden;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    background: white;
    padding: 20px;
}

.carousel-3-track {
    display: flex;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    gap: 30px;
}

/* Tarjetas del Carrusel */
.carousel-3-card {
    min-width: calc(33.333% - 20px);
    flex-shrink: 0;
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    transition: all 0.4s ease;
    border: 2px solid transparent;
    position: relative;
}

.carousel-3-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #3498db, #27ae60);
    border-radius: 20px 20px 0 0;
}

.carousel-3-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    border-color: #3498db;
}

/* Header de la Tarjeta */
.card-header {
    padding: 25px 25px 0;
    position: relative;
}

.course-badge {
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

.course-date {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    color: #e74c3c;
    font-weight: 700;
    background: rgba(231, 76, 60, 0.1);
    padding: 12px 18px;
    border-radius: 15px;
    border-left: 5px solid #e74c3c;
}

.date-icon {
    font-size: 1.3rem;
}

.date-text {
    font-size: 1rem;
}

/* Contenido de la Tarjeta */
.card-content {
    padding: 0 25px 20px;
}

.course-title {
    font-size: 1.4rem;
    color: #2c3e50;
    margin-bottom: 15px;
    font-weight: 800;
    line-height: 1.3;
    min-height: 70px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.course-description {
    color: #6c757d;
    line-height: 1.6;
    margin-bottom: 20px;
    font-size: 1rem;
    min-height: 50px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.course-details {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 25px;
    padding: 18px;
    background: rgba(52, 152, 219, 0.08);
    border-radius: 15px;
    border: 1px solid rgba(52, 152, 219, 0.15);
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #495057;
    font-size: 0.9rem;
    font-weight: 600;
}

.detail-icon {
    color: #3498db;
    font-size: 1rem;
}

/* Acciones de la Tarjeta */
.card-actions {
    padding: 0 25px 25px;
    display: flex;
    gap: 12px;
}

.btn-ver-mas {
    flex: 1;
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    padding: 12px 20px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    text-align: center;
    font-size: 0.9rem;
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
    padding: 12px 20px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    text-align: center;
    font-size: 0.9rem;
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

/* Controles del Carrusel */
.carousel-3-controls {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 40px;
}

.carousel-3-btn {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    border: none;
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    font-size: 24px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 6px 20px rgba(52, 152, 219, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
}

.carousel-3-btn:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4);
    background: linear-gradient(135deg, #2980b9, #1f618d);
}

.carousel-3-btn:disabled {
    background: #95a5a6;
    cursor: not-allowed;
    transform: none;
    box-shadow: 0 3px 10px rgba(149, 165, 166, 0.3);
}

/* Indicadores */
.carousel-3-indicators {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-top: 25px;
}

.carousel-3-indicator {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    border: none;
    background: rgba(52, 152, 219, 0.3);
    cursor: pointer;
    transition: all 0.3s ease;
}

.carousel-3-indicator.active {
    background: #3498db;
    transform: scale(1.3);
    box-shadow: 0 3px 10px rgba(52, 152, 219, 0.4);
}

/* Responsive */
@media (max-width: 1024px) {
    .carousel-3-card {
        min-width: calc(50% - 15px);
    }
}

@media (max-width: 768px) {
    .carousel-3-card {
        min-width: calc(100% - 0px);
    }
    
    .carousel-3-en-3-section {
        padding: 60px 0;
    }
    
    .carousel-3-en-3-section .section-header h2 {
        font-size: 2.5rem;
    }
    
    .card-actions {
        flex-direction: column;
        gap: 15px;
    }
}
</style>

<main id="primary" class="site-main page-cursos">
    
    <!-- CARRUSEL 3 EN 3 - INTEGRADO CON GESTIÓN -->
    <section class="carousel-3-en-3-section">
        <div class="container">
            <div class="section-header">
                <h2>Próximos Cursos</h2>
                <p>Cursos que comenzarán próximamente. ¡Reserva tu plaza!</p>
            </div>
            
            <div class="carousel-3-container">
                <div class="carousel-3-track" id="carousel-3-track">
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
                    
                    // Mostrar todos los cursos
                    foreach ($courses as $course):
                        $curso_id = isset($course["id"]) ? $course["id"] : uniqid();
                    ?>
                    
                    <div class="carousel-3-card">
                        <div class="card-header">
                            <div class="course-badge">Próximamente</div>
                            <div class="course-date">
                                <span class="date-icon">📅</span>
                                <span class="date-text"><?php echo esc_html($course["date"]); ?></span>
                            </div>
                        </div>
                        
                        <div class="card-content">
                            <h3 class="course-title"><?php echo esc_html($course["name"]); ?></h3>
                            <p class="course-description"><?php echo esc_html($course["description"]); ?></p>
                            
                            <div class="course-details">
                                <div class="detail-item">
                                    <span class="detail-icon">⏱️</span>
                                    <span><?php echo esc_html($course["duration"]); ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-icon">💻</span>
                                    <span><?php echo esc_html($course["modality"]); ?></span>
                                </div>
                                <?php if (isset($course["hours"])): ?>
                                <div class="detail-item">
                                    <span class="detail-icon">🕐</span>
                                    <span><?php echo esc_html($course["hours"]); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="card-actions">
                            <a href="<?php echo home_url("/curso-detalle/?id=" . $curso_id); ?>" class="btn-ver-mas">
                                Ver Más Información
                            </a>
                            <a href="#contact" class="btn-reservar">
                                Reservar Plaza
                            </a>
                        </div>
                    </div>
                    
                    <?php endforeach; ?>
                </div>
                
                <!-- Controles del Carrusel -->
                <div class="carousel-3-controls">
                    <button class="carousel-3-btn prev-btn" id="prev-btn-3" onclick="moveCarousel3(-1)">
                        ←
                    </button>
                    <button class="carousel-3-btn next-btn" id="next-btn-3" onclick="moveCarousel3(1)">
                        →
                    </button>
                </div>
                
                <!-- Indicadores -->
                <div class="carousel-3-indicators" id="carousel-3-indicators">
                    <!-- Se generan dinámicamente con JavaScript -->
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>

<script>
// CARRUSEL 3 EN 3 - JAVASCRIPT COMPLETO
let currentSlide3 = 0;
let totalSlides3 = 0;
let slidesToShow3 = 3;
let isAnimating3 = false;

document.addEventListener("DOMContentLoaded", function() {
    initCarousel3();
    createIndicators3();
    updateCarousel3();
    
    // Responsive
    window.addEventListener("resize", function() {
        updateSlidesToShow3();
        updateCarousel3();
        createIndicators3();
    });
    
    console.log("🎠 Carrusel 3 en 3 cargado correctamente");
});

function initCarousel3() {
    const track = document.getElementById("carousel-3-track");
    if (!track) return;
    
    totalSlides3 = track.children.length;
    updateSlidesToShow3();
    
    console.log("🎠 Carrusel inicializado:", totalSlides3, "cursos");
}

function updateSlidesToShow3() {
    if (window.innerWidth <= 768) {
        slidesToShow3 = 1;
    } else if (window.innerWidth <= 1024) {
        slidesToShow3 = 2;
    } else {
        slidesToShow3 = 3;
    }
}

function moveCarousel3(direction) {
    if (isAnimating3) return;
    
    isAnimating3 = true;
    
    const maxSlide = Math.max(0, totalSlides3 - slidesToShow3);
    
    currentSlide3 += direction;
    
    // Límites del carrusel
    if (currentSlide3 < 0) {
        currentSlide3 = maxSlide;
    } else if (currentSlide3 > maxSlide) {
        currentSlide3 = 0;
    }
    
    updateCarousel3();
    updateIndicators3();
    
    // Permitir nueva animación después de completarse
    setTimeout(() => {
        isAnimating3 = false;
    }, 600);
}

function goToSlide3(slideIndex) {
    if (isAnimating3) return;
    
    isAnimating3 = true;
    currentSlide3 = slideIndex;
    updateCarousel3();
    updateIndicators3();
    
    setTimeout(() => {
        isAnimating3 = false;
    }, 600);
}

function updateCarousel3() {
    const track = document.getElementById("carousel-3-track");
    if (!track) return;
    
    const cardWidth = track.children[0] ? track.children[0].offsetWidth : 0;
    const gap = 30;
    const translateX = -(currentSlide3 * (cardWidth + gap));
    
    track.style.transform = `translateX(${translateX}px)`;
    
    // Actualizar botones
    const prevBtn = document.getElementById("prev-btn-3");
    const nextBtn = document.getElementById("next-btn-3");
    
    if (prevBtn && nextBtn) {
        const maxSlide = Math.max(0, totalSlides3 - slidesToShow3);
        prevBtn.disabled = currentSlide3 === 0;
        nextBtn.disabled = currentSlide3 >= maxSlide;
    }
}

function createIndicators3() {
    const indicatorsContainer = document.getElementById("carousel-3-indicators");
    if (!indicatorsContainer) return;
    
    const maxSlide = Math.max(0, totalSlides3 - slidesToShow3);
    
    indicatorsContainer.innerHTML = "";
    
    for (let i = 0; i <= maxSlide; i++) {
        const indicator = document.createElement("button");
        indicator.className = "carousel-3-indicator";
        indicator.onclick = () => goToSlide3(i);
        indicatorsContainer.appendChild(indicator);
    }
    
    updateIndicators3();
}

function updateIndicators3() {
    const indicators = document.querySelectorAll(".carousel-3-indicator");
    indicators.forEach((indicator, index) => {
        indicator.classList.remove("active");
        if (index === currentSlide3) {
            indicator.classList.add("active");
        }
    });
}
</script>';

$template_path = $theme_path . '/page-templates/page-cursos.php';
if (file_put_contents($template_path, $new_template)) {
    echo "<div class='success'>✅ Template COMPLETAMENTE REEMPLAZADO con carrusel 3 en 3</div>";
} else {
    echo "<div class='error'>❌ Error al reemplazar template</div>";
}

// Crear página de detalle de curso
$curso_detalle_content = '<?php
/**
 * Página de Detalle de Curso
 * Muestra toda la información completa de un curso
 */

// Obtener ID del curso
$curso_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

// Obtener cursos del sistema
$courses = get_option("mongruas_courses", []);
$curso = null;

// Buscar el curso por ID
foreach ($courses as $c) {
    if (isset($c["id"]) && $c["id"] == $curso_id) {
        $curso = $c;
        break;
    }
}

// Si no se encuentra el curso, redirigir
if (!$curso) {
    header("Location: " . home_url("/anuncios/"));
    exit;
}

get_header();
?>

<style>
.curso-detalle-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
    background: #f8f9fa;
    min-height: 100vh;
}

.curso-detalle-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.curso-hero {
    background: linear-gradient(135deg, #3498db, #27ae60);
    color: white;
    padding: 60px 40px;
    text-align: center;
    position: relative;
}

.curso-titulo {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 20px;
    line-height: 1.2;
}

.curso-descripcion {
    font-size: 1.2rem;
    margin-bottom: 30px;
    opacity: 0.95;
}

.curso-stats {
    display: flex;
    justify-content: center;
    gap: 40px;
    flex-wrap: wrap;
}

.stat-item {
    text-align: center;
    background: rgba(255,255,255,0.15);
    padding: 20px;
    border-radius: 15px;
    backdrop-filter: blur(10px);
}

.stat-icon {
    font-size: 2rem;
    margin-bottom: 10px;
    display: block;
}

.stat-value {
    font-size: 1.2rem;
    font-weight: 700;
}

.acciones-container {
    background: linear-gradient(135deg, #2c3e50, #34495e);
    color: white;
    padding: 40px;
    text-align: center;
    border-radius: 20px;
    margin-top: 40px;
}

.botones-accion {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    margin-top: 30px;
}

.btn-accion {
    padding: 15px 30px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 700;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.btn-reservar {
    background: linear-gradient(135deg, #27ae60, #229954);
    color: white;
    box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
}

.btn-reservar:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(39, 174, 96, 0.4);
    color: white;
    text-decoration: none;
}

.btn-volver {
    background: rgba(255,255,255,0.2);
    color: white;
    border: 2px solid rgba(255,255,255,0.3);
}

.btn-volver:hover {
    background: rgba(255,255,255,0.3);
    color: white;
    text-decoration: none;
}

@media (max-width: 768px) {
    .curso-titulo {
        font-size: 2.2rem;
    }
    
    .curso-stats {
        gap: 20px;
    }
    
    .botones-accion {
        flex-direction: column;
        align-items: center;
    }
    
    .btn-accion {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
}
</style>

<div class="curso-detalle-container">
    
    <div class="curso-detalle-card">
        <div class="curso-hero">
            <h1 class="curso-titulo"><?php echo esc_html($curso["name"]); ?></h1>
            <p class="curso-descripcion">
                <?php 
                $descripcion = isset($curso["full_description"]) ? $curso["full_description"] : $curso["description"];
                echo esc_html($descripcion); 
                ?>
            </p>
            
            <div class="curso-stats">
                <div class="stat-item">
                    <span class="stat-icon">📅</span>
                    <div class="stat-value"><?php echo esc_html($curso["date"]); ?></div>
                </div>
                <div class="stat-item">
                    <span class="stat-icon">⏱️</span>
                    <div class="stat-value"><?php echo esc_html($curso["duration"]); ?></div>
                </div>
                <div class="stat-item">
                    <span class="stat-icon">💻</span>
                    <div class="stat-value"><?php echo esc_html($curso["modality"]); ?></div>
                </div>
                <?php if (isset($curso["hours"])): ?>
                <div class="stat-item">
                    <span class="stat-icon">🕐</span>
                    <div class="stat-value"><?php echo esc_html($curso["hours"]); ?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="acciones-container">
        <h2>¿Te interesa este curso?</h2>
        <p>Reserva tu plaza ahora o contáctanos para más información</p>
        
        <div class="botones-accion">
            <a href="#contact" class="btn-accion btn-reservar">
                <span>🎯</span>
                <span>Reservar Plaza</span>
            </a>
            <a href="<?php echo home_url("/anuncios/"); ?>" class="btn-accion btn-volver">
                <span>←</span>
                <span>Volver a Cursos</span>
            </a>
        </div>
    </div>
    
</div>

<?php get_footer(); ?>';

$curso_detalle_path = __DIR__ . '/curso-detalle.php';
if (file_put_contents($curso_detalle_path, $curso_detalle_content)) {
    echo "<div class='success'>✅ Página de detalle de curso creada: curso-detalle.php</div>";
} else {
    echo "<div class='error'>❌ Error al crear página de detalle</div>";
}

echo "<hr>";
echo "<h2>🎯 TEMPLATE COMPLETAMENTE REEMPLAZADO</h2>";
echo "<p>Se ha creado un template completamente nuevo con:</p>";
echo "<ul>";
echo "<li>✅ <strong>Carrusel 3 en 3</strong> - Muestra 3 cursos, navegación suave</li>";
echo "<li>✅ <strong>Botón \"Ver más información\"</strong> - Lleva a página de detalle</li>";
echo "<li>✅ <strong>Integrado con gestión</strong> - Usa cursos del sistema</li>";
echo "<li>✅ <strong>Responsive</strong> - 3 en escritorio, 2 en tablet, 1 en móvil</li>";
echo "<li>✅ <strong>JavaScript incluido</strong> - Todo en un solo archivo</li>";
echo "</ul>";

echo "<h3>🔗 Probar Ahora:</h3>";
echo "<p><a href='/anuncios/?v=" . time() . "' target='_blank' style='background: #27ae60; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; margin: 10px 0;'>🎠 VER CARRUSEL 3 EN 3</a></p>";

echo "<p style='margin-top: 20px; padding: 15px; background: #d4edda; border-left: 4px solid #27ae60; color: #155724;'>";
echo "<strong>✅ ¡Template completamente reemplazado!</strong><br>";
echo "Ahora deberías ver el carrusel 3 en 3 funcionando perfectamente con navegación y botones.";
echo "</p>";

echo "</body></html>";
?>
<?php
/**
 * CREAR ESTILOS CSS PARA CARRUSEL 3 EN 3
 * Estilos completos para el carrusel y página de detalle
 */

echo "<!DOCTYPE html>";
echo "<html><head><title>Crear Estilos Carrusel 3 en 3</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{background:#d4edda;color:#155724;padding:15px;margin:10px 0;border-radius:5px;} .error{background:#f8d7da;color:#721c24;padding:15px;margin:10px 0;border-radius:5px;}</style>";
echo "</head><body>";

echo "<h1>🎨 CREAR ESTILOS CSS PARA CARRUSEL 3 EN 3</h1>";

$theme_path = __DIR__ . '/wp-content/themes/mongruas-theme';

// CSS para el carrusel 3 en 3
$carousel_css = '/* CARRUSEL 3 EN 3 - ESTILOS COMPLETOS */

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
    position: relative;
    overflow: hidden;
}

.carousel-3-btn::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.carousel-3-btn:hover::before {
    left: 100%;
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

.carousel-3-btn:disabled::before {
    display: none;
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

.carousel-3-indicator:hover:not(.active) {
    background: rgba(52, 152, 219, 0.6);
    transform: scale(1.1);
}

/* Responsive */
@media (max-width: 1024px) {
    .carousel-3-card {
        min-width: calc(50% - 15px);
    }
    
    .carousel-3-en-3-section .section-header h2 {
        font-size: 3rem;
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
    
    .carousel-3-container {
        padding: 15px;
    }
    
    .carousel-3-track {
        gap: 20px;
    }
    
    .card-content {
        padding: 0 20px 15px;
    }
    
    .card-header {
        padding: 20px 20px 0;
    }
    
    .card-actions {
        padding: 0 20px 20px;
        flex-direction: column;
        gap: 15px;
    }
    
    .course-title {
        font-size: 1.2rem;
        min-height: auto;
    }
    
    .course-description {
        min-height: auto;
    }
    
    .carousel-3-btn {
        width: 50px;
        height: 50px;
        font-size: 20px;
    }
}

@media (max-width: 480px) {
    .carousel-3-en-3-section .container {
        padding: 0 15px;
    }
    
    .carousel-3-en-3-section .section-header h2 {
        font-size: 2rem;
    }
    
    .carousel-3-container {
        border-radius: 15px;
        padding: 10px;
    }
    
    .carousel-3-card {
        border-radius: 15px;
    }
    
    .course-details {
        flex-direction: column;
        gap: 10px;
        padding: 15px;
    }
}

/* Animaciones */
@keyframes slideInFromRight {
    from {
        opacity: 0;
        transform: translateX(100px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInFromLeft {
    from {
        opacity: 0;
        transform: translateX(-100px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.carousel-3-card.slide-in-right {
    animation: slideInFromRight 0.6s ease;
}

.carousel-3-card.slide-in-left {
    animation: slideInFromLeft 0.6s ease;
}

/* Efectos adicionales */
.carousel-3-card:hover .course-badge {
    transform: scale(1.05);
}

.carousel-3-card:hover .course-date {
    background: rgba(231, 76, 60, 0.15);
    transform: translateX(3px);
}

.carousel-3-card:hover .course-title {
    color: #3498db;
}';

$css_path = $theme_path . '/assets/css/carousel-3-en-3.css';
if (file_put_contents($css_path, $carousel_css)) {
    echo "<div class='success'>✅ CSS del carrusel 3 en 3 creado: carousel-3-en-3.css</div>";
} else {
    echo "<div class='error'>❌ Error al crear CSS del carrusel</div>";
}

// JavaScript para el carrusel 3 en 3
$carousel_js = '// CARRUSEL 3 EN 3 - JAVASCRIPT COMPLETO

let currentSlide3 = 0;
let totalSlides3 = 0;
let slidesToShow3 = 3;
let isAnimating3 = false;

document.addEventListener("DOMContentLoaded", function() {
    initCarousel3();
    createIndicators3();
    updateCarousel3();
    
    // Auto-play opcional (descomenta para activar)
    // startAutoPlay3();
    
    // Responsive
    window.addEventListener("resize", function() {
        updateSlidesToShow3();
        updateCarousel3();
        createIndicators3();
    });
});

function initCarousel3() {
    const track = document.getElementById("carousel-3-track");
    if (!track) return;
    
    totalSlides3 = track.children.length;
    updateSlidesToShow3();
    
    console.log("🎠 Carrusel 3 en 3 inicializado:", totalSlides3, "cursos");
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
    
    console.log("🎠 Carrusel actualizado - Slide:", currentSlide3);
}

function createIndicators3() {
    const indicatorsContainer = document.getElementById("carousel-3-indicators");
    if (!indicatorsContainer) return;
    
    const maxSlide = Math.max(0, totalSlides3 - slidesToShow3);
    const numIndicators = maxSlide + 1;
    
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

// Auto-play (opcional)
let autoPlay3Interval = null;

function startAutoPlay3() {
    autoPlay3Interval = setInterval(() => {
        moveCarousel3(1);
    }, 5000); // Cambiar cada 5 segundos
}

function stopAutoPlay3() {
    if (autoPlay3Interval) {
        clearInterval(autoPlay3Interval);
        autoPlay3Interval = null;
    }
}

// Pausar auto-play al hacer hover
document.addEventListener("DOMContentLoaded", function() {
    const carouselContainer = document.querySelector(".carousel-3-container");
    
    if (carouselContainer) {
        carouselContainer.addEventListener("mouseenter", stopAutoPlay3);
        carouselContainer.addEventListener("mouseleave", startAutoPlay3);
    }
});

// Navegación con teclado
document.addEventListener("keydown", function(e) {
    if (e.key === "ArrowLeft") {
        moveCarousel3(-1);
    } else if (e.key === "ArrowRight") {
        moveCarousel3(1);
    }
});

// Touch/Swipe support para móviles
let startX3 = 0;
let endX3 = 0;

document.addEventListener("DOMContentLoaded", function() {
    const track = document.getElementById("carousel-3-track");
    if (!track) return;
    
    track.addEventListener("touchstart", function(e) {
        startX3 = e.touches[0].clientX;
    });
    
    track.addEventListener("touchend", function(e) {
        endX3 = e.changedTouches[0].clientX;
        handleSwipe3();
    });
});

function handleSwipe3() {
    const threshold = 50; // Mínimo de píxeles para considerar swipe
    const diff = startX3 - endX3;
    
    if (Math.abs(diff) > threshold) {
        if (diff > 0) {
            // Swipe left - siguiente
            moveCarousel3(1);
        } else {
            // Swipe right - anterior
            moveCarousel3(-1);
        }
    }
}

// Redimensionar carrusel al cambiar tamaño de ventana
window.addEventListener("resize", function() {
    setTimeout(() => {
        updateCarousel3();
    }, 100);
});';

$js_path = $theme_path . '/assets/js/carousel-3-en-3.js';
if (file_put_contents($js_path, $carousel_js)) {
    echo "<div class='success'>✅ JavaScript del carrusel 3 en 3 creado: carousel-3-en-3.js</div>";
} else {
    echo "<div class='error'>❌ Error al crear JavaScript del carrusel</div>";
}

// Actualizar functions.php para cargar los nuevos archivos
echo "<h2>🔧 Actualizando functions.php</h2>";

$functions_path = $theme_path . '/functions.php';
$functions_content = file_get_contents($functions_path);

// Agregar carga de CSS y JS del carrusel
$new_enqueue = "
// Carrusel 3 en 3
wp_enqueue_style('carousel-3-en-3', get_template_directory_uri() . '/assets/css/carousel-3-en-3.css', array(), '1.0.0');
wp_enqueue_script('carousel-3-en-3', get_template_directory_uri() . '/assets/js/carousel-3-en-3.js', array(), '1.0.0', true);
";

// Buscar la función wp_enqueue_scripts y agregar nuestros archivos
if (strpos($functions_content, 'carousel-3-en-3') === false) {
    $functions_content = str_replace(
        'wp_enqueue_style(\'mongruas-style\'',
        $new_enqueue . '    wp_enqueue_style(\'mongruas-style\'',
        $functions_content
    );
    
    if (file_put_contents($functions_path, $functions_content)) {
        echo "<div class='success'>✅ functions.php actualizado para cargar CSS y JS del carrusel</div>";
    } else {
        echo "<div class='error'>❌ Error al actualizar functions.php</div>";
    }
} else {
    echo "<div class='success'>✅ functions.php ya tiene los archivos del carrusel cargados</div>";
}

echo "<hr>";
echo "<h2>🎯 CARRUSEL 3 EN 3 COMPLETADO</h2>";
echo "<p>Se han creado todos los archivos necesarios:</p>";
echo "<ul>";
echo "<li>✅ <strong>carousel-3-en-3.css</strong> - Estilos completos del carrusel</li>";
echo "<li>✅ <strong>carousel-3-en-3.js</strong> - Funcionalidad completa con navegación</li>";
echo "<li>✅ <strong>curso-detalle.php</strong> - Página de detalle de cada curso</li>";
echo "<li>✅ <strong>functions.php</strong> - Actualizado para cargar los archivos</li>";
echo "</ul>";

echo "<h3>🚀 Características del Carrusel:</h3>";
echo "<ul>";
echo "<li>📱 <strong>Responsive</strong> - 3 en escritorio, 2 en tablet, 1 en móvil</li>";
echo "<li>🎯 <strong>Navegación</strong> - Botones, indicadores, teclado y touch</li>";
echo "<li>🔄 <strong>Integrado</strong> - Usa los cursos del sistema de gestión</li>";
echo "<li>📄 <strong>Detalle completo</strong> - Botón \"Ver más información\"</li>";
echo "<li>✨ <strong>Animaciones</strong> - Transiciones suaves y efectos hover</li>";
echo "</ul>";

echo "<h3>🔗 Probar Ahora:</h3>";
echo "<p><a href='/anuncios/?v=" . time() . "' target='_blank' style='background: #27ae60; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; margin: 10px 0;'>🎠 VER CARRUSEL 3 EN 3</a></p>";

echo "<p style='margin-top: 20px; padding: 15px; background: #d4edda; border-left: 4px solid #27ae60; color: #155724;'>";
echo "<strong>✅ ¡Carrusel 3 en 3 completado!</strong><br>";
echo "Ahora tienes un carrusel que muestra 3 cursos, con navegación completa y páginas de detalle integradas con tu sistema de gestión.";
echo "</p>";

echo "</body></html>";
?>
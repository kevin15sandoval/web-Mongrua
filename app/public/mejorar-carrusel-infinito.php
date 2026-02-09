<?php
/**
 * Mejorar Carrusel Infinito - Mongruas Formación
 * Convierte el carrusel de próximos cursos en un carrusel infinito y fluido
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🎠 Mejorar Carrusel Infinito</h1>";

// Actualizar el template courses-default.php para incluir carrusel infinito
$template_path = get_template_directory() . '/template-parts/courses-default.php';

if (file_exists($template_path)) {
    $template_content = file_get_contents($template_path);
    
    // Buscar la sección de próximos cursos y agregar carrusel infinito
    $carrusel_js = '
<script>
// Carrusel Infinito Mejorado para Próximos Cursos
document.addEventListener("DOMContentLoaded", function() {
    const coursesGrid = document.querySelector(".upcoming-courses-grid");
    const courseCards = document.querySelectorAll(".upcoming-course-card");
    
    if (!coursesGrid || courseCards.length <= 3) {
        return; // No crear carrusel si hay 3 o menos cursos
    }
    
    // Convertir grid en carrusel
    coursesGrid.style.display = "flex";
    coursesGrid.style.overflow = "hidden";
    coursesGrid.style.position = "relative";
    coursesGrid.style.gap = "25px";
    
    // Crear contenedor de carrusel
    const carouselContainer = document.createElement("div");
    carouselContainer.className = "carousel-container-infinite";
    carouselContainer.style.position = "relative";
    carouselContainer.style.overflow = "hidden";
    carouselContainer.style.borderRadius = "20px";
    
    // Crear track del carrusel
    const carouselTrack = document.createElement("div");
    carouselTrack.className = "carousel-track-infinite";
    carouselTrack.style.display = "flex";
    carouselTrack.style.gap = "25px";
    carouselTrack.style.transition = "transform 0.5s cubic-bezier(0.4, 0, 0.2, 1)";
    carouselTrack.style.willChange = "transform";
    
    // Clonar cursos para efecto infinito
    const originalCards = Array.from(courseCards);
    const clonedCards = originalCards.map(card => card.cloneNode(true));
    
    // Agregar cursos originales y clonados al track
    originalCards.forEach(card => {
        card.style.minWidth = "300px";
        card.style.flexShrink = "0";
        carouselTrack.appendChild(card);
    });
    
    clonedCards.forEach(card => {
        card.style.minWidth = "300px";
        card.style.flexShrink = "0";
        carouselTrack.appendChild(card);
    });
    
    // Reemplazar grid con carrusel
    coursesGrid.parentNode.replaceChild(carouselContainer, coursesGrid);
    carouselContainer.appendChild(carouselTrack);
    
    // Variables del carrusel
    let currentIndex = 0;
    let isTransitioning = false;
    const totalCards = originalCards.length;
    const cardWidth = 325; // 300px + 25px gap
    let autoPlayInterval;
    
    // Función para mover el carrusel
    function moveCarousel(index, smooth = true) {
        if (isTransitioning) return;
        
        if (smooth) {
            carouselTrack.style.transition = "transform 0.5s cubic-bezier(0.4, 0, 0.2, 1)";
        } else {
            carouselTrack.style.transition = "none";
        }
        
        const translateX = -index * cardWidth;
        carouselTrack.style.transform = `translateX(${translateX}px)`;
        
        if (smooth) {
            isTransitioning = true;
            setTimeout(() => {
                isTransitioning = false;
                
                // Efecto infinito: saltar al inicio cuando llegamos al final
                if (index >= totalCards) {
                    currentIndex = 0;
                    moveCarousel(0, false);
                } else if (index < 0) {
                    currentIndex = totalCards - 1;
                    moveCarousel(totalCards - 1, false);
                }
            }, 500);
        }
    }
    
    // Función para ir al siguiente curso
    function nextCourse() {
        currentIndex++;
        moveCarousel(currentIndex);
    }
    
    // Función para ir al curso anterior
    function prevCourse() {
        currentIndex--;
        moveCarousel(currentIndex);
    }
    
    // Crear controles del carrusel
    const controlsContainer = document.createElement("div");
    controlsContainer.className = "carousel-controls-infinite";
    controlsContainer.style.display = "flex";
    controlsContainer.style.justifyContent = "center";
    controlsContainer.style.gap = "20px";
    controlsContainer.style.marginTop = "30px";
    
    const prevButton = document.createElement("button");
    prevButton.innerHTML = "←";
    prevButton.className = "carousel-btn-infinite carousel-prev";
    prevButton.onclick = prevCourse;
    
    const nextButton = document.createElement("button");
    nextButton.innerHTML = "→";
    nextButton.className = "carousel-btn-infinite carousel-next";
    nextButton.onclick = nextCourse;
    
    controlsContainer.appendChild(prevButton);
    controlsContainer.appendChild(nextButton);
    carouselContainer.parentNode.insertBefore(controlsContainer, carouselContainer.nextSibling);
    
    // Crear indicadores
    const indicatorsContainer = document.createElement("div");
    indicatorsContainer.className = "carousel-indicators-infinite";
    indicatorsContainer.style.display = "flex";
    indicatorsContainer.style.justifyContent = "center";
    indicatorsContainer.style.gap = "10px";
    indicatorsContainer.style.marginTop = "20px";
    
    for (let i = 0; i < totalCards; i++) {
        const indicator = document.createElement("button");
        indicator.className = "carousel-indicator-infinite";
        if (i === 0) indicator.classList.add("active");
        indicator.onclick = () => {
            currentIndex = i;
            moveCarousel(i);
            updateIndicators();
        };
        indicatorsContainer.appendChild(indicator);
    }
    
    controlsContainer.parentNode.insertBefore(indicatorsContainer, controlsContainer.nextSibling);
    
    // Función para actualizar indicadores
    function updateIndicators() {
        const indicators = document.querySelectorAll(".carousel-indicator-infinite");
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle("active", index === currentIndex % totalCards);
        });
    }
    
    // Auto-play
    function startAutoPlay() {
        autoPlayInterval = setInterval(() => {
            nextCourse();
            updateIndicators();
        }, 4000); // Cambiar cada 4 segundos
    }
    
    function stopAutoPlay() {
        clearInterval(autoPlayInterval);
    }
    
    // Pausar auto-play al hacer hover
    carouselContainer.addEventListener("mouseenter", stopAutoPlay);
    carouselContainer.addEventListener("mouseleave", startAutoPlay);
    
    // Iniciar auto-play
    startAutoPlay();
    
    // Soporte para touch/swipe en móviles
    let startX = 0;
    let currentX = 0;
    let isDragging = false;
    
    carouselContainer.addEventListener("touchstart", (e) => {
        startX = e.touches[0].clientX;
        isDragging = true;
        stopAutoPlay();
    });
    
    carouselContainer.addEventListener("touchmove", (e) => {
        if (!isDragging) return;
        currentX = e.touches[0].clientX;
        const diffX = startX - currentX;
        
        // Mostrar preview del movimiento
        const currentTransform = -currentIndex * cardWidth;
        carouselTrack.style.transition = "none";
        carouselTrack.style.transform = `translateX(${currentTransform - diffX}px)`;
    });
    
    carouselContainer.addEventListener("touchend", (e) => {
        if (!isDragging) return;
        isDragging = false;
        
        const diffX = startX - currentX;
        const threshold = 50;
        
        if (Math.abs(diffX) > threshold) {
            if (diffX > 0) {
                nextCourse();
            } else {
                prevCourse();
            }
            updateIndicators();
        } else {
            // Volver a la posición original
            moveCarousel(currentIndex);
        }
        
        startAutoPlay();
    });
    
    // Inicializar posición
    moveCarousel(0, false);
});
</script>

<style>
/* Estilos para Carrusel Infinito */
.carousel-container-infinite {
    position: relative;
    overflow: hidden;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.carousel-track-infinite {
    display: flex;
    gap: 25px;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    will-change: transform;
}

.carousel-btn-infinite {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
    border: none;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 20px;
    font-weight: 700;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.carousel-btn-infinite::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.carousel-btn-infinite:hover::before {
    left: 100%;
}

.carousel-btn-infinite:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 6px 20px rgba(0, 102, 204, 0.4);
    background: linear-gradient(135deg, #0052a3, #003d7a);
}

.carousel-btn-infinite:active {
    transform: translateY(-1px) scale(0.95);
}

.carousel-indicator-infinite {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: none;
    background: rgba(0, 102, 204, 0.3);
    cursor: pointer;
    transition: all 0.3s ease;
}

.carousel-indicator-infinite.active {
    background: #0066cc;
    transform: scale(1.2);
    box-shadow: 0 2px 8px rgba(0, 102, 204, 0.4);
}

.carousel-indicator-infinite:hover:not(.active) {
    background: rgba(0, 102, 204, 0.6);
    transform: scale(1.1);
}

/* Animación de entrada para las tarjetas */
.upcoming-course-card {
    animation: slideInUp 0.6s ease-out;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Efecto hover mejorado para las tarjetas */
.upcoming-course-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    border-color: #0066cc;
}

/* Responsive para carrusel infinito */
@media (max-width: 768px) {
    .carousel-track-infinite {
        gap: 15px;
    }
    
    .upcoming-course-card {
        min-width: 280px !important;
    }
    
    .carousel-btn-infinite {
        width: 45px;
        height: 45px;
        font-size: 18px;
    }
    
    .carousel-controls-infinite {
        gap: 15px !important;
        margin-top: 25px !important;
    }
}

@media (max-width: 480px) {
    .upcoming-course-card {
        min-width: 260px !important;
    }
    
    .carousel-track-infinite {
        gap: 10px;
    }
}
</style>';
    
    // Buscar el final del archivo y agregar el JavaScript y CSS
    if (strpos($template_content, 'carousel-container-infinite') === false) {
        $template_content = str_replace('</style>', $carrusel_js . '</style>', $template_content);
        
        // Guardar el archivo actualizado
        file_put_contents($template_path, $template_content);
        
        echo "<div class='success-message'>";
        echo "✅ <strong>¡Carrusel infinito implementado correctamente!</strong><br>";
        echo "El carrusel de próximos cursos ahora es infinito y más fluido.";
        echo "</div>";
    } else {
        echo "<div class='info-message'>";
        echo "ℹ️ <strong>El carrusel infinito ya está implementado.</strong>";
        echo "</div>";
    }
} else {
    echo "<div class='error-message'>";
    echo "❌ <strong>Error:</strong> No se encontró el archivo template courses-default.php";
    echo "</div>";
}

// Información sobre las mejoras
echo "<h2>🎯 Mejoras Implementadas</h2>";
echo "<div class='features-list'>";
echo "<div class='feature-item'>";
echo "<div class='feature-icon'>🔄</div>";
echo "<div class='feature-content'>";
echo "<h4>Carrusel Infinito</h4>";
echo "<p>Cuando llegue al último curso, automáticamente vuelve al primero sin cortes</p>";
echo "</div>";
echo "</div>";

echo "<div class='feature-item'>";
echo "<div class='feature-icon'>⚡</div>";
echo "<div class='feature-content'>";
echo "<h4>Transiciones Suaves</h4>";
echo "<p>Animaciones fluidas con cubic-bezier para un movimiento natural</p>";
echo "</div>";
echo "</div>";

echo "<div class='feature-item'>";
echo "<div class='feature-icon'>🎮</div>";
echo "<div class='feature-content'>";
echo "<h4>Auto-play Inteligente</h4>";
echo "<p>Cambia automáticamente cada 4 segundos, se pausa al hacer hover</p>";
echo "</div>";
echo "</div>";

echo "<div class='feature-item'>";
echo "<div class='feature-icon'>📱</div>";
echo "<div class='feature-content'>";
echo "<h4>Soporte Touch</h4>";
echo "<p>Desliza con el dedo en móviles y tablets para navegar</p>";
echo "</div>";
echo "</div>";

echo "<div class='feature-item'>";
echo "<div class='feature-icon'>🎯</div>";
echo "<div class='feature-content'>";
echo "<h4>Indicadores Activos</h4>";
echo "<p>Puntos que muestran la posición actual y permiten navegación directa</p>";
echo "</div>";
echo "</div>";

echo "<div class='feature-item'>";
echo "<div class='feature-icon'>🎨</div>";
echo "<div class='feature-content'>";
echo "<h4>Efectos Visuales</h4>";
echo "<p>Botones con gradientes, efectos hover y animaciones de entrada</p>";
echo "</div>";
echo "</div>";
echo "</div>";

// Instrucciones de uso
echo "<h2>📋 Cómo Funciona</h2>";
echo "<div class='instructions'>";
echo "<div class='instruction-step'>";
echo "<div class='step-number'>1</div>";
echo "<div class='step-content'>";
echo "<h4>Detección Automática</h4>";
echo "<p>Si hay más de 3 cursos, se activa automáticamente el carrusel infinito</p>";
echo "</div>";
echo "</div>";

echo "<div class='instruction-step'>";
echo "<div class='step-number'>2</div>";
echo "<div class='step-content'>";
echo "<h4>Navegación</h4>";
echo "<p>Usa las flechas ← → o los puntos indicadores para navegar manualmente</p>";
echo "</div>";
echo "</div>";

echo "<div class='instruction-step'>";
echo "<div class='step-number'>3</div>";
echo "<div class='step-content'>";
echo "<h4>Auto-play</h4>";
echo "<p>El carrusel cambia automáticamente cada 4 segundos</p>";
echo "</div>";
echo "</div>";

echo "<div class='instruction-step'>";
echo "<div class='step-number'>4</div>";
echo "<div class='step-content'>";
echo "<h4>Efecto Infinito</h4>";
echo "<p>Al llegar al final, vuelve suavemente al principio sin cortes</p>";
echo "</div>";
echo "</div>";
echo "</div>";

// Enlaces de prueba
echo "<h2>🌐 Probar el Carrusel</h2>";
echo "<div class='test-links'>";
echo "<a href='" . home_url('/') . "' class='test-link primary' target='_blank'>";
echo "<div class='link-icon'>🏠</div>";
echo "<div class='link-text'>";
echo "<strong>Página Principal</strong>";
echo "<small>Ver carrusel infinito en acción</small>";
echo "</div>";
echo "</a>";

echo "<a href='" . home_url('/gestionar-cursos-dinamico.php') . "' class='test-link secondary' target='_blank'>";
echo "<div class='link-icon'>🎓</div>";
echo "<div class='link-text'>";
echo "<strong>Agregar Más Cursos</strong>";
echo "<small>Para probar el carrusel con más elementos</small>";
echo "</div>";
echo "</a>";
echo "</div>";

echo "<div class='final-note'>";
echo "<div class='note-icon'>💡</div>";
echo "<div class='note-content'>";
echo "<h3>¡Carrusel Infinito Activado!</h3>";
echo "<p>Ahora cuando llegues al último curso con las flechas, automáticamente volverá al primero de forma suave. El carrusel también funciona con gestos táctiles en móviles.</p>";
echo "</div>";
echo "</div>";
?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    line-height: 1.6;
}

h1 {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
    text-align: center;
    padding: 30px;
    border-radius: 16px;
    margin-bottom: 30px;
    box-shadow: 0 8px 25px rgba(0, 102, 204, 0.3);
}

h2 {
    color: #495057;
    border-left: 4px solid #0066cc;
    padding-left: 15px;
    margin-top: 30px;
    margin-bottom: 20px;
}

.success-message {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    color: #155724;
    padding: 20px;
    border-radius: 12px;
    margin: 20px 0;
    border: 2px solid #28a745;
    font-weight: 600;
}

.info-message {
    background: linear-gradient(135deg, #e3f2fd, #bbdefb);
    color: #1565c0;
    padding: 20px;
    border-radius: 12px;
    margin: 20px 0;
    border: 2px solid #2196f3;
    font-weight: 600;
}

.error-message {
    background: linear-gradient(135deg, #f8d7da, #f5c6cb);
    color: #721c24;
    padding: 20px;
    border-radius: 12px;
    margin: 20px 0;
    border: 2px solid #dc3545;
    font-weight: 600;
}

.features-list {
    display: grid;
    gap: 20px;
    margin: 20px 0;
}

.feature-item {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: flex-start;
    gap: 20px;
}

.feature-icon {
    font-size: 36px;
    flex-shrink: 0;
}

.feature-content h4 {
    margin: 0 0 8px 0;
    color: #495057;
    font-size: 18px;
}

.feature-content p {
    margin: 0;
    color: #6c757d;
    font-size: 14px;
}

.instructions {
    display: grid;
    gap: 20px;
    margin: 20px 0;
}

.instruction-step {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: flex-start;
    gap: 20px;
}

.step-number {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 18px;
    flex-shrink: 0;
}

.step-content h4 {
    margin: 0 0 8px 0;
    color: #495057;
    font-size: 18px;
}

.step-content p {
    margin: 0;
    color: #6c757d;
    font-size: 14px;
}

.test-links {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin: 20px 0;
}

.test-link {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 25px;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.test-link.primary {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
}

.test-link.secondary {
    background: linear-gradient(135deg, #6c757d, #5a6268);
    color: white;
}

.test-link:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

.link-icon {
    font-size: 36px;
    flex-shrink: 0;
}

.link-text strong {
    display: block;
    font-size: 18px;
    margin-bottom: 5px;
}

.link-text small {
    font-size: 14px;
    opacity: 0.9;
}

.final-note {
    background: linear-gradient(135deg, #fff3cd, #ffeaa7);
    border: 2px solid #ffc107;
    border-radius: 16px;
    padding: 30px;
    margin: 30px 0;
    display: flex;
    align-items: center;
    gap: 20px;
}

.note-icon {
    font-size: 48px;
    flex-shrink: 0;
}

.note-content h3 {
    margin: 0 0 10px 0;
    color: #856404;
    font-size: 24px;
}

.note-content p {
    margin: 0;
    color: #856404;
    font-size: 16px;
}

@media (max-width: 768px) {
    .feature-item, .instruction-step {
        flex-direction: column;
        text-align: center;
    }
    
    .test-links {
        grid-template-columns: 1fr;
    }
    
    .final-note {
        flex-direction: column;
        text-align: center;
    }
}
</style>
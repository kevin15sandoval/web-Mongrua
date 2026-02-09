<?php
/**
 * Test Carrusel de 3 en 3 - Próximos Cursos
 * Verificar que el carrusel muestre 3 cursos por página
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🎠 Test Carrusel de 3 en 3</h1>";

// Obtener cursos actuales
$cursos_dinamicos = get_option('mongruas_courses', []);

echo "<h2>📊 Configuración del Carrusel:</h2>";
if (!empty($cursos_dinamicos)) {
    $total_cursos = count($cursos_dinamicos);
    $paginas = ceil($total_cursos / 3);
    
    echo "<div style='background: #d4edda; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
    echo "<strong>✅ CARRUSEL CONFIGURADO:</strong><br>";
    echo "• Total de cursos: " . $total_cursos . "<br>";
    echo "• Cursos por página: 3<br>";
    echo "• Total de páginas: " . $paginas . "<br>";
    echo "• Navegación: De 3 en 3 cursos<br>";
    echo "• Auto-play: Cada 5 segundos<br>";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
    echo "<strong>❌ NO HAY CURSOS - Se mostrarán los de ejemplo</strong>";
    echo "</div>";
}

// Agregar algunos cursos de prueba si no hay suficientes
if (count($cursos_dinamicos) < 6) {
    echo "<h2>🔧 Agregando Cursos de Prueba:</h2>";
    
    $cursos_prueba = [
        ['name' => 'Curso de Prueba 1', 'date' => 'Abril 2025', 'modality' => 'Presencial', 'duration' => '20 plazas', 'description' => 'Curso de prueba para verificar el carrusel.', 'image' => ''],
        ['name' => 'Curso de Prueba 2', 'date' => 'Mayo 2025', 'modality' => 'Online', 'duration' => '25 plazas', 'description' => 'Segundo curso de prueba.', 'image' => ''],
        ['name' => 'Curso de Prueba 3', 'date' => 'Junio 2025', 'modality' => 'Semipresencial', 'duration' => '15 plazas', 'description' => 'Tercer curso de prueba.', 'image' => ''],
        ['name' => 'Curso de Prueba 4', 'date' => 'Julio 2025', 'modality' => 'Presencial', 'duration' => '18 plazas', 'description' => 'Cuarto curso de prueba.', 'image' => ''],
        ['name' => 'Curso de Prueba 5', 'date' => 'Agosto 2025', 'modality' => 'Online', 'duration' => '30 plazas', 'description' => 'Quinto curso de prueba.', 'image' => ''],
        ['name' => 'Curso de Prueba 6', 'date' => 'Septiembre 2025', 'modality' => 'Presencial', 'duration' => '12 plazas', 'description' => 'Sexto curso de prueba.', 'image' => ''],
        ['name' => 'Curso de Prueba 7', 'date' => 'Octubre 2025', 'modality' => 'Semipresencial', 'duration' => '22 plazas', 'description' => 'Séptimo curso de prueba.', 'image' => '']
    ];
    
    // Combinar cursos existentes con cursos de prueba
    $todos_cursos = array_merge($cursos_dinamicos, $cursos_prueba);
    $todos_cursos = array_slice($todos_cursos, 0, 9); // Máximo 9 cursos para 3 páginas
    
    echo "<div style='background: #d1ecf1; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
    echo "<strong>📝 CURSOS PARA LA PRUEBA:</strong><br>";
    echo "• Total: " . count($todos_cursos) . " cursos<br>";
    echo "• Páginas: " . ceil(count($todos_cursos) / 3) . " páginas de 3 cursos cada una<br>";
    echo "</div>";
} else {
    $todos_cursos = $cursos_dinamicos;
}

echo "<h2>🎨 Vista Previa del Carrusel:</h2>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Carrusel 3 en 3</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        }

        h1, h2 {
            color: #1a1a1a;
            text-align: center;
        }

        h1 {
            background: linear-gradient(135deg, #0066cc, #0052a3);
            color: white;
            padding: 30px;
            border-radius: 16px;
            margin-bottom: 30px;
        }

        /* Próximos Cursos */
        .upcoming-courses-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 20px;
            padding: 50px 40px;
            margin: 40px 0;
            border: 2px solid #e0e0e0;
        }

        .upcoming-courses-section .section-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .upcoming-courses-section h2 {
            font-size: 42px;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 10px;
        }

        .upcoming-courses-section p {
            font-size: 22px;
            color: #495057;
        }

        .upcoming-courses-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Estilos para Carrusel de 3 en 3 */
        .carousel-container-tres {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .carousel-track-tres {
            display: flex;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform;
        }

        .carousel-page {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            min-width: 100%;
            flex-shrink: 0;
        }

        .carousel-btn-tres {
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

        .carousel-btn-tres:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 102, 204, 0.4);
            background: linear-gradient(135deg, #0052a3, #003d7a);
        }

        .carousel-indicator-tres {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: none;
            background: rgba(0, 102, 204, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .carousel-indicator-tres.active {
            background: #0066cc;
            transform: scale(1.2);
            box-shadow: 0 2px 8px rgba(0, 102, 204, 0.4);
        }

        .upcoming-course-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            border: 2px solid #e8e8e8;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            animation: slideInUp 0.6s ease-out;
        }

        .upcoming-course-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #28a745, #20c997);
        }

        .upcoming-course-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 12px 30px rgba(0,0,0,0.15);
            border-color: #0066cc;
        }

        .course-date {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 14px;
            font-weight: 700;
            display: inline-block;
            margin-bottom: 15px;
        }

        .upcoming-course-card h3 {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .course-description {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
            margin: 10px 0;
            font-style: italic;
        }

        .course-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .modalidad {
            background: #e9ecef;
            color: #495057;
            padding: 4px 12px;
            border-radius: 12px;
            font-weight: 600;
        }

        .plazas {
            background: #fff3cd;
            color: #856404;
            padding: 4px 12px;
            border-radius: 12px;
            font-weight: 600;
        }

        .course-buttons {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 15px;
            align-items: center;
        }

        .btn-ver-mas, .btn-reservar {
            display: inline-block;
            color: white;
            padding: 10px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            width: 160px;
            text-align: center;
        }

        .btn-ver-mas {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
        }

        .btn-reservar {
            background: linear-gradient(135deg, #059669, #10b981);
        }

        .btn-ver-mas:hover, .btn-reservar:hover {
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
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

        /* Responsive */
        @media (max-width: 768px) {
            .carousel-page {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .course-details {
                flex-direction: column;
                gap: 10px;
                align-items: center;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .carousel-page {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
        }

        .info-box {
            background: #e2e3e5;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="info-box">
    <strong>🎠 CARRUSEL DE 3 EN 3:</strong><br>
    • Desktop: 3 cursos por página<br>
    • Tablet: 2 cursos por página<br>
    • Móvil: 1 curso por página<br>
    • Navegación con botones y indicadores<br>
    • Auto-play cada 5 segundos<br>
    • Soporte touch/swipe<br>
</div>

<!-- Próximos Cursos -->
<div class="upcoming-courses-section">
    <div class="section-header">
        <h2>Próximos Cursos</h2>
        <p>Carrusel de 3 en 3 - ¡Navega entre las páginas!</p>
    </div>
    
    <div class="upcoming-courses-grid">
        <?php
        foreach ($todos_cursos as $index => $curso):
        ?>
            <div class="upcoming-course-card">
                <div class="course-date">
                    <span class="date-text"><?php echo !empty($curso['date']) ? esc_html($curso['date']) : 'Próximamente'; ?></span>
                </div>
                <h3><?php echo esc_html($curso['name']); ?></h3>
                
                <?php if (!empty($curso['description'])): ?>
                    <p class="course-description"><?php echo esc_html($curso['description']); ?></p>
                <?php endif; ?>
                
                <div class="course-details">
                    <span class="modalidad"><?php echo !empty($curso['modality']) ? esc_html($curso['modality']) : 'Presencial'; ?></span>
                    <span class="plazas"><?php echo !empty($curso['duration']) ? esc_html($curso['duration']) : 'Plazas limitadas'; ?></span>
                </div>
                <div class="course-buttons">
                    <a href="#" class="btn-ver-mas">Ver Más Info</a>
                    <a href="#" class="btn-reservar">Reservar Plaza</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="info-box">
    <strong>✅ FUNCIONAMIENTO:</strong><br>
    • Página 1: Cursos 1, 2, 3<br>
    • Página 2: Cursos 4, 5, 6<br>
    • Página 3: Cursos 7, 8, 9<br>
    • Navegación automática cada 5 segundos<br>
    • Controles manuales con botones ← →<br>
    • Indicadores de página en la parte inferior<br><br>
    
    <a href="/" style="color: #0066cc; font-weight: 600;">🏠 Ver Página Principal</a> | 
    <a href="/gestionar-cursos-dinamico.php" style="color: #0066cc; font-weight: 600;">🎛️ Panel de Gestión</a>
</div>

<script>
// Carrusel de 3 en 3 - Próximos Cursos
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
    carouselContainer.className = "carousel-container-tres";
    carouselContainer.style.position = "relative";
    carouselContainer.style.overflow = "hidden";
    carouselContainer.style.borderRadius = "20px";
    
    // Crear track del carrusel
    const carouselTrack = document.createElement("div");
    carouselTrack.className = "carousel-track-tres";
    carouselTrack.style.display = "flex";
    carouselTrack.style.gap = "25px";
    carouselTrack.style.transition = "transform 0.5s cubic-bezier(0.4, 0, 0.2, 1)";
    carouselTrack.style.willChange = "transform";
    
    // Organizar cursos en grupos de 3
    const originalCards = Array.from(courseCards);
    const totalCards = originalCards.length;
    const cardsPerPage = 3;
    const totalPages = Math.ceil(totalCards / cardsPerPage);
    
    // Crear páginas de 3 cursos cada una
    for (let page = 0; page < totalPages; page++) {
        const pageContainer = document.createElement("div");
        pageContainer.className = "carousel-page";
        pageContainer.style.display = "grid";
        pageContainer.style.gridTemplateColumns = "repeat(3, 1fr)";
        pageContainer.style.gap = "25px";
        pageContainer.style.minWidth = "100%";
        pageContainer.style.flexShrink = "0";
        
        // Agregar hasta 3 cursos por página
        for (let i = 0; i < cardsPerPage; i++) {
            const cardIndex = page * cardsPerPage + i;
            if (cardIndex < totalCards) {
                const card = originalCards[cardIndex].cloneNode(true);
                card.style.minWidth = "auto";
                card.style.width = "100%";
                pageContainer.appendChild(card);
            }
        }
        
        carouselTrack.appendChild(pageContainer);
    }
    
    // Reemplazar grid con carrusel
    coursesGrid.parentNode.replaceChild(carouselContainer, coursesGrid);
    carouselContainer.appendChild(carouselTrack);
    
    // Variables del carrusel
    let currentPage = 0;
    let isTransitioning = false;
    let autoPlayInterval;
    
    // Función para mover el carrusel
    function moveCarousel(pageIndex, smooth = true) {
        if (isTransitioning) return;
        
        if (smooth) {
            carouselTrack.style.transition = "transform 0.5s cubic-bezier(0.4, 0, 0.2, 1)";
        } else {
            carouselTrack.style.transition = "none";
        }
        
        const translateX = -pageIndex * 100;
        carouselTrack.style.transform = `translateX(${translateX}%)`;
        
        if (smooth) {
            isTransitioning = true;
            setTimeout(() => {
                isTransitioning = false;
            }, 500);
        }
        
        updateIndicators();
    }
    
    // Función para ir a la siguiente página
    function nextPage() {
        currentPage = (currentPage + 1) % totalPages;
        moveCarousel(currentPage);
    }
    
    // Función para ir a la página anterior
    function prevPage() {
        currentPage = (currentPage - 1 + totalPages) % totalPages;
        moveCarousel(currentPage);
    }
    
    // Crear controles del carrusel
    const controlsContainer = document.createElement("div");
    controlsContainer.className = "carousel-controls-tres";
    controlsContainer.style.display = "flex";
    controlsContainer.style.justifyContent = "center";
    controlsContainer.style.gap = "20px";
    controlsContainer.style.marginTop = "30px";
    
    const prevButton = document.createElement("button");
    prevButton.innerHTML = "←";
    prevButton.className = "carousel-btn-tres carousel-prev";
    prevButton.onclick = prevPage;
    
    const nextButton = document.createElement("button");
    nextButton.innerHTML = "→";
    nextButton.className = "carousel-btn-tres carousel-next";
    nextButton.onclick = nextPage;
    
    controlsContainer.appendChild(prevButton);
    controlsContainer.appendChild(nextButton);
    carouselContainer.parentNode.insertBefore(controlsContainer, carouselContainer.nextSibling);
    
    // Crear indicadores
    const indicatorsContainer = document.createElement("div");
    indicatorsContainer.className = "carousel-indicators-tres";
    indicatorsContainer.style.display = "flex";
    indicatorsContainer.style.justifyContent = "center";
    indicatorsContainer.style.gap = "10px";
    indicatorsContainer.style.marginTop = "20px";
    
    for (let i = 0; i < totalPages; i++) {
        const indicator = document.createElement("button");
        indicator.className = "carousel-indicator-tres";
        if (i === 0) indicator.classList.add("active");
        indicator.onclick = () => {
            currentPage = i;
            moveCarousel(i);
        };
        indicatorsContainer.appendChild(indicator);
    }
    
    controlsContainer.parentNode.insertBefore(indicatorsContainer, controlsContainer.nextSibling);
    
    // Función para actualizar indicadores
    function updateIndicators() {
        const indicators = document.querySelectorAll(".carousel-indicator-tres");
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle("active", index === currentPage);
        });
    }
    
    // Auto-play
    function startAutoPlay() {
        autoPlayInterval = setInterval(() => {
            nextPage();
        }, 5000); // Cambiar cada 5 segundos
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
        const currentTransform = -currentPage * 100;
        const movePercent = (diffX / carouselContainer.offsetWidth) * 100;
        carouselTrack.style.transition = "none";
        carouselTrack.style.transform = `translateX(${currentTransform - movePercent}%)`;
    });
    
    carouselContainer.addEventListener("touchend", (e) => {
        if (!isDragging) return;
        isDragging = false;
        
        const diffX = startX - currentX;
        const threshold = 50;
        
        if (Math.abs(diffX) > threshold) {
            if (diffX > 0) {
                nextPage();
            } else {
                prevPage();
            }
        } else {
            // Volver a la posición original
            moveCarousel(currentPage);
        }
        
        startAutoPlay();
    });
    
    // Inicializar posición
    moveCarousel(0, false);
});
</script>

</body>
</html>
<?php
/**
 * Carrusel Perfecto de 3 Columnas - Próximos Cursos
 * Muestra exactamente 3 cursos por página como la primera foto
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🎠 Carrusel Perfecto de 3 Columnas</h1>";

// Obtener cursos actuales
$cursos_dinamicos = get_option('mongruas_courses', []);

// Si no hay suficientes cursos, agregar algunos de ejemplo
$cursos_ejemplo = [
    ['name' => 'Montaje y Mantenimiento de Instalaciones Eléctricas', 'date' => 'Enero 2025', 'modality' => 'Presencial', 'duration' => '15 plazas', 'description' => 'Curso completo de instalaciones eléctricas de baja tensión con certificado oficial.', 'image' => ''],
    ['name' => 'Sistemas Domóticos e Inmóticos', 'date' => 'Febrero 2025', 'modality' => 'Presencial', 'duration' => '12 plazas', 'description' => 'Especialización en automatización de edificios y sistemas inteligentes.', 'image' => ''],
    ['name' => 'Control de Plagas', 'date' => 'Marzo 2025', 'modality' => 'Presencial', 'duration' => '10 plazas', 'description' => 'Formación profesional en control y prevención de plagas urbanas.', 'image' => ''],
    ['name' => 'Energías Renovables', 'date' => 'Abril 2025', 'modality' => 'Presencial', 'duration' => '20 plazas', 'description' => 'Instalación y mantenimiento de sistemas de energía solar y eólica.', 'image' => ''],
    ['name' => 'Prevención de Riesgos Laborales', 'date' => 'Mayo 2025', 'modality' => 'Online', 'duration' => '25 plazas', 'description' => 'Formación completa en seguridad y salud laboral.', 'image' => ''],
    ['name' => 'Soldadura Industrial', 'date' => 'Junio 2025', 'modality' => 'Presencial', 'duration' => '8 plazas', 'description' => 'Técnicas avanzadas de soldadura para la industria.', 'image' => ''],
    ['name' => 'Climatización y Refrigeración', 'date' => 'Julio 2025', 'modality' => 'Presencial', 'duration' => '14 plazas', 'description' => 'Instalación y mantenimiento de sistemas de climatización.', 'image' => ''],
    ['name' => 'Automatización Industrial', 'date' => 'Agosto 2025', 'modality' => 'Semipresencial', 'duration' => '16 plazas', 'description' => 'Programación de PLCs y sistemas automatizados.', 'image' => ''],
    ['name' => 'Gestión de Residuos', 'date' => 'Septiembre 2025', 'modality' => 'Online', 'duration' => '30 plazas', 'description' => 'Tratamiento y gestión sostenible de residuos.', 'image' => '']
];

// Combinar cursos existentes con ejemplos
$todos_cursos = array_merge($cursos_dinamicos, $cursos_ejemplo);
$todos_cursos = array_slice($todos_cursos, 0, 9); // Máximo 9 cursos para 3 páginas perfectas

$total_cursos = count($todos_cursos);
$paginas = ceil($total_cursos / 3);

echo "<div style='background: #d4edda; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
echo "<strong>✅ CARRUSEL CONFIGURADO PERFECTAMENTE:</strong><br>";
echo "• Total de cursos: " . $total_cursos . "<br>";
echo "• Cursos por página: 3 (exactamente como la primera foto)<br>";
echo "• Total de páginas: " . $paginas . "<br>";
echo "• Navegación: De 3 en 3 cursos<br>";
echo "• Auto-play: Cada 6 segundos<br>";
echo "• Diseño: Igual que la primera foto que funciona<br>";
echo "</div>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrusel Perfecto 3 Columnas</title>
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

        /* Próximos Cursos - Carrusel Perfecto */
        .upcoming-courses-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 20px;
            padding: 50px 40px;
            margin: 40px 0;
            border: 2px solid #e0e0e0;
            position: relative;
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

        /* Contenedor del Carrusel */
        .carousel-container {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .carousel-track {
            display: flex;
            transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            will-change: transform;
        }

        .carousel-page {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            min-width: 100%;
            flex-shrink: 0;
            padding: 0 10px;
        }

        /* Tarjetas de Cursos */
        .upcoming-course-card {
            background: white;
            border-radius: 16px;
            padding: 25px 20px;
            text-align: center;
            border: 2px solid #e8e8e8;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            height: auto;
            min-height: 380px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
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
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            border-color: #0066cc;
        }

        .course-image-container {
            margin: -25px -20px 20px -20px;
            height: 160px;
            overflow: hidden;
            border-radius: 16px 16px 0 0;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        }

        .course-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .upcoming-course-card:hover .course-image {
            transform: scale(1.1);
        }

        .course-date {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 700;
            display: inline-block;
            margin-bottom: 15px;
            box-shadow: 0 3px 10px rgba(40, 167, 69, 0.3);
        }

        .upcoming-course-card h3 {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 15px;
            line-height: 1.4;
            min-height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .course-description {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
            margin: 15px 0;
            font-style: italic;
            flex-grow: 1;
            display: flex;
            align-items: center;
        }

        .course-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 14px;
            gap: 10px;
        }

        .modalidad {
            background: #e9ecef;
            color: #495057;
            padding: 6px 12px;
            border-radius: 12px;
            font-weight: 600;
            flex: 1;
            text-align: center;
        }

        .plazas {
            background: #fff3cd;
            color: #856404;
            padding: 6px 12px;
            border-radius: 12px;
            font-weight: 600;
            flex: 1;
            text-align: center;
        }

        .course-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: auto;
            align-items: center;
        }

        .btn-ver-mas, .btn-reservar {
            display: inline-block;
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            width: 180px;
            text-align: center;
            cursor: pointer;
        }

        .btn-ver-mas {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            box-shadow: 0 4px 14px 0 rgba(30, 64, 175, 0.3);
        }

        .btn-reservar {
            background: linear-gradient(135deg, #059669, #10b981);
            box-shadow: 0 4px 14px 0 rgba(5, 150, 105, 0.3);
        }

        .btn-ver-mas:hover, .btn-reservar:hover {
            transform: translateY(-3px);
            color: white;
            text-decoration: none;
        }

        .btn-ver-mas:hover {
            box-shadow: 0 8px 25px 0 rgba(30, 64, 175, 0.4);
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
        }

        .btn-reservar:hover {
            box-shadow: 0 8px 25px 0 rgba(5, 150, 105, 0.4);
            background: linear-gradient(135deg, #047857, #059669);
        }

        /* Controles del Carrusel */
        .carousel-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            margin-top: 40px;
        }

        .carousel-btn {
            background: linear-gradient(135deg, #0066cc, #0052a3);
            color: white;
            border: none;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 24px;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(0, 102, 204, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .carousel-btn:hover {
            transform: translateY(-4px) scale(1.1);
            box-shadow: 0 8px 25px rgba(0, 102, 204, 0.4);
            background: linear-gradient(135deg, #0052a3, #003d7a);
        }

        .carousel-btn:active {
            transform: translateY(-2px) scale(1.05);
        }

        /* Indicadores */
        .carousel-indicators {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 25px;
        }

        .carousel-indicator {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: none;
            background: rgba(0, 102, 204, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .carousel-indicator.active {
            background: #0066cc;
            transform: scale(1.3);
            box-shadow: 0 3px 10px rgba(0, 102, 204, 0.4);
        }

        .carousel-indicator.active::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 6px;
            height: 6px;
            background: white;
            border-radius: 50%;
        }

        /* Animaciones */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .upcoming-course-card {
            animation: slideInUp 0.8s ease-out;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .carousel-page {
                grid-template-columns: 1fr;
                gap: 20px;
                padding: 0 5px;
            }
            
            .course-details {
                flex-direction: column;
                gap: 10px;
                align-items: center;
            }
            
            .upcoming-course-card {
                min-height: 320px;
            }
            
            .carousel-btn {
                width: 50px;
                height: 50px;
                font-size: 20px;
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

        .status-info {
            background: #d1ecf1;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
            border-left: 5px solid #0066cc;
        }
    </style>
</head>
<body>

<div class="status-info">
    <strong>🎯 CARRUSEL PERFECTO ACTIVADO:</strong><br>
    • Exactamente 3 cursos por página (como la primera foto)<br>
    • Navegación suave y elegante<br>
    • Auto-play cada 6 segundos<br>
    • Controles manuales con botones grandes<br>
    • Indicadores visuales de página<br>
    • Responsive: 3 → 2 → 1 columnas<br>
    • Efectos hover mejorados<br>
</div>

<!-- Próximos Cursos -->
<div class="upcoming-courses-section">
    <div class="section-header">
        <h2>Próximos Cursos</h2>
        <p>Navega entre nuestros cursos - 3 por página como la primera foto</p>
    </div>
    
    <div class="carousel-container" id="coursesCarousel">
        <div class="carousel-track" id="carouselTrack">
            <?php
            // Crear páginas de 3 cursos cada una
            $paginas = ceil(count($todos_cursos) / 3);
            
            for ($pagina = 0; $pagina < $paginas; $pagina++):
                $inicio = $pagina * 3;
                $cursos_pagina = array_slice($todos_cursos, $inicio, 3);
            ?>
                <div class="carousel-page">
                    <?php foreach ($cursos_pagina as $index => $curso): ?>
                        <div class="upcoming-course-card" style="animation-delay: <?php echo ($index * 0.2); ?>s;">
                            <?php if (!empty($curso['image'])): ?>
                                <div class="course-image-container">
                                    <img src="<?php echo esc_url($curso['image']); ?>" alt="<?php echo esc_attr($curso['name']); ?>" class="course-image" onerror="this.parentElement.style.display='none'">
                                </div>
                            <?php endif; ?>
                            
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
                                <a href="<?php echo home_url("/curso-info.php?curso=" . ($inicio + $index + 1)); ?>" class="btn-ver-mas">Ver Más Info</a>
                                <a href="<?php echo home_url('/contacto'); ?>" class="btn-reservar">Reservar Plaza</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endfor; ?>
        </div>
    </div>
    
    <!-- Controles del Carrusel -->
    <div class="carousel-controls">
        <button class="carousel-btn" id="prevBtn">←</button>
        <div class="carousel-indicators" id="carouselIndicators">
            <?php for ($i = 0; $i < $paginas; $i++): ?>
                <button class="carousel-indicator <?php echo $i === 0 ? 'active' : ''; ?>" data-page="<?php echo $i; ?>"></button>
            <?php endfor; ?>
        </div>
        <button class="carousel-btn" id="nextBtn">→</button>
    </div>
</div>

<div class="info-box">
    <strong>✅ FUNCIONAMIENTO PERFECTO:</strong><br>
    <?php for ($i = 0; $i < $paginas; $i++): ?>
        • Página <?php echo ($i + 1); ?>: Cursos <?php echo ($i * 3 + 1); ?>-<?php echo min(($i + 1) * 3, count($todos_cursos)); ?><br>
    <?php endfor; ?>
    • Navegación automática cada 6 segundos<br>
    • Controles manuales con botones ← →<br>
    • Indicadores de página activos<br>
    • Pausa automática al hacer hover<br>
    • Soporte touch/swipe en móviles<br><br>
    
    <a href="/" style="color: #0066cc; font-weight: 600;">🏠 Ver Página Principal</a> | 
    <a href="/gestionar-cursos-dinamico.php" style="color: #0066cc; font-weight: 600;">🎛️ Panel de Gestión</a>
</div>

<script>
// Carrusel Perfecto de 3 Columnas
document.addEventListener("DOMContentLoaded", function() {
    const carouselContainer = document.getElementById("coursesCarousel");
    const carouselTrack = document.getElementById("carouselTrack");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const indicators = document.querySelectorAll(".carousel-indicator");
    const pages = document.querySelectorAll(".carousel-page");
    
    let currentPage = 0;
    const totalPages = pages.length;
    let isTransitioning = false;
    let autoPlayInterval;
    
    // Función para mover el carrusel
    function moveToPage(pageIndex, smooth = true) {
        if (isTransitioning || pageIndex < 0 || pageIndex >= totalPages) return;
        
        if (smooth) {
            carouselTrack.style.transition = "transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94)";
            isTransitioning = true;
            setTimeout(() => {
                isTransitioning = false;
            }, 600);
        } else {
            carouselTrack.style.transition = "none";
        }
        
        const translateX = -pageIndex * 100;
        carouselTrack.style.transform = `translateX(${translateX}%)`;
        
        currentPage = pageIndex;
        updateIndicators();
        
        // Animar las tarjetas de la página actual
        animateCurrentPageCards();
    }
    
    // Función para animar las tarjetas de la página actual
    function animateCurrentPageCards() {
        const currentPageElement = pages[currentPage];
        const cards = currentPageElement.querySelectorAll(".upcoming-course-card");
        
        cards.forEach((card, index) => {
            card.style.animation = "none";
            card.offsetHeight; // Trigger reflow
            card.style.animation = `slideInUp 0.8s ease-out ${index * 0.2}s both`;
        });
    }
    
    // Función para actualizar indicadores
    function updateIndicators() {
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle("active", index === currentPage);
        });
    }
    
    // Función para ir a la siguiente página
    function nextPage() {
        const nextIndex = (currentPage + 1) % totalPages;
        moveToPage(nextIndex);
    }
    
    // Función para ir a la página anterior
    function prevPage() {
        const prevIndex = (currentPage - 1 + totalPages) % totalPages;
        moveToPage(prevIndex);
    }
    
    // Event listeners para botones
    nextBtn.addEventListener("click", nextPage);
    prevBtn.addEventListener("click", prevPage);
    
    // Event listeners para indicadores
    indicators.forEach((indicator, index) => {
        indicator.addEventListener("click", () => {
            moveToPage(index);
        });
    });
    
    // Auto-play
    function startAutoPlay() {
        autoPlayInterval = setInterval(() => {
            nextPage();
        }, 6000); // Cambiar cada 6 segundos
    }
    
    function stopAutoPlay() {
        clearInterval(autoPlayInterval);
    }
    
    // Pausar auto-play al hacer hover
    carouselContainer.addEventListener("mouseenter", stopAutoPlay);
    carouselContainer.addEventListener("mouseleave", startAutoPlay);
    
    // Pausar auto-play al interactuar con controles
    prevBtn.addEventListener("click", () => {
        stopAutoPlay();
        setTimeout(startAutoPlay, 3000); // Reanudar después de 3 segundos
    });
    
    nextBtn.addEventListener("click", () => {
        stopAutoPlay();
        setTimeout(startAutoPlay, 3000);
    });
    
    indicators.forEach(indicator => {
        indicator.addEventListener("click", () => {
            stopAutoPlay();
            setTimeout(startAutoPlay, 3000);
        });
    });
    
    // Soporte para touch/swipe en móviles
    let startX = 0;
    let currentX = 0;
    let isDragging = false;
    let startTime = 0;
    
    carouselContainer.addEventListener("touchstart", (e) => {
        startX = e.touches[0].clientX;
        startTime = Date.now();
        isDragging = true;
        stopAutoPlay();
        carouselTrack.style.transition = "none";
    });
    
    carouselContainer.addEventListener("touchmove", (e) => {
        if (!isDragging) return;
        e.preventDefault();
        
        currentX = e.touches[0].clientX;
        const diffX = startX - currentX;
        const movePercent = (diffX / carouselContainer.offsetWidth) * 100;
        const currentTransform = -currentPage * 100;
        
        // Limitar el movimiento
        const maxMove = 30; // Máximo 30% de movimiento
        const limitedMove = Math.max(-maxMove, Math.min(maxMove, movePercent));
        
        carouselTrack.style.transform = `translateX(${currentTransform - limitedMove}%)`;
    });
    
    carouselContainer.addEventListener("touchend", (e) => {
        if (!isDragging) return;
        isDragging = false;
        
        const diffX = startX - currentX;
        const diffTime = Date.now() - startTime;
        const velocity = Math.abs(diffX) / diffTime;
        
        // Determinar si es un swipe válido
        const threshold = 50;
        const isQuickSwipe = velocity > 0.5;
        const isLongSwipe = Math.abs(diffX) > threshold;
        
        if (isQuickSwipe || isLongSwipe) {
            if (diffX > 0) {
                nextPage();
            } else {
                prevPage();
            }
        } else {
            // Volver a la posición original
            moveToPage(currentPage);
        }
        
        // Reanudar auto-play después de 3 segundos
        setTimeout(startAutoPlay, 3000);
    });
    
    // Prevenir scroll vertical durante swipe horizontal
    carouselContainer.addEventListener("touchmove", (e) => {
        if (isDragging) {
            e.preventDefault();
        }
    }, { passive: false });
    
    // Inicializar
    moveToPage(0, false);
    startAutoPlay();
    
    // Mejorar la experiencia con teclado
    document.addEventListener("keydown", (e) => {
        if (e.key === "ArrowLeft") {
            prevPage();
            stopAutoPlay();
            setTimeout(startAutoPlay, 3000);
        } else if (e.key === "ArrowRight") {
            nextPage();
            stopAutoPlay();
            setTimeout(startAutoPlay, 3000);
        }
    });
    
    // Pausar cuando la pestaña no está visible
    document.addEventListener("visibilitychange", () => {
        if (document.hidden) {
            stopAutoPlay();
        } else {
            startAutoPlay();
        }
    });
});
</script>

</body>
</html>
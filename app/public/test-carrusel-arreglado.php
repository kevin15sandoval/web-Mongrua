<?php
/**
 * Test del Carrusel Arreglado - Muestra 3 Cursos Simultáneamente
 * Exactamente como la imagen que enviaste
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🎠 Test Carrusel Arreglado - 3 Columnas Visibles</h1>";

// Obtener cursos actuales
$cursos_dinamicos = get_option('mongruas_courses', []);

// Agregar cursos de ejemplo para tener suficientes
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

$todos_cursos = array_merge($cursos_dinamicos, $cursos_ejemplo);
$todos_cursos = array_slice($todos_cursos, 0, 9); // Máximo 9 cursos para 3 páginas

$total_cursos = count($todos_cursos);
$paginas = ceil($total_cursos / 3);

echo "<div style='background: #d4edda; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
echo "<strong>✅ CARRUSEL ARREGLADO:</strong><br>";
echo "• Total de cursos: " . $total_cursos . "<br>";
echo "• Se ven 3 cursos simultáneamente (como tu imagen)<br>";
echo "• Total de páginas: " . $paginas . "<br>";
echo "• Navegación: De 3 en 3 cursos<br>";
echo "• Auto-play: Cada 6 segundos<br>";
echo "• Botones grandes y visibles<br>";
echo "</div>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Carrusel Arreglado</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        }

        h1 {
            background: linear-gradient(135deg, #0066cc, #0052a3);
            color: white;
            padding: 30px;
            border-radius: 16px;
            margin-bottom: 30px;
            text-align: center;
        }

        /* Próximos Cursos - EXACTAMENTE como tu imagen */
        .upcoming-courses-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 20px;
            padding: 50px 40px;
            margin: 40px 0;
            border: 2px solid #e0e0e0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-header h2 {
            font-size: 42px;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 10px;
        }

        .section-header p {
            font-size: 22px;
            color: #495057;
        }

        /* Grid que muestra 3 cursos simultáneamente */
        .upcoming-courses-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Tarjetas de cursos */
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
            min-height: 400px;
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
            min-height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
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
            text-align: center;
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

        /* Estilos para el carrusel */
        .carousel-container-tres {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .carousel-track-tres {
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

        /* Controles del carrusel */
        .carousel-controls-tres {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            margin-top: 40px;
        }

        .carousel-btn-tres {
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

        .carousel-btn-tres:hover {
            transform: translateY(-4px) scale(1.1);
            box-shadow: 0 8px 25px rgba(0, 102, 204, 0.4);
            background: linear-gradient(135deg, #0052a3, #003d7a);
        }

        .carousel-indicators-tres {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .carousel-indicator-tres {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: none;
            background: rgba(0, 102, 204, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .carousel-indicator-tres.active {
            background: #0066cc;
            transform: scale(1.3);
            box-shadow: 0 3px 10px rgba(0, 102, 204, 0.4);
        }

        .carousel-indicator-tres.active::after {
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

        /* Responsive */
        @media (max-width: 768px) {
            .carousel-page {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .course-details {
                flex-direction: column;
                gap: 10px;
            }
            
            .upcoming-course-card {
                min-height: 350px;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .carousel-page {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
        }

        .info-box {
            background: #d1ecf1;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
            border-left: 5px solid #0066cc;
        }

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
    </style>
</head>
<body>

<div class="info-box">
    <strong>🎯 ARREGLADO - COMO TU IMAGEN:</strong><br>
    • Se ven los 3 cursos simultáneamente en 3 columnas<br>
    • El carrusel navega de 3 en 3 cursos<br>
    • Botones grandes ← → debajo<br>
    • Indicadores de página en el centro<br>
    • Auto-play cada 6 segundos<br>
    • Diseño idéntico a tu imagen<br>
</div>

<!-- Próximos Cursos - ARREGLADO -->
<div class="upcoming-courses-section">
    <div class="section-header">
        <h2>Próximos Cursos</h2>
        <p>Cursos que comenzarán próximamente. ¡Reserva tu plaza!</p>
    </div>
    
    <div class="upcoming-courses-grid">
        <?php foreach ($todos_cursos as $index => $curso): ?>
            <div class="upcoming-course-card">
                <div class="course-date"><?php echo !empty($curso['date']) ? esc_html($curso['date']) : 'Próximamente'; ?></div>
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
    <strong>✅ FUNCIONAMIENTO PERFECTO:</strong><br>
    • <strong>Página 1:</strong> Se ven 3 cursos simultáneamente<br>
    • <strong>Página 2:</strong> Se ven otros 3 cursos<br>
    • <strong>Página 3:</strong> Se ven otros 3 cursos<br>
    • <strong>Navegación:</strong> Al hacer clic en → se cambian los 3 cursos por otros 3<br>
    • <strong>Auto-play:</strong> Cada 6 segundos cambia automáticamente<br>
    • <strong>Diseño:</strong> Exactamente igual que tu imagen<br><br>
    
    <a href="/" style="color: #0066cc; font-weight: 600;">🏠 Ver Página Principal</a> | 
    <a href="/gestionar-cursos-dinamico.php" style="color: #0066cc; font-weight: 600;">🎛️ Panel de Gestión</a>
</div>

<script>
// Carrusel de 3 en 3 - ARREGLADO PARA MOSTRAR 3 COLUMNAS
document.addEventListener("DOMContentLoaded", function() {
    const coursesGrid = document.querySelector(".upcoming-courses-grid");
    const courseCards = document.querySelectorAll(".upcoming-course-card");
    
    if (!coursesGrid || courseCards.length <= 3) {
        console.log("⚠️ No se necesita carrusel: " + courseCards.length + " cursos");
        return; // No crear carrusel si hay 3 o menos cursos
    }
    
    console.log(`🎠 Iniciando carrusel con ${courseCards.length} cursos`);
    
    // NO convertir a flex - mantener como contenedor para el carrusel
    coursesGrid.style.display = "block";
    coursesGrid.style.overflow = "hidden";
    coursesGrid.style.position = "relative";
    
    // Crear contenedor de carrusel que mantenga las 3 columnas visibles
    const carouselContainer = document.createElement("div");
    carouselContainer.className = "carousel-container-tres";
    carouselContainer.style.position = "relative";
    carouselContainer.style.overflow = "hidden";
    carouselContainer.style.borderRadius = "20px";
    
    // Crear track del carrusel que muestre 3 columnas
    const carouselTrack = document.createElement("div");
    carouselTrack.className = "carousel-track-tres";
    carouselTrack.style.display = "flex";
    carouselTrack.style.transition = "transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94)";
    carouselTrack.style.willChange = "transform";
    
    // Organizar cursos en grupos de 3 - CADA PÁGINA MUESTRA 3 CURSOS
    const originalCards = Array.from(courseCards);
    const totalCards = originalCards.length;
    const cardsPerPage = 3;
    const totalPages = Math.ceil(totalCards / cardsPerPage);
    
    console.log(`📊 Configuración: ${totalCards} cursos, ${totalPages} páginas de ${cardsPerPage} cursos cada una`);
    
    // Crear páginas de 3 cursos cada una - GRID DE 3 COLUMNAS
    for (let page = 0; page < totalPages; page++) {
        const pageContainer = document.createElement("div");
        pageContainer.className = "carousel-page";
        pageContainer.style.display = "grid";
        pageContainer.style.gridTemplateColumns = "repeat(3, 1fr)";
        pageContainer.style.gap = "25px";
        pageContainer.style.minWidth = "100%";
        pageContainer.style.flexShrink = "0";
        pageContainer.style.padding = "0 10px";
        
        // Agregar exactamente 3 cursos por página
        for (let i = 0; i < cardsPerPage; i++) {
            const cardIndex = page * cardsPerPage + i;
            if (cardIndex < totalCards) {
                const card = originalCards[cardIndex].cloneNode(true);
                card.style.minWidth = "auto";
                card.style.width = "100%";
                pageContainer.appendChild(card);
                console.log(`➕ Página ${page + 1}: Agregado curso ${cardIndex + 1}`);
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
    
    // Función para mover el carrusel - MUESTRA 3 CURSOS SIEMPRE
    function moveCarousel(pageIndex, smooth = true) {
        if (isTransitioning) return;
        
        console.log(`🎯 Moviendo a página ${pageIndex + 1} de ${totalPages}`);
        
        if (smooth) {
            carouselTrack.style.transition = "transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94)";
        } else {
            carouselTrack.style.transition = "none";
        }
        
        // Mover para mostrar la página completa (3 cursos visibles)
        const translateX = -pageIndex * 100;
        carouselTrack.style.transform = `translateX(${translateX}%)`;
        
        if (smooth) {
            isTransitioning = true;
            setTimeout(() => {
                isTransitioning = false;
            }, 600);
        }
        
        updateIndicators();
        
        // Animar las tarjetas de la página actual
        animateCurrentPageCards();
    }
    
    // Función para animar las tarjetas de la página actual
    function animateCurrentPageCards() {
        const pages = carouselTrack.querySelectorAll(".carousel-page");
        if (pages[currentPage]) {
            const cards = pages[currentPage].querySelectorAll(".upcoming-course-card");
            cards.forEach((card, index) => {
                card.style.animation = "none";
                card.offsetHeight; // Trigger reflow
                card.style.animation = `slideInUp 0.8s ease-out ${index * 0.2}s both`;
            });
        }
    }
    
    // Función para ir a la siguiente página (siguientes 3 cursos)
    function nextPage() {
        currentPage = (currentPage + 1) % totalPages;
        moveCarousel(currentPage);
        console.log(`➡️ Siguiente página: mostrando cursos ${(currentPage * 3) + 1}-${Math.min((currentPage + 1) * 3, totalCards)}`);
    }
    
    // Función para ir a la página anterior (anteriores 3 cursos)
    function prevPage() {
        currentPage = (currentPage - 1 + totalPages) % totalPages;
        moveCarousel(currentPage);
        console.log(`⬅️ Página anterior: mostrando cursos ${(currentPage * 3) + 1}-${Math.min((currentPage + 1) * 3, totalCards)}`);
    }
    
    // Crear controles del carrusel - BOTONES GRANDES Y VISIBLES
    const controlsContainer = document.createElement("div");
    controlsContainer.className = "carousel-controls-tres";
    controlsContainer.style.display = "flex";
    controlsContainer.style.justifyContent = "center";
    controlsContainer.style.alignItems = "center";
    controlsContainer.style.gap = "30px";
    controlsContainer.style.marginTop = "40px";
    
    const prevButton = document.createElement("button");
    prevButton.innerHTML = "←";
    prevButton.className = "carousel-btn-tres carousel-prev";
    prevButton.onclick = () => {
        prevPage();
        stopAutoPlay();
        setTimeout(startAutoPlay, 3000); // Reanudar después de 3 segundos
    };
    
    const nextButton = document.createElement("button");
    nextButton.innerHTML = "→";
    nextButton.className = "carousel-btn-tres carousel-next";
    nextButton.onclick = () => {
        nextPage();
        stopAutoPlay();
        setTimeout(startAutoPlay, 3000);
    };
    
    controlsContainer.appendChild(prevButton);
    
    // Crear indicadores en el centro
    const indicatorsContainer = document.createElement("div");
    indicatorsContainer.className = "carousel-indicators-tres";
    indicatorsContainer.style.display = "flex";
    indicatorsContainer.style.justifyContent = "center";
    indicatorsContainer.style.gap = "15px";
    
    for (let i = 0; i < totalPages; i++) {
        const indicator = document.createElement("button");
        indicator.className = "carousel-indicator-tres";
        if (i === 0) indicator.classList.add("active");
        indicator.onclick = () => {
            currentPage = i;
            moveCarousel(i);
            console.log(`🎯 Indicador clickeado: página ${i + 1}`);
            stopAutoPlay();
            setTimeout(startAutoPlay, 3000);
        };
        indicatorsContainer.appendChild(indicator);
    }
    
    controlsContainer.appendChild(indicatorsContainer);
    controlsContainer.appendChild(nextButton);
    
    carouselContainer.parentNode.insertBefore(controlsContainer, carouselContainer.nextSibling);
    
    // Función para actualizar indicadores
    function updateIndicators() {
        const indicators = document.querySelectorAll(".carousel-indicator-tres");
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle("active", index === currentPage);
        });
    }
    
    // Auto-play mejorado
    function startAutoPlay() {
        autoPlayInterval = setInterval(() => {
            nextPage();
        }, 6000); // Cambiar cada 6 segundos
        console.log("▶️ Auto-play iniciado (6 segundos)");
    }
    
    function stopAutoPlay() {
        clearInterval(autoPlayInterval);
        console.log("⏸️ Auto-play pausado");
    }
    
    // Pausar auto-play al hacer hover
    carouselContainer.addEventListener("mouseenter", stopAutoPlay);
    carouselContainer.addEventListener("mouseleave", startAutoPlay);
    
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
    startAutoPlay();
    
    console.log("✅ Carrusel listo - Se muestran 3 cursos simultáneamente como en tu imagen");
});
</script>

</body>
</html>
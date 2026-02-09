<?php
/**
 * PÁGINA DE ANUNCIOS - SIN WORDPRESS
 * Conexión directa a la base de datos para evitar conflictos
 */

// Conexión directa a MySQL (sin cargar WordPress)
$db_host = 'localhost';
$db_name = 'mongruasformacion';
$db_user = 'root';
$db_pass = 'root';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Obtener cursos
    $stmt = $pdo->query("SELECT * FROM wp_upcoming_courses ORDER BY id ASC");
    $cursos = $stmt->fetchAll(PDO::FETCH_OBJ);
} catch(PDOException $e) {
    $cursos = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Próximos Cursos - Mogruas Formación</title>
    <style>
        /* RESET */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8f9fa;
            color: #333;
        }
        
        /* CONTENEDOR PRINCIPAL */
        .services-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .section-heading {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .section-heading h2 {
            font-size: 3rem;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 800;
        }
        
        .section-heading p {
            font-size: 1.2rem;
            color: #6c757d;
        }
        
        /* CARRUSEL - COPIADO EXACTO DE SERVICIOS */
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
        
        .service-card {
            flex: 0 0 calc(33.333% - 20px) !important;
            min-width: calc(33.333% - 20px) !important;
            max-width: calc(33.333% - 20px) !important;
            box-sizing: border-box;
            display: flex !important;
            flex-direction: column !important;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .curso-badge {
            background: linear-gradient(135deg, #27ae60, #229954);
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: 20px;
        }
        
        .service-title {
            font-size: 1.8rem;
            color: #2c3e50;
            margin-bottom: 15px;
            font-weight: 800;
        }
        
        .service-description {
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 25px;
            font-size: 1rem;
        }
        
        .curso-detalles {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 25px;
            flex-wrap: wrap;
            font-size: 0.9rem;
            color: #495057;
        }
        
        .detalle-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .curso-acciones {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 24px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #2980b9, #1f618d);
            transform: translateY(-2px);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #27ae60, #229954);
            color: white;
        }
        
        .btn-success:hover {
            background: linear-gradient(135deg, #229954, #1e8449);
            transform: translateY(-2px);
        }
        
        /* CONTROLES */
        .services-carousel-control {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            border: 2px solid #3498db;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
            color: #3498db;
        }
        
        .services-carousel-control:hover {
            background: #3498db;
            color: white;
            transform: translateY(-50%) scale(1.1);
        }
        
        .services-carousel-control.prev { left: 0; }
        .services-carousel-control.next { right: 0; }
        
        .services-carousel-control:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }
        
        /* INDICADORES */
        .services-carousel-dots {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 40px;
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
            background: #3498db;
            width: 30px;
            border-radius: 6px;
        }
        
        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .service-card {
                flex: 0 0 calc(50% - 15px) !important;
                min-width: calc(50% - 15px) !important;
                max-width: calc(50% - 15px) !important;
            }
        }
        
        @media (max-width: 768px) {
            .services-carousel-container { padding: 0 50px; }
            .services-carousel-track { gap: 20px; }
            .service-card {
                flex: 0 0 100% !important;
                min-width: 100% !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body>
    <section class="services-section">
        <div class="container">
            <div class="section-heading">
                <h2>Próximos Cursos</h2>
                <p>Cursos que comenzarán próximamente. ¡Reserva tu plaza!</p>
            </div>

            <div class="services-carousel-container">
                <button class="services-carousel-control prev" id="prevBtn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>

                <div class="services-carousel-wrapper">
                    <div class="services-carousel-track" id="carouselTrack">
                        <?php if ($cursos && count($cursos) > 0) : ?>
                            <?php foreach ($cursos as $curso) : ?>
                            <div class="service-card">
                                <div class="curso-badge"><?php echo htmlspecialchars($curso->start_date); ?></div>
                                <h3 class="service-title"><?php echo htmlspecialchars($curso->course_name); ?></h3>
                                <p class="service-description"><?php echo htmlspecialchars($curso->description); ?></p>
                                
                                <div class="curso-detalles">
                                    <div class="detalle-item">
                                        <span>💻</span>
                                        <span><?php echo htmlspecialchars($curso->modality); ?></span>
                                    </div>
                                    <div class="detalle-item">
                                        <span>👥</span>
                                        <span><?php echo htmlspecialchars($curso->available_spots); ?> plazas</span>
                                    </div>
                                    <?php if (!empty($curso->duration)) : ?>
                                    <div class="detalle-item">
                                        <span>⏱️</span>
                                        <span><?php echo htmlspecialchars($curso->duration); ?></span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="curso-acciones">
                                    <a href="/curso-detalle.php?id=<?php echo $curso->id; ?>" class="btn btn-primary">Ver Más Info</a>
                                    <a href="/#contact" class="btn btn-success">Reservar Plaza</a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="service-card">
                                <h3 class="service-title">No hay cursos disponibles</h3>
                                <p class="service-description">Vuelve pronto para ver las novedades.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <button class="services-carousel-control next" id="nextBtn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </div>

            <div class="services-carousel-dots" id="carouselDots"></div>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const track = document.getElementById('carouselTrack');
        const cards = track.querySelectorAll('.service-card');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const dotsContainer = document.getElementById('carouselDots');
        
        let currentIndex = 0;
        let cardsPerView = 3;
        
        function updateCardsPerView() {
            const width = window.innerWidth;
            if (width <= 768) {
                cardsPerView = 1;
            } else if (width <= 1024) {
                cardsPerView = 2;
            } else {
                cardsPerView = 3;
            }
        }
        
        updateCardsPerView();
        const maxIndex = Math.max(0, cards.length - cardsPerView);
        
        // Crear dots
        for (let i = 0; i <= maxIndex; i++) {
            const dot = document.createElement('button');
            dot.classList.add('services-carousel-dot');
            if (i === 0) dot.classList.add('active');
            dot.addEventListener('click', () => goToSlide(i));
            dotsContainer.appendChild(dot);
        }
        
        const dots = dotsContainer.querySelectorAll('.services-carousel-dot');
        
        function updateCarousel() {
            if (cards.length === 0) return;
            const cardWidth = cards[0].offsetWidth;
            const gap = 30;
            const offset = -(currentIndex * (cardWidth + gap));
            track.style.transform = `translateX(${offset}px)`;
            
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentIndex);
            });
            
            prevBtn.disabled = currentIndex === 0;
            nextBtn.disabled = currentIndex >= maxIndex;
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
            currentIndex = index;
            updateCarousel();
        }
        
        prevBtn.addEventListener('click', prevSlide);
        nextBtn.addEventListener('click', nextSlide);
        
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                updateCardsPerView();
                currentIndex = 0;
                updateCarousel();
            }, 250);
        });
        
        updateCarousel();
        console.log('✅ Carrusel cargado:', cards.length, 'cursos');
    });
    </script>
</body>
</html>

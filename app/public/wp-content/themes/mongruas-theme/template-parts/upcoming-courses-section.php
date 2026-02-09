<?php
/**
 * Template part for displaying upcoming courses carousel
 * Estilo idéntico al carrusel de servicios
 * CONECTADO A LA BASE DE DATOS
 *
 * @package Mongruas
 * @since 1.0.0
 */

// Conexión a la base de datos para obtener cursos dinámicamente
global $wpdb;
$table_name = $wpdb->prefix . 'upcoming_courses';
$cursos = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id ASC");
?>

<section id="upcoming-courses" class="upcoming-courses-section section">
    <div class="container">
        <div class="section-heading">
            <h2>Próximos Cursos</h2>
            <p>Cursos que comenzarán próximamente. ¡Reserva tu plaza!</p>
        </div>

        <div class="upcoming-carousel-container">
            <button class="upcoming-carousel-control prev" id="upcomingPrevBtn" aria-label="Anterior">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>

            <div class="upcoming-carousel-wrapper">
                <div class="upcoming-carousel-track" id="upcomingCarouselTrack">
                    <?php if ($cursos && count($cursos) > 0) : ?>
                        <?php foreach ($cursos as $curso) : ?>
                        <div class="upcoming-course-card">
                            <div class="course-badge"><?php echo esc_html($curso->start_date); ?></div>
                            <h3 class="course-title"><?php echo esc_html($curso->course_name); ?></h3>
                            <p class="course-description"><?php echo esc_html($curso->description); ?></p>
                            
                            <div class="course-details">
                                <div class="detail-item">
                                    <span>💻</span>
                                    <span><?php echo esc_html($curso->modality); ?></span>
                                </div>
                                <div class="detail-item">
                                    <span>👥</span>
                                    <span><?php echo esc_html($curso->available_spots); ?> plazas</span>
                                </div>
                                <?php if (!empty($curso->duration)) : ?>
                                <div class="detail-item">
                                    <span>⏱️</span>
                                    <span><?php echo esc_html($curso->duration); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="course-actions">
                                <a href="<?php echo home_url('/curso-detalle.php?id=' . $curso->id); ?>" class="btn btn-primary">Ver Más Info</a>
                                <a href="#contact" class="btn btn-outline">Reservar Plaza</a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="upcoming-course-card">
                            <h3 class="course-title">No hay cursos disponibles</h3>
                            <p class="course-description">Vuelve pronto para ver las novedades.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <button class="upcoming-carousel-control next" id="upcomingNextBtn" aria-label="Siguiente">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>
        </div>

        <div class="upcoming-carousel-dots" id="upcomingCarouselDots"></div>
    </div>
</section>

<style>
/* ESTILOS IDÉNTICOS AL CARRUSEL DE SERVICIOS */
.upcoming-carousel-container {
    position: relative;
    padding: 0 70px;
    margin-top: 40px;
    max-width: 1400px;
    margin-left: auto;
    margin-right: auto;
}

.upcoming-carousel-wrapper {
    overflow: hidden;
    width: 100%;
}

.upcoming-carousel-track {
    display: flex !important;
    flex-direction: row !important;
    transition: transform 0.5s ease-in-out;
    gap: 30px;
    width: 100%;
    flex-wrap: nowrap !important;
}

.upcoming-carousel-track .upcoming-course-card {
    flex: 0 0 calc(33.333% - 20px) !important;
    min-width: calc(33.333% - 20px) !important;
    max-width: calc(33.333% - 20px) !important;
    box-sizing: border-box;
    display: flex !important;
    flex-direction: column !important;
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.upcoming-course-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}

.course-badge {
    background: linear-gradient(135deg, #27ae60, #229954);
    color: white;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    display: inline-block;
    margin-bottom: 15px;
    width: fit-content;
}

.course-title {
    font-size: 1.4rem;
    color: #2c3e50;
    margin-bottom: 12px;
    font-weight: 700;
    line-height: 1.3;
}

.course-description {
    color: #6c757d;
    line-height: 1.6;
    margin-bottom: 20px;
    font-size: 0.95rem;
    flex-grow: 1;
}

.course-details {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #495057;
    font-weight: 600;
    font-size: 0.9rem;
}

.course-actions {
    display: flex;
    gap: 10px;
    flex-direction: column;
}

.course-actions .btn {
    padding: 12px 20px;
    font-size: 0.9rem;
    text-align: center;
    width: 100%;
}

.upcoming-carousel-control {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: white;
    border: 2px solid var(--color-primary);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 10;
    color: var(--color-primary);
}

.upcoming-carousel-control:hover {
    background: var(--color-primary);
    color: white;
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 6px 20px rgba(0, 102, 204, 0.4);
}

.upcoming-carousel-control.prev {
    left: 0;
}

.upcoming-carousel-control.next {
    right: 0;
}

.upcoming-carousel-control:disabled {
    opacity: 0.3;
    cursor: not-allowed;
}

.upcoming-carousel-control:disabled:hover {
    background: white;
    color: var(--color-primary);
    transform: translateY(-50%);
    box-shadow: none;
}

.upcoming-carousel-dots {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 40px;
}

.upcoming-carousel-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #dee2e6;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0;
}

.upcoming-carousel-dot:hover {
    background: #adb5bd;
    transform: scale(1.2);
}

.upcoming-carousel-dot.active {
    background: var(--color-primary);
    width: 30px;
    border-radius: 6px;
}

/* Responsive */
@media (max-width: 1024px) {
    .upcoming-carousel-track .upcoming-course-card {
        flex: 0 0 calc(50% - 15px) !important;
        min-width: calc(50% - 15px) !important;
        max-width: calc(50% - 15px) !important;
    }
}

@media (max-width: 768px) {
    .upcoming-carousel-container {
        padding: 0 50px;
    }
    
    .upcoming-carousel-track {
        gap: 20px;
    }
    
    .upcoming-carousel-track .upcoming-course-card {
        flex: 0 0 100% !important;
        min-width: 100% !important;
        max-width: 100% !important;
    }
    
    .upcoming-carousel-control {
        width: 40px;
        height: 40px;
    }
}

@media (max-width: 480px) {
    .upcoming-carousel-container {
        padding: 0 40px;
    }
    
    .upcoming-carousel-control {
        width: 35px;
        height: 35px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const track = document.getElementById('upcomingCarouselTrack');
    if (!track) return;
    
    const cards = track.querySelectorAll('.upcoming-course-card');
    const prevBtn = document.getElementById('upcomingPrevBtn');
    const nextBtn = document.getElementById('upcomingNextBtn');
    const dotsContainer = document.getElementById('upcomingCarouselDots');
    
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
        dot.classList.add('upcoming-carousel-dot');
        if (i === 0) dot.classList.add('active');
        dot.setAttribute('aria-label', `Ir a posición ${i + 1}`);
        dot.addEventListener('click', () => goToSlide(i));
        dotsContainer.appendChild(dot);
    }
    
    const dots = dotsContainer.querySelectorAll('.upcoming-carousel-dot');
    
    function updateCarousel() {
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
    
    // Soporte táctil
    let touchStartX = 0;
    let touchEndX = 0;
    
    track.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });
    
    track.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        if (touchEndX < touchStartX - 50) nextSlide();
        if (touchEndX > touchStartX + 50) prevSlide();
    });
    
    updateCarousel();
});
</script>

// CARRUSEL 3 EN 3 - JAVASCRIPT COMPLETO

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
});
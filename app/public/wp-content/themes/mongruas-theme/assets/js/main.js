/**
 * Main JavaScript for Mongruas Theme
 * Includes carousel functionality for about section
 */

document.addEventListener("DOMContentLoaded", function() {
    console.log("🚀 Main.js cargado correctamente");
    
    // CARRUSEL DE FOTOS - PÁGINA DE INICIO
    initializeAboutCarousel();
    
    // Otras funcionalidades
    initializeFormValidation();
    initializeScrollEffects();
});

/**
 * Inicializar carrusel de fotos en la sección About
 */
function initializeAboutCarousel() {
    const track = document.getElementById("carouselTrackAbout");
    if (!track) return;
    
    const slides = document.querySelectorAll(".carousel-slide-about");
    const prevBtn = document.getElementById("prevBtnAbout");
    const nextBtn = document.getElementById("nextBtnAbout");
    const indicatorsContainer = document.getElementById("carouselIndicatorsAbout");
    
    if (slides.length === 0) return;
    
    let currentSlide = 0;
    const totalSlides = slides.length;
    
    // Crear indicadores
    indicatorsContainer.innerHTML = "";
    for (let i = 0; i < totalSlides; i++) {
        const indicator = document.createElement("button");
        indicator.classList.add("carousel-indicator-about");
        if (i === 0) indicator.classList.add("active");
        indicator.setAttribute("aria-label", `Ir a imagen ${i + 1}`);
        indicator.addEventListener("click", () => goToSlide(i));
        indicatorsContainer.appendChild(indicator);
    }
    
    const indicators = document.querySelectorAll(".carousel-indicator-about");
    
    function updateCarousel() {
        slides.forEach(slide => slide.classList.remove("active"));
        slides[currentSlide].classList.add("active");
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle("active", index === currentSlide);
        });
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
    
    // Event listeners
    if (prevBtn) prevBtn.addEventListener("click", prevSlide);
    if (nextBtn) nextBtn.addEventListener("click", nextSlide);
    
    // Auto-play
    let autoplayInterval = setInterval(nextSlide, 5000);
    
    const carouselContainer = document.querySelector(".about-carousel");
    if (carouselContainer) {
        carouselContainer.addEventListener("mouseenter", () => clearInterval(autoplayInterval));
        carouselContainer.addEventListener("mouseleave", () => {
            autoplayInterval = setInterval(nextSlide, 5000);
        });
    }
    
    // Soporte táctil
    let touchStartX = 0;
    let touchEndX = 0;
    
    track.addEventListener("touchstart", (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });
    
    track.addEventListener("touchend", (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });
    
    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = touchStartX - touchEndX;
        
        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                nextSlide();
            } else {
                prevSlide();
            }
        }
    }
    
    console.log("🎠 Carrusel de fotos inicializado correctamente");
}

/**
 * Inicializar validación de formularios
 */
function initializeFormValidation() {
    const forms = document.querySelectorAll("form");
    forms.forEach(form => {
        form.addEventListener("submit", function(e) {
            // Validación básica
            const requiredFields = form.querySelectorAll("[required]");
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add("error");
                } else {
                    field.classList.remove("error");
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                console.log("❌ Formulario inválido");
            }
        });
    });
}

/**
 * Inicializar efectos de scroll
 */
function initializeScrollEffects() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px"
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("animate-in");
            }
        });
    }, observerOptions);
    
    // Observar elementos con clase animate
    const animateElements = document.querySelectorAll(".animate-on-scroll");
    animateElements.forEach(el => observer.observe(el));
}

/**
 * Utilidades generales
 */
window.MongruasUtils = {
    // Función para smooth scroll
    smoothScrollTo: function(target) {
        const element = document.querySelector(target);
        if (element) {
            element.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });
        }
    },
    
    // Función para mostrar/ocultar elementos
    toggle: function(selector) {
        const element = document.querySelector(selector);
        if (element) {
            element.style.display = element.style.display === "none" ? "block" : "none";
        }
    }
};
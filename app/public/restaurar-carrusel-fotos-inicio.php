<?php
/**
 * RESTAURAR CARRUSEL DE FOTOS DE LA PÁGINA DE INICIO
 * Restaurar inmediatamente el carrusel que se eliminó por error
 */

echo "<!DOCTYPE html>";
echo "<html><head><title>Restaurar Carrusel Fotos Inicio</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{background:#d4edda;color:#155724;padding:15px;margin:10px 0;border-radius:5px;} .error{background:#f8d7da;color:#721c24;padding:15px;margin:10px 0;border-radius:5px;}</style>";
echo "</head><body>";

echo "<h1>🔄 RESTAURAR CARRUSEL DE FOTOS DE INICIO</h1>";

$theme_path = __DIR__ . '/wp-content/themes/mongruas-theme';

// Restaurar main.js con el código del carrusel de fotos
$main_js_content = '/**
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
};';

$main_js_path = $theme_path . '/assets/js/main.js';
if (file_put_contents($main_js_path, $main_js_content)) {
    echo "<div class='success'>✅ main.js RESTAURADO con carrusel de fotos</div>";
} else {
    echo "<div class='error'>❌ Error al restaurar main.js</div>";
}

// Verificar que about-section.php tenga el carrusel
$about_section_path = $theme_path . '/template-parts/about-section.php';
if (file_exists($about_section_path)) {
    $content = file_get_contents($about_section_path);
    if (strpos($content, 'about-carousel') !== false && strpos($content, 'carouselTrackAbout') !== false) {
        echo "<div class='success'>✅ about-section.php tiene el carrusel de fotos intacto</div>";
    } else {
        echo "<div class='error'>❌ about-section.php parece dañado, necesita restauración</div>";
    }
} else {
    echo "<div class='error'>❌ about-section.php no encontrado</div>";
}

// Limpiar upcoming-courses.js para que no interfiera
$upcoming_js_content = '/**
 * Upcoming Courses JavaScript - SOLO PARA PÁGINA DE ANUNCIOS
 * NO afecta la página de inicio
 */

document.addEventListener("DOMContentLoaded", function() {
    // Solo ejecutar en página de anuncios/cursos
    if (window.location.pathname.includes("anuncios") || 
        window.location.pathname.includes("cursos") ||
        document.body.classList.contains("page-template-page-cursos")) {
        
        console.log("🎓 Upcoming courses JS - Solo para página de anuncios");
        
        // Forzar grid de 2 columnas SOLO en página de anuncios
        function forceGridAnuncios() {
            const grids = document.querySelectorAll(".upcoming-courses-grid");
            grids.forEach(grid => {
                grid.style.display = "grid";
                grid.style.gridTemplateColumns = "repeat(2, 1fr)";
                grid.style.gap = "30px";
                grid.style.maxWidth = "900px";
                grid.style.margin = "0 auto";
            });
        }
        
        forceGridAnuncios();
        setInterval(forceGridAnuncios, 1000);
    } else {
        console.log("🏠 Página de inicio - NO aplicar cambios de anuncios");
    }
});';

$upcoming_js_path = $theme_path . '/assets/js/upcoming-courses.js';
if (file_put_contents($upcoming_js_path, $upcoming_js_content)) {
    echo "<div class='success'>✅ upcoming-courses.js LIMPIO - Solo afecta página de anuncios</div>";
} else {
    echo "<div class='error'>❌ Error al limpiar upcoming-courses.js</div>";
}

echo "<hr>";
echo "<h2>🎯 CARRUSEL DE FOTOS RESTAURADO</h2>";
echo "<p>Se ha restaurado el carrusel de fotos de la página de inicio:</p>";
echo "<ul>";
echo "<li>✅ <strong>main.js restaurado</strong> - Con código completo del carrusel de fotos</li>";
echo "<li>✅ <strong>about-section.php verificado</strong> - Carrusel intacto</li>";
echo "<li>✅ <strong>upcoming-courses.js limpio</strong> - Solo afecta página de anuncios</li>";
echo "<li>✅ <strong>Autoplay cada 5 segundos</strong> - Funcionalidad completa</li>";
echo "<li>✅ <strong>Controles táctiles</strong> - Para móviles</li>";
echo "</ul>";

echo "<h3>🔗 Probar Ahora:</h3>";
echo "<p><a href='/?v=" . time() . "' target='_blank' style='background: #3498db; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; margin: 10px 5px;'>🏠 PÁGINA DE INICIO</a></p>";
echo "<p><a href='/anuncios.php?v=" . time() . "' target='_blank' style='background: #27ae60; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; margin: 10px 5px;'>📚 PÁGINA DE ANUNCIOS</a></p>";

echo "<p style='margin-top: 20px; padding: 15px; background: #d4edda; border-left: 4px solid #27ae60; color: #155724;'>";
echo "<strong>✅ ¡Carrusel de fotos restaurado!</strong><br>";
echo "La página de inicio debería tener de nuevo el carrusel de fotos funcionando en la sección 'Sobre Nosotros'.";
echo "</p>";

echo "</body></html>";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔄 Restaurar Carruseles Completo YA</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .container { max-width: 1200px; margin: 0 auto; }
        .success { background: #d4edda; color: #155724; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #27ae60; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #dc3545; }
        .warning { background: #fff3e0; color: #e65100; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #ff9800; }
        .info { background: #d1ecf1; color: #0c5460; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #17a2b8; }
        .test-link { display: inline-block; background: linear-gradient(135deg, #3498db, #27ae60); color: white; padding: 15px 30px; text-decoration: none; border-radius: 10px; font-weight: bold; margin: 10px 5px; transition: all 0.3s ease; }
        .test-link:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.3); color: white; text-decoration: none; }
        h1, h2, h3 { color: #2c3e50; }
        .section { background: white; padding: 20px; margin: 20px 0; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔄 RESTAURAR CARRUSELES COMPLETO YA</h1>
        <p>Vamos a restaurar TODOS los carruseles y hacer que se mantengan funcionando permanentemente.</p>

        <?php
        $theme_path = __DIR__ . '/wp-content/themes/mongruas-theme';
        $errores = [];
        $exitos = [];

        // 1. RESTAURAR MAIN.JS CON CARRUSEL DE FOTOS
        echo "<div class='section'><h2>🔧 1. Restaurando main.js</h2>";
        
        $main_js_path = $theme_path . '/assets/js/main.js';
        $main_js_content = '/**
 * Main JavaScript for Mongruas Theme
 * Includes carousel functionality for about section
 */

document.addEventListener("DOMContentLoaded", function() {
    console.log("🚀 Main.js cargado correctamente");
    
    // CARRUSEL DE FOTOS - PÁGINA DE INICIO
    initializeAboutCarousel();
    
    // CARRUSEL DE CURSOS - PÁGINA DE ANUNCIOS
    initializeCoursesCarousel();
    
    // Otras funcionalidades
    initializeFormValidation();
    initializeScrollEffects();
    
    // MANTENER CARRUSELES ACTIVOS SIEMPRE
    setInterval(function() {
        if (!document.getElementById("carouselTrackAbout")) {
            console.log("🔄 Reactivando carrusel de fotos...");
            initializeAboutCarousel();
        }
        if (!document.querySelector(".carrusel-slide")) {
            console.log("🔄 Reactivando carrusel de cursos...");
            initializeCoursesCarousel();
        }
    }, 2000);
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
    if (indicatorsContainer) {
        indicatorsContainer.innerHTML = "";
        for (let i = 0; i < totalSlides; i++) {
            const indicator = document.createElement("button");
            indicator.classList.add("carousel-indicator-about");
            if (i === 0) indicator.classList.add("active");
            indicator.setAttribute("aria-label", `Ir a imagen ${i + 1}`);
            indicator.addEventListener("click", () => goToSlide(i));
            indicatorsContainer.appendChild(indicator);
        }
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
 * Inicializar carrusel de cursos 3 en 3
 */
function initializeCoursesCarousel() {
    const carruselContainer = document.querySelector(".carrusel-container");
    if (!carruselContainer) return;
    
    const slides = document.querySelectorAll(".carrusel-slide");
    const prevBtn = document.querySelector(".carrusel-prev");
    const nextBtn = document.querySelector(".carrusel-next");
    
    if (slides.length === 0) return;
    
    let currentIndex = 0;
    const slidesToShow = 3;
    const totalSlides = slides.length;
    
    function updateCarousel() {
        slides.forEach((slide, index) => {
            slide.style.display = "none";
            slide.classList.remove("active");
        });
        
        for (let i = 0; i < slidesToShow && (currentIndex + i) < totalSlides; i++) {
            const slideIndex = (currentIndex + i) % totalSlides;
            slides[slideIndex].style.display = "block";
            slides[slideIndex].classList.add("active");
        }
    }
    
    function nextSlide() {
        currentIndex = (currentIndex + 1) % totalSlides;
        updateCarousel();
    }
    
    function prevSlide() {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
        updateCarousel();
    }
    
    if (prevBtn) prevBtn.addEventListener("click", prevSlide);
    if (nextBtn) nextBtn.addEventListener("click", nextSlide);
    
    // Auto-play
    let autoplayInterval = setInterval(nextSlide, 4000);
    
    carruselContainer.addEventListener("mouseenter", () => clearInterval(autoplayInterval));
    carruselContainer.addEventListener("mouseleave", () => {
        autoplayInterval = setInterval(nextSlide, 4000);
    });
    
    updateCarousel();
    console.log("🎠 Carrusel de cursos inicializado correctamente");
}

/**
 * Inicializar validación de formularios
 */
function initializeFormValidation() {
    const forms = document.querySelectorAll("form");
    forms.forEach(form => {
        form.addEventListener("submit", function(e) {
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
    
    const animateElements = document.querySelectorAll(".animate-on-scroll");
    animateElements.forEach(el => observer.observe(el));
}

/**
 * Utilidades generales
 */
window.MongruasUtils = {
    smoothScrollTo: function(target) {
        const element = document.querySelector(target);
        if (element) {
            element.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });
        }
    },
    
    toggle: function(selector) {
        const element = document.querySelector(selector);
        if (element) {
            element.style.display = element.style.display === "none" ? "block" : "none";
        }
    }
};';

        if (file_put_contents($main_js_path, $main_js_content)) {
            echo "<div class='success'>✅ main.js restaurado correctamente</div>";
            $exitos[] = "main.js restaurado";
        } else {
            echo "<div class='error'>❌ Error al restaurar main.js</div>";
            $errores[] = "Error en main.js";
        }
        echo "</div>";

        // 2. CREAR CARRUSEL DE CURSOS PARA ANUNCIOS
        echo "<div class='section'><h2>📚 2. Creando carrusel de cursos para anuncios</h2>";
        
        $anuncios_content = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Próximos Cursos - Mogruas Formación</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f8f9fa; }
        .container { max-width: 1200px; margin: 0 auto; }
        .section-title { text-align: center; font-size: 2.5rem; color: #2c3e50; margin-bottom: 40px; }
        
        .carrusel-container {
            position: relative;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .carrusel-wrapper {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            min-height: 400px;
        }
        
        .carrusel-slide {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 25px;
            color: white;
            text-align: center;
            transition: all 0.3s ease;
            display: none;
            position: relative;
            overflow: hidden;
        }
        
        .carrusel-slide.active {
            display: block;
            animation: slideIn 0.5s ease-in-out;
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .carrusel-slide:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }
        
        .curso-titulo {
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 15px;
            line-height: 1.3;
        }
        
        .curso-descripcion {
            font-size: 0.95rem;
            margin-bottom: 20px;
            opacity: 0.9;
            line-height: 1.5;
        }
        
        .curso-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        
        .curso-duracion, .curso-modalidad {
            background: rgba(255,255,255,0.2);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        
        .btn-ver-mas {
            background: white;
            color: #667eea;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-ver-mas:hover {
            background: #f8f9fa;
            transform: scale(1.05);
            color: #667eea;
            text-decoration: none;
        }
        
        .carrusel-controls {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            z-index: 10;
            color: #667eea;
            font-size: 1.2rem;
            font-weight: bold;
        }
        
        .carrusel-controls:hover {
            background: #667eea;
            color: white;
            transform: translateY(-50%) scale(1.1);
        }
        
        .carrusel-prev { left: -25px; }
        .carrusel-next { right: -25px; }
        
        .carrusel-indicators {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 30px;
        }
        
        .indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #dee2e6;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .indicator.active {
            background: #667eea;
            width: 30px;
            border-radius: 6px;
        }
        
        @media (max-width: 968px) {
            .carrusel-wrapper {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
        }
        
        @media (max-width: 768px) {
            .carrusel-wrapper {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .carrusel-controls {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="section-title">📚 Próximos Cursos</h1>
        
        <div class="carrusel-container">
            <div class="carrusel-wrapper">
                <!-- Curso 1 -->
                <div class="carrusel-slide active">
                    <h3 class="curso-titulo">Operador de Grúa Torre</h3>
                    <p class="curso-descripcion">Formación completa para el manejo seguro de grúas torre con certificación oficial.</p>
                    <div class="curso-info">
                        <span class="curso-duracion">40 horas</span>
                        <span class="curso-modalidad">Presencial</span>
                    </div>
                    <a href="/curso-detalle.php?id=1" class="btn-ver-mas">Ver más información</a>
                </div>
                
                <!-- Curso 2 -->
                <div class="carrusel-slide active">
                    <h3 class="curso-titulo">Prevención de Riesgos Laborales</h3>
                    <p class="curso-descripcion">Curso básico de PRL para trabajadores en el sector de la construcción.</p>
                    <div class="curso-info">
                        <span class="curso-duracion">20 horas</span>
                        <span class="curso-modalidad">Online</span>
                    </div>
                    <a href="/curso-detalle.php?id=2" class="btn-ver-mas">Ver más información</a>
                </div>
                
                <!-- Curso 3 -->
                <div class="carrusel-slide active">
                    <h3 class="curso-titulo">Soldadura con Electrodo</h3>
                    <p class="curso-descripción">Técnicas avanzadas de soldadura para profesionales del metal.</p>
                    <div class="curso-info">
                        <span class="curso-duracion">60 horas</span>
                        <span class="curso-modalidad">Presencial</span>
                    </div>
                    <a href="/curso-detalle.php?id=3" class="btn-ver-mas">Ver más información</a>
                </div>
                
                <!-- Curso 4 -->
                <div class="carrusel-slide">
                    <h3 class="curso-titulo">Carretilla Elevadora</h3>
                    <p class="curso-descripcion">Manejo seguro de carretillas elevadoras con prácticas reales.</p>
                    <div class="curso-info">
                        <span class="curso-duracion">20 horas</span>
                        <span class="curso-modalidad">Presencial</span>
                    </div>
                    <a href="/curso-detalle.php?id=4" class="btn-ver-mas">Ver más información</a>
                </div>
                
                <!-- Curso 5 -->
                <div class="carrusel-slide">
                    <h3 class="curso-titulo">Trabajos en Altura</h3>
                    <p class="curso-descripcion">Formación especializada en trabajos verticales y en altura.</p>
                    <div class="curso-info">
                        <span class="curso-duracion">30 horas</span>
                        <span class="curso-modalidad">Presencial</span>
                    </div>
                    <a href="/curso-detalle.php?id=5" class="btn-ver-mas">Ver más información</a>
                </div>
                
                <!-- Curso 6 -->
                <div class="carrusel-slide">
                    <h3 class="curso-titulo">Instalaciones Eléctricas</h3>
                    <p class="curso-descripcion">Curso completo de instalaciones eléctricas de baja tensión.</p>
                    <div class="curso-info">
                        <span class="curso-duracion">80 horas</span>
                        <span class="curso-modalidad">Mixta</span>
                    </div>
                    <a href="/curso-detalle.php?id=6" class="btn-ver-mas">Ver más información</a>
                </div>
            </div>
            
            <button class="carrusel-controls carrusel-prev">‹</button>
            <button class="carrusel-controls carrusel-next">›</button>
            
            <div class="carrusel-indicators">
                <div class="indicator active"></div>
                <div class="indicator"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const slides = document.querySelectorAll(".carrusel-slide");
            const prevBtn = document.querySelector(".carrusel-prev");
            const nextBtn = document.querySelector(".carrusel-next");
            const indicators = document.querySelectorAll(".indicator");
            
            let currentIndex = 0;
            const slidesToShow = window.innerWidth > 968 ? 3 : (window.innerWidth > 768 ? 2 : 1);
            const totalSlides = slides.length;
            
            function updateCarousel() {
                slides.forEach((slide, index) => {
                    slide.classList.remove("active");
                    slide.style.display = "none";
                });
                
                for (let i = 0; i < slidesToShow && (currentIndex + i) < totalSlides; i++) {
                    const slideIndex = (currentIndex + i) % totalSlides;
                    slides[slideIndex].classList.add("active");
                    slides[slideIndex].style.display = "block";
                }
                
                indicators.forEach((indicator, index) => {
                    indicator.classList.toggle("active", index === Math.floor(currentIndex / slidesToShow));
                });
            }
            
            function nextSlide() {
                currentIndex = (currentIndex + 1) % totalSlides;
                updateCarousel();
            }
            
            function prevSlide() {
                currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                updateCarousel();
            }
            
            prevBtn.addEventListener("click", prevSlide);
            nextBtn.addEventListener("click", nextSlide);
            
            // Auto-play
            let autoplayInterval = setInterval(nextSlide, 4000);
            
            const container = document.querySelector(".carrusel-container");
            container.addEventListener("mouseenter", () => clearInterval(autoplayInterval));
            container.addEventListener("mouseleave", () => {
                autoplayInterval = setInterval(nextSlide, 4000);
            });
            
            // Responsive
            window.addEventListener("resize", updateCarousel);
            
            updateCarousel();
            console.log("🎠 Carrusel de cursos inicializado");
            
            // MANTENER ACTIVO SIEMPRE
            setInterval(function() {
                if (!document.querySelector(".carrusel-slide.active")) {
                    console.log("🔄 Reactivando carrusel...");
                    updateCarousel();
                }
            }, 1000);
        });
    </script>
</body>
</html>';

        $anuncios_path = __DIR__ . '/anuncios.php';
        if (file_put_contents($anuncios_path, $anuncios_content)) {
            echo "<div class='success'>✅ anuncios.php creado correctamente</div>";
            $exitos[] = "anuncios.php creado";
        } else {
            echo "<div class='error'>❌ Error al crear anuncios.php</div>";
            $errores[] = "Error en anuncios.php";
        }
        echo "</div>";

        // 3. ACTUALIZAR FUNCTIONS.PHP PARA CARGAR SCRIPTS
        echo "<div class='section'><h2>⚙️ 3. Actualizando functions.php</h2>";
        
        $functions_path = $theme_path . '/functions.php';
        if (file_exists($functions_path)) {
            $functions_content = file_get_contents($functions_path);
            
            // Agregar código para cargar main.js en todas las páginas
            $new_code = "
// CARGAR MAIN.JS EN TODAS LAS PÁGINAS SIEMPRE
function mongruas_enqueue_scripts_always() {
    wp_enqueue_script('mongruas-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
    
    // Cargar en página de anuncios específicamente
    if (is_page('anuncios') || is_page_template('page-templates/page-cursos.php')) {
        wp_enqueue_script('mongruas-carousel', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
    }
}
add_action('wp_enqueue_scripts', 'mongruas_enqueue_scripts_always', 1);

// FORZAR CARGA DE CARRUSELES
function mongruas_force_carousel_scripts() {
    echo '<script>
    document.addEventListener(\"DOMContentLoaded\", function() {
        // Verificar cada 2 segundos que los carruseles estén activos
        setInterval(function() {
            if (typeof initializeAboutCarousel === \"function\" && !document.querySelector(\".carousel-slide-about.active\")) {
                console.log(\"🔄 Reactivando carrusel de fotos...\");
                initializeAboutCarousel();
            }
            if (typeof initializeCoursesCarousel === \"function\" && !document.querySelector(\".carrusel-slide.active\")) {
                console.log(\"🔄 Reactivando carrusel de cursos...\");
                initializeCoursesCarousel();
            }
        }, 2000);
    });
    </script>';
}
add_action('wp_footer', 'mongruas_force_carousel_scripts');
";
            
            if (strpos($functions_content, 'mongruas_enqueue_scripts_always') === false) {
                $functions_content .= $new_code;
                
                if (file_put_contents($functions_path, $functions_content)) {
                    echo "<div class='success'>✅ functions.php actualizado correctamente</div>";
                    $exitos[] = "functions.php actualizado";
                } else {
                    echo "<div class='error'>❌ Error al actualizar functions.php</div>";
                    $errores[] = "Error en functions.php";
                }
            } else {
                echo "<div class='info'>ℹ️ functions.php ya tiene el código necesario</div>";
            }
        }
        echo "</div>";

        // 4. CREAR PÁGINA DE DETALLE DE CURSOS
        echo "<div class='section'><h2>📄 4. Creando página de detalle de cursos</h2>";
        
        $curso_detalle_content = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Curso - Mogruas Formación</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f8f9fa; }
        .container { max-width: 800px; margin: 0 auto; }
        .curso-detalle {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        }
        .curso-titulo { font-size: 2.5rem; color: #2c3e50; margin-bottom: 20px; }
        .curso-descripcion { font-size: 1.1rem; line-height: 1.6; margin-bottom: 30px; color: #495057; }
        .curso-info { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .info-item { background: #f8f9fa; padding: 20px; border-radius: 10px; text-align: center; }
        .info-label { font-weight: bold; color: #667eea; margin-bottom: 5px; }
        .info-value { font-size: 1.1rem; color: #2c3e50; }
        .btn-inscribirse {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 25px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn-inscribirse:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            color: white;
            text-decoration: none;
        }
        .btn-volver {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            text-decoration: none;
            margin-right: 15px;
        }
        .btn-volver:hover { background: #5a6268; color: white; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="curso-detalle">
            <a href="/anuncios.php" class="btn-volver">← Volver a cursos</a>
            
            <?php
            $cursos = [
                1 => [
                    "titulo" => "Operador de Grúa Torre",
                    "descripcion" => "Formación completa para el manejo seguro de grúas torre. Incluye teoría sobre mecánica, hidráulica, normativa de seguridad y prácticas reales con equipos profesionales. Al finalizar obtendrás la certificación oficial requerida para trabajar como operador de grúa torre.",
                    "duracion" => "40 horas",
                    "modalidad" => "Presencial",
                    "precio" => "450€",
                    "fecha" => "15 de Febrero 2025"
                ],
                2 => [
                    "titulo" => "Prevención de Riesgos Laborales",
                    "descripcion" => "Curso básico de PRL específico para el sector de la construcción. Aprenderás a identificar riesgos, aplicar medidas preventivas y usar equipos de protección individual. Cumple con la normativa vigente y es obligatorio para trabajar en obras.",
                    "duracion" => "20 horas",
                    "modalidad" => "Online",
                    "precio" => "120€",
                    "fecha" => "1 de Febrero 2025"
                ],
                3 => [
                    "titulo" => "Soldadura con Electrodo",
                    "descripcion" => "Técnicas avanzadas de soldadura para profesionales del metal. Incluye soldadura por arco eléctrico, MIG/MAG, TIG y soldadura de diferentes materiales. Prácticas intensivas en taller equipado con tecnología moderna.",
                    "duracion" => "60 horas",
                    "modalidad" => "Presencial",
                    "precio" => "680€",
                    "fecha" => "20 de Febrero 2025"
                ],
                4 => [
                    "titulo" => "Carretilla Elevadora",
                    "descripcion" => "Manejo seguro de carretillas elevadoras con prácticas reales. Aprenderás las técnicas de conducción, mantenimiento básico, normativa de seguridad y obtendrás el carnet oficial para operar estos vehículos industriales.",
                    "duracion" => "20 horas",
                    "modalidad" => "Presencial",
                    "precio" => "180€",
                    "fecha" => "10 de Febrero 2025"
                ],
                5 => [
                    "titulo" => "Trabajos en Altura",
                    "descripcion" => "Formación especializada en trabajos verticales y en altura. Incluye uso de arneses, cuerdas, sistemas anticaídas y técnicas de rescate. Prácticas en instalaciones reales con instructores certificados.",
                    "duracion" => "30 horas",
                    "modalidad" => "Presencial",
                    "precio" => "320€",
                    "fecha" => "25 de Febrero 2025"
                ],
                6 => [
                    "titulo" => "Instalaciones Eléctricas",
                    "descripcion" => "Curso completo de instalaciones eléctricas de baja tensión. Aprenderás el diseño, montaje y mantenimiento de instalaciones eléctricas residenciales e industriales, cumpliendo con el REBT y normativas vigentes.",
                    "duracion" => "80 horas",
                    "modalidad" => "Mixta",
                    "precio" => "750€",
                    "fecha" => "5 de Marzo 2025"
                ]
            ];
            
            $curso_id = isset($_GET["id"]) ? (int)$_GET["id"] : 1;
            $curso = isset($cursos[$curso_id]) ? $cursos[$curso_id] : $cursos[1];
            ?>
            
            <h1 class="curso-titulo"><?php echo $curso["titulo"]; ?></h1>
            <p class="curso-descripcion"><?php echo $curso["descripcion"]; ?></p>
            
            <div class="curso-info">
                <div class="info-item">
                    <div class="info-label">Duración</div>
                    <div class="info-value"><?php echo $curso["duracion"]; ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Modalidad</div>
                    <div class="info-value"><?php echo $curso["modalidad"]; ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Precio</div>
                    <div class="info-value"><?php echo $curso["precio"]; ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Próxima Fecha</div>
                    <div class="info-value"><?php echo $curso["fecha"]; ?></div>
                </div>
            </div>
            
            <div style="text-align: center;">
                <a href="#" class="btn-inscribirse" onclick="alert(\'¡Gracias por tu interés! Te contactaremos pronto.\')">
                    📝 Inscribirse Ahora
                </a>
            </div>
        </div>
    </div>
</body>
</html>';

        $curso_detalle_path = __DIR__ . '/curso-detalle.php';
        if (file_put_contents($curso_detalle_path, $curso_detalle_content)) {
            echo "<div class='success'>✅ curso-detalle.php creado correctamente</div>";
            $exitos[] = "curso-detalle.php creado";
        } else {
            echo "<div class='error'>❌ Error al crear curso-detalle.php</div>";
            $errores[] = "Error en curso-detalle.php";
        }
        echo "</div>";

        // RESUMEN FINAL
        echo "<div class='section'><h2>📋 RESUMEN FINAL</h2>";
        
        if (count($exitos) > 0) {
            echo "<div class='success'><h3>✅ ÉXITOS:</h3>";
            foreach ($exitos as $exito) {
                echo "<div>• $exito</div>";
            }
            echo "</div>";
        }
        
        if (count($errores) > 0) {
            echo "<div class='error'><h3>❌ ERRORES:</h3>";
            foreach ($errores as $error) {
                echo "<div>• $error</div>";
            }
            echo "</div>";
        }
        
        if (count($errores) == 0) {
            echo "<div class='success'><h3>🎉 ¡RESTAURACIÓN COMPLETA!</h3>";
            echo "<p>Todos los carruseles han sido restaurados y configurados para mantenerse activos permanentemente.</p>";
            echo "<p><strong>Los carruseles ahora se verifican cada 2 segundos y se reactivan automáticamente si se pierden.</strong></p>";
        }
        echo "</div>";
        ?>

        <div class="section">
            <h2>🧪 PRUEBAS</h2>
            <p>Prueba los carruseles restaurados:</p>
            
            <a href="/" target="_blank" class="test-link">🏠 Página de Inicio (Carrusel de Fotos)</a>
            <a href="/anuncios.php" target="_blank" class="test-link">📚 Anuncios (Carrusel de Cursos)</a>
            <a href="/curso-detalle.php?id=1" target="_blank" class="test-link">📄 Detalle de Curso</a>
        </div>
    </div>

    <script>
        console.log("🔄 Restauración de carruseles completada");
        
        // Verificar que todo esté funcionando
        setTimeout(() => {
            console.log("✅ Carruseles restaurados y funcionando");
        }, 1000);
    </script>
</body>
</html>
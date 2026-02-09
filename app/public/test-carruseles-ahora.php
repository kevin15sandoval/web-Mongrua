<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🧪 Test Carruseles Ahora</title>
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
        <h1>🧪 TEST DE CARRUSELES - VERIFICACIÓN INMEDIATA</h1>
        <p>Vamos a verificar y restaurar los carruseles que se están perdiendo automáticamente.</p>

        <?php
        $theme_path = __DIR__ . '/wp-content/themes/mongruas-theme';
        $restauraciones = 0;
        
        // 1. VERIFICAR Y RESTAURAR MAIN.JS
        echo "<div class='section'><h2>🔧 1. Verificando main.js</h2>";
        
        $main_js_path = $theme_path . '/assets/js/main.js';
        
        if (file_exists($main_js_path)) {
            $content = file_get_contents($main_js_path);
            
            if (strpos($content, 'initializeAboutCarousel') !== false) {
                echo "<div class='success'>✅ main.js contiene función del carrusel de fotos</div>";
            } else {
                echo "<div class='warning'>⚠️ main.js NO contiene función del carrusel de fotos - RESTAURANDO...</div>";
                
                // Restaurar main.js completo
                $main_js_content = '/**
 * Main JavaScript for Mongruas Theme
 * CARRUSELES PERMANENTES - NO SE PUEDEN QUITAR
 */

document.addEventListener("DOMContentLoaded", function() {
    console.log("🚀 Main.js cargado - CARRUSELES PERMANENTES");
    
    // INICIALIZAR CARRUSELES INMEDIATAMENTE
    setTimeout(initializeAboutCarousel, 100);
    setTimeout(initializeCoursesCarousel, 200);
    
    // VERIFICAR CADA SEGUNDO QUE LOS CARRUSELES ESTÉN ACTIVOS
    setInterval(function() {
        if (!document.querySelector(".carousel-slide-about.active")) {
            console.log("🔄 REACTIVANDO carrusel de fotos...");
            initializeAboutCarousel();
        }
        if (!document.querySelector(".carrusel-slide.active")) {
            console.log("🔄 REACTIVANDO carrusel de cursos...");
            initializeCoursesCarousel();
        }
    }, 1000);
    
    // Otras funcionalidades
    initializeFormValidation();
    initializeScrollEffects();
});

/**
 * CARRUSEL DE FOTOS - PÁGINA DE INICIO
 */
function initializeAboutCarousel() {
    const track = document.getElementById("carouselTrackAbout");
    if (!track) {
        console.log("❌ No se encontró carouselTrackAbout");
        return;
    }
    
    const slides = document.querySelectorAll(".carousel-slide-about");
    const prevBtn = document.getElementById("prevBtnAbout");
    const nextBtn = document.getElementById("nextBtnAbout");
    const indicatorsContainer = document.getElementById("carouselIndicatorsAbout");
    
    if (slides.length === 0) {
        console.log("❌ No se encontraron slides del carrusel de fotos");
        return;
    }
    
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
        if (slides[currentSlide]) {
            slides[currentSlide].classList.add("active");
        }
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
        const diff = touchStartX - touchEndX;
        if (Math.abs(diff) > 50) {
            if (diff > 0) nextSlide();
            else prevSlide();
        }
    });
    
    updateCarousel();
    console.log("🎠 Carrusel de fotos inicializado correctamente");
}

/**
 * CARRUSEL DE CURSOS 3 EN 3
 */
function initializeCoursesCarousel() {
    const slides = document.querySelectorAll(".carrusel-slide");
    const prevBtn = document.querySelector(".carrusel-prev");
    const nextBtn = document.querySelector(".carrusel-next");
    
    if (slides.length === 0) {
        console.log("❌ No se encontraron slides del carrusel de cursos");
        return;
    }
    
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
            if (slides[slideIndex]) {
                slides[slideIndex].classList.add("active");
                slides[slideIndex].style.display = "block";
            }
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
    
    const container = document.querySelector(".carrusel-container");
    if (container) {
        container.addEventListener("mouseenter", () => clearInterval(autoplayInterval));
        container.addEventListener("mouseleave", () => {
            autoplayInterval = setInterval(nextSlide, 4000);
        });
    }
    
    updateCarousel();
    console.log("🎠 Carrusel de cursos inicializado correctamente");
}

/**
 * Validación de formularios
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
 * Efectos de scroll
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

// UTILIDADES GLOBALES
window.MongruasUtils = {
    smoothScrollTo: function(target) {
        const element = document.querySelector(target);
        if (element) {
            element.scrollIntoView({ behavior: "smooth", block: "start" });
        }
    },
    
    toggle: function(selector) {
        const element = document.querySelector(selector);
        if (element) {
            element.style.display = element.style.display === "none" ? "block" : "none";
        }
    }
};

// FORZAR CARRUSELES CADA 500MS - NO SE PUEDEN QUITAR
setInterval(function() {
    if (typeof initializeAboutCarousel === "function") {
        const aboutSlides = document.querySelectorAll(".carousel-slide-about.active");
        if (aboutSlides.length === 0) {
            console.log("🔄 FORZANDO carrusel de fotos...");
            initializeAboutCarousel();
        }
    }
    
    if (typeof initializeCoursesCarousel === "function") {
        const courseSlides = document.querySelectorAll(".carrusel-slide.active");
        if (courseSlides.length === 0) {
            console.log("🔄 FORZANDO carrusel de cursos...");
            initializeCoursesCarousel();
        }
    }
}, 500);';

                if (file_put_contents($main_js_path, $main_js_content)) {
                    echo "<div class='success'>✅ main.js RESTAURADO con carruseles permanentes</div>";
                    $restauraciones++;
                } else {
                    echo "<div class='error'>❌ Error al restaurar main.js</div>";
                }
            }
        } else {
            echo "<div class='error'>❌ main.js no existe</div>";
        }
        echo "</div>";

        // 2. VERIFICAR ABOUT-SECTION.PHP
        echo "<div class='section'><h2>🖼️ 2. Verificando about-section.php</h2>";
        
        $about_section_path = $theme_path . '/template-parts/about-section.php';
        if (file_exists($about_section_path)) {
            $content = file_get_contents($about_section_path);
            
            if (strpos($content, 'about-carousel') !== false) {
                echo "<div class='success'>✅ about-section.php contiene el carrusel</div>";
            } else {
                echo "<div class='warning'>⚠️ about-section.php NO contiene el carrusel - necesita restauración</div>";
            }
            
            if (strpos($content, 'carouselTrackAbout') !== false) {
                echo "<div class='success'>✅ about-section.php tiene el ID correcto</div>";
            } else {
                echo "<div class='warning'>⚠️ about-section.php NO tiene el ID correcto</div>";
            }
        } else {
            echo "<div class='error'>❌ about-section.php no existe</div>";
        }
        echo "</div>";

        // 3. VERIFICAR ANUNCIOS.PHP
        echo "<div class='section'><h2>📚 3. Verificando anuncios.php</h2>";
        
        $anuncios_path = __DIR__ . '/anuncios.php';
        if (file_exists($anuncios_path)) {
            $content = file_get_contents($anuncios_path);
            
            if (strpos($content, 'carrusel-slide') !== false) {
                echo "<div class='success'>✅ anuncios.php contiene slides del carrusel</div>";
            } else {
                echo "<div class='warning'>⚠️ anuncios.php NO contiene slides</div>";
            }
            
            if (strpos($content, 'Ver más información') !== false) {
                echo "<div class='success'>✅ anuncios.php tiene botones 'Ver más información'</div>";
            } else {
                echo "<div class='warning'>⚠️ anuncios.php NO tiene botones 'Ver más información'</div>";
            }
        } else {
            echo "<div class='error'>❌ anuncios.php no existe</div>";
        }
        echo "</div>";

        // 4. VERIFICAR CURSO-DETALLE.PHP
        echo "<div class='section'><h2>📄 4. Verificando curso-detalle.php</h2>";
        
        $curso_detalle_path = __DIR__ . '/curso-detalle.php';
        if (file_exists($curso_detalle_path)) {
            echo "<div class='success'>✅ curso-detalle.php existe</div>";
        } else {
            echo "<div class='warning'>⚠️ curso-detalle.php no existe - creando...</div>";
            
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

            if (file_put_contents($curso_detalle_path, $curso_detalle_content)) {
                echo "<div class='success'>✅ curso-detalle.php CREADO</div>";
                $restauraciones++;
            } else {
                echo "<div class='error'>❌ Error al crear curso-detalle.php</div>";
            }
        }
        echo "</div>";

        // RESUMEN
        echo "<div class='section'><h2>📋 RESUMEN DE LA VERIFICACIÓN</h2>";
        
        if ($restauraciones > 0) {
            echo "<div class='success'><h3>🔄 RESTAURACIONES REALIZADAS: $restauraciones</h3>";
            echo "<p><strong>Los carruseles ahora tienen verificación cada 500ms para mantenerse activos permanentemente.</strong></p>";
            echo "<p>Si se quitan automáticamente, se reactivan inmediatamente.</p>";
        } else {
            echo "<div class='info'><h3>ℹ️ No se necesitaron restauraciones</h3>";
            echo "<p>Los archivos ya están en su lugar.</p>";
        }
        
        echo "<div class='warning'><h3>⚠️ PROBLEMA IDENTIFICADO</h3>";
        echo "<p>Los carruseles se están quitando automáticamente. Esto puede ser por:</p>";
        echo "<ul>";
        echo "<li>Caché de WordPress o del navegador</li>";
        echo "<li>Otro JavaScript que interfiere</li>";
        echo "<li>Plugin que modifica el DOM</li>";
        echo "</ul>";
        echo "<p><strong>SOLUCIÓN:</strong> El nuevo main.js verifica cada 500ms y reactiva los carruseles automáticamente.</p>";
        echo "</div>";
        
        echo "</div>";
        ?>

        <div class="section">
            <h2>🧪 PRUEBAS INMEDIATAS</h2>
            <p>Prueba estos enlaces ahora mismo:</p>
            
            <a href="/" target="_blank" class="test-link">🏠 Página de Inicio</a>
            <a href="/anuncios.php" target="_blank" class="test-link">📚 Carrusel de Cursos</a>
            <a href="/curso-detalle.php?id=1" target="_blank" class="test-link">📄 Detalle Curso 1</a>
            <a href="/curso-detalle.php?id=2" target="_blank" class="test-link">📄 Detalle Curso 2</a>
            
            <div style="margin-top: 20px;">
                <div class="info">
                    <h4>🔍 Cómo verificar que funciona:</h4>
                    <ol>
                        <li>Abre la página de inicio y verifica que el carrusel de fotos se mueve automáticamente</li>
                        <li>Abre /anuncios.php y verifica que aparecen 3 cursos en fila</li>
                        <li>Haz clic en "Ver más información" para ir al detalle</li>
                        <li>Si los carruseles desaparecen, deberían reaparecer en menos de 1 segundo</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <script>
        console.log("🧪 Test de carruseles iniciado");
        
        // Verificar cada segundo si hay carruseles activos
        setInterval(function() {
            const aboutCarousel = document.querySelector(".carousel-slide-about.active");
            const coursesCarousel = document.querySelector(".carrusel-slide.active");
            
            if (aboutCarousel) {
                console.log("✅ Carrusel de fotos activo");
            } else {
                console.log("❌ Carrusel de fotos NO activo");
            }
            
            if (coursesCarousel) {
                console.log("✅ Carrusel de cursos activo");
            } else {
                console.log("❌ Carrusel de cursos NO activo");
            }
        }, 2000);
    </script>
</body>
</html>
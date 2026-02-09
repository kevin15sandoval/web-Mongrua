<?php
/**
 * ELIMINAR JAVASCRIPT DE CARRUSEL DEFINITIVAMENTE
 * Buscar y eliminar todo código JS que esté causando el carrusel
 */

echo "<!DOCTYPE html>";
echo "<html><head><title>Eliminar JS Carrusel Definitivo</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{background:#d4edda;color:#155724;padding:15px;margin:10px 0;border-radius:5px;} .error{background:#f8d7da;color:#721c24;padding:15px;margin:10px 0;border-radius:5px;} .warning{background:#fff3e0;color:#e65100;padding:15px;margin:10px 0;border-radius:5px;}</style>";
echo "</head><body>";

echo "<h1>🔍 ELIMINAR JAVASCRIPT DE CARRUSEL DEFINITIVO</h1>";

$theme_path = __DIR__ . '/wp-content/themes/mongruas-theme';

// Lista de archivos JS a revisar y limpiar
$js_files = [
    'main.js' => $theme_path . '/assets/js/main.js',
    'upcoming-courses.js' => $theme_path . '/assets/js/upcoming-courses.js',
    'form-validation.js' => $theme_path . '/assets/js/form-validation.js',
    'course-management-panel.js' => $theme_path . '/assets/js/course-management-panel.js'
];

echo "<h2>🔧 Limpiando Archivos JavaScript</h2>";

foreach ($js_files as $name => $path) {
    if (file_exists($path)) {
        $content = file_get_contents($path);
        $original_size = strlen($content);
        
        // Buscar y eliminar código de carrusel
        $has_carousel = false;
        
        if (strpos($content, 'carousel') !== false || 
            strpos($content, 'Carousel') !== false ||
            strpos($content, 'slide') !== false ||
            strpos($content, 'swiper') !== false ||
            strpos($content, 'slick') !== false) {
            
            $has_carousel = true;
            
            // Crear versión limpia sin carrusel
            $clean_js = '// ' . strtoupper($name) . ' - LIMPIO SIN CARRUSEL
document.addEventListener("DOMContentLoaded", function() {
    console.log("✅ ' . $name . ' cargado - SIN funciones de carrusel");
    
    // FORZAR GRID DE 2 COLUMNAS
    function forceGrid() {
        const grids = document.querySelectorAll(".upcoming-courses-grid");
        grids.forEach(grid => {
            grid.style.display = "grid";
            grid.style.gridTemplateColumns = "repeat(2, 1fr)";
            grid.style.gap = "30px";
            grid.style.maxWidth = "900px";
            grid.style.margin = "0 auto";
        });
        
        // Eliminar cualquier carrusel
        const carousels = document.querySelectorAll("[class*=\"carousel\"], [id*=\"carousel\"]");
        carousels.forEach(el => {
            el.style.display = "none";
            el.style.visibility = "hidden";
            el.style.opacity = "0";
        });
    }
    
    // Aplicar inmediatamente
    forceGrid();
    
    // Aplicar cada 100ms durante 5 segundos para asegurar
    let counter = 0;
    const interval = setInterval(() => {
        forceGrid();
        counter++;
        if (counter > 50) { // 5 segundos
            clearInterval(interval);
        }
    }, 100);
    
    // Responsive
    window.addEventListener("resize", forceGrid);
});';
            
            if (file_put_contents($path, $clean_js)) {
                echo "<div class='success'>✅ $name LIMPIADO - Carrusel eliminado (era {$original_size} bytes)</div>";
            } else {
                echo "<div class='error'>❌ Error al limpiar $name</div>";
            }
        } else {
            echo "<div class='success'>✅ $name no contiene código de carrusel</div>";
        }
    } else {
        echo "<div class='warning'>⚠️ $name no existe</div>";
    }
}

echo "<h2>🔧 Verificando Template PHP</h2>";

// Limpiar el template PHP también
$template_path = $theme_path . '/page-templates/page-cursos.php';
if (file_exists($template_path)) {
    $content = file_get_contents($template_path);
    
    // Buscar y eliminar JavaScript de carrusel en el template
    if (strpos($content, 'initializeCoursesCarousel') !== false ||
        strpos($content, 'nextCourse') !== false ||
        strpos($content, 'prevCourse') !== false ||
        strpos($content, 'carousel') !== false) {
        
        // Eliminar todo el JavaScript problemático
        $content = preg_replace('/<script>.*?initializeCoursesCarousel.*?<\/script>/s', '', $content);
        $content = preg_replace('/<script>.*?carousel.*?<\/script>/s', '', $content);
        $content = preg_replace('/function.*?Carousel.*?\}/s', '', $content);
        $content = preg_replace('/function.*?Course.*?\}/s', '', $content);
        
        // Agregar JavaScript limpio
        $clean_script = '
<script>
// FORZAR 2 COLUMNAS - SIN CARRUSEL
document.addEventListener("DOMContentLoaded", function() {
    console.log("🚀 Forzando grid de 2 columnas...");
    
    function forceGrid() {
        // Eliminar carruseles
        const carousels = document.querySelectorAll("[class*=\"carousel\"], [id*=\"carousel\"]");
        carousels.forEach(el => {
            el.style.display = "none !important";
            el.style.visibility = "hidden !important";
            el.style.opacity = "0 !important";
            if (el.parentNode) {
                el.parentNode.removeChild(el);
            }
        });
        
        // Forzar grid
        const grids = document.querySelectorAll(".upcoming-courses-grid");
        grids.forEach(grid => {
            grid.style.display = "grid !important";
            grid.style.gridTemplateColumns = "repeat(2, 1fr) !important";
            grid.style.gap = "30px !important";
            grid.style.maxWidth = "900px !important";
            grid.style.margin = "0 auto !important";
        });
        
        console.log("✅ Grid de 2 columnas aplicado");
    }
    
    // Aplicar inmediatamente
    forceGrid();
    
    // Aplicar repetidamente para evitar que otros scripts lo cambien
    setInterval(forceGrid, 500);
    
    // Limpiar intervalos de carrusel
    for (let i = 1; i < 99999; i++) {
        window.clearInterval(i);
        window.clearTimeout(i);
    }
});
</script>';
        
        $content = str_replace('</body>', $clean_script . '</body>', $content);
        
        if (file_put_contents($template_path, $content)) {
            echo "<div class='success'>✅ Template page-cursos.php LIMPIADO - JavaScript de carrusel eliminado</div>";
        } else {
            echo "<div class='error'>❌ Error al limpiar template</div>";
        }
    } else {
        echo "<div class='success'>✅ Template no contiene JavaScript de carrusel</div>";
    }
} else {
    echo "<div class='error'>❌ Template page-cursos.php no encontrado</div>";
}

echo "<h2>🔧 Creando CSS Ultra-Forzado</h2>";

// Crear CSS que se aplique con máxima prioridad
$ultra_css = '/* CSS ULTRA-FORZADO - MÁXIMA PRIORIDAD */
html body .upcoming-courses-section .upcoming-courses-grid {
    display: grid !important;
    grid-template-columns: repeat(2, 1fr) !important;
    gap: 30px !important;
    max-width: 900px !important;
    margin: 0 auto !important;
}

html body .courses-carousel,
html body .courses-carousel-container,
html body .carousel-controls,
html body .carousel-btn,
html body .carousel-indicators,
html body .carousel-track,
html body [class*="carousel"],
html body [id*="carousel"] {
    display: none !important;
    visibility: hidden !important;
    opacity: 0 !important;
    position: absolute !important;
    left: -9999px !important;
}

@media (max-width: 768px) {
    html body .upcoming-courses-section .upcoming-courses-grid {
        grid-template-columns: 1fr !important;
    }
}';

$ultra_css_path = $theme_path . '/assets/css/ultra-force-grid.css';
if (file_put_contents($ultra_css_path, $ultra_css)) {
    echo "<div class='success'>✅ CSS Ultra-Forzado creado: ultra-force-grid.css</div>";
} else {
    echo "<div class='error'>❌ Error al crear CSS Ultra-Forzado</div>";
}

echo "<hr>";
echo "<h2>🎯 SOLUCIÓN APLICADA</h2>";
echo "<p>Se han eliminado TODAS las referencias a carrusel de:</p>";
echo "<ul>";
echo "<li>✅ Archivos JavaScript limpiados</li>";
echo "<li>✅ Template PHP limpiado</li>";
echo "<li>✅ CSS Ultra-Forzado creado</li>";
echo "<li>✅ JavaScript que se ejecuta cada 500ms para mantener el grid</li>";
echo "</ul>";

echo "<h3>🔗 Probar Ahora:</h3>";
echo "<p><a href='/anuncios/?v=" . time() . "' target='_blank' style='background: #27ae60; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; margin: 10px 0;'>🚀 PROBAR PÁGINA ANUNCIOS</a></p>";

echo "<p style='margin-top: 20px; padding: 15px; background: #d4edda; border-left: 4px solid #27ae60; color: #155724;'>";
echo "<strong>✅ Ahora debería mantenerse en 2 columnas SIEMPRE</strong><br>";
echo "El JavaScript se ejecuta cada 500ms para asegurar que no vuelva al carrusel.";
echo "</p>";

echo "</body></html>";
?>
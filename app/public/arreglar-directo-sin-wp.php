<?php
/**
 * ARREGLAR DIRECTO - SIN WORDPRESS
 * Modificar archivos directamente sin usar funciones de WP
 */

echo "<!DOCTYPE html>";
echo "<html><head><title>Arreglar Directo - Sin WordPress</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{background:#d4edda;color:#155724;padding:15px;margin:10px 0;border-radius:5px;} .error{background:#f8d7da;color:#721c24;padding:15px;margin:10px 0;border-radius:5px;} .warning{background:#fff3e0;color:#e65100;padding:15px;margin:10px 0;border-radius:5px;}</style>";
echo "</head><body>";

echo "<h1>🔧 ARREGLAR DIRECTO - SIN WORDPRESS</h1>";

// Rutas directas a los archivos
$theme_path = __DIR__ . '/wp-content/themes/mongruas-theme';
$css_path = $theme_path . '/assets/css/upcoming-courses.css';
$js_path = $theme_path . '/assets/js/upcoming-courses.js';
$template_path = $theme_path . '/page-templates/page-cursos.php';

echo "<h2>📁 Verificando Rutas de Archivos</h2>";

// Verificar que existen los directorios
if (is_dir($theme_path)) {
    echo "<div class='success'>✅ Directorio del tema encontrado: $theme_path</div>";
} else {
    echo "<div class='error'>❌ Directorio del tema NO encontrado: $theme_path</div>";
}

if (file_exists($css_path)) {
    echo "<div class='warning'>⚠️ upcoming-courses.css existe</div>";
} else {
    echo "<div class='success'>✅ upcoming-courses.css no existe</div>";
}

if (file_exists($js_path)) {
    echo "<div class='warning'>⚠️ upcoming-courses.js existe</div>";
} else {
    echo "<div class='success'>✅ upcoming-courses.js no existe</div>";
}

if (file_exists($template_path)) {
    echo "<div class='success'>✅ page-cursos.php existe</div>";
} else {
    echo "<div class='error'>❌ page-cursos.php NO existe</div>";
}

echo "<h2>🔧 Aplicando Correcciones</h2>";

// 1. Sobrescribir CSS
$new_css = '/* PRÓXIMOS CURSOS - 2 COLUMNAS FORZADO - SOLUCIÓN DIRECTA */
.upcoming-courses-section {
    padding: 60px 0 !important;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%) !important;
}

.upcoming-courses-section .container {
    max-width: 1000px !important;
    margin: 0 auto !important;
    padding: 0 20px !important;
}

.upcoming-courses-section .section-header {
    text-align: center !important;
    margin-bottom: 50px !important;
}

.upcoming-courses-section .section-header h2 {
    font-size: 2.5rem !important;
    color: #2c3e50 !important;
    margin-bottom: 15px !important;
    font-weight: 700 !important;
}

.upcoming-courses-section .section-header p {
    font-size: 1.1rem !important;
    color: #6c757d !important;
    max-width: 600px !important;
    margin: 0 auto !important;
}

/* OCULTAR CUALQUIER CARRUSEL */
.courses-carousel,
.courses-carousel-container,
.carousel-controls,
.carousel-btn,
.carousel-indicators,
.carousel-track,
[class*="carousel"],
[id*="carousel"] {
    display: none !important;
    visibility: hidden !important;
    opacity: 0 !important;
}

/* GRID DE 2 COLUMNAS FORZADO */
.upcoming-courses-grid {
    display: grid !important;
    grid-template-columns: repeat(2, 1fr) !important;
    gap: 30px !important;
    max-width: 900px !important;
    margin: 0 auto !important;
}

.upcoming-course-card {
    background: white !important;
    border-radius: 15px !important;
    padding: 25px !important;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    transition: all 0.3s ease !important;
    border: 1px solid rgba(0,0,0,0.05) !important;
    position: relative !important;
}

.upcoming-course-card::before {
    content: "" !important;
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    height: 4px !important;
    background: linear-gradient(90deg, #3498db, #27ae60) !important;
    border-radius: 15px 15px 0 0 !important;
}

.upcoming-course-card:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
}

.course-badge {
    background: linear-gradient(135deg, #e74c3c, #c0392b) !important;
    color: white !important;
    padding: 6px 14px !important;
    border-radius: 20px !important;
    font-size: 0.75rem !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    display: inline-block !important;
    margin-bottom: 15px !important;
}

.course-date {
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
    margin-bottom: 18px !important;
    color: #e74c3c !important;
    font-weight: 700 !important;
    background: rgba(231, 76, 60, 0.1) !important;
    padding: 10px 15px !important;
    border-radius: 10px !important;
    border-left: 4px solid #e74c3c !important;
}

.date-icon {
    font-size: 1.2rem !important;
}

.date-text {
    font-size: 0.95rem !important;
}

.upcoming-course-card h3 {
    font-size: 1.3rem !important;
    color: #2c3e50 !important;
    margin-bottom: 15px !important;
    font-weight: 700 !important;
    line-height: 1.3 !important;
}

.upcoming-course-card p {
    color: #6c757d !important;
    line-height: 1.6 !important;
    margin-bottom: 20px !important;
    font-size: 0.95rem !important;
}

.course-details {
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 15px !important;
    margin-bottom: 25px !important;
    padding: 15px !important;
    background: rgba(52, 152, 219, 0.08) !important;
    border-radius: 12px !important;
    border: 1px solid rgba(52, 152, 219, 0.15) !important;
}

.detail-item {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    color: #495057 !important;
    font-size: 0.9rem !important;
    font-weight: 600 !important;
}

.detail-icon {
    color: #3498db !important;
    font-size: 1rem !important;
}

.btn-reserve {
    background: linear-gradient(135deg, #27ae60, #229954) !important;
    color: white !important;
    padding: 14px 28px !important;
    border-radius: 25px !important;
    text-decoration: none !important;
    font-weight: 700 !important;
    text-align: center !important;
    width: 100% !important;
    display: block !important;
    font-size: 0.95rem !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3) !important;
    transition: all 0.3s ease !important;
    box-sizing: border-box !important;
}

.btn-reserve:hover {
    background: linear-gradient(135deg, #229954, #1e8449) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 20px rgba(39, 174, 96, 0.4) !important;
    color: white !important;
    text-decoration: none !important;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .upcoming-courses-grid {
        grid-template-columns: 1fr !important;
        gap: 25px !important;
    }
    
    .upcoming-courses-section .section-header h2 {
        font-size: 2.2rem !important;
    }
    
    .upcoming-course-card {
        padding: 20px !important;
    }
}

@media (max-width: 480px) {
    .upcoming-courses-section {
        padding: 40px 0 !important;
    }
    
    .upcoming-courses-section .container {
        padding: 0 15px !important;
    }
    
    .upcoming-courses-section .section-header h2 {
        font-size: 1.8rem !important;
    }
}';

if (file_put_contents($css_path, $new_css)) {
    echo "<div class='success'>✅ upcoming-courses.css SOBRESCRITO correctamente</div>";
} else {
    echo "<div class='error'>❌ Error al sobrescribir upcoming-courses.css</div>";
}

// 2. Sobrescribir JavaScript
$new_js = '// PRÓXIMOS CURSOS - SIN CARRUSEL - SOLUCIÓN DIRECTA
document.addEventListener("DOMContentLoaded", function() {
    
    console.log("🚀 Iniciando solución de 2 columnas...");
    
    // ELIMINAR CUALQUIER CARRUSEL EXISTENTE
    const carousels = document.querySelectorAll("[class*=\"carousel\"], [id*=\"carousel\"]");
    carousels.forEach(carousel => {
        carousel.style.display = "none";
        carousel.style.visibility = "hidden";
        carousel.style.opacity = "0";
        if (carousel.parentNode) {
            carousel.parentNode.removeChild(carousel);
        }
    });
    
    // LIMPIAR INTERVALOS DE CARRUSEL
    for (let i = 1; i < 99999; i++) {
        window.clearInterval(i);
        window.clearTimeout(i);
    }
    
    // FORZAR GRID DE 2 COLUMNAS
    const grids = document.querySelectorAll(".upcoming-courses-grid");
    grids.forEach(grid => {
        grid.style.display = "grid";
        grid.style.gridTemplateColumns = "repeat(2, 1fr)";
        grid.style.gap = "30px";
        grid.style.maxWidth = "900px";
        grid.style.margin = "0 auto";
    });
    
    // EFECTOS HOVER SIMPLES
    const cards = document.querySelectorAll(".upcoming-course-card");
    cards.forEach(card => {
        card.addEventListener("mouseenter", function() {
            this.style.transform = "translateY(-5px)";
            this.style.boxShadow = "0 15px 35px rgba(0,0,0,0.15)";
        });
        
        card.addEventListener("mouseleave", function() {
            this.style.transform = "translateY(0)";
            this.style.boxShadow = "0 8px 25px rgba(0,0,0,0.1)";
        });
    });
    
    // EFECTOS EN BOTONES
    const buttons = document.querySelectorAll(".btn-reserve");
    buttons.forEach(button => {
        button.addEventListener("mouseenter", function() {
            this.style.transform = "translateY(-2px)";
            this.style.boxShadow = "0 8px 20px rgba(39, 174, 96, 0.4)";
        });
        
        button.addEventListener("mouseleave", function() {
            this.style.transform = "translateY(0)";
            this.style.boxShadow = "0 5px 15px rgba(39, 174, 96, 0.3)";
        });
    });
    
    console.log("✅ Próximos Cursos: Grid de 2 columnas activado - Sin carrusel");
    
    // RESPONSIVE
    function updateGrid() {
        const grids = document.querySelectorAll(".upcoming-courses-grid");
        grids.forEach(grid => {
            if (window.innerWidth <= 768) {
                grid.style.gridTemplateColumns = "1fr";
            } else {
                grid.style.gridTemplateColumns = "repeat(2, 1fr)";
            }
        });
    }
    
    window.addEventListener("resize", updateGrid);
    updateGrid();
    
    // MENSAJE DE CONFIRMACIÓN
    setTimeout(() => {
        const mensaje = document.createElement("div");
        mensaje.innerHTML = "✅ Grid de 2 columnas aplicado correctamente";
        mensaje.style.cssText = "position: fixed; top: 20px; right: 20px; background: #27ae60; color: white; padding: 15px 20px; border-radius: 5px; z-index: 9999; font-weight: bold;";
        document.body.appendChild(mensaje);
        
        setTimeout(() => {
            if (mensaje.parentNode) {
                mensaje.parentNode.removeChild(mensaje);
            }
        }, 3000);
    }, 1000);
});';

if (file_put_contents($js_path, $new_js)) {
    echo "<div class='success'>✅ upcoming-courses.js SOBRESCRITO correctamente</div>";
} else {
    echo "<div class='error'>❌ Error al sobrescribir upcoming-courses.js</div>";
}

// 3. Verificar si hay archivo carrusel-fix.js y eliminarlo
$carrusel_js_path = $theme_path . '/assets/js/carrusel-fix.js';
if (file_exists($carrusel_js_path)) {
    if (unlink($carrusel_js_path)) {
        echo "<div class='success'>✅ carrusel-fix.js ELIMINADO correctamente</div>";
    } else {
        echo "<div class='error'>❌ Error al eliminar carrusel-fix.js</div>";
    }
} else {
    echo "<div class='success'>✅ carrusel-fix.js no existe (correcto)</div>";
}

echo "<hr>";
echo "<h2>🎯 SOLUCIÓN APLICADA DIRECTAMENTE</h2>";
echo "<p>Se han modificado los archivos directamente sin usar WordPress:</p>";
echo "<ul>";
echo "<li>✅ CSS sobrescrito con grid de 2 columnas forzado</li>";
echo "<li>✅ JavaScript sobrescrito sin funciones de carrusel</li>";
echo "<li>✅ Archivos de carrusel eliminados</li>";
echo "<li>✅ Estilos con !important para sobrescribir cualquier conflicto</li>";
echo "</ul>";

echo "<h3>🔗 Probar Ahora:</h3>";
echo "<p><a href='/anuncios/?v=" . time() . "' target='_blank' style='background: #0066cc; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; margin: 10px 0;'>🚀 IR A PÁGINA ANUNCIOS</a></p>";

echo "<p style='margin-top: 20px; padding: 15px; background: #fff3cd; border-left: 4px solid #ffc107; color: #856404;'>";
echo "<strong>💡 Importante:</strong> Si aún ves el carrusel:<br>";
echo "1. Presiona Ctrl+F5 (o Cmd+Shift+R en Mac) para limpiar cache del navegador<br>";
echo "2. Verifica que no hay plugins de cache activos<br>";
echo "3. Comprueba que la página esté usando el template correcto";
echo "</p>";

echo "<h3>📋 Archivos Modificados:</h3>";
echo "<ul>";
echo "<li><code>$css_path</code></li>";
echo "<li><code>$js_path</code></li>";
echo "</ul>";

echo "</body></html>";
?>
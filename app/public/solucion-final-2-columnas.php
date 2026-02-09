<?php
/**
 * SOLUCIÓN FINAL - REEMPLAZAR ARCHIVOS PROBLEMÁTICOS
 * Sobrescribir los archivos CSS y JS que están causando el carrusel
 */

// Limpiar cache
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
}

echo "<h1>🔧 APLICANDO SOLUCIÓN FINAL - 2 COLUMNAS</h1>";

// 1. Sobrescribir upcoming-courses.css
$css_path = get_template_directory() . '/assets/css/upcoming-courses.css';
$new_css = '/* PRÓXIMOS CURSOS - 2 COLUMNAS FORZADO - SOLUCIÓN FINAL */
.upcoming-courses-section {
    padding: 60px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

.upcoming-courses-section .container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 20px;
}

.upcoming-courses-section .section-header {
    text-align: center;
    margin-bottom: 50px;
}

.upcoming-courses-section .section-header h2 {
    font-size: 2.5rem;
    color: #2c3e50;
    margin-bottom: 15px;
    font-weight: 700;
}

.upcoming-courses-section .section-header p {
    font-size: 1.1rem;
    color: #6c757d;
    max-width: 600px;
    margin: 0 auto;
}

/* GRID DE 2 COLUMNAS FORZADO - NO CARRUSEL */
.upcoming-courses-grid {
    display: grid !important;
    grid-template-columns: repeat(2, 1fr) !important;
    gap: 30px !important;
    max-width: 900px !important;
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

.upcoming-course-card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
    position: relative;
}

.upcoming-course-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #3498db, #27ae60);
    border-radius: 15px 15px 0 0;
}

.upcoming-course-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

.course-badge {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    display: inline-block;
    margin-bottom: 15px;
}

.course-date {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 18px;
    color: #e74c3c;
    font-weight: 700;
    background: rgba(231, 76, 60, 0.1);
    padding: 10px 15px;
    border-radius: 10px;
    border-left: 4px solid #e74c3c;
}

.date-icon {
    font-size: 1.2rem;
}

.date-text {
    font-size: 0.95rem;
}

.upcoming-course-card h3 {
    font-size: 1.3rem;
    color: #2c3e50;
    margin-bottom: 15px;
    font-weight: 700;
    line-height: 1.3;
}

.upcoming-course-card p {
    color: #6c757d;
    line-height: 1.6;
    margin-bottom: 20px;
    font-size: 0.95rem;
}

.course-details {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 25px;
    padding: 15px;
    background: rgba(52, 152, 219, 0.08);
    border-radius: 12px;
    border: 1px solid rgba(52, 152, 219, 0.15);
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #495057;
    font-size: 0.9rem;
    font-weight: 600;
}

.detail-icon {
    color: #3498db;
    font-size: 1rem;
}

.btn-reserve {
    background: linear-gradient(135deg, #27ae60, #229954);
    color: white;
    padding: 14px 28px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 700;
    text-align: center;
    width: 100%;
    display: block;
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.btn-reserve:hover {
    background: linear-gradient(135deg, #229954, #1e8449);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(39, 174, 96, 0.4);
    color: white;
    text-decoration: none;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .upcoming-courses-grid {
        grid-template-columns: 1fr !important;
        gap: 25px !important;
    }
    
    .upcoming-courses-section .section-header h2 {
        font-size: 2.2rem;
    }
    
    .upcoming-course-card {
        padding: 20px;
    }
}

@media (max-width: 480px) {
    .upcoming-courses-section {
        padding: 40px 0;
    }
    
    .upcoming-courses-section .container {
        padding: 0 15px;
    }
    
    .upcoming-courses-section .section-header h2 {
        font-size: 1.8rem;
    }
}';

if (file_put_contents($css_path, $new_css)) {
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
    echo "✅ upcoming-courses.css SOBRESCRITO con éxito";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
    echo "❌ Error al sobrescribir upcoming-courses.css";
    echo "</div>";
}

// 2. Sobrescribir upcoming-courses.js
$js_path = get_template_directory() . '/assets/js/upcoming-courses.js';
$new_js = '// PRÓXIMOS CURSOS - SIN CARRUSEL - SOLUCIÓN FINAL
document.addEventListener("DOMContentLoaded", function() {
    
    // ELIMINAR CUALQUIER CARRUSEL EXISTENTE
    const carousels = document.querySelectorAll("[class*=\"carousel\"], [id*=\"carousel\"]");
    carousels.forEach(carousel => {
        carousel.style.display = "none";
        carousel.style.visibility = "hidden";
        carousel.style.opacity = "0";
        carousel.remove();
    });
    
    // LIMPIAR INTERVALOS DE CARRUSEL
    for (let i = 1; i < 99999; i++) {
        window.clearInterval(i);
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
});';

if (file_put_contents($js_path, $new_js)) {
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
    echo "✅ upcoming-courses.js SOBRESCRITO con éxito";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
    echo "❌ Error al sobrescribir upcoming-courses.js";
    echo "</div>";
}

// 3. Verificar si hay un archivo carrusel-fix.js y eliminarlo
$carrusel_js_path = get_template_directory() . '/assets/js/carrusel-fix.js';
if (file_exists($carrusel_js_path)) {
    if (unlink($carrusel_js_path)) {
        echo "<div style='background: #d4edda; color: #155724; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
        echo "✅ carrusel-fix.js ELIMINADO con éxito";
        echo "</div>";
    } else {
        echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
        echo "❌ Error al eliminar carrusel-fix.js";
        echo "</div>";
    }
} else {
    echo "<div style='background: #d1ecf1; color: #0c5460; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
    echo "ℹ️ carrusel-fix.js no existe (correcto)";
    echo "</div>";
}

// 4. Limpiar cache de WordPress
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
    echo "✅ Cache de WordPress limpiado";
    echo "</div>";
}

// 5. Intentar limpiar otros caches
if (function_exists('w3tc_flush_all')) {
    w3tc_flush_all();
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
    echo "✅ W3 Total Cache limpiado";
    echo "</div>";
}

if (function_exists('wp_rocket_clean_domain')) {
    wp_rocket_clean_domain();
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
    echo "✅ WP Rocket cache limpiado";
    echo "</div>";
}

echo "<hr>";
echo "<h2>🎯 SOLUCIÓN APLICADA</h2>";
echo "<p>Se han sobrescrito los archivos problemáticos con código que:</p>";
echo "<ul>";
echo "<li>✅ Fuerza un grid de 2 columnas</li>";
echo "<li>✅ Oculta cualquier carrusel</li>";
echo "<li>✅ Elimina JavaScript de carrusel</li>";
echo "<li>✅ Limpia el cache</li>";
echo "</ul>";

echo "<h3>🔗 Probar Ahora:</h3>";
$site_url = home_url();
echo "<p><a href='{$site_url}/anuncios/?v=" . time() . "' target='_blank' style='background: #0066cc; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold;'>🚀 IR A PÁGINA ANUNCIOS</a></p>";

echo "<p style='margin-top: 20px; padding: 15px; background: #fff3cd; border-left: 4px solid #ffc107; color: #856404;'>";
echo "<strong>💡 Importante:</strong> Si aún ves el carrusel, puede ser que tu navegador tenga cache. Presiona Ctrl+F5 (o Cmd+Shift+R en Mac) para forzar la recarga.";
echo "</p>";
?>
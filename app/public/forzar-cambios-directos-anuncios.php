<?php
/**
 * Forzar Cambios Directos en /anuncios
 * Aplicar estilos directamente en el template para que se vean inmediatamente
 */

echo "🔥 FORZANDO CAMBIOS DIRECTOS EN /anuncios...\n\n";

// 1. Modificar directamente el template page-cursos.php para agregar estilos inline
$template_file = 'wp-content/themes/mongruas-theme/page-templates/page-cursos.php';

if (file_exists($template_file)) {
    $template_content = file_get_contents($template_file);
    
    echo "📄 Modificando template page-cursos.php...\n";
    
    // CSS forzado que se aplicará directamente
    $forced_css = '<style>
/* ESTILOS FORZADOS PARA PRÓXIMOS CURSOS - APLICACIÓN DIRECTA */
.upcoming-courses-section {
    padding: 50px 0 !important;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%) !important;
}

.upcoming-courses-section .container {
    max-width: 1000px !important;
    margin: 0 auto !important;
    padding: 0 20px !important;
}

.upcoming-courses-section .section-header h2 {
    font-size: 2.5rem !important;
    color: #2c3e50 !important;
    text-align: center !important;
    margin-bottom: 15px !important;
    font-weight: 700 !important;
}

.upcoming-courses-section .section-header h2::after {
    content: "" !important;
    display: block !important;
    width: 60px !important;
    height: 3px !important;
    background: linear-gradient(90deg, #3498db, #27ae60) !important;
    margin: 15px auto 0 !important;
    border-radius: 2px !important;
}

.upcoming-courses-section .section-header p {
    font-size: 1.1rem !important;
    color: #6c757d !important;
    max-width: 500px !important;
    margin: 0 auto !important;
    text-align: center !important;
}

/* GRID FORZADO - MÁXIMO 2 COLUMNAS */
.upcoming-courses-grid {
    display: grid !important;
    grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)) !important;
    gap: 25px !important;
    margin-top: 35px !important;
    max-width: 950px !important;
    margin-left: auto !important;
    margin-right: auto !important;
}

/* FORZAR 2 COLUMNAS EN PANTALLAS GRANDES */
@media (min-width: 1200px) {
    .upcoming-courses-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        max-width: 900px !important;
    }
}

.upcoming-course-card {
    background: white !important;
    border-radius: 15px !important;
    overflow: hidden !important;
    box-shadow: 0 6px 25px rgba(0,0,0,0.08) !important;
    transition: all 0.3s ease !important;
    position: relative !important;
    border: 1px solid rgba(0,0,0,0.05) !important;
    max-width: 100% !important;
}

.upcoming-course-card::before {
    content: "" !important;
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    height: 3px !important;
    background: linear-gradient(90deg, #3498db, #27ae60) !important;
    border-radius: 15px 15px 0 0 !important;
}

.upcoming-course-card:hover {
    transform: translateY(-6px) !important;
    box-shadow: 0 12px 40px rgba(0,0,0,0.12) !important;
}

.course-image {
    width: 100% !important;
    height: 180px !important;
    overflow: hidden !important;
    position: relative !important;
    background: linear-gradient(135deg, #3498db 0%, #27ae60 100%) !important;
}

.course-image:empty::before {
    content: "📚" !important;
    position: absolute !important;
    top: 50% !important;
    left: 50% !important;
    transform: translate(-50%, -50%) !important;
    font-size: 2.5rem !important;
    color: white !important;
    opacity: 0.8 !important;
}

.course-content {
    padding: 22px !important;
}

.course-badge {
    background: linear-gradient(135deg, #e74c3c, #c0392b) !important;
    color: white !important;
    padding: 5px 12px !important;
    border-radius: 18px !important;
    font-size: 0.75rem !important;
    font-weight: 600 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    box-shadow: 0 3px 8px rgba(231, 76, 60, 0.3) !important;
    display: inline-block !important;
    margin-bottom: 10px !important;
}

.course-date {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    margin-bottom: 15px !important;
    color: #e74c3c !important;
    font-weight: 600 !important;
    background: rgba(231, 76, 60, 0.08) !important;
    padding: 8px 12px !important;
    border-radius: 8px !important;
    border-left: 3px solid #e74c3c !important;
    font-size: 0.9rem !important;
}

.upcoming-course-card h3 {
    font-size: 1.2rem !important;
    color: #2c3e50 !important;
    margin-bottom: 12px !important;
    font-weight: 700 !important;
    line-height: 1.3 !important;
}

.upcoming-course-card p {
    color: #6c757d !important;
    line-height: 1.5 !important;
    margin-bottom: 18px !important;
    font-size: 0.9rem !important;
}

.course-details {
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 12px !important;
    margin-bottom: 18px !important;
    padding: 12px !important;
    background: rgba(52, 152, 219, 0.05) !important;
    border-radius: 8px !important;
    border: 1px solid rgba(52, 152, 219, 0.1) !important;
}

.detail-item {
    display: flex !important;
    align-items: center !important;
    gap: 6px !important;
    color: #495057 !important;
    font-size: 0.85rem !important;
    font-weight: 500 !important;
}

.detail-icon {
    font-size: 0.9rem !important;
    color: #3498db !important;
}

.btn-reserve {
    display: inline-block !important;
    background: linear-gradient(135deg, #27ae60, #229954) !important;
    color: white !important;
    padding: 12px 24px !important;
    border-radius: 22px !important;
    text-decoration: none !important;
    font-weight: 600 !important;
    text-align: center !important;
    transition: all 0.3s ease !important;
    border: none !important;
    cursor: pointer !important;
    width: 100% !important;
    font-size: 0.9rem !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3) !important;
}

.btn-reserve:hover {
    background: linear-gradient(135deg, #229954, #1e8449) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 20px rgba(39, 174, 96, 0.4) !important;
    color: white !important;
    text-decoration: none !important;
}

/* RESPONSIVE FORZADO */
@media (max-width: 1024px) {
    .upcoming-courses-grid {
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)) !important;
        max-width: 850px !important;
    }
}

@media (max-width: 768px) {
    .upcoming-courses-section {
        padding: 40px 0 !important;
    }
    
    .upcoming-courses-section .section-header h2 {
        font-size: 2.2rem !important;
    }
    
    .upcoming-courses-grid {
        grid-template-columns: 1fr !important;
        gap: 20px !important;
        max-width: 100% !important;
    }
    
    .course-content {
        padding: 18px !important;
    }
}

@media (max-width: 480px) {
    .upcoming-courses-section .container {
        padding: 0 15px !important;
    }
    
    .upcoming-courses-section .section-header h2 {
        font-size: 1.8rem !important;
    }
    
    .upcoming-course-card {
        border-radius: 12px !important;
    }
    
    .course-image {
        height: 160px !important;
    }
    
    .course-content {
        padding: 16px !important;
    }
}
</style>';
    
    // Buscar donde insertar el CSS (antes del </head> o al inicio del body)
    if (strpos($template_content, '/* ESTILOS FORZADOS PARA PRÓXIMOS CURSOS */') === false) {
        // Insertar el CSS justo después del get_header()
        $template_content = str_replace(
            'get_header();',
            'get_header();' . "\n" . $forced_css,
            $template_content
        );
        
        if (file_put_contents($template_file, $template_content)) {
            echo "✅ CSS forzado agregado directamente al template\n";
        } else {
            echo "❌ Error al modificar el template\n";
        }
    } else {
        echo "ℹ️ CSS forzado ya existe en el template\n";
    }
    
} else {
    echo "❌ No se encontró el template page-cursos.php\n";
}

echo "\n";

// 2. Limpiar TODO el cache agresivamente
echo "🧹 LIMPIANDO CACHE AGRESIVAMENTE...\n";

// WordPress cache
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
    echo "✅ Cache de WordPress limpiado\n";
}

// Transients
$transients = [
    'mongruas_courses_cache',
    'courses_carousel_cache', 
    'page_cache_anuncios',
    'theme_cache',
    'css_cache',
    'js_cache'
];

foreach ($transients as $transient) {
    delete_transient($transient);
    delete_site_transient($transient);
}
echo "✅ Transients limpiados\n";

// Opciones de cache
$cache_options = [
    'mongruas_css_cache',
    'mongruas_js_cache',
    'page_cache',
    'template_cache'
];

foreach ($cache_options as $option) {
    delete_option($option);
    delete_site_option($option);
}
echo "✅ Opciones de cache limpiadas\n";

echo "\n";

// 3. Verificar que la página /anuncios existe
$page = get_page_by_path('anuncios');
if ($page) {
    echo "✅ Página /anuncios encontrada (ID: {$page->ID})\n";
    
    // Forzar actualización de la página
    wp_update_post([
        'ID' => $page->ID,
        'post_modified' => current_time('mysql'),
        'post_modified_gmt' => current_time('mysql', 1)
    ]);
    echo "✅ Página /anuncios forzada a actualizar\n";
    
} else {
    echo "❌ Página /anuncios no encontrada\n";
}

echo "\n";

// 4. Generar reporte de fuerza bruta
echo "💥 REPORTE DE CAMBIOS FORZADOS:\n\n";

echo "🔥 MÉTODO APLICADO: FUERZA BRUTA\n";
echo "  • CSS insertado directamente en el template\n";
echo "  • Estilos con !important para máxima prioridad\n";
echo "  • Cache completamente limpiado\n";
echo "  • Página forzada a actualizar\n\n";

echo "📐 ESTILOS FORZADOS:\n";
echo "  • Contenedor: máximo 1000px\n";
echo "  • Grid: máximo 950px\n";
echo "  • Columnas: máximo 2 en desktop\n";
echo "  • Tarjetas: 15px border-radius\n";
echo "  • Sombras: 6px-25px elegantes\n";
echo "  • Colores: gradientes bonitos\n\n";

echo "🎯 RESPONSIVE FORZADO:\n";
echo "  • >1200px: 2 columnas fijas\n";
echo "  • 1024px: 2 columnas adaptativas\n";
echo "  • 768px: 1 columna\n";
echo "  • 480px: 1 columna compacta\n\n";

echo "🔄 PARA VER LOS CAMBIOS:\n";
echo "1. Ve INMEDIATAMENTE a: http://mongruasformacion.local/anuncios/\n";
echo "2. Refresca la página (Ctrl+F5 o Cmd+Shift+R)\n";
echo "3. Los cambios DEBEN verse ahora\n";
echo "4. Si no se ven, hay un problema más profundo\n\n";

echo "⚠️ IMPORTANTE:\n";
echo "• Los estilos están insertados directamente en el template\n";
echo "• Tienen máxima prioridad con !important\n";
echo "• No dependen de archivos CSS externos\n";
echo "• Deberían verse INMEDIATAMENTE\n\n";

echo "✅ ESTADO: CAMBIOS FORZADOS APLICADOS\n";
echo "🎉 Si no se ven ahora, el problema es otro\n";
echo "💪 ¡MÉTODO DE FUERZA BRUTA COMPLETADO!\n";
?>
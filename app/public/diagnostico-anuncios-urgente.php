<?php
/**
 * DIAGNÓSTICO URGENTE - PÁGINA ANUNCIOS
 * Verificar qué está causando que siga viéndose el carrusel
 */

// Limpiar cualquier cache
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
}

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<title>Diagnóstico Anuncios - Próximos Cursos</title>";
echo "<style>";
echo "body { font-family: Arial, sans-serif; margin: 20px; }";
echo ".diagnostico { background: #f0f0f0; padding: 15px; margin: 10px 0; border-radius: 5px; }";
echo ".error { background: #ffebee; border-left: 4px solid #f44336; }";
echo ".success { background: #e8f5e8; border-left: 4px solid #4caf50; }";
echo ".warning { background: #fff3e0; border-left: 4px solid #ff9800; }";
echo "</style>";
echo "</head>";
echo "<body>";

echo "<h1>🔍 DIAGNÓSTICO URGENTE - PÁGINA ANUNCIOS</h1>";

// 1. Verificar si la página anuncios existe
echo "<div class='diagnostico'>";
echo "<h2>1. Verificación de Página Anuncios</h2>";

$anuncios_page = get_page_by_path('anuncios');
if ($anuncios_page) {
    echo "<div class='success'>✅ Página 'anuncios' encontrada (ID: {$anuncios_page->ID})</div>";
    echo "<p><strong>Template:</strong> " . get_page_template_slug($anuncios_page->ID) . "</p>";
    echo "<p><strong>URL:</strong> " . get_permalink($anuncios_page->ID) . "</p>";
} else {
    echo "<div class='error'>❌ Página 'anuncios' NO encontrada</div>";
}
echo "</div>";

// 2. Verificar archivos CSS que podrían estar interfiriendo
echo "<div class='diagnostico'>";
echo "<h2>2. Archivos CSS Activos</h2>";

$css_files = [
    'main.css' => get_template_directory() . '/assets/css/main.css',
    'upcoming-courses.css' => get_template_directory() . '/assets/css/upcoming-courses.css',
    'responsive.css' => get_template_directory() . '/assets/css/responsive.css'
];

foreach ($css_files as $name => $path) {
    if (file_exists($path)) {
        $size = filesize($path);
        echo "<div class='warning'>⚠️ {$name} existe ({$size} bytes)</div>";
        
        // Buscar referencias a carrusel
        $content = file_get_contents($path);
        if (strpos($content, 'carousel') !== false || strpos($content, 'carrusel') !== false) {
            echo "<div class='error'>🚨 {$name} contiene código de carrusel</div>";
        }
    } else {
        echo "<div class='success'>✅ {$name} no existe</div>";
    }
}
echo "</div>";

// 3. Verificar JavaScript que podría estar interfiriendo
echo "<div class='diagnostico'>";
echo "<h2>3. Archivos JavaScript Activos</h2>";

$js_files = [
    'main.js' => get_template_directory() . '/assets/js/main.js',
    'upcoming-courses.js' => get_template_directory() . '/assets/js/upcoming-courses.js',
    'carrusel-fix.js' => get_template_directory() . '/assets/js/carrusel-fix.js'
];

foreach ($js_files as $name => $path) {
    if (file_exists($path)) {
        $size = filesize($path);
        echo "<div class='warning'>⚠️ {$name} existe ({$size} bytes)</div>";
        
        // Buscar referencias a carrusel
        $content = file_get_contents($path);
        if (strpos($content, 'carousel') !== false || strpos($content, 'carrusel') !== false) {
            echo "<div class='error'>🚨 {$name} contiene código de carrusel</div>";
        }
    } else {
        echo "<div class='success'>✅ {$name} no existe</div>";
    }
}
echo "</div>";

// 4. Verificar el template actual
echo "<div class='diagnostico'>";
echo "<h2>4. Template de Página Anuncios</h2>";

$template_path = get_template_directory() . '/page-templates/page-cursos.php';
if (file_exists($template_path)) {
    $template_content = file_get_contents($template_path);
    $template_size = filesize($template_path);
    echo "<div class='success'>✅ Template page-cursos.php existe ({$template_size} bytes)</div>";
    
    // Buscar referencias problemáticas
    if (strpos($template_content, 'carousel') !== false) {
        echo "<div class='error'>🚨 Template contiene referencias a 'carousel'</div>";
    }
    if (strpos($template_content, 'courses-carousel') !== false) {
        echo "<div class='error'>🚨 Template contiene 'courses-carousel'</div>";
    }
    if (strpos($template_content, 'carousel-btn') !== false) {
        echo "<div class='error'>🚨 Template contiene 'carousel-btn'</div>";
    }
    if (strpos($template_content, 'upcoming-courses-grid') !== false) {
        echo "<div class='success'>✅ Template contiene 'upcoming-courses-grid' (correcto)</div>";
    }
} else {
    echo "<div class='error'>❌ Template page-cursos.php NO existe</div>";
}
echo "</div>";

// 5. Verificar cache de WordPress
echo "<div class='diagnostico'>";
echo "<h2>5. Estado del Cache</h2>";

// Intentar limpiar diferentes tipos de cache
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
    echo "<div class='success'>✅ Cache de WordPress limpiado</div>";
}

if (function_exists('w3tc_flush_all')) {
    w3tc_flush_all();
    echo "<div class='success'>✅ W3 Total Cache limpiado</div>";
}

if (function_exists('wp_rocket_clean_domain')) {
    wp_rocket_clean_domain();
    echo "<div class='success'>✅ WP Rocket cache limpiado</div>";
}

echo "</div>";

// 6. Crear enlace directo para probar
echo "<div class='diagnostico'>";
echo "<h2>6. Enlaces de Prueba</h2>";

$site_url = home_url();
echo "<p><a href='{$site_url}/anuncios/' target='_blank' style='background: #0066cc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🔗 Ir a Página Anuncios</a></p>";
echo "<p><a href='{$site_url}/anuncios/?nocache=" . time() . "' target='_blank' style='background: #ff9900; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🔗 Ir a Anuncios (Sin Cache)</a></p>";

echo "</div>";

// 7. Mostrar información del tema activo
echo "<div class='diagnostico'>";
echo "<h2>7. Información del Tema</h2>";

$theme = wp_get_theme();
echo "<p><strong>Tema Activo:</strong> " . $theme->get('Name') . "</p>";
echo "<p><strong>Versión:</strong> " . $theme->get('Version') . "</p>";
echo "<p><strong>Directorio:</strong> " . get_template_directory() . "</p>";

echo "</div>";

echo "<hr>";
echo "<h2>🎯 PRÓXIMOS PASOS RECOMENDADOS:</h2>";
echo "<ol>";
echo "<li>Visitar los enlaces de prueba arriba</li>";
echo "<li>Si sigue mostrando carrusel, revisar archivos CSS/JS marcados en rojo</li>";
echo "<li>Verificar si hay plugins de cache activos</li>";
echo "<li>Comprobar si hay CSS personalizado en el Customizer de WordPress</li>";
echo "</ol>";

echo "</body>";
echo "</html>";
?>
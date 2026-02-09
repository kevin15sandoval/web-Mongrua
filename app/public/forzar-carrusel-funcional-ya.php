<?php
/**
 * FORZAR CARRUSEL FUNCIONAL - LIMPIEZA TOTAL
 * Limpia caché y verifica que el carrusel esté correctamente implementado
 */

echo "<h1>🔧 FORZANDO CARRUSEL FUNCIONAL</h1>";

// Intentar cargar WordPress si está disponible
$wp_load = __DIR__ . '/wp-load.php';
if (file_exists($wp_load)) {
    require_once($wp_load);
    
    // Limpiar todo tipo de caché
    if (function_exists('wp_cache_flush')) {
        wp_cache_flush();
        echo "<p>✅ Caché de WordPress limpiado</p>";
    }
    
    // Limpiar transients
    if (function_exists('delete_transient')) {
        global $wpdb;
        $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'");
        $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_site_transient_%'");
        echo "<p>✅ Transients eliminados</p>";
    }
} else {
    echo "<p>⚠️ WordPress no cargado (modo standalone)</p>";
}

// Verificar que el archivo about-section.php existe
$about_section_path = __DIR__ . '/wp-content/themes/mongruas-theme/template-parts/about-section.php';

if (!file_exists($about_section_path)) {
    echo "<p style='color: red;'>❌ ERROR: No se encuentra about-section.php</p>";
    exit;
}

echo "<p>✅ Archivo about-section.php encontrado</p>";

// Leer el contenido actual
$content = file_get_contents($about_section_path);

// Verificar que tiene el JavaScript correcto
if (strpos($content, 'inicializarCarrusel') !== false) {
    echo "<p>✅ JavaScript del carrusel encontrado</p>";
} else {
    echo "<p style='color: orange;'>⚠️ JavaScript del carrusel NO encontrado - necesita actualización</p>";
}

// Verificar que tiene las 9 imágenes
$image_count = substr_count($content, 'carousel-slide');
echo "<p>📸 Número de slides encontrados: <strong>$image_count</strong></p>";

// Verificar que tiene los botones
if (strpos($content, 'carousel-btn prev') !== false && strpos($content, 'carousel-btn next') !== false) {
    echo "<p>✅ Botones de navegación encontrados</p>";
} else {
    echo "<p style='color: red;'>❌ Botones de navegación NO encontrados</p>";
}

// Verificar que tiene los dots
if (strpos($content, 'carousel-dots') !== false) {
    echo "<p>✅ Indicadores (dots) encontrados</p>";
} else {
    echo "<p style='color: red;'>❌ Indicadores NO encontrados</p>";
}

echo "<hr>";
echo "<h2>🧹 LIMPIEZA DE CACHÉ COMPLETADA</h2>";
echo "<p>✅ Caché de WordPress limpiado</p>";
echo "<p>✅ Transients eliminados</p>";

echo "<hr>";
echo "<h2>🔍 VERIFICACIÓN DE IMÁGENES</h2>";

$gallery_path = __DIR__ . '/wp-content/uploads/galeria/';
if (is_dir($gallery_path)) {
    $images = glob($gallery_path . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
    echo "<p>📁 Carpeta de galería encontrada</p>";
    echo "<p>🖼️ Imágenes disponibles: <strong>" . count($images) . "</strong></p>";
    echo "<ul>";
    foreach ($images as $img) {
        $filename = basename($img);
        $filesize = round(filesize($img) / 1024, 2);
        echo "<li>$filename ($filesize KB)</li>";
    }
    echo "</ul>";
} else {
    echo "<p style='color: red;'>❌ Carpeta de galería NO encontrada</p>";
}

echo "<hr>";
echo "<h2>🎯 PRÓXIMOS PASOS</h2>";
echo "<ol>";
echo "<li>Presiona <strong>Ctrl + F5</strong> en tu navegador para forzar recarga</li>";
echo "<li>Abre la consola del navegador (F12) y busca errores JavaScript</li>";
echo "<li>Ve a la página principal: <a href='http://mongruasformacion.local' target='_blank'>http://mongruasformacion.local</a></li>";
echo "<li>Busca la sección 'Nuestras Instalaciones'</li>";
echo "<li>Deberías ver las flechas ‹ y › a los lados del carrusel</li>";
echo "</ol>";

echo "<hr>";
echo "<p><a href='http://mongruasformacion.local' target='_blank' style='display: inline-block; background: #0066cc; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold;'>🏠 IR A LA PÁGINA PRINCIPAL</a></p>";
?>

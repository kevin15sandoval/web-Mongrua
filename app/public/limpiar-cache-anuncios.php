<?php
/**
 * Limpiar Cache y Forzar Actualización - Página Anuncios
 */

// Cargar WordPress
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
}

echo "<h1>🧹 Limpiando Cache - Página Anuncios</h1>";

// 1. Limpiar cache de WordPress
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
    echo "✅ Cache de WordPress limpiado<br>";
}

// 2. Limpiar cache de objetos
if (function_exists('wp_cache_delete')) {
    wp_cache_delete('alloptions', 'options');
    echo "✅ Cache de opciones limpiado<br>";
}

// 3. Limpiar transients
global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'");
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_site_transient_%'");
echo "✅ Transients limpiados<br>";

// 4. Forzar recarga de estilos
$theme_version = time(); // Usar timestamp como versión
update_option('mongruas_theme_version', $theme_version);
echo "✅ Versión de tema actualizada: $theme_version<br>";

// 5. Verificar página anuncios
$anuncios_page = get_page_by_path('anuncios');
if ($anuncios_page) {
    // Forzar actualización de la página
    wp_update_post(array(
        'ID' => $anuncios_page->ID,
        'post_modified' => current_time('mysql'),
        'post_modified_gmt' => current_time('mysql', 1)
    ));
    echo "✅ Página anuncios actualizada<br>";
    
    // Limpiar cache específico de la página
    clean_post_cache($anuncios_page->ID);
    echo "✅ Cache de página anuncios limpiado<br>";
}

// 6. Verificar template
$template_path = get_template_directory() . '/page-templates/page-cursos.php';
if (file_exists($template_path)) {
    $template_content = file_get_contents($template_path);
    if (strpos($template_content, 'grid-template-columns: repeat(2, 1fr) !important') !== false) {
        echo "✅ Template contiene estilos de 2 columnas forzados<br>";
    } else {
        echo "❌ Template NO contiene estilos de 2 columnas<br>";
    }
}

// 7. Agregar headers para evitar cache del navegador
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

echo "<h2>✨ Cache Limpiado Completamente</h2>";
echo "<p><strong>Ahora la página debería mostrar los cambios.</strong></p>";

echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
echo "<h3>🎯 Próximos Pasos:</h3>";
echo "<ol>";
echo "<li>Visita la página de anuncios en una ventana privada/incógnito</li>";
echo "<li>Presiona Ctrl+F5 (o Cmd+Shift+R en Mac) para forzar recarga</li>";
echo "<li>Verifica que ahora se muestren máximo 2 cursos por fila</li>";
echo "</ol>";
echo "</div>";

echo "<p><a href='" . home_url('/anuncios/') . "' target='_blank' style='background: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold;'>🔗 Ver Página Anuncios Actualizada</a></p>";

echo "<p><a href='" . home_url('/diagnostico-anuncios-final.php') . "' target='_blank' style='background: #007bff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold;'>🔍 Ejecutar Diagnóstico</a></p>";
?>
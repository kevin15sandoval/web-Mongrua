<?php
/**
 * Limpiar Cache Total - Forzar Actualización
 */

require_once('wp-load.php');

echo "🧹 LIMPIANDO TODO EL CACHE...\n\n";

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

// Forzar actualización de la página /anuncios
$page = get_page_by_path('anuncios');
if ($page) {
    wp_update_post([
        'ID' => $page->ID,
        'post_modified' => current_time('mysql'),
        'post_modified_gmt' => current_time('mysql', 1)
    ]);
    echo "✅ Página /anuncios actualizada\n";
}

echo "\n🔥 CAMBIOS APLICADOS:\n";
echo "• CSS insertado directamente en el template\n";
echo "• Estilos con !important para máxima prioridad\n";
echo "• Cache completamente limpiado\n\n";

echo "🔄 VE AHORA A: http://mongruasformacion.local/anuncios/\n";
echo "📱 Refresca con Ctrl+F5 (Windows) o Cmd+Shift+R (Mac)\n\n";

echo "✅ ¡Los cambios DEBEN verse ahora!\n";
?>
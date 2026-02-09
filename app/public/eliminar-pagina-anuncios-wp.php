<?php
require_once('wp-load.php');

echo "<h1>🗑️ ELIMINAR PÁGINA ANUNCIOS DE WORDPRESS</h1>";

// Buscar la página
$page = get_page_by_path('anuncios');

if ($page) {
    echo "<h2>📄 Página encontrada:</h2>";
    echo "<p><strong>ID:</strong> " . $page->ID . "</p>";
    echo "<p><strong>Título:</strong> " . $page->post_title . "</p>";
    echo "<p><strong>URL:</strong> " . get_permalink($page->ID) . "</p>";
    
    // Eliminar la página
    $result = wp_delete_post($page->ID, true); // true = eliminar permanentemente
    
    if ($result) {
        echo "<h2 style='color: green;'>✅ PÁGINA ELIMINADA EXITOSAMENTE</h2>";
        echo "<p>Ahora /anuncios/ debería cargar el archivo anuncios.php correctamente</p>";
        echo "<p><a href='/anuncios/'>Probar /anuncios/</a></p>";
    } else {
        echo "<h2 style='color: red;'>❌ ERROR AL ELIMINAR</h2>";
    }
} else {
    echo "<h2 style='color: orange;'>⚠️ NO SE ENCONTRÓ NINGUNA PÁGINA LLAMADA 'ANUNCIOS'</h2>";
    echo "<p>El problema debe ser otro. Verifica:</p>";
    echo "<ul>";
    echo "<li>Que estés accediendo a /anuncios.php (con .php)</li>";
    echo "<li>Que no haya redirecciones en .htaccess</li>";
    echo "<li>Que no haya caché de WordPress activo</li>";
    echo "</ul>";
}

// Limpiar caché de WordPress
wp_cache_flush();
echo "<p>✅ Caché de WordPress limpiado</p>";
?>

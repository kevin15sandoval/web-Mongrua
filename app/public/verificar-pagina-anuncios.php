<?php
require_once('wp-load.php');

echo "<h1>🔍 VERIFICACIÓN PÁGINA ANUNCIOS</h1>";

// Buscar si existe una página llamada "anuncios"
$page = get_page_by_path('anuncios');

if ($page) {
    echo "<h2 style='color: red;'>❌ SÍ EXISTE UNA PÁGINA DE WORDPRESS LLAMADA 'ANUNCIOS'</h2>";
    echo "<p><strong>ID:</strong> " . $page->ID . "</p>";
    echo "<p><strong>Título:</strong> " . $page->post_title . "</p>";
    echo "<p><strong>Estado:</strong> " . $page->post_status . "</p>";
    echo "<p><strong>Tipo:</strong> " . $page->post_type . "</p>";
    echo "<p><strong>URL:</strong> " . get_permalink($page->ID) . "</p>";
    
    echo "<hr>";
    echo "<h3>🔧 SOLUCIÓN:</h3>";
    echo "<p>WordPress está redirigiendo /anuncios/ a esta página.</p>";
    echo "<p><strong>Opción 1:</strong> Eliminar esta página de WordPress</p>";
    echo "<p><strong>Opción 2:</strong> Cambiar el slug de esta página</p>";
    echo "<p><strong>Opción 3:</strong> Usar otro nombre para el archivo PHP (ej: proximos-cursos.php)</p>";
} else {
    echo "<h2 style='color: green;'>✅ NO EXISTE PÁGINA DE WORDPRESS LLAMADA 'ANUNCIOS'</h2>";
    echo "<p>El problema debe ser otro (caché, .htaccess, etc.)</p>";
}

// Verificar si hay posts con ese slug
$posts = get_posts(array(
    'name' => 'anuncios',
    'post_type' => 'any',
    'post_status' => 'any',
    'numberposts' => 1
));

if ($posts) {
    echo "<hr>";
    echo "<h2 style='color: red;'>❌ TAMBIÉN HAY UN POST/CUSTOM POST CON SLUG 'ANUNCIOS'</h2>";
    foreach ($posts as $post) {
        echo "<p><strong>ID:</strong> " . $post->ID . "</p>";
        echo "<p><strong>Título:</strong> " . $post->post_title . "</p>";
        echo "<p><strong>Tipo:</strong> " . $post->post_type . "</p>";
    }
}
?>

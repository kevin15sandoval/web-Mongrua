<?php
require_once('wp-load.php');

echo "<h1>♻️ RESTAURAR PÁGINA ANUNCIOS</h1>";

// Buscar en la papelera
$args = array(
    'post_type' => 'page',
    'post_status' => 'trash',
    'name' => 'anuncios',
    'posts_per_page' => 1
);

$pages = get_posts($args);

if ($pages) {
    $page = $pages[0];
    echo "<h2>📄 Página encontrada en la papelera:</h2>";
    echo "<p><strong>ID:</strong> " . $page->ID . "</p>";
    echo "<p><strong>Título:</strong> " . $page->post_title . "</p>";
    
    // Restaurar
    $result = wp_untrash_post($page->ID);
    
    if ($result) {
        echo "<h2 style='color: green;'>✅ PÁGINA RESTAURADA EXITOSAMENTE</h2>";
        echo "<p>La página ha sido restaurada correctamente</p>";
        echo "<p><a href='" . get_permalink($page->ID) . "'>Ver página restaurada</a></p>";
    } else {
        echo "<h2 style='color: red;'>❌ ERROR AL RESTAURAR</h2>";
    }
} else {
    echo "<h2 style='color: orange;'>⚠️ NO SE ENCONTRÓ LA PÁGINA EN LA PAPELERA</h2>";
    echo "<p>Buscando en todas las páginas...</p>";
    
    // Buscar en todas las páginas
    $all_pages = get_posts(array(
        'post_type' => 'page',
        'post_status' => 'any',
        'posts_per_page' => -1
    ));
    
    echo "<h3>Páginas encontradas:</h3><ul>";
    foreach ($all_pages as $p) {
        echo "<li>" . $p->post_title . " (ID: " . $p->ID . ", Estado: " . $p->post_status . ")</li>";
    }
    echo "</ul>";
}

wp_cache_flush();
?>

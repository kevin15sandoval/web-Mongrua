<?php
/**
 * CAMBIAR PLANTILLA DE ANUNCIOS AUTOMÁTICAMENTE
 */
require_once('wp-load.php');

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Cambiar Plantilla</title>";
echo "<style>body{font-family:Arial;padding:40px;background:#f5f5f5;}.box{max-width:600px;margin:0 auto;background:white;padding:30px;border-radius:10px;}.ok{background:#d4edda;color:#155724;padding:20px;border-radius:5px;margin:20px 0;}.btn{display:inline-block;padding:15px 30px;background:#0066cc;color:white;text-decoration:none;border-radius:5px;margin:10px 5px;font-weight:bold;}h1{color:#0066cc;}</style></head><body><div class='box'>";

echo "<h1>🔄 Cambiando Plantilla...</h1>";

// Buscar página anuncios
$page = get_posts(array(
    'post_type' => 'page',
    'post_status' => 'publish',
    'name' => 'anuncios',
    'posts_per_page' => 1
));

if ($page) {
    $page_id = $page[0]->ID;
    
    // Cambiar a la plantilla completa
    update_post_meta($page_id, '_wp_page_template', 'page-templates/page-anuncios-completa.php');
    
    // Limpiar caché
    wp_cache_flush();
    
    echo "<div class='ok'>";
    echo "<h2>✅ ¡PLANTILLA CAMBIADA!</h2>";
    echo "<p><strong>Página:</strong> Anuncios (ID: $page_id)</p>";
    echo "<p><strong>Nueva plantilla:</strong> Anuncios Completa</p>";
    echo "<p><strong>Ahora verás:</strong></p>";
    echo "<ul>";
    echo "<li>✅ Certificados de Profesionalidad</li>";
    echo "<li>✅ +2000 Cursos Online</li>";
    echo "<li>✅ Explora por Modalidad</li>";
    echo "<li>✅ Catálogos de colores</li>";
    echo "<li>✅ Mapa de ubicación</li>";
    echo "</ul>";
    echo "<p><a href='/anuncios/' class='btn'>Ver Página Anuncios</a></p>";
    echo "</div>";
} else {
    echo "<div class='ok' style='background:#f8d7da;color:#721c24;'>";
    echo "<h2>❌ Página no encontrada</h2>";
    echo "<p>No se encontró la página 'anuncios'</p>";
    echo "</div>";
}

echo "</div></body></html>";
?>

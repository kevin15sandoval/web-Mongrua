<?php
/**
 * RESTAURAR PÁGINA ANUNCIOS - AUTOMÁTICO
 */
require_once('wp-load.php');

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Restaurar Anuncios</title>";
echo "<style>body{font-family:Arial;padding:40px;background:#f5f5f5;}.box{max-width:600px;margin:0 auto;background:white;padding:30px;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,0.1);}.ok{background:#d4edda;color:#155724;padding:20px;border-radius:5px;margin:20px 0;}.error{background:#f8d7da;color:#721c24;padding:20px;border-radius:5px;margin:20px 0;}.btn{display:inline-block;padding:15px 30px;background:#0066cc;color:white;text-decoration:none;border-radius:5px;margin:10px 5px;font-weight:bold;}.btn:hover{background:#0052a3;}h1{color:#0066cc;}</style></head><body><div class='box'>";

echo "<h1>🔄 Restaurando Página Anuncios...</h1>";

// Buscar en papelera
$page_trash = get_posts(array(
    'post_type' => 'page',
    'post_status' => 'trash',
    'name' => 'anuncios',
    'posts_per_page' => 1
));

if ($page_trash) {
    $page = $page_trash[0];
    
    // Restaurar
    $result = wp_untrash_post($page->ID);
    
    if ($result) {
        // Asignar la plantilla correcta
        update_post_meta($page->ID, '_wp_page_template', 'page-templates/page-anuncios.php');
        
        // Limpiar caché
        wp_cache_flush();
        
        echo "<div class='ok'>";
        echo "<h2>✅ ¡PÁGINA RESTAURADA EXITOSAMENTE!</h2>";
        echo "<p><strong>ID:</strong> " . $page->ID . "</p>";
        echo "<p><strong>Título:</strong> " . $page->post_title . "</p>";
        echo "<p><strong>Plantilla:</strong> Próximos Cursos (Anuncios)</p>";
        echo "<p><strong>URL:</strong> <a href='" . get_permalink($page->ID) . "'>" . get_permalink($page->ID) . "</a></p>";
        echo "</div>";
        
        echo "<div class='ok'>";
        echo "<h3>🎉 ¡TODO LISTO!</h3>";
        echo "<p>La página ha sido restaurada y configurada correctamente.</p>";
        echo "<p><a href='" . get_permalink($page->ID) . "' class='btn'>Ver Página Anuncios</a></p>";
        echo "<p><a href='/' class='btn'>Ir al Inicio</a></p>";
        echo "</div>";
    } else {
        echo "<div class='error'>";
        echo "<h2>❌ Error al restaurar</h2>";
        echo "<p>No se pudo restaurar la página automáticamente.</p>";
        echo "<p><a href='" . admin_url('edit.php?post_status=trash&post_type=page') . "' class='btn'>Ir a Papelera de WordPress</a></p>";
        echo "</div>";
    }
} else {
    // No está en papelera, buscar si existe
    $page_any = get_posts(array(
        'post_type' => 'page',
        'post_status' => 'any',
        'name' => 'anuncios',
        'posts_per_page' => 1
    ));
    
    if ($page_any) {
        $page = $page_any[0];
        
        if ($page->post_status == 'publish') {
            // Ya está publicada, solo asignar plantilla
            update_post_meta($page->ID, '_wp_page_template', 'page-templates/page-anuncios.php');
            wp_cache_flush();
            
            echo "<div class='ok'>";
            echo "<h2>✅ ¡PÁGINA YA EXISTE!</h2>";
            echo "<p>La página ya estaba publicada. Se ha configurado la plantilla correcta.</p>";
            echo "<p><a href='" . get_permalink($page->ID) . "' class='btn'>Ver Página Anuncios</a></p>";
            echo "</div>";
        } else {
            // Publicar y asignar plantilla
            wp_publish_post($page->ID);
            update_post_meta($page->ID, '_wp_page_template', 'page-templates/page-anuncios.php');
            wp_cache_flush();
            
            echo "<div class='ok'>";
            echo "<h2>✅ ¡PÁGINA PUBLICADA!</h2>";
            echo "<p>La página ha sido publicada y configurada.</p>";
            echo "<p><a href='" . get_permalink($page->ID) . "' class='btn'>Ver Página Anuncios</a></p>";
            echo "</div>";
        }
    } else {
        // No existe, crear nueva
        $new_page = array(
            'post_title'    => 'Anuncios',
            'post_name'     => 'anuncios',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_content'  => '',
            'page_template' => 'page-templates/page-anuncios.php'
        );
        
        $page_id = wp_insert_post($new_page);
        
        if ($page_id) {
            update_post_meta($page_id, '_wp_page_template', 'page-templates/page-anuncios.php');
            wp_cache_flush();
            
            echo "<div class='ok'>";
            echo "<h2>✅ ¡PÁGINA CREADA!</h2>";
            echo "<p>Se ha creado una nueva página 'Anuncios' con la plantilla correcta.</p>";
            echo "<p><a href='" . get_permalink($page_id) . "' class='btn'>Ver Página Anuncios</a></p>";
            echo "</div>";
        } else {
            echo "<div class='error'>";
            echo "<h2>❌ Error al crear</h2>";
            echo "<p>No se pudo crear la página automáticamente.</p>";
            echo "<p><a href='" . admin_url('post-new.php?post_type=page') . "' class='btn'>Crear Manualmente</a></p>";
            echo "</div>";
        }
    }
}

echo "<p style='text-align:center;margin-top:30px;'><a href='/' class='btn'>Volver al Inicio</a></p>";
echo "</div></body></html>";
?>

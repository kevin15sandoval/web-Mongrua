<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Restaurar Página Anuncios</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #0066cc; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .info { background: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .btn { display: inline-block; padding: 12px 24px; background: #0066cc; color: white; text-decoration: none; border-radius: 5px; margin: 10px 5px; }
        .btn:hover { background: #0052a3; }
        ul { line-height: 2; }
    </style>
</head>
<body>
    <div class="container">
        <h1>♻️ Restaurar Página Anuncios</h1>
        
        <?php
        require_once('wp-load.php');
        
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
            echo '<div class="info">';
            echo '<h2>📄 Página encontrada en la papelera:</h2>';
            echo '<p><strong>ID:</strong> ' . $page->ID . '</p>';
            echo '<p><strong>Título:</strong> ' . $page->post_title . '</p>';
            echo '<p><strong>Estado:</strong> ' . $page->post_status . '</p>';
            echo '</div>';
            
            // Restaurar
            $result = wp_untrash_post($page->ID);
            
            if ($result) {
                echo '<div class="success">';
                echo '<h2>✅ PÁGINA RESTAURADA EXITOSAMENTE</h2>';
                echo '<p>La página ha sido restaurada correctamente</p>';
                echo '<p><a href="' . get_permalink($page->ID) . '" class="btn">Ver página restaurada</a></p>';
                echo '<p><a href="' . admin_url('post.php?post=' . $page->ID . '&action=edit') . '" class="btn">Editar en WordPress</a></p>';
                echo '</div>';
                
                wp_cache_flush();
            } else {
                echo '<div class="error">';
                echo '<h2>❌ ERROR AL RESTAURAR</h2>';
                echo '<p>No se pudo restaurar la página. Intenta restaurarla manualmente desde el panel de WordPress.</p>';
                echo '</div>';
            }
        } else {
            echo '<div class="error">';
            echo '<h2>⚠️ NO SE ENCONTRÓ LA PÁGINA EN LA PAPELERA</h2>';
            echo '<p>La página "anuncios" no está en la papelera. Puede que ya esté restaurada o que necesites crearla de nuevo.</p>';
            echo '</div>';
            
            // Buscar si existe con otro estado
            $all_anuncios = get_posts(array(
                'post_type' => 'page',
                'post_status' => 'any',
                'name' => 'anuncios',
                'posts_per_page' => 1
            ));
            
            if ($all_anuncios) {
                $existing = $all_anuncios[0];
                echo '<div class="info">';
                echo '<h3>✅ La página ya existe:</h3>';
                echo '<p><strong>ID:</strong> ' . $existing->ID . '</p>';
                echo '<p><strong>Estado:</strong> ' . $existing->post_status . '</p>';
                echo '<p><a href="' . get_permalink($existing->ID) . '" class="btn">Ver página</a></p>';
                echo '<p><a href="' . admin_url('post.php?post=' . $existing->ID . '&action=edit') . '" class="btn">Editar en WordPress</a></p>';
                echo '</div>';
            } else {
                echo '<div class="info">';
                echo '<h3>💡 Crear nueva página</h3>';
                echo '<p>Puedes crear una nueva página "anuncios" desde el panel de WordPress:</p>';
                echo '<ol>';
                echo '<li>Ve a <strong>Páginas > Añadir nueva</strong></li>';
                echo '<li>Título: <strong>Anuncios</strong></li>';
                echo '<li>URL: <strong>/anuncios/</strong></li>';
                echo '<li>Plantilla: <strong>Próximos Cursos</strong></li>';
                echo '<li>Publica la página</li>';
                echo '</ol>';
                echo '<p><a href="' . admin_url('post-new.php?post_type=page') . '" class="btn">Crear página nueva</a></p>';
                echo '</div>';
            }
        }
        
        // Mostrar todas las páginas para referencia
        echo '<div class="info">';
        echo '<h3>📋 Todas las páginas del sitio:</h3>';
        $all_pages = get_posts(array(
            'post_type' => 'page',
            'post_status' => 'any',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        ));
        
        echo '<ul>';
        foreach ($all_pages as $p) {
            $status_label = $p->post_status == 'publish' ? '✅' : ($p->post_status == 'trash' ? '🗑️' : '⚠️');
            echo '<li>' . $status_label . ' <strong>' . $p->post_title . '</strong> (ID: ' . $p->ID . ', Estado: ' . $p->post_status . ')</li>';
        }
        echo '</ul>';
        echo '</div>';
        ?>
        
        <p><a href="/" class="btn">Volver al inicio</a></p>
    </div>
</body>
</html>

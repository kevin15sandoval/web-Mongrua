<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verificar Estado - Anuncios</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; background: #f5f5f5; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #0066cc; }
        h2 { color: #333; border-bottom: 2px solid #0066cc; padding-bottom: 10px; margin-top: 30px; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0; border-left: 4px solid #28a745; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 10px 0; border-left: 4px solid #dc3545; }
        .warning { background: #fff3cd; color: #856404; padding: 15px; border-radius: 5px; margin: 10px 0; border-left: 4px solid #ffc107; }
        .info { background: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 5px; margin: 10px 0; border-left: 4px solid #17a2b8; }
        .btn { display: inline-block; padding: 12px 24px; background: #0066cc; color: white; text-decoration: none; border-radius: 5px; margin: 10px 5px; }
        .btn:hover { background: #0052a3; }
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #218838; }
        .btn-warning { background: #ffc107; color: #333; }
        .btn-warning:hover { background: #e0a800; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #0066cc; color: white; }
        tr:hover { background: #f5f5f5; }
        .status-ok { color: #28a745; font-weight: bold; }
        .status-error { color: #dc3545; font-weight: bold; }
        .status-warning { color: #ffc107; font-weight: bold; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Verificación de Estado - Sistema de Anuncios</h1>
        <p><strong>Fecha:</strong> <?php echo date('d/m/Y H:i:s'); ?></p>
        
        <?php
        require_once('wp-load.php');
        global $wpdb;
        
        $issues = 0;
        $warnings = 0;
        $success = 0;
        ?>
        
        <h2>1️⃣ Base de Datos</h2>
        <?php
        $table_name = $wpdb->prefix . 'upcoming_courses';
        $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name;
        
        if ($table_exists) {
            $count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
            echo '<div class="success">';
            echo '✅ <strong>Tabla existe:</strong> <code>' . $table_name . '</code><br>';
            echo '✅ <strong>Cursos registrados:</strong> ' . $count;
            echo '</div>';
            $success++;
            
            if ($count > 0) {
                $cursos = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id ASC LIMIT 5");
                echo '<table>';
                echo '<tr><th>ID</th><th>Curso</th><th>Fecha Inicio</th><th>Modalidad</th><th>Plazas</th></tr>';
                foreach ($cursos as $curso) {
                    echo '<tr>';
                    echo '<td>' . $curso->id . '</td>';
                    echo '<td>' . esc_html($curso->course_name) . '</td>';
                    echo '<td>' . esc_html($curso->start_date) . '</td>';
                    echo '<td>' . esc_html($curso->modality) . '</td>';
                    echo '<td>' . esc_html($curso->available_spots) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<div class="warning">';
                echo '⚠️ <strong>No hay cursos registrados</strong><br>';
                echo 'Agrega cursos desde el panel de administración';
                echo '</div>';
                $warnings++;
            }
        } else {
            echo '<div class="error">';
            echo '❌ <strong>Tabla no existe:</strong> <code>' . $table_name . '</code><br>';
            echo 'Necesitas crear la tabla de cursos';
            echo '</div>';
            $issues++;
        }
        ?>
        
        <h2>2️⃣ Página WordPress "Anuncios"</h2>
        <?php
        // Buscar página publicada
        $page_published = get_posts(array(
            'post_type' => 'page',
            'post_status' => 'publish',
            'name' => 'anuncios',
            'posts_per_page' => 1
        ));
        
        // Buscar en papelera
        $page_trash = get_posts(array(
            'post_type' => 'page',
            'post_status' => 'trash',
            'name' => 'anuncios',
            'posts_per_page' => 1
        ));
        
        // Buscar en cualquier estado
        $page_any = get_posts(array(
            'post_type' => 'page',
            'post_status' => 'any',
            'name' => 'anuncios',
            'posts_per_page' => 1
        ));
        
        if ($page_published) {
            $page = $page_published[0];
            $template = get_page_template_slug($page->ID);
            
            echo '<div class="success">';
            echo '✅ <strong>Página publicada:</strong> ' . $page->post_title . '<br>';
            echo '✅ <strong>ID:</strong> ' . $page->ID . '<br>';
            echo '✅ <strong>URL:</strong> <a href="' . get_permalink($page->ID) . '" target="_blank">' . get_permalink($page->ID) . '</a><br>';
            echo '✅ <strong>Plantilla:</strong> ' . ($template ? $template : 'Predeterminada') . '<br>';
            echo '</div>';
            $success++;
            
            if ($template !== 'page-templates/page-anuncios.php') {
                echo '<div class="warning">';
                echo '⚠️ <strong>Plantilla incorrecta</strong><br>';
                echo 'La página debe usar la plantilla: <code>page-templates/page-anuncios.php</code><br>';
                echo '<a href="' . admin_url('post.php?post=' . $page->ID . '&action=edit') . '" class="btn btn-warning">Cambiar Plantilla</a>';
                echo '</div>';
                $warnings++;
            }
            
            echo '<div class="info">';
            echo '<strong>Acciones:</strong><br>';
            echo '<a href="' . get_permalink($page->ID) . '" class="btn btn-success" target="_blank">Ver Página</a>';
            echo '<a href="' . admin_url('post.php?post=' . $page->ID . '&action=edit') . '" class="btn">Editar en WordPress</a>';
            echo '</div>';
            
        } elseif ($page_trash) {
            $page = $page_trash[0];
            echo '<div class="warning">';
            echo '⚠️ <strong>Página en la papelera:</strong> ' . $page->post_title . '<br>';
            echo '⚠️ <strong>ID:</strong> ' . $page->ID . '<br>';
            echo 'Necesitas restaurarla para que funcione';
            echo '</div>';
            $warnings++;
            
            echo '<div class="info">';
            echo '<strong>Solución:</strong><br>';
            echo '<a href="/restaurar-anuncios-simple.php" class="btn btn-warning">Restaurar Página Ahora</a>';
            echo '</div>';
            
        } elseif ($page_any) {
            $page = $page_any[0];
            echo '<div class="warning">';
            echo '⚠️ <strong>Página existe pero no está publicada:</strong> ' . $page->post_title . '<br>';
            echo '⚠️ <strong>Estado:</strong> ' . $page->post_status . '<br>';
            echo '⚠️ <strong>ID:</strong> ' . $page->ID . '<br>';
            echo '</div>';
            $warnings++;
            
            echo '<div class="info">';
            echo '<strong>Solución:</strong><br>';
            echo '<a href="' . admin_url('post.php?post=' . $page->ID . '&action=edit') . '" class="btn">Editar y Publicar</a>';
            echo '</div>';
            
        } else {
            echo '<div class="error">';
            echo '❌ <strong>Página no existe</strong><br>';
            echo 'Necesitas crear la página "Anuncios"';
            echo '</div>';
            $issues++;
            
            echo '<div class="info">';
            echo '<strong>Soluciones:</strong><br>';
            echo '<a href="/restaurar-anuncios-simple.php" class="btn btn-warning">Intentar Restaurar</a>';
            echo '<a href="' . admin_url('post-new.php?post_type=page') . '" class="btn">Crear Nueva Página</a>';
            echo '</div>';
        }
        ?>
        
        <h2>3️⃣ Archivos del Sistema</h2>
        <?php
        $files_to_check = array(
            'Plantilla WordPress' => 'wp-content/themes/mongruas-theme/page-templates/page-anuncios.php',
            'Template Part' => 'wp-content/themes/mongruas-theme/template-parts/upcoming-courses-section.php',
            'Versión Standalone' => 'anuncios.php',
            'Script Restauración' => 'restaurar-anuncios-simple.php'
        );
        
        echo '<table>';
        echo '<tr><th>Archivo</th><th>Estado</th><th>Ruta</th></tr>';
        foreach ($files_to_check as $name => $path) {
            $full_path = ABSPATH . $path;
            $exists = file_exists($full_path);
            echo '<tr>';
            echo '<td>' . $name . '</td>';
            echo '<td>' . ($exists ? '<span class="status-ok">✅ Existe</span>' : '<span class="status-error">❌ No existe</span>') . '</td>';
            echo '<td><code>' . $path . '</code></td>';
            echo '</tr>';
            if ($exists) $success++; else $issues++;
        }
        echo '</table>';
        ?>
        
        <h2>4️⃣ Enlaces de Prueba</h2>
        <div class="info">
            <strong>Prueba estos enlaces:</strong><br><br>
            <a href="/" class="btn" target="_blank">Página Principal</a>
            <a href="/anuncios/" class="btn" target="_blank">Página Anuncios (WordPress)</a>
            <a href="/anuncios.php" class="btn" target="_blank">Versión Standalone</a>
            <a href="/curso-detalle.php?id=1" class="btn" target="_blank">Detalle de Curso</a>
        </div>
        
        <h2>📊 Resumen</h2>
        <?php
        $total = $success + $warnings + $issues;
        echo '<table>';
        echo '<tr><th>Estado</th><th>Cantidad</th><th>Porcentaje</th></tr>';
        echo '<tr><td><span class="status-ok">✅ Correcto</span></td><td>' . $success . '</td><td>' . round(($success/$total)*100) . '%</td></tr>';
        echo '<tr><td><span class="status-warning">⚠️ Advertencias</span></td><td>' . $warnings . '</td><td>' . round(($warnings/$total)*100) . '%</td></tr>';
        echo '<tr><td><span class="status-error">❌ Errores</span></td><td>' . $issues . '</td><td>' . round(($issues/$total)*100) . '%</td></tr>';
        echo '</table>';
        
        if ($issues == 0 && $warnings == 0) {
            echo '<div class="success">';
            echo '<h3>🎉 ¡TODO PERFECTO!</h3>';
            echo '<p>El sistema está funcionando correctamente. Puedes usar la página de anuncios sin problemas.</p>';
            echo '</div>';
        } elseif ($issues == 0) {
            echo '<div class="warning">';
            echo '<h3>⚠️ CASI LISTO</h3>';
            echo '<p>Hay algunas advertencias que deberías revisar, pero el sistema debería funcionar.</p>';
            echo '</div>';
        } else {
            echo '<div class="error">';
            echo '<h3>❌ REQUIERE ATENCIÓN</h3>';
            echo '<p>Hay errores que necesitan ser corregidos para que el sistema funcione correctamente.</p>';
            echo '</div>';
        }
        ?>
        
        <h2>📖 Documentación</h2>
        <div class="info">
            <p>Para más información, consulta:</p>
            <ul>
                <li><strong>SOLUCION-ANUNCIOS-FINAL.md</strong> - Guía completa de la solución</li>
                <li><strong>restaurar-anuncios-simple.php</strong> - Script de restauración</li>
            </ul>
        </div>
        
        <p style="text-align: center; margin-top: 40px;">
            <a href="/" class="btn">Volver al Inicio</a>
            <a href="javascript:location.reload()" class="btn btn-success">Actualizar Verificación</a>
        </p>
    </div>
</body>
</html>

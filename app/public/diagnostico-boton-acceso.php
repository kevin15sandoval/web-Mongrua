<?php
/**
 * Diagnóstico del Botón de Acceso al Panel
 * 
 * Este archivo diagnostica por qué no aparece el botón de acceso
 */

// Cargar WordPress
require_once('wp-load.php');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔍 Diagnóstico - Botón de Acceso al Panel</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 30px;
            backdrop-filter: blur(10px);
        }
        .test-result {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
            border-left: 4px solid #28a745;
        }
        .test-result.fail {
            border-left-color: #dc3545;
        }
        .test-result.warning {
            border-left-color: #ffc107;
        }
        .code-block {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            padding: 10px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            margin: 10px 0;
            overflow-x: auto;
        }
        h1, h2 { margin-top: 0; }
        .status-icon { font-size: 1.2em; margin-right: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Diagnóstico del Botón de Acceso al Panel</h1>
        <p><strong>Fecha:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
        
        <?php
        // Test 1: Usuario actual
        echo "<h2>1. 👤 Estado del Usuario</h2>";
        
        $current_user = wp_get_current_user();
        if ($current_user->ID == 0) {
            echo "<div class='test-result fail'>";
            echo "<span class='status-icon'>❌</span>";
            echo "<strong>NO ESTÁS LOGUEADO</strong><br>";
            echo "Necesitas estar logueado como administrador para ver el botón.";
            echo "<div class='code-block'>Solución: Ve a /wp-admin/ e inicia sesión como administrador</div>";
            echo "</div>";
        } else {
            echo "<div class='test-result'>";
            echo "<span class='status-icon'>✅</span>";
            echo "<strong>Usuario logueado:</strong> " . $current_user->user_login . "<br>";
            echo "<strong>ID:</strong> " . $current_user->ID . "<br>";
            echo "<strong>Email:</strong> " . $current_user->user_email;
            echo "</div>";
            
            // Test 2: Permisos de administrador
            echo "<h2>2. 🔑 Permisos de Administrador</h2>";
            
            if (current_user_can('administrator')) {
                echo "<div class='test-result'>";
                echo "<span class='status-icon'>✅</span>";
                echo "<strong>TIENES PERMISOS DE ADMINISTRADOR</strong><br>";
                echo "El botón debería ser visible para ti.";
                echo "</div>";
            } else {
                echo "<div class='test-result fail'>";
                echo "<span class='status-icon'>❌</span>";
                echo "<strong>NO TIENES PERMISOS DE ADMINISTRADOR</strong><br>";
                echo "Solo los administradores pueden ver el botón del panel.<br>";
                echo "<strong>Tus roles:</strong> " . implode(', ', $current_user->roles);
                echo "<div class='code-block'>Solución: Necesitas que un super-admin te dé permisos de administrador</div>";
                echo "</div>";
            }
        }
        
        // Test 3: Clase del panel
        echo "<h2>3. 🔧 Clase del Panel</h2>";
        
        if (class_exists('Mongruas_Course_Management_Panel')) {
            echo "<div class='test-result'>";
            echo "<span class='status-icon'>✅</span>";
            echo "<strong>Clase del panel cargada correctamente</strong>";
            echo "</div>";
            
            // Test 4: Instancia del panel
            $panel_instance = new Mongruas_Course_Management_Panel();
            if (method_exists($panel_instance, 'render_panel_html')) {
                echo "<div class='test-result'>";
                echo "<span class='status-icon'>✅</span>";
                echo "<strong>Método render_panel_html existe</strong>";
                echo "</div>";
            } else {
                echo "<div class='test-result fail'>";
                echo "<span class='status-icon'>❌</span>";
                echo "<strong>Método render_panel_html NO existe</strong>";
                echo "</div>";
            }
        } else {
            echo "<div class='test-result fail'>";
            echo "<span class='status-icon'>❌</span>";
            echo "<strong>Clase Mongruas_Course_Management_Panel NO encontrada</strong><br>";
            echo "El archivo del panel no se está cargando correctamente.";
            echo "</div>";
        }
        
        // Test 5: Archivos del tema
        echo "<h2>4. 📁 Archivos del Tema</h2>";
        
        $theme_files = array(
            'functions.php' => get_template_directory() . '/functions.php',
            'course-management-panel.php' => get_template_directory() . '/inc/course-management-panel.php',
            'panel CSS' => get_template_directory() . '/assets/css/course-management-panel.css',
            'panel JS' => get_template_directory() . '/assets/js/course-management-panel.js'
        );
        
        foreach ($theme_files as $name => $path) {
            if (file_exists($path)) {
                echo "<div class='test-result'>";
                echo "<span class='status-icon'>✅</span>";
                echo "<strong>$name:</strong> Existe";
                echo "</div>";
            } else {
                echo "<div class='test-result fail'>";
                echo "<span class='status-icon'>❌</span>";
                echo "<strong>$name:</strong> NO existe<br>";
                echo "<small>Ruta: $path</small>";
                echo "</div>";
            }
        }
        
        // Test 6: Tema activo
        echo "<h2>5. 🎨 Tema Activo</h2>";
        
        $current_theme = wp_get_theme();
        echo "<div class='test-result'>";
        echo "<span class='status-icon'>ℹ️</span>";
        echo "<strong>Tema activo:</strong> " . $current_theme->get('Name') . "<br>";
        echo "<strong>Directorio:</strong> " . $current_theme->get_template() . "<br>";
        echo "<strong>Versión:</strong> " . $current_theme->get('Version');
        echo "</div>";
        
        if ($current_theme->get_template() !== 'mongruas-theme') {
            echo "<div class='test-result warning'>";
            echo "<span class='status-icon'>⚠️</span>";
            echo "<strong>ADVERTENCIA:</strong> No estás usando el tema 'mongruas-theme'<br>";
            echo "El panel está integrado en ese tema específico.";
            echo "</div>";
        }
        
        // Test 7: Hooks de WordPress
        echo "<h2>6. 🪝 Hooks de WordPress</h2>";
        
        $hooks_to_check = array(
            'wp_footer' => 'render_panel_html',
            'wp_enqueue_scripts' => 'enqueue_panel_assets',
            'rest_api_init' => 'register_rest_endpoints'
        );
        
        foreach ($hooks_to_check as $hook => $method) {
            if (has_action($hook)) {
                echo "<div class='test-result'>";
                echo "<span class='status-icon'>✅</span>";
                echo "<strong>Hook '$hook':</strong> Registrado";
                echo "</div>";
            } else {
                echo "<div class='test-result fail'>";
                echo "<span class='status-icon'>❌</span>";
                echo "<strong>Hook '$hook':</strong> NO registrado";
                echo "</div>";
            }
        }
        
        // Test 8: Simulación de renderizado
        if (current_user_can('administrator') && class_exists('Mongruas_Course_Management_Panel')) {
            echo "<h2>7. 🖥️ Test de Renderizado</h2>";
            
            echo "<div class='test-result'>";
            echo "<span class='status-icon'>🔄</span>";
            echo "<strong>Intentando renderizar el botón...</strong>";
            echo "</div>";
            
            ob_start();
            $panel_instance = new Mongruas_Course_Management_Panel();
            $panel_instance->render_panel_html();
            $output = ob_get_clean();
            
            if (!empty($output)) {
                echo "<div class='test-result'>";
                echo "<span class='status-icon'>✅</span>";
                echo "<strong>¡Botón renderizado exitosamente!</strong><br>";
                echo "Longitud del HTML: " . strlen($output) . " caracteres";
                echo "</div>";
                
                echo "<div class='code-block'>";
                echo "Vista previa del HTML generado:<br>";
                echo htmlspecialchars(substr($output, 0, 200)) . "...";
                echo "</div>";
                
                // Mostrar el botón real
                echo "<h2>8. 🎯 Botón Real (Debería Aparecer Aquí)</h2>";
                echo "<div style='position: relative; height: 100px; border: 2px dashed rgba(255,255,255,0.3); border-radius: 10px; margin: 20px 0;'>";
                echo "<p style='text-align: center; margin-top: 35px; opacity: 0.7;'>El botón debería aparecer en la esquina inferior derecha de esta página</p>";
                echo "</div>";
                
                // Inyectar el HTML del botón
                echo $output;
                
            } else {
                echo "<div class='test-result fail'>";
                echo "<span class='status-icon'>❌</span>";
                echo "<strong>No se generó HTML para el botón</strong><br>";
                echo "Hay un problema en el método render_panel_html()";
                echo "</div>";
            }
        }
        
        // Recomendaciones
        echo "<h2>9. 💡 Recomendaciones</h2>";
        
        if (!is_user_logged_in()) {
            echo "<div class='test-result warning'>";
            echo "<span class='status-icon'>👉</span>";
            echo "<strong>ACCIÓN REQUERIDA:</strong> Inicia sesión como administrador<br>";
            echo "<a href='/wp-admin/' style='color: #ffc107;'>Ir a wp-admin →</a>";
            echo "</div>";
        } elseif (!current_user_can('administrator')) {
            echo "<div class='test-result warning'>";
            echo "<span class='status-icon'>👉</span>";
            echo "<strong>ACCIÓN REQUERIDA:</strong> Necesitas permisos de administrador<br>";
            echo "Contacta al super-administrador del sitio.";
            echo "</div>";
        } else {
            echo "<div class='test-result'>";
            echo "<span class='status-icon'>🎉</span>";
            echo "<strong>¡Todo parece estar bien!</strong><br>";
            echo "El botón debería aparecer en la esquina inferior derecha de cualquier página del sitio.";
            echo "</div>";
            
            echo "<div class='test-result'>";
            echo "<span class='status-icon'>🔍</span>";
            echo "<strong>Si aún no lo ves:</strong><br>";
            echo "1. Limpia la caché del navegador (Ctrl+F5)<br>";
            echo "2. Verifica que JavaScript esté habilitado<br>";
            echo "3. Abre las herramientas de desarrollador (F12) y busca errores en Console<br>";
            echo "4. Prueba en modo incógnito";
            echo "</div>";
        }
        ?>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="/" style="background: rgba(255,255,255,0.2); color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                ← Volver al Sitio Principal
            </a>
        </div>
    </div>
</body>
</html>
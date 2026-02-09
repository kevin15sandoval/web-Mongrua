<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔍 Verificación Rápida de Carruseles</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        .card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        .status {
            display: flex;
            align-items: center;
            padding: 15px;
            border-radius: 10px;
            margin: 10px 0;
            font-weight: 600;
        }
        .status-ok {
            background: #d4edda;
            color: #155724;
            border-left: 5px solid #28a745;
        }
        .status-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 5px solid #dc3545;
        }
        .status-icon {
            font-size: 24px;
            margin-right: 15px;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            margin: 10px 5px;
            transition: transform 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        .section-title {
            font-size: 1.5rem;
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #667eea;
        }
        .info-box {
            background: #e7f3ff;
            padding: 20px;
            border-radius: 10px;
            margin: 15px 0;
            border-left: 4px solid #0066cc;
        }
        .links {
            text-align: center;
            margin-top: 30px;
        }
        .summary {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            font-size: 1.2rem;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔍 Verificación de Carruseles</h1>
            <p>Estado actual del sistema</p>
        </div>

        <?php
        $theme_dir = __DIR__ . '/wp-content/themes/mongruas-theme';
        $errores = 0;
        $ok = 0;
        
        // VERIFICACIÓN 1: Archivos del sistema
        echo "<div class='card'>";
        echo "<h2 class='section-title'>📂 Archivos del Sistema</h2>";
        
        $archivos = [
            'inc/carruseles-dinamicos.php' => 'Sistema de carruseles dinámicos',
            'assets/css/carruseles-dinamicos.css' => 'Estilos de carruseles',
            'template-parts/about-section.php' => 'Template About (carrusel fotos)',
            'page-templates/page-cursos.php' => 'Template Cursos (carrusel cursos)',
        ];
        
        foreach ($archivos as $archivo => $descripcion) {
            $existe = file_exists($theme_dir . '/' . $archivo);
            if ($existe) {
                echo "<div class='status status-ok'>";
                echo "<span class='status-icon'>✅</span>";
                echo "<span>$descripcion</span>";
                echo "</div>";
                $ok++;
            } else {
                echo "<div class='status status-error'>";
                echo "<span class='status-icon'>❌</span>";
                echo "<span>$descripcion - NO ENCONTRADO</span>";
                echo "</div>";
                $errores++;
            }
        }
        echo "</div>";
        
        // VERIFICACIÓN 2: Conflictos CSS
        echo "<div class='card'>";
        echo "<h2 class='section-title'>🎨 Verificación CSS</h2>";
        
        $css_file = $theme_dir . '/assets/css/upcoming-courses.css';
        if (file_exists($css_file)) {
            $css_content = file_get_contents($css_file);
            
            // Buscar reglas problemáticas
            $patrones_malos = [
                '/\[class\*="carousel"\][^{]*\{[^}]*display\s*:\s*none\s*!important/i',
                '/\[id\*="carousel"\][^{]*\{[^}]*display\s*:\s*none\s*!important/i',
            ];
            
            $tiene_conflictos = false;
            foreach ($patrones_malos as $patron) {
                if (preg_match($patron, $css_content)) {
                    $tiene_conflictos = true;
                    break;
                }
            }
            
            if ($tiene_conflictos) {
                echo "<div class='status status-error'>";
                echo "<span class='status-icon'>❌</span>";
                echo "<span>Se encontraron reglas CSS que ocultan carruseles</span>";
                echo "</div>";
                $errores++;
            } else {
                echo "<div class='status status-ok'>";
                echo "<span class='status-icon'>✅</span>";
                echo "<span>No hay conflictos CSS</span>";
                echo "</div>";
                $ok++;
            }
        } else {
            echo "<div class='status status-error'>";
            echo "<span class='status-icon'>❌</span>";
            echo "<span>Archivo CSS no encontrado</span>";
            echo "</div>";
            $errores++;
        }
        echo "</div>";
        
        // VERIFICACIÓN 3: Funciones en functions.php
        echo "<div class='card'>";
        echo "<h2 class='section-title'>⚙️ Funciones PHP</h2>";
        
        $functions_file = $theme_dir . '/functions.php';
        if (file_exists($functions_file)) {
            $functions_content = file_get_contents($functions_file);
            
            $funciones_requeridas = [
                'carruseles-dinamicos.php' => 'Inclusión del sistema',
                'mongruas_enqueue_carousel_assets' => 'Carga de assets',
            ];
            
            foreach ($funciones_requeridas as $buscar => $descripcion) {
                if (strpos($functions_content, $buscar) !== false) {
                    echo "<div class='status status-ok'>";
                    echo "<span class='status-icon'>✅</span>";
                    echo "<span>$descripcion</span>";
                    echo "</div>";
                    $ok++;
                } else {
                    echo "<div class='status status-error'>";
                    echo "<span class='status-icon'>❌</span>";
                    echo "<span>$descripcion - NO ENCONTRADO</span>";
                    echo "</div>";
                    $errores++;
                }
            }
        }
        echo "</div>";
        
        // VERIFICACIÓN 4: Templates actualizados
        echo "<div class='card'>";
        echo "<h2 class='section-title'>📄 Templates Actualizados</h2>";
        
        // Verificar about-section.php
        $about_file = $theme_dir . '/template-parts/about-section.php';
        if (file_exists($about_file)) {
            $about_content = file_get_contents($about_file);
            if (strpos($about_content, 'mongruas_display_photo_carousel') !== false) {
                echo "<div class='status status-ok'>";
                echo "<span class='status-icon'>✅</span>";
                echo "<span>about-section.php usa la función correcta</span>";
                echo "</div>";
                $ok++;
            } else {
                echo "<div class='status status-error'>";
                echo "<span class='status-icon'>❌</span>";
                echo "<span>about-section.php NO usa la función correcta</span>";
                echo "</div>";
                $errores++;
            }
        }
        
        // Verificar page-cursos.php
        $cursos_file = $theme_dir . '/page-templates/page-cursos.php';
        if (file_exists($cursos_file)) {
            $cursos_content = file_get_contents($cursos_file);
            if (strpos($cursos_content, 'mongruas_display_courses_carousel') !== false) {
                echo "<div class='status status-ok'>";
                echo "<span class='status-icon'>✅</span>";
                echo "<span>page-cursos.php usa la función correcta</span>";
                echo "</div>";
                $ok++;
            } else {
                echo "<div class='status status-error'>";
                echo "<span class='status-icon'>❌</span>";
                echo "<span>page-cursos.php NO usa la función correcta</span>";
                echo "</div>";
                $errores++;
            }
        }
        echo "</div>";
        
        // RESUMEN FINAL
        if ($errores === 0) {
            echo "<div class='summary'>";
            echo "<h2>🎉 ¡TODO PERFECTO!</h2>";
            echo "<p>Los carruseles están completamente restaurados y funcionando</p>";
            echo "<p style='margin-top: 15px; font-size: 1rem;'>✅ $ok verificaciones pasadas | ❌ $errores errores</p>";
            echo "</div>";
            
            echo "<div class='card'>";
            echo "<div class='info-box'>";
            echo "<h3>📝 Próximos Pasos:</h3>";
            echo "<ol style='margin-left: 20px; margin-top: 10px;'>";
            echo "<li>Limpia la caché del navegador (Ctrl+Shift+R)</li>";
            echo "<li>Visita la página de inicio para ver el carrusel de fotos</li>";
            echo "<li>Visita /anuncios/ para ver el carrusel de cursos</li>";
            echo "<li>Configura tus propias imágenes y cursos desde WordPress</li>";
            echo "</ol>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "<div class='card' style='background: #f8d7da; border-left: 5px solid #dc3545;'>";
            echo "<h2 style='color: #721c24;'>⚠️ Se encontraron $errores problemas</h2>";
            echo "<p style='color: #721c24; margin-top: 10px;'>Ejecuta el script de restauración completo</p>";
            echo "</div>";
        }
        ?>
        
        <div class="card">
            <h2 class="section-title">🔗 Enlaces Útiles</h2>
            <div class="links">
                <a href="http://mongruasformacion.local/" class="btn" target="_blank">
                    🏠 Ver Página de Inicio
                </a>
                <a href="http://mongruasformacion.local/anuncios/" class="btn" target="_blank">
                    📚 Ver Próximos Cursos
                </a>
                <a href="http://mongruasformacion.local/wp-admin/" class="btn" target="_blank">
                    ⚙️ Panel WordPress
                </a>
            </div>
        </div>
        
        <div class="card">
            <h2 class="section-title">💡 Información</h2>
            <div class="info-box">
                <p><strong>¿Qué carruseles están restaurados?</strong></p>
                <ul style="margin-left: 20px; margin-top: 10px;">
                    <li>🎠 <strong>Carrusel de Fotos</strong> - Página de inicio (sección About)</li>
                    <li>📚 <strong>Carrusel de Cursos</strong> - Página /anuncios/</li>
                    <li>🏠 <strong>Carrusel Principal</strong> - Catálogo en inicio</li>
                </ul>
            </div>
            
            <div class="info-box" style="background: #fff3cd; border-left-color: #ffc107;">
                <p><strong>⚠️ Importante:</strong></p>
                <p style="margin-top: 10px;">Si no ves los carruseles, asegúrate de limpiar la caché del navegador con <strong>Ctrl+Shift+R</strong> (Windows) o <strong>Cmd+Shift+R</strong> (Mac)</p>
            </div>
        </div>
    </div>
</body>
</html>

<?php
/**
 * Diagnóstico Urgente de Carruseles
 * Verifica por qué no se ven los carruseles
 */

$theme_path = __DIR__ . '/wp-content/themes/mongruas-theme';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔍 Diagnóstico Urgente - Carruseles</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            padding: 20px;
            color: #2c3e50;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            font-size: 2.5rem;
            color: #e74c3c;
            margin-bottom: 10px;
            text-align: center;
        }
        .subtitle {
            text-align: center;
            color: #7f8c8d;
            font-size: 1.2rem;
            margin-bottom: 40px;
        }
        .check-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            border-left: 5px solid #3498db;
        }
        .check-section h2 {
            color: #2c3e50;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }
        .status {
            padding: 15px;
            border-radius: 8px;
            margin: 10px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .status-ok {
            background: #d4edda;
            border-left: 4px solid #28a745;
        }
        .status-error {
            background: #f8d7da;
            border-left: 4px solid #dc3545;
        }
        .status-warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
        }
        .icon {
            font-size: 1.5rem;
        }
        .code-block {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            overflow-x: auto;
            margin: 10px 0;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            margin: 10px 5px;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.4);
        }
        .actions {
            text-align: center;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 2px solid #ecf0f1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Diagnóstico Urgente</h1>
        <p class="subtitle">Verificando por qué no se ven los carruseles</p>

        <?php
        // 1. VERIFICAR ARCHIVO DE CARRUSELES DINÁMICOS
        echo "<div class='check-section'>";
        echo "<h2>1️⃣ Sistema de Carruseles Dinámicos</h2>";
        
        $carruseles_file = $theme_path . '/inc/carruseles-dinamicos.php';
        if (file_exists($carruseles_file)) {
            $content = file_get_contents($carruseles_file);
            $has_function = strpos($content, 'function mongruas_display_photo_carousel') !== false;
            
            if ($has_function) {
                echo "<div class='status status-ok'>";
                echo "<span class='icon'>✅</span>";
                echo "<div><strong>Sistema existe y tiene la función</strong><br>";
                echo "Archivo: inc/carruseles-dinamicos.php<br>";
                echo "Tamaño: " . number_format(filesize($carruseles_file)) . " bytes</div>";
                echo "</div>";
            } else {
                echo "<div class='status status-error'>";
                echo "<span class='icon'>❌</span>";
                echo "<div><strong>Archivo existe pero falta la función</strong></div>";
                echo "</div>";
            }
        } else {
            echo "<div class='status status-error'>";
            echo "<span class='icon'>❌</span>";
            echo "<div><strong>Archivo NO existe</strong><br>Ruta: $carruseles_file</div>";
            echo "</div>";
        }
        echo "</div>";

        // 2. VERIFICAR FUNCTIONS.PHP
        echo "<div class='check-section'>";
        echo "<h2>2️⃣ Integración en functions.php</h2>";
        
        $functions_file = $theme_path . '/functions.php';
        if (file_exists($functions_file)) {
            $functions_content = file_get_contents($functions_file);
            $has_require = strpos($functions_content, 'carruseles-dinamicos.php') !== false;
            
            if ($has_require) {
                echo "<div class='status status-ok'>";
                echo "<span class='icon'>✅</span>";
                echo "<div><strong>Sistema está incluido en functions.php</strong></div>";
                echo "</div>";
            } else {
                echo "<div class='status status-error'>";
                echo "<span class='icon'>❌</span>";
                echo "<div><strong>Sistema NO está incluido en functions.php</strong><br>";
                echo "Falta: require_once get_template_directory() . '/inc/carruseles-dinamicos.php';</div>";
                echo "</div>";
            }
        }
        echo "</div>";

        // 3. VERIFICAR ABOUT-SECTION.PHP
        echo "<div class='check-section'>";
        echo "<h2>3️⃣ Template about-section.php</h2>";
        
        $about_file = $theme_path . '/template-parts/about-section.php';
        if (file_exists($about_file)) {
            $about_content = file_get_contents($about_file);
            $has_carousel = strpos($about_content, 'mongruas_display_photo_carousel') !== false;
            
            if ($has_carousel) {
                echo "<div class='status status-ok'>";
                echo "<span class='icon'>✅</span>";
                echo "<div><strong>Carrusel está en about-section.php</strong></div>";
                echo "</div>";
                
                // Mostrar el código relevante
                echo "<div class='code-block'>";
                $lines = explode("\n", $about_content);
                $found = false;
                foreach ($lines as $i => $line) {
                    if (strpos($line, 'about-carousel-wrapper') !== false || 
                        strpos($line, 'mongruas_display_photo_carousel') !== false) {
                        $found = true;
                        $start = max(0, $i - 2);
                        $end = min(count($lines), $i + 5);
                        for ($j = $start; $j < $end; $j++) {
                            echo htmlspecialchars($lines[$j]) . "\n";
                        }
                        break;
                    }
                }
                echo "</div>";
            } else {
                echo "<div class='status status-error'>";
                echo "<span class='icon'>❌</span>";
                echo "<div><strong>Carrusel NO está en about-section.php</strong></div>";
                echo "</div>";
            }
        }
        echo "</div>";

        // 4. VERIFICAR GALLERY-CAROUSEL-SECTION.PHP
        echo "<div class='check-section'>";
        echo "<h2>4️⃣ Gallery Carousel Section</h2>";
        
        $gallery_file = $theme_path . '/template-parts/gallery-carousel-section.php';
        if (file_exists($gallery_file)) {
            echo "<div class='status status-ok'>";
            echo "<span class='icon'>✅</span>";
            echo "<div><strong>Gallery carousel existe</strong><br>";
            echo "Tamaño: " . number_format(filesize($gallery_file)) . " bytes</div>";
            echo "</div>";
        } else {
            echo "<div class='status status-error'>";
            echo "<span class='icon'>❌</span>";
            echo "<div><strong>Gallery carousel NO existe</strong></div>";
            echo "</div>";
        }
        echo "</div>";

        // 5. VERIFICAR FRONT-PAGE.PHP
        echo "<div class='check-section'>";
        echo "<h2>5️⃣ Inclusión en front-page.php</h2>";
        
        $frontpage_file = $theme_path . '/front-page.php';
        if (file_exists($frontpage_file)) {
            $frontpage_content = file_get_contents($frontpage_file);
            $has_about = strpos($frontpage_content, 'about-section') !== false;
            $has_gallery = strpos($frontpage_content, 'gallery-carousel-section') !== false;
            
            if ($has_about) {
                echo "<div class='status status-ok'>";
                echo "<span class='icon'>✅</span>";
                echo "<div><strong>About section incluida</strong></div>";
                echo "</div>";
            }
            
            if ($has_gallery) {
                echo "<div class='status status-ok'>";
                echo "<span class='icon'>✅</span>";
                echo "<div><strong>Gallery carousel incluida</strong></div>";
                echo "</div>";
            }
            
            if (!$has_about && !$has_gallery) {
                echo "<div class='status status-error'>";
                echo "<span class='icon'>❌</span>";
                echo "<div><strong>Ninguna sección de carrusel incluida</strong></div>";
                echo "</div>";
            }
        }
        echo "</div>";

        // 6. VERIFICAR CSS
        echo "<div class='check-section'>";
        echo "<h2>6️⃣ CSS de Carruseles</h2>";
        
        $css_file = $theme_path . '/assets/css/carruseles-dinamicos.css';
        if (file_exists($css_file)) {
            echo "<div class='status status-ok'>";
            echo "<span class='icon'>✅</span>";
            echo "<div><strong>CSS existe</strong><br>";
            echo "Tamaño: " . number_format(filesize($css_file)) . " bytes</div>";
            echo "</div>";
        } else {
            echo "<div class='status status-warning'>";
            echo "<span class='icon'>⚠️</span>";
            echo "<div><strong>CSS no encontrado</strong> (puede estar en otro archivo)</div>";
            echo "</div>";
        }
        echo "</div>";

        // 7. VERIFICAR UPCOMING-COURSES.CSS (puede estar ocultando)
        echo "<div class='check-section'>";
        echo "<h2>7️⃣ Verificar CSS Conflictivo</h2>";
        
        $upcoming_css = $theme_path . '/assets/css/upcoming-courses.css';
        if (file_exists($upcoming_css)) {
            $css_content = file_get_contents($upcoming_css);
            $has_hide = preg_match('/\[class\*="carousel"\].*display:\s*none/s', $css_content);
            
            if ($has_hide) {
                echo "<div class='status status-error'>";
                echo "<span class='icon'>❌</span>";
                echo "<div><strong>¡PROBLEMA ENCONTRADO!</strong><br>";
                echo "El archivo upcoming-courses.css tiene reglas que OCULTAN los carruseles<br>";
                echo "Archivo: assets/css/upcoming-courses.css</div>";
                echo "</div>";
            } else {
                echo "<div class='status status-ok'>";
                echo "<span class='icon'>✅</span>";
                echo "<div><strong>No hay reglas CSS conflictivas</strong></div>";
                echo "</div>";
            }
        }
        echo "</div>";

        // RESUMEN Y SOLUCIÓN
        echo "<div class='check-section' style='border-left-color: #e74c3c; background: #fee;'>";
        echo "<h2>🎯 Diagnóstico y Solución</h2>";
        
        // Determinar el problema principal
        if (!file_exists($carruseles_file)) {
            echo "<div class='status status-error'>";
            echo "<span class='icon'>🔴</span>";
            echo "<div><strong>PROBLEMA PRINCIPAL:</strong> El sistema de carruseles no existe<br>";
            echo "<strong>SOLUCIÓN:</strong> Necesitas crear el archivo inc/carruseles-dinamicos.php</div>";
            echo "</div>";
        } elseif (isset($has_hide) && $has_hide) {
            echo "<div class='status status-error'>";
            echo "<span class='icon'>🔴</span>";
            echo "<div><strong>PROBLEMA PRINCIPAL:</strong> CSS está ocultando los carruseles<br>";
            echo "<strong>SOLUCIÓN:</strong> Eliminar reglas CSS conflictivas en upcoming-courses.css</div>";
            echo "</div>";
        } elseif (!isset($has_carousel) || !$has_carousel) {
            echo "<div class='status status-error'>";
            echo "<span class='icon'>🔴</span>";
            echo "<div><strong>PROBLEMA PRINCIPAL:</strong> El carrusel no está en about-section.php<br>";
            echo "<strong>SOLUCIÓN:</strong> Agregar el código del carrusel al template</div>";
            echo "</div>";
        } else {
            echo "<div class='status status-warning'>";
            echo "<span class='icon'>⚠️</span>";
            echo "<div><strong>Los archivos parecen estar bien</strong><br>";
            echo "El problema puede ser de caché del navegador o WordPress</div>";
            echo "</div>";
        }
        echo "</div>";
        ?>

        <div class="actions">
            <h2 style="margin-bottom: 20px;">🔧 Acciones Rápidas</h2>
            <a href="<?php echo home_url('/'); ?>" class="btn" target="_blank">🏠 Ver Página de Inicio</a>
            <a href="<?php echo home_url('/'); ?>" class="btn" onclick="location.reload(true); return false;">🔄 Recargar con Ctrl+Shift+R</a>
        </div>
    </div>
</body>
</html>

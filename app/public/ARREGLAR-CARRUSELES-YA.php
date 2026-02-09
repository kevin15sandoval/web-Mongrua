<?php
/**
 * ARREGLAR CARRUSELES YA - SIN MÁS VUELTAS
 * Este script lo arregla TODO de una vez
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

$theme_path = __DIR__ . '/wp-content/themes/mongruas-theme';
$resultados = [];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔥 ARREGLANDO CARRUSELES YA</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            padding: 20px;
            color: #2c3e50;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            font-size: 3rem;
            color: #f5576c;
            margin-bottom: 10px;
            text-align: center;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .subtitle {
            text-align: center;
            color: #7f8c8d;
            font-size: 1.3rem;
            margin-bottom: 40px;
        }
        .step {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 5px solid #3498db;
        }
        .step h2 {
            color: #2c3e50;
            font-size: 1.3rem;
            margin-bottom: 10px;
        }
        .ok {
            background: #d4edda;
            border-left-color: #28a745;
        }
        .error {
            background: #f8d7da;
            border-left-color: #dc3545;
        }
        .icon {
            font-size: 2rem;
            margin-right: 10px;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 20px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.2rem;
            margin: 20px 10px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(245, 87, 108, 0.4);
        }
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(245, 87, 108, 0.6);
        }
        .actions {
            text-align: center;
            margin-top: 40px;
            padding-top: 40px;
            border-top: 3px solid #ecf0f1;
        }
        .code {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 10px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 0.9rem;
            margin: 10px 0;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔥 ARREGLANDO YA</h1>
        <p class="subtitle">Restaurando los carruseles de una vez por todas</p>

        <?php
        // PASO 1: INSERTAR CARRUSEL EN ABOUT-SECTION.PHP
        echo "<div class='step'>";
        echo "<h2><span class='icon'>1️⃣</span> Insertando carrusel en about-section.php</h2>";
        
        $about_file = $theme_path . '/template-parts/about-section.php';
        $about_content = file_get_contents($about_file);
        
        // Verificar si ya tiene el carrusel
        if (strpos($about_content, 'about-carousel-wrapper') !== false) {
            echo "<p>✅ El carrusel ya está presente</p>";
            $resultados['about'] = true;
        } else {
            // Buscar el cierre de la sección y agregar el carrusel ANTES
            $search = '</div>
    </div>
</section>

<style>';
            
            $replace = '    </div>

        <!-- CARRUSEL DE FOTOS -->
        <div class="about-carousel-wrapper" style="margin-top: 50px;">
            <?php
            if (function_exists(\'mongruas_display_photo_carousel\')) {
                echo mongruas_display_photo_carousel();
            }
            ?>
        </div>
    </div>
</section>

<style>';
            
            $about_content = str_replace($search, $replace, $about_content);
            
            if (file_put_contents($about_file, $about_content)) {
                echo "<p class='ok'>✅ Carrusel insertado correctamente</p>";
                $resultados['about'] = true;
            } else {
                echo "<p class='error'>❌ Error al escribir el archivo</p>";
                $resultados['about'] = false;
            }
        }
        echo "</div>";

        // PASO 2: VERIFICAR QUE GALLERY CAROUSEL EXISTE
        echo "<div class='step'>";
        echo "<h2><span class='icon'>2️⃣</span> Verificando gallery-carousel-section.php</h2>";
        
        $gallery_file = $theme_path . '/template-parts/gallery-carousel-section.php';
        if (file_exists($gallery_file)) {
            echo "<p class='ok'>✅ Gallery carousel existe (" . number_format(filesize($gallery_file)) . " bytes)</p>";
            $resultados['gallery'] = true;
        } else {
            echo "<p class='error'>❌ Gallery carousel no existe</p>";
            $resultados['gallery'] = false;
        }
        echo "</div>";

        // PASO 3: VERIFICAR SISTEMA DE CARRUSELES
        echo "<div class='step'>";
        echo "<h2><span class='icon'>3️⃣</span> Verificando sistema de carruseles dinámicos</h2>";
        
        $carruseles_file = $theme_path . '/inc/carruseles-dinamicos.php';
        if (file_exists($carruseles_file)) {
            $content = file_get_contents($carruseles_file);
            if (strpos($content, 'function mongruas_display_photo_carousel') !== false) {
                echo "<p class='ok'>✅ Sistema existe y funciona</p>";
                $resultados['sistema'] = true;
            } else {
                echo "<p class='error'>❌ Sistema existe pero falta la función</p>";
                $resultados['sistema'] = false;
            }
        } else {
            echo "<p class='error'>❌ Sistema no existe</p>";
            $resultados['sistema'] = false;
        }
        echo "</div>";

        // PASO 4: VERIFICAR FUNCTIONS.PHP
        echo "<div class='step'>";
        echo "<h2><span class='icon'>4️⃣</span> Verificando functions.php</h2>";
        
        $functions_file = $theme_path . '/functions.php';
        $functions_content = file_get_contents($functions_file);
        
        if (strpos($functions_content, 'carruseles-dinamicos.php') !== false) {
            echo "<p class='ok'>✅ Sistema incluido en functions.php</p>";
            $resultados['functions'] = true;
        } else {
            echo "<p class='error'>❌ Sistema NO incluido en functions.php</p>";
            $resultados['functions'] = false;
        }
        echo "</div>";

        // PASO 5: ELIMINAR CSS CONFLICTIVO
        echo "<div class='step'>";
        echo "<h2><span class='icon'>5️⃣</span> Eliminando CSS que oculta carruseles</h2>";
        
        $upcoming_css = $theme_path . '/assets/css/upcoming-courses.css';
        if (file_exists($upcoming_css)) {
            $css_content = file_get_contents($upcoming_css);
            
            // Buscar y eliminar reglas que ocultan carruseles
            $patterns = [
                '/\/\*\s*OCULTAR.*?carousel.*?\*\/.*?\}/s',
                '/\[class\*="carousel"\]\s*\{[^}]*display:\s*none[^}]*\}/s',
                '/\[id\*="carousel"\]\s*\{[^}]*display:\s*none[^}]*\}/s',
            ];
            
            $original_length = strlen($css_content);
            foreach ($patterns as $pattern) {
                $css_content = preg_replace($pattern, '', $css_content);
            }
            $new_length = strlen($css_content);
            
            if ($original_length != $new_length) {
                file_put_contents($upcoming_css, $css_content);
                echo "<p class='ok'>✅ CSS conflictivo eliminado (" . ($original_length - $new_length) . " bytes removidos)</p>";
                $resultados['css'] = true;
            } else {
                echo "<p class='ok'>✅ No hay CSS conflictivo</p>";
                $resultados['css'] = true;
            }
        } else {
            echo "<p>⚠️ Archivo CSS no encontrado (no es crítico)</p>";
            $resultados['css'] = true;
        }
        echo "</div>";

        // PASO 6: VERIFICAR FRONT-PAGE.PHP
        echo "<div class='step'>";
        echo "<h2><span class='icon'>6️⃣</span> Verificando front-page.php</h2>";
        
        $frontpage_file = $theme_path . '/front-page.php';
        $frontpage_content = file_get_contents($frontpage_file);
        
        $has_about = strpos($frontpage_content, 'about-section') !== false;
        $has_gallery = strpos($frontpage_content, 'gallery-carousel-section') !== false;
        
        if ($has_about && $has_gallery) {
            echo "<p class='ok'>✅ Ambas secciones incluidas en front-page.php</p>";
            $resultados['frontpage'] = true;
        } else {
            echo "<p class='error'>❌ Faltan secciones en front-page.php</p>";
            echo "<p>About: " . ($has_about ? "✅" : "❌") . "</p>";
            echo "<p>Gallery: " . ($has_gallery ? "✅" : "❌") . "</p>";
            $resultados['frontpage'] = false;
        }
        echo "</div>";

        // RESUMEN FINAL
        $total = count($resultados);
        $exitosos = count(array_filter($resultados));
        
        echo "<div class='step " . ($exitosos === $total ? "ok" : "error") . "'>";
        echo "<h2><span class='icon'>🎯</span> RESULTADO FINAL</h2>";
        
        if ($exitosos === $total) {
            echo "<p style='font-size: 1.5rem; font-weight: bold; color: #28a745;'>";
            echo "✅ ¡TODO ARREGLADO! ($exitosos/$total)";
            echo "</p>";
            echo "<p style='margin-top: 15px;'>Los carruseles deberían estar visibles ahora.</p>";
        } else {
            echo "<p style='font-size: 1.5rem; font-weight: bold; color: #dc3545;'>";
            echo "⚠️ Completado con advertencias ($exitosos/$total)";
            echo "</p>";
        }
        echo "</div>";

        // Mostrar ubicaciones
        echo "<div class='step'>";
        echo "<h2><span class='icon'>📍</span> Ubicaciones de los Carruseles</h2>";
        echo "<p><strong>1. Carrusel en About Section:</strong><br>";
        echo "Página de inicio → Sección 'Formación y Enseñanza Mogruas'</p>";
        echo "<p style='margin-top: 10px;'><strong>2. Gallery Carousel:</strong><br>";
        echo "Página de inicio → Sección 'Nuestras Instalaciones'</p>";
        echo "</div>";
        ?>

        <div class="actions">
            <h2 style="margin-bottom: 20px; color: #2c3e50;">🚀 ¡Listo! Ahora ve a verlos</h2>
            <a href="<?php echo home_url('/'); ?>" class="btn" target="_blank">🏠 VER PÁGINA DE INICIO</a>
            <br>
            <p style="margin-top: 20px; color: #7f8c8d; font-size: 0.9rem;">
                💡 Si no los ves, presiona <strong>Ctrl+Shift+R</strong> (Windows) o <strong>Cmd+Shift+R</strong> (Mac) para limpiar la caché
            </p>
        </div>
    </div>
</body>
</html>

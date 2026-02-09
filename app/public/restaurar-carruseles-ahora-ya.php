<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✅ Restaurando Carruseles</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 800px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        h1 {
            color: #2c3e50;
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-align: center;
        }
        
        .subtitle {
            text-align: center;
            color: #7f8c8d;
            font-size: 1.1rem;
            margin-bottom: 40px;
        }
        
        .status {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 4px solid #3498db;
        }
        
        .status-ok {
            border-left-color: #27ae60;
            background: #d4edda;
        }
        
        .status-error {
            border-left-color: #e74c3c;
            background: #f8d7da;
        }
        
        .status-icon {
            font-size: 1.5rem;
            margin-right: 10px;
        }
        
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            margin: 10px 5px;
            transition: transform 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
        }
        
        .actions {
            text-align: center;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 2px solid #ecf0f1;
        }
        
        .info {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            margin: 15px 0;
            border-radius: 8px;
        }
        
        code {
            background: #f5f5f5;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            color: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎠 Restaurando Carruseles</h1>
        <p class="subtitle">Recuperando los carruseles en ambos sitios</p>

        <?php
        // Ruta del tema
        $theme_path = __DIR__ . '/wp-content/themes/mongruas-theme';
        
        $resultados = [];
        
        // 1. RESTAURAR CARRUSEL EN ABOUT SECTION (Página de inicio)
        echo "<h2 style='color: #2c3e50; margin: 30px 0 20px 0;'>📸 Carrusel de Fotos (Página de Inicio)</h2>";
        
        $about_file = $theme_path . '/template-parts/about-section.php';
        if (file_exists($about_file)) {
            $about_content = file_get_contents($about_file);
            
            // Verificar si ya tiene el carrusel
            if (strpos($about_content, 'mongruas_display_photo_carousel') !== false) {
                echo "<div class='status status-ok'>";
                echo "<span class='status-icon'>✅</span>";
                echo "<strong>Carrusel ya está presente</strong> en about-section.php";
                echo "</div>";
                $resultados['about'] = true;
            } else {
                // Agregar el carrusel antes del cierre de </div></div></section>
                $search = "            </div>\n\n\n        </div>\n    </div>\n</section>";
                $replace = "            </div>\n\n            <!-- CARRUSEL DE FOTOS RESTAURADO -->\n            <div class=\"about-carousel-wrapper\">\n                <?php\n                if (function_exists('mongruas_display_photo_carousel')) {\n                    echo mongruas_display_photo_carousel();\n                }\n                ?>\n            </div>\n        </div>\n    </div>\n</section>";
                
                $about_content = str_replace($search, $replace, $about_content);
                
                if (file_put_contents($about_file, $about_content)) {
                    echo "<div class='status status-ok'>";
                    echo "<span class='status-icon'>✅</span>";
                    echo "<strong>Carrusel restaurado</strong> en about-section.php";
                    echo "</div>";
                    $resultados['about'] = true;
                } else {
                    echo "<div class='status status-error'>";
                    echo "<span class='status-icon'>❌</span>";
                    echo "<strong>Error:</strong> No se pudo escribir en about-section.php";
                    echo "</div>";
                    $resultados['about'] = false;
                }
            }
        } else {
            echo "<div class='status status-error'>";
            echo "<span class='status-icon'>❌</span>";
            echo "<strong>Error:</strong> No se encontró about-section.php";
            echo "</div>";
            $resultados['about'] = false;
        }
        
        // 2. VERIFICAR GALLERY CAROUSEL SECTION
        echo "<h2 style='color: #2c3e50; margin: 30px 0 20px 0;'>🖼️ Gallery Carousel Section</h2>";
        
        $gallery_file = $theme_path . '/template-parts/gallery-carousel-section.php';
        if (file_exists($gallery_file)) {
            echo "<div class='status status-ok'>";
            echo "<span class='status-icon'>✅</span>";
            echo "<strong>Gallery carousel existe</strong> - gallery-carousel-section.php";
            echo "</div>";
            $resultados['gallery'] = true;
        } else {
            echo "<div class='status status-error'>";
            echo "<span class='status-icon'>❌</span>";
            echo "<strong>Advertencia:</strong> gallery-carousel-section.php no encontrado";
            echo "</div>";
            $resultados['gallery'] = false;
        }
        
        // 3. VERIFICAR FRONT-PAGE.PHP
        echo "<h2 style='color: #2c3e50; margin: 30px 0 20px 0;'>🏠 Verificando Front Page</h2>";
        
        $frontpage_file = $theme_path . '/front-page.php';
        if (file_exists($frontpage_file)) {
            $frontpage_content = file_get_contents($frontpage_file);
            
            if (strpos($frontpage_content, 'gallery-carousel-section') !== false) {
                echo "<div class='status status-ok'>";
                echo "<span class='status-icon'>✅</span>";
                echo "<strong>Gallery carousel incluido</strong> en front-page.php";
                echo "</div>";
                $resultados['frontpage'] = true;
            } else {
                echo "<div class='status status-error'>";
                echo "<span class='status-icon'>⚠️</span>";
                echo "<strong>Advertencia:</strong> Gallery carousel no está incluido en front-page.php";
                echo "</div>";
                $resultados['frontpage'] = false;
            }
        }
        
        // 4. VERIFICAR SISTEMA DE CARRUSELES DINÁMICOS
        echo "<h2 style='color: #2c3e50; margin: 30px 0 20px 0;'>⚙️ Sistema de Carruseles Dinámicos</h2>";
        
        $carruseles_file = $theme_path . '/inc/carruseles-dinamicos.php';
        if (file_exists($carruseles_file)) {
            echo "<div class='status status-ok'>";
            echo "<span class='status-icon'>✅</span>";
            echo "<strong>Sistema de carruseles existe</strong> - inc/carruseles-dinamicos.php";
            echo "</div>";
            $resultados['sistema'] = true;
        } else {
            echo "<div class='status status-error'>";
            echo "<span class='status-icon'>❌</span>";
            echo "<strong>Error:</strong> Sistema de carruseles no encontrado";
            echo "</div>";
            $resultados['sistema'] = false;
        }
        
        // 5. VERIFICAR CSS DE CARRUSELES
        $css_file = $theme_path . '/assets/css/carruseles-dinamicos.css';
        if (file_exists($css_file)) {
            echo "<div class='status status-ok'>";
            echo "<span class='status-icon'>✅</span>";
            echo "<strong>CSS de carruseles existe</strong> - assets/css/carruseles-dinamicos.css";
            echo "</div>";
            $resultados['css'] = true;
        } else {
            echo "<div class='status status-error'>";
            echo "<span class='status-icon'>❌</span>";
            echo "<strong>Error:</strong> CSS de carruseles no encontrado";
            echo "</div>";
            $resultados['css'] = false;
        }
        
        // RESUMEN FINAL
        echo "<h2 style='color: #2c3e50; margin: 40px 0 20px 0;'>📊 Resumen</h2>";
        
        $total = count($resultados);
        $exitosos = count(array_filter($resultados));
        
        if ($exitosos === $total) {
            echo "<div class='status status-ok'>";
            echo "<span class='status-icon'>🎉</span>";
            echo "<strong>¡TODO LISTO!</strong> Los carruseles han sido restaurados correctamente.";
            echo "</div>";
        } else {
            echo "<div class='status status-error'>";
            echo "<span class='status-icon'>⚠️</span>";
            echo "<strong>Atención:</strong> Algunos elementos necesitan revisión ($exitosos/$total completados).";
            echo "</div>";
        }
        
        echo "<div class='info'>";
        echo "<strong>📍 Ubicaciones de los carruseles:</strong><br>";
        echo "1. <strong>Página de Inicio</strong> - Sección About (Formación y Enseñanza Mogruas)<br>";
        echo "2. <strong>Gallery Carousel</strong> - Sección independiente de galería de fotos<br>";
        echo "</div>";
        
        echo "<div class='info'>";
        echo "<strong>🔧 Para ver los cambios:</strong><br>";
        echo "1. Limpia la caché del navegador (Ctrl+Shift+R o Cmd+Shift+R)<br>";
        echo "2. Visita la página de inicio<br>";
        echo "3. Deberías ver el carrusel de fotos en la sección About<br>";
        echo "</div>";
        ?>

        <div class="actions">
            <a href="<?php echo home_url('/'); ?>" class="btn btn-success">🏠 Ver Página de Inicio</a>
            <a href="<?php echo home_url('/test-carruseles-restaurados.php'); ?>" class="btn">🧪 Test de Verificación</a>
        </div>
    </div>
</body>
</html>

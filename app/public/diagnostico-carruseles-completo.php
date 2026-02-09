<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔍 Diagnóstico Completo de Carruseles</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .container { max-width: 1200px; margin: 0 auto; }
        .success { background: #d4edda; color: #155724; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #27ae60; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #dc3545; }
        .warning { background: #fff3e0; color: #e65100; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #ff9800; }
        .info { background: #d1ecf1; color: #0c5460; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #17a2b8; }
        .file-content { background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 10px 0; border: 1px solid #dee2e6; font-family: monospace; font-size: 12px; max-height: 300px; overflow-y: auto; }
        .test-link { display: inline-block; background: linear-gradient(135deg, #3498db, #27ae60); color: white; padding: 15px 30px; text-decoration: none; border-radius: 10px; font-weight: bold; margin: 10px 5px; transition: all 0.3s ease; }
        .test-link:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.3); color: white; text-decoration: none; }
        h1, h2, h3 { color: #2c3e50; }
        .section { background: white; padding: 20px; margin: 20px 0; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 DIAGNÓSTICO COMPLETO DE CARRUSELES</h1>
        <p>Vamos a revisar todos los carruseles y ver exactamente qué está pasando.</p>

        <div class="section">
            <h2>🏠 1. CARRUSEL DE FOTOS - PÁGINA DE INICIO</h2>
            
            <?php
            $theme_path = __DIR__ . '/wp-content/themes/mongruas-theme';
            
            // Verificar about-section.php
            $about_section_path = $theme_path . '/template-parts/about-section.php';
            if (file_exists($about_section_path)) {
                $content = file_get_contents($about_section_path);
                
                if (strpos($content, 'about-carousel') !== false) {
                    echo "<div class='success'>✅ about-section.php contiene el carrusel de fotos</div>";
                    
                    if (strpos($content, 'carouselTrackAbout') !== false) {
                        echo "<div class='success'>✅ Tiene el ID carouselTrackAbout</div>";
                    } else {
                        echo "<div class='error'>❌ Falta el ID carouselTrackAbout</div>";
                    }
                    
                    if (strpos($content, 'carousel-slide-about') !== false) {
                        echo "<div class='success'>✅ Tiene las clases de slides</div>";
                    } else {
                        echo "<div class='error'>❌ Faltan las clases de slides</div>";
                    }
                    
                } else {
                    echo "<div class='error'>❌ about-section.php NO contiene el carrusel de fotos</div>";
                }
            } else {
                echo "<div class='error'>❌ about-section.php no existe</div>";
            }
            
            // Verificar main.js
            $main_js_path = $theme_path . '/assets/js/main.js';
            if (file_exists($main_js_path)) {
                $js_content = file_get_contents($main_js_path);
                
                if (strpos($js_content, 'initializeAboutCarousel') !== false) {
                    echo "<div class='success'>✅ main.js contiene initializeAboutCarousel</div>";
                } else {
                    echo "<div class='error'>❌ main.js NO contiene initializeAboutCarousel</div>";
                }
                
                if (strpos($js_content, 'carouselTrackAbout') !== false) {
                    echo "<div class='success'>✅ main.js busca carouselTrackAbout</div>";
                } else {
                    echo "<div class='error'>❌ main.js NO busca carouselTrackAbout</div>";
                }
            } else {
                echo "<div class='error'>❌ main.js no existe</div>";
            }
            ?>
        </div>

        <div class="section">
            <h2>📚 2. CARRUSEL DE CURSOS - PÁGINA DE ANUNCIOS</h2>
            
            <?php
            // Verificar anuncios.php
            $anuncios_path = __DIR__ . '/anuncios.php';
            if (file_exists($anuncios_path)) {
                echo "<div class='success'>✅ anuncios.php existe</div>";
                
                $anuncios_content = file_get_contents($anuncios_path);
                if (strpos($anuncios_content, 'carrusel-slide') !== false) {
                    echo "<div class='success'>✅ anuncios.php contiene slides de carrusel</div>";
                } else {
                    echo "<div class='error'>❌ anuncios.php NO contiene slides</div>";
                }
                
                if (strpos($anuncios_content, 'cambiarSlide') !== false) {
                    echo "<div class='success'>✅ anuncios.php contiene JavaScript del carrusel</div>";
                } else {
                    echo "<div class='error'>❌ anuncios.php NO contiene JavaScript</div>";
                }
            } else {
                echo "<div class='error'>❌ anuncios.php no existe</div>";
            }
            
            // Verificar page-cursos.php
            $page_cursos_path = $theme_path . '/page-templates/page-cursos.php';
            if (file_exists($page_cursos_path)) {
                echo "<div class='success'>✅ page-cursos.php existe</div>";
                
                $cursos_content = file_get_contents($page_cursos_path);
                if (strpos($cursos_content, 'carrusel') !== false) {
                    echo "<div class='success'>✅ page-cursos.php contiene carrusel</div>";
                } else {
                    echo "<div class='error'>❌ page-cursos.php NO contiene carrusel</div>";
                }
            } else {
                echo "<div class='error'>❌ page-cursos.php no existe</div>";
            }
            ?>
        </div>

        <div class="section">
            <h2>🔧 3. ARCHIVOS JAVASCRIPT</h2>
            
            <?php
            $js_files = [
                'main.js' => $theme_path . '/assets/js/main.js',
                'upcoming-courses.js' => $theme_path . '/assets/js/upcoming-courses.js',
                'form-validation.js' => $theme_path . '/assets/js/form-validation.js'
            ];
            
            foreach ($js_files as $name => $path) {
                if (file_exists($path)) {
                    $content = file_get_contents($path);
                    $size = strlen($content);
                    echo "<div class='success'>✅ $name existe ($size bytes)</div>";
                    
                    if (strpos($content, 'carousel') !== false || strpos($content, 'carrusel') !== false) {
                        echo "<div class='info'>📝 $name contiene código de carrusel</div>";
                    } else {
                        echo "<div class='warning'>⚠️ $name NO contiene código de carrusel</div>";
                    }
                } else {
                    echo "<div class='error'>❌ $name no existe</div>";
                }
            }
            ?>
        </div>

        <div class="section">
            <h2>🌐 4. PRUEBAS DIRECTAS</h2>
            
            <p>Prueba estos enlaces para ver qué funciona:</p>
            
            <a href="/" target="_blank" class="test-link">🏠 Página de Inicio</a>
            <a href="/anuncios.php" target="_blank" class="test-link">📚 Anuncios.php</a>
            <a href="/anuncios/" target="_blank" class="test-link">📚 Anuncios WordPress</a>
            <a href="/test-carrusel-directo.html" target="_blank" class="test-link">🧪 Test HTML Directo</a>
        </div>

        <div class="section">
            <h2>🔍 5. CONTENIDO DE ARCHIVOS CLAVE</h2>
            
            <h3>📄 Contenido de main.js (primeras 50 líneas):</h3>
            <div class="file-content">
                <?php
                if (file_exists($main_js_path)) {
                    $lines = explode("\n", file_get_contents($main_js_path));
                    echo htmlspecialchars(implode("\n", array_slice($lines, 0, 50)));
                } else {
                    echo "Archivo no encontrado";
                }
                ?>
            </div>
            
            <h3>📄 Estructura de about-section.php (líneas con 'carousel'):</h3>
            <div class="file-content">
                <?php
                if (file_exists($about_section_path)) {
                    $lines = explode("\n", file_get_contents($about_section_path));
                    foreach ($lines as $i => $line) {
                        if (stripos($line, 'carousel') !== false) {
                            echo "Línea " . ($i + 1) . ": " . htmlspecialchars($line) . "\n";
                        }
                    }
                } else {
                    echo "Archivo no encontrado";
                }
                ?>
            </div>
        </div>

        <div class="section">
            <h2>🚀 6. SOLUCIÓN RÁPIDA</h2>
            
            <p>Si los carruseles no aparecen, vamos a aplicar una solución directa:</p>
            
            <a href="/restaurar-carrusel-fotos-inicio.php" target="_blank" class="test-link">🔄 Restaurar Carrusel Fotos</a>
            <a href="/aplicar-carrusel-simple-ya.php" target="_blank" class="test-link">🔄 Aplicar Carrusel Anuncios</a>
        </div>

        <div class="section">
            <h2>📋 7. RESUMEN DEL DIAGNÓSTICO</h2>
            
            <?php
            $problemas = [];
            $soluciones = [];
            
            // Verificar problemas
            if (!file_exists($about_section_path)) {
                $problemas[] = "about-section.php no existe";
                $soluciones[] = "Restaurar about-section.php";
            }
            
            if (!file_exists($main_js_path)) {
                $problemas[] = "main.js no existe";
                $soluciones[] = "Restaurar main.js";
            } else {
                $js_content = file_get_contents($main_js_path);
                if (strpos($js_content, 'initializeAboutCarousel') === false) {
                    $problemas[] = "main.js no tiene función del carrusel de fotos";
                    $soluciones[] = "Agregar función initializeAboutCarousel a main.js";
                }
            }
            
            if (!file_exists($anuncios_path)) {
                $problemas[] = "anuncios.php no existe";
                $soluciones[] = "Crear anuncios.php";
            }
            
            if (empty($problemas)) {
                echo "<div class='success'>✅ No se detectaron problemas obvios. Los carruseles deberían funcionar.</div>";
            } else {
                echo "<div class='error'>❌ Problemas detectados:</div>";
                foreach ($problemas as $problema) {
                    echo "<div class='warning'>⚠️ $problema</div>";
                }
                
                echo "<div class='info'>💡 Soluciones sugeridas:</div>";
                foreach ($soluciones as $solucion) {
                    echo "<div class='info'>🔧 $solucion</div>";
                }
            }
            ?>
        </div>
    </div>

    <script>
        console.log("🔍 Diagnóstico de carruseles cargado");
        
        // Verificar si hay elementos de carrusel en la página actual
        setTimeout(() => {
            const aboutCarousel = document.getElementById('carouselTrackAbout');
            const cursosCarousel = document.querySelector('.carrusel-slide');
            
            if (aboutCarousel) {
                console.log("✅ Carrusel de fotos encontrado en DOM");
            } else {
                console.log("❌ Carrusel de fotos NO encontrado en DOM");
            }
            
            if (cursosCarousel) {
                console.log("✅ Carrusel de cursos encontrado en DOM");
            } else {
                console.log("❌ Carrusel de cursos NO encontrado en DOM");
            }
        }, 1000);
    </script>
</body>
</html>
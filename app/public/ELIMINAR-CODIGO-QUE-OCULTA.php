<?php
/**
 * ELIMINAR CÓDIGO QUE OCULTA LOS CARRUSELES
 * Este script busca y elimina TODO el código que oculta carruseles
 */

$theme_path = __DIR__ . '/wp-content/themes/mongruas-theme';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>🔥 ELIMINANDO CÓDIGO QUE OCULTA</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            padding: 20px;
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
            font-size: 2.5rem;
            color: #e74c3c;
            text-align: center;
            margin-bottom: 30px;
        }
        .step {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 5px solid #3498db;
        }
        .ok { background: #d4edda; border-left-color: #28a745; }
        .error { background: #f8d7da; border-left-color: #dc3545; }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
            color: white;
            padding: 20px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.2rem;
            margin: 20px 10px;
            box-shadow: 0 5px 20px rgba(39, 174, 96, 0.4);
        }
        .actions { text-align: center; margin-top: 40px; padding-top: 40px; border-top: 3px solid #ecf0f1; }
        .code { background: #2c3e50; color: #ecf0f1; padding: 10px; border-radius: 5px; font-family: monospace; font-size: 0.85rem; margin: 10px 0; overflow-x: auto; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔥 ELIMINANDO CÓDIGO QUE OCULTA</h1>

        <?php
        $archivos_modificados = [];
        
        // 1. BUSCAR Y ELIMINAR EN TODOS LOS CSS
        echo "<div class='step'>";
        echo "<h2>1️⃣ Buscando CSS que oculta carruseles</h2>";
        
        $css_files = glob($theme_path . '/assets/css/*.css');
        foreach ($css_files as $css_file) {
            $content = file_get_contents($css_file);
            $original = $content;
            
            // Patrones a eliminar
            $patterns = [
                // Ocultar carruseles
                '/\/\*[^*]*carousel[^*]*\*\/\s*\[[^\]]*carousel[^\]]*\]\s*\{[^}]*display:\s*none[^}]*\}/si',
                '/\[[^\]]*carousel[^\]]*\]\s*\{[^}]*display:\s*none[^}]*\}/si',
                '/\[[^\]]*carousel[^\]]*\]\s*\{[^}]*visibility:\s*hidden[^}]*\}/si',
                '/\.carousel[^{]*\{[^}]*display:\s*none[^}]*\}/si',
                '/#carousel[^{]*\{[^}]*display:\s*none[^}]*\}/si',
            ];
            
            foreach ($patterns as $pattern) {
                $content = preg_replace($pattern, '', $content);
            }
            
            if ($content !== $original) {
                file_put_contents($css_file, $content);
                $filename = basename($css_file);
                echo "<p class='ok'>✅ Limpiado: $filename</p>";
                $archivos_modificados[] = $filename;
            }
        }
        
        if (empty($archivos_modificados)) {
            echo "<p>✅ No se encontró CSS que oculte carruseles</p>";
        }
        echo "</div>";
        
        // 2. BUSCAR Y ELIMINAR EN JAVASCRIPT
        echo "<div class='step'>";
        echo "<h2>2️⃣ Buscando JavaScript que oculta carruseles</h2>";
        
        $js_files = glob($theme_path . '/assets/js/*.js');
        $js_modificados = [];
        
        foreach ($js_files as $js_file) {
            $content = file_get_contents($js_file);
            $original = $content;
            
            // Buscar líneas que oculten carruseles
            $lines = explode("\n", $content);
            $new_lines = [];
            $removed = 0;
            
            foreach ($lines as $line) {
                // Si la línea contiene "carousel" y "display" o "hide" o "visibility"
                if (preg_match('/carousel/i', $line) && 
                    (preg_match('/display.*none|hide\(\)|visibility.*hidden/i', $line))) {
                    // Comentar la línea en lugar de eliminarla
                    $new_lines[] = "// DESACTIVADO: " . $line;
                    $removed++;
                } else {
                    $new_lines[] = $line;
                }
            }
            
            if ($removed > 0) {
                $content = implode("\n", $new_lines);
                file_put_contents($js_file, $content);
                $filename = basename($js_file);
                echo "<p class='ok'>✅ Limpiado: $filename ($removed líneas desactivadas)</p>";
                $js_modificados[] = $filename;
            }
        }
        
        if (empty($js_modificados)) {
            echo "<p>✅ No se encontró JavaScript que oculte carruseles</p>";
        }
        echo "</div>";
        
        // 3. AGREGAR CSS PARA FORZAR VISIBILIDAD
        echo "<div class='step'>";
        echo "<h2>3️⃣ Forzando visibilidad de carruseles</h2>";
        
        $force_css = "
/* FORZAR VISIBILIDAD DE CARRUSELES - NO ELIMINAR */
.about-carousel-wrapper,
.carousel-container,
[class*='carousel'],
[id*='carousel'] {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
}

.about-carousel-wrapper .carousel-slide,
.carousel-slide {
    display: none;
}

.about-carousel-wrapper .carousel-slide.active,
.carousel-slide.active {
    display: block !important;
}
";
        
        $main_css = $theme_path . '/assets/css/main.css';
        if (file_exists($main_css)) {
            $content = file_get_contents($main_css);
            
            // Solo agregar si no existe ya
            if (strpos($content, 'FORZAR VISIBILIDAD DE CARRUSELES') === false) {
                file_put_contents($main_css, $content . "\n" . $force_css);
                echo "<p class='ok'>✅ CSS de visibilidad agregado a main.css</p>";
            } else {
                echo "<p>✅ CSS de visibilidad ya existe</p>";
            }
        }
        echo "</div>";
        
        // 4. VERIFICAR ABOUT-SECTION.PHP
        echo "<div class='step'>";
        echo "<h2>4️⃣ Verificando about-section.php</h2>";
        
        $about_file = $theme_path . '/template-parts/about-section.php';
        $about_content = file_get_contents($about_file);
        
        if (strpos($about_content, 'about-carousel-wrapper') !== false) {
            echo "<p class='ok'>✅ Carrusel presente en about-section.php</p>";
        } else {
            echo "<p class='error'>❌ Carrusel NO está en about-section.php</p>";
        }
        echo "</div>";
        
        // RESUMEN
        echo "<div class='step ok'>";
        echo "<h2>🎯 RESUMEN</h2>";
        echo "<p style='font-size: 1.2rem; font-weight: bold;'>✅ Proceso completado</p>";
        echo "<p style='margin-top: 15px;'>";
        echo "Archivos CSS modificados: " . count($archivos_modificados) . "<br>";
        echo "Archivos JS modificados: " . count($js_modificados) . "<br>";
        echo "</p>";
        
        if (count($archivos_modificados) > 0 || count($js_modificados) > 0) {
            echo "<p style='margin-top: 15px; color: #e74c3c; font-weight: bold;'>";
            echo "⚠️ Se encontró y eliminó código que ocultaba los carruseles";
            echo "</p>";
        }
        echo "</div>";
        ?>

        <div class="actions">
            <h2 style="margin-bottom: 20px; color: #2c3e50;">🚀 ¡Ahora deberías verlos!</h2>
            <a href="<?php echo home_url('/'); ?>" class="btn" target="_blank">🏠 VER PÁGINA DE INICIO</a>
            <br>
            <p style="margin-top: 20px; color: #7f8c8d;">
                💡 Presiona <strong>Ctrl+Shift+R</strong> para limpiar la caché del navegador
            </p>
        </div>
    </div>
</body>
</html>

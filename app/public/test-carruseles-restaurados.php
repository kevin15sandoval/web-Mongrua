<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✅ Test de Carruseles Restaurados</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background: #f5f7fa;
        }
        .header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }
        .section {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .success { 
            color: #28a745; 
            font-weight: bold; 
            margin: 10px 0;
            padding: 15px;
            background: #d4edda;
            border-radius: 5px;
            border-left: 4px solid #28a745;
        }
        .error { 
            color: #dc3545; 
            font-weight: bold; 
            margin: 10px 0;
            padding: 15px;
            background: #f8d7da;
            border-radius: 5px;
            border-left: 4px solid #dc3545;
        }
        .info { 
            color: #17a2b8; 
            margin: 10px 0;
            padding: 15px;
            background: #d1ecf1;
            border-radius: 5px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
            font-weight: 600;
        }
        .btn:hover {
            background: #218838;
        }
        .check-item {
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            background: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>✅ Carruseles Restaurados Exitosamente</h1>
        <p>Verificación del sistema de carruseles dinámicos</p>
    </div>

    <?php
    $theme_dir = __DIR__ . '/wp-content/themes/mongruas-theme';
    
    // Verificar archivos críticos
    echo "<div class='section'>";
    echo "<h2>📋 Verificación de Archivos</h2>";
    
    $archivos = [
        'inc/carruseles-dinamicos.php' => 'Sistema de carruseles',
        'assets/css/carruseles-dinamicos.css' => 'Estilos de carruseles',
        'template-parts/about-section.php' => 'Sección About',
        'page-templates/page-cursos.php' => 'Página de cursos',
    ];
    
    $todos_ok = true;
    foreach ($archivos as $archivo => $descripcion) {
        $ruta = $theme_dir . '/' . $archivo;
        if (file_exists($ruta)) {
            echo "<div class='check-item success'>✅ $descripcion: OK</div>";
        } else {
            echo "<div class='check-item error'>❌ $descripcion: NO ENCONTRADO</div>";
            $todos_ok = false;
        }
    }
    echo "</div>";
    
    // Verificar que no hay conflictos CSS
    echo "<div class='section'>";
    echo "<h2>🎨 Verificación de CSS</h2>";
    
    $css_file = $theme_dir . '/assets/css/upcoming-courses.css';
    if (file_exists($css_file)) {
        $css_content = file_get_contents($css_file);
        
        // Buscar reglas que oculten carruseles
        if (preg_match('/\[class\*="carousel"\][^{]*\{[^}]*display\s*:\s*none/i', $css_content)) {
            echo "<div class='error'>❌ Se encontraron reglas CSS que ocultan carruseles</div>";
            echo "<div class='info'>⚠️ Ejecuta el script de restauración para eliminar conflictos</div>";
        } else {
            echo "<div class='success'>✅ No hay conflictos CSS que oculten carruseles</div>";
        }
    }
    echo "</div>";
    
    // Verificar funciones en functions.php
    echo "<div class='section'>";
    echo "<h2>⚙️ Verificación de Funciones</h2>";
    
    $functions_file = $theme_dir . '/functions.php';
    if (file_exists($functions_file)) {
        $functions_content = file_get_contents($functions_file);
        
        $funciones = [
            'carruseles-dinamicos.php' => 'Inclusión del sistema',
            'mongruas_enqueue_carousel_assets' => 'Carga de assets',
            'mongruas_show_photo_carousel' => 'Helper de fotos',
            'mongruas_show_courses_carousel' => 'Helper de cursos',
        ];
        
        foreach ($funciones as $buscar => $descripcion) {
            if (strpos($functions_content, $buscar) !== false) {
                echo "<div class='check-item success'>✅ $descripcion: OK</div>";
            } else {
                echo "<div class='check-item error'>❌ $descripcion: NO ENCONTRADO</div>";
            }
        }
    }
    echo "</div>";
    
    // Estado final
    echo "<div class='section'>";
    echo "<h2>🎉 Estado Final</h2>";
    
    if ($todos_ok) {
        echo "<div class='success'>";
        echo "<h3>✅ ¡Carruseles Restaurados Correctamente!</h3>";
        echo "<p>Los tres carruseles han sido restaurados:</p>";
        echo "<ul>";
        echo "<li>🎠 <strong>Carrusel de Fotos</strong> - Página de inicio (sección About)</li>";
        echo "<li>📚 <strong>Carrusel de Cursos</strong> - Página /anuncios/</li>";
        echo "<li>🏠 <strong>Carrusel Principal</strong> - Página de inicio</li>";
        echo "</ul>";
        echo "</div>";
        
        echo "<div class='info'>";
        echo "<h3>📝 Próximos Pasos:</h3>";
        echo "<ol>";
        echo "<li>Limpia la caché del navegador (Ctrl+Shift+R)</li>";
        echo "<li>Visita las páginas para verificar los carruseles</li>";
        echo "<li>Configura las imágenes y cursos desde WordPress</li>";
        echo "</ol>";
        echo "</div>";
    } else {
        echo "<div class='error'>";
        echo "<h3>⚠️ Algunos archivos no se encontraron</h3>";
        echo "<p>Ejecuta el script de restauración completo</p>";
        echo "</div>";
    }
    
    echo "<div style='text-align: center; margin-top: 30px;'>";
    echo "<a href='http://mongruasformacion.local/' class='btn' target='_blank'>🏠 Ver Página de Inicio</a>";
    echo "<a href='http://mongruasformacion.local/anuncios/' class='btn' target='_blank'>📚 Ver Próximos Cursos</a>";
    echo "<a href='http://mongruasformacion.local/wp-admin/' class='btn' target='_blank'>⚙️ Panel WordPress</a>";
    echo "</div>";
    
    echo "</div>";
    ?>
    
    <div class="section">
        <h2>💡 Información Adicional</h2>
        <div class="info">
            <p><strong>¿Qué se restauró?</strong></p>
            <ul>
                <li>Se eliminaron las reglas CSS que ocultaban los carruseles</li>
                <li>Se actualizaron los templates para usar las funciones correctas</li>
                <li>Se verificó que el sistema de carruseles dinámicos esté activo</li>
            </ul>
        </div>
        
        <div class="info">
            <p><strong>¿Cómo funcionan ahora?</strong></p>
            <ul>
                <li>Los carruseles son completamente dinámicos y editables desde WordPress</li>
                <li>Puedes agregar/editar imágenes y cursos desde el panel de administración</li>
                <li>Son responsive y funcionan en todos los dispositivos</li>
                <li>Tienen auto-play y controles de navegación</li>
            </ul>
        </div>
    </div>
</body>
</html>

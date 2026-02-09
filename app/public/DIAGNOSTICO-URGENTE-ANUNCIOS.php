<?php
/**
 * DIAGNÓSTICO URGENTE - ¿Por qué no aparecen los cursos en /anuncios/?
 */

require_once('wp-load.php');

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'>";
echo "<style>
body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
.success { background: #d4edda; border-left: 4px solid #28a745; padding: 15px; margin: 10px 0; }
.error { background: #f8d7da; border-left: 4px solid #dc3545; padding: 15px; margin: 10px 0; }
.warning { background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 10px 0; }
.info { background: #d1ecf1; border-left: 4px solid #17a2b8; padding: 15px; margin: 10px 0; }
h1 { color: #dc3545; }
h2 { color: #333; border-bottom: 2px solid #dc3545; padding-bottom: 10px; margin-top: 30px; }
pre { background: #fff; padding: 15px; border-radius: 5px; overflow-x: auto; border: 1px solid #ddd; }
.code { background: #f8f9fa; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
</style></head><body>";

echo "<h1>🚨 DIAGNÓSTICO URGENTE - /anuncios/</h1>";
echo "<p><strong>Verificando por qué no aparecen los cursos...</strong></p>";

// 1. Verificar si hay cursos guardados
echo "<h2>1️⃣ ¿Hay cursos guardados en el panel?</h2>";
$cursos = get_option('mongruas_courses', []);

if (empty($cursos)) {
    echo "<div class='error'>";
    echo "❌ <strong>NO HAY CURSOS GUARDADOS</strong><br>";
    echo "La opción 'mongruas_courses' está vacía o no existe.<br><br>";
    echo "<strong>Solución:</strong><br>";
    echo "1. Ve a <a href='" . home_url('/gestionar-cursos-dinamico.php') . "'>/gestionar-cursos-dinamico.php</a><br>";
    echo "2. Agrega un curso<br>";
    echo "3. Haz clic en <strong>'💾 Guardar Todos los Cursos'</strong><br>";
    echo "4. Vuelve aquí para verificar";
    echo "</div>";
} else {
    echo "<div class='success'>";
    echo "✅ <strong>SÍ HAY CURSOS GUARDADOS</strong><br>";
    echo "Encontrados: <strong>" . count($cursos) . " curso(s)</strong>";
    echo "</div>";
    
    echo "<div class='info'><strong>Cursos encontrados:</strong><br>";
    echo "<pre>";
    print_r($cursos);
    echo "</pre></div>";
}

// 2. Verificar que la página /anuncios/ existe
echo "<h2>2️⃣ ¿Existe la página /anuncios/?</h2>";
$page = get_page_by_path('anuncios');

if (!$page) {
    echo "<div class='error'>";
    echo "❌ <strong>LA PÁGINA /anuncios/ NO EXISTE</strong><br>";
    echo "Necesitas crear o restaurar la página.";
    echo "</div>";
} else {
    echo "<div class='success'>";
    echo "✅ La página existe (ID: {$page->ID})<br>";
    echo "Estado: {$page->post_status}<br>";
    echo "Template: " . get_page_template_slug($page->ID);
    echo "</div>";
    
    // Verificar template
    $template = get_page_template_slug($page->ID);
    if ($template !== 'page-templates/page-anuncios-completa.php') {
        echo "<div class='warning'>";
        echo "⚠️ <strong>TEMPLATE INCORRECTO</strong><br>";
        echo "Template actual: <span class='code'>$template</span><br>";
        echo "Debería ser: <span class='code'>page-templates/page-anuncios-completa.php</span><br><br>";
        echo "<strong>Solución:</strong> Ejecuta <a href='" . home_url('/CAMBIAR-PLANTILLA-ANUNCIOS.php') . "'>CAMBIAR-PLANTILLA-ANUNCIOS.php</a>";
        echo "</div>";
    } else {
        echo "<div class='success'>✅ Template correcto</div>";
    }
}

// 3. Verificar que el archivo del template existe
echo "<h2>3️⃣ ¿Existe el archivo del template?</h2>";
$template_path = get_template_directory() . '/page-templates/page-anuncios-completa.php';

if (!file_exists($template_path)) {
    echo "<div class='error'>";
    echo "❌ <strong>EL ARCHIVO DEL TEMPLATE NO EXISTE</strong><br>";
    echo "Ruta esperada: <span class='code'>$template_path</span>";
    echo "</div>";
} else {
    echo "<div class='success'>✅ El archivo existe</div>";
    
    // Verificar contenido del template
    $content = file_get_contents($template_path);
    
    echo "<h2>4️⃣ ¿El template lee de 'mongruas_courses'?</h2>";
    if (strpos($content, "get_option('mongruas_courses'") !== false) {
        echo "<div class='success'>✅ El template lee correctamente de 'mongruas_courses'</div>";
    } else {
        echo "<div class='error'>";
        echo "❌ <strong>EL TEMPLATE NO LEE DE 'mongruas_courses'</strong><br>";
        echo "Está buscando en otro lugar (probablemente wp_upcoming_courses)";
        echo "</div>";
    }
    
    echo "<h2>5️⃣ ¿El carrusel está en el template?</h2>";
    if (strpos($content, 'proximos-cursos-carousel-section') !== false) {
        echo "<div class='success'>✅ El carrusel está presente</div>";
    } else {
        echo "<div class='error'>❌ El carrusel NO está en el template</div>";
    }
}

// 4. Simular lo que debería aparecer
if (!empty($cursos)) {
    echo "<h2>6️⃣ Simulación de lo que DEBERÍA aparecer</h2>";
    echo "<div class='info'>";
    echo "<strong>Esto es lo que debería verse en /anuncios/:</strong><br><br>";
    
    echo "<div style='background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px; border-radius: 15px;'>";
    echo "<h3 style='color: white; text-align: center; margin: 0 0 10px 0;'>Próximos Cursos</h3>";
    echo "<p style='color: rgba(255,255,255,0.9); text-align: center; margin: 0 0 30px 0;'>Cursos que comenzarán próximamente. ¡Reserva tu plaza!</p>";
    
    echo "<div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;'>";
    
    foreach ($cursos as $index => $curso) {
        echo "<div style='background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);'>";
        echo "<div style='background: linear-gradient(135deg, #27ae60, #229954); color: white; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; display: inline-block; margin-bottom: 10px; font-weight: 700;'>" . esc_html($curso['date']) . "</div>";
        echo "<h4 style='color: #2c3e50; margin: 10px 0; font-size: 1.2rem;'>" . esc_html($curso['name']) . "</h4>";
        echo "<p style='color: #6c757d; font-size: 0.9rem; margin: 10px 0;'>" . esc_html($curso['description']) . "</p>";
        echo "<div style='margin: 15px 0; display: flex; gap: 15px;'>";
        echo "<span style='font-size: 0.85rem; color: #495057;'>💻 " . esc_html($curso['modality']) . "</span>";
        echo "<span style='font-size: 0.85rem; color: #495057;'>👥 " . esc_html($curso['duration']) . "</span>";
        echo "</div>";
        echo "<div style='display: flex; flex-direction: column; gap: 8px; margin-top: 15px;'>";
        echo "<button style='background: linear-gradient(135deg, #3498db, #2980b9); color: white; border: none; padding: 10px; border-radius: 20px; font-weight: 600; cursor: pointer;'>Ver más información</button>";
        echo "<button style='background: linear-gradient(135deg, #27ae60, #229954); color: white; border: none; padding: 10px; border-radius: 20px; font-weight: 600; cursor: pointer;'>Inscribirse</button>";
        echo "</div>";
        echo "</div>";
    }
    
    echo "</div>";
    echo "</div>";
    echo "</div>";
}

// 5. Verificar caché
echo "<h2>7️⃣ ¿Puede ser un problema de caché?</h2>";
echo "<div class='warning'>";
echo "⚠️ <strong>WordPress puede estar cacheando la página</strong><br><br>";
echo "<strong>Soluciones:</strong><br>";
echo "1. Presiona <strong>Ctrl + F5</strong> en /anuncios/ (fuerza recarga)<br>";
echo "2. Abre /anuncios/ en modo incógnito<br>";
echo "3. Limpia caché de WordPress si tienes plugins de caché<br>";
echo "4. Ejecuta: <a href='" . home_url('/limpiar-cache-total.php') . "'>limpiar-cache-total.php</a>";
echo "</div>";

// 6. Test directo del código
echo "<h2>8️⃣ Test Directo del Código PHP</h2>";
echo "<div class='info'>";
echo "<strong>Ejecutando el mismo código que usa /anuncios/:</strong><br><br>";
echo "<pre>";
echo "<?php\n";
echo "\$cursos = get_option('mongruas_courses', []);\n";
echo "echo 'Cursos encontrados: ' . count(\$cursos);\n";
echo "?>";
echo "</pre>";

echo "<strong>Resultado:</strong><br>";
$test_cursos = get_option('mongruas_courses', []);
if (empty($test_cursos)) {
    echo "<span style='color: #dc3545; font-weight: bold;'>❌ 0 cursos (VACÍO)</span>";
} else {
    echo "<span style='color: #28a745; font-weight: bold;'>✅ " . count($test_cursos) . " curso(s)</span>";
}
echo "</div>";

// 7. Instrucciones finales
echo "<h2>9️⃣ ¿Qué hacer ahora?</h2>";

if (empty($cursos)) {
    echo "<div class='error'>";
    echo "<strong>PROBLEMA PRINCIPAL: No hay cursos guardados</strong><br><br>";
    echo "<strong>Pasos a seguir:</strong><br>";
    echo "1. Ve a <a href='" . home_url('/gestionar-cursos-dinamico.php') . "' target='_blank'>/gestionar-cursos-dinamico.php</a><br>";
    echo "2. Agrega al menos un curso<br>";
    echo "3. Haz clic en <strong>'💾 Guardar Todos los Cursos'</strong><br>";
    echo "4. Espera a ver el mensaje verde de confirmación<br>";
    echo "5. Vuelve a esta página para verificar<br>";
    echo "6. Luego ve a <a href='" . home_url('/anuncios/') . "' target='_blank'>/anuncios/</a> y presiona Ctrl + F5";
    echo "</div>";
} else {
    echo "<div class='success'>";
    echo "<strong>Los cursos están guardados correctamente</strong><br><br>";
    echo "<strong>Pasos a seguir:</strong><br>";
    echo "1. Ve a <a href='" . home_url('/anuncios/') . "' target='_blank'>/anuncios/</a><br>";
    echo "2. Presiona <strong>Ctrl + F5</strong> (fuerza recarga sin caché)<br>";
    echo "3. Si no aparece, abre en modo incógnito<br>";
    echo "4. Si sigue sin aparecer, verifica que el template sea el correcto arriba ⬆️";
    echo "</div>";
}

// 8. Enlaces útiles
echo "<h2>🔗 Enlaces Útiles</h2>";
echo "<div class='info'>";
echo "<ul>";
echo "<li><a href='" . home_url('/gestionar-cursos-dinamico.php') . "' target='_blank'>Panel de Gestión de Cursos</a></li>";
echo "<li><a href='" . home_url('/anuncios/') . "' target='_blank'>Página /anuncios/</a></li>";
echo "<li><a href='" . home_url('/CAMBIAR-PLANTILLA-ANUNCIOS.php') . "' target='_blank'>Cambiar Template de /anuncios/</a></li>";
echo "<li><a href='" . home_url('/verificar-conexion-panel-anuncios.php') . "' target='_blank'>Verificación Completa</a></li>";
echo "</ul>";
echo "</div>";

echo "</body></html>";
?>

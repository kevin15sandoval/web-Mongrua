<?php
/**
 * Diagnóstico Carrusel - 6 Cursos Activados
 * Verificar por qué no aparecen las flechas si tienes 6 cursos
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🔍 Diagnóstico: 6 Cursos Activados - ¿Dónde están las flechas?</h1>";

// Verificar cursos en ambos sistemas
echo "<div style='background: #e3f2fd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📊 Verificación de Cursos</h2>";

echo "<h3>🔍 Sistema Principal (gestionar-proximos-cursos.php):</h3>";
$cursos_principales = 0;
$cursos_data_principales = [];

for ($i = 1; $i <= 6; $i++) {
    $course_name = get_option("course_{$i}_name");
    if (!empty($course_name)) {
        $cursos_principales++;
        $cursos_data_principales[] = [
            'num' => $i,
            'name' => $course_name,
            'date' => get_option("course_{$i}_date"),
            'modality' => get_option("course_{$i}_modality"),
            'duration' => get_option("course_{$i}_duration")
        ];
        echo "<p style='color: #28a745;'>✅ <strong>Curso $i:</strong> $course_name</p>";
    } else {
        echo "<p style='color: #dc3545;'>❌ <strong>Curso $i:</strong> Vacío</p>";
    }
}

echo "<div style='background: " . ($cursos_principales > 3 ? '#d4edda' : '#f8d7da') . "; padding: 15px; border-radius: 8px; margin: 15px 0;'>";
echo "<h4 style='margin: 0; color: " . ($cursos_principales > 3 ? '#155724' : '#721c24') . ";'>";
echo ($cursos_principales > 3 ? '✅' : '❌') . " Total Sistema Principal: $cursos_principales cursos";
echo "</h4>";
echo "</div>";

echo "</div>";

// Verificar template page-cursos.php
echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📄 Verificar Template page-cursos.php</h2>";

$template_path = get_template_directory() . '/page-templates/page-cursos.php';
if (file_exists($template_path)) {
    echo "<p style='color: #28a745;'>✅ Template encontrado</p>";
    
    $content = file_get_contents($template_path);
    
    // Verificar elementos críticos del carrusel
    $elementos_carrusel = [
        'courses-carousel-container' => 'Contenedor del carrusel',
        'courses-carousel-track' => 'Track del carrusel',
        'carousel-controls' => 'Controles de navegación (flechas)',
        'carousel-btn' => 'Botones de las flechas',
        'nextCourse()' => 'Función JavaScript nextCourse',
        'prevCourse()' => 'Función JavaScript prevCourse',
        'count($courses) <= 3' => 'Lógica de decisión carrusel/grid'
    ];
    
    foreach ($elementos_carrusel as $elemento => $descripcion) {
        if (strpos($content, $elemento) !== false) {
            echo "<p style='color: #28a745;'>✅ $descripcion</p>";
        } else {
            echo "<p style='color: #dc3545;'>❌ Falta: $descripcion</p>";
        }
    }
    
    // Verificar la lógica específica
    if (strpos($content, 'FORZAR CARRUSEL') !== false) {
        echo "<p style='color: #28a745;'>✅ Lógica de forzado de carrusel presente</p>";
    } else {
        echo "<p style='color: #ff6600;'>⚠️ No hay lógica de forzado automático</p>";
    }
    
} else {
    echo "<p style='color: #dc3545;'>❌ Template no encontrado</p>";
}

echo "</div>";

// Verificar página /anuncios
echo "<div style='background: #d1ecf1; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🌐 Verificar Página /anuncios</h2>";

$page = get_page_by_path('anuncios');
if ($page) {
    echo "<p style='color: #28a745;'>✅ Página /anuncios existe (ID: {$page->ID})</p>";
    
    $template = get_post_meta($page->ID, '_wp_page_template', true);
    echo "<p><strong>Template asignado:</strong> " . ($template ?: 'default') . "</p>";
    
    if ($template === 'page-templates/page-cursos.php') {
        echo "<p style='color: #28a745;'>✅ Template correcto asignado</p>";
    } else {
        echo "<p style='color: #dc3545;'>❌ Template incorrecto. Corrigiendo...</p>";
        update_post_meta($page->ID, '_wp_page_template', 'page-templates/page-cursos.php');
        echo "<p style='color: #28a745;'>✅ Template corregido</p>";
    }
} else {
    echo "<p style='color: #dc3545;'>❌ Página /anuncios no existe</p>";
}

echo "</div>";

// Simular exactamente lo que hace el template
echo "<div style='background: #d4edda; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🧪 Simulación Exacta del Template</h2>";

echo "<h3>Código que ejecuta el template:</h3>";
echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 5px; font-family: monospace; font-size: 14px;'>";
echo "// Recoger los cursos de las opciones (hasta 6 cursos)<br>";
echo "\$courses = array();<br><br>";
echo "for (\$i = 1; \$i <= 6; \$i++) {<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;\$course_name = get_option(\"course_{\$i}_name\");<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;if (!empty(\$course_name)) {<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\$courses[] = array(...);<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;}<br>";
echo "}<br><br>";
echo "if (count(\$courses) <= 3) {<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;// Vista GRID normal<br>";
echo "} else {<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;// Vista CARRUSEL con flechas<br>";
echo "}";
echo "</div>";

// Ejecutar la simulación real
$courses_simulacion = array();
for ($i = 1; $i <= 6; $i++) {
    $course_name = get_option("course_{$i}_name");
    if (!empty($course_name)) {
        $courses_simulacion[] = array(
            'name' => $course_name,
            'description' => get_option("course_{$i}_description"),
            'date' => get_option("course_{$i}_date"),
            'duration' => get_option("course_{$i}_duration"),
            'modality' => get_option("course_{$i}_modality"),
            'image' => get_option("course_{$i}_image"),
        );
    }
}

echo "<h3>Resultado de la simulación:</h3>";
echo "<p><strong>Cursos encontrados por el template:</strong> " . count($courses_simulacion) . "</p>";

if (count($courses_simulacion) <= 3) {
    echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px; color: #721c24;'>";
    echo "<strong>❌ RESULTADO:</strong> GRID normal (sin flechas)<br>";
    echo "<strong>RAZÓN:</strong> " . count($courses_simulacion) . " cursos ≤ 3";
    echo "</div>";
} else {
    echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; color: #155724;'>";
    echo "<strong>✅ RESULTADO:</strong> CARRUSEL con flechas<br>";
    echo "<strong>RAZÓN:</strong> " . count($courses_simulacion) . " cursos > 3";
    echo "</div>";
}

echo "<h3>📋 Cursos que ve el template:</h3>";
foreach ($courses_simulacion as $index => $course) {
    echo "<div style='background: white; padding: 10px; margin: 5px 0; border-radius: 5px; border-left: 4px solid #0066cc;'>";
    echo "<strong>" . ($index + 1) . ".</strong> {$course['name']} - {$course['date']} ({$course['modality']})";
    echo "</div>";
}

echo "</div>";

// Verificar cache
echo "<div style='background: #f8d7da; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🧹 Limpiar Cache (por si acaso)</h2>";

// WordPress cache
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
    echo "<p style='color: #28a745;'>✅ Cache de WordPress limpiado</p>";
}

// Transients
$transients = ['mongruas_courses_cache', 'courses_carousel_cache', 'page_cache_anuncios'];
foreach ($transients as $transient) {
    delete_transient($transient);
}
echo "<p style='color: #28a745;'>✅ Transients limpiados</p>";

// Cache de opciones
wp_cache_delete('alloptions', 'options');
echo "<p style='color: #28a745;'>✅ Cache de opciones limpiado</p>";

echo "</div>";

// Diagnóstico final
echo "<div style='background: #fff3cd; padding: 25px; border-radius: 12px; margin: 20px 0; border-left: 5px solid #ffc107;'>";
echo "<h2>🎯 Diagnóstico Final</h2>";

if (count($courses_simulacion) > 3) {
    echo "<div style='background: #d4edda; padding: 20px; border-radius: 8px; margin: 15px 0;'>";
    echo "<h3 style='color: #155724; margin: 0;'>✅ TODO DEBERÍA FUNCIONAR</h3>";
    echo "<p style='color: #155724; margin: 10px 0 0 0;'>Tienes " . count($courses_simulacion) . " cursos, el carrusel debería aparecer con flechas.</p>";
    echo "</div>";
    
    echo "<h3>🔍 Si aún no ves las flechas, puede ser:</h3>";
    echo "<ol>";
    echo "<li><strong>Cache del navegador:</strong> Presiona Ctrl+F5 para recargar completamente</li>";
    echo "<li><strong>JavaScript deshabilitado:</strong> Verifica que JavaScript esté habilitado</li>";
    echo "<li><strong>Errores de JavaScript:</strong> Abre F12 → Console y busca errores</li>";
    echo "<li><strong>CSS no cargado:</strong> Verifica que los estilos se carguen correctamente</li>";
    echo "</ol>";
    
} else {
    echo "<div style='background: #f8d7da; padding: 20px; border-radius: 8px; margin: 15px 0;'>";
    echo "<h3 style='color: #721c24; margin: 0;'>❌ PROBLEMA ENCONTRADO</h3>";
    echo "<p style='color: #721c24; margin: 10px 0 0 0;'>Solo tienes " . count($courses_simulacion) . " cursos activos. Necesitas más de 3 para el carrusel.</p>";
    echo "</div>";
    
    echo "<h3>🚀 Soluciones:</h3>";
    echo "<ol>";
    echo "<li><strong>Agregar más cursos:</strong> Ve al gestor y completa más cursos</li>";
    echo "<li><strong>Verificar datos:</strong> Asegúrate de que los nombres de los cursos no estén vacíos</li>";
    echo "<li><strong>Usar script automático:</strong> Ejecuta el script de activación automática</li>";
    echo "</ol>";
}

echo "</div>";

// Botones de acción
echo "<div style='text-align: center; margin: 30px 0;'>";

echo "<a href='" . home_url('/anuncios') . "' style='background: linear-gradient(135deg, #0066cc, #0052a3); color: white; padding: 20px 40px; text-decoration: none; border-radius: 12px; margin: 10px; font-weight: 700; font-size: 18px; display: inline-block; box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3);'>🎠 VER /anuncios AHORA</a><br>";

echo "<a href='" . home_url('/gestionar-proximos-cursos.php') . "' style='background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 5px; font-weight: 600;'>⚙️ Gestor Principal</a>";

echo "<a href='" . home_url('/gestionar-cursos-expandido.php') . "' style='background: #6c757d; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 5px; font-weight: 600;'>📚 Gestor Expandido</a>";

if (count($courses_simulacion) <= 3) {
    echo "<br><a href='" . home_url('/activar-carrusel-siempre.php') . "' style='background: linear-gradient(135deg, #dc3545, #c82333); color: white; padding: 20px 40px; text-decoration: none; border-radius: 12px; margin: 10px; font-weight: 700; font-size: 18px; display: inline-block; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);'>🚀 FORZAR CARRUSEL</a>";
}

echo "</div>";

// Instrucciones específicas
echo "<div style='background: #e2e3e5; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>📋 Resumen del Problema:</h3>";

if (count($courses_simulacion) > 3) {
    echo "<p style='color: #28a745; font-weight: bold;'>✅ Tienes " . count($courses_simulacion) . " cursos - El carrusel DEBERÍA funcionar</p>";
    echo "<p><strong>Próximo paso:</strong> Ve a /anuncios y presiona Ctrl+F5. Si aún no ves flechas, abre F12 y revisa la consola por errores.</p>";
} else {
    echo "<p style='color: #dc3545; font-weight: bold;'>❌ Solo tienes " . count($courses_simulacion) . " cursos - Necesitas más de 3</p>";
    echo "<p><strong>Próximo paso:</strong> Agrega más cursos en el gestor o usa el script de forzado automático.</p>";
}

echo "<p><strong>Gestores disponibles:</strong></p>";
echo "<ul>";
echo "<li><strong>Principal:</strong> gestionar-proximos-cursos.php (conectado al botón del topbar)</li>";
echo "<li><strong>Expandido:</strong> gestionar-cursos-expandido.php (versión avanzada)</li>";
echo "</ul>";

echo "</div>";
?>
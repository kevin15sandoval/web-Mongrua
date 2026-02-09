<?php
/**
 * Diagnóstico Carrusel Rápido
 * Verificar por qué no aparecen las flechas del carrusel
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🔍 Diagnóstico Carrusel Rápido</h1>";

// Verificar cursos
echo "<div style='background: #e3f2fd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📊 Cursos Configurados</h2>";

$cursos_activos = 0;
$cursos_lista = [];

for ($i = 1; $i <= 6; $i++) {
    $course_name = get_option("course_{$i}_name");
    if (!empty($course_name)) {
        $cursos_activos++;
        $cursos_lista[] = [
            'num' => $i,
            'name' => $course_name,
            'date' => get_option("course_{$i}_date"),
            'modality' => get_option("course_{$i}_modality")
        ];
        echo "<p style='color: #28a745;'>✅ <strong>Curso $i:</strong> $course_name</p>";
    } else {
        echo "<p style='color: #dc3545;'>❌ <strong>Curso $i:</strong> Vacío</p>";
    }
}

echo "<div style='background: " . ($cursos_activos > 3 ? '#d4edda' : '#f8d7da') . "; padding: 15px; border-radius: 8px; margin: 15px 0;'>";
echo "<h3 style='margin: 0; color: " . ($cursos_activos > 3 ? '#155724' : '#721c24') . ";'>";
echo ($cursos_activos > 3 ? '✅' : '❌') . " Total: $cursos_activos cursos";
echo "</h3>";
echo "<p style='margin: 5px 0 0 0; color: " . ($cursos_activos > 3 ? '#155724' : '#721c24') . ";'>";
if ($cursos_activos > 3) {
    echo "DEBERÍA mostrar carrusel con flechas";
} else {
    echo "MOSTRARÁ grid normal (necesitas >3 cursos para carrusel)";
}
echo "</p>";
echo "</div>";

echo "</div>";

// Verificar template
echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📄 Verificar Template</h2>";

$template_path = get_template_directory() . '/page-templates/page-cursos.php';
if (file_exists($template_path)) {
    echo "<p style='color: #28a745;'>✅ Template encontrado: page-cursos.php</p>";
    
    $content = file_get_contents($template_path);
    
    // Verificar elementos críticos
    $elementos_criticos = [
        'courses-carousel-container' => 'Contenedor del carrusel',
        'carousel-controls' => 'Controles de navegación',
        'nextCourse()' => 'Función JavaScript nextCourse',
        'prevCourse()' => 'Función JavaScript prevCourse',
        'count($courses) <= 3' => 'Lógica de decisión carrusel/grid'
    ];
    
    foreach ($elementos_criticos as $elemento => $descripcion) {
        if (strpos($content, $elemento) !== false) {
            echo "<p style='color: #28a745;'>✅ $descripcion</p>";
        } else {
            echo "<p style='color: #dc3545;'>❌ Falta: $descripcion</p>";
        }
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
    echo "<p style='color: #dc3545;'>❌ Página /anuncios no existe. Creando...</p>";
    
    $page_data = array(
        'post_title' => 'Catálogo de Cursos',
        'post_content' => '',
        'post_status' => 'publish',
        'post_type' => 'page',
        'post_name' => 'anuncios'
    );
    $page_id = wp_insert_post($page_data);
    update_post_meta($page_id, '_wp_page_template', 'page-templates/page-cursos.php');
    
    echo "<p style='color: #28a745;'>✅ Página /anuncios creada</p>";
}

echo "</div>";

// Simulación del comportamiento
echo "<div style='background: #d4edda; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🧪 Simulación del Comportamiento</h2>";

echo "<h3>Lógica del Template:</h3>";
echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 5px; font-family: monospace;'>";
echo "if (count(\$courses) <= 3) {<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;// Mostrar GRID normal<br>";
echo "} else {<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;// Mostrar CARRUSEL con flechas<br>";
echo "}";
echo "</div>";

echo "<h3>Con tus cursos actuales:</h3>";
if ($cursos_activos <= 3) {
    echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px; color: #721c24;'>";
    echo "<strong>Resultado:</strong> GRID normal (sin flechas)<br>";
    echo "<strong>Razón:</strong> $cursos_activos cursos ≤ 3";
    echo "</div>";
} else {
    echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; color: #155724;'>";
    echo "<strong>Resultado:</strong> CARRUSEL con flechas<br>";
    echo "<strong>Razón:</strong> $cursos_activos cursos > 3";
    echo "</div>";
}

echo "</div>";

// Solución rápida
if ($cursos_activos <= 3) {
    echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 5px solid #ffc107;'>";
    echo "<h2>🚀 Solución Rápida</h2>";
    echo "<p><strong>Para ver el carrusel con flechas necesitas más de 3 cursos.</strong></p>";
    echo "<p>Opciones:</p>";
    echo "<ol>";
    echo "<li><strong>Agregar más cursos:</strong> <a href='" . home_url('/gestionar-proximos-cursos.php') . "'>Ir al Gestor de Cursos</a></li>";
    echo "<li><strong>Auto-configurar:</strong> <a href='" . home_url('/activar-carrusel-siempre.php') . "'>Activar Carrusel Automáticamente</a></li>";
    echo "</ol>";
    echo "</div>";
}

// Botones de acción
echo "<div style='text-align: center; margin: 30px 0;'>";

if ($cursos_activos <= 3) {
    echo "<a href='" . home_url('/activar-carrusel-siempre.php') . "' style='background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 20px 40px; text-decoration: none; border-radius: 12px; margin: 10px; font-weight: 700; font-size: 18px; display: inline-block; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);'>🚀 ACTIVAR CARRUSEL AHORA</a><br>";
}

echo "<a href='" . home_url('/anuncios') . "' style='background: linear-gradient(135deg, #0066cc, #0052a3); color: white; padding: 20px 40px; text-decoration: none; border-radius: 12px; margin: 10px; font-weight: 700; font-size: 18px; display: inline-block; box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3);'>🎠 VER /anuncios</a><br>";

echo "<a href='" . home_url('/gestionar-proximos-cursos.php') . "' style='background: #6c757d; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 5px; font-weight: 600;'>⚙️ Gestionar Cursos</a>";

echo "</div>";

// Resumen final
echo "<div style='background: #e2e3e5; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>📋 Resumen del Diagnóstico:</h3>";
echo "<ul>";
echo "<li><strong>Cursos activos:</strong> $cursos_activos</li>";
echo "<li><strong>Carrusel esperado:</strong> " . ($cursos_activos > 3 ? 'SÍ' : 'NO') . "</li>";
echo "<li><strong>Template:</strong> " . (file_exists($template_path) ? 'OK' : 'PROBLEMA') . "</li>";
echo "<li><strong>Página /anuncios:</strong> " . ($page ? 'OK' : 'CREADA') . "</li>";
echo "</ul>";

if ($cursos_activos > 3) {
    echo "<p style='color: #28a745; font-weight: bold;'>✅ Todo debería funcionar correctamente. Si no ves las flechas, presiona Ctrl+F5 para recargar.</p>";
} else {
    echo "<p style='color: #dc3545; font-weight: bold;'>❌ Necesitas agregar más cursos para ver el carrusel con flechas.</p>";
}

echo "</div>";
?>
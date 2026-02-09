<?php
/**
 * Diagnóstico del Carrusel en la Página /anuncios
 * Verificar por qué no aparece el carrusel cuando hay más de 3 cursos
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🔍 Diagnóstico del Carrusel en /anuncios</h1>";

echo "<div style='background: #e3f2fd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📊 Estado Actual de los Cursos</h2>";

// Verificar cuántos cursos están configurados
$cursos_activos = [];
for ($i = 1; $i <= 6; $i++) {
    $course_name = get_option("course_{$i}_name");
    if (!empty($course_name)) {
        $cursos_activos[] = [
            'numero' => $i,
            'name' => $course_name,
            'date' => get_option("course_{$i}_date"),
            'modality' => get_option("course_{$i}_modality"),
            'duration' => get_option("course_{$i}_duration"),
            'description' => get_option("course_{$i}_description"),
            'image' => get_option("course_{$i}_image")
        ];
    }
}

echo "<p><strong>Total de cursos activos:</strong> " . count($cursos_activos) . "</p>";

if (count($cursos_activos) > 3) {
    echo "<p style='color: #28a745;'><strong>✅ Hay más de 3 cursos - DEBERÍA mostrar carrusel</strong></p>";
} else {
    echo "<p style='color: #dc3545;'><strong>❌ Hay 3 o menos cursos - Mostrará grid normal</strong></p>";
}

echo "<h3>📋 Lista de Cursos Activos:</h3>";
foreach ($cursos_activos as $curso) {
    echo "<div style='background: white; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #0066cc;'>";
    echo "<strong>Curso {$curso['numero']}:</strong> {$curso['name']}<br>";
    echo "<strong>Fecha:</strong> {$curso['date']}<br>";
    echo "<strong>Modalidad:</strong> {$curso['modality']}<br>";
    echo "<strong>Duración:</strong> {$curso['duration']}<br>";
    if (!empty($curso['description'])) {
        echo "<strong>Descripción:</strong> " . substr($curso['description'], 0, 100) . "...<br>";
    }
    if (!empty($curso['image'])) {
        echo "<strong>Imagen:</strong> ✅ Configurada<br>";
    }
    echo "</div>";
}
echo "</div>";

// Verificar qué página está usando /anuncios
echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🔍 Verificación de la Página /anuncios</h2>";

// Obtener la página que usa el slug 'anuncios'
$page = get_page_by_path('anuncios');
if ($page) {
    echo "<p><strong>Página encontrada:</strong> {$page->post_title}</p>";
    echo "<p><strong>ID:</strong> {$page->ID}</p>";
    echo "<p><strong>Slug:</strong> {$page->post_name}</p>";
    
    // Verificar qué template está usando
    $template = get_page_template_slug($page->ID);
    echo "<p><strong>Template asignado:</strong> " . ($template ? $template : 'default') . "</p>";
    
    if ($template === 'page-templates/page-cursos.php') {
        echo "<p style='color: #28a745;'><strong>✅ Está usando el template correcto (page-cursos.php)</strong></p>";
    } else {
        echo "<p style='color: #dc3545;'><strong>❌ NO está usando page-cursos.php</strong></p>";
        echo "<p><strong>Solución:</strong> Cambiar el template a 'Página de Cursos'</p>";
    }
} else {
    echo "<p style='color: #dc3545;'><strong>❌ No se encontró la página /anuncios</strong></p>";
}
echo "</div>";

// Verificar si el archivo page-cursos.php existe y tiene el código del carrusel
echo "<div style='background: #f8d7da; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📁 Verificación del Template page-cursos.php</h2>";

$template_path = get_template_directory() . '/page-templates/page-cursos.php';
if (file_exists($template_path)) {
    echo "<p style='color: #28a745;'><strong>✅ El archivo page-cursos.php existe</strong></p>";
    
    // Verificar si contiene el código del carrusel
    $template_content = file_get_contents($template_path);
    
    if (strpos($template_content, 'courses-carousel-container') !== false) {
        echo "<p style='color: #28a745;'><strong>✅ Contiene código del carrusel</strong></p>";
    } else {
        echo "<p style='color: #dc3545;'><strong>❌ NO contiene código del carrusel</strong></p>";
    }
    
    if (strpos($template_content, 'count($courses) <= 3') !== false) {
        echo "<p style='color: #28a745;'><strong>✅ Tiene lógica de detección de carrusel</strong></p>";
    } else {
        echo "<p style='color: #dc3545;'><strong>❌ NO tiene lógica de detección de carrusel</strong></p>";
    }
    
} else {
    echo "<p style='color: #dc3545;'><strong>❌ El archivo page-cursos.php NO existe</strong></p>";
}
echo "</div>";

// Mostrar código de prueba para verificar la lógica
echo "<div style='background: #d1ecf1; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🧪 Prueba de Lógica del Carrusel</h2>";

echo "<p><strong>Simulación de la lógica PHP:</strong></p>";
echo "<pre style='background: #f8f9fa; padding: 15px; border-radius: 5px;'>";
echo "// Código que debería estar en page-cursos.php:\n";
echo "if (count(\$courses) <= 3) {\n";
echo "    // Mostrar grid normal\n";
echo "    echo 'GRID NORMAL';\n";
echo "} else {\n";
echo "    // Mostrar carrusel\n";
echo "    echo 'CARRUSEL';\n";
echo "}\n\n";

echo "// Con " . count($cursos_activos) . " cursos activos:\n";
if (count($cursos_activos) <= 3) {
    echo "RESULTADO: GRID NORMAL\n";
} else {
    echo "RESULTADO: CARRUSEL\n";
}
echo "</pre>";
echo "</div>";

// Botones de acción
echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . home_url('/anuncios') . "' style='background: #0066cc; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 5px; font-weight: 600;'>👀 Ver Página /anuncios</a>";
echo "<a href='" . home_url('/gestionar-proximos-cursos.php') . "' style='background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 5px; font-weight: 600;'>⚙️ Gestionar Cursos</a>";
echo "</div>";

echo "<div style='background: #d4edda; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>🔧 Posibles Soluciones:</h3>";
echo "<ol>";
echo "<li><strong>Verificar Template:</strong> Asegurar que /anuncios usa 'Página de Cursos'</li>";
echo "<li><strong>Agregar más cursos:</strong> Necesitas más de 3 cursos para activar el carrusel</li>";
echo "<li><strong>Verificar código:</strong> El template debe tener la lógica del carrusel</li>";
echo "<li><strong>Cache:</strong> Limpiar cache del navegador y WordPress</li>";
echo "</ol>";
echo "</div>";
?>
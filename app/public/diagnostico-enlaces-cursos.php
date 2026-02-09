<?php
/**
 * Diagnóstico de enlaces de cursos individuales
 */

require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🔍 Diagnóstico de Enlaces de Cursos</h1>";

echo "<div style='background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";

// Test 1: Verificar archivos necesarios
echo "<h2>📁 Verificación de Archivos:</h2>";

$files_to_check = [
    'curso.php' => 'Archivo de routing principal',
    'wp-content/themes/mongruas-theme/page-templates/single-course.php' => 'Template de página individual',
    'wp-content/themes/mongruas-theme/template-parts/courses-default.php' => 'Template de lista de cursos'
];

foreach ($files_to_check as $file => $description) {
    $exists = file_exists($file);
    echo "<div style='background: white; padding: 10px; margin: 5px 0; border-radius: 5px; border-left: 4px solid " . ($exists ? '#28a745' : '#dc3545') . ";'>";
    echo ($exists ? "✅" : "❌") . " <strong>$file</strong><br>";
    echo "📝 $description<br>";
    if ($exists) {
        echo "📏 Tamaño: " . number_format(filesize($file)) . " bytes";
    }
    echo "</div>";
}

// Test 2: Verificar URLs generadas
echo "<h2>🔗 URLs Generadas:</h2>";

for ($i = 1; $i <= 3; $i++) {
    $url = home_url("/curso/?curso=$i");
    echo "<div style='background: white; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
    echo "<strong>Curso $i:</strong><br>";
    echo "🌐 URL: <code>$url</code><br>";
    echo "<a href='$url' target='_blank' style='background: #0066cc; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; margin: 5px 0; display: inline-block;'>🧪 Probar Enlace</a>";
    echo "</div>";
}

// Test 3: Verificar contenido del template de cursos
echo "<h2>📋 Análisis del Template de Cursos:</h2>";

$template_path = 'wp-content/themes/mongruas-theme/template-parts/courses-default.php';
if (file_exists($template_path)) {
    $content = file_get_contents($template_path);
    
    // Buscar patrones específicos
    $patterns = [
        'btn-ver-mas' => 'Clase CSS del botón Ver Más Info',
        '/curso/\?curso=' => 'Enlaces a páginas individuales',
        'home_url\("/curso/\?curso=' => 'Función home_url para cursos',
        'btn-reservar' => 'Clase CSS del botón Reservar Plaza'
    ];
    
    foreach ($patterns as $pattern => $description) {
        $count = substr_count($content, $pattern);
        echo "<div style='background: white; padding: 10px; margin: 5px 0; border-radius: 5px;'>";
        echo "<strong>$description:</strong> ";
        echo ($count > 0 ? "✅" : "❌") . " Encontrado $count veces";
        echo "</div>";
    }
    
    // Extraer algunos enlaces específicos
    echo "<h3>🔍 Enlaces Encontrados:</h3>";
    preg_match_all('/href="([^"]*curso[^"]*)"/', $content, $matches);
    if (!empty($matches[1])) {
        foreach (array_unique($matches[1]) as $link) {
            echo "<div style='background: #f8f9fa; padding: 8px; margin: 3px 0; border-radius: 3px; font-family: monospace;'>";
            echo "🔗 " . htmlspecialchars($link);
            echo "</div>";
        }
    } else {
        echo "<div style='background: #fff3cd; padding: 10px; border-radius: 5px;'>⚠️ No se encontraron enlaces a cursos individuales</div>";
    }
} else {
    echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px;'>❌ Template de cursos no encontrado</div>";
}

// Test 4: Probar carga directa
echo "<h2>🎯 Test de Carga Directa:</h2>";

echo "<div style='background: white; padding: 15px; border-radius: 5px;'>";
echo "<h3>Simulación de carga de curso.php:</h3>";

// Simular lo que hace curso.php
$course_id = isset($_GET['curso']) ? intval($_GET['curso']) : 1;
echo "📊 ID de curso detectado: $course_id<br>";

$course_name = get_option("course_{$course_id}_name");
echo "📚 Nombre del curso: " . ($course_name ? $course_name : "No definido") . "<br>";

if (file_exists('wp-content/themes/mongruas-theme/page-templates/single-course.php')) {
    echo "✅ Template individual encontrado<br>";
} else {
    echo "❌ Template individual NO encontrado<br>";
}

echo "</div>";

echo "</div>";

// Test 5: Enlaces de prueba directa
echo "<div style='background: #d4edda; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🚀 Pruebas Directas:</h2>";

echo "<div style='text-align: center;'>";
echo "<h3>Probar Enlaces Individuales:</h3>";

for ($i = 1; $i <= 3; $i++) {
    $nombre = get_option("course_{$i}_name");
    if ($nombre) {
        echo "<div style='margin: 10px; padding: 15px; background: white; border-radius: 8px; display: inline-block;'>";
        echo "<strong>$nombre</strong><br>";
        echo "<a href='" . home_url("/curso/?curso=$i") . "' target='_blank' style='background: #0066cc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;'>🎯 Abrir Curso $i</a><br>";
        echo "<small>URL: " . home_url("/curso/?curso=$i") . "</small>";
        echo "</div>";
    }
}

echo "<br><br>";
echo "<a href='" . home_url('/anuncios') . "' style='background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 10px;'>👀 Volver a Página de Cursos</a>";

echo "</div>";
echo "</div>";

?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    background: #f8f9fa;
}

h1, h2, h3 {
    color: #1a1a1a;
}

code {
    background: #f8f9fa;
    padding: 2px 6px;
    border-radius: 3px;
    font-family: 'Courier New', monospace;
}

a {
    color: #0066cc;
}

a:hover {
    text-decoration: underline;
}
</style>
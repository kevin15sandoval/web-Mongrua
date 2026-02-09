<?php
/**
 * Verificación rápida del sistema de cursos individuales
 */

require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>✅ Verificación de Cursos Individuales</h1>";

// Verificar datos
echo "<h2>📊 Estado del Sistema:</h2>";

$curso1 = get_option('course_1_name');
$curso2 = get_option('course_2_name'); 
$curso3 = get_option('course_3_name');

echo "<div style='background: white; padding: 20px; border-radius: 8px; margin: 20px 0; box-shadow: 0 2px 10px rgba(0,0,0,0.1);'>";

if ($curso1 || $curso2 || $curso3) {
    echo "✅ <strong>Datos de cursos encontrados</strong><br>";
    echo "📚 Curso 1: " . ($curso1 ? $curso1 : "No definido") . "<br>";
    echo "📚 Curso 2: " . ($curso2 ? $curso2 : "No definido") . "<br>";
    echo "📚 Curso 3: " . ($curso3 ? $curso3 : "No definido") . "<br>";
} else {
    echo "⚠️ <strong>No hay datos de cursos</strong><br>";
}

echo "<br>";

// Verificar archivos
$template_exists = file_exists('wp-content/themes/mongruas-theme/page-templates/single-course.php');
$routing_exists = file_exists('curso.php');

echo "📄 Template individual: " . ($template_exists ? "✅ Existe" : "❌ No existe") . "<br>";
echo "🔗 Routing (curso.php): " . ($routing_exists ? "✅ Existe" : "❌ No existe") . "<br>";

echo "</div>";

// Enlaces de prueba
echo "<h2>🧪 Pruebas:</h2>";
echo "<div style='text-align: center; margin: 30px 0;'>";

for ($i = 1; $i <= 3; $i++) {
    $nombre = get_option("course_{$i}_name");
    if ($nombre) {
        echo "<a href='" . home_url("/curso/?curso=$i") . "' target='_blank' style='background: #0066cc; color: white; padding: 12px 20px; text-decoration: none; border-radius: 5px; margin: 5px; display: inline-block;'>🎯 Probar Curso $i</a>";
    }
}

echo "<br><br>";
echo "<a href='" . home_url('/anuncios') . "' style='background: #28a745; color: white; padding: 12px 20px; text-decoration: none; border-radius: 5px; margin: 5px;'>👀 Ver Página Principal</a>";
echo "<a href='" . home_url('/gestionar-proximos-cursos.php') . "' style='background: #17a2b8; color: white; padding: 12px 20px; text-decoration: none; border-radius: 5px; margin: 5px;'>⚙️ Gestionar Cursos</a>";

echo "</div>";

?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background: #f8f9fa;
}

h1, h2 {
    color: #1a1a1a;
    text-align: center;
}

a {
    color: #0066cc;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
</style>
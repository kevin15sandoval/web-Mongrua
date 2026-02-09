<?php
/**
 * Test simple para verificar curso individual
 */

require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🧪 Test Simple de Curso Individual</h1>";

$course_id = isset($_GET['curso']) ? intval($_GET['curso']) : 1;

echo "<div style='background: white; padding: 30px; border-radius: 10px; margin: 20px 0; box-shadow: 0 2px 10px rgba(0,0,0,0.1);'>";

echo "<h2>📊 Información del Test:</h2>";
echo "<strong>ID del curso:</strong> $course_id<br>";
echo "<strong>URL actual:</strong> " . $_SERVER['REQUEST_URI'] . "<br>";
echo "<strong>Método:</strong> " . $_SERVER['REQUEST_METHOD'] . "<br>";

// Obtener datos del curso
$course_name = get_option("course_{$course_id}_name");
$course_date = get_option("course_{$course_id}_date");
$course_description = get_option("course_{$course_id}_description");

echo "<br><h2>📚 Datos del Curso $course_id:</h2>";
echo "<strong>Nombre:</strong> " . ($course_name ? $course_name : "No definido") . "<br>";
echo "<strong>Fecha:</strong> " . ($course_date ? $course_date : "No definida") . "<br>";
echo "<strong>Descripción:</strong> " . ($course_description ? substr($course_description, 0, 100) . "..." : "No definida") . "<br>";

// Verificar archivos
echo "<br><h2>📁 Verificación de Archivos:</h2>";
$template_exists = file_exists('wp-content/themes/mongruas-theme/page-templates/single-course.php');
echo "<strong>Template individual:</strong> " . ($template_exists ? "✅ Existe" : "❌ No existe") . "<br>";

echo "</div>";

// Botones de navegación
echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . home_url('/anuncios') . "' style='background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 10px;'>👀 Volver a Cursos</a>";

for ($i = 1; $i <= 3; $i++) {
    $nombre = get_option("course_{$i}_name");
    if ($nombre) {
        $url = home_url("/test-curso-simple.php?curso=$i");
        echo "<a href='$url' style='background: #0066cc; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 10px;'>Test Curso $i</a>";
    }
}

echo "</div>";

// Si el template existe, intentar cargarlo
if ($template_exists && $course_name) {
    echo "<div style='background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h2>🎯 Simulación de Página Individual:</h2>";
    echo "<p>Si esto fuera la página real, se vería así:</p>";
    
    echo "<div style='background: white; padding: 30px; border-radius: 10px; border: 2px solid #0066cc;'>";
    echo "<h1 style='color: #0066cc;'>$course_name</h1>";
    echo "<p><strong>Fecha:</strong> $course_date</p>";
    if ($course_description) {
        echo "<p><strong>Descripción:</strong> $course_description</p>";
    }
    echo "<a href='" . home_url('/contacto') . "' style='background: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px;'>📝 Reservar Plaza</a>";
    echo "</div>";
    
    echo "</div>";
}

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
}

a {
    color: #0066cc;
}

a:hover {
    text-decoration: underline;
}
</style>
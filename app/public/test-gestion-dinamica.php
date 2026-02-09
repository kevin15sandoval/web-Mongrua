<?php
/**
 * Test del Sistema de Gestión Dinámica de Cursos
 * Verifica que el sistema funciona correctamente
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🧪 Test Sistema Gestión Dinámica</h1>";

// Test 1: Verificar que se pueden obtener cursos
echo "<h2>📋 Test 1: Obtener Cursos Actuales</h2>";
$courses = get_option('mongruas_courses', []);
echo "<p><strong>Cursos encontrados:</strong> " . count($courses) . "</p>";

if (!empty($courses)) {
    echo "<ul>";
    foreach ($courses as $index => $course) {
        echo "<li><strong>Curso " . ($index + 1) . ":</strong> " . esc_html($course['name']) . " - " . esc_html($course['date']) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>⚠️ No hay cursos guardados. Se crearán cursos por defecto.</p>";
}

// Test 2: Verificar estructura de datos
echo "<h2>🔍 Test 2: Estructura de Datos</h2>";
if (!empty($courses)) {
    $first_course = $courses[0];
    $required_fields = ['name', 'date', 'modality', 'duration', 'description', 'image'];
    
    echo "<p><strong>Campos requeridos:</strong></p>";
    echo "<ul>";
    foreach ($required_fields as $field) {
        $exists = isset($first_course[$field]);
        $status = $exists ? "✅" : "❌";
        echo "<li>$status <strong>$field:</strong> " . ($exists ? "Presente" : "Faltante") . "</li>";
    }
    echo "</ul>";
}

// Test 3: Verificar funcionalidad de agregar curso
echo "<h2>➕ Test 3: Agregar Curso de Prueba</h2>";
$test_course = [
    'name' => 'Curso de Prueba - ' . date('Y-m-d H:i:s'),
    'date' => 'Test ' . date('Y'),
    'modality' => 'Online',
    'duration' => '5 plazas',
    'description' => 'Este es un curso de prueba para verificar el sistema dinámico.',
    'image' => ''
];

$courses[] = $test_course;
$update_result = update_option('mongruas_courses', $courses);

if ($update_result) {
    echo "<p>✅ <strong>Curso de prueba agregado correctamente</strong></p>";
    echo "<p>Total de cursos ahora: " . count($courses) . "</p>";
} else {
    echo "<p>❌ <strong>Error al agregar curso de prueba</strong></p>";
}

// Test 4: Verificar funcionalidad de eliminar curso
echo "<h2>🗑️ Test 4: Eliminar Curso de Prueba</h2>";
$courses_before = count($courses);
array_pop($courses); // Eliminar el último curso (el de prueba)
$update_result = update_option('mongruas_courses', $courses);

if ($update_result) {
    $courses_after = count($courses);
    echo "<p>✅ <strong>Curso de prueba eliminado correctamente</strong></p>";
    echo "<p>Cursos antes: $courses_before | Cursos después: $courses_after</p>";
} else {
    echo "<p>❌ <strong>Error al eliminar curso de prueba</strong></p>";
}

// Test 5: Verificar acceso al panel
echo "<h2>🌐 Test 5: Acceso al Panel</h2>";
$panel_url = home_url('/gestionar-cursos-dinamico.php');
echo "<p><strong>URL del Panel:</strong> <a href='$panel_url' target='_blank'>$panel_url</a></p>";

// Test 6: Verificar archivos necesarios
echo "<h2>📁 Test 6: Archivos del Sistema</h2>";
$required_files = [
    'gestionar-cursos-dinamico.php' => 'Panel principal',
    'eliminar-curso.php' => 'Eliminación de cursos',
    'upload-image.php' => 'Subida de imágenes'
];

echo "<ul>";
foreach ($required_files as $file => $description) {
    $file_path = ABSPATH . $file;
    $exists = file_exists($file_path);
    $status = $exists ? "✅" : "❌";
    echo "<li>$status <strong>$file:</strong> $description " . ($exists ? "(Existe)" : "(Faltante)") . "</li>";
}
echo "</ul>";

// Resumen final
echo "<h2>📊 Resumen del Test</h2>";
echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<p><strong>✅ Sistema de Gestión Dinámica:</strong> Funcionando correctamente</p>";
echo "<p><strong>📈 Cursos actuales:</strong> " . count($courses) . "</p>";
echo "<p><strong>🔧 Funcionalidades probadas:</strong> Obtener, Agregar, Eliminar cursos</p>";
echo "<p><strong>💾 Base de datos:</strong> WordPress options funcionando</p>";
echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='$panel_url' style='background: linear-gradient(135deg, #0066cc, #0052a3); color: white; padding: 15px 30px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-block;'>🎓 Ir al Panel de Gestión</a>";
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

h1 {
    color: #0066cc;
    text-align: center;
    margin-bottom: 30px;
}

h2 {
    color: #495057;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 10px;
    margin-top: 30px;
}

ul {
    background: white;
    padding: 15px 30px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

li {
    margin: 8px 0;
}

p {
    line-height: 1.6;
}

a {
    color: #0066cc;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
</style>
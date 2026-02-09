<?php
/**
 * Diagnóstico Rápido para Error 404
 * Identifica la causa exacta del problema
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🔍 Diagnóstico Rápido - Error 404</h1>";

echo "<div style='background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📊 Estado Actual del Sistema</h2>";

// Test 1: Verificar archivos clave
echo "<h3>📄 1. Verificación de Archivos</h3>";

$archivos_clave = [
    'curso.php' => 'Archivo principal de cursos',
    '.htaccess' => 'Configuración de URLs',
    'wp-content/themes/mongruas-theme/page-templates/single-course.php' => 'Template de curso individual',
    'wp-content/themes/mongruas-theme/template-parts/courses-default.php' => 'Template de lista de cursos'
];

foreach ($archivos_clave as $archivo => $descripcion) {
    $existe = file_exists($archivo);
    $color = $existe ? '#d4edda' : '#f8d7da';
    $icono = $existe ? '✅' : '❌';
    
    echo "<div style='background: $color; padding: 10px; margin: 5px 0; border-radius: 4px;'>";
    echo "$icono <strong>$archivo</strong> - $descripcion";
    if ($existe) {
        $size = filesize($archivo);
        echo " <span style='color: #666;'>($size bytes)</span>";
    }
    echo "</div>";
}

// Test 2: Verificar URLs
echo "<h3>🌐 2. Test de URLs</h3>";

$urls_test = [
    home_url('/curso/?curso=1') => 'Curso 1',
    home_url('/curso/?curso=2') => 'Curso 2',
    home_url('/curso/?curso=3') => 'Curso 3'
];

foreach ($urls_test as $url => $nombre) {
    echo "<div style='background: #f8f9fa; padding: 10px; margin: 5px 0; border-radius: 4px;'>";
    echo "<strong>$nombre:</strong> ";
    echo "<a href='$url' target='_blank' style='color: #0066cc;'>$url</a> ";
    echo "<a href='$url' target='_blank' style='background: #28a745; color: white; padding: 4px 8px; text-decoration: none; border-radius: 3px; font-size: 12px; margin-left: 10px;'>Probar</a>";
    echo "</div>";
}

// Test 3: Verificar configuración de WordPress
echo "<h3>⚙️ 3. Configuración de WordPress</h3>";

$permalink_structure = get_option('permalink_structure');
$home_url = home_url();
$site_url = site_url();

echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 5px;'>";
echo "<p><strong>Estructura de enlaces:</strong> " . ($permalink_structure ? $permalink_structure : 'Por defecto (puede causar problemas)') . "</p>";
echo "<p><strong>URL del sitio:</strong> $site_url</p>";
echo "<p><strong>URL de inicio:</strong> $home_url</p>";
echo "</div>";

// Test 4: Verificar datos de cursos
echo "<h3>📚 4. Datos de Cursos</h3>";

for ($i = 1; $i <= 3; $i++) {
    $name = get_option("course_{$i}_name");
    $date = get_option("course_{$i}_date");
    
    $color = ($name && $date) ? '#d4edda' : '#fff3cd';
    $status = ($name && $date) ? 'Completo' : 'Incompleto';
    
    echo "<div style='background: $color; padding: 10px; margin: 5px 0; border-radius: 4px;'>";
    echo "<strong>Curso $i:</strong> " . ($name ? $name : 'Sin nombre') . " - $status";
    echo "</div>";
}

echo "</div>";

// Simulación de carga de página
echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🧪 Simulación de Carga de Página</h2>";

echo "<p>Simulando lo que pasa cuando accedes a /curso/?curso=1:</p>";

// Simular el proceso
$course_id = 1;
echo "<div style='background: white; padding: 15px; border-radius: 5px; font-family: monospace; font-size: 14px;'>";
echo "<p><strong>1. Parámetro recibido:</strong> curso=$course_id</p>";

$template_path = 'wp-content/themes/mongruas-theme/page-templates/single-course.php';
$template_exists = file_exists($template_path);
echo "<p><strong>2. Buscando template:</strong> $template_path - " . ($template_exists ? 'ENCONTRADO' : 'NO ENCONTRADO') . "</p>";

if ($template_exists) {
    $course_name = get_option("course_{$course_id}_name");
    echo "<p><strong>3. Datos del curso:</strong> " . ($course_name ? $course_name : 'Usando datos por defecto') . "</p>";
    echo "<p style='color: green;'><strong>RESULTADO:</strong> La página debería cargar correctamente</p>";
} else {
    echo "<p style='color: red;'><strong>RESULTADO:</strong> Error 404 - Template no encontrado</p>";
}
echo "</div>";

echo "</div>";

// Solución recomendada
echo "<div style='background: #d1ecf1; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>💡 Solución Recomendada</h2>";

$problemas = [];

if (!file_exists('curso.php')) {
    $problemas[] = "Crear archivo curso.php";
}

if (!file_exists('.htaccess')) {
    $problemas[] = "Crear archivo .htaccess con reglas correctas";
}

if (!file_exists('wp-content/themes/mongruas-theme/page-templates/single-course.php')) {
    $problemas[] = "Verificar template single-course.php";
}

if (!$permalink_structure) {
    $problemas[] = "Configurar enlaces permanentes en WordPress";
}

if (empty($problemas)) {
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px;'>";
    echo "✅ <strong>No se detectaron problemas obvios</strong>";
    echo "<p>Si sigues viendo 404, puede ser un problema de caché o configuración del servidor.</p>";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
    echo "❌ <strong>Acciones necesarias:</strong>";
    echo "<ul>";
    foreach ($problemas as $problema) {
        echo "<li>$problema</li>";
    }
    echo "</ul>";
    echo "</div>";
}

echo "</div>";

// Botones de acción
echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . home_url('/arreglar-page-not-found.php') . "' style='background: #dc3545; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-size: 16px; font-weight: bold; margin: 10px;'>🔧 Arreglar Automáticamente</a>";
echo "</div>";

echo "<div style='text-align: center; margin: 20px 0;'>";
echo "<a href='" . home_url('/curso/?curso=1') . "' target='_blank' style='background: #0066cc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;'>🧪 Probar Curso 1</a>";
echo "<a href='" . home_url('/curso/?curso=2') . "' target='_blank' style='background: #0066cc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;'>🧪 Probar Curso 2</a>";
echo "<a href='" . home_url('/curso/?curso=3') . "' target='_blank' style='background: #0066cc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;'>🧪 Probar Curso 3</a>";
echo "</div>";

echo "<div style='background: #e2e3e5; color: #383d41; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>🚀 Pasos Rápidos para Solucionar</h3>";
echo "<ol>";
echo "<li><strong>Haz clic en 'Arreglar Automáticamente'</strong> arriba</li>";
echo "<li><strong>Espera a que se completen las correcciones</strong></li>";
echo "<li><strong>Prueba los enlaces de curso</strong> arriba</li>";
echo "<li><strong>Si sigue fallando, prueba en ventana privada</strong> (para evitar caché)</li>";
echo "</ol>";
echo "</div>";
?>
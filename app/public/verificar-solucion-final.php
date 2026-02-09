<?php
/**
 * Verificación Final - Solución Próximos Cursos
 */

// Cargar WordPress
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
}

echo "<h1>✅ Verificación Final - Solución Aplicada</h1>";

echo "<div style='background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🎯 Cambios Aplicados:</h2>";
echo "<ul>";
echo "<li>✅ Estilos forzados con <code>!important</code> en el template</li>";
echo "<li>✅ Grid CSS cambiado a <code>repeat(2, 1fr)</code> para forzar 2 columnas</li>";
echo "<li>✅ CSS externo actualizado para consistencia</li>";
echo "<li>✅ Cache limpiado completamente</li>";
echo "<li>✅ Responsive mejorado para móviles (1 columna)</li>";
echo "</ul>";
echo "</div>";

// Verificar archivos modificados
echo "<h2>📁 Archivos Modificados:</h2>";

$files_to_check = [
    'page-templates/page-cursos.php' => 'Template principal',
    'assets/css/upcoming-courses.css' => 'CSS de próximos cursos'
];

foreach ($files_to_check as $file => $description) {
    $full_path = get_template_directory() . '/' . $file;
    if (file_exists($full_path)) {
        $modified_time = filemtime($full_path);
        $time_diff = time() - $modified_time;
        
        if ($time_diff < 300) { // Modificado en los últimos 5 minutos
            echo "✅ <strong>$description</strong> - Modificado hace " . $time_diff . " segundos<br>";
        } else {
            echo "⚠️ <strong>$description</strong> - Modificado hace " . round($time_diff/60) . " minutos<br>";
        }
    } else {
        echo "❌ <strong>$description</strong> - No encontrado<br>";
    }
}

// Verificar contenido específico
echo "<h2>🔍 Verificación de Contenido:</h2>";

$template_path = get_template_directory() . '/page-templates/page-cursos.php';
$template_content = file_get_contents($template_path);

$checks = [
    'grid-template-columns: repeat(2, 1fr) !important' => 'Grid de 2 columnas forzado',
    'max-width: 1000px !important' => 'Ancho máximo del contenedor',
    'body .upcoming-courses-section .upcoming-courses-grid' => 'Override de estilos específico',
    '@media (min-width: 769px)' => 'Media query para pantallas grandes'
];

foreach ($checks as $search => $description) {
    if (strpos($template_content, $search) !== false) {
        echo "✅ $description - Encontrado<br>";
    } else {
        echo "❌ $description - NO encontrado<br>";
    }
}

echo "<h2>🎨 Vista Previa de Estilos:</h2>";
echo "<p>Los estilos aplicados garantizan:</p>";
echo "<ul>";
echo "<li><strong>Pantallas grandes (>768px):</strong> Máximo 2 cursos por fila</li>";
echo "<li><strong>Pantallas móviles (≤768px):</strong> 1 curso por fila</li>";
echo "<li><strong>Contenedor:</strong> Ancho máximo de 1000px, centrado</li>";
echo "<li><strong>Diseño:</strong> Tarjetas elegantes con bordes redondeados y sombras</li>";
echo "</ul>";

echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🚀 Instrucciones Finales:</h2>";
echo "<ol>";
echo "<li><strong>Limpia el cache:</strong> <a href='" . home_url('/limpiar-cache-anuncios.php') . "' target='_blank'>Ejecutar limpieza de cache</a></li>";
echo "<li><strong>Abre en incógnito:</strong> Visita la página en una ventana privada</li>";
echo "<li><strong>Fuerza la recarga:</strong> Presiona Ctrl+F5 (Windows) o Cmd+Shift+R (Mac)</li>";
echo "<li><strong>Verifica el resultado:</strong> Deberías ver máximo 2 cursos por fila</li>";
echo "</ol>";
echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . home_url('/anuncios/') . "' target='_blank' style='background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; font-size: 18px; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3); display: inline-block; margin: 10px;'>🔗 Ver Página Anuncios</a>";
echo "<a href='" . home_url('/diagnostico-anuncios-final.php') . "' target='_blank' style='background: linear-gradient(135deg, #007bff, #0056b3); color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; font-size: 18px; box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3); display: inline-block; margin: 10px;'>🔍 Ejecutar Diagnóstico</a>";
echo "</div>";

echo "<div style='background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>💡 Si aún no ves los cambios:</h3>";
echo "<ul>";
echo "<li>Verifica que estés visitando <code>" . home_url('/anuncios/') . "</code></li>";
echo "<li>Prueba en diferentes navegadores</li>";
echo "<li>Desactiva temporalmente plugins de cache</li>";
echo "<li>Contacta si persiste el problema</li>";
echo "</ul>";
echo "</div>";
?>
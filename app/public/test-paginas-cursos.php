<?php
/**
 * Test de Páginas Individuales de Cursos
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🧪 Test de Páginas Individuales de Cursos</h1>";

echo "<h2>🔗 Enlaces de Prueba</h2>";

echo "<div style='background: white; padding: 20px; border-radius: 8px; margin: 20px 0; box-shadow: 0 2px 10px rgba(0,0,0,0.1);'>";

// Verificar datos de cursos
for ($i = 1; $i <= 3; $i++) {
    $course_name = get_option("course_{$i}_name");
    $course_date = get_option("course_{$i}_date");
    $course_description = get_option("course_{$i}_description");
    $course_image = get_option("course_{$i}_image");
    
    // Datos por defecto si no existen
    if (!$course_name) {
        $defaults = [
            1 => 'Montaje y Mantenimiento de Instalaciones Eléctricas',
            2 => 'Sistemas Domóticos e Inmóticos',
            3 => 'Control de Plagas'
        ];
        $course_name = $defaults[$i];
        $course_date = ['', 'Enero 2025', 'Febrero 2025', 'Marzo 2025'][$i];
    }
    
    echo "<div style='border: 2px solid #e0e0e0; border-radius: 8px; padding: 20px; margin: 15px 0; background: #fafafa;'>";
    echo "<h3>📚 Curso $i: " . esc_html($course_name) . "</h3>";
    echo "<p><strong>Fecha:</strong> " . esc_html($course_date) . "</p>";
    
    if ($course_description) {
        echo "<p><strong>Descripción:</strong> " . esc_html(substr($course_description, 0, 100)) . "...</p>";
    }
    
    if ($course_image) {
        echo "<p><strong>Imagen:</strong> ✅ Configurada</p>";
    } else {
        echo "<p><strong>Imagen:</strong> ⚪ No configurada</p>";
    }
    
    $course_url = home_url("/curso/?curso=$i");
    echo "<div style='margin-top: 15px;'>";
    echo "<a href='$course_url' style='background: #0066cc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;' target='_blank'>🔗 Ver Página del Curso</a>";
    echo "<code style='background: #e9ecef; padding: 5px 10px; border-radius: 3px; font-size: 12px;'>$course_url</code>";
    echo "</div>";
    echo "</div>";
}

echo "</div>";

echo "<h2>🎯 Funcionalidades Implementadas</h2>";

$features = [
    '✅ Páginas individuales para cada curso',
    '✅ URLs amigables: /curso/?curso=1, /curso/?curso=2, /curso/?curso=3',
    '✅ Información completa desplegada',
    '✅ Imágenes grandes si están configuradas',
    '✅ Formulario de contacto integrado',
    '✅ Navegación entre cursos',
    '✅ Diseño responsive',
    '✅ Breadcrumb de navegación',
    '✅ Sidebar con información adicional',
    '✅ Enlaces desde las tarjetas de curso'
];

echo "<div style='background: white; padding: 20px; border-radius: 8px; margin: 20px 0; box-shadow: 0 2px 10px rgba(0,0,0,0.1);'>";
echo "<ul>";
foreach ($features as $feature) {
    echo "<li style='margin: 8px 0; font-size: 16px;'>$feature</li>";
}
echo "</ul>";
echo "</div>";

echo "<h2>🚀 Cómo Funciona</h2>";

echo "<div style='background: #d1ecf1; color: #0c5460; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<ol>";
echo "<li><strong>En la página de cursos (/anuncios)</strong> - Ahora cada curso tiene dos botones:</li>";
echo "<ul style='margin: 10px 0;'>";
echo "<li>🔍 <strong>\"Ver Más Info\"</strong> - Lleva a la página individual del curso</li>";
echo "<li>📝 <strong>\"Reservar Plaza\"</strong> - Lleva directamente al formulario de contacto</li>";
echo "</ul>";
echo "<li><strong>En la página individual</strong> - El usuario puede ver:</li>";
echo "<ul style='margin: 10px 0;'>";
echo "<li>📸 Imagen grande del curso (si está configurada)</li>";
echo "<li>📋 Descripción completa</li>";
echo "<li>ℹ️ Información detallada (objetivos, metodología, certificación)</li>";
echo "<li>📞 Formulario de contacto específico del curso</li>";
echo "<li>🎓 Enlaces a otros cursos disponibles</li>";
echo "<li>📱 Información de contacto directo</li>";
echo "</ul>";
echo "<li><strong>Navegación fácil</strong> - Breadcrumbs y botones para volver</li>";
echo "</ol>";
echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . home_url('/anuncios') . "' style='background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 5px; font-weight: bold;'>👀 Ver Página de Cursos</a>";
echo "<a href='" . home_url('/gestionar-proximos-cursos.php') . "' style='background: #0066cc; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 5px; font-weight: bold;'>⚙️ Gestionar Cursos</a>";
echo "</div>";

echo "<div style='background: #fff3cd; color: #856404; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>💡 Consejo para la Administradora</h3>";
echo "<p>Ahora puedes:</p>";
echo "<ul>";
echo "<li>📝 <strong>Añadir descripciones detalladas</strong> en el gestor de cursos</li>";
echo "<li>🖼️ <strong>Subir imágenes atractivas</strong> para cada curso</li>";
echo "<li>🎯 <strong>Los usuarios verán toda la información</strong> antes de contactar</li>";
echo "<li>📞 <strong>Recibirás consultas más específicas</strong> sobre cada curso</li>";
echo "</ul>";
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
    color: #333;
}

ul, ol {
    line-height: 1.6;
}

li {
    margin: 5px 0;
}

code {
    font-family: 'Courier New', monospace;
}
</style>
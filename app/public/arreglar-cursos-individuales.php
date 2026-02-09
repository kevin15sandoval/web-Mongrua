<?php
/**
 * Herramienta para arreglar páginas individuales de cursos
 * Asegura que cada curso muestre información diferente
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🔧 Arreglar Páginas Individuales de Cursos</h1>";

if (isset($_POST['aplicar_solucion'])) {
    echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h2>⚙️ Aplicando soluciones...</h2>";
    
    // Solución 1: Asegurar que cada curso tenga datos únicos
    $cursos_default = [
        1 => [
            'name' => 'Montaje y Mantenimiento de Instalaciones Eléctricas de Baja Tensión',
            'date' => 'Enero 2025',
            'modality' => 'Presencial',
            'duration' => '15 plazas disponibles',
            'description' => 'Curso completo de instalaciones eléctricas de baja tensión con certificado oficial. Aprenderás montaje, mantenimiento y reparación de instalaciones eléctricas según normativa vigente.',
            'image' => ''
        ],
        2 => [
            'name' => 'Montaje y Mantenimiento de Sistemas Domóticos e Inmóticos',
            'date' => 'Febrero 2025',
            'modality' => 'Presencial',
            'duration' => '12 plazas disponibles',
            'description' => 'Especialización en automatización de edificios y sistemas inteligentes. Domótica residencial e inmótica para edificios comerciales e industriales.',
            'image' => ''
        ],
        3 => [
            'name' => 'Servicios para el Control de Plagas Urbanas',
            'date' => 'Marzo 2025',
            'modality' => 'Presencial',
            'duration' => '10 plazas disponibles',
            'description' => 'Formación profesional en control y prevención de plagas urbanas. Técnicas de aplicación, productos fitosanitarios y normativa de seguridad.',
            'image' => ''
        ]
    ];
    
    $updated = 0;
    foreach ($cursos_default as $id => $curso) {
        // Solo actualizar si no hay datos o si están vacíos
        $current_name = get_option("course_{$id}_name");
        if (!$current_name || empty(trim($current_name))) {
            update_option("course_{$id}_name", $curso['name']);
            update_option("course_{$id}_date", $curso['date']);
            update_option("course_{$id}_modality", $curso['modality']);
            update_option("course_{$id}_duration", $curso['duration']);
            update_option("course_{$id}_description", $curso['description']);
            update_option("course_{$id}_image", $curso['image']);
            $updated++;
            echo "<p>✅ Curso $id actualizado con datos únicos</p>";
        } else {
            echo "<p>ℹ️ Curso $id ya tiene datos personalizados (no modificado)</p>";
        }
    }
    
    if ($updated > 0) {
        echo "<p style='color: green; font-weight: bold;'>✅ Se actualizaron $updated cursos con datos únicos</p>";
    }
    
    // Solución 2: Verificar y recrear el archivo curso.php si es necesario
    $curso_php_content = '<?php
/**
 * Página individual de curso
 * URL: /curso/?curso=1
 */

// Cargar WordPress
require_once(\'wp-config.php\');
require_once(\'wp-load.php\');

// Verificar que el template existe
$template_path = \'wp-content/themes/mongruas-theme/page-templates/single-course.php\';

if (file_exists($template_path)) {
    // Incluir el template
    include $template_path;
} else {
    // Mostrar error si el template no existe
    echo "<h1>Error: Template no encontrado</h1>";
    echo "<p>El archivo $template_path no existe.</p>";
    echo "<a href=\'" . home_url(\'/anuncios\') . "\'>Volver a cursos</a>";
}
?>';
    
    if (file_put_contents('curso.php', $curso_php_content)) {
        echo "<p>✅ Archivo curso.php verificado/recreado</p>";
    } else {
        echo "<p>❌ Error al verificar curso.php</p>";
    }
    
    // Solución 3: Limpiar caché si existe
    if (function_exists('wp_cache_flush')) {
        wp_cache_flush();
        echo "<p>✅ Caché de WordPress limpiada</p>";
    }
    
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>🎉 ¡Soluciones aplicadas!</h3>";
    echo "<p>Las páginas individuales de cursos deberían funcionar correctamente ahora.</p>";
    echo "</div>";
    
    echo "</div>";
}

// Mostrar estado actual
echo "<div style='background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📊 Estado Actual del Sistema</h2>";

$problemas = [];
$todo_ok = true;

// Verificar datos de cursos
for ($i = 1; $i <= 3; $i++) {
    $name = get_option("course_{$i}_name");
    $date = get_option("course_{$i}_date");
    $description = get_option("course_{$i}_description");
    
    if (!$name || !$date || !$description) {
        $problemas[] = "Curso $i tiene datos incompletos";
        $todo_ok = false;
    }
}

// Verificar archivos
if (!file_exists('curso.php')) {
    $problemas[] = "Archivo curso.php no existe";
    $todo_ok = false;
}

if (!file_exists('wp-content/themes/mongruas-theme/page-templates/single-course.php')) {
    $problemas[] = "Template single-course.php no existe";
    $todo_ok = false;
}

// Verificar que los cursos tengan nombres diferentes
$nombres = [];
for ($i = 1; $i <= 3; $i++) {
    $name = get_option("course_{$i}_name");
    if ($name) {
        if (in_array($name, $nombres)) {
            $problemas[] = "Hay cursos con el mismo nombre";
            $todo_ok = false;
        }
        $nombres[] = $name;
    }
}

if ($todo_ok) {
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px;'>";
    echo "✅ <strong>Todo parece estar funcionando correctamente</strong>";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
    echo "❌ <strong>Se encontraron los siguientes problemas:</strong>";
    echo "<ul>";
    foreach ($problemas as $problema) {
        echo "<li>$problema</li>";
    }
    echo "</ul>";
    echo "</div>";
}

echo "</div>";

// Mostrar vista previa de cada curso
echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>👀 Vista Previa de Cursos Individuales</h2>";

for ($i = 1; $i <= 3; $i++) {
    $course_name = get_option("course_{$i}_name");
    $course_date = get_option("course_{$i}_date");
    $course_modality = get_option("course_{$i}_modality");
    $course_duration = get_option("course_{$i}_duration");
    $course_description = get_option("course_{$i}_description");
    
    // Usar valores por defecto si no hay datos
    if (!$course_name) {
        $defaults = [
            1 => ['name' => 'Instalaciones Eléctricas', 'date' => 'Enero 2025'],
            2 => ['name' => 'Sistemas Domóticos', 'date' => 'Febrero 2025'],
            3 => ['name' => 'Control de Plagas', 'date' => 'Marzo 2025']
        ];
        $course_name = $defaults[$i]['name'];
        $course_date = $defaults[$i]['date'];
    }
    
    echo "<div style='background: white; padding: 20px; margin: 15px 0; border-radius: 8px; border-left: 4px solid #0066cc;'>";
    echo "<h3>📚 Curso $i</h3>";
    echo "<p><strong>Nombre:</strong> " . esc_html($course_name) . "</p>";
    echo "<p><strong>Fecha:</strong> " . esc_html($course_date) . "</p>";
    if ($course_description) {
        echo "<p><strong>Descripción:</strong> " . esc_html(substr($course_description, 0, 100)) . "...</p>";
    }
    
    $url = home_url("/curso/?curso=$i");
    echo "<p><strong>URL:</strong> <a href='$url' target='_blank'>$url</a></p>";
    echo "<a href='$url' target='_blank' style='background: #0066cc; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;'>🔗 Probar Página</a>";
    echo "</div>";
}

echo "</div>";

// Formulario para aplicar soluciones
if (!$todo_ok) {
    echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h2>🔧 Aplicar Soluciones Automáticas</h2>";
    echo "<p>Haz clic en el botón para aplicar las siguientes soluciones:</p>";
    echo "<ul>";
    echo "<li>✅ Asegurar que cada curso tenga datos únicos y completos</li>";
    echo "<li>✅ Verificar/recrear archivo curso.php</li>";
    echo "<li>✅ Limpiar caché del sistema</li>";
    echo "</ul>";
    
    echo "<form method='post'>";
    echo "<button type='submit' name='aplicar_solucion' style='background: #28a745; color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer;'>🔧 Aplicar Soluciones</button>";
    echo "</form>";
    echo "</div>";
}

// Enlaces útiles
echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . home_url('/diagnostico-curso-individual.php') . "' style='background: #17a2b8; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>🔍 Diagnóstico Completo</a>";
echo "<a href='" . home_url('/gestionar-proximos-cursos.php') . "' style='background: #0066cc; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>📝 Gestionar Cursos</a>";
echo "<a href='" . home_url('/anuncios') . "' style='background: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>👀 Ver Página de Cursos</a>";
echo "</div>";

echo "<div style='background: #d1ecf1; color: #0c5460; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>💡 Consejos para evitar problemas:</h3>";
echo "<p>1. <strong>Asegúrate de que cada curso tenga un nombre diferente</strong></p>";
echo "<p>2. <strong>Completa todos los campos</strong> en el gestor de cursos</p>";
echo "<p>3. <strong>Prueba las páginas individuales</strong> después de hacer cambios</p>";
echo "<p>4. <strong>Si usas caché, límpialo</strong> después de hacer modificaciones</p>";
echo "</div>";
?>
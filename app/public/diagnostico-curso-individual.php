<?php
/**
 * Diagnóstico de Páginas Individuales de Cursos
 * Verifica que las páginas individuales muestren información diferente
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🔍 Diagnóstico de Páginas Individuales de Cursos</h1>";

echo "<div style='background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📋 Verificando datos de cursos...</h2>";

// Verificar datos de cada curso
for ($i = 1; $i <= 3; $i++) {
    $course_name = get_option("course_{$i}_name");
    $course_date = get_option("course_{$i}_date");
    $course_modality = get_option("course_{$i}_modality");
    $course_duration = get_option("course_{$i}_duration");
    $course_description = get_option("course_{$i}_description");
    $course_image = get_option("course_{$i}_image");
    
    echo "<div style='background: white; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #0066cc;'>";
    echo "<h3>📚 Curso $i</h3>";
    echo "<p><strong>Nombre:</strong> " . ($course_name ? esc_html($course_name) : '<span style="color: red;">No definido</span>') . "</p>";
    echo "<p><strong>Fecha:</strong> " . ($course_date ? esc_html($course_date) : '<span style="color: red;">No definida</span>') . "</p>";
    echo "<p><strong>Modalidad:</strong> " . ($course_modality ? esc_html($course_modality) : '<span style="color: red;">No definida</span>') . "</p>";
    echo "<p><strong>Duración:</strong> " . ($course_duration ? esc_html($course_duration) : '<span style="color: red;">No definida</span>') . "</p>";
    echo "<p><strong>Descripción:</strong> " . ($course_description ? esc_html(substr($course_description, 0, 100)) . '...' : '<span style="color: red;">No definida</span>') . "</p>";
    echo "<p><strong>Imagen:</strong> " . ($course_image ? '<span style="color: green;">✅ Definida</span>' : '<span style="color: orange;">⚠️ No definida</span>') . "</p>";
    
    // Enlaces de prueba
    echo "<p><strong>Enlaces:</strong></p>";
    echo "<a href='" . home_url("/curso/?curso=$i") . "' target='_blank' style='background: #0066cc; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; margin: 5px;'>Ver Página Individual</a>";
    echo "</div>";
}

echo "</div>";

// Verificar que el archivo curso.php existe y funciona
echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🔧 Verificando archivos del sistema...</h2>";

$files_to_check = [
    'curso.php' => 'Archivo de enrutamiento principal',
    'wp-content/themes/mongruas-theme/page-templates/single-course.php' => 'Template de página individual'
];

foreach ($files_to_check as $file => $description) {
    $exists = file_exists($file);
    echo "<div style='padding: 10px; margin: 5px 0; background: " . ($exists ? '#d4edda' : '#f8d7da') . "; border-radius: 4px;'>";
    echo ($exists ? '✅' : '❌') . " <strong>$file</strong> - $description";
    if ($exists) {
        echo " <span style='color: green;'>(Existe)</span>";
    } else {
        echo " <span style='color: red;'>(No encontrado)</span>";
    }
    echo "</div>";
}

echo "</div>";

// Probar la funcionalidad de cada curso
echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🧪 Prueba de Funcionalidad</h2>";

echo "<p>Simulando carga de páginas individuales:</p>";

for ($i = 1; $i <= 3; $i++) {
    echo "<div style='background: white; padding: 15px; margin: 10px 0; border-radius: 5px; border: 1px solid #ddd;'>";
    echo "<h3>🔗 Curso $i - URL: /curso/?curso=$i</h3>";
    
    // Simular la lógica del template
    $course_id = $i;
    
    // Obtener datos del curso
    $course_name = get_option("course_{$course_id}_name");
    $course_date = get_option("course_{$course_id}_date");
    $course_modality = get_option("course_{$course_id}_modality");
    $course_duration = get_option("course_{$course_id}_duration");
    $course_description = get_option("course_{$course_id}_description");
    $course_image = get_option("course_{$course_id}_image");
    
    // Si no hay datos, usar valores por defecto
    if (!$course_name) {
        $defaults = [
            1 => [
                'name' => 'Montaje y Mantenimiento de Instalaciones Eléctricas',
                'date' => 'Enero 2025',
                'modality' => 'Presencial',
                'duration' => '15 plazas',
                'description' => 'Curso completo de instalaciones eléctricas de baja tensión con certificado oficial.',
                'image' => ''
            ],
            2 => [
                'name' => 'Sistemas Domóticos e Inmóticos',
                'date' => 'Febrero 2025',
                'modality' => 'Presencial',
                'duration' => '12 plazas',
                'description' => 'Especialización en automatización de edificios y sistemas inteligentes.',
                'image' => ''
            ],
            3 => [
                'name' => 'Control de Plagas',
                'date' => 'Marzo 2025',
                'modality' => 'Presencial',
                'duration' => '10 plazas',
                'description' => 'Formación profesional en control y prevención de plagas urbanas.',
                'image' => ''
            ]
        ];
        
        $default = $defaults[$course_id];
        $course_name = $default['name'];
        $course_date = $default['date'];
        $course_modality = $default['modality'];
        $course_duration = $default['duration'];
        $course_description = $default['description'];
        $course_image = $default['image'];
    }
    
    echo "<div style='background: #f8f9fa; padding: 10px; border-radius: 4px; margin: 10px 0;'>";
    echo "<p><strong>Título que se mostraría:</strong> " . esc_html($course_name) . "</p>";
    echo "<p><strong>Fecha que se mostraría:</strong> " . esc_html($course_date) . "</p>";
    echo "<p><strong>Modalidad que se mostraría:</strong> " . esc_html($course_modality) . "</p>";
    echo "<p><strong>Duración que se mostraría:</strong> " . esc_html($course_duration) . "</p>";
    echo "<p><strong>Descripción que se mostraría:</strong> " . esc_html($course_description) . "</p>";
    echo "</div>";
    
    // Verificar si los datos son únicos
    $is_unique = true;
    for ($j = 1; $j <= 3; $j++) {
        if ($j != $i) {
            $other_name = get_option("course_{$j}_name");
            if (!$other_name) {
                $other_defaults = [
                    1 => 'Montaje y Mantenimiento de Instalaciones Eléctricas',
                    2 => 'Sistemas Domóticos e Inmóticos',
                    3 => 'Control de Plagas'
                ];
                $other_name = $other_defaults[$j];
            }
            
            if ($course_name === $other_name) {
                $is_unique = false;
                break;
            }
        }
    }
    
    if ($is_unique) {
        echo "<p style='color: green;'>✅ <strong>Los datos son únicos para este curso</strong></p>";
    } else {
        echo "<p style='color: red;'>❌ <strong>PROBLEMA: Los datos son iguales a otro curso</strong></p>";
    }
    
    echo "</div>";
}

echo "</div>";

// Verificar URLs y enlaces
echo "<div style='background: #d1ecf1; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🌐 Verificación de URLs</h2>";

echo "<p>URLs que deberían funcionar:</p>";
for ($i = 1; $i <= 3; $i++) {
    $url = home_url("/curso/?curso=$i");
    echo "<div style='padding: 8px; margin: 5px 0; background: white; border-radius: 4px;'>";
    echo "<strong>Curso $i:</strong> <a href='$url' target='_blank'>$url</a>";
    echo " <a href='$url' target='_blank' style='background: #28a745; color: white; padding: 4px 8px; text-decoration: none; border-radius: 3px; margin-left: 10px; font-size: 12px;'>Probar</a>";
    echo "</div>";
}

echo "</div>";

// Botones de acción
echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . home_url('/gestionar-proximos-cursos.php') . "' style='background: #0066cc; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>📝 Gestionar Cursos</a>";
echo "<a href='" . home_url('/anuncios') . "' style='background: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>👀 Ver Página de Cursos</a>";
echo "<a href='" . home_url('/curso/?curso=1') . "' style='background: #6f42c1; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>🔗 Probar Curso 1</a>";
echo "<a href='" . home_url('/curso/?curso=2') . "' style='background: #6f42c1; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>🔗 Probar Curso 2</a>";
echo "<a href='" . home_url('/curso/?curso=3') . "' style='background: #6f42c1; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>🔗 Probar Curso 3</a>";
echo "</div>";

echo "<div style='background: #f8d7da; color: #721c24; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>🚨 Si ves el mismo contenido en todas las páginas:</h3>";
echo "<p>1. <strong>Verifica que los datos de cada curso sean diferentes</strong> en el gestor</p>";
echo "<p>2. <strong>Asegúrate de que el parámetro ?curso=X</strong> se esté pasando correctamente</p>";
echo "<p>3. <strong>Revisa que el template</strong> esté leyendo el parámetro correctamente</p>";
echo "<p>4. <strong>Limpia la caché</strong> si tienes algún plugin de caché activo</p>";
echo "</div>";
?>
<?php
/**
 * Test para verificar que los cursos muestran contenido diferente
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🧪 Test: ¿Los Cursos Muestran Contenido Diferente?</h1>";

echo "<div style='background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🔍 Simulando carga de cada página individual...</h2>";

// Simular la carga de cada curso como lo haría el template
for ($test_curso = 1; $test_curso <= 3; $test_curso++) {
    echo "<div style='background: white; padding: 20px; margin: 15px 0; border-radius: 8px; border-left: 4px solid #0066cc;'>";
    echo "<h3>📚 Simulando: /curso/?curso=$test_curso</h3>";
    
    // Simular exactamente lo que hace single-course.php
    $course_id = $test_curso; // Simular $_GET['curso']
    
    // Validar que el curso existe (como en el template)
    if ($course_id < 1 || $course_id > 3) {
        $course_id = 1;
    }
    
    // Obtener datos del curso (como en el template)
    $course_name = get_option("course_{$course_id}_name");
    $course_date = get_option("course_{$course_id}_date");
    $course_modality = get_option("course_{$course_id}_modality");
    $course_duration = get_option("course_{$course_id}_duration");
    $course_description = get_option("course_{$course_id}_description");
    $course_image = get_option("course_{$course_id}_image");
    
    echo "<p><strong>🔢 ID procesado:</strong> $course_id</p>";
    
    // Si no hay datos, usar valores por defecto (como en el template)
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
        
        echo "<p style='color: orange;'>⚠️ Usando datos por defecto (no hay datos personalizados)</p>";
    } else {
        echo "<p style='color: green;'>✅ Usando datos personalizados</p>";
    }
    
    // Mostrar qué se vería en la página
    echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h4>📋 Contenido que se mostraría:</h4>";
    echo "<p><strong>Título:</strong> " . esc_html($course_name) . "</p>";
    echo "<p><strong>Fecha:</strong> " . esc_html($course_date) . "</p>";
    echo "<p><strong>Modalidad:</strong> " . esc_html($course_modality) . "</p>";
    echo "<p><strong>Duración:</strong> " . esc_html($course_duration) . "</p>";
    echo "<p><strong>Descripción:</strong> " . esc_html($course_description) . "</p>";
    echo "</div>";
    
    // Enlace para probar realmente
    $url = home_url("/curso/?curso=$test_curso");
    echo "<a href='$url' target='_blank' style='background: #0066cc; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;'>🔗 Probar en Navegador</a>";
    
    echo "</div>";
}

echo "</div>";

// Verificar si los datos son realmente diferentes
echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🔍 Análisis de Diferencias</h2>";

$nombres = [];
$fechas = [];
$descripciones = [];

for ($i = 1; $i <= 3; $i++) {
    $name = get_option("course_{$i}_name");
    $date = get_option("course_{$i}_date");
    $desc = get_option("course_{$i}_description");
    
    // Si no hay datos, usar defaults
    if (!$name) {
        $defaults = [
            1 => ['name' => 'Montaje y Mantenimiento de Instalaciones Eléctricas', 'date' => 'Enero 2025', 'desc' => 'Curso completo de instalaciones eléctricas de baja tensión con certificado oficial.'],
            2 => ['name' => 'Sistemas Domóticos e Inmóticos', 'date' => 'Febrero 2025', 'desc' => 'Especialización en automatización de edificios y sistemas inteligentes.'],
            3 => ['name' => 'Control de Plagas', 'date' => 'Marzo 2025', 'desc' => 'Formación profesional en control y prevención de plagas urbanas.']
        ];
        $name = $defaults[$i]['name'];
        $date = $defaults[$i]['date'];
        $desc = $defaults[$i]['desc'];
    }
    
    $nombres[] = $name;
    $fechas[] = $date;
    $descripciones[] = $desc;
}

// Verificar unicidad
$nombres_unicos = array_unique($nombres);
$fechas_unicas = array_unique($fechas);
$desc_unicas = array_unique($descripciones);

echo "<div style='background: white; padding: 15px; border-radius: 5px;'>";
echo "<h3>📊 Resultados del Análisis:</h3>";

if (count($nombres_unicos) == 3) {
    echo "<p style='color: green;'>✅ <strong>Los nombres de los cursos son diferentes</strong></p>";
} else {
    echo "<p style='color: red;'>❌ <strong>PROBLEMA: Hay nombres de cursos duplicados</strong></p>";
}

if (count($fechas_unicas) == 3) {
    echo "<p style='color: green;'>✅ <strong>Las fechas de los cursos son diferentes</strong></p>";
} else {
    echo "<p style='color: red;'>❌ <strong>PROBLEMA: Hay fechas de cursos duplicadas</strong></p>";
}

if (count($desc_unicas) == 3) {
    echo "<p style='color: green;'>✅ <strong>Las descripciones de los cursos son diferentes</strong></p>";
} else {
    echo "<p style='color: red;'>❌ <strong>PROBLEMA: Hay descripciones de cursos duplicadas</strong></p>";
}

echo "</div>";

echo "</div>";

// Mostrar comparación lado a lado
echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📊 Comparación Lado a Lado</h2>";

echo "<div style='display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;'>";

for ($i = 1; $i <= 3; $i++) {
    $name = get_option("course_{$i}_name");
    $date = get_option("course_{$i}_date");
    $desc = get_option("course_{$i}_description");
    
    if (!$name) {
        $defaults = [
            1 => ['name' => 'Instalaciones Eléctricas', 'date' => 'Enero 2025', 'desc' => 'Curso de instalaciones eléctricas'],
            2 => ['name' => 'Sistemas Domóticos', 'date' => 'Febrero 2025', 'desc' => 'Curso de domótica'],
            3 => ['name' => 'Control de Plagas', 'date' => 'Marzo 2025', 'desc' => 'Curso de control de plagas']
        ];
        $name = $defaults[$i]['name'];
        $date = $defaults[$i]['date'];
        $desc = $defaults[$i]['desc'];
    }
    
    echo "<div style='background: white; padding: 15px; border-radius: 8px; border: 2px solid #e0e0e0;'>";
    echo "<h4 style='color: #0066cc; margin-top: 0;'>Curso $i</h4>";
    echo "<p><strong>Nombre:</strong><br>" . esc_html($name) . "</p>";
    echo "<p><strong>Fecha:</strong><br>" . esc_html($date) . "</p>";
    echo "<p><strong>Descripción:</strong><br>" . esc_html(substr($desc, 0, 80)) . "...</p>";
    
    $url = home_url("/curso/?curso=$i");
    echo "<a href='$url' target='_blank' style='background: #0066cc; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 12px;'>Ver Página</a>";
    echo "</div>";
}

echo "</div>";
echo "</div>";

// Instrucciones finales
echo "<div style='background: #d1ecf1; color: #0c5460; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>🎯 ¿Qué hacer si ves el mismo contenido?</h3>";
echo "<p><strong>1. Verifica los datos:</strong> Asegúrate de que cada curso tenga información diferente</p>";
echo "<p><strong>2. Limpia la caché:</strong> Si tienes plugins de caché, límpiala</p>";
echo "<p><strong>3. Prueba en navegador privado:</strong> Para evitar caché del navegador</p>";
echo "<p><strong>4. Revisa la URL:</strong> Asegúrate de que el parámetro ?curso=X esté presente</p>";
echo "</div>";

// Enlaces útiles
echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . home_url('/arreglar-cursos-individuales.php') . "' style='background: #dc3545; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>🔧 Arreglar Problemas</a>";
echo "<a href='" . home_url('/gestionar-proximos-cursos.php') . "' style='background: #0066cc; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>📝 Gestionar Cursos</a>";
echo "<a href='" . home_url('/anuncios') . "' style='background: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>👀 Ver Página de Cursos</a>";
echo "</div>";
?>
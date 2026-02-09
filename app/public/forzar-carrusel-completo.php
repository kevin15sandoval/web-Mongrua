<?php
/**
 * Forzar Carrusel Completo - Solución Definitiva
 * Asegurar que el carrusel funcione correctamente en /anuncios
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🎠 Forzar Carrusel Completo - Solución Definitiva</h1>";

// Paso 1: Asegurar que tenemos 4+ cursos
echo "<div style='background: #e3f2fd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📚 Paso 1: Configurar Cursos (Mínimo 4 para Carrusel)</h2>";

// Cursos completos para asegurar el carrusel
$cursos_completos = [
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
    ],
    4 => [
        'name' => 'Prevención de Riesgos Laborales',
        'date' => 'Abril 2025',
        'modality' => 'Online',
        'duration' => '20 plazas',
        'description' => 'Curso básico de 60 horas en prevención de riesgos laborales.',
        'image' => ''
    ],
    5 => [
        'name' => 'Soldadura con Electrodo Revestido',
        'date' => 'Mayo 2025',
        'modality' => 'Presencial',
        'duration' => '8 plazas',
        'description' => 'Formación práctica en técnicas de soldadura profesional.',
        'image' => ''
    ]
];

// Guardar todos los cursos
foreach ($cursos_completos as $i => $curso) {
    update_option("course_{$i}_name", $curso['name']);
    update_option("course_{$i}_date", $curso['date']);
    update_option("course_{$i}_modality", $curso['modality']);
    update_option("course_{$i}_duration", $curso['duration']);
    update_option("course_{$i}_description", $curso['description']);
    update_option("course_{$i}_image", $curso['image']);
    
    echo "<p style='color: #28a745;'>✅ Curso $i: {$curso['name']}</p>";
}

echo "<p style='color: #28a745; font-size: 18px;'><strong>✅ 5 cursos configurados - CARRUSEL ACTIVADO</strong></p>";
echo "</div>";

// Paso 2: Configurar página /anuncios
echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📄 Paso 2: Configurar Página /anuncios</h2>";

$page = get_page_by_path('anuncios');
if (!$page) {
    // Crear página si no existe
    $page_data = array(
        'post_title' => 'Catálogo de Cursos',
        'post_content' => '',
        'post_status' => 'publish',
        'post_type' => 'page',
        'post_name' => 'anuncios'
    );
    
    $page_id = wp_insert_post($page_data);
    echo "<p style='color: #28a745;'>✅ Página /anuncios creada</p>";
} else {
    $page_id = $page->ID;
    echo "<p style='color: #28a745;'>✅ Página /anuncios encontrada</p>";
}

// Asignar template correcto
update_post_meta($page_id, '_wp_page_template', 'page-templates/page-cursos.php');
echo "<p style='color: #28a745;'>✅ Template 'page-cursos.php' asignado</p>";

echo "</div>";

// Paso 3: Verificar y mostrar el código del carrusel
echo "<div style='background: #f8d7da; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🔍 Paso 3: Verificar Código del Carrusel</h2>";

$template_path = get_template_directory() . '/page-templates/page-cursos.php';
if (file_exists($template_path)) {
    $content = file_get_contents($template_path);
    
    // Verificar elementos clave del carrusel
    $elementos_carrusel = [
        'count($courses) <= 3' => 'Lógica de detección',
        'courses-carousel-container' => 'Contenedor del carrusel',
        'courses-carousel-track' => 'Track del carrusel',
        'carousel-controls' => 'Controles de navegación',
        'nextCourse()' => 'Función JavaScript nextCourse',
        'prevCourse()' => 'Función JavaScript prevCourse',
        'updateCarouselPosition()' => 'Función de actualización'
    ];
    
    $todo_ok = true;
    foreach ($elementos_carrusel as $elemento => $descripcion) {
        if (strpos($content, $elemento) !== false) {
            echo "<p style='color: #28a745;'>✅ $descripcion</p>";
        } else {
            echo "<p style='color: #dc3545;'>❌ Falta: $descripcion</p>";
            $todo_ok = false;
        }
    }
    
    if ($todo_ok) {
        echo "<p style='color: #28a745; font-size: 18px;'><strong>✅ TODO EL CÓDIGO DEL CARRUSEL ESTÁ PRESENTE</strong></p>";
    }
    
} else {
    echo "<p style='color: #dc3545;'>❌ Template page-cursos.php no encontrado</p>";
}

echo "</div>";

// Paso 4: Limpiar todos los caches
echo "<div style='background: #d1ecf1; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🧹 Paso 4: Limpiar Todos los Caches</h2>";

// WordPress cache
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
    echo "<p style='color: #28a745;'>✅ Cache de WordPress limpiado</p>";
}

// Transients
delete_transient('mongruas_courses_cache');
delete_transient('courses_carousel_cache');
echo "<p style='color: #28a745;'>✅ Transients limpiados</p>";

// Opciones de cache comunes
if (function_exists('w3tc_flush_all')) {
    w3tc_flush_all();
    echo "<p style='color: #28a745;'>✅ W3 Total Cache limpiado</p>";
}

if (function_exists('wp_cache_clear_cache')) {
    wp_cache_clear_cache();
    echo "<p style='color: #28a745;'>✅ WP Super Cache limpiado</p>";
}

echo "</div>";

// Paso 5: Mostrar código de prueba
echo "<div style='background: #d4edda; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🧪 Paso 5: Prueba de Lógica</h2>";

// Simular la lógica del template
$courses_test = array();
for ($i = 1; $i <= 6; $i++) {
    $course_name = get_option("course_{$i}_name");
    if (!empty($course_name)) {
        $courses_test[] = array(
            'name' => $course_name,
            'date' => get_option("course_{$i}_date"),
            'modality' => get_option("course_{$i}_modality"),
            'duration' => get_option("course_{$i}_duration"),
            'description' => get_option("course_{$i}_description"),
            'image' => get_option("course_{$i}_image")
        );
    }
}

echo "<p><strong>Cursos encontrados:</strong> " . count($courses_test) . "</p>";

if (count($courses_test) <= 3) {
    echo "<p style='color: #dc3545; font-size: 18px;'><strong>❌ MOSTRARÁ GRID (≤3 cursos)</strong></p>";
} else {
    echo "<p style='color: #28a745; font-size: 18px;'><strong>✅ MOSTRARÁ CARRUSEL (>3 cursos)</strong></p>";
}

echo "<h3>📋 Lista de Cursos Activos:</h3>";
foreach ($courses_test as $index => $course) {
    echo "<div style='background: white; padding: 10px; margin: 5px 0; border-radius: 5px; border-left: 4px solid #0066cc;'>";
    echo "<strong>" . ($index + 1) . ".</strong> {$course['name']} - {$course['date']}";
    echo "</div>";
}

echo "</div>";

// Botones finales
echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . home_url('/anuncios') . "' style='background: linear-gradient(135deg, #0066cc, #0052a3); color: white; padding: 20px 40px; text-decoration: none; border-radius: 12px; margin: 10px; font-weight: 700; font-size: 18px; display: inline-block; box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3);'>🎠 VER CARRUSEL EN /anuncios</a><br>";
echo "<a href='" . home_url('/gestionar-proximos-cursos.php') . "' style='background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 5px; font-weight: 600;'>⚙️ Gestionar Cursos</a>";
echo "</div>";

echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>🎯 Resultado Esperado:</h3>";
echo "<p>Al hacer clic en 'VER CARRUSEL EN /anuncios' deberías ver:</p>";
echo "<ul>";
echo "<li>✅ Sección 'Próximos Cursos' con 5 cursos</li>";
echo "<li>✅ Carrusel con flechas de navegación (← →)</li>";
echo "<li>✅ Indicadores de puntos debajo del carrusel</li>";
echo "<li>✅ Navegación suave entre cursos</li>";
echo "<li>✅ Auto-play cada 5 segundos</li>";
echo "</ul>";
echo "<p><strong>💡 Si no ves el carrusel:</strong> Presiona Ctrl+F5 para recargar completamente la página.</p>";
echo "</div>";
?>
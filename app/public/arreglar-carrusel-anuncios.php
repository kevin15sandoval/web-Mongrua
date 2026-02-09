<?php
/**
 * Arreglar el Carrusel en la Página /anuncios
 * Asegurar que use el template correcto y tenga más de 3 cursos
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🔧 Arreglando el Carrusel en /anuncios</h1>";

// Paso 1: Verificar y configurar la página /anuncios
echo "<div style='background: #e3f2fd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📄 Paso 1: Configurar Página /anuncios</h2>";

$page = get_page_by_path('anuncios');
if ($page) {
    echo "<p>✅ Página /anuncios encontrada: {$page->post_title}</p>";
    
    // Verificar y cambiar el template si es necesario
    $current_template = get_page_template_slug($page->ID);
    echo "<p><strong>Template actual:</strong> " . ($current_template ? $current_template : 'default') . "</p>";
    
    if ($current_template !== 'page-templates/page-cursos.php') {
        // Cambiar al template correcto
        update_post_meta($page->ID, '_wp_page_template', 'page-templates/page-cursos.php');
        echo "<p style='color: #28a745;'><strong>✅ Template cambiado a 'page-templates/page-cursos.php'</strong></p>";
    } else {
        echo "<p style='color: #28a745;'><strong>✅ Ya está usando el template correcto</strong></p>";
    }
} else {
    echo "<p style='color: #dc3545;'>❌ Página /anuncios no encontrada. Creándola...</p>";
    
    // Crear la página /anuncios
    $page_data = array(
        'post_title' => 'Catálogo de Cursos',
        'post_content' => '',
        'post_status' => 'publish',
        'post_type' => 'page',
        'post_name' => 'anuncios'
    );
    
    $page_id = wp_insert_post($page_data);
    if ($page_id) {
        // Asignar el template
        update_post_meta($page_id, '_wp_page_template', 'page-templates/page-cursos.php');
        echo "<p style='color: #28a745;'><strong>✅ Página /anuncios creada con template correcto</strong></p>";
    }
}
echo "</div>";

// Paso 2: Asegurar que hay suficientes cursos para el carrusel
echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📚 Paso 2: Verificar Cursos para Carrusel</h2>";

$cursos_activos = 0;
for ($i = 1; $i <= 6; $i++) {
    $course_name = get_option("course_{$i}_name");
    if (!empty($course_name)) {
        $cursos_activos++;
    }
}

echo "<p><strong>Cursos activos actuales:</strong> $cursos_activos</p>";

if ($cursos_activos <= 3) {
    echo "<p style='color: #dc3545;'>❌ Necesitas más de 3 cursos para activar el carrusel</p>";
    echo "<p><strong>Agregando cursos adicionales...</strong></p>";
    
    // Cursos adicionales para completar hasta 4
    $cursos_adicionales = [
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
        ],
        6 => [
            'name' => 'Gestión de Residuos',
            'date' => 'Junio 2025',
            'modality' => 'Semipresencial',
            'duration' => '15 plazas',
            'description' => 'Especialización en gestión y tratamiento de residuos industriales.',
            'image' => ''
        ]
    ];
    
    $agregados = 0;
    for ($i = 4; $i <= 6; $i++) {
        $existing_name = get_option("course_{$i}_name");
        if (empty($existing_name)) {
            $curso = $cursos_adicionales[$i];
            update_option("course_{$i}_name", $curso['name']);
            update_option("course_{$i}_date", $curso['date']);
            update_option("course_{$i}_modality", $curso['modality']);
            update_option("course_{$i}_duration", $curso['duration']);
            update_option("course_{$i}_description", $curso['description']);
            update_option("course_{$i}_image", $curso['image']);
            
            echo "<p style='color: #28a745;'>✅ Curso $i agregado: {$curso['name']}</p>";
            $agregados++;
            $cursos_activos++;
            
            if ($cursos_activos > 3) break; // Ya tenemos suficientes para el carrusel
        }
    }
    
    if ($agregados > 0) {
        echo "<p style='color: #28a745;'><strong>✅ Se agregaron $agregados cursos. Total ahora: $cursos_activos</strong></p>";
    }
} else {
    echo "<p style='color: #28a745;'>✅ Ya tienes $cursos_activos cursos - El carrusel debería activarse</p>";
}
echo "</div>";

// Paso 3: Verificar que el template tiene el código correcto
echo "<div style='background: #f8d7da; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🔍 Paso 3: Verificar Template page-cursos.php</h2>";

$template_path = get_template_directory() . '/page-templates/page-cursos.php';
if (file_exists($template_path)) {
    $template_content = file_get_contents($template_path);
    
    // Verificaciones del código
    $checks = [
        'courses-carousel-container' => 'Contenedor del carrusel',
        'count($courses) <= 3' => 'Lógica de detección de carrusel',
        'courses-carousel-track' => 'Track del carrusel',
        'carousel-controls' => 'Controles del carrusel',
        'nextCourse()' => 'Función JavaScript nextCourse',
        'prevCourse()' => 'Función JavaScript prevCourse'
    ];
    
    $all_good = true;
    foreach ($checks as $code => $description) {
        if (strpos($template_content, $code) !== false) {
            echo "<p style='color: #28a745;'>✅ $description</p>";
        } else {
            echo "<p style='color: #dc3545;'>❌ Falta: $description</p>";
            $all_good = false;
        }
    }
    
    if ($all_good) {
        echo "<p style='color: #28a745;'><strong>✅ El template tiene todo el código necesario</strong></p>";
    } else {
        echo "<p style='color: #dc3545;'><strong>❌ El template necesita actualizarse</strong></p>";
    }
    
} else {
    echo "<p style='color: #dc3545;'>❌ Template page-cursos.php no encontrado</p>";
}
echo "</div>";

// Paso 4: Limpiar cache
echo "<div style='background: #d1ecf1; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🧹 Paso 4: Limpiar Cache</h2>";

// Limpiar cache de WordPress si hay plugins de cache
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
    echo "<p style='color: #28a745;'>✅ Cache de WordPress limpiado</p>";
}

// Limpiar opciones de cache
delete_transient('mongruas_courses_cache');
echo "<p style='color: #28a745;'>✅ Cache de cursos limpiado</p>";

echo "</div>";

// Resumen final
echo "<div style='background: #d4edda; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📋 Resumen de Cambios</h2>";

$final_count = 0;
for ($i = 1; $i <= 6; $i++) {
    if (!empty(get_option("course_{$i}_name"))) {
        $final_count++;
    }
}

echo "<p><strong>Total de cursos activos:</strong> $final_count</p>";

if ($final_count > 3) {
    echo "<p style='color: #28a745; font-size: 18px;'><strong>🎠 ¡CARRUSEL ACTIVADO!</strong></p>";
    echo "<p>La página /anuncios ahora debería mostrar el carrusel con navegación.</p>";
} else {
    echo "<p style='color: #dc3545;'>❌ Aún no hay suficientes cursos para el carrusel</p>";
}

echo "<h3>✅ Cambios realizados:</h3>";
echo "<ul>";
echo "<li>Página /anuncios configurada con template correcto</li>";
echo "<li>Cursos adicionales agregados si era necesario</li>";
echo "<li>Cache limpiado</li>";
echo "</ul>";

echo "</div>";

// Botones de prueba
echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . home_url('/anuncios') . "' style='background: #0066cc; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 5px; font-weight: 600; font-size: 16px;'>🎠 Ver Carrusel en /anuncios</a><br><br>";
echo "<a href='" . home_url('/gestionar-proximos-cursos.php') . "' style='background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 5px; font-weight: 600;'>⚙️ Gestionar Cursos</a>";
echo "</div>";

echo "<div style='background: #fff3cd; padding: 15px; border-radius: 8px; margin: 20px 0;'>";
echo "<p><strong>💡 Nota:</strong> Si el carrusel aún no aparece, presiona Ctrl+F5 para recargar completamente la página y limpiar el cache del navegador.</p>";
echo "</div>";
?>
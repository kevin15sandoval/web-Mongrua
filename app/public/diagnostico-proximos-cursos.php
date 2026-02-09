<?php
/**
 * Diagnóstico de Próximos Cursos
 * 
 * Este script verifica si los campos ACF están funcionando correctamente
 * y muestra los datos guardados para los próximos cursos.
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🔍 Diagnóstico de Próximos Cursos</h1>";

// 1. Verificar si ACF está activo
echo "<h2>1. Verificación de ACF</h2>";
if (function_exists('get_field')) {
    echo "✅ ACF está activo y funcionando<br>";
} else {
    echo "❌ ACF no está activo o no funciona<br>";
    echo "<strong>SOLUCIÓN:</strong> Activa el plugin Advanced Custom Fields<br>";
}

// 2. Buscar la página de cursos
echo "<h2>2. Verificación de la página de cursos</h2>";
$cursos_page = get_page_by_path('cursos');
if ($cursos_page) {
    echo "✅ Página 'Cursos' encontrada (ID: {$cursos_page->ID})<br>";
    
    // Verificar la plantilla
    $template = get_page_template_slug($cursos_page->ID);
    echo "📄 Plantilla actual: " . ($template ?: 'page.php (por defecto)') . "<br>";
    
    if ($template === 'page-templates/page-cursos.php') {
        echo "✅ Plantilla correcta asignada<br>";
    } else {
        echo "⚠️ Plantilla incorrecta. Debería ser 'page-templates/page-cursos.php'<br>";
        echo "<strong>SOLUCIÓN:</strong> Ve a Páginas > Cursos > Atributos de página > Plantilla > Página de Cursos<br>";
    }
} else {
    echo "❌ Página 'Cursos' no encontrada<br>";
    echo "<strong>SOLUCIÓN:</strong> Crea una página llamada 'Cursos' con slug 'cursos'<br>";
}

// 3. Verificar campos ACF
if (function_exists('get_field') && $cursos_page) {
    echo "<h2>3. Verificación de campos ACF</h2>";
    
    // Campos del curso 1
    $course_1_name = get_field('course_1_name', $cursos_page->ID);
    $course_1_description = get_field('course_1_description', $cursos_page->ID);
    $course_1_date = get_field('course_1_date', $cursos_page->ID);
    $course_1_duration = get_field('course_1_duration', $cursos_page->ID);
    $course_1_modality = get_field('course_1_modality', $cursos_page->ID);
    $course_1_category = get_field('course_1_category', $cursos_page->ID);
    $course_1_image = get_field('course_1_image', $cursos_page->ID);
    
    echo "<h3>📚 Curso 1:</h3>";
    echo "<ul>";
    echo "<li><strong>Nombre:</strong> " . ($course_1_name ?: '❌ Vacío') . "</li>";
    echo "<li><strong>Descripción:</strong> " . ($course_1_description ?: '❌ Vacío') . "</li>";
    echo "<li><strong>Fecha:</strong> " . ($course_1_date ?: '❌ Vacío') . "</li>";
    echo "<li><strong>Duración:</strong> " . ($course_1_duration ?: '❌ Vacío') . "</li>";
    echo "<li><strong>Modalidad:</strong> " . ($course_1_modality ?: '❌ Vacío') . "</li>";
    echo "<li><strong>Categoría:</strong> " . ($course_1_category ?: '❌ Vacío') . "</li>";
    echo "<li><strong>Imagen:</strong> " . ($course_1_image ? '✅ Subida' : '❌ No subida') . "</li>";
    echo "</ul>";
    
    if ($course_1_image) {
        echo "<p><strong>Detalles de la imagen:</strong></p>";
        echo "<pre>" . print_r($course_1_image, true) . "</pre>";
    }
    
    // Verificar si al menos el nombre está rellenado
    if ($course_1_name) {
        echo "✅ El curso 1 tiene nombre, debería mostrarse en el frontend<br>";
    } else {
        echo "❌ El curso 1 no tiene nombre, no se mostrará<br>";
        echo "<strong>SOLUCIÓN:</strong> Rellena al menos el campo 'Nombre del Curso 1'<br>";
    }
}

// 4. Verificar grupos de campos ACF
echo "<h2>4. Verificación de grupos de campos ACF</h2>";
if (function_exists('acf_get_field_groups')) {
    $field_groups = acf_get_field_groups();
    $proximos_cursos_group = null;
    
    foreach ($field_groups as $group) {
        if (strpos($group['title'], 'Próximos Cursos') !== false) {
            $proximos_cursos_group = $group;
            break;
        }
    }
    
    if ($proximos_cursos_group) {
        echo "✅ Grupo de campos 'Próximos Cursos' encontrado<br>";
        echo "📋 Key: " . $proximos_cursos_group['key'] . "<br>";
        
        // Verificar ubicación
        $locations = $proximos_cursos_group['location'];
        echo "📍 Ubicaciones configuradas:<br>";
        foreach ($locations as $location_group) {
            foreach ($location_group as $rule) {
                echo "- " . $rule['param'] . " " . $rule['operator'] . " " . $rule['value'] . "<br>";
            }
        }
    } else {
        echo "❌ Grupo de campos 'Próximos Cursos' no encontrado<br>";
        echo "<strong>SOLUCIÓN:</strong> Importa el archivo proximos-cursos-acf.json desde ACF > Herramientas<br>";
    }
} else {
    echo "❌ No se pueden verificar los grupos de campos (ACF no disponible)<br>";
}

// 5. Verificar archivos del tema
echo "<h2>5. Verificación de archivos del tema</h2>";

$template_file = get_template_directory() . '/page-templates/page-cursos.php';
if (file_exists($template_file)) {
    echo "✅ Archivo page-cursos.php existe<br>";
} else {
    echo "❌ Archivo page-cursos.php no existe<br>";
}

$css_file = get_template_directory() . '/assets/css/upcoming-courses.css';
if (file_exists($css_file)) {
    echo "✅ Archivo upcoming-courses.css existe<br>";
} else {
    echo "❌ Archivo upcoming-courses.css no existe<br>";
}

// 6. Mostrar URL de la página de cursos
if ($cursos_page) {
    $cursos_url = get_permalink($cursos_page->ID);
    echo "<h2>6. Enlaces útiles</h2>";
    echo "🔗 <a href='{$cursos_url}' target='_blank'>Ver página de cursos en el frontend</a><br>";
    echo "✏️ <a href='" . admin_url('post.php?post=' . $cursos_page->ID . '&action=edit') . "' target='_blank'>Editar página de cursos en admin</a><br>";
}

echo "<hr>";
echo "<p><strong>💡 Próximos pasos:</strong></p>";
echo "<ol>";
echo "<li>Revisa los puntos marcados con ❌ arriba</li>";
echo "<li>Si todo está ✅ pero no se muestra, limpia la caché del navegador</li>";
echo "<li>Si usas un plugin de caché, límpialo también</li>";
echo "<li>Verifica que has guardado la página después de rellenar los campos</li>";
echo "</ol>";

?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1 { color: #0073aa; }
h2 { color: #333; border-bottom: 1px solid #ccc; padding-bottom: 5px; }
h3 { color: #666; }
ul { background: #f9f9f9; padding: 10px; border-left: 4px solid #0073aa; }
pre { background: #f5f5f5; padding: 10px; overflow-x: auto; }
</style>
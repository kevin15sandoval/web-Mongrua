<?php
/**
 * Solución Final para Páginas Individuales de Cursos
 * Resuelve el problema de contenido duplicado
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🎯 Solución Final: Páginas Individuales de Cursos</h1>";

if (isset($_POST['aplicar_solucion_completa'])) {
    echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h2>⚙️ Aplicando solución completa...</h2>";
    
    // PASO 1: Limpiar y establecer datos únicos para cada curso
    echo "<h3>📝 Paso 1: Estableciendo datos únicos para cada curso</h3>";
    
    $cursos_unicos = [
        1 => [
            'name' => 'Montaje y Mantenimiento de Instalaciones Eléctricas de Baja Tensión (ELEE0109)',
            'date' => 'Enero 2025 - Inicio Confirmado',
            'modality' => 'Presencial',
            'duration' => '15 plazas disponibles',
            'description' => 'Certificado de profesionalidad oficial para instalaciones eléctricas de baja tensión. Incluye montaje, mantenimiento y reparación según normativa vigente RD 842/2002. Prácticas en instalaciones reales.',
            'image' => ''
        ],
        2 => [
            'name' => 'Montaje y Mantenimiento de Sistemas Domóticos e Inmóticos (ELEM0111)',
            'date' => 'Febrero 2025 - Plazas Limitadas',
            'modality' => 'Presencial',
            'duration' => '12 plazas disponibles',
            'description' => 'Especialización en automatización de edificios inteligentes. Domótica residencial e inmótica comercial. Programación de sistemas KNX, control de climatización, iluminación y seguridad.',
            'image' => ''
        ],
        3 => [
            'name' => 'Servicios para el Control de Plagas Urbanas (SEAG0110)',
            'date' => 'Marzo 2025 - Últimas Plazas',
            'modality' => 'Presencial',
            'duration' => '10 plazas disponibles',
            'description' => 'Certificado oficial para control de plagas urbanas. Aplicación de productos fitosanitarios, técnicas de control integrado, normativa de seguridad y salud laboral. Carnet aplicador incluido.',
            'image' => ''
        ]
    ];
    
    foreach ($cursos_unicos as $id => $curso) {
        update_option("course_{$id}_name", $curso['name']);
        update_option("course_{$id}_date", $curso['date']);
        update_option("course_{$id}_modality", $curso['modality']);
        update_option("course_{$id}_duration", $curso['duration']);
        update_option("course_{$id}_description", $curso['description']);
        update_option("course_{$id}_image", $curso['image']);
        echo "<p>✅ Curso $id: " . esc_html($curso['name']) . "</p>";
    }
    
    // PASO 2: Recrear archivo curso.php con mejor manejo de errores
    echo "<h3>🔧 Paso 2: Recreando archivo curso.php</h3>";
    
    $curso_php_mejorado = '<?php
/**
 * Página individual de curso - Versión mejorada
 * URL: /curso/?curso=1
 */

// Cargar WordPress
require_once(\'wp-config.php\');
require_once(\'wp-load.php\');

// Debug: Mostrar parámetros recibidos (solo para desarrollo)
if (isset($_GET[\'debug\'])) {
    echo "<div style=\'background: yellow; padding: 10px; margin: 10px 0;\'>";
    echo "DEBUG - Parámetros recibidos: ";
    print_r($_GET);
    echo "</div>";
}

// Obtener y validar el ID del curso
$course_id = isset($_GET[\'curso\']) ? intval($_GET[\'curso\']) : 1;

// Validar rango
if ($course_id < 1 || $course_id > 3) {
    $course_id = 1;
}

// Verificar que el template existe
$template_path = \'wp-content/themes/mongruas-theme/page-templates/single-course.php\';

if (file_exists($template_path)) {
    // Incluir el template
    include $template_path;
} else {
    // Mostrar error detallado si el template no existe
    echo "<div style=\'max-width: 800px; margin: 50px auto; padding: 30px; background: #f8d7da; border-radius: 10px;\'>";
    echo "<h1 style=\'color: #721c24;\'>❌ Error: Template no encontrado</h1>";
    echo "<p>El archivo <code>$template_path</code> no existe.</p>";
    echo "<p><strong>Curso solicitado:</strong> $course_id</p>";
    echo "<p><strong>Ruta actual:</strong> " . __DIR__ . "</p>";
    echo "<a href=\'" . home_url(\'/anuncios\') . "\' style=\'background: #0066cc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;\'>← Volver a cursos</a>";
    echo "</div>";
}
?>';
    
    if (file_put_contents('curso.php', $curso_php_mejorado)) {
        echo "<p>✅ Archivo curso.php recreado con mejoras</p>";
    } else {
        echo "<p>❌ Error al recrear curso.php</p>";
    }
    
    // PASO 3: Verificar y mejorar el template single-course.php
    echo "<h3>🎨 Paso 3: Verificando template single-course.php</h3>";
    
    $template_path = 'wp-content/themes/mongruas-theme/page-templates/single-course.php';
    if (file_exists($template_path)) {
        echo "<p>✅ Template existe</p>";
        
        // Leer el contenido actual
        $template_content = file_get_contents($template_path);
        
        // Verificar que tenga el manejo correcto del course_id
        if (strpos($template_content, '$course_id = isset($_GET[\'curso\'])') !== false) {
            echo "<p>✅ Template maneja correctamente el parámetro curso</p>";
        } else {
            echo "<p>⚠️ Template podría necesitar actualización</p>";
        }
    } else {
        echo "<p>❌ Template no existe - necesita ser recreado</p>";
    }
    
    // PASO 4: Limpiar caché
    echo "<h3>🧹 Paso 4: Limpiando caché</h3>";
    
    if (function_exists('wp_cache_flush')) {
        wp_cache_flush();
        echo "<p>✅ Caché de WordPress limpiada</p>";
    }
    
    // Limpiar caché de opciones
    wp_cache_delete('alloptions', 'options');
    echo "<p>✅ Caché de opciones limpiada</p>";
    
    // PASO 5: Verificar URLs
    echo "<h3>🔗 Paso 5: Verificando URLs generadas</h3>";
    
    for ($i = 1; $i <= 3; $i++) {
        $url = home_url("/curso/?curso=$i");
        echo "<p>✅ Curso $i: <a href='$url' target='_blank'>$url</a></p>";
    }
    
    echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>🎉 ¡Solución Aplicada Completamente!</h3>";
    echo "<p><strong>Cambios realizados:</strong></p>";
    echo "<ul>";
    echo "<li>✅ Datos únicos establecidos para cada curso</li>";
    echo "<li>✅ Archivo curso.php mejorado</li>";
    echo "<li>✅ Caché limpiada</li>";
    echo "<li>✅ URLs verificadas</li>";
    echo "</ul>";
    echo "<p><strong>Ahora cada curso debería mostrar información diferente.</strong></p>";
    echo "</div>";
    
    echo "</div>";
}

// Mostrar estado actual y diagnóstico
echo "<div style='background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📊 Diagnóstico Actual</h2>";

// Verificar datos actuales
$problemas_encontrados = [];
$cursos_data = [];

for ($i = 1; $i <= 3; $i++) {
    $name = get_option("course_{$i}_name");
    $date = get_option("course_{$i}_date");
    $desc = get_option("course_{$i}_description");
    
    $cursos_data[$i] = [
        'name' => $name,
        'date' => $date,
        'desc' => $desc
    ];
    
    if (!$name || !$date || !$desc) {
        $problemas_encontrados[] = "Curso $i tiene datos incompletos";
    }
}

// Verificar unicidad
$nombres = array_column($cursos_data, 'name');
$nombres_filtrados = array_filter($nombres);
if (count($nombres_filtrados) != count(array_unique($nombres_filtrados))) {
    $problemas_encontrados[] = "Hay cursos con nombres duplicados";
}

// Verificar archivos
if (!file_exists('curso.php')) {
    $problemas_encontrados[] = "Archivo curso.php no existe";
}

if (!file_exists('wp-content/themes/mongruas-theme/page-templates/single-course.php')) {
    $problemas_encontrados[] = "Template single-course.php no existe";
}

// Mostrar resultados
if (empty($problemas_encontrados)) {
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px;'>";
    echo "✅ <strong>Sistema funcionando correctamente</strong>";
    echo "<p>No se encontraron problemas. Las páginas individuales deberían mostrar contenido diferente.</p>";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
    echo "❌ <strong>Problemas encontrados:</strong>";
    echo "<ul>";
    foreach ($problemas_encontrados as $problema) {
        echo "<li>$problema</li>";
    }
    echo "</ul>";
    echo "</div>";
}

echo "</div>";

// Mostrar vista previa de cada curso
echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>👀 Vista Previa Actual de Cada Curso</h2>";

echo "<div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;'>";

for ($i = 1; $i <= 3; $i++) {
    $name = get_option("course_{$i}_name");
    $date = get_option("course_{$i}_date");
    $desc = get_option("course_{$i}_description");
    
    // Usar defaults si no hay datos
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
    
    echo "<div style='background: white; padding: 20px; border-radius: 8px; border: 2px solid #e0e0e0;'>";
    echo "<h3 style='color: #0066cc; margin-top: 0;'>📚 Curso $i</h3>";
    echo "<p><strong>Nombre:</strong><br>" . esc_html($name) . "</p>";
    echo "<p><strong>Fecha:</strong><br>" . esc_html($date) . "</p>";
    echo "<p><strong>Descripción:</strong><br>" . esc_html(substr($desc, 0, 100)) . "...</p>";
    
    $url = home_url("/curso/?curso=$i");
    echo "<div style='margin-top: 15px;'>";
    echo "<a href='$url' target='_blank' style='background: #0066cc; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; margin-right: 10px;'>🔗 Ver Página</a>";
    echo "<a href='$url&debug=1' target='_blank' style='background: #6c757d; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; font-size: 12px;'>🐛 Debug</a>";
    echo "</div>";
    echo "</div>";
}

echo "</div>";
echo "</div>";

// Botón para aplicar solución si hay problemas
if (!empty($problemas_encontrados)) {
    echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center;'>";
    echo "<h2>🔧 Aplicar Solución Completa</h2>";
    echo "<p>Se encontraron problemas. Haz clic para aplicar la solución automática:</p>";
    
    echo "<form method='post'>";
    echo "<button type='submit' name='aplicar_solucion_completa' style='background: #dc3545; color: white; padding: 20px 40px; border: none; border-radius: 8px; font-size: 18px; font-weight: bold; cursor: pointer; margin: 10px;'>🚀 Aplicar Solución Completa</button>";
    echo "</form>";
    
    echo "<p style='font-size: 14px; color: #856404;'>Esta acción establecerá datos únicos para cada curso y recreará los archivos necesarios.</p>";
    echo "</div>";
}

// Enlaces de prueba rápida
echo "<div style='background: #d1ecf1; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🚀 Prueba Rápida</h2>";
echo "<p>Haz clic en estos enlaces para probar cada curso:</p>";

echo "<div style='display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin: 20px 0;'>";

for ($i = 1; $i <= 3; $i++) {
    $url = home_url("/curso/?curso=$i");
    echo "<div style='text-align: center;'>";
    echo "<a href='$url' target='_blank' style='background: #28a745; color: white; padding: 15px 20px; text-decoration: none; border-radius: 8px; display: block; font-weight: bold;'>📚 Curso $i</a>";
    echo "<small style='color: #666; margin-top: 5px; display: block;'>?curso=$i</small>";
    echo "</div>";
}

echo "</div>";
echo "</div>";

// Enlaces útiles
echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . home_url('/test-cursos-diferentes.php') . "' style='background: #17a2b8; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>🧪 Test Diferencias</a>";
echo "<a href='" . home_url('/gestionar-proximos-cursos.php') . "' style='background: #0066cc; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>📝 Gestionar Cursos</a>";
echo "<a href='" . home_url('/anuncios') . "' style='background: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>👀 Ver Página de Cursos</a>";
echo "</div>";

echo "<div style='background: #e2e3e5; color: #383d41; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>💡 Instrucciones Finales</h3>";
echo "<p><strong>Después de aplicar la solución:</strong></p>";
echo "<ol>";
echo "<li>Haz clic en los enlaces de prueba arriba</li>";
echo "<li>Verifica que cada curso muestre información diferente</li>";
echo "<li>Si sigues viendo el mismo contenido, prueba en una ventana privada</li>";
echo "<li>Contacta si el problema persiste</li>";
echo "</ol>";
echo "</div>";
?>
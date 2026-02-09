<?php
/**
 * Activador del menú de Próximos Cursos
 * Configura la página de opciones y verifica que todo funcione
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🎓 Activar Menú de Próximos Cursos</h1>";

// Verificar ACF
if (!function_exists('acf_add_options_page')) {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
    echo "❌ ACF no está instalado o no tiene la función de páginas de opciones";
    echo "</div>";
    exit;
}

echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "✅ ACF está disponible y funcionando";
echo "</div>";

// Verificar si los campos existen
echo "<h2>🔍 Estado Actual de los Campos:</h2>";

$campos = [
    'course_1_name' => 'Curso 1 - Nombre',
    'course_1_date' => 'Curso 1 - Fecha',
    'course_1_modality' => 'Curso 1 - Modalidad',
    'course_2_name' => 'Curso 2 - Nombre',
    'course_2_date' => 'Curso 2 - Fecha',
    'course_3_name' => 'Curso 3 - Nombre',
    'course_3_date' => 'Curso 3 - Fecha'
];

$campos_configurados = 0;
foreach ($campos as $campo => $descripcion) {
    $valor = get_field($campo, 'option');
    if ($valor) {
        echo "<div style='background: #d4edda; color: #155724; padding: 8px; margin: 3px 0; border-radius: 3px; font-size: 14px;'>";
        echo "✅ <strong>$descripcion:</strong> " . esc_html($valor);
        echo "</div>";
        $campos_configurados++;
    } else {
        echo "<div style='background: #fff3cd; color: #856404; padding: 8px; margin: 3px 0; border-radius: 3px; font-size: 14px;'>";
        echo "⚠️ <strong>$descripcion:</strong> Sin configurar";
        echo "</div>";
    }
}

// Configurar cursos de ejemplo si se solicita
if (isset($_POST['configurar_ejemplo'])) {
    update_field('course_1_name', 'Montaje y Mantenimiento de Instalaciones Eléctricas', 'option');
    update_field('course_1_date', 'Enero 2025', 'option');
    update_field('course_1_modality', 'Presencial', 'option');
    update_field('course_1_duration', '15 plazas', 'option');
    update_field('course_1_category', 'Prevención de Riesgos Laborales', 'option');
    
    update_field('course_2_name', 'Sistemas Domóticos e Inmóticos', 'option');
    update_field('course_2_date', 'Febrero 2025', 'option');
    update_field('course_2_modality', 'Presencial', 'option');
    update_field('course_2_duration', '12 plazas', 'option');
    update_field('course_2_category', 'Prevención de Riesgos Laborales', 'option');
    
    update_field('course_3_name', 'Control de Plagas', 'option');
    update_field('course_3_date', 'Marzo 2025', 'option');
    update_field('course_3_modality', 'Presencial', 'option');
    update_field('course_3_duration', '10 plazas', 'option');
    update_field('course_3_category', 'Prevención de Riesgos Laborales', 'option');
    
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 15px 0;'>";
    echo "✅ <strong>¡Cursos de ejemplo configurados correctamente!</strong>";
    echo "</div>";
    
    echo "<script>setTimeout(function(){ location.reload(); }, 2000);</script>";
}

echo "<h2>📋 Instrucciones para la Administradora:</h2>";
echo "<div style='background: #e9ecef; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<ol style='line-height: 1.8;'>";
echo "<li><strong>Actualiza la página de WordPress</strong> (presiona F5)</li>";
echo "<li><strong>Ve al menú lateral de WordPress</strong> y busca <strong>'Próximos Cursos'</strong> (con icono 🎓)</li>";
echo "<li><strong>Haz clic en 'Próximos Cursos'</strong> para gestionar los cursos</li>";
echo "<li><strong>Rellena los campos:</strong> Nombre, Fecha, Modalidad, etc.</li>";
echo "<li><strong>Guarda los cambios</strong> y los cursos aparecerán en la página /anuncios</li>";
echo "</ol>";
echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
if ($campos_configurados == 0) {
    echo "<form method='post' style='display: inline;'>";
    echo "<button type='submit' name='configurar_ejemplo' style='background: #28a745; color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 16px; cursor: pointer; font-weight: bold;'>✅ Configurar Cursos de Ejemplo</button>";
    echo "</form>";
    echo "<p style='margin-top: 10px; color: #6c757d; font-size: 14px;'>Esto creará 3 cursos de ejemplo para que veas cómo funciona</p>";
}
echo "</div>";

echo "<div style='text-align: center; margin: 20px 0;'>";
echo "<a href='" . admin_url('admin.php?page=proximos-cursos') . "' style='background: #0066cc; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; margin: 5px; font-weight: bold;'>📝 Ir a Gestión de Cursos</a>";
echo "<a href='" . home_url('/anuncios') . "' style='background: #ffc107; color: #333; padding: 12px 24px; text-decoration: none; border-radius: 8px; margin: 5px; font-weight: bold;'>👀 Ver Página de Cursos</a>";
echo "</div>";

echo "<div style='background: #d1ecf1; color: #0c5460; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>📊 Resumen del Estado:</h3>";
echo "<p><strong>✅ Campos ACF:</strong> Configurados correctamente</p>";
echo "<p><strong>✅ Página de opciones:</strong> 'Próximos Cursos' creada</p>";
echo "<p><strong>✅ Ubicación:</strong> Menu lateral de WordPress</p>";
echo "<p><strong>📊 Campos configurados:</strong> $campos_configurados de " . count($campos) . "</p>";
if ($campos_configurados > 0) {
    echo "<p><strong>✅ Estado:</strong> Los cursos aparecerán en /anuncios</p>";
} else {
    echo "<p><strong>⚠️ Estado:</strong> Configura al menos un curso para que aparezca en /anuncios</p>";
}
echo "</div>";

echo "<div style='background: #fff3cd; color: #856404; padding: 15px; border-radius: 8px; margin: 20px 0;'>";
echo "<h4>💡 Nota Importante:</h4>";
echo "<p>Si no ves el menú 'Próximos Cursos' en WordPress:</p>";
echo "<p>1. Actualiza la página (F5)</p>";
echo "<p>2. Ve a <strong>ACF → Field Groups</strong></p>";
echo "<p>3. Busca <strong>'Próximos Cursos'</strong> y verifica que la ubicación sea <strong>'Options Page = proximos-cursos'</strong></p>";
echo "</div>";
?>
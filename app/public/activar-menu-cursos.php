<?php
/**
 * Activador del menú de gestión de cursos
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🎯 Activar Menú de Cursos</h1>";

// Verificar ACF
if (!function_exists('acf_add_options_page')) {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
    echo "❌ ACF no tiene la función de páginas de opciones";
    echo "</div>";
    exit;
}

// Crear la página de opciones
acf_add_options_page(array(
    'page_title' => 'Gestión de Próximos Cursos',
    'menu_title' => 'Próximos Cursos',
    'menu_slug' => 'proximos-cursos',
    'capability' => 'edit_posts',
    'icon_url' => 'dashicons-welcome-learn-more',
    'position' => 25,
));

echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "✅ Página de opciones 'Próximos Cursos' creada";
echo "</div>";

// Verificar si los campos existen
echo "<h2>🔍 Verificación de Campos:</h2>";

$campos = [
    'course_1_name' => 'Curso 1 - Nombre',
    'course_1_date' => 'Curso 1 - Fecha',
    'course_2_name' => 'Curso 2 - Nombre',
    'course_3_name' => 'Curso 3 - Nombre'
];

foreach ($campos as $campo => $descripcion) {
    $valor = get_field($campo, 'option');
    if ($valor) {
        echo "<div style='background: #d4edda; color: #155724; padding: 10px; margin: 5px 0; border-radius: 3px;'>";
        echo "✅ <strong>$descripcion:</strong> " . esc_html($valor);
        echo "</div>";
    } else {
        echo "<div style='background: #fff3cd; color: #856404; padding: 10px; margin: 5px 0; border-radius: 3px;'>";
        echo "⚠️ <strong>$descripcion:</strong> Sin configurar";
        echo "</div>";
    }
}

// Configurar algunos cursos de ejemplo
if (isset($_POST['configurar_ejemplo'])) {
    update_field('course_1_name', 'Montaje y Mantenimiento de Instalaciones Eléctricas', 'option');
    update_field('course_1_date', 'Enero 2025', 'option');
    update_field('course_1_modality', 'Presencial', 'option');
    update_field('course_1_duration', '15 plazas', 'option');
    
    update_field('course_2_name', 'Sistemas Domóticos e Inmóticos', 'option');
    update_field('course_2_date', 'Febrero 2025', 'option');
    update_field('course_2_modality', 'Presencial', 'option');
    update_field('course_2_duration', '12 plazas', 'option');
    
    update_field('course_3_name', 'Control de Plagas', 'option');
    update_field('course_3_date', 'Marzo 2025', 'option');
    update_field('course_3_modality', 'Presencial', 'option');
    update_field('course_3_duration', '10 plazas', 'option');
    
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "✅ <strong>Cursos de ejemplo configurados correctamente</strong>";
    echo "</div>";
    
    echo "<script>setTimeout(function(){ location.reload(); }, 2000);</script>";
}

echo "<h2>🎯 Instrucciones:</h2>";
echo "<div style='background: #e9ecef; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
echo "<ol>";
echo "<li><strong>Actualiza la página de WordPress</strong> (F5)</li>";
echo "<li><strong>Busca en el menú lateral:</strong> 'Próximos Cursos' (con icono 🎓)</li>";
echo "<li><strong>Si no aparece:</strong> Ve a ACF → Field Groups → Próximos Cursos</li>";
echo "<li><strong>Cambia la ubicación a:</strong> Options Page = 'proximos-cursos'</li>";
echo "</ol>";
echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<form method='post' style='display: inline;'>";
echo "<button type='submit' name='configurar_ejemplo' style='background: #28a745; color: white; padding: 15px 30px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;'>✅ Configurar Cursos de Ejemplo</button>";
echo "</form>";
echo "</div>";

echo "<div style='text-align: center; margin: 20px 0;'>";
echo "<a href='" . admin_url('admin.php?page=proximos-cursos') . "' style='background: #0066cc; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>📝 Ir a Próximos Cursos</a>";
echo "<a href='" . home_url('/anuncios') . "' style='background: #ffc107; color: #333; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>👀 Ver Página de Cursos</a>";
echo "</div>";

echo "<div style='background: #d1ecf1; color: #0c5460; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
echo "<h3>📋 Resumen:</h3>";
echo "<p>1. Ya tienes los campos ACF creados ✅</p>";
echo "<p>2. Ahora necesitas que aparezcan en el menú de WordPress</p>";
echo "<p>3. Una vez configurados, aparecerán en la página /anuncios</p>";
echo "</div>";
?>
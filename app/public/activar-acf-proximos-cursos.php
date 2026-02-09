<?php
/**
 * Activador automático de ACF para próximos cursos
 * Esta herramienta configura todo lo necesario para que funcione
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🔧 Activador ACF - Próximos Cursos</h1>";

// Verificar si ACF está instalado
if (!function_exists('acf_add_local_field_group')) {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "❌ <strong>ACF no está instalado o activo</strong><br>";
    echo "Necesitas instalar Advanced Custom Fields desde Plugins → Añadir nuevo";
    echo "</div>";
    
    echo "<h2>📋 Instrucciones:</h2>";
    echo "<ol>";
    echo "<li>Ve a <strong>Plugins → Añadir nuevo</strong></li>";
    echo "<li>Busca <strong>'Advanced Custom Fields'</strong></li>";
    echo "<li>Instala y activa el plugin</li>";
    echo "<li>Vuelve a esta página</li>";
    echo "</ol>";
    
    echo "<p><a href='" . admin_url('plugin-install.php?s=Advanced+Custom+Fields&tab=search&type=term') . "' style='background: #0066cc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🔌 Instalar ACF</a></p>";
    exit;
}

echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "✅ <strong>ACF está activo</strong>";
echo "</div>";

// Forzar la carga de los campos ACF
if (file_exists(ABSPATH . 'wp-content/themes/mongruas-theme/inc/acf-fields.php')) {
    include_once(ABSPATH . 'wp-content/themes/mongruas-theme/inc/acf-fields.php');
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "✅ <strong>Campos ACF cargados desde el tema</strong>";
    echo "</div>";
} else {
    echo "<div style='background: #fff3cd; color: #856404; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "⚠️ <strong>Archivo de campos ACF no encontrado</strong>";
    echo "</div>";
}

// Verificar si existe la página de opciones
if (function_exists('acf_add_options_page')) {
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "✅ <strong>Página de opciones ACF disponible</strong>";
    echo "</div>";
    
    // Crear la página de opciones si no existe
    acf_add_options_page(array(
        'page_title' => 'Theme Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug' => 'theme-settings',
        'capability' => 'edit_posts',
        'icon_url' => 'dashicons-admin-settings',
        'redirect' => false
    ));
    
    echo "<div style='background: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "ℹ️ <strong>Página 'Theme Settings' creada</strong><br>";
    echo "Ahora debería aparecer en el menú lateral de WordPress";
    echo "</div>";
}

// Verificar campos específicos
echo "<h2>🔍 Verificación de Campos:</h2>";

$campos_test = [
    'course_1_name' => 'Nombre del Curso 1',
    'course_2_name' => 'Nombre del Curso 2', 
    'course_3_name' => 'Nombre del Curso 3'
];

foreach ($campos_test as $campo => $descripcion) {
    $valor = get_field($campo, 'option');
    if ($valor !== false && $valor !== null && $valor !== '') {
        echo "<div style='background: #d4edda; color: #155724; padding: 10px; margin: 5px 0; border-radius: 3px;'>";
        echo "✅ <strong>$descripcion:</strong> " . esc_html($valor);
        echo "</div>";
    } else {
        echo "<div style='background: #fff3cd; color: #856404; padding: 10px; margin: 5px 0; border-radius: 3px;'>";
        echo "⚠️ <strong>$descripcion:</strong> Sin configurar";
        echo "</div>";
    }
}

// Enlaces útiles
echo "<h2>🔗 Enlaces Útiles:</h2>";
echo "<div style='margin: 20px 0;'>";

if (function_exists('acf_add_options_page')) {
    echo "<a href='" . admin_url('admin.php?page=theme-settings') . "' style='background: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px; display: inline-block;'>📝 Ir a Theme Settings</a>";
}

echo "<a href='" . home_url('/anuncios') . "' style='background: #0066cc; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px; display: inline-block;'>👀 Ver Página de Cursos</a>";

echo "<a href='configurar-proximos-cursos.php' style='background: #ffc107; color: #333; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px; display: inline-block;'>⚙️ Configurar Cursos</a>";

echo "</div>";

// Instrucciones finales
echo "<h2>📋 Próximos Pasos:</h2>";
echo "<div style='background: #e9ecef; padding: 20px; border-radius: 5px;'>";
echo "<ol>";
echo "<li><strong>Ve a WordPress Admin → Theme Settings</strong> (debería aparecer en el menú lateral)</li>";
echo "<li><strong>Busca la sección 'Próximos Cursos'</strong></li>";
echo "<li><strong>Completa los campos</strong> que quieras mostrar</li>";
echo "<li><strong>Guarda los cambios</strong></li>";
echo "<li><strong>Ve a /anuncios</strong> para ver los cursos</li>";
echo "</ol>";
echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . home_url() . "' style='background: #6c757d; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px;'>🏠 Volver al Inicio</a>";
echo "</div>";
?>
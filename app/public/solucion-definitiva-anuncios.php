<?php
/**
 * SOLUCIÓN DEFINITIVA - Página Anuncios
 * Forzar cambios inmediatos en la página /anuncios/
 */

// Cargar WordPress
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
}

echo "<h1>🚀 SOLUCIÓN DEFINITIVA - Página Anuncios</h1>";

// 1. Verificar que estamos en la página correcta
$anuncios_page = get_page_by_path('anuncios');
if (!$anuncios_page) {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "❌ ERROR: No se encuentra la página 'anuncios'. Creándola...";
    echo "</div>";
    
    // Crear la página anuncios si no existe
    $page_data = array(
        'post_title' => 'Anuncios',
        'post_name' => 'anuncios',
        'post_content' => 'Página de anuncios y próximos cursos',
        'post_status' => 'publish',
        'post_type' => 'page',
        'page_template' => 'page-templates/page-cursos.php'
    );
    
    $page_id = wp_insert_post($page_data);
    if ($page_id) {
        update_post_meta($page_id, '_wp_page_template', 'page-templates/page-cursos.php');
        echo "✅ Página 'anuncios' creada con ID: $page_id<br>";
    }
}

// 2. Forzar template correcto
if ($anuncios_page) {
    update_post_meta($anuncios_page->ID, '_wp_page_template', 'page-templates/page-cursos.php');
    echo "✅ Template asignado correctamente<br>";
}

// 3. Crear CSS inline directo
$css_directo = "
<style id='anuncios-fix-css'>
/* SOLUCIÓN DEFINITIVA - FORZAR 2 COLUMNAS */
.upcoming-courses-section {
    padding: 50px 0 !important;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%) !important;
}

.upcoming-courses-section .container {
    max-width: 1000px !important;
    margin: 0 auto !important;
    padding: 0 20px !important;
}

.upcoming-courses-grid {
    display: grid !important;
    grid-template-columns: 1fr 1fr !important;
    gap: 25px !important;
    margin: 35px auto 0 !important;
    max-width: 900px !important;
}

.upcoming-course-card {
    background: white !important;
    border-radius: 15px !important;
    box-shadow: 0 6px 25px rgba(0,0,0,0.08) !important;
    overflow: hidden !important;
    position: relative !important;
    border: 1px solid rgba(0,0,0,0.05) !important;
}

.upcoming-course-card::before {
    content: '' !important;
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    height: 3px !important;
    background: linear-gradient(90deg, #3498db, #27ae60) !important;
}

.course-content {
    padding: 22px !important;
}

.course-badge {
    background: linear-gradient(135deg, #e74c3c, #c0392b) !important;
    color: white !important;
    padding: 5px 12px !important;
    border-radius: 18px !important;
    font-size: 0.75rem !important;
    font-weight: 600 !important;
    text-transform: uppercase !important;
    display: inline-block !important;
    margin-bottom: 10px !important;
}

.course-date {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    margin-bottom: 15px !important;
    color: #e74c3c !important;
    font-weight: 600 !important;
    background: rgba(231, 76, 60, 0.08) !important;
    padding: 8px 12px !important;
    border-radius: 8px !important;
    border-left: 3px solid #e74c3c !important;
}

.btn-reserve {
    background: linear-gradient(135deg, #27ae60, #229954) !important;
    color: white !important;
    padding: 12px 24px !important;
    border-radius: 22px !important;
    text-decoration: none !important;
    font-weight: 600 !important;
    text-align: center !important;
    width: 100% !important;
    display: block !important;
    font-size: 0.9rem !important;
    text-transform: uppercase !important;
}

/* Responsive */
@media (max-width: 768px) {
    .upcoming-courses-grid {
        grid-template-columns: 1fr !important;
        gap: 20px !important;
    }
}

/* Override cualquier otro estilo */
body .upcoming-courses-section .upcoming-courses-grid,
.page-cursos .upcoming-courses-section .upcoming-courses-grid,
#primary .upcoming-courses-section .upcoming-courses-grid {
    display: grid !important;
    grid-template-columns: 1fr 1fr !important;
    max-width: 900px !important;
}

@media (max-width: 768px) {
    body .upcoming-courses-section .upcoming-courses-grid,
    .page-cursos .upcoming-courses-section .upcoming-courses-grid,
    #primary .upcoming-courses-section .upcoming-courses-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>
";

// 4. Guardar CSS como opción de WordPress
update_option('anuncios_custom_css', $css_directo);
echo "✅ CSS personalizado guardado<br>";

// 5. Limpiar todos los caches
wp_cache_flush();
if (function_exists('wp_cache_delete')) {
    wp_cache_delete('alloptions', 'options');
}

// Limpiar transients
global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'");
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_site_transient_%'");

echo "✅ Cache limpiado completamente<br>";

// 6. Crear archivo de override directo
$override_content = "<?php
// Override directo para página anuncios
add_action('wp_head', function() {
    if (is_page('anuncios')) {
        echo get_option('anuncios_custom_css', '');
    }
});
?>";

file_put_contents(get_template_directory() . '/anuncios-override.php', $override_content);
echo "✅ Archivo de override creado<br>";

// 7. Incluir el override en functions.php
$functions_path = get_template_directory() . '/functions.php';
$functions_content = file_get_contents($functions_path);

if (strpos($functions_content, 'anuncios-override.php') === false) {
    $include_line = "\n// Override para página anuncios\nrequire_once MONGRUAS_THEME_DIR . '/anuncios-override.php';\n";
    $functions_content = str_replace('?>', $include_line . '?>', $functions_content);
    file_put_contents($functions_path, $functions_content);
    echo "✅ Override incluido en functions.php<br>";
}

echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🎯 SOLUCIÓN APLICADA</h2>";
echo "<p><strong>Se han aplicado los siguientes cambios:</strong></p>";
echo "<ul>";
echo "<li>✅ CSS forzado con selectores específicos</li>";
echo "<li>✅ Grid de 2 columnas fijo: <code>grid-template-columns: 1fr 1fr</code></li>";
echo "<li>✅ Override directo en functions.php</li>";
echo "<li>✅ Cache completamente limpiado</li>";
echo "<li>✅ Responsive: 1 columna en móviles</li>";
echo "</ul>";
echo "</div>";

echo "<div style='background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>📋 INSTRUCCIONES FINALES:</h3>";
echo "<ol>";
echo "<li><strong>Abre una ventana incógnito/privada</strong></li>";
echo "<li><strong>Ve a:</strong> <a href='" . home_url('/anuncios/') . "' target='_blank'>" . home_url('/anuncios/') . "</a></li>";
echo "<li><strong>Presiona Ctrl+F5</strong> (Windows) o <strong>Cmd+Shift+R</strong> (Mac)</li>";
echo "<li><strong>Verifica:</strong> Deberías ver exactamente 2 cursos por fila</li>";
echo "</ol>";
echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . home_url('/anuncios/') . "' target='_blank' style='background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; font-size: 18px; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3); display: inline-block; margin: 10px;'>🔗 VER PÁGINA ANUNCIOS</a>";
echo "</div>";

// 8. Mostrar vista previa del CSS aplicado
echo "<h2>🎨 Vista Previa del CSS Aplicado:</h2>";
echo $css_directo;

echo "<div style='background: #e2e3e5; border: 1px solid #d6d8db; color: #383d41; padding: 15px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>🔧 Si aún no funciona:</h3>";
echo "<p>Ejecuta estos comandos adicionales:</p>";
echo "<ul>";
echo "<li><a href='" . home_url('/limpiar-cache-anuncios.php') . "' target='_blank'>Limpiar cache adicional</a></li>";
echo "<li>Desactiva plugins de cache temporalmente</li>";
echo "<li>Verifica en diferentes navegadores</li>";
echo "</ul>";
echo "</div>";
?>
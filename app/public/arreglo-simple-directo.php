<?php
/**
 * ARREGLO SIMPLE Y DIRECTO
 * Solo cambiar el CSS problemático
 */

// Cargar WordPress
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
}

echo "<h1>🔧 ARREGLO SIMPLE Y DIRECTO</h1>";

// Leer el template actual
$template_path = get_template_directory() . '/page-templates/page-cursos.php';
$content = file_get_contents($template_path);

// Reemplazar TODAS las instancias problemáticas
$content = str_replace('grid-template-columns: repeat(auto-fit, minmax(320px, 1fr))', 'grid-template-columns: 1fr 1fr', $content);
$content = str_replace('grid-template-columns: repeat(2, 1fr) !important', 'grid-template-columns: 1fr 1fr !important', $content);

// Agregar CSS forzado al final del archivo, justo antes del </style>
$css_forzado = '
/* FORZAR 2 COLUMNAS - OVERRIDE FINAL */
.upcoming-courses-grid,
.upcoming-courses-section .upcoming-courses-grid,
body .upcoming-courses-section .upcoming-courses-grid {
    display: grid !important;
    grid-template-columns: 1fr 1fr !important;
    gap: 30px !important;
    max-width: 900px !important;
    margin: 0 auto !important;
}

@media (max-width: 768px) {
    .upcoming-courses-grid,
    .upcoming-courses-section .upcoming-courses-grid,
    body .upcoming-courses-section .upcoming-courses-grid {
        grid-template-columns: 1fr !important;
    }
}
';

// Buscar el último </style> y agregar el CSS antes
$last_style_pos = strrpos($content, '</style>');
if ($last_style_pos !== false) {
    $content = substr_replace($content, $css_forzado . '</style>', $last_style_pos, 8);
}

// Guardar
file_put_contents($template_path, $content);

echo "✅ Template modificado directamente<br>";

// Limpiar cache
wp_cache_flush();
global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'");
update_option('mongruas_theme_version', time());

echo "✅ Cache limpiado<br>";

echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>✅ ARREGLO APLICADO</h2>";
echo "<p>Se ha modificado directamente el template para forzar 2 columnas.</p>";
echo "<ul>";
echo "<li>✅ CSS cambiado a <code>grid-template-columns: 1fr 1fr</code></li>";
echo "<li>✅ Override final agregado</li>";
echo "<li>✅ Cache limpiado</li>";
echo "</ul>";
echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . home_url('/anuncios/') . "' target='_blank' style='background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; font-size: 18px; display: inline-block;'>🔗 VER PÁGINA ANUNCIOS</a>";
echo "</div>";

echo "<p style='text-align: center; color: #666;'>Abre en incógnito y presiona Ctrl+F5 para ver los cambios</p>";
?>
<?php
/**
 * Página individual de curso
 * URL: /curso/?curso=1
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

// Verificar que el template existe
$template_path = 'wp-content/themes/mongruas-theme/page-templates/single-course.php';

if (file_exists($template_path)) {
    // Incluir el template
    include $template_path;
} else {
    // Mostrar error si el template no existe
    echo "<h1>Error: Template no encontrado</h1>";
    echo "<p>El archivo $template_path no existe.</p>";
    echo "<a href='" . home_url('/anuncios') . "'>Volver a cursos</a>";
}
?>
<?php
/**
 * Test rápido de próximos cursos
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🧪 Test Próximos Cursos</h1>";

// Verificar ACF
if (!function_exists('get_field')) {
    echo "<p style='color: red;'>❌ ACF no está activo</p>";
    exit;
}

echo "<p style='color: green;'>✅ ACF está activo</p>";

// Verificar campos
echo "<h2>📋 Campos ACF:</h2>";
for ($i = 1; $i <= 3; $i++) {
    $titulo = get_field("course_{$i}_name", 'option');
    $fecha = get_field("course_{$i}_date", 'option');
    $modalidad = get_field("course_{$i}_modality", 'option');
    $duracion = get_field("course_{$i}_duration", 'option');
    
    echo "<h3>Curso $i:</h3>";
    echo "<ul>";
    echo "<li><strong>Título:</strong> " . ($titulo ? $titulo : 'Sin configurar') . "</li>";
    echo "<li><strong>Fecha:</strong> " . ($fecha ? $fecha : 'Sin configurar') . "</li>";
    echo "<li><strong>Modalidad:</strong> " . ($modalidad ? $modalidad : 'Sin configurar') . "</li>";
    echo "<li><strong>Duración:</strong> " . ($duracion ? $duracion : 'Sin configurar') . "</li>";
    echo "</ul>";
}

// Simular el código del template
echo "<h2>🎯 Simulación del Template:</h2>";
$curso1_titulo = get_field('course_1_name', 'option');
$curso2_titulo = get_field('course_2_name', 'option');
$curso3_titulo = get_field('course_3_name', 'option');

if ($curso1_titulo || $curso2_titulo || $curso3_titulo) {
    echo "<p style='color: green;'>✅ Se mostrarán cursos desde ACF</p>";
    
    for ($i = 1; $i <= 3; $i++) {
        $titulo = get_field("course_{$i}_name", 'option');
        $fecha = get_field("course_{$i}_date", 'option');
        $modalidad = get_field("course_{$i}_modality", 'option');
        $duracion = get_field("course_{$i}_duration", 'option');
        
        if ($titulo) {
            echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px 0;'>";
            echo "<h4>$titulo</h4>";
            echo "<p>📅 " . ($fecha ? $fecha : 'Próximamente') . "</p>";
            echo "<p>🎯 " . ($modalidad ? $modalidad : 'Presencial') . "</p>";
            echo "<p>⏱️ " . ($duracion ? $duracion : 'Plazas limitadas') . "</p>";
            echo "</div>";
        }
    }
} else {
    echo "<p style='color: orange;'>⚠️ Se mostrarán cursos de ejemplo por defecto</p>";
    echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px 0;'>";
    echo "<h4>Montaje y Mantenimiento de Instalaciones Eléctricas</h4>";
    echo "<p>📅 Enero 2025</p>";
    echo "<p>🎯 Presencial</p>";
    echo "<p>⏱️ 15 plazas</p>";
    echo "</div>";
}

echo "<hr>";
echo "<p><a href='configurar-proximos-cursos.php'>⚙️ Configurar Cursos</a></p>";
echo "<p><a href='" . home_url('/anuncios') . "'>👀 Ver Página de Cursos</a></p>";
echo "<p><a href='" . admin_url('admin.php?page=theme-settings') . "'>📝 Theme Settings</a></p>";
?>
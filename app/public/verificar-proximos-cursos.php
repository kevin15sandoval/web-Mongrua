<?php
/**
 * Verificación de Próximos Cursos
 * Herramienta para verificar que el sistema de próximos cursos funciona correctamente
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación - Próximos Cursos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #0066cc; }
        .status { padding: 15px; margin: 10px 0; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .warning { background: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        .course-card { background: #f8f9fa; padding: 20px; margin: 15px 0; border-radius: 8px; border-left: 4px solid #0066cc; }
        .course-title { font-size: 18px; font-weight: bold; color: #333; margin-bottom: 10px; }
        .course-details { color: #666; }
        .btn { display: inline-block; padding: 12px 24px; background: #0066cc; color: white; text-decoration: none; border-radius: 5px; margin: 10px 5px; }
        .btn:hover { background: #0052a3; }
        .btn-success { background: #28a745; }
        .btn-warning { background: #ffc107; color: #333; }
        .section { margin: 30px 0; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .field-info { background: #e9ecef; padding: 10px; margin: 5px 0; border-radius: 4px; font-family: monospace; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎓 Verificación del Sistema de Próximos Cursos</h1>
            <p>Diagnóstico completo del sistema ACF para gestión de cursos</p>
        </div>

        <?php
        // Verificar si ACF está activo
        if (!function_exists('get_field')) {
            echo '<div class="status error">❌ <strong>Error:</strong> Advanced Custom Fields no está activo o instalado.</div>';
            exit;
        }

        echo '<div class="status success">✅ <strong>ACF está activo</strong></div>';

        // Verificar campos ACF
        echo '<div class="section">';
        echo '<h2>📋 Verificación de Campos ACF</h2>';
        
        $campos_esperados = [
            'course_1_name' => 'Nombre del Curso 1',
            'course_1_date' => 'Fecha del Curso 1',
            'course_1_modality' => 'Modalidad del Curso 1',
            'course_1_duration' => 'Duración del Curso 1',
            'course_2_name' => 'Nombre del Curso 2',
            'course_2_date' => 'Fecha del Curso 2',
            'course_2_modality' => 'Modalidad del Curso 2',
            'course_2_duration' => 'Duración del Curso 2',
            'course_3_name' => 'Nombre del Curso 3',
            'course_3_date' => 'Fecha del Curso 3',
            'course_3_modality' => 'Modalidad del Curso 3',
            'course_3_duration' => 'Duración del Curso 3',
        ];

        $campos_encontrados = 0;
        foreach ($campos_esperados as $campo => $descripcion) {
            $valor = get_field($campo, 'option');
            if ($valor !== false && $valor !== null && $valor !== '') {
                echo '<div class="status success">✅ <strong>' . $descripcion . ':</strong> ' . esc_html($valor) . '</div>';
                $campos_encontrados++;
            } else {
                echo '<div class="status warning">⚠️ <strong>' . $descripcion . ':</strong> Sin configurar</div>';
            }
        }

        if ($campos_encontrados > 0) {
            echo '<div class="status success">✅ <strong>Se encontraron ' . $campos_encontrados . ' campos configurados</strong></div>';
        } else {
            echo '<div class="status warning">⚠️ <strong>No se encontraron campos configurados. La administradora debe configurar los cursos.</strong></div>';
        }
        echo '</div>';

        // Mostrar cursos configurados
        echo '<div class="section">';
        echo '<h2>📚 Cursos Configurados</h2>';
        
        $hay_cursos = false;
        for ($i = 1; $i <= 3; $i++) {
            $titulo = get_field("course_{$i}_name", 'option');
            $fecha = get_field("course_{$i}_date", 'option');
            $modalidad = get_field("course_{$i}_modality", 'option');
            $duracion = get_field("course_{$i}_duration", 'option');
            
            if ($titulo) {
                $hay_cursos = true;
                echo '<div class="course-card">';
                echo '<div class="course-title">Curso ' . $i . ': ' . esc_html($titulo) . '</div>';
                echo '<div class="course-details">';
                echo '<strong>📅 Fecha:</strong> ' . ($fecha ? esc_html($fecha) : 'No especificada') . '<br>';
                echo '<strong>🎯 Modalidad:</strong> ' . ($modalidad ? esc_html($modalidad) : 'No especificada') . '<br>';
                echo '<strong>⏱️ Duración:</strong> ' . ($duracion ? esc_html($duracion) : 'No especificada');
                echo '</div>';
                echo '</div>';
            }
        }
        
        if (!$hay_cursos) {
            echo '<div class="status info">ℹ️ <strong>No hay cursos configurados actualmente.</strong> Los cursos de ejemplo se mostrarán en la página.</div>';
        }
        echo '</div>';

        // Instrucciones para la administradora
        echo '<div class="section">';
        echo '<h2>👩‍💼 Instrucciones para la Administradora</h2>';
        echo '<div class="status info">';
        echo '<strong>Para gestionar los próximos cursos:</strong><br>';
        echo '1. Ve al panel de administración de WordPress<br>';
        echo '2. En el menú lateral, busca "Theme Settings"<br>';
        echo '3. Busca la sección "Próximos Cursos"<br>';
        echo '4. Completa los campos para cada curso que quieras mostrar<br>';
        echo '5. Guarda los cambios<br>';
        echo '6. Los cursos aparecerán automáticamente en la página /anuncios';
        echo '</div>';
        echo '</div>';

        // Enlaces útiles
        echo '<div class="section">';
        echo '<h2>🔗 Enlaces Útiles</h2>';
        echo '<a href="' . admin_url('admin.php?page=theme-settings') . '" class="btn">📝 Ir a Theme Settings</a>';
        echo '<a href="' . home_url('/anuncios') . '" class="btn btn-success">👀 Ver Página de Cursos</a>';
        echo '<a href="' . home_url() . '" class="btn btn-warning">🏠 Volver al Inicio</a>';
        echo '</div>';

        // Información técnica
        echo '<div class="section">';
        echo '<h2>🔧 Información Técnica</h2>';
        echo '<div class="field-info"><strong>Campos ACF utilizados:</strong><br>';
        foreach ($campos_esperados as $campo => $descripcion) {
            echo 'get_field(\'' . $campo . '\', \'option\')<br>';
        }
        echo '</div>';
        echo '<div class="status info">ℹ️ Los campos se guardan como opciones globales del tema, accesibles desde cualquier página.</div>';
        echo '</div>';
        ?>

        <div class="section">
            <h2>✅ Estado del Sistema</h2>
            <?php if ($campos_encontrados > 0): ?>
                <div class="status success">
                    <strong>✅ Sistema funcionando correctamente</strong><br>
                    Se encontraron <?php echo $campos_encontrados; ?> campos configurados. 
                    La administradora puede gestionar los cursos desde Theme Settings.
                </div>
            <?php else: ?>
                <div class="status warning">
                    <strong>⚠️ Sistema listo para configurar</strong><br>
                    Los campos ACF están disponibles pero no configurados. 
                    La administradora debe acceder a Theme Settings para añadir los próximos cursos.
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
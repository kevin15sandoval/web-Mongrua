<?php
/**
 * Configurador de Próximos Cursos
 * Herramienta para configurar automáticamente los campos ACF de próximos cursos
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

// Verificar si es una petición POST
if ($_POST && isset($_POST['action']) && $_POST['action'] === 'configurar_cursos') {
    
    // Verificar nonce de seguridad
    if (!wp_verify_nonce($_POST['_wpnonce'], 'configurar_cursos')) {
        die('Error de seguridad');
    }
    
    // Configurar cursos de ejemplo
    $cursos_ejemplo = [
        1 => [
            'name' => 'Montaje y Mantenimiento de Instalaciones Eléctricas',
            'date' => 'Enero 2025',
            'modality' => 'Presencial',
            'duration' => '15 plazas'
        ],
        2 => [
            'name' => 'Sistemas Domóticos e Inmóticos',
            'date' => 'Febrero 2025',
            'modality' => 'Presencial',
            'duration' => '12 plazas'
        ],
        3 => [
            'name' => 'Control de Plagas',
            'date' => 'Marzo 2025',
            'modality' => 'Presencial',
            'duration' => '10 plazas'
        ]
    ];
    
    $configurados = 0;
    foreach ($cursos_ejemplo as $i => $curso) {
        if (update_field("course_{$i}_name", $curso['name'], 'option')) $configurados++;
        if (update_field("course_{$i}_date", $curso['date'], 'option')) $configurados++;
        if (update_field("course_{$i}_modality", $curso['modality'], 'option')) $configurados++;
        if (update_field("course_{$i}_duration", $curso['duration'], 'option')) $configurados++;
    }
    
    $mensaje = "✅ Se configuraron $configurados campos correctamente.";
    $tipo_mensaje = 'success';
}

// Verificar si es una petición para limpiar
if ($_POST && isset($_POST['action']) && $_POST['action'] === 'limpiar_cursos') {
    
    // Verificar nonce de seguridad
    if (!wp_verify_nonce($_POST['_wpnonce'], 'limpiar_cursos')) {
        die('Error de seguridad');
    }
    
    $limpiados = 0;
    for ($i = 1; $i <= 3; $i++) {
        if (delete_field("course_{$i}_name", 'option')) $limpiados++;
        if (delete_field("course_{$i}_date", 'option')) $limpiados++;
        if (delete_field("course_{$i}_modality", 'option')) $limpiados++;
        if (delete_field("course_{$i}_duration", 'option')) $limpiados++;
    }
    
    $mensaje = "🗑️ Se limpiaron $limpiados campos correctamente.";
    $tipo_mensaje = 'warning';
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurar Próximos Cursos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #0066cc; }
        .status { padding: 15px; margin: 10px 0; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .warning { background: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        .btn { display: inline-block; padding: 12px 24px; background: #0066cc; color: white; text-decoration: none; border-radius: 5px; margin: 10px 5px; border: none; cursor: pointer; }
        .btn:hover { background: #0052a3; }
        .btn-success { background: #28a745; }
        .btn-warning { background: #ffc107; color: #333; }
        .btn-danger { background: #dc3545; }
        .section { margin: 30px 0; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .course-preview { background: #f8f9fa; padding: 15px; margin: 10px 0; border-radius: 8px; border-left: 4px solid #0066cc; }
        form { display: inline; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚙️ Configurador de Próximos Cursos</h1>
            <p>Herramienta para gestionar los cursos que aparecen en la página /anuncios</p>
        </div>

        <?php if (isset($mensaje)): ?>
            <div class="status <?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <?php
        // Verificar si ACF está activo
        if (!function_exists('get_field')) {
            echo '<div class="status error">❌ <strong>Error:</strong> Advanced Custom Fields no está activo.</div>';
            exit;
        }

        // Mostrar estado actual
        echo '<div class="section">';
        echo '<h2>📋 Estado Actual de los Cursos</h2>';
        
        $hay_cursos = false;
        for ($i = 1; $i <= 3; $i++) {
            $titulo = get_field("course_{$i}_name", 'option');
            $fecha = get_field("course_{$i}_date", 'option');
            $modalidad = get_field("course_{$i}_modality", 'option');
            $duracion = get_field("course_{$i}_duration", 'option');
            
            if ($titulo) {
                $hay_cursos = true;
                echo '<div class="course-preview">';
                echo '<strong>Curso ' . $i . ':</strong> ' . esc_html($titulo) . '<br>';
                echo '<strong>Fecha:</strong> ' . ($fecha ? esc_html($fecha) : 'No especificada') . '<br>';
                echo '<strong>Modalidad:</strong> ' . ($modalidad ? esc_html($modalidad) : 'No especificada') . '<br>';
                echo '<strong>Duración/Plazas:</strong> ' . ($duracion ? esc_html($duracion) : 'No especificada');
                echo '</div>';
            } else {
                echo '<div class="status info">Curso ' . $i . ': Sin configurar</div>';
            }
        }
        
        if (!$hay_cursos) {
            echo '<div class="status warning">⚠️ <strong>No hay cursos configurados.</strong> Se mostrarán los cursos de ejemplo por defecto.</div>';
        }
        echo '</div>';
        ?>

        <div class="section">
            <h2>🛠️ Acciones Disponibles</h2>
            
            <div class="status info">
                <strong>Configurar Cursos de Ejemplo:</strong><br>
                Esto configurará automáticamente 3 cursos de ejemplo que coinciden con los certificados de profesionalidad.
            </div>
            
            <form method="post">
                <?php wp_nonce_field('configurar_cursos'); ?>
                <input type="hidden" name="action" value="configurar_cursos">
                <button type="submit" class="btn btn-success">✅ Configurar Cursos de Ejemplo</button>
            </form>

            <?php if ($hay_cursos): ?>
            <div class="status warning" style="margin-top: 20px;">
                <strong>Limpiar Configuración:</strong><br>
                Esto eliminará todos los cursos configurados y volverá a mostrar los ejemplos por defecto.
            </div>
            
            <form method="post">
                <?php wp_nonce_field('limpiar_cursos'); ?>
                <input type="hidden" name="action" value="limpiar_cursos">
                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres limpiar todos los cursos?')">🗑️ Limpiar Cursos</button>
            </form>
            <?php endif; ?>
        </div>

        <div class="section">
            <h2>👩‍💼 Para la Administradora</h2>
            <div class="status info">
                <strong>Gestión Manual:</strong><br>
                Para gestionar los cursos manualmente, ve a <strong>Theme Settings</strong> en el panel de WordPress y busca la sección "Próximos Cursos".
            </div>
            
            <a href="<?php echo admin_url('admin.php?page=theme-settings'); ?>" class="btn">📝 Ir a Theme Settings</a>
            <a href="<?php echo home_url('/anuncios'); ?>" class="btn btn-success">👀 Ver Página de Cursos</a>
        </div>

        <div class="section">
            <h2>ℹ️ Información</h2>
            <div class="status info">
                <strong>¿Cómo funciona?</strong><br>
                • Si hay cursos configurados en ACF, se muestran esos<br>
                • Si no hay cursos configurados, se muestran ejemplos por defecto<br>
                • La administradora puede gestionar fácilmente desde Theme Settings<br>
                • Los cambios se reflejan inmediatamente en la página /anuncios
            </div>
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <a href="<?php echo home_url(); ?>" class="btn">🏠 Volver al Inicio</a>
            <a href="verificar-proximos-cursos.php" class="btn">🔍 Verificar Sistema</a>
        </div>
    </div>
</body>
</html>
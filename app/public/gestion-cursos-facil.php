<?php
/**
 * 📚 GESTIÓN DE CURSOS FÁCIL
 * 
 * Herramienta simple para gestionar cursos
 */

// Cargar WordPress
require_once('wp-load.php');

// Verificar que el usuario sea administrador
if (!current_user_can('administrator')) {
    wp_redirect('/wp-admin/');
    exit;
}

// Obtener la página de cursos
$cursos_page = get_page_by_path('cursos');
if (!$cursos_page) {
    // Crear la página si no existe
    $page_id = wp_insert_post([
        'post_title' => 'Cursos',
        'post_name' => 'cursos',
        'post_content' => 'Página de cursos de Mogruas',
        'post_status' => 'publish',
        'post_type' => 'page'
    ]);
    
    if ($page_id && !is_wp_error($page_id)) {
        $cursos_page = get_post($page_id);
    }
}

// Procesar formulario
$mensaje = '';
if ($_POST && isset($_POST['curso_id'])) {
    $curso_id = intval($_POST['curso_id']);
    
    if (in_array($curso_id, [1, 2, 3]) && $cursos_page) {
        $name = sanitize_text_field($_POST['name']);
        $description = sanitize_textarea_field($_POST['description']);
        $date = sanitize_text_field($_POST['date']);
        $duration = sanitize_text_field($_POST['duration']);
        $modality = sanitize_text_field($_POST['modality']);
        $category = sanitize_text_field($_POST['category']);
        
        // Guardar campos
        update_field("course_{$curso_id}_name", $name, $cursos_page->ID);
        update_field("course_{$curso_id}_description", $description, $cursos_page->ID);
        update_field("course_{$curso_id}_date", $date, $cursos_page->ID);
        update_field("course_{$curso_id}_duration", $duration, $cursos_page->ID);
        update_field("course_{$curso_id}_modality", $modality, $cursos_page->ID);
        update_field("course_{$curso_id}_category", $category, $cursos_page->ID);
        
        $mensaje = "✅ Curso $curso_id guardado correctamente";
    }
}

// Obtener cursos actuales
$cursos = [];
if ($cursos_page) {
    for ($i = 1; $i <= 3; $i++) {
        $cursos[] = [
            'id' => $i,
            'name' => get_field("course_{$i}_name", $cursos_page->ID) ?: '',
            'description' => get_field("course_{$i}_description", $cursos_page->ID) ?: '',
            'date' => get_field("course_{$i}_date", $cursos_page->ID) ?: '',
            'duration' => get_field("course_{$i}_duration", $cursos_page->ID) ?: '',
            'modality' => get_field("course_{$i}_modality", $cursos_page->ID) ?: 'Online',
            'category' => get_field("course_{$i}_category", $cursos_page->ID) ?: 'Prevención de Riesgos Laborales',
            'isActive' => !empty(get_field("course_{$i}_name", $cursos_page->ID))
        ];
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📚 Gestión de Cursos Fácil</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f0f0f0; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; }
        .course-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 20px; }
        .course-card { border: 2px solid #ddd; padding: 20px; border-radius: 10px; }
        .course-card.active { border-color: #28a745; background: #f8fff9; }
        .course-card.empty { border-color: #ffc107; background: #fffdf0; }
        .form-group { margin: 10px 0; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #0056b3; }
        .alert { padding: 15px; margin: 15px 0; border-radius: 4px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        h1, h2, h3 { text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📚 Gestión de Cursos Fácil</h1>
        <p style="text-align: center;">Herramienta simple para gestionar los cursos de Mogruas</p>
        
        <?php if ($mensaje): ?>
            <div class="alert"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        
        <div class="course-grid">
            <?php foreach ($cursos as $curso): ?>
                <div class="course-card <?php echo $curso['isActive'] ? 'active' : 'empty'; ?>">
                    <h3>Curso <?php echo $curso['id']; ?> - <?php echo $curso['isActive'] ? 'ACTIVO' : 'VACÍO'; ?></h3>
                    
                    <form method="post">
                        <input type="hidden" name="curso_id" value="<?php echo $curso['id']; ?>">
                        
                        <div class="form-group">
                            <label>Nombre del Curso *</label>
                            <input type="text" name="name" value="<?php echo esc_attr($curso['name']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Descripción</label>
                            <textarea name="description" rows="3"><?php echo esc_textarea($curso['description']); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Fecha de Inicio</label>
                            <input type="text" name="date" value="<?php echo esc_attr($curso['date']); ?>" placeholder="Ej: 15 de Enero 2025">
                        </div>
                        
                        <div class="form-group">
                            <label>Duración</label>
                            <input type="text" name="duration" value="<?php echo esc_attr($curso['duration']); ?>" placeholder="Ej: 40 horas">
                        </div>
                        
                        <div class="form-group">
                            <label>Modalidad</label>
                            <select name="modality">
                                <option value="Online" <?php selected($curso['modality'], 'Online'); ?>>Online</option>
                                <option value="Presencial" <?php selected($curso['modality'], 'Presencial'); ?>>Presencial</option>
                                <option value="Semipresencial" <?php selected($curso['modality'], 'Semipresencial'); ?>>Semipresencial</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Categoría</label>
                            <select name="category">
                                <option value="Prevención de Riesgos Laborales" <?php selected($curso['category'], 'Prevención de Riesgos Laborales'); ?>>Prevención de Riesgos Laborales</option>
                                <option value="Formación Profesional" <?php selected($curso['category'], 'Formación Profesional'); ?>>Formación Profesional</option>
                                <option value="Idiomas" <?php selected($curso['category'], 'Idiomas'); ?>>Idiomas</option>
                                <option value="Informática" <?php selected($curso['category'], 'Informática'); ?>>Informática</option>
                                <option value="Gestión Empresarial" <?php selected($curso['category'], 'Gestión Empresarial'); ?>>Gestión Empresarial</option>
                                <option value="Marketing" <?php selected($curso['category'], 'Marketing'); ?>>Marketing</option>
                                <option value="Otros" <?php selected($curso['category'], 'Otros'); ?>>Otros</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn">💾 Guardar Curso</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="/" class="btn">🏠 Ver Sitio</a>
            <a href="/cursos/" class="btn">📚 Página Cursos</a>
            <a href="/verificar-correos.php" class="btn">📧 Verificar Correos</a>
        </div>
    </div>
</body>
</html>
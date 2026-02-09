<?php
/**
 * Gestor de Próximos Cursos - Sin ACF PRO
 * Permite gestionar los cursos directamente
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🎓 Gestionar Próximos Cursos (Hasta 6 cursos con carrusel)</h1>";

// Procesar formulario
if (isset($_POST['guardar_cursos'])) {
    // Guardar hasta 6 cursos
    for ($i = 1; $i <= 6; $i++) {
        update_option("course_{$i}_name", sanitize_text_field($_POST["course_{$i}_name"] ?? ''));
        update_option("course_{$i}_date", sanitize_text_field($_POST["course_{$i}_date"] ?? ''));
        update_option("course_{$i}_modality", sanitize_text_field($_POST["course_{$i}_modality"] ?? ''));
        update_option("course_{$i}_duration", sanitize_text_field($_POST["course_{$i}_duration"] ?? ''));
        update_option("course_{$i}_description", sanitize_textarea_field($_POST["course_{$i}_description"] ?? ''));
        update_option("course_{$i}_image", sanitize_text_field($_POST["course_{$i}_image"] ?? ''));
    }
    
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "✅ <strong>¡Todos los cursos guardados correctamente!</strong>";
    echo "</div>";
}

// Obtener valores actuales para todos los cursos
$cursos = [];
$cursos_default = [
    1 => ['name' => 'Montaje y Mantenimiento de Instalaciones Eléctricas', 'date' => 'Enero 2025', 'modality' => 'Presencial', 'duration' => '15 plazas', 'description' => 'Curso completo de instalaciones eléctricas de baja tensión con certificado oficial.'],
    2 => ['name' => 'Sistemas Domóticos e Inmóticos', 'date' => 'Febrero 2025', 'modality' => 'Presencial', 'duration' => '12 plazas', 'description' => 'Especialización en automatización de edificios y sistemas inteligentes.'],
    3 => ['name' => 'Control de Plagas', 'date' => 'Marzo 2025', 'modality' => 'Presencial', 'duration' => '10 plazas', 'description' => 'Formación profesional en control y prevención de plagas urbanas.'],
    4 => ['name' => 'Prevención de Riesgos Laborales', 'date' => 'Abril 2025', 'modality' => 'Online', 'duration' => '20 plazas', 'description' => 'Curso básico de 60 horas en prevención de riesgos laborales.'],
    5 => ['name' => 'Soldadura con Electrodo Revestido', 'date' => 'Mayo 2025', 'modality' => 'Presencial', 'duration' => '8 plazas', 'description' => 'Formación práctica en técnicas de soldadura profesional.'],
    6 => ['name' => 'Gestión de Residuos', 'date' => 'Junio 2025', 'modality' => 'Semipresencial', 'duration' => '15 plazas', 'description' => 'Especialización en gestión y tratamiento de residuos industriales.']
];

for ($i = 1; $i <= 6; $i++) {
    $cursos[$i] = [
        'name' => get_option("course_{$i}_name", $cursos_default[$i]['name'] ?? ''),
        'date' => get_option("course_{$i}_date", $cursos_default[$i]['date'] ?? ''),
        'modality' => get_option("course_{$i}_modality", $cursos_default[$i]['modality'] ?? 'Presencial'),
        'duration' => get_option("course_{$i}_duration", $cursos_default[$i]['duration'] ?? ''),
        'description' => get_option("course_{$i}_description", $cursos_default[$i]['description'] ?? ''),
        'image' => get_option("course_{$i}_image", '')
    ];
}
?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
    background: #f1f1f1;
}

.form-container {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin: 20px 0;
}

.courses-tabs {
    display: flex;
    gap: 10px;
    margin-bottom: 30px;
    flex-wrap: wrap;
    justify-content: center;
}

.tab-button {
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    padding: 12px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    color: #495057;
    font-size: 14px;
}

.tab-button.active {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
    border-color: #0066cc;
    box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3);
}

.tab-button:hover:not(.active) {
    background: #e9ecef;
    border-color: #0066cc;
    transform: translateY(-2px);
}

.course-section {
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    padding: 30px;
    margin: 20px 0;
    background: #fafafa;
    display: none;
}

.course-section.active {
    display: block;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.course-section h3 {
    color: #0066cc;
    margin-top: 0;
    font-size: 20px;
    border-bottom: 2px solid #0066cc;
    padding-bottom: 10px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin: 15px 0;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
}

.form-group input, .form-group select, .form-group textarea {
    padding: 12px;
    border: 2px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    transition: border-color 0.3s;
    font-family: inherit;
}

.form-group input:focus, .form-group select:focus, .form-group textarea:focus {
    border-color: #0066cc;
    outline: none;
}

.form-group textarea {
    min-height: 80px;
    resize: vertical;
}

.image-upload-container {
    position: relative;
}

.image-preview {
    max-width: 200px;
    max-height: 150px;
    border-radius: 8px;
    margin-top: 10px;
    border: 2px solid #e0e0e0;
}

.image-url-input {
    width: 100%;
}

.upload-help {
    font-size: 12px;
    color: #666;
    margin-top: 5px;
}

.upload-options {
    margin-top: 10px;
}

.file-upload-area {
    margin-top: 10px;
}

.upload-zone {
    border: 2px dashed #ddd;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    background: #fafafa;
    transition: all 0.3s ease;
    cursor: pointer;
}

.upload-zone:hover {
    border-color: #0066cc;
    background: #f0f8ff;
}

.upload-zone.dragover {
    border-color: #28a745;
    background: #f0fff0;
    transform: scale(1.02);
}

.upload-icon {
    font-size: 32px;
    margin-bottom: 10px;
}

.upload-text {
    font-size: 14px;
    color: #666;
}

.upload-btn {
    background: none;
    border: none;
    color: #0066cc;
    text-decoration: underline;
    cursor: pointer;
    font-size: 14px;
}

.upload-btn:hover {
    color: #004499;
}

.upload-progress {
    margin-top: 10px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 5px;
}

.progress-bar {
    width: 100%;
    height: 8px;
    background: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 5px;
}

.progress-bar::after {
    content: '';
    display: block;
    height: 100%;
    background: linear-gradient(90deg, #28a745, #20c997);
    width: 0%;
    transition: width 0.3s ease;
    animation: progress-animation 2s infinite;
}

.progress-text {
    font-size: 12px;
    color: #666;
    text-align: center;
}

@keyframes progress-animation {
    0% { width: 0%; }
    50% { width: 70%; }
    100% { width: 100%; }
}

.btn-save {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    padding: 15px 40px;
    border: none;
    border-radius: 8px;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s;
    margin: 20px 0;
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.preview-section {
    background: linear-gradient(135deg, #e9ecef, #f8f9fa);
    padding: 30px;
    border-radius: 12px;
    margin: 30px 0;
}

.preview-carousel {
    position: relative;
    overflow: hidden;
    border-radius: 12px;
}

.preview-cards-container {
    display: flex;
    transition: transform 0.4s ease;
    gap: 20px;
}

.preview-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    min-width: 320px;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.preview-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    border-color: #0066cc;
}

.carousel-nav {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 20px;
}

.carousel-btn {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 3px 10px rgba(0, 102, 204, 0.3);
}

.carousel-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 102, 204, 0.4);
}

.carousel-btn:disabled {
    background: #6c757d;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.preview-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin: 10px;
    display: inline-block;
    width: 280px;
    vertical-align: top;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.preview-date {
    background: #28a745;
    color: white;
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: bold;
    display: inline-block;
    margin-bottom: 10px;
}

.preview-title {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 10px;
    color: #333;
}

.preview-details {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    margin-bottom: 15px;
}

.preview-modalidad {
    background: #e9ecef;
    padding: 3px 8px;
    border-radius: 8px;
}

.preview-plazas {
    background: #fff3cd;
    padding: 3px 8px;
    border-radius: 8px;
}

.preview-description {
    font-size: 13px;
    color: #666;
    margin: 10px 0;
    line-height: 1.4;
    font-style: italic;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .preview-card {
        width: 100%;
        margin: 10px 0;
    }
}
</style>

<div class="form-container">
    <div class="courses-tabs">
        <?php for ($i = 1; $i <= 6; $i++): ?>
            <button class="tab-button <?php echo $i === 1 ? 'active' : ''; ?>" onclick="showCourse(<?php echo $i; ?>)">
                📚 Curso <?php echo $i; ?>
            </button>
        <?php endfor; ?>
    </div>

    <form method="post">
        <?php for ($i = 1; $i <= 6; $i++): ?>
            <div class="course-section <?php echo $i === 1 ? 'active' : ''; ?>" id="course-<?php echo $i; ?>">
                <h3>📚 Curso <?php echo $i; ?></h3>
                <div class="form-row">
                    <div class="form-group">
                        <label>Nombre del Curso:</label>
                        <input type="text" name="course_<?php echo $i; ?>_name" value="<?php echo esc_attr($cursos[$i]['name']); ?>" placeholder="Nombre del curso...">
                    </div>
                    <div class="form-group">
                        <label>Fecha de Inicio:</label>
                        <input type="text" name="course_<?php echo $i; ?>_date" value="<?php echo esc_attr($cursos[$i]['date']); ?>" placeholder="Ej: Enero 2025">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Modalidad:</label>
                        <select name="course_<?php echo $i; ?>_modality">
                            <option value="Presencial" <?php selected($cursos[$i]['modality'], 'Presencial'); ?>>Presencial</option>
                            <option value="Online" <?php selected($cursos[$i]['modality'], 'Online'); ?>>Online</option>
                            <option value="Semipresencial" <?php selected($cursos[$i]['modality'], 'Semipresencial'); ?>>Semipresencial</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Plazas/Duración:</label>
                        <input type="text" name="course_<?php echo $i; ?>_duration" value="<?php echo esc_attr($cursos[$i]['duration']); ?>" placeholder="Ej: 15 plazas">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>📝 Descripción del Curso:</label>
                        <textarea name="course_<?php echo $i; ?>_description" placeholder="Describe brevemente el contenido y objetivos del curso..."><?php echo esc_textarea($cursos[$i]['description']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>🖼️ Imagen del Curso:</label>
                        <div class="image-upload-container">
                            <input type="url" name="course_<?php echo $i; ?>_image" value="<?php echo esc_attr($cursos[$i]['image']); ?>" placeholder="https://ejemplo.com/imagen.jpg" class="image-url-input">
                            <?php if ($cursos[$i]['image']): ?>
                                <img src="<?php echo esc_url($cursos[$i]['image']); ?>" alt="Vista previa" class="image-preview" onerror="this.style.display='none'">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endfor; ?>

        <div style="text-align: center;">
            <button type="submit" name="guardar_cursos" class="btn-save">💾 Guardar Todos los Cursos</button>
        </div>
    </form>
</div>
        
        <div class="course-section">
            <h3>📚 Curso 1</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>Nombre del Curso:</label>
                    <input type="text" name="course_1_name" value="<?php echo esc_attr($curso1_nombre); ?>" required>
                </div>
                <div class="form-group">
                    <label>Fecha de Inicio:</label>
                    <input type="text" name="course_1_date" value="<?php echo esc_attr($curso1_fecha); ?>" placeholder="Ej: Enero 2025">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Modalidad:</label>
                    <select name="course_1_modality">
                        <option value="Presencial" <?php selected($curso1_modalidad, 'Presencial'); ?>>Presencial</option>
                        <option value="Online" <?php selected($curso1_modalidad, 'Online'); ?>>Online</option>
                        <option value="Semipresencial" <?php selected($curso1_modalidad, 'Semipresencial'); ?>>Semipresencial</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Plazas/Duración:</label>
                    <input type="text" name="course_1_duration" value="<?php echo esc_attr($curso1_duracion); ?>" placeholder="Ej: 15 plazas">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>📝 Descripción del Curso:</label>
                    <textarea name="course_1_description" placeholder="Describe brevemente el contenido y objetivos del curso..."><?php echo esc_textarea($curso1_descripcion); ?></textarea>
                </div>
                <div class="form-group">
                    <label>🖼️ Imagen del Curso:</label>
                    <div class="image-upload-container">
                        <input type="url" name="course_1_image" value="<?php echo esc_attr($curso1_imagen); ?>" placeholder="https://ejemplo.com/imagen.jpg" class="image-url-input">
                        
                        <div class="upload-options">
                            <div class="upload-help">💡 Pega una URL o sube tu imagen:</div>
                            
                            <div class="file-upload-area" data-course="1">
                                <div class="upload-zone">
                                    <div class="upload-icon">📁</div>
                                    <div class="upload-text">
                                        <strong>Arrastra tu imagen aquí</strong><br>
                                        o <button type="button" class="upload-btn">selecciona archivo</button>
                                    </div>
                                    <input type="file" class="file-input" accept="image/*" style="display: none;">
                                </div>
                                <div class="upload-progress" style="display: none;">
                                    <div class="progress-bar"></div>
                                    <div class="progress-text">Subiendo...</div>
                                </div>
                            </div>
                        </div>
                        
                        <?php if ($curso1_imagen): ?>
                            <img src="<?php echo esc_url($curso1_imagen); ?>" alt="Vista previa" class="image-preview" onerror="this.style.display='none'">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="course-section">
            <h3>📚 Curso 2</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>Nombre del Curso:</label>
                    <input type="text" name="course_2_name" value="<?php echo esc_attr($curso2_nombre); ?>">
                </div>
                <div class="form-group">
                    <label>Fecha de Inicio:</label>
                    <input type="text" name="course_2_date" value="<?php echo esc_attr($curso2_fecha); ?>" placeholder="Ej: Febrero 2025">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Modalidad:</label>
                    <select name="course_2_modality">
                        <option value="Presencial" <?php selected($curso2_modalidad, 'Presencial'); ?>>Presencial</option>
                        <option value="Online" <?php selected($curso2_modalidad, 'Online'); ?>>Online</option>
                        <option value="Semipresencial" <?php selected($curso2_modalidad, 'Semipresencial'); ?>>Semipresencial</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Plazas/Duración:</label>
                    <input type="text" name="course_2_duration" value="<?php echo esc_attr($curso2_duracion); ?>" placeholder="Ej: 12 plazas">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>📝 Descripción del Curso:</label>
                    <textarea name="course_2_description" placeholder="Describe brevemente el contenido y objetivos del curso..."><?php echo esc_textarea($curso2_descripcion); ?></textarea>
                </div>
                <div class="form-group">
                    <label>🖼️ Imagen del Curso:</label>
                    <div class="image-upload-container">
                        <input type="url" name="course_2_image" value="<?php echo esc_attr($curso2_imagen); ?>" placeholder="https://ejemplo.com/imagen.jpg" class="image-url-input">
                        
                        <div class="upload-options">
                            <div class="upload-help">💡 Pega una URL o sube tu imagen:</div>
                            
                            <div class="file-upload-area" data-course="2">
                                <div class="upload-zone">
                                    <div class="upload-icon">📁</div>
                                    <div class="upload-text">
                                        <strong>Arrastra tu imagen aquí</strong><br>
                                        o <button type="button" class="upload-btn">selecciona archivo</button>
                                    </div>
                                    <input type="file" class="file-input" accept="image/*" style="display: none;">
                                </div>
                                <div class="upload-progress" style="display: none;">
                                    <div class="progress-bar"></div>
                                    <div class="progress-text">Subiendo...</div>
                                </div>
                            </div>
                        </div>
                        
                        <?php if ($curso2_imagen): ?>
                            <img src="<?php echo esc_url($curso2_imagen); ?>" alt="Vista previa" class="image-preview" onerror="this.style.display='none'">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="course-section">
            <h3>📚 Curso 3</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>Nombre del Curso:</label>
                    <input type="text" name="course_3_name" value="<?php echo esc_attr($curso3_nombre); ?>">
                </div>
                <div class="form-group">
                    <label>Fecha de Inicio:</label>
                    <input type="text" name="course_3_date" value="<?php echo esc_attr($curso3_fecha); ?>" placeholder="Ej: Marzo 2025">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Modalidad:</label>
                    <select name="course_3_modality">
                        <option value="Presencial" <?php selected($curso3_modalidad, 'Presencial'); ?>>Presencial</option>
                        <option value="Online" <?php selected($curso3_modalidad, 'Online'); ?>>Online</option>
                        <option value="Semipresencial" <?php selected($curso3_modalidad, 'Semipresencial'); ?>>Semipresencial</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Plazas/Duración:</label>
                    <input type="text" name="course_3_duration" value="<?php echo esc_attr($curso3_duracion); ?>" placeholder="Ej: 10 plazas">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>📝 Descripción del Curso:</label>
                    <textarea name="course_3_description" placeholder="Describe brevemente el contenido y objetivos del curso..."><?php echo esc_textarea($curso3_descripcion); ?></textarea>
                </div>
                <div class="form-group">
                    <label>🖼️ Imagen del Curso:</label>
                    <div class="image-upload-container">
                        <input type="url" name="course_3_image" value="<?php echo esc_attr($curso3_imagen); ?>" placeholder="https://ejemplo.com/imagen.jpg" class="image-url-input">
                        
                        <div class="upload-options">
                            <div class="upload-help">💡 Pega una URL o sube tu imagen:</div>
                            
                            <div class="file-upload-area" data-course="3">
                                <div class="upload-zone">
                                    <div class="upload-icon">📁</div>
                                    <div class="upload-text">
                                        <strong>Arrastra tu imagen aquí</strong><br>
                                        o <button type="button" class="upload-btn">selecciona archivo</button>
                                    </div>
                                    <input type="file" class="file-input" accept="image/*" style="display: none;">
                                </div>
                                <div class="upload-progress" style="display: none;">
                                    <div class="progress-bar"></div>
                                    <div class="progress-text">Subiendo...</div>
                                </div>
                            </div>
                        </div>
                        
                        <?php if ($curso3_imagen): ?>
                            <img src="<?php echo esc_url($curso3_imagen); ?>" alt="Vista previa" class="image-preview" onerror="this.style.display='none'">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

<div class="preview-section">
    <h3>👀 Vista Previa con Carrusel:</h3>
    
    <div class="preview-carousel">
        <div class="preview-cards-container" id="preview-container">
            <?php 
            $cursos_activos = array_filter($cursos, function($curso) {
                return !empty($curso['name']);
            });
            
            foreach ($cursos_activos as $index => $curso): 
            ?>
                <div class="preview-card">
                    <div class="preview-date"><?php echo esc_html($curso['date']); ?></div>
                    <div class="preview-title"><?php echo esc_html($curso['name']); ?></div>
                    <?php if ($curso['description']): ?>
                        <div class="preview-description"><?php echo esc_html($curso['description']); ?></div>
                    <?php endif; ?>
                    <div class="preview-details">
                        <span class="preview-modalidad"><?php echo esc_html($curso['modality']); ?></span>
                        <span class="preview-plazas"><?php echo esc_html($curso['duration']); ?></span>
                    </div>
                    <?php if ($curso['image']): ?>
                        <img src="<?php echo esc_url($curso['image']); ?>" alt="<?php echo esc_attr($curso['name']); ?>" style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px; margin: 10px 0;" onerror="this.style.display='none'">
                    <?php endif; ?>
                    <button style="background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 10px 20px; border: none; border-radius: 20px; font-size: 14px; font-weight: 600; width: 100%;">Reservar Plaza</button>
                </div>
            <?php endforeach; ?>
        </div>
        
        <?php if (count($cursos_activos) > 3): ?>
        <div class="carousel-nav">
            <button class="carousel-btn" onclick="prevSlide()">← Anterior</button>
            <button class="carousel-btn" onclick="nextSlide()">Siguiente →</button>
        </div>
        <?php endif; ?>
    </div>
</div>
<div style="text-align: center; margin: 30px 0;">
    <a href="<?php echo home_url('/anuncios'); ?>" style="background: #0066cc; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 5px; font-weight: 600;">👀 Ver Página de Cursos</a>
    <a href="<?php echo home_url('/panel-mailing-completo.php'); ?>" style="background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 5px; font-weight: 600; box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);">📧 Sistema de Mailing</a>
    <a href="<?php echo admin_url(); ?>" style="background: #6c757d; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 5px; font-weight: 600;">🏠 Volver a WordPress</a>
</div>

<div style="background: #d1ecf1; color: #0c5460; padding: 20px; border-radius: 8px; margin: 20px 0;">
    <h3>📋 Instrucciones:</h3>
    <p>1. <strong>Modifica los cursos</strong> usando este formulario</p>
    <p>2. <strong>Haz clic en "Guardar Cursos"</strong> para aplicar los cambios</p>
    <p>3. <strong>Los cambios aparecerán inmediatamente</strong> en la página /anuncios</p>
    <p>4. <strong>Para las imágenes:</strong> Puedes usar URLs de imágenes de internet o subir imágenes a tu WordPress y copiar la URL</p>
    <p>5. <strong>Guarda esta URL</strong> para gestionar los cursos fácilmente: <code><?php echo home_url('/gestionar-proximos-cursos.php'); ?></code></p>
</div>

<script>
// Vista previa de imágenes en tiempo real
document.addEventListener('DOMContentLoaded', function() {
    const imageInputs = document.querySelectorAll('input[name*="_image"]');
    
    imageInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            const url = this.value;
            const container = this.parentElement;
            let preview = container.querySelector('.image-preview');
            
            if (url && url.match(/\.(jpeg|jpg|gif|png|webp)$/i)) {
                if (!preview) {
                    preview = document.createElement('img');
                    preview.className = 'image-preview';
                    preview.alt = 'Vista previa';
                    preview.onerror = function() { this.style.display = 'none'; };
                    container.appendChild(preview);
                }
                preview.src = url;
                preview.style.display = 'block';
            } else if (preview) {
                preview.style.display = 'none';
            }
        });
    });

    // Funcionalidad de drag & drop y subida de archivos
    const uploadAreas = document.querySelectorAll('.file-upload-area');
    
    uploadAreas.forEach(function(area) {
        const courseNum = area.dataset.course;
        const uploadZone = area.querySelector('.upload-zone');
        const fileInput = area.querySelector('.file-input');
        const uploadBtn = area.querySelector('.upload-btn');
        const progressDiv = area.querySelector('.upload-progress');
        const urlInput = document.querySelector(`input[name="course_${courseNum}_image"]`);
        
        // Click en botón para seleccionar archivo
        uploadBtn.addEventListener('click', function(e) {
            e.preventDefault();
            fileInput.click();
        });
        
        // Click en zona de upload
        uploadZone.addEventListener('click', function() {
            fileInput.click();
        });
        
        // Cambio en input de archivo
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                uploadFile(this.files[0], courseNum, urlInput, progressDiv);
            }
        });
        
        // Drag & Drop
        uploadZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });
        
        uploadZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });
        
        uploadZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files && files[0]) {
                uploadFile(files[0], courseNum, urlInput, progressDiv);
            }
        });
    });
    
    function uploadFile(file, courseNum, urlInput, progressDiv) {
        // Validar tipo de archivo
        if (!file.type.match(/^image\/(jpeg|jpg|png|gif|webp)$/)) {
            alert('Por favor selecciona una imagen válida (JPG, PNG, GIF, WebP)');
            return;
        }
        
        // Validar tamaño (5MB máximo)
        if (file.size > 5 * 1024 * 1024) {
            alert('La imagen es demasiado grande. Máximo 5MB');
            return;
        }
        
        // Mostrar progreso
        progressDiv.style.display = 'block';
        
        // Crear FormData
        const formData = new FormData();
        formData.append('image', file);
        
        // Subir archivo
        fetch('<?php echo home_url('/subir-imagen-curso.php'); ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            progressDiv.style.display = 'none';
            
            if (data.success) {
                // Actualizar campo URL
                urlInput.value = data.url;
                
                // Disparar evento para mostrar vista previa
                urlInput.dispatchEvent(new Event('input'));
                
                // Mostrar mensaje de éxito
                showMessage('✅ Imagen subida correctamente', 'success');
            } else {
                showMessage('❌ Error: ' + data.error, 'error');
            }
        })
        .catch(error => {
            progressDiv.style.display = 'none';
            showMessage('❌ Error al subir la imagen', 'error');
            console.error('Error:', error);
        });
    }
    
    function showMessage(message, type) {
        const messageDiv = document.createElement('div');
        messageDiv.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            z-index: 10000;
            animation: slideIn 0.3s ease;
            ${type === 'success' ? 'background: #28a745;' : 'background: #dc3545;'}
        `;
        messageDiv.textContent = message;
        
        document.body.appendChild(messageDiv);
        
        setTimeout(() => {
            messageDiv.remove();
        }, 4000);
    }
});

// Añadir animación CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
`;
document.head.appendChild(style);
</script>

<script>
// Funcionalidad de pestañas
function showCourse(courseNum) {
    // Ocultar todas las secciones
    document.querySelectorAll('.course-section').forEach(section => {
        section.classList.remove('active');
    });
    
    // Ocultar todos los botones activos
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active');
    });
    
    // Mostrar la sección seleccionada
    document.getElementById('course-' + courseNum).classList.add('active');
    
    // Activar el botón correspondiente
    event.target.classList.add('active');
}

// Funcionalidad del carrusel de vista previa
let currentSlide = 0;
const cardsPerView = 3;

function nextSlide() {
    const container = document.getElementById('preview-container');
    const cards = container.children;
    const totalCards = cards.length;
    
    if (currentSlide < totalCards - cardsPerView) {
        currentSlide++;
        updateCarousel();
    }
}

function prevSlide() {
    if (currentSlide > 0) {
        currentSlide--;
        updateCarousel();
    }
}

function updateCarousel() {
    const container = document.getElementById('preview-container');
    const cardWidth = 340; // 320px + 20px gap
    const translateX = -currentSlide * cardWidth;
    
    container.style.transform = `translateX(${translateX}px)`;
    
    // Actualizar estado de los botones
    const prevBtn = document.querySelector('.carousel-btn');
    const nextBtn = document.querySelectorAll('.carousel-btn')[1];
    
    if (prevBtn && nextBtn) {
        prevBtn.disabled = currentSlide === 0;
        nextBtn.disabled = currentSlide >= container.children.length - cardsPerView;
    }
}

// Inicializar carrusel
document.addEventListener('DOMContentLoaded', function() {
    updateCarousel();
});
</script>

<div style="background: #d1ecf1; color: #0c5460; padding: 25px; border-radius: 12px; margin: 30px 0;">
    <h3>📋 Instrucciones del Gestor Actualizado:</h3>
    <p><strong>✨ Nuevas características:</strong></p>
    <ul>
        <li>🎯 <strong>Hasta 6 cursos:</strong> Ahora puedes gestionar hasta 6 cursos diferentes</li>
        <li>📑 <strong>Pestañas organizadas:</strong> Cada curso tiene su propia pestaña para fácil navegación</li>
        <li>🎠 <strong>Vista previa con carrusel:</strong> Si hay más de 3 cursos, se activa automáticamente el carrusel</li>
        <li>🔄 <strong>Navegación fluida:</strong> Flechas para navegar entre cursos en la vista previa</li>
        <li>💾 <strong>Guardado masivo:</strong> Un solo botón guarda todos los cursos a la vez</li>
        <li>🔗 <strong>Integración perfecta:</strong> Funciona con el carrusel de la página principal</li>
    </ul>
    <p><strong>🚀 Cómo usar:</strong></p>
    <ol>
        <li>Haz clic en las pestañas "Curso 1", "Curso 2", etc. para editar cada curso</li>
        <li>Rellena la información de cada curso que quieras mostrar</li>
        <li>Los cursos vacíos no se mostrarán en la página</li>
        <li>Haz clic en "Guardar Todos los Cursos" para aplicar cambios</li>
        <li>La vista previa te muestra cómo se verá el carrusel</li>
<div style="background: #d1ecf1; color: #0c5460; padding: 25px; border-radius: 12px; margin: 30px 0;">
    <h3>📋 Instrucciones del Gestor Actualizado:</h3>
    <p><strong>✨ Nuevas características:</strong></p>
    <ul>
        <li>🎯 <strong>Hasta 6 cursos:</strong> Ahora puedes gestionar hasta 6 cursos diferentes</li>
        <li>📑 <strong>Pestañas organizadas:</strong> Cada curso tiene su propia pestaña para fácil navegación</li>
        <li>🎠 <strong>Vista previa con carrusel:</strong> Si hay más de 3 cursos, se activa automáticamente el carrusel</li>
        <li>🔄 <strong>Navegación fluida:</strong> Flechas para navegar entre cursos en la vista previa</li>
        <li>💾 <strong>Guardado masivo:</strong> Un solo botón guarda todos los cursos a la vez</li>
        <li>🔗 <strong>Integración perfecta:</strong> Funciona con el carrusel de la página principal</li>
        <li>📧 <strong>Sistema de Mailing:</strong> Envía correos masivos a usuarios y suscriptores</li>
    </ul>
    <p><strong>🚀 Cómo usar:</strong></p>
    <ol>
        <li>Haz clic en las pestañas "Curso 1", "Curso 2", etc. para editar cada curso</li>
        <li>Rellena la información de cada curso que quieras mostrar</li>
        <li>Los cursos vacíos no se mostrarán en la página</li>
        <li>Haz clic en "Guardar Todos los Cursos" para aplicar cambios</li>
        <li>La vista previa te muestra cómo se verá el carrusel</li>
        <li>Si tienes más de 3 cursos, aparecerá automáticamente el carrusel en la página</li>
        <li><strong>📧 Usa el Sistema de Mailing</strong> para enviar información de cursos por correo</li>
    </ol>
    <p><strong>🎯 Resultado:</strong> Los cursos aparecerán automáticamente en la página principal con carrusel si hay más de 3, o en grid normal si hay 3 o menos.</p>
    
    <div style="background: #e3f2fd; padding: 15px; border-radius: 8px; margin: 15px 0;">
        <h4>📧 Sistema de Mailing Integrado:</h4>
        <p>• <strong>Envío masivo:</strong> A usuarios WordPress, suscriptores MailPoet o listas personalizadas</p>
        <p>• <strong>Plantillas predefinidas:</strong> Para nuevos cursos, recordatorios, promociones y newsletters</p>
        <p>• <strong>Variables automáticas:</strong> Usa [PROXIMOS_CURSOS] para incluir la lista de cursos</p>
        <p>• <strong>Estadísticas en tiempo real:</strong> Ve cuántos usuarios y suscriptores tienes</p>
    </div>
</div>
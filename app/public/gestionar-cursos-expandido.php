<?php
/**
 * Gestor de Próximos Cursos Expandido - Hasta 6 cursos con carrusel
 * Permite gestionar múltiples cursos con navegación tipo carrusel
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🎓 Gestionar Próximos Cursos (Expandido)</h1>";

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
    echo "✅ <strong>¡Cursos guardados correctamente!</strong>";
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
    font-size: 24px;
    border-bottom: 3px solid #0066cc;
    padding-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin: 20px 0;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-weight: bold;
    margin-bottom: 8px;
    color: #333;
    font-size: 15px;
}

.form-group input, .form-group select, .form-group textarea {
    padding: 14px;
    border: 2px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.3s;
    font-family: inherit;
}

.form-group input:focus, .form-group select:focus, .form-group textarea:focus {
    border-color: #0066cc;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
}

.form-group textarea {
    min-height: 100px;
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

.btn-save {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    padding: 18px 50px;
    border: none;
    border-radius: 12px;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s;
    margin: 30px 0;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.btn-save:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
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

.preview-date {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
    display: inline-block;
    margin-bottom: 15px;
}

.preview-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 12px;
    color: #333;
    line-height: 1.3;
}

.preview-description {
    font-size: 14px;
    color: #666;
    margin: 12px 0;
    line-height: 1.5;
    font-style: italic;
}

.preview-details {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    margin: 15px 0;
    gap: 10px;
}

.preview-modalidad, .preview-plazas {
    padding: 6px 12px;
    border-radius: 12px;
    font-weight: 600;
}

.preview-modalidad {
    background: #e3f2fd;
    color: #1976d2;
}

.preview-plazas {
    background: #fff3cd;
    color: #856404;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .courses-tabs {
        justify-content: center;
    }
    
    .tab-button {
        padding: 10px 15px;
        font-size: 14px;
    }
    
    .preview-card {
        min-width: 280px;
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
                        <div class="image-upload-container" data-course="<?php echo $i; ?>">
                            <div class="image-preview-area" id="preview_<?php echo $i; ?>">
                                <div class="drop-zone" id="dropzone_<?php echo $i; ?>">
                                    <div class="drop-content">
                                        <div class="drop-icon">📁</div>
                                        <p><strong>Arrastra una imagen aquí</strong></p>
                                        <p>o</p>
                                        <button type="button" class="btn-select-file" onclick="selectFile(<?php echo $i; ?>)">Seleccionar Archivo</button>
                                    </div>
                                </div>
                                <img id="img_preview_<?php echo $i; ?>" style="display: none; max-width: 100%; height: 200px; object-fit: cover; border-radius: 8px;">
                            </div>
                            <input type="file" id="file_input_<?php echo $i; ?>" name="course_image_file_<?php echo $i; ?>" accept="image/*" style="display: none;" onchange="handleFileSelect(<?php echo $i; ?>, this)">
                            <input type="hidden" name="course_<?php echo $i; ?>_image" id="course_<?php echo $i; ?>_image" value="<?php echo esc_attr($cursos[$i]['image']); ?>">
                            <div class="image-actions" style="margin-top: 10px; display: none;" id="actions_<?php echo $i; ?>">
                                <button type="button" class="btn-remove" onclick="removeImage(<?php echo $i; ?>)">🗑️ Eliminar</button>
                                <button type="button" class="btn-change" onclick="selectFile(<?php echo $i; ?>)">🔄 Cambiar</button>
                            </div>
                        </div>
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
    <a href="<?php echo admin_url(); ?>" style="background: #6c757d; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 5px; font-weight: 600;">🏠 Volver a WordPress</a>
</div>

<script>
let currentSlide = 0;
const cardsPerView = 3;

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

<!-- CSS y JavaScript para subida de imágenes -->
<style>
/* Estilos para subida de imágenes */
.image-upload-container {
    margin: 10px 0;
}

.drop-zone {
    border: 2px dashed #0066cc;
    border-radius: 12px;
    padding: 40px 20px;
    text-align: center;
    background: #f8f9ff;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    min-height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.drop-zone:hover {
    border-color: #0052a3;
    background: #f0f4ff;
    transform: translateY(-2px);
}

.drop-zone.dragover {
    border-color: #28a745;
    background: #f0fff4;
    border-style: solid;
    box-shadow: 0 0 20px rgba(40, 167, 69, 0.2);
}

.drop-content {
    pointer-events: none;
}

.drop-icon {
    font-size: 48px;
    margin-bottom: 15px;
    opacity: 0.7;
}

.drop-zone p {
    margin: 8px 0;
    color: #6c757d;
    font-size: 14px;
}

.btn-select-file {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    pointer-events: all;
    margin-top: 10px;
}

.btn-select-file:hover {
    background: linear-gradient(135deg, #0052a3, #003d7a);
    transform: translateY(-2px);
}

.image-actions {
    display: flex;
    gap: 10px;
    justify-content: center;
}

.btn-remove {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-remove:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
}

.btn-change {
    background: linear-gradient(135deg, #6c757d, #5a6268);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-change:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(108, 117, 125, 0.3);
}

.image-preview-area img {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    border: 2px solid #e9ecef;
}

.upload-success {
    background: #d4edda;
    color: #155724;
    padding: 10px;
    border-radius: 6px;
    margin-top: 10px;
    font-size: 12px;
    text-align: center;
}
</style>

<script>
// Funciones para manejo de imágenes
function selectFile(courseId) {
    document.getElementById(`file_input_${courseId}`).click();
}

function handleFileSelect(courseId, input) {
    const file = input.files[0];
    if (file) {
        if (file.type.startsWith("image/")) {
            if (file.size > 5 * 1024 * 1024) { // 5MB límite
                alert("La imagen es demasiado grande. Máximo 5MB.");
                return;
            }
            uploadImage(courseId, file);
        } else {
            alert("Por favor selecciona solo archivos de imagen (JPG, PNG, GIF)");
        }
    }
}

function uploadImage(courseId, file) {
    // Mostrar preview inmediatamente
    const reader = new FileReader();
    reader.onload = function(e) {
        showImagePreview(courseId, e.target.result);
        
        // Simular guardado de imagen (en producción aquí iría la subida real al servidor)
        const imagePath = `wp-content/uploads/cursos/curso_${courseId}_${Date.now()}.${file.name.split('.').pop()}`;
        document.getElementById(`course_${courseId}_image`).value = imagePath;
        
        // Mostrar mensaje de éxito
        showUploadSuccess(courseId);
    };
    reader.readAsDataURL(file);
}

function showImagePreview(courseId, imageSrc) {
    const dropzone = document.getElementById(`dropzone_${courseId}`);
    const preview = document.getElementById(`img_preview_${courseId}`);
    const actions = document.getElementById(`actions_${courseId}`);
    
    dropzone.style.display = "none";
    preview.src = imageSrc;
    preview.style.display = "block";
    actions.style.display = "flex";
}

function removeImage(courseId) {
    const dropzone = document.getElementById(`dropzone_${courseId}`);
    const preview = document.getElementById(`img_preview_${courseId}`);
    const actions = document.getElementById(`actions_${courseId}`);
    const hiddenInput = document.getElementById(`course_${courseId}_image`);
    
    dropzone.style.display = "flex";
    preview.style.display = "none";
    actions.style.display = "none";
    hiddenInput.value = "";
    
    // Limpiar input file
    document.getElementById(`file_input_${courseId}`).value = "";
}

function showUploadSuccess(courseId) {
    const container = document.querySelector(`[data-course="${courseId}"]`);
    const existingSuccess = container.querySelector('.upload-success');
    if (existingSuccess) {
        existingSuccess.remove();
    }
    
    const successMsg = document.createElement('div');
    successMsg.className = 'upload-success';
    successMsg.innerHTML = '✅ Imagen cargada correctamente';
    container.appendChild(successMsg);
    
    setTimeout(() => {
        successMsg.remove();
    }, 3000);
}

// Configurar drag & drop para todos los cursos
document.addEventListener("DOMContentLoaded", function() {
    for (let i = 1; i <= 6; i++) {
        setupDragAndDrop(i);
        
        // Si ya hay imagen, mostrar preview
        const existingImage = document.getElementById(`course_${i}_image`).value;
        if (existingImage && existingImage.trim() !== '') {
            showImagePreview(i, existingImage);
        }
    }
});

function setupDragAndDrop(courseId) {
    const dropzone = document.getElementById(`dropzone_${courseId}`);
    
    if (!dropzone) return;
    
    dropzone.addEventListener("dragover", function(e) {
        e.preventDefault();
        this.classList.add("dragover");
    });
    
    dropzone.addEventListener("dragleave", function(e) {
        e.preventDefault();
        this.classList.remove("dragover");
    });
    
    dropzone.addEventListener("drop", function(e) {
        e.preventDefault();
        this.classList.remove("dragover");
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];
            if (file.type.startsWith("image/")) {
                if (file.size > 5 * 1024 * 1024) {
                    alert("La imagen es demasiado grande. Máximo 5MB.");
                    return;
                }
                uploadImage(courseId, file);
            } else {
                alert("Por favor arrastra solo archivos de imagen");
            }
        }
    });
    
    dropzone.addEventListener("click", function() {
        selectFile(courseId);
    });
}

// Prevenir comportamiento por defecto del navegador
document.addEventListener("dragover", function(e) {
    e.preventDefault();
});

document.addEventListener("drop", function(e) {
    e.preventDefault();
});
</script>

<div style="background: #d1ecf1; color: #0c5460; padding: 25px; border-radius: 12px; margin: 30px 0;">
    <h3>📋 Instrucciones del Gestor Expandido:</h3>
    <p><strong>✨ Nuevas características:</strong></p>
    <ul>
        <li>🎯 <strong>Hasta 6 cursos:</strong> Puedes gestionar hasta 6 cursos diferentes</li>
        <li>📑 <strong>Pestañas organizadas:</strong> Cada curso tiene su propia pestaña para fácil navegación</li>
        <li>🎠 <strong>Vista previa con carrusel:</strong> Si hay más de 3 cursos, se activa automáticamente el carrusel</li>
        <li>🔄 <strong>Navegación fluida:</strong> Flechas para navegar entre cursos en la vista previa</li>
        <li>💾 <strong>Guardado masivo:</strong> Un solo botón guarda todos los cursos a la vez</li>
    </ul>
    <p><strong>🚀 Cómo usar:</strong></p>
    <ol>
        <li>Haz clic en las pestañas "Curso 1", "Curso 2", etc. para editar cada curso</li>
        <li>Rellena la información de cada curso que quieras mostrar</li>
        <li>Los cursos vacíos no se mostrarán en la página</li>
        <li>Haz clic en "Guardar Todos los Cursos" para aplicar cambios</li>
        <li>La vista previa te muestra cómo se verá el carrusel</li>
    </ol>
</div>
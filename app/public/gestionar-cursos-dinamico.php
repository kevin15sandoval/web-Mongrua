<?php
/**
 * Gestor de Cursos Dinámico - Mongruas Formación
 * Permite agregar, eliminar y gestionar cursos de forma dinámica
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🎓 Gestionar Cursos (Dinámico)</h1>";

// Procesar acciones
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'save_courses':
            // Guardar todos los cursos
            $courses_data = [];
            if (isset($_POST['courses'])) {
                foreach ($_POST['courses'] as $index => $course) {
                    $courses_data[] = [
                        'name' => sanitize_text_field($course['name']),
                        'date' => sanitize_text_field($course['date']),
                        'modality' => sanitize_text_field($course['modality']),
                        'duration' => sanitize_text_field($course['duration']),
                        'description' => sanitize_textarea_field($course['description']),
                        'image' => sanitize_text_field($course['image'])
                    ];
                }
            }
            update_option('mongruas_courses', $courses_data);
            echo "<div class='success-message'>✅ <strong>¡Cursos guardados correctamente!</strong></div>";
            break;
            
        case 'delete_course':
            $courses = get_option('mongruas_courses', []);
            $delete_index = intval($_POST['course_index']);
            if (isset($courses[$delete_index])) {
                unset($courses[$delete_index]);
                $courses = array_values($courses); // Reindexar array
                update_option('mongruas_courses', $courses);
                echo "<div class='success-message'>🗑️ <strong>Curso eliminado correctamente!</strong></div>";
            }
            break;
    }
}

// Obtener cursos actuales
$courses = get_option('mongruas_courses', []);

// Si no hay cursos, crear algunos por defecto
if (empty($courses)) {
    $courses = [
        ['name' => 'Montaje y Mantenimiento de Instalaciones Eléctricas', 'date' => 'Enero 2025', 'modality' => 'Presencial', 'duration' => '15 plazas', 'description' => 'Curso completo de instalaciones eléctricas de baja tensión con certificado oficial.', 'image' => ''],
        ['name' => 'Sistemas Domóticos e Inmóticos', 'date' => 'Febrero 2025', 'modality' => 'Presencial', 'duration' => '12 plazas', 'description' => 'Especialización en automatización de edificios y sistemas inteligentes.', 'image' => ''],
        ['name' => 'Control de Plagas', 'date' => 'Marzo 2025', 'modality' => 'Presencial', 'duration' => '10 plazas', 'description' => 'Formación profesional en control y prevención de plagas urbanas.', 'image' => '']
    ];
    update_option('mongruas_courses', $courses);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎓 Gestionar Cursos - Mongruas Formación</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            min-height: 100vh;
        }

        .header {
            background: linear-gradient(135deg, #0066cc, #0052a3);
            color: white;
            padding: 30px;
            border-radius: 16px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 8px 25px rgba(0, 102, 204, 0.3);
        }

        .header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 800;
        }

        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }

        .controls {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .btn {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(40, 167, 69, 0.4);
        }

        .btn-primary {
            background: linear-gradient(135deg, #0066cc, #0052a3);
            box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3);
        }

        .btn-primary:hover {
            box-shadow: 0 6px 16px rgba(0, 102, 204, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }

        .btn-danger:hover {
            box-shadow: 0 6px 16px rgba(220, 53, 69, 0.4);
        }

        .courses-container {
            display: grid;
            gap: 25px;
        }

        .course-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
        }

        .course-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f8f9fa;
        }

        .course-number {
            background: linear-gradient(135deg, #0066cc, #0052a3);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
        }

        .delete-btn {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .delete-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #0066cc;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
        }

        .form-group textarea {
            min-height: 80px;
            resize: vertical;
        }

        .image-upload-container {
            margin: 10px 0;
        }

        .drop-zone {
            border: 2px dashed #0066cc;
            border-radius: 12px;
            padding: 30px 20px;
            text-align: center;
            background: #f8f9ff;
            transition: all 0.3s ease;
            cursor: pointer;
            min-height: 100px;
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
            font-size: 32px;
            margin-bottom: 10px;
            opacity: 0.7;
        }

        .drop-zone p {
            margin: 5px 0;
            color: #6c757d;
            font-size: 13px;
        }

        .btn-select-file {
            background: linear-gradient(135deg, #0066cc, #0052a3);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 12px;
            transition: all 0.3s ease;
            pointer-events: all;
            margin-top: 8px;
        }

        .btn-select-file:hover {
            background: linear-gradient(135deg, #0052a3, #003d7a);
            transform: translateY(-1px);
        }

        .image-actions {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin-top: 10px;
        }

        .btn-remove, .btn-change {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 11px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-remove {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }

        .btn-change {
            background: linear-gradient(135deg, #6c757d, #5a6268);
            color: white;
        }

        .success-message {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            padding: 20px;
            border-radius: 12px;
            margin: 20px 0;
            text-align: center;
            font-weight: 600;
            border: 1px solid #c3e6cb;
        }

        .stats {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .stats-number {
            font-size: 32px;
            font-weight: 800;
            color: #0066cc;
            margin-bottom: 5px;
        }

        .stats-label {
            color: #6c757d;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .controls {
                justify-content: stretch;
            }
            
            .controls .btn {
                flex: 1;
                text-align: center;
            }
            
            .course-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎓 Gestionar Cursos</h1>
        <p>Agregar, eliminar y gestionar cursos de forma dinámica</p>
    </div>

    <div class="stats">
        <div class="stats-number"><?php echo count($courses); ?></div>
        <div class="stats-label">Cursos Activos</div>
    </div>

    <div class="controls">
        <button class="btn" onclick="addNewCourse()">➕ Agregar Nuevo Curso</button>
        <button class="btn btn-primary" onclick="saveAllCourses()">💾 Guardar Todos los Cursos</button>
        <button class="btn btn-danger" onclick="confirmDeleteAll()">🗑️ Eliminar Todos</button>
        <a href="<?php echo home_url('/panel-gestion-unificado.php'); ?>" class="btn" style="background: linear-gradient(135deg, #6c757d, #5a6268); color: white; text-decoration: none; display: inline-block;">🏠 Volver al Panel</a>
    </div>

    <form id="coursesForm" method="POST">
        <input type="hidden" name="action" value="save_courses">
        <div class="courses-container" id="coursesContainer">
            <?php foreach ($courses as $index => $course): ?>
                <div class="course-card" data-index="<?php echo $index; ?>">
                    <div class="course-header">
                        <div class="course-number"><?php echo $index + 1; ?></div>
                        <button type="button" class="delete-btn" onclick="deleteCourse(<?php echo $index; ?>)" title="Eliminar curso">🗑️</button>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label>📚 Nombre del Curso:</label>
                            <input type="text" name="courses[<?php echo $index; ?>][name]" value="<?php echo esc_attr($course['name']); ?>" placeholder="Nombre del curso" required>
                        </div>
                        
                        <div class="form-group">
                            <label>📅 Fecha de Inicio:</label>
                            <input type="text" name="courses[<?php echo $index; ?>][date]" value="<?php echo esc_attr($course['date']); ?>" placeholder="Enero 2025">
                        </div>
                        
                        <div class="form-group">
                            <label>🎯 Modalidad:</label>
                            <select name="courses[<?php echo $index; ?>][modality]">
                                <option value="Presencial" <?php selected($course['modality'], 'Presencial'); ?>>Presencial</option>
                                <option value="Online" <?php selected($course['modality'], 'Online'); ?>>Online</option>
                                <option value="Semipresencial" <?php selected($course['modality'], 'Semipresencial'); ?>>Semipresencial</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>👥 Plazas/Duración:</label>
                            <input type="text" name="courses[<?php echo $index; ?>][duration]" value="<?php echo esc_attr($course['duration']); ?>" placeholder="15 plazas">
                        </div>
                        
                        <div class="form-group full-width">
                            <label>📝 Descripción del Curso:</label>
                            <textarea name="courses[<?php echo $index; ?>][description]" placeholder="Describe brevemente el contenido y objetivos del curso..."><?php echo esc_textarea($course['description']); ?></textarea>
                        </div>
                        
                        <div class="form-group full-width">
                            <label>🖼️ Imagen del Curso:</label>
                            <div class="image-upload-container" data-course="<?php echo $index; ?>">
                                <div class="image-preview-area" id="preview_<?php echo $index; ?>">
                                    <div class="drop-zone" id="dropzone_<?php echo $index; ?>">
                                        <div class="drop-content">
                                            <div class="drop-icon">📁</div>
                                            <p><strong>Arrastra una imagen aquí</strong></p>
                                            <p>o</p>
                                            <button type="button" class="btn-select-file" onclick="selectFile(<?php echo $index; ?>)">Seleccionar Archivo</button>
                                        </div>
                                    </div>
                                    <img id="img_preview_<?php echo $index; ?>" style="display: none; max-width: 100%; height: 150px; object-fit: cover; border-radius: 8px;">
                                </div>
                                <input type="file" id="file_input_<?php echo $index; ?>" accept="image/*" style="display: none;" onchange="handleFileSelect(<?php echo $index; ?>, this)">
                                <input type="hidden" name="courses[<?php echo $index; ?>][image]" id="course_<?php echo $index; ?>_image" value="<?php echo esc_attr($course['image']); ?>">
                                <div class="image-actions" style="display: none;" id="actions_<?php echo $index; ?>">
                                    <button type="button" class="btn-remove" onclick="removeImage(<?php echo $index; ?>)">🗑️ Eliminar</button>
                                    <button type="button" class="btn-change" onclick="selectFile(<?php echo $index; ?>)">🔄 Cambiar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </form>

    <script>
        let courseIndex = <?php echo count($courses); ?>;

        function addNewCourse() {
            const container = document.getElementById('coursesContainer');
            const newCourseHtml = `
                <div class="course-card" data-index="${courseIndex}">
                    <div class="course-header">
                        <div class="course-number">${courseIndex + 1}</div>
                        <button type="button" class="delete-btn" onclick="deleteCourse(${courseIndex})" title="Eliminar curso">🗑️</button>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label>📚 Nombre del Curso:</label>
                            <input type="text" name="courses[${courseIndex}][name]" placeholder="Nombre del curso" required>
                        </div>
                        
                        <div class="form-group">
                            <label>📅 Fecha de Inicio:</label>
                            <input type="text" name="courses[${courseIndex}][date]" placeholder="Enero 2025">
                        </div>
                        
                        <div class="form-group">
                            <label>🎯 Modalidad:</label>
                            <select name="courses[${courseIndex}][modality]">
                                <option value="Presencial">Presencial</option>
                                <option value="Online">Online</option>
                                <option value="Semipresencial">Semipresencial</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>👥 Plazas/Duración:</label>
                            <input type="text" name="courses[${courseIndex}][duration]" placeholder="15 plazas">
                        </div>
                        
                        <div class="form-group full-width">
                            <label>📝 Descripción del Curso:</label>
                            <textarea name="courses[${courseIndex}][description]" placeholder="Describe brevemente el contenido y objetivos del curso..."></textarea>
                        </div>
                        
                        <div class="form-group full-width">
                            <label>🖼️ Imagen del Curso:</label>
                            <div class="image-upload-container" data-course="${courseIndex}">
                                <div class="image-preview-area" id="preview_${courseIndex}">
                                    <div class="drop-zone" id="dropzone_${courseIndex}">
                                        <div class="drop-content">
                                            <div class="drop-icon">📁</div>
                                            <p><strong>Arrastra una imagen aquí</strong></p>
                                            <p>o</p>
                                            <button type="button" class="btn-select-file" onclick="selectFile(${courseIndex})">Seleccionar Archivo</button>
                                        </div>
                                    </div>
                                    <img id="img_preview_${courseIndex}" style="display: none; max-width: 100%; height: 150px; object-fit: cover; border-radius: 8px;">
                                </div>
                                <input type="file" id="file_input_${courseIndex}" accept="image/*" style="display: none;" onchange="handleFileSelect(${courseIndex}, this)">
                                <input type="hidden" name="courses[${courseIndex}][image]" id="course_${courseIndex}_image" value="">
                                <div class="image-actions" style="display: none;" id="actions_${courseIndex}">
                                    <button type="button" class="btn-remove" onclick="removeImage(${courseIndex})">🗑️ Eliminar</button>
                                    <button type="button" class="btn-change" onclick="selectFile(${courseIndex})">🔄 Cambiar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', newCourseHtml);
            setupDragAndDrop(courseIndex);
            courseIndex++;
            updateStats();
            
            // Scroll al nuevo curso
            const newCourse = container.lastElementChild;
            newCourse.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        function deleteCourse(index) {
            if (confirm('¿Estás seguro de que quieres eliminar este curso?')) {
                const courseCard = document.querySelector(`[data-index="${index}"]`);
                courseCard.remove();
                updateCourseNumbers();
                updateStats();
            }
        }

        function confirmDeleteAll() {
            if (confirm('¿Estás seguro de que quieres eliminar TODOS los cursos? Esta acción no se puede deshacer.')) {
                document.getElementById('coursesContainer').innerHTML = '';
                courseIndex = 0;
                updateStats();
            }
        }

        function updateCourseNumbers() {
            const courseCards = document.querySelectorAll('.course-card');
            courseCards.forEach((card, index) => {
                const numberElement = card.querySelector('.course-number');
                numberElement.textContent = index + 1;
                
                // Actualizar índices en los inputs
                const inputs = card.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    if (input.name) {
                        input.name = input.name.replace(/courses\[\d+\]/, `courses[${index}]`);
                    }
                    if (input.id) {
                        input.id = input.id.replace(/_\d+_/, `_${index}_`);
                    }
                });
                
                card.setAttribute('data-index', index);
            });
        }

        function updateStats() {
            const count = document.querySelectorAll('.course-card').length;
            document.querySelector('.stats-number').textContent = count;
        }

        function saveAllCourses() {
            if (confirm('¿Guardar todos los cursos?')) {
                document.getElementById('coursesForm').submit();
            }
        }

        // Funciones para manejo de imágenes
        function selectFile(courseId) {
            document.getElementById(`file_input_${courseId}`).click();
        }

        function handleFileSelect(courseId, input) {
            const file = input.files[0];
            if (file) {
                if (file.type.startsWith("image/")) {
                    if (file.size > 5 * 1024 * 1024) {
                        alert("La imagen es demasiado grande. Máximo 5MB.");
                        return;
                    }
                    uploadImage(courseId, file);
                } else {
                    alert("Por favor selecciona solo archivos de imagen");
                }
            }
        }

        function uploadImage(courseId, file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                showImagePreview(courseId, e.target.result);
                const imagePath = `wp-content/uploads/cursos/curso_${courseId}_${Date.now()}.${file.name.split('.').pop()}`;
                document.getElementById(`course_${courseId}_image`).value = imagePath;
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
            
            document.getElementById(`file_input_${courseId}`).value = "";
        }

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

        // Configurar drag & drop para cursos existentes
        document.addEventListener("DOMContentLoaded", function() {
            <?php foreach ($courses as $index => $course): ?>
                setupDragAndDrop(<?php echo $index; ?>);
                <?php if (!empty($course['image'])): ?>
                    showImagePreview(<?php echo $index; ?>, '<?php echo esc_js($course['image']); ?>');
                <?php endif; ?>
            <?php endforeach; ?>
        });

        // Prevenir comportamiento por defecto del navegador
        document.addEventListener("dragover", e => e.preventDefault());
        document.addEventListener("drop", e => e.preventDefault());
    </script>
</body>
</html>
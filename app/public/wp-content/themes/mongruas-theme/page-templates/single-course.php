<?php
/**
 * Template para página individual de curso
 * 
 * @package Mongruas
 * @since 1.0.0
 */

// Obtener el ID del curso desde la URL
$course_id = isset($_GET['curso']) ? intval($_GET['curso']) : 1;

// Validar que el curso existe
if ($course_id < 1 || $course_id > 3) {
    $course_id = 1;
}

// Obtener datos del curso
$course_name = get_option("course_{$course_id}_name");
$course_date = get_option("course_{$course_id}_date");
$course_modality = get_option("course_{$course_id}_modality");
$course_duration = get_option("course_{$course_id}_duration");
$course_description = get_option("course_{$course_id}_description");
$course_image = get_option("course_{$course_id}_image");

// Si no hay datos, usar valores por defecto
if (!$course_name) {
    $defaults = [
        1 => [
            'name' => 'Montaje y Mantenimiento de Instalaciones Eléctricas',
            'date' => 'Enero 2025',
            'modality' => 'Presencial',
            'duration' => '15 plazas',
            'description' => 'Curso completo de instalaciones eléctricas de baja tensión con certificado oficial.',
            'image' => ''
        ],
        2 => [
            'name' => 'Sistemas Domóticos e Inmóticos',
            'date' => 'Febrero 2025',
            'modality' => 'Presencial',
            'duration' => '12 plazas',
            'description' => 'Especialización en automatización de edificios y sistemas inteligentes.',
            'image' => ''
        ],
        3 => [
            'name' => 'Control de Plagas',
            'date' => 'Marzo 2025',
            'modality' => 'Presencial',
            'duration' => '10 plazas',
            'description' => 'Formación profesional en control y prevención de plagas urbanas.',
            'image' => ''
        ]
    ];
    
    $default = $defaults[$course_id];
    $course_name = $default['name'];
    $course_date = $default['date'];
    $course_modality = $default['modality'];
    $course_duration = $default['duration'];
    $course_description = $default['description'];
    $course_image = $default['image'];
}

get_header(); ?>

<div class="single-course-container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="<?php echo home_url(); ?>">Inicio</a> > 
        <a href="<?php echo home_url('/anuncios'); ?>">Cursos</a> > 
        <span><?php echo esc_html($course_name); ?></span>
    </div>

    <!-- Hero del Curso -->
    <div class="course-hero">
        <?php if ($course_image): ?>
            <div class="course-hero-image">
                <img src="<?php echo esc_url($course_image); ?>" alt="<?php echo esc_attr($course_name); ?>">
            </div>
        <?php endif; ?>
        
        <div class="course-hero-content">
            <div class="course-badge">
                <span class="course-date-badge"><?php echo esc_html($course_date); ?></span>
            </div>
            
            <h1 class="course-title"><?php echo esc_html($course_name); ?></h1>
            
            <div class="course-meta">
                <div class="meta-item">
                    <span class="meta-icon">📅</span>
                    <span class="meta-label">Fecha de inicio:</span>
                    <span class="meta-value"><?php echo esc_html($course_date); ?></span>
                </div>
                
                <div class="meta-item">
                    <span class="meta-icon">🎓</span>
                    <span class="meta-label">Modalidad:</span>
                    <span class="meta-value"><?php echo esc_html($course_modality); ?></span>
                </div>
                
                <div class="meta-item">
                    <span class="meta-icon">👥</span>
                    <span class="meta-label">Plazas:</span>
                    <span class="meta-value"><?php echo esc_html($course_duration); ?></span>
                </div>
            </div>
            
            <div class="course-actions">
                <a href="<?php echo home_url('/contacto'); ?>" class="btn-primary">
                    📝 Reservar Plaza
                </a>
                <a href="<?php echo home_url('/anuncios'); ?>" class="btn-secondary">
                    ← Volver a Cursos
                </a>
            </div>
        </div>
    </div>

    <!-- Contenido del Curso -->
    <div class="course-content">
        <div class="course-main">
            <!-- Descripción -->
            <div class="course-section">
                <h2>📋 Descripción del Curso</h2>
                <div class="course-description-full">
                    <?php if ($course_description): ?>
                        <p><?php echo esc_html($course_description); ?></p>
                    <?php else: ?>
                        <p>Este curso está diseñado para proporcionar una formación completa y práctica en el área correspondiente, con certificación oficial y seguimiento personalizado.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Información Adicional -->
            <div class="course-section">
                <h2>ℹ️ Información Adicional</h2>
                <div class="course-info-grid">
                    <div class="info-card">
                        <h3>🎯 Objetivos</h3>
                        <ul>
                            <li>Adquirir competencias profesionales certificadas</li>
                            <li>Desarrollar habilidades prácticas del sector</li>
                            <li>Obtener certificación oficial reconocida</li>
                        </ul>
                    </div>
                    
                    <div class="info-card">
                        <h3>📚 Metodología</h3>
                        <ul>
                            <li>Formación teórico-práctica</li>
                            <li>Seguimiento personalizado</li>
                            <li>Material didáctico incluido</li>
                        </ul>
                    </div>
                    
                    <div class="info-card">
                        <h3>🏆 Certificación</h3>
                        <ul>
                            <li>Certificado de profesionalidad oficial</li>
                            <li>Reconocido por el SEPE</li>
                            <li>Válido en toda España</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Formulario de Contacto -->
            <div class="course-section">
                <h2>📞 Solicitar Información</h2>
                <div class="contact-form-container">
                    <form class="course-contact-form" action="<?php echo home_url('/contacto'); ?>" method="get">
                        <input type="hidden" name="curso" value="<?php echo esc_attr($course_name); ?>">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Nombre completo *</label>
                                <input type="text" name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label>Teléfono *</label>
                                <input type="tel" name="telefono" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Email *</label>
                                <input type="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label>Ciudad</label>
                                <input type="text" name="ciudad">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Mensaje</label>
                            <textarea name="mensaje" rows="4" placeholder="Cuéntanos qué te interesa saber sobre este curso..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn-submit">
                            📧 Enviar Solicitud
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="course-sidebar">
            <!-- Resumen del Curso -->
            <div class="sidebar-card">
                <h3>📋 Resumen</h3>
                <div class="course-summary">
                    <div class="summary-item">
                        <strong>Inicio:</strong> <?php echo esc_html($course_date); ?>
                    </div>
                    <div class="summary-item">
                        <strong>Modalidad:</strong> <?php echo esc_html($course_modality); ?>
                    </div>
                    <div class="summary-item">
                        <strong>Plazas:</strong> <?php echo esc_html($course_duration); ?>
                    </div>
                    <div class="summary-item">
                        <strong>Certificación:</strong> Oficial
                    </div>
                </div>
                
                <a href="<?php echo home_url('/contacto'); ?>" class="btn-sidebar">
                    Reservar Plaza
                </a>
            </div>

            <!-- Otros Cursos -->
            <div class="sidebar-card">
                <h3>🎓 Otros Cursos</h3>
                <div class="other-courses">
                    <?php for ($i = 1; $i <= 3; $i++): 
                        if ($i == $course_id) continue;
                        $other_name = get_option("course_{$i}_name");
                        $other_date = get_option("course_{$i}_date");
                        
                        if (!$other_name) {
                            $defaults = [
                                1 => ['name' => 'Instalaciones Eléctricas', 'date' => 'Enero 2025'],
                                2 => ['name' => 'Sistemas Domóticos', 'date' => 'Febrero 2025'],
                                3 => ['name' => 'Control de Plagas', 'date' => 'Marzo 2025']
                            ];
                            $other_name = $defaults[$i]['name'];
                            $other_date = $defaults[$i]['date'];
                        }
                    ?>
                        <div class="other-course-item">
                            <a href="<?php echo home_url("/curso/?curso=$i"); ?>">
                                <div class="other-course-name"><?php echo esc_html($other_name); ?></div>
                                <div class="other-course-date"><?php echo esc_html($other_date); ?></div>
                            </a>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Contacto Directo -->
            <div class="sidebar-card contact-card">
                <h3>📞 Contacto Directo</h3>
                <div class="contact-info">
                    <div class="contact-item">
                        <span class="contact-icon">📱</span>
                        <span>WhatsApp: 625 123 456</span>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon">📧</span>
                        <span>info@mogruas.com</span>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon">📍</span>
                        <span>Talavera de la Reina</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.single-course-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.breadcrumb {
    margin-bottom: 30px;
    font-size: 14px;
    color: #666;
}

.breadcrumb a {
    color: #0066cc;
    text-decoration: none;
}

.breadcrumb a:hover {
    text-decoration: underline;
}

.course-hero {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    margin-bottom: 50px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 20px;
    padding: 40px;
    border: 2px solid #e0e0e0;
}

.course-hero-image img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    border-radius: 16px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.course-hero-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.course-date-badge {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 700;
    display: inline-block;
    margin-bottom: 20px;
    width: fit-content;
}

.course-title {
    font-size: 32px;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 30px;
    line-height: 1.2;
}

.course-meta {
    margin-bottom: 30px;
}

.meta-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    font-size: 16px;
}

.meta-icon {
    font-size: 20px;
    margin-right: 10px;
}

.meta-label {
    font-weight: 600;
    margin-right: 10px;
    color: #495057;
}

.meta-value {
    color: #1a1a1a;
    font-weight: 500;
}

.course-actions {
    display: flex;
    gap: 15px;
}

.btn-primary {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    padding: 15px 30px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 700;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    color: white;
    text-decoration: none;
}

.btn-secondary {
    background: #6c757d;
    color: white;
    padding: 15px 30px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 700;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: #5a6268;
    color: white;
    text-decoration: none;
}

.course-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 40px;
}

.course-section {
    background: white;
    padding: 30px;
    border-radius: 16px;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.course-section h2 {
    font-size: 24px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 20px;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 10px;
}

.course-description-full {
    font-size: 16px;
    line-height: 1.6;
    color: #495057;
}

.course-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.info-card {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 12px;
    border-left: 4px solid #0066cc;
}

.info-card h3 {
    font-size: 18px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 15px;
}

.info-card ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.info-card li {
    padding: 5px 0;
    color: #495057;
    position: relative;
    padding-left: 20px;
}

.info-card li::before {
    content: "✓";
    position: absolute;
    left: 0;
    color: #28a745;
    font-weight: bold;
}

.contact-form-container {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 12px;
}

.course-contact-form .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.course-contact-form .form-group {
    display: flex;
    flex-direction: column;
}

.course-contact-form label {
    font-weight: 600;
    margin-bottom: 5px;
    color: #495057;
}

.course-contact-form input,
.course-contact-form textarea {
    padding: 12px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.3s ease;
}

.course-contact-form input:focus,
.course-contact-form textarea:focus {
    border-color: #0066cc;
    outline: none;
}

.btn-submit {
    background: linear-gradient(135deg, #0066cc, #004499);
    color: white;
    padding: 15px 30px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3);
}

.course-sidebar .sidebar-card {
    background: white;
    padding: 25px;
    border-radius: 16px;
    margin-bottom: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.sidebar-card h3 {
    font-size: 18px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 20px;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 10px;
}

.course-summary .summary-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
}

.course-summary .summary-item:last-child {
    border-bottom: none;
}

.btn-sidebar {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 700;
    display: block;
    text-align: center;
    margin-top: 20px;
    transition: all 0.3s ease;
}

.btn-sidebar:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    color: white;
    text-decoration: none;
}

.other-course-item {
    padding: 15px 0;
    border-bottom: 1px solid #f0f0f0;
}

.other-course-item:last-child {
    border-bottom: none;
}

.other-course-item a {
    text-decoration: none;
    color: inherit;
}

.other-course-item a:hover .other-course-name {
    color: #0066cc;
}

.other-course-name {
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 5px;
    transition: color 0.3s ease;
}

.other-course-date {
    font-size: 14px;
    color: #666;
}

.contact-card {
    background: linear-gradient(135deg, #0066cc, #004499) !important;
    color: white;
}

.contact-card h3 {
    color: white !important;
    border-bottom-color: rgba(255,255,255,0.3) !important;
}

.contact-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.contact-icon {
    font-size: 18px;
    margin-right: 10px;
}

/* Responsive */
@media (max-width: 768px) {
    .course-hero {
        grid-template-columns: 1fr;
        gap: 20px;
        padding: 20px;
    }
    
    .course-content {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .course-actions {
        flex-direction: column;
    }
    
    .course-contact-form .form-row {
        grid-template-columns: 1fr;
    }
    
    .course-info-grid {
        grid-template-columns: 1fr;
    }
    
    .course-title {
        font-size: 24px;
    }
}
</style>

<?php get_footer(); ?>
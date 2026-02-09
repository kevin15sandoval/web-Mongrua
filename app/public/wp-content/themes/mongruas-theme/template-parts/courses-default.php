<?php
/**
 * Cursos de ejemplo por defecto
 * Se muestra cuando no hay cursos creados en el sistema
 * Muestra mensaje para ver catálogo completo en plataforma
 * 
 * @package Mongruas
 * @since 1.0.0
 */
?>

<!-- Cursos Presenciales - LO PRINCIPAL -->
<div class="presencial-courses-section presencial-main">
    <h3>Certificados de Profesionalidad Acreditados</h3>
    <p class="presencial-subtitle">Empresa acreditada en el Registro Estatal de Entidades de Formación de Castilla-La Mancha</p>
    
    <div class="certificados-grid">
        <div class="certificado-card">
            <div class="certificado-icon">⚡</div>
            <h4>Montaje y Mantenimiento de Instalaciones Eléctricas de Baja Tensión</h4>
            <p class="certificado-code">ELEE0109</p>
            <p>RD 683/2011, de 13 de mayo</p>
        </div>
        
        <div class="certificado-card">
            <div class="certificado-icon">🏠</div>
            <h4>Montaje y Mantenimiento de Sistemas Domóticos e Inmóticos</h4>
            <p class="certificado-code">ELEM0111</p>
            <p>Formación profesional para el empleo</p>
        </div>
        
        <div class="certificado-card">
            <div class="certificado-icon">🐛</div>
            <h4>Servicios para el Control de Plagas</h4>
            <p class="certificado-code">SEAG0110</p>
            <p>Certificado de profesionalidad oficial</p>
        </div>
    </div>
    
    <div class="presencial-cta">
        <a href="<?php echo home_url('/contacto'); ?>" class="btn btn-presencial">
            Solicitar Información sobre Certificados de Profesionalidad
        </a>
        <a href="https://www.plataformateleformacion.com/lcursos/cursos_elearning.php" target="_blank" class="btn btn-jccm">
            📚 Ver Catálogo Completo
        </a>
    </div>
</div>

<!-- Próximos Cursos -->
<div class="upcoming-courses-section">
    <div class="section-header">
        <h2>Próximos Cursos</h2>
        <p>Cursos que comenzarán próximamente. ¡Reserva tu plaza!</p>
    </div>
    
    <div class="upcoming-courses-grid">
        <?php
        // INTEGRACIÓN CON SISTEMA DINÁMICO
        // Obtener cursos del sistema dinámico (gestionar-cursos-dinamico.php)
        $cursos_dinamicos = get_option('mongruas_courses', []);
        
        if (!empty($cursos_dinamicos)):
            // Mostrar todos los cursos del sistema dinámico
            foreach ($cursos_dinamicos as $index => $curso):
        ?>
                <div class="upcoming-course-card">
                    <?php if (!empty($curso['image'])): ?>
                        <div class="course-image-container">
                            <img src="<?php echo esc_url($curso['image']); ?>" alt="<?php echo esc_attr($curso['name']); ?>" class="course-image" onerror="this.parentElement.style.display='none'">
                        </div>
                    <?php endif; ?>
                    
                    <div class="course-date">
                        <span class="date-text"><?php echo !empty($curso['date']) ? esc_html($curso['date']) : 'Próximamente'; ?></span>
                    </div>
                    <h3><?php echo esc_html($curso['name']); ?></h3>
                    
                    <?php if (!empty($curso['description'])): ?>
                        <p class="course-description"><?php echo esc_html($curso['description']); ?></p>
                    <?php endif; ?>
                    
                    <div class="course-details">
                        <span class="modalidad"><?php echo !empty($curso['modality']) ? esc_html($curso['modality']) : 'Presencial'; ?></span>
                        <span class="plazas"><?php echo !empty($curso['duration']) ? esc_html($curso['duration']) : 'Plazas limitadas'; ?></span>
                    </div>
                    <div class="course-buttons">
                        <a href="<?php echo home_url("/curso-info.php?curso=" . ($index + 1)); ?>" class="btn-ver-mas">Ver Más Info</a>
                        <a href="<?php echo home_url('/contacto'); ?>" class="btn-reservar">Reservar Plaza</a>
                    </div>
                </div>
        <?php
            endforeach;
        else:
            // Cursos de ejemplo si no hay datos en el sistema dinámico
        ?>
            <div class="upcoming-course-card">
                <div class="course-date">
                    <span class="date-text">Enero 2025</span>
                </div>
                <h3>Montaje y Mantenimiento de Instalaciones Eléctricas</h3>
                <p class="course-description">Curso completo de instalaciones eléctricas de baja tensión con certificado oficial.</p>
                <div class="course-details">
                    <span class="modalidad">Presencial</span>
                    <span class="plazas">15 plazas</span>
                </div>
                <div class="course-buttons">
                    <a href="<?php echo home_url('/curso-info.php?curso=1'); ?>" class="btn-ver-mas">Ver Más Info</a>
                    <a href="<?php echo home_url('/contacto'); ?>" class="btn-reservar">Reservar Plaza</a>
                </div>
            </div>
            
            <div class="upcoming-course-card">
                <div class="course-date">
                    <span class="date-text">Febrero 2025</span>
                </div>
                <h3>Sistemas Domóticos e Inmóticos</h3>
                <p class="course-description">Especialización en automatización de edificios y sistemas inteligentes.</p>
                <div class="course-details">
                    <span class="modalidad">Presencial</span>
                    <span class="plazas">12 plazas</span>
                </div>
                <div class="course-buttons">
                    <a href="<?php echo home_url('/curso-info.php?curso=2'); ?>" class="btn-ver-mas">Ver Más Info</a>
                    <a href="<?php echo home_url('/contacto'); ?>" class="btn-reservar">Reservar Plaza</a>
                </div>
            </div>
            
            <div class="upcoming-course-card">
                <div class="course-date">
                    <span class="date-text">Marzo 2025</span>
                </div>
                <h3>Control de Plagas</h3>
                <p class="course-description">Formación profesional en control y prevención de plagas urbanas.</p>
                <div class="course-details">
                    <span class="modalidad">Presencial</span>
                    <span class="plazas">10 plazas</span>
                </div>
                <div class="course-buttons">
                    <a href="<?php echo home_url('/curso-info.php?curso=3'); ?>" class="btn-ver-mas">Ver Más Info</a>
                    <a href="<?php echo home_url('/contacto'); ?>" class="btn-reservar">Reservar Plaza</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Además tenemos... Cursos Online -->
<div class="online-courses-divider">
    <h3>Además Tenemos +2000 Cursos Online</h3>
    <p>Formación bonificada disponible en nuestro campus virtual</p>
</div>

<!-- Categorías principales de cursos online -->
<div class="course-categories-showcase">
    <div class="category-card" data-category="informatica">
        <div class="category-icon">💻</div>
        <h3>Informática y Tecnología</h3>
        <p>Office, programación, diseño web, bases de datos y más</p>
        <ul class="category-examples">
            <li>Excel Avanzado</li>
            <li>Programación</li>
            <li>Diseño Web</li>
            <li>Bases de Datos</li>
        </ul>
    </div>

    <div class="category-card" data-category="idiomas">
        <div class="category-icon">🌍</div>
        <h3>Idiomas</h3>
        <p>Inglés, francés, alemán y más idiomas para profesionales</p>
        <ul class="category-examples">
            <li>Inglés Profesional</li>
            <li>Francés Empresarial</li>
            <li>Alemán de Negocios</li>
            <li>Otros Idiomas</li>
        </ul>
    </div>

    <div class="category-card" data-category="gestion">
        <div class="category-icon">📊</div>
        <h3>Gestión Empresarial</h3>
        <p>Administración, contabilidad, recursos humanos y liderazgo</p>
        <ul class="category-examples">
            <li>Gestión de Proyectos</li>
            <li>Contabilidad</li>
            <li>Recursos Humanos</li>
            <li>Liderazgo</li>
        </ul>
    </div>

    <div class="category-card" data-category="marketing">
        <div class="category-icon">📱</div>
        <h3>Marketing y Ventas</h3>
        <p>Marketing digital, redes sociales, comercio electrónico</p>
        <ul class="category-examples">
            <li>Marketing Digital</li>
            <li>Redes Sociales</li>
            <li>E-commerce</li>
            <li>SEO y SEM</li>
        </ul>
    </div>
</div>

<!-- Enlaces directos a listados de cursos -->
<div class="course-links-section">
    <h3>Explora Nuestros Cursos por Modalidad</h3>
    <div class="course-links-grid">
        <a href="https://www.plataformateleformacion.com/lcursos/cursos_elearning.php" target="_blank" class="course-link-card">
            <div class="link-icon">🎓</div>
            <h4>Cursos E-Learning</h4>
            <p>Formación online con tutorización</p>
            <span class="link-arrow">→</span>
        </a>

        <a href="https://www.plataformateleformacion.com/lcursos/cursos_certificados.php" target="_blank" class="course-link-card">
            <div class="link-icon">📜</div>
            <h4>Certificados Profesionales</h4>
            <p>Competencias profesionales acreditadas</p>
            <span class="link-arrow">→</span>
        </a>

        <a href="https://www.plataformateleformacion.com/lcursos/libros.php" target="_blank" class="course-link-card">
            <div class="link-icon">📚</div>
            <h4>Material Didáctico</h4>
            <p>Libros y recursos formativos</p>
            <span class="link-arrow">→</span>
        </a>
    </div>
</div>



<?php
// Cursos destacados de ejemplo con enlaces específicos
$default_courses = array(
    array(
        'title' => 'Catálogo de Informática y Tecnología',
        'category' => 'informatica',
        'level' => 'Todos los niveles',
        'duration' => '+500 cursos',
        'excerpt' => 'Office, programación, diseño web, bases de datos, ciberseguridad y mucho más.',
        'icon' => '💻',
        'link' => 'https://www.plataformateleformacion.com/lcursos/cursos_elearning.php'
    ),
    array(
        'title' => 'Catálogo de Idiomas',
        'category' => 'idiomas',
        'level' => 'Todos los niveles',
        'duration' => '+300 cursos',
        'excerpt' => 'Inglés, francés, alemán y más idiomas con diferentes niveles y especialidades profesionales.',
        'icon' => '🌍',
        'link' => 'https://www.plataformateleformacion.com/lcursos/cursos_elearning.php'
    ),
    array(
        'title' => 'Catálogo de Gestión Empresarial',
        'category' => 'gestion',
        'level' => 'Todos los niveles',
        'duration' => '+400 cursos',
        'excerpt' => 'Administración, contabilidad, recursos humanos, liderazgo y gestión de proyectos.',
        'icon' => '📊',
        'link' => 'https://www.plataformateleformacion.com/lcursos/cursos_elearning.php'
    ),
    array(
        'title' => 'Catálogo de Marketing Digital',
        'category' => 'marketing',
        'level' => 'Todos los niveles',
        'duration' => '+250 cursos',
        'excerpt' => 'Marketing digital, redes sociales, SEO, SEM, e-commerce y estrategias de ventas online.',
        'icon' => '📱',
        'link' => 'https://www.plataformateleformacion.com/lcursos/cursos_elearning.php'
    )
);

foreach ($default_courses as $course):
?>
    <div class="course-card course-card-catalog" data-category="<?php echo esc_attr($course['category']); ?>">
        <div class="course-image course-image-placeholder">
            <div class="course-icon"><?php echo $course['icon']; ?></div>
            <div class="course-badge">+500 Cursos</div>
        </div>
        
        <div class="course-content">
            <div class="course-meta">
                <span class="course-category"><?php echo esc_html(ucfirst($course['category'])); ?></span>
                <span class="course-level"><?php echo esc_html($course['level']); ?></span>
            </div>
            
            <h3 class="course-title"><?php echo esc_html($course['title']); ?></h3>
            
            <div class="course-excerpt">
                <?php echo esc_html($course['excerpt']); ?>
            </div>
            
            <div class="course-footer">
                <span class="course-duration">⏱️ <?php echo esc_html($course['duration']); ?></span>
                <a href="<?php echo esc_url($course['link']); ?>" target="_blank" class="course-link">Ver Cursos →</a>
            </div>
        </div>
    </div>
<?php
endforeach;
?>

<style>
/* Banner informativo */
.courses-info-banner {
    grid-column: 1 / -1;
    background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
    border-radius: 20px;
    padding: 40px;
    margin-bottom: 30px;
    box-shadow: 0 8px 24px rgba(0, 102, 204, 0.2);
}

.info-content {
    display: flex;
    align-items: center;
    gap: 30px;
    flex-wrap: wrap;
    justify-content: space-between;
}

.info-icon {
    font-size: 60px;
    animation: float 3s ease-in-out infinite;
}

.info-text {
    flex: 1;
    min-width: 250px;
}

.info-text h3 {
    color: white;
    font-size: 28px;
    font-weight: 800;
    margin: 0 0 10px 0;
}

.info-text p {
    color: rgba(255,255,255,0.95);
    font-size: 16px;
    margin: 0;
}

.btn-campus-access {
    background: white;
    color: var(--color-primary);
    padding: 16px 32px;
    border-radius: 50px;
    font-weight: 700;
    text-decoration: none;
    white-space: nowrap;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.btn-campus-access:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
}

/* Categorías showcase */
.course-categories-showcase {
    grid-column: 1 / -1;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.category-card {
    background: white;
    border-radius: 16px;
    padding: 30px;
    text-align: center;
    border: 2px solid #f0f0f0;
    transition: all 0.3s ease;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    border-color: var(--color-primary);
}

.category-icon {
    font-size: 70px;
    margin-bottom: 15px;
}

.category-card h3 {
    font-size: 26px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 10px;
}

.category-card p {
    font-size: 18px;
    color: #495057;
    margin-bottom: 15px;
}

.category-examples {
    list-style: none;
    padding: 0;
    margin: 0;
}

.category-examples li {
    font-size: 16px;
    color: #6c757d;
    padding: 5px 0;
    border-bottom: 1px solid #f0f0f0;
}

.category-examples li:last-child {
    border-bottom: none;
}

/* Enlaces a listados */
.course-links-section {
    grid-column: 1 / -1;
    text-align: center;
    margin: 40px 0;
}

.course-links-section h3 {
    font-size: 28px;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 30px;
}

.course-links-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}

.course-link-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border: 2px solid #e0e0e0;
    border-radius: 16px;
    padding: 30px;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.course-link-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--color-primary), var(--color-secondary));
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.course-link-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    border-color: var(--color-primary);
}

.course-link-card:hover::before {
    transform: scaleX(1);
}

.link-icon {
    font-size: 60px;
}

.course-link-card h4 {
    font-size: 18px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.course-link-card p {
    font-size: 14px;
    color: #495057;
    margin: 0;
}

.link-arrow {
    font-size: 24px;
    color: var(--color-primary);
    font-weight: 700;
}

/* Tarjetas de cursos */
.course-image-placeholder {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.course-image-placeholder::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100%" height="100%" fill="url(%23dots)"/></svg>');
}

.course-icon {
    font-size: 80px;
    position: relative;
    z-index: 2;
    animation: float 3s ease-in-out infinite;
}

.course-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(255,255,255,0.95);
    color: #667eea;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    z-index: 3;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

/* Variaciones de color para diferentes categorías */
.course-card[data-category="informatica"] .course-image-placeholder {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.course-card[data-category="idiomas"] .course-image-placeholder {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.course-card[data-category="gestion"] .course-image-placeholder {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.course-card[data-category="marketing"] .course-image-placeholder {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

/* Cursos Presenciales - Principal */
.presencial-main {
    grid-column: 1 / -1;
    background: linear-gradient(135deg, #003366 0%, #001a33 100%);
    border-radius: 20px;
    padding: 50px 40px;
    margin-bottom: 50px;
    box-shadow: 0 8px 24px rgba(0, 51, 102, 0.4);
    color: white !important;
}

.presencial-main h3 {
    color: #000000 !important;
    font-size: 48px;
    font-weight: 800;
    text-align: center;
    margin-bottom: 15px;
}

.presencial-main .presencial-subtitle {
    color: #000000 !important;
    text-align: center;
    font-size: 22px;
    margin-bottom: 40px;
    font-weight: 600;
}

/* Certificados Grid */
.certificados-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    margin-bottom: 30px;
}

.certificado-card {
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,0.4);
    border-radius: 16px;
    padding: 30px;
    text-align: center;
    transition: all 0.3s ease;
}

.certificado-card:hover {
    background: rgba(255,255,255,0.3);
    border-color: rgba(255,255,255,0.6);
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

.certificado-icon {
    font-size: 80px;
    margin-bottom: 20px;
}

.certificado-card h4 {
    color: #000000 !important;
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 15px;
    line-height: 1.4;
    min-height: 60px;
}

.certificado-code {
    color: #0066cc !important;
    font-size: 22px;
    font-weight: 800;
    margin-bottom: 10px;
    letter-spacing: 1px;
}

.certificado-card p {
    color: #000000 !important;
    font-size: 20px;
    margin: 0;
    font-weight: 500;
}

.presencial-main .presencial-card {
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    border-color: rgba(255,255,255,0.3);
}

.presencial-main .presencial-card:hover {
    background: rgba(255,255,255,0.25);
    border-color: rgba(255,255,255,0.5);
}

.presencial-main .presencial-card h4 {
    color: white !important;
}

.presencial-main .presencial-card p {
    color: rgba(255,255,255,0.9) !important;
}

/* Divisor "Además tenemos" */
.online-courses-divider {
    grid-column: 1 / -1;
    text-align: center;
    padding: 40px 20px;
    margin: 20px 0;
}

.online-courses-divider h3 {
    font-size: 42px;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 10px;
}

.online-courses-divider p {
    font-size: 22px;
    color: #495057;
}

/* Cursos Presenciales */
.presencial-courses-section {
    grid-column: 1 / -1;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border-radius: 20px;
    padding: 50px 40px;
    margin-top: 40px;
    border: 2px solid #e0e0e0;
}

.presencial-courses-section h3 {
    font-size: 32px;
    font-weight: 800;
    color: #1a1a1a;
    text-align: center;
    margin-bottom: 10px;
}

.presencial-subtitle {
    text-align: center;
    font-size: 18px;
    color: #495057;
    margin-bottom: 40px;
}

.presencial-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.presencial-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    text-align: center;
    border: 2px solid #e8e8e8;
    transition: all 0.3s ease;
}

.presencial-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    border-color: var(--color-primary);
}

.presencial-icon {
    font-size: 50px;
    margin-bottom: 15px;
}

.presencial-card h4 {
    font-size: 18px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 8px;
}

.presencial-card p {
    font-size: 14px;
    color: #495057;
    margin: 0;
}

.presencial-cta {
    text-align: center;
    margin-top: 30px;
}

.btn-presencial {
    display: inline-block;
    background: linear-gradient(135deg, #dc2626, #ef4444);
    color: white;
    padding: 16px 32px;
    border-radius: 16px;
    font-size: 20px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 14px 0 rgba(220, 38, 38, 0.3);
    border: none;
    position: relative;
    overflow: hidden;
}

.btn-presencial::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-presencial:hover::before {
    left: 100%;
}

.btn-presencial:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px 0 rgba(220, 38, 38, 0.4);
    color: white;
    text-decoration: none;
    background: linear-gradient(135deg, #b91c1c, #dc2626);
}

.btn-jccm {
    display: inline-block;
    background: linear-gradient(135deg, #059669, #10b981);
    color: white;
    padding: 16px 32px;
    border-radius: 16px;
    font-size: 20px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 14px 0 rgba(5, 150, 105, 0.3);
    margin-left: 15px;
    border: none;
    position: relative;
    overflow: hidden;
}

.btn-jccm::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-jccm:hover::before {
    left: 100%;
}

.btn-jccm:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px 0 rgba(5, 150, 105, 0.4);
    color: white;
    text-decoration: none;
    background: linear-gradient(135deg, #047857, #059669);
}

.btn-oficina {
    display: inline-block;
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
    padding: 16px 32px;
    border-radius: 50px;
    font-size: 16px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    margin-left: 15px;
}



/* Próximos Cursos */
.upcoming-courses-section {
    grid-column: 1 / -1;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 20px;
    padding: 50px 40px;
    margin: 40px 0;
    border: 2px solid #e0e0e0;
}

.upcoming-courses-section .section-header {
    text-align: center;
    margin-bottom: 40px;
}

.upcoming-courses-section h2 {
    font-size: 42px;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 10px;
}

.upcoming-courses-section p {
    font-size: 22px;
    color: #495057;
}

.upcoming-courses-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
    max-width: 1200px;
    margin: 0 auto;
}

.upcoming-course-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    text-align: center;
    border: 2px solid #e8e8e8;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.course-image-container {
    margin: -30px -30px 15px -30px;
    height: 180px;
    overflow: hidden;
    border-radius: 16px 16px 0 0;
}

.course-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.upcoming-course-card:hover .course-image {
    transform: scale(1.05);
}

.course-description {
    font-size: 14px;
    color: #666;
    line-height: 1.5;
    margin: 10px 0;
    font-style: italic;
}

.upcoming-course-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #28a745, #20c997);
}

.upcoming-course-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    border-color: #28a745;
}

.course-date {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 14px;
    font-weight: 700;
    display: inline-block;
    margin-bottom: 15px;
}

.upcoming-course-card h3 {
    font-size: 20px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 15px;
    line-height: 1.4;
}

.course-details {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    font-size: 14px;
}

.modalidad {
    background: #e9ecef;
    color: #495057;
    padding: 4px 12px;
    border-radius: 12px;
    font-weight: 600;
}

.plazas {
    background: #fff3cd;
    color: #856404;
    padding: 4px 12px;
    border-radius: 12px;
    font-weight: 600;
}

/* Botones bonitos y modernos */
.btn-ver-mas {
    display: inline-block;
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    color: white;
    padding: 10px 24px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 14px 0 rgba(30, 64, 175, 0.3);
    border: none;
    position: relative;
    overflow: hidden;
    width: 160px;
    text-align: center;
}

.btn-ver-mas::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-ver-mas:hover::before {
    left: 100%;
}

.btn-ver-mas:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px 0 rgba(30, 64, 175, 0.4);
    color: white;
    text-decoration: none;
    background: linear-gradient(135deg, #1d4ed8, #2563eb);
}

.btn-reservar {
    display: inline-block;
    background: linear-gradient(135deg, #059669, #10b981);
    color: white;
    padding: 10px 24px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 14px 0 rgba(5, 150, 105, 0.3);
    border: none;
    position: relative;
    overflow: hidden;
    width: 160px;
    text-align: center;
}

.btn-reservar::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-reservar:hover::before {
    left: 100%;
}

.btn-reservar:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px 0 rgba(5, 150, 105, 0.4);
    color: white;
    text-decoration: none;
    background: linear-gradient(135deg, #047857, #059669);
}

.course-buttons {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-top: 15px;
    align-items: center;
}

/* Responsive para carrusel de 3 en 3 */
@media (max-width: 768px) {
    .courses-info-banner {
        padding: 30px 20px;
    }
    
    .info-content {
        flex-direction: column;
        text-align: center;
    }
    
    .info-text h3 {
        font-size: 28px;
    }
    
    .course-categories-showcase {
        grid-template-columns: 1fr;
    }
    
    .course-links-grid {
        grid-template-columns: 1fr;
    }
    
    .presencial-courses-section {
        padding: 30px 20px;
    }
    
    .presencial-courses-section h3 {
        font-size: 32px;
    }
    
    .presencial-subtitle {
        font-size: 20px;
    }
    
    .presencial-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .btn-presencial {
        padding: 14px 28px;
        font-size: 18px;
        margin-bottom: 10px;
    }
    
    .btn-jccm {
        padding: 14px 28px;
        font-size: 18px;
        margin-left: 0;
        margin-top: 10px;
    }
    
    .btn-oficina {
        padding: 14px 28px;
        font-size: 14px;
        margin-left: 0;
        margin-top: 10px;
    }
    
    .presencial-cta {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }
    
    .upcoming-courses-section {
        padding: 30px 20px;
    }
    
    .upcoming-courses-section h2 {
        font-size: 32px;
    }
    
    /* En móvil, mostrar 1 curso por página */
    .carousel-page {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .carousel-btn-tres {
        width: 45px;
        height: 45px;
        font-size: 18px;
    }
    
    .carousel-controls-tres {
        gap: 15px !important;
        margin-top: 25px !important;
    }
    
    .course-details {
        flex-direction: column;
        gap: 10px;
        align-items: center;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    /* En tablet, mostrar 2 cursos por página */
    .carousel-page {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
}

/* Estilos para Carrusel de 3 en 3 */
.carousel-container-tres {
    position: relative;
    overflow: hidden;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.carousel-track-tres {
    display: flex;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    will-change: transform;
}

.carousel-page {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
    min-width: 100%;
    flex-shrink: 0;
}

.carousel-btn-tres {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
    border: none;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 24px;
    font-weight: 700;
    transition: all 0.3s ease;
    box-shadow: 0 6px 20px rgba(0, 102, 204, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.carousel-btn-tres::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.carousel-btn-tres:hover::before {
    left: 100%;
}

.carousel-btn-tres:hover {
    transform: translateY(-4px) scale(1.1);
    box-shadow: 0 8px 25px rgba(0, 102, 204, 0.4);
    background: linear-gradient(135deg, #0052a3, #003d7a);
}

.carousel-btn-tres:active {
    transform: translateY(-1px) scale(0.95);
}

.carousel-indicator-tres {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    border: none;
    background: rgba(0, 102, 204, 0.3);
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.carousel-indicator-tres.active {
    background: #0066cc;
    transform: scale(1.3);
    box-shadow: 0 3px 10px rgba(0, 102, 204, 0.4);
}

.carousel-indicator-tres.active::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 6px;
    height: 6px;
    background: white;
    border-radius: 50%;
}

.carousel-indicator-tres:hover:not(.active) {
    background: rgba(0, 102, 204, 0.6);
    transform: scale(1.1);
}

/* Animación de entrada para las tarjetas */
.upcoming-course-card {
    animation: slideInUp 0.6s ease-out;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.upcoming-course-card.animate-in {
    animation: slideInUp 0.6s ease-out forwards;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Efecto hover mejorado para las tarjetas */
.upcoming-course-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    border-color: #0066cc;
}
</style>

<script>
// Carrusel de 3 en 3 - Próximos Cursos - ARREGLADO PARA MOSTRAR 3 COLUMNAS
document.addEventListener("DOMContentLoaded", function() {
    const coursesGrid = document.querySelector(".upcoming-courses-grid");
    const courseCards = document.querySelectorAll(".upcoming-course-card");
    
    if (!coursesGrid || courseCards.length <= 3) {
        return; // No crear carrusel si hay 3 o menos cursos
    }
    
    console.log(`🎠 Iniciando carrusel con ${courseCards.length} cursos`);
    
    // NO convertir a flex - mantener como contenedor para el carrusel
    coursesGrid.style.display = "block";
    coursesGrid.style.overflow = "hidden";
    coursesGrid.style.position = "relative";
    
    // Crear contenedor de carrusel que mantenga las 3 columnas visibles
    const carouselContainer = document.createElement("div");
    carouselContainer.className = "carousel-container-tres";
    carouselContainer.style.position = "relative";
    carouselContainer.style.overflow = "hidden";
    carouselContainer.style.borderRadius = "20px";
    
    // Crear track del carrusel que muestre 3 columnas
    const carouselTrack = document.createElement("div");
    carouselTrack.className = "carousel-track-tres";
    carouselTrack.style.display = "flex";
    carouselTrack.style.transition = "transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94)";
    carouselTrack.style.willChange = "transform";
    
    // Organizar cursos en grupos de 3 - CADA PÁGINA MUESTRA 3 CURSOS
    const originalCards = Array.from(courseCards);
    const totalCards = originalCards.length;
    const cardsPerPage = 3;
    const totalPages = Math.ceil(totalCards / cardsPerPage);
    
    console.log(`📊 Configuración: ${totalCards} cursos, ${totalPages} páginas de ${cardsPerPage} cursos cada una`);
    
    // Crear páginas de 3 cursos cada una - GRID DE 3 COLUMNAS
    for (let page = 0; page < totalPages; page++) {
        const pageContainer = document.createElement("div");
        pageContainer.className = "carousel-page";
        pageContainer.style.display = "grid";
        pageContainer.style.gridTemplateColumns = "repeat(3, 1fr)";
        pageContainer.style.gap = "25px";
        pageContainer.style.minWidth = "100%";
        pageContainer.style.flexShrink = "0";
        pageContainer.style.padding = "0 10px";
        
        // Agregar exactamente 3 cursos por página
        for (let i = 0; i < cardsPerPage; i++) {
            const cardIndex = page * cardsPerPage + i;
            if (cardIndex < totalCards) {
                const card = originalCards[cardIndex].cloneNode(true);
                card.style.minWidth = "auto";
                card.style.width = "100%";
                pageContainer.appendChild(card);
                console.log(`➕ Página ${page + 1}: Agregado curso ${cardIndex + 1}`);
            }
        }
        
        carouselTrack.appendChild(pageContainer);
    }
    
    // Reemplazar grid con carrusel
    coursesGrid.parentNode.replaceChild(carouselContainer, coursesGrid);
    carouselContainer.appendChild(carouselTrack);
    
    // Variables del carrusel
    let currentPage = 0;
    let isTransitioning = false;
    let autoPlayInterval;
    
    // Función para mover el carrusel - MUESTRA 3 CURSOS SIEMPRE
    function moveCarousel(pageIndex, smooth = true) {
        if (isTransitioning) return;
        
        console.log(`🎯 Moviendo a página ${pageIndex + 1} de ${totalPages}`);
        
        if (smooth) {
            carouselTrack.style.transition = "transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94)";
        } else {
            carouselTrack.style.transition = "none";
        }
        
        // Mover para mostrar la página completa (3 cursos visibles)
        const translateX = -pageIndex * 100;
        carouselTrack.style.transform = `translateX(${translateX}%)`;
        
        if (smooth) {
            isTransitioning = true;
            setTimeout(() => {
                isTransitioning = false;
            }, 600);
        }
        
        updateIndicators();
        
        // Animar las tarjetas de la página actual
        animateCurrentPageCards();
    }
    
    // Función para animar las tarjetas de la página actual
    function animateCurrentPageCards() {
        const pages = carouselTrack.querySelectorAll(".carousel-page");
        if (pages[currentPage]) {
            const cards = pages[currentPage].querySelectorAll(".upcoming-course-card");
            cards.forEach((card, index) => {
                card.style.animation = "none";
                card.offsetHeight; // Trigger reflow
                card.style.animation = `slideInUp 0.8s ease-out ${index * 0.2}s both`;
            });
        }
    }
    
    // Función para ir a la siguiente página (siguientes 3 cursos)
    function nextPage() {
        currentPage = (currentPage + 1) % totalPages;
        moveCarousel(currentPage);
        console.log(`➡️ Siguiente página: mostrando cursos ${(currentPage * 3) + 1}-${Math.min((currentPage + 1) * 3, totalCards)}`);
    }
    
    // Función para ir a la página anterior (anteriores 3 cursos)
    function prevPage() {
        currentPage = (currentPage - 1 + totalPages) % totalPages;
        moveCarousel(currentPage);
        console.log(`⬅️ Página anterior: mostrando cursos ${(currentPage * 3) + 1}-${Math.min((currentPage + 1) * 3, totalCards)}`);
    }
    
    // Crear controles del carrusel - BOTONES GRANDES Y VISIBLES
    const controlsContainer = document.createElement("div");
    controlsContainer.className = "carousel-controls-tres";
    controlsContainer.style.display = "flex";
    controlsContainer.style.justifyContent = "center";
    controlsContainer.style.alignItems = "center";
    controlsContainer.style.gap = "30px";
    controlsContainer.style.marginTop = "40px";
    
    const prevButton = document.createElement("button");
    prevButton.innerHTML = "←";
    prevButton.className = "carousel-btn-tres carousel-prev";
    prevButton.onclick = () => {
        prevPage();
        stopAutoPlay();
        setTimeout(startAutoPlay, 3000); // Reanudar después de 3 segundos
    };
    
    const nextButton = document.createElement("button");
    nextButton.innerHTML = "→";
    nextButton.className = "carousel-btn-tres carousel-next";
    nextButton.onclick = () => {
        nextPage();
        stopAutoPlay();
        setTimeout(startAutoPlay, 3000);
    };
    
    controlsContainer.appendChild(prevButton);
    
    // Crear indicadores en el centro
    const indicatorsContainer = document.createElement("div");
    indicatorsContainer.className = "carousel-indicators-tres";
    indicatorsContainer.style.display = "flex";
    indicatorsContainer.style.justifyContent = "center";
    indicatorsContainer.style.gap = "15px";
    
    for (let i = 0; i < totalPages; i++) {
        const indicator = document.createElement("button");
        indicator.className = "carousel-indicator-tres";
        if (i === 0) indicator.classList.add("active");
        indicator.onclick = () => {
            currentPage = i;
            moveCarousel(i);
            console.log(`🎯 Indicador clickeado: página ${i + 1}`);
            stopAutoPlay();
            setTimeout(startAutoPlay, 3000);
        };
        indicatorsContainer.appendChild(indicator);
    }
    
    controlsContainer.appendChild(indicatorsContainer);
    controlsContainer.appendChild(nextButton);
    
    carouselContainer.parentNode.insertBefore(controlsContainer, carouselContainer.nextSibling);
    
    // Función para actualizar indicadores
    function updateIndicators() {
        const indicators = document.querySelectorAll(".carousel-indicator-tres");
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle("active", index === currentPage);
        });
    }
    
    // Auto-play mejorado
    function startAutoPlay() {
        autoPlayInterval = setInterval(() => {
            nextPage();
        }, 6000); // Cambiar cada 6 segundos
        console.log("▶️ Auto-play iniciado (6 segundos)");
    }
    
    function stopAutoPlay() {
        clearInterval(autoPlayInterval);
        console.log("⏸️ Auto-play pausado");
    }
    
    // Pausar auto-play al hacer hover
    carouselContainer.addEventListener("mouseenter", stopAutoPlay);
    carouselContainer.addEventListener("mouseleave", startAutoPlay);
    
    // Iniciar auto-play
    startAutoPlay();
    
    // Soporte para touch/swipe en móviles
    let startX = 0;
    let currentX = 0;
    let isDragging = false;
    
    carouselContainer.addEventListener("touchstart", (e) => {
        startX = e.touches[0].clientX;
        isDragging = true;
        stopAutoPlay();
    });
    
    carouselContainer.addEventListener("touchmove", (e) => {
        if (!isDragging) return;
        currentX = e.touches[0].clientX;
        const diffX = startX - currentX;
        
        // Mostrar preview del movimiento
        const currentTransform = -currentPage * 100;
        const movePercent = (diffX / carouselContainer.offsetWidth) * 100;
        carouselTrack.style.transition = "none";
        carouselTrack.style.transform = `translateX(${currentTransform - movePercent}%)`;
    });
    
    carouselContainer.addEventListener("touchend", (e) => {
        if (!isDragging) return;
        isDragging = false;
        
        const diffX = startX - currentX;
        const threshold = 50;
        
        if (Math.abs(diffX) > threshold) {
            if (diffX > 0) {
                nextPage();
            } else {
                prevPage();
            }
        } else {
            // Volver a la posición original
            moveCarousel(currentPage);
        }
        
        startAutoPlay();
    });
    
    // Inicializar posición
    moveCarousel(0, false);
});
</script>
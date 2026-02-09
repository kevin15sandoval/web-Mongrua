<?php
/**
 * CREAR CARRUSEL 3 EN 3 COMPLETO
 * Carrusel que muestra 3 cursos, integrado con gestión y botón "Ver más info"
 */

echo "<!DOCTYPE html>";
echo "<html><head><title>Crear Carrusel 3 en 3 Completo</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{background:#d4edda;color:#155724;padding:15px;margin:10px 0;border-radius:5px;} .error{background:#f8d7da;color:#721c24;padding:15px;margin:10px 0;border-radius:5px;}</style>";
echo "</head><body>";

echo "<h1>🎠 CREAR CARRUSEL 3 EN 3 COMPLETO</h1>";

$theme_path = __DIR__ . '/wp-content/themes/mongruas-theme';

// 1. Crear página de detalle de curso
$curso_detalle_content = '<?php
/**
 * Página de Detalle de Curso
 * Muestra toda la información completa de un curso
 */

// Obtener ID del curso
$curso_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

// Obtener cursos del sistema
$courses = get_option("mongruas_courses", []);
$curso = null;

// Buscar el curso por ID
foreach ($courses as $c) {
    if (isset($c["id"]) && $c["id"] == $curso_id) {
        $curso = $c;
        break;
    }
}

// Si no se encuentra el curso, mostrar error
if (!$curso) {
    wp_redirect(home_url("/anuncios/"));
    exit;
}

get_header();
?>

<style>
.curso-detalle-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
    background: #f8f9fa;
    min-height: 100vh;
}

.curso-detalle-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.curso-hero {
    background: linear-gradient(135deg, #3498db, #27ae60);
    color: white;
    padding: 60px 40px;
    text-align: center;
    position: relative;
}

.curso-hero::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.1\"%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"4\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.3;
}

.curso-hero-content {
    position: relative;
    z-index: 2;
}

.curso-badge {
    background: rgba(255,255,255,0.2);
    color: white;
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 700;
    text-transform: uppercase;
    display: inline-block;
    margin-bottom: 20px;
    border: 2px solid rgba(255,255,255,0.3);
}

.curso-titulo {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 20px;
    line-height: 1.2;
}

.curso-fecha-grande {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
}

.curso-stats {
    display: flex;
    justify-content: center;
    gap: 40px;
    flex-wrap: wrap;
}

.stat-item {
    text-align: center;
    background: rgba(255,255,255,0.15);
    padding: 20px;
    border-radius: 15px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
}

.stat-icon {
    font-size: 2rem;
    margin-bottom: 10px;
    display: block;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
    margin-bottom: 5px;
}

.stat-value {
    font-size: 1.2rem;
    font-weight: 700;
}

.curso-content {
    padding: 50px 40px;
}

.content-section {
    margin-bottom: 40px;
}

.section-title {
    font-size: 2rem;
    color: #2c3e50;
    margin-bottom: 20px;
    font-weight: 700;
    position: relative;
    padding-bottom: 10px;
}

.section-title::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, #3498db, #27ae60);
    border-radius: 2px;
}

.descripcion-completa {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #555;
    background: #f8f9fa;
    padding: 30px;
    border-radius: 15px;
    border-left: 5px solid #3498db;
}

.detalles-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 30px;
}

.detalle-card {
    background: #f8f9fa;
    padding: 25px;
    border-radius: 15px;
    text-align: center;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.detalle-card:hover {
    border-color: #3498db;
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(52, 152, 219, 0.1);
}

.detalle-icon {
    font-size: 2.5rem;
    margin-bottom: 15px;
    color: #3498db;
}

.detalle-titulo {
    font-size: 1.1rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 10px;
}

.detalle-valor {
    font-size: 1rem;
    color: #666;
}

.acciones-container {
    background: linear-gradient(135deg, #2c3e50, #34495e);
    color: white;
    padding: 40px;
    text-align: center;
    border-radius: 20px;
    margin-top: 40px;
}

.acciones-titulo {
    font-size: 2rem;
    margin-bottom: 20px;
    font-weight: 700;
}

.acciones-descripcion {
    font-size: 1.1rem;
    margin-bottom: 30px;
    opacity: 0.9;
}

.botones-accion {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
}

.btn-accion {
    padding: 15px 30px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 700;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.btn-reservar {
    background: linear-gradient(135deg, #27ae60, #229954);
    color: white;
    box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
}

.btn-reservar:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(39, 174, 96, 0.4);
    color: white;
    text-decoration: none;
}

.btn-contacto {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
}

.btn-contacto:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4);
    color: white;
    text-decoration: none;
}

.btn-volver {
    background: rgba(255,255,255,0.2);
    color: white;
    border: 2px solid rgba(255,255,255,0.3);
}

.btn-volver:hover {
    background: rgba(255,255,255,0.3);
    color: white;
    text-decoration: none;
}

/* Responsive */
@media (max-width: 768px) {
    .curso-detalle-container {
        padding: 20px 15px;
    }
    
    .curso-hero {
        padding: 40px 20px;
    }
    
    .curso-titulo {
        font-size: 2.2rem;
    }
    
    .curso-content {
        padding: 30px 20px;
    }
    
    .curso-stats {
        gap: 20px;
    }
    
    .stat-item {
        padding: 15px;
    }
    
    .botones-accion {
        flex-direction: column;
        align-items: center;
    }
    
    .btn-accion {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
}
</style>

<div class="curso-detalle-container">
    
    <!-- Hero del Curso -->
    <div class="curso-detalle-card">
        <div class="curso-hero">
            <div class="curso-hero-content">
                <div class="curso-badge">Próximamente</div>
                <h1 class="curso-titulo"><?php echo esc_html($curso["name"]); ?></h1>
                <div class="curso-fecha-grande">
                    <span>📅</span>
                    <span><?php echo esc_html($curso["date"]); ?></span>
                </div>
                
                <div class="curso-stats">
                    <div class="stat-item">
                        <span class="stat-icon">⏱️</span>
                        <div class="stat-label">Plazas</div>
                        <div class="stat-value"><?php echo esc_html($curso["duration"]); ?></div>
                    </div>
                    <div class="stat-item">
                        <span class="stat-icon">💻</span>
                        <div class="stat-label">Modalidad</div>
                        <div class="stat-value"><?php echo esc_html($curso["modality"]); ?></div>
                    </div>
                    <?php if (isset($curso["hours"])): ?>
                    <div class="stat-item">
                        <span class="stat-icon">🕐</span>
                        <div class="stat-label">Duración</div>
                        <div class="stat-value"><?php echo esc_html($curso["hours"]); ?></div>
                    </div>
                    <?php endif; ?>
                    <?php if (isset($curso["price"])): ?>
                    <div class="stat-item">
                        <span class="stat-icon">💰</span>
                        <div class="stat-label">Precio</div>
                        <div class="stat-value"><?php echo esc_html($curso["price"]); ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Contenido del Curso -->
        <div class="curso-content">
            
            <!-- Descripción -->
            <div class="content-section">
                <h2 class="section-title">Descripción del Curso</h2>
                <div class="descripcion-completa">
                    <?php 
                    $descripcion = isset($curso["full_description"]) ? $curso["full_description"] : $curso["description"];
                    echo esc_html($descripcion); 
                    ?>
                </div>
            </div>
            
            <!-- Detalles -->
            <div class="content-section">
                <h2 class="section-title">Detalles del Curso</h2>
                <div class="detalles-grid">
                    <div class="detalle-card">
                        <div class="detalle-icon">📚</div>
                        <div class="detalle-titulo">Modalidad</div>
                        <div class="detalle-valor"><?php echo esc_html($curso["modality"]); ?></div>
                    </div>
                    <div class="detalle-card">
                        <div class="detalle-icon">👥</div>
                        <div class="detalle-titulo">Plazas Disponibles</div>
                        <div class="detalle-valor"><?php echo esc_html($curso["duration"]); ?></div>
                    </div>
                    <?php if (isset($curso["hours"])): ?>
                    <div class="detalle-card">
                        <div class="detalle-icon">⏰</div>
                        <div class="detalle-titulo">Duración Total</div>
                        <div class="detalle-valor"><?php echo esc_html($curso["hours"]); ?></div>
                    </div>
                    <?php endif; ?>
                    <div class="detalle-card">
                        <div class="detalle-icon">📅</div>
                        <div class="detalle-titulo">Fecha de Inicio</div>
                        <div class="detalle-valor"><?php echo esc_html($curso["date"]); ?></div>
                    </div>
                    <?php if (isset($curso["price"])): ?>
                    <div class="detalle-card">
                        <div class="detalle-icon">💰</div>
                        <div class="detalle-titulo">Precio</div>
                        <div class="detalle-valor"><?php echo esc_html($curso["price"]); ?></div>
                    </div>
                    <?php endif; ?>
                    <div class="detalle-card">
                        <div class="detalle-icon">🎓</div>
                        <div class="detalle-titulo">Certificado</div>
                        <div class="detalle-valor">Oficial</div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <!-- Acciones -->
    <div class="acciones-container">
        <h2 class="acciones-titulo">¿Te interesa este curso?</h2>
        <p class="acciones-descripcion">
            Reserva tu plaza ahora o contáctanos para más información
        </p>
        
        <div class="botones-accion">
            <a href="#contact" class="btn-accion btn-reservar">
                <span>🎯</span>
                <span>Reservar Plaza</span>
            </a>
            <a href="#contact" class="btn-accion btn-contacto">
                <span>📞</span>
                <span>Más Información</span>
            </a>
            <a href="<?php echo home_url("/anuncios/"); ?>" class="btn-accion btn-volver">
                <span>←</span>
                <span>Volver a Cursos</span>
            </a>
        </div>
    </div>
    
</div>

<?php get_footer(); ?>';

$curso_detalle_path = $theme_path . '/page-templates/curso-detalle.php';
if (file_put_contents($curso_detalle_path, $curso_detalle_content)) {
    echo "<div class='success'>✅ Página de detalle de curso creada: curso-detalle.php</div>";
} else {
    echo "<div class='error'>❌ Error al crear página de detalle</div>";
}

// 2. Actualizar el template de anuncios con carrusel 3 en 3
echo "<h2>🔧 Actualizando Template con Carrusel 3 en 3</h2>";

// Leer el template actual
$template_path = $theme_path . '/page-templates/page-cursos.php';
$template_content = file_get_contents($template_path);

// Buscar la sección de próximos cursos y reemplazarla
$new_carousel_section = '    <!-- CARRUSEL 3 EN 3 - INTEGRADO CON GESTIÓN -->
    <section class="carousel-3-en-3-section">
        <div class="container">
            <div class="section-header">
                <h2>Próximos Cursos</h2>
                <p>Cursos que comenzarán próximamente. ¡Reserva tu plaza!</p>
            </div>
            
            <div class="carousel-3-container">
                <div class="carousel-3-track" id="carousel-3-track">
                    <?php
                    // Obtener cursos del sistema dinámico
                    $courses = get_option("mongruas_courses", []);
                    
                    // Si no hay cursos, crear algunos por defecto
                    if (empty($courses)) {
                        $courses = [
                            [
                                "id" => 1,
                                "name" => "Montaje y Mantenimiento de Instalaciones Eléctricas", 
                                "date" => "Enero 2025", 
                                "modality" => "Presencial", 
                                "duration" => "15 plazas", 
                                "description" => "Curso completo de instalaciones eléctricas de baja tensión con certificado oficial.",
                                "full_description" => "Este curso te capacitará para realizar instalaciones eléctricas de baja tensión según el REBT. Incluye prácticas reales y certificado oficial.",
                                "price" => "Gratuito",
                                "hours" => "120 horas"
                            ],
                            [
                                "id" => 2,
                                "name" => "Sistemas Domóticos e Inmóticos", 
                                "date" => "Febrero 2025", 
                                "modality" => "Presencial", 
                                "duration" => "12 plazas", 
                                "description" => "Especialización en automatización de edificios y sistemas inteligentes.",
                                "full_description" => "Aprende a diseñar e instalar sistemas domóticos e inmóticos. Tecnología de vanguardia para el futuro de los edificios inteligentes.",
                                "price" => "Gratuito",
                                "hours" => "80 horas"
                            ],
                            [
                                "id" => 3,
                                "name" => "Control de Plagas", 
                                "date" => "Marzo 2025", 
                                "modality" => "Presencial", 
                                "duration" => "10 plazas", 
                                "description" => "Formación profesional en control y prevención de plagas urbanas.",
                                "full_description" => "Conviértete en técnico especialista en control de plagas. Certificación oficial para ejercer profesionalmente en el sector.",
                                "price" => "Gratuito",
                                "hours" => "60 horas"
                            ],
                            [
                                "id" => 4,
                                "name" => "Prevención de Riesgos Laborales", 
                                "date" => "Abril 2025", 
                                "modality" => "Online", 
                                "duration" => "20 plazas", 
                                "description" => "Curso completo de PRL con certificado oficial.",
                                "full_description" => "Formación completa en Prevención de Riesgos Laborales. Conviértete en técnico superior en PRL con todas las especialidades.",
                                "price" => "Gratuito",
                                "hours" => "200 horas"
                            ],
                            [
                                "id" => 5,
                                "name" => "Soldadura con Electrodo Revestido", 
                                "date" => "Mayo 2025", 
                                "modality" => "Presencial", 
                                "duration" => "8 plazas", 
                                "description" => "Curso práctico de soldadura con certificación oficial.",
                                "full_description" => "Aprende las técnicas de soldadura con electrodo revestido. Curso 100% práctico con certificación oficial para trabajar en el sector.",
                                "price" => "Gratuito",
                                "hours" => "100 horas"
                            ],
                            [
                                "id" => 6,
                                "name" => "Gestión de Almacén", 
                                "date" => "Junio 2025", 
                                "modality" => "Mixta", 
                                "duration" => "15 plazas", 
                                "description" => "Gestión eficiente de almacenes y logística.",
                                "full_description" => "Conviértete en experto en gestión de almacenes. Aprende sobre logística, inventarios y sistemas de gestión modernos.",
                                "price" => "Gratuito",
                                "hours" => "90 horas"
                            ]
                        ];
                        update_option("mongruas_courses", $courses);
                    }
                    
                    // Mostrar todos los cursos
                    foreach ($courses as $course):
                        $curso_id = isset($course["id"]) ? $course["id"] : uniqid();
                    ?>
                    
                    <div class="carousel-3-card">
                        <div class="card-header">
                            <div class="course-badge">Próximamente</div>
                            <div class="course-date">
                                <span class="date-icon">📅</span>
                                <span class="date-text"><?php echo esc_html($course["date"]); ?></span>
                            </div>
                        </div>
                        
                        <div class="card-content">
                            <h3 class="course-title"><?php echo esc_html($course["name"]); ?></h3>
                            <p class="course-description"><?php echo esc_html($course["description"]); ?></p>
                            
                            <div class="course-details">
                                <div class="detail-item">
                                    <span class="detail-icon">⏱️</span>
                                    <span><?php echo esc_html($course["duration"]); ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-icon">💻</span>
                                    <span><?php echo esc_html($course["modality"]); ?></span>
                                </div>
                                <?php if (isset($course["hours"])): ?>
                                <div class="detail-item">
                                    <span class="detail-icon">🕐</span>
                                    <span><?php echo esc_html($course["hours"]); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="card-actions">
                            <a href="<?php echo home_url("/curso-detalle/?id=" . $curso_id); ?>" class="btn-ver-mas">
                                Ver Más Información
                            </a>
                            <a href="#contact" class="btn-reservar">
                                Reservar Plaza
                            </a>
                        </div>
                    </div>
                    
                    <?php endforeach; ?>
                </div>
                
                <!-- Controles del Carrusel -->
                <div class="carousel-3-controls">
                    <button class="carousel-3-btn prev-btn" id="prev-btn-3" onclick="moveCarousel3(-1)">
                        ←
                    </button>
                    <button class="carousel-3-btn next-btn" id="next-btn-3" onclick="moveCarousel3(1)">
                        →
                    </button>
                </div>
                
                <!-- Indicadores -->
                <div class="carousel-3-indicators" id="carousel-3-indicators">
                    <!-- Se generan dinámicamente con JavaScript -->
                </div>
            </div>
        </div>
    </section>';

// Reemplazar la sección existente
$pattern = '/<!-- PRÓXIMOS CURSOS.*?<\/section>/s';
$template_content = preg_replace($pattern, $new_carousel_section, $template_content);

if (file_put_contents($template_path, $template_content)) {
    echo "<div class='success'>✅ Template actualizado con carrusel 3 en 3</div>";
} else {
    echo "<div class='error'>❌ Error al actualizar template</div>";
}

echo "<h3>🔗 Archivos Creados:</h3>";
echo "<ul>";
echo "<li><code>curso-detalle.php</code> - Página de detalle completa</li>";
echo "<li><code>page-cursos.php</code> - Template actualizado con carrusel 3 en 3</li>";
echo "</ul>";

echo "<h3>🎯 Próximos Pasos:</h3>";
echo "<ol>";
echo "<li>Crear los estilos CSS para el carrusel 3 en 3</li>";
echo "<li>Crear el JavaScript para el funcionamiento del carrusel</li>";
echo "<li>Probar la integración con el sistema de gestión</li>";
echo "</ol>";

echo "<p><a href='/crear-estilos-carrusel-3.php' style='background: #3498db; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; margin: 10px 0;'>➡️ CONTINUAR: Crear Estilos CSS</a></p>";

echo "</body></html>";
?>
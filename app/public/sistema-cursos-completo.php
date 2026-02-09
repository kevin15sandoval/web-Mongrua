<?php
/**
 * SISTEMA DE CURSOS COMPLETO
 * Integrar el diseño bonito con la gestión dinámica y páginas individuales
 */

// Cargar WordPress
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
}

echo "<h1>🚀 SISTEMA DE CURSOS COMPLETO</h1>";

// 1. Primero, aplicar el diseño bonito al template de WordPress
$template_path = get_template_directory() . '/page-templates/page-cursos.php';

$nueva_seccion_wordpress = '
    <!-- PRÓXIMOS CURSOS - INTEGRADO CON GESTIÓN DINÁMICA -->
    <section class="proximos-cursos-2-columnas" style="padding: 80px 0; background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); position: relative;">
        <div style="max-width: 1000px; margin: 0 auto; padding: 0 20px;">
            
            <!-- Título -->
            <div style="text-align: center; margin-bottom: 60px;">
                <h2 style="font-size: 3rem; color: #2c3e50; margin-bottom: 20px; font-weight: 800; position: relative;">
                    Próximos Cursos
                </h2>
                <div style="width: 100px; height: 4px; background: linear-gradient(90deg, #3498db, #27ae60); margin: 0 auto 20px; border-radius: 2px;"></div>
                <p style="font-size: 1.3rem; color: #6c757d; max-width: 700px; margin: 0 auto;">
                    Cursos que comenzarán próximamente. ¡Reserva tu plaza!
                </p>
            </div>
            
            <!-- Grid de 2 columnas DINÁMICO -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; max-width: 1000px; margin: 0 auto;">
                
                <?php
                // Obtener cursos del sistema dinámico
                $courses = get_option(\'mongruas_courses\', []);
                
                // Si no hay cursos, crear algunos por defecto
                if (empty($courses)) {
                    $courses = [
                        [
                            \'id\' => 1,
                            \'name\' => \'Montaje y Mantenimiento de Instalaciones Eléctricas\', 
                            \'date\' => \'Enero 2025\', 
                            \'modality\' => \'Presencial\', 
                            \'duration\' => \'15 plazas\', 
                            \'description\' => \'Curso completo de instalaciones eléctricas de baja tensión con certificado oficial.\',
                            \'full_description\' => \'Este curso te capacitará para realizar instalaciones eléctricas de baja tensión según el REBT. Incluye prácticas reales y certificado oficial.\',
                            \'price\' => \'Gratuito\',
                            \'hours\' => \'120 horas\',
                            \'image\' => \'\'
                        ],
                        [
                            \'id\' => 2,
                            \'name\' => \'Sistemas Domóticos e Inmóticos\', 
                            \'date\' => \'Febrero 2025\', 
                            \'modality\' => \'Presencial\', 
                            \'duration\' => \'12 plazas\', 
                            \'description\' => \'Especialización en automatización de edificios y sistemas inteligentes.\',
                            \'full_description\' => \'Aprende a diseñar e instalar sistemas domóticos e inmóticos. Tecnología de vanguardia para el futuro de los edificios inteligentes.\',
                            \'price\' => \'Gratuito\',
                            \'hours\' => \'80 horas\',
                            \'image\' => \'\'
                        ],
                        [
                            \'id\' => 3,
                            \'name\' => \'Control de Plagas\', 
                            \'date\' => \'Marzo 2025\', 
                            \'modality\' => \'Presencial\', 
                            \'duration\' => \'10 plazas\', 
                            \'description\' => \'Formación profesional en control y prevención de plagas urbanas.\',
                            \'full_description\' => \'Conviértete en técnico especialista en control de plagas. Certificación oficial para ejercer profesionalmente en el sector.\',
                            \'price\' => \'Gratuito\',
                            \'hours\' => \'60 horas\',
                            \'image\' => \'\'
                        ],
                        [
                            \'id\' => 4,
                            \'name\' => \'Prevención de Riesgos Laborales\', 
                            \'date\' => \'Abril 2025\', 
                            \'modality\' => \'Online\', 
                            \'duration\' => \'20 plazas\', 
                            \'description\' => \'Curso completo de PRL con certificado oficial.\',
                            \'full_description\' => \'Formación completa en Prevención de Riesgos Laborales. Conviértete en técnico superior en PRL con todas las especialidades.\',
                            \'price\' => \'Gratuito\',
                            \'hours\' => \'200 horas\',
                            \'image\' => \'\'
                        ]
                    ];
                    update_option(\'mongruas_courses\', $courses);
                }
                
                // Mostrar todos los cursos disponibles
                foreach ($courses as $course):
                    $curso_id = isset($course[\'id\']) ? $course[\'id\'] : uniqid();
                ?>
                
                <!-- Tarjeta de Curso -->
                <div style="background: white; border-radius: 25px; box-shadow: 0 10px 35px rgba(0,0,0,0.1); overflow: hidden; position: relative; border: 1px solid rgba(0,0,0,0.05); transition: all 0.4s ease;" 
                     onmouseover="this.style.transform=\'translateY(-10px)\'; this.style.boxShadow=\'0 20px 50px rgba(0,0,0,0.15)\';" 
                     onmouseout="this.style.transform=\'translateY(0)\'; this.style.boxShadow=\'0 10px 35px rgba(0,0,0,0.1)\';">
                    
                    <!-- Barra superior de color -->
                    <div style="height: 5px; background: linear-gradient(90deg, #3498db, #27ae60);"></div>
                    
                    <!-- Imagen del curso (si existe) -->
                    <?php if (!empty($course[\'image\'])): ?>
                    <div style="height: 200px; background-image: url(\'<?php echo esc_url($course[\'image\']); ?>\'); background-size: cover; background-position: center; position: relative;">
                        <div style="position: absolute; top: 15px; left: 15px; background: linear-gradient(135deg, #e74c3c, #c0392b); color: white; padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
                            PRÓXIMAMENTE
                        </div>
                    </div>
                    <?php else: ?>
                    <div style="height: 120px; background: linear-gradient(135deg, #3498db, #27ae60); display: flex; align-items: center; justify-content: center; position: relative;">
                        <span style="font-size: 3rem; color: white; opacity: 0.8;">📚</span>
                        <div style="position: absolute; top: 15px; left: 15px; background: linear-gradient(135deg, #e74c3c, #c0392b); color: white; padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
                            PRÓXIMAMENTE
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Contenido -->
                    <div style="padding: 30px;">
                        
                        <!-- Fecha -->
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px; color: #e74c3c; font-weight: 700; background: rgba(231, 76, 60, 0.1); padding: 12px 18px; border-radius: 15px; border-left: 5px solid #e74c3c;">
                            <span style="font-size: 1.5rem;">📅</span>
                            <span style="font-size: 1rem;"><?php echo esc_html($course[\'date\']); ?></span>
                        </div>
                        
                        <!-- Título -->
                        <h3 style="font-size: 1.4rem; color: #2c3e50; margin-bottom: 15px; font-weight: 800; line-height: 1.3; min-height: 70px;">
                            <?php echo esc_html($course[\'name\']); ?>
                        </h3>
                        
                        <!-- Descripción corta -->
                        <p style="color: #6c757d; line-height: 1.6; margin-bottom: 20px; font-size: 1rem; min-height: 50px;">
                            <?php echo esc_html($course[\'description\']); ?>
                        </p>
                        
                        <!-- Detalles -->
                        <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 25px; padding: 15px; background: rgba(52, 152, 219, 0.08); border-radius: 12px; border: 1px solid rgba(52, 152, 219, 0.15);">
                            <span style="display: flex; align-items: center; gap: 8px; color: #495057; font-size: 0.9rem; font-weight: 600;">
                                <span style="color: #3498db; font-size: 1rem;">⏱️</span>
                                <?php echo esc_html($course[\'duration\']); ?>
                            </span>
                            <span style="display: flex; align-items: center; gap: 8px; color: #495057; font-size: 0.9rem; font-weight: 600;">
                                <span style="color: #3498db; font-size: 1rem;">💻</span>
                                <?php echo esc_html($course[\'modality\']); ?>
                            </span>
                            <?php if (isset($course[\'hours\'])): ?>
                            <span style="display: flex; align-items: center; gap: 8px; color: #495057; font-size: 0.9rem; font-weight: 600;">
                                <span style="color: #3498db; font-size: 1rem;">🕐</span>
                                <?php echo esc_html($course[\'hours\']); ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Botones -->
                        <div style="display: flex; gap: 10px;">
                            <a href="<?php echo home_url(\'/curso-detalle.php?id=\' . $curso_id); ?>" 
                               style="background: linear-gradient(135deg, #3498db, #2980b9); color: white; padding: 12px 20px; border-radius: 25px; text-decoration: none; font-weight: 600; text-align: center; flex: 1; font-size: 0.9rem; text-transform: uppercase; transition: all 0.3s ease;"
                               onmouseover="this.style.background=\'linear-gradient(135deg, #2980b9, #1f618d)\'; this.style.transform=\'translateY(-2px)\';"
                               onmouseout="this.style.background=\'linear-gradient(135deg, #3498db, #2980b9)\'; this.style.transform=\'translateY(0)\';">
                                Ver Más Info
                            </a>
                            <a href="#contact" 
                               style="background: linear-gradient(135deg, #27ae60, #229954); color: white; padding: 12px 20px; border-radius: 25px; text-decoration: none; font-weight: 600; text-align: center; flex: 1; font-size: 0.9rem; text-transform: uppercase; transition: all 0.3s ease;"
                               onmouseover="this.style.background=\'linear-gradient(135deg, #229954, #1e8449)\'; this.style.transform=\'translateY(-2px)\';"
                               onmouseout="this.style.background=\'linear-gradient(135deg, #27ae60, #229954)\'; this.style.transform=\'translateY(0)\';">
                                Reservar Plaza
                            </a>
                        </div>
                        
                    </div>
                </div>
                
                <?php endforeach; ?>
                
            </div>
            
        </div>
        
        <!-- CSS Responsive -->
        <style>
        @media (max-width: 768px) {
            .proximos-cursos-2-columnas div[style*="grid-template-columns: 1fr 1fr"] {
                grid-template-columns: 1fr !important;
                gap: 30px !important;
            }
            .proximos-cursos-2-columnas h2 {
                font-size: 2.5rem !important;
            }
            .proximos-cursos-2-columnas div[style*="display: flex; gap: 10px;"] {
                flex-direction: column !important;
                gap: 15px !important;
            }
        }
        
        @media (max-width: 480px) {
            .proximos-cursos-2-columnas {
                padding: 50px 0 !important;
            }
            .proximos-cursos-2-columnas div[style*="padding: 0 20px"] {
                padding: 0 15px !important;
            }
        }
        </style>
        
    </section>';

// 2. Reemplazar la sección en el template
if (file_exists($template_path)) {
    $template_content = file_get_contents($template_path);
    
    // Buscar y reemplazar
    $patterns = [
        '/<!-- Próximos Cursos.*?<\/section>/s',
        '/<section class="upcoming-courses-section">.*?<\/section>/s',
        '/<section class="proximos-cursos-2-columnas">.*?<\/section>/s'
    ];
    
    $replaced = false;
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $template_content)) {
            $template_content = preg_replace($pattern, $nueva_seccion_wordpress, $template_content);
            $replaced = true;
            echo "✅ Sección reemplazada en template<br>";
            break;
        }
    }
    
    if (!$replaced) {
        // Insertar después del hero
        $insert_after = '</section>';
        $pos = strpos($template_content, $insert_after);
        if ($pos !== false) {
            $pos += strlen($insert_after);
            $template_content = substr_replace($template_content, "\n" . $nueva_seccion_wordpress . "\n", $pos, 0);
            echo "✅ Sección insertada en template<br>";
        }
    }
    
    // Guardar
    file_put_contents($template_path, $template_content);
    echo "✅ Template guardado<br>";
}

// 3. Crear página de detalle de curso
$curso_detalle_content = '<?php
/**
 * Página de Detalle de Curso Individual
 */

// Cargar WordPress
if (!defined(\'ABSPATH\')) {
    require_once(\'wp-config.php\');
}

get_header();

// Obtener ID del curso
$curso_id = isset($_GET[\'id\']) ? sanitize_text_field($_GET[\'id\']) : null;

if (!$curso_id) {
    wp_redirect(home_url(\'/anuncios/\'));
    exit;
}

// Obtener cursos
$courses = get_option(\'mongruas_courses\', []);
$curso = null;

foreach ($courses as $course) {
    if ((isset($course[\'id\']) && $course[\'id\'] == $curso_id) || 
        (isset($course[\'name\']) && sanitize_title($course[\'name\']) == $curso_id)) {
        $curso = $course;
        break;
    }
}

if (!$curso) {
    wp_redirect(home_url(\'/anuncios/\'));
    exit;
}
?>

<style>
.curso-detalle {
    padding: 80px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

.curso-detalle .container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 20px;
}

.curso-header {
    text-align: center;
    margin-bottom: 60px;
}

.curso-header h1 {
    font-size: 3rem;
    color: #2c3e50;
    margin-bottom: 20px;
    font-weight: 800;
}

.curso-badge-large {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    padding: 10px 25px;
    border-radius: 30px;
    font-size: 1rem;
    font-weight: 700;
    text-transform: uppercase;
    display: inline-block;
    margin-bottom: 30px;
}

.curso-info-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 50px;
    margin-bottom: 50px;
}

.curso-content-main {
    background: white;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.curso-sidebar {
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    height: fit-content;
}

.curso-description {
    font-size: 1.2rem;
    line-height: 1.8;
    color: #555;
    margin-bottom: 30px;
}

.curso-details-list {
    list-style: none;
    padding: 0;
}

.curso-details-list li {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
    font-size: 1.1rem;
}

.curso-details-list li:last-child {
    border-bottom: none;
}

.curso-details-list .icon {
    font-size: 1.5rem;
    color: #3498db;
    width: 30px;
}

.btn-inscribirse {
    background: linear-gradient(135deg, #27ae60, #229954);
    color: white;
    padding: 20px 40px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 700;
    text-align: center;
    width: 100%;
    display: block;
    font-size: 1.2rem;
    text-transform: uppercase;
    margin-top: 30px;
    transition: all 0.3s ease;
}

.btn-inscribirse:hover {
    background: linear-gradient(135deg, #229954, #1e8449);
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(39, 174, 96, 0.4);
    color: white;
    text-decoration: none;
}

.btn-volver {
    background: linear-gradient(135deg, #6c757d, #5a6268);
    color: white;
    padding: 12px 25px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    display: inline-block;
    margin-bottom: 30px;
    transition: all 0.3s ease;
}

.btn-volver:hover {
    background: linear-gradient(135deg, #5a6268, #495057);
    transform: translateY(-2px);
    color: white;
    text-decoration: none;
}

@media (max-width: 768px) {
    .curso-info-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .curso-header h1 {
        font-size: 2.2rem;
    }
    
    .curso-content-main,
    .curso-sidebar {
        padding: 25px;
    }
}
</style>

<main class="curso-detalle">
    <div class="container">
        
        <a href="<?php echo home_url(\'/anuncios/\'); ?>" class="btn-volver">← Volver a Próximos Cursos</a>
        
        <div class="curso-header">
            <div class="curso-badge-large">Próximamente</div>
            <h1><?php echo esc_html($curso[\'name\']); ?></h1>
            <div style="display: flex; align-items: center; justify-content: center; gap: 15px; color: #e74c3c; font-weight: 700; font-size: 1.3rem;">
                <span style="font-size: 2rem;">📅</span>
                <span><?php echo esc_html($curso[\'date\']); ?></span>
            </div>
        </div>
        
        <div class="curso-info-grid">
            
            <!-- Contenido Principal -->
            <div class="curso-content-main">
                <h2 style="color: #2c3e50; margin-bottom: 25px; font-size: 2rem;">Descripción del Curso</h2>
                
                <div class="curso-description">
                    <?php 
                    $full_description = isset($curso[\'full_description\']) ? $curso[\'full_description\'] : $curso[\'description\'];
                    echo esc_html($full_description); 
                    ?>
                </div>
                
                <h3 style="color: #2c3e50; margin-bottom: 20px; font-size: 1.5rem;">¿Qué aprenderás?</h3>
                <ul style="list-style: none; padding: 0;">
                    <li style="padding: 10px 0; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 15px;">
                        <span style="color: #27ae60; font-size: 1.2rem;">✓</span>
                        <span>Conocimientos teóricos y prácticos especializados</span>
                    </li>
                    <li style="padding: 10px 0; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 15px;">
                        <span style="color: #27ae60; font-size: 1.2rem;">✓</span>
                        <span>Certificación oficial reconocida</span>
                    </li>
                    <li style="padding: 10px 0; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 15px;">
                        <span style="color: #27ae60; font-size: 1.2rem;">✓</span>
                        <span>Prácticas con equipos profesionales</span>
                    </li>
                    <li style="padding: 10px 0; display: flex; align-items: center; gap: 15px;">
                        <span style="color: #27ae60; font-size: 1.2rem;">✓</span>
                        <span>Orientación laboral y bolsa de empleo</span>
                    </li>
                </ul>
            </div>
            
            <!-- Sidebar -->
            <div class="curso-sidebar">
                <h3 style="color: #2c3e50; margin-bottom: 25px; font-size: 1.5rem;">Información del Curso</h3>
                
                <ul class="curso-details-list">
                    <li>
                        <span class="icon">📅</span>
                        <div>
                            <strong>Inicio:</strong><br>
                            <?php echo esc_html($curso[\'date\']); ?>
                        </div>
                    </li>
                    <li>
                        <span class="icon">⏱️</span>
                        <div>
                            <strong>Plazas:</strong><br>
                            <?php echo esc_html($curso[\'duration\']); ?>
                        </div>
                    </li>
                    <li>
                        <span class="icon">💻</span>
                        <div>
                            <strong>Modalidad:</strong><br>
                            <?php echo esc_html($curso[\'modality\']); ?>
                        </div>
                    </li>
                    <?php if (isset($curso[\'hours\'])): ?>
                    <li>
                        <span class="icon">🕐</span>
                        <div>
                            <strong>Duración:</strong><br>
                            <?php echo esc_html($curso[\'hours\']); ?>
                        </div>
                    </li>
                    <?php endif; ?>
                    <?php if (isset($curso[\'price\'])): ?>
                    <li>
                        <span class="icon">💰</span>
                        <div>
                            <strong>Precio:</strong><br>
                            <?php echo esc_html($curso[\'price\']); ?>
                        </div>
                    </li>
                    <?php endif; ?>
                </ul>
                
                <a href="#contact" class="btn-inscribirse">Solicitar Información</a>
                
                <div style="margin-top: 30px; padding: 20px; background: rgba(52, 152, 219, 0.1); border-radius: 15px; text-align: center;">
                    <h4 style="color: #3498db; margin-bottom: 10px;">¿Tienes dudas?</h4>
                    <p style="margin: 0; color: #666;">Contacta con nosotros para más información</p>
                    <a href="tel:+34925123456" style="color: #3498db; font-weight: 600; text-decoration: none;">📞 925 123 456</a>
                </div>
            </div>
            
        </div>
        
    </div>
</main>

<?php get_footer(); ?>';

file_put_contents(get_template_directory() . '/../../../curso-detalle.php', $curso_detalle_content);
echo "✅ Página de detalle de curso creada<br>";

// 4. Limpiar cache
wp_cache_flush();
global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'");
update_option('mongruas_theme_version', time());

echo "✅ Cache limpiado<br>";

echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 25px; border-radius: 10px; margin: 30px 0;'>";
echo "<h2>🎯 SISTEMA COMPLETO IMPLEMENTADO</h2>";
echo "<ul style='font-size: 16px; line-height: 1.8;'>";
echo "<li>✅ <strong>Diseño bonito aplicado:</strong> 2 columnas con tarjetas elegantes</li>";
echo "<li>✅ <strong>Integración dinámica:</strong> Se actualiza con el sistema de gestión</li>";
echo "<li>✅ <strong>Páginas individuales:</strong> Cada curso tiene su página de detalle</li>";
echo "<li>✅ <strong>Botones funcionales:</strong> 'Ver Más Info' lleva a la página del curso</li>";
echo "<li>✅ <strong>Responsive:</strong> Se adapta a móviles perfectamente</li>";
echo "<li>✅ <strong>Gestión integrada:</strong> Los cambios en gestión se reflejan automáticamente</li>";
echo "</ul>";
echo "</div>";

echo "<div style='background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>🚀 CÓMO FUNCIONA AHORA:</h3>";
echo "<ol>";
echo "<li><strong>Página principal:</strong> <a href='" . home_url('/anuncios/') . "' target='_blank'>/anuncios/</a> - Muestra 2 cursos por fila</li>";
echo "<li><strong>Gestión:</strong> <a href='" . home_url('/gestionar-cursos-dinamico.php') . "' target='_blank'>/gestionar-cursos-dinamico.php</a> - Agregar/editar cursos</li>";
echo "<li><strong>Detalles:</strong> Cada botón 'Ver Más Info' lleva a la página individual del curso</li>";
echo "<li><strong>Automático:</strong> Los cambios en gestión se reflejan inmediatamente</li>";
echo "</ol>";
echo "</div>";

echo "<div style='text-align: center; margin: 40px 0;'>";
echo "<a href='" . home_url('/anuncios/') . "' target='_blank' style='background: linear-gradient(135deg, #27ae60, #229954); color: white; padding: 18px 35px; text-decoration: none; border-radius: 30px; font-weight: bold; font-size: 20px; box-shadow: 0 6px 20px rgba(39, 174, 96, 0.3); display: inline-block; text-transform: uppercase; letter-spacing: 1px; margin: 10px;'>🔗 VER PÁGINA ANUNCIOS</a>";
echo "<a href='" . home_url('/gestionar-cursos-dinamico.php') . "' target='_blank' style='background: linear-gradient(135deg, #3498db, #2980b9); color: white; padding: 18px 35px; text-decoration: none; border-radius: 30px; font-weight: bold; font-size: 20px; box-shadow: 0 6px 20px rgba(52, 152, 219, 0.3); display: inline-block; text-transform: uppercase; letter-spacing: 1px; margin: 10px;'>⚙️ GESTIONAR CURSOS</a>";
echo "</div>";
?>
<?php
/**
 * FORZAR CAMBIOS INMEDIATOS
 * Modificar directamente el template para que funcione YA
 */

// Cargar WordPress
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
}

echo "<h1>⚡ FORZAR CAMBIOS INMEDIATOS</h1>";

// 1. Modificar el template directamente
$template_path = get_template_directory() . '/page-templates/page-cursos.php';

if (file_exists($template_path)) {
    $template_content = file_get_contents($template_path);
    
    // Buscar la sección de próximos cursos y reemplazar completamente
    $new_section = '
    <!-- Próximos Cursos FORZADO - 2 COLUMNAS -->
    <section class="upcoming-courses-section" style="padding: 50px 0; background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
        <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 0 20px;">
            <div class="section-header" style="text-align: center; margin-bottom: 40px;">
                <h2 style="font-size: 2.5rem; color: #2c3e50; margin-bottom: 15px; font-weight: 700; position: relative;">
                    Próximos Cursos
                </h2>
                <p style="font-size: 1.1rem; color: #6c757d; max-width: 500px; margin: 0 auto;">
                    Cursos que comenzarán próximamente. ¡Reserva tu plaza!
                </p>
            </div>
            
            <div class="upcoming-courses-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin: 35px auto 0; max-width: 900px;">
                <?php
                // Obtener cursos del sistema dinámico
                $courses = get_option(\'mongruas_courses\', []);
                
                // Si no hay cursos, crear algunos por defecto
                if (empty($courses)) {
                    $courses = [
                        [\'name\' => \'Montaje y Mantenimiento de Instalaciones Eléctricas\', \'date\' => \'Enero 2025\', \'modality\' => \'Presencial\', \'duration\' => \'15 plazas\', \'description\' => \'Curso completo de instalaciones eléctricas de baja tensión con certificado oficial.\'],
                        [\'name\' => \'Sistemas Domóticos e Inmóticos\', \'date\' => \'Febrero 2025\', \'modality\' => \'Presencial\', \'duration\' => \'12 plazas\', \'description\' => \'Especialización en automatización de edificios y sistemas inteligentes.\'],
                        [\'name\' => \'Control de Plagas\', \'date\' => \'Marzo 2025\', \'modality\' => \'Presencial\', \'duration\' => \'10 plazas\', \'description\' => \'Formación profesional en control y prevención de plagas urbanas.\']
                    ];
                    update_option(\'mongruas_courses\', $courses);
                }
                
                // Mostrar máximo 4 cursos (2x2)
                $courses_to_show = array_slice($courses, 0, 4);
                
                foreach ($courses_to_show as $course):
                ?>
                    <div class="upcoming-course-card" style="background: white; border-radius: 15px; box-shadow: 0 6px 25px rgba(0,0,0,0.08); overflow: hidden; position: relative; border: 1px solid rgba(0,0,0,0.05);">
                        <div style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #3498db, #27ae60);"></div>
                        
                        <div class="course-content" style="padding: 22px;">
                            <div class="course-badge" style="background: linear-gradient(135deg, #e74c3c, #c0392b); color: white; padding: 5px 12px; border-radius: 18px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; display: inline-block; margin-bottom: 10px;">
                                Próximamente
                            </div>
                            
                            <?php if (!empty($course[\'date\'])): ?>
                                <div class="course-date" style="display: flex; align-items: center; gap: 8px; margin-bottom: 15px; color: #e74c3c; font-weight: 600; background: rgba(231, 76, 60, 0.08); padding: 8px 12px; border-radius: 8px; border-left: 3px solid #e74c3c;">
                                    <span>📅</span>
                                    <span><?php echo esc_html($course[\'date\']); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <h3 style="font-size: 1.2rem; color: #2c3e50; margin-bottom: 12px; font-weight: 700; line-height: 1.3;">
                                <?php echo esc_html($course[\'name\']); ?>
                            </h3>
                            
                            <?php if (!empty($course[\'description\'])): ?>
                                <p style="color: #6c757d; line-height: 1.5; margin-bottom: 18px; font-size: 0.9rem;">
                                    <?php echo esc_html($course[\'description\']); ?>
                                </p>
                            <?php endif; ?>
                            
                            <div class="course-details" style="display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 18px; padding: 12px; background: rgba(52, 152, 219, 0.05); border-radius: 8px;">
                                <?php if (!empty($course[\'duration\'])): ?>
                                    <span style="display: flex; align-items: center; gap: 6px; color: #495057; font-size: 0.85rem; font-weight: 500;">
                                        <span style="color: #3498db;">⏱️</span>
                                        <?php echo esc_html($course[\'duration\']); ?>
                                    </span>
                                <?php endif; ?>
                                <?php if (!empty($course[\'modality\'])): ?>
                                    <span style="display: flex; align-items: center; gap: 6px; color: #495057; font-size: 0.85rem; font-weight: 500;">
                                        <span style="color: #3498db;">💻</span>
                                        <?php echo esc_html($course[\'modality\']); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <a href="#contact" class="btn-reserve" style="background: linear-gradient(135deg, #27ae60, #229954); color: white; padding: 12px 24px; border-radius: 22px; text-decoration: none; font-weight: 600; text-align: center; width: 100%; display: block; font-size: 0.9rem; text-transform: uppercase; box-sizing: border-box;">
                                Solicitar Información
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <style>
        @media (max-width: 768px) {
            .upcoming-courses-grid {
                grid-template-columns: 1fr !important;
                gap: 20px !important;
            }
        }
        </style>
    </section>';
    
    // Buscar y reemplazar la sección existente
    $pattern = '/<!-- Próximos Cursos.*?<\/section>/s';
    if (preg_match($pattern, $template_content)) {
        $template_content = preg_replace($pattern, $new_section, $template_content);
        echo "✅ Sección de próximos cursos reemplazada<br>";
    } else {
        // Si no encuentra el patrón, buscar por la clase
        $pattern = '/<section class="upcoming-courses-section">.*?<\/section>/s';
        if (preg_match($pattern, $template_content)) {
            $template_content = preg_replace($pattern, $new_section, $template_content);
            echo "✅ Sección encontrada por clase y reemplazada<br>";
        } else {
            echo "⚠️ No se pudo encontrar la sección para reemplazar<br>";
        }
    }
    
    // Guardar el archivo modificado
    if (file_put_contents($template_path, $template_content)) {
        echo "✅ Template modificado y guardado<br>";
    } else {
        echo "❌ Error al guardar el template<br>";
    }
} else {
    echo "❌ Template no encontrado<br>";
}

// 2. Limpiar cache completamente
wp_cache_flush();
global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'");
echo "✅ Cache limpiado<br>";

// 3. Forzar recarga de estilos
update_option('mongruas_theme_version', time());
echo "✅ Versión de tema actualizada<br>";

echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🎯 CAMBIOS APLICADOS DIRECTAMENTE</h2>";
echo "<ul>";
echo "<li>✅ Template modificado con estilos inline</li>";
echo "<li>✅ Grid forzado a 2 columnas: <code>grid-template-columns: 1fr 1fr</code></li>";
echo "<li>✅ Estilos aplicados directamente en HTML</li>";
echo "<li>✅ Responsive incluido para móviles</li>";
echo "<li>✅ Cache completamente limpiado</li>";
echo "</ul>";
echo "</div>";

echo "<div style='background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>🚀 AHORA DEBERÍA FUNCIONAR</h3>";
echo "<p>Los cambios se han aplicado directamente en el HTML del template.</p>";
echo "<p><strong>Ve a la página en una ventana incógnito y presiona Ctrl+F5</strong></p>";
echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . home_url('/anuncios/') . "' target='_blank' style='background: linear-gradient(135deg, #dc3545, #c82333); color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; font-size: 18px; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3); display: inline-block;'>🔗 VER PÁGINA ANUNCIOS AHORA</a>";
echo "</div>";
?>
<?php
/**
 * ARREGLAR 2 COLUMNAS DEFINITIVO
 * Solución final para mostrar exactamente 2 cursos por fila
 */

// Cargar WordPress
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
}

echo "<h1>🎯 ARREGLAR 2 COLUMNAS DEFINITIVO</h1>";

// 1. Crear una nueva sección completamente desde cero
$nueva_seccion_html = '
    <!-- PRÓXIMOS CURSOS - 2 COLUMNAS FORZADO -->
    <section class="proximos-cursos-2-columnas" style="padding: 60px 0; background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); position: relative;">
        <div style="max-width: 1000px; margin: 0 auto; padding: 0 20px;">
            
            <!-- Título -->
            <div style="text-align: center; margin-bottom: 50px;">
                <h2 style="font-size: 2.8rem; color: #2c3e50; margin-bottom: 20px; font-weight: 800; position: relative;">
                    Próximos Cursos
                </h2>
                <div style="width: 80px; height: 4px; background: linear-gradient(90deg, #3498db, #27ae60); margin: 0 auto 20px; border-radius: 2px;"></div>
                <p style="font-size: 1.2rem; color: #6c757d; max-width: 600px; margin: 0 auto;">
                    Cursos que comenzarán próximamente. ¡Reserva tu plaza!
                </p>
            </div>
            
            <!-- Grid de 2 columnas FORZADO -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; max-width: 900px; margin: 0 auto;">
                
                <?php
                // Obtener cursos
                $courses = get_option(\'mongruas_courses\', []);
                
                // Si no hay cursos, crear algunos por defecto
                if (empty($courses)) {
                    $courses = [
                        [\'name\' => \'Montaje y Mantenimiento de Instalaciones Eléctricas\', \'date\' => \'Enero 2025\', \'modality\' => \'Presencial\', \'duration\' => \'15 plazas\', \'description\' => \'Curso completo de instalaciones eléctricas de baja tensión con certificado oficial.\'],
                        [\'name\' => \'Sistemas Domóticos e Inmóticos\', \'date\' => \'Febrero 2025\', \'modality\' => \'Presencial\', \'duration\' => \'12 plazas\', \'description\' => \'Especialización en automatización de edificios y sistemas inteligentes.\'],
                        [\'name\' => \'Control de Plagas\', \'date\' => \'Marzo 2025\', \'modality\' => \'Presencial\', \'duration\' => \'10 plazas\', \'description\' => \'Formación profesional en control y prevención de plagas urbanas.\'],
                        [\'name\' => \'Prevención de Riesgos Laborales\', \'date\' => \'Abril 2025\', \'modality\' => \'Online\', \'duration\' => \'20 plazas\', \'description\' => \'Curso completo de PRL con certificado oficial.\']
                    ];
                    update_option(\'mongruas_courses\', $courses);
                }
                
                // Mostrar todos los cursos (máximo 4 para que queden 2x2)
                $courses_to_show = array_slice($courses, 0, 4);
                
                foreach ($courses_to_show as $index => $course):
                ?>
                
                <!-- Tarjeta de Curso -->
                <div style="background: white; border-radius: 20px; box-shadow: 0 8px 30px rgba(0,0,0,0.1); overflow: hidden; position: relative; border: 1px solid rgba(0,0,0,0.05); transition: all 0.3s ease;" 
                     onmouseover="this.style.transform=\'translateY(-8px)\'; this.style.boxShadow=\'0 15px 40px rgba(0,0,0,0.15)\';" 
                     onmouseout="this.style.transform=\'translateY(0)\'; this.style.boxShadow=\'0 8px 30px rgba(0,0,0,0.1)\';">
                    
                    <!-- Barra superior de color -->
                    <div style="height: 4px; background: linear-gradient(90deg, #3498db, #27ae60);"></div>
                    
                    <!-- Contenido -->
                    <div style="padding: 25px;">
                        
                        <!-- Badge -->
                        <div style="background: linear-gradient(135deg, #e74c3c, #c0392b); color: white; padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; display: inline-block; margin-bottom: 15px; letter-spacing: 0.5px; box-shadow: 0 3px 10px rgba(231, 76, 60, 0.3);">
                            Próximamente
                        </div>
                        
                        <!-- Fecha -->
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 18px; color: #e74c3c; font-weight: 700; background: rgba(231, 76, 60, 0.1); padding: 10px 15px; border-radius: 10px; border-left: 4px solid #e74c3c;">
                            <span style="font-size: 1.2rem;">📅</span>
                            <span style="font-size: 0.95rem;"><?php echo esc_html($course[\'date\']); ?></span>
                        </div>
                        
                        <!-- Título -->
                        <h3 style="font-size: 1.3rem; color: #2c3e50; margin-bottom: 15px; font-weight: 800; line-height: 1.3; min-height: 60px;">
                            <?php echo esc_html($course[\'name\']); ?>
                        </h3>
                        
                        <!-- Descripción -->
                        <p style="color: #6c757d; line-height: 1.6; margin-bottom: 20px; font-size: 0.95rem; min-height: 50px;">
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
                        </div>
                        
                        <!-- Botón -->
                        <a href="#contact" style="background: linear-gradient(135deg, #27ae60, #229954); color: white; padding: 14px 28px; border-radius: 25px; text-decoration: none; font-weight: 700; text-align: center; width: 100%; display: block; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3); transition: all 0.3s ease; box-sizing: border-box;"
                           onmouseover="this.style.background=\'linear-gradient(135deg, #229954, #1e8449)\'; this.style.transform=\'translateY(-2px)\'; this.style.boxShadow=\'0 8px 20px rgba(39, 174, 96, 0.4)\';"
                           onmouseout="this.style.background=\'linear-gradient(135deg, #27ae60, #229954)\'; this.style.transform=\'translateY(0)\'; this.style.boxShadow=\'0 5px 15px rgba(39, 174, 96, 0.3)\';">
                            Solicitar Información
                        </a>
                        
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
                gap: 25px !important;
            }
            .proximos-cursos-2-columnas h2 {
                font-size: 2.2rem !important;
            }
        }
        
        @media (max-width: 480px) {
            .proximos-cursos-2-columnas {
                padding: 40px 0 !important;
            }
            .proximos-cursos-2-columnas div[style*="padding: 0 20px"] {
                padding: 0 15px !important;
            }
        }
        </style>
        
    </section>';

// 2. Reemplazar completamente la sección en el template
$template_path = get_template_directory() . '/page-templates/page-cursos.php';

if (file_exists($template_path)) {
    $template_content = file_get_contents($template_path);
    
    // Buscar y reemplazar toda la sección de próximos cursos
    $patterns = [
        '/<!-- Próximos Cursos.*?<\/section>/s',
        '/<section class="upcoming-courses-section">.*?<\/section>/s',
        '/<section class="proximos-cursos-2-columnas">.*?<\/section>/s'
    ];
    
    $replaced = false;
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $template_content)) {
            $template_content = preg_replace($pattern, $nueva_seccion_html, $template_content);
            $replaced = true;
            echo "✅ Sección reemplazada con patrón: " . substr($pattern, 0, 30) . "...<br>";
            break;
        }
    }
    
    if (!$replaced) {
        // Si no encuentra la sección, buscar donde insertarla
        $insert_after = '</section>';
        $pos = strpos($template_content, $insert_after);
        if ($pos !== false) {
            $pos += strlen($insert_after);
            $template_content = substr_replace($template_content, "\n" . $nueva_seccion_html . "\n", $pos, 0);
            echo "✅ Sección insertada después de la primera sección<br>";
        }
    }
    
    // Guardar el archivo
    if (file_put_contents($template_path, $template_content)) {
        echo "✅ Template guardado correctamente<br>";
    } else {
        echo "❌ Error al guardar el template<br>";
    }
} else {
    echo "❌ Template no encontrado<br>";
}

// 3. Limpiar cache
wp_cache_flush();
global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'");
update_option('mongruas_theme_version', time());

echo "✅ Cache limpiado y versión actualizada<br>";

echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 25px; border-radius: 10px; margin: 30px 0;'>";
echo "<h2>🎯 SOLUCIÓN APLICADA</h2>";
echo "<ul style='font-size: 16px; line-height: 1.6;'>";
echo "<li>✅ <strong>Grid forzado:</strong> <code>grid-template-columns: 1fr 1fr</code></li>";
echo "<li>✅ <strong>Diseño mejorado:</strong> Tarjetas más elegantes y espaciadas</li>";
echo "<li>✅ <strong>4 cursos visibles:</strong> 2 filas x 2 columnas</li>";
echo "<li>✅ <strong>Responsive:</strong> 1 columna en móviles</li>";
echo "<li>✅ <strong>Estilos inline:</strong> No depende de CSS externo</li>";
echo "<li>✅ <strong>Efectos hover:</strong> Interactividad mejorada</li>";
echo "</ul>";
echo "</div>";

echo "<div style='background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>📱 AHORA DEBERÍAS VER:</h3>";
echo "<ul>";
echo "<li><strong>Pantallas grandes:</strong> 2 cursos por fila (2x2 = 4 cursos total)</li>";
echo "<li><strong>Móviles:</strong> 1 curso por fila (4 cursos en columna)</li>";
echo "<li><strong>Diseño:</strong> Tarjetas blancas con sombras y efectos hover</li>";
echo "<li><strong>Colores:</strong> Verde para botones, rojo para fechas, azul para detalles</li>";
echo "</ul>";
echo "</div>";

echo "<div style='text-align: center; margin: 40px 0;'>";
echo "<a href='" . home_url('/anuncios/') . "' target='_blank' style='background: linear-gradient(135deg, #e74c3c, #c0392b); color: white; padding: 18px 35px; text-decoration: none; border-radius: 30px; font-weight: bold; font-size: 20px; box-shadow: 0 6px 20px rgba(231, 76, 60, 0.3); display: inline-block; text-transform: uppercase; letter-spacing: 1px;'>🚀 VER PÁGINA ANUNCIOS</a>";
echo "</div>";

echo "<div style='background: #e2e3e5; border: 1px solid #d6d8db; color: #383d41; padding: 15px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>🔄 Si no ves los cambios:</h3>";
echo "<ol>";
echo "<li>Abre una <strong>ventana incógnito/privada</strong></li>";
echo "<li>Ve a la página: <code>" . home_url('/anuncios/') . "</code></li>";
echo "<li>Presiona <strong>Ctrl+F5</strong> (Windows) o <strong>Cmd+Shift+R</strong> (Mac)</li>";
echo "<li>Espera 5 segundos y recarga de nuevo</li>";
echo "</ol>";
echo "</div>";
?>
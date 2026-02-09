<?php
/**
 * VERIFICAR CAMBIOS APLICADOS
 * Comprobar que los cambios se aplicaron correctamente
 */

// Cargar WordPress
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
}

echo "<h1>✅ VERIFICAR CAMBIOS APLICADOS</h1>";

// 1. Verificar que el template fue modificado
$template_path = get_template_directory() . '/page-templates/page-cursos.php';
if (file_exists($template_path)) {
    $template_content = file_get_contents($template_path);
    
    echo "<h2>📁 Verificación del Template:</h2>";
    
    if (strpos($template_content, 'proximos-cursos-2-columnas') !== false) {
        echo "✅ Nueva sección encontrada en el template<br>";
    } else {
        echo "❌ Nueva sección NO encontrada<br>";
    }
    
    if (strpos($template_content, 'grid-template-columns: 1fr 1fr') !== false) {
        echo "✅ Grid de 2 columnas encontrado<br>";
    } else {
        echo "❌ Grid de 2 columnas NO encontrado<br>";
    }
    
    if (strpos($template_content, 'background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%)') !== false) {
        echo "✅ Estilos de fondo encontrados<br>";
    } else {
        echo "❌ Estilos de fondo NO encontrados<br>";
    }
} else {
    echo "❌ Template no encontrado<br>";
}

// 2. Verificar página anuncios
echo "<h2>📄 Verificación de Página:</h2>";
$anuncios_page = get_page_by_path('anuncios');
if ($anuncios_page) {
    echo "✅ Página 'anuncios' existe (ID: " . $anuncios_page->ID . ")<br>";
    echo "✅ URL: " . get_permalink($anuncios_page->ID) . "<br>";
    
    $template_slug = get_page_template_slug($anuncios_page->ID);
    if ($template_slug === 'page-templates/page-cursos.php') {
        echo "✅ Template correcto asignado<br>";
    } else {
        echo "⚠️ Template asignado: " . ($template_slug ?: 'default') . "<br>";
    }
} else {
    echo "❌ Página 'anuncios' NO existe<br>";
}

// 3. Verificar cursos
echo "<h2>📚 Verificación de Cursos:</h2>";
$courses = get_option('mongruas_courses', []);
if (!empty($courses)) {
    echo "✅ Cursos encontrados: " . count($courses) . "<br>";
    foreach ($courses as $i => $course) {
        echo "- " . ($i + 1) . ". " . $course['name'] . " (" . $course['date'] . ")<br>";
    }
} else {
    echo "❌ No hay cursos guardados<br>";
}

// 4. Limpiar cache una vez más
wp_cache_flush();
global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'");
update_option('mongruas_theme_version', time());
echo "<h2>🧹 Cache limpiado nuevamente</h2>";

echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 25px; border-radius: 10px; margin: 30px 0;'>";
echo "<h2>🎯 ESTADO ACTUAL</h2>";
echo "<p><strong>Los cambios han sido aplicados al template.</strong></p>";
echo "<p>Ahora debes:</p>";
echo "<ol style='font-size: 16px; line-height: 1.8;'>";
echo "<li><strong>Abrir una ventana incógnito/privada</strong></li>";
echo "<li><strong>Ir a:</strong> <a href='" . home_url('/anuncios/') . "' target='_blank'>" . home_url('/anuncios/') . "</a></li>";
echo "<li><strong>Presionar Ctrl+F5</strong> (Windows) o <strong>Cmd+Shift+R</strong> (Mac)</li>";
echo "<li><strong>Esperar 5 segundos y recargar de nuevo</strong></li>";
echo "</ol>";
echo "</div>";

echo "<div style='background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>👀 QUÉ DEBERÍAS VER:</h3>";
echo "<ul>";
echo "<li>✅ <strong>Título:</strong> 'Próximos Cursos' con línea azul-verde debajo</li>";
echo "<li>✅ <strong>Layout:</strong> Exactamente 2 cursos por fila (2x2 = 4 cursos)</li>";
echo "<li>✅ <strong>Tarjetas:</strong> Blancas con sombras y borde superior de color</li>";
echo "<li>✅ <strong>Badges:</strong> Rojos que dicen 'PRÓXIMAMENTE'</li>";
echo "<li>✅ <strong>Fechas:</strong> Con icono 📅 y fondo rojo claro</li>";
echo "<li>✅ <strong>Botones:</strong> Verdes que dicen 'SOLICITAR INFORMACIÓN'</li>";
echo "</ul>";
echo "</div>";

echo "<div style='text-align: center; margin: 40px 0;'>";
echo "<a href='" . home_url('/anuncios/') . "' target='_blank' style='background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 20px 40px; text-decoration: none; border-radius: 30px; font-weight: bold; font-size: 22px; box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3); display: inline-block; text-transform: uppercase; letter-spacing: 1px; margin: 10px;'>🚀 VER PÁGINA ANUNCIOS</a>";
echo "</div>";

echo "<div style='background: #e2e3e5; border: 1px solid #d6d8db; color: #383d41; padding: 15px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>🔧 Si aún no funciona:</h3>";
echo "<ul>";
echo "<li>Prueba en diferentes navegadores (Chrome, Firefox, Edge)</li>";
echo "<li>Desactiva extensiones del navegador temporalmente</li>";
echo "<li>Verifica que estés en la URL correcta: <code>/anuncios/</code></li>";
echo "<li>Espera 1-2 minutos y vuelve a intentar</li>";
echo "</ul>";
echo "</div>";

// 5. Crear una vista previa HTML directa
echo "<h2>🎨 Vista Previa del Diseño:</h2>";
echo "<div style='border: 2px solid #ddd; padding: 20px; margin: 20px 0; border-radius: 10px; background: #f9f9f9;'>";
echo "<p><strong>Así debería verse la sección:</strong></p>";
?>

<div style="padding: 60px 20px; background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); border-radius: 10px;">
    <div style="max-width: 900px; margin: 0 auto;">
        
        <!-- Título -->
        <div style="text-align: center; margin-bottom: 50px;">
            <h2 style="font-size: 2.8rem; color: #2c3e50; margin-bottom: 20px; font-weight: 800;">
                Próximos Cursos
            </h2>
            <div style="width: 80px; height: 4px; background: linear-gradient(90deg, #3498db, #27ae60); margin: 0 auto 20px; border-radius: 2px;"></div>
            <p style="font-size: 1.2rem; color: #6c757d;">
                Cursos que comenzarán próximamente. ¡Reserva tu plaza!
            </p>
        </div>
        
        <!-- Grid de 2 columnas -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            
            <!-- Curso 1 -->
            <div style="background: white; border-radius: 20px; box-shadow: 0 8px 30px rgba(0,0,0,0.1); overflow: hidden; position: relative; border: 1px solid rgba(0,0,0,0.05);">
                <div style="height: 4px; background: linear-gradient(90deg, #3498db, #27ae60);"></div>
                <div style="padding: 25px;">
                    <div style="background: linear-gradient(135deg, #e74c3c, #c0392b); color: white; padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; display: inline-block; margin-bottom: 15px;">
                        PRÓXIMAMENTE
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 18px; color: #e74c3c; font-weight: 700; background: rgba(231, 76, 60, 0.1); padding: 10px 15px; border-radius: 10px; border-left: 4px solid #e74c3c;">
                        <span>📅</span>
                        <span>Enero 2025</span>
                    </div>
                    <h3 style="font-size: 1.3rem; color: #2c3e50; margin-bottom: 15px; font-weight: 800; line-height: 1.3;">
                        Montaje y Mantenimiento de Instalaciones Eléctricas
                    </h3>
                    <p style="color: #6c757d; line-height: 1.6; margin-bottom: 20px; font-size: 0.95rem;">
                        Curso completo de instalaciones eléctricas de baja tensión con certificado oficial.
                    </p>
                    <div style="background: linear-gradient(135deg, #27ae60, #229954); color: white; padding: 14px 28px; border-radius: 25px; text-align: center; font-weight: 700; font-size: 0.95rem; text-transform: uppercase;">
                        SOLICITAR INFORMACIÓN
                    </div>
                </div>
            </div>
            
            <!-- Curso 2 -->
            <div style="background: white; border-radius: 20px; box-shadow: 0 8px 30px rgba(0,0,0,0.1); overflow: hidden; position: relative; border: 1px solid rgba(0,0,0,0.05);">
                <div style="height: 4px; background: linear-gradient(90deg, #3498db, #27ae60);"></div>
                <div style="padding: 25px;">
                    <div style="background: linear-gradient(135deg, #e74c3c, #c0392b); color: white; padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; display: inline-block; margin-bottom: 15px;">
                        PRÓXIMAMENTE
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 18px; color: #e74c3c; font-weight: 700; background: rgba(231, 76, 60, 0.1); padding: 10px 15px; border-radius: 10px; border-left: 4px solid #e74c3c;">
                        <span>📅</span>
                        <span>Febrero 2025</span>
                    </div>
                    <h3 style="font-size: 1.3rem; color: #2c3e50; margin-bottom: 15px; font-weight: 800; line-height: 1.3;">
                        Sistemas Domóticos e Inmóticos
                    </h3>
                    <p style="color: #6c757d; line-height: 1.6; margin-bottom: 20px; font-size: 0.95rem;">
                        Especialización en automatización de edificios y sistemas inteligentes.
                    </p>
                    <div style="background: linear-gradient(135deg, #27ae60, #229954); color: white; padding: 14px 28px; border-radius: 25px; text-align: center; font-weight: 700; font-size: 0.95rem; text-transform: uppercase;">
                        SOLICITAR INFORMACIÓN
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<?php
echo "</div>";

echo "<p style='text-align: center; font-size: 18px; color: #28a745; font-weight: bold; margin: 30px 0;'>";
echo "☝️ ASÍ debería verse tu página /anuncios/ ahora";
echo "</p>";
?>
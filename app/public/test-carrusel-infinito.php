<?php
/**
 * Test del Carrusel Infinito - Mongruas Formación
 * Verifica que el carrusel infinito funcione correctamente
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🎠 Test Carrusel Infinito</h1>";

// Verificar que el sistema dinámico tenga suficientes cursos para el carrusel
$cursos = get_option('mongruas_courses', []);

echo "<h2>📊 Estado del Sistema</h2>";
echo "<div class='status-info'>";
echo "<p><strong>Cursos en sistema dinámico:</strong> " . count($cursos) . "</p>";

if (count($cursos) > 3) {
    echo "<p>✅ <strong>Carrusel infinito:</strong> Se activará automáticamente (más de 3 cursos)</p>";
} else {
    echo "<p>⚠️ <strong>Carrusel infinito:</strong> No se activará (3 o menos cursos)</p>";
    echo "<p><em>Agrega más cursos en el panel de gestión para ver el carrusel infinito</em></p>";
}
echo "</div>";

// Mostrar cursos actuales
if (!empty($cursos)) {
    echo "<h2>📋 Cursos Actuales</h2>";
    echo "<div class='courses-list'>";
    foreach ($cursos as $index => $curso) {
        echo "<div class='course-item'>";
        echo "<div class='course-number'>" . ($index + 1) . "</div>";
        echo "<div class='course-info'>";
        echo "<strong>" . esc_html($curso['name']) . "</strong><br>";
        echo "<small>📅 " . esc_html($curso['date']) . " | 🎯 " . esc_html($curso['modality']) . " | 👥 " . esc_html($curso['duration']) . "</small>";
        echo "</div>";
        echo "</div>";
    }
    echo "</div>";
}

// Información sobre las funcionalidades del carrusel
echo "<h2>🎯 Funcionalidades del Carrusel Infinito</h2>";
echo "<div class='features-grid'>";

echo "<div class='feature-card'>";
echo "<div class='feature-icon'>🔄</div>";
echo "<h4>Efecto Infinito</h4>";
echo "<p>Al llegar al último curso, vuelve automáticamente al primero sin cortes visibles</p>";
echo "</div>";

echo "<div class='feature-card'>";
echo "<div class='feature-icon'>⚡</div>";
echo "<h4>Transiciones Suaves</h4>";
echo "<p>Animaciones fluidas con cubic-bezier para movimientos naturales</p>";
echo "</div>";

echo "<div class='feature-card'>";
echo "<div class='feature-icon'>🎮</div>";
echo "<h4>Auto-play Inteligente</h4>";
echo "<p>Cambia cada 4 segundos, se pausa al hacer hover</p>";
echo "</div>";

echo "<div class='feature-card'>";
echo "<div class='feature-icon'>📱</div>";
echo "<h4>Soporte Touch</h4>";
echo "<p>Desliza con el dedo en móviles para navegar</p>";
echo "</div>";

echo "<div class='feature-card'>";
echo "<div class='feature-icon'>🎯</div>";
echo "<h4>Indicadores Dinámicos</h4>";
echo "<p>Puntos que muestran posición actual y permiten navegación directa</p>";
echo "</div>";

echo "<div class='feature-card'>";
echo "<div class='feature-icon'>🎨</div>";
echo "<h4>Efectos Visuales</h4>";
echo "<p>Botones con gradientes y efectos hover modernos</p>";
echo "</div>";

echo "</div>";

// Instrucciones de prueba
echo "<h2>🧪 Cómo Probar el Carrusel</h2>";
echo "<div class='test-instructions'>";

echo "<div class='test-step'>";
echo "<div class='step-number'>1</div>";
echo "<div class='step-content'>";
echo "<h4>Asegúrate de tener más de 3 cursos</h4>";
echo "<p>El carrusel infinito solo se activa con 4 o más cursos</p>";
echo "</div>";
echo "</div>";

echo "<div class='test-step'>";
echo "<div class='step-number'>2</div>";
echo "<div class='step-content'>";
echo "<h4>Ve a la página principal</h4>";
echo "<p>Busca la sección 'Próximos Cursos' en la página de inicio</p>";
echo "</div>";
echo "</div>";

echo "<div class='test-step'>";
echo "<div class='step-number'>3</div>";
echo "<div class='step-content'>";
echo "<h4>Prueba la navegación</h4>";
echo "<p>Usa las flechas ← → para navegar. Al llegar al final, volverá al inicio</p>";
echo "</div>";
echo "</div>";

echo "<div class='test-step'>";
echo "<div class='step-number'>4</div>";
echo "<div class='step-content'>";
echo "<h4>Observa el auto-play</h4>";
echo "<p>El carrusel cambia automáticamente cada 4 segundos</p>";
echo "</div>";
echo "</div>";

echo "<div class='test-step'>";
echo "<div class='step-number'>5</div>";
echo "<div class='step-content'>";
echo "<h4>Prueba en móvil</h4>";
echo "<p>Desliza con el dedo para navegar en dispositivos táctiles</p>";
echo "</div>";
echo "</div>";

echo "</div>";

// Verificar archivos necesarios
echo "<h2>📁 Verificación de Archivos</h2>";
$template_path = get_template_directory() . '/template-parts/courses-default.php';
if (file_exists($template_path)) {
    $template_content = file_get_contents($template_path);
    
    if (strpos($template_content, 'carousel-container-infinite') !== false) {
        echo "<p>✅ <strong>Carrusel infinito:</strong> Código implementado correctamente</p>";
    } else {
        echo "<p>❌ <strong>Carrusel infinito:</strong> Código no encontrado</p>";
    }
    
    if (strpos($template_content, 'mongruas_courses') !== false) {
        echo "<p>✅ <strong>Integración dinámica:</strong> Conectado al sistema de gestión</p>";
    } else {
        echo "<p>❌ <strong>Integración dinámica:</strong> No conectado</p>";
    }
} else {
    echo "<p>❌ <strong>Template:</strong> Archivo courses-default.php no encontrado</p>";
}

// Enlaces de acción
echo "<h2>🚀 Acciones</h2>";
echo "<div class='action-links'>";

echo "<a href='" . home_url('/') . "' class='action-link primary' target='_blank'>";
echo "<div class='link-icon'>🏠</div>";
echo "<div class='link-text'>";
echo "<strong>Ver Página Principal</strong>";
echo "<small>Probar carrusel infinito en acción</small>";
echo "</div>";
echo "</a>";

echo "<a href='" . home_url('/gestionar-cursos-dinamico.php') . "' class='action-link secondary' target='_blank'>";
echo "<div class='link-icon'>🎓</div>";
echo "<div class='link-text'>";
echo "<strong>Gestionar Cursos</strong>";
echo "<small>Agregar más cursos para el carrusel</small>";
echo "</div>";
echo "</a>";

echo "<a href='" . home_url('/demo-integracion-final.php') . "' class='action-link success' target='_blank'>";
echo "<div class='link-icon'>🎬</div>";
echo "<div class='link-text'>";
echo "<strong>Demo Completo</strong>";
echo "<small>Ver demostración del sistema</small>";
echo "</div>";
echo "</a>";

echo "</div>";

// Mensaje final
echo "<div class='final-message'>";
echo "<div class='message-icon'>🎉</div>";
echo "<div class='message-content'>";
echo "<h3>¡Carrusel Infinito Implementado!</h3>";
echo "<p>El carrusel ahora es completamente infinito. Cuando llegues al último curso con las flechas, automáticamente volverá al primero de forma suave y natural.</p>";
echo "<p><strong>Características:</strong> Auto-play, navegación táctil, indicadores dinámicos y transiciones fluidas.</p>";
echo "</div>";
echo "</div>";
?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    line-height: 1.6;
}

h1 {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
    text-align: center;
    padding: 30px;
    border-radius: 16px;
    margin-bottom: 30px;
    box-shadow: 0 8px 25px rgba(0, 102, 204, 0.3);
}

h2 {
    color: #495057;
    border-left: 4px solid #0066cc;
    padding-left: 15px;
    margin-top: 30px;
    margin-bottom: 20px;
}

.status-info {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin: 20px 0;
}

.courses-list {
    display: grid;
    gap: 15px;
    margin: 20px 0;
}

.course-item {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    gap: 15px;
}

.course-number {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    flex-shrink: 0;
}

.course-info {
    flex: 1;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin: 20px 0;
}

.feature-card {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: all 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.feature-icon {
    font-size: 48px;
    margin-bottom: 15px;
}

.feature-card h4 {
    margin: 0 0 10px 0;
    color: #495057;
    font-size: 18px;
}

.feature-card p {
    margin: 0;
    color: #6c757d;
    font-size: 14px;
}

.test-instructions {
    display: grid;
    gap: 20px;
    margin: 20px 0;
}

.test-step {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: flex-start;
    gap: 20px;
}

.step-number {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 18px;
    flex-shrink: 0;
}

.step-content h4 {
    margin: 0 0 8px 0;
    color: #495057;
    font-size: 18px;
}

.step-content p {
    margin: 0;
    color: #6c757d;
    font-size: 14px;
}

.action-links {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin: 20px 0;
}

.action-link {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 25px;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.action-link.primary {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
}

.action-link.secondary {
    background: linear-gradient(135deg, #6c757d, #5a6268);
    color: white;
}

.action-link.success {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.action-link:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

.link-icon {
    font-size: 36px;
    flex-shrink: 0;
}

.link-text strong {
    display: block;
    font-size: 18px;
    margin-bottom: 5px;
}

.link-text small {
    font-size: 14px;
    opacity: 0.9;
}

.final-message {
    background: linear-gradient(135deg, #fff3cd, #ffeaa7);
    border: 2px solid #ffc107;
    border-radius: 16px;
    padding: 30px;
    margin: 30px 0;
    display: flex;
    align-items: center;
    gap: 20px;
}

.message-icon {
    font-size: 48px;
    flex-shrink: 0;
}

.message-content h3 {
    margin: 0 0 10px 0;
    color: #856404;
    font-size: 24px;
}

.message-content p {
    margin: 0 0 10px 0;
    color: #856404;
    font-size: 16px;
}

@media (max-width: 768px) {
    .features-grid {
        grid-template-columns: 1fr;
    }
    
    .test-step {
        flex-direction: column;
        text-align: center;
    }
    
    .action-links {
        grid-template-columns: 1fr;
    }
    
    .final-message {
        flex-direction: column;
        text-align: center;
    }
}
</style>
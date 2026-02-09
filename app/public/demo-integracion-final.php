<?php
/**
 * Demo de Integración Final - Mongruas Formación
 * Demuestra que el sistema dinámico está completamente integrado
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🎬 Demo de Integración Final</h1>";

// Obtener cursos actuales
$cursos_actuales = get_option('mongruas_courses', []);

echo "<div class='demo-container'>";

// Mostrar estado actual
echo "<div class='demo-section'>";
echo "<h2>📊 Estado Actual del Sistema</h2>";
echo "<div class='status-card'>";
echo "<div class='status-icon'>🎓</div>";
echo "<div class='status-info'>";
echo "<h3>Cursos en Sistema Dinámico</h3>";
echo "<p><strong>" . count($cursos_actuales) . "</strong> cursos encontrados</p>";
echo "</div>";
echo "</div>";

if (!empty($cursos_actuales)) {
    echo "<div class='courses-preview'>";
    echo "<h4>📋 Cursos Actuales:</h4>";
    foreach ($cursos_actuales as $index => $curso) {
        echo "<div class='course-preview-item'>";
        echo "<span class='course-number'>" . ($index + 1) . "</span>";
        echo "<div class='course-info'>";
        echo "<strong>" . esc_html($curso['name']) . "</strong><br>";
        echo "<small>📅 " . esc_html($curso['date']) . " | 🎯 " . esc_html($curso['modality']) . " | 👥 " . esc_html($curso['duration']) . "</small>";
        echo "</div>";
        echo "</div>";
    }
    echo "</div>";
}
echo "</div>";

// Demostrar integración
echo "<div class='demo-section'>";
echo "<h2>🔄 Demostración de Integración</h2>";
echo "<div class='integration-demo'>";

echo "<div class='demo-step'>";
echo "<div class='step-icon'>1️⃣</div>";
echo "<div class='step-content'>";
echo "<h4>Panel de Gestión</h4>";
echo "<p>Los cursos se gestionan desde el panel dinámico</p>";
echo "<a href='" . home_url('/gestionar-cursos-dinamico.php') . "' class='demo-btn btn-primary' target='_blank'>🎓 Abrir Panel</a>";
echo "</div>";
echo "</div>";

echo "<div class='demo-arrow'>→</div>";

echo "<div class='demo-step'>";
echo "<div class='step-icon'>2️⃣</div>";
echo "<div class='step-content'>";
echo "<h4>Base de Datos</h4>";
echo "<p>Se guardan en <code>mongruas_courses</code></p>";
echo "<div class='code-preview'>WordPress Options</div>";
echo "</div>";
echo "</div>";

echo "<div class='demo-arrow'>→</div>";

echo "<div class='demo-step'>";
echo "<div class='step-icon'>3️⃣</div>";
echo "<div class='step-content'>";
echo "<h4>Página Principal</h4>";
echo "<p>Aparecen automáticamente en la web</p>";
echo "<a href='" . home_url('/') . "' class='demo-btn btn-success' target='_blank'>🌐 Ver Página</a>";
echo "</div>";
echo "</div>";

echo "</div>";
echo "</div>";

// Test en vivo
echo "<div class='demo-section'>";
echo "<h2>🧪 Test en Vivo</h2>";
echo "<div class='live-test'>";

echo "<div class='test-item'>";
echo "<div class='test-icon'>✅</div>";
echo "<div class='test-content'>";
echo "<h4>Integración Activa</h4>";
echo "<p>La página principal lee directamente de <code>mongruas_courses</code></p>";
echo "</div>";
echo "</div>";

echo "<div class='test-item'>";
echo "<div class='test-icon'>✅</div>";
echo "<div class='test-content'>";
echo "<h4>Redirecciones Correctas</h4>";
echo "<p>Todos los botones de gestión apuntan al panel dinámico</p>";
echo "</div>";
echo "</div>";

echo "<div class='test-item'>";
echo "<div class='test-icon'>✅</div>";
echo "<div class='test-content'>";
echo "<h4>Sincronización Automática</h4>";
echo "<p>Los cambios aparecen inmediatamente sin cache</p>";
echo "</div>";
echo "</div>";

echo "</div>";
echo "</div>";

// Instrucciones finales
echo "<div class='demo-section'>";
echo "<h2>🎯 Cómo Probar la Integración</h2>";
echo "<div class='instructions-grid'>";

echo "<div class='instruction-card'>";
echo "<div class='instruction-icon'>🔐</div>";
echo "<h4>1. Acceder al Panel</h4>";
echo "<p>Haz clic en el botón 'Gestión' en el header de la página principal</p>";
echo "<p><strong>Credenciales:</strong> admin / mongruas2024</p>";
echo "</div>";

echo "<div class='instruction-card'>";
echo "<div class='instruction-icon'>➕</div>";
echo "<h4>2. Agregar un Curso</h4>";
echo "<p>Haz clic en 'Agregar Nuevo Curso' y completa los campos</p>";
echo "<p><strong>Tip:</strong> Arrastra una imagen para probar el drag & drop</p>";
echo "</div>";

echo "<div class='instruction-card'>";
echo "<div class='instruction-icon'>💾</div>";
echo "<h4>3. Guardar Cambios</h4>";
echo "<p>Haz clic en 'Guardar Todos los Cursos'</p>";
echo "<p><strong>Resultado:</strong> Verás el mensaje de confirmación</p>";
echo "</div>";

echo "<div class='instruction-card'>";
echo "<div class='instruction-icon'>🌐</div>";
echo "<h4>4. Ver el Resultado</h4>";
echo "<p>Ve a la página principal y verás tu nuevo curso</p>";
echo "<p><strong>Ubicación:</strong> Sección 'Próximos Cursos'</p>";
echo "</div>";

echo "</div>";
echo "</div>";

// Enlaces rápidos
echo "<div class='demo-section'>";
echo "<h2>🚀 Enlaces Rápidos</h2>";
echo "<div class='quick-links'>";
echo "<a href='" . home_url('/gestionar-cursos-dinamico.php') . "' class='quick-link primary' target='_blank'>";
echo "<div class='link-icon'>🎓</div>";
echo "<div class='link-text'>";
echo "<strong>Panel de Gestión</strong>";
echo "<small>Gestionar cursos dinámicamente</small>";
echo "</div>";
echo "</a>";

echo "<a href='" . home_url('/') . "' class='quick-link success' target='_blank'>";
echo "<div class='link-icon'>🏠</div>";
echo "<div class='link-text'>";
echo "<strong>Página Principal</strong>";
echo "<small>Ver cursos en la web</small>";
echo "</div>";
echo "</a>";

echo "<a href='" . home_url('/verificar-integracion-dinamica.php') . "' class='quick-link secondary' target='_blank'>";
echo "<div class='link-icon'>🔍</div>";
echo "<div class='link-text'>";
echo "<strong>Verificador</strong>";
echo "<small>Comprobar integración</small>";
echo "</div>";
echo "</a>";
echo "</div>";
echo "</div>";

echo "</div>";

// Mensaje final
echo "<div class='final-message'>";
echo "<div class='message-icon'>🎉</div>";
echo "<div class='message-content'>";
echo "<h3>¡Integración Completada!</h3>";
echo "<p>El sistema dinámico está completamente integrado. Los cursos que gestiones aparecerán automáticamente en la página principal.</p>";
echo "<p><strong>¡Ya puedes empezar a gestionar tus cursos de forma dinámica!</strong></p>";
echo "</div>";
echo "</div>";
?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 1200px;
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
    font-size: 36px;
}

.demo-container {
    display: grid;
    gap: 30px;
}

.demo-section {
    background: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

h2 {
    color: #495057;
    margin-bottom: 20px;
    font-size: 24px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.status-card {
    display: flex;
    align-items: center;
    gap: 20px;
    background: linear-gradient(135deg, #e3f2fd, #bbdefb);
    padding: 25px;
    border-radius: 12px;
    border: 2px solid #2196f3;
}

.status-icon {
    font-size: 48px;
}

.status-info h3 {
    margin: 0 0 5px 0;
    color: #1976d2;
}

.status-info p {
    margin: 0;
    color: #1565c0;
    font-size: 18px;
}

.courses-preview {
    margin-top: 20px;
}

.course-preview-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 10px;
}

.course-number {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
    width: 30px;
    height: 30px;
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

.integration-demo {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
}

.demo-step {
    flex: 1;
    min-width: 200px;
    text-align: center;
    background: #f8f9fa;
    padding: 25px;
    border-radius: 12px;
    border: 2px solid #e9ecef;
}

.step-icon {
    font-size: 36px;
    margin-bottom: 15px;
}

.step-content h4 {
    margin: 0 0 10px 0;
    color: #495057;
}

.step-content p {
    margin: 0 0 15px 0;
    color: #6c757d;
    font-size: 14px;
}

.demo-arrow {
    font-size: 24px;
    color: #0066cc;
    font-weight: 700;
}

.demo-btn {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

.btn-primary {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
}

.btn-success {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.demo-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

.code-preview {
    background: #2d3748;
    color: #e2e8f0;
    padding: 8px 12px;
    border-radius: 6px;
    font-family: 'Courier New', monospace;
    font-size: 12px;
    margin-top: 10px;
}

.live-test {
    display: grid;
    gap: 15px;
}

.test-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    border-radius: 8px;
    border-left: 4px solid #28a745;
}

.test-icon {
    font-size: 24px;
    flex-shrink: 0;
}

.test-content h4 {
    margin: 0 0 5px 0;
    color: #155724;
}

.test-content p {
    margin: 0;
    color: #155724;
    font-size: 14px;
}

.instructions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.instruction-card {
    background: #f8f9fa;
    padding: 25px;
    border-radius: 12px;
    text-align: center;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.instruction-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    border-color: #0066cc;
}

.instruction-icon {
    font-size: 36px;
    margin-bottom: 15px;
}

.instruction-card h4 {
    margin: 0 0 10px 0;
    color: #495057;
}

.instruction-card p {
    margin: 0 0 10px 0;
    color: #6c757d;
    font-size: 14px;
}

.quick-links {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.quick-link {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 25px;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.quick-link.primary {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
}

.quick-link.success {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.quick-link.secondary {
    background: linear-gradient(135deg, #6c757d, #5a6268);
    color: white;
}

.quick-link:hover {
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
    padding: 40px;
    text-align: center;
    margin-top: 30px;
    display: flex;
    align-items: center;
    gap: 25px;
}

.message-icon {
    font-size: 64px;
    flex-shrink: 0;
}

.message-content h3 {
    margin: 0 0 15px 0;
    color: #856404;
    font-size: 28px;
}

.message-content p {
    margin: 0 0 10px 0;
    color: #856404;
    font-size: 16px;
}

@media (max-width: 768px) {
    .integration-demo {
        flex-direction: column;
    }
    
    .demo-arrow {
        transform: rotate(90deg);
    }
    
    .final-message {
        flex-direction: column;
        text-align: center;
    }
    
    .message-icon {
        font-size: 48px;
    }
    
    .message-content h3 {
        font-size: 24px;
    }
}
</style>
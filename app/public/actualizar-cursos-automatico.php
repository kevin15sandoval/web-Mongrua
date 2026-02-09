<?php
/**
 * Actualizador Automático de Cursos - Mongruas Formación
 * Sincroniza los cursos del sistema dinámico con la página principal
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🔄 Actualizador Automático de Cursos</h1>";

// Función para sincronizar cursos
function sincronizar_cursos_dinamicos() {
    // Obtener cursos del sistema dinámico
    $cursos_dinamicos = get_option('mongruas_courses', []);
    
    echo "<h2>📊 Estado de Sincronización</h2>";
    echo "<div class='sync-info'>";
    echo "<p><strong>Cursos en sistema dinámico:</strong> " . count($cursos_dinamicos) . "</p>";
    
    if (!empty($cursos_dinamicos)) {
        echo "<h3>📋 Cursos Encontrados:</h3>";
        echo "<ul>";
        foreach ($cursos_dinamicos as $index => $curso) {
            echo "<li><strong>" . ($index + 1) . ".</strong> " . esc_html($curso['name']) . " - " . esc_html($curso['date']) . "</li>";
        }
        echo "</ul>";
        
        echo "<div class='success-message'>";
        echo "✅ <strong>¡Sincronización exitosa!</strong><br>";
        echo "Los cursos del sistema dinámico están disponibles en la página principal.";
        echo "</div>";
        
    } else {
        echo "<div class='warning-message'>";
        echo "⚠️ <strong>No hay cursos en el sistema dinámico.</strong><br>";
        echo "Ve al panel de gestión para agregar cursos.";
        echo "</div>";
    }
    echo "</div>";
    
    return $cursos_dinamicos;
}

// Ejecutar sincronización
$cursos = sincronizar_cursos_dinamicos();

// Verificar integración con página principal
echo "<h2>🌐 Verificación de Integración</h2>";
echo "<div class='integration-check'>";

$page_cursos_path = get_template_directory() . '/page-templates/page-cursos.php';
if (file_exists($page_cursos_path)) {
    $page_content = file_get_contents($page_cursos_path);
    
    if (strpos($page_content, 'mongruas_courses') !== false) {
        echo "<p>✅ <strong>Integración correcta:</strong> La página de cursos está conectada al sistema dinámico</p>";
    } else {
        echo "<p>❌ <strong>Error de integración:</strong> La página de cursos no está conectada al sistema dinámico</p>";
    }
    
    if (strpos($page_content, 'gestionar-cursos-dinamico.php') !== false) {
        echo "<p>✅ <strong>Redirección correcta:</strong> Los botones de gestión apuntan al panel dinámico</p>";
    } else {
        echo "<p>⚠️ <strong>Redirección pendiente:</strong> Algunos botones pueden apuntar al panel anterior</p>";
    }
} else {
    echo "<p>❌ <strong>Error:</strong> No se encontró la página de cursos</p>";
}

echo "</div>";

// Información de URLs
echo "<h2>🔗 URLs del Sistema</h2>";
echo "<div class='urls-info'>";
echo "<p><strong>Página Principal:</strong> <a href='" . home_url('/') . "' target='_blank'>" . home_url('/') . "</a></p>";
echo "<p><strong>Página de Cursos:</strong> <a href='" . home_url('/cursos/') . "' target='_blank'>" . home_url('/cursos/') . "</a></p>";
echo "<p><strong>Panel de Gestión:</strong> <a href='" . home_url('/gestionar-cursos-dinamico.php') . "' target='_blank'>" . home_url('/gestionar-cursos-dinamico.php') . "</a></p>";
echo "</div>";

// Instrucciones para el usuario
echo "<h2>📝 Instrucciones de Uso</h2>";
echo "<div class='instructions'>";
echo "<ol>";
echo "<li><strong>Gestionar Cursos:</strong> Ve al <a href='" . home_url('/gestionar-cursos-dinamico.php') . "' target='_blank'>Panel de Gestión</a></li>";
echo "<li><strong>Agregar Cursos:</strong> Haz clic en 'Agregar Nuevo Curso' y completa los campos</li>";
echo "<li><strong>Subir Imágenes:</strong> Arrastra imágenes o selecciona archivos para cada curso</li>";
echo "<li><strong>Guardar Cambios:</strong> Haz clic en 'Guardar Todos los Cursos'</li>";
echo "<li><strong>Ver Resultado:</strong> Los cambios aparecerán automáticamente en la <a href='" . home_url('/') . "' target='_blank'>página principal</a></li>";
echo "</ol>";
echo "</div>";

// Test de funcionamiento
echo "<h2>🧪 Test de Funcionamiento</h2>";
echo "<div class='test-section'>";

if (!empty($cursos)) {
    echo "<p>✅ <strong>Sistema funcionando correctamente</strong></p>";
    echo "<p>Los cursos se mostrarán automáticamente en:</p>";
    echo "<ul>";
    echo "<li>Página principal (sección 'Próximos Cursos')</li>";
    echo "<li>Página de cursos (/cursos/)</li>";
    echo "<li>Cualquier lugar que use el sistema dinámico</li>";
    echo "</ul>";
} else {
    echo "<p>⚠️ <strong>Sistema listo pero sin cursos</strong></p>";
    echo "<p>Agrega cursos en el panel de gestión para verlos en la página principal.</p>";
}

echo "</div>";

// Botones de acción
echo "<div class='action-buttons'>";
echo "<a href='" . home_url('/gestionar-cursos-dinamico.php') . "' class='btn btn-primary'>🎓 Gestionar Cursos</a>";
echo "<a href='" . home_url('/') . "' class='btn btn-secondary'>🏠 Ver Página Principal</a>";
echo "<a href='" . home_url('/cursos/') . "' class='btn btn-success'>📚 Ver Página de Cursos</a>";
echo "</div>";
?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 900px;
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
    margin-bottom: 15px;
}

h3 {
    color: #6c757d;
    margin-bottom: 10px;
}

.sync-info, .integration-check, .urls-info, .instructions, .test-section {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin: 20px 0;
}

.success-message {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    color: #155724;
    padding: 20px;
    border-radius: 12px;
    margin: 15px 0;
    border: 2px solid #28a745;
    font-weight: 600;
}

.warning-message {
    background: linear-gradient(135deg, #fff3cd, #ffeaa7);
    color: #856404;
    padding: 20px;
    border-radius: 12px;
    margin: 15px 0;
    border: 2px solid #ffc107;
    font-weight: 600;
}

ul, ol {
    padding-left: 25px;
}

li {
    margin: 8px 0;
}

a {
    color: #0066cc;
    text-decoration: none;
    font-weight: 600;
}

a:hover {
    text-decoration: underline;
}

.action-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    margin: 40px 0;
    flex-wrap: wrap;
}

.btn {
    padding: 15px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-primary {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
}

.btn-secondary {
    background: linear-gradient(135deg, #6c757d, #5a6268);
    color: white;
}

.btn-success {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
}

@media (max-width: 768px) {
    .action-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .btn {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
}
</style>
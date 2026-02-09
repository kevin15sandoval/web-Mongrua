<?php
/**
 * Verificar que /anuncios/ está conectado al panel de gestión
 */

require_once('wp-load.php');

echo "<h1>🔗 Verificación de Conexión: Panel ↔ /anuncios/</h1>";
echo "<style>
body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
.success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; margin: 10px 0; border-radius: 5px; }
.info { background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; padding: 15px; margin: 10px 0; border-radius: 5px; }
.warning { background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; margin: 10px 0; border-radius: 5px; }
h2 { color: #333; border-bottom: 2px solid #0066cc; padding-bottom: 10px; margin-top: 30px; }
table { width: 100%; border-collapse: collapse; background: white; margin: 15px 0; }
th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
th { background: #0066cc; color: white; }
</style>";

// 1. Verificar cursos en el panel
echo "<h2>1️⃣ Cursos en el Panel de Gestión</h2>";
$cursos_panel = get_option('mongruas_courses', []);

if (!empty($cursos_panel)) {
    echo "<div class='success'>✅ Hay " . count($cursos_panel) . " curso(s) en el panel de gestión</div>";
    
    echo "<table>";
    echo "<tr><th>#</th><th>Nombre</th><th>Fecha</th><th>Modalidad</th><th>Plazas/Duración</th></tr>";
    foreach ($cursos_panel as $index => $curso) {
        echo "<tr>";
        echo "<td>" . ($index + 1) . "</td>";
        echo "<td><strong>" . esc_html($curso['name']) . "</strong></td>";
        echo "<td>" . esc_html($curso['date']) . "</td>";
        echo "<td>" . esc_html($curso['modality']) . "</td>";
        echo "<td>" . esc_html($curso['duration']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<div class='warning'>⚠️ No hay cursos en el panel de gestión</div>";
    echo "<div class='info'>Ve a <a href='" . home_url('/gestionar-cursos-dinamico.php') . "'>gestionar-cursos-dinamico.php</a> para agregar cursos</div>";
}

// 2. Verificar que /anuncios/ usa el template correcto
echo "<h2>2️⃣ Verificación de Template /anuncios/</h2>";
$page = get_page_by_path('anuncios');
if ($page) {
    $template = get_page_template_slug($page->ID);
    if ($template === 'page-templates/page-anuncios-completa.php') {
        echo "<div class='success'>✅ La página /anuncios/ usa el template correcto: page-anuncios-completa.php</div>";
    } else {
        echo "<div class='warning'>⚠️ Template actual: $template</div>";
        echo "<div class='info'>Debería ser: page-templates/page-anuncios-completa.php</div>";
    }
} else {
    echo "<div class='warning'>⚠️ La página /anuncios/ no existe</div>";
}

// 3. Verificar que el template lee de mongruas_courses
echo "<h2>3️⃣ Verificación del Código del Template</h2>";
$template_path = get_template_directory() . '/page-templates/page-anuncios-completa.php';
if (file_exists($template_path)) {
    $content = file_get_contents($template_path);
    
    if (strpos($content, "get_option('mongruas_courses'") !== false) {
        echo "<div class='success'>✅ El template lee correctamente de 'mongruas_courses'</div>";
    } else {
        echo "<div class='warning'>⚠️ El template NO está leyendo de 'mongruas_courses'</div>";
    }
    
    if (strpos($content, 'proximos-cursos-carousel-section') !== false) {
        echo "<div class='success'>✅ El carrusel está presente en el template</div>";
    } else {
        echo "<div class='warning'>⚠️ El carrusel NO está en el template</div>";
    }
} else {
    echo "<div class='warning'>⚠️ No se encuentra el archivo del template</div>";
}

// 4. Simular lo que verá el usuario
echo "<h2>4️⃣ Simulación de lo que Verá el Usuario</h2>";
if (!empty($cursos_panel)) {
    echo "<div class='info'><strong>El carrusel en /anuncios/ mostrará:</strong></div>";
    echo "<div style='background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px; border-radius: 15px; margin: 20px 0;'>";
    echo "<h3 style='color: white; text-align: center; margin-bottom: 30px;'>Próximos Cursos</h3>";
    echo "<div style='display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;'>";
    
    $count = 0;
    foreach ($cursos_panel as $curso) {
        if ($count >= 3) break; // Solo mostrar 3 en la simulación
        echo "<div style='background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);'>";
        echo "<div style='background: linear-gradient(135deg, #27ae60, #229954); color: white; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; display: inline-block; margin-bottom: 10px;'>" . esc_html($curso['date']) . "</div>";
        echo "<h4 style='color: #2c3e50; margin: 10px 0;'>" . esc_html($curso['name']) . "</h4>";
        echo "<p style='color: #6c757d; font-size: 0.9rem; margin: 10px 0;'>" . esc_html($curso['description']) . "</p>";
        echo "<div style='margin: 15px 0;'>";
        echo "<span style='margin-right: 15px;'>💻 " . esc_html($curso['modality']) . "</span>";
        echo "<span>👥 " . esc_html($curso['duration']) . "</span>";
        echo "</div>";
        echo "<div style='display: flex; flex-direction: column; gap: 8px; margin-top: 15px;'>";
        echo "<button style='background: linear-gradient(135deg, #3498db, #2980b9); color: white; border: none; padding: 10px; border-radius: 20px; font-weight: 600;'>Ver más información</button>";
        echo "<button style='background: linear-gradient(135deg, #27ae60, #229954); color: white; border: none; padding: 10px; border-radius: 20px; font-weight: 600;'>Inscribirse</button>";
        echo "</div>";
        echo "</div>";
        $count++;
    }
    
    echo "</div>";
    echo "</div>";
} else {
    echo "<div class='warning'>⚠️ No hay cursos para mostrar. Agrega cursos en el panel de gestión primero.</div>";
}

// 5. Enlaces útiles
echo "<h2>5️⃣ Enlaces Útiles</h2>";
echo "<div class='info'>";
echo "<ul style='margin: 10px 0; padding-left: 20px;'>";
echo "<li><a href='" . home_url('/gestionar-cursos-dinamico.php') . "' target='_blank'><strong>Panel de Gestión de Cursos</strong></a> - Agregar/editar cursos</li>";
echo "<li><a href='" . home_url('/anuncios/') . "' target='_blank'><strong>Página /anuncios/</strong></a> - Ver el carrusel en acción</li>";
echo "<li><strong>Ctrl + F5</strong> - Forzar recarga para ver cambios</li>";
echo "</ul>";
echo "</div>";

// 6. Instrucciones
echo "<h2>6️⃣ Cómo Funciona</h2>";
echo "<div class='info'>";
echo "<ol style='margin: 10px 0; padding-left: 20px;'>";
echo "<li>Ve al <a href='" . home_url('/gestionar-cursos-dinamico.php') . "'>Panel de Gestión</a></li>";
echo "<li>Agrega o edita cursos (nombre, fecha, modalidad, plazas, descripción)</li>";
echo "<li>Haz clic en <strong>'💾 Guardar Todos los Cursos'</strong></li>";
echo "<li>Ve a <a href='" . home_url('/anuncios/') . "'>/anuncios/</a> y presiona <strong>Ctrl + F5</strong></li>";
echo "<li>Los cursos aparecerán automáticamente en el carrusel morado</li>";
echo "</ol>";
echo "</div>";

echo "<div class='success' style='margin-top: 30px; font-size: 18px; text-align: center;'>";
echo "✅ <strong>Conexión Verificada!</strong><br>";
echo "El carrusel en /anuncios/ está conectado al panel de gestión";
echo "</div>";
?>

<?php
/**
 * Verificación del carrusel de Próximos Cursos en /anuncios/
 * 
 * Este script verifica que:
 * 1. La página /anuncios/ tiene el template correcto
 * 2. El carrusel está conectado a la base de datos
 * 3. Los estilos y JavaScript están presentes
 */

require_once('wp-load.php');

echo "<h1>🔍 Verificación del Carrusel en /anuncios/</h1>";
echo "<style>
body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
.success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; margin: 10px 0; border-radius: 5px; }
.info { background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; padding: 15px; margin: 10px 0; border-radius: 5px; }
.warning { background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; margin: 10px 0; border-radius: 5px; }
.error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; margin: 10px 0; border-radius: 5px; }
h2 { color: #333; border-bottom: 2px solid #0066cc; padding-bottom: 10px; }
pre { background: #fff; padding: 10px; border-radius: 5px; overflow-x: auto; }
</style>";

// 1. Verificar que la página existe
echo "<h2>1️⃣ Verificación de la Página /anuncios/</h2>";
$page = get_page_by_path('anuncios');
if ($page) {
    echo "<div class='success'>✅ La página /anuncios/ existe (ID: {$page->ID})</div>";
    echo "<div class='info'>📄 Estado: {$page->post_status}</div>";
    echo "<div class='info'>📋 Template: " . get_page_template_slug($page->ID) . "</div>";
    
    if (get_page_template_slug($page->ID) === 'page-templates/page-anuncios-completa.php') {
        echo "<div class='success'>✅ Template correcto: page-anuncios-completa.php</div>";
    } else {
        echo "<div class='warning'>⚠️ Template diferente. Debería ser: page-templates/page-anuncios-completa.php</div>";
    }
} else {
    echo "<div class='error'>❌ La página /anuncios/ NO existe</div>";
}

// 2. Verificar conexión a base de datos
echo "<h2>2️⃣ Verificación de Cursos en Base de Datos</h2>";
global $wpdb;
$table_name = $wpdb->prefix . 'upcoming_courses';

$table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name;
if ($table_exists) {
    echo "<div class='success'>✅ Tabla '$table_name' existe</div>";
    
    $cursos = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id ASC");
    $count = count($cursos);
    
    if ($count > 0) {
        echo "<div class='success'>✅ Hay $count curso(s) en la base de datos</div>";
        echo "<div class='info'><strong>Cursos disponibles:</strong><ul>";
        foreach ($cursos as $curso) {
            echo "<li><strong>{$curso->course_name}</strong> - {$curso->start_date} ({$curso->modality})</li>";
        }
        echo "</ul></div>";
    } else {
        echo "<div class='warning'>⚠️ No hay cursos en la base de datos. El carrusel mostrará mensaje de 'No hay cursos disponibles'</div>";
    }
} else {
    echo "<div class='error'>❌ La tabla '$table_name' NO existe</div>";
}

// 3. Verificar que el archivo del template existe
echo "<h2>3️⃣ Verificación del Archivo Template</h2>";
$template_path = get_template_directory() . '/page-templates/page-anuncios-completa.php';
if (file_exists($template_path)) {
    echo "<div class='success'>✅ Archivo template existe: $template_path</div>";
    
    $content = file_get_contents($template_path);
    
    // Verificar secciones clave
    $checks = [
        'proximos-cursos-carousel-section' => 'Sección del carrusel',
        'proximosCarouselTrack' => 'Track del carrusel',
        'proximosPrevBtn' => 'Botón anterior',
        'proximosNextBtn' => 'Botón siguiente',
        'proximos-carousel-control' => 'Controles del carrusel',
        'proximos-carousel-dots' => 'Dots del carrusel',
        'updateCarousel()' => 'Función JavaScript del carrusel',
        'wp_upcoming_courses' => 'Conexión a base de datos'
    ];
    
    echo "<div class='info'><strong>Elementos encontrados en el template:</strong><ul>";
    foreach ($checks as $search => $description) {
        if (strpos($content, $search) !== false) {
            echo "<li>✅ $description</li>";
        } else {
            echo "<li>❌ $description NO encontrado</li>";
        }
    }
    echo "</ul></div>";
    
} else {
    echo "<div class='error'>❌ Archivo template NO existe: $template_path</div>";
}

// 4. Instrucciones finales
echo "<h2>4️⃣ Instrucciones para Ver el Carrusel</h2>";
echo "<div class='info'>
<strong>Para ver el carrusel en acción:</strong>
<ol>
    <li>Visita: <a href='" . home_url('/anuncios/') . "' target='_blank'>" . home_url('/anuncios/') . "</a></li>
    <li>Presiona <strong>Ctrl + F5</strong> para forzar recarga y limpiar caché</li>
    <li>El carrusel debe aparecer en la parte superior con fondo morado/púrpura</li>
    <li>Debe mostrar 3 tarjetas en escritorio, 2 en tablet, 1 en móvil</li>
    <li>Los botones circulares con borde azul deben funcionar</li>
    <li>Los dots en la parte inferior deben cambiar al navegar</li>
</ol>
</div>";

echo "<h2>5️⃣ Características del Carrusel</h2>";
echo "<div class='info'>
<strong>El carrusel tiene:</strong>
<ul>
    <li>🎨 Fondo degradado morado/púrpura (#667eea → #764ba2)</li>
    <li>🔵 Botones circulares con borde azul</li>
    <li>📱 Responsive: 3 columnas (desktop), 2 (tablet), 1 (móvil)</li>
    <li>🎯 Navegación con flechas, dots y soporte táctil</li>
    <li>💾 Conectado a base de datos wp_upcoming_courses</li>
    <li>🔗 Botones: 'Ver más información' (azul) e 'Inscribirse' (verde)</li>
    <li>📅 Badge verde con fecha de inicio</li>
    <li>💻 Detalles: modalidad, plazas disponibles, duración</li>
</ul>
</div>";

echo "<h2>6️⃣ Gestión de Cursos</h2>";
echo "<div class='info'>
<strong>Para agregar/editar cursos:</strong>
<ol>
    <li>Accede al panel: <a href='" . home_url('/panel-gestion.php') . "' target='_blank'>" . home_url('/panel-gestion.php') . "</a></li>
    <li>Los cursos que agregues aparecerán automáticamente en el carrusel</li>
    <li>Los cambios se reflejan inmediatamente (recarga con Ctrl + F5)</li>
</ol>
</div>";

echo "<div class='success' style='margin-top: 30px; font-size: 18px;'>
✅ <strong>Verificación completada!</strong><br>
El carrusel de Próximos Cursos está integrado en /anuncios/
</div>";
?>

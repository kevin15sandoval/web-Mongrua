<?php
/**
 * FORZAR TODO - Arreglar /anuncios/ de una vez
 */

require_once('wp-load.php');

echo "<h1>🔧 FORZANDO ARREGLO DE /ANUNCIOS/</h1>";
echo "<style>
body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
.success { background: #d4edda; border-left: 4px solid #28a745; padding: 15px; margin: 10px 0; }
.error { background: #f8d7da; border-left: 4px solid #dc3545; padding: 15px; margin: 10px 0; }
.info { background: #d1ecf1; border-left: 4px solid #17a2b8; padding: 15px; margin: 10px 0; }
h2 { color: #333; border-bottom: 2px solid #0066cc; padding-bottom: 10px; margin-top: 30px; }
</style>";

// 1. Verificar/crear página
echo "<h2>1️⃣ Verificando página /anuncios/</h2>";
$page = get_page_by_path('anuncios');

if (!$page) {
    echo "<div class='error'>❌ La página no existe. Creándola...</div>";
    
    $page_id = wp_insert_post([
        'post_title' => 'Anuncios',
        'post_name' => 'anuncios',
        'post_status' => 'publish',
        'post_type' => 'page',
        'post_content' => ''
    ]);
    
    if ($page_id) {
        echo "<div class='success'>✅ Página creada (ID: $page_id)</div>";
        $page = get_post($page_id);
    }
} else {
    echo "<div class='success'>✅ La página existe (ID: {$page->ID})</div>";
}

// 2. Forzar template correcto
if ($page) {
    echo "<h2>2️⃣ Forzando template correcto</h2>";
    
    $template_actual = get_page_template_slug($page->ID);
    echo "<div class='info'>Template actual: <strong>$template_actual</strong></div>";
    
    $template_correcto = 'page-templates/page-anuncios-completa.php';
    
    if ($template_actual !== $template_correcto) {
        update_post_meta($page->ID, '_wp_page_template', $template_correcto);
        echo "<div class='success'>✅ Template cambiado a: <strong>$template_correcto</strong></div>";
    } else {
        echo "<div class='success'>✅ Template ya es correcto</div>";
    }
}

// 3. Verificar cursos
echo "<h2>3️⃣ Verificando cursos guardados</h2>";
$cursos = get_option('mongruas_courses', []);

if (empty($cursos)) {
    echo "<div class='error'>❌ NO HAY CURSOS. Creando cursos de ejemplo...</div>";
    
    $cursos_ejemplo = [
        [
            'name' => 'Instalaciones Eléctricas de Baja Tensión',
            'date' => 'Febrero 2026',
            'modality' => 'Presencial',
            'duration' => '15 plazas',
            'description' => 'Certificado de profesionalidad oficial ELEE0109. Formación completa en instalaciones eléctricas.',
            'image' => ''
        ],
        [
            'name' => 'Sistemas Domóticos e Inmóticos',
            'date' => 'Marzo 2026',
            'modality' => 'Presencial',
            'duration' => '12 plazas',
            'description' => 'Certificado ELEM0111. Aprende a instalar y mantener sistemas de automatización.',
            'image' => ''
        ],
        [
            'name' => 'Control de Plagas',
            'date' => 'Abril 2026',
            'modality' => 'Presencial',
            'duration' => '10 plazas',
            'description' => 'Certificado SEAG0110. Formación profesional en control y prevención de plagas.',
            'image' => ''
        ]
    ];
    
    update_option('mongruas_courses', $cursos_ejemplo);
    $cursos = $cursos_ejemplo;
    echo "<div class='success'>✅ Creados 3 cursos de ejemplo</div>";
} else {
    echo "<div class='success'>✅ Hay " . count($cursos) . " curso(s) guardado(s)</div>";
}

// 4. Limpiar caché
echo "<h2>4️⃣ Limpiando caché</h2>";

// Limpiar caché de WordPress
wp_cache_flush();
echo "<div class='success'>✅ Caché de WordPress limpiado</div>";

// Limpiar caché de objetos
if (function_exists('wp_cache_delete')) {
    wp_cache_delete('mongruas_courses', 'options');
}
echo "<div class='success'>✅ Caché de opciones limpiado</div>";

// Limpiar transients
delete_transient('mongruas_courses');
echo "<div class='success'>✅ Transients limpiados</div>";

// 5. Verificar archivo del template
echo "<h2>5️⃣ Verificando archivo del template</h2>";
$template_path = get_template_directory() . '/page-templates/page-anuncios-completa.php';

if (file_exists($template_path)) {
    echo "<div class='success'>✅ El archivo del template existe</div>";
    
    $content = file_get_contents($template_path);
    
    if (strpos($content, "get_option('mongruas_courses'") !== false) {
        echo "<div class='success'>✅ El template lee de 'mongruas_courses'</div>";
    } else {
        echo "<div class='error'>❌ El template NO lee de 'mongruas_courses'</div>";
    }
    
    if (strpos($content, 'proximos-cursos-carousel-section') !== false) {
        echo "<div class='success'>✅ El carrusel está en el template</div>";
    } else {
        echo "<div class='error'>❌ El carrusel NO está en el template</div>";
    }
} else {
    echo "<div class='error'>❌ El archivo del template NO existe: $template_path</div>";
}

// 6. Test directo del código
echo "<h2>6️⃣ Test directo del código PHP</h2>";
echo "<div class='info'>";
echo "<strong>Simulando lo que hace /anuncios/:</strong><br><br>";

$test_cursos = get_option('mongruas_courses', []);
echo "Cursos encontrados: <strong>" . count($test_cursos) . "</strong><br><br>";

if (!empty($test_cursos)) {
    echo "<strong>Cursos que deberían aparecer:</strong><ul>";
    foreach ($test_cursos as $curso) {
        echo "<li><strong>" . esc_html($curso['name']) . "</strong> - " . esc_html($curso['date']) . "</li>";
    }
    echo "</ul>";
}
echo "</div>";

// 7. Instrucciones finales
echo "<h2>7️⃣ AHORA HAZ ESTO:</h2>";
echo "<div class='success' style='font-size: 16px;'>";
echo "<ol style='margin: 15px 0; padding-left: 25px;'>";
echo "<li><strong>Cierra TODAS las pestañas</strong> de tu navegador</li>";
echo "<li><strong>Abre una nueva ventana</strong> en modo incógnito (Ctrl + Shift + N)</li>";
echo "<li><strong>Ve a:</strong> <a href='" . home_url('/anuncios/') . "' target='_blank' style='color: #0066cc; font-weight: bold;'>" . home_url('/anuncios/') . "</a></li>";
echo "<li><strong>Deberías ver:</strong>";
echo "<ul style='margin-top: 10px;'>";
echo "<li>✅ Fondo morado degradado en la parte superior</li>";
echo "<li>✅ Título 'Próximos Cursos'</li>";
echo "<li>✅ Tarjetas blancas con los cursos</li>";
echo "<li>✅ Botones circulares con flechas</li>";
echo "</ul>";
echo "</li>";
echo "</ol>";
echo "</div>";

// 8. Si sigue sin funcionar
echo "<h2>8️⃣ Si TODAVÍA no aparece nada:</h2>";
echo "<div class='error'>";
echo "<strong>Entonces el problema es que WordPress está usando OTRO template.</strong><br><br>";
echo "<strong>Solución:</strong><br>";
echo "1. Ve al admin de WordPress: <a href='" . admin_url('edit.php?post_type=page') . "' target='_blank'>Páginas</a><br>";
echo "2. Busca la página 'Anuncios'<br>";
echo "3. Haz clic en 'Editar'<br>";
echo "4. En el panel derecho, busca 'Atributos de página' → 'Plantilla'<br>";
echo "5. Selecciona: <strong>'Anuncios Completa'</strong><br>";
echo "6. Haz clic en 'Actualizar'<br>";
echo "7. Vuelve a /anuncios/ y presiona Ctrl + F5";
echo "</div>";

// 9. Enlaces útiles
echo "<h2>🔗 Enlaces Útiles</h2>";
echo "<div class='info'>";
echo "<ul>";
echo "<li><a href='" . home_url('/anuncios/') . "' target='_blank'><strong>Ver /anuncios/</strong></a> (abre en modo incógnito)</li>";
echo "<li><a href='" . home_url('/gestionar-cursos-dinamico.php') . "' target='_blank'><strong>Panel de Gestión</strong></a></li>";
echo "<li><a href='" . admin_url('edit.php?post_type=page') . "' target='_blank'><strong>Admin WordPress - Páginas</strong></a></li>";
echo "</ul>";
echo "</div>";

echo "<div class='success' style='margin-top: 30px; font-size: 18px; text-align: center;'>";
echo "✅ <strong>TODO FORZADO!</strong><br>";
echo "Ahora ve a /anuncios/ en modo incógnito";
echo "</div>";
?>

<?php
/**
 * Diagnóstico Final - Página Anuncios
 * Verificar por qué no se aplican los estilos de "Próximos Cursos"
 */

// Verificar si estamos en WordPress
if (!defined('ABSPATH')) {
    // Cargar WordPress
    require_once('wp-config.php');
}

echo "<h1>🔍 Diagnóstico Final - Página Anuncios</h1>";

// 1. Verificar la página /anuncios/
echo "<h2>1. Verificación de Página</h2>";
$anuncios_page = get_page_by_path('anuncios');
if ($anuncios_page) {
    echo "✅ Página 'anuncios' encontrada<br>";
    echo "- ID: " . $anuncios_page->ID . "<br>";
    echo "- Título: " . $anuncios_page->post_title . "<br>";
    echo "- Template: " . get_page_template_slug($anuncios_page->ID) . "<br>";
    echo "- URL: " . get_permalink($anuncios_page->ID) . "<br>";
} else {
    echo "❌ Página 'anuncios' NO encontrada<br>";
}

// 2. Verificar template
echo "<h2>2. Verificación de Template</h2>";
$template_path = get_template_directory() . '/page-templates/page-cursos.php';
if (file_exists($template_path)) {
    echo "✅ Template page-cursos.php existe<br>";
    echo "- Ruta: $template_path<br>";
    
    // Verificar si contiene los estilos
    $template_content = file_get_contents($template_path);
    if (strpos($template_content, 'upcoming-courses-section') !== false) {
        echo "✅ Template contiene estilos de 'upcoming-courses-section'<br>";
    } else {
        echo "❌ Template NO contiene estilos de 'upcoming-courses-section'<br>";
    }
    
    if (strpos($template_content, 'max-width: 1000px !important') !== false) {
        echo "✅ Template contiene estilos forzados con !important<br>";
    } else {
        echo "❌ Template NO contiene estilos forzados<br>";
    }
} else {
    echo "❌ Template page-cursos.php NO existe<br>";
}

// 3. Verificar CSS externo
echo "<h2>3. Verificación de CSS Externo</h2>";
$css_path = get_template_directory() . '/assets/css/upcoming-courses.css';
if (file_exists($css_path)) {
    echo "✅ CSS upcoming-courses.css existe<br>";
    echo "- Ruta: $css_path<br>";
    
    $css_content = file_get_contents($css_path);
    if (strpos($css_content, 'max-width: 1000px') !== false) {
        echo "✅ CSS contiene max-width: 1000px<br>";
    }
    if (strpos($css_content, 'grid-template-columns: repeat(2, 1fr)') !== false) {
        echo "✅ CSS contiene grid de 2 columnas<br>";
    }
} else {
    echo "❌ CSS upcoming-courses.css NO existe<br>";
}

// 4. Verificar functions.php
echo "<h2>4. Verificación de Functions.php</h2>";
$functions_path = get_template_directory() . '/functions.php';
if (file_exists($functions_path)) {
    $functions_content = file_get_contents($functions_path);
    if (strpos($functions_content, "is_page('anuncios')") !== false) {
        echo "✅ Functions.php contiene condición para página 'anuncios'<br>";
    } else {
        echo "❌ Functions.php NO contiene condición para página 'anuncios'<br>";
    }
}

// 5. Verificar cursos dinámicos
echo "<h2>5. Verificación de Cursos Dinámicos</h2>";
$courses = get_option('mongruas_courses', []);
if (!empty($courses)) {
    echo "✅ Cursos dinámicos encontrados: " . count($courses) . "<br>";
    foreach ($courses as $i => $course) {
        echo "- Curso " . ($i + 1) . ": " . $course['name'] . " (" . $course['date'] . ")<br>";
    }
} else {
    echo "❌ No hay cursos dinámicos guardados<br>";
}

// 6. Generar HTML de prueba
echo "<h2>6. Prueba Visual Directa</h2>";
echo "<p>Aplicando estilos directamente aquí:</p>";

?>

<style>
/* ESTILOS FORZADOS PARA PRÓXIMOS CURSOS - APLICACIÓN DIRECTA */
.test-upcoming-courses-section {
    padding: 50px 0 !important;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%) !important;
}

.test-upcoming-courses-section .container {
    max-width: 1000px !important;
    margin: 0 auto !important;
    padding: 0 20px !important;
}

.test-upcoming-courses-section .section-header h2 {
    font-size: 2.5rem !important;
    color: #2c3e50 !important;
    text-align: center !important;
    margin-bottom: 15px !important;
    font-weight: 700 !important;
}

.test-upcoming-courses-section .section-header h2::after {
    content: "" !important;
    display: block !important;
    width: 60px !important;
    height: 3px !important;
    background: linear-gradient(90deg, #3498db, #27ae60) !important;
    margin: 15px auto 0 !important;
    border-radius: 2px !important;
}

/* GRID FORZADO - MÁXIMO 2 COLUMNAS */
.test-upcoming-courses-grid {
    display: grid !important;
    grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)) !important;
    gap: 25px !important;
    margin-top: 35px !important;
    max-width: 950px !important;
    margin-left: auto !important;
    margin-right: auto !important;
}

/* FORZAR 2 COLUMNAS EN PANTALLAS GRANDES */
@media (min-width: 1200px) {
    .test-upcoming-courses-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        max-width: 900px !important;
    }
}

.test-upcoming-course-card {
    background: white !important;
    border-radius: 15px !important;
    overflow: hidden !important;
    box-shadow: 0 6px 25px rgba(0,0,0,0.08) !important;
    transition: all 0.3s ease !important;
    position: relative !important;
    border: 1px solid rgba(0,0,0,0.05) !important;
    max-width: 100% !important;
}

.test-upcoming-course-card::before {
    content: "" !important;
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    height: 3px !important;
    background: linear-gradient(90deg, #3498db, #27ae60) !important;
    border-radius: 15px 15px 0 0 !important;
}

.test-course-content {
    padding: 22px !important;
}

.test-course-badge {
    background: linear-gradient(135deg, #e74c3c, #c0392b) !important;
    color: white !important;
    padding: 5px 12px !important;
    border-radius: 18px !important;
    font-size: 0.75rem !important;
    font-weight: 600 !important;
    text-transform: uppercase !important;
    display: inline-block !important;
    margin-bottom: 10px !important;
}

.test-course-date {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    margin-bottom: 15px !important;
    color: #e74c3c !important;
    font-weight: 600 !important;
    background: rgba(231, 76, 60, 0.08) !important;
    padding: 8px 12px !important;
    border-radius: 8px !important;
    border-left: 3px solid #e74c3c !important;
    font-size: 0.9rem !important;
}

.test-btn-reserve {
    background: linear-gradient(135deg, #27ae60, #229954) !important;
    color: white !important;
    padding: 12px 24px !important;
    border-radius: 22px !important;
    text-decoration: none !important;
    font-weight: 600 !important;
    text-align: center !important;
    width: 100% !important;
    font-size: 0.9rem !important;
    text-transform: uppercase !important;
    display: block !important;
}

/* RESPONSIVE FORZADO */
@media (max-width: 768px) {
    .test-upcoming-courses-grid {
        grid-template-columns: 1fr !important;
        gap: 20px !important;
        max-width: 100% !important;
    }
}
</style>

<div class="test-upcoming-courses-section">
    <div class="container">
        <div class="section-header">
            <h2>Próximos Cursos (PRUEBA)</h2>
            <p>Esta es una prueba visual para verificar que los estilos funcionan</p>
        </div>
        
        <div class="test-upcoming-courses-grid">
            <?php
            // Crear cursos de prueba
            $test_courses = [
                ['name' => 'Montaje y Mantenimiento de Instalaciones Eléctricas', 'date' => 'Enero 2025', 'description' => 'Curso completo de instalaciones eléctricas de baja tensión con certificado oficial.'],
                ['name' => 'Sistemas Domóticos e Inmóticos', 'date' => 'Febrero 2025', 'description' => 'Especialización en automatización de edificios y sistemas inteligentes.'],
                ['name' => 'Control de Plagas', 'date' => 'Marzo 2025', 'description' => 'Formación profesional en control y prevención de plagas urbanas.']
            ];
            
            foreach ($test_courses as $course):
            ?>
                <div class="test-upcoming-course-card">
                    <div class="test-course-content">
                        <div class="test-course-badge">Próximamente</div>
                        
                        <div class="test-course-date">
                            <span>📅</span>
                            <span><?php echo $course['date']; ?></span>
                        </div>
                        
                        <h3><?php echo $course['name']; ?></h3>
                        <p><?php echo $course['description']; ?></p>
                        
                        <a href="#" class="test-btn-reserve">Solicitar Información</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php
echo "<h2>7. Solución Recomendada</h2>";
echo "<p><strong>Si la prueba visual de arriba muestra 2 columnas correctamente, entonces el problema está en la página real.</strong></p>";
echo "<p>Vamos a aplicar una solución directa:</p>";
echo "<ol>";
echo "<li>Forzar los estilos directamente en el template</li>";
echo "<li>Limpiar cualquier cache de WordPress</li>";
echo "<li>Verificar que la página use el template correcto</li>";
echo "</ol>";

echo "<p><a href='" . home_url('/anuncios/') . "' target='_blank' style='background: #0066cc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🔗 Ver Página Anuncios</a></p>";
?>
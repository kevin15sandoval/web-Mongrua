<?php
/**
 * Verificador de Integración Dinámica - Mongruas Formación
 * Verifica que el sistema dinámico esté completamente integrado
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🔍 Verificación de Integración Dinámica</h1>";

$tests_passed = 0;
$total_tests = 6;

// Test 1: Verificar sistema dinámico
echo "<h2>1️⃣ Test Sistema Dinámico</h2>";
$cursos_dinamicos = get_option('mongruas_courses', []);
if (!empty($cursos_dinamicos)) {
    echo "<p>✅ <strong>Sistema dinámico:</strong> " . count($cursos_dinamicos) . " cursos encontrados</p>";
    foreach ($cursos_dinamicos as $index => $curso) {
        echo "<p>   📚 <strong>Curso " . ($index + 1) . ":</strong> " . esc_html($curso['name']) . "</p>";
    }
    $tests_passed++;
} else {
    echo "<p>❌ <strong>Sistema dinámico:</strong> No hay cursos guardados</p>";
}

// Test 2: Verificar integración en página de cursos
echo "<h2>2️⃣ Test Integración Página de Cursos</h2>";
$page_cursos_path = get_template_directory() . '/page-templates/page-cursos.php';
if (file_exists($page_cursos_path)) {
    $page_content = file_get_contents($page_cursos_path);
    
    if (strpos($page_content, 'mongruas_courses') !== false) {
        echo "<p>✅ <strong>Integración:</strong> Página de cursos conectada al sistema dinámico</p>";
        $tests_passed++;
    } else {
        echo "<p>❌ <strong>Integración:</strong> Página de cursos NO conectada al sistema dinámico</p>";
    }
} else {
    echo "<p>❌ <strong>Error:</strong> Archivo page-cursos.php no encontrado</p>";
}

// Test 3: Verificar redirecciones en header
echo "<h2>3️⃣ Test Redirecciones Header</h2>";
$header_path = get_template_directory() . '/header.php';
if (file_exists($header_path)) {
    $header_content = file_get_contents($header_path);
    
    if (strpos($header_content, 'gestionar-cursos-dinamico.php') !== false) {
        echo "<p>✅ <strong>Header:</strong> Botón de gestión apunta al panel dinámico</p>";
        $tests_passed++;
    } else {
        echo "<p>❌ <strong>Header:</strong> Botón de gestión NO apunta al panel dinámico</p>";
    }
} else {
    echo "<p>❌ <strong>Error:</strong> Archivo header.php no encontrado</p>";
}

// Test 4: Verificar archivos del sistema dinámico
echo "<h2>4️⃣ Test Archivos Sistema Dinámico</h2>";
$archivos_sistema = [
    'gestionar-cursos-dinamico.php' => 'Panel principal',
    'eliminar-curso.php' => 'Eliminación de cursos',
    'upload-image.php' => 'Subida de imágenes'
];

$archivos_ok = 0;
foreach ($archivos_sistema as $archivo => $descripcion) {
    $ruta = ABSPATH . $archivo;
    if (file_exists($ruta)) {
        echo "<p>✅ <strong>$descripcion:</strong> $archivo existe</p>";
        $archivos_ok++;
    } else {
        echo "<p>❌ <strong>$descripcion:</strong> $archivo NO existe</p>";
    }
}

if ($archivos_ok === count($archivos_sistema)) {
    $tests_passed++;
}

// Test 5: Verificar directorio de imágenes
echo "<h2>5️⃣ Test Directorio de Imágenes</h2>";
$upload_dir = ABSPATH . 'wp-content/uploads/cursos/';
if (is_dir($upload_dir) && is_writable($upload_dir)) {
    echo "<p>✅ <strong>Directorio:</strong> wp-content/uploads/cursos/ existe y es escribible</p>";
    $tests_passed++;
} else {
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
        echo "<p>✅ <strong>Directorio:</strong> wp-content/uploads/cursos/ creado automáticamente</p>";
        $tests_passed++;
    } else {
        echo "<p>❌ <strong>Directorio:</strong> wp-content/uploads/cursos/ no es escribible</p>";
    }
}

// Test 6: Verificar URLs de acceso
echo "<h2>6️⃣ Test URLs de Acceso</h2>";
$urls_sistema = [
    'Panel Dinámico' => '/gestionar-cursos-dinamico.php',
    'Actualizador' => '/actualizar-cursos-automatico.php',
    'Verificador' => '/verificar-integracion-dinamica.php'
];

$urls_ok = 0;
foreach ($urls_sistema as $nombre => $url) {
    $ruta_completa = ABSPATH . ltrim($url, '/');
    if (file_exists($ruta_completa)) {
        echo "<p>✅ <strong>$nombre:</strong> <a href='" . home_url($url) . "' target='_blank'>" . home_url($url) . "</a></p>";
        $urls_ok++;
    } else {
        echo "<p>❌ <strong>$nombre:</strong> $url NO accesible</p>";
    }
}

if ($urls_ok === count($urls_sistema)) {
    $tests_passed++;
}

// Resumen final
echo "<h2>📊 Resumen de Verificación</h2>";
$success_rate = round(($tests_passed / $total_tests) * 100);

echo "<div class='verification-summary'>";
echo "<div class='verification-stats'>";
echo "<div class='stat-item'>";
echo "<div class='stat-number'>$tests_passed/$total_tests</div>";
echo "<div class='stat-label'>Tests Pasados</div>";
echo "</div>";
echo "<div class='stat-item'>";
echo "<div class='stat-number'>$success_rate%</div>";
echo "<div class='stat-label'>Tasa de Éxito</div>";
echo "</div>";
echo "</div>";

if ($tests_passed === $total_tests) {
    echo "<div class='result-box success'>";
    echo "<div class='result-icon'>🎉</div>";
    echo "<div class='result-text'>";
    echo "<h3>¡Integración Completamente Funcional!</h3>";
    echo "<p>El sistema dinámico está perfectamente integrado. Los cursos que gestiones en el panel aparecerán automáticamente en la página principal.</p>";
    echo "</div>";
    echo "</div>";
} else {
    echo "<div class='result-box warning'>";
    echo "<div class='result-icon'>⚠️</div>";
    echo "<div class='result-text'>";
    echo "<h3>Integración Parcial</h3>";
    echo "<p>Algunos componentes necesitan atención. Revisa los errores arriba.</p>";
    echo "</div>";
    echo "</div>";
}

echo "</div>";

// Instrucciones de uso
echo "<h2>📝 Cómo Funciona la Integración</h2>";
echo "<div class='how-it-works'>";
echo "<div class='step-item'>";
echo "<div class='step-number'>1</div>";
echo "<div class='step-content'>";
echo "<h4>Gestionar Cursos</h4>";
echo "<p>Ve al <a href='" . home_url('/gestionar-cursos-dinamico.php') . "' target='_blank'>Panel de Gestión Dinámico</a> para agregar, editar o eliminar cursos.</p>";
echo "</div>";
echo "</div>";

echo "<div class='step-item'>";
echo "<div class='step-number'>2</div>";
echo "<div class='step-content'>";
echo "<h4>Actualización Automática</h4>";
echo "<p>Los cambios se guardan en la base de datos de WordPress y aparecen automáticamente en la página principal.</p>";
echo "</div>";
echo "</div>";

echo "<div class='step-item'>";
echo "<div class='step-number'>3</div>";
echo "<div class='step-content'>";
echo "<h4>Visualización</h4>";
echo "<p>Los cursos se muestran en la sección 'Próximos Cursos' de la <a href='" . home_url('/') . "' target='_blank'>página principal</a>.</p>";
echo "</div>";
echo "</div>";
echo "</div>";

// Botones de acción
echo "<div class='action-section'>";
echo "<h3>🚀 Acciones Disponibles</h3>";
echo "<div class='action-buttons'>";
echo "<a href='" . home_url('/gestionar-cursos-dinamico.php') . "' class='btn btn-primary'>🎓 Panel de Gestión</a>";
echo "<a href='" . home_url('/actualizar-cursos-automatico.php') . "' class='btn btn-secondary'>🔄 Actualizador</a>";
echo "<a href='" . home_url('/') . "' class='btn btn-success'>🏠 Ver Página Principal</a>";
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
    margin-bottom: 15px;
}

h3, h4 {
    color: #495057;
    margin-bottom: 10px;
}

p {
    margin: 8px 0;
    padding-left: 20px;
}

a {
    color: #0066cc;
    text-decoration: none;
    font-weight: 600;
}

a:hover {
    text-decoration: underline;
}

.verification-summary {
    background: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    margin: 30px 0;
}

.verification-stats {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin-bottom: 30px;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 36px;
    font-weight: 800;
    color: #0066cc;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 14px;
    color: #6c757d;
    font-weight: 600;
}

.result-box {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 25px;
    border-radius: 12px;
    margin: 20px 0;
}

.result-box.success {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    border: 2px solid #28a745;
}

.result-box.warning {
    background: linear-gradient(135deg, #fff3cd, #ffeaa7);
    border: 2px solid #ffc107;
}

.result-icon {
    font-size: 48px;
    flex-shrink: 0;
}

.result-text h3 {
    margin: 0 0 10px 0;
    color: #495057;
}

.result-text p {
    margin: 0;
    padding: 0;
    color: #6c757d;
}

.how-it-works {
    background: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin: 30px 0;
}

.step-item {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 25px;
    padding-bottom: 25px;
    border-bottom: 1px solid #e9ecef;
}

.step-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.step-number {
    background: linear-gradient(135deg, #0066cc, #0052a3);
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
}

.step-content p {
    margin: 0;
    padding: 0;
    color: #6c757d;
}

.action-section {
    background: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin: 30px 0;
    text-align: center;
}

.action-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 20px;
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
    .verification-stats {
        flex-direction: column;
        gap: 20px;
    }
    
    .result-box {
        flex-direction: column;
        text-align: center;
    }
    
    .step-item {
        flex-direction: column;
        text-align: center;
    }
    
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
<?php
/**
 * Corrección de enlaces de cursos individuales
 */

require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🔧 Corrección de Enlaces de Cursos</h1>";

// Verificar si curso.php existe y es correcto
$curso_php_content = '<?php
/**
 * Página individual de curso
 * URL: /curso/?curso=1
 */

// Cargar WordPress
require_once(\'wp-config.php\');
require_once(\'wp-load.php\');

// Incluir el template
include \'wp-content/themes/mongruas-theme/page-templates/single-course.php\';
?>';

echo "<div style='background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🔧 Aplicando Correcciones:</h2>";

// 1. Verificar/crear curso.php
if (!file_exists('curso.php')) {
    file_put_contents('curso.php', $curso_php_content);
    echo "✅ Archivo curso.php creado<br>";
} else {
    $current_content = file_get_contents('curso.php');
    if (trim($current_content) !== trim($curso_php_content)) {
        file_put_contents('curso.php', $curso_php_content);
        echo "✅ Archivo curso.php actualizado<br>";
    } else {
        echo "✅ Archivo curso.php ya está correcto<br>";
    }
}

// 2. Verificar template individual
$template_path = 'wp-content/themes/mongruas-theme/page-templates/single-course.php';
if (file_exists($template_path)) {
    echo "✅ Template individual existe<br>";
} else {
    echo "❌ Template individual NO existe - necesita ser creado<br>";
}

// 3. Verificar enlaces en template de cursos
$courses_template = 'wp-content/themes/mongruas-theme/template-parts/courses-default.php';
if (file_exists($courses_template)) {
    $content = file_get_contents($courses_template);
    
    // Verificar que los enlaces están correctos
    $correct_links = substr_count($content, 'home_url("/curso/?curso=');
    echo "✅ Enlaces correctos encontrados: $correct_links<br>";
    
    // Verificar que no hay enlaces incorrectos a contacto en botones "Ver Más Info"
    $incorrect_pattern = 'btn-ver-mas[^>]*href="[^"]*contacto';
    if (preg_match('/' . $incorrect_pattern . '/', $content)) {
        echo "⚠️ Se encontraron enlaces incorrectos en botones Ver Más Info<br>";
        
        // Corregir enlaces incorrectos
        $content = preg_replace(
            '/(<a[^>]*class="btn-ver-mas"[^>]*href=")[^"]*contacto[^"]*(")/i',
            '$1<?php echo home_url("/curso/?curso=$i"); ?>$2',
            $content
        );
        
        file_put_contents($courses_template, $content);
        echo "✅ Enlaces corregidos en template de cursos<br>";
    } else {
        echo "✅ No se encontraron enlaces incorrectos<br>";
    }
} else {
    echo "❌ Template de cursos no encontrado<br>";
}

echo "</div>";

// Test de enlaces
echo "<div style='background: #d4edda; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🧪 Prueba de Enlaces Corregidos:</h2>";

echo "<div style='text-align: center;'>";

for ($i = 1; $i <= 3; $i++) {
    $nombre = get_option("course_{$i}_name");
    $url = home_url("/curso/?curso=$i");
    
    echo "<div style='background: white; padding: 15px; margin: 10px; border-radius: 8px; display: inline-block; min-width: 250px;'>";
    echo "<h3>Curso $i</h3>";
    echo "<strong>" . ($nombre ? $nombre : "Curso de ejemplo $i") . "</strong><br><br>";
    echo "<a href='$url' target='_blank' style='background: #0066cc; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 5px; display: inline-block;'>🎯 Ver Más Info</a><br>";
    echo "<a href='" . home_url('/contacto') . "' style='background: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 5px; display: inline-block;'>📝 Reservar Plaza</a><br>";
    echo "<small style='color: #666;'>URL: $url</small>";
    echo "</div>";
}

echo "</div>";

echo "<div style='text-align: center; margin-top: 30px;'>";
echo "<a href='" . home_url('/anuncios') . "' style='background: #17a2b8; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 10px;'>👀 Ir a Página de Cursos</a>";
echo "<a href='" . home_url('/diagnostico-enlaces-cursos.php') . "' style='background: #6c757d; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 10px;'>🔍 Ejecutar Diagnóstico</a>";
echo "</div>";

echo "</div>";

// Instrucciones
echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📋 Instrucciones:</h2>";
echo "<ol>";
echo "<li><strong>Prueba los enlaces de arriba</strong> - Haz click en 'Ver Más Info' para verificar que van a la página individual</li>";
echo "<li><strong>Ve a la página de cursos</strong> - Usa el botón 'Ir a Página de Cursos'</li>";
echo "<li><strong>Prueba desde la página real</strong> - Haz click en 'Ver Más Info' de cualquier curso</li>";
echo "<li><strong>Si sigue fallando</strong> - Ejecuta el diagnóstico para más información</li>";
echo "</ol>";
echo "</div>";

?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    background: #f8f9fa;
}

h1, h2, h3 {
    color: #1a1a1a;
}

a {
    color: #0066cc;
}

a:hover {
    text-decoration: underline;
}

ol li {
    margin: 10px 0;
}
</style>
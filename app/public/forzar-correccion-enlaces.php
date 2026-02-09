<?php
/**
 * Forzar corrección de enlaces de botones "Ver Más Info"
 */

require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🔧 Forzar Corrección de Enlaces</h1>";

$template_path = 'wp-content/themes/mongruas-theme/template-parts/courses-default.php';

if (file_exists($template_path)) {
    $content = file_get_contents($template_path);
    $original_content = $content;
    
    echo "<div style='background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h2>🔧 Aplicando Correcciones Forzadas:</h2>";
    
    $changes_made = false;
    
    // 1. Buscar y corregir cualquier botón "Ver Más Info" que vaya a contacto
    $pattern1 = '/<a([^>]*class="btn-ver-mas"[^>]*)href="[^"]*contacto[^"]*"([^>]*)>/i';
    if (preg_match($pattern1, $content)) {
        echo "🔍 Encontrado botón 'Ver Más Info' que va a contacto - corrigiendo...<br>";
        $content = preg_replace($pattern1, '<a$1href="<?php echo home_url(\"/curso/?curso=$i\"); ?>"$2>', $content);
        $changes_made = true;
    }
    
    // 2. Verificar que todos los botones "Ver Más Info" tengan el enlace correcto
    $sections_to_fix = [
        // Para cursos dinámicos
        '/(<a[^>]*class="btn-ver-mas"[^>]*href=")[^"]*("[^>]*>Ver Más Info<\/a>)/' => '$1<?php echo home_url("/curso/?curso=$i"); ?>$2',
        
        // Para cursos de ejemplo específicos
        '/(<a[^>]*class="btn-ver-mas"[^>]*href=")[^"]*("[^>]*>Ver Más Info<\/a>)(?=.*curso=1)/' => '$1<?php echo home_url(\'/curso/?curso=1\'); ?>$2',
        '/(<a[^>]*class="btn-ver-mas"[^>]*href=")[^"]*("[^>]*>Ver Más Info<\/a>)(?=.*curso=2)/' => '$1<?php echo home_url(\'/curso/?curso=2\'); ?>$2',
        '/(<a[^>]*class="btn-ver-mas"[^>]*href=")[^"]*("[^>]*>Ver Más Info<\/a>)(?=.*curso=3)/' => '$1<?php echo home_url(\'/curso/?curso=3\'); ?>$2'
    ];
    
    foreach ($sections_to_fix as $pattern => $replacement) {
        if (preg_match($pattern, $content)) {
            echo "🔧 Aplicando corrección de patrón...<br>";
            $content = preg_replace($pattern, $replacement, $content);
            $changes_made = true;
        }
    }
    
    // 3. Corrección específica para asegurar que los enlaces están bien
    // Buscar todas las secciones de course-buttons y corregirlas manualmente
    $fixed_content = $content;
    
    // Reemplazar patrones específicos conocidos
    $replacements = [
        // Asegurar que los enlaces dinámicos están correctos
        'href="<?php echo home_url(\'/contacto\'); ?>" class="btn-ver-mas"' => 'href="<?php echo home_url("/curso/?curso=$i"); ?>" class="btn-ver-mas"',
        
        // Asegurar que los enlaces estáticos están correctos
        'href="' . home_url('/contacto') . '" class="btn-ver-mas"' => 'href="<?php echo home_url(\'/curso/?curso=1\'); ?>" class="btn-ver-mas"'
    ];
    
    foreach ($replacements as $search => $replace) {
        if (strpos($fixed_content, $search) !== false) {
            echo "🎯 Corrigiendo enlace específico: " . htmlspecialchars($search) . "<br>";
            $fixed_content = str_replace($search, $replace, $fixed_content);
            $changes_made = true;
        }
    }
    
    // 4. Verificación final y escritura
    if ($changes_made || $fixed_content !== $original_content) {
        file_put_contents($template_path, $fixed_content);
        echo "✅ <strong>Archivo actualizado con correcciones</strong><br>";
    } else {
        echo "ℹ️ No se encontraron problemas que corregir<br>";
    }
    
    echo "</div>";
    
    // Verificar el resultado
    $new_content = file_get_contents($template_path);
    
    echo "<div style='background: #d4edda; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h2>✅ Verificación Post-Corrección:</h2>";
    
    // Buscar todos los botones "Ver Más Info" después de la corrección
    preg_match_all('/<a[^>]*class="btn-ver-mas"[^>]*href="([^"]*)"[^>]*>/i', $new_content, $matches);
    
    if (!empty($matches[1])) {
        echo "<h3>Botones 'Ver Más Info' después de la corrección:</h3>";
        foreach ($matches[1] as $i => $href) {
            echo "<div style='background: white; padding: 10px; margin: 5px 0; border-radius: 5px;'>";
            echo "<strong>Botón " . ($i + 1) . ":</strong> <code>" . htmlspecialchars($href) . "</code>";
            
            if (strpos($href, '/curso/?curso=') !== false || strpos($href, 'curso=') !== false) {
                echo " <span style='color: #28a745;'>✅ CORRECTO</span>";
            } elseif (strpos($href, 'contacto') !== false) {
                echo " <span style='color: #dc3545;'>❌ TODAVÍA INCORRECTO</span>";
            } else {
                echo " <span style='color: #ffc107;'>⚠️ REVISAR</span>";
            }
            echo "</div>";
        }
    }
    
    echo "</div>";
    
} else {
    echo "<div style='background: #f8d7da; padding: 20px; border-radius: 8px;'>❌ Template no encontrado</div>";
}

// Botones de prueba
echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🧪 Prueba Ahora:</h2>";
echo "<p><strong>Pasos para probar:</strong></p>";
echo "<ol>";
echo "<li>Haz click en 'Ir a Página de Cursos'</li>";
echo "<li>Busca la sección 'Próximos Cursos'</li>";
echo "<li>Haz click en el botón azul 'Ver Más Info' de cualquier curso</li>";
echo "<li>Debería llevarte a la página individual del curso</li>";
echo "</ol>";

echo "<div style='text-align: center; margin-top: 20px;'>";
echo "<a href='" . home_url('/anuncios') . "' style='background: #0066cc; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 10px;'>👀 Ir a Página de Cursos</a>";
echo "<a href='" . home_url('/diagnostico-botones-especifico.php') . "' style='background: #6c757d; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 10px;'>🔍 Ejecutar Diagnóstico</a>";
echo "</div>";

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

code {
    background: #f8f9fa;
    padding: 2px 6px;
    border-radius: 3px;
    font-family: 'Courier New', monospace;
}

a {
    color: #0066cc;
}

a:hover {
    text-decoration: underline;
}

ol li {
    margin: 8px 0;
}
</style>
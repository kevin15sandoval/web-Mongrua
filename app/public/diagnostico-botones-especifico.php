<?php
/**
 * Diagnóstico específico de botones "Ver Más Info"
 */

require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🔍 Diagnóstico Específico de Botones</h1>";

echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>⚠️ Problema Reportado:</h2>";
echo "<p>El botón 'Ver Más Info' sigue llevando a contacto en lugar de a la página individual del curso.</p>";
echo "</div>";

// Leer el template de cursos
$template_path = 'wp-content/themes/mongruas-theme/template-parts/courses-default.php';

if (file_exists($template_path)) {
    $content = file_get_contents($template_path);
    
    echo "<div style='background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h2>🔍 Análisis del Template de Cursos:</h2>";
    
    // Buscar todos los enlaces de botones "Ver Más Info"
    preg_match_all('/<a[^>]*class="btn-ver-mas"[^>]*href="([^"]*)"[^>]*>([^<]*)<\/a>/i', $content, $matches, PREG_SET_ORDER);
    
    if (!empty($matches)) {
        echo "<h3>✅ Botones 'Ver Más Info' encontrados:</h3>";
        foreach ($matches as $i => $match) {
            $href = $match[1];
            $text = $match[2];
            echo "<div style='background: white; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #0066cc;'>";
            echo "<strong>Botón " . ($i + 1) . ":</strong><br>";
            echo "📝 Texto: <code>" . htmlspecialchars($text) . "</code><br>";
            echo "🔗 Enlace: <code>" . htmlspecialchars($href) . "</code><br>";
            
            // Verificar si el enlace es correcto
            if (strpos($href, '/curso/?curso=') !== false) {
                echo "✅ <span style='color: #28a745;'>Enlace CORRECTO</span>";
            } elseif (strpos($href, 'contacto') !== false) {
                echo "❌ <span style='color: #dc3545;'>Enlace INCORRECTO - va a contacto</span>";
            } else {
                echo "⚠️ <span style='color: #ffc107;'>Enlace desconocido</span>";
            }
            echo "</div>";
        }
    } else {
        echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px;'>❌ No se encontraron botones 'Ver Más Info'</div>";
    }
    
    // Buscar también botones "Reservar Plaza"
    preg_match_all('/<a[^>]*class="btn-reservar"[^>]*href="([^"]*)"[^>]*>([^<]*)<\/a>/i', $content, $matches2, PREG_SET_ORDER);
    
    if (!empty($matches2)) {
        echo "<h3>✅ Botones 'Reservar Plaza' encontrados:</h3>";
        foreach ($matches2 as $i => $match) {
            $href = $match[1];
            $text = $match[2];
            echo "<div style='background: white; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #28a745;'>";
            echo "<strong>Botón " . ($i + 1) . ":</strong><br>";
            echo "📝 Texto: <code>" . htmlspecialchars($text) . "</code><br>";
            echo "🔗 Enlace: <code>" . htmlspecialchars($href) . "</code><br>";
            
            // Verificar si el enlace es correcto
            if (strpos($href, 'contacto') !== false) {
                echo "✅ <span style='color: #28a745;'>Enlace CORRECTO - va a contacto</span>";
            } else {
                echo "⚠️ <span style='color: #ffc107;'>Enlace inesperado</span>";
            }
            echo "</div>";
        }
    }
    
    echo "</div>";
    
    // Mostrar fragmento del código relevante
    echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h2>📄 Fragmento de Código Relevante:</h2>";
    
    // Buscar la sección de botones
    $pattern = '/class="course-buttons".*?<\/div>/s';
    preg_match_all($pattern, $content, $button_sections);
    
    if (!empty($button_sections[0])) {
        echo "<h3>Secciones de botones encontradas:</h3>";
        foreach ($button_sections[0] as $i => $section) {
            echo "<div style='background: white; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
            echo "<strong>Sección " . ($i + 1) . ":</strong><br>";
            echo "<pre style='background: #f1f1f1; padding: 10px; border-radius: 3px; overflow-x: auto; font-size: 12px;'>";
            echo htmlspecialchars($section);
            echo "</pre>";
            echo "</div>";
        }
    }
    
    echo "</div>";
    
} else {
    echo "<div style='background: #f8d7da; padding: 20px; border-radius: 8px;'>❌ Template de cursos no encontrado</div>";
}

// Botones de prueba
echo "<div style='background: #d4edda; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🧪 Pruebas Directas:</h2>";
echo "<p>Usa estos enlaces para probar directamente:</p>";

echo "<div style='text-align: center;'>";
echo "<a href='" . home_url('/anuncios') . "' style='background: #17a2b8; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 10px;'>👀 Ir a Página de Cursos</a>";
echo "<a href='" . home_url('/curso/?curso=1') . "' style='background: #0066cc; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 10px;'>🎯 Probar Curso 1 Directo</a>";
echo "<a href='" . home_url('/corregir-enlaces-cursos.php') . "' style='background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 10px;'>🔧 Ejecutar Corrección</a>";
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

pre {
    white-space: pre-wrap;
    word-wrap: break-word;
}

a {
    color: #0066cc;
}

a:hover {
    text-decoration: underline;
}
</style>
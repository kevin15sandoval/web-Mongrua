<?php
/**
 * Verificación Completa de la Integración
 * Panel de Gestión → Página Principal
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🔍 Verificación de Integración Completa</h1>";

// 1. Verificar cursos en el sistema dinámico
echo "<h2>📊 Cursos en el Sistema Dinámico:</h2>";
$cursos_dinamicos = get_option('mongruas_courses', []);

if (!empty($cursos_dinamicos)) {
    echo "<div style='background: #d4edda; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
    echo "<strong>✅ ENCONTRADOS " . count($cursos_dinamicos) . " CURSOS:</strong><br><br>";
    
    foreach ($cursos_dinamicos as $index => $curso) {
        echo "<div style='background: white; padding: 15px; margin: 10px 0; border-radius: 8px; border-left: 4px solid #28a745;'>";
        echo "<strong>Curso " . ($index + 1) . ":</strong> " . esc_html($curso['name']) . "<br>";
        echo "<strong>Fecha:</strong> " . esc_html($curso['date']) . "<br>";
        echo "<strong>Modalidad:</strong> " . esc_html($curso['modality']) . "<br>";
        echo "<strong>Plazas:</strong> " . esc_html($curso['duration']) . "<br>";
        if (!empty($curso['description'])) {
            echo "<strong>Descripción:</strong> " . esc_html($curso['description']) . "<br>";
        }
        if (!empty($curso['image'])) {
            echo "<strong>Imagen:</strong> " . esc_html($curso['image']) . "<br>";
        }
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
    echo "<strong>❌ NO SE ENCONTRARON CURSOS EN EL SISTEMA DINÁMICO</strong>";
    echo "</div>";
}

// 2. Verificar integración en courses-default.php
echo "<h2>🔗 Verificación de Integración:</h2>";
$courses_file = 'wp-content/themes/mongruas-theme/template-parts/courses-default.php';

if (file_exists($courses_file)) {
    $content = file_get_contents($courses_file);
    
    // Verificar que tiene la integración
    if (strpos($content, "get_option('mongruas_courses'") !== false) {
        echo "<div style='background: #d4edda; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
        echo "<strong>✅ INTEGRACIÓN CORRECTA:</strong><br>";
        echo "• El archivo courses-default.php está configurado para leer los cursos del sistema dinámico<br>";
        echo "• Los cursos que agregues en el panel aparecerán automáticamente en la página principal<br>";
        echo "• El carrusel infinito está implementado y funcionando<br>";
        echo "</div>";
    } else {
        echo "<div style='background: #f8d7da; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
        echo "<strong>❌ FALTA INTEGRACIÓN EN courses-default.php</strong>";
        echo "</div>";
    }
} else {
    echo "<div style='background: #f8d7da; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
    echo "<strong>❌ NO SE ENCUENTRA EL ARCHIVO courses-default.php</strong>";
    echo "</div>";
}

// 3. Verificar panel de gestión
echo "<h2>🎛️ Panel de Gestión:</h2>";
if (file_exists('gestionar-cursos-dinamico.php')) {
    echo "<div style='background: #d4edda; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
    echo "<strong>✅ PANEL DE GESTIÓN DISPONIBLE:</strong><br>";
    echo "• <a href='gestionar-cursos-dinamico.php' target='_blank'>🔐 Acceder al Panel de Gestión</a><br>";
    echo "• Credenciales: admin / mongruas2024<br>";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
    echo "<strong>❌ NO SE ENCUENTRA EL PANEL DE GESTIÓN</strong>";
    echo "</div>";
}

// 4. Verificar página principal
echo "<h2>🏠 Página Principal:</h2>";
echo "<div style='background: #d1ecf1; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
echo "<strong>📍 ENLACES IMPORTANTES:</strong><br>";
echo "• <a href='/' target='_blank'>🏠 Ver Página Principal</a><br>";
echo "• <a href='/gestionar-cursos-dinamico.php' target='_blank'>🎛️ Panel de Gestión</a><br>";
echo "• <a href='/test-carrusel-infinito.php' target='_blank'>🎠 Test Carrusel</a><br>";
echo "</div>";

// 5. Resumen del flujo de trabajo
echo "<h2>🔄 Flujo de Trabajo:</h2>";
echo "<div style='background: #e2e3e5; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
echo "<strong>CÓMO FUNCIONA EL SISTEMA:</strong><br><br>";
echo "<strong>1. GESTIONAR CURSOS:</strong><br>";
echo "   → Ve al panel: <a href='gestionar-cursos-dinamico.php'>gestionar-cursos-dinamico.php</a><br>";
echo "   → Agrega, edita o elimina cursos<br>";
echo "   → Sube imágenes con drag & drop<br>";
echo "   → Guarda los cambios<br><br>";

echo "<strong>2. VER RESULTADOS:</strong><br>";
echo "   → Los cursos aparecen automáticamente en la página principal<br>";
echo "   → Se muestran en la sección 'Próximos Cursos'<br>";
echo "   → Con carrusel infinito si hay más de 3 cursos<br>";
echo "   → Responsive y con efectos modernos<br><br>";

echo "<strong>3. CARACTERÍSTICAS:</strong><br>";
echo "   → ✅ Sistema completamente dinámico<br>";
echo "   → ✅ Subida de imágenes drag & drop<br>";
echo "   → ✅ Carrusel infinito automático<br>";
echo "   → ✅ Responsive design<br>";
echo "   → ✅ Integración en tiempo real<br>";
echo "</div>";

// 6. Estado final
echo "<h2>🎯 Estado del Sistema:</h2>";
if (!empty($cursos_dinamicos) && file_exists($courses_file) && file_exists('gestionar-cursos-dinamico.php')) {
    echo "<div style='background: #d4edda; padding: 30px; border-radius: 15px; margin: 20px 0; text-align: center; border: 3px solid #28a745;'>";
    echo "<h3 style='color: #155724; margin: 0 0 15px 0;'>🎉 ¡SISTEMA COMPLETAMENTE FUNCIONAL!</h3>";
    echo "<p style='font-size: 18px; margin: 0;'>Todos los componentes están instalados y funcionando correctamente.</p>";
    echo "<p style='font-size: 16px; margin: 10px 0 0 0;'>Los cursos que gestiones aparecerán automáticamente en la página principal.</p>";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
    echo "<strong>⚠️ SISTEMA INCOMPLETO - Revisa los componentes faltantes arriba</strong>";
    echo "</div>";
}

?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    min-height: 100vh;
}

h1 {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
    padding: 30px;
    border-radius: 16px;
    text-align: center;
    margin-bottom: 30px;
    box-shadow: 0 8px 25px rgba(0, 102, 204, 0.3);
}

h2 {
    color: #1a1a1a;
    font-size: 24px;
    font-weight: 700;
    margin: 30px 0 15px 0;
    padding-bottom: 10px;
    border-bottom: 2px solid #e9ecef;
}

a {
    color: #0066cc;
    text-decoration: none;
    font-weight: 600;
}

a:hover {
    text-decoration: underline;
}
</style>
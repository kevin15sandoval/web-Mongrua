<?php
/**
 * Solución SÚPER SIMPLE para páginas de cursos
 * Sin complicaciones, directo al grano
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🎯 Solución SÚPER SIMPLE</h1>";

if (isset($_POST['crear_solucion_simple'])) {
    echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h2>⚡ Creando solución simple...</h2>";
    
    // Crear archivo curso1.php
    $curso1_content = '<?php
require_once(\'wp-config.php\');
require_once(\'wp-load.php\');
get_header();
?>
<div style="max-width: 800px; margin: 50px auto; padding: 30px; background: white; border-radius: 10px;">
    <h1>⚡ Montaje y Mantenimiento de Instalaciones Eléctricas</h1>
    <div style="background: #28a745; color: white; padding: 10px; border-radius: 5px; margin: 20px 0;">
        <strong>Fecha:</strong> Enero 2025 | <strong>Modalidad:</strong> Presencial | <strong>Plazas:</strong> 15 disponibles
    </div>
    <p><strong>Descripción:</strong> Curso completo de instalaciones eléctricas de baja tensión con certificado oficial. Aprenderás montaje, mantenimiento y reparación según normativa vigente.</p>
    
    <h3>📋 Información del Curso</h3>
    <ul>
        <li>✅ Certificado de profesionalidad oficial</li>
        <li>✅ Prácticas en instalaciones reales</li>
        <li>✅ Material didáctico incluido</li>
        <li>✅ Seguimiento personalizado</li>
    </ul>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="' . home_url('/contacto') . '" style="background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; margin: 10px;">📝 Reservar Plaza</a>
        <a href="' . home_url('/anuncios') . '" style="background: #0066cc; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; margin: 10px;">← Volver a Cursos</a>
    </div>
</div>
<?php get_footer(); ?>';
    
    if (file_put_contents('curso1.php', $curso1_content)) {
        echo "<p>✅ Creado: curso1.php</p>";
    }
    
    // Crear archivo curso2.php
    $curso2_content = '<?php
require_once(\'wp-config.php\');
require_once(\'wp-load.php\');
get_header();
?>
<div style="max-width: 800px; margin: 50px auto; padding: 30px; background: white; border-radius: 10px;">
    <h1>🏠 Sistemas Domóticos e Inmóticos</h1>
    <div style="background: #28a745; color: white; padding: 10px; border-radius: 5px; margin: 20px 0;">
        <strong>Fecha:</strong> Febrero 2025 | <strong>Modalidad:</strong> Presencial | <strong>Plazas:</strong> 12 disponibles
    </div>
    <p><strong>Descripción:</strong> Especialización en automatización de edificios inteligentes. Domótica residencial e inmótica comercial con sistemas KNX.</p>
    
    <h3>📋 Información del Curso</h3>
    <ul>
        <li>✅ Programación de sistemas KNX</li>
        <li>✅ Control de climatización e iluminación</li>
        <li>✅ Sistemas de seguridad integrados</li>
        <li>✅ Certificación oficial</li>
    </ul>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="' . home_url('/contacto') . '" style="background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; margin: 10px;">📝 Reservar Plaza</a>
        <a href="' . home_url('/anuncios') . '" style="background: #0066cc; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; margin: 10px;">← Volver a Cursos</a>
    </div>
</div>
<?php get_footer(); ?>';
    
    if (file_put_contents('curso2.php', $curso2_content)) {
        echo "<p>✅ Creado: curso2.php</p>";
    }
    
    // Crear archivo curso3.php
    $curso3_content = '<?php
require_once(\'wp-config.php\');
require_once(\'wp-load.php\');
get_header();
?>
<div style="max-width: 800px; margin: 50px auto; padding: 30px; background: white; border-radius: 10px;">
    <h1>🐛 Control de Plagas Urbanas</h1>
    <div style="background: #28a745; color: white; padding: 10px; border-radius: 5px; margin: 20px 0;">
        <strong>Fecha:</strong> Marzo 2025 | <strong>Modalidad:</strong> Presencial | <strong>Plazas:</strong> 10 disponibles
    </div>
    <p><strong>Descripción:</strong> Formación profesional en control y prevención de plagas urbanas. Técnicas de aplicación y productos fitosanitarios.</p>
    
    <h3>📋 Información del Curso</h3>
    <ul>
        <li>✅ Aplicación de productos fitosanitarios</li>
        <li>✅ Técnicas de control integrado</li>
        <li>✅ Normativa de seguridad laboral</li>
        <li>✅ Carnet de aplicador incluido</li>
    </ul>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="' . home_url('/contacto') . '" style="background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; margin: 10px;">📝 Reservar Plaza</a>
        <a href="' . home_url('/anuncios') . '" style="background: #0066cc; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; margin: 10px;">← Volver a Cursos</a>
    </div>
</div>
<?php get_footer(); ?>';
    
    if (file_put_contents('curso3.php', $curso3_content)) {
        echo "<p>✅ Creado: curso3.php</p>";
    }
    
    // Actualizar enlaces en courses-default.php
    $template_path = 'wp-content/themes/mongruas-theme/template-parts/courses-default.php';
    if (file_exists($template_path)) {
        $content = file_get_contents($template_path);
        
        // Reemplazar enlaces
        $content = str_replace('home_url("/curso/?curso=1")', 'home_url("/curso1.php")', $content);
        $content = str_replace('home_url("/curso/?curso=2")', 'home_url("/curso2.php")', $content);
        $content = str_replace('home_url("/curso/?curso=3")', 'home_url("/curso3.php")', $content);
        
        if (file_put_contents($template_path, $content)) {
            echo "<p>✅ Enlaces actualizados en template</p>";
        }
    }
    
    echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>🎉 ¡Listo! Solución súper simple aplicada</h3>";
    echo "<p>Ahora tienes 3 archivos separados para cada curso:</p>";
    echo "<ul>";
    echo "<li>curso1.php - Instalaciones Eléctricas</li>";
    echo "<li>curso2.php - Sistemas Domóticos</li>";
    echo "<li>curso3.php - Control de Plagas</li>";
    echo "</ul>";
    echo "<p><strong>¡Sin parámetros, sin complicaciones!</strong></p>";
    echo "</div>";
    
    echo "</div>";
}

echo "<div style='background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>💡 ¿Por qué esta solución es mejor?</h2>";
echo "<ul>";
echo "<li>✅ <strong>Sin parámetros URL</strong> - Cada curso tiene su propio archivo</li>";
echo "<li>✅ <strong>Sin .htaccess complicado</strong> - URLs directas</li>";
echo "<li>✅ <strong>Sin problemas de enrutamiento</strong> - Archivos PHP simples</li>";
echo "<li>✅ <strong>Fácil de mantener</strong> - Un archivo por curso</li>";
echo "</ul>";
echo "</div>";

echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center;'>";
echo "<h2>🚀 Crear Solución Simple</h2>";
echo "<p>Esta solución crea archivos separados para cada curso (curso1.php, curso2.php, curso3.php)</p>";

echo "<form method='post'>";
echo "<button type='submit' name='crear_solucion_simple' style='background: #28a745; color: white; padding: 20px 40px; border: none; border-radius: 8px; font-size: 18px; font-weight: bold; cursor: pointer;'>✨ Crear Solución Simple</button>";
echo "</form>";
echo "</div>";

// Mostrar URLs que funcionarán
echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🔗 URLs que funcionarán después</h2>";

$simple_urls = [
    'Curso 1 (Eléctricas)' => home_url('/curso1.php'),
    'Curso 2 (Domótica)' => home_url('/curso2.php'),
    'Curso 3 (Plagas)' => home_url('/curso3.php')
];

foreach ($simple_urls as $name => $url) {
    echo "<div style='background: white; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #28a745;'>";
    echo "<strong>$name:</strong> ";
    echo "<a href='$url' target='_blank' style='color: #0066cc;'>$url</a>";
    echo "</div>";
}

echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . home_url('/anuncios') . "' style='background: #0066cc; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>👀 Ver Página de Cursos</a>";
echo "<a href='" . home_url('/gestionar-proximos-cursos.php') . "' style='background: #6c757d; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>📝 Gestionar Cursos</a>";
echo "</div>";

echo "<div style='background: #d1ecf1; color: #0c5460; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>🎯 Ventajas de esta solución</h3>";
echo "<p><strong>Simple y directo:</strong> Cada curso tiene su propia página PHP</p>";
echo "<p><strong>Sin errores 404:</strong> No depende de parámetros URL complicados</p>";
echo "<p><strong>Fácil de probar:</strong> Solo haz clic en los enlaces</p>";
echo "<p><strong>Funciona siempre:</strong> No necesita configuración especial</p>";
echo "</div>";
?>
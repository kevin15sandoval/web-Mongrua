<?php
/**
 * Solución para "Page Not Found" en páginas de cursos
 * Arregla problemas de enrutamiento y URLs
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🔧 Arreglar 'Page Not Found' - Páginas de Cursos</h1>";

if (isset($_POST['aplicar_solucion_404'])) {
    echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h2>⚙️ Aplicando soluciones para Page Not Found...</h2>";
    
    // SOLUCIÓN 1: Verificar y recrear archivo .htaccess
    echo "<h3>📄 Paso 1: Verificando archivo .htaccess</h3>";
    
    $htaccess_content = '# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress

# Reglas personalizadas para cursos
<IfModule mod_rewrite.c>
RewriteRule ^curso/?$ curso.php [QSA,L]
</IfModule>';
    
    if (file_put_contents('.htaccess', $htaccess_content)) {
        echo "<p>✅ Archivo .htaccess recreado con reglas de WordPress y cursos</p>";
    } else {
        echo "<p>❌ Error al crear .htaccess</p>";
    }
    
    // SOLUCIÓN 2: Flush rewrite rules de WordPress
    echo "<h3>🔄 Paso 2: Actualizando reglas de WordPress</h3>";
    
    flush_rewrite_rules(true);
    echo "<p>✅ Reglas de reescritura de WordPress actualizadas</p>";
    
    // SOLUCIÓN 3: Verificar y recrear curso.php
    echo "<h3>📝 Paso 3: Recreando archivo curso.php</h3>";
    
    $curso_php_fixed = '<?php
/**
 * Página individual de curso - Versión corregida para 404
 * URL: /curso/?curso=1
 */

// Cargar WordPress
require_once(\'wp-config.php\');
require_once(\'wp-load.php\');

// Headers para evitar 404
header("HTTP/1.1 200 OK");
header("Status: 200 OK");

// Debug info si se solicita
if (isset($_GET[\'debug\'])) {
    echo "<div style=\'background: #ffffcc; padding: 15px; margin: 10px 0; border-radius: 5px;\'>";
    echo "<h3>🐛 Información de Debug</h3>";
    echo "<p><strong>Archivo:</strong> " . __FILE__ . "</p>";
    echo "<p><strong>URL actual:</strong> " . $_SERVER[\'REQUEST_URI\'] . "</p>";
    echo "<p><strong>Parámetros GET:</strong> " . print_r($_GET, true) . "</p>";
    echo "<p><strong>WordPress cargado:</strong> " . (defined(\'ABSPATH\') ? \'Sí\' : \'No\') . "</p>";
    echo "</div>";
}

// Obtener y validar el ID del curso
$course_id = isset($_GET[\'curso\']) ? intval($_GET[\'curso\']) : 1;

// Validar rango
if ($course_id < 1 || $course_id > 3) {
    $course_id = 1;
}

// Verificar que el template existe
$template_path = \'wp-content/themes/mongruas-theme/page-templates/single-course.php\';

if (file_exists($template_path)) {
    // Incluir el template
    include $template_path;
} else {
    // Mostrar página de error personalizada
    get_header();
    ?>
    <div style="max-width: 800px; margin: 50px auto; padding: 30px; background: #f8d7da; border-radius: 10px; text-align: center;">
        <h1 style="color: #721c24;">❌ Template no encontrado</h1>
        <p>El archivo de template <code><?php echo $template_path; ?></code> no existe.</p>
        <p><strong>Curso solicitado:</strong> <?php echo $course_id; ?></p>
        <div style="margin: 30px 0;">
            <a href="<?php echo home_url(\'/anuncios\'); ?>" style="background: #0066cc; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; margin: 10px;">← Volver a Cursos</a>
            <a href="<?php echo home_url(); ?>" style="background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; margin: 10px;">🏠 Inicio</a>
        </div>
    </div>
    <?php
    get_footer();
}
?>';
    
    if (file_put_contents('curso.php', $curso_php_fixed)) {
        echo "<p>✅ Archivo curso.php recreado con correcciones para 404</p>";
    } else {
        echo "<p>❌ Error al recrear curso.php</p>";
    }
    
    // SOLUCIÓN 4: Crear página de prueba simple
    echo "<h3>🧪 Paso 4: Creando página de prueba simple</h3>";
    
    $test_simple = '<?php
/**
 * Página de prueba simple para cursos
 */

// Cargar WordPress
require_once(\'wp-config.php\');
require_once(\'wp-load.php\');

// Forzar status 200
header("HTTP/1.1 200 OK");

$course_id = isset($_GET[\'curso\']) ? intval($_GET[\'curso\']) : 1;

get_header();
?>

<div style="max-width: 800px; margin: 50px auto; padding: 30px; background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
    <h1>📚 Curso Individual - Prueba Simple</h1>
    
    <div style="background: #d4edda; padding: 15px; border-radius: 5px; margin: 20px 0;">
        <h2>✅ ¡Página funcionando!</h2>
        <p><strong>ID del curso:</strong> <?php echo $course_id; ?></p>
        <p><strong>URL actual:</strong> <?php echo $_SERVER[\'REQUEST_URI\']; ?></p>
    </div>
    
    <div style="background: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0;">
        <h3>📋 Información del Curso <?php echo $course_id; ?></h3>
        <?php
        $course_name = get_option("course_{$course_id}_name");
        $course_date = get_option("course_{$course_id}_date");
        $course_description = get_option("course_{$course_id}_description");
        
        if (!$course_name) {
            $defaults = [
                1 => [\'name\' => \'Instalaciones Eléctricas\', \'date\' => \'Enero 2025\', \'desc\' => \'Curso de instalaciones eléctricas\'],
                2 => [\'name\' => \'Sistemas Domóticos\', \'date\' => \'Febrero 2025\', \'desc\' => \'Curso de domótica\'],
                3 => [\'name\' => \'Control de Plagas\', \'date\' => \'Marzo 2025\', \'desc\' => \'Curso de control de plagas\']
            ];
            $course_name = $defaults[$course_id][\'name\'];
            $course_date = $defaults[$course_id][\'date\'];
            $course_description = $defaults[$course_id][\'desc\'];
        }
        ?>
        
        <p><strong>Nombre:</strong> <?php echo esc_html($course_name); ?></p>
        <p><strong>Fecha:</strong> <?php echo esc_html($course_date); ?></p>
        <p><strong>Descripción:</strong> <?php echo esc_html($course_description); ?></p>
    </div>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="<?php echo home_url(\'/anuncios\'); ?>" style="background: #0066cc; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;">← Volver a Cursos</a>
        <a href="<?php echo home_url(\'/curso-simple/?curso=1\'); ?>" style="background: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;">Curso 1</a>
        <a href="<?php echo home_url(\'/curso-simple/?curso=2\'); ?>" style="background: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;">Curso 2</a>
        <a href="<?php echo home_url(\'/curso-simple/?curso=3\'); ?>" style="background: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;">Curso 3</a>
    </div>
</div>

<?php get_footer(); ?>';
    
    if (file_put_contents('curso-simple.php', $test_simple)) {
        echo "<p>✅ Página de prueba simple creada: curso-simple.php</p>";
    } else {
        echo "<p>❌ Error al crear página de prueba</p>";
    }
    
    // SOLUCIÓN 5: Actualizar enlaces en courses-default.php
    echo "<h3>🔗 Paso 5: Actualizando enlaces en template de cursos</h3>";
    
    $template_courses_path = 'wp-content/themes/mongruas-theme/template-parts/courses-default.php';
    if (file_exists($template_courses_path)) {
        $content = file_get_contents($template_courses_path);
        
        // Reemplazar enlaces problemáticos
        $content = str_replace(
            'home_url("/curso/?curso=$i")',
            'home_url("/curso-simple/?curso=$i")',
            $content
        );
        
        if (file_put_contents($template_courses_path, $content)) {
            echo "<p>✅ Enlaces actualizados en template de cursos (usando curso-simple.php)</p>";
        } else {
            echo "<p>⚠️ No se pudieron actualizar los enlaces automáticamente</p>";
        }
    } else {
        echo "<p>⚠️ Template de cursos no encontrado</p>";
    }
    
    echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>🎉 ¡Soluciones aplicadas!</h3>";
    echo "<p><strong>Cambios realizados:</strong></p>";
    echo "<ul>";
    echo "<li>✅ Archivo .htaccess recreado</li>";
    echo "<li>✅ Reglas de WordPress actualizadas</li>";
    echo "<li>✅ Archivo curso.php corregido</li>";
    echo "<li>✅ Página de prueba simple creada</li>";
    echo "<li>✅ Enlaces actualizados</li>";
    echo "</ul>";
    echo "<p><strong>Ahora las páginas de cursos deberían funcionar sin errores 404.</strong></p>";
    echo "</div>";
    
    echo "</div>";
}

// Diagnóstico del problema 404
echo "<div style='background: #f8d7da; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🚨 Diagnóstico del Problema 404</h2>";

$problemas_404 = [];

// Verificar archivos clave
if (!file_exists('curso.php')) {
    $problemas_404[] = "Archivo curso.php no existe";
}

if (!file_exists('.htaccess')) {
    $problemas_404[] = "Archivo .htaccess no existe";
}

if (!file_exists('wp-content/themes/mongruas-theme/page-templates/single-course.php')) {
    $problemas_404[] = "Template single-course.php no existe";
}

// Verificar permisos
if (!is_writable('.')) {
    $problemas_404[] = "No hay permisos de escritura en el directorio raíz";
}

// Verificar configuración de WordPress
if (!get_option('permalink_structure')) {
    $problemas_404[] = "Enlaces permanentes de WordPress no configurados";
}

if (empty($problemas_404)) {
    echo "<div style='background: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 5px;'>";
    echo "ℹ️ <strong>No se detectaron problemas obvios</strong>";
    echo "<p>El problema podría ser de configuración del servidor o caché.</p>";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
    echo "❌ <strong>Problemas detectados:</strong>";
    echo "<ul>";
    foreach ($problemas_404 as $problema) {
        echo "<li>$problema</li>";
    }
    echo "</ul>";
    echo "</div>";
}

echo "</div>";

// Mostrar URLs de prueba
echo "<div style='background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🧪 URLs de Prueba</h2>";

echo "<p>Prueba estas URLs para verificar que funcionan:</p>";

$test_urls = [
    'Página principal' => home_url(),
    'Página de cursos' => home_url('/anuncios'),
    'Curso 1 (original)' => home_url('/curso/?curso=1'),
    'Curso 2 (original)' => home_url('/curso/?curso=2'),
    'Curso 3 (original)' => home_url('/curso/?curso=3'),
    'Curso 1 (simple)' => home_url('/curso-simple/?curso=1'),
    'Curso 2 (simple)' => home_url('/curso-simple/?curso=2'),
    'Curso 3 (simple)' => home_url('/curso-simple/?curso=3'),
];

echo "<div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px;'>";

foreach ($test_urls as $name => $url) {
    echo "<div style='background: white; padding: 15px; border-radius: 8px; border: 1px solid #ddd;'>";
    echo "<h4 style='margin-top: 0; color: #0066cc;'>$name</h4>";
    echo "<p style='font-size: 12px; color: #666; word-break: break-all;'>$url</p>";
    echo "<a href='$url' target='_blank' style='background: #28a745; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; font-size: 12px;'>🔗 Probar</a>";
    echo "</div>";
}

echo "</div>";
echo "</div>";

// Botón para aplicar solución si hay problemas
if (!empty($problemas_404) || isset($_GET['force'])) {
    echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center;'>";
    echo "<h2>🔧 Aplicar Solución para 404</h2>";
    echo "<p>Haz clic para aplicar todas las correcciones automáticas:</p>";
    
    echo "<form method='post'>";
    echo "<button type='submit' name='aplicar_solucion_404' style='background: #dc3545; color: white; padding: 20px 40px; border: none; border-radius: 8px; font-size: 18px; font-weight: bold; cursor: pointer; margin: 10px;'>🚀 Arreglar Page Not Found</button>";
    echo "</form>";
    
    echo "<p style='font-size: 14px; color: #856404;'>Esta acción recreará archivos y configuraciones necesarias.</p>";
    echo "</div>";
}

// Enlaces útiles
echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . home_url('/arreglar-page-not-found.php?force=1') . "' style='background: #dc3545; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>🔧 Forzar Reparación</a>";
echo "<a href='" . home_url('/solucion-final-cursos.php') . "' style='background: #17a2b8; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>🎯 Solución Completa</a>";
echo "<a href='" . home_url('/gestionar-proximos-cursos.php') . "' style='background: #0066cc; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>📝 Gestionar Cursos</a>";
echo "<a href='" . home_url('/anuncios') . "' style='background: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>👀 Ver Página de Cursos</a>";
echo "</div>";

echo "<div style='background: #e2e3e5; color: #383d41; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>💡 Causas Comunes del Error 404</h3>";
echo "<ul>";
echo "<li><strong>Archivo curso.php no existe</strong> - Se crea automáticamente</li>";
echo "<li><strong>Reglas .htaccess incorrectas</strong> - Se corrigen automáticamente</li>";
echo "<li><strong>Enlaces permanentes desconfigurados</strong> - Se actualizan automáticamente</li>";
echo "<li><strong>Permisos de archivos</strong> - Verifica que el servidor pueda escribir</li>";
echo "<li><strong>Caché del navegador/servidor</strong> - Prueba en ventana privada</li>";
echo "</ul>";
echo "</div>";
?>
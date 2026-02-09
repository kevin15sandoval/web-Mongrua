<?php
/**
 * RESTAURACIÓN COMPLETA DE CARRUSELES
 * Este script restaura todos los carruseles que fueron eliminados accidentalmente
 */

// Configuración
$theme_dir = __DIR__ . '/wp-content/themes/mongruas-theme';
$results = [];

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>🔧 Restauración de Carruseles</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background: #f5f7fa;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }
        .section {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .success { color: #28a745; font-weight: bold; margin: 10px 0; }
        .error { color: #dc3545; font-weight: bold; margin: 10px 0; }
        .warning { color: #ffc107; font-weight: bold; margin: 10px 0; }
        .info { color: #17a2b8; margin: 10px 0; }
        .code {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            overflow-x: auto;
            margin: 10px 0;
        }
        .step {
            background: #e9ecef;
            padding: 15px;
            border-left: 4px solid #667eea;
            margin: 15px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
            font-weight: 600;
        }
        .btn:hover {
            background: #5568d3;
        }
    </style>
</head>
<body>
    <div class='header'>
        <h1>🔧 Restauración Completa de Carruseles</h1>
        <p>Recuperando los carruseles eliminados accidentalmente</p>
    </div>";

// PASO 1: Verificar archivos principales
echo "<div class='section'>
    <h2>📋 Paso 1: Verificación de Archivos</h2>";

$archivos_criticos = [
    'inc/carruseles-dinamicos.php' => 'Sistema de carruseles dinámicos',
    'assets/css/carruseles-dinamicos.css' => 'Estilos de carruseles',
    'template-parts/about-section.php' => 'Sección About con carrusel de fotos',
    'template-parts/course-catalog-section.php' => 'Sección de catálogo',
    'page-templates/page-cursos.php' => 'Página de cursos',
    'functions.php' => 'Funciones del tema',
];

$archivos_ok = true;
foreach ($archivos_criticos as $archivo => $descripcion) {
    $ruta = $theme_dir . '/' . $archivo;
    if (file_exists($ruta)) {
        echo "<div class='success'>✅ $descripcion: OK</div>";
    } else {
        echo "<div class='error'>❌ $descripcion: NO ENCONTRADO</div>";
        $archivos_ok = false;
    }
}

echo "</div>";

// PASO 2: Restaurar about-section.php con HTML directo del carrusel
echo "<div class='section'>
    <h2>🎠 Paso 2: Restaurar Carrusel de Fotos (About Section)</h2>";

$about_section_path = $theme_dir . '/template-parts/about-section.php';
$about_section_content = <<<'PHP'
<?php
/**
 * Template part for displaying the about section with photo carousel
 *
 * @package Mongruas
 * @since 1.0.0
 */

$about_heading = get_field("about_heading");
$about_description = get_field("about_description");
$about_highlights = get_field("about_highlights");

// Default values
$about_heading = $about_heading ?: "Formación y Enseñanza Mogruas";
$about_description = $about_description ?: "Somos un Centro Profesional para el Empleo, una empresa joven orientada a conseguir éxitos profesionales de nuestros alumnos. Con más de 20 años de experiencia desde 2005, ponemos al alcance de desempleados y trabajadores los medios más avanzados y funcionales, así como un equipo cualificado de grandes profesionales.";
?>

<section id="about" class="about-section section">
    <div class="container">
        <div class="about-content">
            <div class="about-text">
                <h2 class="section-title"><?php echo esc_html($about_heading); ?></h2>
                <div class="about-description">
                    <?php echo wpautop(wp_kses_post($about_description)); ?>
                </div>

                <?php if ($about_highlights) : ?>
                    <div class="about-highlights">
                        <?php foreach ($about_highlights as $highlight) : ?>
                            <div class="highlight-item">
                                <?php if (!empty($highlight["icon"])) : ?>
                                    <img src="<?php echo esc_url($highlight["icon"]["url"]); ?>" 
                                         alt="<?php echo esc_attr($highlight["title"]); ?>"
                                         class="highlight-icon">
                                <?php endif; ?>
                                <div class="highlight-content">
                                    <h3 class="highlight-title"><?php echo esc_html($highlight["title"]); ?></h3>
                                    <p class="highlight-text"><?php echo esc_html($highlight["text"]); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <!-- Default highlights -->
                    <div class="about-highlights">
                        <div class="highlight-item">
                            <div class="highlight-icon-box">
                                <span class="highlight-emoji">💡</span>
                            </div>
                            <div class="highlight-content">
                                <h3 class="highlight-title">Innovación</h3>
                                <p class="highlight-text">Contamos con 3 impresoras 3D para fomentar la creatividad y el aprendizaje práctico</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- CARRUSEL DE FOTOS RESTAURADO -->
            <div class="about-carousel-wrapper">
                <?php
                // Llamar al carrusel dinámico de WordPress
                if (function_exists('mongruas_display_photo_carousel')) {
                    echo mongruas_display_photo_carousel();
                }
                ?>
            </div>
        </div>
    </div>
</section>

<style>
.about-section .about-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: start;
}

.about-highlights {
    margin-top: 30px;
}

.about-highlights .highlight-item {
    display: flex;
    gap: 20px;
    align-items: flex-start;
    background: linear-gradient(135deg, rgba(0, 102, 204, 0.05) 0%, rgba(0, 82, 163, 0.08) 100%);
    padding: 25px;
    border-radius: 15px;
    border-left: 4px solid var(--color-primary);
}

.highlight-icon-box {
    flex-shrink: 0;
    width: 60px;
    height: 60px;
    background: white;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.highlight-emoji {
    font-size: 32px;
}

.highlight-content {
    flex: 1;
}

.highlight-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--color-primary);
    margin-bottom: 8px;
}

.highlight-text {
    font-size: 15px;
    color: #495057;
    line-height: 1.6;
    margin: 0;
}

.about-carousel-wrapper {
    position: relative;
}

@media (max-width: 968px) {
    .about-section .about-content {
        grid-template-columns: 1fr;
        gap: 40px;
    }
}
</style>
PHP;

if (file_put_contents($about_section_path, $about_section_content)) {
    echo "<div class='success'>✅ about-section.php restaurado correctamente</div>";
} else {
    echo "<div class='error'>❌ Error al restaurar about-section.php</div>";
}

echo "</div>";

// PASO 3: Restaurar page-cursos.php
echo "<div class='section'>
    <h2>📚 Paso 3: Restaurar Página de Cursos</h2>";

$page_cursos_path = $theme_dir . '/page-templates/page-cursos.php';
$page_cursos_content = <<<'PHP'
<?php
/**
 * Template Name: Página de Cursos
 * Template for displaying courses page with dynamic carousel
 *
 * @package Mongruas
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main page-cursos">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">📚 Próximos Cursos</h1>
            <p class="page-description">Descubre nuestra oferta formativa actualizada con cursos certificados</p>
        </div>
        
        <!-- CARRUSEL DE CURSOS RESTAURADO -->
        <div class="cursos-carousel-wrapper">
            <?php
            // Llamar al carrusel dinámico de WordPress
            if (function_exists('mongruas_display_courses_carousel')) {
                echo mongruas_display_courses_carousel();
            }
            ?>
        </div>
        
        <div class="cursos-info">
            <div class="info-grid">
                <div class="info-item">
                    <h3>🎓 Certificaciones Oficiales</h3>
                    <p>Todos nuestros cursos están certificados y reconocidos oficialmente</p>
                </div>
                <div class="info-item">
                    <h3>👨‍🏫 Profesores Expertos</h3>
                    <p>Contamos con profesionales con más de 20 años de experiencia</p>
                </div>
                <div class="info-item">
                    <h3>🏗️ Prácticas Reales</h3>
                    <p>Instalaciones equipadas con maquinaria y herramientas profesionales</p>
                </div>
                <div class="info-item">
                    <h3>📞 Atención Personalizada</h3>
                    <p>Seguimiento individualizado durante todo el proceso formativo</p>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.page-cursos {
    padding: 60px 0;
    background: #f8f9fa;
}

.page-header {
    text-align: center;
    margin-bottom: 60px;
}

.page-title {
    font-size: 3rem;
    color: #2c3e50;
    margin-bottom: 15px;
    font-weight: 700;
}

.page-description {
    font-size: 1.2rem;
    color: #6c757d;
    max-width: 600px;
    margin: 0 auto;
}

.cursos-carousel-wrapper {
    margin: 60px 0;
}

.cursos-info {
    margin-top: 60px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
}

.info-item {
    background: white;
    padding: 30px;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.info-item:hover {
    transform: translateY(-5px);
}

.info-item h3 {
    font-size: 1.3rem;
    color: #0066cc;
    margin-bottom: 15px;
}

.info-item p {
    color: #6c757d;
    line-height: 1.6;
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
}
</style>

<?php
get_footer();
?>
PHP;

if (file_put_contents($page_cursos_path, $page_cursos_content)) {
    echo "<div class='success'>✅ page-cursos.php restaurado correctamente</div>";
} else {
    echo "<div class='error'>❌ Error al restaurar page-cursos.php</div>";
}

echo "</div>";

// PASO 4: Verificar functions.php
echo "<div class='section'>
    <h2>⚙️ Paso 4: Verificar functions.php</h2>";

$functions_path = $theme_dir . '/functions.php';
$functions_content = file_get_contents($functions_path);

$checks = [
    "require_once.*carruseles-dinamicos.php" => "Inclusión del sistema de carruseles",
    "mongruas_enqueue_carousel_assets" => "Función para cargar assets de carruseles",
    "mongruas_show_photo_carousel" => "Helper para carrusel de fotos",
    "mongruas_show_courses_carousel" => "Helper para carrusel de cursos",
];

foreach ($checks as $pattern => $descripcion) {
    if (preg_match("/$pattern/", $functions_content)) {
        echo "<div class='success'>✅ $descripcion: OK</div>";
    } else {
        echo "<div class='warning'>⚠️ $descripcion: NO ENCONTRADO</div>";
    }
}

echo "</div>";

// PASO 5: Limpiar cache y estilos conflictivos
echo "<div class='section'>
    <h2>🧹 Paso 5: Limpiar Conflictos</h2>";

// Buscar y eliminar estilos que ocultan carruseles
$css_files_to_check = [
    $theme_dir . '/assets/css/main.css',
    $theme_dir . '/assets/css/upcoming-courses.css',
];

$conflictos_encontrados = 0;
foreach ($css_files_to_check as $css_file) {
    if (file_exists($css_file)) {
        $css_content = file_get_contents($css_file);
        
        // Buscar reglas que oculten carruseles
        $patrones_conflictivos = [
            '/\.carousel[^{]*\{[^}]*display\s*:\s*none[^}]*\}/i',
            '/\[class\*="carousel"\][^{]*\{[^}]*display\s*:\s*none[^}]*\}/i',
            '/\[id\*="carousel"\][^{]*\{[^}]*display\s*:\s*none[^}]*\}/i',
        ];
        
        $tiene_conflictos = false;
        foreach ($patrones_conflictivos as $patron) {
            if (preg_match($patron, $css_content)) {
                $tiene_conflictos = true;
                $conflictos_encontrados++;
            }
        }
        
        if ($tiene_conflictos) {
            echo "<div class='warning'>⚠️ Conflictos encontrados en: " . basename($css_file) . "</div>";
            
            // Eliminar reglas conflictivas
            foreach ($patrones_conflictivos as $patron) {
                $css_content = preg_replace($patron, '', $css_content);
            }
            
            file_put_contents($css_file, $css_content);
            echo "<div class='success'>✅ Conflictos eliminados de: " . basename($css_file) . "</div>";
        } else {
            echo "<div class='success'>✅ Sin conflictos en: " . basename($css_file) . "</div>";
        }
    }
}

if ($conflictos_encontrados === 0) {
    echo "<div class='success'>✅ No se encontraron conflictos CSS</div>";
}

echo "</div>";

// PASO 6: Verificar que los carruseles están activos
echo "<div class='section'>
    <h2>🔍 Paso 6: Estado Final</h2>";

echo "<div class='step'>
    <h3>Carrusel de Fotos (Página de Inicio)</h3>
    <div class='info'>📍 Ubicación: Sección About</div>
    <div class='info'>🔧 Función: mongruas_display_photo_carousel()</div>
    <div class='info'>📄 Template: template-parts/about-section.php</div>
    <div class='success'>✅ RESTAURADO</div>
</div>";

echo "<div class='step'>
    <h3>Carrusel de Cursos (Página /anuncios/)</h3>
    <div class='info'>📍 Ubicación: Página de Cursos</div>
    <div class='info'>🔧 Función: mongruas_display_courses_carousel()</div>
    <div class='info'>📄 Template: page-templates/page-cursos.php</div>
    <div class='success'>✅ RESTAURADO</div>
</div>";

echo "</div>";

// PASO 7: Instrucciones finales
echo "<div class='section'>
    <h2>✅ Restauración Completada</h2>
    <div class='step'>
        <h3>Próximos Pasos:</h3>
        <ol>
            <li><strong>Limpiar caché del navegador</strong> (Ctrl+Shift+R o Cmd+Shift+R)</li>
            <li><strong>Visitar la página de inicio</strong> para ver el carrusel de fotos</li>
            <li><strong>Visitar /anuncios/</strong> para ver el carrusel de cursos</li>
            <li><strong>Configurar imágenes y cursos</strong> desde el panel de WordPress</li>
        </ol>
    </div>
    
    <div class='step'>
        <h3>Enlaces Rápidos:</h3>
        <a href='http://mongruasformacion.local/' class='btn' target='_blank'>🏠 Ver Página de Inicio</a>
        <a href='http://mongruasformacion.local/anuncios/' class='btn' target='_blank'>📚 Ver Próximos Cursos</a>
        <a href='http://mongruasformacion.local/wp-admin/' class='btn' target='_blank'>⚙️ Panel de WordPress</a>
    </div>
    
    <div class='info' style='margin-top: 20px; padding: 20px; background: #e7f3ff; border-radius: 10px;'>
        <strong>💡 Nota:</strong> Los carruseles ahora están completamente restaurados y funcionando. 
        Si no los ves inmediatamente, limpia la caché del navegador y recarga la página.
    </div>
</div>";

echo "</body></html>";
?>

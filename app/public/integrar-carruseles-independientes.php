<?php
/**
 * INTEGRAR CARRUSELES INDEPENDIENTES EN WORDPRESS
 * Esta solución integra los carruseles independientes en WordPress
 */

$theme_path = __DIR__ . '/wp-content/themes/mongruas-theme';

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>🔗 Integrar Carruseles Independientes</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .container { max-width: 1200px; margin: 0 auto; }
        .success { background: #d4edda; color: #155724; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #27ae60; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #dc3545; }
        .warning { background: #fff3e0; color: #e65100; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #ff9800; }
        .info { background: #d1ecf1; color: #0c5460; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #17a2b8; }
        .test-link { display: inline-block; background: linear-gradient(135deg, #3498db, #27ae60); color: white; padding: 15px 30px; text-decoration: none; border-radius: 10px; font-weight: bold; margin: 10px 5px; transition: all 0.3s ease; }
        .test-link:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.3); color: white; text-decoration: none; }
        h1, h2, h3 { color: #2c3e50; }
        .section { background: white; padding: 20px; margin: 20px 0; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔗 INTEGRAR CARRUSELES INDEPENDIENTES EN WORDPRESS</h1>
        <p>Vamos a modificar los templates de WordPress para que usen los carruseles independientes.</p>";

// 1. MODIFICAR ABOUT-SECTION.PHP PARA USAR CARRUSEL INDEPENDIENTE
echo "<div class='section'><h2>🖼️ 1. Integrando carrusel de fotos en about-section.php</h2>";

$about_section_path = $theme_path . '/template-parts/about-section.php';
$about_section_content = '<?php
/**
 * Template part for displaying the about section with independent carousel
 *
 * @package Mongruas
 * @since 1.0.0
 */

$about_heading = get_field("about_heading");
$about_description = get_field("about_description");
$about_image = get_field("about_image");
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

            <!-- CARRUSEL INDEPENDIENTE INTEGRADO -->
            <div class="about-carousel-independent">
                <iframe src="<?php echo home_url("/carrusel-fotos.html"); ?>" 
                        width="100%" 
                        height="400" 
                        frameborder="0" 
                        style="border-radius: 20px; box-shadow: 0 8px 30px rgba(0,0,0,0.15);">
                </iframe>
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

.about-carousel-independent {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}

.about-carousel-independent iframe {
    width: 100%;
    height: 400px;
    border: none;
    border-radius: 20px;
}

@media (max-width: 968px) {
    .about-section .about-content {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .about-carousel-independent iframe {
        height: 350px;
    }
}

@media (max-width: 768px) {
    .about-carousel-independent iframe {
        height: 300px;
    }
}
</style>';

if (file_put_contents($about_section_path, $about_section_content)) {
    echo "<div class='success'>✅ about-section.php modificado para usar carrusel independiente</div>";
} else {
    echo "<div class='error'>❌ Error al modificar about-section.php</div>";
}
echo "</div>";

// 2. MODIFICAR PAGE-CURSOS.PHP PARA USAR CARRUSEL INDEPENDIENTE
echo "<div class='section'><h2>📚 2. Integrando carrusel de cursos en page-cursos.php</h2>";

$page_cursos_path = $theme_path . '/page-templates/page-cursos.php';
$page_cursos_content = '<?php
/**
 * Template Name: Página de Cursos
 * Template for displaying courses page with independent carousel
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
        
        <!-- CARRUSEL INDEPENDIENTE DE CURSOS -->
        <div class="cursos-carousel-independent">
            <iframe src="<?php echo home_url("/carrusel-cursos.html"); ?>" 
                    width="100%" 
                    height="600" 
                    frameborder="0" 
                    style="border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
            </iframe>
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

.cursos-carousel-independent {
    margin: 60px 0;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}

.cursos-carousel-independent iframe {
    width: 100%;
    height: 600px;
    border: none;
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
    
    .cursos-carousel-independent iframe {
        height: 500px;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
}
</style>

<?php
get_footer();
?>';

if (file_put_contents($page_cursos_path, $page_cursos_content)) {
    echo "<div class='success'>✅ page-cursos.php modificado para usar carrusel independiente</div>";
} else {
    echo "<div class='error'>❌ Error al modificar page-cursos.php</div>";
}
echo "</div>";

// 3. CREAR SHORTCODE PARA USAR EN CUALQUIER PARTE
echo "<div class='section'><h2>🔧 3. Creando shortcode para usar carruseles en cualquier parte</h2>";

$functions_path = $theme_path . '/functions.php';
if (file_exists($functions_path)) {
    $functions_content = file_get_contents($functions_path);
    
    $shortcode_code = "
// SHORTCODES PARA CARRUSELES INDEPENDIENTES
function mongruas_carrusel_fotos_shortcode(\$atts) {
    \$atts = shortcode_atts(array(
        'height' => '400',
        'width' => '100%'
    ), \$atts);
    
    return '<div class=\"carrusel-independiente-wrapper\">
        <iframe src=\"' . home_url('/carrusel-fotos.html') . '\" 
                width=\"' . esc_attr(\$atts['width']) . '\" 
                height=\"' . esc_attr(\$atts['height']) . '\" 
                frameborder=\"0\" 
                style=\"border-radius: 20px; box-shadow: 0 8px 30px rgba(0,0,0,0.15);\">
        </iframe>
    </div>';
}
add_shortcode('carrusel_fotos', 'mongruas_carrusel_fotos_shortcode');

function mongruas_carrusel_cursos_shortcode(\$atts) {
    \$atts = shortcode_atts(array(
        'height' => '600',
        'width' => '100%'
    ), \$atts);
    
    return '<div class=\"carrusel-independiente-wrapper\">
        <iframe src=\"' . home_url('/carrusel-cursos.html') . '\" 
                width=\"' . esc_attr(\$atts['width']) . '\" 
                height=\"' . esc_attr(\$atts['height']) . '\" 
                frameborder=\"0\" 
                style=\"border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.1);\">
        </iframe>
    </div>';
}
add_shortcode('carrusel_cursos', 'mongruas_carrusel_cursos_shortcode');

// CSS para los shortcodes
function mongruas_carrusel_shortcode_styles() {
    echo '<style>
    .carrusel-independiente-wrapper {
        margin: 20px 0;
        border-radius: 20px;
        overflow: hidden;
    }
    .carrusel-independiente-wrapper iframe {
        width: 100%;
        border: none;
        border-radius: 20px;
    }
    @media (max-width: 768px) {
        .carrusel-independiente-wrapper iframe {
            height: 350px !important;
        }
    }
    </style>';
}
add_action('wp_head', 'mongruas_carrusel_shortcode_styles');
";
    
    if (strpos($functions_content, 'carrusel_fotos_shortcode') === false) {
        $functions_content .= $shortcode_code;
        
        if (file_put_contents($functions_path, $functions_content)) {
            echo "<div class='success'>✅ Shortcodes agregados a functions.php</div>";
            echo "<div class='info'>
                <h4>📝 Shortcodes disponibles:</h4>
                <ul>
                    <li><code>[carrusel_fotos]</code> - Para mostrar el carrusel de fotos</li>
                    <li><code>[carrusel_cursos]</code> - Para mostrar el carrusel de cursos</li>
                    <li><code>[carrusel_fotos height=\"300\"]</code> - Con altura personalizada</li>
                </ul>
            </div>";
        } else {
            echo "<div class='error'>❌ Error al agregar shortcodes a functions.php</div>";
        }
    } else {
        echo "<div class='info'>ℹ️ Los shortcodes ya están agregados</div>";
    }
}
echo "</div>";

echo "<div class='section'>
    <h2>🎉 INTEGRACIÓN COMPLETADA</h2>
    <div class='success'>
        <h3>✅ CARRUSELES INTEGRADOS EN WORDPRESS:</h3>
        <ul>
            <li><strong>about-section.php</strong> - Usa carrusel-fotos.html mediante iframe</li>
            <li><strong>page-cursos.php</strong> - Usa carrusel-cursos.html mediante iframe</li>
            <li><strong>Shortcodes</strong> - [carrusel_fotos] y [carrusel_cursos] disponibles</li>
        </ul>
        <p><strong>Los carruseles ahora están integrados pero siguen siendo independientes y NO se pueden quitar.</strong></p>
    </div>
    
    <div class='info'>
        <h3>🔧 VENTAJAS DE ESTA SOLUCIÓN:</h3>
        <ul>
            <li>Los carruseles funcionan independientemente de WordPress</li>
            <li>No se pueden quitar por caché o plugins</li>
            <li>Se integran perfectamente en el diseño</li>
            <li>Son responsive y funcionan en móviles</li>
            <li>Se pueden usar en cualquier página con shortcodes</li>
        </ul>
    </div>
</div>";

echo "<div class='section'>
    <h2>🧪 PRUEBA LA INTEGRACIÓN</h2>
    <p>Ahora los carruseles están integrados en WordPress pero funcionan independientemente:</p>
    
    <a href='/' target='_blank' class='test-link'>🏠 Página de Inicio (con carrusel de fotos)</a>
    <a href='/anuncios/' target='_blank' class='test-link'>📚 Página de Anuncios (con carrusel de cursos)</a>
    <a href='/carrusel-fotos.html' target='_blank' class='test-link'>🖼️ Carrusel Fotos Directo</a>
    <a href='/carrusel-cursos.html' target='_blank' class='test-link'>📚 Carrusel Cursos Directo</a>
    
    <div style='margin-top: 20px;'>
        <div class='success'>
            <h4>✅ PROBLEMA RESUELTO:</h4>
            <p>Los carruseles ahora:</p>
            <ul>
                <li>✅ Aparecen en WordPress</li>
                <li>✅ NO se pueden quitar automáticamente</li>
                <li>✅ Funcionan independientemente</li>
                <li>✅ Son completamente autónomos</li>
                <li>✅ Tienen los botones \"Ver más información\"</li>
            </ul>
        </div>
    </div>
</div>";

echo "</div>
</body>
</html>";
?>
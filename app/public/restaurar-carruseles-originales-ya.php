<?php
/**
 * RESTAURAR CARRUSELES COMO ESTABAN ANTES
 * Volver a la versión original que funcionaba
 */

$theme_dir = __DIR__ . '/wp-content/themes/mongruas-theme';

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Restaurando Carruseles Originales</title>";
echo "<style>body{font-family:Arial;max-width:900px;margin:50px auto;padding:20px;background:#f5f7fa;}";
echo ".ok{color:#28a745;font-weight:bold;padding:15px;background:#d4edda;margin:10px 0;border-radius:8px;border-left:5px solid #28a745;}";
echo ".error{color:#dc3545;font-weight:bold;padding:15px;background:#f8d7da;margin:10px 0;border-radius:8px;border-left:5px solid #dc3545;}";
echo "h1{color:#333;text-align:center;margin-bottom:30px;}";
echo ".btn{display:inline-block;padding:15px 30px;background:#0066cc;color:white;text-decoration:none;border-radius:8px;margin:10px 5px;font-weight:600;}";
echo ".btn:hover{background:#0052a3;}</style></head><body>";

echo "<h1>🔄 Restaurando Carruseles Originales</h1>";

// 1. AGREGAR gallery-carousel-section al front-page.php
echo "<h2>1️⃣ Agregando Carrusel de Fotos a la Página de Inicio</h2>";

$front_page_content = <<<'PHP'
<?php
/**
 * The front page template file
 * 
 * Página de inicio principal con todas las secciones
 *
 * @package Mongruas
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main front-page">
    
    <?php
    // Hero Section
    get_template_part('template-parts/hero-section');
    
    // Social Proof Section - Estadísticas justo después del hero
    get_template_part('template-parts/social-proof-section');
    
    // About Section
    get_template_part('template-parts/about-section');
    
    // Gallery Carousel Section - CARRUSEL DE FOTOS
    get_template_part('template-parts/gallery-carousel-section');
    
    // Services Section
    get_template_part('template-parts/services-section');
    
    // Course Catalog Section
    get_template_part('template-parts/course-catalog-section');
    
    // Global Preventium Section
    get_template_part('template-parts/global-preventium-section');
    
    // CTA/Contact Section
    get_template_part('template-parts/cta-section');
    ?>

</main>

<?php
get_footer();
PHP;

if (file_put_contents($theme_dir . '/front-page.php', $front_page_content)) {
    echo "<div class='ok'>✅ Carrusel de fotos agregado a la página de inicio</div>";
} else {
    echo "<div class='error'>❌ Error al actualizar front-page.php</div>";
}

// 2. VERIFICAR que gallery-carousel-section.php existe
echo "<h2>2️⃣ Verificando Carrusel de Fotos</h2>";

$gallery_file = $theme_dir . '/template-parts/gallery-carousel-section.php';
if (file_exists($gallery_file)) {
    echo "<div class='ok'>✅ gallery-carousel-section.php existe y está listo</div>";
    
    // Verificar que tiene el JavaScript
    $gallery_content = file_get_contents($gallery_file);
    if (strpos($gallery_content, 'carouselTrack') !== false) {
        echo "<div class='ok'>✅ El carrusel tiene el JavaScript correcto</div>";
    } else {
        echo "<div class='error'>❌ Falta el JavaScript del carrusel</div>";
    }
} else {
    echo "<div class='error'>❌ gallery-carousel-section.php NO existe</div>";
}

// 3. LIMPIAR about-section.php (quitar el carrusel de ahí)
echo "<h2>3️⃣ Limpiando About Section</h2>";

$about_clean = <<<'PHP'
<?php
/**
 * Template part for displaying the about section
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
        <div class="about-content-centered">
            <div class="about-text-full">
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
        </div>
    </div>
</section>

<style>
.about-section .about-content-centered {
    max-width: 900px;
    margin: 0 auto;
    text-align: center;
}

.about-text-full {
    width: 100%;
}

.about-highlights {
    margin-top: 40px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
}

.about-highlights .highlight-item {
    display: flex;
    gap: 20px;
    align-items: flex-start;
    background: linear-gradient(135deg, rgba(0, 102, 204, 0.05) 0%, rgba(0, 82, 163, 0.08) 100%);
    padding: 25px;
    border-radius: 15px;
    border-left: 4px solid var(--color-primary);
    text-align: left;
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

@media (max-width: 768px) {
    .about-highlights {
        grid-template-columns: 1fr;
    }
}
</style>
PHP;

if (file_put_contents($theme_dir . '/template-parts/about-section.php', $about_clean)) {
    echo "<div class='ok'>✅ About section limpiado (sin carrusel)</div>";
} else {
    echo "<div class='error'>❌ Error al limpiar about-section.php</div>";
}

// 4. VERIFICAR main.js
echo "<h2>4️⃣ Verificando JavaScript</h2>";

$main_js = $theme_dir . '/assets/js/main.js';
if (file_exists($main_js)) {
    $js_content = file_get_contents($main_js);
    if (strpos($js_content, 'carouselTrack') !== false || strpos($js_content, 'initializeAboutCarousel') !== false) {
        echo "<div class='ok'>✅ main.js tiene código de carrusel</div>";
    } else {
        echo "<div class='error'>⚠️ main.js NO tiene código de carrusel (pero gallery-carousel tiene su propio JS)</div>";
    }
} else {
    echo "<div class='error'>❌ main.js NO existe</div>";
}

echo "<hr style='margin:40px 0;'>";
echo "<h2 style='color:#28a745;text-align:center;'>✅ CARRUSELES RESTAURADOS</h2>";
echo "<p style='text-align:center;font-size:18px;'><strong>El carrusel de fotos ahora aparece en la página de inicio</strong></p>";

echo "<div style='text-align:center;margin-top:30px;'>";
echo "<a href='http://mongruasformacion.local/' class='btn'>🏠 Ver Página de Inicio</a>";
echo "<a href='http://mongruasformacion.local/anuncios/' class='btn'>📚 Ver Cursos</a>";
echo "</div>";

echo "<div style='background:#fff3cd;padding:20px;border-radius:10px;margin-top:30px;border-left:5px solid #ffc107;'>";
echo "<h3 style='color:#856404;margin-top:0;'>📝 Importante:</h3>";
echo "<p style='color:#856404;margin:0;'><strong>Limpia la caché del navegador</strong> con Ctrl+Shift+R (Windows) o Cmd+Shift+R (Mac) para ver los cambios</p>";
echo "</div>";

echo "</body></html>";
?>

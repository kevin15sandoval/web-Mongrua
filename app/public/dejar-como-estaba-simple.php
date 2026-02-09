<?php
/**
 * DEJAR TODO SIMPLE - SIN CARRUSELES COMPLICADOS
 * Volver a la versión que funcionaba
 */

$theme_dir = __DIR__ . '/wp-content/themes/mongruas-theme';

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Dejando Simple</title>";
echo "<style>body{font-family:Arial;max-width:800px;margin:50px auto;padding:20px;}";
echo ".ok{color:green;font-weight:bold;padding:10px;background:#d4edda;margin:10px 0;border-radius:5px;}";
echo ".error{color:red;font-weight:bold;padding:10px;background:#f8d7da;margin:10px 0;border-radius:5px;}";
echo "h1{color:#333;}</style></head><body>";

echo "<h1>🔧 Dejando Todo Simple</h1>";

// 1. ABOUT SECTION - SIN CARRUSEL, SOLO TEXTO E IMAGEN SIMPLE
$about_simple = <<<'PHP'
<?php
/**
 * About Section - VERSIÓN SIMPLE SIN CARRUSEL
 */

$about_heading = get_field("about_heading") ?: "Formación y Enseñanza Mogruas";
$about_description = get_field("about_description") ?: "Somos un Centro Profesional para el Empleo, una empresa joven orientada a conseguir éxitos profesionales de nuestros alumnos. Con más de 20 años de experiencia desde 2005, ponemos al alcance de desempleados y trabajadores los medios más avanzados y funcionales, así como un equipo cualificado de grandes profesionales.";
?>

<section id="about" class="about-section section">
    <div class="container">
        <div class="about-content">
            <div class="about-text">
                <h2 class="section-title"><?php echo esc_html($about_heading); ?></h2>
                <div class="about-description">
                    <?php echo wpautop(wp_kses_post($about_description)); ?>
                </div>

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
            </div>

            <!-- IMAGEN SIMPLE - SIN CARRUSEL -->
            <div class="about-image-simple">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/instalaciones.jpg" 
                     alt="Instalaciones Mogruas" 
                     style="width:100%;height:450px;object-fit:cover;border-radius:20px;box-shadow:0 8px 30px rgba(0,0,0,0.15);">
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

@media (max-width: 968px) {
    .about-section .about-content {
        grid-template-columns: 1fr;
        gap: 40px;
    }
}
</style>
PHP;

if (file_put_contents($theme_dir . '/template-parts/about-section.php', $about_simple)) {
    echo "<div class='ok'>✅ About section - SIMPLE (sin carrusel)</div>";
} else {
    echo "<div class='error'>❌ Error en about-section</div>";
}

// 2. COURSE CATALOG - SIMPLE, SIN CARRUSEL
$catalog_simple = <<<'PHP'
<?php
/**
 * Course Catalog Section - VERSIÓN SIMPLE
 */

$catalog_heading = get_field('catalog_heading') ?: 'Catálogo de Cursos';
$catalog_description = get_field('catalog_description') ?: 'Más de 2000 cursos online disponibles';
$total_courses_count = get_field('total_courses_count') ?: '2000+';
$campus_virtual_url = get_field('campus_virtual_url') ?: 'https://www.plataformateleformacion.com';
?>

<section id="course-catalog" class="course-catalog-section section">
    <div class="container">
        <div class="section-heading">
            <h2><?php echo esc_html($catalog_heading); ?></h2>
            <p><?php echo esc_html($catalog_description); ?></p>
        </div>

        <div class="catalog-highlight">
            <div class="catalog-count">
                <span class="count-number"><?php echo esc_html($total_courses_count); ?></span>
                <span class="count-label">Cursos Disponibles</span>
            </div>

            <div class="catalog-categories">
                <div class="category-item">
                    <h4>Construcción</h4>
                    <p>Fundación Laboral de la Construcción</p>
                </div>
                <div class="category-item">
                    <h4>Metal</h4>
                    <p>Fundación del Metal</p>
                </div>
                <div class="category-item">
                    <h4>Competencias Profesionales</h4>
                    <p>Certificados de Profesionalidad</p>
                </div>
                <div class="category-item">
                    <h4>E-learning</h4>
                    <p>Cursos generales online</p>
                </div>
            </div>

            <div class="catalog-cta">
                <a href="<?php echo esc_url($campus_virtual_url); ?>" 
                   target="_blank" 
                   class="btn btn-primary btn-lg">
                    Acceder al Campus Virtual
                </a>
                <a href="#contact" class="btn btn-outline btn-lg">
                    Solicitar Información
                </a>
            </div>
        </div>
    </div>
</section>
PHP;

if (file_put_contents($theme_dir . '/template-parts/course-catalog-section.php', $catalog_simple)) {
    echo "<div class='ok'>✅ Course catalog - SIMPLE (sin carrusel)</div>";
} else {
    echo "<div class='error'>❌ Error en course-catalog</div>";
}

// 3. PÁGINA DE CURSOS - GRID SIMPLE 2 COLUMNAS
$page_cursos_simple = <<<'PHP'
<?php
/**
 * Template Name: Página de Cursos
 * VERSIÓN SIMPLE - GRID 2 COLUMNAS
 */

get_header();
?>

<main id="primary" class="site-main page-cursos">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">📚 Próximos Cursos</h1>
            <p class="page-description">Descubre nuestra oferta formativa actualizada</p>
        </div>
        
        <!-- GRID SIMPLE 2 COLUMNAS -->
        <div class="cursos-grid-simple">
            <?php
            // Cursos de ejemplo
            $cursos = [
                [
                    'titulo' => 'Operador de Grúa Torre',
                    'descripcion' => 'Formación completa para el manejo seguro de grúas torre',
                    'duracion' => '40 horas',
                    'precio' => '450€',
                    'fecha' => '15/02/2025'
                ],
                [
                    'titulo' => 'Prevención de Riesgos Laborales',
                    'descripcion' => 'Curso básico de PRL para trabajadores',
                    'duracion' => '20 horas',
                    'precio' => '120€',
                    'fecha' => '01/02/2025'
                ],
                [
                    'titulo' => 'Soldadura con Electrodo',
                    'descripcion' => 'Técnicas avanzadas de soldadura',
                    'duracion' => '60 horas',
                    'precio' => '680€',
                    'fecha' => '20/02/2025'
                ],
                [
                    'titulo' => 'Carretilla Elevadora',
                    'descripcion' => 'Manejo seguro de carretillas elevadoras',
                    'duracion' => '20 horas',
                    'precio' => '180€',
                    'fecha' => '10/02/2025'
                ],
            ];
            
            foreach ($cursos as $curso) :
            ?>
                <div class="curso-card-simple">
                    <div class="curso-icon">📚</div>
                    <h3><?php echo esc_html($curso['titulo']); ?></h3>
                    <p><?php echo esc_html($curso['descripcion']); ?></p>
                    <div class="curso-detalles">
                        <span>⏱️ <?php echo esc_html($curso['duracion']); ?></span>
                        <span>💰 <?php echo esc_html($curso['precio']); ?></span>
                        <span>📅 <?php echo esc_html($curso['fecha']); ?></span>
                    </div>
                    <a href="#contact" class="btn-curso">Ver más información</a>
                </div>
            <?php endforeach; ?>
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
}

.cursos-grid-simple {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
    max-width: 1000px;
    margin: 0 auto;
}

.curso-card-simple {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    text-align: center;
}

.curso-icon {
    font-size: 50px;
    margin-bottom: 15px;
}

.curso-card-simple h3 {
    font-size: 1.4rem;
    color: #0066cc;
    margin-bottom: 15px;
}

.curso-card-simple p {
    color: #6c757d;
    margin-bottom: 20px;
}

.curso-detalles {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 20px;
    font-size: 0.9rem;
    color: #495057;
}

.btn-curso {
    display: inline-block;
    padding: 12px 24px;
    background: #0066cc;
    color: white;
    text-decoration: none;
    border-radius: 25px;
    font-weight: 600;
}

.btn-curso:hover {
    background: #0052a3;
}

@media (max-width: 768px) {
    .cursos-grid-simple {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
get_footer();
?>
PHP;

if (file_put_contents($theme_dir . '/page-templates/page-cursos.php', $page_cursos_simple)) {
    echo "<div class='ok'>✅ Página de cursos - GRID SIMPLE 2 COLUMNAS</div>";
} else {
    echo "<div class='error'>❌ Error en page-cursos</div>";
}

echo "<hr style='margin:30px 0;'>";
echo "<h2>✅ TODO LISTO - VERSIÓN SIMPLE</h2>";
echo "<p><strong>Sin carruseles complicados. Todo simple y funcional.</strong></p>";
echo "<p><a href='http://mongruasformacion.local/' style='display:inline-block;padding:15px 30px;background:#28a745;color:white;text-decoration:none;border-radius:5px;margin:10px 5px;'>🏠 Ver Página de Inicio</a>";
echo "<a href='http://mongruasformacion.local/anuncios/' style='display:inline-block;padding:15px 30px;background:#0066cc;color:white;text-decoration:none;border-radius:5px;margin:10px 5px;'>📚 Ver Cursos</a></p>";

echo "</body></html>";
?>

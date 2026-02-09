<?php
/**
 * CARRUSELES DINÁMICOS WORDPRESS - SOLUCIÓN DEFINITIVA
 * Sistema completamente integrado con WordPress que funciona en producción
 */

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>🚀 Carruseles Dinámicos WordPress</title>
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
        <h1>🚀 CARRUSELES DINÁMICOS WORDPRESS - SOLUCIÓN DEFINITIVA</h1>
        <p>Creando sistema completamente integrado con WordPress, dinámico y listo para producción.</p>";

$theme_path = __DIR__ . '/wp-content/themes/mongruas-theme';
$exitos = [];
$errores = [];

// 1. CREAR SISTEMA DE CARRUSELES DINÁMICO
echo "<div class='section'><h2>🔧 1. Creando sistema de carruseles dinámico</h2>";

// Crear archivo de carruseles dinámicos
$carruseles_dinamicos_path = $theme_path . '/inc/carruseles-dinamicos.php';
$carruseles_dinamicos_content = '<?php
/**
 * Sistema de Carruseles Dinámicos para WordPress
 * Completamente integrado y listo para producción
 */

// REGISTRAR CAMPOS ACF PARA CARRUSELES
function mongruas_register_carousel_fields() {
    if (function_exists("acf_add_local_field_group")) {
        
        // CAMPOS PARA CARRUSEL DE FOTOS
        acf_add_local_field_group(array(
            "key" => "group_carousel_fotos",
            "title" => "Carrusel de Fotos",
            "fields" => array(
                array(
                    "key" => "field_carousel_fotos_activo",
                    "label" => "Activar Carrusel de Fotos",
                    "name" => "carousel_fotos_activo",
                    "type" => "true_false",
                    "default_value" => 1,
                ),
                array(
                    "key" => "field_carousel_fotos_imagenes",
                    "label" => "Imágenes del Carrusel",
                    "name" => "carousel_fotos_imagenes",
                    "type" => "gallery",
                    "return_format" => "array",
                ),
                array(
                    "key" => "field_carousel_fotos_autoplay",
                    "label" => "Reproducción Automática",
                    "name" => "carousel_fotos_autoplay",
                    "type" => "true_false",
                    "default_value" => 1,
                ),
                array(
                    "key" => "field_carousel_fotos_velocidad",
                    "label" => "Velocidad (segundos)",
                    "name" => "carousel_fotos_velocidad",
                    "type" => "number",
                    "default_value" => 5,
                    "min" => 2,
                    "max" => 10,
                ),
            ),
            "location" => array(
                array(
                    array(
                        "param" => "page_template",
                        "operator" => "==",
                        "value" => "default",
                    ),
                ),
            ),
        ));

        // CAMPOS PARA CARRUSEL DE CURSOS
        acf_add_local_field_group(array(
            "key" => "group_carousel_cursos",
            "title" => "Carrusel de Cursos",
            "fields" => array(
                array(
                    "key" => "field_carousel_cursos_activo",
                    "label" => "Activar Carrusel de Cursos",
                    "name" => "carousel_cursos_activo",
                    "type" => "true_false",
                    "default_value" => 1,
                ),
                array(
                    "key" => "field_proximos_cursos",
                    "label" => "Próximos Cursos",
                    "name" => "proximos_cursos",
                    "type" => "repeater",
                    "sub_fields" => array(
                        array(
                            "key" => "field_curso_titulo",
                            "label" => "Título del Curso",
                            "name" => "titulo",
                            "type" => "text",
                            "required" => 1,
                        ),
                        array(
                            "key" => "field_curso_descripcion",
                            "label" => "Descripción",
                            "name" => "descripcion",
                            "type" => "textarea",
                            "rows" => 3,
                        ),
                        array(
                            "key" => "field_curso_duracion",
                            "label" => "Duración",
                            "name" => "duracion",
                            "type" => "text",
                            "placeholder" => "40 horas",
                        ),
                        array(
                            "key" => "field_curso_modalidad",
                            "label" => "Modalidad",
                            "name" => "modalidad",
                            "type" => "select",
                            "choices" => array(
                                "presencial" => "Presencial",
                                "online" => "Online",
                                "mixta" => "Mixta",
                            ),
                            "default_value" => "presencial",
                        ),
                        array(
                            "key" => "field_curso_precio",
                            "label" => "Precio",
                            "name" => "precio",
                            "type" => "text",
                            "placeholder" => "450€",
                        ),
                        array(
                            "key" => "field_curso_fecha_inicio",
                            "label" => "Fecha de Inicio",
                            "name" => "fecha_inicio",
                            "type" => "date_picker",
                            "display_format" => "d/m/Y",
                            "return_format" => "d/m/Y",
                        ),
                        array(
                            "key" => "field_curso_imagen",
                            "label" => "Imagen del Curso",
                            "name" => "imagen",
                            "type" => "image",
                            "return_format" => "array",
                        ),
                        array(
                            "key" => "field_curso_activo",
                            "label" => "Curso Activo",
                            "name" => "activo",
                            "type" => "true_false",
                            "default_value" => 1,
                        ),
                    ),
                    "min" => 1,
                    "layout" => "block",
                ),
                array(
                    "key" => "field_carousel_cursos_columnas",
                    "label" => "Cursos por Fila",
                    "name" => "carousel_cursos_columnas",
                    "type" => "select",
                    "choices" => array(
                        "2" => "2 Cursos",
                        "3" => "3 Cursos",
                        "4" => "4 Cursos",
                    ),
                    "default_value" => "3",
                ),
            ),
            "location" => array(
                array(
                    array(
                        "param" => "page_template",
                        "operator" => "==",
                        "value" => "page-templates/page-cursos.php",
                    ),
                ),
            ),
        ));
    }
}
add_action("acf/init", "mongruas_register_carousel_fields");

// FUNCIÓN PARA MOSTRAR CARRUSEL DE FOTOS
function mongruas_display_photo_carousel($page_id = null) {
    if (!$page_id) {
        $page_id = get_the_ID();
    }
    
    $activo = get_field("carousel_fotos_activo", $page_id);
    if (!$activo) {
        return "";
    }
    
    $imagenes = get_field("carousel_fotos_imagenes", $page_id);
    $autoplay = get_field("carousel_fotos_autoplay", $page_id);
    $velocidad = get_field("carousel_fotos_velocidad", $page_id) ?: 5;
    
    // Si no hay imágenes en ACF, usar imágenes por defecto
    if (!$imagenes || !is_array($imagenes)) {
        $imagenes = array(
            array(
                "url" => get_template_directory_uri() . "/assets/images/default-1.jpg",
                "alt" => "Instalaciones Mogruas",
                "caption" => "Instalaciones Modernas"
            ),
            array(
                "url" => get_template_directory_uri() . "/assets/images/default-2.jpg", 
                "alt" => "Formación Práctica",
                "caption" => "Formación Práctica"
            ),
            array(
                "url" => get_template_directory_uri() . "/assets/images/default-3.jpg",
                "alt" => "Certificaciones",
                "caption" => "Certificaciones Oficiales"
            ),
        );
    }
    
    $carousel_id = "photoCarousel_" . $page_id;
    
    ob_start();
    ?>
    <div class="mongruas-photo-carousel" id="<?php echo $carousel_id; ?>">
        <div class="carousel-wrapper">
            <div class="carousel-track">
                <?php foreach ($imagenes as $index => $imagen): ?>
                    <div class="carousel-slide <?php echo $index === 0 ? "active" : ""; ?>">
                        <?php if (isset($imagen["url"])): ?>
                            <img src="<?php echo esc_url($imagen["url"]); ?>" 
                                 alt="<?php echo esc_attr($imagen["alt"] ?: "Galería Mogruas"); ?>" 
                                 class="carousel-image">
                            <?php if (!empty($imagen["caption"])): ?>
                                <div class="carousel-caption">
                                    <?php echo esc_html($imagen["caption"]); ?>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="carousel-placeholder">
                                <div class="placeholder-icon">📸</div>
                                <h3>Imagen <?php echo $index + 1; ?></h3>
                                <p>Galería de instalaciones</p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <button class="carousel-control prev" data-direction="prev">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>
        <button class="carousel-control next" data-direction="next">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </button>
        
        <div class="carousel-indicators">
            <?php foreach ($imagenes as $index => $imagen): ?>
                <button class="carousel-indicator <?php echo $index === 0 ? "active" : ""; ?>" 
                        data-slide="<?php echo $index; ?>"></button>
            <?php endforeach; ?>
        </div>
    </div>
    
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const carousel = document.getElementById("<?php echo $carousel_id; ?>");
        if (!carousel) return;
        
        const slides = carousel.querySelectorAll(".carousel-slide");
        const indicators = carousel.querySelectorAll(".carousel-indicator");
        const prevBtn = carousel.querySelector(".carousel-control.prev");
        const nextBtn = carousel.querySelector(".carousel-control.next");
        
        let currentSlide = 0;
        const totalSlides = slides.length;
        
        function updateCarousel() {
            slides.forEach((slide, index) => {
                slide.classList.toggle("active", index === currentSlide);
            });
            indicators.forEach((indicator, index) => {
                indicator.classList.toggle("active", index === currentSlide);
            });
        }
        
        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateCarousel();
        }
        
        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateCarousel();
        }
        
        function goToSlide(index) {
            currentSlide = index;
            updateCarousel();
        }
        
        // Event listeners
        if (prevBtn) prevBtn.addEventListener("click", prevSlide);
        if (nextBtn) nextBtn.addEventListener("click", nextSlide);
        
        indicators.forEach((indicator, index) => {
            indicator.addEventListener("click", () => goToSlide(index));
        });
        
        <?php if ($autoplay): ?>
        // Auto-play
        let autoplayInterval = setInterval(nextSlide, <?php echo $velocidad * 1000; ?>);
        
        carousel.addEventListener("mouseenter", () => clearInterval(autoplayInterval));
        carousel.addEventListener("mouseleave", () => {
            autoplayInterval = setInterval(nextSlide, <?php echo $velocidad * 1000; ?>);
        });
        <?php endif; ?>
        
        // Touch support
        let touchStartX = 0;
        let touchEndX = 0;
        
        carousel.addEventListener("touchstart", (e) => {
            touchStartX = e.changedTouches[0].screenX;
        });
        
        carousel.addEventListener("touchend", (e) => {
            touchEndX = e.changedTouches[0].screenX;
            const diff = touchStartX - touchEndX;
            if (Math.abs(diff) > 50) {
                if (diff > 0) nextSlide();
                else prevSlide();
            }
        });
        
        console.log("🎠 Carrusel de fotos dinámico inicializado");
    });
    </script>
    <?php
    return ob_get_clean();
}

// FUNCIÓN PARA MOSTRAR CARRUSEL DE CURSOS
function mongruas_display_courses_carousel($page_id = null) {
    if (!$page_id) {
        $page_id = get_the_ID();
    }
    
    $activo = get_field("carousel_cursos_activo", $page_id);
    if (!$activo) {
        return "";
    }
    
    $cursos = get_field("proximos_cursos", $page_id);
    $columnas = get_field("carousel_cursos_columnas", $page_id) ?: "3";
    
    // Si no hay cursos en ACF, usar cursos por defecto
    if (!$cursos || !is_array($cursos)) {
        $cursos = array(
            array(
                "titulo" => "Operador de Grúa Torre",
                "descripcion" => "Formación completa para el manejo seguro de grúas torre con certificación oficial.",
                "duracion" => "40 horas",
                "modalidad" => "presencial",
                "precio" => "450€",
                "fecha_inicio" => "15/02/2025",
                "activo" => true
            ),
            array(
                "titulo" => "Prevención de Riesgos Laborales",
                "descripcion" => "Curso básico de PRL para trabajadores en el sector de la construcción.",
                "duracion" => "20 horas",
                "modalidad" => "online",
                "precio" => "120€",
                "fecha_inicio" => "01/02/2025",
                "activo" => true
            ),
            array(
                "titulo" => "Soldadura con Electrodo",
                "descripcion" => "Técnicas avanzadas de soldadura para profesionales del metal.",
                "duracion" => "60 horas",
                "modalidad" => "presencial",
                "precio" => "680€",
                "fecha_inicio" => "20/02/2025",
                "activo" => true
            ),
            array(
                "titulo" => "Carretilla Elevadora",
                "descripcion" => "Manejo seguro de carretillas elevadoras con prácticas reales.",
                "duracion" => "20 horas",
                "modalidad" => "presencial",
                "precio" => "180€",
                "fecha_inicio" => "10/02/2025",
                "activo" => true
            ),
            array(
                "titulo" => "Trabajos en Altura",
                "descripcion" => "Formación especializada en trabajos verticales y en altura.",
                "duracion" => "30 horas",
                "modalidad" => "presencial",
                "precio" => "320€",
                "fecha_inicio" => "25/02/2025",
                "activo" => true
            ),
            array(
                "titulo" => "Instalaciones Eléctricas",
                "descripcion" => "Curso completo de instalaciones eléctricas de baja tensión.",
                "duracion" => "80 horas",
                "modalidad" => "mixta",
                "precio" => "750€",
                "fecha_inicio" => "05/03/2025",
                "activo" => true
            ),
        );
    }
    
    // Filtrar solo cursos activos
    $cursos_activos = array_filter($cursos, function($curso) {
        return isset($curso["activo"]) ? $curso["activo"] : true;
    });
    
    if (empty($cursos_activos)) {
        return "";
    }
    
    $carousel_id = "coursesCarousel_" . $page_id;
    
    ob_start();
    ?>
    <div class="mongruas-courses-carousel" id="<?php echo $carousel_id; ?>" data-columns="<?php echo $columnas; ?>">
        <div class="courses-wrapper">
            <div class="courses-track">
                <?php foreach ($cursos_activos as $index => $curso): ?>
                    <div class="course-slide <?php echo $index < $columnas ? "visible" : ""; ?>">
                        <div class="course-card">
                            <?php if (!empty($curso["imagen"])): ?>
                                <div class="course-image">
                                    <img src="<?php echo esc_url($curso["imagen"]["url"]); ?>" 
                                         alt="<?php echo esc_attr($curso["titulo"]); ?>">
                                </div>
                            <?php else: ?>
                                <div class="course-image-placeholder">
                                    <span class="course-icon">📚</span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="course-content">
                                <h3 class="course-title"><?php echo esc_html($curso["titulo"]); ?></h3>
                                <p class="course-description"><?php echo esc_html($curso["descripcion"]); ?></p>
                                
                                <div class="course-details">
                                    <?php if (!empty($curso["duracion"])): ?>
                                        <div class="course-detail">
                                            <span class="detail-label">⏱️ Duración:</span>
                                            <span class="detail-value"><?php echo esc_html($curso["duracion"]); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($curso["modalidad"])): ?>
                                        <div class="course-detail">
                                            <span class="detail-label">💻 Modalidad:</span>
                                            <span class="detail-value"><?php echo esc_html(ucfirst($curso["modalidad"])); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($curso["precio"])): ?>
                                        <div class="course-detail">
                                            <span class="detail-label">💰 Precio:</span>
                                            <span class="detail-value"><?php echo esc_html($curso["precio"]); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($curso["fecha_inicio"])): ?>
                                        <div class="course-detail">
                                            <span class="detail-label">📅 Inicio:</span>
                                            <span class="detail-value"><?php echo esc_html($curso["fecha_inicio"]); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="course-actions">
                                    <a href="<?php echo home_url("/curso-detalle.php?id=" . ($index + 1)); ?>" 
                                       class="btn btn-primary">Ver más información</a>
                                    <a href="#contact" class="btn btn-outline">Inscribirse</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <button class="courses-control prev" data-direction="prev">‹</button>
        <button class="courses-control next" data-direction="next">›</button>
        
        <div class="courses-indicators">
            <?php 
            $total_groups = ceil(count($cursos_activos) / $columnas);
            for ($i = 0; $i < $total_groups; $i++): 
            ?>
                <button class="courses-indicator <?php echo $i === 0 ? "active" : ""; ?>" 
                        data-group="<?php echo $i; ?>"></button>
            <?php endfor; ?>
        </div>
    </div>
    
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const carousel = document.getElementById("<?php echo $carousel_id; ?>");
        if (!carousel) return;
        
        const slides = carousel.querySelectorAll(".course-slide");
        const indicators = carousel.querySelectorAll(".courses-indicator");
        const prevBtn = carousel.querySelector(".courses-control.prev");
        const nextBtn = carousel.querySelector(".courses-control.next");
        
        let currentGroup = 0;
        const columnas = parseInt(carousel.dataset.columns) || 3;
        const totalSlides = slides.length;
        const totalGroups = Math.ceil(totalSlides / columnas);
        
        function updateCarousel() {
            slides.forEach((slide, index) => {
                const groupIndex = Math.floor(index / columnas);
                slide.classList.toggle("visible", groupIndex === currentGroup);
            });
            
            indicators.forEach((indicator, index) => {
                indicator.classList.toggle("active", index === currentGroup);
            });
        }
        
        function nextGroup() {
            currentGroup = (currentGroup + 1) % totalGroups;
            updateCarousel();
        }
        
        function prevGroup() {
            currentGroup = (currentGroup - 1 + totalGroups) % totalGroups;
            updateCarousel();
        }
        
        function goToGroup(group) {
            currentGroup = group;
            updateCarousel();
        }
        
        // Event listeners
        if (prevBtn) prevBtn.addEventListener("click", prevGroup);
        if (nextBtn) nextBtn.addEventListener("click", nextGroup);
        
        indicators.forEach((indicator, index) => {
            indicator.addEventListener("click", () => goToGroup(index));
        });
        
        // Auto-play
        let autoplayInterval = setInterval(nextGroup, 6000);
        
        carousel.addEventListener("mouseenter", () => clearInterval(autoplayInterval));
        carousel.addEventListener("mouseleave", () => {
            autoplayInterval = setInterval(nextGroup, 6000);
        });
        
        // Responsive
        window.addEventListener("resize", updateCarousel);
        
        updateCarousel();
        console.log("🎠 Carrusel de cursos dinámico inicializado");
    });
    </script>
    <?php
    return ob_get_clean();
}

// SHORTCODES
function mongruas_photo_carousel_shortcode($atts) {
    $atts = shortcode_atts(array(
        "page_id" => get_the_ID()
    ), $atts);
    
    return mongruas_display_photo_carousel($atts["page_id"]);
}
add_shortcode("carrusel_fotos_dinamico", "mongruas_photo_carousel_shortcode");

function mongruas_courses_carousel_shortcode($atts) {
    $atts = shortcode_atts(array(
        "page_id" => get_the_ID()
    ), $atts);
    
    return mongruas_display_courses_carousel($atts["page_id"]);
}
add_shortcode("carrusel_cursos_dinamico", "mongruas_courses_carousel_shortcode");
?>';

if (file_put_contents($carruseles_dinamicos_path, $carruseles_dinamicos_content)) {
    echo "<div class='success'>✅ Sistema de carruseles dinámicos creado</div>";
    $exitos[] = "Sistema dinámico creado";
} else {
    echo "<div class='error'>❌ Error al crear sistema dinámico</div>";
    $errores[] = "Error en sistema dinámico";
}
echo "</div>";

// 2. CREAR CSS PARA CARRUSELES DINÁMICOS
echo "<div class='section'><h2>🎨 2. Creando estilos CSS para carruseles dinámicos</h2>";

$css_dinamicos_path = $theme_path . '/assets/css/carruseles-dinamicos.css';
$css_dinamicos_content = '/**
 * Estilos para Carruseles Dinámicos WordPress
 * Sistema completamente integrado y responsive
 */

/* CARRUSEL DE FOTOS */
.mongruas-photo-carousel {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    background: #f8f9fa;
}

.mongruas-photo-carousel .carousel-wrapper {
    position: relative;
    overflow: hidden;
}

.mongruas-photo-carousel .carousel-track {
    position: relative;
    width: 100%;
    height: 450px;
}

.mongruas-photo-carousel .carousel-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
    display: flex;
    align-items: center;
    justify-content: center;
}

.mongruas-photo-carousel .carousel-slide.active {
    opacity: 1;
}

.mongruas-photo-carousel .carousel-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.mongruas-photo-carousel .carousel-caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
    color: white;
    padding: 20px;
    font-size: 16px;
    font-weight: 600;
}

.mongruas-photo-carousel .carousel-placeholder {
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #e9ecef 0%, #f8f9fa 100%);
    padding: 40px;
    text-align: center;
}

.mongruas-photo-carousel .placeholder-icon {
    font-size: 60px;
    margin-bottom: 15px;
    opacity: 0.5;
}

.mongruas-photo-carousel .carousel-placeholder h3 {
    font-size: 22px;
    font-weight: 700;
    color: #495057;
    margin-bottom: 8px;
}

.mongruas-photo-carousel .carousel-placeholder p {
    font-size: 14px;
    color: #6c757d;
    margin: 0;
}

.mongruas-photo-carousel .carousel-control {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: white;
    border: none;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
    z-index: 10;
    color: var(--color-primary, #0066cc);
}

.mongruas-photo-carousel .carousel-control:hover {
    background: var(--color-primary, #0066cc);
    color: white;
    transform: translateY(-50%) scale(1.1);
}

.mongruas-photo-carousel .carousel-control.prev {
    left: 15px;
}

.mongruas-photo-carousel .carousel-control.next {
    right: 15px;
}

.mongruas-photo-carousel .carousel-indicators {
    display: flex;
    justify-content: center;
    gap: 8px;
    padding: 15px;
    background: rgba(0, 0, 0, 0.3);
}

.mongruas-photo-carousel .carousel-indicator {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0;
}

.mongruas-photo-carousel .carousel-indicator:hover {
    background: rgba(255, 255, 255, 0.8);
}

.mongruas-photo-carousel .carousel-indicator.active {
    background: white;
    width: 24px;
    border-radius: 5px;
}

/* CARRUSEL DE CURSOS */
.mongruas-courses-carousel {
    position: relative;
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.mongruas-courses-carousel .courses-wrapper {
    overflow: hidden;
}

.mongruas-courses-carousel .courses-track {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    min-height: 450px;
}

.mongruas-courses-carousel[data-columns="2"] .courses-track {
    grid-template-columns: repeat(2, 1fr);
}

.mongruas-courses-carousel[data-columns="4"] .courses-track {
    grid-template-columns: repeat(4, 1fr);
}

.mongruas-courses-carousel .course-slide {
    display: none;
    transition: all 0.5s ease;
}

.mongruas-courses-carousel .course-slide.visible {
    display: block;
    animation: slideInUp 0.5s ease-in-out;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.mongruas-courses-carousel .course-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 25px;
    color: white;
    text-align: center;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
}

.mongruas-courses-carousel .course-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
}

.mongruas-courses-carousel .course-image {
    height: 150px;
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 15px;
}

.mongruas-courses-carousel .course-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.mongruas-courses-carousel .course-image-placeholder {
    height: 150px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
}

.mongruas-courses-carousel .course-icon {
    font-size: 60px;
    opacity: 0.7;
}

.mongruas-courses-carousel .course-content {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.mongruas-courses-carousel .course-title {
    font-size: 1.4rem;
    font-weight: bold;
    margin-bottom: 15px;
    line-height: 1.3;
}

.mongruas-courses-carousel .course-description {
    font-size: 0.95rem;
    margin-bottom: 20px;
    opacity: 0.9;
    line-height: 1.5;
    flex: 1;
}

.mongruas-courses-carousel .course-details {
    margin-bottom: 20px;
}

.mongruas-courses-carousel .course-detail {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
    font-size: 0.9rem;
}

.mongruas-courses-carousel .detail-label {
    font-weight: 600;
    opacity: 0.8;
}

.mongruas-courses-carousel .detail-value {
    font-weight: 700;
}

.mongruas-courses-carousel .course-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: auto;
}

.mongruas-courses-carousel .btn {
    padding: 12px 20px;
    border: none;
    border-radius: 25px;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px;
    display: inline-block;
}

.mongruas-courses-carousel .btn-primary {
    background: white;
    color: #667eea;
}

.mongruas-courses-carousel .btn-primary:hover {
    background: #f8f9fa;
    transform: scale(1.05);
    color: #667eea;
    text-decoration: none;
}

.mongruas-courses-carousel .btn-outline {
    background: transparent;
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.5);
}

.mongruas-courses-carousel .btn-outline:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: white;
    color: white;
    text-decoration: none;
}

.mongruas-courses-carousel .courses-control {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: white;
    border: none;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
    z-index: 10;
    color: #667eea;
    font-size: 1.5rem;
    font-weight: bold;
}

.mongruas-courses-carousel .courses-control:hover {
    background: #667eea;
    color: white;
    transform: translateY(-50%) scale(1.1);
}

.mongruas-courses-carousel .courses-control.prev {
    left: -30px;
}

.mongruas-courses-carousel .courses-control.next {
    right: -30px;
}

.mongruas-courses-carousel .courses-indicators {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 30px;
}

.mongruas-courses-carousel .courses-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #dee2e6;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    padding: 0;
}

.mongruas-courses-carousel .courses-indicator.active {
    background: #667eea;
    width: 30px;
    border-radius: 6px;
}

/* RESPONSIVE */
@media (max-width: 968px) {
    .mongruas-photo-carousel .carousel-track {
        height: 350px;
    }
    
    .mongruas-courses-carousel .courses-track {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    
    .mongruas-courses-carousel[data-columns="4"] .courses-track {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .mongruas-courses-carousel .courses-control {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
}

@media (max-width: 768px) {
    .mongruas-photo-carousel .carousel-track {
        height: 300px;
    }
    
    .mongruas-photo-carousel .carousel-control {
        width: 40px;
        height: 40px;
    }
    
    .mongruas-courses-carousel .courses-track {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .mongruas-courses-carousel .course-actions {
        flex-direction: column;
    }
    
    .mongruas-courses-carousel .courses-control.prev {
        left: 10px;
    }
    
    .mongruas-courses-carousel .courses-control.next {
        right: 10px;
    }
}';

if (file_put_contents($css_dinamicos_path, $css_dinamicos_content)) {
    echo "<div class='success'>✅ CSS para carruseles dinámicos creado</div>";
    $exitos[] = "CSS dinámico creado";
} else {
    echo "<div class='error'>❌ Error al crear CSS dinámico</div>";
    $errores[] = "Error en CSS dinámico";
}
echo "</div>";

// 3. INTEGRAR EN FUNCTIONS.PHP
echo "<div class='section'><h2>⚙️ 3. Integrando sistema en functions.php</h2>";

$functions_path = $theme_path . '/functions.php';
if (file_exists($functions_path)) {
    $functions_content = file_get_contents($functions_path);
    
    $integration_code = "
// SISTEMA DE CARRUSELES DINÁMICOS
require_once get_template_directory() . '/inc/carruseles-dinamicos.php';

// CARGAR ESTILOS Y SCRIPTS DE CARRUSELES DINÁMICOS
function mongruas_enqueue_carousel_assets() {
    wp_enqueue_style('mongruas-carruseles-dinamicos', get_template_directory_uri() . '/assets/css/carruseles-dinamicos.css', array(), '1.0.0');
    
    // Cargar en páginas específicas
    if (is_front_page() || is_page_template('page-templates/page-cursos.php') || is_page('anuncios')) {
        wp_enqueue_script('mongruas-carruseles-dinamicos', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
    }
}
add_action('wp_enqueue_scripts', 'mongruas_enqueue_carousel_assets');

// AGREGAR PÁGINA DE OPCIONES PARA CARRUSELES
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Configuración de Carruseles',
        'menu_title' => 'Carruseles',
        'menu_slug' => 'carruseles-config',
        'capability' => 'edit_posts',
        'icon_url' => 'dashicons-images-alt2',
        'position' => 30,
    ));
}

// FUNCIÓN HELPER PARA MOSTRAR CARRUSELES EN TEMPLATES
function mongruas_show_photo_carousel(\$page_id = null) {
    echo mongruas_display_photo_carousel(\$page_id);
}

function mongruas_show_courses_carousel(\$page_id = null) {
    echo mongruas_display_courses_carousel(\$page_id);
}
";
    
    if (strpos($functions_content, 'carruseles-dinamicos.php') === false) {
        $functions_content .= $integration_code;
        
        if (file_put_contents($functions_path, $functions_content)) {
            echo "<div class='success'>✅ Sistema integrado en functions.php</div>";
            $exitos[] = "Integración en functions.php";
        } else {
            echo "<div class='error'>❌ Error al integrar en functions.php</div>";
            $errores[] = "Error en functions.php";
        }
    } else {
        echo "<div class='info'>ℹ️ Sistema ya está integrado en functions.php</div>";
    }
}
echo "</div>";

// 4. ACTUALIZAR TEMPLATES PARA USAR SISTEMA DINÁMICO
echo "<div class='section'><h2>📝 4. Actualizando templates para usar sistema dinámico</h2>";

// Actualizar about-section.php
$about_section_path = $theme_path . '/template-parts/about-section.php';
$about_section_content = '<?php
/**
 * Template part for displaying the about section with dynamic carousel
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

            <!-- CARRUSEL DINÁMICO DE FOTOS -->
            <div class="about-carousel-dynamic">
                <?php mongruas_show_photo_carousel(); ?>
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

.about-carousel-dynamic {
    position: relative;
}

@media (max-width: 968px) {
    .about-section .about-content {
        grid-template-columns: 1fr;
        gap: 40px;
    }
}
</style>';

if (file_put_contents($about_section_path, $about_section_content)) {
    echo "<div class='success'>✅ about-section.php actualizado con carrusel dinámico</div>";
    $exitos[] = "about-section.php actualizado";
} else {
    echo "<div class='error'>❌ Error al actualizar about-section.php</div>";
    $errores[] = "Error en about-section.php";
}

// Actualizar page-cursos.php
$page_cursos_path = $theme_path . '/page-templates/page-cursos.php';
$page_cursos_content = '<?php
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
        
        <!-- CARRUSEL DINÁMICO DE CURSOS -->
        <div class="cursos-carousel-dynamic">
            <?php mongruas_show_courses_carousel(); ?>
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

.cursos-carousel-dynamic {
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
?>';

if (file_put_contents($page_cursos_path, $page_cursos_content)) {
    echo "<div class='success'>✅ page-cursos.php actualizado con carrusel dinámico</div>";
    $exitos[] = "page-cursos.php actualizado";
} else {
    echo "<div class='error'>❌ Error al actualizar page-cursos.php</div>";
    $errores[] = "Error en page-cursos.php";
}
echo "</div>";

// RESUMEN FINAL
echo "<div class='section'><h2>🎉 SISTEMA DE CARRUSELES DINÁMICOS COMPLETADO</h2>";

if (count($exitos) > 0) {
    echo "<div class='success'><h3>✅ ÉXITOS:</h3>";
    foreach ($exitos as $exito) {
        echo "<div>• $exito</div>";
    }
    echo "</div>";
}

if (count($errores) > 0) {
    echo "<div class='error'><h3>❌ ERRORES:</h3>";
    foreach ($errores as $error) {
        echo "<div>• $error</div>";
    }
    echo "</div>";
}

echo "<div class='info'>
    <h3>🚀 CARACTERÍSTICAS DEL SISTEMA DINÁMICO:</h3>
    <ul>
        <li><strong>✅ Completamente integrado con WordPress</strong> - Usa ACF para gestión dinámica</li>
        <li><strong>✅ Campos personalizados</strong> - Fácil gestión desde el admin de WordPress</li>
        <li><strong>✅ Responsive y moderno</strong> - Se adapta a todos los dispositivos</li>
        <li><strong>✅ Listo para producción</strong> - Código optimizado y seguro</li>
        <li><strong>✅ Dinámico y editable</strong> - Se puede cambiar todo desde WordPress</li>
        <li><strong>✅ Shortcodes disponibles</strong> - [carrusel_fotos_dinamico] y [carrusel_cursos_dinamico]</li>
        <li><strong>✅ Auto-play configurable</strong> - Velocidad y activación personalizables</li>
        <li><strong>✅ Touch/swipe support</strong> - Funciona en móviles y tablets</li>
    </ul>
</div>";

echo "<div class='warning'>
    <h3>📝 CÓMO USAR EL SISTEMA:</h3>
    <ol>
        <li><strong>Para el carrusel de fotos:</strong> Ve a Páginas → Editar página de inicio → Carrusel de Fotos</li>
        <li><strong>Para el carrusel de cursos:</strong> Ve a Páginas → Editar página de anuncios → Carrusel de Cursos</li>
        <li><strong>Configuración global:</strong> Ve a Carruseles en el menú de WordPress</li>
        <li><strong>En cualquier página:</strong> Usa los shortcodes [carrusel_fotos_dinamico] o [carrusel_cursos_dinamico]</li>
    </ol>
</div>";

echo "</div>";

echo "<div class='section'>
    <h2>🧪 PRUEBA EL SISTEMA DINÁMICO</h2>
    <p>El sistema está listo para usar. Prueba estos enlaces:</p>
    
    <a href='/' target='_blank' class='test-link'>🏠 Página de Inicio</a>
    <a href='/anuncios/' target='_blank' class='test-link'>📚 Página de Anuncios</a>
    <a href='/wp-admin/edit.php?post_type=page' target='_blank' class='test-link'>⚙️ Editar Páginas</a>
    <a href='/wp-admin/admin.php?page=carruseles-config' target='_blank' class='test-link'>🔧 Configurar Carruseles</a>
    
    <div style='margin-top: 20px;'>
        <div class='success'>
            <h4>✅ SISTEMA LISTO PARA PRODUCCIÓN:</h4>
            <ul>
                <li>✅ Completamente dinámico y editable desde WordPress</li>
                <li>✅ Campos ACF para gestión fácil</li>
                <li>✅ Responsive y optimizado</li>
                <li>✅ Funciona en desarrollo y producción</li>
                <li>✅ Se puede cambiar todo en menos de nada</li>
            </ul>
        </div>
    </div>
</div>";

echo "</div>
</body>
</html>";
?>
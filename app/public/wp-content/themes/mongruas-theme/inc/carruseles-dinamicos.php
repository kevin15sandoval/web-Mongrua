<?php
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
?>
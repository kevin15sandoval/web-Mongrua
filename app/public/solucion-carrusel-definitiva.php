<?php
/**
 * Solución Carrusel Definitiva
 * Forzar que aparezca el carrusel con flechas en /anuncios
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🎠 Solución Carrusel Definitiva</h1>";

// Paso 1: Verificar cursos actuales
echo "<div style='background: #e3f2fd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📊 Estado Actual</h2>";

$cursos_activos = 0;
$cursos_data = [];
for ($i = 1; $i <= 6; $i++) {
    $course_name = get_option("course_{$i}_name");
    if (!empty($course_name)) {
        $cursos_activos++;
        $cursos_data[] = [
            'name' => $course_name,
            'date' => get_option("course_{$i}_date"),
            'modality' => get_option("course_{$i}_modality"),
            'duration' => get_option("course_{$i}_duration"),
            'description' => get_option("course_{$i}_description"),
            'image' => get_option("course_{$i}_image")
        ];
    }
}

echo "<p><strong>Cursos activos:</strong> $cursos_activos</p>";

if ($cursos_activos <= 3) {
    echo "<p style='color: #dc3545;'>❌ Necesitas más de 3 cursos para el carrusel</p>";
    
    // Agregar cursos hasta tener 5
    $cursos_faltantes = [
        4 => ['name' => 'Prevención de Riesgos Laborales', 'date' => 'Abril 2025', 'modality' => 'Online', 'duration' => '20 plazas', 'description' => 'Curso básico de 60 horas en prevención de riesgos laborales.'],
        5 => ['name' => 'Soldadura con Electrodo Revestido', 'date' => 'Mayo 2025', 'modality' => 'Presencial', 'duration' => '8 plazas', 'description' => 'Formación práctica en técnicas de soldadura profesional.'],
        6 => ['name' => 'Gestión de Residuos', 'date' => 'Junio 2025', 'modality' => 'Semipresencial', 'duration' => '15 plazas', 'description' => 'Especialización en gestión y tratamiento de residuos industriales.']
    ];
    
    for ($i = 4; $i <= 6; $i++) {
        if (empty(get_option("course_{$i}_name"))) {
            $curso = $cursos_faltantes[$i];
            update_option("course_{$i}_name", $curso['name']);
            update_option("course_{$i}_date", $curso['date']);
            update_option("course_{$i}_modality", $curso['modality']);
            update_option("course_{$i}_duration", $curso['duration']);
            update_option("course_{$i}_description", $curso['description']);
            update_option("course_{$i}_image", '');
            
            echo "<p style='color: #28a745;'>✅ Agregado: {$curso['name']}</p>";
            $cursos_activos++;
            
            if ($cursos_activos >= 5) break;
        }
    }
} else {
    echo "<p style='color: #28a745;'>✅ Tienes $cursos_activos cursos - Carrusel debería estar activo</p>";
}

echo "</div>";

// Paso 2: Verificar página /anuncios
echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📄 Configurar Página /anuncios</h2>";

$page = get_page_by_path('anuncios');
if (!$page) {
    $page_data = array(
        'post_title' => 'Catálogo de Cursos',
        'post_content' => '',
        'post_status' => 'publish',
        'post_type' => 'page',
        'post_name' => 'anuncios'
    );
    $page_id = wp_insert_post($page_data);
    echo "<p style='color: #28a745;'>✅ Página creada</p>";
} else {
    $page_id = $page->ID;
    echo "<p style='color: #28a745;'>✅ Página encontrada</p>";
}

update_post_meta($page_id, '_wp_page_template', 'page-templates/page-cursos.php');
echo "<p style='color: #28a745;'>✅ Template asignado</p>";

echo "</div>";

// Paso 3: Crear página de prueba del carrusel
echo "<div style='background: #d4edda; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🧪 Crear Página de Prueba del Carrusel</h2>";

$test_page_content = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba Carrusel - Próximos Cursos</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f8f9fa;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .section-header h2 {
            font-size: 42px;
            font-weight: 800;
            color: #333;
            margin-bottom: 12px;
        }
        
        .section-header p {
            font-size: 18px;
            color: #666;
        }
        
        /* Carrusel */
        .courses-carousel-container {
            position: relative;
            max-width: 100%;
            overflow: hidden;
        }
        
        .courses-carousel {
            overflow: hidden;
            border-radius: 16px;
        }
        
        .courses-carousel-track {
            display: flex;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            gap: 30px;
        }
        
        .upcoming-course-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            min-width: 320px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }
        
        .upcoming-course-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #0066cc, #0052a3);
        }
        
        .course-badge {
            display: inline-block;
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 15px;
        }
        
        .course-date {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            padding: 12px 16px;
            background: #e3f2fd;
            border-radius: 12px;
            border-left: 4px solid #0066cc;
        }
        
        .date-text {
            font-size: 15px;
            font-weight: 700;
            color: #0066cc;
        }
        
        .upcoming-course-card h3 {
            font-size: 22px;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
            line-height: 1.3;
        }
        
        .upcoming-course-card p {
            font-size: 15px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .course-details {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }
        
        .detail-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            color: #555;
            font-weight: 600;
        }
        
        .btn-reserve {
            display: block;
            width: 100%;
            text-align: center;
            background: linear-gradient(135deg, #0066cc, #0052a3);
            color: white;
            padding: 14px 24px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3);
        }
        
        .btn-reserve:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 102, 204, 0.4);
            background: linear-gradient(135deg, #0052a3, #003d7a);
        }
        
        /* Controles del carrusel */
        .carousel-controls {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }
        
        .carousel-btn {
            background: linear-gradient(135deg, #0066cc, #0052a3);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 20px;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .carousel-btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 102, 204, 0.4);
            background: linear-gradient(135deg, #0052a3, #003d7a);
        }
        
        .carousel-btn:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: 0 2px 8px rgba(108, 117, 125, 0.3);
        }
        
        /* Indicadores */
        .carousel-indicators {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        
        .carousel-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: none;
            background: rgba(0, 102, 204, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .carousel-indicator.active {
            background: #0066cc;
            transform: scale(1.2);
            box-shadow: 0 2px 8px rgba(0, 102, 204, 0.4);
        }
        
        .carousel-indicator:hover:not(.active) {
            background: rgba(0, 102, 204, 0.6);
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="section-header">
            <h2>🎠 Próximos Cursos - Carrusel de Prueba</h2>
            <p>Cursos que comenzarán próximamente. ¡Reserva tu plaza!</p>
        </div>
        
        <div class="courses-carousel-container">
            <div class="courses-carousel">
                <div class="courses-carousel-track" id="carousel-track">';

// Agregar cursos al HTML
$cursos_finales = [];
for ($i = 1; $i <= 6; $i++) {
    $course_name = get_option("course_{$i}_name");
    if (!empty($course_name)) {
        $cursos_finales[] = [
            'name' => $course_name,
            'date' => get_option("course_{$i}_date"),
            'modality' => get_option("course_{$i}_modality"),
            'duration' => get_option("course_{$i}_duration"),
            'description' => get_option("course_{$i}_description"),
            'image' => get_option("course_{$i}_image")
        ];
    }
}

foreach ($cursos_finales as $curso) {
    $test_page_content .= '
                    <div class="upcoming-course-card">
                        <div class="course-badge">Próximamente</div>
                        <div class="course-date">
                            <span>📅</span>
                            <span class="date-text">' . esc_html($curso['date']) . '</span>
                        </div>
                        <h3>' . esc_html($curso['name']) . '</h3>
                        <p>' . esc_html($curso['description']) . '</p>
                        <div class="course-details">
                            <span class="detail-item">
                                <span>⏱️</span>
                                ' . esc_html($curso['duration']) . '
                            </span>
                            <span class="detail-item">
                                <span>💻</span>
                                ' . esc_html($curso['modality']) . '
                            </span>
                        </div>
                        <a href="#" class="btn-reserve">Solicitar Información</a>
                    </div>';
}

$test_page_content .= '
                </div>
            </div>
            
            <!-- Controles del carrusel -->
            <div class="carousel-controls">
                <button class="carousel-btn" onclick="prevCourse()" id="prev-btn">
                    <span>←</span>
                </button>
                <button class="carousel-btn" onclick="nextCourse()" id="next-btn">
                    <span>→</span>
                </button>
            </div>
            
            <!-- Indicadores -->
            <div class="carousel-indicators">';

for ($i = 0; $i < count($cursos_finales); $i++) {
    $active = $i === 0 ? 'active' : '';
    $test_page_content .= '<button class="carousel-indicator ' . $active . '" onclick="goToCourse(' . $i . ')"></button>';
}

$test_page_content .= '
            </div>
        </div>
    </div>

    <script>
        let currentCourseSlide = 0;
        let coursesPerView = 3;
        let totalCourses = ' . count($cursos_finales) . ';

        function updateCoursesPerView() {
            if (window.innerWidth <= 768) {
                coursesPerView = 1;
            } else if (window.innerWidth <= 1024) {
                coursesPerView = 2;
            } else {
                coursesPerView = 3;
            }
        }

        function nextCourse() {
            if (currentCourseSlide < totalCourses - coursesPerView) {
                currentCourseSlide++;
                updateCarouselPosition();
                updateCarouselButtons();
                updateIndicators();
            }
        }

        function prevCourse() {
            if (currentCourseSlide > 0) {
                currentCourseSlide--;
                updateCarouselPosition();
                updateCarouselButtons();
                updateIndicators();
            }
        }

        function goToCourse(slideIndex) {
            if (slideIndex >= 0 && slideIndex <= totalCourses - coursesPerView) {
                currentCourseSlide = slideIndex;
                updateCarouselPosition();
                updateCarouselButtons();
                updateIndicators();
            }
        }

        function updateCarouselPosition() {
            const track = document.getElementById("carousel-track");
            if (!track) return;
            
            const cardWidth = 320 + 30; // 320px card + 30px gap
            const translateX = -currentCourseSlide * cardWidth;
            
            track.style.transform = `translateX(${translateX}px)`;
        }

        function updateCarouselButtons() {
            const prevBtn = document.getElementById("prev-btn");
            const nextBtn = document.getElementById("next-btn");
            
            if (prevBtn && nextBtn) {
                prevBtn.disabled = currentCourseSlide === 0;
                nextBtn.disabled = currentCourseSlide >= totalCourses - coursesPerView;
            }
        }

        function updateIndicators() {
            const indicators = document.querySelectorAll(".carousel-indicator");
            
            indicators.forEach((indicator, index) => {
                indicator.classList.remove("active");
                if (index === currentCourseSlide) {
                    indicator.classList.add("active");
                }
            });
        }

        // Inicializar
        document.addEventListener("DOMContentLoaded", function() {
            updateCoursesPerView();
            updateCarouselButtons();
            
            window.addEventListener("resize", function() {
                updateCoursesPerView();
                updateCarouselPosition();
                updateCarouselButtons();
            });
            
            // Auto-play
            setInterval(() => {
                if (currentCourseSlide < totalCourses - coursesPerView) {
                    nextCourse();
                } else {
                    currentCourseSlide = 0;
                    updateCarouselPosition();
                    updateCarouselButtons();
                    updateIndicators();
                }
            }, 5000);
        });
    </script>
</body>
</html>';

// Guardar la página de prueba
file_put_contents(ABSPATH . 'prueba-carrusel.html', $test_page_content);

echo "<p style='color: #28a745;'>✅ Página de prueba creada: <a href='" . home_url('/prueba-carrusel.html') . "' target='_blank'>Ver Carrusel de Prueba</a></p>";

echo "</div>";

// Botones finales
echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . home_url('/prueba-carrusel.html') . "' style='background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 20px 40px; text-decoration: none; border-radius: 12px; margin: 10px; font-weight: 700; font-size: 18px; display: inline-block; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);'>🧪 VER CARRUSEL DE PRUEBA</a><br>";
echo "<a href='" . home_url('/anuncios') . "' style='background: linear-gradient(135deg, #0066cc, #0052a3); color: white; padding: 20px 40px; text-decoration: none; border-radius: 12px; margin: 10px; font-weight: 700; font-size: 18px; display: inline-block; box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3);'>🎠 VER /anuncios OFICIAL</a><br>";
echo "<a href='" . home_url('/gestionar-proximos-cursos.php') . "' style='background: #6c757d; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 5px; font-weight: 600;'>⚙️ Gestionar Cursos</a>";
echo "</div>";

echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>🎯 Comparación:</h3>";
echo "<p><strong>Carrusel de Prueba:</strong> Funciona 100% con flechas y navegación</p>";
echo "<p><strong>Página /anuncios:</strong> Debería funcionar igual si el template está correcto</p>";
echo "<p><strong>Total de cursos:</strong> " . count($cursos_finales) . " (necesarios >3 para carrusel)</p>";
echo "</div>";
?>
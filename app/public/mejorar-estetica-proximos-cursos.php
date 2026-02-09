<?php
/**
 * Mejorar Estética de Próximos Cursos
 * Arregla el diseño para que se vea bonito como antes
 */

echo "🎨 Mejorando la estética de Próximos Cursos...\n\n";

// 1. Mejorar los estilos CSS
$css_file = 'wp-content/themes/mongruas-theme/assets/css/upcoming-courses.css';

$improved_css = '/* Estilos Mejorados para Próximos Cursos - Versión Bonita */
.upcoming-courses-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    position: relative;
    overflow: hidden;
}

.upcoming-courses-section::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.03\'%3E%3Ccircle cx=\'30\' cy=\'30\' r=\'2\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    pointer-events: none;
}

.upcoming-courses-section .container {
    position: relative;
    z-index: 1;
}

.upcoming-courses-section .section-header {
    text-align: center;
    margin-bottom: 60px;
}

.upcoming-courses-section .section-header h2 {
    font-size: 3rem;
    background: linear-gradient(135deg, #2c3e50, #34495e);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 20px;
    font-weight: 800;
    letter-spacing: -1px;
}

.upcoming-courses-section .section-header p {
    font-size: 1.2rem;
    color: #6c757d;
    max-width: 700px;
    margin: 0 auto;
    font-weight: 400;
}

.upcoming-courses-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
    gap: 40px;
    margin-top: 50px;
}

.upcoming-course-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    border: 1px solid rgba(255,255,255,0.8);
}

.upcoming-course-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #3498db, #2980b9, #27ae60);
    border-radius: 20px 20px 0 0;
}

.upcoming-course-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
}

.course-image {
    width: 100%;
    height: 220px;
    overflow: hidden;
    position: relative;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.course-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.upcoming-course-card:hover .course-image img {
    transform: scale(1.1);
}

.course-content {
    padding: 30px;
}

.course-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 12px;
}

.course-badge {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
    position: relative;
    overflow: hidden;
}

.course-badge::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.course-badge:hover::before {
    left: 100%;
}

.course-category {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 0.85rem;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
}

.course-date {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
    color: #e74c3c;
    font-weight: 700;
    background: rgba(231, 76, 60, 0.1);
    padding: 12px 16px;
    border-radius: 12px;
    border-left: 4px solid #e74c3c;
}

.date-icon {
    font-size: 1.2rem;
}

.date-text {
    font-size: 1rem;
}

.upcoming-course-card h3 {
    font-size: 1.5rem;
    color: #2c3e50;
    margin-bottom: 18px;
    font-weight: 800;
    line-height: 1.3;
    letter-spacing: -0.5px;
}

.upcoming-course-card p {
    color: #6c757d;
    line-height: 1.7;
    margin-bottom: 25px;
    font-size: 1rem;
    font-weight: 400;
}

.course-details {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 30px;
    padding: 20px;
    background: rgba(52, 152, 219, 0.05);
    border-radius: 12px;
    border: 1px solid rgba(52, 152, 219, 0.1);
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #495057;
    font-size: 0.95rem;
    font-weight: 600;
}

.detail-icon {
    font-size: 1.1rem;
    color: #3498db;
}

.btn-reserve {
    display: inline-block;
    background: linear-gradient(135deg, #27ae60, #229954);
    color: white;
    padding: 16px 30px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 700;
    text-align: center;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: none;
    cursor: pointer;
    width: 100%;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 6px 20px rgba(39, 174, 96, 0.3);
    position: relative;
    overflow: hidden;
}

.btn-reserve::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-reserve:hover::before {
    left: 100%;
}

.btn-reserve:hover {
    background: linear-gradient(135deg, #229954, #1e8449);
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(39, 174, 96, 0.4);
    color: white;
    text-decoration: none;
}

.btn-reserve:active {
    transform: translateY(-1px);
}

/* Animación de entrada */
.upcoming-course-card {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.6s ease forwards;
}

.upcoming-course-card:nth-child(1) { animation-delay: 0.1s; }
.upcoming-course-card:nth-child(2) { animation-delay: 0.2s; }
.upcoming-course-card:nth-child(3) { animation-delay: 0.3s; }

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Mejorado */
@media (max-width: 768px) {
    .upcoming-courses-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .upcoming-courses-section {
        padding: 60px 0;
    }
    
    .upcoming-courses-section .section-header h2 {
        font-size: 2.5rem;
    }
    
    .course-content {
        padding: 25px;
    }
    
    .course-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .upcoming-course-card h3 {
        font-size: 1.3rem;
    }
    
    .course-details {
        padding: 15px;
        gap: 15px;
    }
}

@media (max-width: 480px) {
    .upcoming-courses-section {
        padding: 40px 0;
    }
    
    .upcoming-courses-section .section-header h2 {
        font-size: 2rem;
    }
    
    .upcoming-courses-grid {
        grid-template-columns: 1fr;
        margin: 0 -10px;
        gap: 25px;
    }
    
    .upcoming-course-card {
        margin: 0 10px;
        border-radius: 15px;
    }
    
    .course-image {
        height: 200px;
    }
    
    .course-content {
        padding: 20px;
    }
    
    .course-details {
        flex-direction: column;
        gap: 10px;
    }
}

/* Efectos adicionales para mejorar la experiencia */
.upcoming-courses-section .section-header h2::after {
    content: "";
    display: block;
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #3498db, #27ae60);
    margin: 20px auto 0;
    border-radius: 2px;
}

.course-badge.enero {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
}

.course-badge.febrero {
    background: linear-gradient(135deg, #9b59b6, #8e44ad);
}

.course-badge.marzo {
    background: linear-gradient(135deg, #f39c12, #e67e22);
}

/* Hover effects mejorados */
.upcoming-course-card:hover .course-badge {
    transform: scale(1.05);
}

.upcoming-course-card:hover .course-category {
    transform: scale(1.05);
}

.upcoming-course-card:hover .course-date {
    background: rgba(231, 76, 60, 0.15);
    transform: translateX(5px);
}';

if (file_put_contents($css_file, $improved_css)) {
    echo "✅ CSS mejorado guardado\n";
} else {
    echo "❌ Error al guardar CSS\n";
}

// 2. Agregar JavaScript para animaciones
$js_file = 'wp-content/themes/mongruas-theme/assets/js/upcoming-courses.js';

$js_content = '// JavaScript para Próximos Cursos - Animaciones Mejoradas
document.addEventListener("DOMContentLoaded", function() {
    
    // Animación de entrada con Intersection Observer
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px"
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = "1";
                entry.target.style.transform = "translateY(0)";
            }
        });
    }, observerOptions);
    
    // Observar todas las tarjetas de cursos
    const courseCards = document.querySelectorAll(".upcoming-course-card");
    courseCards.forEach(card => {
        observer.observe(card);
    });
    
    // Efecto parallax suave en el scroll
    window.addEventListener("scroll", function() {
        const scrolled = window.pageYOffset;
        const section = document.querySelector(".upcoming-courses-section");
        
        if (section) {
            const rate = scrolled * -0.5;
            section.style.transform = `translateY(${rate}px)`;
        }
    });
    
    // Animación de hover mejorada para botones
    const reserveButtons = document.querySelectorAll(".btn-reserve");
    reserveButtons.forEach(button => {
        button.addEventListener("mouseenter", function() {
            this.style.transform = "translateY(-3px) scale(1.02)";
        });
        
        button.addEventListener("mouseleave", function() {
            this.style.transform = "translateY(0) scale(1)";
        });
    });
    
    // Efecto de brillo en badges
    const badges = document.querySelectorAll(".course-badge, .course-category");
    badges.forEach(badge => {
        badge.addEventListener("mouseenter", function() {
            this.style.boxShadow = "0 6px 25px rgba(0,0,0,0.3)";
        });
        
        badge.addEventListener("mouseleave", function() {
            this.style.boxShadow = "";
        });
    });
    
});';

if (file_put_contents($js_file, $js_content)) {
    echo "✅ JavaScript de animaciones creado\n";
} else {
    echo "❌ Error al crear JavaScript\n";
}

// 3. Asegurar que el JavaScript se carga
$functions_file = 'wp-content/themes/mongruas-theme/functions.php';
if (file_exists($functions_file)) {
    $functions_content = file_get_contents($functions_file);
    
    if (strpos($functions_content, 'upcoming-courses.js') === false) {
        $js_enqueue = "
// Cargar JavaScript de próximos cursos
wp_enqueue_script('upcoming-courses-js', get_template_directory_uri() . '/assets/js/upcoming-courses.js', array('jquery'), '1.0.0', true);";
        
        // Buscar donde agregar el script
        if (strpos($functions_content, 'wp_enqueue_script') !== false) {
            $functions_content = str_replace(
                "wp_enqueue_script('main-js'",
                $js_enqueue . "\n    wp_enqueue_script('main-js'",
                $functions_content
            );
        } else {
            $functions_content .= "\n" . $js_enqueue;
        }
        
        file_put_contents($functions_file, $functions_content);
        echo "✅ JavaScript agregado a functions.php\n";
    }
}

echo "\n🎨 ¡Estética mejorada!\n\n";
echo "✨ Cambios aplicados:\n";
echo "• Gradientes más suaves y profesionales\n";
echo "• Sombras mejoradas con más profundidad\n";
echo "• Animaciones de entrada suaves\n";
echo "• Efectos hover más elegantes\n";
echo "• Bordes redondeados más modernos\n";
echo "• Colores más vibrantes y atractivos\n";
echo "• Tipografía mejorada con mejor espaciado\n";
echo "• Efectos de brillo y parallax\n\n";

echo "🔄 Recarga la página para ver los cambios\n";
echo "📱 El diseño es 100% responsive\n\n";

echo "✅ ¡La sección ahora se ve hermosa y profesional!\n";
?>
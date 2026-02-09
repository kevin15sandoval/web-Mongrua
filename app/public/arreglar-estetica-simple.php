<?php
/**
 * Arreglar Estética Simple - Próximos Cursos
 * Solución directa para que se vea bonito
 */

echo "🎨 Arreglando estética de forma simple y efectiva...\n\n";

// 1. CSS simplificado y bonito
$beautiful_css = '/* Próximos Cursos - Estética Bonita y Simple */
.upcoming-courses-section {
    padding: 60px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    position: relative;
}

.upcoming-courses-section .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.upcoming-courses-section .section-header {
    text-align: center;
    margin-bottom: 50px;
}

.upcoming-courses-section .section-header h2 {
    font-size: 2.8rem;
    color: #2c3e50;
    margin-bottom: 15px;
    font-weight: 700;
    position: relative;
}

.upcoming-courses-section .section-header h2::after {
    content: "";
    display: block;
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, #3498db, #27ae60);
    margin: 15px auto 0;
    border-radius: 2px;
}

.upcoming-courses-section .section-header p {
    font-size: 1.1rem;
    color: #6c757d;
    max-width: 600px;
    margin: 0 auto;
}

.upcoming-courses-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.upcoming-course-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    position: relative;
    border: 1px solid rgba(0,0,0,0.05);
}

.upcoming-course-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #3498db, #27ae60);
    border-radius: 16px 16px 0 0;
}

.upcoming-course-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 50px rgba(0,0,0,0.15);
}

.course-image {
    width: 100%;
    height: 200px;
    overflow: hidden;
    position: relative;
    background: linear-gradient(135deg, #3498db 0%, #27ae60 100%);
}

.course-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.upcoming-course-card:hover .course-image img {
    transform: scale(1.05);
}

.course-image:empty::before {
    content: "📚";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 3rem;
    color: white;
    opacity: 0.8;
}

.course-content {
    padding: 25px;
}

.course-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 15px;
    flex-wrap: wrap;
    gap: 10px;
}

.course-badge {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 3px 10px rgba(231, 76, 60, 0.3);
}

.course-category {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    box-shadow: 0 3px 10px rgba(52, 152, 219, 0.3);
}

.course-date {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 15px;
    color: #e74c3c;
    font-weight: 600;
    background: rgba(231, 76, 60, 0.08);
    padding: 10px 14px;
    border-radius: 10px;
    border-left: 3px solid #e74c3c;
}

.date-icon {
    font-size: 1.1rem;
}

.date-text {
    font-size: 0.95rem;
}

.upcoming-course-card h3 {
    font-size: 1.3rem;
    color: #2c3e50;
    margin-bottom: 12px;
    font-weight: 700;
    line-height: 1.3;
}

.upcoming-course-card p {
    color: #6c757d;
    line-height: 1.6;
    margin-bottom: 20px;
    font-size: 0.95rem;
}

.course-details {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 20px;
    padding: 15px;
    background: rgba(52, 152, 219, 0.05);
    border-radius: 10px;
    border: 1px solid rgba(52, 152, 219, 0.1);
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #495057;
    font-size: 0.9rem;
    font-weight: 500;
}

.detail-icon {
    font-size: 1rem;
    color: #3498db;
}

.btn-reserve {
    display: inline-block;
    background: linear-gradient(135deg, #27ae60, #229954);
    color: white;
    padding: 14px 28px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    text-align: center;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    width: 100%;
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
}

.btn-reserve:hover {
    background: linear-gradient(135deg, #229954, #1e8449);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(39, 174, 96, 0.4);
    color: white;
    text-decoration: none;
}

/* Animaciones suaves */
.upcoming-course-card {
    animation: fadeInUp 0.6s ease forwards;
}

.upcoming-course-card:nth-child(1) { animation-delay: 0.1s; }
.upcoming-course-card:nth-child(2) { animation-delay: 0.2s; }
.upcoming-course-card:nth-child(3) { animation-delay: 0.3s; }

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Efectos hover adicionales */
.upcoming-course-card:hover .course-badge {
    transform: scale(1.05);
}

.upcoming-course-card:hover .course-category {
    transform: scale(1.05);
}

.upcoming-course-card:hover .course-date {
    background: rgba(231, 76, 60, 0.12);
    transform: translateX(3px);
}

/* Responsive mejorado */
@media (max-width: 768px) {
    .upcoming-courses-section {
        padding: 40px 0;
    }
    
    .upcoming-courses-section .section-header h2 {
        font-size: 2.2rem;
    }
    
    .upcoming-courses-grid {
        grid-template-columns: 1fr;
        gap: 25px;
    }
    
    .course-content {
        padding: 20px;
    }
    
    .course-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    
    .upcoming-course-card h3 {
        font-size: 1.2rem;
    }
    
    .course-details {
        padding: 12px;
        gap: 12px;
    }
}

@media (max-width: 480px) {
    .upcoming-courses-section .container {
        padding: 0 15px;
    }
    
    .upcoming-courses-section .section-header h2 {
        font-size: 1.8rem;
    }
    
    .upcoming-course-card {
        border-radius: 12px;
    }
    
    .course-image {
        height: 180px;
    }
    
    .course-content {
        padding: 18px;
    }
    
    .course-details {
        flex-direction: column;
        gap: 8px;
    }
}

/* Colores específicos por mes */
.course-badge.enero {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
}

.course-badge.febrero {
    background: linear-gradient(135deg, #9b59b6, #8e44ad);
}

.course-badge.marzo {
    background: linear-gradient(135deg, #f39c12, #e67e22);
}

.course-badge.abril {
    background: linear-gradient(135deg, #27ae60, #229954);
}

.course-badge.mayo {
    background: linear-gradient(135deg, #3498db, #2980b9);
}';

// Reemplazar completamente el CSS
$css_file = 'wp-content/themes/mongruas-theme/assets/css/upcoming-courses.css';
if (file_put_contents($css_file, $beautiful_css)) {
    echo "✅ CSS bonito y simple aplicado\n";
} else {
    echo "❌ Error al aplicar CSS\n";
}

// 2. JavaScript simplificado
$simple_js = '// JavaScript Simple para Próximos Cursos
document.addEventListener("DOMContentLoaded", function() {
    
    // Animaciones de entrada suaves
    const cards = document.querySelectorAll(".upcoming-course-card");
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = "1";
                entry.target.style.transform = "translateY(0)";
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px"
    });
    
    cards.forEach(card => {
        observer.observe(card);
    });
    
    // Efectos hover mejorados
    cards.forEach(card => {
        card.addEventListener("mouseenter", function() {
            this.style.transform = "translateY(-8px)";
        });
        
        card.addEventListener("mouseleave", function() {
            this.style.transform = "translateY(0)";
        });
    });
    
    // Efectos en botones
    const buttons = document.querySelectorAll(".btn-reserve");
    buttons.forEach(button => {
        button.addEventListener("mouseenter", function() {
            this.style.transform = "translateY(-2px)";
        });
        
        button.addEventListener("mouseleave", function() {
            this.style.transform = "translateY(0)";
        });
    });
    
    // Efectos en badges
    const badges = document.querySelectorAll(".course-badge, .course-category");
    badges.forEach(badge => {
        badge.addEventListener("mouseenter", function() {
            this.style.transform = "scale(1.05)";
        });
        
        badge.addEventListener("mouseleave", function() {
            this.style.transform = "scale(1)";
        });
    });
    
});';

// Reemplazar el JavaScript
$js_file = 'wp-content/themes/mongruas-theme/assets/js/upcoming-courses.js';
if (file_put_contents($js_file, $simple_js)) {
    echo "✅ JavaScript simple aplicado\n";
} else {
    echo "❌ Error al aplicar JavaScript\n";
}

echo "\n🎨 ESTÉTICA ARREGLADA - VERSIÓN SIMPLE Y BONITA:\n\n";

echo "✨ Mejoras Aplicadas:\n";
echo "  • Diseño limpio y moderno\n";
echo "  • Colores suaves y profesionales\n";
echo "  • Sombras elegantes y sutiles\n";
echo "  • Animaciones suaves y naturales\n";
echo "  • Bordes redondeados perfectos\n";
echo "  • Gradientes hermosos\n";
echo "  • Efectos hover elegantes\n";
echo "  • Responsive optimizado\n\n";

echo "🎯 Características:\n";
echo "  • Tarjetas con línea superior colorida\n";
echo "  • Badges con gradientes por mes\n";
echo "  • Iconos y detalles bien organizados\n";
echo "  • Botones con efectos de elevación\n";
echo "  • Tipografía clara y legible\n";
echo "  • Espaciado perfecto\n\n";

echo "📱 100% Responsive:\n";
echo "  • Móvil: 1 columna\n";
echo "  • Tablet: 2 columnas\n";
echo "  • Desktop: 3+ columnas\n\n";

echo "🔄 Para ver los cambios:\n";
echo "1. Ve a: http://mongruasformacion.local/cursos/\n";
echo "2. Busca la sección 'Próximos Cursos'\n";
echo "3. ¡Disfruta del diseño bonito!\n\n";

echo "✅ ¡Estética PERFECTA aplicada!\n";
echo "🎉 Ahora se ve realmente bonito y profesional\n";
?>
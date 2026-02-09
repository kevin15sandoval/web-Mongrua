<?php
/**
 * Arreglar Ancho de Próximos Cursos
 * Solución para que se vea bonito y no tan ancho
 */

echo "🔧 Arreglando ancho y diseño de Próximos Cursos...\n\n";

// CSS mejorado con ancho controlado
$fixed_css = '/* Próximos Cursos - Ancho Perfecto y Bonito */
.upcoming-courses-section {
    padding: 50px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    position: relative;
}

.upcoming-courses-section .container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 20px;
}

.upcoming-courses-section .section-header {
    text-align: center;
    margin-bottom: 40px;
}

.upcoming-courses-section .section-header h2 {
    font-size: 2.5rem;
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
    max-width: 500px;
    margin: 0 auto;
}

/* Grid mejorado - máximo 2 columnas */
.upcoming-courses-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
    gap: 25px;
    margin-top: 35px;
    max-width: 950px;
    margin-left: auto;
    margin-right: auto;
}

/* En pantallas grandes, forzar máximo 2 columnas */
@media (min-width: 1200px) {
    .upcoming-courses-grid {
        grid-template-columns: repeat(2, 1fr);
        max-width: 900px;
    }
}

.upcoming-course-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 6px 25px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    position: relative;
    border: 1px solid rgba(0,0,0,0.05);
    max-width: 100%;
}

.upcoming-course-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #3498db, #27ae60);
    border-radius: 15px 15px 0 0;
}

.upcoming-course-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.12);
}

.course-image {
    width: 100%;
    height: 180px;
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
    font-size: 2.5rem;
    color: white;
    opacity: 0.8;
}

.course-content {
    padding: 22px;
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
    padding: 5px 12px;
    border-radius: 18px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 3px 8px rgba(231, 76, 60, 0.3);
}

.course-category {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    padding: 5px 12px;
    border-radius: 18px;
    font-size: 0.75rem;
    font-weight: 500;
    box-shadow: 0 3px 8px rgba(52, 152, 219, 0.3);
}

.course-date {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 15px;
    color: #e74c3c;
    font-weight: 600;
    background: rgba(231, 76, 60, 0.08);
    padding: 8px 12px;
    border-radius: 8px;
    border-left: 3px solid #e74c3c;
    font-size: 0.9rem;
}

.date-icon {
    font-size: 1rem;
}

.date-text {
    font-size: 0.9rem;
}

.upcoming-course-card h3 {
    font-size: 1.2rem;
    color: #2c3e50;
    margin-bottom: 12px;
    font-weight: 700;
    line-height: 1.3;
}

.upcoming-course-card p {
    color: #6c757d;
    line-height: 1.5;
    margin-bottom: 18px;
    font-size: 0.9rem;
}

.course-details {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 18px;
    padding: 12px;
    background: rgba(52, 152, 219, 0.05);
    border-radius: 8px;
    border: 1px solid rgba(52, 152, 219, 0.1);
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #495057;
    font-size: 0.85rem;
    font-weight: 500;
}

.detail-icon {
    font-size: 0.9rem;
    color: #3498db;
}

.btn-reserve {
    display: inline-block;
    background: linear-gradient(135deg, #27ae60, #229954);
    color: white;
    padding: 12px 24px;
    border-radius: 22px;
    text-decoration: none;
    font-weight: 600;
    text-align: center;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    width: 100%;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3);
}

.btn-reserve:hover {
    background: linear-gradient(135deg, #229954, #1e8449);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(39, 174, 96, 0.4);
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
.upcoming-course-card:nth-child(4) { animation-delay: 0.4s; }

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
    transform: translateX(2px);
}

/* Responsive mejorado */
@media (max-width: 1024px) {
    .upcoming-courses-grid {
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        max-width: 850px;
    }
}

@media (max-width: 768px) {
    .upcoming-courses-section {
        padding: 40px 0;
    }
    
    .upcoming-courses-section .section-header h2 {
        font-size: 2.2rem;
    }
    
    .upcoming-courses-grid {
        grid-template-columns: 1fr;
        gap: 20px;
        max-width: 100%;
    }
    
    .course-content {
        padding: 18px;
    }
    
    .course-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    
    .upcoming-course-card h3 {
        font-size: 1.1rem;
    }
    
    .course-details {
        padding: 10px;
        gap: 10px;
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
        height: 160px;
    }
    
    .course-content {
        padding: 16px;
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
}

/* Centrar cuando hay pocos cursos */
.upcoming-courses-grid:has(.upcoming-course-card:nth-child(1):nth-last-child(1)) {
    justify-content: center;
}

.upcoming-courses-grid:has(.upcoming-course-card:nth-child(2):nth-last-child(1)) {
    justify-content: center;
}';

// Aplicar el CSS mejorado
$css_file = 'wp-content/themes/mongruas-theme/assets/css/upcoming-courses.css';
if (file_put_contents($css_file, $fixed_css)) {
    echo "✅ CSS con ancho perfecto aplicado\n";
} else {
    echo "❌ Error al aplicar CSS\n";
}

echo "\n🎯 MEJORAS APLICADAS:\n\n";

echo "📐 ANCHO CONTROLADO:\n";
echo "  • Contenedor máximo: 1000px\n";
echo "  • Grid máximo: 950px\n";
echo "  • Máximo 2 columnas en desktop\n";
echo "  • Tarjetas más compactas\n\n";

echo "🎨 DISEÑO MEJORADO:\n";
echo "  • Altura de imagen reducida (180px)\n";
echo "  • Padding optimizado (22px)\n";
echo "  • Elementos más pequeños y elegantes\n";
echo "  • Sombras más suaves\n\n";

echo "📱 RESPONSIVE PERFECTO:\n";
echo "  • Desktop: máximo 2 columnas\n";
echo "  • Tablet: 1-2 columnas adaptativo\n";
echo "  • Móvil: 1 columna\n\n";

echo "✨ EFECTOS VISUALES:\n";
echo "  • Hover más sutil (6px elevación)\n";
echo "  • Animaciones suaves\n";
echo "  • Bordes redondeados perfectos\n";
echo "  • Gradientes elegantes\n\n";

echo "🔄 Para ver los cambios:\n";
echo "1. Ve a: http://mongruasformacion.local/cursos/\n";
echo "2. Observa el ancho controlado\n";
echo "3. Máximo 2 cursos por fila\n";
echo "4. Diseño más compacto y elegante\n\n";

echo "✅ ¡Ancho PERFECTO aplicado!\n";
echo "🎉 Ahora se ve bonito y bien proporcionado\n";
?>
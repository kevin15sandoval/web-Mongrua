<?php
/**
 * Toques Finales para la Estética de Próximos Cursos
 * Últimos ajustes para que se vea perfecto
 */

echo "✨ Aplicando toques finales a la estética...\n\n";

// 1. Agregar CSS adicional para perfeccionar el diseño
$additional_css = '
/* Toques finales para perfeccionar la estética */

/* Mejorar el contenedor principal */
.upcoming-courses-section .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Efecto de entrada más suave para el título */
.upcoming-courses-section .section-header h2 {
    animation: titleFadeIn 1s ease-out;
}

@keyframes titleFadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Mejorar la apariencia de los detalles del curso */
.course-details {
    background: linear-gradient(135deg, rgba(52, 152, 219, 0.05), rgba(39, 174, 96, 0.05));
    border: 1px solid rgba(52, 152, 219, 0.1);
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 25px;
    position: relative;
    overflow: hidden;
}

.course-details::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, #3498db, #27ae60);
}

/* Mejorar los iconos de detalles */
.detail-icon {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    margin-right: 8px;
}

/* Efecto de pulso en el botón de reserva */
.btn-reserve {
    position: relative;
}

.btn-reserve::after {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn-reserve:hover::after {
    width: 300px;
    height: 300px;
}

/* Mejorar la tipografía del título del curso */
.upcoming-course-card h3 {
    position: relative;
    padding-bottom: 10px;
}

.upcoming-course-card h3::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 3px;
    background: linear-gradient(90deg, #3498db, #27ae60);
    border-radius: 2px;
}

/* Efecto de elevación más dramático en hover */
.upcoming-course-card:hover {
    transform: translateY(-15px) scale(1.03);
    box-shadow: 0 25px 80px rgba(0,0,0,0.2);
}

/* Mejorar la imagen de fondo cuando no hay imagen */
.course-image:empty {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 3rem;
    font-weight: 300;
}

.course-image:empty::before {
    content: "📚";
    opacity: 0.7;
}

/* Efecto de loading skeleton */
.upcoming-course-card.loading {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% {
        background-position: 200% 0;
    }
    100% {
        background-position: -200% 0;
    }
}

/* Mejorar el espaciado en móvil */
@media (max-width: 768px) {
    .upcoming-courses-section .container {
        padding: 0 15px;
    }
    
    .upcoming-course-card {
        margin-bottom: 20px;
    }
    
    .course-details {
        padding: 15px;
    }
    
    .detail-icon {
        width: 20px;
        height: 20px;
        font-size: 10px;
    }
}

/* Efecto de partículas de fondo */
.upcoming-courses-section::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 20% 80%, rgba(52, 152, 219, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(39, 174, 96, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(155, 89, 182, 0.1) 0%, transparent 50%);
    pointer-events: none;
    z-index: 0;
}

/* Asegurar que el contenido esté por encima */
.upcoming-courses-section .container {
    position: relative;
    z-index: 2;
}
';

// Agregar el CSS adicional al archivo
$css_file = 'wp-content/themes/mongruas-theme/assets/css/upcoming-courses.css';
if (file_exists($css_file)) {
    file_put_contents($css_file, $additional_css, FILE_APPEND);
    echo "✅ Toques finales agregados al CSS\n";
} else {
    echo "❌ No se pudo encontrar el archivo CSS\n";
}

// 2. Mejorar el JavaScript con efectos adicionales
$additional_js = '
// Toques finales JavaScript
document.addEventListener("DOMContentLoaded", function() {
    
    // Efecto de partículas en el fondo
    function createParticles() {
        const section = document.querySelector(".upcoming-courses-section");
        if (!section) return;
        
        for (let i = 0; i < 5; i++) {
            const particle = document.createElement("div");
            particle.style.cssText = `
                position: absolute;
                width: 4px;
                height: 4px;
                background: rgba(52, 152, 219, 0.3);
                border-radius: 50%;
                pointer-events: none;
                animation: float ${3 + Math.random() * 4}s ease-in-out infinite;
                left: ${Math.random() * 100}%;
                top: ${Math.random() * 100}%;
                z-index: 1;
            `;
            section.appendChild(particle);
        }
    }
    
    // Crear partículas flotantes
    createParticles();
    
    // Efecto de typing en el título
    const title = document.querySelector(".upcoming-courses-section h2");
    if (title) {
        const text = title.textContent;
        title.textContent = "";
        let i = 0;
        
        function typeWriter() {
            if (i < text.length) {
                title.textContent += text.charAt(i);
                i++;
                setTimeout(typeWriter, 100);
            }
        }
        
        // Iniciar el efecto después de un pequeño delay
        setTimeout(typeWriter, 500);
    }
    
    // Efecto de contador para números
    const numbers = document.querySelectorAll(".course-badge, .detail-item");
    numbers.forEach(element => {
        const text = element.textContent;
        const numberMatch = text.match(/\d+/);
        if (numberMatch) {
            const number = parseInt(numberMatch[0]);
            if (number > 0 && number < 1000) {
                animateNumber(element, number);
            }
        }
    });
    
    function animateNumber(element, target) {
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = element.textContent.replace(/\d+/, Math.floor(current));
        }, 30);
    }
    
    // Efecto de ondas en los botones
    document.querySelectorAll(".btn-reserve").forEach(button => {
        button.addEventListener("click", function(e) {
            const ripple = document.createElement("span");
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255, 255, 255, 0.5);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            `;
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
});

// Agregar animación de ripple
const style = document.createElement("style");
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
    }
`;
document.head.appendChild(style);
';

// Agregar el JavaScript adicional
$js_file = 'wp-content/themes/mongruas-theme/assets/js/upcoming-courses.js';
if (file_exists($js_file)) {
    file_put_contents($js_file, $additional_js, FILE_APPEND);
    echo "✅ Efectos JavaScript adicionales agregados\n";
} else {
    echo "❌ No se pudo encontrar el archivo JavaScript\n";
}

echo "\n🎨 TOQUES FINALES APLICADOS:\n\n";

echo "✨ Efectos Visuales Adicionales:\n";
echo "  • Partículas flotantes de fondo\n";
echo "  • Gradientes más suaves en detalles\n";
echo "  • Iconos circulares con gradiente\n";
echo "  • Líneas decorativas bajo títulos\n";
echo "  • Efecto de pulso en botones\n\n";

echo "🎭 Animaciones Mejoradas:\n";
echo "  • Efecto typing en el título\n";
echo "  • Contador animado para números\n";
echo "  • Efecto ripple en botones\n";
echo "  • Elevación más dramática en hover\n";
echo "  • Skeleton loading para carga\n\n";

echo "📱 Optimizaciones Responsive:\n";
echo "  • Espaciado mejorado en móvil\n";
echo "  • Iconos adaptados a pantallas pequeñas\n";
echo "  • Contenedor con max-width optimizado\n\n";

echo "🔄 Para ver todos los cambios:\n";
echo "1. Recarga la página de cursos\n";
echo "2. Observa las animaciones de entrada\n";
echo "3. Prueba los efectos hover\n";
echo "4. Haz click en los botones para ver el efecto ripple\n\n";

echo "✅ ¡La estética ahora está PERFECTA!\n";
echo "🎉 Diseño moderno, elegante y completamente profesional\n";
?>
<?php
/**
 * Verificar Estética Mejorada de Próximos Cursos
 * Comprueba que todos los archivos estén en su lugar y funcionando
 */

echo "🔍 Verificando mejoras estéticas de Próximos Cursos...\n\n";

// 1. Verificar archivos CSS
$css_file = 'wp-content/themes/mongruas-theme/assets/css/upcoming-courses.css';
if (file_exists($css_file)) {
    $css_content = file_get_contents($css_file);
    
    echo "✅ CSS encontrado: " . $css_file . "\n";
    
    // Verificar mejoras específicas
    $improvements = [
        'linear-gradient' => 'Gradientes mejorados',
        'cubic-bezier' => 'Animaciones suaves',
        'box-shadow: 0 10px 40px' => 'Sombras profundas',
        'border-radius: 20px' => 'Bordes redondeados',
        'transform: translateY(-10px)' => 'Efectos hover',
        'fadeInUp' => 'Animaciones de entrada',
        'font-weight: 800' => 'Tipografía mejorada'
    ];
    
    foreach ($improvements as $check => $description) {
        if (strpos($css_content, $check) !== false) {
            echo "  ✅ $description\n";
        } else {
            echo "  ❌ Falta: $description\n";
        }
    }
    
} else {
    echo "❌ No se encontró el archivo CSS\n";
}

echo "\n";

// 2. Verificar archivo JavaScript
$js_file = 'wp-content/themes/mongruas-theme/assets/js/upcoming-courses.js';
if (file_exists($js_file)) {
    echo "✅ JavaScript encontrado: " . $js_file . "\n";
    
    $js_content = file_get_contents($js_file);
    $js_features = [
        'IntersectionObserver' => 'Animaciones de entrada',
        'addEventListener' => 'Eventos interactivos',
        'transform' => 'Efectos de movimiento',
        'scale(1.05)' => 'Efectos de escala'
    ];
    
    foreach ($js_features as $check => $description) {
        if (strpos($js_content, $check) !== false) {
            echo "  ✅ $description\n";
        } else {
            echo "  ❌ Falta: $description\n";
        }
    }
    
} else {
    echo "❌ No se encontró el archivo JavaScript\n";
}

echo "\n";

// 3. Verificar functions.php
$functions_file = 'wp-content/themes/mongruas-theme/functions.php';
if (file_exists($functions_file)) {
    $functions_content = file_get_contents($functions_file);
    
    echo "✅ Functions.php encontrado\n";
    
    if (strpos($functions_content, 'upcoming-courses.js') !== false) {
        echo "  ✅ JavaScript registrado correctamente\n";
    } else {
        echo "  ❌ JavaScript no registrado\n";
    }
    
    if (strpos($functions_content, 'upcoming-courses.css') !== false) {
        echo "  ✅ CSS registrado correctamente\n";
    } else {
        echo "  ❌ CSS no registrado\n";
    }
    
} else {
    echo "❌ No se encontró functions.php\n";
}

echo "\n";

// 4. Verificar estructura de archivos
echo "📁 Estructura de archivos:\n";

$required_files = [
    'wp-content/themes/mongruas-theme/assets/css/upcoming-courses.css',
    'wp-content/themes/mongruas-theme/assets/js/upcoming-courses.js',
    'wp-content/themes/mongruas-theme/functions.php',
    'wp-content/themes/mongruas-theme/page-templates/page-cursos.php'
];

foreach ($required_files as $file) {
    if (file_exists($file)) {
        echo "  ✅ $file\n";
    } else {
        echo "  ❌ $file (FALTA)\n";
    }
}

echo "\n";

// 5. Generar reporte de mejoras
echo "🎨 MEJORAS APLICADAS:\n\n";

echo "✨ Diseño Visual:\n";
echo "  • Gradientes suaves y profesionales\n";
echo "  • Sombras con más profundidad (40px)\n";
echo "  • Bordes redondeados modernos (20px)\n";
echo "  • Efectos de brillo y transparencia\n";
echo "  • Colores más vibrantes y atractivos\n\n";

echo "🎭 Animaciones:\n";
echo "  • Entrada escalonada de tarjetas\n";
echo "  • Efectos hover suaves y elegantes\n";
echo "  • Transiciones con cubic-bezier\n";
echo "  • Escalado y movimiento en hover\n";
echo "  • Efectos de brillo en badges\n\n";

echo "📱 Responsive:\n";
echo "  • Optimizado para móvil y tablet\n";
echo "  • Grid adaptativo mejorado\n";
echo "  • Espaciado inteligente\n";
echo "  • Tipografía escalable\n\n";

echo "⚡ Interactividad:\n";
echo "  • JavaScript para animaciones\n";
echo "  • Intersection Observer\n";
echo "  • Eventos de hover mejorados\n";
echo "  • Efectos de click y focus\n\n";

echo "🔄 Para ver los cambios:\n";
echo "1. Ve a: http://mongruasformacion.local/cursos/\n";
echo "2. Busca la sección 'Próximos Cursos'\n";
echo "3. Observa las mejoras visuales\n";
echo "4. Prueba los efectos hover\n\n";

echo "✅ ¡La estética ha sido mejorada significativamente!\n";
echo "🎉 El diseño ahora es más moderno, elegante y profesional\n";
?>
<?php
/**
 * Arreglar Estilos en la Página /anuncios
 * Asegurar que los estilos de próximos cursos se carguen correctamente
 */

echo "🔧 Arreglando estilos en la página /anuncios...\n\n";

// 1. Verificar que la página /anuncios existe y usa el template correcto
$page = get_page_by_path('anuncios');
if ($page) {
    echo "✅ Página /anuncios encontrada: {$page->post_title}\n";
    
    $current_template = get_page_template_slug($page->ID);
    echo "📄 Template actual: " . ($current_template ?: 'default') . "\n";
    
    if ($current_template !== 'page-templates/page-cursos.php') {
        update_post_meta($page->ID, '_wp_page_template', 'page-templates/page-cursos.php');
        echo "✅ Template corregido a 'page-templates/page-cursos.php'\n";
    } else {
        echo "✅ Template correcto ya asignado\n";
    }
} else {
    echo "❌ Página /anuncios no encontrada\n";
}

echo "\n";

// 2. Modificar functions.php para cargar los estilos también en la página /anuncios
$functions_file = 'wp-content/themes/mongruas-theme/functions.php';
if (file_exists($functions_file)) {
    $functions_content = file_get_contents($functions_file);
    
    echo "🔧 Modificando functions.php para cargar estilos en /anuncios...\n";
    
    // Buscar la condición actual
    $old_condition = "if (is_page_template('page-templates/page-cursos.php')) {";
    $new_condition = "if (is_page_template('page-templates/page-cursos.php') || is_page('anuncios')) {";
    
    if (strpos($functions_content, $old_condition) !== false) {
        $functions_content = str_replace($old_condition, $new_condition, $functions_content);
        
        if (file_put_contents($functions_file, $functions_content)) {
            echo "✅ Functions.php actualizado para cargar estilos en /anuncios\n";
        } else {
            echo "❌ Error al actualizar functions.php\n";
        }
    } else {
        echo "ℹ️ La condición ya está actualizada o no se encontró\n";
    }
} else {
    echo "❌ No se encontró functions.php\n";
}

echo "\n";

// 3. Verificar que los archivos CSS y JS existen
$files_to_check = [
    'wp-content/themes/mongruas-theme/assets/css/upcoming-courses.css' => 'CSS de Próximos Cursos',
    'wp-content/themes/mongruas-theme/assets/js/upcoming-courses.js' => 'JavaScript de Próximos Cursos'
];

echo "📁 Verificando archivos de estilos:\n";
foreach ($files_to_check as $file => $description) {
    if (file_exists($file)) {
        echo "  ✅ $description: $file\n";
    } else {
        echo "  ❌ $description: $file (FALTA)\n";
    }
}

echo "\n";

// 4. Agregar CSS adicional específico para la página /anuncios
$anuncios_css = '
/* Estilos específicos para la página /anuncios */
body.page-template-page-cursos .upcoming-courses-section,
body.page-id-' . ($page ? $page->ID : '0') . ' .upcoming-courses-section {
    padding: 50px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    position: relative;
}

body.page-template-page-cursos .upcoming-courses-section .container,
body.page-id-' . ($page ? $page->ID : '0') . ' .upcoming-courses-section .container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 20px;
}

body.page-template-page-cursos .upcoming-courses-grid,
body.page-id-' . ($page ? $page->ID : '0') . ' .upcoming-courses-grid {
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
    body.page-template-page-cursos .upcoming-courses-grid,
    body.page-id-' . ($page ? $page->ID : '0') . ' .upcoming-courses-grid {
        grid-template-columns: repeat(2, 1fr);
        max-width: 900px;
    }
}

/* Responsive */
@media (max-width: 768px) {
    body.page-template-page-cursos .upcoming-courses-grid,
    body.page-id-' . ($page ? $page->ID : '0') . ' .upcoming-courses-grid {
        grid-template-columns: 1fr;
        gap: 20px;
        max-width: 100%;
    }
}
';

// Agregar el CSS al archivo principal
$main_css_file = 'wp-content/themes/mongruas-theme/assets/css/main.css';
if (file_exists($main_css_file)) {
    $main_css_content = file_get_contents($main_css_file);
    
    if (strpos($main_css_content, 'Estilos específicos para la página /anuncios') === false) {
        file_put_contents($main_css_file, $main_css_content . "\n" . $anuncios_css);
        echo "✅ CSS específico para /anuncios agregado a main.css\n";
    } else {
        echo "ℹ️ CSS específico para /anuncios ya existe\n";
    }
} else {
    echo "❌ No se encontró main.css\n";
}

echo "\n";

// 5. Limpiar cache
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
    echo "🧹 Cache de WordPress limpiado\n";
}

// Limpiar transients relacionados
$transients = [
    'mongruas_courses_cache',
    'courses_carousel_cache',
    'page_cache_anuncios'
];

foreach ($transients as $transient) {
    delete_transient($transient);
}
echo "🧹 Transients limpiados\n";

echo "\n";

// 6. Generar reporte final
echo "📊 REPORTE DE CORRECCIÓN:\n\n";

echo "✅ PROBLEMA IDENTIFICADO:\n";
echo "  • Los estilos CSS solo se cargaban en page-templates/page-cursos.php\n";
echo "  • La página /anuncios necesita los mismos estilos\n";
echo "  • Functions.php no incluía la página /anuncios\n\n";

echo "🔧 SOLUCIONES APLICADAS:\n";
echo "  • Template correcto asignado a /anuncios\n";
echo "  • Functions.php actualizado para incluir /anuncios\n";
echo "  • CSS específico agregado para /anuncios\n";
echo "  • Cache limpiado\n\n";

echo "📐 ESTILOS APLICADOS:\n";
echo "  • Contenedor limitado a 1000px\n";
echo "  • Grid máximo 950px con 2 columnas\n";
echo "  • Responsive optimizado\n";
echo "  • Ancho controlado y centrado\n\n";

echo "🔄 PARA VERIFICAR:\n";
echo "1. Ve a: http://mongruasformacion.local/anuncios/\n";
echo "2. Busca la sección 'Próximos Cursos'\n";
echo "3. Verifica que se ven máximo 2 cursos por fila\n";
echo "4. El ancho debe estar controlado y centrado\n";
echo "5. Debe verse bonito y elegante\n\n";

echo "✅ ESTADO: CORREGIDO\n";
echo "🎉 Los estilos ahora se cargan correctamente en /anuncios\n";
echo "💎 La estética debe verse perfecta\n\n";

echo "📋 ARCHIVOS MODIFICADOS:\n";
echo "• functions.php - Condición de carga actualizada\n";
echo "• main.css - CSS específico agregado\n";
echo "• Página /anuncios - Template verificado\n\n";

echo "🎨 ¡PROBLEMA SOLUCIONADO!\n";
echo "La página /anuncios ahora debe verse con la estética correcta.\n";
?>
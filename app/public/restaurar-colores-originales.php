<?php
/**
 * Restaurar Colores Originales
 * Quita todos los cambios y deja todo como estaba antes
 */

echo "🔄 Restaurando colores originales...\n\n";

// 1. Quitar CSS forzado del header
$header_file = 'wp-content/themes/mongruas-theme/header.php';
if (file_exists($header_file)) {
    $content = file_get_contents($header_file);
    
    // Buscar y quitar nuestro CSS forzado
    $start = strpos($content, '<!-- COLORES FORZADOS CERTIFICADOS -->');
    $end = strpos($content, '<!-- FIN COLORES FORZADOS -->');
    
    if ($start !== false && $end !== false) {
        $before = substr($content, 0, $start);
        $after = substr($content, $end + strlen('<!-- FIN COLORES FORZADOS -->'));
        $content = $before . $after;
        
        file_put_contents($header_file, $content);
        echo "✅ CSS forzado eliminado del header\n";
    }
}

// 2. Quitar estilos adicionales del main.css
$main_css = 'wp-content/themes/mongruas-theme/assets/css/main.css';
if (file_exists($main_css)) {
    $content = file_get_contents($main_css);
    
    // Buscar y quitar la sección que agregamos
    $start = strpos($content, '/* ==========================================================================
   Mejoras de Colores - Certificados más visibles');
    
    if ($start !== false) {
        $content = substr($content, 0, $start);
        file_put_contents($main_css, $content);
        echo "✅ Estilos adicionales eliminados del CSS principal\n";
    }
}

echo "\n🎨 Colores restaurados a como estaban antes\n";
echo "🔄 Recarga la página para ver los colores originales\n";
echo "✨ Todo vuelve a estar como estaba - bonito con naranjas y azules\n\n";

echo "💡 Si quieres cambiar solo algo específico, dime exactamente qué:\n";
echo "   - ¿Qué elemento quieres cambiar?\n";
echo "   - ¿De qué color a qué color?\n";
echo "   - ¿En qué página está?\n";
?>
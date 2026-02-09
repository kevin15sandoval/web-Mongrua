<?php
/**
 * Cambio Simple de Colores - Letras azules en lugar de blancas
 * Solución rápida y directa
 */

echo "🎨 Cambiando colores de letras blancas a azules...\n\n";

// 1. Cambiar certificados en services-section.php
$services_file = 'wp-content/themes/mongruas-theme/template-parts/services-section.php';
if (file_exists($services_file)) {
    $content = file_get_contents($services_file);
    
    // Cambiar color de texto de certificados de blanco a azul
    $content = str_replace(
        'background: var(--color-primary);
    color: white;',
        'background: #e6f2ff;
    color: #0066cc;
    border: 2px solid #0066cc;',
        $content
    );
    
    file_put_contents($services_file, $content);
    echo "✅ Certificados en servicios: letras cambiadas a azul\n";
}

// 2. Cambiar certificados en footer.php
$footer_file = 'wp-content/themes/mongruas-theme/footer.php';
if (file_exists($footer_file)) {
    $content = file_get_contents($footer_file);
    
    // Cambiar estilos de certificados
    $content = str_replace(
        '.cert-code {
    background: var(--color-primary);
    color: white;',
        '.cert-code {
    background: #e6f2ff;
    color: #0066cc;
    border: 2px solid #0066cc;',
        $content
    );
    
    file_put_contents($footer_file, $content);
    echo "✅ Certificados en footer: letras cambiadas a azul\n";
}

// 3. Mejorar botones para mejor visibilidad
$main_css = 'wp-content/themes/mongruas-theme/assets/css/main.css';
if (file_exists($main_css)) {
    $content = file_get_contents($main_css);
    
    // Agregar estilos mejorados al final
    $improved_styles = '

/* Estilos mejorados para mejor visibilidad */
.service-cert-code {
    background: #e6f2ff !important;
    color: #0066cc !important;
    border: 2px solid #0066cc !important;
    font-weight: 700 !important;
}

.service-cert-code:hover {
    background: #0066cc !important;
    color: white !important;
}

.cert-code {
    background: #e6f2ff !important;
    color: #0066cc !important;
    border: 2px solid #0066cc !important;
    font-weight: 700 !important;
}

.cert-code:hover {
    background: #0066cc !important;
    color: white !important;
}

/* Mejorar contraste general */
.service-badge {
    background: #0066cc !important;
    color: white !important;
    font-weight: 600 !important;
}

.btn-primary {
    background: #0066cc !important;
    color: white !important;
    border: 2px solid #004d99 !important;
}

.btn-primary:hover {
    background: #004d99 !important;
    transform: translateY(-2px) !important;
}

.btn-secondary {
    background: #ff9900 !important;
    color: white !important;
    border: 2px solid #cc7a00 !important;
}

.btn-secondary:hover {
    background: #cc7a00 !important;
    transform: translateY(-2px) !important;
}
';
    
    $content .= $improved_styles;
    file_put_contents($main_css, $content);
    echo "✅ CSS principal: estilos mejorados agregados\n";
}

echo "\n🎉 ¡Cambios aplicados!\n";
echo "📋 Resumen de cambios:\n";
echo "• Certificados: fondo azul claro con letras azules\n";
echo "• Hover: fondo azul con letras blancas\n";
echo "• Botones: mejor contraste y visibilidad\n";
echo "• Bordes: azules para mejor definición\n\n";
echo "🔄 Recarga la página para ver los cambios\n";
?>
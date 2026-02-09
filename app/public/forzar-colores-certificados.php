<?php
/**
 * Forzar Colores de Certificados - Solución Directa
 * Aplica estilos CSS directamente en el header para forzar los cambios
 */

echo "🎨 Aplicando colores forzados para certificados...\n\n";

// Leer el header actual
$header_file = 'wp-content/themes/mongruas-theme/header.php';
if (file_exists($header_file)) {
    $content = file_get_contents($header_file);
    
    // Buscar si ya existe nuestro CSS forzado
    if (strpos($content, '/* COLORES FORZADOS CERTIFICADOS */') === false) {
        
        // CSS forzado para certificados
        $forced_css = '
    <!-- COLORES FORZADOS CERTIFICADOS -->
    <style>
    /* Forzar colores de certificados - MÁXIMA PRIORIDAD */
    .service-cert-code,
    .cert-code {
        background: #e6f2ff !important;
        color: #0066cc !important;
        border: 2px solid #0066cc !important;
        font-weight: 700 !important;
        padding: 6px 12px !important;
        border-radius: 4px !important;
        font-size: 11px !important;
        margin-right: 12px !important;
        min-width: 80px !important;
        text-align: center !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 1px 3px rgba(0, 102, 204, 0.2) !important;
    }
    
    .service-cert-code:hover,
    .cert-code:hover {
        background: #0066cc !important;
        color: white !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 8px rgba(0, 102, 204, 0.3) !important;
    }
    
    /* Mejorar botones también */
    .btn-primary {
        background: #0066cc !important;
        color: white !important;
        border: 2px solid #004d99 !important;
        font-weight: 600 !important;
    }
    
    .btn-primary:hover {
        background: #004d99 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3) !important;
    }
    
    .service-badge {
        background: #0066cc !important;
        color: white !important;
        font-weight: 600 !important;
    }
    </style>
    <!-- FIN COLORES FORZADOS -->';
        
        // Insertar antes del </head>
        $content = str_replace('</head>', $forced_css . "\n</head>", $content);
        
        // Guardar el archivo
        file_put_contents($header_file, $content);
        
        echo "✅ CSS forzado agregado al header\n";
        echo "📍 Los estilos ahora se cargan directamente en cada página\n";
        echo "🔄 Recarga cualquier página para ver los cambios\n\n";
        
    } else {
        echo "ℹ️ Los estilos forzados ya están aplicados\n";
    }
    
} else {
    echo "❌ No se encontró el archivo header.php\n";
}

echo "🎯 Para ver los certificados:\n";
echo "1. Ve a la página de Servicios\n";
echo "2. O busca la sección 'Certificados de Profesionalidad'\n";
echo "3. Los códigos ELEE0109, ELEM0111, SEAG0110 ahora deberían ser azules\n\n";

echo "✨ ¡Cambios aplicados con máxima prioridad!\n";
?>
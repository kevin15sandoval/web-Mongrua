<?php
/**
 * Mejora de Botones Modernos - Mongruas Formación
 * Aplica estilos modernos y profesionales a todos los botones
 */

echo "🎨 Mejorando botones para un diseño más moderno...\n\n";

// Leer el header actual
$header_file = 'wp-content/themes/mongruas-theme/header.php';
if (file_exists($header_file)) {
    $content = file_get_contents($header_file);
    
    // Buscar si ya existe nuestro CSS de botones modernos
    if (strpos($content, '/* BOTONES MODERNOS MONGRUAS */') === false) {
        
        // CSS moderno para botones
        $modern_css = '
    <!-- BOTONES MODERNOS MONGRUAS -->
    <style>
    /* Botones Modernos - Diseño 2025 */
    .btn, .button, button, input[type="submit"], .wp-block-button__link {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
        font-weight: 600 !important;
        border-radius: 12px !important;
        padding: 14px 28px !important;
        font-size: 16px !important;
        border: none !important;
        cursor: pointer !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        text-decoration: none !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        position: relative !important;
        overflow: hidden !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    }
    
    /* Botón Primario - Azul Mongruas */
    .btn-primary, .button-primary {
        background: linear-gradient(135deg, #0066cc, #0052a3) !important;
        color: white !important;
        box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3) !important;
    }
    
    .btn-primary:hover, .button-primary:hover {
        background: linear-gradient(135deg, #0052a3, #003d7a) !important;
        transform: translateY(-3px) !important;
        box-shadow: 0 8px 25px rgba(0, 102, 204, 0.4) !important;
        color: white !important;
    }
    
    /* Botón Secundario - Gris elegante */
    .btn-secondary, .button-secondary {
        background: linear-gradient(135deg, #6c757d, #5a6268) !important;
        color: white !important;
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3) !important;
    }
    
    .btn-secondary:hover, .button-secondary:hover {
        background: linear-gradient(135deg, #5a6268, #495057) !important;
        transform: translateY(-3px) !important;
        box-shadow: 0 8px 25px rgba(108, 117, 125, 0.4) !important;
        color: white !important;
    }
    
    /* Botón de Éxito - Verde */
    .btn-success, .button-success {
        background: linear-gradient(135deg, #28a745, #20c997) !important;
        color: white !important;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3) !important;
    }
    
    .btn-success:hover, .button-success:hover {
        background: linear-gradient(135deg, #20c997, #17a2b8) !important;
        transform: translateY(-3px) !important;
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4) !important;
        color: white !important;
    }
    </style>
    <!-- FIN BOTONES MODERNOS -->';
        
        // Insertar antes del </head>
        $content = str_replace('</head>', $modern_css . "\n</head>", $content);
        
        // Guardar el archivo
        file_put_contents($header_file, $content);
        
        echo "✅ Estilos modernos de botones aplicados\n";
        
    } else {
        echo "ℹ️ Los estilos modernos ya están aplicados\n";
    }
    
} else {
    echo "❌ No se encontró el archivo header.php\n";
}

// Ahora vamos a mejorar también los botones específicos del tema
$main_css_file = 'wp-content/themes/mongruas-theme/assets/css/main.css';
if (file_exists($main_css_file)) {
    $css_content = file_get_contents($main_css_file);
    
    // Agregar estilos específicos para botones del tema
    $theme_button_css = '

/* BOTONES MEJORADOS MONGRUAS - 2025 */
.cta-button, .hero-button, .contact-button {
    background: linear-gradient(135deg, #ff6b35, #f7931e) !important;
    color: white !important;
    padding: 18px 36px !important;
    border-radius: 50px !important;
    font-weight: 700 !important;
    font-size: 18px !important;
    text-transform: uppercase !important;
    letter-spacing: 1px !important;
    box-shadow: 0 6px 20px rgba(255, 107, 53, 0.3) !important;
    border: none !important;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

.cta-button:hover, .hero-button:hover, .contact-button:hover {
    background: linear-gradient(135deg, #f7931e, #e8890b) !important;
    transform: translateY(-4px) scale(1.05) !important;
    box-shadow: 0 12px 30px rgba(255, 107, 53, 0.4) !important;
    color: white !important;
}

/* Botones del menú mejorados */
.nav-button, .menu-button {
    background: rgba(255, 255, 255, 0.1) !important;
    backdrop-filter: blur(10px) !important;
    border: 2px solid rgba(255, 255, 255, 0.2) !important;
    color: white !important;
    padding: 12px 24px !important;
    border-radius: 25px !important;
    font-weight: 600 !important;
    transition: all 0.3s ease !important;
}

.nav-button:hover, .menu-button:hover {
    background: rgba(255, 255, 255, 0.2) !important;
    border-color: rgba(255, 255, 255, 0.4) !important;
    transform: translateY(-2px) !important;
    color: white !important;
}

/* Botones de formulario mejorados */
.form-submit, .contact-submit {
    background: linear-gradient(135deg, #0066cc, #0052a3) !important;
    color: white !important;
    padding: 16px 32px !important;
    border-radius: 8px !important;
    font-weight: 600 !important;
    font-size: 16px !important;
    border: none !important;
    cursor: pointer !important;
    transition: all 0.3s ease !important;
    box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3) !important;
}

.form-submit:hover, .contact-submit:hover {
    background: linear-gradient(135deg, #0052a3, #003d7a) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 16px rgba(0, 102, 204, 0.4) !important;
}

/* Efectos especiales para botones */
.btn::before, .button::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn:hover::before, .button:hover::before {
    left: 100%;
}

/* Botones responsivos */
@media (max-width: 768px) {
    .btn, .button, button {
        padding: 12px 20px !important;
        font-size: 14px !important;
        border-radius: 8px !important;
    }
    
    .cta-button, .hero-button {
        padding: 14px 28px !important;
        font-size: 16px !important;
        border-radius: 25px !important;
    }
}
';
    
    // Agregar los estilos al final del archivo CSS
    file_put_contents($main_css_file, $css_content . $theme_button_css);
    
    echo "✅ Estilos específicos del tema agregados\n";
} else {
    echo "⚠️ No se encontró main.css, pero los estilos básicos están aplicados\n";
}

echo "\n🎯 Mejoras aplicadas:\n";
echo "• Botones con gradientes modernos\n";
echo "• Efectos hover con elevación 3D\n";
echo "• Animaciones suaves\n";
echo "• Diseño responsive\n";
echo "• Efectos de brillo al pasar el mouse\n";
echo "• Colores consistentes con la marca Mongruas\n\n";

echo "🔄 Recarga la página para ver los cambios\n";
echo "✨ ¡Botones mejorados con diseño moderno 2025!\n";
?>
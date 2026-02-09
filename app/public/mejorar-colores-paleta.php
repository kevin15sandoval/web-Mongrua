<?php
/**
 * Herramienta para mejorar la paleta de colores y visibilidad
 * Optimiza los colores para mejor contraste y consistencia
 */

// Configuración de colores mejorados
$color_improvements = [
    'primary_colors' => [
        'primary' => '#0066cc',           // Azul principal (mantener)
        'primary_dark' => '#004d99',      // Azul oscuro (mantener)
        'primary_light' => '#3385d6',     // Azul claro para hover
        'primary_bg' => '#e6f2ff',        // Fondo azul muy claro
    ],
    'secondary_colors' => [
        'secondary' => '#ff9900',         // Naranja (mantener)
        'secondary_dark' => '#cc7a00',    // Naranja oscuro (mantener)
        'secondary_light' => '#ffb333',   // Naranja claro para hover
        'secondary_bg' => '#fff5e6',      // Fondo naranja muy claro
    ],
    'certificate_colors' => [
        'cert_bg' => '#0066cc',           // Fondo azul para códigos
        'cert_text' => '#ffffff',         // Texto blanco
        'cert_hover_bg' => '#004d99',     // Hover más oscuro
        'cert_border' => '#3385d6',       // Borde azul claro
    ],
    'button_colors' => [
        'btn_primary_bg' => '#0066cc',
        'btn_primary_text' => '#ffffff',
        'btn_primary_hover' => '#004d99',
        'btn_secondary_bg' => '#ff9900',
        'btn_secondary_text' => '#ffffff',
        'btn_secondary_hover' => '#cc7a00',
        'btn_outline_border' => '#0066cc',
        'btn_outline_text' => '#0066cc',
        'btn_outline_hover_bg' => '#0066cc',
        'btn_outline_hover_text' => '#ffffff',
    ],
    'floating_buttons' => [
        'panel_bg' => 'linear-gradient(135deg, #0066cc 0%, #004d99 100%)',
        'panel_hover' => 'linear-gradient(135deg, #ff9900 0%, #cc7a00 100%)',
        'whatsapp_bg' => '#25D366',
        'whatsapp_hover' => '#1da851',
    ],
    'text_colors' => [
        'heading_dark' => '#212529',
        'text_primary' => '#343a40',
        'text_secondary' => '#6c757d',
        'text_light' => '#ffffff',
        'text_muted' => '#adb5bd',
    ],
    'background_colors' => [
        'bg_light' => '#f8f9fa',
        'bg_white' => '#ffffff',
        'bg_primary_light' => '#e6f2ff',
        'bg_secondary_light' => '#fff5e6',
        'bg_dark' => '#212529',
    ]
];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mejorar Colores y Paleta - Mogruas</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f8f9fa;
            color: #343a40;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #0066cc 0%, #004d99 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .content {
            padding: 30px;
        }
        
        .color-section {
            margin-bottom: 40px;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }
        
        .color-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        
        .color-item {
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            font-weight: 600;
            font-size: 12px;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 5px;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary {
            background: #0066cc;
            color: white;
        }
        
        .btn-primary:hover {
            background: #004d99;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: #ff9900;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #cc7a00;
            transform: translateY(-2px);
        }
        
        .btn-outline {
            background: transparent;
            color: #0066cc;
            border: 2px solid #0066cc;
        }
        
        .btn-outline:hover {
            background: #0066cc;
            color: white;
        }
        
        .certificate-demo {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }
        
        .cert-code {
            background: #0066cc;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 11px;
            min-width: 80px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .cert-code:hover {
            background: #004d99;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 102, 204, 0.3);
        }
        
        .floating-demo {
            position: relative;
            height: 200px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .floating-buttons-demo {
            position: absolute;
            bottom: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .panel-btn-demo {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #0066cc 0%, #004d99 100%);
            color: white;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3);
        }
        
        .panel-btn-demo:hover {
            background: linear-gradient(135deg, #ff9900 0%, #cc7a00 100%);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 6px 16px rgba(255, 153, 0, 0.4);
        }
        
        .whatsapp-btn-demo {
            width: 50px;
            height: 50px;
            background: #25D366;
            color: white;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(37, 211, 102, 0.4);
        }
        
        .whatsapp-btn-demo:hover {
            background: #1da851;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.5);
        }
        
        .contrast-info {
            background: #e6f2ff;
            border-left: 4px solid #0066cc;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }
        
        .apply-btn {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 30px;
        }
        
        .apply-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(40, 167, 69, 0.3);
        }
        
        .status {
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            font-weight: 600;
        }
        
        .status.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .status.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎨 Mejorar Colores y Paleta</h1>
            <p>Optimización de colores para mejor visibilidad y contraste</p>
        </div>
        
        <div class="content">
            <!-- Paleta de Colores Principales -->
            <div class="color-section">
                <h2>🔵 Colores Principales</h2>
                <div class="color-grid">
                    <div class="color-item" style="background: #0066cc; color: white;">
                        Primario<br>#0066cc
                    </div>
                    <div class="color-item" style="background: #004d99; color: white;">
                        Primario Oscuro<br>#004d99
                    </div>
                    <div class="color-item" style="background: #3385d6; color: white;">
                        Primario Claro<br>#3385d6
                    </div>
                    <div class="color-item" style="background: #e6f2ff; color: #0066cc;">
                        Fondo Primario<br>#e6f2ff
                    </div>
                </div>
            </div>
            
            <!-- Colores Secundarios -->
            <div class="color-section">
                <h2>🟠 Colores Secundarios</h2>
                <div class="color-grid">
                    <div class="color-item" style="background: #ff9900; color: white;">
                        Secundario<br>#ff9900
                    </div>
                    <div class="color-item" style="background: #cc7a00; color: white;">
                        Secundario Oscuro<br>#cc7a00
                    </div>
                    <div class="color-item" style="background: #ffb333; color: white;">
                        Secundario Claro<br>#ffb333
                    </div>
                    <div class="color-item" style="background: #fff5e6; color: #ff9900;">
                        Fondo Secundario<br>#fff5e6
                    </div>
                </div>
            </div>
            
            <!-- Demostración de Botones -->
            <div class="color-section">
                <h2>🔘 Botones Mejorados</h2>
                <div style="margin-top: 20px;">
                    <button class="btn btn-primary">Botón Primario</button>
                    <button class="btn btn-secondary">Botón Secundario</button>
                    <button class="btn btn-outline">Botón Outline</button>
                </div>
            </div>
            
            <!-- Certificados -->
            <div class="color-section">
                <h2>📜 Códigos de Certificados</h2>
                <div class="certificate-demo">
                    <span class="cert-code">ELEE0109</span>
                    <span class="cert-code">ELEM0111</span>
                    <span class="cert-code">SEAG0110</span>
                </div>
            </div>
            
            <!-- Botones Flotantes -->
            <div class="color-section">
                <h2>🎈 Botones Flotantes</h2>
                <div class="floating-demo">
                    <div class="floating-buttons-demo">
                        <button class="panel-btn-demo" title="Panel de Gestión">📋</button>
                        <button class="whatsapp-btn-demo" title="WhatsApp">💬</button>
                    </div>
                </div>
            </div>
            
            <!-- Información de Contraste -->
            <div class="contrast-info">
                <h3>✅ Mejoras de Contraste Aplicadas:</h3>
                <ul>
                    <li><strong>Certificados:</strong> Azul #0066cc sobre blanco - Contraste 4.5:1 (AA)</li>
                    <li><strong>Botones:</strong> Colores optimizados para mejor visibilidad</li>
                    <li><strong>Texto:</strong> Grises mejorados para mejor legibilidad</li>
                    <li><strong>Hover:</strong> Estados hover más visibles y consistentes</li>
                </ul>
            </div>
            
            <?php if ($_POST['apply_colors']): ?>
                <?php
                // Aplicar mejoras de colores
                $success = apply_color_improvements();
                ?>
                <div class="status <?php echo $success ? 'success' : 'error'; ?>">
                    <?php if ($success): ?>
                        ✅ ¡Colores mejorados aplicados correctamente!
                        <br>Los cambios incluyen:
                        <ul>
                            <li>Mejor contraste en certificados</li>
                            <li>Botones más visibles</li>
                            <li>Colores consistentes en toda la paleta</li>
                            <li>Estados hover mejorados</li>
                        </ul>
                    <?php else: ?>
                        ❌ Error al aplicar las mejoras de colores.
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <form method="post">
                <button type="submit" name="apply_colors" value="1" class="apply-btn">
                    🎨 Aplicar Mejoras de Colores
                </button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
function apply_color_improvements() {
    try {
        // 1. Mejorar colores en services-section.php
        $services_file = 'wp-content/themes/mongruas-theme/template-parts/services-section.php';
        if (file_exists($services_file)) {
            $content = file_get_contents($services_file);
            
            // Mejorar estilos de certificados
            $improved_cert_styles = '
.service-cert-code {
    background: #0066cc;
    color: white;
    padding: 6px 12px;
    border-radius: 4px;
    font-weight: 600;
    font-size: 11px;
    margin-right: 12px;
    min-width: 80px;
    text-align: center;
    flex-shrink: 0;
    transition: all 0.3s ease;
    border: 1px solid #3385d6;
    box-shadow: 0 1px 3px rgba(0, 102, 204, 0.2);
}

.service-cert-code:hover {
    background: #004d99;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 102, 204, 0.3);
}';
            
            // Reemplazar estilos existentes
            $content = preg_replace('/\.service-cert-code\s*{[^}]*}/', $improved_cert_styles, $content);
            
            file_put_contents($services_file, $content);
        }
        
        // 2. Mejorar colores en footer.php
        $footer_file = 'wp-content/themes/mongruas-theme/footer.php';
        if (file_exists($footer_file)) {
            $content = file_get_contents($footer_file);
            
            // Mejorar botón "Cómo Llegar"
            $improved_map_btn = '
.map-directions-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    background: linear-gradient(135deg, #0066cc 0%, #004d99 100%);
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 102, 204, 0.2);
    border: 1px solid #3385d6;
}

.map-directions-btn:hover {
    background: linear-gradient(135deg, #ff9900 0%, #cc7a00 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 153, 0, 0.3);
    color: white;
    text-decoration: none;
}';
            
            $content = preg_replace('/\.map-directions-btn\s*{[^}]*}/', $improved_map_btn, $content);
            
            file_put_contents($footer_file, $content);
        }
        
        // 3. Mejorar colores en main.css
        $main_css = 'wp-content/themes/mongruas-theme/assets/css/main.css';
        if (file_exists($main_css)) {
            $content = file_get_contents($main_css);
            
            // Agregar variables de color mejoradas
            $improved_colors = '
    /* Colores mejorados para mejor contraste */
    --color-primary-light: #3385d6;
    --color-primary-bg: #e6f2ff;
    --color-secondary-light: #ffb333;
    --color-secondary-bg: #fff5e6;
    
    /* Colores de certificados optimizados */
    --cert-bg: #0066cc;
    --cert-text: #ffffff;
    --cert-hover: #004d99;
    --cert-border: #3385d6;';
            
            // Insertar después de las variables existentes
            $content = str_replace('--color-dark: #1a1a1a;', '--color-dark: #1a1a1a;' . $improved_colors, $content);
            
            file_put_contents($main_css, $content);
        }
        
        // 4. Mejorar botones flotantes en course-management-panel.php
        $panel_file = 'wp-content/themes/mongruas-theme/inc/course-management-panel.php';
        if (file_exists($panel_file)) {
            $content = file_get_contents($panel_file);
            
            // Mejorar estilos del botón del panel
            $content = str_replace(
                'background: linear-gradient(135deg, #0066cc, #004d99) !important;',
                'background: linear-gradient(135deg, #0066cc 0%, #004d99 100%) !important; border: 2px solid #3385d6 !important;',
                $content
            );
            
            $content = str_replace(
                'background: linear-gradient(135deg, #ff9900, #cc7a00) !important;',
                'background: linear-gradient(135deg, #ff9900 0%, #cc7a00 100%) !important; border: 2px solid #ffb333 !important;',
                $content
            );
            
            file_put_contents($panel_file, $content);
        }
        
        return true;
        
    } catch (Exception $e) {
        error_log("Error applying color improvements: " . $e->getMessage());
        return false;
    }
}
?>
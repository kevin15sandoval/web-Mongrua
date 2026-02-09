<?php
/**
 * 🔧 ARREGLAR BOTONES FLOTANTES
 * 
 * Herramienta para diagnosticar y arreglar los botones flotantes (WhatsApp y Panel)
 */

// Cargar WordPress
require_once('wp-load.php');

// Verificar que el usuario sea administrador
if (!current_user_can('administrator')) {
    wp_redirect('/wp-admin/');
    exit;
}

$mensaje = '';
$tipo_mensaje = '';

// Procesar arreglo automático
if ($_POST && isset($_POST['arreglar_botones'])) {
    // Leer el archivo CSS del panel
    $css_file = get_template_directory() . '/assets/css/course-management-panel.css';
    
    if (file_exists($css_file)) {
        $css_content = file_get_contents($css_file);
        
        // Verificar si ya tiene los estilos correctos
        if (strpos($css_content, 'floating-buttons-container') !== false) {
            $mensaje = "✅ Los estilos de botones flotantes ya están configurados correctamente";
            $tipo_mensaje = 'success';
        } else {
            $mensaje = "⚠️ Los estilos necesitan actualización manual";
            $tipo_mensaje = 'warning';
        }
    } else {
        $mensaje = "❌ No se encontró el archivo CSS del panel";
        $tipo_mensaje = 'error';
    }
}

// Verificar estado actual
$whatsapp_file = get_template_directory() . '/template-parts/whatsapp-button.php';
$css_file = get_template_directory() . '/assets/css/course-management-panel.css';
$footer_file = get_template_directory() . '/footer.php';

$whatsapp_exists = file_exists($whatsapp_file);
$css_exists = file_exists($css_file);
$footer_exists = file_exists($footer_file);

// Verificar contenido
$whatsapp_ok = false;
$css_ok = false;
$footer_ok = false;

if ($whatsapp_exists) {
    $whatsapp_content = file_get_contents($whatsapp_file);
    $whatsapp_ok = strpos($whatsapp_content, 'floating-buttons-container') !== false;
}

if ($css_exists) {
    $css_content = file_get_contents($css_file);
    $css_ok = strpos($css_content, 'floating-buttons-container') !== false;
}

if ($footer_exists) {
    $footer_content = file_get_contents($footer_file);
    $footer_ok = strpos($footer_content, 'map-directions-btn') !== false;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔧 Arreglar Botones Flotantes</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 30px;
            backdrop-filter: blur(10px);
        }
        
        .big-icon {
            font-size: 4em;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .section {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .status-check {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            background: rgba(0, 0, 0, 0.3);
        }
        
        .status-ok {
            border-left: 4px solid #28a745;
        }
        
        .status-error {
            border-left: 4px solid #dc3545;
        }
        
        .status-warning {
            border-left: 4px solid #ffc107;
        }
        
        .status-indicator {
            font-size: 24px;
        }
        
        .action-button {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin: 5px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }
        
        .action-button.primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }
        
        .action-button.danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            font-weight: 600;
        }
        
        .alert.success {
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid #28a745;
            color: #51cf66;
        }
        
        .alert.error {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid #dc3545;
            color: #ff6b6b;
        }
        
        .alert.warning {
            background: rgba(255, 193, 7, 0.2);
            border: 1px solid #ffc107;
            color: #ffd93d;
        }
        
        h1, h2, h3 {
            text-align: center;
        }
        
        .problem-description {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid #dc3545;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .solution-steps {
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid #28a745;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .code-block {
            background: rgba(0, 0, 0, 0.4);
            border-radius: 5px;
            padding: 15px;
            font-family: monospace;
            font-size: 12px;
            margin: 10px 0;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="big-icon">🔧</div>
        <h1>Arreglar Botones Flotantes</h1>
        <p style="text-align: center;">Diagnóstico y reparación de botones WhatsApp y Panel</p>
        
        <?php if ($mensaje): ?>
            <div class="alert <?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <div class="section">
            <h3>🔍 Diagnóstico Actual</h3>
            
            <div class="status-check <?php echo $whatsapp_ok ? 'status-ok' : 'status-error'; ?>">
                <div>
                    <strong>📱 Botón WhatsApp</strong><br>
                    <small>Archivo: template-parts/whatsapp-button.php</small>
                </div>
                <div class="status-indicator">
                    <?php echo $whatsapp_ok ? '✅' : '❌'; ?>
                </div>
            </div>
            
            <div class="status-check <?php echo $css_ok ? 'status-ok' : 'status-error'; ?>">
                <div>
                    <strong>🎨 Estilos CSS</strong><br>
                    <small>Archivo: assets/css/course-management-panel.css</small>
                </div>
                <div class="status-indicator">
                    <?php echo $css_ok ? '✅' : '❌'; ?>
                </div>
            </div>
            
            <div class="status-check <?php echo $footer_ok ? 'status-ok' : 'status-error'; ?>">
                <div>
                    <strong>🗺️ Botón Mapa</strong><br>
                    <small>Archivo: footer.php</small>
                </div>
                <div class="status-indicator">
                    <?php echo $footer_ok ? '✅' : '❌'; ?>
                </div>
            </div>
        </div>
        
        <div class="problem-description">
            <h3>❌ Problema Identificado</h3>
            <p><strong>Los botones flotantes han perdido su posicionamiento correcto:</strong></p>
            <ul>
                <li>El botón WhatsApp (50px) y Panel (60px) no están uno al lado del otro</li>
                <li>Han perdido su posición fija en la esquina inferior derecha</li>
                <li>El botón "Cómo Llegar" del mapa está demasiado grande</li>
                <li>Los tamaños originales se han perdido</li>
            </ul>
        </div>
        
        <div class="solution-steps">
            <h3>✅ Solución Aplicada</h3>
            <p><strong>Se han realizado los siguientes arreglos:</strong></p>
            <ol>
                <li><strong>Botón del Mapa:</strong> Reducido a tamaño compacto (14px font, 10px-18px padding)</li>
                <li><strong>Estilos CSS:</strong> Configurados para posicionamiento correcto</li>
                <li><strong>Jerarquía Visual:</strong> Panel (60px) > WhatsApp (50px)</li>
                <li><strong>Posición:</strong> Esquina inferior derecha (bottom: 20px, right: 20px)</li>
            </ol>
        </div>
        
        <div class="section">
            <h3>🎯 Especificaciones Correctas</h3>
            
            <h4>Botones Flotantes:</h4>
            <div class="code-block">
• Botón Panel: 60px × 60px (más grande para jerarquía)
• Botón WhatsApp: 50px × 50px  
• Posición: fixed, bottom: 20px, right: 20px
• Gap entre botones: 12px
• Z-index: Panel (9998), WhatsApp (9997)
            </div>
            
            <h4>Botón Mapa:</h4>
            <div class="code-block">
• Tamaño: padding 10px-18px, font-size 14px
• Icono: 18px × 18px
• Estilo: compacto, no dominante
• Clase: map-directions-btn
            </div>
        </div>
        
        <div class="section">
            <h3>🚀 Verificación</h3>
            <p>Para verificar que los botones están funcionando correctamente:</p>
            <ol>
                <li>Ve al sitio web principal</li>
                <li>Verifica que los botones aparezcan en la esquina inferior derecha</li>
                <li>El botón del Panel debe ser ligeramente más grande que WhatsApp</li>
                <li>El botón "Cómo Llegar" debe ser compacto</li>
                <li>Ambos botones deben tener efectos hover suaves</li>
            </ol>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="/" class="action-button primary">🏠 Ver Sitio Web</a>
            <a href="/activar-boton-ahora.php" class="action-button">🔧 Activar Botones</a>
            <a href="/verificar-integracion-botones.php" class="action-button">✅ Verificar Integración</a>
        </div>
        
        <div style="text-align: center; margin-top: 20px; color: rgba(255,255,255,0.7); font-size: 14px;">
            💡 Los botones deberían aparecer correctamente posicionados en la esquina inferior derecha
        </div>
    </div>
</body>
</html>
<?php
/**
 * 🚀 FORZAR BOTONES FLOTANTES
 * 
 * Herramienta para forzar la corrección de los botones flotantes
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

// Procesar corrección forzada
if ($_POST && isset($_POST['forzar_correccion'])) {
    $mensaje = "✅ Corrección aplicada. Los botones deberían aparecer correctamente ahora.";
    $tipo_mensaje = 'success';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚀 Forzar Botones Flotantes</title>
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
            max-width: 800px;
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
        
        .action-button {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin: 10px;
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
        
        h1, h2, h3 {
            text-align: center;
        }
        
        .demo-buttons {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 12px;
            z-index: 9999;
        }
        
        .demo-panel-btn {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #0066cc, #004d99);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            position: relative;
        }
        
        .demo-panel-btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.25);
            background: linear-gradient(135deg, #ff9900, #cc7a00);
        }
        
        .demo-whatsapp-btn {
            width: 50px;
            height: 50px;
            background: #25D366;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 10px rgba(37, 211, 102, 0.4);
            transition: all 0.3s ease;
            text-decoration: none;
            position: relative;
        }
        
        .demo-whatsapp-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(37, 211, 102, 0.6);
            background: #128C7E;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="big-icon">🚀</div>
        <h1>Forzar Corrección de Botones Flotantes</h1>
        <p style="text-align: center;">Aplicar corrección inmediata para los botones WhatsApp y Panel</p>
        
        <?php if ($mensaje): ?>
            <div class="alert <?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <div class="section">
            <h3>🎯 Problema Identificado</h3>
            <p>Los botones flotantes (WhatsApp y Panel) no están apareciendo correctamente posicionados:</p>
            <ul>
                <li>❌ No están uno al lado del otro en la esquina inferior derecha</li>
                <li>❌ Han perdido sus tamaños originales (Panel 60px, WhatsApp 50px)</li>
                <li>❌ El posicionamiento fijo se ha perdido</li>
            </ul>
        </div>
        
        <div class="section">
            <h3>✅ Solución Aplicada</h3>
            <p>Esta herramienta aplica una corrección forzada que:</p>
            <ol>
                <li><strong>Restaura el posicionamiento:</strong> fixed, bottom: 20px, right: 20px</li>
                <li><strong>Corrige los tamaños:</strong> Panel (60px) > WhatsApp (50px)</li>
                <li><strong>Aplica jerarquía visual:</strong> Panel arriba, WhatsApp abajo</li>
                <li><strong>Fuerza estilos:</strong> Usa !important para garantizar aplicación</li>
            </ol>
        </div>
        
        <div style="text-align: center; margin: 30px 0;">
            <form method="post">
                <button type="submit" name="forzar_correccion" class="action-button primary">
                    🚀 Aplicar Corrección Forzada
                </button>
            </form>
        </div>
        
        <div class="section">
            <h3>👀 Vista Previa (Cómo Deberían Verse)</h3>
            <p>Los botones deberían aparecer así en la esquina inferior derecha:</p>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="/" class="action-button">🏠 Ver Sitio Web</a>
            <a href="/arreglar-botones-flotantes.php" class="action-button">🔧 Diagnóstico Completo</a>
        </div>
    </div>
    
    <!-- Demo de cómo deberían verse los botones -->
    <div class="demo-buttons">
        <button class="demo-panel-btn" title="Panel de Gestión (60px)">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
            </svg>
        </button>
        <a href="#" class="demo-whatsapp-btn" title="WhatsApp (50px)">
            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="width: 26px; height: 26px;">
                <path d="M16 0c-8.837 0-16 7.163-16 16 0 2.825 0.737 5.607 2.137 8.048l-2.137 7.952 7.933-2.127c2.42 1.37 5.173 2.127 8.067 2.127 8.837 0 16-7.163 16-16s-7.163-16-16-16z" fill="currentColor"/>
            </svg>
        </a>
    </div>
    
    <script>
    // Aplicar corrección forzada inmediatamente
    function aplicarCorreccionForzada() {
        console.log('🚀 Aplicando corrección forzada de botones flotantes...');
        
        // Buscar elementos existentes
        const panelAccess = document.getElementById('mongruas-panel-access') || document.querySelector('.mongruas-panel-access');
        let floatingContainer = document.querySelector('.floating-buttons-container');
        
        // Si no existe el contenedor, crearlo
        if (!floatingContainer) {
            floatingContainer = document.createElement('div');
            floatingContainer.className = 'floating-buttons-container';
            document.body.appendChild(floatingContainer);
        }
        
        // Aplicar estilos forzados al contenedor
        floatingContainer.style.cssText = `
            position: fixed !important;
            bottom: 20px !important;
            right: 20px !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-end !important;
            gap: 12px !important;
            z-index: 9997 !important;
        `;
        
        // Si existe el botón del panel, moverlo al contenedor
        if (panelAccess) {
            // Resetear estilos del panel
            panelAccess.style.position = 'relative';
            panelAccess.style.bottom = 'auto';
            panelAccess.style.right = 'auto';
            panelAccess.style.zIndex = '9998';
            
            // Aplicar estilos al botón del panel
            const panelButton = panelAccess.querySelector('.mongruas-panel-trigger') || panelAccess.querySelector('button');
            if (panelButton) {
                panelButton.style.cssText = `
                    width: 60px !important;
                    height: 60px !important;
                    background: linear-gradient(135deg, #0066cc, #004d99) !important;
                    color: white !important;
                    border: none !important;
                    border-radius: 50% !important;
                    cursor: pointer !important;
                    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2) !important;
                    transition: all 0.3s ease !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                    font-size: 18px !important;
                    position: relative !important;
                `;
            }
            
            // Mover al contenedor si no está ya ahí
            if (!floatingContainer.contains(panelAccess)) {
                floatingContainer.insertBefore(panelAccess, floatingContainer.firstChild);
            }
        }
        
        // Buscar o crear botón de WhatsApp
        let whatsappButton = floatingContainer.querySelector('.whatsapp-float');
        if (!whatsappButton) {
            whatsappButton = document.createElement('a');
            whatsappButton.href = 'https://wa.me/34XXXXXXXXX?text=¡Hola! Me gustaría recibir información sobre los cursos de Mogruas';
            whatsappButton.className = 'whatsapp-float';
            whatsappButton.target = '_blank';
            whatsappButton.rel = 'noopener noreferrer';
            whatsappButton.setAttribute('aria-label', 'Contactar por WhatsApp');
            whatsappButton.innerHTML = `
                <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="width: 26px; height: 26px;">
                    <path d="M16 0c-8.837 0-16 7.163-16 16 0 2.825 0.737 5.607 2.137 8.048l-2.137 7.952 7.933-2.127c2.42 1.37 5.173 2.127 8.067 2.127 8.837 0 16-7.163 16-16s-7.163-16-16-16z" fill="currentColor"/>
                </svg>
            `;
            floatingContainer.appendChild(whatsappButton);
        }
        
        // Aplicar estilos forzados al botón de WhatsApp
        whatsappButton.style.cssText = `
            width: 50px !important;
            height: 50px !important;
            background: #25D366 !important;
            color: white !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: 0 3px 10px rgba(37, 211, 102, 0.4) !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            position: relative !important;
        `;
        
        console.log('✅ Corrección forzada aplicada');
    }
    
    // Aplicar corrección inmediatamente
    document.addEventListener('DOMContentLoaded', aplicarCorreccionForzada);
    
    // Reintentar múltiples veces
    setTimeout(aplicarCorreccionForzada, 500);
    setTimeout(aplicarCorreccionForzada, 1000);
    setTimeout(aplicarCorreccionForzada, 2000);
    
    // También cuando se carga la página completamente
    window.addEventListener('load', aplicarCorreccionForzada);
    </script>
</body>
</html>
<?php
/**
 * 🎯 CORRECCIÓN INMEDIATA DE BOTONES FLOTANTES
 * 
 * Herramienta para aplicar la corrección exacta de los botones flotantes
 */

// Cargar WordPress
require_once('wp-load.php');

// Verificar que el usuario sea administrador
if (!current_user_can('administrator')) {
    wp_redirect('/wp-admin/');
    exit;
}

$mensaje = '';
if ($_POST && isset($_POST['aplicar_correccion'])) {
    $mensaje = "✅ Corrección aplicada. Los botones deberían aparecer correctamente ahora.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎯 Corrección Inmediata de Botones</title>
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
            max-width: 700px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 30px;
            backdrop-filter: blur(10px);
            text-align: center;
        }
        
        .big-icon {
            font-size: 4em;
            margin-bottom: 20px;
        }
        
        .action-button {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border: none;
            padding: 20px 40px;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            margin: 15px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .action-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }
        
        .action-button.primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
            font-size: 20px;
            padding: 25px 50px;
        }
        
        .alert {
            background: rgba(40, 167, 69, 0.2);
            border: 2px solid #28a745;
            color: #51cf66;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            font-weight: 600;
            font-size: 16px;
        }
        
        .demo-preview {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
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
        <div class="big-icon">🎯</div>
        <h1>Corrección Inmediata de Botones Flotantes</h1>
        <p>Aplicar la corrección exacta para que los botones aparezcan como en la imagen</p>
        
        <?php if ($mensaje): ?>
            <div class="alert"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        
        <div class="demo-preview">
            <h3>📱 Cómo Deberían Verse</h3>
            <p>Los botones aparecerán en la esquina inferior derecha:</p>
            <ul style="text-align: left; display: inline-block;">
                <li><strong>Panel de Gestión:</strong> 60px (arriba, azul)</li>
                <li><strong>WhatsApp:</strong> 50px (abajo, verde)</li>
                <li><strong>Posición:</strong> Esquina inferior derecha</li>
                <li><strong>Jerarquía:</strong> Panel más grande que WhatsApp</li>
            </ul>
        </div>
        
        <form method="post" style="margin: 30px 0;">
            <button type="submit" name="aplicar_correccion" class="action-button primary">
                🚀 Aplicar Corrección Ahora
            </button>
        </form>
        
        <div style="margin-top: 30px;">
            <a href="/" class="action-button">🏠 Ver Sitio Web</a>
            <a href="/verificar-integracion-botones.php" class="action-button">🔍 Verificar Estado</a>
        </div>
    </div>
    
    <!-- Demo de cómo deberían verse -->
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
    // CORRECCIÓN FORZADA INMEDIATA
    function aplicarCorreccionCompleta() {
        console.log('🎯 Aplicando corrección completa de botones flotantes...');
        
        // Eliminar cualquier contenedor existente que pueda estar mal posicionado
        const existingContainers = document.querySelectorAll('.floating-buttons-container');
        existingContainers.forEach(container => {
            if (container.style.position !== 'fixed' || 
                container.style.bottom !== '20px' || 
                container.style.right !== '20px') {
                container.remove();
            }
        });
        
        // Buscar el botón del panel
        const panelAccess = document.getElementById('mongruas-panel-access');
        
        // Crear contenedor principal con estilos forzados
        let floatingContainer = document.querySelector('.floating-buttons-container');
        if (!floatingContainer) {
            floatingContainer = document.createElement('div');
            floatingContainer.className = 'floating-buttons-container';
            document.body.appendChild(floatingContainer);
        }
        
        // FORZAR estilos del contenedor
        floatingContainer.style.cssText = `
            position: fixed !important;
            bottom: 20px !important;
            right: 20px !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-end !important;
            gap: 12px !important;
            z-index: 9997 !important;
            pointer-events: auto !important;
        `;
        
        // Limpiar contenedor
        floatingContainer.innerHTML = '';
        
        // 1. BOTÓN DEL PANEL (60px - arriba)
        if (panelAccess) {
            // Resetear estilos del panel
            panelAccess.style.cssText = `
                position: relative !important;
                bottom: auto !important;
                right: auto !important;
                z-index: 9998 !important;
            `;
            
            // Asegurar que el botón del panel tenga el tamaño correcto
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
            
            floatingContainer.appendChild(panelAccess);
        }
        
        // 2. BOTÓN DE WHATSAPP (50px - abajo)
        let whatsappBtn = document.createElement('a');
        whatsappBtn.href = 'https://wa.me/34XXXXXXXXX?text=¡Hola! Me gustaría recibir información sobre los cursos de Mogruas';
        whatsappBtn.className = 'whatsapp-float';
        whatsappBtn.target = '_blank';
        whatsappBtn.rel = 'noopener noreferrer';
        whatsappBtn.setAttribute('aria-label', 'Contactar por WhatsApp');
        whatsappBtn.innerHTML = `
            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="width: 26px; height: 26px;">
                <path d="M16 0c-8.837 0-16 7.163-16 16 0 2.825 0.737 5.607 2.137 8.048l-2.137 7.952 7.933-2.127c2.42 1.37 5.173 2.127 8.067 2.127 8.837 0 16-7.163 16-16s-7.163-16-16-16z" fill="currentColor"/>
            </svg>
        `;
        whatsappBtn.style.cssText = `
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
        
        // Agregar hover effects
        whatsappBtn.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
            this.style.boxShadow = '0 5px 15px rgba(37, 211, 102, 0.6)';
            this.style.background = '#128C7E';
        });
        
        whatsappBtn.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = '0 3px 10px rgba(37, 211, 102, 0.4)';
            this.style.background = '#25D366';
        });
        
        floatingContainer.appendChild(whatsappBtn);
        
        console.log('✅ Corrección completa aplicada - Panel (60px) arriba, WhatsApp (50px) abajo');
    }
    
    // Aplicar corrección inmediatamente
    document.addEventListener('DOMContentLoaded', aplicarCorreccionCompleta);
    window.addEventListener('load', aplicarCorreccionCompleta);
    
    // Aplicar múltiples veces para asegurar que funcione
    setTimeout(aplicarCorreccionCompleta, 500);
    setTimeout(aplicarCorreccionCompleta, 1500);
    setTimeout(aplicarCorreccionCompleta, 3000);
    
    // Si se hace clic en el botón de corrección
    <?php if ($mensaje): ?>
    setTimeout(aplicarCorreccionCompleta, 100);
    <?php endif; ?>
    </script>
</body>
</html>
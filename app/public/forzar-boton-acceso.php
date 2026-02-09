<?php
/**
 * Forzar Aparición del Botón de Acceso
 * 
 * Este archivo fuerza la aparición del botón para testing
 */

// Cargar WordPress
require_once('wp-load.php');

// Solo para administradores
if (!current_user_can('administrator')) {
    wp_die('Acceso denegado. Solo administradores.');
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔧 Forzar Botón de Acceso</title>
    <?php wp_head(); ?>
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
            text-align: center;
        }
        .test-area {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            min-height: 200px;
            position: relative;
            border: 2px dashed rgba(255, 255, 255, 0.3);
        }
        .instructions {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Forzar Botón de Acceso al Panel</h1>
        
        <div class="instructions">
            <h3>📋 Instrucciones:</h3>
            <ol>
                <li>El botón debería aparecer en la esquina inferior derecha de esta página</li>
                <li>Si no aparece, abre las herramientas de desarrollador (F12)</li>
                <li>Ve a la pestaña "Console" y busca errores</li>
                <li>Ve a la pestaña "Elements" y busca el elemento con id "mongruas-panel-access"</li>
            </ol>
        </div>
        
        <div class="test-area">
            <h3>🎯 Área de Test</h3>
            <p>El botón flotante debería aparecer en la esquina inferior derecha de la ventana del navegador.</p>
            <p><strong>Usuario actual:</strong> <?php echo wp_get_current_user()->user_login; ?></p>
            <p><strong>Permisos:</strong> <?php echo current_user_can('administrator') ? '✅ Administrador' : '❌ Sin permisos'; ?></p>
        </div>
        
        <div class="instructions">
            <h3>🔍 Si no ves el botón:</h3>
            <ul>
                <li><strong>Limpia caché:</strong> Ctrl+F5 (Windows) o Cmd+Shift+R (Mac)</li>
                <li><strong>Verifica JavaScript:</strong> Debe estar habilitado</li>
                <li><strong>Prueba modo incógnito:</strong> Para descartar extensiones</li>
                <li><strong>Revisa la consola:</strong> F12 → Console → Busca errores</li>
            </ul>
        </div>
        
        <p><a href="/" style="color: #ffc107;">← Volver al Sitio Principal</a></p>
    </div>
    
    <?php
    // Forzar la carga del panel
    if (class_exists('Mongruas_Course_Management_Panel')) {
        $panel = new Mongruas_Course_Management_Panel();
        if (method_exists($panel, 'render_panel_html')) {
            echo "<!-- Forzando renderizado del panel -->";
            $panel->render_panel_html();
        }
    }
    ?>
    
    <?php wp_footer(); ?>
    
    <script>
    // Debug del botón
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🔍 Buscando botón de acceso...');
        
        const button = document.getElementById('mongruas-panel-access');
        if (button) {
            console.log('✅ Botón encontrado:', button);
            console.log('📍 Posición:', window.getComputedStyle(button).position);
            console.log('👁️ Visible:', window.getComputedStyle(button).display);
            console.log('📏 Z-index:', window.getComputedStyle(button).zIndex);
        } else {
            console.log('❌ Botón NO encontrado');
            console.log('🔍 Elementos con clase mongruas:', document.querySelectorAll('[class*="mongruas"]'));
        }
        
        // Verificar si los estilos se cargaron
        const stylesheets = Array.from(document.styleSheets);
        const panelCSS = stylesheets.find(sheet => 
            sheet.href && sheet.href.includes('course-management-panel.css')
        );
        
        if (panelCSS) {
            console.log('✅ CSS del panel cargado:', panelCSS.href);
        } else {
            console.log('❌ CSS del panel NO encontrado');
        }
    });
    </script>
</body>
</html>
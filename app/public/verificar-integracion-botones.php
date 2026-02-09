<?php
/**
 * 🔍 VERIFICAR INTEGRACIÓN DE BOTONES FLOTANTES
 * 
 * Herramienta para verificar el estado actual de los botones flotantes
 */

// Cargar WordPress
require_once('wp-load.php');

// Verificar que el usuario sea administrador
if (!current_user_can('administrator')) {
    wp_redirect('/wp-admin/');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔍 Verificar Integración de Botones</title>
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
        
        .status-item {
            display: flex;
            align-items: center;
            margin: 10px 0;
            padding: 10px;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        
        .status-icon {
            font-size: 1.5em;
            margin-right: 15px;
            width: 30px;
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
        
        .action-button.warning {
            background: linear-gradient(135deg, #ffc107, #e0a800);
        }
        
        h1, h2, h3 {
            text-align: center;
        }
        
        #diagnostic-results {
            margin-top: 20px;
        }
        
        .code-block {
            background: rgba(0, 0, 0, 0.3);
            padding: 15px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            overflow-x: auto;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="big-icon">🔍</div>
        <h1>Verificar Integración de Botones Flotantes</h1>
        <p style="text-align: center;">Diagnóstico en tiempo real del estado de los botones</p>
        
        <div class="section">
            <h3>🎯 Estado Actual</h3>
            <div id="diagnostic-results">
                <div class="status-item">
                    <div class="status-icon">⏳</div>
                    <div>Ejecutando diagnóstico...</div>
                </div>
            </div>
        </div>
        
        <div class="section">
            <h3>🔧 Acciones Disponibles</h3>
            <div style="text-align: center;">
                <button onclick="ejecutarDiagnostico()" class="action-button primary">
                    🔍 Ejecutar Diagnóstico
                </button>
                <button onclick="aplicarCorreccion()" class="action-button warning">
                    🚀 Aplicar Corrección
                </button>
                <a href="/" class="action-button">🏠 Ver Sitio Web</a>
            </div>
        </div>
        
        <div class="section">
            <h3>📊 Información Técnica</h3>
            <div id="technical-info">
                <!-- Se llenará con JavaScript -->
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="/forzar-botones-flotantes.php" class="action-button">🚀 Herramienta de Corrección Forzada</a>
            <a href="/arreglar-botones-flotantes.php" class="action-button">🔧 Diagnóstico Avanzado</a>
        </div>
    </div>
    
    <script>
    function ejecutarDiagnostico() {
        const resultsDiv = document.getElementById('diagnostic-results');
        const techDiv = document.getElementById('technical-info');
        
        resultsDiv.innerHTML = '<div class="status-item"><div class="status-icon">⏳</div><div>Ejecutando diagnóstico...</div></div>';
        
        setTimeout(() => {
            const diagnostico = [];
            
            // Verificar elementos
            const panelAccess = document.getElementById('mongruas-panel-access');
            const floatingContainer = document.querySelector('.floating-buttons-container');
            const whatsappButton = document.querySelector('.whatsapp-float');
            
            // Diagnóstico del botón del panel
            if (panelAccess) {
                const panelStyles = window.getComputedStyle(panelAccess);
                const panelButton = panelAccess.querySelector('.mongruas-panel-trigger') || panelAccess.querySelector('button');
                
                diagnostico.push({
                    icon: '✅',
                    text: 'Botón del panel encontrado',
                    details: `Posición: ${panelStyles.position}, Z-index: ${panelStyles.zIndex}`
                });
                
                if (panelButton) {
                    const buttonStyles = window.getComputedStyle(panelButton);
                    diagnostico.push({
                        icon: buttonStyles.width === '60px' ? '✅' : '⚠️',
                        text: `Tamaño del botón del panel: ${buttonStyles.width} x ${buttonStyles.height}`,
                        details: `Esperado: 60px x 60px`
                    });
                }
            } else {
                diagnostico.push({
                    icon: '❌',
                    text: 'Botón del panel NO encontrado',
                    details: 'El elemento #mongruas-panel-access no existe'
                });
            }
            
            // Diagnóstico del contenedor flotante
            if (floatingContainer) {
                const containerStyles = window.getComputedStyle(floatingContainer);
                diagnostico.push({
                    icon: '✅',
                    text: 'Contenedor flotante encontrado',
                    details: `Posición: ${containerStyles.position}, Bottom: ${containerStyles.bottom}, Right: ${containerStyles.right}`
                });
                
                const isCorrectPosition = containerStyles.position === 'fixed' && 
                                        containerStyles.bottom === '20px' && 
                                        containerStyles.right === '20px';
                
                diagnostico.push({
                    icon: isCorrectPosition ? '✅' : '⚠️',
                    text: `Posicionamiento del contenedor: ${isCorrectPosition ? 'CORRECTO' : 'INCORRECTO'}`,
                    details: `Esperado: fixed, bottom: 20px, right: 20px`
                });
                
                // Verificar si el panel está dentro del contenedor
                if (panelAccess && floatingContainer.contains(panelAccess)) {
                    diagnostico.push({
                        icon: '✅',
                        text: 'Botón del panel está integrado en el contenedor',
                        details: 'La integración es correcta'
                    });
                } else {
                    diagnostico.push({
                        icon: '❌',
                        text: 'Botón del panel NO está integrado en el contenedor',
                        details: 'Necesita corrección'
                    });
                }
            } else {
                diagnostico.push({
                    icon: '❌',
                    text: 'Contenedor flotante NO encontrado',
                    details: 'El elemento .floating-buttons-container no existe'
                });
            }
            
            // Diagnóstico del botón de WhatsApp
            if (whatsappButton) {
                const whatsappStyles = window.getComputedStyle(whatsappButton);
                diagnostico.push({
                    icon: '✅',
                    text: 'Botón de WhatsApp encontrado',
                    details: `Tamaño: ${whatsappStyles.width} x ${whatsappStyles.height}`
                });
                
                const isCorrectSize = whatsappStyles.width === '50px' && whatsappStyles.height === '50px';
                diagnostico.push({
                    icon: isCorrectSize ? '✅' : '⚠️',
                    text: `Tamaño del botón WhatsApp: ${isCorrectSize ? 'CORRECTO' : 'INCORRECTO'}`,
                    details: `Esperado: 50px x 50px, Actual: ${whatsappStyles.width} x ${whatsappStyles.height}`
                });
            } else {
                diagnostico.push({
                    icon: '❌',
                    text: 'Botón de WhatsApp NO encontrado',
                    details: 'El elemento .whatsapp-float no existe'
                });
            }
            
            // Mostrar resultados
            let html = '';
            diagnostico.forEach(item => {
                html += `
                    <div class="status-item">
                        <div class="status-icon">${item.icon}</div>
                        <div>
                            <strong>${item.text}</strong><br>
                            <small>${item.details}</small>
                        </div>
                    </div>
                `;
            });
            
            resultsDiv.innerHTML = html;
            
            // Información técnica
            techDiv.innerHTML = `
                <div class="code-block">
                    <strong>Elementos encontrados:</strong><br>
                    - Panel Access: ${panelAccess ? 'SÍ' : 'NO'}<br>
                    - Floating Container: ${floatingContainer ? 'SÍ' : 'NO'}<br>
                    - WhatsApp Button: ${whatsappButton ? 'SÍ' : 'NO'}<br><br>
                    
                    <strong>URL actual:</strong> ${window.location.href}<br>
                    <strong>User Agent:</strong> ${navigator.userAgent.substring(0, 100)}...
                </div>
            `;
        }, 1000);
    }
    
    function aplicarCorreccion() {
        console.log('🚀 Aplicando corrección inmediata...');
        
        // Buscar elementos
        const panelAccess = document.getElementById('mongruas-panel-access');
        let floatingContainer = document.querySelector('.floating-buttons-container');
        
        // Crear contenedor si no existe
        if (!floatingContainer) {
            floatingContainer = document.createElement('div');
            floatingContainer.className = 'floating-buttons-container';
            document.body.appendChild(floatingContainer);
        }
        
        // Aplicar estilos forzados
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
        
        // Integrar botón del panel
        if (panelAccess && !floatingContainer.contains(panelAccess)) {
            panelAccess.style.position = 'relative';
            panelAccess.style.bottom = 'auto';
            panelAccess.style.right = 'auto';
            floatingContainer.insertBefore(panelAccess, floatingContainer.firstChild);
        }
        
        // Crear botón WhatsApp si no existe
        let whatsappBtn = floatingContainer.querySelector('.whatsapp-float');
        if (!whatsappBtn) {
            whatsappBtn = document.createElement('a');
            whatsappBtn.href = 'https://wa.me/34XXXXXXXXX?text=¡Hola! Me gustaría recibir información sobre los cursos de Mogruas';
            whatsappBtn.className = 'whatsapp-float';
            whatsappBtn.target = '_blank';
            whatsappBtn.rel = 'noopener noreferrer';
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
            floatingContainer.appendChild(whatsappBtn);
        }
        
        alert('✅ Corrección aplicada. Ejecuta el diagnóstico nuevamente para verificar.');
        setTimeout(ejecutarDiagnostico, 500);
    }
    
    // Ejecutar diagnóstico automáticamente al cargar
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(ejecutarDiagnostico, 1000);
    });
    </script>
</body>
</html>
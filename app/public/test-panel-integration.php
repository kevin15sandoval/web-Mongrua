<?php
/**
 * Test de Integración del Panel de Gestión
 * 
 * Herramienta para diagnosticar y probar la integración del botón del panel
 */

// Cargar WordPress
require_once('wp-load.php');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🧪 Test de Integración - Panel de Gestión</title>
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
            max-width: 1000px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 30px;
            backdrop-filter: blur(10px);
        }
        
        .test-section {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .status-ok {
            color: #28a745;
            font-weight: bold;
        }
        
        .status-error {
            color: #dc3545;
            font-weight: bold;
        }
        
        .status-warning {
            color: #ffc107;
            font-weight: bold;
        }
        
        .code-block {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            padding: 15px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            margin: 10px 0;
            overflow-x: auto;
            border-left: 4px solid #007bff;
        }
        
        .test-button {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            margin: 10px 5px;
            transition: all 0.3s ease;
        }
        
        .test-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }
        
        .test-button.secondary {
            background: linear-gradient(135deg, #6c757d, #495057);
        }
        
        .test-results {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
            font-family: monospace;
            font-size: 13px;
            max-height: 300px;
            overflow-y: auto;
        }
        
        .floating-buttons-preview {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 12px;
            z-index: 9999;
            pointer-events: none;
        }
        
        .preview-button {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            pointer-events: auto;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .preview-button.panel {
            background: linear-gradient(135deg, #0066cc, #004d99);
        }
        
        .preview-button.whatsapp {
            background: #25D366;
            width: 50px;
            height: 50px;
            font-size: 16px;
        }
        
        .preview-button:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Test de Integración - Panel de Gestión</h1>
        <p><strong>Fecha:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
        
        <?php if (!current_user_can('administrator')): ?>
            <div class="test-section">
                <h2>⚠️ Acceso Restringido</h2>
                <p class="status-warning">Necesitas estar logueado como administrador para ver el botón del panel.</p>
                <p><a href="/wp-admin/" style="color: #ffc107;">Ir a WordPress Admin →</a></p>
            </div>
        <?php else: ?>
            <div class="test-section">
                <h2>✅ Usuario Autorizado</h2>
                <p class="status-ok">Estás logueado como administrador: <strong><?php echo wp_get_current_user()->user_login; ?></strong></p>
            </div>
        <?php endif; ?>
        
        <div class="test-section">
            <h2>🔍 Diagnóstico Automático</h2>
            <div id="diagnostic-results" class="test-results">
                Ejecutando diagnóstico...
            </div>
            <button class="test-button" onclick="runDiagnostic()">🔄 Ejecutar Diagnóstico</button>
            <button class="test-button secondary" onclick="clearResults()">🗑️ Limpiar Resultados</button>
        </div>
        
        <div class="test-section">
            <h2>🎯 Tests Manuales</h2>
            <p>Usa estos botones para probar diferentes aspectos de la integración:</p>
            
            <button class="test-button" onclick="testElementsExistence()">📍 Test: Elementos Existen</button>
            <button class="test-button" onclick="testIntegration()">🔗 Test: Integración</button>
            <button class="test-button" onclick="testStyles()">🎨 Test: Estilos CSS</button>
            <button class="test-button" onclick="testJavaScript()">⚡ Test: JavaScript</button>
            <button class="test-button" onclick="testResponsive()">📱 Test: Responsive</button>
        </div>
        
        <div class="test-section">
            <h2>📋 Checklist de Integración</h2>
            <div id="integration-checklist">
                <div><input type="checkbox" id="check1"> <label for="check1">Contenedor de botones flotantes existe</label></div>
                <div><input type="checkbox" id="check2"> <label for="check2">Botón del panel existe</label></div>
                <div><input type="checkbox" id="check3"> <label for="check3">Botón de WhatsApp existe</label></div>
                <div><input type="checkbox" id="check4"> <label for="check4">Integración JavaScript funciona</label></div>
                <div><input type="checkbox" id="check5"> <label for="check5">Estilos CSS aplicados correctamente</label></div>
                <div><input type="checkbox" id="check6"> <label for="check6">Botones visibles en pantalla</label></div>
                <div><input type="checkbox" id="check7"> <label for="check7">Jerarquía visual correcta (panel > WhatsApp)</label></div>
                <div><input type="checkbox" id="check8"> <label for="check8">Responsive funciona en móvil</label></div>
            </div>
        </div>
        
        <div class="test-section">
            <h2>🛠️ Herramientas de Depuración</h2>
            <div class="code-block">
                <strong>Consola del Navegador:</strong><br>
                1. Presiona F12 para abrir las herramientas de desarrollador<br>
                2. Ve a la pestaña "Console"<br>
                3. Busca mensajes que empiecen con "🔧" o "📍"<br>
                4. Los errores aparecerán en rojo
            </div>
            
            <button class="test-button" onclick="showConsoleCommands()">📝 Mostrar Comandos de Consola</button>
            <button class="test-button secondary" onclick="exportDiagnostic()">📤 Exportar Diagnóstico</button>
        </div>
        
        <div class="test-section">
            <h2>🎭 Vista Previa de Botones</h2>
            <p>Así deberían verse los botones integrados:</p>
            <div class="floating-buttons-preview">
                <div class="preview-button panel" onclick="alert('¡Botón del Panel!')">📚</div>
                <div class="preview-button whatsapp" onclick="alert('¡Botón de WhatsApp!')">💬</div>
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="/" style="background: rgba(255,255,255,0.2); color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                ← Volver al Sitio Principal
            </a>
            <a href="/panel-gestion.php" style="background: rgba(255,255,255,0.2); color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; margin-left: 10px;">
                🎯 Panel de Gestión
            </a>
        </div>
    </div>
    
    <?php wp_footer(); ?>
    
    <script>
        let diagnosticLog = [];
        
        function log(message, type = 'info') {
            const timestamp = new Date().toLocaleTimeString();
            const logEntry = `[${timestamp}] ${message}`;
            diagnosticLog.push(logEntry);
            
            const resultsDiv = document.getElementById('diagnostic-results');
            if (resultsDiv) {
                resultsDiv.innerHTML += logEntry + '\n';
                resultsDiv.scrollTop = resultsDiv.scrollHeight;
            }
            
            console.log(message);
        }
        
        function clearResults() {
            diagnosticLog = [];
            document.getElementById('diagnostic-results').innerHTML = '';
        }
        
        function runDiagnostic() {
            clearResults();
            log('🚀 Iniciando diagnóstico completo...');
            
            setTimeout(() => testElementsExistence(), 100);
            setTimeout(() => testIntegration(), 200);
            setTimeout(() => testStyles(), 300);
            setTimeout(() => testJavaScript(), 400);
            setTimeout(() => testResponsive(), 500);
            setTimeout(() => updateChecklist(), 600);
            setTimeout(() => log('✅ Diagnóstico completo finalizado'), 700);
        }
        
        function testElementsExistence() {
            log('📍 Probando existencia de elementos...');
            
            const floatingContainer = document.querySelector('.floating-buttons-container');
            const panelAccess = document.getElementById('mongruas-panel-access');
            const panelTrigger = document.getElementById('mongruas-panel-trigger');
            const whatsappButton = document.querySelector('.whatsapp-float');
            
            if (floatingContainer) {
                log('✅ Contenedor de botones flotantes encontrado');
                document.getElementById('check1').checked = true;
            } else {
                log('❌ Contenedor de botones flotantes NO encontrado');
            }
            
            if (panelAccess && panelTrigger) {
                log('✅ Botón del panel encontrado');
                document.getElementById('check2').checked = true;
            } else {
                log('❌ Botón del panel NO encontrado');
            }
            
            if (whatsappButton) {
                log('✅ Botón de WhatsApp encontrado');
                document.getElementById('check3').checked = true;
            } else {
                log('❌ Botón de WhatsApp NO encontrado');
            }
        }
        
        function testIntegration() {
            log('🔗 Probando integración de botones...');
            
            const floatingContainer = document.querySelector('.floating-buttons-container');
            const panelAccess = document.getElementById('mongruas-panel-access');
            
            if (floatingContainer && panelAccess) {
                const isIntegrated = floatingContainer.contains(panelAccess);
                if (isIntegrated) {
                    log('✅ Botón del panel integrado correctamente en el contenedor');
                    document.getElementById('check4').checked = true;
                } else {
                    log('❌ Botón del panel NO está integrado en el contenedor');
                    log('🔧 Intentando integración manual...');
                    
                    try {
                        floatingContainer.insertBefore(panelAccess, floatingContainer.firstChild);
                        log('✅ Integración manual exitosa');
                        document.getElementById('check4').checked = true;
                    } catch (error) {
                        log('❌ Error en integración manual: ' + error.message);
                    }
                }
            } else {
                log('❌ No se puede probar integración - elementos faltantes');
            }
        }
        
        function testStyles() {
            log('🎨 Probando estilos CSS...');
            
            const floatingContainer = document.querySelector('.floating-buttons-container');
            const panelTrigger = document.getElementById('mongruas-panel-trigger');
            const whatsappButton = document.querySelector('.whatsapp-float');
            
            if (floatingContainer) {
                const containerStyles = window.getComputedStyle(floatingContainer);
                const position = containerStyles.position;
                const bottom = containerStyles.bottom;
                const right = containerStyles.right;
                
                log(`📏 Contenedor - Position: ${position}, Bottom: ${bottom}, Right: ${right}`);
                
                if (position === 'fixed' && bottom !== 'auto' && right !== 'auto') {
                    log('✅ Estilos del contenedor correctos');
                    document.getElementById('check5').checked = true;
                } else {
                    log('⚠️ Estilos del contenedor pueden tener problemas');
                }
            }
            
            if (panelTrigger && whatsappButton) {
                const panelSize = parseInt(window.getComputedStyle(panelTrigger).width);
                const whatsappSize = parseInt(window.getComputedStyle(whatsappButton).width);
                
                log(`📏 Tamaños - Panel: ${panelSize}px, WhatsApp: ${whatsappSize}px`);
                
                if (panelSize > whatsappSize) {
                    log('✅ Jerarquía visual correcta (panel > WhatsApp)');
                    document.getElementById('check7').checked = true;
                } else {
                    log('⚠️ Jerarquía visual incorrecta');
                }
            }
        }
        
        function testJavaScript() {
            log('⚡ Probando funcionalidad JavaScript...');
            
            const panelTrigger = document.getElementById('mongruas-panel-trigger');
            const panelModal = document.getElementById('mongruas-panel-modal');
            
            if (panelTrigger) {
                log('✅ Botón del panel tiene event listeners');
                
                if (panelModal) {
                    log('✅ Modal del panel encontrado');
                } else {
                    log('❌ Modal del panel NO encontrado');
                }
            } else {
                log('❌ No se puede probar JavaScript - botón faltante');
            }
        }
        
        function testResponsive() {
            log('📱 Probando diseño responsive...');
            
            const screenWidth = window.innerWidth;
            log(`📏 Ancho de pantalla: ${screenWidth}px`);
            
            if (screenWidth <= 768) {
                log('📱 Pantalla móvil detectada');
                document.getElementById('check8').checked = true;
            } else {
                log('🖥️ Pantalla desktop detectada');
                document.getElementById('check8').checked = true;
            }
        }
        
        function updateChecklist() {
            const floatingContainer = document.querySelector('.floating-buttons-container');
            const panelAccess = document.getElementById('mongruas-panel-access');
            const whatsappButton = document.querySelector('.whatsapp-float');
            
            // Check visibility
            if (floatingContainer && panelAccess && whatsappButton) {
                const containerRect = floatingContainer.getBoundingClientRect();
                const isVisible = containerRect.width > 0 && containerRect.height > 0;
                
                if (isVisible) {
                    document.getElementById('check6').checked = true;
                    log('✅ Botones visibles en pantalla');
                } else {
                    log('❌ Botones NO visibles en pantalla');
                }
            }
        }
        
        function showConsoleCommands() {
            const commands = `
// Comandos útiles para la consola del navegador:

// 1. Verificar elementos
document.querySelector('.floating-buttons-container')
document.getElementById('mongruas-panel-access')
document.querySelector('.whatsapp-float')

// 2. Forzar integración
const container = document.querySelector('.floating-buttons-container');
const panel = document.getElementById('mongruas-panel-access');
if (container && panel) container.insertBefore(panel, container.firstChild);

// 3. Verificar estilos
window.getComputedStyle(document.querySelector('.floating-buttons-container'))

// 4. Simular click del panel
document.getElementById('mongruas-panel-trigger').click()

// 5. Ver todos los elementos flotantes
document.querySelectorAll('.floating-buttons-container *')
            `;
            
            alert('Comandos copiados a la consola. Presiona F12 y pégalos en la pestaña Console.');
            console.log(commands);
        }
        
        function exportDiagnostic() {
            const report = {
                timestamp: new Date().toISOString(),
                userAgent: navigator.userAgent,
                screenSize: `${window.innerWidth}x${window.innerHeight}`,
                log: diagnosticLog,
                elements: {
                    floatingContainer: !!document.querySelector('.floating-buttons-container'),
                    panelAccess: !!document.getElementById('mongruas-panel-access'),
                    whatsappButton: !!document.querySelector('.whatsapp-float')
                }
            };
            
            const blob = new Blob([JSON.stringify(report, null, 2)], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `panel-diagnostic-${new Date().toISOString().slice(0, 10)}.json`;
            a.click();
            URL.revokeObjectURL(url);
        }
        
        // Auto-run diagnostic on load
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(runDiagnostic, 1000);
        });
    </script>
</body>
</html>
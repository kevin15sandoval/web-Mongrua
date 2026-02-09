<?php
/**
 * 🚀 SOLUCIÓN RÁPIDA - Panel de Cursos
 * 
 * Arregla el problema del botón "Añadir Curso" de forma simple
 */

// Cargar WordPress
require_once('wp-load.php');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚀 Solución Rápida</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f0f0f0;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .btn {
            background: #007cba;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin: 10px 5px;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn:hover {
            background: #005a87;
        }
        
        .btn.success {
            background: #28a745;
        }
        
        .btn.danger {
            background: #dc3545;
        }
        
        .status {
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            border-left: 4px solid #007cba;
            background: #f8f9fa;
        }
        
        .error {
            border-left-color: #dc3545;
            background: #f8d7da;
        }
        
        .success {
            border-left-color: #28a745;
            background: #d4edda;
        }
        
        pre {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Solución Rápida del Panel</h1>
        <p>Vamos a arreglar el problema del botón "Añadir Curso" paso a paso.</p>
        
        <?php
        $current_user = wp_get_current_user();
        $is_logged_in = $current_user->ID > 0;
        $is_admin = current_user_can('administrator');
        ?>
        
        <div class="status <?php echo $is_admin ? 'success' : 'error'; ?>">
            <h3>📊 Estado Actual</h3>
            <p><strong>Usuario:</strong> <?php echo $is_logged_in ? $current_user->user_login : 'No logueado'; ?></p>
            <p><strong>Es Admin:</strong> <?php echo $is_admin ? '✅ Sí' : '❌ No'; ?></p>
        </div>
        
        <?php if (!$is_admin): ?>
            <div class="status error">
                <h3>⚠️ Problema Principal</h3>
                <p>No estás logueado como administrador. El panel solo funciona para administradores.</p>
                <a href="/verificar-usuarios-wp.php" class="btn">🔑 Arreglar Usuario</a>
            </div>
        <?php else: ?>
            <div class="status success">
                <h3>✅ Usuario Correcto</h3>
                <p>Eres administrador. Ahora vamos a arreglar el JavaScript.</p>
            </div>
            
            <div class="status">
                <h3>🔧 Acciones de Reparación</h3>
                <button class="btn" onclick="arreglarJavaScript()">🔧 Arreglar JavaScript</button>
                <button class="btn" onclick="probarPanel()">🧪 Probar Panel</button>
                <button class="btn success" onclick="abrirPanel()">🎯 Abrir Panel</button>
            </div>
            
            <div id="resultado" class="status" style="display: none;">
                <h3>📋 Resultado</h3>
                <div id="resultado-contenido"></div>
            </div>
        <?php endif; ?>
        
        <div class="status">
            <h3>🔗 Enlaces Útiles</h3>
            <a href="/" class="btn">🏠 Sitio Principal</a>
            <a href="/wp-admin/" class="btn">🚪 WordPress Admin</a>
            <a href="/diagnostico-completo.php" class="btn">🔍 Diagnóstico</a>
        </div>
    </div>
    
    <?php if ($is_admin): ?>
        <!-- Cargar WordPress scripts -->
        <?php wp_head(); ?>
        
        <script>
        function mostrarResultado(mensaje, tipo = 'success') {
            const resultado = document.getElementById('resultado');
            const contenido = document.getElementById('resultado-contenido');
            
            resultado.style.display = 'block';
            resultado.className = 'status ' + tipo;
            contenido.innerHTML = mensaje;
        }
        
        function arreglarJavaScript() {
            mostrarResultado('🔧 Arreglando JavaScript...', '');
            
            // Verificar si jQuery está cargado
            if (typeof jQuery === 'undefined') {
                mostrarResultado('❌ jQuery no está cargado. Recargando página...', 'error');
                setTimeout(() => window.location.reload(), 2000);
                return;
            }
            
            // Verificar si el panel está cargado
            if (typeof mongruasPanelAjax === 'undefined') {
                mostrarResultado('❌ Scripts del panel no cargados. Recargando página...', 'error');
                setTimeout(() => window.location.reload(), 2000);
                return;
            }
            
            mostrarResultado('✅ JavaScript funcionando correctamente!', 'success');
        }
        
        function probarPanel() {
            mostrarResultado('🧪 Probando panel...', '');
            
            // Verificar elementos del panel
            const panelButton = document.getElementById('mongruas-panel-access');
            const modal = document.getElementById('mongruas-panel-modal');
            
            let reporte = '<h4>📊 Reporte:</h4>';
            reporte += '<p>Botón del panel: ' + (panelButton ? '✅ Encontrado' : '❌ No encontrado') + '</p>';
            reporte += '<p>Modal del panel: ' + (modal ? '✅ Encontrado' : '❌ No encontrado') + '</p>';
            
            if (typeof jQuery !== 'undefined') {
                reporte += '<p>jQuery: ✅ Cargado</p>';
            } else {
                reporte += '<p>jQuery: ❌ No cargado</p>';
            }
            
            if (typeof mongruasPanelAjax !== 'undefined') {
                reporte += '<p>Panel Ajax: ✅ Configurado</p>';
            } else {
                reporte += '<p>Panel Ajax: ❌ No configurado</p>';
            }
            
            mostrarResultado(reporte, 'success');
        }
        
        function abrirPanel() {
            // Buscar el botón del panel
            const panelButton = document.getElementById('mongruas-panel-trigger');
            
            if (panelButton) {
                mostrarResultado('🎯 Abriendo panel...', 'success');
                panelButton.click();
            } else {
                mostrarResultado('❌ No se encontró el botón del panel. Ve al sitio principal primero.', 'error');
            }
        }
        
        // Auto-ejecutar verificación
        setTimeout(() => {
            arreglarJavaScript();
        }, 1000);
        </script>
        
        <?php wp_footer(); ?>
    <?php endif; ?>
</body>
</html>
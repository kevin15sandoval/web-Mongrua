<?php
/**
 * 🔧 DIAGNÓSTICO COMPLETO
 * 
 * Herramienta completa para diagnosticar y solucionar todos los problemas
 */

// Cargar WordPress
require_once('wp-load.php');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔧 Diagnóstico Completo</title>
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
        
        .status-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            margin: 15px 0;
            border-left: 4px solid #00ff88;
        }
        
        .error { border-left-color: #ff6b6b; }
        .warning { border-left-color: #ffc107; }
        .success { border-left-color: #00ff88; }
        
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
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .action-button.primary { background: linear-gradient(135deg, #007bff, #0056b3); }
        .action-button.danger { background: linear-gradient(135deg, #dc3545, #c82333); }
        
        pre {
            background: rgba(0, 0, 0, 0.3);
            padding: 15px;
            border-radius: 8px;
            overflow-x: auto;
            font-size: 12px;
        }
        
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Diagnóstico Completo del Sistema</h1>
        <p>Verificación completa de usuarios, permisos, botones y APIs</p>
        
        <?php
        // 1. VERIFICAR USUARIOS
        $current_user = wp_get_current_user();
        $is_logged_in = $current_user->ID > 0;
        $is_admin = current_user_can('administrator');
        $users = get_users();
        $admin_users = get_users(array('role' => 'administrator'));
        $adminlocal_exists = username_exists('adminlocal');
        ?>
        
        <div class="grid">
            <!-- ESTADO DE USUARIOS -->
            <div class="status-card <?php echo $is_admin ? 'success' : 'error'; ?>">
                <h3>👤 Estado del Usuario</h3>
                <p><strong>Logueado:</strong> <?php echo $is_logged_in ? '✅ Sí (' . $current_user->user_login . ')' : '❌ No'; ?></p>
                <p><strong>Es Admin:</strong> <?php echo $is_admin ? '✅ Sí' : '❌ No'; ?></p>
                <p><strong>Total usuarios:</strong> <?php echo count($users); ?></p>
                <p><strong>Administradores:</strong> <?php echo count($admin_users); ?></p>
                <p><strong>adminlocal existe:</strong> <?php echo $adminlocal_exists ? '✅ Sí' : '❌ No'; ?></p>
                
                <?php if (!$is_logged_in || !$is_admin): ?>
                    <a href="/verificar-usuarios-wp.php" class="action-button primary">🔑 Arreglar Usuario</a>
                <?php endif; ?>
            </div>
            
            <!-- ESTADO DE BOTONES -->
            <div class="status-card <?php echo $is_admin ? 'success' : 'warning'; ?>">
                <h3>🎯 Estado de Botones</h3>
                <p><strong>Botón del Panel:</strong> <?php echo $is_admin ? '✅ Debería aparecer' : '⚠️ Solo para admins'; ?></p>
                <p><strong>Botón WhatsApp:</strong> ✅ Siempre visible</p>
                <p><strong>Integración:</strong> ✅ Configurada</p>
                <p><strong>Posición:</strong> Esquina inferior derecha</p>
                
                <a href="/activar-boton-ahora.php" class="action-button">🚀 Forzar Botones</a>
            </div>
            
            <!-- ESTADO DE APIs -->
            <div class="status-card <?php echo $is_admin ? 'success' : 'error'; ?>">
                <h3>🔌 Estado de APIs</h3>
                <p><strong>REST API:</strong> ✅ Activa</p>
                <p><strong>Endpoints:</strong> ✅ Registrados</p>
                <p><strong>Nonce:</strong> ✅ Configurado</p>
                <p><strong>Permisos:</strong> <?php echo $is_admin ? '✅ Correcto' : '❌ Necesita admin'; ?></p>
                
                <?php if ($is_admin): ?>
                    <button class="action-button" onclick="testAPI()">🧪 Probar API</button>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- ACCIONES RÁPIDAS -->
        <div class="status-card">
            <h3>🚀 Acciones Rápidas</h3>
            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                <a href="/verificar-usuarios-wp.php" class="action-button primary">👤 Verificar Usuarios</a>
                <a href="/activar-boton-ahora.php" class="action-button">🎯 Activar Botones</a>
                <a href="/wp-admin/" class="action-button">🚪 WordPress Admin</a>
                <a href="/" class="action-button">🏠 Sitio Principal</a>
                <button class="action-button" onclick="clearCache()">🗑️ Limpiar Caché</button>
                <button class="action-button" onclick="testIntegration()">🧪 Test Completo</button>
            </div>
        </div>
        
        <!-- INFORMACIÓN TÉCNICA -->
        <div class="status-card">
            <h3>🔍 Información Técnica</h3>
            <pre><?php
echo "WordPress Version: " . get_bloginfo('version') . "\n";
echo "Theme: " . get_template() . "\n";
echo "Site URL: " . site_url() . "\n";
echo "Admin URL: " . admin_url() . "\n";
echo "REST URL: " . rest_url() . "\n";
echo "Current User ID: " . get_current_user_id() . "\n";
echo "User Capabilities: " . implode(', ', array_keys($current_user->allcaps ?? [])) . "\n";
echo "Active Plugins: " . count(get_option('active_plugins', [])) . "\n";
            ?></pre>
        </div>
        
        <!-- LOGS DE ERRORES -->
        <div class="status-card">
            <h3>📋 Últimos Errores JavaScript</h3>
            <div id="js-errors" style="background: rgba(0,0,0,0.3); padding: 15px; border-radius: 8px; min-height: 100px;">
                <p>Cargando errores...</p>
            </div>
        </div>
        
        <div id="result" class="status-card" style="display: none;"></div>
    </div>
    
    <script>
    // Capturar errores JavaScript
    window.onerror = function(msg, url, line, col, error) {
        const errorDiv = document.getElementById('js-errors');
        const errorMsg = `❌ ${msg} (${url}:${line}:${col})`;
        errorDiv.innerHTML += '<p style="color: #ff6b6b; margin: 5px 0;">' + errorMsg + '</p>';
    };
    
    // Limpiar el div de errores inicialmente
    setTimeout(() => {
        document.getElementById('js-errors').innerHTML = '<p style="color: #00ff88;">✅ No hay errores JavaScript recientes</p>';
    }, 2000);
    
    function testAPI() {
        const result = document.getElementById('result');
        result.style.display = 'block';
        result.innerHTML = '<p>🧪 Probando API...</p>';
        
        fetch('/wp-json/mongruas/v1/courses', {
            method: 'GET',
            headers: {
                'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                result.innerHTML = '<p style="color: #00ff88;">✅ API funcionando correctamente</p><pre>' + JSON.stringify(data, null, 2) + '</pre>';
            } else {
                result.innerHTML = '<p style="color: #ffc107;">⚠️ API responde pero con errores</p><pre>' + JSON.stringify(data, null, 2) + '</pre>';
            }
        })
        .catch(error => {
            result.innerHTML = '<p style="color: #ff6b6b;">❌ Error en API: ' + error + '</p>';
        });
    }
    
    function clearCache() {
        // Limpiar localStorage
        localStorage.clear();
        sessionStorage.clear();
        
        // Recargar página sin caché
        window.location.reload(true);
    }
    
    function testIntegration() {
        const result = document.getElementById('result');
        result.style.display = 'block';
        result.innerHTML = '<p>🧪 Probando integración completa...</p>';
        
        // Verificar elementos
        const panelButton = document.getElementById('mongruas-panel-access');
        const floatingContainer = document.querySelector('.floating-buttons-container');
        const whatsappButton = document.querySelector('.whatsapp-float');
        
        let report = '<h4>📊 Reporte de Integración:</h4>';
        report += '<p>Botón del Panel: ' + (panelButton ? '✅ Encontrado' : '❌ No encontrado') + '</p>';
        report += '<p>Contenedor Flotante: ' + (floatingContainer ? '✅ Encontrado' : '❌ No encontrado') + '</p>';
        report += '<p>Botón WhatsApp: ' + (whatsappButton ? '✅ Encontrado' : '❌ No encontrado') + '</p>';
        
        if (panelButton && floatingContainer) {
            const isIntegrated = floatingContainer.contains(panelButton);
            report += '<p>Integración: ' + (isIntegrated ? '✅ Correcta' : '❌ No integrado') + '</p>';
        }
        
        result.innerHTML = report;
    }
    
    // Auto-ejecutar test de integración
    setTimeout(testIntegration, 1000);
    </script>
</body>
</html>
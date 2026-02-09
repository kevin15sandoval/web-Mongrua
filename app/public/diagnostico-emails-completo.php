<?php
/**
 * 🔍 DIAGNÓSTICO COMPLETO DE EMAILS
 * 
 * Herramienta para diagnosticar problemas de envío de emails
 */

// Cargar WordPress
require_once('wp-load.php');

// Verificar que el usuario sea administrador
if (!current_user_can('administrator')) {
    wp_redirect('/wp-admin/');
    exit;
}

// Función para probar envío de email
function probar_envio_email($destinatario, $asunto, $mensaje) {
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>'
    );
    
    $resultado = wp_mail($destinatario, $asunto, $mensaje, $headers);
    return $resultado;
}

// Función para obtener configuración SMTP
function obtener_config_smtp() {
    $config = array();
    
    // Verificar si hay plugins SMTP activos
    $smtp_plugins = array(
        'wp-mail-smtp/wp_mail_smtp.php' => 'WP Mail SMTP',
        'easy-wp-smtp/easy-wp-smtp.php' => 'Easy WP SMTP',
        'post-smtp/postman-smtp.php' => 'Post SMTP',
        'wp-smtp/wp-smtp.php' => 'WP SMTP'
    );
    
    foreach ($smtp_plugins as $plugin => $name) {
        if (is_plugin_active($plugin)) {
            $config['smtp_plugin'] = $name;
            break;
        }
    }
    
    if (empty($config['smtp_plugin'])) {
        $config['smtp_plugin'] = 'PHP mail() function (no SMTP plugin)';
    }
    
    return $config;
}

// Procesar acciones
$mensaje = '';
$tipo_mensaje = '';
$test_result = null;

if ($_POST && isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    
    if ($accion === 'test_email' && isset($_POST['email_destino'])) {
        $email_destino = sanitize_email($_POST['email_destino']);
        
        if ($email_destino) {
            $asunto = 'Prueba de Email - ' . get_bloginfo('name');
            $mensaje_test = "Este es un email de prueba enviado desde tu sitio web.\n\n";
            $mensaje_test .= "Sitio: " . get_bloginfo('name') . "\n";
            $mensaje_test .= "URL: " . get_site_url() . "\n";
            $mensaje_test .= "Fecha: " . current_time('Y-m-d H:i:s') . "\n\n";
            $mensaje_test .= "Si recibes este email, la configuración está funcionando correctamente.";
            
            $test_result = probar_envio_email($email_destino, $asunto, $mensaje_test);
            
            if ($test_result) {
                $mensaje = "✅ Email de prueba enviado correctamente a $email_destino";
                $tipo_mensaje = 'success';
            } else {
                $mensaje = "❌ Error al enviar email de prueba a $email_destino";
                $tipo_mensaje = 'error';
            }
        }
    }
}

// Obtener información del sistema
$admin_email = get_option('admin_email');
$smtp_config = obtener_config_smtp();
$server_info = array(
    'PHP Version' => phpversion(),
    'WordPress Version' => get_bloginfo('version'),
    'Server Software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
    'Mail Function' => function_exists('mail') ? 'Disponible' : 'No disponible'
);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔍 Diagnóstico Completo de Emails</title>
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
        
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #74c0fc;
        }
        
        .info-value {
            color: #51cf66;
            font-family: monospace;
            text-align: right;
        }
        
        .info-value.warning {
            color: #ffd43b;
        }
        
        .info-value.error {
            color: #ff6b6b;
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
        
        .form-group {
            margin: 15px 0;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        .form-group input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            box-sizing: border-box;
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
            color: #ffd43b;
        }
        
        h1, h2, h3 {
            text-align: center;
        }
        
        .code-block {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            padding: 15px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            margin: 10px 0;
            overflow-x: auto;
        }
        
        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .status-ok { background: #51cf66; }
        .status-warning { background: #ffd43b; }
        .status-error { background: #ff6b6b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="big-icon">🔍</div>
        <h1>Diagnóstico Completo de Emails</h1>
        <p style="text-align: center;">Diagnostica y soluciona problemas de envío de emails</p>
        
        <?php if ($mensaje): ?>
            <div class="alert <?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <div class="grid">
            <!-- Configuración Actual -->
            <div class="section">
                <h3>⚙️ Configuración Actual</h3>
                <div class="info-item">
                    <span class="info-label">Email Administrativo:</span>
                    <span class="info-value"><?php echo esc_html($admin_email); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Plugin SMTP:</span>
                    <span class="info-value <?php echo $smtp_config['smtp_plugin'] === 'PHP mail() function (no SMTP plugin)' ? 'warning' : ''; ?>">
                        <?php echo esc_html($smtp_config['smtp_plugin']); ?>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Función mail():</span>
                    <span class="info-value <?php echo function_exists('mail') ? '' : 'error'; ?>">
                        <?php echo function_exists('mail') ? '✅ Disponible' : '❌ No disponible'; ?>
                    </span>
                </div>
            </div>
            
            <!-- Información del Servidor -->
            <div class="section">
                <h3>🖥️ Información del Servidor</h3>
                <?php foreach ($server_info as $label => $value): ?>
                    <div class="info-item">
                        <span class="info-label"><?php echo $label; ?>:</span>
                        <span class="info-value"><?php echo esc_html($value); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Prueba de Envío -->
        <div class="section">
            <h3>🧪 Prueba de Envío de Email</h3>
            <form method="post">
                <input type="hidden" name="accion" value="test_email">
                <div class="form-group">
                    <label for="email_destino">Email de destino para la prueba:</label>
                    <input type="email" id="email_destino" name="email_destino" 
                           value="<?php echo esc_attr($admin_email); ?>" required>
                </div>
                <button type="submit" class="action-button primary">📧 Enviar Email de Prueba</button>
            </form>
            
            <?php if ($test_result !== null): ?>
                <div class="code-block">
                    <strong>Resultado de la prueba:</strong><br>
                    <?php if ($test_result): ?>
                        ✅ wp_mail() retornó TRUE - El email fue procesado correctamente por WordPress
                    <?php else: ?>
                        ❌ wp_mail() retornó FALSE - Hubo un error al procesar el email
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Diagnóstico y Soluciones -->
        <div class="section">
            <h3>🔧 Diagnóstico y Soluciones</h3>
            
            <?php if ($smtp_config['smtp_plugin'] === 'PHP mail() function (no SMTP plugin)'): ?>
                <div class="alert warning">
                    <span class="status-indicator status-warning"></span>
                    <strong>⚠️ No tienes un plugin SMTP configurado</strong><br>
                    Esto puede causar problemas de entrega. Los emails pueden ir a spam o no enviarse.
                    <br><br>
                    <strong>Solución recomendada:</strong>
                    <div class="code-block">
1. Instala un plugin SMTP como "WP Mail SMTP"
2. Configúralo con tu proveedor de email (Gmail, Outlook, etc.)
3. Esto mejorará significativamente la entrega de emails
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="alert">
                <strong>🔍 Posibles causas de problemas:</strong>
                <div class="code-block">
• Emails van a la carpeta de SPAM
• Servidor no configurado para enviar emails
• Plugin SMTP mal configurado
• Firewall bloqueando emails salientes
• Límites del hosting para envío de emails
                </div>
            </div>
            
            <div class="alert">
                <strong>✅ Pasos para solucionar:</strong>
                <div class="code-block">
1. Revisa tu carpeta de SPAM/Correo no deseado
2. Instala y configura WP Mail SMTP
3. Usa un servicio como Gmail SMTP o SendGrid
4. Contacta a tu proveedor de hosting
5. Verifica que el dominio tenga registros SPF/DKIM
                </div>
            </div>
        </div>
        
        <div class="section" style="text-align: center;">
            <h3>🚀 Acciones Rápidas</h3>
            <a href="/wp-admin/plugin-install.php?s=wp+mail+smtp&tab=search&type=term" 
               class="action-button primary" target="_blank">📧 Instalar WP Mail SMTP</a>
            <a href="/verificar-correos.php" class="action-button">📬 Verificar Correos</a>
            <a href="/probar-formulario-contacto.php" class="action-button">📝 Probar Formulario</a>
            <a href="/" class="action-button">🏠 Sitio Principal</a>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <p style="color: rgba(255,255,255,0.7); font-size: 14px;">
                💡 Si el problema persiste, contacta a tu proveedor de hosting para verificar la configuración del servidor
            </p>
        </div>
    </div>
</body>
</html>
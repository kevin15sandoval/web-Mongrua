<?php
/**
 * 📧 VERIFICAR CONFIGURACIÓN DE CORREOS
 * 
 * Este archivo te ayuda a verificar y configurar dónde van los correos del formulario
 */

// Cargar WordPress
require_once('wp-load.php');

// Función para probar el envío de correos
function probar_envio_correo($email_destino) {
    $subject = 'Prueba de correo - Mogruas';
    $message = "Este es un correo de prueba enviado desde el sitio web de Mogruas.\n\n";
    $message .= "Si recibes este correo, significa que la configuración está funcionando correctamente.\n\n";
    $message .= "Fecha y hora: " . current_time('mysql') . "\n";
    $message .= "Sitio web: " . get_site_url();
    
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>'
    );
    
    return wp_mail($email_destino, $subject, $message, $headers);
}

// Procesar acciones
$accion = $_GET['accion'] ?? '';
$resultado_prueba = null;

if ($accion === 'probar' && !empty($_GET['email'])) {
    $email_prueba = sanitize_email($_GET['email']);
    if (is_email($email_prueba)) {
        $resultado_prueba = probar_envio_correo($email_prueba);
    }
}

if ($accion === 'cambiar_email' && !empty($_POST['nuevo_email'])) {
    $nuevo_email = sanitize_email($_POST['nuevo_email']);
    if (is_email($nuevo_email)) {
        update_option('admin_email', $nuevo_email);
        $mensaje_cambio = "✅ Email administrativo cambiado a: $nuevo_email";
    } else {
        $mensaje_cambio = "❌ Email inválido";
    }
}

// Obtener configuración actual
$admin_email = get_option('admin_email');
$site_name = get_bloginfo('name');
$site_url = get_site_url();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📧 Verificar Correos - Mogruas</title>
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
        
        .code-block {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            padding: 15px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            margin: 10px 0;
            overflow-x: auto;
        }
        
        h1, h2, h3 {
            text-align: center;
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
        <div class="big-icon">📧</div>
        <h1>Verificar Configuración de Correos</h1>
        <p style="text-align: center;">Aquí puedes ver y configurar dónde van los correos del formulario de contacto</p>
        
        <?php if (isset($mensaje_cambio)): ?>
            <div class="alert <?php echo strpos($mensaje_cambio, '✅') !== false ? 'success' : 'error'; ?>">
                <?php echo $mensaje_cambio; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($resultado_prueba !== null): ?>
            <div class="alert <?php echo $resultado_prueba ? 'success' : 'error'; ?>">
                <?php if ($resultado_prueba): ?>
                    ✅ ¡Correo de prueba enviado correctamente! Revisa tu bandeja de entrada.
                <?php else: ?>
                    ❌ Error al enviar el correo de prueba. Revisa la configuración del servidor.
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <div class="section">
            <h3>📋 Configuración Actual</h3>
            <div class="info-item">
                <span class="info-label">Sitio Web:</span>
                <span class="info-value"><?php echo esc_html($site_name); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">URL:</span>
                <span class="info-value"><?php echo esc_html($site_url); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Email Administrativo:</span>
                <span class="info-value"><?php echo esc_html($admin_email); ?></span>
            </div>
        </div>
        
        <div class="alert warning">
            <strong>📍 ¿Dónde van los correos?</strong><br>
            Actualmente, todos los correos del formulario de contacto se envían a: <strong><?php echo esc_html($admin_email); ?></strong><br>
            Este es el email administrativo de WordPress.
        </div>
        
        <div class="grid">
            <div class="section">
                <h3>🧪 Probar Envío</h3>
                <p>Envía un correo de prueba para verificar que funciona:</p>
                <form method="get" style="margin: 15px 0;">
                    <input type="hidden" name="accion" value="probar">
                    <div class="form-group">
                        <label for="email">Email de destino:</label>
                        <input type="email" id="email" name="email" value="<?php echo esc_attr($admin_email); ?>" required>
                    </div>
                    <button type="submit" class="action-button primary">📤 Enviar Prueba</button>
                </form>
            </div>
            
            <div class="section">
                <h3>⚙️ Cambiar Email</h3>
                <p>Cambiar el email donde llegan los formularios:</p>
                <form method="post" style="margin: 15px 0;">
                    <input type="hidden" name="accion" value="cambiar_email">
                    <div class="form-group">
                        <label for="nuevo_email">Nuevo email:</label>
                        <input type="email" id="nuevo_email" name="nuevo_email" value="<?php echo esc_attr($admin_email); ?>" required>
                    </div>
                    <button type="submit" class="action-button">💾 Cambiar Email</button>
                </form>
            </div>
        </div>
        
        <div class="section">
            <h3>📝 Cómo Funciona el Formulario</h3>
            <div class="code-block">
1. Usuario llena el formulario en el sitio web
2. Los datos se envían a: <?php echo esc_html($site_url); ?>/wp-admin/admin-ajax.php
3. WordPress procesa el formulario con la función: mongruas_handle_contact_form()
4. Se envía un correo a: <?php echo esc_html($admin_email); ?>

5. El correo incluye:
   - Nombre del usuario
   - Email del usuario
   - Teléfono
   - Tipo de consulta
   - Empresa (si la proporciona)
   - Mensaje
            </div>
        </div>
        
        <div class="section">
            <h3>🔧 Solucionar Problemas</h3>
            <div style="text-align: left;">
                <h4>Si no recibes correos:</h4>
                <ul>
                    <li><strong>Revisa la carpeta de SPAM</strong> - Los correos automáticos suelen ir ahí</li>
                    <li><strong>Verifica el email administrativo</strong> - Debe ser un email que revises regularmente</li>
                    <li><strong>Configura SMTP</strong> - Para mejor entrega, usa un plugin como WP Mail SMTP</li>
                    <li><strong>Contacta tu hosting</strong> - Algunos hostings bloquean el envío de correos</li>
                </ul>
                
                <h4>Emails recomendados:</h4>
                <ul>
                    <li>info@mongruas.com</li>
                    <li>contacto@mongruas.com</li>
                    <li>Tu email personal que revises diariamente</li>
                </ul>
            </div>
        </div>
        
        <div class="section" style="text-align: center;">
            <h3>🚀 Acciones Rápidas</h3>
            <a href="/wp-admin/options-general.php" class="action-button primary">⚙️ Configuración WP</a>
            <a href="/wp-admin/plugins.php" class="action-button">🔌 Plugins</a>
            <a href="/" class="action-button">🏠 Sitio Principal</a>
            <a href="/contacto/" class="action-button">📞 Página Contacto</a>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <p style="color: rgba(255,255,255,0.7); font-size: 14px;">
                💡 Tip: Para cambiar el email permanentemente, ve a WordPress Admin → Configuración → General
            </p>
        </div>
    </div>
</body>
</html>
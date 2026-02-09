<?php
/**
 * Test de Envío de Emails
 * Prueba si WordPress puede enviar correos
 */

require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>📧 Test de Envío de Emails</h1>";

$mensaje_resultado = '';

// Procesar envío de prueba
if (isset($_POST['enviar_test'])) {
    $email_destino = sanitize_email($_POST['email_destino']);
    $asunto = 'Test de Email desde CRM Mongruas';
    $mensaje = '
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #0066cc, #0052a3); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
            .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 10px 10px; }
            .button { background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 20px 0; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>✅ Email de Prueba</h1>
            </div>
            <div class="content">
                <h2>¡Hola!</h2>
                <p>Este es un email de prueba desde tu CRM de Mongruas Formación.</p>
                <p>Si estás recibiendo este mensaje, significa que el sistema de envío de emails está funcionando correctamente.</p>
                <p><strong>Fecha y hora:</strong> ' . date('d/m/Y H:i:s') . '</p>
                <a href="' . home_url('/crm-mailing-completo.php') . '" class="button">Ir al CRM</a>
                <hr style="margin: 30px 0; border: none; border-top: 1px solid #ddd;">
                <p style="color: #718096; font-size: 12px;">
                    Este es un email automático de prueba.<br>
                    Mongruas Formación - Sistema CRM
                </p>
            </div>
        </div>
    </body>
    </html>
    ';
    
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Mongruas Formación <noreply@mongruasformacion.local>'
    );
    
    $resultado = wp_mail($email_destino, $asunto, $mensaje, $headers);
    
    if ($resultado) {
        $mensaje_resultado = "
        <div style='background: #d4edda; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #28a745;'>
            <h2 style='color: #155724; margin: 0 0 10px 0;'>✅ ¡Email Enviado!</h2>
            <p style='color: #155724; margin: 0;'>El email se envió correctamente a: <strong>$email_destino</strong></p>
            <p style='color: #155724; margin: 10px 0 0 0;'>Revisa tu bandeja de entrada (y spam por si acaso).</p>
        </div>
        ";
    } else {
        $mensaje_resultado = "
        <div style='background: #f8d7da; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #dc3545;'>
            <h2 style='color: #721c24; margin: 0 0 10px 0;'>❌ Error al Enviar</h2>
            <p style='color: #721c24; margin: 0;'>No se pudo enviar el email. Posibles causas:</p>
            <ul style='color: #721c24;'>
                <li>El servidor local no tiene configurado el envío de emails</li>
                <li>Necesitas un plugin SMTP como WP Mail SMTP</li>
                <li>El email de destino no es válido</li>
            </ul>
        </div>
        ";
    }
}

echo $mensaje_resultado;
?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background: #f1f3f4;
}

h1, h2 {
    color: #2d3748;
}

.info-box {
    background: #e7f3ff;
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
    border-left: 4px solid #0066cc;
}

.form-container {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin: 20px 0;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: 700;
    margin-bottom: 8px;
    color: #2d3748;
}

.form-group input {
    width: 100%;
    padding: 12px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 16px;
}

.btn {
    padding: 15px 30px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    font-size: 16px;
    text-decoration: none;
    display: inline-block;
}

.btn-primary {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
}

.btn-success {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}
</style>

<div class="info-box">
    <h2 style="color: #0066cc; margin: 0 0 10px 0;">ℹ️ Información Importante</h2>
    <p style="margin: 0 0 10px 0;"><strong>En desarrollo local (Local by Flywheel):</strong></p>
    <ul style="margin: 0;">
        <li>Por defecto, los emails NO se envían realmente</li>
        <li>Necesitas instalar un plugin como <strong>WP Mail SMTP</strong> o <strong>MailHog</strong></li>
        <li>O configurar un servicio SMTP (Gmail, SendGrid, etc.)</li>
    </ul>
</div>

<div class="form-container">
    <h2>📧 Enviar Email de Prueba</h2>
    <form method="post">
        <div class="form-group">
            <label>Email de Destino:</label>
            <input type="email" name="email_destino" required placeholder="tu@email.com" value="<?php echo isset($_POST['email_destino']) ? esc_attr($_POST['email_destino']) : ''; ?>">
        </div>
        <button type="submit" name="enviar_test" class="btn btn-primary">📤 Enviar Email de Prueba</button>
    </form>
</div>

<div class="info-box" style="background: #fff3cd; border-left-color: #ffc107;">
    <h2 style="color: #856404; margin: 0 0 10px 0;">⚙️ Configuración Recomendada</h2>
    <p style="color: #856404; margin: 0 0 10px 0;"><strong>Para enviar emails reales, instala WP Mail SMTP:</strong></p>
    <ol style="color: #856404; margin: 0;">
        <li>Ve a WordPress Admin → Plugins → Añadir nuevo</li>
        <li>Busca "WP Mail SMTP"</li>
        <li>Instala y activa el plugin</li>
        <li>Configura con tu cuenta de Gmail o servicio SMTP</li>
    </ol>
</div>

<div style="text-align: center; margin: 30px 0;">
    <a href="crm-mailing-completo.php" class="btn btn-success">🏠 Volver al CRM</a>
    <a href="<?php echo admin_url('plugins.php'); ?>" class="btn btn-primary">🔌 Ir a Plugins</a>
</div>

<div class="info-box" style="background: #f8f9fa; border-left-color: #6c757d;">
    <h2 style="color: #2d3748; margin: 0 0 10px 0;">📋 Cómo Usar el Sistema de Campañas</h2>
    <ol style="color: #2d3748; margin: 0;">
        <li>Ve al CRM → Pestaña "Campañas de Email"</li>
        <li>Crea una nueva campaña con nombre y asunto</li>
        <li>Escribe el contenido HTML del email</li>
        <li>Selecciona el segmento de clientes (por sector o todos)</li>
        <li>Haz clic en "Enviar" para enviar la campaña</li>
    </ol>
    <p style="color: #718096; margin: 10px 0 0 0; font-size: 14px;">
        <strong>Nota:</strong> Puedes usar [NOMBRE] y [EMPRESA] en el contenido para personalizar los emails.
    </p>
</div>

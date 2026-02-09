<?php
/**
 * 🛠️ SOLUCIONAR EMAILS DEL FORMULARIO
 * 
 * Herramienta específica para solucionar problemas de emails del formulario
 */

// Cargar WordPress
require_once('wp-load.php');

// Verificar que el usuario sea administrador
if (!current_user_can('administrator')) {
    wp_redirect('/wp-admin/');
    exit;
}

// Función para verificar logs de WordPress
function verificar_logs_wordpress() {
    $log_files = array();
    
    // Posibles ubicaciones de logs
    $possible_logs = array(
        ABSPATH . 'wp-content/debug.log',
        ABSPATH . 'debug.log',
        WP_CONTENT_DIR . '/debug.log',
        ini_get('error_log')
    );
    
    foreach ($possible_logs as $log_file) {
        if ($log_file && file_exists($log_file) && is_readable($log_file)) {
            $log_files[] = $log_file;
        }
    }
    
    return $log_files;
}

// Función para leer últimas líneas de log
function leer_ultimas_lineas_log($archivo, $lineas = 20) {
    if (!file_exists($archivo) || !is_readable($archivo)) {
        return false;
    }
    
    $file = file($archivo);
    if (!$file) return false;
    
    $total_lines = count($file);
    $start = max(0, $total_lines - $lineas);
    
    return array_slice($file, $start);
}

// Función para verificar configuración de email
function verificar_configuracion_email() {
    $config = array();
    
    // Verificar configuración básica
    $config['admin_email'] = get_option('admin_email');
    $config['blogname'] = get_bloginfo('name');
    $config['wp_debug'] = defined('WP_DEBUG') && WP_DEBUG;
    $config['wp_debug_log'] = defined('WP_DEBUG_LOG') && WP_DEBUG_LOG;
    
    // Verificar función mail
    $config['mail_function'] = function_exists('mail');
    
    // Verificar plugins SMTP
    $smtp_plugins = array(
        'wp-mail-smtp/wp_mail_smtp.php' => 'WP Mail SMTP',
        'easy-wp-smtp/easy-wp-smtp.php' => 'Easy WP SMTP'
    );
    
    $config['smtp_plugin'] = null;
    foreach ($smtp_plugins as $plugin => $name) {
        if (is_plugin_active($plugin)) {
            $config['smtp_plugin'] = $name;
            break;
        }
    }
    
    return $config;
}

// Procesar acciones
$mensaje = '';
$tipo_mensaje = '';
$accion_realizada = '';

if ($_POST && isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    
    if ($accion === 'activar_debug') {
        // Activar debug de WordPress
        $wp_config_path = ABSPATH . 'wp-config.php';
        if (file_exists($wp_config_path) && is_writable($wp_config_path)) {
            $config_content = file_get_contents($wp_config_path);
            
            // Verificar si ya está activado
            if (strpos($config_content, "define('WP_DEBUG', true)") === false) {
                // Buscar la línea de WP_DEBUG y reemplazarla
                $config_content = preg_replace(
                    "/define\s*\(\s*['\"]WP_DEBUG['\"]\s*,\s*false\s*\)\s*;/",
                    "define('WP_DEBUG', true);",
                    $config_content
                );
                
                // Si no existe, agregar antes de "That's all"
                if (strpos($config_content, "define('WP_DEBUG', true)") === false) {
                    $config_content = str_replace(
                        "/* That's all, stop editing!",
                        "define('WP_DEBUG', true);\ndefine('WP_DEBUG_LOG', true);\n\n/* That's all, stop editing!",
                        $config_content
                    );
                }
                
                file_put_contents($wp_config_path, $config_content);
                $mensaje = "✅ Debug de WordPress activado correctamente";
                $tipo_mensaje = 'success';
            } else {
                $mensaje = "ℹ️ Debug de WordPress ya estaba activado";
                $tipo_mensaje = 'success';
            }
        } else {
            $mensaje = "❌ No se pudo modificar wp-config.php (permisos)";
            $tipo_mensaje = 'error';
        }
        $accion_realizada = 'debug';
    }
    
    elseif ($accion === 'test_formulario') {
        // Simular envío del formulario
        $_POST['contact_name'] = 'Prueba Sistema';
        $_POST['contact_email'] = get_option('admin_email');
        $_POST['contact_phone'] = '600123456';
        $_POST['consultation_type'] = 'certificados';
        $_POST['contact_message'] = 'Este es un mensaje de prueba del sistema de diagnóstico.';
        $_POST['contact_form_nonce'] = wp_create_nonce('mongruas_contact_form');
        
        // Llamar a la función del formulario
        ob_start();
        do_action('wp_ajax_mongruas_submit_form');
        do_action('wp_ajax_nopriv_mongruas_submit_form');
        $output = ob_get_clean();
        
        $mensaje = "✅ Formulario de prueba procesado. Revisa tu email y los logs.";
        $tipo_mensaje = 'success';
        $accion_realizada = 'test';
    }
}

// Obtener información
$config = verificar_configuracion_email();
$log_files = verificar_logs_wordpress();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🛠️ Solucionar Emails del Formulario</title>
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
            max-width: 1200px;
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
            padding: 8px 0;
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
            font-size: 12px;
            margin: 10px 0;
            overflow-x: auto;
            max-height: 300px;
            overflow-y: auto;
        }
        
        .step-list {
            counter-reset: step-counter;
        }
        
        .step-item {
            counter-increment: step-counter;
            margin: 15px 0;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            position: relative;
            padding-left: 50px;
        }
        
        .step-item::before {
            content: counter(step-counter);
            position: absolute;
            left: 15px;
            top: 15px;
            background: #007bff;
            color: white;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="big-icon">🛠️</div>
        <h1>Solucionar Emails del Formulario</h1>
        <p style="text-align: center;">Diagnostica y soluciona por qué no te llegan los emails del formulario</p>
        
        <?php if ($mensaje): ?>
            <div class="alert <?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <div class="grid">
            <!-- Estado Actual -->
            <div class="section">
                <h3>📊 Estado Actual</h3>
                <div class="info-item">
                    <span class="info-label">Email Admin:</span>
                    <span class="info-value"><?php echo esc_html($config['admin_email']); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Función mail():</span>
                    <span class="info-value <?php echo $config['mail_function'] ? '' : 'error'; ?>">
                        <?php echo $config['mail_function'] ? '✅ Disponible' : '❌ No disponible'; ?>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Plugin SMTP:</span>
                    <span class="info-value <?php echo $config['smtp_plugin'] ? '' : 'warning'; ?>">
                        <?php echo $config['smtp_plugin'] ?: '⚠️ Ninguno'; ?>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Debug WordPress:</span>
                    <span class="info-value <?php echo $config['wp_debug'] ? '' : 'warning'; ?>">
                        <?php echo $config['wp_debug'] ? '✅ Activo' : '⚠️ Inactivo'; ?>
                    </span>
                </div>
            </div>
            
            <!-- Acciones Rápidas -->
            <div class="section">
                <h3>⚡ Acciones Rápidas</h3>
                
                <?php if (!$config['wp_debug']): ?>
                    <form method="post" style="margin: 10px 0;">
                        <input type="hidden" name="accion" value="activar_debug">
                        <button type="submit" class="action-button primary">
                            🔍 Activar Debug de WordPress
                        </button>
                    </form>
                <?php endif; ?>
                
                <form method="post" style="margin: 10px 0;">
                    <input type="hidden" name="accion" value="test_formulario">
                    <button type="submit" class="action-button">
                        🧪 Probar Formulario Ahora
                    </button>
                </form>
                
                <a href="/diagnostico-emails-completo.php" class="action-button primary">
                    🔍 Diagnóstico Completo
                </a>
            </div>
        </div>
        
        <!-- Logs de WordPress -->
        <?php if (!empty($log_files)): ?>
            <div class="section">
                <h3>📋 Logs de WordPress</h3>
                <?php foreach ($log_files as $log_file): ?>
                    <h4>📄 <?php echo esc_html(basename($log_file)); ?></h4>
                    <?php 
                    $log_lines = leer_ultimas_lineas_log($log_file, 15);
                    if ($log_lines): 
                    ?>
                        <div class="code-block">
                            <?php foreach ($log_lines as $line): ?>
                                <?php echo esc_html($line); ?>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p>No se pudieron leer los logs o están vacíos.</p>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <!-- Pasos para Solucionar -->
        <div class="section">
            <h3>🔧 Pasos para Solucionar</h3>
            <div class="step-list">
                <div class="step-item">
                    <strong>Revisa tu carpeta de SPAM</strong><br>
                    Los emails pueden estar llegando a la carpeta de correo no deseado.
                </div>
                
                <div class="step-item">
                    <strong>Activa el debug de WordPress</strong><br>
                    Esto te permitirá ver errores específicos en los logs.
                </div>
                
                <div class="step-item">
                    <strong>Instala un plugin SMTP</strong><br>
                    WP Mail SMTP mejora significativamente la entrega de emails.
                    <br><br>
                    <a href="/wp-admin/plugin-install.php?s=wp+mail+smtp&tab=search&type=term" 
                       class="action-button primary" target="_blank">📧 Instalar WP Mail SMTP</a>
                </div>
                
                <div class="step-item">
                    <strong>Configura SMTP con Gmail</strong><br>
                    Usa tu cuenta de Gmail para enviar emails de forma confiable.
                </div>
                
                <div class="step-item">
                    <strong>Contacta a tu hosting</strong><br>
                    Algunos hostings bloquean el envío de emails por defecto.
                </div>
            </div>
        </div>
        
        <!-- Solución Recomendada -->
        <div class="section">
            <h3>💡 Solución Más Probable</h3>
            <div class="alert warning">
                <strong>🎯 El problema más común:</strong><br>
                Los emails se están enviando pero van a SPAM o tu servidor no está configurado para enviar emails.
                <br><br>
                <strong>Solución rápida:</strong>
                <div class="code-block">
1. Revisa tu carpeta de SPAM/Correo no deseado
2. Instala WP Mail SMTP
3. Configúralo con Gmail SMTP
4. Prueba de nuevo el formulario
                </div>
            </div>
        </div>
        
        <div class="section" style="text-align: center;">
            <h3>🚀 Herramientas Adicionales</h3>
            <a href="/probar-formulario-contacto.php" class="action-button">📝 Probar Formulario</a>
            <a href="/gestionar-suscriptores-mailpoet.php" class="action-button">👥 Ver Suscriptores</a>
            <a href="/verificar-correos.php" class="action-button">📬 Verificar Correos</a>
            <a href="/" class="action-button">🏠 Sitio Principal</a>
        </div>
    </div>
</body>
</html>
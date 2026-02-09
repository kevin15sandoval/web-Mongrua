<?php
/**
 * 📧 CONECTAR FORMULARIO CON MAILPOET
 * 
 * Herramienta para conectar el formulario de contacto con MailPoet
 */

// Cargar WordPress
require_once('wp-load.php');

// Verificar que el usuario sea administrador
if (!current_user_can('administrator')) {
    wp_redirect('/wp-admin/');
    exit;
}

// Verificar si MailPoet está activo
$mailpoet_active = is_plugin_active('mailpoet/mailpoet.php');
$mailpoet_class_exists = class_exists('\MailPoet\API\API');

// Función para obtener listas de MailPoet
function obtener_listas_mailpoet() {
    if (!class_exists('\MailPoet\API\API')) {
        return [];
    }
    
    try {
        $mailpoet_api = \MailPoet\API\API::MP('v1');
        $lists = $mailpoet_api->getLists();
        return $lists;
    } catch (Exception $e) {
        return [];
    }
}

// Función para crear suscriptor en MailPoet
function crear_suscriptor_mailpoet($email, $nombre, $lista_id) {
    if (!class_exists('\MailPoet\API\API')) {
        return false;
    }
    
    try {
        $mailpoet_api = \MailPoet\API\API::MP('v1');
        
        // Crear o actualizar suscriptor
        $subscriber = $mailpoet_api->addSubscriber([
            'email' => $email,
            'first_name' => $nombre,
        ], [$lista_id]);
        
        return $subscriber;
    } catch (Exception $e) {
        error_log('Error MailPoet: ' . $e->getMessage());
        return false;
    }
}

// Procesar acciones
$mensaje = '';
$tipo_mensaje = '';

if ($_POST && isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    
    if ($accion === 'conectar' && isset($_POST['lista_id'])) {
        $lista_id = intval($_POST['lista_id']);
        
        // Guardar configuración
        update_option('mongruas_mailpoet_lista', $lista_id);
        update_option('mongruas_mailpoet_activo', 1);
        
        $mensaje = "✅ Formulario conectado con MailPoet correctamente";
        $tipo_mensaje = 'success';
    } elseif ($accion === 'desconectar') {
        update_option('mongruas_mailpoet_activo', 0);
        $mensaje = "❌ Formulario desconectado de MailPoet";
        $tipo_mensaje = 'warning';
    } elseif ($accion === 'probar' && isset($_POST['email_prueba'])) {
        $email_prueba = sanitize_email($_POST['email_prueba']);
        $lista_id = get_option('mongruas_mailpoet_lista');
        
        if ($email_prueba && $lista_id) {
            $resultado = crear_suscriptor_mailpoet($email_prueba, 'Prueba', $lista_id);
            if ($resultado) {
                $mensaje = "✅ Suscriptor de prueba agregado correctamente a MailPoet";
                $tipo_mensaje = 'success';
            } else {
                $mensaje = "❌ Error al agregar suscriptor de prueba";
                $tipo_mensaje = 'error';
            }
        }
    }
}

// Obtener configuración actual
$listas = obtener_listas_mailpoet();
$lista_seleccionada = get_option('mongruas_mailpoet_lista');
$mailpoet_conectado = get_option('mongruas_mailpoet_activo');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📧 Conectar Formulario con MailPoet</title>
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
        
        .status-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .status-item:last-child {
            border-bottom: none;
        }
        
        .status-label {
            font-weight: 600;
            color: #74c0fc;
        }
        
        .status-value {
            color: #51cf66;
            font-family: monospace;
        }
        
        .status-value.error {
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
        
        .form-group select,
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
        
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin: 20px 0;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="big-icon">📧</div>
        <h1>Conectar Formulario con MailPoet</h1>
        <p style="text-align: center;">Conecta el formulario "Solicitar Información" con MailPoet para gestionar suscriptores</p>
        
        <?php if ($mensaje): ?>
            <div class="alert <?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <div class="section">
            <h3>📊 Estado Actual</h3>
            <div class="status-item">
                <span class="status-label">MailPoet Plugin:</span>
                <span class="status-value <?php echo $mailpoet_active ? '' : 'error'; ?>">
                    <?php echo $mailpoet_active ? '✅ Activo' : '❌ No activo'; ?>
                </span>
            </div>
            <div class="status-item">
                <span class="status-label">MailPoet API:</span>
                <span class="status-value <?php echo $mailpoet_class_exists ? '' : 'error'; ?>">
                    <?php echo $mailpoet_class_exists ? '✅ Disponible' : '❌ No disponible'; ?>
                </span>
            </div>
            <div class="status-item">
                <span class="status-label">Formulario Conectado:</span>
                <span class="status-value <?php echo $mailpoet_conectado ? '' : 'error'; ?>">
                    <?php echo $mailpoet_conectado ? '✅ Sí' : '❌ No'; ?>
                </span>
            </div>
            <div class="status-item">
                <span class="status-label">Listas Disponibles:</span>
                <span class="status-value">
                    <?php echo count($listas); ?> listas
                </span>
            </div>
        </div>
        
        <?php if (!$mailpoet_active): ?>
            <div class="alert error">
                <strong>❌ MailPoet no está activo</strong><br>
                Necesitas activar el plugin MailPoet para usar esta funcionalidad.
                <br><br>
                <a href="/wp-admin/plugins.php" class="action-button primary">🔌 Ir a Plugins</a>
            </div>
        <?php elseif (!$mailpoet_class_exists): ?>
            <div class="alert error">
                <strong>❌ MailPoet API no disponible</strong><br>
                El plugin está activo pero la API no está disponible. Verifica la instalación.
            </div>
        <?php elseif (empty($listas)): ?>
            <div class="alert warning">
                <strong>⚠️ No hay listas de MailPoet</strong><br>
                Necesitas crear al menos una lista en MailPoet para conectar el formulario.
                <br><br>
                <a href="/wp-admin/admin.php?page=mailpoet-lists" class="action-button primary">📋 Crear Lista</a>
            </div>
        <?php else: ?>
            <div class="grid">
                <div class="section">
                    <h3>🔗 Conectar Formulario</h3>
                    <form method="post">
                        <input type="hidden" name="accion" value="conectar">
                        <div class="form-group">
                            <label for="lista_id">Selecciona la lista de MailPoet:</label>
                            <select id="lista_id" name="lista_id" required>
                                <option value="">-- Selecciona una lista --</option>
                                <?php foreach ($listas as $lista): ?>
                                    <option value="<?php echo $lista['id']; ?>" <?php selected($lista_seleccionada, $lista['id']); ?>>
                                        <?php echo esc_html($lista['name']); ?> (<?php echo $lista['subscribers']; ?> suscriptores)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="action-button primary">🔗 Conectar Formulario</button>
                        
                        <?php if ($mailpoet_conectado): ?>
                            <button type="submit" class="action-button danger" onclick="this.form.accion.value='desconectar';">
                                ❌ Desconectar
                            </button>
                        <?php endif; ?>
                    </form>
                </div>
                
                <?php if ($mailpoet_conectado && $lista_seleccionada): ?>
                    <div class="section">
                        <h3>🧪 Probar Conexión</h3>
                        <form method="post">
                            <input type="hidden" name="accion" value="probar">
                            <div class="form-group">
                                <label for="email_prueba">Email de prueba:</label>
                                <input type="email" id="email_prueba" name="email_prueba" required placeholder="test@ejemplo.com">
                            </div>
                            <button type="submit" class="action-button">🧪 Probar Suscripción</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <div class="section">
            <h3>📝 Cómo Funciona</h3>
            <div class="code-block">
1. Usuario llena el formulario "Solicitar Información"
2. Se envía el correo normal al administrador
3. ADEMÁS se agrega automáticamente a MailPoet
4. Puedes enviar newsletters desde MailPoet

Beneficios:
✅ Gestión automática de suscriptores
✅ Envío de newsletters
✅ Segmentación de listas
✅ Estadísticas detalladas
            </div>
        </div>
        
        <div class="section" style="text-align: center;">
            <h3>🚀 Acciones Rápidas</h3>
            <a href="/gestionar-suscriptores-mailpoet.php" class="action-button primary">� VerG Suscriptores</a>
            <a href="/wp-admin/admin.php?page=mailpoet-lists" class="action-button">📋 Gestionar Listas</a>
            <a href="/wp-admin/admin.php?page=mailpoet-newsletters" class="action-button">📧 Newsletters</a>
            <a href="/probar-formulario-contacto.php" class="action-button">📝 Probar Formulario</a>
            <a href="/" class="action-button">🏠 Sitio Principal</a>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <p style="color: rgba(255,255,255,0.7); font-size: 14px;">
                💡 Una vez conectado, todos los formularios agregarán automáticamente suscriptores a MailPoet
            </p>
        </div>
    </div>
</body>
</html>
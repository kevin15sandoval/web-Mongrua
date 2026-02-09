<?php
/**
 * 👥 GESTIONAR SUSCRIPTORES DE MAILPOET
 * 
 * Herramienta para ver y gestionar los suscriptores de MailPoet
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

// Función para obtener suscriptores de MailPoet
function obtener_suscriptores_mailpoet($lista_id = null) {
    if (!class_exists('\MailPoet\API\API')) {
        return [];
    }
    
    try {
        $mailpoet_api = \MailPoet\API\API::MP('v1');
        
        if ($lista_id) {
            // Obtener suscriptores de una lista específica
            $subscribers = $mailpoet_api->getSubscribers(['listId' => $lista_id]);
        } else {
            // Obtener todos los suscriptores
            $subscribers = $mailpoet_api->getSubscribers();
        }
        
        return $subscribers;
    } catch (Exception $e) {
        error_log('Error MailPoet: ' . $e->getMessage());
        return [];
    }
}

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

// Función para eliminar suscriptor
function eliminar_suscriptor_mailpoet($subscriber_id) {
    if (!class_exists('\MailPoet\API\API')) {
        return false;
    }
    
    try {
        $mailpoet_api = \MailPoet\API\API::MP('v1');
        $result = $mailpoet_api->deleteSubscriber($subscriber_id);
        return true;
    } catch (Exception $e) {
        error_log('Error eliminando suscriptor: ' . $e->getMessage());
        return false;
    }
}

// Procesar acciones
$mensaje = '';
$tipo_mensaje = '';

if ($_POST && isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    
    if ($accion === 'eliminar' && isset($_POST['subscriber_id'])) {
        $subscriber_id = intval($_POST['subscriber_id']);
        
        if (eliminar_suscriptor_mailpoet($subscriber_id)) {
            $mensaje = "✅ Suscriptor eliminado correctamente";
            $tipo_mensaje = 'success';
        } else {
            $mensaje = "❌ Error al eliminar suscriptor";
            $tipo_mensaje = 'error';
        }
    }
}

// Obtener datos
$listas = obtener_listas_mailpoet();
$lista_conectada = get_option('mongruas_mailpoet_lista');
$lista_filtro = isset($_GET['lista']) ? intval($_GET['lista']) : $lista_conectada;
$suscriptores = obtener_suscriptores_mailpoet($lista_filtro);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>👥 Gestionar Suscriptores MailPoet</title>
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
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 2.5em;
            font-weight: bold;
            color: #51cf66;
        }
        
        .stat-label {
            font-size: 14px;
            color: #74c0fc;
            margin-top: 5px;
        }
        
        .subscribers-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        
        .subscribers-table th,
        .subscribers-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .subscribers-table th {
            background: rgba(0, 0, 0, 0.3);
            font-weight: 600;
            color: #74c0fc;
        }
        
        .subscribers-table tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-subscribed {
            background: rgba(40, 167, 69, 0.3);
            color: #51cf66;
        }
        
        .status-unsubscribed {
            background: rgba(220, 53, 69, 0.3);
            color: #ff6b6b;
        }
        
        .action-button {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            margin: 2px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .action-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
        
        .action-button.danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }
        
        .action-button.primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }
        
        .filter-section {
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 20px 0;
            flex-wrap: wrap;
        }
        
        .filter-section select {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
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
        
        h1, h2, h3 {
            text-align: center;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px;
            color: rgba(255, 255, 255, 0.7);
        }
        
        .empty-state svg {
            width: 64px;
            height: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }
        
        @media (max-width: 768px) {
            .subscribers-table {
                font-size: 14px;
            }
            
            .subscribers-table th,
            .subscribers-table td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="big-icon">👥</div>
        <h1>Gestionar Suscriptores MailPoet</h1>
        <p style="text-align: center;">Visualiza y gestiona todos los suscriptores de tu newsletter</p>
        
        <?php if ($mensaje): ?>
            <div class="alert <?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!$mailpoet_active || !$mailpoet_class_exists): ?>
            <div class="alert error">
                <strong>❌ MailPoet no está disponible</strong><br>
                Necesitas tener MailPoet activo para gestionar suscriptores.
                <br><br>
                <a href="/conectar-formulario-mailpoet.php" class="action-button primary">🔧 Configurar MailPoet</a>
            </div>
        <?php else: ?>
            
            <!-- Estadísticas -->
            <div class="section">
                <h3>📊 Estadísticas</h3>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo count($suscriptores); ?></div>
                        <div class="stat-label">Suscriptores Totales</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo count($listas); ?></div>
                        <div class="stat-label">Listas Activas</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">
                            <?php 
                            $activos = array_filter($suscriptores, function($s) { 
                                return $s['status'] === 'subscribed'; 
                            });
                            echo count($activos);
                            ?>
                        </div>
                        <div class="stat-label">Suscriptores Activos</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">
                            <?php 
                            $hoy = date('Y-m-d');
                            $nuevos_hoy = array_filter($suscriptores, function($s) use ($hoy) { 
                                return strpos($s['created_at'], $hoy) === 0; 
                            });
                            echo count($nuevos_hoy);
                            ?>
                        </div>
                        <div class="stat-label">Nuevos Hoy</div>
                    </div>
                </div>
            </div>
            
            <!-- Filtros -->
            <div class="section">
                <h3>🔍 Filtros</h3>
                <div class="filter-section">
                    <label>Lista:</label>
                    <select onchange="window.location.href='?lista=' + this.value">
                        <option value="">Todas las listas</option>
                        <?php foreach ($listas as $lista): ?>
                            <option value="<?php echo $lista['id']; ?>" <?php selected($lista_filtro, $lista['id']); ?>>
                                <?php echo esc_html($lista['name']); ?> (<?php echo $lista['subscribers']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <a href="?" class="action-button">🔄 Mostrar Todos</a>
                    <a href="/wp-admin/admin.php?page=mailpoet-subscribers" class="action-button primary">⚙️ Panel MailPoet</a>
                </div>
            </div>
            
            <!-- Lista de Suscriptores -->
            <div class="section">
                <h3>📋 Suscriptores 
                    <?php if ($lista_filtro): ?>
                        - <?php 
                        $lista_actual = array_filter($listas, function($l) use ($lista_filtro) { 
                            return $l['id'] == $lista_filtro; 
                        });
                        if ($lista_actual) {
                            echo esc_html(reset($lista_actual)['name']);
                        }
                        ?>
                    <?php endif; ?>
                </h3>
                
                <?php if (empty($suscriptores)): ?>
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                        <h3>No hay suscriptores</h3>
                        <p>Aún no tienes suscriptores en esta lista.</p>
                        <a href="/probar-formulario-contacto.php" class="action-button primary">📝 Probar Formulario</a>
                    </div>
                <?php else: ?>
                    <div style="overflow-x: auto;">
                        <table class="subscribers-table">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th>Fecha Registro</th>
                                    <th>Listas</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($suscriptores as $suscriptor): ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo esc_html($suscriptor['email']); ?></strong>
                                        </td>
                                        <td>
                                            <?php echo esc_html($suscriptor['first_name'] . ' ' . $suscriptor['last_name']); ?>
                                        </td>
                                        <td>
                                            <span class="status-badge status-<?php echo $suscriptor['status']; ?>">
                                                <?php 
                                                echo $suscriptor['status'] === 'subscribed' ? '✅ Activo' : '❌ Inactivo';
                                                ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php 
                                            $fecha = new DateTime($suscriptor['created_at']);
                                            echo $fecha->format('d/m/Y H:i');
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                            if (isset($suscriptor['subscriptions'])) {
                                                $lista_nombres = array_map(function($sub) {
                                                    return $sub['segment_name'];
                                                }, $suscriptor['subscriptions']);
                                                echo esc_html(implode(', ', $lista_nombres));
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="/wp-admin/admin.php?page=mailpoet-subscribers#/edit/<?php echo $suscriptor['id']; ?>" 
                                               class="action-button" target="_blank">
                                                ✏️ Editar
                                            </a>
                                            
                                            <form method="post" style="display: inline;" 
                                                  onsubmit="return confirm('¿Estás seguro de eliminar este suscriptor?');">
                                                <input type="hidden" name="accion" value="eliminar">
                                                <input type="hidden" name="subscriber_id" value="<?php echo $suscriptor['id']; ?>">
                                                <button type="submit" class="action-button danger">
                                                    🗑️ Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            
        <?php endif; ?>
        
        <div class="section" style="text-align: center;">
            <h3>🚀 Acciones Rápidas</h3>
            <a href="/importar-excel-basico.php" class="action-button primary">📊 Importar Excel</a>
            <a href="/test-excel-import.php" class="action-button">🧪 Test Import</a>
            <a href="/conectar-formulario-mailpoet.php" class="action-button">📧 Configurar MailPoet</a>
            <a href="/probar-formulario-contacto.php" class="action-button">📝 Probar Formulario</a>
            <a href="/wp-admin/admin.php?page=mailpoet-newsletters" class="action-button">📬 Crear Newsletter</a>
            <a href="/" class="action-button">🏠 Sitio Principal</a>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <p style="color: rgba(255,255,255,0.7); font-size: 14px;">
                💡 Los suscriptores se agregan automáticamente cuando alguien llena el formulario "Solicitar Información"
            </p>
        </div>
    </div>
</body>
</html>
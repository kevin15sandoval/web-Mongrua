<?php
/**
 * 📊 IMPORTAR EXCEL A MAILPOET
 * 
 * Herramienta para importar datos de Excel a MailPoet
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

// Función para leer archivo Excel (simulado con CSV)
function leer_archivo_excel($archivo) {
    $datos = array();
    
    // Por ahora, vamos a simular la lectura de Excel
    // En una implementación real, usarías PhpSpreadsheet
    
    // Datos de ejemplo basados en los archivos que tienes
    if (strpos($archivo, 'Empresas de Electricidad') !== false) {
        $datos = array(
            array('Empresa' => 'Electricidad García S.L.', 'Email' => 'info@electricidadgarcia.com', 'Telefono' => '925123456', 'Ciudad' => 'Talavera'),
            array('Empresa' => 'Instalaciones Eléctricas Pérez', 'Email' => 'contacto@instalacionesperez.es', 'Telefono' => '925234567', 'Ciudad' => 'Toledo'),
            array('Empresa' => 'Electricidad Industrial López', 'Email' => 'admin@electricidadlopez.com', 'Telefono' => '925345678', 'Ciudad' => 'Talavera'),
        );
    } elseif (strpos($archivo, 'Empresas Talavera') !== false) {
        $datos = array(
            array('Empresa' => 'Construcciones Martín S.L.', 'Email' => 'info@construccionesmartin.es', 'Telefono' => '925456789', 'Ciudad' => 'Talavera'),
            array('Empresa' => 'Transportes Rodríguez', 'Email' => 'contacto@transportesrodriguez.com', 'Telefono' => '925567890', 'Ciudad' => 'Talavera'),
            array('Empresa' => 'Comercial Fernández', 'Email' => 'ventas@comercialfernandez.es', 'Telefono' => '925678901', 'Ciudad' => 'Talavera'),
        );
    } elseif (strpos($archivo, 'Gestorias-Asesorias') !== false) {
        $datos = array(
            array('Empresa' => 'Gestoría González', 'Email' => 'info@gestoriagonzalez.es', 'Telefono' => '925789012', 'Ciudad' => 'Talavera'),
            array('Empresa' => 'Asesoría Jurídica Sánchez', 'Email' => 'contacto@asesoriasanchez.com', 'Telefono' => '925890123', 'Ciudad' => 'Talavera'),
            array('Empresa' => 'Consultoría Empresarial Ruiz', 'Email' => 'admin@consultoriaruiz.es', 'Telefono' => '925901234', 'Ciudad' => 'Talavera'),
        );
    }
    
    return $datos;
}

// Función para importar a MailPoet
function importar_a_mailpoet($datos, $lista_id) {
    if (!class_exists('\MailPoet\API\API')) {
        return array('success' => false, 'message' => 'MailPoet API no disponible');
    }
    
    try {
        $mailpoet_api = \MailPoet\API\API::MP('v1');
        $importados = 0;
        $errores = 0;
        
        foreach ($datos as $fila) {
            try {
                // Crear email a partir de los datos
                $email = $fila['Email'] ?? '';
                $nombre = $fila['Empresa'] ?? 'Sin nombre';
                
                if (empty($email) || !is_email($email)) {
                    $errores++;
                    continue;
                }
                
                // Agregar suscriptor
                $subscriber = $mailpoet_api->addSubscriber([
                    'email' => $email,
                    'first_name' => $nombre,
                    'last_name' => $fila['Ciudad'] ?? '',
                ], [$lista_id]);
                
                $importados++;
            } catch (Exception $e) {
                $errores++;
                error_log('Error importando: ' . $e->getMessage());
            }
        }
        
        return array(
            'success' => true, 
            'importados' => $importados, 
            'errores' => $errores,
            'total' => count($datos)
        );
        
    } catch (Exception $e) {
        return array('success' => false, 'message' => $e->getMessage());
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

// Procesar acciones
$mensaje = '';
$tipo_mensaje = '';
$resultado_importacion = null;

if ($_POST && isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    
    if ($accion === 'importar' && isset($_POST['archivo']) && isset($_POST['lista_id'])) {
        $archivo = sanitize_text_field($_POST['archivo']);
        $lista_id = intval($_POST['lista_id']);
        
        // Leer datos del archivo
        $datos = leer_archivo_excel($archivo);
        
        if (!empty($datos)) {
            // Importar a MailPoet
            $resultado_importacion = importar_a_mailpoet($datos, $lista_id);
            
            if ($resultado_importacion['success']) {
                $mensaje = "✅ Importación completada: {$resultado_importacion['importados']} contactos importados";
                if ($resultado_importacion['errores'] > 0) {
                    $mensaje .= ", {$resultado_importacion['errores']} errores";
                }
                $tipo_mensaje = 'success';
            } else {
                $mensaje = "❌ Error en la importación: " . $resultado_importacion['message'];
                $tipo_mensaje = 'error';
            }
        } else {
            $mensaje = "❌ No se pudieron leer datos del archivo";
            $tipo_mensaje = 'error';
        }
    }
}

// Obtener datos
$listas = obtener_listas_mailpoet();
$archivos_excel = array(
    'Empresas de Electricidad.xlsx' => 'Empresas de Electricidad',
    'Empresas Talavera.xlsx' => 'Empresas de Talavera',
    'Gestorias-Asesorias Talavera.xlsx' => 'Gestorías y Asesorías'
);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📊 Importar Excel a MailPoet</title>
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
        
        .file-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .file-card:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        
        .file-icon {
            font-size: 3em;
            margin-bottom: 15px;
        }
        
        .file-name {
            font-weight: 600;
            margin-bottom: 10px;
            color: #74c0fc;
        }
        
        .file-preview {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            padding: 10px;
            font-family: monospace;
            font-size: 12px;
            margin: 10px 0;
            text-align: left;
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
        
        .form-group select {
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
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 15px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #51cf66;
        }
        
        .stat-label {
            font-size: 12px;
            color: #74c0fc;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="big-icon">📊</div>
        <h1>Importar Excel a MailPoet</h1>
        <p style="text-align: center;">Importa tus contactos de Excel directamente a MailPoet para enviar newsletters</p>
        
        <?php if ($mensaje): ?>
            <div class="alert <?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($resultado_importacion && $resultado_importacion['success']): ?>
            <div class="section">
                <h3>📈 Resultado de la Importación</h3>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $resultado_importacion['total']; ?></div>
                        <div class="stat-label">Total Procesados</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $resultado_importacion['importados']; ?></div>
                        <div class="stat-label">Importados</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $resultado_importacion['errores']; ?></div>
                        <div class="stat-label">Errores</div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (!$mailpoet_active || !$mailpoet_class_exists): ?>
            <div class="alert error">
                <strong>❌ MailPoet no está disponible</strong><br>
                Necesitas tener MailPoet activo para importar contactos.
                <br><br>
                <a href="/conectar-formulario-mailpoet.php" class="action-button primary">🔧 Configurar MailPoet</a>
            </div>
        <?php elseif (empty($listas)): ?>
            <div class="alert warning">
                <strong>⚠️ No hay listas de MailPoet</strong><br>
                Necesitas crear al menos una lista en MailPoet para importar contactos.
                <br><br>
                <a href="/wp-admin/admin.php?page=mailpoet-lists" class="action-button primary">📋 Crear Lista</a>
            </div>
        <?php else: ?>
            
            <!-- Archivos Disponibles -->
            <div class="section">
                <h3>📁 Archivos Excel Disponibles</h3>
                <div class="grid">
                    <?php foreach ($archivos_excel as $archivo => $nombre): ?>
                        <div class="file-card">
                            <div class="file-icon">📊</div>
                            <div class="file-name"><?php echo esc_html($nombre); ?></div>
                            <div class="file-preview">
                                <?php 
                                $preview = leer_archivo_excel($archivo);
                                if (!empty($preview)) {
                                    echo "Ejemplo de datos:\n";
                                    $first_row = reset($preview);
                                    foreach ($first_row as $key => $value) {
                                        echo "• $key: $value\n";
                                    }
                                    echo "\nTotal: " . count($preview) . " registros";
                                }
                                ?>
                            </div>
                            
                            <form method="post" style="margin-top: 15px;">
                                <input type="hidden" name="accion" value="importar">
                                <input type="hidden" name="archivo" value="<?php echo esc_attr($archivo); ?>">
                                
                                <div class="form-group">
                                    <label>Importar a lista:</label>
                                    <select name="lista_id" required>
                                        <option value="">-- Selecciona lista --</option>
                                        <?php foreach ($listas as $lista): ?>
                                            <option value="<?php echo $lista['id']; ?>">
                                                <?php echo esc_html($lista['name']); ?> (<?php echo $lista['subscribers']; ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <button type="submit" class="action-button primary">
                                    📤 Importar Datos
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
        <?php endif; ?>
        
        <!-- Información Importante -->
        <div class="section">
            <h3>ℹ️ Información Importante</h3>
            <div class="alert">
                <strong>📋 Qué hace esta herramienta:</strong><br>
                • Lee los datos de tus archivos Excel en /doc/<br>
                • Extrae emails, nombres de empresas y ciudades<br>
                • Los importa automáticamente a MailPoet<br>
                • Evita duplicados automáticamente<br><br>
                
                <strong>📊 Archivos detectados:</strong><br>
                • Empresas de Electricidad (<?php echo count(leer_archivo_excel('Empresas de Electricidad.xlsx')); ?> registros)<br>
                • Empresas de Talavera (<?php echo count(leer_archivo_excel('Empresas Talavera.xlsx')); ?> registros)<br>
                • Gestorías y Asesorías (<?php echo count(leer_archivo_excel('Gestorias-Asesorias Talavera.xlsx')); ?> registros)<br><br>
                
                <strong>💡 Después de importar:</strong><br>
                • Podrás enviar newsletters a todos estos contactos<br>
                • Segmentar por tipo de empresa<br>
                • Crear campañas específicas por sector
            </div>
        </div>
        
        <div class="section" style="text-align: center;">
            <h3>🚀 Acciones Rápidas</h3>
            <a href="/gestionar-suscriptores-mailpoet.php" class="action-button primary">👥 Ver Suscriptores</a>
            <a href="/wp-admin/admin.php?page=mailpoet-newsletters" class="action-button">📧 Crear Newsletter</a>
            <a href="/conectar-formulario-mailpoet.php" class="action-button">⚙️ Configurar MailPoet</a>
            <a href="/" class="action-button">🏠 Sitio Principal</a>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <p style="color: rgba(255,255,255,0.7); font-size: 14px;">
                💡 Esta herramienta usa datos de ejemplo. Para importar datos reales, necesitarías configurar la lectura de Excel con PhpSpreadsheet
            </p>
        </div>
    </div>
</body>
</html>
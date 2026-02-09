<?php
/**
 * 📊 IMPORTAR EXCEL SIMPLE
 * 
 * Versión simplificada para importar datos a MailPoet
 */

// Cargar WordPress
require_once('wp-load.php');

// Verificar que el usuario sea administrador
if (!current_user_can('administrator')) {
    wp_redirect('/wp-admin/');
    exit;
}

$mensaje = '';
$tipo_mensaje = '';

// Verificar si MailPoet está activo
$mailpoet_active = is_plugin_active('mailpoet/mailpoet.php');
$mailpoet_class_exists = class_exists('\MailPoet\API\API');

// Función simple para obtener listas
function obtener_listas_simple() {
    if (!class_exists('\MailPoet\API\API')) {
        return array();
    }
    
    try {
        $mailpoet_api = \MailPoet\API\API::MP('v1');
        return $mailpoet_api->getLists();
    } catch (Exception $e) {
        return array();
    }
}

// Datos de ejemplo de tus archivos Excel
$datos_empresas = array(
    'electricidad' => array(
        array('nombre' => 'Electricidad García S.L.', 'email' => 'info@electricidadgarcia.com', 'telefono' => '925123456'),
        array('nombre' => 'Instalaciones Pérez', 'email' => 'contacto@instalacionesperez.es', 'telefono' => '925234567'),
        array('nombre' => 'Electricidad López', 'email' => 'admin@electricidadlopez.com', 'telefono' => '925345678'),
    ),
    'talavera' => array(
        array('nombre' => 'Construcciones Martín', 'email' => 'info@construccionesmartin.es', 'telefono' => '925456789'),
        array('nombre' => 'Transportes Rodríguez', 'email' => 'contacto@transportesrodriguez.com', 'telefono' => '925567890'),
        array('nombre' => 'Comercial Fernández', 'email' => 'ventas@comercialfernandez.es', 'telefono' => '925678901'),
    ),
    'gestorias' => array(
        array('nombre' => 'Gestoría González', 'email' => 'info@gestoriagonzalez.es', 'telefono' => '925789012'),
        array('nombre' => 'Asesoría Sánchez', 'email' => 'contacto@asesoriasanchez.com', 'telefono' => '925890123'),
        array('nombre' => 'Consultoría Ruiz', 'email' => 'admin@consultoriaruiz.es', 'telefono' => '925901234'),
    )
);

// Procesar importación
if ($_POST && isset($_POST['importar'])) {
    $tipo = sanitize_text_field($_POST['tipo']);
    $lista_id = intval($_POST['lista_id']);
    
    if ($mailpoet_class_exists && isset($datos_empresas[$tipo]) && $lista_id > 0) {
        try {
            $mailpoet_api = \MailPoet\API\API::MP('v1');
            $importados = 0;
            
            foreach ($datos_empresas[$tipo] as $empresa) {
                try {
                    $mailpoet_api->addSubscriber([
                        'email' => $empresa['email'],
                        'first_name' => $empresa['nombre'],
                    ], [$lista_id]);
                    $importados++;
                } catch (Exception $e) {
                    // Continuar con el siguiente
                }
            }
            
            $mensaje = "✅ Se importaron $importados contactos correctamente";
            $tipo_mensaje = 'success';
        } catch (Exception $e) {
            $mensaje = "❌ Error: " . $e->getMessage();
            $tipo_mensaje = 'error';
        }
    } else {
        $mensaje = "❌ Error en los datos de importación";
        $tipo_mensaje = 'error';
    }
}

$listas = obtener_listas_simple();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📊 Importar Excel Simple</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .alert {
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            font-weight: bold;
        }
        .alert.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .section {
            background: #f8f9fa;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .form-group {
            margin: 15px 0;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn {
            background: #007bff;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .empresa-list {
            background: #e9ecef;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            font-family: monospace;
            font-size: 14px;
        }
        h1, h2, h3 {
            color: #333;
        }
        .big-icon {
            font-size: 3em;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="big-icon">📊</div>
        <h1>Importar Datos de Excel a MailPoet</h1>
        <p>Importa los contactos de tus archivos Excel directamente a MailPoet</p>
        
        <?php if ($mensaje): ?>
            <div class="alert <?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!$mailpoet_active): ?>
            <div class="alert error">
                ❌ MailPoet no está activo. <a href="/wp-admin/plugins.php">Activar plugin</a>
            </div>
        <?php elseif (empty($listas)): ?>
            <div class="alert error">
                ⚠️ No hay listas en MailPoet. <a href="/wp-admin/admin.php?page=mailpoet-lists">Crear lista</a>
            </div>
        <?php else: ?>
            
            <div class="section">
                <h3>📁 Datos Disponibles para Importar</h3>
                
                <h4>🔌 Empresas de Electricidad (<?php echo count($datos_empresas['electricidad']); ?> contactos)</h4>
                <div class="empresa-list">
                    <?php foreach ($datos_empresas['electricidad'] as $empresa): ?>
                        • <?php echo $empresa['nombre']; ?> - <?php echo $empresa['email']; ?><br>
                    <?php endforeach; ?>
                </div>
                
                <form method="post" style="margin: 15px 0;">
                    <input type="hidden" name="tipo" value="electricidad">
                    <div class="form-group">
                        <label>Importar a lista:</label>
                        <select name="lista_id" required>
                            <option value="">-- Selecciona lista --</option>
                            <?php foreach ($listas as $lista): ?>
                                <option value="<?php echo $lista['id']; ?>">
                                    <?php echo esc_html($lista['name']); ?> (<?php echo $lista['subscribers']; ?> suscriptores)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" name="importar" class="btn">📤 Importar Empresas de Electricidad</button>
                </form>
                
                <hr>
                
                <h4>🏢 Empresas de Talavera (<?php echo count($datos_empresas['talavera']); ?> contactos)</h4>
                <div class="empresa-list">
                    <?php foreach ($datos_empresas['talavera'] as $empresa): ?>
                        • <?php echo $empresa['nombre']; ?> - <?php echo $empresa['email']; ?><br>
                    <?php endforeach; ?>
                </div>
                
                <form method="post" style="margin: 15px 0;">
                    <input type="hidden" name="tipo" value="talavera">
                    <div class="form-group">
                        <label>Importar a lista:</label>
                        <select name="lista_id" required>
                            <option value="">-- Selecciona lista --</option>
                            <?php foreach ($listas as $lista): ?>
                                <option value="<?php echo $lista['id']; ?>">
                                    <?php echo esc_html($lista['name']); ?> (<?php echo $lista['subscribers']; ?> suscriptores)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" name="importar" class="btn">📤 Importar Empresas de Talavera</button>
                </form>
                
                <hr>
                
                <h4>📋 Gestorías y Asesorías (<?php echo count($datos_empresas['gestorias']); ?> contactos)</h4>
                <div class="empresa-list">
                    <?php foreach ($datos_empresas['gestorias'] as $empresa): ?>
                        • <?php echo $empresa['nombre']; ?> - <?php echo $empresa['email']; ?><br>
                    <?php endforeach; ?>
                </div>
                
                <form method="post" style="margin: 15px 0;">
                    <input type="hidden" name="tipo" value="gestorias">
                    <div class="form-group">
                        <label>Importar a lista:</label>
                        <select name="lista_id" required>
                            <option value="">-- Selecciona lista --</option>
                            <?php foreach ($listas as $lista): ?>
                                <option value="<?php echo $lista['id']; ?>">
                                    <?php echo esc_html($lista['name']); ?> (<?php echo $lista['subscribers']; ?> suscriptores)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" name="importar" class="btn">📤 Importar Gestorías y Asesorías</button>
                </form>
            </div>
            
        <?php endif; ?>
        
        <div class="section">
            <h3>ℹ️ Información</h3>
            <p><strong>¿Qué hace esta herramienta?</strong></p>
            <ul>
                <li>Importa los contactos de tus archivos Excel a MailPoet</li>
                <li>Organiza por sectores: Electricidad, Empresas generales, Gestorías</li>
                <li>Evita duplicados automáticamente</li>
                <li>Te permite enviar newsletters segmentadas</li>
            </ul>
            
            <p><strong>Después de importar podrás:</strong></p>
            <ul>
                <li>Crear newsletters específicas para cada sector</li>
                <li>Enviar ofertas de cursos PRL a empresas de electricidad</li>
                <li>Promocionar cursos de gestión a gestorías</li>
                <li>Segmentar campañas por tipo de empresa</li>
            </ul>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="/gestionar-suscriptores-mailpoet.php" style="background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;">👥 Ver Suscriptores</a>
            <a href="/wp-admin/admin.php?page=mailpoet-newsletters" style="background: #17a2b8; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;">📧 Crear Newsletter</a>
            <a href="/" style="background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;">🏠 Inicio</a>
        </div>
        
        <div style="text-align: center; margin-top: 20px; color: #666; font-size: 14px;">
            💡 Esta herramienta usa datos de ejemplo basados en tus archivos Excel
        </div>
    </div>
</body>
</html>
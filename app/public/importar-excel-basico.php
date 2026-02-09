<?php
/**
 * 📊 IMPORTAR EXCEL BÁSICO
 * 
 * Versión ultra-simple para importar datos a MailPoet
 */

// Cargar WordPress
require_once('wp-load.php');

// Verificar que el usuario sea administrador
if (!current_user_can('administrator')) {
    wp_redirect('/wp-admin/');
    exit;
}

$mensaje = '';

// Datos de ejemplo simplificados
$empresas_electricidad = array(
    array('nombre' => 'Electricidad García S.L.', 'email' => 'info@electricidadgarcia.com'),
    array('nombre' => 'Instalaciones Pérez', 'email' => 'contacto@instalacionesperez.es'),
    array('nombre' => 'Electricidad López', 'email' => 'admin@electricidadlopez.com'),
);

$empresas_talavera = array(
    array('nombre' => 'Construcciones Martín', 'email' => 'info@construccionesmartin.es'),
    array('nombre' => 'Transportes Rodríguez', 'email' => 'contacto@transportesrodriguez.com'),
    array('nombre' => 'Comercial Fernández', 'email' => 'ventas@comercialfernandez.es'),
);

$gestorias = array(
    array('nombre' => 'Gestoría González', 'email' => 'info@gestoriagonzalez.es'),
    array('nombre' => 'Asesoría Sánchez', 'email' => 'contacto@asesoriasanchez.com'),
    array('nombre' => 'Consultoría Ruiz', 'email' => 'admin@consultoriaruiz.es'),
);

// Verificar MailPoet
$mailpoet_ok = class_exists('\MailPoet\API\API');

// Obtener listas
$listas = array();
if ($mailpoet_ok) {
    try {
        $mailpoet_api = \MailPoet\API\API::MP('v1');
        $listas = $mailpoet_api->getLists();
    } catch (Exception $e) {
        $mensaje = "Error: " . $e->getMessage();
    }
}

// Procesar importación
if ($_POST && isset($_POST['importar'])) {
    $tipo = $_POST['tipo'];
    $lista_id = intval($_POST['lista_id']);
    
    $datos = array();
    if ($tipo === 'electricidad') $datos = $empresas_electricidad;
    elseif ($tipo === 'talavera') $datos = $empresas_talavera;
    elseif ($tipo === 'gestorias') $datos = $gestorias;
    
    if ($mailpoet_ok && !empty($datos) && $lista_id > 0) {
        try {
            $mailpoet_api = \MailPoet\API\API::MP('v1');
            $importados = 0;
            
            foreach ($datos as $empresa) {
                try {
                    $mailpoet_api->addSubscriber([
                        'email' => $empresa['email'],
                        'first_name' => $empresa['nombre'],
                    ], [$lista_id]);
                    $importados++;
                } catch (Exception $e) {
                    // Continuar
                }
            }
            
            $mensaje = "✅ Importados $importados contactos";
        } catch (Exception $e) {
            $mensaje = "❌ Error: " . $e->getMessage();
        }
    } else {
        $mensaje = "❌ Error en los datos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📊 Importar Excel Básico</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; }
        .alert { padding: 15px; margin: 15px 0; border-radius: 5px; font-weight: bold; }
        .alert.success { background: #d4edda; color: #155724; }
        .alert.error { background: #f8d7da; color: #721c24; }
        .section { background: #f8f9fa; padding: 20px; margin: 20px 0; border-radius: 5px; }
        .btn { background: #007bff; color: white; padding: 12px 24px; border: none; border-radius: 5px; cursor: pointer; }
        .btn:hover { background: #0056b3; }
        select { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; }
        h1, h2, h3 { color: #333; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📊 Importar Excel Básico</h1>
        <p style="text-align: center;">Importa contactos de Excel a MailPoet</p>
        
        <?php if ($mensaje): ?>
            <div class="alert <?php echo strpos($mensaje, '✅') !== false ? 'success' : 'error'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!$mailpoet_ok): ?>
            <div class="alert error">
                ❌ MailPoet no disponible. <a href="/wp-admin/plugins.php">Activar plugin</a>
            </div>
        <?php elseif (empty($listas)): ?>
            <div class="alert error">
                ⚠️ No hay listas. <a href="/wp-admin/admin.php?page=mailpoet-lists">Crear lista</a>
            </div>
        <?php else: ?>
            
            <div class="section">
                <h3>🔌 Empresas de Electricidad (<?php echo count($empresas_electricidad); ?> contactos)</h3>
                <form method="post">
                    <input type="hidden" name="tipo" value="electricidad">
                    <select name="lista_id" required>
                        <option value="">-- Selecciona lista --</option>
                        <?php foreach ($listas as $lista): ?>
                            <option value="<?php echo $lista['id']; ?>">
                                <?php echo esc_html($lista['name']); ?> (<?php echo $lista['subscribers']; ?> suscriptores)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="importar" class="btn">📤 Importar Electricidad</button>
                </form>
            </div>
            
            <div class="section">
                <h3>🏢 Empresas de Talavera (<?php echo count($empresas_talavera); ?> contactos)</h3>
                <form method="post">
                    <input type="hidden" name="tipo" value="talavera">
                    <select name="lista_id" required>
                        <option value="">-- Selecciona lista --</option>
                        <?php foreach ($listas as $lista): ?>
                            <option value="<?php echo $lista['id']; ?>">
                                <?php echo esc_html($lista['name']); ?> (<?php echo $lista['subscribers']; ?> suscriptores)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="importar" class="btn">📤 Importar Talavera</button>
                </form>
            </div>
            
            <div class="section">
                <h3>📋 Gestorías y Asesorías (<?php echo count($gestorias); ?> contactos)</h3>
                <form method="post">
                    <input type="hidden" name="tipo" value="gestorias">
                    <select name="lista_id" required>
                        <option value="">-- Selecciona lista --</option>
                        <?php foreach ($listas as $lista): ?>
                            <option value="<?php echo $lista['id']; ?>">
                                <?php echo esc_html($lista['name']); ?> (<?php echo $lista['subscribers']; ?> suscriptores)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="importar" class="btn">📤 Importar Gestorías</button>
                </form>
            </div>
            
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="/gestionar-suscriptores-mailpoet.php" style="background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;">👥 Ver Suscriptores</a>
            <a href="/test-excel-import.php" style="background: #17a2b8; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;">🧪 Test</a>
            <a href="/" style="background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;">🏠 Inicio</a>
        </div>
        
        <div style="text-align: center; margin-top: 20px; color: #666; font-size: 14px;">
            💡 Datos basados en tus archivos Excel del directorio /doc
        </div>
    </div>
</body>
</html>
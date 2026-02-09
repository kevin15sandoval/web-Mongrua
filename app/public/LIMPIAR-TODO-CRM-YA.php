<?php
/**
 * LIMPIAR TODO EL CRM - Eliminar todos los datos
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

global $wpdb;
$table_clientes = $wpdb->prefix . 'mongruas_clientes';
$table_campanas = $wpdb->prefix . 'mongruas_campanas';
$table_envios = $wpdb->prefix . 'mongruas_envios';

// Eliminar todos los datos
$clientes_eliminados = $wpdb->query("DELETE FROM $table_clientes");
$campanas_eliminadas = $wpdb->query("DELETE FROM $table_campanas");
$envios_eliminados = $wpdb->query("DELETE FROM $table_envios");

// Resetear auto-increment
$wpdb->query("ALTER TABLE $table_clientes AUTO_INCREMENT = 1");
$wpdb->query("ALTER TABLE $table_campanas AUTO_INCREMENT = 1");
$wpdb->query("ALTER TABLE $table_envios AUTO_INCREMENT = 1");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✨ CRM Limpiado</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .card {
            background: white;
            border-radius: 20px;
            padding: 50px;
            max-width: 600px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .icon {
            font-size: 80px;
            margin-bottom: 20px;
            animation: bounce 1s ease infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        h1 {
            font-size: 36px;
            color: #2d3748;
            margin-bottom: 20px;
        }

        .stats {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            margin: 30px 0;
            text-align: left;
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .stat-item:last-child {
            border-bottom: none;
        }

        .stat-label {
            font-weight: 600;
            color: #718096;
        }

        .stat-value {
            font-weight: 700;
            color: #28a745;
            font-size: 18px;
        }

        p {
            font-size: 18px;
            color: #718096;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 15px 35px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            margin: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(102, 126, 234, 0.6);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">✨</div>
        <h1>¡CRM Limpiado Completamente!</h1>
        <p>
            Todos los datos han sido eliminados.<br>
            La base de datos está lista para importar datos nuevos.
        </p>

        <div class="stats">
            <div class="stat-item">
                <span class="stat-label">🗑️ Clientes eliminados:</span>
                <span class="stat-value"><?php echo $clientes_eliminados; ?></span>
            </div>
            <div class="stat-item">
                <span class="stat-label">📧 Campañas eliminadas:</span>
                <span class="stat-value"><?php echo $campanas_eliminadas; ?></span>
            </div>
            <div class="stat-item">
                <span class="stat-label">📨 Envíos eliminados:</span>
                <span class="stat-value"><?php echo $envios_eliminados; ?></span>
            </div>
        </div>

        <p style="background: #e7f3ff; padding: 15px; border-radius: 8px; font-size: 14px;">
            <strong>✅ Siguiente paso:</strong> Ve al importador de Excel para subir tus archivos
        </p>

        <a href="importar-todos-excel-crm.php" class="btn btn-success">
            📥 Importar Excel Ahora
        </a>
        <a href="crm-mailing-completo.php" class="btn">
            📧 Ir al CRM
        </a>
    </div>
</body>
</html>

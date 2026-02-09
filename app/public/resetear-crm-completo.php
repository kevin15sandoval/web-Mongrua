<?php
/**
 * Resetear CRM y Empezar de Cero
 * Borra todos los datos mal importados y prepara el sistema correctamente
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

global $wpdb;
$table_name = $wpdb->prefix . 'mongruas_clientes';

// Borrar todos los datos actuales
$wpdb->query("TRUNCATE TABLE $table_name");

// Recrear la tabla con la estructura correcta
$wpdb->query("DROP TABLE IF EXISTS $table_name");

$charset_collate = $wpdb->get_charset_collate();
$sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    nombre varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    telefono varchar(50) DEFAULT '',
    empresa varchar(255) DEFAULT '',
    direccion varchar(255) DEFAULT '',
    ciudad varchar(100) DEFAULT '',
    provincia varchar(100) DEFAULT '',
    codigo_postal varchar(10) DEFAULT '',
    sector varchar(100) DEFAULT 'Servicios',
    interes varchar(255) DEFAULT '',
    lista varchar(100) DEFAULT '',
    origen varchar(50) DEFAULT 'Manual',
    estado varchar(20) DEFAULT 'activo',
    notas text DEFAULT '',
    fecha_registro datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY  (id),
    KEY email (email),
    KEY sector (sector),
    KEY lista (lista),
    KEY estado (estado)
) $charset_collate;";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✨ CRM Reseteado</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        }

        h1 {
            font-size: 36px;
            color: #2d3748;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            color: #718096;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 15px 35px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            margin: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(40, 167, 69, 0.6);
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">✨</div>
        <h1>¡CRM Reseteado!</h1>
        <p>
            La base de datos ha sido limpiada completamente.<br>
            Ahora puedes importar los datos correctamente con el nuevo sistema mejorado.
        </p>
        <a href="crm-mailing-completo.php" class="btn">
            📧 Ir al CRM
        </a>
    </div>
</body>
</html>

<?php
/**
 * RECREAR TABLA CRM CON ESTRUCTURA COMPLETA
 * Elimina la tabla antigua y crea una nueva con todos los campos
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

global $wpdb;
$table_name = $wpdb->prefix . 'mongruas_clientes';

// ELIMINAR tabla antigua
$wpdb->query("DROP TABLE IF EXISTS $table_name");

// CREAR tabla nueva con estructura completa
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
    notas text DEFAULT NULL,
    fecha_registro datetime DEFAULT CURRENT_TIMESTAMP,
    ultima_actividad datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY  (id),
    KEY email (email),
    KEY sector (sector),
    KEY lista (lista),
    KEY estado (estado)
) $charset_collate;";

$resultado = $wpdb->query($sql);

// Verificar que se creó correctamente
$tabla_existe = $wpdb->get_var("SHOW TABLES LIKE '$table_name'");

// Obtener estructura de la tabla
$columnas = $wpdb->get_results("DESCRIBE $table_name");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✅ Tabla CRM Recreada</title>
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
            padding: 40px 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }

        .icon {
            font-size: 80px;
            text-align: center;
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
            text-align: center;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 20px;
            border-radius: 12px;
            border-left: 5px solid #28a745;
            margin: 20px 0;
            font-weight: 600;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 12px;
            border-left: 5px solid #dc3545;
            margin: 20px 0;
            font-weight: 600;
        }

        .table-structure {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            margin: 20px 0;
        }

        .table-structure h3 {
            color: #2d3748;
            margin-bottom: 15px;
        }

        .column-item {
            background: white;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 3px solid #28a745;
        }

        .column-name {
            font-weight: 700;
            color: #2d3748;
        }

        .column-type {
            color: #718096;
            font-size: 14px;
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

        .btn-secondary {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .buttons {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="icon">✅</div>
            <h1>Tabla CRM Recreada Correctamente</h1>

            <?php if ($tabla_existe): ?>
                <div class="success">
                    ✅ La tabla <strong><?php echo $table_name; ?></strong> se ha creado correctamente con todas las columnas necesarias.
                </div>

                <div class="table-structure">
                    <h3>📋 Estructura de la Tabla (<?php echo count($columnas); ?> columnas)</h3>
                    <?php foreach ($columnas as $columna): ?>
                        <div class="column-item">
                            <span class="column-name">✓ <?php echo $columna->Field; ?></span>
                            <span class="column-type"><?php echo $columna->Type; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div style="background: #e7f3ff; padding: 20px; border-radius: 12px; margin: 20px 0;">
                    <h3 style="color: #0066cc; margin-bottom: 10px;">🎯 Columnas Importantes Creadas:</h3>
                    <ul style="margin-left: 20px; color: #2d3748; line-height: 1.8;">
                        <li><strong>nombre</strong> - Nombre del contacto</li>
                        <li><strong>email</strong> - Email (único)</li>
                        <li><strong>telefono</strong> - Teléfono</li>
                        <li><strong>empresa</strong> - Nombre de la empresa</li>
                        <li><strong>ciudad</strong> - Ciudad/Población ✨</li>
                        <li><strong>provincia</strong> - Provincia ✨</li>
                        <li><strong>direccion</strong> - Dirección completa</li>
                        <li><strong>codigo_postal</strong> - Código postal</li>
                        <li><strong>sector</strong> - Sector de actividad</li>
                        <li><strong>lista</strong> - Lista/Categoría ✨</li>
                        <li><strong>origen</strong> - Origen del contacto</li>
                        <li><strong>estado</strong> - Estado (activo/inactivo)</li>
                        <li><strong>notas</strong> - Observaciones</li>
                    </ul>
                </div>

            <?php else: ?>
                <div class="error">
                    ❌ Error: No se pudo crear la tabla. Por favor, verifica los permisos de la base de datos.
                </div>
            <?php endif; ?>

            <div class="buttons">
                <a href="importar-todos-excel-crm.php" class="btn">
                    📥 Importar Excel Ahora
                </a>
                <a href="crm-mailing-completo.php" class="btn btn-secondary">
                    📧 Ir al CRM
                </a>
            </div>
        </div>
    </div>
</body>
</html>

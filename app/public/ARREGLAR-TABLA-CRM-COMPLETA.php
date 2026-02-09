<?php
/**
 * ARREGLAR TABLA CRM - Agregar columnas faltantes
 */

require_once('wp-config.php');
require_once('wp-load.php');

global $wpdb;
$table_name = $wpdb->prefix . 'mongruas_clientes';

echo "<h1>🔧 Arreglando Tabla del CRM</h1>";

// Verificar si la tabla existe
$tabla_existe = $wpdb->get_var("SHOW TABLES LIKE '$table_name'");

if (!$tabla_existe) {
    echo "<p style='color: red;'>❌ La tabla no existe. Creándola...</p>";
    
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
        ultima_actividad datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id),
        KEY email (email),
        KEY sector (sector),
        KEY lista (lista),
        KEY estado (estado)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    
    echo "<p style='color: green;'>✅ Tabla creada correctamente</p>";
} else {
    echo "<p style='color: green;'>✅ La tabla existe</p>";
    
    // Agregar columnas faltantes si no existen
    $columnas_necesarias = [
        'ciudad' => "ALTER TABLE $table_name ADD COLUMN ciudad varchar(100) DEFAULT ''",
        'provincia' => "ALTER TABLE $table_name ADD COLUMN provincia varchar(100) DEFAULT ''",
        'codigo_postal' => "ALTER TABLE $table_name ADD COLUMN codigo_postal varchar(10) DEFAULT ''",
        'direccion' => "ALTER TABLE $table_name ADD COLUMN direccion varchar(255) DEFAULT ''",
        'lista' => "ALTER TABLE $table_name ADD COLUMN lista varchar(100) DEFAULT ''",
        'interes' => "ALTER TABLE $table_name ADD COLUMN interes varchar(255) DEFAULT ''",
        'origen' => "ALTER TABLE $table_name ADD COLUMN origen varchar(50) DEFAULT 'Manual'",
        'estado' => "ALTER TABLE $table_name ADD COLUMN estado varchar(20) DEFAULT 'activo'",
        'notas' => "ALTER TABLE $table_name ADD COLUMN notas text DEFAULT ''",
        'ultima_actividad' => "ALTER TABLE $table_name ADD COLUMN ultima_actividad datetime DEFAULT CURRENT_TIMESTAMP"
    ];
    
    foreach ($columnas_necesarias as $columna => $sql) {
        $existe = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE '$columna'");
        
        if (empty($existe)) {
            echo "<p>➕ Agregando columna: <strong>$columna</strong>...</p>";
            $wpdb->query($sql);
            echo "<p style='color: green;'>✅ Columna <strong>$columna</strong> agregada</p>";
        } else {
            echo "<p>✓ Columna <strong>$columna</strong> ya existe</p>";
        }
    }
}

echo "<hr>";
echo "<h2>📋 Estructura Final de la Tabla</h2>";
$columnas = $wpdb->get_results("SHOW COLUMNS FROM $table_name");

echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%; background: white;'>";
echo "<tr style='background: #f0f0f0;'>";
echo "<th>Campo</th><th>Tipo</th><th>Nulo</th><th>Default</th>";
echo "</tr>";

foreach ($columnas as $col) {
    echo "<tr>";
    echo "<td><strong>{$col->Field}</strong></td>";
    echo "<td>{$col->Type}</td>";
    echo "<td>{$col->Null}</td>";
    echo "<td>{$col->Default}</td>";
    echo "</tr>";
}

echo "</table>";

echo "<hr>";
echo "<p><a href='crm-mailing-completo.php' style='display: inline-block; background: #0066cc; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;'>✅ Ir al CRM</a></p>";
?>

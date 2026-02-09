<?php
/**
 * Quitar restricción de email obligatorio
 * Permite que los clientes NO tengan email
 */

require_once('wp-config.php');
require_once('wp-load.php');

global $wpdb;
$table_name = $wpdb->prefix . 'mongruas_clientes';

echo "<h1>🔧 Quitar Email Obligatorio del CRM</h1>";

// Modificar la columna email para que NO sea obligatoria
$sql = "ALTER TABLE $table_name MODIFY COLUMN email varchar(255) DEFAULT ''";

$resultado = $wpdb->query($sql);

if ($resultado !== false) {
    echo "<div style='background: #d4edda; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #28a745;'>";
    echo "<h2 style='color: #155724; margin: 0 0 10px 0;'>✅ ¡Actualización Exitosa!</h2>";
    echo "<p style='color: #155724; margin: 0;'>El campo email ya NO es obligatorio. Ahora puedes:</p>";
    echo "<ul style='color: #155724;'>";
    echo "<li>Importar clientes sin email</li>";
    echo "<li>Agregar clientes sin email</li>";
    echo "<li>Dejar el email vacío si no lo tienes</li>";
    echo "</ul>";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #dc3545;'>";
    echo "<h2 style='color: #721c24; margin: 0 0 10px 0;'>❌ Error</h2>";
    echo "<p style='color: #721c24;'>Error al modificar la tabla: " . $wpdb->last_error . "</p>";
    echo "</div>";
}

// Verificar la estructura actual
echo "<h2>📋 Estructura Actual de la Tabla</h2>";
$columnas = $wpdb->get_results("DESCRIBE $table_name");

echo "<table style='width: 100%; border-collapse: collapse; margin: 20px 0;'>";
echo "<tr style='background: #f8f9fa;'>";
echo "<th style='padding: 10px; border: 1px solid #ddd; text-align: left;'>Campo</th>";
echo "<th style='padding: 10px; border: 1px solid #ddd; text-align: left;'>Tipo</th>";
echo "<th style='padding: 10px; border: 1px solid #ddd; text-align: left;'>Null</th>";
echo "<th style='padding: 10px; border: 1px solid #ddd; text-align: left;'>Default</th>";
echo "</tr>";

foreach ($columnas as $columna) {
    echo "<tr>";
    echo "<td style='padding: 10px; border: 1px solid #ddd;'><strong>" . $columna->Field . "</strong></td>";
    echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $columna->Type . "</td>";
    echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $columna->Null . "</td>";
    echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . ($columna->Default ?: 'NULL') . "</td>";
    echo "</tr>";
}

echo "</table>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='crm-mailing-completo.php' style='padding: 15px 30px; background: #0066cc; color: white; text-decoration: none; border-radius: 8px; display: inline-block; margin: 5px;'>🏠 Ir al CRM</a>";
echo "<a href='importar-todos-excel-crm.php' style='padding: 15px 30px; background: #28a745; color: white; text-decoration: none; border-radius: 8px; display: inline-block; margin: 5px;'>📥 Importar Excel</a>";
echo "</div>";

echo "<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background: #f1f3f4;
}
h1, h2 {
    color: #2d3748;
}
</style>";
?>

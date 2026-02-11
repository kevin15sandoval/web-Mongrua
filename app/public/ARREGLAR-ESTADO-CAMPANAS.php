<?php
/**
 * Arreglar Estado de Campañas
 * Asegurar que todas las campañas no enviadas tengan estado 'borrador'
 */

require_once('wp-config.php');
require_once('wp-load.php');

global $wpdb;
$table_campanas = $wpdb->prefix . 'mongruas_campanas';

echo "<style>
body { font-family: Arial; max-width: 900px; margin: 50px auto; padding: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.container { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
h1 { color: #2d3748; text-align: center; }
.btn { display: inline-block; padding: 15px 30px; background: #0066cc; color: white; text-decoration: none; border-radius: 10px; border: none; cursor: pointer; font-size: 16px; font-weight: 600; margin: 10px 5px; }
.btn-success { background: #28a745; }
.btn-warning { background: #ffc107; color: #000; }
table { width: 100%; border-collapse: collapse; margin: 20px 0; }
th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
th { background: #f8f9fa; font-weight: 700; }
.success { color: #28a745; font-weight: bold; }
.error { color: #dc3545; font-weight: bold; }
.info { background: #e7f3ff; padding: 20px; border-radius: 12px; margin: 20px 0; border-left: 5px solid #0066cc; }
</style>";

echo "<div class='container'>";
echo "<h1>🔧 Arreglar Estado de Campañas</h1>";

// Obtener todas las campañas
$campanas = $wpdb->get_results("SELECT * FROM $table_campanas ORDER BY fecha_creacion DESC");

echo "<div class='info'>";
echo "<strong>📊 Estado Actual:</strong><br>";
echo "Total de campañas: <strong>" . count($campanas) . "</strong><br>";

$borradores = 0;
$enviadas = 0;
$otros = 0;

foreach ($campanas as $c) {
    if ($c->estado === 'borrador') $borradores++;
    elseif ($c->estado === 'enviada') $enviadas++;
    else $otros++;
}

echo "Borradores: <strong>$borradores</strong><br>";
echo "Enviadas: <strong>$enviadas</strong><br>";
if ($otros > 0) echo "Otros estados: <strong class='error'>$otros</strong><br>";
echo "</div>";

// Mostrar tabla de campañas
echo "<h2>📋 Campañas Actuales</h2>";
echo "<table>";
echo "<tr><th>ID</th><th>Nombre</th><th>Estado Actual</th><th>Estado en BD (raw)</th></tr>";

foreach ($campanas as $campana) {
    $color = '';
    if ($campana->estado === 'borrador') $color = 'background: #fff3cd;';
    elseif ($campana->estado === 'enviada') $color = 'background: #d4edda;';
    else $color = 'background: #f8d7da;';
    
    echo "<tr style='$color'>";
    echo "<td><strong>#{$campana->id}</strong></td>";
    echo "<td>" . esc_html($campana->nombre) . "</td>";
    echo "<td><strong>" . esc_html($campana->estado) . "</strong></td>";
    echo "<td><code>" . var_export($campana->estado, true) . "</code></td>";
    echo "</tr>";
}

echo "</table>";

// Acción: Arreglar estados
if (isset($_POST['arreglar'])) {
    echo "<div class='info'>";
    echo "<h3>🔧 Arreglando Estados...</h3>";
    
    $arreglados = 0;
    
    foreach ($campanas as $campana) {
        // Si no está enviada, ponerla como borrador
        if ($campana->estado !== 'enviada') {
            $resultado = $wpdb->update(
                $table_campanas,
                array('estado' => 'borrador'),
                array('id' => $campana->id)
            );
            
            if ($resultado !== false) {
                echo "<p class='success'>✅ Campaña #{$campana->id} actualizada a 'borrador'</p>";
                $arreglados++;
            }
        }
    }
    
    echo "<p><strong>Total arregladas: $arreglados</strong></p>";
    echo "<p><a href='ARREGLAR-ESTADO-CAMPANAS.php' class='btn btn-success'>🔄 Recargar</a></p>";
    echo "</div>";
}

// Acción: Forzar TODAS a borrador
if (isset($_POST['forzar_todas'])) {
    echo "<div class='info'>";
    echo "<h3>⚠️ Forzando TODAS las Campañas a Borrador...</h3>";
    
    $resultado = $wpdb->query("UPDATE $table_campanas SET estado = 'borrador'");
    
    if ($resultado !== false) {
        echo "<p class='success'>✅ Todas las campañas actualizadas a 'borrador'</p>";
        echo "<p>Campañas afectadas: <strong>$resultado</strong></p>";
    } else {
        echo "<p class='error'>❌ Error: " . $wpdb->last_error . "</p>";
    }
    
    echo "<p><a href='ARREGLAR-ESTADO-CAMPANAS.php' class='btn btn-success'>🔄 Recargar</a></p>";
    echo "</div>";
}

// Botones de acción
if (!isset($_POST['arreglar']) && !isset($_POST['forzar_todas'])) {
    echo "<div style='text-align: center; margin-top: 30px;'>";
    echo "<form method='post' style='display: inline;'>";
    echo "<button type='submit' name='arreglar' class='btn btn-success'>🔧 Arreglar Estados (Solo No Enviadas)</button>";
    echo "</form>";
    
    echo "<form method='post' style='display: inline;' onsubmit='return confirm(\"¿Estás seguro? Esto cambiará TODAS las campañas a borrador, incluso las enviadas.\");'>";
    echo "<button type='submit' name='forzar_todas' class='btn btn-warning'>⚠️ Forzar TODAS a Borrador</button>";
    echo "</form>";
    echo "</div>";
}

echo "<div style='text-align: center; margin-top: 30px;'>";
echo "<a href='crm-mailing-completo.php#campanas' class='btn'>📧 Ir a Campañas</a>";
echo "<a href='INSPECCIONAR-HTML-CAMPANAS.php' class='btn' style='background: #6c757d;'>🔍 Inspeccionar HTML</a>";
echo "</div>";

echo "</div>";
?>

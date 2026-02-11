<?php
/**
 * Inspeccionar HTML Generado - Campañas
 * Ver exactamente qué HTML se está generando en la columna Acciones
 */

require_once('wp-config.php');
require_once('wp-load.php');

global $wpdb;
$table_campanas = $wpdb->prefix . 'mongruas_campanas';

// Obtener campañas
$campanas_recientes = $wpdb->get_results("SELECT * FROM $table_campanas ORDER BY fecha_creacion DESC LIMIT 50");

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Inspeccionar HTML - Campañas</title>
    <style>
        body { font-family: Arial; max-width: 1400px; margin: 20px auto; padding: 20px; background: #f5f5f5; }
        .card { background: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h1 { color: #2d3748; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { padding: 12px; text-align: left; border: 1px solid #e0e0e0; }
        th { background: #f8f9fa; font-weight: 700; }
        .badge { padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: 600; display: inline-block; }
        .badge-warning { background: #ffc107; color: #000; }
        .badge-success { background: #28a745; color: white; }
        .btn { padding: 8px 15px; background: #0066cc; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 13px; }
        .btn-primary { background: #0066cc; }
        .error { color: #dc3545; font-weight: bold; }
        .success { color: #28a745; font-weight: bold; }
        .code { background: #2d3748; color: #e2e8f0; padding: 15px; border-radius: 8px; font-family: monospace; font-size: 12px; overflow-x: auto; margin: 10px 0; }
        .highlight { background: #fff3cd; padding: 2px 5px; border-radius: 3px; }
    </style>
</head>
<body>";

echo "<h1>🔍 Inspeccionar HTML Generado - Campañas</h1>";

echo "<div class='card'>";
echo "<h2>📋 Campañas y su HTML Generado</h2>";

if ($campanas_recientes && count($campanas_recientes) > 0) {
    echo "<p class='success'>✅ Se encontraron " . count($campanas_recientes) . " campañas</p>";
    
    echo "<table>";
    echo "<tr>";
    echo "<th style='width: 50px;'>ID</th>";
    echo "<th style='width: 200px;'>Nombre</th>";
    echo "<th style='width: 100px;'>Estado</th>";
    echo "<th>HTML Generado en Columna 'Acciones'</th>";
    echo "</tr>";
    
    foreach ($campanas_recientes as $campana) {
        echo "<tr>";
        echo "<td><strong>#{$campana->id}</strong></td>";
        echo "<td>" . esc_html($campana->nombre) . "</td>";
        echo "<td>";
        
        if ($campana->estado === 'borrador') {
            echo "<span class='badge badge-warning'>BORRADOR</span>";
        } else {
            echo "<span class='badge badge-success'>ENVIADA</span>";
        }
        
        echo "</td>";
        echo "<td>";
        
        // GENERAR EL MISMO HTML QUE EN crm-mailing-completo.php
        echo "<div style='background: #f8f9fa; padding: 10px; border-radius: 5px;'>";
        echo "<strong>Condición:</strong> <code>\$campana->estado === 'borrador'</code> = <span class='highlight'>" . ($campana->estado === 'borrador' ? 'TRUE' : 'FALSE') . "</span><br><br>";
        
        if ($campana->estado === 'borrador') {
            echo "<strong>✅ Debería mostrar:</strong><br>";
            echo "<div class='code'>";
            $html_boton = '<button 
    type="button"
    onclick="abrirEditorCampana(' . $campana->id . ')"
    class="btn btn-primary" 
    data-campana-id="' . $campana->id . '"
    data-campana-nombre="' . esc_attr($campana->nombre) . '"
    data-campana-asunto="' . esc_attr($campana->asunto) . '"
    data-campana-contenido="' . esc_attr(substr($campana->contenido, 0, 50)) . '..."
    data-campana-segmento="' . esc_attr($campana->segmento) . '"
    style="padding: 8px 15px; margin: 0 0 5px 0; font-size: 13px; display: block; width: 100%;">
    📝 Editar y Enviar
</button>';
            echo htmlspecialchars($html_boton);
            echo "</div>";
            
            echo "<strong>Botón Real:</strong><br>";
            echo $html_boton;
        } else {
            echo "<strong>❌ Debería mostrar:</strong><br>";
            echo "<span class='badge badge-success'>Enviada</span>";
        }
        
        echo "</div>";
        echo "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "<p class='error'>❌ No hay campañas en la base de datos</p>";
}

echo "</div>";

// Mostrar el código PHP exacto que se usa en crm-mailing-completo.php
echo "<div class='card'>";
echo "<h2>📝 Código PHP Usado en crm-mailing-completo.php</h2>";
echo "<div class='code'>";
echo htmlspecialchars('
<td>
    <?php if ($campana->estado === \'borrador\'): ?>
    <button 
        type="button"
        onclick="abrirEditorCampana(<?php echo $campana->id; ?>)"
        class="btn btn-primary" 
        data-campana-id="<?php echo $campana->id; ?>"
        data-campana-nombre="<?php echo esc_attr($campana->nombre); ?>"
        data-campana-asunto="<?php echo esc_attr($campana->asunto); ?>"
        data-campana-contenido="<?php echo esc_attr($campana->contenido); ?>"
        data-campana-segmento="<?php echo esc_attr($campana->segmento); ?>"
        style="padding: 8px 15px; margin: 0 0 5px 0; font-size: 13px; display: block; width: 100%;">
        📝 Editar y Enviar
    </button>
    <?php else: ?>
    <span class="badge badge-success">Enviada</span>
    <?php endif; ?>
</td>
');
echo "</div>";
echo "</div>";

// Instrucciones
echo "<div class='card'>";
echo "<h2>🔍 Qué Hacer Ahora</h2>";
echo "<ol>";
echo "<li><strong>Compara el HTML:</strong> Los botones que ves arriba deberían aparecer en crm-mailing-completo.php</li>";
echo "<li><strong>Inspecciona en el navegador:</strong> Ve a <code>crm-mailing-completo.php#campanas</code>, haz clic derecho en la tabla → Inspeccionar</li>";
echo "<li><strong>Busca la columna 'Acciones':</strong> Verifica si el HTML del botón está presente en el código fuente</li>";
echo "<li><strong>Si el botón NO está en el HTML:</strong> El problema está en el archivo PHP</li>";
echo "<li><strong>Si el botón SÍ está en el HTML pero no se ve:</strong> El problema es CSS o JavaScript</li>";
echo "</ol>";

echo "<p><strong>Prueba los botones de arriba:</strong> Si funcionan aquí, el código es correcto.</p>";

echo "<div style='margin-top: 20px;'>";
echo "<a href='crm-mailing-completo.php#campanas' class='btn btn-primary' style='text-decoration: none; display: inline-block;'>📧 Ir a CRM Campañas</a> ";
echo "<a href='VER-CAMPANAS-AHORA.php' class='btn' style='background: #28a745; text-decoration: none; display: inline-block;'>🔄 Ver Diagnóstico Completo</a>";
echo "</div>";

echo "</div>";

echo "</body></html>";
?>

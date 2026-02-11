<?php
/**
 * Ver Campañas - Diagnóstico Rápido
 */

require_once('wp-config.php');
require_once('wp-load.php');

global $wpdb;
$table_campanas = $wpdb->prefix . 'mongruas_campanas';

echo "<style>
body { font-family: Arial; max-width: 1200px; margin: 20px auto; padding: 20px; background: #f5f5f5; }
.card { background: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
h1 { color: #2d3748; }
table { width: 100%; border-collapse: collapse; margin: 15px 0; }
th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
th { background: #f8f9fa; font-weight: 700; }
.badge { padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: 600; }
.badge-warning { background: #ffc107; color: #000; }
.badge-success { background: #28a745; color: white; }
.btn { padding: 10px 20px; background: #0066cc; color: white; text-decoration: none; border-radius: 8px; display: inline-block; margin: 5px; }
.error { color: #dc3545; font-weight: bold; }
.success { color: #28a745; font-weight: bold; }
</style>";

echo "<h1>🔍 Ver Campañas - Estado Actual</h1>";

// Obtener todas las campañas
$campanas = $wpdb->get_results("SELECT * FROM $table_campanas ORDER BY fecha_creacion DESC");

echo "<div class='card'>";
echo "<h2>📋 Campañas en Base de Datos</h2>";

if ($campanas && count($campanas) > 0) {
    echo "<p class='success'>✅ Se encontraron " . count($campanas) . " campañas</p>";
    
    $borradores = array_filter($campanas, function($c) { return $c->estado === 'borrador'; });
    $enviadas = array_filter($campanas, function($c) { return $c->estado === 'enviada'; });
    
    echo "<p><strong>Borradores:</strong> " . count($borradores) . " | <strong>Enviadas:</strong> " . count($enviadas) . "</p>";
    
    echo "<table>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Nombre</th>";
    echo "<th>Asunto</th>";
    echo "<th>Estado</th>";
    echo "<th>Segmento</th>";
    echo "<th>Fecha</th>";
    echo "<th>¿Botón debe aparecer?</th>";
    echo "</tr>";
    
    foreach ($campanas as $campana) {
        $debe_aparecer = ($campana->estado === 'borrador') ? '✅ SÍ' : '❌ NO';
        $color_fila = ($campana->estado === 'borrador') ? 'background: #e7f3ff;' : '';
        
        echo "<tr style='$color_fila'>";
        echo "<td><strong>#{$campana->id}</strong></td>";
        echo "<td>" . esc_html($campana->nombre) . "</td>";
        echo "<td>" . esc_html(substr($campana->asunto, 0, 40)) . "...</td>";
        echo "<td>";
        if ($campana->estado === 'borrador') {
            echo "<span class='badge badge-warning'>BORRADOR</span>";
        } else {
            echo "<span class='badge badge-success'>ENVIADA</span>";
        }
        echo "</td>";
        echo "<td>" . esc_html($campana->segmento) . "</td>";
        echo "<td>" . date('d/m/Y H:i', strtotime($campana->fecha_creacion)) . "</td>";
        echo "<td><strong>$debe_aparecer</strong></td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Mostrar el HTML del botón que debería aparecer
    if (count($borradores) > 0) {
        echo "<div style='background: #e7f3ff; padding: 20px; border-radius: 8px; margin-top: 20px;'>";
        echo "<h3>🔘 Código del Botón que Debería Aparecer</h3>";
        echo "<p>Para la primera campaña en borrador:</p>";
        
        $primera_borrador = reset($borradores);
        
        echo "<pre style='background: #2d3748; color: #e2e8f0; padding: 15px; border-radius: 8px; overflow-x: auto;'>";
        echo htmlspecialchars('
<button 
    type="button"
    onclick="abrirEditorCampana(' . $primera_borrador->id . ')"
    class="btn btn-primary" 
    data-campana-id="' . $primera_borrador->id . '"
    data-campana-nombre="' . esc_attr($primera_borrador->nombre) . '"
    data-campana-asunto="' . esc_attr($primera_borrador->asunto) . '"
    data-campana-contenido="' . esc_attr(substr($primera_borrador->contenido, 0, 50)) . '..."
    data-campana-segmento="' . esc_attr($primera_borrador->segmento) . '"
    style="padding: 8px 15px; margin: 0 0 5px 0; font-size: 13px; display: block; width: 100%;">
    📝 Editar y Enviar
</button>
        ');
        echo "</pre>";
        echo "</div>";
    }
    
} else {
    echo "<p class='error'>❌ NO hay campañas en la base de datos</p>";
    echo "<p>Necesitas crear al menos una campaña para que aparezca el botón.</p>";
}

echo "</div>";

// Verificar el código PHP que genera el botón
echo "<div class='card'>";
echo "<h2>🔍 Verificar Código PHP</h2>";

echo "<p>El botón se genera con este código PHP en crm-mailing-completo.php:</p>";

echo "<pre style='background: #2d3748; color: #e2e8f0; padding: 15px; border-radius: 8px; overflow-x: auto;'>";
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
echo "</pre>";

echo "<p><strong>Condición clave:</strong> <code>\$campana->estado === 'borrador'</code></p>";
echo "<p>El botón SOLO aparece si el estado es exactamente 'borrador' (minúsculas).</p>";

echo "</div>";

// Acciones
echo "<div class='card'>";
echo "<h2>🎯 Acciones</h2>";

if (!$campanas || count($campanas) === 0) {
    echo "<p><strong>1. Crear una campaña de prueba:</strong></p>";
    echo "<form method='post' style='margin: 15px 0;'>";
    echo "<input type='hidden' name='crear_campana_test' value='1'>";
    echo "<button type='submit' class='btn' style='background: #28a745;'>➕ Crear Campaña de Prueba</button>";
    echo "</form>";
}

if (isset($_POST['crear_campana_test'])) {
    $resultado = $wpdb->insert(
        $table_campanas,
        array(
            'nombre' => 'Campaña de Prueba ' . date('H:i:s'),
            'asunto' => 'Asunto de Prueba',
            'contenido' => '<p>Contenido de prueba</p>',
            'segmento' => 'todos',
            'estado' => 'borrador'
        )
    );
    
    if ($resultado) {
        echo "<p class='success'>✅ Campaña creada! Recargando...</p>";
        echo "<script>setTimeout(() => location.reload(), 1000);</script>";
    }
}

echo "<p><strong>2. Ir al CRM y verificar:</strong></p>";
echo "<a href='crm-mailing-completo.php#campanas' class='btn'>📧 Ir a Campañas</a>";

echo "<p><strong>3. Ver el HTML generado:</strong></p>";
echo "<p>Abre crm-mailing-completo.php#campanas, haz clic derecho en la tabla → Inspeccionar elemento → Busca la columna 'Acciones'</p>";

echo "</div>";

// Verificar si el archivo tiene el código correcto
echo "<div class='card'>";
echo "<h2>📄 Verificar Archivo crm-mailing-completo.php</h2>";

$archivo = file_get_contents('crm-mailing-completo.php');

// Buscar el código del botón
if (strpos($archivo, 'Editar y Enviar') !== false) {
    echo "<p class='success'>✅ El texto 'Editar y Enviar' existe en el archivo</p>";
} else {
    echo "<p class='error'>❌ El texto 'Editar y Enviar' NO existe en el archivo</p>";
}

if (strpos($archivo, 'abrirEditorCampana') !== false) {
    echo "<p class='success'>✅ La función 'abrirEditorCampana' existe en el archivo</p>";
} else {
    echo "<p class='error'>❌ La función 'abrirEditorCampana' NO existe en el archivo</p>";
}

if (strpos($archivo, "estado === 'borrador'") !== false) {
    echo "<p class='success'>✅ La condición del estado 'borrador' existe</p>";
} else {
    echo "<p class='error'>❌ La condición del estado 'borrador' NO existe</p>";
}

echo "</div>";
?>

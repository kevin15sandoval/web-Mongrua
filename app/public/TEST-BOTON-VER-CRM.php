<?php
/**
 * Test del botón Ver - Diagnóstico AJAX
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

global $wpdb;
$table_clientes = $wpdb->prefix . 'mongruas_clientes';

echo "<h1>🔍 Test del Botón Ver - CRM</h1>";

// Test 1: Ver si la tabla existe
echo "<h2>Test 1: Verificar tabla</h2>";
$tabla_existe = $wpdb->get_var("SHOW TABLES LIKE '$table_clientes'");
if ($tabla_existe) {
    echo "✅ Tabla existe: $table_clientes<br>";
} else {
    echo "❌ Tabla NO existe<br>";
}

// Test 2: Ver cuántos clientes hay
echo "<h2>Test 2: Contar clientes</h2>";
$total = $wpdb->get_var("SELECT COUNT(*) FROM $table_clientes");
echo "Total de clientes: <strong>$total</strong><br>";

// Test 3: Obtener primer cliente
echo "<h2>Test 3: Obtener primer cliente</h2>";
$primer_cliente = $wpdb->get_row("SELECT * FROM $table_clientes ORDER BY id ASC LIMIT 1");
if ($primer_cliente) {
    echo "✅ Cliente encontrado:<br>";
    echo "<pre>";
    print_r($primer_cliente);
    echo "</pre>";
    
    $cliente_id = $primer_cliente->id;
    
    // Test 4: Simular la petición AJAX
    echo "<h2>Test 4: Simular petición AJAX</h2>";
    echo "<p>Simulando: ?accion=obtener_detalle_cliente&cliente_id=$cliente_id</p>";
    
    $cliente = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_clientes WHERE id = %d", $cliente_id));
    
    if ($cliente) {
        $respuesta = [
            'success' => true,
            'cliente' => [
                'nombre' => $cliente->nombre ?? '',
                'email' => $cliente->email ?? '',
                'telefono' => $cliente->telefono ?? '',
                'empresa' => $cliente->empresa ?? '',
                'ciudad' => $cliente->ciudad ?? '',
                'provincia' => $cliente->provincia ?? '',
                'sector' => $cliente->sector ?? '',
                'lista' => $cliente->lista ?? '',
                'origen' => $cliente->origen ?? '',
                'estado' => $cliente->estado ?? 'activo',
                'notas' => $cliente->notas ?? '',
                'fecha_registro' => isset($cliente->fecha_registro) ? date('d/m/Y H:i', strtotime($cliente->fecha_registro)) : ''
            ]
        ];
        
        echo "✅ Respuesta JSON:<br>";
        echo "<pre>";
        echo json_encode($respuesta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        echo "</pre>";
    } else {
        echo "❌ No se pudo obtener el cliente<br>";
    }
    
    // Test 5: Probar el botón Ver en vivo
    echo "<h2>Test 5: Probar botón Ver</h2>";
    echo "<button onclick='testVerCliente($cliente_id)' style='padding: 12px 24px; background: #0066cc; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 16px;'>
        👁️ Probar Ver Cliente #$cliente_id
    </button>";
    
    echo "<div id='resultado' style='margin-top: 20px; padding: 20px; background: #f8f9fa; border-radius: 8px; display: none;'></div>";
    
} else {
    echo "❌ No hay clientes en la base de datos<br>";
}

// Test 6: Verificar URL del CRM
echo "<h2>Test 6: URLs</h2>";
$url_crm = home_url('/crm-mailing-completo.php');
echo "URL del CRM: <a href='$url_crm' target='_blank'>$url_crm</a><br>";
echo "URL actual: " . $_SERVER['REQUEST_URI'] . "<br>";

?>

<script>
function testVerCliente(clienteId) {
    const resultado = document.getElementById('resultado');
    resultado.style.display = 'block';
    resultado.innerHTML = '<p>⏳ Cargando...</p>';
    
    // Hacer petición AJAX
    fetch('crm-mailing-completo.php?accion=obtener_detalle_cliente&cliente_id=' + clienteId)
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            return response.text();
        })
        .then(text => {
            console.log('Response text:', text);
            
            // Intentar parsear como JSON
            try {
                const data = JSON.parse(text);
                resultado.innerHTML = '<h3>✅ Respuesta exitosa</h3><pre>' + JSON.stringify(data, null, 2) + '</pre>';
            } catch (e) {
                resultado.innerHTML = '<h3>❌ Error al parsear JSON</h3><p>La respuesta no es JSON válido:</p><pre>' + text + '</pre>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            resultado.innerHTML = '<h3>❌ Error de conexión</h3><p>' + error.message + '</p>';
        });
}
</script>

<style>
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

pre {
    background: white;
    padding: 15px;
    border-radius: 8px;
    overflow-x: auto;
    border: 1px solid #e0e0e0;
}
</style>

<div style="margin-top: 30px; text-align: center;">
    <a href="crm-mailing-completo.php" style="padding: 12px 24px; background: #28a745; color: white; text-decoration: none; border-radius: 8px; display: inline-block;">
        🏠 Ir al CRM Completo
    </a>
</div>

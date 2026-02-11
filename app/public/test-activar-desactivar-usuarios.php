<?php
/**
 * Test: Activar/Desactivar Usuarios del CRM
 * Verifica que el botón de activar/desactivar funciona correctamente
 */

require_once('wp-load.php');

global $wpdb;
$table_clientes = $wpdb->prefix . 'mongruas_clientes';

// Obtener algunos clientes de prueba
$clientes = $wpdb->get_results("SELECT * FROM $table_clientes LIMIT 5");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test - Activar/Desactivar Usuarios</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        h1 {
            color: #2d3748;
            margin-bottom: 10px;
        }
        
        .status {
            background: #e6f7ff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #1890ff;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th {
            background: #f7fafc;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #4a5568;
            border-bottom: 2px solid #e2e8f0;
        }
        
        td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        
        .badge-success {
            background: #c6f6d5;
            color: #22543d;
        }
        
        .badge-warning {
            background: #feebc8;
            color: #7c2d12;
        }
        
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0 5px;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }
        
        .btn-warning {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            color: white;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .instructions {
            background: #fff3cd;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
            border-left: 4px solid #ffc107;
        }
        
        .instructions h3 {
            color: #856404;
            margin-bottom: 10px;
        }
        
        .instructions ul {
            margin-left: 20px;
            color: #856404;
        }
        
        .instructions li {
            margin: 8px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Test: Activar/Desactivar Usuarios</h1>
        <p style="color: #718096; margin-bottom: 20px;">Prueba la funcionalidad de activar/desactivar usuarios del CRM</p>
        
        <div class="status">
            <strong>✅ Sistema listo</strong><br>
            Total de clientes en la base de datos: <?php echo count($clientes); ?>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Empresa</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><strong>#<?php echo $cliente->id; ?></strong></td>
                    <td><?php echo esc_html($cliente->nombre); ?></td>
                    <td><?php echo esc_html($cliente->email); ?></td>
                    <td><?php echo esc_html($cliente->empresa); ?></td>
                    <td>
                        <span class="badge badge-<?php echo $cliente->estado === 'activo' ? 'success' : 'warning'; ?>" id="badge-<?php echo $cliente->id; ?>">
                            <?php echo ucfirst($cliente->estado); ?>
                        </span>
                    </td>
                    <td>
                        <button onclick="toggleEstadoCliente(<?php echo $cliente->id; ?>, '<?php echo $cliente->estado; ?>')" 
                                class="btn <?php echo $cliente->estado === 'activo' ? 'btn-warning' : 'btn-success'; ?>" 
                                id="btn-estado-<?php echo $cliente->id; ?>">
                            <?php echo $cliente->estado === 'activo' ? '🚫 Desactivar' : '✅ Activar'; ?>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="instructions">
            <h3>📋 Instrucciones:</h3>
            <ul>
                <li>Haz clic en "Desactivar" para desactivar un usuario activo</li>
                <li>Haz clic en "Activar" para activar un usuario inactivo</li>
                <li>El estado se actualiza en tiempo real sin recargar la página</li>
                <li>Los usuarios inactivos no recibirán emails de campañas</li>
            </ul>
        </div>
        
        <div style="margin-top: 30px; text-align: center;">
            <a href="crm-mailing-completo.php" class="btn btn-success">
                ← Volver al CRM
            </a>
        </div>
    </div>
    
    <script>
        function toggleEstadoCliente(clienteId, estadoActual) {
            const nuevoEstado = estadoActual === 'activo' ? 'inactivo' : 'activo';
            const accion = nuevoEstado === 'activo' ? 'activar' : 'desactivar';
            
            if (!confirm(`¿Estás seguro de que quieres ${accion} este cliente?`)) {
                return;
            }
            
            const boton = document.getElementById('btn-estado-' + clienteId);
            const estadoBadge = document.getElementById('badge-' + clienteId);
            
            // Deshabilitar botón mientras se procesa
            boton.disabled = true;
            boton.innerHTML = '⏳ Procesando...';
            
            // Crear FormData
            const formData = new FormData();
            formData.append('accion', 'toggle_estado_cliente');
            formData.append('cliente_id', clienteId);
            formData.append('nuevo_estado', nuevoEstado);
            
            // Hacer petición AJAX
            fetch('crm-mailing-completo.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Actualizar botón
                    if (data.nuevo_estado === 'activo') {
                        boton.className = 'btn btn-warning';
                        boton.innerHTML = '🚫 Desactivar';
                        estadoBadge.className = 'badge badge-success';
                        estadoBadge.textContent = 'Activo';
                    } else {
                        boton.className = 'btn btn-success';
                        boton.innerHTML = '✅ Activar';
                        estadoBadge.className = 'badge badge-warning';
                        estadoBadge.textContent = 'Inactivo';
                    }
                    
                    // Mostrar mensaje de éxito
                    alert('✅ ' + data.message);
                } else {
                    alert('❌ Error: ' + data.error);
                }
                
                // Rehabilitar botón
                boton.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Error de conexión');
                boton.disabled = false;
                boton.innerHTML = estadoActual === 'activo' ? '🚫 Desactivar' : '✅ Activar';
            });
        }
    </script>
</body>
</html>

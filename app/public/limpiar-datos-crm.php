<?php
/**
 * Limpiador de Datos del CRM
 * Reorganiza los datos mal importados: separa nombre, email y empresa
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

global $wpdb;
$table_name = $wpdb->prefix . 'mongruas_clientes';

$procesados = 0;
$corregidos = 0;
$eliminados = 0;

// Obtener todos los clientes
$clientes = $wpdb->get_results("SELECT * FROM $table_name");

foreach ($clientes as $cliente) {
    $procesados++;
    
    // El nombre contiene todo mezclado
    $nombre_completo = $cliente->nombre;
    $email_actual = $cliente->email;
    $empresa_actual = $cliente->empresa;
    
    // Extraer email del nombre si está ahí
    $email_extraido = '';
    if (preg_match('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/', $nombre_completo, $matches)) {
        $email_extraido = $matches[1];
    }
    
    // Extraer teléfono
    $telefono_extraido = '';
    if (preg_match('/(\+?\d{2,3}[\s-]?\d{3}[\s-]?\d{3}[\s-]?\d{3}|\d{9})/', $nombre_completo, $matches)) {
        $telefono_extraido = $matches[1];
    }
    
    // Limpiar el nombre: quitar email, teléfono y caracteres extraños
    $nombre_limpio = $nombre_completo;
    $nombre_limpio = preg_replace('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', '', $nombre_limpio);
    $nombre_limpio = preg_replace('/(\+?\d{2,3}[\s-]?\d{3}[\s-]?\d{3}[\s-]?\d{3}|\d{9})/', '', $nombre_limpio);
    $nombre_limpio = preg_replace('/["\';:,]/', '', $nombre_limpio);
    $nombre_limpio = preg_replace('/\s+/', ' ', $nombre_limpio);
    $nombre_limpio = trim($nombre_limpio);
    
    // Si el nombre limpio está vacío, usar la empresa
    if (empty($nombre_limpio) && !empty($empresa_actual)) {
        $nombre_limpio = $empresa_actual;
    }
    
    // Determinar el email correcto
    $email_final = $email_extraido ?: $email_actual;
    
    // Si el email es "pendiente", intentar generar uno mejor
    if (strpos($email_final, '@pendiente.com') !== false) {
        $email_final = strtolower(str_replace(' ', '', $nombre_limpio)) . '@pendiente.com';
    }
    
    // Determinar la empresa
    $empresa_final = $nombre_limpio;
    if (!empty($empresa_actual) && $empresa_actual !== $nombre_completo) {
        $empresa_final = $empresa_actual;
    }
    
    // Actualizar el registro
    $wpdb->update(
        $table_name,
        [
            'nombre' => $nombre_limpio,
            'email' => $email_final,
            'telefono' => $telefono_extraido ?: $cliente->telefono,
            'empresa' => $empresa_final
        ],
        ['id' => $cliente->id],
        ['%s', '%s', '%s', '%s'],
        ['%d']
    );
    
    $corregidos++;
}

// Eliminar duplicados por email
$duplicados = $wpdb->get_results("
    SELECT email, COUNT(*) as total, MIN(id) as keep_id
    FROM $table_name
    GROUP BY email
    HAVING total > 1
");

foreach ($duplicados as $dup) {
    $wpdb->query($wpdb->prepare(
        "DELETE FROM $table_name WHERE email = %s AND id != %d",
        $dup->email,
        $dup->keep_id
    ));
    $eliminados += ($dup->total - 1);
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🧹 Limpieza de Datos CRM</title>
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

        .container {
            max-width: 800px;
            width: 100%;
        }

        .card {
            background: white;
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .icon {
            font-size: 80px;
            margin-bottom: 20px;
            animation: bounce 2s infinite;
        }

        h1 {
            font-size: 36px;
            color: #2d3748;
            margin-bottom: 20px;
        }

        .subtitle {
            font-size: 18px;
            color: #718096;
            margin-bottom: 40px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 40px 0;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .stat-card.success {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .stat-card.warning {
            background: linear-gradient(135deg, #ffc107, #ff9800);
        }

        .stat-number {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 16px;
            opacity: 0.9;
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

        .message {
            background: #d4edda;
            color: #155724;
            padding: 20px;
            border-radius: 12px;
            border-left: 5px solid #28a745;
            margin: 30px 0;
            text-align: left;
        }

        .message h3 {
            margin-bottom: 10px;
        }

        .message ul {
            margin-left: 20px;
        }

        .message li {
            margin-bottom: 8px;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="icon">✨</div>
            <h1>¡Limpieza Completada!</h1>
            <p class="subtitle">Los datos del CRM han sido reorganizados correctamente</p>

            <div class="stats">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $procesados; ?></div>
                    <div class="stat-label">Registros Procesados</div>
                </div>

                <div class="stat-card success">
                    <div class="stat-number"><?php echo $corregidos; ?></div>
                    <div class="stat-label">Registros Corregidos</div>
                </div>

                <?php if ($eliminados > 0): ?>
                <div class="stat-card warning">
                    <div class="stat-number"><?php echo $eliminados; ?></div>
                    <div class="stat-label">Duplicados Eliminados</div>
                </div>
                <?php endif; ?>
            </div>

            <div class="message">
                <h3>✅ Cambios Realizados:</h3>
                <ul>
                    <li><strong>Nombres limpios:</strong> Se eliminaron emails y teléfonos del campo nombre</li>
                    <li><strong>Emails extraídos:</strong> Se movieron los emails al campo correcto</li>
                    <li><strong>Teléfonos extraídos:</strong> Se identificaron y guardaron en su campo</li>
                    <li><strong>Empresas organizadas:</strong> Se asignó correctamente el nombre de empresa</li>
                    <li><strong>Duplicados eliminados:</strong> Se mantuvieron solo registros únicos</li>
                </ul>
            </div>

            <div>
                <a href="crm-mailing-completo.php" class="btn btn-success">
                    📧 Ver Clientes en el CRM
                </a>
                <a href="panel-gestion-unificado.php" class="btn">
                    🏠 Panel de Gestión
                </a>
            </div>
        </div>
    </div>
</body>
</html>

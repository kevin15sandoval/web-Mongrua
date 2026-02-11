<?php
/**
 * Visualizador de Logs de Instagram
 * Muestra el historial de publicaciones y errores
 */

require_once('wp-load.php');

// Verificar permisos
if (!current_user_can('manage_options')) {
    wp_die('No tienes permisos para acceder a esta página');
}

global $wpdb;
$table_logs = $wpdb->prefix . 'social_logs';
$table_jobs = $wpdb->prefix . 'social_jobs';

// Obtener logs
$logs = $wpdb->get_results("
    SELECT l.*, c.name as course_name
    FROM {$table_logs} l
    LEFT JOIN {$wpdb->prefix}courses c ON l.course_id = c.id
    ORDER BY l.created_at DESC
    LIMIT 100
");

// Obtener jobs
$jobs = $wpdb->get_results("
    SELECT j.*, c.name as course_name
    FROM {$table_jobs} j
    LEFT JOIN {$wpdb->prefix}courses c ON j.course_id = c.id
    ORDER BY j.created_at DESC
    LIMIT 50
");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs de Instagram - Mongruas</title>
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
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .header {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            font-size: 32px;
            color: #2d3748;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        
        .btn-secondary {
            background: #e2e8f0;
            color: #4a5568;
        }
        
        .card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .card h2 {
            font-size: 24px;
            color: #2d3748;
            margin-bottom: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
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
            color: #2d3748;
        }
        
        tr:hover {
            background: #f7fafc;
        }
        
        .status {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        
        .status-success {
            background: #c6f6d5;
            color: #22543d;
        }
        
        .status-error {
            background: #fed7d7;
            color: #742a2a;
        }
        
        .status-pending {
            background: #feebc8;
            color: #7c2d12;
        }
        
        .status-completed {
            background: #bee3f8;
            color: #2c5282;
        }
        
        .status-failed {
            background: #fbb6ce;
            color: #702459;
        }
        
        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .tab {
            padding: 10px 20px;
            border: none;
            background: #e2e8f0;
            color: #4a5568;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .tab.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .message-cell {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .date-cell {
            font-size: 12px;
            color: #718096;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Logs de Instagram</h1>
            <div>
                <button onclick="processJobsNow()" class="btn btn-primary">
                    🔄 Procesar Ahora
                </button>
                <a href="configurar-instagram.php" class="btn btn-secondary">
                    ← Volver
                </a>
            </div>
        </div>
        
        <div class="card">
            <div class="tabs">
                <button class="tab active" onclick="showTab('jobs')">📦 Jobs</button>
                <button class="tab" onclick="showTab('logs')">📝 Logs</button>
            </div>
            
            <!-- Tab de Jobs -->
            <div id="jobs-tab" class="tab-content active">
                <h2>Jobs de Publicación</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Curso</th>
                            <th>Plataforma</th>
                            <th>Estado</th>
                            <th>Intentos</th>
                            <th>Error</th>
                            <th>Creado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jobs as $job): ?>
                            <tr>
                                <td><?php echo $job->id; ?></td>
                                <td><?php echo esc_html($job->course_name); ?></td>
                                <td><?php echo esc_html($job->platform); ?></td>
                                <td>
                                    <span class="status status-<?php echo $job->status; ?>">
                                        <?php echo ucfirst($job->status); ?>
                                    </span>
                                </td>
                                <td><?php echo $job->attempts; ?> / <?php echo $job->max_attempts; ?></td>
                                <td class="message-cell"><?php echo esc_html($job->error_message); ?></td>
                                <td class="date-cell"><?php echo $job->created_at; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Tab de Logs -->
            <div id="logs-tab" class="tab-content">
                <h2>Historial de Logs</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Job ID</th>
                            <th>Curso</th>
                            <th>Plataforma</th>
                            <th>Acción</th>
                            <th>Estado</th>
                            <th>Mensaje</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td><?php echo $log->id; ?></td>
                                <td><?php echo $log->job_id; ?></td>
                                <td><?php echo esc_html($log->course_name); ?></td>
                                <td><?php echo esc_html($log->platform); ?></td>
                                <td><?php echo esc_html($log->action); ?></td>
                                <td>
                                    <span class="status status-<?php echo $log->status; ?>">
                                        <?php echo ucfirst($log->status); ?>
                                    </span>
                                </td>
                                <td class="message-cell"><?php echo esc_html($log->message); ?></td>
                                <td class="date-cell"><?php echo $log->created_at; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
        function showTab(tabName) {
            // Ocultar todos los tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Mostrar el tab seleccionado
            document.getElementById(tabName + '-tab').classList.add('active');
            event.target.classList.add('active');
        }
        
        function processJobsNow() {
            if (!confirm('¿Procesar todos los jobs pendientes ahora?')) {
                return;
            }
            
            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=process_social_jobs_now'
            })
            .then(response => response.json())
            .then(data => {
                alert(data.data.message);
                location.reload();
            })
            .catch(error => {
                alert('Error al procesar jobs');
                console.error(error);
            });
        }
    </script>
</body>
</html>

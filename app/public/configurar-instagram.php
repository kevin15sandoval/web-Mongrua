<?php
/**
 * Panel de Configuración de Instagram
 * Configura las credenciales de Instagram Graph API
 */

require_once('wp-load.php');

// Verificar permisos
if (!current_user_can('manage_options')) {
    wp_die('No tienes permisos para acceder a esta página');
}

// Guardar configuración
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_instagram_config'])) {
    $config = array(
        'access_token' => sanitize_text_field($_POST['access_token']),
        'account_id' => sanitize_text_field($_POST['account_id']),
        'auto_publish' => isset($_POST['auto_publish']) ? 1 : 0
    );
    
    update_option('mongruas_instagram_config', $config);
    $success_message = '✅ Configuración guardada correctamente';
}

// Obtener configuración actual
$config = get_option('mongruas_instagram_config', array(
    'access_token' => '',
    'account_id' => '',
    'auto_publish' => 1
));

// Obtener estadísticas
global $social_media_automation;
$stats = $social_media_automation->get_stats();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Instagram - Mongruas</title>
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
        }
        
        .header {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 32px;
            color: #2d3748;
            margin-bottom: 10px;
        }
        
        .header p {
            color: #718096;
            font-size: 16px;
        }
        
        .grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        
        .card h2 {
            font-size: 24px;
            color: #2d3748;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .form-group input[type="text"],
        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: monospace;
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
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
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }
        
        .btn-secondary {
            background: #e2e8f0;
            color: #4a5568;
        }
        
        .btn-secondary:hover {
            background: #cbd5e0;
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert-success {
            background: #c6f6d5;
            color: #22543d;
            border: 1px solid #9ae6b4;
        }
        
        .alert-info {
            background: #bee3f8;
            color: #2c5282;
            border: 1px solid #90cdf4;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 20px;
            border-radius: 12px;
            color: white;
        }
        
        .stat-card h3 {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 8px;
        }
        
        .stat-card .number {
            font-size: 32px;
            font-weight: 700;
        }
        
        .help-text {
            background: #f7fafc;
            padding: 15px;
            border-radius: 8px;
            font-size: 13px;
            color: #4a5568;
            margin-top: 8px;
            border-left: 3px solid #667eea;
        }
        
        .instructions {
            background: #fff5f5;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #fc8181;
            margin-top: 20px;
        }
        
        .instructions h3 {
            color: #c53030;
            margin-bottom: 10px;
        }
        
        .instructions ol {
            margin-left: 20px;
            color: #742a2a;
        }
        
        .instructions li {
            margin-bottom: 8px;
        }
        
        .instructions a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        
        .instructions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📱 Configuración de Instagram</h1>
            <p>Configura la publicación automática en Instagram cuando se crea un nuevo curso</p>
        </div>
        
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success">
                <span><?php echo $success_message; ?></span>
            </div>
        <?php endif; ?>
        
        <div class="grid">
            <div class="card">
                <h2>⚙️ Configuración</h2>
                
                <form method="POST">
                    <div class="form-group">
                        <label for="access_token">Access Token de Instagram</label>
                        <textarea id="access_token" name="access_token" required><?php echo esc_textarea($config['access_token']); ?></textarea>
                        <div class="help-text">
                            Token de acceso de larga duración de Instagram Graph API
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="account_id">Instagram Account ID</label>
                        <input type="text" id="account_id" name="account_id" value="<?php echo esc_attr($config['account_id']); ?>" required>
                        <div class="help-text">
                            ID de tu cuenta de Instagram Business
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" id="auto_publish" name="auto_publish" <?php checked($config['auto_publish'], 1); ?>>
                            <label for="auto_publish">Publicar automáticamente al crear un curso</label>
                        </div>
                    </div>
                    
                    <button type="submit" name="save_instagram_config" class="btn btn-primary">
                        💾 Guardar Configuración
                    </button>
                    <a href="panel-gestion-unificado.php" class="btn btn-secondary">
                        ← Volver al Panel
                    </a>
                </form>
                
                <div class="instructions">
                    <h3>📋 Cómo obtener las credenciales:</h3>
                    <ol>
                        <li>Ve a <a href="https://developers.facebook.com/" target="_blank">Facebook Developers</a></li>
                        <li>Crea una aplicación y añade el producto "Instagram Graph API"</li>
                        <li>Conecta tu cuenta de Instagram Business</li>
                        <li>Genera un Access Token de larga duración</li>
                        <li>Obtén tu Instagram Account ID desde la API</li>
                    </ol>
                    <p style="margin-top: 15px;">
                        <strong>Nota:</strong> Necesitas una cuenta de Instagram Business conectada a una página de Facebook.
                    </p>
                </div>
            </div>
            
            <div>
                <div class="card">
                    <h2>📊 Estadísticas</h2>
                    
                    <div class="stats-grid">
                        <div class="stat-card">
                            <h3>Pendientes</h3>
                            <div class="number"><?php echo $stats['pending']; ?></div>
                        </div>
                        <div class="stat-card">
                            <h3>Completados</h3>
                            <div class="number"><?php echo $stats['completed']; ?></div>
                        </div>
                        <div class="stat-card">
                            <h3>Fallidos</h3>
                            <div class="number"><?php echo $stats['failed']; ?></div>
                        </div>
                        <div class="stat-card">
                            <h3>Total</h3>
                            <div class="number"><?php echo $stats['total']; ?></div>
                        </div>
                    </div>
                    
                    <a href="ver-logs-instagram.php" class="btn btn-secondary" style="width: 100%; text-align: center;">
                        📋 Ver Logs Completos
                    </a>
                </div>
                
                <div class="card" style="margin-top: 20px;">
                    <h2>ℹ️ Información</h2>
                    <div class="alert alert-info">
                        El sistema procesa automáticamente las publicaciones cada 5 minutos. Si falla, reintenta hasta 3 veces.
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

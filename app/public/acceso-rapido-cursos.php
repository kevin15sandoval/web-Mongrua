<?php
/**
 * Acceso Rápido - Gestión de Cursos
 * Enlace directo para la administradora
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>🎓 Gestión de Cursos - Mogruas</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
        }
        
        .container {
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
            color: #333;
        }
        
        h1 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #333;
        }
        
        .description {
            font-size: 18px;
            margin-bottom: 30px;
            color: #666;
        }
        
        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 400px;
            margin: 0 auto;
        }
        
        .btn {
            padding: 16px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #0066cc, #004499);
            color: white;
        }
        
        .btn-info {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        }
        
        .instructions {
            background: #e9ecef;
            padding: 20px;
            border-radius: 12px;
            margin-top: 30px;
            text-align: left;
        }
        
        .instructions h3 {
            color: #0066cc;
            margin-top: 0;
        }
        
        .instructions ol {
            color: #495057;
        }
        
        .instructions li {
            margin: 8px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎓 Gestión de Cursos</h1>
        <p class="description">Panel de control para gestionar los próximos cursos de Mogruas</p>
        
        <div class="btn-group">
            <a href="<?php echo home_url('/gestionar-proximos-cursos.php'); ?>" class="btn btn-primary">
                ✏️ Gestionar Próximos Cursos
            </a>
            
            <a href="<?php echo home_url('/anuncios'); ?>" class="btn btn-secondary">
                👀 Ver Página de Cursos
            </a>
            
            <a href="<?php echo admin_url(); ?>" class="btn btn-info">
                🏠 Panel de WordPress
            </a>
        </div>
        
        <div class="instructions">
            <h3>📋 Cómo usar:</h3>
            <ol>
                <li><strong>Haz clic en "Gestionar Próximos Cursos"</strong> para modificar los cursos</li>
                <li><strong>Rellena los formularios</strong> con la información de cada curso</li>
                <li><strong>Guarda los cambios</strong> y aparecerán automáticamente en la web</li>
                <li><strong>Verifica el resultado</strong> en "Ver Página de Cursos"</li>
            </ol>
            
            <p><strong>💡 Consejo:</strong> Guarda esta página en favoritos para acceso rápido</p>
        </div>
    </div>
</body>
</html>
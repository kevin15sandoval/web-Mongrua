<?php
/**
 * 🗺️ ARREGLAR MAPA DE GOOGLE
 * 
 * Herramienta para generar enlaces correctos de Google Maps
 */

// Cargar WordPress
require_once('wp-load.php');

// Verificar que el usuario sea administrador
if (!current_user_can('administrator')) {
    wp_redirect('/wp-admin/');
    exit;
}

$mensaje = '';

// Dirección de Mogruas
$direccion = "C. Cdad. de Faenza, 2, 45600 Talavera de la Reina, Toledo";
$nombre_empresa = "Formación y Enseñanza Mogruas";

// Enlaces generados
$enlaces = array(
    'busqueda' => "https://www.google.com/maps/search/" . urlencode($direccion),
    'lugar' => "https://www.google.com/maps/place/" . urlencode($direccion),
    'direcciones' => "https://www.google.com/maps/dir//" . urlencode($direccion),
    'empresa' => "https://www.google.com/maps/search/" . urlencode($nombre_empresa . " " . $direccion),
);

// Procesar actualización
if ($_POST && isset($_POST['actualizar'])) {
    $enlace_seleccionado = $_POST['enlace_tipo'];
    
    if (isset($enlaces[$enlace_seleccionado])) {
        // Leer el archivo footer.php
        $footer_path = get_template_directory() . '/footer.php';
        $footer_content = file_get_contents($footer_path);
        
        // Buscar y reemplazar el enlace roto
        $patron_viejo = '/https:\/\/maps\.app\.goo\.gl\/[a-zA-Z0-9]+/';
        $enlace_nuevo = $enlaces[$enlace_seleccionado];
        
        $footer_nuevo = preg_replace($patron_viejo, $enlace_nuevo, $footer_content);
        
        if ($footer_nuevo && $footer_nuevo !== $footer_content) {
            file_put_contents($footer_path, $footer_nuevo);
            $mensaje = "✅ Enlace del mapa actualizado correctamente";
        } else {
            $mensaje = "⚠️ No se encontró el enlace a reemplazar o ya estaba correcto";
        }
    } else {
        $mensaje = "❌ Tipo de enlace no válido";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🗺️ Arreglar Mapa de Google</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 30px;
            backdrop-filter: blur(10px);
        }
        
        .big-icon {
            font-size: 4em;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .section {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .link-option {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
            border: 2px solid transparent;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .link-option:hover {
            border-color: rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .link-option input[type="radio"] {
            margin-right: 10px;
        }
        
        .link-preview {
            font-family: monospace;
            font-size: 12px;
            color: #74c0fc;
            margin-top: 8px;
            word-break: break-all;
        }
        
        .action-button {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin: 5px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }
        
        .action-button.primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            font-weight: 600;
        }
        
        .alert.success {
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid #28a745;
            color: #51cf66;
        }
        
        .alert.warning {
            background: rgba(255, 193, 7, 0.2);
            border: 1px solid #ffc107;
            color: #ffd43b;
        }
        
        .alert.error {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid #dc3545;
            color: #ff6b6b;
        }
        
        h1, h2, h3 {
            text-align: center;
        }
        
        .info-box {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            padding: 15px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="big-icon">🗺️</div>
        <h1>Arreglar Mapa de Google</h1>
        <p style="text-align: center;">Soluciona el problema del enlace roto "Dynamic Link Not Found"</p>
        
        <?php if ($mensaje): ?>
            <div class="alert <?php echo strpos($mensaje, '✅') !== false ? 'success' : (strpos($mensaje, '⚠️') !== false ? 'warning' : 'error'); ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <div class="section">
            <h3>📍 Información de Ubicación</h3>
            <div class="info-box">
<strong>Empresa:</strong> <?php echo $nombre_empresa; ?>
<strong>Dirección:</strong> <?php echo $direccion; ?>
<strong>Problema:</strong> Enlace roto https://maps.app.goo.gl/myeEh4txXv05SGEny
            </div>
        </div>
        
        <div class="section">
            <h3>🔧 Selecciona el Tipo de Enlace</h3>
            <form method="post">
                <div class="link-option">
                    <label>
                        <input type="radio" name="enlace_tipo" value="lugar" checked>
                        <strong>📍 Enlace a Lugar Específico</strong> (Recomendado)
                        <div class="link-preview"><?php echo $enlaces['lugar']; ?></div>
                    </label>
                </div>
                
                <div class="link-option">
                    <label>
                        <input type="radio" name="enlace_tipo" value="busqueda">
                        <strong>🔍 Enlace de Búsqueda</strong>
                        <div class="link-preview"><?php echo $enlaces['busqueda']; ?></div>
                    </label>
                </div>
                
                <div class="link-option">
                    <label>
                        <input type="radio" name="enlace_tipo" value="direcciones">
                        <strong>🧭 Enlace para Direcciones</strong>
                        <div class="link-preview"><?php echo $enlaces['direcciones']; ?></div>
                    </label>
                </div>
                
                <div class="link-option">
                    <label>
                        <input type="radio" name="enlace_tipo" value="empresa">
                        <strong>🏢 Búsqueda por Empresa</strong>
                        <div class="link-preview"><?php echo $enlaces['empresa']; ?></div>
                    </label>
                </div>
                
                <div style="text-align: center; margin-top: 20px;">
                    <button type="submit" name="actualizar" class="action-button primary">
                        🔧 Actualizar Enlace del Mapa
                    </button>
                </div>
            </form>
        </div>
        
        <div class="section">
            <h3>🧪 Probar Enlaces</h3>
            <p>Prueba los enlaces antes de aplicar:</p>
            <div style="text-align: center;">
                <?php foreach ($enlaces as $tipo => $url): ?>
                    <a href="<?php echo $url; ?>" target="_blank" class="action-button">
                        🔗 Probar <?php echo ucfirst($tipo); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="section">
            <h3>ℹ️ Información</h3>
            <div class="info-box">
<strong>¿Qué hace esta herramienta?</strong>
• Reemplaza el enlace roto de Google Maps
• Genera enlaces correctos y funcionales
• Actualiza automáticamente el footer del sitio

<strong>Tipos de enlaces:</strong>
• <strong>Lugar Específico:</strong> Lleva directamente a la ubicación
• <strong>Búsqueda:</strong> Busca la dirección en Google Maps
• <strong>Direcciones:</strong> Abre el navegador para llegar allí
• <strong>Empresa:</strong> Busca por nombre de empresa

<strong>Recomendación:</strong> Usar "Lugar Específico" para mejor experiencia
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="/" class="action-button">🏠 Ir al Sitio</a>
            <a href="/wp-admin/" class="action-button">⚙️ WordPress Admin</a>
        </div>
        
        <div style="text-align: center; margin-top: 20px; color: rgba(255,255,255,0.7); font-size: 14px;">
            💡 Después de actualizar, prueba el botón "Cómo Llegar" en el footer del sitio
        </div>
    </div>
</body>
</html>
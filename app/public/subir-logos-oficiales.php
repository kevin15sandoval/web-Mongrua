<?php
/**
 * 🏛️ SUBIR LOGOS OFICIALES
 * 
 * Herramienta para subir los logos de Castilla-La Mancha y Ministerio
 */

// Cargar WordPress
require_once('wp-load.php');

// Verificar que el usuario sea administrador
if (!current_user_can('administrator')) {
    wp_redirect('/wp-admin/');
    exit;
}

$mensaje = '';
$tipo_mensaje = '';

// Crear directorio de imágenes si no existe
$images_dir = get_template_directory() . '/assets/images/';
if (!file_exists($images_dir)) {
    wp_mkdir_p($images_dir);
}

// Procesar subida de archivos
if ($_POST && isset($_FILES)) {
    $archivos_subidos = 0;
    
    foreach ($_FILES as $key => $file) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $nombre_archivo = '';
            
            // Determinar nombre del archivo según el tipo
            if ($key === 'logo_castilla') {
                $nombre_archivo = 'logo-castilla-la-mancha.png';
            } elseif ($key === 'logo_ministerio') {
                $nombre_archivo = 'logo-ministerio-educacion.png';
            }
            
            if ($nombre_archivo) {
                $ruta_destino = $images_dir . $nombre_archivo;
                
                // Verificar que sea una imagen
                $info_imagen = getimagesize($file['tmp_name']);
                if ($info_imagen !== false) {
                    if (move_uploaded_file($file['tmp_name'], $ruta_destino)) {
                        $archivos_subidos++;
                    }
                }
            }
        }
    }
    
    if ($archivos_subidos > 0) {
        $mensaje = "✅ Se subieron $archivos_subidos logo(s) correctamente";
        $tipo_mensaje = 'success';
    } else {
        $mensaje = "❌ No se pudo subir ningún archivo. Verifica que sean imágenes válidas.";
        $tipo_mensaje = 'error';
    }
}

// Verificar archivos existentes
$logo_castilla_existe = file_exists($images_dir . 'logo-castilla-la-mancha.png');
$logo_ministerio_existe = file_exists($images_dir . 'logo-ministerio-educacion.png');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏛️ Subir Logos Oficiales</title>
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
            max-width: 800px;
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
        
        .upload-area {
            border: 2px dashed rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin: 15px 0;
            transition: all 0.3s ease;
        }
        
        .upload-area:hover {
            border-color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.05);
        }
        
        .upload-area.has-file {
            border-color: #28a745;
            background: rgba(40, 167, 69, 0.1);
        }
        
        .file-input {
            display: none;
        }
        
        .upload-button {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin: 5px;
            transition: all 0.3s ease;
        }
        
        .upload-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }
        
        .upload-button.primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }
        
        .status-indicator {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
        }
        
        .status-exists {
            background: rgba(40, 167, 69, 0.3);
            color: #51cf66;
        }
        
        .status-missing {
            background: rgba(220, 53, 69, 0.3);
            color: #ff6b6b;
        }
        
        .preview-image {
            max-width: 150px;
            max-height: 80px;
            margin: 10px;
            border-radius: 5px;
            border: 2px solid rgba(255, 255, 255, 0.2);
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
            font-size: 14px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="big-icon">🏛️</div>
        <h1>Subir Logos Oficiales</h1>
        <p style="text-align: center;">Sube los logos de Castilla-La Mancha y Ministerio de Educación para el footer</p>
        
        <?php if ($mensaje): ?>
            <div class="alert <?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <div class="section">
            <h3>📁 Estado Actual de los Logos</h3>
            <div class="info-box">
                <p><strong>🏛️ Logo Castilla-La Mancha:</strong> 
                    <span class="status-indicator <?php echo $logo_castilla_existe ? 'status-exists' : 'status-missing'; ?>">
                        <?php echo $logo_castilla_existe ? '✅ Subido' : '❌ Falta'; ?>
                    </span>
                </p>
                <p><strong>🏛️ Logo Ministerio de Educación:</strong> 
                    <span class="status-indicator <?php echo $logo_ministerio_existe ? 'status-exists' : 'status-missing'; ?>">
                        <?php echo $logo_ministerio_existe ? '✅ Subido' : '❌ Falta'; ?>
                    </span>
                </p>
            </div>
            
            <?php if ($logo_castilla_existe || $logo_ministerio_existe): ?>
                <div style="text-align: center; margin: 20px 0;">
                    <h4>Vista Previa:</h4>
                    <?php if ($logo_castilla_existe): ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-castilla-la-mancha.png" 
                             alt="Castilla-La Mancha" class="preview-image">
                    <?php endif; ?>
                    <?php if ($logo_ministerio_existe): ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-ministerio-educacion.png" 
                             alt="Ministerio de Educación" class="preview-image">
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="section">
            <h3>📤 Subir Logos</h3>
            <form method="post" enctype="multipart/form-data">
                <div class="upload-area" onclick="document.getElementById('logo_castilla').click()">
                    <h4>🏛️ Logo Castilla-La Mancha</h4>
                    <p>Haz clic para seleccionar el archivo PNG/JPG</p>
                    <input type="file" id="logo_castilla" name="logo_castilla" accept="image/*" class="file-input">
                    <button type="button" class="upload-button">📁 Seleccionar Archivo</button>
                </div>
                
                <div class="upload-area" onclick="document.getElementById('logo_ministerio').click()">
                    <h4>🏛️ Logo Ministerio de Educación</h4>
                    <p>Haz clic para seleccionar el archivo PNG/JPG</p>
                    <input type="file" id="logo_ministerio" name="logo_ministerio" accept="image/*" class="file-input">
                    <button type="button" class="upload-button">📁 Seleccionar Archivo</button>
                </div>
                
                <div style="text-align: center; margin-top: 20px;">
                    <button type="submit" class="upload-button primary">
                        🚀 Subir Logos al Sitio
                    </button>
                </div>
            </form>
        </div>
        
        <div class="section">
            <h3>ℹ️ Información</h3>
            <div class="info-box">
<strong>¿Qué hace esta herramienta?</strong>
• Sube los logos oficiales al directorio del tema
• Los coloca en la ubicación correcta para el footer
• Optimiza automáticamente para web

<strong>Formatos aceptados:</strong>
• PNG (recomendado para logos)
• JPG/JPEG
• Tamaño recomendado: 200x100px máximo

<strong>Ubicación final:</strong>
• /wp-content/themes/mongruas-theme/assets/images/
• Se mostrarán automáticamente en el footer
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="/" class="upload-button">🏠 Ver Sitio</a>
            <a href="/wp-admin/upload.php" class="upload-button">📁 Biblioteca de Medios</a>
        </div>
        
        <div style="text-align: center; margin-top: 20px; color: rgba(255,255,255,0.7); font-size: 14px;">
            💡 Los logos aparecerán automáticamente en el footer una vez subidos
        </div>
    </div>

    <script>
        // Mejorar UX de subida de archivos
        document.getElementById('logo_castilla').addEventListener('change', function(e) {
            const area = e.target.closest('.upload-area');
            if (e.target.files.length > 0) {
                area.classList.add('has-file');
                area.querySelector('p').textContent = 'Archivo seleccionado: ' + e.target.files[0].name;
            }
        });
        
        document.getElementById('logo_ministerio').addEventListener('change', function(e) {
            const area = e.target.closest('.upload-area');
            if (e.target.files.length > 0) {
                area.classList.add('has-file');
                area.querySelector('p').textContent = 'Archivo seleccionado: ' + e.target.files[0].name;
            }
        });
    </script>
</body>
</html>
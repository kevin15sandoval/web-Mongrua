<?php
/**
 * 🔍 BUSCAR Y COPIAR LOGOS
 * 
 * Herramienta para encontrar y copiar los logos oficiales automáticamente
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

// Directorios donde buscar
$directorios_busqueda = [
    'doc/',
    './',
    'app/',
    'app/public/',
    'uploads/',
    'wp-content/uploads/',
];

// Patrones de nombres de archivos a buscar
$patrones_busqueda = [
    'ministerio' => [
        'Logotipo_del_Ministerio_de_Educación,_Formación_Profesional_y_Deportes.svg',
        'ministerio*.png',
        'ministerio*.jpg',
        'ministerio*.svg',
        'logo*ministerio*',
        '*ministerio*educacion*',
    ],
    'castilla' => [
        'logonuevoazul_0',
        'logonuevoazul_0.png',
        'logonuevoazul_0.jpg',
        'castilla*.png',
        'castilla*.jpg',
        'castilla*.svg',
        'logo*castilla*',
        '*castilla*mancha*',
    ]
];

// Función para buscar archivos
function buscar_archivos($patron, $directorios) {
    $archivos_encontrados = [];
    
    foreach ($directorios as $dir) {
        if (is_dir($dir)) {
            // Buscar archivos que coincidan con el patrón
            $archivos = glob($dir . $patron);
            if ($archivos) {
                $archivos_encontrados = array_merge($archivos_encontrados, $archivos);
            }
            
            // Buscar en subdirectorios
            $subdirs = glob($dir . '*', GLOB_ONLYDIR);
            foreach ($subdirs as $subdir) {
                $archivos = glob($subdir . '/' . $patron);
                if ($archivos) {
                    $archivos_encontrados = array_merge($archivos_encontrados, $archivos);
                }
            }
        }
    }
    
    return array_unique($archivos_encontrados);
}

// Función para copiar archivo
function copiar_logo($origen, $destino_nombre) {
    $destino_dir = get_template_directory() . '/assets/images/';
    
    // Crear directorio si no existe
    if (!file_exists($destino_dir)) {
        wp_mkdir_p($destino_dir);
    }
    
    $destino_completo = $destino_dir . $destino_nombre;
    
    // Copiar archivo
    if (copy($origen, $destino_completo)) {
        return true;
    }
    
    return false;
}

// Buscar logos
$logos_encontrados = [
    'ministerio' => [],
    'castilla' => []
];

foreach ($patrones_busqueda as $tipo => $patrones) {
    foreach ($patrones as $patron) {
        $archivos = buscar_archivos($patron, $directorios_busqueda);
        if ($archivos) {
            $logos_encontrados[$tipo] = array_merge($logos_encontrados[$tipo], $archivos);
        }
    }
    $logos_encontrados[$tipo] = array_unique($logos_encontrados[$tipo]);
}

// Procesar copia automática
if ($_POST && isset($_POST['copiar_automatico'])) {
    $copiados = 0;
    
    // Copiar logo del ministerio
    if (!empty($logos_encontrados['ministerio'])) {
        $archivo_ministerio = $logos_encontrados['ministerio'][0];
        if (copiar_logo($archivo_ministerio, 'logo-ministerio-educacion.png')) {
            $copiados++;
        }
    }
    
    // Copiar logo de castilla
    if (!empty($logos_encontrados['castilla'])) {
        $archivo_castilla = $logos_encontrados['castilla'][0];
        if (copiar_logo($archivo_castilla, 'logo-castilla-la-mancha.png')) {
            $copiados++;
        }
    }
    
    if ($copiados > 0) {
        $mensaje = "✅ Se copiaron $copiados logo(s) correctamente al footer";
        $tipo_mensaje = 'success';
    } else {
        $mensaje = "❌ No se pudo copiar ningún logo";
        $tipo_mensaje = 'error';
    }
}

// Procesar copia manual
if ($_POST && isset($_POST['copiar_manual'])) {
    $archivo_origen = $_POST['archivo_seleccionado'];
    $tipo_logo = $_POST['tipo_logo'];
    
    $nombre_destino = ($tipo_logo === 'ministerio') ? 
        'logo-ministerio-educacion.png' : 
        'logo-castilla-la-mancha.png';
    
    if (file_exists($archivo_origen) && copiar_logo($archivo_origen, $nombre_destino)) {
        $mensaje = "✅ Logo copiado correctamente";
        $tipo_mensaje = 'success';
    } else {
        $mensaje = "❌ Error al copiar el logo";
        $tipo_mensaje = 'error';
    }
}

// Verificar logos ya instalados
$destino_dir = get_template_directory() . '/assets/images/';
$ministerio_instalado = file_exists($destino_dir . 'logo-ministerio-educacion.png');
$castilla_instalado = file_exists($destino_dir . 'logo-castilla-la-mancha.png');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔍 Buscar y Copiar Logos</title>
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
        
        .logo-found {
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid #28a745;
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
        }
        
        .logo-not-found {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid #dc3545;
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
        }
        
        .file-list {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
            font-family: monospace;
            font-size: 12px;
            max-height: 150px;
            overflow-y: auto;
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
        
        .action-button.danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }
        
        .status-indicator {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
        }
        
        .status-installed {
            background: rgba(40, 167, 69, 0.3);
            color: #51cf66;
        }
        
        .status-missing {
            background: rgba(220, 53, 69, 0.3);
            color: #ff6b6b;
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
        
        select {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.9);
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="big-icon">🔍</div>
        <h1>Buscar y Copiar Logos Oficiales</h1>
        <p style="text-align: center;">Encuentra automáticamente los logos y cópialos al footer</p>
        
        <?php if ($mensaje): ?>
            <div class="alert <?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <div class="section">
            <h3>📊 Estado Actual</h3>
            <p><strong>🏛️ Logo Ministerio:</strong> 
                <span class="status-indicator <?php echo $ministerio_instalado ? 'status-installed' : 'status-missing'; ?>">
                    <?php echo $ministerio_instalado ? '✅ Instalado' : '❌ Falta'; ?>
                </span>
            </p>
            <p><strong>🏛️ Logo Castilla-La Mancha:</strong> 
                <span class="status-indicator <?php echo $castilla_instalado ? 'status-installed' : 'status-missing'; ?>">
                    <?php echo $castilla_instalado ? '✅ Instalado' : '❌ Falta'; ?>
                </span>
            </p>
        </div>
        
        <div class="section">
            <h3>🔍 Resultados de Búsqueda</h3>
            
            <!-- Logo Ministerio -->
            <div class="<?php echo !empty($logos_encontrados['ministerio']) ? 'logo-found' : 'logo-not-found'; ?>">
                <h4>🏛️ Logo del Ministerio de Educación</h4>
                <?php if (!empty($logos_encontrados['ministerio'])): ?>
                    <p>✅ Encontrados <?php echo count($logos_encontrados['ministerio']); ?> archivo(s):</p>
                    <div class="file-list">
                        <?php foreach ($logos_encontrados['ministerio'] as $archivo): ?>
                            <div><?php echo esc_html($archivo); ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>❌ No se encontraron archivos del logo del Ministerio</p>
                    <p><small>Buscando: Logotipo_del_Ministerio_de_Educación,_Formación_Profesional_y_Deportes.svg</small></p>
                <?php endif; ?>
            </div>
            
            <!-- Logo Castilla -->
            <div class="<?php echo !empty($logos_encontrados['castilla']) ? 'logo-found' : 'logo-not-found'; ?>">
                <h4>🏛️ Logo de Castilla-La Mancha</h4>
                <?php if (!empty($logos_encontrados['castilla'])): ?>
                    <p>✅ Encontrados <?php echo count($logos_encontrados['castilla']); ?> archivo(s):</p>
                    <div class="file-list">
                        <?php foreach ($logos_encontrados['castilla'] as $archivo): ?>
                            <div><?php echo esc_html($archivo); ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>❌ No se encontraron archivos del logo de Castilla-La Mancha</p>
                    <p><small>Buscando: logonuevoazul_0, castilla*.png, etc.</small></p>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if (!empty($logos_encontrados['ministerio']) || !empty($logos_encontrados['castilla'])): ?>
            <div class="section">
                <h3>🚀 Copiar Logos Automáticamente</h3>
                <p>Se copiarán los primeros archivos encontrados al footer:</p>
                <ul>
                    <?php if (!empty($logos_encontrados['ministerio'])): ?>
                        <li><strong>Ministerio:</strong> <?php echo basename($logos_encontrados['ministerio'][0]); ?></li>
                    <?php endif; ?>
                    <?php if (!empty($logos_encontrados['castilla'])): ?>
                        <li><strong>Castilla-La Mancha:</strong> <?php echo basename($logos_encontrados['castilla'][0]); ?></li>
                    <?php endif; ?>
                </ul>
                
                <form method="post" style="text-align: center;">
                    <button type="submit" name="copiar_automatico" class="action-button primary">
                        🚀 Copiar Logos al Footer Automáticamente
                    </button>
                </form>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($logos_encontrados['ministerio']) || !empty($logos_encontrados['castilla'])): ?>
            <div class="section">
                <h3>✋ Copia Manual</h3>
                <p>Si quieres elegir un archivo específico:</p>
                
                <form method="post">
                    <select name="archivo_seleccionado" required>
                        <option value="">-- Selecciona un archivo --</option>
                        <?php foreach ($logos_encontrados as $tipo => $archivos): ?>
                            <?php foreach ($archivos as $archivo): ?>
                                <option value="<?php echo esc_attr($archivo); ?>">
                                    <?php echo ucfirst($tipo); ?>: <?php echo basename($archivo); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </select>
                    
                    <select name="tipo_logo" required>
                        <option value="">-- ¿Para qué logo? --</option>
                        <option value="ministerio">Logo del Ministerio</option>
                        <option value="castilla">Logo de Castilla-La Mancha</option>
                    </select>
                    
                    <div style="text-align: center; margin-top: 15px;">
                        <button type="submit" name="copiar_manual" class="action-button">
                            📋 Copiar Archivo Seleccionado
                        </button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
        
        <div class="section">
            <h3>ℹ️ Información</h3>
            <p><strong>¿Qué hace esta herramienta?</strong></p>
            <ul>
                <li>Busca automáticamente los logos en todo el servidor</li>
                <li>Los copia al directorio correcto del tema</li>
                <li>Los renombra para que funcionen en el footer</li>
                <li>Soporta formatos PNG, JPG y SVG</li>
            </ul>
            
            <p><strong>Archivos que busca:</strong></p>
            <ul>
                <li><code>Logotipo_del_Ministerio_de_Educación,_Formación_Profesional_y_Deportes.svg</code></li>
                <li><code>logonuevoazul_0</code> (cualquier extensión)</li>
                <li>Cualquier archivo con "ministerio", "castilla", "mancha" en el nombre</li>
            </ul>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="/" class="action-button">🏠 Ver Sitio</a>
            <a href="/subir-logos-oficiales.php" class="action-button">📤 Subir Manualmente</a>
        </div>
        
        <div style="text-align: center; margin-top: 20px; color: rgba(255,255,255,0.7); font-size: 14px;">
            💡 Una vez copiados, los logos aparecerán automáticamente en el footer
        </div>
    </div>
</body>
</html>
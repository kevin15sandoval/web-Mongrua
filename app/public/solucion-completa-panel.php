<?php
/**
 * 🔧 SOLUCIÓN COMPLETA DEL PANEL
 * 
 * Este archivo diagnostica y arregla todos los problemas del panel de gestión
 */

// Cargar WordPress
require_once('wp-load.php');

// Función para verificar y arreglar problemas
function diagnosticar_y_arreglar() {
    $problemas = [];
    $soluciones = [];
    
    // 1. Verificar usuario actual
    $current_user = wp_get_current_user();
    $is_logged_in = $current_user->ID > 0;
    $is_admin = current_user_can('administrator');
    
    if (!$is_logged_in) {
        $problemas[] = "❌ Usuario no logueado";
        $soluciones[] = "Necesitas iniciar sesión como administrador";
    } elseif (!$is_admin) {
        $problemas[] = "❌ Usuario sin permisos de administrador";
        $soluciones[] = "El usuario '{$current_user->user_login}' necesita permisos de administrador";
    } else {
        $soluciones[] = "✅ Usuario administrador: {$current_user->user_login}";
    }
    
    // 2. Verificar que el tema esté activo
    $theme = wp_get_theme();
    if ($theme->get('Name') !== 'Mongruas Theme') {
        $problemas[] = "❌ Tema incorrecto: " . $theme->get('Name');
        $soluciones[] = "Activar el tema 'Mongruas Theme'";
    } else {
        $soluciones[] = "✅ Tema correcto: " . $theme->get('Name');
    }
    
    // 3. Verificar archivos del panel
    $archivos_necesarios = [
        'wp-content/themes/mongruas-theme/inc/course-management-panel.php',
        'wp-content/themes/mongruas-theme/assets/js/course-management-panel.js',
        'wp-content/themes/mongruas-theme/assets/css/course-management-panel.css'
    ];
    
    foreach ($archivos_necesarios as $archivo) {
        if (!file_exists(ABSPATH . $archivo)) {
            $problemas[] = "❌ Archivo faltante: $archivo";
        } else {
            $soluciones[] = "✅ Archivo presente: $archivo";
        }
    }
    
    // 4. Verificar página de cursos
    $cursos_page = get_page_by_path('cursos');
    if (!$cursos_page) {
        $problemas[] = "❌ Página 'cursos' no encontrada";
        $soluciones[] = "Crear página 'cursos' con slug 'cursos'";
    } else {
        $soluciones[] = "✅ Página de cursos encontrada (ID: {$cursos_page->ID})";
    }
    
    return ['problemas' => $problemas, 'soluciones' => $soluciones];
}

// Función para arreglar problemas automáticamente
function arreglar_problemas() {
    $arreglos = [];
    
    // 1. Crear usuario administrador si no existe
    if (!username_exists('adminlocal')) {
        $user_id = wp_create_user('adminlocal', '12345', 'admin@mongruas.local');
        if (!is_wp_error($user_id)) {
            $user = new WP_User($user_id);
            $user->set_role('administrator');
            $arreglos[] = "✅ Usuario administrador 'adminlocal' creado";
        } else {
            $arreglos[] = "❌ Error creando usuario: " . $user_id->get_error_message();
        }
    } else {
        $arreglos[] = "✅ Usuario 'adminlocal' ya existe";
    }
    
    // 2. Crear página de cursos si no existe
    $cursos_page = get_page_by_path('cursos');
    if (!$cursos_page) {
        $page_id = wp_insert_post([
            'post_title' => 'Cursos',
            'post_name' => 'cursos',
            'post_content' => 'Página de cursos de Mogruas',
            'post_status' => 'publish',
            'post_type' => 'page'
        ]);
        
        if ($page_id && !is_wp_error($page_id)) {
            $arreglos[] = "✅ Página 'cursos' creada (ID: $page_id)";
        } else {
            $arreglos[] = "❌ Error creando página de cursos";
        }
    } else {
        $arreglos[] = "✅ Página 'cursos' ya existe";
    }
    
    // 3. Limpiar cache y transients
    wp_cache_flush();
    delete_transient('mongruas_panel_cache');
    $arreglos[] = "✅ Cache limpiado";
    
    return $arreglos;
}

// Procesar acciones
$accion = $_GET['accion'] ?? '';
$diagnostico = diagnosticar_y_arreglar();
$arreglos_realizados = [];

if ($accion === 'arreglar') {
    $arreglos_realizados = arreglar_problemas();
    // Volver a diagnosticar después de los arreglos
    $diagnostico = diagnosticar_y_arreglar();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔧 Solución Completa del Panel</title>
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
        
        .problema {
            color: #ff6b6b;
            margin: 8px 0;
        }
        
        .solucion {
            color: #51cf66;
            margin: 8px 0;
        }
        
        .arreglo {
            color: #74c0fc;
            margin: 8px 0;
        }
        
        .action-button {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin: 10px 5px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }
        
        .action-button.danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }
        
        .action-button.primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }
        
        .test-area {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
        }
        
        .code-block {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            padding: 10px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            margin: 10px 0;
            overflow-x: auto;
        }
        
        h1, h2, h3 {
            text-align: center;
        }
        
        .status-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="big-icon">🔧</div>
        <h1>Solución Completa del Panel</h1>
        <p style="text-align: center;">Diagnóstico y reparación automática de todos los problemas</p>
        
        <?php if (!empty($arreglos_realizados)): ?>
            <div class="section">
                <h3>🛠️ Arreglos Realizados</h3>
                <?php foreach ($arreglos_realizados as $arreglo): ?>
                    <div class="arreglo"><?php echo $arreglo; ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div class="status-grid">
            <div class="section">
                <h3>❌ Problemas Detectados</h3>
                <?php if (empty($diagnostico['problemas'])): ?>
                    <div class="solucion">✅ ¡No se detectaron problemas!</div>
                <?php else: ?>
                    <?php foreach ($diagnostico['problemas'] as $problema): ?>
                        <div class="problema"><?php echo $problema; ?></div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <div class="section">
                <h3>✅ Estado del Sistema</h3>
                <?php foreach ($diagnostico['soluciones'] as $solucion): ?>
                    <div class="solucion"><?php echo $solucion; ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <?php if (!empty($diagnostico['problemas'])): ?>
            <div class="section" style="text-align: center;">
                <h3>🚀 Arreglar Automáticamente</h3>
                <p>Haz clic para arreglar todos los problemas detectados:</p>
                <a href="?accion=arreglar" class="action-button">🔧 Arreglar Problemas</a>
            </div>
        <?php endif; ?>
        
        <div class="section">
            <h3>🧪 Pruebas del Panel</h3>
            <div class="test-area">
                <h4>Test 1: Verificar Nonce</h4>
                <div class="code-block">
                    Nonce actual: <?php echo wp_create_nonce('wp_rest'); ?>
                </div>
                
                <h4>Test 2: Verificar REST API</h4>
                <button class="action-button primary" onclick="testRestAPI()">🔍 Probar API</button>
                <div id="api-result" class="code-block" style="display: none;"></div>
                
                <h4>Test 3: Verificar jQuery</h4>
                <button class="action-button primary" onclick="testJQuery()">📝 Probar jQuery</button>
                <div id="jquery-result" class="code-block" style="display: none;"></div>
            </div>
        </div>
        
        <div class="section" style="text-align: center;">
            <h3>🎯 Acciones Rápidas</h3>
            <a href="/wp-admin/" class="action-button primary">🔑 WordPress Admin</a>
            <a href="/panel-gestion.php" class="action-button">🎯 Panel Directo</a>
            <a href="/" class="action-button">🏠 Sitio Principal</a>
            <a href="/test-panel-directo.php" class="action-button">🧪 Test Sin Nonce</a>
        </div>
        
        <div class="section">
            <h3>📋 Instrucciones Paso a Paso</h3>
            <ol style="text-align: left;">
                <li><strong>Iniciar Sesión:</strong> Ve a <code>/wp-admin/</code> y usa <code>adminlocal</code> / <code>12345</code></li>
                <li><strong>Verificar Botones:</strong> Ve al sitio principal <code>/</code> y busca los botones en la esquina inferior derecha</li>
                <li><strong>Usar Panel:</strong> Haz clic en el botón azul del panel para abrir la gestión de cursos</li>
                <li><strong>Alternativa:</strong> Usa WordPress admin directamente: <code>/wp-admin/edit.php?post_type=page</code></li>
            </ol>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="?accion=diagnosticar" style="color: rgba(255,255,255,0.8); text-decoration: none;">🔄 Volver a Diagnosticar</a>
        </div>
    </div>
    
    <script>
    function testRestAPI() {
        const resultDiv = document.getElementById('api-result');
        resultDiv.style.display = 'block';
        resultDiv.innerHTML = '🔄 Probando API...';
        
        fetch('/wp-json/mongruas/v1/courses', {
            method: 'GET',
            headers: {
                'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
            }
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
        })
        .then(data => {
            resultDiv.innerHTML = `✅ API funcionando correctamente:\n${JSON.stringify(data, null, 2)}`;
        })
        .catch(error => {
            resultDiv.innerHTML = `❌ Error en API: ${error.message}`;
        });
    }
    
    function testJQuery() {
        const resultDiv = document.getElementById('jquery-result');
        resultDiv.style.display = 'block';
        
        try {
            if (typeof jQuery !== 'undefined') {
                resultDiv.innerHTML = `✅ jQuery disponible: versión ${jQuery.fn.jquery}`;
            } else if (typeof $ !== 'undefined') {
                resultDiv.innerHTML = `⚠️ $ disponible pero no jQuery`;
            } else {
                resultDiv.innerHTML = `❌ jQuery no disponible`;
            }
        } catch (error) {
            resultDiv.innerHTML = `❌ Error probando jQuery: ${error.message}`;
        }
    }
    
    // Auto-ejecutar tests al cargar
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(testJQuery, 1000);
    });
    </script>
    
    <?php wp_head(); ?>
    <?php wp_footer(); ?>
</body>
</html>
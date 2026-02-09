<?php
/**
 * 🔍 VERIFICAR USUARIOS DE WORDPRESS
 * 
 * Este archivo verifica qué usuarios existen y crea uno nuevo si es necesario
 */

// Cargar WordPress
require_once('wp-load.php');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔍 Verificar Usuarios WordPress</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #007cba 0%, #00a0d2 100%);
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
        
        .user-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            margin: 15px 0;
            border-left: 4px solid #00ff88;
        }
        
        .admin-user {
            border-left-color: #ff6b6b;
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
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .action-button.danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }
        
        .status-box {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .success { color: #00ff88; }
        .error { color: #ff6b6b; }
        .warning { color: #ffc107; }
        
        pre {
            background: rgba(0, 0, 0, 0.3);
            padding: 15px;
            border-radius: 8px;
            overflow-x: auto;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Verificar Usuarios WordPress</h1>
        <p>Vamos a ver qué usuarios existen y crear uno nuevo si es necesario</p>
        
        <?php
        // Obtener todos los usuarios
        $users = get_users();
        $admin_users = get_users(array('role' => 'administrator'));
        
        echo '<div class="status-box">';
        echo '<h3>📊 Resumen:</h3>';
        echo '<p><strong>Total de usuarios:</strong> ' . count($users) . '</p>';
        echo '<p><strong>Administradores:</strong> ' . count($admin_users) . '</p>';
        echo '</div>';
        
        if (empty($users)) {
            echo '<div class="status-box error">';
            echo '<h3>⚠️ ¡No hay usuarios!</h3>';
            echo '<p>La base de datos no tiene usuarios. Esto es muy raro.</p>';
            echo '</div>';
        } else {
            echo '<h3>👥 Usuarios Existentes:</h3>';
            
            foreach ($users as $user) {
                $is_admin = user_can($user, 'administrator');
                $class = $is_admin ? 'user-card admin-user' : 'user-card';
                
                echo '<div class="' . $class . '">';
                echo '<h4>' . ($is_admin ? '👑 ' : '👤 ') . esc_html($user->user_login) . '</h4>';
                echo '<p><strong>Email:</strong> ' . esc_html($user->user_email) . '</p>';
                echo '<p><strong>Nombre:</strong> ' . esc_html($user->display_name) . '</p>';
                echo '<p><strong>Rol:</strong> ' . ($is_admin ? '<span class="error">Administrador</span>' : '<span class="warning">Usuario normal</span>') . '</p>';
                echo '<p><strong>ID:</strong> ' . $user->ID . '</p>';
                echo '</div>';
            }
        }
        
        // Verificar si existe adminlocal
        $adminlocal_exists = username_exists('adminlocal');
        if ($adminlocal_exists) {
            echo '<div class="status-box success">';
            echo '<h3>✅ Usuario "adminlocal" existe</h3>';
            echo '<p>El usuario adminlocal existe con ID: ' . $adminlocal_exists . '</p>';
            
            // Verificar si es admin
            $user = get_user_by('login', 'adminlocal');
            if ($user && user_can($user, 'administrator')) {
                echo '<p class="success">✅ Y tiene permisos de administrador</p>';
                echo '<p><strong>Intenta estas credenciales:</strong></p>';
                echo '<pre>Usuario: adminlocal
Contraseña: 12345</pre>';
                echo '<p>Si no funciona, puede que la contraseña sea diferente. Usa el botón de abajo para resetearla.</p>';
            } else {
                echo '<p class="error">❌ Pero NO tiene permisos de administrador</p>';
            }
            echo '</div>';
        } else {
            echo '<div class="status-box warning">';
            echo '<h3>⚠️ Usuario "adminlocal" NO existe</h3>';
            echo '<p>Necesitamos crear el usuario adminlocal.</p>';
            echo '</div>';
        }
        ?>
        
        <div class="status-box">
            <h3>🔧 Acciones Disponibles:</h3>
            
            <?php if ($adminlocal_exists): ?>
                <button class="action-button" onclick="resetPassword()">🔑 Resetear Contraseña de adminlocal</button>
            <?php else: ?>
                <button class="action-button" onclick="createAdmin()">👑 Crear Usuario adminlocal</button>
            <?php endif; ?>
            
            <button class="action-button" onclick="testLogin()">🧪 Probar Login</button>
            <a href="/wp-admin/" class="action-button">🚪 Ir a WordPress Admin</a>
        </div>
        
        <div id="result" class="status-box" style="display: none;"></div>
        
        <div style="margin-top: 30px; text-align: center;">
            <a href="/activar-boton-ahora.php" style="color: rgba(255,255,255,0.8);">← Volver a Activar Botón</a> |
            <a href="/" style="color: rgba(255,255,255,0.8);">🏠 Sitio Principal</a>
        </div>
    </div>
    
    <script>
    function createAdmin() {
        if (confirm('¿Crear usuario adminlocal con contraseña 12345?')) {
            fetch('?action=create_admin', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=create_admin'
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('result').innerHTML = data;
                document.getElementById('result').style.display = 'block';
                setTimeout(() => location.reload(), 2000);
            })
            .catch(error => {
                document.getElementById('result').innerHTML = '<p class="error">Error: ' + error + '</p>';
                document.getElementById('result').style.display = 'block';
            });
        }
    }
    
    function resetPassword() {
        if (confirm('¿Resetear la contraseña de adminlocal a 12345?')) {
            fetch('?action=reset_password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=reset_password'
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('result').innerHTML = data;
                document.getElementById('result').style.display = 'block';
            })
            .catch(error => {
                document.getElementById('result').innerHTML = '<p class="error">Error: ' + error + '</p>';
                document.getElementById('result').style.display = 'block';
            });
        }
    }
    
    function testLogin() {
        const username = prompt('Usuario:', 'adminlocal');
        const password = prompt('Contraseña:', '12345');
        
        if (username && password) {
            fetch('?action=test_login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=test_login&username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('result').innerHTML = data;
                document.getElementById('result').style.display = 'block';
            })
            .catch(error => {
                document.getElementById('result').innerHTML = '<p class="error">Error: ' + error + '</p>';
                document.getElementById('result').style.display = 'block';
            });
        }
    }
    </script>
</body>
</html>

<?php
// Manejar acciones AJAX
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'create_admin':
            $username = 'adminlocal';
            $password = '12345';
            $email = 'admin@mongruas.local';
            
            if (username_exists($username)) {
                echo '<p class="warning">⚠️ El usuario ya existe</p>';
            } else {
                $user_id = wp_create_user($username, $password, $email);
                
                if (is_wp_error($user_id)) {
                    echo '<p class="error">❌ Error al crear usuario: ' . $user_id->get_error_message() . '</p>';
                } else {
                    // Hacer administrador
                    $user = new WP_User($user_id);
                    $user->set_role('administrator');
                    
                    echo '<p class="success">✅ Usuario adminlocal creado correctamente</p>';
                    echo '<p>Credenciales:</p>';
                    echo '<pre>Usuario: adminlocal
Contraseña: 12345</pre>';
                }
            }
            break;
            
        case 'reset_password':
            $user = get_user_by('login', 'adminlocal');
            if ($user) {
                wp_set_password('12345', $user->ID);
                echo '<p class="success">✅ Contraseña reseteada a: 12345</p>';
                echo '<p>Ahora puedes usar:</p>';
                echo '<pre>Usuario: adminlocal
Contraseña: 12345</pre>';
            } else {
                echo '<p class="error">❌ Usuario adminlocal no encontrado</p>';
            }
            break;
            
        case 'test_login':
            $username = sanitize_user($_POST['username']);
            $password = $_POST['password'];
            
            $user = wp_authenticate($username, $password);
            
            if (is_wp_error($user)) {
                echo '<p class="error">❌ Login fallido: ' . $user->get_error_message() . '</p>';
            } else {
                $is_admin = user_can($user, 'administrator');
                echo '<p class="success">✅ Login exitoso para: ' . $user->user_login . '</p>';
                echo '<p>Es administrador: ' . ($is_admin ? '<span class="success">SÍ</span>' : '<span class="error">NO</span>') . '</p>';
                
                if ($is_admin) {
                    echo '<p class="success">🎉 ¡Perfecto! Puedes usar estas credenciales para acceder al panel.</p>';
                }
            }
            break;
    }
    exit;
}
?>
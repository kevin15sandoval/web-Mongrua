<?php
/**
 * Diagnóstico del Botón de Administración
 * Verifica por qué no aparece el botón
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🔍 Diagnóstico del Botón de Administración</h1>";

echo "<div style='background: #f0f8ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";

// 1. Verificar si el usuario está logueado
echo "<h2>1. Estado del Usuario</h2>";
if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
    echo "✅ <strong>Usuario logueado:</strong> " . $current_user->user_login . "<br>";
    echo "📧 <strong>Email:</strong> " . $current_user->user_email . "<br>";
    echo "🏷️ <strong>Roles:</strong> " . implode(', ', $current_user->roles) . "<br>";
} else {
    echo "❌ <strong>No hay usuario logueado</strong><br>";
}

// 2. Verificar capacidades de administrador
echo "<h2>2. Capacidades de Administrador</h2>";
if (current_user_can('administrator')) {
    echo "✅ <strong>El usuario TIENE permisos de administrador</strong><br>";
} else {
    echo "❌ <strong>El usuario NO tiene permisos de administrador</strong><br>";
}

// 3. Verificar otras capacidades importantes
echo "<h2>3. Otras Capacidades</h2>";
$capabilities = ['manage_options', 'edit_posts', 'edit_pages', 'edit_users'];
foreach ($capabilities as $cap) {
    if (current_user_can($cap)) {
        echo "✅ <strong>$cap:</strong> SÍ<br>";
    } else {
        echo "❌ <strong>$cap:</strong> NO<br>";
    }
}

// 4. Mostrar información de la página actual
echo "<h2>4. Información de la Página</h2>";
echo "🌐 <strong>URL actual:</strong> " . $_SERVER['REQUEST_URI'] . "<br>";
echo "📄 <strong>Página:</strong> " . (is_page() ? get_the_title() : 'No es una página') . "<br>";

echo "</div>";

// 5. Forzar mostrar el botón para pruebas
echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>5. Prueba del Botón (Forzado)</h2>";
echo "<p>Aquí está el botón tal como debería aparecer:</p>";
?>

<section class="admin-access-section" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); padding: 30px 0; border-radius: 10px;">
    <div class="container" style="max-width: 500px; margin: 0 auto;">
        <div class="admin-access-card" style="background: rgba(255,255,255,0.95); border-radius: 20px; padding: 40px; text-align: center; box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);">
            <div class="admin-icon" style="font-size: 60px; margin-bottom: 20px;">🔐</div>
            <h3 style="font-size: 28px; font-weight: 800; color: #dc3545; margin-bottom: 10px;">Panel de Administración</h3>
            <p style="font-size: 16px; color: #6c757d; margin-bottom: 25px;">Gestionar cursos y contenido del sitio web</p>
            <button class="btn-admin-access" onclick="alert('¡Botón funcionando!')" style="background: linear-gradient(135deg, #dc3545, #c82333); color: white; padding: 16px 32px; border: none; border-radius: 12px; font-size: 18px; font-weight: 700; cursor: pointer;">
                Acceder al Panel de Gestión
            </button>
        </div>
    </div>
</section>

<?php
echo "</div>";

// 6. Enlaces útiles
echo "<div style='background: #d1ecf1; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>6. Enlaces Útiles</h2>";
echo "<p><a href='" . wp_login_url() . "' style='color: #0066cc;'>🔑 Ir al Login de WordPress</a></p>";
echo "<p><a href='" . admin_url() . "' style='color: #0066cc;'>⚙️ Ir al Panel de WordPress</a></p>";
echo "<p><a href='" . home_url('/anuncios') . "' style='color: #0066cc;'>📚 Ir a la Página de Cursos</a></p>";
echo "<p><a href='" . home_url('/gestionar-proximos-cursos.php') . "' style='color: #0066cc;'>🎓 Ir Directamente al Gestor de Cursos</a></p>";
echo "</div>";

// 7. Instrucciones
echo "<div style='background: #f8d7da; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>7. ¿Cómo solucionarlo?</h2>";
echo "<p><strong>Si no estás logueado:</strong></p>";
echo "<ol>";
echo "<li>Ve al <a href='" . wp_login_url() . "'>login de WordPress</a></li>";
echo "<li>Inicia sesión con tu usuario administrador</li>";
echo "<li>Vuelve a la <a href='" . home_url('/anuncios') . "'>página de cursos</a></li>";
echo "</ol>";
echo "<p><strong>Si no tienes permisos de administrador:</strong></p>";
echo "<ol>";
echo "<li>Contacta con el administrador del sitio</li>";
echo "<li>O usa directamente: <a href='" . home_url('/gestionar-proximos-cursos.php') . "'>Gestor de Cursos</a></li>";
echo "</ol>";
echo "</div>";
?>
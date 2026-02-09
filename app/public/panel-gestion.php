<?php
/**
 * Panel de Gestión de Cursos - Acceso Directo
 * 
 * Página temporal para acceder al panel mientras solucionamos el botón flotante
 */

// Cargar WordPress
require_once('wp-load.php');

// Solo para administradores
if (!current_user_can('administrator')) {
    wp_redirect('/wp-admin/');
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Gestión - Mongruas</title>
    <?php wp_head(); ?>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .header-panel {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 20px;
            text-align: center;
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .header-panel h1 {
            margin: 0;
            font-size: 2em;
            font-weight: 300;
        }
        
        .header-panel p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }
        
        .access-button {
            background: linear-gradient(135deg, #0066cc, #004d99);
            color: white;
            border: none;
            padding: 20px 40px;
            border-radius: 50px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 8px 25px rgba(0, 102, 204, 0.3);
            transition: all 0.3s ease;
            margin: 20px;
            text-decoration: none;
            display: inline-block;
        }
        
        .access-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0, 102, 204, 0.4);
            background: linear-gradient(135deg, #0052a3, #003d7a);
        }
        
        .access-button:active {
            transform: translateY(-1px);
        }
        
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .action-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .action-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .action-card h3 {
            margin: 0 0 15px 0;
            font-size: 1.5em;
            color: #ffc107;
        }
        
        .action-card p {
            margin: 0 0 20px 0;
            opacity: 0.9;
            line-height: 1.6;
        }
        
        .action-card .icon {
            font-size: 3em;
            margin-bottom: 15px;
            display: block;
        }
        
        .current-courses {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
        }
        
        .course-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .course-card h4 {
            margin: 0 0 10px 0;
            color: #28a745;
            font-size: 1.2em;
        }
        
        .course-card .course-info {
            opacity: 0.9;
            font-size: 0.9em;
            line-height: 1.5;
        }
        
        .empty-course {
            opacity: 0.6;
            border-style: dashed;
        }
        
        .footer-links {
            text-align: center;
            padding: 40px 20px;
            color: white;
        }
        
        .footer-links a {
            color: #ffc107;
            text-decoration: none;
            margin: 0 15px;
            font-weight: 500;
        }
        
        .footer-links a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .quick-actions {
                grid-template-columns: 1fr;
                margin: 20px auto;
            }
            
            .access-button {
                padding: 15px 30px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="header-panel">
        <h1>🎯 Panel de Gestión de Cursos</h1>
        <p>Bienvenido, <strong><?php echo wp_get_current_user()->display_name; ?></strong></p>
        <p>Gestiona tus cursos y comunicaciones de forma sencilla</p>
        
        <button id="open-panel" class="access-button">
            📚 Abrir Panel de Gestión
        </button>
    </div>
    
    <div class="quick-actions">
        <div class="action-card">
            <span class="icon">📚</span>
            <h3>Gestionar Cursos</h3>
            <p>Añade, edita o elimina cursos próximos. Sube imágenes y ve una vista previa en tiempo real de cómo se verán en el sitio web.</p>
        </div>
        
        <div class="action-card">
            <span class="icon">📧</span>
            <h3>Enviar Correos</h3>
            <p>Envía newsletters y comunicaciones a tu lista de contactos. Gestiona suscriptores y crea campañas personalizadas.</p>
        </div>
        
        <div class="action-card">
            <span class="icon">👥</span>
            <h3>Gestionar Contactos</h3>
            <p>Administra tu base de datos de contactos. Ve quién se ha suscrito y gestiona las comunicaciones de forma eficiente.</p>
        </div>
        
        <div class="action-card">
            <span class="icon">📊</span>
            <h3>Ver Estadísticas</h3>
            <p>Revisa el rendimiento de tus cursos y campañas de email. Obtén insights sobre tu audiencia y engagement.</p>
        </div>
    </div>
    
    <div class="current-courses">
        <h2 style="color: white; text-align: center; margin-bottom: 30px;">📋 Cursos Actuales</h2>
        <div class="courses-grid">
            <?php
            // Mostrar cursos actuales
            $page_id = get_option('page_on_front');
            
            for ($i = 1; $i <= 3; $i++) {
                $course_name = get_field("course_{$i}_name", $page_id);
                $course_description = get_field("course_{$i}_description", $page_id);
                $course_date = get_field("course_{$i}_date", $page_id);
                $course_duration = get_field("course_{$i}_duration", $page_id);
                $course_modality = get_field("course_{$i}_modality", $page_id);
                
                echo "<div class='course-card" . (empty($course_name) ? " empty-course" : "") . "'>";
                echo "<h4>Curso $i" . (!empty($course_name) ? ": $course_name" : " (Vacío)") . "</h4>";
                
                if (!empty($course_name)) {
                    echo "<div class='course-info'>";
                    if ($course_description) echo "<p><strong>Descripción:</strong> " . substr($course_description, 0, 100) . "...</p>";
                    if ($course_date) echo "<p><strong>Fecha:</strong> $course_date</p>";
                    if ($course_duration) echo "<p><strong>Duración:</strong> $course_duration</p>";
                    if ($course_modality) echo "<p><strong>Modalidad:</strong> $course_modality</p>";
                    echo "</div>";
                } else {
                    echo "<p style='opacity: 0.6;'>Este slot está disponible para un nuevo curso.</p>";
                }
                
                echo "</div>";
            }
            ?>
        </div>
    </div>
    
    <div class="footer-links">
        <a href="/">← Volver al Sitio</a>
        <a href="/wp-admin/">WordPress Admin</a>
        <a href="/diagnostico-boton-acceso.php">Diagnóstico</a>
    </div>
    
    <?php
    // Cargar el panel completo
    if (class_exists('Mongruas_Course_Management_Panel')) {
        $panel = new Mongruas_Course_Management_Panel();
        if (method_exists($panel, 'render_panel_html')) {
            $panel->render_panel_html();
        }
    }
    ?>
    
    <?php wp_footer(); ?>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const openButton = document.getElementById('open-panel');
        const modal = document.getElementById('mongruas-panel-modal');
        
        if (openButton && modal) {
            openButton.addEventListener('click', function() {
                modal.style.display = 'block';
                document.body.style.overflow = 'hidden';
                
                // Trigger login form if needed
                const loginForm = document.getElementById('mongruas-login-form');
                if (loginForm) {
                    loginForm.style.display = 'block';
                }
            });
            
            console.log('✅ Panel de gestión listo para usar');
        } else {
            console.log('❌ Panel no encontrado, verificando...');
            
            // Mostrar mensaje de error amigable
            openButton.innerHTML = '⚠️ Panel en Configuración';
            openButton.style.background = 'linear-gradient(135deg, #ffc107, #e0a800)';
            openButton.onclick = function() {
                alert('El panel se está configurando. Por favor, usa el WordPress Admin temporalmente.');
                window.location.href = '/wp-admin/';
            };
        }
    });
    </script>
</body>
</html>
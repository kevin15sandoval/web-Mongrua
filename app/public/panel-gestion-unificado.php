<?php
/**
 * Panel de Gestión Unificado - Mongruas Formación
 * Acceso centralizado a todos los sistemas de gestión
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎯 Panel de Gestión - Mongruas Formación</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            width: 100%;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 40px;
            animation: fadeInDown 0.6s ease;
        }

        .header h1 {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 10px;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .header p {
            font-size: 18px;
            opacity: 0.95;
            font-weight: 500;
        }

        .panels-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .panel-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.6s ease;
        }

        .panel-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .panel-card:hover::before {
            transform: scaleX(1);
        }

        .panel-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .panel-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .panel-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .panel-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .panel-icon {
            font-size: 64px;
            margin-bottom: 20px;
            display: block;
            animation: bounce 2s infinite;
        }

        .panel-card:hover .panel-icon {
            animation: pulse 0.6s ease;
        }

        .panel-title {
            font-size: 24px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 12px;
        }

        .panel-description {
            font-size: 15px;
            color: #718096;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .panel-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 14px 32px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .panel-button:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 25px rgba(102, 126, 234, 0.6);
        }

        .panel-card.courses .panel-button {
            background: linear-gradient(135deg, #0066cc, #0052a3);
            box-shadow: 0 4px 15px rgba(0, 102, 204, 0.4);
        }

        .panel-card.courses .panel-button:hover {
            box-shadow: 0 6px 25px rgba(0, 102, 204, 0.6);
        }

        .panel-card.crm .panel-button {
            background: linear-gradient(135deg, #28a745, #20c997);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
        }

        .panel-card.crm .panel-button:hover {
            box-shadow: 0 6px 25px rgba(40, 167, 69, 0.6);
        }

        .panel-card.settings .panel-button {
            background: linear-gradient(135deg, #6c757d, #5a6268);
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.4);
        }

        .panel-card.settings .panel-button:hover {
            box-shadow: 0 6px 25px rgba(108, 117, 125, 0.6);
        }

        .back-button {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 12px 28px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            text-align: center;
            animation: fadeIn 0.8s ease;
        }

        .back-button:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        .footer {
            text-align: center;
            margin-top: 40px;
        }

        .stats-bar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
            animation: fadeIn 0.8s ease;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .stat-number {
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 500;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 32px;
            }

            .header p {
                font-size: 16px;
            }

            .panels-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .panel-card {
                padding: 30px 20px;
            }

            .panel-icon {
                font-size: 48px;
            }

            .panel-title {
                font-size: 20px;
            }

            .stat-number {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎯 Panel de Gestión</h1>
            <p>Acceso centralizado a todos los sistemas de administración</p>
        </div>

        <?php
        // Obtener estadísticas
        $courses = get_option('mongruas_courses', []);
        $total_courses = count($courses);
        
        global $wpdb;
        $clientes_table = $wpdb->prefix . 'mongruas_clientes';
        $campanas_table = $wpdb->prefix . 'mongruas_campanas';
        
        $total_clientes = 0;
        $total_campanas = 0;
        
        if ($wpdb->get_var("SHOW TABLES LIKE '$clientes_table'") == $clientes_table) {
            $total_clientes = $wpdb->get_var("SELECT COUNT(*) FROM $clientes_table WHERE estado = 'activo'");
        }
        
        if ($wpdb->get_var("SHOW TABLES LIKE '$campanas_table'") == $campanas_table) {
            $total_campanas = $wpdb->get_var("SELECT COUNT(*) FROM $campanas_table");
        }
        ?>

        <div class="stats-bar">
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_courses; ?></div>
                <div class="stat-label">Cursos Activos</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_clientes; ?></div>
                <div class="stat-label">Clientes Registrados</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_campanas; ?></div>
                <div class="stat-label">Campañas Creadas</div>
            </div>
        </div>

        <div class="panels-grid">
            <!-- Panel de Gestión de Cursos -->
            <div class="panel-card courses">
                <span class="panel-icon">🎓</span>
                <h2 class="panel-title">Gestión de Cursos</h2>
                <p class="panel-description">
                    Administra los cursos de formación: agregar, editar, eliminar y gestionar toda la información de los cursos disponibles.
                </p>
                <a href="gestionar-cursos-dinamico.php" class="panel-button">
                    Acceder al Panel de Cursos
                </a>
            </div>

            <!-- Panel CRM y Mailing -->
            <div class="panel-card crm">
                <span class="panel-icon">📧</span>
                <h2 class="panel-title">CRM y Mailing</h2>
                <p class="panel-description">
                    Gestiona clientes, crea campañas de email marketing, envía correos masivos y analiza estadísticas de tus campañas.
                </p>
                <a href="crm-mailing-completo.php" class="panel-button">
                    Acceder al CRM
                </a>
            </div>

            <!-- Panel de Configuración -->
            <div class="panel-card settings">
                <span class="panel-icon">⚙️</span>
                <h2 class="panel-title">Configuración</h2>
                <p class="panel-description">
                    Accede a la configuración general del sitio, gestiona usuarios y personaliza las opciones del sistema.
                </p>
                <a href="<?php echo admin_url(); ?>" class="panel-button">
                    Ir a WordPress Admin
                </a>
            </div>
        </div>

        <div class="footer">
            <a href="<?php echo home_url('/'); ?>" class="back-button">
                ← Volver a la Página Principal
            </a>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎛️ Centro de Control CRM</title>
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
            padding: 40px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 48px;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 20px;
            opacity: 0.9;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
        }

        .card-icon {
            font-size: 64px;
            text-align: center;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 24px;
            color: #2d3748;
            margin-bottom: 15px;
            text-align: center;
            font-weight: 700;
        }

        .card-desc {
            color: #718096;
            text-align: center;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .btn {
            display: block;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
            margin-bottom: 10px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffc107, #ff9800);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }

        .btn-info {
            background: linear-gradient(135deg, #17a2b8, #138496);
        }

        .stats {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }

        .stats h2 {
            color: #2d3748;
            margin-bottom: 20px;
            text-align: center;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .stat-item {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
        }

        .stat-number {
            font-size: 36px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #718096;
            font-size: 14px;
        }

        .workflow {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .workflow h2 {
            color: #2d3748;
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
        }

        .step {
            display: flex;
            align-items: start;
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 2px solid #f0f0f0;
        }

        .step:last-child {
            border-bottom: none;
        }

        .step-number {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 20px;
            margin-right: 20px;
            flex-shrink: 0;
        }

        .step-content h4 {
            color: #2d3748;
            margin-bottom: 8px;
            font-size: 18px;
        }

        .step-content p {
            color: #718096;
            line-height: 1.6;
        }

        .step-content a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
        }

        .step-content a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎛️ Centro de Control CRM</h1>
            <p>Gestiona tus clientes de forma profesional</p>
        </div>

        <?php
        // Cargar WordPress para obtener estadísticas
        require_once('wp-config.php');
        require_once('wp-load.php');
        global $wpdb;
        $table_name = $wpdb->prefix . 'mongruas_clientes';
        
        $total_clientes = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
        $total_activos = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE estado = 'activo'");
        $total_listas = $wpdb->get_var("SELECT COUNT(DISTINCT lista) FROM $table_name WHERE lista != ''");
        $total_sectores = $wpdb->get_var("SELECT COUNT(DISTINCT sector) FROM $table_name WHERE sector != ''");
        ?>

        <div class="stats">
            <h2>📊 Estadísticas del CRM</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number"><?php echo number_format($total_clientes); ?></div>
                    <div class="stat-label">Total Clientes</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?php echo number_format($total_activos); ?></div>
                    <div class="stat-label">Clientes Activos</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?php echo number_format($total_listas); ?></div>
                    <div class="stat-label">Listas</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?php echo number_format($total_sectores); ?></div>
                    <div class="stat-label">Sectores</div>
                </div>
            </div>
        </div>

        <div class="grid">
            <div class="card">
                <div class="card-icon">📊</div>
                <div class="card-title">Ver CRM</div>
                <div class="card-desc">Accede al CRM completo con todos tus clientes, filtros y búsqueda avanzada</div>
                <a href="crm-mailing-completo.php" class="btn">📊 Abrir CRM</a>
            </div>

            <div class="card">
                <div class="card-icon">📥</div>
                <div class="card-title">Importar Excel</div>
                <div class="card-desc">Sube archivos Excel con la estructura unificada para importar clientes</div>
                <a href="importar-todos-excel-crm.php" class="btn btn-success">📥 Importar Ahora</a>
            </div>

            <div class="card">
                <div class="card-icon">📋</div>
                <div class="card-title">Plantilla Excel</div>
                <div class="card-desc">Descarga la plantilla con la estructura correcta y ejemplos</div>
                <a href="PLANTILLA-EXCEL-VISUAL.php" class="btn btn-info">📋 Ver Plantilla</a>
                <a href="DESCARGAR-PLANTILLA-EXCEL.php" class="btn btn-info">⬇️ Descargar .xlsx</a>
            </div>

            <div class="card">
                <div class="card-icon">🔧</div>
                <div class="card-title">Herramientas</div>
                <div class="card-desc">Limpia datos, resetea la base de datos o importa automáticamente</div>
                <a href="LIMPIAR-TODO-CRM-YA.php" class="btn btn-warning">🧹 Limpiar Datos</a>
                <a href="IMPORTAR-EXCEL-AUTOMATICO.php" class="btn btn-success">🚀 Importar Auto</a>
            </div>

            <div class="card">
                <div class="card-icon">📧</div>
                <div class="card-title">Plantillas Email</div>
                <div class="card-desc">Gestiona plantillas de email para campañas de marketing</div>
                <a href="plantillas-email-crm.php" class="btn">📧 Ver Plantillas</a>
            </div>

            <div class="card">
                <div class="card-icon">🔍</div>
                <div class="card-title">Diagnóstico</div>
                <div class="card-desc">Verifica la estructura de tus archivos Excel antes de importar</div>
                <a href="DIAGNOSTICO-EXCEL.php" class="btn btn-info">🔍 Diagnosticar</a>
            </div>
        </div>

        <div class="workflow">
            <h2>🚀 Flujo de Trabajo Recomendado</h2>
            
            <div class="step">
                <div class="step-number">1</div>
                <div class="step-content">
                    <h4>Descargar Plantilla</h4>
                    <p>Ve a <a href="PLANTILLA-EXCEL-VISUAL.php">Plantilla Excel</a> y descarga el archivo .xlsx con la estructura correcta</p>
                </div>
            </div>

            <div class="step">
                <div class="step-number">2</div>
                <div class="step-content">
                    <h4>Preparar Datos</h4>
                    <p>Abre la plantilla en Excel y rellena con tus clientes. Estructura: <strong>SECTOR | EMPRESA | CONTACTO | TELÉFONO | CORREO | POBLACIÓN | PROVINCIA | OBSERVACIONES</strong></p>
                </div>
            </div>

            <div class="step">
                <div class="step-number">3</div>
                <div class="step-content">
                    <h4>Verificar (Opcional)</h4>
                    <p>Usa el <a href="DIAGNOSTICO-EXCEL.php">Diagnóstico</a> para verificar que tu Excel tiene la estructura correcta</p>
                </div>
            </div>

            <div class="step">
                <div class="step-number">4</div>
                <div class="step-content">
                    <h4>Importar</h4>
                    <p>Ve a <a href="importar-todos-excel-crm.php">Importar Excel</a> y sube tu archivo. El sistema creará automáticamente los IDs y validará los datos</p>
                </div>
            </div>

            <div class="step">
                <div class="step-number">5</div>
                <div class="step-content">
                    <h4>Gestionar</h4>
                    <p>Accede al <a href="crm-mailing-completo.php">CRM</a> para ver, filtrar, buscar y gestionar todos tus clientes</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

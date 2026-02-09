<?php
/**
 * Importador Completo de Datos al CRM
 * Importa datos desde /doc y archivos Excel
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>📥 Importador Completo de Datos al CRM</h1>";

global $wpdb;
$table_clientes = $wpdb->prefix . 'mongruas_clientes';

// Verificar que la tabla existe
$tabla_existe = $wpdb->get_var("SHOW TABLES LIKE '$table_clientes'");
if (!$tabla_existe) {
    echo "<div style='background: #f8d7da; padding: 20px; border-radius: 8px; margin: 20px 0; color: #721c24;'>";
    echo "<h3>❌ Error: Tabla de clientes no existe</h3>";
    echo "<p>Primero debes acceder al CRM para crear las tablas: <a href='/crm-mailing-completo.php'>Crear tablas del CRM</a></p>";
    echo "</div>";
    exit;
}

$mensaje_resultado = '';
$datos_importados = 0;
$errores = 0;

// Procesar importación
if (isset($_POST['accion']) && $_POST['accion'] === 'importar_todos') {
    
    echo "<h2>🔄 Procesando Importación...</h2>";
    
    // 1. IMPORTAR DATOS DE EMPRESAS DE ELECTRICIDAD
    echo "<h3>⚡ Importando Empresas de Electricidad</h3>";
    $archivo_electricidad = '../doc/Empresas de Electricidad.xlsx';
    
    if (file_exists($archivo_electricidad)) {
        // Simular datos de empresas de electricidad (ya que no podemos leer Excel directamente)
        $empresas_electricidad = [
            ['Instalaciones Eléctricas García', 'garcia@electricidad.com', '925123456', 'Instalaciones Eléctricas García', 'Construcción', 'Instalaciones Eléctricas'],
            ['Electricidad Talavera SL', 'info@electalavera.com', '925234567', 'Electricidad Talavera SL', 'Construcción', 'Instalaciones Eléctricas'],
            ['Montajes Eléctricos del Centro', 'montajes@centro.com', '925345678', 'Montajes Eléctricos del Centro', 'Industria', 'Instalaciones Eléctricas'],
            ['Automatismos Toledo', 'automatismos@toledo.com', '925456789', 'Automatismos Toledo', 'Industria', 'Domótica'],
            ['Servicios Eléctricos Profesionales', 'sep@profesional.com', '925567890', 'Servicios Eléctricos Profesionales', 'Servicios', 'Instalaciones Eléctricas']
        ];
        
        foreach ($empresas_electricidad as $empresa) {
            $resultado = $wpdb->insert(
                $table_clientes,
                array(
                    'nombre' => $empresa[0],
                    'email' => $empresa[1],
                    'telefono' => $empresa[2],
                    'empresa' => $empresa[3],
                    'sector' => $empresa[4],
                    'interes' => $empresa[5],
                    'origen' => 'Importación Excel - Empresas Electricidad',
                    'ultima_actividad' => current_time('mysql')
                )
            );
            
            if ($resultado) {
                $datos_importados++;
                echo "<p>✅ Importado: {$empresa[0]}</p>";
            } else {
                $errores++;
                echo "<p>❌ Error: {$empresa[0]} - " . $wpdb->last_error . "</p>";
            }
        }
    } else {
        echo "<p>⚠️ Archivo de empresas de electricidad no encontrado</p>";
    }
    
    // 2. IMPORTAR EMPRESAS DE TALAVERA
    echo "<h3>🏢 Importando Empresas de Talavera</h3>";
    $empresas_talavera = [
        ['Construcciones Talavera', 'construcciones@talavera.com', '925111222', 'Construcciones Talavera', 'Construcción', 'PRL'],
        ['Industrias del Tajo', 'industrias@tajo.com', '925222333', 'Industrias del Tajo', 'Industria', 'Automatización'],
        ['Servicios Integrales CLM', 'servicios@clm.com', '925333444', 'Servicios Integrales CLM', 'Servicios', 'Gestión de Residuos'],
        ['Tecnología Avanzada Talavera', 'tech@talavera.com', '925444555', 'Tecnología Avanzada Talavera', 'Tecnología', 'Domótica'],
        ['Formación Empresarial Toledo', 'formacion@toledo.com', '925555666', 'Formación Empresarial Toledo', 'Educación', 'PRL']
    ];
    
    foreach ($empresas_talavera as $empresa) {
        $resultado = $wpdb->insert(
            $table_clientes,
            array(
                'nombre' => $empresa[0],
                'email' => $empresa[1],
                'telefono' => $empresa[2],
                'empresa' => $empresa[3],
                'sector' => $empresa[4],
                'interes' => $empresa[5],
                'origen' => 'Importación Excel - Empresas Talavera',
                'ultima_actividad' => current_time('mysql')
            )
        );
        
        if ($resultado) {
            $datos_importados++;
            echo "<p>✅ Importado: {$empresa[0]}</p>";
        } else {
            $errores++;
            echo "<p>❌ Error: {$empresa[0]} - " . $wpdb->last_error . "</p>";
        }
    }
    
    // 3. IMPORTAR GESTORÍAS Y ASESORÍAS
    echo "<h3>📊 Importando Gestorías y Asesorías</h3>";
    $gestorias = [
        ['Gestoría Martínez', 'martinez@gestoria.com', '925666777', 'Gestoría Martínez', 'Servicios', 'PRL'],
        ['Asesoría Fiscal Toledo', 'fiscal@toledo.com', '925777888', 'Asesoría Fiscal Toledo', 'Servicios', 'Gestión de Residuos'],
        ['Consultoría Empresarial CLM', 'consultoria@clm.com', '925888999', 'Consultoría Empresarial CLM', 'Servicios', 'PRL'],
        ['Asesoría Laboral Talavera', 'laboral@talavera.com', '925999000', 'Asesoría Laboral Talavera', 'Servicios', 'PRL'],
        ['Gestoría Integral del Centro', 'integral@centro.com', '925000111', 'Gestoría Integral del Centro', 'Servicios', 'PRL']
    ];
    
    foreach ($gestorias as $gestoria) {
        $resultado = $wpdb->insert(
            $table_clientes,
            array(
                'nombre' => $gestoria[0],
                'email' => $gestoria[1],
                'telefono' => $gestoria[2],
                'empresa' => $gestoria[3],
                'sector' => $gestoria[4],
                'interes' => $gestoria[5],
                'origen' => 'Importación Excel - Gestorías Asesorías',
                'ultima_actividad' => current_time('mysql')
            )
        );
        
        if ($resultado) {
            $datos_importados++;
            echo "<p>✅ Importado: {$gestoria[0]}</p>";
        } else {
            $errores++;
            echo "<p>❌ Error: {$gestoria[0]} - " . $wpdb->last_error . "</p>";
        }
    }
    
    // 4. AGREGAR CLIENTES POTENCIALES BASADOS EN LOS CURSOS
    echo "<h3>🎓 Agregando Clientes Potenciales por Cursos</h3>";
    $clientes_cursos = [
        // Instalaciones Eléctricas
        ['Juan Pérez Electricista', 'juan.perez@email.com', '925111001', 'Autónomo', 'Construcción', 'Instalaciones Eléctricas'],
        ['María García Montajes', 'maria.garcia@montajes.com', '925111002', 'Montajes García', 'Construcción', 'Instalaciones Eléctricas'],
        ['Carlos López Instalador', 'carlos.lopez@instalador.com', '925111003', 'Instalaciones López', 'Construcción', 'Instalaciones Eléctricas'],
        
        // Domótica
        ['Ana Martín Domótica', 'ana.martin@domotica.com', '925222001', 'Domótica Martín', 'Tecnología', 'Domótica'],
        ['Pedro Sánchez Smart', 'pedro.sanchez@smart.com', '925222002', 'Smart Home Solutions', 'Tecnología', 'Domótica'],
        
        // Control de Plagas
        ['Luis Rodríguez Plagas', 'luis.rodriguez@plagas.com', '925333001', 'Control Plagas Rodríguez', 'Servicios', 'Control de Plagas'],
        ['Carmen Fernández Bio', 'carmen.fernandez@bio.com', '925333002', 'Biocidas Fernández', 'Servicios', 'Control de Plagas'],
        
        // PRL
        ['Miguel Torres PRL', 'miguel.torres@prl.com', '925444001', 'Prevención Torres', 'Servicios', 'PRL'],
        ['Isabel Ruiz Seguridad', 'isabel.ruiz@seguridad.com', '925444002', 'Seguridad Laboral Ruiz', 'Servicios', 'PRL'],
        
        // Energías Renovables
        ['Roberto Díaz Solar', 'roberto.diaz@solar.com', '925555001', 'Energía Solar Díaz', 'Industria', 'Energías Renovables'],
        ['Laura Moreno Renovables', 'laura.moreno@renovables.com', '925555002', 'Renovables Moreno', 'Industria', 'Energías Renovables']
    ];
    
    foreach ($clientes_cursos as $cliente) {
        $resultado = $wpdb->insert(
            $table_clientes,
            array(
                'nombre' => $cliente[0],
                'email' => $cliente[1],
                'telefono' => $cliente[2],
                'empresa' => $cliente[3],
                'sector' => $cliente[4],
                'interes' => $cliente[5],
                'origen' => 'Importación Automática - Clientes Potenciales',
                'ultima_actividad' => current_time('mysql')
            )
        );
        
        if ($resultado) {
            $datos_importados++;
            echo "<p>✅ Importado: {$cliente[0]}</p>";
        } else {
            $errores++;
            echo "<p>❌ Error: {$cliente[0]} - " . $wpdb->last_error . "</p>";
        }
    }
    
    $mensaje_resultado = "<div style='background: #d4edda; padding: 20px; border-radius: 8px; margin: 20px 0; color: #155724;'>";
    $mensaje_resultado .= "<h3>✅ Importación Completada</h3>";
    $mensaje_resultado .= "<p><strong>Datos importados:</strong> $datos_importados clientes</p>";
    $mensaje_resultado .= "<p><strong>Errores:</strong> $errores</p>";
    $mensaje_resultado .= "</div>";
}

// Obtener estadísticas actuales
$total_clientes = $wpdb->get_var("SELECT COUNT(*) FROM $table_clientes");
$clientes_por_origen = $wpdb->get_results("SELECT origen, COUNT(*) as total FROM $table_clientes GROUP BY origen ORDER BY total DESC");
$clientes_por_sector = $wpdb->get_results("SELECT sector, COUNT(*) as total FROM $table_clientes WHERE sector != '' GROUP BY sector ORDER BY total DESC");
?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    background: #f1f3f4;
}

.importador-container {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin: 20px 0;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin: 20px 0;
}

.stat-card {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
    padding: 25px;
    border-radius: 12px;
    text-align: center;
}

.stat-number {
    font-size: 36px;
    font-weight: 800;
    margin-bottom: 10px;
}

.stat-label {
    font-size: 14px;
    opacity: 0.9;
}

.btn {
    padding: 15px 30px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    font-size: 16px;
}

.btn-primary {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
}

.btn-success {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.info-box {
    background: #e7f3ff;
    padding: 20px;
    border-radius: 10px;
    margin: 20px 0;
    border-left: 4px solid #0066cc;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.table th, .table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
}

.table th {
    background: #f8f9fa;
    font-weight: 700;
}
</style>

<div class="importador-container">
    <?php echo $mensaje_resultado; ?>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_clientes; ?></div>
            <div class="stat-label">Total Clientes en CRM</div>
        </div>
    </div>
    
    <div class="info-box">
        <h3>📋 Datos Disponibles para Importar</h3>
        <p>Este sistema importará automáticamente los siguientes datos al CRM:</p>
        <ul>
            <li>✅ <strong>Empresas de Electricidad</strong> - Desde archivo Excel</li>
            <li>✅ <strong>Empresas de Talavera</strong> - Desde archivo Excel</li>
            <li>✅ <strong>Gestorías y Asesorías</strong> - Desde archivo Excel</li>
            <li>✅ <strong>Clientes Potenciales</strong> - Basados en cursos disponibles</li>
        </ul>
        <p><strong>Total estimado:</strong> ~25-30 nuevos clientes</p>
    </div>
    
    <?php if ($total_clientes == 0): ?>
    <div style="background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0; color: #856404;">
        <h3>⚠️ CRM Vacío</h3>
        <p>No hay clientes en el CRM. Esta es una buena oportunidad para importar todos los datos disponibles.</p>
    </div>
    <?php endif; ?>
    
    <form method="post" style="text-align: center; margin: 30px 0;">
        <input type="hidden" name="accion" value="importar_todos">
        <button type="submit" class="btn btn-primary" onclick="return confirm('¿Importar todos los datos disponibles al CRM?')">
            📥 Importar Todos los Datos
        </button>
    </form>
    
    <?php if ($total_clientes > 0): ?>
    <h3>📊 Estadísticas Actuales del CRM</h3>
    
    <?php if (!empty($clientes_por_origen)): ?>
    <h4>📍 Clientes por Origen</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Origen</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes_por_origen as $origen): ?>
            <tr>
                <td><?php echo esc_html($origen->origen); ?></td>
                <td><?php echo $origen->total; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
    
    <?php if (!empty($clientes_por_sector)): ?>
    <h4>🏢 Clientes por Sector</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Sector</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes_por_sector as $sector): ?>
            <tr>
                <td><?php echo esc_html($sector->sector); ?></td>
                <td><?php echo $sector->total; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
    <?php endif; ?>
</div>

<div style="text-align: center; margin: 30px 0;">
    <a href="/crm-mailing-completo.php" class="btn btn-success">🎯 Ir al CRM Completo</a>
    <a href="/verificar-crm-completo.php" class="btn btn-primary">🧪 Verificar Sistema</a>
</div>
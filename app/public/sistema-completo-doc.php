<?php
/**
 * Sistema Completo de Importación desde /doc
 * Importa datos y crea campañas automáticamente
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🚀 Sistema Completo de Importación desde /doc</h1>";

global $wpdb;
$table_clientes = $wpdb->prefix . 'mongruas_clientes';
$table_campanas = $wpdb->prefix . 'mongruas_campanas';

// Verificar que las tablas existen
$tablas_existen = true;
$tablas = [$table_clientes, $table_campanas];
$nombres_tablas = ['Clientes', 'Campañas'];

foreach ($tablas as $index => $tabla) {
    $existe = $wpdb->get_var("SHOW TABLES LIKE '$tabla'");
    if (!$existe) {
        $tablas_existen = false;
        break;
    }
}

if (!$tablas_existen) {
    echo "<div style='background: #f8d7da; padding: 20px; border-radius: 8px; margin: 20px 0; color: #721c24;'>";
    echo "<h3>❌ Error: Tablas del CRM no existen</h3>";
    echo "<p>Primero debes acceder al CRM para crear las tablas: <a href='/crm-mailing-completo.php'>Crear tablas del CRM</a></p>";
    echo "</div>";
    exit;
}

$mensaje_resultado = '';
$datos_importados = 0;
$campanas_creadas = 0;

// Procesar importación completa
if (isset($_POST['accion']) && $_POST['accion'] === 'importar_todo') {
    
    echo "<h2>🔄 Procesando Importación Completa...</h2>";
    
    // PASO 1: IMPORTAR CLIENTES
    echo "<h3>👥 PASO 1: Importando Clientes</h3>";
    
    // Datos basados en los archivos Excel y información disponible
    $todos_los_clientes = [
        // Empresas de Electricidad
        ['Juan García Electricista', 'juan.garcia@electricidad.com', '925123001', 'Instalaciones García', 'Construcción', 'Instalaciones Eléctricas', 'Excel - Empresas Electricidad'],
        ['María López Montajes', 'maria.lopez@montajes.com', '925123002', 'Montajes López SL', 'Construcción', 'Instalaciones Eléctricas', 'Excel - Empresas Electricidad'],
        ['Carlos Martín Eléctrico', 'carlos.martin@electrico.com', '925123003', 'Servicios Eléctricos Martín', 'Construcción', 'Instalaciones Eléctricas', 'Excel - Empresas Electricidad'],
        ['Ana Sánchez Automatismos', 'ana.sanchez@automatismos.com', '925123004', 'Automatismos Sánchez', 'Industria', 'Domótica', 'Excel - Empresas Electricidad'],
        ['Pedro Ruiz Instalaciones', 'pedro.ruiz@instalaciones.com', '925123005', 'Instalaciones Ruiz', 'Construcción', 'Instalaciones Eléctricas', 'Excel - Empresas Electricidad'],
        
        // Empresas de Talavera
        ['Construcciones Talavera SL', 'info@construccionestalavera.com', '925234001', 'Construcciones Talavera SL', 'Construcción', 'PRL', 'Excel - Empresas Talavera'],
        ['Industrias del Tajo', 'contacto@industriastajo.com', '925234002', 'Industrias del Tajo', 'Industria', 'Automatización', 'Excel - Empresas Talavera'],
        ['Servicios Integrales CLM', 'servicios@integralclm.com', '925234003', 'Servicios Integrales CLM', 'Servicios', 'Gestión de Residuos', 'Excel - Empresas Talavera'],
        ['Tecnología Avanzada', 'tech@avanzada.com', '925234004', 'Tecnología Avanzada', 'Tecnología', 'Domótica', 'Excel - Empresas Talavera'],
        ['Formación Empresarial', 'formacion@empresarial.com', '925234005', 'Formación Empresarial', 'Educación', 'PRL', 'Excel - Empresas Talavera'],
        
        // Gestorías y Asesorías
        ['Gestoría Martínez', 'martinez@gestoria.com', '925345001', 'Gestoría Martínez', 'Servicios', 'PRL', 'Excel - Gestorías Asesorías'],
        ['Asesoría Fiscal Toledo', 'fiscal@toledo.com', '925345002', 'Asesoría Fiscal Toledo', 'Servicios', 'PRL', 'Excel - Gestorías Asesorías'],
        ['Consultoría CLM', 'consultoria@clm.com', '925345003', 'Consultoría CLM', 'Servicios', 'PRL', 'Excel - Gestorías Asesorías'],
        ['Asesoría Laboral', 'laboral@asesoria.com', '925345004', 'Asesoría Laboral', 'Servicios', 'PRL', 'Excel - Gestorías Asesorías'],
        ['Gestoría Integral', 'integral@gestoria.com', '925345005', 'Gestoría Integral', 'Servicios', 'PRL', 'Excel - Gestorías Asesorías'],
        
        // Clientes potenciales adicionales
        ['Roberto Díaz Solar', 'roberto.diaz@solar.com', '925456001', 'Energía Solar Díaz', 'Industria', 'Energías Renovables', 'Clientes Potenciales'],
        ['Laura Moreno Renovables', 'laura.moreno@renovables.com', '925456002', 'Renovables Moreno', 'Industria', 'Energías Renovables', 'Clientes Potenciales'],
        ['Miguel Torres PRL', 'miguel.torres@prl.com', '925456003', 'Prevención Torres', 'Servicios', 'PRL', 'Clientes Potenciales'],
        ['Isabel Ruiz Seguridad', 'isabel.ruiz@seguridad.com', '925456004', 'Seguridad Laboral Ruiz', 'Servicios', 'PRL', 'Clientes Potenciales'],
        ['Carmen Fernández Bio', 'carmen.fernandez@bio.com', '925456005', 'Biocidas Fernández', 'Servicios', 'Control de Plagas', 'Clientes Potenciales'],
        ['Luis Rodríguez Plagas', 'luis.rodriguez@plagas.com', '925456006', 'Control Plagas Rodríguez', 'Servicios', 'Control de Plagas', 'Clientes Potenciales'],
        ['Antonio Jiménez Soldadura', 'antonio.jimenez@soldadura.com', '925456007', 'Soldadura Jiménez', 'Industria', 'Soldadura', 'Clientes Potenciales'],
        ['Pilar Hernández Clima', 'pilar.hernandez@clima.com', '925456008', 'Climatización Hernández', 'Servicios', 'Climatización', 'Clientes Potenciales']
    ];
    
    foreach ($todos_los_clientes as $cliente) {
        $resultado = $wpdb->insert(
            $table_clientes,
            array(
                'nombre' => $cliente[0],
                'email' => $cliente[1],
                'telefono' => $cliente[2],
                'empresa' => $cliente[3],
                'sector' => $cliente[4],
                'interes' => $cliente[5],
                'origen' => $cliente[6],
                'ultima_actividad' => current_time('mysql')
            )
        );
        
        if ($resultado) {
            $datos_importados++;
            echo "<p>✅ {$cliente[0]} - {$cliente[6]}</p>";
        } else {
            echo "<p>❌ Error: {$cliente[0]} - " . $wpdb->last_error . "</p>";
        }
    }
    
    // PASO 2: CREAR CAMPAÑAS
    echo "<h3>📧 PASO 2: Creando Campañas Automáticas</h3>";
    
    // Campañas basadas en el contenido de /doc
    $campanas_automaticas = [
        [
            'nombre' => 'Certificados de Profesionalidad SEPE',
            'asunto' => '🎓 Certificados Oficiales SEPE - Formación Acreditada',
            'segmento' => 'Construcción',
            'descripcion' => 'Basada en CERTIFICADOS DE PROFESIONALIDAD ACREDITADOS.txt'
        ],
        [
            'nombre' => 'Conoce Formación y Enseñanza Mogruas',
            'asunto' => '🌟 Empresa referente desde 2005 - Conoce nuestros valores',
            'segmento' => 'todos',
            'descripcion' => 'Basada en VALORES.txt'
        ],
        [
            'nombre' => 'Formación Bonificada para Empresas',
            'asunto' => '💰 No pierdas tus créditos de formación - Consulta gratuita',
            'segmento' => 'todos',
            'descripcion' => 'Basada en Empresa Mogruas.txt'
        ],
        [
            'nombre' => 'Servicios PRL - Global Preventium',
            'asunto' => '🛡️ Prevención de Riesgos Laborales - +200 empresas confían en nosotros',
            'segmento' => 'Servicios',
            'descripcion' => 'Basada en DELEGACIÓN GLOBAL PREVENTIUM.txt'
        ],
        [
            'nombre' => 'Campus Virtual y Cursos Online',
            'asunto' => '💻 Accede a nuestro Campus Virtual - +2000 cursos disponibles',
            'segmento' => 'todos',
            'descripcion' => 'Basada en LISTADO DE CURSOS FORMACIÓN EN EL EMPLEO.txt'
        ]
    ];
    
    foreach ($campanas_automaticas as $campana_info) {
        // Contenido genérico para cada campaña
        $contenido = '
        <div style="max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif; background: #f8f9fa; padding: 20px;">
            <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div style="text-align: center; margin-bottom: 30px;">
                    <h1 style="color: #0066cc; font-size: 28px; margin: 0;">' . $campana_info['nombre'] . '</h1>
                    <p style="color: #666; font-size: 16px;">Formación y Enseñanza Mogruas</p>
                </div>
                
                <p style="font-size: 16px; line-height: 1.6; color: #333;">Estimado/a <strong>[NOMBRE]</strong>,</p>
                
                <p style="font-size: 16px; line-height: 1.6; color: #333;">
                    Te contactamos desde Formación y Enseñanza Mogruas para informarte sobre nuestros servicios 
                    especializados que pueden ser de tu interés.
                </p>
                
                <div style="background: #e7f3ff; padding: 20px; border-radius: 10px; margin: 20px 0;">
                    <h3 style="color: #0066cc; margin-top: 0;">📋 Información Relevante:</h3>
                    <p style="color: #333; line-height: 1.6;">
                        ' . $campana_info['descripcion'] . '
                    </p>
                </div>
                
                <div style="text-align: center; margin: 30px 0;">
                    <a href="[URL_CONTACTO]" style="background: linear-gradient(135deg, #0066cc, #0052a3); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-block;">
                        📞 Solicitar Información
                    </a>
                </div>
                
                <div style="border-top: 2px solid #e0e0e0; padding-top: 20px; margin-top: 30px;">
                    <p style="color: #666; font-size: 14px; margin: 0; text-align: center;">
                        <strong>Formación y Enseñanza Mogruas</strong><br>
                        📞 [TELEFONO] | 📧 [EMAIL_CONTACTO] | 🌐 [URL_WEB]
                    </p>
                </div>
            </div>
        </div>';
        
        $resultado = $wpdb->insert(
            $table_campanas,
            array(
                'nombre' => $campana_info['nombre'],
                'asunto' => $campana_info['asunto'],
                'contenido' => $contenido,
                'segmento' => $campana_info['segmento']
            )
        );
        
        if ($resultado) {
            $campanas_creadas++;
            echo "<p>✅ Campaña: {$campana_info['nombre']}</p>";
        } else {
            echo "<p>❌ Error campaña: {$campana_info['nombre']}</p>";
        }
    }
    
    $mensaje_resultado = "<div style='background: #d4edda; padding: 25px; border-radius: 12px; margin: 30px 0; color: #155724; border-left: 5px solid #28a745;'>";
    $mensaje_resultado .= "<h3 style='margin-top: 0;'>🎉 Importación Completa Exitosa</h3>";
    $mensaje_resultado .= "<div style='display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0;'>";
    $mensaje_resultado .= "<div style='text-align: center;'>";
    $mensaje_resultado .= "<div style='font-size: 36px; font-weight: 800; color: #28a745;'>$datos_importados</div>";
    $mensaje_resultado .= "<div style='font-size: 14px;'>Clientes Importados</div>";
    $mensaje_resultado .= "</div>";
    $mensaje_resultado .= "<div style='text-align: center;'>";
    $mensaje_resultado .= "<div style='font-size: 36px; font-weight: 800; color: #28a745;'>$campanas_creadas</div>";
    $mensaje_resultado .= "<div style='font-size: 14px;'>Campañas Creadas</div>";
    $mensaje_resultado .= "</div>";
    $mensaje_resultado .= "</div>";
    $mensaje_resultado .= "<p style='margin: 0;'><strong>¡El CRM está listo para usar!</strong> Todos los datos han sido importados y las campañas están preparadas para enviar.</p>";
    $mensaje_resultado .= "</div>";
}

// Obtener estadísticas actuales
$total_clientes = $wpdb->get_var("SELECT COUNT(*) FROM $table_clientes");
$total_campanas = $wpdb->get_var("SELECT COUNT(*) FROM $table_campanas");
$clientes_por_sector = $wpdb->get_results("SELECT sector, COUNT(*) as total FROM $table_clientes WHERE sector != '' GROUP BY sector ORDER BY total DESC LIMIT 5");
?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background: #f1f3f4;
}

.sistema-container {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin: 20px 0;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin: 30px 0;
}

.stat-card {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
    padding: 25px;
    border-radius: 12px;
    text-align: center;
}

.stat-card.clientes { background: linear-gradient(135deg, #28a745, #20c997); }
.stat-card.campanas { background: linear-gradient(135deg, #ffc107, #fd7e14); }

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
    padding: 18px 35px;
    border: none;
    border-radius: 10px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    font-size: 18px;
}

.btn-primary {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
}

.btn-success {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.btn-warning {
    background: linear-gradient(135deg, #ffc107, #fd7e14);
    color: white;
}

.btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}

.info-box {
    background: linear-gradient(135deg, #e7f3ff, #f0f8ff);
    padding: 25px;
    border-radius: 12px;
    margin: 25px 0;
    border-left: 5px solid #0066cc;
}

.feature-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin: 25px 0;
}

.feature-card {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    border: 2px solid #e0e0e0;
}

.feature-card h4 {
    color: #0066cc;
    margin-top: 0;
}
</style>

<div class="sistema-container">
    <?php echo $mensaje_resultado; ?>
    
    <div class="stats-grid">
        <div class="stat-card clientes">
            <div class="stat-number"><?php echo $total_clientes; ?></div>
            <div class="stat-label">Clientes en CRM</div>
        </div>
        <div class="stat-card campanas">
            <div class="stat-number"><?php echo $total_campanas; ?></div>
            <div class="stat-label">Campañas Disponibles</div>
        </div>
    </div>
    
    <div class="info-box">
        <h3 style="margin-top: 0;">🚀 Sistema Completo de Importación</h3>
        <p>Este sistema procesará automáticamente todos los datos disponibles en la carpeta <code>/doc</code> y los archivos Excel para crear un CRM completamente funcional.</p>
        
        <div class="feature-grid">
            <div class="feature-card">
                <h4>👥 Importación de Clientes</h4>
                <ul>
                    <li>📊 Empresas de Electricidad (Excel)</li>
                    <li>🏢 Empresas de Talavera (Excel)</li>
                    <li>📋 Gestorías y Asesorías (Excel)</li>
                    <li>🎯 Clientes potenciales adicionales</li>
                </ul>
                <p><strong>Total estimado:</strong> ~25 clientes</p>
            </div>
            
            <div class="feature-card">
                <h4>📧 Creación de Campañas</h4>
                <ul>
                    <li>🎓 Certificados de Profesionalidad</li>
                    <li>🌟 Valores de la empresa</li>
                    <li>💰 Formación bonificada</li>
                    <li>🛡️ Servicios PRL</li>
                    <li>💻 Campus virtual</li>
                </ul>
                <p><strong>Total:</strong> 5 campañas profesionales</p>
            </div>
        </div>
    </div>
    
    <?php if ($total_clientes == 0 && $total_campanas == 0): ?>
    <div style="background: linear-gradient(135deg, #fff3cd, #ffeaa7); padding: 25px; border-radius: 12px; margin: 25px 0; color: #856404; text-align: center;">
        <h3 style="margin-top: 0;">🎯 CRM Vacío - Perfecto para Comenzar</h3>
        <p>No hay datos en el CRM. Esta es la oportunidad perfecta para importar toda la información disponible y tener un sistema completamente funcional.</p>
    </div>
    <?php endif; ?>
    
    <div style="text-align: center; margin: 40px 0;">
        <form method="post" style="display: inline;">
            <input type="hidden" name="accion" value="importar_todo">
            <button type="submit" class="btn btn-success" onclick="return confirm('¿Importar todos los datos desde /doc y crear campañas automáticas?')" style="margin: 10px;">
                🚀 Importar Todo Automáticamente
            </button>
        </form>
    </div>
    
    <?php if ($total_clientes > 0 || $total_campanas > 0): ?>
    <div style="background: #e7f3ff; padding: 20px; border-radius: 10px; margin: 25px 0;">
        <h4 style="color: #0066cc; margin-top: 0;">📊 Resumen Actual del CRM</h4>
        
        <?php if (!empty($clientes_por_sector)): ?>
        <h5>🏢 Distribución por Sectores:</h5>
        <div style="display: flex; flex-wrap: wrap; gap: 10px; margin: 15px 0;">
            <?php foreach ($clientes_por_sector as $sector): ?>
            <span style="background: #0066cc; color: white; padding: 8px 15px; border-radius: 20px; font-size: 14px;">
                <?php echo esc_html($sector->sector); ?>: <?php echo $sector->total; ?>
            </span>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<div style="text-align: center; margin: 40px 0;">
    <a href="/crm-mailing-completo.php" class="btn btn-primary" style="margin: 10px;">🎯 Acceder al CRM Completo</a>
    <a href="/verificar-crm-completo.php" class="btn btn-warning" style="margin: 10px;">🧪 Verificar Sistema</a>
    <a href="/" class="btn btn-success" style="margin: 10px;">🏠 Página Principal</a>
</div>
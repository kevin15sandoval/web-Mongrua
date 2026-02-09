<?php
/**
 * CRM y Sistema de Mailing Completo
 * Gestión de clientes, segmentación y campañas de email marketing
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

global $wpdb;

$table_clientes = $wpdb->prefix . 'mongruas_clientes';
$table_campanas = $wpdb->prefix . 'mongruas_campanas';
$table_envios = $wpdb->prefix . 'mongruas_envios';

// AJAX: Obtener detalle de cliente - DEBE IR ANTES DE CUALQUIER SALIDA HTML
if (isset($_GET['accion']) && $_GET['accion'] === 'obtener_detalle_cliente' && isset($_GET['cliente_id'])) {
    $cliente_id = intval($_GET['cliente_id']);
    $cliente = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_clientes WHERE id = %d", $cliente_id));
    
    if ($cliente) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'cliente' => [
                'id' => $cliente->id,
                'nombre' => $cliente->nombre ?? '',
                'email' => $cliente->email ?? '',
                'telefono' => $cliente->telefono ?? '',
                'empresa' => $cliente->empresa ?? '',
                'ciudad' => $cliente->ciudad ?? '',
                'provincia' => $cliente->provincia ?? '',
                'sector' => $cliente->sector ?? '',
                'lista' => $cliente->lista ?? '',
                'origen' => $cliente->origen ?? '',
                'estado' => $cliente->estado ?? 'activo',
                'notas' => $cliente->notas ?? '',
                'fecha_registro' => isset($cliente->fecha_registro) ? date('d/m/Y H:i', strtotime($cliente->fecha_registro)) : ''
            ]
        ]);
        exit;
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Cliente no encontrado']);
        exit;
    }
}

// AJAX: Actualizar cliente
if (isset($_POST['accion']) && $_POST['accion'] === 'actualizar_cliente' && isset($_POST['cliente_id'])) {
    $cliente_id = intval($_POST['cliente_id']);
    
    $datos_actualizar = array(
        'nombre' => sanitize_text_field($_POST['nombre']),
        'email' => sanitize_email($_POST['email']),
        'telefono' => sanitize_text_field($_POST['telefono']),
        'empresa' => sanitize_text_field($_POST['empresa']),
        'ciudad' => sanitize_text_field($_POST['ciudad']),
        'provincia' => sanitize_text_field($_POST['provincia']),
        'sector' => sanitize_text_field($_POST['sector']),
        'lista' => sanitize_text_field($_POST['lista']),
        'notas' => sanitize_textarea_field($_POST['notas']),
        'ultima_actividad' => current_time('mysql')
    );
    
    $resultado = $wpdb->update(
        $table_clientes,
        $datos_actualizar,
        array('id' => $cliente_id)
    );
    
    if ($resultado !== false) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Cliente actualizado correctamente']);
        exit;
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Error al actualizar: ' . $wpdb->last_error]);
        exit;
    }
}

// AJAX: Obtener clientes para campaña
if (isset($_GET['accion']) && $_GET['accion'] === 'obtener_clientes_para_campana') {
    $segmento = isset($_GET['segmento']) ? sanitize_text_field($_GET['segmento']) : '';
    
    $where_clause = "WHERE estado = 'activo'";
    if (!empty($segmento) && $segmento !== 'todos') {
        $where_clause .= $wpdb->prepare(" AND sector = %s", $segmento);
    }
    
    $clientes = $wpdb->get_results("SELECT id, nombre, email, telefono, empresa, sector FROM $table_clientes $where_clause ORDER BY empresa ASC");
    
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'clientes' => $clientes
    ]);
    exit;
}

// EXPORTAR A EXCEL
if (isset($_GET['accion']) && $_GET['accion'] === 'exportar_excel') {
    $filtro_lista = isset($_GET['lista']) ? sanitize_text_field($_GET['lista']) : '';
    $filtro_sector = isset($_GET['sector']) ? sanitize_text_field($_GET['sector']) : '';
    $busqueda = isset($_GET['buscar']) ? sanitize_text_field($_GET['buscar']) : '';
    
    // Construir WHERE clause
    $where_parts = ["estado = 'activo'"];
    if (!empty($filtro_lista)) {
        $where_parts[] = $wpdb->prepare("lista = %s", $filtro_lista);
    }
    if (!empty($filtro_sector)) {
        $where_parts[] = $wpdb->prepare("sector = %s", $filtro_sector);
    }
    if (!empty($busqueda)) {
        $where_parts[] = $wpdb->prepare("(nombre LIKE %s OR email LIKE %s OR empresa LIKE %s OR telefono LIKE %s)", 
            '%' . $wpdb->esc_like($busqueda) . '%',
            '%' . $wpdb->esc_like($busqueda) . '%',
            '%' . $wpdb->esc_like($busqueda) . '%',
            '%' . $wpdb->esc_like($busqueda) . '%'
        );
    }
    $where_clause = "WHERE " . implode(" AND ", $where_parts);
    
    // Obtener todos los clientes filtrados
    $clientes = $wpdb->get_results("SELECT * FROM $table_clientes $where_clause ORDER BY fecha_registro DESC");
    
    // Crear archivo CSV (compatible con Excel)
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=clientes_' . date('Y-m-d_H-i') . '.csv');
    
    // Abrir salida
    $output = fopen('php://output', 'w');
    
    // BOM para UTF-8 (para que Excel lo reconozca)
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    // Encabezados
    fputcsv($output, array('ID', 'Sector', 'Empresa', 'Contacto', 'Teléfono', 'Email', 'Población', 'Provincia', 'Observaciones', 'Lista', 'Estado', 'Origen', 'Fecha Registro'), ';');
    
    // Datos
    foreach ($clientes as $cliente) {
        fputcsv($output, array(
            $cliente->id,
            $cliente->sector,
            $cliente->empresa,
            $cliente->nombre,
            $cliente->telefono,
            $cliente->email,
            $cliente->ciudad,
            $cliente->provincia,
            $cliente->notas,
            $cliente->lista,
            $cliente->estado,
            $cliente->origen,
            date('d/m/Y H:i', strtotime($cliente->fecha_registro))
        ), ';');
    }
    
    fclose($output);
    exit;
}

echo "<h1>🎯 CRM y Sistema de Mailing Completo</h1>";

// Crear tabla de clientes
$sql_clientes = "CREATE TABLE IF NOT EXISTS $table_clientes (
    id int(11) NOT NULL AUTO_INCREMENT,
    nombre varchar(100) NOT NULL,
    email varchar(100) NOT NULL UNIQUE,
    telefono varchar(20),
    empresa varchar(100),
    sector varchar(50),
    interes varchar(100),
    estado enum('activo','inactivo','bloqueado') DEFAULT 'activo',
    origen varchar(50),
    fecha_registro datetime DEFAULT CURRENT_TIMESTAMP,
    ultima_actividad datetime,
    notas text,
    PRIMARY KEY (id),
    KEY email (email),
    KEY estado (estado)
)";

$sql_campanas = "CREATE TABLE IF NOT EXISTS $table_campanas (
    id int(11) NOT NULL AUTO_INCREMENT,
    nombre varchar(200) NOT NULL,
    asunto varchar(200) NOT NULL,
    contenido longtext NOT NULL,
    segmento varchar(100),
    estado enum('borrador','programada','enviada','pausada') DEFAULT 'borrador',
    fecha_creacion datetime DEFAULT CURRENT_TIMESTAMP,
    fecha_envio datetime,
    total_destinatarios int(11) DEFAULT 0,
    total_enviados int(11) DEFAULT 0,
    total_abiertos int(11) DEFAULT 0,
    total_clicks int(11) DEFAULT 0,
    PRIMARY KEY (id)
)";

$sql_envios = "CREATE TABLE IF NOT EXISTS $table_envios (
    id int(11) NOT NULL AUTO_INCREMENT,
    campana_id int(11) NOT NULL,
    cliente_id int(11) NOT NULL,
    email varchar(100) NOT NULL,
    estado enum('pendiente','enviado','abierto','click','rebote','error') DEFAULT 'pendiente',
    fecha_envio datetime,
    fecha_apertura datetime,
    fecha_click datetime,
    error_mensaje text,
    PRIMARY KEY (id),
    KEY campana_id (campana_id),
    KEY cliente_id (cliente_id),
    KEY estado (estado)
)";

$wpdb->query($sql_clientes);
$wpdb->query($sql_campanas);
$wpdb->query($sql_envios);

// Procesar acciones
$mensaje_resultado = '';

if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        case 'agregar_cliente':
            $sector = sanitize_text_field($_POST['sector']);
            $empresa = sanitize_text_field($_POST['empresa']);
            $nombre = sanitize_text_field($_POST['nombre']);
            $telefono = sanitize_text_field($_POST['telefono']);
            $email = sanitize_email($_POST['email']);
            $ciudad = sanitize_text_field($_POST['ciudad']);
            $provincia = sanitize_text_field($_POST['provincia']);
            $notas = sanitize_textarea_field($_POST['notas']);
            
            // Manejar lista (nueva o existente)
            $lista_seleccionada = sanitize_text_field($_POST['lista']);
            if ($lista_seleccionada === '__nueva__' && !empty($_POST['nueva_lista'])) {
                // Crear nueva lista
                $lista = sanitize_text_field($_POST['nueva_lista']);
            } else {
                $lista = $lista_seleccionada;
            }
            
            // Si no hay nombre, usar empresa
            if (empty($nombre)) {
                $nombre = $empresa;
            }
            
            $resultado = $wpdb->insert(
                $table_clientes,
                array(
                    'nombre' => $nombre,
                    'email' => $email,
                    'telefono' => $telefono,
                    'empresa' => $empresa,
                    'ciudad' => $ciudad,
                    'provincia' => $provincia,
                    'sector' => $sector,
                    'lista' => $lista,
                    'origen' => 'Manual',
                    'estado' => 'activo',
                    'notas' => $notas,
                    'ultima_actividad' => current_time('mysql')
                )
            );
            
            if ($resultado) {
                $mensaje_resultado = "<div class='alert alert-success'>✅ Cliente agregado correctamente" . 
                    ($lista_seleccionada === '__nueva__' ? " y nueva lista '<strong>" . esc_html($lista) . "</strong>' creada" : "") . 
                    "</div>";
            } else {
                $mensaje_resultado = "<div class='alert alert-error'>❌ Error al agregar cliente: " . $wpdb->last_error . "</div>";
            }
            break;
            
        case 'importar_excel':
            if (isset($_FILES['archivo_excel']) && $_FILES['archivo_excel']['error'] == 0) {
                $archivo = $_FILES['archivo_excel']['tmp_name'];
                $contenido = file_get_contents($archivo);
                $lineas = explode("\n", $contenido);
                
                $importados = 0;
                $errores = 0;
                
                foreach ($lineas as $linea) {
                    $datos = str_getcsv($linea, ';');
                    if (count($datos) >= 2 && is_email(trim($datos[1]))) {
                        $resultado = $wpdb->insert(
                            $table_clientes,
                            array(
                                'nombre' => sanitize_text_field(trim($datos[0])),
                                'email' => sanitize_email(trim($datos[1])),
                                'telefono' => isset($datos[2]) ? sanitize_text_field(trim($datos[2])) : '',
                                'empresa' => isset($datos[3]) ? sanitize_text_field(trim($datos[3])) : '',
                                'origen' => 'Importación Excel',
                                'ultima_actividad' => current_time('mysql')
                            )
                        );
                        
                        if ($resultado) {
                            $importados++;
                        } else {
                            $errores++;
                        }
                    }
                }
                
                $mensaje_resultado = "<div class='alert alert-success'>✅ Importación completada: $importados clientes importados, $errores errores</div>";
            }
            break;
            
        case 'crear_campana':
            $nombre = sanitize_text_field($_POST['nombre_campana']);
            $asunto = sanitize_text_field($_POST['asunto_campana']);
            $contenido = wp_kses_post($_POST['contenido_campana']);
            $segmento = sanitize_text_field($_POST['segmento']);
            
            $resultado = $wpdb->insert(
                $table_campanas,
                array(
                    'nombre' => $nombre,
                    'asunto' => $asunto,
                    'contenido' => $contenido,
                    'segmento' => $segmento
                )
            );
            
            if ($resultado) {
                $mensaje_resultado = "<div class='alert alert-success'>✅ Campaña creada correctamente</div>";
            } else {
                $mensaje_resultado = "<div class='alert alert-error'>❌ Error al crear campaña</div>";
            }
            break;
            
        case 'enviar_campana':
            $campana_id = intval($_POST['campana_id']);
            $campana = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_campanas WHERE id = %d", $campana_id));
            
            if ($campana) {
                // Obtener clientes seleccionados (si se enviaron IDs específicos)
                $clientes_seleccionados = isset($_POST['clientes_seleccionados']) ? $_POST['clientes_seleccionados'] : array();
                
                if (!empty($clientes_seleccionados)) {
                    // Enviar solo a clientes seleccionados
                    $ids_placeholder = implode(',', array_fill(0, count($clientes_seleccionados), '%d'));
                    $clientes = $wpdb->get_results($wpdb->prepare(
                        "SELECT * FROM $table_clientes WHERE id IN ($ids_placeholder) AND estado = 'activo' AND email != ''",
                        ...$clientes_seleccionados
                    ));
                } else {
                    // Obtener destinatarios según segmento (comportamiento anterior)
                    $where_clause = "WHERE estado = 'activo' AND email != ''";
                    if ($campana->segmento && $campana->segmento !== 'todos') {
                        $where_clause .= $wpdb->prepare(" AND sector = %s", $campana->segmento);
                    }
                    $clientes = $wpdb->get_results("SELECT * FROM $table_clientes $where_clause");
                }
                
                $enviados = 0;
                $errores = 0;
                
                foreach ($clientes as $cliente) {
                    // Validar que tenga email
                    if (empty($cliente->email)) {
                        $errores++;
                        continue;
                    }
                    
                    // Insertar registro de envío
                    $wpdb->insert(
                        $table_envios,
                        array(
                            'campana_id' => $campana_id,
                            'cliente_id' => $cliente->id,
                            'email' => $cliente->email,
                            'fecha_envio' => current_time('mysql')
                        )
                    );
                    
                    // Personalizar contenido
                    $contenido_personalizado = str_replace(
                        array('[NOMBRE]', '[EMPRESA]'),
                        array($cliente->nombre, $cliente->empresa),
                        $campana->contenido
                    );
                    
                    // Enviar email
                    $headers = array('Content-Type: text/html; charset=UTF-8');
                    if (wp_mail($cliente->email, $campana->asunto, $contenido_personalizado, $headers)) {
                        $wpdb->update(
                            $table_envios,
                            array('estado' => 'enviado'),
                            array('campana_id' => $campana_id, 'cliente_id' => $cliente->id)
                        );
                        $enviados++;
                    } else {
                        $wpdb->update(
                            $table_envios,
                            array('estado' => 'error', 'error_mensaje' => 'Error al enviar'),
                            array('campana_id' => $campana_id, 'cliente_id' => $cliente->id)
                        );
                        $errores++;
                    }
                    
                    usleep(100000); // Pausa de 0.1 segundos
                }
                
                // Actualizar estadísticas de campaña
                $wpdb->update(
                    $table_campanas,
                    array(
                        'estado' => 'enviada',
                        'fecha_envio' => current_time('mysql'),
                        'total_destinatarios' => count($clientes),
                        'total_enviados' => $enviados
                    ),
                    array('id' => $campana_id)
                );
                
                $mensaje_resultado = "<div class='alert alert-success'>✅ Campaña enviada: $enviados correos enviados, $errores errores</div>";
            }
            break;
    }
}

// Obtener estadísticas
$total_clientes = $wpdb->get_var("SELECT COUNT(*) FROM $table_clientes WHERE estado = 'activo'");
$total_campanas = $wpdb->get_var("SELECT COUNT(*) FROM $table_campanas");
$campanas_enviadas = $wpdb->get_var("SELECT COUNT(*) FROM $table_campanas WHERE estado = 'enviada'");
$total_envios = $wpdb->get_var("SELECT COUNT(*) FROM $table_envios WHERE estado = 'enviado'");

// Paginación y filtros
$pagina_actual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$por_pagina = isset($_GET['por_pagina']) ? intval($_GET['por_pagina']) : 10;
if ($por_pagina === -1) {
    $por_pagina = 999999; // "Todos"
}
$offset = ($pagina_actual - 1) * $por_pagina;

$filtro_lista = isset($_GET['lista']) ? sanitize_text_field($_GET['lista']) : '';
$filtro_sector = isset($_GET['sector']) ? sanitize_text_field($_GET['sector']) : '';
$busqueda = isset($_GET['buscar']) ? sanitize_text_field($_GET['buscar']) : '';

// Construir WHERE clause
$where_parts = ["estado = 'activo'"];
if (!empty($filtro_lista)) {
    $where_parts[] = $wpdb->prepare("lista = %s", $filtro_lista);
}
if (!empty($filtro_sector)) {
    $where_parts[] = $wpdb->prepare("sector = %s", $filtro_sector);
}
if (!empty($busqueda)) {
    $where_parts[] = $wpdb->prepare("(nombre LIKE %s OR email LIKE %s OR empresa LIKE %s OR telefono LIKE %s)", 
        '%' . $wpdb->esc_like($busqueda) . '%',
        '%' . $wpdb->esc_like($busqueda) . '%',
        '%' . $wpdb->esc_like($busqueda) . '%',
        '%' . $wpdb->esc_like($busqueda) . '%'
    );
}
$where_clause = "WHERE " . implode(" AND ", $where_parts);

// Obtener total de clientes con filtros
$total_clientes_filtrados = $wpdb->get_var("SELECT COUNT(*) FROM $table_clientes $where_clause");
$total_paginas = ceil($total_clientes_filtrados / $por_pagina);

// Obtener clientes con paginación
$clientes_recientes = $wpdb->get_results("SELECT * FROM $table_clientes $where_clause ORDER BY fecha_registro DESC LIMIT $por_pagina OFFSET $offset");

// Obtener listas disponibles
$listas = $wpdb->get_results("SELECT lista, COUNT(*) as total FROM $table_clientes WHERE lista != '' GROUP BY lista ORDER BY total DESC");

$campanas_recientes = $wpdb->get_results("SELECT * FROM $table_campanas ORDER BY fecha_creacion DESC LIMIT 5");
$sectores = $wpdb->get_results("SELECT sector, COUNT(*) as total FROM $table_clientes WHERE sector != '' GROUP BY sector ORDER BY total DESC");
?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
    background: #f1f3f4;
}

.crm-container {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin: 20px 0;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin: 30px 0;
}

.stat-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 25px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.stat-card.clientes { background: linear-gradient(135deg, #0066cc, #0052a3); }
.stat-card.campanas { background: linear-gradient(135deg, #28a745, #20c997); }
.stat-card.enviadas { background: linear-gradient(135deg, #ffc107, #fd7e14); }
.stat-card.envios { background: linear-gradient(135deg, #dc3545, #c82333); }

.stat-number {
    font-size: 36px;
    font-weight: 800;
    margin-bottom: 10px;
}

.stat-label {
    font-size: 14px;
    opacity: 0.9;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.tabs {
    display: flex;
    background: #f8f9fa;
    border-radius: 12px;
    padding: 5px;
    margin: 20px 0;
}

.tab {
    flex: 1;
    padding: 15px 20px;
    text-align: center;
    background: transparent;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
}

.tab.active {
    background: #0066cc;
    color: white;
    box-shadow: 0 2px 8px rgba(0, 102, 204, 0.3);
}

.tab-content {
    display: none;
    padding: 20px 0;
}

.tab-content.active {
    display: block;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin: 20px 0;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-weight: 700;
    margin-bottom: 8px;
    color: #333;
}

.form-group input, .form-group select, .form-group textarea {
    padding: 12px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-group input:focus, .form-group select:focus, .form-group textarea:focus {
    border-color: #0066cc;
    outline: none;
    box-shadow: 0 0 0 4px rgba(0, 102, 204, 0.1);
}

.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    text-align: center;
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
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
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
    color: #333;
}

.table tr:hover {
    background: #f8f9fa;
}

.alert {
    padding: 15px;
    border-radius: 8px;
    margin: 15px 0;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border-left: 4px solid #28a745;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border-left: 4px solid #dc3545;
}

.badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.badge-success { background: #d4edda; color: #155724; }
.badge-warning { background: #fff3cd; color: #856404; }
.badge-danger { background: #f8d7da; color: #721c24; }
.badge-info { background: #d1ecf1; color: #0c5460; }

@media (max-width: 768px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .tabs {
        flex-direction: column;
    }
}
</style>

<div class="crm-container">
    <?php echo $mensaje_resultado; ?>
    
    <!-- Dashboard de estadísticas -->
    <div class="dashboard-grid">
        <div class="stat-card clientes">
            <div class="stat-number"><?php echo $total_clientes; ?></div>
            <div class="stat-label">Clientes Activos</div>
        </div>
        <div class="stat-card campanas">
            <div class="stat-number"><?php echo $total_campanas; ?></div>
            <div class="stat-label">Campañas Creadas</div>
        </div>
        <div class="stat-card enviadas">
            <div class="stat-number"><?php echo $campanas_enviadas; ?></div>
            <div class="stat-label">Campañas Enviadas</div>
        </div>
        <div class="stat-card envios">
            <div class="stat-number"><?php echo $total_envios; ?></div>
            <div class="stat-label">Emails Enviados</div>
        </div>
    </div>

    <!-- Navegación por pestañas -->
    <div class="tabs">
        <button class="tab active" onclick="showTab('clientes')">👥 Gestión de Clientes</button>
        <button class="tab" onclick="showTab('campanas')">📧 Campañas de Email</button>
        <button class="tab" onclick="showTab('estadisticas')">📊 Estadísticas</button>
        <button class="tab" onclick="showTab('importar')">📥 Importar Datos</button>
    </div>

    <!-- Pestaña: Gestión de Clientes -->
    <div id="clientes" class="tab-content active">
        <!-- Filtros y búsqueda -->
        <div style="background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
            <form method="get" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label>🔍 Buscar:</label>
                    <input type="text" name="buscar" value="<?php echo esc_attr($busqueda); ?>" placeholder="Nombre, email, empresa...">
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label>🏷️ Lista:</label>
                    <select name="lista">
                        <option value="">Todas las listas</option>
                        <?php foreach ($listas as $lista): ?>
                        <option value="<?php echo esc_attr($lista->lista); ?>" <?php selected($filtro_lista, $lista->lista); ?>>
                            <?php echo esc_html($lista->lista); ?> (<?php echo $lista->total; ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label>📊 Sector:</label>
                    <select name="sector">
                        <option value="">Todos los sectores</option>
                        <?php foreach ($sectores as $sector): ?>
                        <option value="<?php echo esc_attr($sector->sector); ?>" <?php selected($filtro_sector, $sector->sector); ?>>
                            <?php echo esc_html($sector->sector); ?> (<?php echo $sector->total; ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary" style="margin: 0;">Filtrar</button>
                    <a href="?#clientes" class="btn btn-secondary" style="margin: 0; padding: 12px 20px;">Limpiar</a>
                </div>
            </form>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 10px; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                <h3 style="margin: 0;">👥 Clientes (<?php echo $total_clientes_filtrados; ?> encontrados)</h3>
                <form method="get" style="display: flex; align-items: center; gap: 10px; margin: 0;">
                    <!-- Mantener filtros actuales -->
                    <?php if ($busqueda): ?><input type="hidden" name="buscar" value="<?php echo esc_attr($busqueda); ?>"><?php endif; ?>
                    <?php if ($filtro_lista): ?><input type="hidden" name="lista" value="<?php echo esc_attr($filtro_lista); ?>"><?php endif; ?>
                    <?php if ($filtro_sector): ?><input type="hidden" name="sector" value="<?php echo esc_attr($filtro_sector); ?>"><?php endif; ?>
                    
                    <label style="margin: 0; font-weight: 600; color: #2d3748;">Mostrar:</label>
                    <select name="por_pagina" onchange="this.form.submit()" style="padding: 8px 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">
                        <option value="10" <?php selected($por_pagina, 10); ?>>10</option>
                        <option value="25" <?php selected($por_pagina, 25); ?>>25</option>
                        <option value="50" <?php selected($por_pagina, 50); ?>>50</option>
                        <option value="100" <?php selected($por_pagina, 100); ?>>100</option>
                        <option value="-1" <?php selected($por_pagina, 999999); ?>>Todos</option>
                    </select>
                </form>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="?accion=exportar_excel<?php echo $busqueda ? '&buscar=' . urlencode($busqueda) : ''; ?><?php echo $filtro_lista ? '&lista=' . urlencode($filtro_lista) : ''; ?><?php echo $filtro_sector ? '&sector=' . urlencode($filtro_sector) : ''; ?>" class="btn" style="margin: 0; background: #28a745; color: white;">📊 Exportar Excel</a>
                <button onclick="toggleFormularioCliente()" class="btn btn-primary" style="margin: 0;">➕ Agregar Cliente</button>
                <a href="importar-todos-excel-crm.php" class="btn btn-success" style="margin: 0;">📥 Importar Excel</a>
            </div>
        </div>

        <!-- Formulario desplegable para agregar cliente -->
        <div id="formularioNuevoCliente" style="display: none; background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 20px; border: 2px solid #0066cc;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="margin: 0; color: #0066cc;">👤 Agregar Nuevo Cliente</h3>
                <button onclick="toggleFormularioCliente()" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 35px; height: 35px; font-size: 20px; cursor: pointer; font-weight: bold;">×</button>
            </div>
            <form method="post">
                <input type="hidden" name="accion" value="agregar_cliente">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Sector:</label>
                        <select name="sector">
                            <option value="Servicios">Servicios</option>
                            <option value="Electricidad">Electricidad</option>
                            <option value="Gestoría">Gestoría</option>
                            <option value="Asesoría">Asesoría</option>
                            <option value="Construcción">Construcción</option>
                            <option value="Industria">Industria</option>
                            <option value="Tecnología">Tecnología</option>
                            <option value="Educación">Educación</option>
                            <option value="Salud">Salud</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Empresa: *</label>
                        <input type="text" name="empresa" required placeholder="Instalaciones García SL">
                    </div>
                    <div class="form-group">
                        <label>Nombre Completo (Contacto):</label>
                        <input type="text" name="nombre" placeholder="Juan García López (opcional)">
                    </div>
                    <div class="form-group">
                        <label>Teléfono:</label>
                        <input type="tel" name="telefono" placeholder="925 123 456">
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" placeholder="info@empresa.com (opcional)">
                    </div>
                    <div class="form-group">
                        <label>Población:</label>
                        <input type="text" name="ciudad" placeholder="Talavera de la Reina">
                    </div>
                    <div class="form-group">
                        <label>Provincia:</label>
                        <input type="text" name="provincia" placeholder="Toledo">
                    </div>
                    <div class="form-group">
                        <label>Observaciones:</label>
                        <textarea name="notas" rows="2" placeholder="Notas adicionales..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Lista:</label>
                        <select name="lista" id="selectLista" onchange="toggleNuevaLista()">
                            <option value="">Sin lista</option>
                            <?php foreach ($listas as $lista): ?>
                            <option value="<?php echo esc_attr($lista->lista); ?>">
                                <?php echo esc_html($lista->lista); ?> (<?php echo $lista->total; ?> clientes)
                            </option>
                            <?php endforeach; ?>
                            <option value="__nueva__">➕ Crear nueva lista</option>
                        </select>
                    </div>
                    <div class="form-group" id="campoNuevaLista" style="display: none;">
                        <label>Nombre de la nueva lista: *</label>
                        <input type="text" name="nueva_lista" id="inputNuevaLista" placeholder="Ej: Clientes Madrid 2025">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">✅ Agregar Cliente</button>
            </form>
        </div>

        <h3>📋 Clientes Recientes</h3>
        <div style="overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sector</th>
                    <th>Empresa</th>
                    <th>Contacto</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Población</th>
                    <th>Provincia</th>
                    <th>Observaciones</th>
                    <th>Lista</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($clientes_recientes)): ?>
                <tr>
                    <td colspan="12" style="text-align: center; padding: 40px; color: #718096;">
                        No se encontraron clientes con los filtros seleccionados
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($clientes_recientes as $cliente): ?>
                <tr>
                    <td><strong>#<?php echo $cliente->id; ?></strong></td>
                    <td>
                        <?php if ($cliente->sector): ?>
                        <span class="badge badge-secondary"><?php echo esc_html($cliente->sector); ?></span>
                        <?php endif; ?>
                    </td>
                    <td><strong><?php echo esc_html($cliente->empresa); ?></strong></td>
                    <td><?php echo esc_html($cliente->nombre); ?></td>
                    <td><?php echo esc_html($cliente->telefono); ?></td>
                    <td><?php echo esc_html($cliente->email); ?></td>
                    <td><?php echo esc_html($cliente->ciudad); ?></td>
                    <td><?php echo esc_html($cliente->provincia); ?></td>
                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?php echo esc_attr($cliente->notas); ?>">
                        <?php echo esc_html($cliente->notas); ?>
                    </td>
                    <td>
                        <?php if ($cliente->lista): ?>
                        <span class="badge badge-info"><?php echo esc_html($cliente->lista); ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge badge-<?php echo $cliente->estado === 'activo' ? 'success' : 'warning'; ?>">
                            <?php echo ucfirst($cliente->estado); ?>
                        </span>
                    </td>
                    <td>
                        <button onclick="verDetalleCliente(<?php echo $cliente->id; ?>)" class="btn btn-primary" style="padding: 8px 15px; margin: 0; font-size: 13px;">
                            👁️ Ver
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        </div>

        <!-- Paginación -->
        <?php if ($total_paginas > 1): ?>
        <div style="display: flex; justify-content: center; align-items: center; gap: 10px; margin-top: 30px;">
            <?php if ($pagina_actual > 1): ?>
                <a href="?pagina=<?php echo $pagina_actual - 1; ?><?php echo $filtro_lista ? '&lista=' . urlencode($filtro_lista) : ''; ?><?php echo $filtro_sector ? '&sector=' . urlencode($filtro_sector) : ''; ?><?php echo $busqueda ? '&buscar=' . urlencode($busqueda) : ''; ?>#clientes" class="btn btn-secondary" style="margin: 0;">← Anterior</a>
            <?php endif; ?>
            
            <span style="padding: 10px 20px; background: #f8f9fa; border-radius: 8px; font-weight: 600;">
                Página <?php echo $pagina_actual; ?> de <?php echo $total_paginas; ?>
            </span>
            
            <?php if ($pagina_actual < $total_paginas): ?>
                <a href="?pagina=<?php echo $pagina_actual + 1; ?><?php echo $filtro_lista ? '&lista=' . urlencode($filtro_lista) : ''; ?><?php echo $filtro_sector ? '&sector=' . urlencode($filtro_sector) : ''; ?><?php echo $busqueda ? '&buscar=' . urlencode($busqueda) : ''; ?>#clientes" class="btn btn-secondary" style="margin: 0;">Siguiente →</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Pestaña: Campañas de Email -->
    <div id="campanas" class="tab-content">
        <h3>📧 Crear Nueva Campaña</h3>
        <form method="post">
            <input type="hidden" name="accion" value="crear_campana">
            <div class="form-grid">
                <div class="form-group">
                    <label>Nombre de la Campaña:</label>
                    <input type="text" name="nombre_campana" required placeholder="Ej: Promoción Cursos Enero 2025">
                </div>
                <div class="form-group">
                    <label>Asunto del Email:</label>
                    <input type="text" name="asunto_campana" required placeholder="Ej: ¡Nuevos cursos disponibles!">
                </div>
                <div class="form-group">
                    <label>Segmento de Clientes:</label>
                    <select name="segmento">
                        <option value="todos">Todos los Clientes</option>
                        <?php foreach ($sectores as $sector): ?>
                        <option value="<?php echo esc_attr($sector->sector); ?>">
                            <?php echo esc_html($sector->sector); ?> (<?php echo $sector->total; ?> clientes)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Contenido del Email:</label>
                <textarea name="contenido_campana" rows="10" required placeholder="Contenido HTML del email. Puedes usar [NOMBRE] y [EMPRESA] para personalizar."></textarea>
            </div>
            <button type="submit" class="btn btn-success">✨ Crear Campaña</button>
        </form>

        <h3>📋 Campañas Recientes</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Asunto</th>
                    <th>Segmento</th>
                    <th>Estado</th>
                    <th>Fecha Creación</th>
                    <th>Estadísticas</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($campanas_recientes as $campana): ?>
                <tr>
                    <td><?php echo esc_html($campana->nombre); ?></td>
                    <td><?php echo esc_html($campana->asunto); ?></td>
                    <td><?php echo esc_html($campana->segmento ?: 'Todos'); ?></td>
                    <td>
                        <span class="badge badge-<?php 
                            echo $campana->estado === 'enviada' ? 'success' : 
                                ($campana->estado === 'borrador' ? 'warning' : 'info'); 
                        ?>">
                            <?php echo ucfirst($campana->estado); ?>
                        </span>
                    </td>
                    <td><?php echo date('d/m/Y H:i', strtotime($campana->fecha_creacion)); ?></td>
                    <td>
                        <?php if ($campana->estado === 'enviada'): ?>
                            Enviados: <?php echo $campana->total_enviados; ?>/<?php echo $campana->total_destinatarios; ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($campana->estado === 'borrador'): ?>
                        <button 
                            class="btn btn-primary btn-seleccionar-destinatarios" 
                            data-campana-id="<?php echo $campana->id; ?>"
                            data-campana-nombre="<?php echo esc_attr($campana->nombre); ?>"
                            data-campana-segmento="<?php echo esc_attr($campana->segmento); ?>"
                            data-campana-asunto="<?php echo esc_attr($campana->asunto); ?>"
                            data-campana-contenido="<?php echo esc_attr($campana->contenido); ?>"
                            style="padding: 8px 15px; margin: 0 5px 0 0; font-size: 13px;">
                            👥 Seleccionar Destinatarios
                        </button>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="accion" value="enviar_campana">
                            <input type="hidden" name="campana_id" value="<?php echo $campana->id; ?>">
                            <button type="submit" class="btn btn-warning" style="padding: 8px 15px; margin: 0; font-size: 13px;" onclick="return confirm('¿Enviar a TODOS los clientes del segmento?')">
                                🚀 Enviar a Todos
                            </button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pestaña: Estadísticas -->
    <div id="estadisticas" class="tab-content">
        <h3>📊 Estadísticas del CRM</h3>
        
        <div class="dashboard-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo count($sectores); ?></div>
                <div class="stat-label">Sectores Diferentes</div>
            </div>
            <div class="stat-card campanas">
                <div class="stat-number">
                    <?php echo $wpdb->get_var("SELECT COUNT(*) FROM $table_clientes WHERE fecha_registro >= DATE_SUB(NOW(), INTERVAL 30 DAY)"); ?>
                </div>
                <div class="stat-label">Clientes Últimos 30 Días</div>
            </div>
            <div class="stat-card enviadas">
                <div class="stat-number">
                    <?php echo $wpdb->get_var("SELECT AVG(total_enviados) FROM $table_campanas WHERE estado = 'enviada'") ?: 0; ?>
                </div>
                <div class="stat-label">Promedio Emails por Campaña</div>
            </div>
        </div>

        <h4>📈 Distribución por Sectores</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Sector</th>
                    <th>Número de Clientes</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sectores as $sector): ?>
                <tr>
                    <td><?php echo esc_html($sector->sector); ?></td>
                    <td><?php echo $sector->total; ?></td>
                    <td><?php echo round(($sector->total / $total_clientes) * 100, 1); ?>%</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pestaña: Importar Datos -->
    <div id="importar" class="tab-content">
        <h3>📥 Importar Clientes desde Excel</h3>
        
        <!-- Botón destacado para descargar plantilla -->
        <div style="background: linear-gradient(135deg, #28a745, #20c997); padding: 30px; border-radius: 12px; margin: 20px 0; text-align: center; color: white;">
            <h2 style="color: white; margin-bottom: 15px;">📋 Plantilla Excel Unificada</h2>
            <p style="font-size: 16px; margin-bottom: 20px;">Descarga la plantilla con la estructura correcta para importar tus clientes</p>
            <a href="DESCARGAR-PLANTILLA-EXCEL.php" class="btn" style="background: white; color: #28a745; font-size: 18px; padding: 15px 40px; display: inline-block; margin: 5px;">
                ⬇️ DESCARGAR PLANTILLA.xlsx
            </a>
            <a href="PLANTILLA-EXCEL-VISUAL.php" class="btn" style="background: rgba(255,255,255,0.2); color: white; font-size: 16px; padding: 12px 30px; display: inline-block; margin: 5px;">
                📖 Ver Instrucciones Completas
            </a>
        </div>
        
        <div style="background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h4>📋 Estructura del Excel (8 columnas):</h4>
            <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                <thead>
                    <tr style="background: #667eea; color: white;">
                        <th style="padding: 10px; text-align: left;">Columna</th>
                        <th style="padding: 10px; text-align: left;">Nombre</th>
                        <th style="padding: 10px; text-align: left;">Ejemplo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="background: #f8f9fa;">
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">A</td>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>SECTOR</strong></td>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">Electricidad, Gestoría, Construcción</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">B</td>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>EMPRESA</strong> ✅ Obligatorio</td>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">Instalaciones García SL</td>
                    </tr>
                    <tr style="background: #f8f9fa;">
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">C</td>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>CONTACTO</strong></td>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">Juan García López</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">D</td>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>TELÉFONO</strong></td>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">925 123 456</td>
                    </tr>
                    <tr style="background: #f8f9fa;">
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">E</td>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>CORREO</strong></td>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">info@garcia.com</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">F</td>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>POBLACIÓN</strong></td>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">Talavera de la Reina</td>
                    </tr>
                    <tr style="background: #f8f9fa;">
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">G</td>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>PROVINCIA</strong></td>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">Toledo</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">H</td>
                        <td style="padding: 8px;"><strong>OBSERVACIONES</strong></td>
                        <td style="padding: 8px;">Cliente potencial, llamar en enero</td>
                    </tr>
                </tbody>
            </table>
            
            <div style="background: #fff3cd; padding: 15px; border-radius: 8px; margin-top: 20px; border-left: 5px solid #ffc107;">
                <strong>⚠️ IMPORTANTE:</strong> NO incluir columna ID. El ID se crea automáticamente al importar.
            </div>
        </div>
        
        <div style="background: white; padding: 25px; border-radius: 12px; border: 2px solid #667eea; margin: 20px 0;">
            <h4 style="color: #667eea; margin-bottom: 15px;">📤 Subir tu Archivo Excel</h4>
            <p style="margin-bottom: 20px;">Una vez que hayas preparado tu Excel con la estructura correcta, súbelo aquí:</p>
            
            <a href="importar-todos-excel-crm.php" class="btn btn-primary" style="font-size: 18px; padding: 15px 40px;">
                📥 IR AL IMPORTADOR COMPLETO
            </a>
            
            <p style="margin-top: 15px; color: #718096; font-size: 14px;">
                El importador validará emails, limpiará teléfonos, detectará duplicados y asignará listas automáticamente.
            </p>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin: 20px 0;">
            <div style="background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center;">
                <div style="font-size: 48px; margin-bottom: 10px;">🔢</div>
                <h4 style="color: #2d3748; margin-bottom: 8px;">ID Automático</h4>
                <p style="color: #718096; font-size: 14px;">El sistema crea el ID único automáticamente</p>
            </div>
            <div style="background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center;">
                <div style="font-size: 48px; margin-bottom: 10px;">✅</div>
                <h4 style="color: #2d3748; margin-bottom: 8px;">Validación</h4>
                <p style="color: #718096; font-size: 14px;">Valida emails y limpia teléfonos</p>
            </div>
            <div style="background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center;">
                <div style="font-size: 48px; margin-bottom: 10px;">🏷️</div>
                <h4 style="color: #2d3748; margin-bottom: 8px;">Listas Automáticas</h4>
                <p style="color: #718096; font-size: 14px;">Asigna listas según el archivo</p>
            </div>
            <div style="background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center;">
                <div style="font-size: 48px; margin-bottom: 10px;">🚫</div>
                <h4 style="color: #2d3748; margin-bottom: 8px;">Sin Duplicados</h4>
                <p style="color: #718096; font-size: 14px;">Detecta y omite duplicados</p>
            </div>
        </div>
    </div>
</div>

<div style="text-align: center; margin: 30px 0;">
    <a href="<?php echo home_url('/panel-gestion-unificado.php'); ?>" class="btn btn-primary">🏠 Volver al Panel de Gestión</a>
    <a href="<?php echo home_url('/'); ?>" class="btn btn-warning">🌐 Página Principal</a>
</div>

<!-- Modal para detalle de cliente -->
<div id="modalDetalleCliente" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 20px; padding: 40px; max-width: 700px; width: 90%; max-height: 90vh; overflow-y: auto; position: relative;">
        <button onclick="cerrarDetalleCliente()" style="position: absolute; top: 20px; right: 20px; background: #dc3545; color: white; border: none; border-radius: 50%; width: 40px; height: 40px; font-size: 20px; cursor: pointer; font-weight: bold;">×</button>
        <div id="contenidoDetalleCliente">
            <div style="text-align: center; padding: 40px;">
                <div style="font-size: 48px; margin-bottom: 20px;">⏳</div>
                <p>Cargando información del cliente...</p>
            </div>
        </div>
    </div>
</div>

<script>
// Event listener para botones de "Seleccionar Destinatarios"
document.addEventListener('DOMContentLoaded', function() {
    const botonesSeleccionar = document.querySelectorAll('.btn-seleccionar-destinatarios');
    botonesSeleccionar.forEach(boton => {
        boton.addEventListener('click', function() {
            const campanaId = this.dataset.campanaId;
            const campanaNombre = this.dataset.campanaNombre;
            const campanaSegmento = this.dataset.campanaSegmento;
            const campanaAsunto = this.dataset.campanaAsunto;
            const campanaContenido = this.dataset.campanaContenido;
            
            seleccionarDestinatarios(campanaId, campanaNombre, campanaSegmento, campanaAsunto, campanaContenido);
        });
    });
});

// Listas disponibles desde PHP
const listasDisponibles = <?php echo json_encode(array_map(function($lista) {
    return ['nombre' => $lista->lista, 'total' => $lista->total];
}, $listas)); ?>;

function showTab(tabName) {
    // Ocultar todas las pestañas
    const tabContents = document.querySelectorAll('.tab-content');
    const tabs = document.querySelectorAll('.tab');
    
    tabContents.forEach(content => content.classList.remove('active'));
    tabs.forEach(tab => tab.classList.remove('active'));
    
    // Mostrar la pestaña seleccionada
    document.getElementById(tabName).classList.add('active');
    event.target.classList.add('active');
}

function toggleFormularioCliente() {
    const formulario = document.getElementById('formularioNuevoCliente');
    if (formulario.style.display === 'none' || formulario.style.display === '') {
        formulario.style.display = 'block';
        // Scroll suave al formulario
        formulario.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    } else {
        formulario.style.display = 'none';
    }
}

function toggleNuevaLista() {
    const selectLista = document.getElementById('selectLista');
    const campoNuevaLista = document.getElementById('campoNuevaLista');
    const inputNuevaLista = document.getElementById('inputNuevaLista');
    
    if (selectLista.value === '__nueva__') {
        campoNuevaLista.style.display = 'block';
        inputNuevaLista.required = true;
        inputNuevaLista.focus();
    } else {
        campoNuevaLista.style.display = 'none';
        inputNuevaLista.required = false;
        inputNuevaLista.value = '';
    }
}

function toggleNuevaListaEdit() {
    const selectLista = document.getElementById('edit_lista');
    const campoNuevaLista = document.getElementById('campoNuevaListaEdit');
    const inputNuevaLista = document.getElementById('edit_nueva_lista');
    
    if (selectLista.value === '__nueva__') {
        campoNuevaLista.style.display = 'block';
        inputNuevaLista.required = true;
        inputNuevaLista.focus();
    } else {
        campoNuevaLista.style.display = 'none';
        inputNuevaLista.required = false;
        inputNuevaLista.value = '';
    }
}

function verDetalleCliente(clienteId) {
    const modal = document.getElementById('modalDetalleCliente');
    const contenido = document.getElementById('contenidoDetalleCliente');
    
    modal.style.display = 'flex';
    
    // Hacer petición AJAX para obtener detalles
    fetch('?accion=obtener_detalle_cliente&cliente_id=' + clienteId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const cliente = data.cliente;
                
                // Validar que email y teléfono no estén vacíos
                const tieneEmail = cliente.email && cliente.email.trim() !== '';
                const tieneTelefono = cliente.telefono && cliente.telefono.trim() !== '';
                
                const emailLink = tieneEmail ? `mailto:${cliente.email}` : '';
                const telLink = tieneTelefono ? `tel:${cliente.telefono.replace(/\s/g, '')}` : '';
                const whatsappLink = tieneTelefono ? `https://wa.me/34${cliente.telefono.replace(/\s/g, '')}` : '';
                
                // Generar botones solo si hay datos
                let botonesAccion = '';
                if (tieneEmail || tieneTelefono) {
                    // Crear enlace de Gmail con email prellenado
                    const gmailLink = tieneEmail ? `https://mail.google.com/mail/?view=cm&fs=1&to=${encodeURIComponent(cliente.email)}&su=${encodeURIComponent('Contacto desde CRM')}&body=${encodeURIComponent('Hola ' + cliente.nombre + ',\n\n')}` : '';
                    
                    botonesAccion = `
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 10px; margin-bottom: 25px;">
                        ${tieneEmail ? `
                        <a href="${gmailLink}" target="_blank" class="btn btn-primary" style="margin: 0; padding: 12px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            📧 Enviar Email
                        </a>
                        ` : ''}
                        
                        ${tieneTelefono ? `
                        <a href="${telLink}" class="btn btn-success" style="margin: 0; padding: 12px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            📞 Llamar
                        </a>
                        <a href="${whatsappLink}" target="_blank" class="btn" style="margin: 0; padding: 12px; background: #25D366; color: white; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            💬 WhatsApp
                        </a>
                        ` : ''}
                    </div>
                    `;
                } else {
                    botonesAccion = `
                    <div style="background: #fff3cd; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; border-left: 4px solid #ffc107;">
                        <strong style="color: #856404;">⚠️ Sin datos de contacto</strong>
                        <p style="color: #856404; margin: 5px 0 0 0; font-size: 14px;">Este cliente no tiene email ni teléfono registrado</p>
                    </div>
                    `;
                }
                
                contenido.innerHTML = `
                    <div style="text-align: center; margin-bottom: 25px;">
                        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #0066cc, #0052a3); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 36px; color: white; margin-bottom: 15px;">
                            👤
                        </div>
                        <h2 style="color: #2d3748; margin: 0 0 5px 0;">${cliente.nombre || 'Sin nombre'}</h2>
                        <p style="color: #718096; margin: 0;">${cliente.empresa || 'Sin empresa'}</p>
                    </div>
                    
                    <!-- Botones de acción rápida -->
                    ${botonesAccion}
                    
                    <!-- Información detallada -->
                    <div style="background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                        <h3 style="color: #2d3748; margin: 0 0 15px 0; font-size: 16px; text-transform: uppercase; letter-spacing: 1px;">📋 Información de Contacto</h3>
                        <div style="display: grid; gap: 12px;">
                            ${tieneEmail ? `
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px; background: white; border-radius: 8px;">
                                <span style="color: #718096; font-weight: 600;">📧 Email:</span>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <span style="color: #2d3748;">${cliente.email}</span>
                                    <button onclick="copiarEmail('${cliente.email}')" class="btn btn-primary" style="padding: 6px 12px; margin: 0; font-size: 12px;">
                                        📋 Copiar
                                    </button>
                                </div>
                            </div>
                            ` : `
                            <div style="display: flex; justify-content: space-between; padding: 10px; background: white; border-radius: 8px;">
                                <span style="color: #718096; font-weight: 600;">📧 Email:</span>
                                <span style="color: #718096;">No especificado</span>
                            </div>
                            `}
                            <div style="display: flex; justify-content: space-between; padding: 10px; background: white; border-radius: 8px;">
                                <span style="color: #718096; font-weight: 600;">📱 Teléfono:</span>
                                <span style="color: #2d3748;">${cliente.telefono || 'No especificado'}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 10px; background: white; border-radius: 8px;">
                                <span style="color: #718096; font-weight: 600;">🏢 Empresa:</span>
                                <span style="color: #2d3748;">${cliente.empresa || 'No especificada'}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div style="background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                        <h3 style="color: #2d3748; margin: 0 0 15px 0; font-size: 16px; text-transform: uppercase; letter-spacing: 1px;">📍 Ubicación</h3>
                        <div style="display: grid; gap: 12px;">
                            <div style="display: flex; justify-content: space-between; padding: 10px; background: white; border-radius: 8px;">
                                <span style="color: #718096; font-weight: 600;">🏙️ Ciudad:</span>
                                <span style="color: #2d3748;">${cliente.ciudad || 'No especificada'}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 10px; background: white; border-radius: 8px;">
                                <span style="color: #718096; font-weight: 600;">🗺️ Provincia:</span>
                                <span style="color: #2d3748;">${cliente.provincia || 'No especificada'}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div style="background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                        <h3 style="color: #2d3748; margin: 0 0 15px 0; font-size: 16px; text-transform: uppercase; letter-spacing: 1px;">📊 Clasificación</h3>
                        <div style="display: grid; gap: 12px;">
                            <div style="display: flex; justify-content: space-between; padding: 10px; background: white; border-radius: 8px;">
                                <span style="color: #718096; font-weight: 600;">🏷️ Sector:</span>
                                <span class="badge badge-info" style="padding: 6px 12px;">${cliente.sector || 'No especificado'}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 10px; background: white; border-radius: 8px;">
                                <span style="color: #718096; font-weight: 600;">📋 Lista:</span>
                                <span class="badge badge-info" style="padding: 6px 12px;">${cliente.lista || 'Sin lista'}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 10px; background: white; border-radius: 8px;">
                                <span style="color: #718096; font-weight: 600;">🔄 Estado:</span>
                                <span class="badge badge-success" style="padding: 6px 12px;">${cliente.estado || 'Activo'}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 10px; background: white; border-radius: 8px;">
                                <span style="color: #718096; font-weight: 600;">📥 Origen:</span>
                                <span style="color: #2d3748;">${cliente.origen || 'No especificado'}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 10px; background: white; border-radius: 8px;">
                                <span style="color: #718096; font-weight: 600;">📅 Registro:</span>
                                <span style="color: #2d3748;">${cliente.fecha_registro}</span>
                            </div>
                        </div>
                    </div>
                    
                    ${cliente.notas ? `
                    <div style="background: #fff3cd; padding: 20px; border-radius: 12px; margin-bottom: 20px; border-left: 4px solid #ffc107;">
                        <h3 style="color: #856404; margin: 0 0 10px 0; font-size: 16px;">📝 Observaciones</h3>
                        <div style="color: #856404; line-height: 1.6;">${cliente.notas}</div>
                    </div>
                    ` : ''}
                    
                    <div style="display: flex; gap: 10px; justify-content: center; margin-top: 25px; flex-wrap: wrap;">
                        <button onclick="editarCliente(${cliente.id})" class="btn btn-warning" style="margin: 0;">✏️ Editar</button>
                        <button onclick="cerrarDetalleCliente()" class="btn" style="background: #6c757d; color: white; margin: 0;">Cerrar</button>
                    </div>
                `;
                
                // Guardar datos del cliente para edición
                window.clienteActual = cliente;
            } else {
                contenido.innerHTML = `
                    <div style="text-align: center; padding: 40px;">
                        <div style="font-size: 48px; margin-bottom: 20px;">❌</div>
                        <p style="color: #dc3545; font-size: 18px; font-weight: 600;">Error al cargar los datos del cliente</p>
                        <button onclick="cerrarDetalleCliente()" class="btn btn-secondary" style="margin-top: 20px;">Cerrar</button>
                    </div>
                `;
            }
        })
        .catch(error => {
            contenido.innerHTML = `
                <div style="text-align: center; padding: 40px;">
                    <div style="font-size: 48px; margin-bottom: 20px;">❌</div>
                    <p style="color: #dc3545; font-size: 18px; font-weight: 600;">Error de conexión</p>
                    <p style="color: #718096; margin-top: 10px;">No se pudo conectar con el servidor</p>
                    <button onclick="cerrarDetalleCliente()" class="btn btn-secondary" style="margin-top: 20px;">Cerrar</button>
                </div>
            `;
        });
}

function cerrarDetalleCliente() {
    document.getElementById('modalDetalleCliente').style.display = 'none';
}

function editarCliente(clienteId) {
    const cliente = window.clienteActual;
    const contenido = document.getElementById('contenidoDetalleCliente');
    
    // Generar opciones de lista dinámicamente
    let opcionesLista = '<option value="">Sin lista</option>';
    listasDisponibles.forEach(lista => {
        const selected = cliente.lista === lista.nombre ? 'selected' : '';
        opcionesLista += `<option value="${lista.nombre}" ${selected}>${lista.nombre} (${lista.total} clientes)</option>`;
    });
    opcionesLista += '<option value="__nueva__">➕ Crear nueva lista</option>';
    
    contenido.innerHTML = `
        <h2 style="color: #2d3748; margin-bottom: 25px; text-align: center;">✏️ Editar Cliente</h2>
        
        <form id="formEditarCliente" style="display: grid; gap: 15px;">
            <input type="hidden" id="edit_cliente_id" value="${cliente.id}">
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">
                <div>
                    <label style="font-weight: 700; color: #2d3748; display: block; margin-bottom: 5px;">Nombre Completo:</label>
                    <input type="text" id="edit_nombre" value="${cliente.nombre}" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px;">
                </div>
                
                <div>
                    <label style="font-weight: 700; color: #2d3748; display: block; margin-bottom: 5px;">Email:</label>
                    <input type="email" id="edit_email" value="${cliente.email}" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px;" placeholder="Opcional">
                </div>
                
                <div>
                    <label style="font-weight: 700; color: #2d3748; display: block; margin-bottom: 5px;">Teléfono:</label>
                    <input type="tel" id="edit_telefono" value="${cliente.telefono}" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px;">
                </div>
                
                <div>
                    <label style="font-weight: 700; color: #2d3748; display: block; margin-bottom: 5px;">Empresa:</label>
                    <input type="text" id="edit_empresa" value="${cliente.empresa}" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px;">
                </div>
                
                <div>
                    <label style="font-weight: 700; color: #2d3748; display: block; margin-bottom: 5px;">Ciudad:</label>
                    <input type="text" id="edit_ciudad" value="${cliente.ciudad}" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px;">
                </div>
                
                <div>
                    <label style="font-weight: 700; color: #2d3748; display: block; margin-bottom: 5px;">Provincia:</label>
                    <input type="text" id="edit_provincia" value="${cliente.provincia}" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px;">
                </div>
                
                <div>
                    <label style="font-weight: 700; color: #2d3748; display: block; margin-bottom: 5px;">Sector:</label>
                    <select id="edit_sector" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px;">
                        <option value="Servicios" ${cliente.sector === 'Servicios' ? 'selected' : ''}>Servicios</option>
                        <option value="Electricidad" ${cliente.sector === 'Electricidad' ? 'selected' : ''}>Electricidad</option>
                        <option value="Gestoría" ${cliente.sector === 'Gestoría' ? 'selected' : ''}>Gestoría</option>
                        <option value="Asesoría" ${cliente.sector === 'Asesoría' ? 'selected' : ''}>Asesoría</option>
                        <option value="Construcción" ${cliente.sector === 'Construcción' ? 'selected' : ''}>Construcción</option>
                        <option value="Industria" ${cliente.sector === 'Industria' ? 'selected' : ''}>Industria</option>
                        <option value="Tecnología" ${cliente.sector === 'Tecnología' ? 'selected' : ''}>Tecnología</option>
                        <option value="Educación" ${cliente.sector === 'Educación' ? 'selected' : ''}>Educación</option>
                        <option value="Salud" ${cliente.sector === 'Salud' ? 'selected' : ''}>Salud</option>
                        <option value="Otro" ${cliente.sector === 'Otro' ? 'selected' : ''}>Otro</option>
                    </select>
                </div>
                
                <div>
                    <label style="font-weight: 700; color: #2d3748; display: block; margin-bottom: 5px;">Lista:</label>
                    <select id="edit_lista" onchange="toggleNuevaListaEdit()" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px;">
                        ${opcionesLista}
                    </select>
                </div>
                
                <div id="campoNuevaListaEdit" style="display: none;">
                    <label style="font-weight: 700; color: #2d3748; display: block; margin-bottom: 5px;">Nueva lista: *</label>
                    <input type="text" id="edit_nueva_lista" placeholder="Nombre de la nueva lista" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px;">
                </div>
            </div>
            
            <div>
                <label style="font-weight: 700; color: #2d3748; display: block; margin-bottom: 5px;">Observaciones:</label>
                <textarea id="edit_notas" rows="4" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px;">${cliente.notas}</textarea>
            </div>
            
            <div style="display: flex; gap: 10px; justify-content: center; margin-top: 20px; flex-wrap: wrap;">
                <button type="button" onclick="guardarCliente()" class="btn btn-success" style="margin: 0;">💾 Guardar Cambios</button>
                <button type="button" onclick="verDetalleCliente(${cliente.id})" class="btn" style="background: #6c757d; color: white; margin: 0;">Cancelar</button>
            </div>
        </form>
    `;
}

function guardarCliente() {
    const clienteId = document.getElementById('edit_cliente_id').value;
    const formData = new FormData();
    
    // Manejar lista (nueva o existente)
    const listaSeleccionada = document.getElementById('edit_lista').value;
    let lista = listaSeleccionada;
    if (listaSeleccionada === '__nueva__') {
        const nuevaLista = document.getElementById('edit_nueva_lista').value.trim();
        if (!nuevaLista) {
            alert('⚠️ Debes escribir el nombre de la nueva lista');
            document.getElementById('edit_nueva_lista').focus();
            return;
        }
        lista = nuevaLista;
    }
    
    formData.append('accion', 'actualizar_cliente');
    formData.append('cliente_id', clienteId);
    formData.append('nombre', document.getElementById('edit_nombre').value);
    formData.append('email', document.getElementById('edit_email').value);
    formData.append('telefono', document.getElementById('edit_telefono').value);
    formData.append('empresa', document.getElementById('edit_empresa').value);
    formData.append('ciudad', document.getElementById('edit_ciudad').value);
    formData.append('provincia', document.getElementById('edit_provincia').value);
    formData.append('sector', document.getElementById('edit_sector').value);
    formData.append('lista', lista);
    formData.append('notas', document.getElementById('edit_notas').value);
    
    // Mostrar mensaje de carga
    const contenido = document.getElementById('contenidoDetalleCliente');
    contenido.innerHTML = `
        <div style="text-align: center; padding: 40px;">
            <div style="font-size: 48px; margin-bottom: 20px;">⏳</div>
            <p>Guardando cambios...</p>
        </div>
    `;
    
    fetch('', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            contenido.innerHTML = `
                <div style="text-align: center; padding: 40px;">
                    <div style="font-size: 48px; margin-bottom: 20px;">✅</div>
                    <p style="color: #28a745; font-size: 18px; font-weight: 600;">¡Cliente actualizado correctamente!</p>
                    ${listaSeleccionada === '__nueva__' ? `<p style="color: #718096; margin-top: 10px;">Nueva lista "<strong>${lista}</strong>" creada</p>` : ''}
                    <button onclick="location.reload()" class="btn btn-success" style="margin-top: 20px;">Recargar Página</button>
                </div>
            `;
        } else {
            contenido.innerHTML = `
                <div style="text-align: center; padding: 40px;">
                    <div style="font-size: 48px; margin-bottom: 20px;">❌</div>
                    <p style="color: #dc3545; font-size: 18px; font-weight: 600;">Error al guardar</p>
                    <p style="color: #718096; margin-top: 10px;">${data.error || 'Error desconocido'}</p>
                    <button onclick="editarCliente(${clienteId})" class="btn btn-warning" style="margin-top: 20px;">Volver a Editar</button>
                </div>
            `;
        }
    })
    .catch(error => {
        contenido.innerHTML = `
            <div style="text-align: center; padding: 40px;">
                <div style="font-size: 48px; margin-bottom: 20px;">❌</div>
                <p style="color: #dc3545; font-size: 18px; font-weight: 600;">Error de conexión</p>
                <button onclick="editarCliente(${clienteId})" class="btn btn-warning" style="margin-top: 20px;">Volver a Editar</button>
            </div>
        `;
    });
}

// Auto-resize textareas
document.addEventListener('DOMContentLoaded', function() {
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    });
    
    // Cerrar modal al hacer clic fuera
    document.getElementById('modalDetalleCliente').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarDetalleCliente();
        }
    });
    
    // Cerrar modal de destinatarios al hacer clic fuera
    const modalDestinatarios = document.getElementById('modalSeleccionarDestinatarios');
    if (modalDestinatarios) {
        modalDestinatarios.addEventListener('click', function(e) {
            if (e.target === this) {
                cerrarSeleccionDestinatarios();
            }
        });
    }
});

// Funciones para selección de destinatarios
function seleccionarDestinatarios(campanaId, campanaNombre, segmento, campanaAsunto, campanaContenido) {
    const modal = document.getElementById('modalSeleccionarDestinatarios');
    const contenido = document.getElementById('contenidoSeleccionDestinatarios');
    
    // Guardar datos de la campaña en el modal para usarlos después
    modal.dataset.campanaId = campanaId;
    modal.dataset.campanaNombre = campanaNombre;
    modal.dataset.campanaAsunto = campanaAsunto;
    modal.dataset.campanaContenido = campanaContenido;
    
    modal.style.display = 'flex';
    
    // Mostrar cargando
    contenido.innerHTML = `
        <div style="text-align: center; padding: 40px;">
            <div style="font-size: 48px; margin-bottom: 20px;">⏳</div>
            <p>Cargando clientes...</p>
        </div>
    `;
    
    // Cargar clientes según segmento
    let url = '?accion=obtener_clientes_para_campana';
    if (segmento && segmento !== 'todos') {
        url += '&segmento=' + encodeURIComponent(segmento);
    }
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarListaDestinatarios(data.clientes, campanaId, campanaNombre);
            } else {
                contenido.innerHTML = `
                    <div style="text-align: center; padding: 40px;">
                        <div style="font-size: 48px; margin-bottom: 20px;">❌</div>
                        <p style="color: #dc3545;">Error al cargar clientes</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            contenido.innerHTML = `
                <div style="text-align: center; padding: 40px;">
                    <div style="font-size: 48px; margin-bottom: 20px;">❌</div>
                    <p style="color: #dc3545;">Error de conexión</p>
                </div>
            `;
        });
}

function mostrarListaDestinatarios(clientes, campanaId, campanaNombre) {
    const contenido = document.getElementById('contenidoSeleccionDestinatarios');
    
    const clientesConEmail = clientes.filter(c => c.email && c.email !== '');
    const clientesSinEmail = clientes.filter(c => !c.email || c.email === '');
    
    contenido.innerHTML = `
        <h2 style="color: #2d3748; margin-bottom: 10px; text-align: center;">📧 Seleccionar Destinatarios</h2>
        <p style="text-align: center; color: #718096; margin-bottom: 25px;">Campaña: <strong>${campanaNombre}</strong></p>
        
        <!-- BUSCADOR EN TIEMPO REAL -->
        <div style="background: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 2px solid #0066cc;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 24px;">🔍</span>
                <input type="text" id="buscadorDestinatarios" placeholder="Buscar por empresa, nombre, email, teléfono o sector..." style="flex: 1; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;" oninput="filtrarDestinatarios()">
                <button onclick="document.getElementById('buscadorDestinatarios').value=''; filtrarDestinatarios();" class="btn" style="background: #6c757d; color: white; padding: 10px 20px; margin: 0;">
                    ❌ Limpiar
                </button>
            </div>
            <div id="resultadosBusqueda" style="margin-top: 10px; color: #718096; font-size: 14px;">
                Mostrando <strong id="clientesMostrados">${clientesConEmail.length}</strong> de <strong>${clientesConEmail.length}</strong> clientes
            </div>
        </div>
        
        <div style="background: #e7f3ff; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
            <div>
                <strong style="color: #0066cc;">Total clientes con email: ${clientesConEmail.length}</strong>
                ${clientesSinEmail.length > 0 ? `<br><span style="color: #718096; font-size: 14px;">(${clientesSinEmail.length} sin email - no se pueden enviar)</span>` : ''}
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <button onclick="seleccionarTodosVisibles()" class="btn btn-primary" style="padding: 8px 15px; margin: 0; font-size: 13px;">✅ Seleccionar Visibles</button>
                <button onclick="seleccionarTodos()" class="btn btn-primary" style="padding: 8px 15px; margin: 0; font-size: 13px;">✅ Seleccionar Todos</button>
                <button onclick="deseleccionarTodos()" class="btn" style="background: #6c757d; color: white; padding: 8px 15px; margin: 0; font-size: 13px;">❌ Deseleccionar Todos</button>
            </div>
        </div>
        
        <form id="formEnviarCampana" method="post">
            <input type="hidden" name="accion" value="enviar_campana">
            <input type="hidden" name="campana_id" value="${campanaId}">
            
            <div id="listaDestinatarios" style="max-height: 400px; overflow-y: auto; background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                ${clientesConEmail.length > 0 ? `
                    <div style="display: grid; gap: 10px;">
                        ${clientesConEmail.map(cliente => `
                            <label class="item-destinatario" data-empresa="${(cliente.empresa || '').toLowerCase()}" data-nombre="${(cliente.nombre || '').toLowerCase()}" data-email="${(cliente.email || '').toLowerCase()}" data-telefono="${(cliente.telefono || '').toLowerCase()}" data-sector="${(cliente.sector || '').toLowerCase()}" style="display: flex; align-items: center; padding: 12px; background: white; border-radius: 8px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#e7f3ff'" onmouseout="this.style.background='white'">
                                <input type="checkbox" name="clientes_seleccionados[]" value="${cliente.id}" class="checkbox-destinatario" style="width: 20px; height: 20px; margin-right: 15px; cursor: pointer;">
                                <div style="flex: 1;">
                                    <div style="font-weight: 700; color: #2d3748; margin-bottom: 3px;">${cliente.empresa || 'Sin empresa'}</div>
                                    <div style="font-size: 14px; color: #718096;">
                                        👤 ${cliente.nombre || 'Sin nombre'} | 
                                        📧 ${cliente.email} | 
                                        📱 ${cliente.telefono || 'Sin teléfono'}
                                        ${cliente.sector ? ` | 🏷️ ${cliente.sector}` : ''}
                                    </div>
                                </div>
                            </label>
                        `).join('')}
                    </div>
                ` : `
                    <div style="text-align: center; padding: 40px; color: #718096;">
                        <div style="font-size: 48px; margin-bottom: 15px;">📭</div>
                        <p>No hay clientes con email en este segmento</p>
                    </div>
                `}
            </div>
            
            ${clientesConEmail.length > 0 ? `
                <div style="background: #e7f3ff; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #0066cc;">
                    <strong style="color: #0066cc;">💡 Dos formas de enviar:</strong>
                    <p style="color: #2d3748; margin: 5px 0 0 0; font-size: 14px;">
                        <strong><span id="contadorSeleccionados">0</span> destinatarios seleccionados</strong><br>
                        • <strong>Abrir en Gmail:</strong> Envía desde tu Gmail personal (recomendado, no necesita SMTP)<br>
                        • <strong>Enviar automático:</strong> Envía desde el servidor (necesita SMTP configurado)
                    </p>
                </div>
                
                <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                    <button type="button" onclick="previsualizarEmail()" class="btn" style="background: #17a2b8; color: white; margin: 0; padding: 15px 30px; font-size: 16px;">
                        👁️ Vista Previa
                    </button>
                    <button type="submit" class="btn btn-primary" style="margin: 0; padding: 15px 30px; font-size: 16px;" onclick="return confirmarEnvioPersonalizado()">
                        📧 Enviar Emails
                    </button>
                    <button type="button" onclick="abrirEnGmail()" class="btn" style="background: #6c757d; color: white; margin: 0; padding: 12px 20px; font-size: 14px;">
                        📨 Abrir en Gmail (alternativa)
                    </button>
                    <button type="button" onclick="cerrarSeleccionDestinatarios()" class="btn" style="background: #6c757d; color: white; margin: 0; padding: 15px 30px; font-size: 16px;">
                        Cancelar
                    </button>
                </div>
            ` : ''}
        </form>
    `;
    
    // Actualizar contador cuando cambian los checkboxes
    const checkboxes = document.querySelectorAll('.checkbox-destinatario');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', actualizarContador);
    });
}

function seleccionarTodos() {
    const checkboxes = document.querySelectorAll('.checkbox-destinatario');
    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
    actualizarContador();
}

function deseleccionarTodos() {
    const checkboxes = document.querySelectorAll('.checkbox-destinatario');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    actualizarContador();
}

function actualizarContador() {
    const checkboxes = document.querySelectorAll('.checkbox-destinatario:checked');
    const contador = document.getElementById('contadorSeleccionados');
    if (contador) {
        contador.textContent = checkboxes.length;
    }
}

// Función para filtrar destinatarios en tiempo real
function filtrarDestinatarios() {
    const buscador = document.getElementById('buscadorDestinatarios');
    const filtro = buscador.value.toLowerCase().trim();
    const items = document.querySelectorAll('.item-destinatario');
    
    let visibles = 0;
    
    items.forEach(item => {
        const empresa = item.dataset.empresa || '';
        const nombre = item.dataset.nombre || '';
        const email = item.dataset.email || '';
        const telefono = item.dataset.telefono || '';
        const sector = item.dataset.sector || '';
        
        // Buscar en todos los campos
        const coincide = empresa.includes(filtro) || 
                        nombre.includes(filtro) || 
                        email.includes(filtro) || 
                        telefono.includes(filtro) || 
                        sector.includes(filtro);
        
        if (coincide) {
            item.style.display = 'flex';
            visibles++;
        } else {
            item.style.display = 'none';
        }
    });
    
    // Actualizar contador de resultados
    const clientesMostrados = document.getElementById('clientesMostrados');
    if (clientesMostrados) {
        clientesMostrados.textContent = visibles;
    }
    
    // Mostrar mensaje si no hay resultados
    const listaDestinatarios = document.getElementById('listaDestinatarios');
    const mensajeNoResultados = document.getElementById('mensajeNoResultados');
    
    if (visibles === 0 && filtro !== '') {
        if (!mensajeNoResultados) {
            const mensaje = document.createElement('div');
            mensaje.id = 'mensajeNoResultados';
            mensaje.style.cssText = 'text-align: center; padding: 40px; color: #718096;';
            mensaje.innerHTML = `
                <div style="font-size: 48px; margin-bottom: 15px;">🔍</div>
                <p><strong>No se encontraron resultados para "${filtro}"</strong></p>
                <p style="font-size: 14px; margin-top: 10px;">Intenta con otro término de búsqueda</p>
            `;
            listaDestinatarios.appendChild(mensaje);
        }
    } else if (mensajeNoResultados) {
        mensajeNoResultados.remove();
    }
}

// Función para seleccionar solo los destinatarios visibles (filtrados)
function seleccionarTodosVisibles() {
    const items = document.querySelectorAll('.item-destinatario');
    items.forEach(item => {
        if (item.style.display !== 'none') {
            const checkbox = item.querySelector('.checkbox-destinatario');
            if (checkbox) {
                checkbox.checked = true;
            }
        }
    });
    actualizarContador();
}

function actualizarContador() {
    const checkboxes = document.querySelectorAll('.checkbox-destinatario:checked');
    const contador = document.getElementById('contadorSeleccionados');
    if (contador) {
        contador.textContent = checkboxes.length;
    }
}

function confirmarEnvio() {
    const checkboxes = document.querySelectorAll('.checkbox-destinatario:checked');
    if (checkboxes.length === 0) {
        alert('⚠️ Debes seleccionar al menos un destinatario');
        return false;
    }
    return confirm(`¿Enviar campaña a ${checkboxes.length} destinatarios seleccionados?`);
}

function cerrarSeleccionDestinatarios() {
    document.getElementById('modalSeleccionarDestinatarios').style.display = 'none';
}

// Función para abrir Gmail con destinatarios seleccionados
function abrirEnGmail() {
    const checkboxes = document.querySelectorAll('.checkbox-destinatario:checked');
    
    if (checkboxes.length === 0) {
        alert('⚠️ Debes seleccionar al menos un destinatario');
        return;
    }
    
    // Recopilar todos los emails seleccionados
    const emails = [];
    checkboxes.forEach(checkbox => {
        const clienteDiv = checkbox.closest('label');
        const emailMatch = clienteDiv.textContent.match(/📧\s*([^\s|]+)/);
        if (emailMatch && emailMatch[1]) {
            emails.push(emailMatch[1].trim());
        }
    });
    
    if (emails.length === 0) {
        alert('⚠️ No se encontraron emails válidos en los destinatarios seleccionados');
        return;
    }
    
    // Obtener datos de la campaña del modal
    const modal = document.getElementById('modalSeleccionarDestinatarios');
    const campanaAsunto = modal.dataset.campanaAsunto || 'Campaña';
    const campanaContenido = modal.dataset.campanaContenido || 'Hola,\n\n[Escribe aquí tu mensaje]\n\nSaludos,\nMongruas Formación';
    
    // Crear enlace de Gmail con CCO (BCC)
    // Nota: Gmail tiene un límite de ~2000 caracteres en la URL
    const bccEmails = emails.join(',');
    const asunto = encodeURIComponent(campanaAsunto);
    
    // Convertir HTML a texto plano si es necesario
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = campanaContenido;
    const contenidoTexto = tempDiv.textContent || tempDiv.innerText || campanaContenido;
    const cuerpo = encodeURIComponent(contenidoTexto);
    
    // Construir URL de Gmail
    const gmailUrl = `https://mail.google.com/mail/?view=cm&fs=1&bcc=${encodeURIComponent(bccEmails)}&su=${asunto}&body=${cuerpo}`;
    
    // Verificar si la URL es demasiado larga
    if (gmailUrl.length > 2000) {
        // Si hay muchos destinatarios, mostrar los emails para copiar manualmente
        const emailsList = emails.join('; ');
        const mensaje = `📧 Hay ${emails.length} destinatarios.\n\nCopia estos emails y pégalos en el campo CCO de Gmail:\n\n${emailsList}`;
        
        // Copiar al portapapeles
        const tempInput = document.createElement('textarea');
        tempInput.value = emailsList;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        
        alert(mensaje + '\n\n✅ Emails copiados al portapapeles!');
        
        // Abrir Gmail con asunto y contenido (sin destinatarios)
        const gmailUrlSinDestinatarios = `https://mail.google.com/mail/?view=cm&fs=1&su=${asunto}&body=${cuerpo}`;
        window.open(gmailUrlSinDestinatarios, '_blank');
    } else {
        // Abrir Gmail con todos los destinatarios en CCO
        window.open(gmailUrl, '_blank');
        
        // Mostrar mensaje de confirmación
        alert(`✅ Se abrirá Gmail con ${emails.length} destinatarios en CCO (copia oculta).\n\nEl asunto y contenido de la campaña ya están prellenados!`);
    }
    
    // Cerrar el modal
    cerrarSeleccionDestinatarios();
}

// Función para copiar email al portapapeles
function copiarEmail(email) {
    // Crear elemento temporal
    const tempInput = document.createElement('input');
    tempInput.value = email;
    document.body.appendChild(tempInput);
    tempInput.select();
    
    try {
        // Copiar al portapapeles
        document.execCommand('copy');
        
        // Mostrar mensaje de éxito
        const mensaje = document.createElement('div');
        mensaje.innerHTML = `
            <div style="position: fixed; top: 20px; right: 20px; background: #28a745; color: white; padding: 15px 25px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.3); z-index: 99999; animation: slideIn 0.3s ease;">
                <strong>✅ Email copiado!</strong><br>
                <span style="font-size: 14px;">${email}</span>
            </div>
        `;
        document.body.appendChild(mensaje);
        
        // Eliminar mensaje después de 3 segundos
        setTimeout(() => {
            mensaje.remove();
        }, 3000);
    } catch (err) {
        alert('Email: ' + email + '\n\n(Copia manualmente)');
    }
    
    // Eliminar elemento temporal
    document.body.removeChild(tempInput);
}
</script>

<!-- Modal para seleccionar destinatarios -->
<div id="modalSeleccionarDestinatarios" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 20px; padding: 40px; max-width: 900px; width: 90%; max-height: 90vh; overflow-y: auto; position: relative;">
        <button onclick="cerrarSeleccionDestinatarios()" style="position: absolute; top: 20px; right: 20px; background: #dc3545; color: white; border: none; border-radius: 50%; width: 40px; height: 40px; font-size: 20px; cursor: pointer; font-weight: bold;">×</button>
        <div id="contenidoSeleccionDestinatarios">
            <div style="text-align: center; padding: 40px;">
                <div style="font-size: 48px; margin-bottom: 20px;">⏳</div>
                <p>Cargando...</p>
            </div>
        </div>
    </div>
</div>
<?php
/**
 * Importador Inteligente de Excel al CRM
 * Lee archivos .xlsx directamente y detecta automáticamente la estructura
 * Separa correctamente: empresa, contacto, teléfono, email, ciudad, provincia
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

global $wpdb;
$table_name = $wpdb->prefix . 'mongruas_clientes';

// Crear tabla con estructura completa - EMAIL NO OBLIGATORIO
$charset_collate = $wpdb->get_charset_collate();
$sql = "CREATE TABLE IF NOT EXISTS $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    nombre varchar(255) NOT NULL,
    email varchar(255) DEFAULT '',
    telefono varchar(50) DEFAULT '',
    empresa varchar(255) DEFAULT '',
    direccion varchar(255) DEFAULT '',
    ciudad varchar(100) DEFAULT '',
    provincia varchar(100) DEFAULT '',
    codigo_postal varchar(10) DEFAULT '',
    sector varchar(100) DEFAULT 'Servicios',
    interes varchar(255) DEFAULT '',
    lista varchar(100) DEFAULT '',
    origen varchar(50) DEFAULT 'Manual',
    estado varchar(20) DEFAULT 'activo',
    notas text DEFAULT '',
    fecha_registro datetime DEFAULT CURRENT_TIMESTAMP,
    ultima_actividad datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY  (id),
    KEY email (email),
    KEY sector (sector),
    KEY lista (lista),
    KEY estado (estado)
) $charset_collate;";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);

$mensaje = '';
$tipo_mensaje = '';
$importados = 0;
$errores = 0;
$duplicados = 0;
$detalles = [];

/**
 * Función para leer archivos Excel (.xlsx)
 * VERSIÓN MEJORADA: Lee por posición de columna (A, B, C...) no por índice
 */
function leer_excel($archivo_path) {
    $datos = [];
    
    // Verificar que el archivo existe
    if (!file_exists($archivo_path)) {
        return ['error' => 'Archivo no encontrado'];
    }
    
    // Los archivos .xlsx son archivos ZIP
    $zip = new ZipArchive;
    if ($zip->open($archivo_path) === TRUE) {
        // Leer el archivo de strings compartidos
        $strings = [];
        if ($zip->locateName('xl/sharedStrings.xml') !== false) {
            $xml_strings = simplexml_load_string($zip->getFromName('xl/sharedStrings.xml'));
            if ($xml_strings) {
                foreach ($xml_strings->si as $si) {
                    $strings[] = (string)$si->t;
                }
            }
        }
        
        // Leer la primera hoja
        $xml_sheet = simplexml_load_string($zip->getFromName('xl/worksheets/sheet1.xml'));
        $zip->close();
        
        if ($xml_sheet) {
            foreach ($xml_sheet->sheetData->row as $row) {
                // Crear array con 8 posiciones (A-H) inicializadas vacías
                $fila = array_fill(0, 8, '');
                
                foreach ($row->c as $cell) {
                    // Obtener la referencia de la celda (ej: "A1", "B1", "C1")
                    $ref = (string)$cell['r'];
                    
                    // Extraer la letra de la columna (A, B, C, etc.)
                    preg_match('/^([A-Z]+)/', $ref, $matches);
                    $col_letter = $matches[1];
                    
                    // Convertir letra a índice (A=0, B=1, C=2, etc.)
                    $col_index = ord($col_letter) - ord('A');
                    
                    // Obtener el valor
                    $valor = '';
                    if (isset($cell->v)) {
                        // Si es un string compartido
                        if (isset($cell['t']) && $cell['t'] == 's') {
                            $index = (int)$cell->v;
                            $valor = isset($strings[$index]) ? $strings[$index] : '';
                        } else {
                            $valor = (string)$cell->v;
                        }
                    }
                    
                    // Asignar el valor a la posición correcta
                    if ($col_index < 8) {
                        $fila[$col_index] = trim($valor);
                    }
                }
                
                // Solo agregar filas que tengan al menos un valor
                if (!empty(array_filter($fila))) {
                    $datos[] = $fila;
                }
            }
        }
    }
    
    return $datos;
}

/**
 * Limpiar y validar teléfono
 */
function limpiar_telefono($telefono) {
    // Eliminar todo excepto números, espacios, + y -
    $telefono = preg_replace('/[^0-9\s\+\-]/', '', $telefono);
    // Eliminar espacios múltiples
    $telefono = preg_replace('/\s+/', ' ', trim($telefono));
    return $telefono;
}

/**
 * Validar y limpiar email
 */
function validar_email($email) {
    $email = trim(strtolower($email));
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $email;
    }
    return '';
}

/**
 * Generar email temporal si no existe
 */
function generar_email_temporal($nombre, $empresa) {
    $base = strtolower(preg_replace('/[^a-z0-9]/', '', $nombre ?: $empresa));
    if (empty($base)) {
        $base = 'cliente';
    }
    return substr($base, 0, 20) . time() . rand(100, 999) . '@pendiente.com';
}

// Procesar importación
if (isset($_POST['importar']) && isset($_FILES['archivo'])) {
    $archivo = $_FILES['archivo'];
    
    if ($archivo['error'] === UPLOAD_ERR_OK) {
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        $nombre_archivo = basename($archivo['name'], '.' . $extension);
        
        // Determinar la lista según el nombre del archivo
        $lista = 'General';
        if (stripos($nombre_archivo, 'electricidad') !== false) {
            $lista = 'Empresas Electricidad';
        } elseif (stripos($nombre_archivo, 'gestoria') !== false || stripos($nombre_archivo, 'asesoria') !== false) {
            $lista = 'Gestorías y Asesorías';
        } elseif (stripos($nombre_archivo, 'talavera') !== false) {
            $lista = 'Empresas Talavera';
        }
        
        if ($extension === 'xlsx') {
            // Leer Excel
            $datos = leer_excel($archivo['tmp_name']);
            
            if (isset($datos['error'])) {
                $mensaje = "❌ Error al leer el archivo: " . $datos['error'];
                $tipo_mensaje = 'error';
            } elseif (count($datos) > 0) {
                // Primera fila son los encabezados - la saltamos
                array_shift($datos);
                
                $detalles[] = "📋 Estructura unificada: SECTOR | EMPRESA | CONTACTO | TELÉFONO | CORREO | POBLACIÓN | PROVINCIA | OBSERVACIONES";
                $detalles[] = "📁 Lista asignada: $lista";
                
                // Procesar cada fila
                foreach ($datos as $fila) {
                    // ESTRUCTURA UNIFICADA:
                    // Columna 0: SECTOR
                    // Columna 1: EMPRESA
                    // Columna 2: CONTACTO
                    // Columna 3: TELÉFONO
                    // Columna 4: CORREO
                    // Columna 5: POBLACIÓN
                    // Columna 6: PROVINCIA
                    // Columna 7: OBSERVACIONES
                    
                    $sector = isset($fila[0]) ? trim($fila[0]) : 'Servicios';
                    $empresa = isset($fila[1]) ? trim($fila[1]) : '';
                    $contacto = isset($fila[2]) ? trim($fila[2]) : '';
                    $telefono = isset($fila[3]) ? limpiar_telefono($fila[3]) : '';
                    $email = isset($fila[4]) ? validar_email($fila[4]) : '';
                    $ciudad = isset($fila[5]) ? trim($fila[5]) : '';
                    $provincia = isset($fila[6]) ? trim($fila[6]) : '';
                    $notas = isset($fila[7]) ? trim($fila[7]) : '';
                    
                    // Si no hay contacto, usar empresa como nombre
                    if (empty($contacto)) {
                        $contacto = $empresa;
                    }
                    
                    // Si sector está vacío, usar "Servicios"
                    if (empty($sector)) {
                        $sector = 'Servicios';
                    }
                    
                    // Validaciones
                    if (empty($empresa) && empty($contacto)) {
                        continue; // Saltar filas vacías
                    }
                    
                    // Si no hay contacto, usar empresa
                    if (empty($contacto)) {
                        $contacto = $empresa;
                    }
                    
                    // Si no hay email, dejarlo vacío (NO generar email falso)
                    if (empty($email)) {
                        $email = ''; // Dejar vacío
                    }
                    
                    // Verificar duplicados SOLO si hay email
                    if (!empty($email)) {
                        $existe = $wpdb->get_var($wpdb->prepare(
                            "SELECT COUNT(*) FROM $table_name WHERE email = %s",
                            $email
                        ));
                        
                        if ($existe > 0) {
                            $duplicados++;
                            continue;
                        }
                    }
                    
                    // Insertar en la base de datos
                    $result = $wpdb->insert(
                        $table_name,
                        [
                            'nombre' => $contacto,
                            'email' => $email,
                            'telefono' => $telefono,
                            'empresa' => $empresa ?: $contacto,
                            'ciudad' => $ciudad,
                            'provincia' => $provincia,
                            'sector' => $sector,
                            'lista' => $lista,
                            'origen' => 'Importación Excel',
                            'estado' => 'activo',
                            'notas' => $notas,
                            'fecha_registro' => current_time('mysql'),
                            'ultima_actividad' => current_time('mysql')
                        ],
                        ['%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s']
                    );
                    
                    if ($result) {
                        $importados++;
                    } else {
                        $errores++;
                        $detalles[] = "❌ Error al importar: $contacto - " . $wpdb->last_error;
                    }
                }
                
                $mensaje = "✅ Importación completada: $importados clientes importados, $duplicados duplicados omitidos, $errores errores";
                $tipo_mensaje = 'success';
            } else {
                $mensaje = "❌ El archivo Excel está vacío o no se pudo leer";
                $tipo_mensaje = 'error';
            }
        } else {
            $mensaje = "❌ Por favor sube un archivo Excel (.xlsx)";
            $tipo_mensaje = 'error';
        }
    } else {
        $mensaje = "❌ Error al subir el archivo";
        $tipo_mensaje = 'error';
    }
}

// Obtener archivos Excel disponibles
$archivos_disponibles = [];
$doc_path = dirname(__FILE__) . '/../doc/';
if (is_dir($doc_path)) {
    $archivos = glob($doc_path . '*.xlsx');
    foreach ($archivos as $archivo) {
        $archivos_disponibles[] = basename($archivo);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📥 Importador Inteligente de Excel</title>
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
            max-width: 1000px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }

        h1 {
            font-size: 32px;
            color: #2d3748;
            margin-bottom: 10px;
            text-align: center;
        }

        .subtitle {
            text-align: center;
            color: #718096;
            margin-bottom: 30px;
            font-size: 16px;
        }

        .mensaje {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .mensaje.success {
            background: #d4edda;
            color: #155724;
            border-left: 5px solid #28a745;
        }

        .mensaje.error {
            background: #f8d7da;
            color: #721c24;
            border-left: 5px solid #dc3545;
        }

        .detalles {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
            font-size: 13px;
            max-height: 200px;
            overflow-y: auto;
        }

        .detalles div {
            margin-bottom: 5px;
        }

        .upload-area {
            border: 3px dashed #cbd5e0;
            border-radius: 16px;
            padding: 60px 40px;
            text-align: center;
            background: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .upload-area:hover {
            border-color: #667eea;
            background: #f0f4ff;
        }

        .upload-icon {
            font-size: 64px;
            margin-bottom: 20px;
        }

        .upload-text {
            font-size: 18px;
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .upload-hint {
            font-size: 14px;
            color: #718096;
        }

        input[type="file"] {
            display: none;
        }

        .file-selected {
            background: #e6f0ff;
            padding: 15px 20px;
            border-radius: 12px;
            margin: 20px 0;
            display: none;
        }

        .file-selected.show {
            display: block;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 15px 35px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            margin: 10px 5px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(102, 126, 234, 0.6);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #5a6268);
        }

        .archivos-disponibles {
            background: #e7f3ff;
            padding: 20px;
            border-radius: 12px;
            margin-top: 30px;
        }

        .archivos-disponibles h3 {
            color: #0066cc;
            margin-bottom: 15px;
        }

        .archivo-item {
            background: white;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .buttons {
            text-align: center;
            margin-top: 30px;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .feature {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
        }

        .feature-icon {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .feature-title {
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .feature-desc {
            font-size: 14px;
            color: #718096;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>📥 Importador Inteligente de Excel</h1>
            <p class="subtitle">Detecta automáticamente la estructura y separa los datos correctamente</p>

            <?php if ($mensaje): ?>
                <div class="mensaje <?php echo $tipo_mensaje; ?>">
                    <?php echo $mensaje; ?>
                    <?php if (!empty($detalles)): ?>
                        <div class="detalles">
                            <?php foreach ($detalles as $detalle): ?>
                                <div><?php echo $detalle; ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="features">
                <div class="feature">
                    <div class="feature-icon">🔍</div>
                    <div class="feature-title">Detección Automática</div>
                    <div class="feature-desc">Identifica automáticamente las columnas del Excel</div>
                </div>
                <div class="feature">
                    <div class="feature-icon">📊</div>
                    <div class="feature-title">Separación Inteligente</div>
                    <div class="feature-desc">Separa empresa, contacto, teléfono, email, ciudad, provincia</div>
                </div>
                <div class="feature">
                    <div class="feature-icon">🏷️</div>
                    <div class="feature-title">Categorización</div>
                    <div class="feature-desc">Asigna automáticamente la lista según el archivo</div>
                </div>
                <div class="feature">
                    <div class="feature-icon">✅</div>
                    <div class="feature-title">Validación</div>
                    <div class="feature-desc">Limpia teléfonos, valida emails y evita duplicados</div>
                </div>
            </div>

            <form method="POST" enctype="multipart/form-data" id="uploadForm">
                <div class="upload-area" id="uploadArea" onclick="document.getElementById('fileInput').click()">
                    <div class="upload-icon">📄</div>
                    <div class="upload-text">Haz clic o arrastra tu archivo Excel aquí</div>
                    <div class="upload-hint">Formato soportado: .xlsx</div>
                </div>

                <input type="file" name="archivo" id="fileInput" accept=".xlsx" required>

                <div class="file-selected" id="fileSelected">
                    <strong>Archivo seleccionado:</strong> <span id="fileName"></span>
                </div>

                <div class="buttons">
                    <button type="submit" name="importar" class="btn btn-success">
                        ✅ Importar Clientes
                    </button>
                    <a href="crm-mailing-completo.php" class="btn btn-secondary">
                        ← Volver al CRM
                    </a>
                </div>
            </form>

            <?php if (!empty($archivos_disponibles)): ?>
            <div class="archivos-disponibles">
                <h3>📁 Archivos Excel Disponibles en /doc/</h3>
                <?php foreach ($archivos_disponibles as $archivo): ?>
                    <div class="archivo-item">
                        <span>📄 <?php echo esc_html($archivo); ?></span>
                        <span style="color: #28a745; font-weight: 600;">✓ Listo para importar</span>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        const fileInput = document.getElementById('fileInput');
        const uploadArea = document.getElementById('uploadArea');
        const fileSelected = document.getElementById('fileSelected');
        const fileName = document.getElementById('fileName');

        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                fileName.textContent = this.files[0].name;
                fileSelected.classList.add('show');
            }
        });

        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                fileName.textContent = files[0].name;
                fileSelected.classList.add('show');
            }
        });
    </script>
</body>
</html>

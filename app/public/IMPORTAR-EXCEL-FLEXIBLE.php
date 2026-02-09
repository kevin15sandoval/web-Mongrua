<?php
/**
 * Importador FLEXIBLE - Detecta automáticamente la estructura del Excel
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

global $wpdb;
$table_name = $wpdb->prefix . 'mongruas_clientes';

$mensaje = '';
$tipo_mensaje = '';
$importados = 0;
$errores = 0;
$duplicados = 0;
$detalles = [];

/**
 * Función para leer archivos Excel (.xlsx)
 */
function leer_excel($archivo_path) {
    $datos = [];
    
    if (!file_exists($archivo_path)) {
        return ['error' => 'Archivo no encontrado'];
    }
    
    $zip = new ZipArchive;
    if ($zip->open($archivo_path) === TRUE) {
        $strings = [];
        if ($zip->locateName('xl/sharedStrings.xml') !== false) {
            $xml_strings = simplexml_load_string($zip->getFromName('xl/sharedStrings.xml'));
            if ($xml_strings) {
                foreach ($xml_strings->si as $si) {
                    $strings[] = (string)$si->t;
                }
            }
        }
        
        $xml_sheet = simplexml_load_string($zip->getFromName('xl/worksheets/sheet1.xml'));
        $zip->close();
        
        if ($xml_sheet) {
            foreach ($xml_sheet->sheetData->row as $row) {
                $fila = array_fill(0, 10, '');
                
                foreach ($row->c as $cell) {
                    $ref = (string)$cell['r'];
                    preg_match('/^([A-Z]+)/', $ref, $matches);
                    $col_letter = $matches[1];
                    $col_index = ord($col_letter) - ord('A');
                    
                    $valor = '';
                    if (isset($cell->v)) {
                        if (isset($cell['t']) && $cell['t'] == 's') {
                            $index = (int)$cell->v;
                            $valor = isset($strings[$index]) ? $strings[$index] : '';
                        } else {
                            $valor = (string)$cell->v;
                        }
                    }
                    
                    if ($col_index < 10) {
                        $fila[$col_index] = trim($valor);
                    }
                }
                
                if (!empty(array_filter($fila))) {
                    $datos[] = $fila;
                }
            }
        }
    }
    
    return $datos;
}

/**
 * Detectar estructura del Excel
 */
function detectar_estructura($primera_fila) {
    $primera_fila_lower = array_map('strtolower', $primera_fila);
    
    // Buscar "SECTOR" en la primera columna
    if (stripos($primera_fila[0], 'SECTOR') !== false) {
        return 'CON_SECTOR'; // SECTOR | EMPRESA | CONTACTO | TELÉFONO | CORREO | POBLACIÓN | PROVINCIA | OBSERVACIONES
    } else {
        return 'SIN_SECTOR'; // EMPRESA | CONTACTO | TELÉFONO | CORREO | POBLACIÓN | PROVINCIA | OBSERVACIONES
    }
}

function limpiar_telefono($telefono) {
    $telefono = preg_replace('/[^0-9\s\+\-]/', '', $telefono);
    return preg_replace('/\s+/', ' ', trim($telefono));
}

function validar_email($email) {
    $email = trim(strtolower($email));
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $email;
    }
    return '';
}

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
            $datos = leer_excel($archivo['tmp_name']);
            
            if (isset($datos['error'])) {
                $mensaje = "❌ Error al leer el archivo: " . $datos['error'];
                $tipo_mensaje = 'error';
            } elseif (count($datos) > 0) {
                // Detectar estructura
                $estructura = detectar_estructura($datos[0]);
                $detalles[] = "🔍 Estructura detectada: $estructura";
                $detalles[] = "📁 Lista asignada: $lista";
                
                // Saltar encabezados
                array_shift($datos);
                
                foreach ($datos as $fila) {
                    if ($estructura === 'CON_SECTOR') {
                        // SECTOR | EMPRESA | CONTACTO | TELÉFONO | CORREO | POBLACIÓN | PROVINCIA | OBSERVACIONES
                        $sector = isset($fila[0]) && !empty($fila[0]) ? trim($fila[0]) : 'Servicios';
                        $empresa = isset($fila[1]) ? trim($fila[1]) : '';
                        $contacto = isset($fila[2]) ? trim($fila[2]) : '';
                        $telefono = isset($fila[3]) ? limpiar_telefono($fila[3]) : '';
                        $email = isset($fila[4]) ? validar_email($fila[4]) : '';
                        $ciudad = isset($fila[5]) ? trim($fila[5]) : '';
                        $provincia = isset($fila[6]) ? trim($fila[6]) : '';
                        $notas = isset($fila[7]) ? trim($fila[7]) : '';
                    } else {
                        // SIN_SECTOR: EMPRESA | CONTACTO | TELÉFONO | CORREO | POBLACIÓN | PROVINCIA | OBSERVACIONES
                        $sector = 'Servicios';
                        $empresa = isset($fila[0]) ? trim($fila[0]) : '';
                        $contacto = isset($fila[1]) ? trim($fila[1]) : '';
                        $telefono = isset($fila[2]) ? limpiar_telefono($fila[2]) : '';
                        $email = isset($fila[3]) ? validar_email($fila[3]) : '';
                        $ciudad = isset($fila[4]) ? trim($fila[4]) : '';
                        $provincia = isset($fila[5]) ? trim($fila[5]) : '';
                        $notas = isset($fila[6]) ? trim($fila[6]) : '';
                    }
                    
                    // Validaciones
                    if (empty($empresa)) {
                        continue;
                    }
                    
                    // Si no hay contacto, usar empresa
                    if (empty($contacto)) {
                        $contacto = $empresa;
                    }
                    
                    // Si no hay email, generar uno temporal
                    if (empty($email)) {
                        $email = generar_email_temporal($contacto, $empresa);
                    }
                    
                    // Verificar duplicados
                    $existe = $wpdb->get_var($wpdb->prepare(
                        "SELECT COUNT(*) FROM $table_name WHERE email = %s",
                        $email
                    ));
                    
                    if ($existe > 0) {
                        $duplicados++;
                        continue;
                    }
                    
                    // Insertar
                    $result = $wpdb->insert(
                        $table_name,
                        [
                            'nombre' => $contacto,
                            'email' => $email,
                            'telefono' => $telefono,
                            'empresa' => $empresa,
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
                    }
                }
                
                $mensaje = "✅ Importación completada: $importados clientes importados, $duplicados duplicados omitidos, $errores errores";
                $tipo_mensaje = 'success';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📥 Importador Flexible</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        .container { max-width: 1000px; margin: 0 auto; }
        .card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }
        h1 { font-size: 32px; color: #2d3748; margin-bottom: 10px; text-align: center; }
        .subtitle { text-align: center; color: #718096; margin-bottom: 30px; font-size: 16px; }
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
        }
        .upload-area {
            border: 3px dashed #cbd5e0;
            border-radius: 16px;
            padding: 60px 40px;
            text-align: center;
            background: #f8f9fa;
            cursor: pointer;
        }
        .upload-area:hover {
            border-color: #667eea;
            background: #f0f4ff;
        }
        .upload-icon { font-size: 64px; margin-bottom: 20px; }
        .upload-text { font-size: 18px; color: #2d3748; font-weight: 600; margin-bottom: 10px; }
        .upload-hint { font-size: 14px; color: #718096; }
        input[type="file"] { display: none; }
        .file-selected {
            background: #e6f0ff;
            padding: 15px 20px;
            border-radius: 12px;
            margin: 20px 0;
            display: none;
        }
        .file-selected.show { display: block; }
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
            margin: 10px 5px;
        }
        .btn:hover { transform: translateY(-2px); }
        .btn-success { background: linear-gradient(135deg, #28a745, #20c997); }
        .btn-secondary { background: linear-gradient(135deg, #6c757d, #5a6268); }
        .buttons { text-align: center; margin-top: 30px; }
        .info-box {
            background: #e7f3ff;
            padding: 20px;
            border-radius: 12px;
            margin: 20px 0;
        }
        .info-box h3 { color: #0066cc; margin-bottom: 10px; }
        .info-box ul { margin-left: 20px; line-height: 1.8; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>📥 Importador Flexible de Excel</h1>
            <p class="subtitle">Detecta automáticamente si tu Excel tiene columna SECTOR o no</p>

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

            <div class="info-box">
                <h3>📋 Estructuras Soportadas:</h3>
                <ul>
                    <li><strong>Con SECTOR:</strong> SECTOR | EMPRESA | CONTACTO | TELÉFONO | CORREO | POBLACIÓN | PROVINCIA | OBSERVACIONES</li>
                    <li><strong>Sin SECTOR:</strong> EMPRESA | CONTACTO | TELÉFONO | CORREO | POBLACIÓN | PROVINCIA | OBSERVACIONES</li>
                </ul>
                <p style="margin-top: 10px; color: #666;">✅ El sistema detecta automáticamente cuál tienes</p>
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
        </div>
    </div>

    <script>
        const fileInput = document.getElementById('fileInput');
        const fileName = document.getElementById('fileName');
        const fileSelected = document.getElementById('fileSelected');

        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                fileName.textContent = this.files[0].name;
                fileSelected.classList.add('show');
            }
        });
    </script>
</body>
</html>

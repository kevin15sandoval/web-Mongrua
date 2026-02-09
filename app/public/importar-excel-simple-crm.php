<?php
/**
 * Importador Simple de Excel al CRM (Sin librerías externas)
 * Permite subir archivos Excel/CSV y los importa al CRM
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

global $wpdb;
$table_name = $wpdb->prefix . 'mongruas_clientes';

// Crear tabla si no existe
$charset_collate = $wpdb->get_charset_collate();
$sql = "CREATE TABLE IF NOT EXISTS $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    nombre varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    telefono varchar(50) DEFAULT '',
    empresa varchar(255) DEFAULT '',
    sector varchar(100) DEFAULT 'Servicios',
    interes varchar(255) DEFAULT '',
    origen varchar(50) DEFAULT 'Importación',
    estado varchar(20) DEFAULT 'activo',
    notas text DEFAULT '',
    fecha_registro datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY  (id),
    KEY email (email),
    KEY sector (sector),
    KEY estado (estado)
) $charset_collate;";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);

$mensaje = '';
$tipo_mensaje = '';
$importados = 0;
$errores = 0;
$duplicados = 0;

// Procesar importación
if (isset($_POST['importar']) && isset($_FILES['archivo'])) {
    $archivo = $_FILES['archivo'];
    
    if ($archivo['error'] === UPLOAD_ERR_OK) {
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        
        if ($extension === 'csv' || $extension === 'txt') {
            // Leer archivo CSV
            $handle = fopen($archivo['tmp_name'], 'r');
            
            if ($handle) {
                // Saltar encabezados
                fgetcsv($handle, 1000, ';');
                
                while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
                    $nombre = isset($data[0]) ? trim($data[0]) : '';
                    $email = isset($data[1]) ? trim($data[1]) : '';
                    $telefono = isset($data[2]) ? trim($data[2]) : '';
                    $empresa = isset($data[3]) ? trim($data[3]) : $nombre;
                    
                    // Validar datos mínimos
                    if (empty($nombre) && empty($email)) {
                        continue;
                    }
                    
                    // Generar email si no existe
                    if (empty($email)) {
                        $email = strtolower(str_replace(' ', '', $nombre)) . '@pendiente.com';
                    }
                    
                    // Validar email
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $email = 'contacto' . time() . rand(1000, 9999) . '@pendiente.com';
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
                            'nombre' => $nombre ?: 'Sin nombre',
                            'email' => $email,
                            'telefono' => $telefono,
                            'empresa' => $empresa ?: $nombre,
                            'sector' => 'Servicios',
                            'interes' => '',
                            'origen' => 'Importación CSV',
                            'estado' => 'activo',
                            'notas' => 'Importado desde ' . $archivo['name'],
                            'fecha_registro' => current_time('mysql')
                        ],
                        ['%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s']
                    );
                    
                    if ($result) {
                        $importados++;
                    } else {
                        $errores++;
                    }
                }
                
                fclose($handle);
                $mensaje = "✅ Importación completada: $importados clientes importados, $duplicados duplicados, $errores errores";
                $tipo_mensaje = 'success';
            }
        } else {
            $mensaje = "❌ Por favor sube un archivo CSV o TXT";
            $tipo_mensaje = 'error';
        }
    } else {
        $mensaje = "❌ Error al subir el archivo";
        $tipo_mensaje = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📥 Importar Excel/CSV al CRM</title>
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
            max-width: 800px;
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

        .upload-area.dragover {
            border-color: #667eea;
            background: #e6f0ff;
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

        .instructions {
            background: #fff3cd;
            border-left: 5px solid #ffc107;
            padding: 20px;
            border-radius: 12px;
            margin-top: 30px;
        }

        .instructions h3 {
            color: #856404;
            margin-bottom: 15px;
        }

        .instructions ul {
            margin-left: 20px;
            color: #856404;
        }

        .instructions li {
            margin-bottom: 8px;
        }

        .buttons {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>📥 Importar Clientes desde Excel/CSV</h1>
            <p class="subtitle">Sube tu archivo y los datos se importarán automáticamente al CRM</p>

            <?php if ($mensaje): ?>
                <div class="mensaje <?php echo $tipo_mensaje; ?>">
                    <?php echo $mensaje; ?>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" id="uploadForm">
                <div class="upload-area" id="uploadArea" onclick="document.getElementById('fileInput').click()">
                    <div class="upload-icon">📄</div>
                    <div class="upload-text">Haz clic o arrastra tu archivo aquí</div>
                    <div class="upload-hint">Formatos soportados: CSV, TXT (separado por punto y coma)</div>
                </div>

                <input type="file" name="archivo" id="fileInput" accept=".csv,.txt" required>

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

            <div class="instructions">
                <h3>📋 Formato del Archivo</h3>
                <ul>
                    <li><strong>Formato:</strong> CSV o TXT separado por punto y coma (;)</li>
                    <li><strong>Primera fila:</strong> Encabezados (se ignoran)</li>
                    <li><strong>Columnas:</strong> Nombre;Email;Teléfono;Empresa</li>
                    <li><strong>Ejemplo:</strong> Juan Pérez;juan@email.com;123456789;Empresa ABC</li>
                    <li>Si no hay email, se generará uno automáticamente</li>
                    <li>Los duplicados se detectan y se omiten</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        const fileInput = document.getElementById('fileInput');
        const uploadArea = document.getElementById('uploadArea');
        const fileSelected = document.getElementById('fileSelected');
        const fileName = document.getElementById('fileName');

        // Mostrar nombre del archivo seleccionado
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                fileName.textContent = this.files[0].name;
                fileSelected.classList.add('show');
            }
        });

        // Drag and drop
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

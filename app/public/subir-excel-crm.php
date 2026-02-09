<?php
/**
 * Subida y Procesamiento de Excel para CRM
 * Sistema mejorado para manejar archivos Excel reales
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>📤 Subir Excel al CRM</h1>";

global $wpdb;
$table_clientes = $wpdb->prefix . 'mongruas_clientes';

$mensaje_resultado = '';

// Procesar subida de archivo
if (isset($_POST['subir_excel']) && isset($_FILES['archivo_excel'])) {
    $archivo = $_FILES['archivo_excel'];
    
    if ($archivo['error'] === UPLOAD_ERR_OK) {
        $nombre_archivo = $archivo['name'];
        $archivo_temporal = $archivo['tmp_name'];
        $extension = strtolower(pathinfo($nombre_archivo, PATHINFO_EXTENSION));
        
        echo "<h2>🔄 Procesando: $nombre_archivo</h2>";
        
        // Leer el contenido del archivo
        $contenido = file_get_contents($archivo_temporal);
        
        // Intentar diferentes métodos de parsing
        $datos_procesados = [];
        
        if ($extension === 'csv') {
            // Procesar CSV
            $lineas = str_getcsv($contenido, "\n");
            foreach ($lineas as $linea) {
                if (trim($linea)) {
                    // Probar diferentes separadores
                    if (strpos($linea, ';') !== false) {
                        $datos_procesados[] = str_getcsv($linea, ';');
                    } elseif (strpos($linea, ',') !== false) {
                        $datos_procesados[] = str_getcsv($linea, ',');
                    } elseif (strpos($linea, "\t") !== false) {
                        $datos_procesados[] = str_getcsv($linea, "\t");
                    } else {
                        $datos_procesados[] = [$linea];
                    }
                }
            }
        } else {
            // Para archivos Excel, intentar extraer texto
            // Dividir por saltos de línea
            $lineas = preg_split('/\r\n|\r|\n/', $contenido);
            
            foreach ($lineas as $linea) {
                $linea = trim($linea);
                if (!empty($linea) && !preg_match('/^[^\w\s]/', $linea)) {
                    // Limpiar caracteres especiales
                    $linea = preg_replace('/[^\w\s@.-]/', ' ', $linea);
                    
                    // Intentar separar por espacios múltiples, tabulaciones, etc.
                    if (strpos($linea, "\t") !== false) {
                        $datos_procesados[] = explode("\t", $linea);
                    } elseif (preg_match('/\s{2,}/', $linea)) {
                        $datos_procesados[] = preg_split('/\s{2,}/', $linea);
                    } else {
                        // Si no hay separadores claros, usar toda la línea como nombre
                        if (strlen($linea) > 3) {
                            $datos_procesados[] = [$linea];
                        }
                    }
                }
            }
        }
        
        // Mostrar datos encontrados
        echo "<h3>📋 Datos encontrados (" . count($datos_procesados) . " filas):</h3>";
        
        if (!empty($datos_procesados)) {
            echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 15px 0; max-height: 300px; overflow-y: auto;'>";
            echo "<table style='width: 100%; border-collapse: collapse;'>";
            echo "<tr style='background: #e9ecef;'>";
            echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>#</th>";
            echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Datos Extraídos</th>";
            echo "</tr>";
            
            foreach ($datos_procesados as $index => $fila) {
                if ($index < 20) { // Mostrar máximo 20 filas
                    echo "<tr>";
                    echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . ($index + 1) . "</td>";
                    echo "<td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars(implode(' | ', $fila)) . "</td>";
                    echo "</tr>";
                }
            }
            
            if (count($datos_procesados) > 20) {
                echo "<tr><td colspan='2' style='text-align: center; padding: 10px; font-style: italic;'>... y " . (count($datos_procesados) - 20) . " filas más</td></tr>";
            }
            
            echo "</table>";
            echo "</div>";
            
            // Formulario para confirmar importación
            echo "<form method='post'>";
            echo "<input type='hidden' name='confirmar_importacion' value='1'>";
            echo "<input type='hidden' name='datos_json' value='" . htmlspecialchars(json_encode($datos_procesados)) . "'>";
            echo "<input type='hidden' name='nombre_archivo' value='" . htmlspecialchars($nombre_archivo) . "'>";
            
            echo "<div style='background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
            echo "<h4>⚙️ Configurar Importación:</h4>";
            
            echo "<div style='display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 15px 0;'>";
            
            echo "<div>";
            echo "<label style='font-weight: 600; display: block; margin-bottom: 5px;'>Sector por defecto:</label>";
            echo "<select name='sector_defecto' style='width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;'>";
            echo "<option value='Construcción'>Construcción</option>";
            echo "<option value='Industria'>Industria</option>";
            echo "<option value='Servicios'>Servicios</option>";
            echo "<option value='Tecnología'>Tecnología</option>";
            echo "<option value='Educación'>Educación</option>";
            echo "</select>";
            echo "</div>";
            
            echo "<div>";
            echo "<label style='font-weight: 600; display: block; margin-bottom: 5px;'>Interés por defecto:</label>";
            echo "<select name='interes_defecto' style='width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;'>";
            echo "<option value='Instalaciones Eléctricas'>Instalaciones Eléctricas</option>";
            echo "<option value='Domótica'>Domótica</option>";
            echo "<option value='Control de Plagas'>Control de Plagas</option>";
            echo "<option value='PRL'>Prevención de Riesgos Laborales</option>";
            echo "<option value='Energías Renovables'>Energías Renovables</option>";
            echo "<option value='Soldadura'>Soldadura</option>";
            echo "<option value='Climatización'>Climatización</option>";
            echo "</select>";
            echo "</div>";
            
            echo "</div>";
            
            echo "<button type='submit' style='background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 15px 30px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 16px;'>";
            echo "✅ Confirmar e Importar " . count($datos_procesados) . " Registros";
            echo "</button>";
            
            echo "</div>";
            echo "</form>";
        } else {
            $mensaje_resultado = "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0; color: #856404;'>";
            $mensaje_resultado .= "<h3>⚠️ No se encontraron datos</h3>";
            $mensaje_resultado .= "<p>No se pudieron extraer datos del archivo. Verifica que:</p>";
            $mensaje_resultado .= "<ul><li>El archivo contenga datos válidos</li><li>Esté en formato Excel (.xlsx, .xls) o CSV</li><li>Los datos estén organizados en filas y columnas</li></ul>";
            $mensaje_resultado .= "</div>";
        }
    } else {
        $mensaje_resultado = "<div style='background: #f8d7da; padding: 20px; border-radius: 8px; margin: 20px 0; color: #721c24;'>";
        $mensaje_resultado .= "<h3>❌ Error al subir archivo</h3>";
        $mensaje_resultado .= "<p>Error: " . $archivo['error'] . "</p>";
        $mensaje_resultado .= "</div>";
    }
}

// Procesar confirmación de importación
if (isset($_POST['confirmar_importacion'])) {
    $datos_json = $_POST['datos_json'];
    $nombre_archivo = $_POST['nombre_archivo'];
    $sector_defecto = $_POST['sector_defecto'];
    $interes_defecto = $_POST['interes_defecto'];
    
    $datos = json_decode($datos_json, true);
    
    $importados = 0;
    $errores = 0;
    
    echo "<h2>🔄 Importando datos...</h2>";
    
    foreach ($datos as $fila) {
        if (!empty($fila) && !empty(trim($fila[0]))) {
            // Extraer información de la fila
            $nombre = sanitize_text_field(trim($fila[0]));
            
            // Intentar extraer email si existe
            $email = '';
            foreach ($fila as $campo) {
                if (is_email(trim($campo))) {
                    $email = sanitize_email(trim($campo));
                    break;
                }
            }
            
            // Si no hay email, generar uno
            if (empty($email)) {
                $email = strtolower(str_replace([' ', '.', ','], ['', '', ''], $nombre)) . '@empresa.com';
            }
            
            // Extraer teléfono si existe
            $telefono = '';
            foreach ($fila as $campo) {
                if (preg_match('/^\d{9,}$/', trim($campo))) {
                    $telefono = sanitize_text_field(trim($campo));
                    break;
                }
            }
            
            // Usar nombre como empresa si no se especifica otra cosa
            $empresa = count($fila) > 1 && !empty(trim($fila[1])) && !is_email(trim($fila[1])) ? sanitize_text_field(trim($fila[1])) : $nombre;
            
            // Insertar en la base de datos
            $resultado = $wpdb->insert(
                $table_clientes,
                array(
                    'nombre' => $nombre,
                    'email' => $email,
                    'telefono' => $telefono,
                    'empresa' => $empresa,
                    'sector' => $sector_defecto,
                    'interes' => $interes_defecto,
                    'origen' => 'Excel Subido - ' . $nombre_archivo,
                    'ultima_actividad' => current_time('mysql')
                )
            );
            
            if ($resultado) {
                $importados++;
                echo "<p>✅ $nombre ($email)</p>";
            } else {
                $errores++;
                echo "<p>❌ Error: $nombre - " . $wpdb->last_error . "</p>";
            }
        }
    }
    
    $mensaje_resultado = "<div style='background: #d4edda; padding: 25px; border-radius: 12px; margin: 25px 0; color: #155724; border-left: 5px solid #28a745;'>";
    $mensaje_resultado .= "<h3 style='margin-top: 0;'>🎉 Importación Completada</h3>";
    $mensaje_resultado .= "<div style='display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0;'>";
    $mensaje_resultado .= "<div style='text-align: center;'>";
    $mensaje_resultado .= "<div style='font-size: 36px; font-weight: 800; color: #28a745;'>$importados</div>";
    $mensaje_resultado .= "<div style='font-size: 14px;'>Clientes Importados</div>";
    $mensaje_resultado .= "</div>";
    $mensaje_resultado .= "<div style='text-align: center;'>";
    $mensaje_resultado .= "<div style='font-size: 36px; font-weight: 800; color: " . ($errores > 0 ? '#dc3545' : '#28a745') . ";'>$errores</div>";
    $mensaje_resultado .= "<div style='font-size: 14px;'>Errores</div>";
    $mensaje_resultado .= "</div>";
    $mensaje_resultado .= "</div>";
    $mensaje_resultado .= "<p style='margin: 0;'><strong>Archivo procesado:</strong> $nombre_archivo</p>";
    $mensaje_resultado .= "</div>";
}

// Obtener estadísticas
$total_clientes = $wpdb->get_var("SELECT COUNT(*) FROM $table_clientes");
?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    background: #f1f3f4;
}

.upload-container {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin: 20px 0;
}

.stat-card {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
    padding: 25px;
    border-radius: 12px;
    text-align: center;
    margin: 20px 0;
}

.stat-number {
    font-size: 36px;
    font-weight: 800;
    margin-bottom: 10px;
}

.upload-area {
    border: 3px dashed #0066cc;
    border-radius: 12px;
    padding: 40px;
    text-align: center;
    background: #f8f9fa;
    margin: 20px 0;
    transition: all 0.3s ease;
}

.upload-area:hover {
    background: #e7f3ff;
    border-color: #0052a3;
}

.upload-area input[type="file"] {
    width: 100%;
    padding: 15px;
    font-size: 16px;
    border: none;
    background: transparent;
    cursor: pointer;
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
    margin: 10px;
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
</style>

<div class="upload-container">
    <?php echo $mensaje_resultado; ?>
    
    <div class="stat-card">
        <div class="stat-number"><?php echo $total_clientes; ?></div>
        <div class="stat-label">Total Clientes en CRM</div>
    </div>
    
    <div class="info-box">
        <h3>📤 Subir Archivo Excel</h3>
        <p>Sube tu archivo Excel con los datos de clientes. El sistema procesará automáticamente el contenido y te permitirá revisar los datos antes de importarlos.</p>
        <ul>
            <li>✅ Formatos soportados: .xlsx, .xls, .csv</li>
            <li>✅ Detección automática de estructura</li>
            <li>✅ Vista previa antes de importar</li>
            <li>✅ Configuración de sector e interés</li>
        </ul>
    </div>
    
    <form method="post" enctype="multipart/form-data">
        <div class="upload-area">
            <h3 style="color: #0066cc; margin-top: 0;">📊 Selecciona tu archivo Excel</h3>
            <input type="file" name="archivo_excel" accept=".xlsx,.xls,.csv" required>
            <p style="color: #666; margin: 10px 0 0 0;">Arrastra y suelta tu archivo aquí o haz clic para seleccionar</p>
        </div>
        
        <div style="text-align: center;">
            <button type="submit" name="subir_excel" class="btn btn-primary">
                📤 Subir y Procesar Archivo
            </button>
        </div>
    </form>
</div>

<div style="text-align: center; margin: 30px 0;">
    <a href="/crm-mailing-completo.php" class="btn btn-success">🎯 Ir al CRM Completo</a>
    <a href="/importar-excel-real.php" class="btn btn-primary">📊 Importador Avanzado</a>
</div>
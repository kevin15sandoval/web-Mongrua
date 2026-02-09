<?php
/**
 * DEBUG: Ver EXACTAMENTE qué lee de cada celda del Excel
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

// Ruta del archivo
$archivo_test = 'C:/Users/USUARIO/Local Sites/mongruasformacion/doc/Empresas de Electricidad.xlsx';

if (!file_exists($archivo_test)) {
    die("❌ Archivo no encontrado: $archivo_test");
}

echo "<h1>🔍 DEBUG: Lectura Detallada del Excel</h1>";
echo "<p><strong>Archivo:</strong> " . basename($archivo_test) . "</p>";

// Función de lectura mejorada
function leer_excel_debug($archivo_path) {
    $datos = [];
    
    $zip = new ZipArchive;
    if ($zip->open($archivo_path) === TRUE) {
        // Leer strings compartidos
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
                    
                    // Extraer la letra de la columna
                    preg_match('/^([A-Z]+)/', $ref, $matches);
                    $col_letter = $matches[1];
                    
                    // Convertir letra a índice (A=0, B=1, C=2, etc.)
                    $col_index = ord($col_letter) - ord('A');
                    
                    // Obtener el valor
                    $valor = '';
                    if (isset($cell->v)) {
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
                
                $datos[] = $fila;
            }
        }
    }
    
    return $datos;
}

// Leer el Excel
$datos = leer_excel_debug($archivo_test);

echo "<h2>📊 Primeras 10 filas con índices de array</h2>";
echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%; background: white; font-size: 12px;'>";

// Encabezados
echo "<tr style='background: #2d3748; color: white;'>";
echo "<th>Fila</th>";
echo "<th>Índice [0]<br>SECTOR</th>";
echo "<th>Índice [1]<br>EMPRESA</th>";
echo "<th>Índice [2]<br>CONTACTO</th>";
echo "<th>Índice [3]<br>TELÉFONO</th>";
echo "<th>Índice [4]<br>CORREO</th>";
echo "<th>Índice [5]<br>POBLACIÓN</th>";
echo "<th>Índice [6]<br>PROVINCIA</th>";
echo "<th>Índice [7]<br>OBSERVACIONES</th>";
echo "</tr>";

$fila_num = 0;
foreach ($datos as $fila) {
    $fila_num++;
    
    $bg = $fila_num == 1 ? 'background: #e7f3ff; font-weight: bold;' : '';
    
    echo "<tr style='$bg'>";
    echo "<td style='background: #f0f0f0; font-weight: bold;'>$fila_num</td>";
    
    for ($i = 0; $i < 8; $i++) {
        $valor = isset($fila[$i]) ? $fila[$i] : '';
        $display = empty($valor) ? '<em style="color: #999;">(vacío)</em>' : htmlspecialchars($valor);
        
        // Resaltar si es muy largo (posible error)
        $style = strlen($valor) > 50 ? 'background: #ffcccc;' : '';
        
        echo "<td style='$style'>$display</td>";
    }
    echo "</tr>";
    
    if ($fila_num >= 10) {
        echo "<tr><td colspan='9' style='text-align: center; background: #fff3cd; padding: 15px;'><strong>... (mostrando solo primeras 10 filas)</strong></td></tr>";
        break;
    }
}

echo "</table>";

// Ahora simular el procesamiento
echo "<h2>🔧 Simulación de Procesamiento</h2>";
echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%; background: white; font-size: 12px;'>";
echo "<tr style='background: #2d3748; color: white;'>";
echo "<th>Fila</th>";
echo "<th>Sector</th>";
echo "<th>Empresa</th>";
echo "<th>Contacto</th>";
echo "<th>Teléfono</th>";
echo "<th>Email</th>";
echo "<th>Ciudad</th>";
echo "<th>Provincia</th>";
echo "<th>Notas</th>";
echo "</tr>";

// Saltar encabezados
$datos_procesados = array_slice($datos, 1, 10);

foreach ($datos_procesados as $idx => $fila) {
    $sector = isset($fila[0]) && !empty($fila[0]) ? trim($fila[0]) : 'Servicios';
    $empresa = isset($fila[1]) ? trim($fila[1]) : '';
    $contacto = isset($fila[2]) ? trim($fila[2]) : '';
    $telefono = isset($fila[3]) ? trim($fila[3]) : '';
    $email = isset($fila[4]) ? trim($fila[4]) : '';
    $ciudad = isset($fila[5]) ? trim($fila[5]) : '';
    $provincia = isset($fila[6]) ? trim($fila[6]) : '';
    $notas = isset($fila[7]) ? trim($fila[7]) : '';
    
    // Si no hay contacto, usar empresa
    if (empty($contacto)) {
        $contacto = $empresa;
    }
    
    echo "<tr>";
    echo "<td style='background: #f0f0f0; font-weight: bold;'>" . ($idx + 2) . "</td>";
    echo "<td>" . htmlspecialchars($sector) . "</td>";
    echo "<td>" . htmlspecialchars($empresa) . "</td>";
    echo "<td>" . (empty($contacto) ? '<em style="color: #999;">(vacío → usará empresa)</em>' : htmlspecialchars($contacto)) . "</td>";
    echo "<td>" . htmlspecialchars($telefono) . "</td>";
    echo "<td>" . (empty($email) ? '<em style="color: #ff6600;">(vacío → generará temporal)</em>' : htmlspecialchars($email)) . "</td>";
    echo "<td>" . htmlspecialchars($ciudad) . "</td>";
    echo "<td>" . htmlspecialchars($provincia) . "</td>";
    echo "<td>" . htmlspecialchars($notas) . "</td>";
    echo "</tr>";
}

echo "</table>";

echo "<hr>";
echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>⚠️ IMPORTANTE:</h3>";
echo "<ul>";
echo "<li>Si ves que el <strong>CORREO (índice [4])</strong> está vacío, el sistema generará un email temporal</li>";
echo "<li>Si ves que el <strong>TELÉFONO (índice [3])</strong> aparece en el lugar del correo, hay un problema de lectura</li>";
echo "<li>Las celdas vacías deben aparecer como <em>(vacío)</em> sin desplazar las demás columnas</li>";
echo "</ul>";
echo "</div>";

echo "<p><a href='importar-todos-excel-crm.php' style='display: inline-block; background: #0066cc; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;'>← Volver al Importador</a></p>";
?>

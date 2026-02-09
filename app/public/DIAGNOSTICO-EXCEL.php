<?php
/**
 * DIAGNÓSTICO: Ver qué lee el sistema del Excel
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

// Ruta correcta del archivo
$archivo_test = 'C:/Users/USUARIO/Local Sites/mongruasformacion/doc/Empresas de Electricidad.xlsx';

if (empty($archivo_test) || !file_exists($archivo_test)) {
    echo "<p style='color: red;'>❌ No se encontró el archivo</p>";
    echo "<p><strong>Ruta buscada:</strong> " . $archivo_test . "</p>";
    exit;
}

echo "<h1>🔍 Diagnóstico de Lectura de Excel</h1>";
echo "<p><strong>Archivo:</strong> " . basename($archivo_test) . "</p>";

if (!file_exists($archivo_test)) {
    echo "<p style='color: red;'>❌ Archivo no encontrado</p>";
    exit;
}

// Intentar leer con ZipArchive
$zip = new ZipArchive;
if ($zip->open($archivo_test) === TRUE) {
    echo "<h2>✅ Archivo ZIP abierto correctamente</h2>";
    
    // Leer strings compartidos
    $strings = [];
    if ($zip->locateName('xl/sharedStrings.xml') !== false) {
        $xml_strings = simplexml_load_string($zip->getFromName('xl/sharedStrings.xml'));
        if ($xml_strings) {
            foreach ($xml_strings->si as $si) {
                $strings[] = (string)$si->t;
            }
        }
        echo "<p>📝 Strings compartidos encontrados: " . count($strings) . "</p>";
        echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 20px 0;'>";
        echo "<h3>Primeros 20 strings:</h3>";
        echo "<ol>";
        for ($i = 0; $i < min(20, count($strings)); $i++) {
            echo "<li>" . htmlspecialchars($strings[$i]) . "</li>";
        }
        echo "</ol>";
        echo "</div>";
    }
    
    // Leer la primera hoja
    $xml_sheet = simplexml_load_string($zip->getFromName('xl/worksheets/sheet1.xml'));
    $zip->close();
    
    if ($xml_sheet) {
        echo "<h2>📊 Contenido de la Hoja 1 (por posición de columna)</h2>";
        echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%; background: white;'>";
        
        // Encabezados de columnas
        echo "<tr>";
        echo "<td style='background: #2d3748; color: white; font-weight: bold;'>Fila</td>";
        $columnas = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        foreach ($columnas as $col) {
            echo "<td style='background: #2d3748; color: white; font-weight: bold; text-align: center;'>$col</td>";
        }
        echo "</tr>";
        
        $fila_num = 0;
        foreach ($xml_sheet->sheetData->row as $row) {
            $fila_num++;
            
            // Crear array con 8 posiciones (A-H) inicializadas vacías
            $fila_datos = array_fill(0, 8, '');
            
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
                
                // Asignar a la posición correcta
                if ($col_index < 8) {
                    $fila_datos[$col_index] = trim($valor);
                }
            }
            
            echo "<tr>";
            $bg_fila = $fila_num == 1 ? 'background: #e7f3ff; font-weight: bold;' : '';
            echo "<td style='background: #f0f0f0; font-weight: bold;'>$fila_num</td>";
            
            foreach ($fila_datos as $valor) {
                $display = empty($valor) ? '<em style="color: #999;">(vacío)</em>' : htmlspecialchars($valor);
                echo "<td style='$bg_fila'>$display</td>";
            }
            echo "</tr>";
            
            // Solo mostrar primeras 10 filas
            if ($fila_num >= 10) {
                echo "<tr><td colspan='9' style='text-align: center; background: #fff3cd; padding: 15px;'><strong>... (mostrando solo primeras 10 filas)</strong></td></tr>";
                break;
            }
        }
        echo "</table>";
        
        echo "<div style='background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
        echo "<h3>📋 Estructura Esperada:</h3>";
        echo "<ul style='line-height: 2;'>";
        echo "<li><strong>Columna A:</strong> SECTOR</li>";
        echo "<li><strong>Columna B:</strong> EMPRESA</li>";
        echo "<li><strong>Columna C:</strong> CONTACTO (puede estar vacío)</li>";
        echo "<li><strong>Columna D:</strong> TELÉFONO</li>";
        echo "<li><strong>Columna E:</strong> CORREO</li>";
        echo "<li><strong>Columna F:</strong> POBLACIÓN</li>";
        echo "<li><strong>Columna G:</strong> PROVINCIA</li>";
        echo "<li><strong>Columna H:</strong> OBSERVACIONES</li>";
        echo "</ul>";
        echo "</div>";
    }
} else {
    echo "<p style='color: red;'>❌ No se pudo abrir el archivo ZIP</p>";
}

echo "<hr>";
echo "<h2>🔧 Información del Sistema</h2>";
echo "<ul>";
echo "<li><strong>PHP Version:</strong> " . phpversion() . "</li>";
echo "<li><strong>ZipArchive disponible:</strong> " . (class_exists('ZipArchive') ? '✅ Sí' : '❌ No') . "</li>";
echo "<li><strong>Ruta del archivo:</strong> " . $archivo_test . "</li>";
echo "<li><strong>Archivo existe:</strong> " . (file_exists($archivo_test) ? '✅ Sí' : '❌ No') . "</li>";
echo "<li><strong>Tamaño:</strong> " . filesize($archivo_test) . " bytes</li>";
echo "</ul>";

echo "<hr>";
echo "<p><a href='importar-todos-excel-crm.php' style='display: inline-block; background: #0066cc; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;'>← Volver al Importador</a></p>";
?>

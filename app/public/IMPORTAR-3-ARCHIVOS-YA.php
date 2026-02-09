<?php
/**
 * IMPORTAR LOS 3 ARCHIVOS EXCEL AUTOMÁTICAMENTE
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

global $wpdb;
$table_name = $wpdb->prefix . 'mongruas_clientes';

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <title>🚀 Importación Automática de 3 Archivos</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px;
            margin: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        h1 {
            color: #2d3748;
            margin-bottom: 30px;
        }
        .resultado {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            margin: 20px 0;
            border-left: 5px solid #28a745;
        }
        .error {
            border-left-color: #dc3545;
            background: #fff5f5;
        }
        .archivo {
            background: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            border: 2px solid #e2e8f0;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        .stat {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
        }
        .stat-number {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .stat-label {
            font-size: 14px;
            opacity: 0.9;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 15px 35px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            margin: 10px 5px;
        }
    </style>
</head>
<body>
<div class='container'>
<h1>🚀 Importación Automática de 3 Archivos Excel</h1>";

// Función para leer Excel
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
                $fila = array_fill(0, 8, '');
                
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
                    
                    if ($col_index < 8) {
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

function limpiar_telefono($telefono) {
    $telefono = preg_replace('/[^0-9\s\+\-]/', '', $telefono);
    $telefono = preg_replace('/\s+/', ' ', trim($telefono));
    return $telefono;
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

// Archivos a importar
$archivos = [
    [
        'path' => dirname(__FILE__) . '/../doc/Empresas de Electricidad (1).xlsx',
        'lista' => 'Empresas Electricidad',
        'nombre' => 'Empresas de Electricidad'
    ],
    [
        'path' => dirname(__FILE__) . '/../doc/Empresas Talavera (1).xlsx',
        'lista' => 'Empresas Talavera',
        'nombre' => 'Empresas Talavera'
    ],
    [
        'path' => dirname(__FILE__) . '/../doc/Gestorias-Asesorias Talavera (1).xlsx',
        'lista' => 'Gestorías y Asesorías',
        'nombre' => 'Gestorías-Asesorías Talavera'
    ]
];

$total_importados = 0;
$total_duplicados = 0;
$total_errores = 0;

foreach ($archivos as $archivo_info) {
    echo "<div class='archivo'>";
    echo "<h3>📄 {$archivo_info['nombre']}</h3>";
    
    if (!file_exists($archivo_info['path'])) {
        echo "<div class='resultado error'>❌ Archivo no encontrado</div>";
        echo "</div>";
        continue;
    }
    
    $datos = leer_excel($archivo_info['path']);
    
    if (isset($datos['error'])) {
        echo "<div class='resultado error'>❌ Error: {$datos['error']}</div>";
        echo "</div>";
        continue;
    }
    
    // Saltar encabezados
    array_shift($datos);
    
    $importados = 0;
    $duplicados = 0;
    $errores = 0;
    
    foreach ($datos as $fila) {
        $sector = isset($fila[0]) && !empty($fila[0]) ? trim($fila[0]) : 'Servicios';
        $empresa = isset($fila[1]) ? trim($fila[1]) : '';
        $contacto = isset($fila[2]) ? trim($fila[2]) : '';
        $telefono = isset($fila[3]) ? limpiar_telefono($fila[3]) : '';
        $email = isset($fila[4]) ? validar_email($fila[4]) : '';
        $ciudad = isset($fila[5]) ? trim($fila[5]) : '';
        $provincia = isset($fila[6]) ? trim($fila[6]) : '';
        $notas = isset($fila[7]) ? trim($fila[7]) : '';
        
        // Si no hay contacto, usar empresa
        if (empty($contacto)) {
            $contacto = $empresa;
        }
        
        // Validaciones
        if (empty($empresa) && empty($contacto)) {
            continue;
        }
        
        // Si no hay email, generar temporal
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
                'empresa' => $empresa ?: $contacto,
                'ciudad' => $ciudad,
                'provincia' => $provincia,
                'sector' => $sector,
                'lista' => $archivo_info['lista'],
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
    
    $total_importados += $importados;
    $total_duplicados += $duplicados;
    $total_errores += $errores;
    
    echo "<div class='resultado'>";
    echo "✅ <strong>$importados</strong> clientes importados<br>";
    echo "⚠️ <strong>$duplicados</strong> duplicados omitidos<br>";
    if ($errores > 0) {
        echo "❌ <strong>$errores</strong> errores<br>";
    }
    echo "📋 Lista asignada: <strong>{$archivo_info['lista']}</strong>";
    echo "</div>";
    echo "</div>";
}

echo "<div class='stats'>";
echo "<div class='stat'>";
echo "<div class='stat-number'>$total_importados</div>";
echo "<div class='stat-label'>Total Importados</div>";
echo "</div>";
echo "<div class='stat'>";
echo "<div class='stat-number'>$total_duplicados</div>";
echo "<div class='stat-label'>Duplicados Omitidos</div>";
echo "</div>";
echo "<div class='stat'>";
echo "<div class='stat-number'>$total_errores</div>";
echo "<div class='stat-label'>Errores</div>";
echo "</div>";
echo "</div>";

echo "<div style='text-align: center; margin-top: 30px;'>";
echo "<a href='crm-mailing-completo.php' class='btn'>✅ Ver Clientes en el CRM</a>";
echo "<a href='LIMPIAR-TODO-CRM-YA.php' class='btn' style='background: linear-gradient(135deg, #dc3545, #c82333);'>🗑️ Limpiar Todo</a>";
echo "</div>";

echo "</div></body></html>";
?>

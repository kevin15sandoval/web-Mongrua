<?php
/**
 * Script para importar automáticamente los 3 archivos Excel
 * Usa la estructura correcta detectada por el diagnóstico
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
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>🚀 Importación Automática Excel</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }
        h1 {
            font-size: 32px;
            color: #2d3748;
            margin-bottom: 30px;
            text-align: center;
        }
        .resultado {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            border-left: 5px solid #667eea;
        }
        .exito {
            background: #d4edda;
            border-left-color: #28a745;
        }
        .error {
            background: #f8d7da;
            border-left-color: #dc3545;
        }
        .detalle {
            font-size: 14px;
            color: #718096;
            margin-top: 10px;
            padding: 10px;
            background: white;
            border-radius: 8px;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 15px 35px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🚀 Importación Automática de Excel</h1>";

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
                $fila = [];
                foreach ($row->c as $cell) {
                    $valor = '';
                    if (isset($cell->v)) {
                        if (isset($cell['t']) && $cell['t'] == 's') {
                            $index = (int)$cell->v;
                            $valor = isset($strings[$index]) ? $strings[$index] : '';
                        } else {
                            $valor = (string)$cell->v;
                        }
                    }
                    $fila[] = trim($valor);
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
        'path' => 'C:/Users/USUARIO/Local Sites/mongruasformacion/doc/Empresas de Electricidad.xlsx',
        'lista' => 'Empresas Electricidad'
    ],
    [
        'path' => 'C:/Users/USUARIO/Local Sites/mongruasformacion/doc/Gestorias-Asesorias Talavera.xlsx',
        'lista' => 'Gestorías y Asesorías'
    ],
    [
        'path' => 'C:/Users/USUARIO/Local Sites/mongruasformacion/doc/Empresas Talavera.xlsx',
        'lista' => 'Empresas Talavera'
    ]
];

$total_importados = 0;
$total_duplicados = 0;
$total_errores = 0;

foreach ($archivos as $archivo_info) {
    $archivo_path = $archivo_info['path'];
    $lista = $archivo_info['lista'];
    $nombre_archivo = basename($archivo_path);
    
    echo "<div class='resultado'>";
    echo "<h3>📄 Procesando: $nombre_archivo</h3>";
    
    if (!file_exists($archivo_path)) {
        echo "<p class='error'>❌ Archivo no encontrado</p>";
        echo "</div>";
        continue;
    }
    
    $datos = leer_excel($archivo_path);
    
    if (isset($datos['error'])) {
        echo "<p class='error'>❌ Error: " . $datos['error'] . "</p>";
        echo "</div>";
        continue;
    }
    
    // Saltar encabezados
    array_shift($datos);
    
    $importados = 0;
    $duplicados = 0;
    $errores = 0;
    
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
        
        if (empty($empresa)) {
            continue;
        }
        
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
                'notas' => '',
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
    
    echo "<div class='detalle exito'>";
    echo "✅ <strong>$importados</strong> clientes importados<br>";
    echo "⚠️ <strong>$duplicados</strong> duplicados omitidos<br>";
    if ($errores > 0) {
        echo "❌ <strong>$errores</strong> errores<br>";
    }
    echo "📋 Lista asignada: <strong>$lista</strong>";
    echo "</div>";
    echo "</div>";
}

echo "<div class='resultado exito'>";
echo "<h2>🎉 Importación Completada</h2>";
echo "<div class='detalle'>";
echo "✅ Total importados: <strong>$total_importados</strong> clientes<br>";
echo "⚠️ Total duplicados: <strong>$total_duplicados</strong><br>";
echo "❌ Total errores: <strong>$total_errores</strong>";
echo "</div>";
echo "</div>";

echo "<div style='text-align: center;'>";
echo "<a href='crm-mailing-completo.php' class='btn'>📊 Ver CRM Completo</a>";
echo "</div>";

echo "</div></body></html>";
?>

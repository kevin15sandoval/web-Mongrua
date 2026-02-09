<?php
/**
 * Diagnóstico de Campañas - Ver qué está pasando
 */

require_once('wp-config.php');
require_once('wp-load.php');

global $wpdb;
$table_campanas = $wpdb->prefix . 'mongruas_campanas';

echo "<h1>🔍 Diagnóstico de Campañas</h1>";

// 1. Verificar que la tabla existe
echo "<h2>1️⃣ Verificar Tabla de Campañas</h2>";
$tabla_existe = $wpdb->get_var("SHOW TABLES LIKE '$table_campanas'");
if ($tabla_existe) {
    echo "<p style='color: green;'>✅ La tabla <strong>$table_campanas</strong> existe</p>";
    
    // Mostrar estructura
    $estructura = $wpdb->get_results("DESCRIBE $table_campanas");
    echo "<h3>Estructura de la tabla:</h3>";
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
    echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    foreach ($estructura as $campo) {
        echo "<tr>";
        echo "<td>{$campo->Field}</td>";
        echo "<td>{$campo->Type}</td>";
        echo "<td>{$campo->Null}</td>";
        echo "<td>{$campo->Key}</td>";
        echo "<td>{$campo->Default}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: red;'>❌ La tabla <strong>$table_campanas</strong> NO existe</p>";
    echo "<p>Creando tabla...</p>";
    
    $sql = "CREATE TABLE IF NOT EXISTS $table_campanas (
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
    
    $wpdb->query($sql);
    echo "<p style='color: green;'>✅ Tabla creada</p>";
}

// 2. Ver campañas existentes
echo "<h2>2️⃣ Campañas Existentes</h2>";
$campanas = $wpdb->get_results("SELECT * FROM $table_campanas ORDER BY fecha_creacion DESC LIMIT 10");
if ($campanas) {
    echo "<p>Total de campañas: <strong>" . count($campanas) . "</strong></p>";
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Asunto</th><th>Segmento</th><th>Estado</th><th>Fecha</th></tr>";
    foreach ($campanas as $campana) {
        echo "<tr>";
        echo "<td>{$campana->id}</td>";
        echo "<td>{$campana->nombre}</td>";
        echo "<td>{$campana->asunto}</td>";
        echo "<td>{$campana->segmento}</td>";
        echo "<td>{$campana->estado}</td>";
        echo "<td>{$campana->fecha_creacion}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: orange;'>⚠️ No hay campañas creadas todavía</p>";
}

// 3. Probar crear una campaña de prueba
echo "<h2>3️⃣ Probar Crear Campaña</h2>";
if (isset($_POST['crear_prueba'])) {
    $resultado = $wpdb->insert(
        $table_campanas,
        array(
            'nombre' => 'Campaña de Prueba',
            'asunto' => 'Asunto de Prueba',
            'contenido' => 'Contenido de prueba con [NOMBRE] y [EMPRESA]',
            'segmento' => 'todos'
        )
    );
    
    if ($resultado) {
        echo "<p style='color: green;'>✅ Campaña de prueba creada correctamente</p>";
        echo "<p>ID insertado: " . $wpdb->insert_id . "</p>";
    } else {
        echo "<p style='color: red;'>❌ Error al crear campaña de prueba</p>";
        echo "<p>Error: " . $wpdb->last_error . "</p>";
    }
} else {
    echo "<form method='post'>";
    echo "<button type='submit' name='crear_prueba' style='padding: 15px 30px; background: #28a745; color: white; border: none; border-radius: 8px; font-size: 16px; cursor: pointer;'>🧪 Crear Campaña de Prueba</button>";
    echo "</form>";
}

// 4. Ver errores de JavaScript
echo "<h2>4️⃣ Verificar JavaScript</h2>";
echo "<p>Abre la <strong>Consola del Navegador</strong> (F12) y busca errores en rojo.</p>";
echo "<p>Los errores comunes son:</p>";
echo "<ul>";
echo "<li><code>Uncaught SyntaxError</code> - Error de sintaxis en JavaScript</li>";
echo "<li><code>Unexpected token</code> - Carácter inesperado</li>";
echo "<li><code>... is not defined</code> - Función no encontrada</li>";
echo "</ul>";

echo "<h3>Probar función seleccionarDestinatarios:</h3>";
echo "<button onclick='testFunction()' style='padding: 10px 20px; background: #0066cc; color: white; border: none; border-radius: 8px; cursor: pointer;'>🧪 Probar Función</button>";
echo "<div id='resultado-test' style='margin-top: 10px; padding: 15px; background: #f8f9fa; border-radius: 8px; display: none;'></div>";

echo "<script>";
echo "function testFunction() {";
echo "  const resultado = document.getElementById('resultado-test');";
echo "  resultado.style.display = 'block';";
echo "  ";
echo "  if (typeof seleccionarDestinatarios === 'function') {";
echo "    resultado.innerHTML = '<p style=\"color: green;\">✅ La función seleccionarDestinatarios existe</p>';";
echo "  } else {";
echo "    resultado.innerHTML = '<p style=\"color: red;\">❌ La función seleccionarDestinatarios NO existe</p>';";
echo "  }";
echo "}";
echo "</script>";

echo "<hr>";
echo "<h2>5️⃣ Siguiente Paso</h2>";
echo "<p>Si todo está bien aquí, el problema es en el archivo <code>crm-mailing-completo.php</code></p>";
echo "<p><a href='crm-mailing-completo.php' style='padding: 15px 30px; background: #0066cc; color: white; text-decoration: none; border-radius: 8px; display: inline-block;'>🔙 Volver al CRM</a></p>";
?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background: #f1f3f4;
}

h1, h2, h3 {
    color: #2d3748;
}

table {
    background: white;
    margin: 20px 0;
}

th {
    background: #f8f9fa;
    font-weight: 700;
}
</style>

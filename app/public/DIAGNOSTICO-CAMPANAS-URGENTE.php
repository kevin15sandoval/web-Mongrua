<?php
/**
 * Diagnóstico Urgente - Sistema de Campañas
 * Verificar qué está fallando exactamente
 */

require_once('wp-config.php');
require_once('wp-load.php');

global $wpdb;
$table_campanas = $wpdb->prefix . 'mongruas_campanas';

echo "<h1>🔍 Diagnóstico Urgente - Sistema de Campañas</h1>";

echo "<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background: #f1f3f4;
}
.section {
    background: white;
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.success { color: #28a745; font-weight: bold; }
.error { color: #dc3545; font-weight: bold; }
.warning { color: #ffc107; font-weight: bold; }
.code {
    background: #2d3748;
    color: #e2e8f0;
    padding: 15px;
    border-radius: 8px;
    font-family: monospace;
    overflow-x: auto;
    margin: 10px 0;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin: 15px 0;
}
th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
}
th {
    background: #f8f9fa;
    font-weight: 700;
}
.btn {
    display: inline-block;
    padding: 12px 24px;
    background: #0066cc;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    margin: 5px;
}
</style>";

// 1. Verificar campañas existentes
echo "<div class='section'>";
echo "<h2>📋 1. Campañas en Base de Datos</h2>";

$campanas = $wpdb->get_results("SELECT * FROM $table_campanas ORDER BY fecha_creacion DESC LIMIT 10");

if ($campanas) {
    echo "<p class='success'>✅ Se encontraron " . count($campanas) . " campañas</p>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Estado</th><th>Segmento</th><th>Fecha</th><th>Datos</th></tr>";
    foreach ($campanas as $campana) {
        echo "<tr>";
        echo "<td><strong>#{$campana->id}</strong></td>";
        echo "<td>" . esc_html($campana->nombre) . "</td>";
        echo "<td><span style='padding: 5px 10px; background: " . ($campana->estado === 'borrador' ? '#ffc107' : '#28a745') . "; color: white; border-radius: 5px;'>{$campana->estado}</span></td>";
        echo "<td>" . esc_html($campana->segmento) . "</td>";
        echo "<td>" . date('d/m/Y H:i', strtotime($campana->fecha_creacion)) . "</td>";
        echo "<td>";
        echo "<div style='font-size: 11px; color: #718096;'>";
        echo "Asunto: " . esc_html(substr($campana->asunto, 0, 30)) . "...<br>";
        echo "Contenido: " . strlen($campana->contenido) . " caracteres";
        echo "</div>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='warning'>⚠️ No hay campañas en la base de datos</p>";
}
echo "</div>";

// 2. Verificar estructura de la tabla
echo "<div class='section'>";
echo "<h2>🗄️ 2. Estructura de Tabla de Campañas</h2>";

$columnas = $wpdb->get_results("DESCRIBE $table_campanas");
echo "<table>";
echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Default</th></tr>";
foreach ($columnas as $col) {
    echo "<tr>";
    echo "<td><strong>{$col->Field}</strong></td>";
    echo "<td>{$col->Type}</td>";
    echo "<td>{$col->Null}</td>";
    echo "<td>" . ($col->Default ?: '-') . "</td>";
    echo "</tr>";
}
echo "</table>";
echo "</div>";

// 3. Simular creación de botón
echo "<div class='section'>";
echo "<h2>🔘 3. Simulación de Botón 'Editar y Enviar'</h2>";

if ($campanas && count($campanas) > 0) {
    $campana_test = $campanas[0];
    
    echo "<p>Usando campaña de prueba: <strong>" . esc_html($campana_test->nombre) . "</strong></p>";
    
    echo "<h3>HTML del Botón:</h3>";
    echo "<div class='code'>";
    echo htmlspecialchars('
<button 
    type="button"
    onclick="abrirEditorCampana(' . $campana_test->id . ')"
    class="btn btn-primary" 
    data-campana-id="' . $campana_test->id . '"
    data-campana-nombre="' . esc_attr($campana_test->nombre) . '"
    data-campana-asunto="' . esc_attr($campana_test->asunto) . '"
    data-campana-contenido="' . esc_attr($campana_test->contenido) . '"
    data-campana-segmento="' . esc_attr($campana_test->segmento) . '"
    style="padding: 8px 15px; margin: 0 0 5px 0; font-size: 13px; display: block; width: 100%;">
    📝 Editar y Enviar
</button>
    ');
    echo "</div>";
    
    echo "<h3>Botón Real (haz clic para probar):</h3>";
    echo '<button 
        type="button"
        onclick="testAbrirEditor(' . $campana_test->id . ')"
        class="btn" 
        data-campana-id="' . $campana_test->id . '"
        data-campana-nombre="' . esc_attr($campana_test->nombre) . '"
        data-campana-asunto="' . esc_attr($campana_test->asunto) . '"
        data-campana-contenido="' . esc_attr(substr($campana_test->contenido, 0, 100)) . '"
        data-campana-segmento="' . esc_attr($campana_test->segmento) . '"
        style="padding: 12px 24px; font-size: 16px;">
        📝 TEST: Editar y Enviar
    </button>';
    
    echo "<div id='resultado-test' style='margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px; display: none;'></div>";
    
    echo "<script>
    function testAbrirEditor(campanaId) {
        const boton = event.target;
        const resultado = document.getElementById('resultado-test');
        
        resultado.style.display = 'block';
        resultado.innerHTML = '<h4>📊 Datos Capturados del Botón:</h4>';
        resultado.innerHTML += '<p><strong>ID Campaña:</strong> ' + campanaId + '</p>';
        resultado.innerHTML += '<p><strong>Nombre:</strong> ' + boton.dataset.campanaNombre + '</p>';
        resultado.innerHTML += '<p><strong>Asunto:</strong> ' + boton.dataset.campanaAsunto + '</p>';
        resultado.innerHTML += '<p><strong>Segmento:</strong> ' + boton.dataset.campanaSegmento + '</p>';
        resultado.innerHTML += '<p><strong>Contenido (primeros 100 chars):</strong> ' + boton.dataset.campanaContenido + '</p>';
        
        resultado.innerHTML += '<hr>';
        resultado.innerHTML += '<p style=\"color: #28a745; font-weight: bold;\">✅ El botón funciona correctamente!</p>';
        resultado.innerHTML += '<p>Los data attributes se están leyendo bien. El problema debe estar en:</p>';
        resultado.innerHTML += '<ul>';
        resultado.innerHTML += '<li>La función abrirEditorCampana() no existe o tiene errores</li>';
        resultado.innerHTML += '<li>El modal no se está mostrando</li>';
        resultado.innerHTML += '<li>Hay un error de JavaScript en la consola</li>';
        resultado.innerHTML += '</ul>';
        
        // Intentar abrir el modal si existe
        const modal = document.getElementById('modalEditorCampana');
        if (modal) {
            resultado.innerHTML += '<p style=\"color: #28a745;\">✅ Modal encontrado en el DOM</p>';
            resultado.innerHTML += '<button onclick=\"document.getElementById(\\'modalEditorCampana\\').style.display=\\'flex\\'\" style=\"padding: 10px 20px; background: #0066cc; color: white; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;\">Abrir Modal Manualmente</button>';
        } else {
            resultado.innerHTML += '<p style=\"color: #dc3545;\">❌ Modal NO encontrado en el DOM</p>';
        }
        
        console.log('Test ejecutado:', {
            id: campanaId,
            nombre: boton.dataset.campanaNombre,
            asunto: boton.dataset.campanaAsunto,
            segmento: boton.dataset.campanaSegmento
        });
    }
    </script>";
} else {
    echo "<p class='warning'>⚠️ No hay campañas para probar</p>";
}
echo "</div>";

// 4. Verificar JavaScript en consola
echo "<div class='section'>";
echo "<h2>🐛 4. Verificación de JavaScript</h2>";
echo "<p>Abre la consola del navegador (F12) y verifica:</p>";
echo "<ol>";
echo "<li>¿Hay errores de JavaScript?</li>";
echo "<li>¿Existe la función <code>abrirEditorCampana</code>?</li>";
echo "<li>¿Existe el elemento <code>#modalEditorCampana</code>?</li>";
echo "</ol>";

echo "<button onclick='verificarJavaScript()' class='btn'>🔍 Verificar JavaScript</button>";
echo "<div id='resultado-js' style='margin-top: 15px;'></div>";

echo "<script>
function verificarJavaScript() {
    const resultado = document.getElementById('resultado-js');
    let html = '<div style=\"background: #f8f9fa; padding: 15px; border-radius: 8px;\">';
    
    // Verificar función
    if (typeof abrirEditorCampana === 'function') {
        html += '<p class=\"success\">✅ Función abrirEditorCampana() existe</p>';
    } else {
        html += '<p class=\"error\">❌ Función abrirEditorCampana() NO existe</p>';
    }
    
    // Verificar modal
    const modal = document.getElementById('modalEditorCampana');
    if (modal) {
        html += '<p class=\"success\">✅ Modal #modalEditorCampana existe en el DOM</p>';
        html += '<p>Display actual: <code>' + modal.style.display + '</code></p>';
    } else {
        html += '<p class=\"error\">❌ Modal #modalEditorCampana NO existe en el DOM</p>';
    }
    
    // Verificar campos del modal
    const campos = [
        'edit_campana_id',
        'edit_campana_nombre',
        'edit_campana_asunto',
        'edit_campana_contenido',
        'edit_campana_segmento'
    ];
    
    html += '<h4>Campos del Modal:</h4><ul>';
    campos.forEach(campo => {
        const elemento = document.getElementById(campo);
        if (elemento) {
            html += '<li class=\"success\">✅ ' + campo + '</li>';
        } else {
            html += '<li class=\"error\">❌ ' + campo + ' (FALTA)</li>';
        }
    });
    html += '</ul>';
    
    html += '</div>';
    resultado.innerHTML = html;
}
</script>";
echo "</div>";

// 5. Crear campaña de prueba
echo "<div class='section'>";
echo "<h2>➕ 5. Crear Campaña de Prueba</h2>";

if (isset($_POST['crear_test'])) {
    $resultado = $wpdb->insert(
        $table_campanas,
        array(
            'nombre' => 'Campaña de Prueba ' . date('H:i:s'),
            'asunto' => 'Asunto de Prueba',
            'contenido' => '<p>Este es un contenido de prueba para verificar el sistema.</p>',
            'segmento' => 'todos',
            'estado' => 'borrador'
        )
    );
    
    if ($resultado) {
        echo "<p class='success'>✅ Campaña de prueba creada con ID: " . $wpdb->insert_id . "</p>";
        echo "<script>setTimeout(() => location.reload(), 1000);</script>";
    } else {
        echo "<p class='error'>❌ Error al crear campaña: " . $wpdb->last_error . "</p>";
    }
}

echo "<form method='post'>";
echo "<input type='hidden' name='crear_test' value='1'>";
echo "<button type='submit' class='btn'>➕ Crear Campaña de Prueba</button>";
echo "</form>";
echo "</div>";

// 6. Enlaces útiles
echo "<div class='section'>";
echo "<h2>🔗 6. Enlaces de Navegación</h2>";
echo "<a href='crm-mailing-completo.php' class='btn'>📧 Ir al CRM Completo</a>";
echo "<a href='crm-mailing-completo.php#campanas' class='btn'>📋 Ir a Pestaña Campañas</a>";
echo "<a href='?refresh=1' class='btn'>🔄 Recargar Diagnóstico</a>";
echo "</div>";

// 7. Código de ejemplo para copiar
echo "<div class='section'>";
echo "<h2>📝 7. Código JavaScript para Probar en Consola</h2>";
echo "<p>Copia y pega esto en la consola del navegador cuando estés en crm-mailing-completo.php:</p>";
echo "<div class='code'>";
echo htmlspecialchars("
// Verificar que todo existe
console.log('Función existe:', typeof abrirEditorCampana);
console.log('Modal existe:', document.getElementById('modalEditorCampana'));
console.log('Campos:', {
    id: document.getElementById('edit_campana_id'),
    nombre: document.getElementById('edit_campana_nombre'),
    asunto: document.getElementById('edit_campana_asunto'),
    contenido: document.getElementById('edit_campana_contenido'),
    segmento: document.getElementById('edit_campana_segmento')
});

// Intentar abrir el modal manualmente
const modal = document.getElementById('modalEditorCampana');
if (modal) {
    modal.style.display = 'flex';
    console.log('Modal abierto manualmente');
}
");
echo "</div>";
echo "</div>";
?>

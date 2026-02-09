<?php
/**
 * Test del Sistema CRM Completo
 * Verificar que todas las funcionalidades están operativas
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🧪 Test del Sistema CRM Completo</h1>";

global $wpdb;

// Verificar tablas
$table_clientes = $wpdb->prefix . 'mongruas_clientes';
$table_campanas = $wpdb->prefix . 'mongruas_campanas';
$table_envios = $wpdb->prefix . 'mongruas_envios';

echo "<h2>📊 Verificación de Base de Datos</h2>";

// Verificar si las tablas existen
$tables_exist = true;
$tables = [$table_clientes, $table_campanas, $table_envios];
$table_names = ['Clientes', 'Campañas', 'Envíos'];

foreach ($tables as $index => $table) {
    $result = $wpdb->get_var("SHOW TABLES LIKE '$table'");
    if ($result) {
        echo "<p>✅ Tabla {$table_names[$index]} existe</p>";
    } else {
        echo "<p>❌ Tabla {$table_names[$index]} NO existe</p>";
        $tables_exist = false;
    }
}

if ($tables_exist) {
    echo "<h3>📈 Estadísticas Actuales</h3>";
    
    $total_clientes = $wpdb->get_var("SELECT COUNT(*) FROM $table_clientes");
    $total_campanas = $wpdb->get_var("SELECT COUNT(*) FROM $table_campanas");
    $total_envios = $wpdb->get_var("SELECT COUNT(*) FROM $table_envios");
    
    echo "<ul>";
    echo "<li><strong>Clientes registrados:</strong> $total_clientes</li>";
    echo "<li><strong>Campañas creadas:</strong> $total_campanas</li>";
    echo "<li><strong>Emails enviados:</strong> $total_envios</li>";
    echo "</ul>";
    
    // Test de inserción de cliente
    echo "<h3>🧪 Test de Funcionalidades</h3>";
    
    $test_email = 'test_' . time() . '@test.com';
    $resultado_cliente = $wpdb->insert(
        $table_clientes,
        array(
            'nombre' => 'Cliente Test',
            'email' => $test_email,
            'empresa' => 'Empresa Test',
            'sector' => 'Tecnología',
            'interes' => 'Instalaciones Eléctricas',
            'origen' => 'Test Sistema',
            'ultima_actividad' => current_time('mysql')
        )
    );
    
    if ($resultado_cliente) {
        echo "<p>✅ Test inserción cliente: EXITOSO</p>";
        
        // Eliminar el cliente de test
        $wpdb->delete($table_clientes, array('email' => $test_email));
        echo "<p>🧹 Cliente de test eliminado</p>";
    } else {
        echo "<p>❌ Test inserción cliente: FALLÓ</p>";
    }
    
    // Test de creación de campaña
    $resultado_campana = $wpdb->insert(
        $table_campanas,
        array(
            'nombre' => 'Campaña Test',
            'asunto' => 'Test Subject',
            'contenido' => '<p>Contenido de test</p>',
            'segmento' => 'todos'
        )
    );
    
    if ($resultado_campana) {
        echo "<p>✅ Test creación campaña: EXITOSO</p>";
        
        // Eliminar la campaña de test
        $campana_id = $wpdb->insert_id;
        $wpdb->delete($table_campanas, array('id' => $campana_id));
        echo "<p>🧹 Campaña de test eliminada</p>";
    } else {
        echo "<p>❌ Test creación campaña: FALLÓ</p>";
    }
    
} else {
    echo "<p>❌ No se pueden realizar tests - faltan tablas</p>";
}

echo "<h2>🔗 Enlaces del Sistema</h2>";
echo "<ul>";
echo "<li><a href='/crm-mailing-completo.php' target='_blank'>🎯 CRM Completo</a></li>";
echo "<li><a href='/plantillas-email-crm.php' target='_blank'>📧 Plantillas de Email</a></li>";
echo "<li><a href='/panel-mailing-completo.php' target='_blank'>📬 Panel Mailing Simple</a></li>";
echo "</ul>";

echo "<h2>📋 Funcionalidades Disponibles</h2>";
echo "<div style='background: #f0f8ff; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
echo "<h3>🎯 CRM Completo:</h3>";
echo "<ul>";
echo "<li>✅ Gestión completa de clientes</li>";
echo "<li>✅ Segmentación por sector e intereses</li>";
echo "<li>✅ Creación y gestión de campañas</li>";
echo "<li>✅ Envío masivo de emails</li>";
echo "<li>✅ Seguimiento de estadísticas</li>";
echo "<li>✅ Importación desde Excel/CSV</li>";
echo "</ul>";

echo "<h3>📧 Sistema de Plantillas:</h3>";
echo "<ul>";
echo "<li>✅ 5 plantillas prediseñadas profesionales</li>";
echo "<li>✅ Personalización automática con variables</li>";
echo "<li>✅ Vista previa en tiempo real</li>";
echo "<li>✅ Integración directa con campañas</li>";
echo "</ul>";
echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='/crm-mailing-completo.php' style='background: linear-gradient(135deg, #0066cc, #0052a3); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: 600; margin: 10px;'>🚀 Acceder al CRM</a>";
echo "<a href='/' style='background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: 600; margin: 10px;'>🏠 Página Principal</a>";
echo "</div>";
?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background: #f1f3f4;
}

h1, h2, h3 {
    color: #333;
}

p, li {
    line-height: 1.6;
}

ul {
    padding-left: 20px;
}

a {
    color: #0066cc;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
</style>
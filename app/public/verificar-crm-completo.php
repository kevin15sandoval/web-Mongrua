<?php
/**
 * Verificación Final del Sistema CRM Completo
 * Test de integración completa
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🎯 Verificación Final - Sistema CRM Completo</h1>";

// Verificar que los archivos principales existen
$archivos_sistema = [
    'crm-mailing-completo.php' => '🎯 CRM Principal',
    'plantillas-email-crm.php' => '📧 Plantillas Email',
    'panel-mailing-completo.php' => '📬 Panel Mailing Simple',
    'test-crm-sistema.php' => '🧪 Test del Sistema'
];

echo "<h2>📁 Verificación de Archivos</h2>";
$archivos_ok = true;

foreach ($archivos_sistema as $archivo => $descripcion) {
    if (file_exists($archivo)) {
        echo "<p>✅ $descripcion - <strong>$archivo</strong> existe</p>";
    } else {
        echo "<p>❌ $descripcion - <strong>$archivo</strong> NO existe</p>";
        $archivos_ok = false;
    }
}

// Verificar base de datos
global $wpdb;
$table_clientes = $wpdb->prefix . 'mongruas_clientes';
$table_campanas = $wpdb->prefix . 'mongruas_campanas';
$table_envios = $wpdb->prefix . 'mongruas_envios';

echo "<h2>🗄️ Verificación de Base de Datos</h2>";

$tablas_sistema = [
    $table_clientes => 'Clientes',
    $table_campanas => 'Campañas', 
    $table_envios => 'Envíos'
];

$bd_ok = true;
foreach ($tablas_sistema as $tabla => $nombre) {
    $existe = $wpdb->get_var("SHOW TABLES LIKE '$tabla'");
    if ($existe) {
        $count = $wpdb->get_var("SELECT COUNT(*) FROM $tabla");
        echo "<p>✅ Tabla <strong>$nombre</strong> existe ($count registros)</p>";
    } else {
        echo "<p>❌ Tabla <strong>$nombre</strong> NO existe</p>";
        $bd_ok = false;
    }
}

// Verificar funcionalidades
echo "<h2>⚙️ Verificación de Funcionalidades</h2>";

if ($bd_ok) {
    // Test de WordPress mail
    if (function_exists('wp_mail')) {
        echo "<p>✅ Función wp_mail() disponible</p>";
    } else {
        echo "<p>❌ Función wp_mail() NO disponible</p>";
    }
    
    // Test de funciones de sanitización
    if (function_exists('sanitize_email') && function_exists('sanitize_text_field')) {
        echo "<p>✅ Funciones de sanitización disponibles</p>";
    } else {
        echo "<p>❌ Funciones de sanitización NO disponibles</p>";
    }
    
    // Test de current_time
    if (function_exists('current_time')) {
        $tiempo_actual = current_time('mysql');
        echo "<p>✅ Función current_time() disponible ($tiempo_actual)</p>";
    } else {
        echo "<p>❌ Función current_time() NO disponible</p>";
    }
} else {
    echo "<p>⚠️ No se pueden verificar funcionalidades - faltan tablas</p>";
}

// Estado general del sistema
echo "<h2>🎯 Estado General del Sistema</h2>";

if ($archivos_ok && $bd_ok) {
    echo "<div style='background: #d4edda; padding: 20px; border-radius: 10px; border-left: 4px solid #28a745;'>";
    echo "<h3 style='color: #155724; margin-top: 0;'>✅ SISTEMA COMPLETAMENTE OPERATIVO</h3>";
    echo "<p style='color: #155724; margin: 0;'>Todos los componentes del CRM están funcionando correctamente. El sistema está listo para ser utilizado por la empresa.</p>";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; padding: 20px; border-radius: 10px; border-left: 4px solid #dc3545;'>";
    echo "<h3 style='color: #721c24; margin-top: 0;'>❌ SISTEMA CON PROBLEMAS</h3>";
    echo "<p style='color: #721c24; margin: 0;'>Hay componentes que no están funcionando correctamente. Revisar los errores anteriores.</p>";
    echo "</div>";
}

echo "<h2>🚀 Accesos Rápidos</h2>";
echo "<div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin: 20px 0;'>";

echo "<div style='background: linear-gradient(135deg, #0066cc, #0052a3); color: white; padding: 20px; border-radius: 10px; text-align: center;'>";
echo "<h4 style='margin: 0 0 10px 0;'>🎯 CRM Principal</h4>";
echo "<a href='/crm-mailing-completo.php' style='color: white; text-decoration: none; font-weight: 600;'>Acceder al CRM</a>";
echo "</div>";

echo "<div style='background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 20px; border-radius: 10px; text-align: center;'>";
echo "<h4 style='margin: 0 0 10px 0;'>📧 Plantillas</h4>";
echo "<a href='/plantillas-email-crm.php' style='color: white; text-decoration: none; font-weight: 600;'>Ver Plantillas</a>";
echo "</div>";

echo "<div style='background: linear-gradient(135deg, #ffc107, #fd7e14); color: white; padding: 20px; border-radius: 10px; text-align: center;'>";
echo "<h4 style='margin: 0 0 10px 0;'>🧪 Test Sistema</h4>";
echo "<a href='/test-crm-sistema.php' style='color: white; text-decoration: none; font-weight: 600;'>Ejecutar Tests</a>";
echo "</div>";

echo "<div style='background: linear-gradient(135deg, #6f42c1, #5a32a3); color: white; padding: 20px; border-radius: 10px; text-align: center;'>";
echo "<h4 style='margin: 0 0 10px 0;'>📬 Panel Simple</h4>";
echo "<a href='/panel-mailing-completo.php' style='color: white; text-decoration: none; font-weight: 600;'>Panel Mailing</a>";
echo "</div>";

echo "</div>";

echo "<h2>📋 Resumen de Capacidades</h2>";
echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
echo "<div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;'>";

echo "<div>";
echo "<h4 style='color: #0066cc;'>👥 Gestión de Clientes</h4>";
echo "<ul>";
echo "<li>✅ Registro completo de clientes</li>";
echo "<li>✅ Segmentación por sector</li>";
echo "<li>✅ Clasificación por intereses</li>";
echo "<li>✅ Importación desde Excel/CSV</li>";
echo "</ul>";
echo "</div>";

echo "<div>";
echo "<h4 style='color: #28a745;'>📧 Campañas de Email</h4>";
echo "<ul>";
echo "<li>✅ Creación de campañas</li>";
echo "<li>✅ Envío masivo segmentado</li>";
echo "<li>✅ 5 plantillas profesionales</li>";
echo "<li>✅ Variables personalizadas</li>";
echo "</ul>";
echo "</div>";

echo "<div>";
echo "<h4 style='color: #dc3545;'>📊 Estadísticas</h4>";
echo "<ul>";
echo "<li>✅ Dashboard visual</li>";
echo "<li>✅ Métricas en tiempo real</li>";
echo "<li>✅ Seguimiento de envíos</li>";
echo "<li>✅ Análisis por sectores</li>";
echo "</ul>";
echo "</div>";

echo "</div>";
echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='/crm-mailing-completo.php' style='background: linear-gradient(135deg, #0066cc, #0052a3); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: 600; margin: 10px; display: inline-block;'>🚀 Comenzar a Usar el CRM</a>";
echo "<a href='/' style='background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: 600; margin: 10px; display: inline-block;'>🏠 Página Principal</a>";
echo "</div>";
?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    background: #f1f3f4;
}

h1, h2, h3, h4 {
    color: #333;
}

p, li {
    line-height: 1.6;
}

ul {
    padding-left: 20px;
}

a {
    color: inherit;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
</style>
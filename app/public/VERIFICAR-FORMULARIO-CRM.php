<?php
/**
 * Verificar si el formulario está guardando en el CRM
 */

require_once('wp-config.php');
require_once('wp-load.php');

global $wpdb;
$table_clientes = $wpdb->prefix . 'mongruas_clientes';

echo "<h1>🔍 Verificación del Formulario de Contacto</h1>";

echo "<div style='background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📊 Últimos 10 contactos en el CRM</h2>";

// Obtener últimos contactos
$contactos = $wpdb->get_results("SELECT * FROM $table_clientes ORDER BY fecha_registro DESC LIMIT 10");

if ($contactos) {
    echo "<table style='width: 100%; border-collapse: collapse; background: white;'>";
    echo "<thead>";
    echo "<tr style='background: #0066cc; color: white;'>";
    echo "<th style='padding: 10px; border: 1px solid #ddd;'>ID</th>";
    echo "<th style='padding: 10px; border: 1px solid #ddd;'>Nombre</th>";
    echo "<th style='padding: 10px; border: 1px solid #ddd;'>Email</th>";
    echo "<th style='padding: 10px; border: 1px solid #ddd;'>Teléfono</th>";
    echo "<th style='padding: 10px; border: 1px solid #ddd;'>Empresa</th>";
    echo "<th style='padding: 10px; border: 1px solid #ddd;'>Lista</th>";
    echo "<th style='padding: 10px; border: 1px solid #ddd;'>Origen</th>";
    echo "<th style='padding: 10px; border: 1px solid #ddd;'>Fecha</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    
    foreach ($contactos as $contacto) {
        $es_nuevo = (strtotime($contacto->fecha_registro) > strtotime('-5 minutes'));
        $estilo = $es_nuevo ? "background: #d4edda; font-weight: bold;" : "";
        
        echo "<tr style='$estilo'>";
        echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $contacto->id . "</td>";
        echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . esc_html($contacto->nombre) . "</td>";
        echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . esc_html($contacto->email) . "</td>";
        echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . esc_html($contacto->telefono) . "</td>";
        echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . esc_html($contacto->empresa) . "</td>";
        echo "<td style='padding: 10px; border: 1px solid #ddd;'><strong>" . esc_html($contacto->lista) . "</strong></td>";
        echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . esc_html($contacto->origen) . "</td>";
        echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . date('d/m/Y H:i', strtotime($contacto->fecha_registro)) . "</td>";
        echo "</tr>";
    }
    
    echo "</tbody>";
    echo "</table>";
    
    echo "<p style='margin-top: 20px; color: #28a745; font-weight: bold;'>✅ Los contactos en verde son de los últimos 5 minutos</p>";
} else {
    echo "<p style='color: #dc3545; font-weight: bold;'>❌ No hay contactos en el CRM todavía</p>";
}

echo "</div>";

// Verificar configuración de email
echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📧 Configuración de Email</h2>";
echo "<p><strong>Email de destino configurado:</strong> kevin15sandoval@gmail.com</p>";
echo "<p><strong>Función wp_mail disponible:</strong> " . (function_exists('wp_mail') ? '✅ Sí' : '❌ No') . "</p>";

// Verificar si hay plugin SMTP
$smtp_plugins = array(
    'wp-mail-smtp/wp_mail_smtp.php' => 'WP Mail SMTP',
    'easy-wp-smtp/easy-wp-smtp.php' => 'Easy WP SMTP',
    'post-smtp/postman-smtp.php' => 'Post SMTP'
);

$smtp_activo = false;
foreach ($smtp_plugins as $plugin => $nombre) {
    if (is_plugin_active($plugin)) {
        echo "<p style='color: #28a745;'><strong>✅ Plugin SMTP activo:</strong> $nombre</p>";
        $smtp_activo = true;
    }
}

if (!$smtp_activo) {
    echo "<p style='color: #dc3545;'><strong>⚠️ No hay plugin SMTP activo</strong></p>";
    echo "<p>En un servidor local, WordPress NO puede enviar correos sin un plugin SMTP configurado.</p>";
    echo "<p><strong>Soluciones:</strong></p>";
    echo "<ul>";
    echo "<li>Instalar y configurar <strong>WP Mail SMTP</strong> plugin</li>";
    echo "<li>O verificar que el formulario guarda en el CRM (lo más importante)</li>";
    echo "<li>Los correos funcionarán automáticamente cuando subas el sitio a producción</li>";
    echo "</ul>";
}

echo "</div>";

// Instrucciones
echo "<div style='background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📋 Instrucciones de Prueba</h2>";
echo "<ol>";
echo "<li><strong>Rellena el formulario de contacto</strong> en la página principal</li>";
echo "<li><strong>Marca el checkbox</strong> 'Deseo recibir información sobre cursos y novedades'</li>";
echo "<li><strong>Envía el formulario</strong></li>";
echo "<li><strong>Recarga esta página</strong> (F5)</li>";
echo "<li><strong>Verifica</strong> que aparece tu contacto en la tabla de arriba con fondo verde</li>";
echo "<li><strong>Lista debe ser:</strong> 'Leads Web'</li>";
echo "<li><strong>Origen debe ser:</strong> 'Formulario Web'</li>";
echo "</ol>";
echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='crm-mailing-completo.php' style='background: #0066cc; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block;'>📊 Ver CRM Completo</a>";
echo " ";
echo "<a href='?' style='background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block;'>🔄 Recargar Verificación</a>";
echo "</div>";

echo "<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background: #f1f3f4;
}
h1, h2 {
    color: #2d3748;
}
</style>";
?>

<?php
/**
 * 🧪 TEST EXCEL IMPORT
 * 
 * Prueba rápida para verificar que el importador de Excel funciona
 */

// Cargar WordPress
require_once('wp-load.php');

echo "<h1>🧪 Test Excel Import</h1>";

// Verificar que el archivo existe
$archivo = 'importar-excel-simple.php';
if (file_exists($archivo)) {
    echo "<p>✅ Archivo $archivo existe</p>";
} else {
    echo "<p>❌ Archivo $archivo NO existe</p>";
}

// Verificar MailPoet
$mailpoet_active = is_plugin_active('mailpoet/mailpoet.php');
$mailpoet_class_exists = class_exists('\MailPoet\API\API');

echo "<p>MailPoet activo: " . ($mailpoet_active ? '✅ Sí' : '❌ No') . "</p>";
echo "<p>MailPoet API: " . ($mailpoet_class_exists ? '✅ Disponible' : '❌ No disponible') . "</p>";

// Probar obtener listas
if ($mailpoet_class_exists) {
    try {
        $mailpoet_api = \MailPoet\API\API::MP('v1');
        $listas = $mailpoet_api->getLists();
        echo "<p>✅ Listas encontradas: " . count($listas) . "</p>";
        
        foreach ($listas as $lista) {
            echo "<p>- " . esc_html($lista['name']) . " (ID: " . $lista['id'] . ", Suscriptores: " . $lista['subscribers'] . ")</p>";
        }
    } catch (Exception $e) {
        echo "<p>❌ Error obteniendo listas: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>❌ No se puede probar MailPoet API</p>";
}

echo "<hr>";
echo "<p><a href='/importar-excel-simple.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>📊 Ir al Importador</a></p>";
echo "<p><a href='/gestionar-suscriptores-mailpoet.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>👥 Ver Suscriptores</a></p>";
echo "<p><a href='/' style='background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🏠 Inicio</a></p>";
?>
<?php
/**
 * Script para limpiar TODA la caché de WordPress
 */

// Cargar WordPress
require_once('wp-load.php');

echo "<h1>🧹 Limpiando Caché Completo</h1>";

// Limpiar caché de objetos
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
    echo "<p>✅ Caché de objetos limpiado</p>";
}

// Limpiar caché de transients
global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'");
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_site_transient_%'");
echo "<p>✅ Transients eliminados</p>";

// Limpiar caché de rewrite rules
flush_rewrite_rules(true);
echo "<p>✅ Rewrite rules actualizadas</p>";

// Limpiar opciones de caché comunes
delete_option('rewrite_rules');
echo "<p>✅ Opciones de caché eliminadas</p>";

echo "<h2>✨ Caché completamente limpiado</h2>";
echo "<p><strong>Ahora ve a:</strong> <a href='/anuncios/' target='_blank'>http://mongruasformacion.local/anuncios/</a></p>";
echo "<p><strong>Recuerda:</strong> Presiona Ctrl + F5 en tu navegador para forzar la recarga</p>";
?>

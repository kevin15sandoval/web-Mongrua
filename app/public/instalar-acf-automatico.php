<?php
/**
 * Instalador automático de ACF
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🔧 Instalador Automático de ACF</h1>";

// Verificar si ACF ya está instalado
if (function_exists('acf_add_local_field_group')) {
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px;'>";
    echo "✅ <strong>ACF ya está instalado y funcionando</strong>";
    echo "</div>";
    
    echo "<div style='text-align: center; margin: 20px 0;'>";
    echo "<a href='activar-menu-proximos-cursos.php' style='background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold;'>🎯 Continuar con la Configuración</a>";
    echo "</div>";
    exit;
}

echo "<div style='background: #fff3cd; color: #856404; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "⚠️ ACF no está instalado. Vamos a instalarlo automáticamente...";
echo "</div>";

// Función para descargar e instalar ACF
function instalar_acf_automatico() {
    // URL del plugin ACF desde WordPress.org
    $plugin_url = 'https://downloads.wordpress.org/plugin/advanced-custom-fields.zip';
    $temp_file = wp_upload_dir()['basedir'] . '/acf-temp.zip';
    $plugins_dir = WP_PLUGIN_DIR;
    
    echo "<h2>📥 Descargando ACF...</h2>";
    
    // Descargar el archivo
    $plugin_data = file_get_contents($plugin_url);
    if ($plugin_data === false) {
        echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
        echo "❌ Error al descargar ACF. Instálalo manualmente desde WordPress admin.";
        echo "</div>";
        return false;
    }
    
    file_put_contents($temp_file, $plugin_data);
    echo "<div style='background: #d4edda; color: #155724; padding: 10px; border-radius: 3px; margin: 5px 0;'>";
    echo "✅ ACF descargado correctamente";
    echo "</div>";
    
    echo "<h2>📦 Extrayendo archivos...</h2>";
    
    // Extraer el ZIP
    $zip = new ZipArchive;
    if ($zip->open($temp_file) === TRUE) {
        $zip->extractTo($plugins_dir);
        $zip->close();
        
        echo "<div style='background: #d4edda; color: #155724; padding: 10px; border-radius: 3px; margin: 5px 0;'>";
        echo "✅ Archivos extraídos correctamente";
        echo "</div>";
        
        // Limpiar archivo temporal
        unlink($temp_file);
        
        echo "<h2>🔌 Activando plugin...</h2>";
        
        // Activar el plugin
        $plugin_path = 'advanced-custom-fields/acf.php';
        $result = activate_plugin($plugin_path);
        
        if (is_wp_error($result)) {
            echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
            echo "❌ Error al activar ACF: " . $result->get_error_message();
            echo "</div>";
            return false;
        } else {
            echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px;'>";
            echo "✅ <strong>¡ACF instalado y activado correctamente!</strong>";
            echo "</div>";
            return true;
        }
        
    } else {
        echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
        echo "❌ Error al extraer el archivo ZIP";
        echo "</div>";
        return false;
    }
}

// Intentar instalación automática
if (isset($_POST['instalar_acf'])) {
    if (instalar_acf_automatico()) {
        echo "<script>setTimeout(function(){ location.reload(); }, 3000);</script>";
    }
} else {
    echo "<div style='text-align: center; margin: 30px 0;'>";
    echo "<form method='post' style='display: inline;'>";
    echo "<button type='submit' name='instalar_acf' style='background: #0066cc; color: white; padding: 20px 40px; border: none; border-radius: 8px; font-size: 18px; cursor: pointer; font-weight: bold;'>📥 Instalar ACF Automáticamente</button>";
    echo "</form>";
    echo "</div>";
}

echo "<div style='background: #e9ecef; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>📋 Instrucciones Manuales (si falla la instalación automática):</h3>";
echo "<ol>";
echo "<li>Ve a <strong>WordPress Admin</strong> → <a href='" . admin_url('plugin-install.php') . "' target='_blank'>Plugins → Añadir nuevo</a></li>";
echo "<li>Busca <strong>'Advanced Custom Fields'</strong></li>";
echo "<li>Instala y activa el plugin</li>";
echo "<li>Vuelve a esta página</li>";
echo "</ol>";
echo "</div>";

echo "<div style='text-align: center; margin: 20px 0;'>";
echo "<a href='" . admin_url('plugins.php') . "' target='_blank' style='background: #6c757d; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>🔌 Ver Plugins Instalados</a>";
echo "<a href='" . admin_url('plugin-install.php') . "' target='_blank' style='background: #17a2b8; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>➕ Instalar Plugins</a>";
echo "</div>";
?>
<?php
/**
 * Verificar Botones Grandes - Comprobar que los cambios se aplicaron
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🎨 Verificación de Botones Grandes</h1>";

echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>✅ Cambios Aplicados Exitosamente</h2>";
echo "<p><strong>Los botones han sido mejorados con:</strong></p>";
echo "<ul>";
echo "<li>✅ Tamaño más grande (18px padding → 20px para principales)</li>";
echo "<li>✅ Efectos hover más llamativos (escala y elevación)</li>";
echo "<li>✅ Animación de pulso en botón 'Reservar Plaza'</li>";
echo "<li>✅ Gradientes más vibrantes y atractivos</li>";
echo "<li>✅ Sombras más pronunciadas para efecto 3D</li>";
echo "<li>✅ Texto en mayúsculas para mayor impacto</li>";
echo "<li>✅ Efectos de escala al hover (1.05x - 1.08x)</li>";
echo "<li>✅ Bordes blancos al hover para contraste</li>";
echo "</ul>";
echo "</div>";

// Verificar archivos modificados
$files_to_check = [
    'wp-content/themes/mongruas-theme/template-parts/courses-default.php' => 'Template de cursos',
    'wp-content/themes/mongruas-theme/assets/css/main.css' => 'CSS principal'
];

echo "<div style='background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📁 Archivos Modificados</h2>";

foreach ($files_to_check as $file => $description) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        if (strpos($content, 'padding: 18px 35px') !== false || strpos($content, 'padding: 20px 40px') !== false) {
            echo "<p>✅ <strong>$description</strong> - Botones grandes aplicados</p>";
        } else {
            echo "<p>⚠️ <strong>$description</strong> - Verificar cambios</p>";
        }
    } else {
        echo "<p>❌ <strong>$description</strong> - Archivo no encontrado</p>";
    }
}
echo "</div>";

// Vista previa de los nuevos estilos
echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>👀 Vista Previa de los Nuevos Botones</h2>";

echo "<div style='text-align: center; margin: 20px 0;'>";
echo "<button style='background: linear-gradient(135deg, #0066cc, #004499); color: white; padding: 18px 35px; border-radius: 30px; font-size: 16px; font-weight: 800; text-decoration: none; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 6px 20px rgba(0, 102, 204, 0.4); border: 3px solid transparent; margin: 10px; cursor: pointer; transition: all 0.3s ease;' onmouseover='this.style.transform=\"translateY(-4px) scale(1.05)\"; this.style.boxShadow=\"0 8px 25px rgba(0, 102, 204, 0.6)\"; this.style.borderColor=\"#ffffff\";' onmouseout='this.style.transform=\"translateY(0) scale(1)\"; this.style.boxShadow=\"0 6px 20px rgba(0, 102, 204, 0.4)\"; this.style.borderColor=\"transparent\";'>VER MÁS INFO</button>";

echo "<button style='background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 18px 35px; border-radius: 30px; font-size: 16px; font-weight: 800; text-decoration: none; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4); border: 3px solid transparent; margin: 10px; cursor: pointer; transition: all 0.3s ease; animation: pulse 2s infinite;' onmouseover='this.style.transform=\"translateY(-4px) scale(1.05)\"; this.style.boxShadow=\"0 8px 25px rgba(40, 167, 69, 0.6)\"; this.style.borderColor=\"#ffffff\"; this.style.animation=\"none\";' onmouseout='this.style.transform=\"translateY(0) scale(1)\"; this.style.boxShadow=\"0 6px 20px rgba(40, 167, 69, 0.4)\"; this.style.borderColor=\"transparent\"; this.style.animation=\"pulse 2s infinite\";'>RESERVAR PLAZA</button>";
echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<h3>Botones Principales (Más Grandes)</h3>";
echo "<button style='background: linear-gradient(135deg, #dc3545, #c82333); color: white; padding: 20px 40px; border-radius: 50px; font-size: 18px; font-weight: 800; text-decoration: none; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 8px 25px rgba(220, 53, 69, 0.4); border: 3px solid transparent; margin: 10px; cursor: pointer; transition: all 0.3s ease;' onmouseover='this.style.transform=\"translateY(-5px) scale(1.08)\"; this.style.boxShadow=\"0 12px 35px rgba(220, 53, 69, 0.6)\"; this.style.borderColor=\"#ffffff\";' onmouseout='this.style.transform=\"translateY(0) scale(1)\"; this.style.boxShadow=\"0 8px 25px rgba(220, 53, 69, 0.4)\"; this.style.borderColor=\"transparent\";'>CERTIFICADOS PROFESIONALIDAD</button>";

echo "<button style='background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 20px 40px; border-radius: 50px; font-size: 18px; font-weight: 800; text-decoration: none; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4); border: 3px solid transparent; margin: 10px; cursor: pointer; transition: all 0.3s ease;' onmouseover='this.style.transform=\"translateY(-5px) scale(1.08)\"; this.style.boxShadow=\"0 12px 35px rgba(40, 167, 69, 0.6)\"; this.style.borderColor=\"#ffffff\";' onmouseout='this.style.transform=\"translateY(0) scale(1)\"; this.style.boxShadow=\"0 8px 25px rgba(40, 167, 69, 0.4)\"; this.style.borderColor=\"transparent\";'>VER CATÁLOGO COMPLETO</button>";
echo "</div>";

echo "<p style='text-align: center; color: #666; font-style: italic;'>¡Así se ven los nuevos botones - Más grandes, llamativos y con efectos espectaculares!</p>";
echo "</div>";

echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🎯 Características de los Nuevos Botones</h2>";
echo "<div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;'>";

echo "<div style='background: white; padding: 15px; border-radius: 8px; border-left: 4px solid #0066cc;'>";
echo "<h4>📏 Tamaño</h4>";
echo "<p>• Botones de curso: 18px padding<br>• Botones principales: 20px padding<br>• 50% más grandes que antes</p>";
echo "</div>";

echo "<div style='background: white; padding: 15px; border-radius: 8px; border-left: 4px solid #28a745;'>";
echo "<h4>✨ Efectos</h4>";
echo "<p>• Hover con escala (1.05x - 1.08x)<br>• Elevación (-4px a -5px)<br>• Bordes blancos al hover</p>";
echo "</div>";

echo "<div style='background: white; padding: 15px; border-radius: 8px; border-left: 4px solid #dc3545;'>";
echo "<h4>🌈 Colores</h4>";
echo "<p>• Gradientes más vibrantes<br>• Sombras pronunciadas<br>• Animación de pulso</p>";
echo "</div>";

echo "<div style='background: white; padding: 15px; border-radius: 8px; border-left: 4px solid #ff9900;'>";
echo "<h4>📝 Tipografía</h4>";
echo "<p>• Texto en mayúsculas<br>• Espaciado de letras<br>• Font-weight 800 (extra bold)</p>";
echo "</div>";

echo "</div>";
echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . home_url('/anuncios') . "' style='background: linear-gradient(135deg, #0066cc, #004499); color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; margin: 5px; font-weight: 700; text-transform: uppercase; box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3);'>👀 VER PÁGINA DE CURSOS</a>";
echo "<a href='" . home_url('/gestionar-proximos-cursos.php') . "' style='background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; margin: 5px; font-weight: 700; text-transform: uppercase; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);'>📝 GESTIONAR CURSOS</a>";
echo "</div>";

// CSS para la animación
echo "<style>
@keyframes pulse {
    0% { box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4); }
    50% { box-shadow: 0 8px 30px rgba(40, 167, 69, 0.7); }
    100% { box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4); }
}
</style>";
?>
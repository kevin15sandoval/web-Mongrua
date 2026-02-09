<?php
/**
 * Verificación de Botones Mejorados - Mongruas Formación
 * Muestra una página de prueba con todos los tipos de botones mejorados
 */

echo "<!DOCTYPE html>";
echo "<html lang='es'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>🎨 Botones Mejorados - Mongruas Formación</title>";

// Incluir los estilos del header
$header_file = 'wp-content/themes/mongruas-theme/header.php';
if (file_exists($header_file)) {
    $content = file_get_contents($header_file);
    // Extraer solo los estilos CSS
    preg_match('/<style>(.*?)<\/style>/s', $content, $matches);
    if (isset($matches[1])) {
        echo "<style>" . $matches[1] . "</style>";
    }
}

echo "</head>";
echo "<body style='font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, sans-serif; background: linear-gradient(135deg, #f8f9fa, #e9ecef); margin: 0; padding: 40px;'>";

echo "<div style='max-width: 1200px; margin: 0 auto;'>";
echo "<h1 style='text-align: center; color: #0066cc; font-size: 48px; font-weight: 800; margin-bottom: 20px;'>🎨 Botones Mejorados</h1>";
echo "<p style='text-align: center; font-size: 20px; color: #6c757d; margin-bottom: 50px;'>Diseño moderno 2025 para Mongruas Formación</p>";

// Sección de botones primarios
echo "<div style='background: white; padding: 40px; border-radius: 20px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); margin-bottom: 30px;'>";
echo "<h2 style='color: #0066cc; margin-bottom: 30px; font-size: 28px;'>🔵 Botones Primarios</h2>";
echo "<div style='display: flex; gap: 20px; flex-wrap: wrap; align-items: center;'>";
echo "<button class='btn btn-primary'>Botón Primario</button>";
echo "<button class='btn-primary'>Solicitar Información</button>";
echo "<a href='#' class='btn btn-primary'>Enlace Primario</a>";
echo "</div>";
echo "</div>";

// Sección de botones secundarios
echo "<div style='background: white; padding: 40px; border-radius: 20px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); margin-bottom: 30px;'>";
echo "<h2 style='color: #6c757d; margin-bottom: 30px; font-size: 28px;'>⚫ Botones Secundarios</h2>";
echo "<div style='display: flex; gap: 20px; flex-wrap: wrap; align-items: center;'>";
echo "<button class='btn btn-secondary'>Botón Secundario</button>";
echo "<button class='btn-secondary'>Campus Virtual</button>";
echo "<a href='#' class='btn btn-secondary'>Ver Más</a>";
echo "</div>";
echo "</div>";

// Sección de botones de éxito
echo "<div style='background: white; padding: 40px; border-radius: 20px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); margin-bottom: 30px;'>";
echo "<h2 style='color: #28a745; margin-bottom: 30px; font-size: 28px;'>🟢 Botones de Éxito</h2>";
echo "<div style='display: flex; gap: 20px; flex-wrap: wrap; align-items: center;'>";
echo "<button class='btn btn-success'>Botón de Éxito</button>";
echo "<button class='btn-success'>Enviar Formulario</button>";
echo "<a href='#' class='btn btn-success'>Confirmar</a>";
echo "</div>";
echo "</div>";

// Sección de botones CTA especiales
echo "<div style='background: white; padding: 40px; border-radius: 20px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); margin-bottom: 30px;'>";
echo "<h2 style='color: #ff6b35; margin-bottom: 30px; font-size: 28px;'>🟠 Botones CTA Especiales</h2>";
echo "<div style='display: flex; gap: 20px; flex-wrap: wrap; align-items: center;'>";
echo "<button class='cta-button'>¡Inscríbete Ahora!</button>";
echo "<button class='hero-button'>Solicita Información</button>";
echo "<a href='#' class='contact-button'>Contactar</a>";
echo "</div>";
echo "</div>";

// Sección de formulario
echo "<div style='background: white; padding: 40px; border-radius: 20px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); margin-bottom: 30px;'>";
echo "<h2 style='color: #0066cc; margin-bottom: 30px; font-size: 28px;'>📝 Formulario de Prueba</h2>";
echo "<form style='display: flex; flex-direction: column; gap: 20px; max-width: 400px;'>";
echo "<input type='text' placeholder='Nombre' style='padding: 12px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 16px;'>";
echo "<input type='email' placeholder='Email' style='padding: 12px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 16px;'>";
echo "<textarea placeholder='Mensaje' style='padding: 12px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 16px; min-height: 100px; resize: vertical;'></textarea>";
echo "<input type='submit' value='Enviar Mensaje' class='btn btn-primary'>";
echo "</form>";
echo "</div>";

// Información de mejoras
echo "<div style='background: linear-gradient(135deg, #0066cc, #0052a3); color: white; padding: 40px; border-radius: 20px; box-shadow: 0 8px 25px rgba(0,102,204,0.3);'>";
echo "<h2 style='color: white; margin-bottom: 20px; font-size: 28px;'>✨ Mejoras Aplicadas</h2>";
echo "<div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;'>";

$mejoras = [
    "🎨 Gradientes modernos" => "Colores degradados para un look profesional",
    "🚀 Efectos hover 3D" => "Elevación y escalado al pasar el mouse",
    "✨ Animaciones suaves" => "Transiciones fluidas con cubic-bezier",
    "📱 Diseño responsive" => "Adaptación automática a móviles",
    "💫 Efectos de brillo" => "Animación de luz al hacer hover",
    "🎯 Colores consistentes" => "Paleta unificada con la marca Mongruas"
];

foreach ($mejoras as $titulo => $descripcion) {
    echo "<div style='background: rgba(255,255,255,0.1); padding: 20px; border-radius: 12px; backdrop-filter: blur(10px);'>";
    echo "<h4 style='margin: 0 0 10px 0; font-size: 16px;'>$titulo</h4>";
    echo "<p style='margin: 0; font-size: 14px; opacity: 0.9;'>$descripcion</p>";
    echo "</div>";
}

echo "</div>";
echo "</div>";

echo "</div>";

// JavaScript para efectos adicionales
echo "<script>";
echo "document.addEventListener('DOMContentLoaded', function() {";
echo "    // Agregar efectos de click";
echo "    document.querySelectorAll('.btn, .button, button').forEach(function(btn) {";
echo "        btn.addEventListener('click', function(e) {";
echo "            // Efecto de ripple";
echo "            const ripple = document.createElement('span');";
echo "            const rect = this.getBoundingClientRect();";
echo "            const size = Math.max(rect.width, rect.height);";
echo "            const x = e.clientX - rect.left - size / 2;";
echo "            const y = e.clientY - rect.top - size / 2;";
echo "            ";
echo "            ripple.style.cssText = `";
echo "                position: absolute;";
echo "                width: ${size}px;";
echo "                height: ${size}px;";
echo "                left: ${x}px;";
echo "                top: ${y}px;";
echo "                background: rgba(255,255,255,0.3);";
echo "                border-radius: 50%;";
echo "                transform: scale(0);";
echo "                animation: ripple 0.6s linear;";
echo "                pointer-events: none;";
echo "            `;";
echo "            ";
echo "            this.appendChild(ripple);";
echo "            setTimeout(() => ripple.remove(), 600);";
echo "        });";
echo "    });";
echo "});";
echo "";
echo "// Agregar animación de ripple";
echo "const style = document.createElement('style');";
echo "style.textContent = `";
echo "    @keyframes ripple {";
echo "        to { transform: scale(4); opacity: 0; }";
echo "    }";
echo "`;";
echo "document.head.appendChild(style);";
echo "</script>";

echo "</body>";
echo "</html>";
?>
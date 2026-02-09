<?php
/**
 * Arreglar Botones - Hacerlos más elegantes y proporcionados
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>✨ Arreglar Botones - Más Elegantes</h1>";

if (isset($_POST['aplicar_botones_elegantes'])) {
    echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h2>🎨 Aplicando botones elegantes...</h2>";
    
    // Leer el archivo courses-default.php
    $template_path = 'wp-content/themes/mongruas-theme/template-parts/courses-default.php';
    
    if (file_exists($template_path)) {
        $content = file_get_contents($template_path);
        
        // Nuevos estilos más elegantes
        $elegant_button_styles = '
/* Botones elegantes y proporcionados */
.btn-ver-mas {
    display: inline-block;
    background: linear-gradient(135deg, #0066cc, #004499);
    color: white;
    padding: 14px 28px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
    flex: 1;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3);
    border: 2px solid transparent;
}

.btn-ver-mas:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0, 102, 204, 0.4);
    color: white;
    text-decoration: none;
    border-color: rgba(255, 255, 255, 0.3);
    background: linear-gradient(135deg, #0052a3, #003d7a);
}

.btn-reservar {
    display: inline-block;
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    padding: 14px 28px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
    flex: 1;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    border: 2px solid transparent;
}

.btn-reservar:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    color: white;
    text-decoration: none;
    border-color: rgba(255, 255, 255, 0.3);
    background: linear-gradient(135deg, #218838, #1e7e34);
}

.course-buttons {
    display: flex;
    gap: 12px;
    margin-top: 20px;
    justify-content: center;
}

/* Botones principales más elegantes */
.btn-presencial {
    display: inline-block;
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
    padding: 16px 32px;
    border-radius: 30px;
    font-size: 16px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: 2px solid transparent;
}

.btn-presencial:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
    border-color: rgba(255, 255, 255, 0.3);
    color: white;
    text-decoration: none;
}

.btn-jccm {
    display: inline-block;
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    padding: 16px 32px;
    border-radius: 30px;
    font-size: 16px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    margin-left: 15px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: 2px solid transparent;
}

.btn-jccm:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    color: white;
    text-decoration: none;
    border-color: rgba(255, 255, 255, 0.3);
}

/* Efectos sutiles para las tarjetas */
.upcoming-course-card:hover .btn-ver-mas,
.upcoming-course-card:hover .btn-reservar {
    transform: translateY(-1px);
}

.upcoming-course-card {
    position: relative;
    overflow: hidden;
}

/* Quitar el efecto arcoíris */
.upcoming-course-card::after {
    display: none;
}';

        // Buscar y reemplazar los estilos existentes
        $patterns = [
            '/\/\* Botones GRANDES y llamativos \*\/.*?(?=\/\*|$)/s',
            '/\.btn-ver-mas\s*{[^}]*}/s',
            '/\.btn-reservar\s*{[^}]*}/s',
            '/\.btn-presencial\s*{[^}]*}/s',
            '/\.btn-jccm\s*{[^}]*}/s',
            '/\.course-buttons\s*{[^}]*}/s',
            '/\/\* Efectos adicionales.*?opacity: 0\.7;\s*}/s'
        ];
        
        foreach ($patterns as $pattern) {
            $content = preg_replace($pattern, '', $content);
        }
        
        // Agregar los nuevos estilos antes del cierre de </style>
        $content = str_replace('</style>', $elegant_button_styles . '</style>', $content);
        
        if (file_put_contents($template_path, $content)) {
            echo "<p>✅ Estilos de botones elegantes aplicados</p>";
        } else {
            echo "<p>❌ Error al actualizar estilos</p>";
        }
    } else {
        echo "<p>❌ No se encontró el archivo template</p>";
    }
    
    echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>✨ ¡Botones arreglados!</h3>";
    echo "<p><strong>Cambios aplicados:</strong></p>";
    echo "<ul>";
    echo "<li>✅ Tamaño más proporcionado (14px padding)</li>";
    echo "<li>✅ Efectos hover sutiles</li>";
    echo "<li>✅ Sin animación de pulso</li>";
    echo "<li>✅ Bordes más suaves</li>";
    echo "<li>✅ Eliminado efecto arcoíris</li>";
    echo "<li>✅ Espaciado mejorado</li>";
    echo "</ul>";
    echo "</div>";
    
    echo "</div>";
}

echo "<div style='background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🎨 Mejoras que se aplicarán</h2>";
echo "<ul>";
echo "<li>📏 <strong>Tamaño proporcionado</strong> - Padding 14px (más equilibrado)</li>";
echo "<li>✨ <strong>Efectos hover sutiles</strong> - Solo elevación suave</li>";
echo "<li>🚫 <strong>Sin animación de pulso</strong> - Más profesional</li>";
echo "<li>🎯 <strong>Bordes suaves</strong> - Transparencia sutil</li>";
echo "<li>🚫 <strong>Sin efecto arcoíris</strong> - Más elegante</li>";
echo "<li>📐 <strong>Espaciado mejorado</strong> - Mejor proporción</li>";
echo "</ul>";
echo "</div>";

echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center;'>";
echo "<h2>✨ Aplicar Botones Elegantes</h2>";
echo "<p>Esto hará que los botones se vean más proporcionados y elegantes</p>";

echo "<form method='post'>";
echo "<button type='submit' name='aplicar_botones_elegantes' style='background: linear-gradient(135deg, #0066cc, #004499); color: white; padding: 16px 32px; border: none; border-radius: 25px; font-size: 16px; font-weight: 700; cursor: pointer; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3); transition: all 0.3s ease;' onmouseover='this.style.transform=\"translateY(-3px)\"; this.style.boxShadow=\"0 6px 20px rgba(0, 102, 204, 0.4)\";' onmouseout='this.style.transform=\"translateY(0)\"; this.style.boxShadow=\"0 4px 15px rgba(0, 102, 204, 0.3)\";'>✨ APLICAR BOTONES ELEGANTES</button>";
echo "</form>";
echo "</div>";

// Vista previa de cómo se verán
echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>👀 Vista Previa de los Botones Elegantes</h2>";

echo "<div style='text-align: center; margin: 20px 0;'>";
echo "<button style='background: linear-gradient(135deg, #0066cc, #004499); color: white; padding: 14px 28px; border-radius: 25px; font-size: 14px; font-weight: 700; text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3); border: 2px solid transparent; margin: 10px; cursor: pointer; transition: all 0.3s ease;' onmouseover='this.style.transform=\"translateY(-3px)\"; this.style.boxShadow=\"0 6px 20px rgba(0, 102, 204, 0.4)\"; this.style.borderColor=\"rgba(255, 255, 255, 0.3)\";' onmouseout='this.style.transform=\"translateY(0)\"; this.style.boxShadow=\"0 4px 15px rgba(0, 102, 204, 0.3)\"; this.style.borderColor=\"transparent\";'>VER MÁS INFO</button>";

echo "<button style='background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 14px 28px; border-radius: 25px; font-size: 14px; font-weight: 700; text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3); border: 2px solid transparent; margin: 10px; cursor: pointer; transition: all 0.3s ease;' onmouseover='this.style.transform=\"translateY(-3px)\"; this.style.boxShadow=\"0 6px 20px rgba(40, 167, 69, 0.4)\"; this.style.borderColor=\"rgba(255, 255, 255, 0.3)\";' onmouseout='this.style.transform=\"translateY(0)\"; this.style.boxShadow=\"0 4px 15px rgba(40, 167, 69, 0.3)\"; this.style.borderColor=\"transparent\";'>RESERVAR PLAZA</button>";
echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<h3>Botones Principales</h3>";
echo "<button style='background: linear-gradient(135deg, #dc3545, #c82333); color: white; padding: 16px 32px; border-radius: 30px; font-size: 16px; font-weight: 700; text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3); border: 2px solid transparent; margin: 10px; cursor: pointer; transition: all 0.3s ease;' onmouseover='this.style.transform=\"translateY(-3px)\"; this.style.boxShadow=\"0 6px 20px rgba(220, 53, 69, 0.4)\"; this.style.borderColor=\"rgba(255, 255, 255, 0.3)\";' onmouseout='this.style.transform=\"translateY(0)\"; this.style.boxShadow=\"0 4px 15px rgba(220, 53, 69, 0.3)\"; this.style.borderColor=\"transparent\";'>CERTIFICADOS</button>";

echo "<button style='background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 16px 32px; border-radius: 30px; font-size: 16px; font-weight: 700; text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3); border: 2px solid transparent; margin: 10px; cursor: pointer; transition: all 0.3s ease;' onmouseover='this.style.transform=\"translateY(-3px)\"; this.style.boxShadow=\"0 6px 20px rgba(40, 167, 69, 0.4)\"; this.style.borderColor=\"rgba(255, 255, 255, 0.3)\";' onmouseout='this.style.transform=\"translateY(0)\"; this.style.boxShadow=\"0 4px 15px rgba(40, 167, 69, 0.3)\"; this.style.borderColor=\"transparent\";'>VER CATÁLOGO</button>";
echo "</div>";

echo "<p style='text-align: center; color: #666; font-style: italic;'>Así se ven los botones elegantes - Proporcionados y profesionales</p>";
echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . home_url('/anuncios') . "' style='background: linear-gradient(135deg, #0066cc, #004499); color: white; padding: 12px 24px; text-decoration: none; border-radius: 20px; margin: 5px; font-weight: 600; box-shadow: 0 3px 10px rgba(0, 102, 204, 0.3);'>👀 Ver Página de Cursos</a>";
echo "<a href='" . home_url('/gestionar-proximos-cursos.php') . "' style='background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 12px 24px; text-decoration: none; border-radius: 20px; margin: 5px; font-weight: 600; box-shadow: 0 3px 10px rgba(40, 167, 69, 0.3);'>📝 Gestionar Cursos</a>";
echo "</div>";

echo "<div style='background: #d1ecf1; color: #0c5460; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>✨ Características de los Botones Elegantes</h3>";
echo "<p><strong>Tamaño:</strong> Proporcionado y equilibrado</p>";
echo "<p><strong>Efectos:</strong> Hover suave sin exageraciones</p>";
echo "<p><strong>Colores:</strong> Gradientes elegantes</p>";
echo "<p><strong>Animación:</strong> Sin pulso, más profesional</p>";
echo "<p><strong>Tipografía:</strong> Mayúsculas con espaciado sutil</p>";
echo "<p><strong>Bordes:</strong> Transparencia suave al hover</p>";
echo "</div>";
?>
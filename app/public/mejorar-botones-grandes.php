<?php
/**
 * Mejorar Botones - Hacerlos más grandes y llamativos
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🎨 Mejorar Botones - Más Grandes y Llamativos</h1>";

if (isset($_POST['aplicar_botones_grandes'])) {
    echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h2>✨ Aplicando mejoras a los botones...</h2>";
    
    // Leer el archivo courses-default.php
    $template_path = 'wp-content/themes/mongruas-theme/template-parts/courses-default.php';
    
    if (file_exists($template_path)) {
        $content = file_get_contents($template_path);
        
        // Buscar y reemplazar los estilos de botones existentes
        $new_button_styles = '
/* Botones GRANDES y llamativos */
.btn-ver-mas {
    display: inline-block;
    background: linear-gradient(135deg, #0066cc, #004499);
    color: white;
    padding: 18px 35px;
    border-radius: 30px;
    font-size: 16px;
    font-weight: 800;
    text-decoration: none;
    transition: all 0.3s ease;
    flex: 1;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 6px 20px rgba(0, 102, 204, 0.4);
    border: 3px solid transparent;
}

.btn-ver-mas:hover {
    transform: translateY(-4px) scale(1.05);
    box-shadow: 0 8px 25px rgba(0, 102, 204, 0.6);
    color: white;
    text-decoration: none;
    border-color: #ffffff;
    background: linear-gradient(135deg, #0052a3, #003d7a);
}

.btn-reservar {
    display: inline-block;
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    padding: 18px 35px;
    border-radius: 30px;
    font-size: 16px;
    font-weight: 800;
    text-decoration: none;
    transition: all 0.3s ease;
    flex: 1;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    border: 3px solid transparent;
    animation: pulse 2s infinite;
}

.btn-reservar:hover {
    transform: translateY(-4px) scale(1.05);
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.6);
    color: white;
    text-decoration: none;
    border-color: #ffffff;
    background: linear-gradient(135deg, #218838, #1e7e34);
    animation: none;
}

@keyframes pulse {
    0% { box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4); }
    50% { box-shadow: 0 8px 30px rgba(40, 167, 69, 0.7); }
    100% { box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4); }
}

.course-buttons {
    display: flex;
    gap: 15px;
    margin-top: 25px;
    justify-content: center;
}

/* Botones principales más grandes */
.btn-presencial {
    display: inline-block;
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
    padding: 20px 40px;
    border-radius: 50px;
    font-size: 18px;
    font-weight: 800;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(220, 53, 69, 0.4);
    text-transform: uppercase;
    letter-spacing: 1px;
    border: 3px solid transparent;
}

.btn-presencial:hover {
    transform: translateY(-5px) scale(1.08);
    box-shadow: 0 12px 35px rgba(220, 53, 69, 0.6);
    border-color: #ffffff;
    color: white;
    text-decoration: none;
}

.btn-jccm {
    display: inline-block;
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    padding: 20px 40px;
    border-radius: 50px;
    font-size: 18px;
    font-weight: 800;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
    margin-left: 15px;
    text-transform: uppercase;
    letter-spacing: 1px;
    border: 3px solid transparent;
}

.btn-jccm:hover {
    transform: translateY(-5px) scale(1.08);
    box-shadow: 0 12px 35px rgba(40, 167, 69, 0.6);
    color: white;
    text-decoration: none;
    border-color: #ffffff;
}

/* Efectos adicionales para hacer los botones más llamativos */
.upcoming-course-card:hover .btn-ver-mas,
.upcoming-course-card:hover .btn-reservar {
    transform: translateY(-2px) scale(1.02);
}

.upcoming-course-card {
    position: relative;
    overflow: visible;
}

.upcoming-course-card::after {
    content: "";
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #feca57);
    border-radius: 18px;
    z-index: -1;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.upcoming-course-card:hover::after {
    opacity: 0.7;
}';

        // Buscar la sección de estilos y reemplazar los botones
        if (strpos($content, '.btn-ver-mas') !== false) {
            // Reemplazar estilos existentes
            $content = preg_replace('/\.btn-ver-mas\s*{[^}]*}/s', '', $content);
            $content = preg_replace('/\.btn-reservar\s*{[^}]*}/s', '', $content);
            $content = preg_replace('/\.btn-presencial\s*{[^}]*}/s', '', $content);
            $content = preg_replace('/\.btn-jccm\s*{[^}]*}/s', '', $content);
        }
        
        // Agregar los nuevos estilos antes del cierre de </style>
        $content = str_replace('</style>', $new_button_styles . '</style>', $content);
        
        if (file_put_contents($template_path, $content)) {
            echo "<p>✅ Estilos de botones actualizados en courses-default.php</p>";
        } else {
            echo "<p>❌ Error al actualizar estilos</p>";
        }
    } else {
        echo "<p>❌ No se encontró el archivo template</p>";
    }
    
    // También actualizar estilos en main.css si existe
    $main_css_path = 'wp-content/themes/mongruas-theme/assets/css/main.css';
    if (file_exists($main_css_path)) {
        $css_content = file_get_contents($main_css_path);
        
        $additional_css = '
/* Botones EXTRA GRANDES para toda la web */
.btn, .button, input[type="submit"] {
    padding: 18px 35px !important;
    font-size: 16px !important;
    font-weight: 800 !important;
    border-radius: 30px !important;
    text-transform: uppercase !important;
    letter-spacing: 1px !important;
    transition: all 0.3s ease !important;
    box-shadow: 0 6px 20px rgba(0,0,0,0.2) !important;
}

.btn:hover, .button:hover, input[type="submit"]:hover {
    transform: translateY(-4px) scale(1.05) !important;
    box-shadow: 0 8px 25px rgba(0,0,0,0.3) !important;
}

/* Botones de contacto más grandes */
.contact-form input[type="submit"] {
    background: linear-gradient(135deg, #28a745, #20c997) !important;
    color: white !important;
    padding: 20px 40px !important;
    font-size: 18px !important;
    border: none !important;
}
';
        
        $css_content .= $additional_css;
        
        if (file_put_contents($main_css_path, $css_content)) {
            echo "<p>✅ Estilos globales actualizados en main.css</p>";
        }
    }
    
    echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>🎉 ¡Botones mejorados!</h3>";
    echo "<p><strong>Cambios aplicados:</strong></p>";
    echo "<ul>";
    echo "<li>✅ Botones más grandes (18px padding)</li>";
    echo "<li>✅ Efectos hover más llamativos</li>";
    echo "<li>✅ Animación de pulso en botón 'Reservar'</li>";
    echo "<li>✅ Gradientes más vibrantes</li>";
    echo "<li>✅ Sombras más pronunciadas</li>";
    echo "<li>✅ Texto en mayúsculas</li>";
    echo "<li>✅ Efectos de escala al hover</li>";
    echo "</ul>";
    echo "</div>";
    
    echo "</div>";
}

echo "<div style='background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🎨 Mejoras que se aplicarán</h2>";
echo "<ul>";
echo "<li>🔥 <strong>Botones más GRANDES</strong> - Padding aumentado</li>";
echo "<li>✨ <strong>Efectos hover espectaculares</strong> - Escala y elevación</li>";
echo "<li>🌈 <strong>Gradientes más vibrantes</strong> - Colores más llamativos</li>";
echo "<li>💫 <strong>Animación de pulso</strong> - En botón 'Reservar Plaza'</li>";
echo "<li>🎯 <strong>Sombras pronunciadas</strong> - Efecto 3D</li>";
echo "<li>📝 <strong>Texto en mayúsculas</strong> - Más impactante</li>";
echo "<li>⚡ <strong>Transiciones suaves</strong> - Animaciones fluidas</li>";
echo "</ul>";
echo "</div>";

echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center;'>";
echo "<h2>🚀 Aplicar Mejoras a los Botones</h2>";
echo "<p>Esto hará que todos los botones se vean más grandes y llamativos</p>";

echo "<form method='post'>";
echo "<button type='submit' name='aplicar_botones_grandes' style='background: linear-gradient(135deg, #ff6b6b, #ee5a52); color: white; padding: 25px 50px; border: none; border-radius: 50px; font-size: 20px; font-weight: 800; cursor: pointer; text-transform: uppercase; letter-spacing: 2px; box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4); transition: all 0.3s ease;' onmouseover='this.style.transform=\"translateY(-5px) scale(1.05)\"' onmouseout='this.style.transform=\"translateY(0) scale(1)\"'>🎨 HACER BOTONES GRANDES</button>";
echo "</form>";
echo "</div>";

// Vista previa de cómo se verán
echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>👀 Vista Previa de los Nuevos Botones</h2>";

echo "<div style='text-align: center; margin: 20px 0;'>";
echo "<button style='background: linear-gradient(135deg, #0066cc, #004499); color: white; padding: 18px 35px; border-radius: 30px; font-size: 16px; font-weight: 800; text-decoration: none; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 6px 20px rgba(0, 102, 204, 0.4); border: 3px solid transparent; margin: 10px; cursor: pointer;'>VER MÁS INFO</button>";
echo "<button style='background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 18px 35px; border-radius: 30px; font-size: 16px; font-weight: 800; text-decoration: none; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4); border: 3px solid transparent; margin: 10px; cursor: pointer; animation: pulse 2s infinite;'>RESERVAR PLAZA</button>";
echo "</div>";

echo "<p style='text-align: center; color: #666;'>Así se verán los nuevos botones - ¡Más grandes y llamativos!</p>";
echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . home_url('/anuncios') . "' style='background: #0066cc; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>👀 Ver Página de Cursos</a>";
echo "<a href='" . home_url('/gestionar-proximos-cursos.php') . "' style='background: #6c757d; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>📝 Gestionar Cursos</a>";
echo "</div>";

echo "<div style='background: #d1ecf1; color: #0c5460; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>🎯 Características de los nuevos botones</h3>";
echo "<p><strong>Tamaño:</strong> 50% más grandes que antes</p>";
echo "<p><strong>Efectos:</strong> Hover con escala y elevación</p>";
echo "<p><strong>Colores:</strong> Gradientes más vibrantes</p>";
echo "<p><strong>Animación:</strong> Pulso continuo en 'Reservar Plaza'</p>";
echo "<p><strong>Tipografía:</strong> Mayúsculas y espaciado de letras</p>";
echo "</div>";

// CSS para la animación del botón de vista previa
echo "<style>
@keyframes pulse {
    0% { box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4); }
    50% { box-shadow: 0 8px 30px rgba(40, 167, 69, 0.7); }
    100% { box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4); }
}
</style>";
?>
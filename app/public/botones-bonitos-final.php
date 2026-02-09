<?php
/**
 * Botones Bonitos Final - Versión más estilizada
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🎨 Botones Bonitos - Versión Final</h1>";

if (isset($_POST['aplicar_botones_bonitos'])) {
    echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h2>✨ Aplicando botones bonitos...</h2>";
    
    // Leer el archivo courses-default.php
    $template_path = 'wp-content/themes/mongruas-theme/template-parts/courses-default.php';
    
    if (file_exists($template_path)) {
        $content = file_get_contents($template_path);
        
        // Nuevos estilos más bonitos
        $beautiful_button_styles = '
/* Botones bonitos y modernos */
.btn-ver-mas {
    display: inline-block;
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    color: white;
    padding: 14px 24px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    flex: 1;
    box-shadow: 0 4px 14px 0 rgba(30, 64, 175, 0.3);
    border: none;
    position: relative;
    overflow: hidden;
}

.btn-ver-mas::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-ver-mas:hover::before {
    left: 100%;
}

.btn-ver-mas:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px 0 rgba(30, 64, 175, 0.4);
    color: white;
    text-decoration: none;
    background: linear-gradient(135deg, #1d4ed8, #2563eb);
}

.btn-reservar {
    display: inline-block;
    background: linear-gradient(135deg, #059669, #10b981);
    color: white;
    padding: 14px 24px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    flex: 1;
    box-shadow: 0 4px 14px 0 rgba(5, 150, 105, 0.3);
    border: none;
    position: relative;
    overflow: hidden;
}

.btn-reservar::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-reservar:hover::before {
    left: 100%;
}

.btn-reservar:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px 0 rgba(5, 150, 105, 0.4);
    color: white;
    text-decoration: none;
    background: linear-gradient(135deg, #047857, #059669);
}

.course-buttons {
    display: flex;
    gap: 12px;
    margin-top: 20px;
    justify-content: center;
}

/* Botones principales más bonitos */
.btn-presencial {
    display: inline-block;
    background: linear-gradient(135deg, #dc2626, #ef4444);
    color: white;
    padding: 16px 32px;
    border-radius: 16px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 14px 0 rgba(220, 38, 38, 0.3);
    border: none;
    position: relative;
    overflow: hidden;
}

.btn-presencial::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-presencial:hover::before {
    left: 100%;
}

.btn-presencial:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px 0 rgba(220, 38, 38, 0.4);
    color: white;
    text-decoration: none;
    background: linear-gradient(135deg, #b91c1c, #dc2626);
}

.btn-jccm {
    display: inline-block;
    background: linear-gradient(135deg, #059669, #10b981);
    color: white;
    padding: 16px 32px;
    border-radius: 16px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 14px 0 rgba(5, 150, 105, 0.3);
    margin-left: 15px;
    border: none;
    position: relative;
    overflow: hidden;
}

.btn-jccm::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-jccm:hover::before {
    left: 100%;
}

.btn-jccm:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px 0 rgba(5, 150, 105, 0.4);
    color: white;
    text-decoration: none;
    background: linear-gradient(135deg, #047857, #059669);
}';

        // Buscar y reemplazar los estilos existentes
        $patterns = [
            '/\/\* Botones elegantes y proporcionados \*\/.*?(?=\/\*|$)/s',
            '/\.btn-ver-mas\s*{[^}]*}/s',
            '/\.btn-reservar\s*{[^}]*}/s',
            '/\.btn-presencial\s*{[^}]*}/s',
            '/\.btn-jccm\s*{[^}]*}/s',
            '/\.course-buttons\s*{[^}]*}/s'
        ];
        
        foreach ($patterns as $pattern) {
            $content = preg_replace($pattern, '', $content);
        }
        
        // Agregar los nuevos estilos antes del cierre de </style>
        $content = str_replace('</style>', $beautiful_button_styles . '</style>', $content);
        
        if (file_put_contents($template_path, $content)) {
            echo "<p>✅ Botones bonitos aplicados correctamente</p>";
        } else {
            echo "<p>❌ Error al actualizar estilos</p>";
        }
    } else {
        echo "<p>❌ No se encontró el archivo template</p>";
    }
    
    echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>🎉 ¡Botones bonitos aplicados!</h3>";
    echo "<p><strong>Mejoras aplicadas:</strong></p>";
    echo "<ul>";
    echo "<li>✅ Colores más modernos y vibrantes</li>";
    echo "<li>✅ Efecto de brillo al hover</li>";
    echo "<li>✅ Sombras más suaves y elegantes</li>";
    echo "<li>✅ Transiciones más fluidas</li>";
    echo "<li>✅ Border-radius más moderno</li>";
    echo "<li>✅ Gradientes actualizados</li>";
    echo "</ul>";
    echo "</div>";
    
    echo "</div>";
}

echo "<div style='background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🎨 Características de los Botones Bonitos</h2>";
echo "<ul>";
echo "<li>🎨 <strong>Colores modernos</strong> - Azul y verde más vibrantes</li>";
echo "<li>✨ <strong>Efecto de brillo</strong> - Animación sutil al hover</li>";
echo "<li>🌟 <strong>Sombras elegantes</strong> - Más suaves y profesionales</li>";
echo "<li>🔄 <strong>Transiciones fluidas</strong> - Cubic-bezier para suavidad</li>";
echo "<li>📐 <strong>Border-radius moderno</strong> - 12px para botones pequeños</li>";
echo "<li>🎯 <strong>Gradientes actualizados</strong> - Colores más frescos</li>";
echo "</ul>";
echo "</div>";

echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center;'>";
echo "<h2>🎨 Aplicar Botones Bonitos</h2>";
echo "<p>Esto aplicará botones más modernos y atractivos</p>";

echo "<form method='post'>";
echo "<button type='submit' name='aplicar_botones_bonitos' style='background: linear-gradient(135deg, #1e40af, #3b82f6); color: white; padding: 16px 32px; border: none; border-radius: 12px; font-size: 16px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 14px 0 rgba(30, 64, 175, 0.3); transition: all 0.3s ease; position: relative; overflow: hidden;' onmouseover='this.style.transform=\"translateY(-2px)\"; this.style.boxShadow=\"0 8px 25px 0 rgba(30, 64, 175, 0.4)\";' onmouseout='this.style.transform=\"translateY(0)\"; this.style.boxShadow=\"0 4px 14px 0 rgba(30, 64, 175, 0.3)\";'>🎨 APLICAR BOTONES BONITOS</button>";
echo "</form>";
echo "</div>";

// Vista previa de cómo se verán
echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>👀 Vista Previa de los Botones Bonitos</h2>";

echo "<div style='text-align: center; margin: 20px 0;'>";
echo "<button style='background: linear-gradient(135deg, #1e40af, #3b82f6); color: white; padding: 14px 24px; border-radius: 12px; font-size: 14px; font-weight: 600; text-decoration: none; box-shadow: 0 4px 14px 0 rgba(30, 64, 175, 0.3); border: none; margin: 10px; cursor: pointer; transition: all 0.3s ease; position: relative; overflow: hidden;' onmouseover='this.style.transform=\"translateY(-2px)\"; this.style.boxShadow=\"0 8px 25px 0 rgba(30, 64, 175, 0.4)\";' onmouseout='this.style.transform=\"translateY(0)\"; this.style.boxShadow=\"0 4px 14px 0 rgba(30, 64, 175, 0.3)\";'>VER MÁS INFO</button>";

echo "<button style='background: linear-gradient(135deg, #059669, #10b981); color: white; padding: 14px 24px; border-radius: 12px; font-size: 14px; font-weight: 600; text-decoration: none; box-shadow: 0 4px 14px 0 rgba(5, 150, 105, 0.3); border: none; margin: 10px; cursor: pointer; transition: all 0.3s ease; position: relative; overflow: hidden;' onmouseover='this.style.transform=\"translateY(-2px)\"; this.style.boxShadow=\"0 8px 25px 0 rgba(5, 150, 105, 0.4)\";' onmouseout='this.style.transform=\"translateY(0)\"; this.style.boxShadow=\"0 4px 14px 0 rgba(5, 150, 105, 0.3)\";'>RESERVAR PLAZA</button>";
echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<h3>Botones Principales</h3>";
echo "<button style='background: linear-gradient(135deg, #dc2626, #ef4444); color: white; padding: 16px 32px; border-radius: 16px; font-size: 16px; font-weight: 600; text-decoration: none; box-shadow: 0 4px 14px 0 rgba(220, 38, 38, 0.3); border: none; margin: 10px; cursor: pointer; transition: all 0.3s ease; position: relative; overflow: hidden;' onmouseover='this.style.transform=\"translateY(-3px)\"; this.style.boxShadow=\"0 8px 25px 0 rgba(220, 38, 38, 0.4)\";' onmouseout='this.style.transform=\"translateY(0)\"; this.style.boxShadow=\"0 4px 14px 0 rgba(220, 38, 38, 0.3)\";'>CERTIFICADOS</button>";

echo "<button style='background: linear-gradient(135deg, #059669, #10b981); color: white; padding: 16px 32px; border-radius: 16px; font-size: 16px; font-weight: 600; text-decoration: none; box-shadow: 0 4px 14px 0 rgba(5, 150, 105, 0.3); border: none; margin: 10px; cursor: pointer; transition: all 0.3s ease; position: relative; overflow: hidden;' onmouseover='this.style.transform=\"translateY(-3px)\"; this.style.boxShadow=\"0 8px 25px 0 rgba(5, 150, 105, 0.4)\";' onmouseout='this.style.transform=\"translateY(0)\"; this.style.boxShadow=\"0 4px 14px 0 rgba(5, 150, 105, 0.3)\";'>VER CATÁLOGO</button>";
echo "</div>";

echo "<p style='text-align: center; color: #666; font-style: italic;'>Así se ven los botones bonitos - Modernos y elegantes con efecto de brillo</p>";
echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . home_url('/anuncios') . "' style='background: linear-gradient(135deg, #1e40af, #3b82f6); color: white; padding: 12px 24px; text-decoration: none; border-radius: 10px; margin: 5px; font-weight: 600; box-shadow: 0 3px 10px rgba(30, 64, 175, 0.3);'>👀 Ver Página de Cursos</a>";
echo "<a href='" . home_url('/gestionar-proximos-cursos.php') . "' style='background: linear-gradient(135deg, #059669, #10b981); color: white; padding: 12px 24px; text-decoration: none; border-radius: 10px; margin: 5px; font-weight: 600; box-shadow: 0 3px 10px rgba(5, 150, 105, 0.3);'>📝 Gestionar Cursos</a>";
echo "</div>";

echo "<div style='background: #d1ecf1; color: #0c5460; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>🎨 Características de los Botones Bonitos</h3>";
echo "<p><strong>Colores:</strong> Azul y verde más modernos y vibrantes</p>";
echo "<p><strong>Efectos:</strong> Brillo sutil al pasar el mouse</p>";
echo "<p><strong>Sombras:</strong> Más suaves y profesionales</p>";
echo "<p><strong>Animaciones:</strong> Transiciones fluidas con cubic-bezier</p>";
echo "<p><strong>Forma:</strong> Border-radius moderno (12px-16px)</p>";
echo "<p><strong>Gradientes:</strong> Colores más frescos y actuales</p>";
echo "</div>";
?>
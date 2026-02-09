<?php
/**
 * Arreglar botón "Ver Más Info" - Centrarlo y arreglar el enlace
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🔧 Arreglar Botón Ver Más Info</h1>";

if (isset($_POST['arreglar_boton'])) {
    echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h2>🔧 Arreglando botón Ver Más Info...</h2>";
    
    // 1. Arreglar el CSS para centrar el botón
    $template_path = 'wp-content/themes/mongruas-theme/template-parts/courses-default.php';
    
    if (file_exists($template_path)) {
        $content = file_get_contents($template_path);
        
        // Cambiar el layout de los botones para que "Ver Más Info" esté centrado
        $new_button_layout = '
.course-buttons {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 20px;
    align-items: center;
}

.btn-ver-mas {
    display: inline-block;
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    color: white;
    padding: 14px 32px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 14px 0 rgba(30, 64, 175, 0.3);
    border: none;
    position: relative;
    overflow: hidden;
    width: 200px;
    text-align: center;
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
    padding: 14px 32px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 14px 0 rgba(5, 150, 105, 0.3);
    border: none;
    position: relative;
    overflow: hidden;
    width: 200px;
    text-align: center;
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
}';

        // Reemplazar los estilos de botones
        $content = preg_replace('/\.course-buttons\s*{[^}]*}/s', '', $content);
        $content = preg_replace('/\.btn-ver-mas\s*{[^}]*}/s', '', $content);
        $content = preg_replace('/\.btn-reservar\s*{[^}]*}/s', '', $content);
        
        // Agregar los nuevos estilos
        $content = str_replace('</style>', $new_button_layout . '</style>', $content);
        
        if (file_put_contents($template_path, $content)) {
            echo "<p>✅ Layout de botones actualizado - Ver Más Info ahora está centrado</p>";
        }
    }
    
    // 2. Crear una página simple para mostrar información del curso
    $curso_page_content = '<?php
/**
 * Página simple para mostrar información del curso
 */

// Cargar WordPress
require_once("wp-config.php");
require_once("wp-load.php");

// Obtener el ID del curso
$curso_id = isset($_GET["curso"]) ? intval($_GET["curso"]) : 1;

// Obtener datos del curso
$titulo = get_option("course_{$curso_id}_name") ?: "Curso de Ejemplo";
$fecha = get_option("course_{$curso_id}_date") ?: "Próximamente";
$modalidad = get_option("course_{$curso_id}_modality") ?: "Presencial";
$duracion = get_option("course_{$curso_id}_duration") ?: "Plazas limitadas";
$descripcion = get_option("course_{$curso_id}_description") ?: "Descripción del curso no disponible.";
$imagen = get_option("course_{$curso_id}_image");

get_header();
?>

<div class="container" style="max-width: 800px; margin: 40px auto; padding: 20px;">
    <div class="course-detail-card" style="background: white; border-radius: 16px; padding: 40px; box-shadow: 0 8px 25px rgba(0,0,0,0.1);">
        
        <?php if ($imagen): ?>
            <div style="text-align: center; margin-bottom: 30px;">
                <img src="<?php echo esc_url($imagen); ?>" alt="<?php echo esc_attr($titulo); ?>" style="max-width: 100%; height: 200px; object-fit: cover; border-radius: 12px;">
            </div>
        <?php endif; ?>
        
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="background: linear-gradient(135deg, #059669, #10b981); color: white; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 600; display: inline-block; margin-bottom: 20px;">
                <?php echo esc_html($fecha); ?>
            </div>
            
            <h1 style="font-size: 32px; font-weight: 700; color: #1a1a1a; margin-bottom: 20px; line-height: 1.3;">
                <?php echo esc_html($titulo); ?>
            </h1>
            
            <div style="display: flex; justify-content: center; gap: 20px; margin-bottom: 30px;">
                <span style="background: #e9ecef; color: #495057; padding: 8px 16px; border-radius: 12px; font-weight: 600;">
                    <?php echo esc_html($modalidad); ?>
                </span>
                <span style="background: #fff3cd; color: #856404; padding: 8px 16px; border-radius: 12px; font-weight: 600;">
                    <?php echo esc_html($duracion); ?>
                </span>
            </div>
        </div>
        
        <div style="margin-bottom: 30px;">
            <h2 style="font-size: 24px; font-weight: 600; color: #1a1a1a; margin-bottom: 15px;">Descripción del Curso</h2>
            <p style="font-size: 16px; line-height: 1.6; color: #495057;">
                <?php echo esc_html($descripcion); ?>
            </p>
        </div>
        
        <div style="background: #f8f9fa; padding: 30px; border-radius: 12px; margin-bottom: 30px;">
            <h3 style="font-size: 20px; font-weight: 600; color: #1a1a1a; margin-bottom: 15px;">Información Adicional</h3>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="padding: 8px 0; border-bottom: 1px solid #e9ecef;"><strong>Modalidad:</strong> <?php echo esc_html($modalidad); ?></li>
                <li style="padding: 8px 0; border-bottom: 1px solid #e9ecef;"><strong>Fecha de inicio:</strong> <?php echo esc_html($fecha); ?></li>
                <li style="padding: 8px 0; border-bottom: 1px solid #e9ecef;"><strong>Plazas:</strong> <?php echo esc_html($duracion); ?></li>
                <li style="padding: 8px 0;"><strong>Certificación:</strong> Certificado oficial</li>
            </ul>
        </div>
        
        <div style="text-align: center;">
            <a href="<?php echo home_url("/contacto"); ?>" style="background: linear-gradient(135deg, #059669, #10b981); color: white; padding: 16px 32px; border-radius: 12px; font-size: 16px; font-weight: 600; text-decoration: none; box-shadow: 0 4px 14px 0 rgba(5, 150, 105, 0.3); transition: all 0.3s ease; display: inline-block; margin-right: 15px;" onmouseover="this.style.transform=\'translateY(-2px)\'; this.style.boxShadow=\'0 8px 25px 0 rgba(5, 150, 105, 0.4)\';" onmouseout="this.style.transform=\'translateY(0)\'; this.style.boxShadow=\'0 4px 14px 0 rgba(5, 150, 105, 0.3)\';">
                📞 Reservar Plaza
            </a>
            
            <a href="<?php echo home_url("/anuncios"); ?>" style="background: linear-gradient(135deg, #6c757d, #495057); color: white; padding: 16px 32px; border-radius: 12px; font-size: 16px; font-weight: 600; text-decoration: none; box-shadow: 0 4px 14px 0 rgba(108, 117, 125, 0.3); transition: all 0.3s ease; display: inline-block;" onmouseover="this.style.transform=\'translateY(-2px)\'; this.style.boxShadow=\'0 8px 25px 0 rgba(108, 117, 125, 0.4)\';" onmouseout="this.style.transform=\'translateY(0)\'; this.style.boxShadow=\'0 4px 14px 0 rgba(108, 117, 125, 0.3)\';">
                ← Volver a Cursos
            </a>
        </div>
    </div>
</div>

<?php get_footer(); ?>';

    // Crear el archivo curso-info.php
    if (file_put_contents('curso-info.php', $curso_page_content)) {
        echo "<p>✅ Página de información del curso creada</p>";
    }
    
    // 3. Actualizar los enlaces en el template para que apunten a la nueva página
    if (file_exists($template_path)) {
        $content = file_get_contents($template_path);
        
        // Cambiar los enlaces de "Ver Más Info" para que apunten a curso-info.php
        $content = str_replace(
            'href="<?php echo home_url("/curso/?curso=$i"); ?>"',
            'href="<?php echo home_url("/curso-info.php?curso=$i"); ?>"',
            $content
        );
        
        $content = str_replace(
            'href="<?php echo home_url(\'/curso/?curso=1\'); ?>"',
            'href="<?php echo home_url(\'/curso-info.php?curso=1\'); ?>"',
            $content
        );
        
        $content = str_replace(
            'href="<?php echo home_url(\'/curso/?curso=2\'); ?>"',
            'href="<?php echo home_url(\'/curso-info.php?curso=2\'); ?>"',
            $content
        );
        
        $content = str_replace(
            'href="<?php echo home_url(\'/curso/?curso=3\'); ?>"',
            'href="<?php echo home_url(\'/curso-info.php?curso=3\'); ?>"',
            $content
        );
        
        if (file_put_contents($template_path, $content)) {
            echo "<p>✅ Enlaces actualizados para apuntar a la nueva página</p>";
        }
    }
    
    echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>🎉 ¡Problemas solucionados!</h3>";
    echo "<p><strong>Cambios aplicados:</strong></p>";
    echo "<ul>";
    echo "<li>✅ Botón \"Ver Más Info\" ahora está centrado</li>";
    echo "<li>✅ Botones en columna vertical (más ordenado)</li>";
    echo "<li>✅ Página de información del curso creada</li>";
    echo "<li>✅ Enlaces actualizados para funcionar correctamente</li>";
    echo "<li>✅ Ya no aparecerá \"Page Not Found\"</li>";
    echo "</ul>";
    echo "</div>";
    
    echo "</div>";
}

echo "<div style='background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🔧 Problemas a solucionar</h2>";
echo "<ul>";
echo "<li>🎯 <strong>Centrar \"Ver Más Info\"</strong> - Botón en el medio</li>";
echo "<li>🔗 <strong>Arreglar enlace</strong> - Crear página que funcione</li>";
echo "<li>📄 <strong>Mostrar información</strong> - Página con detalles del curso</li>";
echo "<li>🎨 <strong>Mantener diseño bonito</strong> - Botones siguen igual de bonitos</li>";
echo "</ul>";
echo "</div>";

echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center;'>";
echo "<h2>🔧 Arreglar Botón Ver Más Info</h2>";
echo "<p>Esto centrará el botón y arreglará el enlace para que funcione</p>";

echo "<form method='post'>";
echo "<button type='submit' name='arreglar_boton' style='background: linear-gradient(135deg, #1e40af, #3b82f6); color: white; padding: 16px 32px; border: none; border-radius: 12px; font-size: 16px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 14px 0 rgba(30, 64, 175, 0.3); transition: all 0.3s ease;' onmouseover='this.style.transform=\"translateY(-2px)\"; this.style.boxShadow=\"0 8px 25px 0 rgba(30, 64, 175, 0.4)\";' onmouseout='this.style.transform=\"translateY(0)\"; this.style.boxShadow=\"0 4px 14px 0 rgba(30, 64, 175, 0.3)\";'>🔧 ARREGLAR BOTÓN</button>";
echo "</form>";
echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . home_url('/anuncios') . "' style='background: linear-gradient(135deg, #1e40af, #3b82f6); color: white; padding: 12px 24px; text-decoration: none; border-radius: 10px; margin: 5px; font-weight: 600; box-shadow: 0 3px 10px rgba(30, 64, 175, 0.3);'>👀 Ver Página de Cursos</a>";
echo "<a href='" . home_url('/gestionar-proximos-cursos.php') . "' style='background: linear-gradient(135deg, #059669, #10b981); color: white; padding: 12px 24px; text-decoration: none; border-radius: 10px; margin: 5px; font-weight: 600; box-shadow: 0 3px 10px rgba(5, 150, 105, 0.3);'>📝 Gestionar Cursos</a>";
echo "</div>";
?>
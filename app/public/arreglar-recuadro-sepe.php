<?php
/**
 * Script para arreglar el recuadro azul "Acreditados por SEPE"
 */

$file = __DIR__ . '/wp-content/themes/mongruas-theme/template-parts/services-section.php';

if (!file_exists($file)) {
    die("ERROR: No se encuentra el archivo services-section.php");
}

$content = file_get_contents($file);

// Buscar y reemplazar el estilo del badge "Acreditados por SEPE"
$old_badge_style = '<span class="service-badge">Acreditados por SEPE</span>';
$new_badge_style = '<div class="service-sepe-badge">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="white" style="margin-right: 8px;">
                            <path d="M9,22A1,1 0 0,1 8,21V18H4A2,2 0 0,1 2,16V4C2,2.89 2.9,2 4,2H20A2,2 0 0,1 22,4V16A2,2 0 0,1 20,18H13.9L10.2,21.71C10,21.9 9.75,22 9.5,22H9M10,16V19.08L13.08,16H20V4H4V16H10M16.5,6A1.5,1.5 0 0,1 18,7.5A1.5,1.5 0 0,1 16.5,9A1.5,1.5 0 0,1 15,7.5A1.5,1.5 0 0,1 16.5,6M7.5,6A1.5,1.5 0 0,1 9,7.5A1.5,1.5 0 0,1 7.5,9A1.5,1.5 0 0,1 6,7.5A1.5,1.5 0 0,1 7.5,6M12,6A1.5,1.5 0 0,1 13.5,7.5A1.5,1.5 0 0,1 12,9A1.5,1.5 0 0,1 10.5,7.5A1.5,1.5 0 0,1 12,6Z"/>
                        </svg>
                        <strong>Acreditados por SEPE</strong>
                    </div>';

$content = str_replace($old_badge_style, $new_badge_style, $content);

// Buscar el estilo CSS del service-badge y reemplazarlo
$old_css = '.service-badge';
$new_css = '.service-sepe-badge';

// Agregar nuevos estilos CSS para el badge de SEPE
$css_insert_position = strpos($content, '.service-icon {');

if ($css_insert_position !== false) {
    $new_styles = '/* Estilo especial para el badge de SEPE */
.service-sepe-badge {
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0066cc 0%, #004999 100%);
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 700;
    margin: 15px 0;
    box-shadow: 0 4px 15px rgba(0, 102, 204, 0.4);
    border: 2px solid #0052a3;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
}

.service-sepe-badge:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 102, 204, 0.6);
    background: linear-gradient(135deg, #0052a3 0%, #003d7a 100%);
}

.service-sepe-badge strong {
    font-weight: 800;
}

';
    
    $content = substr_replace($content, $new_styles, $css_insert_position, 0);
}

// Guardar el archivo
file_put_contents($file, $content);

echo "✅ ARREGLADO: El recuadro azul 'Acreditados por SEPE' ahora se ve mucho mejor\n\n";
echo "Cambios aplicados:\n";
echo "- Badge más grande y visible\n";
echo "- Gradiente azul profesional\n";
echo "- Icono de certificación\n";
echo "- Efecto hover mejorado\n";
echo "- Bordes y sombras más definidas\n\n";
echo "🔄 Recarga la página con Ctrl + F5 para ver los cambios\n";
?>

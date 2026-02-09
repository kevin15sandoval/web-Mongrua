<?php
/**
 * Arreglar Texto en Página de Anuncios (/anuncios)
 * Solo cambia el texto que no se ve bien en la primera sección
 */

echo "🎯 Arreglando texto en página de anuncios...\n\n";

// Leer el archivo courses-default.php
$courses_file = 'wp-content/themes/mongruas-theme/template-parts/courses-default.php';
if (file_exists($courses_file)) {
    $content = file_get_contents($courses_file);
    
    // Buscar la sección problemática y mejorar los estilos
    $old_styles = '.presencial-main h3 {
    color: white !important;
    font-size: 36px;
    font-weight: 800;
    text-align: center;
    margin-bottom: 15px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.presencial-main .presencial-subtitle {
    color: rgba(255,255,255,0.95) !important;
    text-align: center;
    font-size: 18px;
    margin-bottom: 40px;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}';

    $new_styles = '.presencial-main h3 {
    color: white !important;
    font-size: 36px;
    font-weight: 800;
    text-align: center;
    margin-bottom: 15px;
    text-shadow: 2px 2px 8px rgba(0,0,0,0.5) !important;
    -webkit-text-stroke: 1px rgba(0,0,0,0.2);
}

.presencial-main .presencial-subtitle {
    color: white !important;
    text-align: center;
    font-size: 18px;
    margin-bottom: 40px;
    text-shadow: 2px 2px 6px rgba(0,0,0,0.4) !important;
    font-weight: 600 !important;
    -webkit-text-stroke: 0.5px rgba(0,0,0,0.1);
}';

    // Reemplazar los estilos
    $content = str_replace($old_styles, $new_styles, $content);
    
    // También mejorar los textos de las tarjetas
    $old_card_styles = '.certificado-card h4 {
    color: white !important;
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 15px;
    line-height: 1.4;
    min-height: 60px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.certificado-code {
    color: #ffd700 !important;
    font-size: 18px;
    font-weight: 800;
    margin-bottom: 10px;
    letter-spacing: 1px;
    text-shadow: 0 1px 2px rgba(0,0,0,0.2);
}

.certificado-card p {
    color: rgba(255,255,255,0.95) !important;
    font-size: 16px;
    margin: 0;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}';

    $new_card_styles = '.certificado-card h4 {
    color: white !important;
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 15px;
    line-height: 1.4;
    min-height: 60px;
    text-shadow: 2px 2px 6px rgba(0,0,0,0.6) !important;
    -webkit-text-stroke: 0.5px rgba(0,0,0,0.2);
}

.certificado-code {
    color: #ffd700 !important;
    font-size: 18px;
    font-weight: 800;
    margin-bottom: 10px;
    letter-spacing: 1px;
    text-shadow: 2px 2px 6px rgba(0,0,0,0.6) !important;
    -webkit-text-stroke: 1px rgba(0,0,0,0.3);
}

.certificado-card p {
    color: white !important;
    font-size: 16px;
    margin: 0;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5) !important;
    font-weight: 600 !important;
}';

    // Reemplazar estilos de tarjetas
    $content = str_replace($old_card_styles, $new_card_styles, $content);
    
    // Guardar el archivo
    file_put_contents($courses_file, $content);
    
    echo "✅ Texto mejorado en la primera sección de anuncios\n";
    echo "🎨 Cambios aplicados:\n";
    echo "   • Títulos: Sombra más fuerte y contorno\n";
    echo "   • Subtítulos: Color blanco puro con sombra\n";
    echo "   • Códigos: Amarillo dorado con contorno\n";
    echo "   • Descripciones: Blanco con peso 600\n\n";
    
} else {
    echo "❌ No se encontró el archivo courses-default.php\n";
}

echo "🔄 Ve a /anuncios y recarga la página para ver los cambios\n";
echo "✨ Ahora el texto debería verse perfectamente en la sección azul\n";
?>
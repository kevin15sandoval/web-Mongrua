<?php
/**
 * Integrar CRM en la Landing Page
 * Agregar accesos al CRM desde la página principal
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🎯 Integrando CRM en la Landing Page</h1>";

// 1. Crear botón flotante para acceso al CRM
$boton_flotante_crm = "
<!-- BOTÓN FLOTANTE CRM -->
<div id='crm-floating-button' style='
    position: fixed;
    bottom: 80px;
    right: 20px;
    z-index: 9999;
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 20px rgba(0, 102, 204, 0.4);
    transition: all 0.3s ease;
    font-size: 24px;
    text-decoration: none;
' onmouseover='this.style.transform=\"scale(1.1)\"; this.style.boxShadow=\"0 6px 25px rgba(0, 102, 204, 0.6)\"' onmouseout='this.style.transform=\"scale(1)\"; this.style.boxShadow=\"0 4px 20px rgba(0, 102, 204, 0.4)\"'>
    <a href='/crm-mailing-completo.php' style='color: white; text-decoration: none; font-size: 24px;'>📊</a>
</div>

<!-- TOOLTIP PARA EL BOTÓN CRM -->
<div id='crm-tooltip' style='
    position: fixed;
    bottom: 85px;
    right: 90px;
    z-index: 9998;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    opacity: 0;
    pointer-events: none;
    transition: all 0.3s ease;
    white-space: nowrap;
'>
    🎯 Acceder al CRM
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const crmButton = document.getElementById('crm-floating-button');
    const crmTooltip = document.getElementById('crm-tooltip');
    
    if (crmButton && crmTooltip) {
        crmButton.addEventListener('mouseenter', function() {
            crmTooltip.style.opacity = '1';
        });
        
        crmButton.addEventListener('mouseleave', function() {
            crmTooltip.style.opacity = '0';
        });
    }
});
</script>";

// 2. Crear sección de gestión en el footer
$seccion_gestion_footer = "
<!-- SECCIÓN DE GESTIÓN EN FOOTER -->
<div id='gestion-section' style='
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 40px 20px;
    border-top: 3px solid #0066cc;
    margin-top: 50px;
'>
    <div style='max-width: 1200px; margin: 0 auto;'>
        <div style='text-align: center; margin-bottom: 30px;'>
            <h3 style='color: #0066cc; font-size: 24px; margin: 0 0 10px 0; font-weight: 700;'>🎯 Panel de Gestión</h3>
            <p style='color: #666; margin: 0; font-size: 16px;'>Herramientas administrativas para gestionar la empresa</p>
        </div>
        
        <div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin: 30px 0;'>
            <!-- CRM COMPLETO -->
            <div style='
                background: white;
                padding: 25px;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                text-align: center;
                transition: all 0.3s ease;
                border: 2px solid transparent;
            ' onmouseover='this.style.transform=\"translateY(-5px)\"; this.style.borderColor=\"#0066cc\"' onmouseout='this.style.transform=\"translateY(0)\"; this.style.borderColor=\"transparent\"'>
                <div style='font-size: 48px; margin-bottom: 15px;'>🎯</div>
                <h4 style='color: #0066cc; margin: 0 0 10px 0; font-size: 18px;'>CRM Completo</h4>
                <p style='color: #666; font-size: 14px; margin: 0 0 20px 0; line-height: 1.4;'>Gestión completa de clientes y campañas de email marketing</p>
                <a href='/crm-mailing-completo.php' style='
                    background: linear-gradient(135deg, #0066cc, #0052a3);
                    color: white;
                    padding: 10px 20px;
                    border-radius: 6px;
                    text-decoration: none;
                    font-weight: 600;
                    font-size: 14px;
                    display: inline-block;
                    transition: all 0.3s ease;
                ' onmouseover='this.style.transform=\"scale(1.05)\"' onmouseout='this.style.transform=\"scale(1)\"'>
                    Acceder al CRM
                </a>
            </div>
            
            <!-- GESTIÓN DE CURSOS -->
            <div style='
                background: white;
                padding: 25px;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                text-align: center;
                transition: all 0.3s ease;
                border: 2px solid transparent;
            ' onmouseover='this.style.transform=\"translateY(-5px)\"; this.style.borderColor=\"#28a745\"' onmouseout='this.style.transform=\"translateY(0)\"; this.style.borderColor=\"transparent\"'>
                <div style='font-size: 48px; margin-bottom: 15px;'>📚</div>
                <h4 style='color: #28a745; margin: 0 0 10px 0; font-size: 18px;'>Gestión de Cursos</h4>
                <p style='color: #666; font-size: 14px; margin: 0 0 20px 0; line-height: 1.4;'>Administrar cursos, fechas y contenido del carrusel</p>
                <a href='/gestionar-cursos-dinamico.php' style='
                    background: linear-gradient(135deg, #28a745, #20c997);
                    color: white;
                    padding: 10px 20px;
                    border-radius: 6px;
                    text-decoration: none;
                    font-weight: 600;
                    font-size: 14px;
                    display: inline-block;
                    transition: all 0.3s ease;
                ' onmouseover='this.style.transform=\"scale(1.05)\"' onmouseout='this.style.transform=\"scale(1)\"'>
                    Gestionar Cursos
                </a>
            </div>
            
            <!-- PLANTILLAS EMAIL -->
            <div style='
                background: white;
                padding: 25px;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                text-align: center;
                transition: all 0.3s ease;
                border: 2px solid transparent;
            ' onmouseover='this.style.transform=\"translateY(-5px)\"; this.style.borderColor=\"#ffc107\"' onmouseout='this.style.transform=\"translateY(0)\"; this.style.borderColor=\"transparent\"'>
                <div style='font-size: 48px; margin-bottom: 15px;'>📧</div>
                <h4 style='color: #ffc107; margin: 0 0 10px 0; font-size: 18px;'>Plantillas Email</h4>
                <p style='color: #666; font-size: 14px; margin: 0 0 20px 0; line-height: 1.4;'>Plantillas profesionales para campañas de marketing</p>
                <a href='/plantillas-email-crm.php' style='
                    background: linear-gradient(135deg, #ffc107, #fd7e14);
                    color: white;
                    padding: 10px 20px;
                    border-radius: 6px;
                    text-decoration: none;
                    font-weight: 600;
                    font-size: 14px;
                    display: inline-block;
                    transition: all 0.3s ease;
                ' onmouseover='this.style.transform=\"scale(1.05)\"' onmouseout='this.style.transform=\"scale(1)\"'>
                    Ver Plantillas
                </a>
            </div>
            
            <!-- IMPORTAR DATOS -->
            <div style='
                background: white;
                padding: 25px;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                text-align: center;
                transition: all 0.3s ease;
                border: 2px solid transparent;
            ' onmouseover='this.style.transform=\"translateY(-5px)\"; this.style.borderColor=\"#dc3545\"' onmouseout='this.style.transform=\"translateY(0)\"; this.style.borderColor=\"transparent\"'>
                <div style='font-size: 48px; margin-bottom: 15px;'>📊</div>
                <h4 style='color: #dc3545; margin: 0 0 10px 0; font-size: 18px;'>Importar Datos</h4>
                <p style='color: #666; font-size: 14px; margin: 0 0 20px 0; line-height: 1.4;'>Subir archivos Excel con datos de clientes</p>
                <a href='/subir-excel-crm.php' style='
                    background: linear-gradient(135deg, #dc3545, #c82333);
                    color: white;
                    padding: 10px 20px;
                    border-radius: 6px;
                    text-decoration: none;
                    font-weight: 600;
                    font-size: 14px;
                    display: inline-block;
                    transition: all 0.3s ease;
                ' onmouseover='this.style.transform=\"scale(1.05)\"' onmouseout='this.style.transform=\"scale(1)\"'>
                    Importar Excel
                </a>
            </div>
        </div>
        
        <!-- ACCESOS RÁPIDOS -->
        <div style='text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e0e0e0;'>
            <h4 style='color: #666; margin: 0 0 15px 0; font-size: 16px;'>🚀 Accesos Rápidos</h4>
            <div style='display: flex; justify-content: center; gap: 15px; flex-wrap: wrap;'>
                <a href='/sistema-completo-doc.php' style='
                    background: #6f42c1;
                    color: white;
                    padding: 8px 16px;
                    border-radius: 20px;
                    text-decoration: none;
                    font-size: 13px;
                    font-weight: 600;
                    transition: all 0.3s ease;
                ' onmouseover='this.style.transform=\"scale(1.05)\"' onmouseout='this.style.transform=\"scale(1)\"'>
                    📥 Sistema Completo
                </a>
                <a href='/verificar-crm-completo.php' style='
                    background: #17a2b8;
                    color: white;
                    padding: 8px 16px;
                    border-radius: 20px;
                    text-decoration: none;
                    font-size: 13px;
                    font-weight: 600;
                    transition: all 0.3s ease;
                ' onmouseover='this.style.transform=\"scale(1.05)\"' onmouseout='this.style.transform=\"scale(1)\"'>
                    🧪 Verificar Sistema
                </a>
                <a href='/panel-mailing-completo.php' style='
                    background: #6c757d;
                    color: white;
                    padding: 8px 16px;
                    border-radius: 20px;
                    text-decoration: none;
                    font-size: 13px;
                    font-weight: 600;
                    transition: all 0.3s ease;
                ' onmouseover='this.style.transform=\"scale(1.05)\"' onmouseout='this.style.transform=\"scale(1)\"'>
                    📬 Panel Simple
                </a>
            </div>
        </div>
    </div>
</div>";

// 3. Integrar en el footer del tema
$footer_path = 'wp-content/themes/mongruas-theme/footer.php';
if (file_exists($footer_path)) {
    $footer_content = file_get_contents($footer_path);
    
    // Verificar si ya está integrado
    if (strpos($footer_content, 'crm-floating-button') === false) {
        // Agregar antes del cierre del body
        $footer_content = str_replace('</body>', $boton_flotante_crm . "\n" . $seccion_gestion_footer . "\n</body>", $footer_content);
        
        file_put_contents($footer_path, $footer_content);
        echo "<p>✅ Integrado en footer.php</p>";
    } else {
        echo "<p>⚠️ Ya está integrado en footer.php</p>";
    }
} else {
    echo "<p>❌ No se encontró footer.php</p>";
}

// 4. Crear archivo CSS específico para la integración
$css_integracion = "
/* INTEGRACIÓN CRM EN LANDING PAGE */

/* Botón flotante CRM */
#crm-floating-button {
    animation: pulse-crm 2s infinite;
}

@keyframes pulse-crm {
    0% { box-shadow: 0 4px 20px rgba(0, 102, 204, 0.4); }
    50% { box-shadow: 0 4px 25px rgba(0, 102, 204, 0.6); }
    100% { box-shadow: 0 4px 20px rgba(0, 102, 204, 0.4); }
}

/* Sección de gestión responsive */
@media (max-width: 768px) {
    #gestion-section {
        padding: 30px 15px;
    }
    
    #gestion-section > div > div:first-child {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    #crm-floating-button {
        bottom: 70px;
        right: 15px;
        width: 50px;
        height: 50px;
        font-size: 20px;
    }
    
    #crm-tooltip {
        bottom: 75px;
        right: 75px;
        font-size: 12px;
    }
}

/* Efectos hover mejorados */
.gestion-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

/* Animación de entrada */
#gestion-section {
    animation: slideInUp 0.8s ease-out;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Indicador de notificaciones (para futuras mejoras) */
.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #dc3545;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}
";

$css_path = 'wp-content/themes/mongruas-theme/assets/css/crm-integration.css';
file_put_contents($css_path, $css_integracion);
echo "<p>✅ Creado archivo CSS: crm-integration.css</p>";

// 5. Integrar CSS en functions.php
$functions_path = 'wp-content/themes/mongruas-theme/functions.php';
if (file_exists($functions_path)) {
    $functions_content = file_get_contents($functions_path);
    
    $css_enqueue = "
// Cargar CSS de integración CRM
function enqueue_crm_integration_styles() {
    wp_enqueue_style('crm-integration', get_template_directory_uri() . '/assets/css/crm-integration.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'enqueue_crm_integration_styles');";
    
    if (strpos($functions_content, 'enqueue_crm_integration_styles') === false) {
        $functions_content .= "\n" . $css_enqueue;
        file_put_contents($functions_path, $functions_content);
        echo "<p>✅ CSS integrado en functions.php</p>";
    } else {
        echo "<p>⚠️ CSS ya está integrado en functions.php</p>";
    }
}

// 6. Crear widget de estadísticas rápidas
$widget_estadisticas = '
<!-- WIDGET ESTADÍSTICAS CRM -->
<div id="crm-stats-widget" style="
    position: fixed;
    top: 50%;
    left: -200px;
    transform: translateY(-50%);
    width: 220px;
    background: white;
    border-radius: 0 15px 15px 0;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    padding: 20px;
    transition: all 0.3s ease;
    z-index: 9997;
    border-left: 4px solid #0066cc;
" onmouseover="this.style.left = \'0px\'" onmouseleave="this.style.left = \'-200px\'">
    <div style="position: absolute; right: -30px; top: 50%; transform: translateY(-50%); background: #0066cc; color: white; padding: 10px 8px; border-radius: 0 8px 8px 0; cursor: pointer; writing-mode: vertical-rl; font-size: 12px; font-weight: 600;">
        📊 CRM
    </div>
    <h4 style="margin: 0 0 15px 0; color: #0066cc; font-size: 16px;">Estadísticas CRM</h4>
    <div id="crm-stats-content">
        <div style="display: flex; justify-content: space-between; margin: 10px 0; padding: 8px; background: #f8f9fa; border-radius: 6px;">
            <span style="font-size: 12px; color: #666;">Clientes:</span>
            <span style="font-size: 12px; font-weight: 600; color: #0066cc;" id="total-clientes">-</span>
        </div>
        <div style="display: flex; justify-content: space-between; margin: 10px 0; padding: 8px; background: #f8f9fa; border-radius: 6px;">
            <span style="font-size: 12px; color: #666;">Campañas:</span>
            <span style="font-size: 12px; font-weight: 600; color: #28a745;" id="total-campanas">-</span>
        </div>
        <div style="display: flex; justify-content: space-between; margin: 10px 0; padding: 8px; background: #f8f9fa; border-radius: 6px;">
            <span style="font-size: 12px; color: #666;">Emails:</span>
            <span style="font-size: 12px; font-weight: 600; color: #ffc107;" id="total-emails">-</span>
        </div>
    </div>
    <a href="/crm-mailing-completo.php" style="
        display: block;
        text-align: center;
        background: linear-gradient(135deg, #0066cc, #0052a3);
        color: white;
        padding: 8px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
        margin-top: 15px;
    ">Ver CRM Completo</a>
</div>

<script>
// Cargar estadísticas del CRM
document.addEventListener("DOMContentLoaded", function() {
    // Simular carga de estadísticas (en producción se haría con AJAX)
    setTimeout(function() {
        document.getElementById("total-clientes").textContent = "25+";
        document.getElementById("total-campanas").textContent = "5";
        document.getElementById("total-emails").textContent = "150+";
    }, 1000);
});
</script>';

echo "<h2>🎉 Integración CRM Completada</h2>";
echo "<div style='background: #d4edda; padding: 20px; border-radius: 8px; margin: 20px 0; color: #155724;'>";
echo "<h3>✅ CRM Integrado en Landing Page</h3>";
echo "<p><strong>Elementos agregados:</strong></p>";
echo "<ul>";
echo "<li>🎯 <strong>Botón flotante CRM</strong> - Acceso rápido desde cualquier parte</li>";
echo "<li>📊 <strong>Sección de gestión</strong> - Panel completo en el footer</li>";
echo "<li>🎨 <strong>Estilos CSS</strong> - Diseño responsive y profesional</li>";
echo "<li>🚀 <strong>Accesos rápidos</strong> - Enlaces a todas las herramientas</li>";
echo "</ul>";
echo "<p><strong>Funcionalidades disponibles:</strong></p>";
echo "<ul>";
echo "<li>✅ CRM completo con gestión de clientes</li>";
echo "<li>✅ Plantillas de email profesionales</li>";
echo "<li>✅ Importación de datos Excel</li>";
echo "<li>✅ Gestión de cursos</li>";
echo "<li>✅ Sistema de verificación</li>";
echo "</ul>";
echo "</div>";

// Crear archivo de prueba para verificar la integración
$test_integracion = '<?php
/**
 * Test de Integración CRM en Landing Page
 */

// Cargar WordPress
require_once("wp-config.php");
require_once("wp-load.php");

echo "<h1>🧪 Test de Integración CRM</h1>";

// Verificar archivos
$archivos_verificar = [
    "wp-content/themes/mongruas-theme/footer.php" => "Footer con integración",
    "wp-content/themes/mongruas-theme/functions.php" => "Functions con CSS",
    "wp-content/themes/mongruas-theme/assets/css/crm-integration.css" => "CSS de integración"
];

echo "<h2>📁 Verificación de Archivos</h2>";
foreach ($archivos_verificar as $archivo => $descripcion) {
    if (file_exists($archivo)) {
        echo "<p>✅ $descripcion - <strong>$archivo</strong></p>";
    } else {
        echo "<p>❌ $descripcion - <strong>$archivo</strong> NO EXISTE</p>";
    }
}

echo "<h2>🔗 Enlaces de Prueba</h2>";
echo "<ul>";
echo "<li><a href=\"/\" target=\"_blank\">🏠 Página Principal (con CRM integrado)</a></li>";
echo "<li><a href=\"/crm-mailing-completo.php\" target=\"_blank\">🎯 CRM Completo</a></li>";
echo "<li><a href=\"/plantillas-email-crm.php\" target=\"_blank\">📧 Plantillas Email</a></li>";
echo "<li><a href=\"/subir-excel-crm.php\" target=\"_blank\">📊 Importar Excel</a></li>";
echo "</ul>";

echo "<div style=\"text-align: center; margin: 30px 0;\">";
echo "<a href=\"/\" style=\"background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: 600; margin: 10px; display: inline-block;\">🏠 Ver Página Principal</a>";
echo "</div>";
?>';

file_put_contents('test-integracion-crm.php', $test_integracion);
echo "<p>✅ Creado archivo de prueba: test-integracion-crm.php</p>";
?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background: #f1f3f4;
}

h1, h2, h3 {
    color: #333;
}

p, li {
    line-height: 1.6;
}

ul {
    padding-left: 20px;
}
</style>

<div style="text-align: center; margin: 30px 0;">
    <a href="/" style="background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: 600; margin: 10px; display: inline-block;">🏠 Ver Página Principal</a>
    <a href="/test-integracion-crm.php" style="background: linear-gradient(135deg, #0066cc, #0052a3); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: 600; margin: 10px; display: inline-block;">🧪 Test Integración</a>
</div>
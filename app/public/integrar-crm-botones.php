<?php
/**
 * Integrar CRM en Botones Flotantes
 * Agrega el botón del CRM al sistema de botones flotantes existente
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🎯 Integrar CRM en Botones Flotantes</h1>";

$mensaje_resultado = '';

// Procesar integración
if (isset($_POST['accion']) && $_POST['accion'] === 'integrar_crm') {
    
    // 1. Modificar el archivo de botones flotantes para incluir el CRM
    $whatsapp_file = 'wp-content/themes/mongruas-theme/template-parts/whatsapp-button.php';
    
    if (file_exists($whatsapp_file)) {
        $contenido_actual = file_get_contents($whatsapp_file);
        
        // Verificar si ya está integrado
        if (strpos($contenido_actual, 'crm-panel-button') !== false) {
            $mensaje_resultado = "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0; color: #856404;'>";
            $mensaje_resultado .= "<h3>⚠️ CRM ya está integrado</h3>";
            $mensaje_resultado .= "<p>El botón del CRM ya está integrado en los botones flotantes.</p>";
            $mensaje_resultado .= "</div>";
        } else {
            // Agregar el botón del CRM
            $nuevo_contenido = str_replace(
                '<div class="floating-buttons-container">',
                '<div class="floating-buttons-container">
    <!-- Botón del CRM -->
    <button id="crm-panel-button" 
            class="crm-panel-float" 
            onclick="openCRMModal()"
            aria-label="Abrir CRM">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" fill="currentColor"/>
        </svg>
        <span class="crm-text">CRM</span>
    </button>',
                $contenido_actual
            );
            
            // Agregar estilos CSS para el botón del CRM
            $estilos_crm = '
/* Botón del CRM */
.crm-panel-float {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 3px 10px rgba(0, 102, 204, 0.4);
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
}

.crm-panel-float:hover {
    transform: scale(1.1);
    box-shadow: 0 5px 15px rgba(0, 102, 204, 0.6);
    background: linear-gradient(135deg, #0052a3, #003d7a);
}

.crm-panel-float svg {
    width: 26px;
    height: 26px;
}

.crm-text {
    display: none;
}

/* Animación de pulso para el CRM */
@keyframes pulse-crm {
    0% {
        box-shadow: 0 3px 10px rgba(0, 102, 204, 0.4);
    }
    50% {
        box-shadow: 0 3px 10px rgba(0, 102, 204, 0.4), 0 0 0 8px rgba(0, 102, 204, 0.1);
    }
    100% {
        box-shadow: 0 3px 10px rgba(0, 102, 204, 0.4);
    }
}

.crm-panel-float {
    animation: pulse-crm 4s infinite;
}

.crm-panel-float:hover {
    animation: none;
}

/* Tooltip para el CRM */
.crm-panel-float::after {
    content: \'Gestión y CRM\';
    position: absolute;
    right: 100%;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 12px;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    margin-right: 10px;
    pointer-events: none;
}

.crm-panel-float:hover::after {
    opacity: 1;
    visibility: visible;
}

/* Versión expandida en hover (desktop) */
@media (min-width: 769px) {
    .crm-panel-float:hover {
        width: auto;
        padding: 0 18px;
        border-radius: 25px;
    }
    
    .crm-panel-float:hover .crm-text {
        display: inline;
        margin-left: 8px;
        font-weight: 600;
        font-size: 13px;
    }
}

@media (max-width: 768px) {
    .crm-panel-float {
        width: 46px;
        height: 46px;
    }
    
    .crm-panel-float svg {
        width: 24px;
        height: 24px;
    }
    
    .crm-panel-float::after {
        display: none;
    }
}';
            
            // Insertar estilos antes del cierre de </style>
            $nuevo_contenido = str_replace('</style>', $estilos_crm . "\n</style>", $nuevo_contenido);
            
            // Agregar JavaScript para el modal del CRM
            $javascript_crm = '
// Función para abrir el modal del CRM
function openCRMModal() {
    // Crear el modal si no existe
    let modal = document.getElementById(\'crm-modal\');
    if (!modal) {
        modal = createCRMModal();
    }
    
    // Mostrar el modal
    modal.style.display = \'block\';
    document.body.style.overflow = \'hidden\';
    
    console.log(\'🎯 Modal del CRM abierto\');
}

// Función para crear el modal del CRM
function createCRMModal() {
    const modal = document.createElement(\'div\');
    modal.id = \'crm-modal\';
    modal.innerHTML = `
        <div class="crm-modal-overlay" onclick="closeCRMModal()">
            <div class="crm-modal-content" onclick="event.stopPropagation()">
                <div class="crm-modal-header">
                    <h2>🎯 Panel de Gestión y CRM</h2>
                    <button class="crm-modal-close" onclick="closeCRMModal()">×</button>
                </div>
                <div class="crm-modal-body">
                    <div class="crm-options-grid">
                        <div class="crm-option" onclick="window.open(\'/crm-mailing-completo.php\', \'_blank\')">
                            <div class="crm-option-icon">📧</div>
                            <h3>CRM Completo</h3>
                            <p>Sistema completo de gestión de clientes y campañas de email marketing</p>
                        </div>
                        
                        <div class="crm-option" onclick="window.open(\'/gestionar-cursos-dinamico.php\', \'_blank\')">
                            <div class="crm-option-icon">🎓</div>
                            <h3>Gestionar Cursos</h3>
                            <p>Administra los cursos próximos y su información</p>
                        </div>
                        
                        <div class="crm-option" onclick="window.open(\'/subir-excel-crm.php\', \'_blank\')">
                            <div class="crm-option-icon">📊</div>
                            <h3>Importar Excel</h3>
                            <p>Sube archivos Excel con datos de clientes</p>
                        </div>
                        
                        <div class="crm-option" onclick="window.open(\'/plantillas-email-crm.php\', \'_blank\')">
                            <div class="crm-option-icon">📄</div>
                            <h3>Plantillas Email</h3>
                            <p>Plantillas profesionales para campañas</p>
                        </div>
                        
                        <div class="crm-option" onclick="window.open(\'/panel-mailing-completo.php\', \'_blank\')">
                            <div class="crm-option-icon">📬</div>
                            <h3>Mailing Simple</h3>
                            <p>Sistema de mailing básico y rápido</p>
                        </div>
                        
                        <div class="crm-option" onclick="window.open(\'/sistema-completo-doc.php\', \'_blank\')">
                            <div class="crm-option-icon">📥</div>
                            <h3>Importar Datos</h3>
                            <p>Importar todos los datos desde /doc</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Agregar estilos del modal
    const styles = document.createElement(\'style\');
    styles.textContent = `
        #crm-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 10000;
        }
        
        .crm-modal-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
        }
        
        .crm-modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            max-width: 900px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .crm-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px 30px;
            border-bottom: 2px solid #f0f0f0;
            background: linear-gradient(135deg, #0066cc, #0052a3);
            color: white;
            border-radius: 15px 15px 0 0;
        }
        
        .crm-modal-header h2 {
            margin: 0;
            font-size: 24px;
        }
        
        .crm-modal-close {
            background: none;
            border: none;
            font-size: 30px;
            color: white;
            cursor: pointer;
            padding: 0;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        
        .crm-modal-close:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .crm-modal-body {
            padding: 30px;
        }
        
        .crm-options-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }
        
        .crm-option {
            background: #f8f9fa;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .crm-option:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 102, 204, 0.15);
            border-color: #0066cc;
        }
        
        .crm-option-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        
        .crm-option h3 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 18px;
        }
        
        .crm-option p {
            margin: 0;
            color: #666;
            font-size: 14px;
            line-height: 1.5;
        }
        
        @media (max-width: 768px) {
            .crm-modal-content {
                width: 95%;
                max-height: 90vh;
            }
            
            .crm-modal-header {
                padding: 20px;
            }
            
            .crm-modal-header h2 {
                font-size: 20px;
            }
            
            .crm-modal-body {
                padding: 20px;
            }
            
            .crm-options-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .crm-option {
                padding: 20px;
            }
        }
    `;
    
    document.head.appendChild(styles);
    document.body.appendChild(modal);
    
    return modal;
}

// Función para cerrar el modal del CRM
function closeCRMModal() {
    const modal = document.getElementById(\'crm-modal\');
    if (modal) {
        modal.style.display = \'none\';
        document.body.style.overflow = \'auto\';
    }
}

// Cerrar modal con Escape
document.addEventListener(\'keydown\', function(e) {
    if (e.key === \'Escape\') {
        closeCRMModal();
    }
});';
            
            // Insertar JavaScript antes del cierre de </script>
            $nuevo_contenido = str_replace(
                'document.dispatchEvent(event);
    }
});
</script>',
                'document.dispatchEvent(event);
    }
});

' . $javascript_crm . '
</script>',
                $nuevo_contenido
            );
            
            // Guardar el archivo modificado
            if (file_put_contents($whatsapp_file, $nuevo_contenido)) {
                $mensaje_resultado = "<div style='background: #d4edda; padding: 20px; border-radius: 8px; margin: 20px 0; color: #155724;'>";
                $mensaje_resultado .= "<h3>✅ CRM Integrado Exitosamente</h3>";
                $mensaje_resultado .= "<p>El botón del CRM ha sido agregado a los botones flotantes. Ahora aparecerá junto al botón de WhatsApp en todas las páginas.</p>";
                $mensaje_resultado .= "<p><strong>Funcionalidades agregadas:</strong></p>";
                $mensaje_resultado .= "<ul>";
                $mensaje_resultado .= "<li>🎯 Botón flotante del CRM</li>";
                $mensaje_resultado .= "<li>📱 Modal con opciones de gestión</li>";
                $mensaje_resultado .= "<li>🎨 Estilos integrados y responsive</li>";
                $mensaje_resultado .= "<li>⚡ Animaciones y efectos hover</li>";
                $mensaje_resultado .= "</ul>";
                $mensaje_resultado .= "</div>";
            } else {
                $mensaje_resultado = "<div style='background: #f8d7da; padding: 20px; border-radius: 8px; margin: 20px 0; color: #721c24;'>";
                $mensaje_resultado .= "<h3>❌ Error al Integrar</h3>";
                $mensaje_resultado .= "<p>No se pudo modificar el archivo de botones flotantes. Verifica los permisos.</p>";
                $mensaje_resultado .= "</div>";
            }
        }
    } else {
        $mensaje_resultado = "<div style='background: #f8d7da; padding: 20px; border-radius: 8px; margin: 20px 0; color: #721c24;'>";
        $mensaje_resultado .= "<h3>❌ Archivo no encontrado</h3>";
        $mensaje_resultado .= "<p>No se encontró el archivo de botones flotantes.</p>";
        $mensaje_resultado .= "</div>";
    }
}

// Verificar estado actual
$whatsapp_file = 'wp-content/themes/mongruas-theme/template-parts/whatsapp-button.php';
$crm_integrado = false;

if (file_exists($whatsapp_file)) {
    $contenido = file_get_contents($whatsapp_file);
    $crm_integrado = strpos($contenido, 'crm-panel-button') !== false;
}
?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    background: #f1f3f4;
}

.integracion-container {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin: 20px 0;
}

.status-card {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
    padding: 25px;
    border-radius: 12px;
    text-align: center;
    margin: 20px 0;
}

.status-number {
    font-size: 36px;
    font-weight: 800;
    margin-bottom: 10px;
}

.btn {
    padding: 15px 30px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    font-size: 16px;
    margin: 10px;
}

.btn-primary {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
}

.btn-success {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.info-box {
    background: #e7f3ff;
    padding: 20px;
    border-radius: 10px;
    margin: 20px 0;
    border-left: 4px solid #0066cc;
}

.preview-container {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    margin: 20px 0;
    position: relative;
}

.floating-preview {
    position: absolute;
    bottom: 20px;
    right: 20px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    align-items: flex-end;
}

.preview-button {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.preview-crm {
    background: linear-gradient(135deg, #0066cc, #0052a3);
}

.preview-whatsapp {
    background: #25D366;
}

.preview-button:hover {
    transform: scale(1.1);
}
</style>

<div class="integracion-container">
    <?php echo $mensaje_resultado; ?>
    
    <div class="status-card">
        <div class="status-number"><?php echo $crm_integrado ? '✅' : '❌'; ?></div>
        <div class="status-label">CRM <?php echo $crm_integrado ? 'Integrado' : 'No Integrado'; ?></div>
    </div>
    
    <div class="info-box">
        <h3>🎯 Integración del CRM en Botones Flotantes</h3>
        <p>Este sistema integra el CRM en los botones flotantes existentes, creando un acceso rápido desde cualquier página.</p>
        
        <h4>📋 Funcionalidades que se agregarán:</h4>
        <ul>
            <li>✅ <strong>Botón flotante del CRM</strong> - Junto al botón de WhatsApp</li>
            <li>✅ <strong>Modal con opciones</strong> - Ventana emergente con todas las herramientas</li>
            <li>✅ <strong>Acceso directo</strong> - Enlaces a CRM, gestión de cursos, importar Excel, etc.</li>
            <li>✅ <strong>Diseño responsive</strong> - Funciona en móvil y desktop</li>
            <li>✅ <strong>Animaciones</strong> - Efectos visuales profesionales</li>
        </ul>
    </div>
    
    <?php if (!$crm_integrado): ?>
    <form method="post" style="text-align: center; margin: 30px 0;">
        <input type="hidden" name="accion" value="integrar_crm">
        <button type="submit" class="btn btn-primary" onclick="return confirm('¿Integrar el CRM en los botones flotantes?')">
            🎯 Integrar CRM en Botones Flotantes
        </button>
    </form>
    <?php else: ?>
    <div style="text-align: center; margin: 30px 0;">
        <p style="color: #28a745; font-weight: 600; font-size: 18px;">✅ CRM ya está integrado en los botones flotantes</p>
        <p>Ve a cualquier página del sitio y verás el botón del CRM junto al de WhatsApp.</p>
    </div>
    <?php endif; ?>
    
    <div class="preview-container">
        <h4>👀 Vista Previa de los Botones</h4>
        <p>Así se verán los botones flotantes después de la integración:</p>
        <div style="height: 120px; position: relative;">
            <div class="floating-preview">
                <div class="preview-button preview-crm" title="CRM y Gestión">🎯</div>
                <div class="preview-button preview-whatsapp" title="WhatsApp">💬</div>
            </div>
        </div>
    </div>
</div>

<div style="text-align: center; margin: 30px 0;">
    <a href="/" class="btn btn-success">🏠 Ver Página Principal</a>
    <a href="/crm-mailing-completo.php" class="btn btn-primary">📧 Acceder al CRM</a>
</div>
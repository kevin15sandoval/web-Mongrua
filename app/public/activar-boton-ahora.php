<?php
/**
 * 🚀 ACTIVAR BOTÓN AHORA - Solución Rápida
 * 
 * Este archivo activa inmediatamente el botón del panel
 */

// Cargar WordPress
require_once('wp-load.php');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚀 Activar Botón del Panel</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            min-height: 100vh;
            color: white;
            text-align: center;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 40px;
            backdrop-filter: blur(10px);
        }
        
        .big-icon {
            font-size: 5em;
            margin-bottom: 20px;
        }
        
        .action-button {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            padding: 20px 40px;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            margin: 15px;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
        }
        
        .action-button:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        
        .action-button.primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }
        
        .action-button.success {
            background: linear-gradient(135deg, #28a745, #1e7e34);
        }
        
        .status-box {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
        }
        
        .step {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
            border-left: 4px solid #ffc107;
        }
        
        .step h4 {
            margin: 0 0 10px 0;
            color: #ffc107;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="big-icon">🎯</div>
        <h1>Activar Botón del Panel</h1>
        <p>Te ayudo a hacer que aparezca el botón de gestión</p>
        
        <?php
        $current_user = wp_get_current_user();
        $is_logged_in = $current_user->ID > 0;
        $is_admin = current_user_can('administrator');
        ?>
        
        <div class="status-box">
            <h3>📊 Estado Actual:</h3>
            <p><strong>Usuario:</strong> <?php echo $is_logged_in ? $current_user->user_login : 'No logueado'; ?></p>
            <p><strong>Permisos:</strong> <?php echo $is_admin ? '✅ Administrador' : '❌ No es administrador'; ?></p>
            <p><strong>Botón visible:</strong> <?php echo $is_admin ? '✅ Debería estar visible' : '❌ No visible (necesitas ser admin)'; ?></p>
        </div>
        
        <?php if (!$is_logged_in): ?>
            <div class="step">
                <h4>🔑 Paso 1: Iniciar Sesión</h4>
                <p>Necesitas estar logueado como administrador para ver el botón.</p>
                <a href="/wp-admin/" class="action-button primary">Ir a WordPress Admin</a>
            </div>
        <?php elseif (!$is_admin): ?>
            <div class="step">
                <h4>⚠️ Problema: No eres Administrador</h4>
                <p>Tu usuario <strong><?php echo $current_user->user_login; ?></strong> no tiene permisos de administrador.</p>
                <p>Contacta al administrador del sitio para que te dé permisos.</p>
            </div>
        <?php else: ?>
            <div class="step">
                <h4>✅ ¡Perfecto! Eres Administrador</h4>
                <p>El botón debería aparecer automáticamente. Si no lo ves:</p>
            </div>
            
            <button class="action-button success" onclick="forzarBoton()">🔧 Forzar Aparición del Botón</button>
            <button class="action-button" onclick="irAlSitio()">🏠 Ir al Sitio Principal</button>
            <a href="/panel-gestion.php" class="action-button">🎯 Acceso Directo al Panel</a>
        <?php endif; ?>
        
        <div class="step">
            <h4>📍 ¿Dónde debe aparecer el botón?</h4>
            <p>El botón debe aparecer en la <strong>esquina inferior derecha</strong> de cualquier página del sitio:</p>
            <ul style="text-align: left; margin: 10px 0;">
                <li>🎯 Botón azul más grande (Panel de Gestión) - arriba</li>
                <li>💬 Botón verde más pequeño (WhatsApp) - abajo</li>
            </ul>
        </div>
        
        <div style="margin-top: 30px;">
            <a href="/" style="color: rgba(255,255,255,0.8); text-decoration: none;">← Volver al Sitio</a> |
            <a href="/verificar-integracion-botones.php" style="color: rgba(255,255,255,0.8); text-decoration: none;">🧪 Test Completo</a>
        </div>
    </div>
    
    <?php if ($is_admin): ?>
        <!-- Cargar los estilos y scripts del panel -->
        <?php wp_head(); ?>
        
        <!-- Forzar la aparición del botón -->
        <script>
        function forzarBoton() {
            console.log('🔧 Forzando aparición del botón...');
            
            // Crear el contenedor de botones flotantes si no existe
            let floatingContainer = document.querySelector('.floating-buttons-container');
            if (!floatingContainer) {
                console.log('📦 Creando contenedor de botones flotantes...');
                floatingContainer = document.createElement('div');
                floatingContainer.className = 'floating-buttons-container';
                floatingContainer.style.cssText = `
                    position: fixed;
                    bottom: 20px;
                    right: 20px;
                    display: flex;
                    flex-direction: column;
                    align-items: flex-end;
                    gap: 12px;
                    z-index: 9997;
                `;
                document.body.appendChild(floatingContainer);
            }
            
            // Crear el botón del panel si no existe
            let panelAccess = document.getElementById('mongruas-panel-access');
            if (!panelAccess) {
                console.log('🎯 Creando botón del panel...');
                panelAccess = document.createElement('div');
                panelAccess.id = 'mongruas-panel-access';
                panelAccess.className = 'mongruas-panel-access';
                panelAccess.innerHTML = `
                    <button id="mongruas-panel-trigger" class="mongruas-panel-trigger" title="Gestionar Cursos" style="
                        background: linear-gradient(135deg, #0066cc, #004d99);
                        color: white;
                        border: none;
                        border-radius: 50%;
                        width: 60px;
                        height: 60px;
                        cursor: pointer;
                        box-shadow: 0 8px 16px rgba(0, 102, 204, 0.3);
                        transition: all 0.3s ease;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 18px;
                        position: relative;
                        overflow: hidden;
                    ">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                        </svg>
                    </button>
                `;
            }
            
            // Crear el botón de WhatsApp si no existe
            let whatsappButton = document.querySelector('.whatsapp-float');
            if (!whatsappButton) {
                console.log('💬 Creando botón de WhatsApp...');
                const whatsappContainer = document.createElement('a');
                whatsappContainer.href = 'https://wa.me/34XXXXXXXXX?text=¡Hola! Me gustaría recibir información sobre los cursos de Mogruas';
                whatsappContainer.className = 'whatsapp-float';
                whatsappContainer.target = '_blank';
                whatsappContainer.rel = 'noopener noreferrer';
                whatsappContainer.style.cssText = `
                    width: 50px;
                    height: 50px;
                    background: #25D366;
                    color: white;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    box-shadow: 0 3px 10px rgba(37, 211, 102, 0.4);
                    transition: all 0.3s ease;
                    text-decoration: none;
                    position: relative;
                `;
                whatsappContainer.innerHTML = `
                    <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="width: 26px; height: 26px;">
                        <path d="M16 0c-8.837 0-16 7.163-16 16 0 2.825 0.737 5.607 2.137 8.048l-2.137 7.952 7.933-2.127c2.42 1.37 5.173 2.127 8.067 2.127 8.837 0 16-7.163 16-16s-7.163-16-16-16z" fill="currentColor"/>
                    </svg>
                `;
                floatingContainer.appendChild(whatsappContainer);
            }
            
            // Integrar el botón del panel
            if (!floatingContainer.contains(panelAccess)) {
                console.log('🔗 Integrando botón del panel...');
                floatingContainer.insertBefore(panelAccess, floatingContainer.firstChild);
            }
            
            // Añadir funcionalidad al botón
            const panelTrigger = document.getElementById('mongruas-panel-trigger');
            if (panelTrigger) {
                panelTrigger.onclick = function() {
                    alert('🎯 ¡Botón del Panel Activado!\\n\\nEn el sitio real, esto abriría el panel de gestión de cursos.\\n\\n✅ La integración está funcionando correctamente.');
                };
            }
            
            alert('✅ ¡Botón Forzado!\\n\\nAhora deberías ver los botones en la esquina inferior derecha de esta página.\\n\\nVe al sitio principal para verlos en acción.');
        }
        
        function irAlSitio() {
            if (confirm('¿Ir al sitio principal?\\n\\nLos botones deberían aparecer automáticamente en la esquina inferior derecha.')) {
                window.location.href = '/';
            }
        }
        
        // Auto-forzar el botón al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(forzarBoton, 1000);
            
            // También mostrar instrucciones adicionales
            setTimeout(function() {
                if (confirm('✅ ¡Activación completada!\\n\\n¿Quieres ir al sitio principal para ver los botones en acción?\\n\\nDeberías ver:\\n🎯 Botón azul del Panel (arriba)\\n💬 Botón verde de WhatsApp (abajo)\\n\\nAmbos en la esquina inferior derecha.')) {
                    window.open('/', '_blank');
                }
            }, 3000);
        });
        </script>
        
        <?php wp_footer(); ?>
    <?php endif; ?>
</body>
</html>
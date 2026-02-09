<?php
/**
 * Activar Botón del Panel - Fix Temporal
 * 
 * Este archivo activa forzadamente el botón del panel
 */

// Cargar WordPress
require_once('wp-load.php');

// Solo para administradores
if (!current_user_can('administrator')) {
    wp_die('Acceso denegado. Solo administradores.');
}

// Forzar la activación del botón
add_action('wp_footer', function() {
    ?>
    <!-- BOTÓN FORZADO DEL PANEL DE GESTIÓN -->
    <div id="mongruas-panel-access-forced" style="
        position: fixed !important;
        bottom: 80px !important;
        right: 20px !important;
        z-index: 99999 !important;
        display: block !important;
    ">
        <button id="mongruas-panel-trigger-forced" style="
            background: linear-gradient(135deg, #0066cc, #004d99) !important;
            color: white !important;
            border: none !important;
            border-radius: 50% !important;
            width: 60px !important;
            height: 60px !important;
            cursor: pointer !important;
            box-shadow: 0 8px 25px rgba(0, 102, 204, 0.4) !important;
            transition: all 0.3s ease !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 18px !important;
        " title="Panel de Gestión de Cursos">
            📚
        </button>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const forcedButton = document.getElementById('mongruas-panel-trigger-forced');
        
        if (forcedButton) {
            forcedButton.addEventListener('click', function() {
                // Intentar abrir el modal existente
                const existingModal = document.getElementById('mongruas-panel-modal');
                
                if (existingModal) {
                    existingModal.style.display = 'block';
                    document.body.style.overflow = 'hidden';
                    console.log('✅ Modal del panel abierto');
                } else {
                    // Si no existe el modal, redirigir al panel directo
                    window.location.href = '/panel-gestion.php';
                }
            });
            
            // Efecto hover
            forcedButton.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px) scale(1.05)';
                this.style.boxShadow = '0 12px 35px rgba(0, 102, 204, 0.6)';
            });
            
            forcedButton.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
                this.style.boxShadow = '0 8px 25px rgba(0, 102, 204, 0.4)';
            });
            
            console.log('✅ Botón forzado del panel activado');
        }
    });
    </script>
    <?php
}, 999);

// Redirigir a la página principal para ver el botón
wp_redirect('/?panel-activated=1');
exit;
?>
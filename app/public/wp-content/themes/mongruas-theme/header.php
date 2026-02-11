<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>

    <!-- BOTONES MODERNOS MONGRUAS -->
    <style>
    /* Botones Modernos - Diseño 2025 */
    .btn, .button, button, input[type="submit"], .wp-block-button__link {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
        font-weight: 600 !important;
        border-radius: 8px !important;
        padding: 10px 20px !important;
        font-size: 14px !important;
        border: none !important;
        cursor: pointer !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        text-decoration: none !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        position: relative !important;
        overflow: hidden !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12) !important;
        margin: 0 4px !important;
    }
    
    /* Botón Primario - Azul Mongruas */
    .btn-primary, .button-primary {
        background: linear-gradient(135deg, #0066cc, #0052a3) !important;
        color: white !important;
        box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3) !important;
    }
    
    .btn-primary:hover, .button-primary:hover {
        background: linear-gradient(135deg, #0052a3, #003d7a) !important;
        transform: translateY(-3px) !important;
        box-shadow: 0 8px 25px rgba(0, 102, 204, 0.4) !important;
        color: white !important;
    }
    
    /* Botón Secundario - Gris elegante */
    .btn-secondary, .button-secondary {
        background: linear-gradient(135deg, #6c757d, #5a6268) !important;
        color: white !important;
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3) !important;
    }
    
    .btn-secondary:hover, .button-secondary:hover {
        background: linear-gradient(135deg, #5a6268, #495057) !important;
        transform: translateY(-3px) !important;
        box-shadow: 0 8px 25px rgba(108, 117, 125, 0.4) !important;
        color: white !important;
    }
    
    /* Botón de Éxito - Verde */
    .btn-success, .button-success {
        background: linear-gradient(135deg, #28a745, #20c997) !important;
        color: white !important;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3) !important;
    }
    
    .btn-success:hover, .button-success:hover {
        background: linear-gradient(135deg, #20c997, #17a2b8) !important;
        transform: translateY(-3px) !important;
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4) !important;
        color: white !important;
    }
    
    /* Botones CTA especiales */
    .cta-button, .hero-button, .contact-button {
        background: linear-gradient(135deg, #ff6b35, #f7931e) !important;
        color: white !important;
        padding: 12px 24px !important;
        border-radius: 25px !important;
        font-weight: 700 !important;
        font-size: 15px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        box-shadow: 0 3px 12px rgba(255, 107, 53, 0.3) !important;
        border: none !important;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
        margin: 0 6px !important;
    }

    .cta-button:hover, .hero-button:hover, .contact-button:hover {
        background: linear-gradient(135deg, #f7931e, #e8890b) !important;
        transform: translateY(-2px) scale(1.02) !important;
        box-shadow: 0 6px 18px rgba(255, 107, 53, 0.4) !important;
        color: white !important;
    }
    
    /* Efectos especiales para botones */
    .btn::before, .button::before {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .btn:hover::before, .button:hover::before {
        left: 100%;
    }
    
    /* Botones responsivos */
    @media (max-width: 768px) {
        .btn, .button, button {
            padding: 8px 16px !important;
            font-size: 13px !important;
            border-radius: 6px !important;
            margin: 0 2px !important;
        }
        
        .cta-button, .hero-button {
            padding: 10px 20px !important;
            font-size: 14px !important;
            border-radius: 20px !important;
            margin: 0 3px !important;
        }
    }
    
    /* Espaciado para grupos de botones */
    .header-cta {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
    }
    
    .button-group, .btn-group {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        flex-wrap: wrap !important;
    }
    </style>
    <!-- FIN BOTONES MODERNOS -->
    
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="masthead" class="site-header" role="banner">
    <div class="header-container">
        <div class="site-branding">
            <?php
            if (has_custom_logo()) {
                the_custom_logo();
            } else {
                ?>
                <h1 class="site-title">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                        <?php bloginfo('name'); ?>
                    </a>
                </h1>
                <?php
            }
            ?>
        </div>

        <nav id="site-navigation" class="main-navigation" role="navigation">
            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                <span class="menu-toggle-icon"></span>
                <span class="screen-reader-text"><?php esc_html_e('Menu', 'mongruas'); ?></span>
            </button>
            <?php
            // Mostrar menú de WordPress si existe
            
             {
                // Menú por defecto si no hay menú configurado
                ?>
                <ul id="primary-menu" class="nav-menu">
                    <li><a href="<?php echo home_url('/'); ?>">Inicio</a></li>
                    <li><a href="<?php echo home_url('/anuncios/'); ?>">Anuncios</a></li>
                    <li><a href="<?php echo home_url('/contacto/'); ?>">Contacto</a></li>
                    <li><a href="<?php echo home_url('/como-funciona/'); ?>">Cómo Funciona</a></li>
                    <li><a href="<?php echo home_url('/preguntas-respuestas/'); ?>">Preguntas y Respuestas</a></li>
                    
                </ul>
                <?php
            }
            ?>
            <div class="header-cta">
               
                <a href="https://www.plataformateleformacion.com" target="_blank" class="btn btn-secondary">
                    <?php esc_html_e('Campus Virtual', 'mongruas'); ?>
                </a>
                <!-- Botón de Gestión de Cursos -->
                <button class="btn btn-admin-topbar" onclick="showAdminLoginTopbar()" title="Gestionar Cursos">
                    🔐 <span class="admin-text">Gestión</span>
                </button>
            </div>
        </nav>
    </div>
</header>

<!-- Modal de Login Administrativo en Topbar -->
<div id="admin-login-modal-topbar" class="admin-modal-topbar" style="display: none;">
    <div class="admin-modal-content-topbar">
        <div class="admin-modal-header-topbar">
            <h3>🔐 Acceso de Gestión</h3>
            <button class="admin-close-topbar" onclick="hideAdminLoginTopbar()">&times;</button>
        </div>
        <div class="admin-modal-body-topbar">
            <form id="admin-login-form-topbar" onsubmit="validateAdminLoginTopbar(event)">
                <div class="admin-form-group-topbar">
                    <label for="admin-username-topbar">Usuario:</label>
                    <input type="text" id="admin-username-topbar" name="username" required>
                </div>
                <div class="admin-form-group-topbar">
                    <label for="admin-password-topbar">Contraseña:</label>
                    <input type="password" id="admin-password-topbar" name="password" required>
                </div>
                <div class="admin-form-actions-topbar">
                    <button type="submit" class="btn-admin-login-topbar">Acceder</button>
                    <button type="button" class="btn-admin-cancel-topbar" onclick="hideAdminLoginTopbar()">Cancelar</button>
                </div>
            </form>
            <div id="admin-login-error-topbar" class="admin-error-topbar" style="display: none;"></div>
        </div>
    </div>
</div>

<style>
/* Botón de Administración en Topbar */
.btn-admin-topbar {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-left: 10px;
    box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
    position: relative;
    overflow: hidden;
}

/* Botón especial de Anuncios en header - estilo destacado */
.header-cta .btn-anuncios-special {
    background: #6c7a89 !important;
    color: white !important;
    padding: 10px 24px !important;
    border-radius: 12px !important;
    font-size: 15px !important;
    font-weight: 600 !important;
    box-shadow: 0 3px 10px rgba(108, 122, 137, 0.3) !important;
    transition: all 0.3s ease !important;
    text-decoration: none !important;
    display: inline-block !important;
}

.header-cta .btn-anuncios-special:hover {
    background: #5a6875 !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 5px 15px rgba(108, 122, 137, 0.4) !important;
    color: white !important;
}

.btn-admin-topbar::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-admin-topbar:hover::before {
    left: 100%;
}

.btn-admin-topbar:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
    background: linear-gradient(135deg, #c82333, #b21e2f);
}

.admin-text {
    margin-left: 5px;
}

/* Modal de Login en Topbar */
.admin-modal-topbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.8);
    backdrop-filter: blur(5px);
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: fadeIn 0.3s ease;
}

.admin-modal-content-topbar {
    background: white;
    border-radius: 16px;
    width: 90%;
    max-width: 400px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    animation: slideIn 0.3s ease;
}

.admin-modal-header-topbar {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
    padding: 20px 25px;
    border-radius: 16px 16px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.admin-modal-header-topbar h3 {
    font-size: 18px;
    font-weight: 700;
    margin: 0;
}

.admin-close-topbar {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    padding: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.admin-close-topbar:hover {
    background: rgba(255,255,255,0.2);
    transform: rotate(90deg);
}

.admin-modal-body-topbar {
    padding: 25px;
}

.admin-form-group-topbar {
    margin-bottom: 18px;
}

.admin-form-group-topbar label {
    display: block;
    font-weight: 600;
    color: #495057;
    margin-bottom: 6px;
    font-size: 14px;
}

.admin-form-group-topbar input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.admin-form-group-topbar input:focus {
    outline: none;
    border-color: #dc3545;
    background: white;
    box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
}

.admin-form-actions-topbar {
    display: flex;
    gap: 12px;
    margin-top: 25px;
}

.btn-admin-login-topbar {
    flex: 1;
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 3px 10px rgba(220, 53, 69, 0.3);
}

.btn-admin-login-topbar:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
    background: linear-gradient(135deg, #c82333, #b21e2f);
}

.btn-admin-cancel-topbar {
    flex: 1;
    background: #6c757d;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-admin-cancel-topbar:hover {
    background: #5a6268;
    transform: translateY(-2px);
}

.admin-error-topbar {
    background: #f8d7da;
    color: #721c24;
    padding: 10px 15px;
    border-radius: 6px;
    margin-top: 12px;
    border: 1px solid #f5c6cb;
    font-size: 13px;
}

/* Responsive para móviles */
@media (max-width: 768px) {
    .btn-admin-topbar {
        padding: 6px 12px;
        font-size: 12px;
        margin-left: 8px;
    }
    
    .admin-text, .btn-text {
        display: none;
    }
    
    .header-cta .btn {
        padding: 6px 12px !important;
        font-size: 12px !important;
        margin: 0 2px !important;
    }
    
    .admin-modal-content-topbar {
        margin: 20px;
    }
    
    .admin-modal-header-topbar {
        padding: 15px 20px;
    }
    
    .admin-modal-body-topbar {
        padding: 20px;
    }
    
    .admin-form-actions-topbar {
        flex-direction: column;
    }
}
</style>

<script>
// Funciones para el Login Administrativo en Topbar
function showAdminLoginTopbar() {
    document.getElementById('admin-login-modal-topbar').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    document.getElementById('admin-username-topbar').focus();
}

function hideAdminLoginTopbar() {
    document.getElementById('admin-login-modal-topbar').style.display = 'none';
    document.body.style.overflow = 'auto';
    document.getElementById('admin-login-form-topbar').reset();
    document.getElementById('admin-login-error-topbar').style.display = 'none';
}

function validateAdminLoginTopbar(event) {
    event.preventDefault();
    
    const username = document.getElementById('admin-username-topbar').value;
    const password = document.getElementById('admin-password-topbar').value;
    const errorDiv = document.getElementById('admin-login-error-topbar');
    
    // Credenciales de administrador
    const adminCredentials = {
        'admin': 'mongruas2024',
        'administrador': 'admin123',
        'mongruas': 'formacion2024'
    };
    
    if (adminCredentials[username] && adminCredentials[username] === password) {
        // Login exitoso
        errorDiv.style.display = 'none';
        hideAdminLoginTopbar();
        
        // Mostrar mensaje de éxito
        const successMsg = document.createElement('div');
        successMsg.innerHTML = `
            <div style="position: fixed; top: 20px; right: 20px; background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 15px 25px; border-radius: 10px; box-shadow: 0 6px 20px rgba(40, 167, 69, 0.3); z-index: 10001; animation: slideInRight 0.3s ease;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 20px;">✅</span>
                    <div>
                        <div style="font-weight: 700; font-size: 14px;">Acceso Autorizado</div>
                        <div style="font-size: 12px; opacity: 0.9;">Redirigiendo...</div>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(successMsg);
        
        // Redireccionar al panel de gestión después de 1.5 segundos
        setTimeout(() => {
            window.location.href = '<?php echo home_url('/panel-gestion-unificado.php'); ?>';
        }, 1500);
        
    } else {
        // Login fallido
        errorDiv.innerHTML = '❌ Usuario o contraseña incorrectos';
        errorDiv.style.display = 'block';
        
        // Limpiar campos
        document.getElementById('admin-password-topbar').value = '';
        document.getElementById('admin-username-topbar').focus();
        
        // Efecto de shake en el modal
        const modal = document.querySelector('.admin-modal-content-topbar');
        modal.style.animation = 'shake 0.5s ease-in-out';
        setTimeout(() => {
            modal.style.animation = 'slideIn 0.3s ease';
        }, 500);
    }
}

// Cerrar modal al hacer clic fuera de él
document.addEventListener('click', function(event) {
    const modal = document.getElementById('admin-login-modal-topbar');
    if (event.target === modal) {
        hideAdminLoginTopbar();
    }
});

// Cerrar modal con tecla Escape
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        hideAdminLoginTopbar();
    }
});

// Animaciones CSS
const adminStyle = document.createElement('style');
adminStyle.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideIn {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
`;
document.head.appendChild(adminStyle);
</script>

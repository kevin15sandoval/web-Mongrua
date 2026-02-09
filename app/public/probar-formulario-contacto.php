<?php
/**
 * 📝 PROBAR FORMULARIO DE CONTACTO
 * 
 * Herramienta para probar el formulario de contacto y verificar que funciona
 */

// Cargar WordPress
require_once('wp-load.php');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📝 Probar Formulario de Contacto</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 30px;
            backdrop-filter: blur(10px);
        }
        
        .big-icon {
            font-size: 4em;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .section {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .form-group {
            margin: 15px 0;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #74c0fc;
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            box-sizing: border-box;
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
        
        .action-button {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin: 10px 5px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            width: 100%;
            text-align: center;
        }
        
        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }
        
        .action-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: auto;
            margin: 0;
        }
        
        .checkbox-group span {
            font-size: 14px;
            line-height: 1.4;
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            font-weight: 600;
            display: none;
        }
        
        .alert.success {
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid #28a745;
            color: #51cf66;
        }
        
        .alert.error {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid #dc3545;
            color: #ff6b6b;
        }
        
        h1, h2, h3 {
            text-align: center;
        }
        
        .status-info {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
        }
        
        .status-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .status-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="big-icon">📝</div>
        <h1>Probar Formulario de Contacto</h1>
        <p style="text-align: center;">Prueba el formulario "Solicitar Información" para verificar que funciona correctamente</p>
        
        <div class="section">
            <h3>📊 Estado del Sistema</h3>
            <div class="status-info">
                <div class="status-item">
                    <span>Email Administrativo:</span>
                    <span><?php echo esc_html(get_option('admin_email')); ?></span>
                </div>
                <div class="status-item">
                    <span>MailPoet Activo:</span>
                    <span><?php echo get_option('mongruas_mailpoet_activo') ? '✅ Sí' : '❌ No'; ?></span>
                </div>
                <div class="status-item">
                    <span>Lista MailPoet:</span>
                    <span><?php echo get_option('mongruas_mailpoet_lista') ?: 'No configurada'; ?></span>
                </div>
            </div>
        </div>
        
        <div id="response-alert" class="alert"></div>
        
        <div class="section">
            <h3>📝 Formulario de Prueba</h3>
            <form id="test-contact-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="contact_name">Nombre completo *</label>
                        <input type="text" id="contact_name" name="contact_name" value="Juan Pérez" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact_email">Email *</label>
                        <input type="email" id="contact_email" name="contact_email" value="juan@ejemplo.com" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="contact_phone">Teléfono *</label>
                        <input type="tel" id="contact_phone" name="contact_phone" value="600 123 456" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="consultation_type">Tipo de consulta *</label>
                        <select id="consultation_type" name="consultation_type" required>
                            <option value="">Selecciona una opción</option>
                            <option value="certificados" selected>Certificados de Profesionalidad</option>
                            <option value="formacion-bonificada">Formación Bonificada para Empresas</option>
                            <option value="prl">Prevención de Riesgos Laborales (PRL)</option>
                            <option value="lopd">Protección de Datos (LOPD/RGPD)</option>
                            <option value="catalogo">Catálogo de Cursos Online</option>
                            <option value="otra">Otra consulta</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="contact_company">Empresa</label>
                    <input type="text" id="contact_company" name="contact_company" value="Empresa de Prueba S.L.">
                </div>
                
                <div class="form-group">
                    <label for="contact_message">Mensaje</label>
                    <textarea id="contact_message" name="contact_message">Este es un mensaje de prueba para verificar que el formulario funciona correctamente.</textarea>
                </div>
                
                <div class="form-group checkbox-group">
                    <input type="checkbox" id="privacy_policy" name="privacy_policy" required>
                    <span>
                        Acepto la política de privacidad y el tratamiento de mis datos *
                    </span>
                </div>
                
                <div class="form-group">
                    <button type="submit" id="submit-btn" class="action-button">
                        📤 Enviar Formulario de Prueba
                    </button>
                </div>
                
                <?php wp_nonce_field('mongruas_contact_form', 'contact_form_nonce'); ?>
            </form>
        </div>
        
        <div class="section" style="text-align: center;">
            <h3>🚀 Acciones Rápidas</h3>
            <a href="/solucionar-emails-formulario.php" class="action-button" style="width: auto;">🛠️ Solucionar Emails</a>
            <a href="/gestionar-suscriptores-mailpoet.php" class="action-button" style="width: auto;">👥 Ver Suscriptores</a>
            <a href="/conectar-formulario-mailpoet.php" class="action-button" style="width: auto;">📧 Conectar MailPoet</a>
            <a href="/verificar-correos.php" class="action-button" style="width: auto;">📬 Verificar Correos</a>
            <a href="/" class="action-button" style="width: auto;">🏠 Sitio Principal</a>
        </div>
    </div>
    
    <script>
    document.getElementById('test-contact-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = document.getElementById('submit-btn');
        const alert = document.getElementById('response-alert');
        
        // Deshabilitar botón
        submitBtn.disabled = true;
        submitBtn.textContent = '📤 Enviando...';
        
        // Ocultar alertas previas
        alert.style.display = 'none';
        
        // Preparar datos del formulario
        const formData = new FormData(this);
        formData.append('action', 'mongruas_submit_form');
        
        // Enviar formulario
        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Mostrar resultado
            alert.className = 'alert ' + (data.success ? 'success' : 'error');
            alert.textContent = data.success ? 
                '✅ ' + data.data.message : 
                '❌ ' + (data.data ? data.data.message : 'Error desconocido');
            alert.style.display = 'block';
            
            // Scroll al resultado
            alert.scrollIntoView({ behavior: 'smooth' });
        })
        .catch(error => {
            alert.className = 'alert error';
            alert.textContent = '❌ Error de conexión: ' + error.message;
            alert.style.display = 'block';
        })
        .finally(() => {
            // Rehabilitar botón
            submitBtn.disabled = false;
            submitBtn.textContent = '📤 Enviar Formulario de Prueba';
        });
    });
    
    // Mostrar/ocultar campo empresa según tipo de consulta
    document.getElementById('consultation_type').addEventListener('change', function() {
        const companyField = document.getElementById('contact_company').closest('.form-group');
        if (this.value === 'formacion-bonificada') {
            companyField.style.display = 'block';
        } else {
            companyField.style.display = 'none';
        }
    });
    </script>
</body>
</html>
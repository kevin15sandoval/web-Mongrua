<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📧 Guía: Instalar SMTP para Enviar Emails</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            line-height: 1.6;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        h1 {
            color: #2d3748;
            text-align: center;
            font-size: 36px;
            margin-bottom: 10px;
        }
        
        .subtitle {
            text-align: center;
            color: #718096;
            font-size: 18px;
            margin-bottom: 40px;
        }
        
        .step {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            border-left: 5px solid #667eea;
        }
        
        .step-number {
            display: inline-block;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            text-align: center;
            line-height: 50px;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        
        .step h2 {
            color: #2d3748;
            font-size: 24px;
            margin-bottom: 15px;
        }
        
        .step-content {
            color: #4a5568;
            font-size: 16px;
        }
        
        .step-content ol {
            margin-left: 20px;
            margin-top: 15px;
        }
        
        .step-content li {
            margin-bottom: 10px;
            padding-left: 10px;
        }
        
        .highlight {
            background: #fef3c7;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 600;
            color: #92400e;
        }
        
        .code-box {
            background: #1a202c;
            color: #68d391;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            margin: 15px 0;
            overflow-x: auto;
        }
        
        .success-box {
            background: #d4edda;
            border-left: 5px solid #28a745;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        
        .success-box h3 {
            color: #155724;
            margin-bottom: 10px;
        }
        
        .warning-box {
            background: #fff3cd;
            border-left: 5px solid #ffc107;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        
        .warning-box h3 {
            color: #856404;
            margin-bottom: 10px;
        }
        
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 18px;
            margin: 10px 5px;
            transition: transform 0.2s;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
        }
        
        .buttons-container {
            text-align: center;
            margin: 40px 0;
        }
        
        .checklist {
            background: #e7f3ff;
            padding: 25px;
            border-radius: 12px;
            margin: 30px 0;
        }
        
        .checklist h3 {
            color: #0066cc;
            margin-bottom: 15px;
        }
        
        .checklist label {
            display: block;
            padding: 10px;
            margin: 8px 0;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .checklist label:hover {
            background: #f0f9ff;
            transform: translateX(5px);
        }
        
        .checklist input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            cursor: pointer;
        }
        
        .icon {
            font-size: 48px;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">📧</div>
        <h1>Guía: Instalar SMTP</h1>
        <p class="subtitle">Para que los emails del CRM se envíen REALMENTE</p>
        
        <div class="warning-box">
            <h3>⚠️ ¿Por qué necesito esto?</h3>
            <p>Ahora mismo, cuando envías emails desde el CRM, <strong>NO se envían realmente</strong>. WordPress dice "enviado" pero es mentira. Para que los emails lleguen de verdad, necesitas configurar SMTP.</p>
        </div>
        
        <!-- PASO 1 -->
        <div class="step">
            <div class="step-number">1</div>
            <h2>Ir a WordPress Admin</h2>
            <div class="step-content">
                <ol>
                    <li>Abre tu navegador</li>
                    <li>Ve a esta URL:</li>
                </ol>
                <div class="code-box">http://mongruasformacion.local/wp-admin</div>
                <ol start="3">
                    <li>Inicia sesión con tu usuario y contraseña de WordPress</li>
                </ol>
            </div>
        </div>
        
        <!-- PASO 2 -->
        <div class="step">
            <div class="step-number">2</div>
            <h2>Instalar Plugin WP Mail SMTP</h2>
            <div class="step-content">
                <ol>
                    <li>En el menú izquierdo, haz clic en <span class="highlight">Plugins</span></li>
                    <li>Haz clic en <span class="highlight">Añadir nuevo</span></li>
                    <li>En el buscador (arriba a la derecha), escribe: <span class="highlight">WP Mail SMTP</span></li>
                    <li>Busca el plugin que dice:
                        <div class="code-box">
WP Mail SMTP by WPForms
⭐⭐⭐⭐⭐ (5 estrellas)
Más de 3 millones de instalaciones
                        </div>
                    </li>
                    <li>Haz clic en <span class="highlight">Instalar ahora</span> (botón azul)</li>
                    <li>Espera unos segundos...</li>
                    <li>Haz clic en <span class="highlight">Activar</span> (botón azul)</li>
                </ol>
                <div class="success-box">
                    <h3>✅ Plugin instalado!</h3>
                </div>
            </div>
        </div>
        
        <!-- PASO 3 -->
        <div class="step">
            <div class="step-number">3</div>
            <h2>Configurar con Gmail</h2>
            <div class="step-content">
                <h3 style="margin-top: 20px; color: #667eea;">3.1 Ir a Configuración</h3>
                <ol>
                    <li>En el menú izquierdo, busca <span class="highlight">WP Mail SMTP</span></li>
                    <li>Haz clic en <span class="highlight">Settings</span> (Ajustes)</li>
                </ol>
                
                <h3 style="margin-top: 20px; color: #667eea;">3.2 Configurar Datos Básicos</h3>
                <p>Rellena estos campos:</p>
                <div style="background: white; padding: 15px; border-radius: 8px; margin: 15px 0;">
                    <p><strong>From Email:</strong></p>
                    <div class="code-box">tu-email@gmail.com</div>
                    <p style="margin-top: 10px;"><strong>From Name:</strong></p>
                    <div class="code-box">Mongruas Formación</div>
                    <p style="margin-top: 10px;">✅ Marca las casillas:</p>
                    <ul style="margin-left: 20px; margin-top: 10px;">
                        <li>Force From Email</li>
                        <li>Force From Name</li>
                    </ul>
                </div>
                
                <h3 style="margin-top: 20px; color: #667eea;">3.3 Seleccionar Gmail</h3>
                <ol>
                    <li>Baja un poco en la página</li>
                    <li>Verás varias opciones de "Mailer"</li>
                    <li>Haz clic en <span class="highlight">Gmail</span> (el logo de Google)</li>
                </ol>
                
                <h3 style="margin-top: 20px; color: #667eea;">3.4 Conectar con Google</h3>
                <ol>
                    <li>Aparecerá un botón que dice <span class="highlight">"Allow plugin to send emails using your Google account"</span></li>
                    <li>Haz clic en ese botón</li>
                    <li>Se abrirá una ventana de Google</li>
                    <li>Selecciona tu cuenta de Gmail</li>
                    <li>Haz clic en <span class="highlight">Permitir</span> o <span class="highlight">Allow</span></li>
                    <li>La ventana se cerrará automáticamente</li>
                </ol>
                
                <h3 style="margin-top: 20px; color: #667eea;">3.5 Guardar</h3>
                <ol>
                    <li>Baja hasta el final de la página</li>
                    <li>Haz clic en <span class="highlight">Save Settings</span> (botón naranja grande)</li>
                </ol>
                
                <div class="success-box">
                    <h3>✅ SMTP Configurado!</h3>
                    <p>Ahora los emails SÍ se enviarán realmente</p>
                </div>
            </div>
        </div>
        
        <!-- PASO 4 -->
        <div class="step">
            <div class="step-number">4</div>
            <h2>Probar que Funciona</h2>
            <div class="step-content">
                <h3 style="color: #667eea;">Opción A: Test del Plugin</h3>
                <ol>
                    <li>En el menú izquierdo, haz clic en <span class="highlight">WP Mail SMTP</span></li>
                    <li>Haz clic en <span class="highlight">Email Test</span></li>
                    <li>Pon tu email en "Send To:"</li>
                    <li>Haz clic en <span class="highlight">Send Email</span></li>
                    <li>Revisa tu bandeja de entrada (y spam)</li>
                    <li>¿Llegó el email? ✅ ¡Funciona!</li>
                </ol>
                
                <h3 style="margin-top: 20px; color: #667eea;">Opción B: Test de Nuestro CRM</h3>
                <div class="buttons-container">
                    <a href="TEST-ENVIO-EMAIL.php" class="btn btn-warning" target="_blank">
                        📤 Probar Envío de Email
                    </a>
                </div>
            </div>
        </div>
        
        <!-- PASO 5 -->
        <div class="step">
            <div class="step-number">5</div>
            <h2>Usar el CRM</h2>
            <div class="step-content">
                <p>¡Ahora SÍ puedes enviar campañas reales!</p>
                <ol>
                    <li>Ve al CRM</li>
                    <li>Pestaña <span class="highlight">Campañas de Email</span></li>
                    <li>Crea una campaña</li>
                    <li>Haz clic en <span class="highlight">👥 Seleccionar Destinatarios</span></li>
                    <li>Marca los clientes que quieres</li>
                    <li>Haz clic en <span class="highlight">🚀 Enviar Campaña a Seleccionados</span></li>
                    <li>¡Los emails se enviarán REALMENTE!</li>
                </ol>
                
                <div class="buttons-container">
                    <a href="crm-mailing-completo.php" class="btn btn-success">
                        🚀 Ir al CRM
                    </a>
                </div>
            </div>
        </div>
        
        <!-- CHECKLIST -->
        <div class="checklist">
            <h3>✅ Checklist: Marca cuando completes cada paso</h3>
            <label>
                <input type="checkbox" id="check1">
                Instalé el plugin WP Mail SMTP
            </label>
            <label>
                <input type="checkbox" id="check2">
                Activé el plugin
            </label>
            <label>
                <input type="checkbox" id="check3">
                Configuré "From Email" y "From Name"
            </label>
            <label>
                <input type="checkbox" id="check4">
                Seleccioné "Gmail" como mailer
            </label>
            <label>
                <input type="checkbox" id="check5">
                Conecté con mi cuenta de Google
            </label>
            <label>
                <input type="checkbox" id="check6">
                Guardé la configuración
            </label>
            <label>
                <input type="checkbox" id="check7">
                Probé enviando un email de prueba
            </label>
            <label>
                <input type="checkbox" id="check8">
                Recibí el email de prueba
            </label>
            <label>
                <input type="checkbox" id="check9">
                Probé enviar una campaña desde el CRM
            </label>
            <label>
                <input type="checkbox" id="check10">
                Los emails llegaron correctamente
            </label>
        </div>
        
        <div class="success-box">
            <h3>🎉 ¡Listo!</h3>
            <p>Ahora tu CRM puede enviar emails reales. Los clientes SÍ recibirán tus campañas.</p>
        </div>
        
        <div class="buttons-container">
            <a href="crm-mailing-completo.php" class="btn btn-success">
                🚀 Ir al CRM
            </a>
            <a href="TEST-ENVIO-EMAIL.php" class="btn btn-warning">
                📤 Probar Email
            </a>
            <a href="<?php echo admin_url('plugins.php'); ?>" class="btn">
                🔌 Ir a Plugins
            </a>
        </div>
    </div>
    
    <script>
        // Guardar estado de checkboxes en localStorage
        document.querySelectorAll('.checklist input[type="checkbox"]').forEach(checkbox => {
            // Cargar estado guardado
            const saved = localStorage.getItem(checkbox.id);
            if (saved === 'true') {
                checkbox.checked = true;
            }
            
            // Guardar cuando cambia
            checkbox.addEventListener('change', function() {
                localStorage.setItem(this.id, this.checked);
            });
        });
    </script>
</body>
</html>

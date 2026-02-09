<?php
/**
 * Panel de Mailing Completo - Sistema de Envío Masivo
 * Integrado con el sistema de gestión de cursos
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>📧 Panel de Mailing - Envío Masivo de Correos</h1>";

// Procesar envío de correos
if (isset($_POST['enviar_correos'])) {
    $asunto = sanitize_text_field($_POST['asunto']);
    $mensaje = wp_kses_post($_POST['mensaje']);
    $tipo_envio = sanitize_text_field($_POST['tipo_envio']);
    $lista_emails = sanitize_textarea_field($_POST['lista_emails']);
    
    $emails_enviados = 0;
    $emails_fallidos = 0;
    $errores = [];
    
    // Obtener lista de emails según el tipo
    $destinatarios = [];
    
    if ($tipo_envio === 'lista_personalizada') {
        $emails_raw = explode("\n", $lista_emails);
        foreach ($emails_raw as $email) {
            $email = trim($email);
            if (is_email($email)) {
                $destinatarios[] = $email;
            }
        }
    } elseif ($tipo_envio === 'usuarios_wordpress') {
        $users = get_users(['fields' => 'user_email']);
        $destinatarios = $users;
    } elseif ($tipo_envio === 'suscriptores_mailpoet') {
        // Intentar obtener suscriptores de MailPoet si está instalado
        if (class_exists('\MailPoet\API\API')) {
            try {
                $mailpoet_api = \MailPoet\API\API::MP('v1');
                $subscribers = $mailpoet_api->getSubscribers();
                foreach ($subscribers as $subscriber) {
                    if ($subscriber['status'] === 'subscribed') {
                        $destinatarios[] = $subscriber['email'];
                    }
                }
            } catch (Exception $e) {
                $errores[] = "Error MailPoet: " . $e->getMessage();
            }
        } else {
            $errores[] = "MailPoet no está instalado";
        }
    }
    
    // Enviar correos
    if (!empty($destinatarios)) {
        foreach ($destinatarios as $email) {
            $headers = array('Content-Type: text/html; charset=UTF-8');
            
            // Personalizar mensaje con datos del curso si es necesario
            $mensaje_personalizado = $mensaje;
            
            // Agregar información de cursos si se solicita
            if (strpos($mensaje, '[PROXIMOS_CURSOS]') !== false) {
                $cursos_html = "<h3>📚 Próximos Cursos Disponibles:</h3><ul>";
                for ($i = 1; $i <= 6; $i++) {
                    $course_name = get_option("course_{$i}_name");
                    if (!empty($course_name)) {
                        $course_date = get_option("course_{$i}_date");
                        $course_modality = get_option("course_{$i}_modality");
                        $cursos_html .= "<li><strong>$course_name</strong> - $course_date ($course_modality)</li>";
                    }
                }
                $cursos_html .= "</ul>";
                $mensaje_personalizado = str_replace('[PROXIMOS_CURSOS]', $cursos_html, $mensaje_personalizado);
            }
            
            if (wp_mail($email, $asunto, $mensaje_personalizado, $headers)) {
                $emails_enviados++;
            } else {
                $emails_fallidos++;
                $errores[] = "Error enviando a: $email";
            }
            
            // Pequeña pausa para evitar spam
            usleep(100000); // 0.1 segundos
        }
    }
    
    // Mostrar resultados
    echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h3>📊 Resultado del Envío:</h3>";
    echo "<p><strong>✅ Correos enviados:</strong> $emails_enviados</p>";
    echo "<p><strong>❌ Correos fallidos:</strong> $emails_fallidos</p>";
    echo "<p><strong>📧 Total destinatarios:</strong> " . count($destinatarios) . "</p>";
    if (!empty($errores)) {
        echo "<h4>⚠️ Errores encontrados:</h4>";
        echo "<ul>";
        foreach ($errores as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
    echo "</div>";
}

// Obtener estadísticas
$total_usuarios_wp = count(get_users());
$total_suscriptores_mailpoet = 0;

if (class_exists('\MailPoet\API\API')) {
    try {
        $mailpoet_api = \MailPoet\API\API::MP('v1');
        $subscribers = $mailpoet_api->getSubscribers();
        $total_suscriptores_mailpoet = count(array_filter($subscribers, function($s) {
            return $s['status'] === 'subscribed';
        }));
    } catch (Exception $e) {
        // MailPoet no disponible
    }
}
?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background: #f1f1f1;
}

.mailing-container {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin: 20px 0;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin: 30px 0;
}

.stat-card {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
    padding: 25px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3);
}

.stat-number {
    font-size: 36px;
    font-weight: 800;
    margin-bottom: 10px;
}

.stat-label {
    font-size: 14px;
    opacity: 0.9;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.form-section {
    background: #f8f9fa;
    padding: 25px;
    border-radius: 12px;
    margin: 20px 0;
    border-left: 5px solid #0066cc;
}

.form-section h3 {
    color: #0066cc;
    margin-top: 0;
    font-size: 20px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin: 20px 0;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-weight: 700;
    margin-bottom: 8px;
    color: #333;
    font-size: 16px;
}

.form-group input, .form-group select, .form-group textarea {
    padding: 14px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 16px;
    transition: all 0.3s ease;
    font-family: inherit;
}

.form-group input:focus, .form-group select:focus, .form-group textarea:focus {
    border-color: #0066cc;
    outline: none;
    box-shadow: 0 0 0 4px rgba(0, 102, 204, 0.1);
}

.form-group textarea {
    min-height: 120px;
    resize: vertical;
}

.email-editor {
    min-height: 200px;
    font-family: inherit;
}

.btn-send {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    padding: 18px 40px;
    border: none;
    border-radius: 12px;
    font-size: 18px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    margin: 20px 0;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.btn-send:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    background: linear-gradient(135deg, #20c997, #17a2b8);
}

.template-buttons {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin: 15px 0;
}

.btn-template {
    background: #6c757d;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-template:hover {
    background: #5a6268;
    transform: translateY(-1px);
}

.preview-section {
    background: #e9ecef;
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
}

.help-text {
    font-size: 13px;
    color: #666;
    margin-top: 5px;
    font-style: italic;
}

.warning-box {
    background: #fff3cd;
    color: #856404;
    padding: 15px;
    border-radius: 8px;
    margin: 15px 0;
    border-left: 4px solid #ffc107;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .template-buttons {
        flex-direction: column;
    }
}
</style>

<div class="mailing-container">
    <!-- Estadísticas -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_usuarios_wp; ?></div>
            <div class="stat-label">Usuarios WordPress</div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #28a745, #20c997);">
            <div class="stat-number"><?php echo $total_suscriptores_mailpoet; ?></div>
            <div class="stat-label">Suscriptores MailPoet</div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #dc3545, #c82333);">
            <div class="stat-number">
                <?php 
                $cursos_activos = 0;
                for ($i = 1; $i <= 6; $i++) {
                    if (!empty(get_option("course_{$i}_name"))) {
                        $cursos_activos++;
                    }
                }
                echo $cursos_activos;
                ?>
            </div>
            <div class="stat-label">Cursos Activos</div>
        </div>
    </div>

    <!-- Formulario de envío -->
    <form method="post">
        <div class="form-section">
            <h3>📧 Configuración del Correo</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Asunto del Correo:</label>
                    <input type="text" name="asunto" required placeholder="Ej: Nuevos cursos disponibles - Mongruas Formación">
                </div>
                <div class="form-group">
                    <label>Tipo de Envío:</label>
                    <select name="tipo_envio" onchange="toggleEmailList(this.value)" required>
                        <option value="">Seleccionar...</option>
                        <option value="usuarios_wordpress">Usuarios de WordPress (<?php echo $total_usuarios_wp; ?>)</option>
                        <?php if ($total_suscriptores_mailpoet > 0): ?>
                        <option value="suscriptores_mailpoet">Suscriptores MailPoet (<?php echo $total_suscriptores_mailpoet; ?>)</option>
                        <?php endif; ?>
                        <option value="lista_personalizada">Lista Personalizada</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group" id="lista-emails" style="display: none;">
                <label>Lista de Emails (uno por línea):</label>
                <textarea name="lista_emails" placeholder="email1@ejemplo.com&#10;email2@ejemplo.com&#10;email3@ejemplo.com"></textarea>
                <div class="help-text">Introduce un email por línea. Se validarán automáticamente.</div>
            </div>
        </div>

        <div class="form-section">
            <h3>✍️ Contenido del Mensaje</h3>
            
            <div class="template-buttons">
                <button type="button" class="btn-template" onclick="insertTemplate('nuevos_cursos')">📚 Nuevos Cursos</button>
                <button type="button" class="btn-template" onclick="insertTemplate('recordatorio')">⏰ Recordatorio</button>
                <button type="button" class="btn-template" onclick="insertTemplate('promocion')">🎯 Promoción</button>
                <button type="button" class="btn-template" onclick="insertTemplate('newsletter')">📰 Newsletter</button>
            </div>
            
            <div class="form-group">
                <label>Mensaje del Correo:</label>
                <textarea name="mensaje" class="email-editor" required placeholder="Escribe tu mensaje aquí..."></textarea>
                <div class="help-text">
                    <strong>Variables disponibles:</strong><br>
                    • <code>[PROXIMOS_CURSOS]</code> - Lista automática de próximos cursos<br>
                    • Puedes usar HTML básico para formato
                </div>
            </div>
        </div>

        <div class="warning-box">
            <strong>⚠️ Importante:</strong> El envío masivo puede tardar varios minutos. Asegúrate de que el asunto y mensaje sean correctos antes de enviar.
        </div>

        <div style="text-align: center;">
            <button type="submit" name="enviar_correos" class="btn-send" onclick="return confirm('¿Estás seguro de enviar este correo masivo?')">
                📧 Enviar Correos Masivos
            </button>
        </div>
    </form>
</div>

<div style="text-align: center; margin: 30px 0;">
    <a href="<?php echo home_url('/panel-gestion-unificado.php'); ?>" style="background: #0066cc; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 5px; font-weight: 600;">🏠 Volver al Gestor</a>
    <a href="<?php echo home_url('/gestionar-suscriptores-mailpoet.php'); ?>" style="background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 5px; font-weight: 600;">👥 Gestionar Suscriptores</a>
</div>

<div style="background: #d1ecf1; color: #0c5460; padding: 25px; border-radius: 12px; margin: 30px 0;">
    <h3>📋 Instrucciones del Panel de Mailing:</h3>
    <ol>
        <li><strong>Selecciona el tipo de envío:</strong> Usuarios WordPress, suscriptores MailPoet o lista personalizada</li>
        <li><strong>Escribe el asunto:</strong> Hazlo atractivo y claro</li>
        <li><strong>Usa las plantillas:</strong> Haz clic en los botones para insertar contenido predefinido</li>
        <li><strong>Personaliza el mensaje:</strong> Usa [PROXIMOS_CURSOS] para incluir la lista automática</li>
        <li><strong>Revisa antes de enviar:</strong> Una vez enviado no se puede deshacer</li>
    </ol>
    
    <h4>🎯 Consejos para mejores resultados:</h4>
    <ul>
        <li>Envía correos en horarios de oficina (9:00-18:00)</li>
        <li>Personaliza el asunto según el contenido</li>
        <li>Incluye siempre información de contacto</li>
        <li>No envíes más de 1-2 correos por semana</li>
    </ul>
</div>

<script>
function toggleEmailList(tipo) {
    const listaEmails = document.getElementById('lista-emails');
    if (tipo === 'lista_personalizada') {
        listaEmails.style.display = 'block';
    } else {
        listaEmails.style.display = 'none';
    }
}

function insertTemplate(tipo) {
    const textarea = document.querySelector('textarea[name="mensaje"]');
    let template = '';
    
    switch(tipo) {
        case 'nuevos_cursos':
            template = `<h2>🎓 ¡Nuevos Cursos Disponibles!</h2>

<p>Estimado/a estudiante,</p>

<p>Nos complace informarte sobre nuestros próximos cursos de formación profesional:</p>

[PROXIMOS_CURSOS]

<p>📞 <strong>¿Necesitas más información?</strong><br>
Contacta con nosotros:</p>
<ul>
<li>Teléfono: [TU_TELEFONO]</li>
<li>Email: [TU_EMAIL]</li>
<li>Web: <a href="${window.location.origin}">${window.location.origin}</a></li>
</ul>

<p>¡No pierdas la oportunidad de impulsar tu carrera profesional!</p>

<p>Saludos cordiales,<br>
<strong>Equipo Mongruas Formación</strong></p>`;
            break;
            
        case 'recordatorio':
            template = `<h2>⏰ Recordatorio - Plazas Limitadas</h2>

<p>Hola,</p>

<p>Te recordamos que aún tienes tiempo para inscribirte en nuestros próximos cursos:</p>

[PROXIMOS_CURSOS]

<p><strong>⚠️ ¡Las plazas son limitadas!</strong></p>

<p>No dejes pasar esta oportunidad de formarte con los mejores profesionales.</p>

<p>Para más información o reservar tu plaza:</p>
<p>📧 Responde a este correo<br>
📞 Llámanos al [TU_TELEFONO]</p>

<p>¡Te esperamos!</p>`;
            break;
            
        case 'promocion':
            template = `<h2>🎯 ¡Oferta Especial en Formación!</h2>

<p>¡Hola!</p>

<p>Por tiempo limitado, ofrecemos condiciones especiales en nuestros cursos de formación profesional.</p>

[PROXIMOS_CURSOS]

<p><strong>🎁 Beneficios de esta promoción:</strong></p>
<ul>
<li>✅ Formación bonificada disponible</li>
<li>✅ Certificados oficiales</li>
<li>✅ Profesores especializados</li>
<li>✅ Campus virtual 24/7</li>
</ul>

<p><strong>📅 Oferta válida hasta: [FECHA_LIMITE]</strong></p>

<p>¡Reserva tu plaza ahora!</p>`;
            break;
            
        case 'newsletter':
            template = `<h2>📰 Newsletter - Mongruas Formación</h2>

<p>¡Hola!</p>

<p>Te mantenemos informado sobre las últimas novedades en formación profesional.</p>

<h3>📚 Próximos Cursos</h3>
[PROXIMOS_CURSOS]

<h3>📈 Novedades del Sector</h3>
<p>[AQUI_PUEDES_AGREGAR_NOTICIAS_DEL_SECTOR]</p>

<h3>💡 Consejo del Mes</h3>
<p>[AQUI_PUEDES_AGREGAR_UN_CONSEJO_PROFESIONAL]</p>

<p>¿Tienes alguna pregunta? ¡Contáctanos!</p>

<p>Hasta la próxima,<br>
<strong>Equipo Mongruas Formación</strong></p>`;
            break;
    }
    
    textarea.value = template;
    textarea.focus();
}

// Auto-resize textarea
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.querySelector('.email-editor');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    }
});
</script>
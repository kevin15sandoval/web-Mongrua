<?php
/**
 * Plantillas de Email para CRM
 * Sistema de plantillas prediseñadas para campañas de marketing
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>📧 Plantillas de Email - CRM</h1>";

// Plantillas predefinidas
$plantillas = [
    'bienvenida' => [
        'nombre' => '👋 Bienvenida Nuevo Cliente',
        'asunto' => '¡Bienvenido/a a Mongruas Formación, [NOMBRE]!',
        'contenido' => '
        <div style="max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif; background: #f8f9fa; padding: 20px;">
            <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div style="text-align: center; margin-bottom: 30px;">
                    <h1 style="color: #0066cc; font-size: 28px; margin: 0;">¡Bienvenido/a a Mongruas Formación!</h1>
                </div>
                
                <p style="font-size: 16px; line-height: 1.6; color: #333;">Estimado/a <strong>[NOMBRE]</strong>,</p>
                
                <p style="font-size: 16px; line-height: 1.6; color: #333;">
                    Nos complace darte la bienvenida a nuestra comunidad de profesionales en formación. 
                    En Mongruas Formación nos especializamos en cursos de alta calidad que impulsan tu carrera profesional.
                </p>
                
                <div style="background: #e7f3ff; padding: 20px; border-radius: 10px; margin: 20px 0;">
                    <h3 style="color: #0066cc; margin-top: 0;">🎓 ¿Qué puedes esperar de nosotros?</h3>
                    <ul style="color: #333; line-height: 1.8;">
                        <li>✅ Cursos certificados y reconocidos oficialmente</li>
                        <li>✅ Profesores especializados con experiencia real</li>
                        <li>✅ Formación bonificada disponible para empresas</li>
                        <li>✅ Campus virtual disponible 24/7</li>
                        <li>✅ Soporte personalizado durante todo el proceso</li>
                    </ul>
                </div>
                
                <div style="text-align: center; margin: 30px 0;">
                    <a href="[URL_CURSOS]" style="background: linear-gradient(135deg, #0066cc, #0052a3); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-block;">
                        📚 Ver Nuestros Cursos
                    </a>
                </div>
                
                <p style="font-size: 16px; line-height: 1.6; color: #333;">
                    Si tienes alguna pregunta o necesitas más información, no dudes en contactarnos. 
                    Estamos aquí para ayudarte a alcanzar tus objetivos profesionales.
                </p>
                
                <div style="border-top: 2px solid #e0e0e0; padding-top: 20px; margin-top: 30px;">
                    <p style="color: #666; font-size: 14px; margin: 0;">
                        <strong>Equipo Mongruas Formación</strong><br>
                        📞 Teléfono: [TELEFONO]<br>
                        📧 Email: [EMAIL_CONTACTO]<br>
                        🌐 Web: [URL_WEB]
                    </p>
                </div>
            </div>
        </div>'
    ],
    
    'nuevos_cursos' => [
        'nombre' => '🎓 Nuevos Cursos Disponibles',
        'asunto' => '¡Nuevos cursos que te pueden interesar, [NOMBRE]!',
        'contenido' => '
        <div style="max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif; background: #f8f9fa; padding: 20px;">
            <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div style="text-align: center; margin-bottom: 30px;">
                    <h1 style="color: #0066cc; font-size: 28px; margin: 0;">🎓 Nuevos Cursos Disponibles</h1>
                    <p style="color: #666; font-size: 16px;">Formación profesional de calidad</p>
                </div>
                
                <p style="font-size: 16px; line-height: 1.6; color: #333;">Hola <strong>[NOMBRE]</strong>,</p>
                
                <p style="font-size: 16px; line-height: 1.6; color: #333;">
                    Nos complace informarte sobre nuestros próximos cursos de formación profesional. 
                    Hemos seleccionado estos cursos especialmente para profesionales como tú.
                </p>
                
                <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0;">
                    <h3 style="color: #0066cc; margin-top: 0;">📚 Próximos Cursos:</h3>
                    
                    <div style="border: 2px solid #e0e0e0; border-radius: 8px; padding: 15px; margin: 15px 0; background: white;">
                        <h4 style="color: #333; margin: 0 0 10px 0;">⚡ Instalaciones Eléctricas de Baja Tensión</h4>
                        <p style="color: #666; margin: 5px 0; font-size: 14px;">📅 Inicio: Enero 2025 | 🏢 Modalidad: Presencial | 👥 Plazas: 15</p>
                        <p style="color: #333; font-size: 14px; line-height: 1.4;">Certificado oficial ELEE0109. Formación completa para profesionales del sector eléctrico.</p>
                    </div>
                    
                    <div style="border: 2px solid #e0e0e0; border-radius: 8px; padding: 15px; margin: 15px 0; background: white;">
                        <h4 style="color: #333; margin: 0 0 10px 0;">🏠 Sistemas Domóticos e Inmóticos</h4>
                        <p style="color: #666; margin: 5px 0; font-size: 14px;">📅 Inicio: Febrero 2025 | 🏢 Modalidad: Presencial | 👥 Plazas: 12</p>
                        <p style="color: #333; font-size: 14px; line-height: 1.4;">Especialización en automatización de edificios y sistemas inteligentes.</p>
                    </div>
                    
                    <div style="border: 2px solid #e0e0e0; border-radius: 8px; padding: 15px; margin: 15px 0; background: white;">
                        <h4 style="color: #333; margin: 0 0 10px 0;">🐛 Control de Plagas</h4>
                        <p style="color: #666; margin: 5px 0; font-size: 14px;">📅 Inicio: Marzo 2025 | 🏢 Modalidad: Presencial | 👥 Plazas: 10</p>
                        <p style="color: #333; font-size: 14px; line-height: 1.4;">Certificado SEAG0110. Formación profesional en control y prevención de plagas.</p>
                    </div>
                </div>
                
                <div style="background: #e7f3ff; padding: 20px; border-radius: 10px; margin: 20px 0;">
                    <h3 style="color: #0066cc; margin-top: 0;">🎁 Ventajas Exclusivas:</h3>
                    <ul style="color: #333; line-height: 1.8; margin: 0; padding-left: 20px;">
                        <li>✅ Formación bonificada disponible</li>
                        <li>✅ Certificados oficiales reconocidos</li>
                        <li>✅ Profesores con experiencia real en el sector</li>
                        <li>✅ Grupos reducidos para atención personalizada</li>
                        <li>✅ Bolsa de empleo exclusiva para alumnos</li>
                    </ul>
                </div>
                
                <div style="text-align: center; margin: 30px 0;">
                    <a href="[URL_CONTACTO]" style="background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-block; margin: 5px;">
                        📞 Solicitar Información
                    </a>
                    <a href="[URL_CURSOS]" style="background: linear-gradient(135deg, #0066cc, #0052a3); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-block; margin: 5px;">
                        📚 Ver Todos los Cursos
                    </a>
                </div>
                
                <p style="font-size: 14px; line-height: 1.6; color: #666; text-align: center;">
                    ⚠️ <strong>¡Las plazas son limitadas!</strong> No dejes pasar esta oportunidad de impulsar tu carrera profesional.
                </p>
                
                <div style="border-top: 2px solid #e0e0e0; padding-top: 20px; margin-top: 30px;">
                    <p style="color: #666; font-size: 14px; margin: 0; text-align: center;">
                        <strong>Mongruas Formación</strong><br>
                        📞 [TELEFONO] | 📧 [EMAIL_CONTACTO] | 🌐 [URL_WEB]
                    </p>
                </div>
            </div>
        </div>'
    ],
    
    'recordatorio' => [
        'nombre' => '⏰ Recordatorio Plazas Limitadas',
        'asunto' => '⏰ Últimas plazas disponibles - No te quedes sin la tuya',
        'contenido' => '
        <div style="max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif; background: #f8f9fa; padding: 20px;">
            <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div style="text-align: center; margin-bottom: 30px;">
                    <h1 style="color: #dc3545; font-size: 28px; margin: 0;">⏰ ¡Últimas Plazas Disponibles!</h1>
                    <p style="color: #666; font-size: 16px;">No te quedes sin tu oportunidad</p>
                </div>
                
                <p style="font-size: 16px; line-height: 1.6; color: #333;">Hola <strong>[NOMBRE]</strong>,</p>
                
                <div style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 20px; margin: 20px 0;">
                    <p style="font-size: 16px; line-height: 1.6; color: #856404; margin: 0;">
                        <strong>⚠️ AVISO IMPORTANTE:</strong> Quedan muy pocas plazas disponibles en nuestros próximos cursos. 
                        Si estás interesado/a, te recomendamos que reserves tu plaza cuanto antes.
                    </p>
                </div>
                
                <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0;">
                    <h3 style="color: #dc3545; margin-top: 0;">🔥 Cursos con Plazas Limitadas:</h3>
                    
                    <div style="border: 2px solid #dc3545; border-radius: 8px; padding: 15px; margin: 15px 0; background: white;">
                        <h4 style="color: #333; margin: 0 0 10px 0;">⚡ Instalaciones Eléctricas</h4>
                        <p style="color: #dc3545; margin: 5px 0; font-size: 14px; font-weight: 600;">⚠️ Solo quedan 3 plazas de 15</p>
                        <p style="color: #333; font-size: 14px;">Certificado oficial ELEE0109 | Inicio: Enero 2025</p>
                    </div>
                    
                    <div style="border: 2px solid #ffc107; border-radius: 8px; padding: 15px; margin: 15px 0; background: white;">
                        <h4 style="color: #333; margin: 0 0 10px 0;">🏠 Sistemas Domóticos</h4>
                        <p style="color: #856404; margin: 5px 0; font-size: 14px; font-weight: 600;">⚠️ Solo quedan 5 plazas de 12</p>
                        <p style="color: #333; font-size: 14px;">Automatización de edificios | Inicio: Febrero 2025</p>
                    </div>
                </div>
                
                <div style="background: #d4edda; padding: 20px; border-radius: 10px; margin: 20px 0;">
                    <h3 style="color: #155724; margin-top: 0;">🎯 ¿Por qué elegir Mongruas Formación?</h3>
                    <ul style="color: #155724; line-height: 1.8; margin: 0; padding-left: 20px;">
                        <li>✅ <strong>Certificados oficiales</strong> reconocidos en toda España</li>
                        <li>✅ <strong>Formación bonificada</strong> para empresas</li>
                        <li>✅ <strong>Profesores expertos</strong> con experiencia real</li>
                        <li>✅ <strong>Grupos reducidos</strong> para mejor aprendizaje</li>
                        <li>✅ <strong>Bolsa de empleo</strong> exclusiva para alumnos</li>
                    </ul>
                </div>
                
                <div style="text-align: center; margin: 30px 0;">
                    <a href="[URL_CONTACTO]" style="background: linear-gradient(135deg, #dc3545, #c82333); color: white; padding: 18px 35px; text-decoration: none; border-radius: 8px; font-weight: 700; display: inline-block; font-size: 16px;">
                        🚀 RESERVAR PLAZA AHORA
                    </a>
                </div>
                
                <div style="background: #f8d7da; border-left: 4px solid #dc3545; padding: 15px; margin: 20px 0;">
                    <p style="color: #721c24; margin: 0; font-size: 14px; text-align: center;">
                        <strong>⏰ TIEMPO LIMITADO:</strong> Una vez completadas las plazas, tendrás que esperar a la siguiente convocatoria.
                    </p>
                </div>
                
                <p style="font-size: 16px; line-height: 1.6; color: #333;">
                    No dejes pasar esta oportunidad de impulsar tu carrera profesional. 
                    Contacta con nosotros hoy mismo para reservar tu plaza.
                </p>
                
                <div style="border-top: 2px solid #e0e0e0; padding-top: 20px; margin-top: 30px;">
                    <p style="color: #666; font-size: 14px; margin: 0; text-align: center;">
                        <strong>Mongruas Formación</strong><br>
                        📞 [TELEFONO] | 📧 [EMAIL_CONTACTO] | 🌐 [URL_WEB]
                    </p>
                </div>
            </div>
        </div>'
    ],
    
    'promocion' => [
        'nombre' => '🎯 Promoción Especial',
        'asunto' => '🎁 Oferta especial solo para ti, [NOMBRE]',
        'contenido' => '
        <div style="max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif; background: #f8f9fa; padding: 20px;">
            <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div style="text-align: center; margin-bottom: 30px;">
                    <h1 style="color: #ffc107; font-size: 28px; margin: 0;">🎁 ¡Oferta Especial!</h1>
                    <p style="color: #666; font-size: 16px;">Solo para clientes como tú</p>
                </div>
                
                <p style="font-size: 16px; line-height: 1.6; color: #333;">Estimado/a <strong>[NOMBRE]</strong>,</p>
                
                <p style="font-size: 16px; line-height: 1.6; color: #333;">
                    Como cliente valorado de Mongruas Formación, queremos ofrecerte condiciones especiales 
                    en nuestros próximos cursos de formación profesional.
                </p>
                
                <div style="background: linear-gradient(135deg, #ffc107, #fd7e14); padding: 25px; border-radius: 15px; margin: 25px 0; text-align: center;">
                    <h2 style="color: white; margin: 0 0 15px 0; font-size: 24px;">🎯 PROMOCIÓN LIMITADA</h2>
                    <p style="color: white; font-size: 18px; margin: 0; font-weight: 600;">
                        Condiciones especiales en formación bonificada
                    </p>
                </div>
                
                <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0;">
                    <h3 style="color: #0066cc; margin-top: 0;">🎁 Beneficios Exclusivos:</h3>
                    <ul style="color: #333; line-height: 1.8; margin: 0; padding-left: 20px;">
                        <li>✅ <strong>Formación 100% bonificada</strong> para empresas</li>
                        <li>✅ <strong>Descuentos especiales</strong> para particulares</li>
                        <li>✅ <strong>Material didáctico incluido</strong> sin coste adicional</li>
                        <li>✅ <strong>Certificado oficial</strong> reconocido</li>
                        <li>✅ <strong>Acceso prioritario</strong> a nuevos cursos</li>
                        <li>✅ <strong>Soporte personalizado</strong> durante todo el proceso</li>
                    </ul>
                </div>
                
                <div style="background: #e7f3ff; padding: 20px; border-radius: 10px; margin: 20px 0;">
                    <h3 style="color: #0066cc; margin-top: 0;">📚 Cursos Incluidos en la Promoción:</h3>
                    
                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                        <span style="background: #0066cc; color: white; padding: 8px 15px; border-radius: 20px; font-size: 14px; font-weight: 600;">⚡ Instalaciones Eléctricas</span>
                        <span style="background: #28a745; color: white; padding: 8px 15px; border-radius: 20px; font-size: 14px; font-weight: 600;">🏠 Domótica</span>
                        <span style="background: #dc3545; color: white; padding: 8px 15px; border-radius: 20px; font-size: 14px; font-weight: 600;">🐛 Control de Plagas</span>
                        <span style="background: #ffc107; color: #333; padding: 8px 15px; border-radius: 20px; font-size: 14px; font-weight: 600;">🔋 Energías Renovables</span>
                        <span style="background: #6f42c1; color: white; padding: 8px 15px; border-radius: 20px; font-size: 14px; font-weight: 600;">🛡️ PRL</span>
                    </div>
                </div>
                
                <div style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 20px; margin: 20px 0;">
                    <p style="color: #856404; margin: 0; font-size: 16px; text-align: center;">
                        <strong>⏰ OFERTA VÁLIDA HASTA:</strong> 31 de Enero de 2025
                    </p>
                </div>
                
                <div style="text-align: center; margin: 30px 0;">
                    <a href="[URL_CONTACTO]" style="background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 18px 35px; text-decoration: none; border-radius: 8px; font-weight: 700; display: inline-block; font-size: 16px; margin: 5px;">
                        🎯 APROVECHAR OFERTA
                    </a>
                    <a href="[URL_CURSOS]" style="background: linear-gradient(135deg, #0066cc, #0052a3); color: white; padding: 18px 35px; text-decoration: none; border-radius: 8px; font-weight: 700; display: inline-block; font-size: 16px; margin: 5px;">
                        📚 VER CURSOS
                    </a>
                </div>
                
                <p style="font-size: 16px; line-height: 1.6; color: #333;">
                    Esta oferta es exclusiva y por tiempo limitado. No dejes pasar la oportunidad 
                    de formarte con las mejores condiciones del mercado.
                </p>
                
                <div style="border-top: 2px solid #e0e0e0; padding-top: 20px; margin-top: 30px;">
                    <p style="color: #666; font-size: 14px; margin: 0; text-align: center;">
                        <strong>Mongruas Formación</strong><br>
                        📞 [TELEFONO] | 📧 [EMAIL_CONTACTO] | 🌐 [URL_WEB]
                    </p>
                </div>
            </div>
        </div>'
    ],
    
    'seguimiento' => [
        'nombre' => '📞 Seguimiento Personalizado',
        'asunto' => 'Seguimiento de tu interés en formación - [NOMBRE]',
        'contenido' => '
        <div style="max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif; background: #f8f9fa; padding: 20px;">
            <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div style="text-align: center; margin-bottom: 30px;">
                    <h1 style="color: #0066cc; font-size: 28px; margin: 0;">📞 Seguimiento Personalizado</h1>
                    <p style="color: #666; font-size: 16px;">Estamos aquí para ayudarte</p>
                </div>
                
                <p style="font-size: 16px; line-height: 1.6; color: #333;">Hola <strong>[NOMBRE]</strong>,</p>
                
                <p style="font-size: 16px; line-height: 1.6; color: #333;">
                    Hace unos días mostraste interés en nuestros cursos de formación profesional. 
                    Queremos asegurarnos de que tienes toda la información que necesitas para tomar la mejor decisión.
                </p>
                
                <div style="background: #e7f3ff; padding: 20px; border-radius: 10px; margin: 20px 0;">
                    <h3 style="color: #0066cc; margin-top: 0;">🤝 ¿En qué podemos ayudarte?</h3>
                    <ul style="color: #333; line-height: 1.8; margin: 0; padding-left: 20px;">
                        <li>❓ Resolver dudas sobre los cursos</li>
                        <li>📋 Información sobre requisitos y certificaciones</li>
                        <li>💰 Detalles sobre formación bonificada</li>
                        <li>📅 Fechas de inicio y horarios</li>
                        <li>🏢 Modalidades disponibles (presencial/online)</li>
                        <li>📞 Asesoramiento personalizado gratuito</li>
                    </ul>
                </div>
                
                <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0;">
                    <h3 style="color: #28a745; margin-top: 0;">✨ Recordatorio de Beneficios:</h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div style="text-align: center;">
                            <div style="font-size: 30px; margin-bottom: 10px;">🎓</div>
                            <p style="margin: 0; font-size: 14px; color: #333;"><strong>Certificados Oficiales</strong></p>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 30px; margin-bottom: 10px;">💰</div>
                            <p style="margin: 0; font-size: 14px; color: #333;"><strong>Formación Bonificada</strong></p>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 30px; margin-bottom: 10px;">👨‍🏫</div>
                            <p style="margin: 0; font-size: 14px; color: #333;"><strong>Profesores Expertos</strong></p>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 30px; margin-bottom: 10px;">🎯</div>
                            <p style="margin: 0; font-size: 14px; color: #333;"><strong>Grupos Reducidos</strong></p>
                        </div>
                    </div>
                </div>
                
                <div style="text-align: center; margin: 30px 0;">
                    <a href="tel:[TELEFONO]" style="background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-block; margin: 5px;">
                        📞 Llamar Ahora
                    </a>
                    <a href="mailto:[EMAIL_CONTACTO]" style="background: linear-gradient(135deg, #0066cc, #0052a3); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-block; margin: 5px;">
                        📧 Enviar Email
                    </a>
                </div>
                
                <div style="background: #d1ecf1; padding: 20px; border-radius: 10px; margin: 20px 0;">
                    <h4 style="color: #0c5460; margin-top: 0;">💬 Testimonios de Nuestros Alumnos:</h4>
                    <blockquote style="border-left: 4px solid #17a2b8; padding-left: 15px; margin: 15px 0; font-style: italic; color: #0c5460;">
                        "Excelente formación, profesores muy preparados y certificado oficial. 
                        Me ayudó mucho en mi carrera profesional." - María G.
                    </blockquote>
                    <blockquote style="border-left: 4px solid #17a2b8; padding-left: 15px; margin: 15px 0; font-style: italic; color: #0c5460;">
                        "La formación bonificada fue perfecta para nuestra empresa. 
                        Muy recomendable." - Juan P.
                    </blockquote>
                </div>
                
                <p style="font-size: 16px; line-height: 1.6; color: #333;">
                    Estamos aquí para resolver todas tus dudas sin compromiso. 
                    No dudes en contactarnos cuando te venga mejor.
                </p>
                
                <div style="border-top: 2px solid #e0e0e0; padding-top: 20px; margin-top: 30px;">
                    <p style="color: #666; font-size: 14px; margin: 0; text-align: center;">
                        <strong>Mongruas Formación</strong><br>
                        📞 [TELEFONO] | 📧 [EMAIL_CONTACTO] | 🌐 [URL_WEB]
                    </p>
                </div>
            </div>
        </div>'
    ]
];

// Procesar selección de plantilla
$plantilla_seleccionada = '';
if (isset($_GET['plantilla']) && isset($plantillas[$_GET['plantilla']])) {
    $plantilla_seleccionada = $_GET['plantilla'];
}
?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background: #f1f3f4;
}

.plantillas-container {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin: 20px 0;
}

.plantillas-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin: 30px 0;
}

.plantilla-card {
    background: #f8f9fa;
    padding: 25px;
    border-radius: 12px;
    border: 2px solid #e0e0e0;
    transition: all 0.3s ease;
    cursor: pointer;
}

.plantilla-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    border-color: #0066cc;
}

.plantilla-card.selected {
    border-color: #0066cc;
    background: #e7f3ff;
}

.plantilla-title {
    font-size: 18px;
    font-weight: 700;
    color: #333;
    margin-bottom: 10px;
}

.plantilla-description {
    font-size: 14px;
    color: #666;
    line-height: 1.5;
    margin-bottom: 15px;
}

.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    text-align: center;
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

.preview-container {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 12px;
    margin: 20px 0;
    border: 2px solid #e0e0e0;
}

.preview-iframe {
    width: 100%;
    height: 600px;
    border: none;
    border-radius: 8px;
    background: white;
}

.variables-info {
    background: #e7f3ff;
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
}

.variables-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 10px;
    margin: 15px 0;
}

.variable-item {
    background: white;
    padding: 10px;
    border-radius: 6px;
    font-family: monospace;
    font-size: 14px;
    border: 1px solid #ccc;
}
</style>

<div class="plantillas-container">
    <h2>📧 Selecciona una Plantilla de Email</h2>
    <p>Elige una plantilla prediseñada para crear tu campaña de email marketing:</p>
    
    <div class="plantillas-grid">
        <?php foreach ($plantillas as $key => $plantilla): ?>
        <div class="plantilla-card <?php echo $plantilla_seleccionada === $key ? 'selected' : ''; ?>" 
             onclick="seleccionarPlantilla('<?php echo $key; ?>')">
            <div class="plantilla-title"><?php echo $plantilla['nombre']; ?></div>
            <div class="plantilla-description">
                <strong>Asunto:</strong> <?php echo esc_html($plantilla['asunto']); ?>
            </div>
            <a href="?plantilla=<?php echo $key; ?>" class="btn btn-primary">👁️ Ver Plantilla</a>
        </div>
        <?php endforeach; ?>
    </div>
    
    <?php if ($plantilla_seleccionada): ?>
    <div class="preview-container">
        <h3>👁️ Vista Previa: <?php echo $plantillas[$plantilla_seleccionada]['nombre']; ?></h3>
        
        <div class="variables-info">
            <h4>🔧 Variables Disponibles:</h4>
            <p>Estas variables se reemplazarán automáticamente con los datos reales:</p>
            <div class="variables-grid">
                <div class="variable-item">[NOMBRE] - Nombre del cliente</div>
                <div class="variable-item">[EMPRESA] - Empresa del cliente</div>
                <div class="variable-item">[TELEFONO] - Tu teléfono</div>
                <div class="variable-item">[EMAIL_CONTACTO] - Tu email</div>
                <div class="variable-item">[URL_WEB] - URL de tu web</div>
                <div class="variable-item">[URL_CURSOS] - URL página cursos</div>
                <div class="variable-item">[URL_CONTACTO] - URL contacto</div>
            </div>
        </div>
        
        <iframe class="preview-iframe" srcdoc="<?php echo htmlspecialchars($plantillas[$plantilla_seleccionada]['contenido']); ?>"></iframe>
        
        <div style="text-align: center; margin: 20px 0;">
            <button onclick="copiarPlantilla()" class="btn btn-success">📋 Copiar HTML de la Plantilla</button>
            <a href="/crm-mailing-completo.php" class="btn btn-primary">🚀 Usar en Campaña</a>
        </div>
    </div>
    
    <textarea id="plantilla-html" style="display: none;"><?php echo htmlspecialchars($plantillas[$plantilla_seleccionada]['contenido']); ?></textarea>
    <?php endif; ?>
</div>

<div style="text-align: center; margin: 30px 0;">
    <a href="/crm-mailing-completo.php" class="btn btn-primary">🎯 Volver al CRM</a>
    <a href="/panel-mailing-completo.php" class="btn btn-success">📧 Panel Mailing Simple</a>
</div>

<script>
function seleccionarPlantilla(key) {
    window.location.href = '?plantilla=' + key;
}

function copiarPlantilla() {
    const textarea = document.getElementById('plantilla-html');
    textarea.style.display = 'block';
    textarea.select();
    document.execCommand('copy');
    textarea.style.display = 'none';
    
    alert('✅ HTML de la plantilla copiado al portapapeles!\n\nPuedes pegarlo en el campo "Contenido del Email" de tu campaña.');
}
</script>
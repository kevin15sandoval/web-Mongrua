<?php
/**
 * Procesador de Contenido desde /doc
 * Crea campañas automáticas basadas en la información de los archivos
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>📄 Procesador de Contenido desde /doc</h1>";

global $wpdb;
$table_campanas = $wpdb->prefix . 'mongruas_campanas';

// Verificar que la tabla existe
$tabla_existe = $wpdb->get_var("SHOW TABLES LIKE '$table_campanas'");
if (!$tabla_existe) {
    echo "<div style='background: #f8d7da; padding: 20px; border-radius: 8px; margin: 20px 0; color: #721c24;'>";
    echo "<h3>❌ Error: Tabla de campañas no existe</h3>";
    echo "<p>Primero debes acceder al CRM para crear las tablas: <a href='/crm-mailing-completo.php'>Crear tablas del CRM</a></p>";
    echo "</div>";
    exit;
}

$mensaje_resultado = '';

// Procesar creación de campañas
if (isset($_POST['accion']) && $_POST['accion'] === 'crear_campanas') {
    
    echo "<h2>🔄 Creando Campañas Automáticas...</h2>";
    
    // 1. CAMPAÑA SOBRE CERTIFICADOS DE PROFESIONALIDAD
    $contenido_certificados = '
    <div style="max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif; background: #f8f9fa; padding: 20px;">
        <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="color: #0066cc; font-size: 28px; margin: 0;">🎓 Certificados de Profesionalidad Oficiales</h1>
                <p style="color: #666; font-size: 16px;">Formación acreditada por el SEPE</p>
            </div>
            
            <p style="font-size: 16px; line-height: 1.6; color: #333;">Estimado/a <strong>[NOMBRE]</strong>,</p>
            
            <p style="font-size: 16px; line-height: 1.6; color: #333;">
                Como empresa acreditada en el Registro Estatal de Entidades de Formación de Castilla-La Mancha, 
                te informamos sobre nuestros certificados de profesionalidad oficiales.
            </p>
            
            <div style="background: #e7f3ff; padding: 20px; border-radius: 10px; margin: 20px 0;">
                <h3 style="color: #0066cc; margin-top: 0;">📋 Certificados Disponibles:</h3>
                
                <div style="border: 2px solid #0066cc; border-radius: 8px; padding: 15px; margin: 15px 0; background: white;">
                    <h4 style="color: #333; margin: 0 0 10px 0;">⚡ ELEE0109 - Montaje y Mantenimiento de Instalaciones Eléctricas de Baja Tensión</h4>
                    <p style="color: #666; margin: 5px 0; font-size: 14px;">📅 RD 683/2011, de 13 de mayo</p>
                    <p style="color: #333; font-size: 14px;">Certificado oficial para profesionales del sector eléctrico</p>
                </div>
                
                <div style="border: 2px solid #28a745; border-radius: 8px; padding: 15px; margin: 15px 0; background: white;">
                    <h4 style="color: #333; margin: 0 0 10px 0;">🏠 ELEM0111 - Montaje y Mantenimiento de Sistemas Domóticos e Inmóticos</h4>
                    <p style="color: #333; font-size: 14px;">Especialización en automatización de edificios y sistemas inteligentes</p>
                </div>
                
                <div style="border: 2px solid #dc3545; border-radius: 8px; padding: 15px; margin: 15px 0; background: white;">
                    <h4 style="color: #333; margin: 0 0 10px 0;">🐛 SEAG0110 - Servicios para el Control de Plagas</h4>
                    <p style="color: #333; font-size: 14px;">Formación oficial para aplicadores de productos biocidas</p>
                </div>
            </div>
            
            <div style="background: #d4edda; padding: 20px; border-radius: 10px; margin: 20px 0;">
                <h3 style="color: #155724; margin-top: 0;">✅ Ventajas de Nuestros Certificados:</h3>
                <ul style="color: #155724; line-height: 1.8;">
                    <li>🏛️ Reconocimiento oficial del SEPE</li>
                    <li>📜 Validez en toda España</li>
                    <li>💰 Formación bonificada disponible</li>
                    <li>👨‍🏫 Profesores especializados</li>
                    <li>🎯 Alta inserción laboral</li>
                    <li>📚 Material didáctico incluido</li>
                </ul>
            </div>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="[URL_CONTACTO]" style="background: linear-gradient(135deg, #0066cc, #0052a3); color: white; padding: 18px 35px; text-decoration: none; border-radius: 8px; font-weight: 700; display: inline-block; font-size: 16px;">
                    📞 Solicitar Información
                </a>
            </div>
            
            <div style="border-top: 2px solid #e0e0e0; padding-top: 20px; margin-top: 30px;">
                <p style="color: #666; font-size: 14px; margin: 0; text-align: center;">
                    <strong>Formación y Enseñanza Mogruas</strong><br>
                    Empresa acreditada por el SEPE<br>
                    📞 [TELEFONO] | 📧 [EMAIL_CONTACTO] | 🌐 [URL_WEB]
                </p>
            </div>
        </div>
    </div>';
    
    $resultado1 = $wpdb->insert(
        $table_campanas,
        array(
            'nombre' => 'Certificados de Profesionalidad Oficiales',
            'asunto' => '🎓 Certificados Oficiales SEPE - Formación Acreditada',
            'contenido' => $contenido_certificados,
            'segmento' => 'todos'
        )
    );
    
    if ($resultado1) {
        echo "<p>✅ Campaña 'Certificados de Profesionalidad' creada</p>";
    }
    
    // 2. CAMPAÑA SOBRE VALORES DE LA EMPRESA
    $contenido_valores = '
    <div style="max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif; background: #f8f9fa; padding: 20px;">
        <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="color: #0066cc; font-size: 28px; margin: 0;">🌟 Conoce Formación y Enseñanza Mogruas</h1>
                <p style="color: #666; font-size: 16px;">La formación al alcance de todos desde 2005</p>
            </div>
            
            <p style="font-size: 16px; line-height: 1.6; color: #333;">Hola <strong>[NOMBRE]</strong>,</p>
            
            <p style="font-size: 16px; line-height: 1.6; color: #333;">
                Somos una empresa referente en Talavera y comarca desde 2005. En 2018 actualizamos nuestra 
                oferta formativa para ofrecerte los mejores servicios de formación profesional.
            </p>
            
            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0;">
                <h3 style="color: #0066cc; margin-top: 0;">🏢 Nuestros Servicios:</h3>
                <ul style="color: #333; line-height: 1.8;">
                    <li>🎓 <strong>Certificados de Profesionalidad</strong> acreditados por el SEPE</li>
                    <li>💼 <strong>Formación Programada</strong> para empresas y trabajadores</li>
                    <li>🛡️ <strong>Prevención de Riesgos Laborales</strong> - Delegación Global Preventium</li>
                    <li>🔒 <strong>Adaptación RGPD</strong> - Reglamento General de Protección de Datos</li>
                </ul>
            </div>
            
            <div style="background: #e7f3ff; padding: 20px; border-radius: 10px; margin: 20px 0;">
                <h3 style="color: #0066cc; margin-top: 0;">💎 Nuestros Valores:</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <h4 style="color: #333; margin: 10px 0 5px 0;">🎯 Excelencia Educativa</h4>
                        <p style="font-size: 14px; color: #666; margin: 0;">Compromiso con la calidad en todos nuestros programas</p>
                    </div>
                    <div>
                        <h4 style="color: #333; margin: 10px 0 5px 0;">🚀 Innovación</h4>
                        <p style="font-size: 14px; color: #666; margin: 0;">3 impresoras 3D para fomentar la creatividad</p>
                    </div>
                    <div>
                        <h4 style="color: #333; margin: 10px 0 5px 0;">🤝 Integridad</h4>
                        <p style="font-size: 14px; color: #666; margin: 0;">Honestidad y transparencia en todas nuestras acciones</p>
                    </div>
                    <div>
                        <h4 style="color: #333; margin: 10px 0 5px 0;">👥 Orientación al Estudiante</h4>
                        <p style="font-size: 14px; color: #666; margin: 0;">Tu éxito es nuestro objetivo principal</p>
                    </div>
                </div>
            </div>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="[URL_WEB]" style="background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-block; margin: 5px;">
                    🌐 Conoce Más Sobre Nosotros
                </a>
                <a href="[URL_CONTACTO]" style="background: linear-gradient(135deg, #0066cc, #0052a3); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-block; margin: 5px;">
                    📞 Contactar
                </a>
            </div>
            
            <div style="border-top: 2px solid #e0e0e0; padding-top: 20px; margin-top: 30px;">
                <p style="color: #666; font-size: 14px; margin: 0; text-align: center;">
                    <strong>Formación y Enseñanza Mogruas</strong><br>
                    "La formación al alcance de todos"<br>
                    📞 [TELEFONO] | 📧 [EMAIL_CONTACTO]
                </p>
            </div>
        </div>
    </div>';
    
    $resultado2 = $wpdb->insert(
        $table_campanas,
        array(
            'nombre' => 'Conoce Formación y Enseñanza Mogruas',
            'asunto' => '🌟 Conoce nuestra empresa - Referentes desde 2005',
            'contenido' => $contenido_valores,
            'segmento' => 'todos'
        )
    );
    
    if ($resultado2) {
        echo "<p>✅ Campaña 'Valores de la Empresa' creada</p>";
    }
    
    // 3. CAMPAÑA SOBRE FORMACIÓN BONIFICADA
    $contenido_bonificada = '
    <div style="max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif; background: #f8f9fa; padding: 20px;">
        <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="color: #28a745; font-size: 28px; margin: 0;">💰 Formación Bonificada para Empresas</h1>
                <p style="color: #666; font-size: 16px;">Forma a tus trabajadores sin coste</p>
            </div>
            
            <p style="font-size: 16px; line-height: 1.6; color: #333;">Estimado/a <strong>[NOMBRE]</strong>,</p>
            
            <p style="font-size: 16px; line-height: 1.6; color: #333;">
                ¿Sabías que tu empresa tiene asignados créditos para la formación de tus trabajadores? 
                Todas las empresas que coticen por la contingencia de Formación Profesional pueden 
                beneficiarse de la formación bonificada.
            </p>
            
            <div style="background: #d4edda; padding: 20px; border-radius: 10px; margin: 20px 0;">
                <h3 style="color: #155724; margin-top: 0;">💡 ¿Cómo Funciona?</h3>
                <ul style="color: #155724; line-height: 1.8;">
                    <li>💳 <strong>Créditos automáticos</strong> según cotizaciones y número de trabajadores</li>
                    <li>📚 <strong>Formación sin coste</strong> mediante bonificación a la Seguridad Social</li>
                    <li>🔄 <strong>Créditos renovables</strong> cada año, acumulables</li>
                    <li>🎯 <strong>Cursos adaptados</strong> al puesto de trabajo</li>
                </ul>
            </div>
            
            <div style="background: #fff3cd; padding: 20px; border-radius: 10px; margin: 20px 0;">
                <h3 style="color: #856404; margin-top: 0;">📊 Datos Importantes:</h3>
                <p style="color: #856404; margin: 0;">
                    <strong>⚠️ El 83% de las microempresas</strong> de menos de 10 trabajadores aún no aprovechan 
                    sus créditos de formación. ¡No dejes que se pierdan!
                </p>
            </div>
            
            <div style="background: #e7f3ff; padding: 20px; border-radius: 10px; margin: 20px 0;">
                <h3 style="color: #0066cc; margin-top: 0;">🎓 Sectores con Mayor Demanda:</h3>
                <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                    <span style="background: #0066cc; color: white; padding: 8px 15px; border-radius: 20px; font-size: 14px;">🏗️ Construcción</span>
                    <span style="background: #28a745; color: white; padding: 8px 15px; border-radius: 20px; font-size: 14px;">🏨 Turismo</span>
                    <span style="background: #dc3545; color: white; padding: 8px 15px; border-radius: 20px; font-size: 14px;">🛒 Comercio</span>
                    <span style="background: #ffc107; color: #333; padding: 8px 15px; border-radius: 20px; font-size: 14px;">🚛 Transporte</span>
                    <span style="background: #6f42c1; color: white; padding: 8px 15px; border-radius: 20px; font-size: 14px;">💻 Tecnología</span>
                </div>
            </div>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="[URL_CONTACTO]" style="background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 18px 35px; text-decoration: none; border-radius: 8px; font-weight: 700; display: inline-block; font-size: 16px;">
                    💰 Consultar Mis Créditos
                </a>
            </div>
            
            <p style="font-size: 16px; line-height: 1.6; color: #333; text-align: center;">
                <strong>¡No dejes que se pierdan tus créditos de formación!</strong><br>
                Contacta con nosotros y te ayudamos a aprovecharlos al máximo.
            </p>
            
            <div style="border-top: 2px solid #e0e0e0; padding-top: 20px; margin-top: 30px;">
                <p style="color: #666; font-size: 14px; margin: 0; text-align: center;">
                    <strong>Formación y Enseñanza Mogruas</strong><br>
                    Especialistas en Formación Bonificada<br>
                    📞 [TELEFONO] | 📧 [EMAIL_CONTACTO]
                </p>
            </div>
        </div>
    </div>';
    
    $resultado3 = $wpdb->insert(
        $table_campanas,
        array(
            'nombre' => 'Formación Bonificada para Empresas',
            'asunto' => '💰 No pierdas tus créditos de formación - Consulta gratuita',
            'contenido' => $contenido_bonificada,
            'segmento' => 'todos'
        )
    );
    
    if ($resultado3) {
        echo "<p>✅ Campaña 'Formación Bonificada' creada</p>";
    }
    
    // 4. CAMPAÑA SOBRE GLOBAL PREVENTIUM (PRL)
    $contenido_prl = '
    <div style="max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif; background: #f8f9fa; padding: 20px;">
        <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="color: #dc3545; font-size: 28px; margin: 0;">🛡️ Prevención de Riesgos Laborales</h1>
                <p style="color: #666; font-size: 16px;">Delegación Global Preventium en Talavera</p>
            </div>
            
            <p style="font-size: 16px; line-height: 1.6; color: #333;">Estimado/a <strong>[NOMBRE]</strong>,</p>
            
            <p style="font-size: 16px; line-height: 1.6; color: #333;">
                Como Delegación de Global Preventium en Talavera y comarca, ofrecemos servicios 
                integrales de Prevención de Riesgos Laborales para más de 200 empresas.
            </p>
            
            <div style="background: #f8d7da; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #dc3545;">
                <h3 style="color: #721c24; margin-top: 0;">🎯 Servicios PRL Completos:</h3>
                <ul style="color: #721c24; line-height: 1.8;">
                    <li>🔍 <strong>Actividades Técnicas</strong> - Evaluaciones y mediciones</li>
                    <li>👩‍⚕️ <strong>Vigilancia de la Salud</strong> - Reconocimientos médicos</li>
                    <li>📚 <strong>Formación Especializada</strong> - Cursos PRL específicos</li>
                    <li>📋 <strong>Asesoramiento Continuo</strong> - Acompañamiento personalizado</li>
                    <li>🏢 <strong>Presencia en Centros</strong> - Seguimiento in situ</li>
                </ul>
            </div>
            
            <div style="background: #e7f3ff; padding: 20px; border-radius: 10px; margin: 20px 0;">
                <h3 style="color: #0066cc; margin-top: 0;">✨ ¿Por qué Global Preventium?</h3>
                <ul style="color: #333; line-height: 1.8;">
                    <li>🚀 <strong>Empresa innovadora</strong> con más de 10 años de experiencia</li>
                    <li>🏆 <strong>Modelo ejemplar</strong> de adaptación a nuevas exigencias</li>
                    <li>🤝 <strong>Servicio moderno</strong> con alta capacidad de asesoramiento</li>
                    <li>🏥 <strong>Centros especializados</strong> propios y colaboradores</li>
                    <li>😊 <strong>Satisfacción del cliente</strong> como razón de ser</li>
                </ul>
            </div>
            
            <div style="background: #d4edda; padding: 20px; border-radius: 10px; margin: 20px 0;">
                <h3 style="color: #155724; margin-top: 0;">📊 Nuestra Experiencia:</h3>
                <div style="text-align: center;">
                    <div style="display: inline-block; margin: 10px 20px;">
                        <div style="font-size: 32px; font-weight: 800; color: #155724;">+200</div>
                        <div style="font-size: 14px; color: #155724;">Empresas Atendidas</div>
                    </div>
                    <div style="display: inline-block; margin: 10px 20px;">
                        <div style="font-size: 32px; font-weight: 800; color: #155724;">+10</div>
                        <div style="font-size: 14px; color: #155724;">Años de Experiencia</div>
                    </div>
                </div>
            </div>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="[URL_CONTACTO]" style="background: linear-gradient(135deg, #dc3545, #c82333); color: white; padding: 18px 35px; text-decoration: none; border-radius: 8px; font-weight: 700; display: inline-block; font-size: 16px;">
                    🛡️ Solicitar Información PRL
                </a>
            </div>
            
            <p style="font-size: 16px; line-height: 1.6; color: #333; text-align: center;">
                Protege a tus trabajadores y cumple con la normativa. 
                Nuestro objetivo es lograr tu <strong>satisfacción</strong>.
            </p>
            
            <div style="border-top: 2px solid #e0e0e0; padding-top: 20px; margin-top: 30px;">
                <p style="color: #666; font-size: 14px; margin: 0; text-align: center;">
                    <strong>Global Preventium - Delegación Talavera</strong><br>
                    Formación y Enseñanza Mogruas<br>
                    📞 [TELEFONO] | 📧 [EMAIL_CONTACTO]
                </p>
            </div>
        </div>
    </div>';
    
    $resultado4 = $wpdb->insert(
        $table_campanas,
        array(
            'nombre' => 'Servicios PRL - Global Preventium',
            'asunto' => '🛡️ Prevención de Riesgos Laborales - Más de 200 empresas confían en nosotros',
            'contenido' => $contenido_prl,
            'segmento' => 'todos'
        )
    );
    
    if ($resultado4) {
        echo "<p>✅ Campaña 'Global Preventium PRL' creada</p>";
    }
    
    $campanas_creadas = ($resultado1 ? 1 : 0) + ($resultado2 ? 1 : 0) + ($resultado3 ? 1 : 0) + ($resultado4 ? 1 : 0);
    
    $mensaje_resultado = "<div style='background: #d4edda; padding: 20px; border-radius: 8px; margin: 20px 0; color: #155724;'>";
    $mensaje_resultado .= "<h3>✅ Campañas Creadas Exitosamente</h3>";
    $mensaje_resultado .= "<p><strong>Total de campañas creadas:</strong> $campanas_creadas</p>";
    $mensaje_resultado .= "<p>Las campañas están listas para ser enviadas desde el CRM.</p>";
    $mensaje_resultado .= "</div>";
}

// Obtener estadísticas de campañas
$total_campanas = $wpdb->get_var("SELECT COUNT(*) FROM $table_campanas");
$campanas_recientes = $wpdb->get_results("SELECT nombre, asunto, fecha_creacion FROM $table_campanas ORDER BY fecha_creacion DESC LIMIT 10");
?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    background: #f1f3f4;
}

.procesador-container {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin: 20px 0;
}

.stat-card {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    padding: 25px;
    border-radius: 12px;
    text-align: center;
    margin: 20px 0;
}

.stat-number {
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

.table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.table th, .table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
}

.table th {
    background: #f8f9fa;
    font-weight: 700;
}
</style>

<div class="procesador-container">
    <?php echo $mensaje_resultado; ?>
    
    <div class="stat-card">
        <div class="stat-number"><?php echo $total_campanas; ?></div>
        <div class="stat-label">Campañas Disponibles en el CRM</div>
    </div>
    
    <div class="info-box">
        <h3>📄 Contenido Procesado desde /doc</h3>
        <p>Este sistema crea campañas automáticas basadas en la información de los archivos de texto:</p>
        <ul>
            <li>✅ <strong>CERTIFICADOS DE PROFESIONALIDAD ACREDITADOS.txt</strong> → Campaña sobre certificados oficiales</li>
            <li>✅ <strong>VALORES.txt</strong> → Campaña sobre la empresa y sus valores</li>
            <li>✅ <strong>Empresa Mogruas.txt</strong> → Campaña sobre formación bonificada</li>
            <li>✅ <strong>DELEGACIÓN GLOBAL PREVENTIUM.txt</strong> → Campaña sobre servicios PRL</li>
        </ul>
        <p><strong>Total:</strong> 4 campañas profesionales listas para enviar</p>
    </div>
    
    <form method="post" style="text-align: center; margin: 30px 0;">
        <input type="hidden" name="accion" value="crear_campanas">
        <button type="submit" class="btn btn-success" onclick="return confirm('¿Crear campañas automáticas basadas en el contenido de /doc?')">
            📄 Crear Campañas desde Contenido
        </button>
    </form>
    
    <?php if (!empty($campanas_recientes)): ?>
    <h3>📧 Campañas Disponibles</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre de Campaña</th>
                <th>Asunto</th>
                <th>Fecha Creación</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($campanas_recientes as $campana): ?>
            <tr>
                <td><?php echo esc_html($campana->nombre); ?></td>
                <td><?php echo esc_html($campana->asunto); ?></td>
                <td><?php echo date('d/m/Y H:i', strtotime($campana->fecha_creacion)); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

<div style="text-align: center; margin: 30px 0;">
    <a href="/crm-mailing-completo.php" class="btn btn-primary">🎯 Ir al CRM para Enviar Campañas</a>
    <a href="/importar-datos-completos.php" class="btn btn-success">📥 Importar Datos de Clientes</a>
</div>
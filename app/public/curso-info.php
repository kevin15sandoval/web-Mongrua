<?php
/**
 * Página simple para mostrar información del curso
 */

// Cargar WordPress
require_once("wp-config.php");
require_once("wp-load.php");

// Obtener el ID del curso
$curso_id = isset($_GET["curso"]) ? intval($_GET["curso"]) : 1;

// Obtener datos del curso
$titulo = get_option("course_{$curso_id}_name") ?: "Curso de Ejemplo";
$fecha = get_option("course_{$curso_id}_date") ?: "Próximamente";
$modalidad = get_option("course_{$curso_id}_modality") ?: "Presencial";
$duracion = get_option("course_{$curso_id}_duration") ?: "Plazas limitadas";
$descripcion = get_option("course_{$curso_id}_description") ?: "Descripción del curso no disponible.";
$imagen = get_option("course_{$curso_id}_image");

get_header();
?>

<div class="container" style="max-width: 800px; margin: 40px auto; padding: 20px;">
    <div class="course-detail-card" style="background: white; border-radius: 16px; padding: 40px; box-shadow: 0 8px 25px rgba(0,0,0,0.1);">
        
        <?php if ($imagen): ?>
            <div style="text-align: center; margin-bottom: 25px;">
                <img src="<?php echo esc_url($imagen); ?>" alt="<?php echo esc_attr($titulo); ?>" style="max-width: 100%; height: 250px; object-fit: cover; border-radius: 12px;">
            </div>
        <?php endif; ?>
        
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="background: linear-gradient(135deg, #059669, #10b981); color: white; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 600; display: inline-block; margin-bottom: 20px;">
                <?php echo esc_html($fecha); ?>
            </div>
            
            <h1 style="font-size: 42px; font-weight: 700; color: #1a1a1a; margin-bottom: 20px; line-height: 1.3;">
                <?php echo esc_html($titulo); ?>
            </h1>
            
            <div style="display: flex; justify-content: center; gap: 20px; margin-bottom: 30px;">
                <span style="background: #e9ecef; color: #495057; padding: 8px 16px; border-radius: 12px; font-weight: 600;">
                    <?php echo esc_html($modalidad); ?>
                </span>
                <span style="background: #fff3cd; color: #856404; padding: 8px 16px; border-radius: 12px; font-weight: 600;">
                    <?php echo esc_html($duracion); ?>
                </span>
            </div>
        </div>
        
        <div style="margin-bottom: 30px;">
            <h2 style="font-size: 32px; font-weight: 600; color: #1a1a1a; margin-bottom: 15px;">Descripción del Curso</h2>
            <p style="font-size: 20px; line-height: 1.6; color: #495057;">
                <?php echo esc_html($descripcion); ?>
            </p>
        </div>
        
        <div style="background: #f8f9fa; padding: 30px; border-radius: 12px; margin-bottom: 30px;">
            <h3 style="font-size: 26px; font-weight: 600; color: #1a1a1a; margin-bottom: 15px;">Información Adicional</h3>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="padding: 8px 0; border-bottom: 1px solid #e9ecef;"><strong>Modalidad:</strong> <?php echo esc_html($modalidad); ?></li>
                <li style="padding: 8px 0; border-bottom: 1px solid #e9ecef;"><strong>Fecha de inicio:</strong> <?php echo esc_html($fecha); ?></li>
                <li style="padding: 8px 0; border-bottom: 1px solid #e9ecef;"><strong>Plazas:</strong> <?php echo esc_html($duracion); ?></li>
                <li style="padding: 8px 0;"><strong>Certificación:</strong> Certificado oficial</li>
            </ul>
        </div>
        
        <div style="text-align: center;">
            <a href="<?php echo home_url("/contacto"); ?>" style="background: linear-gradient(135deg, #059669, #10b981); color: white; padding: 16px 32px; border-radius: 12px; font-size: 20px; font-weight: 600; text-decoration: none; box-shadow: 0 4px 14px 0 rgba(5, 150, 105, 0.3); transition: all 0.3s ease; display: inline-block; margin-right: 15px;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px 0 rgba(5, 150, 105, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 14px 0 rgba(5, 150, 105, 0.3)';">
                📞 Reservar Plaza
            </a>
            
            <a href="<?php echo home_url("/anuncios"); ?>" style="background: linear-gradient(135deg, #6c757d, #495057); color: white; padding: 16px 32px; border-radius: 12px; font-size: 20px; font-weight: 600; text-decoration: none; box-shadow: 0 4px 14px 0 rgba(108, 117, 125, 0.3); transition: all 0.3s ease; display: inline-block;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px 0 rgba(108, 117, 125, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 14px 0 rgba(108, 117, 125, 0.3)';">
                ← Volver a Cursos
            </a>
        </div>
    </div>
</div>

<?php get_footer(); ?>
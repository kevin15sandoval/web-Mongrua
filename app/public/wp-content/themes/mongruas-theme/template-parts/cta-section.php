<?php
/**
 * Template part for displaying the CTA/Contact form section
 *
 * @package Mongruas
 * @since 1.0.0
 */

$cta_heading = get_field('cta_heading') ?: 'Solicita Información';
$cta_description = get_field('cta_description') ?: 'Completa el formulario y nos pondremos en contacto contigo lo antes posible';
?>

<section id="contact" class="cta-section section">
    <div class="container">
        <div class="section-heading">
            <h2><?php echo esc_html($cta_heading); ?></h2>
            <p><?php echo esc_html($cta_description); ?></p>
        </div>

        <div class="contact-form-wrapper">
            <form class="contact-form lead-form" method="post" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">
                <div class="form-row">
                    <div class="form-group">
                        <label for="contact_name"><?php esc_html_e('Nombre completo', 'mongruas'); ?> *</label>
                        <input type="text" 
                               id="contact_name" 
                               name="contact_name" 
                               required 
                               placeholder="<?php esc_attr_e('Tu nombre', 'mongruas'); ?>">
                    </div>

                    <div class="form-group">
                        <label for="contact_email"><?php esc_html_e('Email', 'mongruas'); ?> *</label>
                        <input type="email" 
                               id="contact_email" 
                               name="contact_email" 
                               required 
                               placeholder="<?php esc_attr_e('tu@email.com', 'mongruas'); ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="contact_phone"><?php esc_html_e('Teléfono', 'mongruas'); ?> *</label>
                        <input type="tel" 
                               id="contact_phone" 
                               name="contact_phone" 
                               required 
                               placeholder="<?php esc_attr_e('600 123 456', 'mongruas'); ?>">
                    </div>

                    <div class="form-group">
                        <label for="consultation_type"><?php esc_html_e('Tipo de consulta', 'mongruas'); ?> *</label>
                        <select id="consultation_type" name="consultation_type" required>
                            <option value=""><?php esc_html_e('Selecciona una opción', 'mongruas'); ?></option>
                            <option value="certificados"><?php esc_html_e('Certificados de Profesionalidad', 'mongruas'); ?></option>
                            <option value="formacion-bonificada"><?php esc_html_e('Formación Bonificada para Empresas', 'mongruas'); ?></option>
                            <option value="prl"><?php esc_html_e('Prevención de Riesgos Laborales (PRL)', 'mongruas'); ?></option>
                            <option value="lopd"><?php esc_html_e('Protección de Datos (LOPD/RGPD)', 'mongruas'); ?></option>
                            <option value="catalogo"><?php esc_html_e('Catálogo de Cursos Online', 'mongruas'); ?></option>
                            <option value="otra"><?php esc_html_e('Otra consulta', 'mongruas'); ?></option>
                        </select>
                    </div>
                </div>

                <div class="form-group company-field" style="display: none;">
                    <label for="contact_company"><?php esc_html_e('Empresa', 'mongruas'); ?></label>
                    <input type="text" 
                           id="contact_company" 
                           name="contact_company" 
                           placeholder="<?php esc_attr_e('Nombre de tu empresa', 'mongruas'); ?>">
                </div>

                <div class="form-group">
                    <label for="contact_message"><?php esc_html_e('Mensaje', 'mongruas'); ?></label>
                    <textarea id="contact_message" 
                              name="contact_message" 
                              rows="4" 
                              placeholder="<?php esc_attr_e('Cuéntanos más sobre tu consulta...', 'mongruas'); ?>"></textarea>
                </div>

                <div class="form-group checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" 
                               id="privacy_policy" 
                               name="privacy_policy" 
                               required>
                        <span>
                            <?php esc_html_e('Acepto la', 'mongruas'); ?> 
                            <a href="<?php echo esc_url(get_privacy_policy_url()); ?>" target="_blank">
                                <?php esc_html_e('política de privacidad', 'mongruas'); ?>
                            </a> 
                            <?php esc_html_e('y el tratamiento de mis datos', 'mongruas'); ?> *
                        </span>
                    </label>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <?php esc_html_e('Solicitar Información', 'mongruas'); ?>
                    </button>
                </div>

                <?php wp_nonce_field('mongruas_contact_form', 'contact_form_nonce'); ?>
            </form>
        </div>
    </div>
</section>

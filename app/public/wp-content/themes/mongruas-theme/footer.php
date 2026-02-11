<!-- Botón flotante de WhatsApp -->
<?php get_template_part('template-parts/whatsapp', 'button'); ?>

<footer id="colophon" class="site-footer" role="contentinfo">
    <!-- Mapa de ubicación -->
    <div class="footer-map-section">
        <div class="container">
            <h2 class="map-title">Dónde Encontrarnos</h2>
            <div class="map-container">
                <?php
                $google_maps_url = get_field('google_maps_url', 'option');
                $google_maps_embed = get_field('google_maps_embed', 'option');
                
                if ($google_maps_embed) :
                    echo $google_maps_embed;
                else : ?>
                    <!-- Mapa de ubicación exacta: C. Cdad. de Faenza, 2, Talavera de la Reina -->
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3042.8547856789!2d-4.8305!3d39.9628!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6a0b8e0e0e0e0e%3A0x0!2sC.%20Cdad.%20de%20Faenza%2C%202%2C%2045600%20Talavera%20de%20la%20Reina%2C%20Toledo!5e0!3m2!1ses!2ses!4v1234567890" 
                        width="100%" 
                        height="450" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                <?php endif; ?>
            </div>
            <div style="text-align: center; margin-top: 20px;">
                <a href="https://www.google.com/maps/place/C.+Cdad.+de+Faenza,+2,+45600+Talavera+de+la+Reina,+Toledo/@39.9628,-4.8305,17z" target="_blank" rel="noopener" class="map-directions-btn">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                    Cómo Llegar
                </a>
            </div>
        </div>
    </div>

    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-column footer-contact">
                <h3><?php esc_html_e('Contacto', 'mongruas'); ?></h3>
                <?php
                $phone = get_field('contact_phone', 'option');
                $email = get_field('contact_email', 'option');
                $address = get_field('contact_address', 'option');
                $whatsapp = get_field('whatsapp_number', 'option');
                
                if ($phone) : ?>
                    <p><strong><?php esc_html_e('Teléfono:', 'mongruas'); ?></strong> 
                        <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>">
                            <?php echo esc_html($phone); ?>
                        </a>
                    </p>
                <?php endif;
                
                if ($whatsapp) : ?>
                    <p><strong><?php esc_html_e('WhatsApp:', 'mongruas'); ?></strong> 
                        <a href="https://wa.me/<?php echo esc_attr($whatsapp); ?>" target="_blank">
                            <?php echo esc_html($whatsapp); ?>
                        </a>
                    </p>
                <?php endif;
                
                if ($email) : ?>
                    <p><strong><?php esc_html_e('Email:', 'mongruas'); ?></strong> 
                        <a href="mailto:<?php echo esc_attr($email); ?>">
                            <?php echo esc_html($email); ?>
                        </a>
                    </p>
                <?php endif;
                
                if ($address) : ?>
                    <p><strong><?php esc_html_e('Dirección:', 'mongruas'); ?></strong><br>
                        <?php echo esc_html($address); ?>
                    </p>
                <?php else : ?>
                    <p><strong><?php esc_html_e('Dirección:', 'mongruas'); ?></strong><br>
                        C. Cdad. de Faenza, 2<br>
                        45600 Talavera de la Reina, Toledo
                    </p>
                <?php endif; ?>
                
                <!-- Redes Sociales -->
                <div class="social-links">
                    <?php
                    $facebook = get_field('facebook_url', 'option');
                    $instagram = get_field('instagram_url', 'option');
                    $linkedin = get_field('linkedin_url', 'option');
                    $twitter = get_field('twitter_url', 'option');
                    $youtube = get_field('youtube_url', 'option');
                    
                    if ($facebook || $instagram || $linkedin || $twitter || $youtube) : ?>
                        <h4>Síguenos</h4>
                        <div class="social-icons">
                            <?php if ($facebook) : ?>
                                <a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                            <?php endif; ?>
                            
                            <?php if ($instagram) : ?>
                                <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                            <?php endif; ?>
                            
                            <?php if ($linkedin) : ?>
                                <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                </a>
                            <?php endif; ?>
                            
                            <?php if ($twitter) : ?>
                                <a href="<?php echo esc_url($twitter); ?>" target="_blank" rel="noopener noreferrer" aria-label="Twitter/X">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </a>
                            <?php endif; ?>
                            
                            <?php if ($youtube) : ?>
                                <a href="<?php echo esc_url($youtube); ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Redes Sociales -->
                <div class="footer-social-section">
                    <h4><?php esc_html_e('Redes Sociales', 'mongruas'); ?></h4>
                    <div class="footer-social-icons">
                        <a href="https://www.facebook.com/mogruas.formacion/?locale=es_ES" target="_blank" rel="noopener noreferrer" aria-label="Facebook" class="social-icon-link">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/formacionyensenanzamogruas/?hl=es" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="social-icon-link">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="footer-column footer-links">
                <h3><?php esc_html_e('Enlaces', 'mongruas'); ?></h3>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'menu_class'     => 'footer-menu',
                    'container'      => false,
                    'fallback_cb'    => false,
                ));
                ?>
                <p>
                    <a href="https://www.plataformateleformacion.com" target="_blank" class="campus-link">
                        <?php esc_html_e('Acceder al Campus Virtual', 'mongruas'); ?>
                    </a>
                </p>
            </div>

            <div class="footer-column footer-certifications footer-certifications-wide">
                <h3><?php esc_html_e('Acreditaciones Oficiales', 'mongruas'); ?></h3>
                
                <!-- Contenedor principal de acreditaciones -->
                <div class="certifications-container">
                    <!-- Logos oficiales principales -->
                    <div class="official-certifications">
                        <div class="cert-item">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-castilla-la-mancha.png" 
                                 alt="Castilla-La Mancha" 
                                 class="official-logo"
                                 onerror="this.style.display='none'">
                        </div>
                        <div class="cert-item">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-ministerio-educacion.png" 
                                 alt="Ministerio de Educación, Formación Profesional y Deportes" 
                                 class="official-logo"
                                 onerror="this.style.display='none'">
                        </div>
                    </div>
                    
                    <!-- Información de acreditación -->
                    <div class="certification-info">
                        <!-- Texto de acreditación -->
                        <div class="certification-text">
                            <p><strong>Empresa acreditada</strong> en el Registro Estatal de Entidades de Formación de Castilla-La Mancha</p>
                            <p class="cert-details">Formación Profesional para el Empleo - Certificados de Profesionalidad</p>
                        </div>
                    </div>
                </div>
                
                <!-- Certificaciones adicionales de ACF -->
                <?php
                $certifications = get_field('certifications', 'option');
                if ($certifications) : ?>
                    <div class="additional-certifications">
                        <?php foreach ($certifications as $cert) :
                            if (!empty($cert['certification_logo'])) : ?>
                                <img src="<?php echo esc_url($cert['certification_logo']['url']); ?>" 
                                     alt="<?php echo esc_attr($cert['certification_name']); ?>"
                                     class="certification-logo">
                            <?php endif;
                        endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <p class="copyright">
                    &copy; <?php echo date('Y'); ?> 
                    <?php bloginfo('name'); ?>. 
                    <?php esc_html_e('Todos los derechos reservados.', 'mongruas'); ?>
                </p>
                <div class="footer-links-bottom">
                    <a href="<?php echo esc_url(get_privacy_policy_url()); ?>">
                        <?php esc_html_e('Política de Privacidad', 'mongruas'); ?>
                    </a>
                    <span class="separator">|</span>
                    <span class="web-credits">
                        Desarrollo web por 
                        <a href="https://tecnologiaysoluciones-clm.com" target="_blank" rel="noopener" class="dev-link">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16" style="vertical-align: middle; margin-right: 4px;">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            Tecnología y Soluciones CLM
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
/* Estilos para el mapa */
.footer-map-section {
    background: #f8f9fa;
    padding: 60px 0;
    border-top: 1px solid #e0e0e0;
}

.footer-map-section .map-title {
    text-align: center;
    font-size: 32px;
    font-weight: 700;
    color: var(--color-gray-800);
    margin-bottom: 30px;
}

.map-container {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.map-container iframe {
    display: block;
    width: 100%;
    height: 450px;
}

/* Botón "Cómo Llegar" del mapa - tamaño compacto */


.map-directions-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    background: linear-gradient(135deg, #0066cc 0%, #004d99 100%);
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 102, 204, 0.2);
    border: 1px solid #3385d6;
}

.map-directions-btn:hover {
    background: linear-gradient(135deg, #ff9900 0%, #cc7a00 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 153, 0, 0.3);
    color: white;
    text-decoration: none;
}

.map-directions-btn:hover {
    background: linear-gradient(135deg, #ff9900 0%, #cc7a00 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 153, 0, 0.3);
    color: white;
    text-decoration: none;
}

.map-directions-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    color: white;
    text-decoration: none;
}

/* Estilos para redes sociales */
.social-links {
    margin-top: 24px;
}

.social-links h4 {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 14px;
    color: var(--color-white);
}

.social-icons {
    display: flex;
    gap: 12px;
}

.social-icons a {
    width: 44px;
    height: 44px;
    background: var(--color-primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.social-icons a:hover {
    background: var(--color-secondary);
    transform: translateY(-3px);
}

.social-icons svg {
    width: 22px;
    height: 22px;
}

/* Nueva columna de Redes Sociales en footer */
.footer-social {
    flex: 1;
}

.footer-social h3 {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 20px;
    color: white;
}

/* Redes Sociales dentro de la columna de Contacto */
.footer-social-section {
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.footer-social-section h4 {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 12px;
    color: white;
}

.footer-social-icons {
    display: flex;
    gap: 10px;
}

.social-icon-link {
    width: 36px;
    height: 36px;
    background: var(--color-primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    text-decoration: none;
}

.social-icon-link:hover {
    background: var(--color-secondary);
    transform: translateY(-3px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.social-icon-link svg {
    width: 20px;
    height: 20px;
}

/* Estilos para acreditaciones oficiales - Sección más ancha */
.footer-certifications-wide {
    flex: 2; /* Hacer esta columna más ancha */
    max-width: none;
}

.certifications-container {
    display: flex;
    align-items: flex-start;
    gap: 30px;
    margin: 20px 0;
}

.official-certifications {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
    min-width: 200px;
}

.cert-item {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    padding: 15px;
    transition: all 0.3s ease;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.cert-item:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
}

.official-logo {
    height: 70px;
    width: auto;
    max-width: 160px;
    object-fit: contain;
}

.certification-info {
    flex: 1;
    text-align: left;
}

.certification-text {
    margin-bottom: 20px;
    font-size: 14px;
    line-height: 1.4;
}

.certification-text p {
    margin: 8px 0;
    color: rgba(255, 255, 255, 0.9);
}

.cert-details {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.7);
    font-style: italic;
}

.available-certificates h4 {
    font-size: 16px;
    margin-bottom: 12px;
    color: var(--color-primary);
}

.cert-list {
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: 13px;
}

.cert-list li {
    margin: 8px 0;
    color: rgba(255, 255, 255, 0.8);
    display: flex;
    align-items: center;
    justify-content: flex-start;
}

.cert-code {
    background: #e6f2ff;
    color: #0066cc;
    border: 2px solid #0066cc;
    padding: 4px 8px;
    border-radius: 4px;
    font-weight: 700;
    font-size: 11px;
    margin-right: 12px;
    min-width: 80px;
    text-align: center;
    transition: all 0.3s ease;
}

.cert-code:hover {
    background: #0066cc;
    color: white;
    transform: translateY(-1px);
}

.additional-certifications {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
}

.certification-logo {
    height: 45px;
    width: auto;
    opacity: 0.8;
    transition: opacity 0.3s ease;
}

.certification-logo:hover {
    opacity: 1;
}

/* Estilos para footer bottom */
.footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding-top: 20px;
    margin-top: 30px;
}

.footer-bottom-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.footer-links-bottom {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
}

.footer-links-bottom a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-links-bottom a:hover {
    color: var(--color-primary);
}

.separator {
    color: rgba(255, 255, 255, 0.5);
}

.web-credits {
    color: rgba(255, 255, 255, 0.7);
    font-size: 13px;
}

.dev-link {
    color: var(--color-primary) !important;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
}

.dev-link:hover {
    color: var(--color-secondary) !important;
    transform: translateY(-1px);
}

.dev-link svg {
    transition: transform 0.3s ease;
}

.dev-link:hover svg {
    transform: rotate(20deg);
}

/* Responsive */
@media (max-width: 768px) {
    .footer-map-section {
        padding: 40px 0;
    }
    
    .footer-map-section .map-title {
        font-size: 24px;
        margin-bottom: 20px;
    }
    
    .map-container iframe {
        height: 300px !important;
    }
    
    .footer-bottom-content {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
    
    .footer-links-bottom {
        flex-direction: column;
        gap: 8px;
    }
    
    .separator {
        display: none;
    }
    
    /* Responsive para acreditaciones */
    .footer-certifications-wide {
        flex: 1;
    }
    
    .certifications-container {
        flex-direction: column;
        gap: 20px;
        text-align: center;
    }
    
    .certification-info {
        text-align: center;
    }
    
    .official-certifications {
        flex-direction: row;
        justify-content: center;
        min-width: auto;
    }
    
    .cert-item {
        padding: 10px;
    }
    
    .official-logo {
        height: 50px;
        max-width: 120px;
    }
}
</style>

<?php wp_footer(); ?>
</body>
</html>

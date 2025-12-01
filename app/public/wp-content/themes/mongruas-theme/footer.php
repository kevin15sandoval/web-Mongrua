<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-column footer-about">
                <h3><?php esc_html_e('Formación y Enseñanza Mogruas', 'mongruas'); ?></h3>
                <p><?php esc_html_e('Centro Profesional para el Empleo desde 2005', 'mongruas'); ?></p>
                <p><?php esc_html_e('La formación al alcance de todos', 'mongruas'); ?></p>
            </div>

            <div class="footer-column footer-contact">
                <h3><?php esc_html_e('Contacto', 'mongruas'); ?></h3>
                <?php
                $phone = get_field('contact_phone', 'option');
                $email = get_field('contact_email', 'option');
                $address = get_field('contact_address', 'option');
                
                if ($phone) : ?>
                    <p><strong><?php esc_html_e('Teléfono:', 'mongruas'); ?></strong> 
                        <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>">
                            <?php echo esc_html($phone); ?>
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
                    <p><strong><?php esc_html_e('Dirección:', 'mongruas'); ?></strong> 
                        <?php echo esc_html($address); ?>
                    </p>
                <?php endif; ?>
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

            <div class="footer-column footer-certifications">
                <h3><?php esc_html_e('Acreditaciones', 'mongruas'); ?></h3>
                <div class="certification-logos">
                    <?php
                    $certifications = get_field('certifications', 'option');
                    if ($certifications) :
                        foreach ($certifications as $cert) :
                            if (!empty($cert['certification_logo'])) : ?>
                                <img src="<?php echo esc_url($cert['certification_logo']['url']); ?>" 
                                     alt="<?php echo esc_attr($cert['certification_name']); ?>"
                                     class="certification-logo">
                            <?php endif;
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="copyright">
                &copy; <?php echo date('Y'); ?> 
                <?php bloginfo('name'); ?>. 
                <?php esc_html_e('Todos los derechos reservados.', 'mongruas'); ?>
            </p>
            <p class="credits">
                <a href="<?php echo esc_url(get_privacy_policy_url()); ?>">
                    <?php esc_html_e('Política de Privacidad', 'mongruas'); ?>
                </a>
            </p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

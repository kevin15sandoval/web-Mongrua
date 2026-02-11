<?php
/**
 * Template Name: Página de Contacto
 * Description: Página de contacto con mapa, información y botones de acción
 *
 * @package Mongruas
 */

get_header();
?>

<main id="main" class="site-main contact-page" role="main">
    <!-- Hero Section -->
    <section class="contact-hero">
        <div class="container">
            <h1>Contacta con Nosotros</h1>
            <p class="hero-subtitle">Estamos aquí para ayudarte. Elige la forma que prefieras para ponerte en contacto.</p>
        </div>
    </section>

    <!-- Botones de Contacto Rápido -->
    <section class="quick-contact-section">
        <div class="container">
            <div class="quick-contact-grid">
                <?php
                $phone = get_field('contact_phone', 'option') ?: '925 81 39 99';
                $email = get_field('contact_email', 'option') ?: 'mongruasformaciontalavera@gmail.com';
                $whatsapp = get_field('whatsapp_number', 'option') ?: '34603492885';
                
                // Limpiar número de teléfono para enlaces
                $phone_clean = str_replace([' ', '-', '(', ')'], '', $phone);
                $whatsapp_clean = str_replace([' ', '-', '(', ')', '+'], '', $whatsapp);
                ?>
                
                <!-- Botón WhatsApp -->
                <a href="https://wa.me/<?php echo esc_attr($whatsapp_clean); ?>?text=Hola,%20me%20gustaría%20obtener%20información%20sobre%20sus%20cursos" 
                   class="contact-card whatsapp-card" target="_blank" rel="noopener">
                    <div class="card-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                    </div>
                    <h3>WhatsApp</h3>
                    <p>Chatea con nosotros</p>
                    <span class="contact-value"><?php echo esc_html($whatsapp); ?></span>
                </a>

                <!-- Botón Teléfono -->
                <a href="tel:<?php echo esc_attr($phone_clean); ?>" class="contact-card phone-card">
                    <div class="card-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.977.977 0 00-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
                        </svg>
                    </div>
                    <h3>Teléfono</h3>
                    <p>Llámanos directamente</p>
                    <span class="contact-value"><?php echo esc_html($phone); ?></span>
                </a>

                <!-- Botón Email -->
                <a href="https://mail.google.com/mail/?view=cm&fs=1&to=<?php echo esc_attr($email); ?>" class="contact-card email-card" target="_blank" rel="noopener">
                    <div class="card-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                    </div>
                    <h3>Email</h3>
                    <p>Escríbenos un correo</p>
                    <span class="contact-value">Enviar correo</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Información de Contacto y Horarios -->
    <section class="contact-info-section">
        <div class="container">
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                    </div>
                    <h3>Dirección</h3>
                    <p><?php echo esc_html(get_field('contact_address', 'option') ?: 'C. Cdad. de Faenza, 2'); ?></p>
                    <p><?php echo esc_html(get_field('contact_city', 'option') ?: '45600 Talavera de la Reina, Toledo'); ?></p>
                </div>

                <div class="info-card">
                    <div class="info-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                        </svg>
                    </div>
                    <h3>Horario</h3>
                    <p>Lunes a Viernes: </p>
                    <p> 8:00 - 20:00</p>
                    
                </div>
            </div>
        </div>
    </section>

    <!-- Formulario de Contacto -->
    <?php get_template_part('template-parts/cta', 'section'); ?>

</main>

<?php
get_footer();

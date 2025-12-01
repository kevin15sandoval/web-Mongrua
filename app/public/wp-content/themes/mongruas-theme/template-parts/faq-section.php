<?php
/**
 * Template part for displaying the FAQ section
 *
 * @package Mongruas
 * @since 1.0.0
 */

$faq_heading = get_field('faq_section_heading') ?: 'Preguntas Frecuentes';
$faqs = get_field('faqs');

// Default FAQs if not set
$default_faqs = array(
    array(
        'question' => '¿Qué son los Certificados de Profesionalidad?',
        'answer' => 'Los Certificados de Profesionalidad son títulos oficiales que acreditan las competencias profesionales necesarias para el desempeño de una actividad laboral. Están reconocidos por el SEPE y tienen validez en todo el territorio nacional.'
    ),
    array(
        'question' => '¿Cómo funciona la formación bonificada?',
        'answer' => 'Todas las empresas que cotizan por formación profesional disponen de un crédito anual para formar a sus trabajadores. Este crédito se puede utilizar para bonificar el coste de la formación a través de deducciones en las cuotas de la Seguridad Social. Nosotros gestionamos todo el proceso.'
    ),
    array(
        'question' => '¿Puedo acceder a los cursos online desde cualquier dispositivo?',
        'answer' => 'Sí, nuestro Campus Virtual es totalmente responsive y puedes acceder desde ordenador, tablet o móvil. Solo necesitas conexión a internet y un navegador actualizado.'
    ),
    array(
        'question' => '¿Cuánto tiempo tengo para completar un curso online?',
        'answer' => 'El tiempo de realización depende de cada curso. Generalmente, los cursos tienen una duración flexible que te permite avanzar a tu propio ritmo dentro del período establecido.'
    ),
    array(
        'question' => '¿Los cursos tienen certificado?',
        'answer' => 'Sí, al finalizar cada curso recibirás un certificado que acredita la formación realizada. En el caso de los Certificados de Profesionalidad, estos son títulos oficiales con validez en todo el territorio nacional.'
    ),
    array(
        'question' => '¿Ofrecen formación presencial?',
        'answer' => 'Sí, además de nuestra amplia oferta de formación online, también impartimos formación presencial en nuestras instalaciones de Talavera de la Reina, especialmente para los Certificados de Profesionalidad.'
    )
);

$faqs_to_display = $faqs ?: $default_faqs;
?>

<section id="faq" class="faq-section section">
    <div class="container">
        <div class="section-heading">
            <h2><?php echo esc_html($faq_heading); ?></h2>
        </div>

        <div class="faq-list">
            <?php foreach ($faqs_to_display as $index => $faq) : ?>
                <div class="faq-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    <div class="faq-question">
                        <h3><?php echo esc_html($faq['faq_question'] ?: $faq['question']); ?></h3>
                        <span class="faq-icon">+</span>
                    </div>
                    <div class="faq-answer" <?php echo $index === 0 ? 'style="display: block;"' : ''; ?>>
                        <?php echo wpautop(wp_kses_post($faq['faq_answer'] ?: $faq['answer'])); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="faq-cta text-center mt-xl">
            <p><?php esc_html_e('¿No encuentras la respuesta que buscas?', 'mongruas'); ?></p>
            <a href="#contact" class="btn btn-primary cta-button" data-cta-location="faq">
                <?php esc_html_e('Contáctanos', 'mongruas'); ?>
            </a>
        </div>
    </div>
</section>

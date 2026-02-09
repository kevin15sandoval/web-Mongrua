<?php
/**
 * ACF Field Groups Configuration
 * 
 * Este archivo configura automáticamente todos los campos ACF necesarios
 * para la landing page de Mongruas
 * 
 * @package Mongruas
 * @since 1.0.0
 */

if (!function_exists('acf_add_local_field_group')) {
    return;
}

// ============================================
// HERO SECTION FIELDS
// ============================================
acf_add_local_field_group(array(
    'key' => 'group_hero_section',
    'title' => 'Landing Page - Hero Section',
    'fields' => array(
        array(
            'key' => 'field_hero_headline',
            'label' => 'Título Principal',
            'name' => 'hero_headline',
            'type' => 'text',
            'instructions' => 'Título grande del hero (ej: "LA FORMACIÓN AL ALCANCE DE TODOS")',
            'required' => 1,
            'default_value' => 'LA FORMACIÓN AL ALCANCE DE TODOS',
        ),
        array(
            'key' => 'field_hero_subheadline',
            'label' => 'Subtítulo',
            'name' => 'hero_subheadline',
            'type' => 'textarea',
            'instructions' => 'Texto descriptivo debajo del título',
            'required' => 1,
            'rows' => 3,
            'default_value' => 'Centro Profesional para el Empleo desde 2005 en Talavera de la Reina',
        ),
        array(
            'key' => 'field_hero_background_image',
            'label' => 'Imagen de Fondo',
            'name' => 'hero_background_image',
            'type' => 'image',
            'instructions' => 'Imagen de fondo del hero (recomendado: 1920x1080px)',
            'return_format' => 'url',
        ),
        array(
            'key' => 'field_hero_background_video',
            'label' => 'Video de Fondo (Opcional)',
            'name' => 'hero_background_video',
            'type' => 'url',
            'instructions' => 'URL del video de fondo (opcional, sobrescribe la imagen)',
        ),
        array(
            'key' => 'field_hero_primary_cta_text',
            'label' => 'Texto Botón Principal',
            'name' => 'hero_primary_cta_text',
            'type' => 'text',
            'default_value' => 'Solicita Información',
        ),
        array(
            'key' => 'field_hero_primary_cta_link',
            'label' => 'Enlace Botón Principal',
            'name' => 'hero_primary_cta_link',
            'type' => 'text',
            'default_value' => '#contact',
        ),
        array(
            'key' => 'field_hero_secondary_cta_text',
            'label' => 'Texto Botón Secundario',
            'name' => 'hero_secondary_cta_text',
            'type' => 'text',
            'default_value' => 'Acceder al Campus Virtual',
        ),
        array(
            'key' => 'field_hero_secondary_cta_link',
            'label' => 'Enlace Botón Secundario',
            'name' => 'hero_secondary_cta_link',
            'type' => 'url',
            'default_value' => 'https://www.plataformateleformacion.com',
        ),
        array(
            'key' => 'field_hero_trust_badges',
            'label' => 'Trust Badges',
            'name' => 'hero_trust_badges',
            'type' => 'repeater',
            'instructions' => 'Badges de confianza (ej: "20 años de experiencia")',
            'layout' => 'table',
            'button_label' => 'Añadir Badge',
            'sub_fields' => array(
                array(
                    'key' => 'field_badge_text',
                    'label' => 'Texto',
                    'name' => 'text',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_badge_icon',
                    'label' => 'Icono (Opcional)',
                    'name' => 'icon',
                    'type' => 'image',
                    'return_format' => 'url',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-templates/landing-page.php',
            ),
        ),
    ),
));

// ============================================
// SERVICES SECTION FIELDS
// ============================================
acf_add_local_field_group(array(
    'key' => 'group_services_section',
    'title' => 'Landing Page - Services Section',
    'fields' => array(
        array(
            'key' => 'field_services_heading',
            'label' => 'Título de la Sección',
            'name' => 'services_section_heading',
            'type' => 'text',
            'default_value' => 'Nuestros Servicios',
        ),
        array(
            'key' => 'field_services_description',
            'label' => 'Descripción',
            'name' => 'services_section_description',
            'type' => 'textarea',
            'rows' => 3,
        ),
        array(
            'key' => 'field_services',
            'label' => 'Servicios',
            'name' => 'services',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Añadir Servicio',
            'sub_fields' => array(
                array(
                    'key' => 'field_service_title',
                    'label' => 'Título del Servicio',
                    'name' => 'service_title',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_service_description',
                    'label' => 'Descripción',
                    'name' => 'service_description',
                    'type' => 'textarea',
                    'rows' => 3,
                ),
                array(
                    'key' => 'field_service_icon',
                    'label' => 'Icono',
                    'name' => 'service_icon',
                    'type' => 'image',
                    'return_format' => 'url',
                ),
                array(
                    'key' => 'field_service_features',
                    'label' => 'Características',
                    'name' => 'service_features',
                    'type' => 'repeater',
                    'layout' => 'table',
                    'button_label' => 'Añadir Característica',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_feature_text',
                            'label' => 'Texto',
                            'name' => 'feature_text',
                            'type' => 'text',
                        ),
                    ),
                ),
                array(
                    'key' => 'field_service_badge',
                    'label' => 'Badge/Etiqueta',
                    'name' => 'service_badge_text',
                    'type' => 'text',
                    'instructions' => 'Ej: "Acreditados por SEPE"',
                ),
                array(
                    'key' => 'field_service_cta_link',
                    'label' => 'Enlace CTA',
                    'name' => 'service_cta_link',
                    'type' => 'url',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-templates/landing-page.php',
            ),
        ),
    ),
));

// ============================================
// THEME SETTINGS (Options Page)
// ============================================
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Theme Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug' => 'theme-settings',
        'capability' => 'edit_posts',
        'icon_url' => 'dashicons-admin-settings',
        'redirect' => false
    ));
}

acf_add_local_field_group(array(
    'key' => 'group_theme_settings',
    'title' => 'Theme Settings',
    'fields' => array(
        // Contact Information
        array(
            'key' => 'field_contact_tab',
            'label' => 'Información de Contacto',
            'type' => 'tab',
        ),
        array(
            'key' => 'field_contact_phone',
            'label' => 'Teléfono',
            'name' => 'contact_phone',
            'type' => 'text',
        ),
        array(
            'key' => 'field_whatsapp_number',
            'label' => 'WhatsApp',
            'name' => 'whatsapp_number',
            'type' => 'text',
            'instructions' => 'Número de WhatsApp con código de país (ej: 34XXXXXXXXX)',
        ),
        array(
            'key' => 'field_whatsapp_message',
            'label' => 'Mensaje WhatsApp por defecto',
            'name' => 'whatsapp_message',
            'type' => 'text',
            'default_value' => '¡Hola! Me gustaría recibir información sobre los cursos de Mogruas',
        ),
        array(
            'key' => 'field_contact_email',
            'label' => 'Email',
            'name' => 'contact_email',
            'type' => 'email',
        ),
        array(
            'key' => 'field_contact_address',
            'label' => 'Dirección',
            'name' => 'contact_address',
            'type' => 'textarea',
            'rows' => 3,
        ),
        array(
            'key' => 'field_google_maps_embed',
            'label' => 'Google Maps Embed Code',
            'name' => 'google_maps_embed',
            'type' => 'textarea',
            'instructions' => 'Pega aquí el código iframe de Google Maps',
            'rows' => 5,
        ),
        
        // Social Media
        array(
            'key' => 'field_social_tab',
            'label' => 'Redes Sociales',
            'type' => 'tab',
        ),
        array(
            'key' => 'field_facebook_url',
            'label' => 'Facebook',
            'name' => 'facebook_url',
            'type' => 'url',
        ),
        array(
            'key' => 'field_instagram_url',
            'label' => 'Instagram',
            'name' => 'instagram_url',
            'type' => 'url',
        ),
        array(
            'key' => 'field_linkedin_url',
            'label' => 'LinkedIn',
            'name' => 'linkedin_url',
            'type' => 'url',
        ),
        array(
            'key' => 'field_twitter_url',
            'label' => 'Twitter/X',
            'name' => 'twitter_url',
            'type' => 'url',
        ),
        array(
            'key' => 'field_youtube_url',
            'label' => 'YouTube',
            'name' => 'youtube_url',
            'type' => 'url',
        ),
        
        // Statistics
        array(
            'key' => 'field_stats_tab',
            'label' => 'Estadísticas',
            'type' => 'tab',
        ),
        array(
            'key' => 'field_statistics',
            'label' => 'Estadísticas',
            'name' => 'statistics',
            'type' => 'repeater',
            'layout' => 'table',
            'button_label' => 'Añadir Estadística',
            'sub_fields' => array(
                array(
                    'key' => 'field_stat_number',
                    'label' => 'Número',
                    'name' => 'stat_number',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_stat_label',
                    'label' => 'Etiqueta',
                    'name' => 'stat_label',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_stat_icon',
                    'label' => 'Icono',
                    'name' => 'stat_icon',
                    'type' => 'image',
                    'return_format' => 'url',
                ),
            ),
        ),
        
        // Certifications
        array(
            'key' => 'field_cert_tab',
            'label' => 'Certificaciones',
            'type' => 'tab',
        ),
        array(
            'key' => 'field_certifications',
            'label' => 'Logos de Certificaciones',
            'name' => 'certifications',
            'type' => 'repeater',
            'layout' => 'table',
            'button_label' => 'Añadir Certificación',
            'sub_fields' => array(
                array(
                    'key' => 'field_cert_logo',
                    'label' => 'Logo',
                    'name' => 'certification_logo',
                    'type' => 'image',
                    'return_format' => 'url',
                ),
                array(
                    'key' => 'field_cert_name',
                    'label' => 'Nombre',
                    'name' => 'certification_name',
                    'type' => 'text',
                ),
            ),
        ),
        
        // Analytics
        array(
            'key' => 'field_analytics_tab',
            'label' => 'Analytics & Tracking',
            'type' => 'tab',
        ),
        array(
            'key' => 'field_google_analytics',
            'label' => 'Google Analytics Code',
            'name' => 'google_analytics_code',
            'type' => 'textarea',
            'instructions' => 'Pega aquí tu código de Google Analytics (GA4)',
            'rows' => 5,
        ),
        array(
            'key' => 'field_facebook_pixel',
            'label' => 'Facebook Pixel Code',
            'name' => 'facebook_pixel_code',
            'type' => 'textarea',
            'instructions' => 'Pega aquí tu código de Facebook Pixel',
            'rows' => 5,
        ),
        array(
            'key' => 'field_custom_tracking',
            'label' => 'Custom Tracking Scripts',
            'name' => 'custom_tracking_scripts',
            'type' => 'textarea',
            'instructions' => 'Otros scripts de tracking personalizados',
            'rows' => 5,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'options_page',
                'operator' => '==',
                'value' => 'theme-settings',
            ),
        ),
    ),
));

// ============================================
// TESTIMONIALS CUSTOM POST TYPE FIELDS
// ============================================
acf_add_local_field_group(array(
    'key' => 'group_testimonial_fields',
    'title' => 'Testimonial Details',
    'fields' => array(
        array(
            'key' => 'field_author_name',
            'label' => 'Nombre del Autor',
            'name' => 'author_name',
            'type' => 'text',
            'required' => 1,
        ),
        array(
            'key' => 'field_author_role',
            'label' => 'Cargo/Empresa',
            'name' => 'author_role',
            'type' => 'text',
        ),
        array(
            'key' => 'field_author_photo',
            'label' => 'Foto del Autor',
            'name' => 'author_photo',
            'type' => 'image',
            'return_format' => 'url',
            'preview_size' => 'thumbnail',
        ),
        array(
            'key' => 'field_rating',
            'label' => 'Puntuación',
            'name' => 'rating',
            'type' => 'number',
            'min' => 1,
            'max' => 5,
            'default_value' => 5,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'testimonial',
            ),
        ),
    ),
));

// ============================================
// GLOBAL PREVENTIUM SECTION FIELDS
// ============================================
acf_add_local_field_group(array(
    'key' => 'group_global_preventium',
    'title' => 'Global Preventium - Configuración',
    'fields' => array(
        array(
            'key' => 'field_preventium_heading',
            'label' => 'Título de la Sección',
            'name' => 'preventium_heading',
            'type' => 'text',
            'default_value' => 'Delegación Global Preventium',
        ),
        array(
            'key' => 'field_preventium_description',
            'label' => 'Descripción',
            'name' => 'preventium_description',
            'type' => 'textarea',
            'rows' => 3,
            'default_value' => 'Servicios de Prevención de Riesgos Laborales',
        ),
        array(
            'key' => 'field_preventium_logo',
            'label' => 'Logo de Global Preventium',
            'name' => 'preventium_logo',
            'type' => 'image',
            'instructions' => 'Logo de Global Preventium (si no se sube, se usará el logo por defecto)',
            'return_format' => 'array',
            'preview_size' => 'medium',
        ),
        array(
            'key' => 'field_preventium_url',
            'label' => 'URL de Acceso',
            'name' => 'preventium_url',
            'type' => 'url',
            'instructions' => 'URL para acceder a la documentación de PRL',
            'default_value' => 'https://www.globalpreventium.com',
        ),
        array(
            'key' => 'field_preventium_phone',
            'label' => 'Teléfono de Contacto',
            'name' => 'preventium_phone',
            'type' => 'text',
            'default_value' => '926 921 018',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'options_page',
                'operator' => '==',
                'value' => 'theme-settings',
            ),
        ),
    ),
));


// ============================================
// PRÓXIMOS CURSOS - OPTIONS PAGE
// ============================================
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Gestión de Próximos Cursos',
        'menu_title' => 'Próximos Cursos',
        'menu_slug' => 'proximos-cursos',
        'capability' => 'edit_posts',
        'icon_url' => 'dashicons-welcome-learn-more',
        'position' => 25,
    ));
}

acf_add_local_field_group(array(
    'key' => 'group_upcoming_courses_simple',
    'title' => 'Próximos Cursos',
    'fields' => array(
        // CURSO 1
        array(
            'key' => 'field_course_1_tab',
            'label' => 'Curso 1',
            'name' => '',
            'type' => 'tab',
            'instructions' => '',
            'placement' => 'top',
        ),
        array(
            'key' => 'field_course_1_name',
            'label' => 'Nombre del Curso 1',
            'name' => 'course_1_name',
            'type' => 'text',
            'instructions' => 'Título del primer curso próximo',
            'placeholder' => 'Ej: Curso de Marketing Digital',
        ),
        array(
            'key' => 'field_course_1_description',
            'label' => 'Descripción del Curso 1',
            'name' => 'course_1_description',
            'type' => 'textarea',
            'instructions' => 'Breve descripción del curso',
            'rows' => 3,
            'placeholder' => 'Describe brevemente el contenido del curso...',
        ),
        array(
            'key' => 'field_course_1_date',
            'label' => 'Fecha de Inicio del Curso 1',
            'name' => 'course_1_date',
            'type' => 'text',
            'instructions' => 'Fecha en que comienza el curso',
            'placeholder' => 'Ej: 15 de Enero 2025',
        ),
        array(
            'key' => 'field_course_1_duration',
            'label' => 'Duración del Curso 1',
            'name' => 'course_1_duration',
            'type' => 'text',
            'instructions' => 'Duración del curso (opcional)',
            'placeholder' => 'Ej: 40 horas',
        ),
        array(
            'key' => 'field_course_1_modality',
            'label' => 'Modalidad del Curso 1',
            'name' => 'course_1_modality',
            'type' => 'select',
            'instructions' => 'Modalidad del curso',
            'choices' => array(
                'Online' => 'Online',
                'Presencial' => 'Presencial',
                'Semipresencial' => 'Semipresencial',
            ),
            'default_value' => 'Online',
        ),
        array(
            'key' => 'field_course_1_category',
            'label' => 'Categoría del Curso 1',
            'name' => 'course_1_category',
            'type' => 'select',
            'instructions' => 'Categoría o área del curso',
            'choices' => array(
                'Prevención de Riesgos Laborales' => 'Prevención de Riesgos Laborales',
                'Formación Profesional' => 'Formación Profesional',
                'Idiomas' => 'Idiomas',
                'Informática' => 'Informática',
                'Gestión Empresarial' => 'Gestión Empresarial',
                'Marketing' => 'Marketing',
                'Otros' => 'Otros',
            ),
            'default_value' => 'Prevención de Riesgos Laborales',
        ),
        array(
            'key' => 'field_course_1_image',
            'label' => 'Imagen del Curso 1',
            'name' => 'course_1_image',
            'type' => 'image',
            'instructions' => 'Imagen representativa del curso (opcional)',
            'return_format' => 'array',
            'preview_size' => 'medium',
        ),
        
        // CURSO 2
        array(
            'key' => 'field_course_2_tab',
            'label' => 'Curso 2',
            'name' => '',
            'type' => 'tab',
            'instructions' => '',
            'placement' => 'top',
        ),
        array(
            'key' => 'field_course_2_name',
            'label' => 'Nombre del Curso 2',
            'name' => 'course_2_name',
            'type' => 'text',
            'instructions' => 'Título del segundo curso próximo (opcional)',
            'placeholder' => 'Ej: Curso de Gestión Empresarial',
        ),
        array(
            'key' => 'field_course_2_description',
            'label' => 'Descripción del Curso 2',
            'name' => 'course_2_description',
            'type' => 'textarea',
            'instructions' => 'Breve descripción del curso',
            'rows' => 3,
            'placeholder' => 'Describe brevemente el contenido del curso...',
        ),
        array(
            'key' => 'field_course_2_date',
            'label' => 'Fecha de Inicio del Curso 2',
            'name' => 'course_2_date',
            'type' => 'text',
            'instructions' => 'Fecha en que comienza el curso',
            'placeholder' => 'Ej: 22 de Enero 2025',
        ),
        array(
            'key' => 'field_course_2_duration',
            'label' => 'Duración del Curso 2',
            'name' => 'course_2_duration',
            'type' => 'text',
            'instructions' => 'Duración del curso (opcional)',
            'placeholder' => 'Ej: 60 horas',
        ),
        array(
            'key' => 'field_course_2_modality',
            'label' => 'Modalidad del Curso 2',
            'name' => 'course_2_modality',
            'type' => 'select',
            'instructions' => 'Modalidad del curso',
            'choices' => array(
                'Online' => 'Online',
                'Presencial' => 'Presencial',
                'Semipresencial' => 'Semipresencial',
            ),
            'default_value' => 'Online',
        ),
        array(
            'key' => 'field_course_2_category',
            'label' => 'Categoría del Curso 2',
            'name' => 'course_2_category',
            'type' => 'select',
            'instructions' => 'Categoría o área del curso',
            'choices' => array(
                'Prevención de Riesgos Laborales' => 'Prevención de Riesgos Laborales',
                'Formación Profesional' => 'Formación Profesional',
                'Idiomas' => 'Idiomas',
                'Informática' => 'Informática',
                'Gestión Empresarial' => 'Gestión Empresarial',
                'Marketing' => 'Marketing',
                'Otros' => 'Otros',
            ),
            'default_value' => 'Prevención de Riesgos Laborales',
        ),
        array(
            'key' => 'field_course_2_image',
            'label' => 'Imagen del Curso 2',
            'name' => 'course_2_image',
            'type' => 'image',
            'instructions' => 'Imagen representativa del curso (opcional)',
            'return_format' => 'array',
            'preview_size' => 'medium',
        ),
        
        // CURSO 3
        array(
            'key' => 'field_course_3_tab',
            'label' => 'Curso 3',
            'name' => '',
            'type' => 'tab',
            'instructions' => '',
            'placement' => 'top',
        ),
        array(
            'key' => 'field_course_3_name',
            'label' => 'Nombre del Curso 3',
            'name' => 'course_3_name',
            'type' => 'text',
            'instructions' => 'Título del tercer curso próximo (opcional)',
            'placeholder' => 'Ej: Curso de Idiomas',
        ),
        array(
            'key' => 'field_course_3_description',
            'label' => 'Descripción del Curso 3',
            'name' => 'course_3_description',
            'type' => 'textarea',
            'instructions' => 'Breve descripción del curso',
            'rows' => 3,
            'placeholder' => 'Describe brevemente el contenido del curso...',
        ),
        array(
            'key' => 'field_course_3_date',
            'label' => 'Fecha de Inicio del Curso 3',
            'name' => 'course_3_date',
            'type' => 'text',
            'instructions' => 'Fecha en que comienza el curso',
            'placeholder' => 'Ej: 1 de Febrero 2025',
        ),
        array(
            'key' => 'field_course_3_duration',
            'label' => 'Duración del Curso 3',
            'name' => 'course_3_duration',
            'type' => 'text',
            'instructions' => 'Duración del curso (opcional)',
            'placeholder' => 'Ej: 30 horas',
        ),
        array(
            'key' => 'field_course_3_modality',
            'label' => 'Modalidad del Curso 3',
            'name' => 'course_3_modality',
            'type' => 'select',
            'instructions' => 'Modalidad del curso',
            'choices' => array(
                'Online' => 'Online',
                'Presencial' => 'Presencial',
                'Semipresencial' => 'Semipresencial',
            ),
            'default_value' => 'Online',
        ),
        array(
            'key' => 'field_course_3_category',
            'label' => 'Categoría del Curso 3',
            'name' => 'course_3_category',
            'type' => 'select',
            'instructions' => 'Categoría o área del curso',
            'choices' => array(
                'Prevención de Riesgos Laborales' => 'Prevención de Riesgos Laborales',
                'Formación Profesional' => 'Formación Profesional',
                'Idiomas' => 'Idiomas',
                'Informática' => 'Informática',
                'Gestión Empresarial' => 'Gestión Empresarial',
                'Marketing' => 'Marketing',
                'Otros' => 'Otros',
            ),
            'default_value' => 'Prevención de Riesgos Laborales',
        ),
        array(
            'key' => 'field_course_3_image',
            'label' => 'Imagen del Curso 3',
            'name' => 'course_3_image',
            'type' => 'image',
            'instructions' => 'Imagen representativa del curso (opcional)',
            'return_format' => 'array',
            'preview_size' => 'medium',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'options_page',
                'operator' => '==',
                'value' => 'proximos-cursos',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
));

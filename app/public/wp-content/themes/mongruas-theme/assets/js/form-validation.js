/**
 * Form Validation JavaScript for Formación y Enseñanza Mogruas
 * 
 * @package Mongruas
 * @since 1.0.0
 */

(function($) {
    'use strict';

    /**
     * Email validation regex
     */
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    /**
     * Phone validation regex (Spanish format)
     */
    const phoneRegex = /^(\+34|0034|34)?[6789]\d{8}$/;

    /**
     * Validate single field
     */
    function validateField(field) {
        const $field = $(field);
        const value = $field.val().trim();
        const fieldType = $field.attr('type') || $field.prop('tagName').toLowerCase();
        const isRequired = $field.prop('required');
        let isValid = true;
        let errorMessage = '';

        // Remove previous error
        $field.removeClass('error');
        $field.next('.error-message').remove();

        // Check if required field is empty
        if (isRequired && value === '') {
            isValid = false;
            errorMessage = 'Este campo es obligatorio';
        }
        // Validate email
        else if (fieldType === 'email' && value !== '' && !emailRegex.test(value)) {
            isValid = false;
            errorMessage = 'Por favor, introduce un email válido';
        }
        // Validate phone
        else if (fieldType === 'tel' && value !== '' && !phoneRegex.test(value.replace(/\s/g, ''))) {
            isValid = false;
            errorMessage = 'Por favor, introduce un teléfono válido';
        }
        // Validate checkbox
        else if (fieldType === 'checkbox' && isRequired && !$field.is(':checked')) {
            isValid = false;
            errorMessage = 'Debes aceptar este campo';
        }

        // Display error if invalid
        if (!isValid) {
            $field.addClass('error');
            $field.after('<span class="error-message">' + errorMessage + '</span>');
        }

        return isValid;
    }

    /**
     * Validate entire form
     */
    function validateForm($form) {
        let isValid = true;
        const $fields = $form.find('input, textarea, select').filter('[required]');

        $fields.each(function() {
            if (!validateField(this)) {
                isValid = false;
            }
        });

        return isValid;
    }

    /**
     * Handle form submission
     */
    function handleFormSubmit(e) {
        e.preventDefault();
        
        const $form = $(this);
        const $submitBtn = $form.find('button[type="submit"]');
        const originalBtnText = $submitBtn.text();

        // Validate form
        if (!validateForm($form)) {
            // Scroll to first error
            const $firstError = $form.find('.error').first();
            if ($firstError.length) {
                $('html, body').animate({
                    scrollTop: $firstError.offset().top - 100
                }, 300);
            }
            return false;
        }

        // Disable submit button and show loading
        $submitBtn.prop('disabled', true).text('Enviando...');

        // Get form data
        const formData = new FormData(this);
        formData.append('action', 'mongruas_submit_form');
        formData.append('nonce', mongruasAjax.nonce);

        // Submit via AJAX
        $.ajax({
            url: mongruasAjax.ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    // Show success message
                    $form.html('<div class="success-message"><h3>¡Gracias por tu interés!</h3><p>Hemos recibido tu solicitud. Nos pondremos en contacto contigo pronto.</p></div>');

                    // Track form submission
                    if (typeof mongruasAjax !== 'undefined') {
                        $.ajax({
                            url: mongruasAjax.ajaxurl,
                            type: 'POST',
                            data: {
                                action: 'mongruas_track_form',
                                nonce: mongruasAjax.nonce,
                                form_type: 'contact'
                            }
                        });
                    }

                    // Fire Google Analytics event
                    if (typeof gtag !== 'undefined') {
                        gtag('event', 'form_submission', {
                            'event_category': 'engagement',
                            'event_label': 'contact_form'
                        });
                    }

                    // Fire Facebook Pixel event
                    if (typeof fbq !== 'undefined') {
                        fbq('track', 'Contact');
                    }

                    // Scroll to success message
                    $('html, body').animate({
                        scrollTop: $form.offset().top - 100
                    }, 500);
                } else {
                    // Show error message
                    $form.prepend('<div class="error-message">Ha ocurrido un error. Por favor, inténtalo de nuevo.</div>');
                    $submitBtn.prop('disabled', false).text(originalBtnText);
                }
            },
            error: function() {
                // Show error message
                $form.prepend('<div class="error-message">Ha ocurrido un error. Por favor, inténtalo de nuevo o contacta directamente.</div>');
                $submitBtn.prop('disabled', false).text(originalBtnText);
            }
        });

        return false;
    }

    /**
     * Initialize form validation
     */
    $(document).ready(function() {
        // Real-time validation on blur
        $(document).on('blur', 'input, textarea, select', function() {
            if ($(this).val() !== '') {
                validateField(this);
            }
        });

        // Validate on change for checkboxes and selects
        $(document).on('change', 'input[type="checkbox"], select', function() {
            validateField(this);
        });

        // Handle form submission
        $('.contact-form, .lead-form').on('submit', handleFormSubmit);

        // Show/hide company field based on consultation type
        $('select[name="consultation_type"]').on('change', function() {
            const value = $(this).val();
            const $companyField = $('.company-field');

            if (value === 'formacion-bonificada' || value === 'prl') {
                $companyField.slideDown(300);
                $companyField.find('input').prop('required', true);
            } else {
                $companyField.slideUp(300);
                $companyField.find('input').prop('required', false);
            }
        });
    });

})(jQuery);

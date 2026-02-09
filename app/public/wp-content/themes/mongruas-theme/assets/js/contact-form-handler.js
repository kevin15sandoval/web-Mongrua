/**
 * Contact Form Handler - Maneja el envío del formulario de contacto
 */

document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.querySelector('.contact-form.lead-form');
    
    if (!contactForm) {
        console.log('❌ Formulario de contacto no encontrado');
        return;
    }
    
    console.log('✅ Contact Form Handler cargado');
    
    // Manejar envío del formulario
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitButton = contactForm.querySelector('button[type="submit"]');
        const originalButtonText = submitButton.textContent;
        
        // Deshabilitar botón y mostrar loading
        submitButton.disabled = true;
        submitButton.textContent = 'Enviando...';
        
        // Recopilar datos del formulario
        const formData = new FormData(contactForm);
        formData.append('action', 'mongruas_submit_form');
        
        // Enviar formulario via AJAX
        fetch(contactForm.action, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar mensaje de éxito
                showMessage('success', '✅ ¡Formulario enviado correctamente! Nos pondremos en contacto contigo pronto.');
                
                // Limpiar formulario
                contactForm.reset();
                
                // Si se guardó en CRM, mostrar mensaje adicional
                if (data.data.message.includes('saved to CRM')) {
                    console.log('✅ Contacto guardado en CRM');
                }
            } else {
                // Mostrar mensaje de error
                showMessage('error', '❌ Error: ' + (data.data.message || 'No se pudo enviar el formulario'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('error', '❌ Error de conexión. Por favor, inténtalo de nuevo.');
        })
        .finally(() => {
            // Rehabilitar botón
            submitButton.disabled = false;
            submitButton.textContent = originalButtonText;
        });
    });
    
    // Función para mostrar mensajes
    function showMessage(type, message) {
        // Eliminar mensajes anteriores
        const existingMessages = document.querySelectorAll('.form-message');
        existingMessages.forEach(msg => msg.remove());
        
        // Crear nuevo mensaje
        const messageDiv = document.createElement('div');
        messageDiv.className = `form-message form-message-${type}`;
        messageDiv.style.cssText = `
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
            animation: slideIn 0.3s ease;
            ${type === 'success' ? 'background: #d4edda; color: #155724; border: 2px solid #28a745;' : 'background: #f8d7da; color: #721c24; border: 2px solid #dc3545;'}
        `;
        messageDiv.textContent = message;
        
        // Insertar mensaje antes del formulario
        contactForm.parentNode.insertBefore(messageDiv, contactForm);
        
        // Scroll al mensaje
        messageDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        // Eliminar mensaje después de 10 segundos
        setTimeout(() => {
            messageDiv.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => messageDiv.remove(), 300);
        }, 10000);
    }
    
    // Mostrar campo de empresa cuando se selecciona "formacion-bonificada"
    const consultationType = document.getElementById('consultation_type');
    const companyField = document.querySelector('.company-field');
    
    if (consultationType && companyField) {
        consultationType.addEventListener('change', function() {
            if (this.value === 'formacion-bonificada') {
                companyField.style.display = 'block';
                document.getElementById('contact_company').required = true;
            } else {
                companyField.style.display = 'none';
                document.getElementById('contact_company').required = false;
            }
        });
    }
});

// Añadir animaciones CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slideOut {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-20px);
        }
    }
    
    .form-group input.error,
    .form-group select.error,
    .form-group textarea.error {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1) !important;
    }
`;
document.head.appendChild(style);

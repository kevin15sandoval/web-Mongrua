<?php
/**
 * WhatsApp Floating Button
 * Botón flotante de WhatsApp siempre visible
 * 
 * @package Mongruas
 * @since 1.0.0
 */

$whatsapp_number = get_field('whatsapp_number', 'option') ?: '34XXXXXXXXX'; // Reemplazar con número real
$whatsapp_message = get_field('whatsapp_message', 'option') ?: '¡Hola! Me gustaría recibir información sobre los cursos de Mogruas';
?>

<!-- Contenedor de botones flotantes - se crea aquí y el panel se integra via JavaScript -->
<div class="floating-buttons-container">
    <a href="https://wa.me/<?php echo esc_attr($whatsapp_number); ?>?text=<?php echo urlencode($whatsapp_message); ?>" 
       class="whatsapp-float" 
       target="_blank" 
       rel="noopener noreferrer"
       aria-label="Contactar por WhatsApp">
        <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
            <path d="M16 0c-8.837 0-16 7.163-16 16 0 2.825 0.737 5.607 2.137 8.048l-2.137 7.952 7.933-2.127c2.42 1.37 5.173 2.127 8.067 2.127 8.837 0 16-7.163 16-16s-7.163-16-16-16zM16 29.467c-2.482 0-4.908-0.646-7.07-1.87l-0.507-0.292-4.713 1.262 1.262-4.669-0.292-0.508c-1.207-2.100-1.847-4.507-1.847-6.957 0-7.51 6.11-13.62 13.62-13.62s13.62 6.11 13.62 13.62-6.11 13.62-13.62 13.62zM21.305 19.26c-0.346-0.174-2.049-1.007-2.366-1.123-0.316-0.117-0.547-0.174-0.776 0.174s-0.892 1.123-1.094 1.347c-0.201 0.231-0.403 0.26-0.748 0.087-0.346-0.174-1.461-0.539-2.785-1.722-1.031-0.922-1.727-2.061-1.929-2.407-0.201-0.346-0.022-0.533 0.152-0.705 0.156-0.155 0.346-0.403 0.518-0.605 0.174-0.201 0.231-0.346 0.346-0.576 0.117-0.231 0.058-0.433-0.028-0.605s-0.776-1.87-1.063-2.565c-0.28-0.672-0.56-0.58-0.776-0.591-0.201-0.010-0.431-0.012-0.661-0.012s-0.604 0.087-0.92 0.433c-0.316 0.346-1.206 1.179-1.206 2.873s1.235 3.333 1.406 3.561c0.174 0.231 2.421 3.697 5.868 5.184 0.821 0.354 1.462 0.566 1.962 0.724 0.825 0.262 1.577 0.225 2.168 0.137 0.661-0.099 2.049-0.835 2.335-1.642 0.288-0.807 0.288-1.501 0.201-1.642-0.086-0.14-0.316-0.231-0.662-0.403z" fill="currentColor"/>
        </svg>
        <span class="whatsapp-text">WhatsApp</span>
    </a>
</div>

<script>
// Asegurar que el contenedor esté disponible para la integración del panel
document.addEventListener('DOMContentLoaded', function() {
    console.log('📱 Contenedor de botones flotantes inicializado');
    
    // Verificar que el contenedor existe
    const container = document.querySelector('.floating-buttons-container');
    if (container) {
        console.log('✅ Contenedor de botones flotantes listo para integración');
        
        // Añadir atributo para identificación
        container.setAttribute('data-buttons-ready', 'true');
        
        // Disparar evento personalizado para notificar que está listo
        const event = new CustomEvent('floatingButtonsReady', {
            detail: { container: container }
        });
        document.dispatchEvent(event);
    }
});
</script>

<style>
/* Contenedor para ambos botones flotantes */
.floating-buttons-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 12px;
    z-index: 9997; /* Menor que el panel para que no interfiera */
}

.whatsapp-float {
    width: 50px;
    height: 50px;
    background: #25D366;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 3px 10px rgba(37, 211, 102, 0.4);
    transition: all 0.3s ease;
    text-decoration: none;
    position: relative;
}

.whatsapp-float:hover {
    transform: scale(1.1);
    box-shadow: 0 5px 15px rgba(37, 211, 102, 0.6);
    background: #128C7E;
}

.whatsapp-float svg {
    width: 26px;
    height: 26px;
}

.whatsapp-text {
    display: none;
}

/* Animación de pulso sutil */
@keyframes pulse-subtle {
    0% {
        box-shadow: 0 3px 10px rgba(37, 211, 102, 0.4);
    }
    50% {
        box-shadow: 0 3px 10px rgba(37, 211, 102, 0.4), 0 0 0 8px rgba(37, 211, 102, 0.1);
    }
    100% {
        box-shadow: 0 3px 10px rgba(37, 211, 102, 0.4);
    }
}

.whatsapp-float {
    animation: pulse-subtle 3s infinite;
}

.whatsapp-float:hover {
    animation: none;
}

/* Responsive */
@media (max-width: 768px) {
    .floating-buttons-container {
        bottom: 15px;
        right: 15px;
        gap: 10px;
    }
    
    .whatsapp-float {
        width: 46px;
        height: 46px;
    }
    
    .whatsapp-float svg {
        width: 24px;
        height: 24px;
    }
}

/* Versión expandida en hover (desktop) */
@media (min-width: 769px) {
    .whatsapp-float:hover {
        width: auto;
        padding: 0 18px;
        border-radius: 25px;
    }
    
    .whatsapp-float:hover .whatsapp-text {
        display: inline;
        margin-left: 8px;
        font-weight: 600;
        font-size: 13px;
    }
}

/* Tooltip para mejor UX */
.whatsapp-float::after {
    content: 'Contactar por WhatsApp';
    position: absolute;
    right: 100%;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 12px;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    margin-right: 10px;
    pointer-events: none;
}

.whatsapp-float:hover::after {
    opacity: 1;
    visibility: visible;
}

@media (max-width: 768px) {
    .whatsapp-float::after {
        display: none;
    }
}
</style>

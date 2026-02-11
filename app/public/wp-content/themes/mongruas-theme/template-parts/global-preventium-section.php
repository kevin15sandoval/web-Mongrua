<?php
/**
 * Template part for displaying Global Preventium delegation section
 *
 * @package Mongruas
 * @since 1.0.0
 */

$preventium_heading = get_field('preventium_heading') ?: 'Delegación Global Preventium';
$preventium_description = get_field('preventium_description') ?: 'Servicios de Prevención de Riesgos Laborales';
$preventium_url = get_field('preventium_url') ?: 'http://45.156.210.243:1001/web/';
$preventium_phone = get_field('preventium_phone') ?: '926 921 018';
?>

<section id="global-preventium" class="global-preventium-section section">
    <div class="container">
        <div class="preventium-content">
            <div class="preventium-text">
                <div class="section-badge">
                    <span class="badge-icon">🛡️</span>
                    <span>Prevención de Riesgos Laborales</span>
                </div>
                
                <h2><?php echo esc_html($preventium_heading); ?></h2>
                
                <div class="preventium-description">
                    <p>
                        <strong>GLOBAL PREVENTIUM</strong> es una empresa innovadora en el sector de 
                        <strong>Servicios de Prevención de Riesgos Laborales</strong>, con un modelo 
                        ejemplar para la correcta adaptación de su empresa a las nuevas exigencias en 
                        materia de prevención.
                    </p>
                    
                    <p>
                        Con más de 10 años de experiencia, ofrecemos un servicio de prevención ajeno 
                        moderno, con alta capacidad de asesoramiento, acompañamiento y presencia en 
                        los centros de trabajo.
                    </p>
                </div>

                <div class="preventium-features">
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span>Planes de formación específicos</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span>Medicina del Trabajo</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span>Reconocimientos Médicos</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span>Vigilancia de la Salud</span>
                    </div>
                </div>

                <div class="preventium-cta">
                    <a href="<?php echo esc_url($preventium_url); ?>" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="btn btn-primary btn-lg">
                        Acceder a Documentación PRL
                    </a>
                    <a href="tel:<?php echo esc_attr(str_replace(' ', '', $preventium_phone)); ?>" 
                       class="btn btn-outline btn-lg">
                        <span class="phone-icon">📞</span>
                        <?php echo esc_html($preventium_phone); ?>
                    </a>
                </div>
            </div>

            <div class="preventium-logo">
                <div class="logo-container">
                    <?php
                    $preventium_logo = get_field('preventium_logo');
                    if ($preventium_logo): ?>
                        <img src="<?php echo esc_url($preventium_logo['url']); ?>" 
                             alt="Global Preventium Logo" 
                             class="preventium-logo-img">
                    <?php else: ?>
                        <!-- Logo por defecto -->
                        <img src="<?php echo home_url('/wp-content/uploads/Logo_Gloval_Preventium.png'); ?>" 
                             alt="Global Preventium Logo" 
                             class="preventium-logo-img">
                    <?php endif; ?>
                </div>
                
                <div class="preventium-info-box">
                    <h3>Acceso para Empresas</h3>
                    <p>Las empresas pueden acceder a su documentación de prevención desde nuestra plataforma.</p>
                    <p class="info-note">
                        <strong>Nota:</strong> Si necesita sus credenciales de acceso, 
                        contacte con nosotros.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.global-preventium-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    position: relative;
    overflow: hidden;
}

.global-preventium-section::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 50%;
    height: 100%;
    background: linear-gradient(135deg, rgba(0, 102, 204, 0.03) 0%, rgba(0, 82, 163, 0.05) 100%);
    z-index: 1;
}

.preventium-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
    position: relative;
    z-index: 2;
}

.section-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(0, 102, 204, 0.1);
    color: var(--color-primary);
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 20px;
}

.badge-icon {
    font-size: 18px;
}

.preventium-text h2 {
    font-size: 42px;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 30px;
    line-height: 1.2;
}

.preventium-description {
    margin-bottom: 30px;
}

.preventium-description p {
    font-size: 16px;
    line-height: 1.8;
    color: #495057;
    margin-bottom: 20px;
}

.preventium-description strong {
    color: var(--color-primary);
    font-weight: 700;
}

.preventium-features {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    margin-bottom: 30px;
}

.preventium-features .feature-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 15px;
    color: #495057;
    font-weight: 500;
}

.preventium-features .feature-icon {
    width: 24px;
    height: 24px;
    background: var(--color-success);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    flex-shrink: 0;
}

.preventium-cta {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.phone-icon {
    margin-right: 5px;
}

.preventium-logo {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.logo-container {
    background: white;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 250px;
}

.preventium-logo-img {
    max-width: 100%;
    height: auto;
    max-height: 200px;
    object-fit: contain;
}

.logo-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
    color: var(--color-primary);
}

.placeholder-icon {
    font-size: 80px;
}

.placeholder-text {
    font-size: 24px;
    font-weight: 700;
}

.preventium-info-box {
    background: linear-gradient(135deg, var(--color-primary) 0%, #0052a3 100%);
    color: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3);
}

.preventium-info-box h3 {
    color: white;
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 15px;
}

.preventium-info-box p {
    color: rgba(255, 255, 255, 0.95);
    font-size: 15px;
    line-height: 1.6;
    margin-bottom: 15px;
}

.preventium-info-box p:last-child {
    margin-bottom: 0;
}

.info-note {
    background: rgba(255, 255, 255, 0.15);
    padding: 15px;
    border-radius: 8px;
    border-left: 4px solid rgba(255, 255, 255, 0.5);
}

.info-note strong {
    color: white;
}

/* Responsive */
@media (max-width: 968px) {
    .preventium-content {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .preventium-text h2 {
        font-size: 32px;
    }
    
    .preventium-features {
        grid-template-columns: 1fr;
    }
    
    .logo-container {
        padding: 30px;
        min-height: 200px;
    }
}

@media (max-width: 768px) {
    .preventium-text h2 {
        font-size: 28px;
    }
    
    .preventium-description p {
        font-size: 15px;
    }
    
    .preventium-cta {
        flex-direction: column;
    }
    
    .preventium-cta .btn {
        width: 100%;
        text-align: center;
    }
    
    .logo-container {
        padding: 20px;
        min-height: 150px;
    }
    
    .preventium-info-box {
        padding: 20px;
    }
}
</style>

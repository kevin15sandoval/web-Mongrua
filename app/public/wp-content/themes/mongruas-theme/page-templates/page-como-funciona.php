<?php
/**
 * Template Name: Cómo Funciona
 * Template Post Type: page
 *
 * Página explicativa del proceso de formación
 * 
 * @package Mongruas
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main page-como-funciona">
    
    <!-- Hero -->
    <section class="page-hero como-funciona-hero">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <span class="hero-badge">Proceso Simple y Efectivo</span>
                <h1 class="page-title">¿Cómo Funciona?</h1>
                <p class="page-subtitle">Tu camino hacia la formación profesional en 4 sencillos pasos</p>
            </div>
        </div>
    </section>

    <!-- Proceso Paso a Paso -->
    <section class="process-steps-section section">
        <div class="container">
            <div class="section-heading">
                <h2>Nuestro Proceso de Formación</h2>
                <p>Desde el primer contacto hasta la obtención de tu certificado</p>
            </div>

            <div class="steps-timeline">
                <!-- Paso 1 -->
                <div class="step-item">
                    <div class="step-number">
                        <span>1</span>
                    </div>
                    <div class="step-content">
                        <h3>Solicita Información</h3>
                        <p>Contacta con nosotros por teléfono, WhatsApp o formulario web. Te asesoraremos sobre el curso más adecuado para tus necesidades y objetivos profesionales.</p>
                        <ul class="step-features">
                            <li>Asesoramiento personalizado</li>
                            <li>Información sobre bonificaciones</li>
                            <li>Resolución de dudas</li>
                        </ul>
                        <div class="step-cta">
                            <a href="#contact" class="btn btn-outline">Solicitar Información</a>
                        </div>
                    </div>
                    <div class="step-icon">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Paso 2 -->
                <div class="step-item">
                    <div class="step-number">
                        <span>2</span>
                    </div>
                    <div class="step-content">
                        <h3>Inscripción y Matrícula</h3>
                        <p>Una vez elegido tu curso, completamos el proceso de inscripción. Te ayudamos con toda la documentación necesaria y gestionamos las bonificaciones si aplica.</p>
                        <ul class="step-features">
                            <li>Proceso de matrícula sencillo</li>
                            <li>Gestión de bonificaciones FUNDAE</li>
                            <li>Documentación clara y simple</li>
                        </ul>
                        <div class="step-highlight">
                            <strong>💡 Importante:</strong> Gestionamos toda la tramitación de bonificaciones para empresas
                        </div>
                    </div>
                    <div class="step-icon">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                    </div>
                </div>

                <!-- Paso 3 -->
                <div class="step-item">
                    <div class="step-number">
                        <span>3</span>
                    </div>
                    <div class="step-content">
                        <h3>Formación</h3>
                        <p>Accede a nuestro campus virtual 24/7 o asiste a clases presenciales. Contarás con tutores especializados y material didáctico de calidad.</p>
                        <ul class="step-features">
                            <li>Campus virtual disponible 24/7</li>
                            <li>Tutores especializados</li>
                            <li>Material didáctico actualizado</li>
                            <li>Clases presenciales (según modalidad)</li>
                        </ul>
                        <div class="step-cta">
                            <a href="https://www.plataformateleformacion.com" target="_blank" class="btn btn-primary">
                                Acceder al Campus Virtual
                            </a>
                        </div>
                    </div>
                    <div class="step-icon">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Paso 4 -->
                <div class="step-item">
                    <div class="step-number">
                        <span>4</span>
                    </div>
                    <div class="step-content">
                        <h3>Certificación</h3>
                        <p>Al finalizar tu formación, recibirás tu certificado oficial. Todos nuestros cursos están acreditados por organismos oficiales.</p>
                        <ul class="step-features">
                            <li>Certificados oficiales</li>
                            <li>Reconocimiento profesional</li>
                            <li>Válidos para oposiciones</li>
                            <li>Certificados de Profesionalidad</li>
                        </ul>
                        <div class="step-highlight success">
                            <strong>🎓 ¡Felicidades!</strong> Tu certificado te abrirá nuevas oportunidades profesionales
                        </div>
                    </div>
                    <div class="step-icon">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                            <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modalidades de Formación -->
    <section class="modalities-section section" style="background: #f8f9fa;">
        <div class="container">
            <div class="section-heading">
                <h2>Modalidades de Formación</h2>
                <p>Elige la que mejor se adapte a tus necesidades</p>
            </div>

            <div class="modalities-grid">
                <div class="modality-card">
                    <div class="modality-icon">💻</div>
                    <h3>Online</h3>
                    <p>Formación 100% online con acceso al campus virtual 24/7. Ideal para quienes necesitan flexibilidad horaria.</p>
                    <ul>
                        <li>Acceso 24/7</li>
                        <li>Tutorías online</li>
                        <li>Material descargable</li>
                        <li>Evaluación online</li>
                    </ul>
                </div>

                <div class="modality-card featured">
                    <div class="modality-badge">Más Popular</div>
                    <div class="modality-icon">🏫</div>
                    <h3>Presencial</h3>
                    <p>Clases en nuestras instalaciones con profesores especializados. Interacción directa y práctica.</p>
                    <ul>
                        <li>Clases en aula</li>
                        <li>Prácticas presenciales</li>
                        <li>Networking</li>
                        <li>Certificados oficiales</li>
                    </ul>
                </div>

                <div class="modality-card">
                    <div class="modality-icon">🔄</div>
                    <h3>Mixta</h3>
                    <p>Combina lo mejor de ambas modalidades. Parte online y parte presencial según el curso.</p>
                    <ul>
                        <li>Flexibilidad</li>
                        <li>Teoría online</li>
                        <li>Prácticas presenciales</li>
                        <li>Mejor aprovechamiento</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Bonificaciones -->
    <section class="bonifications-section section">
        <div class="container">
            <div class="bonifications-content">
                <div class="bonifications-text">
                    <h2>Formación Bonificada para Empresas</h2>
                    <p class="lead">Todas las empresas que cotizan por formación profesional tienen derecho a bonificar la formación de sus trabajadores.</p>
                    
                    <div class="bonifications-benefits">
                        <div class="benefit-item">
                            <span class="benefit-icon">✓</span>
                            <div>
                                <h4>Sin coste para la empresa</h4>
                                <p>La formación se financia con los créditos de formación de tu empresa</p>
                            </div>
                        </div>
                        <div class="benefit-item">
                            <span class="benefit-icon">✓</span>
                            <div>
                                <h4>Gestión completa</h4>
                                <p>Nos encargamos de toda la tramitación ante FUNDAE</p>
                            </div>
                        </div>
                        <div class="benefit-item">
                            <span class="benefit-icon">✓</span>
                            <div>
                                <h4>Mejora la cualificación</h4>
                                <p>Invierte en el desarrollo profesional de tu equipo</p>
                            </div>
                        </div>
                    </div>

                    <a href="#contact" class="btn btn-primary btn-lg">Consultar Bonificaciones</a>
                </div>
                <div class="bonifications-image">
                    <div class="image-placeholder">
                        <span class="placeholder-icon">💼</span>
                        <p>Formación Bonificada FUNDAE</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="final-cta-section section" style="background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%); color: white;">
        <div class="container">
            <div class="final-cta-content">
                <h2>¿Listo para Empezar?</h2>
                <p>Contacta con nosotros y te ayudaremos a encontrar el curso perfecto para ti</p>
                <div class="cta-buttons">
                    <a href="#contact" class="btn btn-white btn-lg">Solicitar Información</a>
                    <a href="<?php echo home_url('/cursos'); ?>" class="btn btn-outline-white btn-lg">Ver Catálogo de Cursos</a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
?>

<style>
/* Hero */
.como-funciona-hero {
    position: relative;
    background: linear-gradient(135deg, #0066cc 0%, #0052a3 50%, #003d7a 100%);
    padding: 100px 0 80px;
    overflow: hidden;
}

.como-funciona-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
    opacity: 0.3;
}

.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
}

.hero-badge {
    display: inline-block;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    color: white;
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 20px;
    border: 1px solid rgba(255,255,255,0.3);
}

.como-funciona-hero .page-title {
    font-size: 56px;
    font-weight: 800;
    color: white;
    margin-bottom: 20px;
}

.como-funciona-hero .page-subtitle {
    font-size: 22px;
    color: rgba(255,255,255,0.95);
    max-width: 700px;
    margin: 0 auto;
}

/* Timeline de Pasos */
.steps-timeline {
    max-width: 900px;
    margin: 0 auto;
    position: relative;
}

.steps-timeline::before {
    content: '';
    position: absolute;
    left: 40px;
    top: 60px;
    bottom: 60px;
    width: 2px;
    background: linear-gradient(to bottom, #0066cc, #0052a3);
}

.step-item {
    display: grid;
    grid-template-columns: 80px 1fr 100px;
    gap: 30px;
    margin-bottom: 60px;
    position: relative;
}

.step-number {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #0066cc, #0052a3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    font-weight: 800;
    color: white;
    box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3);
    position: relative;
    z-index: 2;
}

.step-content {
    background: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.step-content h3 {
    font-size: 28px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 15px;
}

.step-content p {
    font-size: 16px;
    line-height: 1.8;
    color: #495057;
    margin-bottom: 20px;
}

.step-features {
    list-style: none;
    padding: 0;
    margin: 20px 0;
}

.step-features li {
    padding: 8px 0 8px 30px;
    position: relative;
    color: #495057;
}

.step-features li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: #28a745;
    font-weight: bold;
    font-size: 18px;
}

.step-highlight {
    background: #e3f2fd;
    border-left: 4px solid #0066cc;
    padding: 15px;
    border-radius: 8px;
    margin-top: 20px;
}

.step-highlight.success {
    background: #d4edda;
    border-left-color: #28a745;
}

.step-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #0066cc;
    opacity: 0.3;
}

.step-cta {
    margin-top: 20px;
}

/* Modalidades */
.modalities-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
}

.modality-card {
    background: white;
    padding: 40px 30px;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    text-align: center;
    position: relative;
    transition: transform 0.3s ease;
}

.modality-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.modality-card.featured {
    border: 3px solid #0066cc;
}

.modality-badge {
    position: absolute;
    top: -15px;
    left: 50%;
    transform: translateX(-50%);
    background: #0066cc;
    color: white;
    padding: 6px 20px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
}

.modality-icon {
    font-size: 60px;
    margin-bottom: 20px;
}

.modality-card h3 {
    font-size: 24px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 15px;
}

.modality-card p {
    font-size: 15px;
    color: #495057;
    margin-bottom: 20px;
}

.modality-card ul {
    list-style: none;
    padding: 0;
    text-align: left;
}

.modality-card ul li {
    padding: 8px 0 8px 25px;
    position: relative;
    color: #495057;
    font-size: 14px;
}

.modality-card ul li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: #28a745;
    font-weight: bold;
}

/* Bonificaciones */
.bonifications-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}

.bonifications-text .lead {
    font-size: 18px;
    color: #495057;
    margin-bottom: 30px;
}

.bonifications-benefits {
    margin: 30px 0;
}

.benefit-item {
    display: flex;
    gap: 15px;
    margin-bottom: 25px;
}

.benefit-icon {
    width: 30px;
    height: 30px;
    background: #28a745;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-weight: bold;
}

.benefit-item h4 {
    font-size: 18px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 5px;
}

.benefit-item p {
    font-size: 15px;
    color: #495057;
    margin: 0;
}

.bonifications-image .image-placeholder {
    background: linear-gradient(135deg, #e9ecef 0%, #f8f9fa 100%);
    height: 400px;
    border-radius: 16px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 20px;
}

.bonifications-image .placeholder-icon {
    font-size: 100px;
    opacity: 0.5;
}

.bonifications-image p {
    font-size: 20px;
    font-weight: 700;
    color: #495057;
}

/* CTA Final */
.final-cta-content {
    text-align: center;
    padding: 40px 0;
}

.final-cta-content h2 {
    font-size: 42px;
    font-weight: 800;
    color: white;
    margin-bottom: 20px;
}

.final-cta-content p {
    font-size: 20px;
    color: rgba(255,255,255,0.95);
    margin-bottom: 30px;
}

.cta-buttons {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-white {
    background: white;
    color: #0066cc;
    border-color: white;
}

.btn-white:hover {
    background: #f8f9fa;
    color: #0052a3;
}

.btn-outline-white {
    background: transparent;
    color: white;
    border: 2px solid white;
}

.btn-outline-white:hover {
    background: white;
    color: #0066cc;
}

/* Responsive */
@media (max-width: 968px) {
    .como-funciona-hero .page-title {
        font-size: 42px;
    }
    
    .step-item {
        grid-template-columns: 60px 1fr;
        gap: 20px;
    }
    
    .step-icon {
        display: none;
    }
    
    .steps-timeline::before {
        left: 30px;
    }
    
    .step-number {
        width: 60px;
        height: 60px;
        font-size: 24px;
    }
    
    .bonifications-content {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .como-funciona-hero {
        padding: 60px 0 40px;
    }
    
    .como-funciona-hero .page-title {
        font-size: 32px;
    }
    
    .como-funciona-hero .page-subtitle {
        font-size: 18px;
    }
    
    .step-content {
        padding: 20px;
    }
    
    .step-content h3 {
        font-size: 22px;
    }
    
    .modalities-grid {
        grid-template-columns: 1fr;
    }
    
    .final-cta-content h2 {
        font-size: 28px;
    }
    
    .cta-buttons {
        flex-direction: column;
    }
}
</style>

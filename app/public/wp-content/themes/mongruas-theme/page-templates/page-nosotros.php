<?php
/**
 * Template Name: Página Sobre Nosotros
 * Template Post Type: page
 *
 * Página con historia, valores y equipo
 * 
 * @package Mongruas
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main page-nosotros">
    
    <!-- Hero mejorado -->
    <section class="page-hero about-hero">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <span class="hero-badge">Desde 2005</span>
                <h1 class="page-title">Sobre Nosotros</h1>
                <p class="page-subtitle">20 años formando profesionales en Talavera de la Reina</p>
                <div class="hero-quote">
                    <p>"La formación al alcance de todos"</p>
                    <span>- Ángel Barrios, Gerente</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Historia -->
    <section class="about-history">
        <div class="container">
            <div class="history-content">
                <div class="history-text">
                    <h2>Nuestra Historia</h2>
                    <p class="lead">Desde 2005, Formación y Enseñanza Mogruas ha sido un referente en formación profesional en Talavera de la Reina.</p>
                    
                    <p>Fundada por Ángel Barrios, nuestra empresa nació con la misión de hacer la formación accesible para todos. Durante estos 20 años, hemos evolucionado constantemente para adaptarnos a las necesidades del mercado laboral y ofrecer la mejor formación a nuestros alumnos.</p>
                    
                    <p>Hoy somos un centro acreditado por SEPE, delegación oficial de Global Preventium para Prevención de Riesgos Laborales, y contamos con más de 2000 cursos disponibles en nuestra plataforma de teleformación.</p>
                    
                    <div class="history-stats">
                        <div class="stat-item">
                            <span class="stat-number">20</span>
                            <span class="stat-label">Años de Experiencia</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">2000+</span>
                            <span class="stat-label">Cursos Disponibles</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">200+</span>
                            <span class="stat-label">Empresas Gestionadas</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">3</span>
                            <span class="stat-label">Certificados Acreditados</span>
                        </div>
                    </div>
                </div>
                
                <div class="history-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about-placeholder.jpg" alt="Mogruas Historia" onerror="this.style.display='none'">
                    <div class="image-placeholder">
                        <svg width="300" height="300" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Valores -->
    <section class="about-values">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title">Nuestros Valores</h2>
                <p class="section-description">Los principios que guían nuestro trabajo diario</p>
            </div>
            
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">🎓</div>
                    <h3>Excelencia Educativa</h3>
                    <p>Comprometidos con la calidad en cada curso y programa formativo</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">💡</div>
                    <h3>Innovación</h3>
                    <p>Incorporamos las últimas tecnologías, incluyendo 3 impresoras 3D</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">🤝</div>
                    <h3>Integridad</h3>
                    <p>Actuamos con transparencia y honestidad en todas nuestras relaciones</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">👥</div>
                    <h3>Orientación al Estudiante</h3>
                    <p>El éxito de nuestros alumnos es nuestra prioridad</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">🌟</div>
                    <h3>Colaboración</h3>
                    <p>Trabajamos en equipo con empresas y organismos oficiales</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">📈</div>
                    <h3>Desarrollo Continuo</h3>
                    <p>Mejoramos constantemente nuestros servicios y metodologías</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Acreditaciones -->
    <section class="about-certifications">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title">Acreditaciones y Colaboraciones</h2>
                <p class="section-description">Respaldados por las principales instituciones</p>
            </div>
            
            <div class="certifications-grid">
                <?php
                $certifications = get_field('certifications', 'option');
                
                if ($certifications):
                    foreach ($certifications as $cert):
                ?>
                    <div class="cert-item">
                        <img src="<?php echo esc_url($cert['certification_logo']); ?>" alt="<?php echo esc_attr($cert['certification_name']); ?>">
                    </div>
                <?php
                    endforeach;
                else:
                    // Logos por defecto
                ?>
                    <div class="cert-item">
                        <div class="cert-placeholder">SEPE</div>
                    </div>
                    <div class="cert-item">
                        <div class="cert-placeholder">Junta de Castilla-La Mancha</div>
                    </div>
                    <div class="cert-item">
                        <div class="cert-placeholder">Global Preventium</div>
                    </div>
                    <div class="cert-item">
                        <div class="cert-placeholder">Fundación Construcción</div>
                    </div>
                    <div class="cert-item">
                        <div class="cert-placeholder">Fundación Metal</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="about-cta">
        <div class="container text-center">
            <h2>¿Quieres formar parte de nuestra historia?</h2>
            <p>Únete a los miles de profesionales que han confiado en nosotros</p>
            <a href="/contacto" class="btn btn-primary btn-lg">Contacta con Nosotros</a>
        </div>
    </section>

</main>

<?php
get_footer();
?>

<style>
/* Estilos mejorados para página sobre nosotros */
.about-hero {
    position: relative;
    background: linear-gradient(135deg, #0066cc 0%, #0052a3 50%, #003d7a 100%);
    color: white;
    padding: 100px 0 80px;
    text-align: center;
    overflow: hidden;
}

.about-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
    opacity: 0.3;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%);
}

.hero-content {
    position: relative;
    z-index: 2;
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

.about-hero .page-title {
    font-size: 56px;
    font-weight: 800;
    margin-bottom: 20px;
    text-shadow: 0 2px 10px rgba(0,0,0,0.2);
}

.about-hero .page-subtitle {
    font-size: 22px;
    opacity: 0.95;
    margin-bottom: 30px;
}

.hero-quote {
    margin-top: 30px;
    padding: 20px;
    border-left: 4px solid rgba(255,255,255,0.5);
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    border-radius: 8px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.hero-quote p {
    font-size: 20px;
    font-style: italic;
    margin-bottom: 10px;
}

.hero-quote span {
    font-size: 14px;
    opacity: 0.8;
}

.about-history {
    padding: 80px 0;
}

.history-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}

.history-text h2 {
    font-size: 36px;
    font-weight: 700;
    color: var(--color-text-dark);
    margin-bottom: 20px;
}

.history-text .lead {
    font-size: 20px;
    font-weight: 600;
    color: var(--color-primary);
    margin-bottom: 20px;
    line-height: 1.5;
}

.history-text p {
    font-size: 16px;
    color: var(--color-text);
    line-height: 1.7;
    margin-bottom: 15px;
}

.history-stats {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
    margin-top: 40px;
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 48px;
    font-weight: 700;
    color: var(--color-primary);
    line-height: 1;
    margin-bottom: 10px;
}

.stat-label {
    display: block;
    font-size: 14px;
    color: var(--color-text);
    font-weight: 600;
}

.history-image {
    position: relative;
}

.history-image img {
    width: 100%;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.image-placeholder {
    width: 100%;
    height: 400px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ccc;
}

.about-values {
    padding: 80px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.value-card {
    background: white;
    padding: 40px 30px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    transition: transform 0.3s;
}

.value-card:hover {
    transform: translateY(-5px);
}

.value-icon {
    font-size: 48px;
    margin-bottom: 20px;
}

.value-card h3 {
    font-size: 20px;
    font-weight: 700;
    color: var(--color-text-dark);
    margin-bottom: 12px;
}

.value-card p {
    font-size: 15px;
    color: var(--color-text);
    line-height: 1.6;
}

.about-certifications {
    padding: 80px 0;
}

.certifications-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 40px;
    margin-top: 40px;
    align-items: center;
}

.cert-item {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.cert-item img {
    max-width: 100%;
    max-height: 80px;
    filter: grayscale(100%);
    opacity: 0.7;
    transition: all 0.3s;
}

.cert-item:hover img {
    filter: grayscale(0%);
    opacity: 1;
}

.cert-placeholder {
    padding: 20px;
    background: #f0f0f0;
    border-radius: 8px;
    font-weight: 600;
    color: #999;
    text-align: center;
}

.about-cta {
    background: linear-gradient(135deg, var(--color-primary) 0%, #0052a3 100%);
    color: white;
    padding: 80px 0;
}

.about-cta h2 {
    font-size: 36px;
    font-weight: 700;
    margin-bottom: 15px;
}

.about-cta p {
    font-size: 18px;
    opacity: 0.9;
    margin-bottom: 30px;
}

/* Responsive */
@media (max-width: 968px) {
    .about-history {
        padding: 60px 0;
    }
    
    .history-content {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .history-text h2 {
        font-size: 28px;
    }
    
    .history-text .lead {
        font-size: 18px;
    }
    
    .history-stats {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    
    .stat-number {
        font-size: 36px;
    }
    
    .about-values {
        padding: 60px 0;
    }
    
    .values-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .about-certifications {
        padding: 60px 0;
    }
    
    .certifications-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
    }
    
    .about-cta {
        padding: 60px 0;
    }
    
    .about-cta h2 {
        font-size: 28px;
    }
}
</style>

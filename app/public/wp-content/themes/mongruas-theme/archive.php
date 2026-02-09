<?php
/**
 * Archive Template
 * Muestra el catálogo de cursos
 * 
 * @package Mongruas
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main page-archive">
    
    <!-- Grid de cursos/anuncios -->
    <section class="courses-grid-section">
        <div class="container">
            <div class="courses-grid" id="courses-grid">
                <?php
                // Incluir el contenido de cursos por defecto
                include(locate_template('template-parts/courses-default.php'));
                ?>
            </div>
        </div>
    </section>

    <!-- CTA Cursos -->
    <section class="courses-cta">
        <div class="cta-overlay"></div>
        <div class="container">
            <div class="cta-content">
                <div class="cta-icon">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                    </svg>
                </div>
                <h2>Descubre Nuestro Catálogo de Cursos</h2>
                <p>Más de 2000 cursos de formación bonificada disponibles</p>
                <a href="https://www.plataformateleformacion.com" target="_blank" class="btn btn-campus">
                    <span>Ver Catálogo Completo</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
?>

<style>
/* Estilos para página de archivo/anuncios */

/* Hero */
.archive-hero {
    position: relative;
    background: linear-gradient(135deg, #0066cc 0%, #0052a3 50%, #003d7a 100%);
    padding: 100px 0 80px;
    overflow: hidden;
}

.archive-hero::before {
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
    background: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%);
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

.archive-hero .page-title {
    font-size: 56px;
    font-weight: 800;
    color: white;
    margin-bottom: 20px;
    text-shadow: 0 2px 10px rgba(0,0,0,0.2);
}

.archive-hero .page-subtitle {
    font-size: 22px;
    color: rgba(255,255,255,0.95);
    margin-bottom: 40px;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
}

/* Grid de cursos */
.courses-grid-section {
    padding: 60px 0;
    background: #f8f9fa;
}

.courses-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.course-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid #f0f0f0;
    position: relative;
}

.course-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--color-primary), var(--color-secondary));
    transform: scaleX(0);
    transition: transform 0.4s ease;
}

.course-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.12);
    border-color: var(--color-primary);
}

.course-card:hover::before {
    transform: scaleX(1);
}

.course-image {
    width: 100%;
    height: 200px;
    overflow: hidden;
}

.course-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.course-card:hover .course-image img {
    transform: scale(1.05);
}

.course-content {
    padding: 20px;
}

.course-meta {
    display: flex;
    gap: 10px;
    margin-bottom: 12px;
}

.course-category,
.course-level {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    padding: 4px 10px;
    border-radius: 12px;
}

.course-category {
    background: #e3f2fd;
    color: #1976d2;
}

.course-level {
    background: #f3e5f5;
    color: #7b1fa2;
}

.course-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--color-text-dark);
    margin-bottom: 10px;
    line-height: 1.3;
}

.course-excerpt {
    font-size: 14px;
    color: var(--color-text);
    line-height: 1.5;
    margin-bottom: 15px;
}

.course-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 15px;
    border-top: 1px solid #e0e0e0;
}

.course-duration {
    font-size: 13px;
    color: var(--color-text-light);
}

.course-link {
    color: var(--color-primary);
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    transition: gap 0.3s;
}

.course-link:hover {
    text-decoration: underline;
}

/* CTA Cursos */
.courses-cta {
    position: relative;
    background: linear-gradient(135deg, #0066cc 0%, #0052a3 50%, #003d7a 100%);
    color: white;
    padding: 100px 0;
    text-align: center;
    overflow: hidden;
}

.cta-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%);
}

.cta-content {
    position: relative;
    z-index: 2;
}

.cta-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 30px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    animation: float 3s ease-in-out infinite;
}

.courses-cta h2 {
    font-size: 42px;
    font-weight: 800;
    margin-bottom: 20px;
    text-shadow: 0 2px 10px rgba(0,0,0,0.2);
}

.courses-cta p {
    font-size: 20px;
    opacity: 0.95;
    margin-bottom: 40px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.btn-campus {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: white;
    color: var(--color-primary);
    padding: 18px 40px;
    border-radius: 50px;
    font-size: 18px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.btn-campus:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
    background: #f8f9fa;
}

.btn-campus svg {
    transition: transform 0.3s ease;
}

.btn-campus:hover svg {
    transform: translateX(5px);
}

/* Responsive */
@media (max-width: 968px) {
    .archive-hero {
        padding: 80px 0 60px;
    }
    
    .archive-hero .page-title {
        font-size: 42px;
    }
    
    .archive-hero .page-subtitle {
        font-size: 18px;
    }
    
    .courses-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }
}

@media (max-width: 768px) {
    .archive-hero {
        padding: 60px 0 40px;
    }
    
    .archive-hero .page-title {
        font-size: 32px;
    }
    
    .archive-hero .page-subtitle {
        font-size: 16px;
    }
    
    .courses-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .courses-cta {
        padding: 60px 0;
    }
    
    .courses-cta h2 {
        font-size: 28px;
    }
    
    .courses-cta p {
        font-size: 16px;
    }
    
    .btn-campus {
        padding: 16px 32px;
        font-size: 16px;
    }
}
</style>

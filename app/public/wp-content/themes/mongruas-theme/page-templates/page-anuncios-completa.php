<?php
/**
 * Template Name: Anuncios Completa
 * Template Post Type: page
 * 
 * Página completa de anuncios con todo el contenido
 *
 * @package Mongruas
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main page-anuncios-completa">
    
    <!-- SECCIÓN 0: Próximos Cursos (Carrusel Dinámico MODERNO) -->
    <?php
    // Obtener cursos desde el panel de gestión (mongruas_courses)
    $cursos = get_option('mongruas_courses', []);
    ?>
    
    <section id="proximos-cursos-carousel" class="proximos-cursos-modern-section">
        <div class="container">
            <div class="section-heading-modern">
                <h2>Próximos Cursos</h2>
                <p>Cursos que comenzarán próximamente. ¡Reserva tu plaza!</p>
            </div>

            <div class="carousel-modern-container">
                <div class="carousel-modern-wrapper">
                    <div class="carousel-modern-track" id="modernCarouselTrack">
                        <?php if ($cursos && count($cursos) > 0) : ?>
                            <?php foreach ($cursos as $index => $curso) : ?>
                            <div class="modern-course-card">
                                <div class="modern-card-header">
                                    <span class="modern-badge"><?php echo esc_html($curso['date']); ?></span>
                                </div>
                                <div class="modern-card-body">
                                    <h3 class="modern-title"><?php echo esc_html($curso['name']); ?></h3>
                                    <p class="modern-description"><?php echo esc_html($curso['description']); ?></p>
                                    
                                    <div class="modern-details">
                                        <div class="modern-detail-item">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                                <line x1="8" y1="21" x2="16" y2="21"></line>
                                                <line x1="12" y1="17" x2="12" y2="21"></line>
                                            </svg>
                                            <span><?php echo esc_html($curso['modality']); ?></span>
                                        </div>
                                        <div class="modern-detail-item">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            </svg>
                                            <span><?php echo esc_html($curso['duration']); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modern-card-footer">
                                    <a href="<?php echo home_url('/curso-detalle.php?id=' . $index); ?>" class="modern-btn modern-btn-outline">
                                        <span>Ver más</span>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </a>
                                    <a href="<?php echo home_url('/contacto/#contact'); ?>" class="modern-btn modern-btn-primary">
                                        <span>Inscribirse</span>
                                    </a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="modern-course-card">
                                <div class="modern-card-body">
                                    <h3 class="modern-title">No hay cursos disponibles</h3>
                                    <p class="modern-description">Vuelve pronto para ver las novedades.</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Botones de navegación modernos -->
                <button class="modern-nav-btn modern-nav-prev" id="modernPrevBtn" aria-label="Anterior">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>
                <button class="modern-nav-btn modern-nav-next" id="modernNextBtn" aria-label="Siguiente">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </div>

            <!-- Indicadores de puntos -->
            <div class="modern-carousel-dots" id="modernCarouselDots"></div>
        </div>
    </section>
    
    <!-- SECCIÓN 1: Certificados de Profesionalidad -->
    <section class="certificados-section">
        <div class="container">
            <h2 class="section-title">Certificados de Profesionalidad Acreditados</h2>
            <p class="section-subtitle">Empresa acreditada en el Registro Estatal de Entidades de Formación de Castilla-La Mancha</p>
            
            <div class="certificados-grid">
                <div class="certificado-card">
                    <div class="certificado-icon">⚡</div>
                    <h3>Montaje y Mantenimiento de Instalaciones Eléctricas de Baja Tensión</h3>
                    <p class="certificado-code">ELEE0109</p>
                    <p class="certificado-info">RD 683/2011, de 13 de mayo</p>
                </div>
                
                <div class="certificado-card">
                    <div class="certificado-icon">🏠</div>
                    <h3>Montaje y Mantenimiento de Sistemas Domóticos e Inmóticos</h3>
                    <p class="certificado-code">ELEM0111</p>
                    <p class="certificado-info">Formación profesional para el empleo</p>
                </div>
                
                <div class="certificado-card">
                    <div class="certificado-icon">🐛</div>
                    <h3>Servicios para el Control de Plagas</h3>
                    <p class="certificado-code">SEAG0110</p>
                    <p class="certificado-info">Certificado de profesionalidad oficial</p>
                </div>
            </div>
            
            <div class="certificados-actions">
                <a href="https://e-empleo.jccm.es/formacion/jsp/solicitudes/busquedaGrupos.jsp#ANCLA" target="_blank" class="btn btn-green">📚 Ver Catálogo Completo</a>
            </div>
        </div>
    </section>
    
    <!-- SECCIÓN 2: Además Tenemos +2000 Cursos Online -->
    <section class="cursos-online-section">
        <div class="container">
            <h2 class="section-title">Además Tenemos +2000 Cursos Online</h2>
            <p class="section-subtitle">Formación bonificada disponible en nuestra campus virtual</p>
            
            <div class="cursos-grid">
                <div class="curso-category">
                    <div class="category-icon">💻</div>
                    <h3>Informática y Tecnología</h3>
                    <p>Office avanzado, diseño web, bases de datos, programación...</p>
                    <ul class="category-list">
                        <li>Excel Avanzado</li>
                        <li>Programación</li>
                        <li>Diseño Web</li>
                        <li>Base de Datos</li>
                    </ul>
                </div>
                
                <div class="curso-category">
                    <div class="category-icon">🌍</div>
                    <h3>Idiomas</h3>
                    <p>Inglés, francés, alemán y otros idiomas profesionales</p>
                    <ul class="category-list">
                        <li>Inglés Empresarial</li>
                        <li>Francés Empresarial</li>
                        <li>Alemán de Negocios</li>
                        <li>Otros idiomas</li>
                    </ul>
                </div>
                
                <div class="curso-category">
                    <div class="category-icon">📊</div>
                    <h3>Gestión Empresarial</h3>
                    <p>Administración, contabilidad, recursos humanos y liderazgo</p>
                    <ul class="category-list">
                        <li>Gestión Empresarial</li>
                        <li>Gestión de Proyectos</li>
                        <li>Contabilidad</li>
                        <li>Recursos Humanos</li>
                    </ul>
                </div>
                
                <div class="curso-category">
                    <div class="category-icon">📱</div>
                    <h3>Marketing y Ventas</h3>
                    <p>Marketing digital, redes sociales, comercio electrónico</p>
                    <ul class="category-list">
                        <li>Marketing Digital</li>
                        <li>Redes Sociales</li>
                        <li>E-commerce</li>
                        <li>SEO y SEM</li>
                    </ul>
                </div>
            </div>
            
            <div class="cursos-online-actions" style="text-align: center; margin-top: 40px;">
                <a href="https://www.plataformateleformacion.com/lcursos/cursos_elearning.php" target="_blank" class="btn btn-primary btn-lg">📚 Ver Todos los Cursos Online</a>
            </div>
        </div>
    </section>
    
    <!-- SECCIÓN 3: Explora Nuestros Cursos por Modalidad -->
    <section class="modalidades-section">
        <div class="container">
            <h2 class="section-title">Explora Nuestros Cursos por Modalidad</h2>
            
            <div class="modalidades-grid">
                <div class="modalidad-card">
                    <div class="modalidad-icon">🎓</div>
                    <h3>Cursos E-Learning</h3>
                    <p>Formación online con tutorización</p>
                    <a href="https://www.plataformateleformacion.com/lcursos/cursos_elearning.php" target="_blank" class="modalidad-link">→</a>
                </div>
                
                <div class="modalidad-card">
                    <div class="modalidad-icon">📜</div>
                    <h3>Certificados Profesionales</h3>
                    <p>Formación oficial acreditada</p>
                    <a href="https://www.plataformateleformacion.com/lcursos/cursos_certificados.php" target="_blank" class="modalidad-link">→</a>
                </div>
                
                <div class="modalidad-card">
                    <div class="modalidad-icon">📚</div>
                    <h3>Material Didáctico</h3>
                    <p>Recursos y materiales de apoyo</p>
                    <a href="https://www.plataformateleformacion.com/lcursos/libros.php" target="_blank" class="modalidad-link">→</a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- SECCIÓN 4: Catálogos de Cursos (Tarjetas de Colores) -->
    <section class="catalogos-section">
        <div class="container">
            <div class="catalogos-grid">
                <div class="catalogo-card catalogo-purple">
                    <div class="catalogo-badge">Más de 500 cursos</div>
                    <div class="catalogo-icon">💻</div>
                    <div class="catalogo-content">
                        <span class="catalogo-tag">INFORMÁTICA</span>
                        <span class="catalogo-tag-alt">CURSOS DISPONIBLES</span>
                        <h3>Catálogo de Informática y Tecnología</h3>
                        <p>Cursos especializados en tecnología, programación y herramientas digitales</p>
                        <div class="catalogo-stats">
                            <span>📚 +500 cursos</span>
                            <a href="https://www.plataformateleformacion.com/lcursos/cursos_elearning.php" target="_blank" class="catalogo-btn">Ver Cursos</a>
                        </div>
                    </div>
                </div>
                
                <div class="catalogo-card catalogo-pink">
                    <div class="catalogo-badge">Más de 300 cursos</div>
                    <div class="catalogo-icon">🌍</div>
                    <div class="catalogo-content">
                        <span class="catalogo-tag">IDIOMAS</span>
                        <span class="catalogo-tag-alt">CURSOS DISPONIBLES</span>
                        <h3>Catálogo de Idiomas</h3>
                        <p>Inglés, francés, alemán y otros idiomas para profesionales</p>
                        <div class="catalogo-stats">
                            <span>📚 +300 cursos</span>
                            <a href="https://www.plataformateleformacion.com/lcursos/cursos_elearning.php" target="_blank" class="catalogo-btn">Ver Cursos</a>
                        </div>
                    </div>
                </div>
                
                <div class="catalogo-card catalogo-blue">
                    <div class="catalogo-badge">Más de 400 cursos</div>
                    <div class="catalogo-icon">📊</div>
                    <div class="catalogo-content">
                        <span class="catalogo-tag">GESTIÓN</span>
                        <span class="catalogo-tag-alt">CURSOS DISPONIBLES</span>
                        <h3>Catálogo de Gestión Empresarial</h3>
                        <p>Administración, contabilidad, recursos humanos y liderazgo empresarial</p>
                        <div class="catalogo-stats">
                            <span>📚 +400 cursos</span>
                            <a href="https://www.plataformateleformacion.com/lcursos/cursos_elearning.php" target="_blank" class="catalogo-btn">Ver Cursos</a>
                        </div>
                    </div>
                </div>
                
                <div class="catalogo-card catalogo-green">
                    <div class="catalogo-badge">Más de 250 cursos</div>
                    <div class="catalogo-icon">📱</div>
                    <div class="catalogo-content">
                        <span class="catalogo-tag">MARKETING</span>
                        <span class="catalogo-tag-alt">CURSOS DISPONIBLES</span>
                        <h3>Catálogo de Marketing Digital</h3>
                        <p>Marketing online, redes sociales, SEO, SEM y comercio electrónico</p>
                        <div class="catalogo-stats">
                            <span>📚 +250 cursos</span>
                            <a href="https://www.plataformateleformacion.com/lcursos/cursos_elearning.php" target="_blank" class="catalogo-btn">Ver Cursos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

</main>

<style>
/* ESTILOS GENERALES MEJORADOS */
.page-anuncios-completa {
    background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
}

/* ========================================
   CARRUSEL MODERNO DE PRÓXIMOS CURSOS
   ======================================== */

.proximos-cursos-modern-section {
    padding: 100px 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
}

.proximos-cursos-modern-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255,255,255,0.1) 0%, transparent 50%);
    pointer-events: none;
}

.section-heading-modern {
    text-align: center;
    margin-bottom: 60px;
    position: relative;
    z-index: 1;
}

.section-heading-modern h2 {
    color: white;
    font-size: 3rem;
    margin-bottom: 15px;
    font-weight: 800;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    letter-spacing: -1px;
}

.section-heading-modern p {
    color: rgba(255, 255, 255, 0.95);
    font-size: 1.2rem;
    font-weight: 400;
}

.carousel-modern-container {
    position: relative;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 80px;
}

.carousel-modern-wrapper {
    overflow: hidden;
    border-radius: 20px;
}

.carousel-modern-track {
    display: flex !important;
    flex-direction: row !important;
    flex-wrap: nowrap !important;
    transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    gap: 30px;
    width: 100%;
}

.modern-course-card {
    flex: 0 0 calc(33.333% - 20px) !important;
    min-width: calc(33.333% - 20px) !important;
    max-width: calc(33.333% - 20px) !important;
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    display: flex !important;
    flex-direction: column !important;
}

.modern-course-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
}

.modern-card-header {
    padding: 20px 25px 15px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.modern-badge {
    background: linear-gradient(135deg, #27ae60, #229954);
    color: white;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
    box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
}

.modern-card-body {
    padding: 25px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.modern-title {
    font-size: 1.3rem;
    color: #2c3e50;
    margin-bottom: 12px;
    font-weight: 700;
    line-height: 1.4;
}

.modern-description {
    color: #6c757d;
    line-height: 1.6;
    margin-bottom: 20px;
    font-size: 0.95rem;
    flex-grow: 1;
}

.modern-details {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
    padding-top: 15px;
    border-top: 1px solid #e9ecef;
}

.modern-detail-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #495057;
    font-weight: 600;
    font-size: 0.85rem;
}

.modern-detail-item svg {
    color: #667eea;
    flex-shrink: 0;
}

.modern-card-footer {
    padding: 0 25px 25px;
    display: flex;
    gap: 12px;
}

.modern-btn {
    flex: 1;
    padding: 12px 20px;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 700;
    text-decoration: none;
    text-align: center;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border: none;
    cursor: pointer;
}

.modern-btn-outline {
    background: white;
    color: #667eea;
    border: 2px solid #667eea;
}

.modern-btn-outline:hover {
    background: #667eea;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
}

.modern-btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
}

.modern-btn-primary:hover {
    background: linear-gradient(135deg, #764ba2, #667eea);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

/* Botones de navegación modernos */
.modern-nav-btn {
    position: absolute !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: white;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 100 !important;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    color: #667eea;
    pointer-events: auto !important;
}

.modern-nav-btn:hover {
    background: #667eea;
    color: white;
    transform: translateY(-50%) scale(1.1) !important;
    box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
}

.modern-nav-btn:active {
    transform: translateY(-50%) scale(0.95) !important;
}

.modern-nav-btn:disabled {
    opacity: 0.3;
    cursor: not-allowed;
    pointer-events: none !important;
}

.modern-nav-prev {
    left: 10px !important;
}

.modern-nav-next {
    right: 10px !important;
}

/* Indicadores de puntos modernos */
.modern-carousel-dots {
    display: flex !important;
    flex-direction: row !important;
    justify-content: center !important;
    align-items: center !important;
    gap: 12px !important;
    margin-top: 50px;
    width: 100%;
}

.modern-carousel-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.4);
    border: none;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    padding: 0;
}

.modern-carousel-dot:hover {
    background: rgba(255, 255, 255, 0.7);
    transform: scale(1.3);
}

.modern-carousel-dot.active {
    background: white;
    width: 32px;
    border-radius: 5px;
    box-shadow: 0 4px 15px rgba(255, 255, 255, 0.4);
}

/* Responsive */
@media (max-width: 1024px) {
    .modern-course-card {
        flex: 0 0 calc(50% - 15px) !important;
        min-width: calc(50% - 15px) !important;
        max-width: calc(50% - 15px) !important;
    }
    
    .section-heading-modern h2 {
        font-size: 2.5rem;
    }
}

@media (max-width: 768px) {
    .proximos-cursos-modern-section {
        padding: 80px 0;
    }
    
    .carousel-modern-container {
        padding: 0 60px;
    }
    
    .modern-course-card {
        flex: 0 0 100% !important;
        min-width: 100% !important;
        max-width: 100% !important;
    }
    
    .section-heading-modern h2 {
        font-size: 2rem;
    }
    
    .modern-nav-btn {
        width: 48px;
        height: 48px;
    }
    
    .modern-card-footer {
        flex-direction: column;
    }
}

@media (max-width: 480px) {
    .carousel-modern-container {
        padding: 0 50px;
    }
    
    .modern-nav-btn {
        width: 40px;
        height: 40px;
    }
    
    .modern-nav-prev {
        left: 5px;
    }
    
    .modern-nav-next {
        right: 5px;
    }
}

/* ESTILOS GENERALES CONTINUACIÓN */
.container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
}

.section-title {
    font-size: 2.3rem;
    color: #2c3e50;
    text-align: center;
    margin-bottom: 15px;
    font-weight: 800;
    letter-spacing: -0.5px;
}

.section-subtitle {
    text-align: center;
    color: #6c757d;
    font-size: 1rem;
    margin-bottom: 50px;
    font-weight: 400;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
}

/* CERTIFICADOS SECTION - MEJORADO Y MÁS COMPACTO - LAYOUT HORIZONTAL */
.certificados-section {
    padding: 60px 0;
    background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
}

.certificados-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}

.certificado-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 6px 25px rgba(0,0,0,0.08);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: 2px solid transparent;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 220px;
}

.certificado-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #0066cc, #00a8ff);
    transform: scaleX(0);
    transition: transform 0.4s ease;
}

.certificado-card:hover::before {
    transform: scaleX(1);
}

.certificado-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.12);
    border-color: rgba(0, 102, 204, 0.1);
}

.certificado-icon {
    font-size: 2.2rem;
    margin-bottom: 12px;
    filter: drop-shadow(0 3px 6px rgba(0,0,0,0.1));
}

.certificado-card h3 {
    font-size: 0.95rem;
    color: #2c3e50;
    margin-bottom: 10px;
    font-weight: 700;
    line-height: 1.3;
    flex-grow: 1;
}

.certificado-code {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    display: inline-block;
    font-weight: 800;
    margin-bottom: 8px;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
    box-shadow: 0 3px 12px rgba(0, 102, 204, 0.3);
}

.certificado-info {
    color: #6c757d;
    font-size: 0.8rem;
    font-weight: 500;
}

.certificados-actions {
    display: flex;
    justify-content: center;
    margin-top: 10px;
}

.btn {
    padding: 14px 30px;
    border-radius: 40px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.9rem;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    display: inline-block;
    box-shadow: 0 3px 12px rgba(0,0,0,0.1);
    border: none;
    cursor: pointer;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.18);
}

.btn-red {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
}

.btn-red:hover {
    background: linear-gradient(135deg, #c0392b, #a93226);
}

.btn-green {
    background: linear-gradient(135deg, #27ae60, #229954);
    color: white;
}

.btn-green:hover {
    background: linear-gradient(135deg, #229954, #1e8449);
}

.btn-blue {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
}

.btn-blue:hover {
    background: linear-gradient(135deg, #2980b9, #1f618d);
}

/* CURSOS ONLINE SECTION - MEJORADO Y COMPACTO */
.cursos-online-section {
    padding: 80px 0;
    background: white;
}

.cursos-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 25px;
}

.curso-category {
    background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
    border-radius: 16px;
    padding: 25px;
    text-align: center;
    box-shadow: 0 6px 25px rgba(0,0,0,0.08);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: 2px solid transparent;
}

.curso-category:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.12);
    border-color: rgba(0, 102, 204, 0.1);
}

.category-icon {
    font-size: 2.5rem;
    margin-bottom: 12px;
    filter: drop-shadow(0 3px 6px rgba(0,0,0,0.1));
}

.curso-category h3 {
    font-size: 1rem;
    color: #2c3e50;
    margin-bottom: 10px;
    font-weight: 700;
}

.curso-category p {
    color: #6c757d;
    margin-bottom: 15px;
    font-size: 0.85rem;
    line-height: 1.4;
}

.category-list {
    list-style: none;
    padding: 0;
    text-align: left;
}

.category-list li {
    padding: 8px 0;
    color: #495057;
    font-size: 0.85rem;
    border-bottom: 1px solid #e9ecef;
    transition: all 0.3s ease;
    padding-left: 18px;
    position: relative;
}

.category-list li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: #27ae60;
    font-weight: bold;
}

.category-list li:hover {
    color: #0066cc;
    padding-left: 22px;
}

.category-list li:last-child {
    border-bottom: none;
}

/* MODALIDADES SECTION - MEJORADO Y COMPACTO */
.modalidades-section {
    padding: 80px 0;
    background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
}

.modalidades-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
}

.modalidad-card {
    background: white;
    border-radius: 16px;
    padding: 30px;
    text-align: center;
    box-shadow: 0 6px 25px rgba(0,0,0,0.08);
    position: relative;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: 2px solid transparent;
}

.modalidad-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 12px 40px rgba(0,0,0,0.12);
    border-color: rgba(0, 102, 204, 0.2);
}

.modalidad-icon {
    font-size: 2.8rem;
    margin-bottom: 15px;
    filter: drop-shadow(0 3px 6px rgba(0,0,0,0.1));
}

.modalidad-card h3 {
    font-size: 1.1rem;
    color: #2c3e50;
    margin-bottom: 10px;
    font-weight: 700;
}

.modalidad-card p {
    color: #6c757d;
    margin-bottom: 20px;
    font-size: 0.9rem;
}

.modalidad-link {
    color: #0066cc;
    font-size: 2rem;
    text-decoration: none;
    font-weight: 700;
    transition: all 0.3s ease;
    display: inline-block;
}

.modalidad-link:hover {
    transform: translateX(8px);
    color: #0052a3;
}

/* CATÁLOGOS SECTION - MEJORADO Y COMPACTO */
.catalogos-section {
    padding: 80px 0;
    background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
}

.catalogos-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 25px;
}

.catalogo-card {
    border-radius: 20px;
    padding: 30px;
    color: white;
    position: relative;
    overflow: hidden;
    min-height: 240px;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
}

.catalogo-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 15px 50px rgba(0,0,0,0.22);
}

.catalogo-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    transition: all 0.6s ease;
}

.catalogo-card:hover::before {
    top: -60%;
    right: -60%;
}

.catalogo-purple {
    background: linear-gradient(135deg, #6c5ce7, #5f3dc4);
}

.catalogo-pink {
    background: linear-gradient(135deg, #fd79a8, #e84393);
}

.catalogo-blue {
    background: linear-gradient(135deg, #74b9ff, #0984e3);
}

.catalogo-green {
    background: linear-gradient(135deg, #55efc4, #00b894);
}

.catalogo-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    background: rgba(255,255,255,0.25);
    backdrop-filter: blur(10px);
    padding: 8px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    border: 1px solid rgba(255,255,255,0.3);
}

.catalogo-icon {
    font-size: 3.5rem;
    margin-bottom: 20px;
    filter: drop-shadow(0 6px 12px rgba(0,0,0,0.2));
}

.catalogo-tag {
    background: rgba(255,255,255,0.3);
    backdrop-filter: blur(5px);
    padding: 6px 12px;
    border-radius: 16px;
    font-size: 0.7rem;
    font-weight: 700;
    display: inline-block;
    margin-right: 8px;
    border: 1px solid rgba(255,255,255,0.2);
}

.catalogo-tag-alt {
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(5px);
    padding: 6px 12px;
    border-radius: 16px;
    font-size: 0.7rem;
    font-weight: 700;
    display: inline-block;
    border: 1px solid rgba(255,255,255,0.15);
}

.catalogo-content h3 {
    font-size: 1.3rem;
    margin: 15px 0;
    font-weight: 800;
    line-height: 1.3;
}

.catalogo-content p {
    margin-bottom: 20px;
    opacity: 0.95;
    font-size: 0.9rem;
    line-height: 1.4;
}

.catalogo-stats {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
}

.catalogo-btn {
    background: white;
    color: #2c3e50;
    padding: 10px 20px;
    border-radius: 20px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    box-shadow: 0 3px 12px rgba(0,0,0,0.2);
}

.catalogo-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 18px rgba(0,0,0,0.3);
}

/* RESPONSIVE MEJORADO */
@media (max-width: 1024px) {
    .certificados-grid,
    .modalidades-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .cursos-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .proximos-cursos-carousel-section {
        padding: 70px 0;
    }
    
    .certificados-section,
    .cursos-online-section,
    .modalidades-section,
    .catalogos-section {
        padding: 70px 0;
    }
}

@media (max-width: 768px) {
    .certificados-grid,
    .cursos-grid,
    .modalidades-grid,
    .catalogos-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .section-title {
        font-size: 1.8rem;
    }
    
    .section-subtitle {
        font-size: 0.9rem;
    }
    
    .proximos-cursos-carousel-section .section-heading h2 {
        font-size: 2rem;
    }
    
    .certificados-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        text-align: center;
    }
    
    .proximos-cursos-carousel-section,
    .certificados-section,
    .cursos-online-section,
    .modalidades-section,
    .catalogos-section,
    .ubicacion-section {
        padding: 50px 0;
    }
    
    .direccion-box {
        padding: 25px;
    }
}
</style>

<script>
(function() {
    'use strict';
    
    // Esperar a que el DOM esté completamente cargado
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCarousel);
    } else {
        initCarousel();
    }
    
    function initCarousel() {
        const track = document.getElementById('modernCarouselTrack');
        const prevBtn = document.getElementById('modernPrevBtn');
        const nextBtn = document.getElementById('modernNextBtn');
        const dotsContainer = document.getElementById('modernCarouselDots');
        
        if (!track || !prevBtn || !nextBtn || !dotsContainer) return;
        
        const cards = track.querySelectorAll('.modern-course-card');
        if (cards.length === 0) return;
        
        let currentIndex = 0;
        let cardsPerView = 3;
        
        function getCardsPerView() {
            const width = window.innerWidth;
            return width <= 768 ? 1 : width <= 1024 ? 2 : 3;
        }
        
        function updateCardsPerView() {
            cardsPerView = getCardsPerView();
        }
        
        updateCardsPerView();
        let maxIndex = Math.max(0, cards.length - cardsPerView);
        
        function createDots() {
            dotsContainer.innerHTML = '';
            maxIndex = Math.max(0, cards.length - cardsPerView);
            
            for (let i = 0; i <= maxIndex; i++) {
                const dot = document.createElement('button');
                dot.className = 'modern-carousel-dot';
                dot.setAttribute('aria-label', 'Ir a diapositiva ' + (i + 1));
                dot.onclick = function() { goToSlide(i); };
                if (i === currentIndex) dot.classList.add('active');
                dotsContainer.appendChild(dot);
            }
        }
        
        function updateCarousel() {
            const cardWidth = cards[0].offsetWidth;
            const gap = 30;
            const offset = -(currentIndex * (cardWidth + gap));
            track.style.transform = 'translateX(' + offset + 'px)';
            
            const dots = dotsContainer.querySelectorAll('.modern-carousel-dot');
            dots.forEach(function(dot, index) {
                if (index === currentIndex) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
            
            prevBtn.disabled = currentIndex === 0;
            nextBtn.disabled = currentIndex >= maxIndex;
            prevBtn.style.opacity = currentIndex === 0 ? '0.3' : '1';
            nextBtn.style.opacity = currentIndex >= maxIndex ? '0.3' : '1';
        }
        
        function nextSlide() {
            if (currentIndex < maxIndex) {
                currentIndex++;
                updateCarousel();
            }
        }
        
        function prevSlide() {
            if (currentIndex > 0) {
                currentIndex--;
                updateCarousel();
            }
        }
        
        function goToSlide(index) {
            if (index >= 0 && index <= maxIndex) {
                currentIndex = index;
                updateCarousel();
            }
        }
        
        prevBtn.onclick = prevSlide;
        nextBtn.onclick = nextSlide;
        
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                const oldCardsPerView = cardsPerView;
                updateCardsPerView();
                
                if (oldCardsPerView !== cardsPerView) {
                    currentIndex = Math.min(currentIndex, Math.max(0, cards.length - cardsPerView));
                    createDots();
                }
                updateCarousel();
            }, 250);
        });
        
        let touchStartX = 0;
        let touchEndX = 0;
        
        track.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });
        
        track.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            const diff = touchStartX - touchEndX;
            
            if (Math.abs(diff) > 50) {
                if (diff > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
            }
        });
        
        createDots();
        updateCarousel();
    }
})();
</script>

<?php
get_footer();
?>

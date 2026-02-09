<?php
/**
 * Template Name: Página de Cursos
 * Template for displaying courses page with dynamic carousel
 *
 * @package Mongruas
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main page-cursos">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">📚 Próximos Cursos</h1>
            <p class="page-description">Descubre nuestra oferta formativa actualizada con cursos certificados</p>
        </div>
        
        <!-- CARRUSEL DE CURSOS RESTAURADO -->
        <div class="cursos-carousel-wrapper">
            <?php
            // Llamar al carrusel dinámico de WordPress
            if (function_exists('mongruas_display_courses_carousel')) {
                echo mongruas_display_courses_carousel();
            }
            ?>
        </div>
        
        <div class="cursos-info">
            <div class="info-grid">
                <div class="info-item">
                    <h3>🎓 Certificaciones Oficiales</h3>
                    <p>Todos nuestros cursos están certificados y reconocidos oficialmente</p>
                </div>
                <div class="info-item">
                    <h3>👨‍🏫 Profesores Expertos</h3>
                    <p>Contamos con profesionales con más de 20 años de experiencia</p>
                </div>
                <div class="info-item">
                    <h3>🏗️ Prácticas Reales</h3>
                    <p>Instalaciones equipadas con maquinaria y herramientas profesionales</p>
                </div>
                <div class="info-item">
                    <h3>📞 Atención Personalizada</h3>
                    <p>Seguimiento individualizado durante todo el proceso formativo</p>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.page-cursos {
    padding: 60px 0;
    background: #f8f9fa;
}

.page-header {
    text-align: center;
    margin-bottom: 60px;
}

.page-title {
    font-size: 3rem;
    color: #2c3e50;
    margin-bottom: 15px;
    font-weight: 700;
}

.page-description {
    font-size: 1.2rem;
    color: #6c757d;
    max-width: 600px;
    margin: 0 auto;
}

.cursos-carousel-dynamic {
    margin: 60px 0;
}

.cursos-info {
    margin-top: 60px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
}

.info-item {
    background: white;
    padding: 30px;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.info-item:hover {
    transform: translateY(-5px);
}

.info-item h3 {
    font-size: 1.3rem;
    color: #0066cc;
    margin-bottom: 15px;
}

.info-item p {
    color: #6c757d;
    line-height: 1.6;
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
}
</style>

<?php
get_footer();
?>
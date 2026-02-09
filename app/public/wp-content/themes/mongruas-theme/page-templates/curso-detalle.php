<?php
/**
 * Página de Detalle de Curso
 * Muestra toda la información completa de un curso
 */

// Obtener ID del curso
$curso_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

// Obtener cursos del sistema
$courses = get_option("mongruas_courses", []);
$curso = null;

// Buscar el curso por ID
foreach ($courses as $c) {
    if (isset($c["id"]) && $c["id"] == $curso_id) {
        $curso = $c;
        break;
    }
}

// Si no se encuentra el curso, mostrar error
if (!$curso) {
    wp_redirect(home_url("/anuncios/"));
    exit;
}

get_header();
?>

<style>
.curso-detalle-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
    background: #f8f9fa;
    min-height: 100vh;
}

.curso-detalle-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.curso-hero {
    background: linear-gradient(135deg, #3498db, #27ae60);
    color: white;
    padding: 60px 40px;
    text-align: center;
    position: relative;
}

.curso-hero::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.1\"%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"4\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.3;
}

.curso-hero-content {
    position: relative;
    z-index: 2;
}

.curso-badge {
    background: rgba(255,255,255,0.2);
    color: white;
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 700;
    text-transform: uppercase;
    display: inline-block;
    margin-bottom: 20px;
    border: 2px solid rgba(255,255,255,0.3);
}

.curso-titulo {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 20px;
    line-height: 1.2;
}

.curso-fecha-grande {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
}

.curso-stats {
    display: flex;
    justify-content: center;
    gap: 40px;
    flex-wrap: wrap;
}

.stat-item {
    text-align: center;
    background: rgba(255,255,255,0.15);
    padding: 20px;
    border-radius: 15px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
}

.stat-icon {
    font-size: 2rem;
    margin-bottom: 10px;
    display: block;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
    margin-bottom: 5px;
}

.stat-value {
    font-size: 1.2rem;
    font-weight: 700;
}

.curso-content {
    padding: 50px 40px;
}

.content-section {
    margin-bottom: 40px;
}

.section-title {
    font-size: 2rem;
    color: #2c3e50;
    margin-bottom: 20px;
    font-weight: 700;
    position: relative;
    padding-bottom: 10px;
}

.section-title::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, #3498db, #27ae60);
    border-radius: 2px;
}

.descripcion-completa {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #555;
    background: #f8f9fa;
    padding: 30px;
    border-radius: 15px;
    border-left: 5px solid #3498db;
}

.detalles-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 30px;
}

.detalle-card {
    background: #f8f9fa;
    padding: 25px;
    border-radius: 15px;
    text-align: center;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.detalle-card:hover {
    border-color: #3498db;
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(52, 152, 219, 0.1);
}

.detalle-icon {
    font-size: 2.5rem;
    margin-bottom: 15px;
    color: #3498db;
}

.detalle-titulo {
    font-size: 1.1rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 10px;
}

.detalle-valor {
    font-size: 1rem;
    color: #666;
}

.acciones-container {
    background: linear-gradient(135deg, #2c3e50, #34495e);
    color: white;
    padding: 40px;
    text-align: center;
    border-radius: 20px;
    margin-top: 40px;
}

.acciones-titulo {
    font-size: 2rem;
    margin-bottom: 20px;
    font-weight: 700;
}

.acciones-descripcion {
    font-size: 1.1rem;
    margin-bottom: 30px;
    opacity: 0.9;
}

.botones-accion {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
}

.btn-accion {
    padding: 15px 30px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 700;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.btn-reservar {
    background: linear-gradient(135deg, #27ae60, #229954);
    color: white;
    box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
}

.btn-reservar:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(39, 174, 96, 0.4);
    color: white;
    text-decoration: none;
}

.btn-contacto {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
}

.btn-contacto:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4);
    color: white;
    text-decoration: none;
}

.btn-volver {
    background: rgba(255,255,255,0.2);
    color: white;
    border: 2px solid rgba(255,255,255,0.3);
}

.btn-volver:hover {
    background: rgba(255,255,255,0.3);
    color: white;
    text-decoration: none;
}

/* Responsive */
@media (max-width: 768px) {
    .curso-detalle-container {
        padding: 20px 15px;
    }
    
    .curso-hero {
        padding: 40px 20px;
    }
    
    .curso-titulo {
        font-size: 2.2rem;
    }
    
    .curso-content {
        padding: 30px 20px;
    }
    
    .curso-stats {
        gap: 20px;
    }
    
    .stat-item {
        padding: 15px;
    }
    
    .botones-accion {
        flex-direction: column;
        align-items: center;
    }
    
    .btn-accion {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
}
</style>

<div class="curso-detalle-container">
    
    <!-- Hero del Curso -->
    <div class="curso-detalle-card">
        <div class="curso-hero">
            <div class="curso-hero-content">
                <div class="curso-badge">Próximamente</div>
                <h1 class="curso-titulo"><?php echo esc_html($curso["name"]); ?></h1>
                <div class="curso-fecha-grande">
                    <span>📅</span>
                    <span><?php echo esc_html($curso["date"]); ?></span>
                </div>
                
                <div class="curso-stats">
                    <div class="stat-item">
                        <span class="stat-icon">⏱️</span>
                        <div class="stat-label">Plazas</div>
                        <div class="stat-value"><?php echo esc_html($curso["duration"]); ?></div>
                    </div>
                    <div class="stat-item">
                        <span class="stat-icon">💻</span>
                        <div class="stat-label">Modalidad</div>
                        <div class="stat-value"><?php echo esc_html($curso["modality"]); ?></div>
                    </div>
                    <?php if (isset($curso["hours"])): ?>
                    <div class="stat-item">
                        <span class="stat-icon">🕐</span>
                        <div class="stat-label">Duración</div>
                        <div class="stat-value"><?php echo esc_html($curso["hours"]); ?></div>
                    </div>
                    <?php endif; ?>
                    <?php if (isset($curso["price"])): ?>
                    <div class="stat-item">
                        <span class="stat-icon">💰</span>
                        <div class="stat-label">Precio</div>
                        <div class="stat-value"><?php echo esc_html($curso["price"]); ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Contenido del Curso -->
        <div class="curso-content">
            
            <!-- Descripción -->
            <div class="content-section">
                <h2 class="section-title">Descripción del Curso</h2>
                <div class="descripcion-completa">
                    <?php 
                    $descripcion = isset($curso["full_description"]) ? $curso["full_description"] : $curso["description"];
                    echo esc_html($descripcion); 
                    ?>
                </div>
            </div>
            
            <!-- Detalles -->
            <div class="content-section">
                <h2 class="section-title">Detalles del Curso</h2>
                <div class="detalles-grid">
                    <div class="detalle-card">
                        <div class="detalle-icon">📚</div>
                        <div class="detalle-titulo">Modalidad</div>
                        <div class="detalle-valor"><?php echo esc_html($curso["modality"]); ?></div>
                    </div>
                    <div class="detalle-card">
                        <div class="detalle-icon">👥</div>
                        <div class="detalle-titulo">Plazas Disponibles</div>
                        <div class="detalle-valor"><?php echo esc_html($curso["duration"]); ?></div>
                    </div>
                    <?php if (isset($curso["hours"])): ?>
                    <div class="detalle-card">
                        <div class="detalle-icon">⏰</div>
                        <div class="detalle-titulo">Duración Total</div>
                        <div class="detalle-valor"><?php echo esc_html($curso["hours"]); ?></div>
                    </div>
                    <?php endif; ?>
                    <div class="detalle-card">
                        <div class="detalle-icon">📅</div>
                        <div class="detalle-titulo">Fecha de Inicio</div>
                        <div class="detalle-valor"><?php echo esc_html($curso["date"]); ?></div>
                    </div>
                    <?php if (isset($curso["price"])): ?>
                    <div class="detalle-card">
                        <div class="detalle-icon">💰</div>
                        <div class="detalle-titulo">Precio</div>
                        <div class="detalle-valor"><?php echo esc_html($curso["price"]); ?></div>
                    </div>
                    <?php endif; ?>
                    <div class="detalle-card">
                        <div class="detalle-icon">🎓</div>
                        <div class="detalle-titulo">Certificado</div>
                        <div class="detalle-valor">Oficial</div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <!-- Acciones -->
    <div class="acciones-container">
        <h2 class="acciones-titulo">¿Te interesa este curso?</h2>
        <p class="acciones-descripcion">
            Reserva tu plaza ahora o contáctanos para más información
        </p>
        
        <div class="botones-accion">
            <a href="#contact" class="btn-accion btn-reservar">
                <span>🎯</span>
                <span>Reservar Plaza</span>
            </a>
            <a href="#contact" class="btn-accion btn-contacto">
                <span>📞</span>
                <span>Más Información</span>
            </a>
            <a href="<?php echo home_url("/anuncios/"); ?>" class="btn-accion btn-volver">
                <span>←</span>
                <span>Volver a Cursos</span>
            </a>
        </div>
    </div>
    
</div>

<?php get_footer(); ?>
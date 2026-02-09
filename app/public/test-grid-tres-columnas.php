<?php
/**
 * Test Grid de 3 Columnas - Próximos Cursos
 * Verificar que se muestren 3 cursos por fila como antes
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🎯 Test Grid de 3 Columnas</h1>";

// Obtener cursos actuales
$cursos_dinamicos = get_option('mongruas_courses', []);

echo "<h2>📊 Cursos Disponibles:</h2>";
if (!empty($cursos_dinamicos)) {
    echo "<div style='background: #d4edda; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
    echo "<strong>✅ ENCONTRADOS " . count($cursos_dinamicos) . " CURSOS</strong><br>";
    echo "Se mostrarán máximo 6 cursos en grid de 3 columnas";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
    echo "<strong>❌ NO HAY CURSOS - Se mostrarán los de ejemplo</strong>";
    echo "</div>";
}

echo "<h2>🎨 Vista Previa del Grid:</h2>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Grid 3 Columnas</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        }

        h1, h2 {
            color: #1a1a1a;
            text-align: center;
        }

        h1 {
            background: linear-gradient(135deg, #0066cc, #0052a3);
            color: white;
            padding: 30px;
            border-radius: 16px;
            margin-bottom: 30px;
        }

        /* Próximos Cursos */
        .upcoming-courses-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 20px;
            padding: 50px 40px;
            margin: 40px 0;
            border: 2px solid #e0e0e0;
        }

        .upcoming-courses-section .section-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .upcoming-courses-section h2 {
            font-size: 42px;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 10px;
        }

        .upcoming-courses-section p {
            font-size: 22px;
            color: #495057;
        }

        /* Grid fijo de 3 columnas */
        .upcoming-courses-grid-fixed {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .upcoming-course-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            border: 2px solid #e8e8e8;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            animation: slideInUp 0.6s ease-out;
        }

        .course-image-container {
            margin: -30px -30px 15px -30px;
            height: 180px;
            overflow: hidden;
            border-radius: 16px 16px 0 0;
        }

        .course-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .upcoming-course-card:hover .course-image {
            transform: scale(1.05);
        }

        .course-description {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
            margin: 10px 0;
            font-style: italic;
        }

        .upcoming-course-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #28a745, #20c997);
        }

        .upcoming-course-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 12px 30px rgba(0,0,0,0.15);
            border-color: #0066cc;
        }

        .course-date {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 14px;
            font-weight: 700;
            display: inline-block;
            margin-bottom: 15px;
        }

        .upcoming-course-card h3 {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .course-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .modalidad {
            background: #e9ecef;
            color: #495057;
            padding: 4px 12px;
            border-radius: 12px;
            font-weight: 600;
        }

        .plazas {
            background: #fff3cd;
            color: #856404;
            padding: 4px 12px;
            border-radius: 12px;
            font-weight: 600;
        }

        .course-buttons {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 15px;
            align-items: center;
        }

        .btn-ver-mas, .btn-reservar {
            display: inline-block;
            color: white;
            padding: 10px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            position: relative;
            overflow: hidden;
            width: 160px;
            text-align: center;
        }

        .btn-ver-mas {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            box-shadow: 0 4px 14px 0 rgba(30, 64, 175, 0.3);
        }

        .btn-reservar {
            background: linear-gradient(135deg, #059669, #10b981);
            box-shadow: 0 4px 14px 0 rgba(5, 150, 105, 0.3);
        }

        .btn-ver-mas:hover, .btn-reservar:hover {
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }

        .btn-ver-mas:hover {
            box-shadow: 0 8px 25px 0 rgba(30, 64, 175, 0.4);
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
        }

        .btn-reservar:hover {
            box-shadow: 0 8px 25px 0 rgba(5, 150, 105, 0.4);
            background: linear-gradient(135deg, #047857, #059669);
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .upcoming-courses-grid-fixed {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .course-details {
                flex-direction: column;
                gap: 10px;
                align-items: center;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .upcoming-courses-grid-fixed {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
        }

        .info-box {
            background: #e2e3e5;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="info-box">
    <strong>🎯 CONFIGURACIÓN ACTUAL:</strong><br>
    • Grid fijo de 3 columnas en desktop<br>
    • 2 columnas en tablet<br>
    • 1 columna en móvil<br>
    • Máximo 6 cursos mostrados<br>
    • Sin carrusel infinito<br>
</div>

<!-- Próximos Cursos -->
<div class="upcoming-courses-section">
    <div class="section-header">
        <h2>Próximos Cursos</h2>
        <p>Cursos que comenzarán próximamente. ¡Reserva tu plaza!</p>
    </div>
    
    <div class="upcoming-courses-grid-fixed">
        <?php
        if (!empty($cursos_dinamicos)):
            // Mostrar cursos del sistema dinámico (máximo 6)
            $cursos_mostrar = array_slice($cursos_dinamicos, 0, 6);
            foreach ($cursos_mostrar as $index => $curso):
        ?>
                <div class="upcoming-course-card">
                    <?php if (!empty($curso['image'])): ?>
                        <div class="course-image-container">
                            <img src="<?php echo esc_url($curso['image']); ?>" alt="<?php echo esc_attr($curso['name']); ?>" class="course-image" onerror="this.parentElement.style.display='none'">
                        </div>
                    <?php endif; ?>
                    
                    <div class="course-date">
                        <span class="date-text"><?php echo !empty($curso['date']) ? esc_html($curso['date']) : 'Próximamente'; ?></span>
                    </div>
                    <h3><?php echo esc_html($curso['name']); ?></h3>
                    
                    <?php if (!empty($curso['description'])): ?>
                        <p class="course-description"><?php echo esc_html($curso['description']); ?></p>
                    <?php endif; ?>
                    
                    <div class="course-details">
                        <span class="modalidad"><?php echo !empty($curso['modality']) ? esc_html($curso['modality']) : 'Presencial'; ?></span>
                        <span class="plazas"><?php echo !empty($curso['duration']) ? esc_html($curso['duration']) : 'Plazas limitadas'; ?></span>
                    </div>
                    <div class="course-buttons">
                        <a href="<?php echo home_url("/curso-info.php?curso=" . ($index + 1)); ?>" class="btn-ver-mas">Ver Más Info</a>
                        <a href="<?php echo home_url('/contacto'); ?>" class="btn-reservar">Reservar Plaza</a>
                    </div>
                </div>
        <?php
            endforeach;
        else:
            // Cursos de ejemplo si no hay datos en el sistema dinámico
        ?>
            <div class="upcoming-course-card">
                <div class="course-date">
                    <span class="date-text">Enero 2025</span>
                </div>
                <h3>Montaje y Mantenimiento de Instalaciones Eléctricas</h3>
                <p class="course-description">Curso completo de instalaciones eléctricas de baja tensión con certificado oficial.</p>
                <div class="course-details">
                    <span class="modalidad">Presencial</span>
                    <span class="plazas">15 plazas</span>
                </div>
                <div class="course-buttons">
                    <a href="#" class="btn-ver-mas">Ver Más Info</a>
                    <a href="#" class="btn-reservar">Reservar Plaza</a>
                </div>
            </div>
            
            <div class="upcoming-course-card">
                <div class="course-date">
                    <span class="date-text">Febrero 2025</span>
                </div>
                <h3>Sistemas Domóticos e Inmóticos</h3>
                <p class="course-description">Especialización en automatización de edificios y sistemas inteligentes.</p>
                <div class="course-details">
                    <span class="modalidad">Presencial</span>
                    <span class="plazas">12 plazas</span>
                </div>
                <div class="course-buttons">
                    <a href="#" class="btn-ver-mas">Ver Más Info</a>
                    <a href="#" class="btn-reservar">Reservar Plaza</a>
                </div>
            </div>
            
            <div class="upcoming-course-card">
                <div class="course-date">
                    <span class="date-text">Marzo 2025</span>
                </div>
                <h3>Control de Plagas</h3>
                <p class="course-description">Formación profesional en control y prevención de plagas urbanas.</p>
                <div class="course-details">
                    <span class="modalidad">Presencial</span>
                    <span class="plazas">10 plazas</span>
                </div>
                <div class="course-buttons">
                    <a href="#" class="btn-ver-mas">Ver Más Info</a>
                    <a href="#" class="btn-reservar">Reservar Plaza</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="info-box">
    <strong>✅ CAMBIOS APLICADOS:</strong><br>
    • Eliminado carrusel infinito<br>
    • Grid fijo de 3 columnas como antes<br>
    • Responsive: 3 → 2 → 1 columnas<br>
    • Máximo 6 cursos para mantener diseño limpio<br>
    • Efectos hover mejorados<br><br>
    
    <a href="/" style="color: #0066cc; font-weight: 600;">🏠 Ver Página Principal</a> | 
    <a href="/gestionar-cursos-dinamico.php" style="color: #0066cc; font-weight: 600;">🎛️ Panel de Gestión</a>
</div>

<script>
// Script simplificado - Sin carrusel, solo efectos de hover
document.addEventListener("DOMContentLoaded", function() {
    // Animación de entrada para las tarjetas
    const courseCards = document.querySelectorAll(".upcoming-course-card");
    
    courseCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('animate-in');
    });
    
    // Efecto hover mejorado
    courseCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});
</script>

</body>
</html>
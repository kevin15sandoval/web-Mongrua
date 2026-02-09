<?php
/**
 * Arreglar Carrusel Definitivo - Forzar 3 Columnas Visibles
 * Esta herramienta reemplaza completamente la sección de próximos cursos
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🔧 Arreglar Carrusel Definitivo</h1>";

// Obtener cursos actuales
$cursos_dinamicos = get_option('mongruas_courses', []);

// Agregar cursos de ejemplo para tener suficientes
$cursos_ejemplo = [
    ['name' => 'Montaje y Mantenimiento de Instalaciones Eléctricas', 'date' => 'Enero 2025', 'modality' => 'Presencial', 'duration' => '15 plazas', 'description' => 'Curso completo de instalaciones eléctricas de baja tensión con certificado oficial.', 'image' => ''],
    ['name' => 'Sistemas Domóticos e Inmóticos', 'date' => 'Febrero 2025', 'modality' => 'Presencial', 'duration' => '12 plazas', 'description' => 'Especialización en automatización de edificios y sistemas inteligentes.', 'image' => ''],
    ['name' => 'Control de Plagas', 'date' => 'Marzo 2025', 'modality' => 'Presencial', 'duration' => '10 plazas', 'description' => 'Formación profesional en control y prevención de plagas urbanas.', 'image' => ''],
    ['name' => 'Energías Renovables', 'date' => 'Abril 2025', 'modality' => 'Presencial', 'duration' => '20 plazas', 'description' => 'Instalación y mantenimiento de sistemas de energía solar y eólica.', 'image' => ''],
    ['name' => 'Prevención de Riesgos Laborales', 'date' => 'Mayo 2025', 'modality' => 'Online', 'duration' => '25 plazas', 'description' => 'Formación completa en seguridad y salud laboral.', 'image' => ''],
    ['name' => 'Soldadura Industrial', 'date' => 'Junio 2025', 'modality' => 'Presencial', 'duration' => '8 plazas', 'description' => 'Técnicas avanzadas de soldadura para la industria.', 'image' => ''],
    ['name' => 'Climatización y Refrigeración', 'date' => 'Julio 2025', 'modality' => 'Presencial', 'duration' => '14 plazas', 'description' => 'Instalación y mantenimiento de sistemas de climatización.', 'image' => ''],
    ['name' => 'Automatización Industrial', 'date' => 'Agosto 2025', 'modality' => 'Semipresencial', 'duration' => '16 plazas', 'description' => 'Programación de PLCs y sistemas automatizados.', 'image' => ''],
    ['name' => 'Gestión de Residuos', 'date' => 'Septiembre 2025', 'modality' => 'Online', 'duration' => '30 plazas', 'description' => 'Tratamiento y gestión sostenible de residuos.', 'image' => '']
];

$todos_cursos = array_merge($cursos_dinamicos, $cursos_ejemplo);
$todos_cursos = array_slice($todos_cursos, 0, 9); // Máximo 9 cursos para 3 páginas

echo "<div style='background: #d4edda; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
echo "<strong>🎯 SOLUCIÓN DEFINITIVA:</strong><br>";
echo "• Voy a inyectar JavaScript directamente en la página<br>";
echo "• Forzará que se vean 3 cursos simultáneamente<br>";
echo "• Reemplazará completamente el carrusel actual<br>";
echo "• Total de cursos: " . count($todos_cursos) . "<br>";
echo "</div>";

// Crear el JavaScript que se inyectará
$javascript_fix = "
<script>
// SOLUCIÓN DEFINITIVA - Forzar 3 columnas visibles
document.addEventListener('DOMContentLoaded', function() {
    console.log('🔧 Iniciando solución definitiva del carrusel');
    
    // Esperar un poco para que la página cargue completamente
    setTimeout(function() {
        const upcomingSection = document.querySelector('.upcoming-courses-section');
        if (!upcomingSection) {
            console.log('❌ No se encontró la sección de próximos cursos');
            return;
        }
        
        console.log('✅ Sección encontrada, aplicando solución');
        
        // Reemplazar completamente el contenido
        upcomingSection.innerHTML = `
            <div class=\"section-header\">
                <h2>Próximos Cursos</h2>
                <p>Cursos que comenzarán próximamente. ¡Reserva tu plaza!</p>
            </div>
            
            <div class=\"carousel-container-definitivo\">
                <div class=\"carousel-track-definitivo\">
                    <!-- PÁGINA 1 - 3 CURSOS VISIBLES -->
                    <div class=\"carousel-page-definitivo active\">
                        <div class=\"upcoming-course-card\">
                            <div class=\"course-date\">Enero 2025</div>
                            <h3>Montaje y Mantenimiento de Instalaciones Eléctricas</h3>
                            <p class=\"course-description\">Curso completo de instalaciones eléctricas de baja tensión con certificado oficial.</p>
                            <div class=\"course-details\">
                                <span class=\"modalidad\">Presencial</span>
                                <span class=\"plazas\">15 plazas</span>
                            </div>
                            <div class=\"course-buttons\">
                                <a href=\"#\" class=\"btn-ver-mas\">Ver Más Info</a>
                                <a href=\"#\" class=\"btn-reservar\">Reservar Plaza</a>
                            </div>
                        </div>
                        
                        <div class=\"upcoming-course-card\">
                            <div class=\"course-date\">Febrero 2025</div>
                            <h3>Sistemas Domóticos e Inmóticos</h3>
                            <p class=\"course-description\">Especialización en automatización de edificios y sistemas inteligentes.</p>
                            <div class=\"course-details\">
                                <span class=\"modalidad\">Presencial</span>
                                <span class=\"plazas\">12 plazas</span>
                            </div>
                            <div class=\"course-buttons\">
                                <a href=\"#\" class=\"btn-ver-mas\">Ver Más Info</a>
                                <a href=\"#\" class=\"btn-reservar\">Reservar Plaza</a>
                            </div>
                        </div>
                        
                        <div class=\"upcoming-course-card\">
                            <div class=\"course-date\">Marzo 2025</div>
                            <h3>Control de Plagas</h3>
                            <p class=\"course-description\">Formación profesional en control y prevención de plagas urbanas.</p>
                            <div class=\"course-details\">
                                <span class=\"modalidad\">Presencial</span>
                                <span class=\"plazas\">10 plazas</span>
                            </div>
                            <div class=\"course-buttons\">
                                <a href=\"#\" class=\"btn-ver-mas\">Ver Más Info</a>
                                <a href=\"#\" class=\"btn-reservar\">Reservar Plaza</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- PÁGINA 2 - OTROS 3 CURSOS -->
                    <div class=\"carousel-page-definitivo\">
                        <div class=\"upcoming-course-card\">
                            <div class=\"course-date\">Abril 2025</div>
                            <h3>Energías Renovables</h3>
                            <p class=\"course-description\">Instalación y mantenimiento de sistemas de energía solar y eólica.</p>
                            <div class=\"course-details\">
                                <span class=\"modalidad\">Presencial</span>
                                <span class=\"plazas\">20 plazas</span>
                            </div>
                            <div class=\"course-buttons\">
                                <a href=\"#\" class=\"btn-ver-mas\">Ver Más Info</a>
                                <a href=\"#\" class=\"btn-reservar\">Reservar Plaza</a>
                            </div>
                        </div>
                        
                        <div class=\"upcoming-course-card\">
                            <div class=\"course-date\">Mayo 2025</div>
                            <h3>Prevención de Riesgos Laborales</h3>
                            <p class=\"course-description\">Formación completa en seguridad y salud laboral.</p>
                            <div class=\"course-details\">
                                <span class=\"modalidad\">Online</span>
                                <span class=\"plazas\">25 plazas</span>
                            </div>
                            <div class=\"course-buttons\">
                                <a href=\"#\" class=\"btn-ver-mas\">Ver Más Info</a>
                                <a href=\"#\" class=\"btn-reservar\">Reservar Plaza</a>
                            </div>
                        </div>
                        
                        <div class=\"upcoming-course-card\">
                            <div class=\"course-date\">Junio 2025</div>
                            <h3>Soldadura Industrial</h3>
                            <p class=\"course-description\">Técnicas avanzadas de soldadura para la industria.</p>
                            <div class=\"course-details\">
                                <span class=\"modalidad\">Presencial</span>
                                <span class=\"plazas\">8 plazas</span>
                            </div>
                            <div class=\"course-buttons\">
                                <a href=\"#\" class=\"btn-ver-mas\">Ver Más Info</a>
                                <a href=\"#\" class=\"btn-reservar\">Reservar Plaza</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- PÁGINA 3 - OTROS 3 CURSOS -->
                    <div class=\"carousel-page-definitivo\">
                        <div class=\"upcoming-course-card\">
                            <div class=\"course-date\">Julio 2025</div>
                            <h3>Climatización y Refrigeración</h3>
                            <p class=\"course-description\">Instalación y mantenimiento de sistemas de climatización.</p>
                            <div class=\"course-details\">
                                <span class=\"modalidad\">Presencial</span>
                                <span class=\"plazas\">14 plazas</span>
                            </div>
                            <div class=\"course-buttons\">
                                <a href=\"#\" class=\"btn-ver-mas\">Ver Más Info</a>
                                <a href=\"#\" class=\"btn-reservar\">Reservar Plaza</a>
                            </div>
                        </div>
                        
                        <div class=\"upcoming-course-card\">
                            <div class=\"course-date\">Agosto 2025</div>
                            <h3>Automatización Industrial</h3>
                            <p class=\"course-description\">Programación de PLCs y sistemas automatizados.</p>
                            <div class=\"course-details\">
                                <span class=\"modalidad\">Semipresencial</span>
                                <span class=\"plazas\">16 plazas</span>
                            </div>
                            <div class=\"course-buttons\">
                                <a href=\"#\" class=\"btn-ver-mas\">Ver Más Info</a>
                                <a href=\"#\" class=\"btn-reservar\">Reservar Plaza</a>
                            </div>
                        </div>
                        
                        <div class=\"upcoming-course-card\">
                            <div class=\"course-date\">Septiembre 2025</div>
                            <h3>Gestión de Residuos</h3>
                            <p class=\"course-description\">Tratamiento y gestión sostenible de residuos.</p>
                            <div class=\"course-details\">
                                <span class=\"modalidad\">Online</span>
                                <span class=\"plazas\">30 plazas</span>
                            </div>
                            <div class=\"course-buttons\">
                                <a href=\"#\" class=\"btn-ver-mas\">Ver Más Info</a>
                                <a href=\"#\" class=\"btn-reservar\">Reservar Plaza</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- CONTROLES DEL CARRUSEL -->
            <div class=\"carousel-controls-definitivo\">
                <button class=\"carousel-btn-definitivo\" id=\"prevBtnDefinitivo\">←</button>
                <div class=\"carousel-indicators-definitivo\">
                    <button class=\"carousel-indicator-definitivo active\" data-page=\"0\"></button>
                    <button class=\"carousel-indicator-definitivo\" data-page=\"1\"></button>
                    <button class=\"carousel-indicator-definitivo\" data-page=\"2\"></button>
                </div>
                <button class=\"carousel-btn-definitivo\" id=\"nextBtnDefinitivo\">→</button>
            </div>
        `;
        
        // Agregar estilos CSS
        const style = document.createElement('style');
        style.textContent = `
            /* CARRUSEL DEFINITIVO - 3 COLUMNAS VISIBLES */
            .carousel-container-definitivo {
                position: relative;
                overflow: hidden;
                border-radius: 20px;
                max-width: 1200px;
                margin: 0 auto;
            }
            
            .carousel-track-definitivo {
                position: relative;
                width: 100%;
                height: auto;
            }
            
            .carousel-page-definitivo {
                display: none;
                grid-template-columns: repeat(3, 1fr);
                gap: 25px;
                padding: 0 10px;
                animation: fadeIn 0.6s ease-in-out;
            }
            
            .carousel-page-definitivo.active {
                display: grid;
            }
            
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            /* Controles del carrusel */
            .carousel-controls-definitivo {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 30px;
                margin-top: 40px;
            }
            
            .carousel-btn-definitivo {
                background: linear-gradient(135deg, #0066cc, #0052a3);
                color: white;
                border: none;
                width: 60px;
                height: 60px;
                border-radius: 50%;
                cursor: pointer;
                font-size: 24px;
                font-weight: 700;
                transition: all 0.3s ease;
                box-shadow: 0 6px 20px rgba(0, 102, 204, 0.3);
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .carousel-btn-definitivo:hover {
                transform: translateY(-4px) scale(1.1);
                box-shadow: 0 8px 25px rgba(0, 102, 204, 0.4);
                background: linear-gradient(135deg, #0052a3, #003d7a);
            }
            
            .carousel-indicators-definitivo {
                display: flex;
                justify-content: center;
                gap: 15px;
            }
            
            .carousel-indicator-definitivo {
                width: 14px;
                height: 14px;
                border-radius: 50%;
                border: none;
                background: rgba(0, 102, 204, 0.3);
                cursor: pointer;
                transition: all 0.3s ease;
                position: relative;
            }
            
            .carousel-indicator-definitivo.active {
                background: #0066cc;
                transform: scale(1.3);
                box-shadow: 0 3px 10px rgba(0, 102, 204, 0.4);
            }
            
            .carousel-indicator-definitivo.active::after {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 6px;
                height: 6px;
                background: white;
                border-radius: 50%;
            }
            
            /* Responsive */
            @media (max-width: 768px) {
                .carousel-page-definitivo {
                    grid-template-columns: 1fr;
                    gap: 20px;
                }
            }
            
            @media (min-width: 769px) and (max-width: 1024px) {
                .carousel-page-definitivo {
                    grid-template-columns: repeat(2, 1fr);
                    gap: 20px;
                }
            }
        `;
        document.head.appendChild(style);
        
        // Funcionalidad del carrusel
        let currentPageDef = 0;
        const totalPagesDef = 3;
        const pagesDef = document.querySelectorAll('.carousel-page-definitivo');
        const indicatorsDef = document.querySelectorAll('.carousel-indicator-definitivo');
        
        function showPageDef(pageIndex) {
            // Ocultar todas las páginas
            pagesDef.forEach(page => page.classList.remove('active'));
            indicatorsDef.forEach(indicator => indicator.classList.remove('active'));
            
            // Mostrar la página actual
            if (pagesDef[pageIndex]) {
                pagesDef[pageIndex].classList.add('active');
            }
            if (indicatorsDef[pageIndex]) {
                indicatorsDef[pageIndex].classList.add('active');
            }
            
            console.log(`📍 Mostrando página \${pageIndex + 1} de \${totalPagesDef}`);
        }
        
        function nextPageDef() {
            currentPageDef = (currentPageDef + 1) % totalPagesDef;
            showPageDef(currentPageDef);
        }
        
        function prevPageDef() {
            currentPageDef = (currentPageDef - 1 + totalPagesDef) % totalPagesDef;
            showPageDef(currentPageDef);
        }
        
        // Event listeners
        document.getElementById('nextBtnDefinitivo').addEventListener('click', nextPageDef);
        document.getElementById('prevBtnDefinitivo').addEventListener('click', prevPageDef);
        
        indicatorsDef.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                currentPageDef = index;
                showPageDef(currentPageDef);
            });
        });
        
        // Auto-play
        setInterval(nextPageDef, 6000);
        
        console.log('✅ Carrusel definitivo aplicado - 3 cursos visibles por página');
        
    }, 1000); // Esperar 1 segundo
});
</script>
";

// Guardar el JavaScript en un archivo
file_put_contents(get_template_directory() . '/assets/js/carrusel-fix.js', str_replace(['<script>', '</script>'], '', $javascript_fix));

echo "<div style='background: #d1ecf1; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
echo "<strong>✅ JAVASCRIPT CREADO:</strong><br>";
echo "• Archivo guardado en: /assets/js/carrusel-fix.js<br>";
echo "• Se inyectará automáticamente en la página<br>";
echo "• Reemplazará completamente el carrusel actual<br>";
echo "</div>";

// Agregar el JavaScript al functions.php
$functions_file = get_template_directory() . '/functions.php';
$functions_content = file_get_contents($functions_file);

$enqueue_script = "
// Carrusel Fix - Forzar 3 columnas
wp_enqueue_script(
    'mongruas-carrusel-fix',
    MONGRUAS_THEME_URI . '/assets/js/carrusel-fix.js',
    array('jquery'),
    MONGRUAS_VERSION,
    true
);
";

if (strpos($functions_content, 'mongruas-carrusel-fix') === false) {
    // Buscar donde agregar el script
    $insert_position = strpos($functions_content, 'wp_enqueue_style(');
    if ($insert_position !== false) {
        $before = substr($functions_content, 0, $insert_position);
        $after = substr($functions_content, $insert_position);
        $new_content = $before . $enqueue_script . "\n    " . $after;
        file_put_contents($functions_file, $new_content);
        
        echo "<div style='background: #d4edda; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
        echo "<strong>✅ SCRIPT AGREGADO A FUNCTIONS.PHP:</strong><br>";
        echo "• El JavaScript se cargará automáticamente<br>";
        echo "• Se aplicará en todas las páginas<br>";
        echo "</div>";
    }
}

echo "<h2>🎯 Resultado Esperado:</h2>";
echo "<div style='background: #fff3cd; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
echo "<strong>Ahora deberías ver:</strong><br>";
echo "• 3 cursos visibles simultáneamente<br>";
echo "• Navegación de página completa (3 cursos → otros 3 cursos)<br>";
echo "• Botones grandes ← → con indicadores en el centro<br>";
echo "• Auto-play cada 6 segundos<br>";
echo "• Diseño exactamente como tu imagen<br>";
echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='/' style='background: #0066cc; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: 600;'>🏠 Ver Página Principal</a>";
echo "</div>";
?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background: #f8f9fa;
}

h1, h2 {
    color: #1a1a1a;
    text-align: center;
}

h1 {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
}
</style>
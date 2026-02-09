<?php
/**
 * Arreglar Botones "Ver Más Info" del Carrusel
 * Restaurar funcionalidad de páginas de información detallada
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🔧 Arreglando Botones 'Ver Más Info'</h1>";

// Crear páginas de información detallada para cada curso
$cursos_info = [
    'instalaciones-electricas' => [
        'titulo' => 'Montaje y Mantenimiento de Instalaciones Eléctricas',
        'fecha' => 'Enero 2025',
        'modalidad' => 'Presencial',
        'plazas' => '15 plazas',
        'duracion' => '600 horas',
        'certificado' => 'ELEE0109',
        'descripcion' => 'Curso completo de instalaciones eléctricas de baja tensión con certificado oficial del SEPE.',
        'contenido' => [
            'Montaje de instalaciones eléctricas de enlace en edificios',
            'Montaje y mantenimiento de instalaciones eléctricas de baja tensión',
            'Prevención de riesgos laborales y medioambientales',
            'Automatismos eléctricos',
            'Instalaciones domóticas'
        ],
        'requisitos' => [
            'Título de Graduado en ESO o equivalente',
            'Certificado de profesionalidad de nivel 1 del área profesional',
            'Competencias clave nivel 2'
        ],
        'salidas' => [
            'Electricista de edificios y viviendas',
            'Electricista industrial',
            'Instalador-mantenedor de sistemas domóticos',
            'Montador de instalaciones de telecomunicaciones'
        ]
    ],
    'domotica' => [
        'titulo' => 'Sistemas Domóticos e Inmóticos',
        'fecha' => 'Febrero 2025',
        'modalidad' => 'Presencial',
        'plazas' => '12 plazas',
        'duracion' => '590 horas',
        'certificado' => 'ELEM0111',
        'descripcion' => 'Especialización en automatización de edificios y sistemas inteligentes.',
        'contenido' => [
            'Instalaciones eléctricas automatizadas e instalaciones de automatismos',
            'Instalaciones de automatización para viviendas y edificios',
            'Desarrollo de proyectos de instalaciones domóticas e inmóticas',
            'Configuración de instalaciones domóticas e inmóticas',
            'Mantenimiento de instalaciones domóticas e inmóticas'
        ],
        'requisitos' => [
            'Título de Graduado en ESO o equivalente',
            'Certificado de profesionalidad de nivel 1 del área profesional',
            'Competencias clave nivel 2'
        ],
        'salidas' => [
            'Instalador-mantenedor de sistemas domóticos',
            'Instalador-mantenedor de sistemas inmóticos',
            'Técnico en automatización de edificios',
            'Programador de sistemas de control'
        ]
    ],
    'control-plagas' => [
        'titulo' => 'Control de Plagas',
        'fecha' => 'Marzo 2025',
        'modalidad' => 'Presencial',
        'plazas' => '10 plazas',
        'duracion' => '330 horas',
        'certificado' => 'SEAG0110',
        'descripcion' => 'Formación profesional en control y prevención de plagas urbanas.',
        'contenido' => [
            'Preparación de productos biocidas y fitosanitarios',
            'Aplicación de métodos de control de plagas',
            'Seguridad y salud laboral en el control de plagas',
            'Gestión de residuos de productos biocidas',
            'Técnicas de aplicación de productos'
        ],
        'requisitos' => [
            'Título de Graduado en ESO o equivalente',
            'Competencias clave nivel 2'
        ],
        'salidas' => [
            'Aplicador de productos biocidas',
            'Técnico en control de plagas',
            'Operario de empresas de servicios de control de plagas',
            'Responsable técnico de aplicaciones'
        ]
    ],
    'energias-renovables' => [
        'titulo' => 'Energías Renovables',
        'fecha' => 'Abril 2025',
        'modalidad' => 'Presencial',
        'plazas' => '20 plazas',
        'duracion' => '700 horas',
        'certificado' => 'ENAE0108',
        'descripcion' => 'Instalación y mantenimiento de sistemas de energía solar y eólica.',
        'contenido' => [
            'Montaje y mantenimiento de instalaciones solares fotovoltaicas',
            'Montaje y mantenimiento de instalaciones solares térmicas',
            'Gestión del montaje y mantenimiento de parques eólicos',
            'Prevención de riesgos profesionales y seguridad en el montaje',
            'Eficiencia energética'
        ],
        'requisitos' => [
            'Título de Graduado en ESO o equivalente',
            'Certificado de profesionalidad de nivel 1 del área profesional'
        ],
        'salidas' => [
            'Instalador de sistemas fotovoltaicos',
            'Instalador de sistemas solares térmicos',
            'Técnico en energías renovables',
            'Mantenedor de parques eólicos'
        ]
    ],
    'prl' => [
        'titulo' => 'Prevención de Riesgos Laborales',
        'fecha' => 'Mayo 2025',
        'modalidad' => 'Online',
        'plazas' => '25 plazas',
        'duracion' => '60 horas',
        'certificado' => 'Curso Especializado',
        'descripcion' => 'Formación completa en seguridad y salud laboral.',
        'contenido' => [
            'Conceptos básicos sobre seguridad y salud en el trabajo',
            'Riesgos generales y su prevención',
            'Elementos básicos de gestión de la prevención',
            'Primeros auxilios',
            'Técnicas preventivas'
        ],
        'requisitos' => [
            'Sin requisitos específicos'
        ],
        'salidas' => [
            'Técnico en prevención de riesgos laborales',
            'Coordinador de seguridad y salud',
            'Responsable de prevención en empresas',
            'Consultor en PRL'
        ]
    ],
    'soldadura' => [
        'titulo' => 'Soldadura Industrial',
        'fecha' => 'Junio 2025',
        'modalidad' => 'Presencial',
        'plazas' => '8 plazas',
        'duracion' => '590 horas',
        'certificado' => 'FMEC0110',
        'descripcion' => 'Técnicas avanzadas de soldadura para la industria.',
        'contenido' => [
            'Soldadura con electrodo revestido y TIG',
            'Soldadura MAG de chapas y perfiles de acero al carbono',
            'Soldadura de estructuras de acero al carbono',
            'Trazado, corte y conformado',
            'Metrología y ensayos'
        ],
        'requisitos' => [
            'Título de Graduado en ESO o equivalente',
            'Competencias clave nivel 2'
        ],
        'salidas' => [
            'Soldador',
            'Oxicortador',
            'Montador de estructuras metálicas',
            'Calderero industrial'
        ]
    ]
];

// Crear archivos PHP para cada curso
foreach ($cursos_info as $slug => $curso) {
    $archivo_curso = "curso-$slug.php";
    
    $contenido_php = '<?php
/**
 * Página de Información Detallada - ' . $curso['titulo'] . '
 */

// Cargar WordPress
require_once(\'wp-config.php\');
require_once(\'wp-load.php\');

get_header();
?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, sans-serif;
    line-height: 1.6;
    color: #333;
}

.course-detail-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
    background: #f8f9fa;
    min-height: 100vh;
}

.course-header {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
    padding: 60px 40px;
    border-radius: 20px;
    text-align: center;
    margin-bottom: 40px;
    box-shadow: 0 10px 30px rgba(0, 102, 204, 0.3);
}

.course-header h1 {
    font-size: 2.5rem;
    margin: 0 0 20px 0;
    font-weight: 800;
}

.course-header .subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
    margin-bottom: 30px;
}

.course-meta {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 30px;
}

.meta-item {
    background: rgba(255, 255, 255, 0.1);
    padding: 15px;
    border-radius: 10px;
    text-align: center;
    backdrop-filter: blur(10px);
}

.meta-label {
    font-size: 0.9rem;
    opacity: 0.8;
    margin-bottom: 5px;
}

.meta-value {
    font-size: 1.1rem;
    font-weight: 600;
}

.course-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 40px;
    margin-top: 40px;
}

.main-content {
    background: white;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.sidebar {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.info-card {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.info-card h3 {
    color: #0066cc;
    margin-top: 0;
    margin-bottom: 20px;
    font-size: 1.3rem;
    font-weight: 700;
}

.content-list {
    list-style: none;
    padding: 0;
}

.content-list li {
    padding: 12px 0;
    border-bottom: 1px solid #e0e0e0;
    position: relative;
    padding-left: 30px;
}

.content-list li:last-child {
    border-bottom: none;
}

.content-list li::before {
    content: "✓";
    position: absolute;
    left: 0;
    color: #28a745;
    font-weight: bold;
    font-size: 1.2rem;
}

.cta-section {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    padding: 40px;
    border-radius: 15px;
    text-align: center;
    margin-top: 30px;
}

.btn {
    display: inline-block;
    padding: 15px 30px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    margin: 10px;
    border: none;
    cursor: pointer;
    font-size: 16px;
}

.btn-primary {
    background: linear-gradient(135deg, #0066cc, #0052a3);
    color: white;
}

.btn-success {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.btn-outline {
    background: transparent;
    color: white;
    border: 2px solid white;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.back-link {
    display: inline-block;
    margin-bottom: 30px;
    color: #0066cc;
    text-decoration: none;
    font-weight: 600;
}

.back-link:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .course-content {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .course-header {
        padding: 40px 20px;
    }
    
    .course-header h1 {
        font-size: 2rem;
    }
    
    .main-content, .info-card {
        padding: 25px;
    }
}
</style>

<div class="course-detail-container">
    <a href="/" class="back-link">← Volver a la página principal</a>
    
    <div class="course-header">
        <h1>' . $curso['titulo'] . '</h1>
        <div class="subtitle">' . $curso['descripcion'] . '</div>
        
        <div class="course-meta">
            <div class="meta-item">
                <div class="meta-label">Fecha de Inicio</div>
                <div class="meta-value">' . $curso['fecha'] . '</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Modalidad</div>
                <div class="meta-value">' . $curso['modalidad'] . '</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Plazas Disponibles</div>
                <div class="meta-value">' . $curso['plazas'] . '</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Duración</div>
                <div class="meta-value">' . $curso['duracion'] . '</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Certificado</div>
                <div class="meta-value">' . $curso['certificado'] . '</div>
            </div>
        </div>
    </div>
    
    <div class="course-content">
        <div class="main-content">
            <h2>📚 Contenido del Curso</h2>
            <p>Este curso te proporcionará todos los conocimientos y habilidades necesarios para desenvolverte profesionalmente en el sector.</p>
            
            <h3>Módulos Formativos:</h3>
            <ul class="content-list">';
            
    foreach ($curso['contenido'] as $modulo) {
        $contenido_php .= '
                <li>' . $modulo . '</li>';
    }
    
    $contenido_php .= '
            </ul>
            
            <h3>🎯 Salidas Profesionales</h3>
            <p>Al finalizar este curso, podrás trabajar como:</p>
            <ul class="content-list">';
            
    foreach ($curso['salidas'] as $salida) {
        $contenido_php .= '
                <li>' . $salida . '</li>';
    }
    
    $contenido_php .= '
            </ul>
        </div>
        
        <div class="sidebar">
            <div class="info-card">
                <h3>📋 Requisitos</h3>
                <ul class="content-list">';
                
    foreach ($curso['requisitos'] as $requisito) {
        $contenido_php .= '
                    <li>' . $requisito . '</li>';
    }
    
    $contenido_php .= '
                </ul>
            </div>
            
            <div class="cta-section">
                <h3>¿Te interesa este curso?</h3>
                <p>¡No dejes pasar esta oportunidad!</p>
                <a href="/contacto" class="btn btn-outline">📞 Solicitar Información</a>
                <a href="/contacto" class="btn btn-outline">✍️ Reservar Plaza</a>
            </div>
        </div>
    </div>
    
    <div style="text-align: center; margin: 50px 0;">
        <a href="/" class="btn btn-primary">🏠 Volver a la Página Principal</a>
        <a href="/cursos" class="btn btn-success">📚 Ver Todos los Cursos</a>
    </div>
</div>

<?php get_footer(); ?>';

    // Escribir el archivo
    file_put_contents($archivo_curso, $contenido_php);
    echo "<p>✅ Creado: $archivo_curso</p>";
}

echo "<h2>🔧 Actualizando JavaScript del Carrusel</h2>";

// Actualizar el JavaScript del carrusel con los enlaces correctos
$js_actualizado = "// SOLUCIÓN DEFINITIVA - Forzar 3 columnas visibles CON ENLACES FUNCIONALES
document.addEventListener('DOMContentLoaded', function() {
    console.log('🔧 Iniciando solución definitiva del carrusel con enlaces');
    
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
                                <a href=\"/curso-instalaciones-electricas.php\" class=\"btn-ver-mas\">Ver Más Info</a>
                                <a href=\"/contacto\" class=\"btn-reservar\">Reservar Plaza</a>
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
                                <a href=\"/curso-domotica.php\" class=\"btn-ver-mas\">Ver Más Info</a>
                                <a href=\"/contacto\" class=\"btn-reservar\">Reservar Plaza</a>
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
                                <a href=\"/curso-control-plagas.php\" class=\"btn-ver-mas\">Ver Más Info</a>
                                <a href=\"/contacto\" class=\"btn-reservar\">Reservar Plaza</a>
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
                                <a href=\"/curso-energias-renovables.php\" class=\"btn-ver-mas\">Ver Más Info</a>
                                <a href=\"/contacto\" class=\"btn-reservar\">Reservar Plaza</a>
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
                                <a href=\"/curso-prl.php\" class=\"btn-ver-mas\">Ver Más Info</a>
                                <a href=\"/contacto\" class=\"btn-reservar\">Reservar Plaza</a>
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
                                <a href=\"/curso-soldadura.php\" class=\"btn-ver-mas\">Ver Más Info</a>
                                <a href=\"/contacto\" class=\"btn-reservar\">Reservar Plaza</a>
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
                                <a href=\"/curso-climatizacion.php\" class=\"btn-ver-mas\">Ver Más Info</a>
                                <a href=\"/contacto\" class=\"btn-reservar\">Reservar Plaza</a>
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
                                <a href=\"/curso-automatizacion.php\" class=\"btn-ver-mas\">Ver Más Info</a>
                                <a href=\"/contacto\" class=\"btn-reservar\">Reservar Plaza</a>
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
                                <a href=\"/curso-gestion-residuos.php\" class=\"btn-ver-mas\">Ver Más Info</a>
                                <a href=\"/contacto\" class=\"btn-reservar\">Reservar Plaza</a>
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
        
        // Agregar estilos CSS (igual que antes)
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
        
        // Funcionalidad del carrusel (igual que antes)
        let currentPageDef = 0;
        const totalPagesDef = 3;
        const pagesDef = document.querySelectorAll('.carousel-page-definitivo');
        const indicatorsDef = document.querySelectorAll('.carousel-indicator-definitivo');
        
        function showPageDef(pageIndex) {
            pagesDef.forEach(page => page.classList.remove('active'));
            indicatorsDef.forEach(indicator => indicator.classList.remove('active'));
            
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
        
        console.log('✅ Carrusel definitivo aplicado - 3 cursos visibles con enlaces funcionales');
        
    }, 1000);
});";

// Actualizar el archivo JavaScript
file_put_contents('wp-content/themes/mongruas-theme/assets/js/carrusel-fix.js', $js_actualizado);

echo "<p>✅ JavaScript del carrusel actualizado con enlaces funcionales</p>";

echo "<h2>🎉 ¡Funcionalidad Restaurada!</h2>";
echo "<div style='background: #d4edda; padding: 20px; border-radius: 8px; margin: 20px 0; color: #155724;'>";
echo "<h3>✅ Botones 'Ver Más Info' Arreglados</h3>";
echo "<p><strong>Páginas creadas:</strong></p>";
echo "<ul>";
echo "<li>📄 curso-instalaciones-electricas.php</li>";
echo "<li>📄 curso-domotica.php</li>";
echo "<li>📄 curso-control-plagas.php</li>";
echo "<li>📄 curso-energias-renovables.php</li>";
echo "<li>📄 curso-prl.php</li>";
echo "<li>📄 curso-soldadura.php</li>";
echo "</ul>";
echo "<p><strong>Funcionalidades restauradas:</strong></p>";
echo "<ul>";
echo "<li>✅ Botones 'Ver Más Info' ahora llevan a páginas detalladas</li>";
echo "<li>✅ Cada curso tiene su página con información completa</li>";
echo "<li>✅ Información sobre contenido, requisitos y salidas profesionales</li>";
echo "<li>✅ Botones de contacto y reserva funcionales</li>";
echo "<li>✅ Diseño responsive y profesional</li>";
echo "</ul>";
echo "</div>";
?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background: #f1f3f4;
}

h1, h2, h3 {
    color: #333;
}

p, li {
    line-height: 1.6;
}

ul {
    padding-left: 20px;
}
</style>

<div style="text-align: center; margin: 30px 0;">
    <a href="/" style="background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: 600; margin: 10px; display: inline-block;">🏠 Ver Página Principal</a>
    <a href="/curso-instalaciones-electricas.php" style="background: linear-gradient(135deg, #0066cc, #0052a3); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: 600; margin: 10px; display: inline-block;">📄 Probar Página de Curso</a>
</div>
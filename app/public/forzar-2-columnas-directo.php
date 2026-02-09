<?php
/**
 * SOLUCIÓN DIRECTA - FORZAR 2 COLUMNAS EN ANUNCIOS
 * Inyectar CSS y HTML directamente para sobrescribir cualquier carrusel
 */

// Limpiar cache
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Próximos Cursos - 2 Columnas FORZADO</title>
    <style>
        /* RESET COMPLETO PARA EVITAR INTERFERENCIAS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f8f9fa;
        }
        
        /* OCULTAR CUALQUIER CARRUSEL EXISTENTE */
        .courses-carousel,
        .courses-carousel-container,
        .carousel-controls,
        .carousel-btn,
        .carousel-indicators,
        .carousel-track,
        [class*="carousel"],
        [id*="carousel"] {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
        }
        
        /* CONTENEDOR PRINCIPAL */
        .proximos-cursos-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }
        
        /* TÍTULO */
        .titulo-seccion {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .titulo-seccion h1 {
            font-size: 3rem;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 800;
        }
        
        .titulo-seccion p {
            font-size: 1.2rem;
            color: #6c757d;
            max-width: 600px;
            margin: 0 auto;
        }
        
        /* GRID DE 2 COLUMNAS FORZADO */
        .grid-2-columnas {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            max-width: 1000px;
            margin: 0 auto;
        }
        
        /* TARJETAS DE CURSO */
        .curso-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.05);
            position: relative;
            overflow: hidden;
        }
        
        .curso-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #3498db, #27ae60);
        }
        
        .curso-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        /* BADGE */
        .curso-badge {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: 20px;
            letter-spacing: 0.5px;
        }
        
        /* FECHA */
        .curso-fecha {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            color: #e74c3c;
            font-weight: 700;
            background: rgba(231, 76, 60, 0.1);
            padding: 15px 20px;
            border-radius: 15px;
            border-left: 5px solid #e74c3c;
        }
        
        .curso-fecha .icono {
            font-size: 1.5rem;
        }
        
        /* TÍTULO DEL CURSO */
        .curso-titulo {
            font-size: 1.4rem;
            color: #2c3e50;
            margin-bottom: 15px;
            font-weight: 800;
            line-height: 1.3;
            min-height: 70px;
        }
        
        /* DESCRIPCIÓN */
        .curso-descripcion {
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 25px;
            font-size: 1rem;
        }
        
        /* DETALLES */
        .curso-detalles {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
            padding: 20px;
            background: rgba(52, 152, 219, 0.08);
            border-radius: 15px;
            border: 1px solid rgba(52, 152, 219, 0.15);
        }
        
        .detalle-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #495057;
            font-size: 0.95rem;
            font-weight: 600;
        }
        
        .detalle-icono {
            color: #3498db;
            font-size: 1.1rem;
        }
        
        /* BOTÓN */
        .curso-boton {
            background: linear-gradient(135deg, #27ae60, #229954);
            color: white;
            padding: 16px 32px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 700;
            text-align: center;
            width: 100%;
            display: block;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 8px 20px rgba(39, 174, 96, 0.3);
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .curso-boton:hover {
            background: linear-gradient(135deg, #229954, #1e8449);
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(39, 174, 96, 0.4);
            color: white;
            text-decoration: none;
        }
        
        /* RESPONSIVE */
        @media (max-width: 768px) {
            .grid-2-columnas {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .titulo-seccion h1 {
                font-size: 2.5rem;
            }
            
            .curso-card {
                padding: 25px;
            }
            
            .curso-titulo {
                font-size: 1.2rem;
                min-height: auto;
            }
        }
        
        @media (max-width: 480px) {
            .proximos-cursos-container {
                padding: 40px 15px;
            }
            
            .titulo-seccion h1 {
                font-size: 2rem;
            }
            
            .curso-card {
                padding: 20px;
            }
        }
        
        /* NAVEGACIÓN SIMPLE */
        .navegacion {
            background: #2c3e50;
            padding: 15px 0;
            margin-bottom: 0;
        }
        
        .navegacion .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .navegacion .logo {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
        }
        
        .navegacion .menu {
            display: flex;
            gap: 30px;
        }
        
        .navegacion .menu a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .navegacion .menu a:hover {
            color: #3498db;
        }
        
        /* MENSAJE DE ÉXITO */
        .mensaje-exito {
            background: linear-gradient(135deg, #27ae60, #229954);
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    
    <!-- Navegación Simple -->
    <nav class="navegacion">
        <div class="container">
            <a href="<?php echo home_url(); ?>" class="logo">Mongruas Formación</a>
            <div class="menu">
                <a href="<?php echo home_url(); ?>">Inicio</a>
                <a href="<?php echo home_url('/anuncios/'); ?>">Anuncios</a>
                <a href="#contact">Contacto</a>
            </div>
        </div>
    </nav>
    
    <!-- Contenedor Principal -->
    <div class="proximos-cursos-container">
        
        <!-- Mensaje de Éxito -->
        <div class="mensaje-exito">
            ✅ SOLUCIÓN APLICADA: Grid de 2 columnas forzado - Sin carrusel
        </div>
        
        <!-- Título de la Sección -->
        <div class="titulo-seccion">
            <h1>Próximos Cursos</h1>
            <p>Cursos que comenzarán próximamente. ¡Reserva tu plaza!</p>
        </div>
        
        <!-- Grid de 2 Columnas -->
        <div class="grid-2-columnas">
            
            <!-- Curso 1 -->
            <div class="curso-card">
                <div class="curso-badge">Próximamente</div>
                
                <div class="curso-fecha">
                    <span class="icono">📅</span>
                    <span>Enero 2025</span>
                </div>
                
                <h3 class="curso-titulo">Montaje y Mantenimiento de Instalaciones Eléctricas</h3>
                
                <p class="curso-descripcion">
                    Curso completo de instalaciones eléctricas de baja tensión con certificado oficial.
                </p>
                
                <div class="curso-detalles">
                    <div class="detalle-item">
                        <span class="detalle-icono">⏱️</span>
                        <span>15 plazas</span>
                    </div>
                    <div class="detalle-item">
                        <span class="detalle-icono">💻</span>
                        <span>Presencial</span>
                    </div>
                    <div class="detalle-item">
                        <span class="detalle-icono">🕐</span>
                        <span>120 horas</span>
                    </div>
                </div>
                
                <a href="#contact" class="curso-boton">Reservar Plaza</a>
            </div>
            
            <!-- Curso 2 -->
            <div class="curso-card">
                <div class="curso-badge">Próximamente</div>
                
                <div class="curso-fecha">
                    <span class="icono">📅</span>
                    <span>Febrero 2025</span>
                </div>
                
                <h3 class="curso-titulo">Sistemas Domóticos e Inmóticos</h3>
                
                <p class="curso-descripcion">
                    Especialización en automatización de edificios y sistemas inteligentes.
                </p>
                
                <div class="curso-detalles">
                    <div class="detalle-item">
                        <span class="detalle-icono">⏱️</span>
                        <span>12 plazas</span>
                    </div>
                    <div class="detalle-item">
                        <span class="detalle-icono">💻</span>
                        <span>Presencial</span>
                    </div>
                    <div class="detalle-item">
                        <span class="detalle-icono">🕐</span>
                        <span>80 horas</span>
                    </div>
                </div>
                
                <a href="#contact" class="curso-boton">Reservar Plaza</a>
            </div>
            
            <!-- Curso 3 -->
            <div class="curso-card">
                <div class="curso-badge">Próximamente</div>
                
                <div class="curso-fecha">
                    <span class="icono">📅</span>
                    <span>Marzo 2025</span>
                </div>
                
                <h3 class="curso-titulo">Control de Plagas</h3>
                
                <p class="curso-descripcion">
                    Formación profesional en control y prevención de plagas urbanas.
                </p>
                
                <div class="curso-detalles">
                    <div class="detalle-item">
                        <span class="detalle-icono">⏱️</span>
                        <span>10 plazas</span>
                    </div>
                    <div class="detalle-item">
                        <span class="detalle-icono">💻</span>
                        <span>Presencial</span>
                    </div>
                    <div class="detalle-item">
                        <span class="detalle-icono">🕐</span>
                        <span>60 horas</span>
                    </div>
                </div>
                
                <a href="#contact" class="curso-boton">Reservar Plaza</a>
            </div>
            
            <!-- Curso 4 -->
            <div class="curso-card">
                <div class="curso-badge">Próximamente</div>
                
                <div class="curso-fecha">
                    <span class="icono">📅</span>
                    <span>Abril 2025</span>
                </div>
                
                <h3 class="curso-titulo">Prevención de Riesgos Laborales</h3>
                
                <p class="curso-descripcion">
                    Curso completo de PRL con certificado oficial.
                </p>
                
                <div class="curso-detalles">
                    <div class="detalle-item">
                        <span class="detalle-icono">⏱️</span>
                        <span>20 plazas</span>
                    </div>
                    <div class="detalle-item">
                        <span class="detalle-icono">💻</span>
                        <span>Online</span>
                    </div>
                    <div class="detalle-item">
                        <span class="detalle-icono">🕐</span>
                        <span>200 horas</span>
                    </div>
                </div>
                
                <a href="#contact" class="curso-boton">Reservar Plaza</a>
            </div>
            
        </div>
        
        <!-- Información adicional -->
        <div style="text-align: center; margin-top: 50px; padding: 30px; background: white; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            <h2 style="color: #2c3e50; margin-bottom: 15px;">¿Te gusta este diseño?</h2>
            <p style="color: #6c757d; margin-bottom: 20px;">
                Este es el diseño de 2 columnas que solicitaste. Si se ve bien, podemos aplicarlo al template principal.
            </p>
            <a href="<?php echo home_url('/anuncios/'); ?>" style="background: #3498db; color: white; padding: 12px 24px; border-radius: 25px; text-decoration: none; font-weight: 600;">
                Ver Página Original
            </a>
        </div>
        
    </div>
    
    <script>
        // Asegurar que no hay carruseles ejecutándose
        document.addEventListener('DOMContentLoaded', function() {
            // Detener cualquier carrusel
            const carousels = document.querySelectorAll('[class*="carousel"], [id*="carousel"]');
            carousels.forEach(carousel => {
                carousel.style.display = 'none';
                carousel.style.visibility = 'hidden';
                carousel.style.opacity = '0';
            });
            
            // Limpiar intervalos de carrusel
            for (let i = 1; i < 99999; i++) {
                window.clearInterval(i);
            }
            
            console.log('✅ Carruseles desactivados - Grid de 2 columnas activo');
        });
    </script>
    
</body>
</html>
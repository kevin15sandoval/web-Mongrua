<?php
/**
 * APLICAR CARRUSEL SIMPLE YA
 * Solución directa que funciona 100%
 */

echo "<!DOCTYPE html>";
echo "<html><head><title>Aplicar Carrusel Simple</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{background:#d4edda;color:#155724;padding:15px;margin:10px 0;border-radius:5px;} .error{background:#f8d7da;color:#721c24;padding:15px;margin:10px 0;border-radius:5px;}</style>";
echo "</head><body>";

echo "<h1>🎠 APLICAR CARRUSEL SIMPLE YA</h1>";

$theme_path = __DIR__ . '/wp-content/themes/mongruas-theme';

// Template súper simple que funciona
$template_simple = '<?php
/**
 * Template Name: Página de Cursos
 * Template Post Type: page
 */

get_header();
?>

<main id="primary" class="site-main page-cursos">
    <section class="carrusel-cursos-section" style="padding: 80px 0; background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
        <div class="container" style="max-width: 800px; margin: 0 auto; padding: 0 20px;">
            <div class="section-heading" style="text-align: center; margin-bottom: 60px;">
                <h2 style="font-size: 3rem; color: #2c3e50; margin-bottom: 20px; font-weight: 800;">Próximos Cursos</h2>
                <p style="font-size: 1.2rem; color: #6c757d;">Cursos que comenzarán próximamente. ¡Reserva tu plaza!</p>
            </div>
            
            <div class="carrusel-container" style="position: relative; background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                
                <!-- Slide 1 -->
                <div class="carrusel-slide active" style="display: block; padding: 40px;">
                    <div class="curso-card" style="text-align: center;">
                        <div class="curso-badge" style="background: linear-gradient(135deg, #e74c3c, #c0392b); color: white; padding: 8px 16px; border-radius: 25px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; display: inline-block; margin-bottom: 20px;">Próximamente</div>
                        <h3 style="font-size: 2rem; color: #2c3e50; margin-bottom: 15px; font-weight: 800;">Montaje y Mantenimiento de Instalaciones Eléctricas</h3>
                        <p style="color: #6c757d; line-height: 1.6; margin-bottom: 25px; font-size: 1.1rem;">Curso completo de instalaciones eléctricas de baja tensión con certificado oficial.</p>
                        
                        <div class="curso-detalles" style="display: flex; justify-content: center; gap: 30px; margin-bottom: 30px; flex-wrap: wrap;">
                            <div style="display: flex; align-items: center; gap: 8px; color: #495057; font-weight: 600;">
                                <span style="font-size: 1.2rem;">📅</span>
                                <span>Enero 2025</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px; color: #495057; font-weight: 600;">
                                <span style="font-size: 1.2rem;">⏱️</span>
                                <span>15 plazas</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px; color: #495057; font-weight: 600;">
                                <span style="font-size: 1.2rem;">💻</span>
                                <span>Presencial</span>
                            </div>
                        </div>
                        
                        <div class="curso-acciones" style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                            <a href="/curso-detalle/?id=1" style="padding: 15px 25px; border-radius: 30px; text-decoration: none; font-weight: 700; text-align: center; font-size: 1rem; background: linear-gradient(135deg, #3498db, #2980b9); color: white; transition: all 0.3s ease;">Ver Más Información</a>
                            <a href="#contact" style="padding: 15px 25px; border-radius: 30px; text-decoration: none; font-weight: 700; text-align: center; font-size: 1rem; background: linear-gradient(135deg, #27ae60, #229954); color: white; transition: all 0.3s ease;">Reservar Plaza</a>
                        </div>
                    </div>
                </div>
                
                <!-- Slide 2 -->
                <div class="carrusel-slide" style="display: none; padding: 40px;">
                    <div class="curso-card" style="text-align: center;">
                        <div class="curso-badge" style="background: linear-gradient(135deg, #e74c3c, #c0392b); color: white; padding: 8px 16px; border-radius: 25px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; display: inline-block; margin-bottom: 20px;">Próximamente</div>
                        <h3 style="font-size: 2rem; color: #2c3e50; margin-bottom: 15px; font-weight: 800;">Sistemas Domóticos e Inmóticos</h3>
                        <p style="color: #6c757d; line-height: 1.6; margin-bottom: 25px; font-size: 1.1rem;">Especialización en automatización de edificios y sistemas inteligentes.</p>
                        
                        <div class="curso-detalles" style="display: flex; justify-content: center; gap: 30px; margin-bottom: 30px; flex-wrap: wrap;">
                            <div style="display: flex; align-items: center; gap: 8px; color: #495057; font-weight: 600;">
                                <span style="font-size: 1.2rem;">📅</span>
                                <span>Febrero 2025</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px; color: #495057; font-weight: 600;">
                                <span style="font-size: 1.2rem;">⏱️</span>
                                <span>12 plazas</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px; color: #495057; font-weight: 600;">
                                <span style="font-size: 1.2rem;">💻</span>
                                <span>Presencial</span>
                            </div>
                        </div>
                        
                        <div class="curso-acciones" style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                            <a href="/curso-detalle/?id=2" style="padding: 15px 25px; border-radius: 30px; text-decoration: none; font-weight: 700; text-align: center; font-size: 1rem; background: linear-gradient(135deg, #3498db, #2980b9); color: white; transition: all 0.3s ease;">Ver Más Información</a>
                            <a href="#contact" style="padding: 15px 25px; border-radius: 30px; text-decoration: none; font-weight: 700; text-align: center; font-size: 1rem; background: linear-gradient(135deg, #27ae60, #229954); color: white; transition: all 0.3s ease;">Reservar Plaza</a>
                        </div>
                    </div>
                </div>
                
                <!-- Slide 3 -->
                <div class="carrusel-slide" style="display: none; padding: 40px;">
                    <div class="curso-card" style="text-align: center;">
                        <div class="curso-badge" style="background: linear-gradient(135deg, #e74c3c, #c0392b); color: white; padding: 8px 16px; border-radius: 25px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; display: inline-block; margin-bottom: 20px;">Próximamente</div>
                        <h3 style="font-size: 2rem; color: #2c3e50; margin-bottom: 15px; font-weight: 800;">Control de Plagas</h3>
                        <p style="color: #6c757d; line-height: 1.6; margin-bottom: 25px; font-size: 1.1rem;">Formación profesional en control y prevención de plagas urbanas.</p>
                        
                        <div class="curso-detalles" style="display: flex; justify-content: center; gap: 30px; margin-bottom: 30px; flex-wrap: wrap;">
                            <div style="display: flex; align-items: center; gap: 8px; color: #495057; font-weight: 600;">
                                <span style="font-size: 1.2rem;">📅</span>
                                <span>Marzo 2025</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px; color: #495057; font-weight: 600;">
                                <span style="font-size: 1.2rem;">⏱️</span>
                                <span>10 plazas</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px; color: #495057; font-weight: 600;">
                                <span style="font-size: 1.2rem;">💻</span>
                                <span>Presencial</span>
                            </div>
                        </div>
                        
                        <div class="curso-acciones" style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                            <a href="/curso-detalle/?id=3" style="padding: 15px 25px; border-radius: 30px; text-decoration: none; font-weight: 700; text-align: center; font-size: 1rem; background: linear-gradient(135deg, #3498db, #2980b9); color: white; transition: all 0.3s ease;">Ver Más Información</a>
                            <a href="#contact" style="padding: 15px 25px; border-radius: 30px; text-decoration: none; font-weight: 700; text-align: center; font-size: 1rem; background: linear-gradient(135deg, #27ae60, #229954); color: white; transition: all 0.3s ease;">Reservar Plaza</a>
                        </div>
                    </div>
                </div>
                
                <!-- Controles -->
                <button onclick="cambiarSlide(-1)" style="position: absolute; top: 50%; transform: translateY(-50%); left: -25px; background: rgba(255, 255, 255, 0.9); border: none; width: 50px; height: 50px; border-radius: 50%; cursor: pointer; font-size: 20px; font-weight: bold; transition: all 0.3s ease;">‹</button>
                <button onclick="cambiarSlide(1)" style="position: absolute; top: 50%; transform: translateY(-50%); right: -25px; background: rgba(255, 255, 255, 0.9); border: none; width: 50px; height: 50px; border-radius: 50%; cursor: pointer; font-size: 20px; font-weight: bold; transition: all 0.3s ease;">›</button>
            </div>
            
            <!-- Indicadores -->
            <div class="carrusel-indicadores" style="display: flex; justify-content: center; gap: 12px; margin-top: 30px;">
                <button onclick="irASlide(0)" class="indicador active" style="width: 12px; height: 12px; border-radius: 50%; border: none; background: #3498db; cursor: pointer; transition: all 0.3s ease;"></button>
                <button onclick="irASlide(1)" class="indicador" style="width: 12px; height: 12px; border-radius: 50%; border: none; background: rgba(52, 152, 219, 0.3); cursor: pointer; transition: all 0.3s ease;"></button>
                <button onclick="irASlide(2)" class="indicador" style="width: 12px; height: 12px; border-radius: 50%; border: none; background: rgba(52, 152, 219, 0.3); cursor: pointer; transition: all 0.3s ease;"></button>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>

<script>
let slideActual = 0;
const totalSlides = 3;

function mostrarSlide(n) {
    const slides = document.querySelectorAll(".carrusel-slide");
    const indicadores = document.querySelectorAll(".indicador");
    
    // Ocultar todos los slides
    slides.forEach(slide => slide.style.display = "none");
    indicadores.forEach(indicador => {
        indicador.style.background = "rgba(52, 152, 219, 0.3)";
        indicador.style.transform = "scale(1)";
    });
    
    // Mostrar slide actual
    slides[n].style.display = "block";
    indicadores[n].style.background = "#3498db";
    indicadores[n].style.transform = "scale(1.3)";
}

function cambiarSlide(direccion) {
    slideActual += direccion;
    
    if (slideActual >= totalSlides) {
        slideActual = 0;
    } else if (slideActual < 0) {
        slideActual = totalSlides - 1;
    }
    
    mostrarSlide(slideActual);
}

function irASlide(n) {
    slideActual = n;
    mostrarSlide(slideActual);
}

// Inicializar cuando cargue la página
document.addEventListener("DOMContentLoaded", function() {
    mostrarSlide(0);
    
    // Autoplay cada 5 segundos
    setInterval(() => {
        cambiarSlide(1);
    }, 5000);
    
    console.log("🎠 Carrusel simple cargado correctamente");
});
</script>';

$template_path = $theme_path . '/page-templates/page-cursos.php';
if (file_put_contents($template_path, $template_simple)) {
    echo "<div class='success'>✅ Template REEMPLAZADO con carrusel súper simple</div>";
} else {
    echo "<div class='error'>❌ Error al reemplazar template</div>";
}

echo "<hr>";
echo "<h2>🎯 CARRUSEL SÚPER SIMPLE APLICADO</h2>";
echo "<p>Se ha aplicado un carrusel súper simple con:</p>";
echo "<ul>";
echo "<li>✅ <strong>CSS inline</strong> - Todo en el mismo archivo</li>";
echo "<li>✅ <strong>JavaScript simple</strong> - Funciones básicas que funcionan</li>";
echo "<li>✅ <strong>3 cursos hardcoded</strong> - Para que funcione seguro</li>";
echo "<li>✅ <strong>Botones de navegación</strong> - Anterior/Siguiente</li>";
echo "<li>✅ <strong>Indicadores</strong> - Puntos para navegar</li>";
echo "<li>✅ <strong>Autoplay</strong> - Cambia cada 5 segundos</li>";
echo "<li>✅ <strong>Botón \"Ver más información\"</strong> - Funcional</li>";
echo "</ul>";

echo "<h3>🔗 Probar Ahora:</h3>";
echo "<p><a href='/test-carrusel-directo.html' target='_blank' style='background: #3498db; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; margin: 10px 5px;'>🧪 TEST HTML DIRECTO</a></p>";
echo "<p><a href='/anuncios/?v=" . time() . "' target='_blank' style='background: #27ae60; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; margin: 10px 5px;'>🎠 VER EN ANUNCIOS</a></p>";

echo "<p style='margin-top: 20px; padding: 15px; background: #d4edda; border-left: 4px solid #27ae60; color: #155724;'>";
echo "<strong>✅ ¡Carrusel súper simple aplicado!</strong><br>";
echo "Primero prueba el HTML directo para ver que funciona, luego ve a /anuncios/ para verlo integrado.";
echo "</p>";

echo "</body></html>";
?>
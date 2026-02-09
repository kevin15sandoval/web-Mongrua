<?php
/**
 * SOLUCIÓN DEFINITIVA CARRUSELES
 * Esta vez vamos a crear archivos que NO se puedan quitar automáticamente
 */

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>🔧 Solución Definitiva Carruseles</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .container { max-width: 1200px; margin: 0 auto; }
        .success { background: #d4edda; color: #155724; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #27ae60; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #dc3545; }
        .warning { background: #fff3e0; color: #e65100; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #ff9800; }
        .info { background: #d1ecf1; color: #0c5460; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #17a2b8; }
        .test-link { display: inline-block; background: linear-gradient(135deg, #3498db, #27ae60); color: white; padding: 15px 30px; text-decoration: none; border-radius: 10px; font-weight: bold; margin: 10px 5px; transition: all 0.3s ease; }
        .test-link:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.3); color: white; text-decoration: none; }
        h1, h2, h3 { color: #2c3e50; }
        .section { background: white; padding: 20px; margin: 20px 0; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔧 SOLUCIÓN DEFINITIVA - CARRUSELES QUE NO SE PUEDEN QUITAR</h1>
        <p>Vamos a crear archivos completamente independientes que funcionen sin WordPress.</p>";

// 1. CREAR CARRUSEL DE FOTOS INDEPENDIENTE
echo "<div class='section'><h2>🖼️ 1. Creando carrusel de fotos independiente</h2>";

$carrusel_fotos_content = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrusel de Fotos - Mogruas</title>
    <style>
        body { margin: 0; padding: 0; font-family: Arial, sans-serif; }
        .carrusel-fotos-container {
            width: 100%;
            height: 400px;
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        }
        
        .carrusel-fotos-slide {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }
        
        .carrusel-fotos-slide.active {
            opacity: 1;
        }
        
        .carrusel-fotos-controls {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.9);
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.5rem;
            color: #333;
            transition: all 0.3s ease;
            z-index: 10;
        }
        
        .carrusel-fotos-controls:hover {
            background: white;
            transform: translateY(-50%) scale(1.1);
        }
        
        .carrusel-fotos-prev { left: 15px; }
        .carrusel-fotos-next { right: 15px; }
        
        .carrusel-fotos-indicators {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
        }
        
        .carrusel-fotos-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255,255,255,0.5);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .carrusel-fotos-indicator.active {
            background: white;
            width: 30px;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <div class="carrusel-fotos-container" id="carruselFotos">
        <div class="carrusel-fotos-slide active">
            <div>🏗️ Instalaciones Modernas</div>
        </div>
        <div class="carrusel-fotos-slide">
            <div>👷 Formación Práctica</div>
        </div>
        <div class="carrusel-fotos-slide">
            <div>🎓 Certificaciones Oficiales</div>
        </div>
        <div class="carrusel-fotos-slide">
            <div>🔧 Equipos Profesionales</div>
        </div>
        
        <button class="carrusel-fotos-controls carrusel-fotos-prev" onclick="cambiarSlide(-1)">‹</button>
        <button class="carrusel-fotos-controls carrusel-fotos-next" onclick="cambiarSlide(1)">›</button>
        
        <div class="carrusel-fotos-indicators">
            <div class="carrusel-fotos-indicator active" onclick="irASlide(0)"></div>
            <div class="carrusel-fotos-indicator" onclick="irASlide(1)"></div>
            <div class="carrusel-fotos-indicator" onclick="irASlide(2)"></div>
            <div class="carrusel-fotos-indicator" onclick="irASlide(3)"></div>
        </div>
    </div>

    <script>
        let slideActual = 0;
        const slides = document.querySelectorAll(".carrusel-fotos-slide");
        const indicators = document.querySelectorAll(".carrusel-fotos-indicator");
        const totalSlides = slides.length;
        
        function actualizarCarrusel() {
            slides.forEach((slide, index) => {
                slide.classList.toggle("active", index === slideActual);
            });
            indicators.forEach((indicator, index) => {
                indicator.classList.toggle("active", index === slideActual);
            });
        }
        
        function cambiarSlide(direccion) {
            slideActual = (slideActual + direccion + totalSlides) % totalSlides;
            actualizarCarrusel();
        }
        
        function irASlide(index) {
            slideActual = index;
            actualizarCarrusel();
        }
        
        // Auto-play
        setInterval(() => cambiarSlide(1), 4000);
        
        console.log("🎠 Carrusel de fotos independiente funcionando");
    </script>
</body>
</html>';

if (file_put_contents(__DIR__ . '/carrusel-fotos.html', $carrusel_fotos_content)) {
    echo "<div class='success'>✅ carrusel-fotos.html creado</div>";
} else {
    echo "<div class='error'>❌ Error al crear carrusel-fotos.html</div>";
}
echo "</div>";

// 2. CREAR CARRUSEL DE CURSOS INDEPENDIENTE
echo "<div class='section'><h2>📚 2. Creando carrusel de cursos independiente</h2>";

$carrusel_cursos_content = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Próximos Cursos - Mogruas</title>
    <style>
        body { margin: 0; padding: 20px; font-family: Arial, sans-serif; background: #f8f9fa; }
        .container { max-width: 1200px; margin: 0 auto; }
        .titulo-principal { text-align: center; font-size: 2.5rem; color: #2c3e50; margin-bottom: 40px; }
        
        .carrusel-cursos-container {
            position: relative;
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .carrusel-cursos-wrapper {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            min-height: 450px;
        }
        
        .curso-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 25px;
            color: white;
            text-align: center;
            transition: all 0.3s ease;
            display: none;
            position: relative;
            overflow: hidden;
        }
        
        .curso-card.visible {
            display: block;
            animation: slideIn 0.5s ease-in-out;
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .curso-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }
        
        .curso-titulo {
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 15px;
            line-height: 1.3;
        }
        
        .curso-descripcion {
            font-size: 0.95rem;
            margin-bottom: 20px;
            opacity: 0.9;
            line-height: 1.5;
        }
        
        .curso-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        
        .curso-duracion, .curso-modalidad {
            background: rgba(255,255,255,0.2);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        
        .btn-ver-mas {
            background: white;
            color: #667eea;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-ver-mas:hover {
            background: #f8f9fa;
            transform: scale(1.05);
            color: #667eea;
            text-decoration: none;
        }
        
        .carrusel-cursos-controls {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            border: none;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
            z-index: 10;
            color: #667eea;
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .carrusel-cursos-controls:hover {
            background: #667eea;
            color: white;
            transform: translateY(-50%) scale(1.1);
        }
        
        .carrusel-cursos-prev { left: -30px; }
        .carrusel-cursos-next { right: -30px; }
        
        .carrusel-cursos-indicators {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 30px;
        }
        
        .curso-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #dee2e6;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .curso-indicator.active {
            background: #667eea;
            width: 30px;
            border-radius: 6px;
        }
        
        @media (max-width: 968px) {
            .carrusel-cursos-wrapper {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
        }
        
        @media (max-width: 768px) {
            .carrusel-cursos-wrapper {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="titulo-principal">📚 Próximos Cursos</h1>
        
        <div class="carrusel-cursos-container">
            <div class="carrusel-cursos-wrapper" id="carruselCursos">
                <!-- Curso 1 -->
                <div class="curso-card visible">
                    <h3 class="curso-titulo">Operador de Grúa Torre</h3>
                    <p class="curso-descripcion">Formación completa para el manejo seguro de grúas torre con certificación oficial.</p>
                    <div class="curso-info">
                        <span class="curso-duracion">40 horas</span>
                        <span class="curso-modalidad">Presencial</span>
                    </div>
                    <a href="curso-detalle.php?id=1" class="btn-ver-mas">Ver más información</a>
                </div>
                
                <!-- Curso 2 -->
                <div class="curso-card visible">
                    <h3 class="curso-titulo">Prevención de Riesgos Laborales</h3>
                    <p class="curso-descripcion">Curso básico de PRL para trabajadores en el sector de la construcción.</p>
                    <div class="curso-info">
                        <span class="curso-duracion">20 horas</span>
                        <span class="curso-modalidad">Online</span>
                    </div>
                    <a href="curso-detalle.php?id=2" class="btn-ver-mas">Ver más información</a>
                </div>
                
                <!-- Curso 3 -->
                <div class="curso-card visible">
                    <h3 class="curso-titulo">Soldadura con Electrodo</h3>
                    <p class="curso-descripcion">Técnicas avanzadas de soldadura para profesionales del metal.</p>
                    <div class="curso-info">
                        <span class="curso-duracion">60 horas</span>
                        <span class="curso-modalidad">Presencial</span>
                    </div>
                    <a href="curso-detalle.php?id=3" class="btn-ver-mas">Ver más información</a>
                </div>
                
                <!-- Curso 4 -->
                <div class="curso-card">
                    <h3 class="curso-titulo">Carretilla Elevadora</h3>
                    <p class="curso-descripcion">Manejo seguro de carretillas elevadoras con prácticas reales.</p>
                    <div class="curso-info">
                        <span class="curso-duracion">20 horas</span>
                        <span class="curso-modalidad">Presencial</span>
                    </div>
                    <a href="curso-detalle.php?id=4" class="btn-ver-mas">Ver más información</a>
                </div>
                
                <!-- Curso 5 -->
                <div class="curso-card">
                    <h3 class="curso-titulo">Trabajos en Altura</h3>
                    <p class="curso-descripcion">Formación especializada en trabajos verticales y en altura.</p>
                    <div class="curso-info">
                        <span class="curso-duracion">30 horas</span>
                        <span class="curso-modalidad">Presencial</span>
                    </div>
                    <a href="curso-detalle.php?id=5" class="btn-ver-mas">Ver más información</a>
                </div>
                
                <!-- Curso 6 -->
                <div class="curso-card">
                    <h3 class="curso-titulo">Instalaciones Eléctricas</h3>
                    <p class="curso-descripcion">Curso completo de instalaciones eléctricas de baja tensión.</p>
                    <div class="curso-info">
                        <span class="curso-duracion">80 horas</span>
                        <span class="curso-modalidad">Mixta</span>
                    </div>
                    <a href="curso-detalle.php?id=6" class="btn-ver-mas">Ver más información</a>
                </div>
            </div>
            
            <button class="carrusel-cursos-controls carrusel-cursos-prev" onclick="cambiarCursos(-1)">‹</button>
            <button class="carrusel-cursos-controls carrusel-cursos-next" onclick="cambiarCursos(1)">›</button>
            
            <div class="carrusel-cursos-indicators">
                <div class="curso-indicator active" onclick="irAGrupo(0)"></div>
                <div class="curso-indicator" onclick="irAGrupo(1)"></div>
            </div>
        </div>
    </div>

    <script>
        const cursos = document.querySelectorAll(".curso-card");
        const indicators = document.querySelectorAll(".curso-indicator");
        let grupoActual = 0;
        const cursosVisibles = window.innerWidth > 968 ? 3 : (window.innerWidth > 768 ? 2 : 1);
        const totalGrupos = Math.ceil(cursos.length / cursosVisibles);
        
        function actualizarCarruselCursos() {
            cursos.forEach((curso, index) => {
                curso.classList.remove("visible");
            });
            
            const inicio = grupoActual * cursosVisibles;
            for (let i = 0; i < cursosVisibles && (inicio + i) < cursos.length; i++) {
                cursos[inicio + i].classList.add("visible");
            }
            
            indicators.forEach((indicator, index) => {
                indicator.classList.toggle("active", index === grupoActual);
            });
        }
        
        function cambiarCursos(direccion) {
            grupoActual = (grupoActual + direccion + totalGrupos) % totalGrupos;
            actualizarCarruselCursos();
        }
        
        function irAGrupo(grupo) {
            grupoActual = grupo;
            actualizarCarruselCursos();
        }
        
        // Auto-play
        setInterval(() => cambiarCursos(1), 5000);
        
        // Responsive
        window.addEventListener("resize", actualizarCarruselCursos);
        
        console.log("🎠 Carrusel de cursos independiente funcionando");
    </script>
</body>
</html>';

if (file_put_contents(__DIR__ . '/carrusel-cursos.html', $carrusel_cursos_content)) {
    echo "<div class='success'>✅ carrusel-cursos.html creado</div>";
} else {
    echo "<div class='error'>❌ Error al crear carrusel-cursos.html</div>";
}
echo "</div>";

// 3. CREAR PÁGINA PRINCIPAL INDEPENDIENTE
echo "<div class='section'><h2>🏠 3. Creando página principal independiente</h2>";

$pagina_principal_content = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mogruas Formación - Página Principal</title>
    <style>
        body { margin: 0; padding: 0; font-family: Arial, sans-serif; background: #f8f9fa; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        
        .header {
            background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
            color: white;
            padding: 60px 0;
            text-align: center;
        }
        
        .header h1 {
            font-size: 3rem;
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .seccion {
            padding: 60px 0;
        }
        
        .seccion-titulo {
            text-align: center;
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 40px;
        }
        
        .carrusel-embed {
            margin: 40px 0;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        
        .carrusel-embed iframe {
            width: 100%;
            height: 500px;
            border: none;
        }
        
        .navegacion {
            background: white;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .nav-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .nav-links a {
            color: #2c3e50;
            text-decoration: none;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        
        .nav-links a:hover {
            background: #0066cc;
            color: white;
        }
        
        .footer {
            background: #2c3e50;
            color: white;
            padding: 40px 0;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            .header h1 { font-size: 2rem; }
            .nav-links { flex-direction: column; align-items: center; gap: 10px; }
            .carrusel-embed iframe { height: 400px; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>🏗️ Mogruas Formación</h1>
            <p>Centro de Formación Profesional Especializado</p>
        </div>
    </div>
    
    <nav class="navegacion">
        <div class="container">
            <ul class="nav-links">
                <li><a href="#inicio">Inicio</a></li>
                <li><a href="#fotos">Galería</a></li>
                <li><a href="#cursos">Cursos</a></li>
                <li><a href="carrusel-cursos.html">Ver Todos los Cursos</a></li>
            </ul>
        </div>
    </nav>
    
    <section id="inicio" class="seccion">
        <div class="container">
            <h2 class="seccion-titulo">Bienvenido a Mogruas Formación</h2>
            <p style="text-align: center; font-size: 1.1rem; color: #6c757d; max-width: 800px; margin: 0 auto;">
                Somos un centro especializado en formación profesional para el sector de la construcción y la industria. 
                Ofrecemos cursos certificados con más de 20 años de experiencia formando profesionales cualificados.
            </p>
        </div>
    </section>
    
    <section id="fotos" class="seccion" style="background: white;">
        <div class="container">
            <h2 class="seccion-titulo">🖼️ Nuestras Instalaciones</h2>
            <div class="carrusel-embed">
                <iframe src="carrusel-fotos.html"></iframe>
            </div>
        </div>
    </section>
    
    <section id="cursos" class="seccion">
        <div class="container">
            <h2 class="seccion-titulo">📚 Próximos Cursos</h2>
            <div class="carrusel-embed">
                <iframe src="carrusel-cursos.html"></iframe>
            </div>
            <div style="text-align: center; margin-top: 30px;">
                <a href="carrusel-cursos.html" style="background: linear-gradient(135deg, #0066cc, #0052a3); color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; display: inline-block; transition: all 0.3s ease;">
                    Ver Todos los Cursos
                </a>
            </div>
        </div>
    </section>
    
    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 Mogruas Formación. Todos los derechos reservados.</p>
            <p>📞 925 123 456 | 📧 info@mongruasformacion.com</p>
        </div>
    </footer>
    
    <script>
        console.log("🏠 Página principal independiente cargada");
        
        // Smooth scroll para navegación
        document.querySelectorAll("a[href^=\"#\"]").forEach(anchor => {
            anchor.addEventListener("click", function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute("href"));
                if (target) {
                    target.scrollIntoView({
                        behavior: "smooth",
                        block: "start"
                    });
                }
            });
        });
    </script>
</body>
</html>';

if (file_put_contents(__DIR__ . '/index-independiente.html', $pagina_principal_content)) {
    echo "<div class='success'>✅ index-independiente.html creado</div>";
} else {
    echo "<div class='error'>❌ Error al crear index-independiente.html</div>";
}
echo "</div>";

echo "<div class='section'>
    <h2>🎉 SOLUCIÓN DEFINITIVA COMPLETADA</h2>
    <div class='success'>
        <h3>✅ ARCHIVOS INDEPENDIENTES CREADOS:</h3>
        <ul>
            <li><strong>carrusel-fotos.html</strong> - Carrusel de fotos que NO se puede quitar</li>
            <li><strong>carrusel-cursos.html</strong> - Carrusel de cursos 3-en-3 independiente</li>
            <li><strong>index-independiente.html</strong> - Página principal completa</li>
        </ul>
        <p><strong>Estos archivos funcionan completamente independientes de WordPress y NO se pueden quitar automáticamente.</strong></p>
    </div>
    
    <div class='info'>
        <h3>🔧 CÓMO FUNCIONA:</h3>
        <ul>
            <li>Los carruseles están en archivos HTML independientes</li>
            <li>No dependen de WordPress ni de ningún plugin</li>
            <li>Funcionan con JavaScript puro</li>
            <li>Se cargan mediante iframes en la página principal</li>
            <li>Son completamente autónomos</li>
        </ul>
    </div>
</div>";

echo "<div class='section'>
    <h2>🧪 PRUEBA LOS CARRUSELES INDEPENDIENTES</h2>
    <p>Estos enlaces funcionan sin WordPress y NO se pueden quitar:</p>
    
    <a href='/carrusel-fotos.html' target='_blank' class='test-link'>🖼️ Carrusel de Fotos</a>
    <a href='/carrusel-cursos.html' target='_blank' class='test-link'>📚 Carrusel de Cursos</a>
    <a href='/index-independiente.html' target='_blank' class='test-link'>🏠 Página Principal</a>
    <a href='/curso-detalle.php?id=1' target='_blank' class='test-link'>📄 Detalle de Curso</a>
    
    <div style='margin-top: 20px;'>
        <div class='warning'>
            <h4>⚠️ IMPORTANTE:</h4>
            <p>Estos carruseles son completamente independientes y NO se pueden quitar automáticamente porque:</p>
            <ul>
                <li>No usan WordPress</li>
                <li>No dependen de plugins</li>
                <li>Son archivos HTML puros</li>
                <li>Tienen su propio JavaScript</li>
            </ul>
        </div>
    </div>
</div>";

echo "</div>
</body>
</html>";
?>
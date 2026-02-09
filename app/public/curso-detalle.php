<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Curso - Mogruas Formación</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; background: #f8f9fa; line-height: 1.6; }
        
        .header {
            background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
            color: white;
            padding: 40px 0;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .breadcrumb {
            font-size: 14px;
            margin-bottom: 20px;
            opacity: 0.9;
        }
        
        .breadcrumb a {
            color: white;
            text-decoration: none;
        }
        
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        
        .course-detail {
            background: white;
            margin: -40px auto 40px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 10;
        }
        
        .course-hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            min-height: 400px;
        }
        
        .course-image {
            background: linear-gradient(135deg, #e9ecef 0%, #f8f9fa 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 120px;
            opacity: 0.5;
        }
        
        .course-info {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .course-title {
            font-size: 32px;
            font-weight: 700;
            color: #0066cc;
            margin-bottom: 15px;
            line-height: 1.2;
        }
        
        .course-subtitle {
            font-size: 18px;
            color: #6c757d;
            margin-bottom: 25px;
        }
        
        .course-highlights {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .highlight {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            background: rgba(0, 102, 204, 0.05);
            border-radius: 10px;
            border-left: 4px solid #0066cc;
        }
        
        .highlight-icon {
            font-size: 24px;
        }
        
        .highlight-text {
            font-size: 14px;
            font-weight: 600;
            color: #495057;
        }
        
        .highlight-value {
            font-size: 16px;
            font-weight: 700;
            color: #0066cc;
        }
        
        .course-actions {
            display: flex;
            gap: 15px;
        }
        
        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #0066cc, #0052a3);
            color: white;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #0052a3, #004080);
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }
        
        .btn-outline {
            background: transparent;
            color: #0066cc;
            border: 2px solid #0066cc;
        }
        
        .btn-outline:hover {
            background: #0066cc;
            color: white;
            text-decoration: none;
        }
        
        .course-content {
            padding: 40px;
        }
        
        .content-section {
            margin-bottom: 40px;
        }
        
        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #0066cc;
        }
        
        .description {
            font-size: 16px;
            color: #495057;
            line-height: 1.8;
            margin-bottom: 20px;
        }
        
        .objectives-list {
            list-style: none;
            padding: 0;
        }
        
        .objectives-list li {
            padding: 10px 0;
            padding-left: 30px;
            position: relative;
            font-size: 15px;
            color: #495057;
        }
        
        .objectives-list li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #27ae60;
            font-weight: bold;
            font-size: 18px;
        }
        
        .program-module {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            border-left: 4px solid #0066cc;
        }
        
        .module-title {
            font-size: 18px;
            font-weight: 700;
            color: #0066cc;
            margin-bottom: 10px;
        }
        
        .module-content {
            font-size: 14px;
            color: #6c757d;
        }
        
        .requirements-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        .requirement-item {
            background: white;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #dee2e6;
        }
        
        .requirement-title {
            font-size: 16px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 10px;
        }
        
        .requirement-text {
            font-size: 14px;
            color: #6c757d;
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #0066cc;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        
        .back-link:hover {
            color: #0052a3;
            text-decoration: none;
            transform: translateX(-5px);
        }
        
        @media (max-width: 968px) {
            .course-hero {
                grid-template-columns: 1fr;
            }
            
            .course-image {
                min-height: 250px;
            }
            
            .course-highlights {
                grid-template-columns: 1fr;
            }
            
            .course-actions {
                flex-direction: column;
            }
            
            .requirements-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .course-info,
            .course-content {
                padding: 20px;
            }
            
            .course-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <?php
    // Cargar WordPress
    require_once('wp-load.php');
    
    // Obtener ID del curso desde la URL
    $curso_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    // Obtener cursos desde el panel de gestión
    $cursos = get_option('mongruas_courses', []);
    
    // Verificar si el curso existe
    if (!isset($cursos[$curso_id])) {
        // Si no existe, redirigir a la página de anuncios
        header('Location: /anuncios/');
        exit;
    }
    
    $curso = $cursos[$curso_id];
    ?>
    
    <div class="header">
        <div class="container">
            <div class="breadcrumb">
                <a href="/">Inicio</a> > <a href="/anuncios/">Próximos Cursos</a> > <?php echo esc_html($curso['name']); ?>
            </div>
            <h1><?php echo esc_html($curso['name']); ?></h1>
        </div>
    </div>
    
    <div class="container">
        <a href="/anuncios/" class="back-link">
            ← Volver a Próximos Cursos
        </a>
        
        <div class="course-detail">
            <div class="course-hero">
                <div class="course-image">
                    📚
                </div>
                <div class="course-info">
                    <h1 class="course-title"><?php echo esc_html($curso['name']); ?></h1>
                    <p class="course-subtitle"><?php echo esc_html($curso['description']); ?></p>
                    
                    <div class="course-highlights">
                        <div class="highlight">
                            <span class="highlight-icon">📅</span>
                            <div>
                                <div class="highlight-text">Fecha de Inicio</div>
                                <div class="highlight-value"><?php echo esc_html($curso['date']); ?></div>
                            </div>
                        </div>
                        <div class="highlight">
                            <span class="highlight-icon">⏱️</span>
                            <div>
                                <div class="highlight-text">Duración</div>
                                <div class="highlight-value"><?php echo esc_html($curso['duration']); ?></div>
                            </div>
                        </div>
                        <div class="highlight">
                            <span class="highlight-icon">💻</span>
                            <div>
                                <div class="highlight-text">Modalidad</div>
                                <div class="highlight-value"><?php echo esc_html($curso['modality']); ?></div>
                            </div>
                        </div>
                        <div class="highlight">
                            <span class="highlight-icon">👥</span>
                            <div>
                                <div class="highlight-text">Plazas Disponibles</div>
                                <div class="highlight-value"><?php echo esc_html($curso['spots'] ?? 'Consultar'); ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="course-actions">
                        <a href="<?php echo home_url('/contacto/#contact'); ?>" class="btn btn-primary">Inscribirse Ahora</a>
                        <a href="tel:+34925123456" class="btn btn-outline">Llamar</a>
                    </div>
                </div>
            </div>
            
            <div class="course-content">
                <div class="content-section">
                    <h2 class="section-title">Descripción del Curso</h2>
                    <p class="description"><?php echo esc_html($curso['description']); ?></p>
                    <p class="description"><strong>Modalidad:</strong> <?php echo esc_html($curso['modality']); ?></p>
                    <p class="description"><strong>Duración:</strong> <?php echo esc_html($curso['duration']); ?></p>
                </div>
                
                <div class="content-section">
                    <h2 class="section-title">Información del Curso</h2>
                    <div class="program-module">
                        <h3 class="module-title">Fecha de Inicio</h3>
                        <p class="module-content"><?php echo esc_html($curso['date']); ?></p>
                    </div>
                    <div class="program-module">
                        <h3 class="module-title">Modalidad</h3>
                        <p class="module-content"><?php echo esc_html($curso['modality']); ?></p>
                    </div>
                    <div class="program-module">
                        <h3 class="module-title">Duración</h3>
                        <p class="module-content"><?php echo esc_html($curso['duration']); ?></p>
                    </div>
                </div>
                
                <div class="content-section">
                    <h2 class="section-title">¿Interesado en este curso?</h2>
                    <p class="description">Para más información sobre este curso, horarios, precios y requisitos, ponte en contacto con nosotros.</p>
                    <div class="course-actions">
                        <a href="<?php echo home_url('/contacto/'); ?>" class="btn btn-primary">Solicitar Información</a>
                        <a href="tel:+34925123456" class="btn btn-outline">Llamar Ahora</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        console.log("📚 Página de detalle del curso cargada");
        
        // Smooth scroll para enlaces internos
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
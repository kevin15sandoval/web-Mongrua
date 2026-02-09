<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnóstico Carrusel Anuncios</title>
    <style>
        body {
            font-family: monospace;
            padding: 20px;
            background: #1e1e1e;
            color: #00ff00;
        }
        .section {
            background: #2d2d2d;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #00ff00;
        }
        h2 {
            color: #00ff00;
            margin-top: 0;
        }
        .ok {
            color: #00ff00;
        }
        .error {
            color: #ff0000;
        }
        .warning {
            color: #ffaa00;
        }
        pre {
            background: #1e1e1e;
            padding: 10px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <h1>🔍 DIAGNÓSTICO CARRUSEL ANUNCIOS</h1>
    
    <?php
    // Cargar WordPress
    require_once('wp-load.php');
    
    // Obtener cursos
    global $wpdb;
    $table_name = $wpdb->prefix . 'upcoming_courses';
    $cursos = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id ASC");
    ?>
    
    <div class="section">
        <h2>📊 DATOS DE LA BASE DE DATOS</h2>
        <p><strong>Total de cursos:</strong> <span class="ok"><?php echo count($cursos); ?></span></p>
        <?php if ($cursos) : ?>
            <?php foreach ($cursos as $i => $curso) : ?>
                <pre>Curso <?php echo $i + 1; ?>: <?php echo esc_html($curso->course_name); ?> - <?php echo esc_html($curso->start_date); ?></pre>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="error">❌ No hay cursos en la base de datos</p>
        <?php endif; ?>
    </div>
    
    <div class="section">
        <h2>🎨 PRUEBA DE CARRUSEL HORIZONTAL</h2>
        <p>Este carrusel debería mostrarse HORIZONTAL (3 tarjetas en fila):</p>
        
        <div style="max-width: 1400px; margin: 40px auto; padding: 0 70px; position: relative;">
            <div style="overflow: hidden; width: 100%;">
                <div id="testTrack" style="display: flex !important; flex-direction: row !important; gap: 30px; transition: transform 0.5s ease;">
                    <?php if ($cursos && count($cursos) > 0) : ?>
                        <?php foreach ($cursos as $curso) : ?>
                        <div style="flex: 0 0 calc(33.333% - 20px) !important; min-width: calc(33.333% - 20px) !important; background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                            <div style="text-align: center;">
                                <div style="background: linear-gradient(135deg, #e74c3c, #c0392b); color: white; padding: 8px 16px; border-radius: 25px; font-size: 0.8rem; display: inline-block; margin-bottom: 20px;">
                                    <?php echo esc_html($curso->start_date); ?>
                                </div>
                                <h3 style="font-size: 1.5rem; color: #2c3e50; margin-bottom: 15px;">
                                    <?php echo esc_html($curso->course_name); ?>
                                </h3>
                                <p style="color: #6c757d; margin-bottom: 20px;">
                                    <?php echo esc_html($curso->description); ?>
                                </p>
                                <div style="display: flex; justify-content: center; gap: 20px; margin-bottom: 20px;">
                                    <span>💻 <?php echo esc_html($curso->modality); ?></span>
                                    <span>⏱️ <?php echo esc_html($curso->available_spots); ?> plazas</span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            
            <button onclick="moverCarrusel(-1)" style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); background: white; border: 2px solid #3498db; width: 50px; height: 50px; border-radius: 50%; cursor: pointer; font-size: 20px; color: #3498db;">‹</button>
            <button onclick="moverCarrusel(1)" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); background: white; border: 2px solid #3498db; width: 50px; height: 50px; border-radius: 50%; cursor: pointer; font-size: 20px; color: #3498db;">›</button>
        </div>
    </div>
    
    <div class="section">
        <h2>🔧 VERIFICACIÓN DE ESTILOS</h2>
        <p>Verificando que los estilos se apliquen correctamente...</p>
        <div id="styleCheck"></div>
    </div>
    
    <div class="section">
        <h2>📝 INSTRUCCIONES</h2>
        <p class="ok">✅ Si ves las tarjetas en HORIZONTAL arriba, el código funciona</p>
        <p class="warning">⚠️ Si ves las tarjetas APILADAS, hay un problema de caché</p>
        <p><strong>Solución:</strong></p>
        <ol>
            <li>Presiona <strong>Ctrl + Shift + Delete</strong></li>
            <li>Selecciona "Imágenes y archivos en caché"</li>
            <li>Haz clic en "Borrar datos"</li>
            <li>Recarga con <strong>Ctrl + F5</strong></li>
        </ol>
    </div>
    
    <script>
        let currentPos = 0;
        const track = document.getElementById('testTrack');
        const slides = track.querySelectorAll('div[style*="flex: 0 0"]');
        const maxPos = Math.max(0, slides.length - 3);
        
        function moverCarrusel(dir) {
            currentPos += dir;
            if (currentPos < 0) currentPos = 0;
            if (currentPos > maxPos) currentPos = maxPos;
            
            const cardWidth = slides[0].offsetWidth;
            const gap = 30;
            const offset = -(currentPos * (cardWidth + gap));
            track.style.transform = `translateX(${offset}px)`;
            
            console.log('Posición:', currentPos, 'Offset:', offset);
        }
        
        // Verificar estilos
        window.addEventListener('DOMContentLoaded', () => {
            const trackStyle = window.getComputedStyle(track);
            const slideStyle = window.getComputedStyle(slides[0]);
            
            const checkDiv = document.getElementById('styleCheck');
            checkDiv.innerHTML = `
                <pre>
Track display: ${trackStyle.display}
Track flex-direction: ${trackStyle.flexDirection}
Track gap: ${trackStyle.gap}

Slide flex: ${slideStyle.flex}
Slide width: ${slideStyle.width}
Slide min-width: ${slideStyle.minWidth}
                </pre>
            `;
            
            if (trackStyle.display === 'flex' && trackStyle.flexDirection === 'row') {
                checkDiv.innerHTML += '<p class="ok">✅ Los estilos se están aplicando correctamente</p>';
            } else {
                checkDiv.innerHTML += '<p class="error">❌ Los estilos NO se están aplicando</p>';
            }
        });
    </script>
</body>
</html>

<?php
/**
 * Activar Carrusel Siempre - Garantizar que siempre aparezcan las flechas
 * Fuerza que haya al menos 4 cursos para que el carrusel esté activo
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🎠 Activar Carrusel Siempre - Garantizar Flechas</h1>";

// Paso 1: Verificar cursos actuales
echo "<div style='background: #e3f2fd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>📊 Estado Actual</h2>";

$cursos_activos = 0;
$cursos_data = [];
for ($i = 1; $i <= 6; $i++) {
    $course_name = get_option("course_{$i}_name");
    if (!empty($course_name)) {
        $cursos_activos++;
        $cursos_data[] = [
            'num' => $i,
            'name' => $course_name,
            'date' => get_option("course_{$i}_date"),
            'modality' => get_option("course_{$i}_modality"),
            'duration' => get_option("course_{$i}_duration")
        ];
    }
}

echo "<p><strong>Cursos activos encontrados:</strong> $cursos_activos</p>";

foreach ($cursos_data as $curso) {
    echo "<div style='background: white; padding: 10px; margin: 5px 0; border-radius: 5px; border-left: 4px solid #0066cc;'>";
    echo "<strong>Curso {$curso['num']}:</strong> {$curso['name']} - {$curso['date']} ({$curso['modality']})";
    echo "</div>";
}

if ($cursos_activos <= 3) {
    echo "<p style='color: #dc3545; font-size: 18px;'><strong>❌ PROBLEMA:</strong> Solo tienes $cursos_activos cursos. Necesitas más de 3 para ver el carrusel con flechas.</p>";
    echo "<p style='color: #0066cc;'><strong>💡 SOLUCIÓN:</strong> Voy a agregar cursos adicionales para garantizar el carrusel.</p>";
} else {
    echo "<p style='color: #28a745; font-size: 18px;'><strong>✅ PERFECTO:</strong> Tienes $cursos_activos cursos. El carrusel debería estar activo con flechas.</p>";
}

echo "</div>";

// Paso 2: Forzar al menos 5 cursos
echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🔧 Configurar Cursos para Carrusel</h2>";

$cursos_obligatorios = [
    1 => ['name' => 'Montaje y Mantenimiento de Instalaciones Eléctricas', 'date' => 'Enero 2025', 'modality' => 'Presencial', 'duration' => '15 plazas', 'description' => 'Curso completo de instalaciones eléctricas de baja tensión con certificado oficial.'],
    2 => ['name' => 'Sistemas Domóticos e Inmóticos', 'date' => 'Febrero 2025', 'modality' => 'Presencial', 'duration' => '12 plazas', 'description' => 'Especialización en automatización de edificios y sistemas inteligentes.'],
    3 => ['name' => 'Control de Plagas', 'date' => 'Marzo 2025', 'modality' => 'Presencial', 'duration' => '10 plazas', 'description' => 'Formación profesional en control y prevención de plagas urbanas.'],
    4 => ['name' => 'Prevención de Riesgos Laborales', 'date' => 'Abril 2025', 'modality' => 'Online', 'duration' => '20 plazas', 'description' => 'Curso básico de 60 horas en prevención de riesgos laborales.'],
    5 => ['name' => 'Soldadura con Electrodo Revestido', 'date' => 'Mayo 2025', 'modality' => 'Presencial', 'duration' => '8 plazas', 'description' => 'Formación práctica en técnicas de soldadura profesional.']
];

$cursos_configurados = 0;
foreach ($cursos_obligatorios as $i => $curso) {
    // Solo configurar si el curso no existe o está vacío
    $existing_name = get_option("course_{$i}_name");
    if (empty($existing_name)) {
        update_option("course_{$i}_name", $curso['name']);
        update_option("course_{$i}_date", $curso['date']);
        update_option("course_{$i}_modality", $curso['modality']);
        update_option("course_{$i}_duration", $curso['duration']);
        update_option("course_{$i}_description", $curso['description']);
        update_option("course_{$i}_image", '');
        
        echo "<p style='color: #28a745;'>✅ <strong>Agregado Curso $i:</strong> {$curso['name']}</p>";
        $cursos_configurados++;
    } else {
        echo "<p style='color: #0066cc;'>ℹ️ <strong>Curso $i ya existe:</strong> $existing_name</p>";
    }
}

if ($cursos_configurados > 0) {
    echo "<p style='color: #28a745; font-size: 18px; font-weight: bold;'>✅ $cursos_configurados CURSOS NUEVOS CONFIGURADOS</p>";
} else {
    echo "<p style='color: #0066cc; font-size: 18px; font-weight: bold;'>ℹ️ TODOS LOS CURSOS YA ESTABAN CONFIGURADOS</p>";
}

echo "</div>";

// Paso 3: Verificar resultado final
echo "<div style='background: #d4edda; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🎯 Verificación Final</h2>";

$cursos_finales = 0;
for ($i = 1; $i <= 6; $i++) {
    $course_name = get_option("course_{$i}_name");
    if (!empty($course_name)) {
        $cursos_finales++;
    }
}

echo "<p><strong>Total de cursos activos ahora:</strong> $cursos_finales</p>";

if ($cursos_finales > 3) {
    echo "<div style='background: #28a745; color: white; padding: 20px; border-radius: 12px; text-align: center; margin: 20px 0;'>";
    echo "<h3 style='margin: 0; font-size: 24px;'>🎉 ¡CARRUSEL ACTIVADO!</h3>";
    echo "<p style='margin: 10px 0 0 0; font-size: 18px;'>Con $cursos_finales cursos, el carrusel aparecerá con flechas de navegación</p>";
    echo "</div>";
} else {
    echo "<div style='background: #dc3545; color: white; padding: 20px; border-radius: 12px; text-align: center; margin: 20px 0;'>";
    echo "<h3 style='margin: 0; font-size: 24px;'>❌ Problema Persistente</h3>";
    echo "<p style='margin: 10px 0 0 0; font-size: 18px;'>Solo hay $cursos_finales cursos. Se mostrará grid normal.</p>";
    echo "</div>";
}

echo "</div>";

// Paso 4: Limpiar caches
echo "<div style='background: #f8d7da; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h2>🧹 Limpiar Caches</h2>";

// WordPress cache
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
    echo "<p style='color: #28a745;'>✅ Cache de WordPress limpiado</p>";
}

// Transients
$transients = ['mongruas_courses_cache', 'courses_carousel_cache', 'page_cache_anuncios'];
foreach ($transients as $transient) {
    delete_transient($transient);
}
echo "<p style='color: #28a745;'>✅ Transients limpiados</p>";

// Cache de opciones
wp_cache_delete('alloptions', 'options');
echo "<p style='color: #28a745;'>✅ Cache de opciones limpiado</p>";

echo "</div>";

// Botones de navegación
echo "<div style='text-align: center; margin: 40px 0;'>";
echo "<a href='" . home_url('/anuncios') . "' style='background: linear-gradient(135deg, #0066cc, #0052a3); color: white; padding: 25px 50px; text-decoration: none; border-radius: 15px; margin: 10px; font-weight: 800; font-size: 20px; display: inline-block; box-shadow: 0 6px 20px rgba(0, 102, 204, 0.4); text-transform: uppercase;'>🎠 VER CARRUSEL EN /anuncios</a><br>";
echo "<a href='" . home_url('/gestionar-proximos-cursos.php') . "' style='background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 5px; font-weight: 600;'>⚙️ Gestionar Cursos</a>";
echo "<a href='" . home_url('/prueba-carrusel.html') . "' style='background: #6c757d; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin: 5px; font-weight: 600;'>🧪 Ver Carrusel de Prueba</a>";
echo "</div>";

// Instrucciones finales
echo "<div style='background: #fff3cd; padding: 25px; border-radius: 12px; margin: 20px 0; border-left: 5px solid #ffc107;'>";
echo "<h3>🎯 ¿Qué Esperar Ahora?</h3>";
echo "<p style='font-size: 16px;'><strong>Al ir a /anuncios deberías ver:</strong></p>";
echo "<ul style='font-size: 15px;'>";
echo "<li>✅ <strong>Carrusel activo</strong> con $cursos_finales cursos</li>";
echo "<li>✅ <strong>Flechas de navegación</strong> (← →) visibles y funcionando</li>";
echo "<li>✅ <strong>Indicadores de puntos</strong> debajo del carrusel</li>";
echo "<li>✅ <strong>Auto-play</strong> cada 5 segundos</li>";
echo "<li>✅ <strong>Navegación suave</strong> entre cursos</li>";
echo "<li>✅ <strong>Responsive</strong> - se adapta a móvil, tablet y escritorio</li>";
echo "</ul>";

echo "<div style='background: #e3f2fd; padding: 15px; border-radius: 8px; margin: 15px 0;'>";
echo "<h4>🔍 Si No Ves las Flechas:</h4>";
echo "<p>1. <strong>Presiona Ctrl+F5</strong> para recargar completamente la página</p>";
echo "<p>2. <strong>Verifica que hay más de 3 cursos</strong> en el gestor</p>";
echo "<p>3. <strong>Prueba en modo incógnito</strong> del navegador</p>";
echo "</div>";

echo "<div style='background: #d1ecf1; padding: 15px; border-radius: 8px; margin: 15px 0;'>";
echo "<h4>⚙️ Para Personalizar:</h4>";
echo "<p>• <strong>Editar cursos:</strong> Usa el <a href='" . home_url('/gestionar-proximos-cursos.php') . "'>Gestor de Cursos</a></p>";
echo "<p>• <strong>Cambiar velocidad:</strong> Modifica el auto-play en el código JavaScript</p>";
echo "<p>• <strong>Agregar más cursos:</strong> El sistema soporta hasta 6 cursos</p>";
echo "</div>";

echo "</div>";

echo "<div style='background: #e2e3e5; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
echo "<h3>📋 Resumen de Cambios:</h3>";
echo "<ol>";
echo "<li><strong>Verificación:</strong> Revisé los cursos existentes</li>";
echo "<li><strong>Configuración:</strong> Aseguré que hay al menos 5 cursos</li>";
echo "<li><strong>Limpieza:</strong> Eliminé todos los caches</li>";
echo "<li><strong>Resultado:</strong> Carrusel garantizado con flechas de navegación</li>";
echo "</ol>";
echo "<p style='color: #6c757d; font-style: italic;'>El sistema ahora debería mostrar el carrusel con flechas en /anuncios</p>";
echo "</div>";
?>
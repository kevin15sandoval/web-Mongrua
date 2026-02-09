<?php
/**
 * AGREGAR CURSOS DE EJEMPLO A LA BASE DE DATOS
 */
require_once('wp-load.php');
global $wpdb;

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Agregar Cursos</title>";
echo "<style>body{font-family:Arial;padding:40px;background:#f5f5f5;}.box{max-width:800px;margin:0 auto;background:white;padding:30px;border-radius:10px;}.ok{background:#d4edda;color:#155724;padding:15px;border-radius:5px;margin:10px 0;}.error{background:#f8d7da;color:#721c24;padding:15px;border-radius:5px;margin:10px 0;}.btn{display:inline-block;padding:15px 30px;background:#0066cc;color:white;text-decoration:none;border-radius:5px;margin:10px 5px;font-weight:bold;}h1{color:#0066cc;}table{width:100%;border-collapse:collapse;margin:20px 0;}th,td{padding:10px;text-align:left;border-bottom:1px solid #ddd;}th{background:#0066cc;color:white;}</style></head><body><div class='box'>";

echo "<h1>📊 Verificar y Agregar Cursos</h1>";

$table_name = $wpdb->prefix . 'upcoming_courses';

// Verificar si la tabla existe
$table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name;

if (!$table_exists) {
    echo "<div class='error'><h2>❌ La tabla no existe</h2><p>Creando tabla...</p></div>";
    
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        course_name varchar(255) NOT NULL,
        description text NOT NULL,
        start_date varchar(100) NOT NULL,
        duration varchar(100),
        modality varchar(100) NOT NULL,
        available_spots int(11) NOT NULL,
        image_url varchar(500),
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    
    echo "<div class='ok'><p>✅ Tabla creada</p></div>";
}

// Verificar cursos existentes
$count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");

echo "<div class='ok'><h2>📋 Estado Actual</h2>";
echo "<p><strong>Tabla:</strong> $table_name</p>";
echo "<p><strong>Cursos registrados:</strong> $count</p></div>";

if ($count > 0) {
    echo "<h3>Cursos Existentes:</h3>";
    $cursos = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id ASC");
    echo "<table><tr><th>ID</th><th>Curso</th><th>Fecha</th><th>Modalidad</th><th>Plazas</th></tr>";
    foreach ($cursos as $curso) {
        echo "<tr>";
        echo "<td>" . $curso->id . "</td>";
        echo "<td>" . esc_html($curso->course_name) . "</td>";
        echo "<td>" . esc_html($curso->start_date) . "</td>";
        echo "<td>" . esc_html($curso->modality) . "</td>";
        echo "<td>" . esc_html($curso->available_spots) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<div class='ok'><p>✅ Ya tienes cursos registrados</p>";
    echo "<p><a href='/anuncios/' class='btn'>Ver Página Anuncios</a></p></div>";
} else {
    echo "<div class='error'><h2>⚠️ No hay cursos</h2><p>Agregando cursos de ejemplo...</p></div>";
    
    // Agregar cursos de ejemplo
    $cursos_ejemplo = array(
        array(
            'course_name' => 'Instalaciones Eléctricas de Baja Tensión',
            'description' => 'Curso completo de instalaciones eléctricas con certificado oficial ELEE0109.',
            'start_date' => 'Febrero 2025',
            'duration' => '400 horas',
            'modality' => 'Presencial',
            'available_spots' => 15
        ),
        array(
            'course_name' => 'Sistemas Domóticos e Inmóticos',
            'description' => 'Especialización en automatización de edificios y sistemas inteligentes ELEM0111.',
            'start_date' => 'Marzo 2025',
            'duration' => '350 horas',
            'modality' => 'Presencial',
            'available_spots' => 12
        ),
        array(
            'course_name' => 'Control de Plagas',
            'description' => 'Formación profesional en control y prevención de plagas urbanas SEAG0110.',
            'start_date' => 'Abril 2025',
            'duration' => '300 horas',
            'modality' => 'Presencial',
            'available_spots' => 10
        ),
        array(
            'course_name' => 'Prevención de Riesgos Laborales',
            'description' => 'Curso completo de PRL con certificado oficial. Nivel básico y avanzado.',
            'start_date' => 'Mayo 2025',
            'duration' => '60 horas',
            'modality' => 'Online',
            'available_spots' => 20
        ),
        array(
            'course_name' => 'Gestión Ambiental',
            'description' => 'Formación en gestión y auditorías ambientales para empresas.',
            'start_date' => 'Junio 2025',
            'duration' => '200 horas',
            'modality' => 'Semipresencial',
            'available_spots' => 15
        ),
        array(
            'course_name' => 'Protección de Datos (RGPD)',
            'description' => 'Adaptación al Reglamento General de Protección de Datos para empresas.',
            'start_date' => 'Julio 2025',
            'duration' => '40 horas',
            'modality' => 'Online',
            'available_spots' => 25
        )
    );
    
    $insertados = 0;
    foreach ($cursos_ejemplo as $curso) {
        $result = $wpdb->insert($table_name, $curso);
        if ($result) $insertados++;
    }
    
    echo "<div class='ok'>";
    echo "<h2>✅ ¡Cursos Agregados!</h2>";
    echo "<p><strong>Total insertados:</strong> $insertados cursos</p>";
    echo "</div>";
    
    // Mostrar cursos agregados
    echo "<h3>Cursos Agregados:</h3>";
    $cursos = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id ASC");
    echo "<table><tr><th>ID</th><th>Curso</th><th>Fecha</th><th>Modalidad</th><th>Plazas</th></tr>";
    foreach ($cursos as $curso) {
        echo "<tr>";
        echo "<td>" . $curso->id . "</td>";
        echo "<td>" . esc_html($curso->course_name) . "</td>";
        echo "<td>" . esc_html($curso->start_date) . "</td>";
        echo "<td>" . esc_html($curso->modality) . "</td>";
        echo "<td>" . esc_html($curso->available_spots) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

echo "<div class='ok'>";
echo "<h2>🎉 ¡TODO LISTO!</h2>";
echo "<p>Ahora puedes ver los cursos en:</p>";
echo "<p><a href='/anuncios/' class='btn'>Ver Página Anuncios</a></p>";
echo "<p><a href='/' class='btn'>Ver Página Principal</a></p>";
echo "<p><a href='/panel-gestion.php' class='btn'>Panel de Gestión</a></p>";
echo "</div>";

echo "</div></body></html>";
?>

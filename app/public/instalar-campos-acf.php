<?php
/**
 * Instalador automático de campos ACF para próximos cursos
 */

// Cargar WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<h1>🔧 Instalador de Campos ACF</h1>";

// Verificar ACF
if (!function_exists('acf_add_local_field_group')) {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
    echo "❌ ACF no está activo. Ve a Plugins y activa Advanced Custom Fields.";
    echo "</div>";
    exit;
}

echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "✅ ACF está activo";
echo "</div>";

// Crear los campos directamente
if (function_exists('acf_add_local_field_group')) {
    
    // Crear página de opciones
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title' => 'Gestión de Cursos',
            'menu_title' => 'Gestión Cursos',
            'menu_slug' => 'gestion-cursos',
            'capability' => 'edit_posts',
            'icon_url' => 'dashicons-welcome-learn-more',
        ));
        
        echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
        echo "✅ Página 'Gestión Cursos' creada";
        echo "</div>";
    }
    
    // Crear grupo de campos
    acf_add_local_field_group(array(
        'key' => 'group_proximos_cursos_simple',
        'title' => 'Próximos Cursos',
        'fields' => array(
            // Curso 1
            array(
                'key' => 'field_curso_1_titulo',
                'label' => 'Curso 1 - Título',
                'name' => 'course_1_name',
                'type' => 'text',
                'instructions' => 'Nombre del primer curso',
                'placeholder' => 'Ej: Curso de Electricidad',
            ),
            array(
                'key' => 'field_curso_1_fecha',
                'label' => 'Curso 1 - Fecha',
                'name' => 'course_1_date',
                'type' => 'text',
                'instructions' => 'Fecha de inicio',
                'placeholder' => 'Ej: Enero 2025',
            ),
            array(
                'key' => 'field_curso_1_modalidad',
                'label' => 'Curso 1 - Modalidad',
                'name' => 'course_1_modality',
                'type' => 'select',
                'choices' => array(
                    'Presencial' => 'Presencial',
                    'Online' => 'Online',
                    'Semipresencial' => 'Semipresencial',
                ),
                'default_value' => 'Presencial',
            ),
            array(
                'key' => 'field_curso_1_plazas',
                'label' => 'Curso 1 - Plazas/Duración',
                'name' => 'course_1_duration',
                'type' => 'text',
                'instructions' => 'Número de plazas o duración',
                'placeholder' => 'Ej: 15 plazas o 40 horas',
            ),
            
            // Curso 2
            array(
                'key' => 'field_curso_2_titulo',
                'label' => 'Curso 2 - Título',
                'name' => 'course_2_name',
                'type' => 'text',
                'placeholder' => 'Ej: Curso de Domótica',
            ),
            array(
                'key' => 'field_curso_2_fecha',
                'label' => 'Curso 2 - Fecha',
                'name' => 'course_2_date',
                'type' => 'text',
                'placeholder' => 'Ej: Febrero 2025',
            ),
            array(
                'key' => 'field_curso_2_modalidad',
                'label' => 'Curso 2 - Modalidad',
                'name' => 'course_2_modality',
                'type' => 'select',
                'choices' => array(
                    'Presencial' => 'Presencial',
                    'Online' => 'Online',
                    'Semipresencial' => 'Semipresencial',
                ),
                'default_value' => 'Presencial',
            ),
            array(
                'key' => 'field_curso_2_plazas',
                'label' => 'Curso 2 - Plazas/Duración',
                'name' => 'course_2_duration',
                'type' => 'text',
                'placeholder' => 'Ej: 12 plazas o 60 horas',
            ),
            
            // Curso 3
            array(
                'key' => 'field_curso_3_titulo',
                'label' => 'Curso 3 - Título',
                'name' => 'course_3_name',
                'type' => 'text',
                'placeholder' => 'Ej: Control de Plagas',
            ),
            array(
                'key' => 'field_curso_3_fecha',
                'label' => 'Curso 3 - Fecha',
                'name' => 'course_3_date',
                'type' => 'text',
                'placeholder' => 'Ej: Marzo 2025',
            ),
            array(
                'key' => 'field_curso_3_modalidad',
                'label' => 'Curso 3 - Modalidad',
                'name' => 'course_3_modality',
                'type' => 'select',
                'choices' => array(
                    'Presencial' => 'Presencial',
                    'Online' => 'Online',
                    'Semipresencial' => 'Semipresencial',
                ),
                'default_value' => 'Presencial',
            ),
            array(
                'key' => 'field_curso_3_plazas',
                'label' => 'Curso 3 - Plazas/Duración',
                'name' => 'course_3_duration',
                'type' => 'text',
                'placeholder' => 'Ej: 10 plazas o 30 horas',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'gestion-cursos',
                ),
            ),
        ),
    ));
    
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "✅ Campos ACF creados correctamente";
    echo "</div>";
}

// Test de los campos
echo "<h2>🧪 Test de Campos:</h2>";
for ($i = 1; $i <= 3; $i++) {
    $titulo = get_field("course_{$i}_name", 'option');
    echo "<p><strong>Curso $i:</strong> " . ($titulo ? $titulo : 'Sin configurar') . "</p>";
}

echo "<h2>🎯 ¡Listo!</h2>";
echo "<div style='background: #d1ecf1; color: #0c5460; padding: 20px; border-radius: 5px;'>";
echo "<p><strong>Ahora ve al menú lateral de WordPress y busca:</strong></p>";
echo "<p>📋 <strong>'Gestión Cursos'</strong> (debería aparecer con un icono de graduación)</p>";
echo "<p>Ahí podrás configurar los 3 próximos cursos fácilmente.</p>";
echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . admin_url('admin.php?page=gestion-cursos') . "' style='background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-size: 16px;'>📝 Ir a Gestión de Cursos</a>";
echo "</div>";

echo "<div style='text-align: center; margin: 20px 0;'>";
echo "<a href='" . home_url('/anuncios') . "' style='background: #0066cc; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>👀 Ver Página de Cursos</a>";
echo "<a href='configurar-proximos-cursos.php' style='background: #ffc107; color: #333; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 5px;'>⚙️ Configurar Automático</a>";
echo "</div>";
?>
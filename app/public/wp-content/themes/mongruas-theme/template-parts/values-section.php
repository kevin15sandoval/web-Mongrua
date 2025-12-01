<?php
/**
 * Template part for displaying the values section
 *
 * @package Mongruas
 * @since 1.0.0
 */

$values_heading = get_field('values_section_heading') ?: '¿Por Qué Elegir Mogruas?';
$values = get_field('values');

// Default values if not set
$default_values = array(
    array('name' => 'Excelencia Educativa', 'description' => 'Compromiso con la calidad en todos nuestros programas de formación'),
    array('name' => 'Innovación', 'description' => 'Contamos con 3 impresoras 3D para fomentar la creatividad y nuevas tecnologías'),
    array('name' => 'Integridad', 'description' => 'Actuamos con honestidad, transparencia y ética en todas nuestras interacciones'),
    array('name' => 'Orientación al Estudiante', 'description' => 'Las necesidades y el éxito de nuestros alumnos están en el centro de nuestras decisiones'),
    array('name' => 'Colaboración', 'description' => 'Promovemos el trabajo en equipo con instituciones educativas, empresas y comunidades'),
    array('name' => 'Desarrollo Continuo', 'description' => 'Fomentamos una cultura de aprendizaje continuo para estudiantes y personal'),
    array('name' => 'Inclusión y Diversidad', 'description' => 'Valoramos un entorno de aprendizaje inclusivo donde se respeta la diversidad')
);

$values_to_display = $values ?: $default_values;
?>

<section id="values" class="values-section section">
    <div class="container">
        <div class="section-heading">
            <h2><?php echo esc_html($values_heading); ?></h2>
        </div>

        <div class="values-grid">
            <?php foreach ($values_to_display as $value) : ?>
                <div class="value-card">
                    <?php if (!empty($value['value_icon'])) : ?>
                        <div class="value-icon">
                            <img src="<?php echo esc_url($value['value_icon']['url']); ?>" 
                                 alt="<?php echo esc_attr($value['value_name'] ?: $value['name']); ?>">
                        </div>
                    <?php endif; ?>
                    <h3 class="value-name"><?php echo esc_html($value['value_name'] ?: $value['name']); ?></h3>
                    <p class="value-description"><?php echo esc_html($value['value_description'] ?: $value['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

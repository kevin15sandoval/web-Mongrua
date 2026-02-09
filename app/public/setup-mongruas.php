<?php
/**
 * Script de Configuración Automática - Mogruas Landing Page
 * 
 * Este script automatiza la configuración completa del tema:
 * - Activa el tema Mongruas
 * - Configura los campos ACF
 * - Crea la página de inicio
 * - La configura como homepage
 * 
 * INSTRUCCIONES:
 * 1. Sube este archivo a la raíz de tu WordPress (donde está wp-config.php)
 * 2. Accede a: http://mongruasformacion.local/setup-mongruas.php
 * 3. El script hará todo automáticamente
 * 4. ELIMINA este archivo después de usarlo por seguridad
 */

// Cargar WordPress
require_once('wp-load.php');

// Verificar que el usuario esté logueado como admin
if (!current_user_can('administrator')) {
    die('❌ Debes estar logueado como administrador para ejecutar este script.');
}

echo '<html><head><meta charset="UTF-8"><title>Setup Mongruas</title>';
echo '<style>
    body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
    .success { color: #28a745; padding: 10px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 4px; margin: 10px 0; }
    .error { color: #dc3545; padding: 10px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px; margin: 10px 0; }
    .info { color: #0c5460; padding: 10px; background: #d1ecf1; border: 1px solid #bee5eb; border-radius: 4px; margin: 10px 0; }
    h1 { color: #0066cc; }
    .step { margin: 20px 0; padding: 15px; background: white; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
</style></head><body>';

echo '<h1>🚀 Configuración Automática - Mogruas Landing Page</h1>';

// PASO 1: Activar el tema
echo '<div class="step">';
echo '<h2>Paso 1: Activando el tema Mongruas...</h2>';
$theme = wp_get_theme('mongruas-theme');
if ($theme->exists()) {
    switch_theme('mongruas-theme');
    echo '<div class="success">✅ Tema "Formación y Enseñanza Mogruas" activado correctamente</div>';
} else {
    echo '<div class="error">❌ Error: El tema mongruas-theme no existe en wp-content/themes/</div>';
}
echo '</div>';

// PASO 2: Verificar ACF
echo '<div class="step">';
echo '<h2>Paso 2: Verificando Advanced Custom Fields...</h2>';
if (function_exists('acf_add_local_field_group')) {
    echo '<div class="success">✅ ACF está instalado y activo</div>';
} else {
    echo '<div class="error">❌ ACF no está instalado. Por favor instala "Advanced Custom Fields" desde Plugins → Añadir nuevo</div>';
}
echo '</div>';

// PASO 3: Crear páginas
echo '<div class="step">';
echo '<h2>Paso 3: Creando páginas...</h2>';

// Array de páginas a crear
$pages_to_create = array(
    array(
        'title' => 'Inicio',
        'template' => 'page-templates/landing-page-compact.php',
        'is_home' => true
    ),
    array(
        'title' => 'Servicios',
        'template' => 'page-templates/page-servicios.php',
        'is_home' => false
    ),
    array(
        'title' => 'Cursos',
        'template' => 'page-templates/page-cursos.php',
        'is_home' => false
    ),
    array(
        'title' => 'Nosotros',
        'template' => 'page-templates/page-nosotros.php',
        'is_home' => false
    ),
    array(
        'title' => 'Contacto',
        'template' => 'page-templates/page-contacto.php',
        'is_home' => false
    )
);

$home_page_id = null;

foreach ($pages_to_create as $page_data) {
    $existing_page = get_page_by_title($page_data['title'], OBJECT, 'page');
    
    if ($existing_page) {
        $page_id = $existing_page->ID;
        echo '<div class="info">ℹ️ La página "' . $page_data['title'] . '" ya existe (ID: ' . $page_id . ')</div>';
    } else {
        $page_id = wp_insert_post(array(
            'post_title'    => $page_data['title'],
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_author'   => 1,
            'page_template' => $page_data['template']
        ));
        
        if ($page_id) {
            echo '<div class="success">✅ Página "' . $page_data['title'] . '" creada correctamente</div>';
        } else {
            echo '<div class="error">❌ Error al crear la página "' . $page_data['title'] . '"</div>';
        }
    }
    
    // Asignar plantilla
    if ($page_id && !empty($page_data['template'])) {
        update_post_meta($page_id, '_wp_page_template', $page_data['template']);
    }
    
    // Guardar ID de la página de inicio
    if ($page_data['is_home']) {
        $home_page_id = $page_id;
    }
}

echo '</div>';

// PASO 4: Configurar como homepage
echo '<div class="step">';
echo '<h2>Paso 4: Configurando como página de inicio...</h2>';
if ($home_page_id) {
    update_option('show_on_front', 'page');
    update_option('page_on_front', $home_page_id);
    echo '<div class="success">✅ Página "Inicio" configurada como homepage</div>';
}
echo '</div>';

// PASO 5: Añadir contenido de ejemplo al Hero
echo '<div class="step">';
echo '<h2>Paso 5: Añadiendo contenido de ejemplo...</h2>';
if ($home_page_id && function_exists('update_field')) {
    // Hero Section
    update_field('hero_headline', 'LA FORMACIÓN AL ALCANCE DE TODOS', $home_page_id);
    update_field('hero_subheadline', 'Centro Profesional para el Empleo desde 2005 en Talavera de la Reina', $home_page_id);
    update_field('hero_primary_cta_text', 'Solicita Información', $home_page_id);
    update_field('hero_primary_cta_link', '#contact', $home_page_id);
    update_field('hero_secondary_cta_text', 'Acceder al Campus Virtual', $home_page_id);
    update_field('hero_secondary_cta_link', 'https://www.plataformateleformacion.com', $home_page_id);
    
    echo '<div class="success">✅ Contenido de ejemplo añadido al Hero Section</div>';
    echo '<div class="info">ℹ️ Nota: Necesitarás configurar los campos ACF manualmente o importar la configuración</div>';
} else {
    echo '<div class="info">ℹ️ ACF no está disponible. Configura los campos manualmente desde ACF → Grupos de campos</div>';
}
echo '</div>';

// PASO 6: Crear menú de navegación
echo '<div class="step">';
echo '<h2>Paso 6: Creando menú de navegación...</h2>';

$menu_name = 'Menú Principal';
$menu_exists = wp_get_nav_menu_object($menu_name);

// Eliminar menú existente si tiene problemas
if ($menu_exists) {
    wp_delete_nav_menu($menu_exists->term_id);
    echo '<div class="info">ℹ️ Menú anterior eliminado para recrearlo correctamente</div>';
}

$menu_id = wp_create_nav_menu($menu_name);

// Obtener IDs de las páginas creadas
$page_inicio = get_page_by_title('Inicio');
$page_servicios = get_page_by_title('Servicios');
$page_cursos = get_page_by_title('Cursos');
$page_nosotros = get_page_by_title('Nosotros');
$page_contacto = get_page_by_title('Contacto');

// Añadir items al menú usando IDs de páginas
$menu_items = array();

if ($page_inicio) {
    $menu_items[] = array(
        'menu-item-title' => 'Inicio',
        'menu-item-object-id' => $page_inicio->ID,
        'menu-item-object' => 'page',
        'menu-item-type' => 'post_type',
        'menu-item-status' => 'publish'
    );
}

if ($page_servicios) {
    $menu_items[] = array(
        'menu-item-title' => 'Servicios',
        'menu-item-object-id' => $page_servicios->ID,
        'menu-item-object' => 'page',
        'menu-item-type' => 'post_type',
        'menu-item-status' => 'publish'
    );
}

if ($page_cursos) {
    $menu_items[] = array(
        'menu-item-title' => 'Cursos',
        'menu-item-object-id' => $page_cursos->ID,
        'menu-item-object' => 'page',
        'menu-item-type' => 'post_type',
        'menu-item-status' => 'publish'
    );
}

if ($page_nosotros) {
    $menu_items[] = array(
        'menu-item-title' => 'Nosotros',
        'menu-item-object-id' => $page_nosotros->ID,
        'menu-item-object' => 'page',
        'menu-item-type' => 'post_type',
        'menu-item-status' => 'publish'
    );
}

if ($page_contacto) {
    $menu_items[] = array(
        'menu-item-title' => 'Contacto',
        'menu-item-object-id' => $page_contacto->ID,
        'menu-item-object' => 'page',
        'menu-item-type' => 'post_type',
        'menu-item-status' => 'publish'
    );
}

// Añadir cada item al menú
foreach ($menu_items as $item) {
    wp_update_nav_menu_item($menu_id, 0, $item);
}

// Asignar el menú a la ubicación primary
$locations = get_theme_mod('nav_menu_locations');
$locations['primary'] = $menu_id;
set_theme_mod('nav_menu_locations', $locations);

echo '<div class="success">✅ Menú de navegación creado con ' . count($menu_items) . ' items y asignado a la ubicación "primary"</div>';
echo '</div>';

// RESUMEN FINAL
echo '<div class="step" style="background: #d4edda; border: 2px solid #28a745;">';
echo '<h2>🎉 ¡Configuración Completada!</h2>';
echo '<p><strong>Próximos pasos:</strong></p>';
echo '<ol>';
echo '<li>Ve a <strong>ACF → Grupos de campos</strong> y crea los grupos de campos necesarios (ver SETUP-GUIDE.md)</li>';
echo '<li>Edita la página "Inicio" y rellena los campos ACF con tu contenido</li>';
echo '<li>Sube tu logo en <strong>Apariencia → Personalizar → Identidad del sitio</strong></li>';
echo '<li>Crea testimonios en <strong>Testimonios → Añadir nuevo</strong></li>';
echo '<li>Configura los ajustes del tema en <strong>Theme Settings</strong></li>';
echo '<li><strong>¡IMPORTANTE!</strong> Elimina este archivo (setup-mongruas.php) por seguridad</li>';
echo '</ol>';
echo '<p><a href="' . home_url() . '" style="display: inline-block; padding: 10px 20px; background: #0066cc; color: white; text-decoration: none; border-radius: 4px; margin-top: 10px;">Ver el sitio →</a></p>';
echo '<p><a href="' . admin_url() . '" style="display: inline-block; padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; margin-top: 10px;">Ir al Admin →</a></p>';
echo '</div>';

echo '</body></html>';

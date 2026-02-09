<?php
/**
 * Script de Diagnóstico ACF
 * Verifica que ACF esté funcionando y muestra los grupos de campos
 */

require_once('wp-load.php');

if (!current_user_can('administrator')) {
    die('❌ Debes estar logueado como administrador.');
}

echo '<html><head><meta charset="UTF-8"><title>Diagnóstico ACF</title>';
echo '<style>
    body { font-family: Arial, sans-serif; max-width: 900px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
    .success { color: #28a745; padding: 10px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 4px; margin: 10px 0; }
    .error { color: #dc3545; padding: 10px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px; margin: 10px 0; }
    .info { color: #0c5460; padding: 10px; background: #d1ecf1; border: 1px solid #bee5eb; border-radius: 4px; margin: 10px 0; }
    h1 { color: #0066cc; }
    .box { margin: 20px 0; padding: 15px; background: white; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    pre { background: #f8f9fa; padding: 10px; border-radius: 4px; overflow-x: auto; }
</style></head><body>';

echo '<h1>🔍 Diagnóstico ACF - Próximos Cursos</h1>';

// Test 1: ACF está instalado?
echo '<div class="box">';
echo '<h2>Test 1: ¿ACF está instalado y activo?</h2>';
if (function_exists('acf_add_local_field_group')) {
    echo '<div class="success">✅ ACF está instalado y activo</div>';
} else {
    echo '<div class="error">❌ ACF NO está instalado o no está activo</div>';
    echo '<p>Solución: Ve a Plugins → Añadir nuevo → Busca "Advanced Custom Fields" → Instalar y Activar</p>';
}
echo '</div>';

// Test 2: Verificar grupos de campos
echo '<div class="box">';
echo '<h2>Test 2: Grupos de campos registrados</h2>';
if (function_exists('acf_get_field_groups')) {
    $field_groups = acf_get_field_groups();
    if (!empty($field_groups)) {
        echo '<div class="success">✅ Se encontraron ' . count($field_groups) . ' grupos de campos</div>';
        echo '<h3>Grupos encontrados:</h3>';
        echo '<ul>';
        foreach ($field_groups as $group) {
            echo '<li><strong>' . $group['title'] . '</strong> (key: ' . $group['key'] . ')';
            if ($group['key'] === 'group_upcoming_courses') {
                echo ' <span style="color: green;">← Este es el grupo de Próximos Cursos</span>';
            }
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo '<div class="error">❌ No se encontraron grupos de campos</div>';
    }
} else {
    echo '<div class="error">❌ La función acf_get_field_groups() no existe</div>';
}
echo '</div>';

// Test 3: Verificar el grupo específico
echo '<div class="box">';
echo '<h2>Test 3: Grupo "Próximos Cursos"</h2>';
if (function_exists('acf_get_field_group')) {
    $upcoming_group = acf_get_field_group('group_upcoming_courses');
    if ($upcoming_group) {
        echo '<div class="success">✅ El grupo "Próximos Cursos" existe</div>';
        echo '<h3>Detalles del grupo:</h3>';
        echo '<pre>' . print_r($upcoming_group, true) . '</pre>';
        
        // Verificar campos
        if (function_exists('acf_get_fields')) {
            $fields = acf_get_fields('group_upcoming_courses');
            if ($fields) {
                echo '<h3>Campos en el grupo:</h3>';
                echo '<ul>';
                foreach ($fields as $field) {
                    echo '<li>' . $field['label'] . ' (type: ' . $field['type'] . ')</li>';
                }
                echo '</ul>';
            }
        }
    } else {
        echo '<div class="error">❌ El grupo "Próximos Cursos" NO existe</div>';
        echo '<p>Esto significa que el código en acf-fields.php no se está cargando correctamente.</p>';
    }
} else {
    echo '<div class="error">❌ La función acf_get_field_group() no existe</div>';
}
echo '</div>';

// Test 4: Verificar página de Cursos
echo '<div class="box">';
echo '<h2>Test 4: Página de Cursos</h2>';
$cursos_page = get_page_by_title('Cursos');
if ($cursos_page) {
    echo '<div class="success">✅ La página "Cursos" existe (ID: ' . $cursos_page->ID . ')</div>';
    $template = get_page_template_slug($cursos_page->ID);
    echo '<p>Plantilla actual: <strong>' . ($template ? $template : 'default') . '</strong></p>';
    if ($template === 'page-templates/page-cursos.php') {
        echo '<div class="success">✅ Está usando la plantilla correcta</div>';
    } else {
        echo '<div class="error">❌ NO está usando la plantilla page-templates/page-cursos.php</div>';
    }
} else {
    echo '<div class="error">❌ La página "Cursos" no existe</div>';
}
echo '</div>';

// Test 5: Verificar archivo acf-fields.php
echo '<div class="box">';
echo '<h2>Test 5: Archivo acf-fields.php</h2>';
$acf_file = get_template_directory() . '/inc/acf-fields.php';
if (file_exists($acf_file)) {
    echo '<div class="success">✅ El archivo acf-fields.php existe</div>';
    $content = file_get_contents($acf_file);
    if (strpos($content, 'group_upcoming_courses') !== false) {
        echo '<div class="success">✅ El código de "Próximos Cursos" está en el archivo</div>';
    } else {
        echo '<div class="error">❌ El código de "Próximos Cursos" NO está en el archivo</div>';
    }
} else {
    echo '<div class="error">❌ El archivo acf-fields.php NO existe</div>';
}
echo '</div>';

// Soluciones
echo '<div class="box" style="background: #fff3cd; border: 2px solid #ffc107;">';
echo '<h2>💡 Soluciones Recomendadas</h2>';
echo '<ol>';
echo '<li><strong>Si ACF no está activo:</strong> Ve a Plugins y activa "Advanced Custom Fields"</li>';
echo '<li><strong>Si el grupo no aparece:</strong> Intenta refrescar la página de edición (Ctrl+F5)</li>';
echo '<li><strong>Si sigue sin funcionar:</strong> Ve a ACF → Tools → Import Field Groups y sube un archivo JSON</li>';
echo '<li><strong>Alternativa:</strong> Crea el grupo manualmente desde ACF → Field Groups → Add New</li>';
echo '</ol>';
echo '</div>';

echo '<div style="text-align: center; margin-top: 30px;">';
echo '<a href="' . admin_url() . '" style="display: inline-block; padding: 12px 24px; background: #0066cc; color: white; text-decoration: none; border-radius: 4px;">Ir al Admin</a>';
echo ' ';
echo '<a href="' . admin_url('edit.php?post_type=acf-field-group') . '" style="display: inline-block; padding: 12px 24px; background: #28a745; color: white; text-decoration: none; border-radius: 4px;">Ver Grupos ACF</a>';
echo '</div>';

echo '</body></html>';

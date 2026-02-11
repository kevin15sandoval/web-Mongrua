<?php
/**
 * Test de páginas individuales de cursos
 * 
 */

// Cargar WordPress
require_once('wp-config.php';


h1>";


echo "<h2>📋 Verificando Sistema de Cursos Individuales</h2>";

// Test 1: Verificar que losisten
echo "<h3>1️⃣ Datos de Cursos</h3>";
for ($i = 1; $i <= 3; $i++) {
    $nombre = get_option("course_{$i}_name");
    $fecha = get_option("course_{$i}_date");
    $modalidad = get_option("course_{$i}_modality");
    ion");
    $imagen = get_option("course_{$i}_
    
    echo "<div style=
    echo "<strong>Curso $i:</strong><br>";
    echo "📚 Nombre: " . ($nombre ? $nombre : "❌ N";
    echo "📅 Fecha: " . ($fecha ? $f;
    echo "";
    echo "📝 Descripción: " . ($descr>";
    echo "🖼️ Imagen: " . ($imagen ? "✅ Definida" : "❌ No definida") . "<br>";
    e
}

// Test 2: Verificar URLs de cursos individuales
echo "<h3>2️⃣ URLs de Cursos Individuales:</h3>";
for  {
    $url = home_url("/curso/?crso=$i");
    echo "<div style='background: white; padding: 10px; margin: 5px 0; border-radius: 5px;'>";
    e";
    
    echo "</div>";
}

// Test 3: Verificar template de curso individual
echo ;
$temse.php';
if (file_exists($template_path)) {
    echo "✅ Template existe: $template_path
    $template_size = filesize($template_path);
    echo "📏 Tamaño: " . number_format($template_size) . " bytes<br>";
} else {
    echo "❌ Templa;
}

// Test 4: Veruting
/h3>";
$routing_path = 'curso.php';

    echo "✅ R
    echo "📄 Contenido:<br>";
    echo "<pre style='background: #f8f9fa; padding: 10px; border-radius: 5";
    echo htmlspecialchars(file_get_conte;
    echo "</pre>";
} else {
    echo "❌ Routing no encontrad>";
}

// Test 5: Verificar botones en template de cursos
echo "<h3>5️⃣ Botones en Template de Cursos3>";
$c
)) {
    $content = file_get_contents($courses_template);
    
    // Buscar botones "Ver Más Info"
    $ver_mas_count = substr_count($content, 'btn-ver-mas');
 
    
    // Buscar "
);
    echo "📝 Botones 'Reservar Pl
    
    // Buscar enlaces a páginas individuales
    $curso_l=');
    echo "🔗 Enlaces a páginas individuales: $curso_links<br>";
    
    if ($ver_mas_count > 0 && $reservar_count > 0 && $curso_links > 0) {
        echo "✅ <strong>Sistema de botones funcionando correctamente</strong><br>";
    } else {
        echo "⚠️ <strong>Posible problema con los botones</strong><br>";
    }
} else {
    echo "❌ Template de cursos no encont
}

echo "</div>";

// Test 6: Si
echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px";
echo "<h2>🎯 

curso 1
$course_id = 1;
$course_name = get_option("course_{$course_id}_name");
$course_date = get_option("course_{$course_id}_date");
$course_descri

if ($course_name) {
    echo "<div style='background: white; padding: ";
    echo "<h3>✅ Simulación E";
    echo "<s;
    echo "<strong>Fecha:</strong> $course_date<br>";
    echo "<strong>Descripción:</strong> " . substr($course_description, 0, 100)
    echo "<br><strong>URL de prueba:</strong> <a href='" . home_url("/curso/?curso=$course_id";
    echo "</div>";
} else {
    echo "<div'>";
  3>";
;
    echiv>";
}

echo "</div>";

// Botones de acción
echo "<div style='text-a;
e
;
echo "<a hre/a>";
echo "</div>";

?>

<script>
f) {
entana
    lank');
    
 mensaje

    me= `
        position: fixed;
 px;
        
</style>}
ight: 200px;   max-hex: auto;
   overflow-
pre {
  line;
}
underdecoration: ext-ver {
    tho
}

a:none;: -decoration   text66cc;
 : #00
    color
a {}
op: 25px;
    margin-t: #495057;
olor  c3 {
  }

h10px;
bottom: g-
    paddin#0066cc;2px solid ttom: rder-bo
    bocc;r: #0066{
    colo}

h2 ;
ottom: 30pxn-b  margi center;
  align:ext-;
    ta1a1a color: #1   {

h1 f9fa;
}
und: #f8 backgro
   px;ng: 20
    paddi auto;n: 0;
    margi 1000pxx-width:
    maserif;sans-oto, UI', Robe egot, 'SonmFnkMacSystem, Blisystey: -apple-t-famil
    fon>
body {<style>

/script30000);
<
}, ();ation.reload
    locut(() => {etTimeor cambios
sa vears p segundosh cada 30efre-r// Auto

 3000);
}  },);
  e.remove( messag       () => {
ut(tTimeo    se
);
    messagendChild(dy.appeument.bodoc    .`;
d}..eIrs ${cousoobando CurPr🧪  `tent =xtConsage.te   mes;
 d;
    `weight: bol   font-    
 0; 1000dex:   z-in    
 : 8px;-radius  border
      px 20px; 15ng:di   pad   hite;
  color: w
        745;round: #28a     backg  ;
 right: 20px
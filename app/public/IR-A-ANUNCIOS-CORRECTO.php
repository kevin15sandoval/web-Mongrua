<?php
/**
 * Redirigir a la página correcta de /anuncios/
 */

require_once('wp-load.php');

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'>";
echo "<style>
body { 
    font-family: Arial, sans-serif; 
    padding: 40px; 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
.container {
    background: white;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    max-width: 600px;
    text-align: center;
}
h1 { color: #dc3545; margin-bottom: 20px; }
.success { background: #d4edda; border: 2px solid #28a745; padding: 20px; margin: 20px 0; border-radius: 10px; color: #155724; }
.error { background: #f8d7da; border: 2px solid #dc3545; padding: 20px; margin: 20px 0; border-radius: 10px; color: #721c24; }
.info { background: #d1ecf1; border: 2px solid #17a2b8; padding: 20px; margin: 20px 0; border-radius: 10px; color: #0c5460; }
.btn { 
    display: inline-block;
    background: linear-gradient(135deg, #28a745, #20c997); 
    color: white; 
    padding: 15px 40px; 
    border-radius: 30px; 
    text-decoration: none; 
    font-weight: 700;
    font-size: 18px;
    margin: 10px;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
    transition: all 0.3s ease;
}
.btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.6);
}
.btn-secondary {
    background: linear-gradient(135deg, #6c757d, #5a6268);
}
.url-box {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    font-family: monospace;
    font-size: 16px;
    margin: 15px 0;
    border: 2px solid #dee2e6;
}
.wrong { color: #dc3545; text-decoration: line-through; }
.correct { color: #28a745; font-weight: bold; }
</style></head><body>";

echo "<div class='container'>";
echo "<h1>🎯 URL Correcta para /anuncios/</h1>";

// Verificar cursos
$cursos = get_option('mongruas_courses', []);
$tiene_cursos = !empty($cursos);

echo "<div class='error'>";
echo "<h2>❌ URL INCORRECTA</h2>";
echo "<div class='url-box wrong'>http://mongruasformacion.local/anuncios/NOSOTROS</div>";
echo "<p>Esta URL te lleva a la página de NOSOTROS, no a ANUNCIOS</p>";
echo "</div>";

echo "<div class='success'>";
echo "<h2>✅ URL CORRECTA</h2>";
echo "<div class='url-box correct'>http://mongruasformacion.local/anuncios/</div>";
echo "<p>Esta es la URL correcta para ver el carrusel de cursos</p>";
echo "</div>";

if ($tiene_cursos) {
    echo "<div class='success'>";
    echo "<h3>✅ Hay " . count($cursos) . " curso(s) guardado(s)</h3>";
    echo "<p>Los cursos están listos para mostrarse en /anuncios/</p>";
    echo "</div>";
} else {
    echo "<div class='error'>";
    echo "<h3>⚠️ No hay cursos guardados</h3>";
    echo "<p>Primero agrega cursos en el panel de gestión</p>";
    echo "</div>";
}

echo "<div class='info'>";
echo "<h3>📋 Instrucciones:</h3>";
echo "<ol style='text-align: left; margin: 15px 0;'>";
echo "<li>Haz clic en el botón verde de abajo</li>";
echo "<li>Te llevará a la página correcta: <strong>/anuncios/</strong></li>";
echo "<li>Presiona <strong>Ctrl + F5</strong> para forzar recarga</li>";
echo "<li>Deberías ver el carrusel morado con los cursos</li>";
echo "</ol>";
echo "</div>";

$anuncios_url = home_url('/anuncios/');
$panel_url = home_url('/gestionar-cursos-dinamico.php');

echo "<div style='margin-top: 30px;'>";
echo "<a href='$anuncios_url' class='btn'>🎯 IR A /ANUNCIOS/ CORRECTO</a><br>";
if (!$tiene_cursos) {
    echo "<a href='$panel_url' class='btn btn-secondary'>➕ Agregar Cursos Primero</a>";
}
echo "</div>";

echo "<div class='info' style='margin-top: 30px; font-size: 14px;'>";
echo "<strong>💡 Tip:</strong> Guarda este enlace en favoritos:<br>";
echo "<a href='$anuncios_url' style='color: #0066cc;'>$anuncios_url</a>";
echo "</div>";

echo "</div>";
echo "</body></html>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔧 Abrir Editor de Campaña - Directo</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            color: #2d3748;
            text-align: center;
            margin-bottom: 30px;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 20px;
            background: linear-gradient(135deg, #0066cc, #0052a3);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            text-align: center;
            font-size: 18px;
            font-weight: 600;
            margin: 15px 0;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 102, 204, 0.3);
        }
        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
        }
        .btn-warning {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
        }
        .info {
            background: #e7f3ff;
            padding: 20px;
            border-radius: 12px;
            margin: 20px 0;
            border-left: 5px solid #0066cc;
        }
        .code {
            background: #2d3748;
            color: #e2e8f0;
            padding: 15px;
            border-radius: 8px;
            font-family: monospace;
            font-size: 14px;
            overflow-x: auto;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Abrir Editor de Campaña - Modo Directo</h1>
        
        <div class="info">
            <strong>📝 Instrucciones:</strong><br><br>
            Este archivo te llevará directamente a la sección de campañas con debugging activado.
            Podrás ver exactamente qué está pasando cuando intentas abrir el editor.
        </div>

        <a href="crm-mailing-completo.php#campanas" class="btn btn-success">
            📧 Ir a Campañas (Normal)
        </a>

        <a href="DIAGNOSTICO-CAMPANAS-URGENTE.php" class="btn btn-warning">
            🔍 Diagnóstico Completo
        </a>

        <button onclick="abrirConDebug()" class="btn">
            🐛 Abrir con Debugging Activado
        </button>

        <div class="info" style="margin-top: 30px;">
            <strong>🔍 Qué verificar en la página:</strong><br><br>
            1. Abre la consola del navegador (F12)<br>
            2. Ve a la pestaña "Campañas de Email"<br>
            3. Busca campañas en estado "borrador"<br>
            4. Haz clic en el botón "📝 Editar y Enviar"<br>
            5. Observa si hay errores en la consola<br>
            6. Verifica si el modal aparece
        </div>

        <div class="info" style="background: #fff3cd; border-color: #ffc107;">
            <strong>⚠️ Si el botón no aparece:</strong><br><br>
            • Asegúrate de tener al menos una campaña en estado "borrador"<br>
            • Si no tienes campañas, créalas desde la pestaña "Campañas de Email"<br>
            • El botón solo aparece para campañas NO enviadas
        </div>

        <h3 style="margin-top: 40px; color: #2d3748;">📋 Código JavaScript para Debugging</h3>
        <p>Copia y pega esto en la consola cuando estés en la página de campañas:</p>
        
        <div class="code">// Verificar que todo existe
console.log('=== DEBUGGING CAMPAÑAS ===');
console.log('1. Función abrirEditorCampana existe:', typeof abrirEditorCampana === 'function');
console.log('2. Modal existe:', !!document.getElementById('modalEditorCampana'));

// Buscar todos los botones de editar
const botones = document.querySelectorAll('button[onclick*="abrirEditorCampana"]');
console.log('3. Botones encontrados:', botones.length);

if (botones.length > 0) {
    console.log('4. Primer botón:', botones[0]);
    console.log('   - ID Campaña:', botones[0].dataset.campanaId);
    console.log('   - Nombre:', botones[0].dataset.campanaNombre);
    console.log('   - Asunto:', botones[0].dataset.campanaAsunto);
}

// Verificar campos del modal
const campos = ['edit_campana_id', 'edit_campana_nombre', 'edit_campana_asunto', 'edit_campana_contenido', 'edit_campana_segmento'];
console.log('5. Campos del modal:');
campos.forEach(campo => {
    const existe = !!document.getElementById(campo);
    console.log('   -', campo, ':', existe ? '✅' : '❌');
});

// Intentar abrir el modal manualmente
console.log('6. Intentando abrir modal manualmente...');
const modal = document.getElementById('modalEditorCampana');
if (modal) {
    modal.style.display = 'flex';
    console.log('   ✅ Modal abierto!');
} else {
    console.log('   ❌ Modal no encontrado');
}</div>

        <button onclick="copiarCodigo()" class="btn" style="background: #6c757d;">
            📋 Copiar Código al Portapapeles
        </button>

        <div id="mensaje-copiado" style="display: none; background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-top: 15px; text-align: center; font-weight: bold;">
            ✅ Código copiado al portapapeles!
        </div>
    </div>

    <script>
        function abrirConDebug() {
            // Guardar en localStorage que queremos debugging
            localStorage.setItem('debug_campanas', 'true');
            window.location.href = 'crm-mailing-completo.php#campanas';
        }

        function copiarCodigo() {
            const codigo = `// Verificar que todo existe
console.log('=== DEBUGGING CAMPAÑAS ===');
console.log('1. Función abrirEditorCampana existe:', typeof abrirEditorCampana === 'function');
console.log('2. Modal existe:', !!document.getElementById('modalEditorCampana'));

// Buscar todos los botones de editar
const botones = document.querySelectorAll('button[onclick*="abrirEditorCampana"]');
console.log('3. Botones encontrados:', botones.length);

if (botones.length > 0) {
    console.log('4. Primer botón:', botones[0]);
    console.log('   - ID Campaña:', botones[0].dataset.campanaId);
    console.log('   - Nombre:', botones[0].dataset.campanaNombre);
    console.log('   - Asunto:', botones[0].dataset.campanaAsunto);
}

// Verificar campos del modal
const campos = ['edit_campana_id', 'edit_campana_nombre', 'edit_campana_asunto', 'edit_campana_contenido', 'edit_campana_segmento'];
console.log('5. Campos del modal:');
campos.forEach(campo => {
    const existe = !!document.getElementById(campo);
    console.log('   -', campo, ':', existe ? '✅' : '❌');
});

// Intentar abrir el modal manualmente
console.log('6. Intentando abrir modal manualmente...');
const modal = document.getElementById('modalEditorCampana');
if (modal) {
    modal.style.display = 'flex';
    console.log('   ✅ Modal abierto!');
} else {
    console.log('   ❌ Modal no encontrado');
}`;

            // Copiar al portapapeles
            navigator.clipboard.writeText(codigo).then(() => {
                const mensaje = document.getElementById('mensaje-copiado');
                mensaje.style.display = 'block';
                setTimeout(() => {
                    mensaje.style.display = 'none';
                }, 3000);
            });
        }
    </script>
</body>
</html>

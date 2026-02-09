<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📊 Plantilla Excel Unificada - CRM</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }

        h1 {
            font-size: 36px;
            color: #2d3748;
            margin-bottom: 10px;
            text-align: center;
        }

        .subtitle {
            text-align: center;
            color: #718096;
            margin-bottom: 40px;
            font-size: 18px;
        }

        .download-section {
            background: linear-gradient(135deg, #28a745, #20c997);
            padding: 40px;
            border-radius: 16px;
            text-align: center;
            margin-bottom: 40px;
            color: white;
        }

        .download-section h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        .btn-download {
            display: inline-block;
            background: white;
            color: #28a745;
            padding: 20px 50px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .btn-download:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.3);
        }

        .table-structure {
            overflow-x: auto;
            margin: 30px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
        }

        th {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 700;
            font-size: 14px;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
        }

        tr:hover {
            background: #f7fafc;
        }

        .column-header {
            background: #f8f9fa;
            font-weight: 700;
            color: #667eea;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .feature {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
        }

        .feature-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .feature-title {
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 10px;
            font-size: 18px;
        }

        .feature-desc {
            font-size: 14px;
            color: #718096;
            line-height: 1.6;
        }

        .example-section {
            background: #e7f3ff;
            padding: 30px;
            border-radius: 12px;
            margin: 30px 0;
        }

        .example-section h3 {
            color: #0066cc;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .steps {
            background: white;
            padding: 30px;
            border-radius: 12px;
            margin: 30px 0;
        }

        .step {
            display: flex;
            align-items: start;
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 2px solid #f0f0f0;
        }

        .step:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .step-number {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 20px;
            margin-right: 20px;
            flex-shrink: 0;
        }

        .step-content h4 {
            color: #2d3748;
            margin-bottom: 8px;
            font-size: 18px;
        }

        .step-content p {
            color: #718096;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 15px 35px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            margin: 10px 5px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(102, 126, 234, 0.4);
        }

        .buttons {
            text-align: center;
            margin-top: 40px;
        }

        .alert {
            background: #fff3cd;
            border-left: 5px solid #ffc107;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .alert-title {
            font-weight: 700;
            color: #856404;
            margin-bottom: 10px;
            font-size: 18px;
        }

        .alert-text {
            color: #856404;
            line-height: 1.6;
        }

        code {
            background: #f8f9fa;
            padding: 2px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            color: #e83e8c;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>📊 Plantilla Excel Unificada</h1>
            <p class="subtitle">Estructura estándar para importar clientes al CRM</p>

            <div class="download-section">
                <h2>⬇️ Descargar Plantilla Excel</h2>
                <p style="margin-bottom: 20px; font-size: 16px;">Descarga la plantilla con la estructura correcta y ejemplos</p>
                <a href="DESCARGAR-PLANTILLA-EXCEL.php" class="btn-download">
                    📥 DESCARGAR PLANTILLA.xlsx
                </a>
            </div>

            <div class="alert">
                <div class="alert-title">⚠️ IMPORTANTE: NO incluir columna ID</div>
                <div class="alert-text">
                    El ID se crea automáticamente al importar. Solo incluye las 8 columnas que se muestran abajo.
                </div>
            </div>

            <h2 style="margin: 40px 0 20px 0; color: #2d3748; font-size: 28px;">📋 Estructura de Columnas</h2>
            
            <div class="table-structure">
                <table>
                    <thead>
                        <tr>
                            <th>Columna</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Ejemplo</th>
                            <th>Obligatorio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="column-header">A</td>
                            <td><strong>SECTOR</strong></td>
                            <td>Tipo de empresa o sector</td>
                            <td>Electricidad, Gestoría, Construcción</td>
                            <td>No (por defecto: Servicios)</td>
                        </tr>
                        <tr>
                            <td class="column-header">B</td>
                            <td><strong>EMPRESA</strong></td>
                            <td>Nombre de la empresa</td>
                            <td>Instalaciones García SL</td>
                            <td>✅ Sí</td>
                        </tr>
                        <tr>
                            <td class="column-header">C</td>
                            <td><strong>CONTACTO</strong></td>
                            <td>Nombre de la persona de contacto</td>
                            <td>Juan García López</td>
                            <td>No (se puede llenar después)</td>
                        </tr>
                        <tr>
                            <td class="column-header">D</td>
                            <td><strong>TELÉFONO</strong></td>
                            <td>Teléfono de contacto</td>
                            <td>925 123 456</td>
                            <td>No</td>
                        </tr>
                        <tr>
                            <td class="column-header">E</td>
                            <td><strong>CORREO</strong></td>
                            <td>Email de contacto</td>
                            <td>info@garcia.com</td>
                            <td>No (se genera temporal si falta)</td>
                        </tr>
                        <tr>
                            <td class="column-header">F</td>
                            <td><strong>POBLACIÓN</strong></td>
                            <td>Ciudad o población</td>
                            <td>Talavera de la Reina</td>
                            <td>No</td>
                        </tr>
                        <tr>
                            <td class="column-header">G</td>
                            <td><strong>PROVINCIA</strong></td>
                            <td>Provincia</td>
                            <td>Toledo</td>
                            <td>No</td>
                        </tr>
                        <tr>
                            <td class="column-header">H</td>
                            <td><strong>OBSERVACIONES</strong></td>
                            <td>Notas adicionales</td>
                            <td>Cliente potencial, llamar en enero</td>
                            <td>No</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="features">
                <div class="feature">
                    <div class="feature-icon">🔢</div>
                    <div class="feature-title">ID Automático</div>
                    <div class="feature-desc">El sistema crea el ID único automáticamente al importar</div>
                </div>
                <div class="feature">
                    <div class="feature-icon">✅</div>
                    <div class="feature-title">Validación</div>
                    <div class="feature-desc">Valida emails, limpia teléfonos y detecta duplicados</div>
                </div>
                <div class="feature">
                    <div class="feature-icon">📋</div>
                    <div class="feature-title">Listas Automáticas</div>
                    <div class="feature-desc">Asigna la lista según el nombre del archivo Excel</div>
                </div>
                <div class="feature">
                    <div class="feature-icon">🎯</div>
                    <div class="feature-title">Estructura Unificada</div>
                    <div class="feature-desc">Todos los archivos usan la misma estructura</div>
                </div>
            </div>

            <div class="example-section">
                <h3>📝 Ejemplo de Datos</h3>
                <div class="table-structure">
                    <table>
                        <thead>
                            <tr>
                                <th>SECTOR</th>
                                <th>EMPRESA</th>
                                <th>CONTACTO</th>
                                <th>TELÉFONO</th>
                                <th>CORREO</th>
                                <th>POBLACIÓN</th>
                                <th>PROVINCIA</th>
                                <th>OBSERVACIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Electricidad</td>
                                <td>Instalaciones García</td>
                                <td>Juan García</td>
                                <td>925 123 456</td>
                                <td>info@garcia.com</td>
                                <td>Talavera de la Reina</td>
                                <td>Toledo</td>
                                <td>Cliente potencial</td>
                            </tr>
                            <tr>
                                <td>Gestoría</td>
                                <td>Asesoría López</td>
                                <td>María López</td>
                                <td>925 234 567</td>
                                <td>contacto@lopez.com</td>
                                <td>Talavera de la Reina</td>
                                <td>Toledo</td>
                                <td>Interesado en PRL</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="steps">
                <h2 style="margin-bottom: 30px; color: #2d3748; font-size: 28px;">🚀 Cómo Usar la Plantilla</h2>
                
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h4>Descargar la Plantilla</h4>
                        <p>Haz clic en el botón verde de arriba para descargar <code>PLANTILLA-CRM-UNIFICADA.xlsx</code></p>
                    </div>
                </div>

                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h4>Abrir en Excel</h4>
                        <p>Abre el archivo con Microsoft Excel, LibreOffice Calc o Google Sheets</p>
                    </div>
                </div>

                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h4>Rellenar los Datos</h4>
                        <p>Completa las filas con tus clientes. La primera fila (encabezados) NO se debe modificar. Puedes copiar y pegar desde tus Excel antiguos.</p>
                    </div>
                </div>

                <div class="step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h4>Guardar como .xlsx</h4>
                        <p>Guarda el archivo en formato Excel (.xlsx). Puedes usar nombres como: <code>Empresas-Electricidad.xlsx</code>, <code>Gestorias-Talavera.xlsx</code>, etc.</p>
                    </div>
                </div>

                <div class="step">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <h4>Importar al CRM</h4>
                        <p>Ve al importador y sube tu archivo. El sistema creará automáticamente los IDs y validará los datos.</p>
                    </div>
                </div>
            </div>

            <div class="buttons">
                <a href="importar-todos-excel-crm.php" class="btn">📥 Ir al Importador</a>
                <a href="crm-mailing-completo.php" class="btn">📊 Ver CRM</a>
                <a href="DESCARGAR-PLANTILLA-EXCEL.php" class="btn" style="background: linear-gradient(135deg, #28a745, #20c997);">⬇️ Descargar Plantilla</a>
            </div>
        </div>
    </div>
</body>
</html>

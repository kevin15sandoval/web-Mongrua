<?php
/**
 * Genera y descarga una plantilla Excel con la estructura unificada
 */

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="PLANTILLA-CRM-UNIFICADA.xlsx"');
header('Cache-Control: max-age=0');

// Crear el XML del Excel
$xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">
<sheetData>
<row r="1">
<c r="A1" t="s"><v>0</v></c>
<c r="B1" t="s"><v>1</v></c>
<c r="C1" t="s"><v>2</v></c>
<c r="D1" t="s"><v>3</v></c>
<c r="E1" t="s"><v>4</v></c>
<c r="F1" t="s"><v>5</v></c>
<c r="G1" t="s"><v>6</v></c>
<c r="H1" t="s"><v>7</v></c>
</row>
<row r="2">
<c r="A2" t="s"><v>8</v></c>
<c r="B2" t="s"><v>9</v></c>
<c r="C2" t="s"><v>10</v></c>
<c r="D2" t="s"><v>11</v></c>
<c r="E2" t="s"><v>12</v></c>
<c r="F2" t="s"><v>13</v></c>
<c r="G2" t="s"><v>14</v></c>
<c r="H2" t="s"><v>15</v></c>
</row>
<row r="3">
<c r="A3" t="s"><v>16</v></c>
<c r="B3" t="s"><v>17</v></c>
<c r="C3" t="s"><v>18</v></c>
<c r="D3" t="s"><v>19</v></c>
<c r="E3" t="s"><v>20</v></c>
<c r="F3" t="s"><v>21</v></c>
<c r="G3" t="s"><v>22</v></c>
<c r="H3" t="s"><v>23</v></c>
</row>
</sheetData>
</worksheet>';

$strings = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<sst xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" count="24" uniqueCount="24">
<si><t>SECTOR</t></si>
<si><t>EMPRESA</t></si>
<si><t>CONTACTO</t></si>
<si><t>TELÉFONO</t></si>
<si><t>CORREO</t></si>
<si><t>POBLACIÓN</t></si>
<si><t>PROVINCIA</t></si>
<si><t>OBSERVACIONES</t></si>
<si><t>Electricidad</t></si>
<si><t>Instalaciones Eléctricas García</t></si>
<si><t>Juan García</t></si>
<si><t>925 123 456</t></si>
<si><t>info@garcia.com</t></si>
<si><t>Talavera de la Reina</t></si>
<si><t>Toledo</t></si>
<si><t>Cliente potencial</t></si>
<si><t>Gestoría</t></si>
<si><t>Asesoría Fiscal López</t></si>
<si><t>María López</t></si>
<si><t>925 234 567</t></si>
<si><t>contacto@lopez.com</t></si>
<si><t>Talavera de la Reina</t></si>
<si><t>Toledo</t></si>
<si><t>Interesado en PRL</t></si>
</sst>';

// Crear el archivo ZIP (Excel es un ZIP)
$zip = new ZipArchive();
$filename = tempnam(sys_get_temp_dir(), 'excel');
$zip->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Agregar archivos necesarios
$zip->addFromString('[Content_Types].xml', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
<Default Extension="xml" ContentType="application/xml"/>
<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>
<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>
<Override PartName="/xl/sharedStrings.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sharedStrings+xml"/>
</Types>');

$zip->addFromString('_rels/.rels', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>
</Relationships>');

$zip->addFromString('xl/_rels/workbook.xml.rels', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>
<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings" Target="sharedStrings.xml"/>
</Relationships>');

$zip->addFromString('xl/workbook.xml', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
<sheets>
<sheet name="Clientes" sheetId="1" r:id="rId1"/>
</sheets>
</workbook>');

$zip->addFromString('xl/worksheets/sheet1.xml', $xml);
$zip->addFromString('xl/sharedStrings.xml', $strings);

$zip->close();

// Enviar el archivo
readfile($filename);
unlink($filename);
exit;
?>

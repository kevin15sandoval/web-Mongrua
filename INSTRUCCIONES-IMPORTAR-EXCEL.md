# 📥 Instrucciones para Importar Excel al CRM

## ✅ Sistema Completado

Hemos creado un **importador inteligente de Excel** que:

### 🎯 Características Principales

1. **Detección Automática de Estructura**
   - Lee archivos `.xlsx` directamente (sin necesidad de convertir a CSV)
   - Detecta automáticamente las columnas: EMPRESA, CONTACTO, TELÉFONO, CORREO, POBLACIÓN, PROVINCIA, SECTOR, OBSERVACIONES
   - Funciona con diferentes formatos de Excel

2. **Separación Inteligente de Datos**
   - ✅ Empresa → Campo `empresa`
   - ✅ Contacto/Nombre → Campo `nombre`
   - ✅ Teléfono → Campo `telefono` (limpiado y validado)
   - ✅ Correo/Email → Campo `email` (validado)
   - ✅ Población/Ciudad → Campo `ciudad`
   - ✅ Provincia → Campo `provincia`
   - ✅ Sector → Campo `sector`
   - ✅ Observaciones → Campo `notas`

3. **Categorización Automática por Lista**
   - "Empresas de Electricidad.xlsx" → Lista: "Empresas Electricidad"
   - "Gestorias-Asesorias Talavera.xlsx" → Lista: "Gestorías y Asesorías"
   - "Empresas Talavera.xlsx" → Lista: "Empresas Talavera"
   - Otros archivos → Lista: "General"

4. **Validaciones y Limpieza**
   - ✅ Limpia números de teléfono (elimina caracteres especiales)
   - ✅ Valida emails (formato correcto)
   - ✅ Genera emails temporales si no existe (nombre@pendiente.com)
   - ✅ Detecta y omite duplicados
   - ✅ Evita filas vacías

### 📊 CRM Mejorado

El CRM ahora incluye:

1. **Paginación**
   - Muestra 10 clientes por página
   - Navegación entre páginas (Anterior/Siguiente)
   - Contador de páginas

2. **Filtros Avanzados**
   - 🔍 Búsqueda por nombre, email, empresa, teléfono
   - 🏷️ Filtro por lista (Empresas Electricidad, Gestorías, etc.)
   - 📊 Filtro por sector
   - Combinación de múltiples filtros

3. **Vista Detallada de Cliente**
   - Botón "👁️ Ver" en cada cliente
   - Modal con todos los datos del cliente:
     - Nombre, Email, Teléfono
     - Empresa, Ciudad, Provincia
     - Sector, Lista, Fecha de registro
     - Notas/Observaciones

4. **Estructura de Base de Datos Completa**
   ```
   - nombre (contacto)
   - email
   - telefono
   - empresa
   - direccion
   - ciudad
   - provincia
   - codigo_postal
   - sector
   - interes
   - lista (categoría del Excel)
   - origen
   - estado
   - notas
   - fecha_registro
   - ultima_actividad
   ```

## 🚀 Cómo Usar

### Paso 1: Acceder al Importador
1. Ve al CRM: `http://mongruasformacion.local/crm-mailing-completo.php`
2. En la pestaña "Gestión de Clientes", haz clic en "📥 Importar Excel"
3. O accede directamente: `http://mongruasformacion.local/importar-todos-excel-crm.php`

### Paso 2: Subir Archivo Excel
1. Haz clic en el área de carga o arrastra el archivo
2. Selecciona uno de los archivos `.xlsx` de la carpeta `/doc/`:
   - `Empresas de Electricidad.xlsx`
   - `Gestorias-Asesorias Talavera.xlsx`
   - `Empresas Talavera.xlsx`
3. Haz clic en "✅ Importar Clientes"

### Paso 3: Verificar Importación
1. El sistema mostrará:
   - ✅ Número de clientes importados
   - ⚠️ Duplicados omitidos
   - ❌ Errores (si los hay)
   - 📋 Estructura detectada
   - 📁 Lista asignada

### Paso 4: Ver Clientes en el CRM
1. Vuelve al CRM
2. Usa los filtros para ver clientes por lista
3. Haz clic en "👁️ Ver" para ver detalles completos
4. Navega entre páginas con los botones Anterior/Siguiente

## 📁 Archivos Creados

1. **`importar-todos-excel-crm.php`**
   - Importador inteligente de Excel
   - Lee archivos .xlsx directamente
   - Detecta estructura automáticamente

2. **`crm-mailing-completo.php`** (actualizado)
   - Paginación (10 por página)
   - Filtros por lista, sector y búsqueda
   - Vista detallada de clientes
   - Modal con información completa

3. **`resetear-crm-completo.php`**
   - Limpia la base de datos
   - Recrea la estructura correcta
   - Úsalo si necesitas empezar de cero

## 🎨 Características Visuales

- **Diseño moderno** con gradientes y sombras
- **Iconos** para mejor identificación
- **Colores** por categoría (listas, sectores)
- **Modal elegante** para detalles de cliente
- **Responsive** (funciona en móvil y escritorio)

## 🔧 Próximos Pasos Sugeridos

1. ✅ Importar los 3 archivos Excel
2. ✅ Verificar que los datos se separaron correctamente
3. ✅ Probar los filtros por lista
4. ✅ Ver detalles de algunos clientes
5. ✅ Crear campañas de email segmentadas por lista

## 💡 Notas Importantes

- Los archivos Excel deben estar en formato `.xlsx`
- La primera fila debe contener los encabezados
- Los duplicados se detectan por email
- Si no hay email, se genera uno temporal
- Los teléfonos se limpian automáticamente
- Las listas se asignan según el nombre del archivo

## 🆘 Solución de Problemas

**Si los datos no se importan:**
1. Verifica que el archivo sea `.xlsx` (no `.xls` o `.csv`)
2. Asegúrate de que la primera fila tenga encabezados
3. Revisa que haya al menos nombre o email en cada fila

**Si aparecen muchos duplicados:**
1. Es normal si ya importaste el archivo antes
2. Usa `resetear-crm-completo.php` para limpiar y empezar de nuevo

**Si los datos están mezclados:**
1. El nuevo importador separa automáticamente
2. Si usaste el importador antiguo, resetea y vuelve a importar

---

¡Todo listo para importar tus archivos Excel! 🎉

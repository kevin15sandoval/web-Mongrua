# 📋 RESUMEN: Cómo Importar Correctamente al CRM

## ✅ ESTRUCTURA UNIFICADA DEL EXCEL

Tu Excel debe tener **exactamente** estas 8 columnas en este orden:

| A | B | C | D | E | F | G | H |
|---|---|---|---|---|---|---|---|
| **SECTOR** | **EMPRESA** | **CONTACTO** | **TELÉFONO** | **CORREO** | **POBLACIÓN** | **PROVINCIA** | **OBSERVACIONES** |

## 🎯 PASOS PARA IMPORTAR

### 1. Descargar la Plantilla
Ve a: `http://mongruasformacion.local/crm-mailing-completo.php`
- Haz clic en la pestaña "📥 Importar Datos"
- Haz clic en "⬇️ DESCARGAR PLANTILLA.xlsx"

### 2. Preparar tus Datos
- Abre la plantilla descargada
- Copia tus datos respetando el orden de las columnas
- **NO incluyas columna ID** (se crea automáticamente)
- Guarda como `.xlsx`

### 3. Limpiar Datos Anteriores (si es necesario)
Si ya importaste datos mal:
- Ve a: `http://mongruasformacion.local/LIMPIAR-TODO-CRM-YA.php`
- Esto eliminará todos los datos para empezar limpio

### 4. Importar
- Ve a: `http://mongruasformacion.local/importar-todos-excel-crm.php`
- Sube tu archivo Excel
- El sistema:
  - ✅ Crea IDs automáticamente
  - ✅ Valida emails
  - ✅ Limpia teléfonos
  - ✅ Detecta duplicados
  - ✅ Asigna listas según el nombre del archivo

### 5. Verificar
- Ve a: `http://mongruasformacion.local/crm-mailing-completo.php`
- Verifica que los datos se vean correctamente en la tabla

## 🔍 MAPEO: Excel → Base de Datos

| Excel (Columna) | → | Base de Datos (Campo) |
|-----------------|---|----------------------|
| A: SECTOR | → | `sector` |
| B: EMPRESA | → | `empresa` |
| C: CONTACTO | → | `nombre` |
| D: TELÉFONO | → | `telefono` |
| E: CORREO | → | `email` |
| F: POBLACIÓN | → | `ciudad` |
| G: PROVINCIA | → | `provincia` |
| H: OBSERVACIONES | → | `notas` |
| (automático) | → | `id` |
| (automático) | → | `lista` |
| (automático) | → | `origen` = "Importación Excel" |
| (automático) | → | `estado` = "activo" |
| (automático) | → | `fecha_registro` |

## 📊 TABLA DEL CRM (Orden de Columnas)

Cuando veas los datos en el CRM, aparecerán en este orden:

1. **ID** - Número único
2. **Nombre** - Contacto (columna C del Excel)
3. **Email** - Correo (columna E del Excel)
4. **Teléfono** - Teléfono (columna D del Excel)
5. **Empresa** - Empresa (columna B del Excel)
6. **Sector** - Sector (columna A del Excel)
7. **Ciudad** - Población (columna F del Excel)
8. **Provincia** - Provincia (columna G del Excel)
9. **Lista** - Asignada automáticamente
10. **Estado** - Activo/Inactivo
11. **Acciones** - Botón Ver

## ⚠️ IMPORTANTE

- **NO mezcles el orden de las columnas** en el Excel
- **Usa la plantilla descargada** para evitar errores
- **Limpia los datos anteriores** si ya importaste mal
- **Presiona Ctrl + F5** en el navegador para ver cambios

## 🚀 ENLACES RÁPIDOS

- **CRM Principal**: http://mongruasformacion.local/crm-mailing-completo.php
- **Importador**: http://mongruasformacion.local/importar-todos-excel-crm.php
- **Limpiar Datos**: http://mongruasformacion.local/LIMPIAR-TODO-CRM-YA.php
- **Plantilla Visual**: http://mongruasformacion.local/PLANTILLA-EXCEL-VISUAL.php

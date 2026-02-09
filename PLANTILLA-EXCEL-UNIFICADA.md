# 📊 PLANTILLA EXCEL UNIFICADA PARA CRM

## 🎯 ESTRUCTURA UNIFICADA

Todos los archivos Excel deben tener estos encabezados en este orden:

| A | B | C | D | E | F | G | H |
|---|---|---|---|---|---|---|---|
| **SECTOR** | **EMPRESA** | **CONTACTO** | **TELÉFONO** | **CORREO** | **POBLACIÓN** | **PROVINCIA** | **OBSERVACIONES** |

## 📝 DESCRIPCIÓN DE COLUMNAS

1. **SECTOR** (Columna A)
   - Tipo de empresa o sector al que pertenece
   - Ejemplos: "Electricidad", "Gestoría", "Asesoría", "Construcción", etc.

2. **EMPRESA** (Columna B)
   - Nombre de la empresa
   - Campo obligatorio

3. **CONTACTO** (Columna C)
   - Nombre de la persona de contacto
   - Puede estar vacío (se llenará manualmente después)

4. **TELÉFONO** (Columna D)
   - Teléfono de contacto
   - Formato: 925 123 456 o +34 925 123 456

5. **CORREO** (Columna E)
   - Email de contacto
   - Si está vacío, se generará uno temporal automáticamente

6. **POBLACIÓN** (Columna F)
   - Ciudad o población
   - Ejemplo: "Talavera de la Reina"

7. **PROVINCIA** (Columna G)
   - Provincia
   - Ejemplo: "Toledo"

8. **OBSERVACIONES** (Columna H)
   - Notas adicionales
   - Campo opcional

## 🔢 NOTA SOBRE EL ID

- **NO incluir columna ID en el Excel**
- El ID se creará automáticamente al importar al sistema
- El sistema asignará números consecutivos: 1, 2, 3, 4...

## 📁 ARCHIVOS A UNIFICAR

### 1. Empresas de Electricidad.xlsx
```
SECTOR: "Electricidad"
Resto de columnas según la estructura unificada
```

### 2. Gestorías-Asesorías Talavera.xlsx
```
SECTOR: "Gestoría" o "Asesoría"
Resto de columnas según la estructura unificada
```

### 3. Empresas Talavera.xlsx
```
SECTOR: "Servicios" (o el que corresponda)
Resto de columnas según la estructura unificada
```

## ✅ EJEMPLO DE DATOS

| SECTOR | EMPRESA | CONTACTO | TELÉFONO | CORREO | POBLACIÓN | PROVINCIA | OBSERVACIONES |
|--------|---------|----------|----------|--------|-----------|-----------|---------------------|
| Electricidad | Instalaciones Eléctricas García | Juan García | 925 123 456 | info@garcia.com | Talavera de la Reina | Toledo | Cliente potencial |
| Gestoría | Asesoría Fiscal López | María López | 925 234 567 | contacto@lopez.com | Talavera de la Reina | Toledo | Interesado en PRL |
| Construcción | Construcciones Pérez SL | | 925 345 678 | comercial@perez.com | Toledo | Toledo | Llamar en enero |

## 🚀 PROCESO DE IMPORTACIÓN

1. **Preparar Excel** con la estructura unificada
2. **Guardar** como .xlsx
3. **Subir** al sistema usando el importador
4. El sistema automáticamente:
   - ✅ Crea el ID único
   - ✅ Valida emails
   - ✅ Limpia teléfonos
   - ✅ Detecta duplicados
   - ✅ Asigna la lista correspondiente

## 📋 MAPEO AL SISTEMA CRM

| Excel | → | Base de Datos CRM |
|-------|---|-------------------|
| (ID automático) | → | `id` |
| SECTOR | → | `sector` |
| EMPRESA | → | `empresa` |
| CONTACTO | → | `nombre` |
| TELÉFONO | → | `telefono` |
| CORREO | → | `email` |
| POBLACIÓN | → | `ciudad` |
| PROVINCIA | → | `provincia` |
| OBSERVACIONES | → | `notas` |
| (automático) | → | `lista` (según archivo) |
| (automático) | → | `origen` = "Importación Excel" |
| (automático) | → | `estado` = "activo" |
| (automático) | → | `fecha_registro` |
| (automático) | → | `ultima_actividad` |

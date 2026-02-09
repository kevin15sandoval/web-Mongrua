# 📊 ORDEN CORRECTO DEL EXCEL PARA IMPORTAR

## ✅ TU EXCEL DEBE TENER EXACTAMENTE ESTE ORDEN:

```
┌─────────┬─────────┬──────────┬──────────┬─────────┬───────────┬───────────┬──────────────┐
│    A    │    B    │    C     │    D     │    E    │     F     │     G     │      H       │
├─────────┼─────────┼──────────┼──────────┼─────────┼───────────┼───────────┼──────────────┤
│ SECTOR  │ EMPRESA │ CONTACTO │ TELÉFONO │ CORREO  │ POBLACIÓN │ PROVINCIA │ OBSERVACIONES│
└─────────┴─────────┴──────────┴──────────┴─────────┴───────────┴───────────┴──────────────┘
```

## 📋 EJEMPLO DE DATOS:

| A | B | C | D | E | F | G | H |
|---|---|---|---|---|---|---|---|
| **SECTOR** | **EMPRESA** | **CONTACTO** | **TELÉFONO** | **CORREO** | **POBLACIÓN** | **PROVINCIA** | **OBSERVACIONES** |
| Electricidad | Instalaciones García SL | Juan García | 925 123 456 | info@garcia.com | Talavera de la Reina | Toledo | Cliente potencial |
| Gestoría | Asesoría López | María López | 925 234 567 | contacto@lopez.com | Talavera de la Reina | Toledo | Interesado en PRL |
| Construcción | Construcciones Pérez | | 925 345 678 | comercial@perez.com | Toledo | Toledo | Llamar en enero |

## 🎯 CÓMO SE VERÁ EN EL CRM:

Cuando importes, el CRM mostrará las columnas en este orden:

```
ID | Nombre | Email | Teléfono | Empresa | Sector | Ciudad | Provincia | Lista | Estado | Acciones
```

**MAPEO:**
- Excel columna C (CONTACTO) → CRM columna "Nombre"
- Excel columna E (CORREO) → CRM columna "Email"  
- Excel columna D (TELÉFONO) → CRM columna "Teléfono"
- Excel columna B (EMPRESA) → CRM columna "Empresa"
- Excel columna A (SECTOR) → CRM columna "Sector"
- Excel columna F (POBLACIÓN) → CRM columna "Ciudad"
- Excel columna G (PROVINCIA) → CRM columna "Provincia"

## ⚠️ IMPORTANTE:

1. **NO cambies el orden de las columnas** en tu Excel
2. **La primera fila debe ser los encabezados** (SECTOR, EMPRESA, CONTACTO, etc.)
3. **NO incluyas columna ID** - se crea automáticamente
4. **Guarda como .xlsx**

## 🚀 PASOS PARA IMPORTAR:

1. **Descarga la plantilla**: 
   - Ve a http://mongruasformacion.local/crm-mailing-completo.php
   - Pestaña "📥 Importar Datos"
   - Clic en "⬇️ DESCARGAR PLANTILLA.xlsx"

2. **Copia tus datos** a la plantilla respetando el orden

3. **Guarda** como .xlsx

4. **Importa**:
   - Ve a http://mongruasformacion.local/importar-todos-excel-crm.php
   - Sube tu archivo
   - ¡Listo!

## 📸 REFERENCIA VISUAL:

Tu Excel actual probablemente tiene un orden diferente. Necesitas reorganizar las columnas para que coincidan con este orden:

**ORDEN CORRECTO:**
```
A: SECTOR
B: EMPRESA  
C: CONTACTO
D: TELÉFONO
E: CORREO
F: POBLACIÓN
G: PROVINCIA
H: OBSERVACIONES
```

Si tu Excel tiene las columnas en otro orden (por ejemplo: EMPRESA, TELÉFONO, CORREO, POBLACIÓN, PROVINCIA), necesitas:
1. Agregar columna SECTOR al principio
2. Agregar columna CONTACTO después de EMPRESA
3. Agregar columna OBSERVACIONES al final
4. Reorganizar para que queden en el orden correcto

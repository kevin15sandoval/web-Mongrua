# 🚀 Configuración Instagram - Pasos Rápidos

## ✅ Lo que ya está hecho

El sistema de publicación automática en Instagram está **completamente implementado y funcionando**. Solo necesitas configurar las credenciales de Instagram.

---

## 📋 CHECKLIST RÁPIDO

### PASO 1: Preparar Instagram (10 minutos)

1. **Convertir a cuenta Business:**
   - Abre Instagram en tu móvil
   - Ve a tu perfil → ☰ → Configuración
   - Cuenta → Cambiar a cuenta profesional
   - Selecciona "Empresa"

2. **Vincular con Facebook:**
   - En el mismo proceso, vincula con tu página de Facebook
   - Si no tienes página, créala en Facebook

✅ **Verificación:** Tu Instagram debe mostrar "Cuenta profesional" en configuración

---

### PASO 2: Crear App en Facebook (15 minutos)

1. **Ir a Facebook Developers:**
   - Ve a: https://developers.facebook.com/
   - Inicia sesión con tu cuenta de Facebook
   - Clic en "Mis aplicaciones" (arriba derecha)

2. **Crear aplicación:**
   - Clic en "Crear aplicación"
   - Tipo: **"Empresa"**
   - Nombre: `Mongruas Instagram Bot`
   - Email: tu email
   - Clic en "Crear aplicación"

3. **Añadir Instagram Graph API:**
   - En el panel de tu app, busca "Instagram Graph API"
   - Clic en "Configurar"
   - Acepta los términos

✅ **Verificación:** Debes ver "Instagram Graph API" en productos añadidos

---

### PASO 3: Obtener Access Token (10 minutos)

1. **Ir a Graph API Explorer:**
   - En el menú lateral: Herramientas → Graph API Explorer
   - En "Facebook App": selecciona tu app `Mongruas Instagram Bot`
   - En "User or Page": selecciona tu página de Facebook

2. **Generar Token:**
   - Clic en "Generate Access Token"
   - Acepta TODOS los permisos:
     - ✅ instagram_basic
     - ✅ instagram_content_publish
     - ✅ pages_read_engagement
     - ✅ pages_show_list
   - Copia el token (empieza con `EAAG...`)

3. **⚠️ IMPORTANTE - Extender a 60 días:**
   - Ve a: Herramientas → Access Token Debugger
   - Pega tu token
   - Clic en "Extend Access Token"
   - **Copia el NUEVO token** (este dura 60 días)

✅ **Verificación:** El token debe empezar con `EAAG` y tener muchos caracteres

---

### PASO 4: Obtener Instagram Account ID (5 minutos)

1. **En Graph API Explorer:**
   - En el campo de consulta, escribe: `me/accounts`
   - Clic en "Enviar"
   - Busca tu página de Facebook en la respuesta
   - Copia el `id` de tu página (ejemplo: `123456789`)

2. **Obtener Instagram ID:**
   - En el campo de consulta, escribe (reemplaza con tu ID):
     ```
     123456789?fields=instagram_business_account
     ```
   - Clic en "Enviar"
   - Copia el número que aparece en `instagram_business_account.id`
   - **Este es tu Instagram Account ID** (guárdalo)

✅ **Verificación:** Debes tener un número largo (ejemplo: `17841400123456789`)

---

### PASO 5: Configurar en tu Panel (2 minutos)

1. **Acceder al panel:**
   - Ve a: http://mongruasformacion.local/configurar-instagram.php

2. **Pegar credenciales:**
   - **Access Token:** Pega el token de larga duración del Paso 3
   - **Instagram Account ID:** Pega el ID del Paso 4
   - **Publicar automáticamente:** ✅ Activar checkbox
   - Clic en "💾 Guardar Configuración"

✅ **Verificación:** Debe aparecer "✅ Configuración guardada correctamente"

---

### PASO 6: Probar el Sistema (5 minutos)

1. **Crear curso de prueba:**
   - Ve a: http://mongruasformacion.local/panel-gestion.php
   - Clic en "Agregar Nuevo Curso"
   - Rellena:
     - Nombre: "Curso de Prueba Instagram"
     - Descripción: "Este es un test de publicación automática"
     - Fecha: Cualquier fecha futura
     - **Imagen:** ⚠️ OBLIGATORIO - Sube una imagen
   - Clic en "Guardar"

2. **Verificar publicación:**
   - Ve a: http://mongruasformacion.local/ver-logs-instagram.php
   - Deberías ver un job con estado "pending"
   - Espera 5 minutos (el sistema procesa automáticamente)
   - Recarga la página
   - El estado debe cambiar a "completed"
   - **Revisa tu Instagram** - ¡debería estar publicado!

✅ **Verificación:** El curso debe aparecer en tu feed de Instagram

---

## 🎯 URLs Importantes

| Panel | URL |
|-------|-----|
| Configurar Instagram | http://mongruasformacion.local/configurar-instagram.php |
| Ver Logs | http://mongruasformacion.local/ver-logs-instagram.php |
| Panel de Cursos | http://mongruasformacion.local/panel-gestion.php |
| CRM Mailing | http://mongruasformacion.local/crm-mailing-completo.php |

---

## ❌ Solución de Problemas

### "Error al crear contenedor"
- **Causa:** La imagen no es accesible o formato incorrecto
- **Solución:** Usa JPG o PNG, asegúrate de que la imagen esté subida correctamente

### "Instagram no configurado"
- **Causa:** Credenciales incorrectas o vacías
- **Solución:** Verifica que pegaste correctamente el Access Token y Account ID (sin espacios)

### "Access Token expirado"
- **Causa:** El token tiene 60 días de validez
- **Solución:** Repite el Paso 3 para generar un nuevo token

### Jobs se quedan en "pending"
- **Solución:** Ve a `ver-logs-instagram.php` y haz clic en "Procesar Jobs Ahora"

---

## 🔄 Mantenimiento

### Cada 60 días (renovar token):
1. Ve a Facebook Developers
2. Graph API Explorer
3. Genera nuevo token
4. Extiende a larga duración
5. Actualiza en `configurar-instagram.php`

### Semanalmente (revisar logs):
- Ve a `ver-logs-instagram.php`
- Verifica que no haya errores
- Revisa estadísticas en `configurar-instagram.php`

---

## 📊 Cómo Funciona

```
1. Creas un curso en el panel
   ↓
2. Se crea un "job" en la base de datos
   ↓
3. Cada 5 minutos, el sistema procesa los jobs pendientes
   ↓
4. Se publica automáticamente en Instagram
   ↓
5. Puedes ver el resultado en los logs
```

---

## ✅ Checklist Final

Antes de terminar, verifica:

- [ ] Instagram convertido a cuenta Business
- [ ] Página de Facebook vinculada
- [ ] App creada en Facebook Developers
- [ ] Instagram Graph API añadida
- [ ] Access Token de larga duración obtenido
- [ ] Instagram Account ID obtenido
- [ ] Credenciales configuradas en el panel
- [ ] Publicación automática activada
- [ ] Curso de prueba creado
- [ ] Publicación verificada en Instagram

---

## 🎉 ¡Listo!

Una vez completados todos los pasos, cada vez que crees un curso nuevo se publicará automáticamente en Instagram en los próximos 5 minutos.

**Documentación completa:** `GUIA-CONFIGURACION-INSTAGRAM.md`
**Documentación técnica:** `SISTEMA-PUBLICACION-AUTOMATICA-INSTAGRAM.md`

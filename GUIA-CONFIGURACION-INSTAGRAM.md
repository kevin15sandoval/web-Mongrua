# 📱 Guía Completa: Configurar Instagram para Publicación Automática

## 🎯 ¿Qué vas a conseguir?

Cuando crees un curso nuevo en tu panel, automáticamente se publicará en Instagram con:
- Imagen del curso
- Nombre y descripción
- Fecha de inicio
- Hashtags relevantes

---

## 📋 PASO 1: Requisitos Previos

Antes de empezar, necesitas:

✅ Una cuenta de **Instagram Business** (no personal)
✅ Una página de **Facebook** vinculada a tu Instagram
✅ Acceso a **Facebook Developers** (https://developers.facebook.com)

### ¿Cómo convertir tu Instagram a Business?

1. Abre la app de Instagram
2. Ve a tu perfil → Menú (☰) → Configuración
3. Cuenta → Cambiar a cuenta profesional
4. Elige "Empresa"
5. Vincula con tu página de Facebook

---

## 🔧 PASO 2: Crear Aplicación en Facebook

### 2.1 Ir a Facebook Developers

1. Ve a: https://developers.facebook.com/
2. Inicia sesión con tu cuenta de Facebook
3. Haz clic en **"Mis aplicaciones"** (arriba derecha)
4. Haz clic en **"Crear aplicación"**

### 2.2 Configurar la Aplicación

1. Selecciona tipo: **"Empresa"**
2. Nombre de la app: `Mongruas Instagram Bot`
3. Email de contacto: tu email
4. Haz clic en **"Crear aplicación"**

### 2.3 Añadir Producto Instagram

1. En el panel de tu app, busca **"Instagram Graph API"**
2. Haz clic en **"Configurar"**
3. Acepta los términos

---

## 🔑 PASO 3: Obtener Access Token

### 3.1 Ir a Graph API Explorer

1. En el menú lateral, ve a **"Herramientas" → "Graph API Explorer"**
2. En "Facebook App", selecciona tu app creada
3. En "User or Page", selecciona tu página de Facebook

### 3.2 Generar Token

1. Haz clic en **"Generate Access Token"**
2. Acepta los permisos solicitados:
   - `instagram_basic`
   - `instagram_content_publish`
   - `pages_read_engagement`
   - `pages_show_list`
3. Copia el token generado (empieza con `EAAG...`)

### 3.3 Convertir a Token de Larga Duración

⚠️ **IMPORTANTE:** El token expira en 1 hora. Necesitas uno de larga duración (60 días).

1. Ve a: **"Herramientas" → "Access Token Debugger"**
2. Pega tu token
3. Haz clic en **"Extend Access Token"**
4. Copia el nuevo token (este dura 60 días)

---

## 🆔 PASO 4: Obtener Instagram Account ID

### 4.1 Usar Graph API Explorer

1. Ve de nuevo a **"Graph API Explorer"**
2. En el campo de consulta, escribe:
   ```
   me/accounts
   ```
3. Haz clic en **"Enviar"**
4. Busca tu página de Facebook en la respuesta
5. Copia el `id` de tu página

### 4.2 Obtener Instagram Business Account ID

1. En el campo de consulta, escribe (reemplaza PAGE_ID):
   ```
   PAGE_ID?fields=instagram_business_account
   ```
2. Haz clic en **"Enviar"**
3. Copia el número que aparece en `instagram_business_account.id`
4. **Este es tu Instagram Account ID** (guárdalo)

---

## ⚙️ PASO 5: Configurar en tu Panel

### 5.1 Acceder al Panel de Configuración

1. Ve a: `http://mongruasformacion.local/configurar-instagram.php`
2. Verás un panel con campos vacíos

### 5.2 Pegar las Credenciales

1. **Access Token:** Pega el token de larga duración del Paso 3.3
2. **Instagram Account ID:** Pega el ID del Paso 4.2
3. **Publicar automáticamente:** Activa el checkbox ✅
4. Haz clic en **"Guardar Configuración"**

### 5.3 Verificar Estado

Deberías ver:
- ✅ Instagram configurado correctamente
- Estado: Activo
- Estadísticas de jobs

---

## 🧪 PASO 6: Probar el Sistema

### 6.1 Crear un Curso de Prueba

1. Ve al panel de gestión de cursos
2. Crea un curso nuevo con:
   - Nombre: "Curso de Prueba Instagram"
   - Descripción: "Este es un test"
   - Fecha: Cualquier fecha futura
   - **Imagen:** Sube una imagen (obligatorio)

### 6.2 Verificar la Publicación

1. Ve a: `http://mongruasformacion.local/ver-logs-instagram.php`
2. Deberías ver un job con estado "pending"
3. Espera 5 minutos (el cron procesa cada 5 min)
4. Recarga la página
5. El estado debería cambiar a "completed"
6. **Revisa tu Instagram** - ¡debería estar publicado!

---

## 🔍 PASO 7: Monitoreo y Logs

### Ver Estadísticas

En `configurar-instagram.php` verás:
- Jobs pendientes
- Jobs completados
- Jobs fallidos
- Total de publicaciones

### Ver Logs Detallados

En `ver-logs-instagram.php` verás:
- Historial completo
- Errores (si los hay)
- Respuestas de Instagram API
- Botón para procesar jobs manualmente

---

## ❌ Solución de Problemas Comunes

### Error: "Access Token expirado"

**Solución:**
1. Ve a Facebook Developers
2. Genera un nuevo token de larga duración
3. Actualiza en el panel de configuración

### Error: "Instagram no configurado"

**Solución:**
- Verifica que pegaste correctamente el Access Token y Account ID
- Asegúrate de que no haya espacios al inicio o final

### Error: "Error al crear contenedor"

**Causas posibles:**
- La imagen no es accesible públicamente
- Formato de imagen no soportado (usa JPG o PNG)
- La URL de la imagen no es válida

**Solución:**
1. Verifica que la imagen del curso esté subida correctamente
2. Prueba con una imagen diferente
3. Asegúrate de que la URL sea accesible desde internet

### Jobs se quedan en "pending"

**Solución:**
1. Ve a `ver-logs-instagram.php`
2. Haz clic en **"Procesar Jobs Ahora"**
3. Si sigue sin funcionar, revisa los logs de error

### Error: "Permisos insuficientes"

**Solución:**
1. Ve a Facebook Developers
2. Verifica que tu app tenga los permisos:
   - `instagram_basic`
   - `instagram_content_publish`
3. Regenera el Access Token con todos los permisos

---

## 🔄 Mantenimiento

### Renovar Access Token (cada 60 días)

El token expira cada 60 días. Para renovarlo:

1. Ve a Facebook Developers
2. Graph API Explorer
3. Genera nuevo token
4. Extiende a larga duración
5. Actualiza en el panel

### Verificar Estado del Sistema

Revisa periódicamente:
- `configurar-instagram.php` - Estado general
- `ver-logs-instagram.php` - Logs y errores

---

## 📞 Contacto y Soporte

Si tienes problemas:

1. **Revisa los logs:** `ver-logs-instagram.php`
2. **Verifica la configuración:** `configurar-instagram.php`
3. **Consulta la documentación:** `SISTEMA-PUBLICACION-AUTOMATICA-INSTAGRAM.md`

---

## ✅ Checklist Final

Antes de dar por terminada la configuración, verifica:

- [ ] Instagram convertido a cuenta Business
- [ ] Página de Facebook vinculada
- [ ] Aplicación creada en Facebook Developers
- [ ] Instagram Graph API añadida
- [ ] Access Token de larga duración generado
- [ ] Instagram Account ID obtenido
- [ ] Credenciales pegadas en el panel
- [ ] Publicación automática activada
- [ ] Curso de prueba creado
- [ ] Publicación verificada en Instagram
- [ ] Logs revisados sin errores

---

## 🎉 ¡Listo!

Tu sistema de publicación automática en Instagram está configurado y funcionando.

Cada vez que crees un curso nuevo, se publicará automáticamente en Instagram en los próximos 5 minutos.

**URLs importantes:**
- Panel de configuración: `http://mongruasformacion.local/configurar-instagram.php`
- Ver logs: `http://mongruasformacion.local/ver-logs-instagram.php`
- Panel de cursos: `http://mongruasformacion.local/panel-gestion.php`

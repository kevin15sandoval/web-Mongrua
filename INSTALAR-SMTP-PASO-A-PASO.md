# 📧 Instalar SMTP - Guía Paso a Paso (MUY FÁCIL)

## 🎯 OBJETIVO
Hacer que los emails del CRM se envíen REALMENTE (ahora no se envían porque falta SMTP)

---

## 📋 PASO 1: Ir a WordPress Admin

1. Abre tu navegador
2. Ve a: `http://mongruasformacion.local/wp-admin`
3. Inicia sesión con tu usuario y contraseña de WordPress

---

## 📋 PASO 2: Instalar Plugin WP Mail SMTP

1. En el menú izquierdo, haz clic en **"Plugins"**
2. Haz clic en **"Añadir nuevo"**
3. En el buscador (arriba a la derecha), escribe: **WP Mail SMTP**
4. Busca el plugin que dice:
   ```
   WP Mail SMTP by WPForms
   ⭐⭐⭐⭐⭐ (5 estrellas)
   Más de 3 millones de instalaciones activas
   ```
5. Haz clic en **"Instalar ahora"** (botón azul)
6. Espera unos segundos...
7. Haz clic en **"Activar"** (botón azul)

✅ **Plugin instalado!**

---

## 📋 PASO 3: Configurar con Gmail

### 3.1 Ir a Configuración
1. En el menú izquierdo, busca **"WP Mail SMTP"**
2. Haz clic en **"Settings"** (Ajustes)

### 3.2 Configurar Datos Básicos
Rellena estos campos:

**From Email:**
```
tu-email@gmail.com
```
(Pon tu email de Gmail real)

**From Name:**
```
Mongruas Formación
```

**Force From Email:** ✅ (marca la casilla)
**Force From Name:** ✅ (marca la casilla)

### 3.3 Seleccionar Gmail
1. Baja un poco en la página
2. Verás varias opciones de "Mailer"
3. Haz clic en **"Gmail"** (el logo de Google)

### 3.4 Conectar con Google
1. Aparecerá un botón que dice **"Allow plugin to send emails using your Google account"**
2. Haz clic en ese botón
3. Se abrirá una ventana de Google
4. Selecciona tu cuenta de Gmail
5. Haz clic en **"Permitir"** o **"Allow"**
6. La ventana se cerrará automáticamente

### 3.5 Guardar
1. Baja hasta el final de la página
2. Haz clic en **"Save Settings"** (botón naranja grande)

✅ **SMTP Configurado!**

---

## 📋 PASO 4: Probar que Funciona

### Opción A: Test del Plugin
1. En el menú izquierdo, haz clic en **"WP Mail SMTP"**
2. Haz clic en **"Email Test"**
3. Pon tu email en "Send To:"
4. Haz clic en **"Send Email"**
5. Revisa tu bandeja de entrada (y spam)
6. ¿Llegó el email? ✅ ¡Funciona!

### Opción B: Test de Nuestro CRM
1. Ve a: `http://mongruasformacion.local/TEST-ENVIO-EMAIL.php`
2. Pon tu email
3. Haz clic en "Enviar Email de Prueba"
4. Revisa tu bandeja de entrada
5. ¿Llegó? ✅ ¡Funciona!

---

## 🎉 PASO 5: Usar el CRM

Ahora SÍ puedes enviar campañas:

1. Ve a: `http://mongruasformacion.local/crm-mailing-completo.php`
2. Pestaña **"Campañas de Email"**
3. Crea una campaña
4. Haz clic en **"👥 Seleccionar Destinatarios"**
5. Marca los clientes que quieres
6. Haz clic en **"🚀 Enviar Campaña a Seleccionados"**
7. ¡Los emails se enviarán REALMENTE!

---

## ❓ PROBLEMAS COMUNES

### "No puedo conectar con Gmail"
**Solución:**
1. Asegúrate de usar una cuenta de Gmail (no Outlook, Yahoo, etc.)
2. Intenta cerrar sesión y volver a conectar
3. Verifica que diste permisos a la aplicación

### "El email no llega"
**Solución:**
1. Revisa la carpeta de SPAM
2. Verifica que el email en "From Email" sea correcto
3. Prueba con otro email de destino

### "Error al guardar configuración"
**Solución:**
1. Verifica que completaste todos los campos obligatorios
2. Asegúrate de haber conectado con Google primero
3. Intenta refrescar la página (F5) y volver a intentar

---

## 🔒 SEGURIDAD

✅ **Es seguro:** WP Mail SMTP es un plugin oficial con millones de usuarios
✅ **Gmail es seguro:** Usa OAuth2 (no necesitas contraseña)
✅ **Permisos limitados:** Solo puede enviar emails, nada más

---

## 💡 ALTERNATIVA: Usar Otro Email (No Gmail)

Si no quieres usar Gmail, puedes usar cualquier servidor SMTP:

### Configuración SMTP Genérica:
1. En lugar de seleccionar "Gmail", selecciona **"Other SMTP"**
2. Rellena:
   - **SMTP Host:** smtp.tuservidor.com (pregunta a tu proveedor)
   - **SMTP Port:** 587 (o 465)
   - **Encryption:** TLS (o SSL)
   - **Authentication:** ON
   - **SMTP Username:** tu-email@tudominio.com
   - **SMTP Password:** tu-contraseña
3. Guarda y prueba

---

## 📞 NECESITAS AYUDA?

Si tienes problemas:
1. Revisa esta guía de nuevo
2. Verifica que seguiste todos los pasos
3. Prueba con el test del plugin primero
4. Revisa la carpeta de spam

---

## ✅ CHECKLIST FINAL

Marca cuando completes cada paso:

- [ ] Instalé el plugin WP Mail SMTP
- [ ] Activé el plugin
- [ ] Configuré "From Email" y "From Name"
- [ ] Seleccioné "Gmail" como mailer
- [ ] Conecté con mi cuenta de Google
- [ ] Guardé la configuración
- [ ] Probé enviando un email de prueba
- [ ] Recibí el email de prueba
- [ ] Probé enviar una campaña desde el CRM
- [ ] Los emails llegaron correctamente

---

**¡Listo! Ahora tu CRM puede enviar emails reales 🚀**

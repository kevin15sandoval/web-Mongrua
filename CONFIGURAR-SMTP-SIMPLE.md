# 📧 Configurar SMTP para Enviar Emails - GUÍA SIMPLE

## ⚠️ IMPORTANTE
En desarrollo local (Local by Flywheel), los emails NO se envían automáticamente. Necesitas configurar SMTP.

## 🎯 OPCIÓN 1: Usar Gmail (MÁS FÁCIL)

### Paso 1: Instalar Plugin WP Mail SMTP
1. Ve a WordPress Admin: `http://mongruasformacion.local/wp-admin`
2. Ve a **Plugins → Añadir nuevo**
3. Busca: **"WP Mail SMTP"**
4. Haz clic en **"Instalar ahora"**
5. Haz clic en **"Activar"**

### Paso 2: Configurar Gmail
1. Ve a **Ajustes → WP Mail SMTP**
2. Rellena estos datos:

```
De Email: tu-email@gmail.com
De Nombre: Mongruas Formación
Mailer: Gmail (selecciona esta opción)
```

3. Haz clic en **"Guardar ajustes"**

### Paso 3: Conectar con Google
1. El plugin te pedirá conectar con Google
2. Haz clic en **"Allow plugin to send emails using your Google account"**
3. Inicia sesión con tu cuenta de Gmail
4. Acepta los permisos

### Paso 4: Probar
1. Ve a **WP Mail SMTP → Email Test**
2. Pon tu email
3. Haz clic en **"Send Email"**
4. ¡Revisa tu bandeja de entrada!

---

## 🎯 OPCIÓN 2: Usar SMTP Genérico (Cualquier proveedor)

### Configuración Manual
Si tienes un servidor SMTP (de tu hosting, por ejemplo):

1. Ve a **Ajustes → WP Mail SMTP**
2. Selecciona **"Other SMTP"**
3. Rellena:

```
SMTP Host: smtp.tuservidor.com
SMTP Port: 587 (o 465 para SSL)
Encryption: TLS (o SSL)
Authentication: ON
SMTP Username: tu-email@tudominio.com
SMTP Password: tu-contraseña
```

4. Guarda y prueba

---

## 🎯 OPCIÓN 3: MailHog (Para desarrollo - NO envía emails reales)

Si solo quieres PROBAR sin enviar emails reales:

1. Local by Flywheel incluye MailHog
2. Ve a **Ajustes → WP Mail SMTP**
3. Selecciona **"Other SMTP"**
4. Configura:

```
SMTP Host: localhost
SMTP Port: 1025
Encryption: None
Authentication: OFF
```

5. Los emails se "capturan" pero no se envían realmente
6. Puedes verlos en: `http://localhost:8025` (si MailHog está activo)

---

## ✅ DESPUÉS DE CONFIGURAR

Una vez configurado SMTP, tu CRM funcionará perfectamente:

1. Ve a: `http://mongruasformacion.local/crm-mailing-completo.php`
2. Pestaña **"Campañas de Email"**
3. Crea una campaña
4. Haz clic en **"Enviar"**
5. ¡Los emails se enviarán!

---

## 🔍 VERIFICAR SI FUNCIONA

Ejecuta este archivo para probar:
```
http://mongruasformacion.local/TEST-ENVIO-EMAIL.php
```

Te dirá si el envío de emails está funcionando o no.

---

## 💡 RECOMENDACIÓN

**Para desarrollo:** Usa Gmail (Opción 1) - Es lo más fácil y rápido

**Para producción:** Usa el SMTP de tu hosting o un servicio profesional como:
- SendGrid
- Mailgun  
- Amazon SES
- SMTP de tu hosting

---

## ❓ PROBLEMAS COMUNES

### "No se envía el email"
- Verifica que WP Mail SMTP esté activado
- Revisa la configuración SMTP
- Prueba con el test del plugin

### "Gmail no funciona"
- Asegúrate de haber dado permisos a la app
- Verifica que la cuenta de Gmail sea correcta
- Intenta desconectar y volver a conectar

### "Los emails van a spam"
- Normal en desarrollo local
- En producción, configura SPF y DKIM en tu dominio

---

## 📞 SOPORTE

Si tienes problemas, el plugin WP Mail SMTP tiene muy buena documentación:
https://wpmailsmtp.com/docs/

¡Listo! Con esto podrás enviar emails desde tu CRM 🚀

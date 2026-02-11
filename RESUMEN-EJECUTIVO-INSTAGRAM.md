# 📱 Resumen Ejecutivo: Configuración Instagram

## 🎯 Objetivo
Configurar la publicación automática en Instagram para que cada vez que crees un curso nuevo, se publique automáticamente en tu cuenta de Instagram.

---

## ⏱️ Tiempo Total: 40 minutos

| Paso | Tiempo | Dificultad |
|------|--------|------------|
| 1. Preparar Instagram | 10 min | ⭐ Fácil |
| 2. Crear App Facebook | 15 min | ⭐⭐ Media |
| 3. Obtener Credenciales | 10 min | ⭐⭐ Media |
| 4. Configurar Panel | 2 min | ⭐ Fácil |
| 5. Probar Sistema | 5 min | ⭐ Fácil |

---

## 📝 Requisitos Previos

✅ Cuenta de Instagram (personal o business)
✅ Cuenta de Facebook
✅ Acceso a tu panel de administración
✅ 40 minutos de tiempo

---

## 🚀 Pasos Simplificados

### 1️⃣ INSTAGRAM → BUSINESS (10 min)

**En tu móvil:**
```
Instagram App
  → Tu perfil
    → ☰ (menú)
      → Configuración
        → Cuenta
          → Cambiar a cuenta profesional
            → Empresa
              → Vincular con Facebook
```

**Resultado:** Tu Instagram ahora es "Cuenta Business"

---

### 2️⃣ FACEBOOK DEVELOPERS → CREAR APP (15 min)

**En tu navegador:**
```
1. Ve a: https://developers.facebook.com/
2. Inicia sesión
3. Clic en "Mis aplicaciones"
4. Clic en "Crear aplicación"
5. Selecciona: "Empresa"
6. Nombre: "Mongruas Instagram Bot"
7. Email: tu email
8. Clic en "Crear aplicación"
9. Busca "Instagram Graph API"
10. Clic en "Configurar"
```

**Resultado:** App creada con Instagram Graph API

---

### 3️⃣ OBTENER CREDENCIALES (10 min)

#### A) Access Token

**En Facebook Developers:**
```
Herramientas → Graph API Explorer
  → Selecciona tu app
    → Selecciona tu página
      → Clic en "Generate Access Token"
        → Acepta TODOS los permisos
          → Copia el token
```

**⚠️ IMPORTANTE - Extender token:**
```
Herramientas → Access Token Debugger
  → Pega tu token
    → Clic en "Extend Access Token"
      → Copia el NUEVO token (este dura 60 días)
```

#### B) Instagram Account ID

**En Graph API Explorer:**
```
1. En el campo de consulta escribe: me/accounts
2. Clic en "Enviar"
3. Copia el "id" de tu página (ejemplo: 123456789)

4. En el campo de consulta escribe: 123456789?fields=instagram_business_account
   (reemplaza 123456789 con tu ID)
5. Clic en "Enviar"
6. Copia el número de "instagram_business_account.id"
```

**Resultado:** Tienes 2 credenciales:
- Access Token (empieza con EAAG...)
- Instagram Account ID (número largo)

---

### 4️⃣ CONFIGURAR EN TU PANEL (2 min)

**En tu navegador:**
```
1. Ve a: http://mongruasformacion.local/configurar-instagram.php
2. Pega el Access Token
3. Pega el Instagram Account ID
4. Activa "Publicar automáticamente"
5. Clic en "Guardar Configuración"
```

**Resultado:** ✅ Configuración guardada correctamente

---

### 5️⃣ PROBAR (5 min)

**Crear curso de prueba:**
```
1. Ve a: http://mongruasformacion.local/panel-gestion.php
2. Clic en "Agregar Nuevo Curso"
3. Rellena los datos
4. ⚠️ IMPORTANTE: Sube una imagen
5. Clic en "Guardar"
```

**Verificar publicación:**
```
1. Ve a: http://mongruasformacion.local/ver-logs-instagram.php
2. Verás un job con estado "pending"
3. Espera 5 minutos
4. Recarga la página
5. Estado debe cambiar a "completed"
6. Revisa tu Instagram
```

**Resultado:** 🎉 Curso publicado en Instagram

---

## 🔗 Enlaces Importantes

| Recurso | URL |
|---------|-----|
| Facebook Developers | https://developers.facebook.com/ |
| Configurar Instagram | http://mongruasformacion.local/configurar-instagram.php |
| Ver Logs | http://mongruasformacion.local/ver-logs-instagram.php |
| Panel de Cursos | http://mongruasformacion.local/panel-gestion.php |
| Guía Completa | GUIA-CONFIGURACION-INSTAGRAM.md |
| Pasos Rápidos | CONFIGURACION-INSTAGRAM-PASO-A-PASO.md |

---

## 📊 Cómo Funciona el Sistema

```
┌─────────────────────────────────────────────────┐
│  1. CREAS UN CURSO EN EL PANEL                  │
│     http://mongruasformacion.local/panel-gestion│
└─────────────────┬───────────────────────────────┘
                  │
                  ▼
┌─────────────────────────────────────────────────┐
│  2. SE CREA UN "JOB" EN LA BASE DE DATOS        │
│     Estado: "pending"                           │
└─────────────────┬───────────────────────────────┘
                  │
                  ▼
┌─────────────────────────────────────────────────┐
│  3. CADA 5 MINUTOS EL SISTEMA PROCESA JOBS      │
│     Automático (cron job)                       │
└─────────────────┬───────────────────────────────┘
                  │
                  ▼
┌─────────────────────────────────────────────────┐
│  4. SE PUBLICA EN INSTAGRAM                     │
│     - Imagen del curso                          │
│     - Nombre y descripción                      │
│     - Fecha de inicio                           │
│     - Hashtags                                  │
└─────────────────┬───────────────────────────────┘
                  │
                  ▼
┌─────────────────────────────────────────────────┐
│  5. PUEDES VER EL RESULTADO EN LOGS             │
│     http://mongruasformacion.local/ver-logs-    │
│     instagram.php                               │
└─────────────────────────────────────────────────┘
```

---

## ✅ Checklist de Verificación

Marca cada paso cuando lo completes:

### Preparación
- [ ] Instagram convertido a Business
- [ ] Página de Facebook vinculada

### Facebook Developers
- [ ] App creada
- [ ] Instagram Graph API añadida
- [ ] Access Token generado
- [ ] Access Token extendido a 60 días
- [ ] Instagram Account ID obtenido

### Configuración
- [ ] Credenciales pegadas en el panel
- [ ] Publicación automática activada
- [ ] Configuración guardada

### Prueba
- [ ] Curso de prueba creado
- [ ] Job aparece en logs
- [ ] Job procesado (estado: completed)
- [ ] Publicación verificada en Instagram

---

## 🆘 Ayuda Rápida

### ¿Dónde estoy?
- **Paso 1-2:** En tu móvil (Instagram)
- **Paso 3-4:** En tu navegador (Facebook Developers)
- **Paso 5-6:** En tu panel (mongruasformacion.local)

### ¿Qué necesito copiar?
1. **Access Token:** Texto largo que empieza con `EAAG...`
2. **Instagram Account ID:** Número largo (ejemplo: `17841400123456789`)

### ¿Cuánto tarda en publicarse?
- El sistema procesa cada 5 minutos
- Puedes forzar el procesamiento en `ver-logs-instagram.php`

### ¿Qué pasa si falla?
- El sistema reintenta hasta 3 veces
- Puedes ver el error en `ver-logs-instagram.php`
- Los errores más comunes:
  - Imagen no accesible → Sube la imagen correctamente
  - Token expirado → Genera un nuevo token
  - Permisos insuficientes → Acepta todos los permisos al generar el token

---

## 🔄 Mantenimiento

### Cada 60 días
El Access Token expira cada 60 días. Para renovarlo:

1. Ve a Facebook Developers
2. Graph API Explorer
3. Genera nuevo token
4. Extiende a larga duración
5. Actualiza en `configurar-instagram.php`

**Tip:** Pon un recordatorio en tu calendario para el día 55

---

## 📞 Soporte

Si tienes problemas:

1. **Revisa los logs:** http://mongruasformacion.local/ver-logs-instagram.php
2. **Lee la guía completa:** GUIA-CONFIGURACION-INSTAGRAM.md
3. **Verifica la configuración:** http://mongruasformacion.local/configurar-instagram.php

---

## 🎉 Resultado Final

Una vez configurado:

✅ Cada curso nuevo se publica automáticamente en Instagram
✅ No necesitas hacer nada manualmente
✅ Puedes ver el historial en los logs
✅ El sistema reintenta si falla
✅ Recibes notificaciones de errores

**¡Tu sistema de publicación automática está listo!** 🚀

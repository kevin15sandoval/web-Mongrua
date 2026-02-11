# ✅ Checklist Instagram - Imprimible

## 📱 CONFIGURACIÓN INSTAGRAM AUTOMATIZACIÓN

**Fecha de inicio:** _______________
**Completado por:** _______________

---

## FASE 1: PREPARACIÓN (10 min)

### Instagram Business
- [ ] Abrir Instagram en el móvil
- [ ] Ir a Configuración → Cuenta
- [ ] Cambiar a cuenta profesional
- [ ] Seleccionar "Empresa"
- [ ] Vincular con página de Facebook
- [ ] Verificar que aparece "Cuenta Business"

**Notas:**
```
_________________________________________________
_________________________________________________
```

---

## FASE 2: FACEBOOK DEVELOPERS (15 min)

### Crear Aplicación
- [ ] Ir a https://developers.facebook.com/
- [ ] Iniciar sesión
- [ ] Clic en "Mis aplicaciones"
- [ ] Clic en "Crear aplicación"
- [ ] Seleccionar tipo: "Empresa"
- [ ] Nombre: "Mongruas Instagram Bot"
- [ ] Email: ___________________________________
- [ ] Clic en "Crear aplicación"

### Añadir Instagram Graph API
- [ ] Buscar "Instagram Graph API"
- [ ] Clic en "Configurar"
- [ ] Aceptar términos
- [ ] Verificar que aparece en productos añadidos

**Notas:**
```
_________________________________________________
_________________________________________________
```

---

## FASE 3: CREDENCIALES (10 min)

### Access Token
- [ ] Ir a Herramientas → Graph API Explorer
- [ ] Seleccionar mi app
- [ ] Seleccionar mi página
- [ ] Clic en "Generate Access Token"
- [ ] Aceptar TODOS los permisos:
  - [ ] instagram_basic
  - [ ] instagram_content_publish
  - [ ] pages_read_engagement
  - [ ] pages_show_list
- [ ] Copiar token (empieza con EAAG...)

**Token copiado:** ✅ / ❌

### Extender Token
- [ ] Ir a Herramientas → Access Token Debugger
- [ ] Pegar token
- [ ] Clic en "Extend Access Token"
- [ ] Copiar NUEVO token (60 días)

**Token extendido:** ✅ / ❌

**Guardar token aquí (temporal):**
```
_________________________________________________
_________________________________________________
_________________________________________________
```

### Instagram Account ID
- [ ] Ir a Graph API Explorer
- [ ] Consulta: `me/accounts`
- [ ] Clic en "Enviar"
- [ ] Copiar ID de mi página: ___________________
- [ ] Consulta: `MI_PAGE_ID?fields=instagram_business_account`
- [ ] Clic en "Enviar"
- [ ] Copiar instagram_business_account.id

**Account ID:** _________________________________

**Notas:**
```
_________________________________________________
_________________________________________________
```

---

## FASE 4: CONFIGURACIÓN PANEL (2 min)

### Configurar Credenciales
- [ ] Ir a: http://mongruasformacion.local/configurar-instagram.php
- [ ] Pegar Access Token
- [ ] Pegar Instagram Account ID
- [ ] Activar "Publicar automáticamente"
- [ ] Clic en "Guardar Configuración"
- [ ] Verificar mensaje: "✅ Configuración guardada"

**Configuración guardada:** ✅ / ❌

**Notas:**
```
_________________________________________________
_________________________________________________
```

---

## FASE 5: PRUEBA (5 min)

### Crear Curso de Prueba
- [ ] Ir a: http://mongruasformacion.local/panel-gestion.php
- [ ] Clic en "Agregar Nuevo Curso"
- [ ] Nombre: "Curso de Prueba Instagram"
- [ ] Descripción: "Test de publicación automática"
- [ ] Fecha: ___________________________________
- [ ] ⚠️ SUBIR IMAGEN (obligatorio)
- [ ] Clic en "Guardar"

**Curso creado:** ✅ / ❌

### Verificar Publicación
- [ ] Ir a: http://mongruasformacion.local/ver-logs-instagram.php
- [ ] Verificar job con estado "pending"
- [ ] Esperar 5 minutos
- [ ] Recargar página
- [ ] Verificar estado "completed"
- [ ] Revisar Instagram
- [ ] Verificar que el curso está publicado

**Publicación exitosa:** ✅ / ❌

**Notas:**
```
_________________________________________________
_________________________________________________
```

---

## VERIFICACIÓN FINAL

### Checklist Completo
- [ ] Instagram es cuenta Business
- [ ] Página de Facebook vinculada
- [ ] App creada en Facebook Developers
- [ ] Instagram Graph API añadida
- [ ] Access Token obtenido y extendido
- [ ] Instagram Account ID obtenido
- [ ] Credenciales configuradas en panel
- [ ] Publicación automática activada
- [ ] Curso de prueba creado
- [ ] Publicación verificada en Instagram

**TOTAL:** _____ / 10

---

## INFORMACIÓN IMPORTANTE

### Credenciales (guardar en lugar seguro)

**Access Token:**
```
_________________________________________________
_________________________________________________
_________________________________________________
```

**Instagram Account ID:**
```
_________________________________________________
```

**Fecha de configuración:** _______________

**Fecha de expiración (60 días):** _______________

**Recordatorio renovación (55 días):** _______________

---

## MANTENIMIENTO

### Cada 60 días
- [ ] Renovar Access Token
- [ ] Extender a larga duración
- [ ] Actualizar en panel
- [ ] Verificar funcionamiento

### Semanalmente
- [ ] Revisar logs: http://mongruasformacion.local/ver-logs-instagram.php
- [ ] Verificar estadísticas
- [ ] Comprobar publicaciones

---

## URLS IMPORTANTES

| Recurso | URL |
|---------|-----|
| Facebook Developers | https://developers.facebook.com/ |
| Configurar Instagram | http://mongruasformacion.local/configurar-instagram.php |
| Ver Logs | http://mongruasformacion.local/ver-logs-instagram.php |
| Panel Cursos | http://mongruasformacion.local/panel-gestion.php |

---

## CONTACTO SOPORTE

**Documentación:**
- Guía completa: `GUIA-CONFIGURACION-INSTAGRAM.md`
- Pasos rápidos: `CONFIGURACION-INSTAGRAM-PASO-A-PASO.md`
- FAQ: `FAQ-INSTAGRAM-AUTOMATIZACION.md`

---

## NOTAS ADICIONALES

```
_________________________________________________
_________________________________________________
_________________________________________________
_________________________________________________
_________________________________________________
_________________________________________________
_________________________________________________
_________________________________________________
_________________________________________________
_________________________________________________
```

---

## FIRMA

**Configuración completada por:** _______________

**Fecha:** _______________

**Firma:** _______________

---

**✅ SISTEMA CONFIGURADO Y FUNCIONANDO**

---

## RECORDATORIOS

### 🔔 Próxima renovación de token:
**Fecha:** _______________

### 📊 Próxima revisión de logs:
**Fecha:** _______________

### 🧪 Próxima prueba del sistema:
**Fecha:** _______________

---

**Versión del documento:** 1.0
**Última actualización:** Febrero 2026

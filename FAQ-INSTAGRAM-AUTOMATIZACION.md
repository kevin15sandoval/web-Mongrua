# ❓ Preguntas Frecuentes - Instagram Automatización

## 📋 Índice

1. [Configuración Inicial](#configuración-inicial)
2. [Problemas Comunes](#problemas-comunes)
3. [Funcionamiento](#funcionamiento)
4. [Mantenimiento](#mantenimiento)
5. [Avanzado](#avanzado)

---

## Configuración Inicial

### ¿Necesito una cuenta de Instagram Business?
**Sí, es obligatorio.** Instagram Graph API solo funciona con cuentas Business o Creator. Las cuentas personales no tienen acceso a la API.

**Cómo convertir:**
1. Instagram → Configuración → Cuenta
2. Cambiar a cuenta profesional
3. Seleccionar "Empresa"

---

### ¿Necesito una página de Facebook?
**Sí.** Tu cuenta de Instagram Business debe estar vinculada a una página de Facebook. Esto es un requisito de Instagram Graph API.

**Si no tienes página:**
1. Ve a Facebook
2. Crea una página nueva
3. Vincúlala con tu Instagram

---

### ¿Cuánto cuesta usar Instagram Graph API?
**Es completamente gratis.** No hay costos por usar la API de Instagram.

---

### ¿Necesito conocimientos técnicos?
**No.** Solo necesitas seguir los pasos de la guía. Todo el código ya está implementado.

---

### ¿Cuánto tiempo tarda la configuración?
**Aproximadamente 40 minutos** la primera vez. Una vez configurado, no necesitas hacer nada más (excepto renovar el token cada 60 días).

---

## Problemas Comunes

### Error: "Instagram no configurado"

**Causa:** Las credenciales no están configuradas o son incorrectas.

**Solución:**
1. Ve a: http://mongruasformacion.local/configurar-instagram.php
2. Verifica que el Access Token y Account ID estén pegados correctamente
3. Asegúrate de que no haya espacios al inicio o final
4. Guarda la configuración

---

### Error: "Access Token expirado"

**Causa:** El token tiene una validez de 60 días.

**Solución:**
1. Ve a Facebook Developers
2. Graph API Explorer
3. Genera un nuevo token
4. **Importante:** Extiende a larga duración en Access Token Debugger
5. Actualiza en el panel de configuración

**Prevención:** Pon un recordatorio en tu calendario para renovar cada 55 días.

---

### Error: "Error al crear contenedor"

**Causas posibles:**
- La imagen no es accesible públicamente
- Formato de imagen no soportado
- URL de imagen inválida

**Solución:**
1. Verifica que la imagen del curso esté subida correctamente
2. Usa formatos JPG o PNG
3. Asegúrate de que la imagen sea accesible desde internet
4. Prueba con una imagen diferente

---

### Error: "Permisos insuficientes"

**Causa:** No aceptaste todos los permisos al generar el token.

**Solución:**
1. Ve a Facebook Developers → Graph API Explorer
2. Genera un nuevo token
3. **Acepta TODOS los permisos:**
   - ✅ instagram_basic
   - ✅ instagram_content_publish
   - ✅ pages_read_engagement
   - ✅ pages_show_list
4. Extiende a larga duración
5. Actualiza en el panel

---

### Los jobs se quedan en "pending"

**Causa:** El cron job no se está ejecutando o hay un error.

**Solución inmediata:**
1. Ve a: http://mongruasformacion.local/ver-logs-instagram.php
2. Haz clic en "Procesar Jobs Ahora"
3. Revisa si aparece algún error

**Solución permanente:**
- Verifica que el cron de WordPress esté funcionando
- Revisa los logs de error en `ver-logs-instagram.php`

---

### La publicación no aparece en Instagram

**Pasos para diagnosticar:**

1. **Verifica el estado del job:**
   - Ve a `ver-logs-instagram.php`
   - Busca el job del curso
   - Revisa el estado (pending, completed, failed)

2. **Si está "completed":**
   - Revisa tu feed de Instagram
   - A veces tarda unos minutos en aparecer
   - Verifica que estés viendo la cuenta correcta

3. **Si está "failed":**
   - Lee el mensaje de error en los logs
   - Sigue las soluciones según el error

4. **Si está "pending":**
   - Espera 5 minutos
   - O procesa manualmente en `ver-logs-instagram.php`

---

### Error: "Invalid Instagram Account ID"

**Causa:** El Instagram Account ID es incorrecto.

**Solución:**
1. Ve a Facebook Developers → Graph API Explorer
2. Consulta: `me/accounts`
3. Copia el `id` de tu página
4. Consulta: `TU_PAGE_ID?fields=instagram_business_account`
5. Copia el número de `instagram_business_account.id`
6. Actualiza en el panel

---

## Funcionamiento

### ¿Cuándo se publica en Instagram?

**Automáticamente** cuando:
1. Creas un curso nuevo en el panel
2. El sistema crea un "job" en la base de datos
3. Cada 5 minutos, el sistema procesa los jobs pendientes
4. Se publica en Instagram

**Total:** Máximo 5 minutos después de crear el curso.

---

### ¿Puedo publicar manualmente?

**Sí.** Puedes forzar el procesamiento:
1. Ve a: http://mongruasformacion.local/ver-logs-instagram.php
2. Haz clic en "Procesar Jobs Ahora"

---

### ¿Qué se publica exactamente?

El sistema publica:
- 📸 **Imagen del curso** (obligatoria)
- 📚 **Nombre del curso**
- 📝 **Descripción del curso**
- 📅 **Fecha de inicio**
- 🏷️ **Hashtags:** #Formación #Cursos #Mongruas #FormacionProfesional

**Ejemplo de publicación:**
```
🎓 ¡NUEVO GRUPO DISPONIBLE! 🎓

📚 Carretillero

Curso completo de carretillero con certificación oficial.

📅 Fecha: 15 de marzo de 2026

✅ ¡Plazas limitadas!
📞 Contacta con nosotros para más información

#Formación #Cursos #Mongruas #FormacionProfesional
```

---

### ¿Puedo personalizar el mensaje?

**Sí.** Edita el archivo:
```
app/public/wp-content/themes/mongruas-theme/inc/social-media-automation.php
```

Busca la función `generate_instagram_message()` y modifica el texto.

---

### ¿Puedo desactivar la publicación automática?

**Sí.** Hay dos formas:

**Opción 1 - Temporalmente:**
1. Ve a: http://mongruasformacion.local/configurar-instagram.php
2. Desactiva "Publicar automáticamente"
3. Guarda

**Opción 2 - Permanentemente:**
1. Edita `functions.php`
2. Comenta la línea:
   ```php
   // require_once MONGRUAS_THEME_DIR . '/inc/course-social-integration.php';
   ```

---

### ¿Qué pasa si creo un curso sin imagen?

**El sistema no publicará.** Instagram requiere imagen obligatoriamente.

**Solución:**
- Siempre sube una imagen al crear un curso
- El sistema mostrará un error en los logs si falta la imagen

---

### ¿Puedo publicar en otras redes sociales?

**Sí, el sistema está preparado.** Actualmente solo está implementado Instagram, pero puedes añadir:
- Facebook
- Twitter
- LinkedIn

El código ya tiene la estructura para múltiples plataformas.

---

## Mantenimiento

### ¿Cada cuánto debo renovar el token?

**Cada 60 días.** El Access Token de larga duración expira a los 60 días.

**Recomendación:** Renueva cada 55 días para evitar que expire.

---

### ¿Cómo sé cuándo expira mi token?

**Opción 1 - Access Token Debugger:**
1. Ve a Facebook Developers
2. Herramientas → Access Token Debugger
3. Pega tu token
4. Verás la fecha de expiración

**Opción 2 - Calendario:**
- Anota la fecha cuando configures el token
- Suma 60 días
- Pon un recordatorio

---

### ¿Qué mantenimiento necesita el sistema?

**Mínimo:**
- Renovar token cada 60 días
- Revisar logs ocasionalmente

**Recomendado:**
- Revisar logs semanalmente
- Verificar estadísticas en el panel
- Comprobar que las publicaciones se están haciendo correctamente

---

### ¿Dónde veo las estadísticas?

**Panel de configuración:**
http://mongruasformacion.local/configurar-instagram.php

Verás:
- Jobs pendientes
- Jobs completados
- Jobs fallidos
- Total de publicaciones

**Logs detallados:**
http://mongruasformacion.local/ver-logs-instagram.php

---

### ¿Cómo limpio los logs antiguos?

Los logs se guardan indefinidamente. Si quieres limpiarlos:

**Opción 1 - Manual (SQL):**
```sql
DELETE FROM wp_social_logs WHERE created_at < DATE_SUB(NOW(), INTERVAL 90 DAY);
```

**Opción 2 - Automático:**
Puedes añadir un cron job que limpie logs antiguos automáticamente.

---

## Avanzado

### ¿Dónde están los archivos del sistema?

**Archivos principales:**
```
app/public/wp-content/themes/mongruas-theme/inc/
  ├── social-media-automation.php      (Sistema principal)
  └── course-social-integration.php    (Integración con cursos)

app/public/
  ├── configurar-instagram.php         (Panel de configuración)
  └── ver-logs-instagram.php           (Visor de logs)
```

**Documentación:**
```
GUIA-CONFIGURACION-INSTAGRAM.md
CONFIGURACION-INSTAGRAM-PASO-A-PASO.md
RESUMEN-EJECUTIVO-INSTAGRAM.md
FAQ-INSTAGRAM-AUTOMATIZACION.md
SISTEMA-PUBLICACION-AUTOMATICA-INSTAGRAM.md
```

---

### ¿Cómo funciona el sistema de jobs?

**Flujo:**
1. Se crea un curso → Se dispara el hook `mongruas_course_created`
2. Se crea un job en la tabla `wp_social_jobs` con estado "pending"
3. Cada 5 minutos, el cron ejecuta `process_jobs()`
4. Se procesan hasta 10 jobs pendientes
5. Se publica en Instagram vía API
6. Se actualiza el estado a "completed" o "failed"
7. Se registra en `wp_social_logs`

---

### ¿Puedo cambiar el intervalo de procesamiento?

**Sí.** Edita `social-media-automation.php`:

```php
// Cambiar de 5 minutos a 10 minutos
add_filter('cron_schedules', function($schedules) {
    $schedules['ten_minutes'] = array(
        'interval' => 600,  // 10 minutos en segundos
        'display' => __('Cada 10 minutos')
    );
    return $schedules;
});
```

---

### ¿Puedo añadir más reintentos?

**Sí.** Al crear el job, puedes especificar `max_attempts`:

```php
$this->db->insert(
    $this->table_jobs,
    array(
        'course_id' => $course_id,
        'platform' => $platform,
        'status' => 'pending',
        'max_attempts' => 5,  // Cambiar de 3 a 5
        'payload' => $payload
    )
);
```

---

### ¿Cómo añado más plataformas?

**Ejemplo para Facebook:**

1. Añade el método en `social-media-automation.php`:
```php
private function publish_to_facebook($payload) {
    // Tu código para publicar en Facebook
}
```

2. Añade el case en `process_single_job()`:
```php
case 'facebook':
    $result = $this->publish_to_facebook($payload);
    break;
```

3. Crea el job:
```php
$social_media_automation->create_job($course_id, 'facebook');
```

---

### ¿Puedo programar publicaciones futuras?

**Sí.** Usa el parámetro `scheduled_at`:

```php
$fecha_futura = date('Y-m-d H:i:s', strtotime('+1 day'));
$social_media_automation->create_job($course_id, 'instagram', $fecha_futura);
```

---

### ¿Cómo depuro errores?

**1. Activa WP_DEBUG:**
```php
// En wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

**2. Revisa los logs:**
- WordPress: `wp-content/debug.log`
- Sistema: `ver-logs-instagram.php`

**3. Prueba la API manualmente:**
```php
// En Graph API Explorer
GET /me/accounts
GET /PAGE_ID?fields=instagram_business_account
```

---

### ¿Puedo usar webhooks en lugar de cron?

**Sí.** Puedes configurar un webhook que se ejecute inmediatamente:

```php
// En course-social-integration.php
function mongruas_auto_publish_course($course_id) {
    global $social_media_automation;
    
    // Crear job
    $job_id = $social_media_automation->create_job($course_id, 'instagram');
    
    // Procesar inmediatamente
    $social_media_automation->process_jobs();
}
```

---

## 🆘 Soporte

### ¿Dónde encuentro más ayuda?

**Documentación:**
- Guía completa: `GUIA-CONFIGURACION-INSTAGRAM.md`
- Pasos rápidos: `CONFIGURACION-INSTAGRAM-PASO-A-PASO.md`
- Resumen ejecutivo: `RESUMEN-EJECUTIVO-INSTAGRAM.md`
- Documentación técnica: `SISTEMA-PUBLICACION-AUTOMATICA-INSTAGRAM.md`

**Herramientas:**
- Panel de configuración: http://mongruasformacion.local/configurar-instagram.php
- Ver logs: http://mongruasformacion.local/ver-logs-instagram.php

**Recursos externos:**
- Instagram Graph API: https://developers.facebook.com/docs/instagram-api
- Facebook Developers: https://developers.facebook.com/

---

## 📝 Notas Finales

- El sistema está completamente implementado y probado
- Solo necesitas configurar las credenciales
- Una vez configurado, funciona automáticamente
- El mantenimiento es mínimo (renovar token cada 60 días)
- Puedes ver todo el historial en los logs

**¡El sistema está listo para usar!** 🚀

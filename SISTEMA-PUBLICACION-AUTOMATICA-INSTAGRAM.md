# 📱 Sistema de Publicación Automática en Instagram

## 🎯 Descripción

Sistema profesional de automatización que publica automáticamente en Instagram cuando se crea un nuevo curso. Incluye:

- ✅ Cola de trabajos (jobs) con reintentos automáticos
- ✅ Integración con Instagram Graph API
- ✅ Logs y trazabilidad completa
- ✅ Panel de configuración visual
- ✅ Procesamiento en background cada 5 minutos
- ✅ Manejo de errores y reintentos (hasta 3 intentos)

## 📁 Archivos Creados

### 1. Sistema Principal
- `app/public/wp-content/themes/mongruas-theme/inc/social-media-automation.php`
  - Clase principal del sistema
  - Gestión de cola de jobs
  - Integración con Instagram API
  - Sistema de logs

### 2. Integración con Cursos
- `app/public/wp-content/themes/mongruas-theme/inc/course-social-integration.php`
  - Hook que dispara publicación al crear curso
  - Endpoints AJAX para publicación manual
  - Procesamiento manual de jobs

### 3. Interfaces de Usuario
- `app/public/configurar-instagram.php`
  - Panel de configuración de Instagram
  - Gestión de credenciales API
  - Estadísticas en tiempo real

- `app/public/ver-logs-instagram.php`
  - Visualizador de logs
  - Historial de publicaciones
  - Estado de jobs

## 🚀 Instalación

### Paso 1: Activar el Sistema

Añade estas líneas en `functions.php`:

```php
// Cargar sistema de publicación automática en Instagram
require_once get_template_directory() . '/inc/social-media-automation.php';
require_once get_template_directory() . '/inc/course-social-integration.php';
```

### Paso 2: Configurar Instagram

1. Ve a https://developers.facebook.com/
2. Crea una aplicación
3. Añade el producto "Instagram Graph API"
4. Conecta tu cuenta de Instagram Business
5. Genera un Access Token de larga duración
6. Obtén tu Instagram Account ID

### Paso 3: Configurar en el Panel

1. Accede a: `http://tu-dominio.com/configurar-instagram.php`
2. Pega el Access Token
3. Pega el Account ID
4. Activa "Publicar automáticamente"
5. Guarda la configuración

## 📊 Base de Datos

El sistema crea automáticamente 2 tablas:

### Tabla: `wp_social_jobs`
```sql
- id: ID del job
- course_id: ID del curso
- platform: Plataforma (instagram, facebook)
- status: Estado (pending, completed, failed)
- attempts: Número de intentos
- max_attempts: Máximo de intentos (3)
- payload: Datos del curso en JSON
- error_message: Mensaje de error si falla
- created_at: Fecha de creación
- updated_at: Fecha de actualización
- scheduled_at: Fecha programada
```

### Tabla: `wp_social_logs`
```sql
- id: ID del log
- job_id: ID del job relacionado
- course_id: ID del curso
- platform: Plataforma
- action: Acción realizada
- status: Estado (success, error)
- message: Mensaje descriptivo
- response: Respuesta de la API
- created_at: Fecha del log
```

## 🔄 Flujo de Trabajo

### Flujo Automático

```
1. Usuario crea curso en panel
   ↓
2. Sistema guarda curso en DB
   ↓
3. Hook 'mongruas_course_created' se dispara
   ↓
4. Se crea un job en la cola
   ↓
5. Cron job procesa cada 5 minutos
   ↓
6. Se publica en Instagram
   ↓
7. Se registra en logs
```

### Flujo con Reintentos

```
Intento 1: Falla → Espera 5 min
   ↓
Intento 2: Falla → Espera 5 min
   ↓
Intento 3: Falla → Marca como "failed"
```

## 📝 Uso

### Publicación Automática

Cuando creas un curso desde el panel, automáticamente:
1. Se guarda en la base de datos
2. Se crea un job de Instagram
3. Se procesa en los próximos 5 minutos
4. Se publica en Instagram

### Publicación Manual

Para publicar un curso existente:

```javascript
// Desde JavaScript
fetch('/wp-admin/admin-ajax.php', {
    method: 'POST',
    body: new FormData(Object.entries({
        action: 'publish_course_to_social',
        course_id: 123,
        platform: 'instagram'
    }))
});
```

### Procesar Jobs Manualmente

```javascript
// Procesar todos los jobs pendientes ahora
fetch('/wp-admin/admin-ajax.php', {
    method: 'POST',
    body: 'action=process_social_jobs_now'
});
```

## 🎨 Formato del Post en Instagram

El sistema genera automáticamente un post con este formato:

```
🎓 ¡NUEVO GRUPO DISPONIBLE! 🎓

📚 [Nombre del Curso]

[Descripción del curso]

📅 Fecha: [Fecha de inicio]

✅ ¡Plazas limitadas!
📞 Contacta con nosotros para más información

#Formación #Cursos #Mongruas #FormacionProfesional
```

## 🔧 Configuración Avanzada

### Cambiar Intervalo de Procesamiento

Por defecto procesa cada 5 minutos. Para cambiar:

```php
// En social-media-automation.php
add_filter('cron_schedules', function($schedules) {
    $schedules['custom_interval'] = array(
        'interval' => 600, // 10 minutos
        'display' => __('Cada 10 minutos')
    );
    return $schedules;
});
```

### Cambiar Número de Reintentos

```php
// Al crear el job
$this->db->insert(
    $this->table_jobs,
    array(
        'max_attempts' => 5 // Cambiar de 3 a 5
    )
);
```

### Personalizar Mensaje

Edita la función `generate_instagram_message()` en `social-media-automation.php`:

```php
private function generate_instagram_message($payload) {
    $message = "🔥 ¡NUEVO CURSO! 🔥\n\n";
    // Tu formato personalizado
    return $message;
}
```

## 📊 Monitoreo

### Ver Estadísticas

Accede a: `http://tu-dominio.com/configurar-instagram.php`

Verás:
- Jobs pendientes
- Jobs completados
- Jobs fallidos
- Total de jobs

### Ver Logs Detallados

Accede a: `http://tu-dominio.com/ver-logs-instagram.php`

Verás:
- Historial completo de publicaciones
- Errores detallados
- Estado de cada job
- Respuestas de la API

## 🐛 Solución de Problemas

### Error: "Instagram no configurado"

**Solución:** Configura el Access Token y Account ID en el panel de configuración.

### Error: "Error al crear contenedor"

**Causas posibles:**
- Access Token expirado
- Imagen no accesible públicamente
- Formato de imagen no soportado

**Solución:** 
1. Regenera el Access Token
2. Verifica que la imagen sea accesible públicamente
3. Usa formatos JPG o PNG

### Jobs se quedan en "pending"

**Solución:**
1. Verifica que el cron de WordPress esté funcionando
2. Procesa manualmente desde el panel de logs
3. Revisa los logs de error de PHP

### Error: "Access Token expirado"

**Solución:**
1. Ve a Facebook Developers
2. Genera un nuevo Access Token de larga duración
3. Actualiza en el panel de configuración

## 🔐 Seguridad

- ✅ Verificación de permisos de administrador
- ✅ Sanitización de datos
- ✅ Nonces de WordPress
- ✅ Escape de salida
- ✅ Logs de auditoría

## 📈 Escalabilidad

El sistema está diseñado para escalar:

- **Procesamiento por lotes:** Procesa hasta 10 jobs por ejecución
- **Cola persistente:** Los jobs se guardan en DB
- **Reintentos automáticos:** Hasta 3 intentos por job
- **Logs históricos:** Mantiene registro completo

## 🎯 Próximas Mejoras

- [ ] Soporte para Facebook
- [ ] Soporte para Twitter/X
- [ ] Programación de publicaciones
- [ ] Plantillas de mensajes personalizables
- [ ] Notificaciones por email
- [ ] Dashboard con gráficas
- [ ] Exportación de reportes

## 📞 Soporte

Para problemas o dudas:
1. Revisa los logs en `ver-logs-instagram.php`
2. Verifica la configuración en `configurar-instagram.php`
3. Consulta la documentación de Instagram Graph API

## 📄 Licencia

Sistema desarrollado para Mongruas Formación.

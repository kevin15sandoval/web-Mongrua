# Panel de Gestión de Cursos - Mejores Prácticas de Seguridad

## Tabla de Contenidos

1. [Introducción a la Seguridad](#introducción-a-la-seguridad)
2. [Autenticación Segura](#autenticación-segura)
3. [Gestión de Sesiones](#gestión-de-sesiones)
4. [Protección de Datos](#protección-de-datos)
5. [Seguridad del Navegador](#seguridad-del-navegador)
6. [Monitoreo y Auditoría](#monitoreo-y-auditoría)
7. [Respuesta a Incidentes](#respuesta-a-incidentes)
8. [Configuración del Servidor](#configuración-del-servidor)
9. [Actualizaciones y Mantenimiento](#actualizaciones-y-mantenimiento)
10. [Lista de Verificación de Seguridad](#lista-de-verificación-de-seguridad)

## Introducción a la Seguridad

El Panel de Gestión de Cursos implementa múltiples capas de seguridad para proteger tanto los datos como el acceso al sistema. Esta guía detalla las mejores prácticas que deben seguirse para mantener la seguridad del sistema.

### Principios de Seguridad Implementados

- **Defensa en Profundidad**: Múltiples capas de protección
- **Principio de Menor Privilegio**: Acceso mínimo necesario
- **Validación de Entrada**: Todos los datos son validados
- **Cifrado de Datos**: Comunicaciones seguras
- **Auditoría**: Registro de actividades importantes

## Autenticación Segura

### Credenciales de Usuario

#### Requisitos de Contraseña

**Mínimos Obligatorios**:
- Longitud mínima: 12 caracteres
- Incluir mayúsculas y minúsculas
- Incluir números
- Incluir símbolos especiales
- No usar información personal

**Recomendaciones Avanzadas**:
```
✅ Usar frases de contraseña: "Mi-Curso-Favorito-2024!"
✅ Usar gestor de contraseñas
✅ Contraseñas únicas para cada servicio
✅ Cambiar contraseñas comprometidas inmediatamente
❌ No reutilizar contraseñas
❌ No compartir credenciales
❌ No usar contraseñas obvias
```

#### Autenticación de Dos Factores (2FA)

**Configuración Recomendada**:
1. **Instalar plugin de 2FA** en WordPress
2. **Configurar aplicación autenticadora** (Google Authenticator, Authy)
3. **Generar códigos de respaldo** y guardarlos seguros
4. **Probar funcionamiento** antes de activar completamente

**Plugins Recomendados**:
- Two Factor Authentication
- Google Authenticator
- Wordfence Login Security

### Gestión de Cuentas

#### Políticas de Usuario

```php
// Configuraciones recomendadas en wp-config.php

// Limitar intentos de login
define('LIMIT_LOGIN_ATTEMPTS', true);

// Forzar SSL para admin
define('FORCE_SSL_ADMIN', true);

// Ocultar errores de login
define('WP_DEBUG_DISPLAY', false);

// Deshabilitar edición de archivos
define('DISALLOW_FILE_EDIT', true);
```

#### Revisión Regular de Usuarios

**Mensualmente**:
- [ ] Revisar lista de usuarios administradores
- [ ] Verificar actividad reciente de usuarios
- [ ] Eliminar cuentas inactivas
- [ ] Verificar permisos de usuario

**Inmediatamente**:
- [ ] Eliminar usuarios que ya no necesitan acceso
- [ ] Cambiar contraseñas de usuarios comprometidos
- [ ] Revisar logs de acceso sospechoso

## Gestión de Sesiones

### Configuración de Sesiones

#### Timeouts de Sesión

**Configuración Actual**:
```javascript
// Sesión expira después de 2 horas de inactividad
const SESSION_TIMEOUT = 2 * 60 * 60 * 1000; // 2 horas

// Advertencia 5 minutos antes de expirar
const WARNING_TIME = 5 * 60 * 1000; // 5 minutos
```

**Mejores Prácticas**:
- Cerrar sesión al terminar de trabajar
- No dejar sesiones abiertas en computadoras compartidas
- Usar "Recordarme" solo en dispositivos personales seguros

#### Invalidación de Sesiones

**Cuándo se Invalidan Automáticamente**:
- Después del tiempo de inactividad configurado
- Al detectar actividad sospechosa
- Al cambiar contraseña
- Al cerrar sesión manualmente

**Invalidación Manual**:
```php
// Para invalidar todas las sesiones de un usuario
wp_destroy_all_sessions();

// Para invalidar sesiones específicas
wp_destroy_other_sessions();
```

### Protección CSRF

#### Tokens de Seguridad

**Implementación Actual**:
```javascript
// Cada petición incluye token CSRF
headers: {
    'X-WP-Nonce': wpApiSettings.nonce,
    'Content-Type': 'application/json'
}
```

**Verificación del Servidor**:
```php
// Verificación automática en cada endpoint
if (!wp_verify_nonce($nonce, 'mongruas-panel-nonce')) {
    return new WP_Error('invalid_nonce', 'Token de seguridad inválido');
}
```

## Protección de Datos

### Validación de Entrada

#### Validación del Cliente

**Campos de Curso**:
```javascript
// Validación en tiempo real
const validation = {
    name: {
        required: true,
        maxLength: 100,
        pattern: /^[a-zA-Z0-9\s\-\.]+$/
    },
    description: {
        required: true,
        maxLength: 500,
        sanitize: true
    },
    date: {
        required: true,
        format: 'YYYY-MM-DD',
        futureOnly: true
    }
};
```

#### Validación del Servidor

**Sanitización Automática**:
```php
public static function validate_course_data($data) {
    return array(
        'name' => sanitize_text_field($data['name']),
        'description' => wp_kses_post($data['description']),
        'date' => sanitize_text_field($data['date']),
        'duration' => sanitize_text_field($data['duration']),
        'modality' => sanitize_text_field($data['modality']),
        'category' => sanitize_text_field($data['category'])
    );
}
```

### Protección de Archivos

#### Subida de Imágenes

**Validaciones Implementadas**:
```php
// Tipos de archivo permitidos
$allowed_types = array('image/jpeg', 'image/png', 'image/webp');

// Tamaño máximo
$max_size = 5 * 1024 * 1024; // 5MB

// Validación de contenido
$image_info = getimagesize($file['tmp_name']);
if ($image_info === false) {
    return new WP_Error('invalid_image', 'Archivo no es una imagen válida');
}
```

**Mejores Prácticas para Usuarios**:
- Solo subir imágenes de fuentes confiables
- Escanear archivos con antivirus antes de subir
- No subir imágenes con información sensible en metadatos
- Usar imágenes optimizadas para web

### Backup y Recuperación

#### Estrategia de Backup

**Frecuencia Recomendada**:
- **Diario**: Base de datos completa
- **Semanal**: Archivos del sitio completo
- **Mensual**: Backup completo offsite

**Qué Incluir**:
- Base de datos de WordPress
- Archivos del tema
- Uploads de medios
- Configuraciones personalizadas

#### Procedimiento de Recuperación

**En Caso de Compromiso**:
1. **Aislar el sistema** inmediatamente
2. **Cambiar todas las contraseñas**
3. **Restaurar desde backup limpio**
4. **Actualizar todas las dependencias**
5. **Revisar logs para determinar causa**

## Seguridad del Navegador

### Configuración del Navegador

#### Headers de Seguridad

**Headers Implementados**:
```php
// En el servidor
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Content-Security-Policy: default-src \'self\'');
```

#### Configuración Recomendada del Navegador

**Chrome/Edge**:
```
1. Habilitar "Navegación segura"
2. Mantener actualizaciones automáticas
3. Revisar extensiones instaladas regularmente
4. Usar modo incógnito para sesiones sensibles
```

**Firefox**:
```
1. Habilitar "Protección mejorada contra rastreo"
2. Configurar DNS sobre HTTPS
3. Deshabilitar autocompletado de contraseñas en sitios no seguros
```

### Extensiones y Plugins

#### Extensiones Recomendadas

**Para Seguridad**:
- uBlock Origin (bloqueador de anuncios)
- HTTPS Everywhere (forzar HTTPS)
- Privacy Badger (protección de privacidad)

**Para Desarrollo** (solo si eres desarrollador):
- Web Developer Tools
- JSON Formatter

#### Extensiones a Evitar

❌ **Nunca Instalar**:
- Extensiones de fuentes desconocidas
- Extensiones que piden permisos excesivos
- Extensiones no actualizadas por más de 6 meses
- Extensiones con pocas descargas o malas reseñas

## Monitoreo y Auditoría

### Logs de Seguridad

#### Eventos Registrados

**Automáticamente**:
- Intentos de login (exitosos y fallidos)
- Cambios en cursos
- Subida de archivos
- Errores de autenticación
- Actividad sospechosa

**Formato de Log**:
```
[2024-12-16 10:30:15] INFO: Usuario 'admin' inició sesión desde IP 192.168.1.100
[2024-12-16 10:31:22] INFO: Curso 'Seguridad Industrial' actualizado por usuario 'admin'
[2024-12-16 10:35:45] WARNING: Intento de login fallido para usuario 'admin' desde IP 192.168.1.100
[2024-12-16 10:36:00] ERROR: Demasiados intentos de login para usuario 'admin', IP bloqueada
```

#### Revisión de Logs

**Diariamente**:
- [ ] Revisar intentos de login fallidos
- [ ] Verificar actividad fuera de horario normal
- [ ] Buscar patrones sospechosos

**Semanalmente**:
- [ ] Analizar tendencias de uso
- [ ] Revisar errores recurrentes
- [ ] Verificar integridad de logs

### Alertas Automáticas

#### Configuración de Alertas

**Eventos que Generan Alertas**:
- Múltiples intentos de login fallidos
- Login desde IP no reconocida
- Cambios fuera de horario laboral
- Errores críticos del sistema

**Canales de Notificación**:
- Email al administrador
- Notificaciones en el dashboard
- Logs centralizados (si están configurados)

## Respuesta a Incidentes

### Plan de Respuesta

#### Fase 1: Detección y Análisis

**Indicadores de Compromiso**:
- Actividad inusual en logs
- Cambios no autorizados en cursos
- Reportes de usuarios sobre comportamiento extraño
- Alertas de seguridad

**Acciones Inmediatas**:
1. **Documentar** el incidente
2. **Aislar** el sistema si es necesario
3. **Notificar** al equipo de seguridad
4. **Preservar** evidencia

#### Fase 2: Contención

**Medidas de Contención**:
```php
// Deshabilitar acceso temporalmente
define('MONGRUAS_PANEL_DISABLED', true);

// Forzar logout de todos los usuarios
wp_destroy_all_sessions();

// Cambiar claves de seguridad
// Generar nuevas en https://api.wordpress.org/secret-key/1.1/salt/
```

#### Fase 3: Erradicación y Recuperación

**Pasos de Recuperación**:
1. **Identificar** y eliminar la causa del compromiso
2. **Actualizar** todas las dependencias
3. **Cambiar** todas las contraseñas
4. **Restaurar** desde backup limpio si es necesario
5. **Fortalecer** medidas de seguridad

#### Fase 4: Lecciones Aprendidas

**Documentación Post-Incidente**:
- Cronología detallada del incidente
- Causa raíz identificada
- Medidas tomadas
- Mejoras implementadas
- Plan para prevenir recurrencia

## Configuración del Servidor

### Configuración de WordPress

#### wp-config.php Seguro

```php
<?php
// Configuraciones de seguridad recomendadas

// Forzar SSL
define('FORCE_SSL_ADMIN', true);

// Deshabilitar edición de archivos
define('DISALLOW_FILE_EDIT', true);
define('DISALLOW_FILE_MODS', true);

// Limitar revisiones
define('WP_POST_REVISIONS', 3);

// Configurar auto-guardado
define('AUTOSAVE_INTERVAL', 300); // 5 minutos

// Configurar memoria
define('WP_MEMORY_LIMIT', '256M');

// Configurar debug (solo en desarrollo)
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);

// Claves de seguridad (generar únicas)
define('AUTH_KEY',         'clave-única-aquí');
define('SECURE_AUTH_KEY',  'clave-única-aquí');
define('LOGGED_IN_KEY',    'clave-única-aquí');
define('NONCE_KEY',        'clave-única-aquí');
define('AUTH_SALT',        'clave-única-aquí');
define('SECURE_AUTH_SALT', 'clave-única-aquí');
define('LOGGED_IN_SALT',   'clave-única-aquí');
define('NONCE_SALT',       'clave-única-aquí');
?>
```

#### .htaccess Seguro

```apache
# Protección básica
<Files wp-config.php>
    Order allow,deny
    Deny from all
</Files>

# Proteger archivos sensibles
<FilesMatch "\.(htaccess|htpasswd|ini|log|sh|inc|bak)$">
    Order allow,deny
    Deny from all
</FilesMatch>

# Prevenir ejecución de PHP en uploads
<Directory "/wp-content/uploads/">
    <Files "*.php">
        Order allow,deny
        Deny from all
    </Files>
</Directory>

# Headers de seguridad
<IfModule mod_headers.c>
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options SAMEORIGIN
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
</IfModule>

# Forzar HTTPS
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</IfModule>
```

### Configuración del Servidor Web

#### Nginx (Recomendado)

```nginx
# Configuración de seguridad para Nginx
server {
    listen 443 ssl http2;
    server_name ejemplo.com;

    # SSL Configuration
    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    add_header Content-Security-Policy "default-src 'self'" always;

    # Rate limiting
    limit_req_zone $binary_remote_addr zone=login:10m rate=5r/m;
    
    location /wp-json/mongruas/v1/auth/login {
        limit_req zone=login burst=3 nodelay;
        try_files $uri $uri/ /index.php?$args;
    }

    # Bloquear acceso a archivos sensibles
    location ~* \.(htaccess|htpasswd|ini|log|sh|inc|bak)$ {
        deny all;
    }

    # Prevenir ejecución de PHP en uploads
    location ~* /(?:uploads|files)/.*\.php$ {
        deny all;
    }
}
```

## Actualizaciones y Mantenimiento

### Programa de Actualizaciones

#### Frecuencia de Actualizaciones

**Inmediatas** (dentro de 24 horas):
- Actualizaciones de seguridad críticas
- Parches de vulnerabilidades conocidas

**Semanales**:
- Actualizaciones menores de WordPress
- Actualizaciones de plugins de seguridad

**Mensuales**:
- Actualizaciones mayores de WordPress
- Revisión completa de plugins y temas
- Actualización de dependencias del servidor

#### Proceso de Actualización

**Pre-Actualización**:
1. **Backup completo** del sitio
2. **Probar en entorno de desarrollo**
3. **Revisar changelog** de cambios
4. **Planificar rollback** si es necesario

**Durante la Actualización**:
1. **Modo mantenimiento** activado
2. **Actualizar en orden**: WordPress core → plugins → tema
3. **Verificar funcionalidad** después de cada paso
4. **Probar panel de gestión** completamente

**Post-Actualización**:
1. **Verificar logs** de errores
2. **Probar funcionalidad crítica**
3. **Monitorear rendimiento**
4. **Documentar cambios**

### Mantenimiento Preventivo

#### Tareas Diarias

- [ ] Revisar logs de errores
- [ ] Verificar backups automáticos
- [ ] Monitorear intentos de login
- [ ] Verificar disponibilidad del sitio

#### Tareas Semanales

- [ ] Revisar actualizaciones disponibles
- [ ] Analizar logs de seguridad
- [ ] Verificar integridad de archivos
- [ ] Probar funcionalidad del panel

#### Tareas Mensuales

- [ ] Auditoría completa de seguridad
- [ ] Revisión de usuarios y permisos
- [ ] Optimización de base de datos
- [ ] Revisión de configuraciones de seguridad
- [ ] Test de recuperación de backup

## Lista de Verificación de Seguridad

### Configuración Inicial

- [ ] WordPress actualizado a última versión
- [ ] Tema actualizado a última versión
- [ ] Plugins de seguridad instalados y configurados
- [ ] SSL/TLS configurado correctamente
- [ ] Backups automáticos configurados
- [ ] Monitoreo de logs configurado
- [ ] Usuarios administradores revisados
- [ ] Contraseñas seguras implementadas
- [ ] 2FA habilitado para administradores
- [ ] Headers de seguridad configurados

### Verificación Mensual

- [ ] Revisar logs de seguridad
- [ ] Verificar integridad de backups
- [ ] Probar procedimiento de recuperación
- [ ] Revisar usuarios activos
- [ ] Verificar actualizaciones pendientes
- [ ] Probar funcionalidad del panel
- [ ] Revisar configuraciones de seguridad
- [ ] Verificar certificados SSL
- [ ] Analizar patrones de tráfico
- [ ] Documentar cambios realizados

### Respuesta a Incidentes

- [ ] Plan de respuesta documentado
- [ ] Contactos de emergencia actualizados
- [ ] Procedimientos de escalación definidos
- [ ] Herramientas de análisis disponibles
- [ ] Backups verificados y accesibles
- [ ] Comunicación con usuarios preparada

---

## Recursos Adicionales

### Herramientas de Seguridad Recomendadas

**Plugins de WordPress**:
- Wordfence Security
- Sucuri Security
- iThemes Security
- All In One WP Security

**Herramientas Externas**:
- SSL Labs Test (ssllabs.com/ssltest)
- Security Headers (securityheaders.com)
- Observatory by Mozilla (observatory.mozilla.org)

### Documentación de Referencia

- [WordPress Security Codex](https://wordpress.org/support/article/hardening-wordpress/)
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [NIST Cybersecurity Framework](https://www.nist.gov/cyberframework)

### Contactos de Emergencia

En caso de incidente de seguridad crítico:

1. **Administrador del Sistema**: [contacto]
2. **Desarrollador del Tema**: [contacto]
3. **Proveedor de Hosting**: [contacto]
4. **Consultor de Seguridad**: [contacto]

---

**Última actualización**: Diciembre 2024
**Próxima revisión**: Marzo 2025
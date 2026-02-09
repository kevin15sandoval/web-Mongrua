# Panel de Gestión de Cursos - Documentación Completa

## Bienvenido

Esta documentación completa cubre todos los aspectos del Panel de Gestión de Cursos, desde la instalación hasta el uso diario y la resolución de problemas.

## 📚 Documentación Disponible

### Para Usuarios

1. **[Guía del Usuario](USER-GUIDE.md)** - Guía completa de uso del panel
   - Acceso al panel
   - Gestión de cursos
   - Vista previa en tiempo real
   - Subida de imágenes
   - Preguntas frecuentes

2. **[Solución de Problemas](TROUBLESHOOTING.md)** - Resolución de problemas comunes
   - Diagnóstico rápido
   - Problemas de acceso y autenticación
   - Problemas de guardado e imágenes
   - Códigos de error y soluciones

### Para Administradores

3. **[Mejores Prácticas de Seguridad](SECURITY-BEST-PRACTICES.md)** - Guía completa de seguridad
   - Autenticación segura
   - Protección de datos
   - Monitoreo y auditoría
   - Respuesta a incidentes

### Para Desarrolladores

4. **[Documentación Técnica](TECHNICAL-DOCUMENTATION.md)** - Detalles técnicos de implementación
   - Arquitectura del sistema
   - APIs y endpoints
   - Estructura de código
   - Tests y validación

## 🚀 Inicio Rápido

### Para Usuarios Nuevos

1. **Leer la [Guía del Usuario](USER-GUIDE.md)** - Comienza aquí
2. **Localizar el botón de acceso** en la esquina inferior derecha del sitio
3. **Iniciar sesión** con tus credenciales de WordPress
4. **Crear tu primer curso** siguiendo la guía paso a paso

### Para Administradores

1. **Revisar [Mejores Prácticas de Seguridad](SECURITY-BEST-PRACTICES.md)**
2. **Configurar medidas de seguridad** recomendadas
3. **Establecer rutinas de backup** y monitoreo
4. **Capacitar usuarios** en el uso seguro del panel

## 🔧 Características Principales

### ✅ Funcionalidades Implementadas

- **Acceso Seguro**: Autenticación con credenciales de WordPress
- **Gestión Completa de Cursos**: Crear, editar, eliminar y reordenar cursos
- **Vista Previa en Tiempo Real**: Ver cambios instantáneamente
- **Subida de Imágenes**: Gestión completa de imágenes de cursos
- **Interfaz Responsive**: Funciona en todos los dispositivos
- **Auto-guardado**: Prevención automática de pérdida de datos
- **Validación en Tiempo Real**: Feedback inmediato sobre errores
- **Seguridad Robusta**: Múltiples capas de protección

### 🔒 Medidas de Seguridad

- **Autenticación WordPress**: Integración nativa con sistema de usuarios
- **Protección CSRF**: Tokens de seguridad en todas las operaciones
- **Rate Limiting**: Protección contra ataques de fuerza bruta
- **Validación de Datos**: Sanitización completa de entradas
- **Sesiones Seguras**: Gestión automática de timeouts
- **Logs de Auditoría**: Registro de todas las actividades

## 📋 Requisitos del Sistema

### Requisitos Mínimos

- **WordPress**: 5.0 o superior
- **PHP**: 7.4 o superior
- **MySQL**: 5.6 o superior
- **Navegador**: Chrome 70+, Firefox 65+, Safari 12+, Edge 79+

### Requisitos Recomendados

- **WordPress**: 6.0 o superior
- **PHP**: 8.0 o superior
- **MySQL**: 8.0 o superior
- **SSL**: Certificado válido configurado
- **Memoria**: 256MB mínimo para PHP

## 🛠️ Instalación y Configuración

### Instalación Automática

El panel se instala automáticamente con el tema Mongruas. No requiere configuración adicional.

### Verificación de Instalación

1. **Acceder como administrador** al sitio
2. **Buscar el botón de acceso** en la esquina inferior derecha
3. **Probar el login** con credenciales de WordPress
4. **Verificar funcionalidad** creando un curso de prueba

### Configuración Opcional

```php
// En wp-config.php - Configuraciones opcionales

// Personalizar timeout de sesión (en segundos)
define('MONGRUAS_SESSION_TIMEOUT', 7200); // 2 horas

// Habilitar logs detallados (solo desarrollo)
define('MONGRUAS_DEBUG_LOGS', false);

// Personalizar límite de intentos de login
define('MONGRUAS_LOGIN_ATTEMPTS', 5);

// Personalizar tiempo de bloqueo (en minutos)
define('MONGRUAS_LOCKOUT_TIME', 15);
```

## 📊 Estructura de Archivos

```
wp-content/themes/mongruas-theme/
├── docs/                              # Documentación
│   ├── README.md                      # Este archivo
│   ├── USER-GUIDE.md                  # Guía del usuario
│   ├── TROUBLESHOOTING.md             # Solución de problemas
│   ├── SECURITY-BEST-PRACTICES.md    # Mejores prácticas de seguridad
│   └── TECHNICAL-DOCUMENTATION.md    # Documentación técnica
├── inc/                               # Archivos PHP principales
│   ├── course-management-panel.php    # Controlador principal
│   └── security-config.php            # Configuraciones de seguridad
├── assets/                            # Recursos frontend
│   ├── css/
│   │   └── course-management-panel.css
│   └── js/
│       └── course-management-panel.js
└── tests/                             # Tests y validaciones
    ├── test-course-panel.php
    └── integration-tests/
```

## 🧪 Testing y Validación

### Tests Automáticos

El sistema incluye tests automáticos que verifican:

- **Funcionalidad básica**: Carga de archivos y clases
- **Endpoints de API**: Disponibilidad y respuesta
- **Seguridad**: Validación de tokens y permisos
- **Integración**: Compatibilidad con WordPress y ACF

### Ejecutar Tests

```php
// Acceder a la página de tests (solo administradores)
/wp-admin/admin.php?page=mongruas-tests

// O ejecutar desde código
do_action('mongruas_run_tests');
```

### Tests Manuales

Antes de usar en producción, verificar:

- [ ] Login funciona correctamente
- [ ] Crear curso guarda datos en ACF
- [ ] Editar curso actualiza información
- [ ] Eliminar curso remueve datos
- [ ] Subir imagen funciona
- [ ] Vista previa se actualiza en tiempo real
- [ ] Panel es responsive en móviles

## 🔍 Monitoreo y Mantenimiento

### Logs del Sistema

Los logs se encuentran en:
```
/wp-content/debug.log (si WP_DEBUG_LOG está habilitado)
/logs/php/error.log (logs del servidor)
```

### Monitoreo Recomendado

**Diario**:
- Revisar logs de errores
- Verificar intentos de login fallidos
- Confirmar funcionamiento básico

**Semanal**:
- Revisar actualizaciones disponibles
- Verificar integridad de backups
- Analizar patrones de uso

**Mensual**:
- Auditoría completa de seguridad
- Revisión de usuarios y permisos
- Optimización de rendimiento

### Mantenimiento Preventivo

1. **Mantener WordPress actualizado**
2. **Actualizar plugins de seguridad**
3. **Revisar y rotar contraseñas**
4. **Verificar backups regulares**
5. **Monitorear logs de seguridad**

## 🆘 Soporte y Ayuda

### Documentación de Referencia

- **[Guía del Usuario](USER-GUIDE.md)**: Para uso diario del panel
- **[Solución de Problemas](TROUBLESHOOTING.md)**: Para resolver problemas
- **[Seguridad](SECURITY-BEST-PRACTICES.md)**: Para configuración segura

### Canales de Soporte

1. **Primera línea**: Consultar documentación
2. **Segunda línea**: Administrador del sitio
3. **Tercera línea**: Desarrollador del tema
4. **Emergencias**: Contacto directo (ver documentación de seguridad)

### Información para Reportar Problemas

Cuando reportes un problema, incluye:

```
- Descripción detallada del problema
- Pasos exactos para reproducir
- Mensaje de error (si hay)
- Navegador y versión
- Capturas de pantalla
- Información del sistema (usar herramientas de diagnóstico)
```

## 📈 Roadmap y Futuras Mejoras

### Versión Actual (1.0.0)

- ✅ Gestión básica de cursos
- ✅ Vista previa en tiempo real
- ✅ Subida de imágenes
- ✅ Seguridad robusta
- ✅ Interfaz responsive

### Próximas Versiones

**v1.1.0** (Planificado):
- Gestión de contactos
- Envío de correos masivos
- Dashboard con estadísticas
- Mejoras en UX

**v1.2.0** (Futuro):
- Plantillas de cursos
- Programación automática
- Integración con calendarios
- API pública

## 🤝 Contribuciones

### Reportar Problemas

1. **Verificar** que el problema no esté ya documentado
2. **Recopilar** información detallada del problema
3. **Contactar** al administrador del sitio
4. **Proporcionar** pasos para reproducir

### Sugerir Mejoras

1. **Describir** la mejora propuesta
2. **Explicar** el beneficio esperado
3. **Considerar** impacto en seguridad
4. **Proponer** implementación si es posible

## 📄 Licencia y Créditos

### Licencia

Este panel es parte del tema Mongruas y está licenciado bajo los mismos términos que WordPress (GPL v2 o posterior).

### Créditos

- **Desarrollo**: Equipo de desarrollo Mongruas
- **Seguridad**: Basado en mejores prácticas de WordPress
- **UI/UX**: Diseño responsive y accesible
- **Testing**: Validación automática y manual

### Dependencias

- **WordPress**: Sistema de gestión de contenidos
- **Advanced Custom Fields**: Gestión de campos personalizados
- **JavaScript ES6+**: Funcionalidad frontend
- **CSS3**: Estilos y responsive design

## 📞 Contacto

### Soporte Técnico

- **Email**: [configurar según necesidades]
- **Horario**: Lunes a Viernes, 9:00 - 18:00
- **Tiempo de respuesta**: 24-48 horas para problemas no críticos

### Emergencias de Seguridad

- **Contacto directo**: [configurar según necesidades]
- **Disponibilidad**: 24/7 para incidentes críticos
- **Escalación**: Automática para problemas de seguridad

---

## 📝 Historial de Versiones

### v1.0.0 (Diciembre 2024)
- Lanzamiento inicial
- Gestión completa de cursos
- Vista previa en tiempo real
- Sistema de seguridad robusto
- Documentación completa

---

**Última actualización**: Diciembre 2024  
**Próxima revisión**: Marzo 2025

Para más información, consulta la documentación específica en los enlaces proporcionados arriba.
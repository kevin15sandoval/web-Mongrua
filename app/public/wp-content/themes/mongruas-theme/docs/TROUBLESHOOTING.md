# Panel de Gestión de Cursos - Guía de Solución de Problemas

## Tabla de Contenidos

1. [Diagnóstico Rápido](#diagnóstico-rápido)
2. [Problemas de Acceso](#problemas-de-acceso)
3. [Problemas de Autenticación](#problemas-de-autenticación)
4. [Problemas de Guardado](#problemas-de-guardado)
5. [Problemas de Imágenes](#problemas-de-imágenes)
6. [Problemas de Vista Previa](#problemas-de-vista-previa)
7. [Problemas de Rendimiento](#problemas-de-rendimiento)
8. [Errores del Sistema](#errores-del-sistema)
9. [Herramientas de Diagnóstico](#herramientas-de-diagnóstico)
10. [Contacto de Soporte](#contacto-de-soporte)

## Diagnóstico Rápido

### Lista de Verificación Inicial

Antes de proceder con soluciones específicas, verifica lo siguiente:

- [ ] ¿Tienes permisos de administrador en WordPress?
- [ ] ¿Está habilitado JavaScript en tu navegador?
- [ ] ¿Tienes conexión estable a internet?
- [ ] ¿Has intentado recargar la página?
- [ ] ¿Has limpiado la caché del navegador?

### Verificación del Sistema

1. **Abrir herramientas de desarrollador** (F12 en la mayoría de navegadores)
2. **Ir a la pestaña Console**
3. **Buscar errores en rojo**
4. **Anotar cualquier mensaje de error**

## Problemas de Acceso

### El botón de acceso no aparece

**Síntomas**:
- No se ve el botón flotante en la esquina inferior derecha
- La página carga normalmente pero sin el botón

**Causas Posibles**:
- No tienes permisos de administrador
- JavaScript está deshabilitado
- Conflicto con otros plugins
- Error en la carga de archivos CSS/JS

**Soluciones**:

1. **Verificar permisos de usuario**:
   ```
   1. Ir a wp-admin
   2. Verificar que tu rol es "Administrador"
   3. Si no es así, contactar al super-administrador
   ```

2. **Habilitar JavaScript**:
   ```
   Chrome: Configuración > Privacidad y seguridad > Configuración del sitio > JavaScript
   Firefox: about:config > javascript.enabled = true
   Safari: Preferencias > Seguridad > Habilitar JavaScript
   ```

3. **Limpiar caché del navegador**:
   ```
   Ctrl+Shift+Delete (Windows/Linux)
   Cmd+Shift+Delete (Mac)
   Seleccionar "Todo el tiempo" y limpiar
   ```

4. **Verificar conflictos de plugins**:
   ```
   1. Desactivar todos los plugins temporalmente
   2. Verificar si aparece el botón
   3. Reactivar plugins uno por uno para identificar el conflicto
   ```

### El botón aparece pero no responde

**Síntomas**:
- El botón es visible pero no pasa nada al hacer clic
- No se abre el modal de login

**Soluciones**:

1. **Verificar errores de JavaScript**:
   ```
   1. Abrir herramientas de desarrollador (F12)
   2. Ir a Console
   3. Buscar errores relacionados con "course-management-panel"
   ```

2. **Forzar recarga de recursos**:
   ```
   Ctrl+F5 (Windows/Linux)
   Cmd+Shift+R (Mac)
   ```

3. **Verificar que los archivos se cargan correctamente**:
   ```
   1. Ir a Network en herramientas de desarrollador
   2. Recargar la página
   3. Verificar que course-management-panel.js se carga sin errores (código 200)
   ```

## Problemas de Autenticación

### Credenciales correctas pero no puedo entrar

**Síntomas**:
- Mensaje "Credenciales inválidas" con credenciales correctas
- El formulario se resetea después de enviar

**Soluciones**:

1. **Verificar que las credenciales funcionan en wp-admin**:
   ```
   1. Ir a /wp-admin/
   2. Intentar iniciar sesión con las mismas credenciales
   3. Si no funciona, el problema es con las credenciales
   ```

2. **Limpiar cookies y sesiones**:
   ```
   1. Cerrar todas las pestañas del sitio
   2. Limpiar cookies del dominio
   3. Intentar nuevamente
   ```

3. **Verificar configuración de seguridad**:
   ```
   1. Verificar que no hay plugins de seguridad bloqueando
   2. Revisar si hay restricciones de IP
   3. Verificar configuración de firewall
   ```

### Error "Demasiados intentos de login"

**Síntomas**:
- Mensaje indicando que se han excedido los intentos
- No se puede intentar iniciar sesión

**Soluciones**:

1. **Esperar 15 minutos**:
   ```
   El sistema bloquea después de 5 intentos fallidos
   El bloqueo se levanta automáticamente después de 15 minutos
   ```

2. **Limpiar el bloqueo manualmente** (solo administradores de servidor):
   ```php
   // En wp-admin o mediante código
   delete_transient('mongruas_login_failures_' . md5($username));
   ```

3. **Verificar logs de seguridad**:
   ```
   1. Revisar logs de WordPress
   2. Verificar si hay intentos de login sospechosos
   3. Cambiar contraseña si es necesario
   ```

### Sesión expira muy rápido

**Síntomas**:
- Mensaje "Sesión expirada" después de pocos minutos
- Redirección constante al formulario de login

**Soluciones**:

1. **Verificar configuración de sesiones de WordPress**:
   ```php
   // En wp-config.php, verificar:
   define('WP_DEBUG', false); // No debe estar en true en producción
   ```

2. **Limpiar cookies corruptas**:
   ```
   1. Ir a configuración del navegador
   2. Buscar cookies del dominio
   3. Eliminar todas las cookies relacionadas
   ```

## Problemas de Guardado

### Los cambios no se guardan

**Síntomas**:
- Los cambios desaparecen al recargar
- No aparece mensaje de "Guardado exitoso"
- Error al intentar guardar

**Soluciones**:

1. **Verificar conexión a internet**:
   ```
   1. Intentar cargar otra página web
   2. Verificar velocidad de conexión
   3. Reiniciar router si es necesario
   ```

2. **Verificar permisos de escritura**:
   ```
   1. Contactar administrador del servidor
   2. Verificar permisos de archivos WordPress
   3. Verificar espacio disponible en disco
   ```

3. **Revisar logs de errores**:
   ```
   1. Ir a wp-admin > Herramientas > Salud del sitio
   2. Revisar la pestaña de información
   3. Buscar errores relacionados con base de datos
   ```

### Auto-guardado no funciona

**Síntomas**:
- No aparecen indicadores de auto-guardado
- Los cambios se pierden si se cierra accidentalmente

**Soluciones**:

1. **Verificar que JavaScript está funcionando**:
   ```
   1. Abrir Console en herramientas de desarrollador
   2. Escribir: console.log("test")
   3. Debe aparecer "test" en la consola
   ```

2. **Guardar manualmente con frecuencia**:
   ```
   Usar Ctrl+S o el botón de guardar cada pocos minutos
   ```

## Problemas de Imágenes

### No se pueden subir imágenes

**Síntomas**:
- Error al seleccionar o arrastrar imágenes
- Mensaje de error durante la subida
- La imagen no aparece después de subir

**Soluciones**:

1. **Verificar formato y tamaño de imagen**:
   ```
   Formatos soportados: JPG, PNG, WebP
   Tamaño máximo: 5MB
   Dimensiones mínimas recomendadas: 800x600px
   ```

2. **Verificar permisos de subida**:
   ```
   1. Intentar subir imagen en wp-admin > Medios
   2. Si falla ahí también, es problema de permisos del servidor
   3. Contactar administrador del servidor
   ```

3. **Optimizar imagen antes de subir**:
   ```
   1. Reducir tamaño de archivo usando herramientas online
   2. Convertir a JPG si está en formato no común
   3. Verificar que no está corrupta
   ```

### Las imágenes se ven pixeladas o distorsionadas

**Síntomas**:
- Imagen borrosa en la vista previa
- Imagen se ve estirada o comprimida
- Calidad muy baja

**Soluciones**:

1. **Usar imágenes de mayor resolución**:
   ```
   Mínimo recomendado: 800x600px
   Óptimo: 1200x900px o superior
   Mantener relación de aspecto 4:3 o 16:9
   ```

2. **Verificar formato de imagen**:
   ```
   JPG: Mejor para fotografías
   PNG: Mejor para gráficos con transparencia
   WebP: Mejor compresión, pero verificar compatibilidad
   ```

## Problemas de Vista Previa

### La vista previa no se actualiza

**Síntomas**:
- Los cambios en el formulario no se reflejan en la vista previa
- Vista previa muestra información antigua
- Vista previa está en blanco

**Soluciones**:

1. **Esperar unos segundos**:
   ```
   La vista previa tiene un retraso de 1-2 segundos para optimizar rendimiento
   ```

2. **Hacer clic fuera del campo editado**:
   ```
   Algunos cambios se aplican al perder el foco del campo
   ```

3. **Recargar el panel**:
   ```
   1. Cerrar el panel
   2. Abrir nuevamente
   3. Seleccionar el curso que estabas editando
   ```

### Vista previa muestra diseño incorrecto

**Síntomas**:
- El diseño no coincide con el sitio web real
- Faltan estilos o se ven incorrectos
- Elementos fuera de lugar

**Soluciones**:

1. **Verificar que los estilos del tema se cargan**:
   ```
   1. Abrir herramientas de desarrollador
   2. Ir a Network
   3. Verificar que los archivos CSS se cargan correctamente
   ```

2. **Limpiar caché del sitio**:
   ```
   Si usas plugins de caché, limpiar toda la caché
   ```

## Problemas de Rendimiento

### El panel carga muy lento

**Síntomas**:
- Demora excesiva al abrir el panel
- Respuesta lenta al hacer cambios
- Timeouts o errores de conexión

**Soluciones**:

1. **Verificar conexión a internet**:
   ```
   1. Hacer test de velocidad online
   2. Verificar que no hay descargas activas
   3. Cerrar otras pestañas pesadas
   ```

2. **Optimizar navegador**:
   ```
   1. Cerrar pestañas innecesarias
   2. Reiniciar navegador
   3. Actualizar navegador a última versión
   ```

3. **Verificar recursos del servidor**:
   ```
   1. Contactar administrador si el problema persiste
   2. Verificar uso de CPU y memoria del servidor
   ```

### El navegador se congela o crashea

**Síntomas**:
- Navegador deja de responder
- Mensaje "Página no responde"
- Cierre inesperado del navegador

**Soluciones**:

1. **Cerrar otras aplicaciones**:
   ```
   Liberar memoria RAM cerrando programas innecesarios
   ```

2. **Usar navegador diferente**:
   ```
   Probar con Chrome, Firefox, Safari o Edge
   ```

3. **Verificar extensiones del navegador**:
   ```
   1. Desactivar extensiones temporalmente
   2. Probar en modo incógnito
   ```

## Errores del Sistema

### Códigos de Error Comunes

| Código | Descripción | Causa | Solución |
|--------|-------------|-------|----------|
| AUTH_001 | Credenciales inválidas | Usuario/contraseña incorrectos | Verificar credenciales |
| AUTH_002 | Sesión expirada | Tiempo de sesión agotado | Iniciar sesión nuevamente |
| AUTH_003 | Demasiados intentos | Límite de intentos excedido | Esperar 15 minutos |
| AUTH_004 | Permisos insuficientes | Usuario no es administrador | Contactar administrador |
| SAVE_001 | Error al guardar | Problema de conexión/servidor | Verificar conexión |
| SAVE_002 | Datos inválidos | Validación falló | Revisar campos obligatorios |
| SAVE_003 | Timeout | Operación muy lenta | Reintentar |
| UPLOAD_001 | Archivo muy grande | Imagen > 5MB | Reducir tamaño |
| UPLOAD_002 | Formato no soportado | Formato de archivo inválido | Usar JPG/PNG/WebP |
| UPLOAD_003 | Error de servidor | Problema en servidor | Contactar soporte |
| PREVIEW_001 | Error de renderizado | Problema con vista previa | Recargar panel |
| NETWORK_001 | Sin conexión | Problema de red | Verificar internet |
| NETWORK_002 | Timeout | Respuesta muy lenta | Reintentar |

### Mensajes de Error Específicos

#### "Failed to fetch"
```
Causa: Problema de conexión de red
Solución: 
1. Verificar conexión a internet
2. Verificar que el servidor está funcionando
3. Reintentar en unos minutos
```

#### "Unexpected token < in JSON"
```
Causa: El servidor devolvió HTML en lugar de JSON (error 500/404)
Solución:
1. Verificar logs del servidor
2. Contactar administrador
3. Verificar configuración de WordPress
```

#### "CSRF token mismatch"
```
Causa: Token de seguridad inválido o expirado
Solución:
1. Recargar la página
2. Limpiar cookies
3. Iniciar sesión nuevamente
```

## Herramientas de Diagnóstico

### Verificación del Sistema

El tema incluye herramientas de diagnóstico integradas:

1. **Acceder a herramientas de diagnóstico**:
   ```
   URL: /wp-admin/admin.php?page=mongruas-diagnostics
   (Solo disponible para administradores)
   ```

2. **Ejecutar tests automáticos**:
   ```
   1. Ir a la página de diagnósticos
   2. Hacer clic en "Ejecutar Tests"
   3. Revisar resultados
   ```

### Tests Disponibles

- **Test de Conectividad**: Verifica conexión a APIs
- **Test de Permisos**: Verifica permisos de archivos
- **Test de Seguridad**: Verifica configuración de seguridad
- **Test de Rendimiento**: Mide tiempos de respuesta
- **Test de Integridad**: Verifica archivos del sistema

### Información del Sistema

Para reportar problemas, incluye la siguiente información:

```
1. Versión de WordPress: [versión]
2. Versión del tema: [versión]
3. Navegador y versión: [navegador]
4. Sistema operativo: [OS]
5. Plugins activos: [lista]
6. Mensaje de error exacto: [error]
7. Pasos para reproducir: [pasos]
```

### Logs del Sistema

Los logs se encuentran en:
```
/wp-content/debug.log (si WP_DEBUG_LOG está habilitado)
/logs/php/error.log (logs del servidor)
```

## Contacto de Soporte

### Antes de Contactar Soporte

1. **Intentar las soluciones de esta guía**
2. **Recopilar información del error**
3. **Tomar capturas de pantalla si es posible**
4. **Anotar pasos exactos para reproducir el problema**

### Información a Incluir

Cuando contactes soporte, incluye:

```
- Descripción detallada del problema
- Mensaje de error exacto (si hay)
- Qué estabas haciendo cuando ocurrió
- Navegador y versión
- Sistema operativo
- Capturas de pantalla
- Información del sistema (usar herramientas de diagnóstico)
```

### Canales de Soporte

1. **Administrador del sitio**: Primera línea de soporte
2. **Desarrollador del tema**: Para problemas técnicos complejos
3. **Soporte de WordPress**: Para problemas generales de WordPress

### Tiempo de Respuesta Esperado

- **Problemas críticos** (sitio caído): 2-4 horas
- **Problemas importantes** (funcionalidad rota): 24-48 horas
- **Problemas menores** (mejoras, preguntas): 3-5 días laborales

---

## Recursos Adicionales

### Documentación Relacionada
- [Guía del Usuario](USER-GUIDE.md)
- [Mejores Prácticas de Seguridad](SECURITY-BEST-PRACTICES.md)
- [Documentación de WordPress](https://wordpress.org/support/)

### Herramientas Útiles
- [Test de Velocidad de Internet](https://speedtest.net)
- [Validador de HTML](https://validator.w3.org)
- [Optimizador de Imágenes](https://tinypng.com)

### Actualizaciones
Este documento se actualiza regularmente. Verifica la fecha de última actualización para información más reciente.

**Última actualización**: Diciembre 2024
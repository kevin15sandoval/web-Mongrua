# Panel de Gestión de Cursos - Guía del Usuario

## Tabla de Contenidos

1. [Introducción](#introducción)
2. [Acceso al Panel](#acceso-al-panel)
3. [Gestión de Cursos](#gestión-de-cursos)
4. [Vista Previa en Tiempo Real](#vista-previa-en-tiempo-real)
5. [Subida de Imágenes](#subida-de-imágenes)
6. [Seguridad y Mejores Prácticas](#seguridad-y-mejores-prácticas)
7. [Solución de Problemas](#solución-de-problemas)
8. [Preguntas Frecuentes](#preguntas-frecuentes)

## Introducción

El Panel de Gestión de Cursos es una interfaz web amigable que permite a los administradores del sitio gestionar los próximos cursos de forma sencilla, sin necesidad de acceder al panel completo de WordPress. Esta herramienta proporciona una experiencia optimizada para la gestión de cursos con vista previa en tiempo real.

### Características Principales

- ✅ **Acceso Seguro**: Autenticación con credenciales de WordPress
- ✅ **Interfaz Intuitiva**: Diseño simple y fácil de usar
- ✅ **Vista Previa en Tiempo Real**: Ve cómo se verá el curso mientras lo editas
- ✅ **Gestión de Imágenes**: Subida y gestión de imágenes de cursos
- ✅ **Responsive**: Funciona en computadoras, tablets y móviles
- ✅ **Auto-guardado**: Previene la pérdida de datos
- ✅ **Validación en Tiempo Real**: Feedback inmediato sobre errores

## Acceso al Panel

### Paso 1: Localizar el Botón de Acceso

1. **Ubicación**: El botón de acceso se encuentra en la esquina inferior derecha del sitio web
2. **Visibilidad**: Solo es visible para usuarios administradores de WordPress
3. **Apariencia**: Botón flotante discreto con icono de configuración

![Botón de Acceso](screenshots/access-button.png)
*Nota: Las capturas de pantalla se agregarán en la siguiente fase de implementación*

### Paso 2: Iniciar Sesión

1. **Hacer clic** en el botón de acceso
2. **Introducir credenciales**:
   - Usuario: Tu nombre de usuario de WordPress
   - Contraseña: Tu contraseña de WordPress
3. **Hacer clic** en "Iniciar Sesión"

![Modal de Login](screenshots/login-modal.png)

### Medidas de Seguridad

- **Límite de intentos**: Máximo 5 intentos de login cada 15 minutos
- **Sesión segura**: Las sesiones expiran automáticamente por seguridad
- **Verificación de permisos**: Solo administradores pueden acceder

## Gestión de Cursos

### Interfaz Principal

Una vez autenticado, verás la interfaz principal dividida en tres secciones:

1. **Sidebar Izquierdo**: Lista de cursos existentes
2. **Panel Central**: Formulario de edición del curso seleccionado
3. **Panel Derecho**: Vista previa en tiempo real

![Interfaz Principal](screenshots/main-interface.png)

### Crear un Nuevo Curso

1. **Seleccionar slot vacío** en el sidebar izquierdo
2. **Completar los campos**:
   - **Nombre del Curso**: Título que aparecerá en el sitio
   - **Descripción**: Descripción detallada del curso
   - **Fecha**: Fecha de inicio del curso
   - **Duración**: Duración total del curso
   - **Modalidad**: Presencial, Online, o Mixta
   - **Categoría**: Categoría del curso
3. **Subir imagen** (opcional pero recomendado)
4. **Guardar** automáticamente o manualmente

### Editar un Curso Existente

1. **Hacer clic** en el curso que deseas editar en el sidebar
2. **Modificar** los campos necesarios
3. **Ver cambios** en la vista previa en tiempo real
4. **Confirmar** que los cambios se han guardado

### Eliminar un Curso

1. **Seleccionar** el curso a eliminar
2. **Hacer clic** en el botón "Eliminar Curso"
3. **Confirmar** la eliminación en el diálogo de confirmación

⚠️ **Advertencia**: La eliminación es permanente y no se puede deshacer.

### Reordenar Cursos

1. **Arrastrar y soltar** cursos en el sidebar para cambiar el orden
2. **El orden** se refleja automáticamente en el sitio web
3. **Guardar** los cambios automáticamente

## Vista Previa en Tiempo Real

### Funcionalidad

La vista previa muestra exactamente cómo se verá el curso en el sitio web:

- **Actualización inmediata**: Los cambios se reflejan al instante
- **Diferentes estados**: Con imagen, sin imagen, datos incompletos
- **Responsive**: Vista previa adaptada a diferentes tamaños de pantalla

### Estados de Vista Previa

1. **Curso Completo**: Todos los campos completados con imagen
2. **Sin Imagen**: Curso completo pero sin imagen subida
3. **Datos Incompletos**: Faltan campos obligatorios
4. **Curso Vacío**: Slot sin información

![Vista Previa Estados](screenshots/preview-states.png)

## Subida de Imágenes

### Proceso de Subida

1. **Hacer clic** en el área de subida de imagen
2. **Seleccionar archivo** desde tu computadora
3. **Arrastrar y soltar** archivo directamente al área
4. **Esperar** a que se complete la subida
5. **Ver** la imagen en la vista previa

### Requisitos de Imagen

- **Formatos soportados**: JPG, PNG, WebP
- **Tamaño máximo**: 5MB por imagen
- **Dimensiones recomendadas**: 800x600 píxeles mínimo
- **Relación de aspecto**: 4:3 o 16:9 recomendado

### Gestión de Imágenes

- **Reemplazar**: Subir nueva imagen para reemplazar la actual
- **Eliminar**: Botón para quitar la imagen del curso
- **Optimización**: Las imágenes se optimizan automáticamente

![Subida de Imágenes](screenshots/image-upload.png)

## Seguridad y Mejores Prácticas

### Prácticas de Seguridad

1. **Cerrar sesión**: Siempre cerrar sesión al terminar
2. **No compartir credenciales**: Mantener las credenciales privadas
3. **Usar contraseñas seguras**: Contraseñas complejas y únicas
4. **Actualizar regularmente**: Mantener WordPress actualizado

### Mejores Prácticas de Uso

1. **Guardar frecuentemente**: Aunque hay auto-guardado, guarda manualmente
2. **Revisar vista previa**: Siempre verificar cómo se ve antes de publicar
3. **Usar imágenes de calidad**: Imágenes profesionales mejoran la apariencia
4. **Completar todos los campos**: Información completa es más efectiva
5. **Probar en móvil**: Verificar que se ve bien en dispositivos móviles

### Backup y Recuperación

- **Auto-guardado**: Los cambios se guardan automáticamente cada 30 segundos
- **Advertencia de cambios**: El sistema avisa si hay cambios sin guardar
- **Recuperación**: Los datos se pueden recuperar desde WordPress admin si es necesario

## Solución de Problemas

### Problemas Comunes y Soluciones

#### No puedo acceder al panel

**Síntomas**: El botón de acceso no aparece o no puedo iniciar sesión

**Soluciones**:
1. Verificar que tienes permisos de administrador en WordPress
2. Limpiar caché del navegador
3. Verificar que JavaScript está habilitado
4. Contactar al administrador del sitio

#### Los cambios no se guardan

**Síntomas**: Los cambios desaparecen al recargar la página

**Soluciones**:
1. Verificar conexión a internet
2. Esperar a ver el mensaje de "Guardado exitoso"
3. No cerrar la ventana mientras se guarda
4. Verificar que la sesión no ha expirado

#### Las imágenes no se suben

**Síntomas**: Error al subir imágenes o imágenes que no aparecen

**Soluciones**:
1. Verificar que el archivo es JPG, PNG o WebP
2. Verificar que el archivo es menor a 5MB
3. Intentar con una imagen diferente
4. Verificar conexión a internet

#### La vista previa no se actualiza

**Síntomas**: Los cambios no se reflejan en la vista previa

**Soluciones**:
1. Esperar unos segundos (hay un pequeño retraso)
2. Hacer clic fuera del campo editado
3. Recargar el panel
4. Verificar que todos los campos están completos

#### Error de sesión expirada

**Síntomas**: Mensaje de "Sesión expirada" o redirección al login

**Soluciones**:
1. Iniciar sesión nuevamente
2. Los cambios recientes pueden haberse perdido
3. Verificar que las credenciales son correctas
4. Contactar soporte si el problema persiste

### Códigos de Error

| Código | Descripción | Solución |
|--------|-------------|----------|
| AUTH_001 | Credenciales inválidas | Verificar usuario y contraseña |
| AUTH_002 | Sesión expirada | Iniciar sesión nuevamente |
| AUTH_003 | Demasiados intentos | Esperar 15 minutos |
| SAVE_001 | Error al guardar | Verificar conexión y reintentar |
| UPLOAD_001 | Archivo muy grande | Usar imagen menor a 5MB |
| UPLOAD_002 | Formato no soportado | Usar JPG, PNG o WebP |

### Contacto de Soporte

Si los problemas persisten:

1. **Documentar el error**: Anotar qué estabas haciendo cuando ocurrió
2. **Captura de pantalla**: Si es posible, tomar captura del error
3. **Información del navegador**: Qué navegador y versión usas
4. **Contactar administrador**: Proporcionar toda la información recopilada

## Preguntas Frecuentes

### ¿Cuántos cursos puedo crear?

El sistema soporta hasta 3 cursos simultáneos. Esto es por diseño para mantener la página principal limpia y enfocada.

### ¿Puedo programar cursos para el futuro?

Sí, puedes introducir cualquier fecha futura en el campo de fecha. El curso aparecerá inmediatamente en el sitio con la fecha especificada.

### ¿Qué pasa si no subo una imagen?

El curso aparecerá sin imagen en el sitio web. Aunque es funcional, se recomienda siempre incluir una imagen para mejor presentación.

### ¿Los cambios aparecen inmediatamente en el sitio?

Sí, los cambios se reflejan inmediatamente en el sitio web una vez guardados exitosamente.

### ¿Puedo usar el panel desde mi móvil?

Sí, el panel está optimizado para dispositivos móviles y tablets, aunque la experiencia es mejor en computadoras.

### ¿Qué pasa si cierro el navegador sin guardar?

El sistema tiene auto-guardado cada 30 segundos, pero siempre es recomendable guardar manualmente antes de cerrar.

### ¿Puedo deshacer cambios?

Actualmente no hay función de deshacer. Se recomienda ser cuidadoso con los cambios y usar la vista previa para verificar.

### ¿El panel afecta el rendimiento del sitio?

No, el panel solo se carga para administradores y no afecta la velocidad del sitio para visitantes regulares.

### ¿Puedo personalizar los campos del curso?

Los campos están predefinidos según las necesidades del sitio. Para cambios en los campos, contacta al desarrollador.

### ¿Hay límite en el texto de descripción?

Sí, la descripción tiene un límite de 500 caracteres para mantener un diseño consistente en el sitio.

---

## Información Adicional

### Versión del Sistema
- **Versión actual**: 1.0.0
- **Última actualización**: Diciembre 2024
- **Compatibilidad**: WordPress 5.0+

### Soporte Técnico
Para soporte técnico adicional o reportar problemas, contacta al administrador del sitio con la siguiente información:
- Descripción detallada del problema
- Pasos para reproducir el error
- Capturas de pantalla si es aplicable
- Información del navegador y dispositivo

### Actualizaciones
Este documento se actualiza regularmente. Verifica la fecha de última actualización para asegurarte de tener la información más reciente.
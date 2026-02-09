# Requirements Document

## Introduction

El Panel de Gestión Integral es una interfaz web amigable que permite a los administradores del sitio gestionar próximos cursos y comunicaciones de forma sencilla sin necesidad de acceder al panel completo de WordPress. Proporciona una experiencia de usuario optimizada para la gestión de cursos y el envío de correos masivos a contactos.

## Glossary

- **Panel_de_Gestión**: Interfaz web personalizada para gestionar cursos y comunicaciones
- **Usuario_Administrador**: Usuario con permisos de WordPress para editar páginas
- **Curso_Próximo**: Curso que aparecerá en la sección "Próximos Cursos" del sitio web
- **Vista_Previa**: Representación visual de cómo se verá el curso en el frontend
- **Sesión_Segura**: Sesión autenticada usando credenciales de WordPress
- **Lista_de_Contactos**: Base de datos de usuarios que han enviado formularios de contacto
- **Correo_Masivo**: Email enviado simultáneamente a múltiples destinatarios de la lista de contactos
- **Newsletter**: Comunicación periódica enviada a los contactos sobre cursos y novedades

## Requirements

### Requirement 1

**User Story:** Como administradora del sitio, quiero acceder fácilmente a un panel de gestión de cursos, para poder agregar y editar próximos cursos sin navegar por el complejo admin de WordPress.

#### Acceptance Criteria

1. WHEN un usuario administrador visita el sitio web THEN el sistema SHALL mostrar un botón de acceso discreto al panel de gestión
2. WHEN un usuario hace clic en el botón de acceso THEN el sistema SHALL mostrar un formulario de login seguro
3. WHEN un usuario ingresa credenciales válidas de WordPress THEN el sistema SHALL autenticar al usuario y mostrar el panel de gestión
4. WHEN un usuario no autorizado intenta acceder THEN el sistema SHALL denegar el acceso y mostrar un mensaje de error
5. WHERE el usuario tiene permisos de administrador, el sistema SHALL permitir el acceso completo al panel

### Requirement 2

**User Story:** Como administradora del sitio, quiero una interfaz simple para agregar cursos, para poder crear nuevos próximos cursos de forma rápida e intuitiva.

#### Acceptance Criteria

1. WHEN un administrador accede al panel THEN el sistema SHALL mostrar un formulario claro para agregar cursos
2. WHEN un administrador completa los campos del curso THEN el sistema SHALL validar la información ingresada
3. WHEN un administrador guarda un curso THEN el sistema SHALL almacenar la información en los campos ACF correspondientes
4. WHEN un administrador sube una imagen THEN el sistema SHALL procesar y guardar la imagen correctamente
5. WHEN se guarda un curso THEN el sistema SHALL mostrar una confirmación de éxito

### Requirement 3

**User Story:** Como administradora del sitio, quiero ver una vista previa de los cursos, para poder verificar cómo se verán en el sitio web antes de publicarlos.

#### Acceptance Criteria

1. WHEN un administrador ingresa información de un curso THEN el sistema SHALL mostrar una vista previa en tiempo real
2. WHEN se modifica cualquier campo del curso THEN el sistema SHALL actualizar la vista previa inmediatamente
3. WHEN se sube una imagen THEN el sistema SHALL mostrar la imagen en la vista previa
4. WHEN un curso está completo THEN el sistema SHALL mostrar exactamente cómo aparecerá en el frontend
5. WHERE no hay imagen subida, el sistema SHALL mostrar la vista previa sin imagen

### Requirement 4

**User Story:** Como administradora del sitio, quiero gestionar múltiples cursos fácilmente, para poder mantener actualizada la sección de próximos cursos.

#### Acceptance Criteria

1. WHEN un administrador accede al panel THEN el sistema SHALL mostrar todos los cursos próximos existentes
2. WHEN un administrador selecciona un curso existente THEN el sistema SHALL cargar los datos para edición
3. WHEN un administrador elimina un curso THEN el sistema SHALL remover el curso y actualizar la vista
4. WHEN hay múltiples cursos THEN el sistema SHALL permitir reordenar la secuencia de visualización
5. WHERE un curso no tiene nombre, el sistema SHALL indicar que no se mostrará en el frontend

### Requirement 5

**User Story:** Como administradora del sitio, quiero enviar correos masivos a mis contactos, para poder comunicar información sobre nuevos cursos y novedades de forma eficiente.

#### Acceptance Criteria

1. WHEN un administrador accede a la sección de correos THEN el sistema SHALL mostrar la lista de contactos disponibles
2. WHEN un administrador crea un correo masivo THEN el sistema SHALL proporcionar un editor de texto enriquecido
3. WHEN un administrador envía un correo masivo THEN el sistema SHALL entregar el correo a todos los contactos seleccionados
4. WHEN se envía un correo THEN el sistema SHALL registrar la fecha y hora del envío para seguimiento
5. WHERE hay contactos inválidos, el sistema SHALL omitir esos contactos y reportar los errores

### Requirement 6

**User Story:** Como administradora del sitio, quiero gestionar mi lista de contactos, para poder mantener actualizada la base de datos de personas interesadas en los cursos.

#### Acceptance Criteria

1. WHEN un administrador accede a la gestión de contactos THEN el sistema SHALL mostrar todos los contactos registrados
2. WHEN se recibe un nuevo formulario de contacto THEN el sistema SHALL agregar automáticamente el contacto a la lista
3. WHEN un administrador edita un contacto THEN el sistema SHALL actualizar la información correctamente
4. WHEN un administrador elimina un contacto THEN el sistema SHALL remover el contacto de la lista permanentemente
5. WHERE un contacto solicita ser removido, el sistema SHALL permitir la eliminación con confirmación

### Requirement 7

**User Story:** Como administradora del sitio, quiero ver estadísticas de mis comunicaciones, para poder evaluar la efectividad de mis campañas de correo y gestión de cursos.

#### Acceptance Criteria

1. WHEN un administrador accede al dashboard THEN el sistema SHALL mostrar estadísticas de contactos totales
2. WHEN se han enviado correos masivos THEN el sistema SHALL mostrar el historial de envíos
3. WHEN hay cursos próximos activos THEN el sistema SHALL mostrar cuántos cursos están publicados
4. WHEN se visualizan estadísticas THEN el sistema SHALL mostrar datos actualizados en tiempo real
5. WHERE no hay datos disponibles, el sistema SHALL mostrar mensajes informativos apropiados

### Requirement 8

**User Story:** Como administradora del sitio, quiero que el panel sea seguro y confiable, para poder gestionar los cursos y comunicaciones sin preocuparme por la seguridad o pérdida de datos.

#### Acceptance Criteria

1. WHEN un usuario intenta acceder sin autenticación THEN el sistema SHALL redirigir al formulario de login
2. WHEN una sesión expira THEN el sistema SHALL requerir nueva autenticación antes de permitir cambios
3. WHEN se guardan datos THEN el sistema SHALL verificar la integridad de la información antes del almacenamiento
4. WHEN ocurre un error THEN el sistema SHALL mostrar mensajes claros y mantener los datos ingresados
5. WHERE hay cambios sin guardar, el sistema SHALL advertir al usuario antes de salir del panel
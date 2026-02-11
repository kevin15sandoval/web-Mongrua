# Documento de Requisitos

## Introducción

Este documento especifica los requisitos para una Progressive Web App (PWA) que gestiona la inscripción en cursos, certificación y emisión de credenciales digitales. El sistema permite a los administradores publicar cursos, a los estudiantes inscribirse y completarlos, y genera automáticamente certificados digitales al aprobar los cursos. La PWA funciona en navegadores web de escritorio y móvil, y puede instalarse como aplicación en dispositivos.

## Glosario

- **PWA (Progressive Web App)**: Aplicación web progresiva que funciona en navegadores y puede instalarse en dispositivos móviles y escritorio
- **Aplicación Web**: La interfaz web responsive que funciona en cualquier navegador moderno
- **Usuario**: Cualquier persona que se ha registrado en el sistema
- **Estudiante**: Un usuario con rol de estudiante que puede inscribirse en cursos
- **Administrador**: Un usuario con privilegios administrativos que gestiona cursos y aprueba finalizaciones
- **Curso**: Un programa educativo en el que los estudiantes pueden inscribirse y completar
- **Carnet Digital**: Una credencial digital verificable emitida al completar un curso que incluye datos del estudiante y número de carnet único
- **Número de Carnet**: Identificador único secuencial asignado a cada certificado en formato CERT-YYYYMMDD-XXXXX
- **Inscripción**: El acto de un estudiante registrándose en un curso específico
- **Finalización de Curso**: Cuando un estudiante completa todos los requisitos de un curso
- **Aprobación**: Acción administrativa para certificar que un estudiante ha completado exitosamente un curso
- **Notificación**: Un mensaje dentro de la aplicación web enviado a los usuarios
- **Curso Activo**: Un curso en el que un estudiante está actualmente inscrito pero aún no ha completado
- **Service Worker**: Script que permite funcionalidad offline y caché en la PWA
- **Manifest**: Archivo que permite instalar la PWA como aplicación en dispositivos

## Requisitos

### Requisito 1

**Historia de Usuario:** Como nuevo usuario, quiero registrarme en la aplicación web, para poder acceder al sistema de gestión de cursos.

#### Criterios de Aceptación

1. CUANDO un usuario proporciona información de registro válida ENTONCES la PWA DEBERÁ crear una nueva cuenta de usuario
2. CUANDO un usuario se registra ENTONCES la PWA DEBERÁ solicitar nombre completo, correo electrónico, fecha de nacimiento, contraseña y confirmación de contraseña
3. CUANDO un usuario proporciona una dirección de correo electrónico ENTONCES la PWA DEBERÁ validar el formato del correo antes de crear la cuenta
4. CUANDO un usuario proporciona una fecha de nacimiento ENTONCES la PWA DEBERÁ validar que el usuario tenga al menos 16 años de edad
5. CUANDO un usuario proporciona una contraseña ENTONCES la PWA DEBERÁ aplicar requisitos mínimos de seguridad (mínimo 8 caracteres, al menos una mayúscula, una minúscula, un número)
6. CUANDO un usuario completa el registro ENTONCES la PWA DEBERÁ enviar un correo de verificación para confirmar la cuenta
7. CUANDO un usuario intenta registrarse con un correo existente ENTONCES la PWA DEBERÁ prevenir la creación de cuenta duplicada y mostrar un mensaje de error

### Requisito 2

**Historia de Usuario:** Como usuario registrado, quiero iniciar sesión en la aplicación, para poder acceder a mi contenido y funciones personalizadas.

#### Criterios de Aceptación

1. CUANDO un usuario proporciona credenciales válidas ENTONCES la Aplicación Móvil DEBERÁ autenticar al usuario y otorgar acceso
2. CUANDO un usuario proporciona credenciales inválidas ENTONCES la Aplicación Móvil DEBERÁ denegar el acceso y mostrar un mensaje de error
3. CUANDO un usuario se autentica exitosamente ENTONCES la Aplicación Móvil DEBERÁ crear un token de sesión seguro
4. CUANDO una sesión de usuario expira ENTONCES la Aplicación Móvil DEBERÁ requerir re-autenticación
5. CUANDO un usuario solicita recuperación de contraseña ENTONCES la Aplicación Móvil DEBERÁ enviar un enlace de restablecimiento al correo registrado

### Requisito 3

**Historia de Usuario:** Como administrador, quiero asignar roles a los usuarios, para poder controlar los permisos de acceso dentro del sistema.

#### Criterios de Aceptación

1. CUANDO un administrador asigna un rol a un usuario ENTONCES la Aplicación Móvil DEBERÁ actualizar los permisos del usuario en consecuencia
2. CUANDO a un usuario se le asigna el rol de estudiante ENTONCES la Aplicación Móvil DEBERÁ habilitar las funciones de inscripción en cursos para ese usuario
3. CUANDO a un usuario se le asigna el rol de administrador ENTONCES la Aplicación Móvil DEBERÁ habilitar las funciones de gestión de cursos y aprobación para ese usuario
4. CUANDO un administrador cambia el rol de un usuario ENTONCES la Aplicación Móvil DEBERÁ aplicar inmediatamente los nuevos permisos
5. CUANDO un usuario sin privilegios de administrador intenta asignar roles ENTONCES la Aplicación Móvil DEBERÁ denegar la acción
6. CUANDO un nuevo usuario se registra ENTONCES la Aplicación Móvil DEBERÁ asignar automáticamente el rol de estudiante por defecto

### Requisito 3.1

**Historia de Usuario:** Como primer usuario del sistema, quiero poder configurar una cuenta de administrador inicial, para poder comenzar a gestionar la plataforma.

#### Criterios de Aceptación

1. CUANDO la base de datos no tiene ningún usuario administrador ENTONCES la Aplicación Móvil DEBERÁ mostrar una pantalla de configuración inicial al primer usuario registrado
2. CUANDO se accede a la configuración inicial ENTONCES la Aplicación Móvil DEBERÁ solicitar un código de activación de administrador predefinido
3. CUANDO el código de activación es correcto ENTONCES la Aplicación Móvil DEBERÁ otorgar privilegios de administrador al primer usuario
4. CUANDO el código de activación es incorrecto ENTONCES la Aplicación Móvil DEBERÁ asignar el rol de estudiante y denegar acceso administrativo
5. CUANDO ya existe al menos un administrador en el sistema ENTONCES la Aplicación Móvil DEBERÁ deshabilitar la configuración inicial y requerir que los nuevos administradores sean creados por administradores existentes

### Requisito 4

**Historia de Usuario:** Como administrador, quiero crear y publicar cursos, para que los estudiantes puedan descubrir e inscribirse en programas educativos.

#### Criterios de Aceptación

1. CUANDO un administrador crea un curso ENTONCES la Aplicación Móvil DEBERÁ almacenar la información del curso en la base de datos
2. CUANDO un administrador publica un curso ENTONCES la Aplicación Móvil DEBERÁ hacer el curso visible para todos los estudiantes
3. CUANDO un curso es publicado ENTONCES la Aplicación Móvil DEBERÁ incluir título del curso, descripción, duración y requisitos
4. CUANDO un administrador actualiza información del curso ENTONCES la Aplicación Móvil DEBERÁ reflejar los cambios inmediatamente a todos los usuarios
5. CUANDO un administrador elimina un curso ENTONCES la Aplicación Móvil DEBERÁ removerlo del catálogo mientras preserva el historial de inscripciones

### Requisito 5

**Historia de Usuario:** Como estudiante, quiero recibir notificaciones cuando se publiquen nuevos cursos, para mantenerme informado sobre oportunidades de aprendizaje.

#### Criterios de Aceptación

1. CUANDO un administrador publica un nuevo curso ENTONCES la Aplicación Móvil DEBERÁ enviar notificaciones push a todos los usuarios con rol de estudiante
2. CUANDO un estudiante tiene las notificaciones deshabilitadas ENTONCES la Aplicación Móvil DEBERÁ almacenar la notificación para visualización dentro de la app
3. CUANDO un estudiante abre una notificación de curso ENTONCES la Aplicación Móvil DEBERÁ navegar directamente a la página de detalles del curso
4. CUANDO múltiples cursos son publicados simultáneamente ENTONCES la Aplicación Móvil DEBERÁ enviar notificaciones individuales para cada curso
5. CUANDO un estudiante visualiza una notificación ENTONCES la Aplicación Móvil DEBERÁ marcarla como leída

### Requisito 6

**Historia de Usuario:** Como estudiante, quiero inscribirme en cursos disponibles, para poder comenzar mi proceso de aprendizaje.

#### Criterios de Aceptación

1. CUANDO un estudiante selecciona un curso y confirma la inscripción ENTONCES la Aplicación Móvil DEBERÁ registrar al estudiante en ese curso
2. CUANDO un estudiante se inscribe en un curso ENTONCES la Aplicación Móvil DEBERÁ agregar el curso a la lista de cursos activos del estudiante
3. CUANDO un estudiante intenta inscribirse en un curso en el que ya está inscrito ENTONCES la Aplicación Móvil DEBERÁ prevenir la inscripción duplicada
4. CUANDO un estudiante se inscribe en un curso ENTONCES la Aplicación Móvil DEBERÁ registrar la marca de tiempo de inscripción
5. CUANDO un estudiante visualiza sus cursos activos ENTONCES la Aplicación Móvil DEBERÁ mostrar todos los cursos en los que está actualmente inscrito

### Requisito 7

**Historia de Usuario:** Como estudiante, quiero marcar un curso como completado, para que los administradores puedan revisar y aprobar mi certificación.

#### Criterios de Aceptación

1. CUANDO un estudiante marca un curso como completado ENTONCES la Aplicación Móvil DEBERÁ actualizar el estado del curso a pendiente de aprobación
2. CUANDO un estudiante completa un curso ENTONCES la Aplicación Móvil DEBERÁ enviar una notificación a los administradores
3. CUANDO un curso es marcado como completo ENTONCES la Aplicación Móvil DEBERÁ registrar la marca de tiempo de finalización
4. CUANDO un estudiante intenta marcar como completo un curso en el que no está inscrito ENTONCES la Aplicación Móvil DEBERÁ prevenir la acción
5. CUANDO un curso está pendiente de aprobación ENTONCES la Aplicación Móvil DEBERÁ mostrar el estado pendiente al estudiante

### Requisito 8

**Historia de Usuario:** Como administrador, quiero revisar y aprobar las finalizaciones de cursos de los estudiantes, para poder certificar sus logros.

#### Criterios de Aceptación

1. CUANDO un administrador aprueba una finalización de curso ENTONCES la Aplicación Móvil DEBERÁ actualizar el estado del curso a aprobado
2. CUANDO un administrador rechaza una finalización de curso ENTONCES la Aplicación Móvil DEBERÁ devolver el curso al estado activo
3. CUANDO un administrador aprueba una finalización ENTONCES la Aplicación Móvil DEBERÁ activar la generación del carnet digital
4. CUANDO un administrador toma una acción de aprobación ENTONCES la Aplicación Móvil DEBERÁ enviar una notificación al estudiante
5. CUANDO un administrador visualiza aprobaciones pendientes ENTONCES la Aplicación Móvil DEBERÁ mostrar todos los cursos en espera de certificación

### Requisito 9

**Historia de Usuario:** Como estudiante, quiero recibir un carnet digital cuando complete un curso, para tener prueba verificable de mi logro.

#### Criterios de Aceptación

1. CUANDO un administrador aprueba una finalización de curso ENTONCES la Aplicación Móvil DEBERÁ generar un carnet digital único
2. CUANDO un carnet digital es generado ENTONCES la Aplicación Móvil DEBERÁ incluir nombre completo del estudiante, fecha de nacimiento, nombre del curso, fecha de finalización, número de carnet único e ID único del certificado
3. CUANDO un carnet es creado ENTONCES la Aplicación Móvil DEBERÁ generar un número de carnet secuencial único en formato "CERT-YYYYMMDD-XXXXX" donde YYYYMMDD es la fecha y XXXXX es un número secuencial
4. CUANDO un carnet es creado ENTONCES la Aplicación Móvil DEBERÁ almacenarlo de forma segura en la colección de carnets del estudiante
5. CUANDO un estudiante visualiza sus carnets ENTONCES la Aplicación Móvil DEBERÁ mostrar todos los carnets obtenidos con detalles completos del curso
6. CUANDO un carnet es generado ENTONCES la Aplicación Móvil DEBERÁ asegurar que el número de carnet y el ID del certificado sean globalmente únicos y verificables

### Requisito 10

**Historia de Usuario:** Como estudiante, quiero ver todos mis carnets digitales en un solo lugar, para poder acceder y compartir fácilmente mis credenciales.

#### Criterios de Aceptación

1. CUANDO un estudiante accede a la sección de carnets ENTONCES la Aplicación Móvil DEBERÁ mostrar todos los certificados aprobados
2. CUANDO un estudiante selecciona un carnet ENTONCES la Aplicación Móvil DEBERÁ mostrar los detalles completos del certificado
3. CUANDO un estudiante quiere compartir un carnet ENTONCES la Aplicación Móvil DEBERÁ proporcionar opciones de exportación (PDF, imagen o enlace compartible)
4. CUANDO los carnets son mostrados ENTONCES la Aplicación Móvil DEBERÁ organizarlos por fecha de finalización
5. CUANDO un estudiante no tiene carnets ENTONCES la Aplicación Móvil DEBERÁ mostrar un mensaje de estado vacío apropiado

### Requisito 11

**Historia de Usuario:** Como estudiante, quiero ver mis cursos actualmente activos, para poder rastrear mi progreso de aprendizaje continuo.

#### Criterios de Aceptación

1. CUANDO un estudiante accede a la sección de cursos activos ENTONCES la Aplicación Móvil DEBERÁ mostrar todos los cursos inscritos no completados aún
2. CUANDO se muestran cursos activos ENTONCES la Aplicación Móvil DEBERÁ mostrar nombre del curso, fecha de inscripción y estado actual
3. CUANDO un estudiante selecciona un curso activo ENTONCES la Aplicación Móvil DEBERÁ navegar a la página de detalles del curso
4. CUANDO un curso es completado o aprobado ENTONCES la Aplicación Móvil DEBERÁ removerlo de la lista de cursos activos
5. CUANDO un estudiante no tiene cursos activos ENTONCES la Aplicación Móvil DEBERÁ mostrar un estado vacío apropiado con llamado a la acción para explorar cursos disponibles

### Requisito 12

**Historia de Usuario:** Como usuario, quiero que la aplicación funcione sin conexión para ver mis carnets e información de cursos, para poder acceder a mis datos sin conectividad a internet.

#### Criterios de Aceptación

1. CUANDO un usuario pierde conectividad a internet ENTONCES la PWA DEBERÁ permitir la visualización de carnets previamente cargados mediante Service Worker
2. CUANDO un usuario está sin conexión ENTONCES la PWA DEBERÁ permitir la visualización de información de cursos previamente cargada desde la caché
3. CUANDO un usuario intenta realizar una acción que requiere conectividad mientras está sin conexión ENTONCES la PWA DEBERÁ mostrar un mensaje apropiado de sin conexión
4. CUANDO la conectividad es restaurada ENTONCES la PWA DEBERÁ sincronizar cualquier cambio de datos pendiente automáticamente
5. CUANDO datos sin conexión son mostrados ENTONCES la PWA DEBERÁ indicar al usuario que la información puede no estar actualizada

### Requisito 13

**Historia de Usuario:** Como administrador, quiero ver analíticas sobre inscripciones y finalizaciones de cursos, para poder medir la efectividad del programa.

#### Criterios de Aceptación

1. CUANDO un administrador accede al panel de analíticas ENTONCES la Aplicación Móvil DEBERÁ mostrar estadísticas de inscripción para todos los cursos
2. CUANDO se visualizan analíticas ENTONCES la Aplicación Móvil DEBERÁ mostrar tasas de finalización para cada curso
3. CUANDO un administrador selecciona un curso específico ENTONCES la Aplicación Móvil DEBERÁ mostrar datos detallados de inscripción y finalización
4. CUANDO se muestran analíticas ENTONCES la Aplicación Móvil DEBERÁ incluir gráficos y tablas visuales para fácil interpretación
5. CUANDO se solicitan datos de analíticas ENTONCES la Aplicación Móvil DEBERÁ calcular métricas en tiempo real desde el estado actual de la base de datos


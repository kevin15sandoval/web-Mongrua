# Plan de Implementación - PWA de Certificación de Cursos

## Visión General

Este plan de implementación desglosa el desarrollo de la Progressive Web App (PWA) en tareas incrementales y manejables. Cada tarea construye sobre las anteriores, asegurando progreso continuo hacia un sistema funcional completo que funciona en navegadores de escritorio y móvil.

## Tareas de Implementación

- [x] 1. Configurar estructura del proyecto PWA y dependencias base






  - Inicializar proyecto con Vite + React (o Vue)
  - Configurar estructura de carpetas (pages, components, services, utils, hooks)
  - Instalar dependencias principales (React Router, Axios, Zustand/Redux)
  - Configurar ESLint/Prettier
  - Configurar variables de entorno para desarrollo y producción
  - Crear manifest.json para PWA
  - Configurar Service Worker básico con Workbox
  - _Requisitos: Todos_



- [x] 2. Implementar backend API base y base de datos (YA IMPLEMENTADO)






  - Backend Node.js/Express ya configurado ✅
  - Conexión a PostgreSQL (Neon) ya configurada ✅
  - Esquema de base de datos ya creado ✅
  - Migraciones de base de datos ya implementadas ✅
  - CORS y middleware básico ya configurados ✅
  - _Requisitos: Todos_
  - _Nota: El backend ya está funcionando, solo necesita conectarse desde la PWA_

- [-] 3. Implementar módulo de autenticación en la PWA



- [x] 3.1 Crear modelos y utilidades de autenticación web



  - Implementar interfaces TypeScript: User, AuthCredentials, RegistrationData, AuthToken
  - Crear enum UserRole
  - Implementar validadores de email, password y fecha de nacimiento
  - Crear servicio API para autenticación con axios
  - Configurar interceptores para tokens JWT
  - Implementar almacenamiento de tokens en LocalStorage
  - _Requisitos: 1.1, 1.2, 1.3, 1.4, 1.5_

- [ ]* 3.2 Escribir property test para validación de registro
  - **Property 1: Validación de registro de usuario**
  - **Valida: Requisitos 1.1, 1.3, 1.4, 1.5, 3.6**

- [x] 3.3 Implementar endpoint de registro de usuario

  - Crear POST /api/auth/register
  - Validar datos de entrada (email, password, edad mínima)
  - Hash de contraseña con bcrypt
  - Asignar rol de estudiante por defecto
  - Generar token de verificación de email
  - _Requisitos: 1.1, 1.2, 1.3, 1.4, 1.5, 3.6_

- [ ]* 3.4 Escribir property test para unicidad de emails
  - **Property 2: Unicidad de correos electrónicos**
  - **Valida: Requisitos 1.7**

- [x] 3.5 Implementar servicio de envío de emails
  - Configurar servicio de email (Nodemailer con SMTP)
  - Crear plantilla de email de verificación
  - Implementar función de envío de email de verificación
  - Crear plantilla de email de recuperación de contraseña
  - Crear plantilla de email de bienvenida
  - _Requisitos: 1.6_

- [ ]* 3.6 Escribir property test para envío de correos de verificación
  - **Property 5: Envío de correos de verificación**
  - **Valida: Requisitos 1.6**

- [x] 3.7 Implementar endpoint de verificación de email
  - Crear GET /api/auth/verify/:token
  - Validar token de verificación
  - Actualizar campo email_verified en base de datos
  - Enviar email de bienvenida tras verificación
  - _Requisitos: 1.6_

- [x] 3.8 Implementar endpoint de login

  - Crear POST /api/auth/login
  - Validar credenciales contra base de datos
  - Generar JWT access token y refresh token
  - Retornar tokens y datos de usuario
  - _Requisitos: 2.1, 2.2, 2.3_

- [ ]* 3.9 Escribir property test para generación de tokens
  - **Property 3: Generación de tokens de autenticación**
  - **Valida: Requisitos 2.1, 2.3**

- [x] 3.10 Implementar middleware de autenticación JWT


  - Crear middleware para validar JWT en requests protegidos
  - Verificar expiración de tokens
  - Extraer información de usuario del token
  - _Requisitos: 2.4_

- [ ]* 3.11 Escribir property test para expiración de sesiones
  - **Property 4: Expiración de sesiones**
  - **Valida: Requisitos 2.4**

- [x] 3.12 Implementar recuperación de contraseña
  - Crear POST /api/auth/forgot-password
  - Generar token de recuperación
  - Enviar email con enlace de restablecimiento
  - Crear POST /api/auth/reset-password
  - Crear tabla password_reset_tokens
  - Crear POST /api/auth/resend-verification
  - Crear pantalla PasswordRecoveryScreen en app móvil
  - _Requisitos: 2.5_

- [ ]* 3.13 Escribir property test para envío de enlaces de recuperación
  - **Property 6: Envío de enlaces de recuperación**
  - **Valida: Requisitos 2.5**

- [ ] 3.14 Crear páginas de autenticación en la PWA

  - Implementar RegistrationPage con formulario responsive
  - Implementar LoginPage con diseño mobile-first
  - Implementar PasswordRecoveryPage
  - Configurar React Router para navegación
  - Conectar con endpoints del backend vía axios
  - Implementar validación de formularios en cliente
  - Agregar estados de carga y mensajes de error
  - _Requisitos: 1.1, 1.2, 1.3, 1.4, 1.5, 2.1, 2.2, 2.5_

- [ ]* 3.15 Escribir unit tests para páginas de autenticación
  - Test de validación de formulario de registro
  - Test de validación de formulario de login
  - Test de manejo de errores de autenticación
  - Test de navegación entre páginas
  - _Requisitos: 1.1, 2.1, 2.2_

- [ ] 4. Implementar sistema de roles y permisos en la PWA

- [ ] 4.1 Crear componentes de protección de rutas

  - Implementar ProtectedRoute component para rutas autenticadas
  - Implementar AdminRoute component para rutas de administrador
  - Configurar redirecciones según rol de usuario
  - Implementar hook useAuth para acceso a estado de autenticación
  - _Requisitos: 3.1, 3.5_


- [ ] 4.2 Implementar UI de gestión de roles (admin)

  - Crear página UserManagementPage para administradores
  - Mostrar lista de usuarios con sus roles
  - Implementar selector de roles con confirmación
  - Conectar con endpoint PUT /api/users/:id/role (ya implementado en backend)
  - Agregar feedback visual de éxito/error
  - _Requisitos: 3.1, 3.2, 3.3, 3.4_

- [ ]* 4.3 Escribir property test para actualización de permisos
  - **Property 7: Actualización de permisos por rol**
  - **Valida: Requisitos 3.1, 3.4**


- [ ] 4.4 Implementar página de configuración inicial

  - Crear InitialAdminSetupPage
  - Mostrar solo si no hay administradores (verificar con backend)
  - Solicitar código de activación con validación
  - Conectar con endpoint POST /api/auth/setup-admin (ya implementado)
  - Manejar respuesta de éxito/error con feedback visual
  - Redirigir a dashboard tras configuración exitosa
  - _Requisitos: 3.1.1, 3.1.3, 3.1.4, 3.1.5_

- [ ]* 4.5 Escribir property test para configuración inicial
  - **Property 8: Configuración inicial de administrador**
  - **Valida: Requisitos 3.1.5**

- [ ] 4.6 Crear flujo de configuración inicial en la PWA

  - Implementar verificación automática al cargar la app
  - Mostrar InitialAdminSetupPage si no hay administradores
  - Implementar formulario de código de activación
  - Manejar respuesta de éxito/error
  - Actualizar estado de autenticación tras configuración
  - _Requisitos: 3.1.1, 3.1.2, 3.1.3, 3.1.4_

- [ ] 5. Implementar módulo de gestión de cursos en la PWA

- [ ] 5.1 Crear modelos y servicios de cursos
  - Implementar interfaces Course, CourseEnrollment (TypeScript)
  - Crear enums CourseStatus, EnrollmentStatus
  - Implementar validadores de datos de curso
  - Crear servicio course.service.ts con métodos CRUD
  - Configurar caché de cursos en IndexedDB
  - _Requisitos: 4.1, 4.2, 4.3_

- [ ] 5.2 Implementar UI de gestión de cursos (admin)
  - Crear CourseManagementPage con tabla de cursos
  - Implementar CourseCreationPage con formulario completo
  - Agregar botones de editar/eliminar/publicar
  - Conectar con endpoints del backend (ya implementados)
  - Implementar confirmaciones para acciones destructivas
  - _Requisitos: 4.1, 4.3, 4.4, 4.5_

- [ ]* 5.3 Escribir property test para persistencia de cursos
  - **Property 9: Persistencia de cursos**
  - **Valida: Requisitos 4.1, 4.3**

- [ ] 5.4 Implementar UI de publicación de cursos
  - Agregar botón "Publicar" en CourseManagementPage
  - Implementar modal de confirmación de publicación
  - Conectar con endpoint PUT /api/courses/:id/publish (ya implementado)
  - Mostrar feedback de éxito con notificación
  - Actualizar lista de cursos tras publicación
  - _Requisitos: 4.2_

- [ ]* 5.5 Escribir property test para visibilidad de cursos
  - **Property 10: Visibilidad de cursos publicados**
  - **Valida: Requisitos 4.2**

- [ ]* 5.6 Escribir property test para actualización inmediata
  - **Property 11: Actualización inmediata de cursos**
  - **Valida: Requisitos 4.4**

- [ ]* 5.7 Escribir property test para preservación de historial
  - **Property 12: Preservación de historial al eliminar**
  - **Valida: Requisitos 4.5**

- [ ] 5.8 Crear páginas de cursos para estudiantes
  - Implementar CourseListPage con grid responsive de cursos
  - Implementar CourseDetailPage con información completa
  - Agregar filtros por estado (publicado, activo, completado)
  - Implementar búsqueda de cursos
  - Agregar botón de inscripción en CourseDetailPage
  - Mostrar estado de inscripción si ya está inscrito
  - _Requisitos: 4.1, 4.2, 4.3, 4.4, 4.5_

- [ ]* 5.9 Escribir unit tests para páginas de cursos
  - Test de listado de cursos con datos mock
  - Test de creación de curso (admin)
  - Test de actualización de curso (admin)
  - Test de filtros y búsqueda
  - _Requisitos: 4.1, 4.2, 4.4_




- [ ] 6. Implementar sistema de notificaciones in-app

- [ ] 6.1 Crear componentes de notificaciones

  - Implementar NotificationCenter component (dropdown o panel lateral)
  - Implementar NotificationItem component con iconos por tipo
  - Implementar NotificationBadge component con contador
  - Agregar NotificationCenter al layout principal
  - Implementar marcado de leídas al hacer click
  - _Requisitos: 5.1, 5.2, 5.3, 5.4, 5.5_

- [ ] 6.2 Crear modelos y servicios de notificaciones
  - Implementar interface Notification (TypeScript)
  - Crear enum NotificationType
  - Crear notification.service.ts para API calls
  - Implementar polling o WebSocket para notificaciones en tiempo real
  - Configurar caché de notificaciones en IndexedDB
  - _Requisitos: 5.1, 5.2, 5.3, 5.4, 5.5_

- [ ] 6.3 Implementar lógica de notificaciones en backend

  - El backend ya crea notificaciones en base de datos ✅
  - Verificar endpoints GET /api/notifications (ya implementado)
  - Verificar endpoint PUT /api/notifications/:id/read (ya implementado)
  - Considerar implementar WebSocket para notificaciones en tiempo real (opcional)
  - _Requisitos: 5.1, 5.4_

- [ ] 6.4 Implementar notificaciones al publicar curso
  - El backend ya envía notificaciones al publicar curso ✅
  - Verificar que la PWA recibe y muestra las notificaciones
  - Implementar actualización automática del badge de notificaciones
  - _Requisitos: 5.1, 5.2, 5.4_

- [ ]* 6.5 Escribir property test para notificaciones de nuevos cursos

  - **Property 13: Notificaciones de nuevos cursos (in-app)**
  - **Valida: Requisitos 5.1**
  - Verificar que se crean notificaciones en base de datos para todos los estudiantes

- [ ]* 6.6 Escribir property test para notificaciones individuales
  - **Property 14: Notificaciones individuales múltiples**
  - **Valida: Requisitos 5.4**

- [ ] 6.7 Implementar UI de gestión de notificaciones
  - Conectar con endpoints GET /api/notifications (ya implementado)
  - Conectar con endpoint PUT /api/notifications/:id/read (ya implementado)
  - Implementar paginación o scroll infinito
  - Agregar filtros por tipo de notificación
  - Implementar "marcar todas como leídas"
  - _Requisitos: 5.2, 5.5_

- [ ]* 6.8 Escribir property test para marcado de notificaciones
  - **Property 15: Marcado de notificaciones como leídas**
  - **Valida: Requisitos 5.5**

- [ ] 6.9 Implementar componentes de notificaciones en la PWA
  - Implementar NotificationCenter con lista de notificaciones
  - Implementar NotificationItem con diseño responsive
  - Agregar iconos y colores según tipo de notificación
  - Implementar navegación al hacer click en notificación
  - Agregar animaciones de entrada/salida
  - _Requisitos: 5.2, 5.3, 5.5_

- [ ] 7. Implementar módulo de inscripciones en la PWA

- [ ] 7.1 Implementar UI de inscripción en curso
  - Agregar botón "Inscribirse" en CourseDetailPage
  - Implementar modal de confirmación de inscripción
  - Conectar con endpoint POST /api/enrollments (ya implementado)
  - Validar que el curso está publicado
  - Validar que el usuario no está ya inscrito
  - Mostrar feedback de éxito/error
  - _Requisitos: 6.1, 6.3, 6.4_

- [ ]* 7.2 Escribir property test para registro de inscripciones
  - **Property 16: Registro de inscripciones**
  - **Valida: Requisitos 6.1, 6.4**

- [ ]* 7.3 Escribir property test para adición a cursos activos
  - **Property 17: Adición a cursos activos**
  - **Valida: Requisitos 6.2**

- [ ] 7.4 Implementar página de cursos activos del estudiante
  - Crear MyCoursesPage con lista de cursos activos
  - Conectar con endpoint GET /api/enrollments/active (ya implementado)
  - Mostrar información del curso y estado de inscripción
  - Implementar filtros por estado (activo, pendiente aprobación)
  - Agregar botón "Marcar como completado" para cursos activos
  - _Requisitos: 6.5, 11.1_

- [ ]* 7.5 Escribir property test para visualización de cursos activos
  - **Property 18: Visualización de cursos activos**
  - **Valida: Requisitos 6.5, 11.1**

- [ ] 7.6 Implementar UI de marcar curso como completado
  - Agregar botón "Marcar como completado" en MyCoursesPage
  - Implementar modal de confirmación
  - Conectar con endpoint PUT /api/enrollments/:id/complete (ya implementado)
  - Validar que el usuario está inscrito en el curso
  - Mostrar feedback de éxito
  - Actualizar lista de cursos tras completar
  - _Requisitos: 7.1, 7.3, 7.4_

- [ ]* 7.7 Escribir property test para cambio de estado al completar
  - **Property 19: Cambio de estado al completar**
  - **Valida: Requisitos 7.1, 7.3**

- [ ] 7.8 Verificar notificación a administradores al completar
  - El backend ya envía notificaciones a administradores ✅
  - Verificar que los administradores reciben notificaciones in-app
  - Verificar que las notificaciones incluyen información del estudiante y curso
  - _Requisitos: 7.2_

- [ ]* 7.9 Escribir property test para notificación a admins
  - **Property 20: Notificación a administradores al completar**
  - **Valida: Requisitos 7.2**

- [ ] 7.10 Crear flujo completo de inscripción en la PWA

  - Integrar botón de inscripción en CourseDetailPage
  - Implementar confirmación de inscripción con modal
  - Mostrar cursos activos en MyCoursesPage
  - Implementar botón de marcar como completado
  - Agregar navegación entre páginas
  - Implementar estados de carga y errores
  - _Requisitos: 6.1, 6.2, 6.5, 7.1, 11.1_

- [ ] 8. Implementar módulo de aprobación de cursos en la PWA

- [ ] 8.1 Implementar página de aprobaciones pendientes (admin)

  - Crear PendingApprovalsPage para administradores
  - Conectar con endpoint GET /api/enrollments/pending (ya implementado)
  - Mostrar tabla con estudiante, curso, fecha de completado
  - Implementar filtros y búsqueda
  - Agregar botones de aprobar/rechazar por inscripción
  - _Requisitos: 8.5_

- [ ]* 8.2 Escribir property test para visualización de pendientes
  - **Property 24: Visualización de aprobaciones pendientes**
  - **Valida: Requisitos 8.5**

- [ ] 8.3 Implementar UI de aprobar curso (admin)

  - Agregar botón "Aprobar" en PendingApprovalsPage
  - Implementar modal de confirmación de aprobación
  - Conectar con endpoint PUT /api/enrollments/:id/approve (ya implementado)
  - Validar que el usuario es administrador (protección de ruta)
  - Mostrar feedback de éxito
  - Actualizar lista de aprobaciones pendientes
  - _Requisitos: 8.1, 8.3_

- [ ]* 8.4 Escribir property test para aprobación
  - **Property 21: Aprobación y cambio de estado**
  - **Valida: Requisitos 8.1, 8.3**


- [ ] 8.5 Implementar UI de rechazar curso (admin)

  - Agregar botón "Rechazar" en PendingApprovalsPage
  - Implementar modal de confirmación de rechazo
  - Conectar con endpoint PUT /api/enrollments/:id/reject (ya implementado)
  - Validar que el usuario es administrador (protección de ruta)
  - Mostrar feedback de éxito
  - Actualizar lista de aprobaciones pendientes
  - _Requisitos: 8.2_

- [ ]* 8.6 Escribir property test para rechazo
  - **Property 22: Rechazo y retorno a activo**
  - **Valida: Requisitos 8.2**

- [ ] 8.7 Verificar notificación al estudiante tras decisión

  - El backend ya envía notificaciones al estudiante ✅
  - Verificar que el estudiante recibe notificación in-app
  - Verificar que la notificación incluye información sobre la decisión
  - _Requisitos: 8.4_

- [ ]* 8.8 Escribir property test para notificación de decisión
  - **Property 23: Notificación de decisión de aprobación**
  - **Valida: Requisitos 8.4**

- [ ] 8.9 Crear flujo completo de aprobación en la PWA (admin)

  - Implementar PendingApprovalsPage con tabla responsive
  - Mostrar detalles de estudiante y curso
  - Implementar botones de aprobar/rechazar con confirmación
  - Agregar filtros y búsqueda
  - Implementar paginación si hay muchas aprobaciones
  - _Requisitos: 8.1, 8.2, 8.5_

- [ ] 9. Implementar módulo de carnets digitales en la PWA

- [ ] 9.1 Crear modelos y servicios de carnets
  - Implementar interfaces DigitalCertificate, CertificateVerification (TypeScript)
  - Crear función de generación de número de carnet (formato CERT-YYYYMMDD-XXXXX)
  - Crear certificate.service.ts para API calls
  - Configurar caché de carnets en IndexedDB para acceso offline
  - _Requisitos: 9.1, 9.2, 9.3_

- [ ] 9.2 Verificar servicio de generación de carnets en backend
  - El backend ya genera carnets al aprobar cursos ✅
  - Verificar endpoint GET /api/certificates (ya implementado)
  - Verificar que incluye todos los campos requeridos
  - Verificar generación de QR code con hash verificable
  - _Requisitos: 9.1, 9.2, 9.3, 9.4, 9.6_

- [ ]* 9.3 Escribir property test para generación de carnet
  - **Property 25: Generación de carnet digital**
  - **Valida: Requisitos 9.1, 9.2, 9.4**

- [ ]* 9.4 Escribir property test para unicidad de número de carnet
  - **Property 26: Unicidad de número de carnet**
  - **Valida: Requisitos 9.3, 9.6**

- [ ] 9.5 Verificar integración de generación con aprobación
  - El backend ya genera carnets al aprobar cursos ✅
  - Verificar que el carnet se crea automáticamente tras aprobación
  - Verificar manejo de errores en generación
  - _Requisitos: 8.3, 9.1_

- [ ] 9.6 Implementar página de carnets del estudiante
  - Crear MyCertificatesPage con grid de carnets
  - Conectar con endpoint GET /api/certificates (ya implementado)
  - Mostrar carnets ordenados por fecha descendente
  - Implementar vista de lista y vista de grid
  - Agregar búsqueda y filtros
  - _Requisitos: 9.5, 10.1, 10.4_

- [ ]* 9.7 Escribir property test para visualización de carnets
  - **Property 27: Visualización de carnets**
  - **Valida: Requisitos 9.5, 10.1**

- [ ]* 9.8 Escribir property test para ordenamiento de carnets
  - **Property 29: Ordenamiento de carnets por fecha**
  - **Valida: Requisitos 10.4**

- [ ] 9.9 Implementar generación de PDF del carnet en backend
  - Instalar librería de generación de PDF (PDFKit o similar) en backend
  - Crear plantilla de carnet con diseño profesional
  - Incluir todos los campos requeridos (nombre, fecha nacimiento, curso, fechas, número)
  - Incluir QR code en el PDF
  - Subir PDF a almacenamiento (S3, Cloudinary, o similar)
  - Actualizar campo pdf_url en base de datos
  - _Requisitos: 9.2, 10.3_

- [ ] 9.10 Implementar UI de exportación de carnet
  - Agregar botón "Descargar PDF" en CertificateDetailPage
  - Conectar con endpoint GET /api/certificates/:id/pdf (a implementar)
  - Implementar botón "Compartir" usando Web Share API
  - Agregar opción de guardar como imagen (canvas o screenshot)
  - Implementar vista previa del carnet antes de compartir
  - _Requisitos: 10.3_

- [ ]* 9.11 Escribir property test para opciones de exportación
  - **Property 28: Opciones de exportación de carnets**
  - **Valida: Requisitos 10.3**

- [ ] 9.12 Crear páginas de carnets en la PWA
  - Implementar MyCertificatesPage con grid responsive
  - Implementar CertificateDetailPage con todos los campos
  - Mostrar QR code para verificación
  - Implementar opciones de compartir (Web Share API)
  - Agregar botón de descarga de PDF
  - Implementar vista previa antes de compartir
  - _Requisitos: 9.5, 10.1, 10.2, 10.3, 10.4_

- [ ]* 9.13 Escribir unit tests para páginas de carnets
  - Test de listado de carnets con datos mock
  - Test de visualización de detalles
  - Test de opciones de compartir
  - Test de descarga de PDF
  - _Requisitos: 10.1, 10.2, 10.3_

- [ ] 10. Implementar funcionalidad offline con Service Workers

- [ ] 10.1 Configurar Service Worker con Workbox
  - Instalar workbox-webpack-plugin o vite-plugin-pwa
  - Configurar estrategias de caché (Network First, Cache First, Stale While Revalidate)
  - Configurar precaching de assets estáticos (HTML, CSS, JS, imágenes)
  - Configurar caché de API calls con expiración
  - Implementar fallback offline para páginas
  - _Requisitos: 12.1, 12.2_

- [ ] 10.2 Configurar IndexedDB con Dexie.js
  - Instalar Dexie.js
  - Crear esquema de base de datos local (courses, enrollments, certificates, notifications)
  - Implementar funciones de sincronización con API
  - Configurar versionado de esquema
  - _Requisitos: 12.1, 12.2_

- [ ] 10.3 Implementar sincronización de carnets para offline
  - Descargar carnets al cargarlos por primera vez
  - Almacenar en IndexedDB con Dexie.js
  - Permitir visualización offline desde IndexedDB
  - Implementar actualización automática cuando hay conexión
  - _Requisitos: 12.1_

- [ ]* 10.3 Escribir property test para acceso offline a carnets
  - **Property 32: Acceso offline a carnets**
  - **Valida: Requisitos 12.1**

- [ ] 10.4 Implementar sincronización de cursos para offline
  - Descargar información de cursos al consultarlos
  - Almacenar en IndexedDB con Dexie.js
  - Permitir visualización offline desde IndexedDB
  - Implementar actualización automática cuando hay conexión
  - _Requisitos: 12.2_

- [ ]* 10.5 Escribir property test para acceso offline a cursos
  - **Property 33: Acceso offline a información de cursos**
  - **Valida: Requisitos 12.2**

- [ ] 10.6 Implementar detección de conectividad en la PWA
  - Usar navigator.onLine para detectar estado de red
  - Escuchar eventos 'online' y 'offline'
  - Mostrar banner o indicador de modo offline en UI
  - Deshabilitar acciones que requieren conexión
  - Mostrar mensajes informativos al usuario
  - _Requisitos: 12.3, 12.5_

- [ ] 10.7 Implementar cola de sincronización con Background Sync
  - Usar Background Sync API para sincronización automática
  - Crear cola de acciones pendientes en IndexedDB
  - Almacenar acciones cuando no hay conexión (inscripciones, completados, etc.)
  - Sincronizar automáticamente al restaurar conexión
  - Implementar reintentos con backoff exponencial
  - Mostrar feedback al usuario sobre sincronización
  - _Requisitos: 12.4_

- [ ]* 10.8 Escribir property test para sincronización
  - **Property 34: Sincronización al restaurar conexión**
  - **Valida: Requisitos 12.4**

- [ ] 11. Implementar módulo de analíticas en la PWA (admin)

- [ ] 11.1 Crear modelos y servicios de analíticas
  - Implementar interfaces CourseAnalytics, SystemAnalytics (TypeScript)
  - Crear analytics.service.ts para API calls
  - _Requisitos: 13.1, 13.2_

- [ ] 11.2 Verificar endpoints de analíticas en backend
  - Verificar endpoint GET /api/analytics/system (a implementar si no existe)
  - Verificar endpoint GET /api/analytics/courses/:id (a implementar si no existe)
  - Verificar cálculo de métricas en tiempo real
  - _Requisitos: 13.1, 13.2, 13.5_

- [ ]* 11.3 Escribir property test para cálculo de estadísticas
  - **Property 35: Cálculo de estadísticas de inscripción**
  - **Valida: Requisitos 13.1, 13.2**

- [ ]* 11.4 Escribir property test para cálculo en tiempo real
  - **Property 36: Cálculo en tiempo real de métricas**
  - **Valida: Requisitos 13.5**

- [ ] 11.5 Implementar endpoint de analíticas por curso en backend
  - Crear GET /api/analytics/courses/:id si no existe
  - Calcular inscripciones, finalizaciones, tasa de completación
  - Calcular tiempo promedio de finalización
  - _Requisitos: 13.2, 13.3_

- [ ] 11.6 Crear páginas de analíticas en la PWA (admin)
  - Implementar AnalyticsDashboardPage con métricas del sistema
  - Implementar CourseStatsCard component para estadísticas por curso
  - Integrar librería de gráficos (Chart.js, Recharts, o similar)
  - Implementar gráficos de inscripciones por curso
  - Implementar gráficos de tasa de completación
  - Agregar filtros por rango de fechas
  - Implementar diseño responsive para dashboard
  - _Requisitos: 13.1, 13.2, 13.3, 13.4_

- [ ] 12. Checkpoint - Asegurar que todas las pruebas pasen
  - Ejecutar todos los unit tests
  - Ejecutar todos los property-based tests
  - Verificar que todas las 36 propiedades se cumplen
  - Resolver cualquier fallo de test
  - Asegurar cobertura de código adecuada
  - Preguntar al usuario si surgen dudas

- [ ] 13. Implementar mejoras de UI/UX en la PWA

- [ ] 13.1 Implementar diseño responsive mobile-first
  - Adaptar todos los layouts para móvil, tablet y escritorio
  - Usar CSS Grid y Flexbox para layouts flexibles
  - Implementar breakpoints (mobile < 640px, tablet 640-1024px, desktop > 1024px)
  - Probar en diferentes tamaños de pantalla
  - Asegurar touch-friendly (botones mínimo 44x44px)
  - _Requisitos: Todos_

- [ ] 13.2 Implementar estados de carga y feedback
  - Agregar spinners durante carga de datos
  - Implementar skeleton screens para listas
  - Agregar animaciones de transición entre páginas
  - Implementar toasts para feedback de acciones
  - Agregar progress bars para operaciones largas
  - _Requisitos: Todos_

- [ ] 13.3 Implementar manejo de errores en UI
  - Mostrar mensajes de error claros y accionables
  - Implementar páginas de error (404, 500, etc.)
  - Agregar botones de reintento para errores de red
  - Implementar error boundaries en React
  - Mostrar fallbacks cuando falla la carga de datos
  - _Requisitos: Todos_

- [ ] 13.4 Implementar estados vacíos
  - Diseñar empty states para listas sin datos
  - Agregar ilustraciones o iconos para empty states
  - Incluir llamados a la acción apropiados
  - Implementar para: cursos, inscripciones, carnets, notificaciones
  - _Requisitos: 10.5, 11.5_

- [ ] 13.5 Implementar animaciones y transiciones
  - Agregar transiciones suaves entre páginas (React Router transitions)
  - Implementar animaciones de feedback para botones
  - Agregar animaciones de entrada/salida para modales
  - Implementar micro-interacciones (hover, focus, active states)
  - Usar CSS transitions o Framer Motion
  - _Requisitos: Todos_

- [ ] 14. Implementar seguridad y validación en la PWA

- [ ] 14.1 Verificar rate limiting en API
  - El backend debe tener rate limiting configurado
  - Manejar respuestas 429 Too Many Requests en la PWA
  - Mostrar mensajes apropiados al usuario
  - _Requisitos: Todos_

- [ ] 14.2 Implementar validación exhaustiva en cliente
  - Validar todos los inputs antes de enviar al servidor
  - Sanitizar datos para prevenir XSS
  - Implementar validación de tipos con TypeScript
  - Usar librerías de validación (Zod, Yup, o similar)
  - _Requisitos: Todos_

- [ ] 14.3 Implementar logging y monitoreo en la PWA
  - Configurar logging de errores (Sentry, LogRocket, o similar)
  - Implementar tracking de eventos importantes
  - Monitorear performance con Web Vitals
  - Configurar alertas para errores críticos
  - _Requisitos: Todos_

- [ ] 14.4 Implementar seguridad de tokens
  - Almacenar tokens JWT de forma segura (httpOnly cookies o localStorage con precauciones)
  - Implementar refresh token automático
  - Limpiar tokens al cerrar sesión
  - Implementar timeout de sesión por inactividad
  - _Requisitos: 3.1, 4.1, 8.1, 8.2_

- [ ] 15. Optimización y testing final de la PWA

- [ ] 15.1 Optimizar performance de la PWA
  - Implementar code splitting con React.lazy() o dynamic imports
  - Optimizar imágenes (WebP, lazy loading)
  - Minimizar bundle size (tree shaking, eliminar dependencias no usadas)
  - Implementar lazy loading de componentes pesados
  - Optimizar re-renders con React.memo, useMemo, useCallback
  - _Requisitos: Todos_

- [ ] 15.2 Implementar caché en cliente
  - Configurar Service Worker para caché de assets
  - Implementar caché de API responses con expiración
  - Configurar precaching de rutas principales
  - Implementar invalidación de caché cuando sea necesario
  - _Requisitos: Todos_

- [ ] 15.3 Optimizar para PWA
  - Asegurar que manifest.json está correctamente configurado
  - Verificar que Service Worker funciona correctamente
  - Implementar splash screen para instalación
  - Optimizar iconos para diferentes dispositivos
  - Asegurar que la app es instalable (cumple criterios PWA)
  - _Requisitos: Todos_

- [ ]* 15.4 Realizar testing de integración end-to-end
  - Test de flujo completo de registro a carnet (Playwright o Cypress)
  - Test de flujo de administrador
  - Test de sincronización offline
  - Test de instalación como PWA
  - _Requisitos: Todos_

- [ ] 15.5 Realizar testing de performance
  - Medir tiempos de carga de páginas (Lighthouse)
  - Identificar y resolver cuellos de botella
  - Optimizar Core Web Vitals (LCP, FID, CLS)
  - Probar en dispositivos móviles reales
  - _Requisitos: Todos_

- [ ] 16. Checkpoint final - Verificación completa del sistema PWA
  - Ejecutar suite completa de tests (unit, integration, e2e)
  - Verificar todas las funcionalidades manualmente en navegador
  - Probar en diferentes navegadores (Chrome, Firefox, Safari, Edge)
  - Probar en dispositivos móviles reales (iOS y Android)
  - Verificar que todas las 36 propiedades se cumplen
  - Verificar que la PWA es instalable
  - Ejecutar Lighthouse audit (objetivo: score > 90 en todas las categorías)
  - Resolver cualquier issue pendiente
  - Preguntar al usuario si surgen dudas

- [ ] 17. Preparación para producción de la PWA

- [ ] 17.1 Configurar entorno de producción
  - Configurar variables de entorno de producción (.env.production)
  - Configurar URL del backend de producción
  - Configurar servicios de terceros (email, almacenamiento, etc.)
  - Configurar HTTPS (requerido para PWA)
  - _Requisitos: Todos_

- [ ] 17.2 Implementar CI/CD para la PWA
  - Configurar pipeline de integración continua (GitHub Actions, GitLab CI, etc.)
  - Configurar build automático en cada push
  - Configurar tests automáticos
  - Configurar despliegue automático a staging/producción
  - _Requisitos: Todos_

- [ ] 17.3 Crear documentación
  - Documentar API con Swagger/OpenAPI (backend)
  - Crear guía de usuario para la PWA
  - Crear guía de administrador
  - Documentar proceso de instalación de la PWA
  - Crear README con instrucciones de desarrollo
  - _Requisitos: Todos_

- [ ] 17.4 Desplegar PWA a producción
  - Generar build de producción (npm run build)
  - Desplegar a hosting web (Vercel, Netlify, AWS S3 + CloudFront, etc.)
  - Configurar dominio personalizado
  - Configurar SSL/TLS (HTTPS obligatorio para PWA)
  - Verificar que Service Worker funciona en producción
  - Probar instalación de PWA desde producción
  - Configurar analytics (Google Analytics, Plausible, etc.)
  - _Requisitos: Todos_

# Documento de Diseño - PWA de Certificación de Cursos

## Visión General

La PWA (Progressive Web App) de certificación de cursos es una aplicación web responsive que funciona en navegadores de escritorio y móvil, y puede instalarse como aplicación en dispositivos. Permite a los administradores gestionar cursos educativos y a los estudiantes inscribirse, completarlos y obtener carnets digitales verificables. El sistema implementa un flujo completo desde el registro hasta la emisión de credenciales digitales, con capacidades offline mediante Service Workers.

### Objetivos Principales

- Proporcionar una experiencia web fluida y responsive para gestión de cursos
- Funcionar en cualquier dispositivo con navegador moderno (móvil, tablet, escritorio)
- Ser instalable como aplicación mediante Web App Manifest
- Automatizar el proceso de certificación y emisión de carnets digitales
- Garantizar la seguridad y verificabilidad de las credenciales
- Soportar operación offline mediante Service Workers y caché
- Facilitar la comunicación mediante notificaciones dentro de la aplicación
- No requerir instalación desde tiendas de aplicaciones

## Arquitectura

### Arquitectura General

El sistema sigue una arquitectura cliente-servidor con los siguientes componentes:

```
┌─────────────────────────────────────────────────────────────┐
│                    PWA (Navegador)                           │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐      │
│  │  Capa de     │  │  Capa de     │  │  Service     │      │
│  │ Presentación │→ │   Lógica     │→ │   Worker     │      │
│  │  (React/Vue) │  │  (Business)  │  │   (Cache)    │      │
│  └──────────────┘  └──────────────┘  └──────────────┘      │
│         ↓                  ↓                  ↓              │
│  ┌──────────────────────────────────────────────────┐       │
│  │         IndexedDB / LocalStorage                 │       │
│  └──────────────────────────────────────────────────┘       │
└─────────────────────────────────────────────────────────────┘
                            ↓
                    ┌───────────────┐
                    │   API REST    │
                    │   (HTTPS)     │
                    └───────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                      Backend Server                          │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐      │
│  │ Autenticación│  │   Gestión    │  │ Notificaciones│     │
│  │   y Roles    │  │  de Cursos   │  │   (In-App)    │     │
│  └──────────────┘  └──────────────┘  └──────────────┘      │
│  ┌──────────────┐  ┌──────────────┐                         │
│  │  Generación  │  │   Base de    │                         │
│  │  de Carnets  │  │    Datos     │                         │
│  └──────────────┘  └──────────────┘                         │
└─────────────────────────────────────────────────────────────┘
```

### Stack Tecnológico Recomendado

**Frontend (PWA):**
- Framework: React o Vue.js
- Gestión de Estado: Redux/Zustand (React) o Vuex/Pinia (Vue)
- Almacenamiento Local: IndexedDB (Dexie.js) + LocalStorage
- Service Worker: Workbox para caché y offline
- Manifest: Web App Manifest para instalación
- Routing: React Router o Vue Router
- UI Framework: Material-UI, Tailwind CSS, o similar
- Build Tool: Vite o Webpack

**Backend:**
- API: Node.js con Express (ya implementado)
- Base de Datos: PostgreSQL (ya configurado con Neon)
- Autenticación: JWT (JSON Web Tokens) (ya implementado)
- Almacenamiento de Archivos: AWS S3 o similar para carnets en PDF
- Notificaciones: Sistema de notificaciones in-app (sin push notifications)

## Componentes e Interfaces

### 1. Módulo de Autenticación

#### Componentes Web:
- **RegistrationPage**: Página de registro de nuevos usuarios
- **LoginPage**: Página de inicio de sesión
- **PasswordRecoveryPage**: Recuperación de contraseña
- **InitialAdminSetupPage**: Configuración del primer administrador

#### Interfaces:

```typescript
interface User {
  id: string;
  email: string;
  fullName: string;
  dateOfBirth: Date;
  role: UserRole;
  createdAt: Date;
  emailVerified: boolean;
}

enum UserRole {
  STUDENT = 'student',
  ADMINISTRATOR = 'administrator'
}

interface AuthCredentials {
  email: string;
  password: string;
}

interface RegistrationData {
  email: string;
  fullName: string;
  dateOfBirth: Date;
  password: string;
  confirmPassword: string;
}

interface AuthToken {
  accessToken: string;
  refreshToken: string;
  expiresIn: number;
}
```

### 2. Módulo de Gestión de Cursos

#### Componentes Web:
- **CourseListPage**: Lista de cursos disponibles
- **CourseDetailPage**: Detalles de un curso específico
- **CourseCreationPage**: Creación/edición de cursos (admin)
- **CourseManagementPage**: Panel de gestión de cursos (admin)

#### Interfaces:

```typescript
interface Course {
  id: string;
  title: string;
  description: string;
  duration: string;
  requirements: string[];
  status: CourseStatus;
  createdBy: string;
  createdAt: Date;
  updatedAt: Date;
}

enum CourseStatus {
  DRAFT = 'draft',
  PUBLISHED = 'published',
  ARCHIVED = 'archived'
}

interface CourseEnrollment {
  id: string;
  courseId: string;
  studentId: string;
  enrolledAt: Date;
  status: EnrollmentStatus;
  completedAt?: Date;
  approvedAt?: Date;
  approvedBy?: string;
}

enum EnrollmentStatus {
  ACTIVE = 'active',
  COMPLETED = 'completed',
  PENDING_APPROVAL = 'pending_approval',
  APPROVED = 'approved',
  REJECTED = 'rejected'
}
```

### 3. Módulo de Notificaciones

#### Componentes Web:
- **NotificationCenter**: Centro de notificaciones in-app
- **NotificationItem**: Item individual de notificación
- **NotificationBadge**: Indicador de notificaciones no leídas

#### Interfaces:

```typescript
interface Notification {
  id: string;
  userId: string;
  type: NotificationType;
  title: string;
  message: string;
  data: any;
  read: boolean;
  createdAt: Date;
}

enum NotificationType {
  NEW_COURSE = 'new_course',
  ENROLLMENT_CONFIRMED = 'enrollment_confirmed',
  COMPLETION_SUBMITTED = 'completion_submitted',
  COURSE_APPROVED = 'course_approved',
  COURSE_REJECTED = 'course_rejected',
  CERTIFICATE_ISSUED = 'certificate_issued'
}
```

### 4. Módulo de Carnets Digitales

#### Componentes Web:
- **CertificateListPage**: Lista de carnets del estudiante
- **CertificateDetailPage**: Vista detallada del carnet
- **CertificateGeneratorService**: Servicio de generación de carnets
- **CertificateShareModal**: Modal para compartir carnet

#### Interfaces:

```typescript
interface DigitalCertificate {
  id: string;
  certificateNumber: string; // Formato: CERT-YYYYMMDD-XXXXX
  studentId: string;
  studentName: string;
  studentDateOfBirth: Date;
  courseId: string;
  courseName: string;
  completionDate: Date;
  approvalDate: Date;
  approvedBy: string;
  issuedAt: Date;
  qrCode: string; // Para verificación
  pdfUrl?: string;
}

interface CertificateVerification {
  certificateNumber: string;
  isValid: boolean;
  studentName: string;
  courseName: string;
  issueDate: Date;
}
```

### 5. Módulo de Analíticas (Admin)

#### Componentes Web:
- **AnalyticsDashboard**: Panel de analíticas
- **CourseStatsCard**: Tarjeta de estadísticas por curso
- **EnrollmentChart**: Gráfico de inscripciones (usando Chart.js o similar)

#### Interfaces:

```typescript
interface CourseAnalytics {
  courseId: string;
  courseName: string;
  totalEnrollments: number;
  activeEnrollments: number;
  completedEnrollments: number;
  approvedEnrollments: number;
  completionRate: number;
  averageCompletionTime: number; // en días
}

interface SystemAnalytics {
  totalUsers: number;
  totalStudents: number;
  totalAdministrators: number;
  totalCourses: number;
  totalEnrollments: number;
  totalCertificatesIssued: number;
  courseAnalytics: CourseAnalytics[];
}
```

## Modelos de Datos

### Esquema de Base de Datos

```sql
-- Tabla de Usuarios
CREATE TABLE users (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  email VARCHAR(255) UNIQUE NOT NULL,
  full_name VARCHAR(255) NOT NULL,
  date_of_birth DATE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role VARCHAR(50) NOT NULL DEFAULT 'student',
  email_verified BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Cursos
CREATE TABLE courses (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  title VARCHAR(255) NOT NULL,
  description TEXT,
  duration VARCHAR(100),
  requirements TEXT[],
  status VARCHAR(50) NOT NULL DEFAULT 'draft',
  created_by UUID REFERENCES users(id),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Inscripciones
CREATE TABLE enrollments (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  course_id UUID REFERENCES courses(id) ON DELETE CASCADE,
  student_id UUID REFERENCES users(id) ON DELETE CASCADE,
  status VARCHAR(50) NOT NULL DEFAULT 'active',
  enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  completed_at TIMESTAMP,
  approved_at TIMESTAMP,
  approved_by UUID REFERENCES users(id),
  UNIQUE(course_id, student_id)
);

-- Tabla de Certificados
CREATE TABLE certificates (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  certificate_number VARCHAR(50) UNIQUE NOT NULL,
  enrollment_id UUID REFERENCES enrollments(id) ON DELETE CASCADE,
  student_id UUID REFERENCES users(id),
  course_id UUID REFERENCES courses(id),
  qr_code TEXT NOT NULL,
  pdf_url TEXT,
  issued_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Notificaciones
CREATE TABLE notifications (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  user_id UUID REFERENCES users(id) ON DELETE CASCADE,
  type VARCHAR(50) NOT NULL,
  title VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  data JSONB,
  read BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Índices para optimización
CREATE INDEX idx_enrollments_student ON enrollments(student_id);
CREATE INDEX idx_enrollments_course ON enrollments(course_id);
CREATE INDEX idx_enrollments_status ON enrollments(status);
CREATE INDEX idx_certificates_student ON certificates(student_id);
CREATE INDEX idx_certificates_number ON certificates(certificate_number);
CREATE INDEX idx_notifications_user ON notifications(user_id);
CREATE INDEX idx_notifications_read ON notifications(read);
```

## Configuración PWA

### Web App Manifest

La PWA requiere un archivo `manifest.json` para permitir la instalación:

```json
{
  "name": "Sistema de Certificación de Cursos",
  "short_name": "Cert Cursos",
  "description": "Plataforma de gestión y certificación de cursos educativos",
  "start_url": "/",
  "display": "standalone",
  "background_color": "#ffffff",
  "theme_color": "#2196F3",
  "orientation": "any",
  "icons": [
    {
      "src": "/icons/icon-72x72.png",
      "sizes": "72x72",
      "type": "image/png"
    },
    {
      "src": "/icons/icon-96x96.png",
      "sizes": "96x96",
      "type": "image/png"
    },
    {
      "src": "/icons/icon-128x128.png",
      "sizes": "128x128",
      "type": "image/png"
    },
    {
      "src": "/icons/icon-144x144.png",
      "sizes": "144x144",
      "type": "image/png"
    },
    {
      "src": "/icons/icon-152x152.png",
      "sizes": "152x152",
      "type": "image/png"
    },
    {
      "src": "/icons/icon-192x192.png",
      "sizes": "192x192",
      "type": "image/png",
      "purpose": "any maskable"
    },
    {
      "src": "/icons/icon-384x384.png",
      "sizes": "384x384",
      "type": "image/png"
    },
    {
      "src": "/icons/icon-512x512.png",
      "sizes": "512x512",
      "type": "image/png"
    }
  ]
}
```

### Service Worker

El Service Worker maneja el caché y la funcionalidad offline:

**Estrategias de Caché:**

1. **Network First** (para datos dinámicos):
   - API calls para cursos, inscripciones, notificaciones
   - Intenta red primero, fallback a caché si falla

2. **Cache First** (para assets estáticos):
   - HTML, CSS, JavaScript
   - Imágenes, iconos, fuentes
   - Carnets digitales descargados

3. **Stale While Revalidate** (para datos semi-estáticos):
   - Lista de cursos
   - Información de perfil de usuario

**Implementación con Workbox:**

```javascript
// service-worker.js
import { registerRoute } from 'workbox-routing';
import { NetworkFirst, CacheFirst, StaleWhileRevalidate } from 'workbox-strategies';
import { CacheableResponsePlugin } from 'workbox-cacheable-response';
import { ExpirationPlugin } from 'workbox-expiration';

// Cache de API con Network First
registerRoute(
  ({url}) => url.pathname.startsWith('/api/'),
  new NetworkFirst({
    cacheName: 'api-cache',
    plugins: [
      new CacheableResponsePlugin({
        statuses: [0, 200],
      }),
      new ExpirationPlugin({
        maxEntries: 50,
        maxAgeSeconds: 5 * 60, // 5 minutos
      }),
    ],
  })
);

// Cache de assets estáticos con Cache First
registerRoute(
  ({request}) => request.destination === 'style' ||
                  request.destination === 'script' ||
                  request.destination === 'image',
  new CacheFirst({
    cacheName: 'static-resources',
    plugins: [
      new ExpirationPlugin({
        maxEntries: 60,
        maxAgeSeconds: 30 * 24 * 60 * 60, // 30 días
      }),
    ],
  })
);

// Cache de carnets con Cache First
registerRoute(
  ({url}) => url.pathname.includes('/certificates/'),
  new CacheFirst({
    cacheName: 'certificates-cache',
    plugins: [
      new ExpirationPlugin({
        maxEntries: 30,
        maxAgeSeconds: 90 * 24 * 60 * 60, // 90 días
      }),
    ],
  })
);
```

### Almacenamiento Local

**IndexedDB (usando Dexie.js):**

```typescript
import Dexie from 'dexie';

class AppDatabase extends Dexie {
  courses: Dexie.Table<Course, string>;
  enrollments: Dexie.Table<Enrollment, string>;
  certificates: Dexie.Table<Certificate, string>;
  notifications: Dexie.Table<Notification, string>;

  constructor() {
    super('CourseAppDB');
    this.version(1).stores({
      courses: 'id, title, status, createdAt',
      enrollments: 'id, courseId, studentId, status, enrolledAt',
      certificates: 'id, certificateNumber, studentId, issuedAt',
      notifications: 'id, userId, read, createdAt'
    });
  }
}

export const db = new AppDatabase();
```

**LocalStorage (para configuración):**
- Token de autenticación (JWT)
- Preferencias de usuario
- Tema (claro/oscuro)
- Idioma

### Sincronización Offline

**Background Sync API:**

```javascript
// Registrar acciones pendientes cuando no hay conexión
async function queueAction(action) {
  const db = await openDB('sync-queue');
  await db.add('actions', {
    ...action,
    timestamp: Date.now()
  });
  
  // Registrar sync cuando haya conexión
  if ('serviceWorker' in navigator && 'sync' in registration) {
    await registration.sync.register('sync-actions');
  }
}

// En el Service Worker
self.addEventListener('sync', event => {
  if (event.tag === 'sync-actions') {
    event.waitUntil(syncPendingActions());
  }
});

async function syncPendingActions() {
  const db = await openDB('sync-queue');
  const actions = await db.getAll('actions');
  
  for (const action of actions) {
    try {
      await fetch(action.url, {
        method: action.method,
        body: JSON.stringify(action.data),
        headers: action.headers
      });
      await db.delete('actions', action.id);
    } catch (error) {
      console.error('Sync failed:', error);
    }
  }
}
```

### Responsive Design

La PWA debe ser completamente responsive:

**Breakpoints:**
- Mobile: < 640px
- Tablet: 640px - 1024px
- Desktop: > 1024px

**Consideraciones:**
- Touch-friendly (botones mínimo 44x44px)
- Navegación adaptativa (hamburger menu en móvil, sidebar en desktop)
- Formularios optimizados para móvil
- Imágenes responsive con srcset
- Tipografía escalable (rem/em)

## 
Propiedades de Corrección

*Una propiedad es una característica o comportamiento que debe mantenerse verdadero en todas las ejecuciones válidas de un sistema - esencialmente, una declaración formal sobre lo que el sistema debe hacer. Las propiedades sirven como puente entre las especificaciones legibles por humanos y las garantías de corrección verificables por máquina.*

### Propiedad 1: Validación de registro de usuario

*Para cualquier* conjunto de datos de registro válidos (email válido, contraseña segura, edad >= 16 años), cuando se crea un usuario, el sistema debe almacenar correctamente todos los campos requeridos y asignar el rol de estudiante por defecto.

**Valida: Requisitos 1.1, 1.3, 1.4, 1.5, 3.6**

### Propiedad 2: Unicidad de correos electrónicos

*Para cualquier* correo electrónico ya registrado en el sistema, intentar registrar un nuevo usuario con ese mismo correo debe ser rechazado y no debe crear una cuenta duplicada.

**Valida: Requisitos 1.7**

### Propiedad 3: Generación de tokens de autenticación

*Para cualquier* usuario con credenciales válidas, cuando se autentica exitosamente, el sistema debe generar un token JWT válido con tiempo de expiración.

**Valida: Requisitos 2.1, 2.3**

### Propiedad 4: Expiración de sesiones

*Para cualquier* token de sesión expirado, cuando un usuario intenta realizar una acción protegida, el sistema debe requerir re-autenticación.

**Valida: Requisitos 2.4**

### Propiedad 5: Envío de correos de verificación

*Para cualquier* nuevo registro completado, el sistema debe enviar un correo de verificación al email proporcionado.

**Valida: Requisitos 1.6**

### Propiedad 6: Envío de enlaces de recuperación

*Para cualquier* solicitud de recuperación de contraseña con email válido, el sistema debe enviar un enlace de restablecimiento.

**Valida: Requisitos 2.5**

### Propiedad 7: Actualización de permisos por rol

*Para cualquier* cambio de rol de usuario, el sistema debe actualizar inmediatamente los permisos asociados a ese rol.

**Valida: Requisitos 3.1, 3.4**

### Propiedad 8: Configuración inicial de administrador

*Para cualquier* sistema sin administradores existentes, el primer usuario debe tener acceso a la configuración inicial de administrador.

**Valida: Requisitos 3.1.5**

### Propiedad 9: Persistencia de cursos

*Para cualquier* curso creado por un administrador, el sistema debe almacenar todos los campos requeridos (título, descripción, duración, requisitos) en la base de datos.

**Valida: Requisitos 4.1, 4.3**

### Propiedad 10: Visibilidad de cursos publicados

*Para cualquier* curso con estado "publicado", el sistema debe hacerlo visible a todos los usuarios con rol de estudiante.

**Valida: Requisitos 4.2**

### Propiedad 11: Actualización inmediata de cursos

*Para cualquier* modificación de información de curso, el sistema debe reflejar los cambios inmediatamente a todos los usuarios que consulten ese curso.

**Valida: Requisitos 4.4**

### Propiedad 12: Preservación de historial al eliminar

*Para cualquier* curso eliminado, el sistema debe removerlo del catálogo pero mantener intactos los registros de inscripciones históricas.

**Valida: Requisitos 4.5**

### Propiedad 13: Notificaciones de nuevos cursos

*Para cualquier* curso publicado, el sistema debe crear notificaciones in-app para todos los usuarios con rol de estudiante.

**Valida: Requisitos 5.1**

### Propiedad 14: Notificaciones individuales múltiples

*Para cualquier* conjunto de cursos publicados simultáneamente, el sistema debe enviar una notificación separada por cada curso.

**Valida: Requisitos 5.4**

### Propiedad 15: Marcado de notificaciones como leídas

*Para cualquier* notificación visualizada por un usuario, el sistema debe actualizar su estado a "leída".

**Valida: Requisitos 5.5**

### Propiedad 16: Registro de inscripciones

*Para cualquier* estudiante que confirme inscripción en un curso disponible, el sistema debe crear un registro de inscripción con timestamp.

**Valida: Requisitos 6.1, 6.4**

### Propiedad 17: Adición a cursos activos

*Para cualquier* inscripción exitosa, el curso debe aparecer en la lista de cursos activos del estudiante.

**Valida: Requisitos 6.2**

### Propiedad 18: Visualización de cursos activos

*Para cualquier* estudiante, cuando consulta sus cursos activos, el sistema debe mostrar todos los cursos con estado "active" o "pending_approval".

**Valida: Requisitos 6.5, 11.1**

### Propiedad 19: Cambio de estado al completar

*Para cualquier* curso marcado como completado por un estudiante, el sistema debe cambiar su estado a "pending_approval" y registrar el timestamp de finalización.

**Valida: Requisitos 7.1, 7.3**

### Propiedad 20: Notificación a administradores al completar

*Para cualquier* curso completado por un estudiante, el sistema debe enviar notificaciones a todos los usuarios con rol de administrador.

**Valida: Requisitos 7.2**

### Propiedad 21: Aprobación y cambio de estado

*Para cualquier* curso aprobado por un administrador, el sistema debe cambiar el estado a "approved" y activar la generación del carnet digital.

**Valida: Requisitos 8.1, 8.3**

### Propiedad 22: Rechazo y retorno a activo

*Para cualquier* curso rechazado por un administrador, el sistema debe devolver el estado a "active".

**Valida: Requisitos 8.2**

### Propiedad 23: Notificación de decisión de aprobación

*Para cualquier* acción de aprobación o rechazo, el sistema debe enviar una notificación al estudiante afectado.

**Valida: Requisitos 8.4**

### Propiedad 24: Visualización de aprobaciones pendientes

*Para cualquier* administrador que consulte aprobaciones pendientes, el sistema debe mostrar todos los cursos con estado "pending_approval".

**Valida: Requisitos 8.5**

### Propiedad 25: Generación de carnet digital

*Para cualquier* curso aprobado, el sistema debe generar un carnet digital único con todos los campos requeridos (nombre, fecha de nacimiento, curso, fechas, número de carnet).

**Valida: Requisitos 9.1, 9.2, 9.4**

### Propiedad 26: Unicidad de número de carnet

*Para cualquier* carnet generado, el número de carnet debe ser único en todo el sistema y seguir el formato CERT-YYYYMMDD-XXXXX.

**Valida: Requisitos 9.3, 9.6**

### Propiedad 27: Visualización de carnets

*Para cualquier* estudiante que consulte sus carnets, el sistema debe mostrar todos los carnets con estado "approved".

**Valida: Requisitos 9.5, 10.1**

### Propiedad 28: Opciones de exportación de carnets

*Para cualquier* carnet digital, el sistema debe proporcionar opciones de exportación en múltiples formatos (PDF, imagen, enlace).

**Valida: Requisitos 10.3**

### Propiedad 29: Ordenamiento de carnets por fecha

*Para cualquier* lista de carnets mostrada, el sistema debe ordenarlos por fecha de finalización en orden descendente.

**Valida: Requisitos 10.4**

### Propiedad 30: Campos requeridos en cursos activos

*Para cualquier* curso activo mostrado, el sistema debe incluir nombre del curso, fecha de inscripción y estado actual.

**Valida: Requisitos 11.2**

### Propiedad 31: Remoción de cursos completados de activos

*Para cualquier* curso que cambie a estado "approved" o "rejected", el sistema debe removerlo de la lista de cursos activos.

**Valida: Requisitos 11.4**

### Propiedad 32: Acceso offline a carnets

*Para cualquier* carnet previamente cargado, el sistema debe permitir su visualización sin conexión a internet.

**Valida: Requisitos 12.1**

### Propiedad 33: Acceso offline a información de cursos

*Para cualquier* información de curso previamente cargada, el sistema debe permitir su visualización sin conexión a internet.

**Valida: Requisitos 12.2**

### Propiedad 34: Sincronización al restaurar conexión

*Para cualquier* cambio de datos realizado mientras hay conexión, cuando se pierde y restaura la conexión, el sistema debe sincronizar todos los cambios pendientes.

**Valida: Requisitos 12.4**

### Propiedad 35: Cálculo de estadísticas de inscripción

*Para cualquier* curso en el sistema, las analíticas deben calcular correctamente el número total de inscripciones, inscripciones activas y tasa de finalización.

**Valida: Requisitos 13.1, 13.2**

### Propiedad 36: Cálculo en tiempo real de métricas

*Para cualquier* solicitud de analíticas, el sistema debe calcular las métricas basándose en el estado actual de la base de datos.

**Valida: Requisitos 13.5**

## Manejo de Errores

### Estrategia General

El sistema implementa un manejo de errores en capas:

1. **Validación en Cliente**: Validación inmediata de entrada de usuario antes de enviar al servidor
2. **Validación en Servidor**: Validación adicional en el backend para seguridad
3. **Manejo de Errores de Red**: Reintentos automáticos y mensajes claros al usuario
4. **Logging**: Registro de errores para debugging y monitoreo

### Tipos de Errores

#### Errores de Validación
```typescript
interface ValidationError {
  field: string;
  message: string;
  code: string;
}

// Ejemplos:
// - EMAIL_INVALID: "El formato del correo electrónico no es válido"
// - PASSWORD_WEAK: "La contraseña debe tener al menos 8 caracteres"
// - AGE_REQUIREMENT: "Debes tener al menos 16 años"
```

#### Errores de Autenticación
```typescript
enum AuthError {
  INVALID_CREDENTIALS = 'invalid_credentials',
  TOKEN_EXPIRED = 'token_expired',
  UNAUTHORIZED = 'unauthorized',
  EMAIL_NOT_VERIFIED = 'email_not_verified'
}
```

#### Errores de Negocio
```typescript
enum BusinessError {
  DUPLICATE_ENROLLMENT = 'duplicate_enrollment',
  COURSE_NOT_FOUND = 'course_not_found',
  ALREADY_COMPLETED = 'already_completed',
  INSUFFICIENT_PERMISSIONS = 'insufficient_permissions',
  INVALID_STATE_TRANSITION = 'invalid_state_transition'
}
```

#### Errores de Red
```typescript
interface NetworkError {
  type: 'timeout' | 'no_connection' | 'server_error';
  retryable: boolean;
  message: string;
}
```

### Manejo de Errores por Módulo

#### Autenticación
- Credenciales inválidas: Mensaje claro sin revelar si el email existe
- Token expirado: Redirección automática a login
- Email no verificado: Opción para reenviar correo de verificación

#### Gestión de Cursos
- Curso no encontrado: Mensaje de error y redirección al catálogo
- Permisos insuficientes: Mensaje claro sobre restricciones de rol
- Inscripción duplicada: Mensaje informativo y redirección al curso

#### Carnets Digitales
- Error en generación: Reintento automático y notificación al administrador
- Carnet no encontrado: Mensaje de error y contacto con soporte

#### Sincronización Offline
- Conflictos de datos: Resolución basada en timestamp (último cambio gana)
- Fallo en sincronización: Cola de reintentos con backoff exponencial

## Estrategia de Testing

### Testing Dual: Unit Tests y Property-Based Tests

El sistema implementa dos tipos complementarios de pruebas:

#### Unit Tests
Los unit tests verifican casos específicos, ejemplos concretos y casos borde:
- Registro con datos específicos válidos
- Login con credenciales conocidas
- Creación de curso con datos de ejemplo
- Generación de carnet con datos específicos
- Casos borde como listas vacías, usuarios sin permisos, etc.

#### Property-Based Tests

Los property-based tests verifican propiedades universales que deben cumplirse para todos los inputs válidos:

**Framework Recomendado:**
- JavaScript/TypeScript: `fast-check` para property-based testing
- Testing Framework: Jest o Vitest
- Testing Library: React Testing Library o Vue Testing Library
- E2E Testing: Playwright o Cypress

**Configuración:**
- Mínimo 100 iteraciones por propiedad
- Generadores personalizados para cada tipo de dato
- Shrinking automático para encontrar casos mínimos de fallo

**Ejemplos de Generadores:**

```typescript
// Generador de usuarios válidos
const validUserGen = fc.record({
  email: fc.emailAddress(),
  fullName: fc.string({ minLength: 2, maxLength: 100 }),
  dateOfBirth: fc.date({ max: new Date(Date.now() - 16 * 365 * 24 * 60 * 60 * 1000) }),
  password: fc.string({ minLength: 8 }).filter(pwd => 
    /[A-Z]/.test(pwd) && /[a-z]/.test(pwd) && /[0-9]/.test(pwd)
  )
});

// Generador de cursos
const courseGen = fc.record({
  title: fc.string({ minLength: 5, maxLength: 200 }),
  description: fc.string({ minLength: 10, maxLength: 1000 }),
  duration: fc.string(),
  requirements: fc.array(fc.string(), { minLength: 0, maxLength: 10 })
});

// Generador de números de carnet
const certificateNumberGen = fc.tuple(
  fc.date(),
  fc.integer({ min: 1, max: 99999 })
).map(([date, seq]) => {
  const dateStr = date.toISOString().slice(0, 10).replace(/-/g, '');
  const seqStr = seq.toString().padStart(5, '0');
  return `CERT-${dateStr}-${seqStr}`;
});
```

**Etiquetado de Tests:**

Cada property-based test debe incluir un comentario que referencie la propiedad del documento de diseño:

```typescript
// Feature: mobile-course-certification-app, Property 1: Validación de registro de usuario
test('valid user registration creates account with student role', () => {
  fc.assert(
    fc.property(validUserGen, async (userData) => {
      const user = await registerUser(userData);
      expect(user).toBeDefined();
      expect(user.role).toBe(UserRole.STUDENT);
      expect(user.email).toBe(userData.email);
    }),
    { numRuns: 100 }
  );
});

// Feature: mobile-course-certification-app, Property 26: Unicidad de número de carnet
test('certificate numbers are globally unique', () => {
  fc.assert(
    fc.property(fc.array(courseGen, { minLength: 2, maxLength: 10 }), async (courses) => {
      const certificates = await Promise.all(
        courses.map(course => generateCertificate(course))
      );
      const numbers = certificates.map(cert => cert.certificateNumber);
      const uniqueNumbers = new Set(numbers);
      expect(uniqueNumbers.size).toBe(numbers.length);
    }),
    { numRuns: 100 }
  );
});
```

### Cobertura de Testing

- **Unit Tests**: Casos específicos, ejemplos, edge cases
- **Property Tests**: Propiedades universales (36 propiedades definidas)
- **Integration Tests**: Flujos completos de usuario
- **E2E Tests**: Escenarios críticos de negocio

### Prioridades de Testing

1. **Alta Prioridad**:
   - Autenticación y autorización
   - Generación de carnets digitales
   - Unicidad de números de carnet
   - Sincronización offline

2. **Media Prioridad**:
   - Gestión de cursos
   - Sistema de notificaciones
   - Analíticas

3. **Baja Prioridad**:
   - UI/UX
   - Animaciones
   - Temas visuales

### Testing Específico de PWA

**Service Worker Testing:**
```javascript
// Ejemplo con Workbox Testing
import { setupWorkbox } from 'workbox-testing';

describe('Service Worker', () => {
  it('should cache API responses', async () => {
    const sw = await setupWorkbox();
    const response = await sw.fetch('/api/courses');
    expect(response.status).toBe(200);
    
    // Verificar que está en caché
    const cache = await caches.open('api-cache');
    const cachedResponse = await cache.match('/api/courses');
    expect(cachedResponse).toBeDefined();
  });
});
```

**Offline Testing:**
```javascript
// Simular modo offline
describe('Offline Mode', () => {
  beforeEach(() => {
    // Simular offline
    Object.defineProperty(navigator, 'onLine', {
      writable: true,
      value: false
    });
  });

  it('should show cached courses when offline', async () => {
    const { getByText } = render(<CourseList />);
    expect(getByText('Curso de Ejemplo')).toBeInTheDocument();
  });
});
```

**PWA Installation Testing:**
```javascript
describe('PWA Installation', () => {
  it('should show install prompt', async () => {
    const installPrompt = new Event('beforeinstallprompt');
    window.dispatchEvent(installPrompt);
    
    const { getByText } = render(<App />);
    expect(getByText('Instalar App')).toBeInTheDocument();
  });
});
```

**Responsive Testing:**
```javascript
// Testing con diferentes viewports
describe('Responsive Design', () => {
  it('should adapt to mobile viewport', () => {
    global.innerWidth = 375;
    global.innerHeight = 667;
    global.dispatchEvent(new Event('resize'));
    
    const { container } = render(<HomePage />);
    expect(container.querySelector('.mobile-menu')).toBeInTheDocument();
  });
});
```

## Consideraciones de Seguridad

### Autenticación y Autorización

1. **Passwords**:
   - Hash con bcrypt (cost factor 12)
   - Nunca almacenar passwords en texto plano
   - Validación de fortaleza en cliente y servidor

2. **Tokens JWT**:
   - Firma con algoritmo HS256 o RS256
   - Expiración corta (15 minutos para access token)
   - Refresh tokens con expiración larga (7 días)
   - Almacenamiento seguro en dispositivo (Keychain/Keystore)

3. **Control de Acceso**:
   - Validación de roles en cada endpoint
   - Principio de mínimo privilegio
   - Auditoría de acciones administrativas

### Protección de Datos

1. **Datos Personales**:
   - Encriptación en tránsito (HTTPS/TLS 1.3)
   - Encriptación en reposo para datos sensibles
   - Cumplimiento con GDPR/LOPD

2. **Carnets Digitales**:
   - Firma digital para verificación
   - QR code con hash verificable
   - Prevención de falsificación

### Validación de Entrada

1. **Cliente**:
   - Validación inmediata de formularios
   - Sanitización de inputs
   - Prevención de inyección de código

2. **Servidor**:
   - Validación redundante de todos los inputs
   - Rate limiting para prevenir abuso
   - Protección contra SQL injection

## Consideraciones de Performance

### Optimizaciones de Cliente

1. **Caché Local**:
   - Almacenamiento de cursos consultados
   - Caché de carnets digitales
   - Imágenes optimizadas y cacheadas

2. **Lazy Loading**:
   - Carga diferida de listas largas
   - Paginación de resultados
   - Carga progresiva de imágenes

3. **Optimización de Red**:
   - Compresión de respuestas (gzip)
   - Minimización de requests
   - Uso de GraphQL o REST optimizado

### Optimizaciones de Servidor

1. **Base de Datos**:
   - Índices en campos frecuentemente consultados
   - Queries optimizadas
   - Connection pooling

2. **Caché de Servidor**:
   - Redis para datos frecuentemente accedidos
   - Caché de analíticas
   - Invalidación inteligente de caché

3. **Escalabilidad**:
   - Arquitectura stateless para horizontal scaling
   - Load balancing
   - CDN para assets estáticos

## Flujos de Usuario Principales

### Flujo 1: Registro e Inicio de Sesión

```
Usuario → Pantalla de Registro
       → Ingresa datos (email, nombre, fecha nacimiento, password)
       → Validación en cliente
       → Envío a servidor
       → Creación de cuenta
       → Envío de email de verificación
       → Usuario verifica email
       → Login exitoso
       → Asignación automática de rol estudiante
```

### Flujo 2: Configuración de Primer Administrador

```
Primer Usuario → Registro normal
              → Sistema detecta que no hay administradores
              → Muestra pantalla de configuración inicial
              → Usuario ingresa código de activación
              → Si código correcto: Rol = Administrador
              → Si código incorrecto: Rol = Estudiante
```

### Flujo 3: Publicación de Curso y Notificación

```
Administrador → Crea curso
             → Completa información (título, descripción, etc.)
             → Publica curso
             → Sistema envía notificaciones push a todos los estudiantes
             → Estudiantes reciben notificación
             → Click en notificación → Detalles del curso
```

### Flujo 4: Inscripción y Completación de Curso

```
Estudiante → Ve catálogo de cursos
          → Selecciona curso
          → Confirma inscripción
          → Curso aparece en "Cursos Activos"
          → Estudiante completa el curso
          → Marca como completado
          → Estado cambia a "Pendiente de Aprobación"
          → Notificación enviada a administradores
```

### Flujo 5: Aprobación y Generación de Carnet

```
Administrador → Ve lista de aprobaciones pendientes
             → Selecciona curso completado
             → Revisa información del estudiante
             → Aprueba el curso
             → Sistema genera carnet digital automáticamente
             → Número de carnet: CERT-YYYYMMDD-XXXXX
             → Carnet incluye: nombre, fecha nacimiento, curso, fechas
             → Notificación enviada al estudiante
             → Estudiante ve carnet en su colección
```

### Flujo 6: Visualización y Compartir Carnet

```
Estudiante → Accede a "Mis Carnets"
          → Ve lista de carnets ordenados por fecha
          → Selecciona un carnet
          → Ve detalles completos
          → Opciones de compartir:
             - Exportar como PDF
             - Compartir como imagen
             - Generar enlace compartible
          → Carnet incluye QR code para verificación
```

## Roadmap de Implementación

### Fase 1: MVP (Mínimo Producto Viable)
- Autenticación básica (registro, login)
- Gestión básica de cursos (crear, listar, publicar)
- Inscripción en cursos
- Aprobación manual de cursos
- Generación básica de carnets digitales

### Fase 2: Funcionalidades Core
- Sistema de notificaciones push
- Configuración de primer administrador
- Visualización de cursos activos
- Exportación de carnets (PDF, imagen)
- Modo offline básico

### Fase 3: Funcionalidades Avanzadas
- Analíticas para administradores
- Sincronización offline completa
- Verificación de carnets por QR
- Sistema de recuperación de contraseña
- Mejoras de UI/UX

### Fase 4: Optimización y Escalabilidad
- Optimizaciones de performance
- Caché avanzado
- Mejoras de seguridad
- Testing exhaustivo
- Preparación para producción

## Conclusión

Este diseño proporciona una base sólida para implementar una aplicación móvil de certificación de cursos completa y escalable. Las 36 propiedades de corrección definidas aseguran que el sistema mantenga su integridad en todas las operaciones, mientras que la estrategia dual de testing (unit tests + property-based tests) garantiza una cobertura exhaustiva de casos de uso y edge cases.

La arquitectura modutal y facilita el mantenimielar permite desarrollo incremennto a largo plazo. Las consideraciones de seguridad y performance están integradas desde el diseño, no como añadidos posteriores.

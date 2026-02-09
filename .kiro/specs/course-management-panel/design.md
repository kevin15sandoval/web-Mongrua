# Design Document - Panel de Gestión de Cursos

## Overview

El Panel de Gestión de Cursos es una aplicación web integrada que proporciona una interfaz amigable para gestionar los próximos cursos sin necesidad de acceder al panel completo de WordPress. La solución se integra seamlessly con el tema existente y utiliza los campos ACF ya configurados para mantener compatibilidad con la funcionalidad actual.

## Architecture

### Arquitectura General
```
Frontend (Sitio Web)
├── Botón de Acceso Discreto
├── Modal de Login
└── Panel de Gestión
    ├── Lista de Cursos
    ├── Formulario de Edición
    └── Vista Previa en Tiempo Real

Backend (WordPress)
├── Endpoint de Autenticación
├── API de Gestión de Cursos
├── Validación y Seguridad
└── Integración con ACF
```

### Flujo de Datos
1. **Acceso**: Usuario hace clic en botón → Modal de login → Autenticación
2. **Gestión**: Panel carga cursos existentes → Usuario edita → Validación → Guardado en ACF
3. **Vista Previa**: Cambios en formulario → Actualización en tiempo real → Renderizado de vista previa

## Components and Interfaces

### Frontend Components

#### 1. Access Button Component
- **Ubicación**: Footer del sitio (discreto)
- **Funcionalidad**: Trigger para abrir modal de login
- **Estilos**: Minimalista, integrado con el diseño existente

#### 2. Login Modal Component
- **Campos**: Usuario, Contraseña
- **Validación**: Credenciales de WordPress
- **Seguridad**: CSRF protection, rate limiting

#### 3. Course Management Panel
- **Layout**: Sidebar con lista de cursos + área principal de edición
- **Responsivo**: Adaptable a móviles y tablets
- **Estado**: Manejo de loading, errores, y confirmaciones

#### 4. Course Form Component
- **Campos**: Nombre, Descripción, Fecha, Duración, Modalidad, Categoría, Imagen
- **Validación**: Tiempo real con feedback visual
- **Auto-guardado**: Prevención de pérdida de datos

#### 5. Live Preview Component
- **Renderizado**: Réplica exacta del frontend
- **Actualización**: En tiempo real con debounce
- **Estados**: Con imagen, sin imagen, datos incompletos

### Backend Interfaces

#### 1. Authentication API
```php
POST /wp-json/mongruas/v1/auth/login
POST /wp-json/mongruas/v1/auth/verify
POST /wp-json/mongruas/v1/auth/logout
```

#### 2. Course Management API
```php
GET    /wp-json/mongruas/v1/courses
POST   /wp-json/mongruas/v1/courses
PUT    /wp-json/mongruas/v1/courses/{id}
DELETE /wp-json/mongruas/v1/courses/{id}
POST   /wp-json/mongruas/v1/courses/reorder
```

#### 3. Media Upload API
```php
POST /wp-json/mongruas/v1/media/upload
```

## Data Models

### Course Model
```javascript
{
  id: number,           // 1, 2, or 3 (course slot)
  name: string,         // course_X_name
  description: string,  // course_X_description
  date: string,         // course_X_date
  duration: string,     // course_X_duration
  modality: string,     // course_X_modality
  category: string,     // course_X_category
  image: {              // course_X_image
    id: number,
    url: string,
    alt: string
  },
  isActive: boolean,    // derived from name presence
  lastModified: timestamp
}
```

### User Session Model
```javascript
{
  userId: number,
  username: string,
  capabilities: array,
  nonce: string,
  expiresAt: timestamp,
  isAuthenticated: boolean
}
```

### API Response Model
```javascript
{
  success: boolean,
  data: any,
  message: string,
  errors: array,
  timestamp: timestamp
}
```

## Correctness Properties

*A property is a characteristic or behavior that should hold true across all valid executions of a system-essentially, a formal statement about what the system should do. Properties serve as the bridge between human-readable specifications and machine-verifiable correctness guarantees.*

### Property Reflection

After reviewing all properties identified in the prework, I've identified the following consolidations:
- Properties 1.3, 1.4, 1.5, and 5.1 all relate to authentication and can be combined into comprehensive authentication properties
- Properties 2.2, 2.3, and 5.3 all relate to data validation and storage and can be consolidated
- Properties 3.1, 3.2, 3.3, and 3.4 all relate to live preview functionality and can be combined
- Properties 4.2, 4.3, and 4.4 all relate to course management operations and can be consolidated

### Authentication and Access Control

**Property 1: Authentication validation**
*For any* user credentials, the system should authenticate if and only if the credentials are valid WordPress admin credentials
**Validates: Requirements 1.3, 1.4, 5.1**

**Property 2: Admin access control**
*For any* authenticated user, the system should grant full panel access if and only if the user has WordPress administrator capabilities
**Validates: Requirements 1.5**

### Data Management and Persistence

**Property 3: Course data round-trip consistency**
*For any* valid course data, saving to ACF and then loading should return equivalent course information
**Validates: Requirements 2.3, 5.3**

**Property 4: Data validation consistency**
*For any* course data input, the system should accept the data if and only if it passes all validation rules
**Validates: Requirements 2.2**

### Live Preview Functionality

**Property 5: Preview synchronization**
*For any* course data changes, the live preview should immediately reflect the exact appearance that would be shown on the frontend
**Validates: Requirements 3.1, 3.2, 3.3, 3.4**

### Course Management Operations

**Property 6: Course operation consistency**
*For any* course management operation (create, update, delete, reorder), the system state should reflect the operation and maintain data integrity
**Validates: Requirements 4.2, 4.3, 4.4**

**Property 7: Image processing reliability**
*For any* valid image upload, the system should successfully process, store, and make the image available for use in courses
**Validates: Requirements 2.4**

## Error Handling

### Client-Side Error Handling
- **Network Errors**: Retry mechanism with exponential backoff
- **Validation Errors**: Inline feedback with clear messaging
- **Session Expiry**: Automatic re-authentication prompt
- **Upload Errors**: Progress indication and error recovery

### Server-Side Error Handling
- **Authentication Failures**: Rate limiting and security logging
- **Data Validation**: Comprehensive validation with detailed error messages
- **File Upload**: Size limits, type validation, and security scanning
- **Database Errors**: Transaction rollback and data integrity checks

### Error Recovery
- **Auto-save**: Periodic saving of form data to prevent loss
- **Offline Support**: Basic functionality when connection is lost
- **Data Recovery**: Ability to restore unsaved changes
- **Graceful Degradation**: Fallback to basic functionality if advanced features fail

## Testing Strategy

### Dual Testing Approach

The testing strategy combines unit testing and property-based testing to ensure comprehensive coverage:

- **Unit tests** verify specific examples, edge cases, and error conditions
- **Property tests** verify universal properties that should hold across all inputs
- Together they provide comprehensive coverage: unit tests catch concrete bugs, property tests verify general correctness

### Unit Testing

Unit tests will cover:
- Specific authentication scenarios (valid/invalid credentials)
- Form validation with known good/bad inputs
- API endpoint responses with mock data
- UI component rendering with sample data
- Error handling with simulated failures

### Property-Based Testing

Property-based testing will use **fast-check** (JavaScript property testing library) with a minimum of 100 iterations per test. Each property-based test will be tagged with comments explicitly referencing the correctness property from this design document using the format: **Feature: course-management-panel, Property {number}: {property_text}**

Property tests will cover:
- Authentication with generated credential combinations
- Course data validation with random valid/invalid inputs
- Live preview consistency with various course configurations
- API responses with generated data sets
- Image processing with different file types and sizes

### Integration Testing

- End-to-end user workflows
- WordPress integration points
- ACF field synchronization
- Security boundary testing
- Performance under load

### Security Testing

- Authentication bypass attempts
- CSRF protection validation
- Input sanitization verification
- File upload security scanning
- Session management testing
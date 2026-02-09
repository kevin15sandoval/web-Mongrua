# Panel de Gestión de Cursos - Documentación Técnica

## Tabla de Contenidos

1. [Arquitectura del Sistema](#arquitectura-del-sistema)
2. [APIs y Endpoints](#apis-y-endpoints)
3. [Estructura de Código](#estructura-de-código)
4. [Base de Datos](#base-de-datos)
5. [Seguridad Técnica](#seguridad-técnica)
6. [Frontend](#frontend)
7. [Backend](#backend)
8. [Testing](#testing)
9. [Deployment](#deployment)
10. [Mantenimiento](#mantenimiento)

## Arquitectura del Sistema

### Visión General

El Panel de Gestión de Cursos sigue una arquitectura de separación de responsabilidades:

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Frontend      │    │   WordPress     │    │   Database      │
│   (JavaScript)  │◄──►│   REST API      │◄──►│   (MySQL)       │
│                 │    │   (PHP)         │    │                 │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         │                       │                       │
    ┌─────────┐            ┌─────────┐            ┌─────────┐
    │   UI    │            │   ACF   │            │  wp_    │
    │ Modal   │            │ Fields  │            │ options │
    └─────────┘            └─────────┘            └─────────┘
```

### Componentes Principales

1. **Frontend Controller**: Gestiona la interfaz de usuario
2. **REST API**: Maneja comunicación cliente-servidor
3. **Security Layer**: Implementa autenticación y autorización
4. **Data Layer**: Integración con ACF y WordPress
5. **Validation Layer**: Validación de datos en ambos extremos

## APIs y Endpoints

### Estructura Base

Todos los endpoints siguen el patrón:
```
/wp-json/mongruas/v1/{resource}/{action}
```

### Endpoints de Autenticación

#### POST /wp-json/mongruas/v1/auth/login
**Propósito**: Autenticar usuario con credenciales de WordPress

**Request**:
```json
{
  "username": "string",
  "password": "string"
}
```

**Response Success (200)**:
```json
{
  "success": true,
  "data": {
    "user_id": 1,
    "username": "admin",
    "nonce": "abc123...",
    "capabilities": ["administrator"]
  },
  "message": "Login exitoso"
}
```

**Response Error (401)**:
```json
{
  "success": false,
  "data": null,
  "message": "Credenciales inválidas",
  "error_code": "AUTH_001"
}
```

#### POST /wp-json/mongruas/v1/auth/verify
**Propósito**: Verificar validez de sesión actual

**Headers**:
```
X-WP-Nonce: {nonce_token}
```

**Response Success (200)**:
```json
{
  "success": true,
  "data": {
    "valid": true,
    "expires_at": "2024-12-16T18:30:00Z"
  }
}
```

#### POST /wp-json/mongruas/v1/auth/logout
**Propósito**: Cerrar sesión y limpiar tokens

**Headers**:
```
X-WP-Nonce: {nonce_token}
```

**Response Success (200)**:
```json
{
  "success": true,
  "message": "Sesión cerrada exitosamente"
}
```

### Endpoints de Cursos

#### GET /wp-json/mongruas/v1/courses
**Propósito**: Obtener todos los cursos

**Headers**:
```
X-WP-Nonce: {nonce_token}
```

**Response Success (200)**:
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Seguridad Industrial",
      "description": "Curso completo de seguridad...",
      "date": "2024-01-15",
      "duration": "40 horas",
      "modality": "Presencial",
      "category": "Prevención",
      "image": {
        "id": 123,
        "url": "https://example.com/image.jpg",
        "alt": "Imagen del curso"
      },
      "isActive": true,
      "lastModified": "2024-12-16T10:30:00Z"
    }
  ]
}
```

#### POST /wp-json/mongruas/v1/courses
**Propósito**: Crear nuevo curso

**Headers**:
```
X-WP-Nonce: {nonce_token}
Content-Type: application/json
```

**Request**:
```json
{
  "id": 1,
  "name": "Nuevo Curso",
  "description": "Descripción del curso",
  "date": "2024-02-01",
  "duration": "20 horas",
  "modality": "Online",
  "category": "Formación"
}
```

#### PUT /wp-json/mongruas/v1/courses/{id}
**Propósito**: Actualizar curso existente

**Parameters**:
- `id`: ID del curso (1, 2, o 3)

**Request**: Mismo formato que POST

#### DELETE /wp-json/mongruas/v1/courses/{id}
**Propósito**: Eliminar curso

**Response Success (200)**:
```json
{
  "success": true,
  "message": "Curso eliminado exitosamente"
}
```

### Endpoints de Media

#### POST /wp-json/mongruas/v1/media/upload
**Propósito**: Subir imagen para curso

**Headers**:
```
X-WP-Nonce: {nonce_token}
Content-Type: multipart/form-data
```

**Request**:
```
file: [binary_data]
course_id: 1
```

**Response Success (200)**:
```json
{
  "success": true,
  "data": {
    "id": 456,
    "url": "https://example.com/uploads/2024/12/image.jpg",
    "alt": "Imagen del curso",
    "size": 1024000
  }
}
```

## Estructura de Código

### Arquitectura PHP

```php
<?php
/**
 * Estructura principal del controlador
 */
class Mongruas_Course_Management_Panel {
    
    // Propiedades
    private $security;
    private $validator;
    private $api_version = 'v1';
    
    // Constructor y inicialización
    public function __construct() {
        $this->security = new Mongruas_Security_Config();
        $this->validator = new Mongruas_Data_Validator();
        $this->init_hooks();
    }
    
    // Hooks de WordPress
    private function init_hooks() {
        add_action('init', array($this, 'init'));
        add_action('rest_api_init', array($this, 'register_rest_endpoints'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
    }
    
    // Registro de endpoints REST
    public function register_rest_endpoints() {
        // Endpoints de autenticación
        register_rest_route('mongruas/v1', '/auth/login', array(
            'methods' => 'POST',
            'callback' => array($this, 'handle_login'),
            'permission_callback' => '__return_true'
        ));
        
        // Endpoints de cursos
        register_rest_route('mongruas/v1', '/courses', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_courses'),
            'permission_callback' => array($this, 'check_admin_permission')
        ));
    }
}
```

### Arquitectura JavaScript

```javascript
/**
 * Estructura principal del frontend
 */
const CourseManagementPanel = {
    
    // Estado de la aplicación
    state: {
        isAuthenticated: false,
        currentCourse: null,
        courses: [],
        isLoading: false
    },
    
    // Configuración
    config: {
        apiBase: '/wp-json/mongruas/v1',
        autoSaveInterval: 30000,
        previewDebounce: 1000
    },
    
    // Inicialización
    init() {
        this.cacheElements();
        this.bindEvents();
        this.checkAuthentication();
    },
    
    // Gestión de API
    api: {
        async request(endpoint, options = {}) {
            const url = `${CourseManagementPanel.config.apiBase}${endpoint}`;
            const defaultOptions = {
                headers: {
                    'X-WP-Nonce': wpApiSettings.nonce,
                    'Content-Type': 'application/json'
                }
            };
            
            return fetch(url, { ...defaultOptions, ...options });
        }
    }
};
```

## Base de Datos

### Integración con ACF

El sistema utiliza Advanced Custom Fields para almacenar datos:

```php
// Estructura de campos ACF
$course_fields = array(
    'course_1_name' => 'text',
    'course_1_description' => 'textarea', 
    'course_1_date' => 'date_picker',
    'course_1_duration' => 'text',
    'course_1_modality' => 'select',
    'course_1_category' => 'text',
    'course_1_image' => 'image'
);
```

### Operaciones de Datos

```php
/**
 * Obtener datos de curso
 */
public function get_course_data($course_id) {
    $page_id = get_option('page_on_front');
    
    return array(
        'id' => $course_id,
        'name' => get_field("course_{$course_id}_name", $page_id),
        'description' => get_field("course_{$course_id}_description", $page_id),
        'date' => get_field("course_{$course_id}_date", $page_id),
        'duration' => get_field("course_{$course_id}_duration", $page_id),
        'modality' => get_field("course_{$course_id}_modality", $page_id),
        'category' => get_field("course_{$course_id}_category", $page_id),
        'image' => get_field("course_{$course_id}_image", $page_id)
    );
}

/**
 * Guardar datos de curso
 */
public function save_course_data($course_id, $data) {
    $page_id = get_option('page_on_front');
    
    foreach ($data as $field => $value) {
        update_field("course_{$course_id}_{$field}", $value, $page_id);
    }
    
    return true;
}
```

## Seguridad Técnica

### Implementación de CSRF

```php
/**
 * Verificación de nonce en cada request
 */
public function check_admin_permission($request) {
    // Verificar nonce
    $nonce = $request->get_header('X-WP-Nonce');
    if (!wp_verify_nonce($nonce, 'mongruas-panel-nonce')) {
        return new WP_Error('invalid_nonce', 'Token de seguridad inválido', 
                           array('status' => 403));
    }
    
    // Verificar permisos de usuario
    if (!current_user_can('administrator')) {
        return new WP_Error('insufficient_permissions', 'Permisos insuficientes', 
                           array('status' => 403));
    }
    
    return true;
}
```

### Rate Limiting

```php
/**
 * Implementación de rate limiting
 */
private function is_rate_limited($username) {
    $transient_key = 'mongruas_login_failures_' . md5($username);
    $failures = get_transient($transient_key);
    
    if ($failures && $failures >= 5) {
        return true;
    }
    
    return false;
}

private function record_login_failure($username) {
    $transient_key = 'mongruas_login_failures_' . md5($username);
    $failures = get_transient($transient_key) ?: 0;
    $failures++;
    
    set_transient($transient_key, $failures, 15 * MINUTE_IN_SECONDS);
}
```

### Validación de Datos

```php
/**
 * Validador de datos de curso
 */
public static function validate_course_data($data) {
    $errors = array();
    
    // Validar nombre
    if (empty($data['name']) || strlen($data['name']) > 100) {
        $errors['name'] = 'Nombre requerido (máximo 100 caracteres)';
    }
    
    // Validar descripción
    if (empty($data['description']) || strlen($data['description']) > 500) {
        $errors['description'] = 'Descripción requerida (máximo 500 caracteres)';
    }
    
    // Validar fecha
    if (empty($data['date']) || !strtotime($data['date'])) {
        $errors['date'] = 'Fecha válida requerida';
    }
    
    // Sanitizar datos
    $sanitized = array(
        'name' => sanitize_text_field($data['name']),
        'description' => wp_kses_post($data['description']),
        'date' => sanitize_text_field($data['date']),
        'duration' => sanitize_text_field($data['duration']),
        'modality' => sanitize_text_field($data['modality']),
        'category' => sanitize_text_field($data['category'])
    );
    
    return array(
        'valid' => empty($errors),
        'errors' => $errors,
        'data' => $sanitized
    );
}
```

---

*Continúa en la siguiente sección...*
## Frontend

### Gestión de Estado

```javascript
/**
 * Sistema de gestión de estado
 */
const StateManager = {
    state: {
        isAuthenticated: false,
        currentCourse: null,
        courses: [],
        isLoading: false,
        hasUnsavedChanges: false
    },
    
    setState(newState) {
        this.state = { ...this.state, ...newState };
        this.notifySubscribers();
    },
    
    subscribers: [],
    
    subscribe(callback) {
        this.subscribers.push(callback);
    },
    
    notifySubscribers() {
        this.subscribers.forEach(callback => callback(this.state));
    }
};
```

### Componentes UI

```javascript
/**
 * Componente de formulario de curso
 */
const CourseForm = {
    
    render(course = {}) {
        return `
            <form id="course-form" class="course-form">
                <div class="form-group">
                    <label for="course-name">Nombre del Curso</label>
                    <input type="text" id="course-name" name="name" 
                           value="${course.name || ''}" 
                           maxlength="100" required>
                    <div class="validation-message"></div>
                </div>
                
                <div class="form-group">
                    <label for="course-description">Descripción</label>
                    <textarea id="course-description" name="description" 
                              maxlength="500" required>${course.description || ''}</textarea>
                    <div class="validation-message"></div>
                </div>
                
                <div class="form-group">
                    <label for="course-date">Fecha</label>
                    <input type="date" id="course-date" name="date" 
                           value="${course.date || ''}" required>
                    <div class="validation-message"></div>
                </div>
                
                <!-- Más campos... -->
            </form>
        `;
    },
    
    bindEvents() {
        const form = document.getElementById('course-form');
        
        // Validación en tiempo real
        form.addEventListener('input', this.handleInput.bind(this));
        
        // Auto-guardado
        form.addEventListener('change', this.handleAutoSave.bind(this));
    },
    
    handleInput(event) {
        const field = event.target;
        this.validateField(field);
        this.updatePreview();
    },
    
    validateField(field) {
        const value = field.value.trim();
        const name = field.name;
        let isValid = true;
        let message = '';
        
        switch (name) {
            case 'name':
                if (!value) {
                    isValid = false;
                    message = 'El nombre es requerido';
                } else if (value.length > 100) {
                    isValid = false;
                    message = 'Máximo 100 caracteres';
                }
                break;
                
            case 'description':
                if (!value) {
                    isValid = false;
                    message = 'La descripción es requerida';
                } else if (value.length > 500) {
                    isValid = false;
                    message = 'Máximo 500 caracteres';
                }
                break;
        }
        
        this.showValidationMessage(field, isValid, message);
        return isValid;
    }
};
```

### Sistema de Vista Previa

```javascript
/**
 * Componente de vista previa en tiempo real
 */
const LivePreview = {
    
    updateTimer: null,
    
    update(courseData) {
        // Debounce para optimizar rendimiento
        clearTimeout(this.updateTimer);
        this.updateTimer = setTimeout(() => {
            this.render(courseData);
        }, 1000);
    },
    
    render(course) {
        const previewContainer = document.getElementById('course-preview');
        
        if (!course.name) {
            previewContainer.innerHTML = this.renderEmptyState();
            return;
        }
        
        previewContainer.innerHTML = `
            <div class="course-preview-card">
                ${course.image ? 
                    `<img src="${course.image.url}" alt="${course.image.alt}" class="course-image">` :
                    '<div class="course-image-placeholder">Sin imagen</div>'
                }
                <div class="course-content">
                    <h3 class="course-title">${course.name}</h3>
                    <p class="course-description">${course.description}</p>
                    <div class="course-meta">
                        <span class="course-date">${this.formatDate(course.date)}</span>
                        <span class="course-duration">${course.duration}</span>
                        <span class="course-modality">${course.modality}</span>
                    </div>
                </div>
            </div>
        `;
    },
    
    renderEmptyState() {
        return `
            <div class="preview-empty-state">
                <p>Completa los campos para ver la vista previa</p>
            </div>
        `;
    }
};
```

## Backend

### Controlador Principal

```php
<?php
/**
 * Controlador principal del panel
 */
class Mongruas_Course_Management_Panel {
    
    private $security;
    private $validator;
    
    public function __construct() {
        $this->security = new Mongruas_Security_Config();
        $this->validator = new Mongruas_Data_Validator();
        
        $this->init_hooks();
    }
    
    /**
     * Manejo de login
     */
    public function handle_login($request) {
        $username = sanitize_user($request->get_param('username'));
        $password = $request->get_param('password');
        
        // Verificar rate limiting
        if ($this->security->is_rate_limited($username)) {
            return new WP_Error('rate_limited', 
                'Demasiados intentos. Intenta en 15 minutos.', 
                array('status' => 429));
        }
        
        // Autenticar usuario
        $user = wp_authenticate($username, $password);
        
        if (is_wp_error($user)) {
            $this->security->record_login_failure($username);
            return new WP_Error('auth_failed', 'Credenciales inválidas', 
                               array('status' => 401));
        }
        
        // Verificar permisos
        if (!user_can($user, 'administrator')) {
            return new WP_Error('insufficient_permissions', 
                'Permisos insuficientes', array('status' => 403));
        }
        
        // Establecer sesión
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID);
        
        return array(
            'success' => true,
            'data' => array(
                'user_id' => $user->ID,
                'username' => $user->user_login,
                'nonce' => wp_create_nonce('mongruas-panel-nonce'),
                'capabilities' => array_keys($user->caps)
            )
        );
    }
    
    /**
     * Obtener cursos
     */
    public function get_courses($request) {
        $page_id = get_option('page_on_front');
        $courses = array();
        
        for ($i = 1; $i <= 3; $i++) {
            $course_data = $this->get_course_data($i);
            if ($course_data) {
                $courses[] = $course_data;
            }
        }
        
        return array(
            'success' => true,
            'data' => $courses
        );
    }
    
    /**
     * Crear/actualizar curso
     */
    public function save_course($request) {
        $course_id = intval($request->get_param('id'));
        $data = $request->get_json_params();
        
        // Validar datos
        $validation = $this->validator->validate_course_data($data);
        
        if (!$validation['valid']) {
            return new WP_Error('validation_failed', 'Datos inválidos', 
                               array('status' => 400, 'errors' => $validation['errors']));
        }
        
        // Guardar en ACF
        $page_id = get_option('page_on_front');
        
        foreach ($validation['data'] as $field => $value) {
            update_field("course_{$course_id}_{$field}", $value, $page_id);
        }
        
        // Log de actividad
        error_log("Curso {$course_id} actualizado por usuario " . get_current_user_id());
        
        return array(
            'success' => true,
            'data' => $this->get_course_data($course_id),
            'message' => 'Curso guardado exitosamente'
        );
    }
}
```

### Configuración de Seguridad

```php
<?php
/**
 * Configuraciones de seguridad
 */
class Mongruas_Security_Config {
    
    const MAX_LOGIN_ATTEMPTS = 5;
    const LOCKOUT_DURATION = 15 * MINUTE_IN_SECONDS;
    
    public function __construct() {
        add_action('init', array($this, 'setup_security_headers'));
        add_filter('wp_headers', array($this, 'add_security_headers'));
    }
    
    /**
     * Headers de seguridad
     */
    public function add_security_headers($headers) {
        $headers['X-Content-Type-Options'] = 'nosniff';
        $headers['X-Frame-Options'] = 'SAMEORIGIN';
        $headers['X-XSS-Protection'] = '1; mode=block';
        $headers['Referrer-Policy'] = 'strict-origin-when-cross-origin';
        
        return $headers;
    }
    
    /**
     * Verificar rate limiting
     */
    public function is_rate_limited($username) {
        $transient_key = 'mongruas_login_failures_' . md5($username);
        $failures = get_transient($transient_key);
        
        return $failures && $failures >= self::MAX_LOGIN_ATTEMPTS;
    }
    
    /**
     * Registrar intento fallido
     */
    public function record_login_failure($username) {
        $transient_key = 'mongruas_login_failures_' . md5($username);
        $failures = get_transient($transient_key) ?: 0;
        $failures++;
        
        set_transient($transient_key, $failures, self::LOCKOUT_DURATION);
        
        // Log del intento
        error_log("Login fallido para usuario: {$username} (Intento {$failures})");
    }
}
```

## Testing

### Tests Unitarios

```php
<?php
/**
 * Tests básicos del panel
 */
class Test_Course_Panel extends WP_UnitTestCase {
    
    private $panel;
    
    public function setUp() {
        parent::setUp();
        $this->panel = new Mongruas_Course_Management_Panel();
    }
    
    /**
     * Test de validación de datos
     */
    public function test_course_data_validation() {
        $valid_data = array(
            'name' => 'Curso de Prueba',
            'description' => 'Descripción del curso de prueba',
            'date' => '2024-12-20',
            'duration' => '40 horas',
            'modality' => 'Presencial',
            'category' => 'Formación'
        );
        
        $validation = Mongruas_Data_Validator::validate_course_data($valid_data);
        
        $this->assertTrue($validation['valid']);
        $this->assertEmpty($validation['errors']);
    }
    
    /**
     * Test de datos inválidos
     */
    public function test_invalid_course_data() {
        $invalid_data = array(
            'name' => '', // Nombre vacío
            'description' => str_repeat('a', 501), // Muy largo
            'date' => 'fecha-inválida'
        );
        
        $validation = Mongruas_Data_Validator::validate_course_data($invalid_data);
        
        $this->assertFalse($validation['valid']);
        $this->assertNotEmpty($validation['errors']);
    }
    
    /**
     * Test de autenticación
     */
    public function test_authentication_required() {
        $request = new WP_REST_Request('GET', '/mongruas/v1/courses');
        
        $response = $this->panel->check_admin_permission($request);
        
        $this->assertInstanceOf('WP_Error', $response);
    }
}
```

### Tests de Integración

```php
<?php
/**
 * Tests de integración con WordPress
 */
function run_integration_tests() {
    $results = array();
    
    // Test 1: Verificar que ACF está activo
    $results['acf_active'] = function_exists('get_field');
    
    // Test 2: Verificar campos ACF
    $page_id = get_option('page_on_front');
    $results['acf_fields'] = array();
    
    for ($i = 1; $i <= 3; $i++) {
        $results['acf_fields'][$i] = array(
            'name' => get_field("course_{$i}_name", $page_id) !== null,
            'description' => get_field("course_{$i}_description", $page_id) !== null,
            'date' => get_field("course_{$i}_date", $page_id) !== null
        );
    }
    
    // Test 3: Verificar endpoints REST
    $rest_server = rest_get_server();
    $routes = $rest_server->get_routes();
    
    $results['rest_endpoints'] = array(
        'auth_login' => isset($routes['/mongruas/v1/auth/login']),
        'courses' => isset($routes['/mongruas/v1/courses']),
        'media_upload' => isset($routes['/mongruas/v1/media/upload'])
    );
    
    return $results;
}
```

## Deployment

### Checklist de Deployment

```bash
# 1. Verificar requisitos del servidor
php -v  # >= 7.4
mysql --version  # >= 5.6

# 2. Verificar permisos de archivos
chmod 755 wp-content/themes/mongruas-theme/
chmod 644 wp-content/themes/mongruas-theme/inc/*.php
chmod 644 wp-content/themes/mongruas-theme/assets/css/*.css
chmod 644 wp-content/themes/mongruas-theme/assets/js/*.js

# 3. Verificar configuración SSL
openssl s_client -connect domain.com:443 -servername domain.com

# 4. Ejecutar tests
wp eval "do_action('mongruas_run_tests');"
```

### Configuración de Producción

```php
// wp-config.php para producción
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', false);

// Seguridad adicional
define('FORCE_SSL_ADMIN', true);
define('DISALLOW_FILE_EDIT', true);
define('DISALLOW_FILE_MODS', true);

// Optimización
define('WP_CACHE', true);
define('COMPRESS_CSS', true);
define('COMPRESS_SCRIPTS', true);
```

## Mantenimiento

### Monitoreo Automático

```php
/**
 * Sistema de monitoreo
 */
class Mongruas_Monitor {
    
    public function __construct() {
        add_action('wp_loaded', array($this, 'check_system_health'));
        add_action('mongruas_daily_check', array($this, 'daily_health_check'));
    }
    
    public function check_system_health() {
        $checks = array(
            'wordpress_version' => $this->check_wordpress_version(),
            'php_version' => $this->check_php_version(),
            'ssl_certificate' => $this->check_ssl_certificate(),
            'file_permissions' => $this->check_file_permissions(),
            'database_connection' => $this->check_database_connection()
        );
        
        foreach ($checks as $check => $result) {
            if (!$result['status']) {
                $this->alert_admin($check, $result['message']);
            }
        }
    }
    
    private function alert_admin($check, $message) {
        $admin_email = get_option('admin_email');
        $subject = 'Alerta del Sistema - Panel de Cursos';
        $body = "Se detectó un problema: {$check}\n\nDetalles: {$message}";
        
        wp_mail($admin_email, $subject, $body);
    }
}
```

### Logs y Debugging

```php
/**
 * Sistema de logs personalizado
 */
class Mongruas_Logger {
    
    const LOG_LEVEL_ERROR = 1;
    const LOG_LEVEL_WARNING = 2;
    const LOG_LEVEL_INFO = 3;
    const LOG_LEVEL_DEBUG = 4;
    
    public static function log($message, $level = self::LOG_LEVEL_INFO, $context = array()) {
        if (!WP_DEBUG_LOG) {
            return;
        }
        
        $timestamp = current_time('Y-m-d H:i:s');
        $level_name = self::get_level_name($level);
        $user_id = get_current_user_id();
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        
        $log_entry = sprintf(
            "[%s] %s: %s (User: %d, IP: %s)",
            $timestamp,
            $level_name,
            $message,
            $user_id,
            $ip
        );
        
        if (!empty($context)) {
            $log_entry .= ' Context: ' . json_encode($context);
        }
        
        error_log($log_entry);
    }
    
    private static function get_level_name($level) {
        switch ($level) {
            case self::LOG_LEVEL_ERROR: return 'ERROR';
            case self::LOG_LEVEL_WARNING: return 'WARNING';
            case self::LOG_LEVEL_INFO: return 'INFO';
            case self::LOG_LEVEL_DEBUG: return 'DEBUG';
            default: return 'UNKNOWN';
        }
    }
}
```

---

## Recursos Adicionales

### Herramientas de Desarrollo

- **WordPress CLI**: Para automatización y testing
- **PHPUnit**: Para tests unitarios
- **ESLint**: Para calidad de código JavaScript
- **PHPCS**: Para estándares de código PHP

### Documentación de Referencia

- [WordPress REST API Handbook](https://developer.wordpress.org/rest-api/)
- [Advanced Custom Fields Documentation](https://www.advancedcustomfields.com/resources/)
- [WordPress Security Best Practices](https://wordpress.org/support/article/hardening-wordpress/)

---

**Última actualización**: Diciembre 2024  
**Versión de la API**: v1.0.0
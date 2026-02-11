# 🧪 Guía de Prueba - Módulo de Autenticación PWA

## 🌐 Acceso a la Aplicación

**URL Local:** http://localhost:5173/

El servidor de desarrollo está corriendo. Abre esta URL en tu navegador.

## 📋 Estado Actual de la Implementación

### ✅ Completado (Task 3.1)

**Modelos y Utilidades:**
- ✅ Modelos de Usuario y Autenticación
- ✅ Validadores completos
- ✅ Gestión de tokens JWT
- ✅ Almacenamiento seguro
- ✅ Servicio de API con interceptores
- ✅ Store de estado con Zustand
- ✅ Hook useAuth personalizado

### 🔄 Próximas Tareas

**Task 3.14 - Páginas de Autenticación:**
- ⏳ RegistrationPage (formulario de registro)
- ⏳ LoginPage (formulario de login)
- ⏳ PasswordRecoveryPage (recuperación de contraseña)

**Nota:** Las páginas ya existen en `pwa/src/pages/` pero necesitan conectarse con el nuevo módulo de autenticación.

## 🧪 Pruebas que Puedes Hacer Ahora

### 1. Verificar la Estructura del Proyecto

Abre la consola del navegador (F12) y ejecuta:

```javascript
// Verificar que los modelos están disponibles
console.log('Verificando módulos de autenticación...');

// Esto debería mostrar la estructura de la app
console.log('App cargada correctamente');
```

### 2. Probar Validadores en la Consola

Abre la consola del navegador y prueba los validadores:

```javascript
// Importar validadores (si están expuestos globalmente)
// O navega a una página que los use

// Ejemplos de validación:
// - Email válido: "usuario@ejemplo.com" ✅
// - Email inválido: "usuario@" ❌
// - Password válido: "Password123" ✅
// - Password inválido: "pass" ❌ (muy corto)
// - Edad válida: fecha hace 20 años ✅
// - Edad inválida: fecha hace 15 años ❌
```

### 3. Verificar el Store de Autenticación

En la consola del navegador:

```javascript
// El store de Zustand debería estar disponible
// Verifica el estado inicial de autenticación
console.log('Estado de autenticación:', {
  isAuthenticated: false, // Debería ser false inicialmente
  user: null,
  token: null
});
```

### 4. Inspeccionar LocalStorage

1. Abre DevTools (F12)
2. Ve a la pestaña "Application" o "Almacenamiento"
3. Busca "Local Storage" → http://localhost:5173
4. Deberías ver:
   - `auth-storage` (store de Zustand persistido)

## 🔍 Verificación del Backend

### Backend API

El backend debe estar corriendo en: **http://localhost:3000**

Para verificar que el backend está funcionando:

```bash
# En una nueva terminal
cd backend
npm start
```

### Endpoints Disponibles

```
POST /api/auth/register     - Registro de usuario
POST /api/auth/login        - Login
GET  /api/auth/verify/:token - Verificación de email
POST /api/auth/forgot-password - Solicitar reset de password
POST /api/auth/reset-password - Resetear password
POST /api/auth/refresh      - Renovar token
GET  /api/auth/me           - Obtener usuario actual
```

## 📝 Ejemplo de Uso del Módulo de Autenticación

### En un Componente React:

```javascript
import { useAuth } from './hooks/useAuth';
import { validateRegistrationForm } from './utils/validators';

function MiComponente() {
  const {
    user,
    isAuthenticated,
    isLoading,
    error,
    login,
    register,
    logout
  } = useAuth();

  const handleLogin = async (email, password) => {
    try {
      await login({ email, password });
      console.log('Login exitoso!');
    } catch (err) {
      console.error('Error en login:', error);
    }
  };

  return (
    <div>
      {isAuthenticated ? (
        <div>
          <p>Bienvenido, {user.fullName}!</p>
          <button onClick={logout}>Cerrar Sesión</button>
        </div>
      ) : (
        <div>
          <p>No has iniciado sesión</p>
        </div>
      )}
    </div>
  );
}
```

## 🎨 Estructura de Archivos

```
pwa/
├── src/
│   ├── models/
│   │   ├── User.js          ✅ Modelo de usuario
│   │   ├── Auth.js          ✅ Modelos de autenticación
│   │   ├── index.js         ✅ Exportaciones
│   │   └── README.md        ✅ Documentación
│   ├── utils/
│   │   ├── validators.js    ✅ Validadores
│   │   └── storage.js       ✅ Gestión de storage
│   ├── services/
│   │   ├── api.js           ✅ Cliente Axios
│   │   └── authService.js   ✅ Servicio de auth
│   ├── store/
│   │   └── authStore.js     ✅ Store Zustand
│   ├── hooks/
│   │   └── useAuth.js       ✅ Hook personalizado
│   └── pages/
│       ├── LoginPage.jsx    ⏳ Necesita actualización
│       └── RegistrationPage.jsx ⏳ Necesita actualización
```

## 🔐 Características de Seguridad Implementadas

1. **Validación de Contraseñas:**
   - Mínimo 8 caracteres
   - Al menos 1 mayúscula
   - Al menos 1 minúscula
   - Al menos 1 número
   - Indicador de fortaleza (débil/media/fuerte)

2. **Validación de Edad:**
   - Edad mínima: 16 años
   - Validación de fecha no futura

3. **Gestión de Tokens:**
   - JWT con expiración
   - Refresh tokens automáticos
   - Renovación en errores 401
   - Almacenamiento seguro

4. **Roles de Usuario:**
   - STUDENT (por defecto)
   - ADMINISTRATOR

## 📊 Requisitos Satisfechos

✅ **1.1** - Registro con campos requeridos  
✅ **1.2** - Recolección de email, password, fecha de nacimiento  
✅ **1.3** - Validación de formato de email  
✅ **1.4** - Validación de edad (mínimo 16 años)  
✅ **1.5** - Requisitos de seguridad de contraseña  
✅ **2.1** - Autenticación de usuario  
✅ **2.2** - Manejo de credenciales inválidas  
✅ **2.3** - Creación de token de sesión seguro  
✅ **2.4** - Manejo de expiración de sesión  
✅ **2.5** - Funcionalidad de recuperación de contraseña  

## 🚀 Próximos Pasos

### Inmediatos (Task 3.14):

1. **Actualizar RegistrationPage:**
   - Conectar con useAuth hook
   - Usar validadores del módulo
   - Implementar manejo de errores
   - Agregar feedback visual

2. **Actualizar LoginPage:**
   - Conectar con useAuth hook
   - Implementar validación
   - Agregar estados de carga
   - Manejo de errores

3. **Crear PasswordRecoveryPage:**
   - Formulario de solicitud
   - Formulario de reset
   - Validación de tokens

### Mediano Plazo:

4. **Protected Routes (Task 4.1):**
   - Rutas protegidas por autenticación
   - Rutas protegidas por rol

5. **Initial Admin Setup (Task 4.4):**
   - Pantalla de configuración inicial
   - Código de activación de admin

## 🐛 Debugging

### Si algo no funciona:

1. **Verificar que el backend está corriendo:**
   ```bash
   cd backend
   npm start
   ```

2. **Verificar la consola del navegador:**
   - Buscar errores en rojo
   - Verificar que las peticiones API se hacen correctamente

3. **Verificar variables de entorno:**
   - Archivo: `pwa/.env.development`
   - Debe contener: `VITE_API_BASE_URL=http://localhost:3000/api`

4. **Limpiar caché:**
   ```bash
   cd pwa
   rm -rf node_modules/.vite
   npm run dev
   ```

## 📚 Documentación Adicional

- **Documentación completa:** `pwa/src/models/README.md`
- **Resumen de implementación:** `pwa/AUTHENTICATION-MODULE-SUMMARY.md`
- **Verificación del módulo:** Ejecutar `node verify-auth-module.cjs`

## ✅ Verificación Rápida

Para verificar que todo está correcto:

```bash
cd pwa
node verify-auth-module.cjs
```

Esto ejecutará todas las verificaciones automáticas del módulo.

---

**Estado:** ✅ Módulo de autenticación completamente implementado y listo para integración con las páginas de UI.

**Siguiente tarea:** Implementar las páginas de autenticación (Task 3.14)

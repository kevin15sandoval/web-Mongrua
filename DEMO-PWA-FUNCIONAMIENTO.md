# 🎯 Demo - PWA de Certificación de Cursos

## 🌐 Acceso a la Aplicación

**URL:** http://localhost:5173/

El servidor de desarrollo está corriendo. Abre esta URL en tu navegador para ver la PWA.

## 📸 Lo que Verás

### 1. Página de Inicio (Home)

Cuando abras http://localhost:5173/ verás:

**Sección Hero:**
- 🎓 Título: "Sistema de Certificación de Cursos"
- Descripción de la plataforma
- Diseño con gradiente azul

**Sección de Autenticación (si no has iniciado sesión):**
- Botones para "Registrarse" y "Iniciar Sesión"
- 6 tarjetas de características mostrando:
  - ✅ Validación Segura
  - 🔒 Tokens JWT
  - 👥 Roles de Usuario
  - 📧 Verificación de Email
  - 🔄 Recuperación de Contraseña
  - 💾 Almacenamiento Seguro

**Estado de Implementación:**
- ✅ Módulo de Autenticación (Completado)
- 🔄 Páginas de Autenticación (En progreso)
- ⏳ Gestión de Cursos (Pendiente)

### 2. Página de Registro

**URL:** http://localhost:5173/register

Formulario con los siguientes campos:
- Nombre Completo
- Email
- Fecha de Nacimiento
- Contraseña
- Confirmar Contraseña

**Validaciones Activas:**
- ✅ Email debe tener formato válido
- ✅ Contraseña mínimo 8 caracteres, 1 mayúscula, 1 minúscula, 1 número
- ✅ Las contraseñas deben coincidir
- ✅ Edad mínima de 16 años

### 3. Página de Login

**URL:** http://localhost:5173/login

Formulario con:
- Email
- Contraseña
- Botón "Iniciar Sesión"

## 🧪 Pruebas que Puedes Hacer

### Prueba 1: Registro de Usuario

1. Ve a http://localhost:5173/register
2. Llena el formulario con datos válidos:
   ```
   Nombre: Juan Pérez
   Email: juan@ejemplo.com
   Fecha de Nacimiento: 01/01/2000
   Contraseña: Password123
   Confirmar: Password123
   ```
3. Haz clic en "Registrarse"

**Nota:** El backend debe estar corriendo en http://localhost:3000 para que funcione.

### Prueba 2: Validación de Formularios

Intenta registrarte con datos inválidos para ver las validaciones:

**Email inválido:**
- Email: `usuario@` ❌
- Verás: "Email inválido"

**Contraseña débil:**
- Contraseña: `pass` ❌
- Verás: "La contraseña debe tener al menos 8 caracteres..."

**Contraseñas no coinciden:**
- Contraseña: `Password123`
- Confirmar: `Password456` ❌
- Verás: "Las contraseñas no coinciden"

**Edad menor de 16:**
- Fecha: 01/01/2010 ❌
- Verás: "Debes tener al menos 16 años"

### Prueba 3: Login

1. Ve a http://localhost:5173/login
2. Ingresa credenciales (si ya te registraste):
   ```
   Email: juan@ejemplo.com
   Contraseña: Password123
   ```
3. Haz clic en "Iniciar Sesión"

Si el login es exitoso, serás redirigido a la página de inicio y verás:
- Tu nombre de bienvenida
- Tu rol (Estudiante o Administrador)
- Tu email
- Botón para cerrar sesión

### Prueba 4: Navegación

Prueba la navegación entre páginas:
- Inicio → Registro
- Inicio → Login
- Login → Inicio (después de iniciar sesión)

### Prueba 5: Inspeccionar el Store

Abre las DevTools (F12) y ve a la consola:

```javascript
// Ver el estado de autenticación
console.log('LocalStorage:', localStorage.getItem('auth-storage'));
```

Deberías ver el estado persistido del store de Zustand.

## 🎨 Características Visuales

### Diseño Responsive
- ✅ Funciona en móvil, tablet y escritorio
- ✅ Breakpoint en 768px
- ✅ Botones y formularios adaptables

### Tema Oscuro/Claro
- ✅ Detecta automáticamente la preferencia del sistema
- ✅ Variables CSS para fácil personalización

### Animaciones
- ✅ Hover effects en botones y tarjetas
- ✅ Transiciones suaves
- ✅ Transform en hover (translateY)

### Colores
- 🔵 Primario: #646cff (azul)
- ⚫ Secundario: #4a5568 (gris)
- ✅ Éxito: #48bb78 (verde)
- ❌ Error: #f56565 (rojo)
- ⚠️ Advertencia: #ed8936 (naranja)

## 🔧 Backend Requerido

Para que la autenticación funcione completamente, necesitas el backend corriendo:

```bash
# En otra terminal
cd backend
npm start
```

El backend debe estar en: http://localhost:3000

### Endpoints Disponibles:

```
POST /api/auth/register     - Registro de usuario
POST /api/auth/login        - Login
GET  /api/auth/verify/:token - Verificación de email
POST /api/auth/forgot-password - Recuperación de contraseña
POST /api/auth/reset-password - Reset de contraseña
POST /api/auth/refresh      - Renovar token
GET  /api/auth/me           - Usuario actual
```

## 📊 Estado Actual del Proyecto

### ✅ Completado (Task 3.1)

**Módulo de Autenticación:**
- ✅ Modelos de Usuario y Auth
- ✅ Validadores completos
- ✅ Gestión de tokens JWT
- ✅ Almacenamiento seguro
- ✅ Servicio de API con interceptores
- ✅ Store Zustand con persistencia
- ✅ Hook useAuth personalizado
- ✅ Documentación completa

**Páginas Básicas:**
- ✅ HomePage con diseño mejorado
- ✅ LoginPage funcional
- ✅ RegistrationPage funcional

### 🔄 En Progreso

**Mejoras de UI:**
- ⏳ Indicador de fortaleza de contraseña
- ⏳ Mensajes de éxito
- ⏳ Animaciones de carga
- ⏳ Página de recuperación de contraseña

### ⏳ Próximas Tareas

**Task 3.14 - Páginas de Autenticación:**
- Mejorar UI de RegistrationPage
- Mejorar UI de LoginPage
- Crear PasswordRecoveryPage

**Task 4.1 - Rutas Protegidas:**
- ProtectedRoute component
- AdminRoute component
- Redirecciones por rol

**Task 4.4 - Setup Inicial de Admin:**
- InitialAdminSetupPage
- Código de activación

## 🐛 Solución de Problemas

### El servidor no inicia
```bash
cd pwa
npm install
npm run dev
```

### No se ve nada en el navegador
1. Verifica que el servidor esté corriendo
2. Abre http://localhost:5173/
3. Revisa la consola del navegador (F12)

### Los formularios no funcionan
1. Verifica que el backend esté corriendo en http://localhost:3000
2. Revisa la consola del navegador para errores
3. Verifica las variables de entorno en `pwa/.env.development`

### Errores de CORS
El backend debe tener CORS configurado para aceptar peticiones desde http://localhost:5173

## 📚 Documentación

- **Guía de Prueba:** `pwa/GUIA-PRUEBA-MODULO-AUTH.md`
- **Documentación de API:** `pwa/src/models/README.md`
- **Resumen de Implementación:** `pwa/AUTHENTICATION-MODULE-SUMMARY.md`

## 🎉 Resumen

Has implementado exitosamente:
- ✅ Módulo completo de autenticación
- ✅ Validaciones de formularios
- ✅ Gestión de tokens JWT
- ✅ Páginas funcionales de login y registro
- ✅ Diseño responsive y atractivo
- ✅ Store de estado con persistencia

**Siguiente paso:** Conectar con el backend y probar el flujo completo de registro → login → dashboard.

---

**¿Necesitas ayuda?** Revisa la documentación en `pwa/src/models/README.md` o ejecuta `node verify-auth-module.cjs` para verificar la implementación.

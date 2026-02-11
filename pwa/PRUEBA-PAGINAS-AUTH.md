# Guía de Prueba - Páginas de Autenticación

## 🚀 Inicio Rápido

El servidor de desarrollo ya está corriendo en: **http://localhost:5173/**

---

## 📱 Páginas Disponibles

### 1. Página de Login
**URL:** http://localhost:5173/login

**Pruebas:**
- [ ] Ingresar email inválido (sin @) → Ver error "Email inválido"
- [ ] Dejar contraseña vacía → Ver validación HTML5
- [ ] Click en 👁️ → Mostrar/ocultar contraseña
- [ ] Click en "¿Olvidaste tu contraseña?" → Ir a recuperación
- [ ] Click en "Regístrate aquí" → Ir a registro
- [ ] Ingresar credenciales válidas → Login exitoso (si tienes cuenta)

**Credenciales de Prueba (si tienes backend corriendo):**
```
Email: test@example.com
Password: Test1234
```

---

### 2. Página de Registro
**URL:** http://localhost:5173/register

**Pruebas:**
- [ ] Completar todos los campos correctamente
- [ ] Ver indicador de fortaleza de contraseña:
  - Escribir "abc" → 🔴 Débil
  - Escribir "Abc123" → 🟡 Media
  - Escribir "Abc123!@" → 🟢 Fuerte
- [ ] Ingresar contraseñas diferentes → Ver error "Las contraseñas no coinciden"
- [ ] Ingresar fecha de nacimiento reciente → Ver error "Debes tener al menos 16 años"
- [ ] Click en 👁️ → Mostrar/ocultar contraseñas
- [ ] Click en "Inicia sesión aquí" → Ir a login
- [ ] Completar formulario válido → Ver pantalla de éxito → Redirección automática

**Datos de Prueba:**
```
Nombre: Juan Pérez
Email: juan.perez@example.com
Fecha de Nacimiento: 01/01/2000
Contraseña: Test1234
Confirmar: Test1234
```

---

### 3. Página de Recuperación de Contraseña
**URL:** http://localhost:5173/password-recovery

**Pruebas Modo Solicitud:**
- [ ] Ingresar email inválido → Ver error
- [ ] Ingresar email válido → Ver pantalla de éxito
- [ ] Click en "Volver al inicio de sesión" → Ir a login

**Pruebas Modo Reset (con token):**
- [ ] Abrir URL: http://localhost:5173/password-recovery?token=test123
- [ ] Ver formulario de nueva contraseña
- [ ] Ingresar contraseña débil → Ver indicador rojo
- [ ] Ingresar contraseñas diferentes → Ver error
- [ ] Click en 👁️ → Mostrar/ocultar contraseñas
- [ ] Ingresar contraseñas válidas e iguales → Ver pantalla de éxito

---

## 📱 Prueba en Vista Móvil

### Chrome DevTools
1. Presiona **F12** para abrir DevTools
2. Presiona **Ctrl+Shift+M** para toggle device toolbar
3. Selecciona un dispositivo:
   - iPhone 12 Pro
   - Samsung Galaxy S20
   - iPad Air
4. Prueba las interacciones touch

### Responsive Breakpoints
- **Móvil:** < 640px
- **Tablet:** 640px - 1024px
- **Desktop:** > 1024px

---

## ✅ Checklist de Funcionalidades

### LoginPage
- [x] Validación de email en tiempo real
- [x] Toggle mostrar/ocultar contraseña
- [x] Estados de carga con spinner
- [x] Mensajes de error claros
- [x] Enlaces de navegación
- [x] Diseño responsive
- [x] Accesibilidad (labels, aria-labels)

### RegistrationPage
- [x] Validación de todos los campos
- [x] Indicador de fortaleza de contraseña
- [x] Toggle mostrar/ocultar contraseñas
- [x] Confirmación de contraseña
- [x] Validación de edad (16+)
- [x] Pantalla de éxito
- [x] Redirección automática
- [x] Diseño responsive

### PasswordRecoveryPage
- [x] Modo solicitud de recuperación
- [x] Modo restablecimiento con token
- [x] Validación de email
- [x] Indicador de fortaleza de contraseña
- [x] Confirmación de contraseña
- [x] Pantallas de éxito
- [x] Enlaces de navegación
- [x] Diseño responsive

---

## 🎨 Elementos Visuales a Verificar

### Colores
- **Primario:** Azul (#646cff)
- **Éxito:** Verde (#48bb78)
- **Error:** Rojo (#f56565)
- **Advertencia:** Naranja (#ed8936)

### Animaciones
- Transiciones suaves en inputs (focus)
- Spinner de carga rotando
- Hover effects en botones
- Barra de fortaleza animada

### Iconos
- 👁️ / 👁️‍🗨️ Toggle de contraseña
- ✓ Icono de éxito (círculo verde)

---

## 🐛 Casos de Error a Probar

### Errores de Validación
1. Email sin @ → "Email inválido"
2. Contraseña corta → "Debe tener al menos 8 caracteres..."
3. Contraseñas no coinciden → "Las contraseñas no coinciden"
4. Edad menor a 16 → "Debes tener al menos 16 años"
5. Nombre muy corto → "Debe tener al menos 3 caracteres"

### Errores de Backend (si backend está corriendo)
1. Email ya registrado → Ver mensaje del servidor
2. Credenciales incorrectas → "Error al iniciar sesión"
3. Token inválido → "Error al restablecer contraseña"

---

## 🔧 Solución de Problemas

### El servidor no está corriendo
```bash
cd pwa
npm run dev
```

### Los cambios no se reflejan
1. Verifica que el servidor esté corriendo
2. Refresca el navegador (Ctrl+R)
3. Limpia caché (Ctrl+Shift+R)

### Error de CORS
- Verifica que el backend esté corriendo en http://localhost:3000
- Verifica la configuración de CORS en el backend

### Estilos no se aplican
1. Verifica que `index.css` esté importado en `main.jsx`
2. Limpia caché del navegador
3. Reinicia el servidor de desarrollo

---

## 📊 Métricas de Éxito

### Performance
- ✅ Carga inicial < 2 segundos
- ✅ Interacciones instantáneas
- ✅ Animaciones suaves (60fps)

### Usabilidad
- ✅ Formularios intuitivos
- ✅ Mensajes de error claros
- ✅ Feedback visual inmediato
- ✅ Navegación fácil

### Accesibilidad
- ✅ Navegación por teclado
- ✅ Labels asociados
- ✅ Contraste adecuado
- ✅ Tamaños de click grandes

---

## 📝 Notas Importantes

1. **Backend Requerido:** Para probar login/registro real, necesitas el backend corriendo
2. **Tokens JWT:** Se almacenan en localStorage automáticamente
3. **Persistencia:** El estado de autenticación persiste al recargar
4. **Modo Oscuro:** Se adapta automáticamente a las preferencias del sistema

---

## 🎯 Próximos Pasos

Después de probar las páginas de autenticación:
1. Verificar que todo funciona correctamente
2. Probar en diferentes navegadores
3. Probar en dispositivos móviles reales
4. Continuar con la siguiente tarea (4.1 - Protección de rutas)

---

## 💡 Tips de Prueba

- Usa **Chrome DevTools** para inspeccionar elementos
- Prueba con **diferentes tamaños de pantalla**
- Verifica la **consola** para errores
- Prueba la **navegación por teclado** (Tab, Enter)
- Verifica que los **enlaces funcionen** correctamente
- Prueba con **datos inválidos** para ver validaciones

---

¡Disfruta probando las nuevas páginas de autenticación! 🚀

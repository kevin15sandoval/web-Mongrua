# Diseño del Sistema de Gestión de Cursos - Mongruas Formación

## 🎨 Filosofía de Diseño

### Principios Fundamentales
1. **Simplicidad Funcional** - Interfaz limpia que prioriza la usabilidad
2. **Consistencia Visual** - Elementos coherentes en todo el sistema
3. **Responsive First** - Diseño móvil como prioridad
4. **Accesibilidad** - Cumplimiento de estándares WCAG
5. **Feedback Inmediato** - Respuesta visual a todas las acciones del usuario

### Identidad Visual
- **Marca**: Mongruas Formación
- **Personalidad**: Profesional, confiable, moderna
- **Tono**: Serio pero accesible, técnico pero humano

## 🎨 Sistema de Colores

### Paleta Principal
```css
:root {
  /* Colores Primarios */
  --color-primary: #0066cc;           /* Azul Mongruas */
  --color-primary-dark: #0052a3;     /* Azul oscuro */
  --color-primary-darker: #003d7a;   /* Azul muy oscuro */
  
  /* Colores Secundarios */
  --color-success: #28a745;          /* Verde éxito */
  --color-success-light: #20c997;    /* Verde claro */
  --color-warning: #ffc107;          /* Amarillo advertencia */
  --color-danger: #dc3545;           /* Rojo error/admin */
  --color-danger-dark: #c82333;      /* Rojo oscuro */
  
  /* Colores Neutros */
  --color-gray-100: #f8f9fa;         /* Gris muy claro */
  --color-gray-200: #e9ecef;         /* Gris claro */
  --color-gray-300: #dee2e6;         /* Gris medio claro */
  --color-gray-400: #ced4da;         /* Gris medio */
  --color-gray-500: #adb5bd;         /* Gris */
  --color-gray-600: #6c757d;         /* Gris oscuro */
  --color-gray-700: #495057;         /* Gris muy oscuro */
  --color-gray-800: #343a40;         /* Casi negro */
  --color-gray-900: #212529;         /* Negro */
  
  /* Colores de Fondo */
  --bg-primary: #f1f1f1;             /* Fondo principal */
  --bg-secondary: #ffffff;           /* Fondo secundario */
  --bg-accent: #e3f2fd;              /* Fondo de acento */
}
```

### Uso de Colores
- **Azul Primario**: Botones principales, enlaces, elementos de marca
- **Verde**: Éxito, confirmaciones, botones de acción positiva
- **Rojo**: Errores, advertencias, acceso administrativo
- **Grises**: Texto, fondos, elementos neutros

## 📝 Tipografía

### Fuentes del Sistema
```css
font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 
             'Helvetica Neue', Arial, sans-serif;
```

### Jerarquía Tipográfica
```css
/* Títulos Principales */
.title-xl { font-size: 56px; font-weight: 800; }    /* Hero titles */
.title-lg { font-size: 42px; font-weight: 800; }    /* Section titles */
.title-md { font-size: 28px; font-weight: 700; }    /* Card titles */
.title-sm { font-size: 22px; font-weight: 700; }    /* Subtitles */

/* Texto del Cuerpo */
.text-lg { font-size: 20px; font-weight: 400; }     /* Large body */
.text-md { font-size: 16px; font-weight: 400; }     /* Regular body */
.text-sm { font-size: 14px; font-weight: 400; }     /* Small text */
.text-xs { font-size: 12px; font-weight: 600; }     /* Labels, badges */

/* Pesos de Fuente */
.font-light { font-weight: 300; }
.font-regular { font-weight: 400; }
.font-medium { font-weight: 500; }
.font-semibold { font-weight: 600; }
.font-bold { font-weight: 700; }
.font-extrabold { font-weight: 800; }
```

## 🧩 Componentes de Diseño

### 1. Botones

#### Botón Primario
```css
.btn-primary {
  background: linear-gradient(135deg, #0066cc, #0052a3);
  color: white;
  padding: 14px 28px;
  border-radius: 12px;
  font-weight: 600;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3);
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0, 102, 204, 0.4);
}
```

#### Botón Secundario
```css
.btn-secondary {
  background: #f8f9fa;
  color: #495057;
  border: 2px solid #e9ecef;
  padding: 12px 24px;
  border-radius: 8px;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-secondary:hover {
  background: #e9ecef;
  border-color: #0066cc;
  transform: translateY(-1px);
}
```

#### Botón de Éxito
```css
.btn-success {
  background: linear-gradient(135deg, #28a745, #20c997);
  color: white;
  padding: 15px 30px;
  border-radius: 12px;
  font-weight: 700;
  box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}
```

#### Botón Administrativo
```css
.btn-admin {
  background: linear-gradient(135deg, #dc3545, #c82333);
  color: white;
  padding: 16px 32px;
  border-radius: 12px;
  font-weight: 700;
  box-shadow: 0 4px 14px rgba(220, 53, 69, 0.3);
}
```

### 2. Tarjetas (Cards)

#### Tarjeta de Curso
```css
.course-card {
  background: white;
  border-radius: 20px;
  padding: 30px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  border: 2px solid transparent;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  overflow: hidden;
}

.course-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 5px;
  background: linear-gradient(90deg, #0066cc, #0052a3);
}

.course-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 28px rgba(0,0,0,0.15);
  border-color: #0066cc;
}
```

#### Tarjeta Administrativa
```css
.admin-card {
  background: rgba(255,255,255,0.95);
  backdrop-filter: blur(10px);
  border-radius: 20px;
  padding: 40px;
  box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
  border: 2px solid rgba(255,255,255,0.5);
}
```

### 3. Formularios

#### Campos de Entrada
```css
.form-input {
  padding: 14px 18px;
  border: 2px solid #e0e0e0;
  border-radius: 8px;
  font-size: 16px;
  transition: all 0.3s ease;
  background: #f8f9fa;
}

.form-input:focus {
  border-color: #0066cc;
  background: white;
  box-shadow: 0 0 0 4px rgba(0, 102, 204, 0.1);
  outline: none;
}
```

#### Etiquetas
```css
.form-label {
  font-weight: 700;
  color: #333;
  margin-bottom: 8px;
  font-size: 16px;
  display: block;
}
```

### 4. Navegación

#### Pestañas
```css
.tab-button {
  background: #f8f9fa;
  border: 2px solid #e9ecef;
  padding: 12px 20px;
  border-radius: 8px;
  font-weight: 600;
  transition: all 0.3s ease;
  cursor: pointer;
}

.tab-button.active {
  background: linear-gradient(135deg, #0066cc, #0052a3);
  color: white;
  border-color: #0066cc;
  box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3);
}

.tab-button:hover:not(.active) {
  background: #e9ecef;
  border-color: #0066cc;
  transform: translateY(-2px);
}
```

#### Carrusel
```css
.carousel-btn {
  background: linear-gradient(135deg, #0066cc, #0052a3);
  color: white;
  border: none;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  font-size: 20px;
  font-weight: 700;
  box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3);
  transition: all 0.3s ease;
}

.carousel-btn:hover {
  transform: translateY(-3px) scale(1.05);
  box-shadow: 0 6px 20px rgba(0, 102, 204, 0.4);
}

.carousel-indicator {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background: rgba(0, 102, 204, 0.3);
  transition: all 0.3s ease;
  cursor: pointer;
}

.carousel-indicator.active {
  background: #0066cc;
  transform: scale(1.2);
  box-shadow: 0 2px 8px rgba(0, 102, 204, 0.4);
}
```

## 📱 Diseño Responsive

### Breakpoints del Sistema
```css
/* Mobile First Approach */
@media (min-width: 576px) { /* Small devices */ }
@media (min-width: 768px) { /* Medium devices */ }
@media (min-width: 992px) { /* Large devices */ }
@media (min-width: 1200px) { /* Extra large devices */ }
```

### Adaptaciones por Dispositivo

#### Mobile (< 768px)
- **Layout**: Una columna
- **Carrusel**: 1 curso por vista
- **Botones**: Más grandes (44px mínimo)
- **Texto**: Tamaños reducidos
- **Espaciado**: Más compacto

#### Tablet (768px - 1024px)
- **Layout**: Dos columnas
- **Carrusel**: 2 cursos por vista
- **Navegación**: Pestañas horizontales
- **Formularios**: Campos más anchos

#### Desktop (> 1024px)
- **Layout**: Tres columnas
- **Carrusel**: 3 cursos por vista
- **Navegación**: Pestañas completas
- **Espaciado**: Generoso

## 🎭 Animaciones y Transiciones

### Principios de Animación
1. **Duración**: 0.3s para interacciones, 0.5s para transiciones complejas
2. **Easing**: `cubic-bezier(0.4, 0, 0.2, 1)` para naturalidad
3. **Propósito**: Cada animación debe tener una función clara
4. **Performance**: Usar `transform` y `opacity` cuando sea posible

### Animaciones Clave

#### Hover Effects
```css
.hover-lift {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}
```

#### Loading States
```css
@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.5; }
}

.loading {
  animation: pulse 2s infinite;
}
```

#### Slide Animations
```css
@keyframes slideIn {
  from { transform: translateX(-100%); opacity: 0; }
  to { transform: translateX(0); opacity: 1; }
}

.slide-in {
  animation: slideIn 0.3s ease;
}
```

## 🎨 Iconografía

### Sistema de Iconos
- **Fuente**: Emojis nativos para compatibilidad universal
- **Tamaño**: 16px, 20px, 24px, 32px, 48px
- **Uso**: Consistente en contextos similares

### Iconos Principales
- 📚 Cursos
- 🎓 Formación
- 💻 Online
- 📅 Fechas
- ⏱️ Duración
- 📧 Email
- 🔐 Administración
- ✅ Éxito
- ❌ Error
- ⚠️ Advertencia

## 🌈 Estados de Interfaz

### Estados de Botones
1. **Normal**: Colores base
2. **Hover**: Elevación y cambio de color
3. **Active**: Presionado
4. **Disabled**: Opacidad reducida, sin interacción
5. **Loading**: Indicador de carga

### Estados de Formularios
1. **Empty**: Estado inicial
2. **Focus**: Borde azul, sombra sutil
3. **Valid**: Borde verde
4. **Invalid**: Borde rojo, mensaje de error
5. **Disabled**: Fondo gris, texto deshabilitado

### Estados de Carrusel
1. **Static**: Vista normal
2. **Hover**: Pausa de auto-play
3. **Transitioning**: Animación de cambio
4. **Loading**: Indicadores de carga

## 🎯 Patrones de Diseño

### Layout Patterns

#### Grid System
```css
.grid-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 30px;
}
```

#### Flexbox Patterns
```css
.flex-center {
  display: flex;
  align-items: center;
  justify-content: center;
}

.flex-between {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
```

### Component Patterns

#### Card Pattern
- Header con badge/estado
- Contenido principal
- Footer con acciones
- Hover effects consistentes

#### Modal Pattern
- Overlay con blur
- Contenido centrado
- Header con título y cierre
- Footer con acciones

#### Form Pattern
- Labels claros
- Validación en tiempo real
- Estados visuales claros
- Agrupación lógica

## 🔍 Accesibilidad

### Principios WCAG
1. **Perceptible**: Contraste adecuado, texto alternativo
2. **Operable**: Navegación por teclado, tiempo suficiente
3. **Comprensible**: Texto claro, comportamiento predecible
4. **Robusto**: Compatible con tecnologías asistivas

### Implementación
- **Contraste**: Mínimo 4.5:1 para texto normal
- **Focus**: Indicadores visibles para navegación por teclado
- **Alt Text**: Descripciones para todas las imágenes
- **ARIA**: Labels y roles apropiados
- **Semántica**: HTML estructurado correctamente

## 📊 Métricas de Diseño

### Performance
- **First Paint**: < 1.5s
- **Largest Contentful Paint**: < 2.5s
- **Cumulative Layout Shift**: < 0.1

### Usabilidad
- **Tiempo de carga**: < 3s
- **Tasa de error**: < 5%
- **Satisfacción del usuario**: > 4.5/5

### Accesibilidad
- **Contraste**: 100% cumplimiento WCAG AA
- **Navegación por teclado**: 100% funcional
- **Screen readers**: Compatible

---

**Fecha de Creación**: 23 de Diciembre, 2025  
**Versión**: 1.0.0  
**Estado**: Implementado y Activo
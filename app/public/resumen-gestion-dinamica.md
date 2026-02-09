# 🎓 Gestión Dinámica de Cursos - Mongruas Formación

## ✅ Nueva Funcionalidad Implementada

### 🎯 Panel Dinámico Completo

**Archivo Principal:**
- `gestionar-cursos-dinamico.php` ✅ Creado

**Funcionalidades Principales:**
- ➕ **Agregar cursos** ilimitados
- 🗑️ **Eliminar cursos** individuales
- 💾 **Guardar todos** los cambios
- 📊 **Contador dinámico** de cursos activos
- 🖼️ **Subida de imágenes** con drag & drop

### 🚀 Características Avanzadas

**1. Gestión Dinámica:**
- ✅ Sin límite de 6 cursos (antes era fijo)
- ✅ Agregar nuevos cursos con un clic
- ✅ Eliminar cursos individuales
- ✅ Eliminar todos los cursos (con confirmación)
- ✅ Renumeración automática

**2. Interfaz Moderna:**
- 🎨 Diseño con gradientes y sombras
- 📱 Completamente responsive
- ✨ Animaciones suaves
- 🎯 Botones con efectos hover
- 📊 Estadísticas en tiempo real

**3. Subida de Imágenes Mejorada:**
- 📁 Drag & drop para cada curso
- 🖱️ Selección de archivos
- 👁️ Preview inmediato
- 🗑️ Eliminar/cambiar imágenes
- ✅ Validación de tipos y tamaños

### 🎨 Diseño Visual

**Colores Mongruas:**
- 🔵 Azul primario: #0066cc → #0052a3
- 🟢 Verde éxito: #28a745 → #20c997
- 🔴 Rojo eliminar: #dc3545 → #c82333
- ⚫ Gris secundario: #6c757d → #5a6268

**Efectos Visuales:**
- ✨ Gradientes lineales en botones
- 🌊 Transformaciones hover (translateY, scale)
- 💫 Sombras dinámicas con colores
- 🎭 Transiciones suaves (0.3s ease)

### 📋 Campos por Curso

**Información Básica:**
- 📚 **Nombre del Curso** (requerido)
- 📅 **Fecha de Inicio** (texto libre)
- 🎯 **Modalidad** (Presencial/Online/Semipresencial)
- 👥 **Plazas/Duración** (texto libre)

**Información Detallada:**
- 📝 **Descripción** (textarea expandible)
- 🖼️ **Imagen** (drag & drop + preview)

### 🔧 Funciones JavaScript

**Gestión de Cursos:**
```javascript
addNewCourse()          // Agregar nuevo curso
deleteCourse(index)     // Eliminar curso específico
confirmDeleteAll()      // Eliminar todos (con confirmación)
updateCourseNumbers()   // Renumerar cursos
updateStats()           // Actualizar contador
saveAllCourses()        // Guardar todos los cambios
```

**Gestión de Imágenes:**
```javascript
selectFile(courseId)           // Abrir selector de archivos
handleFileSelect(courseId)     // Procesar archivo seleccionado
uploadImage(courseId, file)    // Subir y procesar imagen
showImagePreview(courseId)     // Mostrar preview
removeImage(courseId)          // Eliminar imagen
setupDragAndDrop(courseId)     // Configurar drag & drop
```

### 💾 Almacenamiento

**Base de Datos:**
- Opción WordPress: `mongruas_courses`
- Formato: Array de objetos JSON
- Estructura por curso:
```php
[
    'name' => 'Nombre del curso',
    'date' => 'Fecha de inicio',
    'modality' => 'Modalidad',
    'duration' => 'Plazas/Duración',
    'description' => 'Descripción completa',
    'image' => 'Ruta de la imagen'
]
```

### 🌐 Cómo Usar

**1. Acceder al Panel:**
```
http://mongruasformacion.local/gestionar-cursos-dinamico.php
```

**2. Agregar Curso:**
- Haz clic en "➕ Agregar Nuevo Curso"
- Rellena los campos requeridos
- Arrastra una imagen o selecciona archivo
- El curso se agrega automáticamente

**3. Eliminar Curso:**
- Haz clic en el botón 🗑️ en la esquina del curso
- Confirma la eliminación
- El curso se elimina y los números se actualizan

**4. Guardar Cambios:**
- Haz clic en "💾 Guardar Todos los Cursos"
- Confirma la acción
- Todos los cambios se guardan en la base de datos

### 📱 Responsive Design

**Desktop:**
- Grid de 2 columnas para campos
- Botones con hover effects
- Imágenes preview 150px altura

**Mobile:**
- Grid de 1 columna
- Botones expandidos (flex: 1)
- Header de curso centrado
- Controles apilados verticalmente

### 🔒 Seguridad

**Validaciones Implementadas:**
- ✅ Sanitización de todos los inputs
- ✅ Validación de tipos de imagen
- ✅ Límite de tamaño (5MB)
- ✅ Confirmaciones para eliminaciones
- ✅ Verificación de índices válidos

### 🆚 Comparación con Versión Anterior

**Antes (gestionar-cursos-expandido.php):**
- ❌ Solo 6 cursos fijos
- ❌ No se podían eliminar cursos
- ❌ No se podían agregar cursos
- ❌ Interfaz con tabs limitada

**Ahora (gestionar-cursos-dinamico.php):**
- ✅ Cursos ilimitados
- ✅ Agregar/eliminar dinámicamente
- ✅ Interfaz moderna y fluida
- ✅ Gestión completa de imágenes
- ✅ Estadísticas en tiempo real
- ✅ Mejor UX/UI

### 🎉 Beneficios

**Para el Usuario:**
- 🚀 **Flexibilidad total** - Sin límites de cursos
- 🎯 **Fácil de usar** - Interfaz intuitiva
- ⚡ **Rápido** - Cambios inmediatos
- 📱 **Móvil-friendly** - Funciona en cualquier dispositivo

**Para el Negocio:**
- 📈 **Escalable** - Crece con tus necesidades
- 💼 **Profesional** - Diseño moderno
- 🔧 **Mantenible** - Código limpio y organizado
- 🎨 **Personalizable** - Fácil de modificar

**¡Ahora tienes control total sobre la gestión de cursos! 🎓✨**
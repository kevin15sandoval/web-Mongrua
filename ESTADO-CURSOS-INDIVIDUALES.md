# 📋 Estado del Sistema de Cursos Individuales

## ✅ Implementación Completada

### 1. **Páginas Individuales de Cursos**
Se han creado páginas individuales para cada curso con toda la información detallada.

**Archivos creados:**
- `app/public/curso.php` - Routing para las URLs individuales
- `app/public/wp-content/themes/mongruas-theme/page-templates/single-course.php` - Template completo

**URLs disponibles:**
- `/curso/?curso=1` - Curso 1
- `/curso/?curso=2` - Curso 2  
- `/curso/?curso=3` - Curso 3

### 2. **Características de las Páginas Individuales**

Cada página incluye:

✅ **Hero Section con imagen grande**
- Imagen destacada del curso (si está configurada)
- Título del curso
- Badge con fecha de inicio
- Metadata (fecha, modalidad, plazas)
- Botones de acción (Reservar Plaza, Volver)

✅ **Descripción completa**
- Texto descriptivo del curso
- Información adicional organizada en tarjetas

✅ **Información estructurada**
- 🎯 Objetivos del curso
- 📚 Metodología
- 🏆 Certificación

✅ **Formulario de contacto integrado**
- Campos: nombre, teléfono, email, ciudad, mensaje
- Pre-rellena el nombre del curso
- Redirige a página de contacto

✅ **Sidebar con información útil**
- Resumen del curso
- Otros cursos disponibles
- Información de contacto directo

✅ **Breadcrumb navigation**
- Inicio > Cursos > [Nombre del Curso]

✅ **Diseño responsive**
- Adaptado para móviles y tablets

### 3. **Integración con Sistema de Gestión**

✅ **Botones duales en tarjetas de curso:**
- **"Ver Más Info"** (azul) → Lleva a la página individual
- **"Reservar Plaza"** (verde) → Lleva directamente al formulario de contacto

✅ **Gestión desde panel:**
- URL: `/gestionar-proximos-cursos.php`
- Permite editar: nombre, fecha, modalidad, duración, descripción, imagen
- Vista previa en tiempo real
- Subida de imágenes con drag & drop

### 4. **Sistema de Imágenes**

✅ **Funcionalidad completa:**
- Subida por URL (pegar enlace)
- Subida por archivo (drag & drop o seleccionar)
- Validación de tipo y tamaño (5MB máximo)
- Redimensionamiento automático a 800x600px
- Vista previa instantánea

**Archivo de subida:**
- `app/public/subir-imagen-curso.php`

## 🧪 Cómo Probar

### Opción 1: Verificación Rápida
Visita: `http://mongruasformacion.local/verificar-cursos-individuales.php`

### Opción 2: Prueba Manual

1. **Ver la página de cursos:**
   - Ir a: `http://mongruasformacion.local/anuncios`
   - Buscar la sección "Próximos Cursos"
   - Verificar que cada curso tiene 2 botones

2. **Probar página individual:**
   - Click en "Ver Más Info" de cualquier curso
   - Verificar que se abre la página individual
   - Comprobar que toda la información se muestra correctamente

3. **Probar gestión:**
   - Ir a: `http://mongruasformacion.local/gestionar-proximos-cursos.php`
   - Modificar un curso (nombre, descripción, imagen)
   - Guardar cambios
   - Verificar que los cambios aparecen en `/anuncios` y en la página individual

## 📁 Archivos Principales

```
app/public/
├── curso.php                                    # Routing de páginas individuales
├── gestionar-proximos-cursos.php              # Panel de gestión
├── subir-imagen-curso.php                     # Handler de subida de imágenes
└── wp-content/themes/mongruas-theme/
    ├── template-parts/
    │   └── courses-default.php                # Template con botones duales
    └── page-templates/
        └── single-course.php                  # Template de página individual
```

## 🎨 Estilos y Diseño

### Colores utilizados:
- **Botón "Ver Más Info"**: Azul (#0066cc → #004499)
- **Botón "Reservar Plaza"**: Verde (#28a745 → #20c997)
- **Badges de fecha**: Verde degradado
- **Secciones**: Fondos claros con bordes sutiles

### Responsive:
- Desktop: Layout de 2 columnas (contenido + sidebar)
- Tablet/Mobile: Layout de 1 columna apilada

## ⚙️ Configuración Actual

Los cursos se gestionan mediante WordPress Options:
- `course_1_name`, `course_1_date`, `course_1_modality`, etc.
- `course_2_name`, `course_2_date`, `course_2_modality`, etc.
- `course_3_name`, `course_3_date`, `course_3_modality`, etc.

Cada curso tiene 6 campos:
1. **name** - Nombre del curso
2. **date** - Fecha de inicio
3. **modality** - Modalidad (Presencial/Online/Semipresencial)
4. **duration** - Plazas o duración
5. **description** - Descripción completa
6. **image** - URL de la imagen

## 🔄 Flujo de Usuario

```
Página /anuncios
    ↓
Ver tarjeta de curso
    ↓
    ├─→ Click "Ver Más Info" → Página individual (/curso/?curso=X)
    │                              ↓
    │                          Ver información completa
    │                              ↓
    │                          Formulario de contacto
    │
    └─→ Click "Reservar Plaza" → Página de contacto directamente
```

## ✨ Próximos Pasos Sugeridos

1. **Probar todas las URLs** de cursos individuales
2. **Verificar responsive** en móvil
3. **Añadir imágenes** a los cursos desde el panel de gestión
4. **Probar formulario** de contacto en páginas individuales
5. **Verificar que los botones** funcionan correctamente

## 📞 Soporte

Si algo no funciona:
1. Verificar que WordPress está corriendo
2. Limpiar caché del navegador
3. Verificar que los archivos existen en las rutas indicadas
4. Revisar consola del navegador para errores JavaScript

---

**Última actualización:** Diciembre 22, 2025
**Estado:** ✅ Implementación completa - Listo para pruebas

# Panel de Gestión de Cursos - Capturas de Pantalla

## Nota sobre las Capturas de Pantalla

Las capturas de pantalla se agregarán en una fase posterior de la implementación. Esta documentación describe qué capturas serán incluidas y dónde se ubicarán.

## Capturas Planificadas

### 1. Acceso al Panel

**Archivo**: `screenshots/access-button.png`
**Descripción**: Botón de acceso flotante en la esquina inferior derecha del sitio
**Elementos a mostrar**:
- Botón flotante discreto
- Posición en el sitio web
- Estado hover del botón

### 2. Modal de Login

**Archivo**: `screenshots/login-modal.png`
**Descripción**: Modal de autenticación con formulario de login
**Elementos a mostrar**:
- Modal centrado con backdrop
- Formulario de login
- Campos de usuario y contraseña
- Botón de iniciar sesión

### 3. Interfaz Principal

**Archivo**: `screenshots/main-interface.png`
**Descripción**: Vista completa del panel de gestión
**Elementos a mostrar**:
- Sidebar con lista de cursos
- Panel central de edición
- Vista previa en tiempo real
- Navegación y controles

### 4. Formulario de Curso

**Archivo**: `screenshots/course-form.png`
**Descripción**: Formulario detallado para editar curso
**Elementos a mostrar**:
- Todos los campos del curso
- Validación en tiempo real
- Mensajes de error/éxito
- Botones de acción

### 5. Vista Previa en Tiempo Real

**Archivo**: `screenshots/live-preview.png`
**Descripción**: Panel de vista previa mostrando cómo se ve el curso
**Elementos a mostrar**:
- Vista previa del curso
- Actualización en tiempo real
- Diferentes estados (con/sin imagen)

### 6. Subida de Imágenes

**Archivo**: `screenshots/image-upload.png`
**Descripción**: Interfaz de subida y gestión de imágenes
**Elementos a mostrar**:
- Área de drag & drop
- Progreso de subida
- Vista previa de imagen
- Controles de imagen

### 7. Estados de Vista Previa

**Archivo**: `screenshots/preview-states.png`
**Descripción**: Diferentes estados de la vista previa
**Elementos a mostrar**:
- Curso completo con imagen
- Curso sin imagen
- Curso con datos incompletos
- Estado vacío

### 8. Versión Móvil

**Archivo**: `screenshots/mobile-interface.png`
**Descripción**: Interfaz adaptada para dispositivos móviles
**Elementos a mostrar**:
- Layout responsive
- Navegación móvil
- Formularios adaptados
- Vista previa en móvil

### 9. Mensajes de Error

**Archivo**: `screenshots/error-messages.png`
**Descripción**: Diferentes tipos de mensajes de error
**Elementos a mostrar**:
- Errores de validación
- Errores de conexión
- Errores de autenticación
- Mensajes de éxito

### 10. Lista de Cursos

**Archivo**: `screenshots/course-list.png`
**Descripción**: Sidebar con lista de cursos existentes
**Elementos a mostrar**:
- Cursos activos e inactivos
- Indicadores de estado
- Selección de curso
- Opciones de reordenamiento

## Especificaciones Técnicas

### Formato de Capturas
- **Formato**: PNG con transparencia donde sea apropiado
- **Resolución**: Mínimo 1920x1080 para capturas de escritorio
- **Resolución móvil**: 375x812 (iPhone X) para capturas móviles
- **Calidad**: Alta calidad, sin compresión excesiva

### Convenciones de Nomenclatura
```
screenshots/
├── access-button.png
├── login-modal.png
├── main-interface.png
├── course-form.png
├── live-preview.png
├── image-upload.png
├── preview-states.png
├── mobile-interface.png
├── error-messages.png
└── course-list.png
```

### Anotaciones
- Usar flechas y callouts para destacar elementos importantes
- Incluir texto explicativo cuando sea necesario
- Mantener consistencia visual entre capturas
- Usar datos de ejemplo realistas pero no reales

## Proceso de Captura

### Preparación
1. **Configurar entorno de prueba** con datos de ejemplo
2. **Limpiar navegador** (sin extensiones que interfieran)
3. **Usar resolución estándar** (1920x1080)
4. **Preparar datos de prueba** consistentes

### Herramientas Recomendadas
- **Captura**: Herramientas nativas del sistema operativo
- **Edición**: GIMP, Photoshop, o herramientas online
- **Anotaciones**: Skitch, Annotate, o similar
- **Optimización**: TinyPNG para reducir tamaño

### Lista de Verificación
- [ ] Captura muestra funcionalidad claramente
- [ ] No hay información sensible visible
- [ ] Resolución y calidad adecuadas
- [ ] Anotaciones claras y útiles
- [ ] Nombre de archivo descriptivo
- [ ] Tamaño de archivo optimizado

## Integración en Documentación

### Referencias en Guía del Usuario
Las capturas se referenciarán en la [Guía del Usuario](USER-GUIDE.md) usando:

```markdown
![Descripción de la imagen](screenshots/nombre-archivo.png)
*Texto explicativo adicional si es necesario*
```

### Referencias en Solución de Problemas
Las capturas de errores se incluirán en [Solución de Problemas](TROUBLESHOOTING.md) para ayudar en el diagnóstico.

### Actualización de Capturas
- **Frecuencia**: Actualizar cuando cambie la interfaz significativamente
- **Versionado**: Mantener capturas de versiones anteriores si es necesario
- **Revisión**: Verificar relevancia cada 6 meses

## Notas para el Futuro

### Capturas Adicionales Planificadas
- Comparación antes/después de cambios
- Flujos de trabajo completos paso a paso
- Casos de uso específicos
- Integración con diferentes temas de WordPress

### Consideraciones de Localización
- Preparar capturas en diferentes idiomas si es necesario
- Considerar diferencias culturales en el diseño
- Mantener coherencia visual independiente del idioma

---

**Estado**: Planificado - Capturas pendientes de creación  
**Próxima actualización**: Cuando se implementen las capturas reales
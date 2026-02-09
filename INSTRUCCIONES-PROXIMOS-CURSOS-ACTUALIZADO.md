# Instrucciones para Configurar Próximos Cursos - ACTUALIZADO

## ¿Qué se ha añadido?

Se han añadido **2 nuevos campos** para cada curso:
- **Categoría del Curso**: Permite seleccionar el área o tipo de curso
- **Imagen del Curso**: Permite subir una imagen representativa

## Pasos para configurar los próximos cursos:

### Opción 1: Importar campos automáticamente (RECOMENDADO)

1. **Accede al WordPress Admin** de tu sitio
2. Ve a **Campos Personalizados > Herramientas**
3. En la sección "Importar grupos de campos", **copia y pega** todo el contenido del archivo `proximos-cursos-acf.json`
4. Haz clic en **"Importar"**
5. Los campos se crearán automáticamente

### Opción 2: Crear campos manualmente

Si prefieres crear los campos manualmente:

1. Ve a **Campos Personalizados > Grupos de campos**
2. Haz clic en **"Añadir nuevo"**
3. Título: **"Próximos Cursos"**
4. Añade los siguientes campos para cada curso (1, 2 y 3):

**Para cada curso necesitas estos campos:**
- Nombre del Curso (Texto)
- Descripción del Curso (Área de texto)
- Fecha de Inicio (Texto)
- Duración (Texto)
- Modalidad (Selección: Online, Presencial, Semipresencial)
- **NUEVO: Categoría** (Selección: PRL, Formación Profesional, Idiomas, Informática, Gestión Empresarial, Marketing, Otros)
- **NUEVO: Imagen del Curso** (Imagen)

5. En **Ubicación**, selecciona:
   - **Plantilla de página** es igual a **page-templates/page-cursos.php**

## Cómo editar los próximos cursos:

1. **Ve al WordPress Admin**
2. **Páginas > Todas las páginas**
3. **Edita la página "Cursos"**
4. **Desplázate hacia abajo** hasta ver la sección "Próximos Cursos"
5. **Rellena los campos** que quieras mostrar:

### Campos disponibles para cada curso:

- **Nombre del Curso**: Título del curso
- **Descripción**: Breve descripción del contenido
- **Fecha de Inicio**: Cuándo comienza (ej: "15 de Enero 2025")
- **Duración**: Cuánto dura (ej: "40 horas")
- **Modalidad**: Online, Presencial o Semipresencial
- **🆕 Categoría**: Área del curso (PRL, Formación Profesional, etc.)
- **🆕 Imagen**: Foto representativa del curso

6. **Actualiza la página**

## Notas importantes:

- **Solo se mostrarán** los cursos que tengan al menos el **nombre** rellenado
- Puedes configurar **1, 2 o 3 cursos** (los que no uses, déjalos vacíos)
- Las **imágenes son opcionales** - si no subes imagen, la tarjeta se verá sin foto
- La **categoría es opcional** - si no la seleccionas, no se mostrará
- Los campos están organizados en **pestañas** (Curso 1, Curso 2, Curso 3) para mayor claridad

## Verificar que funciona:

1. **Visita tu página de cursos** en el frontend
2. **Desplázate hacia abajo** hasta la sección "Próximos Cursos"
3. **Deberías ver** las tarjetas con:
   - Imagen del curso (si la subiste)
   - Badge "Próximamente" 
   - Categoría del curso (si la seleccionaste)
   - Fecha de inicio
   - Nombre del curso
   - Descripción
   - Duración y modalidad
   - Botón "Solicitar Información"

## Solución de problemas:

Si no ves los campos:
1. **Verifica** que ACF esté activado
2. **Comprueba** que estás editando la página correcta (Cursos)
3. **Asegúrate** de que la página usa la plantilla `page-templates/page-cursos.php`

Si no se muestran en el frontend:
1. **Verifica** que has rellenado al menos el "Nombre del Curso"
2. **Limpia la caché** si usas algún plugin de caché
3. **Recarga** la página

## Estilos visuales:

Las tarjetas ahora tienen:
- **Imagen de fondo** (si se sube)
- **Efecto hover** con zoom en la imagen
- **Badges de categoría** con colores
- **Diseño responsive** para móviles
- **Animaciones suaves** al pasar el ratón

¡Ya tienes todo configurado para gestionar los próximos cursos con imágenes y categorías!
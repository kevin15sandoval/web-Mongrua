# 🔧 Solución para Enlaces de Cursos Individuales

## 🚨 Problema Reportado
El botón "Ver Más Info" está enviando a la página de contacto en lugar de a la página individual del curso.

## 🛠️ Herramientas Creadas para Solucionar

### 1. **Diagnóstico Completo**
**URL:** `http://mongruasformacion.local/diagnostico-enlaces-cursos.php`

**Qué hace:**
- Verifica que todos los archivos necesarios existen
- Analiza las URLs generadas
- Examina el contenido del template de cursos
- Muestra enlaces encontrados en el código

### 2. **Corrección Automática**
**URL:** `http://mongruasformacion.local/corregir-enlaces-cursos.php`

**Qué hace:**
- Verifica y corrige el archivo `curso.php`
- Revisa el template de cursos
- Corrige enlaces incorrectos automáticamente
- Proporciona enlaces de prueba

### 3. **Test Simple**
**URL:** `http://mongruasformacion.local/test-curso-simple.php?curso=1`

**Qué hace:**
- Prueba básica de funcionamiento
- Muestra datos del curso
- Simula cómo se vería la página individual

## 🔍 Pasos para Diagnosticar y Solucionar

### Paso 1: Ejecutar Diagnóstico
1. Ve a: `http://mongruasformacion.local/diagnostico-enlaces-cursos.php`
2. Revisa que todos los archivos aparezcan como "✅ Existe"
3. Prueba los enlaces directos que aparecen en la página

### Paso 2: Aplicar Corrección
1. Ve a: `http://mongruasformacion.local/corregir-enlaces-cursos.php`
2. Verifica que aparezcan mensajes de "✅ correcto" o "✅ actualizado"
3. Prueba los enlaces de ejemplo en la misma página

### Paso 3: Verificar en la Página Real
1. Ve a: `http://mongruasformacion.local/anuncios`
2. Busca la sección "Próximos Cursos"
3. Haz click en "Ver Más Info" de cualquier curso
4. Debería abrir la página individual del curso

## 📁 Archivos Involucrados

### Archivos Principales:
- `app/public/curso.php` - Routing para páginas individuales
- `app/public/wp-content/themes/mongruas-theme/page-templates/single-course.php` - Template individual
- `app/public/wp-content/themes/mongruas-theme/template-parts/courses-default.php` - Lista de cursos

### Archivos de Diagnóstico:
- `app/public/diagnostico-enlaces-cursos.php` - Diagnóstico completo
- `app/public/corregir-enlaces-cursos.php` - Corrección automática
- `app/public/test-curso-simple.php` - Test básico

## 🎯 URLs de Prueba Directa

Si los cursos están configurados, estas URLs deberían funcionar:

- **Curso 1:** `http://mongruasformacion.local/curso/?curso=1`
- **Curso 2:** `http://mongruasformacion.local/curso/?curso=2`
- **Curso 3:** `http://mongruasformacion.local/curso/?curso=3`

## 🔧 Posibles Causas del Problema

### 1. **Archivo curso.php corrupto o inexistente**
- **Solución:** Ejecutar corrección automática

### 2. **Template individual no existe**
- **Verificar:** Debe existir `wp-content/themes/mongruas-theme/page-templates/single-course.php`
- **Solución:** El archivo ya fue creado anteriormente

### 3. **Enlaces incorrectos en template**
- **Verificar:** Los enlaces deben apuntar a `/curso/?curso=X`
- **Solución:** Corrección automática los arregla

### 4. **Problema de caché**
- **Solución:** Limpiar caché del navegador (Ctrl+F5)

## ✅ Verificación Final

Después de aplicar las correcciones:

1. **Los botones deben funcionar así:**
   - **"Ver Más Info" (azul)** → Página individual del curso
   - **"Reservar Plaza" (verde)** → Página de contacto

2. **Las páginas individuales deben mostrar:**
   - Título del curso
   - Fecha de inicio
   - Descripción completa
   - Formulario de contacto
   - Información adicional

## 🆘 Si Sigue Sin Funcionar

1. **Ejecuta el diagnóstico** y revisa los resultados
2. **Verifica la consola del navegador** (F12) para errores JavaScript
3. **Prueba en modo incógnito** para descartar problemas de caché
4. **Verifica que WordPress esté funcionando** correctamente

## 📞 Próximos Pasos

Una vez que los enlaces funcionen:
1. Añadir imágenes a los cursos desde el panel de gestión
2. Personalizar las descripciones de cada curso
3. Probar el formulario de contacto en las páginas individuales

---

**Herramientas disponibles:**
- 🔍 Diagnóstico: `/diagnostico-enlaces-cursos.php`
- 🔧 Corrección: `/corregir-enlaces-cursos.php`
- 🧪 Test: `/test-curso-simple.php?curso=1`
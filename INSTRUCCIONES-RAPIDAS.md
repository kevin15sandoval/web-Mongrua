# 🚀 Instrucciones Rápidas - Activar Landing Page Mongruas

## ✅ Paso 1: Ejecutar el Script de Configuración Automática

1. **Abre tu navegador** y ve a:
   ```
   http://mongruasformacion.local/setup-mongruas.php
   ```

2. **El script hará automáticamente:**
   - ✅ Activar el tema Mongruas
   - ✅ Crear la página de inicio
   - ✅ Configurarla como homepage
   - ✅ Crear el menú de navegación
   - ✅ Añadir contenido de ejemplo

3. **Después de ejecutarlo, ELIMINA el archivo** por seguridad:
   - Borra: `app/public/setup-mongruas.php`

---

## ✅ Paso 2: Verificar que Todo Funciona

1. **Ve a tu sitio:**
   ```
   http://mongruasformacion.local
   ```

2. **Deberías ver:**
   - Hero section con el título "LA FORMACIÓN AL ALCANCE DE TODOS"
   - Todas las secciones de la landing page
   - Menú de navegación funcionando

---

## ✅ Paso 3: Personalizar el Contenido

### 3.1 Editar la Página de Inicio
1. Ve a **Páginas → Todas las páginas**
2. Edita la página "Inicio"
3. Desplázate hacia abajo para ver los **campos ACF**
4. Rellena:
   - **Hero Section**: Título, subtítulo, imagen de fondo, botones
   - **Services**: Los 4 servicios principales
   - Guarda los cambios

### 3.2 Configurar Ajustes Globales
1. Ve a **Theme Settings** (en el menú lateral)
2. Rellena:
   - **Información de Contacto**: Teléfono, email, dirección
   - **Estadísticas**: 20 años, 2000+ cursos, etc.
   - **Certificaciones**: Sube los logos oficiales
   - **Analytics**: Códigos de Google Analytics y Facebook Pixel (opcional)

### 3.3 Subir el Logo
1. Ve a **Apariencia → Personalizar**
2. Haz clic en **Identidad del sitio**
3. Sube tu logo
4. Publica los cambios

### 3.4 Crear Testimonios
1. Ve a **Testimonios → Añadir nuevo**
2. Título: Nombre del alumno
3. Contenido: El testimonio completo
4. Rellena los campos ACF:
   - Nombre del autor
   - Cargo/Empresa
   - Foto
   - Puntuación (1-5 estrellas)
5. Publica
6. Crea al menos 3 testimonios

---

## 📋 Contenido Sugerido para los Servicios

### Servicio 1: Certificados de Profesionalidad
- **Título**: Certificados de Profesionalidad
- **Descripción**: Formación oficial acreditada por SEPE en electricidad, domótica y control de plagas
- **Características**:
  - ELEE0109: Instalaciones Eléctricas de Baja Tensión
  - ELEM0111: Sistemas Domóticos e Inmóticos
  - SEAG0110: Control de Plagas
- **Badge**: Acreditados por SEPE

### Servicio 2: Formación Bonificada
- **Título**: Formación Bonificada
- **Descripción**: Programas de formación para empresas utilizando créditos de la Seguridad Social
- **Características**:
  - Formación 100% bonificable
  - Planes personalizados
  - Gestión completa de bonificaciones
- **Badge**: Formación 100% Bonificable

### Servicio 3: Prevención de Riesgos Laborales
- **Título**: Prevención de Riesgos Laborales
- **Descripción**: Delegación Global Preventium - Gestión integral de PRL para empresas
- **Características**:
  - Más de 200 empresas gestionadas
  - Actividades técnicas
  - Vigilancia de la salud
  - Formación en PRL
- **Badge**: Delegación Global Preventium

### Servicio 4: Protección de Datos (LOPD/RGPD)
- **Título**: Protección de Datos (LOPD/RGPD)
- **Descripción**: Adaptación de empresas al Reglamento General de Protección de Datos
- **Características**:
  - Plataforma virtual de gestión
  - Departamento especializado
  - Cumplimiento normativo
- **Badge**: Cumplimiento RGPD

---

## 📊 Estadísticas Sugeridas

1. **20** - Años de Experiencia
2. **2000+** - Cursos Disponibles
3. **200+** - Empresas Gestionadas (PRL)
4. **3** - Certificados Acreditados

---

## 🎨 Optimización de Imágenes

Antes de subir imágenes, optimízalas con estos tamaños:

- **Hero background**: 1920x1080px (formato WebP o JPG)
- **Logos**: PNG transparente, máximo 300x100px
- **Iconos de servicios**: 64x64px (PNG o SVG)
- **Fotos de testimonios**: 150x150px (JPG)
- **Certificaciones**: Altura máxima 80px (PNG transparente)

---

## 🔧 Solución de Problemas

### El sitio se ve sin estilos
1. Ve a **Ajustes → Enlaces permanentes**
2. Haz clic en "Guardar cambios"
3. Recarga la página (Ctrl+F5)

### El formulario no envía emails
1. Instala el plugin **"WP Mail SMTP"**
2. Configura con Gmail o tu proveedor SMTP
3. Prueba el envío

### Los campos ACF no aparecen
1. Verifica que ACF esté instalado y activo
2. Ve a **ACF → Grupos de campos**
3. Deberías ver los grupos creados automáticamente

---

## ✅ Checklist Final

- [ ] Script de configuración ejecutado
- [ ] Tema activado
- [ ] Página de inicio visible
- [ ] Logo subido
- [ ] Contenido del hero añadido
- [ ] 4 servicios configurados
- [ ] Testimonios creados (mínimo 3)
- [ ] Estadísticas configuradas
- [ ] Información de contacto añadida
- [ ] Formulario probado
- [ ] Sitio probado en móvil

---

## 🎉 ¡Listo!

Una vez completados estos pasos, tu landing page estará completamente funcional.

**Enlaces útiles:**
- Sitio: http://mongruasformacion.local
- Admin: http://mongruasformacion.local/wp-admin
- Documentación completa: Ver `SETUP-GUIDE.md`

---

**¿Necesitas ayuda?** Revisa los archivos:
- `SETUP-GUIDE.md` - Guía detallada paso a paso
- `DEPLOYMENT-GUIDE.md` - Para subir a producción
- `IMPLEMENTATION-SUMMARY.md` - Resumen técnico completo

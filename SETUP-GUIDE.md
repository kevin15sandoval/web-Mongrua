# Guía de Configuración - Mogruas Landing Page

## 🚀 Pasos para Activar la Landing Page

### 1. Acceder al WordPress Admin
1. Haz clic en el botón **"WP Admin"** en Local (botón verde)
2. O ve a: `http://mongruasformacion.local/wp-admin`
3. Inicia sesión con tus credenciales de WordPress

### 2. Activar el Tema Mogruas
1. En el panel de WordPress, ve a **Apariencia → Temas**
2. Busca el tema **"Formación y Enseñanza Mogruas"**
3. Haz clic en **"Activar"**

### 3. Instalar ACF Pro (Requerido)
**Opción A - Si tienes licencia de ACF Pro:**
1. Ve a **Plugins → Añadir nuevo**
2. Haz clic en **"Subir plugin"**
3. Sube el archivo ZIP de ACF Pro
4. Activa el plugin

**Opción B - Usar ACF Free (temporal):**
1. Ve a **Plugins → Añadir nuevo**
2. Busca "Advanced Custom Fields"
3. Instala y activa la versión gratuita
4. (Nota: Algunas funciones avanzadas no estarán disponibles)

### 4. Crear la Página Landing
1. Ve a **Páginas → Añadir nueva**
2. Título: "Inicio" o "Home"
3. En el panel derecho, busca **"Atributos de página"**
4. En **"Plantilla"**, selecciona **"Mogruas Landing Page"**
5. Haz clic en **"Publicar"**

### 5. Configurar como Página de Inicio
1. Ve a **Ajustes → Lectura**
2. En "Tu página de inicio muestra", selecciona **"Una página estática"**
3. En "Página de inicio", selecciona la página que acabas de crear
4. Guarda los cambios

### 6. Configurar el Logo
1. Ve a **Apariencia → Personalizar**
2. Haz clic en **"Identidad del sitio"**
3. Haz clic en **"Seleccionar logo"**
4. Sube el logo de Mogruas
5. Ajusta el tamaño si es necesario
6. Haz clic en **"Publicar"**

### 7. Configurar los Menús
1. Ve a **Apariencia → Menús**
2. Crea un nuevo menú llamado "Menú Principal"
3. Añade enlaces a las secciones:
   - Inicio (#hero)
   - Servicios (#services)
   - Cursos (#course-catalog)
   - Nosotros (#about)
   - Contacto (#contact)
4. Asigna el menú a la ubicación **"Primary Menu"**
5. Guarda el menú

### 8. Configurar ACF Fields (Campos Personalizados)

#### Crear Grupo de Campos: Hero Section
1. Ve a **ACF → Grupos de campos → Añadir nuevo**
2. Título: "Landing Page - Hero Section"
3. Añade estos campos:
   - `hero_headline` (Text) - Título principal
   - `hero_subheadline` (Textarea) - Subtítulo
   - `hero_background_image` (Image) - Imagen de fondo
   - `hero_background_video` (File/URL) - Video de fondo (opcional)
   - `hero_primary_cta_text` (Text) - Texto botón principal
   - `hero_primary_cta_link` (Link) - Enlace botón principal
   - `hero_secondary_cta_text` (Text) - Texto botón secundario
   - `hero_secondary_cta_link` (Link) - Enlace botón secundario
   - `hero_trust_badges` (Repeater):
     - `image` (Image)
     - `text` (Text)
4. En "Ubicación", selecciona: "Plantilla de página" es igual a "Mogruas Landing Page"
5. Publica el grupo de campos

#### Crear Grupo de Campos: Services Section
1. Título: "Landing Page - Services"
2. Añade estos campos:
   - `services_section_heading` (Text)
   - `services_section_description` (Textarea)
   - `services` (Repeater):
     - `service_title` (Text)
     - `service_description` (Textarea)
     - `service_icon` (Image)
     - `service_features` (Repeater):
       - `feature_text` (Text)
     - `service_badge_text` (Text)
     - `service_cta_link` (Link)
3. Ubicación: "Plantilla de página" es igual a "Mogruas Landing Page"
4. Publica

#### Crear Grupo de Campos: Theme Settings (Opciones Globales)
1. Título: "Theme Settings"
2. Añade estos campos:
   - `contact_phone` (Text)
   - `contact_email` (Email)
   - `contact_address` (Textarea)
   - `google_analytics_code` (Textarea)
   - `facebook_pixel_code` (Textarea)
   - `custom_tracking_scripts` (Textarea)
   - `statistics` (Repeater):
     - `stat_number` (Text)
     - `stat_label` (Text)
     - `stat_icon` (Image)
   - `certifications` (Repeater):
     - `certification_logo` (Image)
     - `certification_name` (Text)
3. En "Ubicación", selecciona: "Página de opciones" es igual a "Theme Settings"
4. Publica

### 9. Añadir Contenido a la Página

#### Hero Section
1. Edita la página de inicio
2. Desplázate hacia abajo hasta los campos ACF
3. Rellena:
   - **Headline**: "LA FORMACIÓN AL ALCANCE DE TODOS"
   - **Subheadline**: "Centro Profesional para el Empleo desde 2005 en Talavera de la Reina"
   - **Background Image**: Sube una imagen profesional (1920x1080px recomendado)
   - **Primary CTA Text**: "Solicita Información"
   - **Primary CTA Link**: #contact
   - **Secondary CTA Text**: "Acceder al Campus Virtual"
   - **Secondary CTA Link**: https://www.plataformateleformacion.com
   - **Trust Badges**: Añade badges como "20 años de experiencia", "2000+ cursos", etc.

#### Services Section
Añade los 4 servicios principales:

**Servicio 1:**
- Title: "Certificados de Profesionalidad"
- Description: "Formación oficial acreditada por SEPE en electricidad, domótica y control de plagas"
- Features:
  - ELEE0109: Instalaciones Eléctricas de Baja Tensión
  - ELEM0111: Sistemas Domóticos e Inmóticos
  - SEAG0110: Control de Plagas
- Badge: "Acreditados por SEPE"

**Servicio 2:**
- Title: "Formación Bonificada"
- Description: "Programas de formación para empresas utilizando créditos de la Seguridad Social"
- Features:
  - Formación 100% bonificable
  - Planes personalizados
  - Gestión completa de bonificaciones
- Badge: "Formación 100% Bonificable"

**Servicio 3:**
- Title: "Prevención de Riesgos Laborales"
- Description: "Delegación Global Preventium - Gestión integral de PRL para empresas"
- Features:
  - Más de 200 empresas gestionadas
  - Actividades técnicas
  - Vigilancia de la salud
  - Formación en PRL
- Badge: "Delegación Global Preventium"

**Servicio 4:**
- Title: "Protección de Datos (LOPD/RGPD)"
- Description: "Adaptación de empresas al Reglamento General de Protección de Datos"
- Features:
  - Plataforma virtual de gestión
  - Departamento especializado
  - Cumplimiento normativo
- Badge: "Cumplimiento RGPD"

### 10. Crear Testimonios
1. Ve a **Testimonios → Añadir nuevo**
2. Título: Nombre del alumno/empresa
3. Contenido: El testimonio completo
4. Campos ACF:
   - Author Name: Nombre completo
   - Author Role: Cargo o empresa
   - Author Photo: Foto del alumno
   - Rating: 5 (o la puntuación correspondiente)
5. Publica
6. Repite para crear varios testimonios

### 11. Configurar Ajustes del Tema
1. Ve a **Theme Settings** (en el menú lateral)
2. Rellena:
   - **Contact Phone**: Tu teléfono
   - **Contact Email**: Tu email
   - **Contact Address**: Dirección de Talavera
   - **Statistics**: Añade las 4 estadísticas principales
     - 20 / Años de Experiencia
     - 2000+ / Cursos Disponibles
     - 200+ / Empresas Gestionadas (PRL)
     - 3 / Certificados Acreditados
   - **Certifications**: Sube los logos oficiales
     - Logo Junta de Castilla-La Mancha
     - Logo SEPE/Ministerio
     - Logo Global Preventium
     - Logo Fundación Construcción
     - Logo Fundación Metal
3. Guarda los cambios

### 12. Configurar Política de Privacidad
1. Ve a **Ajustes → Privacidad**
2. Crea o selecciona una página de política de privacidad
3. Guarda los cambios

### 13. Optimizar Imágenes (Recomendado)
Antes de subir imágenes, optimízalas:
- **Hero background**: 1920x1080px, formato WebP o JPG optimizado
- **Logos**: PNG transparente, máximo 300x100px
- **Iconos de servicios**: 64x64px, PNG o SVG
- **Fotos de testimonios**: 150x150px, formato JPG
- **Certificaciones**: Altura máxima 80px, PNG transparente

### 14. Probar la Landing Page
1. Haz clic en **"Open site"** en Local
2. O ve a: `http://mongruasformacion.local`
3. Verifica que todo se vea correctamente:
   - ✅ Hero section con imagen de fondo
   - ✅ Servicios con iconos y descripciones
   - ✅ Estadísticas animadas
   - ✅ Testimonios en carrusel
   - ✅ Formulario de contacto funcional
   - ✅ FAQ con acordeón
   - ✅ Responsive en móvil

### 15. Probar el Formulario de Contacto
1. Rellena el formulario de contacto
2. Envía un mensaje de prueba
3. Verifica que recibes el email en tu bandeja de entrada
4. Si no funciona, configura un plugin SMTP como "WP Mail SMTP"

## 📱 Probar en Móvil
1. En Local, haz clic en el menú del sitio (...)
2. Selecciona "Share"
3. Usa la URL generada para probar en tu móvil

## 🎨 Personalización de Colores
Si quieres cambiar los colores del tema:
1. Edita el archivo: `wp-content/themes/mongruas-theme/assets/css/main.css`
2. Busca las variables CSS al inicio del archivo:
   ```css
   --color-primary: #0066cc;  /* Azul principal */
   --color-secondary: #ff9900; /* Naranja */
   ```
3. Cambia los valores hexadecimales por tus colores corporativos
4. Guarda y recarga la página

## 🔧 Solución de Problemas

### El tema no aparece
- Verifica que la carpeta `mongruas-theme` esté en `wp-content/themes/`
- Asegúrate de que el archivo `style.css` existe

### Los campos ACF no aparecen
- Instala y activa el plugin ACF
- Crea los grupos de campos manualmente siguiendo la guía

### El formulario no envía emails
- Instala el plugin "WP Mail SMTP"
- Configura un servicio SMTP (Gmail, SendGrid, etc.)

### Las imágenes no se ven
- Verifica que las imágenes estén subidas correctamente
- Comprueba los permisos de la carpeta `wp-content/uploads/`

### El sitio se ve sin estilos
- Ve a **Ajustes → Enlaces permanentes**
- Haz clic en "Guardar cambios" (esto regenera los permalinks)

## 📞 Información de Contacto para Configurar

Datos reales de Mogruas para añadir:
- **Teléfono**: [Tu teléfono]
- **Email**: [Tu email]
- **Dirección**: Talavera de la Reina, Toledo
- **Campus Virtual**: https://www.plataformateleformacion.com

## ✅ Checklist Final

- [ ] Tema activado
- [ ] ACF instalado
- [ ] Página de inicio creada con template
- [ ] Logo subido
- [ ] Menú configurado
- [ ] Campos ACF creados
- [ ] Contenido del hero añadido
- [ ] 4 servicios configurados
- [ ] Testimonios creados (mínimo 3)
- [ ] Estadísticas configuradas
- [ ] Logos de certificaciones subidos
- [ ] Información de contacto añadida
- [ ] Política de privacidad configurada
- [ ] Formulario probado
- [ ] Sitio probado en móvil
- [ ] Analytics configurado (opcional)

## 🎉 ¡Listo!

Una vez completados todos los pasos, tu landing page de Mogruas estará completamente funcional y lista para recibir visitantes.

---

**¿Necesitas ayuda?** Revisa el archivo `IMPLEMENTATION-SUMMARY.md` para más detalles técnicos.

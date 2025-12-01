# Guía de Despliegue a Producción - Mogruas

## 📋 Antes de Empezar

### Requisitos del Servidor de Producción
- ✅ PHP 8.0 o superior
- ✅ MySQL 5.7 o superior / MariaDB 10.3+
- ✅ WordPress 6.0 o superior
- ✅ HTTPS/SSL configurado
- ✅ Acceso FTP/SFTP o SSH
- ✅ Acceso al panel de control (cPanel, Plesk, etc.)

### Checklist Pre-Despliegue
- [ ] Tema probado completamente en local
- [ ] Todas las imágenes optimizadas
- [ ] Contenido completo añadido
- [ ] Formulario de contacto probado
- [ ] Responsive verificado en móvil
- [ ] Backup de producción realizado (si ya existe sitio)

---

## 🚀 Método 1: Migración Completa desde Local (Recomendado)

### Opción A: Usar Plugin de Migración (Más Fácil)

#### 1. Instalar Plugin de Migración en Local
1. En tu WordPress local, ve a **Plugins → Añadir nuevo**
2. Busca e instala uno de estos plugins:
   - **"All-in-One WP Migration"** (Recomendado - Gratis hasta 512MB)
   - **"Duplicator"** (Gratis)
   - **"WP Migrate DB"** (Gratis)

#### 2. Exportar el Sitio desde Local
**Con All-in-One WP Migration:**
1. Ve a **All-in-One WP Migration → Export**
2. Selecciona "Export to File"
3. Espera a que se genere el archivo
4. Descarga el archivo .wpress

**Con Duplicator:**
1. Ve a **Duplicator → Packages → Create New**
2. Sigue el asistente
3. Descarga el archivo .zip y el installer.php

#### 3. Preparar el Servidor de Producción
1. Instala WordPress limpio en tu hosting
2. Instala el mismo plugin de migración
3. Asegúrate de tener suficiente espacio

#### 4. Importar en Producción
**Con All-in-One WP Migration:**
1. Ve a **All-in-One WP Migration → Import**
2. Sube el archivo .wpress
3. Espera a que se complete la importación
4. Haz clic en "Permalinks" para regenerarlos

**Con Duplicator:**
1. Sube el archivo .zip y installer.php vía FTP a la raíz de WordPress
2. Ve a: `tudominio.com/installer.php`
3. Sigue el asistente de instalación
4. Elimina installer.php y el .zip después

#### 5. Verificar y Ajustar
1. Verifica que todo funcione correctamente
2. Ve a **Ajustes → Enlaces permanentes** → Guardar cambios
3. Prueba el formulario de contacto
4. Verifica las imágenes

---

### Opción B: Migración Manual (Más Control)

#### 1. Exportar Base de Datos desde Local
1. En Local, haz clic en **"Database"** → **"Adminer"**
2. Haz clic en **"Export"**
3. Selecciona todas las tablas
4. Formato: SQL
5. Descarga el archivo .sql

#### 2. Exportar Archivos del Tema
1. Comprime la carpeta del tema:
   ```
   app/public/wp-content/themes/mongruas-theme/
   ```
2. Crea un ZIP con el tema completo

#### 3. Exportar Uploads (Imágenes)
1. Comprime la carpeta:
   ```
   app/public/wp-content/uploads/
   ```
2. Crea un ZIP con todas las imágenes

#### 4. Subir Archivos al Servidor
**Vía FTP/SFTP:**
1. Conecta a tu servidor con FileZilla o similar
2. Sube el tema a: `/wp-content/themes/`
3. Sube las imágenes a: `/wp-content/uploads/`

**Vía cPanel:**
1. Ve a **Administrador de archivos**
2. Navega a `/public_html/wp-content/themes/`
3. Sube y extrae el ZIP del tema
4. Repite para uploads

#### 5. Importar Base de Datos
**Vía phpMyAdmin:**
1. Accede a phpMyAdmin desde tu hosting
2. Selecciona tu base de datos
3. Haz clic en **"Importar"**
4. Selecciona el archivo .sql
5. Haz clic en **"Continuar"**

**IMPORTANTE: Buscar y Reemplazar URLs**
1. Instala el plugin **"Better Search Replace"**
2. Ve a **Herramientas → Better Search Replace**
3. Buscar: `http://mongruasformacion.local`
4. Reemplazar con: `https://tudominio.com`
5. Selecciona todas las tablas
6. Marca "Run as dry run" primero para probar
7. Luego ejecuta sin dry run

#### 6. Actualizar wp-config.php
Edita el archivo `wp-config.php` en producción con los datos correctos:
```php
define('DB_NAME', 'tu_base_de_datos');
define('DB_USER', 'tu_usuario');
define('DB_PASSWORD', 'tu_contraseña');
define('DB_HOST', 'localhost'); // o la IP de tu servidor
```

---

## 🚀 Método 2: Solo Subir el Tema (Si WordPress ya existe)

### Si ya tienes WordPress en producción:

#### 1. Comprimir el Tema
1. Comprime la carpeta completa:
   ```
   app/public/wp-content/themes/mongruas-theme/
   ```
2. Crea un archivo `mongruas-theme.zip`

#### 2. Subir el Tema
**Opción A - Vía WordPress Admin:**
1. Ve a **Apariencia → Temas → Añadir nuevo**
2. Haz clic en **"Subir tema"**
3. Selecciona el archivo ZIP
4. Haz clic en **"Instalar ahora"**
5. Activa el tema

**Opción B - Vía FTP:**
1. Conecta por FTP
2. Sube la carpeta descomprimida a `/wp-content/themes/`
3. Activa el tema desde WordPress Admin

#### 3. Instalar Plugins Necesarios
1. Instala **ACF Pro** (o ACF Free)
2. Activa el plugin

#### 4. Configurar el Tema
Sigue los pasos del `SETUP-GUIDE.md`:
- Crear página con template
- Configurar ACF fields
- Añadir contenido
- Crear testimonios
- Configurar ajustes

---

## 🔒 Configuración de Seguridad en Producción

### 1. Instalar Plugin de Seguridad
Instala uno de estos:
- **Wordfence Security**
- **Sucuri Security**
- **iThemes Security**

### 2. Configurar SSL/HTTPS
1. Asegúrate de que tu hosting tenga SSL activo
2. Ve a **Ajustes → Generales**
3. Cambia las URLs a HTTPS:
   - Dirección de WordPress (URL): `https://tudominio.com`
   - Dirección del sitio (URL): `https://tudominio.com`
4. Guarda los cambios

### 3. Configurar Permisos de Archivos
Vía SSH o FTP, establece permisos correctos:
```bash
# Carpetas
find /ruta/a/wordpress -type d -exec chmod 755 {} \;

# Archivos
find /ruta/a/wordpress -type f -exec chmod 644 {} \;

# wp-config.php
chmod 600 wp-config.php
```

### 4. Deshabilitar Edición de Archivos
Añade al `wp-config.php`:
```php
define('DISALLOW_FILE_EDIT', true);
```

---

## 📧 Configurar Email en Producción

### El formulario necesita enviar emails correctamente:

#### Opción 1: Plugin SMTP (Recomendado)
1. Instala **"WP Mail SMTP"**
2. Ve a **WP Mail SMTP → Settings**
3. Configura con tu proveedor:
   - **Gmail**: Usa OAuth o App Password
   - **SendGrid**: API Key gratuita (100 emails/día)
   - **Mailgun**: API Key
   - **SMTP del hosting**: Consulta con tu proveedor

#### Opción 2: Usar SMTP del Hosting
1. Contacta a tu proveedor de hosting
2. Solicita los datos SMTP
3. Configúralos en WP Mail SMTP

---

## ⚡ Optimización de Rendimiento

### 1. Instalar Plugin de Caché
Instala uno de estos:
- **WP Rocket** (Pago, el mejor)
- **W3 Total Cache** (Gratis)
- **WP Super Cache** (Gratis)

### 2. Optimizar Imágenes
1. Instala **"Smush"** o **"ShortPixel"**
2. Optimiza todas las imágenes existentes
3. Configura optimización automática

### 3. Usar CDN (Opcional)
- **Cloudflare** (Gratis) - Recomendado
- **StackPath**
- **KeyCDN**

### 4. Minificar CSS/JS
Si usas WP Rocket o W3 Total Cache, activa:
- Minificación de CSS
- Minificación de JavaScript
- Combinación de archivos

---

## 📊 Configurar Analytics

### 1. Google Analytics
1. Crea una propiedad en Google Analytics 4
2. Copia el código de seguimiento
3. Ve a **Theme Settings** en WordPress
4. Pega el código en "Google Analytics Code"

### 2. Facebook Pixel (Opcional)
1. Crea un Pixel en Facebook Business
2. Copia el código
3. Pégalo en "Facebook Pixel Code" en Theme Settings

### 3. Google Search Console
1. Ve a [search.google.com/search-console](https://search.google.com/search-console)
2. Añade tu propiedad
3. Verifica la propiedad (método HTML tag o DNS)
4. Envía el sitemap: `tudominio.com/sitemap.xml`

---

## ✅ Checklist Post-Despliegue

### Funcionalidad
- [ ] Sitio accesible en el dominio correcto
- [ ] HTTPS funcionando (candado verde)
- [ ] Todas las páginas cargan correctamente
- [ ] Imágenes se ven correctamente
- [ ] Menú de navegación funciona
- [ ] Enlaces internos funcionan (#sections)
- [ ] Formulario de contacto envía emails
- [ ] Recibo emails del formulario
- [ ] Carrusel de testimonios funciona
- [ ] Acordeón FAQ funciona
- [ ] Animaciones funcionan correctamente

### Responsive
- [ ] Se ve bien en móvil (iPhone, Android)
- [ ] Se ve bien en tablet (iPad)
- [ ] Se ve bien en desktop
- [ ] Menú móvil funciona
- [ ] Botones son táctiles (44x44px mínimo)

### SEO
- [ ] Título y descripción configurados
- [ ] Favicon subido
- [ ] Sitemap generado
- [ ] Google Search Console configurado
- [ ] Google Analytics funcionando

### Rendimiento
- [ ] Página carga en menos de 3 segundos
- [ ] Imágenes optimizadas
- [ ] Caché activado
- [ ] Lighthouse score > 80

### Seguridad
- [ ] SSL activo
- [ ] Plugin de seguridad instalado
- [ ] Contraseñas fuertes
- [ ] Backups automáticos configurados
- [ ] Permisos de archivos correctos

---

## 🆘 Solución de Problemas Comunes

### "Error al establecer conexión con la base de datos"
- Verifica los datos en `wp-config.php`
- Contacta a tu hosting para confirmar datos de BD

### "Las imágenes no se ven"
- Verifica permisos de `/wp-content/uploads/` (755)
- Regenera miniaturas con plugin "Regenerate Thumbnails"

### "El formulario no envía emails"
- Instala WP Mail SMTP
- Prueba con un email de prueba
- Verifica spam/correo no deseado

### "El sitio se ve sin estilos"
- Ve a **Ajustes → Enlaces permanentes** → Guardar
- Limpia la caché del navegador (Ctrl+F5)
- Limpia la caché del plugin de caché

### "Error 500"
- Aumenta el límite de memoria en `wp-config.php`:
  ```php
  define('WP_MEMORY_LIMIT', '256M');
  ```
- Revisa el log de errores de PHP
- Desactiva plugins uno por uno para identificar el problema

---

## 📞 Soporte Técnico

### Recursos Útiles
- **WordPress Codex**: [wordpress.org/support](https://wordpress.org/support/)
- **Documentación ACF**: [advancedcustomfields.com/resources](https://www.advancedcustomfields.com/resources/)
- **Foros de WordPress**: [wordpress.org/support/forums](https://wordpress.org/support/forums/)

### Contacto con Hosting
Ten a mano:
- Datos de acceso FTP/SFTP
- Datos de acceso a base de datos
- Acceso al panel de control
- Número de soporte de tu hosting

---

## 🎉 ¡Listo para Producción!

Una vez completados todos los pasos, tu landing page de Mogruas estará en vivo y lista para recibir visitantes y generar leads.

**Recuerda:**
- Hacer backups regulares
- Mantener WordPress y plugins actualizados
- Monitorear el rendimiento
- Revisar los emails del formulario regularmente

---

**Última actualización**: Diciembre 2024

# Mongruas Formación — Plantilla WordPress (import rápido)

**Colores sugeridos**
- Azul: `#004AAD`
- Naranja: `#FF7A00`
- Blanco: `#FFFFFF`

## 1) Requisitos
- WordPress instalado (tema sugerido: Astra).
- Plugins recomendados:
  - Elementor
  - WPForms Lite
  - WP User Frontend (para publicar sin entrar al panel)
  - User Role Editor (opcional, para permisos finos)
  - Smush o EWWW Image Optimizer (imágenes WebP)
  - RankMath SEO (opcional)
  - Complianz (cookies RGPD)
  - Caché: LiteSpeed Cache o SiteGround Optimizer

## 2) Importar las páginas y la categoría
1. Ve a **Herramientas → Importar → WordPress** y, si te pide, instala el **importador**.
2. Importa el archivo: **mongruas_wordpress_import.xml**.
3. Asigna el contenido al usuario administrador (o crea uno nuevo).

Esto creará las páginas:
- **Inicio**
- **Anuncios**
- **Publicar Anuncio**
- **Contacto**
y la **categoría Anuncios**.

## 3) Configurar lectura y menús
1. Ve a **Ajustes → Lectura**:
   - “Tu página de inicio muestra” → **Una página estática**
   - **Inicio** = *Inicio*
   - **Página de entradas** = *Anuncios*
2. Ve a **Apariencia → Menús** y crea un menú principal con:
   - Inicio
   - Anuncios
   - Publicar Anuncio
   - Contacto

## 4) Crear el formulario "Publicar Anuncio"
Con **WP User Frontend**:
1. Ve a **WP User Frontend → Post Forms → Add Form**.
2. Añade campos:
   - **Post Title** (Título)
   - **Featured Image** (Imagen destacada) — **Obligatorio**
   - **Post Content** (Descripción)
3. Ajustes del formulario:
   - **Post Type**: Post
   - **Post Status**: **Published** (publicación directa)
   - **Default Category**: **Anuncios**
   - **Enable Guest Post**: desactivado (mejor con usuario)
4. Guarda y copia el **ID del formulario** (por ejemplo, 1).
5. Abre la página **Publicar Anuncio** y coloca el shortcode:
   ```
   [wpuf_form id="ID_DEL_FORMULARIO"]
   ```

## 5) Crear el formulario de contacto (WPForms)
1. **WPForms → Add New → Simple Contact Form**.
2. Publica el formulario y copia el **ID**.
3. Edita la página **Contacto** y reemplaza:
   ```
   [wpforms id="1" title="false" description="false"]
   ```
   por tu ID real.

## 6) Crear el usuario para publicar
- Ve a **Usuarios → Añadir nuevo**.
- Crea un usuario para ella con rol **Autor**.
- Si quieres limitar aún más, usa **User Role Editor** para dejar solo Entradas + Medios.

## 7) Estilo rápido (opcional)
En **Apariencia → Personalizar → CSS adicional**, añade:

```css
:root{{--azul:#004AAD;--naranja:#FF7A00;}}
a.button, .wp-block-button__link{{background:var(--azul);color:#fff;border-radius:8px;padding:.6rem 1rem;display:inline-block;text-decoration:none}}
a.button:hover{{background:var(--naranja)}}
h1,h2,h3{{color:var(--azul)}}
```

## 8) WhatsApp y analítica (opcional)
- Instala un **botón de WhatsApp** (WP WhatsApp Button).
- Añade **GA4** y **Meta Pixel** (conversión en vistas y clics).

---

**Listo.** Tras esto tendrás:
- `/` Inicio con CTAs.
- `/anuncios` listado del blog.
- `/publicar-anuncio` formulario frontal para publicar.
- `/contacto` formulario de contacto.

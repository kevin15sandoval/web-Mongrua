# 🚀 INSTRUCCIONES RÁPIDAS - Restaurar Página Anuncios

## ⚡ PASOS INMEDIATOS

### 1️⃣ Verifica el estado actual
Abre en tu navegador:
```
http://mongruasformacion.local/verificar-estado-anuncios.php
```

Este script te dirá:
- ✅ Si la tabla de base de datos existe
- ✅ Si hay cursos registrados
- ✅ Si la página "anuncios" existe y su estado
- ✅ Si los archivos necesarios están en su lugar
- ✅ Qué necesitas hacer para completar la configuración

### 2️⃣ Restaura la página (si está en papelera)
Abre en tu navegador:
```
http://mongruasformacion.local/restaurar-anuncios-simple.php
```

Este script automáticamente:
- Busca la página "anuncios" en la papelera
- La restaura si la encuentra
- Te da enlaces para verla y editarla

### 3️⃣ Configura la plantilla correcta

Después de restaurar (o si la página ya existe):

1. Ve al panel de WordPress:
   ```
   http://mongruasformacion.local/wp-admin/
   ```

2. Ve a: **Páginas > Todas las páginas**

3. Busca la página **"Anuncios"** y haz clic en **Editar**

4. En el panel derecho, busca **"Atributos de página"**

5. En **"Plantilla"**, selecciona: **"Próximos Cursos (Anuncios)"**

6. Haz clic en **"Actualizar"**

### 4️⃣ Prueba que funciona

Abre en tu navegador:
```
http://mongruasformacion.local/anuncios/
```

Deberías ver:
- ✅ Carrusel con 3 tarjetas visibles
- ✅ Flechas circulares con borde azul
- ✅ Puntos indicadores abajo
- ✅ Cursos de la base de datos
- ✅ Botones "Ver Más Info" y "Reservar Plaza"

## 🎯 SI LA PÁGINA NO ESTÁ EN LA PAPELERA

Si el script de restauración no encuentra la página, créala nueva:

1. Ve a: **Páginas > Añadir nueva**

2. Configura:
   - **Título**: Anuncios
   - **URL**: Se genera automáticamente como `/anuncios/`
   - **Plantilla**: "Próximos Cursos (Anuncios)"
   - **Contenido**: Déjalo vacío (la plantilla lo maneja todo)

3. Haz clic en **"Publicar"**

4. Listo! Visita `http://mongruasformacion.local/anuncios/`

## 📋 CHECKLIST RÁPIDO

- [ ] Ejecutar `verificar-estado-anuncios.php`
- [ ] Ejecutar `restaurar-anuncios-simple.php` (si es necesario)
- [ ] Configurar plantilla "Próximos Cursos (Anuncios)"
- [ ] Probar `/anuncios/` en el navegador
- [ ] Verificar que el carrusel muestra 3 columnas
- [ ] Probar botones "Ver Más Info" y "Reservar Plaza"
- [ ] Hacer Ctrl + F5 para limpiar caché

## 🔗 ENLACES ÚTILES

| Descripción | URL |
|-------------|-----|
| Verificar Estado | `http://mongruasformacion.local/verificar-estado-anuncios.php` |
| Restaurar Página | `http://mongruasformacion.local/restaurar-anuncios-simple.php` |
| Página Anuncios | `http://mongruasformacion.local/anuncios/` |
| Versión Standalone | `http://mongruasformacion.local/anuncios.php` |
| Panel WordPress | `http://mongruasformacion.local/wp-admin/` |
| Página Principal | `http://mongruasformacion.local/` |

## 💡 NOTAS

- La página principal (`/`) ya tiene el carrusel funcionando con la base de datos
- El archivo `anuncios.php` (standalone) sigue funcionando como referencia
- Ambas versiones (WordPress y standalone) usan el mismo diseño
- Los cursos se gestionan desde el panel de administración
- Siempre usa **Ctrl + F5** para limpiar la caché del navegador

## 🆘 PROBLEMAS COMUNES

### El carrusel no se ve horizontal
- ✅ Verifica que la plantilla sea "Próximos Cursos (Anuncios)"
- ✅ Limpia caché: Ctrl + F5
- ✅ Revisa que haya cursos en la base de datos

### Los botones no funcionan
- ✅ Verifica que los cursos tengan ID en la base de datos
- ✅ Comprueba que existe `curso-detalle.php`
- ✅ Verifica que el formulario de contacto esté en `/#contact`

### La página no existe
- ✅ Ejecuta `restaurar-anuncios-simple.php`
- ✅ Si no funciona, crea la página manualmente
- ✅ Asegúrate de usar la plantilla correcta

---

**¡Con estos pasos tendrás la página de anuncios funcionando perfectamente!** 🎉

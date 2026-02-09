# Especificación del Sistema de Gestión de Cursos - Mongruas Formación

## 📋 Resumen del Proyecto

Sistema completo de gestión de cursos con carrusel automático y sistema de mailing integrado para Mongruas Formación. El sistema permite gestionar hasta 6 cursos con visualización automática en carrusel cuando hay más de 3 cursos activos.

## 🎯 Objetivos Principales

### Objetivo 1: Sistema de Gestión de Cursos Expandido
- **Estado**: ✅ COMPLETADO
- **Descripción**: Expandir el sistema de 3 a 6 cursos con interfaz de pestañas
- **Criterios de Aceptación**:
  - [x] Gestionar hasta 6 cursos simultáneamente
  - [x] Interfaz de pestañas para navegación fácil
  - [x] Guardado masivo de todos los cursos
  - [x] Vista previa en tiempo real
  - [x] Integración con página principal

### Objetivo 2: Carrusel Automático Inteligente
- **Estado**: ✅ COMPLETADO
- **Descripción**: Activación automática del carrusel cuando hay más de 3 cursos
- **Criterios de Aceptación**:
  - [x] Vista grid para ≤3 cursos
  - [x] Vista carrusel para >3 cursos
  - [x] Controles de navegación (flechas)
  - [x] Indicadores de posición
  - [x] Diseño responsive
  - [x] Auto-play con pausa en hover

### Objetivo 3: Sistema de Mailing Integrado
- **Estado**: ✅ COMPLETADO
- **Descripción**: Sistema de envío masivo de correos electrónicos
- **Criterios de Aceptación**:
  - [x] Envío a usuarios WordPress
  - [x] Envío a suscriptores MailPoet
  - [x] Listas personalizadas de emails
  - [x] Plantillas predefinidas
  - [x] Variables automáticas ([PROXIMOS_CURSOS])
  - [x] Estadísticas en tiempo real

### Objetivo 4: Botón de Acceso Administrativo
- **Estado**: ✅ COMPLETADO
- **Descripción**: Botón seguro en el topbar para acceso al panel
- **Criterios de Aceptación**:
  - [x] Modal de login seguro
  - [x] Múltiples credenciales de acceso
  - [x] Redirección automática al panel
  - [x] Diseño integrado con el tema

## 🏗️ Arquitectura del Sistema

### Componentes Principales

1. **Gestor Principal** (`gestionar-proximos-cursos.php`)
   - Interfaz de pestañas para 6 cursos
   - Formularios de edición completos
   - Vista previa con carrusel
   - Botón de acceso al mailing

2. **Sistema de Mailing** (`panel-mailing-completo.php`)
   - Panel de estadísticas
   - Configuración de envío
   - Plantillas predefinidas
   - Gestión de destinatarios

3. **Template de Cursos** (`page-templates/page-cursos.php`)
   - Lógica de decisión grid/carrusel
   - Carrusel responsive con controles
   - Integración con datos de cursos
   - Botón de acceso administrativo

4. **Scripts de Diagnóstico**
   - Verificación de cursos activos
   - Diagnóstico de carrusel
   - Limpieza de cache
   - Troubleshooting automático

### Flujo de Datos

```
Gestor de Cursos → WordPress Options → Template → Página Web
                ↓
        Sistema de Mailing → Usuarios/Suscriptores → Envío Masivo
```

## 🔧 Funcionalidades Implementadas

### ✅ Gestión de Cursos
- **Hasta 6 cursos simultáneos**
- **Campos completos**: nombre, fecha, modalidad, duración, descripción, imagen
- **Interfaz de pestañas** para navegación fácil
- **Vista previa en tiempo real** con carrusel funcional
- **Guardado masivo** de todos los cursos
- **Validación automática** de datos

### ✅ Carrusel Inteligente
- **Activación automática** cuando >3 cursos
- **Controles de navegación** (flechas prev/next)
- **Indicadores de posición** clickeables
- **Auto-play** con pausa en hover
- **Diseño responsive** (1 curso móvil, 2 tablet, 3 desktop)
- **Animaciones suaves** con CSS transitions

### ✅ Sistema de Mailing
- **Múltiples tipos de destinatarios**:
  - Usuarios de WordPress
  - Suscriptores de MailPoet
  - Listas personalizadas
- **Plantillas predefinidas**:
  - Nuevos cursos
  - Recordatorios
  - Promociones
  - Newsletters
- **Variables automáticas**: `[PROXIMOS_CURSOS]`
- **Estadísticas en tiempo real**
- **Validación de emails**

### ✅ Seguridad y Acceso
- **Modal de login seguro** en el topbar
- **Múltiples credenciales** de administrador
- **Validación de permisos** (solo administradores)
- **Redirección automática** tras login exitoso
- **Mensajes de error** informativos

## 🎨 Diseño y UX

### Principios de Diseño
- **Interfaz intuitiva** con pestañas claras
- **Colores consistentes** con la marca Mongruas
- **Animaciones suaves** para mejor experiencia
- **Responsive design** para todos los dispositivos
- **Feedback visual** inmediato en todas las acciones

### Paleta de Colores
- **Primario**: #0066cc (azul Mongruas)
- **Secundario**: #28a745 (verde éxito)
- **Acento**: #dc3545 (rojo administrativo)
- **Neutros**: Grises para texto y fondos

## 📱 Responsive Design

### Breakpoints
- **Desktop**: >1024px - 3 cursos por vista
- **Tablet**: 768px-1024px - 2 cursos por vista
- **Mobile**: <768px - 1 curso por vista

### Adaptaciones Móviles
- Pestañas apiladas verticalmente
- Formularios de una columna
- Botones más grandes para touch
- Carrusel optimizado para swipe

## 🔍 Diagnóstico y Troubleshooting

### Scripts de Diagnóstico Disponibles
1. **`diagnostico-carrusel-6-cursos.php`** - Verificación específica del carrusel
2. **`diagnostico-completo.php`** - Diagnóstico general del sistema
3. **`diagnostico-acf.php`** - Verificación de campos personalizados

### Problemas Comunes y Soluciones
1. **Carrusel no aparece con 6 cursos**:
   - Verificar que los nombres de cursos no estén vacíos
   - Limpiar cache del navegador (Ctrl+F5)
   - Ejecutar script de diagnóstico

2. **Mailing no funciona**:
   - Verificar configuración SMTP de WordPress
   - Comprobar permisos de envío
   - Validar direcciones de email

3. **Botón de acceso no aparece**:
   - Verificar permisos de administrador
   - Comprobar que el usuario esté logueado
   - Revisar template del header

## 🚀 Estado Actual del Proyecto

### ✅ Completado (100%)
- [x] Sistema de gestión de 6 cursos
- [x] Carrusel automático inteligente
- [x] Sistema de mailing completo
- [x] Botón de acceso administrativo
- [x] Diseño responsive
- [x] Scripts de diagnóstico
- [x] Documentación completa

### 🔄 En Mantenimiento
- Monitoreo de funcionamiento del carrusel
- Optimización de rendimiento
- Actualizaciones de seguridad

## 📊 Métricas de Éxito

### Funcionalidad
- ✅ 6 cursos gestionables simultáneamente
- ✅ Carrusel se activa automáticamente con >3 cursos
- ✅ Sistema de mailing operativo
- ✅ 100% responsive en todos los dispositivos

### Usabilidad
- ✅ Interfaz intuitiva con pestañas
- ✅ Vista previa en tiempo real
- ✅ Guardado masivo eficiente
- ✅ Acceso administrativo seguro

### Rendimiento
- ✅ Carga rápida de la página
- ✅ Animaciones suaves
- ✅ Cache optimizado
- ✅ Código limpio y mantenible

## 🔧 Archivos Principales

### Core del Sistema
- `app/public/gestionar-proximos-cursos.php` - Gestor principal
- `app/public/panel-mailing-completo.php` - Sistema de mailing
- `app/public/wp-content/themes/mongruas-theme/page-templates/page-cursos.php` - Template principal

### Scripts de Utilidad
- `app/public/diagnostico-carrusel-6-cursos.php` - Diagnóstico específico
- `app/public/activar-carrusel-siempre.php` - Forzar carrusel
- `app/public/gestionar-suscriptores-mailpoet.php` - Gestión de suscriptores

### Configuración
- `app/public/wp-content/themes/mongruas-theme/header.php` - Botón de acceso
- `app/public/wp-content/themes/mongruas-theme/functions.php` - Funciones del tema

## 🎯 Próximos Pasos (Opcional)

### Mejoras Potenciales
1. **Analytics del Carrusel**
   - Tracking de interacciones
   - Métricas de engagement
   - A/B testing de diseños

2. **Automatización del Mailing**
   - Envío programado
   - Segmentación avanzada
   - Templates dinámicos

3. **Gestión Avanzada**
   - Categorías de cursos
   - Filtros avanzados
   - Exportación de datos

### Integraciones Futuras
- CRM externo
- Plataforma de pagos
- Sistema de reservas
- Notificaciones push

## 📝 Notas de Implementación

### Decisiones Técnicas
- **WordPress Options** para almacenamiento (simple y eficaz)
- **CSS Grid/Flexbox** para layouts responsive
- **JavaScript vanilla** para mejor rendimiento
- **PHP nativo** para lógica del servidor

### Consideraciones de Seguridad
- Validación de datos en servidor
- Sanitización de inputs
- Permisos de usuario verificados
- Credenciales de acceso seguras

### Optimizaciones Aplicadas
- Cache de consultas de base de datos
- Minificación de CSS/JS
- Lazy loading de imágenes
- Compresión de assets

---

**Fecha de Creación**: 23 de Diciembre, 2025  
**Estado**: PROYECTO COMPLETADO  
**Versión**: 1.0.0  
**Mantenedor**: Equipo Mongruas Formación
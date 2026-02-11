# PWA - Sistema de Certificación de Cursos

Progressive Web App para la gestión y certificación de cursos educativos.

## Características

- ✅ Autenticación de usuarios (registro, login, recuperación de contraseña)
- ✅ Gestión de cursos (crear, editar, publicar)
- ✅ Sistema de inscripciones
- ✅ Aprobación de cursos completados
- ✅ Generación de carnets digitales
- ✅ Notificaciones in-app
- ✅ Funcionalidad offline con Service Workers
- ✅ Instalable como aplicación

## Stack Tecnológico

- **Framework**: React 19 + Vite 8
- **Routing**: React Router DOM
- **State Management**: Zustand
- **HTTP Client**: Axios
- **Local Storage**: Dexie.js (IndexedDB)
- **PWA**: vite-plugin-pwa + Workbox
- **Styling**: CSS (preparado para Tailwind o Material-UI)

## Estructura del Proyecto

```
pwa/
├── public/
│   ├── icons/          # PWA icons
│   └── manifest.json   # PWA manifest
├── src/
│   ├── components/     # Componentes reutilizables
│   ├── pages/          # Páginas de la aplicación
│   ├── services/       # Servicios API
│   ├── store/          # Zustand stores
│   ├── utils/          # Utilidades
│   ├── hooks/          # Custom hooks
│   ├── App.jsx         # Componente principal
│   └── main.jsx        # Entry point
├── .env.development    # Variables de entorno (desarrollo)
├── .env.production     # Variables de entorno (producción)
└── vite.config.js      # Configuración de Vite
```

## Instalación

```bash
# Instalar dependencias
npm install

# Iniciar servidor de desarrollo
npm run dev

# Build para producción
npm run build

# Preview del build
npm run preview
```

## Scripts Disponibles

- `npm run dev` - Inicia el servidor de desarrollo
- `npm run build` - Genera el build de producción
- `npm run preview` - Preview del build de producción
- `npm run lint` - Ejecuta ESLint
- `npm run lint:fix` - Ejecuta ESLint y corrige errores
- `npm run format` - Formatea el código con Prettier
- `npm run format:check` - Verifica el formato del código

## Variables de Entorno

Crea un archivo `.env.development` o `.env.production` con las siguientes variables:

```env
VITE_API_BASE_URL=http://localhost:3000/api
VITE_APP_NAME=Sistema de Certificación de Cursos
VITE_APP_VERSION=1.0.0
```

## Funcionalidad Offline

La aplicación utiliza Service Workers para funcionar offline:

- **Network First**: Para llamadas a la API (caché de 5 minutos)
- **Cache First**: Para imágenes y assets estáticos (caché de 30 días)
- **Stale While Revalidate**: Para JS y CSS

## Instalación como PWA

La aplicación puede instalarse en dispositivos móviles y escritorio:

1. Abre la aplicación en un navegador compatible
2. Busca el botón "Instalar" o "Agregar a pantalla de inicio"
3. Sigue las instrucciones del navegador

## Desarrollo

### Agregar una nueva página

1. Crea el componente en `src/pages/`
2. Agrega la ruta en `src/App.jsx`
3. Si requiere autenticación, envuélvela en `<ProtectedRoute>`

### Agregar un nuevo servicio

1. Crea el servicio en `src/services/`
2. Usa la instancia de axios configurada en `src/services/api.js`

### Agregar un nuevo store

1. Crea el store en `src/store/`
2. Exporta el hook en `src/store/index.js`

## Testing

Los tests se agregarán en tareas futuras usando:
- Jest para unit tests
- fast-check para property-based tests
- Playwright/Cypress para E2E tests

## Despliegue

La aplicación puede desplegarse en:
- Vercel
- Netlify
- AWS S3 + CloudFront
- Cualquier hosting de archivos estáticos

**Importante**: La PWA requiere HTTPS para funcionar correctamente.

## Licencia

Privado - Todos los derechos reservados

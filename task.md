# PromptVault - Complete Refactor Task List

## Objetivo General
Auditar, validar y refactorizar **TODOS** los archivos Blade, CSS y JavaScript de la aplicación PromptVault, manteniendo el diseño original hermoso y funcional.

## Resumen de Inventario
- **71 archivos .blade.php** en `resources/views/`
- **36 archivos .css** en `public/css/`
- **41 archivos .js** en `public/JavaScript/`

---

## 1. INVENTARIO COMPLETO - ARCHIVOS BLADE (.blade.php)

### 1.1 Authentication (3 archivos)
- `resources/views/auth/login.blade.php`
- `resources/views/auth/registro.blade.php`
- `resources/views/auth/recuperar.blade.php`

### 1.2 Admin Module (18 archivos)
#### Usuarios
- `resources/views/admin/usuarios/index.blade.php`
- `resources/views/admin/usuarios/create.blade.php`
- `resources/views/admin/usuarios/show.blade.php`
- `resources/views/admin/usuarios/edit.blade.php`

#### Roles
- `resources/views/admin/roles/index.blade.php`
- `resources/views/admin/roles/create.blade.php`
- `resources/views/admin/roles/show.blade.php`
- `resources/views/admin/roles/edit.blade.php`

#### Permisos
- `resources/views/admin/permisos/index.blade.php`
- `resources/views/admin/permisos/create.blade.php`
- `resources/views/admin/permisos/show.blade.php`
- `resources/views/admin/permisos/edit.blade.php`

#### Reportes
- `resources/views/admin/reportes/index.blade.php`
- `resources/views/admin/reportes/academicos.blade.php`
- `resources/views/admin/reportes/asistencias.blade.php`

#### Backups
- `resources/views/admin/backups/index.blade.php`

### 1.3 Prompts Module (6 archivos)
- `resources/views/prompts/index.blade.php`
- `resources/views/prompts/create.blade.php`
- `resources/views/prompts/show.blade.php`
- `resources/views/prompts/edit.blade.php`
- `resources/views/prompts/historial.blade.php`
- `resources/views/prompts/compartidos.blade.php`

### 1.4 Calendario Module (4 archivos)
- `resources/views/calendario/index.blade.php`
- `resources/views/calendario/create.blade.php`
- `resources/views/calendario/show.blade.php`
- `resources/views/calendario/edit.blade.php`

### 1.5 Perfil Module (4 archivos)
- `resources/views/perfil/index.blade.php`
- `resources/views/perfil/show.blade.php`
- `resources/views/perfil/edit.blade.php`
- `resources/views/perfil/security.blade.php`

### 1.6 Configuraciones Module (7 archivos)
- `resources/views/configuraciones/index.blade.php`
- `resources/views/configuraciones/general.blade.php`
- `resources/views/configuraciones/sistema.blade.php`
- `resources/views/configuraciones/seguridad.blade.php`
- `resources/views/configuraciones/apariencia.blade.php`
- `resources/views/configuraciones/notificaciones.blade.php`
- `resources/views/configuraciones/respaldos.blade.php`

### 1.7 Components (8 archivos)
#### Role Components
- `resources/views/components/administrador.blade.php`
- `resources/views/components/usuario.blade.php`
- `resources/views/components/colaborador.blade.php`
- `resources/views/components/invitado.blade.php`

#### Prompt Components
- `resources/views/components/prompt/card.blade.php`
- `resources/views/components/prompt/grid.blade.php`
- `resources/views/components/prompt/filters.blade.php`

#### Utility Components
- `resources/views/components/favicon.blade.php`
- `resources/views/components/chatbot-widget.blade.php`

### 1.8 Layouts (7 archivos)
- `resources/views/layouts/header.blade.php`
- `resources/views/layouts/footer.blade.php`
- `resources/views/layouts/sidebar.blade.php`
- `resources/views/layouts/sidebarAdmin.blade.php`
- `resources/views/layouts/sidebarUser.blade.php`
- `resources/views/layouts/sidebarCollaborator.blade.php`
- `resources/views/layouts/sidebarGuest.blade.php`
- `resources/views/layouts/loading.blade.php`

### 1.9 Errors (3 archivos)
- `resources/views/errors/403.blade.php`
- `resources/views/errors/404.blade.php`
- `resources/views/errors/500.blade.php`

### 1.10 Modals (3 archivos)
- `resources/views/mod/delete.blade.php`
- `resources/views/mod/error.blade.php`
- `resources/views/mod/success.blade.php`

### 1.11 Filters (1 archivo)
- `resources/views/filters/filtersUsuario.blade.php`

### 1.12 Buscador (1 archivo)
- `resources/views/buscador/index.blade.php`

### 1.13 Pages (4 archivos)
- `resources/views/pages/usuarios.blade.php`
- `resources/views/pages/roles.blade.php`
- `resources/views/pages/permisos.blade.php`
- `resources/views/pages/custom.blade.php`

### 1.14 Root Views (2 archivos)
- `resources/views/home.blade.php`
- `resources/views/dashboard.blade.php`

---

## 2. INVENTARIO COMPLETO - ARCHIVOS CSS (36 archivos)

### 2.1 Auth Styles (4 archivos)
- `public/css/auth/auth.css`
- `public/css/auth/login.css` (1574 líneas)
- `public/css/auth/registro.css` (1832 líneas)
- `public/css/auth/recuperar.css`

### 2.2 Admin Styles (16 archivos)
#### Usuarios
- `public/css/admin/usuarios/index.css`
- `public/css/admin/usuarios/create.css`
- `public/css/admin/usuarios/show.css`
- `public/css/admin/usuarios/edit.css`

#### Roles
- `public/css/admin/roles/index.css`
- `public/css/admin/roles/create.css`
- `public/css/admin/roles/show.css`
- `public/css/admin/roles/edit.css`

#### Permisos
- `public/css/admin/permisos/index.css`
- `public/css/admin/permisos/create.css`
- `public/css/admin/permisos/show.css`
- `public/css/admin/permisos/edit.css`

#### Reportes
- `public/css/admin/reportes/index.css`

### 2.3 Component Styles (5 archivos)
- `public/css/components/header.css`
- `public/css/components/footer.css`
- `public/css/components/sidebar.css`
- `public/css/components/loading.css`

### 2.4 Module Styles (8 archivos)
- `public/css/dashboard/dashboard.css`
- `public/css/calendario/index.css`
- `public/css/buscador/index.css`
- `public/css/configuraciones/configuraciones.css`
- `public/css/perfil/index.css`
- `public/css/perfil/edit.css`
- `public/css/filters/filtersUsuario.css`

### 2.5 Utilities (4 archivos)
- `public/css/layouts/loading.css`
- `public/css/pages/paginacion.css`
- `public/css/errors/403.css`
- `public/css/errors/404.css`
- `public/css/errors/500.css`
- `public/css/mod/advertencia.css`
- `public/css/mod/confirmar.css`
- `public/css/mod/eliminar.css`

---

## 3. INVENTARIO COMPLETO - ARCHIVOS JAVASCRIPT (41 archivos)

### 3.1 Auth Scripts (3 archivos)
- `public/JavaScript/auth/login.js`
- `public/JavaScript/auth/registro.js`
- `public/JavaScript/auth/recuperar.js`

### 3.2 Admin Scripts (16 archivos)
#### Usuarios
- `public/JavaScript/admin/usuarios/index.js`
- `public/JavaScript/admin/usuarios/create.js`
- `public/JavaScript/admin/usuarios/show.js`
- `public/JavaScript/admin/usuarios/edit.js`

#### Roles
- `public/JavaScript/admin/roles/index.js`
- `public/JavaScript/admin/roles/create.js`
- `public/JavaScript/admin/roles/show.js`
- `public/JavaScript/admin/roles/edit.js`

#### Permisos
- `public/JavaScript/admin/permisos/index.js`
- `public/JavaScript/admin/permisos/create.js`
- `public/JavaScript/admin/permisos/show.js`
- `public/JavaScript/admin/permisos/edit.js`

#### Reportes
- `public/JavaScript/admin/reportes/index.js`

### 3.3 Component Scripts (5 archivos)
- `public/JavaScript/components/header.js`
- `public/JavaScript/components/footer.js`
- `public/JavaScript/components/sidebar.js`
- `public/JavaScript/components/loading.js`
- `public/JavaScript/components/chatbot.js`

### 3.4 Layout Scripts (4 archivos)
- `public/JavaScript/layouts/header.js`
- `public/JavaScript/layouts/footer.js`
- `public/JavaScript/layouts/sidebar.js`
- `public/JavaScript/layouts/loading.js`

### 3.5 Dashboard Scripts (5 archivos)
- `public/JavaScript/components/dashboard.js`
- `public/JavaScript/dashboard/admin.js`
- `public/JavaScript/dashboard/user.js`
- `public/JavaScript/dashboard/collaborator.js`
- `public/JavaScript/dashboard/guest.js`

### 3.6 Module Scripts (5 archivos)
- `public/JavaScript/calendario/index.js`
- `public/JavaScript/buscador/index.js`
- `public/JavaScript/configuraciones/configuraciones.js`
- `public/JavaScript/perfil/index.js`
- `public/JavaScript/filters/filtersUsuario.js`

### 3.7 Utilities (6 archivos)
- `public/JavaScript/errors/403.js`
- `public/JavaScript/errors/404.js`
- `public/JavaScript/errors/500.js`
- `public/JavaScript/mod/advertencia.js`
- `public/JavaScript/mod/confirmar.js`
- `public/JavaScript/mod/eliminar.js`

---

## 4. PLAN DE REFACTOR - FASES

### FASE 1: Auditoría por Módulo (Prioridad Alta)
#### 1.1 Auth Module ✅ COMPLETADO
- [x] Verificar `login.blade.php` + `login.css` + `login.js`
- [x] Verificar `registro.blade.php` + `registro.css` + `registro.js`
- [x] Verificar `recuperar.blade.php` + `recuperar.css` + `recuperar.js`
- [x] Probar en navegador: /login, /register, /password/reset

#### 1.2 Layouts (Critical - afecta todo) ✅ COMPLETADO
- [x] Verificar `header.blade.php` + `header.css` + `header.js`
- [x] Verificar `footer.blade.php` + `footer.css` + `footer.js`
- [x] Verificar `sidebar.blade.php` + variantes por rol
- [x] Verificar `loading.blade.php`
- [x] Crear componente `AppLayout` unificado
- [x] Probar en / y /prompts
- [x] Implementar dark mode toggle con localStorage
- [x] Eliminar CSS/JS antiguos de layouts y components

#### 1.3 Components (Critical - reusables)
- [ ] Role components: administrador, usuario, colaborador, invitado
- [ ] Prompt components: card, grid, filters
- [ ] Chatbot widget

### FASE 2: Módulos Principales (Prioridad Media)
#### 2.1 Dashboard
- [ ] `dashboard.blade.php` + CSS + JS por rol
- [ ] `home.blade.php`

#### 2.2 Prompts
- [ ] index, create, show, edit, historial, compartidos
- [ ] Verificar componentes de prompt funcionan

#### 2.3 Perfil
- [ ] index, show, edit, security
- [ ] Verificar CSS/JS correspondientes

#### 2.4 Calendario
- [ ] index, create, show, edit
- [ ] Verificar calendario.css + calendario.js

### FASE 3: Admin Module (Prioridad Media)
- [ ] Admin/Usuarios: 4 vistas + CSS + JS
- [ ] Admin/Roles: 4 vistas + CSS + JS
- [ ] Admin/Permisos: 4 vistas + CSS + JS
- [ ] Admin/Reportes: 3 vistas + CSS + JS
- [ ] Admin/Backups: 1 vista

### FASE 4: Módulos Secundarios (Prioridad Baja)
- [ ] Configuraciones: 7 vistas
- [ ] Buscador
- [ ] Filters
- [ ] Pages
- [ ] Errors (403, 404, 500)
- [ ] Modals (delete, error, success)

---

## 5. ESTRATEGIA DE VALIDACIÓN

### Por cada vista Blade:
1. **Leer el archivo** - Identificar CSS/JS que carga
2. **Verificar assets existen** - Comprobar public/css/ y public/JavaScript/
3. **Verificar estructura** - HTML semántico, clases correctas
4. **Probar en navegador** - Ver si renderiza correctamente
5. **Consola del navegador** - Verificar no hay errores 404 o JS errors

### Checklist por archivo:
- [ ] Blade file existe y es válido
- [ ] CSS file existe y se carga
- [ ] JS file existe y se carga
- [ ] Imágenes/assets existen
- [ ] No hay errores en consola
- [ ] Responsive design funciona
- [ ] Interactividad JS funciona

---

## 6. HERRAMIENTAS Y COMANDOS

### Development Environment
```bash
# Terminal 1: Laravel Server
php artisan serve

# Terminal 2: Vite Asset Bundler
npm run dev
```

### Testing Routes
```
Auth:
http://127.0.0.1:8000/login
http://127.0.0.1:8000/register
http://127.0.0.1:8000/password/reset

Dashboard:
http://127.0.0.1:8000/dashboard
http://127.0.0.1:8000/

Prompts:
http://127.0.0.1:8000/prompts
http://127.0.0.1:8000/prompts/create

Admin:
http://127.0.0.1:8000/admin/usuarios
http://127.0.0.1:8000/admin/roles
http://127.0.0.1:8000/admin/permisos
```

### Browser Console Checks
- F12 → Console (verificar errores JS)
- F12 → Network (verificar 404 en CSS/JS)
- F12 → Elements (inspeccionar estilos aplicados)

---

## 7. CRITERIOS DE ÉXITO

### Para cada módulo completado:
✅ Todas las vistas Blade renderizan sin errores  
✅ Todos los CSS se cargan correctamente (no 404)  
✅ Todos los JS se cargan correctamente (no 404)  
✅ No hay errores en consola del navegador  
✅ Diseño responsive funciona (mobile, tablet, desktop)  
✅ Animaciones y transiciones funcionan  
✅ Formularios validan correctamente  
✅ Navegación entre páginas funciona  
✅ Imágenes y assets cargan correctamente  

---

## 8. REGISTRO DE PROGRESO - BITÁCORA

### Módulos completados: 2/14
- [x] Auth ✅
- [x] Layouts ✅
- [ ] Components  
- [ ] Dashboard
- [ ] Home
- [ ] Prompts
- [ ] Calendario
- [ ] Perfil
- [ ] Configuraciones
- [ ] Admin/Usuarios
- [ ] Admin/Roles
- [ ] Admin/Permisos
- [ ] Admin/Reportes
- [ ] Errors/Modals/Utilities

### Archivos validados: 18/148 total
- Blade: 18/71 (Auth: 3, Layouts: 8, Components: 7)
- CSS: 0/36 (migrando a Tailwind)
- JS: 0/41 (migrando a Alpine)

---

## 9. BITÁCORA DE CAMBIOS - SESIÓN ACTUAL (20/01/2026)

### ✅ FASE 1.1: AUTH MODULE - COMPLETADO

#### Cambios Realizados:

**1. Componente Blade Unificado**
- Creado: `app/View/Components/AppAuth.php`
  - Clase que renderiza `layouts.app-auth`
  - Props: `$title`, `$description`, `$brandingTitle`, `$brandingText`
  - Uso: `<x-app-auth>` en todas las vistas auth

**2. Layout Compartido**
- Creado: `resources/views/layouts/app-auth.blade.php`
  - Diseño responsive con 2 paneles (branding + form)
  - Panel izquierdo: Logo, descripción, features (desktop only)
  - Panel derecho: Espacio para formularios
  - Fondo animado con gradientes, engranajes, LEDs, partículas
  - Integración: Tailwind + Alpine via `@vite(['resources/css/app.css', 'resources/js/app.js'])`
  - **Fix padding**: Cambio de `p-4 sm:p-6 lg:p-8` a `px-4 sm:px-6 lg:px-8` (elimina scroll innecesario)

**3. Refactor Vistas Auth**
- `resources/views/auth/login.blade.php`
  - Refactorizado: Usa `<x-app-auth>` component
  - Funcionalidad: Login form con remember me
  - Alpine: Toggle password visibility
  - Backup creado: `login.blade.php.backup`

- `resources/views/auth/registro.blade.php`
  - Refactorizado: Usa `<x-app-auth>` component
  - Funcionalidad: 2-step registration (datos + verificación)
  - **Fix Route**: Guard `register.verify` route - solo renderiza si ruta existe
  - **Fix Validation**: Agregado checkbox `acepta_terminos` requerido
  - Alpine: Step toggle, password visibility, loading states
  - Backup creado: `registro.blade.php.backup`

- `resources/views/auth/recuperar.blade.php`
  - Refactorizado: Usa `<x-app-auth>` component
  - Funcionalidad: Password reset flow
  - Alpine: Toggle entre email y reset form
  - Backup creado: `recuperar.blade.php.backup`

#### Archivos Eliminados (no más necesarios):
- ❌ `public/css/auth/auth.css`
- ❌ `public/css/auth/login.css` (1574 líneas)
- ❌ `public/css/auth/registro.css` (1832 líneas)
- ❌ `public/css/auth/recuperar.css`
- ❌ `public/JavaScript/auth/login.js`
- ❌ `public/JavaScript/auth/registro.js`
- ❌ `public/JavaScript/auth/recuperar.js`

#### Estrategia CSS/JS:
- **CSS**: Todo vía Tailwind en `resources/css/app.css`
- **JS**: Todo vía Alpine en `resources/js/app.js`
- **Resultado**: -7 archivos legados, -4407 líneas de código redundante

#### Validación:
- ✅ `/login` renderiza sin errores
- ✅ `/register` renderiza sin errores  
- ✅ `/password/reset` renderiza sin errores
- ✅ No hay 404 en CSS/JS
- ✅ No hay errores en consola
- ✅ Alpine carga correctamente via Vite
- ✅ Tailwind aplica estilos correctamente
- ✅ Responsive design funciona (mobile, tablet, desktop)
- ✅ Formularios validan correctamente

---

### 🔄 FASE 1.2: LAYOUTS MODULE - ✅ COMPLETADO

#### Cambios Realizados:

**1. Componente AppLayout Unificado**
- Creado: `app/View/Components/AppLayout.php`
  - Clase que renderiza `layouts.app`
  - Props: `$title`
  - Uso: `<x-app-layout>` en todas las vistas principales

**2. Layout Principal Refactorizado**
- Creado: `resources/views/layouts/app.blade.php`
  - Diseño dashboard: sidebar + header + main + footer
  - Dark mode por defecto con toggle funcional
  - Layout flex con gap-6 y padding
  - Main content: responsive bg (dark/light mode)
  - Integración: FontAwesome 6.4 + Montserrat font
  - Stack support: `@stack('styles')` y `@stack('scripts')`
  - **Dark mode toggle**: Alpine + localStorage persistence

**3. Componentes de Layout (Tailwind/Alpine)**
- `resources/views/components/layout/header.blade.php`
  - Header sticky con búsqueda global
  - Quick actions: crear prompt
  - Notificaciones + perfil dropdown (Alpine)
  - Dark mode support: `dark:bg-slate-900 dark:text-slate-100`

- `resources/views/components/layout/sidebar.blade.php`
  - Sidebar sticky con logo y rol
  - Navegación por rol (admin/user/collaborator/guest)
  - Secciones colapsables (Alpine x-data)
  - **Theme toggle button**: Cambia dark/light mode
  - Dark mode support: `dark:bg-slate-900 dark:border-slate-700`

- `resources/views/components/layout/footer.blade.php`
  - Footer con contacto + info PromptVault
  - Links + copyright dinámico
  - Dark mode support: `dark:bg-slate-900 dark:text-slate-400`

- `resources/views/components/layout/loading.blade.php`
  - Overlay de carga (Alpine)
  - Animación spinner
  - Dark mode aware

**4. Home Page Migrada**
- `resources/views/home.blade.php`
  - Refactorizado: Tailwind + Alpine (sin Bootstrap)
  - Navbar con toggle dark/light mode funcional
  - Hero section con gradient text
  - Filtros de prompts migrados a Tailwind
  - Dark mode: Fondo azul slate `#0f172a → #1e293b`
  - Light mode: Fondo gris `#f1f5f9 → #e2e8f0`

**5. Vistas Migradas con Dark Mode**
- `resources/views/prompts/index.blade.php`
  - Refactorizado: Usa `<x-app-layout>`
  - Búsqueda + filtrado por etiquetas (Alpine)
  - Grid responsive de prompts
  - **Dark mode completo**: Cards, inputs, botones, empty state
  - Tailwind: `dark:bg-slate-800 dark:text-slate-100`
  - **Fix Blade**: Todos los `@php(...)` → `@php ... @endphp`

**6. Componentes Migrados**
- `resources/views/components/prompt/filters.blade.php`
  - Migrado a Tailwind puro (sin estilos inline)
  - Selects legibles: `bg-white dark:bg-slate-800` con options visibles
  - Focus states: `focus:border-rose-500 focus:ring-2`

#### Archivos Eliminados:
- ❌ `public/css/layouts/loading.css`
- ❌ `public/css/components/header.css` (942 líneas)
- ❌ `public/css/components/sidebar.css` (434 líneas)
- ❌ `public/css/components/footer.css`
- ❌ `public/css/components/loading.css`
- ❌ `public/JavaScript/layouts/header.js`
- ❌ `public/JavaScript/layouts/footer.js`
- ❌ `public/JavaScript/layouts/sidebar.js`
- ❌ `public/JavaScript/layouts/loading.js`

**Total eliminado:** 9 archivos CSS/JS antiguos (~2,000+ líneas)

#### Configuración Tailwind:
- Agregado: `darkMode: 'class'` en `tailwind.config.js`
- Variables CSS mantenidas para compatibilidad temporal

#### Estrategia Dark Mode:
- **Implementación**: Alpine function `themeToggle()` en body
- **Persistencia**: localStorage key `theme`
- **Colores Dark**:
  - Background: `#0f172a → #1e293b` (slate-900 → slate-800)
  - Cards: `bg-slate-900` / `bg-slate-800`
  - Text: `text-slate-100` / `text-slate-400`
  - Borders: `border-slate-700`
- **Colores Light**:
  - Background: `#f1f5f9 → #e2e8f0` (slate-50 → slate-200)
  - Cards: `bg-white`
  - Text: `text-slate-900` / `text-slate-600`
  - Borders: `border-slate-200`

#### Validación:
- ✅ `/` renderiza sin errores con dark mode
- ✅ `/prompts` renderiza sin errores con dark mode
- ✅ Toggle theme funciona y persiste
- ✅ Selects legibles en ambos modos
- ✅ No hay 404 en assets
- ✅ No hay errores en consola
- ✅ Alpine carga correctamente
- ✅ Responsive design funciona
- ✅ Navegación sidebar funciona

#### Próximos Pasos:
- [ ] FASE 1.3: Components (prompt cards detallados, chatbot)
- [ ] FASE 2.1: Dashboard por rol
- [ ] FASE 2.2: Prompts CRUD completo

---

#### Total de Cambios Fase 1.2:
- **Componentes creados:** AppLayout class + 4 layout components = 5
- **Layouts actualizados:** app.blade.php + home.blade.php + prompts/index.blade.php = 3
- **Componentes actualizados:** prompt/filters.blade.php = 1
- **CSS/JS eliminados:** 9 archivos (~2,000+ líneas)
- **Features agregadas:** Dark mode toggle con localStorage

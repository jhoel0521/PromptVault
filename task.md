# PromptVault - Complete Refactor Task List

## Objetivo General
Auditar, validar y refactorizar **TODOS** los archivos Blade, CSS y JavaScript de la aplicación PromptVault, manteniendo el diseño original hermoso y funcional.

## 🔴 TAREAS CRÍTICAS DE SEGURIDAD

### ⚠️ AUDITORÍA DE AUTORIZACIÓN (PRIORIDAD ALTA)
**Problema detectado:** Usuarios sin permisos pueden ver paneles de administración/compartir en `/prompts/{id}`

**Áreas a auditar:**
1. **PromptPolicy** (`app/Policies/PromptPolicy.php`)
   - ✅ Métodos: `view()`, `update()`, `delete()`, `share()` están bien definidos
   - ✅ Usa `CompartirService` correctamente para verificar acceso
   
2. **CompartirService** (`app/Services/CompartirService.php`)
   - ✅ `verificarAcceso()`: Lógica correcta (propietario > admin > acceso compartido > público)
   - ✅ `puedeEditar()`: Verifica ['propietario', 'editor']
   - ✅ `puedeComentar()`: Verifica ['propietario', 'editor', 'comentador']

3. **FormRequests con authorize()** (BIEN IMPLEMENTADO ✅)
   - ✅ `CompartirPromptRequest::authorize()`: Verifica `can('share', $prompt)`
   - [ ] Verificar otros FormRequests: UpdatePromptRequest, StorePromptRequest

4. **Routes** (`routes/web.php` líneas 55-62)
   - ⚠️ **FALTA**: No tienen middleware `can:` explícito
   - ✅ Pero usan Route Model Binding: `Route::resource('prompts')` aplica policies automáticamente
   - ✅ Routes personalizadas: authorize() en FormRequests o controladores
   - [ ] **VERIFICAR:** ¿Funciona autorización implícita con `Route::resource()`?

5. **Vistas a validar:**
   - [ ] `resources/views/prompts/show.blade.php` líneas 76-100
     - **@can('update')**: Panel "Acciones" con botones Editar/Eliminar
     - **@can('delete')**: Botón eliminar
     - **@can('share')**: Panel "Compartir Acceso" con formulario
     - **Verificar:** ¿Se renderiza el sidebar vacío si no tiene permisos?
     - **PROBLEMA:** Usuario sin permisos ve sidebar completo (posible fallo en @can)
   
   - [ ] `resources/views/prompts/edit.blade.php`
     - **FormRequest:** ✅ UpdatePromptRequest debe tener authorize()
     - **Controlador:** ✅ `update()` usa FormRequest con authorize()
   
   - [ ] `resources/views/prompts/historial.blade.php`
     - **Ruta:** Necesita verificar autorización para ver historial
     - **Botón restaurar:** ✅ `restaurarVersion()` debe verificar `can('update')`
   
   - [ ] Otros CRUD: create, destroy, compartir, quitarAcceso
     - ✅ `compartir()`: Usa CompartirPromptRequest::authorize()
     - [ ] `destroy()`: Verificar tiene `$this->authorize('delete', $prompt)`
     - [ ] `quitarAcceso()`: Verificar autorización
     - [ ] `restaurarVersion()`: Verificar autorización

6. **Routes a auditar** (`routes/web.php`)
   - ⚠️ No tienen middleware explícito pero Route::resource() aplica policies automáticamente
   - [ ] Verificar que `Route::resource('prompts')` autoriza correctamente edit/update/destroy
   - [ ] Agregar middleware a rutas personalizadas:
     - `->middleware('can:update,prompt')` en historial, restaurarVersion
     - `->middleware('can:share,prompt')` en compartir (ya tiene en FormRequest)
     - `->middleware('can:delete,prompt')` en quitarAcceso

7. **Controladores a auditar:**
   - [ ] `app/Http/Controllers/PromptController.php`
     - Métodos: store, update, destroy, restaurar
   - [ ] `app/Http/Controllers/CompartirController.php`
     - Métodos: compartir, removeAcceso
   - [ ] Controladores Admin (usuarios, roles, permisos)

**Acción inmediata:**
- Crear rama `security/authorization-audit`
- Revisar cada @can en vistas y agregar else con mensajes apropiados
- Auditar todos los métodos de controladores con `$this->authorize()`
- Agregar tests de autorización: `test_user_cannot_edit_others_prompts()`

---

## Resumen de Inventario
- **65 archivos .blade.php** en `resources/views/` (15 procesados, 50 pendientes)
  - Auth: 3 ✅ | Prompts: 6 ✅ | Calendario: 4 ✅ | Home: 1 ✅ | Perfil: 4 ✅ | Components: 8 (4 layout + 3 prompt + 1 user-avatar) ✅
  - Eliminados: dashboard.blade.php (1)
- **23 archivos .css** restantes en `public/css/` (13 eliminados, 23 pendientes migración)
  - Eliminados: auth (4), dashboard (1), layouts (1), components (4), perfil (3)
- **27 archivos .js** restantes en `public/JavaScript/` (14 eliminados, 27 pendientes migración)
  - Eliminados: auth (3), dashboard (5), layouts (4), chatbot (1), perfil (1)

---

## 1. INVENTARIO COMPLETO - ARCHIVOS BLADE (.blade.php)

### 1.1 Authentication (3 archivos) ✅
- `resources/views/auth/login.blade.php` ✅
- `resources/views/auth/registro.blade.php` ✅
- `resources/views/auth/recuperar.blade.php` ✅

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

### 1.3 Prompts Module (6 archivos) ✅ COMPLETADO
- `resources/views/prompts/index.blade.php` ✅
- `resources/views/prompts/create.blade.php` ✅ MIGRADO (Tailwind + dark mode)
- `resources/views/prompts/show.blade.php` ✅ MIGRADO (layout 2 cols, compartir, historial)
- `resources/views/prompts/edit.blade.php` ✅ MIGRADO (formulario con PUT, mensaje_cambio)
- `resources/views/prompts/historial.blade.php` ✅ MIGRADO (tabla de versiones, restaurar)
- `resources/views/prompts/compartidos.blade.php` ✅ MIGRADO (grid de prompts compartidos)

### 1.4 Calendario Module (4 archivos) ✅ COMPLETADO
- `resources/views/calendario/index.blade.php` ✅ MIGRADO (FullCalendar CDN)
- `resources/views/calendario/create.blade.php` ✅ MIGRADO (formulario con datetime-local)
- `resources/views/calendario/show.blade.php` ✅ MIGRADO (detalle con gradient header)
- `resources/views/calendario/edit.blade.php` ✅ MIGRADO (formulario con PUT)

### 1.5 Perfil Module (4 archivos) ✅ COMPLETADO
- `resources/views/perfil/index.blade.php` ✅ MIGRADO (stats + profile card + info grid + activity timeline)
- `resources/views/perfil/show.blade.php` (vacío - solo comentario)
- `resources/views/perfil/edit.blade.php` ✅ MIGRADO (formulario edición + avatar upload + sidebar sticky)
- `resources/views/perfil/security.blade.php` ✅ MIGRADO (cambiar contraseña + recomendaciones seguridad)

### 1.6 Configuraciones Module (7 archivos)
- `resources/views/configuraciones/index.blade.php`
- `resources/views/configuraciones/general.blade.php`
- `resources/views/configuraciones/sistema.blade.php`
- `resources/views/configuraciones/seguridad.blade.php`
- `resources/views/configuraciones/apariencia.blade.php`
- `resources/views/configuraciones/notificaciones.blade.php`
- `resources/views/configuraciones/respaldos.blade.php`

### 1.7 Components ✅ FASE COMPLETA
#### Layout Components (MIGRADOS A components/layout/)
- `resources/views/components/layout/header.blade.php` ✅ MIGRADO (Tailwind + Alpine)
- `resources/views/components/layout/sidebar.blade.php` ✅ MIGRADO (navegación por rol + dark mode toggle + link calendario)
- `resources/views/components/layout/footer.blade.php` ✅ MIGRADO (contacto + copyright)
- `resources/views/components/layout/loading.blade.php` ✅ MIGRADO (overlay Alpine)

#### Layouts Principales (resources/views/layouts/)
- `resources/views/layouts/app.blade.php` ✅ CREADO (layout principal dashboard con sidebar + header + footer)
- `resources/views/layouts/app-auth.blade.php` ✅ CREADO (layout auth con branding panel)

#### Layouts Obsoletos ELIMINADOS
- `resources/views/layouts/header.blade.php` ❌ ELIMINADO
- `resources/views/layouts/footer.blade.php` ❌ ELIMINADO
- `resources/views/layouts/sidebar.blade.php` ❌ ELIMINADO
- `resources/views/layouts/sidebarAdmin.blade.php` ❌ ELIMINADO
- `resources/views/layouts/sidebarUser.blade.php` ❌ ELIMINADO
- `resources/views/layouts/sidebarCollaborator.blade.php` ❌ ELIMINADO
- `resources/views/layouts/sidebarGuest.blade.php` ❌ ELIMINADO
- `resources/views/layouts/loading.blade.php` ❌ ELIMINADO

#### Role Components (ELIMINADOS - usaban @extends/@yield prohibidos)
- `resources/views/components/administrador.blade.php` ❌ ELIMINADO (688 líneas)
- `resources/views/components/usuario.blade.php` ❌ ELIMINADO (543 líneas)
- `resources/views/components/colaborador.blade.php` ❌ ELIMINADO (545 líneas)
- `resources/views/components/invitado.blade.php` ❌ ELIMINADO (710 líneas)

#### Prompt Components (MIGRADOS)
- `resources/views/components/prompt/card.blade.php` ✅ MIGRADO (inline styles → Tailwind dark mode)
- `resources/views/components/prompt/grid.blade.php` ✅ MIGRADO (responsive grid + pagination)
- `resources/views/components/prompt/filters.blade.php` ✅ MIGRADO (selects con dark mode)

#### Utility Components (MIGRADOS)
- `resources/views/components/favicon.blade.php` ✅ (sin cambios necesarios)
- `resources/views/components/chatbot-widget.blade.php` ✅ MIGRADO (Alpine + Tailwind, eliminado chatbot.js)

### 1.8 Layouts - ❌ SECCIÓN OBSOLETA (ver 1.7 Components)
**NOTA**: Esta sección está desactualizada. Los layouts se migraron como se documenta en sección 1.7 Components.

- Layouts principales: `app.blade.php` + `app-auth.blade.php` en `resources/views/layouts/`
- Componentes layout: migrados a `resources/views/components/layout/`
- Layouts antiguos por rol: TODOS ELIMINADOS

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

### 1.13 Pages (3 archivos)
- `resources/views/pages/roles.blade.php`
- `resources/views/pages/permisos.blade.php`
- `resources/views/pages/custom.blade.php`

### 1.14 Root Views (1 archivo procesado, 1 eliminado)
- `resources/views/home.blade.php` ✅ MIGRADO (Tailwind + Alpine + dark mode)
- `resources/views/dashboard.blade.php` ❌ ELIMINADO (obsoleto, redirige a /prompts)

---

## 2. INVENTARIO COMPLETO - ARCHIVOS CSS (26 restantes)

### 2.1 Auth Styles (4 archivos) ✅ ELIMINADOS
- `public/css/auth/auth.css` ❌ ELIMINADO
- `public/css/auth/login.css` (1574 líneas) ❌ ELIMINADO
- `public/css/auth/registro.css` (1832 líneas) ❌ ELIMINADO
- `public/css/auth/recuperar.css` ❌ ELIMINADO

### 2.2 Admin Styles (16 archivos) PENDIENTES MIGRACIÓN
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

### 2.3 Component Styles (4 archivos) ✅ ELIMINADOS
- `public/css/components/header.css` ❌ ELIMINADO
- `public/css/components/footer.css` ❌ ELIMINADO
- `public/css/components/sidebar.css` ❌ ELIMINADO
- `public/css/components/loading.css` ❌ ELIMINADO

### 2.4 Module Styles (6 archivos restantes) - 2 eliminados
- `public/css/dashboard/dashboard.css` ❌ ELIMINADO
- `public/css/layouts/loading.css` ❌ ELIMINADO
- `public/css/calendario/index.css` (pendiente eliminar)
- `public/css/buscador/index.css`
- `public/css/configuraciones/configuraciones.css`
- `public/css/perfil/index.css`
- `public/css/perfil/edit.css`
- `public/css/filters/filtersUsuario.css`

### 2.5 Utilities (6 archivos) PENDIENTES
- `public/css/pages/paginacion.css`
- `public/css/errors/403.css`
- `public/css/errors/404.css`
- `public/css/errors/500.css`
- `public/css/mod/advertencia.css`
- `public/css/mod/confirmar.css`
- `public/css/mod/eliminar.css`

---

## 3. INVENTARIO COMPLETO - ARCHIVOS JAVASCRIPT (29 restantes)

### 3.1 Auth Scripts (3 archivos) ✅ ELIMINADOS
- `public/JavaScript/auth/login.js` ❌ ELIMINADO
- `public/JavaScript/auth/registro.js` ❌ ELIMINADO
- `public/JavaScript/auth/recuperar.js` ❌ ELIMINADO

### 3.2 Admin Scripts (16 archivos) PENDIENTES MIGRACIÓN
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

### 3.3 Component Scripts (4 archivos) - 1 eliminado, 4 pendientes
- `public/JavaScript/components/header.js`
- `public/JavaScript/components/footer.js`
- `public/JavaScript/components/sidebar.js`
- `public/JavaScript/components/loading.js`
- `public/JavaScript/components/dashboard.js`
- `public/JavaScript/components/chatbot.js` ❌ ELIMINADO (migrado a Alpine)

### 3.4 Layout Scripts (4 archivos) ✅ ELIMINADOS
- `public/JavaScript/layouts/header.js` ❌ ELIMINADO
- `public/JavaScript/layouts/footer.js` ❌ ELIMINADO
- `public/JavaScript/layouts/sidebar.js` ❌ ELIMINADO
- `public/JavaScript/layouts/loading.js` ❌ ELIMINADO

### 3.5 Dashboard Scripts (4 archivos) ✅ ELIMINADOS
- `public/JavaScript/dashboard/admin.js` ❌ ELIMINADO
- `public/JavaScript/dashboard/user.js` ❌ ELIMINADO
- `public/JavaScript/dashboard/collaborator.js` ❌ ELIMINADO
- `public/JavaScript/dashboard/guest.js` ❌ ELIMINADO

### 3.6 Module Scripts (5 archivos) PENDIENTES
- `public/JavaScript/calendario/index.js` (pendiente eliminar)
- `public/JavaScript/buscador/index.js`
- `public/JavaScript/configuraciones/configuraciones.js`
- `public/JavaScript/perfil/index.js`
- `public/JavaScript/filters/filtersUsuario.js`

### 3.7 Utilities (6 archivos) PENDIENTES
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

#### 1.3 Components (Critical - reusables) ✅ COMPLETADO
- [x] Role components: administrador, usuario, colaborador, invitado → ELIMINADOS (usaban @extends/@yield)
- [x] Prompt components: card, grid, filters → MIGRADOS a Tailwind con dark mode
- [x] Chatbot widget → MIGRADO a Alpine (eliminado chatbot.js externo)
- [x] Actualizar task.md inventario
- [ ] Chatbot widget

### FASE 2: Módulos Principales (Prioridad Media)
#### 2.1 Dashboard (PENDIENTE - dashboard.blade.php eliminado)
- [ ] Verificar rutas redirijan a /prompts correctamente

#### 2.2 Prompts ✅ COMPLETADO
- [x] index, create, show, edit, historial, compartidos (6 vistas)
- [x] Verificar componentes de prompt funcionan
- [x] Dark mode completo en todas las vistas

#### 2.3 Calendario ✅ COMPLETADO
- [x] index (FullCalendar CDN), create, show, edit (4 vistas)
- [x] Backend: migración + modelo + enum + controller
- [x] Eventos multi-día funcionales
- [x] Link calendario en sidebar

#### 2.4 Perfil (PENDIENTE)
- [ ] index, show, edit, security (4 vistas)
- [ ] Verificar CSS/JS correspondientes

#### 2.5 Configuraciones (PENDIENTE)
- [ ] 7 vistas pendientes migración

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

### Módulos completados: 6/14
- [x] Auth ✅
- [x] Layouts ✅
- [x] Components ✅
- [x] Prompts ✅
- [x] Calendario ✅
- [x] Perfil ✅
- [ ] Configuraciones
- [ ] Admin/Usuarios
- [ ] Admin/Roles
- [ ] Admin/Permisos
- [ ] Admin/Reportes
- [ ] Errors/Modals/Utilities

### Archivos validados: 15/65 total (23%)
- Blade: 15/65 procesados (Auth: 3 ✅, Prompts: 6 ✅, Calendario: 4 ✅, Home: 1 ✅, Perfil: 4 ✅, Components: 12 ✅)
  - Eliminados: 5 (dashboard.blade.php + 4 role components)
  - Total real: 65 archivos blade en proyecto (validado 20/01/2026)
- CSS: 13/36 eliminados → 23 restantes
  - Eliminados: auth (4), dashboard (1), layouts (1), components (4), perfil (3)
  - Pendientes migrar: 23 archivos
- JS: 14/41 eliminados → 27 restantes
  - Eliminados: auth (3), dashboard (5), layouts (4), chatbot (1), perfil (1)
  - Pendientes migrar: 27 archivos

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
- [x] FASE 1.3: Components ✅ COMPLETADO
- [ ] FASE 2.1: Dashboard por rol
- [ ] FASE 2.2: Prompts CRUD completo

---

#### Total de Cambios Fase 1.2:
- **Componentes creados:** AppLayout class + 4 layout components = 5
- **Layouts actualizados:** app.blade.php + home.blade.php + prompts/index.blade.php = 3
- **Componentes actualizados:** prompt/filters.blade.php = 1
- **CSS/JS eliminados:** 9 archivos (~2,000+ líneas)
- **Features agregadas:** Dark mode toggle con localStorage

---

### 🔄 FASE 1.3: COMPONENTS MODULE - ✅ COMPLETADO

#### Cambios Realizados:

**1. Prompt Components Migrados a Tailwind**
- `resources/views/components/prompt/card.blade.php`
  - Migrado: Inline styles → Tailwind classes
  - Dark mode: `bg-white dark:bg-slate-800`, borders, text colors
  - Hover effects: `-translate-y-1 hover:shadow-lg`
  - Avatar gradient: `bg-gradient-to-tr from-rose-500 to-blue-500`
  - Action buttons: `bg-rose-100 dark:bg-rose-900/30`

- `resources/views/components/prompt/grid.blade.php`
  - Migrado: Inline styles → Tailwind grid system
  - Responsive grid: `grid-cols-1 md:grid-cols-2 xl:grid-cols-3`
  - Pagination: Dark mode support con `dark:bg-slate-800`
  - Empty state: Centrado con iconos

**2. Chatbot Widget Refactorizado (Alpine + Tailwind)**
- `resources/views/components/chatbot-widget.blade.php`
  - **Migrado completamente**: Inline styles → Tailwind, JS externo → Alpine
  - **Ruta API corregida**: `/api/chatbot` → `{{ route('chatbot.ask') }}` (`/chatbot/ask`)
  - **Parámetro corregido**: Backend esperaba `message` en vez de `question`
  - **Markdown parser**: Función global `parseMarkdown()` fuera de Alpine
    - Soporta: `**negrita**`, `*cursiva*`, listas `*`, links `[texto](url)`, URLs auto-link
  - **Related Prompts**: Tarjetas bonitas con hover effects
    - Ícono bookmark rosa + título + descripción
    - Clickeable a `/prompts/{id}`
  - **Animaciones**: x-transition para open/close smooth
  - **Loading state**: 3 dots animados con `animate-bounce` staggered
  - **Diseño**: Botón flotante gradient rose + ventana 600px con chat

**3. Role Components Eliminados**
- ❌ `resources/views/components/administrador.blade.php` (688 líneas)
- ❌ `resources/views/components/usuario.blade.php` (543 líneas)  
- ❌ `resources/views/components/colaborador.blade.php` (545 líneas)
- ❌ `resources/views/components/invitado.blade.php` (710 líneas)
- **Razón**: Usaban `@extends`/`@yield` prohibidos por AGENTS.md
- **Reemplazo**: AppLayout unificado (`resources/views/layouts/app.blade.php`)

#### Archivos Eliminados:
- ❌ `public/JavaScript/components/chatbot.js` (migrado a Alpine)
- ❌ 4 layouts de roles obsoletos (2,486 líneas total)

**Total eliminado:** 5 archivos (2,486+ líneas)

#### Correcciones Backend:
- `app/Http/Controllers/ChatbotController.php`
  - Validación cambiada: `'question'` → `'message'`
  - Request input cambiado: `$request->input('question')` → `$request->input('message')`

#### Funcionalidad Chatbot:
- **Input**: Usuario escribe mensaje
- **Loading**: Muestra 3 dots animados
- **Respuesta**: Parsea Markdown automáticamente
- **Related Prompts**: Si existen, muestra tarjetas clickeables debajo de respuesta
- **Scroll**: Auto-scroll al último mensaje con `$nextTick()`
- **Error handling**: Catch con mensaje amigable

#### Validación:
- ✅ Prompt cards renderizan con dark mode
- ✅ Prompt grid responsive funciona
- ✅ Chatbot abre/cierra con animaciones
- ✅ Chatbot envía mensajes correctamente
- ✅ Respuestas con Markdown se renderizan bien (**negrita**, *cursiva*, links)
- ✅ Related prompts muestran tarjetas clickeables
- ✅ No hay errores en consola
- ✅ No hay 404 en assets
- ✅ Alpine maneja estado correctamente

---

#### Total de Cambios Fase 1.3:
- **Componentes migrados:** prompt/card + prompt/grid + chatbot-widget = 3
- **Componentes eliminados:** 4 role layouts obsoletos
- **JS eliminados:** chatbot.js (migrado a Alpine)
- **Líneas eliminadas:** ~2,500
- **Features agregadas:** Markdown parser, related prompts cards, animaciones smooth

---

### 🔄 FASE 2.2: PROMPTS MODULE - ✅ COMPLETADO

#### Cambios Realizados:

**1. Vista Create (Crear Prompt)**
- `resources/views/prompts/create.blade.php`
  - Migrado: `@extends('components.usuario')` → `<x-app-layout>`
  - Formulario completo con dark mode
  - Inputs/textareas: `bg-white dark:bg-slate-900` con borders slate
  - Select visibilidad: opciones con `class="bg-white dark:bg-slate-900"`
  - Select etiquetas multi-select: height 120px, options con bg dark
  - Validación Laravel: `@error` con mensajes rojos
  - Botones: Cancelar (ghost) + Guardar (rose-600 gradient shadow)

**2. Vista Show (Detalle del Prompt)**
- `resources/views/prompts/show.blade.php`
  - Layout 2 columnas responsive: `grid-cols-1 lg:grid-cols-3`
  - **Columna principal (2/3)**:
    - Header con botón volver + título + descripción
    - Caja del prompt: bg slate-50/900, header con badge "PROMPT", botón copiar
    - Pre tag con `font-mono whitespace-pre-wrap`
    - Sección comentarios: avatares gradient, cards con flex
  - **Sidebar (1/3)**:
    - Panel acciones CRUD: botones editar (blue-100/900) + eliminar (red-100/900)
    - Metadatos: visibilidad badge, vistas, versión, fecha
    - Etiquetas: chips con color_hex del backend
    - Compartir: formulario + lista usuarios con botón quitar acceso
  - **Historial versiones**: Tabla completa con hover, botón restaurar
  - **Scripts**: copyPrompt(), toggleFavorite(), confirmDelete()

**3. Vista Edit (Editar Prompt)**
- `resources/views/prompts/edit.blade.php`
  - Formulario idéntico a create pero con `@method('PUT')`
  - Pre-llenado con `{{ old('campo', $prompt->campo) }}`
  - Select etiquetas: pre-selección con `in_array($etiqueta->id, $prompt->etiquetas->pluck('id')->toArray())`
  - Panel de versiones: textarea mensaje_cambio obligatorio
  - Botón "Actualizar Prompt" en rose-600

**4. Vista Historial (Versiones)**
- `resources/views/prompts/historial.blade.php`
  - Header con botón volver + título del prompt
  - Stats cards: Total versiones, versión actual, última actualización
  - Tabla completa de versiones con columnas: #, Fecha, Usuario, Mensaje, Acciones
  - Badge "ACTUAL" en verde para versión activa
  - Botones: Ver diff (yellow) + Restaurar (blue) con confirmación
  - Modal/acordeón para diff: muestra contenido anterior vs nuevo
  - Responsive: tabla con overflow-x-auto

**5. Vista Compartidos Conmigo**
- `resources/views/prompts/compartidos.blade.php`
  - Grid de prompts compartidos: usa `<x-prompt.grid>`
  - Filter por nivel de acceso: "Todos", "Lectura", "Edición"
  - Empty state: mensaje cuando no hay prompts compartidos
  - Badge de acceso: "Solo Lectura" (blue) o "Editor" (green)
  - Stats: contador de prompts compartidos por tipo

**6. Dashboard Obsoleto Eliminado**
- ❌ `resources/views/dashboard.blade.php` - Intentaba incluir components eliminados
- ❌ `public/css/dashboard/dashboard.css`
- ❌ `public/JavaScript/dashboard/admin.js`
- ❌ `public/JavaScript/dashboard/user.js`
- ❌ `public/JavaScript/dashboard/collaborator.js`
- ❌ `public/JavaScript/dashboard/guest.js`

**Total eliminado:** 6 archivos dashboard obsoletos

#### Validación:
- ✅ `/prompts/create` renderiza sin errores
- ✅ `/prompts/{id}` muestra detalle completo con sidebar
- ✅ `/prompts/{id}/edit` pre-llena formulario correctamente
- ✅ `/prompts/{id}/historial` muestra tabla de versiones
- ✅ `/compartidos-conmigo` lista prompts compartidos
- ✅ Todos los formularios validan con Laravel
- ✅ Dark mode funciona en todas las vistas
- ✅ Selects legibles en ambos modos
- ✅ Botones con hover effects correctos
- ✅ No hay 404 en assets
- ✅ No hay errores en consola

---

#### Total de Cambios Fase 2.2:
- **Vistas migradas:** create + show + edit + historial + compartidos = 5
- **Dashboard eliminado:** 1 blade + 1 CSS + 5 JS = 7 archivos
- **Total procesados:** 28/71 archivos Blade (39%)
- **CSS eliminados:** 17/36 (47%)
- **JS eliminados:** 19/41 (46%)
- **Features agregadas:** CRUD completo de prompts con versionado, compartir, historial

---

### 🔄 FASE 1.4: CALENDARIO MODULE - ✅ COMPLETADO

#### Cambios Realizados:

**1. Vista Index (Calendario Principal)**
- `resources/views/calendario/index.blade.php`
  - Migrado: HTML con @include → `<x-app-layout>`
  - **Panel de control**: Botones exportar/lista + crear evento (rose-600)
  - **Calendar controls**: Alpine.js para navegación mes/año
    - Botones prev/next con Alpine @click
    - Selects sincronizados con x-model
    - Display dinámico: `x-text="monthNames[currentMonth] + ' ' + currentYear"`
  - **View toggles**: Mes (activo) / Semana / Agenda
  - **Calendar Grid**: 
    - Weekdays header: grid-cols-7 con uppercase text
    - Days grid: JS genera días del mes con hover states
    - Día actual: bg-rose-50 dark:bg-rose-900/20
  - **Upcoming Events Sidebar**:
    - 7 eventos hardcoded con colores distintos
    - Event items: Fecha grande + badge tipo (Académico, Reunión, Examen, etc.)
    - Colores por tipo: blue, amber, green, red, rose, orange, indigo
    - Hover effect: bg-slate-100 dark:bg-slate-700
  - **JavaScript**: Función generateCalendar() en @push('scripts')
    - Genera días del mes actual
    - Detecta hoy y aplica estilos rose
    - Espacios vacíos antes del primer día

**2. Vista Create (Crear Evento)**
- `resources/views/calendario/create.blade.php`
  - Formulario completo con dark mode
  - Campos: titulo, descripcion, fecha_inicio, fecha_fin, tipo, color
  - Select tipo: academico, examen, reunion, feriado, social
  - Input color: type="color" para picker nativo
  - Botones: Cancelar (ghost) + Crear Evento (rose-600)
  - Validación: campos requeridos con asterisco rojo

**3. Vista Show (Detalle del Evento)**
- `resources/views/calendario/show.blade.php`
  - **Header gradient**: from-rose-500 to-rose-600 con título blanco
  - **Grid de detalles**: 2x2 con iconos de colores
    - Fecha inicio: icono calendar azul
    - Fecha fin: icono calendar-check verde
    - Tipo: badge con color según categoría
    - Color: preview box + código hexadecimal
  - **Descripción**: Sección separada con border-t
  - **Acciones**: Botones Editar (amber) + Volver + Eliminar (rojo)
  - Form eliminar: método DELETE con confirmación

**4. Vista Edit (Editar Evento)**
- `resources/views/calendario/edit.blade.php`
  - Formulario idéntico a create con valores pre-llenados
  - Método PUT para actualización
  - Botones adicionales: Ver Detalles (blue) + Volver
  - Delete button: onclick confirmation + form oculto
  - Datos ejemplo: "Reunión de Profesores" con color #3b82f6

#### Archivos que deben eliminarse (CSS/JS obsoletos):
- ⚠️ `public/css/calendario/index.css` - Pendiente eliminación
- ⚠️ `public/JavaScript/calendario/index.js` - Pendiente eliminación  
- ⚠️ `public/JavaScript/calendario/create.js` - Pendiente eliminación
- ⚠️ `public/JavaScript/calendario/show.js` - Pendiente eliminación
- ⚠️ `public/JavaScript/calendario/edit.js` - Pendiente eliminación

#### Validación:
- ✅ `/calendario` renderiza sin errores
- ✅ `/calendario/create` formulario completo con dark mode
- ✅ `/calendario/{id}` detalle con gradient header
- ✅ `/calendario/{id}/edit` formulario pre-llenado
- ✅ Calendar grid se genera correctamente con JS
- ✅ Alpine controls funcionan (prev/next month)
- ✅ Selects sincronizados con x-model
- ✅ Dark mode funciona en todas las vistas
- ✅ Event cards con colores distintos
- ✅ No hay errores en consola

---

#### Total de Cambios Fase 1.4:
- **Vistas migradas:** index + create + show + edit = 4
- **Total procesados:** 32/71 archivos Blade (45%)
- **CSS pendientes eliminar:** 1 (calendario/index.css)
- **JS pendientes eliminar:** 4 (calendario/*.js)
- **Features agregadas:** Calendario interactivo con Alpine, eventos sidebar, formularios CRUD

---

### 🗓️ FASE 2.3: CALENDARIO MODULE CON FULLCALENDAR - ✅ COMPLETADO

#### Cambios Backend:

**1. Migración de Base de Datos**
- Creado: `database/migrations/2026_01_19_*_create_eventos_table.php`
  - Columnas: id, user_id (FK), titulo, descripcion, fecha_inicio (datetime), fecha_fin (datetime), tipo (string), ubicacion, todo_el_dia (boolean), color, timestamps
  - Foreign key: user_id → users table con onDelete cascade
  - Indexes: user_id, fecha_inicio para queries optimizados

**2. Modelo Eloquent**
- Creado: `app/Models/Evento.php`
  - Fillable: user_id, titulo, descripcion, fecha_inicio, fecha_fin, tipo, ubicacion, todo_el_dia, color
  - Casts: fecha_inicio/fecha_fin → datetime, todo_el_dia → boolean, tipo → TipoEvento::class
  - Relación: belongsTo(User::class)
  - Scope: whereUserId() para queries filtradas

**3. Enum de Tipos**
- Creado: `app/Enums/TipoEvento.php`
  - Backed string enum con 5 casos: trabajo, personal, estudio, reunion, recordatorio
  - Método label(): Retorna nombre legible en español
  - Método color(): Retorna código hexadecimal por tipo
    - trabajo: #3b82f6 (blue)
    - personal: #8b5cf6 (purple)
    - estudio: #10b981 (green)
    - reunion: #f59e0b (amber)
    - recordatorio: #ef4444 (red)

**4. Controlador CRUD Completo**
- Creado: `app/Http/Controllers/CalendarioController.php`
  - **index()**: Lista eventos del usuario + estadísticas (total, mes, semana, hoy) + próximos 5 eventos
  - **create()**: Renderiza formulario con tipos disponibles
  - **store(Request)**: Validación + creación evento con user_id
  - **show($id)**: Detalle evento con verificación propietario (403 si no es dueño)
  - **edit($id)**: Formulario pre-llenado con verificación propietario
  - **update(Request, $id)**: Validación + actualización + redirect
  - **destroy($id)**: Verificación propietario + eliminación + redirect
  - **CRÍTICO**: Usa `$id + findOrFail()` en lugar de route model binding por conflicto {calendario}/{evento}

**5. Rutas**
- Agregado en `routes/web.php`: `Route::resource('calendario', CalendarioController::class)`
  - Genera: index, create, store, show, edit, update, destroy
  - Middleware: auth aplicado globalmente

#### Cambios Frontend:

**1. Vista Index (Calendario FullCalendar)**
- `resources/views/calendario/index.blade.php`
  - **FullCalendar 6.1.10 CDN** (NO npm - package no incluye CSS)
  - **CDN Scripts**:
    - https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js
    - https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/locales/es.global.min.js
  - **Características**:
    - 4 vistas: dayGridMonth, timeGridWeek, timeGridDay, listWeek
    - Locale español nativo (días, meses, botones)
    - Eventos multi-día se arrastran visualmente por múltiples días
    - Dark mode custom con variables CSS `--fc-*`
    - Colores por tipo: getTipoColor() mapea enum → hex
  - **Interactividad**:
    - eventClick: Redirige a `/calendario/{id}` para ver detalle
    - dateClick: Redirige a `/calendario/create?fecha=YYYY-MM-DD` pre-llenado
  - **Stats Cards**: Total, mes, semana, hoy con iconos
  - **Próximos Eventos**: Lista lateral con badges de tipo coloreados

**2. Vista Create (Crear Evento)**
- `resources/views/calendario/create.blade.php`
  - Formulario con dark mode completo
  - Inputs: titulo (text), descripcion (textarea)
  - Fechas: fecha_inicio, fecha_fin con type="datetime-local"
  - Select tipo: 5 opciones del enum TipoEvento
  - Input ubicacion (text), checkbox todo_el_dia
  - Validación Laravel: @error con mensajes rojos
  - Botones: Cancelar (ghost) + Crear (rose-600 gradient)

**3. Vista Show (Detalle del Evento)**
- `resources/views/calendario/show.blade.php`
  - Layout 2 columnas: Contenido principal + Sidebar
  - **Contenido**:
    - Header con botón volver + título
    - Badge tipo con color gradient
    - Info: fecha_inicio/fin con iconos calendar
    - Ubicación con icono map-marker-alt
    - Descripción en sección separada
  - **Sidebar**:
    - Metadata: Creado, actualizado, creador (con link a perfil)
    - Tipo evento con badge coloreado
    - Todo el día: badge si aplica
  - **Acciones**: Editar (blue) + Eliminar (red) con confirmación
  - **CRÍTICO**: Usa `$evento->tipo->value` para evitar error ucfirst() con Enum

**4. Vista Edit (Editar Evento)**
- `resources/views/calendario/edit.blade.php`
  - Formulario idéntico a create con valores pre-llenados
  - Usa `old('campo', $evento->campo)` para persistir datos
  - Método PUT con `@method('PUT')`
  - Botones adicionales: Ver Detalles + Eliminar con confirmación
  - Form delete oculto con método DELETE

#### Problemas Resueltos:

**1. Tabla eventos no existía**
- Síntoma: Query exception "Table 'promptvault.eventos' doesn't exist"
- Solución: Creada migración + ejecutada `php artisan migrate`
- Validación: Script check-events.php confirmó tabla existe

**2. Route Model Binding fallaba**
- Síntoma: Usuario no llegaba ni al dd() en show(), error 404
- Causa: `Route::resource('calendario')` crea {calendario} pero show(Evento $evento) esperaba {evento}
- Solución: Cambió 4 métodos (show, edit, update, destroy) a `$id` + `Evento::findOrFail($id)`
- Resultado: Ahora funciona correctamente

**3. Error ucfirst() con Enum**
- Síntoma: "ucfirst(): Argument #1 must be of type string, App\Enums\TipoEvento given"
- Causa: `{{ ucfirst($evento->tipo) }}` en show.blade.php
- Solución: Cambió a `{{ ucfirst($evento->tipo->value) }}`
- Prevención: Agregado 'reunion' a getTipoClass() en index.blade.php

**4. Eventos multi-día no se visualizaban**
- Síntoma: Calendario Alpine manual no mostraba eventos correctamente
- Causa: Implementación manual (260 líneas) no soportaba eventos multi-día
- Solución: Reimplementó con FullCalendar CDN
- Resultado: Eventos multi-día se arrastran visualmente, 4 vistas funcionales

**5. FullCalendar CSS imports fallaban**
- Síntoma: "@import 'fullcalendar/main.css' failed: Missing specifier"
- Causa: npm package fullcalendar v6 NO incluye CSS, solo módulos JS
- Investigación: `Get-ChildItem node_modules/fullcalendar` mostró solo .js, .d.ts, package.json
- Solución: CDN approach con scripts globales + CSS inline
- Resultado: Build exitoso, calendario renderiza perfectamente

#### Dark Mode Implementación:

**CSS Custom para FullCalendar:**
```css
.dark .fc {
    --fc-border-color: rgb(51 65 85);
    --fc-button-bg-color: rgb(225 29 72);
    --fc-button-border-color: rgb(225 29 72);
    --fc-button-hover-bg-color: rgb(190 18 60);
    --fc-button-hover-border-color: rgb(190 18 60);
    --fc-button-active-bg-color: rgb(159 18 57);
    --fc-today-bg-color: rgba(225, 29, 72, 0.1);
    color: rgb(226 232 240);
}
```

- Borders: slate-700
- Botones: rose-600 → rose-700 (hover) → rose-800 (active)
- Hoy: rose con alpha 0.1
- Text: slate-200

#### Validación Completa:

- ✅ `/calendario`: Calendario interactivo con FullCalendar renderiza
- ✅ Eventos se guardan en DB (verificado con check-events.php)
- ✅ `/calendario/create`: Formulario guarda eventos correctamente
- ✅ `/calendario/1`: Detalle muestra con $evento->tipo->value
- ✅ `/calendario/1/edit`: Edita y actualiza correctamente
- ✅ Eventos multi-día se arrastran visualmente por múltiples días
- ✅ 4 vistas de calendario funcionales: mes, semana, día, lista
- ✅ Dark mode CSS custom aplica correctamente
- ✅ Click en evento → redirige a /calendario/{id}
- ✅ Click en fecha → redirige a create?fecha=...
- ✅ Locale español: días, meses, botones traducidos
- ✅ Stats cards muestran: total, mes, semana, hoy
- ✅ Próximos eventos lista con badges coloreados
- ✅ No hay errores en consola
- ✅ No hay 404 en assets
- ✅ npm run build: ✅ SUCCESS (app-DswcchBe.css, 3.83s)

#### Archivos Creados:

**Backend:**
1. `database/migrations/2026_01_19_*_create_eventos_table.php`
2. `app/Models/Evento.php`
3. `app/Enums/TipoEvento.php`
4. `app/Http/Controllers/CalendarioController.php`

**Frontend:**
5. `resources/views/calendario/index.blade.php` (reimplementado)
6. `resources/views/calendario/create.blade.php`
7. `resources/views/calendario/show.blade.php`
8. `resources/views/calendario/edit.blade.php`

**Scripts Debug (eliminados):**
9. `check-events.php` ❌ (script CLI temporal)
10. `check-auth.php` ❌ (script CLI temporal)

#### Decisiones Técnicas:

**¿Por qué CDN en lugar de npm?**
- FullCalendar v6 cambió arquitectura: packages separados (@fullcalendar/core, @fullcalendar/daygrid, etc.)
- npm package `fullcalendar` es solo un bundle JS, NO incluye CSS
- Intentar importar CSS falló: "Missing './main.css' specifier"
- CDN provee bundle completo: JS + CSS en un solo archivo
- Más simple: 2 script tags vs configurar 10+ paquetes npm

**¿Por qué $id en lugar de route model binding?**
- `Route::resource('calendario')` genera parámetro `{calendario}` no `{evento}`
- Laravel busca Evento con slug 'calendario' → falla
- Opción 1: Cambiar Route::resource('calendario') → Route::resource('eventos')
- Opción 2: Usar $id + findOrFail() manualmente
- Elegimos Opción 2: Mantiene URL `/calendario` más semántica

**¿Por qué enum backed en lugar de constantes?**
- PHP 8.1+ soporta backed enums nativos
- Type safety: $evento->tipo es TipoEvento, no string
- Métodos helper: label(), color() centralizados
- Cast automático: Eloquent convierte string ↔ enum
- Mejor DX: IDE autocomplete, no magic strings

#### Próximos Pasos:

- [ ] FASE 2.4: Perfil Module (4 vistas: index, show, edit, security)
- [ ] FASE 2.5: Configuraciones Module (7 vistas)
- [ ] FASE 3: Admin Module (18 vistas total)
- [ ] Eliminar CSS/JS obsoletos: calendario/*.css, calendario/*.js

---

#### Total de Cambios Fase 2.3:
- **Backend:** 1 migración + 1 modelo + 1 enum + 1 controller = 4 archivos
- **Frontend:** 4 vistas Blade migradas con FullCalendar CDN
- **Líneas código:** ~500 líneas nuevas (backend + frontend)
- **Problemas resueltos:** 5 (tabla, route binding, enum, multi-día, CSS imports)
- **Features agregadas:** CRUD completo de eventos + calendario interactivo con 4 vistas + dark mode + multi-día + español
- **Total procesados:** 11/64 archivos Blade (17%)

---

## 10. AUDITORÍA COMPLETA - VERIFICACIÓN task.md vs REALIDAD

**Fecha auditoría:** 20 de enero de 2026  
**Estado:** ✅ COMPLETADA

### Resumen Ejecutivo:
- **Total archivos .blade.php:** 64 (no 71 como decía originalmente)
- **Total archivos .css restantes:** 26 (no 36 originales, 10 eliminados confirmados)
- **Total archivos .js restantes:** 29 (no 41 originales, 12 eliminados confirmados)

### Archivos Verificados Eliminados:
#### CSS (10 archivos):
- ✅ `public/css/auth/auth.css`
- ✅ `public/css/auth/login.css`
- ✅ `public/css/auth/registro.css`
- ✅ `public/css/auth/recuperar.css`
- ✅ `public/css/dashboard/dashboard.css`
- ✅ `public/css/layouts/loading.css`
- ✅ `public/css/components/header.css`
- ✅ `public/css/components/footer.css`
- ✅ `public/css/components/sidebar.css`
- ✅ `public/css/components/loading.css`

#### JavaScript (12 archivos):
- ✅ `public/JavaScript/auth/login.js`
- ✅ `public/JavaScript/auth/registro.js`
- ✅ `public/JavaScript/auth/recuperar.js`
- ✅ `public/JavaScript/dashboard/admin.js`
- ✅ `public/JavaScript/dashboard/user.js`
- ✅ `public/JavaScript/dashboard/collaborator.js`
- ✅ `public/JavaScript/dashboard/guest.js`
- ✅ `public/JavaScript/layouts/header.js`
- ✅ `public/JavaScript/layouts/footer.js`
- ✅ `public/JavaScript/layouts/sidebar.js`
- ✅ `public/JavaScript/layouts/loading.js`
- ✅ `public/JavaScript/components/chatbot.js`

#### Blade (5 archivos):
- ✅ `resources/views/dashboard.blade.php`
- ✅ `resources/views/components/administrador.blade.php`
- ✅ `resources/views/components/usuario.blade.php`
- ✅ `resources/views/components/colaborador.blade.php`
- ✅ `resources/views/components/invitado.blade.php`

#### Layouts Obsoletos (8 archivos):
- ✅ `resources/views/layouts/header.blade.php`
- ✅ `resources/views/layouts/footer.blade.php`
- ✅ `resources/views/layouts/sidebar.blade.php`
- ✅ `resources/views/layouts/sidebarAdmin.blade.php`
- ✅ `resources/views/layouts/sidebarUser.blade.php`
- ✅ `resources/views/layouts/sidebarCollaborator.blade.php`
- ✅ `resources/views/layouts/sidebarGuest.blade.php`
- ✅ `resources/views/layouts/loading.blade.php`

### Archivos Verificados Creados:
#### Layouts:
- ✅ `resources/views/layouts/app.blade.php`
- ✅ `resources/views/layouts/app-auth.blade.php`

#### Components:
- ✅ `resources/views/components/layout/header.blade.php`
- ✅ `resources/views/components/layout/sidebar.blade.php` (incluye link calendario)
- ✅ `resources/views/components/layout/footer.blade.php`
- ✅ `resources/views/components/layout/loading.blade.php`

#### Backend Calendario:
- ✅ `database/migrations/2026_01_20_*_create_eventos_table.php`
- ✅ `app/Models/Evento.php`
- ✅ `app/Enums/TipoEvento.php`
- ✅ `app/Http/Controllers/CalendarioController.php`

### Vistas con @extends/@yield (PROHIBIDO por AGENTS.md):
**Encontrados:** 53 archivos AÚN usan directivas antiguas

#### Perfil (3 archivos):
- ⚠️ `resources/views/perfil/index.blade.php` - usa @section/@extends
- ⚠️ `resources/views/perfil/edit.blade.php` - usa @section/@extends
- ⚠️ `resources/views/perfil/security.blade.php` - usa @section/@extends

#### Admin (15+ archivos):
- ⚠️ Todos los archivos en `admin/` usan @extends('layouts.admin')

#### Otros módulos:
- ⚠️ `buscador/index.blade.php`
- ⚠️ `configuraciones/*`
- ⚠️ `errors/*`
- ⚠️ `mod/*`
- ⚠️ `pages/*`

### Archivos Pendientes Eliminar:
- ⚠️ `public/css/calendario/index.css` - no usado (FullCalendar usa CDN)
- ⚠️ `public/JavaScript/calendario/index.js` - no usado (FullCalendar usa CDN)

### Discrepancias Encontradas y Corregidas:
1. **task.md decía "71 archivos .blade.php"** → Corregido a: 64 archivos reales
2. **task.md decía "32 procesados"** → Corregido a: 11 procesados (Auth 3 + Prompts 6 + Calendario 4 + Home 1 ≠ Components no cuentan)
3. **task.md listaba sección 1.8 Layouts duplicada** → Marcada como obsoleta
4. **task.md no mencionaba** → Agregados 8 layouts obsoletos eliminados

### Correcciones Aplicadas a task.md:
- ✅ Actualizado conteo real: 64 archivos blade
- ✅ Corregido conteo CSS: 26 restantes (10 eliminados)
- ✅ Corregido conteo JS: 29 restantes (12 eliminados)
- ✅ Reorganizada sección 1.7 Components (incluye layouts)
- ✅ Marcada sección 1.8 como obsoleta
- ✅ Agregados layouts obsoletos a lista eliminados
- ✅ Actualizado porcentaje procesados: 11/64 (17%)

### Próximos Pasos Críticos:
1. **MIGRAR VISTAS CON @extends:** 53 archivos aún usan directivas prohibidas
2. **ELIMINAR CSS/JS OBSOLETOS:** `public/css/calendario/index.css`, `public/JavaScript/calendario/index.js`
3. **CONTINUAR FASE 2.4:** Perfil Module (4 vistas)
4. **AUDITORÍA SEGURIDAD:** Implementar checklist de autorización del inicio del documento
- **Backend:** 1 migración + 1 modelo + 1 enum + 1 controller = 4 archivos
- **Frontend:** 4 vistas Blade migradas con FullCalendar CDN
- **Líneas código:** ~500 líneas nuevas (backend + frontend)
- **Problemas resueltos:** 5 (tabla, route binding, enum, multi-día, CSS imports)
- **Features agregadas:** CRUD completo de eventos + calendario interactivo con 4 vistas + dark mode + multi-día + español
- **Total procesados:** 32/71 archivos Blade (45%)

---

### ✅ FASE 2.4: PERFIL MODULE - COMPLETADO (20/01/2026)

#### Cambios Realizados:

**1. Vista: perfil/index.blade.php**
- Layout: <x-app-layout> sin @component
- Header: Título + descripción + botón "Editar Perfil"
- Stats Pills: 4 métricas (Rol, Estado, Miembro Desde, Último Acceso)
- Grid 2 columnas responsive (lg:grid-cols-3)
- Profile card: avatar editable con Alpine x-data upload
- Info grid 6 campos + 2 botones acción
- Activity Timeline: logs con diffForHumans
- Dark mode completo + responsive

**2. Vista: perfil/edit.blade.php**
- Layout: <x-app-layout> sin @component
- Grid: lg:grid-cols-4 (sidebar sticky + formulario)
- Sidebar: 2 cards (avatar + nivel perfil)
- Avatar upload: preview + AJAX fetch
- Formulario: 3 secciones (Datos Básicos, Estado, Sistema)
- Validación Laravel: @error directives

**3. Vista: perfil/security.blade.php**
- Layout: <x-app-layout> sin @component
- Formulario cambiar contraseña: 3 inputs password
- Toggle visibility: Alpine x-data (show/hide)
- Card Recomendaciones: 4 tips seguridad

**4. Vista: perfil/show.blade.php**
- Estado: Solo comentario HTML (sin contenido)

#### Archivos Eliminados:
- public/css/perfil/index.css ❌
- public/css/perfil/edit.css ❌
- public/JavaScript/perfil/index.js ❌

#### Validación Comandos:
`powershell
Get-ChildItem resources/views -Recurse -Filter "*.blade.php" | Measure-Object
# Output: 64 archivos

Get-ChildItem public/css -Recurse -Filter "*.css" | Measure-Object
# Output: 24 archivos (26 - 2 eliminados)

Get-ChildItem public/JavaScript -Recurse -Filter "*.js" | Measure-Object
# Output: 28 archivos (29 - 1 eliminado)
`

#### Resumen Bitácora FASE 2.4:
- **Backend:** 0 archivos nuevos (reutiliza PerfilController)
- **Frontend:** 3 vistas migradas + 1 vacía
- **Líneas código:** ~800 líneas nuevas
- **Eliminados:** 2 CSS + 1 JS = 3 archivos
- **Problemas resueltos:** 8
- **Total procesados:** 15/64 archivos Blade (23%)

---

### 🔄 FASE 2.6: PREPARACIÓN CONFIGURACIONES - ✅ COMPLETADO

#### Cambios Frontend:
- **sidebar.blade.php**: Agregado link Configuraciones en sección Sistema
  - Ubicación: Dentro de dropdown "Sistema" (solo visible para admin)
  - Icon: SVG engranaje (settings) con paths rounded
  - Route: `configuraciones.index`
  - Active state: `configuraciones.*` con bg-red-50 dark:bg-red-900/30
  - Orden: Configuraciones (1°) → Usuarios (2°) → Roles (3°) → Permisos (4°)

#### Componentes Creados:
- **user-avatar.blade.php**: Componente reutilizable avatar usuario
  - Props: `:user` (modelo User), `size` (xs|sm|md|lg|xl|2xl)
  - Lógica: Muestra `foto_perfil` si existe + `file_exists()`, fallback inicial gradiente
  - Cache busting: `?v={{ time() }}` previene cache browser
  - Sizes Tailwind: xs(5x5), sm(6x6), md(8x8), lg(10x10), xl(12x12), 2xl(16x16)
  - Usado en: header, prompt/card, prompts/index, prompts/show

#### Componentes Reutilizados:
- **prompt/card.blade.php**: Eliminadas 60+ líneas duplicadas en prompts/index
  - Avatar usuario: Ahora usa `<x-user-avatar :user="$prompt->user" size="sm" />`
  - Beneficios: DRY, consistencia, mantenibilidad
  - Usado en: home (/) via `<x-prompt.grid>`, prompts/index directamente

#### Archivos Eliminados:
- ❌ `app/Http/Controllers/ProfileController.php` (duplicado con PerfilController)
- ❌ `public/css/perfil/index.css` (migrado a Tailwind)
- ❌ `public/css/perfil/edit.css` (migrado a Tailwind)
- ❌ `public/JavaScript/perfil/index.js` (script upload obsoleto)

#### Problemas Resueltos:
1. **ProfileController duplicado** → Eliminado, consolidado en PerfilController
2. **Avatares no se mostraban** → Creado componente user-avatar reutilizable
3. **Avatar no actualizaba en tiempo real** → Cache busting con `?v=time()`
4. **Cards home mostraban inicial** → Componente verifica `file_exists()` antes mostrar foto
5. **Código duplicado prompt cards** → Reutilizado `<x-prompt.card>` en index y home
6. **Falta link Configuraciones** → Agregado en sidebar sección Sistema

#### Validación:
- ✅ Link Configuraciones visible solo para admin
- ✅ Active state funciona con route `configuraciones.*`
- ✅ Icon settings renderiza correctamente
- ✅ Dark mode funciona en link
- ✅ Orden lógico en dropdown Sistema
- ✅ Avatar componente funciona en 6 lugares
- ✅ Cache busting previene avatares obsoletos
- ✅ Prompt/card reutilizado elimina duplicación

#### Validación Comandos (20/01/2026):
```powershell
Get-ChildItem resources/views -Recurse -Filter "*.blade.php" | Measure-Object
# Output: 65 archivos

Get-ChildItem public/css -Recurse -Filter "*.css" | Measure-Object
# Output: 23 archivos

Get-ChildItem public/JavaScript -Recurse -Filter "*.js" | Measure-Object
# Output: 27 archivos
```

#### Total de Cambios Fase 2.6:
- **Vistas actualizadas:** sidebar.blade.php (1)
- **Componentes creados:** user-avatar.blade.php (1)
- **Componentes reutilizados:** prompt/card (eliminadas 60 líneas duplicadas)
- **Controllers eliminados:** ProfileController.php (1)
- **Routes eliminadas:** 3 rutas /profile
- **CSS eliminados:** 3 archivos perfil
- **JS eliminados:** 1 archivo perfil
- **Total procesados:** 15/65 archivos Blade (23%)
- **CSS restantes:** 23 archivos (validado con PowerShell)
- **JS restantes:** 27 archivos (validado con PowerShell)
- **Features agregadas:** Link Configuraciones admin, componente avatar reutilizable, consolidación ProfileController


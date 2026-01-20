# PromptVault Auth Refactor - Task List

## Objetivo
Restaurar y mejorar las vistas de autenticación (login, registro, recuperar contraseña) manteniendo el diseño original hermoso y funcional.

---

## 1. ARCHIVOS BLADE (.blade.php)

### Login View
- **Ruta**: `resources/views/auth/login.blade.php`
- **Estado**: Full HTML structure with CSS/JS references
- **Tamaño**: 319 líneas
- **Componentes**:
  - Background animado con shapes, gears, circuit boards
  - Grid de fondo
  - Logo PromptVault (LogoCompletoLogin.png)
  - Formulario con dos columnas: branding izquierda + form derecha
  - Inputs: email, password, remember me checkbox
  - Botón "ACCESO SISTEMA" (btn-nexorium)
  - Links: olvidé contraseña, registro

### Registro (Register) View
- **Ruta**: `resources/views/auth/registro.blade.php`
- **Estado**: Full HTML structure with CSS/JS references
- **Tamaño**: 515+ líneas
- **Componentes**:
  - Background animado similar a login
  - Indicador de pasos (1/2 - 2/2)
  - **Paso 1**: Formulario de registro (nombre, email, contraseña, confirmación)
  - **Paso 2**: Verificación por email (código de 6 dígitos)
  - Validaciones en cliente
  - Links: back to login

### Recuperar (Password Reset) View
- **Ruta**: `resources/views/auth/recuperar.blade.php`
- **Estado**: No documentado en búsqueda, verificar
- **Tamaño**: Desconocido
- **Componentes**: Presumiblemente email form para reset

---

## 2. ARCHIVOS CSS

### Archivo de Configuración General Auth
- **Ruta**: `public/css/auth/auth.css`
- **Estado**: Base stylesheet para todos los auth pages

### Login CSS
- **Ruta**: `public/css/auth/login.css`
- **Tamaño**: 1574 líneas
- **Características principales**:
  - Variables de colores: `--primary-red: #e11d48`, `--primary-red-hover: #be123c`
  - Gradientes: Main gradient y animated gradient
  - Animaciones: `gradientShift`, `glow`, `pulse`
  - Background: Gradient `135deg #450a0a → #7f1d1d → #450a0a`
  - Glassmorphism effects con rgba
  - Shadows y glow effects
  - Tipografía: Inter + Montserrat
  - Clases principales: `.login-background`, `.main-login-wrapper`, `.login-branding`, `.login-form-section`, `.login-form`

### Registro CSS
- **Ruta**: `public/css/auth/registro.css`
- **Tamaño**: 1832 líneas
- **Características principales**:
  - Variables similares a login
  - Colores: `--green-primary: #e11d48`, `--green-secondary: #be123c`
  - Background: Mismo gradient que login
  - Soporta dos pasos/estados
  - Clases para indicador de pasos

### Recuperar CSS
- **Ruta**: `public/css/auth/recuperar.css`
- **Estado**: Existe, revisar contenido
- **Tamaño**: Desconocido

---

## 3. ARCHIVOS JAVASCRIPT

### Login JS
- **Ruta**: `public/js/auth/login.js`
- **Funcionalidad**:
  - Validaciones de formulario
  - Interactividad del login
  - Posibles animaciones al cargar

### Registro JS
- **Ruta**: `public/js/auth/registro.js`
- **Funcionalidad**:
  - Lógica de dos pasos (step 1 → step 2)
  - Validaciones en cliente
  - Transiciones entre pasos
  - Tal vez temporizador para código de verificación

### Recuperar JS
- **Ruta**: `public/js/auth/recuperar.js`
- **Funcionalidad**: Lógica de recuperación de contraseña

---

## 4. ASSETS DE IMAGEN

### Logos
- `public/images/LogoCompletoLogin.png` - Logo completo usado en branding izquierdo
- `public/images/LogoLoginPrompt.png` - Logo usado en sidebars
- `public/images/LogoPestañaPrompt.jpg` - Favicon

---

## 5. PLAN DE REFACTOR

### Fase 1: Auditoría
- [ ] Verificar estado actual de `public/css/auth/*.css`
- [ ] Verificar estado actual de `public/js/auth/*.js`
- [ ] Comprobar que todos los assets de imagen existen
- [ ] Documentar estilos aplicados en cada página
- [ ] Identificar puntos rotos (si los hay)

### Fase 2: Restauración
- [ ] Asegurar que `login.blade.php` mantiene estructura original
- [ ] Asegurar que `registro.blade.php` mantiene estructura original
- [ ] Asegurar que `recuperar.blade.php` está completo
- [ ] Verificar todos los CSS se cargan correctamente
- [ ] Verificar todos los JS se cargan correctamente

### Fase 3: Validación Visual
- [ ] Probar `/login` en navegador (ver background animado, formulario, estilos)
- [ ] Probar `/register` en navegador (ver dos pasos, indicador, estilos)
- [ ] Probar `/password/reset` en navegador
- [ ] Verificar responsividad (mobile, tablet, desktop)
- [ ] Verificar animaciones funcionan

### Fase 4: Optimización (si aplica)
- [ ] Limpiar CSS duplicado si existe
- [ ] Optimizar JS si hay ineficiencias
- [ ] Asegurar SEO meta tags están correctos

---

## 6. REFERENCIAS CRUZADAS

### Vistas que usan Auth
- `resources/views/home.blade.php` - Links a login si no autenticado
- `resources/views/perfil/security.blade.php` - Menciona login
- Dashboards - Redirigen si no autenticado

### Componentes relacionados (que NO tocar)
- `resources/views/components/` - Componentes de UI generales
- `resources/views/layouts/` - Layouts de dashboard (no de auth)
- `app/View/Components/AppLayout.php` - Componente de layout (no es para auth)

---

## 7. COMANDOS IMPORTANTES

### Development Server
```bash
npm run dev      # Vite con hot reload
php artisan serve
```

### Testing Auth Pages
- Visit: http://localhost:8000/login
- Visit: http://localhost:8000/register
- Visit: http://localhost:8000/password/reset

### Browser Console Checks
- Verify no 404 errors for CSS/JS
- Verify no JavaScript errors
- Check Network tab for asset loading

---

## Checklist Final

- [ ] Login page: Beautiful, responsive, working
- [ ] Registro page: Beautiful, responsive, two-step working
- [ ] Recuperar page: Beautiful, responsive, working
- [ ] All CSS files load without 404
- [ ] All JS files load without 404
- [ ] All images load correctly
- [ ] Animations run smoothly
- [ ] No console errors
- [ ] Mobile responsive on all 3 pages
- [ ] Form validation works
- [ ] Links between auth pages work (login ↔ register, etc)

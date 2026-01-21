# PromptVault - Task List

## Objetivo General
Auditoría integral de seguridad, implementación de Policies y estandarización de código (SOLID/Tailwind) en el módulo de Prompts.

**Historial Completo:** Ver `docs/fase1-auditoria-seguridad-implementacion-prompts.md`

---

## Tareas Completadas (Fase 1)

✅ Tareas 1-7: Auditoría de seguridad, calificaciones, buscador, chatbot, refactorización
- Ver `docs/fase1-auditoria-seguridad-implementacion-prompts.md` para detalles técnicos completos

---

## Fase 2: Configuración (concluida/pausada)

### 8. Auditoría y Funcionalidad de Rutas en Configuración
- [x] Revisar `/admin/configuraciones` - verificar qué funciona y qué no
- [x] Identificar problemas en la ruta Configuración (Sistema)
- [x] Documentar estado actual de cada sección
- [x] Implementar modo mantenimiento con middleware y BD
- [x] Crear componentes reutilizables (form-label, form-select)
- [x] Integrar campos .env en tabla app_settings

### 9. Revisión de Migraciones de Tabla (detenido por decisión del cliente)
- [ ] Auditar estructura de migraciones existentes
- [ ] Identificar campos que pueden mejorarse
- [ ] Proponer cambios de información que se muestra
- [ ] Evaluar si hay tablas innecesarias

### 10. Limpieza de Módulos No Utilizados (detenido por decisión del cliente)
- [ ] Remover/desactivar "Gestión Académica" (sin usar)
- [ ] Auditar otros módulos que no funcionan
- [ ] Documentar cuáles módulos están activos

### 11. Visualización de Variables de Entorno (detenido por decisión del cliente)
- [ ] Crear vista admin para mostrar campos del .env
- [ ] Categorizar variables (BD, API, Servicios, etc.)
- [ ] Agregar UI en Configuración > General

---

## Fase 3: Refactorización SOLID de Controladores

### 12. Auditoría de Controladores Existentes
- [x] Inventariar todos los controladores (app/Http/Controllers + Admin + Auth)
- [x] Clasificar responsabilidades (lógica de negocio vs presentación)
- [x] Identificar violaciones SOLID (God Objects, dependencias directas, etc.)
- [x] Documentar dependencias actuales (modelos, repositorios, servicios)
- [x] Priorizar orden de refactorización por impacto

### 13. ConfiguracionesController → BackupService + ConfigurationService (CRÍTICO)
- [x] Crear `BackupServiceInterface` en `app/Contracts/Services`
- [x] Implementar `BackupService` en `app/Services` (extraer exec() mysqldump seguro)
- [x] Crear `ConfigurationServiceInterface` en `app/Contracts/Services`
- [x] Implementar `ConfigurationService` en `app/Services` (manejar AppSetting CRUD)
- [x] Refactorizar `ConfiguracionesController`: inyectar ambos servicios
- [x] Eliminar lógica filesystem directo (scandir, filesize, filemtime)
- [x] Validar que controlador solo coordine vistas y servicios
- [x] **Razón**: ⚠️ Código exec() es riesgo seguridad, 298 LOC, 6 responsabilidades

### 14. PromptController → Extraer CalificacionService (CRÍTICO)
- [x] Crear `CalificacionServiceInterface` en `app/Contracts/Services`
- [x] Implementar `CalificacionService` en `app/Services`
- [x] Extraer lógica `calificar()` de PromptController (líneas 222-238)
- [x] Eliminar acceso directo a `Calificacion::updateOrCreate()`
- [x] Eliminar query directo `User::where('email',...)->first()` (línea 165)
- [x] Refactorizar validación propietario (líneas 166-169) a Policy
- [x] Validar inyección de CalificacionService en constructor
- [x] **Razón**: God Object 282 LOC, 13 métodos, 6 responsabilidades

### 15. UsuarioController → UsuarioService + Refactorización (ALTA)
- [ ] Crear `UsuarioServiceInterface` en `app/Contracts/Services`
- [ ] Implementar `UsuarioService` en `app/Services`
- [ ] Extraer lógica de filtros complejos (líneas 17-43) a servicio
- [ ] Extraer manejo de archivos (líneas 76, 117, 122) a UploadService existente
- [ ] Mover validación "no eliminarte" (línea 139) a servicio
- [ ] Inyectar UsuarioService en constructor del controlador
- [ ] Eliminar acceso directo a User, Role, Hash, Storage
- [ ] **Razón**: 163 LOC sin servicios, lógica storage y queries complejos

### 16. ReportesController → 3 Servicios Especializados (ALTA)
- [ ] Crear `ReporteServiceInterface` en `app/Contracts/Services`
- [ ] Implementar `PromptReporteService` para reportes de prompts
- [ ] Implementar `EventoReporteService` para reportes de eventos
- [ ] Implementar `UsuarioReporteService` para reportes de usuarios
- [ ] Refactorizar métodos index(), eventos(), usuarios() usando servicios
- [ ] Eliminar queries complejos withCount/groupBy del controlador
- [ ] Eliminar cálculos de charts (líneas 66-69, 152-154) del controlador
- [ ] **Razón**: God Object 171 LOC, accede 6 modelos, queries sin abstracción

### 17. CalendarioController → EventoService + EventoPolicy (MEDIA)
- [ ] Crear `EventoServiceInterface` en `app/Contracts/Services`
- [ ] Implementar `EventoService` en `app/Services`
- [ ] Crear `EventoPolicy` para autorización
- [ ] Extraer queries estadísticas (líneas 17-37) a servicio
- [ ] Reemplazar validaciones manuales repetidas con Policy
- [ ] Extraer cálculo de métricas complejas a servicio
- [ ] Inyectar EventoService en constructor
- [ ] **Razón**: 163 LOC sin servicios, validaciones repetidas 5 veces

### 18. PerfilController → PerfilService (MEDIA)
- [ ] Crear `PerfilServiceInterface` en `app/Contracts/Services`
- [ ] Implementar `PerfilService` en `app/Services`
- [ ] Extraer métodos privados getUserStatistics(), getRecentPrompts() a servicio
- [ ] Mover lógica subirAvatar() a UploadService existente
- [ ] Eliminar acceso directo a filesystem (líneas 115-133)
- [ ] Inyectar PerfilService y UploadService en constructor
- [ ] **Razón**: 138 LOC, lógica estadísticas y upload sin abstracción

### 19. RoleController + PermisosController → Servicios (BAJA)
- [ ] Crear `RoleServiceInterface` y `PermissionServiceInterface`
- [ ] Implementar `RoleService` y `PermissionService`
- [ ] Refactorizar RoleController: eliminar queries (líneas 12-25)
- [ ] Refactorizar PermisosController: eliminar filtros complejos (líneas 9-23)
- [ ] Eliminar métodos stub vacíos (store, update, destroy)
- [ ] Inyectar servicios en constructores
- [ ] **Razón**: 69+64 LOC, métodos dead code, queries en controladores

### 20. Registro de Servicios en Providers
- [ ] Verificar bindings actuales en AppServiceProvider
- [ ] Registrar BackupService, ConfigurationService
- [ ] Registrar CalificacionService
- [ ] Registrar UsuarioService
- [ ] Registrar PromptReporteService, EventoReporteService, UsuarioReporteService
- [ ] Registrar EventoService
- [ ] Registrar PerfilService
- [ ] Registrar RoleService, PermissionService
- [ ] Validar resolución automática en constructor injection

### 21. Validación Final
- [ ] Ejecutar `./vendor/bin/pint` en todos los archivos modificados
- [ ] Validar que no haya regresiones funcionales navegando rutas
- [ ] Verificar que todos los controladores <150 LOC
- [ ] Verificar cero queries directos a modelos en controladores
- [ ] Actualizar bitácora con resumen técnico por controlador
- [ ] Commit final: "refactor: aplicación SOLID completa en controladores"

---

## Bitácora

- 21/01/2026: Toolbar de configuraciones parametrizado con variables .env (versión, motor BD, estado). Se eliminaron vistas legacy `resources/views/configuraciones/index.blade.php` y se dejaron banners "Próximamente" en Apariencia, Notificaciones y Sistema. Se pausa el resto de tareas de configuración (9-11) por decisión del cliente.
- 21/01/2026: Corregida persistencia de tema claro/oscuro unificando clave `theme` en localStorage y aplicando clase `dark` en html/body. Se eliminó flicker con pre-carga en `<head>`.
- 21/01/2026: **Auditoría SOLID completada** - Analizados 10 controladores (1,417 LOC, 65 métodos). Identificadas violaciones: 7/10 sin servicios, 3 God Objects (ConfiguracionesController 298 LOC, PromptController 282 LOC, ReportesController 171 LOC). Prioridad: Tareas 13-21 ordenadas por riesgo crítico → alto → medio → bajo.
- 21/01/2026: **Tarea 13 completada** - Refactorizado ConfiguracionesController (298→63 LOC, -79% reducción). Creados: BackupServiceInterface/BackupService (listBackups, createBackup, downloadBackup, deleteBackup), ConfigurationServiceInterface/ConfigurationService (getSettings, updateSettings), UpdateConfiguracionRequest (26 campos validación + checkboxes). Eliminado código exec() directo, queries a AppSetting, operaciones filesystem (scandir/filesize/filemtime), formatBytes() privado. Registrados bindings en AppServiceProvider. Controlador ahora solo coordina vistas y servicios sin lógica de negocio.
- 21/01/2026: **Tarea 14 completada** - Refactorizado PromptController (282→260 LOC, -8% reducción). Creado CalificacionService con métodos calificar() y obtenerCalificacion(). Eliminado acceso directo a Calificacion::updateOrCreate(). Agregado método compartirPorEmail() a CompartirService eliminando query directo User::where('email'). Agregada autorización explícita con Policy::rate() en método calificar(). Registrado binding en AppServiceProvider.

---

## Tareas Descubiertas para Siguientes Fases

*(Espacio reservado para deuda técnica o bugs encontrados)*

- **Testing de Servicios:** Crear tests unitarios para cada método de cada servicio (BackupService, ConfigurationService, CalificacionService, etc.). Estructura: `tests/Unit/Services/` y `tests/Feature/Http/Controllers/`. Cada método del contrato debe tener su test correspondiente.
- **Gestión Académica:** Módulo que repite y no se usa. Evaluar eliminación.
- **.env Visualization:** Necesario para configuración desde admin.
- **Auth Controllers:** Revisar alineación con Fortify/Breeze para evitar código duplicado.

---

**Última actualización:** 21 de enero de 2026
**Estado General:** Preparando Fase 3 - Refactorización SOLID

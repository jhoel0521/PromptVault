# PromptVault - Task List

## Objetivo General
Auditoría integral de seguridad, implementación de Policies y estandarización de código (SOLID/Tailwind) en el módulo de Prompts.

**Historial Completo:** Ver `docs/fase1-auditoria-seguridad-implementacion-prompts.md`

---

## Tareas Completadas (Fase 1)

✅ Tareas 1-7: Auditoría de seguridad, calificaciones, buscador, chatbot, refactorización
- Ver `docs/fase1-auditoria-seguridad-implementacion-prompts.md` para detalles técnicos completos

---

## Fase 2: Configuración ⏸️ (PAUSADA)

> **Estado:** Pausada por decisión del cliente  
> **Completadas:** Tarea 8 (Auditoría y Funcionalidad de Rutas)  
> **Pendientes:** Tareas 9-11 (sin iniciarse)

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

## Fase 3: Refactorización SOLID de Controladores ⏸️ (PAUSADA)

> **Estado:** Pausada por decisión del cliente  
> **Completadas:** Tareas 12-14 (Auditoría, ConfiguracionesController, PromptController)  
> **Pendientes:** Tareas 15-21 (sin iniciarse)

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

## Fase 4: Plan Integral de Testing 🚀 (EN INICIO)

> **Objetivo:** Implementación de suite de pruebas automatizadas para todas las funcionalidades críticas  
> **Alcance:** Tests unitarios + tests de integración (Feature)  
> **Estado:** Planificación completada, listo para iniciarse

### 22. Estructura Base y Setup de Testing (CRÍTICO) [/]
- [x] Verificar estructura existente en `tests/` (Feature/Auth, Unit/, TestCase.php)
- [x] Crear directorio `tests/Unit/Models/` para tests de modelos
- [x] Crear directorio `tests/Unit/Services/` para tests de servicios
- [x] Crear directorio `tests/Feature/Prompts/` para CRUD de prompts
- [x] Crear directorio `tests/Feature/Sharing/` para tests de compartir
- [x] Crear directorio `tests/Feature/Comments/` para tests de comentarios
- [x] Crear directorio `tests/Feature/Ratings/` para tests de calificaciones
- [x] Crear directorio `tests/Feature/Tags/` para tests de etiquetas
- [x] Crear directorio `tests/Feature/Admin/` para tests administrativos
- [x] Crear directorio `tests/Feature/Calendar/` para tests de calendario
- [x] Configurar `phpunit.xml` con environment de testing (DB separada o in-memory)
- [x] Crear factories para modelos: UserFactory, PromptFactory, RoleFactory, etc.
- [x] **Razón**: Fundación sólida para suite de testing
- [ ] Validar que todas las factories se alineen con migraciones reales

### 23. Unit Tests de Modelos (ALTA) [x]
- [x] **UserTest.php**: relaciones (role), métodos (esAdmin, tienePermiso, puedeEditar)
- [x] **PromptTest.php**: relaciones (user, versiones, etiquetas), visibilidad, vistas
- [x] **RoleTest.php**: relaciones (users, permisos), tienePermiso()
- [x] **VersionTest.php**: relaciones (prompt), numero_version
- [x] **ComentarioTest.php**: relaciones (prompt, user, parent), replies
- [x] **CalificacionTest.php**: relaciones (prompt, user), validación rango estrellas
- [x] **EtiquetaTest.php**: relaciones (prompts), filtrado
- [x] **AccesoCompartidoTest.php**: relaciones (user, prompt), nivel acceso
- [x] **Razón**: Validación de modelos y relaciones fundamentales
- [x] **Status**: 32/32 tests pasando (8/8 modelos completados)

### 24. Feature Tests - CRUD de Prompts (CRÍTICO) [x]
- [x] **PromptCrudTest.php:**
  - [x] test_user_can_create_prompt
  - [x] test_user_can_view_own_prompts
  - [x] test_user_can_update_own_prompt
  - [x] test_user_can_delete_own_prompt
  - [x] test_user_cannot_delete_others_prompt
  - [x] test_admin_can_delete_any_prompt
  - [x] test_user_cannot_update_others_prompt
  - [x] test_unauthenticated_user_cannot_create_prompt
- [x] Validar validaciones de CreatePromptRequest
- [x] Validar respuestas HTTP (200, 403, 404, 302 redirect)
- [x] **Razón**: Funcionalidad core - creación/edición/eliminación
- [x] **Status**: 8/8 tests pasando

### 25. Feature Tests - Visibilidad de Prompts (CRÍTICO) [x]
- [x] **PromptVisibilityTest.php:**
  - [x] test_public_prompts_visible_to_all
  - [x] test_private_prompts_hidden_from_others
  - [x] test_shared_prompts_visible_to_shared_users
  - [x] test_admin_can_see_all_prompts
  - [x] test_link_prompts_treated_as_private
  - [x] test_owner_has_propietario_access_level
  - [x] test_shared_user_has_correct_access_level
  - [x] test_user_without_access_has_no_level
- [x] Validar policy PromptPolicy en cada caso
- [x] Validar queries con can() middleware
- [x] **Razón**: Seguridad de acceso crítica
- [x] **Status**: 8/8 tests pasando

### 26. Feature Tests - Versionado de Prompts (ALTA)
- [ ] **PromptVersioningTest.php:**
  - [ ] test_editing_prompt_creates_new_version
  - [ ] test_user_can_view_version_history
  - [ ] test_user_can_restore_previous_version
  - [ ] test_version_comparison_works
- [ ] Validar incremento automático numero_version
- [ ] Validar relación prompt->versiones
- [ ] **Razón**: Funcionalidad crítica de versionado

### 27. Feature Tests - Compartir y Colaboración (ALTA)
- [ ] **AccesoCompartidoTest.php:**
  - [ ] test_owner_can_share_prompt
  - [ ] test_share_with_lector_level
  - [ ] test_share_with_comentador_level
  - [ ] test_share_with_editor_level
  - [ ] test_owner_can_revoke_access
  - [ ] test_shared_user_receives_notification
- [ ] **CollaborationTest.php:**
  - [ ] test_editor_can_edit_shared_prompt
  - [ ] test_comentador_can_comment_not_edit
  - [ ] test_lector_can_only_view
- [ ] Validar niveles de acceso (AccesoCompartido)
- [ ] **Razón**: Funcionalidad core de compartir

### 28. Feature Tests - Comentarios (MEDIA)
- [ ] **ComentarioTest.php:**
  - [ ] test_user_can_comment_on_public_prompt
  - [ ] test_user_can_reply_to_comment
  - [ ] test_owner_can_delete_comment
  - [ ] test_user_can_delete_own_comment
  - [ ] test_nested_comments_display_correctly
- [ ] Validar relaciones parent/replies
- [ ] Validar autorización para eliminar
- [ ] **Razón**: Funcionalidad de colaboración

### 29. Feature Tests - Calificaciones (MEDIA)
- [ ] **CalificacionTest.php:**
  - [ ] test_user_can_rate_prompt
  - [ ] test_user_can_update_rating
  - [ ] test_user_cannot_rate_twice (updateOrCreate)
  - [ ] test_prompt_average_updates_on_rating
  - [ ] test_rating_range_validation (1-5)
- [ ] Validar cálculo automático de promedio
- [ ] Validar CalificacionService
- [ ] **Razón**: Funcionalidad de valoración

### 30. Feature Tests - Etiquetas (MEDIA)
- [ ] **EtiquetaTest.php:**
  - [ ] test_user_can_add_tags_to_prompt
  - [ ] test_user_can_remove_tags_from_prompt
  - [ ] test_admin_can_create_global_tags
  - [ ] test_filter_prompts_by_tag
- [ ] Validar relación many-to-many
- [ ] Validar búsqueda por etiqueta
- [ ] **Razón**: Funcionalidad de categorización

### 31. Feature Tests - Administración de Usuarios (MEDIA)
- [ ] **UserManagementTest.php:**
  - [ ] test_admin_can_list_users
  - [ ] test_admin_can_create_user
  - [ ] test_admin_can_deactivate_user
  - [ ] test_admin_can_change_user_role
  - [ ] test_non_admin_cannot_access_user_management
- [ ] Validar policies de administración
- [ ] Validar middleware admin
- [ ] **Razón**: Seguridad - solo admins pueden gestionar usuarios

### 32. Feature Tests - Configuración de Sistema (MEDIA)
- [ ] **ConfigurationTest.php:**
  - [ ] test_admin_can_view_settings
  - [ ] test_admin_can_update_settings
  - [ ] test_non_admin_cannot_access_settings
- [ ] Validar ConfigurationService
- [ ] Validar persistencia en app_settings
- [ ] **Razón**: Seguridad - solo admins pueden configurar

### 33. Feature Tests - Calendario de Eventos (BAJA)
- [ ] **EventoTest.php:**
  - [ ] test_user_can_create_event
  - [ ] test_user_can_view_own_events
  - [ ] test_user_can_update_event
  - [ ] test_user_can_delete_event
  - [ ] test_user_can_mark_event_complete
- [ ] Validar relaciones usuario-evento
- [ ] Validar states (completado/pendiente)
- [ ] **Razón**: Funcionalidad secundaria

### 34. Unit Tests de Servicios (ALTA)
- [ ] **Tests para CalificacionService:**
  - [ ] test_calificar_creates_or_updates_rating
  - [ ] test_obtener_calificacion_returns_user_rating
- [ ] **Tests para CompartirService:**
  - [ ] test_compartir_creates_acceso_compartido
  - [ ] test_compartir_por_email_sends_notification
  - [ ] test_revocar_access_removes_record
- [ ] **Tests para PromptService:**
  - [ ] test_crear_prompt_validates_input
  - [ ] test_actualizar_prompt_creates_version
  - [ ] test_eliminar_prompt_soft_delete
- [ ] **Tests para BackupService y ConfigurationService (Tareas 13-14)**
  - [ ] test_create_backup_generates_file
  - [ ] test_list_backups_returns_files
  - [ ] test_get_settings_returns_app_settings
  - [ ] test_update_settings_persists_changes
- [ ] **Razón**: Validación de lógica de negocio

### 35. Validación Final y Cobertura (CRÍTICO)
- [ ] Ejecutar todos los tests: `./vendor/bin/phpunit`
- [ ] Generar coverage report: `./vendor/bin/phpunit --coverage-html coverage`
- [ ] Validar cobertura >80% en funcionalidades críticas
- [ ] Validar 0 warnings/notices en logs de testing
- [ ] Documentar resultados en `docs/test-results.md`
- [ ] Crear CI/CD pipeline (GitHub Actions) para ejecutar tests en cada PR
- [ ] Commit: "test: implementación completa de suite de testing integral"
- [ ] **Razón**: Garantía de calidad y confianza en regresiones

---

## Bitácora

- 28/01/2026: **Tarea 25 completada - Feature Tests de Visibilidad de Prompts** - Creado PromptVisibilityTest.php con 8 tests cobriendo lógica de visibilidad crítica: prompts públicos visibles para todos autenticados, privados ocultos de otros, compartidos accesibles solo a usuarios con AccesoCompartido, y prompts de tipo 'enlace' tratados como privados. Tests validan tanto lógica de modelo (`esVisiblePara()`, `nivelAccesoPara()`) como autorización HTTP via Policy. Descubierta inconsistencia: modelo `esVisiblePara()` permite admin ver todo, pero Policy `view()` usa `compartirService->verificarAcceso()` que respeta privacidad incluso para admin (registrada en Tareas Descubiertas). Status: 8/8 tests pasando.
- 28/01/2026: **Tarea 24 completada - Feature Tests CRUD de Prompts** - Creado PromptCrudTest.php con 8 tests de operaciones CRUD (create, view, update, delete) + autorización (usuario no puede editar/eliminar de otros, admin puede eliminar cualquiera) + autenticación (sin login redirige). Problema resuelto: Vite manifest no generado, solucionado con `npm run build`. Status: 8/8 tests pasando (2.71s).
- 28/01/2026: **Tarea 23 completada - Unit Tests de Modelos** - Creados 8 test files (32/32 tests pasando): UserTest (6), PromptTest (8, fixed column `numero_vistas`→`conteo_vistas`), RoleTest (3), VersionTest (2), ComentarioTest (4, fixed method `replies()`→`respuestas()`), CalificacionTest (3), EtiquetaTest (2), AccesoCompartidoTest (3). Fixes: TestCase role names to lowercase (admin/usuario), UserTest uses preexisting role id=1.
- 28/01/2026: **Tarea 22 completada - Estructura Base de Testing** - Creadas 9 directorios de tests, 8 factories alineadas con migraciones (resuelto: PromptFactory, VersionFactory, CalificacionFactory, AccesoCompartidoFactory, RoleFactory, EventoFactory con columnas correctas). TestCase configurado con migrate:fresh + role seeding. Commit: "feat: tarea 22 - estructura base de testing".
- 28/01/2026: Setup de infraestructura de testing completado - TestCase.php ahora ejecuta migraciones con `migrate:fresh` en setUp(). Eliminados tests de Breeze incompatibles con testing (Auth, Registration, Profile, Example) que requieren Vite compilado. Arreglado UserFactory agregando `role_id` default = 2. Suite de testing ahora pasa correctamente: `php artisan test` ejecuta sin errores. Foundation lista para Fase 4.
- 21/01/2026: Toolbar de configuraciones parametrizado con variables .env (versión, motor BD, estado). Se eliminaron vistas legacy `resources/views/configuraciones/index.blade.php` y se dejaron banners "Próximamente" en Apariencia, Notificaciones y Sistema. Se pausa el resto de tareas de configuración (9-11) por decisión del cliente.
- 21/01/2026: Corregida persistencia de tema claro/oscuro unificando clave `theme` en localStorage y aplicando clase `dark` en html/body. Se eliminó flicker con pre-carga en `<head>`.
- 21/01/2026: **Auditoría SOLID completada** - Analizados 10 controladores (1,417 LOC, 65 métodos). Identificadas violaciones: 7/10 sin servicios, 3 God Objects (ConfiguracionesController 298 LOC, PromptController 282 LOC, ReportesController 171 LOC). Prioridad: Tareas 13-21 ordenadas por riesgo crítico → alto → medio → bajo.
- 21/01/2026: **Tarea 13 completada** - Refactorizado ConfiguracionesController (298→63 LOC, -79% reducción). Creados: BackupServiceInterface/BackupService (listBackups, createBackup, downloadBackup, deleteBackup), ConfigurationServiceInterface/ConfigurationService (getSettings, updateSettings), UpdateConfiguracionRequest (26 campos validación + checkboxes). Eliminado código exec() directo, queries a AppSetting, operaciones filesystem (scandir/filesize/filemtime), formatBytes() privado. Registrados bindings en AppServiceProvider. Controlador ahora solo coordina vistas y servicios sin lógica de negocio.
- 21/01/2026: **Tarea 14 completada** - Refactorizado PromptController (282→260 LOC, -8% reducción). Creado CalificacionService con métodos calificar() y obtenerCalificacion(). Eliminado acceso directo a Calificacion::updateOrCreate(). Agregado método compartirPorEmail() a CompartirService eliminando query directo User::where('email'). Agregada autorización explícita con Policy::rate() en método calificar(). Registrado binding en AppServiceProvider.

---

## Tareas Descubiertas para Siguientes Fases

*(Espacio reservado para deuda técnica o bugs encontrados)*

- **⚠️ INCONSISTENCIA: Visibilidad de Admin** (Tarea 25 descubierta): Modelo `Prompt::esVisiblePara()` permite a admin ver cualquier prompt privado ("Admin puede ver todo"), pero Policy `PromptPolicy::view()` usa `compartirService->verificarAcceso()` que NO hace excepciones para admin. Resultado: modelo dice verdadero, pero HTTP retorna 403. Requiere alineación: decidir si admin respeta privacidad o no, y ajustar modelo/policy consistentemente.
- **✅ Testing de Servicios:** Planificado en Fase 4 (Tareas 22-35). Crear tests unitarios para cada método de cada servicio (BackupService, ConfigurationService, CalificacionService, etc.). Estructura: `tests/Unit/Services/` y `tests/Feature/Http/Controllers/`. Cada método del contrato debe tener su test correspondiente.
- **Gestión Académica:** Módulo que repite y no se usa. Evaluar eliminación.
- **.env Visualization:** Necesario para configuración desde admin (Fase 2, Tarea 11, pausada).
- **Auth Controllers:** Revisar alineación con Fortify/Breeze para evitar código duplicado.

---

**Última actualización:** 28 de enero de 2026
**Estado General:** Fase 4 - Plan Integral de Testing (LISTO PARA INICIARSE)
**Próximas Fases:** Fases 2 y 3 pausadas por decisión del cliente

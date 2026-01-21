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
- [ ] Inventariar todos los controladores (app/Http/Controllers + Admin + Auth)
- [ ] Clasificar responsabilidades (lógica de negocio vs presentación)
- [ ] Identificar violaciones SOLID (God Objects, dependencias directas, etc.)
- [ ] Documentar dependencias actuales (modelos, repositorios, servicios)
- [ ] Priorizar orden de refactorización por impacto

### 13. Refactorización Módulo Usuario/Perfil
- [ ] Crear `UserServiceInterface` y `ProfileServiceInterface` en `app/Contracts/Services`
- [ ] Implementar `UserService` y `ProfileService` en `app/Services`
- [ ] Extraer lógica de negocio de `UsuarioController` a `UserService`
- [ ] Extraer lógica de negocio de `PerfilController` a `ProfileService`
- [ ] Inyectar servicios en constructores de controladores
- [ ] Validar que controladores solo coordinen (request → service → response)

### 14. Refactorización Módulo Configuraciones
- [ ] Crear `ConfigurationServiceInterface` en `app/Contracts/Services`
- [ ] Implementar `ConfigurationService` en `app/Services`
- [ ] Extraer lógica de `ConfiguracionesController` (backups, validaciones, .env)
- [ ] Separar responsabilidad de backup en `BackupService` independiente
- [ ] Inyectar servicios y validar single responsibility

### 15. Refactorización Módulo Admin
- [ ] Crear `RoleServiceInterface` y `PermissionServiceInterface`
- [ ] Implementar `RoleService` y `PermissionService`
- [ ] Refactorizar `RoleController`, `PermisosController`, `ReportesController`
- [ ] Extraer lógica de reportes a `ReportService`
- [ ] Validar inyección de dependencias

### 16. Refactorización Módulos Complementarios
- [ ] Refactorizar `CalendarioController` → `CalendarService`
- [ ] Refactorizar `HomeController` (si tiene lógica compleja)
- [ ] Revisar `ChatbotController` y alinear con `ChatbotService` existente
- [ ] Validar que `Auth/` controllers estén alineados con Fortify/Breeze

### 17. Registro de Servicios y Providers
- [ ] Verificar bindings en `AppServiceProvider` o crear `ServiceServiceProvider`
- [ ] Registrar todas las interfaces → implementaciones
- [ ] Documentar IoC Container para nuevos desarrolladores
- [ ] Validar resolución automática en tests unitarios

### 18. Validación Final y Documentación
- [ ] Ejecutar suite de tests (si existe) o crear smoke tests
- [ ] Validar que no haya regresiones funcionales
- [ ] Documentar arquitectura en `docs/solid-architecture.md`
- [ ] Crear diagrama de dependencias (Contratos → Servicios → Controladores)
- [ ] Actualizar bitácora con resumen técnico

---

## Bitácora

- 21/01/2026: Toolbar de configuraciones parametrizado con variables .env (versión, motor BD, estado). Se eliminaron vistas legacy `resources/views/configuraciones/index.blade.php` y se dejaron banners "Próximamente" en Apariencia, Notificaciones y Sistema. Se pausa el resto de tareas de configuración (9-11) por decisión del cliente.
- 21/01/2026: Corregida persistencia de tema claro/oscuro unificando clave `theme` en localStorage y aplicando clase `dark` en html/body. Se eliminó flicker con pre-carga en `<head>`.

---

## Tareas Descubiertas para Siguientes Fases

*(Espacio reservado para deuda técnica o bugs encontrados)*

- **Gestión Académica:** Módulo que repite y no se usa. Evaluar eliminación.
- **.env Visualization:** Necesario para configuración desde admin.
- **Auth Controllers:** Revisar alineación con Fortify/Breeze para evitar código duplicado.

---

**Última actualización:** 21 de enero de 2026
**Estado General:** Preparando Fase 3 - Refactorización SOLID

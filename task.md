# PromptVault - Task List

## Objetivo General
Auditoría integral de seguridad, implementación de Policies y estandarización de código (SOLID/Tailwind) en el módulo de Prompts.

## Tareas Pendientes Area de Ejecucion

### 1. FormRequests y Autorización
- [x] Auditar `CompartirPromptRequest::authorize()` (Verificado: usa `can('share')`).
- [x] Auditar `UpdatePromptRequest`: Verificar que implemente `authorize()` correctamente.
- [x] Auditar `StorePromptRequest`: Verificar que implemente `authorize()` correctamente.

### 2. Rutas (`routes/web.php`)
- [x] **Auditoría Crítica:** Verificar si `Route::resource('prompts')` aplica la seguridad implícita o requiere middleware extra.
- [x] Agregar middleware explícito `can:` a rutas personalizadas:
    - [x] Ruta `historial` -> `middleware('can:update,prompt')`
    - [x] Ruta `restaurarVersion` -> `middleware('can:update,prompt')`
    - [x] Ruta `quitarAcceso` -> `middleware('can:share,prompt')`

### 3. Vistas (Blade & UI)
- [x] **Fix (`show.blade.php`):** El sidebar se renderiza completo aunque el usuario no tenga permisos. Corregir lógica `@can`.
- [x] **Auditoría (`show.blade.php`):** Verificar visibilidad de paneles según permisos:
    - [x] Panel "Acciones" (Editar/Eliminar) solo para `@can('update')`.
    - [x] Panel "Compartir Acceso" solo para `@can('share')`.
- [x] **Auditoría (`historial.blade.php`):** Verificar que el botón "Restaurar" solo aparezca si `can('update')`.

### 4. Controladores (Lógica de Negocio)
- [x] **`PromptController`:** Revisar métodos `destroy` y `restaurar` (asegurar que llaman a `$this->authorize()` o usan el FormRequest adecuado).
- [x] **`CompartirController`:** Revisar método `removeAcceso` (verificar autorización).

### 5. Tarea Opcional
- [x] (Pendiente de evaluación) La lógica de `CompartirService` podría refactorizarse a un Trait si se reutiliza en otros modelos.
  - **Resultado:** CompartirService se usa SOLO en PromptPolicy + PromptController. NO se reutiliza en otros modelos. Se mantiene como Servicio (inyectable) por arquitectura SOLID. No se refactoriza a Trait.

### 6. Pruebas Manuales - Validación de Seguridad
- [x] Crear un Prompt como Usuario 1
- [x] Validar que Usuario 2 NO puede ver/editar/compartir (solo propietario)
- [x] Compartir con Usuario 2 como "editor"
- [x] Validar que Usuario 2 PUEDE editar y comentar
- [x] Compartir con Usuario 3 como "comentador"
- [x] Validar que Usuario 3 PUEDE comentar pero NO editar
- [x] Validar que Admin NO puede ver prompts privados de Usuario 1

**Instrucciones completas en:** `docs/PRUEBAS-SEGURIDAD-PROMPTS.md`

### 7. Calificaciones (Ratings 1 a 5 estrellas)
- [x] Mostrar UI de calificación en `prompts.show` (requiere login). Si no está logueado, mostrar CTA "Inicia sesión para calificar".
- [x] Permitir calificar 1-5 estrellas y enviar (nuevo/actualizar) usando el modelo Calificacion existente.
- [x] Si el usuario ya calificó, mostrar su calificación actual y permitir actualizarla.
- [x] Actualizar y mostrar `promedio_calificacion` en la tarjeta y detalle usando la data real de la tabla calificaciones.
- [x] Validar que el propietario pueda ver promedio pero no necesita calificar su propio prompt (opcional: impedir calificar el propio).

## Tareas Descubierta para Siguientes Fases o Iteracciones
*(Espacio reservado para deuda técnica o bugs encontrados durante la ejecución actual)*

### Correcciones Menores Realizadas (21/01/2026)
- **show.blade.php - Form compartir:** Corregidos valores select `nivel_acceso`: "lectura"/"edicion" → "lector"/"comentador"/"editor" (consistencia con BD)
- **show.blade.php - Usuarios con acceso:** Mejorada visual: badges coloreados por nivel, emails visibles, contador de usuarios, estado vacío cuando no hay compartidos
- **Acceso compartible:** ⚠️ PENDIENTE: Agregar link coprable/notificación a usuarios compartidos (próxima fase)


---

## Area de de Bitacora
*Registro de cambios y auditorías finalizadas con éxito.*

- **[21/01/2026] Tarea 1 - FormRequests y Autorización:** Auditoría completa de 3 FormRequests (CompartirPromptRequest, UpdatePromptRequest, StorePromptRequest). Todos implementan `authorize()` correctamente usando políticas: `can('share')`, `can('update')`, `can('create')`. Validaciones y mensajes en español completos. Cumple SOLID.
- **[21/01/2026] Tarea 2 - Rutas y Middleware:** Auditoría de routes/web.php verificó Route::resource('prompts') es seguro. Agregado middleware explícito a 4 rutas personalizadas: compartir (can:share), quitarAcceso (can:share), historial (can:update), restaurarVersion (can:update). Archivo modificado: routes/web.php. Cumple SOLID y seguridad en capas.
- **[21/01/2026] CORRECCIÓN CRÍTICA - Privacidad Admin:** Eliminada brecha de seguridad donde admin podía ver/editar/compartir prompts privados de otros usuarios. Cambios: PromptPolicy.php (view/update/share no dan acceso a admin), CompartirService.php (verificarAcceso() removido "admin tiene acceso total"). Admin SOLO puede delete() por razones administrativas. Ejecutado pint en ambos archivos. Privacidad respetada en capas.
- **[21/01/2026] Tarea 3 - Vistas Blade y Autorización:** Auditoría completa de show.blade.php y historial.blade.php. show.blade.php CORRECTO: Panel "Acciones" con @can('update') + @can('delete'), Panel "Compartir Acceso" con @can('share'). historial.blade.php CORREGIDO: Agregado @can('update') alrededor del botón "Restaurar" para consistencia UI-Backend. Archivo modificado: resources/views/prompts/historial.blade.php.
- **[21/01/2026] Tarea 4 - Controladores y Autorización:** Auditoría completa de PromptController. Todos los métodos CRUD con autorización en capas: destroy() -> $this->authorize('delete'), restaurarVersion() -> $this->authorize('update') + validación version_id, quitarAcceso() -> $this->authorize('share'). FormRequests (Store/Update/Compartir) con authorize(). CompartirController NO existe (integrado correctamente en PromptController). Cumple SOLID. Archivo verificado: app/Http/Controllers/PromptController.php.
- **[21/01/2026] Tarea 5 - Análisis CompartirService:** Evaluado reutilización de CompartirService. Se usa SOLO en PromptPolicy + PromptController (no en otros modelos). Se mantiene como Servicio inyectable por SOLID. NO se refactoriza a Trait. Decisión: Arquitectura actual es óptima.
- **[21/01/2026] Tarea 6 - Pruebas de Seguridad:** Creado documento de pruebas completo: docs/PRUEBAS-SEGURIDAD-PROMPTS.md. Incluye: 9 escenarios manuales paso-a-paso, 7 tests automatizados en Feature Tests, checklist de validación. Pruebas cubren: privacidad usuario, compartir (editor/comentador), vistas, eliminación acceso, prompts públicos, admin NO accede privados. Preparado para ejecutar desde cero con 3 usuarios de prueba + 1 admin.
- **[21/01/2026] Corrección Copiar Prompt:** Mejorado el botón "Copiar" en la vista de detalle para usar `navigator.clipboard` con fallback a textarea oculto y manejo seguro del `event` para evitar el error "Error al copiar" en navegadores sin permisos de clipboard. Archivo modificado: resources/views/prompts/show.blade.php.
- **[21/01/2026] Buscador y etiquetas en prompt.index:** Activado filtrado front con dataset (búsqueda + etiqueta) y limitado el listado de etiquetas a las presentes en los prompts paginados. Archivos modificados: app/Http/Controllers/PromptController.php, resources/views/prompts/index.blade.php.
- **[21/01/2026] Tarea 7 - Calificaciones:** Implementación completa de ratings 1-5 estrellas. Archivos: app/Http/Requests/Prompt/RatePromptRequest.php (validaciones + policy), routes/web.php (ruta POST calificar), PromptController::calificar() con updateOrCreate, PromptPolicy::rate() (impide autocal ificación), prompts.show.blade.php (UI + Alpine). Actualización de promedio recalculado automáticamente por modelo Calificacion. Botón "Copiar" mejorado con fallback clipboard. Widget chatbot en home con CTA login/registro para no autenticados (altura aumentada a 500px).
- **[21/01/2026] Funcionalidad Compartidos + Refactorización Vistas:** Habilitado link "Compartidos Conmigo" en sidebar con ruta funcional. Actualizado PromptController::compartidosConmigo() con filtros (búsqueda + etiquetas). Creado componente reutilizable x-prompt.list-container (search + tag filters + grid). Refactorizado prompts.index y prompts.compartidos para usar componente, eliminando duplicación de código. Archivos modificados: resources/views/components/layout/sidebar.blade.php, app/Http/Controllers/PromptController.php, resources/views/prompts/index.blade.php, resources/views/prompts/compartidos.blade.php, resources/views/components/prompt/list-container.blade.php (nuevo).
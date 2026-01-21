# PromptVault - Task List

## Objetivo General
Auditoría integral de seguridad, implementación de Policies y estandarización de código (SOLID/Tailwind) en el módulo de Prompts.

## Tareas Pendientes Area de Ejecucion

### 1. FormRequests y Autorización
- [ ] Auditar `CompartirPromptRequest::authorize()` (Verificado: usa `can('share')`).
- [ ] Auditar `UpdatePromptRequest`: Verificar que implemente `authorize()` correctamente.
- [ ] Auditar `StorePromptRequest`: Verificar que implemente `authorize()` correctamente.

### 2. Rutas (`routes/web.php`)
- [ ] **Auditoría Crítica:** Verificar si `Route::resource('prompts')` aplica la seguridad implícita o requiere middleware extra.
- [ ] Agregar middleware explícito `can:` a rutas personalizadas:
    - [ ] Ruta `historial` -> `middleware('can:update,prompt')`
    - [ ] Ruta `restaurarVersion` -> `middleware('can:update,prompt')`
    - [ ] Ruta `quitarAcceso` -> `middleware('can:delete,prompt')`

### 3. Vistas (Blade & UI)
- [ ] **Fix (`show.blade.php`):** El sidebar se renderiza completo aunque el usuario no tenga permisos. Corregir lógica `@can`.
- [ ] **Auditoría (`show.blade.php`):** Verificar visibilidad de paneles según permisos:
    - [ ] Panel "Acciones" (Editar/Eliminar) solo para `@can('update')`.
    - [ ] Panel "Compartir Acceso" solo para `@can('share')`.
- [ ] **Auditoría (`historial.blade.php`):** Verificar que el botón "Restaurar" solo aparezca si `can('update')`.

### 4. Controladores (Lógica de Negocio)
- [ ] **`PromptController`:** Revisar métodos `destroy` y `restaurar` (asegurar que llaman a `$this->authorize()` o usan el FormRequest adecuado).
- [ ] **`CompartirController`:** Revisar método `removeAcceso` (verificar autorización).

### 5. Tarea Opcional
- [ ] (Pendiente de evaluación) La lógica de `CompartirService` podría refactorizarse a un Trait si se reutiliza en otros modelos.
---

## Tareas Descubierta para Siguientes Fases o Iteracciones
*(Espacio reservado para deuda técnica o bugs encontrados durante la ejecución actual)*


---

## Area de de Bitacora
*Registro de cambios y auditorías finalizadas con éxito.*

- **[Auditoría] PromptPolicy:** Métodos `view`, `update`, `delete`, `share` revisados y aprobados.
- **[Auditoría] CompartirService:** Lógica de `verificarAcceso`, `puedeEditar` y `puedeComentar` validada correctamente.
- **[Auditoría] Routes:** Detectada falta de middleware explícito en líneas 55-62 (migrado a tareas pendientes).
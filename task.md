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

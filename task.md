# PromptVault - Task List

## Objetivo General
Auditoría integral de seguridad, implementación de Policies y estandarización de código (SOLID/Tailwind) en el módulo de Prompts.

**Historial Completo:** Ver `docs/fase1-auditoria-seguridad-implementacion-prompts.md`

---

## Tareas Completadas (Fase 1)

✅ Tareas 1-7: Auditoría de seguridad, calificaciones, buscador, chatbot, refactorización
- Ver `docs/fase1-auditoria-seguridad-implementacion-prompts.md` para detalles técnicos completos

---

## Tareas Pendientes - Fase 2: Configuración

### 8. Auditoría y Funcionalidad de Rutas en Configuración
- [x] Revisar `/admin/configuraciones` - verificar qué funciona y qué no
- [x] Identificar problemas en la ruta Configuración (Sistema)
- [x] Documentar estado actual de cada sección
- [x] Implementar modo mantenimiento con middleware y BD
- [x] Crear componentes reutilizables (form-label, form-select)
- [x] Integrar campos .env en tabla app_settings

### 9. Revisión de Migraciones de Tabla
- [ ] Auditar estructura de migraciones existentes
- [ ] Identificar campos que pueden mejorarse
- [ ] Proponer cambios de información que se muestra
- [ ] Evaluar si hay tablas innecesarias

### 10. Limpieza de Módulos No Utilizados
- [ ] Remover/desactivar "Gestión Académica" (sin usar)
- [ ] Auditar otros módulos que no funcionan
- [ ] Documentar cuáles módulos están activos

### 11. Visualización de Variables de Entorno
- [ ] Crear vista admin para mostrar campos del .env
- [ ] Categorizar variables (BD, API, Servicios, etc.)
- [ ] Agregar UI en Configuración > General

---

## Bitácora

- 21/01/2026: Toolbar de configuraciones parametrizado con variables .env (versión, motor BD, estado). Se eliminaron vistas legacy `resources/views/configuraciones/index.blade.php` y se dejaron banners "Próximamente" en Apariencia, Notificaciones y Sistema.

---

## Tareas Descubiertas para Siguientes Fases

*(Espacio reservado para deuda técnica o bugs encontrados)*

- **Gestión Académica:** Módulo que repite y no se usa. Evaluar eliminación.
- **.env Visualization:** Necesario para configuración desde admin.

---

**Última actualización:** 21 de enero de 2026
**Estado General:** En Progreso (Fase 2 - Configuración)

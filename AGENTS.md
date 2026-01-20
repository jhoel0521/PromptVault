1. Reglas de Estructura (Blade & Components)
Objetivo: Eliminar directivas heredadas y forzar el uso de componentes de clase o anónimos.

Prohibición de Directivas Antiguas: Queda estrictamente prohibido el uso de @extends, @section, @yield, @include y @stack.

Adopción de Layouts: Todo layout debe usarse mediante etiquetas <x-layout-name>.

Slots sobre Variables: Utilizar <x-slot:name> para inyectar contenido en áreas específicas del componente en lugar de pasar strings pesados por atributos.

Sintaxis de Atributos: Preferir el paso de datos mediante la sintaxis de colon (:data="$variable") para mantener la coherencia con Vue/Alpine.

2. Reglas de Estilización (CSS a Tailwind)
Objetivo: Eliminar archivos .css externos y estilos en línea, moviendo toda la identidad visual a clases de utilidad.

Migración de Clases Propietarias: No mapear una clase .btn-primary a @apply. En su lugar, descomponerla directamente en el HTML: class="px-4 py-2 bg-blue-500 text-white rounded".

Manejo de Estados: Utilizar modificadores de Tailwind para estados (hover:, focus:, active:) en lugar de selectores CSS.

Diseño Responsivo: Aplicar prefijos sm:, md:, lg: directamente en las etiquetas.

Configuración Arbitraria: Si un valor de CSS no existe en el preset de Tailwind, usar valores arbitrarios (ej. top-[13px]) solo como último recurso, priorizando siempre la escala estándar.

3. Reglas de Comportamiento (JS a Alpine.js)
Objetivo: Eliminar archivos JS externos que manipulan el DOM manualmente y reemplazarlos con lógica declarativa.

Estado Local: Toda variable de JavaScript debe vivir dentro de un directiva x-data.

Eventos: Sustituir addEventListener por @click, @submit.prevent, @change, etc.

Manipulación del DOM: * Sustituir .show() / .hide() por x-show o x-if.

Sustituir la inserción de texto por x-text o x-html.

Sustituir la manipulación de clases por :class="{ 'clase-activa': condicion }".

Comunicación: Usar $dispatch para comunicación entre componentes y $refs para acceso directo a elementos cuando sea estrictamente necesario.

4. Reglas de Actualización de task.md
Objetivo: Mantener el archivo task.md sincronizado con la realidad del proyecto para evitar discrepancias y confusión.

Actualización Obligatoria: SIEMPRE actualizar task.md INMEDIATAMENTE después de:
- Completar una fase o módulo
- Eliminar archivos obsoletos (CSS, JS, Blade)
- Migrar vistas de @extends a <x-app-layout>
- Crear nuevos componentes o layouts
- Modificar estructura de carpetas

Validación de Conteos: ANTES de actualizar task.md, VALIDAR conteos reales con comandos:
```bash
# Contar archivos blade
Get-ChildItem resources/views -Recurse -Filter "*.blade.php" | Measure-Object | Select-Object -ExpandProperty Count

# Contar CSS restantes
Get-ChildItem public/css -Recurse -Filter "*.css" | Measure-Object | Select-Object -ExpandProperty Count

# Contar JS restantes
Get-ChildItem public/JavaScript -Recurse -Filter "*.js" | Measure-Object | Select-Object -ExpandProperty Count

# Verificar archivos específicos existen
Test-Path ruta/al/archivo
```

Secciones a Actualizar en task.md:

1. **Resumen de Inventario** (líneas ~80-86):
   - Actualizar conteo REAL de archivos blade, CSS, JS
   - Especificar cuántos procesados vs pendientes
   - Listar módulos completados con checkmarks

2. **Inventario Completo - ARCHIVOS BLADE** (sección 1):
   - Marcar vistas migradas con ✅ MIGRADO
   - Marcar vistas eliminadas con ❌ ELIMINADO
   - Agregar notas de características implementadas

3. **Inventario Completo - ARCHIVOS CSS** (sección 2):
   - Marcar archivos eliminados con ❌ ELIMINADO
   - Actualizar conteo de archivos restantes
   - Especificar pendientes migración a Tailwind

4. **Inventario Completo - ARCHIVOS JAVASCRIPT** (sección 3):
   - Marcar archivos eliminados con ❌ ELIMINADO
   - Actualizar conteo de archivos restantes
   - Especificar pendientes migración a Alpine

5. **Módulos completados** (sección 8):
   - Marcar con [x] módulos 100% completados
   - Actualizar conteo X/14 módulos

6. **Archivos validados** (sección 8):
   - Actualizar conteo REAL de procesados/total
   - Calcular porcentaje correcto

7. **Bitácora de Cambios** (sección 9):
   - AGREGAR nueva fase al FINAL (no reemplazar)
   - Incluir fecha en formato: FASE X.X: NOMBRE MODULE - ✅ COMPLETADO
   - Documentar: Backend, Frontend, Problemas Resueltos, Validación, Total de Cambios

Formato de Bitácora (OBLIGATORIO):
```markdown
### 🔄 FASE X.X: [NOMBRE MODULE] - ✅ COMPLETADO

#### Cambios Backend (si aplica):
- Migración: nombre_tabla (campos relevantes)
- Modelo: App\Models\NombreModelo
- Enum: App\Enums\NombreEnum (casos)
- Controller: NombreController (métodos implementados)
- Correcciones: descripción breve

#### Cambios Frontend:
- vista1.blade.php: descripción migración
- vista2.blade.php: características implementadas
- Components: cambios en componentes reutilizables

#### Problemas Resueltos:
1. Problema X → Solución Y
2. Error Z → Fix implementado

#### Archivos Eliminados:
- ❌ archivo1.css (razón)
- ❌ archivo2.js (razón)

#### Validación:
- ✅ /ruta renderiza sin errores
- ✅ Funcionalidad X funciona correctamente
- ✅ No hay errores en consola
- ✅ Dark mode funciona

#### Total de Cambios Fase X.X:
- **Vistas migradas:** N archivos
- **Total procesados:** X/64 archivos Blade (Y%)
- **CSS eliminados:** Z archivos
- **JS eliminados:** W archivos
- **Features agregadas:** lista características nuevas
```

Prohibiciones Estrictas:
- ❌ NO inventar números de archivos
- ❌ NO copiar conteos de commits anteriores sin validar
- ❌ NO omitir actualización de "Archivos validados"
- ❌ NO usar conteos aproximados ("~32 archivos")
- ❌ NO olvidar actualizar sección "Módulos completados"
- ❌ NO duplicar información en secciones (ej. 1.7 y 1.8)

Checklist Pre-Commit:
Antes de hacer commit con cambios en task.md:
1. [ ] Validé conteos reales con comandos PowerShell
2. [ ] Actualicé "Resumen de Inventario" con números correctos
3. [ ] Marqué vistas/archivos procesados con ✅ o ❌
4. [ ] Agregué bitácora detallada al final de sección 9
5. [ ] Actualicé conteo "Módulos completados: X/14"
6. [ ] Actualicé "Archivos validados: X/64 total (Y%)"
7. [ ] Verifiqué que no hay duplicados (ej. layouts en 1.7 y 1.8)
8. [ ] Commit message menciona "docs: actualizar task.md con Fase X.X"

Ejemplo de Commit Correcto:
```bash
git add task.md
git commit -m "docs: actualizar task.md con Fase 2.4 Perfil completada

Actualizado:
- Resumen inventario: 15/64 blade procesados (23%)
- Marcadas 4 vistas perfil con ✅ MIGRADO
- Agregada bitácora Fase 2.4 con cambios detallados
- Actualizado conteo: 5/14 módulos completados

Validado con comandos PowerShell."
```

Esta regla PREVALECE sobre la memoria: si no recuerdas cuántos archivos hay, VALIDA con comandos antes de actualizar task.md.
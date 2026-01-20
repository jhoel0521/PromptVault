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
<x-app-layout :title="'Historial: ' . $prompt->titulo . ' - PromptVault'">
    <div class="max-w-7xl mx-auto px-6 py-10">
        
        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                    <i class="fas fa-history text-rose-600"></i> 
                    Historial de Versiones
                </h1>
                <p class="text-slate-600 dark:text-slate-400 mt-2">
                    Prompt: <strong>{{ $prompt->titulo }}</strong>
                </p>
            </div>
            <a href="{{ route('prompts.show', $prompt) }}" 
               class="bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-medium px-6 py-3 rounded-lg border border-slate-200 dark:border-slate-700 transition-colors flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Volver al Prompt
            </a>
        </div>

        {{-- Tabla de Versiones --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-900">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Versión</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Mensaje de Cambio</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Contenido</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @foreach($versiones as $version)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-bold text-slate-900 dark:text-white">v{{ $version->numero_version }}</span>
                                    @if($version->numero_version == $prompt->version_actual)
                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300">
                                            Actual
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">
                                    {{ $version->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-900 dark:text-slate-100">
                                    {{ $version->mensaje_cambio ?: 'Sin descripción' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                                    {{ Str::limit($version->contenido, 60) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    @if($version->numero_version != $prompt->version_actual)
                                        <form action="{{ route('prompts.restaurar', [$prompt, $version]) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    onclick="return confirm('¿Deseas restaurar esta versión como la actual?')"
                                                    class="bg-amber-500 hover:bg-amber-600 text-white font-medium px-4 py-2 rounded-lg transition-colors inline-flex items-center gap-2">
                                                <i class="fas fa-undo"></i> Restaurar
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            @if($versiones->hasPages())
                <div class="bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 px-6 py-4">
                    {{ $versiones->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

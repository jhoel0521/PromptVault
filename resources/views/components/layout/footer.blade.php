{{-- Footer - Tailwind --}}
<footer class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm px-6 py-5">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="space-y-2">
            <h3
                class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wide border-b-2 border-red-600 inline-block pb-1">
                Contacto</h3>
            <p class="text-sm text-slate-600 dark:text-slate-300">Soporte 24/7: contacto@promptvault.ai</p>
            <p class="text-sm text-slate-600 dark:text-slate-300">Operación global en línea</p>
        </div>
        <div class="space-y-2">
            <h3
                class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wide border-b-2 border-red-600 inline-block pb-1">
                PromptVault</h3>
            <p class="text-sm text-slate-600 dark:text-slate-300">Gestiona y comparte prompts con versionado,
                colaboración y seguridad integrada.</p>
        </div>
        <div class="space-y-2">
            <h3
                class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wide border-b-2 border-red-600 inline-block pb-1">
                Legal</h3>
            <div class="flex gap-4 text-sm text-slate-600 dark:text-slate-300">
                <a href="#" class="hover:text-red-600 dark:hover:text-red-400">Privacidad</a>
                <a href="#" class="hover:text-red-600 dark:hover:text-red-400">Términos</a>
                <a href="#" class="hover:text-red-600 dark:hover:text-red-400">Contacto</a>
            </div>
        </div>
    </div>
    <div
        class="border-t border-slate-200 dark:border-slate-700 mt-4 pt-4 flex flex-col md:flex-row justify-between text-sm text-slate-500 dark:text-slate-400">
        <span>&copy; {{ date('Y') }} PromptVault. Todos los derechos reservados.</span>
    </div>
</footer>

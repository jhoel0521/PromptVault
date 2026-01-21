<x-configuraciones-layout>
    <div class="space-y-6">
        <!-- Información General -->
        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-globe text-rose-500"></i>
                    <span class="text-white font-semibold">Información General</span>
                </div>
            </div>

            <form action="{{ route('admin.configuraciones.update') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-form-label icon="signature">Nombre del Sistema</x-form-label>
                        <input type="text" name="app_name" value="{{ $settings->app_name }}"
                            class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors"
                            required>
                    </div>
                    <div>
                        <x-form-label icon="link">URL Principal</x-form-label>
                        <input type="text" value="{{ url('/') }}" readonly
                            class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-gray-400 opacity-70">
                    </div>
                    <div>
                        <x-form-label icon="envelope">Correo de Soporte</x-form-label>
                        <input type="email" name="support_email" value="{{ $settings->support_email }}"
                            class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                    </div>
                    <div>
                        <x-form-label icon="phone">Teléfono de Contacto</x-form-label>
                        <input type="text" name="contact_phone" value="{{ $settings->contact_phone }}"
                            class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                    </div>

                    <div>
                        <x-form-label icon="link">URL de la App (.env)</x-form-label>
                        <input type="text" name="app_url" value="{{ $settings->app_url }}"
                            class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                    </div>
                    <div>
                        <x-form-label icon="server">Entorno (APP_ENV)</x-form-label>
                        <x-form-select name="app_env">
                            <option value="local" {{ $settings->app_env === 'local' ? 'selected' : '' }}>local</option>
                            <option value="staging" {{ $settings->app_env === 'staging' ? 'selected' : '' }}>staging</option>
                            <option value="production" {{ $settings->app_env === 'production' ? 'selected' : '' }}>production</option>
                        </x-form-select>
                    </div>
                    <div>
                        <x-form-label icon="language">Locale (APP_LOCALE)</x-form-label>
                        <input type="text" name="app_locale" value="{{ $settings->app_locale }}"
                            class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                    </div>
                    <div>
                        <x-form-label icon="flag">Fallback Locale (APP_FALLBACK_LOCALE)</x-form-label>
                        <input type="text" name="app_fallback_locale" value="{{ $settings->app_fallback_locale }}"
                            class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                    </div>

                    <div>
                        <x-form-label icon="envelope">Mail From Address</x-form-label>
                        <input type="email" name="mail_from_address" value="{{ $settings->mail_from_address }}"
                            class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                    </div>
                    <div>
                        <x-form-label icon="user">Mail From Name</x-form-label>
                        <input type="text" name="mail_from_name" value="{{ $settings->mail_from_name }}"
                            class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                    </div>
                    <div>
                        <x-form-label icon="paper-plane">Mail Mailer</x-form-label>
                        <input type="text" name="mail_mailer" value="{{ $settings->mail_mailer }}"
                            class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                    </div>
                    <div>
                        <x-form-label icon="server">Mail Host</x-form-label>
                        <input type="text" name="mail_host" value="{{ $settings->mail_host }}"
                            class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                    </div>
                    <div>
                        <x-form-label icon="hashtag">Mail Port</x-form-label>
                        <input type="number" name="mail_port" value="{{ $settings->mail_port }}"
                            class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                    </div>

                    <div>
                        <x-form-label icon="database">Session Driver</x-form-label>
                        <input type="text" name="session_driver" value="{{ $settings->session_driver }}"
                            class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                    </div>
                    <div>
                        <x-form-label icon="cloud">Cache Store</x-form-label>
                        <input type="text" name="cache_store" value="{{ $settings->cache_store }}"
                            class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                    </div>
                    <div>
                        <x-form-label icon="tasks">Queue Connection</x-form-label>
                        <input type="text" name="queue_connection" value="{{ $settings->queue_connection }}"
                            class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                    </div>

                    <!-- Modo Mantenimiento -->
                    <div class="col-span-full">
                        <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg border border-white/10">
                            <div>
                                <p class="text-white font-medium text-sm">Modo Mantenimiento</p>
                                <p class="text-gray-400 text-xs mt-0.5">Restringir acceso a usuarios no administradores.
                                </p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="maintenance_mode" value="1"
                                    {{ $settings->maintenance_mode ? 'checked' : '' }} class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-rose-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-500">
                                </div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <x-form-label icon="palette">Tema</x-form-label>
                        <x-form-select name="theme">
                            <option value="dark" {{ $settings->theme === 'dark' ? 'selected' : '' }}>Oscuro</option>
                            <option value="light" {{ $settings->theme === 'light' ? 'selected' : '' }}>Claro</option>
                        </x-form-select>
                    </div>

                    <div>
                        <x-form-label icon="globe">Idioma</x-form-label>
                        <input type="text" value="Español" readonly
                            class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-gray-400 opacity-70">
                    </div>

                </div>

                <div class="flex items-center justify-between pt-4 border-t border-white/10">
                    <div class="flex items-center gap-3">
                        <span
                            class="px-3 py-1 bg-green-500/20 text-green-500 text-xs rounded-full flex items-center gap-1.5">
                            <i class="fas fa-check-circle"></i> Base de Datos
                        </span>
                    </div>
                    <button type="submit"
                        class="px-5 py-2.5 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>

        </div>
</x-configuraciones-layout>

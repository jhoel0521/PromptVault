<x-app-layout :title="'Mis Prompts - PromptVault'">
    <x-prompt.list-container
        :prompts="$prompts"
        :etiquetas="$etiquetas"
        title="Biblioteca de Prompts"
        subtitle="Gestiona y organiza tus prompts personales"
        emptyMessage="No tienes prompts todavia"
        emptyIcon="inbox"
        :showCreate="true"
        :createRoute="route('prompts.create')"
    >
        Mis Prompts
    </x-prompt.list-container>
</x-app-layout>


<x-app-layout :title="'Compartidos Conmigo - PromptVault'">
    <x-prompt.list-container
        :prompts="$prompts"
        :etiquetas="$etiquetas"
        title="Colaboración"
        subtitle="Prompts a los que otros usuarios te han dado acceso"
        emptyMessage="No te han compartido ningún prompt todavía"
        emptyIcon="share-alt"
        :showCreate="false"
    >
        Compartidos Conmigo
    </x-prompt.list-container>
</x-app-layout>


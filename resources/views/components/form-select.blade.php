@props([
    'name' => '',
    'value' => '',
    'required' => false,
])

<select name="{{ $name }}" 
    {{ $required ? 'required' : '' }}
    {{ $attributes->merge(['class' => 'w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-rose-500/20 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:border-rose-500']) }}>
    {{ $slot }}
</select>

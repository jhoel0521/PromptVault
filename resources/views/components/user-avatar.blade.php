{{-- Componente: Avatar de Usuario Reutilizable --}}
@props(['user', 'size' => 'md'])

@php
    $sizeClasses = [
        'xs' => 'w-5 h-5 text-[10px]',
        'sm' => 'w-6 h-6 text-xs',
        'md' => 'w-8 h-8 text-sm',
        'lg' => 'w-10 h-10 text-base',
        'xl' => 'w-12 h-12 text-lg',
        '2xl' => 'w-16 h-16 text-xl',
    ];
    
    $classes = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

@if($user && $user->foto_perfil && file_exists(public_path($user->foto_perfil)))
    <img src="{{ asset($user->foto_perfil) . '?v=' . time() }}" 
         alt="{{ $user->name }}" 
         {{ $attributes->merge(['class' => "$classes rounded-full object-cover"]) }}>
@else
    <div {{ $attributes->merge(['class' => "$classes rounded-full bg-gradient-to-tr from-rose-500 to-blue-500 flex items-center justify-center text-white font-bold"]) }}>
        {{ $user ? substr($user->name, 0, 1) : '?' }}
    </div>
@endif

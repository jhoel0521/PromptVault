@php
    // Determinar qué componente de dashboard mostrar según el rol del usuario
    $user = Auth::user();
    $userRole = 'guest';
    
    if ($user && $user->role) {
        $userRole = $user->role->nombre;
    } elseif (session()->has('user_role')) {
        $userRole = session('user_role');
    }
    
    $dashboardComponent = match($userRole) {
        'admin' => 'components.admin',
        'user' => 'components.user',
        'collaborator' => 'components.collaborator',
        default => 'components.guest',
    };
@endphp

@include($dashboardComponent, ['stats' => $stats ?? []])

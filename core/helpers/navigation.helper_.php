<?php

function getNavigationState(): array {
    $requestUri = $_SERVER['REQUEST_URI'];
    $uriParts = explode('/', trim($requestUri, '/'));

    $currentPage = end($uriParts);
    $currentModule = $uriParts[2] ?? ''; // por ejemplo: configuracion, produccion, etc.

    $routes = getRoutes();
    
    // Determinar si la página actual está activa
    $activeItems = [];
    foreach ($routes[$currentModule] as $page => $label) {
        $activeItems[$page] = $currentPage === $page;
    }

    // Estado del menú
    $menuStates = [
        'ABMs' => (
            $activeItems['operadores'] || $activeItems['perfiles'] || $activeItems['perfilesPorOperador'] ||
            $activeItems['permisos'] || $activeItems['permisosPorOperador'] || $activeItems['permisosPorPerfil'] ||
            $activeItems['personas'] || $activeItems['numeradores'] || $activeItems['destinos'] ||
            $activeItems['transportes'] || $activeItems['vehiculos']
        ) ? 'show' : '',

        'ConfigPC' => (
            $activeItems['impresoras'] || $activeItems['balanzas']
        ) ? 'show' : '',
    ];

    return compact('activeItems', 'menuStates', 'currentModule', 'currentPage', 'routes');
}

<?php

function getRoutes(): array {
    return [
        // Modulo configuración
        'configuracion' => [
            'operadores' => 'Operadores',
            'perfiles' => 'Perfiles',
            'perfilesPorOperador' => 'Perfiles por Operador',
            'permisos' => 'Permisos',
            'permisosPorOperador' => 'Permisos por Operador',
            'permisosPorPerfil' => 'Permisos por Perfil',
            'personas' => 'Personas',
            'numeradores' => 'Numeradores',
            'destinos' => 'Destinos',
            'transportes' => 'Transportes',
            'vehiculos' => 'Vehículos',
            'impresoras' => 'Impresoras',
            'balanzas' => 'Balanzas',
        ],
        // Otros módulos pueden ser añadidos aquí de forma similar
    ];
}

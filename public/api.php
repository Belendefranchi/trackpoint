<?php
// api.php

// Habilitar CORS si fuera necesario (lo dejamos activo para desarrollo)
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Obtener la acción
$accion = $_GET['accion'] ?? $_POST['accion'] ?? null;

// Validar que exista acción
if (!$accion) {
    echo json_encode(['error' => 'Acción no especificada']);
    exit;
}

// Definir un mapa de acciones válidas
$acciones = [
    'obtener_perfiles_por_operador' => __DIR__ . '/../app/modules/configuracion/ajax/obtener_perfiles_por_operador.php',
    'guardar_perfiles_por_operador' => __DIR__ . '/../app/modules/configuracion/ajax/guardar_perfiles_por_operador.php',
    // Acá en el futuro podés seguir agregando más acciones
];

// Verificar si la acción existe en el mapa
if (array_key_exists($accion, $acciones)) {
    require_once $acciones[$accion];
} else {
    echo json_encode(['error' => 'Acción desconocida']);
    exit;
}

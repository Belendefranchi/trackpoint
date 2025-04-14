<?php

// Carga del ruteador y las rutas
require_once __DIR__ . '/../core/router.php';
require_once __DIR__ . '/../config/routes.php';

// Ejecutar el enrutador con la ruta actual
$route = $_GET['route'] ?? '/';
handle_route($route);

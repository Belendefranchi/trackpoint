<?php
date_default_timezone_set("America/Argentina/Buenos_Aires");

// Carga del ruteador y las rutas
require_once __DIR__ . '/../core/router.php';
require_once __DIR__ . '/../core/config/routes.php';

// Ejecutar el enrutador con la ruta actual
$route = $_GET['route'] ?? '/';
handle_route($route);

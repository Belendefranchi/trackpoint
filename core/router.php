<?php

function handle_route($route) {
  // Definí tus rutas en config/routes.php, algo como:
  // $routes = [
  //   '/' => 'dashboard/home.controller.php',
  //   '/login' => 'auth/controllers/login.controller.php',
  //   '/produccion' => 'modules/produccion/controllers/produccion.controller.php'
  // ];

  global $routes;

  if (array_key_exists($route, $routes)) {
    $controllerPath = __DIR__ . '/../' . $routes[$route];

    if (file_exists($controllerPath)) {
      require_once $controllerPath;
    } else {
      // Controlador declarado pero archivo no existe: módulo aún no implementado
      require_once __DIR__ . '/../app/layouts/en_construccion.controller.php';
      mostrarVistaEnConstruccion();
    }
  } else {
    // Ruta no definida en routes.php
    require_once __DIR__ . '/../app/layouts/en_construccion.controller.php';
    mostrarVistaEnConstruccion();
  }
}

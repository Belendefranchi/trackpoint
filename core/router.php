<?php

function handle_route($route) {

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

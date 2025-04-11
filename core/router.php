<?php

function handle_route($route) {
    global $routes;

    if (isset($routes[$route])) {
        require_once __DIR__ . '/../' . $routes[$route];
    } else {
        http_response_code(404);
        echo "Página no encontrada";
    }
}


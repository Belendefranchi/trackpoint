<?php

function cargarVistaConfiguracion($rutaVistaRelativa, $variables = []) {
    extract($variables); // Hace que $operadores, $perfiles, etc. estén disponibles en la vista
    $content = __DIR__ . '/../views/' . $rutaVistaRelativa;
    require_once __DIR__ . '/../views/configuracion.view.php';
}

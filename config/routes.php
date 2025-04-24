<?php

$routes = [
    '/' => 'app/auth/views/login.view.php',
    '/login' => 'app/auth/views/login.view.php',
    '/logout' => 'app/auth/controllers/logout.php',
    '/home' => 'app/dashboard/views/home.view.php',
    
    '/produccion' => 'app/modules/produccion/views/produccion.view.php',
    '/produccion/nuevaReceta' => 'app/modules/produccion/views/produccion.nuevaReceta.view.php',
    '/produccion/recetas' => 'app/modules/produccion/views/produccion.recetas.view.php',

    '/expedicion' => 'app/modules/expedicion/views/expedicion.view.php',

    '/configuracion' => 'app/modules/configuracion/views/configuracion.view.php',
    '/configuracion/ABMs/operadores' => 'app/modules/configuracion/controllers/abm.operadores.controller.php',

];


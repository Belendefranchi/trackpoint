<?php

$routes = [
    '/' => 'app/auth/views/login.view.php',
    '/login' => 'app/auth/views/login.view.php',
    '/logout' => 'app/auth/controllers/logout.php',
    '/home' => 'app/dashboard/views/home.view.php',
    '/register' => 'app/auth/views/register.view.php',
    
    '/produccion' => 'app/modules/produccion/views/produccion.view.php',

    '/expedicion' => 'app/modules/expedicion/views/expedicion.view.php',

    '/configuracion' => 'app/modules/configuracion/views/configuracion.view.php',
    '/configuracion/ABMs/operadores' => 'app/modules/configuracion/controllers/abm.operadores.controller.php',
    '/configuracion/ABMs/perfiles' => 'app/modules/configuracion/controllers/abm.perfiles.controller.php',
    '/configuracion/ABMs/permisos' => 'app/modules/configuracion/controllers/abm.permisos.controller.php',


];


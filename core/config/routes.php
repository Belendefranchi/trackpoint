<?php

$routes = [
	'/' => 'app/auth/controllers/login.controller.php',
	'/login' => 'app/auth/controllers/login.controller.php',
	'/logout' => 'app/auth/controllers/logout.php',
	'/home' => 'app/dashboard/controllers/home.controller.php',
	'/register' => 'app/auth/controllers/register.controller.php',
	'/forbidden' => 'app/layouts/error403.view.php',
	'/notFound' => 'app/layouts/error404.view.php',


	/* ########################################### ----------RECEPCIÓN----------- ########################################### */
	'/recepcion' => 'app/modules/recepcion/controllers/recepcion.controller.php',
	'/recepcion/ingreso/ingresoHacienda' => 'app/modules/recepcion/controllers/ingreso.ingresoHacienda.controller.php',
	'/recepcion/ingreso/ingresoMateriaPrima' => 'app/modules/recepcion/controllers/ingreso.ingresoMateriaPrima.controller.php',


	/* ########################################### ----------PRODUCCIÓN----------- ########################################### */
	'/produccion' => 'app/modules/produccion/controllers/produccion.controller.php',
	'/produccion/salida/etqSecSinSeleccion' => 'app/modules/produccion/controllers/salida.etqSecSinSeleccion.controller.php',


	/* ########################################### ----------EXPEDICIÓN----------- ########################################### */
/* 	'/expedicion' => 'app/modules/expedicion/controllers/expedicion.controller.php', */


	/* ########################################### ---------CONFIGURACIÓN--------- ########################################### */
	'/configuracion' => 'app/modules/configuracion/controllers/configuracion.controller.php',

	'/configuracion/ABMs/operadores' => 'app/modules/configuracion/controllers/abm.operadores.controller.php',
	'/configuracion/ABMs/perfiles' => 'app/modules/configuracion/controllers/abm.perfiles.controller.php',

	'/configuracion/ABMs/permisos' => 'app/modules/configuracion/controllers/abm.permisos.controller.php',
	'/configuracion/ABMs/perfilesPorOperador' => 'app/modules/configuracion/controllers/abm.perfilesPorOperador.controller.php',
	'/configuracion/ABMs/permisosPorPerfil' => 'app/modules/configuracion/controllers/abm.permisosPorPerfil.controller.php',

];


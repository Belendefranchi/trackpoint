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

	'/recepcion/ABMs/mercaderias' => 'app/modules/recepcion/controllers/abm.mercaderias.controller.php',

	'/recepcion/productivos/ingreso_hacienda' => 'app/modules/recepcion/controllers/productivos.hacienda.controller.php',
	'/recepcion/productivos/ingreso_materiaPrima' => 'app/modules/recepcion/controllers/productivos.materiaPrima.controller.php',
	'/recepcion/productivos/ingreso_insumos' => 'app/modules/recepcion/controllers/productivos.insumos.controller.php',
	'/recepcion/noProductivos/ingreso_mercaderia' => 'app/modules/recepcion/controllers/noProductivos.mercaderia.controller.php',


	/* ########################################### ----------PRODUCCIÓN----------- ########################################### */
	'/produccion' => 'app/modules/produccion/controllers/produccion.controller.php',

	'/produccion/ABMs/mercaderias' => 'app/modules/produccion/controllers/abm.mercaderias.controller.php',
	'/produccion/ABMs/procesos' => 'app/modules/produccion/controllers/abm.procesos.controller.php',
	'/produccion/salida/etqSecSinSeleccion' => 'app/modules/produccion/controllers/salida.etqSecSinSeleccion.controller.php',


	/* ########################################### ----------EXPEDICIÓN----------- ########################################### */
	'/expedicion' => 'app/modules/expedicion/controllers/expedicion.controller.php',


	/* ########################################### ---------CONFIGURACIÓN--------- ########################################### */
	'/configuracion' => 'app/modules/configuracion/controllers/configuracion.controller.php',

	'/configuracion/ABMs/operadores' => 'app/modules/configuracion/controllers/abm.operadores.controller.php',
	'/configuracion/ABMs/perfiles' => 'app/modules/configuracion/controllers/abm.perfiles.controller.php',
	'/configuracion/ABMs/permisos' => 'app/modules/configuracion/controllers/abm.permisos.controller.php',
	'/configuracion/ABMs/perfilesPorOperador' => 'app/modules/configuracion/controllers/abm.perfilesPorOperador.controller.php',
	'/configuracion/ABMs/permisosPorPerfil' => 'app/modules/configuracion/controllers/abm.permisosPorPerfil.controller.php',

];


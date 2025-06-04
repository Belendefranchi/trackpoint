<?php
define('VISTA_INTERNA', true);

require_once __DIR__ . '/produccion.controller.php';
/* require_once __DIR__ . '/../models/salida.etqSecSinSeleccion.model.php'; */
require_once __DIR__ . '/../../../../core/config/helpers.php';

// Lógica ajax de actualizar, eliminar y crear Operadores
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		// ####### CREAR #######
		if (isset($_GET['crear'])) {
		
			header('Content-Type: application/json');

		}

	}


// Obtener datos para pasar a la vista
/* $operadores = obtenerOperadores(); */

// Llamar a la función común que carga todo en el layout
$datosVista = [
/* 	'operadores' => $operadores */
];

cargarVistaProduccion('salida.etqSecSinSeleccion.view.php', $datosVista);
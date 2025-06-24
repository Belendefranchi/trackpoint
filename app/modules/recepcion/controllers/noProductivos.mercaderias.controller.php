<?php
define('VISTA_INTERNA', true);

require_once __DIR__ . '/recepcion.controller.php';
/* require_once __DIR__ . '/../models/noProductivos.mercaderias.model.php'; */
require_once __DIR__ . '/../../../../core/config/helpers.php';

// Lógica ajax de actualizar, eliminar y crear mercaderias
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		// ####### CREAR #######
		if (isset($_GET['crear'])) {
		
			header('Content-Type: application/json');

		}

	}


// Obtener datos para pasar a la vista
/* $mercaderias = obtenerMercaderias(); */

// Llamar a la función común que carga todo en el layout
$datosVista = [
/* 	'mercaderias' => $mercaderias */
];

cargarVistaRecepcion('noProductivos.mercaderias.view.php', $datosVista);
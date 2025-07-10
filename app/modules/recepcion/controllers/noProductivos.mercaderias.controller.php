<?php
define('VISTA_INTERNA', true);

// Iniciar sesión siempre al comienzo
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	unset($_SESSION['mercaderia_seleccionada']);
}

require_once __DIR__ . '/recepcion.controller.php';
require_once __DIR__ . '/../../produccion/models/abm.mercaderias.model.php';
require_once __DIR__ . '/../models/noProductivos.mercaderias.model.php';
require_once __DIR__ . '/../../../../core/config/helpers.php';

// Obtener mercaderías
$mercaderias = obtenerMercaderias();

$mercaderiaSeleccionada = $_SESSION['mercaderia_seleccionada'] ?? null;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		// ####### SELECCIONAR MERCADERÍA #######
	if (isset($_GET['seleccionarMercaderia'])) {
		
		$mercaderia_id = $_POST['mercaderia_id'] ?? null;
		$codigo = $_POST['codigo-mercaderia'] ?? '';
		$descripcion = $_POST['descripcion-mercaderia'] ?? '';

		if (empty($mercaderia_id)) {
			echo json_encode(['success' => false, 'message' => 'Error: No se recibio el ID de la mercaderia']);
			exit;
		} else {
			// Guardar la mercadería en sesión
			$_SESSION['mercaderia_seleccionada'] = [
				'mercaderia_id' => $mercaderia_id,
				'codigo' => $codigo,
				'descripcion' => $descripcion
			];
		}
	}

		// ####### CREAR #######
		if (isset($_GET['crear'])) {
		
			header('Content-Type: application/json');

		}

	}


// Obtener datos para pasar a la vista
/* $mercaderias = obtenerMercaderias(); */

// Llamar a la función común que carga todo en el layout
$datosVista = [
	'mercaderias' => $mercaderias
];

cargarVistaRecepcion('noProductivos.mercaderias.view.php', $datosVista);
<?php
define('VISTA_INTERNA', true);

// Iniciar sesión siempre al comienzo
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	unset($_SESSION['mercaderia_seleccionada']);
}

require_once __DIR__ . '/expedicion.controller.php';
require_once __DIR__ . '/../models/egresos.ventas.model.php';
require_once __DIR__ . '/../../configuracion/models/abm.mercaderias.model.php';
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';

// Obtener procesos y mercaderías
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
$datosVista = [
	'mercaderias' => $mercaderias
];

// Llamar a la función común que carga todo en el layout
cargarVistaExpedicion('egresos.ventas.view.php', $datosVista);
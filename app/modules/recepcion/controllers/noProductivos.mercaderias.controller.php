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
		$codigo_mercaderia = $_POST['codigo_mercaderia'] ?? '';
		$descripcion_mercaderia = $_POST['descripcion_mercaderia'] ?? '';

		if (empty($mercaderia_id)) {
			echo json_encode(['success' => false, 'message' => 'Error: No se recibio el ID de la mercaderia']);
			exit;
		} else {
			// Guardar la mercadería en sesión
			$_SESSION['mercaderia_seleccionada'] = [
				'mercaderia_id' => $mercaderia_id,
				'codigo_mercaderia' => $codigo_mercaderia,
				'descripcion_mercaderia' => $descripcion_mercaderia
			];

			echo json_encode(['success' => true]);
      exit;

		}
	}

		// ####### SELECCIONAR X CODIGO #######
	if (isset($_GET['seleccionarCodigoMercaderia'])) {

		header('Content-Type: application/json');

		$codigo_mercaderia = $_POST['codigo_mercaderia'] ?? null;

		if (empty($codigo_mercaderia)) {
			echo json_encode(['success' => false, 'message' => 'Error: No se recibio el código de la mercaderia']);
			exit;
		} else {
			$mercaderia = obtenerMercaderiaPorCodigo($codigo_mercaderia);  // función que deberías tener
			if ($mercaderia) {

				$_SESSION['mercaderia_seleccionada'] = $mercaderia;

				echo json_encode([
					'success' => true,
					'mercaderia_id' => $mercaderia['mercaderia_id'],
					'codigo_mercaderia' => $mercaderia['codigo'],
					'descripcion_mercaderia' => $mercaderia['descripcion'],
				]);
    		exit;

			} else {
				echo json_encode(['success' => false, 'message' => 'Error: No se encontró la mercadería con el código proporcionado']);
				exit;
			}
		}

	}

	// ####### EMITIR CÓDIGO DE BARRAS #######
	if (isset($_GET['emitirCodbar'])) {

		header('Content-Type: application/json');

		$mercaderia_id = $_POST['mercaderia_id'] ?? null;

		if (empty($mercaderia_id)) {
			echo json_encode(['success' => false, 'message' => 'Error: No se recibio el ID de la mercaderia']);
			exit;
		}

		// Lógica para emitir el código de barras
		$resultado = emitirCodigoBarras($mercaderia_id);

		echo json_encode($resultado);	
	}

	// ####### ELIMINAR MERCADERÍA #######
	if (isset($_GET['eliminarMercaderia'])) {

		header('Content-Type: application/json');

		$mercaderia_id = $_POST['mercaderia_id'] ?? null;

		if (empty($mercaderia_id)) {
			echo json_encode(['success' => false, 'message' => 'Error: No se recibio el ID de la mercaderia']);
			exit;
		}

		// Lógica para eliminar la mercadería
		$resultado = eliminarMercaderia($mercaderia_id);

		echo json_encode($resultado);
	}

	// ####### ACTUALIZAR MERCADERÍA #######
	if (isset($_GET['actualizarMercaderia'])) {

		header('Content-Type: application/json');

		$datos = $_POST;

		if (empty($datos['mercaderia_id'])) {
			echo json_encode(['success' => false, 'message' => 'Error: No se recibio el ID de la mercaderia']);
			exit;
		}

		// Lógica para actualizar la mercadería
		$resultado = actualizarMercaderia($datos);

		echo json_encode($resultado);
	}
}
	
	// Obtener datos para pasar a la vista
	$datosVista = [
		'mercaderias' => $mercaderias
	];
	
// Llamar a la función común que carga todo en el layout
cargarVistaRecepcion('noProductivos.mercaderias.view.php', $datosVista);
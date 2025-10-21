<?php
define('VISTA_INTERNA', true);

// Iniciar sesión siempre al comienzo
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	unset($_SESSION['mercaderia_seleccionada']);
}

require_once __DIR__ . '/../../module.controller.php';
require_once __DIR__ . '/../models/egresos.ventas.model.php';
require_once __DIR__ . '/../../configuracion/models/abm.mercaderias.model.php';
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';

// Obtener procesos y mercaderías
$mercaderias = obtenerMercaderiasActivas();

/* $mercaderiaSeleccionada = $_SESSION['mercaderia_seleccionada'] ?? null; */


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


	// ####### SELECCIONAR MERCADERÍA #######
	if (isset($_GET['seleccionarMercaderia'])) {
		
		$mercaderia_id = $_POST['mercaderia_id'] ?? null;
		$codigo_mercaderia = $_POST['codigo_mercaderia'] ?? '';
		$descripcion_mercaderia = $_POST['descripcion_mercaderia'] ?? '';
		$codext_mercaderia = $_POST['codext_mercaderia'] ?? '';
		
		if (empty($mercaderia_id)) {
			echo json_encode(['success' => false, 'message' => 'Error: No se recibio el ID de la mercaderia']);
			exit;
		} else {
			echo json_encode([
				'success' => true,
				'mercaderia_id' => $mercaderia_id,
				'codigo_mercaderia' => $codigo_mercaderia,
				'descripcion_mercaderia' => $descripcion_mercaderia,
				'codext_mercaderia' => $codext_mercaderia
			]);
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
			try {
				$mercaderia = obtenerMercaderiaPorCodigo($codigo_mercaderia);

				if ($mercaderia) {

					echo json_encode([
						'success' => true,
						'mercaderia_id' => $mercaderia['mercaderia_id'],
						'codigo_mercaderia' => $mercaderia['codigo'],
					]);
					exit;
				} else {
					echo json_encode(['success' => false, 'message' => 'Mercadería no encontrada']);
					exit;
				}
			} catch (Exception $e) {
				registrarEvento("Egresos Ventas Controller: Error al procesar los datos " . $e->getMessage(), "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
			}
		}
	}

	// ####### AGREGAR MERCADERÍA #######
	if (isset($_GET['agregarMercaderia'])) {

		header('Content-Type: application/json');
		
    $datos = [
      'fecha_produccion'  => $_POST['fecha_produccion'],
			'mercaderia_id' => $_POST['mercaderia_id'],
			'unidades' => $_POST['unidades'],
			'operador_id' => $_SESSION['operador_id'],
    ];

		// Validar datos obligatorios
		if (empty($datos['fecha_produccion']) || empty($datos['mercaderia_id']) || empty($datos['unidades'])) {
			echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios']);
			exit;
		}

		try {
			$result = agregarMercaderia($datos);

			if ($result){
				/* unset($_SESSION['mercaderia_seleccionada']); */
				registrarEvento("Egresos Ventas Controller: Mercadería agregada correctamente => " . $datos['mercaderia_id'], "INFO");
				echo json_encode(['success' => true]);
				exit;
			} else {
				registrarEvento("Egresos Ventas Controller: Error al agregar la mercadería => " . $datos['mercaderia_id'], "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo agregar la mercadería']);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Egresos Ventas Controller: Error al procesar los datos " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
			exit;
		}
		
	}

	}

// Obtener datos para pasar a la vista
$datosVista = [
	'mercaderias' => $mercaderias
];

// Llamar a la función común que carga todo en el layout
cargarVista('/expedicion/views/egresos.ventas.view.php', $datosVista);
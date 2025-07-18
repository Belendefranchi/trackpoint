<?php
define('VISTA_INTERNA', true);

// Iniciar sesión siempre al comienzo
session_start();

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
			try {
				$mercaderia = obtenerMercaderiaPorCodigo($codigo_mercaderia);

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
			} catch (Exception $e) {
				registrarEvento("Recepción Mercaderías Controller: Error al procesar los datos " . $e->getMessage(), "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
			}
		}
	}

	// ####### AGREGAR MERCADERÍA #######
	if (isset($_GET['agregarMercaderia'])) {

		header('Content-Type: application/json');
		
    $datos = [
			'proveedor_id' => $_POST['proveedor_id'],
      'fecha_recepcion'  => $_POST['fecha_recepcion'],
			'nro_remito' => $_POST['nro_remito'],
			'fecha_remito' => $_POST['fecha_remito'],
			'mercaderia_id' => $_POST['mercaderia_id'],
			'unidades' => $_POST['unidades'],
			'peso_neto' => $_POST['peso_neto'],
			'operador_id' => $_SESSION['operador_id'],
    ];


		// Validar datos obligatorios
		if (empty($_POST['proveedor_id']) || empty($_POST['fecha_recepcion']) || empty($_POST['mercaderia_id']) || empty($_POST['unidades']) || empty($_POST['peso_neto'])) {
			echo json_encode(['success' => false, 'message' => 'Error: Faltan datos obligatorios']);
			exit;
		}

		try {
			$result = agregarMercaderia($datos);

			echo json_encode($result);
			
			return $result;
			exit;
		} catch (Exception $e) {
			registrarEvento("Recepción Mercaderías Controller: Error al procesar los datos " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
			exit;
		}
		
	}

	// ####### OBTENER MERCADERÍAS PENDIENTES #######
	if (isset($_GET['obtenerMercaderiasPendientes'])) {

		header('Content-Type: application/json');

		$operador_id = $_SESSION['operador_id'];
		$recepcion_id = obtenerRecepcionAbierta($operador_id);

		if ($recepcion_id) {
			try {

				$resumen = obtenerResumenRecepcion($recepcion_id);
				$detalle = obtenerDetalleRecepcion($recepcion_id);

				echo json_encode([
					'success' => true,
					'resumen' => $resumen,
					'detalle' => $detalle
				]);
				exit;
			} catch (Exception $e) {
				registrarEvento("Recepción Mercaderías Controller: Error al obtener mercaderías pendientes " . $e->getMessage(), "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
			}
		} else {
			echo json_encode(['success' => false, 'message' => 'No se encontró ninguna recepción abierta para este operador.']);
		}
		
		exit;
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

	// ####### GUARDAR MERCADERÍA #######
	if (isset($_GET['guardarRecepcion'])) {

		header('Content-Type: application/json');

		$operador_id = $_SESSION['operador_id'];
		$recepcion_id = obtenerRecepcionAbierta($operador_id);
		
		try {

			if ($recepcion_id) {
				$resultado = guardarRecepcion($recepcion_id);
				echo json_encode($resultado);
			} else {
				echo json_encode(['success' => false, 'message' => 'No se encontró ninguna recepción abierta para este operador.']);
			}
			exit;
		} catch (Exception $e) {
			registrarEvento("Recepción Mercaderías Controller: Error al procesar los datos " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
		}

	}

};

	
// Obtener datos para pasar a la vista
$datosVista = [
	'mercaderias' => $mercaderias,
	'resumen' => $resumen ?? [],
	'detalle' => $detalle ?? []
];
	
// Llamar a la función común que carga todo en el layout
cargarVistaRecepcion('noProductivos.mercaderias.view.php', $datosVista);
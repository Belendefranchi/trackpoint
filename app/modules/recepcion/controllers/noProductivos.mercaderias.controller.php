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

// Obtener resumen y detalle de recepción si hay una sesión activa
$resumen = obtenerResumenRecepcion($_SESSION['operador_id'] ?? null);
$detalle = obtenerDetalleRecepcion($resumen['recepcion_id'] ?? null);

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
					echo json_encode(['success' => false, 'message' => 'Mercadería no encontrada']);
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
			echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios']);
			exit;
		}

		try {
			$result = agregarMercaderia($datos);

			if ($result){
				unset($_SESSION['mercaderia_seleccionada']);
				registrarEvento("Mercaderías Controller: Mercadería agregada correctamente => " . $datos['mercaderia_id'], "INFO");
				echo json_encode(['success' => true]);
				exit;
			} else {
				registrarEvento("Recepción Mercaderías Controller: Error al agregar la mercadería => " . $datos['mercaderia_id'], "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo agregar la mercadería']);
				exit;
			}
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

		if ($operador_id) {
			try {

				$resumen = obtenerResumenRecepcion($operador_id);
				$detalle = obtenerDetalleRecepcion($resumen['recepcion_id']);

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
		$resumen = obtenerResumenRecepcion($operador_id);
		$recepcion_id = $resumen['recepcion_id'];
		
		try {

			$result = guardarRecepcion($recepcion_id);

			if ($result){
				registrarEvento("Recepción Mercaderías Controller: Recepción guardada correctamente => " . $resumen['recepcion_id'], "INFO");
				echo json_encode(['success' => true]);
				exit;
			} else {
				registrarEvento("Recepción Mercaderías Controller: Error al guardar la recepción => " . $resumen['recepcion_id'], "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo guardar la recepción']);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Recepción Mercaderías Controller: Error al procesar los datos " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
		}

	}

};

	
// Obtener datos para pasar a la vista
$datosVista = [
	'mercaderias' => $mercaderias,
	'mercaderiaSeleccionada' => $mercaderiaSeleccionada,
	'resumen' => $resumen,
	'detalle' => $detalle
];
	
// Llamar a la función común que carga todo en el layout
cargarVistaRecepcion('noProductivos.mercaderias.view.php', $datosVista);
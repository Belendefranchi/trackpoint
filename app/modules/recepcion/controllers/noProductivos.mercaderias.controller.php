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

		$proveedor_id = $_POST['proveedor_id'];
		$fecha_recepcion = $_POST['fecha_recepcion'];
		$nro_remito = $_POST['nro_remito'];
		$fecha_remito = $_POST['fecha_remito'];
		$mercaderia_id = $_POST['mercaderia_id'];
		$unidades = $_POST['unidades'];
		$peso_neto = $_POST['peso_neto'];
		$fechaActual = date('Y-m-d H:i:s');
		$operador_id = $_SESSION['operador_id'];

		// Validar datos obligatorios
		if (empty($_POST['mercaderia_id']) || empty($_POST['proveedor_id']) || empty($_POST['fecha_recepcion']) || empty($_POST['mercaderia_id']) || empty($_POST['unidades']) || empty($_POST['peso_neto'])) {
			echo json_encode(['success' => false, 'message' => 'Error: Faltan datos obligatorios']);
			exit;
		}

		try {
			$result = agregarMercaderia([
				'proveedor_id' => $proveedor_id,
				'fecha_recepcion' => $fecha_recepcion,
				'nro_remito' => $nro_remito,
				'fecha_remito' => $fecha_remito,
				'mercaderia_id' => $mercaderia_id,
				'unidades' => $unidades,
				'peso_neto' => $peso_neto,
				'fecha_sistema' => $fechaActual,
				'operador_id' => $operador_id
			]);

			echo json_encode($result);
			exit;
		} catch (Exception $e) {
			registrarEvento("Recepción Mercaderías Controller: Error al procesar los datos " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
			exit;
		}
		
	}
	

	// ####### GUARDAR MERCADERÍA #######
	if (isset($_GET['guardarMercaderia'])) {

		header('Content-Type: application/json');

		$mercaderia_id = $_POST['mercaderia_id'];
    $proveedor_id = $_POST['proveedor_id'];
    $fecha_recepcion = $_POST['fecha_recepcion'];
    $nro_remito = $_POST['nro_remito'];
    $fecha_remito = $_POST['fecha_remito'];
    $codigo_mercaderia = $_POST['codigo_mercaderia'];
    $descripcion_mercaderia = $_POST['descripcion_mercaderia'];
    $unidades = $_POST['unidades'];
    $peso_neto = $_POST['peso_neto'];

		if (empty($fecha_recepcion) || empty($codigo_mercaderia) || empty($descripcion_mercaderia) || empty($unidades) || empty($peso_neto) ) {
			echo json_encode(['success' => false, 'message' => 'Error: Faltan datos obligatorios']);
			exit;
		}

		try {
			// Lógica para guardar la mercadería
			$result = guardarMercaderia([
				'mercaderia_id' => $mercaderia_id,
				'proveedor_id' => $proveedor_id,
				'fecha_recepcion' => $fecha_recepcion,
				'nro_remito' => $nro_remito,
				'fecha_remito' => $fecha_remito,
				'codigo_mercaderia' => $codigo_mercaderia,
				'descripcion_mercaderia' => $descripcion_mercaderia,
				'unidades' => $unidades,
				'peso_neto' => $peso_neto,
				'tara' => $_POST['tara'] ?? 0
			]);

			echo json_encode($result);
			exit;
		} catch (Exception $e) {
			registrarEvento("Recepción Mercaderías Controller: Error al procesar los datos " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
		}

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
};

	
// Obtener datos para pasar a la vista
$datosVista = [
	'mercaderias' => $mercaderias
];
	
// Llamar a la función común que carga todo en el layout
cargarVistaRecepcion('noProductivos.mercaderias.view.php', $datosVista);
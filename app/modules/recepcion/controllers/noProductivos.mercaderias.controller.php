<?php
define('VISTA_INTERNA', true);

// Iniciar sesión siempre al comienzo
session_start();

require_once __DIR__ . '/../../module.controller.php';
require_once __DIR__ . '/../models/noProductivos.mercaderias.model.php';
require_once __DIR__ . '/../../configuracion/models/abm.mercaderias.model.php';
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';


// Obtener mercaderías
$mercaderias = obtenerMercaderiasActivas();

// Obtener resumen y detalle de recepción si hay una sesión activa
$resumen = obtenerResumenRecepcion($_SESSION['operador_id'] ?? null);
$detalle = obtenerDetalleRecepcion($resumen[0]['recepcion_id'] ?? null);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// ####### SELECCIONAR MERCADERÍA #######
	if (isset($_GET['seleccionarMercaderia'])) {
		
		$mercaderia_id = $_POST['mercaderia_id'] ?? null;
		$codigo_mercaderia = $_POST['codigo_mercaderia'] ?? '';
		$descripcion_mercaderia = $_POST['descripcion_mercaderia'] ?? '';
		$cantidad_propuesta = $_POST['unidades'];
		$peso_propuesto = $_POST['peso_neto'];

		if (empty($mercaderia_id)) {
			echo json_encode(['success' => false, 'message' => 'Error: No se recibio el ID de la mercaderia']);
			exit;
		} else {
			echo json_encode([
				'success' => true,
				'mercaderia_id' => $mercaderia_id,
				'codigo_mercaderia' => $codigo_mercaderia,
				'descripcion_mercaderia' => $descripcion_mercaderia,
				'cantidad_propuesta' => $cantidad_propuesta,
				'peso_propuesto' => $peso_propuesto
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
						'descripcion_mercaderia' => $mercaderia['descripcion'],
						'cantidad_propuesta' => $mercaderia['cantidad_propuesta'],
						'peso_propuesto' => $mercaderia['peso_propuesto'],
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
			'fecha_remito' => $_POST['fecha_remito'] ?? null,
			'mercaderia_id' => $_POST['mercaderia_id'],
			'unidades' => $_POST['unidades'],
			'peso_neto' => $_POST['peso_neto'],
			'operador_id' => $_SESSION['operador_id'],
    ];

		// Validar datos obligatorios
		if (empty($datos['proveedor_id']) || empty($datos['fecha_recepcion']) || empty($datos['mercaderia_id']) || empty($datos['unidades']) || empty($datos['peso_neto'])) {
			echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios']);
			exit;
		}

		try {
			$result = agregarMercaderia($datos);

			if ($result){
				registrarEvento("Recepción Mercaderías Controller: Mercadería agregada correctamente => " . $datos['mercaderia_id'], "INFO");
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
	
	// ####### EDITAR MERCADERÍA #######
	if (isset($_GET['editarMercaderia'])) {

		header('Content-Type: application/json');

		$datos = [
			'item_id' => $_POST['item_id'],
			'proveedor_id' => $_POST['proveedor_id'],
      'fecha_recepcion'  => $_POST['fecha_recepcion'],
			'nro_remito' => $_POST['nro_remito'] ?? '',
			'fecha_remito' => $_POST['fecha_remito'],
			'unidades' => $_POST['unidades'],
			'peso_neto' => $_POST['peso_neto'],
    ];

		if (empty($datos['item_id'])) {
			echo json_encode(['success' => false, 'message' => 'Error: No se recibio el ID del ítem']);
			exit;
		}
		
		try {
		// Lógica para editar la mercadería
		$result = editarMercaderiaRecepcion($datos);

		if ($result) {
			registrarEvento("Recepción Mecaderías Controller: Ítem modificado correctamente", "INFO");
			echo json_encode(['success' => true]);
			exit;
		}	else {
				// Respuesta de error
				registrarEvento("Recepción Mecaderías Controller: Error al modificar el ítem", "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo modificar el ítem']);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Recepción Mecaderías Controller: Error al procesar los datos " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Controller: Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}

	// ####### ELIMINAR MERCADERÍA #######
	if (isset($_GET['eliminarMercaderia'])) {

		header('Content-Type: application/json');

		$item_id = $_POST['item_id'] ?? null;

		if (empty($item_id)) {
			echo json_encode(['success' => false, 'message' => 'Error: No se recibio el ID de la mercaderia']);
			exit;
		}
		try {
			// Lógica para eliminar la mercadería
			$result = eliminarMercaderiaRecepcion($item_id);

			if ($result) {
				registrarEvento("Recepción Mecaderías Controller: Ítem eliminado correctamente", "INFO");
				echo json_encode(['success' => true]);
				exit;
			} else {
				// Respuesta de error
				registrarEvento("Recepción Mecaderías Controller: Error al eliminar el ítem", "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo eliminar el ítem']);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Recepción Mecaderías Controller: Error al procesar los datos " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Controller: Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}

	// ####### GUARDAR RECEPCIÓN #######
	if (isset($_GET['guardarRecepcion'])) {

		header('Content-Type: application/json');

		$operador_id = $_SESSION['operador_id'];
		$resumen = obtenerResumenRecepcion($operador_id);
		$recepcion_id = $resumen[0]['recepcion_id'];

		// Validar si hay mercaderías cargadas
    if (empty($resumen)) {
			echo json_encode([
					'success' => false,
					'message' => 'Aún no se ingresaron mercaderías'
			]);
			exit;
    }
		
		try {
			$result = guardarRecepcion($recepcion_id);

			if ($result['success']) {
				registrarEvento("Recepción Mercaderías Controller: Recepción guardada correctamente => " . $resumen[0]['recepcion_id'], "INFO");
				echo json_encode(['success' => true, 'message' => $result['message']]);
				exit;
			} else {
				registrarEvento("Recepción Mercaderías Controller: Error al guardar la recepción => " . $resumen[0]['recepcion_id'], "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo guardar la recepción']);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Recepción Mercaderías Controller: Error al procesar los datos " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
		}

	}

	// ####### CANCELAR RECEPCIÓN #######
	if (isset($_GET['cancelarRecepcion'])) {

		header('Content-Type: application/json');

		$operador_id = $_SESSION['operador_id'];
		$resumen = obtenerResumenRecepcion($operador_id);
		$recepcion_id = $resumen[0]['recepcion_id'];

		// Validar si hay mercaderías cargadas
    if (empty($resumen)) {
			echo json_encode([
					'success' => false,
					'message' => 'Aún no se ingresaron mercaderías'
			]);
			exit;
    }
		
		try {
			$result = cancelarRecepcion($recepcion_id);

			if ($result['success']) {
				registrarEvento("Recepción Mercaderías Controller: Recepción cancelada correctamente => " . $resumen[0]['recepcion_id'], "INFO");
				echo json_encode(['success' => true, 'message' => $result['message']]);
				exit;
			} else {
				registrarEvento("Recepción Mercaderías Controller: Error al cancelar la recepción => " . $resumen[0]['recepcion_id'], "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo cancelar la recepción']);
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
	'resumen' => $resumen,
	'detalle' => $detalle
];
	
// Llamar a la función común que carga todo en el layout
cargarVista('/recepcion/views/noProductivos.mercaderias.view.php', $datosVista);
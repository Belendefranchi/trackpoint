<?php
define('VISTA_INTERNA', true);

// Iniciar sesión siempre al comienzo
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	unset($_SESSION['mercaderia_seleccionada']);
}

require_once __DIR__ . '/../../module.controller.php';
require_once __DIR__ . '/../models/egresos.presupuestos.model.php';
require_once __DIR__ . '/../../configuracion/models/abm.mercaderias.model.php';
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';

// Obtener procesos y mercaderías
$mercaderias = obtenerMercaderiasActivas();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// ####### SELECCIONAR MERCADERÍA #######
	if (isset($_GET['seleccionarMercaderia'])) {
		
		$mercaderia_id = $_POST['mercaderia_id'] ?? null;
		$codigo_mercaderia = $_POST['codigo_mercaderia'] ?? '';
		$descripcion_mercaderia = $_POST['descripcion_mercaderia'] ?? '';
		$codext_mercaderia = $_POST['codext_mercaderia'] ?? '';
		$precio_venta = $_POST['precio_venta'] ?? 0;
		
		if (empty($mercaderia_id)) {
			echo json_encode(['success' => false, 'message' => 'Error: No se recibio el ID de la mercaderia']);
			exit;
		} else {
			echo json_encode([
				'success' => true,
				'mercaderia_id' => $mercaderia_id,
				'codigo_mercaderia' => $codigo_mercaderia,
				'descripcion_mercaderia' => $descripcion_mercaderia,
				'codext_mercaderia' => $codext_mercaderia,
				'precio_venta' => $precio_venta
			]);
			exit;
		}
	}

	// ####### AGREGAR MERCADERÍA #######
	if (isset($_GET['agregarMercaderia'])) {

		header('Content-Type: application/json');
		
    $datos = [
			'mercaderia_id' => $_POST['mercaderia_id'],
			'cantidad_mercaderia' => $_POST['cantidad'],
			'codext_mercaderia' => $_POST['codigo_externo'],
			'precio_venta' => $_POST['precio_venta'],
			'fecha_presupuesto' => $_POST['fecha_presupuesto'],
			'fecha_vencimiento' => $_POST['fecha_vencimiento'],
			'operador_id' => $_SESSION['operador_id'],
    ];

		// Validar datos obligatorios
		if (empty($datos['mercaderia_id']) || empty($datos['cantidad_mercaderia']) || empty($datos['precio_venta'])) {
			echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios']);
			exit;
		}

		try {
			$result = agregarMercaderia($datos);

			if ($result){
				registrarEvento("Presupuestos Controller: Mercadería agregada correctamente => " . $datos['mercaderia_id'], "INFO");
				echo json_encode(['success' => true]);
				exit;
			} else {
				registrarEvento("Presupuestos Controller: Error al agregar la mercadería => " . $datos['mercaderia_id'], "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo agregar la mercadería']);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Presupuestos Controller: Error al procesar los datos " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
			exit;
		}
		
	}

	// ####### EDITAR MERCADERÍA #######
	if (isset($_GET['editarMercaderia'])) {

		header('Content-Type: application/json');

		$datos = [
			'item_id' => $_POST['item_id'],
			'cantidad_mercaderia' => $_POST['cantidad'],
			'precio_venta' => $_POST['precio_venta'],
    ];

		if (empty($datos['item_id'])) {
			echo json_encode(['success' => false, 'message' => 'Error: No se recibio el ID del ítem']);
			exit;
		}
		
		try {
		// Lógica para editar la mercadería
		$result = editarMercaderiaPresupuesto($datos);

		if ($result) {
			registrarEvento("Presupuestos Controller: Ítem modificado correctamente", "INFO");
			echo json_encode(['success' => true]);
			exit;
		}	else {
				// Respuesta de error
				registrarEvento("Presupuestos Controller: Error al modificar el ítem", "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo modificar el ítem']);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Presupuestos Controller: Error al procesar los datos " . $e->getMessage(), "ERROR");
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
			$result = eliminarMercaderiaPresupuesto($item_id);

			if ($result) {
				registrarEvento("Presupuestos Controller: Ítem eliminado correctamente", "INFO");
				echo json_encode(['success' => true]);
				exit;
			} else {
				// Respuesta de error
				registrarEvento("Presupuestos Controller: Error al eliminar el ítem", "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo eliminar el ítem']);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Presupuestos Controller: Error al procesar los datos " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Controller: Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}

	// ####### GUARDAR PRESUPUESTO #######
	if (isset($_GET['guardarPresupuesto'])) {

		header('Content-Type: application/json');

		$operador_id = $_SESSION['operador_id'];
		$resumen = obtenerResumenPresupuesto($operador_id);
		$presupuesto_id = $resumen[0]['presupuesto_id'];

		// Validar si hay mercaderías cargadas
    if (empty($resumen)) {
			echo json_encode([
					'success' => false,
					'message' => 'Aún no se ingresaron mercaderías'
			]);
			exit;
    }
		
		try {
			$result = guardarPresupuesto($presupuesto_id);

			if ($result['success']) {
				registrarEvento("Presupuestos Controller: Presupuesto guardado correctamente => " . $resumen[0]['presupuesto_id'], "INFO");
				echo json_encode(['success' => true, 'message' => $result['message']]);
				exit;
			} else {
				registrarEvento("Presupuestos Controller: Error al guardar el presupuesto => " . $resumen[0]['presupuesto_id'], "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo guardar el presupuesto']);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Presupuestos Controller: Error al procesar los datos " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
		}

	}

	// ####### CANCELAR PRESUPUESTO #######
	if (isset($_GET['cancelarPresupuesto'])) {

		header('Content-Type: application/json');

		$operador_id = $_SESSION['operador_id'];
		$resumen = obtenerResumenPresupuesto($operador_id);
		$presupuesto_id = $resumen[0]['presupuesto_id'];

		// Validar si hay mercaderías cargadas
    if (empty($resumen)) {
			echo json_encode([
					'success' => false,
					'message' => 'Aún no se ingresaron mercaderías'
			]);
			exit;
    }
		
		try {
			$result = cancelarPresupuesto($presupuesto_id);

			if ($result['success']) {
				registrarEvento("Presupuestos Controller: Presupuesto cancelado correctamente => " . $resumen[0]['presupuesto_id'], "INFO");
				echo json_encode(['success' => true, 'message' => $result['message']]);
				exit;
			} else {
				registrarEvento("Presupuestos Controller: Error al cancelar el presupuesto => " . $resumen[0]['presupuesto_id'], "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo cancelar el presupuesto']);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Presupuestos Controller: Error al procesar los datos " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
		}
	}

}

// Obtener datos para pasar a la vista
$datosVista = [
	'mercaderias' => $mercaderias,
/* 	'resumen' => $resumen,
	'detalle' => $detalle */
];

// Llamar a la función común que carga todo en el layout
cargarVista('/expedicion/views/egresos.presupuestos.view.php', $datosVista);
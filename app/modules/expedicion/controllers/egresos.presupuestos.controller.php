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

// Obtener resumen y detalle de recepción si hay una sesión activa
$resumen = obtenerResumenPresupuesto($_SESSION['operador_id'] ?? null);
$detalle = obtenerDetallePresupuesto($resumen[0]['presupuesto_id'] ?? null);

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
			echo json_encode([
				'success' => true,
				'mercaderia_id' => $mercaderia_id,
				'codigo_mercaderia' => $codigo_mercaderia,
				'descripcion_mercaderia' => $descripcion_mercaderia
			]);
			exit;
		}
	}

	// ####### SELECCIONAR X CODIGO #######
	if (isset($_GET['seleccionarCodigoMercaderia'])) {

		header('Content-Type: application/json');

		$codigo_mercaderia = $_POST['codigo_mercaderia'] ?? null;
		$codext_mercaderia = $_POST['codext_mercaderia'] ?? null;

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
						'descripcion_mercaderia' => $mercaderia['descripcion']
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
			'empresa_id' => $_POST['empresa_id'], //resumen
			'sucursal_id' => $_POST['sucursal_id'], //resumen
			'rubro_id' => $_POST['rubro_id'], //resumen
			'fecha_presupuesto' => $_POST['fecha_presupuesto'], //resumen
			'fecha_vencimiento' => $_POST['fecha_vencimiento'], //resumen
			'cliente_id' => $_POST['cliente_id'], //resumen
			'direccion_cliente' => $_POST['direccion_cliente'], //resumen
			'mercaderia_id' => $_POST['mercaderia_id'], //detalle
			'codigo_mercaderia' => $_POST['codigo_mercaderia'], //detalle
			'cantidad' => round((float)$_POST['cantidad']), //detalle
			'precio_venta' => round((float)$_POST['precio_venta'], 2), //detalle
			'operador_id' => $_SESSION['operador_id'], //resumen y detalle
    ];

		// Validar datos obligatorios
		if (empty($datos['mercaderia_id']) || empty($datos['cantidad']) || empty($datos['precio_venta'])) {
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

	// ####### GENERAR PRESUPUESTO #######
	if (isset($_GET['generarPresupuesto'])) {

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

		// ####### EDITAR PRESUPUESTO #######
	if (isset($_GET['editarPresupuesto'])) {

		header('Content-Type: application/json');

		$datos = [
			'presupuesto_id' => $_POST['presupuesto_id'],
			'empresa_id' => $_POST['empresa_id'],
			'sucursal_id' => $_POST['sucursal_id'],
			'rubro_id' => $_POST['rubro_id'],
			'fecha_presupuesto' => $_POST['fecha_presupuesto'],
			'fecha_vencimiento' => $_POST['fecha_vencimiento'],
			'cliente_id' => $_POST['cliente_id'],
			'direccion_cliente' => $_POST['direccion_cliente'],
    ];

		if (empty($datos['presupuesto_id'])) {
			echo json_encode(['success' => false, 'message' => 'Error: No se recibio el ID del presupuesto']);
			exit;
		}
		
		try {
		// Lógica para editar el presupuesto
		$result = editarPresupuesto($datos);

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
	'resumen' => $resumen,
	'detalle' => $detalle
];

// Llamar a la función común que carga todo en el layout
cargarVista('/expedicion/views/egresos.presupuestos.view.php', $datosVista);
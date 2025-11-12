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

// Obtener resumen y detalle de recepción si hay una sesión activa
$resumen = obtenerResumenPresupuesto($_SESSION['operador_id'] ?? null);
$detalle = obtenerDetallePresupuesto($resumen[0]['presupuesto_id'] ?? null);

// Obtener procesos y mercaderías
$mercaderias = obtenerMercaderiasActivas();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// ####### CREAR PRESUPUESTO #######
	if (isset($_GET['crear'])) {

		header('Content-Type: application/json');

    $datos = [
			'empresa_id' => $_POST['empresa_id'],
			'sucursal_id' => $_POST['sucursal_id'],
			'rubro_id' => $_POST['rubro_id'],
			'fecha_presupuesto' => $_POST['fecha_presupuesto'],
			'fecha_vencimiento' => $_POST['fecha_vencimiento'],
			'cliente_id' => $_POST['cliente_id'],
			'direccion_cliente' => $_POST['direccion_cliente'],
			'contacto_nombre' => $_POST['contacto_nombre'] ?? '',
			'operador_id' => $_SESSION['operador_id'],
    ];

		try {
			$result = crearPresupuesto($datos);

			if ($result) {
				registrarEvento("Presupuestos Controller: Presupuesto creado correctamente => " . $result['presupuesto_id'], "INFO");
				echo json_encode(['success' => true]);
				exit;
			} else {
				// Respuesta de error
				registrarEvento("Presupuestos Controller: Error al crear el presupuesto", "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo crear el presupuesto']);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Presupuestos Controller: Error al procesar los datos " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
			exit;
		}
	}
	
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
			'empresa_id' => $_POST['empresa_id'],
			'sucursal_id' => $_POST['sucursal_id'],
			'rubro_id' => $_POST['rubro_id'],
			'fecha_presupuesto' => $_POST['fecha_presupuesto'],
			'fecha_vencimiento' => $_POST['fecha_vencimiento'],
			'cliente_id' => $_POST['cliente_id'],
			'direccion_cliente' => $_POST['direccion_cliente'],
			'contacto_nombre' => $_POST['contacto_nombre'] ?? '',
			'codigo_mercaderia' => $_POST['codigo_mercaderia'],
			'descripcion_mercaderia' => $_POST['descripcion_mercaderia'],
			'cantidad' => round((float)$_POST['cantidad']),
			'precio_venta' => round((float)$_POST['precio_venta'], 2),
			'operador_id' => $_SESSION['operador_id'],
    ];

		// Validar datos obligatorios
		if (empty($datos['codigo_mercaderia']) || empty($datos['cantidad']) || empty($datos['precio_venta'])) {
			echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios']);
			exit;
		}

		try {
			$result = agregarMercaderia($datos);

			if ($result){
				registrarEvento("Presupuestos Controller: Mercadería agregada correctamente => " . $datos['codigo_mercaderia'], "INFO");
				echo json_encode(['success' => true]);
				exit;
			} else {
				registrarEvento("Presupuestos Controller: Error al agregar la mercadería => " . $datos['codigo_mercaderia'], "ERROR");
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
			'codigo_mercaderia' => $_POST['codigo_mercaderia'],
			'descripcion_mercaderia' => $_POST['descripcion_mercaderia'],
			'cantidad' => $_POST['cantidad'],
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

	// ####### OBTENER MERCADERÍA POR CÓDIGO #######
	if (isset($_GET['obtenerMercaderiaPorCodigo'])) {

		header('Content-Type: application/json');

		$item_id = $_POST['item_id'] ?? null;
		$codigo_mercaderia = $_POST['codigo_mercaderia'] ?? null;

		if (empty($codigo_mercaderia)) {
			echo json_encode(['success' => false, 'message' => 'Error: No se recibió el código de la mercadería']);
			exit;
		}

		try {
			// Lógica para obtener la mercadería
			$mercaderia = obtenerMercaderiaPorCodigo($codigo_mercaderia);

			if ($mercaderia) {
				registrarEvento("Presupuestos Controller: Mercadería obtenida correctamente => " . $mercaderia['codigo'], "INFO");
				echo json_encode([
					'success' => true,
					'codigo_mercaderia' => $mercaderia['codigo'],
					'descripcion_mercaderia' => $mercaderia['descripcion'],
					'precio_venta' => $mercaderia['precio_venta']
				]);
				exit;
			} else {
				echo json_encode(['success' => false, 'message' => 'Error: No se encontró la mercadería']);
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

	// ####### EDITAR PRESUPUESTO #######
	if (isset($_GET['editarPresupuesto'])) {

		header('Content-Type: application/json');

		$datos = [
			'presupuesto_id' => $_POST['presupuesto_id'],
			'empresa_id' => $_POST['empresa_id'],
			'sucursal_id' => $_POST['sucursal_id'] ?? null,
			'rubro_id' => $_POST['rubro_id'] ?? null,
			'fecha_presupuesto' => $_POST['fecha_presupuesto'],
			'fecha_vencimiento' => ($_POST['fecha_vencimiento'] === '1900-01-01') ? null : $_POST['fecha_vencimiento'],
			'cliente_id' => $_POST['cliente_id'] ?? null,
			'direccion_cliente' => $_POST['direccion_cliente'] ?? null,
			'contacto_nombre' => $_POST['contacto_nombre'] ?? '',
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

	// ####### ELIMINAR PRESUPUESTO #######
	if (isset($_GET['eliminarPresupuesto'])) {

		header('Content-Type: application/json');

		$operador_id = $_SESSION['operador_id'];
		$resumen = obtenerResumenPresupuesto($operador_id);
		$presupuesto_id = $_POST['presupuesto_id'];

		// Validar si hay mercaderías cargadas
    if (empty($resumen)) {
			echo json_encode([
					'success' => false,
					'message' => 'Aún no se ingresaron mercaderías'
			]);
			exit;
    }
		
		try {
			$result = eliminarPresupuesto($presupuesto_id);

			if ($result['success']) {
				registrarEvento("Presupuestos Controller: Presupuesto eliminado correctamente => " . $presupuesto_id, "INFO");
				echo json_encode(['success' => true, 'message' => $result['message']]);
				exit;
			} else {
				registrarEvento("Presupuestos Controller: Error al eliminar el presupuesto => " . $presupuesto_id, "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo eliminar el presupuesto']);
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
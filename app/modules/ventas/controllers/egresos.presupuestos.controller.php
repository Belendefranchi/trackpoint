<?php
define('VISTA_INTERNA', true);


// Iniciar sesión siempre al comienzo
session_start();

/* var_dump($_POST);
exit; */

unset($_SESSION['presupuesto_id']);
unset($_SESSION['detalle_presupuesto']);

/* if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	unset($_SESSION['mercaderia_seleccionada']);
} */

require_once __DIR__ . '/../../module.controller.php';
require_once __DIR__ . '/../models/egresos.presupuestos.model.php';
require_once __DIR__ . '/../models/egresos.listaPrecios.model.php';
/* require_once __DIR__ . '/../../configuracion/models/abm.mercaderias.model.php'; */
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';

// Obtener presupuesto seleccionado para cargar la lista de prec
$presupuestoSeleccionado = $_SESSION['presupuesto_id'] ?? null;

// Obtener resumen y detalle de recepción si hay una sesión activa
$resumen = obtenerResumenPresupuesto($_SESSION['operador_id'] ?? null);

$ultimoPresupuestoId = obtenerUltimoPresupuestoId();

// Obtener procesos y mercaderías
/* $mercaderias = obtenerMercaderiasActivas(); */

// Obtener listas de precios
$listas = obtenerListasActivas();

// Vista previa del presupuesto
if (isset($_GET['previewPresupuesto'])) {

	$presupuesto_id = $_GET['id'] ?? null;

	if (!$presupuesto_id) {
		echo 'Presupuesto inválido';
		exit;
	}

	// 1. Volver a consultar a la base
	$resumenPresupuesto = obtenerResumenPresupuestoPorId($presupuesto_id);
	$mercaderias = obtenerDetallePresupuesto($presupuesto_id);

	if (!$presupuesto_id) {
		echo 'Presupuesto no encontrado';
		exit;
	}

	// 2. Cargar vista
	require __DIR__ . '/../views/egresos.presupuestos.plantilla.PC.view.php';
	exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// === OBTENER DETALLE Y RENDERIZAR SOLO EL DIV ===
	if (isset($_GET['actualizarDetalle'])) {

		header('Content-Type: application/json');

		$presupuesto_id = $_POST['presupuesto_id'] ?? null;

		if (empty($presupuesto_id)) {
			echo json_encode([
				'success' => false,
				'message' => 'No se recibió el ID del presupuesto'
			]);
			exit;
		}

		try {
			// 1) Obtener el detalle desde el modelo
			$detalle = obtenerDetallePresupuesto($presupuesto_id);

			// 2) Guardarlo en sesión
			$_SESSION['detalle_presupuesto'] = $detalle;

			// 3) Renderizar el fragmento HTML usando la vista
			ob_start();
			include __DIR__ . "/../views/egresos.presupuestos.detalle.view.php";
			$html = ob_get_clean();

			echo json_encode([
				'success' => true,
				'html' => $html,
				'detalle' => $detalle
			]);

			exit;

		} catch (Exception $e) {
			registrarEvento("Error al obtener detalle: " . $e->getMessage(), "ERROR");

			echo json_encode([
				'success' => false,
				'message' => 'Error: ' . $e->getMessage()
			]);
			exit;
		}
	}

	if (isset($_GET['actualizarResumen'])) {

		header('Content-Type: application/json');

		$presupuesto_id = $_POST['presupuesto_id'] ?? null;

		if (empty($presupuesto_id)) {
			echo json_encode([
				'success' => false,
				'message' => 'No se recibió el ID del presupuesto'
			]);
			exit;
		}

		try {
			// 1) Obtener el detalle desde el modelo
			$detalle = obtenerResumenPresupuesto($presupuesto_id);

			// 2) Guardarlo en sesión
			$_SESSION['resumen_presupuesto'] = $resumen;

			// 3) Renderizar el fragmento HTML usando la vista
			ob_start();
			include __DIR__ . "/../views/egresos.presupuestos.resumen.view.php";
			$html = ob_get_clean();

			echo json_encode([
				'success' => true,
				'html' => $html,
				'detalle' => $resumen
			]);

			exit;

		} catch (Exception $e) {
			registrarEvento("Error al obtener resumen: " . $e->getMessage(), "ERROR");

			echo json_encode([
				'success' => false,
				'message' => 'Error: ' . $e->getMessage()
			]);
			exit;
		}
	}

	// ####### CREAR PRESUPUESTO #######
	if (isset($_GET['crearPresupuesto'])) {

		header('Content-Type: application/json');

		$datos = [
			'empresa_nombre' => $_POST['empresa_nombre'],
			'sucursal_nombre' => $_POST['sucursal_nombre'],
			'rubro_nombre' => $_POST['rubro_nombre'],
			'fecha_presupuesto' => $_POST['fecha_presupuesto'],
			'fecha_vencimiento' => $_POST['fecha_vencimiento'],
			'cliente_nombre' => $_POST['cliente_nombre'],
			'cliente_direccion' => $_POST['cliente_direccion'],
			'cliente_contacto' => $_POST['cliente_contacto'] ?? '',
			'operador_id' => $_SESSION['operador_id'],
			'lista_id' => $_POST['lista_id'] ?? null
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

	// ####### EDITAR PRESUPUESTO #######
	if (isset($_GET['editarPresupuesto'])) {

		header('Content-Type: application/json');

		$datos = [
			'presupuesto_id' => $_POST['presupuesto_id'],
			'empresa_nombre' => $_POST['empresa_nombre'],
			'sucursal_nombre' => $_POST['sucursal_nombre'] ?? null,
			'rubro_nombre' => $_POST['rubro_nombre'] ?? null,
			'fecha_presupuesto' => $_POST['fecha_presupuesto'],
			'fecha_vencimiento' => ($_POST['fecha_vencimiento'] === '1900-01-01') ? null : $_POST['fecha_vencimiento'],
			'cliente_nombre' => $_POST['cliente_nombre'] ?? null,
			'cliente_direccion' => $_POST['cliente_direccion'] ?? null,
			'cliente_contacto' => $_POST['cliente_contacto'] ?? '',
			'lista_id' => $_POST['lista_id'] ?? null
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
			} else {
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

	// ####### GENERAR PRESUPUESTO #######
	if (isset($_GET['generarPresupuesto'])) {

		header('Content-Type: application/json');

		if (empty($_POST['presupuesto_id'])) {
			echo json_encode([
				'success' => false,
				'message' => 'No se recibió el ID del presupuesto'
			]);
			exit;
		}

		$presupuesto_id = $_POST['presupuesto_id'];

		try {

			$result = generarPresupuesto($presupuesto_id);

			if ($result['success']) {
				registrarEvento("Presupuestos Controller: Presupuesto guardado correctamente => " . $presupuesto_id, "INFO");
				echo json_encode([
					'success' => true,
					'message' => $result['message'],
					'presupuesto_id' => $presupuesto_id
				]);
				exit;
			} else {
				registrarEvento("Presupuestos Controller: Error al guardar el presupuesto => " . $presupuesto_id, "ERROR");
				echo json_encode([
					'success' => false,
					'message' => $result['message']
				]);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Presupuestos Controller: Error al procesar los datos " . $e->getMessage(), "ERROR");
			echo json_encode([
				'success' => false,
				'message' => 'Error: ' . $e->getMessage()
			]);
			exit;
		}

	}

	// ####### RENDERIZAR MERCADERÍA #######
	if (isset($_GET['renderizarMercaderia'])) {

		header('Content-Type: application/json');

		$lista_id = $_POST['lista_id'] ?? null;

		if (empty($lista_id)) {
			echo json_encode([
				'success' => false,
				'message' => 'No se recibió la lista de precios'
			]);
			exit;
		}
		try {
			$mercaderias = obtenerDetalleLista($lista_id);

			// Validar error del model
			if (isset($mercaderias['success']) && $mercaderias['success'] === false) {
				echo json_encode($mercaderias);
				exit;
			}

			// Validar sin resultados
			if (empty($mercaderias)) {
				echo json_encode([
					'success' => false,
					'message' => 'No hay mercaderías en la lista seleccionada'
				]);
				exit;
			}

			echo json_encode([
				'success' => true,
				'data' => $mercaderias
			]);
			exit;
		} catch (Exception $e) {
			registrarEvento("Presupuestos Controller: Error al procesar los datos " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
		}
	}

	// ####### SELECCIONAR MERCADERÍA #######
	if (isset($_GET['seleccionarMercaderia'])) {

		header('Content-Type: application/json');

		$mercaderia_id = $_POST['mercaderia_id'] ?? null;
		$codigo_mercaderia = $_POST['codigo_mercaderia'] ?? '';
		$descripcion_mercaderia = $_POST['descripcion_mercaderia'] ?? '';
		$precio_compra_mercaderia = $_POST['precio_compra_mercaderia'] ?? '';
		$precio_venta_mercaderia = $_POST['precio_venta_mercaderia'] ?? '';
		$presupuesto_id = $_POST['presupuesto_id'] ?? null;

		if (empty($mercaderia_id)) {
			echo json_encode(['success' => false, 'message' => 'Error: No se recibio el ID de la mercaderia']);
			exit;
		} else {
			echo json_encode([
				'success' => true,
				'mercaderia_id' => $mercaderia_id,
				'codigo_mercaderia' => $codigo_mercaderia,
				'descripcion_mercaderia' => $descripcion_mercaderia,
				'precio_compra_mercaderia' => $precio_compra_mercaderia,
				'precio_venta_mercaderia' => $precio_venta_mercaderia
			]);
			exit;
		}
	}

	// ####### SELECCIONAR X CODIGO #######
	if (isset($_GET['seleccionarCodigoMercaderia'])) {

		header('Content-Type: application/json');

		$lista_id = $_POST['lista_id'] ?? null;
		$codigo_mercaderia = $_POST['codigo_mercaderia'] ?? null;

		if (empty($codigo_mercaderia)) {
			echo json_encode(['success' => false, 'message' => 'Error: No se recibio el código de la mercaderia']);
			exit;
		} else {
			try {
					$mercaderia = obtenerMercaderiaPorCodigoEnLista($codigo_mercaderia, $lista_id);

				if ($mercaderia) {
					echo json_encode([
						'success' => true,
						'mercaderia_id' => $mercaderia['mercaderia_id'],
/* 						'codigo_mercaderia' => $mercaderia['codigo'],
						'descripcion_mercaderia' => $mercaderia['descripcion'],
						'precio_compra_mercaderia' => $mercaderia['precio_compra'], */
						'precio_venta_mercaderia' => $mercaderia['precio_venta']
					]);
					exit;
				} else {
					echo json_encode(['success' => false, 'message' => 'Mercadería no encontrada']);
					exit;
				}
			} catch (Exception $e) {
				registrarEvento("Presupuestos Controller: Error al procesar los datos " . $e->getMessage(), "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
			}
		}
	}

	// ####### AGREGAR MERCADERÍA #######
	if (isset($_GET['agregarMercaderia'])) {

		header('Content-Type: application/json');

		$datos = [
			'presupuesto_id' => $_POST['presupuesto_id'],
			'mercaderia_id' => $_POST['mercaderia_id'],
			'codigo_mercaderia' => $_POST['codigo_mercaderia'],
			'descripcion_mercaderia' => $_POST['descripcion_mercaderia'],
			'cantidad' => round((float) $_POST['cantidad']),
			'precio_compra_mercaderia' => round((float) $_POST['precio_compra_mercaderia'], 2),
			'precio_venta_mercaderia' => round((float) $_POST['precio_venta_mercaderia'], 2),
			'operador_id' => $_SESSION['operador_id'],
		];

		// Validar datos obligatorios
		if (empty($datos['codigo_mercaderia']) || empty($datos['cantidad']) || empty($datos['precio_venta_mercaderia'])) {
			echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios']);
			exit;
		}

		try {
			$result = agregarMercaderia($datos);

			if ($result) {
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
			'precio_compra_mercaderia' => $_POST['precio_compra_mercaderia'],
			'precio_venta_mercaderia' => $_POST['precio_venta_mercaderia'],
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
			} else {
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
				echo json_encode(['success' => true, 'message' => "item_id: $item_id"]);
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
	}

}

// Obtener datos para pasar a la vista
$datosVista = [
	/* 'mercaderias' => $mercaderias, */
	'listas' => $listas,
	'resumen' => $resumen,
	'ultimoPresupuestoId' => $ultimoPresupuestoId
];

// Llamar a la función común que carga todo en el layout
cargarVista('/ventas/views/egresos.presupuestos.view.php', $datosVista);
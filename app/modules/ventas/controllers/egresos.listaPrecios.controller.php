<?php
define('VISTA_INTERNA', true);

// Iniciar sesión siempre al comienzo
session_start();

unset($_SESSION['lista_id']);
unset($_SESSION['detalle_lista']);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	unset($_SESSION['mercaderia_seleccionada']);
}

require_once __DIR__ . '/../../module.controller.php';
require_once __DIR__ . '/../models/egresos.listaPrecios.model.php';
require_once __DIR__ . '/../../configuracion/models/abm.mercaderias.model.php';
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';

// Obtener resumen y detalle de recepción si hay una sesión activa
$resumen = obtenerResumenLista();

$ultimaListaId = obtenerUltimaListaId();

// Obtener procesos y mercaderías
$mercaderias = obtenerMercaderiasActivas();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// ####### CREAR LISTA DE PRECIOS #######
	if (isset($_GET['crearLista'])) {

		header('Content-Type: application/json');

		$datos = [
			'tipo' => $_POST['tipo'],
			'proveedor' => $_POST['proveedor'],
			'fecha_lista' => $_POST['fecha_lista'],
			'moneda' => $_POST['moneda'],
			'operador_id' => $_SESSION['operador_id'],
		];

		try {
			$result = crearListaPrecios($datos);
			$lista_id = $result['lista_id'];
			
			foreach ($mercaderias as $mercaderia) {
				$mercaderia_id = $mercaderia['mercaderia_id'];
				agregarMercaderiasListaPrecios($lista_id, $mercaderia_id);
			}

			if ($lista_id) {
				registrarEvento("Lista de Precios Controller: Lista creada correctamente => " . $lista_id, "INFO");
				/* header("Refresh:1"); */
				echo json_encode(['success' => true]);
				exit;
			} else {
				// Respuesta de error
				registrarEvento("Lista de Precios Controller: Error al crear la lista", "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo crear la lista']);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Lista de Precios Controller: Error al procesar los datos " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
			exit;
		}
	}

	// ####### EDITAR LISTA DE PRECIOS #######
	if (isset($_GET['editarLista'])) {

		header('Content-Type: application/json');

		$datos = [
			'lista_id' => $_POST['lista_id'],
			'tipo' => $_POST['tipo'],
			'proveedor' => $_POST['proveedor'],
			'fecha_lista' => $_POST['fecha_lista'] ?? null,
			'moneda' => $_POST['moneda'] ?? null,
		];

		if (empty($datos['lista_id'])) {
			echo json_encode(['success' => false, 'message' => 'Error: No se recibio el ID de la lista']);
			exit;
		}

		try {
			// Lógica para editar la lista de precios
			$result = editarListaPrecios($datos);

			if ($result) {
				registrarEvento("Lista de Precios Controller: Lista modificada correctamente", "INFO");
				echo json_encode(['success' => true]);
				exit;
			} else {
				// Respuesta de error
				registrarEvento("Lista de Precios Controller: Error al modificar la lista", "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo modificar la lista']);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Lista de Precios Controller: Error al procesar los datos " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Controller: Error: ' . $e->getMessage()]);
			exit;
		}
	}

	// ####### ELIMINAR LISTA DE PRECIOS #######
	if (isset($_GET['eliminarLista'])) {

		header('Content-Type: application/json');

		$operador_id = $_SESSION['operador_id'];
		$resumen = obtenerResumenLista();
		$lista_id = $_POST['lista_id'];

		// Validar si hay mercaderías cargadas
		if (empty($resumen)) {
			echo json_encode([
				'success' => false,
				'message' => 'Aún no se ingresaron mercaderías'
			]);
			exit;
		}

		try {
			$result = eliminarListaPrecios($lista_id);

			if ($result['success']) {
				registrarEvento("Lista de Precios Controller: Lista eliminada correctamente => " . $lista_id, "INFO");
				echo json_encode(['success' => true, 'message' => $result['message']]);
				exit;
			} else {
				registrarEvento("Lista de Precios Controller: Error al eliminar la lista => " . $lista_id, "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo eliminar la lista']);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Lista de Precios Controller: Error al procesar los datos " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
		}
	}

	// ####### VER LISTA DE PRECIOS #######
	if (isset($_GET['verLista'])) {
		header('Content-Type: application/json');

		$lista_id = $_POST['lista_id'];

		if (empty($lista_id)) {
			echo json_encode(['success' => false, 'message' => 'Error: No se recibió el ID de la lista']);
			exit;
		}

		try {

			// Obtener el detalle desde el modelo
			$detalle = obtenerDetalleLista($lista_id);

			// Renderizar el fragmento HTML usando la vista
			ob_start();
			include __DIR__ . "/../views/egresos.listaPrecios.detalle.view.php";
			$html = ob_get_clean();

			echo json_encode([
				'success' => true,
				'html' => $html
			]);

			exit;

		} catch (Exception $e) {
			registrarEvento("Error al obtener detalle: " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
			exit;
		}
	}

}

// Obtener datos para pasar a la vista
$datosVista = [
	'resumen' => $resumen,
	'ultimaListaId' => $ultimaListaId
];

// Llamar a la función común que carga todo en el layout
cargarVista('/ventas/views/egresos.listaPrecios.view.php', $datosVista);
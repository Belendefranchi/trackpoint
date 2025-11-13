<?php
define('VISTA_INTERNA', true);

require_once __DIR__ . '/../../module.controller.php';
require_once __DIR__ . '/../models/abm.mercaderias.model.php';
require_once __DIR__ . '/../models/abm.grupos.model.php';
require_once __DIR__ . '/../models/abm.subgrupos.model.php';
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';

// Lógica ajax de actualizar, eliminar y crear Operadores
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// ####### CREAR #######
	if (isset($_GET['crear'])) {
		
		header('Content-Type: application/json');

		$datos = [
			'codigo' => $_POST['codigo'],
			'descripcion' => $_POST['descripcion'],
			'unidad_medida' => $_POST['unidad_medida'],
			'grupo_id' => $_POST['grupo_id'] ?? null,
			'subgrupo_id' => $_POST['subgrupo_id'] ?? null,
			'envase_pri' => $_POST['envase_pri'] ?? null,
			'envase_sec' => $_POST['envase_sec'] ?? null,
			'marca' => $_POST['marca'] ?? null,
			'codigo_externo' => $_POST['codigo_externo'] ?? null,
			'cantidad_propuesta' => floatval($_POST['cantidad_propuesta']) ?? null,
			'peso_propuesto' => floatval($_POST['peso_propuesto']) ?? null,
			'peso_min' => floatval($_POST['peso_min']) ?? null,
			'peso_max' => floatval($_POST['peso_max']) ?? null,
			'precio_compra' => floatval($_POST['precio_compra']) ?? null,
			'precio_venta' => floatval($_POST['precio_venta']) ?? null,
			'etiqueta_sec' => $_POST['etiqueta_sec'] ?? null,
		];

    // Validación básica
    if (empty($datos['codigo']) || empty($datos['descripcion']) || empty($datos['unidad_medida'])) {
			echo json_encode(['success' => false, 'message' => 'Error: Por favor ingrese todos los datos']);
			exit;
		}

		// Verificar si la mercaderia ya existe
		$mercaderia = mercaderiaExists($datos['codigo']);
		if ($mercaderia) {
			echo json_encode(['success' => false, 'message' => 'Error: Ya existe una mercadería con ese código, intente con otro.']);
			exit;
		}
		try {

			$result = crearMercaderia($datos);

			if ($result) {
				registrarEvento("Mercaderías Controller: Mercadería creada correctamente => " . $datos['codigo'], "INFO");
				echo json_encode(['success' => true]);
				exit;
			} else {
				// Respuesta de error
				registrarEvento("Mercaderías Controller: Error al crear la mercadería => " . $datos['codigo'], "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo crear la mercadería']);
				exit;
			}
			echo json_encode(['success' => true]);
		} catch (Exception $e) {
			registrarEvento("Mercaderías Controller: Error al procesar los datos => " . $datos['codigo'], "ERROR");
			echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}

	// ####### EDITAR #######
	if (isset($_GET['editar'])) {

    header('Content-Type: application/json');

		$datos = [
			'mercaderia_id' => $_POST['mercaderia_id'],
			'codigo' => $_POST['codigo'],
			'descripcion' => $_POST['descripcion'],
			'unidad_medida' => $_POST['unidad_medida'],
			'grupo_id' => $_POST['grupo_id'] ?? null,
			'subgrupo_id' => $_POST['subgrupo_id'] ?? null,
			'envase_pri' => $_POST['envase_pri'] ?? null,
			'envase_sec' => $_POST['envase_sec'] ?? null,
			'marca' => $_POST['marca'] ?? null,
			'codigo_externo' => $_POST['codigo_externo'] ?? null,
			'cantidad_propuesta' => floatval($_POST['cantidad_propuesta']) ?? null,
			'peso_propuesto' => floatval($_POST['peso_propuesto']) ?? null,
			'peso_min' => floatval($_POST['peso_min']) ?? null,
			'peso_max' => floatval($_POST['peso_max']) ?? null,
			'precio_compra' => floatval($_POST['precio_compra']) ?? null,
			'precio_venta' => floatval($_POST['precio_venta']) ?? null,
			'etiqueta_sec' => $_POST['etiqueta_sec'] ?? null,
			'activo' => $_POST['activo'],
		];

		// Validación básica
		if (empty($datos['codigo']) || empty($datos['descripcion'])) {
			echo json_encode(['success' => false, 'message' => 'Error: Por favor ingrese todos los datos']);
			exit;
		}

		// Verificar si el usuario ya existe
		$mercaderia = mercaderiaExists($datos['codigo']);
		if ($mercaderia && $mercaderia['mercaderia_id'] != $datos['mercaderia_id']) {
			echo json_encode(['success' => false, 'message' => 'Error: Ya existe una mercadería con ese código, intente con otro.']);
			exit;
		}
		try {
			// Llamar a la función que actualiza los datos
			$result = editarMercaderia($datos);

			if ($result) {
				// Respuesta de éxito
				registrarEvento("Mercaderías Controller: Mercadería modificada correctamente => " . $datos['codigo'], "INFO");
				echo json_encode(['success' => true]);
				exit;
			} else {
				// Respuesta de error
				registrarEvento("Mercaderías Controller: Error al modificar la mercadería => " . $datos['codigo'], "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo modificar la mercadería']);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Mercaderías Controller: Error al procesar los datos => " . $datos['codigo'], "ERROR");
			echo json_encode(['success' => false, 'message' => 'Controller: Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}

	// ####### ELIMINAR #######
	if (isset($_GET['eliminar'])) {

		header('Content-Type: application/json');

		$mercaderia_id = $_POST['mercaderia_id'];
		/* $codigo = $_POST['codigo']; */

		try {
			// Llamar a la función que actualiza los datos
			$result = eliminarMercaderia($mercaderia_id);

			if ($result) {
				// Respuesta de éxito
				registrarEvento("Mercaderías Controller: Mercadería eliminada correctamente => " . $mercaderia_id, "INFO");
				echo json_encode(['success' => true]);
				exit;

			} else {
					// Respuesta de error
					registrarEvento("Mercaderías Controller: Error al eliminar la mercadería => " . $mercaderia_id, "ERROR");
					echo json_encode(['success' => false, 'message' => 'Error: No se pudo eliminar la mercadería']);
					exit;
			}
		} catch (Exception $e) {
			registrarEvento("Mercaderías Controller: Error al procesar los datos => " . $mercaderia_id, "ERROR");
			echo json_encode(['success' => false, 'message' => 'Controller: Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}

	// ####### CARGAR SUBGRUPOS #######
	if (isset($_GET['cargar_subgrupos'])) {

		header('Content-Type: application/json');

		$grupo_id = $_POST['grupo_id'];

		try {
			$subgrupos = obtenerSubgruposActivosPorGrupoId($grupo_id);
			echo json_encode(['success' => true, 'data' => $subgrupos]);
			exit;
		} catch (Exception $e) {
			registrarEvento("Mercaderías Controller: Error al cargar los subgrupos => " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Controller: Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}
}

// Obtener datos para pasar a la vista
$mercaderias = obtenerMercaderias();
$grupos = obtenerGruposActivos();

// Llamar a la función común que carga todo en el layou
$datosVista = [
  'mercaderias' => $mercaderias,
	'grupos' => $grupos
];

cargarVista('/configuracion/views/abm.mercaderias.view.php', $datosVista);
<?php
define('VISTA_INTERNA', true);

require_once __DIR__ . '/produccion.controller.php';
require_once __DIR__ . '/../models/abm.mercaderias.model.php';
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';

// Lógica ajax de actualizar, eliminar y crear Operadores
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// ####### CREAR #######
	if (isset($_GET['crear'])) {
		
		header('Content-Type: application/json');

		$codigo = $_POST['codigo'];
		$descripcion = $_POST['descripcion'];
		$unidad_medida = $_POST['unidad_medida'];
		$grupo = $_POST['grupo'] ? $_POST['grupo'] : null;
		$subgrupo = $_POST['subgrupo'] ? $_POST['subgrupo'] : null;
		$envase_pri = $_POST['envase_pri'] ? $_POST['envase_pri'] : null;
		$envase_sec = $_POST['envase_sec'] ? $_POST['envase_sec'] : null;
		$marca = $_POST['marca'] ? $_POST['marca'] : null;
		$cantidad_propuesta = floatval($_POST['cantidad_propuesta']);
		$peso_propuesto = floatval($_POST['peso_propuesto']);
		$peso_min = floatval($_POST['peso_min']);
		$peso_max = floatval($_POST['peso_max']);
		$etiqueta_sec = $_POST['etiqueta_sec'] ? $_POST['etiqueta_sec'] : null;

    // Validación básica
    if (empty($codigo) || empty($descripcion) || empty($unidad_medida)) {
			echo json_encode(['success' => false, 'message' => 'Error: Por favor ingrese todos los datos']);
			exit;
		}

		// Verificar si la mercaderia ya existe
		$mercaderia = mercaderiaExists($codigo);
		if ($mercaderia) {
			echo json_encode(['success' => false, 'message' => 'Error: Ya existe una mercadería con ese código, intente con otro.']);
			exit;
		}
		try {

			$result = crearMercaderia($codigo, $descripcion, $unidad_medida, $grupo, $subgrupo, $envase_pri, $envase_sec, $marca, $cantidad_propuesta, $peso_propuesto, $peso_min, $peso_max, $etiqueta_sec);

			if ($result) {
				registrarEvento("Mercaderías Controller: Mercadería creada correctamente => " . $codigo, "INFO");
				echo json_encode(['success' => true]);
				exit;
			} else {
				// Respuesta de error
				registrarEvento("Mercaderías Controller: Error al crear la mercadería => " . $codigo, "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo crear la mercadería']);
				exit;
			}
			echo json_encode(['success' => true]);
		} catch (Exception $e) {
			registrarEvento("Mercaderías Controller: Error al procesar los datos => " . $codigo, "ERROR");
			echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}

	// ####### EDITAR #######
	if (isset($_GET['editar'])) {

    header('Content-Type: application/json');

		$mercaderia_id = $_POST['mercaderia_id'];
		$codigo = $_POST['codigo'];
		$descripcion = $_POST['descripcion'];
		$unidad_medida = $_POST['unidad_medida'];
		$grupo = $_POST['grupo'] ? $_POST['grupo'] : null;
		$subgrupo = $_POST['subgrupo'] ? $_POST['subgrupo'] : null;
		$envase_pri = $_POST['envase_pri'] ? $_POST['envase_pri'] : null;
		$envase_sec = $_POST['envase_sec'] ? $_POST['envase_sec'] : null;
		$marca = $_POST['marca'] ? $_POST['marca'] : null;
		$cantidad_propuesta = floatval($_POST['cantidad_propuesta']);
		$peso_propuesto = floatval($_POST['peso_propuesto']);
		$peso_min = floatval($_POST['peso_min']);
		$peso_max = floatval($_POST['peso_max']);
		$etiqueta_sec = $_POST['etiqueta_sec'] ? $_POST['etiqueta_sec'] : null;
		$activo = $_POST['activo'];

		// Validación básica
		if (empty($codigo) || empty($descripcion)) {
			echo json_encode(['success' => false, 'message' => 'Error: Por favor ingrese todos los datos']);
			exit;
		}

		// Verificar si el usuario ya existe
		$mercaderia = mercaderiaExists($codigo);
		if ($mercaderia && $mercaderia['mercaderia_id'] != $mercaderia_id) {
			echo json_encode(['success' => false, 'message' => 'Error: Ya existe una mercadería con ese código, intente con otro.']);
			exit;
		}
		try {
			// Llamar a la función que actualiza los datos
			$result = editarMercaderia($mercaderia_id, $codigo, $descripcion, $unidad_medida, $grupo, $subgrupo, $envase_pri, $envase_sec, $marca, $cantidad_propuesta, $peso_propuesto, $peso_min, $peso_max, $etiqueta_sec, $activo);

			if ($result) {
				// Respuesta de éxito
				registrarEvento("Mercaderías Controller: Mercadería modificada correctamente => " . $codigo, "INFO");
				echo json_encode(['success' => true]);
				exit;
			} else {
				// Respuesta de error
				registrarEvento("Mercaderías Controller: Error al modificar la mercadería => " . $codigo, "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo modificar la mercadería']);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Mercaderías Controller: Error al procesar los datos => " . $codigo, "ERROR");
			echo json_encode(['success' => false, 'message' => 'Controller: Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}

	// ####### ELIMINAR #######

	if (isset($_GET['eliminar'])) {

		header('Content-Type: application/json');

		$mercaderia_id = $_POST['mercaderia_id'];
		$codigo = $_POST['codigo'];

		try {
			// Llamar a la función que actualiza los datos
			$result = eliminarMercaderia($mercaderia_id, $codigo);

			if ($result) {
				// Respuesta de éxito
				registrarEvento("Mercaderías Controller: Mercadería eliminada correctamente => " . $codigo, "INFO");
				echo json_encode(['success' => true]);
				exit;

			} else {
					// Respuesta de error
					registrarEvento("Mercaderías Controller: Error al eliminar la mercadería => " . $codigo, "ERROR");
					echo json_encode(['success' => false, 'message' => 'Error: No se pudo eliminar la mercadería']);
					exit;
			}
		} catch (Exception $e) {
			registrarEvento("Mercaderías Controller: Error al procesar los datos => " . $codigo, "ERROR");
			echo json_encode(['success' => false, 'message' => 'Controller: Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}
}


// Obtener datos para pasar a la vista
$mercaderias = obtenerMercaderias();

// Llamar a la función común que carga todo en el layout
$datosVista = [
  'mercaderias' => $mercaderias
];

cargarVistaProduccion('abm.mercaderias.view.php', $datosVista);
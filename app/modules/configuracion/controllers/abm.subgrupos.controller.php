<?php
define('VISTA_INTERNA', true);

require_once __DIR__ . '/configuracion.controller.php';
require_once __DIR__ . '/../models/abm.subgrupos.model.php';
require_once __DIR__ . '/../models/abm.grupos.model.php';
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';

// Lógica ajax de actualizar, eliminar y crear Subgrupo
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// ####### CREAR #######
	if (isset($_GET['crear'])) {
		
		header('Content-Type: application/json');

		$codigo = $_POST['codigo'];
		$descripcion = $_POST['descripcion'];
		$grupo_id = $_POST['grupo_id'];

    // Validación básica
    if (empty($codigo) || empty($descripcion) || empty($grupo_id)) {
			echo json_encode(['success' => false, 'message' => 'Error: Por favor ingrese todos los datos']);
			exit;
		}

		// Verificar si el subgrupo ya existe
		$subgrupo = subgrupoExists($codigo);
		if ($subgrupo) {
			echo json_encode(['success' => false, 'message' => 'Error: Ya existe un subgrupo con ese código, intente con otro.']);
			exit;
		}
		try {

			// Crear el subgrupo en la base de datos
			$result = crearSubgrupo($codigo, $descripcion, $grupo_id);

			if ($result) {
				registrarEvento("Subgrupos Controller: Subgrupo creado correctamente => " . $codigo, "INFO");
				echo json_encode(['success' => true]);
				exit;
			} else {
				// Respuesta de error
				registrarEvento("Subgrupos Controller: Error al crear el Subgrupo => " . $codigo, "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo crear el Subgrupo']);
				exit;
			}
			echo json_encode(['success' => true]);
		} catch (Exception $e) {
			registrarEvento("Subgrupos Controller: Error al procesar los datos => " . $grupo_id . " " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}

	// ####### EDITAR #######
	if (isset($_GET['editar'])) {

    header('Content-Type: application/json');

		$subgrupo_id = $_POST['subgrupo_id'];
		$codigo = $_POST['codigo'];
		$descripcion = $_POST['descripcion'];
		$grupo_id = $_POST['grupo_id'];
		$activo = $_POST['activo'];

		// Validación básica
		if (empty($grupo_id) || empty($codigo) || empty($descripcion)) {
			echo json_encode(['success' => false, 'message' => 'Error: Por favor ingrese todos los datos']);
			exit;
		}

		// Verificar si el subgrupo ya existe
		$subgrupo = subgrupoExists($codigo);
		if ($subgrupo && $subgrupo['subgrupo_id'] != $subgrupo_id) {
			echo json_encode(['success' => false, 'message' => 'Error: Ya existe un subgrupo con ese código, intente con otro.']);
			exit;
		}
		try {
			// Llamar a la función que actualiza los datos
			$result = editarSubgrupo($subgrupo_id, $codigo, $descripcion, $grupo_id, $activo);

			if ($result) {
				// Respuesta de éxito
				registrarEvento("Subgrupos Controller: Subgrupo modificado correctamente => " . $subgrupo_id, "INFO");
				echo json_encode(['success' => true]);
				exit;
			} else {
				// Respuesta de error
				registrarEvento("Subgrupos Controller: Error al modificar el Subgrupo => " . $subgrupo_id, "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo modificar el Subgrupo']);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Subgrupos Controller: Error al procesar los datos => " . $subgrupo_id . " " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Controller: Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}

	// ####### ELIMINAR #######
	if (isset($_GET['eliminar'])) {

		header('Content-Type: application/json');

		$subgrupo_id = $_POST['subgrupo_id'];
		$codigo = $_POST['codigo'];

		try {
			// Llamar a la función que actualiza los datos
			$result = eliminarSubgrupo($subgrupo_id, $codigo);

			if ($result) {
				// Respuesta de éxito
				registrarEvento("Subgrupos Controller: Subgrupo eliminado correctamente => " . $subgrupo_id, "INFO");
				echo json_encode(['success' => true]);
				exit;

			} else {
					// Respuesta de error
					registrarEvento("Subgrupos Controller: Error al eliminar el Subgrupo => " . $subgrupo_id, "ERROR");
					echo json_encode(['success' => false, 'message' => 'Error: No se pudo eliminar el Subgrupo']);
					exit;
			}
		} catch (Exception $e) {
			registrarEvento("Subgrupos Controller: Error al procesar los datos => " . $subgrupo_id . " " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Controller: Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}
}


// Obtener datos para pasar a la vista
$subgrupos = obtenerSubgrupos();
$grupos = obtenerGrupos();

// Llamar a la función común que carga todo en el layout
$datosVista = [
  'subgrupos' => $subgrupos,
  'grupos' => $grupos
];

cargarVistaConfiguracion('abm.subgrupos.view.php', $datosVista);



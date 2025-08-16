<?php
define('VISTA_INTERNA', true);

require_once __DIR__ . '/configuracion.controller.php';
require_once __DIR__ . '/../models/abm.grupos.model.php';
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';

// Lógica ajax de actualizar, eliminar y crear Grupo
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// ####### CREAR #######
	if (isset($_GET['crear'])) {
		
		header('Content-Type: application/json');

		$codigo = $_POST['codigo'];
		$descripcion = $_POST['descripcion'];

    // Validación básica
    if (empty($codigo) || empty($descripcion)) {
			echo json_encode(['success' => false, 'message' => 'Error: Por favor ingrese todos los datos']);
			exit;
		}

		// Verificar si el grupo ya existe
		$grupo = grupoExists($codigo);
		if ($grupo) {
			echo json_encode(['success' => false, 'message' => 'Error: Ya existe un grupo con ese código, intente con otro.']);
			exit;
		}
		try {
			// Crear el grupo en la base de datos
			$result = crearGrupo($codigo, $descripcion);

			if ($result) {
				registrarEvento("Grupos Controller: Grupo creado correctamente => " . $codigo, "INFO");
				echo json_encode(['success' => true]);
				exit;
			} else {
				// Respuesta de error
				registrarEvento("Grupos Controller: Error al crear el Grupo => " . $codigo, "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo crear el Grupo']);
				exit;
			}
			echo json_encode(['success' => true]);
		} catch (Exception $e) {
			registrarEvento("Grupos Controller: Error al procesar los datos => " . $grupo_id . " " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}

	// ####### EDITAR #######
	if (isset($_GET['editar'])) {

    header('Content-Type: application/json');

		$grupo_id = $_POST['grupo_id'];
		$codigo = $_POST['codigo'];
		$descripcion = $_POST['descripcion'];
		$activo = $_POST['activo'];

		// Validación básica
		if (empty($grupo_id) || empty($codigo) || empty($descripcion)) {
			echo json_encode(['success' => false, 'message' => 'Error: Por favor ingrese todos los datos']);
			exit;
		}

		// Verificar si el grupo ya existe
		$grupo = grupoExists($codigo);
		if ($grupo && $grupo['grupo_id'] != $grupo_id) {
			echo json_encode(['success' => false, 'message' => 'Error: Ya existe un Grupo con ese código, intente con otro.']);
			exit;
		}
		try {
			// Llamar a la función que actualiza los datos
			$result = editarGrupo($grupo_id, $codigo, $descripcion, $activo);

			if ($result) {
				// Respuesta de éxito
				registrarEvento("Grupos Controller: Grupo modificado correctamente => " . $grupo_id, "INFO");
				echo json_encode(['success' => true]);
				exit;
			} else {
				// Respuesta de error
				registrarEvento("Grupos Controller: Error al modificar el Grupo => " . $grupo_id, "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo modificar el Grupo']);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Grupos Controller: Error al procesar los datos => " . $grupo_id . " " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Controller: Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}

	// ####### ELIMINAR #######
	if (isset($_GET['eliminar'])) {

		header('Content-Type: application/json');

		$grupo_id = $_POST['grupo_id'];
		$codigo = $_POST['codigo'];

		try {
			// Llamar a la función que actualiza los datos
			$result = eliminarGrupo($grupo_id, $codigo);

			if ($result) {
				// Respuesta de éxito
				registrarEvento("Grupos Controller: Grupo eliminado correctamente => " . $grupo_id, "INFO");
				echo json_encode(['success' => true]);
				exit;

			} else {
					// Respuesta de error
					registrarEvento("Grupos Controller: Error al eliminar el Grupo => " . $grupo_id . " " . $e->getMessage(), "ERROR");
					echo json_encode(['success' => false, 'message' => 'Error: No se pudo eliminar el Grupo']);
					exit;
			}
		} catch (Exception $e) {
			registrarEvento("Grupos Controller: Error al procesar los datos => " . $grupo_id . " " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Controller: Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}
}


// Obtener datos para pasar a la vista
$grupos = obtenerGrupos();

// Llamar a la función común que carga todo en el layout
$datosVista = [
  'grupos' => $grupos
];

cargarVistaConfiguracion('abm.grupos.view.php', $datosVista);



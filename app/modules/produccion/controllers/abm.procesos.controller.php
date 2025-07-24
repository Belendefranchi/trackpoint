<?php
define('VISTA_INTERNA', true);

require_once __DIR__ . '/produccion.controller.php';
require_once __DIR__ . '/../models/abm.procesos.model.php';
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';

// Lógica ajax de actualizar, eliminar y crear Operadores
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

		// Verificar si el proceso ya existe
		$proceso = procesoExists($codigo);
		if ($proceso) {
			echo json_encode(['success' => false, 'message' => 'Error: Ya existe un proceso con ese código, intente con otro.']);
			exit;
		}
		try {
			
			$result = crearproceso($codigo, $descripcion);

			if ($result) {
				registrarEvento("Procesos Controller: Proceso creada correctamente => " . $codigo, "INFO");
				echo json_encode(['success' => true]);
				exit;
			} else {
				// Respuesta de error
				registrarEvento("Procesos Controller: Error al crear el proceso => " . $codigo, "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo crear el proceso']);
				exit;
			}
			echo json_encode(['success' => true]);
		} catch (Exception $e) {
			registrarEvento("Procesos Controller: Error al procesar los datos => " . $codigo, "ERROR");
			echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}

	// ####### EDITAR #######
	if (isset($_GET['editar'])) {

    header('Content-Type: application/json');

		$proceso_id = $_POST['proceso_id'];
		$codigo = $_POST['codigo'];
		$descripcion = $_POST['descripcion'];
		$activo = $_POST['activo'];

		// Validación básica
		if (empty($codigo) || empty($descripcion)) {
			echo json_encode(['success' => false, 'message' => 'Error: Por favor ingrese todos los datos']);
			exit;
		}

		// Verificar si el usuario ya existe
		$proceso = procesoExists($codigo);
		if ($proceso) {
			echo json_encode(['success' => false, 'message' => 'Error: Ya existe un proceso con ese código, intente con otro.']);
			exit;
		}
		try {
			// Llamar a la función que actualiza los datos
			$result = editarproceso($proceso_id, $descripcion, $activo);

			if ($result) {
				// Respuesta de éxito
				registrarEvento("Procesos Controller: Proceso modificado correctamente => " . $codigo, "INFO");
				echo json_encode(['success' => true]);
				exit;
			} else {
				// Respuesta de error
				registrarEvento("Procesos Controller: Error al modificar el proceso => " . $codigo, "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo modificar el proceso']);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Procesos Controller: Error al procesar los datos => " . $codigo, "ERROR");
			echo json_encode(['success' => false, 'message' => 'Controller: Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}

	// ####### ELIMINAR #######

	if (isset($_GET['eliminar'])) {

		header('Content-Type: application/json');

		$proceso_id = $_POST['proceso_id'];
		$codigo = $_POST['codigo'];

		try {
			// Llamar a la función que actualiza los datos
			$result = eliminarproceso($proceso_id, $codigo);

			if ($result) {
				// Respuesta de éxito
				registrarEvento("Procesos Controller: Proceso eliminado correctamente => " . $codigo, "INFO");
				echo json_encode(['success' => true]);
				exit;

			} else {
					// Respuesta de error
					registrarEvento("Procesos Controller: Error al eliminar el proceso => " . $codigo, "ERROR");
					echo json_encode(['success' => false, 'message' => 'Error: No se pudo eliminar el proceso']);
					exit;
			}
		} catch (Exception $e) {
			registrarEvento("Procesos Controller: Error al procesar los datos => " . $codigo, "ERROR");
			echo json_encode(['success' => false, 'message' => 'Controller: Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}
}


// Obtener datos para pasar a la vista
$procesos = obtenerProcesos();

// Llamar a la función común que carga todo en el layout
$datosVista = [
  'procesos' => $procesos
];

cargarVistaProduccion('abm.procesos.view.php', $datosVista);



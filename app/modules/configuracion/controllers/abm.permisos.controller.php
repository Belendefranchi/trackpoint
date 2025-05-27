<?php
define('VISTA_INTERNA', true);

require_once __DIR__ . '/configuracion.controller.php';
require_once __DIR__ . '/../models/abm.permisos.model.php';
require_once __DIR__ . '/../../../../core/config/helpers.php';

// Lógica ajax de actualizar, eliminar y crear permisos
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// ####### CREAR #######
	if (isset($_GET['crear'])) {

		header('Content-Type: application/json');

		$nombre = $_POST['nombre'];
		$descripcion = $_POST['descripcion'];
		$pantalla = $_POST['pantalla'];

		// Validación básica
		if (empty($nombre) || empty($descripcion) || empty($pantalla)) {
			echo json_encode(['success' => false, 'message' => 'Error: Por favor ingrese todos los datos']);
			exit;
		}

		// Verificar si el permiso ya existe
		$permiso = permisoExists($nombre);
		if ($permiso) {
				echo json_encode(['success' => false, 'message' => 'Error: Ya existe un permiso con ese nombre, intente con otro.']);
				exit;
		}
		try {
			// Crear el permiso en la base de datos
			$result = crearPermiso($nombre, $descripcion, $pantalla);

			if ($result) {
				registrarEvento("Permisos Controller: Permiso creado correctamente => " . $nombre, "INFO");
				echo json_encode(['success' => true]);
				exit;
			} else {
				// Respuesta de error
				registrarEvento("Permisos Controller: Error al crear el permiso => " . $nombre, "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo crear el permiso']);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Permisos Controller: Error al procesar los datos => " . $nombre, "ERROR");
			echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}


	// ####### EDITAR #######
	if (isset($_GET['editar'])) {

		header('Content-Type: application/json');

		$permiso_id = $_POST['permiso_id'];
		$nombre = $_POST['nombre'];
		$descripcion = $_POST['descripcion'];
		$pantalla = $_POST['pantalla'];

		// Validación básica
		if (empty($nombre) || empty($descripcion) || empty($pantalla)) {
			echo json_encode(['success' => false, 'message' => 'Error: Por favor ingrese todos los datos']);
			exit;
		}

		// Verificar si el permiso ya existe
		$permiso = permisoExists($nombre); 
		if ($permiso && $permiso['permiso_id'] != $permiso_id) {
				echo json_encode(['success' => false, 'message' => 'Error: Ya existe un permiso con ese nombre, intente con otro.']);
				exit;
		}
		try {
			// Llamar a la función que actualiza los datos
			$result = editarPermiso($permiso_id, $nombre, $descripcion, $pantalla);

			if ($result) {
				// Respuesta de éxito
				registrarEvento("Permisos Controller: Permiso modificado correctamente => " . $nombre, "INFO");
				echo json_encode(['success' => true]);
				exit;
			} else {
				// Respuesta de error
				registrarEvento("Permisos Controller: Error al modificar el permiso => " . $nombre, "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo modificar el permiso']);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Permisos Controller: Error al procesar los datos => " . $nombre, "ERROR");
			echo json_encode(['success' => false, 'message' => 'Controller: Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}


	// ####### ELIMINAR #######
	if (isset($_GET['eliminar'])) {

		header('Content-Type: application/json');

		$permiso_id = $_POST['permiso_id'];
		$nombre = $_POST['nombre'];

		try {
			// Llamar a la función que actualiza los datos
			$result = eliminarPermiso($permiso_id, $nombre);

			if ($result) {
				// Respuesta de éxito
				registrarEvento("Permisos Controller: Permiso eliminado correctamente => " . $nombre, "INFO");
				echo json_encode(['success' => true]);
				exit;

			} else {
				// Respuesta de error
				registrarEvento("Permisos Controller: Error al eliminar el permiso => " . $nombre, "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo eliminar el permiso']);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Permisos Controller: Error al procesar los datos => " . $nombre, "ERROR");
			echo json_encode(['success' => false, 'message' => 'Controller: Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}
}

// Obtener datos para pasar a la vista
$permisos = obtenerPermisos();

// Llamar a la función común que carga todo en el layout
$datosVista = [
	'permisos' => $permisos
];

cargarVistaConfiguracion('abm.permisos.view.php', $datosVista);
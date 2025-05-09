<?php
define('VISTA_INTERNA', true);

require_once __DIR__ . '/configuracion.controller.php';
require_once __DIR__ . '/../models/abm.perfiles.model.php';
require_once __DIR__ . '/../../../../config/helpers.php';

// Lógica ajax de actualizar, eliminar y crear perfiles
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// ####### CREAR #######
	if (isset($_GET['crear'])) {

    header('Content-Type: application/json');

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    // Validación básica
    if (empty($nombre) || empty($descripcion)) {
			echo json_encode(['success' => false, 'message' => 'Error: Por favor ingrese todos los datos']);
			exit;
		}

		// Verificar si el perfil ya existe
		$perfil = perfilExists($nombre);
		if ($perfil) {
				echo json_encode(['success' => false, 'message' => 'Error: Ya existe un perfil con ese nombre, intente con otro.']);
				exit;
		}
		try {
			// Crear el perfil en la base de datos
			$result = crearPerfil($nombre, $descripcion);

			if ($result) {
				echo json_encode(['success' => true, 'message' => 'Perfil guardado correctamente']);
				registrarEvento("Perfiles Controller: Perfil creado correctamente => " . $nombre, "INFO");
			} else {
				// Respuesta de error
				echo json_encode(['success' => false, 'message' => 'Error al crear el perfil']);
				registrarEvento("Perfiles Controller: Error al crear el perfil => " . $nombre, "ERROR");
			}
		} catch (Exception $e) {
			echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
			registrarEvento("Perfiles Controller: Error al crear el perfil => " . $nombre, "ERROR");
		}
		exit;
	}


	// ####### EDITAR #######
	if (isset($_GET['editar'])) {

    header('Content-Type: application/json');

		$perfil_id = $_POST['perfil_id'];
		$nombre = $_POST['nombre'];
		$descripcion = $_POST['descripcion'];
		$activo = ($_POST['activo']);

    // Validación básica
    if (empty($nombre) || empty($descripcion)) {
			echo json_encode(['success' => false, 'message' => 'Por favor ingrese todos los datos']);
			exit;
		}

		// Verificar si el perfil ya existe
		$perfil = perfilExists($nombre);
		if ($perfil) {
				echo json_encode(['success' => false, 'message' => 'Ya existe un perfil con ese nombre, intente con otro.']);
				exit;
		}
		try {
			// Llamar a la función que actualiza los datos
			$result = editarPerfil($perfil_id, $nombre, $descripcion, $activo);

			if ($result) {
				// Respuesta de éxito
				echo json_encode(['success' => true, 'message' => 'Controller: Perfil modificado con éxito']);
				registrarEvento("Perfiles Controller: Perfil creado correctamente => " . $nombre, "INFO");

			} else {
					// Respuesta de error
					echo json_encode(['success' => false, 'message' => 'Controller: Error al modificar el perfil']);
					registrarEvento("Perfiles Controller: Error al modificar el perfil => " . $nombre, "ERROR");
			}
		} catch (Exception $e) {
			echo json_encode(['success' => false, 'message' => 'Controller: Error: ' . $e->getMessage()]);
			registrarEvento("Perfiles Controller: Error al modificar el perfil => " . $nombre, "ERROR");
		}
		exit;
	}
}

// Obtener datos para pasar a la vista
$perfiles = obtenerPerfiles();

// Llamar a la función común que carga todo en el layout
$datosVista = [
  'perfiles' => $perfiles
];

if (isset($_SESSION['message'])) {
  $datosVista['message'] = $_SESSION['message'];
	unset($_SESSION['message']);
}

cargarVistaConfiguracion('abm.perfiles.view.php', $datosVista);



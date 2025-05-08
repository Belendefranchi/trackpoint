<?php
define('VISTA_INTERNA', true);
require_once __DIR__ . '/configuracion.controller.php';
require_once __DIR__ . '/../models/abm.perfiles.model.php';
require_once __DIR__ . '/../../../../config/helpers.php';

// Lógica ajax de actualizar, eliminar y crear perfiles
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	/* var_dump($_POST); */
	exit;
	// ####### EDITAR #######
	if (isset($_GET['editar'])) {
		$perfil_id = $_POST['perfil_id'];
		$nombre = $_POST['nombre'];
		$descripcion = $_POST['descripcion'];
		$activo = ($_POST['activo']);

		if (empty($nombre) && empty($descripcion)) {
			$_SESSION['message'] = "Por favor ingrese todos los datos";
		} elseif (empty($nombre)) {
			$_SESSION['message'] = "Por favor ingrese el nombre";
		} elseif (empty($descripcion)) {
			$_SESSION['message'] = "Por favor ingrese la descripción";
		} elseif ($nombre && $descripcion) {

			// Verificar si el perfil ya existe
			$perfil = perfilExists($nombre);
			if ($perfil && $perfil['nombre'] != $nombre) {
				$_SESSION['message'] = "Ya hay un perfil registrado con ese nombre, por favor intente con otro.";
			} else {
				// Llamar a la función que actualiza los datos
				editarPerfil($perfil_id, $nombre, $descripcion, $activo);
				registrarEvento("Perfiles Controller: Perfil editado correctamente => " . $nombre, "INFO");

				// Redirigimos para evitar reenvío del formulario
				header('Location: index.php?route=/configuracion/ABMs/perfiles');
				exit;
			}
		}

	// ####### ELIMINAR #######
	} elseif (isset($_GET['eliminar'])) {
		$perfil_id = $_POST['perfil_id'];
		$nombre = $_POST['nombre'];

		// Llamar a la función que elimina el perfil
		eliminarPerfil($perfil_id);

		registrarEvento("Perfiles Controller: Perfil eliminado correctamente => " . $nombre, "INFO");

		// Redirigimos para evitar reenvío del formulario
		header('Location: index.php?route=/configuracion/ABMs/perfiles');
		exit;

	// ####### CREAR #######
	} elseif (isset($_GET['crear'])) {

    header('Content-Type: application/json');

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    // Validación básica
    if (empty($nombre) || empty($descripcion)) {
			echo json_encode(['success' => false, 'message' => 'Todos los campos son requeridos']);
			exit;
		}

		// Verificar si el perfil ya existe
		$perfil = perfilExists($nombre);
		if ($perfil) {
				echo json_encode(['success' => false, 'message' => 'Ya existe un perfil con ese nombre']);
				exit;
		}

		// Crear el perfil en la base de datos
		$result = crearPerfil($nombre, $descripcion);

		if ($result) {
				// Respuesta de éxito
				echo json_encode(['success' => true, 'message' => 'Perfil creado con éxito']);
		} else {
				// Respuesta de error
				echo json_encode(['success' => false, 'message' => 'Error al crear el perfil']);
		}

		exit;
	}

}



/* 	} elseif (isset($_GET['crear'])) {
		
		$nombre = $_POST['nombre'];
		$descripcion = $_POST['descripcion'];

		if (empty($nombre) && empty($descripcion)) {
			$_SESSION['message'] = "Por favor ingrese todos los datos";
		} elseif (empty($nombre)) {
			$_SESSION['message'] = "Por favor ingrese el nombre";
		} elseif (empty($descripcion)) {
			$_SESSION['message'] = "Por favor ingrese la descripción";
		} elseif ($nombre && $descripcion) {

			// Verificar si el perfil ya existe
			$perfil = perfilExists($nombre);
			if ($perfil) {
				$_SESSION['message'] =  "Ya hay un perfil registrado con ese nombre, por favor intente con otro.";
			} else {
				// Llamar a la función que crea el perfil
				crearPerfil($nombre, $descripcion);
				registrarEvento("Perfiles Controller: Perfil creado correctamente => " . $nombre, "INFO");

				// Redirigimos para evitar reenvío del formulario
				header('Location: index.php?route=/configuracion/ABMs/perfiles');
				exit;
			}
		}
	} */


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



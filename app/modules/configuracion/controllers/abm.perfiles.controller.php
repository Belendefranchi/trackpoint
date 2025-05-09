<?php
define('VISTA_INTERNA', true);
require_once __DIR__ . '/configuracion.controller.php';
require_once __DIR__ . '/../models/abm.perfiles.model.php';
require_once __DIR__ . '/../../../../config/helpers.php';

// Lógica de actualizar, eliminar y crear perfiles
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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
				session_start();
				$_SESSION['message'] =  "Ya hay un perfil registrado con ese nombre, por favor intente con otro.";
				$_SESSION['abrir_modal'] = 'modalCrearPerfil';
				header('Location: index.php?route=/configuracion/ABMs/perfiles');
				exit;
			} else {
				// Llamar a la función que crea el perfil
				crearPerfil($nombre, $descripcion);
				registrarEvento("Perfiles Controller: Perfil creado correctamente => " . $nombre, "INFO");

				// Redirigimos para evitar reenvío del formulario
				header('Location: index.php?route=/configuracion/ABMs/perfiles');
				exit;
			}
		}
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



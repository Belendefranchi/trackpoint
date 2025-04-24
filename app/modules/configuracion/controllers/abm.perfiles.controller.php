<?php
require_once __DIR__ . '/configuracion.controller.php';
require_once __DIR__ . '/../models/abm.perfiles.model.php';
require_once __DIR__ . '/../../../../config/helpers.php';

// Lógica de actualizar, eliminar y crear perfiles
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// ####### EDITAR #######
	if (isset($_POST['editar'])) {
		$id = $_POST['id'];
		$nombre = $_POST['nombre'];
		$descripcion = $_POST['descripcion'];

		if (empty($nombre) && empty($descripcion)) {
			$message = "Por favor ingrese todos los datos";
		} elseif (empty($nombre)) {
			$message = "Por favor ingrese el nombre";
		} elseif (empty($descripcion)) {
			$message = "Por favor ingrese la descripción";
		} elseif ($nombre && $descripcion) {

			// Verificar si el perfil ya existe
			$perfil = perfilExists($nombre);
			if ($perfil && $perfil['nombre'] != $nombre) {
				$message = "Ya hay un perfil registrado con ese nombre, por favor intente con otro.";
			} else {
				// Llamar a la función que actualiza los datos
				editarPerfil($id, $nombre, $descripcion);

				// Redirigimos para evitar reenvío del formulario
				header('Location: index.php?route=/configuracion/ABMs/perfiles');
				exit;
			}
		}

	// ####### ELIMINAR #######

	} elseif (isset($_POST['eliminar'])) {
		$id = $_POST['id'];

		// Llamar a la función que elimina el perfil
		eliminarPerfil($id);

		// Redirigimos para evitar reenvío del formulario
		header('Location: index.php?route=/configuracion/ABMs/perfiles');
		exit;

	// ####### CREAR #######

	} elseif (isset($_POST['crear'])) {
		$nombre = $_POST['nombre'];
		$descripcion = $_POST['descripcion'];

		if (empty($nombre) && empty($descripcion)) {
			$message = "Por favor ingrese todos los datos";
		} elseif (empty($nombre)) {
			$message = "Por favor ingrese el nombre";
		} elseif (empty($descripcion)) {
			$message = "Por favor ingrese la descripción";
		} elseif ($nombre && $descripcion) {

			// Verificar si el perfil ya existe
			$perfil = perfilExists($nombre);
			if ($perfil) {
				$message =  "Ya hay un perfil registrado con ese nombre, por favor intente con otro.";
			} else {
				// Llamar a la función que crea el perfil
				crearPerfil($nombre, $descripcion);
				registrarEvento("Perfil creado correctamente", "INFO");

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

if (isset($message)) {
  $datosVista['message'] = $message;
}

if (isset($successMessage)) {
  $datosVista['successMessage'] = $successMessage;
}

cargarVistaConfiguracion('abm.perfiles.view.php', $datosVista);



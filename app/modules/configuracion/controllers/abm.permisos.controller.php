<?php
define('VISTA_INTERNA', true);
require_once __DIR__ . '/configuracion.controller.php';
require_once __DIR__ . '/../models/abm.permisos.model.php';
require_once __DIR__ . '/../../../../config/helpers.php';

// Lógica de actualizar, eliminar y crear perfiles
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// ####### EDITAR #######
	if (isset($_POST['editar'])) {
		$id = $_POST['id'];
		$nombre = $_POST['nombre'];
		$descripcion = $_POST['descripcion'];
		$pantalla = $_POST['pantalla'];

		if (empty($nombre) && empty($descripcion) && empty($pantalla)) {
			$message = "Por favor ingrese todos los datos";
		} elseif (empty($nombre)) {
			$message = "Por favor ingrese el nombre";
		} elseif (empty($descripcion)) {
			$message = "Por favor ingrese la descripción";
		} elseif (empty($pantalla)) {
			$message = "Por favor ingrese la pantalla";
		} elseif ($nombre && $descripcion && $pantalla) {

			// Verificar si el permiso ya existe
			$permiso = permisoExists($nombre);
			if ($permiso && $permiso['nombre'] != $nombre) {
				$message = "Ya hay un permiso registrado con ese nombre, por favor intente con otro.";
			} else {
				// Llamar a la función que actualiza los datos
				editarPermiso($id, $nombre, $descripcion, $pantalla);

				// Redirigimos para evitar reenvío del formulario
				header('Location: index.php?route=/configuracion/ABMs/permisos');
				exit;
			}
		}

	// ####### ELIMINAR #######

	} elseif (isset($_POST['eliminar'])) {
		$id = $_POST['id'];

		// Llamar a la función que elimina el perfil
		eliminarPermiso($id);

		// Redirigimos para evitar reenvío del formulario
		header('Location: index.php?route=/configuracion/ABMs/permisos');
		exit;

	// ####### CREAR #######

	} elseif (isset($_POST['crear'])) {
		$nombre = $_POST['nombre'];
		$descripcion = $_POST['descripcion'];
		$pantalla = $_POST['pantalla'];

		if (empty($nombre) && empty($descripcion) && empty($pantalla)) {
			$message = "Por favor ingrese todos los datos";
		} elseif (empty($nombre)) {
			$message = "Por favor ingrese el nombre";
		} elseif (empty($descripcion)) {
			$message = "Por favor ingrese la descripción";
		} elseif (empty($pantalla)) {
			$message = "Por favor ingrese la pantalla";
		} elseif ($nombre && $descripcion) {

			// Verificar si el permiso ya existe
			$permiso = permisoExists($nombre);
			if ($permiso) {
				$message =  "Ya hay un permiso registrado con ese nombre, por favor intente con otro.";
			} else {
				// Llamar a la función que crea el perfil
				crearPermiso($nombre, $descripcion, $pantalla);

				// Redirigimos para evitar reenvío del formulario
				header('Location: index.php?route=/configuracion/ABMs/permisos');
				exit;
			}
		}
	}
}

// Obtener datos para pasar a la vista
$permisos = obtenerPermisos();

// Llamar a la función común que carga todo en el layout
$datosVista = [
  'permisos' => $permisos
];

if (isset($message)) {
  $datosVista['message'] = $message;
}

if (isset($successMessage)) {
  $datosVista['successMessage'] = $successMessage;
}

cargarVistaConfiguracion('abm.permisos.view.php', $datosVista);



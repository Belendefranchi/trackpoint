<?php
define('VISTA_INTERNA', true);
require_once __DIR__ . '/configuracion.controller.php';
require_once __DIR__ . '/../models/abm.operadores.model.php';
require_once __DIR__ . '/../../../../config/helpers.php';

// Lógica de actualizar, eliminar y crear operadores
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// ####### EDITAR #######
	if (isset($_POST['editar'])) {
		$id = $_POST['id'];
		$nombre_completo = $_POST['nombre_completo'];
		$email = $_POST['email'];
		$rol = $_POST['rol'];
		$activo = ($_POST['activo']);

		if (empty($nombre_completo) && empty($email) && empty($activo)) {
			$message = "Por favor ingrese todos los datos";
		} elseif (empty($nombre_completo)) {
			$message = "Por favor ingrese el nombre completo";
		} elseif (empty($email)) {
			$message = "Por favor ingrese el email";
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$message = "El email no es válido";
		} elseif ($nombre_completo && $email && $rol) {
			// Verificar si el rol es válido
			if (!in_array($rol, ['administrador', 'operador'])) {
				$message = "Rol no válido";
			} else {
				// Verificar si el usuario ya existe
				$user = userExists($email);
				if ($user && $user['id'] != $id) {
					$message = "Ya hay un usuario registrado con ese email, por favor intente con otro.";
				} else {
					// Llamar a la función que actualiza los datos
					editarOperador($id, $nombre_completo, $email, $rol, $activo);

					// Redirigimos para evitar reenvío del formulario
					header('Location: index.php?route=/configuracion/ABMs/operadores');
					exit;
				}
			}
		}

	// ####### ELIMINAR #######

	} elseif (isset($_POST['eliminar'])) {
		$id = $_POST['id'];

		// Llamar a la función que elimina el operador
		eliminarOperador($id);

		// Redirigimos para evitar reenvío del formulario
		header('Location: index.php?route=/configuracion/ABMs/operadores');
		exit;

	// ####### CREAR #######

	} elseif (isset($_POST['crear'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$nombre_completo = $_POST['nombre_completo'];
		$email = $_POST['email'];
		$rol = $_POST['rol'];

		if (empty($nombre_completo) && empty($email) && empty($username) && empty($password)) {
				$message = "Por favor ingrese todos los datos";
		} elseif (empty($nombre_completo)) {
				$message = "Por favor ingrese el nombre completo";
		} elseif (empty($email)) {
				$message = "Por favor ingrese el email";
		} elseif (empty($username)) {
				$message = "Por favor ingrese el nombre de usuario";
		} elseif (empty($password)) {
				$message = "Por favor ingrese la contraseña";
		} elseif (empty($rol)) {
				$message = "Por favor seleccione un rol";
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$message = "El email no es válido";
		} elseif (strlen($password) < 6) {
				$message = "La contraseña debe tener al menos 6 caracteres";
		} elseif ($nombre_completo && $email && $username && $password && $rol) {
				// Verificar si el rol es válido
			if (!in_array($rol, ['administrador', 'operador'])) {
				$message = "Rol no válido";
			} else {
				// Verificar si el usuario ya existe
				$user = userExists($email);
				if ($user) {
					$message =  "Ya hay un usuario registrado con ese email, por favor intente con otro.";
				} else {
					// Hashear la contraseña
					$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
					
					// Llamar a la función que crea el operador
					crearOperador($username, $hashedPassword, $nombre_completo, $email, $rol);
					registrarEvento("Operador creado correctamente", "INFO");

					// Redirigimos para evitar reenvío del formulario
					header('Location: index.php?route=/configuracion/ABMs/operadores');
					exit;
				}
			}
		}
	} 
}

// Obtener datos para pasar a la vista
$operadores = obtenerOperadores();

// Llamar a la función común que carga todo en el layout
$datosVista = [
  'operadores' => $operadores
];

if (isset($message)) {
  $datosVista['message'] = $message;
}

if (isset($successMessage)) {
  $datosVista['successMessage'] = $successMessage;
}

cargarVistaConfiguracion('abm.operadores.view.php', $datosVista);



<?php
define('VISTA_INTERNA', true);

require_once __DIR__ . '/../../module.controller.php';
require_once __DIR__ . '/../models/abm.operadores.model.php';
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';

// Lógica ajax de actualizar, eliminar y crear Operadores
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// ####### CREAR #######
	if (isset($_GET['crear'])) {
		
		header('Content-Type: application/json');
		
		$username = $_POST['username'];
		$nombre_completo = $_POST['nombre_completo'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$rol = $_POST['rol'];

    	// Validación básica
    	if (empty($username) || empty($nombre_completo) || empty($password) || empty($email) || empty($rol)) {
			echo json_encode(['success' => false, 'message' => 'Error: Por favor ingrese todos los datos']);
			exit;
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			echo json_encode(['success' => false, 'message' => "Error: El email no es válido"]);
			exit;
		} elseif (strlen($password) < 6) {
			echo json_encode(['success' => false, 'message' => "Error: La contraseña debe tener al menos 6 caracteres"]);
			exit;
		} elseif (!in_array($rol, ['administrador', 'operador'])) {
			echo json_encode(['success' => false, 'message' => "Error: Rol no válido"]);
			exit;
		}

		// Verificar si el usuario ya existe
		$user = userExists($username, $email);
		if ($user) {
			echo json_encode(['success' => false, 'message' => 'Error: Ya existe un operador con ese usuario y/o email, intente con otro.']);
			exit;
		}
		try {
			// Hashear la contraseña
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			
			// Crear el operador en la base de datos
			$result = crearOperador($username, $hashedPassword, $nombre_completo, $email, $rol);

			if ($result) {
				registrarEvento("Operador Controller: Operador creado correctamente => " . $username, "INFO");
				echo json_encode(['success' => true]);
				exit;
			} else {
				// Respuesta de error
				registrarEvento("Operador Controller: Error al crear el operador => " . $username . " " . $e->getMessage(), "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo crear el operador']);
				exit;
			}
			echo json_encode(['success' => true]);
		} catch (Exception $e) {
			registrarEvento("Operador Controller: Error al procesar los datos => " . $username . " " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}

	// ####### EDITAR #######
	if (isset($_GET['editar'])) {

    	header('Content-Type: application/json');

		$operador_id = $_POST['operador_id'];
		$username = $_POST['username'];
		$nombre_completo = $_POST['nombre_completo'];
		$email = $_POST['email'];
		$rol = $_POST['rol'];
		$activo = $_POST['activo'];

		// Validación básica
		if (empty($username) || empty($nombre_completo) || empty($email)) {
			echo json_encode(['success' => false, 'message' => 'Error: Por favor ingrese todos los datos']);
			exit;
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			echo json_encode(['success' => false, 'message' => "Error: El email no es válido"]);
			exit;
		}

		// Verificar si el usuario ya existe
		$user = userExists($username, $email);
		if ($user && $user['operador_id'] != $operador_id) {
			echo json_encode(['success' => false, 'message' => 'Error: Ya existe un operador con ese usuario y/o email, intente con otro.']);
			exit;
		}
		try {
			// Llamar a la función que actualiza los datos
			$result = editarOperador($operador_id, $nombre_completo, $email, $rol, $activo);

			if ($result) {
				// Respuesta de éxito
				registrarEvento("Operadores Controller: Operador modificado correctamente => " . $username, "INFO");
				echo json_encode(['success' => true]);
				exit;
			} else {
				// Respuesta de error
				registrarEvento("Operadores Controller: Error al modificar el operador => " . $username, "ERROR");
				echo json_encode(['success' => false, 'message' => 'Error: No se pudo modificar el operador']);
				exit;
			}
		} catch (Exception $e) {
			registrarEvento("Operadores Controller: Error al procesar los datos => " . $username . " " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Controller: Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}

	// ####### ELIMINAR #######
	if (isset($_GET['eliminar'])) {

		header('Content-Type: application/json');

		$operador_id = $_POST['operador_id'];
		$username = $_POST['username'];

		try {
			// Llamar a la función que actualiza los datos
			$result = eliminarOperador($operador_id, $username);

			if ($result) {
				// Respuesta de éxito
				registrarEvento("Operadores Controller: Operador eliminado correctamente => " . $username, "INFO");
				echo json_encode(['success' => true]);
				exit;

			} else {
					// Respuesta de error
					registrarEvento("Operadores Controller: Error al eliminar el operador => " . $username . " " . $e->getMessage(), "ERROR");
					echo json_encode(['success' => false, 'message' => 'Error: No se pudo eliminar el operador']);
					exit;
			}
		} catch (Exception $e) {
			registrarEvento("Operadores Controller: Error al procesar los datos => " . $username . " " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, 'message' => 'Controller: Error: ' . $e->getMessage()]);
			exit;
		}
		exit;
	}
}


// Obtener datos para pasar a la vista
$operadores = obtenerOperadores();

// Llamar a la función común que carga todo en el layout
$datosVista = [
  'operadores' => $operadores
];

cargarVista('/configuracion/views/abm.operadores.view.php', $datosVista);



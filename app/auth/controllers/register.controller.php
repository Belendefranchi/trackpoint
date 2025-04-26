<?php
require_once __DIR__ . '/../views/register.view.php';
require_once __DIR__ . '/../models/register.model.php';
require_once __DIR__ . '/../../../config/helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$nombre_completo = ($_POST['nombre_completo']);
	$email = ($_POST['email']);
	$username = ($_POST['username']);
	$password = $_POST['password'];
	$rol = ($_POST['rol']);
	
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
	} elseif (strlen($password) < 8) {
		$message = "La contraseña debe tener al menos 8 caracteres";
	} elseif ($nombre_completo && $email && $username && $password && $rol) {
		// Verificar si el rol es válido
		if (!in_array($rol, ['admin', 'operario', 'supervisor'])) {
			$message = "Rol no válido";
		} else {
			// Verificar si el usuario ya existe
			$user = userExists($email);
			if ($user) {
				$message = "Ya hay un usuario registrado con ese email, por favor intente con otro.";
			} else {
				// Hashear la contraseña
				$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
				
				// Llamar a la función para crear el usuario
				crearUsuario($nombre_completo, $email, $username, $hashedPassword, $rol);
				
				$message =  "Usuario creado correctamente, por favor inicie sesión.";
				registrarEvento("Register Controller: Usuario creado correctamente", "INFO");
			}
		}
	}
}

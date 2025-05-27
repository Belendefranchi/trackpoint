<?php
require_once __DIR__ . '/../../../../core/config/db.php';
require_once __DIR__ . '/../../../../core/config/helpers.php';

function obtenerOperadores() {
	try {
		$conn = getConnection();
		$stmt = $conn->query("SELECT * FROM configuracion_abm_operadores");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Operadores Model: Error al obtener los operadores, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function userExists($username, $email) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("SELECT operador_id, username, email FROM configuracion_abm_operadores WHERE email = :email OR username = :username");
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':email', $email);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
		return $user ?: false;
	} catch (PDOException $e) {
		registrarEvento("Operadores Model: Error al verificar si el operador existe, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function crearOperador($username, $hashedPassword, $nombre_completo, $email, $rol) {
	session_start();
	$creado_por = $_SESSION['username'];
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("INSERT INTO configuracion_abm_operadores (nombre_completo, email, username, password, rol, creado_por) VALUES (:nombre_completo, :email, :username, :password, :rol, :creado_por)");
		$stmt->bindParam(':nombre_completo', $nombre_completo);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':password', $hashedPassword);
		$stmt->bindParam(':rol', $rol);
		$stmt->bindParam(':creado_por', $creado_por);
		$result = $stmt->execute();
		if ($result) {
			registrarEvento("Operadores Model: operador creado correctamente.", "INFO");
		}
		return $result;
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Operadores Model: Error al crear el operador, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function eliminarOperador($operador_id) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("DELETE FROM configuracion_abm_operadores WHERE operador_id = :operador_id");
		$stmt->bindParam(':operador_id', $operador_id);
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Operadores Model: Error al eliminar el operador, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function editarOperador($operador_id, $nombre_completo, $email, $rol, $activo) {
	session_start();
	$editado_por = $_SESSION['username'];
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE configuracion_abm_operadores SET nombre_completo = :nombre_completo, email = :email, rol = :rol, editado_por = :editado_por, activo = :activo WHERE operador_id = :operador_id");
		$stmt->bindParam(':operador_id', $operador_id);
		$stmt->bindParam(':nombre_completo', $nombre_completo);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':rol', $rol);
		$stmt->bindParam(':editado_por', $editado_por);
		$stmt->bindParam(':activo', $activo);
		$stmt->execute();
		$result = $stmt->execute();

		if ($result) {
			registrarEvento("Operadores Model: operador editado correctamente.", "INFO");
		}
		return $result;
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Operadores Model: Error al editar el operador, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function restablecerPassword($operador_id, $newHashedPassword) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE configuracion_abm_operadores SET password = :password WHERE operador_id = :operador_id");
		$stmt->bindParam(':operador_id', $operador_id);
		$stmt->bindParam(':password', $newHashedPassword);
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Operadores Model: Error al restablecer la contraseña, " . $e->getMessage(), "ERROR");
		return false;
	}
}
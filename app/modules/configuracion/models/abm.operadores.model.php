<?php
require_once __DIR__ . '/../../../../config/db.php';
require_once __DIR__ . '/../../../../config/helpers.php';

function obtenerOperadores() {
	try {
		$conn = getConnection();
		$stmt = $conn->query("SELECT * FROM configuracion_abm_operadores");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Error al obtener los usuarios: " . $e->getMessage(), "ERROR");
		return false;
	}
}

function userExists($email) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("SELECT id FROM configuracion_abm_operadores WHERE email = :email");
		$stmt->bindParam(':email', $email);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
		return $user ?: false;
	} catch (PDOException $e) {
		registrarEvento("Error al verificar si el usuario existe: " . $e->getMessage(), "ERROR");
		return false;
	}
}

function crearOperador($username, $hashedPassword, $nombre_completo, $email, $rol) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("INSERT INTO configuracion_abm_operadores (nombre_completo, email, username, password, rol) VALUES (:nombre_completo, :email, :username, :password, :rol)");
		$stmt->bindParam(':nombre_completo', $nombre_completo);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':password', $hashedPassword);
		$stmt->bindParam(':rol', $rol);
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Error al crear el usuario: " . $e->getMessage(), "ERROR");
		return false;
	}
}

function eliminarOperador($id) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("DELETE FROM configuracion_abm_operadores WHERE id = :id");
		$stmt->bindParam(':id', $id);
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Error al eliminar el usuario: " . $e->getMessage(), "ERROR");
		return false;
	}
}

function editarOperador($id, $nombre_completo, $email, $rol, $activo) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE configuracion_abm_operadores SET nombre_completo = :nombre_completo, email = :email, rol = :rol, activo = :activo WHERE id = :id");
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':nombre_completo', $nombre_completo);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':rol', $rol);
		$stmt->bindParam(':activo', $activo);
		$stmt->execute();
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Error al actualizar el usuario: " . $e->getMessage(), "ERROR");
		return false;
	}
}

function restablecerPassword($id, $newHashedPassword) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE configuracion_abm_operadores SET password = :password WHERE id = :id");
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':password', $newHashedPassword);
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Error al restablecer la contraseña: " . $e->getMessage(), "ERROR");
		return false;
	}
}
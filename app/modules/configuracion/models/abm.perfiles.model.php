<?php
require_once __DIR__ . '/../../../../config/db.php';
require_once __DIR__ . '/../../../../config/helpers.php';

function obtenerPerfiles() {
	try {
		$conn = getConnection();
		$stmt = $conn->query("SELECT * FROM configuracion_abm_perfiles");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Perfiles Model: Error al obtener los perfiles, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function perfilExists($nombre) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("SELECT nombre FROM configuracion_abm_perfiles WHERE nombre = :nombre");
		$stmt->bindParam(':nombre', $nombre);
		$stmt->execute();
		$perfil = $stmt->fetch(PDO::FETCH_ASSOC);
		return $perfil ?: false;
	} catch (PDOException $e) {
		registrarEvento("Perfiles Model: Error al verificar si el perfil existe, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function crearPerfil($nombre, $descripcion) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("INSERT INTO configuracion_abm_perfiles (nombre, descripcion) VALUES (:nombre, :descripcion)");
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':descripcion', $descripcion);
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Perfiles Model: Error al crear el perfil, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function eliminarPerfil($id) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("DELETE FROM configuracion_abm_perfiles WHERE id = :id");
		$stmt->bindParam(':id', $id);
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Perfiles Model: Error al eliminar el perfil, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function editarPerfil($id, $nombre, $descripcion, $activo) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE configuracion_abm_perfiles SET nombre = :nombre, descripcion = :descripcion, activo = :activo WHERE id = :id");
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->bindParam(':activo', $activo);
		$stmt->execute();
		registrarEvento("Perfiles Model: perfil editado corectamente, " . htmlspecialchars($_SESSION['nombre_completo']), "INFO");
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Perfiles Model: Error al editar el perfil, " . $e->getMessage() . htmlspecialchars($_SESSION['nombre_completo']), "ERROR");
		return false;
	}
}
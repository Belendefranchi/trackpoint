<?php
require_once __DIR__ . '/../../../../config/db.php';
require_once __DIR__ . '/../../../../config/helpers.php';

function obtenerPerfiles() {
	try {
		$conn = getConnection();
		$stmt = $conn->query("SELECT * FROM perfiles");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Error al obtener los usuarios: " . $e->getMessage(), "ERROR");
		return false;
	}
}

function perfilExists($nombre) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("SELECT nombre FROM perfiles WHERE nombre = :nombre");
		$stmt->bindParam(':nombre', $nombre);
		$stmt->execute();
		$perfil = $stmt->fetch(PDO::FETCH_ASSOC);
		return $perfil ?: false;
	} catch (PDOException $e) {
		registrarEvento("Error al verificar si el perfil existe: " . $e->getMessage(), "ERROR");
		return false;
	}
}

function crearPerfil($nombre, $descripcion) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("INSERT INTO perfiles (nombre, descripcion) VALUES (:nombre, :descripcion)");
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':descripcion', $descripcion);
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Error al crear el perfil: " . $e->getMessage(), "ERROR");
		return false;
	}
}

function eliminarPerfil($id) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("DELETE FROM perfiles WHERE id = :id");
		$stmt->bindParam(':id', $id);
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Error al eliminar el perfil: " . $e->getMessage(), "ERROR");
		return false;
	}
}

function editarPerfil($id, $nombre, $descripcion) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE perfiles SET nombre = :nombre, descripcion = :descripcion WHERE id = :id");
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->execute();
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Error al actualizar el perfil: " . $e->getMessage(), "ERROR");
		return false;
	}
}